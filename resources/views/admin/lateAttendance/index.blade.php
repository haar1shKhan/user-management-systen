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
    <h3>{{ $page_title }}</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">{{ $page_title }}</li>
@endsection

@section('content')

<div class="container-fluid">
    <div class="row">

        <!-- Zero Configuration  Starts-->
        <div class="col-sm-12">

            {{-- multi select form  Starts--}}
            <div class="card">
                <input type="hidden" name="action_type" id="actionType">

                <div class="card-header pb-0 card-no-border">

                    <div class="d-flex justify-content-between">
                        @if($trash)
                        <h3>{{ trans('global.trashTable') }}</h3>
                        <div>
                            <a class="btn btn-primary" href="/admin/users">{{ trans('global.back') }}</a>
                            <button class="btn btn-danger massActionButton"   type="submit"  onclick="setActionType('forceDestroyAll')" data-bs-original-title="" title="">{{ trans('global.deleteAll') }}</button>
                            <button class="btn btn-success massActionButton"  onclick="setActionType('restoreAll')"  type="submit" data-bs-original-title="" title="">{{ trans('global.restoreAll') }}</button>
                        </div>
                        @else
                        <h3>{{ trans('admin/longLeave.leaveTable') }}</h3>
                        <div>

                            {{-- @can('role_delete') --}}
                            <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target=".bd-example-modal-lg">Apply Leave</button>
                           
                            <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                   <div class="modal-content">
                                      <div class="modal-header">
                                         <h4 class="modal-title" id="myLargeModalLabel">Large modal</h4>
                                         <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                                      </div>
                                      

                                      <form action="{{route('admin.'.$url.".store")}}" method="POST" class="modal-content">
                                        @csrf

                                       <div class="modal-body">
                                            <div class="">
                                    
                                                <h6>Vactions</h6>
                        
                        
                                                    <div class="row" id="shortLeaveFields">
                                                        <div class="col-md-4">
                                                            <label class="col-form-label">From</label>
                                                            <div class="col-sm-12">
                                                                <input class="form-control digits" type="time" name="from" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="col-form-label">To</label>
                                                            <div class="col-sm-12">
                                                                <input class="form-control digits" type="time" name="to" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    

                        
                                                   <div class="row">
                                                       <div class="col">
                                                       <div>
                                                           <label class="form-label" for="exampleFormControlTextarea4">Reason</label>
                                                           <textarea class="form-control" name="reason" id="exampleFormControlTextarea4" rows="3" required></textarea>
                                                       </div>
                                                       </div>
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
                             </div>

                            <a class="btn btn-danger" href="/admin/users?trash=1">{{ trans('global.trash') }}</a>
                            <button class="btn btn-danger massActionButton" id="destroyAll" type="submit" onclick="setActionType('destroyAll')"  data-bs-original-title="" title="">{{ trans('global.deleteAll')}}</button>

                            {{-- @endcan --}}

                        </div>
                        @endif
                    </div>

                        
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="display" id="basic-1">
                            <thead>
                                <tr>
                                    {{-- @can('user_edit' || 'user_delete') --}}

                                    {{-- <th>
                                        <div class="form-check checkbox checkbox-dark mb-2">
                                              <input id='selectall' class="form-check-input select-all-checkbox" data-category="all" type="checkbox">
                                              <label for="selectall" class="form-check-label"></label>
                                        </div>
                                    </th> --}}

                                    {{-- @endcan --}}
                                    <th>{{ trans('global.id') }}</th>
                                    <th>{{ trans('admin/user.name') }}</th>

                                    <th>Duration</th>
                                    <th>Reason</th>
                                    <th>status</th>
                                    <th>Approved by</th>

                                  
                                    {{-- @can('user_edit' || 'user_delete') --}}
                                    <th>{{ trans('global.action') }}</th>
                                    {{-- @endcan --}}
                                </tr>
                            </thead>
                            <tbody>
                                @if(!empty($lateAttendances))
                                    @foreach ($lateAttendances as $list )
                                        <tr class="LateAttendances_id{{$list->id}}">

                                            {{-- @can('user_edit' || 'user_delete') --}}
{{-- 
                                            <td>
                                                <div class="form-check checkbox checkbox-dark mb-0">
                                                    <input class="form-check-input" name="massAction" id={{"inline-".$list->id}} value="{{ $list->id }}" type="checkbox" data-bs-original-title="" title>
                                                    <label class="form-check-label" for={{"inline-".$list->id}}></label>
                                                </div>
                                            </td> --}}

                                            {{-- @endcan --}}

                                            <td>{{$list->id}}</td>

                                            <td>
                                                <h6>{{$list->user->first_name}} {{$list->user->last_name}}</h6>
                                            </td>

                                            <td><span class="font-weight-bold">From: </span> {{date ('h:i a',strtotime($list->from))}} <span class="font-weight-bold">To: </span> {{$list->to}}</td>

                                            <td>
                                              {{$list->reason}}
                                            </td>
                                            <td>
                                                @if ($list->approved==0)
                                                    <p class="text-warning">Pending</p>
                                                @elseif ($list->approved==1)
                                                    <p class="text-success">Approved</p>
                                                @else
                                                    <p class="text-danger">Rejected</p>  
                                                @endif
                                              
                                            </td>
                                            <td>
                                                  {{ optional($list->approvedBy)->first_name . ' ' . optional($list->approvedBy)->last_name ?? 'Not Approved' }}
                                            </td>

                                            {{-- @can('user_edit' || 'user_delete') --}}

                                            <td>
                                                <ul class="action">
                                                    
                                                    <li class="edit">
                                                        <button class="border-none" type="button" data-bs-toggle="modal" data-bs-target="#editModal{{ $list->id }}">
                                                            <i class="icon-pencil-alt"></i>
                                                        </button>
                                                    </li>
                                                    <div class="modal fade" id="editModal{{ $list->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenter" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                                            <form action="{{ route('admin.'.$url.'.update', ['lateAttendance' => $list->id]) }}" method="POST" class="modal-content">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Update Title</h5>
                                                                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="d-flex flex-column mx-3">
                                                                        <input class="form-control" id="validationCustom01" value="{{ $list->reason }}" name="reason" type="text" required="" data-bs-original-title="" title="">
                                                                        <div class="text-danger mt-1">
                                                                            @error("reason")
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

                                                    <form action="{{route('admin.'.$url.'.destroy',['lateAttendance'=>$list->id])}}" method="post">
                                                        @csrf
                                                        @method('DELETE')
                                                        <li class="delete"><button class="border-none" type="submit"><i class="icon-trash"></i></button></li>

                                                    </form>
                                                    
                                                    <form action="{{ route('admin.'.$url.'.update', ['lateAttendance' => $list->id]) }}" method="post">
                                                        @csrf
                                                        @method('PUT')
                                                    
                                                        <!-- Add a hidden input field for user ID -->
                                                        <input type="hidden" name="user_id" value="{{ $list->user->id }}">
                                                    
                                                        <li class="edit">
                                                            <button class="border-none" type="submit" name="approve"><i class="icon-check"></i></button>
                                                        </li>
                                                    </form>

                                                    <form action="{{ route('admin.'.$url.'.update', ['lateAttendance' => $list->id]) }}" method="post">
                                                        @csrf
                                                        @method('PUT')
                                                    
                                                        <!-- Add a hidden input field for user ID -->
                                                        <input type="hidden" name="user_id" value="{{ $list->user->id }}">
                                                    
                                                        <li class="delete">
                                                            <button class="border-none" type="submit" name="reject"><i class="icon-close"></i></button>
                                                        </li>
                                                    </form>
                                                    
                                                  </ul>
                                            </td>
                                            {{-- @endcan --}}

                                        </tr>
                                    @endforeach
                                 @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            {{-- multi select form Ends--}}
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
        
        //Toggling button between disable or enable
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
                 var selectedUserIds = [];
                 

                 if(actionType !== 'restoreAll'){

                    var isConfirm = confirm('Are you sure');
                    if(!isConfirm) return

                }

                 // Collect selected user IDs
                 $('input:checkbox[name="massAction"]:checked').each(function() {
                     selectedUserIds.push($(this).val());
                 });
             
                 // Check if any users are selected
                 if (selectedUserIds.length > 0) {
                     // Set the action type in the hidden input
                     setActionType(actionType);

                     // Prepare data for AJAX request
                     var requestData = {
                         action_type: actionType,
                         massAction: selectedUserIds,
                         _token: '{{csrf_token()}}'

                     };
                 
                     // Make AJAX request
                     $.ajax({
                         type: 'POST',
                         url: "{{route('admin.user.massAction')}}", // Update the URL to your controller method
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