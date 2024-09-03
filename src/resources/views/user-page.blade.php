@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/user-page.css') }}">
@endsection

@section('content')
    <div class="flex">
        <div class="flex__user">
            <div class="user-table">
                <table class="table-xontents">
                    <tr class="attendance-table__row">
                        <th class="attendance-table__header">名前</th>
                    </tr>
                </table>
            </div>
        </div>
        <div class="flex__attendance">
            <div class="attendance-table">
                <table class="table-xontents">
                    <tr class="attendance-table__row">
                        <th class="attendance-table__header">日付</th>
                        <th class="attendance-table__header">勤務開始</th>
                        <th class="attendance-table__header">勤務終了</th>
                        <th class="attendance-table__header">休憩時間</th>
                        <th class="attendance-table__header">勤務時間</th>
                    </tr>
                </table>
            </div>
        </div>
    </div>
@endsection
