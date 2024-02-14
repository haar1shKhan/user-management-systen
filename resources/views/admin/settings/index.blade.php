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

        li.dot {
            height: 1rem;
            width: 1rem;
            border-radius: 50%;
            padding: 2px;
            margin: 4px;
        }

        li.sidebar {
            margin-top: 0.5rem;
            height: 6rem;
        }

        li.body {
            margin-top: 0.5rem;
        }


        .flip {
            transform: scaleX(-1);
            transform-origin: center;
            transform-style: preserve-3d;
        }

        /* .flip > * {
                transform: scaleX(-1);
                transform-origin: center;
                transform-style: preserve-3d;
              } */
    </style>
@endsection

@section('breadcrumb-title')
    <h3>Settings</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">{{ $page_title }}</li>
    {{-- <li class="breadcrumb-item active">{{trans('admin/permission.permissions') }}</li> --}}
@endsection

@section('content')

    <div class="container-fluid">
        <div class="row">

            <!-- Zero Configuration  Starts-->
            <div class="col-sm-12 col-xxl-6">
                <div class="card">
                    <div class="card-header">
                        <h5>Settings</h5>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs border-tab nav-primary" id="top-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="top-home-tab" data-bs-toggle="tab" href="#top-appearance"
                                    role="tab" aria-controls="top-home" aria-selected="true">
                                    <i class="icofont icofont-layout"></i>
                                    Appearance
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="profile-top-tab" data-bs-toggle="tab" href="#top-profile"
                                    role="tab" aria-controls="top-profile" aria-selected="false"><i
                                        class="icofont icofont-man-in-glasses"></i>Profile</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="contact-top-tab" data-bs-toggle="tab" href="#top-contact"
                                    role="tab" aria-controls="top-contact" aria-selected="false"><i
                                        class="icofont icofont-contacts"></i>Contact</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="top-tabContent">
                            <div class="tab-pane fade show active" id="top-appearance" role="tabpanel" aria-labelledby="top-home-tab">
                                


                            </div>
                            <div class="tab-pane fade" id="top-profile" role="tabpanel"
                                aria-labelledby="profile-top-tab">
                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum
                                    has been the industry's standard dummy text ever since the 1500s, when an unknown
                                    printer took a galley of type and scrambled it to make a type specimen book. It has
                                    survived not only five centuries, but also the leap into electronic typesetting,
                                    remaining essentially unchanged. It was popularised in the 1960s with the release of
                                    Letraset sheets containing Lorem Ipsum passages, and more recently with desktop
                                    publishing software like Aldus PageMaker including versions of Lorem Ipsum</p>
                            </div>
                            <div class="tab-pane fade" id="top-contact" role="tabpanel"
                                aria-labelledby="contact-top-tab">
                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum
                                    has been the industry's standard dummy text ever since the 1500s, when an unknown
                                    printer took a galley of type and scrambled it to make a type specimen book. It has
                                    survived not only five centuries, but also the leap into electronic typesetting,
                                    remaining essentially unchanged. It was popularised in the 1960s with the release of
                                    Letraset sheets containing Lorem Ipsum passages, and more recently with desktop
                                    publishing software like Aldus PageMaker including versions of Lorem Ipsum</p>
                            </div>
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
    <script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatables/datatable.custom.js') }}"></script>
@endsection
