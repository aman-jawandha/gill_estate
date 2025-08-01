@extends('website_layout.app')
@section('content')
    <section class="breadcumb-area bg-img"
        style="background-image: url('{{ asset('assets/img/bg-img/hero1.jpg') }}');height:200px">
    </section>
    <section class="south-contact-area section-padding-25">
        <div class="container-fluid p-4 p-md-5">
            <div class="row">
                <div class="col-12">
                    <div class="contact-heading" style="margin-bottom: 20px">
                        <h6><a href="{{ route('dashboard') }}"><i class="fa fa-home"></i></a> / <a>Shortlisted Properties</a></h6>
                    </div>
                </div>
            </div>
            @include('website_layout.common')
            @if($properties->count() > 0)
            <h3 class="mb-2 mt-4">Shortlisted Properties</h3>
            <div class="row">
                @foreach ($properties as $property)
                    <div class="col-12 col-md-6 col-xl-4">
                        <div class="single-featured-property mb-50 wow fadeInUp" data-wow-delay="100ms">
                            <div class="property-thumb">
                                <img src="{{ asset('uploads/properties/banner_images/' . $property->banner_image) }}"
                                    alt="Image">
                                <div class="tag">
                                    <span>{{ $property->status }}</span>
                                </div>
                                @if ($property->urgent_sell == 'Yes')
                                    <span class="badge badge-danger position-absolute top-0 start-0 m-2 text-white"
                                        style="z-index: 10;">
                                        <i class="fa fa-bolt me-1"></i> Urgent Sale
                                    </span>
                                @endif
                                <div class="list-price">
                                    <p>CA$ {{ number_format($property->price) }}</p>
                                </div>
                            </div>
                            <a href="{{ route('property-detail', $property->id) }}">
                                <div class="property-content">
                                    <h5>{{ $property->title }}</h5>
                                    <p class="location"><i class="fa fa-map-marker"></i> {{ $property->street }},
                                        {{ $property->city }}, {{ $property->state }}, {{ $property->zip_code }}</p>
                                    <p style="margin-bottom: 0px">Property Type - {{ $property->type }}</p>
                                    <p style="margin-bottom: 0px"><i class="fa fa-bed"></i> {{ $property->bed_rooms }} |
                                        <i class="fa fa-shower"></i> {{ $property->bath_rooms }} | {{ $property->area }}
                                        sq ft
                                    </p>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="text-end">
                {{ $properties->links() }}
            </div>
            @else
            <p>No Data Found!</p>
            @endif
        </div>
    </section>
@endsection
