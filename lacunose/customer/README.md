# Lacunose Customer

**Lacunose Customer** is a flexible accounts and account management system for Laravel, with the required tools to run your SAAS like services efficiently. It's simple architecture, accompanied by powerful underlying to afford solid platform for your business.

[![Packagist](https://img.shields.io/packagist/v/chelsymooy/laravel-accounts.svg?label=Packagist&style=flat-square)](https://packagist.com/orgs/Lacunose/programs/2673530)
[![Scrutinizer Code Quality](https://img.shields.io/scrutinizer/g/chelsymooy/laravel-accounts.svg?label=Scrutinizer&style=flat-square)](#)
[![Travis](https://img.shields.io/travis/chelsymooy/laravel-accounts.svg?label=TravisCI&style=flat-square)](#)
[![StyleCI](https://styleci.io/repos/93313402/shield)](#)
[![License](https://img.shields.io/packagist/l/chelsymooy/laravel-accounts.svg?label=License&style=flat-square)](#)


## Considerations

- Payments are out of scope for this program.
- You may want to extend some of the core models, in case you need to override the logic behind some helper methods like `renew()`, `cancel()` etc. E.g.: when cancelling a account you may want to also cancel the recurring payment attached.


## Installation

1. Install the program via composer:
    ```shell
    composer require Lacunose/Customer
    ```

2. Publish resources (migrations and config files):
    ```shell
    php artisan vendor:publish
    ```

3. Add service provider in config/app.php:
    ```shell
    Lacunose\Customer\Providers\CustomerServiceProvider::class,
    ```

4. Execute migrations via the following command:
    ```shell
    php artisan migrate
    ```

5. Done!


## Usage

### New account

(COMING SOON)

### Recurring log

(COMING SOON)

### Activate account as Middleware

(COMING SOON)

### Send log to customer Email

(COMING SOON)

### Frontend Hook

(COMING SOON)

### Scopes

### Models

(COMING SOON)

## Changelog

Refer to the [Changelog](CHANGELOG.md) for a full history of the project.


## Support

The following support channels are available at your fingertips:

- [Help on Email](mailto:mooychelsy@gmail.com)
- [Follow on Twitter](https://twitter.com/cmooy)


## Contributing & Protocols

Thank you for considering contributing to this project! The contribution guide can be found in [CONTRIBUTING.md](CONTRIBUTING.md).

Bug reports, feature requests, and pull requests are very welcome.

- [Versioning](CONTRIBUTING.md#versioning)
- [Pull Requests](CONTRIBUTING.md#pull-requests)
- [Coding Standards](CONTRIBUTING.md#coding-standards)
- [Feature Requests](CONTRIBUTING.md#feature-requests)
- [Git Flow](CONTRIBUTING.md#git-flow)


## Security Vulnerabilities

If you discover a security vulnerability within this project, please send an e-mail to [mooychelsy@gmail.com](mooychelsy@gmail.com). All security vulnerabilities will be promptly addressed.


## About Lacunose

Lacunose is a software developer specialized in web & android applications.


## License

This software is released under [The MIT License (MIT)](LICENSE).

(c) 2020 Lacunose LLC, Some rights reserved.
