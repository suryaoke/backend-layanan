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


        <input type="text" class="intro-x login__input form-control py-3 px-4 block" placeholder=" Name" name="name"
            id="name">
        <input type="text" class="intro-x login__input form-control py-3 px-4 block mt-4" placeholder="UserName"
            name="username" id="username">
        <input type="email" class="intro-x login__input form-control py-3 px-4 block mt-4" placeholder="Email"
            name="email" id="email">
        <select name="jabatan" id="jabatan" class="tom-select w-full  mt-4 " aria-label="Default select example">

            @foreach ($jabatan as $jbt)
                <option value=" {{ $jbt->id }} ">Select Jabatan : {{ $jbt->name }} </option>
            @endforeach
        </select>
        <input type="password" class="intro-x login__input form-control py-3 px-4 block mt-4" placeholder="Password"
            name="password" id="password">
        <input type="password" class="intro-x login__input form-control py-3 px-4 block mt-4" placeholder="Password"
            name="password_confirmation" id="password_confirmation">
        <input type="hidden" class="intro-x login__input form-control py-3 px-4 block mt-4" value="0"
            name="profile_image" id="profile_image">

        <select name="role" id="role" data-placeholder="Select Role" class="tom-select w-full  mt-4 ">
            <option value="0">Select Role</option>
            <option value="-">Tidak Aktif</option>
            <option value="1">Kepsek</option>
            <option value="2">Wakil Kepsek</option>
            <option value="3">Verifikator</option>
            <option value="4">Admin</option>

        </select>

        <button class="btn btn-primary mt-3 py-3 px-4 w-full xl:w-32 xl:mr-3 align-top" type="submit">Create User</button>
    </form>



    <script type="text/javascript">
        $(document).ready(function() {
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
                    jabatan: {
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
                    jabatan: {
                        required: 'Please Enter Your Jabatan',
                    },

                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
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
