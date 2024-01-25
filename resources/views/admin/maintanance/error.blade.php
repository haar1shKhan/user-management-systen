@extends('layouts.admin')


@section('style')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/animate.css') }}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/summernote.css')}}">
@endsection

@section('content')
<div class="col-sm-12">
    <div class="card">
      <div class="card-header">
        <h5>Hint for words Summernote</h5>
      </div>
      <div class="card-body">
        <div id="error-log">  
              @foreach ($errors as $error)
            <pre>{{ $error }}</pre>
             @endforeach</div>
      </div>
    </div>
  </div>
@endsection

@section('script')
<script src="{{ asset('assets/js/jquery.ui.min.js') }}"></script>
<script src="{{ asset('assets/js/editor/summernote/summernote.js') }}"></script>
<script src="{{ asset('assets/js/editor/summernote/summernote.custom.js') }}"></script>
<script src="{{ asset('assets/js/tooltip-init.js') }}"></script>
@endsection