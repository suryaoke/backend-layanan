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
            Add Ekstrakulikuler Siswa
        </h1>
    </div>
    <form method="post" action="{{ route('ekstranilai.store') }}" enctype="multipart/form-data" id="myForm">
        @csrf
        <div class="mt-4">
            <label for=""> Nama Ekstrakulikuler</label>
            <select name="id_ekstra" id="id_ekstra" class="tom-select  w-full " required>
                <option value="">Pilih Ekstrakulikuler</option>
                @foreach ($ekstra as $item)
                    <option value="{{ $item->id }}">{{ $item->nama }} </option>
                @endforeach
            </select>
        </div>

        <div class="mt-4">
            <label for=""> Nama Siswa</label>
            <select name="id_siswa" id="id_siswa" class="tom-select  w-full " required>
                <option value="">Pilih Siswa</option>
                @foreach ($siswa as $item)
                    <option value="{{ $item->id }}">{{ $item->nama }} / {{ $item->nisn }} </option>
                @endforeach
            </select>
        </div>

        <div class="mt-4">
            <label for=""> Nilai</label>
            <input class="intro-x login__input form-control py-3 px-4 block" type="text" placeholder="Masukkan Nilai"
                name="nilai">
        </div>
        <div class="mt-4">
            <label for=""> Keterangan</label>
            <input class="intro-x login__input form-control py-3 px-4 block" type="text" placeholder="Masukkan Ket"
                name="ket">
        </div>

        <div class="mt-2">
            <button class="btn btn-primary mt-2  w-full  h-10  xl:w-32 xl:mr-3 align-top" type="submit">Save</button>
            <a class="btn btn-danger mt-2 w-full h-10 xl:w-32 xl:mr-3 align-top"
                href="{{ route('ekstranilai.all') }}">Cancel
            </a>
        </div>
    </form>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#myForm').validate({
                rules: {
                    id_guru: {
                        required: true,
                    },
                    nama: {
                        required: true,
                    },
                },
                messages: {
                    id_guru: {
                        required: 'Please Enter Your Id_guru',
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
