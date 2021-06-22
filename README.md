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
php artisan marshmallow:resource UserGroup NovaUserGroups
php artisan marshmallow:resource NovaResource NovaUserGroups
php artisan marshmallow:resource NovaResourceAction NovaUserGroups
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
