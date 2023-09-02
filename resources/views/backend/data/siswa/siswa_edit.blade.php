@extends('admin.admin_master')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <div class="intro-y flex items-center mt-8 mb-4">
        <h1 class="text-lg font-medium mr-auto">
            Edit Siswa
        </h1>
    </div>

    <form method="post" action="{{ route('siswa.update') }}" enctype="multipart/form-data" id="myForm">
        @csrf

        <input type="hidden" name="id" value="{{ $siswa->id }}">

        <div class="form-group mt-3">
            <label for="username">Nama</label>
            <input type="text" value="{{ $siswa->nama }}" class="intro-x login__input form-control py-3 px-4 block "
                placeholder="Nama siswa" name="nama" id="nama">
        </div>
        <div class="form-group mt-3">
            <label for="username">Nisn</label>
            <input type="text" value="{{ $siswa->nisn }}" class="intro-x login__input form-control py-3 px-4 block "
                placeholder="Nisn" name="nisn" id="nisn">
        </div>
        <div class="mt-3">
            <label>Jenis Kelamin</label>
            <div class="flex flex-col sm:flex-row mt-2">
                <div class="form-check mr-2">
                    <input id="jk_l" class="form-check-input" type="radio" name="jk" value="L"
                        {{ $siswa->jk === 'L' ? 'checked' : '' }}>
                    <label class="form-check-label" for="jk_l">Laki-laki</label>
                </div>
                <div class="form-check mr-2 mt-2 sm:mt-0">
                    <input class="form-check-input" type="radio" name="jk" id="jk_p" value="P"
                        {{ $siswa->jk === 'P' ? 'checked' : '' }}>
                    <label class="form-check-label" for="jk_p">Perempuan</label>
                </div>
            </div>
        </div>
        <div class="form-group mt-3">
            <label for="username">Kelas</label>
            <select name="kelas" id="kelas" class="tom-select w-full " aria-label="Default select example">
                <option value="{{ $siswa->kelass->id }}">{{ $siswa->kelass->nama }}</option>
                @foreach ($kelas as $item)
                    <option value="{{ $item->id }}">{{ $item->nama }}</option>
                @endforeach
            </select>
        </div>
        <div class="mt-4">
            <button class="btn btn-primary  py-3 px-4 w-full xl:w-32 xl:mr-3 align-top" type="submit">Update</button>
            <a class="btn btn-danger  py-3 px-4 w-full xl:w-32 xl:mr-3 align-top"
                href="{{ route('siswa.all') }}">Cancel</a>
        </div>

    </form>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#myForm').validate({
                rules: {
                    nama: {
                        required: true,
                    },
                    nisn: {
                        required: true,
                    },
                    kelas: {
                        required: true,
                    },
                    jk: {
                        required: true,
                    },
                },
                messages: {
                    nama: {
                        required: 'Please Enter Your Nama',
                    },
                    nisn: {
                        required: 'Please Enter Your NISN',
                    },
                    kelas: {
                        required: 'Please Select Your Kelas',
                    },
                    jk: {
                        required: 'Please Select Your Jenis Kelamin',
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
