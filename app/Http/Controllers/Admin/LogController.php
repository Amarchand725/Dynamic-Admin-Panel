<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Log;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Traits\DataTableTrait;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;

class LogController extends Controller
{
    use DataTableTrait;

    protected $model;
    protected $routePrefix;
    protected $pathInitialize;
    protected $singularLabel;
    protected $pluralLabel;
    protected array $permissions;

    public function __construct(Log $model)
    {
        parent::__construct();
        
        $this->model = $model; 
        $this->routePrefix = Str::before(Route::currentRouteName(), '.');
        $this->pathInitialize = 'admin.'.$this->routePrefix;
        $this->singularLabel = Str::ucfirst(Str::singular($this->routePrefix));
        $this->pluralLabel = 'All '.Str::ucfirst($this->routePrefix);

        // Initialize the permissions array
        $this->permissions = [
            'index'  => $this->routePrefix . '-list',
            'create' => $this->routePrefix . '-create',
            'edit'   => $this->routePrefix . '-edit',
            'show'   => $this->routePrefix . '-show',
            'destroy' => $this->routePrefix . '-delete',
        ];
    }

    protected function getFieldsAndColumns()
    {
        // Dynamic fields fetched from the database
        $dynamicFields = $this->generateDynamicFieldArray($this->model);

        // Common fields that should always be included
        $commonFields = $this->getCommonFields($this->model);
    
        // Merging common fields with dynamic fields
        $mergedFields = array_merge($dynamicFields, $commonFields);
        
        return $mergedFields;
    }

    public function generateDynamicFieldArray($model) {
        $table = $model->getTable();
        // Get column names and types from the database schema
        // $columns = Schema::getColumnListing($table);
        $columns = DB::connection()->getDoctrineSchemaManager()->listTableColumns($table);
        
        $fieldArray = [];
    
        foreach ($columns as $columnName => $column) {
            // Skip common fields
            if (in_array($columnName, ['id', 'created_at', 'deleted_at', 'updated_at'])) {
                continue;
            }
    
            // Get the type of each column (e.g., string, integer, etc.)
            // $type = Schema::getColumnType($table, $column);
            $type = $column->getType()->getName();
            
            // Build the dynamic field configuration
            $fieldArray[$columnName] = [
                'type' => $type == 'text' ? 'text' : ($type == 'boolean' ? 'select' : 'text'), // Default 'text' or 'select' for boolean
                'label' => ucfirst(str_replace('_', ' ', $columnName)), // Use column name as label (capitalize words and replace underscores)
                'placeholder' => "Enter $columnName", // Placeholder text
                'required' => in_array($columnName, ['title', 'status']), // Example: Mark some fields as required
                'value' => fn($model) => $model->{$columnName} ?? '', // Get the value from the model
                'index' => fn($model) => $model->{$columnName} ?? '-', // Index view value
                'index_visible' => true, // You can dynamically set visibility rules
                'create_visible' => true,
                'edit_visible' => true,
                'show_visible' => true,
            ];

            // Specifically handle the 'description' field
            if ($columnName == 'fields') {
                $fieldArray[$columnName]['index_visible'] = false; // Hide description in index view
            }
        }
    
        return $fieldArray;
    }
    public function getCommonFields($model) {
        // Common fields data (status, created_at, created_by, action)
        return [
            'created_at' => [
                'type' => 'datetime',
                'label' => 'Created At',
                'required' => false,
                'value' => fn($model) => Carbon::parse($model->created_at)->format('d, M Y | H:i A') ?? '',
                'index' => fn($model) => Carbon::parse($model->created_at)->format('d, M Y'),
                'index_visible' => true,
                'create_visible' => false,  // Hide in create form
                'edit_visible' => false,    // Hide in edit form
                'show_visible' => true,
            ],
            'action' => [
                'index' => fn($model) => view($this->pathInitialize . '.action', [
                    'model' => $model,
                    'singularLabel' => $this->singularLabel,
                    'routeInitialize' => $this->routePrefix
                ])->render(),
                'index_visible' => true,
                'create_visible' => false,  // Hide in create form
                'edit_visible' => false,    // Hide in edit form
                'show_visible' => false,
            ]
        ];
    }

    public function index(Request $request)
    {
        $title = $this->pluralLabel;
        $singularLabel = $this->singularLabel;
        $routeInitialize = $this->routePrefix;
        $bladePath = $this->pathInitialize;

        $models = $this->model
                    ->latest()
                    ->orderBy('id', 'desc')
                    ->select(['id', 'user_id', 'action', 'model', 'ip_address', 'description', 'created_at']);

        // Define the columns dynamically
        $columns = [
            'user' => fn($model) => $model->hasActionUser ? $model->hasActionUser->name . ' (' . $model->hasActionUser->role . ')' : '-',
            'model' => fn($model) => $model->model,
            'ip_address' => fn($model) => $model->ip_address,
            'description' => fn($model) => $model->description,
            'action_type' => fn($model) => $model->action,
            'created_at' => fn($model) => \Carbon\Carbon::parse($model->created_at)->format('d M, Y | h:i A'),

            'action' => function ($model) use ($bladePath, $singularLabel, $routeInitialize) {
                return view($bladePath.'.action', [
                    'model' => $model,
                    'singularLabel' => $singularLabel,
                    'routeInitialize' => $routeInitialize,
                ])->render();
            }
        ];
        
        if ($request->ajax() && $request->loaddata == "yes") {
            return $this->getDataTable($request, $models, $columns);
        }

        $columnsConfig = collect($columns)->map(function ($callback, $key) {
            return [
                'data' => $key,
                'name' => $key,
                'orderable' => !in_array($key, ['action']), // Set orderable=false for 'action'
                'searchable' => !in_array($key, ['action']) // Set searchable=false for 'action'
            ];
        })->values()->toArray();
        
        return view($bladePath.'.index', get_defined_vars());
    }
    
    public function show(string $id)
    {
        $bladePath = $this->pathInitialize;
        $title = 'Log Details';
        $model = Log::where('id', $id)->first();
        $modelClass = $model->model;

        // Get the class name without namespace
        $className = class_basename($modelClass);
        if(!empty($model)){
            $modelData = $model->model::where('id', $model->model_id)->withTrashed()->first();
            // Get all attributes of the model
            $attributes = $modelData->getAttributes();

            // Filter out keys ending with '_id'
            $modelData = collect($attributes)->filter(function ($value, $key) {
                return !\Illuminate\Support\Str::endsWith($key, '_id'); // Exclude columns ending with '_id'
            });
            return view($bladePath.'.show', get_defined_vars());
        }else{
            return abort(405);
        }
    }
}
