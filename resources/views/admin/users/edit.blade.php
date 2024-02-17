@extends('layouts.admin')

@section('title', 'Default')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/animate.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/prism.css') }}">
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
    <h3>{{ trans('admin/user.user') }}</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Dashboard</li>
    <li class="breadcrumb-item active">{{ trans('admin/user.editUser') }}</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row starter-main">
        <div class="col-sm-12">
            <div class="card">
                  <div class="card-header d-flex justify-content-between">
                      <h5>{{ trans('admin/user.editUser') }}</h5>
                      <a class="btn btn-primary" href="/admin/users">{{ trans('global.back') }}</a>
                  </div>
                <div class="card-body">
                    <form action="{{route("admin.user.update",['user'=>$user->id])}}" method="POST"  enctype="multipart/form-data" class="needs-validation" novalidate="">
                        @csrf
                        @method('PUT')
                        <h5 class="my-3">User personal Detail</h5>

                        <div class="row my-4">

                            <div class="col-md-6">
                                <label class="col-sm-3 col-form-label">Profile picture</label>
                                <input name="image" class="form-control"  type="file">
                                {{-- <div class="valid-feedback">Looks good!</div> --}}
                                <div class="text-danger mt-1">
                                    @error("image")
                                    {{$message}}    
                                    @enderror
                                </div>
                            </div>


                        </div>
                        
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label class="form-label" for="validationCustom01">First Name</label>
                                <input class="form-control" id="validationCustom01" name="first_name" value="{{$user->first_name}}" type="text"  required="" data-bs-original-title="" title="">
                                {{-- <div class="valid-feedback">Looks good!</div> --}}
                                <div class="text-danger mt-1">
                                    @error("first_name")
                                    {{$message}}    
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label" for="validationCustom01">Last Name</label>
                                <input class="form-control" id="validationCustom01" name="last_name" value="{{$user->last_name}}" type="text"  required="" data-bs-original-title="" title="">
                                {{-- <div class="valid-feedback">Looks good!</div> --}}
                                <div class="text-danger mt-1">
                                    @error("last_name")
                                    {{$message}}    
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label" for="validationCustom04">{{ trans('admin/user.role') }}</label>
                                <select name="role"  class="form-select" id="validationCustom04" required="">
                                    <option selected="true"  value="2">Choose...</option>
                                    @foreach ($roles as $role)
                                        <option {{$user->roles[0]->id == $role->id ?'selected':""}} value="{{ $role->id }}">
                                            {{ $role->title }}
                                        </option>
                                     @endforeach
                        
                                </select>
                                <div class="text-danger mt-1">
                                    @error("role")
                                    {{$message}}    
                                    @enderror
                                </div>
                            </div>

                        </div>


                        <div class="row g-3">

                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="validationCustomEmail">{{ trans('admin/user.email') }}</label>
                                    <input class="form-control" id="validationCustom" type="text" name="email"  placeholder="Email"  value="{{$user->email}}" aria-describedby="inputGroupPrepend" required="" data-bs-original-title="" title="">
                                    <div class="text-danger mt-1">
                                        @error("email")
                                        {{$message}}    
                                        @enderror
                                    </div>
                                </div>
    
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="validationCustomEmail">Personal email (optional)</label>
                                    <input class="form-control" id="validationCustom" type="text" name="personal_email"  placeholder="Email"  value="{{$user->profile->email ?? ""}}" aria-describedby="inputGroupPrepend" required="" data-bs-original-title="" title="">
                                    <div class="text-danger mt-1">
                                        @error("personal_email")
                                        {{$message}}    
                                        @enderror
                                    </div>
    
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label">Date of birth</label>
                                    <div class="col-sm-12">
                                        <input class="form-control digits" name="date_of_birth" value="{{$user->profile->date_of_birth ?? ""}}" type="date" value="2018-01-01">
                                    </div>
                                    <div class="text-danger mt-1">
                                        @error("date_of_birth")
                                        {{$message}}    
                                        @enderror
                                    </div>
                                </div>


                        </div>

                        <div class="row g-3">

                            <div class="col-md-3 mb-3">
                                <label class="form-label" for="validationCustomEmail">Phone Number</label>
                                <input class="form-control" id="validationCustom" type="tel" name="phone"  placeholder="+971 50 123 4567"  value="{{$user->profile->phone ?? ""}}" aria-describedby="inputGroupPrepend" required="" data-bs-original-title="" title="">
                                <div class="text-danger mt-1">
                                    @error("phone")
                                    {{$message}}    
                                    @enderror
                                </div>

                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label" for="validationCustomEmail">Phone Number (optional)</label>
                                <input class="form-control" id="validationCustom" type="tel" name="mobile"  placeholder="+971 50 123 4567"  value="{{$user->profile->mobile ?? ""}}" aria-describedby="inputGroupPrepend" required="" data-bs-original-title="" title="">
                                <div class="text-danger mt-1">
                                    @error("mobile")
                                    {{$message}}    
                                    @enderror
                                </div>

                            </div>
                            
                            <div class="col-md-3">
                                <label class="form-label" for="validationCustom04">Gender</label>
                                @if (empty($user->profile->gender))
                                <select name="gender"  class="form-select" id="validationCustom04" required="">
                                        <option selected="true" disabled value="">Choose...</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                </select>
                                @else
                                <select name="gender"  class="form-select" id="validationCustom04" required="">
                                        <option selected="true" disabled value="">Choose...</option>
                                        <option {{$user->profile->gender == 'male'? "selected" : "" }}  value="Male">Male</option>
                                        <option {{$user->profile->gender == 'female'? "selected" : "" }}  value="Female">Female</option>
                                </select>
                                @endif
                                <div class="text-danger mt-1">
                                    @error("gender")
                                    {{$message}}    
                                    @enderror
                                </div>
                            </div>


                        </div>


                        <div class="row g-3">
                          
                            <div class="col-md-3">
                                <label class="form-label" for="validationCustom04">Marital status</label>
                                @if (empty($user->profile->marital_status))
                                    <select name="marital_status"  class="form-select" id="validationCustom04" required="">
                                        <option selected="true" disabled value="">Choose...</option>
                                        <option value="Bachelor">Bachelor</option>
                                        <option value="Married">Married</option>
                                    </select>
                                @else
                                    <select name="marital_status"  class="form-select" id="validationCustom04" required="">
                                        <option selected="true" disabled value="">Choose...</option>
                                        <option {{$user->profile->marital_status == 'Bachelor'? "selected" : "" }}  value="Bachelor">Bachelor</option>
                                        <option {{$user->profile->marital_status == 'Married'? "selected" : "" }}  value="Married">Married</option>
                                  </select>
                                @endif
                                <div class="text-danger mt-1">
                                    @error("marital_status")
                                    {{$message}}    
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label" for="validationCustomEmail">Nationality</label>
                                <input class="form-control" id="validationCustom" type="text" name="nationality" value="{{$user->profile->nationality ?? ""}}"  placeholder="" aria-describedby="inputGroupPrepend" required="" data-bs-original-title="" title="">
                                <div class="text-danger mt-1">
                                    @error("nationality")
                                    {{$message}}    
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label" for="validationCustomEmail">Religion</label>
                                <input class="form-control" id="validationCustom" type="text" name="religion" value="{{$user->profile->religion ?? " "}}"  placeholder="" aria-describedby="inputGroupPrepend" required="" data-bs-original-title="" title="">
                                <div class="text-danger mt-1">
                                    @error("religion")
                                    {{$message}}    
                                    @enderror
                                </div>
                            </div>

                        </div>

                        <div class="row g-3">
                            
                            <div class="col-md-3">
                                <label class="form-label">Hired at</label>
                                <div class="col-sm-12">
                                    <input class="form-control digits" name="hired_at" value="{{$user->jobDetail->hired_at ?? ""}}" type="date">
                                </div>
                                <div class="text-danger mt-1">
                                    @error("hired_at")
                                    {{$message}}    
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Joined at</label>
                                <div class="col-sm-12">
                                    <input class="form-control digits" value="{{$user->jobDetail->joined_at ?? ""}}" name="joined_at" type="date">
                                </div>
                                <div class="text-danger mt-1">
                                    @error("joined_at")
                                    {{$message}}    
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Resigned at</label>
                                <div class="col-sm-12">
                                    <input class="form-control digits" value="{{$user->jobDetail->resigned_at ?? ""}}" name="resigned_at" type="date">
                                </div>
                                <div class="text-danger mt-1">
                                    @error("resigned_at")
                                    {{$message}}    
                                    @enderror
                                </div>
                            </div>

                        </div>

                        <div class="row g-3 my-1">
                            
                            <div class="col-md-3">
                                <label class="form-label" for="validationCustom04">Source Of Hiring</label>
                                @if ( !empty($user->profile->source_of_hire))
                                    <select name="source_of_hire"  class="form-select" id="validationCustom04" required="">

                                        <option selected="true" disabled value="">Choose...</option>
                                        <option value="direct">Direct</option>
                                        <option value="refaral">Refaral</option>
                                        <option value="online">Online</option>
                            
                                    </select>
                                @else
                                    <select name="source_of_hire"  class="form-select" id="validationCustom04" required="">

                                        <option selected="true" disabled value="">Choose...</option>
                                        <option {{$user->jobDetail->source_of_hire == 'direct'? "selected" : "" }}  value="direct">Direct</option>
                                        <option {{$user->jobDetail->source_of_hire == 'refaral'? "selected" : "" }}  value="refaral">Refaral</option>
                                        <option {{$user->jobDetail->source_of_hire == 'online'? "selected" : "" }} value="online">Online</option>
                            
                                    </select>
                                @endif

                                <div class="text-danger mt-1">
                                    @error("source_of_hire")
                                    {{$message}}    
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label" for="validationCustom04">Job Type</label>
                                @if ( !empty($user->profile->job_type))
                                    <select name="job_type"  class="form-select" id="validationCustom04" required="">
                                        <option selected="true" disabled value="">Choose...</option>
                                        <option value="full_time">Full time</option>
                                        <option value="part_time">Part time</option>
                                        <option value="contract">Contract</option>
                                        <option value="internship">Internship</option>
                                        <option value="freelance">Freelance</option>
                                    </select>        
                                @else
                                    <select name="job_type"  class="form-select" id="validationCustom04" required="">
                                            <option selected="true" disabled value="">Choose...</option>
                                            <option {{$user->jobDetail->job_type == 'full_time'? "selected" : "" }}  value="full_time">Full time</option>
                                            <option {{$user->jobDetail->job_type == 'part_time'? "selected" : "" }}  value="part_time">Part time</option>
                                            <option {{$user->jobDetail->job_type == 'contract'? "selected" : "" }}   value="contract">Contract</option>
                                            <option {{$user->jobDetail->job_type == 'internship'? "selected" : "" }} value="internship">Internship</option>
                                            <option {{$user->jobDetail->job_type == 'freelance'? "selected" : "" }}  value="freelance">Freelance</option>
                                    </select>
                                @endif
                                <div class="text-danger mt-1">
                                    @error("job_type")
                                    {{$message}}    
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label" for="validationCustom04">Status</label>

                                @if ( !empty($user->profile->status))
                                    <select name="status"  class="form-select" id="validationCustom04" required="">
                                        <option selected="true" disabled value="">Choose...</option>
                                        <option  value="active">Active</option>
                                        <option  value="terminated">Terminated</option>
                                        <option  value="resigned">Resigned</option>
                                        <option  value="deceased">Deceased</option>
                                    </select>
                                @else
                                    <select name="status"  class="form-select" id="validationCustom04" required="">
                                            <option selected="true" disabled value="">Choose...</option>
                                            <option {{$user->jobDetail->status == 'active'? "selected" : "" }}  value="active">Active</option>
                                            <option {{$user->jobDetail->status == 'terminated'? "selected" : "" }}  value="terminated">Terminated</option>
                                            <option {{$user->jobDetail->status == 'resigned'? "selected" : "" }}  value="resigned">Resigned</option>
                                            <option {{$user->jobDetail->status == 'deceased'? "selected" : "" }}  value="deceased">Deceased</option>
                                    </select>
                                @endif

                                <div class="text-danger mt-1">
                                    @error("status")
                                    {{$message}}    
                                    @enderror
                                </div>
                            </div>

                        </div>
                        <div class="row">

                            <div class="col-md-3 mb-3">
                                <label class="form-label" for="validationCustomEmail">Education</label>
                                <input class="form-control" id="validationCustom" type="text" name="education" value="{{$user->jobDetail->education ?? ""}}"  placeholder="" aria-describedby="inputGroupPrepend" required="" data-bs-original-title="" title="">
                                <div class="text-danger mt-1">
                                    @error("education")
                                    {{$message}}    
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label" for="validationCustomEmail">Work experience</label>
                                <input class="form-control" id="validationCustom" type="number" name="work_experience" value="{{$user->jobDetail->work_experience ?? 0}}"  placeholder="" aria-describedby="inputGroupPrepend" required="" data-bs-original-title="" title="">
                                <div class="text-danger mt-1">
                                    @error("work_experience")
                                    {{$message}}    
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label" for="validationCustomEmail">Salary</label>
                                <input class="form-control" id="validationCustom" type="number" name="salary" value="{{$user->jobDetail->salary ?? 0}}"  placeholder="" aria-describedby="inputGroupPrepend" required="" data-bs-original-title="" title="">
                                <div class="text-danger mt-1">
                                    @error("salary")
                                    {{$message}}    
                                    @enderror
                                </div>
                            </div>

                        </div>

                        <div class="row">

                            <div class="col-md-9">

                                <div class="row">
                                    <div class="o-hidden">
                                        <div class="mb-2">
                                            <div class="form-label">Reporting To</div>
                                            <select name="supervisor_id" class="js-example-basic-single col-sm-12">
                                                @if( !empty($user->jobDetail->supervisor_id))
                                                    @foreach ($supervisors as $supervisors)
                                                        <option value="{{ $supervisors->id }}">
                                                            {{ $supervisors->first_name}} {{ $supervisors->last_name}}
                                                        </option>
                                                    @endforeach
                                                @else
                                                    @foreach ($supervisors as $supervisors)
                                                        <option {{$user->jobDetail->supervisor_id == $supervisors->id ? "selected" : "" }} value="{{ $supervisors->id }}">
                                                            {{ $supervisors->first_name}} {{ $supervisors->last_name}}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>

                        </div>

                        <div class="row">

                            <div class="col-md-9">
                                <div>
                                    <label class="form-label" for="exampleFormControlTextarea14">Biography </label>
                                    <textarea name="biography" class="form-control btn-square" id="exampleFormControlTextarea14" rows="8">{{$user->profile->biography ?? ""}}</textarea>
                                  </div>

                                <div class="text-danger mt-1">
                                    @error("biography")
                                    {{$message}}    
                                    @enderror
                                </div>
                            </div>

                        </div>


                        <h5 class="my-3">Legal Documents</h5>

                        <div class="row mb-5">

                            <div class="col-md-3">
                                <label class="form-label" for="validationCustomEmail">Passport ID</label>
                                <input class="form-control" id="validationCustom" type="text" name="passport" value="{{$user->profile->passport ?? ""}}"  placeholder="" aria-describedby="inputGroupPrepend" required="" data-bs-original-title="" title="">
                                <div class="text-danger mt-1">
                                    @error("passport")
                                    {{$message}}    
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Passport Issue Date</label>
                                <div class="col-sm-12">
                                    <input class="form-control digits" value="{{$user->profile->passport_issued_at ?? ""}}" name="passport_issued_at" type="date">
                                </div>
                                <div class="text-danger mt-1">
                                    @error("passport_issued_at")
                                    {{$message}}    
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Passport Expiry Date</label>
                                <div class="col-sm-12">
                                    <input class="form-control digits"  name="passport_expires_at"  value="{{$user->profile->passport_expires_at ?? ""}}"  type="date" >
                                </div>
                                <div class="text-danger mt-1">
                                    @error("passport_expires_at")
                                    {{$message}}    
                                    @enderror
                                </div>
                            </div>

                            <div class="row">

                                <div class="col-md-6">
                                    <label class="col-sm-3 col-form-label">Passport</label>
                                    <input name="passport_file" class="form-control" type="file">
                                    {{-- <div class="valid-feedback">Looks good!</div> --}}
                                    <div class="text-danger mt-1">
                                        @error("passport_file")
                                        {{$message}}    
                                        @enderror
                                    </div>
                                </div>
    
                            </div>

                        </div>

                        <div class="row mb-5">

                            <div class="col-md-3">
                                <label class="form-label" for="validationCustomEmail">Emirates ID</label>
                                <input class="form-control" id="validationCustom" type="text" name="nid" value="{{$user->profile->nid ?? ""}}"  placeholder="" aria-describedby="inputGroupPrepend" required="" data-bs-original-title="" title="">
                                <div class="text-danger mt-1">
                                    @error("nid")
                                    {{$message}}    
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Emirates ID Issue Date</label>
                                <div class="col-sm-12">
                                    <input class="form-control digits" value="{{$user->profile->nid_issued_at ?? ""}}" name="nid_issued_at"  type="date" >
                                </div>
                                <div class="text-danger mt-1">
                                    @error("nid_issued_at")
                                    {{$message}}    
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Emirates ID Expiry Date</label>
                                <div class="col-sm-12">
                                    <input class="form-control digits" value="{{$user->profile->nid_expires_at ?? ""}}" name="nid_expires_at"  type="date" >
                                </div>
                                <div class="text-danger mt-1">
                                    @error("nid_expires_at")
                                    {{$message}}    
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="col-sm-3 col-form-label">Emirates ID</label>
                                <input name="nid_file" class="form-control" type="file">
                                {{-- <div class="valid-feedback">Looks good!</div> --}}
                                <div class="text-danger mt-1">
                                    @error("nid_file")
                                    {{$message}}    
                                    @enderror
                                </div>
                            </div>

                        </div>

                        <div class="row mb-5">

                            <div class="col-md-3">
                                <label class="form-label" for="validationCustomEmail">Visa</label>
                                <input class="form-control" id="validationCustom" type="text" name="visa" value="{{$user->profile->visa ?? ""}}"  placeholder="" aria-describedby="inputGroupPrepend" required="" data-bs-original-title="" title="">
                                <div class="text-danger mt-1">
                                    @error("visa")
                                    {{$message}}    
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Visa Issue Date</label>
                                <div class="col-sm-12">
                                    <input class="form-control digits" value="{{$user->profile->visa_issued_at ?? ""}}" name="visa_issued_at"  type="date" >
                                </div>
                                <div class="text-danger mt-1">
                                    @error("visa_issued_at")
                                    {{$message}}    
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Visa Expiry Date</label>
                                <div class="col-sm-12">
                                    <input class="form-control digits" value="{{$user->profile->visa_expires_at ?? ""}}" name="visa_expires_at"  type="date" >
                                </div>
                                <div class="text-danger mt-1">
                                    @error("visa_expires_at")
                                    {{$message}}    
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="col-sm-3 col-form-label">Visa</label>
                                <input name="visa_file" class="form-control" type="file">
                                {{-- <div class="valid-feedback">Looks good!</div> --}}
                                <div class="text-danger mt-1">
                                    @error("visa_file")
                                    {{$message}}    
                                    @enderror
                                </div>
                            </div>

                        </div>

                        <h5 class="my-3">Bank Details</h5>

                        <div class="row">

                            <div class="col-md-3 mb-3">
                                <label class="form-label" for="validationCustomEmail">Bank Name</label>
                                <input class="form-control" id="validationCustom" type="text" name="bank_name" value="{{$user->jobDetail->bank_name ?? ""}}"  placeholder="" aria-describedby="inputGroupPrepend" required="" data-bs-original-title="" title="">
                                <div class="text-danger mt-1">
                                    @error("bank_name")
                                    {{$message}}    
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label" for="validationCustomEmail">Bank Account Number</label>
                                <input class="form-control" id="validationCustom" type="text" name="bank_account_number" value="{{$user->jobDetail->bank_account_number ?? ""}}"  placeholder="" aria-describedby="inputGroupPrepend" required="" data-bs-original-title="" title="">
                                <div class="text-danger mt-1">
                                    @error("bank_account_number")
                                    {{$message}}    
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label" for="validationCustomEmail">IBAN</label>
                                <input class="form-control" id="validationCustom" type="text" name="iban" value="{{$user->jobDetail->iban ?? ""}}"  placeholder="" aria-describedby="inputGroupPrepend" required="" data-bs-original-title="" title="">
                                <div class="text-danger mt-1">
                                    @error("iban")
                                    {{$message}}    
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label" for="validationCustom04">Payment method</label>
                                @if (!empty($user->profile->payment_method))
                                    <select name="payment_method"  class="form-select" id="validationCustom04" required="">
                                            <option selected="true" disabled value="">Choose...</option>
                                            <option   value="cash">Cash</option>
                                            <option   value="bank_transfer">Bank Transfer</option>
                                    </select>
                                @else
                                    <select name="payment_method"  class="form-select" id="validationCustom04" required="">
                                        <option selected="true" disabled value="">Choose...</option>
                                            <option   value="cash">Cash</option>
                                            <option   value="bank_transfer">Bank Transfer</option>
                                            <option {{$user->jobDetail->payment_method == 'cash'? "selected" : "" }}  value="cash">Cash</option>
                                            <option {{$user->jobDetail->payment_method == 'bank_transfer'? "selected" : "" }} value="bank_transfer">Bank Transfer</option>
                                    </select>
                                @endif
                                <div class="text-danger mt-1">
                                    @error("payment_method")
                                    {{$message}}    
                                    @enderror
                                </div>
                            </div>

                        </div>

                        <h5 class="my-3">User Address</h5>


                        <div class="row">

                            <div class="col-md-3 mb-3">
                                <label class="form-label" for="validationCustomEmail">Address</label>
                                <input class="form-control" id="validationCustom" type="address" name="address" value="{{$user->profile->address ?? ""}}"  placeholder="" aria-describedby="inputGroupPrepend" required="" data-bs-original-title="" title="">
                                <div class="text-danger mt-1">
                                    @error("address")
                                    {{$message}}    
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label" for="validationCustomEmail">Second Address (optional)</label>
                                <input class="form-control" id="validationCustom" type="address" name="address2" value="{{$user->profile->address2 ?? ""}}" placeholder="" aria-describedby="inputGroupPrepend" required="" data-bs-original-title="" title="">
                                <div class="text-danger mt-1">
                                    @error("address2")
                                    {{$message}}    
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label" for="validationCustomEmail">City</label>
                                <input class="form-control" id="validationCustom" type="text" name="city"  value="{{$user->profile->city ?? ""}}"  placeholder="" aria-describedby="inputGroupPrepend" required="" data-bs-original-title="" title="">
                                <div class="text-danger mt-1">
                                    @error("city")
                                    {{$message}}    
                                    @enderror
                                </div>
                            </div>

                    </div>

                    
                    <div class="row">

                        <div class="col-md-3 mb-3">
                            <label class="form-label" for="validationCustomEmail">Province/State</label>
                            <input class="form-control" id="validationCustom" type="text" name="province"  value="{{$user->profile->province ?? ""}}"  placeholder="" aria-describedby="inputGroupPrepend" required="" data-bs-original-title="" title="">
                            <div class="text-danger mt-1">
                                @error("province")
                                {{$message}}    
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label" for="validationCustomEmail">country</label>
                            <input class="form-control" id="validationCustom" type="text" name="country"  value="{{$user->profile->country ?? ""}}" placeholder="" aria-describedby="inputGroupPrepend" required="" data-bs-original-title="" title="">
                            <div class="text-danger mt-1">
                                @error("country")
                                {{$message}}    
                                @enderror
                            </div>
                        </div>

                    </div>

                        <div class="row">
                            <div class="col-md-9 offset-md-10">
                                <button class="btn btn-primary" type="submit" data-bs-original-title="" title="">{{ trans('admin/user.addUser') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

    <script type="text/javascript">
        var session_layout = '{{ session()->get('layout') }}';
    </script>
@endsection

@section('script')
@endsection
