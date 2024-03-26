@extends('admin.admin_master')
@section('admin')
    <div class="mb-3 intro-y flex flex-col sm:flex-row items-center mt-8">
        <h1 class="text-lg font-medium mr-auto">
            Data Rapor Siswa
        </h1>

    </div>
    @if (Auth::user()->role == '4')
        <div class="mb-4 intro-y flex flex-col sm:flex-row items-center mt-4">

            <form role="form" action="{{ route('rapor.siswa') }}" method="get" class="sm:flex">


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
                <div class="flex-1 mr-1">
                    <div class="form-group">
                        <select name="searchtahun" class="form-select w-full">
                            <option value="">Tahun Ajar</option>
                            @foreach ($datatahun as $item)
                                <option value="{{ $item->id }}">{{ $item->semester }} - {{ $item->tahun }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="sm:ml-1">
                    <button type="submit" class="btn btn-default">Search</button>
                </div>
                <div class="sm:ml-2">

                    <a href="{{ route('rapor.siswa') }}" class="btn btn-danger">Clear</a>

                </div>
            </form>
        </div>

        <div class="col-span-2 mb-2 mt-4">

            <a class="btn btn-pending btn-block" data-tw-toggle="modal" data-tw-target="#pdf-modal-preview">
                <span class="glyphicon glyphicon-download"></span> <i data-lucide="printer" class="w-4 h-4"></i>&nbsp;Legger

            </a>

            <a class="btn btn-primary btn-block" data-tw-toggle="modal" data-tw-target="#excel-modal-preview">
                <span class="glyphicon glyphicon-download"></span> <svg xmlns="http://www.w3.org/2000/svg" width="16"
                    height="16" fill="currentColor" class="bi bi-file-earmark-excel" viewBox="0 0 16 16">
                    <path
                        d="M5.884 6.68a.5.5 0 1 0-.768.64L7.349 10l-2.233 2.68a.5.5 0 0 0 .768.64L8 10.781l2.116 2.54a.5.5 0 0 0 .768-.641L8.651 10l2.233-2.68a.5.5 0 0 0-.768-.64L8 9.219l-2.116-2.54z" />
                    <path
                        d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2M9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5z" />
                </svg>&nbsp;Legger

            </a>

        </div>
    @endif
    @if (Auth::user()->role == '6')
        <div class="mb-4 intro-y flex flex-col sm:flex-row items-center mt-4">

            <form role="form" action="{{ route('rapor.data.siswa') }}" method="get" class="sm:flex">

                <div class="flex-1 mr-1">
                    <div class="form-group">
                        <select name="searchtahun" class="form-select w-full">
                            <option value="">Tahun Ajar</option>
                            @foreach ($datatahun as $item)
                                <option value="{{ $item->id }}">{{ $item->semester }} - {{ $item->tahun }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="sm:ml-1">
                    <button type="submit" class="btn btn-default">Search</button>
                </div>
                <div class="sm:ml-2">

                    <a href="{{ route('rapor.data.siswa') }}" class="btn btn-danger">Clear</a>

                </div>
            </form>
        </div>
    @endif

    @if (Auth::user()->role == '5')
        <div class="mb-4 intro-y flex flex-col sm:flex-row items-center mt-4">

            <form role="form" action="{{ route('rapor.data.siswa.orangtua') }}" method="get" class="sm:flex">

                <div class="flex-1 mr-1">
                    <div class="form-group">
                        <select name="searchtahun" class="form-select w-full">
                            <option value="">Tahun Ajar</option>
                            @foreach ($datatahun as $item)
                                <option value="{{ $item->id }}">{{ $item->semester }} - {{ $item->tahun }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="sm:ml-1">
                    <button type="submit" class="btn btn-default">Search</button>
                </div>
                <div class="sm:ml-2">

                    <a href="{{ route('rapor.data.siswa.orangtua') }}" class="btn btn-danger">Clear</a>

                </div>
            </form>
        </div>
    @endif
    <div class="mb-4 mt-4">
        @if ($datarombelsiswa && isset($datarombelsiswa['rombels']))
            Semester {{ $datarombelsiswa['rombels']['tahuns']['semester'] }}
            Tahun Ajar {{ $datarombelsiswa['rombels']['tahuns']['tahun'] }}
        @endif
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
                                        <th class="whitespace-nowrap">TTL</th>
                                        @if (Auth::user()->role == '4')
                                            @if ($datarombelsiswa->rombels->tahuns->semester == 'Genap')
                                                <th class="whitespace-nowrap">Naik Kelas</th>
                                            @endif
                                        @endif
                                        <th class="whitespace-nowrap">Action</th>

                                </thead>
                                <tbody>

                                    @foreach ($rombelsiswa as $key => $item)
                                        <tr>
                                            <td class="whitespace-nowrap"> {{ $key + 1 }} </td>
                                            <td class="whitespace-nowrap"style="text-transform: capitalize;">
                                                {{ $item->siswas->nama }} </td>
                                            <td class="whitespace-nowrap"> {{ $item->siswas->nisn }} </td>
                                            <td class="whitespace-nowrap">
                                                @if ($item->siswas->jk == 'L')
                                                    L
                                                @elseif ($item->siswas->jk == 'P')
                                                    P
                                                @endif
                                            </td>

                                            <td class="whitespace-nowrap">
                                                {{ $item->rombels->kelass->tingkat }}
                                                {{ $item->rombels->kelass->nama }}
                                                {{ $item->rombels->kelass->jurusans->nama }}
                                            </td>
                                            <td class="whitespace-nowrap" style="text-transform: capitalize;">
                                                {{ $item->siswas->tempat }},
                                                {{ $item->siswas->tanggal }} </td>
                                            @if (Auth::user()->role == '4')
                                                @if ($item->rombels->tahuns->semester == 'Genap')
                                                    <td class="whitespace-nowrap" style="text-transform: capitalize;">
                                                        <div class="ml-4">
                                                            @php
                                                                $rapor = App\Models\Rapor::where(
                                                                    'id_rombelsiswa',
                                                                    $item->id,
                                                                )->first();
                                                            @endphp

                                                            @if ($rapor->naik_kelas == 1)
                                                                <a href="{{ route('tinggal.kelas', $item->id) }}"
                                                                    class="text-success  mr-1 mb-2">
                                                                    <i data-lucide="check" class="w-6 h-6"></i>
                                                                </a>
                                                            @elseif ($rapor->naik_kelas == 0)
                                                                <a href="{{ route('naik.kelas', $item->id) }}"
                                                                    class=" text-danger mr-1 mb-2">
                                                                    <i data-lucide="x" class="w-6 h-6"></i>
                                                                </a>
                                                            @endif

                                                        </div>
                                                @endif
                                            @endif
                                            </td>
                                            <td class="whitespace-nowrap">

                                                <a href="{{ route('nilai.pdf', $item->id) }}"
                                                    class="btn btn-primary mr-1 mb-2">
                                                    <i data-lucide="printer" class="w-4 h-4"></i>&nbsp;Nilai
                                                </a>
                                                <a href="{{ route('rapor.pdf', $item->id) }}"
                                                    class="btn btn-success mr-1 mb-2">
                                                    <i data-lucide="printer" class="w-4 h-4"></i>&nbsp;Rapor
                                                </a>

                                                <a href="{{ route('sampul.siswa.pdf', $item->siswas->id) }}"
                                                    class="btn btn-warning mr-1 mb-2">
                                                    <i data-lucide="printer" class="w-4 h-4"></i>&nbsp;Sampul
                                                </a>
                                                <a href="{{ route('identitas.siswa.pdf', $item->siswas->id) }}"
                                                    class="btn btn-danger mr-1 mb-2">
                                                    <i data-lucide="printer" class="w-4 h-4"></i>&nbsp;Identitas
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


    </div> <!-- export legger-->

    <div id="excel-modal-preview" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- BEGIN: Modal Header -->
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto">Export Legger Nilai</h2>
                    <div class="dropdown sm:hidden"> <a class="dropdown-toggle w-5 h-5 block" href="javascript:;"
                            aria-expanded="false" data-tw-toggle="dropdown"> <i data-lucide="more-horizontal"
                                class="w-5 h-5 text-slate-500"></i> </a>
                        <div class="dropdown-menu w-40">
                        </div>
                    </div>
                </div> <!-- END: Modal Header -->
                <!-- BEGIN: Modal Body -->

                <form method="post" action="{{ route('legger.excel') }}">
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
                        <a href="{{ route('rapor.siswa') }}" class="btn btn-outline-secondary w-20 mr-1">Cancel</a>
                        <button type="submit" class="btn btn-primary w-20">Export</button>
                </form>
            </div>
        </div>
    </div>

    </div> <!-- PDF legger-->

    <div id="pdf-modal-preview" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- BEGIN: Modal Header -->
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto">Cetak Legger Nilai</h2>
                    <div class="dropdown sm:hidden"> <a class="dropdown-toggle w-5 h-5 block" href="javascript:;"
                            aria-expanded="false" data-tw-toggle="dropdown"> <i data-lucide="more-horizontal"
                                class="w-5 h-5 text-slate-500"></i> </a>
                        <div class="dropdown-menu w-40">
                        </div>
                    </div>
                </div> <!-- END: Modal Header -->
                <!-- BEGIN: Modal Body -->

                <form method="post" action="{{ route('legger.pdf') }}">
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
                        <a href="{{ route('rapor.siswa') }}" class="btn btn-outline-secondary w-20 mr-1">Cancel</a>
                        <button type="submit" class="btn btn-primary w-20">Export</button>
                </form>
            </div>
        </div>
    </div>
@endsection
