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
div .eye i{
    color: black;
    margin: auto;
}
div .edit i{
    color: green;
    padding: 0;
}
div .delete i{
    color: red;
    padding: 0;

}
div .pending i{
    color: rgb(241, 155, 26);
    text-align: center;
    margin: 0;

}

.act li{
    /* padding: 8px 4px;
    text-align: center; */
    margin: 0px 4px;
    text-align: center;

}
/* .act li:hover{
    padding: 8px 4px;
    background-color: rgb(233, 227, 227);
    text-align: center;
    border-radius: 50%;
} */


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

            <div class="card">
                <input type="hidden" name="table_type" id="tableType">

                <div class="card-header pb-0 card-no-border">

                    <div class="d-flex justify-content-between">
                        <h3>{{ trans('admin/longLeave.leaveTable') }}</h3>
                        <div>

                            {{-- @can('role_delete') --}}
                            {{-- <button class="btn btn-danger massActionButton" id="destroyAll" type="submit" onclick="setActionType('destroyAll')"  data-bs-original-title="" title="">{{ trans('global.deleteAll')}}</button> --}}
                            <select name="massActionSelect"  class="form-select" id="massActionSelect" required="">

                                <option selected="true" disabled value="">Choose...</option>
                                <option   value="pending_all">Pending All</option>
                                <option   value="accept_all">Accept All</option>
                                <option   value="reject_all">Reject All</option>
                    
                            </select>
                            {{-- @endcan --}}

                        </div>
                    </div>
                        
                </div>
                <div class="card-body">
                    <ul class="nav nav-tabs border-tab nav-primary" id="top-tab" role="tablist">

                      <li class="nav-item"><a onclick="setTableType('long-leave')" class="nav-link active" id="top-home-tab" data-bs-toggle="tab" href="#long-leave" role="tab" aria-controls="top-home" aria-selected="true"><i class="icofont icofont-layout"></i>Long Leave</a></li>
                      <li class="nav-item"><a onclick="setTableType('late-attendance')" class="nav-link" id="profile-top-tab" data-bs-toggle="tab" href="#late-attendance" role="tab" aria-controls="top-profile" aria-selected="false"><i class="icofont icofont-man-in-glasses"></i>Late Attendance</a></li>
                      <li class="nav-item"><a onclick="setTableType('short-leave')" class="nav-link" id="contact-top-tab" data-bs-toggle="tab" href="#short-leave" role="tab" aria-controls="top-contact" aria-selected="false"><i class="icofont icofont-contacts"></i>Short Leave</a></li>

                    </ul>
                    <div class="tab-content" id="top-tabContent">

                      <div class="tab-pane fade show active" id="long-leave" role="tabpanel" aria-labelledby="top-home-tab">
                        

                        <div class="table-responsive">
                        <table class="display" id="basic-1">
                            <thead>
                                <tr>
                                    {{-- @can('user_edit' || 'user_delete') --}}

                                    <th>
                                        <div class="form-check checkbox checkbox-dark mb-2">
                                              <input id='selectall1' class="form-check-input select-all-checkbox" data-category="all" type="checkbox">
                                              <label for="selectall1" class="form-check-label"></label>
                                        </div>
                                    </th>

                                    {{-- @endcan --}}
                                    <th>{{ trans('global.id') }}</th>
                                    <th>{{ trans('admin/user.name') }}</th>
                                    <th>Leave Type</th>
                                    <th>From</th>
                                    <th>To</th>
                                    <th>Reason</th>
                                    <th>File</th>
                                    <th>status</th>
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
                                                                <p>From :{{ date('d/m/Y', strtotime($list->from)) }} To : {{ date('d/m/Y', strtotime($list->to)) }}</p>
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
                                            

                                            <td >
                                                
                                                 
                                                <ul class="d-flex justify-content-center align-items-center" >

                                                    <li data-bs-toggle="modal" data-bs-target="#file{{$list->id}}" class="eye mx-1">
                                                        <button type="submit" class="border-none">
                                                            <span><i class="icon-eye"></i></span>
                                                        </button>
                                                    </li>
                                                    {{-- <form class="" action="{{ route('admin.'.$url.'.update', ['globalLeave' => $list->id]) }}" method="post">
                                                        @csrf
                                                        @method('PUT')
                                                    
                                                        <!-- Add a hidden input field for user ID -->
                                                        <input type="hidden" name="user_id" value="{{ $list->user->id }}">
                                                        <input type="hidden" name="leave_policy_id" value="{{ $list->entitlement->policy->id }}">
                                                        <input type="hidden" name="type" value="longLeave">
                                                    
                                                        <li class="edit mx-1">
                                                            <button type="submit"  name="approve" class="border-none d-flex justify-content-between align-items-center">
                                                                <span><i class="icon-check"></i></span>
                                                            </button>
                                                        </li>
                                                    </form>

                                                    <form class="" action="{{ route('admin.'.$url.'.update', ['globalLeave' => $list->id]) }}" method="post">
                                                        @csrf
                                                        @method('PUT')
                                                    
                                                        <!-- Add a hidden input field for user ID -->
                                                        <input type="hidden" name="user_id" value="{{ $list->user->id }}">
                                                        <input type="hidden" name="leave_policy_id" value="{{ $list->entitlement->policy->id }}">
                                                        <input type="hidden" name="type" value="longLeave">
                                                    
                                                        <li class="pending mx-1">
                                                            <button type="submit" name="pending" class="border-none d-flex justify-content-between align-items-center">
                                                                <span><i class="icon-minus"></i></span>
                                                            </button>
                                                        </li>
                                                    </form> 
                                                
                                                    <form class="" action="{{ route('admin.'.$url.'.update', ['globalLeave' => $list->id]) }}" method="post">
                                                        @csrf
                                                        @method('PUT')
                                                    
                                                        <!-- Add a hidden input field for user ID -->
                                                        <input type="hidden" name="user_id" value="{{ $list->user->id }}">
                                                        <input type="hidden" name="leave_policy_id" value="{{ $list->entitlement->policy->id }}">
                                                        <input type="hidden" name="type" value="longLeave">
                                                    
                                                        <li class="delete mx-1">
                                                            <button type="submit"  name="reject" class="border-none d-flex justify-content-between align-items-center">
                                                                <span><i class="icon-close"></i></span>
                                                            </button>
                                                        </li>
                                                    </form> --}}

                                                    <li class="d-flex justify-content-center align-items-center dropdown icon-dropdown" >
                                                            <button class="btn dropdown-toggle actionDropDown" id="{{$list->id}}" type="button"
                                                            aria-haspopup="true"  data-bs-toggle="dropdown" aria-expanded="false">
                                                                <i class="icon-more-alt"></i>
                                                            </button>

                                                            <div class="dropdown-menu " aria-labelledby="{{$list->id}}">
                                                                    <ul class="action d-flex flex-column justify-content-around">

                                                                    
                    
                                                                        <form class="" action="{{ route('admin.'.$url.'.update', ['globalLeave' => $list->id]) }}" method="post">
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
                    
                                                                        <form class="" action="{{ route('admin.'.$url.'.update', ['globalLeave' => $list->id]) }}" method="post">
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
                                                                        
                                                                    
                                                                        
                                                                    
                                                                        <form class="" action="{{ route('admin.'.$url.'.update', ['globalLeave' => $list->id]) }}" method="post">
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
                                                        </li>
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




                      <div class="tab-pane fade" id="late-attendance" role="tabpanel" aria-labelledby="profile-top-tab">


                        <div class="table-responsive">
                            <table class="display" id="basic-2">
                                <thead>
                                    <tr>
                                        {{-- @can('user_edit' || 'user_delete') --}}
    
                                        <th>
                                            <div class="form-check checkbox checkbox-dark mb-2">
                                                  <input id='selectall2' class="form-check-input select-all-checkbox" data-category="all" type="checkbox">
                                                  <label for="selectall2" class="form-check-label"></label>
                                            </div>
                                        </th>
    
                                        {{-- @endcan --}}
                                        <th>{{ trans('global.id') }}</th>
                                        <th>{{ trans('admin/user.name') }}</th>
                                        <th>Date</th>
                                        <th>Leave From</th>
                                        <th>Leave To</th>
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
    
                                                <td>
                                                    <div class="form-check checkbox checkbox-dark mb-0">
                                                        <input class="form-check-input" name="massAction" id={{"inline-".$list->id}} value="{{ $list->id }}" type="checkbox" data-bs-original-title="" title>
                                                        <label class="form-check-label" for={{"inline-".$list->id}}></label>
                                                    </div>
                                                </td>
                                                
    
                                                {{-- @endcan --}}
    
                                                <td>{{$list->id}}</td>
    
                                                <td>
                                                    {{ucwords($list->user->first_name)}} {{ucwords($list->user->last_name)}}
                                                </td>
                                                <td>{{ date('d/m/Y', strtotime($list->date)) }}</td>
                                                <td>{{date ('h:i a',strtotime($list->from))}}</td>
                                                <td>{{date ('h:i a',strtotime($list->to))}}</td>
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
                                                    {{ucwords(optional($list->approvedBy)->first_name) . ' ' . ucwords(optional($list->approvedBy)->last_name) ?? 'Not Approved' }}
                                                </td>
    
                                                {{-- @can('user_edit' || 'user_delete') --}}
    
                                                <td>
                                                    <ul class="act d-flex justify-content-even">    
                                                        
                                                        <li class="">
                                                            <form action="{{ route('admin.'.$url.'.update', ['globalLeave' => $list->id]) }}" method="post">
                                                                 @csrf
                                                                 @method('PUT')

                                                                 <!-- Add a hidden input field for user ID -->
                                                                 <input type="hidden" name="user_id" value="{{ $list->user->id }}">
                                                                 <input type="hidden" name="type" value="lateAttendances">


                                                                 <button class="border-none" type="submit" name="approve"><i class="icon-check text-success font-weight-bold"></i></button>
                                                            </form>
                                                        </li>

                                                        <li class="mx-1">
                                                            <form action="{{ route('admin.'.$url.'.update', ['globalLeave' => $list->id]) }}" method="post">
                                                                @csrf
                                                                @method('PUT')
                                                            
                                                                <!-- Add a hidden input field for user ID -->
                                                                <input type="hidden" name="user_id" value="{{ $list->user->id }}">
                                                                <input type="hidden" name="type" value="lateAttendances">

                                                                <button class="border-none" type="submit" name="pending"><i class="icofont icofont-clock-time text-warning font-weight-bold"></i></button>
                                                             </form>
                                                        </li>
    
                                                        <li class="">
                                                        <form action="{{ route('admin.'.$url.'.update', ['globalLeave' => $list->id]) }}" method="post">
                                                            @csrf
                                                            @method('PUT')
                                                        
                                                            <!-- Add a hidden input field for user ID -->
                                                            <input type="hidden" name="user_id" value="{{ $list->user->id }}">
                                                            <input type="hidden" name="type" value="lateAttendances">

                                                        
                                                                <button class="border-none" type="submit" name="reject"><i class="icon-close text-danger font-weight-bold"></i></button>
                                                            </form>
                                                        </li>
                                                        
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




                      <div class="tab-pane fade" id="short-leave" role="tabpanel" aria-labelledby="contact-top-tab">
                        <div class="table-responsive">
                            <table class="display" id="basic-3">
                                <thead>
                                    <tr>
                                        {{-- @can('user_edit' || 'user_delete') --}}
    
                                        <th>
                                            <div class="form-check checkbox checkbox-dark mb-2">
                                                  <input id='selectall3' class="form-check-input select-all-checkbox" data-category="all" type="checkbox">
                                                  <label for="selectall3" class="form-check-label"></label>
                                            </div>
                                        </th>
    
                                        {{-- @endcan --}}
                                        <th>{{ trans('global.id') }}</th>
                                        <th>{{ trans('admin/user.name') }}</th>
                                        <th>date</th>
                                        <th>Leave From</th>
                                        <th>Leave To</th>
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
    
                                                <td>
                                                    <div class="form-check checkbox checkbox-dark mb-0">
                                                        <input class="form-check-input" name="massAction" id={{"_1inline-".$list->id}} value="{{ $list->id }}" type="checkbox" data-bs-original-title="" title>
                                                        <label class="form-check-label" for={{"_inline-".$list->id}}></label>
                                                    </div>
                                                </td>
    
                                                {{-- @endcan --}}
    
                                                <td>{{$list->id}}</td>
    
                                                <td>
                                                    {{ucwords($list->user->first_name)}} {{ucwords($list->user->last_name)}}
                                                </td>
                                                <td>{{ date('d/m/Y', strtotime($list->date)) }}</td>
                                                <td>{{date ('h:i a',strtotime($list->from))}}</td>
                                                <td>{{date ('h:i a',strtotime($list->to))}}</td>
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
                                                    {{ucwords(optional($list->approvedBy)->first_name) . ' ' . ucwords(optional($list->approvedBy)->last_name) ?? 'Not Approved' }}
                                                </td>
    
                                                {{-- @can('user_edit' || 'user_delete') --}}
    
                                                <td>
                                                    <ul class="action">
                                                        
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

        // let dropdownButton = $('.actionDropDown');
        // // console.log(dropdownButton);
        // dropdownButton.each(function() {
        //     console.log($(this).attr('id'));
        //     let id = $(this).attr('id')
        //     document.getElementById(id).dispatchEvent(new Event('click'));
        // });
        // function closeDropdown(dropdownId) {
        //      let dropdown = document.getElementById(dropdownId);
        //      console.log(dropdownId);

        //      if (dropdown) {
        //          let bootstrapDropdown = new bootstrap.Dropdown(dropdown);
        //          bootstrapDropdown.hide();
        //      } else {
        //          console.error('Dropdown not found with id: ' + dropdownId);
        //      }

        // }
        
        
        $(document).ready(function () {
        // Function to update the shared select input based on selected checkboxes
        function updateMassActionButtonState(tableId) {
            var isMassActionEmpty = $('#' + tableId + ' input[name="massAction"]:checked').length === 0;
            $('#' + tableId + ' .massActionButton').prop('disabled', isMassActionEmpty);
        }

        // Event listeners for checkboxes in each table
        $('input[name="massAction"]').change(function () {
            var tableId = $(this).closest('table').attr('id');
            updateMassActionButtonState(tableId);
        });

        // Event listener for "Select All" checkbox in each table
        $('#selectall1').change(function () {
            var tableId = $(this).closest('table').attr('id');
            $('#' + tableId + ' input[name="massAction"]').prop('checked', this.checked);
            updateMassActionButtonState(tableId);
        });
        $('#selectall2').change(function () {
            var tableId = $(this).closest('table').attr('id');
            $('#' + tableId + ' input[name="massAction"]').prop('checked', this.checked);
            updateMassActionButtonState(tableId);
        });
        $('#selectall3').change(function () {
            var tableId = $(this).closest('table').attr('id');
            $('#' + tableId + ' input[name="massAction"]').prop('checked', this.checked);
            updateMassActionButtonState(tableId);
        });

        // Event listener for the shared select input
        $('#massActionSelect').change(function () {
            var selectedAction = $(this).val();

            // Iterate over the tables and perform the selected action for each
            ['basic-1', 'basic-2', 'basic-3'].forEach(function (tableId) {
                var selectedUserIds = $('#' + tableId + ' input[name="massAction"]:checked').map(function () {
                    return $(this).val();
                }).get();

                if (selectedUserIds.length > 0) {
                    // Perform the selected action using AJAX or other logic
                    // Here, I'm just logging the action and selected IDs to the console
                    var requestData = {
                         action_type: selectedAction,
                         tableId: tableId,
                         massAction: selectedUserIds,
                         _token: '{{csrf_token()}}'

                     };

                    $.ajax({
                         type: 'POST',
                         url: "{{route('admin.globalLeave.massAction')}}", // Update the URL to your controller method
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
                    // console.log('Table:', tableId, 'Action:', selectedAction, 'Selected IDs:', selectedUserIds);
                }
            });
        });
    });


    </script>
    <script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatables/datatable.custom.js') }}"></script>
@endsection