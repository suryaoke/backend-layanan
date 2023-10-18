@extends('admin.admin_master')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script> <!-- Include jQuery Validation plugin -->
    <div class="intro-y flex items-center mt-8 mb-4">
        <h1 class="text-lg font-medium mr-auto">
            Edit Ekstrakulikuler Nilai
        </h1>
    </div>

    <form method="post" action="{{ route('ekstranilai.update') }}" enctype="multipart/form-data" id="myForm">
        @csrf

        <input type="hidden" name="id" value="{{ $ekstranilai->id }}">

        <div class="mt-4">
            <label for=""> Nama Ekstrakulikuler</label>
        </div>
        <div class="mt-1 flex">
            <div
                class="z-30 rounded-l w-10 flex items-center justify-center
             bg-slate-100 border text-slate-500 dark:bg-darkmode-700 dark:border-darkmode-800
              dark:text-slate-400 -mr-1">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-gauge-circle">
                    <path d="M15.6 2.7a10 10 0 1 0 5.7 5.7" />
                    <circle cx="12" cy="12" r="2" />
                    <path d="M13.4 10.6 19 5" />
                </svg>
            </div>
            <select name="id_ekstra" id="id_ekstra" class="tom-select  w-full " required>
                <option value="{{ $ekstranilai->id_ekstra }}"> {{ $ekstranilai['ekstras']['nama'] }} </option>
                @foreach ($ekstra as $item)
                    <option value="{{ $item->id }}">{{ $item->nama }} </option>
                @endforeach
            </select>
        </div>

        <div class="mt-4">
            <label for=""> Nama Siswa</label>
        </div>
        <div class="mt-1 flex">
            <div
                class="z-30 rounded-l w-10 flex items-center justify-center
             bg-slate-100 border text-slate-500 dark:bg-darkmode-700 dark:border-darkmode-800
              dark:text-slate-400 -mr-1">
                <i data-lucide="user"></i>
            </div>
            <select name="id_rombelsiswa" id="id_rombelsiswa" class="tom-select  w-full " required>

                <option value="{{ $ekstranilai->id_rombelsiswa }}">{{ $ekstranilai['rombelsiswa']['siswas']['nama'] }}
                   / {{ $ekstranilai['rombelsiswa']['siswas']['nisn'] }}
                </option>
                @foreach ($rombelsiswa as $item)
                    @php
                        $siswa = App\Models\Siswa::where('id', $item->id_siswa)->first();
                    @endphp
                    <option value="{{ $item->id }}"> {{ $siswa->nama }} / {{ $siswa->nisn }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mt-4">
            <label for=""> Nilai</label>
        </div>
        <div class="input-group mt-1">
            <div id="input-group-email" class="input-group-text">
                <i data-lucide="clipboard"></i>
            </div>
            <input class="intro-x login__input form-control py-3 px-4 block" type="text" placeholder="Masukkan Nilai"
                name="nilai" value="{{ $ekstranilai->nilai }}">
        </div>

        <div class="mt-4">
            <label for=""> Keterangan</label>
        </div>
        <div class="input-group mt-1">
            <div id="input-group-email" class="input-group-text">
                <i data-lucide="clipboard"></i>
            </div>
            <input class="intro-x login__input form-control py-3 px-4 block" type="text" placeholder="Masukkan Ket"
                name="ket" value="{{ $ekstranilai->ket }}">
        </div>


        <div class="mt-2">
            <button class="btn btn-primary mt-2  w-full  h-10  xl:w-32 xl:mr-3 align-top" type="submit">Save</button>
            <a class="btn btn-danger mt-2 w-full h-10 xl:w-32 xl:mr-3 align-top"
                href="{{ route('ekstranilai.all') }}">Cancel
            </a>
        </div>

    </form>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#myForm').validate({
                rules: {
                    id_guru: {
                        required: true,
                    },
                    id_kelas: {
                        required: true,
                    },
                },
                messages: {
                    id_guru: {
                        required: 'Please Enter Your Id_guru',
                    },
                    id_kelas: {
                        required: 'Please Enter Your Id_kelas',
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
