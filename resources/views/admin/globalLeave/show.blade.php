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
    <h3>User Details</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item active">Users</li>
<li class="breadcrumb-item">{{ $page_title }}</li>
@endsection

@section('content')

@endsection

@section('script')
    

    <script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatables/datatable.custom.js') }}"></script>
@endsection