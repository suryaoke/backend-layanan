@extends('admin.admin_master')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <div class="intro-y flex items-center mt-8 mb-4">
        <h1 class="text-lg font-medium mr-auto">
            Edit Pengampu Mata Pelajaran
        </h1>
    </div>

    <form method="post" action="{{ route('pengampu.update') }}" enctype="multipart/form-data" id="myForm">
        @csrf

        <input type="hidden" name="id" value="{{ $pengampu->id }}">
        <div class="mt-4">
            <label for="id_guru">Guru</label>

            <div class="mt-1 flex">
                <div
                    class="z-30 rounded-l w-10 flex items-center justify-center
             bg-slate-100 border text-slate-500 dark:bg-darkmode-700 dark:border-darkmode-800
              dark:text-slate-400 -mr-1">
                    <i data-lucide="user"></i>
                </div>
                <select name="id_guru" id="id_guru" class="tom-select w-full" required>
                    <option value="{{ $pengampu->id_guru }}">{{ $pengampu['gurus']['nama'] }} /
                        {{ $pengampu['gurus']['kode_gr'] }}</option>
                    @foreach ($guru as $item)
                        <option value="{{ $item->id }}">{{ $item->nama }} / {{ $item->kode_gr }}</option>
                    @endforeach
                </select>
            </div>
            <span id="error-id_guru" class="text-sm text-red-600"></span>
        </div>

        <div class="mt-4">
            <label for="id_mapel">Mata Pelajaran</label>

            <div class="mt-1 flex">
                <div
                    class="z-30 rounded-l w-10 flex items-center justify-center
             bg-slate-100 border text-slate-500 dark:bg-darkmode-700 dark:border-darkmode-800
              dark:text-slate-400 -mr-1">
                    <i data-lucide="book"></i>
                </div>
                <select name="id_mapel" id="id_mapel" class="tom-select w-full" required>
                    <option value="{{ $pengampu->id_mapel }}">{{ $pengampu['mapels']['nama'] }} /
                        {{ $pengampu['mapels']['kode_mapel'] }}</option>
                    @foreach ($mapel as $item)
                        <option value="{{ $item->id }}">{{ $item->nama }} / {{ $item->kode_mapel }}</option>
                    @endforeach
                </select>
            </div>
            <span id="error-id_mapel" class="text-sm text-red-600"></span>
        </div>


        <div class="mt-4">
            <label for="kelas">Kelas</label>

            <div class="mt-1 flex">
                <div
                    class="z-30 rounded-l w-10 flex items-center justify-center
             bg-slate-100 border text-slate-500 dark:bg-darkmode-700 dark:border-darkmode-800
              dark:text-slate-400 -mr-1">
                    <i data-lucide="home"></i>
                </div>
                <select name="kelas" id="kelas" class="tom-select w-full mt-1" required>
                    <option value="{{ $pengampu->kelas }}">
                        {{ $pengampu['kelass']['tingkat'] }}{{ $pengampu['kelass']['nama'] }}
                        {{ $pengampu['kelass']['jurusans']['nama'] }}</option>
                    @foreach ($kelas as $item)
                        <option value="{{ $item->id }}">{{ $item->tingkat }} {{ $item->nama }}
                            {{ $item['jurusans']['nama'] }}</option>
                    @endforeach
                </select>
            </div>
            <span id="error-kelas" class="text-sm text-red-600"></span>
        </div>


        <div class="mt-4">
            <label for="kurikulum">Kurikulum</label>

            <div class="input-group mt-1">
                <div id="input-group-email" class="input-group-text">
                    <i data-lucide="file"></i>
                </div>
                <input type="text" class="intro-x login__input form-control py-3 px-4 block "
                    placeholder="Masukkan Kurikulum" value="{{ $pengampu->kurikulum }}" name="kurikulum" id="kurikulum"
                    readonly>
            </div>
            <span id="error-kurikulum" class="text-sm text-red-600"></span>
        </div>

        <div class="mt-4">
            <button class="btn btn-primary  w-full  h-10 xl:w-32 xl:mr-3 align-top" type="submit">Save </button>
            <a href="{{ route('pengampu.all') }}" class="btn btn-danger w-full h-10 xl:w-32 xl:mr-3 align-top"
                type="submit">Cancel</a>
        </div>

    </form>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script type="text/javascript">
        jQuery(document).ready(function() {
            $('#myForm').validate({
                ignore: [],
                rules: {
                    // Your form validation rules
                    id_guru: {
                        required: true,
                    },
                    id_mapel: {
                        required: true,
                    },
                    kelas: {
                        required: true,
                    },
                    kurikulum: {
                        required: true,
                    },
                },
                messages: {
                    // Your form validation messages
                    id_guru: {
                        required: 'Please Enter Your Guru',
                    },
                    id_mapel: {
                        required: 'Please Enter Your Mapel',
                    },
                    kelas: {
                        required: 'Please Enter Your Kelas',
                    },
                    kurikulum: {
                        required: 'Please Enter Your Kurikulum',
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
