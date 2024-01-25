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
    <h3>{{trans('admin/role.roles') }}</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">{{ $page_title }}</li>
    <li class="breadcrumb-item active">{{trans('admin/role.roles') }}</li>
@endsection

@section('content')

<div class="container-fluid">
    <div class="row">

        <!-- Zero Configuration  Starts-->
        <div class="col-sm-12">
            <div class="card">
                <input type="hidden" name="action_type" id="actionType">

                <div class="card-header pb-0 card-no-border">

                    @if(!$trash)
                    <div class="d-flex justify-content-between">
                        <h3>{{trans('admin/role.roleTable') }}</h3>
                        <div>
                            @can('role_create')
                                
                             <a class="btn btn-primary" href="{{'/admin'.'/'.$url.'s/create'}}">{{trans('admin/role.addRole') }}</a>
                            
                            @endcan

                            @can('role_delete')

                              <a class="btn btn-danger" href="{{'/admin'.'/'.$url.'s?trash=1'}}">{{trans('global.trash') }}</a>
                              <button class="btn btn-danger massActionButton"  onclick="setActionType('destroyAll')"  type="submit" data-bs-original-title="" title="">{{trans('global.deleteAll') }}</button>
                              
                            @endcan
                        </div>
                    </div>
                    @else
                    <div class="d-flex justify-content-between">
                        <h3>{{trans('global.trashTable') }}</h3>
                        <div>
                            <a class="btn btn-primary" href={{"/admin"."/".$url.'s'}}>{{trans('global.back') }}</a>
                            <button class="btn btn-danger massActionButton"  type="submit"  onclick="setActionType('forceDestroyAll')" data-bs-original-title="" title="">{{trans('global.deleteAll') }}</button>
                            <button class="btn btn-success massActionButton"   onclick="setActionType('restoreAll')"  type="submit" data-bs-original-title="" title="">{{trans('global.restoreAll') }}</button>
                        </div>
                    </div>
                    @endif
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="display" id="basic-1">
                            <thead>
                                <tr>
                                    @if (Gate::check('role_edit') || Gate::check('role_delete'))


                                    <th>
                                        <div class="form-check checkbox checkbox-dark mb-2">
                                            <input id='selectall' class="form-check-input select-all-checkbox" data-category="all" type="checkbox">
                                            <label for="selectall" class="form-check-label"></label>
                                        </div>
                                    </th>

                                    @endif

                                    <th>{{trans('global.id') }}</th>
                                    <th class="col-8">{{trans('admin/role.role') }}</th>

                                    @if (Gate::check('role_edit') || Gate::check('role_delete'))


                                    <th>{{trans('global.action') }}</th>

                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @if(!is_null($roles))
                                    @foreach ($roles as $role )
                                        <tr>

                                            @if (Gate::check('role_edit') || Gate::check('role_delete'))

                                            <td>
                                                <div class="form-check checkbox checkbox-dark mb-0">
                                                    <input class="form-check-input" name="massAction" id={{"inline-".$role->id}} value="{{ $role->id }}" type="checkbox" data-bs-original-title="" title>
                                                    <label class="form-check-label" for={{"inline-".$role->id}}></label>
                                                </div>
                                            </td>

                                            @endif

                                            <td>{{$role->id}}</td>
                                            <td>
                                                <h6>{{$role->title}}</h6>
                                            </td>

                                            @if (Gate::check('role_edit') || Gate::check('role_delete'))
                                            <td>
                                                <ul class="action">
                                                    @if ($role->deleted_at)
                                                        <li class="edit"> 
                                                            <a href="{{route('admin.'.$url.'.restore',['role'=>$role->id])}}">
                                                            <i class="fa fa-undo"></i>
                                                        </a>
                                                        </li>

                                                        <form action="{{route('admin.'.$url.'.forceDelete',['role'=>$role->id])}}" method="post">
                                                            @csrf
                                                            @method('DELETE')
                                                            <li class="delete"><button class="border-none" type="submit"><i class="icon-trash"></i></button></li>
                                                        </form>
                                                    @else
                                                        @can('role_edit')
                                                            
                                                        <li class="edit">
                                                            <a href="{{route('admin.'.$url.'.edit',['role'=>$role->id])}}">
                                                                <i class="icon-pencil-alt"></i>
                                                            </a>
                                                        </li>
                                                        
                                                        @endcan

                                                        @can('role_delete')
                                                        
                                                        <form action="{{route('admin.'.$url.'.destroy',['role'=>$role->id])}}" method="post">
                                                            @csrf
                                                            @method('DELETE')
                                                            <li class="delete"><button class="border-none" type="submit"><i class="icon-trash"></i></button></li>
                                                        </form>

                                                        @endcan
                                                    @endif
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
            // Disable the button initially if massDestroy array is empty
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
            var isMassDestroyEmpty = $('input[name="massAction"]:checked').length === 0;
            $('.massActionButton').prop('disabled', isMassDestroyEmpty);
        }

        function setActionType(actionType) {
        // Set the value of the hidden input field
            $('#actionType').val(actionType);
        }

          //submitting selected id to massAction
        $(function() {

             $('.massActionButton').click(function(e) {
                 e.preventDefault();
                 
                 
                 
                 var actionType = $('#actionType').val();
                 console.log(actionType);
                 var selectedRolesIds = [];
                 

                 if(actionType !== 'restoreAll'){

                    var isConfirm = confirm('Are you sure');
                    if(!isConfirm) return

                }

                 // Collect selected user IDs
                 $('input:checkbox[name="massAction"]:checked').each(function() {
                    selectedRolesIds.push($(this).val());
                 });
             
                 // Check if any users are selected
                 if (selectedRolesIds.length > 0) {
                     // Set the action type in the hidden input
                     setActionType(actionType);

                     // Prepare data for AJAX request
                     var requestData = {
                         action_type: actionType,
                         massAction: selectedRolesIds,
                         _token: '{{csrf_token()}}'

                     };
                 
                     // Make AJAX request
                     $.ajax({
                         type: 'POST',
                         url: "{{route('admin.role.massAction')}}", // Update the URL to your controller method
                         data: requestData,
                         success: function(response) {
                             // Handle success response
                             location.reload();
                             console.log(response);
                             // Optionally, you can reload the page or update the UI as needed.
                         },
                         error: function(error) {
                             // Handle error response
                            //  console.error(error);
                            alert(error)
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