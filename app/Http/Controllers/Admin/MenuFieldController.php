<?php

namespace App\Http\Controllers\Admin;

use Exception;
use Carbon\Carbon;
use App\Models\Menu;
use App\Models\MenuField;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;

class MenuFieldController extends Controller
{
    protected $model;
    protected $routePrefix;
    protected $pathInitialize;
    protected $singularLabel;
    protected $pluralLabel;
    protected array $permissions;

    public function __construct(MenuField $model)
    {
        // parent::__construct();
        
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

    public function getFieldsAndColumns()
    {
        $modelName = class_basename($this->model);
        $menuName = Str::kebab(Str::singular($modelName));
        $menu = Menu::where('menu', $menuName)->first();
        $menuFields = MenuField::where('menu_id', $menu->id)->get();

        $fieldArray = [];

        foreach ($menuFields as $field) {
            $extraAttributes = json_decode($field->extra ?? '{}', true);

            // Defaults
            $fieldData = [
                'type' => $field->input_type,
                'label' => $field->label ?? ucfirst(str_replace('_', ' ', $field->name)),
                'placeholder' => $field->placeholder ?? "Enter {$field->name}",
                'required' => (bool) $field->required,
                'value' => fn($model) => $model->{$field->name} ?? '',
                'index' => fn($model) => $model->{$field->name} ?? '-',
                'index_visible' => (bool) $field->index_visible,
                'create_visible' => (bool) $field->create_visible,
                'edit_visible' => (bool) $field->edit_visible,
                'show_visible' => (bool) $field->show_visible,
                'extra' => $extraAttributes,
            ];

            // Dynamic custom logic for specific fields
            switch ($field->name) {
                case 'status':
                    $fieldData['options'] = [1 => 'Active', 0 => 'De-Active'];
                    $fieldData['value'] = fn($model) => $model->status ?? 0;
                    $fieldData['index'] = fn($model) =>
                        $model->status == 1
                            ? '<span class="badge bg-label-success me-1">Active</span>'
                            : '<span class="badge bg-label-danger me-1">De-Active</span>';
                    break;

                case 'created_at':
                    $fieldData['value'] = fn($model) => $model->created_at
                        ? Carbon::parse($model->created_at)->format('d, M Y | H:i A') : '';
                    $fieldData['index'] = fn($model) => $model->created_at
                        ? Carbon::parse($model->created_at)->format('d, M Y | H:i A') : '';
                    break;

                case 'created_by':
                    $fieldData['value'] = fn($model) => optional($model->createdBy)->name ?? '-';
                    $fieldData['index'] = fn($model) => optional($model->createdBy)->name ?? '-';
                    break;

                case 'action':
                    $fieldData['index'] = fn($model) => view($this->pathInitialize . '.action', [
                        'model' => $model,
                        'singularLabel' => $this->singularLabel,
                        'routeInitialize' => $this->routePrefix
                    ])->render();
                    break;

                // Add more dynamic overrides if needed
            }

            $fieldArray[$field->name] = $fieldData;
        }

        return $fieldArray;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $bladePath = $this->pathInitialize;
        $title = $this->singularLabel;
        $menu = Menu::where('id', $id)->first();
        $fields = $this->model->where('menu_id', $menu->id)->get();
        
        return view($bladePath.'.edit_content', get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, $modelId)
    {
        $mainMenu = Menu::where('id', $modelId)->first();
        $singularLabel = $this->singularLabel;
        $generatedMigration = null;

        // Reorder fields
        if (isset($request->field_order) && !empty($request->field_order)) {
            $fieldOrder = json_decode($request->field_order, true);
            $orderedFields = [];

            if (is_array($fieldOrder)) {
                foreach ($fieldOrder as $fieldName) {
                    if (isset($request->fields[$fieldName])) {
                        $orderedFields[$fieldName] = $request->fields[$fieldName];
                    }
                }
            }

            $request->merge(['fields' => $orderedFields]);
        }

        // Step 1: Detect new columns
        $tableName = Str::plural(Str::snake($mainMenu->menu));
        $newColumns = [];

        foreach ($request->fields as $field => $fieldObj) {
            $columnName = $fieldObj['name'] ?? $field;

            if (!Schema::hasColumn($tableName, $columnName) && $columnName !== 'action' && $columnName !== 'role') {
                $newColumns[$columnName] = $fieldObj['type'] ?? 'string';
            }
        }

        // Step 2: Create one migration for all new columns
        if (!empty($newColumns)) {
            $columnPart = implode('_', array_keys($newColumns));
            $migrationName = 'add_' . $columnPart . '_to_' . $tableName . '_table';
            Artisan::call('make:migration', [
                'name' => $migrationName,
                '--table' => $tableName,
            ]);

            // Step 3: Locate and write migration content
            $timestampedFile = collect(File::files(database_path('migrations')))
                ->sortByDesc(fn($file) => $file->getCTime())
                ->firstWhere(fn($file) => str_contains($file->getFilename(), $migrationName));

            if ($timestampedFile) {
                $content = File::get($timestampedFile->getPathname());

                $schemaLines = '';
                foreach ($newColumns as $col => $type) {
                    $nullable = "->nullable()";
                    switch ($type) {
                        case 'text':
                            $schemaLines .= "\$table->text('$col')$nullable;\n                ";
                            break;
                        case 'integer':
                            $schemaLines .= "\$table->integer('$col')$nullable;\n                ";
                            break;
                        case 'boolean':
                            $schemaLines .= "\$table->boolean('$col')->default(false);\n                ";
                            break;
                        case 'date':
                            $schemaLines .= "\$table->date('$col')$nullable;\n                ";
                            break;
                        case 'datetime':
                            $schemaLines .= "\$table->dateTime('$col')$nullable;\n                ";
                            break;
                        case 'float':
                            $schemaLines .= "\$table->float('$col')$nullable;\n                ";
                            break;
                        default:
                            $schemaLines .= "\$table->string('$col')$nullable;\n                ";
                            break;
                    }
                }

                // Replace default stub
                $content = preg_replace(
                    '/Schema::table\(.*?function\s*\(Blueprint\s*\$table\)\s*\{\n(.*?)\n\s*\}\);/s',
                    "Schema::table('$tableName', function (Blueprint \$table) {\n            $schemaLines});",
                    $content
                );

                File::put($timestampedFile->getPathname(), $content);
                $generatedMigration = $timestampedFile->getFilename();

                if($generatedMigration){
                    Artisan::call('migrate');
                }
            }
        }

        // Step 4: Update model metadata
        DB::beginTransaction();
        try {
            $this->model->where('menu_id', $mainMenu->id)->delete();

            foreach ($request->fields as $field => $fieldObj) {
                $columnName = $fieldObj['name'] ?? $field;

                $extraValidation = !empty($fieldObj['extra'])
                    ? $fieldObj['extra']
                    : json_encode(($fieldObj['type'] === 'string') ? ['validation' => 'max:255'] : []);

                $model = $this->model->create([
                    'menu_id' => $mainMenu->id,
                    'name' => $columnName,
                    'data_type' => $fieldObj['type'] ?? null,
                    'input_type' => $fieldObj['input_type'] ?? null,
                    'label' => $fieldObj['label'] ?? null,
                    'placeholder' => $fieldObj['placeholder'] ?? null,
                    'required' => $fieldObj['required'] ?? 0,
                    'index_visible' => $fieldObj['index_visible'] ?? 0,
                    'create_visible' => $fieldObj['create_visible'] ?? 0,
                    'edit_visible' => $fieldObj['edit_visible'] ?? 0,
                    'show_visible' => $fieldObj['show_visible'] ?? 0,
                    'extra' => $extraValidation,
                ]);
            }

            $msg = 'You have updated ' . $singularLabel . ' successfully.';
            if (isset($generatedMigration) && !empty($generatedMigration)) {
                // Now, call migrate after committing the transaction
                $msg .= ' Migration created: `' . $generatedMigration . '`. Migration executed.';
            }

            if(isset($model) && !empty($model)){
                DB::commit();
                return response()->json(['success' => true, 'message' =>$msg]);
            }else{
                DB::rollback();
                return response()->json(['success' => false, 'message' =>'You have not updated '.$singularLabel.' successfully.']);
            }
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}