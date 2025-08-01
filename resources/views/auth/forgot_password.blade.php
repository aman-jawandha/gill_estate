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

<body style="background-image: url('{{ asset('assets/img/bg-img/hero5.jpg') }}'); background-size: cover; background-position: center;">
    <div class="container-fluid" style="margin-top:70px">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8 card">
                <div class="text-center pt-5 pb-4">
                    <a href="{{ route('home') }}"><img src="assets/img/core-img/logo.png" style="width: 150px;"
                            alt="logo"></a>
                    <h4 style="color:#947054;margin-top:10px">Gill Estate</h4>
                </div>
                <div>
                    @if (session('error'))
                        <div class="d-flex align-items-center text-danger">
                            <p class="mb-0">
                                <b>{{ session('error') }}</b>
                            </p>
                        </div>
                    @endif
                    @if (session('success'))
                        <div class="d-flex align-items-center text-success">
                            <p class="mb-0">
                                <b>{{ session('success') }}</b>
                            </p>
                        </div>
                    @endif
                    <form action="{{ route('send-reset-pswd-mail') }}" method="post">
                        @csrf
                        <label class="mb-2">Enter your registered email to get reset password link</label>
                        <input type="email" class="form-control" name="email" minlength="8" maxlength="30" value="{{ old('email') }}"
                            placeholder="Email"><br>
                            <div class="d-flex align-items-center justify-content-between mt-4 mb-4">
                        <button type="submit" style="background-color:#947054;border:none" class="btn btn-primary">Send Email</button>
                        <a href="{{route('login')}}" style="background-color:#947054;border:none" class="btn btn-primary">Back To Login</a>
                            </div>
                    </form>
                </div>
            </div>
            <div class="col-md-2"></div>
        </div>
    </div>
</body>

</html>
