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
    <h3>{{ $page_title }}</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">{{ $page_title }}</li>
@endsection

@section('content')

@if (session('status'))
    <div class="alert alert-warning " role="alert">
        {{ session('status') }}
    </div>
@endif

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
                                         <h4 class="modal-title" id="myLargeModalLabel">Apply Leave<span class="text-danger">{{$error??""}}</span></h4>
                                         <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                                      </div>
                                      

                                      <form enctype="multipart/form-data" action="{{route('admin.'.$url.".store")}}" method="POST" class="modal-content">
                                        @csrf

                                       <div class="modal-body">
                                            <div class="">
                                                            
                                                <div class="">
                                                    <select name="policy_id" class="form-select" id="validationCustom04" required="">
                                                        <option selected="true" disabled value="">Choose...</option>
                                                        @foreach ($leaveEntitlement as $leaveType)
                                                            @if ($leaveType->policy->monthly)
                                                                @php
                                                                    // remaining = total - num of current month * (total/12)
                                                                    $days = $leaveType->days?$leaveType->days:$leaveType->policy->days;
                                                                    $remainingDays = $days - $leaveType->leave_taken;
            
                                                                    $remainingDaysMonthy = $remainingDays - ($currentMonth * 3);
                                                                @endphp 
                                                        @else
                                                            @php
                                                                $days = $leaveType->days?$leaveType->days:$leaveType->policy->days;
                                                                $remainingDays = $days - $leaveType->leave_taken;  
                                                            @endphp 
                                                        @endif
                                                            <option value="{{ $leaveType->policy->id }}" data-monthly="{{ $leaveType->policy->monthly }}" data-advance-salary="{{ $leaveType->policy->advance_salary }}" 
                                                            data-number-of-days="{{$leaveType->policy->monthly?$remainingDaysMonthy:$remainingDays}}">
                                                                {{ $leaveType->policy->title }}
                                                            </option>
                                                        @endforeach
                                                    </select>                                                    
                                                    <div class="text-danger mt-1">
                                                        @error("policy_id")
                                                        {{$message}}    
                                                        @enderror
                                                    </div>
                                                </div>
                        
                                                    
                                                <div class="row" id="longLeaveFields">
                                                    <div class="col-md-4">
                                                        <label class="col-form-label">Start Date</label>
                                                        <div class="col-sm-12">
                                                            <input class="form-control digits" type="date" min="{{date('Y-m-d')}}" id="startDate" name="startDate">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="col-form-label">End Date</label>
                                                        <div class="col-sm-12">
                                                            <input class="form-control digits" type="date" min="{{date('Y-m-d')}}" id="endDate"  name="endDate">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 d-flex justify-content-center align-items-end my-4 ">
                                                        <div class="mx-2 days-field">
                                                            Number of days: 0
                                                        </div>
                                                    </div>
                                                </div>
                                                    
                        
                                                <div class="row mb-2 my-4">
                                                    
                                                    <div class=" d-flex justify-content-around">
                                                        <div class="form-check form-check-inline radio radio-primary">
                                                        <input disabled class="form-check-input" id="radioinline2" type="radio" name="advance_salary">
                                                        <label class="form-check-label mb-0 small" for="radioinline2">Advance Salary</label>
                                                        </div>
                                                        <div class="form-check form-check-inline radio radio-primary">
                                                        <input disabled class="form-check-input" id="radioinline3" type="radio" name="monthly">
                                                        <label class="form-check-label mb-0 small" for="radioinline3">Monthly</label>
                                                        </div>
                                                    </div>
             
                                                </div>
                        
                        
                                                        <div class="row">
                                                            <div class="col">
                                                            <div class="mb-3 row">
                                                                <div class="col-sm-12">
                                                                <input class="form-control" name="leave_file" type="file">
                                                                </div>
                                                            </div>
                                                            </div>
                                                        </div>
                        
                                                        <div class="row">
                                                            <div class="col">
                                                            <div>
                                                                <label class="form-label" for="exampleFormControlTextarea4">Comments</label>
                                                                <textarea class="form-control" name="comment" id="exampleFormControlTextarea4" rows="3"></textarea>
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

                            <button class="btn btn-danger massActionButton" id="destroyAll" type="submit" onclick="setActionType('destroyAll')"  data-bs-original-title="" title="">{{ trans('global.deleteAll')}}</button>

                            {{-- @endcan --}}

                        </div>
                        @endif
                    </div>

                    <div class="col-md-8">
                        <div class="mt-4">
                            <h5 class="p-1 bg-success">Previous Vacation</h5>

                            <table class="table table-bordered table-striped" style="background-color: #f8f9fa;">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="small">Leave Year</th>
                                        <th class="small">leave Type</th>
                                        <th class="small">Total Days</th>
                                        <th class="small">Leave taken</th>
                                        <th class="small">Remaining Balance</th>
                                        <th class="small">Expired Days</th>
                                    </tr>
                                </thead>
                                <tbody>

                                  @foreach ($leaveEntitlement as $entitlement )
                                        <tr>
                                            <td class="small">{{$entitlement->leave_year}}</td>
                                            <td class="small">{{$entitlement->policy->title}}</td>
                                            <td class="small">{{$entitlement->days?$entitlement->days:$entitlement->policy->days}}</td>
                                            <td class="small">{{$entitlement->leave_taken}}</td>
                                            <td class="small">
                                                @if ($entitlement->policy->monthly)
                                                    @php
                                                        // remaining = total - num of current month * (total/12)
                                                        $days = $entitlement->days?$entitlement->days:$entitlement->policy->days;
                                                        $remainingDays = $days - $entitlement->leave_taken;

                                                        $remainingDaysMonthy = $remainingDays - ($currentMonth * 3);

                                                    @endphp 
                                                    {{$remainingDaysMonthy}}
                                                    {{-- remainingDaysMonthy : {{$remainingDaysMonthy}}
                                                    days : {{$days}}
                                                    remainingDays : {{$remainingDays}} --}}
                                                @else
                                                    @php
                                                         $days = $entitlement->days?$entitlement->days:$entitlement->policy->days;
                                                        $remainingDays = $days - $entitlement->leave_taken;  
                                                    @endphp 
                                                    {{$remainingDays}}
                                                @endif
                                            </td>
                                            <td class="small">
                                                @if ($entitlement->policy->monthly)
                                                @php
                                                    // expired = num of current month * (total/12) - sum of taken days
                                                    $days = $entitlement->days?$entitlement->days:$entitlement->policy->days;
                                                    $remainingDays = $days - $entitlement->leave_taken;

                                                    $expiredDays = $days - $remainingDaysMonthy - $entitlement->leave_taken
                                                  
                                                    
                                                @endphp 
                                                {{$expiredDays}}
                                                {{-- remainingDaysMonthy : {{$remainingDaysMonthy}}
                                                days : {{$days}}
                                                remainingDays : {{$remainingDays}} --}}
                                                @else
                                                    0
                                                @endif
                                            </td>
                                        </tr>
                                  @endforeach

                                </tbody>
                            </table>
                                
                           
                            
                        </div>
                    </div>
                        
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
                                    <th>{{ trans('global.id') }}</th>
                                    <th>{{ trans('admin/user.name') }}</th>
                                    <th>Leave type</th>
                                    <th>Duration</th>
                                    <th>Reason</th>
                                    <th>status</th>
                                    <th>Approved By</th>
                                    {{-- @can('user_edit' || 'user_delete') --}}
                                    <th>{{ trans('global.action') }}</th>
                                    {{-- @endcan --}}
                                </tr>
                            </thead>
                            <tbody>
                                @if(!empty($longLeave))
                                    @foreach ($longLeave as $list )
                                        <tr class="list_id{{$list->id}}">

                                            {{-- @can('user_edit' || 'user_delete') --}}

                                            <td>
                                                <div class="form-check checkbox checkbox-dark mb-0">
                                                    <input class="form-check-input" name="massAction" id={{"inline-".$list->id}} value="{{ $list->id }}" type="checkbox" data-bs-original-title="" title>
                                                    <label class="form-check-label" for={{"inline-".$list->id}}></label>
                                                </div>
                                            </td>

                                            {{-- @endcan --}}

                                            <td>{{$list->id}}</td>
                                            <td>{{$list->user->first_name}} {{$list->user->last_name}}</td>
                                            <td>{{$list->entitlement->policy->title}}</td>
                                            <td><span class="font-weight-bold">From: </span> {{$list->from}} <span class="font-weight-bold">To: </span> {{$list->to}}</td>
                                            <td>{{$list->reason}}</td>
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

                                                    {{-- @can('permission_edit') --}}

                                                      {{-- <li class="edit">
                                                         <a href="{{route('admin.'.$url.'.edit',['longLeave'=>$list->id])}}"><i class="icon-pencil-alt"></i></a>
                                                      </li> --}}
                                                      
                                                    {{-- @endcan --}}
                                                    
                                                    {{-- @can('permission_delete') --}}

                                                    <form action="{{route('admin.'.$url.'.destroy',['longLeave'=>$list->id])}}" method="post">
                                                      @csrf
                                                      @method('DELETE')
                                                      <li class="delete"><button class="border-none" type="submit"><i class="icon-trash"></i></button></li>

                                                    </form>

                                                    {{-- @endcan --}}

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
                         url: "{{route('admin.longLeave.massAction')}}", // Update the URL to your controller method
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


        $('#validationCustom04').change(function () {
            var selectedLeaveType = $(this).find(':selected');
            updateFormFields(selectedLeaveType);
            dateValidation(selectedLeaveType);
        });

        function updateFormFields(selectedLeaveType) {
            // Reset form fields
            $('input[name="advance_salary"]').prop('checked', false);
            $('input[name="monthly"]').prop('checked', false);

            // Add logic to show/hide and update fields based on the selected leave type
            var monthly = selectedLeaveType.data('monthly');
            var advanceSalary = selectedLeaveType.data('advance-salary');
            var numberOfDays = selectedLeaveType.data('number-of-days');


            $('.days-field').text('Number of days: ' + numberOfDays);


            if (monthly) {
                // Update fields for monthly leave
                $('input[name="monthly"]').prop('checked', true);
                
            }
            
            if (advanceSalary) {
                // Update fields for leave with advance salary
                $('input[name="advance_salary"]').prop('checked', true);
            }
            // Add more conditions based on your dynamic leave type properties

            // Show the relevant form fields
        }

        
        function dateValidation(selectedLeaveType){
            let endDate = "";
            let startDate = "";

            // console.log(endDate,startDate);
            $('#startDate, #endDate').change(function () {
            // This function will be triggered when either #startDate or #endDate changes
                startDateInput = $("#startDate").val();
                endDateInput = $("#endDate").val();
                var numberOfDays = selectedLeaveType.data('number-of-days');

                const startDate = new Date(startDateInput);
                const endDate = new Date(endDateInput);

                // Calculate the difference in milliseconds
                const timeDifference = endDate - startDate;

                // Convert milliseconds to days
                const daysDifference = Math.floor(timeDifference / (1000 * 60 * 60 * 24));

                $('.days-field').html((numberOfDays - daysDifference>0?'Number of days: ' +( numberOfDays - daysDifference):"<span class='text-danger'>Number of days: "+0+"</span>"));


            });
        }
     


    </script>
    <script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatables/datatable.custom.js') }}"></script>
@endsection