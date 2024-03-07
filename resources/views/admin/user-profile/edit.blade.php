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

        .file_view {
            cursor: pointer;
        }
    </style>
@endsection

@section('breadcrumb-title')
    <h3>User Details</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item active">User Profile</li>
    <li class="breadcrumb-item">{{ $page_title }}</li>
@endsection

@section('content')
    <div class="container card">
        <form action="{{ route('admin.account.profile.update') }}" method="POST" enctype="multipart/form-data"
            class="needs-validation" novalidate="">
            @csrf
            @method('PUT')
            <div class="card-header">
                <h4 class="card-title mb-0"></h4>
                <div class="d-flex justify-content-end">
                    <div>
                        <a class="btn btn-primary" href="{{ route('admin.account.profile') }}" class="mx-2">Back</a>
                        <button class="btn btn-primary" type="submit">Save</button>
                    </div>
                </div>
            </div>
            <div class="card-body">


                @if (!empty($user->profile->image))
                    <div class="row mb-4 d-flex align-items-center">
                        <img id="profile-image" height="140px" width="140px"
                            src="{{ asset('storage/profile_images/' . $user->profile->image ?? '') }}" alt="Profile Picture"
                            class="rounded-circle media profile-media profile-image"
                            style="max-width: 150px; max-height: 150px;">

                        <div class="col-md-6">
                            <label class="col-sm-3 col-form-label">Profile picture</label>
                            <input id="profile-file" name="image" class="form-control" type="file">
                            {{-- <div class="valid-feedback">Looks good!</div> --}}
                            <div class="text-danger mt-1">
                                @error('image')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>

                    </div>
                @else
                    <div class="row mb-4 d-flex align-items-center">
                        <img id="profile-image" height="140px" width="140px"
                            class="rounded-circle media profile-media profile-image"
                            style="max-width: 150px; max-height: 150px;"
                            src="{{ asset('storage/profile_images/placeholder.png') }}" alt="">

                        <div class="col-md-6">
                            <label class="col-sm-3 col-form-label">Profile picture</label>
                            <input id="profile-file" name="image" class="form-control" type="file">
                            {{-- <div class="valid-feedback">Looks good!</div> --}}
                            <div class="text-danger mt-1">
                                @error('image')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>


                    </div>
                @endif



                <div class="row mb-4">
                    <div class="col-md-10">
                        <h4 class="my-3">Biography</h4>
                        <div class="row">

                            <div class="col-md-9">
                                <div>
                                    <textarea name="biography" class="form-control btn-square" id="exampleFormControlTextarea14" rows="8">{{ $user->profile->biography ?? '' }}</textarea>
                                </div>

                                <div class="text-danger mt-1">
                                    @error('biography')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <h5 class="my-3">User personal Detail</h5>

                <div class="col-md-12">

                    <div class="row ">

                        <div class="col-md-4">
                            <label class="form-label" for="validationCustom01">First Name</label>
                            <input class="form-control" id="validationCustom01" name="first_name"
                                value="{{ $user->first_name }}" type="text" required="" data-bs-original-title=""
                                title="">
                            {{-- <div class="valid-feedback">Looks good!</div> --}}
                            <div class="text-danger mt-1">
                                @error('first_name')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label" for="validationCustom01">Last Name</label>
                            <input class="form-control" id="validationCustom01" name="last_name"
                                value="{{ $user->last_name }}" type="text" required="" data-bs-original-title=""
                                title="">
                            {{-- <div class="valid-feedback">Looks good!</div> --}}
                            <div class="text-danger mt-1">
                                @error('last_name')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label" for="validationCustomEmail">Personal email (optional)</label>
                            <input class="form-control" id="validationCustom" type="text" name="personal_email"
                                placeholder="Email" value="{{ $user->profile->email ?? '' }}"
                                aria-describedby="inputGroupPrepend" required="" data-bs-original-title=""
                                title="">
                            <div class="text-danger mt-1">
                                @error('personal_email')
                                    {{ $message }}
                                @enderror
                            </div>

                        </div>

                        @if (empty($user->profile->date_of_birth))
                            <div class="col-md-4">
                                <label class="form-label">Date of birth</label>
                                <div class="col-sm-12">
                                    <input class="form-control digits" name="date_of_birth"
                                        value="{{ $user->profile->date_of_birth ?? '' }}" type="date"
                                        value="2018-01-01">
                                </div>
                                <div class="text-danger mt-1">
                                    @error('date_of_birth')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                        @endif

                        <div class="col-md-4 mb-3">
                            <label class="form-label" for="validationCustomEmail">Phone Number</label>
                            <input class="form-control" id="validationCustom" type="tel" name="phone"
                                placeholder="+971 50 123 4567" value="{{ $user->profile->phone ?? '' }}"
                                aria-describedby="inputGroupPrepend" required="" data-bs-original-title=""
                                title="">
                            <div class="text-danger mt-1">
                                @error('phone')
                                    {{ $message }}
                                @enderror
                            </div>

                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label" for="validationCustomEmail">Phone Number (optional)</label>
                            <input class="form-control" id="validationCustom" type="tel" name="mobile"
                                placeholder="+971 50 123 4567" value="{{ $user->profile->mobile ?? '' }}"
                                aria-describedby="inputGroupPrepend" required="" data-bs-original-title=""
                                title="">
                            <div class="text-danger mt-1">
                                @error('mobile')
                                    {{ $message }}
                                @enderror
                            </div>

                        </div>

                        <div class="col-md-4">
                            <label class="form-label" for="validationCustom04">Gender</label>
                            @if (empty($user->profile->gender))
                                <select name="gender" class="form-select" id="validationCustom04" required="">
                                    <option selected="true" disabled value="">Choose...</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            @else
                                <select name="gender" class="form-select" id="validationCustom04" required="">
                                    <option selected="true" disabled value="">Choose...</option>
                                    <option {{ $user->profile->gender == 'male' ? 'selected' : '' }} value="Male">Male
                                    </option>
                                    <option {{ $user->profile->gender == 'female' ? 'selected' : '' }} value="Female">
                                        Female</option>
                                </select>
                            @endif
                            <div class="text-danger mt-1">
                                @error('gender')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>


                        <div class="col-md-4">
                            <label class="form-label" for="validationCustom04">Marital status</label>
                            @if (empty($user->profile->marital_status))
                                <select name="marital_status" class="form-select" id="validationCustom04"
                                    required="">
                                    <option selected="true" disabled value="">Choose...</option>
                                    <option value="Bachelor">Bachelor</option>
                                    <option value="Married">Married</option>
                                </select>
                            @else
                                <select name="marital_status" class="form-select" id="validationCustom04"
                                    required="">
                                    <option selected="true" disabled value="">Choose...</option>
                                    <option {{ $user->profile->marital_status == 'Bachelor' ? 'selected' : '' }}
                                        value="Bachelor">Bachelor</option>
                                    <option {{ $user->profile->marital_status == 'Married' ? 'selected' : '' }}
                                        value="Married">Married</option>
                                </select>
                            @endif
                            <div class="text-danger mt-1">
                                @error('marital_status')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>


                        @if (empty($user->profile->nationality))
                            <div class="col-md-4 mb-3">
                                <label class="form-label" for="validationCustomEmail">Nationality</label>
                                <input class="form-control" id="validationCustom" type="text" name="nationality"
                                    value="{{ $user->profile->nationality ?? '' }}" placeholder=""
                                    aria-describedby="inputGroupPrepend" required="" data-bs-original-title=""
                                    title="">
                                <div class="text-danger mt-1">
                                    @error('nationality')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                        @endif

                        <div class="col-md-4 mb-3">
                            <label class="form-label" for="validationCustomEmail">Religion</label>
                            <input class="form-control" id="validationCustom" type="text" name="religion"
                                value="{{ $user->profile->religion ?? ' ' }}" placeholder=""
                                aria-describedby="inputGroupPrepend" required="" data-bs-original-title=""
                                title="">
                            <div class="text-danger mt-1">
                                @error('religion')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label" for="validationCustomEmail">Address</label>
                            <input class="form-control" id="validationCustom" type="address" name="address"
                                value="{{ $user->profile->address ?? '' }}" placeholder=""
                                aria-describedby="inputGroupPrepend" required="" data-bs-original-title=""
                                title="">
                            <div class="text-danger mt-1">
                                @error('address')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label" for="validationCustomEmail">Second Address (optional)</label>
                            <input class="form-control" id="validationCustom" type="address" name="address2"
                                value="{{ $user->profile->address2 ?? '' }}" placeholder=""
                                aria-describedby="inputGroupPrepend" required="" data-bs-original-title=""
                                title="">
                            <div class="text-danger mt-1">
                                @error('address2')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label" for="validationCustomEmail">City</label>
                            <input class="form-control" id="validationCustom" type="text" name="city"
                                value="{{ $user->profile->city ?? '' }}" placeholder=""
                                aria-describedby="inputGroupPrepend" required="" data-bs-original-title=""
                                title="">
                            <div class="text-danger mt-1">
                                @error('city')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label" for="validationCustomEmail">Province/State</label>
                            <input class="form-control" id="validationCustom" type="text" name="province"
                                value="{{ $user->profile->province ?? '' }}" placeholder=""
                                aria-describedby="inputGroupPrepend" required="" data-bs-original-title=""
                                title="">
                            <div class="text-danger mt-1">
                                @error('province')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label" for="validationCustomEmail">country</label>
                            <input class="form-control" id="validationCustom" type="text" name="country"
                                value="{{ $user->profile->country ?? '' }}" placeholder=""
                                aria-describedby="inputGroupPrepend" required="" data-bs-original-title=""
                                title="">
                            <div class="text-danger mt-1">
                                @error('country')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('script')

    <script>
        let profileImg = $('#profile-image')
        let profileFile = $('#profile-file')

        profileFile.change(function(e) {

            let file = e.target.files[0];
            var reader = new FileReader();

            if (file) {

                reader.onload = function(e) {
                    profileImg.attr('src', reader.result);
                }

                reader.readAsDataURL(file);
            }

        })
    </script>



    <script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatables/datatable.custom.js') }}"></script>
@endsection
