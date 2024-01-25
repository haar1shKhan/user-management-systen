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
    <h3>{{ trans('admin/feedback.feedback') }}</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">{{ $page_title }}</li>
    <li class="breadcrumb-item active">{{ trans('admin/feedback.feedbackForm') }}</li>
@endsection

@section('content')

<div class="container-fluid">
    <div class="row">

        <!-- Zero Configuration  Starts-->
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h5>{{ trans('admin/feedback.feedbackForm') }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{route("admin.feedback.store")}}" method="POST" class="needs-validation" novalidate="">
                        @csrf
                            <div class="row my-3">
                                <div class="col-md-6">
                                    <label class="form-label" for="validationCustom04">{{ trans('admin/feedback.TypeOfRequest') }}</label>
                                    <select name="requestType"  class="form-select" id="validationCustom04" required="">

                                        <option selected="true" disabled value="">Choose...</option>
                                        <option   value="complaint">Complaint</option>
                                        <option   value="suggestion">Suggestion</option>
                            
                                    </select>
                                    <div class="text-danger mt-1">
                                        @error("requestType")
                                        {{$message}}    
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row my-3">
                                <div class="col-md-6">
                                    <label class="form-label" for="validationCustom01">{{ trans('admin/feedback.address') }}</label>
                                    <input class="form-control" id="validationCustom01" name="address" type="text"  required="" data-bs-original-title="" title="">
                                    {{-- <div class="valid-feedback">Looks good!</div> --}}
                                    <div class="text-danger mt-1">
                                        @error("address")
                                        {{$message}}    
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row my-3">
                                <div class="col-md-6">
                                    <label class="col-sm-3 col-form-label">{{ trans('admin/feedback.chooseFile')}}</label>
                                    <input name="chooseFile" class="form-control" type="file">
                                    {{-- <div class="valid-feedback">Looks good!</div> --}}
                                    <div class="text-danger mt-1">
                                        @error("chooseFile")
                                        {{$message}}    
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row my-3">
                                <div class="col-md-6">
                                    <div>
                                        <label class="form-label" for="exampleFormControlTextarea14">{{ trans('admin/feedback.topic')}}</label>
                                        <textarea name="topic" class="form-control btn-square" id="exampleFormControlTextarea14" rows="8"></textarea>
                                      </div>
                                    {{-- <div class="valid-feedback">Looks good!</div> --}}
                                    <div class="text-danger mt-1">
                                        @error("topic")
                                        {{$message}}    
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row my-3">
                            <div class="col-md-9 offset-md-10">
                                <button class="btn btn-primary" type="submit" data-bs-original-title="" title="">Submit</button>
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

    <script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatables/datatable.custom.js') }}"></script>
@endsection