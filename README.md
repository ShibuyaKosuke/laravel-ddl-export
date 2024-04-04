# laravel-ddl-export

Laravel プロジェクトから、テーブル定義書を xlsx 形式でエクスポートします！

Export Table definition to spreadsheet by artisan command.

For MySQL, PostgreSQL

## Install

```bash
$ composer require shibuyakosuke/laravel-ddl-export
```

## Usage

Write your migration file with comments.
To add table comment, use [this library](https://github.com/diplodocker/comments-loader).

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id()->comment('ID');
            $table->string('name')->comment('氏名');
            $table->string('email')->unique()->comment('メールアドレス');
            $table->timestamp('email_verified_at')->nullable()->comment('メール認証日時');
            $table->string('password')->comment('パスワード');
            $table->rememberToken()->comment('リメンバートークン');
            $table->dateTime('created_at')->nullable()->comment('作成日時');
            $table->dateTime('updated_at')->nullable()->comment('更新日時');
            $table->softDeletes()->comment('削除日時');
            $table->tableComment('ユーザー');
        });
    }
};
```

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
