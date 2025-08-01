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
</head>

<body>
    <div class="container-fluid" style="margin-top:70px">
        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4 card" style="border: 2px solid #a98162;border-radius:10px">
                <div class="text-center pt-5 pb-4">
                    <a href="{{ route('home') }}"><img src="assets/img/core-img/logo.png" style="width: 150px;"
                            alt="logo"></a>
                    <h4 style="color:#947054;margin-top:10px">Gill Estate</h4>
                </div>
                <div>
                    @if (session('error'))
                        <div class="d-flex align-items-center text-danger">
                            <i class="bi bi-exclamation-circle m-2"></i>
                            <p class="mb-0">
                                <b>{{ session('error') }}</b>
                            </p>
                        </div>
                    @endif
                    <form action="{{ route('post_login') }}" method="post">
                        @csrf
                        <input type="email" class="form-control" name="email" value="{{ old('email') }}"
                            placeholder="Email"><br>
                        <input type="password" class="form-control" name="password" value="{{ old('password') }}"
                            placeholder="Password"><br>
                        <button type="submit" class="btn btn-primary" style="width: 100%;background-color:#947054;border:none">Login</button>
                        <div class="d-flex align-items-center justify-content-between mt-4 mb-4">
                            <a class="text-muted" href="{{route('forgot-password')}}">Forgot password?</a>
                            <a class="text-muted" href="{{ route('register') }}">Sign Up?</a>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-4"></div>
        </div>
    </div>
</body>

</html>
