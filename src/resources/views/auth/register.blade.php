@extends('layouts/app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/fortify-common.css') }}">
@endsection

@section('content')
    <div class="body-contents">
        <h2>会員登録</h2>
        <form class="form-contents" action="/register" method="post">
            @csrf
            <input class="input-box" type="text" name="name" value="{{ old('name') }}" placeholder="名前">
            @error('name')
                {{ $message }}
            @enderror
            <input class="input-box" type="email" name="email" value="{{ old('email') }}" placeholder="メールアドレス">
            @error('email')
                {{ $message }}
            @enderror
            <input class="input-box" type="password" name="password" placeholder="パスワード">
            @error('password')
                {{ $message }}
            @enderror
            <input class="input-box" type="password" name="password_confirmation" placeholder="確認用パスワード">
            <button class="button-submit" type="submit">会員登録</button>
        </form>
        <p class="text">アカウントをお持ちの方はこちらから</p>
        <a class="link" href="/login">ログイン</a>
    </div>
@endsection
