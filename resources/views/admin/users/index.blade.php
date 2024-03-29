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
    <h3>المستخدمين</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">System</li>
    <li class="breadcrumb-item">User Management</li>
    <li class="breadcrumb-item active">{{ $page_title }}</li>
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
                    <div class="row">
                        @if($trash)
                        <div class="d-flex justify-content-end"> 
                            <div>
                                <a class="btn btn-primary" href="/admin/users">العودة</a>
                                <button class="btn btn-danger massActionButton"   type="submit"  onclick="setActionType('forceDestroyAll')" data-bs-original-title="" title="">حذف الكل</button>
                                <button class="btn btn-success massActionButton"  onclick="setActionType('restoreAll')"  type="submit" data-bs-original-title="" title="">استعادة الكل</button>
                            </div>
                        </div>
                        @else
                        <div class="d-flex justify-content-end">
                            <div>
                                    @can('user_create')
                                    
                                    <a class="btn btn-primary" href="{{ route('admin.user.create') }}">إضافة مستخدم جديد</a>
                                    
                                    @endcan 
                                    
                                    @can('user_delete')
                                    
                                    <a class="btn btn-danger" href="/admin/users?trash=1">سلة المهملات</a>
                                    <button class="btn btn-danger massActionButton" id="destroyAll" type="submit" onclick="setActionType('destroyAll')"  data-bs-original-title="" title="">حذف الكل</button>
                                    
                                    @endcan
                            </div>

                        </div>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="display" id="basic-1">
                            <thead>
                                <tr>
                                    @if (Gate::check('user_edit') || Gate::check('user_delete'))

                                    <th>
                                        <div class="form-check checkbox checkbox-dark mb-2">
                                              <input id='selectall' class="form-check-input select-all-checkbox" data-category="all" type="checkbox">
                                              <label for="selectall" class="form-check-label"></label>
                                        </div>
                                    </th>

                                    @endif

                                    <th>رقم التعريفي</th>
                                    <th>الاسم</th>
                                    <th>البريد الالكتروني</th>
                                    <th>الأدوار</th>


                                    @if (Gate::check('user_edit') || Gate::check('user_delete'))

                                    <th>الإجراءات</th>

                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @if(!empty($users))
                                    @foreach ($users as $user )
                                        <tr class="user_id{{$user->id}}">

                                            @if (Gate::check('user_edit') || Gate::check('user_delete'))

                                            <td>
                                                <div class="form-check checkbox checkbox-dark mb-0">
                                                    <input class="form-check-input" name="massAction" id={{"inline-".$user->id}} value="{{ $user->id }}" type="checkbox" data-bs-original-title="" title>
                                                    <label class="form-check-label" for={{"inline-".$user->id}}></label>
                                                </div>
                                            </td>

                                            @endcan

                                            <td>{{$user->id}}</td>
                                            <td>
                                               <h6><a style="color: black" href="{{route('admin.user.show',['user'=>$user->id])}}">{{ucwords($user->first_name)}} {{ucwords($user->last_name)}}</a></h6>
                                            </td>
                                            <td>{{$user->email}}</td>
                                            <td>
                                                @foreach ($user->roles as $role)
                                                    {{ $role->title }}<br>
                                                @endforeach
                                            </td>

                                            @if (Gate::check('user_edit') || Gate::check('user_delete'))

                                                <td>
                                                        <ul class="action">
                                                            @if ($user->deleted_at)

                                                                <li class="edit"> 
                                                                    <a href="{{route('admin.user.restore',['user'=>$user->id])}}">
                                                                    <i class="fa fa-undo"></i>
                                                                </a>
                                                                </li>
                                                                <form action="{{route('admin.user.forceDelete',['user'=>$user->id])}}" method="post">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <li class="delete"><button class="border-none" type="submit"><i class="icon-trash"></i></button></li>
                                                                </form>
                                                                @else
                                                                
                                                                @can('user_edit')      
                                                                <li class="edit"> <a href="{{route('admin.user.edit',['user'=>$user->id])}}">
                                                                    <i class="icon-pencil-alt"></i></a>
                                                                </li>
                                                                @endcan

                                                                @can('user_delete')
                                                                <form action="{{route('admin.user.destroy',['user'=>$user->id])}}" method="post">
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