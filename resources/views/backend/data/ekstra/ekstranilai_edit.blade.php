@extends('admin.admin_master')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script> <!-- Include jQuery Validation plugin -->
    <div class="intro-y flex items-center mt-8 mb-4">
        <h1 class="text-lg font-medium mr-auto">
            Edit Ekstrakulikuler Nilai
        </h1>
    </div>

    <form method="post" action="{{ route('ekstranilai.update') }}" enctype="multipart/form-data" id="myForm">
        @csrf

        <input type="hidden" name="id" value="{{ $ekstranilai->id }}">

        <div class="mt-4">
            <label for=""> Nama Ekstrakulikuler</label>
            <select name="id_ekstra" id="id_ekstra" class="tom-select  w-full " required>
                <option value="{{ $ekstranilai->id_ekstra }}"> {{ $ekstranilai['ekstras']['nama'] }} </option>
                @foreach ($ekstra as $item)
                    <option value="{{ $item->id }}">{{ $item->nama }} </option>
                @endforeach
            </select>
        </div>

        <div class="mt-4">
            <label for=""> Nama Siswa</label>
            <select name="id_siswa" id="id_siswa" class="tom-select  w-full " required>
                <option value="{{ $ekstranilai->id_siswa }}">{{ $ekstranilai['siswas']['nama'] }}</option>
                @foreach ($siswa as $item)
                    <option value="{{ $item->id }}">{{ $item->nama }} / {{ $item->nisn }} </option>
                @endforeach
            </select>
        </div>

        <div class="mt-4">
            <label for=""> Nilai</label>
            <input class="intro-x login__input form-control py-3 px-4 block" type="text" placeholder="Masukkan Nilai"
                name="nilai" value="{{ $ekstranilai->nilai }}">
        </div>
        <div class="mt-4">
            <label for=""> Keterangan</label>
            <input class="intro-x login__input form-control py-3 px-4 block" type="text" placeholder="Masukkan Ket"
                name="ket" value="{{ $ekstranilai->ket }}">
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
                    id_kelas: {
                        required: true,
                    },
                },
                messages: {
                    id_guru: {
                        required: 'Please Enter Your Id_guru',
                    },
                    id_kelas: {
                        required: 'Please Enter Your Id_kelas',
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
