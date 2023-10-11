@extends('admin.admin_master')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <div class="intro-y flex items-center mt-8 mb-4">
        <h1 class="text-lg font-medium mr-auto">
            Add Mapel
        </h1>
    </div>

    <form method="post" action="{{ route('mapel.update') }}" enctype="multipart/form-data" id="myForm">
        @csrf

        <input type="hidden" name="id" value="{{ $mapel->id }}">
        <div class="mt-4">
            <label for=""> Kode Mapel</label>
            <input type="text" class="intro-x login__input form-control py-3 px-4 block "
                placeholder="Masukkan Kode Mapel" name="kode_mapel" id="kode_mapel" value="{{ $mapel->kode_mapel }}">
        </div>

        <div class="mt-4">
            <label for=""> Nama Mapel</label>
            <input type="text" class="intro-x login__input form-control py-3 px-4 block "
                placeholder="Masukkan Nama Mapel" name="nama" id="nama" value="{{ $mapel->nama }}">
        </div>

        <div class="mt-4">
            <label for=""> Jam Pelajaran</label>
            <select name="jp" id="jp" class="form-control w-full " required>
                <option value="{{ $mapel->jp }}">{{ $mapel->jp }} JP</option>
                <option value="1">1 JP</option>
                <option value="2">2 JP</option>
                <option value="3">3 JP</option>
                <option value="4">4 JP</option>
                <option value="5">5 JP</option>
                <option value="6">6 JP</option>

            </select>
        </div>

        <div class="mt-4">
            <label for="">Semester</label>
            <select name="semester" id="semester" class="form-control w-full " required>
                <option value="{{ $mapel->semester }}">{{ $mapel['tahunajars']['semester'] }} -
                    {{ $mapel['tahunajars']['tahun'] }}
                </option>
                @foreach ($tahunajar as $item)
                    <option value="{{ $item->id }}">{{ $item->semester }}-{{ $item->tahun }}</option>
                @endforeach
            </select>
        </div>


        <div class="mt-4">
            <label for=""> Jurusan</label>
            <select name="id_jurusan" id="id_jurusan" class="form-control w-full " required>
                <option value="{{ $mapel->id_jurusan }}">{{ $mapel['jurusans']['nama'] }} </option>
                @foreach ($jurusan as $item)
                    <option value="{{ $item->id }}">{{ $item->nama }}</option>
                @endforeach
            </select>
        </div>

        <div class="mt-4">
            <label for=""> Jenis</label>
            <select name="jenis" id="jenis" class="form-control w-full " required>
                <option value="{{ $mapel->jenis }}">{{ $mapel->jenis }}</option>
                <option value="Teori">Teori</option>
                <option value="Pratikum">Pratikum</option>
            </select>
        </div>


        <div class="mt-4">
            <button class="btn btn-primary  w-full  h-10 xl:w-32 xl:mr-3 align-top" type="submit">Save </button>
            <a href="{{ route('mapel.all') }}" class="btn btn-danger w-full h-10 xl:w-32 xl:mr-3 align-top"
                type="submit">Cancel</a>
        </div>

    </form>

    <script type="text/javascript">
        jQuery(document).ready(function() {
            $('#myForm').validate({
                rules: {
                    kode_mapel: {
                        required: true,
                    },
                    nama: {
                        required: true,
                    },
                    jp: {
                        required: true,
                    },
                    semester: {
                        required: true,
                    },
                    id_jurusan: {
                        required: true,
                    },
                    jenis: {
                        required: true,
                    },
                },
                messages: {
                    kode_mapel: {
                        required: 'Please Enter Your Kode Mapel',
                    },
                    nama: {
                        required: 'Please Enter Your Nama Mapel',
                    },
                    jp: {
                        required: 'Please Enter Your JP',
                    },
                    semester: {
                        required: 'Please Enter Your Semester',
                    },
                    id_jurusan: {
                        required: 'Please Enter Your Jurusan',
                    },
                    jenis: {
                        required: 'Please Enter Your Jenis',
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
