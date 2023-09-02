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

        <input type="text" class="intro-x login__input form-control py-3 px-4 block" placeholder="Kode Orang Tua"
            name="kode_ortu" id="kode_ortu" required>
        <input type="text" class="intro-x login__input form-control py-3 px-4 block mt-4" placeholder="Nama"
            name="nama" id="nama" required>
        <input type="text" class="intro-x login__input form-control py-3 px-4 block mt-4" placeholder="No HP"
            name="no_hp" id="no_hp" pattern="[0-9]+" title="Please enter only numbers" required>

        <select name="username" id="username" class="form-control w-full mt-4" required>
            <option value="">Pilih Username</option>
            @foreach ($user as $item)
                <option value="{{ $item->id }}">{{ $item->username }}</option>
            @endforeach
        </select>

        <select name="nama_siswa" id="nama_siswa" class="form-control w-full mt-4" required>
            <option value="">Pilih Siswa</option>
            @foreach ($siswa as $item)
                <option value="{{ $item->id }}">{{ $item->nama }}</option>
            @endforeach
        </select>
        <div class="mt-4">
            <button class="btn btn-primary  py-3 px-4 w-full xl:w-32 xl:mr-3 align-top" type="submit">Save</button>
            <a href="{{ route('orangtua.all') }}"
                class="btn btn-danger  py-3 px-4 w-full xl:w-32 xl:mr-3 align-top">Cancel</a>
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
                    username: {
                        required: true,
                    },
                    nama_siswa: {
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
                    username: {
                        required: 'Please Enter Your Username',
                    },
                    nama_siswa: {
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
