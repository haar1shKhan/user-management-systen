@extends('layouts.admin')

@section('title', 'Default')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/animate.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/prism.css') }}">
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
    <h3>{{trans('admin/role.roles') }}</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Dashboard</li>
    <li class="breadcrumb-item active">{{trans('admin/role.addRole') }}</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row starter-main">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h5>{{trans('admin/role.addRole') }}</h5>
                    <a class="btn btn-primary" href={{"/admin"."/".$url.'s'}}>{{trans('global.back') }}</a>
                </div>
                <div class="card-body">
                    <form action="{{route("admin.".$url.".store")}}" method="POST" class="needs-validation " novalidate="">
                        @csrf
                        <div class="row g-3 ">
                            <div class="col-md-12 d-flex align-items-center">
                                <label class="form-label" for="validationCustom01">{{trans('admin/role.title') }}</label>
                                <div class="d-flex flex-column mx-3">
                                    <input class="form-control " id="validationCustom01" name="title" type="text" required="" data-bs-original-title="" title="">
                                    {{-- <div class="valid-feedback">Looks good!</div> --}}
                                    <div class="text-danger mt-1">
                                        @error("title")
                                        {{$message}}    
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="my-5">
                            <div class="d-flex justify-content-between align-items-center ">
                                <h5 class="form-label my-4" for="validationCustom01">{{trans('admin/role.selectPermission') }}</h5>
                                <div class="form-check checkbox checkbox-dark mb-2 mx-3">
                                    <input id='selectall' class="form-check-input select-all-checkbox" data-category="all" type="checkbox">
                                    <label for="selectall" class="form-check-label">{{trans('global.selectAll') }}</label>
                                </div>
                            </div>
                            <div class="row">
                                @foreach($categories as $category)
                                    <div class="col">
                                        <h6 class="permission-category">{{ $category }}</h6>
                                        @foreach($permissions as $permission)
                                            @if (str_starts_with($permission->title, strtolower($category)))
                                            
                                                <div class="form-check checkbox checkbox-dark mb-0">
                                                    <input class="form-check-input" name="permissions[]" id={{"inline-".$permission->id}} value="{{ $permission->id }}" type="checkbox" data-bs-original-title="" title="">
                                                    <label class="form-check-label" for={{"inline-".$permission->id}}>{{ $permission->title }}</label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-9 offset-md-10">
                                <button class="btn btn-primary" type="submit" data-bs-original-title="" title="">{{ trans('admin/role.saveRole') }}</button>
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
<<script>
    $(document).ready(function () {
        // Function to handle the "Select All" checkbox
        $('#selectall').change(function () {
            $('.form-check-input[name="permissions[]"]').prop('checked', this.checked);
        });

        // Function to handle individual checkboxes
        $('.form-check-input[name="permissions[]"]').change(function () {
            if (!this.checked) {
                $('#selectall').prop('checked', false);
            }
        });
    });
</script>
@endsection

