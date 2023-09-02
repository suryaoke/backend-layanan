@extends('admin.admin_master')
@section('admin')


    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <div class="intro-y flex items-center mt-8 mb-4">
        <h1 class="text-lg font-medium mr-auto">
            Pembuataan Surat Masuk
        </h1>
    </div>

    <form method="post" action="{{ route('surat.masuk.store') }}" enctype="multipart/form-data" id="myForm">
        @csrf
        <div class="grid grid-cols-12 gap-2">
            <select name="asal_surat" id="asal_surat" data-placeholder="Select Jenis" class="tom-select w-full col-span-4">

                <option value="1">Luar Sekolah</option>

            </select>
            <input name="no_surat" id="no_surat" type="text" class="form-control col-span-4" placeholder="Nomor Surat"
                aria-label="default input inline 2">

            <input name="tgl_surat" id="tgl_surat" type="text" class="datepicker col-span-4 form-control "
                data-single-mode="true">
        </div>

        <div class="grid grid-cols-12 gap-2 mt-6">
            <input name="pengirim" id="pengirim" type="text" class="form-control col-span-4" placeholder="Pengirim"
                aria-label="default input inline 2">

            <input name="perihal" id="perihal" type="text" class="form-control col-span-4" placeholder="Perihal"
                aria-label="default input inline 2">


            <select name="tujuan" id="tujuan" class="tom-select w-full col-span-4 " aria-label="Default select example"
                data-placeholder="Select Tujuan">

                @foreach ($user as $users)
                    @if ($users->id != Auth::user()->id)
                        <option value=" {{ $users->id }} ">Tujuan Surat : {{ $users->name }} </option>
                    @endif
                @endforeach

            </select>

        </div>

        <div class="grid grid-cols-12 gap-2 mt-6">
            <div class="col-span-4">
                <input name="file" type="file" id="file">
                <div class="text-slate-500 mt-2"> Format file Pdf. </div>
            </div>

        </div>

        <button class="btn btn-primary mt-4 py-3 px-4 w-full xl:w-32 xl:mr-3 align-top" type="submit">Create </button>
    </form>

    <script type="text/javascript">
        jQuery(document).ready(function() {
            $('#myForm').validate({
                rules: {
                    asal_surat: {
                        required: true,
                    },
                    no_surat: {
                        required: true,
                    },
                    tgl_surat: {
                        required: true,
                    },
                    pengirim: {
                        required: true,
                    },
                    perihal: {
                        required: true,
                    },
                    tujuan: {
                        required: true,
                    },
                    file: {
                        required: true,
                    },

                },
                messages: {
                    asal_surat: {
                        required: 'Please Enter Your Asal Surat',
                    },
                    no_surat: {
                        required: 'Please Enter Your No Surat',
                    },
                    tgl_surat: {
                        required: 'Please Enter Your Tanggal Surat',
                    },
                    pengirm: {
                        required: 'Please Enter Your Pengirim',
                    },
                    perihal: {
                        required: 'Please Enter Your Perihal',
                    },
                    tujuan: {
                        required: 'Please Enter Your Tujuan',
                    },
                    file: {
                        required: 'Please Enter Your File',
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

@endsection
