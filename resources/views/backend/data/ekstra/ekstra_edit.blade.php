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
            <label for=""> Nama</label>
            <input class="intro-x login__input form-control py-3 px-4 block" type="text" placeholder="Masukkan Nama"
                name="nama" id="nama" required value="{{ $ekstra->nama }}">
        </div>

        <div class="mt-4">
            <label for=""> Pembina</label>
            <select name="id_guru" id="id_guru" class="tom-select  w-full " required>
                <option value="{{ $ekstra->id_guru }}">{{ $ekstra['gurus']['nama'] }}
                    / {{ $ekstra['gurus']['kode_gr'] }}
                </option>
                @foreach ($guru as $item)
                    <option value="{{ $item->id }}">{{ $item->nama }} / {{ $item->kode_gr }} </option>
                @endforeach
            </select>
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
            <button class="btn btn-primary mt-2  w-full  h-10  xl:w-32 xl:mr-3 align-top" type="submit">Update</button>
            <a class="btn btn-danger mt-2 w-full h-10 xl:w-32 xl:mr-3 align-top" href="{{ route('ekstra.all') }}">Cancel
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
