@extends('admin.admin_master')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <div class="intro-y flex items-center mt-8 mb-4">
        <h1 class="text-lg font-medium mr-auto">
            Edit Data Orang Tua
        </h1>
    </div>

    <form method="post" action="{{ route('orangtua.update') }}" enctype="multipart/form-data" id="myForm">
        @csrf
        <input type="hidden" name="id" value="{{ $ortu->id }}">

        <div class="form-group">
            <label for="kode_gr">Kode Orang Tua</label>
            <input type="text" value="{{ $ortu->kode_ortu }}" class="intro-x login__input form-control py-3 px-4 block"
                placeholder="Kode Orang Tua" name="kode_ortu" id="kode_ortu">
        </div>

        <div class="form-group mt-4">
            <label for="nama">Nama Orang Tua</label>
            <input type="text" value="{{ $ortu->nama }}" class="intro-x login__input form-control py-3 px-4 block "
                placeholder="Nama Orang Tua" name="nama" id="nama">
        </div>

        <div class="form-group mt-4">
            <label for="no_hp">Nomor HP:</label>
            <input type="text" value="{{ $ortu->no_hp }}" class="intro-x login__input form-control py-3 px-4 block "
                placeholder="Nomor HP" name="no_hp" id="no_hp">
        </div>
        @if (Auth::user()->role == '1')
            <div class="mt-4">
                <label for=""> Username</label>
                <select name="id_user" id="id_user" class="tom-select w-full mt-1" required>

                    @if ($ortu->id_user == '0')
                        <option value="0">Kosong</option>
                    @else
                        <option value="{{ $ortu->id_user }}">{{ $ortu['users']['name'] }}</option>
                    @endif

                    @foreach ($user as $item)
                        <option value="{{ $item->id }}">{{ $item->username }}</option>
                    @endforeach
                </select>
            </div>
        @endif

        <div class="mt-4">
            <label for=""> Siswa</label>
            <select name="id_siswa" id="id_siswa" class="tom-select w-full mt-1" required>

                @if ($ortu->id_siswa == '0')
                    <option value="0">Kosong</option>
                @else
                    <option value="{{ $ortu->id_siswa }}">{{ $ortu['siswas']['nama'] }}</option>
                @endif
                @foreach ($siswa as $item)
                    <option value="{{ $item->id }}">{{ $item->nama }}</option>
                @endforeach
            </select>
        </div>

        <!-- Add other input fields as needed -->
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
