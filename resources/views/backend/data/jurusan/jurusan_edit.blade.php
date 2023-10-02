@extends('admin.admin_master')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script> <!-- Include jQuery Validation plugin -->
    <div class="intro-y flex items-center mt-8 mb-4">
        <h1 class="text-lg font-medium mr-auto">
            Edit Data Jurusan
        </h1>
    </div>

    <form method="post" action="{{ route('jurusan.update') }}" enctype="multipart/form-data" id="myForm">
        @csrf

        <input type="hidden" name="id" value="{{ $jurusan->id }}">

        <div class="mt-4">
            <label>
                Kode Jurusan
            </label>
            <input class="intro-x login__input form-control py-3 px-4 block" type="text" placeholder="Masukkan Kode Jurusan"
                name="kode_jurusan" id="kode_jurusan" value="{{ $jurusan->kode_jurusan }}" required>
        </div>

        <div class="mt-4">
            <label for=""> Nama Jurusan</label>
            <input type="text" class="intro-x login__input form-control py-3 px-4 block" placeholder="Jurusan Mulai"
                name="nama" id="nama" value="{{ $jurusan->nama }}" required>
        </div>


        <div class="mt-2">
            <button class="btn btn-primary mt-2  w-full  h-10  xl:w-32 xl:mr-3 align-top" type="submit">Update</button>
            <a class="btn btn-danger mt-2 w-full h-10 xl:w-32 xl:mr-3 align-top" href="{{ route('jurusan.all') }}">Cancel
            </a>
        </div>

    </form>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#myForm').validate({
                rules: {
                    kode_jurusan: {
                        required: true,
                    },
                    nama: {
                        required: true,
                    },
                },
                messages: {
                    kode_jurusan: {
                        required: 'Please Enter Your Kode Jurusan',
                    },
                    nama: {
                        required: 'Please Enter Your Nama',
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