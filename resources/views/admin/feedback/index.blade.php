@extends('layouts.admin')

@section('title', '{{ $page_title }}')

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
    <h3>{{ $page_title }}</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item active">{{ $page_title }}</li>
@endsection

@section('content')

<div class="container-fluid">
    <div class="row">

        <!-- Zero Configuration  Starts-->
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h5>Feedback Form</h5>
                </div>
                <div class="card-body">
                    <form enctype="multipart/form-data" action="{{route("admin.feedback.send")}}" method="POST" class="needs-validation" novalidate="">
                        @csrf
                            <div class="row my-3">
                                <div class="col-md-6">
                                    <label class="form-label" for="reqType">Type of Request</label>
                                    <select name="reqType"  class="form-select" id="reqType" required="">
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
                                    <label class="form-label" for="subject">Subject</label>
                                    <input class="form-control" id="subject" name="subject" type="text"  required="" data-bs-original-title="" title="">
                                    <div class="text-danger mt-1">
                                        @error("address")
                                        {{$message}}    
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row my-3">
                                <div class="col-md-6">
                                    <label class="col-sm-3 col-form-label">Choose File</label>
                                    <input name="file" class="form-control" type="file">
                                    <div class="text-danger mt-1">
                                        @error("file")
                                        {{$message}}    
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row my-3">
                                <div class="col-md-6">
                                    <div>
                                        <label class="form-label" for="exampleFormControlTextarea14">Describe your issue.</label>
                                        <textarea name="topic" class="form-control btn-square" id="exampleFormControlTextarea14" rows="8"></textarea>
                                      </div>
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