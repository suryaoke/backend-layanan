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
    <title>Register - Midone - Tailwind HTML Admin Template</title>
    <!-- BEGIN: CSS Assets-->
    <link rel="stylesheet" href="{{ asset('backend/dist/css/app.css') }}" />
    <!-- END: CSS Assets-->
</head>
<!-- END: Head -->

<body class="login">
    <div class="container sm:px-10">
        <div class="block xl:grid grid-cols-2 gap-4">
            <!-- BEGIN: Register Info -->
            <div class="hidden xl:flex flex-col min-h-screen">
                <a href="" class="-intro-x flex items-center pt-5">
                    <img alt="Midone - HTML Admin Template" class="w-12"
                        src="{{ asset('backend/dist/images/man1.png') }}">
                    <span class="text-white text-lg ml-3"> PTSP MAN 1 Kota Padang </span>
                </a>
                <div class="my-auto">
                    <img width="370px" alt="Midone - HTML Admin Template" class="-intro-x -mt-16"
                        src="{{ asset('backend/dist/images/layanan.png') }}">
                    <div class="-intro-x text-white font-medium text-4xl leading-tight mt-10">
                        PTSP MAN 1 Kota Padang.
                        <br>
                        Menuju Sistem Digital 2023
                    </div>
                    <div class="-intro-x mt-5 text-lg text-white text-opacity-70 dark:text-slate-400">Manage all your
                        e-commerce accounts in one place</div>
                </div>
            </div>
            <!-- END: Register Info -->
            <!-- BEGIN: Register Form -->

            <div class="h-screen xl:h-auto flex py-5 xl:py-0 my-10 xl:my-0">
                <div
                    class="my-auto mx-auto xl:ml-20 bg-white dark:bg-darkmode-600 xl:bg-transparent px-5 sm:px-8 py-8 xl:p-0 rounded-md shadow-md xl:shadow-none w-full sm:w-3/4 lg:w-2/4 xl:w-auto">
                    <h2 class="intro-x font-bold text-2xl xl:text-3xl text-center xl:text-left">
                        Sign Up
                    </h2>
                    <div class="intro-x mt-2 text-slate-400 dark:text-slate-400 xl:hidden text-center">A few more
                        clicks to sign in to your account. Manage all your e-commerce accounts in one place</div>
                    <div class="intro-x mt-8">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <input type="text" class="intro-x login__input form-control py-3 px-4 block"
                                placeholder=" Name" name="name" id="name">
                            <input type="text" class="intro-x login__input form-control py-3 px-4 block mt-4"
                                placeholder="UserName" name="username" id="username">
                            <input type="email" class="intro-x login__input form-control py-3 px-4 block mt-4"
                                placeholder="Email" name="email" id="email">
                            <input type="password" class="intro-x login__input form-control py-3 px-4 block mt-4"
                                placeholder="Password" name="password" id="password">
                            <input type="password" class="intro-x login__input form-control py-3 px-4 block mt-4"
                                placeholder="Password" name="password_confirmation" id="password_confirmation">
                            <input type="hidden" class="intro-x login__input form-control py-3 px-4 block mt-4"
                                value="0" name="profile_image" id="profile_image">
                            <input type="hidden" class="intro-x login__input form-control py-3 px-4 block mt-4"
                                value="0" name="role" id="role">
                            <input type="hidden" class="intro-x login__input form-control py-3 px-4 block mt-4"
                                value="0" name="jabatan" id="jabatan">
                    </div>
                    <div class="intro-x flex items-center text-slate-600 dark:text-slate-500 mt-4 text-xs sm:text-sm">
                        <input id="remember-me" type="checkbox" class="form-check-input border mr-2">
                        <label class="cursor-pointer select-none" for="remember-me">I agree to the Envato</label>
                        <a class="text-primary dark:text-slate-200 ml-1" href="">Privacy Policy</a>.
                    </div>
                    <div class="intro-x mt-5 xl:mt-8 text-center xl:text-left">
                        <button class="btn btn-primary py-3 px-4 w-full xl:w-32 xl:mr-3 align-top"
                            type="submit">Register</button>

                        <a class="btn btn-outline-secondary py-3 px-4 w-full xl:w-32 mt-3 xl:mt-0 align-top"
                            href="{{ route('login') }}">
                            Sign in</a>
                    </div>
                </div>
                </form>
            </div>

            <!-- END: Register Form -->
        </div>
    </div>


    <!-- BEGIN: JS Assets-->
    <script src="{{ asset('backend/dist/images/illustration.svg') }}dist/js/app.js"></script>
    <!-- END: JS Assets-->
</body>

</html>
