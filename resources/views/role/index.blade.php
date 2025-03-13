@extends('layouts.layout')
@section('breadcame')
    Role & Assign
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h2 class="pt-5">Role List</h2>
                </div>
                <div class="card-body">
                    @include('role.datatables.role-datatable')
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-5">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h2 class="pt-5 " id="add-header">Add Role And Permission</h2>
                </div>
                <div class="card-body">
                    @include('role.partials.add-role-permission')
                </div>
            </div>
        </div>
    </div>
@endsection

