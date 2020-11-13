@extends('layouts.login-app')
@section('title', __('global.login'))

@section('content')
    <div class="content">
        <header class="content-header">
            <div class="logo">
                <span class="text-hide">{{ config('app.name') }}</span>
            </div>
            <span class="cta-title">
                    Sign in
                </span>
            <span class="cta-subtitle">
				    With Your Account
                </span>
        </header>
        <form autocomplete="off" action="{{ route('backpack.auth.login') }}" method="post" name="loginform" id="loginform" class="login-form">
            @csrf
            <div id="content">
                <div class="form-group">
                    <label for="username">
                        Enter your email
                    </label>
                    <input
                        class="form-control form-control--username {{ $errors->has('email') ? ' is-invalid' : '' }}"
                        type="text"
                        name="email"
                        id="email"
                        required
                        autocomplete="email"
                        autofocus
                        value="{{ old('email', null) }}"
                    />
                    <em class="form-control-icon form-control-icon--username"></em>
                </div>
                <div class="form-group">
                    <label for="password">
                        Password
                    </label>
                    <input
                        autocomplete="off"
                        id="password"
                        name="password"
                        type="password"
                        class="form-control form-control--password {{ $errors->has('password') ? ' is-invalid' : '' }}"
                        required
                    />
                    <em class="form-control-icon form-control-icon--password"></em>
                </div>

                <button type="submit" class="btn btn-primary" id="loginButton">
                    {{ trans('global.login') }}
                </button>
            </div>

            <footer class="content-footer">
                <nav class="footer-navigation">
                    @if(Route::has('password.request'))
                        <a class="footer-navigation-item" href="{{ route('backpack.auth.password.reset') }}">
                            {{ trans('base.forgot_your_password') }}
                        </a>
                    @endif

                    @if(Route::has('register'))

                        <div class="footer-navigation-item">
                            No account yet?
                            <a href="{{ route('backpack.auth.register') }}">
                                {{ __('global.register') }}
                            </a>
                        </div>
                    @endif

                </nav>
            </footer>
        </form>
    </div>
@endsection
