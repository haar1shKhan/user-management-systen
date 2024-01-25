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
    <h3>{{trans('admin/permission.permissions') }}</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">{{ $page_title }}</li>
    <li class="breadcrumb-item active">{{trans('admin/permission.permissions') }}</li>
@endsection

@section('content')

<div class="container-fluid">
    <div class="row">

        <!-- Zero Configuration  Starts-->
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header pb-0 card-no-border">

                    @if(!$trash)

                        <div class="d-flex justify-content-between">
                            <h3>{{trans('admin/permission.permissionTable') }}</h3>
                            <div>

                                @can('permission_create')

                                <a class="btn btn-primary" href="{{'/admin'.'/'.$url.'s/create'}}">{{trans('admin/permission.addPermission') }}</a>

                                @endcan

                                {{-- <a class="btn btn-danger" href="{{'/admin'.'/'.$url.'s?trash=1'}}">Trash</a> --}}

                                @can('permission_create')

                                <button class="btn btn-danger"  id="massActionButton" type="submit" data-bs-original-title="" title="">{{trans('global.deleteAll') }}</button>

                                @endcan

                            </div>
                        </div>
                        
                    @else

                        <div class="d-flex justify-content-between">
                            <h3>{{trans('admin/permission.trashTable') }}</h3>
                            <a class="btn btn-primary" href="/admin/user">{{trans('global.back') }}</a>
                        </div>

                    @endif
                    
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="display" id="basic-1">
                            <thead>
                                <tr>
                                    @if (Gate::check('permission_edit') || Gate::check('permission_delete'))

                                        <th>
                                            <div class="form-check checkbox checkbox-dark mb-2">
                                                <input id='selectall' class="form-check-input select-all-checkbox" data-category="all" type="checkbox">
                                                <label for="selectall" class="form-check-label"></label>
                                            </div>
                                        </th>

                                    @endif

                                    <th>{{trans('global.id') }}</th>
                                    <th class="col-8">{{trans('admin/permission.permission') }}</th>

                                    @if (Gate::check('permission_edit') || Gate::check('permission_delete'))

                                        <th>{{trans('global.action') }}</th>

                                    @endif

                                </tr>
                            </thead>
                            <tbody>
                                @if(!is_null($permissions))
                                    @foreach ($permissions as $permission )
                                        <tr>
                                            @if (Gate::check('permission_edit') || Gate::check('permission_delete'))

                                                <td>
                                                    <div class="form-check checkbox checkbox-dark mb-0">
                                                        <input class="form-check-input" name="massAction" id={{"inline-".$permission->id}} value="{{ $permission->id }}" type="checkbox" data-bs-original-title="" title>
                                                        <label class="form-check-label" for={{"inline-".$permission->id}}></label>
                                                    </div>
                                                </td>
                                                
                                            @endif

                                            <td>{{$permission->id}}</td>

                                            <td>
                                                <h6>{{$permission->title}}</h6>
                                            </td>
                                            
                                            @if (Gate::check('permission_edit') || Gate::check('permission_delete'))

                                                <td>
                                                    <ul class="action">

                                                    @can('permission_edit')

                                                        <li class="edit"> <a href="{{route('admin.'.$url.'.edit',['permission'=>$permission->id])}}"><i class="icon-pencil-alt"></i></a>
                                                        </li>

                                                    @endcan
                                                    
                                                    @can('permission_delete')

                                                    <form action="{{route('admin.'.$url.'.destroy',['permission'=>$permission->id])}}" method="post">
                                                        @csrf
                                                        @method('DELETE')
                                                        <li class="delete"><button class="border-none" type="submit"><i class="icon-trash"></i></button></li>

                                                    </form>

                                                    

                                                        {{-- <li class="delete"><a  href="{{route($url.'.destroy',['id'=>$permission->id])}}"><i class="icon-trash"></i></a></li> --}}

                                                    @endcan

                                                    </ul>
                                                </td>
                                            
                                            @endif

                                        </tr>
                                    @endforeach
                                 @endif
                            </tbody>
                        </table>
                    </div>
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
        // Disable the button initially if massAction array is empty
        updatemassActionButtonState();

        // Add an event listener to update the button state when the checkbox state changes
        $('input[name="massAction"]').change(function () {
            updatemassActionButtonState();
        });

         //selecting all check boxes
         $('#selectall').change(function () {
                $('.form-check-input[name="massAction"]').prop('checked', this.checked);
                updatemassActionButtonState();
             });
         
             // Function to handle individual checkboxes
             $('.form-check-input[name="massAction"]').change(function () {
                 if (!this.checked) {
                     $('#selectall').prop('checked', false);
                 }
             });
    });

    function updatemassActionButtonState() {
        var ismassActionEmpty = $('input[name="massAction"]:checked').length === 0;
        $('#massActionButton').prop('disabled', ismassActionEmpty);
    }


    $(function() {

             $('#massActionButton').click(function(e) {
                 e.preventDefault();
                 
                 
                 
                //  var actionType = $('#actionType').val();
                //  console.log(actionType);
                 var selectedPermissionIds = [];
                 


                    var isConfirm = confirm('Are you sure');
                    if(!isConfirm) return


                 // Collect selected user IDs
                 $('input:checkbox[name="massAction"]:checked').each(function() {
                    selectedPermissionIds.push($(this).val());
                 });
             
                 // Check if any users are selected
                 if (selectedPermissionIds.length > 0) {
                     // Set the action type in the hidden input
                    //  setActionType(actionType);

                     // Prepare data for AJAX request
                     var requestData = {
                         massAction: selectedPermissionIds,
                         _token: '{{csrf_token()}}'

                     };
                 
                     // Make AJAX request
                     $.ajax({
                         type: 'POST',
                         url: "{{route('admin.permission.massAction')}}", // Update the URL to your controller method
                         data: requestData,
                         success: function(response) {
                             // Handle success response
                             location.reload();
                             console.log(response);
                             // Optionally, you can reload the page or update the UI as needed.
                         },
                         error: function(error) {
                             // Handle error response
                             console.error(error);
                            // alert(error)
                         }
                     });
                 } else {
                     alert('Please select at least one user to perform the action.');
                 }
             });  

        });
</script>
    <script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatables/datatable.custom.js') }}"></script>
@endsection