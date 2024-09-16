@extends('layouts.app')
@section('title', __('app.login') )
@section('content')
    <main class="login main-content">
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <label for="email">{{ __('app.loginText.email') }}:</label>
            <input type="email" id="email" name="email" required>
            <br>
            <label for="password">{{ __('app.loginText.password') }}:</label>
            <input type="password" id="password" name="password" required>
            <br>
            <button type="submit">
                <img src="{{ asset('logo/cat-icon.png') }}" alt="Icon">
                {{ __('app.login') }}</button>
        </form>
        <p>{{ __('app.loginText.noAccount') }} <a href="{{ route('register') }}">{{ __('app.loginText.register') }}</a>
        </p>
        @if ($errors->any())
            <div>
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif
    </main>
@endsection