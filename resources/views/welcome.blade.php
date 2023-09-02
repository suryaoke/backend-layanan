<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">

    <!--====== Title ======-->
    <title>PTSP - MAN 1 Kota Padang</title>

    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <!--====== Favicon Icon ======-->
    <link rel="shortcut icon" href="{{ asset('backend/dist/images/man1.png') }}" type="image/png">

    <!--====== Animate CSS ======-->
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/animate.css') }}">

    <!--====== Magnific Popup CSS ======-->
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/magnific-popup.css') }}">

    <!--====== Slick CSS ======-->
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/slick.css') }}">

    <!--====== Line Icons CSS ======-->
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/LineIcons.2.0.css') }}">

    <!--====== Style CSS ======-->
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/tailwind.css') }}">



    <style>
        button,
        [role="button"] {
            cursor: pointer;
        }

        button,
        [type='button'],
        [type='reset'],
        [type='submit'] {
            -webkit-appearance: button;
            background-color: transparent;
            background-image: none;
        }

        button,
        select {
            text-transform: none;
        }

        button,
        input,
        optgroup,
        select,
        textarea {
            font-family: inherit;
            font-size: 100%;
            line-height: inherit;
            color: inherit;
            margin: 0;
            padding: 0;
        }

        btn:hover:not(:disabled) {
            --tw-border-opacity: 0.9;
            --tw-bg-opacity: 0.9;
        }

        .btn:focus {
            --tw-ring-offset-shadow: var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color);
            --tw-ring-shadow: var(--tw-ring-inset) 0 0 0 calc(4px + var(--tw-ring-offset-width)) var(--tw-ring-color);
            box-shadow: var(--tw-ring-offset-shadow), var(--tw-ring-shadow), var(--tw-shadow, 0 0 #0000);
            --tw-ring-color: rgb(var(--color-primary) / var(--tw-ring-opacity));
            --tw-ring-opacity: 0.2;
        }

        .items-center {
            align-items: center;
        }

        .flex {
            display: flex;
        }

        .box {
            box-shadow: 0px 3px 20px #0000000b;
            position: relative;
            border-radius: 0.375rem;
            border-color: transparent;
            --tw-bg-opacity: 1;
            background-color: rgb(255 255 255 / var(--tw-bg-opacity));
        }

        .dropdown .dropdown-menu {
            transform: translate3d(-10000px, 0px, 0px) !important;
        }

        .dropdown-menu {
            z-index: 9999;
            inset: 0px auto auto 0px;
            transition: visibility 0s ease-in-out 0.2s, opacity 0.2s 0s;
            visibility: hidden;
            position: absolute;
            opacity: 0;
        }

        .dropdown-menu.show {
            transition: visibility 0s ease-in-out 0s, opacity 0.2s 0s;
            visibility: visible;
            opacity: 1;
        }

        .dropdown-menu.show>.dropdown-content {
            margin-top: 0.25rem;
        }

        .dropdown-menu.show>.dropdown-content .tab-content .tab-pane {
            visibility: visible;
        }

        .dropdown-menu .dropdown-content {
            transition: margin-top 0.2s;
            box-shadow: 0px 3px 10px #00000017;
            position: relative;
            margin-top: 1.25rem;
            width: 100%;
            border-radius: 0.375rem;
            padding: 0.5rem;
        }

        .dropdown-menu .dropdown-content .dropdown-header {
            padding: 0.5rem;
            font-weight: 500;
        }

        .dropdown-menu .dropdown-content .dropdown-divider {
            margin-top: 0.5rem;
            margin-bottom: 0.5rem;
            margin-left: -0.5rem;
            margin-right: -0.5rem;
        }

        .dropdown-menu .dropdown-content .dropdown-item {
            display: flex;
            align-items: center;
            border-radius: 0.375rem;
            padding: 0.5rem;
            transition-property: color, background-color, border-color, fill, stroke,
                opacity, box-shadow, transform, filter, -webkit-text-decoration-color,
                -webkit-backdrop-filter;
            transition-property: color, background-color, border-color,
                text-decoration-color, fill, stroke, opacity, box-shadow, transform,
                filter, backdrop-filter;
            transition-property: color, background-color, border-color,
                text-decoration-color, fill, stroke, opacity, box-shadow, transform,
                filter, backdrop-filter, -webkit-text-decoration-color,
                -webkit-backdrop-filter;
            transition-duration: 300ms;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        }

        .dropdown-menu .dropdown-content .dropdown-footer {
            display: flex;
            padding: 0.25rem;
        }

        .dropdown-menu .dropdown-content .tab-content .tab-pane {
            visibility: hidden;
        }

        .dropdown-content {
            --tw-bg-opacity: 1;
            background-color: rgb(255 255 255 / var(--tw-bg-opacity));
        }

        .dark .dropdown-content {
            --tw-bg-opacity: 1;
            background-color: rgb(var(--color-darkmode-600) / var(--tw-bg-opacity));
        }

        .dropdown-divider {
            border-color: rgb(var(--color-slate-200) / 0.6);
        }

        .dark .dropdown-divider {
            --tw-border-opacity: 1;
            border-color: rgb(var(--color-darkmode-400) / var(--tw-border-opacity));
        }

        .dropdown-item:hover {
            background-color: rgb(var(--color-slate-200) / 0.6);
        }

        .dark .dropdown-item {
            --tw-bg-opacity: 1;
            background-color: rgb(var(--color-darkmode-600) / var(--tw-bg-opacity));
        }

        .dark .dropdown-item:hover {
            --tw-bg-opacity: 1;
            background-color: rgb(var(--color-darkmode-400) / var(--tw-bg-opacity));
        }
    </style>

    <style>
        .modal {
            margin-top: -10000px;
            margin-left: -10000px;
            background: #000000a6;
            transition: visibility 0s linear 0.2s, opacity 0.2s 0s;
            visibility: hidden;
            position: fixed;
            left: 0px;
            top: 0px;
            height: 100vh;
            width: 100vw;
            opacity: 0;
        }

        .modal.modal-overlap {
            background: #000000a6;
        }

        .modal.modal-static .modal-content {
            -webkit-animation: modal-static-backdrop 0.3s infinite;
            animation: modal-static-backdrop 0.3s infinite;
            -webkit-animation-direction: alternate;
            animation-direction: alternate;
        }

        .modal.show {
            transition: visibility 0s ease-in-out 0s, opacity 0.4s ease-in-out 0s;
            visibility: visible;
            opacity: 1;
        }

        .modal.show>.modal-dialog {
            margin-top: 4rem;
        }

        .modal .modal-dialog {
            width: 90%;
            transition: margin-top 0.4s;
            margin-left: auto;
            margin-right: auto;
            margin-top: -4rem;
            margin-bottom: 4rem;
        }

        @media (min-width: 640px) {
            .modal .modal-dialog {
                width: 460px
            }

            .modal .modal-dialog.modal-sm {
                width: 300px;
            }

            .modal .modal-dialog.modal-lg {
                width: 600px;
            }

            .modal .modal-dialog.modal-xl {
                width: 600px;
            }
        }

        @media (min-width: 1024px) {
            .modal .modal-dialog.modal-xl {
                width: 900px;
            }
        }

        .modal .modal-dialog .modal-content {
            position: relative;
        }

        .modal .modal-dialog .modal-content>[data-tw-dismiss="modal"] {
            position: absolute;
            right: 0px;
            top: 0px;
            margin-top: 0.75rem;
            margin-right: 0.75rem;
        }

        .modal.modal-slide-over {
            overflow-x: hidden;
        }

        .modal.modal-slide-over.modal-static .modal-content {
            -webkit-animation: none;
            animation: none;
        }

        .modal.modal-slide-over.show {
            transition: visibility 0s ease-in-out 0s, opacity 0.6s ease-in-out 0s;
            visibility: visible;
            opacity: 1;
        }

        .modal.modal-slide-over.show>.modal-dialog {
            margin-right: 0px;
        }

        .modal.modal-slide-over .modal-dialog {
            margin-right: -100%;
            transition: margin-right 0.6s;
            margin-top: 0px;
            margin-bottom: 0px;
        }

        .modal.modal-slide-over .modal-dialog .modal-content {
            min-height: 100vh;
            border-radius: 0px;
        }

        .modal.modal-slide-over .modal-dialog .modal-content>[data-tw-dismiss="modal"] {
            position: absolute;
            top: 0px;
            left: 0px;
            right: auto;
            margin-top: 1rem;
            margin-left: -3rem;
        }

        .modal-content {
            position: relative;
            width: 100%;
            border-radius: 0.375rem;
            --tw-bg-opacity: 1;
            background-color: rgb(255 255 255 / var(--tw-bg-opacity));
            --tw-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            --tw-shadow-colored: 0 4px 6px -1px var(--tw-shadow-color), 0 2px 4px -2px var(--tw-shadow-color);
            box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow);
        }

        .dark .modal-content {
            --tw-bg-opacity: 1;
            background-color: rgb(var(--color-darkmode-600) / var(--tw-bg-opacity));
        }

        .modal-header {
            display: flex;
            align-items: center;
            border-bottom-width: 1px;
            border-color: rgb(var(--color-slate-200) / 0.6);
            padding-left: 1.25rem;
            padding-right: 1.25rem;
            padding-top: 0.75rem;
            padding-bottom: 0.75rem;
        }

        .dark .modal-header {
            --tw-border-opacity: 1;
            border-color: rgb(var(--color-darkmode-400) / var(--tw-border-opacity));
        }

        .modal-body {
            padding: 1.25rem;
        }

        .modal-footer {
            border-top-width: 1px;
            border-color: rgb(var(--color-slate-200) / 0.6);
            padding-left: 1.25rem;
            padding-right: 1.25rem;
            padding-top: 0.75rem;
            padding-bottom: 0.75rem;
            text-align: right;
        }

        .dark .modal-footer {
            --tw-border-opacity: 1;
            border-color: rgb(var(--color-darkmode-400) / var(--tw-border-opacity));
        }
    </style>
    <style>
        input[type=text],
        select {
            width: 100%;
            padding: 12px 20px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type=submit] {
            width: 100%;
            background-color: #4CAF50;
            color: white;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type=submit]:hover {
            background-color: #45a049;
        }

        div1 {
            border-radius: 5px;
            background-color: #f2f2f2;
            padding: 20px;
        }
    </style>
