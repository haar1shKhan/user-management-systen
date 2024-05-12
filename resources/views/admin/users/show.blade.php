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
@media (min-width: 768px) {
        h5.phone {
            display: none; /* Hide h5 on larger screens */
        }
    }

    /* Media query for screens smaller than 768 pixels (typical for phones) */
    @media (max-width: 767px) {
        h2.pc {
            display: none; /* Hide h2 on smaller screens */
        }
    }
    #new_entitlement_div {
        display: none;
    }
</style>
@endsection

@section('breadcrumb-title')
    <h3>User Details</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item">System</li>
<li class="breadcrumb-item">User Management</li>
<li class="breadcrumb-item">User</li>
<li class="breadcrumb-item active">{{ $page_title }}</li>
@endsection

@section('content')
@if (session('status'))
    <div class="alert alert-warning " role="alert">
        {{ session('status') }}
    </div>
@endif
<div class="container card">
    <div class="card-body">

        <div class="modal fade" id="passport" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
            <div class="modal-dialog" role="document">
               <div class="modal-content">
                

                    <embed src="{{ asset('storage/passport_files/'.$user->profile->passport_file) }}" width="800px" height="2100px" />

                
               </div>
            </div>
         </div>

         <div class="modal fade" id="nid" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
            <div class="modal-dialog" role="document">
               <div class="modal-content">
                

                    <embed src="{{ asset('storage/nid_files/'.$user->profile->nid_file) }}" width="800px" height="2100px" />

                
               </div>
            </div>
         </div>

         <div class="modal fade" id="visa" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
            <div class="modal-dialog" role="document">
               <div class="modal-content">
                

                    <embed src="{{ asset('storage/visa_files/'.$user->profile->visa_file) }}" width="800px" height="2100px" />

                
               </div>
            </div>
         </div>

        <div class="row ">
            <div class=" mb-3  d-flex justify-content-end align-items-center">
                <a class="mx-2" href="{{route('admin.user.edit',['user'=>$user->id])}}"><h4><i class="icon-pencil-alt"></i></h4></a>
                <a href="{{ url('admin/users') }}" class="btn btn-primary">Back</a>
            </div>
        </div>

        @if($user->profile->image)
            <div class="row mb-4 d-flex align-items-center">
                <div class="media profile-media col-md-2">
                    <img height="140px" width="150px" class="rounded-circle media profile-media" style="max-width: 150px; max-height: 150px;"  src="{{ asset('storage/profile_images/'.$user->profile->image) }}" alt="">
                </div>
                {{-- <img  alt="Profile Picture" class="rounded-circle media profile-media" style="max-width: 150px; max-height: 150px;"> --}}
                <div class="col-md-8">
                    <h2 class="pc">{{ucwords($user->first_name)}} {{ucwords($user->last_name)}}
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
                    <h5 class="phone my-2">{{ucwords($user->first_name)}} {{ucwords($user->last_name)}}
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
                    </h5>
                    <h6>Employee ID: {{$user->id}}</h6>
                    <h6>Email: {{ $user->email }}</h6>
                    <h6>
                        Role: @foreach($user->roles as $role)
                        {{ $role->title ?? 'N/A' }}
                        @endforeach
                    </h6>
                    <h6>{{ $user->jobDetail->supervisor?"Reporting to: ".$user->jobDetail->supervisor->first_name." ".$user->jobDetail->supervisor->last_name:""}}</h6>
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
                <div class="media profile-media col-md-2">
                    <img height="140px" width="150px" class="rounded-circle media profile-media" style="max-width: 150px; max-height: 150px;"  src="{{ asset('assets/images/placeholder.png') }}" alt="">
                </div>
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
           <div class="my-5">
            <ul class="nav nav-tabs" id="icon-tab" role="tablist">
                <li class="nav-item"><a class="nav-link active" id="personal-details-tab" data-bs-toggle="tab"
                        href="#personal-details" role="tab" aria-controls="personal-details" aria-selected="true"><i
                            class="icofont icofont-man-in-glasses"></i>Personal details</a></li>

                <li class="nav-item"><a class="nav-link" id="job-details-tab" data-bs-toggle="tab"
                        href="#job-details" role="tab" aria-controls="profile-icon"
                        aria-selected="false"><i class="icofont icofont-briefcase"></i>Job details</a></li>

                <li class="nav-item"><a class="nav-link" id="contact-icon-tab" data-bs-toggle="tab"
                        href="#document-legal" role="tab" aria-controls="contact-icon"
                        aria-selected="false"><i class="icofont icofont-document-search"></i>Legal document and Bank details</a></li>

                <li class="nav-item"><a class="nav-link" id="long-leave-tab" data-bs-toggle="tab"
                        href="#long-leave" role="tab" aria-controls="long-leave"
                        aria-selected="false"><i class="icofont icofont-list"></i>جميع الاجازات </a></li>
                        
                <li class="nav-item"><a class="nav-link" id="short-leave-tab" data-bs-toggle="tab"
                        href="#short-leave" role="tab" aria-controls="short-leave"
                        aria-selected="false"><i class="icofont icofont-list"></i>اذن خروج</a></li>

                <li class="nav-item"><a class="nav-link" id="late-attendance-tab" data-bs-toggle="tab"
                        href="#late-attendance" role="tab" aria-controls="late-attendance"
                        aria-selected="false"><i class="icofont icofont-list"></i>تأخر عن العمل </a></li>

                <li class="nav-item"><a class="nav-link" id="entitlement-year-tab" data-bs-toggle="tab"
                    href="#entitlement_year_tab" role="tab" aria-controls="entitlement_year_tab"
                    aria-selected="false"><i class="icofont icofont-user-search"></i>Employee Entitlement</a></li>

            </ul>

            <div class="tab-content" id="icon-tabContent">
                <div class="tab-pane fade show active" id="personal-details" role="tabpanel"
                    aria-labelledby="personal-details-tab">
                    <table class="table table-bordered">
                        <div class="row my-4">
                            <div class="col-md-10">
                                <h4>Personal Details</h4>
                            </div>
                        </div>
                        <tbody>
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
                </div>

                <div class="tab-pane fade" id="job-details" role="tabpanel"
                    aria-labelledby="job-details-tabs">
                    <div class="row my-4">
                        <div class="col-md-10">
                            <h4>Job details</h4>
                        </div>
                    </div>
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th>Status</th>
                                <td>{{ $user->jobDetail->status ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Reporting to</th>
                                <td>{{ $user->jobDetail->supervisor? $user->jobDetail->supervisor->first_name." ".$user->jobDetail->supervisor->last_name:"N/A"}}</td>
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
                                <th>Salary</th>
                                <td>{{ $user->jobDetail->salary ?? 'N/A' }}</td>
                            </tr>
                        </tbody>
                    </table>

                </div>

                <div class="tab-pane fade" id="document-legal" role="tabpanel"
                    aria-labelledby="contact-icon-tab">
                    <div class="row my-4">
                        <div class="col-md-10">
                            <h4>
                                Passport
                                @if(now()->greaterThan($user->profile->passport_expires_at))
                                    <span class="badge badge-danger">Expired</span>
                                @endif
                            </h4>
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
                                <td @if(!empty($user->profile->passport_file)) data-bs-toggle="modal" data-bs-target="#passport" @endif class="file_view">{{ $user->profile->passport_file?? 'N/A' }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="row my-4">
                        <div class="col-md-10">
                                <h4>
                                    Emirates ID
                                    @if(now()->greaterThan($user->profile->nid_expires_at))
                                        <span class="badge badge-danger">Expired</span>
                                    @endif
                                </h4>
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
                                <td @if(!empty($user->profile->nid_file)) data-bs-toggle="modal" data-bs-target="#nid"  @endif class="file_view">{{ $user->profile->nid_file?? 'N/A' }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="row my-4">
                        <div class="col-md-10">
                            <h4>
                                Visa 
                                @if(now()->greaterThan($user->profile->visa_expires_at))
                                    <span class="badge badge-danger">Expired</span>
                                @endif
                            </h4>
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
                                <td @if(!empty($user->profile->visa_file)) data-bs-toggle="modal" data-bs-target="#visa" @endif class="file_view">{{ $user->profile->visa_file?? 'N/A' }}</td>
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

                <div class="tab-pane fade" id="long-leave" role="tabpanel"
                    aria-labelledby="long-leave-tab">
                    <div class="d-flex justify-content-between align-items-center mt-4">

                        @php
                            $totalLeaveDays = 0;
                            $totalTaken = 0;
                           foreach($leaveEntitlement as $leaveDays){
                                $totalLeaveDays += $leaveDays->days;
                                $totalTaken += $leaveDays->leave_taken;
                           }
                        @endphp

                        {{-- @can('role_delete') --}}
                        <div class="d-flex flex-column">
                            <span style="font-weight: 500 ; " class="mb-2" >Total Leaves days : {{$totalLeaveDays}}</span>
                            <span style="font-weight: 500 ; " >Total Leaves Takens : {{$totalTaken}}</span>
                        </div>

                        <div>
                                @can("long_leave_create")
                                    
                                    <button class="btn btn-primary mx-1" type="button" data-bs-toggle="modal" data-bs-target=".bd-example-modal-lg">أضف إجازة</button>
                            
                                    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title" id="myLargeModalLabel">أضف إجازة<span class="text-danger">{{$error??""}}</span></h4>
                                                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>

                                            
                                                <form enctype="multipart/form-data" action="{{route('admin.'.$url.".store_long_leave",['user'=>$user->id])}}" method="POST" class="modal-content">
                                                @csrf
                                                
                                                <div class="modal-body">
                                                    <div class="">
                                                        <div class="row d-flex align-items-end">
                                                            <div class="col-md-8">
                                                                    <label class="col-form-label">استحقاق الإجازة</label>
                                                                    <select name="entit_id" class="form-select" id="policy_id" required="">
                                                                        <option selected="true" disabled value="">Choose...</option>
                                                                        @foreach ($leaveEntitlement as $leaveType)
                                                                                @php
                                                                                    // remaining = total - num of current month * (total/12)

                                                                                    // $expired = ($value->days/12) * $last_month - $leave_taken;
                                                                                    // $remaining = ($value->days - $value->leave_taken) - $expired
                                                                                    if($leaveType->policy->monthly){
                                                                                        $leave_taken = 0;
                                                                                        
                                                                                        foreach ($longLeave as $leave) {
                                                                                            if ($leave->approved == 1 && $leaveType->policy->id == $leave->entitlement->policy->id) {
                                                                                                $fromDate = Carbon\Carbon::parse($leave->from);
                                                                                                $month = $fromDate->month ;
                                                                                                $toDate = Carbon\Carbon::parse($leave->to);
                                                                                                if($month <= $lastMonth){
                                                                                                    $leave_taken += $fromDate->diffInDays($toDate);
                                                                                                }
                                                                                            }
                                                                                            }

                                                                                        $totalDays = $leaveType->days;
                                                                                        $expired = ($totalDays/12) * $lastMonth - $leave_taken ;
                                                                                        $remainingDays = ($totalDays - $leaveType->leave_taken) - $expired  ;
                                                                                        // $remainingDays =  $leave_taken ;
                                                                                    } else {
                                                                                        $totalDays = $leaveType->days;
                                                                                        $remainingDays = $totalDays - $leaveType->leave_taken;  
                                                                                    }
                                                                                
                                                                                
                                                                                @endphp 
                                                                            <option class="py-3" value="{{ $leaveType->id }}" data-monthly="{{ $leaveType->policy->monthly }}" data-advance-salary="{{ $leaveType->policy->advance_salary }}" 
                                                                            data-number-of-days="@if($leaveType->policy->monthly) {{$totalDays/12}} @else{{$remainingDays}}@endif">
                                                                                {{ $leaveType->policy->title."  -  ".date('M Y', strtotime($leaveType->start_year))." to ".date('M Y', strtotime($leaveType->end_year))}}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>    
                                                                <div class="text-danger mt-1">
                                                                    @error("entit_id")
                                                                    {{$message}}    
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row" id="longLeaveFields">
                                                            <div class="col-md-4">
                                                                <label class="col-form-label">تاريخ البدء</label>
                                                                <div class="col-sm-12">
                                                                    <input class="form-control digits" type="date"  id="startDate" name="startDate" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label class="col-form-label">تاريخ الانتهاء</label>
                                                                <div class="col-sm-12">
                                                                    <input class="form-control digits" type="date"  id="endDate"  name="endDate" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4 d-flex justify-content-center align-items-end my-4 ">
                                                                <div class="mx-2 days-field">
                                                                    الأيام المتبقية: 0
                                                                </div>
                                                            </div>
                                                        </div>

                                                    
                                                        <div class="row mb-2 my-4">

                                                            <div class=" d-flex justify-content-around">

                                                                <div id="advance_salary_div" style="display:none;" class="form-check form-check-inline checkbox checkbox-dark mb-0">
                                                                        <input class="form-check-input" id="inline-1" type="checkbox" name="advance_salary">
                                                                        <label class="form-check-label" for="inline-1">Advance Salary</label>
                                                                </div>

                                                            </div>
                                                        
                                                        </div>
                                                    
                                                    
                                                                <div class="row">
                                                                    <div class="col">
                                                                    <div class="mb-3 row">
                                                                        <div class="col-sm-12">
                                                                        <input class="form-control" name="leave_file" type="file">
                                                                        </div>
                                                                    </div>
                                                                    </div>
                                                                </div>
                                                            
                                                                <div class="row">
                                                                    <div class="col">
                                                                    <div>
                                                                        <label class="form-label" for="exampleFormControlTextarea4">تعليقات</label>
                                                                        <textarea class="form-control" name="comment" id="exampleFormControlTextarea4" rows="3"></textarea>
                                                                    </div>
                                                                    </div>
                                                                </div>
                                                        </div>
                                                </div>
                                                <div class="modal-footer">
                                                <button class="btn btn-danger" type="button" data-bs-dismiss="modal">الغاء</button>
                                                <button class="btn btn-primary" type="submit">اضافة</button>
                                                </div>
                                                </form>
                                            
                                            
                                            </div>
                                        </div>
                                        </div>
                                @endcan

                                @can("long_leave_delete")
                                    <button class="btn btn-danger massActionButton" id="destroyAll" type="submit" onclick="setActionType('destroyAll')"  data-bs-original-title="" title="">{{ trans('global.deleteAll')}}</button>
                                @endcan
                       </div>
                    </div>
                    <div class="table-responsive my-5">
                        <table class="display" id="basic-1">
                            <thead>
                                <tr>
                                    
                                    @if (Gate::check('long_leave_update') || Gate::check('long_leave_delete'))

                                    <th>
                                        <div class="form-check checkbox checkbox-dark mb-2">
                                              <input id='selectall' class="form-check-input select-all-checkbox" data-category="all" type="checkbox">
                                              <label for="selectall" class="form-check-label"></label>
                                        </div>
                                    </th>

                                    @endif
                                    <th>{{ trans('admin/user.name') }}</th>
                                    <th>Leave type</th>
                                    <th>From</th>
                                    <th>To</th>
                                    <th>Reason</th>
                                    <th>File</th>
                                    <th>status</th>
                                    <th>Approved By</th>

                                    @if (Gate::check('long_leave_update') || Gate::check('long_leave_delete'))

                                      <th>{{ trans('global.action') }}</th>

                                    @endif

                                </tr>
                            </thead>
                            <tbody>
                                @if(!empty($longLeave))
                                    @foreach ($longLeave as $list )

                                            {{-- @endcan --}}
                                            @if(Gate::check('long_leave_update') || Gate::check('long_leave_delete'))
                                            <td>
                                                        <div class="form-check checkbox checkbox-dark mb-0">
                                                            <input class="form-check-input" name="massAction" id={{"inline-".$list->id}} value="{{ $list->id }}" type="checkbox" data-bs-original-title="" title>
                                                            <label class="form-check-label" for={{"inline-".$list->id}}></label>
                                                        </div>
                                                </td>
                                            @endif
                                            <td>{{ucwords($list->user->first_name)}} {{ucwords($list->user->last_name)}}</td>
                                            <td>{{$list->entitlement->policy->title}}</td>
                                            <td>{{ date('d/m/Y', strtotime($list->from)) }}</td>
                                            <td>{{ date('d/m/Y', strtotime($list->to)) }}</td>
                                            <td>{{$list->reason}}</td>
                                            <td> 
                                                @if ($list->leave_file)
                                                <a class="pdf" href="{{ asset('storage/leave_files/'.$list->leave_file) }}" target="_blank">
                                                <i style="color:red;" class="icofont icofont-file-pdf"></i></a>
                                                @else
                                                File not available
                                                @endif 
                                            </td>
                                            <td>
                                                @if ($list->approved==0)
                                                    <p class="text-warning">Pending</p>
                                                @elseif ($list->approved==1)
                                                    <p class="text-success">Approved</p>
                                                @else
                                                    <p class="text-danger">Rejected</p>  
                                                @endif
                                              
                                            </td>
                                            <td>
                                                {{ucwords(optional($list->approvedBy)->first_name) . ' ' . ucwords(optional($list->approvedBy)->last_name) ?? 'Not Approved' }}
                                            </td>
                                            <td>
                                                @can("long_leave_delete")
                                                    <ul class="action">
                                                        <form onsubmit="return confirm('Are you sure you want to delete this leave?')" action="{{route('admin.longLeave.destroy',['long_leave'=>$list->id])}}" method="post">
                                                            @csrf
                                                            @method('DELETE')
                                                            <li class="delete"><button class="border-none" type="submit"><i class="icon-trash"></i></button></li>
                                                            
                                                        </form>
                                                    </ul>
                                                @endcan
                                            </td>

                                        </tr>
                                    @endforeach
                                 @endif
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="tab-pane fade" id="short-leave" role="tabpanel"
                    aria-labelledby="short-leave-tab">
                    <div class="table-responsive my-5">
                        <table class="display" id="basic-2">
                            <thead>
                                <tr>
                                    <th>{{ trans('admin/user.name') }}</th>
                                    <th>From</th>
                                    <th>To</th>
                                    <th>Reason</th>
                                    <th>File</th>
                                    <th>status</th>
                                    <th>Approved By</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(!empty($shortLeave))
                                    @foreach ($shortLeave as $list )

                                            {{-- @endcan --}}

                                            <td>{{ucwords($list->user->first_name)}} {{ucwords($list->user->last_name)}}</td>
                                            <td>{{ date('h:i a', strtotime($list->from)) }}</td>
                                            <td>{{ date('h:i a', strtotime($list->to)) }}</td>
                                            <td>{{$list->reason}}</td>
                                            <td> 
                                                @if ($list->leave_file)
                                                <a class="pdf" href="{{ asset('storage/leave_files/'.$list->leave_file) }}" target="_blank">
                                                <i style="color:red;" class="icofont icofont-file-pdf"></i></a>
                                                @else
                                                File not available
                                                @endif 
                                            </td>
                                            <td>
                                                @if ($list->approved==0)
                                                    <p class="text-warning">Pending</p>
                                                @elseif ($list->approved==1)
                                                    <p class="text-success">Approved</p>
                                                @else
                                                    <p class="text-danger">Rejected</p>  
                                                @endif
                                              
                                            </td>
                                            <td>
                                                {{ucwords(optional($list->approvedBy)->first_name) . ' ' . ucwords(optional($list->approvedBy)->last_name) ?? 'Not Approved' }}
                                            </td>

                                        </tr>
                                    @endforeach
                                 @endif
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="tab-pane fade" id="late-attendance" role="tabpanel"
                    aria-labelledby="late-attendance-tab">
                    <div class="table-responsive my-5">
                        <table class="display" id="basic-3">
                            <thead>
                                <tr>
                                    <th>{{ trans('admin/user.name') }}</th>
                                    <th>From</th>
                                    <th>To</th>
                                    <th>Reason</th>
                                    <th>File</th>
                                    <th>status</th>
                                    <th>Approved By</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(!empty($lateAttendance))
                                    @foreach ($lateAttendance as $list )

                                            {{-- @endcan --}}

                                            <td>{{ucwords($list->user->first_name)}} {{ucwords($list->user->last_name)}}</td>
                                            <td>{{ date('h:i a', strtotime($list->from)) }}</td>
                                            <td>{{ date('h:i a', strtotime($list->to)) }}</td>
                                            <td>{{$list->reason}}</td>
                                            <td> 
                                                @if ($list->leave_file)
                                                <a class="pdf" href="{{ asset('storage/leave_files/'.$list->leave_file) }}" target="_blank">
                                                <i style="color:red;" class="icofont icofont-file-pdf"></i></a>
                                                @else
                                                File not available
                                                @endif 
                                            </td>
                                            <td>
                                                @if ($list->approved==0)
                                                    <p class="text-warning">Pending</p>
                                                @elseif ($list->approved==1)
                                                    <p class="text-success">Approved</p>
                                                @else
                                                    <p class="text-danger">Rejected</p>  
                                                @endif
                                              
                                            </td>
                                            <td>
                                                {{ucwords(optional($list->approvedBy)->first_name) . ' ' . ucwords(optional($list->approvedBy)->last_name) ?? 'Not Approved' }}
                                            </td>

                                        </tr>
                                    @endforeach
                                 @endif
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="tab-pane fade show " id="entitlement_year_tab" role="tabpanel"
                    aria-labelledby="entitlement-year-tab">
                    <div class="table-responsive">

                        <div class="d-flex justify-content-end mt-4">

                            {{-- @can('role_delete') --}}
                            @can("long_leave_create")
                                
                                <button class="btn btn-primary mx-1 my-5" type="button" data-bs-toggle="modal" data-bs-target=".bd-example-modal-lg1">Add Entitlement</button>
                        
                                <div class="modal fade bd-example-modal-lg1" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="myLargeModalLabel">أضف إجازة<span class="text-danger">{{$error??""}}</span></h4>
                                                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
    
                                        
                                            <form enctype="multipart/form-data" action="{{route('admin.'.$url.".store_entitlement",['user'=>$user->id])}}" method="POST" class="modal-content">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="">

        
                                                            <div class="my-2 row">
        
                                                                <div class="col-md-4">
                                                                    <label class="form-label" for="days" id="daysLabel">الأيام</label>
                                                                    <input class="form-control" id="days"  name="days" type="number"  data-bs-original-title="" title="">
                                                                    <div class="text-danger ">
                                                                        @error("days")
                                                                            {{ $message }}
                                                                        @enderror
                                                                    </div>
                                                                </div>
        
                                                                <div class="col-md-4">
                                                                <label class="col-form-label">سنة العمل</label>
                                                                    <select class="form-select" name="entitlement_year"  id="entitlement_year">
                                                                        @foreach ($employee_years as $years )
                                                                            @php
                                                                                                                                            
                                                                            // Explode the string by "-"
                                                                            $dates = explode('-', $years);
                                                                            $formated_date =date('M Y', strtotime($dates[0])) .' - '.date('M Y', strtotime($dates[1]));
        
                                                                            @endphp
        
                                                                            <option  value="{{$years}}">{{$formated_date}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
        
                                                                <div class="col-md-4">
                                                                <label class="col-form-label">سياسة</label>
                                                                <select class="form-select" name="policy_id" id="new_policy_id" >
                                                                        <option selected="true" disabled value="">Choose...</option>
                                                                        @foreach ($policies as $policy )
                                                                            <option data-add-monthly="{{ $policy->monthly }}" data-add-number-of-days="@if($policy->monthly) {{$policy->days/12}} @else{{!$policy->is_unlimited ? $policy->days : $policy->max_days }}@endif" value="{{$policy->id}}">{{$policy->title}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn btn-danger" type="button" data-bs-dismiss="modal">الغاء</button>
                                                    <button class="btn btn-primary" type="submit">اضافة</button>
                                                </div>
                                            </form>
                                        
                                        
                                        </div>
                                    </div>
                                    </div>
                            @endcan
                        </div>


                        <table class="display " id="basic-4">
                            <thead>
                                <tr>
                                    {{-- @can('user_edit' || 'user_delete') --}}

                                    

                                    {{-- @endcan --}}

                                    <th>{{trans('global.id') }}</th>
                                    <th>موظف</th>
                                    <th>نوع الإجازة</th>
                                    <th>سنة العمل</th>
                                    <th>الأيام</th>
                                    <th>عدد اجازات الماخوذة</th>
                                   
                                    {{-- @can('permission_edit' || 'permission_delete') --}}

                                    {{-- @endcan --}}

                                </tr>
                            </thead>
                            <tbody>
                                @if(!is_null($leaveEntitlement))
                                    @foreach ($leaveEntitlement as $list)
                                        <tr>
                                            <td>{{$list->id}}</td>
                                            <td>{{$list->user->first_name}} {{$list->user->last_name}}</td>
                                            <td>
                                                <h6>{{$list->policy->title}}</h6>
                                            </td>
                                            <td style="direction:ltr;">{{date('d M Y',strtotime($list->start_year))}} {{date('d M Y',strtotime($list->end_year))}}</td>
                                            <td>{{$list->max_days > 0 ? $list->policy->max_days : $list->days }}</td>
                                            <td>{{$list->leave_taken }}</td>
                                        </tr>
                                    @endforeach
                                 @endif
                            </tbody>
                        </table>
                    </div>
                
                </div>
            </div>

        </div>

    </div>
</div>
@endsection

@section('script')

    
    <script>
     $('.days-field').hide();

     $('#policy_id',).change(function () {
         var selectedLeaveType = $(this).find(':selected');
         updateFormFields(selectedLeaveType);
         dateValidation(selectedLeaveType);
     });

     $('#new_policy_id').change(function () {
         let selectedLeaveType = $(this).find(':selected');
         let newMonthly = selectedLeaveType.data('add-monthly');
         let newnumberOfDays = parseInt(selectedLeaveType.data('add-number-of-days'));
         let newDayText = $("#daysLabel");
         let newDays = $("#days");
         console.log(newnumberOfDays);
         !newMonthly?newDayText.text('Days'):newDayText.text('Days (Monthly)');
         newDays.val(newnumberOfDays);
     });

    
    function updateFormFields(selectedLeaveType) {
        // Reset form fields
        // Add logic to show/hide and update fields based on the selected leave type
        var monthly = selectedLeaveType.data('monthly');
        var advanceSalary = selectedLeaveType.data('advance-salary');
        var numberOfDays = selectedLeaveType.data('number-of-days');

        $('.days-field').text('Remaining days: ' + numberOfDays);

        if (monthly) {
            $('.days-field').text('Remaining days: ' + numberOfDays+ " per month");
        }
        $('#advance_salary_div').hide();
        $('input[name="advance_salary"]').prop('checked', false)
        if (advanceSalary) {
            // Update fields for leave with advance salary
            // console.log(advanceSalary);
            $('#advance_salary_div').show();
            $('input[name="advance_salary"]').prop('checked', false)
        }
        // Add more conditions based on your dynamic leave type properties

        // Show the relevant form fields
    }

    
    function dateValidation(selectedLeaveType){
        let endDate = "";
        let startDate = "";

        // console.log(endDate,startDate);
        $('#startDate, #endDate').change(function () {
        // This function will be triggered when either #startDate or #endDate changes
            startDateInput = $("#startDate").val();
            endDateInput = $("#endDate").val();
            var numberOfDays = selectedLeaveType.data('number-of-days');
            var monthly = selectedLeaveType.data('monthly');

            const startDate = new Date(startDateInput);
            const endDate = new Date(endDateInput);

            // Calculate the difference in milliseconds
            const timeDifference = endDate - startDate;

            // Convert milliseconds to days
            const daysDifference = Math.floor(timeDifference / (1000 * 60 * 60 * 24)) + 1;

            $('.days-field').html((numberOfDays - daysDifference>0?'Remaining days: ' +( numberOfDays - daysDifference):"<span class='text-danger'>Remaining days: "+0+"</span>"));

            if(monthly){
               $('.days-field').html((numberOfDays - daysDifference>0?'Remaining days: ' +( numberOfDays - daysDifference) + ' per month' : "<span class='text-danger'>Remaining days: "+0+" per month</span>"));
            }


        });
    }

    //Toggling button between disable or enable
    $(document).ready(function () {
            // Disable the button initially if massDestroy array is empty
            updatemassActionButtonState();

            // Add an event listener to update the button state when the checkbox state changes
            $('input[name="massAction"]').change(function () {
                updatemassActionButtonState();
            });


            //selecting all check boxes
            $('#selectall').change(function () {
                $('.form-check-input[name="massAction"]').prop('checked', this.checked);
                updatemassActionButtonState();
             });
         
             // Function to handle individual checkboxes
             $('.form-check-input[name="massAction"]').change(function () {
                 if (!this.checked) {
                     $('#selectall').prop('checked', false);
                 }
             });

     });

    function updatemassActionButtonState() 
    {
        var isMassDestroyEmpty = $('input[name="massAction"]:checked').length === 0;
        $('.massActionButton').prop('disabled', isMassDestroyEmpty);
    }

    $(function() {

        $('.massActionButton').click(function(e) {
            e.preventDefault();
            
            
            
            var selectedUserIds = [];
            


            var isConfirm = confirm('Are you sure');
            if(!isConfirm) return


            // Collect selected user IDs
            $('input:checkbox[name="massAction"]:checked').each(function() {
                selectedUserIds.push($(this).val());
            });

            // Check if any users are selected
            if (selectedUserIds.length > 0) {
                // Set the action type in the hidden input

                // Prepare data for AJAX request
                var requestData = {
                    action_type: "delete",
                    massAction: selectedUserIds,
                    _token: '{{csrf_token()}}'

                };
            
                // Make AJAX request
                $.ajax({
                    type: 'POST',
                    url: "{{route('admin.longLeave.massAction')}}", // Update the URL to your controller method
                    data: requestData,
                    success: function(response) {
                        // Handle success response
                        location.reload();
                        console.log(response);
                        // Optionally, you can reload the page or update the UI as needed.
                    },
                    error: function(error) {
                        // Handle error response
                        console.error(error);
                    }
                });
            } else {
                alert('Please select at least one user to perform the action.');
            }
        });  

        });


    
    // function showEntitlment(){
    //     const newEntitlementDiv = $('#new_entitlement_div');
    //     const days = $('#days');
    //     const entitlementYear = $('#entitlement_year');
    //     const newPolicyId = $('#new_policy_id');
    //     const policyId = $('#policy_id');
    //     const addEntitlement = $('#add_entitlement');
    //     const daysField = $('.days-field');

    //     if (newEntitlementDiv.is(':visible')) {
    //         // If newEntitlementDiv is visible, hide it and disable elements
            
    //         newEntitlementDiv.hide();
    //         addEntitlement.text('إضافة استحقاق');
    //         daysField.show()
    //         days.prop('disabled', true);
    //         entitlementYear.prop('disabled', true);
    //         newPolicyId.prop('disabled', true);
    //         policyId.show(); // Make PolicyId visible
    //         policyId.prop('disabled', false); // Enable PolicyId
    //     } else {
    //         // If newEntitlementDiv is hidden, show it and enable elements
    //         newEntitlementDiv.show();
    //         addEntitlement.text('يلغي');
    //         daysField.hide()
    //         days.prop('disabled', false);
    //         entitlementYear.prop('disabled', false);
    //         newPolicyId.prop('disabled', false);
    //         // policyId.hide(); // Hide PolicyId
    //         policyId.prop('disabled', true); // Disable PolicyId
    //     }

    // }
    </script>

    <script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatables/datatable.custom.js') }}"></script>
@endsection