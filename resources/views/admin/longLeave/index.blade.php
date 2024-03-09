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
    <li class="breadcrumb-item">Leave Management</li>
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

                    <div >
                        @if($trash)
                        <div class="row">
                            <h3>{{ trans('global.trashTable') }}</h3>
                            <div>
                                <a class="btn btn-primary" href="/admin/users">{{ trans('global.back') }}</a>
                                <button class="btn btn-danger massActionButton"   type="submit"  onclick="setActionType('forceDestroyAll')" data-bs-original-title="" title="">{{ trans('global.deleteAll') }}</button>
                                <button class="btn btn-success massActionButton"  onclick="setActionType('restoreAll')"  type="submit" data-bs-original-title="" title="">{{ trans('global.restoreAll') }}</button>
                            </div>
                        </div>
                        @else
                        <div class="d-flex justify-content-end">

                            {{-- @can('role_delete') --}}
                            @can("long_leave_create")
                                
                                  <button class="btn btn-primary mx-1" type="button" data-bs-toggle="modal" data-bs-target=".bd-example-modal-lg">Apply Leave</button>
                           
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
                                                           <label class="col-form-label">Leave Title</label>
                                                           <select name="policy_id" class="form-select" id="policy_id" required="">
                                                               <option selected="true" disabled value="">Choose...</option>
                                                               @foreach ($leaveEntitlement as $leaveType)
                                                                       @php
                                                                           // remaining = total - num of current month * (total/12)

                                                                           // $expired = ($value->days/12) * $last_month - $leave_taken;
                                                                           // $remaining = ($value->days - $value->leave_taken) - $expired
                                                                           if($leaveType->policy->monthly){
                                                                               $leave_taken = 0;
                                                                            
                                                                               foreach ($longLeave as $leave) {
                                                                                   if ($leave->approved == 1 && $leaveType->policy->id == $leave->entitlement->policy->id) {
                                                                                       $fromDate = Carbon\Carbon::parse($leave->from);
                                                                                       $month = $fromDate->month ;
                                                                                       $toDate = Carbon\Carbon::parse($leave->to);
                                                                                       if($month <= $lastMonth){
                                                                                        $leave_taken += $fromDate->diffInDays($toDate);
                                                                                    }
                                                                                }
                                                                                }

                                                                               $totalDays = $leaveType->days;
                                                                               $expired = ($totalDays/12) * $lastMonth - $leave_taken ;
                                                                               $remainingDays = ($totalDays - $leaveType->leave_taken) - $expired  ;
                                                                               // $remainingDays =  $leave_taken ;
                                                                           } else {
                                                                               $totalDays = $leaveType->days;
                                                                               $remainingDays = $totalDays - $leaveType->leave_taken;  
                                                                           }
                                                                       
                                                                       
                                                                       @endphp 
                                                                   <option value="{{ $leaveType->policy->id }}" data-monthly="{{ $leaveType->policy->monthly }}" data-advance-salary="{{ $leaveType->policy->advance_salary }}" 
                                                                   data-number-of-days="{{$remainingDays}}">
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
                                                                   <input class="form-control digits" type="date" min="{{date('Y-m-d')}}" id="startDate" name="startDate" required>
                                                               </div>
                                                           </div>
                                                           <div class="col-md-4">
                                                               <label class="col-form-label">End Date</label>
                                                               <div class="col-sm-12">
                                                                   <input class="form-control digits" type="date" min="{{date('Y-m-d')}}" id="endDate"  name="endDate" required>
                                                               </div>
                                                           </div>
                                                           <div class="col-md-4 d-flex justify-content-center align-items-end my-4 ">
                                                               <div class="mx-2 days-field">
                                                                   Remaining days: 0
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
                                                                       <textarea class="form-control" name="comment" id="exampleFormControlTextarea4" rows="3" required></textarea>
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
                            @endcan

                            @can("long_leave_delete")
                                 <button class="btn btn-danger massActionButton" id="destroyAll" type="submit" onclick="setActionType('destroyAll')"  data-bs-original-title="" title="">{{ trans('global.deleteAll')}}</button>
                            @endcan


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

                                    @foreach ($entitlmentArray as $entitlement)
                                        <tr>
                                            <td class="small">{{ $entitlement['leaveYear'] }}</td>
                                            <td class="small">{{ $entitlement['leaveType'] }}</td>
                                            <td class="small">{{ $entitlement['totaDays'] }}</td>
                                            <td class="small">{{ $entitlement['leaveTaken'] }}</td>
                                            <td class="small">{{ $entitlement['remainingLeave'] }}</td>
                                            <td class="small">{{ $entitlement['expiredLeave'] }}</td>
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
                                 
                                    @if (Gate::check('long_leave_update') || Gate::check('long_leave_delete'))

                                        <th>
                                            <div class="form-check checkbox checkbox-dark mb-2">
                                                  <input id='selectall' class="form-check-input select-all-checkbox" data-category="all" type="checkbox">
                                                  <label for="selectall" class="form-check-label"></label>
                                            </div>
                                        </th>

                                    @endif

                                 
                                    <th>{{ trans('global.id') }}</th>
                                    <th>{{ trans('admin/user.name') }}</th>
                                    <th>Leave type</th>
                                    <th>From</th>
                                    <th>To</th>
                                    <th>Reason</th>
                                    <th>File</th>
                                    <th>status</th>
                                    <th>Approved By</th>

                                    @if (Gate::check('long_leave_update') || Gate::check('long_leave_delete'))
                                         <th>{{ trans('global.action') }}</th>
                                    @endif
                                 
                                </tr>
                            </thead>
                            <tbody>
                                @if(!empty($longLeave))
                                    @foreach ($longLeave as $list )
                                        <tr class="list_id{{$list->id}}">

                                           
                                           @if(Gate::check('long_leave_update') || Gate::check('long_leave_delete'))
                                                <td>
                                                    @if($list->approved===0)
                                                         <div class="form-check checkbox checkbox-dark mb-0">
                                                             <input class="form-check-input" name="massAction" id={{"inline-".$list->id}} value="{{ $list->id }}" type="checkbox" data-bs-original-title="" title>
                                                             <label class="form-check-label" for={{"inline-".$list->id}}></label>
                                                         </div>
                                                    @endif
                                                </td>
                                            @endif

                                            {{-- @endcan --}}

                                            <td>{{$list->id}}</td>
                                            <td>{{ucwords($list->user->first_name)}} {{ucwords($list->user->last_name)}}</td>
                                            <td>{{$list->entitlement->policy->title}}</td>
                                            <td>{{ date('d/m/Y', strtotime($list->from)) }}</td>
                                            <td>{{ date('d/m/Y', strtotime($list->to)) }}</td>
                                            <td>{{$list->reason}}</td>
                                            <td class="action"> 
                                                <a class="pdf" href="{{ asset('storage/leave_files/'.$list->leave_file) }}" target="_blank">
                                                <i class="icofont icofont-file-pdf"></i></a>
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
                                                {{ucwords(optional($list->approvedBy)->first_name) . ' ' . ucwords(optional($list->approvedBy)->last_name) ?? 'Not Approved' }}
                                            </td>
                                            

                                            @if(Gate::check('long_leave_update') || Gate::check('long_leave_delete'))
                                                <td>
                                                    @if($list->approved === 0)
                                                     <ul class="action">

                                                        @can("long_leave_update")
                                                            
                                                                {{-- <li class="edit">
                                                                    <button class="border-none" type="button" data-bs-toggle="modal" data-bs-target="#editModal{{ $list->id }}">
                                                                        <i class="icon-pencil-alt"></i>
                                                                    </button>
                                                                </li>
                                                                
                                                                <div class="modal fade" id="editModal{{ $list->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenter" aria-hidden="true">
                                                                    <div class="modal-dialog modal-lg" role="document">
                                                                        <form enctype="multipart/form-data" action="{{ route('admin.'.$url.'.update', ['longLeave' => $list->id]) }}" method="POST" class="modal-content">
                                                                            @csrf
                                                                            @method('PUT')
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title">Update Long Leave</h5>
                                                                                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <div class="">

                                                                                    <div class="">
                                                                                        <label class="col-form-label">Leave Title</label>
                                                                                        
                                                                                            @foreach ($leaveEntitlement as $leaveType)
                                                                                                 @if ($list->entitlement->id === $leaveType->id)
                                                                                                    <div>
                                                                                                        {{ $leaveType->policy->title }}
                                                                                                    </div> 
                                                                                                 @endif    
                                                                                            @endforeach
                                                                                                                                        
                                                                                    </div>
                                                                                
                             
                                                                                    <div class="row" id="longLeaveFields">
                                                                                        <div class="col-md-4">
                                                                                            <label class="col-form-label">Start Date</label>
                                                                                            <div class="col-sm-12">
                                                                                                <input class="form-control digits" value="{{$list->from}}" type="date" min="{{date('Y-m-d')}}"  name="startDate" required>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-md-4">
                                                                                            <label class="col-form-label">End Date</label>
                                                                                            <div class="col-sm-12">
                                                                                                <input class="form-control digits" value="{{$list->to}}" type="date" min="{{date('Y-m-d')}}"   name="endDate" required>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                             
                                                                                
                                                                                
                                                                                    <div class="row">
                                                                                        <div class="col">
                                                                                        <div class="my-3 row">
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
                                                                                            <textarea class="form-control" name="comment" id="exampleFormControlTextarea4" rows="3" required>{{$list->reason}}</textarea>
                                                                                        </div>
                                                                                        </div>
                                                                                    </div>
                                                                                 </div>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
                                                                                <button class="btn btn-primary" type="submit">Save</button>
                                                                            </div>
                                                                        </div>
                                                                        </form>
                                                                    </div>
                                                                </div> --}}

                                                        @endcan

                                                        @can("long_leave_delete")
                                                            <form action="{{route('admin.'.$url.'.destroy',['long_leave'=>$list->id])}}" method="post">
                                                                @csrf
                                                                @method('DELETE')
                                                                <li class="delete"><button class="border-none" type="submit"><i class="icon-trash"></i></button></li>

                                                            </form>
                                                        @endcan

                                                      </ul>
                                                    @endif
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


        $('#policy_id',).change(function () {
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


            $('.days-field').text('Remaining days: ' + numberOfDays);


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

                $('.days-field').html((numberOfDays - daysDifference>0?'Remaining days: ' +( numberOfDays - daysDifference):"<span class='text-danger'>Remaining days: "+0+"</span>"));


            });
        }
     


    </script>
    <script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatables/datatable.custom.js') }}"></script>
@endsection