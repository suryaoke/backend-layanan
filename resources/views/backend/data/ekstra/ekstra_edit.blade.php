@extends('admin.admin_master')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script> <!-- Include jQuery Validation plugin -->
    <div class="intro-y flex items-center mt-8 mb-4">
        <h1 class="text-lg font-medium mr-auto">
            Edit Ekstrakulikuler
        </h1>
    </div>

    <form method="post" action="{{ route('ekstra.update') }}" enctype="multipart/form-data" id="myForm">
        @csrf

        <input type="hidden" name="id" value="{{ $ekstra->id }}">


        <div class="mt-4">
            <label for="">Nama Ekstrakulikuler</label>

            <div class="input-group mt-1">
                <div id="input-group-email" class="input-group-text">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-gauge-circle">
                        <path d="M15.6 2.7a10 10 0 1 0 5.7 5.7" />
                        <circle cx="12" cy="12" r="2" />
                        <path d="M13.4 10.6 19 5" />
                    </svg>
                </div>
                <input class="intro-x login__input form-control py-3 px-4 block" type="text" placeholder="Masukkan Nama"
                    name="nama" id="nama" required value="{{ $ekstra->nama }}">
            </div>
            <span id="error-kurikulum" class="text-sm text-red-600"></span>
        </div>

        <div class="mt-4">
            <label for="kelas">Pembina</label>
            <div class="mt-1 flex">
                <div
                    class="z-30 rounded-l w-10 flex items-center justify-center
             bg-slate-100 border text-slate-500 dark:bg-darkmode-700 dark:border-darkmode-800
              dark:text-slate-400 -mr-1">
                    <i data-lucide="user"></i>
                </div>
                <select name="id_guru" id="id_guru" class="tom-select  w-full " required>
                    <option value="{{ $ekstra->id_guru }}">{{ $ekstra['gurus']['nama'] }}
                        / {{ $ekstra['gurus']['kode_gr'] }}
                    </option>
                    @foreach ($guru as $item)
                        <option value="{{ $item->id }}">{{ $item->nama }} / {{ $item->kode_gr }} </option>
                    @endforeach
                </select>
            </div>
            <span id="error-kelas" class="text-sm text-red-600"></span>
        </div>

        <div class="mt-4">
            <label for=""> Image</label>
            <label for="regular-form-1" class="mr-2">Profile Image</label> <input name="image" type="file"
                id="image">
        </div>

        <div class="mt-3 flex ">
            <img width="130px auto" id="showImage"
                src="{{ !empty($ekstra->image) ? url('uploads/admin_images/' . $ekstra->image) : url('uploads/no_image.jpg') }}"
                alt="Card image cap">

        </div>

        <div class="mt-2">
            <button class="btn btn-primary mt-2  w-full  h-10  xl:w-32 xl:mr-3 align-top" type="submit">Save</button>
            <a class="btn btn-danger mt-2 w-full h-10 xl:w-32 xl:mr-3 align-top" href="{{ route('ekstra.all') }}">Cancel
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
                    nama: {
                        required: true,
                    },
                },
                messages: {
                    id_guru: {
                        required: 'Please Enter Your Id_guru',
                    },
                    nama: {
                        required: 'Please Enter Your Nama',
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


    <script type="text/javascript">
        $(document).ready(function() {
            $('#image').change(function(e) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#showImage').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            });
        });
    </script>
@endsection
