@extends('layouts.admin')

@section('title', 'Default')

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/select2.css')}}">
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
    <h3>{{trans('admin/leaveSettings/leaveEntitlement.leaveTypes') }}</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item trans_leave_entitlements">{{ $page_title }}</li>
    <li class="breadcrumb-item active">{{trans('admin/leaveSettings/leaveEntitlement.leaveTypes') }}</li>
@endsection

@section('content')

@if (session('status'))
    <div class="alert alert-warning " role="alert">
        {{ session('status') }}
    </div>
@endif

@if(!is_null($leaveEntitlement))
@foreach ($leaveEntitlement as $list)
<div class="modal fade bd-{{$list->id}}-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
       <div class="modal-content">
          <div class="modal-header">
             <h4 class="modal-title" id="myLargeModalLabel">{{$list->policy->title}}</h4>
             <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          

          <form action="{{route('admin.'.$url.'.leaveEntitlement.update', ['leaveEntitlement' => $list->id])}}" method="POST" class="modal-content">
            @csrf
            @method('PUT')
        
        <div class="modal-body">
                <div class="">

                    <div class="row">

                        <div class="d-flex flex-column  col-md-6 mb-3">
                            <label class="form-label" for="days-{{$list->id}}">Days</label>
                            <input class="form-control" id="days-{{$list->id}}" value="{{$list->max_days > 0 ? $list->max_days :  $list->days}}"  name="days" type="number"  data-bs-original-title="" title="">
                            <div class="text-danger mt-1">
                                @error("days")
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>
                    </div>
                    <p class="text-danger">*Leave year will be counted from User's joining date.</p>
                </div>
        </div>

          <div class="modal-footer">
            <button class="btn btn-danger" type="button" data-bs-dismiss="modal">Close</button>
            <button class="btn btn-primary" type="submit">Add</button>
         </div>
          </form>

         
       </div>
    </div>
 </div>
 @endforeach
 @endif
 
<div class="container-fluid">
    
    <div class="row">

        <!-- Zero Configuration  Starts-->
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header pb-0 card-no-border">

                    @if(!$trash)
                    <div class="d-flex justify-content-end">
                        <div>

                            {{-- @can('permission_create') --}}

                            {{-- modal start --}}
                            <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target=".bd-example-modal-lg">Add Entitlment</button>

                            <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                   <div class="modal-content">
                                      <div class="modal-header">
                                         <h4 class="modal-title" id="myLargeModalLabel">Add Entitlment</h4>
                                         <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                                      </div>
                                      

                                      <form action="{{route('admin.'.$url.".leaveEntitlement.store")}}" method="POST" class="modal-content">
                                        @csrf

                                       <div class="modal-body">
                                            <div class="">

                                                <div class="row">

                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label" for="leave_policy">Leave policy</label>
                                                        <select name="leave_policy_id"  class="form-select" id="leave_policy" >
                        
                                                            <option selected="true" disabled value="">Choose...</option>
                                                            @foreach ($leavePolicies as $policies)
                                                             <option data-days="{{ $policies->max_days > 0 ? $policies->max_days : $policies->days }}" data-unlimited="{{$policies->is_unlimited}}" data-monthly={{$policies->monthly}} value="{{ $policies->id }}">
                                                                 {{ $policies->title }}
                                                             </option>
                                                            @endforeach
                                                
                                                        </select>
                                                        <div class="text-danger mt-1">
                                                            @error("leave_policy_id")
                                                            {{$message}}    
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="d-flex flex-column  col-md-6 mb-3">
                                                        <label class="form-label" for="days" id="daysLabel">Days</label>
                                                         <input class="form-control" id="days"  name="days" type="number"  data-bs-original-title="" title="">
                                                         <div class="text-danger mt-1">
                                                             @error("days")
                                                                 {{ $message }}
                                                             @enderror
                                                         </div>
                                                     </div>

                                                </div>
                                                <p class="text-danger">*Leave year will be counted from User's joining date.</p>
                                                <div class="row">
                                                    <div class="o-hidden">
                                                        <div class="mb-2">
                                                            <div class="form-label">Select Users</div>
                                                            <select name="user_id[]" class="js-example-placeholder-multiple col-sm-12" multiple="multiple">
                                                                @foreach ($users as $user)
                                                                <option value="{{ $user->id }}">
                                                                    {{ $user->first_name}} {{ $user->last_name}}
                                                                </option>
                                                             @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                   
                                             </div>
                                      </div>
                                      <div class="modal-footer">
                                        <button class="btn btn-danger" type="button" data-bs-dismiss="modal">Close</button>
                                        <button class="btn btn-primary" type="submit">Add</button>
                                     </div>
                                      </form>

                                     
                                   </div>
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
                                    <th>Type</th>
                                    <th>Leave year</th>
                                    <th>days</th>
                                    <th>Leave taken</th>
                                    <th>Users</th>
                                    {{-- @can('permission_edit' || 'permission_delete') --}}

                                    <th>{{trans('global.action') }}</th>
                                    {{-- @endcan --}}

                                </tr>
                            </thead>
                            <tbody>
                                @if(!is_null($leaveEntitlement))
                                    @foreach ($leaveEntitlement as $list)
                                        <tr>
                                            <td>
                                                <div class="form-check checkbox checkbox-dark mb-0">
                                                    <input class="form-check-input" name="massAction" id={{"inline-".$list->id}} value="{{ $list->id }}" type="checkbox" data-bs-original-title="" title>
                                                    <label class="form-check-label" for={{"inline-".$list->id}}></label>
                                                </div>
                                            </td>
                                            <td>{{$list->id}}</td>
                                            <td>
                                                <h6>{{$list->policy->title}}</h6>
                                            </td>
                                            <td>{{date('d M Y',strtotime($list->start_year))}} - {{date('d M Y',strtotime($list->end_year))}}</td>
                                            <td>{{$list->max_days > 0 ? $list->policy->max_days : $list->days }}</td>
                                            <td>{{$list->leave_taken }}</td>
                                            <td>{{$list->user->first_name}} {{$list->user->last_name}}</td>
                                            <td>
                                                <ul class="action">
                                                    <li class="edit">
                                                        <button class="border-none" type="button" data-bs-toggle="modal" data-bs-target=".bd-{{$list->id}}-modal-lg">

                                                            <i class="icon-pencil-alt"></i>

                                                        </button>
                                                    </li>

                                                    <form action="{{ route('admin.'.$url.'.leaveEntitlement.destroy', ['leaveEntitlement' => $list->id]) }}" method="post">
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
                         url: "{{route('admin.leaveSettings.leaveEntitlement.massAction')}}", // Update the URL to your controller method
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

        $('#leave_policy').change(function () {
            var selectedLeaveType = $(this).find(':selected');
            updateFormFields(selectedLeaveType);
        });

        function updateFormFields(selectedLeaveType) {

            var days = selectedLeaveType.data('days');
            var monthly = selectedLeaveType.data('monthly');
            var unlimited = selectedLeaveType.data('unlimited');

           
            $('#days').val(days);

            $('#daysLabel').text("Days per year");

            if (monthly) {
                $('#daysLabel').text("Days per month");
            } 
            if(unlimited){
                $('#daysLabel').text("Days (no limit)");
            }
        }
</script>
    <script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatables/datatable.custom.js') }}"></script>
    <script src="{{asset('assets/js/select2/select2.full.min.js')}}"></script>
    <script src="{{asset('assets/js/select2/select2-custom.js')}}"></script>
@endsection