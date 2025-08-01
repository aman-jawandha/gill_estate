@extends('website_layout.app')
@section('content')
    <section class="breadcumb-area bg-img"
        style="background-image: url('{{ asset('assets/img/bg-img/hero1.jpg') }}');height:250px">
    </section>

    <div class="south-search-area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="advanced-search-form">
                        <!-- Search Title -->
                        <div class="search-title">
                            <p>SEARCH PROPERTIES</p>
                        </div>
                        <!-- Search Form -->
                        <form action="{{route('search-properties')}}" method="get">
                            <div class="row">
                                <div class="col-md-3">
                                    <select class="form-control" name="state" id="state">
                                        <option value="" selected>Select State</option>
                                        @foreach ($states as $state)
                                            <option value="{{ $state->name }}" data-code="{{ $state->code }}" {{ request('state') == $state->name ? 'selected' : '' }}>
                                                {{ $state->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <select id="city" name="city" class="form-control">
                                        @if(request('city'))
                                        <option value="">Select City</option>
                                        <option value="{{request('city')}}" selected>{{request('city')}}</option>
                                        @else
                                        <option value="" selected>Select City</option>
                                        @endif
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <select class="form-control" name="type" id="type">
                                        <option value="" selected>Property Type</option>
                                        @foreach ($types as $type)
                                            <option value="{{ $type->type }}" {{ request('type') == $type->type ? 'selected' : '' }}>{{ $type->type }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <select class="form-control" name="max_price" id="max_price">
                                        <option value="" selected>Price Range Below</option>
                                        <option value="200000" {{ request('max_price') == '200000' ? 'selected' : '' }}>$200,000</option>
                                        <option value="500000" {{ request('max_price') == '500000' ? 'selected' : '' }}>$500,000</option>
                                        <option value="1000000" {{ request('max_price') == '1000000' ? 'selected' : '' }}>$1,000,000</option>
                                        <option value="2000000" {{ request('max_price') == '2000000' ? 'selected' : '' }}>$2,000,000</option>
                                        <option value="5000000" {{ request('max_price') == '5000000' ? 'selected' : '' }}>$5,000,000</option>
                                        <option value="5000000+" {{ request('max_price') == '5000000+' ? 'selected' : '' }}>$5,000,000 +</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <select class="form-control" name="order_by" id="order_by">
                                        <option value="" selected>Order By</option>
                                        <option value="high_to_low" {{ request('order_by') == 'high_to_low' ? 'selected' : '' }}>High To Low</option>
                                        <option value="low_to_high" {{ request('order_by') == 'low_to_high' ? 'selected' : '' }}>Low To High</option>
                                        <option value="latest" {{ request('order_by') == 'latest' ? 'selected' : '' }}>Latest</option>
                                    </select>
                                </div>
                                <div class="col-md-10 text-right">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Search</button>
                                    <a href="{{route('properties')}}" class="btn btn-primary"><i class="fa fa-ban"></i> Reset</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="listings-content-wrapper section-padding-50">
        <div class="container">
            {{-- <div class="row">
                <div class="col-12">
                    <div class="listings-top-meta d-flex justify-content-between mb-100">
                        <div class="view-area d-flex align-items-center">
                            <span>View as:</span>
                            <div class="grid_view ml-15"><a href="#" class="active"><i class="fa fa-th" aria-hidden="true"></i></a></div>
                            <div class="list_view ml-15"><a href="#"><i class="fa fa-th-list" aria-hidden="true"></i></a></div>
                        </div>
                        <div class="order-by-area d-flex align-items-center">
                            <span class="mr-15">Order by:</span>
                            <select>
                              <option selected>Default</option>
                              <option value="1">Newest</option>
                              <option value="2">Sales</option>
                              <option value="3">Ratings</option>
                              <option value="3">Popularity</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div> --}}

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
                                        sq ft</p>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="text-end">
                {{ $properties->links() }}
            </div>
        </div>
    </section>
@endsection
