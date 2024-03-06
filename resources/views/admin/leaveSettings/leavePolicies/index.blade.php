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
    <h3>{{trans('admin/leaveSettings/leavePolicies.leaveTypes') }}</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">{{ $page_title }}</li>
    <li class="breadcrumb-item active">{{trans('admin/leaveSettings/leavePolicies.leaveTypes') }}</li>
@endsection

@section('content')

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
                            <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target=".bd-example-modal-lg">Add Policy</button>

                            <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                   <div class="modal-content">
                                      <div class="modal-header">
                                         <h4 class="modal-title" id="myLargeModalLabel">Add Policy</h4>
                                         <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                                      </div>
                                      

                                      <form action="{{route('admin.'.$url.".leavePolicies.store")}}" method="POST" class="modal-content">
                                        @csrf

                                       <div class="modal-body">
                                            <div class="">

                                                <div class="row">
                                                    <div class="d-flex flex-column ">
                                                        <label class="form-label" for="title">Title</label>
                                                        <input class="form-control" id="title"  name="title" type="text" required >
                                                        <div class="text-danger mt-1">
                                                            @error("title")
                                                                {{ $message }}
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row d-flex align-items-end my-4">

                                                    <div class="d-flex flex-column  col-md-3">
                                                       <label class="form-label" for="days">Days</label>
                                                        <input class="form-control" id="days"  name="days" type="number" required >
                                                        <div class="text-danger mt-1">
                                                            @error("days")
                                                                {{ $message }}
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="form-check checkbox checkbox-dark  mx-3  col-md-3">
                                                        <input id='monthly' name="monthly" class="form-check-input monthly-checkbox" data-category="monthly" type="checkbox">
                                                        <label for="monthly" class="form-check-label">Monthly</label>
                                                    </div>

                                                    <div class="form-check checkbox checkbox-dark  mx-3 col-md-3">
                                                        <input id='advance_salary' name="advance_salary" class="form-check-input advance-salary-checkbox" data-category="advance_salary" type="checkbox">
                                                        <label for="advance_salary" class="form-check-label">Advance Salary</label>
                                                    </div>

                                                </div>

                                                <div class="row">


                                                    <div class="col-md-3">
                                                        <label class="form-label" for="role">{{ trans('admin/user.role') }}</label>
                                                        <select name="role"  class="form-select" id="role">

                                                            <option selected="true" disabled value="">Choose...</option>
                                                            <option  value="">All</option>
                                                            @foreach ($roles as $role)
                                                                <option value="{{ $role->title }}">
                                                                    {{ $role->title }}
                                                                </option>
                                                             @endforeach
                                                
                                                        </select>
                                                        <div class="text-danger mt-1">
                                                            @error("role")
                                                            {{$message}}    
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <label class="form-label" for="gender">Gender</label>
                                                        <select name="gender"  class="form-select" id="gender" >
                        
                                                            <option selected="true" disabled value="">Choose...</option>
                                                            <option   value="">All</option>
                                                            <option   value="male">Male</option>
                                                            <option   value="female">Female</option>
                                                
                                                        </select>
                                                        <div class="text-danger mt-1">
                                                            @error("gender")
                                                            {{$message}}    
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <label class="form-label" for="marital_status">Marital status</label>
                                                        <select name="marital_status"  class="form-select" id="marital_status" >
                        
                                                            <option selected="true" disabled value="">Choose...</option>
                                                            <option   value="">All</option>
                                                            <option   value="Bachelor">Bachelor</option>
                                                            <option   value="Married">Married</option>
                                                
                                                        </select>
                                                        <div class="text-danger mt-1">
                                                            @error("marital_status")
                                                            {{$message}}    
                                                            @enderror
                                                        </div>
                                                    </div>


                                                </div>

                                                <div class="row d-flex align-items-end my-4">

                                                    <div class="col-md-3">
                                                    
                                                        <label class="form-label" for="activate">Activate</label>
                                                        <select name="activate"  class="form-select" id="activate" required>
                        
                                                            <option selected="true" disabled value="">Choose...</option>
                                                            <option   value="manual">Manually</option>
                                                            <option   value="immediately_after_hiring">Immediately After Hiring</option>
                                                
                                                        </select>
                                                        <div class="text-danger mt-1">
                                                            @error("activate")
                                                            {{$message}}    
                                                            @enderror
                                                        </div>
                                                    </div>

                                                        
                                                     <div class="form-check checkbox checkbox-dark  mx-3 col-md-5">

                                                         <input id='existing_user' name="existing_user" class="form-check-input existing-user-checkbox" data-category="existing_user" type="checkbox">
                                                         <label for="existing_user" class="form-check-label">Apply to existing user</label>

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
                            {{-- modal end --}}

                            {{-- @endcan --}}

                            {{-- <a class="btn btn-danger" href="{{'/admin'.'/'.$url.'s?trash=1'}}">Trash</a> --}}
                            {{-- @can('permission_create') --}}

                            <button class="btn btn-danger"  id="massActionButton" type="submit" >{{trans('global.deleteAll') }}</button>

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
                                    <th class="col-8">{{trans('admin/leaveSettings/leavePolicies.type') }}</th>
                                    <th class="col-8">Days</th>
                                    <th class="col-8">Monthly</th>
                                    <th class="col-8">Advance Salary</th>
                                    <th class="col-8">Roles</th>
                                    <th class="col-8">Gender</th>
                                    <th class="col-8">Marital Status</th>
                                    <th class="col-8">Activate</th>

                                    {{-- @can('permission_edit' || 'permission_delete') --}}

                                    <th>{{trans('global.action') }}</th>
                                    {{-- @endcan --}}

                                </tr>
                            </thead>
                            <tbody>
                                @if(!is_null($leavePolicies))
                                    @foreach ($leavePolicies as $type)
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
                                                <h6>{{$type->days}}</h6>
                                            </td>
                                            <td>
                                                <h6>{{$type->monthly?"True" : "False" }}</h6>
                                            </td>
                                            <td>
                                                <h6>{{$type->advance_salary? "True" : "False"}}</h6>
                                            </td>
                                            <td>
                                                <h6>{{$type->roles ?? "All" }}</h6>
                                            </td>
                                            <td>
                                                <h6>{{$type->gender ?? "All"}}</h6>
                                            </td>
                                            <td>
                                                <h6>{{$type->marital_status ?? "All"}}</h6>
                                            </td>
                                            <td>
                                                <h6>{{$type->activate}}</h6>
                                            </td>
                                            <td>
                                                <ul class="action">
                                                    <li class="edit">
                                                        <button class="border-none" type="button" data-bs-toggle="modal" data-bs-target=".bd-{{$type->id}}-modal-lg">

                                                            <i class="icon-pencil-alt"></i>

                                                        </button>
                                                    </li>

                                                    <div class="modal fade bd-{{$type->id}}-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-lg">
                                                           <div class="modal-content">
                                                              <div class="modal-header">
                                                                 <h4 class="modal-title" id="myLargeModalLabel">Update Policies</h4>
                                                                 <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                                                              </div>
                                                              
                        
                                                              <form action="{{route('admin.'.$url.'.leavePolicies.update', ['policy' => $type->id])}}" method="POST" class="modal-content">
                                                                @csrf
                                                                @method('PUT')
                                                               <div class="modal-body">
                                                                    <div class="">
                        
                                                                        <div class="row">
                                                                            <div class="d-flex flex-column ">
                                                                                <label class="form-label" for="update_title-{{$type->id}}">Title</label>
                                                                                <input class="form-control" id="update_title-{{$type->id}}"  name="title" value="{{$type->title}}" type="text" required >
                                                                                <div class="text-danger mt-1">
                                                                                    @error("title")
                                                                                        {{ $message }}
                                                                                    @enderror
                                                                                </div>
                                                                            </div>
                                                                        </div>
                        
                                                                        <div class="row d-flex align-items-end my-4">
                        
                                                                            <div class="d-flex flex-column  col-md-3">
                                                                               <label class="form-label" for="update_days-{{$type->id}}">Days</label>
                                                                                <input class="form-control" id="update_days-{{$type->id}}"  name="days" value="{{$type->days}}" type="number" required >
                                                                                <div class="text-danger mt-1">
                                                                                    @error("days")
                                                                                        {{ $message }}
                                                                                    @enderror
                                                                                </div>
                                                                            </div>
                        
                                                                            <div class="form-check checkbox checkbox-dark  mx-3  col-md-3">
                                                                                <input id='update_monthly-{{$type->id}}' {{$type->monthly?"checked":""}} name="monthly" class="form-check-input monthly-checkbox" data-category="monthly" type="checkbox">
                                                                                <label for="update_monthly-{{$type->id}}" class="form-check-label">Monthly</label>
                                                                            </div>
                        
                                                                            <div class="form-check checkbox checkbox-dark  mx-3 col-md-3">
                                                                                <input id='update_advance_salary-{{$type->id}}' {{$type->advance_salary?"checked":""}} name="advance_salary" class="form-check-input advance-salary-checkbox" data-category="advance_salary" type="checkbox">
                                                                                <label for="update_advance_salary-{{$type->id}}" class="form-check-label">Advance Salary</label>
                                                                            </div>
                        
                                                                        </div>
                        
                                                                        <div class="row">
                        
                        
                                                                            <div class="col-md-3">
                                                                                <label class="form-label" for="update_role-{{$type->id}}">{{ trans('admin/user.role') }}</label>
                                                                                <select name="role"  class="form-select" id="update_role-{{$type->id}}">
                        
                                                                                    <option selected="true" disabled value="">Choose...</option>
                                                                                    
                                                                                    <option {{$type->roles == $role->title  ?"selected":""}} value="">All</option>
                                                                                    @foreach ($roles as $role)
                                                                                        <option {{$type->roles == $role->title  ?"selected":""}} value="{{ $role->title }}">
                                                                                            {{ $role->title }}
                                                                                        </option>
                                                                                     @endforeach
                                                                        
                                                                                </select>
                                                                                <div class="text-danger mt-1">
                                                                                    @error("role")
                                                                                    {{$message}}    
                                                                                    @enderror
                                                                                </div>
                                                                            </div>
                        
                                                                            <div class="col-md-3">
                                                                                <label class="form-label" for="update_gender-{{$type->id}}">Gender</label>
                                                                                <select name="gender"  class="form-select" id="update_gender-{{$type->id}}" >
                                                
                                                                                    <option selected="true" disabled value="">Choose...</option>
                                                                                    <option   value="">All</option>       
                                                                                    <option  {{$type->gender=="male"?"selected":""}} value="male">Male</option>
                                                                                    <option  {{$type->gender=="female"?"selected":""}}  value="female">Female</option>
                                                                        
                                                                                </select>
                                                                                <div class="text-danger mt-1">
                                                                                    @error("gender")
                                                                                    {{$message}}    
                                                                                    @enderror
                                                                                </div>
                                                                            </div>
                        
                                                                            <div class="col-md-3">
                                                                                <label class="form-label" for="update_marital_status-{{$type->id}}">Marital status</label>
                                                                                <select name="marital_status-{{$type->id}}"  class="form-select" id="update_marital_status" >
                                                
                                                                                    <option selected="true" disabled value="">Choose...</option>
                                                                                    <option   value="">All</option>       
                                                                                    <option {{$type->marital_status=="Bachelor"?"selected":""}}   value="Bachelor">Bachelor</option>
                                                                                    <option {{$type->marital_status=="Married"?"selected":""}}  value="Married">Married</option>
                                                                        
                                                                                </select>
                                                                                <div class="text-danger mt-1">
                                                                                    @error("marital_status")
                                                                                    {{$message}}    
                                                                                    @enderror
                                                                                </div>
                                                                            </div>
                        
                        
                                                                        </div>
                        
                                                                        <div class="row d-flex align-items-end my-4">
                        
                                                                            <div class="col-md-3">
                                                                            
                                                                                <label class="form-label" for="update_validationCustom04-{{$type->id}}">Activate</label>
                                                                                <select name="activate"  class="form-select" id="update_validationCustom04-{{$type->id}}" required>
                                                
                                                                                    <option selected="true" disabled value="">Choose...</option>
                                                                                    <option {{$type->activate=="manual"?"selected":""}}   value="manual">Manually</option>
                                                                                    <option {{$type->activate=="immediately_after_hiring"?"selected":""}} value="immediately_after_hiring">Immediately After Hiring</option>
                                                                        
                                                                                </select>
                                                                                <div class="text-danger mt-1">
                                                                                    @error("activate")
                                                                                    {{$message}}    
                                                                                    @enderror
                                                                                </div>
                                                                            </div>
                        
                                                                                
                                                                             <div class="form-check checkbox checkbox-dark  mx-3 col-md-5">
                        
                                                                                <input id='update_existing_user-{{$type->id}}' {{$type->apply_existing_users?"checked":""}} name="existing_user" class="form-check-input existing-user-checkbox" data-category="existing_user" type="checkbox">
                                                                                 <label for="update_existing_user-{{$type->id}}" class="form-check-label">Apply to existing user</label>
                        
                                                                             </div>
                        
                                                                        </div>
                        
                                                                       
                        
                                                                        
                                                                            
                        
                                                                           
                                                                     </div>
                                                              </div>
                                                              <div class="modal-footer">
                                                                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
                                                                <button class="btn btn-primary" type="submit">Update</button>
                                                             </div>
                                                              </form>
                        
                                                             
                                                           </div>
                                                        </div>
                                                     </div>

                                                    <form action="{{ route('admin.'.$url.'.leavePolicies.destroy', ['policy' => $type->id]) }}" method="post">
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
                         url: "{{route('admin.leaveSettings.policies.massAction')}}", // Update the URL to your controller method
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