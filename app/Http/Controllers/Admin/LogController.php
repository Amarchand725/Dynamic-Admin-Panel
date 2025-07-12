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

    public function index(Request $request)
    {
        $title = $this->pluralLabel;
        $singularLabel = $this->singularLabel;
        $routeInitialize = $this->routePrefix;
        $bladePath = $this->pathInitialize;

        // Get column definitions dynamically
        $getFields = getFields($this->model, getFieldsAndColumns($this->model, $this->pathInitialize, $this->singularLabel, $this->routePrefix), 'index');
        
        //select columns
        $selectedColumns = collect($getFields)
        ->mapWithKeys(function ($config, $key) {
            return [$key => $config['index']];
        })
        ->keys()
        ->filter(function ($key) {
            return $key !== 'action'; // Remove 'action'
        })
        ->values() // Reindex the array
        ->toArray();
    
        // Optionally prepend 'id'
        array_unshift($selectedColumns, 'id');
        
        $models = $this->model->latest()
            ->with('hasActionUser:id,name')
            ->select($selectedColumns);
        //select columns

        $columns = collect($getFields)->mapWithKeys(function ($config, $key) {
            return [$key => $config['index']];
        })->toArray();  // Convert Collection to Array
        
        if ($request->ajax() && $request->loaddata == "yes") {
            return $this->getDataTable($request, $models, $columns);
        }

        $columnsConfig = collect($getFields)->map(function ($config, $key) {
            return [
                'data' => $key,
                'name' => $key,
                'title' => $config['label'],
                'orderable' => !in_array($key, ['action']),
                'searchable' => !in_array($key, ['action'])
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
