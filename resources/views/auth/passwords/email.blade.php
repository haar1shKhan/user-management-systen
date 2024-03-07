@extends('layouts.authentication.master')
@section('title', 'Forget-password')

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
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                     <form class="theme-form" method="POST" action="{{ route('password.email') }}">
                        @csrf
                        <h4>Reset Your Password</h4>
                        <div class="form-group">
                           <label class="col-form-label">Enter Your Email Address</label>
                           <div class="row">
                              <div class="col-12">
                                <input class="form-control email @error('email') is-invalid @enderror" type="email" id="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="name@email.com">
                                @error('email')
                                    <div class="invalid-feedback" style="display:block;">{{ $message }}</div>
                                @enderror
                              </div>
                              <div class="col-12">
                                 <button class="btn btn-primary btn-block m-t-10" type="submit">Send</button>
                              </div>
                           </div>
                        </div>
                        <p class="mt-4 mb-0">Already have an password?<a class="ms-2" href="{{ route('login') }}">Sign in</a></p>
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
<script src="{{ asset('assets/js/sidebar-menu.js')}}"></script>
@endsection
