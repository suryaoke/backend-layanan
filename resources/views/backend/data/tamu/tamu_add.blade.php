@extends('admin.admin_master')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <div class="intro-y flex items-center mt-8 mb-4">
        <h1 class="text-lg font-medium mr-auto">
            Add Tamu
        </h1>
    </div>
    <form method="POST" action="{{ route('tamu.store') }}" enctype="multipart/form-data" id="myForm">
        @csrf
        <input id="nama" type="text" class="intro-x login__input form-control py-3 px-4 block" placeholder=" Nama"
            name="nama">
        <div class="mt-3 mb-2 intro-x login__input form-control"> <label>Jabatan</label>
            <div class="flex flex-col sm:flex-row mt-2">
                <div class="form-check mr-2"> <input id="jabatan" class="form-check-input" type="radio" name="jabatan"
                        value="Instansi"> <label class="form-check-label" for="radio-switch-4">Instansi</label> </div>

                <div class="form-check mr-2 mt-2 sm:mt-0"> <input id="jabatan" class="form-check-input" type="radio"
                        name="jabatan" value="Instansi"> <label class="form-check-label" for="radio-switch-5">Orang
                        Tua/Wali</label> </div>

                <div class="form-check mr-2 mt-2 sm:mt-0"> <input id="jabatan" class="form-check-input" type="radio"
                        name="jabatan" value="Instansi"> <label class="form-check-label" for="radio-switch-6">Umum</label>
                </div>
            </div>
        </div>

        <input id="individu" type="text" class="intro-x login__input form-control mt-3 py-3 px-4 block"
            placeholder="Individu Yang dituju Contoh:Kepala Madrasah,Wakil Kepala, atau Nama Individu " name="individu">

        <input id="tujuan" type="text" class="intro-x login__input form-control mt-3 py-3 px-4 block"
            placeholder="Maksud dan Tujuan" name="tujuan">
        <input id="no_hp" type="text" class="intro-x login__input form-control mt-3 py-3 px-4 block"
            placeholder="No HP/WA Contoh:083182718860" name="no_hp">
        <input type="hidden" class="intro-x login__input form-control mt-3 py-3 px-4 block" name="status" value="0">
        <button class="btn btn-primary mt-3 py-3 px-4 w-full xl:w-32 xl:mr-3 align-top" type="submit">Create </button>
    </form>

    <script type="text/javascript">
        jQuery(document).ready(function() {
            $('#myForm').validate({
                rules: {
                    nama: {
                        required: true,
                    },
                    jabatan: {
                        required: true,
                    },
                    individu: {
                        required: true,
                    },
                    tujuan: {
                        required: true,
                    },
                    no_hp: {
                        required: true,
                    },

                },
                messages: {
                    nama: {
                        required: 'Please Enter Your Tamu',
                    },
                    jabatan: {
                        required: 'Please Enter Your Tamu',
                    },
                    individu: {
                        required: 'Please Enter Your Tamu',
                    },
                    tujuan: {
                        required: 'Please Enter Your Tamu',
                    },
                    no_hp: {
                        required: 'Please Enter Your Tamu',
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
@endsection
