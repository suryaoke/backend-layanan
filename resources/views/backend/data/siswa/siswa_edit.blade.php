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

        <div class="mt-4">
            <label for=""> Kelas</label>
            <select name="kelas" id="kelas" class="tom-select w-full mt-1" required>
                <option value="{{ $siswa->kelas }}">{{ $siswa['kelass']['nama'] }}</option>
                @foreach ($kelas as $item)
                    <option value="{{ $item->id }}">{{ $item->nama }}</option>
                @endforeach
            </select>
        </div>
        @if (Auth::user()->role == '1')
            <div class="mt-4">
                <label for=""> Username</label>
                <select name="id_user" id="id_user" class="tom-select w-full mt-1"required>

                    @if ($siswa->id_user == '0')
                        <option value="0">Kosong</option>
                    @else
                        <option value="{{ $siswa->id_user }}">{{ $siswa['users']['name'] }}</option>
                    @endif
                    <option value="0">Kosong</option>
                    @foreach ($user as $item)
                        <option value="{{ $item->id }}">{{ $item->username }}</option>
                    @endforeach
                </select>
            </div>
        @endif
        <div class="mt-4">
            <button class="btn btn-primary  w-full  h-10 xl:w-32 xl:mr-3 align-top mb-1" type="submit">Save </button>
            <a href="{{ route('siswa.all') }}" class="btn btn-danger w-full h-10 xl:w-32 xl:mr-3 align-top "
                type="submit">Cancel</a>

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
                    id_user: {
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
                    id_user: {
                        required: 'Please Select Your Username',
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
