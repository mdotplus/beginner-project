@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/fortify-common.css') }}">
    <link rel="stylesheet" href="{{ asset('css/verify-email.css') }}">
@endsection

@section('content')
    <div class="verify-body verify-contents">
        <p>ログイン認証メールを送信しました</p>
        <p>60分以内に認証を行ってください</p>
    </div>
    <div class="verify-body verify-again">
        <p>メールが届いていませんか？</p>
        <p>もう一度認証メールを送信する場合はこちらをクリック</p>
        <form action="/email/verification-notification" method="post">
            @csrf
            <button class="button-resend" type="submit">認証メールを再送信</button>
        </form>
    </div>
@endsection
