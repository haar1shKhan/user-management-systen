@extends('layouts.admin')

@section('title', 'Default')

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">

@endsection

@section('style')
<style>
form button.border-none {
    border: none;
    background: none;
    padding: 0;
    cursor: pointer;
    /* Additional styles as needed */
}
</style>
@endsection

@section('breadcrumb-title')
    <h3>{{ trans('admin/user.user') }}</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item active">Change Password</li>
@endsection

@section('content')

<div class="container-fluid">
    <div class="row">
        <!-- Zero Configuration  Starts-->
        <div class="col-sm-12">

       
            <div class="card">
                <div class="card-body">
                    <form action="{{route("admin.change-password.update",['change_password'=>auth()->user()->id])}}" method="POST" class="needs-validation">
                        @csrf
                        @method('PUT')

                        
                        <div class="col-md-6">
                            <label class="form-label" for="current_password">Current Password</label>
                            <input class="form-control" id="current_password" name="current_password" type="password"  required="">
                            {{-- <div class="valid-feedback">Looks good!</div> --}}
                            <div class="text-danger mt-1">
                                @error("current_password")
                                {{$message}}    
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="new_password">New Password</label>
                            <input class="form-control" id="new_password" name="new_password" type="password"  required="">
                            {{-- <div class="valid-feedback">Looks good!</div> --}}
                            <div class="text-danger mt-1">
                                @error("new_password")
                                {{$message}}    
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="new_password_confirmation">Confirm New Password</label>
                            <input class="form-control" id="new_password_confirmation" name="new_password_confirmation" type="password"  required="">
                            {{-- <div class="valid-feedback">Looks good!</div> --}}
                            <div class="text-danger mt-1">
                                @error("new_password_confirmation")
                                {{$message}}    
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-9 offset-md-10">
                                <button class="btn btn-primary" type="submit">Change</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
     
        </div>
        <!-- Zero Configuration  Ends-->     
    </div>
</div>

    <script type="text/javascript">
        var session_layout = '{{ session()->get('layout') }}';
    </script>
@endsection

@section('script')

@endsection