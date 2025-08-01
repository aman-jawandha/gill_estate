@extends('admin_layout.app')
@section('content')
<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
        <div>
            <h3 class="fw-bold">Dashboard</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('dashboard')}}"><i class="fa fa-home" style="color: #947054"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                </ol>
            </nav>
        </div>
    </div>
<div class="row">
    <div class="col-md-4">
            <div class="card card-secondary bg-secondary-gradient">
                <div class="card-body bubble-shadow">
                    <h5 class="op-8">Properties Sold</h5>
                    <h1>{{$sold_proprts}}</h1>
                    <div class="pull-right">
                        <h3 class="fw-bold op-8"></h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-secondary bg-secondary-gradient">
                <div class="card-body bubble-shadow">
                    <h5 class="op-8">Total Buyers</h5>
                    <h1>{{$buyers}}</h1>
                    <div class="pull-right">
                        <h3 class="fw-bold op-8"></h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-secondary bg-secondary-gradient">
                <div class="card-body bubble-shadow">
                    <h5 class="op-8">Total Sellers</h5>
                    <h1>{{$sellers}}</h1>
                    <div class="pull-right">
                        <h3 class="fw-bold op-8"></h3>
                    </div>
                </div>
            </div>
        </div>
</div>
@endsection