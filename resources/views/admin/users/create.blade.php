@extends('layouts.admin')

@section('title', 'Default')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/animate.css') }}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/prism.css') }}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/select2.css')}}">
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
    <h3>{{ trans('admin/user.user') }}</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">System</li>
    <li class="breadcrumb-item">User Management</li>
    <li class="breadcrumb-item">{{ trans('admin/user.addUser') }}</li>
    <li class="breadcrumb-item active">Create</li>
@endsection

@section('content')
{{-- <div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<h5>Create new User</h5>
					<span>Please Make sure fill all the filed before click on next button</span>
				</div>
				<div class="card-body">
					<form class="form-wizard" id="regForm" action="#" method="POST">
						<div class="tab">
							<div class="mb-3 col-md-6">
								<label class="form-label" for="first_name">First Name</label>
                                <input class="form-control" type="text" id="first_name" name="first_name" value="{{old('first_name')}}"  required>
                                
                                @error("first_name")
                                <div class="valid-feedback">{{$message}} </div>      
                                @enderror
                            </div>
							<div class="mb-3 col-md-6">
                                <label class="form-label" for="last_name">Last Name</label>
                                <input class="form-control" type="text" id="last_name" name="last_name" value="{{old('last_name')}}" type="text" required>
                                
                                @error("last_name")
                                <div class="valid-feedback">{{$message}}</div>
                                @enderror
							</div>
							<div class="mb-3">
								<label for="contact">Contact No.</label>
								<input class="form-control digits" id="contact" type="number" placeholder="123456789">
							</div>
                            <div class="mb-3">
								<label for="exampleFormControlInput1">Email address</label>
								<input class="form-control" id="exampleFormControlInput1" type="email" placeholder="name@example.com">
							</div>
							<div class="mb-3">
								<label for="exampleInputPassword1">Password</label>
								<input class="form-control" id="exampleInputPassword1" type="password" placeholder="Password">
							</div>
							<div class="mb-3">
								<label for="exampleInputPassword1">Confirm Password</label>
								<input class="form-control" id="exampleInputcPassword1" type="password" placeholder="Enter again">
							</div>
						</div>
						<div class="tab">
							//
						</div>
						<div class="tab">
							<div class="mb-3">
								<label for="exampleFormControlInput1">Birthday:</label>
								<input class="form-control digits" type="date">
							</div>
							<div class="mb-3">
								<label class="control-label">Age</label>
								<input class="form-control digits" placeholder="Age" type="text">
							</div>
							<div class="mb-3">
								<label class="control-label">Have Passport</label>
								<input class="form-control digits" placeholder="Yes/No" type="text">
							</div>
						</div>
						<div class="tab">
							<div class="mb-3">
								<label class="control-label">Country</label>
								<input class="form-control mt-1" type="text" placeholder="Country" required="required">
							</div>
							<div class="mb-3">
								<label class="control-label">State</label>
								<input class="form-control mt-1" type="text" placeholder="State" required="required">
							</div>
							<div class="mb-3">
								<label class="control-label">City</label>
								<input class="form-control mt-1" type="text" placeholder="City" required="required">
							</div>
						</div>
						<div>
							<div class="text-end btn-mb">
								<button class="btn btn-secondary" id="prevBtn" type="button" onclick="nextPrev(-1)">Previous</button>
								<button class="btn btn-primary" id="nextBtn" type="button" onclick="nextPrev(1)">Next</button>
							</div>
						</div>
						<!-- Circles which indicates the steps of the form:-->
						<div class="text-center"><span class="step"></span><span class="step"></span><span class="step"></span><span class="step"></span></div>
						<!-- Circles which indicates the steps of the form:-->
					</form>
				</div>
			</div>
		</div>
	</div>
</div> --}}
<div class="container-fluid">
    <div class="row starter-main">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h5>{{ trans('admin/user.addUser') }}</h5>
                    <a class="btn btn-primary" href="/admin/users">{{ trans('global.back') }}</a>
                </div>
                <div class="card-body">
                    
                    <form action="{{route("admin.user.store")}}" method="POST" class="needs-validation @if(count($errors)>0)was-validated @endif" enctype="multipart/form-data" novalidate="">
                        @csrf

                        <h5 class="my-3">User personal Detail</h5>

                        <div class="row my-4">

                            <div class="col-md-6">
                                <label class="col-sm-3 col-form-label">Profile picture</label>
                                <input name="image" class="form-control" type="file">
                                @error("image")
                                <div class="invalid-feedback"> {{$message}} </div> 
                                @enderror
                            </div>


                        </div>
                        
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label class="form-label" for="validationCustom01">First Name</label>
                                <input class="form-control" id="validationCustom01" name="first_name"  type="text"  required="" data-bs-original-title="" title="">
                                {{-- <div class="valid-feedback">Looks good!</div> --}}
                                <div class="text-danger mt-1">
                                    @error("first_name")
                                    {{$message}}    
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label" for="validationCustom01">Last Name</label>
                                <input class="form-control" id="validationCustom01" name="last_name"  type="text"  required="" data-bs-original-title="" title="">
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
                                    <input class="form-control" id="validationCustom" type="text" name="email"  placeholder="Email"  aria-describedby="inputGroupPrepend" required="" data-bs-original-title="" title="">
                                    <div class="text-danger mt-1">
                                        @error("email")
                                        {{$message}}    
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="validationCustomEmail">Personal email (optional)</label>
                                    <input class="form-control" id="validationCustom" type="text" name="personal_email"  placeholder="Email"  value="{{old('email')}}" aria-describedby="inputGroupPrepend" required="" data-bs-original-title="" title="">
                                    
                                        @error("personal_email")
                                        {{$message}}    
                                        @enderror
            
    
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label">Date of birth</label>
                                    <div class="col-sm-12">
                                        <input class="form-control digits" name="date_of_birth" value="{{date('Y-m-d')}}" type="date" value="2018-01-01">
                                    </div>
                                    
                                        @error("date_of_birth")
                                        {{$message}}    
                                        @enderror
            
                                </div>


                        </div>

                        <div class="row g-3">

                            <div class="col-md-3 mb-3">
                                <label class="form-label" for="validationCustomEmail">Phone Number</label>
                                <input class="form-control" id="validationCustom" type="tel" name="phone"  placeholder="+971 50 123 4567"  value="{{old('phone')}}" aria-describedby="inputGroupPrepend" required="" data-bs-original-title="" title="">
                                
                                    @error("phone")
                                    {{$message}}    
                                    @enderror
        

                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label" for="validationCustomEmail">Phone Number (optional)</label>
                                <input class="form-control" id="validationCustom" type="tel" name="mobile"  placeholder="+971 50 123 4567"  value="{{old('mobile')}}" aria-describedby="inputGroupPrepend" required="" data-bs-original-title="" title="">
                                
                                    @error("mobile")
                                    {{$message}}    
                                    @enderror
        

                            </div>

                            <div class="col-md-3">
                                <label class="form-label" for="validationCustom04">Gender</label>
                                <select name="gender"  class="form-select" id="validationCustom04" required="">

                                    <option selected="true" disabled value="">Choose...</option>
                                    <option   value="Male">Male</option>
                                    <option   value="Female">Female</option>
                        
                                </select>
                                
                                    @error("gender")
                                    {{$message}}    
                                    @enderror
        
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
                                
                                    @error("marital_status")
                                    {{$message}}    
                                    @enderror
        
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label" for="validationCustomEmail">Nationality</label>
                                <input class="form-control" id="validationCustom" type="text" name="nationality" value="{{old('nationality')}}"  placeholder="" aria-describedby="inputGroupPrepend" required="" data-bs-original-title="" title="">
                                
                                    @error("nationality")
                                    {{$message}}    
                                    @enderror
        
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label" for="validationCustomEmail">Religion</label>
                                <input class="form-control" id="validationCustom" type="text" name="religion" value="{{old('religion')}}"  placeholder="" aria-describedby="inputGroupPrepend" required="" data-bs-original-title="" title="">
                                
                                    @error("religion")
                                    {{$message}}    
                                    @enderror
        
                            </div>

                        </div>

                        <div class="row g-3">
                            
                            <div class="col-md-3">
                                <label class="form-label">Hired at</label>
                                <div class="col-sm-12">
                                    <input class="form-control digits" name="hired_at" type="date">
                                </div>
                                
                                    @error("hired_at")
                                    {{$message}}    
                                    @enderror
        
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Joined at</label>
                                <div class="col-sm-12">
                                    <input class="form-control digits" name="joined_at" type="date">
                                </div>
                                
                                    @error("joined_at")
                                    {{$message}}    
                                    @enderror
        
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Resigned at</label>
                                <div class="col-sm-12">
                                    <input class="form-control digits" name="resigned_at" type="date">
                                </div>
                                
                                    @error("resigned_at")
                                    {{$message}}    
                                    @enderror
        
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
                                
                                    @error("source_of_hire")
                                    {{$message}}    
                                    @enderror
        
                            </div>

                            <div class="col-md-3">
                                <label class="form-label" for="validationCustom04">Job Type</label>
                                <select name="job_type"  class="form-select" id="validationCustom04" required="">

                                    <option selected="true" disabled value="">Choose...</option>
                                    <option   value="full_time">Full time</option>
                                    <option   value="part_time">Part time</option>
                                    <option   value="contract">Contract</option>
                                    <option   value="internship">Internship</option>
                                    <option   value="freelance">Freelance</option>
                        
                                </select>
                                
                                    @error("job_type")
                                    {{$message}}    
                                    @enderror
        
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
                                
                                    @error("status")
                                    {{$message}}    
                                    @enderror
        
                            </div>

                        </div>
                        <div class="row">

                            <div class="col-md-3 mb-3">
                                <label class="form-label" for="validationCustomEmail">Education</label>
                                <input class="form-control" id="validationCustom" type="text" name="education" value="{{old('education')}}"  placeholder="" aria-describedby="inputGroupPrepend" required="" data-bs-original-title="" title="">
                                
                                    @error("education")
                                    {{$message}}    
                                    @enderror
        
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label" for="validationCustomEmail">Work experience</label>
                                <input class="form-control" id="validationCustom" type="number" name="work_experience" value="{{old('education')}}"  placeholder="" aria-describedby="inputGroupPrepend" required="" data-bs-original-title="" title="">
                                
                                    @error("work_experience")
                                    {{$message}}    
                                    @enderror
        
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label" for="validationCustomEmail">Salary</label>
                                <input class="form-control" id="validationCustom" type="number" name="salary" value="{{old('salary')}}"  placeholder="" aria-describedby="inputGroupPrepend" required="" data-bs-original-title="" title="">
                                
                                    @error("salary")
                                    {{$message}}    
                                    @enderror
        
                            </div>

                        </div>

                        <div class="row">

                            <div class="col-md-9">

                                <div class="row">
                                    <div class="o-hidden">
                                        <div class="mb-2">
                                            <div class="form-label">Reporting To</div>
                                            <select name="supervisor_id" class="js-example-basic-single col-sm-12">
                                                @foreach ($supervisors as $supervisors)
                                                <option value="{{ $supervisors->id }}">
                                                    {{ $supervisors->first_name}} {{ $supervisors->last_name}}
                                                </option>
                                             @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                        </div>

                        <div class="row">

                            <div class="col-md-9">
                                <div>
                                    <label class="form-label" for="exampleFormControlTextarea14">Biography </label>
                                    <textarea name="biography" class="form-control btn-square" id="exampleFormControlTextarea14" rows="8"></textarea>
                                  </div>

                                
                                    @error("biography")
                                    {{$message}}    
                                    @enderror
        
                            </div>

                        </div>


                        <h5 class="my-3">Legal Documents</h5>

                        <div class="row mb-5">

                            <div class="col-md-3">
                                <label class="form-label" for="validationCustomEmail">Passport ID</label>
                                <input class="form-control" id="validationCustom" type="text" name="passport" value="{{old('passport')}}"  placeholder="" aria-describedby="inputGroupPrepend" required="" data-bs-original-title="" title="">
                                
                                    @error("passport")
                                    {{$message}}    
                                    @enderror
        
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Passport Issue Date</label>
                                <div class="col-sm-12">
                                    <input class="form-control digits" name="passport_issued_at" type="date">
                                </div>
                                
                                    @error("passport_issued_at")
                                    {{$message}}    
                                    @enderror
        
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Passport Expiry Date</label>
                                <div class="col-sm-12">
                                    <input class="form-control digits" name="passport_expires_at"  type="date" >
                                </div>
                                
                                    @error("passport_expires_at")
                                    {{$message}}    
                                    @enderror
        
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
                                    <option   value="bank_transfer">Bank Transfer</option>
                        
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
<script src="{{asset('assets/js/select2/select2.full.min.js')}}"></script>
<script src="{{asset('assets/js/select2/select2-custom.js')}}"></script>
<script src="{{asset('assets/js/form-wizard/form-wizard.js')}}"></script>
@endsection
