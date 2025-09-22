<div align="center">
    <p>
        <h1>ExA</h1>
        Opinionated Modularized API Skeleton for Laravel
    </p>
</div>

<p align="center">
<a href="https://packagist.org/packages/WendellAdriel/laravel-exa"><img src="https://img.shields.io/packagist/v/WendellAdriel/laravel-exa.svg?style=flat-square" alt="Packagist"></a>
<a href="https://packagist.org/packages/WendellAdriel/laravel-exa"><img src="https://img.shields.io/packagist/php-v/WendellAdriel/laravel-exa.svg?style=flat-square" alt="PHP from Packagist"></a>
<a href="https://packagist.org/packages/WendellAdriel/laravel-exa"><img src="https://img.shields.io/badge/Laravel-12.x-brightgreen.svg?style=flat-square" alt="Laravel Version"></a>
</p>

<p align="center">
    <a href="#features">Features</a> |
    <a href="#using-the-template">Usage</a> |
    <a href="#configuring-the-application">Configuration</a> |
    <a href="#application-structure">Structure</a> |
    <a href="#exa-classes">ExA Classes</a> |
    <a href="#credits">Credits</a> |
    <a href="#contributing">Contributing</a>
</p>

## Features

* Your API running on the latest version of Laravel and PHP
* API Documentation with Swagger
* Laravel Pint configuration (very opinionated)
* Pest v4 for Tests with 100% type coverage
* Base classes to speed up the development
* DTOs with [Laravel Validated DTO](https://github.com/WendellAdriel/laravel-validated-dto)
* Slack Client for notifications
* API structured in modules
* JWT for Authentication
* Users management out-of-the-box with simple roles system
* Logs on DB for user logins and for actions made on models
* Log actions made by users with the `created_by`, `updated_by` and `deleted_by` fields. Use the `$table->userActions()` in your migrations to add these fields.
* Strict mode for Models + automatic eager load relationships
* Dates use `CarbonImmutable` by default
* Prohibit destructive commands in PROD
* Strong password validation by default
* Rector configuration for better code

## Using the Template

```bash
composer create-project --prefer-dist wendelladriel/laravel-exa my-app
```

## Configuring the Application

Copy the `.env.example` to `.env` and update the needed values

```bash
cp .env.example .env
```

Install the dependencies

```bash
composer install
```

Generate the application key and JWT secret

```bash
php artisan key:generate --ansi && php artisan jwt:secret
```

Run the migrations

```bash
php artisan migrate
```

Update the admin user in the `database/seeders/DatabaseSeeder.php` file and run the seeds

```bash
php artisan db:seed
```

## Application Structure

The `app` folder contains only the files of a default **Laravel** installation.

The `exa` folder contains all the base classes provided by this **skeleton** to help you to develop your **API**.

The `modules` folder contains the code for your application. By default, you have an **Auth** module for **Authentication**,
and **User management out-of-the-box**. It also provides a **Common** module that you can put shared logic for
your application.

### Creating Modules

To create new modules you can use this command

```bash
php artisan make:module MODULE_NAME
```

This will create a new module inside the `modules` folder with the same structure of the other modules. It will create
the module disabled by default. To enable it, add the new module name to the `config/modules.php` file.

### Commands Available

Run the linter (Pint) and Rector in the whole codebase

```bash
composer lint
```

Run the linter (Pint) and Rector in dry-run mode

```bash
composer test:lint
```

Run the type coverage tests

```bash
composer test:types
```

Run the test suite

```bash
composer test:unit
```

Update the Swagger docs

```bash
composer swagger
```

Run the linter (Pint) in staged files and update the Swagger docs

```bash
composer prepare
```

Runs the commands `test:lint`, `test:types` and `test:unit`

```bash
composer test
```

## ExA Classes

Inside the `exa` folder, there are a lot of classes provided by this **skeleton** to help you to develop your **API**.

### DTOs

* `DatatableDTO` - This DTO provides basic filters for fetching data for datatables.
* `DateRangeDTO` - This is an extension of the `DatatableDTO` providing additional parameters for date filters.

### Exceptions

- `ExaException` - Base class that all your custom exceptions should extend, so it can be handled properly by the `app/Exceptions/Handler`.
- `AccessDeniedException` - Exception used for actions that the user is not allowed to perform.

### Http

#### Middlewares

* `BlockViewerUsers` - This middleware is a middleware applied to all routes that blocks any users with the role **VIEWER** to access any routes that are not **GET** routes.
* `HasRole` - This middleware can be applied to routes that can be accessed only by users with a specific role or **ADMINS** that have full access.

#### Responses

* `ApiErrorResponse` - The class to be used to return any error responses, configured to be used by the `app/Exceptions/Handler`.
* `ApiSuccessResponse` - The class to be used to return any success responses, configured to be used with **JSON Resources**.
* `NoContentResponse` - The class to be used to return empty responses.

### Models

* `BaseModel` - Base class that all your models should extend, already configured with the `CommonQueries`, `LogChanges` and `UserActions` Traits.
* `ChangeLog` - Model for the table that logs all changes made on other models.
* `CommonQueries` - This Trait provides a lot of methods for common queries that you can use with your models.
* `HasUuidField` - This Trait provides UUID field support for models that don't want the UUID to be the primary key.
* `LogChanges` - This Trait provides listeners for logging changes on the models. Check the class to know how you can customize your models with the properties of this Trait.
* `UserActions` - This Trait provides listeners for logging changes made by users on the models populating the `created_by`, `updated_by` and `deleted_by` fields. Check the class to know how you can customize your models with the properties of this Trait.

### Services

* `SlackClient` - Class to send notifications to **Slack**. You need to add the needed configuration in your env, check the `config/services.php` file for the slack service to know how to configure it.

### Support

* `Datatable` - Class that provides functions for paginating, sorting and filtering data.
* `Formatter` - Class that provides common values in constants and methods to format data in your application.
* `ChangeAction` - Enum used by the `LogChanges` Trait.
* `SortOption` - Enum for the sort order used by the `DatatableDTO`.

## Credits

- [Wendell Adriel](https://github.com/WendellAdriel)
- [All Contributors](../../contributors)

## Contributing

Check the **[Contributing Guide](CONTRIBUTING.md)**.
