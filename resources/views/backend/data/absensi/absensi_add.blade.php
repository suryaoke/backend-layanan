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
            <select placeholder="Pilih Mata Pelajaran" name="id_jadwal" id="id_jadwal" class="tom-select w-full ">
                <option value="">Pilih Mata Pelajaran</option>
                @foreach ($jadwal as $item)
                    @php
                        $pengampu = App\Models\Pengampu::where('id', $item->id_pengampu)->first();
                        $mapel = App\Models\Mapel::where('id', $pengampu->id_mapel)->first();
                    @endphp
                    <option value="{{ $item->id }}">{{ $mapel->nama }} / {{ $item->kode_jadwalmapel }}</option>
                @endforeach
            </select>
        </div>


        <div class="mt-3">
            <label for="input-state-2" class="form-label">Kelas</label>
            <select placeholder="kelas" id="kelas" name="search" class="tom-select w-full  ">
                <option value="">Pilih Kelas</option>
                @foreach ($kelas as $item)
                    @php
                        $siswadata = App\Models\Siswa::where('kelas', $item->id)->first();
                    @endphp
                    @if ($siswadata != null)
                        <option value="{{ isset($search) ? $search : "$item->id" }}">
                            {{ $item->nama }} 
                        </option>
                    @endif
                @endforeach
            </select>
        </div>



        <div class="mt-4">
            <button class="btn btn-primary  h-10 w-full xl:w-32 xl:mr-3 align-top" type="submit">Save</button>
            <a href="{{ route('absensi.all') }}" class="btn btn-danger h-10 w-full xl:w-32 xl:mr-3 align-top">Cancel</a>
        </div>
    </form>

    <script type="text/javascript">
        jQuery(document).ready(function() {
            $('#myForm').validate({
                rules: {
                    tanggal: {
                        required: true,
                    },
                    id_jadwal: {
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
                    id_jadwal: {
                        required: 'Please Enter Your Email',
                    },
                    id_jadwal: {
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
