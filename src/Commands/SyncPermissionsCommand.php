<?php

namespace Mindz\LaravelPermissions\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Permission;

class SyncPermissionsCommand extends Command
{
    public static $synchronizationCallback;

    protected $signature = 'permissions:sync';

    protected $description = 'Sync permissions in database';

    public function __construct()
    {
        parent::__construct();
    }

    public static function synchronizationCallback($callback)
    {
        static::$synchronizationCallback = $callback;
    }

    public function handle()
    {
        if (static::$synchronizationCallback) {
            return call_user_func(static::$synchronizationCallback);
        }

        $permissions = config('laravel-permissions.permissions');
        Permission::whereNotIn('name', collect($permissions)->pluck('name'))->delete();
        collect($permissions)->whereNotIn('name', Permission::pluck('name'))->each(fn($permission) => Permission::create($permission));
    }
}
