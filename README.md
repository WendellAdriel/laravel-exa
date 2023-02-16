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

## Features

* Docker config with PHP, Nginx, MySQL, Redis and Mailhog
* Pint configuration
* Pest v2 for Tests
* Git Hooks for linting files
* Base classes to speed up the development
* DTOs
* Slack client for notifications
* API structured in modules
* Laravel Sanctum for Authentication
* Users and Roles management out-of-the-box

## Configuring the Application

Run this command for the initial app configuration

```bash
make configure
```

Update the `.env` file and then run the migrations

```bash
make art ARGS="migrate"
```

## Updating Services Ports

You can update which ports the services will connect to your machine by updating these variables in the `.env` file

* `APP_EXTERNAL_PORT`
* `APP_EXTERNAL_PORT_SSL`
* `DB_EXTERNAL_PORT`
* `REDIS_EXTERNAL_PORT`
* `MAILHOG_EXTERNAL_PORT_SMTP`
* `MAILHOG_EXTERNAL_PORT_HTTP`

## Commands Available

Use this command to see all the commands available

```bash
make
```

## Application Structure

The `app` folder contains only the files of a default **Laravel** installation.

The `exa` folder contains all the base classes provided by this **skeleton** to help you to develop your **API**.

The `modules` folder contains the code for your application. By default, you have an **Auth** module for **Authentication**,
**User** and **Roles management out-of-the-box**. It also provides a **Common** module that you can put shared logic for
your application.

## Creating Modules

To create new modules you can use this command

```bash
make art ARGS="make:module NAME"
```

This will create a new module inside the `modules` folder with the same structure of the other modules. It will create
the module disabled by default. To enable it, add the new module name to the `config/modules.php` file.

## Credits

- [Wendell Adriel](https://github.com/WendellAdriel)
- [All Contributors](../../contributors)

## Contributing

Check the **[Contributing Guide](CONTRIBUTING.md)**.
