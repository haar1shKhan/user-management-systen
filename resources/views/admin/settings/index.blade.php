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
    <li class="breadcrumb-item">{{ $page_title }}</li>
    {{-- <li class="breadcrumb-item active">{{trans('admin/permission.permissions') }}</li> --}}
@endsection

@section('content')

    <div class="container-fluid">

        <div class="row">

            <!-- Zero Configuration  Starts-->
            <div class="col-sm-12 col-xxl-6">

                <div class="modal fade open_meta_icon_modal" tabindex="-1" role="dialog" aria-labelledby="meta_icon_modal" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                       <div class="modal-content">
                          <div class="modal-header">
                             <h4 class="modal-title" id="meta_icon_modal">Meta Icon crop</h4>
                             <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="card-body">

                            <div class="container-fluid">
                                <div class="img-cropper">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-xl-9 col-md-12 docs-buttons">
                                                            {{-- <div class="btn-group">
                                                                <button class="btn btn-outline-primary" type="button" data-method="reset" title="Reset"><span class="docs-tooltip" data-bs-toggle="tooltip" data-animation="false" title="$().cropper(&quot;reset&quot;)"><span class="fa fa-refresh"></span></span></button>
                                                                <label class="btn btn-outline-primary btn-upload" for="inputImage" title="Upload image file">
                                                                <input class="sr-only" id="inputImage" type="file" name="file" accept=".jpg,.jpeg,.png,.gif,.bmp,.tiff"><span class="docs-tooltip" data-bs-toggle="tooltip" data-animation="false" title="Import image with Blob URLs"><span class="fa fa-upload"></span></span>
                                                                </label>
                                                                <button class="btn btn-outline-primary" type="button" data-method="destroy" title="Destroy"><span class="docs-tooltip" data-bs-toggle="tooltip" data-animation="false" title="$().cropper(&quot;destroy&quot;)"><span class="fa fa-power-off"></span></span></button>
                                                            </div> --}}
                                                            <br>
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
                                                        <!-- /.docs-buttons-->
                                                        <div class="col-xl-3 col-md-12 docs-toggles">
                                                            <!-- <h3>Toggles:</h3>-->
                                                            <div class="btn-group d-flex flex-nowrap" data-bs-toggle="buttons">
                                                                <label class="btn btn-primary active">
                                                                <input class="sr-only" id="aspectRatio0" type="radio" name="aspectRatio" value="1.7777777777777777"><span class="docs-tooltip" data-bs-toggle="tooltip" data-animation="false" title="aspectRatio: 16 / 9">16:9</span>
                                                                </label>
                                                                <label class="btn btn-outline-primary">
                                                                <input class="sr-only" id="aspectRatio1" type="radio" name="aspectRatio" value="1.3333333333333333"><span class="docs-tooltip" data-bs-toggle="tooltip" data-animation="false" title="aspectRatio: 4 / 3">4:3</span>
                                                                </label>
                                                                <label class="btn btn-outline-primary">
                                                                <input class="sr-only" id="aspectRatio2" type="radio" name="aspectRatio" value="1"><span class="docs-tooltip" data-bs-toggle="tooltip" data-animation="false" title="aspectRatio: 1 / 1">1:1</span>
                                                                </label>
                                                                <label class="btn btn-outline-primary">
                                                                <input class="sr-only" id="aspectRatio3" type="radio" name="aspectRatio" value="0.6666666666666666"><span class="docs-tooltip" data-bs-toggle="tooltip" data-animation="false" title="aspectRatio: 2 / 3">2:3</span>
                                                                </label>
                                                                <label class="btn btn-outline-primary">
                                                                <input class="sr-only" id="aspectRatio4" type="radio" name="aspectRatio" value="NaN"><span class="docs-tooltip" data-bs-toggle="tooltip" data-animation="false" title="aspectRatio: NaN">Free</span>
                                                                </label>
                                                            </div>
                                                            <div class="btn-group d-flex flex-nowrap" data-bs-toggle="buttons">
                                                                <label class="btn btn-primary active">
                                                                <input class="sr-only" id="viewMode0" type="radio" name="viewMode" value="0" checked=""><span class="docs-tooltip" data-bs-toggle="tooltip" data-animation="false" title="View Mode 0">VM0</span>
                                                                </label>
                                                                <label class="btn btn-outline-primary">
                                                                <input class="sr-only" id="viewMode1" type="radio" name="viewMode" value="1"><span class="docs-tooltip" data-bs-toggle="tooltip" data-animation="false" title="View Mode 1">VM1</span>
                                                                </label>
                                                                <label class="btn btn-outline-primary">
                                                                <input class="sr-only" id="viewMode2" type="radio" name="viewMode" value="2"><span class="docs-tooltip" data-bs-toggle="tooltip" data-animation="false" title="View Mode 2">VM2</span>
                                                                </label>
                                                                <label class="btn btn-outline-primary">
                                                                <input class="sr-only" id="viewMode3" type="radio" name="viewMode" value="3"><span class="docs-tooltip" data-bs-toggle="tooltip" data-animation="false" title="View Mode 3">VM3</span>
                                                                </label>
                                                            </div>
                                                            <!-- /.dropdown-->
                                                            <!-- /.docs-toggles-->
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                         
                        </div>
                       </div>
                    </div>
                 </div>


                <div class="card">
                    <div class="card-header">
                        <h5>Settings</h5>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs border-tab nav-primary" id="top-tab" role="tablist">


                            <li class="nav-item">
                                <a class="nav-link active" id="profile-top-tab" data-bs-toggle="tab" href="#top-store"
                                    role="tab" aria-controls="top-store" aria-selected="true"><i
                                        class="icofont icofont-man-in-glasses"></i>Store</a>
                            </li>


                            <li class="nav-item">
                                <a class="nav-link " id="top-home-tab" data-bs-toggle="tab" href="#top-logo"
                                    role="tab" aria-controls="top-home" aria-selected="false">
                                    <i class="icofont icofont-layout"></i>
                                    logo
                                </a>
                            </li>


                            <li class="nav-item">
                                <a class="nav-link" id="contact-top-tab" data-bs-toggle="tab" href="#top-email" role="tab" aria-controls="top-email" aria-selected="false">
                                    <i class="icofont icofont-email"></i>Mail
                                </a>
                            </li>


                        </ul>
                        <form action="{{route("admin.setting.update",['setting'=>'1'])}}" method="POST">
                            @method("PUT")
                            @csrf

                        <div class="tab-content" id="top-tabContent">

                      
                            <div class="tab-pane fade " id="top-logo" role="tabpanel" aria-labelledby="top-home-tab">
                                
                                <div class="row my-4">
                                    {{-- Meta icon start --}}
                                    
                                    <div class="col-md-3 mb-3">
                                        <h5>Site Icon</h5>
                                        <div class="my-3">
                                            <img class="img-100" id="site-icon-preview" src="{{asset(config('settings.site_icon'))}}"/>
                                        </div>
                                        <label for="site-icon" class="btn btn-square btn-primary">Replace</label>
                                        <input class="file-input" data-preview="site-icon-preview" name="site-icon" style="display: none;" id="site-icon" accept=".jpg,.jpeg,.png,.gif,.bmp,.tiff" class="form-control" type="file">
                                        @error("meta_icon")
                                        <div class="invalid-feedback"> {{$message}} </div> 
                                        @enderror
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <h5>Site Logo</h5>
                                        <div class="my-3">
                                            <img class="img-100" id="site-logo-preview" src="{{asset(config('settings.site_icon'))}}"/>
                                        </div>
                                        <label for="site-logo" class="btn btn-square btn-primary">Replace</label>
                                        <input class="file-input" data-preview="site-logo-preview" name="site-logo" style="display: none;" id="site-logo" accept=".jpg,.jpeg,.png,.gif,.bmp,.tiff" class="form-control" type="file">
                                        @error("meta_icon")
                                        <div class="invalid-feedback"> {{$message}} </div> 
                                        @enderror
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <h5>Site Icon</h5>
                                        <img class="img-50" id="site-icon-preview3" src="{{asset(config('settings.site_icon'))}}"/>
                                        <label for="site-icon3" class="btn btn-square btn-primary">Replace</label>
                                        <input name="site-icon3" style="display: none;" id="site-icon3" accept=".jpg,.jpeg,.png,.gif,.bmp,.tiff" class="form-control" type="file">
                                        @error("meta_icon")
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
                                aria-labelledby="profile-top-tab">
                                    
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
                                aria-labelledby="contact-top-tab">
                                   
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
                                            <label class="form-label" for="store_owner">SMTP Timeout {{ config('mail.mailers.smtp.password') }}</label>
                                            <input class="form-control" id="store_owner" name="mail_smtp_timeout" value="{{ Config::get('settings.mail_smtp_timeout') }}" type="text"  required="" data-bs-original-title="" title="">
                                            {{-- <div class="valid-feedback">Looks good!</div> --}}
                                            <div class="text-danger mt-1">
                                                @error("store_owner")
                                                {{$message}}    
                                                @enderror
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-md-9 offset-md-10">
                                            <button class="btn btn-primary" type="submit" data-bs-original-title="" title="">Submit</button>
                                        </div>
                                    </div>

                            </div>

                        </form>
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
