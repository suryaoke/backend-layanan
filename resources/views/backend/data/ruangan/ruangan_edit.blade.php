@extends('admin.admin_master')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script> <!-- Include jQuery Validation plugin -->
    <div class="intro-y flex items-center mt-8 mb-4">
        <h1 class="text-lg font-medium mr-auto">
            Edit Data Ruangan
        </h1>
    </div>

    <form method="post" action="{{ route('ruangan.update') }}" enctype="multipart/form-data" id="myForm">
        @csrf

        <input type="hidden" name="id" value="{{ $ruangan->id }}">

        <div class="mt-4">
            <label>
                Kode Ruangan
            </label>
            <input class="intro-x login__input form-control py-3 px-4 block" type="text"
                placeholder="Masukkan Kode Ruangan" name="kode_ruangan" id="kode_ruangan"
                value="{{ $ruangan->kode_ruangan }}" required>
        </div>

        <div class="mt-4">
            <label for=""> Nama Ruangan</label>
            <input type="text" class="intro-x login__input form-control py-3 px-4 block"
                placeholder="Masukkan Nama Ruangan" name="nama" id="nama" value="{{ $ruangan->nama }}" required>
        </div>

        <div class="mt-4">
            <label for=""> Kapasitas</label>
            <input type="text" class="intro-x login__input form-control py-3 px-4 block" placeholder="Masukkan Kapasitas"
                name="kapasitas" id="kapasitas" value="{{ $ruangan->kapasitas }}" required>
        </div>

        <div class="mt-4">
            <label for=""> Jurusan</label>
            <input type="text" class="intro-x login__input form-control py-3 px-4 block" placeholder="Masukkan Jurusan"
                name="jurusan" id="jurusan" value="{{ $ruangan->jurusan }}" required>
        </div>


        <div class="mt-4">
            <label for=""> Jurusan</label>
            <select name="id_jurusan" id="id_jurusan" class="form-control w-full " required>
                <option value="{{ $ruangan->id_jurusan }}">{{ $ruangan['jurusans']['nama'] }} </option>
                @foreach ($jurusan as $item)
                    <option value="{{ $item->id }}">{{ $item->nama }}</option>
                @endforeach
            </select>
        </div>
        <div class="mt-4">
            <label for=""> Type</label>
            <select name="type" id="type" class="form-control w-full " required>
                <option value="{{ $ruangan->type }}">{{ $ruangan->type }}</option>
                <option value="Teori">Teori</option>
                <option value="Teori">Pratikum</option>
            </select>
        </div>
        <div class="mt-4">
            <button class="btn btn-primary   w-full h-10 xl:w-32 xl:mr-3 align-top" type="submit">Update</button>
            <a class="btn btn-danger  w-full h-10 xl:w-32 xl:mr-3 align-top" href="{{ route('ruangan.all') }}">Cancel
            </a>
        </div>

    </form>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#myForm').validate({
                rules: {
                    kode_ruangan: {
                        required: true,
                    },
                    nama: {
                        required: true,
                    },
                    kapasitas: {
                        required: true,
                    },
                    id_jurusan: {
                        required: true,
                    },
                    type: {
                        required: true,
                    },
                },
                messages: {
                    kode_ruangan: {
                        required: 'Please Enter Your Kode Ruangan',
                    },
                    nama: {
                        required: 'Please Enter Your Nama Ruangan',
                    },
                    kapasitas: {
                        required: 'Please Enter Your Kapasitas',
                    },
                    id_jurusan: {
                        required: 'Please Enter Your Jurusan',
                    },
                    type: {
                        required: 'Please Enter Your Type',
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