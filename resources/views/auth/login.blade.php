@extends('layouts.authentication.master')
@section('title', 'Login')

@section('css')

@endsection

@section('style')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/sweetalert2.css')}}">
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12 p-0">
            <div class="login-card">
                <div>
                    <div>
                        <a class="logo text-start" href="{{ route('/') }}">
                            <img class="img-fluid for-light" src="{{asset('assets/images/logo/login.png')}}" alt="looginpage">
                            <img class="img-fluid for-dark" src="{{asset('assets/images/logo/logo_dark.png')}}" alt="looginpage">
                            {{-- <img class="img-fluid for-light" src="{{asset(config('settings.site_logo'))}}" alt="looginpage"> --}}
                        </a>
                    </div>
                    <div class="login-main">
                        <form class="theme-form needs-validation @error('email') was-validated @enderror" novalidate="" method="POST" action="{{ route('login') }}">
                            @csrf
                            <h4>Sign in to account</h4>
                            <p>Enter your email & password to login</p>
                            <div class="form-group">
                                <label class="col-form-label">Email Address</label>
                                <input class="form-control email @error('email') is-invalid @enderror" type="email" id="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="name@email.com">
                                @error('email')
                                    <div class="invalid-feedback" style="display:block;">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">Password</label>
                                <input class="form-control pwd @error('password') is-invalid @enderror" type="password" id="password" name="password" required autocomplete="current-password" placeholder="*********">
                                @error('password')
                                    <div class="invalid-feedback" style="display:block;">{{ $message }}</div>
                                @enderror
                                <div class="show-hide" style="top: 70%;">
                                    <span class="show"></span>
                                </div>
                            </div>
                            <div class="form-group mb-0">
                                <div class="checkbox p-0">
                                    <input name="remember" id="remember" type="checkbox" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="text-muted" for="remember">Remember password</label>
                                </div>
                                @if (Route::has('password.request'))
                                <a class="link" href="{{ route('password.request') }}">Forgot password?</a>
                                @endif
                                <button class="btn btn-primary btn-block" id="error">Sign in</button>
                            </div>
                            <p class="mt-4 mb-0">Don't have account?<a class="ms-2" href="#">Please Contact Admin</a></p>
                            <script>
                                (function() {
                                    'use strict';
                                    window.addEventListener('load', function() {
                                        // Fetch all the forms we want to apply custom Bootstrap validation styles to
                                        var forms = document.getElementsByClassName('needs-validation');
                                        // Loop over them and prevent submission
                                        var validation = Array.prototype.filter.call(forms, function(form) {
                                            form.addEventListener('submit', function(event) {
                                                if (form.checkValidity() === false) {
                                                    event.preventDefault();
                                                    event.stopPropagation();
                                                }
                                                form.classList.add('was-validated');
                                            }, false);
                                        });
                                    }, false);
                                })();
                            </script>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
@endsection
