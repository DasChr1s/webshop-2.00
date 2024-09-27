@extends('layouts.app')
@section('title', __('app.register') )
@section('content')
    <main class="register">
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <label for="name">{{ __('app.registerText.name') }}:</label>
            <input type="text" id="name" name="name" required>
            <br>
            <label for="email">{{ __('app.registerText.email') }}:</label>
            <input type="email" id="email" name="email" required>
            <br>
            <label for="password">{{ __('app.registerText.password') }}:</label>
            <input type="password" id="password" name="password" required autocomplete="new-password">
            <br>
            <label for="password_confirmation">{{ __('app.registerText.confirmPassword') }}:</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required autocomplete="new-password">
            <br>
            <button type="submit">
                <img src="{{ asset('logo/cat-icon.png') }}" alt="Icon">
                {{ __('app.registerText.register') }}
            </button>
        </form>
        @if ($errors->any())
            <div>
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif
        <p>{{ __('app.registerText.haveAccount') }} <a href="{{ route('login') }}">{{ __('app.registerText.login') }}</a></p>
    </main>
@endsection


