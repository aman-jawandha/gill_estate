<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Title  -->
    <title>Gill Estate</title>

    <!-- Favicon  -->
    <link rel="icon" href="{{ asset('assets/img/core-img/favicon.ico') }}">

    <!-- Style CSS -->
    <link rel="stylesheet" href="{{ asset('assets/style.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.css" rel="stylesheet">
    <style>
        .dd-arrow {
            display: none;
        }

        .dd-trigger {
            display: none;
        }
    .modal-backdrop {
        z-index: 10001 !important;
    }

    .modal {
        z-index: 10002 !important;
    }
.floating-query-btn {
    position: fixed;
    bottom: 100px;
    right: 40px;
    background-color: #947054;
    color: white;
    border-radius: 10px;
    padding: 5px 10px;
    font-size: 16px;
    font-weight: bold;
    z-index: 9999;
    border: none;
}
    </style>
</head>

<body>
    <!-- Preloader -->
    <div id="preloader">
        <div class="south-load"></div>
    </div>

    <!-- ##### Header Area Start ##### -->
    <header class="header-area">

        <!-- Top Header Area -->
        <div class="top-header-area">
            <div class="h-100 d-md-flex justify-content-between align-items-center">
                <div class="email-address">
                    <a href="mailto:contact@southtemplate.com">contact@southtemplate.com</a>
                </div>
                <div class="phone-number d-flex">
                    <div class="icon">
                        <img src="{{ asset('assets/img/icons/phone-call.png') }}" alt="">
                    </div>
                    <div class="number">
                        <a href="tel:+45 677 8993000 223">+45 677 8993000 223</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Header Area -->
        <div class="main-header-area" id="stickyHeader">
            <div class="classy-nav-container breakpoint-off">
                <!-- Classy Menu -->
                <nav class="classy-navbar justify-content-between" id="southNav">

                    <!-- Logo -->
                    <a class="nav-brand" href="{{ route('home') }}"><img
                            src="{{ asset('assets/img/core-img/logo.png') }}" alt=""></a>

                    <!-- Navbar Toggler -->
                    <div class="classy-navbar-toggler">
                        <span class="navbarToggler"><span></span><span></span><span></span></span>
                    </div>

                    <!-- Menu -->
                    <div class="classy-menu">

                        <!-- close btn -->
                        <div class="classycloseIcon">
                            <div class="cross-wrap"><span class="top"></span><span class="bottom"></span></div>
                        </div>

                        <!-- Nav Start -->
                        <div class="classynav">
                            <ul>
                                <li><a href="{{ route('home') }}" class="web-link {{ request()->routeIs('home') ? 'active' : '' }}">Home</a></li>
                                <li><a href="{{ route('about-us') }}" class="web-link {{ request()->routeIs('about-us') ? 'active' : '' }}">About Us</a></li>
                                <li><a href="{{ route('properties') }}" class="web-link {{ request()->routeIs('properties') ? 'active' : '' }}">Properties</a></li>
                                <li><a href="{{ route('contact-us') }}" class="web-link {{ request()->routeIs('contact-us') ? 'active' : '' }}">Contact</a></li>
                                @if (auth()->user())
                                    <li><a href="{{ route('profile') }}" class="btn btn-sm"
                                            style="background-color: #947054"><i class="fa fa-user"></i>&nbsp; Profile
                                            &nbsp;&nbsp;&nbsp;<i class="fa fa-caret-down"></i></a>
                                        <ul class="dropdown">
                                            {{-- <li><a href="{{ route('profile') }}"><i class="fa fa-user"></i>&nbsp;
                                                    Profile</a></li> --}}
                                            @if(auth()->user()->role == 'buyer')
                                                <li><a href="{{ route('find-property') }}"><i class="fa fa-search"></i>&nbsp; Find a Property</a></li>
                                                <li><a href="{{ route('shortlisted-properties') }}"><i class="fa fa-heart"></i>&nbsp; Shortlisted</a></li>
                                            @endif
                                            @if(auth()->user()->role == 'seller')
                                                <li><a href="{{ route('sell-property') }}"><i class="fa fa-tag"></i>&nbsp;  Sell Property</a></li>
                                                <li><a href="{{ route('my-properties') }}"><i class="fa fa-home"></i>&nbsp;  My Properties</a></li>
                                            @endif
                                            <li><a href="{{ route('logout') }}"><i class="fa fa-sign-out"></i>&nbsp;
                                                    Logout</a></li>
                                        </ul>
                                    </li>
                                @endif
                            </ul>
                            @if (!auth()->user())
                                <div class="btn-group m-3">
                                    <a href="{{ route('register') }}" class="btn btn-sm"
                                        style="background-color:#947054;border:1px solid white;color:white"><b>Sign
                                            Up</b></a>
                                    <a href="{{ route('login') }}" class="btn btn-sm"
                                        style="background-color:white;border:1px solid white;color:#947054"><b>Log
                                            In</b></a>
                                </div>
                            @endif
                        </div>
                        <!-- Nav End -->
                    </div>
                </nav>
            </div>
        </div>
    </header>
    <!-- ##### Header Area End ##### -->
