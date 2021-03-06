<?php

return [
    'table' => [
        'title' => 'Tables',
        'app_name' => 'App name',
        'sub_system' => 'SUB SYSTEM',
        'creator' => 'Created by',
        'created_at' => 'Created at',
        'updated_at' => 'Updated at',
        'schema_name' => 'Schema name',
        'logical_name' => 'Logical name',
        'physical_name' => 'Physical name',
        'rdbms' => 'RDBMS',
    ],
    'columns' => [
        'title' => 'Columns',
        'iteration' => 'No.',
        'comment' => 'Logical name',
        'name' => 'Physical name',
        'type' => 'Type',
        'not_null' => 'Not Null',
        'default' => 'Default',
        'extra' => 'Extra',
    ],
    'indexes' => [
        'title' => 'Indexes',
        'iteration' => 'No.',
        'constraint_name' => 'Name',
        'column_name' => 'Columns',
        'primary' => 'Primary key',
        'unique' => 'Unique',
        'extra' => 'Extra',
    ],
    'referencing' => [
        'title' => 'Referencing',
        'iteration' => 'No.',
        'constraint_name' => 'Name',
        'referencing_column_name' => 'Columns',
        'referenced_table_name' => 'Referenced table',
        'referenced_column_name' => 'Referenced columns',
    ],
    'referenced' => [
        'title' => 'Referenced',
        'iteration' => 'No.',
        'constraint_name' => 'Name',
        'referenced_column_name' => 'Referenced column',
        'table_name' => 'Referencing table',
        'referencing_column_name' => 'Referencing column',
    ],
];