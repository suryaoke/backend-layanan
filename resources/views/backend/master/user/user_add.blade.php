@extends('admin.admin_master')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <div class="intro-y flex items-center mt-8 mb-4">
        <h1 class="text-lg font-medium mr-auto">
            Add User
        </h1>
    </div>

    <form method="POST" id="myForm" action="{{ route('user.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="mt-4">
            <label for="">Nama </label>
            <input type="text" class="intro-x login__input form-control py-3 px-4 block mt-1" placeholder="Masukkan Nama"
                name="name" id="name">
        </div>

        <div class="mt-4">
            <label for=""> Username</label>
            <input type="text" class="intro-x login__input form-control py-3 px-4 block mt-1 "
                placeholder="Masukkan UserName" name="username" id="username">
        </div>

        <div class="mt-4">
            <label for=""> Email</label>
            <input type="email" class="intro-x login__input form-control py-3 px-4 block mt-1"
                placeholder="Masukkan Email" name="email" id="email">
        </div>

        <div class="mt-4">
            <label for=""> Password</label>
            <input type="password" class="intro-x login__input form-control py-3 px-4 block mt-1"
                placeholder="Masukkan Password" name="password" id="password">
        </div>

        <div class="mt-4">
            <label for=""> Password</label>
            <input type="password" class="intro-x login__input form-control py-3 px-4 block mt-1"
                placeholder="Masukkan Password" name="password_confirmation" id="password_confirmation">
        </div>

        <input type="hidden" class="intro-x login__input form-control py-3 px-4 block mt-1" value="0"
            name="profile_image" id="profile_image">
        <input type="hidden" name="status" value="1">

        <div class="mt-4">
            <label for=""> Role</label>
            <select name="role" id="role" data-placeholder="Select Role" class="tom-select w-full mt-1">
                <option value="">Pilih Role</option>
                <option value="1">Admin</option>
                <option value="2">Kepsek</option>
                <option value="3">Operator</option>
                <option value="4">Guru</option>
                <option value="5">Orang Tua</option>
                <option value="6">Siswa</option>
            </select>
        </div>
        <div class="mt-4">
            <button class="btn btn-primary  w-full  h-10 xl:w-32 xl:mr-3 align-top mb-1" type="submit">Save </button>

            <a href="{{ route('user.all') }}" class="btn btn-danger w-full h-10 xl:w-32 xl:mr-3 align-top "
                type="submit">Cancel</a>

        </div>

    </form>

    <script type="text/javascript">
        jQuery(document).ready(function() {
            $('#myForm').validate({
                rules: {
                    name: {
                        required: true,
                    },
                    email: {
                        required: true,
                    },
                    username: {
                        required: true,
                    },
                    role: {
                        required: true,
                    },
                    password: {
                        required: true,
                    },
                    password_confirmation: {
                        required: true,
                    },


                },
                messages: {
                    name: {
                        required: 'Please Enter Your Name',
                    },
                    email: {
                        required: 'Please Enter Your Email',
                    },
                    username: {
                        required: 'Please Enter Your Username',
                    },
                    role: {
                        required: 'Please Enter Your Role',
                    },
                    password: {
                        required: 'Please Enter Your Password',
                    },
                    password_confirmation: {
                        required: 'Please Enter Your Password Konfirmasi',
                    },
                },
                errorElement: 'span',
                errorClass: 'invalid-feedback',
                errorPlacement: function(error, element) {
                    error.insertAfter(element);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                },
            });
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#image').change(function(e) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#showImage').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            });
        });
    </script>
@endsection