</head>

<body>

    <!--====== PRELOADER PART START ======-->

    <div class="hidden preloader">
        <div class="loader">
            <div class="ytp-spinner">
                <div class="ytp-spinner-container">
                    <div class="ytp-spinner-rotator">
                        <div class="ytp-spinner-left">
                            <div class="ytp-spinner-circle"></div>
                        </div>
                        <div class="ytp-spinner-right">
                            <div class="ytp-spinner-circle"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--====== PRELOADER PART ENDS ======-->

    <!--====== HEADER PART START ======-->

    <header class="header-area">
        <div class="navbar-area">
            <div class="container relative">
                <div class="row">
                    <div class="w-full">
                        <nav class="flex items-center justify-between navbar navbar-expand-lg">
                            <a class="mr-4 navbar-brand">
                                <img src="{{ asset('backend/dist/images/man1.png') }}" width="75px">
                            </a>
                            <button class="block navbar-toggler focus:outline-none lg:hidden" type="button"
                                data-toggle="collapse" data-target="#navbarOne" aria-controls="navbarOne"
                                aria-expanded="false" aria-label="Toggle navigation">
                                <span class="toggler-icon"></span>
                                <span class="toggler-icon"></span>
                                <span class="toggler-icon"></span>
                            </button>

                            <div class="absolute left-0 z-20 hidden w-full px-5 py-3 duration-300 bg-white shadow lg:w-auto collapse navbar-collapse lg:block top-100 mt-full lg:static lg:bg-transparent lg:shadow-none"
                                id="navbarOne">
                                <ul id="nav"
                                    class="items-center content-start mr-auto lg:justify-end navbar-nav lg:flex">
                                    <li class="nav-item ">
                                        <a class="page-scroll" href="#home">Home</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="page-scroll" href="#features">Buku Tamu Digital</a>
                                    </li>
                                    <li class="nav-item">
                                        <div class="dropdown mr-2">
                                            <button class="dropdown-toggle items-center ml-2" aria-expanded="false"
                                                data-tw-toggle="dropdown"> <a> Layanan</a></button>
                                            <div class="dropdown-menu w-40">
                                                <ul class="dropdown-content">
                                                    <li>
                                                        <a href="javascript:;" data-tw-toggle="modal"
                                                            data-tw-target="#new-order-modal"class="dropdown-item">
                                                            <span class="truncate">Surat Keterangan Siswa</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <hr class="dropdown-divider">
                                                    </li>
                                                    <li>
                                                        <a href="" class="dropdown-item"> <span
                                                                class="truncate">Legalisir Ijazah</span> </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div> <!-- navbar collapse -->
                            <div
                                class="absolute right-0 hidden mt-2 mr-24 navbar-btn sm:inline-block lg:mt-0 lg:static lg:mr-0">
                                <a class="main-btn gradient-btn" data-scroll-nav="0" href="{{ route('login') }}"
                                    rel="nofollow">Login</a>
                            </div>
                        </nav> <!-- navbar -->
                    </div>
                </div> <!-- row -->
            </div> <!-- container -->
        </div> <!-- navbar area -->

        <div id="home" class="header-hero" style="background-image: url(frontend/assets/images/banner-bg.svg)">
            <div class="container">
                <div class="justify-center row">
                    <div class="w-full lg:w-2/3">
                        <div class="pt-32 mb-4 text-center  header-hero-content">
                            <h3 class="text-4xl font-light leading-tight text-white header-sub-title wow fadeInUp"
                                data-wow-duration="1.3s" data-wow-delay="0.2s">Selamat Datang di Aplikasi <br>
                                Pelayanan
                                Terpadu Satu Pintu (PTSP)</h3>
                            <h2 class="mb-3 text-4xl font-bold text-white header-title wow fadeInUp"
                                data-wow-duration="1.3s" data-wow-delay="0.5s">MAN 1 Kota Padang</h2>
                            <a href="#" class="main-btn gradient-btn gradient-btn-2 wow fadeInUp"
                                data-wow-duration="1.3s" data-wow-delay="1.1s">Get Started</a>
                        </div> <!-- header hero content -->

                    </div>

                </div> <!-- row -->
                <div class="justify-center row">
                    <div class="w-full lg:w-2/3">
                        <div class="text-center header-hero-image wow fadeIn" data-wow-duration="1.3s"
                            data-wow-delay="1.4s">
                            <img src="{{ asset('backend/dist/images/layanan.png') }}" alt="hero">
                        </div> <!-- header hero image -->
                    </div>
                </div> <!-- row -->
            </div> <!-- container -->
            <div id="particles-1" class="particles"></div>
        </div> <!-- header hero -->
    </header>

    <!--====== HEADER PART ENDS ======-->

    <!--====== BRAMD PART START ======-->

    <div class="pt-24 brand-area">
        <div class="container">
            <div class="row">
                <div class="w-full">
                    <div class="items-center justify-center row lg:justify-between">
                        <div class="single-logo hover:opacity-100 wow fadeIn" data-wow-duration="1s"
                            data-wow-delay="0.2s">
                            <img src="{{ asset('frontend/assets/images/brand-1.png') }}" alt="brand">
                        </div> <!-- single logo -->
                        <div class="single-logo hover:opacity-100 wow fadeIn" data-wow-duration="1.5s"
                            data-wow-delay="0.2s">
                            <img src="{{ asset('frontend/assets/images/brand-2.png') }}" alt="brand">
                        </div> <!-- single logo -->
                        <div class="single-logo hover:opacity-100 wow fadeIn" data-wow-duration="1.5s"
                            data-wow-delay="0.3s">
                            <img src="{{ asset('frontend/assets/images/brand-3.png') }}" alt="brand">
                        </div> <!-- single logo -->
                        <div class="single-logo hover:opacity-100 wow fadeIn" data-wow-duration="1.5s"
                            data-wow-delay="0.4s">
                            <img src="{{ asset('frontend/assets/images/brand-4.png') }}" alt="brand">
                        </div> <!-- single logo -->
                        <div class="single-logo hover:opacity-100 wow fadeIn" data-wow-duration="1.5s"
                            data-wow-delay="0.5s">
                            <img src="{{ asset('frontend/assets/images/brand-5.png') }}" alt="brand">
                        </div> <!-- single logo -->
                    </div> <!-- brand logo -->
                </div>
            </div> <!-- row -->
        </div> <!-- container -->
    </div>

    <!--====== BRAMD PART ENDS ======-->

    <!--====== SERVICES PART START ======-->

    <section id="features" class="services-area pt-120">
        <div class="container">
            <div class="justify-center row">
                <div class="w-full lg:w-2/3">
                    <div class="pb-10 text-center section-title">
                        <div class="m-auto line"></div>
                        <h3 class="title">Clean and simple design, <span> Comes with everything you need to get
                                started!</span></h3>
                    </div> <!-- section title -->
                </div>
            </div> <!-- row -->
            <div class="justify-center row">
                <div class="w-full sm:w-2/3 lg:w-1/3">
                    <div class="single-services wow fadeIn" data-wow-duration="1s" data-wow-delay="0.2s">
                        <div class="services-icon">
                            <img class="shape" src="{{ asset('frontend/assets/images/services-shape.svg') }}"
                                alt="shape">
                            <img class="shape-1" src="{{ asset('frontend/assets/images/services-shape-1.svg') }}"
                                alt="shape">
                            <i class="lni lni-baloon"></i>
                        </div>
                        <div class="mt-8 services-content">
                            <h4 class="mb-8 text-xl font-bold text-gray-900">Clean</h4>
                            <p class="mb-8">Lorem ipsum dolor sit amet,consetetur sadipscing elitr, seddiam nonu
                                eirmod tempor invidunt labore.</p>
                            <a class="duration-300 hover:text-theme-color" href="javascript:void(0)">Learn More <i
                                    class="ml-2 lni lni-chevron-right"></i></a>
                        </div>
                    </div> <!-- single services -->
                </div>
                <div class="w-full sm:w-2/3 lg:w-1/3">
                    <div class="mt-8 text-center single-services wow fadeIn" data-wow-duration="1s"
                        data-wow-delay="0.5s">
                        <div class="services-icon">
                            <img class="shape" src="{{ asset('frontend/assets/images/services-shape.svg') }}"
                                alt="shape">
                            <img class="shape-1" src="{{ asset('frontend/assets/images/services-shape-2.svg') }}"
                                alt="shape">
                            <i class="lni lni-cog"></i>
                        </div>
                        <div class="mt-8 services-content">
                            <h4 class="mb-8 text-xl font-bold text-gray-900">Robust</h4>
                            <p class="mb-8">Lorem ipsum dolor sit amet,consetetur sadipscing elitr, seddiam nonu
                                eirmod tempor invidunt labore.</p>
                            <a class="duration-300 hover:text-theme-color" href="javascript:void(0)">Learn More <i
                                    class="ml-2 lni lni-chevron-right"></i></a>
                        </div>
                    </div> <!-- single services -->
                </div>
                <div class="w-full sm:w-2/3 lg:w-1/3">
                    <div class="mt-8 text-center single-services wow fadeIn" data-wow-duration="1s"
                        data-wow-delay="0.8s">
                        <div class="services-icon">
                            <img class="shape" src="{{ asset('frontend/assets/images/services-shape.svg') }}"
                                alt="shape">
                            <img class="shape-1" src="{{ asset('frontend/assets/images/services-shape-3.svg') }}"
                                alt="shape">
                            <i class="lni lni-bolt-alt"></i>
                        </div>
                        <div class="mt-8 services-content">
                            <h4 class="mb-8 text-xl font-bold text-gray-900">Powerful</h4>
                            <p class="mb-8">Lorem ipsum dolor sit amet,consetetur sadipscing elitr, seddiam nonu
                                eirmod tempor invidunt labore.</p>
                            <a class="duration-300 hover:text-theme-color" href="javascript:void(0)">Learn More <i
                                    class="ml-2 lni lni-chevron-right"></i></a>
                        </div>
                    </div> <!-- single services -->
                </div>
            </div> <!-- row -->
        </div> <!-- container -->
    </section>

    <!--====== SERVICES PART ENDS ======-->

    <!--====== ABOUT PART START ======-->

    <section id="about" class="relative pt-20 about-area">
        <div class="container">
            <div class="row">
                <div class="w-full lg:w-1/2">
                    <div class="mx-4 mt-12 about-content wow fadeInLeftBig" data-wow-duration="1s"
                        data-wow-delay="0.5s">
                        <div class="mb-4 section-title">
                            <div class="line"></div>
                            <h3 class="title">Quick & Easy <span>to Use Tailwind Template</span></h3>
                        </div> <!-- section title -->
                        <p class="mb-8">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, seiam nonumy eirmod
                            tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et
                            accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus
                            est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing.</p>
                        <a href="javascript:void(0)" class="main-btn gradient-btn">Try it
                            Free</a>
                    </div> <!-- about content -->
                </div>
                <div class="w-full lg:w-1/2">
                    <div class="mx-4 mt-12 text-center about-image wow fadeInRightBig" data-wow-duration="1s"
                        data-wow-delay="0.5s">
                        <img src="{{ asset('frontend/assets/images/about1.svg') }}" alt="about">
                    </div> <!-- about image -->
                </div>
            </div> <!-- row -->
        </div> <!-- container -->
        <div class="about-shape-1">
            <img src="{{ asset('frontend/assets/images/about-shape-1.svg') }}" alt="shape">
        </div>
    </section>

    <!--====== ABOUT PART ENDS ======-->

    <!--====== ABOUT PART START ======-->

    <section class="relative pt-20 about-area">
        <div class="about-shape-2">
            <img src="{{ asset('frontend/assets/images/about-shape-2.svg') }}" alt="shape">
        </div>
        <div class="container">
            <div class="row">
                <div class="w-full lg:w-1/2 lg:order-last">
                    <div class="mx-4 mt-12 about-content wow fadeInLeftBig" data-wow-duration="1s"
                        data-wow-delay="0.5s">
                        <div class="mb-4 section-title">
                            <div class="line"></div>
                            <h3 class="title">Modern design <span> with Essential Features</span></h3>
                        </div> <!-- section title -->
                        <p class="mb-8">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, seiam nonumy eirmod
                            tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et
                            accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus
                            est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing.</p>
                        <a href="javascript:void(0)" class="main-btn gradient-btn">Try it
                            Free</a>
                    </div> <!-- about content -->
                </div>
                <div class="w-full lg:w-1/2 lg:order-first">
                    <div class="mx-4 mt-12 text-center about-image wow fadeInRightBig" data-wow-duration="1s"
                        data-wow-delay="0.5s">
                        <img src="{{ asset('frontend/assets/images/about2.svg') }}" alt="about">
                    </div> <!-- about image -->
                </div>
            </div> <!-- row -->
        </div> <!-- container -->
    </section>


    <!--====== ABOUT PART START ======-->

    <section class="relative pt-20 about-area">
        <div class="container">
            <div class="row">
                <div class="w-full lg:w-1/2">
                    <div class="mx-4 mt-12 about-content wow fadeInLeftBig" data-wow-duration="1s"
                        data-wow-delay="0.5s">
                        <div class="mb-4 section-title">
                            <div class="line"></div>
                            <h3 class="title"><span>Crafted for</span> SaaS, App and Software Landing Page</h3>
                        </div> <!-- section title -->
                        <p class="mb-8">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, seiam nonumy eirmod
                            tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et
                            accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus
                            est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing.</p>
                        <a href="javascript:void(0)" class="main-btn gradient-btn">Try it
                            Free</a>
                    </div> <!-- about content -->
                </div>
                <div class="w-full lg:w-1/2">
                    <div class="mx-4 mt-12 text-center about-image wow fadeInRightBig" data-wow-duration="1s"
                        data-wow-delay="0.5s">
                        <img src="{{ asset('frontend/assets/images/about3.svg') }}" alt="about">
                    </div> <!-- about image -->
                </div>
            </div> <!-- row -->
        </div> <!-- container -->
        <div class="about-shape-1">
            <img src="{{ asset('frontend/assets/images/about-shape-1.svg') }}" alt="shape">
        </div>
    </section>

    <!--====== ABOUT PART ENDS ======-->


    <!--====== ABOUT PART ENDS ======-->

    <!--====== VIDEO COUNTER PART START ======-->

    <section id="facts" class="pt-20 video-counter">
        <div class="container">
            <div class="row">
                <div class="w-full lg:w-1/2">
                    <div class="relative pb-8 mt-12 video-content wow fadeIn" data-wow-duration="1s"
                        data-wow-delay="0.5s">
                        <img class="absolute bottom-0 left-0 -ml-8 dots"
                            src="{{ asset('frontend/assets/images/dots.svg') }}" alt="dots">
                        <div class="relative mr-6 rounded-lg shadow-md video-wrapper">
                            <div class="video-image">
                                <img src="{{ asset('frontend/assets/images/video.png') }}" alt="video">
                            </div>
                            <div
                                class="absolute top-0 left-0 flex items-center justify-center w-full h-full bg-blue-900 bg-opacity-25 rounded-lg video-icon">
                                <a href="https://www.youtube.com/watch?v=r44RKWyfcFw" class="video-popup"><i
                                        class="lni lni-play"></i></a>
                            </div>
                        </div> <!-- video wrapper -->
                    </div> <!-- video content -->
                </div>
                <div class="w-full lg:w-1/2">
                    <div class="pl-0 mt-12 counter-wrapper lg:pl-16 wow fadeIn" data-wow-duration="1s"
                        data-wow-delay="0.8s">
                        <div class="counter-content">
                            <div class="mb-8 section-title">
                                <div class="line"></div>
                                <h3 class="title">Cool facts <span> about this app</span></h3>
                            </div> <!-- section title -->
                            <p class="text">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, seiam nonumy
                                eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.</p>
                        </div> <!-- counter content -->
                        <div class="row no-gutters">
                            <div class="flex items-center justify-center single-counter counter-color-1">
                                <div class="text-center counter-items">
                                    <span class="text-2xl font-bold text-white"><span
                                            class="counter">125</span>K</span>
                                    <p class="text-white">Downloads</p>
                                </div>
                            </div> <!-- single counter -->
                            <div class="flex items-center justify-center single-counter counter-color-2">
                                <div class="text-center counter-items">
                                    <span class="text-2xl font-bold text-white"><span
                                            class="counter">87</span>K</span>
                                    <p class="text-white">Active Users</p>
                                </div>
                            </div> <!-- single counter -->
                            <div class="flex items-center justify-center single-counter counter-color-3">
                                <div class="text-center counter-items">
                                    <span class="text-2xl font-bold text-white"><span
                                            class="counter">4.8</span></span>
                                    <p class="text-white">User Rating</p>
                                </div>
                            </div> <!-- single counter -->
                        </div> <!-- row -->
                    </div> <!-- counter wrapper -->
                </div>
            </div> <!-- row -->
        </div> <!-- container -->
    </section>

    <!--====== VIDEO COUNTER PART ENDS ======-->

    <!--====== TEAM PART START ======-->

    <section id="team" class="team-area pt-120">
        <div class="container">
            <div class="justify-center row">
                <div class="w-full lg:w-2/3">
                    <div class="pb-8 text-center section-title">
                        <div class="m-auto line"></div>
                        <h3 class="title"><span>Meet Our</span> Creative Team Members</h3>
                    </div> <!-- section title -->
                </div>
            </div> <!-- row -->
            <div class="justify-center row">
                <div class="w-full sm:w-2/3 lg:w-1/3">
                    <div class="mt-8 text-center single-team wow fadeIn" data-wow-duration="1s"
                        data-wow-delay="0.2s">
                        <div class="relative team-image">
                            <img class="w-full" src="{{ asset('frontend/assets/images/team-1.png') }}"
                                alt="Team">
                            <div class="team-social">
                                <ul>
                                    <li><a href="javascript:void(0)"><i class="lni lni-facebook-filled"></i></a></li>
                                    <li><a href="javascript:void(0)"><i class="lni lni-twitter-filled"></i></a></li>
                                    <li><a href="javascript:void(0)"><i class="lni lni-instagram-filled"></i></a></li>
                                    <li><a href="javascript:void(0)"><i class="lni lni-linkedin-original"></i></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="p-8">
                            <h5 class="mb-1 text-xl font-bold text-gray-900">Isabela Moreira</h5>
                            <p>Founder and CEO</p>
                        </div>
                    </div> <!-- single team -->
                </div>
                <div class="w-full sm:w-2/3 lg:w-1/3">
                    <div class="mt-8 text-center single-team wow fadeIn" data-wow-duration="1s"
                        data-wow-delay="0.5s">
                        <div class="relative team-image">
                            <img class="w-full" src="{{ asset('frontend/assets/images/team-2.png') }}"
                                alt="Team">
                            <div class="team-social">
                                <ul>
                                    <li><a href="javascript:void(0)"><i class="lni lni-facebook-filled"></i></a></li>
                                    <li><a href="javascript:void(0)"><i class="lni lni-twitter-filled"></i></a></li>
                                    <li><a href="javascript:void(0)"><i class="lni lni-instagram-filled"></i></a></li>
                                    <li><a href="javascript:void(0)"><i class="lni lni-linkedin-original"></i></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="p-8">
                            <h5 class="mb-1 text-xl font-bold text-gray-900">Elon Musk</h5>
                            <p>Sr. Software Engineer</p>
                        </div>
                    </div> <!-- single team -->
                </div>
                <div class="w-full sm:w-2/3 lg:w-1/3">
                    <div class="mt-8 text-center single-team wow fadeIn" data-wow-duration="1s"
                        data-wow-delay="0.8s">
                        <div class="relative team-image">
                            <img class="w-full" src="assets/images/team-3.png" alt="Team">
                            <div class="team-social">
                                <ul>
                                    <li><a href="javascript:void(0)"><i class="lni lni-facebook-filled"></i></a></li>
                                    <li><a href="javascript:void(0)"><i class="lni lni-twitter-filled"></i></a></li>
                                    <li><a href="javascript:void(0)"><i class="lni lni-instagram-filled"></i></a></li>
                                    <li><a href="javascript:void(0)"><i class="lni lni-linkedin-original"></i></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="p-8">
                            <h5 class="mb-1 text-xl font-bold text-gray-900">Fiona Smith</h5>
                            <p>Business Development Manager</p>
                        </div>
                    </div> <!-- single team -->
                </div>
            </div> <!-- row -->
        </div> <!-- container -->
    </section>

    <!--====== TEAM PART ENDS ======-->

    <!--====== TESTIMONIAL PART START ======-->

    <section id="testimonial" class="testimonial-area pt-120">
        <div class="container">
            <div class="justify-center row">
                <div class="w-full lg:w-2/3">
                    <div class="pb-10 text-center section-title">
                        <div class="m-auto line"></div>
                        <h3 class="title">Users sharing<span> their experience</span></h3>
                    </div> <!-- section title -->
                </div>
            </div> <!-- row -->
            <div class="row testimonial-active wow fadeInUpBig" data-wow-duration="1s" data-wow-delay="0.8s">
                <div class="w-full lg:w-1/3">
                    <div class="single-testimonial">
                        <div class="flex items-center justify-between mb-6">
                            <div class="quota">
                                <i class="text-4xl duration-300 lni lni-quotation text-theme-color"></i>
                            </div>
                            <div class="star">
                                <ul class="flex">
                                    <li><i class="lni lni-star-filled text-theme-color-2"></i></li>
                                    <li><i class="lni lni-star-filled text-theme-color-2"></i></li>
                                    <li><i class="lni lni-star-filled text-theme-color-2"></i></li>
                                    <li><i class="lni lni-star-filled text-theme-color-2"></i></li>
                                    <li><i class="lni lni-star-filled text-theme-color-2"></i></li>
                                </ul>
                            </div>
                        </div>
                        <div class="mb-8">
                            <p>Lorem ipsum dolor sit amet,consetetur sadipscing elitr, seddiam nonu eirmod tempor
                                invidunt labore.Lorem ipsum dolor sit amet,consetetur sadipscing elitr, seddiam nonu.
                            </p>
                        </div>
                        <div class="flex items-center testimonial-author">
                            <div class="relative author-image">
                                <img class="shape" src="assets/images/textimonial-shape.svg" alt="shape">
                                <img class="author" src="assets/images/author-1.png" alt="author">
                            </div>
                            <div class="author-content media-body">
                                <h6 class="mb-1 text-xl font-bold text-gray-900">Jenny Deo</h6>
                                <p>CEO, SpaceX</p>
                            </div>
                        </div>
                    </div> <!-- single testimonial -->
                </div>
                <div class="col-lg-4">
                    <div class="single-testimonial">
                        <div class="flex items-center justify-between mb-6">
                            <div class="quota">
                                <i class="text-4xl duration-300 lni lni-quotation text-theme-color"></i>
                            </div>
                            <div class="star">
                                <ul class="flex">
                                    <li><i class="lni lni-star-filled text-theme-color-2"></i></li>
                                    <li><i class="lni lni-star-filled text-theme-color-2"></i></li>
                                    <li><i class="lni lni-star-filled text-theme-color-2"></i></li>
                                    <li><i class="lni lni-star-filled text-theme-color-2"></i></li>
                                    <li><i class="lni lni-star-filled text-theme-color-2"></i></li>
                                </ul>
                            </div>
                        </div>
                        <div class="mb-8">
                            <p>Lorem ipsum dolor sit amet,consetetur sadipscing elitr, seddiam nonu eirmod tempor
                                invidunt labore.Lorem ipsum dolor sit amet,consetetur sadipscing elitr, seddiam nonu.
                            </p>
                        </div>
                        <div class="flex items-center testimonial-author">
                            <div class="relative author-image">
                                <img class="shape" src="assets/images/textimonial-shape.svg" alt="shape">
                                <img class="author" src="assets/images/author-2.png" alt="author">
                            </div>
                            <div class="author-content media-body">
                                <h6 class="mb-1 text-xl font-bold text-gray-900">Marjin Otte</h6>
                                <p>UX Specialist, Yoast</p>
                            </div>
                        </div>
                    </div> <!-- single testimonial -->
                </div>
                <div class="col-lg-4">
                    <div class="single-testimonial">
                        <div class="flex items-center justify-between mb-6">
                            <div class="quota">
                                <i class="text-4xl duration-300 lni lni-quotation text-theme-color"></i>
                            </div>
                            <div class="star">
                                <ul class="flex">
                                    <li><i class="lni lni-star-filled text-theme-color-2"></i></li>
                                    <li><i class="lni lni-star-filled text-theme-color-2"></i></li>
                                    <li><i class="lni lni-star-filled text-theme-color-2"></i></li>
                                    <li><i class="lni lni-star-filled text-theme-color-2"></i></li>
                                    <li><i class="lni lni-star-filled text-theme-color-2"></i></li>
                                </ul>
                            </div>
                        </div>
                        <div class="mb-8">
                            <p>Lorem ipsum dolor sit amet,consetetur sadipscing elitr, seddiam nonu eirmod tempor
                                invidunt labore.Lorem ipsum dolor sit amet,consetetur sadipscing elitr, seddiam nonu.
                            </p>
                        </div>
                        <div class="flex items-center testimonial-author">
                            <div class="relative author-image">
                                <img class="shape" src="assets/images/textimonial-shape.svg" alt="shape">
                                <img class="author" src="assets/images/author-3.png" alt="author">
                            </div>
                            <div class="author-content media-body">
                                <h6 class="mb-1 text-xl font-bold text-gray-900">David Smith</h6>
                                <p>CTO, Alphabet</p>
                            </div>
                        </div>
                    </div> <!-- single testimonial -->
                </div>
                <div class="col-lg-4">
                    <div class="single-testimonial">
                        <div class="flex items-center justify-between mb-6">
                            <div class="quota">
                                <i class="text-4xl duration-300 lni lni-quotation text-theme-color"></i>
                            </div>
                            <div class="star">
                                <ul class="flex">
                                    <li><i class="lni lni-star-filled text-theme-color-2"></i></li>
                                    <li><i class="lni lni-star-filled text-theme-color-2"></i></li>
                                    <li><i class="lni lni-star-filled text-theme-color-2"></i></li>
                                    <li><i class="lni lni-star-filled text-theme-color-2"></i></li>
                                    <li><i class="lni lni-star-filled text-theme-color-2"></i></li>
                                </ul>
                            </div>
                        </div>
                        <div class="mb-8">
                            <p>Lorem ipsum dolor sit amet,consetetur sadipscing elitr, seddiam nonu eirmod tempor
                                invidunt labore.Lorem ipsum dolor sit amet,consetetur sadipscing elitr, seddiam nonu.
                            </p>
                        </div>
                        <div class="flex items-center testimonial-author">
                            <div class="relative author-image">
                                <img class="shape" src="assets/images/textimonial-shape.svg" alt="shape">
                                <img class="author" src="assets/images/author-2.png" alt="author">
                            </div>
                            <div class="author-content media-body">
                                <h6 class="mb-1 text-xl font-bold text-gray-900">Fajar Siddiq</h6>
                                <p>COO, MakerFlix</p>
                            </div>
                        </div>
                    </div> <!-- single testimonial -->
                </div>
            </div> <!-- row -->
        </div> <!-- container -->
    </section>

    <!--====== TESTIMONIAL PART ENDS ======-->

    <!--====== BLOG PART START ======-->

    <section id="blog" class="blog-area pt-120">
        <div class="container">
            <div class="row">
                <div class="w-full lg:w-1/2">
                    <div class="pb-8 section-title">
                        <div class="line"></div>
                        <h3 class="title"><span>Our Recent</span> Blog Posts</h3>
                    </div> <!-- section title -->
                </div>
            </div> <!-- row -->
            <div class="justify-center row">
                <div class="w-full md:w-2/3 lg:w-1/3">
                    <div class="mx-4 mt-10 single-blog wow fadeIn" data-wow-duration="1s" data-wow-delay="0.2s">
                        <div class="mb-5 overflow-hidden blog-image rounded-xl">
                            <img class="w-full" src="assets/images/blog-1.jpg" alt="blog">
                        </div>
                        <div class="blog-content">
                            <ul class="flex mb-5 meta">
                                <li>Posted By: <a href="javascript:void(0)">Admin</a></li>
                                <li class="ml-12">03 June, 2023</li>
                            </ul>
                            <p class="mb-6 text-2xl leading-snug text-gray-900">Lorem ipsuamet conset sadips cing elitr
                                seddiam nonu eirmod tempor invidunt labore.</p>
                            <a class="text-theme-color-2" href="javascript:void(0)">
                                Learn More
                                <i class="ml-2 lni lni-chevron-right"></i>
                            </a>
                        </div>
                    </div> <!-- single blog -->
                </div>
                <div class="w-full md:w-2/3 lg:w-1/3">
                    <div class="mx-4 mt-10 single-blog wow fadeIn" data-wow-duration="1s" data-wow-delay="0.5s">
                        <div class="mb-5 overflow-hidden blog-image rounded-xl">
                            <img class="w-full" src="assets/images/blog-2.jpg" alt="blog">
                        </div>
                        <div class="blog-content">
                            <ul class="flex mb-5 meta">
                                <li>Posted By: <a href="javascript:void(0)">Admin</a></li>
                                <li class="ml-12">03 June, 2023</li>
                            </ul>
                            <p class="mb-6 text-2xl leading-snug text-gray-900">Lorem ipsuamet conset sadips cing elitr
                                seddiam nonu eirmod tempor invidunt labore.</p>
                            <a class="text-theme-color-2" href="javascript:void(0)">
                                Learn More
                                <i class="ml-2 lni lni-chevron-right"></i>
                            </a>
                        </div>
                    </div> <!-- single blog -->
                </div>
                <div class="w-full md:w-2/3 lg:w-1/3">
                    <div class="mx-4 mt-10 single-blog wow fadeIn" data-wow-duration="1s" data-wow-delay="0.8s">
                        <div class="mb-5 overflow-hidden blog-image rounded-xl">
                            <img class="w-full" src="assets/images/blog-3.jpg" alt="blog">
                        </div>
                        <div class="blog-content">
                            <ul class="flex mb-5 meta">
                                <li>Posted By: <a href="javascript:void(0)">Admin</a></li>
                                <li class="ml-12">03 June, 2023</li>
                            </ul>
                            <p class="mb-6 text-2xl leading-snug text-gray-900">Lorem ipsuamet conset sadips cing elitr
                                seddiam nonu eirmod tempor invidunt labore.</p>
                            <a class="text-theme-color-2" href="javascript:void(0)">
                                Learn More
                                <i class="ml-2 lni lni-chevron-right"></i>
                            </a>
                        </div>
                    </div> <!-- single blog -->
                </div>
            </div> <!-- row -->
        </div> <!-- container -->
    </section>

    <!--====== BLOG PART ENDS ======-->

    <!--====== FOOTER PART START ======-->

    <footer id="footer" class="relative z-10 footer-area pt-120">
        <div class="footer-bg" style="background-image: url(frontend/assets/images/footer-bg.svg);"></div>
        <div class="container">
            <div class="px-6 pt-10 pb-20 mb-12 bg-white rounded-lg shadow-xl md:px-12 subscribe-area wow fadeIn"
                data-wow-duration="1s" data-wow-delay="0.5s">
                <div class="row">
                    <div class="w-full lg:w-1/2">
                        <div class="lg:mt-12 subscribe-content">
                            <h2 class="text-2xl font-bold sm:text-4xl subscribe-title">
                                Subscribe Our Newsletter
                                <span class="block font-normal">get reguler updates</span>
                            </h2>
                        </div>
                    </div>
                    <div class="w-full lg:w-1/2">
                        <div class="mt-12 subscribe-form">
                            <form action="#" class="relative focus:outline-none">
                                <input type="email" placeholder="Enter eamil"
                                    class="w-full py-4 pl-6 pr-40 duration-300 border-2 rounded focus:border-theme-color focus:outline-none">
                                <button class="main-btn gradient-btn">Subscribe</button>
                            </form>
                        </div>
                    </div>
                </div> <!-- row -->
            </div> <!-- subscribe area -->
            <div class="footer-widget pb-120">
                <div class="row">
                    <div class="w-4/5 md:w-3/5 lg:w-2/6">
                        <div class="mt-12 footer-about wow fadeIn" data-wow-duration="1s" data-wow-delay="0.2s">
                            <a class="inline-block mb-8 logo">
                                <img src="assets/images/logo.svg" alt="logo" class="w-40">
                            </a>
                            <p class="pb-10 pr-10 leading-snug text-white">Lorem ipsum dolor sit amet consetetur
                                sadipscing elitr, sederfs diam nonumy eirmod tempor invidunt ut labore et dolore magna
                                aliquyam.</p>
                            <ul class="flex footer-social">
                                <li><a href="javascript:void(0)"><i class="lni lni-facebook-filled"></i></a></li>
                                <li><a href="javascript:void(0)"><i class="lni lni-twitter-filled"></i></a></li>
                                <li><a href="javascript:void(0)"><i class="lni lni-instagram-filled"></i></a></li>
                                <li><a href="javascript:void(0)"><i class="lni lni-linkedin-original"></i></a></li>
                            </ul>
                        </div> <!-- footer about -->
                    </div>
                    <div class="w-4/5 sm:w-2/3 md:w-3/5 lg:w-2/6">
                        <div class="row">
                            <div class="w-full sm:w-1/2 md:w-1/2 lg:w-1/2">
                                <div class="mt-12 link-wrapper wow fadeIn" data-wow-duration="1s"
                                    data-wow-delay="0.4s">
                                    <div class="footer-title">
                                        <h4 class="mb-8 text-2xl font-bold text-white">Quick Link</h4>
                                    </div>
                                    <ul class="link">
                                        <li><a href="javascript:void(0)">Road Map</a></li>
                                        <li><a href="javascript:void(0)">Privacy Policy</a>
                                        </li>
                                        <li><a href="javascript:void(0)">Refund Policy</a>
                                        </li>
                                        <li><a href="javascript:void(0)">Terms of Service</a>
                                        </li>
                                        <li><a href="javascript:void(0)">Pricing</a></li>
                                    </ul>
                                </div> <!-- footer wrapper -->
                            </div>
                            <div class="w-full sm:w-1/2 md:w-1/2 lg:w-1/2">
                                <div class="mt-12 link-wrapper wow fadeIn" data-wow-duration="1s"
                                    data-wow-delay="0.6s">
                                    <div class="footer-title">
                                        <h4 class="mb-8 text-2xl font-bold text-white">Resources</h4>
                                    </div>
                                    <ul class="link">
                                        <li><a href="javascript:void(0)">Home</a></li>
                                        <li><a href="javascript:void(0)">Page</a></li>
                                        <li><a href="javascript:void(0)">Portfolio</a></li>
                                        <li><a href="javascript:void(0)">Blog</a></li>
                                        <li><a href="javascript:void(0)">Contact</a></li>
                                    </ul>
                                </div> <!-- footer wrapper -->
                            </div>
                        </div>
                    </div>
                    <div class="w-4/5 sm:w-1/3 md:w-2/5 lg:w-2/6">
                        <div class="mt-12 footer-contact wow fadeIn" data-wow-duration="1s" data-wow-delay="0.8s">
                            <div class="footer-title">
                                <h4 class="mb-8 text-2xl font-bold text-white">Contact Us</h4>
                            </div>
                            <ul class="contact">
                                <li>+809272561823</li>
                                <li>info@gmail.com</li>
                                <li>www.yourweb.com</li>
                                <li>123 Stree New York City , United <br> States Of America 750.</li>
                            </ul>
                        </div> <!-- footer contact -->
                    </div>
                </div> <!-- row -->
            </div> <!-- footer widget -->
            <div class="py-8 border-t border-gray-200 footer-copyright">
                <p class="text-white">
                    Template by <a class="duration-300 hover:text-theme-color-2" href="https://tailwindtemplates.co"
                        rel="nofollow" target="_blank">TailwindTemplates</a> and
                    <a class="duration-300 hover:text-theme-color-2" href="https://uideck.com" rel="nofollow"
                        target="_blank">UIdeck</a>
                </p>
            </div> <!-- footer copyright -->
        </div> <!-- container -->
        <div id="particles-2" class="particles"></div>
    </footer>
    <!-- BEGIN: New Order Modal -->
    <div id="new-order-modal" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto">
                        New Order
                    </h2>
                </div>
                <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                    <div class="col-span-12">
                        <label for="pos-form-1" class="form-label">Name</label>
                        <input id="pos-form-1" type="text" class="form-control flex-1"
                            placeholder="Customer name">
                    </div>
                    <div class="col-span-12">
                        <label for="pos-form-2" class="form-label">Table</label>
                        <input id="pos-form-2" type="text" class="form-control flex-1"
                            placeholder="Customer table">
                    </div>
                    <div class="col-span-12">
                        <label for="pos-form-3" class="form-label">Number of People</label>
                        <input id="pos-form-3" type="text" class="form-control flex-1" placeholder="People">
                    </div>
                </div>

                <input name="tgl_surat" id="tgl_surat" type="text" class="datepicker col-span-4 form-control "
                    data-single-mode="true">

                <div class="modal-footer text-right">
                    <button type="button" data-tw-dismiss="modal"
                        class="btn btn-outline-secondary w-32 mr-1">Cancel</button>
                    <button type="button" class="btn btn-primary w-32">Create Ticket</button>
                </div>
            </div>
        </div>
    </div>
    <!-- END: New Order Modal -->
    <!--====== FOOTER PART ENDS ======-->

    <!--====== BACK TOP TOP PART START ======-->

    <a href="#" class="back-to-top"><i class="lni lni-chevron-up"></i></a>

    <!--====== BACK TOP TOP PART ENDS ======-->

    <!--====== PART START ======-->

    <!--
    <section class="">
        <div class="container">
            <div class="row">
                <div class="col-lg-"></div>
            </div>
        </div>
    </section>
-->

    <!--====== PART ENDS ======-->

    <script src="  {{ asset('backend/dist/js/app.js') }} "></script>


    <!--====== Jquery js ======-->
    <script src="{{ asset('frontend/assets/js/vendor/jquery-3.5.1-min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/vendor/modernizr-3.7.1.min.js') }}"></script>

    <!--====== Plugins js ======-->
    <script src="{{ asset('frontend/assets/js/plugins.js') }}"></script>

    <!--====== Slick js ======-->
    <script src="{{ asset('frontend/assets/js/slick.min.js') }}"></script>

    <!--====== Scrolling Nav js ======-->
    <script src="{{ asset('frontend/assets/js/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/scrolling-nav.js') }}"></script>

    <!--====== wow js ======-->
    <script src="{{ asset('frontend/assets/js/wow.min.js') }}"></script>

    <!--====== Particles js ======-->
    <script src="{{ asset('frontend/assets/js/particles.min.js') }}"></script>

    <!--====== Main js ======-->
    <script src="{{ asset('frontend/assets/js/main.js') }}"></script>


</body>

</html>
