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
.file_view{
    cursor: pointer;
}
</style>
@endsection

@section('breadcrumb-title')
    <h3>User Details</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item active">Users</li>
<li class="breadcrumb-item">{{ $page_title }}</li>
@endsection

@section('content')
<div class="container card">
    <div class="card-body">

        <div class="float-end mb-3 d-flex">
            <a href="{{route('admin.user-account.edit',['user_account'=>$user->id])}}"><h4><i class="icon-pencil-alt"></i></h4></a>
            <a href="{{ url('admin/users') }}" class="btn btn-primary">Back</a>
        </div>

        @if(!empty($user->profile->image))
            <div class="row mb-4 d-flex align-items-center">
                <img src="{{ asset('storage/profile_images/'.$user->profile->image?? "") }}" alt="Profile Picture" class="rounded-circle media profile-media" style="max-width: 150px; max-height: 150px;">
                <div class="col-md-8">
                    <h2>{{$user->first_name ?? "First Name"}} {{$user->last_name ?? "First Name"}} 
                    </h2>
                    <h6>Employee ID: {{$user->id}}</h6>
                    <h6>Email: {{ $user->email }}</h6>
                    <h6>
                     Role: @foreach($user->roles as $role)
                        {{ $role->title ?? 'N/A' }}
                        @endforeach
                    </h6>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-10">
                    <h4>Biography</h4>
                    <p>{{$user->profile->biography}}</p>
                </div>
            </div>
        @else
            <div class="row mb-4 d-flex align-items-center">
            <img height="140px" width="140px" class="rounded-circle media profile-media" style="max-width: 150px; max-height: 150px;" src="{{ asset('storage/profile_images/placeholder.png') }}" alt="">                
                <div class="col-md-6">
                    <h2>{{$user->first_name}} {{$user->last_name}} 
                </h2>
                <h6>Email: {{ $user->email }}</h6>
                <h6>
                   Role: @foreach($user->roles as $role)
                    {{ $role->title ?? 'N/A' }}
                    @endforeach
                </h6>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-10">
                    <h4>Biography</h4>
                    <p>{{$user->profile->biography ?? "No Biography Written"}}</p>
                </div>
            </div>
        @endif

        <div class="row mb-4">
            <div class="col-md-10">
                <h4>Personal Details</h4>
            </div>
        </div>

        <table class="table table-bordered">
            <tbody>
                <tr>
                    <th><h5>User Personal Details</h5></th>
                </tr>
                <tr>
                    <th>Date of Birth</th>
                    <td>{{ $user->profile->date_of_birth ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{$user->email ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Personal Email</th>
                    <td>{{$user->profile->email ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Phone Number</th>
                    <td>{{$user->profile->phone ?? 'N/A' }}{{$user->profile->mobile ?? ""}}</td>
                </tr>
                <tr>
                    <th>Gender</th>
                    <td>{{ $user->profile->gender?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Religion</th>
                    <td>{{ $user->profile->religion?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Marital Status</th>
                    <td>{{ $user->profile->marital_status?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Nationality</th>
                    <td>{{ $user->profile->nationality ?? 'N/A' }}</td>
                </tr>

                <tr>
                    <th>Address</th>
                    <td>{{ $user->profile->address?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Second Address</th>
                    <td>{{ $user->profile->address2?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>City</th>
                    <td>{{ $user->profile->city?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Province/State</th>
                    <td>{{ $user->profile->province?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Country</th>
                    <td>{{ $user->profile->country?? 'N/A' }}</td>
                </tr>
            </tbody>
        </table>
       

    </div>
</div>
@endsection

@section('script')
    

    <script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatables/datatable.custom.js') }}"></script>
@endsection