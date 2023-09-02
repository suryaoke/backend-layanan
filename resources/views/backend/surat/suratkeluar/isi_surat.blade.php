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
                            <i class="  float-right fa fa-star-of-life danger"
                                style=" font-size: 10px; "data-lucide="check-circle" class="w-5 h-5"></i>
                    </li>
                    <li id="example-4-tab" class="nav-item flex-1 " role="presentation">
                        <button class="nav-link w-full py-2 " data-tw-toggle="pill" data-tw-target="#example-tab-4"
                            type="button" role="tab" aria-controls="example-tab-4" aria-selected="false"> Tujuan Surat
                            <i class="  float-right fa fa-star-of-life danger"
                                style=" font-size: 10px; "data-lucide="check-circle" class="w-5 h-5"></i>
                        </button>
                    </li>
                    <li id="example-5-tab" class="nav-item flex-1 " role="presentation">
                        <button class="nav-link w-full py-2 " data-tw-toggle="pill" data-tw-target="#example-tab-5"
                            type="button" role="tab" aria-controls="example-tab-5" aria-selected="false"> Tembusan
                            Surat
                        </button>
                    </li>
                    <li id="example-6-tab" class="nav-item flex-1 " role="presentation">
                        <button class="nav-link w-full py-2 " data-tw-toggle="pill" data-tw-target="#example-tab-6"
                            type="button" role="tab" aria-controls="example-tab-6" aria-selected="false"> Lampiran
                            Surat
                        </button>
                    </li>
                    <li id="example-7-tab" class="nav-item flex-1 " role="presentation">
                        <button class="nav-link w-full py-2 " data-tw-toggle="pill" data-tw-target="#example-tab-7"
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
                @foreach ($tujuan as $tujuans)
                @endforeach
                @php
                    $user = App\Models\User::latest()
                        ->where('id', $tujuans->id_user)
                        ->get();
                @endphp
                @foreach ($user as $users)
                @endforeach
                @foreach ($isi as $isis)
                @endforeach


                <div class="tab-content mt-5">

                    {{--  //Informasi surat//  --}}
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
                        <div class="grid grid-cols-12 gap-2 mt-6 mb-8">

                            <input type="text" disabled class="form-control col-span-4"
                                aria-label="default input inline 2" value="{{ $surats->no_surat }}">

                            <input type="text" disabled class="form-control col-span-4"
                                aria-label="default input inline 2" value=" {{ $surats->no_agenda }} ">

                            <input type="text" disabled class="form-control col-span-4"
                                aria-label="default input inline 2" value=" {{ $surats->tgl_surat }} ">
                        </div>

                    </div>
                    {{--  //Informasi surat//  --}}

                    {{--  //Tujuan surat//  --}}
                    <div id="example-tab-4" class="tab-pane leading-relaxed" role="tabpanel"
                        aria-labelledby="example-4-tab">
                        <form method="post" action="{{ route('surat.keluar.tujuan.update') }}"
                            enctype="multipart/form-data" id="myForm">
                            @csrf
                            <div class="grid grid-cols-12 gap-2 mt-12 ml-6">
                                @if ($surats->tujuan_surat == '1')
                                    <input name="id_user" id="id_user" type="text" class="form-control col-span-4"
                                        placeholder="Tujuan Surat" aria-label="default input inline 2">
                                @elseif ($surats->tujuan_surat == '2')
                                    <select name="id_user" id="id_user" class="tom-select w-full col-span-4 "
                                        aria-label="Default select example" data-placeholder="Select Naskah">
                                        @foreach ($user1 as $users)
                                            <option value=" {{ $users->id }} ">Tujuan : {{ $users->name }} </option>
                                        @endforeach
                                    </select>
                                @endif
                                <input name="id_informasi" id="id_informasi" type="hidden" value="{{ $surats->id }}">

                                @if ($surats->status == '0')
                                    <button class="btn btn-primary w-full align-top" type="submit">Create
                                    </button>
                                @endif

                            </div>
                            <div class="grid   ml-6 mt-8 mb-8">
                                <table class="table table-sm"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Action</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($tujuan2 as $key => $tujuan2s)
                                            <tr>
                                                <td> {{ $key + 1 }} </td>
                                                <td>
                                                    @if ($surats->tujuan_surat == 1)
                                                        {{ $tujuan2s->id_user }}
                                                    @elseif ($surats->tujuan_surat == 2)
                                                        {{ $tujuan2s['tujuan']['name'] }}
                                                    @endif


                                                </td>

                                                <td>
                                                    @if ($surats->status == '0' && $tujuan3 > '1')
                                                        <a id="delete"
                                                            href="{{ route('surat.keluar.tujuan.delete', $tujuans->id) }}"
                                                            class="btn btn-danger mr-1 mb-2">
                                                            <i data-lucide="trash" class="w-5 h-5"></i> </a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach

                        </form>
                        </tbody>
                        </table>
                    </div>
                    {{--  //Tujuan surat//  --}}
                </div>
                {{--  //Tembusan surat//  --}}
                <div id="example-tab-5" class="tab-pane leading-relaxed" role="tabpanel"
                    aria-labelledby="example-5-tab">
                    <form method="post" action="{{ route('surat.keluar.tembusan.store') }}"
                        enctype="multipart/form-data" id="myForm">
                        @csrf
                        <div class="grid grid-cols-12 gap-2 mt-12 ml-6">
                            <textarea name="tujuan" id="" placeholder="Tembusan " class="form-control col-span-4"></textarea>
                            <input name="id_informasi" id="id_informasi" type="hidden" value="{{ $surats->id }}">
                            <div class="grid grid-cols-12 gap-2 mt-12 ml-6">
                                @if ($surats->status == '0')
                                    <button class="btn btn-primary mt-3 py-3 px-4 w-full xl:w-32 xl:mr-3 align-top"
                                        type="submit">Create </button>
                                @endif
                            </div>
                        </div>
                        <div class="grid grid-cols-12 gap-2 mt-12 ml-6 mb-8">
                            @foreach ($tembusan as $key => $tembusans)
                                <textarea class="form-control col-span-4">{{ $tembusans->tujuan }}</textarea>
                                <div class="grid grid-cols-12 gap-2 mt-12 ml-6">
                                    @if ($surats->status == '0')
                                        <a id="delete"
                                            href="{{ route('surat.keluar.tembusan.delete', $tembusans->id) }}"
                                            class="btn btn-danger mr-1 mb-2 mt-3 py-3 px-4 w-full xl:w-32 xl:mr-3 align-top">
                                            <i data-lucide="trash" class="w-5 h-5"></i> </a>
                                    @endif
                                </div>
                            @endforeach
                    </form>
                </div>
                {{--  //Tembusan surat//  --}}
            </div>
            {{--  //Lampiran surat//  --}}
            <div id="example-tab-6" class="tab-pane leading-relaxed" role="tabpanel" aria-labelledby="example-6-tab">
                <form method="post" action="{{ route('surat.keluar.lampiran.store') }}" enctype="multipart/form-data"
                    id="myForm">
                    @csrf
                    <div class="grid grid-cols-12 gap-2 mt-12 ml-6">
                        <div class="col-span-4">
                            <input name="file" type="file">
                            <div class="text-slate-500 mt-2"> Format file Pdf. </div>
                        </div>
                        <input name="id_informasi" id="id_informasi" type="hidden" value="{{ $surats->id }}">
                        @if ($surats->status == '0')
                            <button class="btn btn-primary w-full align-top" type="submit">Create
                        @endif
                        </button>
                    </div>
                    <div class="grid   ml-6 mt-8 mb-8">
                        <table class="table table-sm" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Action</th>
                            </thead>
                            <tbody>
                                @foreach ($lampiran as $key => $lampirans)
                                    <tr>
                                        <td> {{ $key + 1 }} </td>
                                        <td>
                                            {{ $lampirans->file }}

                                        </td>
                                        <td>
                                            <a href="{{ url('uploads/lampiran/', $lampirans->file) }}"
                                                class="btn btn-success mr-1 mb-2">
                                                <i data-lucide="download" class="w-5 h-5"></i> </a>
                                            @if ($surats->status == '0')
                                                <a id="delete"
                                                    href="{{ route('surat.keluar.lampiran.delete', $lampirans->id) }}"
                                                    class="btn btn-danger mr-1 mb-2">
                                                    <i data-lucide="trash" class="w-5 h-5"></i> </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach

                </form>
                </tbody>
                </table>
            </div>
            {{--  //Lampiran surat//  --}}
        </div>
        {{--  //Status surat//  --}}
        <div id="example-tab-7" class="tab-pane leading-relaxed" role="tabpanel" aria-labelledby="example-6-tab">
            <div class="grid   ml-6 mt-8 mb-8">
                <h1 class="font-medium text-base mr-auto mb-8 mt-8">
                    Status Surat Keluar
                </h1>
                <table class="table table-sm mb-8" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Status</th>
                            <th>Ket</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($verifikasi as $key => $verfikasis)
                            <tr>
                                <td> {{ $key + 1 }} </td>
                                <td>Verifikasi Surat</td>
                                <td>

                                    @if ($verfikasis->status == '0')
                                        <button class="btn btn-warning mr-1 mb-2"> Proses <i
                                                data-loading-icon="three-dots" data-color="1a202c"
                                                class="w-4 h-4 ml-2"></i> </button>
                                    @elseif ($verfikasis->status == '2')
                                        <button class="btn btn-success mr-1 mb-2"> Diverifikasi </button>
                                    @elseif ($verfikasis->status == '3')
                                        <button class="btn btn-danger mr-1 mb-2"> Ditolak <i data-loading-icon="puff"
                                                data-color="white" class="w-4 h-4 ml-2"></i> </button>
                                    @endif
                                </td>
                                <td>
                                    {{ $verfikasis->ket }}
                                </td>
                            </tr>
                        @endforeach

                        @foreach ($tandatangan as $tandatangans)
                            <tr>
                                <td> <i data-lucide="hash"></i> </td>
                                <td>Tandatangan Surat</td>
                                <td>

                                    @if ($tandatangans->status == '0')
                                        <button class="btn btn-warning mr-1 mb-2"> Proses <i
                                                data-loading-icon="three-dots" data-color="1a202c"
                                                class="w-4 h-4 ml-2"></i> </button>
                                    @elseif ($tandatangans->status == '1')
                                        <button class="btn btn-success mr-1 mb-2"> Ditandatangan </button>
                                    @endif
                                </td>
                                <td>
                                    {{ $tandatangans->ket }}
                                </td>
                            </tr>
                        @endforeach


                    </tbody>
                </table>
            </div>
        </div>
        {{--  //Status surat//  --}}

        {{--   // Kirim Surat //  --}}
        <form method="post" action="{{ route('surat.keluar.terkirim.store') }}" enctype="multipart/form-data"
            id="myForm">
            @csrf
            <div class="mt-4 ml-8">
                <h1 class=" text-base mr-auto text-center mb-4 mt-4">
                    Isi Surat
                </h1>
                <input type="hidden" name="id" value="{{ $isis->id }}">
                <input type="hidden" name="id_informasi" value="{{ $isis->id_informasi }}">
                <textarea name="isi" id="editor" class="ml-2">
                        {{ $isis->isi }} 
                    </textarea>
                @if ($surats->created_by == Auth::user()->id)
                    @if ($surats->status == '0')
                        <button class="btn btn-primary mt-4 py-3 px-4 w-full xl:w-32 xl:mr-3 align-top" type="submit">
                            Kirim Surat
                        </button>
                    @elseif ($surats->status == '3')
                        <button class="btn btn-primary mt-4 py-3 px-4 w-full xl:w-64 xl:mr-3 align-top" type="submit">
                            Kirim Surat Perbaikan
                        </button>
                    @endif
                @endif

            </div>
        </form>
        {{--   // Kirim Surat //  --}}

        {{--   // Verifikasi Surat //  --}}
        @if ($surats->status == '1' && Auth::user()->role == '3')
            <div class="flex ">
                <form>
                    <a href="javascript:;"
                        class="  shadow-md ml-8 side-menu btn btn-primary mt-4 py-3 px-4 w-full xl:w-32 xl:mr-3 align-top "
                        data-tw-toggle="modal" data-tw-target="#suratok">Surat OK</a>

                    <a href="javascript:;"
                        class="  shadow-md ml-auto side-menu btn btn-pending mt-4 py-3 px-4 w-full xl:w-32 xl:mr-3 align-top "
                        data-tw-toggle="modal" data-tw-target="#tolak">Surat Perbaiki</a>
                </form>
            </div>
        @endif
        {{--   // Verifikasi Surat //  --}}

        {{--   // Tandatangan  Surat //  --}}
        @if ($surats->status == '2' && Auth::user()->role == '1')
            <div class="flex ml-8 ">
                <form>
                    <a href="javascript:;"
                        class="  shadow-md ml-auto side-menu btn btn-primary mt-4 py-3 px-4 w-full xl:w-32 xl:mr-3 align-top "
                        data-tw-toggle="modal" data-tw-target="#ttd">Tandatangan</a>
                </form>
            </div>
        @endif
        {{--   // Tandatangan Surat //  --}}
    </div>
    </div>
    </div>
    </div>
    <!-- END: Boxed Tab -->

    <!-- BEGIN: Modal Toggle -->

    {{--  // Modal  Surat OK//  --}}
    <div id="suratok" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form method="post" action="{{ route('surat.keluar.verifikasi.store') }}" enctype="multipart/form-data"
                id="myForm">
                @csrf
                <div class="modal-content"> <a data-tw-dismiss="modal" href="javascript:;"> <i data-lucide="x"
                            class="w-8 h-8 text-slate-400"></i> </a>
                    <div class="modal-body p-0">
                        <div class="p-5 text-center"> <i data-lucide="check-circle"
                                class="w-16 h-16 text-success mx-auto mt-3"></i>
                            <div class="text-3xl mt-5">Verifikasi Surat ?</div>
                            <input type="hidden" name="id_informasi" value="{{ $isis->id_informasi }}">
                        </div>
                        <div class="px-5 pb-8 text-center"> <button type="submit" data-tw-dismiss="modal"
                                class="btn btn-primary w-24">Ok</button> </div>
                    </div>
                </div>
            </form>
        </div>
    </div> <!-- END: Modal Content -->
    {{--  // Modal Tandatangan Surat OK//  --}}

    {{--  // Modal Tolak Surat //  --}}
    <div id="tolak" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form method="post" action="{{ route('surat.keluar.verifikasi.tolak') }}" enctype="multipart/form-data"
                id="myForm">
                @csrf

                <div class="modal-content">
                    <!-- BEGIN: Modal Header -->
                    <div class="modal-header">
                        <h2 class="font-medium text-base mr-auto">Perbaiki Surat</h2>
                        <div class="dropdown sm:hidden"> <a class="dropdown-toggle w-5 h-5 block" href="javascript:;"
                                aria-expanded="false" data-tw-toggle="dropdown"> <i data-lucide="more-horizontal"
                                    class="w-5 h-5 text-slate-500"></i> </a>
                            <div class="dropdown-menu w-40">
                                <ul class="dropdown-content">
                                    <li> <a href="javascript:;" class="dropdown-item"> <i data-lucide="file"
                                                class="w-4 h-4 mr-2"></i> Download Docs </a> </li>
                                </ul>
                            </div>
                        </div>
                    </div> <!-- END: Modal Header -->
                    <!-- BEGIN: Modal Body -->

                    <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                        <div class="col-span-12 sm:col-span-6"> <label for="modal-form-1" class="form-label">Keterangan
                            </label>

                            <input type="hidden" name="id_informasi" value="{{ $isis->id_informasi }}">
                            <input type="text" name="ket">
                        </div> <!-- END: Modal Body -->
                        <!-- BEGIN: Modal Footer -->
                        <div class="modal-footer">
                            <button type="button" data-tw-dismiss="modal"
                                class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
                            <button type="submit" class="btn btn-primary w-20">Kirim</button>

                        </div> <!-- END: Modal Footer -->
                    </div>
                </div>
            </form>
        </div> <!-- END: Modal Content -->
    </div>
    {{--  // Modal Tolak Surat //  --}}

    {{--  // Modal Tandatangan Surat //  --}}
    <!-- BEGIN: Modal Content -->
    <div id="ttd" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto">Tandatangan Surat</h2>
                    <div class="dropdown sm:hidden"> <a class="dropdown-toggle w-5 h-5 block" href="javascript:;"
                            aria-expanded="false" data-tw-toggle="dropdown"> <i data-lucide="more-horizontal"
                                class="w-5 h-5 text-slate-500"></i> </a>
                        <div class="dropdown-menu w-40">
                            <ul class="dropdown-content">
                                <li> <a href="javascript:;" class="dropdown-item"> <i data-lucide="file"
                                            class="w-4 h-4 mr-2"></i> Download Docs </a> </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="modal-body p-10 text-center">
                    <!-- BEGIN: Toggle Modal Toggle --> <a id="programmatically-toggle-modal" href="javascript:;"
                        class="btn btn-danger mr-1" data-tw-toggle="modal" data-tw-target="#gambar">Gambar</a>
                    <!-- END: Toggle Modal Toggle -->
                    <!-- BEGIN: Toggle Modal Toggle --> <a id="programmatically-toggle-modal" href="javascript:;"
                        class="btn btn-warning mr-1" data-tw-toggle="modal" data-tw-target="#cetak">Langsung</a>
                    <!-- END: Toggle Modal Toggle -->
                    {{--  
                    <!-- BEGIN: Toggle Modal Toggle --> <a id="programmatically-toggle-modal" href="javascript:;"
                        class="btn btn-warning mr-1" data-tw-toggle="modal"
                        data-tw-target="#exampleModalCenterr">Langsung</a>
                    <!-- END: Toggle Modal Toggle -->  --}}

                </div>
            </div>
        </div>
    </div> <!-- END: Modal Content -->
    {{--  // Modal Tandatangan Surat //  --}}

    {{--  // Modal Tandatangan Surat Cetak//  --}}
    <div id="cetak" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form method="post" action="{{ route('surat.keluar.tandatangan.cetak') }}" enctype="multipart/form-data"
                id="myForm">
                @csrf
                <div class="modal-content"> <a data-tw-dismiss="modal" href="javascript:;"> <i data-lucide="x"
                            class="w-8 h-8 text-slate-400"></i> </a>
                    <div class="modal-body p-0">
                        <div class="p-5 text-center"> <i data-lucide="check-circle"
                                class="w-16 h-16 text-success mx-auto mt-3"></i>
                            <div class="text-3xl mt-5">Tandatangan Surat ?</div>
                            <input type="hidden" name="id_informasi" value="{{ $isis->id_informasi }}">
                        </div>
                        <div class="px-5 pb-8 text-center"> <button type="submit" data-tw-dismiss="modal"
                                class="btn btn-primary w-24">Ok</button> </div>
                    </div>
                </div>
            </form>
        </div>
    </div> <!-- END: Modal Content -->
    {{--  // Modal Tandatangan Surat Cetak//  --}}


    {{--  // Modal Tandatangan Surat Gambar//  --}}
    <div id="gambar" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form method="post" action="{{ route('surat.keluar.tandatangan.gambar') }}" enctype="multipart/form-data"
                id="myForm">
                @csrf
                <div class="modal-content"> <a data-tw-dismiss="modal" href="javascript:;"> <i data-lucide="x"
                            class="w-8 h-8 text-slate-400"></i> </a>
                    <div class="modal-body p-0">
                        <div class="p-5 text-center"> <i data-lucide="check-circle"
                                class="w-16 h-16 text-success mx-auto mt-3"></i>
                            <div class="text-3xl mt-5">Tandatangan Surat ?</div>
                            <input type="hidden" name="id_informasi" value="{{ $isis->id_informasi }}">

                        </div>
                        <div class="px-5 pb-8 text-center"> <button type="submit" data-tw-dismiss="modal"
                                class="btn btn-primary w-24">Ok</button> </div>
                    </div>
                </div>
            </form>
        </div>
    </div> <!-- END: Modal Content -->
    {{--  // Modal Tandatangan Surat Gambar//  --}}



    <!-- // Modal Tandatangan Digital// -->
    {{--  <div class="modal fade bd-example-modal-xl" id="exampleModalCenterr" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-md  modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Tanda Tangan </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table border="1">
                        <tr>
                            <td>
                                <div id="signature">

                                </div>
                            </td>
                        </tr>
                    </table>

                    <br />

                    <!-- <input type='button' id='click' value='click'> -->
                    <form enctype="multipart/form-data" method="post"
                        action=" {{ route('surat.keluar.tandatangan.langsung') }}" class="form-horizontal"
                        onsubmit="return confirm('Yakin tidak ada perubahan pada tanda tangan anda ?')">
                        <textarea id='output' name="img" style="display:none;"></textarea><br />
                        <img src='' id='sign_prev' style='display: none;' />
                        <br>
                        <br>
                        <div id="tombol-cek" style="display: block;">
                            <input type="button" class="btn btn-success" id="click" value="Cek">
                        </div>
                        <div id="tombol-simpan" style="display: none;">
                            <input type="submit" class="btn btn-success" id="click-simpan" value="Simpan Tanda Tangan">
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                </div>
            </div>
        </div>
    </div>  --}}
    <!-- // Modal Tandatangan  end// -->


@endsection
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

<script type="text/javascript">
    jQuery(document).ready(function() {
        $('#Form').validate({
            rules: {

                ket: {
                    required: true,
                },
            },
            messages: {
                ket: {
                    required: 'Please Enter Your Keterangan',
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
