@extends('website_layout.app')
@section('content')
<section class="breadcumb-area bg-img" style="background-image: url('{{ asset('assets/img/bg-img/hero1.jpg') }}');height:200px">
    </section>
    <section class="south-contact-area section-padding-50">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="contact-heading">
                        <h6><a href="{{route('dashboard')}}"><i class="fa fa-home"></i></a> / <a>Dashboard</a></h6>
                    </div>
                </div>
            </div>
            @include('website_layout.common')
            <div class="row">
                <h5>Welcome to the dashboard {{auth()->user()->name}}.</h5>
            </div>
        </div>
    </section>
@endsection