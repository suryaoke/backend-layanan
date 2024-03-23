@extends('admin.admin_master')
@section('admin')
    <div class="mb-3 intro-y flex flex-col sm:flex-row items-center mt-8">
        <h1 class="text-lg font-medium mr-auto">
            Data Prestasi Siswa All

        </h1>

    </div>


    <div class="flex mb-4 mt-4">

        <a class="btn btn-pending btn-block mr-1" data-tw-toggle="modal" data-tw-target="#excel-modal-preview">
            <span class="glyphicon glyphicon-download"></span> <i data-lucide="download" class="w-4 h-4"></i>&nbsp;Export
        </a>

        <a class="btn btn-success btn-block mr-1" data-tw-toggle="modal" data-tw-target="#header1-footer-modal-preview">
            <span class="glyphicon glyphicon-download"></span> </span> <i data-lucide="upload"
                class="w-5 h-5"></i>&nbsp;Upload</a>



        <a data-tw-toggle="modal" data-tw-target="#header-footer-modal-preview" class="btn btn-primary btn-block"> <span
                class="glyphicon glyphicon-download mr-1"></span> </span> <i data-lucide="edit"
                class="w-5 h-5"></i>&nbsp;Nilai
        </a>
        <div class="ml-1">
            <form role="form" action="{{ route('prestasi.all') }}" method="get" class="flex">
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
                            <option value="{{ $item->id }}">{{ $item->semester }} - {{ $item->tahun }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="ml-1">
                    <button type="submit" class="btn btn-default">Search</button>
                </div>

                <div class="ml-2">
                    <a href="{{ route('prestasi.all') }}" class="btn btn-danger">Clear</a>
                </div>
            </form>
        </div>


    </div>
    <div class="mb-4 mt-4">
        @if ($datacttnwalas && isset($datacttnwalas['tahun']))
            Semester {{ $datacttnwalas['tahun']['semester'] }}
            Tahun Ajar {{ $datacttnwalas['tahun']['tahun'] }}
        @endif
    </div>
   

    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card overflow-x-auto">
                        <div class="card-body">
                            <table id="datatable" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th class="whitespace-nowrap">No</th>
                                        <th class="whitespace-nowrap">NISN</th>
                                        <th class="whitespace-nowrap">Nama</th>
                                        <th class="whitespace-nowrap">Jk</th>
                                        <th class="whitespace-nowrap">Kelas</th>
                                        <th class="whitespace-nowrap">Prestasi</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($cttnwalas as $key => $item)
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
                                                @if ($item->prestasi == null)
                                                    -
                                                @else
                                                    {{ $item->prestasi }}
                                                @endif
                                            </td>


                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>


                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->

    <!-- BEGIN: Modal Toggle -->
    <!-- END: Modal Toggle --> <!-- BEGIN: Modal Content -->
    <div id="header1-footer-modal-preview" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content"> <!-- BEGIN: Modal Header -->
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto">Upload Data Prestasi Siswa</h2>

                    <form method="post" action="{{ route('prestasi.import') }}">
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
                            class="dropzone flex justify-center items-center" action="{{ route('prestasi.upload') }}"
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
                <div class="modal-footer"> <a href="{{ route('prestasi.all') }}" data-tw-dismiss="modal"
                        class="btn btn-danger w-20 mr-1">Cancel</a> <button type="submit"
                        class="btn btn-primary w-20">Save</button> </div> <!-- END: Modal Footer -->
                </form>
            </div>
        </div>
    </div> <!-- END: Modal Content -->

    <div id="excel-modal-preview" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- BEGIN: Modal Header -->
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto">Export Prestasi Siswa</h2>
                    <div class="dropdown sm:hidden"> <a class="dropdown-toggle w-5 h-5 block" href="javascript:;"
                            aria-expanded="false" data-tw-toggle="dropdown"> <i data-lucide="more-horizontal"
                                class="w-5 h-5 text-slate-500"></i> </a>
                        <div class="dropdown-menu w-40">
                        </div>
                    </div>
                </div> <!-- END: Modal Header -->
                <!-- BEGIN: Modal Body -->

                <form method="post" action="{{ route('prestasi.excel') }}">
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
                        <a href="{{ route('prestasi.all') }}" class="btn btn-outline-secondary w-20 mr-1">Cancel</a>
                        <button type="submit" class="btn btn-primary w-20">Export</button>
                </form>
            </div>
        </div>
    </div>


    <!-- BEGIN: Modal Toggle -->


    <!-- END: Modal Toggle --> <!-- BEGIN: Modal Content -->
    <div id="header-footer-modal-preview" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" style="max-width: 90vw; width: 60%;"> <!-- Menambahkan style langsung di sini -->
            <div class="modal-content">
                <!-- BEGIN: Modal Header -->
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto">Prestasi Siswa All</h2>
                </div>
                <!-- END: Modal Header -->
                <!-- BEGIN: Modal Body -->
                <div class="modal-body grid grid-cols-12 gap-4 gap-y-3"
                    style="overflow-x: auto; overflow-y: auto; max-height: 80vh;">
                    <!-- Menambahkan gaya overflow di sini -->
                    <form method="post" action="{{ route('prestasi.update') }}" enctype="multipart/form-data"
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
                                    <th class="whitespace-nowrap">Prestasi <input id="prestasiInput"
                                            style="width: 350px;" type="text"></th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cttnwalas as $key => $item)
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
                                            <input class="prestasiInputField" style="width: 350px;" type="text"
                                                name="prestasi[]" value="{{ $item->prestasi ?? '-' }}">
                                        </td>


                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                </div>
                <!-- END: Modal Body -->
                <!-- BEGIN: Modal Footer -->
                <div class="modal-footer">
                    <a href="{{ route('prestasi.all') }}" type="button" data-tw-dismiss="modal"
                        class="btn btn-danger w-20 mr-1">Cancel</a>
                    <button type="submit" class="btn btn-primary w-20">Save</button>
                </div>
                <!-- END: Modal Footer -->
            </div>
            </form>
        </div>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var judulPrestasi = document.getElementById('prestasiInput');
            var inputPrestasi = document.querySelectorAll('.prestasiInputField');


            judulPrestasi.addEventListener('input', function() {
                var nilaiPrestasi = this.value;
                inputPrestasi.forEach(function(input) {
                    input.value = nilaiPrestasi;
                });
            });

        });
    </script>

    <!-- END: Modal Content -->
@endsection
