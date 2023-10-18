@extends('admin.admin_master')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script> <!-- Include jQuery Validation plugin -->
    <div class="intro-y flex items-center mt-8 mb-4">
        <h1 class="text-lg font-medium mr-auto">
            Edit Data Wali Kelas
        </h1>
    </div>

    <form method="post" action="{{ route('walas.update') }}" enctype="multipart/form-data" id="myForm">
        @csrf

        <input type="hidden" name="id" value="{{ $walas->id }}">

        <div class="mt-4">
            <label for="">Nama Guru</label>
            <div class="mt-1 flex">
                <div
                    class="z-30 rounded-l w-10 flex items-center justify-center
             bg-slate-100 border text-slate-500 dark:bg-darkmode-700 dark:border-darkmode-800
              dark:text-slate-400 -mr-1">
                    <i data-lucide="user"></i>
                </div>
                <select name="id_guru" id="id_guru" class="tom-select  w-full " required>
                    <option value="{{ $walas->id_guru }}">{{ $walas['gurus']['nama'] }}
                        / {{ $walas['gurus']['kode_gr'] }}
                    </option>
                    @foreach ($guru as $item)
                        <option value="{{ $item->id }}">{{ $item->nama }} / {{ $item->kode_gr }} </option>
                    @endforeach
                </select>
            </div>
            <span id="error-kelas" class="text-sm text-red-600"></span>
        </div>


        <div class="mt-4">
            <label for="">Kelas</label>

            <div class="mt-1 flex">
                <div
                    class="z-30 rounded-l w-10 flex items-center justify-center
             bg-slate-100 border text-slate-500 dark:bg-darkmode-700 dark:border-darkmode-800
              dark:text-slate-400 -mr-1">
                    <i data-lucide="home"></i>
                </div>
                <select name="id_kelas" id="id_kelas" class="tom-select w-full " required>
                    <option value="{{ $walas->id_kelas }}">{{ $walas['kelass']['tingkat'] }} {{ $walas['kelass']['nama'] }}
                        {{ $walas['kelass']['jurusans']['nama'] }}</option>
                    @foreach ($kelas as $item)
                        <option value="{{ $item->id }}">{{ $item->tingkat }} {{ $item->nama }}
                            {{ $item['jurusans']['nama'] }}</option>
                    @endforeach
                </select>
            </div>
            <span id="error-kelas" class="text-sm text-red-600"></span>
        </div>


        <div class="mt-2">
            <button class="btn btn-primary mt-2  w-full  h-10  xl:w-32 xl:mr-3 align-top" type="submit">Save</button>
            <a class="btn btn-danger mt-2 w-full h-10 xl:w-32 xl:mr-3 align-top" href="{{ route('walas.all') }}">Cancel
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
                    id_guru: {
                        required: true,
                    },
                    id_kelas: {
                        required: true,
                    },
                },
                messages: {
                    id_guru: {
                        required: 'Please Enter Your Nama guru',
                    },
                    id_kelas: {
                        required: 'Please Enter Your Kelas',
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
