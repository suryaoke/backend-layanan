@extends('admin.admin_master')
@section('admin')
    <div class="mb-3 intro-y flex flex-col sm:flex-row items-center mt-8">
        <h1 class="text-lg font-medium mr-auto">
            Data Siswa All
        </h1>

    </div>

    <div class="flex mb-4 mt-4">


        <a class="btn btn-pending btn-block mr-1" data-tw-toggle="modal" data-tw-target="#excel-modal-preview">
            <span class="glyphicon glyphicon-download"></span> <i data-lucide="download" class="w-4 h-4"></i>&nbsp;Export
        </a>

        <div class="ml-1">
            <form role="form" action="{{ route('siswa.guruwalas') }}" method="get" class="flex">
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
                    <a href="{{ route('siswa.guruwalas') }}" class="btn btn-danger">Clear</a>
                </div>
            </form>
        </div>


    </div>
    <div class="mb-4 mt-4">
        Semester {{ $datarombelsiswa['rombels']['tahuns']['semester'] }}
        Tahun Ajar {{ $datarombelsiswa['rombels']['tahuns']['tahun'] }}
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
                                        <th class="whitespace-nowrap">No</th>
                                        <th class="whitespace-nowrap">Nama</th>
                                        <th class="whitespace-nowrap">Nisn</th>
                                        <th class="whitespace-nowrap">JK</th>
                                        <th class="whitespace-nowrap">Kelas</th>
                                        <th class="whitespace-nowrap">Action</th>

                                </thead>
                                <tbody>

                                    @foreach ($rombelsiswa as $key => $item)
                                        <tr>
                                            <td class="whitespace-nowrap"> {{ $key + 1 }} </td>
                                            <td class="whitespace-nowrap"> {{ $item->siswas->nama }} </td>
                                            <td class="whitespace-nowrap"> {{ $item->siswas->nisn }} </td>
                                            <td class="whitespace-nowrap">
                                                @if ($item->siswas->jk == 'L')
                                                    Laki - Laki
                                                @elseif ($item->siswas->jk == 'P')
                                                    Perempuan
                                                @endif
                                            </td>

                                            <td class="whitespace-nowrap">
                                                {{ $item->rombels->kelass->tingkat }}
                                                {{ $item->rombels->kelass->nama }}
                                                {{ $item->rombels->kelass->jurusans->nama }}
                                            </td>
                                            <td class="whitespace-nowrap">

                                                <a href="{{ route('siswa.walas.edit', $item->siswas->id) }}"
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
                    <h2 class="font-medium text-base mr-auto">Export Data Siswa</h2>
                    <div class="dropdown sm:hidden"> <a class="dropdown-toggle w-5 h-5 block" href="javascript:;"
                            aria-expanded="false" data-tw-toggle="dropdown"> <i data-lucide="more-horizontal"
                                class="w-5 h-5 text-slate-500"></i> </a>
                        <div class="dropdown-menu w-40">
                        </div>
                    </div>
                </div> <!-- END: Modal Header -->
                <!-- BEGIN: Modal Body -->

                <form method="post" action="{{ route('siswawalas.excel') }}">
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
                        <a href="{{ route('siswa.guruwalas') }}" class="btn btn-outline-secondary w-20 mr-1">Cancel</a>
                        <button type="submit" class="btn btn-primary w-20">Export</button>
                </form>
            </div>
        </div>
    </div>
@endsection
