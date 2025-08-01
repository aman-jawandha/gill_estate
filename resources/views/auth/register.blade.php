<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Gill Estate</title>

    <!-- Favicons -->
    <link rel="icon" href="{{asset('assets/img/core-img/favicon.ico')}}" type="image/x-icon" />
    <!-- Vendor CSS Files -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .error {
            font-size: 14px;
            margin: 5px 0px;
        }
        #agree_to_terms-error{
            margin: 20px;
        }
    </style>
</head>

<body style="background-image: url('{{ asset('assets/img/bg-img/hero5.jpg') }}'); background-size: cover; background-position: center;">
    <div class="container-fluid" style="margin-top:70px">
        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4 card">
                <div class="text-center pt-3 pb-4">
                    <a href="{{ route('home') }}"><img src="assets/img/core-img/logo.png" style="width: 120px;"
                            alt="logo"></a>
                    <h4 style="color:#947054;margin-top:10px">Gill Estate</h4>
                </div>
                <div>
                    <form action="{{ route('post-register') }}" id="register_form" method="post">
                        @csrf
                        <input type="text" class="form-control" name="name" minlength="5"
                            maxlength="25" value="{{ old('name') }}" placeholder="First Name" required><br>
                        <input type="email" class="form-control" name="email" id="email" minlength="5"
                            maxlength="50" value="{{ old('email') }}" placeholder="Email" required><br>
                        <input type="password" class="form-control" name="password" minlength="8" maxlength="20"
                            value="{{ old('password') }}" placeholder="Password" required><br>
                        <select name="role" class="form-control" required>
                            <option value="" selected disabled>Select Role</option>
                            <option value="buyer">Buyer</option>
                            <option value="seller">Seller</option>
                            {{-- <option value="agent">Agent</option> --}}
                        </select><br>
                        <div class="form-check">
                        <input class="form-check-input" name="agree_to_terms" type="checkbox" value="Yes" id="agree_to_terms" required>
                        <label class="form-check-label" for="agree_to_terms">
                            I agree to <a href="">Terms & Conditions</a>
                        </label>
                        </div><br>
                        <button type="submit" class="btn btn-primary"
                            style="width: 100%;background-color:#947054;border:none">Register</button>
                    </form>
                    <p class="m-3 text-center text-muted">Already have an account? <a
                            href="{{ route('login') }}">Login</a></p>
                </div>
            </div>
            <div class="col-md-4"></div>
        </div>
    </div>
</body>
<script src="{{asset('assets/js/admin/jquery-3.7.1.min.js')}}"></script>
<script src="{{asset('assets/js/admin/popper.min.js')}}"></script>
<script src="{{asset('assets/js/admin/bootstrap.min.js')}}"></script>
<script src="{{ asset('assets/js/plugin/jquery.validate/jquery.validate.min.js') }}"></script>
<script>
    $("#register_form").validate({
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
                        _token: "{{ csrf_token() }}"
                    }
                }
            },
            agree_to_terms: {
                required: true,
            },
        },
        messages: {
            email: {
                remote: "Email already exist!"
            },
            agree_to_terms: {
                required: "Acceptance of Terms & Conditions is required!"
            }
        },
        submitHandler: function(form) {
            form.submit();
        }
    });
</script>

</html>
