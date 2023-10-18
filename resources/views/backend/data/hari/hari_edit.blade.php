@extends('admin.admin_master')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script> <!-- Include jQuery Validation plugin -->
    <div class="intro-y flex items-center mt-8 mb-4">
        <h1 class="text-lg font-medium mr-auto">
            Edit Data Hari
        </h1>
    </div>

    <form method="post" action="{{ route('hari.update') }}" enctype="multipart/form-data" id="myForm">
        @csrf

        <input type="hidden" name="id" value="{{ $hari->id }}">
        <div class="mt-4">
            <label for="">Kode Hari</label>
            <div class="input-group mt-1">
                <div id="input-group-email" class="input-group-text">
                    <i data-lucide="code-2"></i>
                </div>
                <input class="intro-x login__input form-control py-3 px-4 block" type="text"
                    placeholder="Masukkan Kode Hari" name="kode_hari" id="kode_hari" value="{{ $hari->kode_hari }}"
                    required>
            </div>
            <span id="error-kurikulum" class="text-sm text-red-600"></span>
        </div>

        <div class="mt-4">
            <label for="">Nama</label>
            <div class="input-group mt-1">
                <div id="input-group-email" class="input-group-text">
                    <i data-lucide="file"></i>
                </div>
                <input type="text" class="intro-x login__input form-control py-3 px-4 block" placeholder="Hari Mulai"
                    name="nama" id="nama" value="{{ $hari->nama }}" required>
            </div>
            <span id="error-kurikulum" class="text-sm text-red-600"></span>
        </div>


        <div class="mt-2">
            <button class="btn btn-primary mt-2  w-full  h-10  xl:w-32 xl:mr-3 align-top" type="submit">Save</button>
            <a class="btn btn-danger mt-2 w-full h-10 xl:w-32 xl:mr-3 align-top" href="{{ route('hari.all') }}">Cancel
            </a>
        </div>

    </form>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script type="text/javascript">
        jQuery(document).ready(function() {
            $('#myForm').validate({
                ignore: [],
                rules: {
                    kode_hari: {
                        required: true,
                    },
                    nama: {
                        required: true,
                    },
                },
                messages: {
                    kode_hari: {
                        required: 'Please Enter Your Kode Hari',
                    },
                    nama: {
                        required: 'Please Enter Your Nama',
                    },
                },
                errorElement: 'span',
                errorClass: 'invalid-feedback',
                errorPlacement: function(error, element) {
                    error.addClass('block text-sm text-red-600');
                    error.appendTo(element.parent().next());
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
