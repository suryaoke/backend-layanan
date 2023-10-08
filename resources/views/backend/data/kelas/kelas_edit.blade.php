@extends('admin.admin_master')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script> <!-- Include jQuery Validation plugin -->
    <div class="intro-y flex items-center mt-8 mb-4">
        <h1 class="text-lg font-medium mr-auto">
            Edit Data Kelas
        </h1>
    </div>

    <form method="post" action="{{ route('kelas.update') }}" enctype="multipart/form-data" id="myForm">
        @csrf

        <input type="hidden" name="id" value="{{ $kelas->id }}">
        <div class="form-group mt-3">
            <label for="username" class="mb-2">Nama</label>
            <input type="text" name="nama" id="nama" value="{{ $kelas->nama }}"
                class="intro-x login__input form-control py-3 px-4 block ">
        </div>
        <div class="mt-4">
            <button class="btn btn-primary  h-10 w-full xl:w-32 xl:mr-3 align-top" type="submit">Save</button>
            <a href="{{ route('kelas.all') }}" class="btn btn-danger h-10 w-full xl:w-32 xl:mr-3 align-top">Cancel</a>
        </div>

    </form>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#myForm').validate({
                rules: {
                    nama: {
                        required: true,
                    },
                },
                messages: {
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
