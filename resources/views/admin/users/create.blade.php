@extends('layouts.admin')

@section('title', 'Default')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/animate.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/prism.css') }}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/select2.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/date-picker.css')}}">
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
                            <div class="row g-2">
							    <div class="mb-3 col-md-6">
							    	<label class="form-label" for="first_name">First Name</label>
                                    <input class="form-control" type="text" id="first_name" name="first_name" value="{{old('first_name')}}"  required>

                                    @error("first_name")
                                    <div class="invalid-feedback">{{$message}} </div>      
                                    @enderror
                                </div>
							    <div class="mb-3 col-md-6">
                                    <label class="form-label" for="last_name">Last Name</label>
                                    <input class="form-control" type="text" id="last_name" name="last_name" value="{{old('last_name')}}" type="text" required>

                                    @error("last_name")
                                    <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
							    </div>
							</div>
                            <div class="mb-3">
								<label for="email">Email address</label>
								<input class="form-control" type="email" id="email" value="{{old('email')}}" required>
                                @error("email")
                                <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
							<div class="mb-3">
								<label class="form-label" for="phone">Phone Number</label>
                                <input class="form-control" id="phone" type="tel" name="phone" value="{{old('phone')}}" required>
                                
                                @error("phone")
                                <div class="invalid-feedback">{{$message}}</div>  
                                @enderror
							</div>
							<div class="mb-3">
								<label class="form-label" for="password">Password</label>
                                <input class="form-control" id="password" type="password" name="password" required>
                                @error("password")
                                <div class="invalid-feedback">{{$message}}</div>
                                @enderror
							</div>
							<div class="mb-3">
								<label class="form-label" for="password_confirmation">Confirm password</label>
                                <input class="form-control" id="password_confirmation" type="password" name="password_confirmation" required>
                                <div class="invalid-feedback">
                                @error("password_confirmation")
                                {{$message}}
                                @else
                                Password Doesn't match
                                @enderror
                                </div>
							</div>
						</div>
						<div class="tab">
                            <h5 class="my-3">User personal Details</h5>
							<div class="row g-3">
							    <div class="mb-3 col-md-4">
                                    <label class="form-label" for="role">Role</label>
                                    <select name="role" class="form-select" id="role" required>
                                        <option selected>Choose a Role...</option>
                                        @foreach ($roles as $key => $role)
                                            <option value="{{ $role->id }}" @if (old('role') == $role->id) selected @endif>
                                                {{ $role->title }}
                                            </option>
                                         @endforeach

                                    </select>
                                    @error("role")
                                     <div class="invalid-feedback">{{$message}}</div>   
                                    @enderror
                                </div>
							    <div class="mb-3 col-md-4">
                                    <label for="date_of_birth" class="form-label">Date of birth</label>
                                    <div class="col-sm-12">
                                        <input class="datepicker-here form-control digits" type="text" data-language="en" id="date_of_birth" name="date_of_birth" value="{{date('Y-m-d')}}">
                                    </div>
                                    @error("date_of_birth")
                                    <div class="invalid-feedback">{{$message}}</div>    
                                    @enderror
                                </div>
							    <div class="mb-3 col-md-4">
                                    <label class="form-label" for="gender">Gender</label>
                                    <select name="gender"  class="form-select" id="gender" required>

                                        <option selected disabled>Choose a gender...</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                        
                                    </select>
                                
                                    @error("gender")
                                    <div class="invalid-feedback">{{$message}}</div>  
                                    @enderror
        
                                </div>
                            </div>
							<div class="row g-3">
							    <div class="mb-3 col-md-4">
                                    <label class="form-label" for="marital_status">Marital status</label>
                                    <select name="marital_status"  class="form-select" id="marital_status" required>
                                        <option selected disabled>Choose...</option>
                                        <option value="Bachelor">Bachelor</option>
                                        <option value="Married">Married</option>
                                    </select>
                                
                                    @error("marital_status")
                                    <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>
							    <div class="mb-3 col-md-4">
                                    <label class="form-label" for="nationality">Nationality</label>
                                    <input class="form-control" id="nationality" type="text" name="nationality" value="{{old('nationality')}}"  required>
                                
                                    @error("nationality")
                                    <div class="invalid-feedback">{{$message}}</div>   
                                    @enderror
                                </div>
							    <div class="mb-3 col-md-4">
                                    <label class="form-label" for="religion">Religion</label>
                                    <input class="form-control" id="religion" type="text" name="religion" value="{{old('religion')}}"  required>
                                
                                    @error("religion")  
                                    <div class="invalid-feedback">{{$message}}</div>   
                                    @enderror
        
                                </div>
                            </div>
							<div class="row g-3">
							    <div class="mb-3 col-md-6">
                                    <label class="form-label" for="personal_email">Personal Email (optional)</label>
                                    <input class="form-control" id="personal_email" type="text" name="personal_email" value="{{old('email')}}">

                                    @error("personal_email")
                                    <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>
							    <div class="mb-3 col-md-6">
                                    <label class="form-label" for="mobile">Mobile Number (optional)</label>
                                    <input class="form-control" id="mobile" type="tel" name="mobile" value="{{old('mobile')}}">

                                    @error("mobile")
                                    <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>
                            </div>
                            <h5 class="my-3">User job Detail</h5>
                            <div class="row g-3">
                                <div class="col-md-4 mb-3">
                                    <label for="hired_at" class="form-label">Hiring Date</label>
                                    <input class="datepicker-here form-control digits" type="text" data-language="en" id="hired_at" name="hired_at" value="{{date('Y-m-d')}}" required>
                                   
                                    @error("hired_at")
                                    <div class="invalid-feedback">{{$message}}</div>   
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="joined_at" class="form-label">Joining Date</label>
                                    <input class="datepicker-here form-control digits" type="text" data-language="en" id="joined_at" name="joined_at" required>
                                    
                                    @error("joined_at")
                                    <div class="invalid-feedback">{{$message}}</div>   
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="resigned_at" class="form-label">Resigning Date</label>
                                    <input class="datepicker-here form-control digits" type="text" data-language="en" id="resigned_at" name="resigned_at">
                                    
                                    @error("resigned_at")
                                    <div class="invalid-feedback">{{$message}}</div>   
                                    @enderror
                                </div>
                            </div>
                            <div class="row g-3">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label" for="source_of_hire">Source Of Hiring</label>
                                    <select name="source_of_hire" class="form-select" id="source_of_hire" required>
                                        <option selected disabled>Choose...</option>
                                        <option value="direct">Direct</option>
                                        <option value="refaral">Refaral</option>
                                        <option value="online">Online</option>
                                    </select>

                                    @error("source_of_hire")
                                    <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label" for="job_type">Job Type</label>
                                    <select name="job_type" class="form-select" id="job_type" required>
                                        <option selected disabled>Choose...</option>
                                        <option   value="full_time">Full time</option>
                                        <option   value="part_time">Part time</option>
                                        <option   value="contract">Contract</option>
                                        <option   value="internship">Internship</option>
                                        <option   value="freelance">Freelance</option>
                                    </select>

                                    @error("job_type")
                                    <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label" for="status">Status</label>
                                    <select name="status" class="form-select" id="status" required>
                                        <option value="active" selected>active</option>
                                        <option value="terminated">terminated</option>
                                        <option value="resigned">resigned</option>
                                        <option value="deceased">deceased</option>
                                    </select>

                                    @error("status")
                                    <div class="invalid-feedback">{{$message}}</div> 
                                    @enderror
                                </div>
                            </div>
                            <div class="row g-3">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label" for="salary">Salary</label>
                                    <input class="form-control" id="salary" type="number" name="salary" value="{{old('salary')}}" required>

                                    @error("salary")
                                    <div class="invalid-feedback">{{$message}}</div>   
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label" for="supervisor_id">Reporting to</label>
                                    <select id="supervisor_id" name="supervisor_id" class="js-example-basic-single">
                                        @foreach ($supervisors as $supervisors)
                                        <option value="{{ $supervisors->id }}">
                                            {{ $supervisors->first_name}} {{ $supervisors->last_name}}
                                        </option>
                                        @endforeach
                                    </select>

                                    @error("supervisor_id")
                                    <div class="invalid-feedback">{{$message}}</div>   
                                    @enderror
                                </div>
                            </div>
						</div>
						<div class="tab">
							<div class="row g-3 my-3">
                                <div class="mb-3 col-md-4 row">
                                    <div class="text-center">
                                         <img id="profile-preview" width="200" src="{{ asset('assets/images/placeholder.png') }}" alt="Placeholder">
                                    </div>
                                    <div class="text-center">
                                        <label for="image" class="btn btn-primary my-3">Change Profile Picture</label>
                                        <input name="image" id="image" class="form-control d-none" type="file">
                                        
                                        @error("image")
                                        <div class="invalid-feedback">{{$message}}</div> 
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-8 mb-3">
                                    <label class="form-label" for="biography">Biography (optional)</label>
                                    <textarea name="biography" class="form-control btn-square" id="biography" rows="8"></textarea>
                                
                                    @error("biography")
                                    <div class="invalid-feedback">{{$message}}</div> 
                                    @enderror
                                </div>
                            </div>
						</div>
						<div class="tab">
                            <h5 class="my-3">User Address</h5>
                            <div class="row mb-5">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="address">Address</label>
                                    <input class="form-control" id="address" type="address" name="address" value="{{old('address')}}"  required>

                                    @error("address")
                                    <div class="invalid-feedback">{{$message}}</div> 
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="address2">Second Address (optional)</label>
                                    <input class="form-control" id="address2" type="address" name="address2" value="{{old('address2')}}">
                                   
                                    @error("address2")
                                    <div class="invalid-feedback">{{$message}}</div> 
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="city">City</label>
                                    <select name="city" class="form-select" id="city" required>
                                        <option value="Abu Dhabi" @if (old('city'))selected @endif>Abu Dhabi</option>
                                        <option value="Dubai" @if (old('city'))selected @endif>Dubai</option>
                                        <option value="Sharjah" @if (old('city'))selected @endif>Sharjah</option>
                                        <option value="Ajman" @if (old('city'))selected @endif>Ajman</option>
                                        <option value="Umm Al Quwain" @if (old('city'))selected @endif>Umm Al Quwain</option>
                                        <option value="Ras Al Khaimah" @if (old('city'))selected @endif>Ras Al Khaimah</option>
                                        <option value="Fujairah" @if (old('city'))selected @endif>Fujairah</option>
                                    </select>

                                    @error("city")
                                    <div class="invalid-feedback">{{$message}}</div> 
                                    @enderror 
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="country">country</label>
                                    <input class="form-control" id="country" type="text" name="country" value="{{old('address')}}"  required>
                                    <div class="text-danger mt-1">
                                
                                    @error("country")
                                    <div class="invalid-feedback">{{$message}}</div>   
                                    @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
						<div class="tab">
							<h5 class="my-3">Legal Documents</h5>

                            <div class="row mb-5">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="validationCustomEmail">Passport No.</label>
                                    <input class="form-control" id="validationCustom" type="text" name="passport" value="{{old('passport')}}">

                                    @error("passport")
                                    <div class="invalid-feedback">{{$message}}</div>   
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Passport Issue Date</label>
                                    <div class="col-sm-12">
                                        <input class="form-control digits" name="passport_issued_at" type="date">
                                    </div>

                                    @error("passport_issued_at")
                                    <div class="invalid-feedback">{{$message}}</div>    
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Passport Expiry Date</label>
                                    <div class="col-sm-12">
                                        <input class="form-control digits" name="passport_expires_at"  type="date" >
                                    </div>

                                    @error("passport_expires_at")
                                    <div class="invalid-feedback">{{$message}}</div>   
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="col-sm-3 col-form-label">Passport</label>
                                    <input name="passport_file" class="form-control" type="file">
                                     
                                    @error("passport_file")
                                    <div class="invalid-feedback">{{$message}}</div>      
                                    @enderror 
                                </div>
                            </div>
                            <div class="row mb-5">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="validationCustomEmail">Emirates ID</label>
                                    <input class="form-control" id="validationCustom" type="text" name="nid" value="{{old('nid')}}">
                                    
                                    @error("nid")
                                    <div class="invalid-feedback">{{$message}}</div>      
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Emirates ID Issue Date</label>
                                    <div class="col-sm-12">
                                        <input class="form-control digits" name="nid_issued_at"  type="date" >
                                    </div>
                                    
                                    @error("nid_issued_at")
                                    <div class="invalid-feedback">{{$message}}</div>     
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Emirates ID Expiry Date</label>
                                    <div class="col-sm-12">
                                        <input class="form-control digits" name="nid_expires_at"  type="date" >
                                    </div>
                                    
                                    @error("nid_expires_at")
                                    <div class="invalid-feedback">{{$message}}</div>      
                                    @enderror 
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="col-sm-3 col-form-label">Emirates ID</label>
                                    <input name="nid_file" class="form-control" type="file">
                                    
                                    @error("nid_file")
                                    <div class="invalid-feedback">{{$message}}</div>       
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-5">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="validationCustomEmail">Visa</label>
                                    <input class="form-control" id="validationCustom" type="text" name="visa" value="{{old('visa')}}">
                                    
                                    @error("visa")
                                    <div class="invalid-feedback">{{$message}}</div>       
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Visa Issue Date</label>
                                    <div class="col-sm-12">
                                        <input class="form-control digits" name="visa_issued_at"  type="date" >
                                    </div>
                                    
                                    @error("visa_issued_at")
                                    <div class="invalid-feedback">{{$message}}</div>       
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Visa Expiry Date</label>
                                    <div class="col-sm-12">
                                        <input class="form-control digits" name="visa_expires_at"  type="date" >
                                    </div>
                                    
                                    @error("visa_expires_at")
                                    <div class="invalid-feedback">{{$message}}</div>       
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="col-sm-3 col-form-label">Visa</label>
                                    <input name="visa_file" class="form-control" type="file">
                                    
                                    @error("visa_file")
                                    <div class="invalid-feedback">{{$message}}</div>       
                                    @enderror
                                </div>
                            </div>
						</div>
						<div class="tab">
                            <h5 class="my-3">Bank Details</h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
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
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="validationCustomEmail">Bank Name</label>
                                    <input class="form-control" id="validationCustom" type="text" name="bank_name" value="{{old('bank_name')}}"  placeholder="" aria-describedby="inputGroupPrepend" required="" data-bs-original-title="" title="">
                                    <div class="text-danger mt-1">
                                        @error("bank_name")
                                        {{$message}}    
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="validationCustomEmail">Bank Account Number</label>
                                    <input class="form-control" id="validationCustom" type="text" name="bank_account_number" value="{{old('bank_account_number')}}"  placeholder="" aria-describedby="inputGroupPrepend" required="" data-bs-original-title="" title="">
                                    <div class="text-danger mt-1">
                                        @error("bank_account_number")
                                        {{$message}}    
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="validationCustomEmail">IBAN</label>
                                    <input class="form-control" id="validationCustom" type="text" name="iban" value="{{old('iban')}}"  placeholder="" aria-describedby="inputGroupPrepend" required="" data-bs-original-title="" title="">
                                    <div class="text-danger mt-1">
                                        @error("iban")
                                        {{$message}}    
                                        @enderror
                                    </div>
                                </div>
                            </div>
						</div>
						<div>
							<div class="text-end btn-mb">
								<button class="btn btn-secondary" id="prevBtn" type="button" onclick="nextPrev(-1)">Previous</button>
								<button class="btn btn-primary" id="nextBtn" type="button" onclick="nextPrev(1)">Next</button>
							</div>
						</div>
						<!-- Circles which indicates the steps of the form:-->
						<div class="text-center">
                            <span class="step"></span>
                            <span class="step"></span>
                            <span class="step"></span>
                            <span class="step"></span>
                            <span class="step"></span>
                            <span class="step"></span>
                        </div>
						<!-- Circles which indicates the steps of the form:-->
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
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

                        

                        

                        <div class="row">

                            <div class="col-md-9">

                                <div class="row">
                                    <div class="o-hidden">
                                        <div class="mb-2">
                                            <div class="form-label">Reporting To</div>
                                            
                                        </div>
                                    </div>
                                </div>

                        </div>

                        <div class="row">

                            <div class="col-md-9">
                                
                                    
        
                            </div>

                        </div>


                       

                        


                    <h5 class="my-3">User Password</h5>


                         


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
<script src="{{asset('assets/js/datepicker/date-picker/datepicker.js')}}"></script>
<script src="{{asset('assets/js/datepicker/date-picker/datepicker.en.js')}}"></script>
<script src="{{asset('assets/js/datepicker/date-picker/datepicker.custom.js')}}"></script>
<script src="{{asset('assets/js/select2/select2.full.min.js')}}"></script>
<script src="{{asset('assets/js/select2/select2-custom.js')}}"></script>
<script src="{{asset('assets/js/form-wizard/form-wizard.js')}}"></script>
<script type="text/javascript">
    $('#image').change( e => {
        var reader = new FileReader();
        reader.onload = function(){
            var output = document.getElementById('profile-preview');
            output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    });
</script>
@endsection