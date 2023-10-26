@extends('admin.admin_master')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script> <!-- Include jQuery Validation plugin -->
    <div class="intro-y flex items-center mt-8 mb-4">
        <h1 class="text-lg font-medium mr-auto">
            Edit Data KKM
        </h1>
    </div>

    <form method="post" action="{{ route('kkm.update') }}" enctype="multipart/form-data" id="myForm">
        @csrf
        <input type="hidden" name="id" value="{{ $kkm->id }}">
        <div class="mt-4">
            <label for="">Kkm</label>
            <div class="input-group mt-1">
                <div id="input-group-email" class="input-group-text">
                    <i data-lucide="tag"></i>
                </div>
                <input class="intro-x login__input form-control py-3 px-4 block" type="number"
                    placeholder="Masukkan Batasan KKM" name="kkm" id="kkm" value="{{ $kkm->kkm }}" required>
            </div>
            <span id="error-kurikulum" class="text-sm text-red-600"></span>
        </div>



        <div class="mt-4">
            <label for="id_kelas">Kelas</label>

            <div class="mt-1 flex">
                <div
                    class="z-30 rounded-l w-10 flex items-center justify-center
             bg-slate-100 border text-slate-500 dark:bg-darkmode-700 dark:border-darkmode-800
              dark:text-slate-400 -mr-1">
                    <i data-lucide="file"></i>
                </div>
                <select name="id_kelas" id="id_kelas" class="tom-select w-full" required>
                    <option value="{{ $kkm->id_kelas }}">{{ $kkm->id_kelas }}</option>
                    <option value="X">X</option>
                    <option value="XI">XI</option>
                    <option value="XII">XII</option>
                </select>
            </div>
            <span id="error-id_kelas" class="text-sm text-red-600"></span>
        </div>






        <div class="mt-2">
            <button class="btn btn-primary mt-2  w-full  h-10  xl:w-32 xl:mr-3 align-top" type="submit">Save</button>
            <a class="btn btn-danger mt-2 w-full h-10 xl:w-32 xl:mr-3 align-top" href="{{ route('kkm.all') }}">Cancel
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
                    kkm: {
                        required: true,
                    },
                    id_kelas: {
                        required: true,
                    },
                },
                messages: {
                    kkm: {
                        required: 'Please Enter Your Kkm',
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
