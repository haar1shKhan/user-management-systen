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
    <li class="breadcrumb-item active">{{ trans('admin/user.addUser') }}</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row starter-main">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h5>{{ trans('admin/user.addUser') }}</h5>
                    <a class="btn btn-primary" href="/admin/users">{{ trans('global.back') }}</a>
                </div>
                <div class="card-body">
                    <form action="{{route("admin.user.store")}}" method="POST" class="needs-validation" enctype="multipart/form-data" novalidate="">
                        @csrf

                        <h5 class="my-3">User personal Detail</h5>

                        <div class="row my-4">

                            <div class="col-md-6">
                                <label class="col-sm-3 col-form-label">Profile picture</label>
                                <input name="image" class="form-control" type="file">
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
                                <input class="form-control" id="validationCustom01" name="first_name" value="{{old('first_name')}}" type="text"  required="" data-bs-original-title="" title="">
                                {{-- <div class="valid-feedback">Looks good!</div> --}}
                                <div class="text-danger mt-1">
                                    @error("first_name")
                                    {{$message}}    
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label" for="validationCustom01">Last Name</label>
                                <input class="form-control" id="validationCustom01" name="last_name" value="{{old('last_name')}}" type="text"  required="" data-bs-original-title="" title="">
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
                                        <option value="{{ $role->id }}">
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
                                    <input class="form-control" id="validationCustom" type="text" name="email"  placeholder="Email"  value="{{old('email')}}" aria-describedby="inputGroupPrepend" required="" data-bs-original-title="" title="">
                                    <div class="text-danger mt-1">
                                        @error("email")
                                        {{$message}}    
                                        @enderror
                                    </div>
                                </div>
    
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="validationCustomEmail">Personal email (optional)</label>
                                    <input class="form-control" id="validationCustom" type="text" name="personal_email"  placeholder="Email"  value="{{old('email')}}" aria-describedby="inputGroupPrepend" required="" data-bs-original-title="" title="">
                                    <div class="text-danger mt-1">
                                        @error("personal_email")
                                        {{$message}}    
                                        @enderror
                                    </div>
    
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label">Date of birth</label>
                                    <div class="col-sm-12">
                                        <input class="form-control digits" name="date_of_birth" value="{{date('Y-m-d')}}" type="date" value="2018-01-01">
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
                                <input class="form-control" id="validationCustom" type="tel" name="phone"  placeholder="+971 50 123 4567"  value="{{old('phone')}}" aria-describedby="inputGroupPrepend" required="" data-bs-original-title="" title="">
                                <div class="text-danger mt-1">
                                    @error("phone")
                                    {{$message}}    
                                    @enderror
                                </div>

                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label" for="validationCustomEmail">Phone Number (optional)</label>
                                <input class="form-control" id="validationCustom" type="tel" name="mobile"  placeholder="+971 50 123 4567"  value="{{old('mobile')}}" aria-describedby="inputGroupPrepend" required="" data-bs-original-title="" title="">
                                <div class="text-danger mt-1">
                                    @error("mobile")
                                    {{$message}}    
                                    @enderror
                                </div>

                            </div>

                            <div class="col-md-3">
                                <label class="form-label" for="validationCustom04">Gender</label>
                                <select name="gender"  class="form-select" id="validationCustom04" required="">

                                    <option selected="true" disabled value="">Choose...</option>
                                    <option   value="Male">Male</option>
                                    <option   value="Female">Female</option>
                        
                                </select>
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
                                <select name="marital_status"  class="form-select" id="validationCustom04" required="">

                                    <option selected="true" disabled value="">Choose...</option>
                                    <option   value="Bachelor">Bachelor</option>
                                    <option   value="Married">Married</option>
                        
                                </select>
                                <div class="text-danger mt-1">
                                    @error("marital_status")
                                    {{$message}}    
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label" for="validationCustomEmail">Nationality</label>
                                <input class="form-control" id="validationCustom" type="text" name="nationality" value="{{old('nationality')}}"  placeholder="" aria-describedby="inputGroupPrepend" required="" data-bs-original-title="" title="">
                                <div class="text-danger mt-1">
                                    @error("nationality")
                                    {{$message}}    
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label" for="validationCustomEmail">Religion</label>
                                <input class="form-control" id="validationCustom" type="text" name="religion" value="{{old('religion')}}"  placeholder="" aria-describedby="inputGroupPrepend" required="" data-bs-original-title="" title="">
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
                                    <input class="form-control digits" name="hired_at" type="date">
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
                                    <input class="form-control digits" name="joined_at" type="date">
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
                                    <input class="form-control digits" name="resigned_at" type="date">
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
                                <select name="source_of_hire"  class="form-select" id="validationCustom04" required="">

                                    <option selected="true" disabled value="">Choose...</option>
                                    <option   value="direct">Direct</option>
                                    <option   value="refaral">Refaral</option>
                                    <option   value="online">Online</option>
                        
                                </select>
                                <div class="text-danger mt-1">
                                    @error("source_of_hire")
                                    {{$message}}    
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label" for="validationCustom04">Job Type</label>
                                <select name="job_type"  class="form-select" id="validationCustom04" required="">

                                    <option selected="true" disabled value="">Choose...</option>
                                    <option   value="full time">Full time</option>
                                    <option   value="part time">Part time</option>
                                    <option   value="contract">Contract</option>
                                    <option   value="internship">Internship</option>
                                    <option   value="freelance">Freelance</option>
                        
                                </select>
                                <div class="text-danger mt-1">
                                    @error("job_type")
                                    {{$message}}    
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label" for="validationCustom04">Status</label>
                                <select name="status"  class="form-select" id="validationCustom04" required="">

                                    <option selected="true" disabled value="">Choose...</option>
                                    <option   value="active">active</option>
                                    <option   value="terminated">terminated</option>
                                    <option   value="resigned">resigned</option>
                                    <option   value="deceased">deceased</option>
                        
                                </select>
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
                                <input class="form-control" id="validationCustom" type="text" name="education" value="{{old('education')}}"  placeholder="" aria-describedby="inputGroupPrepend" required="" data-bs-original-title="" title="">
                                <div class="text-danger mt-1">
                                    @error("education")
                                    {{$message}}    
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label" for="validationCustomEmail">Work experience</label>
                                <input class="form-control" id="validationCustom" type="number" name="work_experience" value="{{old('education')}}"  placeholder="" aria-describedby="inputGroupPrepend" required="" data-bs-original-title="" title="">
                                <div class="text-danger mt-1">
                                    @error("work_experience")
                                    {{$message}}    
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label" for="validationCustomEmail">Salary</label>
                                <input class="form-control" id="validationCustom" type="number" name="salary" value="{{old('salary')}}"  placeholder="" aria-describedby="inputGroupPrepend" required="" data-bs-original-title="" title="">
                                <div class="text-danger mt-1">
                                    @error("salary")
                                    {{$message}}    
                                    @enderror
                                </div>
                            </div>

                        </div>

                        <div class="row">

                            <div class="col-md-9">
                                <div>
                                    <label class="form-label" for="exampleFormControlTextarea14">Biography </label>
                                    <textarea name="biography" class="form-control btn-square" id="exampleFormControlTextarea14" rows="8"></textarea>
                                  </div>

                                <div class="text-danger mt-1">
                                    @error("biography")
                                    {{$message}}    
                                    @enderror
                                </div>
                            </div>

                        </div>


                        <h5 class="my-3">Legal Documents</h5>

                        <div class="row">

                            <div class="col-md-3 mb-3">
                                <label class="form-label" for="validationCustomEmail">Passport ID</label>
                                <input class="form-control" id="validationCustom" type="text" name="passport" value="{{old('passport')}}"  placeholder="" aria-describedby="inputGroupPrepend" required="" data-bs-original-title="" title="">
                                <div class="text-danger mt-1">
                                    @error("passport")
                                    {{$message}}    
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Passport Issue Date</label>
                                <div class="col-sm-12">
                                    <input class="form-control digits" name="passport_issued_at" type="date">
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
                                    <input class="form-control digits" name="passport_expires_at"  type="date" >
                                </div>
                                <div class="text-danger mt-1">
                                    @error("passport_expires_at")
                                    {{$message}}    
                                    @enderror
                                </div>
                            </div>

                        </div>

                        <div class="row">

                            <div class="col-md-3 mb-3">
                                <label class="form-label" for="validationCustomEmail">Emirates ID</label>
                                <input class="form-control" id="validationCustom" type="text" name="nid" value="{{old('nid')}}"  placeholder="" aria-describedby="inputGroupPrepend" required="" data-bs-original-title="" title="">
                                <div class="text-danger mt-1">
                                    @error("nid")
                                    {{$message}}    
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Emirates ID Issue Date</label>
                                <div class="col-sm-12">
                                    <input class="form-control digits" name="nid_issued_at"  type="date" >
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
                                    <input class="form-control digits" name="nid_expires_at"  type="date" >
                                </div>
                                <div class="text-danger mt-1">
                                    @error("nid_expires_at")
                                    {{$message}}    
                                    @enderror
                                </div>
                            </div>

                        </div>

                        <div class="row">

                            <div class="col-md-3 mb-3">
                                <label class="form-label" for="validationCustomEmail">Visa</label>
                                <input class="form-control" id="validationCustom" type="text" name="visa" value="{{old('visa')}}"  placeholder="" aria-describedby="inputGroupPrepend" required="" data-bs-original-title="" title="">
                                <div class="text-danger mt-1">
                                    @error("visa")
                                    {{$message}}    
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Visa Issue Date</label>
                                <div class="col-sm-12">
                                    <input class="form-control digits" name="visa_issued_at"  type="date" >
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
                                    <input class="form-control digits" name="visa_expires_at"  type="date" >
                                </div>
                                <div class="text-danger mt-1">
                                    @error("visa_expires_at")
                                    {{$message}}    
                                    @enderror
                                </div>
                            </div>

                        </div>

                        <h5 class="my-3">Bank Details</h5>

                        <div class="row">

                            <div class="col-md-3 mb-3">
                                <label class="form-label" for="validationCustomEmail">Bank Name</label>
                                <input class="form-control" id="validationCustom" type="text" name="bank_name" value="{{old('bank_name')}}"  placeholder="" aria-describedby="inputGroupPrepend" required="" data-bs-original-title="" title="">
                                <div class="text-danger mt-1">
                                    @error("bank_name")
                                    {{$message}}    
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label" for="validationCustomEmail">Bank Account Number</label>
                                <input class="form-control" id="validationCustom" type="text" name="bank_account_number" value="{{old('bank_account_number')}}"  placeholder="" aria-describedby="inputGroupPrepend" required="" data-bs-original-title="" title="">
                                <div class="text-danger mt-1">
                                    @error("bank_account_number")
                                    {{$message}}    
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label" for="validationCustomEmail">IBAN</label>
                                <input class="form-control" id="validationCustom" type="text" name="iban" value="{{old('iban')}}"  placeholder="" aria-describedby="inputGroupPrepend" required="" data-bs-original-title="" title="">
                                <div class="text-danger mt-1">
                                    @error("iban")
                                    {{$message}}    
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label" for="validationCustom04">Payment method</label>
                                <select name="payment_method"  class="form-select" id="validationCustom04" required="">

                                    <option selected="true" disabled value="">Choose...</option>
                                    <option   value="cash">cash</option>
                                    <option   value="bank transfer">bank Transfer</option>
                        
                                </select>
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
                                <input class="form-control" id="validationCustom" type="address" name="address" value="{{old('address')}}"  placeholder="" aria-describedby="inputGroupPrepend" required="" data-bs-original-title="" title="">
                                <div class="text-danger mt-1">
                                    @error("address")
                                    {{$message}}    
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label" for="validationCustomEmail">Second Address (optional)</label>
                                <input class="form-control" id="validationCustom" type="address" name="address2" value="{{old('address2')}}"  placeholder="" aria-describedby="inputGroupPrepend" required="" data-bs-original-title="" title="">
                                <div class="text-danger mt-1">
                                    @error("address2")
                                    {{$message}}    
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label" for="validationCustomEmail">City</label>
                                <input class="form-control" id="validationCustom" type="text" name="city" value="{{old('city')}}"  placeholder="" aria-describedby="inputGroupPrepend" required="" data-bs-original-title="" title="">
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
                            <input class="form-control" id="validationCustom" type="text" name="province" value="{{old('province')}}"  placeholder="" aria-describedby="inputGroupPrepend" required="" data-bs-original-title="" title="">
                            <div class="text-danger mt-1">
                                @error("province")
                                {{$message}}    
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label" for="validationCustomEmail">country</label>
                            <input class="form-control" id="validationCustom" type="text" name="country" value="{{old('address')}}"  placeholder="" aria-describedby="inputGroupPrepend" required="" data-bs-original-title="" title="">
                            <div class="text-danger mt-1">
                                @error("country")
                                {{$message}}    
                                @enderror
                            </div>
                        </div>

                    </div>

                    <h5 class="my-3">User Password</h5>


                         <div class="col-md-6 mb-3">
                             <label class="form-label" for="validationCustomEmail">{{ trans('admin/user.password') }}</label>
                             <input class="form-control" id="validationCustom" type="password" name="password"  placeholder="Password" aria-describedby="inputGroupPrepend" required="" data-bs-original-title="" title="">
                             <div class="text-danger mt-1">
                                 @error("password")
                                 {{$message}}    
                                 @enderror
                             </div>
                         </div>

                         <div class="col-md-6 mb-3">
                             <label class="form-label" for="validationCustomEmail">Confirm password</label>
                             <input class="form-control" id="validationCustom" type="password" name="password_confirmation"  placeholder="Confirm Password" aria-describedby="inputGroupPrepend" required="" data-bs-original-title="" title="">
                             <div class="text-danger mt-1">
                                 @error("password_confirmation")
                                 {{$message}}    
                                 @enderror
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
