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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script> <!-- Include jQuery Validation plugin -->



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
                                PROSES JADWAL MAPEL </button> </li>
                    </ul>


                </div>

                <div class="mb-2 intro-y flex flex-col sm:flex-row items-center mt-4">

                    <form role="form" action="{{ route('jadwalmapel.kepsek') }}" method="get" class="sm:flex">
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

                            <a href="{{ route('jadwalmapel.kepsek') }}" class="btn btn-danger">Clear</a>

                        </div>
                    </form>
                </div>


                <div class="col-span-2 mb-2 mt-4">

                    <a class="btn btn-pending btn-block" data-tw-toggle="modal" data-tw-target="#excel-modal-preview">
                        <span class="glyphicon glyphicon-download"></span> <i data-lucide="download"
                            class="w-4 h-4"></i>&nbsp;Export

                    </a>

                    <a class="btn btn-primary btn-block" data-tw-toggle="modal" data-tw-target="#verifikasi-modal-preview">
                        <span class="glyphicon glyphicon-download"></span> <i data-lucide="check-circle"
                            class="w-4 h-4"></i>&nbsp;Verifikasi

                    </a>

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
        </div>
    </div>

    <div class="overflow-x-auto">
        <div class="tab-content mt-4">
            <div id="example-tab-5" class="tab-pane leading-relaxed active" role="tabpanel" aria-labelledby="example-5-tab">
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
                        @endphp
                        {{--  
                        // hari senin  --}}

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
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_guru }}
                                    </td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}</td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}</td>
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
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_guru }}
                                    </td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}</td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}</td>
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
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_guru }}
                                    </td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}</td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}</td>
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
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_guru }}
                                    </td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}</td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}</td>
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
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_guru }}
                                    </td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}</td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}</td>
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
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_guru }}
                                    </td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}</td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}</td>
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
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_guru }}
                                    </td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}</td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}</td>
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
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_guru }}
                                    </td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}</td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}</td>
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
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_guru }}
                                    </td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}</td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}</td>
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
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_guru }}
                                    </td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}</td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}</td>
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
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_guru }}
                                    </td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}</td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}</td>
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
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_guru }}
                                    </td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}</td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}</td>
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
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_guru }}
                                    </td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}</td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}</td>
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
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_guru }}
                                    </td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}</td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}</td>
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
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_guru }}
                                    </td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}</td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}</td>
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
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_guru }}
                                    </td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}</td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}</td>
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
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_guru }}
                                    </td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}</td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}</td>
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
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_guru }}
                                    </td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}</td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}</td>
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
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_guru }}
                                    </td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}</td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}</td>
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
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_guru }}
                                    </td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}</td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}</td>
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
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_guru }}
                                    </td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}</td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}</td>
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
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_guru }}
                                    </td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}</td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}</td>
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
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_guru }}
                                    </td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}</td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}</td>
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
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_guru }}
                                    </td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}</td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}</td>
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
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_guru }}
                                    </td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}</td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}</td>
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
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_guru }}
                                    </td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}</td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}</td>
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
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_guru }}
                                    </td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}</td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}</td>
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
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_guru }}
                                    </td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}</td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}</td>
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
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_guru }}
                                    </td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}</td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}</td>
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
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_guru }}
                                    </td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}</td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}</td>
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
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_guru }}
                                    </td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}</td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}</td>
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
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_guru }}
                                    </td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}</td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}</td>
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
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_guru }}
                                    </td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}</td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}</td>
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
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_guru }}
                                    </td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}</td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}</td>
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
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_guru }}
                                    </td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}</td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}</td>
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
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_guru }}
                                    </td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}</td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}</td>
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
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_guru }}
                                    </td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}</td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}</td>
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
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_guru }}
                                    </td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}</td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}</td>
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
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_guru }}
                                    </td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}</td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}</td>
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
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_guru }}
                                    </td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}</td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}</td>
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
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_guru }}
                                    </td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}</td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}</td>
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
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_guru }}
                                    </td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}</td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}</td>
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
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_guru }}
                                    </td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}</td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}</td>
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
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_guru }}
                                    </td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}</td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}</td>
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
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_guru }}
                                    </td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}</td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}</td>
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
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_guru }}
                                    </td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}</td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}</td>
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
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_guru }}
                                    </td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}</td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}</td>
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
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_guru }}
                                    </td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}</td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}</td>
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
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_guru }}
                                    </td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}</td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}</td>
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
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_guru }}
                                    </td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}</td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}</td>
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
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_guru }}
                                    </td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}</td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}</td>
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
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_guru }}
                                    </td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}</td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}</td>
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
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_guru }}
                                    </td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}</td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}</td>
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
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_guru }}
                                    </td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}</td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}</td>
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
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_guru }}
                                    </td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}</td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}</td>
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
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_guru }}
                                    </td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}</td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}</td>
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
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_guru }}
                                    </td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}</td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}</td>
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
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_guru }}
                                    </td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}</td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}</td>
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
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_guru }}
                                    </td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}</td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}</td>
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
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_guru }}
                                    </td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}</td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}</td>
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
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_guru }}
                                    </td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}</td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}</td>
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
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_guru }}
                                    </td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}</td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}</td>
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
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_guru }}
                                    </td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}</td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}</td>
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
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_guru }}
                                    </td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}</td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}</td>
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
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_guru }}
                                    </td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}</td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}</td>
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
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_guru }}
                                    </td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}</td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}</td>
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
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_guru }}
                                    </td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}</td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}</td>
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
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_guru }}
                                    </td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}</td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}</td>
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
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_guru }}
                                    </td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}</td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}</td>
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
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_guru }}
                                    </td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}</td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}</td>
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
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_guru }}
                                    </td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}</td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}</td>
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
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_guru }}
                                    </td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}</td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}</td>
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
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_guru }}
                                    </td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}</td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}</td>
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
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_guru }}
                                    </td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}</td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}</td>
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
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_guru }}
                                    </td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}</td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}</td>
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
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_guru }}
                                    </td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}</td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}</td>
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
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_guru }}
                                    </td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}</td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}</td>
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
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_guru }}
                                    </td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}</td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}</td>
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
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_guru }}
                                    </td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}</td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}</td>
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
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_guru }}
                                    </td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}</td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}</td>
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
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_guru }}
                                    </td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}</td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}</td>
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
                                            if ($time_within_range) {
                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                                            }
                                        @endphp
                                    @endforeach
                                    {{-- Display the kode guru --}}
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_guru }}
                                    </td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}</td>
                                    <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}</td>
                                @endforeach
                            </tr>
                        @endforeach



                    </tbody>
                </table>

            </div>
            <div id="example-tab-6" class="tab-pane leading-relaxed" role="tabpanel" aria-labelledby="example-6-tab">
                <table id="datatable" class="table table-sm"
                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                            <th style="white-space: nowrap;">No.</th>
                            <th style="white-space: nowrap;">Seksi</th>
                            <th style="white-space: nowrap;">Kode</th>
                            <th style="white-space: nowrap;">Hari</th>
                            <th style="white-space: nowrap;">Waktu</th>
                            <th style="white-space: nowrap;">Guru</th>
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
                                    {{ $key + 1 }}</td>
                                <td style="white-space: nowrap;" class="text-primary">
                                    {{ $item->kode_jadwalmapel }}
                                </td>
                                <td style="white-space: nowrap;" class="text-primary">
                                    {{ $item['pengampus']['kode_pengampu'] }}
                                </td>
                                <td> {{ $item['haris']['nama'] }}
                                </td>
                                <td> {{ $item->id_waktu }}
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
                                <td> {{ $mapelid->jp }} </td>
                                <td> {{ $item['ruangans']['kode_ruangan'] }}
                                </td>
                                <td style="white-space: nowrap;">
                                    {{ $item['tahun']['semester'] }}
                                    - {{ $item['tahun']['tahun'] }}
                                </td>

                                </td>
                                <td>
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
                                <td>

                                    @if ($item->status == '1')
                                        <a href="javascript:;" data-tw-toggle="modal"
                                            data-tw-target="#tolak-schedule-modal-{{ $item->id }}"
                                            class="btn btn-danger">
                                            <i data-lucide="x-circle" class="w-4 h-4"></i>
                                        </a>
                                        <a href="javascript:;" data-tw-toggle="modal"
                                            data-tw-target="#verifikasi-schedule-modal-{{ $item->id }}"
                                            class="btn btn-primary mt-1">
                                            <i data-lucide="check-circle" class="w-4 h-4"></i>
                                        </a>
                                    @endif

                                </td>


                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>


        <!-- BEGIN: Modal Verifikasi Jadwal All-->
        <div id="verifikasi-modal-preview" class="modal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <form method="post" action="{{ route('jadwalmapelverifikasiall.update') }}">
                    @csrf
                    <div class="modal-content"> <a data-tw-dismiss="modal" href="javascript:;"> <i data-lucide="x"
                                class="w-8 h-8 text-slate-400"></i> </a>
                        <div class="modal-body p-0">
                            <div class="p-5 text-center"> <i data-lucide="check-circle"
                                    class="w-16 h-16 text-success mx-auto mt-3"></i>
                                <div class="text-3xl mt-5">Verifikasi Jadwal Mapel </div>

                            </div>
                            <div class="px-5 pb-8 text-center"> <button type="submit" data-tw-dismiss="modal"
                                    class="btn btn-primary w-24">Ok</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- END: Modal Verifikasi Jadwal All Content -->



        <!-- BEGIN: Modal Verifikasi Jadwal Satuan-->
        @foreach ($jadwalmapel as $item)
            <div id="verifikasi-schedule-modal-{{ $item->id }}" class="modal" tabindex="-1" aria-hidden="true"
                aria-labelledby="verifikasi-schedule-modal-label-{{ $item->id }}">
                <div class="modal-dialog">

                    <form method="post" action="{{ route('jadwalmapelverifikasione.update', $item->id) }}">
                        @csrf
                        <input type="hidden" value="1" name="status">
                        <div class="modal-content"> <a data-tw-dismiss="modal" href="javascript:;"> <i data-lucide="x"
                                    class="w-8 h-8 text-slate-400"></i> </a>
                            <div class="modal-body p-0">
                                <div class="p-5 text-center"> <i data-lucide="check-circle"
                                        class="w-16 h-16 text-success mx-auto mt-3"></i>
                                    <div class="text-3xl mt-5">Verifikasi Jadwal Mapel </div>
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

        <!-- BEGIN: Modal Verifikasi Jadwal Satu-->



        <!-- BEGIN: Modal Tolak Jadwal Satuan-->
        @foreach ($jadwalmapel as $item)
            <div id="tolak-schedule-modal-{{ $item->id }}" class="modal" tabindex="-1" aria-hidden="true"
                aria-labelledby="tolak-schedule-modal-label-{{ $item->id }}">
                <div class="modal-dialog">

                    <form method="post" action="{{ route('jadwalmapeltolakone.update', $item->id) }}">
                        @csrf
                        <input type="hidden" value="1" name="status">
                        <div class="modal-content"> <a data-tw-dismiss="modal" href="javascript:;"> <i data-lucide="x"
                                    class="w-8 h-8 text-slate-400"></i> </a>
                            <div class="modal-body p-0">
                                <div class="p-5 text-center"> <i data-lucide="x-circle"
                                        class="w-16 h-16 text-danger mx-auto mt-3"></i>
                                    <div class="text-3xl mt-5">Tolak Jadwal Mapel </div>
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

        <!-- BEGIN: Modal Verifikasi Jadwal Satu-->




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

                    <form method="post" action="{{ route('jadal.mapels.kepsek') }}">
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
                            <a href="{{ route('jadwalmapel.kepsek') }}"
                                class="btn btn-outline-secondary w-20 mr-1">Cancel</a>
                            <button type="submit" class="btn btn-primary w-20">Export</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- BEGIN: Modal Excel -->


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
            document.addEventListener("DOMContentLoaded", function() {
                var table = $('#datatable1').DataTable(); // Inisialisasi DataTable
                $('#searchInput').on('keyup', function() {
                    table.search(this.value).draw();
                });

                // Hapus DataTable sebelum menginisialisasi kembali
                if ($.fn.DataTable.isDataTable('#datatable2')) {
                    $('#datatable2').DataTable().destroy();
                }

                // Menginisialisasi DataTable kembali dengan paginasi
                $('#datatable2').DataTable({
                    paging: true
                });
            });
        </script>
    @endsection
