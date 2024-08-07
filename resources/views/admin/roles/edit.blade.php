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
    <li class="breadcrumb-item">System</li>
    <li class="breadcrumb-item">User Management</li>
    <li class="breadcrumb-item">{{trans('admin/role.editRole') }}</li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row starter-main">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h5>Edit Roles</h5>
                    <a class="btn btn-primary" href={{"/admin"."/".$url.'s'}}>{{trans('global.back') }}</a>
                </div>
                <div class="card-body">
                    <form action="{{route("admin.".$url.".update",['role'=>$role->id])}}" method="POST" class="needs-validation " novalidate="">
                        @csrf
                        @method('PUT')
                        <div class="row g-3 ">
                            <div class="col-md-6 d-flex align-items-center">
                                <label class="form-label" for="title">{{trans('admin/role.title') }}</label>
                                <input class="form-control mx-3" id="title" name="title" type="text" value="{{$role->title}}" required >
                                {{-- <div class="valid-feedback">Looks good!</div> --}}
                                <div class="text-danger mt-1">
                                    @error("title")
                                    {{$message}}    
                                    @enderror
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
                                @foreach ( $group as $category )
                                    @if($category['title'] != "Permissions" )
                                        <div class="col-4 my-4">
                                            <h6 class="permission-category" style="cursor: pointer;">{{ $category['title'] }}</h6>
                                            @foreach($category['permissions'] as $permission)
                                                    <div class="form-check checkbox checkbox-dark mb-0">
                                                        <input class="form-check-input" name="permissions[]" id={{"inline-".$permission['id']}} value="{{ $permission['id'] }}" type="checkbox" 
                                                            @if ($role->permissions->pluck('id')->contains($permission['id']))
                                                            checked
                                                            @endif
                                                        >
                                                        <label class="form-check-label" for={{"inline-".$permission['id']}}>{{ $permission['title'] }}</label>
                                                    </div>
                                            @endforeach 
                                        </div>
                                    @endif
                                @endforeach      
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-9 offset-md-10">
                                <button class="btn btn-primary" type="submit" >{{trans('admin/role.saveRole') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <
       
   
        <div class="container-fluid">
          
          </div>
        
    </div>
</div>

    <script type="text/javascript">
        var session_layout = '{{ session()->get('layout') }}';
    </script>
@endsection

@section('script')
<script>
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

        var selects = $('.select');

        if(selects.not(':checked').length == 0)  {
            $('#selectall').prop('checked', true);
        }    
        
        let permission_category =  document.getElementsByClassName('permission-category');

        permission_category.forEach(function (element) {
            element.addEventListener('click',function (e) {
                let parent = e.target.parentElement;
                let inputs = parent.getElementsByTagName('input');
                inputs.forEach(function (input){
                    input.checked = !input.checked;
                })
            })
        })
        
    });
</script>
@endsection
