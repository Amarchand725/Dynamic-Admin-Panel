<?php

namespace App\Http\Controllers\Admin;

use Exception;
use Carbon\Carbon;
use App\Models\Menu;
use App\Models\MenuField;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Traits\DataTableTrait;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;

class MenuController extends Controller
{
    use DataTableTrait;
    
    protected $model;
    protected $routePrefix;
    protected $pathInitialize;
    protected $singularLabel;
    protected $pluralLabel;
    protected array $permissions;

    public function __construct(Menu $model)
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
            ->with('hasMenuGroup:id,menu', 'createdBy:id,name')
            ->select($selectedColumns);
        //select columns

        if (isset($getFields['icon'])) {
            $getFields['icon']['index'] = fn($model) => '<i class="menu-icon tf-icons '.$model->icon .'"></i>';
        }
        // Check and handle relation
        if (isset($getFields['menu_group'])) {
            // Customize index to pull from relation
            $getFields['menu_group']['index'] = fn($model) => optional($model->hasMenuGroup)->menu ?? '-';
        }

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

    public function create(){
        $bladePath = $this->pathInitialize;

        $menuGroups = $this->model->where('menu_group', NULL)->where('status', 1)->get();
        $model = $this->model;
        $menuFields = getFields($this->model, getFieldsAndColumns($this->model, $this->pathInitialize, $this->singularLabel, $this->routePrefix), 'create');
        
        return (string) view($bladePath.'.create_content', get_defined_vars());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $singularLabel = $this->singularLabel;
        $fields = getFieldsAndColumns($this->model, $this->pathInitialize, $this->singularLabel, $this->routePrefix);

        // Step 1: Build dynamic validation rules
        $rules = buildValidationRules($fields, null, $request);

        // Step 2: Validate
        $validated = $request->validate($rules);

        DB::beginTransaction();

        try{
            $saved = new $this->model;
            
            // Step 3: Dynamically assign fields
            foreach ($fields as $field => $config) {
                if($field != 'created_at' && $field != 'action'){
                    if($field=='created_by'){
                        $saved->$field = auth()->id() ?? null;
                    }elseif($field=='fields'){
                        $types = $request->types;
                        $inputTypes = $request->input_types;

                        $saved->$field = mergeFieldInputTypes($validated[$field], $types, $inputTypes);
                    }else{
                        $saved->$field = $validated[$field] ?? null;
                    }
                }

                $saved->save();
            }
            
            if(isset($saved) && !empty($saved)){
                $types = $request->types;
                $input_types = $request->input_types;
                $menuColumns = $request->fields;

                $types = $request->types;          // ['string', 'string']
                $input_types = $request->input_types; // ['text', 'file']

                $dynamicFields = [];

                foreach ($menuColumns as $i => $field) {
                    if (!isset($types[$i], $input_types[$i])) continue;

                    $dynamicFields[] = [
                        'field' => $field,
                        'type' => $types[$i],
                        'input_type' => $input_types[$i],
                    ];
                }
                
                // Common fields that should always be included
                $commonFields = [
                    ['field' => 'status', 'type' => 'boolean', 'input_type' => 'select'],
                    ['field' => 'created_at', 'type' => 'datetime', 'input_type' => 'datetime'],
                    ['field' => 'created_by', 'type' => 'bigInteger', 'input_type' => 'text'],
                    ['field' => 'action', 'type' => 'string', 'input_type' => 'select'],
                ];
            
                // Merging common fields with dynamic fields
                $fields = array_merge($dynamicFields, $commonFields);
                
                $response = false;
                if($this->createMenuFields($saved, $fields)){
                    $response = true;
                }

                if($response){
                    $this->createFiles($saved);
                    
                    // Commit the transaction before running the migration
                    DB::commit();
                    
                    // Now, call migrate after committing the transaction
                    Artisan::call('migrate');
                    return response()->json(['success' => true, 'message' =>'You have added '.$singularLabel.' successfully.']);
                }else{
                    DB::rollback();
                    return response()->json(['success' => false, 'message' =>'Menu fields not inserted try again']);
                }
            }else{  
                DB::rollback();
                return response()->json(['success' => false, 'message' =>'You have not added '.$singularLabel.' successfully.']);
            }
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()]);
        }
    }
    public function createMenuFields($saved, $mergedFields){
        $field_menus = MenuField::where('menu_id', $saved->id)->get();
        if ($field_menus->isNotEmpty()) {
            $field_menus->each->delete();
        }

        foreach ($mergedFields as $fieldItem) {
            $field = $fieldItem['field'];
            $type = $fieldItem['type'];
            $input_type = $fieldItem['input_type'];
        
            $label = ucfirst(str_replace('_', ' ', $field));
            $placeholder = "Enter $label";
            $required = in_array($field, ['name', 'status']);
        
            $extra = [];
            if ($type === 'string') {
                $extra['validation'] = 'max:255';
            } elseif ($type === 'text') {
                $extra['validation'] = NULL;
            }

            $extraValidation = NULL;
            if (count($extra) > 0) {
                $extraValidation = json_encode($extra);
            }
        
            $inserted = MenuField::create([
                'menu_id' => $saved->id,
                'name' => $field,
                'data_type' => $type,
                'input_type' => $input_type,
                'label' => $label,
                'placeholder' => $placeholder,
                'required' => $required,
                'extra' => $extraValidation,
            ]);
        }        

        if(isset($inserted) && !empty($inserted)){
            return true;
        }else{
            return false;
        }
    }
    public function createFiles($menuModel){
        $menu = $menuModel->menu;
        $tableName = Str::snake(Str::plural($menu)); // categories
        $modelName = Str::studly($menu);             // Category
        $controllerName = $modelName . 'Controller'; // CategoryController
        
        $fields = json_decode($menuModel->fields, true);
        
        // Define the migration fields
        $migrationFields = [];
        // Add auto-incrementing ID
        $migrationFields[] = "\$table->id();"; // Equivalent to $table->bigIncrements('id');
        $migrationFields[] = "\$table->bigInteger('created_by')->nullable();";
        
        foreach ($fields as $field => $fieldItem) {
            $field = $fieldItem['field'];
            $type = $fieldItem['type'];
            $name = Str::snake($field);
            $migrationFields[] = "\$table->$type('$name')->nullable();";
        }        
        
        // Add default fields
        $migrationFields[] = "\$table->boolean('status')->default(true);";
        $migrationFields[] = "\$table->string('deleted_at')->nullable();";
        $migrationFields[] = "\$table->timestamps();";
        
        // ===== Generate Model =====
        $this->generateModel($modelName, $fields);

        // ===== Generate Migration =====
        $this->generateMigration($tableName, $migrationFields);
        
        // ===== Generate Controller =====
        $this->generateController($controllerName, $modelName);
        
        // ===== Generate Resource Route =====
        $this->generateResourceRoute($controllerName, $modelName);

        // ===== Copy views =====
        $baseViewsPath = resource_path('views/baseViews');
        $routeName = str_replace('-', '_', Str::kebab(Str::plural($modelName))); 
        $newViewPath = resource_path("views/admin/" . $routeName);
        
        if (!File::exists($newViewPath)) {
            File::makeDirectory($newViewPath, 0755, true);
        }
        
        File::copyDirectory($baseViewsPath, $newViewPath);        
    }

    public function generateModel($modelName, $fields){
        Artisan::call('make:model', [
            'name' => $modelName,
        ]);

        // Inject custom content into model
        $modelPath = app_path("Models/{$modelName}.php");
        if (file_exists($modelPath)) {
            $modelContent = file_get_contents($modelPath);

            // 1. Add 'use Illuminate\Database\Eloquent\SoftDeletes;' at the top if not present
            if (!Str::contains($modelContent, 'use Illuminate\Database\Eloquent\SoftDeletes;')) {
                $modelContent = preg_replace(
                    '/<\?php\s+namespace App\\\Models;/',
                    "<?php\n\nnamespace App\Models;\n\nuse Illuminate\\Database\\Eloquent\\SoftDeletes;",
                    $modelContent
                );
            }

            if (!Str::contains($modelContent, 'use App\Traits\HasModelLogObserver;')) {
                $modelContent = preg_replace(
                    '/namespace App\\\Models;(\n(?:use\s+[^\n]+;)*)/',
                    "namespace App\Models;$1\nuse App\\Traits\\HasModelLogObserver;",
                    $modelContent
                );
            }

            // 2. Remove 'use HasFactory;' at the bottom if it exists
            $modelContent = preg_replace('/\n\s*use HasFactory;\n/', '', $modelContent);

            // 3. Add 'use HasFactory, SoftDeletes;' and other class body content, including the createdBy relation
            $modelContent = preg_replace_callback('/class\s+' . $modelName . '\s+extends\s+Model\s*\{/', function ($matches) {
                return $matches[0] . "\n    use HasFactory, SoftDeletes, HasModelLogObserver;\n\n    protected \$guarded = [];\n\n    public function createdBy()\n    {\n        return \$this->hasOne(User::class, 'id', 'created_by');\n    }\n";
            }, $modelContent);

            file_put_contents($modelPath, $modelContent);
        }
    }

    public function generateMigration($tableName, $migrationFields){
        Artisan::call('make:migration', [
            'name' => "create_{$tableName}_table",
            '--create' => $tableName,
        ]);
        
        // ===== Append migration fields =====
        $migrationPath = collect(File::allFiles(database_path('migrations')))
            ->last(fn($file) => Str::contains($file->getFilename(), "create_{$tableName}_table"));
        
        if ($migrationPath) {
            $content = file_get_contents($migrationPath->getPathname());
            $content = preg_replace_callback('/Schema::create\(.*?function\s*\(Blueprint \$table\) \{(.*?)\}\);/s', function ($matches) use ($migrationFields, $tableName) {
                $newFields = implode("\n            ", $migrationFields);
                return "Schema::create('$tableName', function (Blueprint \$table) {\n            $newFields\n        });";
            }, $content);
        
            file_put_contents($migrationPath->getPathname(), $content);
        }        
    }

    public function generateController($controllerName, $modelName){
        // ===== Copy BaseController content =====
        $baseControllerPath = app_path('Http/Controllers/BaseController.php');
        $targetControllerPath = app_path("Http/Controllers/Admin/{$controllerName}.php");
        
        if (file_exists($baseControllerPath)) {
            $baseContent = file_get_contents($baseControllerPath);
            
            // Dynamically replace the 'use' statement with the model class name
            $baseContent = preg_replace(
                '/use App\\\Models\\\BaseModel;/',
                "use App\Models\\{$modelName};", // Replace 'BaseModel' with the new model name
                $baseContent
            );
        
            // Dynamically replace the constructor with the model class and inject the model
            $baseContent = preg_replace(
                '/public function __construct\(BaseModel \$model\)/',
                "public function __construct({$modelName} \$model)", // Replace with the new model name
                $baseContent
            );
        
            // Replace the class name dynamically with the new controller name
            $newContent = str_replace('class BaseController', "class {$controllerName}", $baseContent);
            
            // Replace all instances of 'BaseController' with the new controller name
            $newContent = str_replace('BaseController', $controllerName, $newContent);
        
            file_put_contents($targetControllerPath, $newContent);
        }
        
    }

    public function generateResourceRoute($controllerName, $modelName)
    {
        $routeName = str_replace('-', '_', Str::kebab(Str::plural($modelName)));  
        $routeLine = "Route::resource('$routeName', $controllerName::class);";

        // Add trashed and restore route block
        $additionalRoutes = <<<EOT
            Route::controller($controllerName::class)->group(function () {
                Route::get('$routeName/trashed', 'trashed')->name('$routeName.trashed');
                Route::get('$routeName/restore/{id}', 'restore')->name('$routeName.restore');
            });
        EOT;

        $filePath = base_path('routes/admin.php');
        $fileContent = file_get_contents($filePath);
    
        // 1. Update or insert controller inside grouped `use` block
        $fileContent = preg_replace_callback(
            '/use App\\\Http\\\Controllers\\\Admin\\\{([^}]+)}/',
            function ($matches) use ($controllerName) {
                // Explode by comma and clean up
                $controllers = array_filter(array_map('trim', explode(',', trim($matches[1]))));
    
                // Ensure unique and sorted, and remove duplicates (with empty values handled)
                $controllers = array_filter($controllers, fn($c) => !empty($c));
                if (!in_array($controllerName, $controllers)) {
                    $controllers[] = $controllerName;
                }
    
                sort($controllers); // optional, for better readability
    
                // Rebuild cleanly, ensuring no extra commas
                $formatted = implode(",\n    ", $controllers);
                return "use App\Http\Controllers\Admin\{\n    $formatted\n}";
            },
            $fileContent
        );
    
        // 2. Update or insert route inside middleware group
        $fileContent = preg_replace_callback(
            '/Route::middleware\(\'auth\'\)->group\(function\s*\(\)\s*\{(.*?)\n\}\);/s',
            function ($matches) use ($routeName, $controllerName, $routeLine, $additionalRoutes) {
                $routesBlock = trim($matches[1]);

                // Remove old resource route and additional custom block
                $routesBlock = preg_replace("/Route::resource\('$routeName'.*?;\n?/", '', $routesBlock);
                $routesBlock = preg_replace("/Route::controller\($controllerName::class\)->group\(function\s*\(\)\s*\{.*?\}\);/s", '', $routesBlock);

                // ✅ Insert custom routes right before "//Resource Routes."
                $updatedRoutes = preg_replace(
                    '/(\/\/\s*Resource Routes\.)/',
                    $additionalRoutes . "\n\n    $1",  // add indent to match
                    $routesBlock
                );

                // ✅ Append the resource route at the end
                $updatedRoutes .= "\n" . $routeLine;

                return "Route::middleware('auth')->group(function () {\n" . $updatedRoutes . "\n});";
            },
            $fileContent
        );

        // Fix extra semicolons
        $fileContent = preg_replace('/;{2,}/', ';', $fileContent);
    
        // Write back to file
        file_put_contents($filePath, $fileContent);
    }

    /**
     * Show details the specified resource.
     */
    public function show($id)
    {
        $bladePath = $this->pathInitialize;
        $model = $this->model->with('hasMenuGroup')->findOrFail($id);
        $fields = getFields($model, getFieldsAndColumns($this->model, $this->pathInitialize, $this->singularLabel, $this->routePrefix), 'show');
        return (string) view($bladePath.'.show_content', get_defined_vars());
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $bladePath = $this->pathInitialize;
        $title = $this->singularLabel;
        $menuGroups = $this->model->where('menu_group', NULL)->where('status', 1)->get();
        $model = $this->model->where('id', $id)->first();
        $fields = getFields($model, getFieldsAndColumns($this->model, $this->pathInitialize, $this->singularLabel, $this->routePrefix), 'edit');
        
        return view($bladePath.'.edit_content', get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $modelId)
    {
        $model = $this->model->where('id', $modelId)->first();
        $singularLabel = $this->singularLabel;
        $fields = getFieldsAndColumns($this->model, $this->pathInitialize, $this->singularLabel, $this->routePrefix);

        // Step 1: Build dynamic validation rules
        $rules = buildValidationRules($fields, $model, $request);

        // Step 2: Validate
        $validated = $request->validate($rules);

        DB::beginTransaction();

        try{
            // Step 3: Dynamically assign fields
            foreach ($fields as $field => $config) {
                if($field != 'created_at' && $field != 'action' && $field != 'fields' && $field != 'menu'){
                    if($field=='created_by'){
                        $model->$field = auth()->id() ?? null;
                    }
                    // elseif($field=='fields'){
                    //     $types = $request->types;
                    //     $merged = array_combine($validated[$field], $types);

                    //     // Remove null values from the merged array
                    //     $merged = array_filter($merged, function ($value) {
                    //         return !is_null($value); // Only keep non-null values
                    //     });

                    //     $model->$field = json_encode($merged);
                    // }
                    else{
                        $model->$field = $validated[$field] ?? null;
                    }
                }

                $model->save();
            }
            
            if(isset($model) && !empty($model)){
                // $response = $this->deleteExistFiles($request->pre_menu);
                // if ($response == true) {
                //     $types = $request->types;
                //     $menuColumns = $request->fields;
                //     $merged = array_combine($menuColumns, $types);

                //     // Remove null values from the merged array
                //     $fields = array_filter($merged, function ($value) {
                //         return !is_null($value); // Only keep non-null values
                //     });

                //     $response = false;
                //     if($this->createMenuFields($model, $fields)){
                //         $response = true;
                //     }

                //     if($response){
                //         $this->createFiles($model);

                //          // Commit the transaction before running the migration
                //         DB::commit();

                //         $tableName = Str::snake(Str::plural($request->pre_menu)); // categories
                //         if (Schema::hasTable($tableName)) {
                //             Schema::drop($tableName);
                //         }

                //         // Now, call migrate after committing the transaction
                //         Artisan::call('migrate');
                //     }else{
                //         DB::rollback();
                //         return response()->json(['success' => false, 'message' =>'Menu fields not inserted try again']);
                //     }
                // } else {
                //     DB::rollback();
                //     // Handle failure to delete files
                //     return response()->json(['success' => false, 'message' => 'Failed to delete some files.']);
                // }

                DB::commit();
                return response()->json(['success' => true, 'message' =>'You have updated '.$singularLabel.' successfully.']);
            }else{
                DB::rollback();
                return response()->json(['success' => false, 'message' =>'You have not updated '.$singularLabel.' successfully.']);
            }
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function deleteExistFiles($menu){
        // Extract menu-related information
        $tableName = Str::snake(Str::plural($menu)); // categories
        $modelName = Str::studly($menu);             // Category
        $controllerName = $modelName . 'Controller'; // CategoryController

        // Define paths for model, migration, controller, and views
        $modelPath = app_path("Models/{$modelName}.php");
        $migrationPath = collect(File::allFiles(database_path('migrations')))
        ->first(fn($file) => Str::contains($file->getFilename(), "create_" . $tableName . "_table"));
        $migrationPath ? $migrationPath->getPathname() : null;
        $controllerPath = app_path("Http/Controllers/Admin/{$controllerName}.php");
        $viewsPath = resource_path("views/admin/" . $tableName);

        // Initialize a flag to track deletion status
        $deleted = true;

        // 1. Delete the model if it exists
        if (file_exists($modelPath)) {
            unlink($modelPath);
        } 

        // 2. Delete the migration if it exists
        if ($migrationPath && file_exists($migrationPath)) {
            unlink($migrationPath);

            // Extract the filename (just the file name without path)
            $filename = basename($migrationPath);

            // Remove the migration record from the migrations table
            DB::table('migrations')->where('migration', pathinfo($filename, PATHINFO_FILENAME))->delete();
        } 

        // 3. Delete the controller if it exists
        if (file_exists($controllerPath)) {
            unlink($controllerPath);

            $this->deleteResourceRoute($controllerName, $modelName);
        }

        // 4. Delete the views folder if it exists
        if (File::exists($viewsPath)) {
            File::deleteDirectory($viewsPath);
        }

        // Return true if all files were successfully deleted, otherwise false
        return $deleted;
    }

    public function deleteResourceRoute($controllerName, $modelName){
        $routeName = Str::kebab(Str::plural($modelName)); 
        // Define file path for routes/web.php
        $filePath = base_path('routes/admin.php');
        $fileContent = file_get_contents($filePath);

        // Remove the controller from the 'use' block
        $fileContent = preg_replace_callback(
            '/use App\\\Http\\\Controllers\\\Admin\\\{([^}]+)}/',
            function ($matches) use ($controllerName) {
                // Explode by comma and clean up
                $controllers = array_filter(array_map('trim', explode(',', trim($matches[1]))));

                // Remove the controller if it exists
                $controllers = array_filter($controllers, fn($c) => $c !== $controllerName);

                // Rebuild cleanly, ensuring no extra commas
                $formatted = implode(",\n    ", $controllers);
                return "use App\Http\Controllers\Admin\{\n    $formatted\n};";
            },
            $fileContent
        );

        // Remove the resource route from the middleware group
        $fileContent = preg_replace_callback(
            '/Route::middleware\(\'auth\'\)->group\(function\s*\(\)\s*\{(.*?)\n\}\);/s',
            function ($matches) use ($routeName) {
                $routesBlock = trim($matches[1]);

                // Remove old resource route for this controller
                $routesBlock = preg_replace("/Route::resource\('$routeName'.*?;\n?/", '', $routesBlock);

                // Rebuild the routes block
                return "Route::middleware('auth')->group(function () {\n" . $routesBlock . "\n});";
            },
            $fileContent
        );

        // Fix extra semicolons
        $fileContent = preg_replace('/;{2,}/', ';', $fileContent);

        // Write the updated content back to the file
        file_put_contents($filePath, $fileContent);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($modelId)
    {
        $singularLabel = $this->singularLabel;
        if($this->model->where('id', $modelId)->delete()) {
            return response()->json([
                'status' => true,
                'message' => $singularLabel.' Deleted Successfully'
            ]);
        } else{
            return response()->json([
                'status' => false,
                'error' => $singularLabel.' not deleted try again.'
            ]);
        }
    }

    public function trashed(Request $request)
    {
        $singularLabel = $this->singularLabel;
        $routeInitialize = $this->routePrefix;
        $bladePath = $this->pathInitialize;
        $title = 'All Trashed '.Str::plural($singularLabel);

        // Get column definitions dynamically
        $getFields = getFields($this->model, getFieldsAndColumns($this->model, $this->pathInitialize, $this->singularLabel, $this->routePrefix), 'index');

        if (isset($getFields['icon'])) {
            $getFields['icon']['index'] = fn($model) => '<i class="menu-icon tf-icons '.$model->icon .'"></i>';
        }
        // Check and handle relation
        if (isset($getFields['menu_group'])) {
            // Customize index to pull from relation
            $getFields['menu_group']['index'] = fn($model) => optional($model->hasMenuGroup)->menu ?? '-';
        }

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
        
        $models = $this->model->onlyTrashed()->latest()
            ->select($selectedColumns);
        //select columns

        // Step 2: Check if current route is trashed
        if (Route::currentRouteName() === $routeInitialize.'.trashed') {
            // Step 3: Remove existing 'action' config
            unset($getFields['action']);

            // Step 4: Add custom restore button to 'action'
            $getFields['action'] = [
                'type' => 'custom',
                'label' => 'Action',
                'index_visible' => true,
                'index' => fn($model) => '<a href="' . route($routeInitialize.'.restore', $model->id) . '" class="btn btn-icon btn-label-info waves-effect">'
                                        . '<span><i class="ti ti-refresh ti-sm"></i></span></a>'
            ];
        }

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
                'orderable' => !in_array($key, ['action']), // Set orderable=false for 'action'
                'searchable' => !in_array($key, ['action']) // Set searchable=false for 'action'
            ];
        })->values()->toArray();
        
        return view($bladePath.'.index', get_defined_vars());
    }
    public function restore($id)
    {
       $find = $this->model->onlyTrashed()->where('id', $id)->first();
        if(isset($find) && !empty($find)) {
            $restore = $find->restore();
            if(!empty($restore)) {
                return redirect()->back()->with('message', 'Record Restored Successfully.');
            }
        } else {
            return false;
        }
    }

    public function settings(){
        $this->authorize('menus-list');
        $title = $this->pluralLabel;
        $singularLabel = $this->singularLabel;
        $routeInitialize = $this->routePrefix;
        $bladePath = $this->pathInitialize;

        $menus = $this->model->where('menu_group', NULL)
            ->where('status', 1)
            ->with('hasChildMenus')
            ->orderBy('group_order')
            ->orderBy('menu_order')
            ->select('id', 'menu', 'menu_label', 'icon', 'group_order', 'menu_order')->get();
        return view('admin.menus.settings', get_defined_vars());
    }

    public function reorder(Request $request)
    {
        $this->updateHierarchy($request->hierarchy);
        return response()->json(['status' => 'success']);
    }

    private function updateHierarchy($items, $parentId = null)
    {
        foreach ($items as $index => $item) {
            Menu::where('id', $item['id'])->update([
                'menu_group' => $parentId,
                'group_order' => $index + 1
            ]);

            if (!empty($item['children'])) {
                $this->updateHierarchy($item['children'], $item['id']);
            }
        }
    }
}
