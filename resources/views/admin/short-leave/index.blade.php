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
    <li class="breadcrumb-item active">{{ $page_title }}</li>
@endsection

@section('content')
    @if (session('status'))
        <div class="alert alert-warning" role="alert">
            {{ session('status') }}
        </div>
    @endif

    @if (!empty($shortLeave))
    @foreach ($shortLeave as $list)
    <div class="modal fade" id="editModal{{ $list->id }}"
        tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenter" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <form
                action="{{ route('admin.' . $url . '.update', ['short_leave' => $list->id]) }}"
                method="POST" class="modal-content">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Update Short Leave</h5>
                    <button class="btn-close" type="button"
                        data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="">

                        <div class="row" id="shortLeaveFields">
                            <div class="col-md-4">
                                <label
                                    class="col-form-label">From</label>
                                <div class="col-sm-12">
                                    <input
                                        class="form-control digits"
                                        value="{{ $list->from }}"
                                        type="time"
                                        name="from" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label
                                    class="col-form-label">To</label>
                                <div class="col-sm-12">
                                    <input
                                        class="form-control digits"
                                        value="{{ $list->to }}"
                                        type="time"
                                        name="to" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <div>
                                    <label class="form-label"
                                        for="reason">Reason</label>
                                    <textarea class="form-control" name="reason" id="reason" rows="3" required>{{ $list->reason }}</textarea>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary"
                        type="button"
                        data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-primary"
                        type="submit">Save</button>
                </div>
            </form>
        </div>
    </div>
    @endforeach
    @endif

    <iframe id="print-frame"  style="display:none;"></iframe>  

    <div class="container-fluid">
        <div class="row">

            <!-- Zero Configuration  Starts-->
            <div class="col-sm-12">

                {{-- multi select form  Starts --}}
                <div class="card">
                    <input type="hidden" name="action_type" id="actionType">

                    <div class="card-header pb-0 card-no-border">

                        <div class="row">
                            <div class="d-flex justify-content-end">
                                <div>

                                    @can('short_leave_create')
                                        <button class="btn btn-primary" type="button" data-bs-toggle="modal"
                                            data-bs-target=".bd-example-modal-lg">Apply Leave</button>

                                        <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog"
                                            aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <form action="{{ route('admin.' . $url . '.store') }}" method="POST"
                                                        class="modal-content">
                                                        @csrf

                                                        <div class="modal-body">
                                                            <div class="">

                                                                <div>
                                                                    <div class="col-md-4">
                                                                        <h4 class="modal-title">Today {{ date('d-m-Y') }}</h4>
                                                                    </div>
                                                                </div>

                                                                <div class="row" id="shortLeaveFields">
                                                                    <div class="col-md-4">
                                                                        <label class="col-form-label">From</label>
                                                                        <div class="col-sm-12">
                                                                            <input class="form-control digits" type="time"
                                                                                name="from">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <label class="col-form-label">To</label>
                                                                        <div class="col-sm-12">
                                                                            <input class="form-control digits" type="time"
                                                                                name="to">
                                                                        </div>
                                                                    </div>
                                                                </div>


                                                                <div class="row">
                                                                    <div class="col">
                                                                        <div>
                                                                            <label class="form-label"
                                                                                for="exampleFormControlTextarea4">Reason</label>
                                                                            <textarea class="form-control" name="reason" id="exampleFormControlTextarea4" rows="3"></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button class="btn btn-secondary" type="button"
                                                                data-bs-dismiss="modal">Close</button>
                                                            <button class="btn btn-primary" type="submit">Add</button>
                                                        </div>
                                                    </form>


                                                </div>
                                            </div>
                                        </div>
                                    @endcan

                                    @can('short_leave_delete')
                                        <button class="btn btn-danger massActionButton" id="destroyAll" type="submit"
                                            onclick="setActionType('destroyAll')" data-bs-original-title=""
                                            title="">{{ trans('global.deleteAll') }}</button>
                                    @endcan

                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="display" id="basic-1">
                                <thead>
                                    <tr>
                                        @can('short_leave_delete')
                                            <th>
                                                <div class="form-check checkbox checkbox-dark mb-2">
                                                    <input id='selectall' class="form-check-input select-all-checkbox"
                                                        data-category="all" type="checkbox">
                                                    <label for="selectall" class="form-check-label"></label>
                                                </div>
                                            </th>
                                        @endcan
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Date</th>
                                        <th>Duration</th>
                                        <th>Reason</th>
                                        <th>status</th>
                                        <th>Approved by</th>

                                        <th>{{ trans('global.action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (!empty($shortLeave))
                                        @foreach ($shortLeave as $list)
                                            <tr class="shortLeave_id{{ $list->id }}">

                                                @can('short_leave_delete')
                                                    @if ($list->approved == 0)
                                                        <td>
                                                            <div class="form-check checkbox checkbox-dark mb-0">
                                                                <input class="form-check-input" name="massDelete[]"
                                                                    id={{ 'inline-' . $list->id }} value="{{ $list->id }}"
                                                                    type="checkbox" data-bs-original-title="" title>
                                                                <label class="form-check-label"
                                                                    for={{ 'inline-' . $list->id }}></label>
                                                            </div>
                                                        </td>
                                                    @else
                                                        <td></td>
                                                    @endif
                                                @endcan

                                                <td>{{ $list->id }}</td>

                                                <td>
                                                    {{ ucwords($list->user->first_name) }}
                                                    {{ ucwords($list->user->last_name) }}
                                                </td>
                                                <td>
                                                    {{ date('d/m/Y', strtotime($list->date)) }}
                                                </td>

                                                <td><span class="font-weight-bold">From: </span>
                                                    {{ date('h:i a', strtotime($list->from)) }} <span
                                                        class="font-weight-bold">To: </span>
                                                    {{ date('h:i a', strtotime($list->to)) }}</td>

                                                <td>
                                                    {{ $list->reason }}
                                                </td>
                                                <td>
                                                    @if ($list->approved == 0)
                                                        <p class="text-warning">Pending</p>
                                                    @elseif ($list->approved == 1)
                                                        <p class="text-success">Approved</p>
                                                    @else
                                                        <p class="text-danger">Rejected</p>
                                                    @endif

                                                </td>
                                                <td>
                                                    {{ ucwords(optional($list->approvedBy)->first_name) . ' ' . ucwords(optional($list->approvedBy)->last_name) ?? 'Not Approved' }}
                                                </td>

                                                <td>
                                                    <ul class="action">
                                                        @if ($list->approved == 0)
                                                                    @can('short_leave_update')
                                                                        <li class="edit">
                                                                            <button class="border-none" type="button"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#editModal{{ $list->id }}">
                                                                                <i class="icon-pencil-alt"></i>
                                                                            </button>
                                                                        </li>
                                                                     @endcan
                                                                     @can('short_leave_delete')
                                                                            <form
                                                                                onsubmit="return confirm('Are you sure you want to delete this leave?')"
                                                                                action="{{ route('admin.' . $url . '.destroy', ['short_leave' => $list->id]) }}"
                                                                                method="post">
                                                                                @csrf
                                                                                @method('DELETE')
                                                                                <li class="delete"><button class="border-none"
                                                                                        type="submit"><i class="icon-trash"></i></button>
                                                                                </li>

                                                                            </form>
                                                                    @endcan
                                                                @endif
                                                                <li class="edit">
                                                                    <button class="border-none" type="button" onclick="printContent('{{ route('admin.'.$url.'.print', ['leave' => $list->id]) }}')">
                                                                        <i class="icon-printer"></i>
                                                                    </button>
                                                                </li>
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
                {{-- multi select form Ends --}}
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
        $(document).ready(function() {
            // Disable the button initially if massDestroy array is empty
            updatemassActionButtonState();

            // Add an event listener to update the button state when the checkbox state changes
            $('input[name="massDelete[]"]').change(function() {
                updatemassActionButtonState();
            });


            //selecting all check boxes
            $('#selectall').change(function() {
                $('.form-check-input[name="massDelete[]"]').prop('checked', this.checked);
                updatemassActionButtonState();
            });

            // Function to handle individual checkboxes
            $('.form-check-input[name="massDelete[]"]').change(function() {
                if (!this.checked) {
                    $('#selectall').prop('checked', false);
                }
            });

        });

        //Toggling button between disable or enable
        function updatemassActionButtonState() {
            var isMassDestroyEmpty = $('input[name="massDelete[]"]:checked').length === 0;
            $('.massActionButton').prop('disabled', isMassDestroyEmpty);
        }

        function printContent(url) {
            console.log(url);
            var iframe = document.getElementById('print-frame');
            // iframe.style.display = 'block';
            iframe.onload = function() {
                iframe.contentWindow.focus();
                iframe.contentWindow.print();
            };
            iframe.src = url;
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


                if (actionType !== 'restoreAll') {

                    var isConfirm = confirm('Are you sure');
                    if (!isConfirm) return

                }

                // Collect selected user IDs
                $('input:checkbox[name="massDelete[]"]:checked').each(function() {
                    selectedUserIds.push($(this).val());
                });

                // Check if any users are selected
                if (selectedUserIds.length > 0) {
                    // Set the action type in the hidden input
                    setActionType(actionType);

                    // Prepare data for AJAX request
                    var requestData = {
                        action_type: actionType,
                        massDelete: selectedUserIds,
                        _token: '{{ csrf_token() }}'

                    };

                    // Make AJAX request
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('admin.user.massDelete') }}", // Update the URL to your controller method
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
