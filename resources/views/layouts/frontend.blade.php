<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=utf-8" /><!-- /Added by HTTrack -->

<head>
    <meta charset="utf-8">
    <title>Rotokemas Indonesia</title>

    <!-- Stylesheets -->
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.jpg') }}" type="image/x-icon">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <!-- Favicon -->

    <!-- Di dalam <head> -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-XyGZ1AvwLhkdME9YyUw5o2qvWZt1Qo8h1FZZbGQUFdA+cS9bYOzCXh3n4gxQ3VnTZhKLG1rKcsEtTXCvC8Ybnw==" crossorigin="anonymous" referrerpolicy="no-referrer" />


     
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">


</head>

<body>

    <div class="page-wrapper">

        <!-- preloader -->
        <div class="loader-wrap">
            <div class="preloader">
                <div class="preloader-close">x</div>
                <div id="handle-preloader" class="handle-preloader">
                    <div class="animation-preloader">
                        <div class="loader-image">
                            <img src="{{ asset('assets/images/loader.gif') }}" alt="loader">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- preloader end -->

        <!-- header -->
        <header class="main-header header-style-one">

            <!-- Header Lower -->
            <div class="header-lower">
                <div class="container">
                    <div class="inner-container d-flex align-items-center justify-content-between">
                        <div class="header-left-column">
                            <div class="logo-box">
                                <div class="logo"><a href="{{ url('/') }}"><img
                                            src="{{ asset('assets/images/logo.png') }}" alt="logo"></a></div>
                            </div>
                        </div>
                        <div class="header-center-column">
                            <div class="nav-outer">
                                <div class="mobile-nav-toggler"><img
                                        src="{{ asset('assets/images/icons/icon-bar.png') }}" alt="icon"></div>
                                <nav class="main-menu navbar-expand-md navbar-light">
                                    <div class="collapse navbar-collapse show clearfix" id="navbarSupportedContent">
                                        <ul class="navigation">
                                            <li><a href="{{ url('/') }}">Home</a></li>
                                            <li><a href="{{ url('/media') }}">Media & News</a></li>
                                            <li><a href="{{ url('/our_member') }}">Our Members</a></li>
                                            <li><a href="{{ url('/about') }}">About</a></li>
                                            <li><a href="{{ url('/contact') }}">Contact Us</a></li>

                                        </ul>
                                    </div>
                                </nav>
                            </div>
                        </div>
                        <div class="header-right-column d-flex  align-items-center">
                            <div class="header-right-btn-area">
                                @guest
                                    <a href="{{ url('login') }}" class="btn-1">Login</a>
                                    <a href="{{ url('register') }}" class="btn-1">Daftar</a>
                                @else
                                    <a href="{{ url('home') }}" class="btn-1">Member Area</a>
                                @endguest
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Header Lower -->

            <!-- sticky header -->
            <div class="sticky-header">
                <div class="header-upper">
                    <div class="container">
                        <div class="inner-container d-flex align-items-center justify-content-between">
                            <div class="left-column d-flex align-items-center">
                                <div class="logo-box">
                                    <div class="logo"><a href="{{ url('/') }}"><img
                                                src="{{ asset('assets/images/logo.png') }}" alt="logo"></a></div>
                                </div>
                            </div>

                            <div class="nav-outer gap-5 d-flex align-items-center">
                                <div class="mobile-nav-toggler"><img
                                        src="{{ asset('assets/images/icons/icon-bar.png') }}" alt="icon"></div>
                                <nav class="main-menu navbar-expand-md navbar-light"></nav>
                            </div>

                            <div class="header-right-column d-flex align-items-center">
                                <div class="header-right-btn-area">
                                    @guest
                                        <a href="{{ url('login') }}" class="btn-1">Login</a>
                                        <a href="{{ url('register') }}" class="btn-1">Daftar</a>
                                    @else
                                        <a href="{{ url('home') }}" class="btn-1">Member Area</a>
                                    @endguest
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- sticky header -->

            <!-- mobile menu -->
            <div class="mobile-menu">
                <div class="menu-backdrop"></div>
                <div class="close-btn"><span class="fal fa-times"></span></div>

                <nav class="menu-box">
                    <div class="nav-logo"><a href="{{ url('/') }}"><img
                                src="{{ asset('assets/images/logo.png') }}" alt="logo"></a></div>
                    <div class="menu-outer">
                        <!--Here Menu Will Come Automatically Via Javascript / Same Menu as in Header-->
                    </div>
                    <!--Social Links-->
                    <div class="social-links">
                        <ul class="clearfix">
                            <li><a href="#"><span class="fab fa-twitter"></span></a></li>
                            <li><a href="#"><span class="fab fa-facebook-square"></span></a></li>
                            <li><a href="#"><span class="fab fa-pinterest-p"></span></a></li>
                            <li><a href="#"><span class="fab fa-instagram"></span></a></li>
                            <li><a href="#"><span class="fab fa-youtube"></span></a></li>
                        </ul>
                    </div>
                </nav>
            </div>

        </header>
        <!-- header -->


        @yield('content')

        <!-- footer -->
        <footer id="footer" class="main-footer footer-one">
            <div class="container">
                <div class="footer-top">
                    <div class="footer-top-logo">
                        <img src="{{ asset('assets/images/logo.png') }}" alt="logo">
                    </div>
                    {{-- <div class="social-media">
                        <ul>
                            <li><a href="#0"><i class="fa-brands fa-facebook-f"></i></a></li>
                            <li><a href="#0"><i class="icon-twiter"></i></a></li>
                            <li><a href="#0"><i class="fa-brands fa-linkedin-in"></i></a></li>
                            <li><a href="#0"><i class="fa-brands fa-instagram"></i></a></li>
                        </ul>
                    </div> --}}
                </div>
                <div class="footer-widget-container">
                    <div class="row">
                        <div class="col-xl-3 col-lg-4 col-md-6">
                            <div class="footer-widget about-widget">
                                <div class="about-widget-inner">
                                    <h6 class="footer-widget-title">About</h6>
                                    <p class="text-justify">
                                        The Packaging Industry Association - Rotokemas is an organization established to support the development of the packaging industry in Indonesia, focusing on innovation, standardization, and collaboration among industry players.
                                    </p>

                                </div>
                            </div>
                        </div>
                        
                        <div class="col-xl-4 col-lg-6 col-md-8">
                            <div class="footer-widget newsletter-widget">
                                <div class="newsletter-widget-inner">
                                    <h6 class="footer-widget-title">Hubungi</h6>
                                    <div class="footer-newsletter-info">

                                        <div class="footer-contact-info">
                                            <a href="https://maps.app.goo.gl/84TH16A5Q1TZs1c2A" target="_blank"><i class="fa-light fa-location-dot" ></i>Panin Tower, 15th Floor, Senayan City, Jalan Asia Afrika Lot. 19, Jakarta Pusat, Indonesia</a>
                                            <a href="https://mail.google.com/mail/?view=cm&fs=1&to=rotokemas@gmail.com" target="_blank">
                                                <i class="fa-light fa-envelope"></i> rotokemas@gmail.com
                                              </a> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-copyright">
                <div class="container">
                    <div class="footer-copyright-content">
                        <p> &copy; 2025 Rotokemas Indonesia | Alrights reserved
                    </div>
                </div>
            </div>
        </footer>
        <!-- footer -->

    </div>


    <!--Scroll to top-->
    <div class="scroll-to-top">
        <div>
            <div class="scroll-top-inner">
                <div class="scroll-bar">
                    <div class="bar-inner"></div>
                </div>
                <div class="scroll-bar-text">Go To Top</div>
            </div>
        </div>
    </div>
    <!-- Scroll to top end -->



    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.nice-select.min.js') }}"></script>
    <script src="{{ asset('assets/js/appear.js') }}"></script>
    <script src="{{ asset('assets/js/wow.js') }}"></script>
    <script src="{{ asset('assets/js/TweenMax.min.js') }}"></script>
    <script src="{{ asset('assets/js/odometer.min.js') }}"></script>
    <script src="{{ asset('assets/js/swiper.min.js') }}"></script>
    <script src="{{ asset('assets/js/parallax-scroll.js') }}"></script>
    <script src="{{ asset('assets/js/jarallax.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.paroller.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('assets/js/isotope.js') }}"></script>
    <script src="{{ asset('assets/js/flatpickr-min.js') }}"></script>
    <script src="{{ asset('assets/js/socialSharing.js') }}"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>
    
    @stack('scripts')

</body>

</html>
