# laravel-ddl-export

Export Table definition to spreadsheet by artisan command.

For MySQL, PostgreSQL

## Install

```bash
$ composer require shibuyakosuke/laravel-ddl-export
```

## Usage

Run migration before exporting.

```bash
$ php artisan migrate
$ php artisan ddl:export
```

## Export validation rules

```bash
$ php artisan ddl:rules
```

output to `/config/rules.php`

```php
return [
    'users' => [
        'id' => ['integer', 'required'],
        'name' => ['string', 'required', 'max:255'],
        'email' => ['string', 'required', 'max:255'],
        'email_verified_at' => ['date', 'nullable'],
        'password' => ['string', 'required', 'max:255'],
        'remember_token' => ['string', 'nullable', 'max:100'],
        'created_at' => ['date', 'nullable'],
        'updated_at' => ['date', 'nullable'],
        'deleted_at' => ['date', 'nullable'],
    ],
];
```

## Export translation file

```bash
$ php artisan ddl:trans
```

output to `/resources/lang/ja/columns.php`

```php
return [
    'users' => [
        'id' => 'ID',
        'name' => '氏名',
        'email' => 'メールアドレス',
        'email_verified_at' => 'メール認証日時',
        'password' => 'パスワード',
        'remember_token' => 'リメンバートークン',
        'created_at' => '作成日時',
        'updated_at' => '更新日時',
        'deleted_at' => '削除日時',
    ],
];
```
