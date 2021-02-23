<?php

namespace App\Providers;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
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
        if ($this->app->environment('testing')) {
            $path      = storage_path('logs');
            $files     = new Filesystem;
            $gitignore = $files->get($path . '/.gitignore');

            $files->cleanDirectory($path);
            $files->put($path . '/.gitignore', $gitignore);
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
