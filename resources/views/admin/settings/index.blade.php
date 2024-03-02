@extends('layouts.admin')

@section('title', 'Default')

@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/image-cropper.css')}}">
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
    <li class="breadcrumb-item">System</li>
    <li class="breadcrumb-item active">{{ $page_title }}</li>
    {{-- <li class="breadcrumb-item active">{{trans('admin/permission.permissions') }}</li> --}}
@endsection

@section('content')

    <div class="container-fluid">

        <form  enctype="multipart/form-data" action="{{route("admin.setting.update",['setting'=>'1'])}}" method="POST" class="row">
            @method("PUT")
            @csrf

            <!-- Zero Configuration  Starts-->
            <div class=" col-xxl-12">

                <div class="card">
                    <div class="card-header d-flex justify-content-end">
                            <div class="">
                                <button class="btn btn-primary" type="submit">Save</button>
                            </div>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs border-tab nav-primary" id="top-tab" role="tablist">


                            <li class="nav-item">
                                <a class="nav-link active" id="profile-store-tab" data-bs-toggle="tab" href="#top-store"
                                    role="tab" aria-controls="top-store" aria-selected="true"><i
                                        class="icofont icofont-ui-home"></i>Store</a>
                            </li>


                            <li class="nav-item">
                                <a class="nav-link " id="profile-logo-tab" data-bs-toggle="tab" href="#top-logo"
                                    role="tab" aria-controls="top-home" aria-selected="false">
                                    <i class="icofont icofont-layout"></i>
                                    logo
                                </a>
                            </li>


                            <li class="nav-item">
                                <a class="nav-link" id="profile-email-tab" data-bs-toggle="tab" href="#top-email" role="tab" aria-controls="top-email" aria-selected="false">
                                    <i class="icofont icofont-email"></i>Mail
                                </a>
                            </li>


                        </ul>

                        <div>
                        <div class="tab-content" id="top-tabContent">

                      
                            <div class="tab-pane fade " id="top-logo" role="tabpanel" aria-labelledby="profile-logo-tab">
                                
                                <div class="row my-4">
                                    {{-- Meta icon start --}}
                                    
                                    <div class="col-md-3 mb-3">
                                        <h5>Site Icon</h5>
                                        <div class="my-3">
                                            <img class="img-100" id="site-icon-preview" src="{{asset(config('settings.site_icon'))}}"/>
                                        </div>
                                        <label for="site_icon" class="btn btn-square btn-primary">Replace</label>
                                        <input class="file-input" data-preview="site-icon-preview" name="site_icon" style="display: none;" id="site_icon" accept=".jpg,.jpeg,.png,.gif,.bmp,.tiff" class="form-control" type="file">
                                        @error("meta_icon")
                                        <div class="invalid-feedback"> {{$message}} </div> 
                                        @enderror
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <h5>Site Logo</h5>
                                        <div class="my-3">
                                            <img class="img-100" id="site-logo-preview" src="{{asset(config('settings.site_logo'))}}"/>
                                        </div>
                                        <label for="site_logo" class="btn btn-square btn-primary">Replace</label>
                                        <input class="file-input" data-preview="site-logo-preview" name="site_logo" style="display: none;" id="site_logo" accept=".jpg,.jpeg,.png,.gif,.bmp,.tiff" class="form-control" type="file">
                                        @error("site_logo")
                                        <div class="invalid-feedback"> {{$message}} </div> 
                                        @enderror
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <h5>Site Email</h5>
                                        <div class="my-3">
                                            <img class="img-100" id="site-email-preview" src="{{asset(config('settings.site_email'))}}"/>
                                        </div>
                                        <label for="site_email" class="btn btn-square btn-primary">Replace</label>
                                        <input class="file-input" data-preview="site-email-preview" name="site_email" style="display: none;" id="site_email" accept=".jpg,.jpeg,.png,.gif,.bmp,.tiff" class="form-control" type="file">
                                        @error("site_email")
                                        <div class="invalid-feedback"> {{$message}} </div> 
                                        @enderror
                                    </div>
                                    
                                    <div class="col-xl-9 col-md-12 docs-buttons">
                                        <!-- Show the cropped image in modal-->
                                        <div class="modal fade docs-cropped" id="getCroppedCanvasModal" aria-hidden="true" aria-labelledby="getCroppedCanvasTitle" role="dialog" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="getCroppedCanvasTitle">Cropped</h5>
                                                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                                    </div>
                                                    <div class="modal-body"></div>
                                                    <div class="modal-footer">
                                                        <button class="btn btn-primary" type="button" data-dismiss="modal">Close</button><a class="btn btn-outline-primary" id="download" href="javascript:void(0);" download="cropped.jpg') }}">Download</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.modal-->
                                    </div>                                   
                                    {{-- Meta icon end --}}
        
                                </div>

                            </div>


                            <div class="tab-pane fade show active" id="top-store" role="tabpanel"
                                aria-labelledby="profile-store-tab">
                                    
                                        <div class="col-md-6">
                                            <label class="form-label" for="store_name">Store Name</label>
                                            <input class="form-control" id="store_name" name="store_name" value="{{ Config::get('settings.store_name') }}" type="text"  required="" data-bs-original-title="" title="">
                                            {{-- <div class="valid-feedback">Looks good!</div> --}}
                                            <div class="text-danger mt-1">
                                                @error("store_name")
                                                {{$message}}    
                                                @enderror
                                            </div>
                                        </div>
            
                                        <div class="col-md-6">
                                            <label class="form-label" for="store_owner">Store Owner</label>
                                            <input class="form-control" id="store_owner" name="store_owner" value="{{ Config::get('settings.store_owner') }}" type="text"  required="" data-bs-original-title="" title="">
                                            {{-- <div class="valid-feedback">Looks good!</div> --}}
                                            <div class="text-danger mt-1">
                                                @error("store_owner")
                                                {{$message}}    
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label" for="store_address">Store Address</label>
                                            <input class="form-control" id="store_address" name="store_address" value="{{ Config::get('settings.store_address') }}" type="text"  required="" data-bs-original-title="" title="">
                                            {{-- <div class="valid-feedback">Looks good!</div> --}}
                                            <div class="text-danger mt-1">
                                                @error("store_address")
                                                {{$message}}    
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label" for="store_email">Store Email</label>
                                            <input class="form-control" id="store_email" name="store_email" value="{{ Config::get('settings.store_email') }}" type="email"  required="" data-bs-original-title="" title="">
                                            {{-- <div class="valid-feedback">Looks good!</div> --}}
                                            <div class="text-danger mt-1">
                                                @error("store_email")
                                                {{$message}}    
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label" for="store_phone">Store phone</label>
                                            <input class="form-control" id="store_phone" name="store_phone" value="{{ Config::get('settings.store_phone') }}" type="tel"  required="" data-bs-original-title="" title="">
                                            {{-- <div class="valid-feedback">Looks good!</div> --}}
                                            <div class="text-danger mt-1">
                                                @error("store_phone")
                                                {{$message}}    
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label" for="store_telephone">Store Telephone</label>
                                            <input class="form-control" id="store_telephone" name="store_telephone" value="{{ Config::get('settings.store_telephone') }}" type="tel"  required="" data-bs-original-title="" title="">
                                            {{-- <div class="valid-feedback">Looks good!</div> --}}
                                            <div class="text-danger mt-1">
                                                @error("store_telephone")
                                                {{$message}}    
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row d-flex align-items-center">

                                        <div class="col-md-3">
                                        <label class="form-label" for="store_Latitude">Store Latitude</label>
                                        <input class="form-control" id="store_latitude" name="store_latitude"  value="{{ Config::get('settings.store_latitude') }}" readonly type="text"  required="" data-bs-original-title="" title="">
                                        {{-- <div class="valid-feedback">Looks good!</div> --}}
                                        <div class="text-danger mt-1">
                                            @error("store_latitude")
                                            {{$message}}    
                                            @enderror
                                        </div>
                                        </div>

                                        <div class="col-md-3">
                                            <label class="form-label" for="store_longitude">Store Longitude</label>
                                            <input class="form-control" id="store_longitude" name="store_longitute" value="{{ Config::get('settings.store_longitute') }}" readonly   type="text"  required="" data-bs-original-title="" title="">
                                            {{-- <div class="valid-feedback">Looks good!</div> --}}
                                            <div class="text-danger mt-1">
                                                @error("store_longitude")
                                                {{$message}}    
                                                @enderror
                                            </div>
                                        </div>

                                            <div class="col-md-3 mt-3">
                                                <button class="btn btn-primary" id="get_location" onclick="getLocation()" type="button"  name="get_location">Get Location</button>
                                            </div>

                                    </div>
                                 
                            </div>


                            <div class="tab-pane fade" id="top-email" role="tabpanel"
                                aria-labelledby="profile-email-tab">
                                   
                                        <div class="col-md-6">
                                            <label class="form-label" for="store_name">SMTP Hostname</label>
                                            <input class="form-control" id="store_name" name="mail_smtp_hostname" value="{{ Config::get('settings.mail_smtp_hostname') }}" type="text"  required="" data-bs-original-title="" title="">
                                            {{-- <div class="valid-feedback">Looks good!</div> --}}
                                            <div class="text-danger mt-1">
                                                @error("store_name")
                                                {{$message}}    
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label" for="store_owner">SMTP Username</label>
                                            <input class="form-control" id="store_owner" name="mail_smtp_username" value="{{ Config::get('settings.mail_smtp_username') }}" type="text"  required="" data-bs-original-title="" title="">
                                            {{-- <div class="valid-feedback">Looks good!</div> --}}
                                            <div class="text-danger mt-1">
                                                @error("store_owner")
                                                {{$message}}    
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label" for="store_owner">SMTP Password</label>
                                            <input class="form-control" id="store_owner" name="mail_smtp_password" value="{{ Config::get('settings.mail_smtp_password') }}" type="text"  required="" data-bs-original-title="" title="">
                                            {{-- <div class="valid-feedback">Looks good!</div> --}}
                                            <div class="text-danger mt-1">
                                                @error("store_owner")
                                                {{$message}}    
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label" for="store_owner">SMTP Port</label>
                                            <input class="form-control" id="store_owner" name="mail_smtp_port" value="{{ Config::get('settings.mail_smtp_port') }}" type="text"  required="" data-bs-original-title="" title="">
                                            {{-- <div class="valid-feedback">Looks good!</div> --}}
                                            <div class="text-danger mt-1">
                                                @error("store_owner")
                                                {{$message}}    
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label" for="store_owner">SMTP Timeout</label>
                                            <input class="form-control" id="store_owner" name="mail_smtp_timeout" value="{{ Config::get('settings.mail_smtp_timeout') }}" type="text"  required="" data-bs-original-title="" title="">
                                            {{-- <div class="valid-feedback">Looks good!</div> --}}
                                            <div class="text-danger mt-1">
                                                @error("store_owner")
                                                {{$message}}    
                                                @enderror
                                            </div>
                                        </div>

                                    </div>

                            </div>

                        </div>
                    </div>
                </div>
            </form>
            <!-- Zero Configuration  Ends-->

        </div>
    </div>

    <script type="text/javascript">
        var session_layout = '{{ session()->get('layout') }}';
    </script>
@endsection

@section('script')
    <script>

        let fileInput = $('.file-input');
        fileInput.each(element => {
            $(this).change(function(e){
                let file = e.target.files[0];
                let preview = $('#'+e.target.getAttribute("data-preview"));
                var reader = new FileReader();

                if (file) {
                    
                    reader.onload = function(e){
                        preview.attr('src', reader.result);
                    }
                
                    reader.readAsDataURL(file);
                } else {
                  preview.src = "";
                }
            }) 
        });


        function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                function(position) {
                    // Populate latitude and longitude fields with current geolocation
                    document.getElementById("store_latitude").value = position.coords.latitude;
                    document.getElementById("store_longitude").value = position.coords.longitude;
                },
                function(error) {
                    console.error('Error getting location:', error.message);
                    alert('Error getting location. Please check your browser settings.');
                }
            );
        } else {
            alert("Geolocation is not supported by this browser.");
        }
    }
    </script>
   <script src="{{asset('assets/js/image-cropper/cropper.js')}}"></script>
   <script src="{{asset('assets/js/image-cropper/cropper-main.js')}}"></script>
@endsection
