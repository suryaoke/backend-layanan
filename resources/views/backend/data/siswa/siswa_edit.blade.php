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
            <input type="text" value="{{ $siswa->nama }}"
                class="intro-x login__input form-control py-3 px-4 block mt-1 " placeholder="Masukkan Nama " name="nama"
                id="nama">
        </div>
        <div class="form-group mt-3">
            <label for="username">Nisn</label>
            <input type="text" value="{{ $siswa->nisn }}" class="intro-x login__input form-control py-3 px-4 block mt-1"
                placeholder="Masukkan Nisn" name="nisn" id="nisn">
        </div>


        <div class="mt-3">
            <label>Tempat dan Tanggal Lahir</label>
            <div class="flex flex-col sm:flex-row mt-2">
                <div class="form-check mr-2">
                    <input type="text" value="{{ $siswa->tempat }}"
                        class="intro-x login__input form-control py-3 px-4 block mt-1" placeholder="Masukkan Tempat Lahir"
                        name="tempat" id="tempat">
                </div>
                <div class="form-check mr-2 mt-2 sm:mt-0">
                    <input type="date" value="{{ $siswa->tanggal }}"
                        class="intro-x login__input form-control py-3 px-4 block mt-1" name="tanggal" id="tanggal">
                </div>
            </div>
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
        @if ($siswa->id_user != '0' && $siswa->id_user != null)
            <div class="mt-3">
                <label>Username</label>
                <input type="text" value="{{ $siswa['users']['username'] }}"
                    class="intro-x login__input form-control py-3 px-4 block " placeholder="Masukkan Username "
                    name="username" id="username">
                <input type="hidden" value="{{ $siswa->id_user }}"
                    class="intro-x login__input form-control py-3 px-4 block " name="id_user" id="id_user">
            </div>
        @endif

        @if ($siswa->id_user == '0' || $siswa->id_user == null)
            @if (Auth::user()->role == '1')
                <div class="mt-4">
                    <label for=""> Username</label>
                    <select name="id_user" id="id_user" class="tom-select w-full mt-1"required>
                        <option value="0">Kosong</option>
                        @foreach ($user as $item)
                            <option value="{{ $item->id }}">{{ $item->username }}</option>
                        @endforeach
                    </select>
                </div>
            @endif
        @endif

        <div class="mt-4">
            <a href="{{ route('siswa.all') }}" class="btn btn-danger w-full h-10 xl:w-32 xl:mr-2 align-top "
                type="submit">Cancel</a>
            <button class="btn btn-primary  w-full  h-10 xl:w-32 xl:mr-3 align-top mb-1" type="submit">Save </button>
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

                    jk: {
                        required: true,
                    },
                    username: {
                        required: true,
                    },

                    tempat: {
                        required: true,
                    },
                    tanggal: {
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

                    jk: {
                        required: 'Please Select Your Jenis Kelamin',
                    },
                    username: {
                        required: 'Please Select Your Username',
                    },
                    tempat: {
                        required: 'Please Select Your Tempat',
                    },
                    tanggal: {
                        required: 'Please Select Your Tanggal',
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
