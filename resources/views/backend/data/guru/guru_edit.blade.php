@extends('admin.admin_master')
@section('admin')
    <div class="intro-y flex items-center mt-8 mb-4">
        <h1 class="text-lg font-medium mr-auto">
            Edit Data Guru
        </h1>
    </div>

    <form method="post" action="{{ route('guru.update') }}" enctype="multipart/form-data" id="myForm">
        @csrf
        @method('PUT') <!-- Adding this line for RESTful update -->

        <input type="hidden" name="id" value="{{ $guru->id }}">
        <div class="mt-3">
            <Kode>Kode Guru</label>
                <input type="text" value="{{ $guru->kode_gr }}" class="intro-x login__input form-control py-3 px-4 block"
                    placeholder="Kode Guru" name="kode_gr" id="kode_gr">
        </div>
        <div class="mt-3">
            <label>Nama Guru</label>
            <input type="text" value="{{ $guru->nama }}" class="intro-x login__input form-control py-3 px-4 block "
                placeholder="Nama Guru" name="nama" id="nama">
        </div>
        <div class="mt-3"> <label>NIP</label>
            <input type="text" value="{{ $guru->nip }}" class="intro-x login__input form-control py-3 px-4 block "
                placeholder="NIP" name="nip" id="nip">
        </div>
        <div class="mt-3"> <label>Username Guru</label>
            <select name="username" id="username" class="form-control w-full " required>
                <option value="{{ $guru->username }}">{{ $guru->username }}</option>
            </select>
        </div>
        <div class="mt-4">
            <button class="btn btn-primary py-3 px-4 w-full xl:w-32 xl:mr-3 align-top" type="submit">Update</button>
            <a href="{{ route('guru.all') }}" class="btn btn-danger py-3 px-4 w-full xl:w-32 xl:mr-3 align-top">Cancel</a>
        </div>
    </form>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script> <!-- Include jQuery Validate plugin -->

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
                    nip: {
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
                    nip: {
                        required: 'Please Enter Your NIP',
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
