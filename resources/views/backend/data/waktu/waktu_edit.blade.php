@extends('admin.admin_master')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script> <!-- Include jQuery Validation plugin -->
    <div class="intro-y flex items-center mt-8 mb-4">
        <h1 class="text-lg font-medium mr-auto">
            Edit Data Waktu
        </h1>
    </div>

    <form method="post" action="{{ route('waktu.update') }}" enctype="multipart/form-data" id="myForm">
        @csrf

        <input type="hidden" name="id" value="{{ $waktu->id }}">

        <div class="mt-4">
            <label>
                Kode Waktu
            </label>
            <input class="intro-x login__input form-control py-3 px-4 block" type="text"
                placeholder="Masukkan Kode Waktu" name="kode_waktu" id="kode_waktu" value="{{ $waktu->kode_waktu }}"
                required>
        </div>

        <div class="mt-4">
            <label for=""> Waktu Mulai</label>
            <input type="time" class="intro-x login__input form-control py-3 px-4 block" placeholder="Waktu Mulai"
                name="waktu_mulai" id="waktu_mulai" value="{{ $waktu->waktu_mulai }}" required>
        </div>

        <div class="mt-4">
            <label for=""> Waktu Akhir</label>
            <input type="time" class="intro-x login__input form-control py-3 px-4 block" placeholder="Waktu Akhir"
                name="waktu_akhir" id="waktu_akhir" value="{{ $waktu->waktu_akhir }}" required>
        </div>
        <div class="mt-4">
            <label for="">Jam Pelajaran</label>
            <select name="jp" id="jp" class="form-control w-full " required>
                <option value="{{ $waktu->jp }}">{{ $waktu->jp }} Jp</option>
                <option value="1">1 Jp</option>
                <option value="2">2 Jp</option>
                <option value="3">3 Jp</option>
                <option value="4">4 Jp</option>
            </select>
        </div>
        <div class="mt-4">
            <button class="btn btn-primary   w-full h-10 xl:w-32 xl:mr-3 align-top" type="submit">Update</button>
            <a class="btn btn-danger  w-full h-10 xl:w-32 xl:mr-3 align-top" href="{{ route('waktu.all') }}">Cancel
            </a>
        </div>

    </form>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#myForm').validate({
                rules: {
                    kode_waktu: {
                        required: true,
                    },
                    waktu_mulai: {
                        required: true,
                    },
                    waktu_akhir: {
                        required: true,
                    },
                    range: {
                        required: true,
                    },
                    jp: {
                        required: true,
                    },

                },
                messages: {
                    kode_waktu: {
                        required: 'Please Enter Your Kode Waktu',
                    },
                    waktu_mulai: {
                        required: 'Please Enter Your Waktu Mulai',
                    },
                    waktu_akhir: {
                        required: 'Please Enter Your Waktu Akhir,',
                    },
                    range: {
                        required: 'Please Enter Your Range',
                    },
                    jp: {
                        required: 'Please Enter Your Jp',
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
