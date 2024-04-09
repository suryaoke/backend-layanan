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

    <div class="mb-3 intro-y flex flex-col sm:flex-row items-center mt-8">
        <h1 class="text-lg font-medium mr-auto">
            Data Pengampu Mata Pelajaran All
        </h1>

    </div>
    <div class="mb-4 intro-y flex flex-col sm:flex-row items-center mt-4">

        <form role="form" action="{{ route('pengampu.all') }}" method="get" class="sm:flex">

            <div class="flex-1 sm:mr-2">
                <div class="form-group">
                    <input type="text" name="searchkode" class="form-control" placeholder="Kode Pengampu"
                        value="{{ request('searchkode') }}">
                </div>
            </div>
            <div class="flex-1 sm:mr-2">
                <div class="form-group">
                    <input type="text" name="searchguru" class="form-control" placeholder="Nama Guru"
                        value="{{ request('searchguru') }}">
                </div>
            </div>
            <div class="flex-2 sm:mr-2">
                <div class="form-group">
                    <input type="text" name="searchmapel" class="form-control" placeholder="Nama Mata Pelajaran"
                        value="{{ request('searchmapel') }}">

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
                        @foreach ($tahun as $item)
                            <option value="{{ $item->id }}"> {{ $item->semester }} /
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

                <a href="{{ route('pengampu.all') }}" class="btn btn-danger">Clear</a>

            </div>
        </form>
    </div>
    {{--  // End Bagian search //  --}}

    <div class="col-span-2 mb-4 mt-4">

        <a class="btn btn-pending btn-block" href="{{ route('pengampu.excel') }} ">
            <span class="glyphicon glyphicon-download"></span> </span> <i data-lucide="download"
                class="w-5 h-5"></i>&nbsp;Export
        </a>

        <a href="javascript:;" class="btn btn-success btn-block" data-tw-toggle="modal"
            data-tw-target="#header-footer-modal-preview">
            <span class="glyphicon glyphicon-download"></span> </span> <i data-lucide="upload"
                class="w-5 h-5"></i>&nbsp;Upload</a>


        <a href="{{ route('pengampu.add') }}" class="btn btn-primary btn-block"> <span
                class="glyphicon glyphicon-download"></span> </span> <i data-lucide="plus-square"
                class="w-5 h-5"></i>&nbsp;Tambah Data</a>


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
                                        <th>No</th>
                                        <th style="white-space: nowrap;">Kode Pengampu</th>
                                        <th style="white-space: nowrap;">Nama Guru</th>
                                        <th style="white-space: nowrap;">Kode Guru</th>
                                        <th style="white-space: nowrap;">Mata Pelajaran</th>
                                        <th style="white-space: nowrap;">Kode Mapel</th>
                                        <th style="white-space: nowrap;">Kelas</th>
                                        <th style="white-space: nowrap;">Tahun Ajar</th>
                                        <th>Action</th>
                                </thead>
                                <tbody>

                                    @foreach ($pengampu as $key => $item)
                                        <tr>
                                            <td style="text-align: center;"> {{ $key + 1 }} </td>
                                            <td style="white-space: nowrap;">
                                                {{ $item->kode_pengampu }} </td>
                                            <td style="white-space: nowrap;"> {{ $item['gurus']['nama'] }} </td>
                                            <td style="white-space: nowrap;"> {{ $item['gurus']['kode_gr'] }} </td>
                                            <td style="white-space: nowrap;"> {{ $item['mapels']['nama'] }} </td>
                                            <td style="white-space: nowrap;"> {{ $item['mapels']['kode_mapel'] }} </td>
                                            <td style="white-space: nowrap;"> {{ $item['kelass']['tingkat'] }}
                                                {{ $item['kelass']['nama'] }}
                                                {{ $item['kelass']['jurusans']['nama'] }} </td>
                                            <td style="white-space: nowrap;">
                                                {{ $item->tahuns->semester }} / {{ $item->tahuns->tahun }} </td>
                                            <td style="white-space: nowrap;">
                                                <a id="delete" href="{{ route('pengampu.delete', $item->id) }}"
                                                    class="btn btn-danger mr-1 mb-2">
                                                    <i data-lucide="trash" class="w-4 h-4"></i> </a>
                                                <a href="{{ route('pengampu.edit', $item->id) }}"
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

    <!-- BEGIN: Modal Toggle -->
    <!-- END: Modal Toggle --> <!-- BEGIN: Modal Content -->
    <div id="header-footer-modal-preview" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content"> <!-- BEGIN: Modal Header -->
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto">Upload Data Pengampu</h2> <a
                        href="{{ route('pengampu.upload.excel') }}" class="btn btn-outline-secondary hidden sm:flex"> <i
                            data-lucide="download" class="w-4 h-4 mr-2"></i>
                        Template </a>

                </div> <!-- END: Modal Header --> <!-- BEGIN: Modal Body -->
                <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                    <div class="col-span-12 sm:col-span-12">
                        <form
                            data-file-types="application/vnd.ms-excel|application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
                            class="dropzone flex justify-center items-center" action="{{ route('pengampu.upload') }}"
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
                <div class="modal-footer"> <a href="{{ route('pengampu.all') }}" data-tw-dismiss="modal"
                        class="btn btn-danger w-20 mr-1">Cancel</a> <button type="submit"
                        class="btn btn-primary w-20">Save</button> </div> <!-- END: Modal Footer -->
                </form>
            </div>
        </div>
    </div> <!-- END: Modal Content -->
@endsection
