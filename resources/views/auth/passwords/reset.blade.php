



@extends('layouts.authentication.master')
@section('title', 'Reset-password')

@section('css')
@endsection

@section('style')
@endsection


@section('content')
<!-- tap on top starts-->
<div class="tap-top"><i data-feather="chevrons-up"></i></div>
<!-- tap on tap ends-->
<!-- page-wrapper Start-->
<div class="page-wrapper">
   <div class="container-fluid p-0">
      <div class="row">
         <div class="col-12">
            <div class="login-card">
               <div>
                  <div><a class="logo" href="{{ route('/') }}">
                     <img class="img-fluid for-light" src="{{asset(config('settings.site_logo'))}}" alt="looginpage">
                            <img class="img-fluid for-dark" src="{{asset(config('settings.site_logo'))}}" alt="looginpage">
                  </a></div>
                  <div class="login-main">
                     <form class="theme-form" method="POST" action="{{ route('password.update') }}">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">
                        <h4>Create Your Password</h4>
                        <div class="form-group">
                           <label class="col-form-label">Email Address</label>
                           <input class="form-control email @error('email') is-invalid @enderror" type="email" id="email" name="email" value="{{ $email ?? old('email') }}" @if ($email) readonly @endif required autocomplete="email" autofocus placeholder="name@email.com">
                            @error('email')
                                <div class="invalid-feedback" style="display:block;">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                           <label class="col-form-label">New Password</label>
                           <input class="form-control @error('password') is-invalid @enderror" type="password" id="password" name="password" placeholder="*********" required autocomplete="new-password">
                           @error('password')
                                <div class="invalid-feedback" style="display:block;">{{ $message }}</div>
                            @enderror
                           <div class="show-hide" style="top: 70%;">
                                <span class="show"></span>
                            </div>
                        </div>
                        <div class="form-group">
                           <label class="col-form-label">Retype Password</label>
                           <input class="form-control" type="password" id="password-confirm" name="password_confirmation" placeholder="*********" required autocomplete="new-password">
                        </div>
                        <div class="form-group mb-0">
                           <div class="checkbox p-0">
                              <input id="checkbox1" type="checkbox">
                              <label class="text-muted" for="checkbox1">Remember password</label>
                           </div>
                           <button class="btn btn-primary btn-block" type="submit">Done                          </button>
                        </div>
                        <p class="mt-4 mb-0">Don't have account?<a class="ms-2" href="#">Please Contact Admin</a></p>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection

@section('script')

@endsection
