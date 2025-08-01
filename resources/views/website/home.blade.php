@extends('website_layout.app')
@section('content')
    <section class="hero-area">
        <div class="hero-slides owl-carousel">
            <!-- Single Hero Slide -->
            <div class="single-hero-slide bg-img" style="background-image: url('{{ asset('assets/img/bg-img/hero2.jpg') }}')">
                <div class="container h-100">
                    <div class="row h-100 align-items-center">
                        <div class="col-md-2"></div>
                        <div class="col-md-8 text-center">
                            <div class="hero-slides-content">
                                <h2 class="text-white mb-4">Your Dream House Is Just a Click Away</h2>
                                <a href="{{route('sell-property')}}" class="btn south-btn m-1">Sell A Property</a><a href="{{route('properties')}}" class="btn south-btn m-1" style="background-color: black;border:2px solid #947054">View Properties</a><a href="{{route('find-property')}}" class="btn south-btn m-1">Find A Property</a>
                            </div>
                        </div>
                        <div class="col-md-2"></div>
                    </div>
                </div>
            </div>
            <!-- Single Hero Slide -->
            <div class="single-hero-slide bg-img"
                style="background-image: url('{{ asset('assets/img/bg-img/hero3.jpg') }}')">
                <div class="container h-100">
                    <div class="row h-100 align-items-center">
                        <div class="col-md-2"></div>
                        <div class="col-md-8 text-center">
                            <div class="hero-slides-content">
                                <h2 class="text-white mb-4">Discover the Best Properties Near You</h2>
                                <a href="{{route('sell-property')}}" class="btn south-btn m-1">Sell A Property</a><a href="{{route('properties')}}" class="btn south-btn m-1" style="background-color: black;border:2px solid #947054">View Properties</a><a href="{{route('find-property')}}" class="btn south-btn m-1">Find A Property</a>
                            </div>
                        </div>
                        <div class="col-md-2"></div>
                    </div>
                </div>
            </div>
            <!-- Single Hero Slide -->
            <div class="single-hero-slide bg-img"
                style="background-image: url('{{ asset('assets/img/bg-img/hero4.jpg') }}')">
                <div class="container h-100">
                    <div class="row h-100 align-items-center">
                        <div class="col-md-2"></div>
                        <div class="col-md-8 text-center">
                            <div class="hero-slides-content">
                                <h2 class="text-white mb-4">Find Your Perfect Home Today</h2>
                                <a href="{{route('sell-property')}}" class="btn south-btn m-1">Sell A Property</a><a href="{{route('properties')}}" class="btn south-btn m-1" style="background-color: black;border:2px solid #947054">View Properties</a><a href="{{route('find-property')}}" class="btn south-btn m-1">Find A Property</a>
                            </div>
                        </div>
                        <div class="col-md-2"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ##### Hero Area End ##### -->

    <!-- ##### Featured Properties Area Start ##### -->
    <section class="featured-properties-area section-padding-100-50">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-heading wow fadeInUp">
                        <h2>New Arrivals</h2>
                        <p>Checkout Our Latest Properties</p>
                    </div>
                </div>
            </div>

            <div class="row">
                @foreach ($properties as $property)
                    <div class="col-12 col-md-6 col-xl-4">
                    <div class="single-featured-property mb-50 wow fadeInUp" data-wow-delay="100ms">
                        <div class="property-thumb">
                            <img src="{{ asset('uploads/properties/banner_images/'.$property->banner_image) }}" alt="Image">
                            <div class="tag">
                                <span>{{$property->status}}</span>
                            </div>
                            @if ($property->urgent_sell == 'Yes')
                                <span class="badge badge-danger position-absolute top-0 start-0 m-2 text-white"
                                    style="z-index: 10;">
                                    <i class="fa fa-bolt me-1"></i> Urgent Sale
                                </span>
                            @endif
                            <div class="list-price">
                                <p>CA$ {{number_format($property->price)}}</p>
                            </div>
                        </div>
                        <a href="{{route('property-detail',$property->id)}}">
                        <div class="property-content">
                            <h5>{{$property->title}}</h5>
                            <p class="location"><i class="fa fa-map-marker"></i> {{$property->street}}, {{$property->city}}, {{$property->state}}, {{$property->zip_code}}</p>
                            <p style="margin-bottom: 0px">Property Type - {{$property->type}}</p>
                            <p style="margin-bottom: 0px"><i class="fa fa-bed"></i> {{$property->bed_rooms}} | <i class="fa fa-shower"></i> {{$property->bath_rooms}} | {{$property->area}} sq ft</p>
                        </div></a>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="text-center">
                    <a href="{{route('properties')}}" class="btn south-btn">View All</a>
                </div>
        </div>
    </section>

    <section class="south-editor-area d-flex align-items-center">
        <!-- Editor Content -->
        <div class="editor-content-area">
            <!-- Section Heading -->
            <div class="section-heading wow fadeInUp" data-wow-delay="250ms">
                <img src="{{ asset('assets/img/icons/prize.png') }}" alt="">
                <h2>jeremy Scott</h2>
                <p>Realtor (5 Years Experience)</p>
            </div>
            <p class="wow fadeInUp" data-wow-delay="500ms">Etiam nec odio vestibulum est mattis effic iturut magna.
                Pellentesque sit amet tellus blandit. Etiam nec odiomattis effic iturut magna. Pellentesque sit am et tellus
                blandit. Etiam nec odio vestibul. Etiam nec odio vestibulum est mat tis effic iturut magna. Curabitur
                rhoncus auctor eleifend. Fusce venenatis diam urna, eu pharetra arcu varius ac. Etiam cursus turpis lectus,
                id iaculis risus tempor id. Phasellus fringilla nisl sed sem scelerisque, eget aliquam magna vehicula.</p>
            <div class="address wow fadeInUp" data-wow-delay="750ms">
                <h6><img src="{{ asset('assets/img/icons/phone-call.png') }}" alt=""> +45 677 8993000 223</h6>
                <h6><img src="{{ asset('assets/img/icons/envelope.png') }}" alt=""> office@template.com</h6>
            </div>
            <div class="signature mt-50 wow fadeInUp" data-wow-delay="1000ms">
                <img src="{{ asset('assets/img/core-img/signature.png') }}" alt="">
            </div>
        </div>

        <!-- Editor Thumbnail -->
        <div class="editor-thumbnail">
            <img src="{{ asset('assets/img/bg-img/editor.jpg') }}" alt="">
        </div>
    </section>
    <!-- ##### Call To Action Area End ##### -->
