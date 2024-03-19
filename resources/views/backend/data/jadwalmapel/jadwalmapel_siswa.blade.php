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

        <form role="form" action="{{ route('jadwalmapel.siswa') }}" method="get" class="sm:flex">
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

                <a href="{{ route('jadwalmapel.siswa') }}" class="btn btn-danger">Clear</a>

            </div>
        </form>
    </div>
    {{--  // End Bagian search //  --}}


    <div class="col-span-2 mb-4 mt-4">


        <a class="btn btn-pending btn-block" data-tw-toggle="modal" data-tw-target="#pdf-modal-preview">
            <span class="glyphicon glyphicon-download"></span> <i data-lucide="printer" class="w-4 h-4"></i>&nbsp;Cetak

        </a>

    </div>

    <div class="mb-4 mt-4">
        Semester {{ $jadwal['tahun']['semester'] }}
        Tahun Ajar {{ $jadwal['tahun']['tahun'] }}
    </div>
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="overflow-x-auto">
                        <table id="datatable" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center "style="background-color: rgb(187,191,195)">Hari</th>
                                    <th class="text-center "style="background-color: rgb(187,191,195)">Waktu</th>
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
                                    @foreach ($kelasGroups as $kelas => $jadwalByClass)
                                        @php
                                            $tingkat = App\Models\Kelas::where('id', $kelas)->first();
                                        @endphp
                                        <th colspan="3" class="text-center "style="background-color: rgb(187,191,195)">
                                            {{ $tingkat->tingkat }} {{ $tingkat->nama }}
                                            {{ $tingkat['jurusans']['nama'] }}
                                        </th>
                                    @endforeach
                                </tr>
                                <tr>
                                    <th class="text-center "style="background-color: rgb(187,191,195)"></th>
                                    <th class="text-center "style="background-color: rgb(187,191,195)"></th>
                                    @foreach ($kelasGroups as $kelas => $jadwalByClass)
                                        <th style="white-space: nowrap;" class="btn-primary">
                                            Kode Guru</th>
                                        <th style=" white-space: nowrap;" class="btn-primary">
                                            Kode Mapel</th>
                                        <th style="white-space: nowrap;" class="btn-primary">
                                            Ruangan</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>

                                @php
                                    $hariGroups = collect();
                                @endphp
                                @foreach ($jadwalmapel as $key => $jadwal)
                                    @php
                                        // Mengelompokkan data berdasarkan hari

                                        $hari1 = $jadwal->id_hari;
                                        if (!$hariGroups->has($hari1)) {
                                            $hariGroups->put($hari1, collect());
                                        }
                                        $hariGroups[$hari1]->push($jadwal);

                                    @endphp
                                @endforeach
                                @foreach ($hariGroups as $hari1 => $jadwalByDay)
                                    @php
                                        $haridata = App\Models\Hari::find($hari1);
                                        $harijumlah = count($jadwalByDay);
                                        $printedTimeSlots = []; // Initialize array to keep track of printed time slots
                                        $uniqueTimes = $jadwalByDay->unique('id_waktu');
                                        $harijumlah = count($uniqueTimes);
                                    @endphp
                                    @foreach ($jadwalByDay as $index => $jadwal)
                                        @php
                                            $timeSlot = $jadwal->waktus->range; // Get the time slot
                                        @endphp
                                        {{-- Check if the time slot has been printed already --}}
                                        @if (!in_array($timeSlot, $printedTimeSlots))
                                            <tr>
                                                @if ($index === 0)
                                                    <td rowspan="{{ $harijumlah }}"
                                                        style="background-color: rgb(187,191,195)">
                                                        {{ $haridata->nama }}
                                                    </td>
                                                @endif
                                                <td style="white-space: nowrap;" class="bg-warning">
                                                    {{ $timeSlot }}
                                                </td>
                                                {{-- Loop through kelasGroups to display kode guru for each class --}}
                                                @foreach ($kelasGroups as $kelas => $jadwalByClass)
                                                    @php
                                                        $kode_guru = ''; // Initialize kode guru as empty string
                                                        $kode_mapel = ''; // Initialize kode mapel as empty string
                                                        $kode_ruangan = ''; // Initialize kode ruangan as empty string
                                                    @endphp
                                                    @foreach ($jadwalByClass as $jadwalKelas)
                                                        {{-- Check if the jadwal belongs to the current iteration's class and time slot --}}
                                                        @if ($jadwalKelas->waktus->range === $timeSlot && $jadwalKelas->id_hari === $jadwal->id_hari)
                                                            {{-- Assign the kode guru if the jadwal belongs to the current iteration's class and time slot --}}
                                                            @php
                                                                $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                                $kode_mapel =
                                                                    $jadwalKelas->pengampus->mapels->kode_mapel;
                                                                $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;

                                                            @endphp
                                                            {{-- Break the inner loop --}}
                                                        @break
                                                    @endif
                                                @endforeach
                                                {{-- Display the kode guru --}}
                                                <td>{{ $kode_guru }}
                                                </td>
                                                <td>{{ $kode_mapel }}</td>
                                                <td>{{ $kode_ruangan }}</td>
                                            @endforeach
                                        </tr>
                                        {{-- Add the printed time slot to the printedTimeSlots array --}}
                                        @php
                                            $printedTimeSlots[] = $timeSlot;
                                        @endphp
                                    @endif
                                @endforeach
                            @endforeach

                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>


<!-- BEGIN: Modal Excel-->

<div id="pdf-modal-preview" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- BEGIN: Modal Header -->
            <div class="modal-header">
                <h2 class="font-medium text-base mr-auto">Cetak Jadwal Mapel</h2>
                <div class="dropdown sm:hidden"> <a class="dropdown-toggle w-5 h-5 block" href="javascript:;"
                        aria-expanded="false" data-tw-toggle="dropdown"> <i data-lucide="more-horizontal"
                            class="w-5 h-5 text-slate-500"></i> </a>
                    <div class="dropdown-menu w-40">
                    </div>
                </div>
            </div> <!-- END: Modal Header -->
            <!-- BEGIN: Modal Body -->

            <form method="post" action="{{ route('jadwalsiswa.pdf') }}">
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
                    <a href="{{ route('jadwalmapel.siswa') }}" class="btn btn-outline-secondary w-20 mr-1">Cancel</a>
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
