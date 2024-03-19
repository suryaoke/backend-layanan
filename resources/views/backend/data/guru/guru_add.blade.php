@extends('admin.admin_master')
@section('admin')

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script> <!-- Include jQuery Validation plugin -->

    <div class="intro-y flex items-center mt-8 mb-4">
        <h1 class="text-lg font-medium mr-auto">
            Add Guru
        </h1>
    </div>

    <form method="post" action="{{ route('guru.store') }}" enctype="multipart/form-data" id="myForm">
        @csrf
        <div class="mt-3">
            <label>Kode Guru</label>
            <input type="text" class="intro-x login__input form-control py-3 px-4 block mt-1"
                placeholder="Masukkan Kode Guru" name="kode_gr" id="kode_gr" required>
        </div>
        <div class="mt-3">
            <label>Nama</label>
            <input type="text" class="intro-x login__input form-control py-3 px-4 block mt-1" placeholder="Masukkan Nama"
                name="nama" id="nama" required>
        </div>

        <div class="mt-3">
            <label>No Hp</label>
            <input type="text" class="intro-x login__input form-control py-3 px-4 block mt-1"
                placeholder="Masukkan No HP" name="no_hp" id="no_hp" pattern="[0-9]+"
                title="Please enter only numbers" required>
        </div>

        <div class="mt-3">
            <label>Username</label>
            <input type="text" class="intro-x login__input form-control py-3 px-4 block mt-1"
                placeholder="Masukkan Username" name="username" id="username" title="Please enter only numbers" required>
        </div>


        <input value="12345678" type="hidden" class="intro-x login__input form-control py-3 px-4 block mt-1"
            placeholder="Masukkan Password" name="password" id="password">

        <input value="12345678" type="hidden" class="intro-x login__input form-control py-3 px-4 block mt-1"
            placeholder="Masukkan Password" name="password_confirmation" id="password_confirmation">



        <div class="mt-4">
            <a href="{{ route('guru.all') }}" class="btn btn-danger h-10 w-full xl:w-32 xl:mr-2 align-top">Cancel</a>
            <button class="btn btn-primary  h-10 w-full xl:w-32 xl:mr-3 align-top" type="submit">Save</button>

        </div>

    </form>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#myForm').validate({
                rules: {
                    kode_gr: {
                        required: true,
                    },
                    nama: {
                        required: true,
                    },
                    no_hp: {
                        required: true,
                        digits: true,
                    },
                    username: {
                        required: true,
                    },
                },
                messages: {
                    kode_gr: {
                        required: 'Please Enter Your Kode',
                    },
                    nama: {
                        required: 'Please Enter Your Nama',
                    },
                    no_hp: {
                        required: 'Please Enter Your No Hp',
                        digits: 'Please enter only numbers',
                    },
                    username: {
                        required: 'Please Enter Your Username',
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

@endsection
