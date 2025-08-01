@extends('admin_layout.app')
@section('content')
    <div class="d-flex align-items-center content-space-between pt-2 pb-4">
        <div style="width:95%">
            <h3 class="fw-bold">Create Property</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fa fa-home"
                                style="color: #947054"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Properties</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('properties-list') }}" class="btn btn-primary btn-sm">Back</a>
    </div>
    <div class="card p-4">
        <form method="POST" action="{{ route('store-property') }}" id="property_form" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-12">
                    <label class="form-label">Title</label>
                    <input type="text" class="form-control" name="title" id="title" maxlength="250" required
                        placeholder="Enter Title">
                </div>
                <div class="col-md-12">
                    <label class="form-label">Features</label>
                    <textarea class="form-control" rows="7" name="features" id="summernote" required maxlength="5000"
                        placeholder="Write About Proerty"></textarea>
                </div>
                <div class="col-md-12">
                    <label class="form-label">Street</label>
                    <input type="text" class="form-control" name="street" id="street" required maxlength="250"
                        placeholder="Enter Street">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Country</label>
                    <input type="text" class="form-control" name="country" id="country" required value="Canada"
                        readonly>
                </div>
                <div class="col-md-3">
                    <label class="form-label">State</label>
                    <select class="form-control" name="state" id="state" required>
                        <option value="" selected disabled>Select State</option>
                        @foreach ($states as $state)
                            <option value="{{ $state->name }}" data-code="{{ $state->code }}">{{ $state->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">City Or Neighborhoods</label>
                    <select id="city" name="city" required class="form-control">
                        <option value="" selected disabled>Select City</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Zip Code</label>
                    <input type="text" class="form-control" name="zip_code" id="zip_code" required maxlength="6">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Property Type</label>
                    <select class="form-control" name="type" id="type" required>
                        <option value="" selected disabled>Select Property Type</option>
                        @foreach ($types as $type)
                            <option value="{{ $type->type }}">{{ $type->type }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Property Status</label>
                    <select class="form-control" name="status" id="status" required>
                        <option value="" selected disabled>Select Property Status</option>
                        @foreach ($statuses as $status)
                            <option value="{{ $status->status }}">{{ $status->status }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Furnished</label>
                    <select id="furnishing" name="furnishing" required class="form-control">
                        <option value="" selected disabled>Select An Option</option>
                        <option value="Fully Furnished">Fully Furnished</option>
                        <option value="Semi Furnished">Semi Furnished</option>
                        <option value="Non Furnished">Non Furnished</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Urgent Sell ?</label>
                    <select id="urgent_sell" name="urgent_sell" required class="form-control">
                        <option value="" selected disabled>Select An Option</option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">No. Of Bed Rooms</label>
                    <select id="bed_rooms" name="bed_rooms" required class="form-control">
                        <option value="" selected disabled>Select A Number</option>
                        <option value="0">0</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5+">5+</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">No. Of Bath Rooms</label>
                    <select id="bath_rooms" name="bath_rooms" required class="form-control">
                        <option value="" selected disabled>Select A Number</option>
                        <option value="0">0</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5+">5+</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Price (CA$)</label>
                    <input type="number" class="form-control" step="0.01" name="price" id="price" required
                        min="1" max="10000000">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Built In Year</label>
                    <select name="built_year" class="form-control" id="built_year" required>
                        <option value="" selected disabled>Select Year</option>
                        @for ($i = date('Y'); $i >= 1800; $i--)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Area (in square feet)</label>
                    <input type="number" class="form-control" step="0.01" name="area" id="area" required
                        min="1" max="20000">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Floor No.</label>
                    <input type="number" class="form-control" name="floor_number" id="floor_number" required
                        min="0" max="200">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Total Floors</label>
                    <input type="number" class="form-control" name="total_floors" id="total_floors" required
                        min="0" max="200">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Latitude</label>
                    <input type="number" step="any" class="form-control" name="latitude" id="latitude" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Longitude</label>
                    <input type="number" step="any" class="form-control" name="longitude" id="longitude" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Banner Image</label>
                    <input type="file" class="form-control" name="banner_image" id="fileInput" required>
                    <span id="error-msg" style="color: red;"></span>
                </div>
                <div class="col-md-12">
                    <button class="btn btn-primary btn-sm mt-3" type="submit">Save</button>
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
