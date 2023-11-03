@extends('admin.admin_master')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script> <!-- Include jQuery Validation plugin -->
    <div class="intro-y flex items-center mt-8 mb-4">
        <h1 class="text-lg font-medium mr-auto">
            Edit Data  Informasi Sekolah
        </h1>
    </div>

    <form method="post" action="{{ route('info.update') }}" enctype="multipart/form-data" id="myForm">
        @csrf

        <input type="hidden" name="id" value="{{ $info->id }}">

        <div class="mt-4">
            <label for="">Nama</label>
            <div class="input-group mt-1">
                <div id="input-group-email" class="input-group-text">
                    <i data-lucide="file"></i>
                </div>
                <input type="text" class="intro-x login__input form-control py-3 px-4 block " placeholder="Masukkan Nama"
                    name="nama" id="nama" value="{{ $info->nama }}">
            </div>
            <span id="error-kurikulum" class="text-sm text-red-600"></span>
        </div>
        <div class="mt-4">
            <label for="">keterangan</label>
            <div class="input-group mt-1">

                <textarea class="intro-x login__input form-control py-3 px-4 block " name="ket" id="ket" cols="20"
                    rows="5"> {{$info->ket}} </textarea>
            </div>
            <span id="error-kurikulum" class="text-sm text-red-600"></span>
        </div>


        <div class="mt-4">
            <label for="">Link</label>
            <div class="input-group mt-1">
                <div id="input-group-email" class="input-group-text">
                    <i data-lucide="code-2"></i>
                </div>
                <input type="text" class="intro-x login__input form-control py-3 px-4 block " placeholder="Masukkan Link"
                    name="link" id="link" value="{{$info->link}}">
            </div>
        </div>


        <div class="mt-4 flex">
            <label for="regular-form-1" class="mr-2">Profile Image</label>
            <input name="image" type="file"id="image">
        
        </div>

         <div class="mt-3 flex ">
            <img width="130px auto" id="showImage"
                src="{{ !empty($info->image) ? url('uploads/admin_images/' . $info->image) : url('uploads/no_image.jpg') }}"
                alt="Card image cap">

        </div>

        <div class="mt-2">
            <button class="btn btn-primary mt-2  w-full  h-10  xl:w-32 xl:mr-3 align-top" type="submit">Save</button>
            <a class="btn btn-danger mt-2 w-full h-10 xl:w-32 xl:mr-3 align-top" href="{{ route('info.all') }}">Cancel
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
                    nama: {
                        required: true,
                    },
                    ket: {
                        required: true,
                    },
                  
                },
                messages: {
                    nama: {
                        required: 'Please Enter Your Nama',
                    },
                    ket: {
                        required: 'Please Enter Your ket',
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
