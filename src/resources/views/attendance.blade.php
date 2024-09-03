@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/attendance.css') }}">
@endsection

@section('content')
    <div class="date-paginator">
        <form class="next-date" action="/attendance" method="post">
            @csrf
            <input type="hidden" name="targetDate" value="{{ date("Y-m-d", strtotime("$fixedDate -1 day")) }}">
            <button class="date-paginator__button date-paginator__button--next" type="submit">
                ＜
            </button>
        </form>
        <span>{{ $fixedDate }}</span>
        <form class="previous-date" action="/attendance" method="post">
            @csrf
            <input type="hidden" name="targetDate" value="{{ date("Y-m-d", strtotime("$fixedDate +1 day")) }}">
            <button class="date-paginator__button date-paginator__button--previous" type="submit">
                ＞
            </button>
        </form>
    </div>
    <div class="attendance-table">
        <table class="table-contents">
            <tr class="attendance-table__row">
                <th class="attendance-table__header">名前</th>
                <th class="attendance-table__header">勤務開始</th>
                <th class="attendance-table__header">勤務終了</th>
                <th class="attendance-table__header">休憩時間</th>
                <th class="attendance-table__header">勤務時間</th>
            </tr>
            @foreach ($records as $userName => $userRecords)
                <tr class="attendance-table__row">
                    <td class="attendance-table__item">{{ $userName }}</td>
                    <td class="attendance-table__item">{{ $userRecords['work_start'] }}</td>
                    <td class="attendance-table__item">{{ $userRecords['work_end'] }}</td>
                    <td class="attendance-table__item">{{ $userRecords['breaking'] }}</td>
                    <td class="attendance-table__item">{{ $userRecords['working'] }}</td>
                </tr>
            @endforeach
        </table>
        {{ $records->links() }}
    </div>
@endsection
