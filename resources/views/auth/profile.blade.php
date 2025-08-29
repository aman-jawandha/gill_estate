@extends('website_layout.app')
@section('content')
    <section class="breadcumb-area bg-img"
        style="background-image: url('{{ asset('assets/img/bg-img/hero1.jpg') }}');height:200px">
    </section>
    <section class="south-contact-area section-padding-50">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="contact-heading">
                        <h6><a href="{{ route('dashboard') }}"><i class="fa fa-home"></i></a> / <a>Profile</a></h6>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            @include('website_layout.common')
            <div class="card p-5">
                <form action="{{ route('profile-update') }}" id="profile_update_form" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="hidden" value="{{ auth()->user()->id }}" name="user_id">
                                    <label class="form-label">Name <span class="red_star">*</span></label>
                                    <input type="text" name="name" minlength="3" maxlength="50" id="name"
                                        class="form-control" placeholder="Enter Your First Name"
                                        value="{{ auth()->user()->name }}" required>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label">Email Address <span class="red_star">*</span></label>
                                    <input type="email" name="email" id="email" minlength="5" maxlength="50"
                                        class="form-control" placeholder="example@example.com" required
                                        value="{{ auth()->user()->email }}">
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label">Phone <span class="red_star">*</span></label>
                                    <input type="text" name="phone" id="phone" minlength="10" maxlength="10"
                                        class="form-control" placeholder="Enter Phone" required
                                        value="{{ auth()->user()->phone }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-1"></div>
                        <div class="col-md-3">
                            <div class="avatar m-3 text-center">
                                <img id="selected_img"
                                    src="{{ auth()->user()->profile_pic ? asset('uploads/profiles/' . auth()->user()->profile_pic) : asset('assets/img/demo_image.jpeg') }}"
                                    alt="image" class="avatar-img rounded-circle" width="80%" />
                            </div>
                            <div class="text-center">
                                <div class="btn btn-primary btn-sm">
                                    <label class="form-label text-white m-1" for="profile_pic">Choose file</label>
                                    <input type="file" name="profile_pic" class="form-control d-none" id="profile_pic"
                                        onchange="displaySelectedImage(event, 'selected_img')" />
                                </div><br>
                                <span id="error-msg" style="color: red;"></span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Street <span class="red_star">*</span></label>
                            <input type="text" name="street" id="street" maxlength="250" class="form-control"
                                placeholder="Enter Address Street" required value="{{ auth()->user()->street }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Country <span class="red_star">*</span></label>
                            <select class="form-control" name="country" id="country" required>
                                        <option value="" selected>Select Country</option>
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->name }}" data-id="{{ $country->id }}" {{ auth()->user()->country == $country->name ? 'selected' : '' }}>
                                                {{ $country->name }}</option>
                                        @endforeach
                                    </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">State <span class="red_star">*</span></label>
                            <select id="state" name="state" class="form-control" required>
                                        @if(auth()->user()->state)
                                        <option value="">Select State</option>
                                        <option value="{{auth()->user()->state}}" selected>{{auth()->user()->state}}</option>
                                        @else
                                        <option value="" selected>Select State</option>
                                        @endif
                                    </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">City <span class="red_star">*</span></label>
                            <select id="city" name="city" class="form-control" required>
                                        @if(auth()->user()->city)
                                        <option value="">Select City</option>
                                        <option value="{{auth()->user()->city}}" selected>{{auth()->user()->city}}</option>
                                        @else
                                        <option value="" selected>Select City</option>
                                        @endif
                                    </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Zip Code <span class="red_star">*</span></label>
                            <input type="text" class="form-control" name="zip_code" id="zip_code"
                                placeholder="Enter Zip Code" required maxlength="6"
                                value="{{ auth()->user()->zip_code }}">
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card mt-4 p-5">
                <form action="{{ route('password-update') }}" id="password_update" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-7 mb-2">
                            <h4>Reset Password</h4>
                        </div>
                        <div class="col-md-7">
                            <label class="form-label">Current Password <span class="red_star">*</span></label>
                            <input type="password" name="current_password" minlength="8" maxlength="15"
                                id="current_password" class="form-control" placeholder="Enter Current Password"
                                value="{{ old('current_password') }}" required>
                        </div>
                        <div class="col-md-7">
                            <label class="form-label">New Password <span class="red_star">*</span></label>
                            <input type="password" name="new_password" id="new_password" minlength="8" maxlength="15"
                                class="form-control" placeholder="Enter New Password" value="{{ old('new_password') }}"
                                required>
                        </div>
                        <div class="col-md-7">
                            <label class="form-label">Confirm Password <span class="red_star">*</span></label>
                            <input type="password" name="new_password_confirmation" id="new_password_confirmation"
                                minlength="8" maxlength="15" class="form-control"
                                placeholder="Should be same as new password"
                                value="{{ old('new_password_confirmation') }}" required>
                        </div>
                        <div class="col-md-7 mt-4">
                            <button type="submit" class="btn btn-primary">Reset</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
@section('js')
    <script>
        let isFileValid = true;

        function validateFileInput() {
            const fileInput = document.getElementById('profile_pic');
            const file = fileInput.files[0];
            const errorMsg = document.getElementById('error-msg');
            errorMsg.textContent = '';
            isFileValid = true;

            if (!file) {
                return;
            }

            const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
            const maxSize = 1 * 1024 * 1024; // 1MB

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

        document.getElementById('profile_pic').addEventListener('change', function() {
            validateFileInput();
        });

        $("#profile_update_form").validate({
            errorElement: "span",
            errorPlacement: function(error, element) {
                error.addClass("text-danger");
                error.insertAfter(element);
            },
            rules: {
                email: {
                    required: true,
                    email: true,
                    remote: {
                        url: "{{ route('check-email') }}",
                        type: "get",
                        data: {
                            email: function() {
                                return $("#email").val();
                            },
                            user_id: "{{ auth()->user()->id }}",
                        }
                    }
                },
                phone: {
                     digits: true,
                },
            },
            messages: {
                email: {
                    remote: "Email already exist!"
                },
                phone: {
                    digits: "Phone should be a numeric value"
                },
            },
            submitHandler: function(form) {
                validateFileInput();
                if (isFileValid) {
                    form.submit();
                }
            }
        });
    </script>
@endsection
