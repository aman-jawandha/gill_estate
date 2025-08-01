@extends('website_layout.app')
@section('content')
<section class="breadcumb-area bg-img"
        style="background-image: url('{{ asset('assets/img/bg-img/hero1.jpg') }}');height:200px">
    </section>
    <section class="south-editor-area d-flex align-items-center">
        <!-- Editor Content -->
        <div class="editor-content-area">
            <div class="contact-heading">
                        <h6>About Us</h6>
                    </div>
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
    <section class="call-to-action-area bg-fixed bg-overlay-black" style="background-image: url('{{ asset('assets/img/bg-img/cta.jpg') }}')">
        <div class="container h-100">
            <div class="row align-items-center h-100">
                <div class="col-12">
                    <div class="cta-content text-center">
                        <h2 class="wow fadeInUp" data-wow-delay="300ms">Are you looking for a place to rent?</h2>
                        <h6 class="wow fadeInUp" data-wow-delay="400ms">Suspendisse dictum enim sit amet libero malesuada feugiat.</h6>
                        <a href="#" class="btn south-btn mt-50 wow fadeInUp" data-wow-delay="500ms">Search</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="meet-the-team-area section-padding-100-0">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-heading">
                        <h2>Meet The Team</h2>
                        <p>Suspendisse dictum enim sit amet libero</p>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <!-- Single Team Member -->
                <div class="col-12 col-sm-6 col-lg-4">
                    <div class="single-team-member mb-100 wow fadeInUp" data-wow-delay="250ms">
                        <!-- Team Member Thumb -->
                        <div class="team-member-thumb">
                            <img src="{{asset('assets/img/bg-img/team1.jpg')}}" alt="">
                        </div>
                        <!-- Team Member Info -->
                        <div class="team-member-info">
                            <div class="section-heading">
                                <img src="{{asset('assets/img/icons/prize.png')}}" alt="">
                                <h2>Jeremy Scott</h2>
                                <p>Realtor</p>
                            </div>
                            <div class="address">
                                <h6><img src="{{asset('assets/img/icons/phone-call.png')}}" alt=""> +45 677 8993000 223</h6>
                                <h6><img src="{{asset('assets/img/icons/envelope.png')}}" alt=""> office@template.com</h6>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Single Team Member -->
                <div class="col-12 col-sm-6 col-lg-4">
                    <div class="single-team-member mb-100 wow fadeInUp" data-wow-delay="500ms">
                        <!-- Team Member Thumb -->
                        <div class="team-member-thumb">
                            <img src="{{asset('assets/img/bg-img/team2.jpg')}}" alt="">
                        </div>
                        <!-- Team Member Info -->
                        <div class="team-member-info">
                            <div class="section-heading">
                                <img src="{{asset('assets/img/icons/prize.png')}}" alt="">
                                <h2>Maria Williams</h2>
                                <p>Realtor</p>
                            </div>
                            <div class="address">
                                <h6><img src="{{asset('assets/img/icons/phone-call.png')}}" alt=""> +45 677 8993000 223</h6>
                                <h6><img src="{{asset('assets/img/icons/envelope.png')}}" alt=""> office@template.com</h6>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Single Team Member -->
                <div class="col-12 col-sm-6 col-lg-4">
                    <div class="single-team-member mb-100 wow fadeInUp" data-wow-delay="750ms">
                        <!-- Team Member Thumb -->
                        <div class="team-member-thumb">
                            <img src="{{asset('assets/img/bg-img/team3.jpg')}}" alt="">
                        </div>
                        <!-- Team Member Info -->
                        <div class="team-member-info">
                            <div class="section-heading">
                                <img src="{{asset('assets/img/icons/prize.png')}}" alt="">
                                <h2>Patrick Joe</h2>
                                <p>Realtor</p>
                            </div>
                            <div class="address">
                                <h6><img src="{{asset('assets/img/icons/phone-call.png')}}" alt=""> +45 677 8993000 223</h6>
                                <h6><img src="{{asset('assets/img/icons/envelope.png')}}" alt=""> office@template.com</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection