# HTTP Software Application Template

[![License](https://poser.pugx.org/httpsoft/http-app/license)](https://packagist.org/packages/httpsoft/http-app)
[![Latest Stable Version](https://poser.pugx.org/httpsoft/http-app/v)](https://packagist.org/packages/httpsoft/http-app)
[![Total Downloads](https://poser.pugx.org/httpsoft/http-app/downloads)](https://packagist.org/packages/httpsoft/http-app)
[![GitHub Build Status](https://github.com/httpsoft/http-app/workflows/build/badge.svg)](https://github.com/httpsoft/http-app/actions)
[![GitHub Static Analysis Status](https://github.com/httpsoft/http-app/workflows/static/badge.svg)](https://github.com/httpsoft/http-app/actions)
[![Scrutinizer Code Coverage](https://scrutinizer-ci.com/g/httpsoft/http-app/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/httpsoft/http-app/?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/httpsoft/http-app/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/httpsoft/http-app/?branch=master)

HTTP application template for quickly creating simple but powerful web applications and APIs. «Out of the box», the application template is configured to work with JSON for rapid REST API development.

The core of this application template is the [httpsoft/http-basis](https://github.com/httpsoft/http-basis) microframework. By default, the [devanych/di-container](https://github.com/devanych/di-container) that implements [PSR-11](https://github.com/php-fig/container) and the [monolog/monolog](https://github.com/Seldaek/monolog) logger that implements [PSR-3](https://github.com/php-fig/log) are also used. You can easily change the container and logger to your preferred implementations of the corresponding PSRs.

## Documentation

* [In English language](https://httpsoft.org/docs/app).
* [In Russian language](https://httpsoft.org/ru/docs/app).

## Installation

This project template requires PHP version 7.4 or later.

```bash
composer create-project --prefer-dist --stability=dev httpsoft/http-app <app-dir>
```

To verify the installation, go to `<app-dir>` and start the PHP built-in web server:

```bash
cd <app-dir>
composer run serve
```

After that, open `http://localhost:8080` in your browser.

## Testing and checking

The following commands are run in the application directory:

* `composer run test` — runs tests.
* `composer run static` — runs static analysis code.
* `composer run cs-check` — runs checking coding standards.
* `composer run cs-fix` — runs automatic correction of violations of encoding standards.
* `composer run check` — runs checking coding standards, static analysis code and tests.

## Directory structure

By default, the application template has the following structure:

```
bin/                  Executable console scripts.
    chmod-var.php     Recursively changing the "var/" directory mode.
config/               Configuration files.
    config.php        Main configuration.
    container.php     Dependency injection.
    pipeline.php      Middleware pipeline.
    routes.php        HTTP request routes.
public/               Files publically accessible from the Internet.
    index.php         Entry script.
src/                  Application source code.
    Http/             HTTP application classes (actions, middelware, etc.).
    Infrastructure/   Helper classes (factories, listeners, etc.).
    Model/            Domain model classes (entities, repositories, etc.).
tests/                A set of tests for the application.
vendor/               Installed Composer packages.
var/                  Temporary files (logs, cache, etc.).
```

You can change the structure of the application template as you like.
