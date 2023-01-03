<!DOCTYPE html>
<html lang="en">

<head> 
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('assets/img/header/logo/landapp-logo.png') }}">
    <title>Sistem Penjualan DRG</title>
    <!-- -------- anime css ------ -->
    <link rel="stylesheet" href="assets/css/animate.css">
    <!-- --------- font awsome css ------ -->
    <link rel="stylesheet" href="assets/css/all.css">
    <!-- ---- Bootstrap css--- -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <!-- ---------- default css --------- -->
    <link rel="stylesheet" href="assets/css/default.css">
    <!-- --- style css -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <!-- --------- preloader ------------ -->
    <div class="preloader">
        <div class="loader">
            <div class="spinner">
                <div class="spinner-container">
                    <div class="spinner-rotator">
                        <div class="spinner-left">
                            <div class="spinner-circle"></div>
                        </div>
                        <div class="spinner-right">
                            <div class="spinner-circle"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-------   Header star ------>
    <header class="header-area">
        <div class="navbar-area full-height">
            <!---- navbar star--->
            <div class="container">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <div class="container-fluid">
                        <a class="navbar-brand" href="#">
                            <img class="image" src="assets/img/header/logo/login-landapp-logo.png" alt="">
                        </a>
                    </div>
                </nav>
            </div>
        </div>
        <!---- navbar end--->
        <div class="header-hero" data-scroll-index="0">
            <!---- home star ------>
            <div class="shape shape-1"></div>
            <div class="shape shape-2"></div>
            <div class="shape shape-3"></div>
            <div class="shape shape-4"></div>
            <div class="shape shape-5"></div>
            <div class="shape shape-6"></div>
            <div class="container">
                <div class="row align-items-center justify-content-center justify-content-lg-between">
                    <div class="col-lg-6 col-md-10">
                        <div class="header-hero-content">
                            <h1 class="header-title wow fadeInLeftBig" data-wow-duration="2s" data-wow-delay="0.2s"><span>Launch Your
                                    App</span> With Confidence and Creative</h1>
                            <p class="text wow fadeInLeftBig" data-wow-duration="2s" data-wow-delay="0.4s">Selamat datang di Sistem Penjualan DRG. Silahkan login.</p>
                            <ul class="d-flex">
                                <li>
                                    @if (Route::has('login') && Auth::check())
                                    <a href="{{ url('/home') }}" class="main-btn wow fadeInLeftBig" data-wow-duration="2s" data-wow-delay="0.8s">Home</a>
                                    @else
                                    <a href="{{ route('login') }}" class="main-btn wow fadeInLeftBig" data-wow-duration="2s" data-wow-delay="0.8s">Login
                                        Now</a>
                                    @endif
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="header-image">
                            <img src="assets/img/header/header-app.png" alt="" class="image-1  wow fadeInRightBig" data-wow-duration="2s" data-wow-delay="0.5s">
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="header-shape-1"></div>
                <div class="header-shape-2">
                    <img src="assets/img/header/header-shape-2.svg" alt="">
                </div>
            </div>
        </div>
        <!---- home star ------>
    </header>
    <!--------   Header End ----  -->


    <!-- ---- jquery Js ---- -->
    <script src="assets/js/jquery-1.12.4.min.js"></script>
    <!-- ---------- wow js ---------- -->
    <script src="assets/js/wow.min.js"></script>
    <!-- -------- font awsome js --------- -->
    <script src="assets/js/all.js"></script>
    <!-- ---- Bootstrap Js ---- -->
    <script src="assets/js/bootstrap.min.js"></script>
    <!-- ---- main js --- -->
    <script src="assets/js/main.js"></script>
</body>

</html>