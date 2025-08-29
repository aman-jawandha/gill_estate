@extends('admin_layout.app')
@section('content')
    <div class="d-flex align-items-center content-space-between pt-2 pb-4">
        <div style="width:95%">
            <h3 class="fw-bold">Edit Property</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fa fa-home"
                                style="color: #947054"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Properties</li>
                </ol>
            </nav>
        </div>
        @if($property->user_role == 'seller')
        <a href="{{ route('sellers-properties') }}" class="btn btn-primary btn-sm m-1">Back</a>
        @else
        <a href="{{ route('properties-list') }}" class="btn btn-primary btn-sm m-1">Back</a>
        @endif
    </div>
    <div class="card p-4">
        <form method="POST" action="{{ route('update-property') }}" id="property_form" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-12">
                    <input type="hidden" name="property_id" value="{{ $property->id }}">
                    <label class="form-label">Title</label>
                    <input type="text" class="form-control" name="title" id="title" value="{{ $property->title }}"
                        maxlength="250" required placeholder="Enter Title">
                </div>
                <div class="col-md-12">
                    <label class="form-label">Features</label>
                    <textarea class="form-control" rows="7" name="features" id="summernote" required maxlength="5000"
                        placeholder="Write About Proerty">{{ $property->features }}</textarea>
                </div>
                <div class="col-md-12">
                    <label class="form-label">Street</label>
                    <input type="text" class="form-control" name="street" id="street" value="{{ $property->street }}"
                        required maxlength="250" placeholder="Enter Street">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Country</label>
                    <select class="form-control" name="country" id="country" required>
                        <option value="" selected>Select Country</option>
                        @foreach ($countries as $country)
                            <option value="{{ $country->name }}" data-id="{{ $country->id }}"
                                {{ $property->country == $country->name ? 'selected' : '' }}>
                                {{ $country->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">State</label>
                    <select id="state" name="state" class="form-control" required>
                        @if ($property->state)
                            <option value="">Select State</option>
                            <option value="{{ $property->state }}" selected>{{ $property->state }}</option>
                        @else
                            <option value="" selected>Select State</option>
                        @endif
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">City</label>
                    <select id="city" name="city" class="form-control" required>
                        @if ($property->city)
                            <option value="">Select City</option>
                            <option value="{{ $property->city }}" selected>{{ $property->city }}</option>
                        @else
                            <option value="" selected>Select City</option>
                        @endif
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Zip Code</label>
                    <input type="text" class="form-control" value="{{ $property->zip_code }}" name="zip_code"
                        id="zip_code" required maxlength="6">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Property Type</label>
                    <select class="form-control" name="type" id="type" required>
                        <option value="" selected disabled>Select Property Type</option>
                        @foreach ($types as $type)
                            <option value="{{ $type->type }}" {{ $property->type == $type->type ? 'selected' : '' }}>
                                {{ $type->type }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Property Status</label>
                    <select class="form-control" name="status" id="status" required>
                        <option value="" selected disabled>Select Property Status</option>
                        @foreach ($statuses as $status)
                            <option value="{{ $status->status }}"
                                {{ $property->status == $status->status ? 'selected' : '' }}>{{ $status->status }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Furnished</label>
                    <select id="furnishing" name="furnishing" required class="form-control">
                        <option value="" selected disabled>Select An Option</option>
                        <option value="Fully Furnished"
                            {{ $property->furnishing == 'Fully Furnished' ? 'selected' : '' }}>Fully Furnished</option>
                        <option value="Semi Furnished"
                            {{ $property->furnishing == 'Semi Furnished' ? 'selected' : '' }}>Semi Furnished</option>
                        <option value="Non Furnished" {{ $property->furnishing == 'Non Furnished' ? 'selected' : '' }}>
                            Non Furnished</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Urgent Sell ?</label>
                    <select id="urgent_sell" name="urgent_sell" required class="form-control">
                        <option value="" selected disabled>Select An Option</option>
                        <option value="Yes" {{ $property->urgent_sell == 'Yes' ? 'selected' : '' }}>Yes</option>
                        <option value="No" {{ $property->urgent_sell == 'No' ? 'selected' : '' }}>No</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">No. Of Bed Rooms</label>
                    <select id="bed_rooms" name="bed_rooms" required class="form-control">
                        <option value="" selected disabled>Select A Number</option>
                        <option value="0" {{ $property->bed_rooms == '0' ? 'selected' : '' }}>0</option>
                        <option value="1" {{ $property->bed_rooms == '1' ? 'selected' : '' }}>1</option>
                        <option value="2" {{ $property->bed_rooms == '2' ? 'selected' : '' }}>2</option>
                        <option value="3" {{ $property->bed_rooms == '3' ? 'selected' : '' }}>3</option>
                        <option value="4" {{ $property->bed_rooms == '4' ? 'selected' : '' }}>4</option>
                        <option value="5+" {{ $property->bed_rooms == '5+' ? 'selected' : '' }}>5+</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">No. Of Bath Rooms</label>
                    <select id="bath_rooms" name="bath_rooms" required class="form-control">
                        <option value="" selected disabled>Select A Number</option>
                        <option value="0" {{ $property->bed_rooms == '0' ? 'selected' : '' }}>0</option>
                        <option value="1" {{ $property->bath_rooms == '1' ? 'selected' : '' }}>1</option>
                        <option value="2" {{ $property->bath_rooms == '2' ? 'selected' : '' }}>2</option>
                        <option value="3" {{ $property->bath_rooms == '3' ? 'selected' : '' }}>3</option>
                        <option value="4" {{ $property->bath_rooms == '4' ? 'selected' : '' }}>4</option>
                        <option value="5+" {{ $property->bath_rooms == '5+' ? 'selected' : '' }}>5+</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Price (CA$)</label>
                    <input type="number" class="form-control" step="0.01" value="{{ $property->price }}"
                        name="price" id="price" required min="1" max="10000000">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Built In Year</label>
                    <select name="built_year" class="form-control" id="built_year" required>
                        <option value="" selected disabled>Select Year</option>
                        @for ($i = date('Y'); $i >= 1800; $i--)
                            <option value="{{ $i }}" {{ $property->built_year == $i ? 'selected' : '' }}>
                                {{ $i }}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Area (in square feet)</label>
                    <input type="number" class="form-control" step="0.01" value="{{ $property->area }}"
                        name="area" id="area" required min="1" max="20000">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Floor No.</label>
                    <input type="number" class="form-control" name="floor_number"
                        value="{{ $property->floor_number }}" id="floor_number" required min="0" max="200">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Total Floors</label>
                    <input type="number" class="form-control" name="total_floors"
                        value="{{ $property->total_floors }}" id="total_floors" required min="0" max="200">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Latitude</label>
                    <input type="number" step="any" class="form-control" name="latitude" id="latitude"
                        value="{{ $property->latitude }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Longitude</label>
                    <input type="number" step="any" class="form-control" name="longitude" id="longitude"
                        value="{{ $property->longitude }}" required>
                </div>
                @if ($property->banner_image)
                    <div class="col-md-2 p-3">
                        <img src="{{ asset('uploads/properties/banner_images/' . $property->banner_image) }}"
                            alt="Image" width="100%">
                    </div>
                @endif
                <div class="col-md-6">
                    <label class="form-label">Update Banner Image</label>
                    <input type="file" class="form-control" name="banner_image" id="fileInput">
                    <span id="error-msg" style="color: red;"></span>
                </div>
                <div class="col-md-12">
                    <button class="btn btn-primary btn-sm mt-3" type="submit">Update</button>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('js')
    <script>
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

            if (file.size > maxSize) {
                errorMsg.textContent = 'Image must be less than 1MB.';
                isFileValid = false;
                return;
            }
        }

        document.getElementById('fileInput').addEventListener('change', function() {
            validateFileInput();
        });

        document.getElementById('property_form').addEventListener('submit', function(e) {
            validateFileInput();
            if (!isFileValid) {
                e.preventDefault();
            }
        });
    </script>
@endsection
