# Laravel Permissions

This package helps to manage roles and permissions in application and utilize `spatie/laravel-permissions` package for convenient use.

# Installation

You can install package via composer. Add repository to your composer.json

    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/mindz-team/laravel-permissions"
        }
    ],

Then run

    composer require mindz-team/laravel-permissions

Publish config and configure

    php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
    php artisan vendor:publish --provider="Mindz\LaravelPermissions\LaravelPermissionsServiceProvider" --tag="config"

Migrate
    
    php artisan migrate


# Usage

Usage instruction

## Defining super admins

This package allows to grant super admin privileges to users which emails are included in `SUPER_ADMINS`. To include more than one super admin use comma to separate emails.

## Defining permissions

To have precise control over application privileges all operations must be determined by permissions only. Therefore, only permissions (not roles) should be only limitations for users.

To define permissions use config file `configs/laravel-permissions.php` and add required `permissions`. Then to sync them with database use command

    php arisan permissions:sync

All permissions in config file will be synced with database.

## Custom sync process

If you need to add some customization to sync process you can define your own using callback fo example in `AppServiceProvider.php`

    public function boot()
    {
        SyncPermissionsCommand::synchronizationCallback(function () {
            $permissions = config('laravel-permissions.permissions');
            Permission::whereNotIn('name', collect($permissions)->pluck('name'))->delete();
            collect($permissions)->whereNotIn('name', Permission::pluck('name'))->each(fn($permission) => Permission::create($permission));
        });
    }

# Change log

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

# Security

If you discover any security related issues, please email r.szymanski@mindz.it instead of using the issue tracker.

# Credits

Author: Roman Szymański [r.szymanski@mindz.it](mailto:r.szymanski@mindz.it)

# License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
