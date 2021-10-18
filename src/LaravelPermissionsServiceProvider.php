<?php

namespace Mindz\LaravelPermissions;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Mindz\LaravelPermissions\Commands\SyncPermissionsCommand;

class LaravelPermissionsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                SyncPermissionsCommand::class
            ]);
        }

        $this->publishes([
            __DIR__ . '/../config/laravel-permissions.php' => config_path('laravel-permissions.php'),
        ], 'config');

        Gate::before(function ($user, $ability) {
            return in_array($user->email, config('laravel-permissions.super-admins', '')) ? true : null;
        });
    }
}
