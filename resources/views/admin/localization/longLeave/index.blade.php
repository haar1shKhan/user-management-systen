@extends('layouts.admin')

@section('title', 'Default')

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">

@endsection

@section('style')
<style>
     button.border-none {
        border: none;
        background: none;
        padding: 0;
        cursor: pointer;
        /* Additional styles as needed */
    }
    </style>
@endsection

@section('breadcrumb-title')
    <h3>{{trans('admin/localization/longLeave.leaveTypes') }}</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">{{ $page_title }}</li>
    <li class="breadcrumb-item active">{{trans('admin/localization/longLeave.leaveTypes') }}</li>
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
                        <h3>{{trans('admin/localization/longLeave.leaveTypeTable') }}</h3>
                        <div>

                            {{-- @can('permission_create') --}}

                            {{-- modal start --}}
                            <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#exampleModalCenter">{{trans('admin/localization/longLeave.addType') }}</button>
                            <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenter" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                   <form action="{{route('admin.'.$url.".longLeave.store")}}" method="POST" class="modal-content">
                                    @csrf
                                      <div class="modal-header">
                                         <h5 class="modal-title">Add Title</h5>
                                         <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                                      </div>
                                      <div class="modal-body">
                                        <div class="d-flex flex-column mx-3">
                                            <input class="form-control " id="validationCustom01" name="title" type="text" required="" data-bs-original-title="" title="">
                                            {{-- <div class="valid-feedback">Looks good!</div> --}}
                                            <div class="text-danger mt-1">
                                                @error("type")
                                                {{$message}}    
                                                @enderror
                                            </div>
                                        </div>
                                      </div>
                                      <div class="modal-footer">
                                         <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
                                         <button class="btn btn-primary" type="submit">Add</button>
                                      </div>
                                   </form>
                                </div>
                             </div>
                            {{-- modal end --}}

                            {{-- @endcan --}}

                            {{-- <a class="btn btn-danger" href="{{'/admin'.'/'.$url.'s?trash=1'}}">Trash</a> --}}
                            {{-- @can('permission_create') --}}

                            <button class="btn btn-danger"  id="massActionButton" type="submit" data-bs-original-title="" title="">{{trans('global.deleteAll') }}</button>

                            {{-- @endcan --}}

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
                                    {{-- @can('user_edit' || 'user_delete') --}}

                                    <th>
                                        <div class="form-check checkbox checkbox-dark mb-2">
                                            <input id='selectall' class="form-check-input select-all-checkbox" data-category="all" type="checkbox">
                                            <label for="selectall" class="form-check-label"></label>
                                      </div>
                                    </th>

                                    {{-- @endcan --}}

                                    <th>{{trans('global.id') }}</th>
                                    <th class="col-8">{{trans('admin/localization/longLeave.type') }}</th>

                                    {{-- @can('permission_edit' || 'permission_delete') --}}

                                    <th>{{trans('global.action') }}</th>
                                    {{-- @endcan --}}

                                </tr>
                            </thead>
                            <tbody>
                                @if(!is_null($longLeaveType))
                                    @foreach ($longLeaveType as $type)
                                        <tr>
                                            <td>
                                                <div class="form-check checkbox checkbox-dark mb-0">
                                                    <input class="form-check-input" name="massAction" id={{"inline-".$type->id}} value="{{ $type->id }}" type="checkbox" data-bs-original-title="" title>
                                                    <label class="form-check-label" for={{"inline-".$type->id}}></label>
                                                </div>
                                            </td>
                                            <td>{{$type->id}}</td>
                                            <td>
                                                <h6>{{$type->title}}</h6>
                                            </td>
                                            <td>
                                                <ul class="action">
                                                    <li class="edit">
                                                        <button class="border-none" type="button" data-bs-toggle="modal" data-bs-target="#editModal{{ $type->id }}">
                                                            <i class="icon-pencil-alt"></i>
                                                        </button>
                                                    </li>
                                                    <div class="modal fade" id="editModal{{ $type->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenter" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                                            <form action="{{ route('admin.'.$url.'.longLeave.update', ['longLeave' => $type->id]) }}" method="POST" class="modal-content">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Update Title</h5>
                                                                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="d-flex flex-column mx-3">
                                                                        <input class="form-control" id="validationCustom01" value="{{ $type->title }}" name="title" type="text" required="" data-bs-original-title="" title="">
                                                                        <div class="text-danger mt-1">
                                                                            @error("title")
                                                                                {{ $message }}
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
                                                                    <button class="btn btn-primary" type="submit">Save</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>

                                                    <form action="{{ route('admin.'.$url.'.longLeave.destroy', ['longLeave' => $type->id]) }}" method="post">
                                                        @csrf
                                                        @method('DELETE')
                                                        <li class="delete">
                                                            <button class="border-none" type="submit"><i class="icon-trash"></i></button>
                                                        </li>
                                                    </form>
                                                </ul>
                                            </td>
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
                         url: "{{route('admin.localization.longLeave.massAction')}}", // Update the URL to your controller method
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