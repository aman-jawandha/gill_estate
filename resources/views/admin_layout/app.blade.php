<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Gill Estate</title>
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
    <link rel="icon" href="{{ asset('assets/img/core-img/favicon.ico') }}" type="image/x-icon" />
    <style>
        li.nav-item.active {
            background-color: #947054;
        }
    </style>
    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('assets/css/admin/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/kaiadmin.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/admin/plugins.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/admin.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/font-awesome.min.css') }}" />
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.0/css/dataTables.dataTables.min.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.css" rel="stylesheet">
</head>

<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <div class="sidebar" data-background-color="dark">
            <div class="sidebar-logo">
                <!-- Logo Header -->
                <div class="logo-header" data-background-color="dark">
                    <a href="{{ route('dashboard') }}" class="logo">
                        <img src="{{ asset('assets/img/core-img/logo.png') }}" alt="navbar brand" class="navbar-brand"
                            width="100px" />
                    </a>
                    <div class="nav-toggle">
                        <button class="btn btn-toggle toggle-sidebar">
                            <i class="gg-menu-right"></i>
                        </button>
                        <button class="btn btn-toggle sidenav-toggler">
                            <i class="gg-menu-left"></i>
                        </button>
                    </div>
                    <button class="topbar-toggler more">
                        <i class="gg-more-vertical-alt"></i>
                    </button>
                </div>
                <!-- End Logo Header -->
            </div>
            <div class="sidebar-wrapper scrollbar scrollbar-inner">
                <div class="sidebar-content">
                    <ul class="nav nav-secondary">
                        <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                            <a href="{{ route('dashboard') }}">
                                <i class="fa fa-home"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                        <li class="nav-section">
                            <span class="sidebar-mini-icon">
                                <i class="fa fa-ellipsis-h"></i>
                            </span>
                            <h4 class="text-section">Components</h4>
                        </li>
                        @can('roles-list')
                            <li
                                class="nav-item {{ request()->routeIs('roles', 'create-role', 'edit-role') ? 'active' : '' }}">
                                <a href="{{ route('roles') }}">
                                    <i class="fa fa-shield"></i>
                                    <p>Roles</p>
                                </a>
                            </li>
                        @endcan
                        @can('staff-list')
                            <li
                                class="nav-item {{ request()->routeIs('staff', 'create-staff', 'edit-staff') ? 'active' : '' }}">
                                <a href="{{ route('staff') }}">
                                    <i class="fa fa-users"></i>
                                    <p>Staff</p>
                                </a>
                            </li>
                        @endcan
                        @can('sellers-list')
                            <li class="nav-item {{ request()->routeIs('sellers') ? 'active' : '' }}">
                                <a href="{{ route('sellers') }}">
                                    <i class="fa fa-users"></i>
                                    <p>Sellers</p>
                                </a>
                            </li>
                        @endcan
                        @can('buyers-list')
                            <li class="nav-item {{ request()->routeIs('buyers') ? 'active' : '' }}">
                                <a href="{{ route('buyers') }}">
                                    <i class="fa fa-users"></i>
                                    <p>Buyers</p>
                                </a>
                            </li>
                        @endcan
                        @can('properties-list')
                            <li
                                class="nav-item {{ request()->routeIs('properties-list', 'create-property', 'edit-property', 'view-property') ? 'active' : '' }}">
                                <a href="{{ route('properties-list') }}">
                                    <i class="fa fa-building"></i>
                                    <p>Properties</p>
                                </a>
                            </li>
                        @endcan
                        @can('sellers-properties')
                            <li
                                class="nav-item {{ request()->routeIs('sellers-properties','view-seller-property','edit-seller-property') ? 'active' : '' }}">
                                <a href="{{ route('sellers-properties') }}">
                                    <i class="fa fa-building"></i>
                                    <p>Sellers Properties</p>
                                </a>
                            </li>
                        @endcan
                        @can('buyers-requirements-list')
                            <li
                                class="nav-item {{ request()->routeIs('buyers-requirements') ? 'active' : '' }}">
                                <a href="{{ route('buyers-requirements') }}">
                                    <i class="fa fa-list-alt"></i>
                                    <p>Buyers Requirements</p>
                                </a>
                            </li>
                        @endcan
                        @can('faqs-list')
                            <li class="nav-item {{ request()->routeIs('faqs', 'create-faq', 'edit-faq') ? 'active' : '' }}">
                                <a href="{{ route('faqs') }}">
                                    <i class="fa fa-question-circle"></i>
                                    <p>FAQs</p>
                                </a>
                            </li>
                        @endcan
                        @can('contact-us-list')
                            <li class="nav-item {{ request()->routeIs('contact-us-messages') ? 'active' : '' }}">
                                <a href="{{ route('contact-us-messages') }}">
                                    <i class="fa fa-comment"></i>
                                    <p>Contact Us Msgs</p>
                                </a>
                            </li>
                        @endcan
                        @can('queries-list')
                            <li class="nav-item {{ request()->routeIs('queries') ? 'active' : '' }}">
                                <a href="{{ route('queries') }}">
                                    <i class="fa fa-question-circle"></i>
                                    <p>Queries</p>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </div>
            </div>
        </div>
        <!-- End Sidebar -->

        <div class="main-panel">
            <div class="main-header">
                <div class="main-header-logo">
                    <!-- Logo Header -->
                    <div class="logo-header" data-background-color="dark">
                        <a href="index.html" class="logo">
                            <img src="{{ asset('assets/img/core-img/logo.png') }}" alt="navbar brand"
                                class="navbar-brand" height="20" />
                        </a>
                        <div class="nav-toggle">
                            <button class="btn btn-toggle toggle-sidebar">
                                <i class="gg-menu-right"></i>
                            </button>
                            <button class="btn btn-toggle sidenav-toggler">
                                <i class="gg-menu-left"></i>
                            </button>
                        </div>
                        <button class="topbar-toggler more">
                            <i class="gg-more-vertical-alt"></i>
                        </button>
                    </div>
                    <!-- End Logo Header -->
                </div>
                <!-- Navbar Header -->
                <nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
                    <div class="container-fluid">
                        <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
                            <li class="nav-item topbar-user dropdown hidden-caret" style="background-color: #eaedf1">
                                <a class="dropdown-toggle profile-pic" data-bs-toggle="dropdown" href="#"
                                    aria-expanded="false">
                                    <div class="avatar-sm">
                                        <img src="{{ asset('assets/img/demo_image.jpeg') }}" alt="image"
                                            class="avatar-img rounded-circle" />
                                    </div>
                                    <span class="profile-username">
                                        <span class="fw-bold">Admin</span>
                                    </span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('profile') }}">View Profile</a>
                                        <a class="dropdown-item" href="{{ route('logout') }}">Logout</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>
                <!-- End Navbar -->
            </div>

            <div class="container">
                <div class="page-inner">
                    @if (session('success'))
                        <p class="alert alert-success text-success notify_alert"><b><i class="fa fa-check-circle"></i>
                                {{ session('success') }}</b></p>
                    @endif
                    @if (session('error'))
                        <p class="alert alert-danger text-danger notify_alert"><b><i
                                    class="fa fa-exclamation-circle"></i>
                                {{ session('error') }}</b></p>
                    @endif
                    <form id="delete-form" method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>
                    <form id="update-status" method="POST" style="display: none;">
                        @csrf
                    </form>
                    @yield('content')
                </div>
            </div>

            <footer class="footer">
                <div class="container-fluid d-flex justify-content-center">
                    <div class="copyright">
                        Copyright © {{ date('Y') }} Gill Estate
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <!--   Core JS Files   -->
    <script src="{{ asset('assets/js/admin/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/admin/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/admin/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugin/summernote-lite.min.js') }}"></script>

    <!-- jQuery Scrollbar -->
    <script src="{{ asset('assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>

    <!-- jQuery validate -->
    <script src="{{ asset('assets/js/plugin/jquery.validate/jquery.validate.min.js') }}"></script>

    <!-- Datatables -->
    <script src="{{ asset('assets/js/plugin/datatables/datatables.min.js') }}"></script>

    <!-- Sweet Alert -->
    <script src="{{ asset('assets/js/plugin/sweetalert/sweetalert.min.js') }}"></script>

    <!-- Kaiadmin JS -->
    <script src="{{ asset('assets/js/kaiadmin.min.js') }}"></script>

    <!-- Kaiadmin DEMO methods, don't include it in your project! -->
    <script>
        $('#summernote').summernote({
            height: 250
        });
        $(document).ready(function() {
            $('#data_table').DataTable({
                ordering: false
            });
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

        $('#state').on('change', function() {
            let regionCode = $('#state option:selected').data('code');
            $('#city').empty().append('<option>Loading...</option>');
            if (regionCode) {
                $.ajax({
                    url: `/api/cities/${regionCode}`,
                    method: 'GET',
                    success: function(response) {
                        $('#city').empty().append(
                            '<option value="" selected disabled>Select City</option>');
                        $.each(response.data, function(i, city) {
                            $('#city').append(
                                `<option value="${city.name}">${city.name}</option>`);
                        });
                    },
                    error: function() {
                        $('#city').empty().append(
                            '<option value="" selected disabled>Error in loading cities</option>');
                    }
                });
            } else {
                $('#city').html('<option value="" selected disabled>Select City</option>');
            }
        });
    </script>
    @yield('js')
</body>

</html>
