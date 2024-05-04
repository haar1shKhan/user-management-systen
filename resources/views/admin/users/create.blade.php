@extends('layouts.admin')

@section('title', 'Default')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/animate.css') }}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/prism.css') }}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/select2.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/date-picker.css')}}">
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
    <h3>الموظفين</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">System</li>
    <li class="breadcrumb-item">User Management</li>
    <li class="breadcrumb-item active">Create User</li>
@endsection

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<h5>إضافة موظف جديد</h5>
					<span>يرجى التأكد من ملء جميع الحقول قبل النقر على الزر التالي</span>
				</div>
				<div class="card-body">
					<form class="form-wizard" id="regForm" action="{{route("admin.user.store")}}" method="POST" enctype="multipart/form-data">
                        @csrf
						<div class="tab">
                            <div class="row g-2">
							    <div class="mb-3 col-md-6">
							    	<label class="form-label" for="first_name"><span class="text-danger">(اجباري)</span> الاسم الأول</label>
                                    <input class="form-control" type="text" id="first_name" name="first_name" value="{{old('first_name')}}"  required>

                                    @error("first_name")
                                    <div class="invalid-feedback">{{$message}} </div>      
                                    @enderror
                                </div>
							    <div class="mb-3 col-md-6">
                                    <label class="form-label" for="last_name"><span class="text-danger">(اجباري)</span> اسم العائلة</label>
                                    <input class="form-control" type="text" id="last_name" name="last_name" value="{{old('last_name')}}" type="text" required>

                                    @error("last_name")
                                    <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
							    </div>
							</div>
                            <div class="mb-3">
								<label for="email"> <span class="text-danger">(اجباري)</span> البريد الإلكتروني</label>
								<input class="form-control" type="email" id="email" name="email" value="{{old('email')}}" required>
                                @error("email")
                                <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
							<div class="mb-3">
								<label class="form-label" for="phone"><span class="text-danger">(اجباري)</span> رقم تليفون</label>
                                <input class="form-control" id="phone" type="tel" name="phone" value="{{old('phone')}}" required>
                                
                                @error("phone")
                                <div class="invalid-feedback">{{$message}}</div>  
                                @enderror
							</div>
							<div class="mb-3">
								<label class="form-label" for="password"><span class="text-danger">(اجباري)</span> كلمة المرور</label>
                                <input class="form-control" id="password" type="password" name="password" required>
                                @error("password")
                                <div class="invalid-feedback">{{$message}}</div>
                                @enderror
							</div>
							<div class="mb-3">
								<label class="form-label" for="password_confirmation"><span class="text-danger">(اجباري)</span> تأكيد كلمة المرور</label>
                                <input class="form-control" id="password_confirmation" type="password" name="password_confirmation" required>
                                <div class="invalid-feedback">
                                @error("password_confirmation")
                                {{$message}}
                                @else
                                كلمة المرور غير متطابقة
                                @enderror
                                </div>
							</div>
						</div>
						<div class="tab">
                            <h5 class="my-3">التفاصيل الشخصية</h5>
							<div class="row g-3">
							    <div class="mb-3 col-md-4">
                                    <label class="form-label" for="role">Role <span class="text-danger">(اجباري)</span></label>
                                    <select name="role" class="form-select" id="role" required>
                                        @foreach ($roles as $key => $role)
                                            <option value="{{ $role->id }}" @if ($role->id == 2) selected @endif>
                                                {{ $role->title }}
                                            </option>
                                         @endforeach

                                    </select>
                                    @error("role")
                                     <div class="invalid-feedback">{{$message}}</div>   
                                    @enderror
                                </div>
							    <div class="mb-3 col-md-4">
                                    <label for="date_of_birth" class="form-label"><span class="text-danger">(اجباري)</span> تاريخ الميلاد</label>
                                    <div class="col-sm-12">
                                        <input class="datepicker-here form-control digits" type="text" data-language="en" id="date_of_birth" name="date_of_birth" value="{{date('Y-m-d')}}">
                                    </div>
                                    @error("date_of_birth")
                                    <div class="invalid-feedback">{{$message}}</div>    
                                    @enderror
                                </div>
							    <div class="mb-3 col-md-4">
                                    <label class="form-label" for="gender"><span class="text-danger">(اجباري)</span> جنس</label>
                                    <select name="gender"  class="form-select" id="gender" required>

                                        <option selected value="">Choose a gender...</option>
                                        <option value="Male">ذكر</option>
                                        <option value="Female">أنثى</option>
                        
                                    </select>
                                
                                    @error("gender")
                                    <div class="invalid-feedback">{{$message}}</div>  
                                    @enderror
        
                                </div>
                            </div>
							<div class="row g-3">
							    <div class="mb-3 col-md-4">
                                    <label class="form-label" for="marital_status"><span class="text-danger">(اجباري)</span> الحالة الاجتماعية</label>
                                    <select name="marital_status"  class="form-select" id="marital_status" required>
                                        <option selected value="">Choose...</option>
                                        <option value="Bachelor">أعزب</option>
                                        <option value="Married">متزوج/متزوجة</option>
                                    </select>
                                
                                    @error("marital_status")
                                    <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>
							    <div class="mb-3 col-md-4">
                                    <label class="form-label" for="nationality"><span class="text-danger">(اجباري)</span> الجنسية</label>
                                    <input class="form-control" id="nationality" type="text" name="nationality" value="{{old('nationality')}}"  required>
                                
                                    @error("nationality")
                                    <div class="invalid-feedback">{{$message}}</div>   
                                    @enderror
                                </div>
							    <div class="mb-3 col-md-4">
                                    <label class="form-label" for="religion">الديانة (اختياري)</label>
                                    <input class="form-control" id="religion" type="text" name="religion" value="{{old('religion')}}">
                                
                                    @error("religion")  
                                    <div class="invalid-feedback">{{$message}}</div>   
                                    @enderror
        
                                </div>
                            </div>
							<div class="row g-3">
							    <div class="mb-3 col-md-6">
                                    <label class="form-label" for="personal_email">بريد إلكتروني إضافي (اختياري)</label>
                                    <input class="form-control" id="personal_email" type="text" name="personal_email" value="{{old('email')}}">

                                    @error("personal_email")
                                    <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>
							    <div class="mb-3 col-md-6">
                                    <label class="form-label" for="mobile">رقم تليفون إضافي (اختياري)</label>
                                    <input class="form-control" id="mobile" type="tel" name="mobile" value="{{old('mobile')}}">

                                    @error("mobile")
                                    <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>
                            </div>
                            <h5 class="my-3">بيانات الوظيفة</h5>
                            <div class="row g-3">
                                <div class="col-md-4 mb-3">
                                    <label for="hired_at" class="form-label"><span class="text-danger">(اجباري)</span> تاريخ التعيين</label>
                                    <input class="datepicker-here form-control digits" type="text" data-language="en" id="hired_at" name="hired_at" value="{{date('Y-m-d')}}" required>
                                   
                                    @error("hired_at")
                                    <div class="invalid-feedback">{{$message}}</div>   
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="joined_at" class="form-label"><span class="text-danger">(اجباري)</span> تاريخ مباشرة العمل</label>
                                    <input class="datepicker-here form-control digits" type="text" data-language="en" id="joined_at" name="joined_at" required>
                                    
                                    @error("joined_at")
                                    <div class="invalid-feedback">{{$message}}</div>   
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="resigned_at" class="form-label"> (اختياري) تاريخ الانتهاء</label>
                                    <input class="datepicker-here form-control digits" type="text" data-language="en" id="resigned_at" name="resigned_at">
                                    
                                    @error("resigned_at")
                                    <div class="invalid-feedback">{{$message}}</div>   
                                    @enderror
                                </div>
                            </div>
                            <div class="row g-3">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label" for="source_of_hire">مصدر التوظيف (اختياري)</label>
                                    <select name="source_of_hire" class="form-select" id="source_of_hire" >
                                        <option selected value="">Choose...</option>
                                        <option value="direct">التوظيف المباشر</option>
                                        <option value="refaral">الإحالة</option>
                                        <option value="online">التوظيف عبر الإنترنت</option>
                                    </select>

                                    @error("source_of_hire")
                                    <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label" for="job_type"><span class="text-danger">(اجباري)</span> نوع الوظيفة</label>
                                    <select name="job_type" class="form-select" id="job_type" required>
                                        <option selected value="">Choose...</option>
                                        <option   value="full_time">دوام كامل</option>
                                        <option   value="part_time">دوام جزئي</option>
                                        <option   value="contract">عقد</option>
                                        <option   value="internship">التدريب الداخلي</option>
                                        <option   value="freelance">مستقلة</option>
                                    </select>

                                    @error("job_type")
                                    <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label" for="status"><span class="text-danger">(اجباري)</span> حالة</label>
                                    <select name="status" class="form-select" id="status" required>
                                        <option value="active" selected>نشيط</option>
                                        <option value="terminated">تم إنهاؤه</option>
                                        <option value="resigned">استقال</option>
                                        <option value="deceased">فقيد</option>
                                    </select>

                                    @error("status")
                                    <div class="invalid-feedback">{{$message}}</div> 
                                    @enderror
                                </div>
                            </div>
                            <div class="row g-3">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label" for="salary"><span class="text-danger">(اجباري)</span> راتب</label>
                                    <input class="form-control" id="salary" type="number" name="salary" value="{{ old('salary') ? old('salary') : __('0') }}" required>

                                    @error("salary")
                                    <div class="invalid-feedback">{{$message}}</div>   
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label" for="supervisor_id"><span class="text-danger">(اجباري)</span> تقديم التقارير إلى</label>
                                    <select id="supervisor_id" name="supervisor_id" class="js-example-basic-single" required>
                                        @foreach ($supervisors as $supervisors)
                                        <option value="{{ $supervisors->id }}" @if($supervisors->id == 1)selected @endif>
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
                                        <label for="image" class="btn btn-primary my-3">(اختياري) تغيير صورة الملف الشخصي</label>
                                        <input name="image" id="image" class="form-control d-none" type="file">
                                        
                                        @error("image")
                                        <div class="invalid-feedback">{{$message}}</div> 
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-8 mb-3">
                                    <label class="form-label" for="biography">سيرة شخصية (اختياري)</label>
                                    <textarea name="biography" class="form-control btn-square" id="biography" rows="8"></textarea>
                                
                                    @error("biography")
                                    <div class="invalid-feedback">{{$message}}</div> 
                                    @enderror
                                </div>
                            </div>
						</div>
						<div class="tab">
                            <h5 class="my-3">عنوان المنزل</h5>
                            <div class="row mb-5">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="address"><span class="text-danger">(اجباري)</span> العنوان</label>
                                    <input class="form-control" id="address" type="address" name="address" value="{{old('address')}}"  required>

                                    @error("address")
                                    <div class="invalid-feedback">{{$message}}</div> 
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="address2">العنوان الثاني (اختياري)</label>
                                    <input class="form-control" id="address2" type="address" name="address2" value="{{old('address2')}}">
                                   
                                    @error("address2")
                                    <div class="invalid-feedback">{{$message}}</div> 
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="city"><span class="text-danger">(اجباري)</span> إمارة</label>
                                    <select name="city" class="form-select" id="city" required>
                                        <option value="Abu Dhabi" @if (old('city'))selected @endif>أبو ظبي</option>
                                        <option value="Dubai" @if (old('city'))selected @endif>دبي</option>
                                        <option value="Sharjah" @if (old('city'))selected @endif>الشارقة</option>
                                        <option value="Ajman" @if (old('city'))selected @endif>عجمان</option>
                                        <option value="Umm Al Quwain" @if (old('city'))selected @endif>أم القيوين</option>
                                        <option value="Ras Al Khaimah" @if (old('city'))selected @endif>رأس الخيمة</option>
                                        <option value="Fujairah" @if (old('city'))selected @endif>الفجيرة</option>
                                    </select>

                                    @error("city")
                                    <div class="invalid-feedback">{{$message}}</div> 
                                    @enderror 
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="country"><span class="text-danger">(اجباري)</span> الدولة</label>
                                    <input class="form-control" id="country" type="text" name="country" value="{{old('country') ?? __('الإمارات العربية المتحدة') }}"  required>
                                    <div class="text-danger mt-1">
                                
                                    @error("country")
                                    <div class="invalid-feedback">{{$message}}</div>   
                                    @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
						<div class="tab">
							<h5 class="my-3">وثائق قانونية</h5>

                            <div class="row mb-5">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="validationCustomEmail"> (اختياري) رقم جواز السفر.</label>
                                    <input class="form-control" id="validationCustom" type="text" name="passport" value="{{old('passport')}}">

                                    @error("passport")
                                    <div class="invalid-feedback">{{$message}}</div>   
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label"> (اختياري) تاريخ الإصدار</label>
                                    <div class="col-sm-12">
                                        <input class="form-control digits" name="passport_issued_at" type="date">
                                    </div>

                                    @error("passport_issued_at")
                                    <div class="invalid-feedback">{{$message}}</div>    
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label"> (اختياري) تاريخ الانتهاء</label>
                                    <div class="col-sm-12">
                                        <input class="form-control digits" name="passport_expires_at"  type="date" >
                                    </div>

                                    @error("passport_expires_at")
                                    <div class="invalid-feedback">{{$message}}</div>   
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="col-sm-3 col-form-label"> (اختياري) ارفاق جواز السفر</label>
                                    <input name="passport_file" class="form-control" type="file">
                                     
                                    @error("passport_file")
                                    <div class="invalid-feedback">{{$message}}</div>      
                                    @enderror 
                                </div>
                            </div>
                            <div class="row mb-5">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="validationCustomEmail"> (اختياري) رقم الهوية الاماراتية</label>
                                    <input class="form-control" id="validationCustom" type="text" name="nid" value="{{old('nid')}}">
                                    
                                    @error("nid")
                                    <div class="invalid-feedback">{{$message}}</div>      
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label"> (اختياري) تاريخ الإصدار</label>
                                    <div class="col-sm-12">
                                        <input class="form-control digits" name="nid_issued_at"  type="date" >
                                    </div>
                                    
                                    @error("nid_issued_at")
                                    <div class="invalid-feedback">{{$message}}</div>     
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label"> (اختياري) تاريخ الانتهاء</label>
                                    <div class="col-sm-12">
                                        <input class="form-control digits" name="nid_expires_at"  type="date" >
                                    </div>
                                    
                                    @error("nid_expires_at")
                                    <div class="invalid-feedback">{{$message}}</div>      
                                    @enderror 
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="col-sm-3 col-form-label"> (اختياري) ارفاق الهوية الاماراتية</label>
                                    <input name="nid_file" class="form-control" type="file">
                                    
                                    @error("nid_file")
                                    <div class="invalid-feedback">{{$message}}</div>       
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-5">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="validationCustomEmail"> (اختياري) رقم الاقامة</label>
                                    <input class="form-control" id="validationCustom" type="text" name="visa" value="{{old('visa')}}">
                                    
                                    @error("visa")
                                    <div class="invalid-feedback">{{$message}}</div>       
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label"> (اختياري) تاريخ الإصدار</label>
                                    <div class="col-sm-12">
                                        <input class="form-control digits" name="visa_issued_at"  type="date" >
                                    </div>
                                    
                                    @error("visa_issued_at")
                                    <div class="invalid-feedback">{{$message}}</div>       
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label"> (اختياري) تاريخ الانتهاء</label>
                                    <div class="col-sm-12">
                                        <input class="form-control digits" name="visa_expires_at"  type="date" >
                                    </div>
                                    
                                    @error("visa_expires_at")
                                    <div class="invalid-feedback">{{$message}}</div>       
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="col-sm-3 col-form-label"> (اختياري) ارفاق الاقامة</label>
                                    <input name="visa_file" class="form-control" type="file">
                                    
                                    @error("visa_file")
                                    <div class="invalid-feedback">{{$message}}</div>       
                                    @enderror
                                </div>
                            </div>
						</div>
						<div class="tab">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="payment_method"><span class="text-danger">(اجباري)</span> طريقة الدفع</label>
                                    <select name="payment_method"  class="form-select" id="payment_method" required>
                                        <option value="Cash">كاش</option>
                                        <option value="Bank Transfer">تحويل بنكي</option>
                                    </select>
                                    <div class="text-danger mt-1">
                                        @error("payment_method")
                                        {{$message}}    
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3 bank_name">
                                    <label class="form-label" for="bank_name">اسم البنك</label>
                                    <input class="form-control" id="bank_name" type="text" name="bank_name" value="{{old('bank_name')}}">
                                    <div class="text-danger mt-1">
                                        @error("bank_name")
                                        {{$message}}    
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3 bank_account_number">
                                    <label class="form-label" for="bank_account_number">رقم الحساب</label>
                                    <input class="form-control" id="bank_account_number" type="text" name="bank_account_number" value="{{old('bank_account_number')}}">
                                    <div class="text-danger mt-1">
                                        @error("bank_account_number")
                                        {{$message}}    
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3 iban">
                                    <label class="form-label" for="iban">IBAN</label>
                                    <input class="form-control" id="iban" type="text" name="iban" value="{{old('iban')}}">
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
								<button class="btn btn-secondary" id="prevBtn" type="button" onclick="nextPrev(-1)">السابق</button>
								<button class="btn btn-primary" id="nextBtn" type="button" onclick="nextPrev(1)">التالي</button> 
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
    $('.bank_account_number').css('display','none')
    $('.bank_name').css('display','none')
    $('.iban').css('display','none')
    $('#payment_method').change( e => {
        let value = $('#payment_method').val();
        if (value === 'Cash') {
            $('.bank_account_number').css('display','none')
            $('.bank_name').css('display','none')
            $('.iban').css('display','none')
        }else{
            $('.bank_account_number').css('display','block')
            $('.bank_name').css('display','block')
            $('.iban').css('display','block')
        }
    });
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