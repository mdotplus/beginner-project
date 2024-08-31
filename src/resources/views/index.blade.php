@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
    <div class="attendance__contents">
        <p class="greeting">{{ $user['name'] }} さんお疲れ様です！{{ $user['status'] }}</p>
        <div class="attendance__working">
            <form class="attendance__button" action="/timestamp" method="post">
                @csrf
                <input type="hidden" name="action" value="work_start">
                <input type="hidden" name="user_id" value="{{ $user['id'] }}">
                <button class="attendance__button-submit" type="submit"
                {{ $user['status'] === 'not working' ? '' : 'disabled' }}>
                    勤務開始
                </button>
            </form>
            <form class="attendance__button" action="/timestamp" method="post">
                @csrf
                <input type="hidden" name="action" value="work_end">
                <input type="hidden" name="user_id" value="{{ $user['id'] }}">
                <button class="attendance__button-submit" type="submit"
                {{ $user['status'] === 'working' ? '' : 'disabled' }}>
                    勤務終了
                </button>
            </form>
        </div>
        <div class="attendance__breaking">
            <form class="attendance__button" action="/timestamp" method="post">
                @csrf
                <input type="hidden" name="action" value="break_start">
                <input type="hidden" name="user_id" value="{{ $user['id'] }}">
                <button class="attendance__button-submit" type="submit"
                {{ $user['status'] === 'working' ? '' : 'disabled' }}>
                    休憩開始
                </button>
            </form>
            <form class="attendance__button" action="/timestamp" method="post">
                @csrf
                <input type="hidden" name="action" value="break_end">
                <input type="hidden" name="user_id" value="{{ $user['id'] }}">
                <button class="attendance__button-submit" type="submit"
                {{ $user['status'] === 'breaking' ? '' : 'disabled' }}>
                    休憩終了
                </button>
            </form>
        </div>
    </div>
@endsection
