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
.file_view{
    cursor: pointer;
}

    @media (min-width: 768px) {
            h5.phone {
                display: none; /* Hide h5 on larger screens */
            }
        }

    /* Media query for screens smaller than 768 pixels (typical for phones) */
    @media (max-width: 767px) {
        h2.pc {
            display: none; /* Hide h2 on smaller screens */
        }
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
    <div class="edit-profile">
      <div class="row">
        <div class="col-xl-4">
          <div class="card">
            <div class="card-header">
              <h4 class="card-title mb-0">My Profile</h4>
              <div class="card-options"><a class="card-options-collapse" href="#" data-bs-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a><a class="card-options-remove" href="#" data-bs-toggle="card-remove"><i class="fe fe-x"></i></a></div>
            </div>
            <div class="card-body">
              <form>
                <div class="row mb-2">
                  <div class="profile-title">
                    @if (!empty($user->profile->image))   
                    <div class="media">
                        <img height="90px" width="100px" class=" rounded-circle" alt="" src="{{ asset('storage/profile_images/'.$user->profile->image) }}">
                        <div class="media-body">
                            <h5 class="mb-1">{{ucwords($user->first_name)}} {{ucwords($user->last_name)}}</h5>
                            <p>
                                @foreach($user->roles as $role)
                                  {{ $role->title ?? 'N/A' }}
                                @endforeach
                            </p>
                        </div>
                    </div>
                    @else
                    <div class="media">
                        <img class="img-70 rounded-circle" alt=""  src="{{ asset('storage/profile_images/placeholder.png') }}" >
                        <div class="media-body">
                            <h5 class="mb-1">{{ucwords($user->first_name)}} {{ucwords($user->last_name)}}</h5>
                            <p>
                                @foreach($user->roles as $role)
                                    {{ $role->title ?? 'N/A' }}
                                @endforeach
                            </p>
                        </div>
                    </div>
                    @endif

                  </div>
                </div>
                <div class="my-3 d-flex">
                  <h6 class="form-label">Phone :</h6>
                  <span class="mx-1">{{ $user->profile->phone ?? "N/A" }}</span>
                </div>
                <div class="my-3 d-flex">
                  <h6 class="form-label">Email :</h6>
                  <span class="mx-1">{{ $user->email  ?? "N/A"}}</span>
                </div>
                <div class="my-3 d-flex">
                  <h6 class="form-labe">Date of Birth :</h6>
                  <span class="mx-1">{{ $user->profile->date_of_birth ?? "N/A" }}</span>
                </div>
                <div class="my-3 d-flex">
                  <h6 class="form-label">Gender : </h6>
                  <span class="mx-1">{{ ucwords($user->profile->gender ?? "N/A" )}}</span>
                </div>
                <div class="my-3 d-flex">
                  <h6 class="form-label">Religion : </h6>
                  <span class="mx-1">{{ ucwords($user->profile->religion ?? "N/A") }}</span>
                </div>
                <div class="my-3 d-flex">
                  <h6 class="form-label">Marital Status :</h6>
                  <span class="mx-1">{{ ucwords($user->profile->marital_status ?? "N/A") }}</span>
                </div>
                <div class="my-3 d-flex">
                  <h6 class="">Nationality :</h6>
                  <span class="mx-1">{{ ucwords($user->profile->nationality ?? "N/A") }}</span>
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="col-xl-8">
          <form class="card">
            <div class="card-header">
                    <div class=" mb-3  d-flex justify-content-between align-item-betweem">
                        <h4 class="card-title mb-0">Edit Profile</h4>
                        <div class="d-flex">
                            <a href="{{route('admin.user-profile.edit',['user_profile'=>$user->id])}}"><h4><i class="icon-pencil-alt"></i></h4></a>
                            <a href="{{ url('admin/users') }}" class="btn btn-primary">Back</a>
                        </div>
                    </div>
              <div class="card-options"><a class="card-options-collapse" href="#" data-bs-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a><a class="card-options-remove" href="#" data-bs-toggle="card-remove"><i class="fe fe-x"></i></a></div>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-md-12">
                  <div class="mb-3">
                    <h6 class="form-label">Biography</h6>
                    <p>{{$user->profile->biography ?? "N/A"}}</p>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="mb-3">
                    <h6 class="form-label">Personal Email</h6>
                    <p>{{$user->profile->email ?? "N/A"}}</p>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="mb-3">
                    <h6 class="form-label">Personal Phone Number</h6>
                    <p>{{$user->profile->mobile ?? "N/A"}}</p>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="mb-3">
                    <h6 class="form-label">Address</h6>
                    <p>{{$user->profile->address ?? "N/A"}}</p>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="mb-3">
                    <h6 class="form-label">Second Address</h6>
                    <p>{{$user->profile->address2 ?? "N/A"}}</p>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="mb-3">
                    <h6 class="form-label">City</h6>
                    <p>{{$user->profile->city ?? "N/A"}}</p>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="mb-3">
                    <h6 class="form-label">Province/state</h6>
                    <p>{{$user->profile->province ?? "N/A"}}</p>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="mb-3">
                    <h6 class="form-label">Country</h6>
                    <p>{{$user->profile->country ?? "N/A"}}</p>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <h4 class="card-title mb-0">Add projects And Upload</h4>
              <div class="card-options"><a class="card-options-collapse" href="#" data-bs-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a><a class="card-options-remove" href="#" data-bs-toggle="card-remove"><i class="fe fe-x"></i></a></div>
            </div>
            <div class="table-responsive add-project">
              <table class="table card-table table-vcenter text-nowrap">
                <thead>
                  <tr>
                    <th>Project Name</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Price</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td><a class="text-inherit" href="#">Untrammelled prevents </a></td>
                    <td>28 May 2018</td>
                    <td><span class="status-icon bg-success"></span> Completed</td>
                    <td>$56,908</td>
                    <td class="text-end"><a class="icon" href="javascript:void(0)"></a><a class="btn btn-primary btn-sm" href="javascript:void(0)"><i class="fa fa-pencil"></i> Edit</a><a class="icon" href="javascript:void(0)"></a><a class="btn btn-transparent btn-sm" href="javascript:void(0)"><i class="fa fa-link"></i> Update</a><a class="icon" href="javascript:void(0)"></a><a class="btn btn-danger btn-sm" href="javascript:void(0)"><i class="fa fa-trash"></i> Delete</a></td>
                  </tr>
                  <tr>
                    <td><a class="text-inherit" href="#">Untrammelled prevents</a></td>
                    <td>12 June 2018</td>
                    <td><span class="status-icon bg-danger"></span> On going</td>
                    <td>$45,087</td>
                    <td class="text-end"><a class="icon" href="javascript:void(0)"></a><a class="btn btn-primary btn-sm" href="javascript:void(0)"><i class="fa fa-pencil"></i> Edit</a><a class="icon" href="javascript:void(0)"></a><a class="btn btn-transparent btn-sm" href="javascript:void(0)"><i class="fa fa-link"></i> Update</a><a class="icon" href="javascript:void(0)"></a><a class="btn btn-danger btn-sm" href="javascript:void(0)"><i class="fa fa-trash"></i> Delete</a></td>
                  </tr>
                  <tr>
                    <td><a class="text-inherit" href="#">Untrammelled prevents</a></td>
                    <td>12 July 2018</td>
                    <td><span class="status-icon bg-warning"></span> Pending</td>
                    <td>$60,123</td>
                    <td class="text-end"><a class="icon" href="javascript:void(0)"></a><a class="btn btn-primary btn-sm" href="javascript:void(0)"><i class="fa fa-pencil"></i> Edit</a><a class="icon" href="javascript:void(0)"></a><a class="btn btn-transparent btn-sm" href="javascript:void(0)"><i class="fa fa-link"></i> Update</a><a class="icon" href="javascript:void(0)"></a><a class="btn btn-danger btn-sm" href="javascript:void(0)"><i class="fa fa-trash"></i> Delete</a></td>
                  </tr>
                  <tr>
                    <td><a class="text-inherit" href="#">Untrammelled prevents</a></td>
                    <td>14 June 2018</td>
                    <td><span class="status-icon bg-warning"></span> Pending</td>
                    <td>$70,435</td>
                    <td class="text-end"><a class="icon" href="javascript:void(0)"></a><a class="btn btn-primary btn-sm" href="javascript:void(0)"><i class="fa fa-pencil"></i> Edit</a><a class="icon" href="javascript:void(0)"></a><a class="btn btn-transparent btn-sm" href="javascript:void(0)"><i class="fa fa-link"></i> Update</a><a class="icon" href="javascript:void(0)"></a><a class="btn btn-danger btn-sm" href="javascript:void(0)"><i class="fa fa-trash"></i> Delete</a></td>
                  </tr>
                  <tr>
                    <td><a class="text-inherit" href="#">Untrammelled prevents</a></td>
                    <td>25 June 2018</td>
                    <td><span class="status-icon bg-success"></span> Completed</td>
                    <td>$15,987</td>
                    <td class="text-end"><a class="icon" href="javascript:void(0)"></a><a class="btn btn-primary btn-sm" href="javascript:void(0)"><i class="fa fa-pencil"></i> Edit</a><a class="icon" href="javascript:void(0)"></a><a class="btn btn-transparent btn-sm" href="javascript:void(0)"><i class="fa fa-link"></i> Update</a><a class="icon" href="javascript:void(0)"></a><a class="btn btn-danger btn-sm" href="javascript:void(0)"><i class="fa fa-trash"></i> Delete</a></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('script')
    

    <script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatables/datatable.custom.js') }}"></script>
@endsection