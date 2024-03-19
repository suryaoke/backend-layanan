<!DOCTYPE html>
<html>

<head>
    <title>Jadwal Mata Pelajaran</title>
    <style>
        table {
            border-collapse: collapse;
            border: 1px solid black;
            width: 100%;
            table-layout: fixed;
        }

        th,
        td {
            border: 1px solid black;
            padding: 10px;
            text-align: center;
            word-wrap: break-word;
        }
    </style>
    @php
        use Carbon\Carbon;
        $time = Carbon::now();
    @endphp
</head>

<body>
    <h3 style="text-align: center; margin-bottom: 11px; font-family: Calibri, sans-serif;">JADWAL MATA PELAJARAN
    </h3>
    <h3 style="text-align: center; margin-bottom: 11px; font-family: Calibri, sans-serif;">MAN 1 Kota Padang
    </h3>
    <h3 style="text-align: center; margin-bottom: 11px; font-family: Calibri, sans-serif;" >Tahun Pelajaran {{$datajadwal->tahun->tahun}} Semester {{$datajadwal->tahun->semester}}
    </h3>


    <table id="datatable1" class="table table-bordered mt-4">
        <thead>
            <tr>
                <th class="btn-secondary" style="width:100px  ; border: 2px solid black; text-align: center;">Hari</th>
                <th class="btn-secondary" style="width:100px  ; border: 2px solid black; text-align: center;">Waktu</th>
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
                    <th colspan="3" class="btn-secondary"
                        style="width:100px  ; border: 2px solid black; text-align: center;">
                        {{ $tingkat->tingkat }} {{ $tingkat->nama }}
                        {{ $tingkat['jurusans']['nama'] }}
                    </th>
                @endforeach
            </tr>
            <tr>
                <th class="btn-secondary" style="width:100px  ; border: 2px solid black;"></th>
                <th class="btn-secondary" style="width:100px  ; border: 2px solid black;"></th>
                @foreach ($kelasGroups as $kelas => $jadwalByClass)
                    <th style="white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center;"
                        class="btn-primary">
                        Kode Guru</th>
                    <th style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center;"
                        class="btn-primary">
                        Kode Mapel</th>
                    <th style="white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center;"
                        class="btn-primary">
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
                                <td style="width:100px  ; border: 2px solid black;" rowspan="{{ $harijumlah }}"
                                    class="btn-secondary">
                                    {{ $haridata->nama }}
                                </td>
                            @endif
                            <td style="width:100px  ; border: 2px solid black;" class="bg-warning">
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
                                            $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                            $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;

                                        @endphp
                                        {{-- Break the inner loop --}}
                                    @break
                                @endif
                            @endforeach
                            {{-- Display the kode guru --}}
                            <td style="width:100px  ; border: 2px solid black;">{{ $kode_guru }}
                            </td>
                            <td style="width:100px  ; border: 2px solid black;">{{ $kode_mapel }}</td>
                            <td style="width:100px  ; border: 2px solid black;">{{ $kode_ruangan }}</td>
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

</body>

</html>
