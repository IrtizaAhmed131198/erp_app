<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('images/favicon-96x96.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon-16x16.png') }}">

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
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">
</head>

<body>


    <section class="sign-in-sec">
        <div class="container-fluid p-0">
            <div class="row align-items-center justify-content-center sign-up-row">
                <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 p-0 right-content">
                    <div class="sign-in-left sign-up-left">
                        <div class="logo-container">
                            <img src="{{ asset('images/main-logo.png') }}" class="img-fluid" alt="">
                        </div>
                        <div class="log-in-content">
                            <h1>Log in to your account</h1>
                            <p>Please enter your information here to view details</p>
                        </div>
                        <div class="log-in-foam">
                            <form action="{{ route('loginuser') }}" method="post">
                                @csrf
                                <div class="cridentials">
                                    <label for="exampleInputEmail1" class="form-label">E-Email</label>
                                    <input type="email" class="form-control" placeholder="Enter your email address"
                                        id="exampleInputEmail1" name="email" aria-describedby="emailHelp" required>
                                    <span class="icons">
                                        <img src="{{ asset('images/icon-1.png') }}" class="img-fluid" alt="">
                                    </span>
                                </div>
                                <div class="cridentials">
                                    <label for="exampleInputPassword1" class="form-label">Password</label>
                                    <input type="password" class="form-control" placeholder="Enter your password "
                                        name="password" id="exampleInputPassword1" required>
                                    <span class="icons">
                                        <img src="{{ asset('images/icon-2.png') }}" class="img-fluid" alt="">
                                    </span>
                                </div>
                                {{-- <div class="cridentials-check form-check">
                                    <span>
                                        <input type="checkbox" class="form-check-input" name="" id="exampleCheck1">
                                        <label class="form-check-label" for="exampleCheck1">Remeber me</label>
                                    </span>
                                    <span class="forget-pass">
                                        <a href="javascript:;">Forget Password</a>
                                    </span>
                                </div> --}}
                                <button type="submit" class="btn custom-btn-login">Submit</button>


                                <div class="Need-Help">
                                    <p>
                                        Need Help?
                                        <span>
                                            <a href="#">Contact Us</a>
                                        </span>
                                    </p>
                                </div>
                            </form>
                        </div>


                    </div>
                </div>
                <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 p-0 slider-main-colum"
                    id="hide-on-mobile">
                    <div class="slider-main">
                    </div>
                </div>
            </div>
        </div>
    </section>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $(".js-select2").select2({
                closeOnSelect: true
            });
            $(".js-select2-multi").select2({
                closeOnSelect: true
            });
        });
    </script>

</body>

</html>