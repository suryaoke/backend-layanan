@extends('admin.admin_master')
@section('admin')
    <div class="mb-3 intro-y flex flex-col sm:flex-row items-center mt-8">
        <h1 class="text-lg font-medium mr-auto" style="font-size: 20px">
            Data Rombongan Belajar All
        </h1>

    </div>

    <div class="mb-4 intro-y flex flex-col sm:flex-row items-center mt-4">

        <form role="form" action="{{ route('rombel.all') }}" method="get" class="sm:flex">

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

                <a href="{{ route('rombel.all') }}" class="btn btn-danger">Clear</a>

            </div>
        </form>
    </div>

    <div class="col-span-2 mb-4 mt-4">
        @if ($rombelsiswa && $rombelsiswa->rombels)
            <a href="{{ route('rombel.delete', $rombelsiswa->rombels->id) }}" id="delete"
                class="btn btn-danger btn-block">
                <span class="glyphicon glyphicon-download"></span> <i data-lucide="trash" class="w-5 h-5"></i>&nbsp;Rombel
            </a>
            <a class="btn btn-pending btn-block" data-tw-toggle="modal" data-tw-target="#excel-modal-preview">
                <span class="glyphicon glyphicon-download"></span> <i data-lucide="download"
                    class="w-4 h-4"></i>&nbsp;Export
            </a>
            <a href="{{ route('rombel.edit', $rombelsiswa->rombels->id) }}" class="btn btn-success btn-block">
                <span class="glyphicon glyphicon-download"></span> <i data-lucide="edit" class="w-5 h-5"></i>&nbsp;Edit Data
            </a>
        @endif
        <a href="{{ route('rombel.add') }}" class="btn btn-primary btn-block">
            <span class="glyphicon glyphicon-download"></span> <i data-lucide="plus-square" class="w-5 h-5"></i>&nbsp;Tambah
            Data
        </a>
      
    </div>

    @if (isset(
            $rombelsiswa['rombels']['tahuns'],
            $rombelsiswa['rombels']['kelass'],
            $rombelsiswa['rombels']['kelass']['jurusans'],
            $rombelsiswa['rombels']['walass']['gurus']))
        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card overflow-x-auto">
                            <div class="card-body">

                                <div class="intro-y alert alert-primary show mb-2 " role="alert">
                                    <span>
                                        Semester {{ $rombelsiswa['rombels']['tahuns']['semester'] }}
                                        Tahun Ajar {{ $rombelsiswa['rombels']['tahuns']['tahun'] }} | Kelas :
                                        {{ $rombelsiswa->rombels->kelass->tingkat }}
                                        {{ $rombelsiswa->rombels->kelass->nama }}
                                        {{ $rombelsiswa->rombels->kelass->jurusans->nama }} | Wali Kelas:
                                        {{ $rombelsiswa->rombels->walass->gurus->nama }}
                                    </span>
                                </div>
                                <table id="datatable" class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="whitespace-nowrap">No</th>
                                            <th class="whitespace-nowrap">Nama</th>
                                            <th class="whitespace-nowrap">Nisn</th>
                                            <th class="whitespace-nowrap">Jk</th>
                                            <th class="whitespace-nowrap">Kelas</th>

                                    </thead>
                                    <tbody>
                                        @foreach ($rombelsiswaa as $key => $item)
                                            <tr>
                                                <td class="whitespace-nowrap"> {{ $key + 1 }} </td>
                                                <td class="whitespace-nowrap">
                                                    {{ $item->siswas->nama }}
                                                </td>
                                                <td class="whitespace-nowrap">
                                                    {{ $item->siswas->nisn }}
                                                </td>
                                                <td class="whitespace-nowrap">
                                                    {{ $item->siswas->jk }}
                                                </td>
                                                <td class="whitespace-nowrap">
                                                    {{ $item->rombels->kelass->tingkat }}
                                                    {{ $item->rombels->kelass->nama }}
                                                    {{ $item->rombels->kelass->jurusans->nama }}

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
        </div>
    @endif

    <!-- BEGIN: Modal Excel-->

    <div id="excel-modal-preview" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- BEGIN: Modal Header -->
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto">Export Rombongan Belajar</h2>
                    <div class="dropdown sm:hidden"> <a class="dropdown-toggle w-5 h-5 block" href="javascript:;"
                            aria-expanded="false" data-tw-toggle="dropdown"> <i data-lucide="more-horizontal"
                                class="w-5 h-5 text-slate-500"></i> </a>
                        <div class="dropdown-menu w-40">
                        </div>
                    </div>
                </div> <!-- END: Modal Header -->
                <!-- BEGIN: Modal Body -->

                <form method="post" action="{{ route('rombel.excel') }}">
                    @csrf
                    <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                        <div class="col-span-12 sm:col-span-6"> <label for="edit-jam">Pilih Kelas </label>
                            <select name="kelas" id="kelas" class="form-select w-full" required>

                                @foreach ($kelas as $item)
                                    <option value="{{ $item->id }}"> {{ $item->tingkat }}{{ $item->nama }}
                                        {{ $item['jurusans']['nama'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
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
                        <a href="{{ route('rombel.all') }}" class="btn btn-outline-secondary w-20 mr-1">Cancel</a>
                        <button type="submit" class="btn btn-primary w-20">Export</button>
                </form>
            </div>
        </div>
    </div>

    <!-- BEGIN: Modal Excel -->
@endsection
