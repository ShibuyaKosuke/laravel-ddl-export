<?php

return [
    'table' => [
        'title' => 'テーブル情報',
        'app_name' => 'システム名',
        'sub_system' => 'サブシステム名',
        'creator' => '作成者',
        'created_at' => '作成日',
        'updated_at' => '更新日',
        'schema_name' => 'スキーマ名',
        'logical_name' => '論理テーブル名',
        'physical_name' => '物理テーブル名',
        'rdbms' => 'RDBMS',
    ],
    'columns' => [
        'title' => 'カラム情報',
        'iteration' => 'No.',
        'comment' => '論理名',
        'name' => '物理名',
        'type' => 'データ型',
        'not_null' => 'Not Null',
        'default' => 'デフォルト',
        'extra' => '備考',
    ],
    'indexes' => [
        'title' => 'インデックス情報',
        'iteration' => 'No.',
        'constraint_name' => 'インデックス情報',
        'column_name' => 'カラムリスト',
        'primary' => '主キー',
        'unique' => 'ユニーク',
        'extra' => '備考',
    ],
    'referencing' => [
        'title' => '外部キー情報',
        'iteration' => 'No.',
        'constraint_name' => 'インデックス情報',
        'referencing_column_name' => 'カラムリスト',
        'referenced_table_name' => '参照先テーブル名',
        'referenced_column_name' => '参照先カラムリスト',
    ],
    'referenced' => [
        'title' => '外部キー情報(PK側)',
        'iteration' => 'No.',
        'constraint_name' => 'インデックス情報',
        'referenced_column_name' => 'カラムリスト',
        'table_name' => '参照元テーブル名',
        'referencing_column_name' => '参照元カラムリスト',
    ],
];