<form id="delete-form" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>
<form id="update-status" method="POST" style="display: none;">
    @csrf
</form>
    @yield('content')
<div class="modal fade" id="query_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ask Your Query</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        onclick="$('#query_modal').modal('hide')">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('store-contact-us') }}" method="post">
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" name="type" value="query">
                        <div class="form-group">
                            <input type="text" class="form-control" name="name" id="name" maxlength="50"
                                placeholder="Your Name" required>
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-control" name="email" id="email" maxlength="50"
                                placeholder="Your Email" required>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="phone" id="phone" maxlength="10"
                                placeholder="Your Phone" required>
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" style="height:200px" name="message" maxlength="1000" id="message" rows="10"
                                placeholder="Your Message" required></textarea>
                        </div>
                    </div>
                    <div class="text-right p-3">
                        <button type="submit" class="btn btn-primary mb-2">Send</button>
                    </div>
                    </form>
            </div>
        </div>
    </div>
    <!-- ##### Footer Area Start ##### -->
    <footer class="footer-area section-padding-50-0 bg-img gradient-background-overlay"
        style="background-image: url('{{ asset('assets/img/bg-img/cta.jpg') }}')">
        <!-- Main Footer Area -->
        <div class="main-footer-area">
            <div class="container">
                <div class="row">

                    <!-- Single Footer Widget -->
                    <div class="col-md-4">
                        <div class="footer-widget-area mb-100">
                            <!-- Widget Title -->
                            <div class="widget-title">
                                <h6>About Us</h6>
                            </div>

                            <img src="{{ asset('assets/img/bg-img/footer.jpg') }}" alt="">
                            <div class="footer-logo my-4">
                                <img src="{{ asset('assets/img/core-img/logo.png') }}" alt="">
                            </div>
                            <p>Integer nec bibendum lacus. Suspen disse dictum enim sit amet libero males uada feugiat.
                                Praesent malesuada.</p>
                        </div>
                    </div>
                    <!-- Single Footer Widget -->
                    <div class="col-md-4">
                        <div class="footer-widget-area mb-100">
                            <!-- Widget Title -->
                            <div class="widget-title">
                                <h6>Get In Touch</h6>
                            </div>
                            <!-- Office Hours -->
                            <div class="weekly-office-hours">
                                <ul>
                                    <li class="d-flex align-items-center justify-content-between"><span>Monday -
                                            Friday</span> <span>09 AM - 19 PM</span></li>
                                    <li class="d-flex align-items-center justify-content-between"><span>Saturday</span>
                                        <span>09 AM - 14 PM</span></li>
                                    <li class="d-flex align-items-center justify-content-between"><span>Sunday</span>
                                        <span>Closed</span></li>
                                </ul>
                            </div>
                            <!-- Address -->
                            <div class="address">
                                <h6><img src="{{ asset('assets/img/icons/phone-call.png') }}" alt=""> +45 677
                                    8993000 223</h6>
                                <h6><img src="{{ asset('assets/img/icons/envelope.png') }}" alt="">
                                    office@template.com</h6>
                                <h6><img src="{{ asset('assets/img/icons/location.png') }}" alt=""> Main Str.
                                    no 45-46, b3, 56832, Los Angeles, CA</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-1"> </div>
                    <!-- Single Footer Widget -->
                    <div class="col-md-3">
                        <div class="footer-widget-area mb-100">
                            <!-- Widget Title -->
                            <div class="widget-title">
                                <h6>Useful Links</h6>
                            </div>
                            <!-- Nav -->
                            <ul class="useful-links-nav">
                                <li><a href="#">Home</a></li>
                                <li><a href="#">About us</a></li>
                                <li><a href="#">Properties</a></li>
                                <li><a href="#">Testimonials</a></li>
                                <li><a href="#">Blogs</a></li>
                                <li><a href="#">FAQ</a></li>
                                <li><a href="#">Contact</a></li>
                                
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Copywrite Text -->
        <div class="copywrite-text d-flex align-items-center justify-content-center">
            <p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                Copyright &copy;
                <script>
                    document.write(new Date().getFullYear());
                </script> All rights reserved | Gill Estate</a>
                <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
        </div>
    </footer>
    <button type="button" class="floating-query-btn" style="cursor: pointer;" onclick="$('#query_modal').modal('show')"><i class="fa fa-question-circle"> Have Any Query?</i></button>
    <!-- ##### Footer Area End ##### -->

    <!-- jQuery (Necessary for All JavaScript Plugins) -->
    <script src="{{ asset('assets/js/jquery-2.2.4.min.js') }}"></script>
    <!-- Popper js -->
    <script src="{{ asset('assets/js/popper.min.js') }}"></script>
    <!-- Bootstrap js -->
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugin/jquery.validate/jquery.validate.min.js') }}"></script>
    <!-- Sweet Alert -->
    <script src="{{ asset('assets/js/plugin/sweetalert/sweetalert.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugin/summernote-lite.min.js') }}"></script>
    <!-- Plugins js -->
    <script src="{{ asset('assets/js/plugins.js') }}"></script>
    <script src="{{ asset('assets/js/classy-nav.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
    <!-- Active js -->
    <script src="{{ asset('assets/js/active.js') }}"></script>
    @yield('js')
    <script>
        $('#summernote').summernote({
            height: 250
        });
        $(document).ready(function() {
            setTimeout(function() {
                $('.notify_alert').remove();
            }, 3000);
        });

        function displaySelectedImage(event, elementId) {
            const selectedImage = document.getElementById(elementId);
            const fileInput = event.target;

            if (fileInput.files && fileInput.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    selectedImage.src = e.target.result;
                };

                reader.readAsDataURL(fileInput.files[0]);
            }
        }

        function confirmDelete(url, msg) {
            swal({
                title: 'Are you sure?',
                text: `You want to delete this ${msg}?`,
                icon: 'warning',
                buttons: {
                    confirm: {
                        text: 'Yes, delete it!',
                        className: 'btn btn-success'
                    },
                    cancel: {
                        visible: true,
                        className: 'btn btn-danger'
                    }
                }
            }).then((willDelete) => {
                if (willDelete) {
                    let form = document.getElementById('delete-form');
                    form.action = url;
                    form.submit();
                }
            });
        }

        function updateStatus(url, msg) {
            swal({
                title: 'Are you sure?',
                text: `You want to update status of this ${msg}?`,
                icon: 'warning',
                buttons: {
                    confirm: {
                        text: 'Yes, update!',
                        className: 'btn btn-success'
                    },
                    cancel: {
                        visible: true,
                        className: 'btn btn-danger'
                    }
                }
            }).then((willDelete) => {
                if (willDelete) {
                    let form = document.getElementById('update-status');
                    form.action = url;
                    form.submit();
                }
            });
        }

        $('#accordion').on('show.bs.collapse', function(e) {
            $(e.target).prev('.card-header').find('.toggle-icon').text('−');
        });

        $('#accordion').on('hide.bs.collapse', function(e) {
            $(e.target).prev('.card-header').find('.toggle-icon').text('+');
        });

        $('#state').on('change', function () {
    let regionCode = $('#state option:selected').data('code');

    // Reset city dropdown
    $('#city').empty().append('<option>Loading...</option>');
    $('#city').niceSelect('update'); // Refresh UI

    if (regionCode) {
        $.ajax({
            url: `/api/cities/${regionCode}`,
            method: 'GET',
            success: function (response) {
                $('#city').empty().append('<option value="" selected disabled>Select City</option>');

                $.each(response.data, function (i, city) {
                    $('#city').append(`<option value="${city.name}">${city.name}</option>`);
                });

                $('#city').niceSelect('update'); // 🔄 Refresh again after adding cities
            },
            error: function () {
                $('#city').empty().append('<option value="" selected disabled>Error in loading cities</option>');
                $('#city').niceSelect('update'); // 🔄 Refresh on error too
            }
        });
    } else {
        $('#city').html('<option value="" selected disabled>Select City</option>');
        $('#city').niceSelect('update'); // Refresh if regionCode is missing
    }
});

    </script>
</body>

</html>
