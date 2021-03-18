<?php

namespace App\Providers;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Blade;
use App\Traits\InteractsWithFilesystem;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    use InteractsWithFilesystem;

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(\App\Repositories\Posts\Posts::class, \App\Repositories\Posts\Eloquent::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->clearLogs();
        $this->setBladeExtensions();
    }

    /**
     * Delete the application logs.
     *
     * @return void
     */
    protected function clearLogs() {
        if (
            env('CLEAN_LOGS_WHEN_RUNNING_UNIT_TESTS') &&
            $this->app->runningInConsole() &&
            $this->app->runningUnitTests()
        ) {
            $path = storage_path('logs/.gitignore');
            $dirname = dirname($path);

            if ($this->files->exists($path) &&
                $this->files->isReadable($path) &&
                $this->files->isWritable($dirname)
            ) {
                $gitignore = $this->files->get($path);

                $this->files->cleanDirectory($dirname);
                $this->files->put($path, $gitignore);
            }
        }
    }

    /**
     * Extending Blade
     *
     * @return void
     */
    protected function setBladeExtensions() {
        Blade::if('role', function ($roles) {
            return auth()->user()->hasRole($roles);
        });

        Blade::if('permission', function ($permissions) {
            return auth()->user()->hasPermission($permissions);
        });
    }
}
