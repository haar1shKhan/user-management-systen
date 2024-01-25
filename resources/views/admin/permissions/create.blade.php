@extends('layouts.admin')

@section('title', 'Default')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/animate.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/prism.css') }}">
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
    <h3>{{trans('admin/permission.permissions') }}</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Dashboard</li>
    <li class="breadcrumb-item active">{{trans('admin/permission.addPermission') }}</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row starter-main">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h5>{{trans('admin/permission.addPermission') }}</h5>
                    <a class="btn btn-primary" href={{"/admin"."/".$url.'s'}}>{{trans('global.back') }}</a>
                </div>
                <div class="card-body">
                    <form action="{{route('admin.'.$url.".store")}}" method="POST" class="needs-validation d-flex  " novalidate="">
                        @csrf
                        <div class="row g-3 ">
                            <div class="col-md-12 d-flex align-items-center">
                                <label class="form-label" for="validationCustom01">{{trans('admin/permission.title') }} : </label>
                                <div class="d-flex flex-column mx-3">
                                    <input class="form-control " id="validationCustom01" name="title" type="text" required="" data-bs-original-title="" title="">
                                    {{-- <div class="valid-feedback">Looks good!</div> --}}
                                    <div class="text-danger mt-1">
                                        @error("title")
                                        {{$message}}    
                                        @enderror
                                    </div>
                                </div>
                                <label class="form-label" for="validationCustom01">{{trans('admin/permission.slug') }} : </label>
                                <div class="d-flex flex-column mx-3">
                                    <input class="form-control " id="validationCustom01" name="slug" type="text" required="" data-bs-original-title="" title="">
                                    {{-- <div class="valid-feedback">Looks good!</div> --}}
                                    <div class="text-danger mt-1">
                                        @error("slug")
                                        {{$message}}    
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                     
                        <button class="btn btn-primary" type="submit" data-bs-original-title="" title="">{{trans('admin/permission.addPermission') }}</button>
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
