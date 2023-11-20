<!DOCTYPE html>

<html lang="en" class="light">
<!-- BEGIN: Head -->

<head>
    <meta charset="utf-8">
    <link href="{{ asset('backend/dist/images/man1.png') }}" rel="shortcut icon">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description"
        content="Midone admin is super flexible, powerful, clean & modern responsive tailwind admin template with unlimited possibilities.">
    <meta name="keywords"
        content="admin template, Midone Admin Template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="LEFT4CODE">
    <title>Forgotpassword - SIAKAD MAN 1 Kota Padang</title>
    <!-- BEGIN: CSS Assets-->
    <link rel="stylesheet" href="{{ asset('backend/dist/css/app.css') }}" />
    <!-- END: CSS Assets-->
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">
</head>
<!-- END: Head -->

<body class="login">
    <div class="container sm:px-10">
        <div class="block xl:grid grid-cols-2 gap-4">
            <!-- BEGIN: Login Info -->
            <div class="hidden xl:flex flex-col min-h-screen">
                <a href="{{ url('/') }}" class="-intro-x flex items-center pt-5">
                    <img alt="Midone - HTML Admin Template" class="w-12"
                        src="{{ asset('backend/dist/images/man1.png') }}">
                    <span class="text-white text-lg ml-3">SIAKAD MAN 1 Kota Padang </span>
                </a>
                <div class="my-auto ">
                    <img width="370px" alt="Midone - HTML Admin Template" class="-intro-x -mt-16"
                        src="{{ asset('backend/dist/images/layanan.png') }}">
                    <div class="-intro-x text-white font-medium text-4xl leading-tight mt-10">
                        Sistem Informasi Akademik
                        <br>
                        MAN 1 Kota Padang.
                    </div>
                    <div class="-intro-x mt-5 text-lg text-white text-opacity-70 dark:text-slate-400"> Menuju Sistem
                        Digital 2023</div>
                </div>
            </div>
            <!-- END: Login Info -->
            <!-- BEGIN: Login Form -->

            <div class="h-screen xl:h-auto flex py-5 xl:py-0 my-10 xl:my-0">
                <div
                    class="my-auto mx-auto xl:ml-20 bg-white dark:bg-darkmode-600 xl:bg-transparent px-5 sm:px-8 py-8 xl:p-0 rounded-md shadow-md xl:shadow-none w-full sm:w-3/4 lg:w-2/4 xl:w-auto">
                    <h2 class="intro-x font-bold text-2xl xl:text-3xl text-center xl:text-left">
                        Forgot Password
                    </h2>

                    <div class="intro-x mt-2 text-slate-400 xl:hidden text-center">A few more clicks to sign in to
                        your
                        account. Manage all your e-commerce accounts in one place</div>
                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf
                        <div class="intro-x mt-8">
                            <input type="email" id="email" name="email"
                                class="intro-x login__input form-control py-3 px-4 block" placeholder="Email">

                        </div>

                        <div class="intro-x mt-5 xl:mt-8 text-center xl:text-left">
                            <button class="btn btn-primary py-3 px-4 w-full xl:w-32 xl:mr-3 align-top"
                                type="submit">Send Email</button>
                            <a href="{{ route('login') }}"
                                class="btn btn-outline-secondary py-3 px-4 w-full xl:w-32 mt-3 xl:mt-0 align-top">
                                Login</a>
                        </div>
                    </form>
                    <div class="intro-x mt-10 xl:mt-24 text-slate-600 dark:text-slate-500 text-center xl:text-left">
                    </div>
                </div>
            </div>
            <!-- END: Login Form -->
        </div>
    </div>


    <!-- BEGIN: JS Assets-->
    <script src="{{ asset('backend/dist/js/app.js') }}"></script>

    <!-- Pastikan ini ada di halaman Anda -->
    <!-- Pastikan ini ada di halaman Anda -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <script>
        // Periksa apakah ada notifikasi dalam sesi
        @if (session('notification'))
            // Ganti properti 'alert-type' menjadi 'type'
            @php
                $notification = session('notification');
                $notification['type'] = $notification['alert-type'];
                unset($notification['alert-type']);
            @endphp

            // Tampilkan notifikasi menggunakan SweetAlert
            Swal.fire({
                text: "{{ $notification['message'] }}",
                icon: "{{ $notification['type'] }}",
            });
        @endif
    </script>

    <!-- END: JS Assets-->
</body>

</html>
