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
            Add Mata Pelajaran
        </h1>
    </div>

    <form method="post" action="{{ route('mapel.store') }}" enctype="multipart/form-data" id="myForm">
        @csrf
        <div class="mt-4">
            <label for="">Kode Mapel</label>
            <div class="input-group mt-1">
                <div id="input-group-email" class="input-group-text">
                    <i data-lucide="code-2"></i>
                </div>
                <input type="text" class="intro-x login__input form-control py-3 px-4 block "
                    placeholder="Masukkan Kode Mapel" name="kode_mapel" id="kode_mapel">
            </div>
            <span id="error-kurikulum" class="text-sm text-red-600"></span>
        </div>


        <div class="mt-4">
            <label for="">Induk</label>

            <div class="input-group mt-1">
                <div id="input-group-email" class="input-group-text">
                    <i data-lucide="file"></i>
                </div>
                <input type="text" class="intro-x login__input form-control py-3 px-4 block "
                    placeholder="Kosongkan Kalau Tidak Ada !!" name="induk">
            </div>
            <span id="error-kurikulum" class="text-sm text-red-600"></span>
        </div>


        <div class="mt-4">
            <label for="">Nama Mapel</label>

            <div class="input-group mt-1">
                <div id="input-group-email" class="input-group-text">
                    <i data-lucide="book"></i>
                </div>

                <input type="text" class="intro-x login__input form-control py-3 px-4 block "
                    placeholder="Masukkan Nama Mapel" name="nama" id="nama">
            </div>
            <span id="error-kurikulum" class="text-sm text-red-600"></span>
        </div>


        <div class="mt-4">
            <label for="">Jam Pelajaran</label>

            <div class="mt-1 flex">
                <div
                    class="z-30 rounded-l w-10 flex items-center justify-center
             bg-slate-100 border text-slate-500 dark:bg-darkmode-700 dark:border-darkmode-800
              dark:text-slate-400 -mr-1">
                    <i data-lucide="clock"></i>
                </div>
                <select name="jp" id="jp" class="tom-select w-full " required>
                    <option value="">Select JP</option>
                    <option value="1">1 JP</option>
                    <option value="2">2 JP</option>
                    <option value="3">3 JP</option>
                    <option value="4">4 JP</option>
                    <option value="5">5 JP</option>
                    <option value="6">6 JP</option>

                </select>
            </div>
            <span id="error-kelas" class="text-sm text-red-600"></span>
        </div>





        <div class="mt-4">
            <label for="">Jurusan</label>

            <div class="mt-1 flex">
                <div
                    class="z-30 rounded-l w-10 flex items-center justify-center
             bg-slate-100 border text-slate-500 dark:bg-darkmode-700 dark:border-darkmode-800
              dark:text-slate-400 -mr-1">
                    <i data-lucide="file"></i>
                </div>
                <select name="id_jurusan" id="id_jurusan" class="tom-select w-full " required>
                    <option value="">Pilih Jurusan</option>
                    @foreach ($jurusan as $item)
                        <option value="{{ $item->id }}">{{ $item->nama }}</option>
                    @endforeach
                </select>

            </div>
            <span id="error-kelas" class="text-sm text-red-600"></span>
        </div>

        <div class="mt-4">
            <label for="">Kelompok</label>

            <div class="mt-1 flex">
                <div
                    class="z-30 rounded-l w-10 flex items-center justify-center
             bg-slate-100 border text-slate-500 dark:bg-darkmode-700 dark:border-darkmode-800
              dark:text-slate-400 -mr-1">
                    <i data-lucide="file"></i>
                </div>
                <select name="jenis" id="jenis" class="tom-select w-full " required>
                    <option value="">Pilih jenis</option>
                    <option value="A">Kelompok A</option>
                    <option value="B">Kelompok B</option>
                    <option value="C">Kelompok C</option>
                </select>
            </div>
            <span id="error-kelas" class="text-sm text-red-600"></span>
        </div>

        <div class="mt-4">
            <label for="">Type</label>

            <div class="mt-1 flex">
                <div
                    class="z-30 rounded-l w-10 flex items-center justify-center
             bg-slate-100 border text-slate-500 dark:bg-darkmode-700 dark:border-darkmode-800
              dark:text-slate-400 -mr-1">
                    <i data-lucide="file"></i>
                </div>
                <select name="type" id="type" class="tom-select w-full " required>
                    <option value="">Select Type</option>
                    <option value="Teori">Teori</option>
                    <option value="Pratikum">Pratikum</option>


                </select>
            </div>
            <span id="error-kelas" class="text-sm text-red-600"></span>
        </div>


        <div class="mt-4">

            <a href="{{ route('mapel.all') }}" class="btn btn-danger w-full h-10 xl:w-32 xl:mr-2 align-top"
                type="submit">Cancel</a>
            <button class="btn btn-primary  w-full  h-10 xl:w-32 xl:mr-3 align-top" type="submit">Save </button>
        </div>

    </form>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script type="text/javascript">
        jQuery(document).ready(function() {
            $('#myForm').validate({
                ignore: [],
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

                    id_jurusan: {
                        required: true,
                    },
                    jenis: {
                        required: true,
                    },
                    type: {
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

                    id_jurusan: {
                        required: 'Please Enter Your Jurusan',
                    },
                    jenis: {
                        required: 'Please Enter Your Jenis',
                    },
                    type: {
                        required: 'Please Enter Your Jenis',
                    },

                },
                errorElement: 'span',
                errorClass: 'invalid-feedback',
                errorPlacement: function(error, element) {
                    error.addClass('block text-sm text-red-600');
                    error.appendTo(element.parent().next());
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
