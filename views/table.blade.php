<div>

    <h3>テーブル情報</h3>

    <table>
        <tbody>
        <tr>
            <th style="background-color: yellowgreen" colspan="2">システム名</th>
            <td colspan="2">{{ config('app.name') }}</td>
            <th style="background-color: #D3F9D8">作成者</th>
            <td colspan="2"></td>
        </tr>
        <tr>
            <th style="background-color: yellowgreen" colspan="2">サブシステム名</th>
            <td colspan="2"></td>
            <th style="background-color: #D3F9D8">作成日</th>
            <td colspan="2">{{ today() }}</td>
        </tr>
        <tr>
            <th style="background-color: yellowgreen" colspan="2">スキーマ名</th>
            <td colspan="2">{{ $table->table_schema }}</td>
            <th style="background-color: #D3F9D8">更新日</th>
            <td colspan="2"></td>
        </tr>
        <tr>
            <th style="background-color: yellowgreen" colspan="2">論理テーブル名</th>
            <td colspan="2">{{ $table->comment }}</td>
            <th style="background-color: #D3F9D8">RDBMS</th>
            <td colspan="2"></td>
        </tr>
        <tr>
            <th style="background-color: yellowgreen" colspan="2">物理テーブル名</th>
            <td colspan="2">{{ $table->name }}</td>
            <th style="background-color: #D3F9D8"></th>
            <td colspan="2"></td>
        </tr>
        </tbody>
    </table>

</div>

<div>

    <h3>カラム情報</h3>

    <table>
        <thead>
        <tr>
            <th style="background-color: yellowgreen">No.</th>
            <th style="background-color: yellowgreen">論理名</th>
            <th style="background-color: yellowgreen">物理名</th>
            <th style="background-color: yellowgreen">データ型</th>
            <th style="background-color: yellowgreen">Not Null</th>
            <th style="background-color: yellowgreen">デフォルト</th>
            <th style="background-color: yellowgreen">備考</th>
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

    <h3>インデックス情報</h3>

    <table>
        <thead>
        <tr>
            <th style="background-color: yellowgreen">No.</th>
            <th style="background-color: yellowgreen" colspan="2">インデックス情報</th>
            <th style="background-color: yellowgreen">カラムリスト</th>
            <th style="background-color: yellowgreen">主キー</th>
            <th style="background-color: yellowgreen">ユニーク</th>
            <th style="background-color: yellowgreen">備考</th>
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
                    @if($index->constraint_type === 'PRIMARY KEY') Yes @endif
                </td>
                <td>
                    @if($index->constraint_type === 'UNIQUE') Yes @endif
                </td>
                <td></td>
            </tr>
        @endforeach
        </tbody>
    </table>

</div>

<div>

    <h3>外部キー情報</h3>

    <table>
        <thead>
        <tr>
            <th style="background-color: yellowgreen">No.</th>
            <th style="background-color: yellowgreen" colspan="2">インデックス情報</th>
            <th style="background-color: yellowgreen">カラムリスト</th>
            <th style="background-color: yellowgreen" colspan="2">参照先テーブル名</th>
            <th style="background-color: yellowgreen">参照先カラムリスト</th>
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

    <h3>外部キー情報(PK側)</h3>

    <table>
        <thead>
        <tr>
            <th style="background-color: yellowgreen">No.</th>
            <th style="background-color: yellowgreen" colspan="2">インデックス情報</th>
            <th style="background-color: yellowgreen">カラムリスト</th>
            <th style="background-color: yellowgreen" colspan="2">参照元テーブル名</th>
            <th style="background-color: yellowgreen">参照元カラムリスト</th>
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