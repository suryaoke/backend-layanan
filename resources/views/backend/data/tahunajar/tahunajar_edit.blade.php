@extends('admin.admin_master')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script> <!-- Include jQuery Validation plugin -->
    <div class="intro-y flex items-center mt-8 mb-4">
        <h1 class="text-lg font-medium mr-auto">
            Edit Data Tahun Ajar
        </h1>
    </div>

    <form method="post" action="{{ route('tahunajar.update') }}" enctype="multipart/form-data" id="myForm">
        @csrf

        <input type="hidden" name="id" value="{{ $tahunajar->id }}">

        <div class="mt-4">
            <label>
                Tahun Ajar
            </label>
            <input class="intro-x login__input form-control py-3 px-4 block" type="text"
                placeholder="Masukkan Kode Tahunajar" name="tahun" id="tahun" value="{{ $tahunajar->tahun }}"
                required>
        </div>

        <div class="mt-4">
            <label for=""> Semester </label>
            <select name="semester" id="semester" class="tom-select  w-full " required>
                <option value="{{ $tahunajar->semester }}">{{ $tahunajar->semester }}</option>
                <option value="Ganjil">Ganjil</option>
                <option value="Genap">Genap</option>
            </select>
        </div>


        <div class="mt-2">
            <button class="btn btn-primary mt-2  w-full  h-10  xl:w-32 xl:mr-3 align-top" type="submit">Update</button>
            <a class="btn btn-danger mt-2 w-full h-10 xl:w-32 xl:mr-3 align-top" href="{{ route('tahunajar.all') }}">Cancel
            </a>
        </div>

    </form>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#myForm').validate({
                rules: {
                    tahun: {
                        required: true,
                    },
                    semester: {
                        required: true,
                    },
                },
                messages: {
                    tahun: {
                        required: 'Please Enter Your Tahun',
                    },
                    semester: {
                        required: 'Please Enter Your Semester',
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
