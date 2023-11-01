<!DOCTYPE html>
<html>

<head>
    <title>Data Absensi Siswa</title>
    <style>
        table {
            border-collapse: collapse;
            border: 1px solid black;
            width: 100%;
        }

        th,
        td {
            border: 1px solid black;
            padding: 10px;
            text-align: center;
        }
    </style>
    @php
        $time = Carbon\Carbon::now();
    @endphp
</head>

<body>
    {{ $time }}

    <h3 style="text-align: center; margin-bottom: 11px; font-family: Calibri, sans-serif;">Data Absensi Siswa </h3>
    <h4 style=" margin-bottom: 11px; font-family: Calibri, sans-serif;">Rekap Absensi</h4>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>NISN</th>
                <th>Kelas</th>
                <th>Jk</th>
                <th>Kode Mapel</th>
                <th>Mapel</th>
                <th>Hadir</th>
                <th>Sakit</th>
                <th>Izin</th>
                <th>Alfa</th>
            </tr>
        </thead>
        <tbody>

            @php
                $uniqueCombination = [];
            @endphp
            @foreach ($absensi as $key => $item)
                @php
                    $currentCombination = $item->id_siswa . '-' . $item->id_jadwal;
                @endphp

                @if (!in_array($currentCombination, $uniqueCombination))
                    @php
                        array_push($uniqueCombination, $currentCombination);

                        $absensialfa = App\Models\Absensi::where('id_siswa', $item->id_siswa)
                            ->where('id_jadwal', $item->id_jadwal)
                            ->where('status', 0)
                            ->count();
                        $absensisakit = App\Models\Absensi::where('id_siswa', $item->id_siswa)
                            ->where('id_jadwal', $item->id_jadwal)
                            ->where('status', 3)
                            ->count();
                        $absensiizin = App\Models\Absensi::where('id_siswa', $item->id_siswa)
                            ->where('id_jadwal', $item->id_jadwal)
                            ->where('status', 2)
                            ->count();
                        $absensihadir = App\Models\Absensi::where('id_siswa', $item->id_siswa)
                            ->where('id_jadwal', $item->id_jadwal)
                            ->where('status', 1)
                            ->count();
                        $jadwal = App\Models\Jadwalmapel::where('id', $item->id_jadwal)->first();
                        $pengampu = App\Models\Pengampu::where('id', $jadwal->id_pengampu)->first();
                        $mapel = App\Models\Mapel::where('id', $pengampu->id_mapel)->first();

                        $rombelsiswa = App\Models\Rombelsiswa::where('id_siswa', $item->id_siswa)->first();
                        $rombel = App\Models\Rombel::where('id', $rombelsiswa->id_rombel)->first();
                        $kelas = App\Models\Kelas::where('id', $rombel->id_kelas)->first();

                    @endphp

                    <tr>
                        <td>{{ $key + 1 }}
                        </td>
                        <td>{{ $item->siswass->nama }}
                        </td>
                        <td>{{ $item->siswass->nisn }}
                        </td>
                        <td> {{ $kelas->tingkat }}{{ $kelas->nama }}
                            {{ $kelas['jurusans']['nama'] }}
                        </td>
                        <td>{{ $item->siswass->jk }}
                        </td>
                        <td> {{ $mapel->kode_mapel }}
                        </td>
                        <td> {{ $mapel->nama }}
                        </td>
                        <td class="text-success">
                            {{ $absensihadir }}
                        </td>
                        <td class="text-warning">
                            {{ $absensisakit }}
                        </td>
                        <td class="text-primary">
                            {{ $absensiizin }}
                        </td>
                        <td class="text-danger">
                            {{ $absensialfa }}
                        </td>

                    </tr>
                @endif
            @endforeach

        </tbody>
    </table>


    <h4 style=" margin-bottom: 11px; font-family: Calibri, sans-serif;">Harian Absensi</h4>

    <table>
        <thead>
            <tr>
                <th class="whitespace-nowrap">No</th>
                <th class="whitespace-nowrap">Nama</th>
                <th class="whitespace-nowrap">NISN</th>
                <th class="whitespace-nowrap">Kelas</th>
                <th class="whitespace-nowrap">Tanggal</th>
                <th class="whitespace-nowrap">Kode Mapel</th>
                <th class="whitespace-nowrap">Mapel</th>
                <th class="whitespace-nowrap">Status</th>
                <th class="whitespace-nowrap">Ket</th>
            </tr>
        </thead>
        <tbody>


            @foreach ($absensi as $key => $item)
                <tr>
                    @php
                        $jadwal = App\Models\Jadwalmapel::where('id', $item->id_jadwal)->first();
                        $pengampu = App\Models\Pengampu::where('id', $jadwal->id_pengampu)->first();
                        $mapel = App\Models\Mapel::where('id', $pengampu->id_mapel)->first();
                        $seksi = App\Models\Seksi::where('id', $item->id_jadwal)->first();
                        $rombelsiswa = App\Models\Rombelsiswa::where('id_siswa', $item->id_siswa)->first();
                        $rombel = App\Models\Rombel::where('id', $rombelsiswa->id_rombel)->first();
                        // $kelas = App\Models\Kelas::where('id', $rombel->id_kelas)->first();
                    @endphp
                    <td> {{ $key + 1 }} </td>
                    @if ($item['siswass'] != null)
                        <td>{{ $item['siswass']['nama'] }}</td>
                        <td>{{ $item['siswass']['nisn'] }}</td>
                        <td>{{ $rombel['kelass']['tingkat'] }}
                            {{ $rombel['kelass']['nama'] }}
                            {{ $rombel['kelass']['jurusans']['nama'] }}
                        </td>
                    @else
                        <td></td>
                        <td></td>
                        <td></td>
                    @endif

                    <td>{{ $item->tanggal }}</td>
                    <td> {{ $mapel->kode_mapel }}</td>
                    <td> {{ $mapel->nama }}</td>
                    <td>

                        @if ($item->status == '0')
                            <span class="text-danger">
                                Alfa</span>
                        @elseif($item->status == '1')
                            <span class="text-success">
                                Hadir</span>
                        @elseif($item->status == '2')
                            <span class="text-primary">
                                Izin</span>
                        @elseif($item->status == '3')
                            <span class="text-warning">
                                Sakit</span @endif
                    </td>
                    <td>
                        @if ($item->ket == null)
                            -
                        @else
                            {{ $item->ket }}
                        @endif

                    </td>
                </tr>
            @endforeach


        </tbody>
    </table>



</body>

</html>
