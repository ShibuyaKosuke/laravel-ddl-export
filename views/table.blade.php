<div>

    <h3>{{ __('ddl::ddl.table.title') }}</h3>

    <table>
        <tbody>
        <tr>
            <th style="background-color: yellowgreen" colspan="2">{{ __('ddl::ddl.table.app_name') }}</th>
            <td colspan="2">{{ config('app.name') }}</td>
            <th style="background-color: #D3F9D8">{{ __('ddl::ddl.table.creator') }}</th>
            <td colspan="2"></td>
        </tr>
        <tr>
            <th style="background-color: yellowgreen" colspan="2">{{ __('ddl::ddl.table.sub_system') }}</th>
            <td colspan="2"></td>
            <th style="background-color: #D3F9D8">{{ __('ddl::ddl.table.created_at') }}</th>
            <td colspan="2">{{ today() }}</td>
        </tr>
        <tr>
            <th style="background-color: yellowgreen" colspan="2">{{ __('ddl::ddl.table.schema_name') }}</th>
            <td colspan="2">{{ $table->table_schema }}</td>
            <th style="background-color: #D3F9D8">{{ __('ddl::ddl.table.updated_at') }}</th>
            <td colspan="2"></td>
        </tr>
        <tr>
            <th style="background-color: yellowgreen" colspan="2">{{ __('ddl::ddl.table.logical_name') }}</th>
            <td colspan="2">{{ $table->comment }}</td>
            <th style="background-color: #D3F9D8">{{ __('ddl::ddl.table.rdbms') }}</th>
            <td colspan="2"></td>
        </tr>
        <tr>
            <th style="background-color: yellowgreen" colspan="2">{{ __('ddl::ddl.table.physical_name') }}</th>
            <td colspan="2">{{ $table->name }}</td>
            <th style="background-color: #D3F9D8"></th>
            <td colspan="2"></td>
        </tr>
        </tbody>
    </table>

</div>

<div>

    <h3>{{ __('ddl::ddl.columns.title') }}</h3>

    <table>
        <thead>
        <tr>
            <th style="background-color: yellowgreen">{{ __('ddl::ddl.columns.iteration') }}</th>
            <th style="background-color: yellowgreen">{{ __('ddl::ddl.columns.comment') }}</th>
            <th style="background-color: yellowgreen">{{ __('ddl::ddl.columns.name') }}</th>
            <th style="background-color: yellowgreen">{{ __('ddl::ddl.columns.type') }}</th>
            <th style="background-color: yellowgreen">{{ __('ddl::ddl.columns.not_null') }}</th>
            <th style="background-color: yellowgreen">{{ __('ddl::ddl.columns.default') }}</th>
            <th style="background-color: yellowgreen">{{ __('ddl::ddl.columns.extra') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($table->columns as $column)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $column->comment }}</td>
                <td>{{ $column->name }}</td>
                <td>{{ $column->type }}</td>
                <td>{{ $column->not_null ? 'Yes' : '' }}</td>
                <td>{{ $column->default }}</td>
                <td></td>
            </tr>
        @endforeach
        </tbody>
    </table>

</div>

<div>

    <h3>{{ __('ddl::ddl.indexes.title') }}</h3>

    <table>
        <thead>
        <tr>
            <th style="background-color: yellowgreen">{{ __('ddl::ddl.indexes.iteration') }}</th>
            <th style="background-color: yellowgreen" colspan="2">{{ __('ddl::ddl.indexes.constraint_name') }}</th>
            <th style="background-color: yellowgreen">{{ __('ddl::ddl.indexes.column_name') }}</th>
            <th style="background-color: yellowgreen">{{ __('ddl::ddl.indexes.primary') }}</th>
            <th style="background-color: yellowgreen">{{ __('ddl::ddl.indexes.unique') }}</th>
            <th style="background-color: yellowgreen">{{ __('ddl::ddl.indexes.extra') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($table->indexes as $index)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td colspan="2">{{ $index->constraint_name }}</td>
                <td>
                    {{ $index->column_name }}
                </td>
                <td>
                    @if($index->isPrimary()) Yes @endif
                </td>
                <td>
                    @if($index->isUnique()) Yes @endif
                </td>
                <td></td>
            </tr>
        @endforeach
        </tbody>
    </table>

</div>

<div>

    <h3>{{ __('ddl::ddl.referencing.title') }}</h3>

    <table>
        <thead>
        <tr>
            <th style="background-color: yellowgreen">{{ __('ddl::ddl.referencing.iteration') }}</th>
            <th style="background-color: yellowgreen" colspan="2">{{ __('ddl::ddl.referencing.constraint_name') }}</th>
            <th style="background-color: yellowgreen">{{ __('ddl::ddl.referencing.referencing_column_name') }}</th>
            <th style="background-color: yellowgreen" colspan="2">{{ __('ddl::ddl.referencing.referenced_table_name') }}</th>
            <th style="background-color: yellowgreen">{{ __('ddl::ddl.referencing.referenced_column_name') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($table->referencing as $constraint)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td colspan="2">{{ $constraint->constraint_name }}</td>
                <td>{{ $constraint->referencing_column_name }}</td>
                <td colspan="2">{{ $constraint->referenced_table_name }}</td>
                <td>{{ $constraint->referenced_column_name }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

</div>

<div>

    <h3>{{ __('ddl::ddl.referenced.title') }}</h3>

    <table>
        <thead>
        <tr>
            <th style="background-color: yellowgreen">{{ __('ddl::ddl.referenced.iteration') }}</th>
            <th style="background-color: yellowgreen" colspan="2">{{ __('ddl::ddl.referenced.constraint_name') }}</th>
            <th style="background-color: yellowgreen">{{ __('ddl::ddl.referenced.referenced_column_name') }}</th>
            <th style="background-color: yellowgreen" colspan="2">{{ __('ddl::ddl.referenced.table_name') }}</th>
            <th style="background-color: yellowgreen">{{ __('ddl::ddl.referenced.referencing_column_name') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($table->referenced as $constraint)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td colspan="2">{{ $constraint->constraint_name }}</td>
                <td>{{ $constraint->referenced_column_name }}</td>
                <td colspan="2">{{ $constraint->table_name }}</td>
                <td>{{ $constraint->referencing_column_name }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

</div>