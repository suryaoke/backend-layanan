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
                            Surat <i class="  float-right fa fa-star-of-life danger"
                                style=" font-size: 10px; "data-lucide="check-circle" class="w-5 h-5"></i>
                    </li>
                    <li id="example-4-tab" class="nav-item flex-1 " role="presentation">
                        <button class="nav-link w-full py-2 " data-tw-toggle="pill" data-tw-target="#example-tab-4"
                            type="button" role="tab" aria-controls="example-tab-4" aria-selected="false"> Tujuan Surat
                        </button>
                    </li>
                    <li id="example-5-tab" class="nav-item flex-1 " role="presentation">
                        <button disabled class="nav-link w-full py-2 " data-tw-toggle="pill" data-tw-target="#example-tab-4"
                            type="button" role="tab" aria-controls="example-tab-5" aria-selected="false"> Tembusan
                            Surat
                        </button>
                    </li>
                    <li id="example-6-tab" class="nav-item flex-1 " role="presentation">
                        <button disabled class="nav-link w-full py-2 " data-tw-toggle="pill" data-tw-target="#example-tab-4"
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
                @foreach ($surat as $surats)
                @endforeach
                @php
                    $naskah = App\Models\Naskah::latest()
                        ->where('id', $surats->id_naskah)
                        ->get();
                @endphp
                @foreach ($naskah as $naskahs)
                @endforeach
                <div class="tab-content mt-5">
                    <div id="example-tab-3" class="tab-pane leading-relaxed active" role="tabpanel"
                        aria-labelledby="example-3-tab">

                        <div class="grid grid-cols-12 gap-2 mt-12">

                            @if ($surats->tujuan_surat == '1')
                                <input type="text" disabled class="form-control col-span-4"
                                    aria-label="default input inline 2" value="Luar Sekolah">
                            @elseif ($surats->tujuan_surat == '2')
                                <input type="text" disabled class="form-control col-span-4"
                                    aria-label="default input inline 2" value="Dalam Sekolah">
                            @endif
                            <input type="text" disabled class="form-control col-span-4"
                                aria-label="default input inline 2" value="{{ $surats->perihal }} ">

                            <input type="text" disabled class="form-control col-span-4"
                                aria-label="default input inline 2" value="{{ $naskahs->nama }} ">
                        </div>
                        <div class="grid grid-cols-12 gap-2 mt-6 mb-6">

                            <input type="text" disabled class="form-control col-span-4"
                                aria-label="default input inline 2" value="{{ $surats->no_surat }}">

                            <input type="text" disabled class="form-control col-span-4"
                                aria-label="default input inline 2" value=" {{ $surats->no_agenda }} ">

                            <input type="text" disabled class="form-control col-span-4"
                                aria-label="default input inline 2" value=" {{ $surats->tgl_surat }} ">
                        </div>

                    </div>


                    <div id="example-tab-4" class="tab-pane leading-relaxed" role="tabpanel"
                        aria-labelledby="example-4-tab">
                        <form method="post" action="{{ route('surat.keluar.tujuan.store') }}"
                            enctype="multipart/form-data" id="myForm">
                            @csrf
                            <div class="grid grid-cols-12 gap-2 mt-12">

                                @if ($surats->tujuan_surat == '1')
                                    <input name="id_user" id="id_user" type="text" class="form-control col-span-4"
                                        placeholder="Tujuan Surat" aria-label="default input inline 2">
                                @elseif ($surats->tujuan_surat == '2')
                                    <select name="id_user" id="id_user" class="tom-select w-full col-span-4 "
                                        aria-label="Default select example" data-placeholder="Select Naskah">
                                        @foreach ($user as $users)
                                            <option value=" {{ $users->id }} ">Tujuan : {{ $users->name }} </option>
                                        @endforeach
                                    </select>
                                @endif
                                <input name="id_informasi" id="id_informasi" type="hidden" value="{{ $surats->id }}">
                                <input name="id_informasi" id="id_informasi" type="hidden"
                                    value="{{ $surats->id }}">
                                <input name="isi" id="isi" type="hidden" value="{{ $naskahs->isi }}">

                            </div>


                            <button class="btn btn-primary mt-4 py-3 px-4 w-full xl:w-32 xl:mr-3 align-top "
                                type="submit">Create
                            </button>
                    </div>
                </div>
            </div>
            <div class="flex sm:ml-auto mt-5 sm:mt-0">


            </div>
        </div>
    </div>
    <!-- END: Boxed Tab -->

    </form>
    <script type="text/javascript">
        jQuery(document).ready(function() {
            $('#myForm').validate({
                rules: {

                    id_user: {
                        required: true,
                    },


                },
                messages: {
                    id_user: {
                        required: 'Please Enter Your Naskah',
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
