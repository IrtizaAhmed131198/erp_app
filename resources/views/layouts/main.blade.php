<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" sizes="32x32" href="images/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="images/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon-16x16.png">

    <title>Rita Shea</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <!-- fonts  -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Funnel+Sans:ital,wght@0,300..800;1,300..800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css"
        integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">
    @yield('css')
</head>

<body>


    <header>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <nav class="navbar navbar-expand-lg">
                        <div class="container-fluid p-0">
                            <a class="navbar-brand" href="index.php">
                                <img src="{{ asset('images/sidebarlogo.png') }}" class="img-fluid" alt="">
                            </a>
                            <form class="d-flex" role="search">
                                <div class="parent-search-bar">
                                    <button>
                                        <img src="{{ asset('images/search-bar.png') }}" class="img-fluid"
                                            alt="">
                                    </button>
                                    <input class="form-control" type="search" id="search-input" placeholder="Search" aria-label="Search">
                                </div>
                            </form>
                            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                                aria-expanded="false" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                            </button>
                            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-center">
                                    <a href="{{ route('notifications') }}">
                                        <button class="bell-icon" type="submit">
                                            <img src="{{ asset('images/notification-icon.png') }}" class="img-fluid"
                                                alt="">
                                        </button>
                                    </a>
                                    <div class="profile-detail">
                                        <a href="javascript:;">
                                            <img src="{{ asset('images/profile-pic.png') }}" class="img-fluid"
                                                alt="">
                                        </a>
                                    </div>
                                    <li class="nav-item dropdown profile-drop-down">
                                        <a class="nav-link dropdown-toggle" href="javascript:;" role="button"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            {{ Auth::user()->name }}
                                        </a>
                                        <ul class="dropdown-menu">
                                            @if (auth()->check())
                                                <li><a class="dropdown-item" href="{{ route('index') }}">Master Data</a>
                                                </li>
                                                @if (Auth::user()->user_maintenance == 1)
                                                    <li><a class="dropdown-item"
                                                            href="{{ route('users.index') }}">Users</a>
                                                    </li>
                                                    <li><a class="dropdown-item" href="{{ route('add_user') }}">Add
                                                            User</a>
                                                    </li>
                                                @endif
                                    </li>
                                    <li><a class="dropdown-item" href="{{ route('calender') }}">Shipment &
                                            Production</a>
                                    </li>
                                    <li><a class="dropdown-item" href="{{ route('input_screen') }}">Input screen</a>
                                    </li>
                                    <li><a class="dropdown-item" href="{{ route('visual_screen') }}">Visual Input
                                            Screen
                                        </a>
                                    </li>
                                    {{-- <li><a class="dropdown-item" href="{{ route('visual_screen_1') }}">Visual screen 1</a>
                                                </li>
                                                <li><a class="dropdown-item" href="{{ route('visual_screen_2') }}">Visual screen 2</a>
                                                </li> --}}
                                    <li><a class="dropdown-item" href="{{ route('data_center') }}">Part Number
                                            Input</a>
                                    </li>
                                    <li><a class="dropdown-item" href="{{ route('logout') }}">Logout</a>
                                    </li>
                                @else
                                    <li><a class="dropdown-item" href="{{ route('login') }}">Login</a></li>
                                    @endif
                                </ul>
                                </li>
                                </ul>
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </header>


    @yield('content')



    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap5.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.querySelector('form[role="search"]').addEventListener('submit', function(e) {
            e.preventDefault();
            // Add your custom search handling logic here
        });
    </script>

    @yield('js')

    <script>
        function formatAndPreventNegative(element) {
            // Remove non-numeric characters except for the decimal point
            let value = element.value.replace(/[^0-9.]/g, '');

            // Prevent negative values
            if (value.startsWith('-')) {
                value = value.replace('-', '');
            }

            // Split the value into integer and decimal parts
            const parts = value.split('.');
            parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ','); // Add commas to the integer part

            // Rejoin the integer and decimal parts
            element.value = parts.join('.');
        }
    </script>

    <script>
        $(document).ready(function() {
            $(".js-select2").select2({
                closeOnSelect: true
            });
            $(".js-select21").select2({
                closeOnSelect: true
            });
            $(".js-select2-multi").select2({
                closeOnSelect: true
            });
        });
    </script>

    @if (session('success'))
        <script>
            Swal.fire({
                title: 'Success!',
                text: '{{ session('success') }}',
                icon: 'success',
                confirmButtonText: 'OK'
            }).then(() => {
                window.location.href = "{{ url()->previous() }}"; // Redirect back
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                title: 'Error!',
                text: '{{ session('error') }}',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        </script>
    @endif

</body>

</html>
