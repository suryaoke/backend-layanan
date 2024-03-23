@extends('admin.admin_master')
@section('admin')
    <div class="page-content mt-4">

        <div class="container-fluid">
            <div class="row">
                <style>
                    .custom-yellow-bg {
                        background-color: yellow !important;
                    }
                </style>
                <div class="col-12">

                    <ul class="nav nav-boxed-tabs" role="tablist">
                        <li id="example-3-tab" class="nav-item flex-1" role="presentation">
                            <button class="nav-link w-full py-2 active" data-tw-toggle="pill" data-tw-target="#example-tab-3"
                                type="button" role="tab" aria-controls="example-tab-3" aria-selected="true"> SIKAP
                                SOSIAL </button>
                        </li>
                        <li id="example-4-tab" class="nav-item flex-1" role="presentation">
                            <button class="nav-link w-full py-2" data-tw-toggle="pill" data-tw-target="#example-tab-4"
                                type="button" role="tab" aria-controls="example-tab-4" aria-selected="false"> SIKAP
                                SPIRITUAL</button>
                        </li>
                    </ul>


                </div>
            </div>
        </div>
    </div>

    <div class="overflow-x-auto">


        <div class="tab-content mt-5">
            <div id="example-tab-3" class="tab-pane leading-relaxed active" role="tabpanel" aria-labelledby="example-3-tab">
                <div class="ml-1">
                    <form role="form" action="{{ route('sikap.all') }}" method="get" class="flex">
                        <div class="flex-1 mr-1">
                            <div class="form-group">
                                <input type="text" name="searchnama" class="form-control" placeholder="Nama"
                                    value="{{ request('searchnama') }}">

                            </div>
                        </div>
                        <div class="flex-1 mr-1">
                            <div class="form-group">
                                <input type="text" name="searchnisn" class="form-control" placeholder="Nisn"
                                    value="{{ request('searchnisn') }}">

                            </div>
                        </div>
                        <div class="flex-1 mr-1">
                            <div class="form-group">
                                <input type="text" name="searchjk" class="form-control" placeholder="Jk"
                                    value="{{ request('searchjk') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <select name="searchtahun" class="form-select w-full">
                                <option value="">Tahun Ajar</option>
                                @foreach ($datatahun as $item)
                                    <option value="{{ $item->id }}">{{ $item->semester }} - {{ $item->tahun }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="ml-1">
                            <button type="submit" class="btn btn-default">Search</button>
                        </div>

                        <div class="ml-2">
                            <a href="{{ route('sikap.all') }}" class="btn btn-danger">Clear</a>
                        </div>
                    </form>
                </div>
                <div class="flex mb-4 mt-4">

                    <a class="btn btn-pending btn-block mr-1" data-tw-toggle="modal" data-tw-target="#excel-modal-preview">
                        <span class="glyphicon glyphicon-download"></span> <i data-lucide="download"
                            class="w-5 h-5"></i>&nbsp;Export
                    </a>

                    <a class="btn btn-success btn-block mr-1" data-tw-toggle="modal"
                        data-tw-target="#header1-footer-modal-preview">
                        <span class="glyphicon glyphicon-download"></span> </span> <i data-lucide="upload"
                            class="w-5 h-5"></i>&nbsp;Upload</a>



                    <a data-tw-toggle="modal" data-tw-target="#header-footer-modal-preview"
                        class="btn btn-primary btn-block"> <span class="glyphicon glyphicon-download mr-1"></span> </span>
                        <i data-lucide="edit" class="w-5 h-5"></i>&nbsp;
                        Nilai</a>



                </div>

                <div class="mb-4 mt-4">
                    @if ($rapors && isset($rapors['tahun']))
                        Semester {{ $rapors['tahun']['semester'] }}
                        Tahun Ajar {{ $rapors['tahun']['tahun'] }}
                    @endif
                </div>

                <table id="datatable" class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="whitespace-nowrap">No</th>
                            <th class="whitespace-nowrap">NISN</th>
                            <th class="whitespace-nowrap">Nama</th>
                            <th class="whitespace-nowrap">Jk</th>
                            <th class="whitespace-nowrap">Kelas</th>
                            <th class="whitespace-nowrap">Kejujuran</th>
                            <th class="whitespace-nowrap">Kedisiplinan</th>
                            <th class="whitespace-nowrap">Tanggung Jawab</th>
                            <th class="whitespace-nowrap">Toleransi</th>
                            <th class="whitespace-nowrap">Gotong Royong</th>
                            <th class="whitespace-nowrap">Kesantunan</th>
                            <th class="whitespace-nowrap">Percaya Diri</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rapor as $key => $item)
                            @php
                                $nilaiArray = json_decode($item->nilai_sosial, true);
                            @endphp
                            <tr>
                                <td class="whitespace-nowrap">{{ $key + 1 }}</td>
                                <td style="white-space: nowrap; text-transform: capitalize;">
                                    {{ $item->rombelsiswas->siswas->nisn }}
                                </td>
                                <td style="white-space: nowrap; text-transform: capitalize;">
                                    {{ $item->rombelsiswas->siswas->nama }}
                                </td>
                                <td class="whitespace-nowrap">
                                    @if ($item->rombelsiswas->siswas->jk == 'L')
                                        L
                                    @elseif ($item->rombelsiswas->siswas->jk == 'P')
                                        P
                                    @endif
                                </td>
                                <td style="white-space: nowrap; text-transform: capitalize;">
                                    {{ $item->rombelsiswas->rombels->kelass->tingkat }}
                                    {{ $item->rombelsiswas->rombels->kelass->nama }}
                                    {{ $item->rombelsiswas->rombels->kelass->jurusans->nama }}
                                </td>
                                <td style="white-space: nowrap; text-transform: capitalize; width: 350px;">

                                    @if (isset($nilaiArray[0]))
                                        {{ $nilaiArray[0] }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td style="white-space: nowrap; text-transform: capitalize; width: 350px;">
                                    @if (isset($nilaiArray[1]))
                                        {{ $nilaiArray[1] }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td style="white-space: nowrap; text-transform: capitalize; width: 350px;">
                                    @if (isset($nilaiArray[2]))
                                        {{ $nilaiArray[2] }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td style="white-space: nowrap; text-transform: capitalize; width: 350px;">
                                    @if (isset($nilaiArray[3]))
                                        {{ $nilaiArray[3] }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td style="white-space: nowrap; text-transform: capitalize; width: 350px;">
                                    @if (isset($nilaiArray[4]))
                                        {{ $nilaiArray[4] }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td style="white-space: nowrap; text-transform: capitalize; width: 350px;">
                                    @if (isset($nilaiArray[5]))
                                        {{ $nilaiArray[5] }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td style="white-space: nowrap; text-transform: capitalize; width: 350px;">
                                    @if (isset($nilaiArray[6]))
                                        {{ $nilaiArray[6] }}
                                    @else
                                        -
                                    @endif
                                </td>



                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div id="example-tab-4" class="tab-pane leading-relaxed" role="tabpanel" aria-labelledby="example-4-tab">
                <div class="ml-1">
                    <form role="form" action="{{ route('sikap.all') }}" method="get" class="flex">
                        <div class="flex-1 mr-1">
                            <div class="form-group">
                                <input type="text" name="searchnama" class="form-control" placeholder="Nama"
                                    value="{{ request('searchnama') }}">

                            </div>
                        </div>
                        <div class="flex-1 mr-1">
                            <div class="form-group">
                                <input type="text" name="searchnisn" class="form-control" placeholder="Nisn"
                                    value="{{ request('searchnisn') }}">

                            </div>
                        </div>
                        <div class="flex-1 mr-1">
                            <div class="form-group">
                                <input type="text" name="searchjk" class="form-control" placeholder="Jk"
                                    value="{{ request('searchjk') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <select name="searchtahun" class="form-select w-full">
                                <option value="">Tahun Ajar</option>
                                @foreach ($datatahun as $item)
                                    <option value="{{ $item->id }}">{{ $item->semester }} - {{ $item->tahun }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="ml-1">
                            <button type="submit" class="btn btn-default">Search</button>
                        </div>

                        <div class="ml-2">
                            <a href="{{ route('sikap.all') }}" class="btn btn-danger">Clear</a>
                        </div>
                    </form>
                </div>
                <div class="flex mb-4 mt-4">

                    <a class="btn btn-pending btn-block mr-1" data-tw-toggle="modal"
                        data-tw-target="#excel1-modal-preview">
                        <span class="glyphicon glyphicon-download"></span> <i data-lucide="download"
                            class="w-5 h-5"></i>&nbsp;Export
                    </a>

                    <a class="btn btn-success btn-block mr-1" data-tw-toggle="modal"
                        data-tw-target="#header11-footer-modal-preview">
                        <span class="glyphicon glyphicon-download"></span> </span> <i data-lucide="upload"
                            class="w-5 h-5"></i>&nbsp;Upload</a>



                    <a data-tw-toggle="modal" data-tw-target="#header10-footer-modal-preview"
                        class="btn btn-primary btn-block"> <span class="glyphicon glyphicon-download mr-1"></span> </span>
                        <i data-lucide="edit" class="w-5 h-5"></i>&nbsp;Nilai
                    </a>


                </div>

                <div class="mb-4 mt-4">
                    @if ($rapors && isset($rapors['tahun']))
                        Semester {{ $rapors['tahun']['semester'] }}
                        Tahun Ajar {{ $rapors['tahun']['tahun'] }}
                    @endif
                </div>


                <table id="datatable" class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="whitespace-nowrap">No</th>
                            <th class="whitespace-nowrap">NISN</th>
                            <th class="whitespace-nowrap">Nama</th>
                            <th class="whitespace-nowrap">Jk</th>
                            <th class="whitespace-nowrap">Kelas</th>
                            <th class="whitespace-nowrap">Berdoa</th>
                            <th class="whitespace-nowrap">Memberi Salam</th>
                            <th class="whitespace-nowrap">Sholat Berjamaah</th>
                            <th class="whitespace-nowrap">Bersyukur</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rapor as $key => $item)
                            @php
                                $nilaiArray = json_decode($item->nilai_spiritual, true);
                            @endphp
                            <tr>
                                <td class="whitespace-nowrap">{{ $key + 1 }}</td>
                                <td style="white-space: nowrap; text-transform: capitalize;">
                                    {{ $item->rombelsiswas->siswas->nisn }}
                                </td>
                                <td style="white-space: nowrap; text-transform: capitalize;">
                                    {{ $item->rombelsiswas->siswas->nama }}
                                </td>
                                <td class="whitespace-nowrap">
                                    @if ($item->rombelsiswas->siswas->jk == 'L')
                                        L
                                    @elseif ($item->rombelsiswas->siswas->jk == 'P')
                                        P
                                    @endif
                                </td>
                                <td style="white-space: nowrap; text-transform: capitalize;">
                                    {{ $item->rombelsiswas->rombels->kelass->tingkat }}
                                    {{ $item->rombelsiswas->rombels->kelass->nama }}
                                    {{ $item->rombelsiswas->rombels->kelass->jurusans->nama }}
                                </td>
                                <td style="white-space: nowrap; text-transform: capitalize; width: 350px;">

                                    @if (isset($nilaiArray[0]))
                                        {{ $nilaiArray[0] }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td style="white-space: nowrap; text-transform: capitalize; width: 350px;">
                                    @if (isset($nilaiArray[1]))
                                        {{ $nilaiArray[1] }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td style="white-space: nowrap; text-transform: capitalize; width: 350px;">
                                    @if (isset($nilaiArray[2]))
                                        {{ $nilaiArray[2] }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td style="white-space: nowrap; text-transform: capitalize; width: 350px;">
                                    @if (isset($nilaiArray[3]))
                                        {{ $nilaiArray[3] }}
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>





        <!-- Upload Sosial -->
        <!-- END: Modal Toggle --> <!-- BEGIN: Modal Content -->
        <div id="header1-footer-modal-preview" class="modal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content"> <!-- BEGIN: Modal Header -->
                    <div class="modal-header">
                        <h2 class="font-medium text-base mr-auto">Upload Data Sosial Siswa</h2>

                        <form method="post" action="{{ route('sosial.import') }}">
                            @csrf

                            <select name="tahun" id="tahun" class="form-select w-full" required>

                                @foreach ($datatahun as $item)
                                    <option value="{{ $item->id }}">{{ $item->semester }} -
                                        {{ $item->tahun }}
                                    </option>
                                @endforeach
                            </select>

                            <!-- BEGIN: Modal Footer -->
                            <div class="mt-1">
                                <button type="submit" class="btn btn-outline-secondary hidden sm:flex"> <i
                                        data-lucide="download" class="w-4 h-4 mr-2"></i> Template</button>
                            </div>
                        </form>


                    </div> <!-- END: Modal Header --> <!-- BEGIN: Modal Body -->
                    <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                        <div class="col-span-12 sm:col-span-12">
                            <form
                                data-file-types="application/vnd.ms-excel|application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
                                class="dropzone flex justify-center items-center" action="{{ route('sosial.upload') }}"
                                method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="fallback"> <input name="file" type="file" /> </div>

                                <div class="dz-message" data-dz-message>
                                    <div class="text-center">
                                        <img alt="Midone - HTML Admin Template" class="w-10 mx-auto"
                                            src="{{ asset('backend/dist/images/excel.png') }}">
                                        <div class="text-lg font-medium">Drop files here or click to upload.</div>
                                    </div>
                                </div>
                        </div>

                    </div> <!-- END: Modal Body --> <!-- BEGIN: Modal Footer -->
                    <div class="modal-footer"> <a href="{{ route('sikap.all') }}" data-tw-dismiss="modal"
                            class="btn btn-danger w-20 mr-1">Cancel</a> <button type="submit"
                            class="btn btn-primary w-20">Save</button> </div> <!-- END: Modal Footer -->
                    </form>
                </div>
            </div>
        </div> <!-- END: Modal Content -->

        <!-- Export Sikap Sosial Siswa All Content -->

        <div id="excel-modal-preview" class="modal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- BEGIN: Modal Header -->
                    <div class="modal-header">
                        <h2 class="font-medium text-base mr-auto">Export Sikap Sosial Siswa</h2>
                        <div class="dropdown sm:hidden"> <a class="dropdown-toggle w-5 h-5 block" href="javascript:;"
                                aria-expanded="false" data-tw-toggle="dropdown"> <i data-lucide="more-horizontal"
                                    class="w-5 h-5 text-slate-500"></i> </a>
                            <div class="dropdown-menu w-40">
                            </div>
                        </div>
                    </div> <!-- END: Modal Header -->
                    <!-- BEGIN: Modal Body -->

                    <form method="post" action="{{ route('sosial.excel') }}">
                        @csrf
                        <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">

                            <div class="col-span-12 sm:col-span-6"> <label for="edit-jam">Pilih Tahun Ajar </label>
                                <select name="tahun" id="tahun" class="form-select w-full" required>

                                    @foreach ($datatahun as $item)
                                        <option value="{{ $item->id }}">{{ $item->semester }} -
                                            {{ $item->tahun }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>


                        <!-- BEGIN: Modal Footer -->
                        <div class="modal-footer">
                            <a href="{{ route('sikap.all') }}" class="btn btn-outline-secondary w-20 mr-1">Cancel</a>
                            <button type="submit" class="btn btn-primary w-20">Export</button>
                    </form>
                </div>
            </div>
        </div>


        <!-- BEGIN: Modal Toggle -->


        <!-- Edit Sikap Sosial Siswa All Content -->
        <div id="header-footer-modal-preview" class="modal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog" style="max-width: 90vw; width: 90%; "> <!-- Menambahkan style langsung di sini -->
                <div class="modal-content">
                    <!-- BEGIN: Modal Header -->
                    <div class="modal-header">
                        <h2 class="font-medium text-base mr-auto">Sikap Sosial Siswa All</h2>
                    </div>
                    <!-- END: Modal Header -->
                    <!-- BEGIN: Modal Body -->
                    <div class="modal-body grid grid-cols-12 gap-4 gap-y-3"
                        style="overflow-x: auto; overflow-y: auto; max-height: 80vh;">
                        <!-- Menambahkan gaya overflow di sini -->
                        <form method="post" action="{{ route('sosial.update') }}" enctype="multipart/form-data"
                            id="myForm">
                            @csrf

                            <table id="datatable" class="table table-bordered mx-auto">
                                <thead>
                                    <tr>
                                        <th class="whitespace-nowrap">No</th>
                                        <th class="whitespace-nowrap">NISN</th>
                                        <th class="whitespace-nowrap">Nama</th>
                                        <th class="whitespace-nowrap">Jk</th>
                                        <th class="whitespace-nowrap">Kelas</th>

                                        <th class="whitespace-nowrap">Kejujuran
                                            <select id="kejujuranSelect" style="width: 150px;">
                                                <option value="-">Pilih</option>
                                                <option value="Sangat Baik">Sangat Baik</option>
                                                <option value="Baik">Baik</option>
                                                <option value="Cukup">Cukup</option>
                                                <option value="Kurang">Kurang</option>
                                                <!-- Tambahkan opsi lain sesuai kebutuhan -->
                                            </select>
                                        </th>
                                        <th class="whitespace-nowrap">Kedisiplinan <select id="kedisiplinanSelect"
                                                style="width: 150px;">
                                                <option value="-">Pilih</option>
                                                <option value="Sangat Baik">Sangat Baik</option>
                                                <option value="Baik">Baik</option>
                                                <option value="Cukup">Cukup</option>
                                                <option value="Kurang">Kurang</option>
                                                <!-- Tambahkan opsi lain sesuai kebutuhan -->
                                            </select></th>
                                        <th class="whitespace-nowrap">Tanggung Jawab <select id="tanggungjawabSelect"
                                                style="width: 150px;">
                                                <option value="-">Pilih</option>
                                                <option value="Sangat Baik">Sangat Baik</option>
                                                <option value="Baik">Baik</option>
                                                <option value="Cukup">Cukup</option>
                                                <option value="Kurang">Kurang</option>
                                                <!-- Tambahkan opsi lain sesuai kebutuhan -->
                                            </select></th>
                                        <th class="whitespace-nowrap">Toleransi <select id="toleransiSelect"
                                                style="width: 150px;">
                                                <option value="-">Pilih</option>
                                                <option value="Sangat Baik">Sangat Baik</option>
                                                <option value="Baik">Baik</option>
                                                <option value="Cukup">Cukup</option>
                                                <option value="Kurang">Kurang</option>
                                                <!-- Tambahkan opsi lain sesuai kebutuhan -->
                                            </select></th>
                                        <th class="whitespace-nowrap">Gotong Royong <select id="gotongroyongSelect"
                                                style="width: 150px;">
                                                <option value="-">Pilih</option>
                                                <option value="Sangat Baik">Sangat Baik</option>
                                                <option value="Baik">Baik</option>
                                                <option value="Cukup">Cukup</option>
                                                <option value="Kurang">Kurang</option>
                                                <!-- Tambahkan opsi lain sesuai kebutuhan -->
                                            </select></th>
                                        <th class="whitespace-nowrap">Kesantunan <select id="kesantunanSelect"
                                                style="width: 150px;">
                                                <option value="-">Pilih</option>
                                                <option value="Sangat Baik">Sangat Baik</option>
                                                <option value="Baik">Baik</option>
                                                <option value="Cukup">Cukup</option>
                                                <option value="Kurang">Kurang</option>
                                                <!-- Tambahkan opsi lain sesuai kebutuhan -->
                                            </select></th>
                                        <th class="whitespace-nowrap">Percaya Diri <select id="percayadiriSelect"
                                                style="width: 150px;">
                                                <option value="-">Pilih</option>
                                                <option value="Sangat Baik">Sangat Baik</option>
                                                <option value="Baik">Baik</option>
                                                <option value="Cukup">Cukup</option>
                                                <option value="Kurang">Kurang</option>
                                                <!-- Tambahkan opsi lain sesuai kebutuhan -->
                                            </select></th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($rapor as $key => $item)
                                        @php
                                            $nilaiArray = json_decode($item->nilai_sosial, true);
                                        @endphp
                                        <tr>
                                            <td class="whitespace-nowrap">{{ $key + 1 }}</td>
                                            <td style="white-space: nowrap; text-transform: capitalize;">
                                                {{ $item->rombelsiswas->siswas->nisn }}
                                            </td>
                                            <td style="white-space: nowrap; text-transform: capitalize;">
                                                {{ $item->rombelsiswas->siswas->nama }}
                                            </td>
                                            <td class="whitespace-nowrap">
                                                @if ($item->rombelsiswas->siswas->jk == 'L')
                                                    L
                                                @elseif ($item->rombelsiswas->siswas->jk == 'P')
                                                    P
                                                @endif
                                            </td>

                                            <td style="white-space: nowrap; text-transform: capitalize;">
                                                {{ $item->rombelsiswas->rombels->kelass->tingkat }}
                                                {{ $item->rombelsiswas->rombels->kelass->nama }}
                                                {{ $item->rombelsiswas->rombels->kelass->jurusans->nama }}
                                            </td>
                                            <input style="width: 50px;" type="hidden" name="id[]"
                                                value="{{ $item->id }}">

                                            <td style="white-space: nowrap; text-transform: capitalize;">
                                                <select class="kejujuranInputField" style="width: 150px;"
                                                    name="kejujuran[]">
                                                    <option value="-" {{ $nilaiArray[0] == '-' ? 'selected' : '' }}>
                                                        Pilih
                                                    </option>
                                                    <option value="Sangat Baik"
                                                        {{ $nilaiArray[0] == 'Sangat Baik' ? 'selected' : '' }}>Sangat Baik
                                                    </option>
                                                    <option value="Baik"
                                                        {{ $nilaiArray[0] == 'Baik' ? 'selected' : '' }}>Baik</option>
                                                    <option value="Cukup"
                                                        {{ $nilaiArray[0] == 'Cukup' ? 'selected' : '' }}>Cukup</option>
                                                    <option value="Kurang"
                                                        {{ $nilaiArray[0] == 'Kurang' ? 'selected' : '' }}>Kurang</option>
                                                </select>
                                            </td>
                                            <td style="white-space: nowrap; text-transform: capitalize;">
                                                <select class="kedisiplinanInputField" style="width: 150px;"
                                                    name="kedisiplinan[]">
                                                    <option value="-" {{ $nilaiArray[1] == '-' ? 'selected' : '' }}>
                                                        Pilih
                                                    </option>
                                                    <option value="Sangat Baik"
                                                        {{ $nilaiArray[1] == 'Sangat Baik' ? 'selected' : '' }}>Sangat Baik
                                                    </option>
                                                    <option value="Baik"
                                                        {{ $nilaiArray[1] == 'Baik' ? 'selected' : '' }}>Baik</option>
                                                    <option value="Cukup"
                                                        {{ $nilaiArray[1] == 'Cukup' ? 'selected' : '' }}>Cukup</option>
                                                    <option value="Kurang"
                                                        {{ $nilaiArray[1] == 'Kurang' ? 'selected' : '' }}>Kurang</option>
                                                </select>
                                            </td>


                                            <td style="white-space: nowrap; text-transform: capitalize;">
                                                <select class="tanggungjawabInputField" style="width: 150px;"
                                                    name="tanggungjawab[]">
                                                    <option value="-" {{ $nilaiArray[2] == '-' ? 'selected' : '' }}>
                                                        Pilih
                                                    </option>
                                                    <option value="Sangat Baik"
                                                        {{ $nilaiArray[2] == 'Sangat Baik' ? 'selected' : '' }}>Sangat Baik
                                                    </option>
                                                    <option value="Baik"
                                                        {{ $nilaiArray[2] == 'Baik' ? 'selected' : '' }}>Baik</option>
                                                    <option value="Cukup"
                                                        {{ $nilaiArray[2] == 'Cukup' ? 'selected' : '' }}>Cukup</option>
                                                    <option value="Kurang"
                                                        {{ $nilaiArray[2] == 'Kurang' ? 'selected' : '' }}>Kurang</option>
                                                </select>
                                            </td>
                                            <td style="white-space: nowrap; text-transform: capitalize;">
                                                <select class="toleransiInputField" style="width: 150px;"
                                                    name="toleransi[]">
                                                    <option value="-" {{ $nilaiArray[3] == '-' ? 'selected' : '' }}>
                                                        Pilih
                                                    </option>
                                                    <option value="Sangat Baik"
                                                        {{ $nilaiArray[3] == 'Sangat Baik' ? 'selected' : '' }}>Sangat Baik
                                                    </option>
                                                    <option value="Baik"
                                                        {{ $nilaiArray[3] == 'Baik' ? 'selected' : '' }}>Baik</option>
                                                    <option value="Cukup"
                                                        {{ $nilaiArray[3] == 'Cukup' ? 'selected' : '' }}>Cukup</option>
                                                    <option value="Kurang"
                                                        {{ $nilaiArray[3] == 'Kurang' ? 'selected' : '' }}>Kurang</option>
                                                </select>
                                            </td>
                                            <td style="white-space: nowrap; text-transform: capitalize;">
                                                <select class="gotongroyongInputField" style="width: 150px;"
                                                    name="gotongroyong[]">
                                                    <option value="-" {{ $nilaiArray[4] == '-' ? 'selected' : '' }}>
                                                        Pilih
                                                    </option>
                                                    <option value="Sangat Baik"
                                                        {{ $nilaiArray[4] == 'Sangat Baik' ? 'selected' : '' }}>Sangat Baik
                                                    </option>
                                                    <option value="Baik"
                                                        {{ $nilaiArray[4] == 'Baik' ? 'selected' : '' }}>Baik</option>
                                                    <option value="Cukup"
                                                        {{ $nilaiArray[4] == 'Cukup' ? 'selected' : '' }}>Cukup</option>
                                                    <option value="Kurang"
                                                        {{ $nilaiArray[4] == 'Kurang' ? 'selected' : '' }}>Kurang</option>
                                                </select>
                                            </td>
                                            <td style="white-space: nowrap; text-transform: capitalize;">
                                                <select class="kesantunanInputField" style="width: 150px;"
                                                    name="kesantunan[]">
                                                    <option value="-" {{ $nilaiArray[5] == '-' ? 'selected' : '' }}>
                                                        Pilih
                                                    </option>
                                                    <option value="Sangat Baik"
                                                        {{ $nilaiArray[5] == 'Sangat Baik' ? 'selected' : '' }}>Sangat Baik
                                                    </option>
                                                    <option value="Baik"
                                                        {{ $nilaiArray[5] == 'Baik' ? 'selected' : '' }}>Baik</option>
                                                    <option value="Cukup"
                                                        {{ $nilaiArray[5] == 'Cukup' ? 'selected' : '' }}>Cukup</option>
                                                    <option value="Kurang"
                                                        {{ $nilaiArray[5] == 'Kurang' ? 'selected' : '' }}>Kurang</option>
                                                </select>
                                            </td>

                                            <td style="white-space: nowrap; text-transform: capitalize;">
                                                <select class="percayadiriInputField" style="width: 150px;"
                                                    name="percayadiri[]">
                                                    <option value="-" {{ $nilaiArray[6] == '-' ? 'selected' : '' }}>
                                                        Pilih
                                                    </option>
                                                    <option value="Sangat Baik"
                                                        {{ $nilaiArray[6] == 'Sangat Baik' ? 'selected' : '' }}>Sangat Baik
                                                    </option>
                                                    <option value="Baik"
                                                        {{ $nilaiArray[6] == 'Baik' ? 'selected' : '' }}>Baik</option>
                                                    <option value="Cukup"
                                                        {{ $nilaiArray[6] == 'Cukup' ? 'selected' : '' }}>Cukup</option>
                                                    <option value="Kurang"
                                                        {{ $nilaiArray[6] == 'Kurang' ? 'selected' : '' }}>Kurang</option>
                                                </select>
                                            </td>



                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                    </div>
                    <!-- END: Modal Body -->
                    <!-- BEGIN: Modal Footer -->
                    <div class="modal-footer">
                        <a href="{{ route('sikap.all') }}" type="button" data-tw-dismiss="modal"
                            class="btn btn-danger w-20 mr-1">Cancel</a>
                        <button type="submit" class="btn btn-primary w-20">Save</button>
                    </div>
                    <!-- END: Modal Footer -->
                </div>
                </form>
            </div>
        </div>


        <!-- END: Modal Content -->

        <script>
            // Mendapatkan elemen-elemen yang diperlukan
            var kejujuranSelect = document.getElementById('kejujuranSelect');
            var kejujuranDataSelect = document.getElementsByClassName('kejujuranInputField');

            // Menambahkan event listener untuk perubahan pada kolom judul select
            kejujuranSelect.addEventListener('change', function() {
                // Mendapatkan nilai yang dipilih di kolom judul select
                var nilaiJudul = kejujuranSelect.value;

                // Mengatur nilai di kolom data select sesuai dengan nilai judul yang dipilih
                for (var i = 0; i < kejujuranDataSelect.length; i++) {
                    kejujuranDataSelect[i].value = nilaiJudul;
                }
            });

            var kedisiplinanSelect = document.getElementById('kedisiplinanSelect');
            var kedisiplinanDataSelect = document.getElementsByClassName('kedisiplinanInputField');

            // Menambahkan event listener untuk perubahan pada kolom judul select
            kedisiplinanSelect.addEventListener('change', function() {
                // Mendapatkan nilai yang dipilih di kolom judul select
                var nilaiJudul = kedisiplinanSelect.value;

                // Mengatur nilai di kolom data select sesuai dengan nilai judul yang dipilih
                for (var i = 0; i < kedisiplinanDataSelect.length; i++) {
                    kedisiplinanDataSelect[i].value = nilaiJudul;
                }
            });

            var tanggungjawabSelect = document.getElementById('tanggungjawabSelect');
            var tanggungjawabDataSelect = document.getElementsByClassName('tanggungjawabInputField');

            // Menambahkan event listener untuk perubahan pada kolom judul select
            tanggungjawabSelect.addEventListener('change', function() {
                // Mendapatkan nilai yang dipilih di kolom judul select
                var nilaiJudul = tanggungjawabSelect.value;

                // Mengatur nilai di kolom data select sesuai dengan nilai judul yang dipilih
                for (var i = 0; i < tanggungjawabDataSelect.length; i++) {
                    tanggungjawabDataSelect[i].value = nilaiJudul;
                }
            });


            var toleransiSelect = document.getElementById('toleransiSelect');
            var toleransiDataSelect = document.getElementsByClassName('toleransiInputField');

            // Menambahkan event listener untuk perubahan pada kolom judul select
            toleransiSelect.addEventListener('change', function() {
                // Mendapatkan nilai yang dipilih di kolom judul select
                var nilaiJudul = toleransiSelect.value;

                // Mengatur nilai di kolom data select sesuai dengan nilai judul yang dipilih
                for (var i = 0; i < toleransiDataSelect.length; i++) {
                    toleransiDataSelect[i].value = nilaiJudul;
                }
            });

            var gotongroyongSelect = document.getElementById('gotongroyongSelect');
            var gotongroyongDataSelect = document.getElementsByClassName('gotongroyongInputField');

            // Menambahkan event listener untuk perubahan pada kolom judul select
            gotongroyongSelect.addEventListener('change', function() {
                // Mendapatkan nilai yang dipilih di kolom judul select
                var nilaiJudul = gotongroyongSelect.value;

                // Mengatur nilai di kolom data select sesuai dengan nilai judul yang dipilih
                for (var i = 0; i < gotongroyongDataSelect.length; i++) {
                    gotongroyongDataSelect[i].value = nilaiJudul;
                }
            });

            var kesantunanSelect = document.getElementById('kesantunanSelect');
            var kesantunanDataSelect = document.getElementsByClassName('kesantunanInputField');

            // Menambahkan event listener untuk perubahan pada kolom judul select
            kesantunanSelect.addEventListener('change', function() {
                // Mendapatkan nilai yang dipilih di kolom judul select
                var nilaiJudul = kesantunanSelect.value;

                // Mengatur nilai di kolom data select sesuai dengan nilai judul yang dipilih
                for (var i = 0; i < kesantunanDataSelect.length; i++) {
                    kesantunanDataSelect[i].value = nilaiJudul;
                }
            });

            var percayadiriSelect = document.getElementById('percayadiriSelect');
            var percayadiriDataSelect = document.getElementsByClassName('percayadiriInputField');

            // Menambahkan event listener untuk perubahan pada kolom judul select
            percayadiriSelect.addEventListener('change', function() {
                // Mendapatkan nilai yang dipilih di kolom judul select
                var nilaiJudul = percayadiriSelect.value;

                // Mengatur nilai di kolom data select sesuai dengan nilai judul yang dipilih
                for (var i = 0; i < percayadiriDataSelect.length; i++) {
                    percayadiriDataSelect[i].value = nilaiJudul;
                }
            });
        </script>


        <!-- Export Sikap Spiritual Siswa All Content -->

        <div id="excel1-modal-preview" class="modal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- BEGIN: Modal Header -->
                    <div class="modal-header">
                        <h2 class="font-medium text-base mr-auto">Export Sikap Spiritual Siswa</h2>
                        <div class="dropdown sm:hidden"> <a class="dropdown-toggle w-5 h-5 block" href="javascript:;"
                                aria-expanded="false" data-tw-toggle="dropdown"> <i data-lucide="more-horizontal"
                                    class="w-5 h-5 text-slate-500"></i> </a>
                            <div class="dropdown-menu w-40">
                            </div>
                        </div>
                    </div> <!-- END: Modal Header -->
                    <!-- BEGIN: Modal Body -->

                    <form method="post" action="{{ route('spiritual.excel') }}">
                        @csrf
                        <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">

                            <div class="col-span-12 sm:col-span-6"> <label for="edit-jam">Pilih Tahun Ajar </label>
                                <select name="tahun" id="tahun" class="form-select w-full" required>

                                    @foreach ($datatahun as $item)
                                        <option value="{{ $item->id }}">{{ $item->semester }} -
                                            {{ $item->tahun }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>


                        <!-- BEGIN: Modal Footer -->
                        <div class="modal-footer">
                            <a href="{{ route('sikap.all') }}" class="btn btn-outline-secondary w-20 mr-1">Cancel</a>
                            <button type="submit" class="btn btn-primary w-20">Export</button>
                    </form>
                </div>
            </div>
        </div>


        <!-- Edit Sikap Spiritual Siswa All Content -->
        <div id="header10-footer-modal-preview" class="modal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog" style="max-width: 90vw; width: 90%; "> <!-- Menambahkan style langsung di sini -->
                <div class="modal-content">
                    <!-- BEGIN: Modal Header -->
                    <div class="modal-header">
                        <h2 class="font-medium text-base mr-auto">Sikap Spiritual Siswa All</h2>
                    </div>
                    <!-- END: Modal Header -->
                    <!-- BEGIN: Modal Body -->
                    <div class="modal-body grid grid-cols-12 gap-4 gap-y-3"
                        style="overflow-x: auto; overflow-y: auto; max-height: 80vh;">
                        <!-- Menambahkan gaya overflow di sini -->
                        <form method="post" action="{{ route('spiritual.update') }}" enctype="multipart/form-data"
                            id="myForm">
                            @csrf

                            <table id="datatable" class="table table-bordered mx-auto">
                                <thead>
                                    <tr>
                                        <th class="whitespace-nowrap">No</th>
                                        <th class="whitespace-nowrap">NISN</th>
                                        <th class="whitespace-nowrap">Nama</th>
                                        <th class="whitespace-nowrap">Jk</th>
                                        <th class="whitespace-nowrap">Kelas</th>

                                        <th class="whitespace-nowrap">Berdoa
                                            <select id="berdoaSelect" style="width: 150px;">
                                                <option value="-">Pilih</option>
                                                <option value="Sangat Baik">Sangat Baik</option>
                                                <option value="Baik">Baik</option>
                                                <option value="Cukup">Cukup</option>
                                                <option value="Kurang">Kurang</option>
                                                <!-- Tambahkan opsi lain sesuai kebutuhan -->
                                            </select>
                                        </th>
                                        <th class="whitespace-nowrap">Memberi Salam <select id="memberisalamSelect"
                                                style="width: 150px;">
                                                <option value="-">Pilih</option>
                                                <option value="Sangat Baik">Sangat Baik</option>
                                                <option value="Baik">Baik</option>
                                                <option value="Cukup">Cukup</option>
                                                <option value="Kurang">Kurang</option>
                                                <!-- Tambahkan opsi lain sesuai kebutuhan -->
                                            </select></th>
                                        <th class="whitespace-nowrap">Sholat Berjamaah <select id="sholatberjamaahSelect"
                                                style="width: 150px;">
                                                <option value="-">Pilih</option>
                                                <option value="Sangat Baik">Sangat Baik</option>
                                                <option value="Baik">Baik</option>
                                                <option value="Cukup">Cukup</option>
                                                <option value="Kurang">Kurang</option>
                                                <!-- Tambahkan opsi lain sesuai kebutuhan -->
                                            </select></th>
                                        <th class="whitespace-nowrap">Bersyukur <select id="bersyukurSelect"
                                                style="width: 150px;">
                                                <option value="-">Pilih</option>
                                                <option value="Sangat Baik">Sangat Baik</option>
                                                <option value="Baik">Baik</option>
                                                <option value="Cukup">Cukup</option>
                                                <option value="Kurang">Kurang</option>
                                                <!-- Tambahkan opsi lain sesuai kebutuhan -->
                                            </select></th>



                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($rapor as $key => $item)
                                        @php
                                            $nilaiArray = json_decode($item->nilai_spiritual, true);
                                        @endphp
                                        <tr>
                                            <td class="whitespace-nowrap">{{ $key + 1 }}</td>
                                            <td style="white-space: nowrap; text-transform: capitalize;">
                                                {{ $item->rombelsiswas->siswas->nisn }}
                                            </td>
                                            <td style="white-space: nowrap; text-transform: capitalize;">
                                                {{ $item->rombelsiswas->siswas->nama }}
                                            </td>
                                            <td class="whitespace-nowrap">
                                                @if ($item->rombelsiswas->siswas->jk == 'L')
                                                    L
                                                @elseif ($item->rombelsiswas->siswas->jk == 'P')
                                                    P
                                                @endif
                                            </td>
                                            <td style="white-space: nowrap; text-transform: capitalize;">
                                                {{ $item->rombelsiswas->rombels->kelass->tingkat }}
                                                {{ $item->rombelsiswas->rombels->kelass->nama }}
                                                {{ $item->rombelsiswas->rombels->kelass->jurusans->nama }}
                                            </td>
                                            <input style="width: 50px;" type="hidden" name="id[]"
                                                value="{{ $item->id }}">

                                            <td style="white-space: nowrap; text-transform: capitalize;">
                                                <select class="berdoaInputField" style="width: 150px;" name="berdoa[]">
                                                    <option value="-" {{ $nilaiArray[0] == '-' ? 'selected' : '' }}>
                                                        Pilih
                                                    </option>
                                                    <option value="Sangat Baik"
                                                        {{ $nilaiArray[0] == 'Sangat Baik' ? 'selected' : '' }}>Sangat
                                                        Baik
                                                    </option>
                                                    <option value="Baik"
                                                        {{ $nilaiArray[0] == 'Baik' ? 'selected' : '' }}>Baik</option>
                                                    <option value="Cukup"
                                                        {{ $nilaiArray[0] == 'Cukup' ? 'selected' : '' }}>Cukup</option>
                                                    <option value="Kurang"
                                                        {{ $nilaiArray[0] == 'Kurang' ? 'selected' : '' }}>Kurang</option>
                                                </select>
                                            </td>
                                            <td style="white-space: nowrap; text-transform: capitalize;">
                                                <select class="memberisalamInputField" style="width: 150px;"
                                                    name="memberisalam[]">
                                                    <option value="-" {{ $nilaiArray[1] == '-' ? 'selected' : '' }}>
                                                        Pilih
                                                    </option>
                                                    <option value="Sangat Baik"
                                                        {{ $nilaiArray[1] == 'Sangat Baik' ? 'selected' : '' }}>Sangat
                                                        Baik
                                                    </option>
                                                    <option value="Baik"
                                                        {{ $nilaiArray[1] == 'Baik' ? 'selected' : '' }}>Baik</option>
                                                    <option value="Cukup"
                                                        {{ $nilaiArray[1] == 'Cukup' ? 'selected' : '' }}>Cukup</option>
                                                    <option value="Kurang"
                                                        {{ $nilaiArray[1] == 'Kurang' ? 'selected' : '' }}>Kurang</option>
                                                </select>
                                            </td>


                                            <td style="white-space: nowrap; text-transform: capitalize;">
                                                <select class="sholatberjamaahInputField" style="width: 150px;"
                                                    name="sholatberjamaah[]">
                                                    <option value="-" {{ $nilaiArray[2] == '-' ? 'selected' : '' }}>
                                                        Pilih
                                                    </option>
                                                    <option value="Sangat Baik"
                                                        {{ $nilaiArray[2] == 'Sangat Baik' ? 'selected' : '' }}>Sangat
                                                        Baik
                                                    </option>
                                                    <option value="Baik"
                                                        {{ $nilaiArray[2] == 'Baik' ? 'selected' : '' }}>Baik</option>
                                                    <option value="Cukup"
                                                        {{ $nilaiArray[2] == 'Cukup' ? 'selected' : '' }}>Cukup</option>
                                                    <option value="Kurang"
                                                        {{ $nilaiArray[2] == 'Kurang' ? 'selected' : '' }}>Kurang</option>
                                                </select>
                                            </td>

                                            <td style="white-space: nowrap; text-transform: capitalize;">
                                                <select class="bersyukurInputField" style="width: 150px;"
                                                    name="bersyukur[]">
                                                    <option value="-" {{ $nilaiArray[3] == '-' ? 'selected' : '' }}>
                                                        Pilih
                                                    </option>
                                                    <option value="Sangat Baik"
                                                        {{ $nilaiArray[3] == 'Sangat Baik' ? 'selected' : '' }}>Sangat
                                                        Baik
                                                    </option>
                                                    <option value="Baik"
                                                        {{ $nilaiArray[3] == 'Baik' ? 'selected' : '' }}>Baik</option>
                                                    <option value="Cukup"
                                                        {{ $nilaiArray[3] == 'Cukup' ? 'selected' : '' }}>Cukup</option>
                                                    <option value="Kurang"
                                                        {{ $nilaiArray[3] == 'Kurang' ? 'selected' : '' }}>Kurang</option>
                                                </select>
                                            </td>


                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                    </div>
                    <!-- END: Modal Body -->
                    <!-- BEGIN: Modal Footer -->
                    <div class="modal-footer">
                        <a href="{{ route('sikap.all') }}" type="button" data-tw-dismiss="modal"
                            class="btn btn-danger w-20 mr-1">Cancel</a>
                        <button type="submit" class="btn btn-primary w-20">Save</button>
                    </div>
                    <!-- END: Modal Footer -->
                </div>
                </form>
            </div>
        </div>


        <!-- END: Modal Content -->

        <script>
            // Mendapatkan elemen-elemen yang diperlukan
            var berdoaSelect = document.getElementById('berdoaSelect');
            var berdoaDataSelect = document.getElementsByClassName('berdoaInputField');

            // Menambahkan event listener untuk perubahan pada kolom judul select
            berdoaSelect.addEventListener('change', function() {
                // Mendapatkan nilai yang dipilih di kolom judul select
                var nilaiJudul = berdoaSelect.value;

                // Mengatur nilai di kolom data select sesuai dengan nilai judul yang dipilih
                for (var i = 0; i < berdoaDataSelect.length; i++) {
                    berdoaDataSelect[i].value = nilaiJudul;
                }
            });


            var memberisalamSelect = document.getElementById('memberisalamSelect');
            var memberisalamDataSelect = document.getElementsByClassName('memberisalamInputField');

            // Menambahkan event listener untuk perubahan pada kolom judul select
            memberisalamSelect.addEventListener('change', function() {
                // Mendapatkan nilai yang dipilih di kolom judul select
                var nilaiJudul = memberisalamSelect.value;

                // Mengatur nilai di kolom data select sesuai dengan nilai judul yang dipilih
                for (var i = 0; i < memberisalamDataSelect.length; i++) {
                    memberisalamDataSelect[i].value = nilaiJudul;
                }
            });

            var sholatberjamaahSelect = document.getElementById('sholatberjamaahSelect');
            var sholatberjamaahDataSelect = document.getElementsByClassName('sholatberjamaahInputField');

            // Menambahkan event listener untuk perubahan pada kolom judul select
            sholatberjamaahSelect.addEventListener('change', function() {
                // Mendapatkan nilai yang dipilih di kolom judul select
                var nilaiJudul = sholatberjamaahSelect.value;

                // Mengatur nilai di kolom data select sesuai dengan nilai judul yang dipilih
                for (var i = 0; i < sholatberjamaahDataSelect.length; i++) {
                    sholatberjamaahDataSelect[i].value = nilaiJudul;
                }
            });


            var bersyukurSelect = document.getElementById('bersyukurSelect');
            var bersyukurDataSelect = document.getElementsByClassName('bersyukurInputField');

            // Menambahkan event listener untuk perubahan pada kolom judul select
            bersyukurSelect.addEventListener('change', function() {
                // Mendapatkan nilai yang dipilih di kolom judul select
                var nilaiJudul = bersyukurSelect.value;

                // Mengatur nilai di kolom data select sesuai dengan nilai judul yang dipilih
                for (var i = 0; i < bersyukurDataSelect.length; i++) {
                    bersyukurDataSelect[i].value = nilaiJudul;
                }
            });
        </script>



        <!-- Upload Spiritual -->
        <!-- END: Modal Toggle --> <!-- BEGIN: Modal Content -->
        <div id="header11-footer-modal-preview" class="modal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content"> <!-- BEGIN: Modal Header -->
                    <div class="modal-header">
                        <h2 class="font-medium text-base mr-auto">Upload Data Spiritual Siswa</h2>

                        <form method="post" action="{{ route('spiritual.import') }}">
                            @csrf

                            <select name="tahun" id="tahun" class="form-select w-full" required>

                                @foreach ($datatahun as $item)
                                    <option value="{{ $item->id }}">{{ $item->semester }} -
                                        {{ $item->tahun }}
                                    </option>
                                @endforeach
                            </select>

                            <!-- BEGIN: Modal Footer -->
                            <div class="mt-1">
                                <button type="submit" class="btn btn-outline-secondary hidden sm:flex"> <i
                                        data-lucide="download" class="w-4 h-4 mr-2"></i> Template</button>
                            </div>
                        </form>


                    </div> <!-- END: Modal Header --> <!-- BEGIN: Modal Body -->
                    <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                        <div class="col-span-12 sm:col-span-12">
                            <form
                                data-file-types="application/vnd.ms-excel|application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
                                class="dropzone flex justify-center items-center"
                                action="{{ route('spiritual.upload') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="fallback"> <input name="file" type="file" /> </div>

                                <div class="dz-message" data-dz-message>
                                    <div class="text-center">
                                        <img alt="Midone - HTML Admin Template" class="w-10 mx-auto"
                                            src="{{ asset('backend/dist/images/excel.png') }}">
                                        <div class="text-lg font-medium">Drop files here or click to upload.</div>
                                    </div>
                                </div>
                        </div>

                    </div> <!-- END: Modal Body --> <!-- BEGIN: Modal Footer -->
                    <div class="modal-footer"> <a href="{{ route('sikap.all') }}" data-tw-dismiss="modal"
                            class="btn btn-danger w-20 mr-1">Cancel</a> <button type="submit"
                            class="btn btn-primary w-20">Save</button> </div> <!-- END: Modal Footer -->
                    </form>
                </div>
            </div>
        </div> <!-- END: Modal Content -->
    @endsection
