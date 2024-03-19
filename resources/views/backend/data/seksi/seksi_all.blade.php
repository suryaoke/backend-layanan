@extends('admin.admin_master')
@section('admin')
    <h1 class="text-lg font-medium mb-4 mt-4 ml-1"> Data Seksi All</h1>
    <div class="mb-4 intro-y flex flex-col sm:flex-row items-center mt-4">

        <form role="form" action="{{ route('seksi.all') }}" method="get" class="sm:flex">
            <div class="flex-1 sm:mr-2">
                <div class="form-group">
                    <input type="text" name="searchseksi" class="form-control" placeholder="Seksi"
                        value="{{ request('searchseksi') }}">
                </div>
            </div>

            <div class="flex-1 sm:mr-2">
                <div class="form-group">
                    <input type="text" name="searchmapel" class="form-control" placeholder="Mata Pelajaran"
                        value="{{ request('searchmapel') }}">

                </div>
            </div>
            <div class="flex-1 sm:mr-2">
                <div class="form-group">
                    <input type="text" name="searchguru" class="form-control" placeholder="Nama Guru"
                        value="{{ request('searchguru') }}">
                </div>
            </div>
            <div class="flex-1 sm:mr-2">
                <div class="form-group">

                    <select name="searchkelas" class="form-select w-full">
                        <option value="">Kelas</option>
                        @foreach ($kelas as $item)
                            <option value="{{ $item->id }}">{{ $item->tingkat }} {{ $item->nama }}
                                {{ $item->jurusans->nama }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="flex-1 sm:mr-2">
                <div class="form-group">

                    <select name="searchtahun" class="form-select w-full">
                        <option value="">Tahun Ajar</option>
                        @foreach ($datatahun as $item)
                            <option value="{{ $item->id }}">{{ $item->semester }} -
                                {{ $item->tahun }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="sm:ml-1">
                <button type="submit" class="btn btn-default">Search</button>
            </div>
            <div class="sm:ml-2">

                <a href="{{ route('seksi.all') }}" class="btn btn-danger">Clear</a>

            </div>
        </form>
    </div>
    <div class="col-span-2 mb-4 mt-4 intro-y flex flex-col sm:flex-row">
        <div class="sm:ml-1">
            <a class="btn btn-pending btn-block" data-tw-toggle="modal" data-tw-target="#excel-modal-preview">
                <span class="glyphicon glyphicon-download"></span> <i data-lucide="download"
                    class="w-4 h-4"></i>&nbsp;Export
            </a>
        </div>
        <div class="sm:ml-1">
            <a href="{{ route('seksi.add') }}" class="btn btn-primary btn-block"></span> </span> <i
                    data-lucide="plus-square" class="w-5 h-5"></i>&nbsp;Tambah Data</a>
            </a>
        </div>

    </div>
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card overflow-x-auto">
                        <div class="card-body">
                            <table id="datatable" class="table table-sm"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Seksi</th>
                                        <th>Kode</th>
                                        <th style="white-space: nowrap;">Mata Pelajaran</th>
                                        <th> Guru</th>
                                        <th style="white-space: nowrap;">Kelas / Rombel</th>
                                        <th>Tahun Ajar</th>
                                        <th>Action</th>
                                </thead>
                                <tbody>
                                    @foreach ($seksi as $key => $item)
                                        <tr>
                                            <td> {{ $key + 1 }} </td>
                                            <td style="white-space: nowrap;" class="text-primary"> {{ $item->kode_seksi }}
                                            </td>
                                            <td style="white-space: nowrap;" class="text-primary">
                                                {{ $item['jadwalmapels']['pengampus']['kode_pengampu'] }}
                                            </td>
                                            <td style="white-space: nowrap;">
                                                {{ $item['jadwalmapels']['pengampus']['mapels']['nama'] }}
                                            </td>
                                            <td> {{ $item['jadwalmapels']['pengampus']['gurus']['nama'] }} </td>
                                            <td> {{ $item['rombels']['kelass']['tingkat'] }}
                                                {{ $item['rombels']['kelass']['nama'] }}
                                                {{ $item['rombels']['kelass']['jurusans']['nama'] }} </td>
                                            <td style="white-space: nowrap;">
                                                {{ $item['semesters']['semester'] }} / {{ $item['semesters']['tahun'] }}
                                            </td>
                                            <td>
                                                <a id="delete" href="{{ route('seksi.delete', $item->id) }}"
                                                    class="btn btn-danger mr-1 mb-2">
                                                    <i data-lucide="trash" class="w-4 h-4"></i> </a>
                                                <a href="{{ route('seksi.edit', $item->id) }}"
                                                    class="btn btn-success mr-1 mb-2">
                                                    <i data-lucide="edit" class="w-4 h-4"></i>
                                                </a>
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



    <div id="excel-modal-preview" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- BEGIN: Modal Header -->
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto">Export Seksi All</h2>
                    <div class="dropdown sm:hidden"> <a class="dropdown-toggle w-5 h-5 block" href="javascript:;"
                            aria-expanded="false" data-tw-toggle="dropdown"> <i data-lucide="more-horizontal"
                                class="w-5 h-5 text-slate-500"></i> </a>
                        <div class="dropdown-menu w-40">
                        </div>
                    </div>
                </div> <!-- END: Modal Header -->
                <!-- BEGIN: Modal Body -->

                <form method="post" action="{{ route('seksi.excel') }}">
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
                        <a href="{{ route('seksi.all') }}" class="btn btn-outline-secondary w-20 mr-1">Cancel</a>
                        <button type="submit" class="btn btn-primary w-20">Export</button>
                </form>
            </div>
        </div>
    </div>
@endsection
