@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
    <div class="attendance__contents">
        <p class="greeting">さんお疲れ様です！</p>
        <div class="attendance__working">
            <form class="attendance__button" action="/work/start" method="post">
            @csrf
                <button class="attendance__button-submit" type="submit">勤務開始</button>
            </form>
            <form class="attendance__button" action="/work/end" method="post">
            @csrf
                <button class="attendance__button-submit" type="submit">勤務終了</button>
            </form>
        </div>
        <div class="attendance__breaking">
            <form class="attendance__button" action="/break/start" method="post">
            @csrf
                <button class="attendance__button-submit" type="submit">休憩開始</button>
            </form>
            <form class="attendance__button" action="/break/end" method="post">
            @csrf
                <button class="attendance__button-submit" type="submit">休憩終了</button>
            </form>
        </div>
    </div>
@endsection
