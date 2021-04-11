# laravel-ddl-export

Export Table definition to spreadsheet by artisan command.

For MySQL, PostgreSQL

## Install 

```bash
$ composer require shibuyakosuke/laravel-ddl-export
```

# Usage

Run migration before exporting.

```bash
$ php artisan migrate
$ php artisan ddl:export
```
