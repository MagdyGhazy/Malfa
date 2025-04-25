<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MakeModuleCommand extends Command
{

    protected $signature = 'make:module {name}';


    protected $description = 'Generate a new migration, model, service, controller and routs';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name                 = ucfirst($this->argument('name'));
        $small_name           = strtolower($this->argument('name'));
        $class_name           = $name . 'Service';
        $controller_name      = $name . 'Controller';
        $seeder_name          = $name . 'Seeder';
        $store_request        = 'Store' . $name . 'Request';
        $update_request       = 'Update' . $name . 'Request';
        $service_directory    = app_path("Http/Services/{$name}");
        $service_path         = $service_directory . "/{$class_name}.php";
        $controller_directory = app_path("Http/Controllers/Api/{$name}");
        $controller_path      = $controller_directory . "/{$controller_name}.php";
        $date                 = now()->format('Y-m-d');


        if (File::exists($service_path)) {
            $this->error("Service {$class_name} already exists!");
            return;
        }

        if (File::exists($controller_path)) {
            $this->error("Controller {$controller_name} already exists!");
            return;
        }


        File::makeDirectory($service_directory, 0755, true, true);
        File::makeDirectory($controller_directory, 0755, true, true);


        $service_stub_path = base_path('stubs/service.stub');
        if (!File::exists($service_stub_path)) {
            $this->error("Stub file not found at: stubs/service.stub");
            return;
        }

        $controller_stub_path = base_path('stubs/controller.module.stub');
        if (!File::exists($controller_stub_path)) {
            $this->error("Stub file not found at: stubs/controller.module.stub");
            return;
        }


        Artisan::call("make:model", ['name' => $name, '--migration' => true]);
        Artisan::call("make:request", ['name' => "{$name}/{$store_request}"]);
        Artisan::call("make:request", ['name' => "{$name}/{$update_request}"]);
        Artisan::call("make:seeder", ['name' => "{$seeder_name}"]);


        $service_stub = File::get($service_stub_path);
        $controller_stub = File::get($controller_stub_path);


        $service_content = str_replace(
            ['{{ name }}', '{{ service_name }}', '{{ controller_name }}', '{{ store_request }}', '{{ update_request }}'],
            [$name, $class_name, $controller_name, $store_request, $update_request],
            $service_stub
        );

        $controller_content = str_replace(
            ['{{ name }}', '{{ service_name }}', '{{ controller_name }}', '{{ store_request }}', '{{ update_request }}'],
            [$name, $class_name, $controller_name, $store_request, $update_request],
            $controller_stub
        );


        File::put($service_path, $service_content);
        File::put($controller_path, $controller_content);


        $routePath = base_path('routes/api.php');
        $routeContent = <<<ROUTE



             /** ===========| {$name} |============================| {$date} |================= **/
             Route::group(['prefix' => '{$small_name}', 'middleware' => 'auth:sanctum'], function () {
                 Route::controller(\\App\\Http\\Controllers\\Api\\{$name}\\{$controller_name}::class)->group(function () {
                     Route::get('/', 'index')->middleware('permission:list {$small_name}s');
                     Route::get('/{id}', 'show')->middleware('permission:show {$small_name}s');
                     Route::post('/', 'store')->middleware('permission:create {$small_name}s');
                     Route::put('/{id}', 'update')->middleware('permission:edit {$small_name}s');
                     Route::delete('/{id}', 'destroy')->middleware('permission:delete {$small_name}s');
                 });
             });
        ROUTE;


        File::append($routePath, $routeContent);

        $seederPath = database_path('seeders/PermissionSeeder.php');
        $permissionLine = "            '{$small_name}s' => ['list', 'show', 'create', 'edit', 'delete'],\n        ";

        if (File::exists($seederPath)) {
            $seederContent = File::get($seederPath);


            if (strpos($seederContent, $permissionLine) === false) {
                $seederContent = preg_replace(
                    '/(\$permissions\s*=\s*\[)(.*?)(\];)/s',
                    "$1$2\n{$permissionLine}$3",
                    $seederContent
                );

                File::put($seederPath, $seederContent);
            }
        }

        $databaseSeederPath = database_path('seeders/DatabaseSeeder.php');
        $seeder_call_line = "        \$this->call({$seeder_name}::class);";

        if (File::exists($databaseSeederPath)) {
            $dbSeederContent = File::get($databaseSeederPath);

            if (strpos($dbSeederContent, $seeder_call_line) === false) {

                $dbSeederContent = preg_replace(
                    '/(public function run\(\): void\s*\{\n)(.*?)(\n\s*\})/s',
                    "$1$2\n{$seeder_call_line}$3",
                    $dbSeederContent
                );

                File::put($databaseSeederPath, $dbSeederContent);
            }
        }


        $created_seeder_path = database_path("seeders/{$seeder_name}.php");
        $seeder_insert_line = "        {$name}::create([\n            '' => ''\n        ]);";

        if (File::exists($created_seeder_path)) {
            $seeder_content = File::get($created_seeder_path);

            $model_import_line = "use App\\Models\\{$name};";

            if (!Str::contains($seeder_content, $model_import_line)) {
                $seeder_content = preg_replace(
                    '/(namespace\s+Database\\\\Seeders;)/',
                    "$1\n\n{$model_import_line}",
                    $seeder_content
                );
            }

            $seeder_content = preg_replace(
                '/(public function run\(\): void\s*\{\n)(\s*\/\/)/',
                "$1{$seeder_insert_line}",
                $seeder_content
            );

            File::put($created_seeder_path, $seeder_content);
        }

        $this->info("Service, Requests, Routes, permissions, seeder, Model and migration created for {$name}");
    }

}
