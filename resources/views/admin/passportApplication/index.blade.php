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
    <h3>{{ trans('admin/passport.passportApplication') }}</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">{{ $page_title }}</li>
    <li class="breadcrumb-item active">{{ trans('admin/passport.passportApplicationForm') }}</li>
@endsection

@section('content')

<div class="container-fluid">
    <div class="row">

        <!-- Zero Configuration  Starts-->
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h5>{{ trans('admin/passport.passportApplicationForm') }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{route("admin.passport.store")}}" method="POST" class="needs-validation" novalidate="">
                        @csrf
                            <div class="row my-3">

                                <div class="col-md-3">
                                    <label class="form-label">{{ trans('admin/passport.dateOfApplication') }}</label>
                                    <input class="form-control digits" type="date" value= "{{date('Y-m-d')}}">  {{-- <div class="valid-feedback">Looks good!</div> --}}
                                    <div class="text-danger mt-1">
                                        @error("dateOfApplication")
                                        {{$message}}    
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="col-md-3">
                                    <label class="form-label" for="passportNumber">{{ trans('admin/passport.passportNumber') }}</label>
                                    <input class="form-control" id="passportNumber" name="passportNumber" type="text"  required>
                                    {{-- <div class="valid-feedback">Looks good!</div> --}}
                                    <div class="text-danger mt-1">
                                        @error("passportNumber")
                                        {{$message}}    
                                        @enderror
                                    </div>
                                </div>
                           
                                <div class="col-md-3">
                                    <label class="form-label" for="employeeNumber">{{ trans('admin/passport.employeeNumber') }}</label>
                                    <input class="form-control" id="employeeNumber" name="employeeNumber" type="text"  required>
                                    {{-- <div class="valid-feedback">Looks good!</div> --}}
                                    <div class="text-danger mt-1">
                                        @error("employeeNumber")
                                        {{$message}}    
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row my-3">

                                <div class="col-md-3">
                                    <label class="form-label" for="employeeName">{{ trans('admin/passport.employeeName') }}</label>
                                    <input class="form-control" id="employeeName" name="employeeName" type="text"  required>
                                    <div class="text-danger mt-1">
                                        @error("employeeName")
                                        {{$message}}    
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="col-md-3">
                                    <label class="form-label" for="role">{{ trans('admin/role.role') }}</label>
                                    <input class="form-control" id="role" name="role" type="text"  required>
                                    {{-- <div class="valid-feedback">Looks good!</div> --}}
                                    <div class="text-danger mt-1">
                                        @error("role")
                                        {{$message}}    
                                        @enderror
                                    </div>
                                </div>
                           
                                <div class="col-md-3">
                                    <label class="form-label" for="partSection">{{ trans('admin/passport.partSection') }}</label>
                                    <input class="form-control" id="partSection" name="partSection" type="text"  required>
                                    {{-- <div class="valid-feedback">Looks good!</div> --}}
                                    <div class="text-danger mt-1">
                                        @error("partSection")
                                        {{$message}}    
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row my-3">

                                <div class="col-md-2">
                                    <label class="form-label" for="numberOfDays">{{ trans('admin/passport.numberOfDays') }}</label>
                                    <input class="form-control" id="numberOfDays" name="numberOfDays" type="text"  required>
                                    <div class="text-danger mt-1">
                                        @error("numberOfDays")
                                        {{$message}}    
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="col-md-3">
                                    <label class="form-label" for="returnDate">{{ trans('admin/passport.returnDate') }}</label>
                                    <input class="form-control" id="returnDate" name="returnDate" type="text"  required>
                                    {{-- <div class="valid-feedback">Looks good!</div> --}}
                                    <div class="text-danger mt-1">
                                        @error("returnDate")
                                        {{$message}}    
                                        @enderror
                                    </div>
                                </div>
                           
                                <div class="col-md-2">
                                    <label class="form-label" for="replyStatus">{{ trans('admin/passport.replyStatus') }}</label>
                                    <input class="form-control" id="replyStatus" disabled name="replyStatus" type="text"  required>
                                    {{-- <div class="valid-feedback">Looks good!</div> --}}
                                    <div class="text-danger mt-1">
                                        @error("replyStatus")
                                        {{$message}}    
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label" for="clearanceForm">{{ trans('admin/passport.clearanceForm') }}</label>
                                    <input class="form-control" id="clearanceForm" disabled name="clearanceForm" type="text"  required>
                                    {{-- <div class="valid-feedback">Looks good!</div> --}}
                                    <div class="text-danger mt-1">
                                        @error("clearanceForm")
                                        {{$message}}    
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row my-3">

                                <div class="row">
                                    <div class="form-check checkbox checkbox-dark mb-0">

                                        <input class="form-check-input select" name="passportExCheckBox" id="passportExCheckBox" type="checkbox" data-bs-original-title="" title="">
                                        <label class="form-check-label" for="passportExCheckBox">{{ trans('admin/passport.passportExchange') }}</label>

                                    </div>
                                </div>
                                
                                <div class="row" id="passportExchangeFields">

                                        <div class="col-md-3">
                                            <label class="form-label" for="passportExchange">{{ trans('admin/passport.passportExchange') }}</label>
                                            <input class="form-control" id="passportExchange" name="passportNumber" type="text"  required>
                                            <div class="text-danger mt-1">
                                                @error("passportExchange")
                                                {{$message}}    
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-3">
                                            <label class="form-label" for="passportNameExchange">{{ trans('admin/passport.passportNameExchange') }}</label>
                                            <input class="form-control" id="passportNameExchange" name="passportNumber" type="text"  required>
                                            {{-- <div class="valid-feedback">Looks good!</div> --}}
                                            <div class="text-danger mt-1">
                                                @error("passportNameExchange")
                                                {{$message}}    
                                                @enderror
                                            </div>
                                        </div>
                                
                                        <div class="col-md-3">
                                            <label class="form-label" for="relationship">{{ trans('admin/passport.relationship') }}</label>
                                            <input class="form-control" id="relationship" name="address" type="text"  required>
                                            {{-- <div class="valid-feedback">Looks good!</div> --}}
                                            <div class="text-danger mt-1">
                                                @error("relationship")
                                                {{$message}}    
                                                @enderror
                                            </div>
                                        </div>

                                </div>

                                <div class="row my-3">
                                    <div class="col-md-8">
                                        <div>
                                            <label class="form-label" for="reason">{{ trans('admin/passport.reason')}}</label>
                                            <textarea name="reason" class="form-control btn-square" id="reason" rows="8"></textarea>
                                          </div>
                                        {{-- <div class="valid-feedback">Looks good!</div> --}}
                                        <div class="text-danger mt-1">
                                            @error("reason")
                                            {{$message}}    
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        <div class="row">
                            <div class="col-md-9 offset-md-10">
                                <button class="btn btn-primary" type="submit" data-bs-original-title="" title="">{{ trans('global.submit') }}</button>
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
    
     <script>
        $(document).ready(function () {
            // Initial check when the page loads
            togglePassportExchangeFields();

            // Add an event listener to the Passport Exchange checkbox
            $('#passportExCheckBox').change(function () {
                togglePassportExchangeFields();
            });
        });

        function togglePassportExchangeFields() {
            // Get the Passport Exchange checkbox element
            var passportExCheckBox = $('#passportExCheckBox');

            // Get the container div for the fields
            var passportExchangeFields = $('#passportExchangeFields');

            // Check if the Passport Exchange checkbox is checked
            if (passportExCheckBox.prop('checked')) {
                // If checked, show the container div
                passportExchangeFields.show();
            } else {
                // If not checked, hide the container div and clear the values
                passportExchangeFields.hide();
                // You may also want to clear the values of the fields within this container
            }
        }
    </script>

    <script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatables/datatable.custom.js') }}"></script>
@endsection