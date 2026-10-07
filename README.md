# FyrePHP Application Skeleton

[![CI](https://github.com/fyrephp/app/actions/workflows/ci.yml/badge.svg)](https://github.com/fyrephp/app/actions/workflows/ci.yml)
[![Packagist Version](https://img.shields.io/packagist/v/fyre/app.svg)](https://packagist.org/packages/fyre/app)
[![Packagist Downloads](https://img.shields.io/packagist/dt/fyre/app.svg)](https://packagist.org/packages/fyre/app)
[![GitHub License](https://img.shields.io/github/license/fyrephp/app.svg)](LICENSE)

**FyrePHP** is an application skeleton for **FyreFramework** with application bootstrap, HTTP and CLI entry points, configuration, and a welcome page ready to run. Use it as a starting point for your application: define routes in `config/routes.php`, add application code under `app/`, and build pages in `templates/`.

## Table of Contents

- [Getting started](#getting-started)
- [Project structure](#project-structure)
- [Configuration](#configuration)
- [Hosting](#hosting)
- [Documentation](#documentation)
- [Development checks](#development-checks)
- [Testing](#testing)
- [License](#license)

## Getting started

Requires PHP 8.5 or later, the `intl`, `mbstring`, and `sodium` extensions, and Composer.

Create a new application with Composer:

```sh
composer create-project fyre/app my-app
cd my-app
```

This creates the project directory and installs its dependencies. If you cloned or downloaded this repository instead, run `composer install` from the project directory.

Copy the development environment file and start the development server:

```sh
cp config/.env.example config/.env
./bin/fyre server
```

Open [http://localhost:8000](http://localhost:8000) to view the welcome page. No database, Redis, or SMTP setup is needed to get started.

The server uses PHP's built-in development server. The port defaults to 8000; use `-p` to choose a port between 1 and 65535:

```sh
./bin/fyre server -p 8080
```

Use `./bin/fyre server --help` to list server options.

## Project structure

| Path | Purpose |
| --- | --- |
| `app/Application.php` | Application bootstrap and middleware configuration. |
| `config/routes.php` | Route definitions, including the welcome page route. |
| `config/app.php` | Application and service settings. |
| `config/bootstrap.php` | Environment loading and global defaults. |
| `templates/` | Welcome and error page templates. |
| `public/` | Web document root, including the front controller and public assets. |
| `tests/TestCase/` | Application tests. |

## Configuration

Configure application defaults and services in `config/app.php`. Use `config/.env` for environment-specific values; `config/.env.example` lists the available application, database, SMTP, Redis, session, and CSRF settings. Existing process environment variables take precedence over the file.

Session, CSRF, and authentication middleware are optional and can be enabled in `app/Application.php` after configuring their services. Set a stable `CSRF_SALT` before enabling CSRF protection, and disable the relevant secure cookie settings when developing over plain HTTP.

## Hosting

Set the web server's document root to `public/`. Ensure `tmp/` and `log/` exist and are writable by the PHP process; they hold runtime files such as caches, sessions, and logs.

Set `APP_DEBUG=0` in production. Use the built-in server for local development only.

## Documentation

Continue with the FyreFramework guides:

- [Getting Started](https://github.com/fyrephp/framework/blob/main/docs/getting-started.md)
- [Routing](https://github.com/fyrephp/framework/blob/main/docs/routing/index.md)
- [Deployment](https://github.com/fyrephp/framework/blob/main/docs/deployment.md)

## Development checks

```sh
composer cs
composer stan
composer test
```

Use `composer cs:fix` to apply the framework's formatting rules.

## Testing

Requires FyreFramework 1.2 or later. `autoload.php` initializes the application and loads its configuration. The HTTP and CLI entry points then call `Application::boot()`. `tests/bootstrap.php` applies test settings, adds test connection aliases, disables cache, unregisters the PHP error handler, and disables CLI error rendering before calling boot.

`config/app.php` defines `Database.test` using separate `TEST_DB_*` settings from `config/.env.example`. They do not fall back to application database credentials. The test bootstrap aliases `Database.default` to `Database.test`; for each additional application connection, add a corresponding `Database.test_<name>` configuration in `config/app.php`. Create the test databases and prepare their schemas before running fixture tests. Automatic fixtures require configured `test` or `test_*` write connections and truncate affected tables during cleanup. The supplied tests do not require a database or Redis server.

Add `Fyre\TestSuite\Traits\QueueTestTrait` to tests asserting dispatches; it captures jobs without Redis or job execution and clears them between tests. If boot or fixture setup dispatches jobs, configure the affected queues with `Fyre\TestSuite\Queue\Handlers\TestQueue` in `tests/bootstrap.php` before that work. Tests exercising real Redis behavior must configure a dedicated Redis database and a distinct `prefix` per parallel process.

Cache is disabled by default. Add `Fyre\TestSuite\Traits\CacheTestTrait` to tests needing functioning, isolated array caches. Queue and cache traits run after base `TestCase::setUp()`, including fixture loading. Apply any required handler settings in the bootstrap before boot or fixture work retains service references.

HTTP integration tests render error responses by default. Call `$this->disableErrorRendering()` when expecting the original exception; rendering is restored automatically during cleanup. Put `expectException()` and, where practical, `expectExceptionMessageIs()` before the operation being tested.

See the framework's [test configuration guide](https://github.com/fyrephp/framework/blob/v1.2.0/docs/testing/configuration.md) for the APIs and lifecycle details.

## License

FyrePHP is released under the [MIT License](LICENSE).
