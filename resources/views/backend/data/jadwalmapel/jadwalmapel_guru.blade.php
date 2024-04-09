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
    <h1 class="text-lg font-medium mb-4 mt-4">Jadwal Mata Pelajaran All</h1>

    <div class="mb-4 intro-y flex flex-col sm:flex-row items-center mt-4">

        <form role="form" action="{{ route('jadwalmapel.guru') }}" method="get" class="sm:flex">
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

                <a href="{{ route('jadwalmapel.guru') }}" class="btn btn-danger">Clear</a>

            </div>
        </form>
    </div>
    {{--  // End Bagian search //  --}}


    <div class="col-span-2 mb-2 mt-4">

        </a>


        <a class="btn btn-pending btn-block" data-tw-toggle="modal" data-tw-target="#excel-modal-preview">
            <span class="glyphicon glyphicon-download"></span> <i data-lucide="download" class="w-4 h-4"></i>&nbsp;Export

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
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="overflow-x-auto">

                        <table id="datatable1" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center " style="background-color: rgb(187,191,195)">Hari</th>
                                    <th
                                        class="text-center "style="background-color: rgb(187,191,195); white-space: nowrap;">
                                        Waktu
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
                                            <th colspan="3" class="text-center "
                                                style="background-color: rgb(187,191,195)">
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

                                {{--  // hari senin  --}}

                                @foreach ($hari->where('kode_hari', 'H01') as $key => $itemhari)
                                    <tr>

                                        <td rowspan="20" style="background-color: rgb(187,191,195)" class="text-center">
                                            {{ $itemhari->nama }}
                                        </td>

                                        <td style="white-space: nowrap;background-color: rgb(187,191,195)"
                                            class="text-center">
                                            07:00 - 08:00</td>
                                        <td colspan="{{ $j }}" class="text-center"
                                            style="background-color: yellow">
                                            UPACARA</td>
                                    </tr>

                                    <tr>
                                        <td style="white-space: nowrap;background-color: rgb(187,191,195)"
                                            class="text-center">
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
                                                        $desired_start_time >= $start_time &&
                                                        $desired_end_time <= $end_time;
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
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}
                                            </td>
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}
                                            </td>
                                        @endforeach
                                    </tr>


                                    <tr>
                                        <td style="white-space: nowrap;background-color: rgb(187,191,195)"
                                            class="text-center">
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
                                                        $desired_start_time >= $start_time &&
                                                        $desired_end_time <= $end_time;
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
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}
                                            </td>
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}
                                            </td>
                                        @endforeach
                                    </tr>

                                    <tr>
                                        <td style="white-space: nowrap;background-color: rgb(187,191,195)"
                                            class="text-center">
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
                                                        $desired_start_time >= $start_time &&
                                                        $desired_end_time <= $end_time;
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
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}
                                            </td>
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}
                                            </td>
                                        @endforeach
                                    </tr>

                                    <tr>
                                        <td style="white-space: nowrap;background-color: rgb(187,191,195)"
                                            class="text-center">
                                            10:00 - 10:20</td>

                                        <td colspan="{{ $j }}"
                                            class="text-center"style="background-color: yellow">
                                            ISTIRAHAT</td>
                                    </tr>

                                    <tr>
                                        <td style="white-space: nowrap;background-color: rgb(187,191,195)"
                                            class="text-center">
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
                                                        $desired_start_time >= $start_time &&
                                                        $desired_end_time <= $end_time;
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
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}
                                            </td>
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}
                                            </td>
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <td style="white-space: nowrap;background-color: rgb(187,191,195)"
                                            class="text-center">
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
                                                        $desired_start_time >= $start_time &&
                                                        $desired_end_time <= $end_time;
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
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}
                                            </td>
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}
                                            </td>
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <td style="white-space: nowrap;background-color: rgb(187,191,195)"
                                            class="text-center">
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
                                                        $desired_start_time >= $start_time &&
                                                        $desired_end_time <= $end_time;
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
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}
                                            </td>
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}
                                            </td>
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <td style="white-space: nowrap;background-color: rgb(187,191,195)"
                                            class="text-center">
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
                                                        $desired_start_time >= $start_time &&
                                                        $desired_end_time <= $end_time;
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
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}
                                            </td>
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}
                                            </td>
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <td style="white-space: nowrap;background-color: rgb(187,191,195)"
                                            class="text-center">
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
                                                        $desired_start_time >= $start_time &&
                                                        $desired_end_time <= $end_time;
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
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}
                                            </td>
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}
                                            </td>
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <td style="white-space: nowrap;background-color: rgb(187,191,195)"
                                            class="text-center">
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
                                                        $desired_start_time >= $start_time &&
                                                        $desired_end_time <= $end_time;
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
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}
                                            </td>
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}
                                            </td>
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <td style="white-space: nowrap;background-color: rgb(187,191,195)"
                                            class="text-center">
                                            12:20 - 13:00</td>

                                        <td colspan="{{ $j }}" class="text-center"
                                            style="background-color: yellow">
                                            ISTIRAHAT</td>
                                    </tr>
                                    <tr>
                                        <td style="white-space: nowrap;background-color: rgb(187,191,195)"
                                            class="text-center">
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
                                                        $desired_start_time >= $start_time &&
                                                        $desired_end_time <= $end_time;
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
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}
                                            </td>
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}
                                            </td>
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <td style="white-space: nowrap;background-color: rgb(187,191,195)"
                                            class="text-center">
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
                                                        $desired_start_time >= $start_time &&
                                                        $desired_end_time <= $end_time;
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
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}
                                            </td>
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}
                                            </td>
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <td style="white-space: nowrap;background-color: rgb(187,191,195)"
                                            class="text-center">
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
                                                        $desired_start_time >= $start_time &&
                                                        $desired_end_time <= $end_time;
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
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}
                                            </td>
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}
                                            </td>
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <td style="white-space: nowrap;background-color: rgb(187,191,195)"
                                            class="text-center">
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
                                                        $desired_start_time >= $start_time &&
                                                        $desired_end_time <= $end_time;
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
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}
                                            </td>
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}
                                            </td>
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <td style="white-space: nowrap;background-color: rgb(187,191,195)"
                                            class="text-center">
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
                                                        $desired_start_time >= $start_time &&
                                                        $desired_end_time <= $end_time;
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
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}
                                            </td>
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}
                                            </td>
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <td style="white-space: nowrap;background-color: rgb(187,191,195)"
                                            class="text-center">
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
                                                        $desired_start_time >= $start_time &&
                                                        $desired_end_time <= $end_time;
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
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}
                                            </td>
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}
                                            </td>
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <td style="white-space: nowrap;background-color: rgb(187,191,195)"
                                            class="text-center">
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
                                                        $desired_start_time >= $start_time &&
                                                        $desired_end_time <= $end_time;
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
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}
                                            </td>
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}
                                            </td>
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <td style="white-space: nowrap;background-color: rgb(187,191,195)"
                                            class="text-center">
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
                                                        $desired_start_time >= $start_time &&
                                                        $desired_end_time <= $end_time;
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
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}
                                            </td>
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach

                                {{--  // hari selasa //  --}}



                                @foreach ($hari->where('kode_hari', 'H02') as $key => $itemhari)
                                    <tr>
                                        <td rowspan="20" style="background-color: rgb(187,191,195)"
                                            class="text-center">
                                            {{ $itemhari->nama }}
                                        </td>
                                        <td style="white-space: nowrap;background-color: rgb(187,191,195)"
                                            class="text-center">
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
                                                        $desired_start_time >= $start_time &&
                                                        $desired_end_time <= $end_time;
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

                                        <td style="white-space: nowrap;background-color: rgb(187,191,195)"
                                            class="text-center">
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
                                                        $desired_start_time >= $start_time &&
                                                        $desired_end_time <= $end_time;
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

                                        <td style="white-space: nowrap;background-color: rgb(187,191,195)"
                                            class="text-center">
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
                                                        $desired_start_time >= $start_time &&
                                                        $desired_end_time <= $end_time;
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

                                        <td style="white-space: nowrap;background-color: rgb(187,191,195)"
                                            class="text-center">
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
                                                        $desired_start_time >= $start_time &&
                                                        $desired_end_time <= $end_time;
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

                                        <td style="white-space: nowrap;background-color: rgb(187,191,195)"
                                            class="text-center">
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
                                                        $desired_start_time >= $start_time &&
                                                        $desired_end_time <= $end_time;
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
                                        <td style="white-space: nowrap;background-color: rgb(187,191,195)"
                                            class="text-center">
                                            10:00 - 10:20</td>

                                        <td colspan="{{ $j }}"
                                            class="text-center"style="background-color: yellow">
                                            ISTIRAHAT</td>
                                    </tr>

                                    <tr>

                                        <td style="white-space: nowrap;background-color: rgb(187,191,195)"
                                            class="text-center">
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
                                                        $desired_start_time >= $start_time &&
                                                        $desired_end_time <= $end_time;
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

                                        <td style="white-space: nowrap;background-color: rgb(187,191,195)"
                                            class="text-center">
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
                                                        $desired_start_time >= $start_time &&
                                                        $desired_end_time <= $end_time;
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

                                        <td style="white-space: nowrap;background-color: rgb(187,191,195)"
                                            class="text-center">
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
                                                        $desired_start_time >= $start_time &&
                                                        $desired_end_time <= $end_time;
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

                                        <td style="white-space: nowrap;background-color: rgb(187,191,195)"
                                            class="text-center">
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
                                                        $desired_start_time >= $start_time &&
                                                        $desired_end_time <= $end_time;
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
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}
                                            </td>
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}
                                            </td>
                                        @endforeach
                                    </tr>

                                    <tr>

                                        <td style="white-space: nowrap;background-color: rgb(187,191,195)"
                                            class="text-center">
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
                                                        $desired_start_time >= $start_time &&
                                                        $desired_end_time <= $end_time;
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
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}
                                            </td>
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}
                                            </td>
                                        @endforeach
                                    </tr>
                                    <tr>

                                        <td style="white-space: nowrap;background-color: rgb(187,191,195)"
                                            class="text-center">
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
                                                        $desired_start_time >= $start_time &&
                                                        $desired_end_time <= $end_time;
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
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}
                                            </td>
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}
                                            </td>
                                        @endforeach
                                    </tr>


                                    <tr>
                                        <td style="white-space: nowrap;background-color: rgb(187,191,195)"
                                            class="text-center">
                                            12:20 - 13:00</td>

                                        <td colspan="{{ $j }}"
                                            class="text-center"style="background-color: yellow">
                                            ISTIRAHAT</td>
                                    </tr>

                                    <tr>

                                        <td style="white-space: nowrap;background-color: rgb(187,191,195)"
                                            class="text-center">
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
                                                        $desired_start_time >= $start_time &&
                                                        $desired_end_time <= $end_time;
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
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}
                                            </td>
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}
                                            </td>
                                        @endforeach
                                    </tr>

                                    <tr>

                                        <td style="white-space: nowrap;background-color: rgb(187,191,195)"
                                            class="text-center">
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
                                                        $desired_start_time >= $start_time &&
                                                        $desired_end_time <= $end_time;
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
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}
                                            </td>
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}
                                            </td>
                                        @endforeach
                                    </tr>

                                    <tr>

                                        <td style="white-space: nowrap;background-color: rgb(187,191,195)"
                                            class="text-center">
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
                                                        $desired_start_time >= $start_time &&
                                                        $desired_end_time <= $end_time;
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
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}
                                            </td>
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}
                                            </td>
                                        @endforeach
                                    </tr>

                                    <tr>

                                        <td style="white-space: nowrap;background-color: rgb(187,191,195)"
                                            class="text-center">
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
                                                        $desired_start_time >= $start_time &&
                                                        $desired_end_time <= $end_time;
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
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}
                                            </td>
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}
                                            </td>
                                        @endforeach
                                    </tr>

                                    <tr>

                                        <td style="white-space: nowrap;background-color: rgb(187,191,195)"
                                            class="text-center">
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
                                                        $desired_start_time >= $start_time &&
                                                        $desired_end_time <= $end_time;
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
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}
                                            </td>
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}
                                            </td>
                                        @endforeach
                                    </tr>
                                    <tr>

                                        <td style="white-space: nowrap;background-color: rgb(187,191,195)"
                                            class="text-center">
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
                                                        $desired_start_time >= $start_time &&
                                                        $desired_end_time <= $end_time;
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
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}
                                            </td>
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}
                                            </td>
                                        @endforeach
                                    </tr>
                                    <tr>

                                        <td style="white-space: nowrap;background-color: rgb(187,191,195)"
                                            class="text-center">
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
                                                        $desired_start_time >= $start_time &&
                                                        $desired_end_time <= $end_time;
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
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}
                                            </td>
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach



                                {{--  // hari rabu//  --}}



                                @foreach ($hari->where('kode_hari', 'H03') as $key => $itemhari)
                                    <tr>
                                        <td rowspan="18" style="background-color: rgb(187,191,195)"
                                            class="text-center">
                                            {{ $itemhari->nama }}
                                        </td>
                                        <td style="white-space: nowrap;background-color: rgb(187,191,195)"
                                            class="text-center">
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
                                                        $desired_start_time >= $start_time &&
                                                        $desired_end_time <= $end_time;
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
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}
                                            </td>
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}
                                            </td>
                                        @endforeach
                                    </tr>

                                    <tr>

                                        <td style="white-space: nowrap;background-color: rgb(187,191,195)"
                                            class="text-center">
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
                                                        $desired_start_time >= $start_time &&
                                                        $desired_end_time <= $end_time;
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
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}
                                            </td>
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}
                                            </td>
                                        @endforeach
                                    </tr>

                                    <tr>

                                        <td style="white-space: nowrap;background-color: rgb(187,191,195)"
                                            class="text-center">
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
                                                        $desired_start_time >= $start_time &&
                                                        $desired_end_time <= $end_time;
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
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}
                                            </td>
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}
                                            </td>
                                        @endforeach
                                    </tr>


                                    <tr>

                                        <td style="white-space: nowrap;background-color: rgb(187,191,195)"
                                            class="text-center">
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
                                                        $desired_start_time >= $start_time &&
                                                        $desired_end_time <= $end_time;
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
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}
                                            </td>
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}
                                            </td>
                                        @endforeach
                                    </tr>

                                    <tr>

                                        <td style="white-space: nowrap;background-color: rgb(187,191,195)"
                                            class="text-center">
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
                                                        $desired_start_time >= $start_time &&
                                                        $desired_end_time <= $end_time;
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
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}
                                            </td>
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}
                                            </td>
                                        @endforeach
                                    </tr>

                                    <tr>
                                        <td style="white-space: nowrap;background-color: rgb(187,191,195)"
                                            class="text-center">
                                            10:00 - 10:20</td>

                                        <td colspan="{{ $j }}"
                                            class="text-center"style="background-color: yellow">
                                            ISTIRAHAT</td>
                                    </tr>

                                    <tr>

                                        <td style="white-space: nowrap;background-color: rgb(187,191,195)"
                                            class="text-center">
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
                                                        $desired_start_time >= $start_time &&
                                                        $desired_end_time <= $end_time;
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
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}
                                            </td>
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}
                                            </td>
                                        @endforeach
                                    </tr>

                                    <tr>

                                        <td style="white-space: nowrap;background-color: rgb(187,191,195)"
                                            class="text-center">
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
                                                        $desired_start_time >= $start_time &&
                                                        $desired_end_time <= $end_time;
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
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}
                                            </td>
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}
                                            </td>
                                        @endforeach
                                    </tr>

                                    <tr>

                                        <td style="white-space: nowrap;background-color: rgb(187,191,195)"
                                            class="text-center">
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
                                                        $desired_start_time >= $start_time &&
                                                        $desired_end_time <= $end_time;
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
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}
                                            </td>
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}
                                            </td>
                                        @endforeach
                                    </tr>
                                    <tr>

                                        <td style="white-space: nowrap;background-color: rgb(187,191,195)"
                                            class="text-center">
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
                                                        $desired_start_time >= $start_time &&
                                                        $desired_end_time <= $end_time;
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
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}
                                            </td>
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}
                                            </td>
                                        @endforeach
                                    </tr>

                                    <tr>

                                        <td style="white-space: nowrap;background-color: rgb(187,191,195)"
                                            class="text-center">
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
                                                        $desired_start_time >= $start_time &&
                                                        $desired_end_time <= $end_time;
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
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}
                                            </td>
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}
                                            </td>
                                        @endforeach
                                    </tr>
                                    <tr>

                                        <td style="white-space: nowrap;background-color: rgb(187,191,195)"
                                            class="text-center">
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
                                                        $desired_start_time >= $start_time &&
                                                        $desired_end_time <= $end_time;
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
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}
                                            </td>
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}
                                            </td>
                                        @endforeach
                                    </tr>


                                    <tr>
                                        <td style="white-space: nowrap;background-color: rgb(187,191,195)"
                                            class="text-center">
                                            12:20 - 13:00</td>

                                        <td colspan="{{ $j }}"
                                            class="text-center"style="background-color: yellow">
                                            ISTIRAHAT</td>
                                    </tr>

                                    <tr>

                                        <td style="white-space: nowrap;background-color: rgb(187,191,195)"
                                            class="text-center">
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
                                                        $desired_start_time >= $start_time &&
                                                        $desired_end_time <= $end_time;
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
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}
                                            </td>
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}
                                            </td>
                                        @endforeach
                                    </tr>

                                    <tr>

                                        <td style="white-space: nowrap;background-color: rgb(187,191,195)"
                                            class="text-center">
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
                                                        $desired_start_time >= $start_time &&
                                                        $desired_end_time <= $end_time;
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
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}
                                            </td>
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}
                                            </td>
                                        @endforeach
                                    </tr>

                                    <tr>

                                        <td style="white-space: nowrap;background-color: rgb(187,191,195)"
                                            class="text-center">
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
                                                        $desired_start_time >= $start_time &&
                                                        $desired_end_time <= $end_time;
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
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}
                                            </td>
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}
                                            </td>
                                        @endforeach
                                    </tr>

                                    <tr>

                                        <td style="white-space: nowrap;background-color: rgb(187,191,195)"
                                            class="text-center">
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
                                                        $desired_start_time >= $start_time &&
                                                        $desired_end_time <= $end_time;
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
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}
                                            </td>
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}
                                            </td>
                                        @endforeach
                                    </tr>

                                    <tr>

                                        <td style="white-space: nowrap;background-color: rgb(187,191,195)"
                                            class="text-center">
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
                                                        $desired_start_time >= $start_time &&
                                                        $desired_end_time <= $end_time;
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
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}
                                            </td>
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach


                                {{--  // Kamis //  --}}

                                @foreach ($hari->where('kode_hari', 'H04') as $key => $itemhari)
                                    <tr>
                                        <td rowspan="18" style="background-color: rgb(187,191,195)"
                                            class="text-center">
                                            {{ $itemhari->nama }}
                                        </td>
                                        <td style="white-space: nowrap;background-color: rgb(187,191,195)"
                                            class="text-center">
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
                                                        $desired_start_time >= $start_time &&
                                                        $desired_end_time <= $end_time;
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
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}
                                            </td>
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}
                                            </td>
                                        @endforeach
                                    </tr>

                                    <tr>

                                        <td style="white-space: nowrap;background-color: rgb(187,191,195)"
                                            class="text-center">
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
                                                        $desired_start_time >= $start_time &&
                                                        $desired_end_time <= $end_time;
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
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}
                                            </td>
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}
                                            </td>
                                        @endforeach
                                    </tr>

                                    <tr>

                                        <td style="white-space: nowrap;background-color: rgb(187,191,195)"
                                            class="text-center">
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
                                                        $desired_start_time >= $start_time &&
                                                        $desired_end_time <= $end_time;
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
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}
                                            </td>
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}
                                            </td>
                                        @endforeach
                                    </tr>


                                    <tr>

                                        <td style="white-space: nowrap;background-color: rgb(187,191,195)"
                                            class="text-center">
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
                                                        $desired_start_time >= $start_time &&
                                                        $desired_end_time <= $end_time;
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
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}
                                            </td>
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}
                                            </td>
                                        @endforeach
                                    </tr>

                                    <tr>

                                        <td style="white-space: nowrap;background-color: rgb(187,191,195)"
                                            class="text-center">
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
                                                        $desired_start_time >= $start_time &&
                                                        $desired_end_time <= $end_time;
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
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}
                                            </td>
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}
                                            </td>
                                        @endforeach
                                    </tr>

                                    <tr>
                                        <td style="white-space: nowrap;background-color: rgb(187,191,195)"
                                            class="text-center">
                                            10:00 - 10:20</td>

                                        <td colspan="{{ $j }}"
                                            class="text-center"style="background-color: yellow">
                                            ISTIRAHAT</td>
                                    </tr>

                                    <tr>

                                        <td style="white-space: nowrap;background-color: rgb(187,191,195)"
                                            class="text-center">
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
                                                        $desired_start_time >= $start_time &&
                                                        $desired_end_time <= $end_time;
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
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}
                                            </td>
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}
                                            </td>
                                        @endforeach
                                    </tr>

                                    <tr>

                                        <td style="white-space: nowrap;background-color: rgb(187,191,195)"
                                            class="text-center">
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
                                                        $desired_start_time >= $start_time &&
                                                        $desired_end_time <= $end_time;
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
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}
                                            </td>
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}
                                            </td>
                                        @endforeach
                                    </tr>

                                    <tr>

                                        <td style="white-space: nowrap;background-color: rgb(187,191,195)"
                                            class="text-center">
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
                                                        $desired_start_time >= $start_time &&
                                                        $desired_end_time <= $end_time;
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
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}
                                            </td>
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}
                                            </td>
                                        @endforeach
                                    </tr>
                                    <tr>

                                        <td style="white-space: nowrap;background-color: rgb(187,191,195)"
                                            class="text-center">
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
                                                        $desired_start_time >= $start_time &&
                                                        $desired_end_time <= $end_time;
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
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}
                                            </td>
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}
                                            </td>
                                        @endforeach
                                    </tr>

                                    <tr>

                                        <td style="white-space: nowrap;background-color: rgb(187,191,195)"
                                            class="text-center">
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
                                                        $desired_start_time >= $start_time &&
                                                        $desired_end_time <= $end_time;
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
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}
                                            </td>
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}
                                            </td>
                                        @endforeach
                                    </tr>
                                    <tr>

                                        <td style="white-space: nowrap;background-color: rgb(187,191,195)"
                                            class="text-center">
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
                                                        $desired_start_time >= $start_time &&
                                                        $desired_end_time <= $end_time;
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
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}
                                            </td>
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}
                                            </td>
                                        @endforeach
                                    </tr>


                                    <tr>
                                        <td style="white-space: nowrap;background-color: rgb(187,191,195)"
                                            class="text-center">
                                            12:20 - 13:00</td>

                                        <td colspan="{{ $j }}"
                                            class="text-center"style="background-color: yellow">
                                            ISTIRAHAT</td>
                                    </tr>

                                    <tr>

                                        <td style="white-space: nowrap;background-color: rgb(187,191,195)"
                                            class="text-center">
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
                                                        $desired_start_time >= $start_time &&
                                                        $desired_end_time <= $end_time;
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
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}
                                            </td>
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}
                                            </td>
                                        @endforeach
                                    </tr>

                                    <tr>

                                        <td style="white-space: nowrap;background-color: rgb(187,191,195)"
                                            class="text-center">
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
                                                        $desired_start_time >= $start_time &&
                                                        $desired_end_time <= $end_time;
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
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}
                                            </td>
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}
                                            </td>
                                        @endforeach
                                    </tr>

                                    <tr>

                                        <td style="white-space: nowrap;background-color: rgb(187,191,195)"
                                            class="text-center">
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
                                                        $desired_start_time >= $start_time &&
                                                        $desired_end_time <= $end_time;
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
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}
                                            </td>
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}
                                            </td>
                                        @endforeach
                                    </tr>

                                    <tr>

                                        <td style="white-space: nowrap;background-color: rgb(187,191,195)"
                                            class="text-center">
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
                                                        $desired_start_time >= $start_time &&
                                                        $desired_end_time <= $end_time;
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
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}
                                            </td>
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}
                                            </td>
                                        @endforeach
                                    </tr>

                                    <tr>

                                        <td style="white-space: nowrap;background-color: rgb(187,191,195)"
                                            class="text-center">
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
                                                        $desired_start_time >= $start_time &&
                                                        $desired_end_time <= $end_time;
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
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}
                                            </td>
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach



                                {{--  // jumat //  --}}

                                @foreach ($hari->where('kode_hari', 'H05') as $key => $itemhari)
                                    <tr>

                                        <td rowspan="18" style="background-color: rgb(187,191,195)"
                                            class="text-center">
                                            {{ $itemhari->nama }}
                                        </td>

                                        <td style="white-space: nowrap;background-color: rgb(187,191,195)"
                                            class="text-center">
                                            07:00 - 08:00</td>
                                        <td colspan="{{ $j }}" class="text-center"
                                            style="background-color: yellow">
                                            KULTUM</td>
                                    </tr>
                                    <tr>
                                        <td style="white-space: nowrap;background-color: rgb(187,191,195)"
                                            class="text-center">
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
                                                        $desired_start_time >= $start_time &&
                                                        $desired_end_time <= $end_time;
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
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}
                                            </td>
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}
                                            </td>
                                        @endforeach
                                    </tr>

                                    <tr>
                                        <td style="white-space: nowrap;background-color: rgb(187,191,195)"
                                            class="text-center">
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
                                                        $desired_start_time >= $start_time &&
                                                        $desired_end_time <= $end_time;
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
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}
                                            </td>
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}
                                            </td>
                                        @endforeach
                                    </tr>

                                    <tr>
                                        <td style="white-space: nowrap;background-color: rgb(187,191,195)"
                                            class="text-center">
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
                                                        $desired_start_time >= $start_time &&
                                                        $desired_end_time <= $end_time;
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
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}
                                            </td>
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}
                                            </td>
                                        @endforeach
                                    </tr>

                                    <tr>
                                        <td style="white-space: nowrap;background-color: rgb(187,191,195)"
                                            class="text-center">
                                            10:00 - 10:20</td>

                                        <td colspan="{{ $j }}"
                                            class="text-center"style="background-color: yellow">
                                            ISTIRAHAT</td>
                                    </tr>

                                    <tr>
                                        <td style="white-space: nowrap;background-color: rgb(187,191,195)"
                                            class="text-center">
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
                                                        $desired_start_time >= $start_time &&
                                                        $desired_end_time <= $end_time;
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
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}
                                            </td>
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}
                                            </td>
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <td style="white-space: nowrap;background-color: rgb(187,191,195)"
                                            class="text-center">
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
                                                        $desired_start_time >= $start_time &&
                                                        $desired_end_time <= $end_time;
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
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}
                                            </td>
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}
                                            </td>
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <td style="white-space: nowrap;background-color: rgb(187,191,195)"
                                            class="text-center">
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
                                                        $desired_start_time >= $start_time &&
                                                        $desired_end_time <= $end_time;
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
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}
                                            </td>
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}
                                            </td>
                                        @endforeach
                                    </tr>

                                    </tr>
                                    <tr>
                                        <td style="white-space: nowrap;background-color: rgb(187,191,195)"
                                            class="text-center">
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
                                                        $desired_start_time >= $start_time &&
                                                        $desired_end_time <= $end_time;
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
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}
                                            </td>
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}
                                            </td>
                                        @endforeach
                                    </tr>

                                    <tr>
                                        <td style="white-space: nowrap;background-color: rgb(187,191,195)"
                                            class="text-center">
                                            11:40 - 13:20</td>

                                        <td colspan="{{ $j }}" class="text-center"
                                            style="background-color: yellow">
                                            ISTIRAHAT</td>
                                    </tr>
                                    <tr>
                                        <td style="white-space: nowrap;background-color: rgb(187,191,195)"
                                            class="text-center">
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
                                                        $desired_start_time >= $start_time &&
                                                        $desired_end_time <= $end_time;
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
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}
                                            </td>
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}
                                            </td>
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <td style="white-space: nowrap;background-color: rgb(187,191,195)"
                                            class="text-center">
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
                                                        $desired_start_time >= $start_time &&
                                                        $desired_end_time <= $end_time;
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
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}
                                            </td>
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}
                                            </td>
                                        @endforeach
                                    </tr>

                                    <tr>
                                        <td style="white-space: nowrap;background-color: rgb(187,191,195)"
                                            class="text-center">
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
                                                        $desired_start_time >= $start_time &&
                                                        $desired_end_time <= $end_time;
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
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}
                                            </td>
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}
                                            </td>
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <td style="white-space: nowrap;background-color: rgb(187,191,195)"
                                            class="text-center">
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
                                                        $desired_start_time >= $start_time &&
                                                        $desired_end_time <= $end_time;
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
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}
                                            </td>
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}
                                            </td>
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <td style="white-space: nowrap;background-color: rgb(187,191,195)"
                                            class="text-center">
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
                                                        $desired_start_time >= $start_time &&
                                                        $desired_end_time <= $end_time;
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
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}
                                            </td>
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}
                                            </td>
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <td style="white-space: nowrap;background-color: rgb(187,191,195)"
                                            class="text-center">
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
                                                        $desired_start_time >= $start_time &&
                                                        $desired_end_time <= $end_time;
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
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}
                                            </td>
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}
                                            </td>
                                        @endforeach
                                    </tr>

                                    <tr>
                                        <td style="white-space: nowrap;background-color: rgb(187,191,195)"
                                            class="text-center">
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
                                                        $desired_start_time >= $start_time &&
                                                        $desired_end_time <= $end_time;
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
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}
                                            </td>
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}
                                            </td>
                                        @endforeach
                                    </tr>

                                    <tr>
                                        <td style="white-space: nowrap;background-color: rgb(187,191,195)"
                                            class="text-center">
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
                                                        $desired_start_time >= $start_time &&
                                                        $desired_end_time <= $end_time;
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
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_mapel }}
                                            </td>
                                            <td style="white-space: nowrap;" class="text-center">{{ $kode_ruangan }}
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach



                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

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

                <form method="post" action="{{ route('jadwalmapels.guru.excel') }}">
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
                        <a href="{{ route('jadwalmapel.guru') }}" class="btn btn-outline-secondary w-20 mr-1">Cancel</a>
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
@endsection
