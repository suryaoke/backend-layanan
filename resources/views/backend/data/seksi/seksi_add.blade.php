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
            Add Data Seksi
        </h1>
    </div>
    <form method="post" action="{{ route('seksi.store') }}" enctype="multipart/form-data" id="myForm">
        @csrf

        <div class="mt-4">
            <label for="">Tahun Ajar</label>
            <div class="mt-1 flex">
                <div
                    class="z-30 rounded-l w-10 flex items-center justify-center
             bg-slate-100 border text-slate-500 dark:bg-darkmode-700 dark:border-darkmode-800
              dark:text-slate-400 -mr-1">
                    <i data-lucide="tag"></i>
                </div>
                <select name="semester" id="semester" class="tom-select  w-full " required>
                    <option value="">Pilih Kelas</option>
                    @foreach ($semester as $item)
                        <option value="{{ $item->id }}">{{ $item->semester }} / {{ $item->tahun }}</option>
                    @endforeach
                </select>
            </div>
            <span id="error-kelas" class="text-sm text-red-600"></span>
        </div>


        <div class="mt-4">
            <label for="">Kelas / Rombongan Belajar</label>

            <div class="mt-1 flex">
                <div
                    class="z-30 rounded-l w-10 flex items-center justify-center
             bg-slate-100 border text-slate-500 dark:bg-darkmode-700 dark:border-darkmode-800
              dark:text-slate-400 -mr-1">
                    <i data-lucide="users"></i>
                </div>
                <select name="id_rombel" id="id_rombel" class="tom-select  w-full " required>
                    <option value="">Pilih Rombel</option>
                    @foreach ($rombel as $item)
                        <option value="{{ $item->id }}">{{ $item['kelass']['tingkat'] }}
                            {{ $item['kelass']['nama'] }} {{ $item['kelass']['jurusans']['nama'] }} </option>
                    @endforeach
                </select>
            </div>
            <span id="error-kelas" class="text-sm text-red-600"></span>
        </div>


        <div class="mt-4">
            <label for="">Mata Pelajaran</label>

            <div class="mt-1 flex">
                <div
                    class="z-30 rounded-l w-10 flex items-center justify-center
             bg-slate-100 border text-slate-500 dark:bg-darkmode-700 dark:border-darkmode-800
              dark:text-slate-400 -mr-1">
                    <i data-lucide="book"></i>
                </div>
                <select name="id_jadwal" id="id_jadwal" class="tom-select  w-full " required>
                    <option value="">Pilih Mata Pelajaran</option>
                    @foreach ($jadwalmapel as $item)
                        <option value="{{ $item->id }}"
                            data-guru="{{ $item['pengampus']['gurus']['kode_gr'] }} / {{ $item['pengampus']['gurus']['nama'] }}">
                            {{ $item['pengampus']['mapels']['nama'] }} /
                            {{ $item['pengampus']['kelass']['tingkat'] }}{{ $item['pengampus']['kelass']['nama'] }}
                            {{ $item['pengampus']['kelass']['jurusans']['nama'] }}
                        </option>
                    @endforeach
                </select>
            </div>
            <span id="error-kelas" class="text-sm text-red-600"></span>
        </div>


        <div class="mt-4">
            <label for="">Guru</label>
            <div class="input-group mt-1">
                <div id="input-group-email" class="input-group-text">
                    <i data-lucide="user"></i>
                </div>
                <input type="text" id="guru" value="" class="form-control" readonly>
            </div>
            <span id="error-kurikulum" class="text-sm text-red-600"></span>
        </div>




        <div class="mt-4">
            <button class="btn btn-primary mt-2  w-full  h-10  xl:w-32 xl:mr-3 align-top" type="submit">Save</button>
            <a class="btn btn-danger mt-2 w-full h-10 xl:w-32 xl:mr-3 align-top" href="{{ route('seksi.all') }}">Cancel
            </a>
        </div>
    </form>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script type="text/javascript">
        jQuery(document).ready(function() {
            $('#myForm').validate({
                ignore: [],
                rules: {
                    semester: {
                        required: true,
                    },
                    id_rombel: {
                        required: true,
                    },
                    id_jadwal: {
                        required: true,
                    },
                    guru: {
                        required: true,
                    },

                },
                messages: {
                    Semester: {
                        required: 'Please Enter Your Semester',
                    },
                    id_rombel: {
                        required: 'Please Enter Your Rombel',
                    },
                    id_jadwal: {
                        required: 'Please Enter Your Jadwal',
                    },
                    guru: {
                        required: 'Please Enter Your Guru',
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

    <script>
        // Menambahkan event listener ke dropdown mata pelajaran
        document.getElementById("id_jadwal").addEventListener("change", function() {
            // Mendapatkan nilai kelas dari data-kelas yang terkait dengan option yang dipilih
            var selectedOption = this.options[this.selectedIndex];
            var guru = selectedOption.getAttribute("data-guru");

            // Memasukkan nilai kelas ke input kelas
            document.getElementById("guru").value = guru;

        });
    </script>
@endsection
