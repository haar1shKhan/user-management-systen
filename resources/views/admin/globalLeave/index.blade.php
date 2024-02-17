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
    color: black;
    width: 80%;

    /* Additional styles as needed */
}
div .action .eye i{
    color: black;
    margin: auto;
}
div .action .pending i{
    color: rgb(241, 155, 26);
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
                        <h3>{{ trans('admin/longLeave.leaveTable') }}</h3>
                        <div>

                            {{-- @can('role_delete') --}}
                            <button class="btn btn-danger massActionButton" id="destroyAll" type="submit" onclick="setActionType('destroyAll')"  data-bs-original-title="" title="">{{ trans('global.deleteAll')}}</button>

                            {{-- @endcan --}}

                        </div>
                    </div>
                        
                </div>
                <div class="card-body">
                    <ul class="nav nav-tabs border-tab nav-primary" id="top-tab" role="tablist">
                      <li class="nav-item"><a class="nav-link active" id="top-home-tab" data-bs-toggle="tab" href="#top-appearance" role="tab" aria-controls="top-home" aria-selected="true"><i class="icofont icofont-layout"></i>Long Leave</a></li>
                      <li class="nav-item"><a class="nav-link" id="profile-top-tab" data-bs-toggle="tab" href="#top-profile" role="tab" aria-controls="top-profile" aria-selected="false"><i class="icofont icofont-man-in-glasses"></i>Late Attendance</a></li>
                      <li class="nav-item"><a class="nav-link" id="contact-top-tab" data-bs-toggle="tab" href="#top-contact" role="tab" aria-controls="top-contact" aria-selected="false"><i class="icofont icofont-contacts"></i>Short Leave</a></li>
                    </ul>
                    <div class="tab-content" id="top-tabContent">

                      <div class="tab-pane fade show active" id="top-appearance" role="tabpanel" aria-labelledby="top-home-tab">
                        

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
                                    <th>Leave Type</th>
                                    <th>Leave From</th>
                                    <th>Leave To</th>
                                    <th>Reason</th>
                                    <th>status</th>
                                    <th>File</th>
                                    <th>Approved By</th>
                                    {{-- @can('user_edit' || 'user_delete') --}}
                                    <th>{{ trans('global.action') }}</th>
                                    {{-- @endcan --}}
                                </tr>
                            </thead>
                            <tbody>
                                @if(!empty($longLeaves))
                                    @foreach ($longLeaves as $list )
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
                                            <td>{{$list->from}}</td>
                                            <td>{{$list->to}}</td>
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

                                            <td class="action"> 
                                                <a class="pdf" href="{{ asset('storage/leave_files/'.$list->leave_file) }}" target="_blank">
                                                <i class="icofont icofont-file-pdf"></i></a>
                                            </td>
                                            <td>
                                                {{ optional($list->approvedBy)->first_name . ' ' . optional($list->approvedBy)->last_name ?? 'Not Approved' }}
                                            </td>
                                            
                                            <div class="modal fade" id="file{{$list->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                                                <div class="modal-dialog modal-lg" role="document">
                                                   <div class="modal-content">
                                                    
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Leave Details</h5>
                                                        <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                                                     </div>
                                                     <div class="modal-body">

                                                        <div class="mb-3">
                                                            @if (empty($list->user->profile->image))

                                                               <img height="100px" width="100px" class="img-thumbnail rounded-circle" style="max-width: 150px; max-height: 150px;" src="{{ asset('storage/profile_images/placeholder.png') }}" alt="">                

                                                            @else
                                                            
                                                               <img  height="100px" width="100px" src="{{ asset('storage/profile_images/'.$list->user->profile->image) }}" alt="Profile Picture" class="rounded-circle media profile-media">
                                                                     
                                                            @endif
                                                        </div>

                                                        <div class="row">
                                                            <div class="d-flex justify-content-between mt-1">

                                                                <span>Name: {{$list->user->first_name}} {{$list->user->last_name}}</span>
                                                                <div class="row">
                                                                    <p>
                                                                        Status:
                                                                        @if ($list->approved==0)
                                                                            <span class="text-warning">Pending</span>
                                                                        @elseif ($list->approved==1)
                                                                            <span class="text-success">Approved</span>
                                                                        @else
                                                                            <span class="text-danger">Rejected</span>  
                                                                        @endif
                                                                    </p>
                                                                </div>

                                                            </div>
                                                            <div class="my-1">
                                                                Approved By : {{ optional($list->approvedBy)->first_name . ' ' . optional($list->approvedBy)->last_name ?? 'Not Approved' }}
                                                            </div>
                                                            <div class="my-1">
                                                                Leave Type: {{$list->entitlement->policy->title}} 
                                                            </div>
                                                        </div>

                                                        <div class="row my-3">

                                                            <div class="d-flex">
                                                                <p>From : {{$list->from}} To : {{$list->to}}</p>
                                                            </div>

                                                            <div class="my-4">
                                                                Reason: 
                                                                <p>
                                                                    {{$list->reason}}
                                                                </p>
                                                            </div>

                                                            <div class="action ">

                                                                <a  target="_blank" class="bg-light text-dark px-3 py-2" href="{{ asset('storage/leave_files/'.$list->leave_file) }}">
                                                                    View File 
                                                                    <i class="icofont icofont-file-pdf text-danger"></i>
                                                                </a>    

                                                            </div>
                                                            
                                                        </div>




                                                     </div>
                                                    

                                                    
                                                   </div>
                                                </div>
                                             </div>
                                            

                                            <td>
                                                 {{-- <div class="dropdown-basic">
                                                    <div class="btn-group">
                                                        <div class="dropdown separated-btn">
                                                            <button class="border-none" type="button"><i
                                                                class="icon-more-alt"></i>
                                                            </button>
                                                            <div class="dropdown-content digits">
                                                                <a href="#">Link 1</a>
                                                                <a href="#">Link 2</a>
                                                                <a href="#">Link 3</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div> --}}
                                                 
                                                <div class="dropdown icon-dropdown">
                                                    <button class="btn dropdown-toggle" id="orderButton" type="button"
                                                        data-bs-toggle="dropdown" aria-expanded="false"><i
                                                            class="icon-more-alt"></i></button>
                                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="orderButton">
                                                            <ul class="action d-flex flex-column justify-content-around">

                                                                <li data-bs-toggle="modal" data-bs-target="#file{{$list->id}}" class="dropdown edit eye">
                                                                    <button type="submit" class="border-none d-flex justify-content-between align-items-center my-2 mx-3">
                                                                        <span>Show</span>
                                                                        <span><i class="icon-eye"></i></span>
                                                                    </button>
                                                                </li>
            
                                                                <form class="dropdown" action="{{ route('admin.'.$url.'.update', ['globalLeave' => $list->id]) }}" method="post">
                                                                    @csrf
                                                                    @method('PUT')
                                                                
                                                                    <!-- Add a hidden input field for user ID -->
                                                                    <input type="hidden" name="user_id" value="{{ $list->user->id }}">
                                                                    <input type="hidden" name="leave_policy_id" value="{{ $list->entitlement->policy->id }}">
                                                                    <input type="hidden" name="type" value="longLeave">
                                                                
                                                                    <li class="edit">
                                                                        <button type="submit"  name="approve" class="border-none d-flex justify-content-between align-items-center my-2 mx-3">
                                                                            <span>Approve</span>
                                                                            <span><i class="icon-check"></i></span>
                                                                        </button>
                                                                    </li>
                                                                </form>
            
                                                                <form class="dropdown" action="{{ route('admin.'.$url.'.update', ['globalLeave' => $list->id]) }}" method="post">
                                                                    @csrf
                                                                    @method('PUT')
                                                                
                                                                    <!-- Add a hidden input field for user ID -->
                                                                    <input type="hidden" name="user_id" value="{{ $list->user->id }}">
                                                                    <input type="hidden" name="leave_policy_id" value="{{ $list->entitlement->policy->id }}">
                                                                    <input type="hidden" name="type" value="longLeave">
                                                                
                                                                    <li class="pending">
                                                                        <button type="submit" name="pending" class="border-none d-flex justify-content-between align-items-center my-2 mx-3">
                                                                            <span>Pending</span>
                                                                            <span><i class="icon-minus"></i></span>
                                                                        </button>
                                                                    </li>
                                                                </form>
                                                                
                                                               
                                                                
                                                              
                                                                <form class="dropdown" action="{{ route('admin.'.$url.'.update', ['globalLeave' => $list->id]) }}" method="post">
                                                                    @csrf
                                                                    @method('PUT')
                                                                
                                                                    <!-- Add a hidden input field for user ID -->
                                                                    <input type="hidden" name="user_id" value="{{ $list->user->id }}">
                                                                    <input type="hidden" name="leave_policy_id" value="{{ $list->entitlement->policy->id }}">
                                                                    <input type="hidden" name="type" value="longLeave">
                                                                
                                                                    <li class="delete">
                                                                        <button type="submit"  name="reject" class="border-none d-flex justify-content-between align-items-center my-2 mx-3">
                                                                            <span>Reject</span>
                                                                            <span><i class="icon-close"></i></span>
                                                                        </button>
                                                                    </li>
                                                                </form>
            
                                                              </ul>
                                                    </div>
                                                </div>
                                            </td>
                                            {{-- @endcan --}}

                                        </tr>
                                    @endforeach
                                 @endif
                            </tbody>
                        </table>
                    </div>
                        


                      </div>




                      <div class="tab-pane fade" id="top-profile" role="tabpanel" aria-labelledby="profile-top-tab">


                        <div class="table-responsive">
                            <table class="display" id="basic-2">
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
                                                        
                                                        <li class="edit eye">
                                                            <button class="border-none" type="submit" name="approve"><i class="icofont icofont-eye"></i></button>
                                                        </li>
                                                        
                                                        <form action="{{ route('admin.'.$url.'.update', ['globalLeave' => $list->id]) }}" method="post">
                                                            @csrf
                                                            @method('PUT')
                                                        
                                                            <!-- Add a hidden input field for user ID -->
                                                            <input type="hidden" name="user_id" value="{{ $list->user->id }}">
                                                            <input type="hidden" name="type" value="lateAttendances">

                                                        
                                                            <li class="edit">
                                                                <button class="border-none" type="submit" name="approve"><i class="icon-check"></i></button>
                                                            </li>
                                                        </form>

                                                        <form action="{{ route('admin.'.$url.'.update', ['globalLeave' => $list->id]) }}" method="post">
                                                            @csrf
                                                            @method('PUT')
                                                        
                                                            <!-- Add a hidden input field for user ID -->
                                                            <input type="hidden" name="user_id" value="{{ $list->user->id }}">
                                                            <input type="hidden" name="type" value="lateAttendances">
                                                        
                                                            <li class="pending">
                                                                <button class="border-none" type="submit" name="pending"><i class="icon-minus"></i></i></button>
                                                            </li>
                                                        </form>
    
                                                        <form action="{{ route('admin.'.$url.'.update', ['globalLeave' => $list->id]) }}" method="post">
                                                            @csrf
                                                            @method('PUT')
                                                        
                                                            <!-- Add a hidden input field for user ID -->
                                                            <input type="hidden" name="user_id" value="{{ $list->user->id }}">
                                                            <input type="hidden" name="type" value="lateAttendances">

                                                        
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




                      <div class="tab-pane fade" id="top-contact" role="tabpanel" aria-labelledby="contact-top-tab">
                        <div class="table-responsive">
                            <table class="display" id="basic-3">
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
                                    @if(!empty($shortLeave))
                                        @foreach ($shortLeave as $list )
                                            <tr class="shortLeave_id{{$list->id}}">
    
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
    
                                                <td><span class="font-weight-bold">From: </span> {{$list->from}} <span class="font-weight-bold">To: </span> {{$list->to}}</td>
    
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

                                                        <li class="edit eye">
                                                            <button class="border-none" type="submit" name="approve"><i class="icofont icofont-eye"></i></button>
                                                        </li>
                                                        
                                                        <form action="{{ route('admin.'.$url.'.update', ['globalLeave' => $list->id]) }}" method="post">
                                                            @csrf
                                                            @method('PUT')
                                                        
                                                            <!-- Add a hidden input field for user ID -->
                                                            <input type="hidden" name="user_id" value="{{ $list->user->id }}">
                                                            <input type="hidden" name="type" value="shortLeave">

                                                        
                                                            <li class="edit">
                                                                <button class="border-none" type="submit" name="approve"><i class="icon-check"></i></button>
                                                            </li>
                                                        </form>

                                                        <form action="{{ route('admin.'.$url.'.update', ['globalLeave' => $list->id]) }}" method="post">
                                                            @csrf
                                                            @method('PUT')
                                                        
                                                            <!-- Add a hidden input field for user ID -->
                                                            <input type="hidden" name="user_id" value="{{ $list->user->id }}">
                                                            <input type="hidden" name="type" value="shortLeave">
                                                        
                                                            <li class="pending">
                                                                <button class="border-none" type="submit" name="pending"><i class="icon-minus"></i></i></button>
                                                            </li>
                                                        </form>

                                                        <form action="{{ route('admin.'.$url.'.update', ['globalLeave' => $list->id]) }}" method="post">
                                                            @csrf
                                                            @method('PUT')
                                                        
                                                            <!-- Add a hidden input field for user ID -->
                                                            <input type="hidden" name="user_id" value="{{ $list->user->id }}">
                                                            <input type="hidden" name="type" value="shortLeave">

                                                        
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