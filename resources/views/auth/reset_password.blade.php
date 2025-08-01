<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Gill Estate</title>

    <!-- Favicons -->
    <link rel="icon" href="{{asset('assets/img/core-img/favicon.ico')}}" type="image/x-icon" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body style="background-image: url('{{ asset('assets/img/bg-img/hero5.jpg') }}'); background-size: cover; background-position: center;">
    <div class="container-fluid" style="margin-top:70px">
        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4 card">
                <div class="text-center pt-5 pb-4">
                    {{-- <a href="{{ route('home') }}"><img src="assets/img/core-img/logo.png" style="width: 150px;"
                            alt="logo"></a> --}}
                    <h4 style="color:#947054;margin-top:10px">Gill Estate</h4>
                </div>
                <div>
                    @if (session('error'))
                        <div class="d-flex align-items-center text-danger">
                            {{-- <i class="bi bi-exclamation-circle m-2"></i> --}}
                            <p class="mb-0">
                                <b>{{ session('error') }}</b>
                            </p>
                        </div>
                    @endif
                    @if (session('success'))
                        <div class="d-flex align-items-center text-success">
                            {{-- <i class="bi bi-check-circle m-2"></i> --}}
                            <p class="mb-0">
                                <b>{{ session('success') }}</b>
                            </p>
                        </div>
                    @endif
                    <form action="{{ route('reset-pswd') }}" method="post">
                        @csrf
                        <label class="mb-2">Reset Your Password Here</label>
                        <input type="hidden" name="token" value="{{$token}}">
                        <input type="email" name="email" id="email" minlength="8" maxlength="30"
                            class="form-control" placeholder="Enter Your Email" value="{{ old('email') }}"><br>
                        <input type="password" name="new_password" id="new_password" minlength="8" maxlength="20"
                            class="form-control" placeholder="New Password" value="{{ old('new_password') }}"><br>
                        <input type="password" name="new_password_confirmation" id="new_password_confirmation"
                            minlength="8" maxlength="20" class="form-control"
                            placeholder="Confirm Password" value="{{ old('new_password_confirmation') }}">
                        <div class="d-flex align-items-center justify-content-between mt-4 mb-4">
                            <button type="submit" style="background-color:#947054;border:none" class="btn btn-primary">Reset</button>
                            <a href="{{ route('login') }}" style="background-color:#947054;border:none" class="btn btn-primary">Login</a>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-4"></div>
        </div>
    </div>
</body>

</html>