<section class="call-to-action-area bg-fixed bg-overlay-black"
        style="background-image: url('{{ asset('assets/img/bg-img/cta.jpg') }}')">
        <div class="container h-100">
            <div class="row align-items-center h-100">
                <div class="col-12">
                    <div class="cta-content text-center">
                        <h2 class="wow fadeInUp" data-wow-delay="300ms">Are you looking for a place to rent?</h2>
                        <h6 class="wow fadeInUp" data-wow-delay="400ms">Suspendisse dictum enim sit amet libero malesuada
                            feugiat.</h6>
                        <a href="#" class="btn south-btn mt-50 wow fadeInUp" data-wow-delay="500ms">Search</a>
                    </div>
                </div>
            </div>
        </div>
    </section>    
    <div style="width:100%;height:20px;background-color:white"></div>
    <section class="south-testimonials-area" id="testimonials" style="background-color:#947054;padding-top:50px;overflow:hidden">
        <h2 class="text-center"><span style="color:white">Trusted By Families</span></h2>
    <script src="https://static.elfsight.com/platform/platform.js" async></script>
    <div class="elfsight-app-edf97fa3-4a98-442d-a1a0-023db7a19321" data-elfsight-app-lazy></div>
</section><!-- /Testimonials Section -->
<div style="width:100%;height:50px;background-color:#947054"></div>
<section class="south-testimonials-area section-padding-100">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-heading wow fadeInUp" data-wow-delay="250ms">
                        <h2>Frequently Asked Questions</h2>
                    </div>
                    <div id="accordion">
                        @foreach ($faqs as $key => $faq)
                            <div class="card mb-3">
                                <div class="card-header bg-white" id="heading_{{ $key }}">
                                    <h5 class="mb-0 d-flex justify-content-between align-items-center">
                                        <button class="btn btn-link collapsed d-flex justify-content-between w-100"
                                            data-toggle="collapse" style="text-decoration: none;color:black" data-target="#collapse_{{ $key }}"
                                            aria-expanded="false" aria-controls="collapse_{{ $key }}">
                                            <span><b>{{ $faq->question }}</b></span>
                                            <span><b class="toggle-icon">+</b></span>
                                        </button>
                                    </h5>
                                </div>
                                <div id="collapse_{{ $key }}" class="collapse"
                                    aria-labelledby="heading_{{ $key }}" data-parent="#accordion">
                                    <div class="card-body">
                                        {!! nl2br(e($faq->answer)) !!}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection
