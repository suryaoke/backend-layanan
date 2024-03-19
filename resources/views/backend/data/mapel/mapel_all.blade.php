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
            Data Mata Pelajaran All
        </h1>

    </div>

    <div class="col-span-2 mb-4 mt-4">

        <a class="btn btn-pending btn-block" href="{{ route('mapel.excel') }} ">
            <span class="glyphicon glyphicon-download"></span> </span> <i data-lucide="download"
                class="w-5 h-5"></i>&nbsp;Export
        </a>

        <a href="javascript:;" class="btn btn-success btn-block" data-tw-toggle="modal"
            data-tw-target="#header-footer-modal-preview">
            <span class="glyphicon glyphicon-download"></span> </span> <i data-lucide="upload"
                class="w-5 h-5"></i>&nbsp;Upload</a>

        @if (Auth::user()->role == '1' || Auth::user()->role == '3')
            <a href="{{ route('mapel.add') }}" class="btn btn-primary btn-block"> <span
                    class="glyphicon glyphicon-download"></span> </span> <i data-lucide="plus-square"
                    class="w-5 h-5"></i>&nbsp;Tambah Data</a>
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
                                        <th>No</th>
                                        <th style="white-space: nowrap;">Kode Mapel</th>
                                        <th style="white-space: nowrap;">Induk</th>
                                        <th style="white-space: nowrap;">Nama</th>
                                        <th style="white-space: nowrap;">JP</th>
                                        <th style="white-space: nowrap;">Jurusan</th>
                                        <th style="white-space: nowrap;">Kelompok</th>
                                        <th style="white-space: nowrap;">Type</th>

                                        <th style="white-space: nowrap;">Action</th>
                                </thead>
                                <tbody>

                                    @foreach ($mapel as $key => $item)
                                        <tr>
                                            <td style="text-align: center;"> {{ $key + 1 }} </td>

                                            <td style="white-space: nowrap; text-align: center;"> {{ $item->kode_mapel }}
                                            </td>
                                            <td>
                                                @if ($item->induk === null)
                                                    -
                                                @else
                                                    {{ $item->induk }}
                                                @endif
                                            </td>
                                            <td style="white-space: nowrap;" style="text-transform: capitalize;">
                                                {{ $item->nama }} </td>
                                            <td style="text-align: center;"> {{ $item->jp }} </td>

                                            <td style="text-align: center;"> {{ $item['jurusans']['nama'] ?? 'Not Found' }}
                                            </td>

                                            <td style="white-space: nowrap;">Kelompok {{ $item->jenis }} </td>
                                            <td style="text-align: center;"> {{ $item->type }} </td>
                                            <td class="whitespace-nowrap">
                                                <a id="delete" href="{{ route('mapel.delete', $item->id) }}"
                                                    class="btn btn-danger mr-1 mb-2">
                                                    <i data-lucide="trash" class="w-4 h-4"></i>
                                                </a>
                                                <a href="{{ route('mapel.edit', $item->id) }}"
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
                    <h2 class="font-medium text-base mr-auto">Upload Data Mapel</h2> <a
                        href="{{ asset('/template/Template Mapel.xlsx') }}"
                        class="btn btn-outline-secondary hidden sm:flex"> <i data-lucide="download"
                            class="w-4 h-4 mr-2"></i>
                        Template </a>

                </div> <!-- END: Modal Header --> <!-- BEGIN: Modal Body -->
                <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                    <div class="col-span-12 sm:col-span-12">
                        <form
                            data-file-types="application/vnd.ms-excel|application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
                            class="dropzone flex justify-center items-center" action="{{ route('mapel.upload') }}"
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
                <div class="modal-footer"> <a href="{{ route('mapel.all') }}" data-tw-dismiss="modal"
                        class="btn btn-danger w-20 mr-1">Cancel</a> <button type="submit"
                        class="btn btn-primary w-20">Save</button> </div> <!-- END: Modal Footer -->
                </form>
            </div>
        </div>
    </div> <!-- END: Modal Content -->
@endsection
