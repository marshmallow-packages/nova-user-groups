# A package to manage Nova User Groups in Nova

[![Latest Version on Packagist](https://img.shields.io/packagist/v/marshmallow/nova-user-groups.svg?style=flat-square)](https://packagist.org/packages/marshmallow/nova-user-groups)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/marshmallow/nova-user-groups/run-tests?label=tests)](https://github.com/marshmallow/nova-user-groups/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/marshmallow/nova-user-groups/Check%20&%20fix%20styling?label=code%20style)](https://github.com/marshmallow/nova-user-groups/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/marshmallow/nova-user-groups.svg?style=flat-square)](https://packagist.org/packages/marshmallow/nova-user-groups)

A package to manage Nova User Groups in Nova

## Installation

You can install the package via composer:

```bash
composer require marshmallow/nova-user-groups
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --provider="Marshmallow\NovaUserGroups\NovaUserGroupsServiceProvider" --tag="nova-user-groups-migrations"
php artisan migrate
```

## Usage

Run the install command to start using this package. When you run install, this will create Nova resources so you can manage all the data in your Nova installation. It will also create an administrator user group and connect all the current Nova Resources to that group. It will also connect all existing users to this administrator group.

```bash
php artisan user-groups:install

php artisan user-groups:policies
```

To add an super administrator group use the -s option

```bash
php artisan user-groups:install -s
```

### User model

Add the `HasUserGroup` trait to you user model.

```php
namespace App\Models;

use Marshmallow\NovaUserGroups\Traits\HasUserGroup;

class User extends Authenticatable
{
    use HasUserGroup;

    // ...
}

```

### Nova Resource

Add the `UserGroupResource` trait to your main Nova Resource.

```php
namespace App\Nova;

use Laravel\Nova\Resource as NovaResource;
use Laravel\Nova\Http\Requests\NovaRequest;
use Marshmallow\NovaUserGroups\Traits\UserGroupResource;

abstract class Resource extends NovaResource
{
    use UserGroupResource;

    // ...
}
```

### User methods

You can add methods to the user model and manage if there allowed to run these methods in Nova. Out of the box we will add three methods to the User model. These are `viewNova()`, `viewTelescope()` and `viewHorizon()`. If you wish to add a new methods to this, you need to follow the following steps.

In your config, add the method that you are going to add.

```php
// config/nova-user-groups.php
return [
    'user_methods' => [
        // ...
        'canImpersonate' => 'Is allowed to impersonate users',
    ],
];
```

Next you will need to add the methods to your user model. And call the `allowedToRunMethod` method.

```php
// app/models/user.php

namespace App\Models;

class User extends Authenticatable
{
    // ...
    public function canImpersonate()
    {
        return $this->allowedToRunMethod('canImpersonate');
    }
}
```

Once this is all set up, go to Nova and edit your user group. In the methods section, you will now see you new `canImpersonate` method. Check this to activate this method for that user group.

### Nova Service Provider

Add the `UserGroupNovaServiceProvider` trait to your `NovaServiceProvider`. Once you have done so, you will have a couple of new methods to make sure the authenticated user group is allowed to do stuff that is defined in the NovaServiceProvider.

```php
namespace App\Providers;

// ..
use Marshmallow\NovaUserGroups\Traits\UserGroupNovaServiceProvider;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    use UserGroupNovaServiceProvider;

    // ...

    protected function cards()
    {
        return $this->canSeeCards([
            // Your cards go here.
        ]);
    }

    protected function dashboards()
    {
        return $this->canSeeDashboards([
            // Your cards go here.
        ]);
    }

    protected function tools()
    {
        return $this->canSeeTools([
            // Your cards go here.
        ]);
    }
}
```

## Change the models and resource

All models and resources can be overruled by changing them in you `AppServiceProvider` in the `boot` method. You can find an example below. The values in this example are the default values.

```php
/**
 * Bootstrap any application services.
 *
 * @return void
 */
public function boot()
{
    NovaUserGroups::$userModel = User::class;
    NovaUserGroups::$userGroupModel = \Marshmallow\NovaUserGroups\Models\UserGroup::class;
    NovaUserGroups::$novaResourceModel = \Marshmallow\NovaUserGroups\Models\NovaResource::class;
    NovaUserGroups::$novaResourceActionModel = \Marshmallow\NovaUserGroups\Models\NovaResourceAction::class;

    NovaUserGroups::$userResource = \App\Nova\User::class;
    NovaUserGroups::$novaResource = \Marshmallow\NovaUserGroups\Nova\NovaResource::class;
    NovaUserGroups::$novaResourceAction = \Marshmallow\NovaUserGroups\Nova\NovaResourceAction::class;
}
```

## Config

Some methods require additional Policy access, add a group under 'groups' with the key and name.
Add the allowed methods under 'methods' with group key and the method name.

````php

return [

    /*
    |--------------------------------------------------------------------------
    | Allowed Admin Groups
    |--------------------------------------------------------------------------
    |
    | This is a list of groups on which the methods will be defined.
    |
    */
    'groups' => [
        'admin' => 'Administrator',
        'super-admin' => 'SuperAdministrator',
    ],

    /*
    |--------------------------------------------------------------------------
    | Allowed Methods
    |--------------------------------------------------------------------------
    |
    | This is a list of allowed methods per group
    |
    */
    'methods' => [
        'admin' => [
            'viewNova',
        ],
        'super-admin' => [
            'viewNova',
            'viewTelescope',
            'viewHorizon'
        ]
    ],
];

## Commands

```bash
php artisan user-groups:policies
php artisan user-groups:policy {name}
php artisan user-groups:import-resources

php artisan marshmallow:resource NovaTool NovaUserGroups --force
php artisan marshmallow:resource UserGroup NovaUserGroups --force
php artisan marshmallow:resource NovaResource NovaUserGroups --force
php artisan marshmallow:resource NovaResourceAction NovaUserGroups --force
````

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

-   [Stef van Esch](https://github.com/marshmallow-packages)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
