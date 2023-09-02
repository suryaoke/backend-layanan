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
    <!-- BEGIN: Boxed Tab -->
    <div class="intro-y box mt-5">
        <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
            <h1 class="font-medium text-base mr-auto">
                Pembuatan Surat Keluar
            </h1>
        </div>
        <div id="boxed-tab" class="p-5">
            <div class="preview">
                <ul class="nav nav-boxed-tabs" role="tablist">
                    <li id="example-3-tab" class="nav-item flex-1" role="presentation">
                        <button class="nav-link w-full py-2 active" data-tw-toggle="pill" data-tw-target="#example-tab-3"
                            type="button" role="tab" aria-controls="example-tab-3" aria-selected="true"> Informasi
                            Surat
                    </li>
                    <li id="example-4-tab" class="nav-item flex-1 " role="presentation">
                        <button disabled class="nav-link w-full py-2 " data-tw-toggle="pill" data-tw-target="#example-tab-4"
                            type="button" role="tab" aria-controls="example-tab-4" aria-selected="false"> Tujuan Surat
                        </button>
                    </li>
                    <li id="example-5-tab" class="nav-item flex-1 " role="presentation">
                        <button disabled class="nav-link w-full py-2 " data-tw-toggle="pill" data-tw-target="#example-tab-5"
                            type="button" role="tab" aria-controls="example-tab-5" aria-selected="false"> Tembusan
                            Surat
                        </button>
                    </li>
                    <li id="example-6-tab" class="nav-item flex-1 " role="presentation">
                        <button disabled class="nav-link w-full py-2 " data-tw-toggle="pill" data-tw-target="#example-tab-6"
                            type="button" role="tab" aria-controls="example-tab-6" aria-selected="false"> Lampiran
                            Surat
                        </button>
                    </li>
                    <li id="example-7-tab" class="nav-item flex-1 " role="presentation">
                        <button disabled class="nav-link w-full py-2 " data-tw-toggle="pill" data-tw-target="#example-tab-7"
                            type="button" role="tab" aria-controls="example-tab-6" aria-selected="false"> Status
                        </button>
                    </li>
                </ul>
                <form method="post" action="{{ route('surat.keluar.informasi.store') }}" enctype="multipart/form-data"
                    id="myForm">
                    @csrf
                    <div class="tab-content mt-5">
                        <div id="example-tab-3" class="tab-pane leading-relaxed active" role="tabpanel"
                            aria-labelledby="example-3-tab">
                            <div class="grid grid-cols-12 gap-2 mt-12">
                                <select name="tujuan_surat" id="tujuan_surat" data-placeholder="Select Jenis"
                                    class="tom-select w-full col-span-4">
                                    <option value="1">Luar Sekolah</option>
                                    <option value="2">Dalam Sekolah</option>

                                </select>
                                <input name="perihal" id="perihal" type="text" class="form-control col-span-4"
                                    placeholder="Perihal" aria-label="default input inline 2">

                                <select name="id_naskah" id="id_naskah" class="tom-select w-full col-span-4 "
                                    aria-label="Default select example" data-placeholder="Select Naskah">

                                    @foreach ($naskah as $naskahs)
                                        <option value=" {{ $naskahs->id }} ">Naskah : {{ $naskahs->nama }} </option>
                                    @endforeach

                                </select>
                            </div>
                            <div class="grid grid-cols-12 gap-2 mt-6 mb-6">
                                <input name="no_surat" id="no_surat" type="text" class="form-control col-span-4"
                                    placeholder="Nomor Surat" aria-label="default input inline 2">

                                <input name="no_agenda" id="no_agenda" type="text" class="form-control col-span-4"
                                    placeholder="Nomor Agenda" aria-label="default input inline 2">

                                <input name="tgl_surat" id="tgl_surat" type="text"
                                    class="datepicker col-span-4 form-control " data-single-mode="true">
                            </div>
                        </div>

                        <div id="example-tab-4" class="tab-pane leading-relaxed" role="tabpanel"
                            aria-labelledby="example-4-tab"> </div>
                    </div>
            </div>
            <div class="flex sm:ml-auto mt-5 sm:mt-0">

                <button class="btn btn-primary mt-4 py-3 px-4 w-full xl:w-32 xl:mr-3 align-top " type="submit">Create
                </button>

            </div>
        </div>
    </div>
    <!-- END: Boxed Tab -->

    </form>
    <script type="text/javascript">
        jQuery(document).ready(function() {
            $('#myForm').validate({
                rules: {

                    id_naskah: {
                        required: true,
                    },
                    no_surat: {
                        required: true,
                    },
                    tgl_surat: {
                        required: true,
                    },
                    no_agenda: {
                        required: true,
                    },
                    perihal: {
                        required: true,
                    },
                    tujuan_surat: {
                        required: true,
                    },
                    file: {
                        required: true,
                    },

                },
                messages: {
                    id_naskah: {
                        required: 'Please Enter Your Naskah',
                    },
                    no_surat: {
                        required: 'Please Enter Your No Surat',
                    },
                    tgl_surat: {
                        required: 'Please Enter Your Tanggal Surat',
                    },
                    no_agenda: {
                        required: 'Please Enter Your Agenda',
                    },
                    perihal: {
                        required: 'Please Enter Your Perihal',
                    },
                    tujuan_surat: {
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
