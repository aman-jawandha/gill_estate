@extends('website_layout.app')
<style>
    .features_div ol li {
        list-style: decimal !important;
        margin-left: 1.5em !important;
    }

    .features_div ul li {
        list-style: disc !important;
        margin-left: 1.5em !important;
    }
</style>
@section('content')
    <section class="breadcumb-area bg-img"
        style="background-image: url('{{ asset('assets/img/bg-img/hero1.jpg') }}');height:200px">
    </section>
    <section class="south-contact-area section-padding-25">
        <div class="container-fluid p-4 p-md-5">
            <div class="row">
                <div class="col-12">
                    <div class="contact-heading" style="margin-bottom: 20px">
                        <h6><a href="{{ route('dashboard') }}"><i class="fa fa-home"></i></a> / <a
                                href="{{ route('properties') }}">Properties</a> / <a>Property Details</a></h6>
                    </div>
                </div>
            </div>
            @include('website_layout.common')
            <div class="row">
                <div class="col-md-9">
                    <h3>{{ $property->title }}</h3>
                    <p style="color: #947054"><b><i class="fa fa-map-marker"></i> {{ $property->street }},
                            {{ $property->city }}, {{ $property->state }}, {{ $property->zip_code }}</b></p>
                    @if ($property->urgent_sell == 'Yes')
                        <span class="badge badge-danger"><i class="fa fa-bolt me-1"></i> Urgent Sale</span>
                    @endif
                    <span class="badge badge-success">{{ $property->furnishing }}</span>
                    @if ($property->status == 'Pending')
                        <span class="badge badge-warning">{{ $property->status }}</span>
                    @elseif($property->status == 'Inactive' || $property->status == 'Rejected')
                        <span class="badge badge-danger">{{ $property->status }}</span>
                    @elseif($property->status == 'For Sale' || $property->status == 'For Rent')
                        <span class="badge badge-success">{{ $property->status }}</span>
                    @elseif($property->status == 'Sold' || $property->status == 'Rented')
                        <span class="badge badge-primary">{{ $property->status }}</span>
                    @endif
                </div>
                <div class="col-md-3 text-right">
                    @if (auth()->user() && auth()->user()->role == 'buyer')
                        @php
                            $favouriteIds = explode(',', auth()->user()->favourites ?? '');
                        @endphp
                        <button
                            class="btn btn-light fav-btn mb-2 {{ in_array($property->id, $favouriteIds) ? 'shortlisted' : '' }}"
                            data-id="{{ $property->id }}">
                            <i class="fa fa-heart text-danger"></i> &nbsp;
                            <span class="fav-text">
                                {{ in_array($property->id, $favouriteIds) ? 'Shortlisted' : 'Shortlist' }}
                            </span>
                        </button>
                    @endif
                    <h3>Price : CA$ {{ number_format($property->price) }}</h3>
                </div>
            </div><br>
            <div class="row">
                <div class="col-md-6 p-1">
                    <div class="position-relative">
                        <div class="btn-group position-absolute m-2" style="z-index: 10;bottom:0;right:0">
                            <a href="https://www.google.com/maps/search/?api=1&query={{ $property->latitude }},{{ $property->longitude }}"
                                target="_blank">
                                <button class="btn btn-light btn-sm m-1"><i class="fa fa-map-marker"></i> Location</button>
                            </a>

                            <a href="https://www.google.com/maps/dir/?api=1&destination={{ $property->latitude }},{{ $property->longitude }}"
                                target="_blank">
                                <button class="btn btn-light btn-sm m-1"><i class="fa fa-location-arrow"></i>
                                    Directions</button>
                            </a>

                            <a href="https://www.google.com/maps/@?api=1&map_action=pano&viewpoint={{ $property->latitude }},{{ $property->longitude }}"
                                target="_blank">
                                <button class="btn btn-light btn-sm m-1"><i class="fa fa-street-view"></i> Street
                                    View</button>
                            </a>
                            <button class="btn btn-light btn-sm m-1" onclick="$('#carouselPhotosModal').modal('show')"><i
                                    class="fa fa-photo"></i>
                                {{ $images->count() }}
                                Photos</button>
                        </div>
                        <div class="banner_img">
                            <a href="{{ asset('uploads/properties/banner_images/' . $property->banner_image) }}"
                                target="_blank"><img
                                    src="{{ asset('uploads/properties/banner_images/' . $property->banner_image) }}"
                                    alt="Image" width="100%"></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        @foreach ($images->take(4) as $image)
                            <div class="col-md-6 p-1">
                                <a href="{{ asset('uploads/properties/images/' . $image->file) }}" target="_blank"><img
                                        src="{{ asset('uploads/properties/images/' . $image->file) }}" alt="Image"
                                        width="100%"></a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="bg-light mt-4 mb-2 p-3">
                <h4>Overview</h4>
                <hr>
                <div class="row">
                    <div class="col-md-1 text-center">
                        <p style="margin-bottom: 0px">Bedroom<br><i class="fa fa-bed"></i> {{ $property->bed_rooms }}</p>
                    </div>
                    <div class="col-md-2 text-center">
                        <p style="margin-bottom: 0px">Property Type<br><b>{{ $property->type }}</b></p>
                    </div>
                    <div class="col-md-1 text-center">
                        <p style="margin-bottom: 0px">Bathroom<br><i class="fa fa-shower"></i> {{ $property->bath_rooms }}
                        </p>
                    </div>
                    <div class="col-md-1 text-center">
                        <p style="margin-bottom: 0px">Area<br>{{ $property->area }} sq ft</p>
                    </div>
                    <div class="col-md-2 text-center">
                        <p style="margin-bottom: 0px">Total Floors<br><i class="fa fa-building"></i>
                            {{ $property->total_floors ?? 'N\A' }}</p>
                    </div>
                    <div class="col-md-1 text-center">
                        <p style="margin-bottom: 0px">Built In<br><i class="fa fa-calendar"></i>
                            {{ $property->built_year }}
                        </p>
                    </div>
                    <div class="col-md-2 text-center">
                        <p style="margin-bottom: 0px">Floor No.<br><i class="fa fa-home"></i>
                            {{ $property->floor_number ?? 'N\A' }}</p>
                    </div>
                    <div class="col-md-2 text-center">
                        <p style="margin-bottom: 0px">Published At<br><i class="fa fa-calendar"></i>
                            {{ ($property->published_at) ? date('d-m-Y | h:i a', strtotime($property->published_at)) : 'N\A' }}</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8">
                    <div class="bg-light mt-4 mb-4 p-3">
                        <h4>Features</h4>
                        <hr>
                        <div class="features_div">
                            {!! $property->features !!}
                        </div>
                    </div>
                    <div class="bg-light mt-4 mb-4 p-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <h4>Videos</h4>
                            <button class="btn btn-dark btn-sm"><i class="fa fa-video-camera"></i> &nbsp;
                                {{ $videos->count() }} Videos</button>
                        </div>
                        <hr>
                        <div class="row">
                            <!-- Carousel wrapper -->
                            <div id="carouselVideoExample" data-mdb-carousel-init class="carousel slide carousel-fade"
                                data-mdb-ride="carousel">
                                <div class="carousel-inner">
                                    @foreach ($videos as $key => $video)
                                        <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                            <a href="{{ asset('uploads/properties/videos/' . $video->file) }}"
                                                target="_blank"><video class="img-fluid" controls autoplay loop muted>
                                                    <source src="{{ asset('uploads/properties/videos/' . $video->file) }}"
                                                        type="video/mp4" /></a>
                                            </video>
                                        </div>
                                    @endforeach
                                </div>
                                <a class="carousel-control-prev" href="#carouselVideoExample" role="button"
                                    data-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                </a>
                                <a class="carousel-control-next" href="#carouselVideoExample" role="button"
                                    data-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="bg-light mt-4 mb-4 p-3">
                        <iframe src="https://calendly.com/amandeep00988/30min" width="100%" height="650"
                            frameborder="0"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade" id="carouselPhotosModal" tabindex="-1" role="dialog" style="z-index: 1055;"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div id="carouselPhotos" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            @foreach ($images as $index => $image)
                                <div class="carousel-item @if ($index == 0) active @endif">
                                    <a href="{{ asset('uploads/properties/images/' . $image->file) }}"
                                        target="_blank"><img
                                            src="{{ asset('uploads/properties/images/' . $image->file) }}" alt="Image"
                                            width="100%"></a>
                                </div>
                            @endforeach
                        </div>
                        <a class="carousel-control-prev" href="#carouselPhotos" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        </a>
                        <a class="carousel-control-next" href="#carouselPhotos" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        $(document).on('click', '.fav-btn', function() {
            let button = $(this);
            let propertyId = button.data('id');
            let textSpan = button.find('.fav-text');

            $.ajax({
                url: "{{ route('favourite-property') }}",
                method: 'get',
                data: {
                    property_id: propertyId
                },
                success: function(response) {
                    if (textSpan.text().trim() === 'Shortlist') {
                        textSpan.text('Shortlisted');
                    } else {
                        textSpan.text('Shortlist');
                    }
                },
                error: function() {
                    alert('Something went wrong.');
                }
            });
        });
    </script>
@endsection
