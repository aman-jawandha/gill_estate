@extends('admin_layout.app')
@section('content')
    <div class="row mb-3">
        <div class="col-md-6">
            <h3 class="fw-bold">View Property</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fa fa-home"
                                style="color: #947054"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Properties</li>
                </ol>
            </nav>
        </div>
        <div class="col-md-6 text-end pt-3">
            @can('edit-property')
                <a href="{{ route('edit-seller-property', $property->id) }}" class="btn btn-success btn-sm"><i
                        class="fa fa-edit"></i></a>
            @endcan
            @can('delete-property')
                <button class="btn btn-danger btn-sm"
                    onclick="confirmDelete('{{ route('delete-property', $property->id) }}', 'Property')"><i
                        class="fa fa-trash"></i></button>
            @endcan
                @if ($property->user_role == 'seller')
                    @if ($property->status == 'Rejected')
                        <button class="btn btn-dark btn-sm" data-reason="{{ $property->reason }}"
                            onclick="$('#view_reason_modal').modal('show')">Rejected Reason</button>
                    @else
                        @can('reject-property')
                            <button class="btn btn-danger btn-sm" onclick="reject_property('{{ $property->id }}')">Reject
                                Property</button>
                        @endcan
                    @endif
                @endif
            @if ($property->user_role == 'seller')
                <a href="{{ route('sellers-properties') }}" class="btn btn-primary btn-sm">Back</a>
            @else
                <a href="{{ route('properties-list') }}" class="btn btn-primary btn-sm">Back</a>
            @endif
        </div>
    </div>
    <div class="card">
        <div class="row">
            <div class="col-md-6">
                <div class="property_content m-4">
                    <div class="row">
                        <div class="col-6">
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
                        <div class="col-6">
                            <h6 style="text-align:end"><b>CA$ {{ number_format($property->price) }}</b></h6>
                        </div>
                    </div>
                    <h4>{{ $property->title }}</h4>
                    <h6 style="color: #947054"><b><i class="fa fa-map-marker"></i> {{ $property->street }},
                            {{ $property->city }}, {{ $property->state }}, {{ $property->zip_code }}</b></h6>
                    <h6>Bedrooms - {{ $property->bed_rooms }} | Bathrooms - {{ $property->bath_rooms }}</h6>
                    <h6>Floor No. - {{ $property->floor_number ?? 'N\A' }} | Total Floors -
                        {{ $property->total_floors ?? 'N\A' }}</h6>
                    <h6>Area - {{ $property->area }} sq ft</h6>
                    <h6>Property Type - {{ $property->type }}</h6>
                    <h6>Furnishing - {{ $property->furnishing }}</h6>
                    <h6>Built In Year - {{ $property->built_year }}</h6>
                    <h6>Added By - {{ $property->user->name }}</h6>
                    <h6>Published At -
                        {{ $property->published_at ? date('d-m-Y | h:i a', strtotime($property->published_at)) : 'N\A' }}
                    </h6>
                </div>
            </div>
            <div class="col-md-6">
                <div class="position-relative m-4">
                    @if ($property->urgent_sell == 'Yes')
                        <span class="badge badge-danger position-absolute top-0 start-0 m-2" style="z-index: 10;">
                            <i class="fa fa-bolt me-1"></i> Urgent Sale
                        </span>
                    @endif
                    <div class="banner_img">
                        <a href="{{ asset('uploads/properties/banner_images/' . $property->banner_image) }}"
                            target="_blank"><img
                                src="{{ asset('uploads/properties/banner_images/' . $property->banner_image) }}"
                                alt="Image" width="100%"></a>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="m-4">
                    <h4>Features</h4>
                    {!! $property->features !!}
                </div>
            </div>
        </div>
    </div>
    <div class="card p-4">
        <h1 class="text-center mt-4 mb-4">Gallery</h1>
        <div class="text-end">
            @can('add-property-media')
                <button type="button" onclick="store_images()" class="btn btn-primary btn-sm">Add
                    Images</button>
                <button type="button" onclick="$('#video_id').val('');$('#add_video_modal').modal('show')"
                    class="btn btn-primary btn-sm">Add
                    Video</button>
            @endcan
        </div>
        @if ($images->count() > 0)
            <h4>Images</h4>
            <div class="row">
                @foreach ($images as $image)
                    <div class="col-md-4">
                        <div class="position-relative mt-2 mb-2">
                            <div class="position-absolute top-0 end-0" style="z-index: 10;">
                                @can('add-property-media')
                                    <button type="button" onclick="update_image('{{ $image->id }}')"
                                        class="btn btn-success btn-sm"><i class="fa fa-edit"></i></button>
                                @endcan
                                @can('delete-property-media')
                                    <button class="btn btn-danger btn-sm"
                                        onclick="confirmDelete('{{ route('delete-property-media', $image->id) }}', 'Image')"><i
                                            class="fa fa-trash"></i></button>
                                @endcan
                            </div>
                            <a href="{{ asset('uploads/properties/images/' . $image->file) }}" target="_blank"><img
                                    src="{{ asset('uploads/properties/images/' . $image->file) }}" alt="Image"
                                    width="100%"></a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
        <br><br>
        @if ($videos->count() > 0)
            <h4>Videos</h4>
            <div class="row">
                @foreach ($videos as $video)
                    <div class="col-md-4 text-center">
                        <div class="border p-2">
                            <div class="text-end mb-4">
                                @can('add-property-media')
                                    <button type="button"
                                        onclick="$('#video_id').val('{{ $video->id }}');$('#add_video_modal').modal('show')"
                                        class="btn btn-success btn-sm"><i class="fa fa-edit"></i></button>
                                @endcan
                                @can('delete-property-media')
                                    <button class="btn btn-danger btn-sm"
                                        onclick="confirmDelete('{{ route('delete-property-media', $video->id) }}', 'Video')"><i
                                            class="fa fa-trash"></i></button>
                                @endcan
                            </div>
                            <a href="{{ asset('uploads/properties/videos/' . $video->file) }}" target="_blank"><img
                                    width="100px" src="{{ asset('assets/img/video_img.png') }}" alt="Video"></a>
                            <br>
                            <p class="text-center mt-2">{{ $video->file }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Modal -->
    <div class="modal fade" id="add_images_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Upload Images</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        onclick="$('#add_images_modal').modal('hide')">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('store-property-images') }}" id="property_images_form" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="property_id" value="{{ $property->id }}">
                        <input type="hidden" name="image_id" id="image_id">
                        <div class="images_form_html"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="Submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="add_video_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Upload Video</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        onclick="$('#add_video_modal').modal('hide')">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('store-property-video') }}" id="property_video_form" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="property_id" value="{{ $property->id }}">
                        <input type="hidden" name="video_id" id="video_id">
                        <label class="form-label">Upload Video</label>
                        <input type="file" class="form-control" name="video" id="VideoInput" required>
                        <span id="video-error-msg" style="color: red;"></span>
                    </div>
                    <div class="modal-footer">
                        <button type="Submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="change_status_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Reject Property</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        onclick="$('#change_status_modal').modal('hide')">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('reject-property') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="seller_property_id" value="{{ $property->id }}">
                        <label class="form-label">Reason</label>
                        <textarea rows="5" class="form-control" placeholder="Write Something" name="reason" id="reason"
                            maxlength="1000" required></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="Submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="view_reason_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Rejected Reason</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        onclick="$('#view_reason_modal').modal('hide')">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {!! nl2br(e($property->reason)) !!}
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        function store_images() {
            var html = `
            <p class="text-danger">Maximum 5 Images can be upoaded at a time.</p>
            <label class="form-label">Upload Images</label>
            <input type="file" class="form-control" id="fileInput" name="images[]" required multiple>
            <span id="error-msg" style="color: red;"></span>`;
            $('#image_id').val('');
            $('.images_form_html').html(html);
            $('#add_images_modal').modal('show');
        }

        function update_image($image_id) {
            var html = `
            <label class="form-label">Upload Image</label>
            <input type="file" class="form-control" id="fileInput" name="image" required>
            <span id="error-msg" style="color: red;"></span>`;
            $('#image_id').val($image_id);
            $('.images_form_html').html(html);
            $('#add_images_modal').modal('show');
        }

        let isFileValid = true;

        function validateFileInput() {
            const fileInput = document.getElementById('fileInput');
            const file = fileInput.files[0];
            const errorMsg = document.getElementById('error-msg');
            errorMsg.textContent = '';
            isFileValid = true;

            if (!file) {
                return;
            }

            const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
            const maxSize = 1 * 1024 * 1024;

            if (!allowedTypes.includes(file.type)) {
                errorMsg.textContent = 'Allowed file types are jpg, jpeg, png and webp.';
                isFileValid = false;
                return;
            }

            if (file.size >= maxSize) {
                errorMsg.textContent = 'Each image must be less than or equals to 1MB.';
                isFileValid = false;
                return;
            }
        }

        $(document).on("change", "#fileInput", function() {
            validateFileInput();
        });

        $(document).on("submit", "#property_images_form", function(e) {
            validateFileInput();
            if (!isFileValid) {
                e.preventDefault();
            }
        });


        let isVideoValid = true;

        function validateVideoInput() {
            const fileInput = document.getElementById('VideoInput');
            const file = fileInput.files[0];
            const errorMsg = document.getElementById('video-error-msg');
            errorMsg.textContent = '';
            isVideoValid = true;

            if (!file) {
                return;
            }

            const allowedTypes = ['video/mp4'];
            const maxSize = 5 * 1024 * 1024;

            if (!allowedTypes.includes(file.type)) {
                errorMsg.textContent = 'File type should be mp4.';
                isVideoValid = false;
                return;
            }

            if (file.size >= maxSize) {
                errorMsg.textContent = 'Video must be less than or equals to 5MB.';
                isVideoValid = false;
                return;
            }
        }

        $(document).on("change", "#VideoInput", function() {
            validateVideoInput();
        });

        $(document).on("change", "#property_video_form", function(e) {
            validateVideoInput();
            if (!isVideoValid) {
                e.preventDefault();
            }
        });
    </script>
@endsection
