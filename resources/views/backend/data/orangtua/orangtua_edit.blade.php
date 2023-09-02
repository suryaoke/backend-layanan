@extends('admin.admin_master')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <div class="intro-y flex items-center mt-8 mb-4">
        <h1 class="text-lg font-medium mr-auto">
            Edit Data Orang Tua
        </h1>
    </div>

    <form method="post" action="{{ route('orangtua.update') }}" enctype="multipart/form-data" id="myForm">
        @csrf
        <input type="hidden" name="id" value="{{ $ortu->id }}">

        <div class="form-group">
            <label for="kode_gr">Kode Orang Tua:</label>
            <input type="text" value="{{ $ortu->kode_ortu }}" class="intro-x login__input form-control py-3 px-4 block"
                placeholder="Kode Orang Tua" name="kode_gr" id="kode_gr">
        </div>

        <div class="form-group mt-3">
            <label for="nama">Nama Orang Tua:</label>
            <input type="text" value="{{ $ortu->nama }}" class="intro-x login__input form-control py-3 px-4 block "
                placeholder="Nama Orang Tua" name="nama" id="nama">
        </div>

        <div class="form-group mt-3">
            <label for="username">Username:</label>
            <input type="text" value="{{ $ortu->username }}" class="intro-x login__input form-control py-3 px-4 block "
                placeholder="Username" name="username" id="username">
        </div>

        <div class="form-group mt-3">
            <label for="nama_siswa">Nama Siswa:</label>
            <input type="text" value="{{ $ortu->nama_siswa }}" class="intro-x login__input form-control py-3 px-4 block "
                placeholder="Nama Siswa" name="nama_siswa" id="nama_siswa">
        </div>

        <div class="form-group mt-3">
            <label for="no_hp">Nomor HP:</label>
            <input type="text" value="{{ $ortu->no_hp }}" class="intro-x login__input form-control py-3 px-4 block "
                placeholder="Nomor HP" name="no_hp" id="no_hp">
        </div>

        <!-- Add other input fields as needed -->
        <div class="mt-4">
            <button class="btn btn-primary  py-3 px-4 w-full xl:w-32 xl:mr-3 align-top" type="submit">Update</button>
            <a href="{{ route('orangtua.all') }}"
                class="btn btn-danger py-3 px-4 w-full xl:w-32 xl:mr-3 align-top">Cancel</a>
        </div>

    </form>


    <script type="text/javascript">
        jQuery(document).ready(function() {
            $('#myForm').validate({
                rules: {
                    kode_gr: {
                        required: true,
                    },
                    nama: {
                        required: true,
                    },
                    username: {
                        required: true,
                    },
                    nama_siswa: {
                        required: true,
                    },
                    no_hp: {
                        required: true,
                    },
                    // Add rules for other fields
                },
                messages: {
                    kode_gr: {
                        required: 'Please Enter Kode',
                    },
                    nama: {
                        required: 'Please Enter Name',
                    },
                    username: {
                        required: 'Please Enter Username',
                    },
                    nama_siswa: {
                        required: 'Please Enter Nama Siswa',
                    },
                    no_hp: {
                        required: 'Please Enter Nomor HP',
                    },
                    // Add messages for other fields
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
@endsection
