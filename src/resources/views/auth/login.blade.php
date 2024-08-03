@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/fortify-common.css') }}">
@endsection

@section('content')
    <div class="body-contents">
        <h2>ログイン</h2>
        <form class="form-contents" action="/login" method="post">
            @csrf
            <input class="input-box" type="email" name="email" value="{{ old('email') }}" placeholder="メールアドレス">
            @error('email')
                {{ $message }}
            @enderror
            <input class="input-box" type="password" name="password" placeholder="パスワード">
            @error('password')
                {{ $message }}
            @enderror
            <button class="button-submit" type="submit">ログイン</button>
        </form>
        <p class="text">アカウントをお持ちでない方はこちらから</p>
        <a class="link" href="/register">会員登録</a>
    </div>
@endsection
