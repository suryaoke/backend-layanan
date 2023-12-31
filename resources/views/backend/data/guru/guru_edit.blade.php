@extends('admin.admin_master')
@section('admin')
    <div class="intro-y flex items-center mt-8 mb-4">
        <h1 class="text-lg font-medium mr-auto">
            Edit Data Guru
        </h1>
    </div>

    <form method="post" action="{{ route('guru.update') }}" enctype="multipart/form-data" id="myForm">
        @csrf

        <input type="hidden" name="id" value="{{ $guru->id }}">
        <div class="mt-3">
            <Kode>Kode Guru</label>
                <input type="text" value="{{ $guru->kode_gr }}" class="intro-x login__input form-control py-3 px-4 block"
                    placeholder="Masukkan Kode Guru" name="kode_gr" id="kode_gr">
        </div>
        <div class="mt-3">
            <label>Nama Guru</label>
            <input type="text" value="{{ $guru->nama }}" class="intro-x login__input form-control py-3 px-4 block "
                placeholder="Nasukkan Nama " name="nama" id="nama">
        </div>
        <div class="mt-3"> <label>No HP</label>
            <input type="text" value="{{ $guru->no_hp }}" class="intro-x login__input form-control py-3 px-4 block "
                placeholder="Masukkan No Hp" name="no_hp" id="no_hp">
        </div>
        @if (Auth::user()->role == '1')
            <div class="mt-3"> <label>Username Guru</label>
                <select name="id_user" id="id_user" class="tom-select w-full mt-1" required>
                    @if ($guru->id_user == '0')
                        <option value="0">Kosong</option>
                    @else
                        <option value="{{ $guru->id_user }}">{{ $guru['users']['username'] }}</option>
                    @endif
                    <option value="0">Kosong</option>
                    @foreach ($user as $item)
                        <option value="{{ $item->id }}">{{ $item->username }}</option>
                    @endforeach
                </select>
            </div>
        @endif

        <div class="mt-4">
            <button class="btn btn-primary  h-10 w-full xl:w-32 xl:mr-3 align-top" type="submit">Save</button>
            <a href="{{ route('guru.all') }}" class="btn btn-danger h-10 w-full xl:w-32 xl:mr-3 align-top">Cancel</a>
        </div>
    </form>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script> <!-- Include jQuery Validate plugin -->

    <script type="text/javascript">
        $(document).ready(function() {
            $('#myForm').validate({
                rules: {
                    kode_gr: {
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
                },
                messages: {
                    kode_gr: {
                        required: 'Please Enter Your Kode',
                    },
                    nama: {
                        required: 'Please Enter Your Nama',
                    },
                    no_hp: {
                        required: 'Please Enter Your No Hp',
                        digits: 'Please enter only numbers',
                    },
                    id_user: {
                        required: 'Please Enter Your Username',
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
