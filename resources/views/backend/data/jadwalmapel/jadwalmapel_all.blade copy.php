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

    <style>
        .horizontal-align {
            display: inline-flex;
            /* atau display: inline-block; */
            align-items: center;
            /* Optional: Untuk menengahkan ikon dan teks secara vertikal jika dibutuhkan */
        }
    </style>

    @php
        use Carbon\Carbon;
    @endphp

    <div class="page-content mt-4">
        <div class="container-fluid">
            <div class="row">

                <div class="col-12">
                    <ul class="nav nav-boxed-tabs" role="tablist">
                        <li id="example-5-tab" class="nav-item flex-1" role="presentation"> <button
                                class="nav-link w-full py-2 active" data-tw-toggle="pill" data-tw-target="#example-tab-5"
                                type="button" role="tab" aria-controls="example-tab-3" aria-selected="true"> REKAP
                                JADWAL MAPEL </button> </li>
                        <li id="example-5-tab" class="nav-item flex-1" role="presentation"> <button
                                class="nav-link w-full py-2" data-tw-toggle="pill" data-tw-target="#example-tab-6"
                                type="button" role="tab" aria-controls="example-tab-4" aria-selected="false">
                                RUBAH JADWAL MAPEL </button> </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class=" intro-y flex flex-col sm:flex-row items-center mt-4">

            <form role="form" action="{{ route('jadwalmapel.all') }}" method="get" class="sm:flex">
                <div class="flex-1 sm:mr-2">
                    <div class="form-group">
                        <input type="text" name="searchhari" class="form-control" placeholder="Hari"
                            value="{{ request('searchhari') }}">
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
                        <input type="text" name="searchmapel" class="form-control" placeholder="Mata Pelajaran"
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

                    <a href="{{ route('jadwalmapel.all') }}" class="btn btn-danger">Clear</a>

                </div>
            </form>
        </div>
        {{--  // End Bagian search //  --}}


        <div class="col-span-2 mb-4 mt-4 intro-y flex flex-col sm:flex-row">
            <div class="sm:ml-1">

                <a class="btn btn-pending btn-block" data-tw-toggle="modal" data-tw-target="#excel-modal-preview">
                    <span class="glyphicon glyphicon-download"></span> <i data-lucide="download"
                        class="w-4 h-4"></i>&nbsp;Export

                </a>
            </div>
            <div class="sm:ml-1">
                <a class="btn btn-success btn-block" data-tw-toggle="modal" data-tw-target="#button-modal-preview">
                    <span class="glyphicon glyphicon-download"></span> <i data-lucide="send" class="w-4 h-4"></i>&nbsp;Kirim
                    Jadwal
                </a>
            </div>
            <div class="sm:ml-1">
                @if (Auth::user()->role == '1' || Auth::user()->role == '3')
                    <a data-tw-toggle="modal" data-tw-target="#add-jadwalmapels-modal" class="btn btn-primary btn-block">
                        <span class="glyphicon glyphicon-download"></span> </span> <i data-lucide="plus-square"
                            class="w-5 h-5"></i>&nbsp;Tambah Data</a>
                @endif
            </div>
            <div class="sm:ml-1">

                <a class="btn btn-danger btn-block" data-tw-toggle="modal" data-tw-target="#generate-modal-preview">
                    <span class="glyphicon glyphicon-download"></span> <i data-lucide="plus-square"
                        class="w-4 h-4"></i>&nbsp;Generate

                </a>
            </div>

        </div>

        <div class="col-span-2 mb-2 mt-4">
            @if (
                !empty($jadwal) &&
                    isset($jadwal['tahun']) &&
                    isset($jadwal['tahun']['semester']) &&
                    isset($jadwal['tahun']['tahun']))
                Semester {{ $jadwal['tahun']['semester'] }}
                Tahun Ajar {{ $jadwal['tahun']['tahun'] }}
            @endif

        </div>
    </div>

    <div class="overflow-x-auto">
        <div class="tab-content mt-4">
            <div id="example-tab-5" class="tab-pane leading-relaxed active" role="tabpanel"
                aria-labelledby="example-5-tab">

                <table id="datatable1" class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center " style="background-color: rgb(187,191,195)">Hari</th>
                            <th class="text-center "style="background-color: rgb(187,191,195); white-space: nowrap;">Waktu
                            </th>
                            @php
                                $kelasGroups = collect();
                            @endphp
                            @foreach ($jadwalmapel as $key => $jadwal)
                                @php
                                    $kelas = $jadwal->pengampus->kelas;
                                    if (!$kelasGroups->has($kelas)) {
                                        $kelasGroups->put($kelas, collect());
                                    }
                                    $kelasGroups[$kelas]->push($jadwal);

                                @endphp
                            @endforeach
                            @php
                                $kelasGroups = $kelasGroups->sortKeys();
                            @endphp
                            @if ($jadwal)
                                @foreach ($kelasGroups as $kelas => $jadwalByClass)
                                    @php
                                        $tingkat = App\Models\Kelas::where('id', $kelas)->first();
                                    @endphp
                                    <th colspan="3" class="text-center " style="background-color: rgb(187,191,195)">
                                        {{ $tingkat->tingkat }} {{ $tingkat->nama }}
                                        {{ $tingkat['jurusans']['nama'] }}
                                    </th>
                                @endforeach
                            @else
                                <th colspan="3" class="text-center " style="background-color: rgb(187,191,195)">
                                    Kelas
                                </th>
                            @endif

                        </tr>
                        <tr>
                            <th class="text-center "style="background-color: rgb(187,191,195)"></th>
                            <th class="text-center "style="background-color: rgb(187,191,195)"></th>
                            @if ($jadwal)
                                @foreach ($kelasGroups as $kelas => $jadwalByClass)
                                    <th style="white-space: nowrap;" class="btn-primary text-center">
                                        Kode Guru</th>
                                    <th style=" white-space: nowrap;" class="btn-primary text-center">
                                        Kode Mapel</th>
                                    <th style="white-space: nowrap;" class="btn-primary text-center">
                                        Ruangan</th>
                                @endforeach
                            @else
                                <th style="white-space: nowrap;" class="btn-primary text-center">
                                    Kode Guru</th>
                                <th style=" white-space: nowrap;" class="btn-primary text-center">
                                    Kode Mapel</th>
                                <th style="white-space: nowrap;" class="btn-primary text-center">
                                    Ruangan</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $j = 3; // Inisialisasi $j di sini
                            if ($jadwal) {
                                $j = 3 * $kelas;
                            }
                            $guruDuplicate = false;
                        @endphp

                        {{--  // hari senin  --}}

                        @foreach ($hari->where('kode_hari', 'H01') as $key => $itemhari)
                            <tr>

                                <td rowspan="20" style="background-color: rgb(187,191,195)" class="text-center">
                                    {{ $itemhari->nama }}
                                </td>

                                <td style="white-space: nowrap;background-color: rgb(187,191,195)" class="text-center">
                                    07:00 - 08:00</td>
                                <td colspan="{{ $j }}" class="text-center" style="background-color: yellow">
                                    UPACARA</td>
                            </tr>

                            <tr>
                                <td style="white-space: nowrap;background-color: rgb(187,191,195)" class="text-center">
                                    08:00 - 08:40</td>

                                @foreach ($kelasGroups as $kelas => $jadwalByClass)
                                    @php
                                        $kode_guru = ''; // Initialize kode guru as empty string
                                        $kode_mapel = ''; // Initialize kode mapel as empty string
                                        $kode_ruangan = ''; // Initialize kode ruangan as empty string

                                    @endphp
                                    @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                                        @php
                                            $waktu1 = explode('-', $jadwalKelas->id_waktu);
                                            $start_time = $waktu1[0];
                                            $end_time = $waktu1[1];

                                            // Check if the desired time range falls within the id_waktu range
                                            $desired_start_time = '08:00';
                                            $desired_end_time = '08:40';
                                            $time_within_range =
                                                $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                                            $guruDuplicate = false;
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;

                                                $guruDuplicate =
                                                    App\Models\Jadwalmapel::join(
                                                        'pengampus',
                                                        'jadwalmapels.id_pengampu',
                                                        '=',
                                                        'pengampus.id',
                                                    )
                                                        ->where('pengampus.id_guru', $jadwalKelas->pengampus->id_guru)
                                                        ->where('jadwalmapels.id_hari', 1)
                                                        ->where('jadwalmapels.id_waktu', $jadwalKelas->id_waktu)
                                                        ->count() > 1;
                                            }

                                        @endphp
                                    @endforeach

                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_guru }}</td>

                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_mapel }}</td>
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_ruangan }}</td>
                                @endforeach
                            </tr>

                            <tr>
                                <td style="white-space: nowrap;background-color: rgb(187,191,195)" class="text-center">
                                    08:40 - 09:20</td>
                                @foreach ($kelasGroups as $kelas => $jadwalByClass)
                                    @php
                                        $kode_guru = ''; // Initialize kode guru as empty string
                                        $kode_mapel = ''; // Initialize kode mapel as empty string
                                        $kode_ruangan = ''; // Initialize kode ruangan as empty string

                                    @endphp
                                    @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                                        @php
                                            $waktu1 = explode('-', $jadwalKelas->id_waktu);
                                            $start_time = $waktu1[0];
                                            $end_time = $waktu1[1];

                                            // Check if the desired time range falls within the id_waktu range
                                            $desired_start_time = '08:40';
                                            $desired_end_time = '09:20';
                                            $time_within_range =
                                                $desired_start_time >= $start_time && $desired_end_time <= $end_time;

                                            $guruDuplicate = false;
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                                $guruDuplicate =
                                                    App\Models\Jadwalmapel::join(
                                                        'pengampus',
                                                        'jadwalmapels.id_pengampu',
                                                        '=',
                                                        'pengampus.id',
                                                    )
                                                        ->where('pengampus.id_guru', $jadwalKelas->pengampus->id_guru)
                                                        ->where('jadwalmapels.id_hari', 1)
                                                        ->where('jadwalmapels.id_waktu', $jadwalKelas->id_waktu)
                                                        ->count() > 1;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_guru }}</td>

                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_mapel }}</td>
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_ruangan }}</td>
                                @endforeach
                            </tr>

                            <tr>
                                <td style="white-space: nowrap;background-color: rgb(187,191,195)" class="text-center">
                                    09:20 - 10:00</td>
                                @foreach ($kelasGroups as $kelas => $jadwalByClass)
                                    @php
                                        $kode_guru = ''; // Initialize kode guru as empty string
                                        $kode_mapel = ''; // Initialize kode mapel as empty string
                                        $kode_ruangan = ''; // Initialize kode ruangan as empty string

                                    @endphp
                                    @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                                        @php
                                            $waktu1 = explode('-', $jadwalKelas->id_waktu);
                                            $start_time = $waktu1[0];
                                            $end_time = $waktu1[1];

                                            // Check if the desired time range falls within the id_waktu range
                                            $desired_start_time = '09:20';
                                            $desired_end_time = '10:00';
                                            $time_within_range =
                                                $desired_start_time >= $start_time && $desired_end_time <= $end_time;

                                            $guruDuplicate = false;
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                                $guruDuplicate =
                                                    App\Models\Jadwalmapel::join(
                                                        'pengampus',
                                                        'jadwalmapels.id_pengampu',
                                                        '=',
                                                        'pengampus.id',
                                                    )
                                                        ->where('pengampus.id_guru', $jadwalKelas->pengampus->id_guru)
                                                        ->where('jadwalmapels.id_hari', 1)
                                                        ->where('jadwalmapels.id_waktu', $jadwalKelas->id_waktu)
                                                        ->count() > 1;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_guru }}</td>

                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_mapel }}</td>
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_ruangan }}</td>
                                @endforeach
                            </tr>

                            <tr>
                                <td style="white-space: nowrap;background-color: rgb(187,191,195)" class="text-center">
                                    10:00 - 10:20</td>

                                <td colspan="{{ $j }}" class="text-center"style="background-color: yellow">
                                    ISTIRAHAT</td>
                            </tr>

                            <tr>
                                <td style="white-space: nowrap;background-color: rgb(187,191,195)" class="text-center">
                                    10:20 - 10:40</td>
                                @foreach ($kelasGroups as $kelas => $jadwalByClass)
                                    @php
                                        $kode_guru = ''; // Initialize kode guru as empty string
                                        $kode_mapel = ''; // Initialize kode mapel as empty string
                                        $kode_ruangan = ''; // Initialize kode ruangan as empty string

                                    @endphp
                                    @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                                        @php
                                            $waktu1 = explode('-', $jadwalKelas->id_waktu);
                                            $start_time = $waktu1[0];
                                            $end_time = $waktu1[1];

                                            // Check if the desired time range falls within the id_waktu range
                                            $desired_start_time = '10:20';
                                            $desired_end_time = '10:40';
                                            $time_within_range =
                                                $desired_start_time >= $start_time && $desired_end_time <= $end_time;

                                            $guruDuplicate = false;
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                                $guruDuplicate =
                                                    App\Models\Jadwalmapel::join(
                                                        'pengampus',
                                                        'jadwalmapels.id_pengampu',
                                                        '=',
                                                        'pengampus.id',
                                                    )
                                                        ->where('pengampus.id_guru', $jadwalKelas->pengampus->id_guru)
                                                        ->where('jadwalmapels.id_hari', 1)
                                                        ->where('jadwalmapels.id_waktu', $jadwalKelas->id_waktu)
                                                        ->count() > 1;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_guru }}</td>

                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_mapel }}</td>
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_ruangan }}</td>
                                @endforeach
                            </tr>
                            <tr>
                                <td style="white-space: nowrap;background-color: rgb(187,191,195)" class="text-center">
                                    10:40 - 11:00</td>
                                @foreach ($kelasGroups as $kelas => $jadwalByClass)
                                    @php
                                        $kode_guru = ''; // Initialize kode guru as empty string
                                        $kode_mapel = ''; // Initialize kode mapel as empty string
                                        $kode_ruangan = ''; // Initialize kode ruangan as empty string

                                    @endphp
                                    @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                                        @php
                                            $waktu1 = explode('-', $jadwalKelas->id_waktu);
                                            $start_time = $waktu1[0];
                                            $end_time = $waktu1[1];

                                            // Check if the desired time range falls within the id_waktu range
                                            $desired_start_time = '10:40';
                                            $desired_end_time = '11:00';
                                            $time_within_range =
                                                $desired_start_time >= $start_time && $desired_end_time <= $end_time;

                                            $guruDuplicate = false;
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                                $guruDuplicate =
                                                    App\Models\Jadwalmapel::join(
                                                        'pengampus',
                                                        'jadwalmapels.id_pengampu',
                                                        '=',
                                                        'pengampus.id',
                                                    )
                                                        ->where('pengampus.id_guru', $jadwalKelas->pengampus->id_guru)
                                                        ->where('jadwalmapels.id_hari', 1)
                                                        ->where('jadwalmapels.id_waktu', $jadwalKelas->id_waktu)
                                                        ->count() > 1;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_guru }}</td>

                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_mapel }}</td>
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_ruangan }}</td>
                                @endforeach
                            </tr>
                            <tr>
                                <td style="white-space: nowrap;background-color: rgb(187,191,195)" class="text-center">
                                    11:00 - 11:20</td>
                                @foreach ($kelasGroups as $kelas => $jadwalByClass)
                                    @php
                                        $kode_guru = ''; // Initialize kode guru as empty string
                                        $kode_mapel = ''; // Initialize kode mapel as empty string
                                        $kode_ruangan = ''; // Initialize kode ruangan as empty string

                                    @endphp
                                    @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                                        @php
                                            $waktu1 = explode('-', $jadwalKelas->id_waktu);
                                            $start_time = $waktu1[0];
                                            $end_time = $waktu1[1];

                                            // Check if the desired time range falls within the id_waktu range
                                            $desired_start_time = '11:00';
                                            $desired_end_time = '11:20';
                                            $time_within_range =
                                                $desired_start_time >= $start_time && $desired_end_time <= $end_time;

                                            $guruDuplicate = false;
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                                $guruDuplicate =
                                                    App\Models\Jadwalmapel::join(
                                                        'pengampus',
                                                        'jadwalmapels.id_pengampu',
                                                        '=',
                                                        'pengampus.id',
                                                    )
                                                        ->where('pengampus.id_guru', $jadwalKelas->pengampus->id_guru)
                                                        ->where('jadwalmapels.id_hari', 1)
                                                        ->where('jadwalmapels.id_waktu', $jadwalKelas->id_waktu)
                                                        ->count() > 1;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_guru }}</td>

                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_mapel }}</td>
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_ruangan }}</td>
                                @endforeach
                            </tr>
                            <tr>
                                <td style="white-space: nowrap;background-color: rgb(187,191,195)" class="text-center">
                                    11:20 - 11:40</td>
                                @foreach ($kelasGroups as $kelas => $jadwalByClass)
                                    @php
                                        $kode_guru = ''; // Initialize kode guru as empty string
                                        $kode_mapel = ''; // Initialize kode mapel as empty string
                                        $kode_ruangan = ''; // Initialize kode ruangan as empty string

                                    @endphp
                                    @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                                        @php
                                            $waktu1 = explode('-', $jadwalKelas->id_waktu);
                                            $start_time = $waktu1[0];
                                            $end_time = $waktu1[1];

                                            // Check if the desired time range falls within the id_waktu range
                                            $desired_start_time = '11:20';
                                            $desired_end_time = '11:40';
                                            $time_within_range =
                                                $desired_start_time >= $start_time && $desired_end_time <= $end_time;

                                            $guruDuplicate = false;
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                                $guruDuplicate =
                                                    App\Models\Jadwalmapel::join(
                                                        'pengampus',
                                                        'jadwalmapels.id_pengampu',
                                                        '=',
                                                        'pengampus.id',
                                                    )
                                                        ->where('pengampus.id_guru', $jadwalKelas->pengampus->id_guru)
                                                        ->where('jadwalmapels.id_hari', 1)
                                                        ->where('jadwalmapels.id_waktu', $jadwalKelas->id_waktu)
                                                        ->count() > 1;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_guru }}</td>

                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_mapel }}</td>
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_ruangan }}</td>
                                @endforeach
                            </tr>
                            <tr>
                                <td style="white-space: nowrap;background-color: rgb(187,191,195)" class="text-center">
                                    11:40 - 12:00</td>
                                @foreach ($kelasGroups as $kelas => $jadwalByClass)
                                    @php
                                        $kode_guru = ''; // Initialize kode guru as empty string
                                        $kode_mapel = ''; // Initialize kode mapel as empty string
                                        $kode_ruangan = ''; // Initialize kode ruangan as empty string

                                    @endphp
                                    @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                                        @php
                                            $waktu1 = explode('-', $jadwalKelas->id_waktu);
                                            $start_time = $waktu1[0];
                                            $end_time = $waktu1[1];

                                            // Check if the desired time range falls within the id_waktu range
                                            $desired_start_time = '11:40';
                                            $desired_end_time = '12:00';
                                            $time_within_range =
                                                $desired_start_time >= $start_time && $desired_end_time <= $end_time;

                                            $guruDuplicate = false;
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                                $guruDuplicate =
                                                    App\Models\Jadwalmapel::join(
                                                        'pengampus',
                                                        'jadwalmapels.id_pengampu',
                                                        '=',
                                                        'pengampus.id',
                                                    )
                                                        ->where('pengampus.id_guru', $jadwalKelas->pengampus->id_guru)
                                                        ->where('jadwalmapels.id_hari', 1)
                                                        ->where('jadwalmapels.id_waktu', $jadwalKelas->id_waktu)
                                                        ->count() > 1;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_guru }}</td>

                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_mapel }}</td>
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_ruangan }}</td>
                                @endforeach
                            </tr>
                            <tr>
                                <td style="white-space: nowrap;background-color: rgb(187,191,195)" class="text-center">
                                    12:00 - 12:20</td>
                                @foreach ($kelasGroups as $kelas => $jadwalByClass)
                                    @php
                                        $kode_guru = ''; // Initialize kode guru as empty string
                                        $kode_mapel = ''; // Initialize kode mapel as empty string
                                        $kode_ruangan = ''; // Initialize kode ruangan as empty string

                                    @endphp
                                    @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                                        @php
                                            $waktu1 = explode('-', $jadwalKelas->id_waktu);
                                            $start_time = $waktu1[0];
                                            $end_time = $waktu1[1];

                                            // Check if the desired time range falls within the id_waktu range
                                            $desired_start_time = '12:00';
                                            $desired_end_time = '12:20';
                                            $time_within_range =
                                                $desired_start_time >= $start_time && $desired_end_time <= $end_time;

                                            $guruDuplicate = false;
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                                $guruDuplicate =
                                                    App\Models\Jadwalmapel::join(
                                                        'pengampus',
                                                        'jadwalmapels.id_pengampu',
                                                        '=',
                                                        'pengampus.id',
                                                    )
                                                        ->where('pengampus.id_guru', $jadwalKelas->pengampus->id_guru)
                                                        ->where('jadwalmapels.id_hari', 1)
                                                        ->where('jadwalmapels.id_waktu', $jadwalKelas->id_waktu)
                                                        ->count() > 1;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_guru }}</td>

                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_mapel }}</td>
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_ruangan }}</td>
                                @endforeach
                            </tr>
                            <tr>
                                <td style="white-space: nowrap;background-color: rgb(187,191,195)" class="text-center">
                                    12:20 - 13:00</td>

                                <td colspan="{{ $j }}" class="text-center" style="background-color: yellow">
                                    ISTIRAHAT</td>
                            </tr>
                            <tr>
                                <td style="white-space: nowrap;background-color: rgb(187,191,195)" class="text-center">
                                    13:00 - 13:20</td>
                                @foreach ($kelasGroups as $kelas => $jadwalByClass)
                                    @php
                                        $kode_guru = ''; // Initialize kode guru as empty string
                                        $kode_mapel = ''; // Initialize kode mapel as empty string
                                        $kode_ruangan = ''; // Initialize kode ruangan as empty string

                                    @endphp
                                    @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                                        @php
                                            $waktu1 = explode('-', $jadwalKelas->id_waktu);
                                            $start_time = $waktu1[0];
                                            $end_time = $waktu1[1];

                                            // Check if the desired time range falls within the id_waktu range
                                            $desired_start_time = '13:00';
                                            $desired_end_time = '13:20';
                                            $time_within_range =
                                                $desired_start_time >= $start_time && $desired_end_time <= $end_time;

                                            $guruDuplicate = false;
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                                $guruDuplicate =
                                                    App\Models\Jadwalmapel::join(
                                                        'pengampus',
                                                        'jadwalmapels.id_pengampu',
                                                        '=',
                                                        'pengampus.id',
                                                    )
                                                        ->where('pengampus.id_guru', $jadwalKelas->pengampus->id_guru)
                                                        ->where('jadwalmapels.id_hari', 1)
                                                        ->where('jadwalmapels.id_waktu', $jadwalKelas->id_waktu)
                                                        ->count() > 1;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_guru }}</td>

                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_mapel }}</td>
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_ruangan }}</td>
                                @endforeach
                            </tr>
                            <tr>
                                <td style="white-space: nowrap;background-color: rgb(187,191,195)" class="text-center">
                                    13:20 - 13:40</td>
                                @foreach ($kelasGroups as $kelas => $jadwalByClass)
                                    @php
                                        $kode_guru = ''; // Initialize kode guru as empty string
                                        $kode_mapel = ''; // Initialize kode mapel as empty string
                                        $kode_ruangan = ''; // Initialize kode ruangan as empty string

                                    @endphp
                                    @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                                        @php
                                            $waktu1 = explode('-', $jadwalKelas->id_waktu);
                                            $start_time = $waktu1[0];
                                            $end_time = $waktu1[1];

                                            // Check if the desired time range falls within the id_waktu range
                                            $desired_start_time = '13:20';
                                            $desired_end_time = '13:40';
                                            $time_within_range =
                                                $desired_start_time >= $start_time && $desired_end_time <= $end_time;

                                            $guruDuplicate = false;
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                                $guruDuplicate =
                                                    App\Models\Jadwalmapel::join(
                                                        'pengampus',
                                                        'jadwalmapels.id_pengampu',
                                                        '=',
                                                        'pengampus.id',
                                                    )
                                                        ->where('pengampus.id_guru', $jadwalKelas->pengampus->id_guru)
                                                        ->where('jadwalmapels.id_hari', 1)
                                                        ->where('jadwalmapels.id_waktu', $jadwalKelas->id_waktu)
                                                        ->count() > 1;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_guru }}</td>

                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_mapel }}</td>
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_ruangan }}</td>
                                @endforeach
                            </tr>
                            <tr>
                                <td style="white-space: nowrap;background-color: rgb(187,191,195)" class="text-center">
                                    13:40 - 14:00</td>
                                @foreach ($kelasGroups as $kelas => $jadwalByClass)
                                    @php
                                        $kode_guru = ''; // Initialize kode guru as empty string
                                        $kode_mapel = ''; // Initialize kode mapel as empty string
                                        $kode_ruangan = ''; // Initialize kode ruangan as empty string

                                    @endphp
                                    @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                                        @php
                                            $waktu1 = explode('-', $jadwalKelas->id_waktu);
                                            $start_time = $waktu1[0];
                                            $end_time = $waktu1[1];

                                            // Check if the desired time range falls within the id_waktu range
                                            $desired_start_time = '13:40';
                                            $desired_end_time = '14:00';
                                            $time_within_range =
                                                $desired_start_time >= $start_time && $desired_end_time <= $end_time;

                                            $guruDuplicate = false;
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                                $guruDuplicate =
                                                    App\Models\Jadwalmapel::join(
                                                        'pengampus',
                                                        'jadwalmapels.id_pengampu',
                                                        '=',
                                                        'pengampus.id',
                                                    )
                                                        ->where('pengampus.id_guru', $jadwalKelas->pengampus->id_guru)
                                                        ->where('jadwalmapels.id_hari', 1)
                                                        ->where('jadwalmapels.id_waktu', $jadwalKelas->id_waktu)
                                                        ->count() > 1;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_guru }}</td>

                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_mapel }}</td>
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_ruangan }}</td>
                                @endforeach
                            </tr>
                            <tr>
                                <td style="white-space: nowrap;background-color: rgb(187,191,195)" class="text-center">
                                    14:00 - 14:20</td>
                                @foreach ($kelasGroups as $kelas => $jadwalByClass)
                                    @php
                                        $kode_guru = ''; // Initialize kode guru as empty string
                                        $kode_mapel = ''; // Initialize kode mapel as empty string
                                        $kode_ruangan = ''; // Initialize kode ruangan as empty string

                                    @endphp
                                    @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                                        @php
                                            $waktu1 = explode('-', $jadwalKelas->id_waktu);
                                            $start_time = $waktu1[0];
                                            $end_time = $waktu1[1];

                                            // Check if the desired time range falls within the id_waktu range
                                            $desired_start_time = '14:00';
                                            $desired_end_time = '14:20';
                                            $time_within_range =
                                                $desired_start_time >= $start_time && $desired_end_time <= $end_time;

                                            $guruDuplicate = false;
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                                $guruDuplicate =
                                                    App\Models\Jadwalmapel::join(
                                                        'pengampus',
                                                        'jadwalmapels.id_pengampu',
                                                        '=',
                                                        'pengampus.id',
                                                    )
                                                        ->where('pengampus.id_guru', $jadwalKelas->pengampus->id_guru)
                                                        ->where('jadwalmapels.id_hari', 1)
                                                        ->where('jadwalmapels.id_waktu', $jadwalKelas->id_waktu)
                                                        ->count() > 1;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_guru }}</td>

                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_mapel }}</td>
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_ruangan }}</td>
                                @endforeach
                            </tr>
                            <tr>
                                <td style="white-space: nowrap;background-color: rgb(187,191,195)" class="text-center">
                                    14:20 - 14:40</td>
                                @foreach ($kelasGroups as $kelas => $jadwalByClass)
                                    @php
                                        $kode_guru = ''; // Initialize kode guru as empty string
                                        $kode_mapel = ''; // Initialize kode mapel as empty string
                                        $kode_ruangan = ''; // Initialize kode ruangan as empty string

                                    @endphp
                                    @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                                        @php
                                            $waktu1 = explode('-', $jadwalKelas->id_waktu);
                                            $start_time = $waktu1[0];
                                            $end_time = $waktu1[1];

                                            // Check if the desired time range falls within the id_waktu range
                                            $desired_start_time = '14:20';
                                            $desired_end_time = '14:40';
                                            $time_within_range =
                                                $desired_start_time >= $start_time && $desired_end_time <= $end_time;

                                            $guruDuplicate = false;
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                                $guruDuplicate =
                                                    App\Models\Jadwalmapel::join(
                                                        'pengampus',
                                                        'jadwalmapels.id_pengampu',
                                                        '=',
                                                        'pengampus.id',
                                                    )
                                                        ->where('pengampus.id_guru', $jadwalKelas->pengampus->id_guru)
                                                        ->where('jadwalmapels.id_hari', 1)
                                                        ->where('jadwalmapels.id_waktu', $jadwalKelas->id_waktu)
                                                        ->count() > 1;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_guru }}</td>

                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_mapel }}</td>
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_ruangan }}</td>
                                @endforeach
                            </tr>
                            <tr>
                                <td style="white-space: nowrap;background-color: rgb(187,191,195)" class="text-center">
                                    14:40 - 15:00</td>
                                @foreach ($kelasGroups as $kelas => $jadwalByClass)
                                    @php
                                        $kode_guru = ''; // Initialize kode guru as empty string
                                        $kode_mapel = ''; // Initialize kode mapel as empty string
                                        $kode_ruangan = ''; // Initialize kode ruangan as empty string

                                    @endphp
                                    @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                                        @php
                                            $waktu1 = explode('-', $jadwalKelas->id_waktu);
                                            $start_time = $waktu1[0];
                                            $end_time = $waktu1[1];

                                            // Check if the desired time range falls within the id_waktu range
                                            $desired_start_time = '14:40';
                                            $desired_end_time = '15:00';
                                            $time_within_range =
                                                $desired_start_time >= $start_time && $desired_end_time <= $end_time;

                                            $guruDuplicate = false;
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                                $guruDuplicate =
                                                    App\Models\Jadwalmapel::join(
                                                        'pengampus',
                                                        'jadwalmapels.id_pengampu',
                                                        '=',
                                                        'pengampus.id',
                                                    )
                                                        ->where('pengampus.id_guru', $jadwalKelas->pengampus->id_guru)
                                                        ->where('jadwalmapels.id_hari', 1)
                                                        ->where('jadwalmapels.id_waktu', $jadwalKelas->id_waktu)
                                                        ->count() > 1;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_guru }}</td>

                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_mapel }}</td>
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_ruangan }}</td>
                                @endforeach
                            </tr>
                            <tr>
                                <td style="white-space: nowrap;background-color: rgb(187,191,195)" class="text-center">
                                    15:00 - 15:20</td>
                                @foreach ($kelasGroups as $kelas => $jadwalByClass)
                                    @php
                                        $kode_guru = ''; // Initialize kode guru as empty string
                                        $kode_mapel = ''; // Initialize kode mapel as empty string
                                        $kode_ruangan = ''; // Initialize kode ruangan as empty string

                                    @endphp
                                    @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                                        @php
                                            $waktu1 = explode('-', $jadwalKelas->id_waktu);
                                            $start_time = $waktu1[0];
                                            $end_time = $waktu1[1];

                                            // Check if the desired time range falls within the id_waktu range
                                            $desired_start_time = '15:00';
                                            $desired_end_time = '15:20';
                                            $time_within_range =
                                                $desired_start_time >= $start_time && $desired_end_time <= $end_time;

                                            $guruDuplicate = false;
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                                $guruDuplicate =
                                                    App\Models\Jadwalmapel::join(
                                                        'pengampus',
                                                        'jadwalmapels.id_pengampu',
                                                        '=',
                                                        'pengampus.id',
                                                    )
                                                        ->where('pengampus.id_guru', $jadwalKelas->pengampus->id_guru)
                                                        ->where('jadwalmapels.id_hari', 1)
                                                        ->where('jadwalmapels.id_waktu', $jadwalKelas->id_waktu)
                                                        ->count() > 1;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_guru }}</td>

                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_mapel }}</td>
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_ruangan }}</td>
                                @endforeach
                            </tr>
                            <tr>
                                <td style="white-space: nowrap;background-color: rgb(187,191,195)" class="text-center">
                                    15:20 - 15:40</td>
                                @foreach ($kelasGroups as $kelas => $jadwalByClass)
                                    @php
                                        $kode_guru = ''; // Initialize kode guru as empty string
                                        $kode_mapel = ''; // Initialize kode mapel as empty string
                                        $kode_ruangan = ''; // Initialize kode ruangan as empty string

                                    @endphp
                                    @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                                        @php
                                            $waktu1 = explode('-', $jadwalKelas->id_waktu);
                                            $start_time = $waktu1[0];
                                            $end_time = $waktu1[1];

                                            // Check if the desired time range falls within the id_waktu range
                                            $desired_start_time = '15:20';
                                            $desired_end_time = '15:40';
                                            $time_within_range =
                                                $desired_start_time >= $start_time && $desired_end_time <= $end_time;

                                            $guruDuplicate = false;
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                                $guruDuplicate =
                                                    App\Models\Jadwalmapel::join(
                                                        'pengampus',
                                                        'jadwalmapels.id_pengampu',
                                                        '=',
                                                        'pengampus.id',
                                                    )
                                                        ->where('pengampus.id_guru', $jadwalKelas->pengampus->id_guru)
                                                        ->where('jadwalmapels.id_hari', 1)
                                                        ->where('jadwalmapels.id_waktu', $jadwalKelas->id_waktu)
                                                        ->count() > 1;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_guru }}</td>

                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_mapel }}</td>
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_ruangan }}</td>
                                @endforeach
                            </tr>
                        @endforeach


                        {{--  // hari selasa //  --}}



                        @foreach ($hari->where('kode_hari', 'H02') as $key => $itemhari)
                            <tr>
                                <td rowspan="20" style="background-color: rgb(187,191,195)" class="text-center">
                                    {{ $itemhari->nama }}
                                </td>
                                <td style="white-space: nowrap;background-color: rgb(187,191,195)" class="text-center">
                                    07:00 - 07:40</td>

                                @foreach ($kelasGroups as $kelas => $jadwalByClass)
                                    @php
                                        $kode_guru = ''; // Initialize kode guru as empty string
                                        $kode_mapel = ''; // Initialize kode mapel as empty string
                                        $kode_ruangan = ''; // Initialize kode ruangan as empty string

                                    @endphp
                                    @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                                        @php
                                            $waktu1 = explode('-', $jadwalKelas->id_waktu);
                                            $start_time = $waktu1[0];
                                            $end_time = $waktu1[1];

                                            // Check if the desired time range falls within the id_waktu range
                                            $desired_start_time = '07:00';
                                            $desired_end_time = '07:40';
                                            $time_within_range =
                                                $desired_start_time >= $start_time && $desired_end_time <= $end_time;

                                            $guruDuplicate = false;
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                                $guruDuplicate =
                                                    App\Models\Jadwalmapel::join(
                                                        'pengampus',
                                                        'jadwalmapels.id_pengampu',
                                                        '=',
                                                        'pengampus.id',
                                                    )
                                                        ->where('pengampus.id_guru', $jadwalKelas->pengampus->id_guru)
                                                        ->where('jadwalmapels.id_hari', 2)
                                                        ->where('jadwalmapels.id_waktu', $jadwalKelas->id_waktu)
                                                        ->count() > 1;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_guru }}</td>

                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_mapel }}</td>
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_ruangan }}</td>
                                @endforeach
                            </tr>

                            <tr>

                                <td style="white-space: nowrap;background-color: rgb(187,191,195)" class="text-center">
                                    07:40 - 08:20</td>

                                @foreach ($kelasGroups as $kelas => $jadwalByClass)
                                    @php
                                        $kode_guru = ''; // Initialize kode guru as empty string
                                        $kode_mapel = ''; // Initialize kode mapel as empty string
                                        $kode_ruangan = ''; // Initialize kode ruangan as empty string

                                    @endphp
                                    @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                                        @php
                                            $waktu1 = explode('-', $jadwalKelas->id_waktu);
                                            $start_time = $waktu1[0];
                                            $end_time = $waktu1[1];

                                            // Check if the desired time range falls within the id_waktu range
                                            $desired_start_time = '07:40';
                                            $desired_end_time = '08:20';
                                            $time_within_range =
                                                $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                                            $guruDuplicate = false;
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                                $guruDuplicate =
                                                    App\Models\Jadwalmapel::join(
                                                        'pengampus',
                                                        'jadwalmapels.id_pengampu',
                                                        '=',
                                                        'pengampus.id',
                                                    )
                                                        ->where('pengampus.id_guru', $jadwalKelas->pengampus->id_guru)
                                                        ->where('jadwalmapels.id_hari', 2)
                                                        ->where('jadwalmapels.id_waktu', $jadwalKelas->id_waktu)
                                                        ->count() > 1;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_guru }}</td>

                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_mapel }}</td>
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_ruangan }}</td>
                                @endforeach
                            </tr>

                            <tr>

                                <td style="white-space: nowrap;background-color: rgb(187,191,195)" class="text-center">
                                    08:20 - 09:00</td>

                                @foreach ($kelasGroups as $kelas => $jadwalByClass)
                                    @php
                                        $kode_guru = ''; // Initialize kode guru as empty string
                                        $kode_mapel = ''; // Initialize kode mapel as empty string
                                        $kode_ruangan = ''; // Initialize kode ruangan as empty string

                                    @endphp
                                    @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                                        @php
                                            $waktu1 = explode('-', $jadwalKelas->id_waktu);
                                            $start_time = $waktu1[0];
                                            $end_time = $waktu1[1];

                                            // Check if the desired time range falls within the id_waktu range
                                            $desired_start_time = '08:20';
                                            $desired_end_time = '09:00';
                                            $time_within_range =
                                                $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                                            $guruDuplicate = false;
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                                $guruDuplicate =
                                                    App\Models\Jadwalmapel::join(
                                                        'pengampus',
                                                        'jadwalmapels.id_pengampu',
                                                        '=',
                                                        'pengampus.id',
                                                    )
                                                        ->where('pengampus.id_guru', $jadwalKelas->pengampus->id_guru)
                                                        ->where('jadwalmapels.id_hari', 2)
                                                        ->where('jadwalmapels.id_waktu', $jadwalKelas->id_waktu)
                                                        ->count() > 1;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_guru }}</td>

                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_mapel }}</td>
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_ruangan }}</td>
                                @endforeach
                            </tr>


                            <tr>

                                <td style="white-space: nowrap;background-color: rgb(187,191,195)" class="text-center">
                                    09:00 - 09:40</td>

                                @foreach ($kelasGroups as $kelas => $jadwalByClass)
                                    @php
                                        $kode_guru = ''; // Initialize kode guru as empty string
                                        $kode_mapel = ''; // Initialize kode mapel as empty string
                                        $kode_ruangan = ''; // Initialize kode ruangan as empty string

                                    @endphp
                                    @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                                        @php
                                            $waktu1 = explode('-', $jadwalKelas->id_waktu);
                                            $start_time = $waktu1[0];
                                            $end_time = $waktu1[1];

                                            // Check if the desired time range falls within the id_waktu range
                                            $desired_start_time = '09:00';
                                            $desired_end_time = '09:40';
                                            $time_within_range =
                                                $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                                            $guruDuplicate = false;
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                                $guruDuplicate =
                                                    App\Models\Jadwalmapel::join(
                                                        'pengampus',
                                                        'jadwalmapels.id_pengampu',
                                                        '=',
                                                        'pengampus.id',
                                                    )
                                                        ->where('pengampus.id_guru', $jadwalKelas->pengampus->id_guru)
                                                        ->where('jadwalmapels.id_hari', 2)
                                                        ->where('jadwalmapels.id_waktu', $jadwalKelas->id_waktu)
                                                        ->count() > 1;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_guru }}</td>

                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_mapel }}</td>
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_ruangan }}</td>
                                @endforeach
                            </tr>

                            <tr>

                                <td style="white-space: nowrap;background-color: rgb(187,191,195)" class="text-center">
                                    09:40 - 10:00</td>

                                @foreach ($kelasGroups as $kelas => $jadwalByClass)
                                    @php
                                        $kode_guru = ''; // Initialize kode guru as empty string
                                        $kode_mapel = ''; // Initialize kode mapel as empty string
                                        $kode_ruangan = ''; // Initialize kode ruangan as empty string

                                    @endphp
                                    @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                                        @php
                                            $waktu1 = explode('-', $jadwalKelas->id_waktu);
                                            $start_time = $waktu1[0];
                                            $end_time = $waktu1[1];

                                            // Check if the desired time range falls within the id_waktu range
                                            $desired_start_time = '09:40';
                                            $desired_end_time = '10:00';
                                            $time_within_range =
                                                $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                                            $guruDuplicate = false;
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                                $guruDuplicate =
                                                    App\Models\Jadwalmapel::join(
                                                        'pengampus',
                                                        'jadwalmapels.id_pengampu',
                                                        '=',
                                                        'pengampus.id',
                                                    )
                                                        ->where('pengampus.id_guru', $jadwalKelas->pengampus->id_guru)
                                                        ->where('jadwalmapels.id_hari', 2)
                                                        ->where('jadwalmapels.id_waktu', $jadwalKelas->id_waktu)
                                                        ->count() > 1;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_guru }}</td>

                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_mapel }}</td>
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_ruangan }}</td>
                                @endforeach
                            </tr>

                            <tr>
                                <td style="white-space: nowrap;background-color: rgb(187,191,195)" class="text-center">
                                    10:00 - 10:20</td>

                                <td colspan="{{ $j }}" class="text-center"style="background-color: yellow">
                                    ISTIRAHAT</td>
                            </tr>

                            <tr>

                                <td style="white-space: nowrap;background-color: rgb(187,191,195)" class="text-center">
                                    10:20 - 10:40</td>

                                @foreach ($kelasGroups as $kelas => $jadwalByClass)
                                    @php
                                        $kode_guru = ''; // Initialize kode guru as empty string
                                        $kode_mapel = ''; // Initialize kode mapel as empty string
                                        $kode_ruangan = ''; // Initialize kode ruangan as empty string

                                    @endphp
                                    @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                                        @php
                                            $waktu1 = explode('-', $jadwalKelas->id_waktu);
                                            $start_time = $waktu1[0];
                                            $end_time = $waktu1[1];

                                            // Check if the desired time range falls within the id_waktu range
                                            $desired_start_time = '10:20';
                                            $desired_end_time = '10:40';
                                            $time_within_range =
                                                $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                                            $guruDuplicate = false;
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                                $guruDuplicate =
                                                    App\Models\Jadwalmapel::join(
                                                        'pengampus',
                                                        'jadwalmapels.id_pengampu',
                                                        '=',
                                                        'pengampus.id',
                                                    )
                                                        ->where('pengampus.id_guru', $jadwalKelas->pengampus->id_guru)
                                                        ->where('jadwalmapels.id_hari', 2)
                                                        ->where('jadwalmapels.id_waktu', $jadwalKelas->id_waktu)
                                                        ->count() > 1;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_guru }}</td>

                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_mapel }}</td>
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_ruangan }}</td>
                                @endforeach
                            </tr>

                            <tr>

                                <td style="white-space: nowrap;background-color: rgb(187,191,195)" class="text-center">
                                    10:40 - 11:00</td>

                                @foreach ($kelasGroups as $kelas => $jadwalByClass)
                                    @php
                                        $kode_guru = ''; // Initialize kode guru as empty string
                                        $kode_mapel = ''; // Initialize kode mapel as empty string
                                        $kode_ruangan = ''; // Initialize kode ruangan as empty string

                                    @endphp
                                    @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                                        @php
                                            $waktu1 = explode('-', $jadwalKelas->id_waktu);
                                            $start_time = $waktu1[0];
                                            $end_time = $waktu1[1];

                                            // Check if the desired time range falls within the id_waktu range
                                            $desired_start_time = '10:40';
                                            $desired_end_time = '11:00';
                                            $time_within_range =
                                                $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                                            $guruDuplicate = false;
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                                $guruDuplicate =
                                                    App\Models\Jadwalmapel::join(
                                                        'pengampus',
                                                        'jadwalmapels.id_pengampu',
                                                        '=',
                                                        'pengampus.id',
                                                    )
                                                        ->where('pengampus.id_guru', $jadwalKelas->pengampus->id_guru)
                                                        ->where('jadwalmapels.id_hari', 2)
                                                        ->where('jadwalmapels.id_waktu', $jadwalKelas->id_waktu)
                                                        ->count() > 1;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_guru }}</td>

                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_mapel }}</td>
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_ruangan }}</td>
                                @endforeach
                            </tr>

                            <tr>

                                <td style="white-space: nowrap;background-color: rgb(187,191,195)" class="text-center">
                                    11:00 - 11:20</td>

                                @foreach ($kelasGroups as $kelas => $jadwalByClass)
                                    @php
                                        $kode_guru = ''; // Initialize kode guru as empty string
                                        $kode_mapel = ''; // Initialize kode mapel as empty string
                                        $kode_ruangan = ''; // Initialize kode ruangan as empty string

                                    @endphp
                                    @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                                        @php
                                            $waktu1 = explode('-', $jadwalKelas->id_waktu);
                                            $start_time = $waktu1[0];
                                            $end_time = $waktu1[1];

                                            // Check if the desired time range falls within the id_waktu range
                                            $desired_start_time = '11:00';
                                            $desired_end_time = '11:20';
                                            $time_within_range =
                                                $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                                            $guruDuplicate = false;
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                                $guruDuplicate =
                                                    App\Models\Jadwalmapel::join(
                                                        'pengampus',
                                                        'jadwalmapels.id_pengampu',
                                                        '=',
                                                        'pengampus.id',
                                                    )
                                                        ->where('pengampus.id_guru', $jadwalKelas->pengampus->id_guru)
                                                        ->where('jadwalmapels.id_hari', 2)
                                                        ->where('jadwalmapels.id_waktu', $jadwalKelas->id_waktu)
                                                        ->count() > 1;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_guru }}</td>

                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_mapel }}</td>
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_ruangan }}</td>
                                @endforeach
                            </tr>
                            <tr>

                                <td style="white-space: nowrap;background-color: rgb(187,191,195)" class="text-center">
                                    11:20 - 11:40</td>

                                @foreach ($kelasGroups as $kelas => $jadwalByClass)
                                    @php
                                        $kode_guru = ''; // Initialize kode guru as empty string
                                        $kode_mapel = ''; // Initialize kode mapel as empty string
                                        $kode_ruangan = ''; // Initialize kode ruangan as empty string

                                    @endphp
                                    @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                                        @php
                                            $waktu1 = explode('-', $jadwalKelas->id_waktu);
                                            $start_time = $waktu1[0];
                                            $end_time = $waktu1[1];

                                            // Check if the desired time range falls within the id_waktu range
                                            $desired_start_time = '11:20';
                                            $desired_end_time = '11:40';
                                            $time_within_range =
                                                $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                                            $guruDuplicate = false;
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                                $guruDuplicate =
                                                    App\Models\Jadwalmapel::join(
                                                        'pengampus',
                                                        'jadwalmapels.id_pengampu',
                                                        '=',
                                                        'pengampus.id',
                                                    )
                                                        ->where('pengampus.id_guru', $jadwalKelas->pengampus->id_guru)
                                                        ->where('jadwalmapels.id_hari', 2)
                                                        ->where('jadwalmapels.id_waktu', $jadwalKelas->id_waktu)
                                                        ->count() > 1;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_guru }}</td>

                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_mapel }}</td>
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_ruangan }}</td>
                                @endforeach
                            </tr>

                            <tr>

                                <td style="white-space: nowrap;background-color: rgb(187,191,195)" class="text-center">
                                    11:40 - 12:00</td>

                                @foreach ($kelasGroups as $kelas => $jadwalByClass)
                                    @php
                                        $kode_guru = ''; // Initialize kode guru as empty string
                                        $kode_mapel = ''; // Initialize kode mapel as empty string
                                        $kode_ruangan = ''; // Initialize kode ruangan as empty string

                                    @endphp
                                    @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                                        @php
                                            $waktu1 = explode('-', $jadwalKelas->id_waktu);
                                            $start_time = $waktu1[0];
                                            $end_time = $waktu1[1];

                                            // Check if the desired time range falls within the id_waktu range
                                            $desired_start_time = '11:40';
                                            $desired_end_time = '12:00';
                                            $time_within_range =
                                                $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                                            $guruDuplicate = false;
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                                $guruDuplicate =
                                                    App\Models\Jadwalmapel::join(
                                                        'pengampus',
                                                        'jadwalmapels.id_pengampu',
                                                        '=',
                                                        'pengampus.id',
                                                    )
                                                        ->where('pengampus.id_guru', $jadwalKelas->pengampus->id_guru)
                                                        ->where('jadwalmapels.id_hari', 2)
                                                        ->where('jadwalmapels.id_waktu', $jadwalKelas->id_waktu)
                                                        ->count() > 1;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_guru }}</td>

                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_mapel }}</td>
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_ruangan }}</td>
                                @endforeach
                            </tr>
                            <tr>

                                <td style="white-space: nowrap;background-color: rgb(187,191,195)" class="text-center">
                                    12:00 - 12:20</td>

                                @foreach ($kelasGroups as $kelas => $jadwalByClass)
                                    @php
                                        $kode_guru = ''; // Initialize kode guru as empty string
                                        $kode_mapel = ''; // Initialize kode mapel as empty string
                                        $kode_ruangan = ''; // Initialize kode ruangan as empty string

                                    @endphp
                                    @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                                        @php
                                            $waktu1 = explode('-', $jadwalKelas->id_waktu);
                                            $start_time = $waktu1[0];
                                            $end_time = $waktu1[1];

                                            // Check if the desired time range falls within the id_waktu range
                                            $desired_start_time = '12:00';
                                            $desired_end_time = '12:20';
                                            $time_within_range =
                                                $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                                            $guruDuplicate = false;
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                                $guruDuplicate =
                                                    App\Models\Jadwalmapel::join(
                                                        'pengampus',
                                                        'jadwalmapels.id_pengampu',
                                                        '=',
                                                        'pengampus.id',
                                                    )
                                                        ->where('pengampus.id_guru', $jadwalKelas->pengampus->id_guru)
                                                        ->where('jadwalmapels.id_hari', 2)
                                                        ->where('jadwalmapels.id_waktu', $jadwalKelas->id_waktu)
                                                        ->count() > 1;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_guru }}</td>

                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_mapel }}</td>
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_ruangan }}</td>
                                @endforeach
                            </tr>


                            <tr>
                                <td style="white-space: nowrap;background-color: rgb(187,191,195)" class="text-center">
                                    12:20 - 13:00</td>

                                <td colspan="{{ $j }}" class="text-center"style="background-color: yellow">
                                    ISTIRAHAT</td>
                            </tr>

                            <tr>

                                <td style="white-space: nowrap;background-color: rgb(187,191,195)" class="text-center">
                                    13:00 - 13:20</td>

                                @foreach ($kelasGroups as $kelas => $jadwalByClass)
                                    @php
                                        $kode_guru = ''; // Initialize kode guru as empty string
                                        $kode_mapel = ''; // Initialize kode mapel as empty string
                                        $kode_ruangan = ''; // Initialize kode ruangan as empty string

                                    @endphp
                                    @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                                        @php
                                            $waktu1 = explode('-', $jadwalKelas->id_waktu);
                                            $start_time = $waktu1[0];
                                            $end_time = $waktu1[1];

                                            // Check if the desired time range falls within the id_waktu range
                                            $desired_start_time = '13:00';
                                            $desired_end_time = '13:20';
                                            $time_within_range =
                                                $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                                            $guruDuplicate = false;
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                                $guruDuplicate =
                                                    App\Models\Jadwalmapel::join(
                                                        'pengampus',
                                                        'jadwalmapels.id_pengampu',
                                                        '=',
                                                        'pengampus.id',
                                                    )
                                                        ->where('pengampus.id_guru', $jadwalKelas->pengampus->id_guru)
                                                        ->where('jadwalmapels.id_hari', 2)
                                                        ->where('jadwalmapels.id_waktu', $jadwalKelas->id_waktu)
                                                        ->count() > 1;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_guru }}</td>

                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_mapel }}</td>
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_ruangan }}</td>
                                @endforeach
                            </tr>

                            <tr>

                                <td style="white-space: nowrap;background-color: rgb(187,191,195)" class="text-center">
                                    13:20 - 13:40</td>

                                @foreach ($kelasGroups as $kelas => $jadwalByClass)
                                    @php
                                        $kode_guru = ''; // Initialize kode guru as empty string
                                        $kode_mapel = ''; // Initialize kode mapel as empty string
                                        $kode_ruangan = ''; // Initialize kode ruangan as empty string

                                    @endphp
                                    @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                                        @php
                                            $waktu1 = explode('-', $jadwalKelas->id_waktu);
                                            $start_time = $waktu1[0];
                                            $end_time = $waktu1[1];

                                            // Check if the desired time range falls within the id_waktu range
                                            $desired_start_time = '13:20';
                                            $desired_end_time = '13:40';
                                            $time_within_range =
                                                $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                                            $guruDuplicate = false;
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                                $guruDuplicate =
                                                    App\Models\Jadwalmapel::join(
                                                        'pengampus',
                                                        'jadwalmapels.id_pengampu',
                                                        '=',
                                                        'pengampus.id',
                                                    )
                                                        ->where('pengampus.id_guru', $jadwalKelas->pengampus->id_guru)
                                                        ->where('jadwalmapels.id_hari', 2)
                                                        ->where('jadwalmapels.id_waktu', $jadwalKelas->id_waktu)
                                                        ->count() > 1;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_guru }}</td>

                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_mapel }}</td>
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_ruangan }}</td>
                                @endforeach
                            </tr>

                            <tr>

                                <td style="white-space: nowrap;background-color: rgb(187,191,195)" class="text-center">
                                    13:40 - 14:00</td>

                                @foreach ($kelasGroups as $kelas => $jadwalByClass)
                                    @php
                                        $kode_guru = ''; // Initialize kode guru as empty string
                                        $kode_mapel = ''; // Initialize kode mapel as empty string
                                        $kode_ruangan = ''; // Initialize kode ruangan as empty string

                                    @endphp
                                    @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                                        @php
                                            $waktu1 = explode('-', $jadwalKelas->id_waktu);
                                            $start_time = $waktu1[0];
                                            $end_time = $waktu1[1];

                                            // Check if the desired time range falls within the id_waktu range
                                            $desired_start_time = '13:40';
                                            $desired_end_time = '14:00';
                                            $time_within_range =
                                                $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                                            $guruDuplicate = false;
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                                $guruDuplicate =
                                                    App\Models\Jadwalmapel::join(
                                                        'pengampus',
                                                        'jadwalmapels.id_pengampu',
                                                        '=',
                                                        'pengampus.id',
                                                    )
                                                        ->where('pengampus.id_guru', $jadwalKelas->pengampus->id_guru)
                                                        ->where('jadwalmapels.id_hari', 2)
                                                        ->where('jadwalmapels.id_waktu', $jadwalKelas->id_waktu)
                                                        ->count() > 1;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_guru }}</td>

                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_mapel }}</td>
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_ruangan }}</td>
                                @endforeach
                            </tr>

                            <tr>

                                <td style="white-space: nowrap;background-color: rgb(187,191,195)" class="text-center">
                                    14:00 - 14:20</td>

                                @foreach ($kelasGroups as $kelas => $jadwalByClass)
                                    @php
                                        $kode_guru = ''; // Initialize kode guru as empty string
                                        $kode_mapel = ''; // Initialize kode mapel as empty string
                                        $kode_ruangan = ''; // Initialize kode ruangan as empty string

                                    @endphp
                                    @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                                        @php
                                            $waktu1 = explode('-', $jadwalKelas->id_waktu);
                                            $start_time = $waktu1[0];
                                            $end_time = $waktu1[1];

                                            // Check if the desired time range falls within the id_waktu range
                                            $desired_start_time = '14:00';
                                            $desired_end_time = '14:20';
                                            $time_within_range =
                                                $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                                            $guruDuplicate = false;
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                                $guruDuplicate =
                                                    App\Models\Jadwalmapel::join(
                                                        'pengampus',
                                                        'jadwalmapels.id_pengampu',
                                                        '=',
                                                        'pengampus.id',
                                                    )
                                                        ->where('pengampus.id_guru', $jadwalKelas->pengampus->id_guru)
                                                        ->where('jadwalmapels.id_hari', 2)
                                                        ->where('jadwalmapels.id_waktu', $jadwalKelas->id_waktu)
                                                        ->count() > 1;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_guru }}</td>

                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_mapel }}</td>
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_ruangan }}</td>
                                @endforeach
                            </tr>

                            <tr>

                                <td style="white-space: nowrap;background-color: rgb(187,191,195)" class="text-center">
                                    14:20 - 14:40</td>

                                @foreach ($kelasGroups as $kelas => $jadwalByClass)
                                    @php
                                        $kode_guru = ''; // Initialize kode guru as empty string
                                        $kode_mapel = ''; // Initialize kode mapel as empty string
                                        $kode_ruangan = ''; // Initialize kode ruangan as empty string

                                    @endphp
                                    @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                                        @php
                                            $waktu1 = explode('-', $jadwalKelas->id_waktu);
                                            $start_time = $waktu1[0];
                                            $end_time = $waktu1[1];

                                            // Check if the desired time range falls within the id_waktu range
                                            $desired_start_time = '14:20';
                                            $desired_end_time = '14:40';
                                            $time_within_range =
                                                $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                                            $guruDuplicate = false;
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                                $guruDuplicate =
                                                    App\Models\Jadwalmapel::join(
                                                        'pengampus',
                                                        'jadwalmapels.id_pengampu',
                                                        '=',
                                                        'pengampus.id',
                                                    )
                                                        ->where('pengampus.id_guru', $jadwalKelas->pengampus->id_guru)
                                                        ->where('jadwalmapels.id_hari', 2)
                                                        ->where('jadwalmapels.id_waktu', $jadwalKelas->id_waktu)
                                                        ->count() > 1;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_guru }}</td>

                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_mapel }}</td>
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_ruangan }}</td>
                                @endforeach
                            </tr>
                            <tr>

                                <td style="white-space: nowrap;background-color: rgb(187,191,195)" class="text-center">
                                    14:40 - 15:00</td>

                                @foreach ($kelasGroups as $kelas => $jadwalByClass)
                                    @php
                                        $kode_guru = ''; // Initialize kode guru as empty string
                                        $kode_mapel = ''; // Initialize kode mapel as empty string
                                        $kode_ruangan = ''; // Initialize kode ruangan as empty string

                                    @endphp
                                    @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                                        @php
                                            $waktu1 = explode('-', $jadwalKelas->id_waktu);
                                            $start_time = $waktu1[0];
                                            $end_time = $waktu1[1];

                                            // Check if the desired time range falls within the id_waktu range
                                            $desired_start_time = '14:40';
                                            $desired_end_time = '15:00';
                                            $time_within_range =
                                                $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                                            $guruDuplicate = false;
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                                $guruDuplicate =
                                                    App\Models\Jadwalmapel::join(
                                                        'pengampus',
                                                        'jadwalmapels.id_pengampu',
                                                        '=',
                                                        'pengampus.id',
                                                    )
                                                        ->where('pengampus.id_guru', $jadwalKelas->pengampus->id_guru)
                                                        ->where('jadwalmapels.id_hari', 2)
                                                        ->where('jadwalmapels.id_waktu', $jadwalKelas->id_waktu)
                                                        ->count() > 1;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_guru }}</td>

                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_mapel }}</td>
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_ruangan }}</td>
                                @endforeach
                            </tr>
                            <tr>

                                <td style="white-space: nowrap;background-color: rgb(187,191,195)" class="text-center">
                                    15:00 - 15:20</td>

                                @foreach ($kelasGroups as $kelas => $jadwalByClass)
                                    @php
                                        $kode_guru = ''; // Initialize kode guru as empty string
                                        $kode_mapel = ''; // Initialize kode mapel as empty string
                                        $kode_ruangan = ''; // Initialize kode ruangan as empty string

                                    @endphp
                                    @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                                        @php
                                            $waktu1 = explode('-', $jadwalKelas->id_waktu);
                                            $start_time = $waktu1[0];
                                            $end_time = $waktu1[1];

                                            // Check if the desired time range falls within the id_waktu range
                                            $desired_start_time = '15:00';
                                            $desired_end_time = '15:20';
                                            $time_within_range =
                                                $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                                            $guruDuplicate = false;
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                                $guruDuplicate =
                                                    App\Models\Jadwalmapel::join(
                                                        'pengampus',
                                                        'jadwalmapels.id_pengampu',
                                                        '=',
                                                        'pengampus.id',
                                                    )
                                                        ->where('pengampus.id_guru', $jadwalKelas->pengampus->id_guru)
                                                        ->where('jadwalmapels.id_hari', 2)
                                                        ->where('jadwalmapels.id_waktu', $jadwalKelas->id_waktu)
                                                        ->count() > 1;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_guru }}</td>

                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_mapel }}</td>
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_ruangan }}</td>
                                @endforeach
                            </tr>
                        @endforeach



                        {{--  // hari rabu//  --}}



                        @foreach ($hari->where('kode_hari', 'H03') as $key => $itemhari)
                            <tr>
                                <td rowspan="18" style="background-color: rgb(187,191,195)" class="text-center">
                                    {{ $itemhari->nama }}
                                </td>
                                <td style="white-space: nowrap;background-color: rgb(187,191,195)" class="text-center">
                                    07:00 - 07:40</td>

                                @foreach ($kelasGroups as $kelas => $jadwalByClass)
                                    @php
                                        $kode_guru = ''; // Initialize kode guru as empty string
                                        $kode_mapel = ''; // Initialize kode mapel as empty string
                                        $kode_ruangan = ''; // Initialize kode ruangan as empty string

                                    @endphp
                                    @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                                        @php
                                            $waktu1 = explode('-', $jadwalKelas->id_waktu);
                                            $start_time = $waktu1[0];
                                            $end_time = $waktu1[1];

                                            // Check if the desired time range falls within the id_waktu range
                                            $desired_start_time = '07:00';
                                            $desired_end_time = '07:40';
                                            $time_within_range =
                                                $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                                            $guruDuplicate = false;
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                                $guruDuplicate =
                                                    App\Models\Jadwalmapel::join(
                                                        'pengampus',
                                                        'jadwalmapels.id_pengampu',
                                                        '=',
                                                        'pengampus.id',
                                                    )
                                                        ->where('pengampus.id_guru', $jadwalKelas->pengampus->id_guru)
                                                        ->where('jadwalmapels.id_hari', 3)
                                                        ->where('jadwalmapels.id_waktu', $jadwalKelas->id_waktu)
                                                        ->count() > 1;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_guru }}</td>

                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_mapel }}</td>
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_ruangan }}</td>
                                @endforeach
                            </tr>

                            <tr>

                                <td style="white-space: nowrap;background-color: rgb(187,191,195)" class="text-center">
                                    07:40 - 08:20</td>

                                @foreach ($kelasGroups as $kelas => $jadwalByClass)
                                    @php
                                        $kode_guru = ''; // Initialize kode guru as empty string
                                        $kode_mapel = ''; // Initialize kode mapel as empty string
                                        $kode_ruangan = ''; // Initialize kode ruangan as empty string

                                    @endphp
                                    @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                                        @php
                                            $waktu1 = explode('-', $jadwalKelas->id_waktu);
                                            $start_time = $waktu1[0];
                                            $end_time = $waktu1[1];

                                            // Check if the desired time range falls within the id_waktu range
                                            $desired_start_time = '07:40';
                                            $desired_end_time = '08:20';
                                            $time_within_range =
                                                $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                                            $guruDuplicate = false;
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                                $guruDuplicate =
                                                    App\Models\Jadwalmapel::join(
                                                        'pengampus',
                                                        'jadwalmapels.id_pengampu',
                                                        '=',
                                                        'pengampus.id',
                                                    )
                                                        ->where('pengampus.id_guru', $jadwalKelas->pengampus->id_guru)
                                                        ->where('jadwalmapels.id_hari', 3)
                                                        ->where('jadwalmapels.id_waktu', $jadwalKelas->id_waktu)
                                                        ->count() > 1;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_guru }}</td>

                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_mapel }}</td>
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_ruangan }}</td>
                                @endforeach
                            </tr>

                            <tr>

                                <td style="white-space: nowrap;background-color: rgb(187,191,195)" class="text-center">
                                    08:20 - 09:00</td>

                                @foreach ($kelasGroups as $kelas => $jadwalByClass)
                                    @php
                                        $kode_guru = ''; // Initialize kode guru as empty string
                                        $kode_mapel = ''; // Initialize kode mapel as empty string
                                        $kode_ruangan = ''; // Initialize kode ruangan as empty string

                                    @endphp
                                    @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                                        @php
                                            $waktu1 = explode('-', $jadwalKelas->id_waktu);
                                            $start_time = $waktu1[0];
                                            $end_time = $waktu1[1];

                                            // Check if the desired time range falls within the id_waktu range
                                            $desired_start_time = '08:20';
                                            $desired_end_time = '09:00';
                                            $time_within_range =
                                                $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                                            $guruDuplicate = false;
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                                $guruDuplicate =
                                                    App\Models\Jadwalmapel::join(
                                                        'pengampus',
                                                        'jadwalmapels.id_pengampu',
                                                        '=',
                                                        'pengampus.id',
                                                    )
                                                        ->where('pengampus.id_guru', $jadwalKelas->pengampus->id_guru)
                                                        ->where('jadwalmapels.id_hari', 3)
                                                        ->where('jadwalmapels.id_waktu', $jadwalKelas->id_waktu)
                                                        ->count() > 1;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_guru }}</td>

                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_mapel }}</td>
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_ruangan }}</td>
                                @endforeach
                            </tr>


                            <tr>

                                <td style="white-space: nowrap;background-color: rgb(187,191,195)" class="text-center">
                                    09:00 - 09:40</td>

                                @foreach ($kelasGroups as $kelas => $jadwalByClass)
                                    @php
                                        $kode_guru = ''; // Initialize kode guru as empty string
                                        $kode_mapel = ''; // Initialize kode mapel as empty string
                                        $kode_ruangan = ''; // Initialize kode ruangan as empty string

                                    @endphp
                                    @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                                        @php
                                            $waktu1 = explode('-', $jadwalKelas->id_waktu);
                                            $start_time = $waktu1[0];
                                            $end_time = $waktu1[1];

                                            // Check if the desired time range falls within the id_waktu range
                                            $desired_start_time = '09:00';
                                            $desired_end_time = '09:40';
                                            $time_within_range =
                                                $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                                            $guruDuplicate = false;
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                                $guruDuplicate =
                                                    App\Models\Jadwalmapel::join(
                                                        'pengampus',
                                                        'jadwalmapels.id_pengampu',
                                                        '=',
                                                        'pengampus.id',
                                                    )
                                                        ->where('pengampus.id_guru', $jadwalKelas->pengampus->id_guru)
                                                        ->where('jadwalmapels.id_hari', 3)
                                                        ->where('jadwalmapels.id_waktu', $jadwalKelas->id_waktu)
                                                        ->count() > 1;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_guru }}</td>

                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_mapel }}</td>
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_ruangan }}</td>
                                @endforeach
                            </tr>

                            <tr>

                                <td style="white-space: nowrap;background-color: rgb(187,191,195)" class="text-center">
                                    09:40 - 10:00</td>

                                @foreach ($kelasGroups as $kelas => $jadwalByClass)
                                    @php
                                        $kode_guru = ''; // Initialize kode guru as empty string
                                        $kode_mapel = ''; // Initialize kode mapel as empty string
                                        $kode_ruangan = ''; // Initialize kode ruangan as empty string

                                    @endphp
                                    @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                                        @php
                                            $waktu1 = explode('-', $jadwalKelas->id_waktu);
                                            $start_time = $waktu1[0];
                                            $end_time = $waktu1[1];

                                            // Check if the desired time range falls within the id_waktu range
                                            $desired_start_time = '09:40';
                                            $desired_end_time = '10:00';
                                            $time_within_range =
                                                $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                                            $guruDuplicate = false;
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                                $guruDuplicate =
                                                    App\Models\Jadwalmapel::join(
                                                        'pengampus',
                                                        'jadwalmapels.id_pengampu',
                                                        '=',
                                                        'pengampus.id',
                                                    )
                                                        ->where('pengampus.id_guru', $jadwalKelas->pengampus->id_guru)
                                                        ->where('jadwalmapels.id_hari', 3)
                                                        ->where('jadwalmapels.id_waktu', $jadwalKelas->id_waktu)
                                                        ->count() > 1;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_guru }}</td>

                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_mapel }}</td>
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_ruangan }}</td>
                                @endforeach
                            </tr>

                            <tr>
                                <td style="white-space: nowrap;background-color: rgb(187,191,195)" class="text-center">
                                    10:00 - 10:20</td>

                                <td colspan="{{ $j }}" class="text-center"style="background-color: yellow">
                                    ISTIRAHAT</td>
                            </tr>

                            <tr>

                                <td style="white-space: nowrap;background-color: rgb(187,191,195)" class="text-center">
                                    10:20 - 10:40</td>

                                @foreach ($kelasGroups as $kelas => $jadwalByClass)
                                    @php
                                        $kode_guru = ''; // Initialize kode guru as empty string
                                        $kode_mapel = ''; // Initialize kode mapel as empty string
                                        $kode_ruangan = ''; // Initialize kode ruangan as empty string

                                    @endphp
                                    @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                                        @php
                                            $waktu1 = explode('-', $jadwalKelas->id_waktu);
                                            $start_time = $waktu1[0];
                                            $end_time = $waktu1[1];

                                            // Check if the desired time range falls within the id_waktu range
                                            $desired_start_time = '10:20';
                                            $desired_end_time = '10:40';
                                            $time_within_range =
                                                $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                                            $guruDuplicate = false;
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                                $guruDuplicate =
                                                    App\Models\Jadwalmapel::join(
                                                        'pengampus',
                                                        'jadwalmapels.id_pengampu',
                                                        '=',
                                                        'pengampus.id',
                                                    )
                                                        ->where('pengampus.id_guru', $jadwalKelas->pengampus->id_guru)
                                                        ->where('jadwalmapels.id_hari', 3)
                                                        ->where('jadwalmapels.id_waktu', $jadwalKelas->id_waktu)
                                                        ->count() > 1;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_guru }}</td>

                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_mapel }}</td>
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_ruangan }}</td>
                                @endforeach
                            </tr>

                            <tr>

                                <td style="white-space: nowrap;background-color: rgb(187,191,195)" class="text-center">
                                    10:40 - 11:00</td>

                                @foreach ($kelasGroups as $kelas => $jadwalByClass)
                                    @php
                                        $kode_guru = ''; // Initialize kode guru as empty string
                                        $kode_mapel = ''; // Initialize kode mapel as empty string
                                        $kode_ruangan = ''; // Initialize kode ruangan as empty string

                                    @endphp
                                    @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                                        @php
                                            $waktu1 = explode('-', $jadwalKelas->id_waktu);
                                            $start_time = $waktu1[0];
                                            $end_time = $waktu1[1];

                                            // Check if the desired time range falls within the id_waktu range
                                            $desired_start_time = '10:40';
                                            $desired_end_time = '11:00';
                                            $time_within_range =
                                                $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                                            $guruDuplicate = false;
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                                $guruDuplicate =
                                                    App\Models\Jadwalmapel::join(
                                                        'pengampus',
                                                        'jadwalmapels.id_pengampu',
                                                        '=',
                                                        'pengampus.id',
                                                    )
                                                        ->where('pengampus.id_guru', $jadwalKelas->pengampus->id_guru)
                                                        ->where('jadwalmapels.id_hari', 3)
                                                        ->where('jadwalmapels.id_waktu', $jadwalKelas->id_waktu)
                                                        ->count() > 1;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_guru }}</td>

                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_mapel }}</td>
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_ruangan }}</td>
                                @endforeach
                            </tr>

                            <tr>

                                <td style="white-space: nowrap;background-color: rgb(187,191,195)" class="text-center">
                                    11:00 - 11:20</td>

                                @foreach ($kelasGroups as $kelas => $jadwalByClass)
                                    @php
                                        $kode_guru = ''; // Initialize kode guru as empty string
                                        $kode_mapel = ''; // Initialize kode mapel as empty string
                                        $kode_ruangan = ''; // Initialize kode ruangan as empty string

                                    @endphp
                                    @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                                        @php
                                            $waktu1 = explode('-', $jadwalKelas->id_waktu);
                                            $start_time = $waktu1[0];
                                            $end_time = $waktu1[1];

                                            // Check if the desired time range falls within the id_waktu range
                                            $desired_start_time = '11:00';
                                            $desired_end_time = '11:20';
                                            $time_within_range =
                                                $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                                            $guruDuplicate = false;
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                                $guruDuplicate =
                                                    App\Models\Jadwalmapel::join(
                                                        'pengampus',
                                                        'jadwalmapels.id_pengampu',
                                                        '=',
                                                        'pengampus.id',
                                                    )
                                                        ->where('pengampus.id_guru', $jadwalKelas->pengampus->id_guru)
                                                        ->where('jadwalmapels.id_hari', 3)
                                                        ->where('jadwalmapels.id_waktu', $jadwalKelas->id_waktu)
                                                        ->count() > 1;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_guru }}</td>

                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_mapel }}</td>
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_ruangan }}</td>
                                @endforeach
                            </tr>
                            <tr>

                                <td style="white-space: nowrap;background-color: rgb(187,191,195)" class="text-center">
                                    11:20 - 11:40</td>

                                @foreach ($kelasGroups as $kelas => $jadwalByClass)
                                    @php
                                        $kode_guru = ''; // Initialize kode guru as empty string
                                        $kode_mapel = ''; // Initialize kode mapel as empty string
                                        $kode_ruangan = ''; // Initialize kode ruangan as empty string

                                    @endphp
                                    @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                                        @php
                                            $waktu1 = explode('-', $jadwalKelas->id_waktu);
                                            $start_time = $waktu1[0];
                                            $end_time = $waktu1[1];

                                            // Check if the desired time range falls within the id_waktu range
                                            $desired_start_time = '11:20';
                                            $desired_end_time = '11:40';
                                            $time_within_range =
                                                $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                                            $guruDuplicate = false;
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                                $guruDuplicate =
                                                    App\Models\Jadwalmapel::join(
                                                        'pengampus',
                                                        'jadwalmapels.id_pengampu',
                                                        '=',
                                                        'pengampus.id',
                                                    )
                                                        ->where('pengampus.id_guru', $jadwalKelas->pengampus->id_guru)
                                                        ->where('jadwalmapels.id_hari', 3)
                                                        ->where('jadwalmapels.id_waktu', $jadwalKelas->id_waktu)
                                                        ->count() > 1;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_guru }}</td>

                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_mapel }}</td>
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_ruangan }}</td>
                                @endforeach
                            </tr>

                            <tr>

                                <td style="white-space: nowrap;background-color: rgb(187,191,195)" class="text-center">
                                    11:40 - 12:00</td>

                                @foreach ($kelasGroups as $kelas => $jadwalByClass)
                                    @php
                                        $kode_guru = ''; // Initialize kode guru as empty string
                                        $kode_mapel = ''; // Initialize kode mapel as empty string
                                        $kode_ruangan = ''; // Initialize kode ruangan as empty string

                                    @endphp
                                    @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                                        @php
                                            $waktu1 = explode('-', $jadwalKelas->id_waktu);
                                            $start_time = $waktu1[0];
                                            $end_time = $waktu1[1];

                                            // Check if the desired time range falls within the id_waktu range
                                            $desired_start_time = '11:40';
                                            $desired_end_time = '12:00';
                                            $time_within_range =
                                                $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                                            $guruDuplicate = false;
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                                $guruDuplicate =
                                                    App\Models\Jadwalmapel::join(
                                                        'pengampus',
                                                        'jadwalmapels.id_pengampu',
                                                        '=',
                                                        'pengampus.id',
                                                    )
                                                        ->where('pengampus.id_guru', $jadwalKelas->pengampus->id_guru)
                                                        ->where('jadwalmapels.id_hari', 3)
                                                        ->where('jadwalmapels.id_waktu', $jadwalKelas->id_waktu)
                                                        ->count() > 1;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_guru }}</td>

                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_mapel }}</td>
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_ruangan }}</td>
                                @endforeach
                            </tr>
                            <tr>

                                <td style="white-space: nowrap;background-color: rgb(187,191,195)" class="text-center">
                                    12:00 - 12:20</td>

                                @foreach ($kelasGroups as $kelas => $jadwalByClass)
                                    @php
                                        $kode_guru = ''; // Initialize kode guru as empty string
                                        $kode_mapel = ''; // Initialize kode mapel as empty string
                                        $kode_ruangan = ''; // Initialize kode ruangan as empty string

                                    @endphp
                                    @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                                        @php
                                            $waktu1 = explode('-', $jadwalKelas->id_waktu);
                                            $start_time = $waktu1[0];
                                            $end_time = $waktu1[1];

                                            // Check if the desired time range falls within the id_waktu range
                                            $desired_start_time = '12:00';
                                            $desired_end_time = '12:20';
                                            $time_within_range =
                                                $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                                            $guruDuplicate = false;
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                                $guruDuplicate =
                                                    App\Models\Jadwalmapel::join(
                                                        'pengampus',
                                                        'jadwalmapels.id_pengampu',
                                                        '=',
                                                        'pengampus.id',
                                                    )
                                                        ->where('pengampus.id_guru', $jadwalKelas->pengampus->id_guru)
                                                        ->where('jadwalmapels.id_hari', 3)
                                                        ->where('jadwalmapels.id_waktu', $jadwalKelas->id_waktu)
                                                        ->count() > 1;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_guru }}</td>

                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_mapel }}</td>
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_ruangan }}</td>
                                @endforeach
                            </tr>


                            <tr>
                                <td style="white-space: nowrap;background-color: rgb(187,191,195)" class="text-center">
                                    12:20 - 13:00</td>

                                <td colspan="{{ $j }}" class="text-center"style="background-color: yellow">
                                    ISTIRAHAT</td>
                            </tr>

                            <tr>

                                <td style="white-space: nowrap;background-color: rgb(187,191,195)" class="text-center">
                                    13:00 - 13:20</td>

                                @foreach ($kelasGroups as $kelas => $jadwalByClass)
                                    @php
                                        $kode_guru = ''; // Initialize kode guru as empty string
                                        $kode_mapel = ''; // Initialize kode mapel as empty string
                                        $kode_ruangan = ''; // Initialize kode ruangan as empty string

                                    @endphp
                                    @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                                        @php
                                            $waktu1 = explode('-', $jadwalKelas->id_waktu);
                                            $start_time = $waktu1[0];
                                            $end_time = $waktu1[1];

                                            // Check if the desired time range falls within the id_waktu range
                                            $desired_start_time = '13:00';
                                            $desired_end_time = '13:20';
                                            $time_within_range =
                                                $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                                            $guruDuplicate = false;
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                                $guruDuplicate =
                                                    App\Models\Jadwalmapel::join(
                                                        'pengampus',
                                                        'jadwalmapels.id_pengampu',
                                                        '=',
                                                        'pengampus.id',
                                                    )
                                                        ->where('pengampus.id_guru', $jadwalKelas->pengampus->id_guru)
                                                        ->where('jadwalmapels.id_hari', 3)
                                                        ->where('jadwalmapels.id_waktu', $jadwalKelas->id_waktu)
                                                        ->count() > 1;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_guru }}</td>

                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_mapel }}</td>
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_ruangan }}</td>
                                @endforeach
                            </tr>

                            <tr>

                                <td style="white-space: nowrap;background-color: rgb(187,191,195)" class="text-center">
                                    13:20 - 13:40</td>

                                @foreach ($kelasGroups as $kelas => $jadwalByClass)
                                    @php
                                        $kode_guru = ''; // Initialize kode guru as empty string
                                        $kode_mapel = ''; // Initialize kode mapel as empty string
                                        $kode_ruangan = ''; // Initialize kode ruangan as empty string

                                    @endphp
                                    @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                                        @php
                                            $waktu1 = explode('-', $jadwalKelas->id_waktu);
                                            $start_time = $waktu1[0];
                                            $end_time = $waktu1[1];

                                            // Check if the desired time range falls within the id_waktu range
                                            $desired_start_time = '13:20';
                                            $desired_end_time = '13:40';
                                            $time_within_range =
                                                $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                                            $guruDuplicate = false;
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                                $guruDuplicate =
                                                    App\Models\Jadwalmapel::join(
                                                        'pengampus',
                                                        'jadwalmapels.id_pengampu',
                                                        '=',
                                                        'pengampus.id',
                                                    )
                                                        ->where('pengampus.id_guru', $jadwalKelas->pengampus->id_guru)
                                                        ->where('jadwalmapels.id_hari', 3)
                                                        ->where('jadwalmapels.id_waktu', $jadwalKelas->id_waktu)
                                                        ->count() > 1;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_guru }}</td>

                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_mapel }}</td>
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_ruangan }}</td>
                                @endforeach
                            </tr>

                            <tr>

                                <td style="white-space: nowrap;background-color: rgb(187,191,195)" class="text-center">
                                    13:40 - 14:00</td>

                                @foreach ($kelasGroups as $kelas => $jadwalByClass)
                                    @php
                                        $kode_guru = ''; // Initialize kode guru as empty string
                                        $kode_mapel = ''; // Initialize kode mapel as empty string
                                        $kode_ruangan = ''; // Initialize kode ruangan as empty string

                                    @endphp
                                    @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                                        @php
                                            $waktu1 = explode('-', $jadwalKelas->id_waktu);
                                            $start_time = $waktu1[0];
                                            $end_time = $waktu1[1];

                                            // Check if the desired time range falls within the id_waktu range
                                            $desired_start_time = '13:40';
                                            $desired_end_time = '14:00';
                                            $time_within_range =
                                                $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                                            $guruDuplicate = false;
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                                $guruDuplicate =
                                                    App\Models\Jadwalmapel::join(
                                                        'pengampus',
                                                        'jadwalmapels.id_pengampu',
                                                        '=',
                                                        'pengampus.id',
                                                    )
                                                        ->where('pengampus.id_guru', $jadwalKelas->pengampus->id_guru)
                                                        ->where('jadwalmapels.id_hari', 3)
                                                        ->where('jadwalmapels.id_waktu', $jadwalKelas->id_waktu)
                                                        ->count() > 1;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_guru }}</td>

                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_mapel }}</td>
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_ruangan }}</td>
                                @endforeach
                            </tr>

                            <tr>

                                <td style="white-space: nowrap;background-color: rgb(187,191,195)" class="text-center">
                                    14:00 - 14:20</td>

                                @foreach ($kelasGroups as $kelas => $jadwalByClass)
                                    @php
                                        $kode_guru = ''; // Initialize kode guru as empty string
                                        $kode_mapel = ''; // Initialize kode mapel as empty string
                                        $kode_ruangan = ''; // Initialize kode ruangan as empty string

                                    @endphp
                                    @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                                        @php
                                            $waktu1 = explode('-', $jadwalKelas->id_waktu);
                                            $start_time = $waktu1[0];
                                            $end_time = $waktu1[1];

                                            // Check if the desired time range falls within the id_waktu range
                                            $desired_start_time = '14:00';
                                            $desired_end_time = '14:20';
                                            $time_within_range =
                                                $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                                            $guruDuplicate = false;
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                                $guruDuplicate =
                                                    App\Models\Jadwalmapel::join(
                                                        'pengampus',
                                                        'jadwalmapels.id_pengampu',
                                                        '=',
                                                        'pengampus.id',
                                                    )
                                                        ->where('pengampus.id_guru', $jadwalKelas->pengampus->id_guru)
                                                        ->where('jadwalmapels.id_hari', 3)
                                                        ->where('jadwalmapels.id_waktu', $jadwalKelas->id_waktu)
                                                        ->count() > 1;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_guru }}</td>

                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_mapel }}</td>
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_ruangan }}</td>
                                @endforeach
                            </tr>

                            <tr>

                                <td style="white-space: nowrap;background-color: rgb(187,191,195)" class="text-center">
                                    14:20 - 14:40</td>

                                @foreach ($kelasGroups as $kelas => $jadwalByClass)
                                    @php
                                        $kode_guru = ''; // Initialize kode guru as empty string
                                        $kode_mapel = ''; // Initialize kode mapel as empty string
                                        $kode_ruangan = ''; // Initialize kode ruangan as empty string

                                    @endphp
                                    @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                                        @php
                                            $waktu1 = explode('-', $jadwalKelas->id_waktu);
                                            $start_time = $waktu1[0];
                                            $end_time = $waktu1[1];

                                            // Check if the desired time range falls within the id_waktu range
                                            $desired_start_time = '14:20';
                                            $desired_end_time = '14:40';
                                            $time_within_range =
                                                $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                                            $guruDuplicate = false;
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                                $guruDuplicate =
                                                    App\Models\Jadwalmapel::join(
                                                        'pengampus',
                                                        'jadwalmapels.id_pengampu',
                                                        '=',
                                                        'pengampus.id',
                                                    )
                                                        ->where('pengampus.id_guru', $jadwalKelas->pengampus->id_guru)
                                                        ->where('jadwalmapels.id_hari', 3)
                                                        ->where('jadwalmapels.id_waktu', $jadwalKelas->id_waktu)
                                                        ->count() > 1;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_guru }}</td>

                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_mapel }}</td>
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_ruangan }}</td>
                                @endforeach
                            </tr>
                        @endforeach


                        {{--  // Kamis //  --}}

                        @foreach ($hari->where('kode_hari', 'H04') as $key => $itemhari)
                            <tr>
                                <td rowspan="18" style="background-color: rgb(187,191,195)" class="text-center">
                                    {{ $itemhari->nama }}
                                </td>
                                <td style="white-space: nowrap;background-color: rgb(187,191,195)" class="text-center">
                                    07:00 - 07:40</td>

                                @foreach ($kelasGroups as $kelas => $jadwalByClass)
                                    @php
                                        $kode_guru = ''; // Initialize kode guru as empty string
                                        $kode_mapel = ''; // Initialize kode mapel as empty string
                                        $kode_ruangan = ''; // Initialize kode ruangan as empty string

                                    @endphp
                                    @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                                        @php
                                            $waktu1 = explode('-', $jadwalKelas->id_waktu);
                                            $start_time = $waktu1[0];
                                            $end_time = $waktu1[1];

                                            // Check if the desired time range falls within the id_waktu range
                                            $desired_start_time = '07:00';
                                            $desired_end_time = '07:40';
                                            $time_within_range =
                                                $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                                            $guruDuplicate = false;
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;

                                                $guruDuplicate =
                                                    App\Models\Jadwalmapel::join(
                                                        'pengampus',
                                                        'jadwalmapels.id_pengampu',
                                                        '=',
                                                        'pengampus.id',
                                                    )
                                                        ->where('pengampus.id_guru', $jadwalKelas->pengampus->id_guru)
                                                        ->where('jadwalmapels.id_hari', 4)
                                                        ->where('jadwalmapels.id_waktu', $jadwalKelas->id_waktu)
                                                        ->count() > 1;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_guru }}</td>

                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_mapel }}</td>
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_ruangan }}</td>
                                @endforeach
                            </tr>

                            <tr>

                                <td style="white-space: nowrap;background-color: rgb(187,191,195)" class="text-center">
                                    07:40 - 08:20</td>

                                @foreach ($kelasGroups as $kelas => $jadwalByClass)
                                    @php
                                        $kode_guru = ''; // Initialize kode guru as empty string
                                        $kode_mapel = ''; // Initialize kode mapel as empty string
                                        $kode_ruangan = ''; // Initialize kode ruangan as empty string

                                    @endphp
                                    @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                                        @php
                                            $waktu1 = explode('-', $jadwalKelas->id_waktu);
                                            $start_time = $waktu1[0];
                                            $end_time = $waktu1[1];

                                            // Check if the desired time range falls within the id_waktu range
                                            $desired_start_time = '07:40';
                                            $desired_end_time = '08:20';
                                            $time_within_range =
                                                $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                                            $guruDuplicate = false;
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                                $guruDuplicate =
                                                    App\Models\Jadwalmapel::join(
                                                        'pengampus',
                                                        'jadwalmapels.id_pengampu',
                                                        '=',
                                                        'pengampus.id',
                                                    )
                                                        ->where('pengampus.id_guru', $jadwalKelas->pengampus->id_guru)
                                                        ->where('jadwalmapels.id_hari', 4)
                                                        ->where('jadwalmapels.id_waktu', $jadwalKelas->id_waktu)
                                                        ->count() > 1;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_guru }}</td>

                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_mapel }}</td>
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_ruangan }}</td>
                                @endforeach
                            </tr>

                            <tr>

                                <td style="white-space: nowrap;background-color: rgb(187,191,195)" class="text-center">
                                    08:20 - 09:00</td>

                                @foreach ($kelasGroups as $kelas => $jadwalByClass)
                                    @php
                                        $kode_guru = ''; // Initialize kode guru as empty string
                                        $kode_mapel = ''; // Initialize kode mapel as empty string
                                        $kode_ruangan = ''; // Initialize kode ruangan as empty string

                                    @endphp
                                    @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                                        @php
                                            $waktu1 = explode('-', $jadwalKelas->id_waktu);
                                            $start_time = $waktu1[0];
                                            $end_time = $waktu1[1];

                                            // Check if the desired time range falls within the id_waktu range
                                            $desired_start_time = '08:20';
                                            $desired_end_time = '09:00';
                                            $time_within_range =
                                                $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                                            $guruDuplicate = false;
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                                $guruDuplicate =
                                                    App\Models\Jadwalmapel::join(
                                                        'pengampus',
                                                        'jadwalmapels.id_pengampu',
                                                        '=',
                                                        'pengampus.id',
                                                    )
                                                        ->where('pengampus.id_guru', $jadwalKelas->pengampus->id_guru)
                                                        ->where('jadwalmapels.id_hari', 4)
                                                        ->where('jadwalmapels.id_waktu', $jadwalKelas->id_waktu)
                                                        ->count() > 1;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_guru }}</td>

                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_mapel }}</td>
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_ruangan }}</td>
                                @endforeach
                            </tr>


                            <tr>

                                <td style="white-space: nowrap;background-color: rgb(187,191,195)" class="text-center">
                                    09:00 - 09:40</td>

                                @foreach ($kelasGroups as $kelas => $jadwalByClass)
                                    @php
                                        $kode_guru = ''; // Initialize kode guru as empty string
                                        $kode_mapel = ''; // Initialize kode mapel as empty string
                                        $kode_ruangan = ''; // Initialize kode ruangan as empty string

                                    @endphp
                                    @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                                        @php
                                            $waktu1 = explode('-', $jadwalKelas->id_waktu);
                                            $start_time = $waktu1[0];
                                            $end_time = $waktu1[1];

                                            // Check if the desired time range falls within the id_waktu range
                                            $desired_start_time = '09:00';
                                            $desired_end_time = '09:40';
                                            $time_within_range =
                                                $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                                            $guruDuplicate = false;
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                                $guruDuplicate =
                                                    App\Models\Jadwalmapel::join(
                                                        'pengampus',
                                                        'jadwalmapels.id_pengampu',
                                                        '=',
                                                        'pengampus.id',
                                                    )
                                                        ->where('pengampus.id_guru', $jadwalKelas->pengampus->id_guru)
                                                        ->where('jadwalmapels.id_hari', 4)
                                                        ->where('jadwalmapels.id_waktu', $jadwalKelas->id_waktu)
                                                        ->count() > 1;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_guru }}</td>

                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_mapel }}</td>
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_ruangan }}</td>
                                @endforeach
                            </tr>

                            <tr>

                                <td style="white-space: nowrap;background-color: rgb(187,191,195)" class="text-center">
                                    09:40 - 10:00</td>

                                @foreach ($kelasGroups as $kelas => $jadwalByClass)
                                    @php
                                        $kode_guru = ''; // Initialize kode guru as empty string
                                        $kode_mapel = ''; // Initialize kode mapel as empty string
                                        $kode_ruangan = ''; // Initialize kode ruangan as empty string

                                    @endphp
                                    @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                                        @php
                                            $waktu1 = explode('-', $jadwalKelas->id_waktu);
                                            $start_time = $waktu1[0];
                                            $end_time = $waktu1[1];

                                            // Check if the desired time range falls within the id_waktu range
                                            $desired_start_time = '09:40';
                                            $desired_end_time = '10:00';
                                            $time_within_range =
                                                $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                                            $guruDuplicate = false;
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                                $guruDuplicate =
                                                    App\Models\Jadwalmapel::join(
                                                        'pengampus',
                                                        'jadwalmapels.id_pengampu',
                                                        '=',
                                                        'pengampus.id',
                                                    )
                                                        ->where('pengampus.id_guru', $jadwalKelas->pengampus->id_guru)
                                                        ->where('jadwalmapels.id_hari', 4)
                                                        ->where('jadwalmapels.id_waktu', $jadwalKelas->id_waktu)
                                                        ->count() > 1;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_guru }}</td>

                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_mapel }}</td>
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_ruangan }}</td>
                                @endforeach
                            </tr>

                            <tr>
                                <td style="white-space: nowrap;background-color: rgb(187,191,195)" class="text-center">
                                    10:00 - 10:20</td>

                                <td colspan="{{ $j }}" class="text-center"style="background-color: yellow">
                                    ISTIRAHAT</td>
                            </tr>

                            <tr>

                                <td style="white-space: nowrap;background-color: rgb(187,191,195)" class="text-center">
                                    10:20 - 10:40</td>

                                @foreach ($kelasGroups as $kelas => $jadwalByClass)
                                    @php
                                        $kode_guru = ''; // Initialize kode guru as empty string
                                        $kode_mapel = ''; // Initialize kode mapel as empty string
                                        $kode_ruangan = ''; // Initialize kode ruangan as empty string

                                    @endphp
                                    @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                                        @php
                                            $waktu1 = explode('-', $jadwalKelas->id_waktu);
                                            $start_time = $waktu1[0];
                                            $end_time = $waktu1[1];

                                            // Check if the desired time range falls within the id_waktu range
                                            $desired_start_time = '10:20';
                                            $desired_end_time = '10:40';
                                            $time_within_range =
                                                $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                                            $guruDuplicate = false;
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                                $guruDuplicate =
                                                    App\Models\Jadwalmapel::join(
                                                        'pengampus',
                                                        'jadwalmapels.id_pengampu',
                                                        '=',
                                                        'pengampus.id',
                                                    )
                                                        ->where('pengampus.id_guru', $jadwalKelas->pengampus->id_guru)
                                                        ->where('jadwalmapels.id_hari', 4)
                                                        ->where('jadwalmapels.id_waktu', $jadwalKelas->id_waktu)
                                                        ->count() > 1;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_guru }}</td>

                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_mapel }}</td>
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_ruangan }}</td>
                                @endforeach
                            </tr>

                            <tr>

                                <td style="white-space: nowrap;background-color: rgb(187,191,195)" class="text-center">
                                    10:40 - 11:00</td>

                                @foreach ($kelasGroups as $kelas => $jadwalByClass)
                                    @php
                                        $kode_guru = ''; // Initialize kode guru as empty string
                                        $kode_mapel = ''; // Initialize kode mapel as empty string
                                        $kode_ruangan = ''; // Initialize kode ruangan as empty string

                                    @endphp
                                    @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                                        @php
                                            $waktu1 = explode('-', $jadwalKelas->id_waktu);
                                            $start_time = $waktu1[0];
                                            $end_time = $waktu1[1];

                                            // Check if the desired time range falls within the id_waktu range
                                            $desired_start_time = '10:40';
                                            $desired_end_time = '11:00';
                                            $time_within_range =
                                                $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                                            $guruDuplicate = false;
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                                $guruDuplicate =
                                                    App\Models\Jadwalmapel::join(
                                                        'pengampus',
                                                        'jadwalmapels.id_pengampu',
                                                        '=',
                                                        'pengampus.id',
                                                    )
                                                        ->where('pengampus.id_guru', $jadwalKelas->pengampus->id_guru)
                                                        ->where('jadwalmapels.id_hari', 4)
                                                        ->where('jadwalmapels.id_waktu', $jadwalKelas->id_waktu)
                                                        ->count() > 1;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_guru }}</td>

                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_mapel }}</td>
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_ruangan }}</td>
                                @endforeach
                            </tr>

                            <tr>

                                <td style="white-space: nowrap;background-color: rgb(187,191,195)" class="text-center">
                                    11:00 - 11:20</td>

                                @foreach ($kelasGroups as $kelas => $jadwalByClass)
                                    @php
                                        $kode_guru = ''; // Initialize kode guru as empty string
                                        $kode_mapel = ''; // Initialize kode mapel as empty string
                                        $kode_ruangan = ''; // Initialize kode ruangan as empty string

                                    @endphp
                                    @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                                        @php
                                            $waktu1 = explode('-', $jadwalKelas->id_waktu);
                                            $start_time = $waktu1[0];
                                            $end_time = $waktu1[1];

                                            // Check if the desired time range falls within the id_waktu range
                                            $desired_start_time = '11:00';
                                            $desired_end_time = '11:20';
                                            $time_within_range =
                                                $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                                            $guruDuplicate = false;
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                                $guruDuplicate =
                                                    App\Models\Jadwalmapel::join(
                                                        'pengampus',
                                                        'jadwalmapels.id_pengampu',
                                                        '=',
                                                        'pengampus.id',
                                                    )
                                                        ->where('pengampus.id_guru', $jadwalKelas->pengampus->id_guru)
                                                        ->where('jadwalmapels.id_hari', 4)
                                                        ->where('jadwalmapels.id_waktu', $jadwalKelas->id_waktu)
                                                        ->count() > 1;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_guru }}</td>

                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_mapel }}</td>
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_ruangan }}</td>
                                @endforeach
                            </tr>
                            <tr>

                                <td style="white-space: nowrap;background-color: rgb(187,191,195)" class="text-center">
                                    11:20 - 11:40</td>

                                @foreach ($kelasGroups as $kelas => $jadwalByClass)
                                    @php
                                        $kode_guru = ''; // Initialize kode guru as empty string
                                        $kode_mapel = ''; // Initialize kode mapel as empty string
                                        $kode_ruangan = ''; // Initialize kode ruangan as empty string

                                    @endphp
                                    @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                                        @php
                                            $waktu1 = explode('-', $jadwalKelas->id_waktu);
                                            $start_time = $waktu1[0];
                                            $end_time = $waktu1[1];

                                            // Check if the desired time range falls within the id_waktu range
                                            $desired_start_time = '11:20';
                                            $desired_end_time = '11:40';
                                            $time_within_range =
                                                $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                                            $guruDuplicate = false;
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                                $guruDuplicate =
                                                    App\Models\Jadwalmapel::join(
                                                        'pengampus',
                                                        'jadwalmapels.id_pengampu',
                                                        '=',
                                                        'pengampus.id',
                                                    )
                                                        ->where('pengampus.id_guru', $jadwalKelas->pengampus->id_guru)
                                                        ->where('jadwalmapels.id_hari', 4)
                                                        ->where('jadwalmapels.id_waktu', $jadwalKelas->id_waktu)
                                                        ->count() > 1;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_guru }}</td>

                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_mapel }}</td>
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_ruangan }}</td>
                                @endforeach
                            </tr>

                            <tr>

                                <td style="white-space: nowrap;background-color: rgb(187,191,195)" class="text-center">
                                    11:40 - 12:00</td>

                                @foreach ($kelasGroups as $kelas => $jadwalByClass)
                                    @php
                                        $kode_guru = ''; // Initialize kode guru as empty string
                                        $kode_mapel = ''; // Initialize kode mapel as empty string
                                        $kode_ruangan = ''; // Initialize kode ruangan as empty string

                                    @endphp
                                    @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                                        @php
                                            $waktu1 = explode('-', $jadwalKelas->id_waktu);
                                            $start_time = $waktu1[0];
                                            $end_time = $waktu1[1];

                                            // Check if the desired time range falls within the id_waktu range
                                            $desired_start_time = '11:40';
                                            $desired_end_time = '12:00';
                                            $time_within_range =
                                                $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                                            $guruDuplicate = false;
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                                $guruDuplicate =
                                                    App\Models\Jadwalmapel::join(
                                                        'pengampus',
                                                        'jadwalmapels.id_pengampu',
                                                        '=',
                                                        'pengampus.id',
                                                    )
                                                        ->where('pengampus.id_guru', $jadwalKelas->pengampus->id_guru)
                                                        ->where('jadwalmapels.id_hari', 4)
                                                        ->where('jadwalmapels.id_waktu', $jadwalKelas->id_waktu)
                                                        ->count() > 1;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_guru }}</td>

                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_mapel }}</td>
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_ruangan }}</td>
                                @endforeach
                            </tr>
                            <tr>

                                <td style="white-space: nowrap;background-color: rgb(187,191,195)" class="text-center">
                                    12:00 - 12:20</td>

                                @foreach ($kelasGroups as $kelas => $jadwalByClass)
                                    @php
                                        $kode_guru = ''; // Initialize kode guru as empty string
                                        $kode_mapel = ''; // Initialize kode mapel as empty string
                                        $kode_ruangan = ''; // Initialize kode ruangan as empty string

                                    @endphp
                                    @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                                        @php
                                            $waktu1 = explode('-', $jadwalKelas->id_waktu);
                                            $start_time = $waktu1[0];
                                            $end_time = $waktu1[1];

                                            // Check if the desired time range falls within the id_waktu range
                                            $desired_start_time = '12:00';
                                            $desired_end_time = '12:20';
                                            $time_within_range =
                                                $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                                            $guruDuplicate = false;
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                                $guruDuplicate =
                                                    App\Models\Jadwalmapel::join(
                                                        'pengampus',
                                                        'jadwalmapels.id_pengampu',
                                                        '=',
                                                        'pengampus.id',
                                                    )
                                                        ->where('pengampus.id_guru', $jadwalKelas->pengampus->id_guru)
                                                        ->where('jadwalmapels.id_hari', 4)
                                                        ->where('jadwalmapels.id_waktu', $jadwalKelas->id_waktu)
                                                        ->count() > 1;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_guru }}</td>

                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_mapel }}</td>
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_ruangan }}</td>
                                @endforeach
                            </tr>


                            <tr>
                                <td style="white-space: nowrap;background-color: rgb(187,191,195)" class="text-center">
                                    12:20 - 13:00</td>

                                <td colspan="{{ $j }}" class="text-center"style="background-color: yellow">
                                    ISTIRAHAT</td>
                            </tr>

                            <tr>

                                <td style="white-space: nowrap;background-color: rgb(187,191,195)" class="text-center">
                                    13:00 - 13:20</td>

                                @foreach ($kelasGroups as $kelas => $jadwalByClass)
                                    @php
                                        $kode_guru = ''; // Initialize kode guru as empty string
                                        $kode_mapel = ''; // Initialize kode mapel as empty string
                                        $kode_ruangan = ''; // Initialize kode ruangan as empty string

                                    @endphp
                                    @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                                        @php
                                            $waktu1 = explode('-', $jadwalKelas->id_waktu);
                                            $start_time = $waktu1[0];
                                            $end_time = $waktu1[1];

                                            // Check if the desired time range falls within the id_waktu range
                                            $desired_start_time = '13:00';
                                            $desired_end_time = '13:20';
                                            $time_within_range =
                                                $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                                            $guruDuplicate = false;
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                                $guruDuplicate =
                                                    App\Models\Jadwalmapel::join(
                                                        'pengampus',
                                                        'jadwalmapels.id_pengampu',
                                                        '=',
                                                        'pengampus.id',
                                                    )
                                                        ->where('pengampus.id_guru', $jadwalKelas->pengampus->id_guru)
                                                        ->where('jadwalmapels.id_hari', 4)
                                                        ->where('jadwalmapels.id_waktu', $jadwalKelas->id_waktu)
                                                        ->count() > 1;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_guru }}</td>

                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_mapel }}</td>
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_ruangan }}</td>
                                @endforeach
                            </tr>

                            <tr>

                                <td style="white-space: nowrap;background-color: rgb(187,191,195)" class="text-center">
                                    13:20 - 13:40</td>

                                @foreach ($kelasGroups as $kelas => $jadwalByClass)
                                    @php
                                        $kode_guru = ''; // Initialize kode guru as empty string
                                        $kode_mapel = ''; // Initialize kode mapel as empty string
                                        $kode_ruangan = ''; // Initialize kode ruangan as empty string

                                    @endphp
                                    @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                                        @php
                                            $waktu1 = explode('-', $jadwalKelas->id_waktu);
                                            $start_time = $waktu1[0];
                                            $end_time = $waktu1[1];

                                            // Check if the desired time range falls within the id_waktu range
                                            $desired_start_time = '13:20';
                                            $desired_end_time = '13:40';
                                            $time_within_range =
                                                $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                                            $guruDuplicate = false;
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                                $guruDuplicate =
                                                    App\Models\Jadwalmapel::join(
                                                        'pengampus',
                                                        'jadwalmapels.id_pengampu',
                                                        '=',
                                                        'pengampus.id',
                                                    )
                                                        ->where('pengampus.id_guru', $jadwalKelas->pengampus->id_guru)
                                                        ->where('jadwalmapels.id_hari', 4)
                                                        ->where('jadwalmapels.id_waktu', $jadwalKelas->id_waktu)
                                                        ->count() > 1;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_guru }}</td>

                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_mapel }}</td>
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_ruangan }}</td>
                                @endforeach
                            </tr>

                            <tr>

                                <td style="white-space: nowrap;background-color: rgb(187,191,195)" class="text-center">
                                    13:40 - 14:00</td>

                                @foreach ($kelasGroups as $kelas => $jadwalByClass)
                                    @php
                                        $kode_guru = ''; // Initialize kode guru as empty string
                                        $kode_mapel = ''; // Initialize kode mapel as empty string
                                        $kode_ruangan = ''; // Initialize kode ruangan as empty string

                                    @endphp
                                    @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                                        @php
                                            $waktu1 = explode('-', $jadwalKelas->id_waktu);
                                            $start_time = $waktu1[0];
                                            $end_time = $waktu1[1];

                                            // Check if the desired time range falls within the id_waktu range
                                            $desired_start_time = '13:40';
                                            $desired_end_time = '14:00';
                                            $time_within_range =
                                                $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                                            $guruDuplicate = false;
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;

                                                $guruDuplicate =
                                                    App\Models\Jadwalmapel::join(
                                                        'pengampus',
                                                        'jadwalmapels.id_pengampu',
                                                        '=',
                                                        'pengampus.id',
                                                    )
                                                        ->where('pengampus.id_guru', $jadwalKelas->pengampus->id_guru)
                                                        ->where('jadwalmapels.id_hari', 4)
                                                        ->where('jadwalmapels.id_waktu', $jadwalKelas->id_waktu)
                                                        ->count() > 1;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_guru }}</td>

                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_mapel }}</td>
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_ruangan }}</td>
                                @endforeach
                            </tr>

                            <tr>

                                <td style="white-space: nowrap;background-color: rgb(187,191,195)" class="text-center">
                                    14:00 - 14:20</td>

                                @foreach ($kelasGroups as $kelas => $jadwalByClass)
                                    @php
                                        $kode_guru = ''; // Initialize kode guru as empty string
                                        $kode_mapel = ''; // Initialize kode mapel as empty string
                                        $kode_ruangan = ''; // Initialize kode ruangan as empty string

                                    @endphp
                                    @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                                        @php
                                            $waktu1 = explode('-', $jadwalKelas->id_waktu);
                                            $start_time = $waktu1[0];
                                            $end_time = $waktu1[1];

                                            // Check if the desired time range falls within the id_waktu range
                                            $desired_start_time = '14:00';
                                            $desired_end_time = '14:20';
                                            $time_within_range =
                                                $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                                            $guruDuplicate = false;
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;

                                                $guruDuplicate =
                                                    App\Models\Jadwalmapel::join(
                                                        'pengampus',
                                                        'jadwalmapels.id_pengampu',
                                                        '=',
                                                        'pengampus.id',
                                                    )
                                                        ->where('pengampus.id_guru', $jadwalKelas->pengampus->id_guru)
                                                        ->where('jadwalmapels.id_hari', 4)
                                                        ->where('jadwalmapels.id_waktu', $jadwalKelas->id_waktu)
                                                        ->count() > 1;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_guru }}</td>

                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_mapel }}</td>
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_ruangan }}</td>
                                @endforeach
                            </tr>

                            <tr>

                                <td style="white-space: nowrap;background-color: rgb(187,191,195)" class="text-center">
                                    14:20 - 14:40</td>

                                @foreach ($kelasGroups as $kelas => $jadwalByClass)
                                    @php
                                        $kode_guru = ''; // Initialize kode guru as empty string
                                        $kode_mapel = ''; // Initialize kode mapel as empty string
                                        $kode_ruangan = ''; // Initialize kode ruangan as empty string

                                    @endphp
                                    @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                                        @php
                                            $waktu1 = explode('-', $jadwalKelas->id_waktu);
                                            $start_time = $waktu1[0];
                                            $end_time = $waktu1[1];

                                            // Check if the desired time range falls within the id_waktu range
                                            $desired_start_time = '14:20';
                                            $desired_end_time = '14:40';
                                            $time_within_range =
                                                $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                                            $guruDuplicate = false;
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                                $guruDuplicate =
                                                    App\Models\Jadwalmapel::join(
                                                        'pengampus',
                                                        'jadwalmapels.id_pengampu',
                                                        '=',
                                                        'pengampus.id',
                                                    )
                                                        ->where('pengampus.id_guru', $jadwalKelas->pengampus->id_guru)
                                                        ->where('jadwalmapels.id_hari', 4)
                                                        ->where('jadwalmapels.id_waktu', $jadwalKelas->id_waktu)
                                                        ->count() > 1;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_guru }}</td>

                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_mapel }}</td>
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_ruangan }}</td>
                                @endforeach
                            </tr>
                        @endforeach



                        {{--  // jumat //  --}}

                        @foreach ($hari->where('kode_hari', 'H05') as $key => $itemhari)
                            <tr>

                                <td rowspan="18" style="background-color: rgb(187,191,195)" class="text-center">
                                    {{ $itemhari->nama }}
                                </td>

                                <td style="white-space: nowrap;background-color: rgb(187,191,195)" class="text-center">
                                    07:00 - 08:00</td>
                                <td colspan="{{ $j }}" class="text-center" style="background-color: yellow">
                                    KULTUM</td>
                            </tr>
                            <tr>
                                <td style="white-space: nowrap;background-color: rgb(187,191,195)" class="text-center">
                                    08:00 - 08:40</td>

                                @foreach ($kelasGroups as $kelas => $jadwalByClass)
                                    @php
                                        $kode_guru = ''; // Initialize kode guru as empty string
                                        $kode_mapel = ''; // Initialize kode mapel as empty string
                                        $kode_ruangan = ''; // Initialize kode ruangan as empty string

                                    @endphp
                                    @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                                        @php
                                            $waktu1 = explode('-', $jadwalKelas->id_waktu);
                                            $start_time = $waktu1[0];
                                            $end_time = $waktu1[1];

                                            // Check if the desired time range falls within the id_waktu range
                                            $desired_start_time = '08:00';
                                            $desired_end_time = '08:40';
                                            $time_within_range =
                                                $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                                            $guruDuplicate = false;
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                                $guruDuplicate =
                                                    App\Models\Jadwalmapel::join(
                                                        'pengampus',
                                                        'jadwalmapels.id_pengampu',
                                                        '=',
                                                        'pengampus.id',
                                                    )
                                                        ->where('pengampus.id_guru', $jadwalKelas->pengampus->id_guru)
                                                        ->where('jadwalmapels.id_hari', 5)
                                                        ->where('jadwalmapels.id_waktu', $jadwalKelas->id_waktu)
                                                        ->count() > 1;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_guru }}</td>

                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_mapel }}</td>
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_ruangan }}</td>
                                @endforeach
                            </tr>

                            <tr>
                                <td style="white-space: nowrap;background-color: rgb(187,191,195)" class="text-center">
                                    08:40 - 09:20</td>
                                @foreach ($kelasGroups as $kelas => $jadwalByClass)
                                    @php
                                        $kode_guru = ''; // Initialize kode guru as empty string
                                        $kode_mapel = ''; // Initialize kode mapel as empty string
                                        $kode_ruangan = ''; // Initialize kode ruangan as empty string

                                    @endphp
                                    @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                                        @php
                                            $waktu1 = explode('-', $jadwalKelas->id_waktu);
                                            $start_time = $waktu1[0];
                                            $end_time = $waktu1[1];

                                            // Check if the desired time range falls within the id_waktu range
                                            $desired_start_time = '08:40';
                                            $desired_end_time = '09:20';
                                            $time_within_range =
                                                $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                                            $guruDuplicate = false;
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                                $guruDuplicate =
                                                    App\Models\Jadwalmapel::join(
                                                        'pengampus',
                                                        'jadwalmapels.id_pengampu',
                                                        '=',
                                                        'pengampus.id',
                                                    )
                                                        ->where('pengampus.id_guru', $jadwalKelas->pengampus->id_guru)
                                                        ->where('jadwalmapels.id_hari', 5)
                                                        ->where('jadwalmapels.id_waktu', $jadwalKelas->id_waktu)
                                                        ->count() > 1;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_guru }}</td>

                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_mapel }}</td>
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_ruangan }}</td>
                                @endforeach
                            </tr>

                            <tr>
                                <td style="white-space: nowrap;background-color: rgb(187,191,195)" class="text-center">
                                    09:20 - 10:00</td>
                                @foreach ($kelasGroups as $kelas => $jadwalByClass)
                                    @php
                                        $kode_guru = ''; // Initialize kode guru as empty string
                                        $kode_mapel = ''; // Initialize kode mapel as empty string
                                        $kode_ruangan = ''; // Initialize kode ruangan as empty string

                                    @endphp
                                    @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                                        @php
                                            $waktu1 = explode('-', $jadwalKelas->id_waktu);
                                            $start_time = $waktu1[0];
                                            $end_time = $waktu1[1];

                                            // Check if the desired time range falls within the id_waktu range
                                            $desired_start_time = '09:20';
                                            $desired_end_time = '10:00';
                                            $time_within_range =
                                                $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                                            $guruDuplicate = false;
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                                $guruDuplicate =
                                                    App\Models\Jadwalmapel::join(
                                                        'pengampus',
                                                        'jadwalmapels.id_pengampu',
                                                        '=',
                                                        'pengampus.id',
                                                    )
                                                        ->where('pengampus.id_guru', $jadwalKelas->pengampus->id_guru)
                                                        ->where('jadwalmapels.id_hari', 5)
                                                        ->where('jadwalmapels.id_waktu', $jadwalKelas->id_waktu)
                                                        ->count() > 1;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_guru }}</td>

                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_mapel }}</td>
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_ruangan }}</td>
                                @endforeach
                            </tr>

                            <tr>
                                <td style="white-space: nowrap;background-color: rgb(187,191,195)" class="text-center">
                                    10:00 - 10:20</td>

                                <td colspan="{{ $j }}" class="text-center"style="background-color: yellow">
                                    ISTIRAHAT</td>
                            </tr>

                            <tr>
                                <td style="white-space: nowrap;background-color: rgb(187,191,195)" class="text-center">
                                    10:20 - 10:40</td>
                                @foreach ($kelasGroups as $kelas => $jadwalByClass)
                                    @php
                                        $kode_guru = ''; // Initialize kode guru as empty string
                                        $kode_mapel = ''; // Initialize kode mapel as empty string
                                        $kode_ruangan = ''; // Initialize kode ruangan as empty string

                                    @endphp
                                    @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                                        @php
                                            $waktu1 = explode('-', $jadwalKelas->id_waktu);
                                            $start_time = $waktu1[0];
                                            $end_time = $waktu1[1];

                                            // Check if the desired time range falls within the id_waktu range
                                            $desired_start_time = '10:20';
                                            $desired_end_time = '10:40';
                                            $time_within_range =
                                                $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                                            $guruDuplicate = false;
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                                $guruDuplicate =
                                                    App\Models\Jadwalmapel::join(
                                                        'pengampus',
                                                        'jadwalmapels.id_pengampu',
                                                        '=',
                                                        'pengampus.id',
                                                    )
                                                        ->where('pengampus.id_guru', $jadwalKelas->pengampus->id_guru)
                                                        ->where('jadwalmapels.id_hari', 5)
                                                        ->where('jadwalmapels.id_waktu', $jadwalKelas->id_waktu)
                                                        ->count() > 1;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_guru }}</td>

                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_mapel }}</td>
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_ruangan }}</td>
                                @endforeach
                            </tr>
                            <tr>
                                <td style="white-space: nowrap;background-color: rgb(187,191,195)" class="text-center">
                                    10:40 - 11:00</td>
                                @foreach ($kelasGroups as $kelas => $jadwalByClass)
                                    @php
                                        $kode_guru = ''; // Initialize kode guru as empty string
                                        $kode_mapel = ''; // Initialize kode mapel as empty string
                                        $kode_ruangan = ''; // Initialize kode ruangan as empty string

                                    @endphp
                                    @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                                        @php
                                            $waktu1 = explode('-', $jadwalKelas->id_waktu);
                                            $start_time = $waktu1[0];
                                            $end_time = $waktu1[1];

                                            // Check if the desired time range falls within the id_waktu range
                                            $desired_start_time = '10:40';
                                            $desired_end_time = '11:00';
                                            $time_within_range =
                                                $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                                            $guruDuplicate = false;
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                                $guruDuplicate =
                                                    App\Models\Jadwalmapel::join(
                                                        'pengampus',
                                                        'jadwalmapels.id_pengampu',
                                                        '=',
                                                        'pengampus.id',
                                                    )
                                                        ->where('pengampus.id_guru', $jadwalKelas->pengampus->id_guru)
                                                        ->where('jadwalmapels.id_hari', 5)
                                                        ->where('jadwalmapels.id_waktu', $jadwalKelas->id_waktu)
                                                        ->count() > 1;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_guru }}</td>

                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_mapel }}</td>
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_ruangan }}</td>
                                @endforeach
                            </tr>
                            <tr>
                                <td style="white-space: nowrap;background-color: rgb(187,191,195)" class="text-center">
                                    11:00 - 11:20</td>
                                @foreach ($kelasGroups as $kelas => $jadwalByClass)
                                    @php
                                        $kode_guru = ''; // Initialize kode guru as empty string
                                        $kode_mapel = ''; // Initialize kode mapel as empty string
                                        $kode_ruangan = ''; // Initialize kode ruangan as empty string

                                    @endphp
                                    @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                                        @php
                                            $waktu1 = explode('-', $jadwalKelas->id_waktu);
                                            $start_time = $waktu1[0];
                                            $end_time = $waktu1[1];

                                            // Check if the desired time range falls within the id_waktu range
                                            $desired_start_time = '11:00';
                                            $desired_end_time = '11:20';
                                            $time_within_range =
                                                $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                                            $guruDuplicate = false;
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                                $guruDuplicate =
                                                    App\Models\Jadwalmapel::join(
                                                        'pengampus',
                                                        'jadwalmapels.id_pengampu',
                                                        '=',
                                                        'pengampus.id',
                                                    )
                                                        ->where('pengampus.id_guru', $jadwalKelas->pengampus->id_guru)
                                                        ->where('jadwalmapels.id_hari', 5)
                                                        ->where('jadwalmapels.id_waktu', $jadwalKelas->id_waktu)
                                                        ->count() > 1;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_guru }}</td>

                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_mapel }}</td>
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_ruangan }}</td>
                                @endforeach
                            </tr>

                            </tr>
                            <tr>
                                <td style="white-space: nowrap;background-color: rgb(187,191,195)" class="text-center">
                                    11:20 - 11:40</td>
                                @foreach ($kelasGroups as $kelas => $jadwalByClass)
                                    @php
                                        $kode_guru = ''; // Initialize kode guru as empty string
                                        $kode_mapel = ''; // Initialize kode mapel as empty string
                                        $kode_ruangan = ''; // Initialize kode ruangan as empty string

                                    @endphp
                                    @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                                        @php
                                            $waktu1 = explode('-', $jadwalKelas->id_waktu);
                                            $start_time = $waktu1[0];
                                            $end_time = $waktu1[1];

                                            // Check if the desired time range falls within the id_waktu range
                                            $desired_start_time = '11:20';
                                            $desired_end_time = '11:40';
                                            $time_within_range =
                                                $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                                            $guruDuplicate = false;
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                                $guruDuplicate =
                                                    App\Models\Jadwalmapel::join(
                                                        'pengampus',
                                                        'jadwalmapels.id_pengampu',
                                                        '=',
                                                        'pengampus.id',
                                                    )
                                                        ->where('pengampus.id_guru', $jadwalKelas->pengampus->id_guru)
                                                        ->where('jadwalmapels.id_hari', 5)
                                                        ->where('jadwalmapels.id_waktu', $jadwalKelas->id_waktu)
                                                        ->count() > 1;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_guru }}</td>

                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_mapel }}</td>
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_ruangan }}</td>
                                @endforeach
                            </tr>

                            <tr>
                                <td style="white-space: nowrap;background-color: rgb(187,191,195)" class="text-center">
                                    11:40 - 13:20</td>

                                <td colspan="{{ $j }}" class="text-center" style="background-color: yellow">
                                    ISTIRAHAT</td>
                            </tr>
                            <tr>
                                <td style="white-space: nowrap;background-color: rgb(187,191,195)" class="text-center">
                                    13:20 - 13:40</td>
                                @foreach ($kelasGroups as $kelas => $jadwalByClass)
                                    @php
                                        $kode_guru = ''; // Initialize kode guru as empty string
                                        $kode_mapel = ''; // Initialize kode mapel as empty string
                                        $kode_ruangan = ''; // Initialize kode ruangan as empty string

                                    @endphp
                                    @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                                        @php
                                            $waktu1 = explode('-', $jadwalKelas->id_waktu);
                                            $start_time = $waktu1[0];
                                            $end_time = $waktu1[1];

                                            // Check if the desired time range falls within the id_waktu range
                                            $desired_start_time = '13:20';
                                            $desired_end_time = '13:40';
                                            $time_within_range =
                                                $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                                            $guruDuplicate = false;
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                                $guruDuplicate =
                                                    App\Models\Jadwalmapel::join(
                                                        'pengampus',
                                                        'jadwalmapels.id_pengampu',
                                                        '=',
                                                        'pengampus.id',
                                                    )
                                                        ->where('pengampus.id_guru', $jadwalKelas->pengampus->id_guru)
                                                        ->where('jadwalmapels.id_hari', 5)
                                                        ->where('jadwalmapels.id_waktu', $jadwalKelas->id_waktu)
                                                        ->count() > 1;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_guru }}</td>

                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_mapel }}</td>
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_ruangan }}</td>
                                @endforeach
                            </tr>
                            <tr>
                                <td style="white-space: nowrap;background-color: rgb(187,191,195)" class="text-center">
                                    13:40 - 14:00</td>
                                @foreach ($kelasGroups as $kelas => $jadwalByClass)
                                    @php
                                        $kode_guru = ''; // Initialize kode guru as empty string
                                        $kode_mapel = ''; // Initialize kode mapel as empty string
                                        $kode_ruangan = ''; // Initialize kode ruangan as empty string

                                    @endphp
                                    @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                                        @php
                                            $waktu1 = explode('-', $jadwalKelas->id_waktu);
                                            $start_time = $waktu1[0];
                                            $end_time = $waktu1[1];

                                            // Check if the desired time range falls within the id_waktu range
                                            $desired_start_time = '13:40';
                                            $desired_end_time = '14:00';
                                            $time_within_range =
                                                $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                                            $guruDuplicate = false;
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                                $guruDuplicate =
                                                    App\Models\Jadwalmapel::join(
                                                        'pengampus',
                                                        'jadwalmapels.id_pengampu',
                                                        '=',
                                                        'pengampus.id',
                                                    )
                                                        ->where('pengampus.id_guru', $jadwalKelas->pengampus->id_guru)
                                                        ->where('jadwalmapels.id_hari', 5)
                                                        ->where('jadwalmapels.id_waktu', $jadwalKelas->id_waktu)
                                                        ->count() > 1;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_guru }}</td>

                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_mapel }}</td>
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_ruangan }}</td>
                                @endforeach
                            </tr>

                            <tr>
                                <td style="white-space: nowrap;background-color: rgb(187,191,195)" class="text-center">
                                    14:00 - 14:20</td>
                                @foreach ($kelasGroups as $kelas => $jadwalByClass)
                                    @php
                                        $kode_guru = ''; // Initialize kode guru as empty string
                                        $kode_mapel = ''; // Initialize kode mapel as empty string
                                        $kode_ruangan = ''; // Initialize kode ruangan as empty string

                                    @endphp
                                    @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                                        @php
                                            $waktu1 = explode('-', $jadwalKelas->id_waktu);
                                            $start_time = $waktu1[0];
                                            $end_time = $waktu1[1];

                                            // Check if the desired time range falls within the id_waktu range
                                            $desired_start_time = '14:00';
                                            $desired_end_time = '14:20';
                                            $time_within_range =
                                                $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                                            $guruDuplicate = false;
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                                $guruDuplicate =
                                                    App\Models\Jadwalmapel::join(
                                                        'pengampus',
                                                        'jadwalmapels.id_pengampu',
                                                        '=',
                                                        'pengampus.id',
                                                    )
                                                        ->where('pengampus.id_guru', $jadwalKelas->pengampus->id_guru)
                                                        ->where('jadwalmapels.id_hari', 5)
                                                        ->where('jadwalmapels.id_waktu', $jadwalKelas->id_waktu)
                                                        ->count() > 1;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_guru }}</td>

                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_mapel }}</td>
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_ruangan }}</td>
                                @endforeach
                            </tr>
                            <tr>
                                <td style="white-space: nowrap;background-color: rgb(187,191,195)" class="text-center">
                                    14:20 - 14:40</td>
                                @foreach ($kelasGroups as $kelas => $jadwalByClass)
                                    @php
                                        $kode_guru = ''; // Initialize kode guru as empty string
                                        $kode_mapel = ''; // Initialize kode mapel as empty string
                                        $kode_ruangan = ''; // Initialize kode ruangan as empty string

                                    @endphp
                                    @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                                        @php
                                            $waktu1 = explode('-', $jadwalKelas->id_waktu);
                                            $start_time = $waktu1[0];
                                            $end_time = $waktu1[1];

                                            // Check if the desired time range falls within the id_waktu range
                                            $desired_start_time = '14:20';
                                            $desired_end_time = '14:40';
                                            $time_within_range =
                                                $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                                            $guruDuplicate = false;
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                                $guruDuplicate =
                                                    App\Models\Jadwalmapel::join(
                                                        'pengampus',
                                                        'jadwalmapels.id_pengampu',
                                                        '=',
                                                        'pengampus.id',
                                                    )
                                                        ->where('pengampus.id_guru', $jadwalKelas->pengampus->id_guru)
                                                        ->where('jadwalmapels.id_hari', 5)
                                                        ->where('jadwalmapels.id_waktu', $jadwalKelas->id_waktu)
                                                        ->count() > 1;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_guru }}</td>

                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_mapel }}</td>
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_ruangan }}</td>
                                @endforeach
                            </tr>
                            <tr>
                                <td style="white-space: nowrap;background-color: rgb(187,191,195)" class="text-center">
                                    14:40 - 15:00</td>
                                @foreach ($kelasGroups as $kelas => $jadwalByClass)
                                    @php
                                        $kode_guru = ''; // Initialize kode guru as empty string
                                        $kode_mapel = ''; // Initialize kode mapel as empty string
                                        $kode_ruangan = ''; // Initialize kode ruangan as empty string

                                    @endphp
                                    @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                                        @php
                                            $waktu1 = explode('-', $jadwalKelas->id_waktu);
                                            $start_time = $waktu1[0];
                                            $end_time = $waktu1[1];

                                            // Check if the desired time range falls within the id_waktu range
                                            $desired_start_time = '14:40';
                                            $desired_end_time = '15:00';
                                            $time_within_range =
                                                $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                                            $guruDuplicate = false;
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                                $guruDuplicate =
                                                    App\Models\Jadwalmapel::join(
                                                        'pengampus',
                                                        'jadwalmapels.id_pengampu',
                                                        '=',
                                                        'pengampus.id',
                                                    )
                                                        ->where('pengampus.id_guru', $jadwalKelas->pengampus->id_guru)
                                                        ->where('jadwalmapels.id_hari', 5)
                                                        ->where('jadwalmapels.id_waktu', $jadwalKelas->id_waktu)
                                                        ->count() > 1;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_guru }}</td>

                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_mapel }}</td>
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_ruangan }}</td>
                                @endforeach
                            </tr>
                            <tr>
                                <td style="white-space: nowrap;background-color: rgb(187,191,195)" class="text-center">
                                    15:00 - 15:20</td>
                                @foreach ($kelasGroups as $kelas => $jadwalByClass)
                                    @php
                                        $kode_guru = ''; // Initialize kode guru as empty string
                                        $kode_mapel = ''; // Initialize kode mapel as empty string
                                        $kode_ruangan = ''; // Initialize kode ruangan as empty string

                                    @endphp
                                    @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                                        @php
                                            $waktu1 = explode('-', $jadwalKelas->id_waktu);
                                            $start_time = $waktu1[0];
                                            $end_time = $waktu1[1];

                                            // Check if the desired time range falls within the id_waktu range
                                            $desired_start_time = '15:00';
                                            $desired_end_time = '15:20';
                                            $time_within_range =
                                                $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                                            $guruDuplicate = false;
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                                $guruDuplicate =
                                                    App\Models\Jadwalmapel::join(
                                                        'pengampus',
                                                        'jadwalmapels.id_pengampu',
                                                        '=',
                                                        'pengampus.id',
                                                    )
                                                        ->where('pengampus.id_guru', $jadwalKelas->pengampus->id_guru)
                                                        ->where('jadwalmapels.id_hari', 5)
                                                        ->where('jadwalmapels.id_waktu', $jadwalKelas->id_waktu)
                                                        ->count() > 1;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_guru }}</td>

                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_mapel }}</td>
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_ruangan }}</td>
                                @endforeach
                            </tr>

                            <tr>
                                <td style="white-space: nowrap;background-color: rgb(187,191,195)" class="text-center">
                                    15:20 - 15:40</td>
                                @foreach ($kelasGroups as $kelas => $jadwalByClass)
                                    @php
                                        $kode_guru = ''; // Initialize kode guru as empty string
                                        $kode_mapel = ''; // Initialize kode mapel as empty string
                                        $kode_ruangan = ''; // Initialize kode ruangan as empty string

                                    @endphp
                                    @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                                        @php
                                            $waktu1 = explode('-', $jadwalKelas->id_waktu);
                                            $start_time = $waktu1[0];
                                            $end_time = $waktu1[1];

                                            // Check if the desired time range falls within the id_waktu range
                                            $desired_start_time = '15:20';
                                            $desired_end_time = '15:40';
                                            $time_within_range =
                                                $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                                            $guruDuplicate = false;
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                                $guruDuplicate =
                                                    App\Models\Jadwalmapel::join(
                                                        'pengampus',
                                                        'jadwalmapels.id_pengampu',
                                                        '=',
                                                        'pengampus.id',
                                                    )
                                                        ->where('pengampus.id_guru', $jadwalKelas->pengampus->id_guru)
                                                        ->where('jadwalmapels.id_hari', 5)
                                                        ->where('jadwalmapels.id_waktu', $jadwalKelas->id_waktu)
                                                        ->count() > 1;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_guru }}</td>

                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_mapel }}</td>
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_ruangan }}</td>
                                @endforeach
                            </tr>

                            <tr>
                                <td style="white-space: nowrap;background-color: rgb(187,191,195)" class="text-center">
                                    15:40 - 16:00</td>
                                @foreach ($kelasGroups as $kelas => $jadwalByClass)
                                    @php
                                        $kode_guru = ''; // Initialize kode guru as empty string
                                        $kode_mapel = ''; // Initialize kode mapel as empty string
                                        $kode_ruangan = ''; // Initialize kode ruangan as empty string

                                    @endphp
                                    @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                                        @php
                                            $waktu1 = explode('-', $jadwalKelas->id_waktu);
                                            $start_time = $waktu1[0];
                                            $end_time = $waktu1[1];

                                            // Check if the desired time range falls within the id_waktu range
                                            $desired_start_time = '15:40';
                                            $desired_end_time = '16:00';
                                            $time_within_range =
                                                $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                                            $guruDuplicate = false;
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                                $guruDuplicate =
                                                    App\Models\Jadwalmapel::join(
                                                        'pengampus',
                                                        'jadwalmapels.id_pengampu',
                                                        '=',
                                                        'pengampus.id',
                                                    )
                                                        ->where('pengampus.id_guru', $jadwalKelas->pengampus->id_guru)
                                                        ->where('jadwalmapels.id_hari', 5)
                                                        ->where('jadwalmapels.id_waktu', $jadwalKelas->id_waktu)
                                                        ->count() > 1;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_guru }}</td>

                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_mapel }}</td>
                                    <td @if ($guruDuplicate) style=" background-color: red" @endif
                                        class="text-center">{{ $kode_ruangan }}</td>
                                @endforeach
                            </tr>
                        @endforeach



                    </tbody>
                </table>
            </div>




            <div id="example-tab-6" class="tab-pane leading-relaxed" role="tabpanel" aria-labelledby="example-6-tab">
                <table id="datatable" class="table table-bordered">
                    <thead>
                        <tr>

                            <th style="white-space: nowrap;">No.</th>
                            <th style="white-space: nowrap;">Seksi</th>
                            <th style="white-space: nowrap;">Kode </th>
                            <th style="white-space: nowrap;">Hari</th>
                            <th style="white-space: nowrap;">Waktu</th>
                            <th style="white-space: nowrap;">Guru </th>
                            <th style="white-space: nowrap;">Mata Pelajaran</th>
                            <th style="white-space: nowrap;">Kelas</th>
                            <th style="white-space: nowrap;">JP</th>
                            <th style="white-space: nowrap;">Kode Ruangan</th>
                            <th style="white-space: nowrap;">Semester</th>
                            <th style="white-space: nowrap;">Status</th>
                            <th style="white-space: nowrap;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($jadwalmapel as $key => $item)
                            @php
                                $pengampuid = App\Models\Pengampu::find($item->id_pengampu);
                                $mapelid = App\Models\Mapel::find($pengampuid->id_mapel);
                                $guruid = App\Models\Guru::find($pengampuid->id_guru);
                                $kelas = App\Models\Kelas::find($pengampuid->kelas);
                            @endphp

                            <tr>
                                <td align="center">
                                    {{ $key + 1 }} </td>
                                <td style="white-space: nowrap;" class="text-primary">
                                    {{ $item->kode_jadwalmapel }}
                                </td>
                                <td style="white-space: nowrap;" class="text-primary">
                                    {{ $item['pengampus']['kode_pengampu'] }}
                                </td>
                                <td style="white-space: nowrap;"> {{ $item['haris']['nama'] }}
                                </td>
                                <td style="white-space: nowrap;"> {{ $item->id_waktu }}
                                </td>
                                <td style="white-space: nowrap;">
                                    {{ $guruid->nama }} </td>
                                <td style="white-space: nowrap;">
                                    {{ $mapelid->nama }} </td>
                                <td style="white-space: nowrap;">
                                    {{ $kelas->tingkat }}
                                    {{ $kelas->nama }}
                                    {{ $kelas['jurusans']['nama'] }}
                                </td>
                                <td style="white-space: nowrap;"> {{ $mapelid->jp }} </td>
                                <td style="white-space: nowrap;"> {{ $item['ruangans']['kode_ruangan'] }}
                                </td>
                                <td style="white-space: nowrap;">
                                    {{ $item['tahun']['semester'] }}
                                    - {{ $item['tahun']['tahun'] }}
                                </td>

                                <td style="white-space: nowrap;">
                                    @if ($item->status == '0')
                                        <span class="btn btn-outline-warning">Proses
                                            Penjadwalan</span>
                                    @elseif($item->status == '1')
                                        <span class="btn btn-outline-pending">Menunggu
                                            Verifikasi</span>
                                    @elseif($item->status == '2')
                                        <span class="btn btn-outline-success">Kirim</span>
                                    @elseif($item->status == '3')
                                        <span class="btn btn-outline-danger">Ditolak</span>
                                    @endif

                                </td>
                                <td style="white-space: nowrap;">

                                    <a id="delete" href="{{ route('jadwalmapel.delete', $item->id) }}"
                                        class="btn btn-danger mr-1 mb-2">
                                        <i data-lucide="trash" class="w-4 h-4"></i>
                                    </a>

                                    <a href="javascript:;" data-tw-toggle="modal"
                                        data-tw-target="#edit-jadwalmapels-modal-{{ $item->id }}"
                                        class="btn btn-primary mb-2">
                                        <i data-lucide="edit" class="w-4 h-4 mb"></i>
                                    </a>

                                    @if ($item->status == '0' || $item->status == '3')
                                        <a href="javascript:;" data-tw-toggle="modal"
                                            data-tw-target="#kirim-jadwalmapels-modal-{{ $item->id }}"
                                            class="btn btn-primary">
                                            <i data-lucide="send" class="w-4 h-4"></i>
                                        </a>
                                    @endif

                                </td>


                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>




        <!-- Modal Tambah Jadwal -->

        <div id="add-jadwalmapels-modal" class="modal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="font-medium text-base mr-auto">Tambah Jadwal Mapel</h2>
                    </div>
                    <form method="post" action="{{ route('jadwalmapel.store') }}" enctype="multipart/form-data"
                        id="myForm1">
                        @csrf
                        <div class="modal-body">
                            <div class="grid grid-cols-12 gap-4 gap-y-3 mb-4">
                                <!-- Kode Pengampu -->
                                <div class="col-span-12 sm:col-span-4">
                                    <div class="mb-2">
                                        <div class="mb-2">
                                            <label for="id_pengampu">KODE PENGAMPU</label>
                                        </div>
                                        <select name="id_pengampu" id="id_pengampu" class="tom-select w-full" required>
                                            <optgroup>
                                                <option value="">Pilih Kode Pengampu</option>
                                                @foreach ($pengampu as $item)
                                                    <option value="{{ $item->id }}">
                                                        {{ $item->kode_pengampu }} / {{ $item['gurus']['nama'] }}
                                                    </option>
                                                @endforeach
                                            </optgroup>
                                        </select>
                                    </div>
                                </div>

                                <!-- Tabel Data -->
                                <div class="col-span-12">
                                    <div class="card overflow-x-auto">
                                        <div class="card-body table-responsive">
                                            <table id="data-table" class="table table-sm" style="width: 100%;">
                                                <thead>
                                                    <tr>

                                                        <th>Kode Pengampu</th>
                                                        <th>Nama Guru</th>
                                                        <th>Mata Pelajaran</th>
                                                        <th>Kelas</th>
                                                        <th>Jp</th>
                                                        <th>Tahun Ajar</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="grid grid-cols-12 gap-4 gap-y-3 mt-8 mb-4">
                                <!-- Waktu -->
                                <div class="col-span-12 sm:col-span-4">
                                    <div class="mb-2">
                                        <label for="edit-jam">Waktu</label>
                                    </div>
                                    <select name="id_waktu" id="id_waktu" class="form-control w-full" required>
                                        <option value="">Pilih Waktu</option>
                                        {{--  @foreach ($waktu as $item)
                                            <option value="{{ $item->id }}">{{ $item->range }}</option>
                                        @endforeach  --}}
                                        <option value="07:00-09:40">07:00-09:40</option>
                                    </select>
                                </div>

                                <!-- Hari -->
                                <div class="col-span-12 sm:col-span-4">
                                    <label for="modal-form-4" class="form-label">Hari</label>
                                    <select name="id_hari" id="id_hari" class="form-control w-full" required>
                                        <option value="">Pilih Hari</option>
                                        @foreach ($hari as $item)
                                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                        @endforeach


                                    </select>
                                </div>

                                <!-- Ruangan -->
                                <div class="col-span-12 sm:col-span-4">
                                    <div class="mb-2">
                                        <label for="edit-ruangan">Ruangan</label>
                                    </div>
                                    <select name="id_ruangan" id="id_ruangan" class="form-control w-full" required>
                                        <option value="">Pilih Ruangan</option>
                                        @foreach ($ruangan as $item)
                                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <!-- Tahun Ajar -->

                            </div>
                        </div>
                        <p class="horizontal-align ml-4">
                            <i data-lucide="alert-triangle" class="mr-1 text-danger"></i>
                            <span class="text-danger">Pastikan data yang diinputkan benar.</span>
                        </p>

                        <div class="modal-footer">
                            <button type="button" data-tw-dismiss="modal"
                                class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
                            <button type="submit" class="btn btn-primary w-20">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script type="text/javascript">
            $(document).ready(function() {
                $('#myForm1').validate({
                    rules: {
                        id_waktu: {
                            required: true,
                        },
                        id_hari: {
                            required: true,
                        },
                        id_ruangan: {
                            required: true,
                        },

                    },
                    messages: {
                        id_waktu: {
                            required: 'Please Enter Your Waktu',
                        },
                        id_hari: {
                            required: 'Please Enter Your Hari',
                        },
                        id_ruangan: {
                            required: 'Please Enter Your Ruangan',
                        },


                    },
                    errorElement: 'span',
                    errorClass: 'invalid-feedback',
                    errorPlacement: function(error, element) {
                        error.insertAfter(element);
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

        {{--  Scrip Menampilkan data tabel  --}}

        <script>
            // Tangkap elemen dropdown select
            const selectElement = document.getElementById('id_pengampu');

            // Tambahkan event listener untuk menangani perubahan dalam dropdown
            selectElement.addEventListener('change', function() {
                // Ambil nilai yang dipilih dalam dropdown
                const selectedValue = selectElement.value;

                // Buat AJAX request atau manipulasi data sesuai kebutuhan Anda
                // Di sini, kita hanya akan menambahkan data ke dalam tabel sebagai contoh
                const tableBody = document.querySelector('#data-table tbody');
                tableBody.innerHTML = ''; // Bersihkan isi tabel sebelum menambahkan data baru

                // Loop melalui data pengampu untuk menemukan yang sesuai dengan nilai yang dipilih
                @foreach ($pengampu as $item)
                    if ("{{ $item->id }}" === selectedValue) {
                        const newRow = tableBody.insertRow();
                        const cell1 = newRow.insertCell(0); // Hanya satu kolom yang perlu ditambahkan sekarang
                        const cell2 = newRow.insertCell(1);
                        const cell3 = newRow.insertCell(2);
                        const cell4 = newRow.insertCell(3);
                        const cell5 = newRow.insertCell(4);
                        const cell6 = newRow.insertCell(5);


                        cell1.textContent = "{{ $item->kode_pengampu }}"; // Kode Pengampu
                        cell2.textContent = "{{ $item->gurus->nama }}"; // Nama Guru (berdasarkan relasi)
                        cell3.textContent = "{{ $item->mapels->nama }}"; // Mata Pelajaran (berdasarkan relasi)
                        cell4.textContent =
                            "{{ $item->kelass->tingkat }} {{ $item->kelass->nama }} {{ $item->kelass->jurusans->nama }}"; // Kelas
                        cell5.textContent = "{{ $item->mapels->jp }}"; // Jp
                        cell6.textContent = "{{ $item->tahuns->semester }} - {{ $item->tahuns->tahun }}";

                    }
                @endforeach
            });
        </script>

        <!-- End Modal Tambah Jadwal -->






        <!-- Modal Edit Jadwal -->

        @foreach ($jadwalmapel as $item)
            <div class="modal fade" id="edit-jadwalmapels-modal-{{ $item->id }}" tabindex="-1" role="dialog"
                aria-labelledby="edit-jadwalmapels-modal-label-{{ $item->id }}" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h2 class="font-medium text-base mr-auto">Edit Jadwal Mapel</h2>
                        </div>

                        <div class="modal-body">
                            <div class="grid grid-cols-12 gap-4 gap-y-3 mb-4">

                                <!-- Tabel Data -->
                                <div class="col-span-12">
                                    <div class="card overflow-x-auto">
                                        <div class="card-body table-responsive">
                                            <table id="data-table1" class="table table-sm" style="width: 100%;">
                                                <thead>
                                                    <tr>

                                                        <th>Kode Pengampu</th>
                                                        <th>Nama Guru</th>
                                                        <th>Mata Pelajaran</th>
                                                        <th>Kelas</th>
                                                        <th>Jp</th>
                                                        <th>Tahun Ajar</th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $pengampuid = App\Models\Pengampu::find($item->id_pengampu);
                                                        $mapelid = App\Models\Mapel::find($pengampuid->id_mapel);
                                                        $guruid = App\Models\Guru::find($pengampuid->id_guru);
                                                    @endphp

                                                    <tr>

                                                        <td style="white-space: nowrap;">
                                                            {{ $pengampuid->kode_pengampu }} </td>
                                                        <td style="white-space: nowrap;"> {{ $guruid->nama }} </td>
                                                        <td style="white-space: nowrap;"> {{ $mapelid->nama }} </td>
                                                        <td style="white-space: nowrap;">
                                                            {{ $pengampuid['kelass']['tingkat'] }}
                                                            {{ $pengampuid['kelass']['nama'] }}
                                                            {{ $pengampuid['kelass']['jurusans']['nama'] }} </td>
                                                        <td style="white-space: nowrap;">
                                                            {{ $mapelid->jp }} </td>
                                                        <td style="white-space: nowrap;">
                                                            {{ $pengampuid->tahuns->semester }} -
                                                            {{ $pengampuid->tahuns->tahun }} </td>


                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="row">

                                <div class="col-6">
                                    <div class="intro-y grid grid-cols-12 gap-12 ">
                                        <div class="col-span-12 lg:col-span-12">

                                            <div class="intro-y box mt-5">

                                                <div id="boxed-tab" class="p-5">
                                                    <div class="preview">
                                                        <ul class="nav nav-boxed-tabs" role="tablist">
                                                            <li id="example-3-tab" class="nav-item flex-1"
                                                                role="presentation">
                                                                <button class="nav-link w-full py-2 active"
                                                                    data-tw-toggle="pill" data-tw-target="#example-tab-3"
                                                                    type="button" role="tab"
                                                                    aria-controls="example-tab-3" aria-selected="true">
                                                                    Tukar</button>
                                                            </li>
                                                            <li id="example-4-tab" class="nav-item flex-1"
                                                                role="presentation">
                                                                <button class="nav-link w-full py-2" data-tw-toggle="pill"
                                                                    data-tw-target="#example-tab-4" type="button"
                                                                    role="tab" aria-controls="example-tab-4"
                                                                    aria-selected="false"> Rubah </button>
                                                            </li>
                                                        </ul>


                                                        <div class="tab-content mt-5">
                                                            <div id="example-tab-3"
                                                                class="tab-pane leading-relaxed mt- 4 active"
                                                                role="tabpanel" aria-labelledby="example-3-tab">
                                                                <form method="post"
                                                                    action="{{ route('jadwalmapel.tukar', $item->id) }}">
                                                                    @csrf
                                                                    <div class="grid grid-cols-12 gap-4 gap-y-3 mt-8 mb-4">
                                                                        <!-- Waktu -->
                                                                        <div class="col-span-12 sm:col-span-6">

                                                                            <select name="id2" id="id_waktu"
                                                                                class="form-control w-full" required>

                                                                                @php
                                                                                    $jad = App\Models\Jadwalmapel::join(
                                                                                        'pengampus',
                                                                                        'pengampus.id',
                                                                                        '=',
                                                                                        'jadwalmapels.id_pengampu',
                                                                                    )
                                                                                        ->join(
                                                                                            'mapels',
                                                                                            'mapels.id',
                                                                                            '=',
                                                                                            'pengampus.id_mapel',
                                                                                        )
                                                                                        ->where(
                                                                                            'pengampus.kelas',
                                                                                            $item->pengampus->kelas,
                                                                                        )
                                                                                        ->where(
                                                                                            'mapels.jp',
                                                                                            $mapelid->jp,
                                                                                        )
                                                                                        ->orderby(
                                                                                            'jadwalmapels.id_hari',
                                                                                        )
                                                                                        ->orderby(
                                                                                            'jadwalmapels.id_waktu',
                                                                                        )
                                                                                        ->select('jadwalmapels.*')
                                                                                        ->get();
                                                                                @endphp
                                                                                @foreach ($jad as $itemjad)
                                                                                    <option value="{{ $itemjad->id }}">
                                                                                        {{ $itemjad->haris->nama }} -
                                                                                        {{ $itemjad->id_waktu }} -
                                                                                        {{ $itemjad->pengampus->mapels->nama }}
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>


                                                                    </div>

                                                                    <p class="horizontal-align ml-4">
                                                                        <i data-lucide="alert-triangle"
                                                                            class="mr-1 text-danger"></i>
                                                                        <span class="text-danger">Pastikan data yang
                                                                            diinputkan benar.</span>
                                                                    </p>


                                                                    <div class="modal-footer">
                                                                        <button type="button" data-tw-dismiss="modal"
                                                                            class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
                                                                        <button type="submit"
                                                                            class="btn btn-primary w-20">Save</button>
                                                                    </div>
                                                                </form>

                                                            </div>
                                                            <div id="example-tab-4" class="tab-pane leading-relaxed"
                                                                role="tabpanel" aria-labelledby="example-4-tab">
                                                                <form method="post"
                                                                    action="{{ route('jadwalmapel.update', $item->id) }}">
                                                                    @csrf
                                                                    <div class="grid grid-cols-12 gap-4 gap-y-3 mt-8 mb-4">
                                                                        <div class="col-span-12 sm:col-span-4">
                                                                            <label for="modal-form-4"
                                                                                class="form-label">Hari</label>
                                                                            <select name="id_hari" id="id_hari"
                                                                                class="form-control w-full" required>
                                                                                <option value="{{ $item->id_hari }}">
                                                                                    {{ $item['haris']['nama'] }}</option>
                                                                                @foreach ($hari as $item2)
                                                                                    <option value="{{ $item2->id }}">
                                                                                        {{ $item2->nama }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-span-12 sm:col-span-4">
                                                                            <div class="mb-2">
                                                                                <label for="edit-jam">Waktu</label>
                                                                            </div>
                                                                            @php
                                                                                $datajp = App\Models\Mapel::where(
                                                                                    'id',
                                                                                    $mapelid->id,
                                                                                )->first();
                                                                            @endphp
                                                                            <select name="id_waktu" id="id_waktu"
                                                                                class="form-control w-full" required>

                                                                                <option value="">----Senin----
                                                                                </option>
                                                                                {{--  // jp 2 //  --}}
                                                                               @if ($datajp->jp == 2)
                                                                                   
                                                                               
                                                                                    <option value="08:00-09:20">
                                                                                        08:00-09:20 -{{$datajp->jp}}
                                                                                    </option>
                                                                                    <option value="09:20-11:00">
                                                                                        09:20-11:00
                                                                                    </option>
                                                                                    <option value="10:20-11:40">
                                                                                        10:20-11:40
                                                                                    </option>
                                                                                    <option value="11:00-12:20">
                                                                                        11:00-12:20
                                                                                    </option>
                                                                                    <option value="11:40-13:40">
                                                                                        11:40-13:40
                                                                                    </option>
                                                                                    <option value="14:20-15:40">
                                                                                        14:20-15:40
                                                                                    </option>
                                                                                    @endif
                                                                               

                                                                                {{--  // jp 3 //  --}}
                                                                                <option value="08:00-10:10"> 08:00-09:20
                                                                                </option>
                                                                                <option value="09:20-11:40"> 09:20-11:40
                                                                                </option>
                                                                                <option value="10:20-12:20"> 10:20-12:20
                                                                                </option>
                                                                                <option value="11:00-13:40"> 11:00-13:40
                                                                                </option>
                                                                                <option value="11:40-14:20"> 11:40-14:20
                                                                                </option>
                                                                                <option value="13:40-15:40"> 13:40-15:40
                                                                                </option>

                                                                                {{--  // jp 4 //  --}}
                                                                                <option value="08:00-11:00"> 08:00-11:00
                                                                                </option>
                                                                                <option value="09:20-12:20"> 09:20-12:20
                                                                                </option>
                                                                                <option value="10:20-13:40"> 10:20-13:40
                                                                                </option>
                                                                                <option value="11:00-14:20">11:00-14:20
                                                                                </option>
                                                                                <option value="12:20-15:40">12:20-15:40
                                                                                </option>
                                                                                <option value="13:00-15:40">13:00-15:40
                                                                                </option>

                                                                                {{--  // jp 6 //  --}}
                                                                                <option value="08:00-12:20">08:00-12:20
                                                                                </option>
                                                                                <option value="09:20-14:20">09:20-14:20
                                                                                </option>
                                                                                <option value="11:00-15:40">11:00-15:40
                                                                                </option>

                                                                                <option value="">----Selasa----
                                                                                </option>

                                                                                {{--  // jp 2 //  --}}
                                                                                <option value="07:00-08:20">07:00-08:20
                                                                                </option>
                                                                                <option value="08:20-09:40">08:20-09:40
                                                                                </option>
                                                                                <option value="09:00-10:40">09:00-10:40
                                                                                </option>
                                                                                <option value="09:40-11:20">09:40-11:20
                                                                                </option>
                                                                                <option value="10:40-12:00">10:40-12:00
                                                                                </option>
                                                                                <option value="11:20-13:20">11:20-13:20
                                                                                </option>
                                                                                <option value="12:00-14:00">12:00-14:00
                                                                                </option>
                                                                                <option value="14:00-15:20">14:00-15:20
                                                                                </option>

                                                                                {{--  // jp 3 //  --}}
                                                                                <option value="07:00-09:00">07:00-09:00
                                                                                </option>
                                                                                <option value="08:20-10:40">08:20-10:40
                                                                                </option>
                                                                                <option value="09:00-11:20">09:00-11:20
                                                                                </option>
                                                                                <option value="09:40-12:00">09:40-12:00
                                                                                </option>
                                                                                <option value="10:40-13:20">10:40-13:20
                                                                                </option>
                                                                                <option value="11:20-14:00">11:20-14:00
                                                                                </option>
                                                                                <option value="13:20-15:20">13:20-15:20
                                                                                </option>

                                                                                {{--  // jp 4 //  --}}
                                                                                <option value="07:00-09:40">07:00-09:40
                                                                                </option>
                                                                                <option value="08:20-11:20">08:20-11:20
                                                                                </option>
                                                                                <option value="09:00-12:00">09:00-12:00
                                                                                </option>
                                                                                <option value="09:40-13:20">09:40-13:20
                                                                                </option>
                                                                                <option value="12:00-15:20">12:00-15:20
                                                                                </option>

                                                                                {{--  // jp 6 //  --}}
                                                                                <option value="07:00-11:20">07:00-11:20
                                                                                </option>
                                                                                <option value="08:20-13:20">08:20-13:20
                                                                                </option>
                                                                                <option value="09:00-14:00">09:00-14:00
                                                                                </option>


                                                                                <option value="">----Rabu----
                                                                                </option>

                                                                                {{--  // jp 2 //  --}}
                                                                                <option value="07:00-08:20">07:00-08:20
                                                                                </option>
                                                                                <option value="08:20-09:40">08:20-09:40
                                                                                </option>
                                                                                <option value="09:00-10:40">09:00-10:40
                                                                                </option>
                                                                                <option value="09:40-11:20">09:40-11:20
                                                                                </option>
                                                                                <option value="10:40-12:00">10:40-12:00
                                                                                </option>
                                                                                <option value="11:20-13:20">11:20-13:20
                                                                                </option>
                                                                                <option value="13:20-14:40">14:20-14:40
                                                                                </option>

                                                                                {{--  // jp 3 //  --}}
                                                                                <option value="07:00-09:00">07:00-09:00
                                                                                </option>
                                                                                <option value="08:20-10:40">08:20-10:40
                                                                                </option>
                                                                                <option value="09:00-11:20">09:00-11:20
                                                                                </option>
                                                                                <option value="09:40-12:00">09:40-12:00
                                                                                </option>
                                                                                <option value="12:00-14:40">12:00-14:40
                                                                                </option>

                                                                                {{--  // jp 4 //  --}}
                                                                                <option value="07:00-09:40">07:00-09:40
                                                                                </option>
                                                                                <option value="08:20-11:20">08:20-11:20
                                                                                </option>
                                                                                <option value="09:00-12:00">09:00-12:00
                                                                                </option>
                                                                                <option value="09:40-13:20">09:40-13:20
                                                                                </option>
                                                                                <option value="11:20-14:40">11:20-14:40
                                                                                </option>

                                                                                {{--  // jp 6 //  --}}
                                                                                <option value="07:00-11:20">07:00-11:20
                                                                                </option>
                                                                                <option value="08:20-13:20">08:20-13:20
                                                                                </option>
                                                                                <option value="09:00-14:40">09:00-14:40
                                                                                </option>


                                                                                <option value="">----Kamis----
                                                                                </option>

                                                                                {{--  // jp 2 //  --}}
                                                                                <option value="07:00-08:20">07:00-08:20
                                                                                </option>
                                                                                <option value="08:20-09:40">08:20-09:40
                                                                                </option>
                                                                                <option value="09:00-10:40">09:00-10:40
                                                                                </option>
                                                                                <option value="09:40-11:20">09:40-11:20
                                                                                </option>
                                                                                <option value="10:40-12:00">10:40-12:00
                                                                                </option>
                                                                                <option value="11:20-13:20">11:20-13:20
                                                                                </option>
                                                                                <option value="13:20-14:40">14:20-14:40
                                                                                </option>

                                                                                {{--  // jp 3 //  --}}
                                                                                <option value="07:00-09:00">07:00-09:00
                                                                                </option>
                                                                                <option value="08:20-10:40">08:20-10:40
                                                                                </option>
                                                                                <option value="09:00-11:20">09:00-11:20
                                                                                </option>
                                                                                <option value="09:40-12:00">09:40-12:00
                                                                                </option>
                                                                                <option value="12:00-14:40">12:00-14:40
                                                                                </option>

                                                                                {{--  // jp 4 //  --}}
                                                                                <option value="07:00-09:40">07:00-09:40
                                                                                </option>
                                                                                <option value="08:20-11:20">08:20-11:20
                                                                                </option>
                                                                                <option value="09:00-12:00">09:00-12:00
                                                                                </option>
                                                                                <option value="09:40-13:20">09:40-13:20
                                                                                </option>
                                                                                <option value="11:20-14:40">11:20-14:40
                                                                                </option>

                                                                                {{--  // jp 6 //  --}}
                                                                                <option value="07:00-11:20">07:00-11:20
                                                                                </option>
                                                                                <option value="08:20-13:20">08:20-13:20
                                                                                </option>
                                                                                <option value="09:00-14:40">09:00-14:40
                                                                                </option>

                                                                                <option value="">----Jumat----
                                                                                </option>
                                                                                {{--  // jp 2 //  --}}
                                                                                <option value="08:00-09:20"> 08:00-09:20
                                                                                </option>
                                                                                <option value="09:20-11:00"> 09:20-11:00
                                                                                </option>
                                                                                <option value="10:20-11:40"> 10:20-11:40
                                                                                </option>
                                                                                <option value="11:00-14:00"> 11:00-14:00
                                                                                </option>
                                                                                <option value="11:40-14:40"> 11:40-14:40
                                                                                </option>
                                                                                <option value="14:40-16:00"> 14:40-16:00
                                                                                </option>

                                                                                {{--  // jp 3 //  --}}
                                                                                <option value="08:00-10:10"> 08:00-09:20
                                                                                </option>
                                                                                <option value="09:20-11:40"> 09:20-11:40
                                                                                </option>
                                                                                <option value="10:00-14:00"> 10:00-14:00
                                                                                </option>
                                                                                <option value="11:00-14:40"> 11:00-14:40
                                                                                </option>
                                                                                <option value="14:00-16:00"> 14:00-16:00
                                                                                </option>

                                                                                {{--  // jp 4 //  --}}
                                                                                <option value="08:00-11:00"> 08:00-11:00
                                                                                </option>
                                                                                <option value="09:20-14:00"> 09:20-14:00
                                                                                </option>
                                                                                <option value="10:20-14:40"> 10:20-14:40
                                                                                </option>
                                                                                <option value="11:00-14:20">11:00-14:20
                                                                                </option>
                                                                                <option value="13:20-16:00">13:20-16:00
                                                                                </option>


                                                                                {{--  // jp 6 //  --}}
                                                                                <option value="08:00-14:00">08:00-14:00
                                                                                </option>
                                                                                <option value="10:20-16:00">10:20-16:00
                                                                                </option>


                                                                            </select>
                                                                        </div>

                                                                        <!-- Hari -->


                                                                        <!-- Ruangan -->
                                                                        <div class="col-span-12 sm:col-span-4">
                                                                            <div class="mb-2">
                                                                                <label for="edit-ruangan">Ruangan</label>
                                                                            </div>
                                                                            <select name="id_ruangan" id="id_ruangan"
                                                                                class="form-control w-full" required>
                                                                                <option value="{{ $item->id_ruangan }}">
                                                                                    {{ $item['ruangans']['nama'] }}
                                                                                </option>
                                                                                @foreach ($ruangan as $item3)
                                                                                    <option value="{{ $item3->id }}">
                                                                                        {{ $item3->nama }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>



                                                                    </div>

                                                                    <p class="horizontal-align ml-4">
                                                                        <i data-lucide="alert-triangle"
                                                                            class="mr-1 text-danger"></i>
                                                                        <span class="text-danger">Pastikan data yang
                                                                            diinputkan benar.</span>
                                                                    </p>


                                                                    <div class="modal-footer">
                                                                        <button type="button" data-tw-dismiss="modal"
                                                                            class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
                                                                        <button type="submit"
                                                                            class="btn btn-primary w-20">Save</button>
                                                                    </div>
                                                                </form>

                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                            </div>






                        </div>
                    </div>
                </div>
        @endforeach


        <!-- End Modal Edit Jadwal -->




        <!-- BEGIN: Modal Kirim Jadwal All-->
        <div id="button-modal-preview" class="modal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <form method="post" action="{{ route('jadwalmapelstatusall.update') }}">
                    @csrf
                    <div class="modal-content"> <a data-tw-dismiss="modal" href="javascript:;"> <i data-lucide="x"
                                class="w-8 h-8 text-slate-400"></i> </a>
                        <div class="modal-body p-0">
                            <div class="p-5 text-center"> <i data-lucide="check-circle"
                                    class="w-16 h-16 text-success mx-auto mt-3"></i>
                                <div class="text-3xl mt-5">Kirim Jadwal </div>
                                <div class="text-slate-500 mt-2">Data Jadwal Mata Pelajaran Di Kirim Ke Kepsek..!!</div>
                            </div>
                            <div class="px-5 pb-8 text-center"> <button type="submit" data-tw-dismiss="modal"
                                    class="btn btn-primary w-24">Ok</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- END: Modal Kirim Jadwal All Content -->

        <!-- BEGIN: Modal Excel-->

        <div id="excel-modal-preview" class="modal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- BEGIN: Modal Header -->
                    <div class="modal-header">
                        <h2 class="font-medium text-base mr-auto">Export Jadwal Mapel</h2>
                        <div class="dropdown sm:hidden"> <a class="dropdown-toggle w-5 h-5 block" href="javascript:;"
                                aria-expanded="false" data-tw-toggle="dropdown"> <i data-lucide="more-horizontal"
                                    class="w-5 h-5 text-slate-500"></i> </a>
                            <div class="dropdown-menu w-40">
                            </div>
                        </div>
                    </div> <!-- END: Modal Header -->
                    <!-- BEGIN: Modal Body -->

                    <form method="post" action="{{ route('jadal.mapels.excel') }}">
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
                        </div> <!-- END: Modal Body -->
                        <!-- BEGIN: Modal Footer -->
                        <div class="modal-footer">
                            <a href="{{ route('jadwalmapel.all') }}"
                                class="btn btn-outline-secondary w-20 mr-1">Cancel</a>
                            <button type="submit" class="btn btn-primary w-20">Export</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- BEGIN: Modal Excel -->

        <!-- BEGIN: Modal Kirim Jadwal Satuan-->
        @foreach ($jadwalmapel as $item)
            <div id="kirim-jadwalmapels-modal-{{ $item->id }}" class="modal" tabindex="-1"
                aria-hidden="true" aria-labelledby="kirim-jadwalmapels-modal-label-{{ $item->id }}">
                <div class="modal-dialog">

                    <form method="post" action="{{ route('jadwalmapelstatusone.update', $item->id) }}">
                        @csrf
                        <input type="hidden" value="1" name="status">
                        <div class="modal-content"> <a data-tw-dismiss="modal" href="javascript:;"> <i
                                    data-lucide="x" class="w-8 h-8 text-slate-400"></i> </a>
                            <div class="modal-body p-0">
                                <div class="p-5 text-center"> <i data-lucide="check-circle"
                                        class="w-16 h-16 text-success mx-auto mt-3"></i>
                                    <div class="text-3xl mt-5">Kirim Jadwal </div>
                                    <div class="text-slate-500 mt-2">Data Jadwal Mata Pelajaran Di Kirim Ke Kepsek..!!
                                    </div>
                                </div>
                                <div class="px-5 pb-8 text-center"> <button type="submit" data-tw-dismiss="modal"
                                        class="btn btn-primary w-24">Ok</button>

                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div> <!-- END: Modal Content -->
        @endforeach

        <!-- BEGIN: Modal Kirim Jadwal Satu-->





        <!-- Masukkan jQuery sebelum kode JavaScript Anda -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

        <!-- Kode JavaScript Anda -->
        <script type="text/javascript">
            $('#myAction').change(function() {
                var action = $(this).val();
                window.location = action;
            });
        </script>
        <script>
            $(document).ready(function() {
                $('#datatable1').DataTable();
            });
        </script>



        <!-- BEGIN: Modal Generate-->

        <div id="generate-modal-preview" class="modal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- BEGIN: Modal Header -->
                    <div class="modal-header">
                        <h2 class="font-medium text-base mr-auto">Generate Jadwal Mapel</h2>
                        <div class="dropdown sm:hidden"> <a class="dropdown-toggle w-5 h-5 block" href="javascript:;"
                                aria-expanded="false" data-tw-toggle="dropdown"> <i data-lucide="more-horizontal"
                                    class="w-5 h-5 text-slate-500"></i> </a>
                            <div class="dropdown-menu w-40">
                            </div>
                        </div>
                    </div> <!-- END: Modal Header -->
                    <!-- BEGIN: Modal Body -->

                    <form method="post" action="{{ route('jadwal.mapel.generate') }}">
                        @csrf
                        <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                            <div class="col-span-12 sm:col-span-6"> <label for="edit-jam">Pilih Hari </label>
                                <select name="id_kelas" class="form-select w-full" required>

                                    @foreach ($datakelas as $item)
                                        <option value="{{ $item->id }}">

                                            {{ $item->tingkat }}
                                            {{ $item->nama }}
                                            {{ $item->jurusans->nama }}

                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-span-12 sm:col-span-6"> <label for="edit-jam">Pilih Tahun Ajar </label>
                                <select name="id_tahunajar" id="tahun" class="form-select w-full" required>

                                    @foreach ($datatahunpengampu as $item)
                                        <option value="{{ $item->id }}">{{ $item->semester }} -
                                            {{ $item->tahun }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div> <!-- END: Modal Body -->
                        <!-- BEGIN: Modal Footer -->
                        <div class="modal-footer">
                            <a href="{{ route('jadwalmapel.all') }}"
                                class="btn btn-outline-secondary w-20 mr-1">Cancel</a>
                            <button type="submit" class="btn btn-primary w-20">Generate</button>
                    </form>
                </div>
            </div>
        </div>


    @endsection
