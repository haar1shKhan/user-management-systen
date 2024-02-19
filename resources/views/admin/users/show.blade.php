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
            <a href="{{route('admin.user.edit',['user'=>$user->id])}}"><h4><i class="icon-pencil-alt"></i></h4></a>
            <a href="{{ url('admin/users') }}" class="btn btn-primary">Back</a>
        </div>

        @if($user->profile->image)
            <div class="row mb-4 d-flex align-items-center">
                <img src="{{ asset('storage/profile_images/'.$user->profile->image) }}" alt="Profile Picture" class="rounded-circle media profile-media" style="max-width: 150px; max-height: 150px;">
                <div class="col-md-8">
                    <h2>{{$user->first_name}} {{$user->last_name}} 
                        @if($user->jobDetail)       
                            @if ($user->jobDetail->status == 'active')
                            <span class="text-success">(Active)</span>
                            @elseif ($user->jobDetail->status == 'resigned')
                            <span class="text-danger">(Resigned)</span>
                            @elseif ($user->jobDetail->status=='terminated')
                            <span class="text-danger">(Terminated)</span>
                            @else
                            <span class="text-muted">(Deceased)</span>
                            @endif
                        @endif
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
            <img height="40px" width="40px" class="rounded-circle media profile-media" style="max-width: 150px; max-height: 150px;" src="{{ asset('storage/profile_images/placeholder.png') }}" alt="">                
                <div class="col-md-6">
                    <h2>{{$user->first_name}} {{$user->last_name}} 
                        @if($user->jobDetail)       
                            @if ($user->jobDetail->status == 'active')
                            <span class="text-success">(Active)</span>
                            @elseif ($user->jobDetail->status == 'resigned')
                            <span class="text-danger">(Resigned)</span>
                            @elseif ($user->jobDetail->status=='terminated')
                            <span class="text-danger">(Terminated)</span>
                            @else
                            <span class="text-muted">(Deceased)</span>
                            @endif
                        @endif
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
                    <p>{{$user->profile->biography}}</p>
                </div>
            </div>
        @endif

        <div class="row mb-4">
            <div class="col-md-10">
                <h4>Job Details</h4>
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
                    <td>{{$user->profile->phone ?? 'N/A' }}{{$user->profile->mobile ? ', '.$user->profile->mobile:''}}</td>
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
                    <th>Hired at</th>
                    <td>{{ $user->jobDetail->hired_at ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Joined at</th>
                    <td>{{ $user->jobDetail->joined_at ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Resigned at</th>
                    <td>{{ $user->jobDetail->resigned_at ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Source of hire</th>
                    <td>{{ $user->jobDetail->source_of_hire ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Job type</th>
                    <td>{{ $user->jobDetail->job_type ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Education</th>
                    <td>{{ $user->jobDetail->education ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Work Expirence</th>
                    <td>{{ $user->jobDetail->work_experience ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Salary</th>
                    <td>{{ $user->jobDetail->salary ?? 'N/A' }}</td>
                </tr>
            </tbody>
        </table>
        <div class="row my-4">
            <div class="col-md-10">
                <h4>Passport</h4>
            </div>
        </div>
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <th>Passport Id</th>
                    <td>{{ $user->profile->passport?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Passport Issue Date</th>
                    <td>{{ $user->profile->passport_issued_at?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Passport Expiry Date</th>
                    <td>{{ $user->profile->passport_expires_at?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>File Attachment</th>
                    <div class="modal fade" id="passport" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                           <div class="modal-content">
                            

                                <embed src="{{ asset('storage/visa_files/'.$user->profile->passport_file) }}" width="800px" height="2100px" />

                            
                           </div>
                        </div>
                     </div>
                    <td data-bs-toggle="modal" data-bs-target="#passport" class="file_view">{{ $user->profile->passport_file?? 'N/A' }}</td>
                </tr>
            </tbody>
        </table>
        <div class="row my-4">
            <div class="col-md-10">
                <h4>Emirates ID</h4>
            </div>
        </div>
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <th>Emirates Id</th>
                    <td>{{ $user->profile->nid?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Emirates Issue Date</th>
                    <td>{{ $user->profile->nid_issued_at?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Emirates Expiry Date</th>
                    <td>{{ $user->profile->nid_expires_at?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>File Attachment</th>
                    <div class="modal fade" id="nid" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                           <div class="modal-content">
                            

                                <embed src="{{ asset('storage/nid_files/'.$user->profile->nid_file) }}" width="800px" height="2100px" />

                            
                           </div>
                        </div>
                     </div>
                    <td data-bs-toggle="modal" data-bs-target="#nid" class="file_view">{{ $user->profile->nid_file?? 'N/A' }}</td>
                </tr>
            </tbody>
        </table>
        <div class="row my-4">
            <div class="col-md-10">
                <h4>Visa <span class="badge badge-danger">Expired</span></h4>
            </div>
        </div>
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <th>Visa</th>
                    <td>{{ $user->profile->visa?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Visa Issue Date</th>
                    <td>{{ $user->profile->visa_issued_at?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Visa Expiry Date</th>
                    <td>{{ $user->profile->visa_expires_at?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>File Attachment</th>

                    <div class="modal fade" id="visa" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                           <div class="modal-content">
                            

                                <embed src="{{ asset('storage/visa_files/'.$user->profile->visa_file) }}" width="800px" height="2100px" />

                            
                           </div>
                        </div>
                     </div>
                    <td data-bs-toggle="modal" data-bs-target="#visa" class="file_view">{{ $user->profile->visa_file?? 'N/A' }}</td>
                </tr>
            </tbody>
        </table>
        <div class="row my-4">
            <div class="col-md-10">
                <h4>Address</h4>
            </div>
        </div>
        <table class="table table-bordered">
            <tbody>
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
        <div class="row my-4">
            <div class="col-md-10">
                <h4>Bank Account</h4>
            </div>
        </div>
        <table class="table table-bordered">
            <tbody>

                <tr>
                    <th>Bank Name</th>
                    <td>{{ $user->jobDetail->bank_name ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Bank Account Number</th>
                    <td>{{ $user->jobDetail->bank_account_number ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>IBAN</th>
                    <td>{{ $user->jobDetail->iban ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Payment Method</th>
                    <td>{{ $user->jobDetail->payment_method ?? 'N/A' }}</td>
                </tr>
                {{-- Add more fields as needed --}}
            </tbody>
        </table>

    </div>
</div>
@endsection

@section('script')
    

    <script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatables/datatable.custom.js') }}"></script>
@endsection