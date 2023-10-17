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

    <div class="intro-y flex items-center mt-8 mb-4">
        <h1 class="text-lg font-medium mr-auto">
            Add Siswa
        </h1>
    </div>

    <form method="post" action="{{ route('siswa.store') }}" enctype="multipart/form-data" id="myForm">
        @csrf
        <div class="mt-4">
            <label for=""> Nama </label>
            <input type="text" class="intro-x login__input form-control py-3 px-4 block mt-1" placeholder="Masukkan Nama"
                name="nama" id="nama">
        </div>
        <div class="mt-4">
            <label for=""> Nisn</label>
            <input type="text" class="intro-x login__input form-control py-3 px-4 block mt-1" placeholder="Masukkan Nisn"
                name="nisn" id="nisn">
        </div>

        <div class="mt-3">
            <label>Jenis Kelamin</label>
            <div class="flex flex-col sm:flex-row mt-2">
                <div class="form-check mr-2">
                    <input id="jk_l" class="form-check-input" type="radio" name="jk" value="L">
                    <label class="form-check-label" for="jk_l">Laki-laki</label>
                </div>
                <div class="form-check mr-2 mt-2 sm:mt-0">
                    <input class="form-check-input" type="radio" name="jk" id="jk_p" value="P">
                    <label class="form-check-label" for="jk_p">Perempuan</label>
                </div>
            </div>
        </div>
        @if (Auth::user()->role == '1')
            <div class="mt-4">
                <label for=""> Username</label>
                <select name="id_user" id="id_user" class="tom-select w-full mt-1" required>
                    <option value="">Pilih Username</option>
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
