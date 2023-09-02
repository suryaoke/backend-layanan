@extends('admin.admin_master')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

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
            Add Absensi Siswa
        </h1>
    </div>

    <form method="post" action="{{ route('absensi.store') }}" enctype="multipart/form-data" id="myForm">
        @csrf
        <div class="mt-3">
            <label for="input-state-2" class="form-label">Tanggal</label>
            <div class="relative  mx-auto">
                <div
                    class="absolute rounded-l w-10 h-full flex items-center justify-center bg-slate-100 border text-slate-500 dark:bg-darkmode-700 dark:border-darkmode-800 dark:text-slate-400">
                    <i data-lucide="calendar" class="w-4 h-4"></i>
                </div> <input type="text" class="datepicker form-control pl-12" data-single-mode="true"
                    placeholder="Tanggal" name="tanggal" id="tanggal">
            </div>
        </div>
        <div class="mt-3">
            <label for="input-state-2" class="form-label">Mata Pelajaran</label>
            <input type="text" class="intro-x login__input form-control py-3 px-4 block" placeholder="Mata Pelajaran"
                name="mata_pelajaran" id="mata_pelajaran">
        </div>
        <div class="mt-3">
            <label for="input-state-2" class="form-label">Pilih Kelas</label>
            <select placeholder="kelas" id="kelas" name="search" class="tom-select w-full  ">

                @foreach ($kelas as $item)
                    @php
                        $siswadata = app\Models\Siswa::where('kelas', $item->id)->first();
                    @endphp
                    @if ($siswadata != null)
                        <option value="{{ isset($search) ? $search : "$item->id" }}">
                            {{ $item->nama }} <type="hidden" {{ $item->id }}>
                        </option>
                    @endif
                @endforeach
            </select>
        </div>


        <button class="btn btn-primary mt-3 py-3 px-4 w-full xl:w-32 xl:mr-3 align-top" type="submit">Save </button>
        <a href="{{ route('absensi.all') }}" class="btn btn-danger mt-3 py-3 px-4 w-full xl:w-32 xl:mr-3 align-top"
            type="submit">Cancel</a>
    </form>

    <script type="text/javascript">
        jQuery(document).ready(function() {
            $('#myForm').validate({
                rules: {
                    tanggal: {
                        required: true,
                    },
                    mata_pelajaran: {
                        required: true,
                    },
                    kelas: {
                        required: true,
                    },

                },
                messages: {
                    tanggal: {
                        required: 'Please Enter Your Name',
                    },
                    mata_pelajaran: {
                        required: 'Please Enter Your Email',
                    },
                    kelas: {
                        required: 'Please Enter Your Username',
                    },


                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
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
        $(function() {
            $("#tanggal").datepicker({
                dateFormat: "yy-mm-dd"
            });
        });
    </script>
@endsection
