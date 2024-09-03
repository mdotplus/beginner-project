@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/user-page.css') }}">
@endsection

@section('content')
    <div class="flex">
        <div class="flex__user">
            <div class="user-table">
                <table class="table-contents">
                    <tr class="table-row">
                        <th class="attendance-table__header">名前</th>
                    </tr>
                    @foreach ($users as $user)
                        <tr class="table-row">
                            <td class="attendance-table__header">
                                <form action="/userpage" method="post">
                                    @csrf
                                    <input type="hidden" name="userName" value="{{ $user->name }}">
                                    <button class="button-submit {{ empty($targetUser) ? "" : ($targetUser === $user->name ? "target" : "") }}" type="submit">
                                        {{ $user->name }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
        <div class="flex__attendance">
            <div class="attendance-table">
                <table class="table-contents">
                    <tr class="table-row">
                        <th class="attendance-table__header">日付</th>
                        <th class="attendance-table__header">勤務開始</th>
                        <th class="attendance-table__header">勤務終了</th>
                        <th class="attendance-table__header">休憩時間</th>
                        <th class="attendance-table__header">勤務時間</th>
                    </tr>
                    @if (!empty($records))
                        @foreach ($records as $userName => $userRecords)
                            <tr class="table-row">
                                <td class="attendance-table__item">{{ $userName }}</td>
                                <td class="attendance-table__item">{{ $userRecords['work_start'] }}</td>
                                <td class="attendance-table__item">{{ $userRecords['work_end'] }}</td>
                                <td class="attendance-table__item">{{ $userRecords['breaking'] }}</td>
                                <td class="attendance-table__item">{{ $userRecords['working'] }}</td>
                            </tr>
                        @endforeach
                    @endif
                </table>
            </div>
            @if (empty($records))
                <span>ユーザーを選択してください</span>
            @endif
        </div>
    </div>
@endsection
