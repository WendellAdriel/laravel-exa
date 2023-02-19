<div align="center">
    <p>
        <h1>ExA</h1>
        Opinionated Modularized API Skeleton for Laravel
    </p>
</div>

<p align="center">
<a href="https://packagist.org/packages/WendellAdriel/laravel-exa"><img src="https://img.shields.io/packagist/v/WendellAdriel/laravel-exa.svg?style=flat-square" alt="Packagist"></a>
<a href="https://packagist.org/packages/WendellAdriel/laravel-exa"><img src="https://img.shields.io/packagist/php-v/WendellAdriel/laravel-exa.svg?style=flat-square" alt="PHP from Packagist"></a>
<a href="https://packagist.org/packages/WendellAdriel/laravel-exa"><img src="https://img.shields.io/badge/Laravel-10.x-brightgreen.svg?style=flat-square" alt="Laravel Version"></a>
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
* Docker config with PHP, Nginx, MySQL, Redis and Mailpit
* Laravel Pint configuration
* Pest v2 for Tests
* Git Hooks for linting files
* Base classes to speed up the development
* DTOs with [Laravel Validated DTO](https://github.com/WendellAdriel/laravel-validated-dto)
* Slack Client for notifications
* API structured in modules
* Laravel Sanctum for Authentication
* Users management out-of-the-box with simple roles system
* Logs on DB for user logins and for actions made on models
* [Strictus](https://github.com/php-strictus/strictus) for enforcing local variable types

## Using the Template

There are three ways of using this template:

### Composer (Recommended)

```bash
composer create-project --prefer-dist wendelladriel/laravel-exa my-app
```

### GitHub Template

Click the `Use this template` button in the GitHub repository page.

### Git Clone

```bash
git clone git@github.com:WendellAdriel/laravel-exa.git my-app && cd my-app && rm -rf .git
```

## Configuring the Application

Build the docker services with

```bash
make build
```

Run this command for the initial app configuration

```bash
make configure
```

Update the `.env` file and then run the migrations

```bash
make art ARGS="migrate"
```

Update the admin user in the `database/seeders/DatabaseSeeder.php` file and run the seeds

```bash
make art ARGS="db:seed"
```

### Updating Services Ports

You can update which ports the services will connect to your machine by updating these variables in the `.env` file

* `APP_EXTERNAL_PORT`
* `APP_EXTERNAL_PORT_SSL`
* `DB_EXTERNAL_PORT`
* `REDIS_EXTERNAL_PORT`
* `MAILPIT_EXTERNAL_PORT_SMTP`
* `MAILPIT_EXTERNAL_PORT_HTTP`

## Application Structure

The `app` folder contains only the files of a default **Laravel** installation.

The `exa` folder contains all the base classes provided by this **skeleton** to help you to develop your **API**.

The `modules` folder contains the code for your application. By default, you have an **Auth** module for **Authentication**,
and **User management out-of-the-box**. It also provides a **Common** module that you can put shared logic for
your application.

### Creating Modules

To create new modules you can use this command

```bash
make art ARGS="make:module NAME"
```

This will create a new module inside the `modules` folder with the same structure of the other modules. It will create
the module disabled by default. To enable it, add the new module name to the `config/modules.php` file.

### Commands Available

For running Pint in the whole codebase use

```bash
make lint
```

For running the test suite use

```bash
make test
```

Use this command to see all the commands available

```bash
make
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

* `BaseModel` - Base class that all your models should extend, already configured with the `CommonQueries` and `LogChanges` Traits.
* `ChangeLog` - Model for the table that logs all changes made on other models.
* `CommonQueries` - This Trait provides a lot of methods for common queries that you can use with your models.
* `HasUuidField` - This Trait provides UUID field support for models that don't want the UUID to be the primary key.
* `LogChanges` - This Trait provides listeners for logging changes on the models. Check the class to know how you can customize your models with the properties of this Trait.

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
