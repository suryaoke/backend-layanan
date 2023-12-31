@extends('admin.admin_master')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script> <!-- Include jQuery Validation plugin -->
    <div class="intro-y flex items-center mt-8 mb-4">
        <h1 class="text-lg font-medium mr-auto">
            Edit Data Wali Kelas
        </h1>
    </div>

    <form method="post" action="{{ route('rombel.update', $rombel->id) }}" enctype="multipart/form-data" id="myForm">
        @csrf

        <input type="hidden" name="id" value="{{ $rombel->id }}">

        <div class="mt-4">
            <label for="">Kode Rombongan Belajar</label>
            <div class="input-group mt-1">
                <div id="input-group-email" class="input-group-text">
                    <i data-lucide="code-2"></i>
                </div>
                <input type="text" id="kode_rombel" name="kode_rombel" class="form-control"
                    placeholder="Masukkan Kode Rombel" value="{{ $rombel->kode_rombel }}">
            </div>
            <span id="error-kurikulum" class="text-sm text-red-600"></span>
        </div>




        <div class="mt-4">
            <label for="">Kelas</label>

            <div class="mt-1 flex">
                <div
                    class="z-30 rounded-l w-10 flex items-center justify-center
             bg-slate-100 border text-slate-500 dark:bg-darkmode-700 dark:border-darkmode-800
              dark:text-slate-400 -mr-1">
                    <i data-lucide="users"></i>
                </div>
                <select name="id_kelas" id="id_kelas" class="tom-select  w-full " required>
                    <option value="{{ $rombel->id_kelas }}">
                        {{ $rombel['kelass']['tingkat'] }}{{ $rombel['kelass']['nama'] }}
                        {{ $rombel['kelass']['jurusans']['nama'] }}</option>
                    @foreach ($kelas as $item)
                        <option value="{{ $item->id }}">{{ $item->tingkat }}{{ $item->nama }}
                            {{ $item['jurusans']['nama'] }} </option>
                    @endforeach
                </select>
            </div>
            <span id="error-kelas" class="text-sm text-red-600"></span>
        </div>



        <div class="mt-4">
            <label for="">Wali Kelas</label>

            <div class="mt-1 flex">
                <div
                    class="z-30 rounded-l w-10 flex items-center justify-center
             bg-slate-100 border text-slate-500 dark:bg-darkmode-700 dark:border-darkmode-800
              dark:text-slate-400 -mr-1">
                    <i data-lucide="key"></i>
                </div>
                <select name="id_walas" id="id_walas" class="tom-select  w-full " required>
                    <option value="{{ $rombel->id_walas }}">{{ $rombel['walass']['gurus']['nama'] }}</option>
                    @foreach ($walas as $item)
                        <option value="{{ $item->id }}">{{ $item['gurus']['nama'] }} </option>
                    @endforeach
                </select>
            </div>
            <span id="error-kelas" class="text-sm text-red-600"></span>
        </div>



        <div class="mt-4">
            <label for="">Siswa</label>
            <div class="mt-1 flex">
                <div
                    class="z-30 rounded-l w-10 flex items-center justify-center
             bg-slate-100 border text-slate-500 dark:bg-darkmode-700 dark:border-darkmode-800
              dark:text-slate-400 -mr-1">
                    <i data-lucide="user"></i>
                </div>
                <select data-placeholder="Select Siswa" name="id_siswa[]" class="tom-select w-full" multiple>
                   
                     @foreach ($siswa as $item)
                        <option value="{{ $item->id }}" @if (in_array($item->id, $selectedSiswa)) selected @endif>
                            {{ $item->nama }} </option>
                    @endforeach  
       
                </select>  
            </div>
            <span id="error-kelas" class="text-sm text-red-600"></span>
        </div>


        <div class="mt-2">
            <button class="btn btn-primary mt-2  w-full  h-10  xl:w-32 xl:mr-3 align-top" type="submit">Save</button>
            <a class="btn btn-danger mt-2 w-full h-10 xl:w-32 xl:mr-3 align-top" href="{{ route('rombel.all') }}">Cancel
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
                    kode_rombel: {
                        required: true,
                    },
                    id_kelas: {
                        required: true,
                    },
                    id_walas: {
                        required: true,
                    },

                },
                messages: {
                    kode_rombel: {
                        required: 'Please Enter Your Kode Rombel',
                    },
                    id_kelas: {
                        required: 'Please Enter Your Kelas',
                    },
                    id_walas: {
                        required: 'Please Enter Your Walas',
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
