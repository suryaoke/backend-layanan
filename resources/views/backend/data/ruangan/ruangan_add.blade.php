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
            Add Data Ruangan
        </h1>
    </div>

    <form method="post" action="{{ route('ruangan.store') }}" enctype="multipart/form-data" id="myForm">
        @csrf
        <div class="mt-4">
            <label>
                Kode Ruangan
            </label>
            <input class="intro-x login__input form-control py-3 px-4 block" type="text"
                placeholder="Masukkan Kode Ruangan" name="kode_ruangan" id="kode_ruangan" required>
        </div>

        <div class="mt-4">
            <label for=""> Nama Ruangan</label>
            <input type="text" class="intro-x login__input form-control py-3 px-4 block"
                placeholder="Masukkan Nama Ruangan" name="nama" id="nama" required>
        </div>

        <div class="mt-4">
            <label for=""> Kapasitas</label>
            <input type="text" class="intro-x login__input form-control py-3 px-4 block" placeholder="Masukkan Kapasitas"
                name="kapasitas" id="kapasitas" required>
        </div>

        <div class="mt-4">
            <label for=""> Jurusan</label>
            <select name="id_jurusan" id="id_jurusan" class="tom-select  w-full " required>
                <option value="">Pilih Jurusan</option>
                @foreach ($jurusan as $item)
                    <option value="{{ $item->id }}">{{ $item->nama }}</option>
                @endforeach
            </select>
        </div>

        <div class="mt-4">
            <label for=""> Type</label>
            <select name="type" id="type" class="tom-select  w-full " required>
                <option value="">Pilih Type</option>
                <option value="Teori">Teori</option>
                <option value="Pratikum">Pratikum</option>
            </select>
        </div>


        <div class="mt-4">
            <button class="btn btn-primary  py-3 px-4 w-full xl:w-32 xl:mr-3 align-top" type="submit">Save </button>
            <a href="{{ route('ruangan.all') }}" class="btn btn-danger  py-3 px-4 w-full xl:w-32 xl:mr-3 align-top"
                type="submit">Cancel</a>
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
