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
            Add Orang Tua
        </h1>
    </div>

    <form method="post" action="{{ route('orangtua.store') }}" enctype="multipart/form-data" id="myForm">
        @csrf
        <div class="mt-4">
            <label for="">Kode Orang Tua</label>
            <input type="text" class="intro-x login__input form-control py-3 px-4 block mt-1"
                placeholder="Masukkan Kode Orang Tua" name="kode_ortu" id="kode_ortu" required>
        </div>

        <div class="mt-4">
            <label for=""> Nama</label>
            <input type="text" class="intro-x login__input form-control py-3 px-4 block mt-1" placeholder="Masukkan Nama"
                name="nama" id="nama" required>
        </div>

        <div class="mt-4">
            <label for=""> No Hp</label>
            <input type="text" class="intro-x login__input form-control py-3 px-4 block mt-4"
                placeholder="Masukkan No HP" name="no_hp" id="no_hp" pattern="[0-9]+"
                title="Please enter only numbers" required>
        </div>

        <div class="mt-4">
            <label for=""> Username</label>
            <select name="id_user" id="id_user" class="tom-select w-full mt-1" required>
                <option value="">Pilih Username</option>
                @foreach ($user as $item)
                    <option value="{{ $item->id }}">{{ $item->username }}</option>
                @endforeach
            </select>
        </div>

        <div class="mt-4">
            <label for=""> Siswa</label>
            <select name="id_siswa" id="id_siswa" class="tom-select w-full mt-1" required>
                <option value="">Pilih Siswa</option>
                @foreach ($siswa as $item)
                    <option value="{{ $item->id }}">{{ $item->nama }}</option>
                @endforeach
            </select>
        </div>

        <div class="mt-4">
            <button class="btn btn-primary  w-full  h-10 xl:w-32 xl:mr-3 align-top mb-1" type="submit">Save </button>
            <a href="{{ route('orangtua.all') }}" class="btn btn-danger w-full h-10 xl:w-32 xl:mr-3 align-top "
                type="submit">Cancel</a>

        </div>


    </form>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#myForm').validate({
                rules: {
                    kode_ortu: {
                        required: true,
                    },
                    nama: {
                        required: true,
                    },
                    no_hp: {
                        required: true,
                        digits: true,
                    },
                    id_user: {
                        required: true,
                    },
                    id_siswa: {
                        required: true,
                    },
                },
                messages: {
                    kode_ortu: {
                        required: 'Please Enter Your Kode',
                    },
                    nama: {
                        required: 'Please Enter Your Nama',
                    },
                    no_hp: {
                        required: 'Please Enter Your No HP',
                        digits: 'Please enter only numbers',
                    },
                    id_user: {
                        required: 'Please Enter Your Username',
                    },
                    id_siswa: {
                        required: 'Please Enter Your Nama Siswa',
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
