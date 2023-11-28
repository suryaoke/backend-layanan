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
    <h3 style="text-align: center; margin-bottom: 11px; font-family: Calibri, sans-serif;">Jadwal Mata Pelajaran
    </h3>
    <p>{{ $time }}</p>

    <table>
        <thead>
            <tr>
                
                <th style="white-space: nowrap;">Seksi</th>
                <th style="white-space: nowrap;">Kode</th>
                <th style="white-space: nowrap;">Hari</th>
                <th style="white-space: nowrap;">Waktu</th>
                <th style="white-space: nowrap;">Guru</th>
                <th style="white-space: nowrap;">Mapel</th>
                <th style="white-space: nowrap;">Kelas</th>
                <th style="white-space: nowrap;">JP</th>
                <th style="white-space: nowrap;">Ruang</th>
                <th style="white-space: nowrap;">Semester</th>
            </tr>
        </thead>
        <tbody>

            @foreach ($jadwalmapel as $item)
                @php
                    $pengampuid = App\Models\Pengampu::find($item->id_pengampu);
                    $mapelid = App\Models\Mapel::find($pengampuid->id_mapel);
                    $guruid = App\Models\Guru::find($pengampuid->id_guru);
                    $kelas = App\Models\Kelas::find($pengampuid->kelas);
                @endphp

                <tr>
                 
                    <td class="text-primary">
                        {{ $item->kode_jadwalmapel }}
                    </td>
                    <td class="text-primary">
                        {{ $item->pengampus->kode_pengampu }} </td>
                    <td> {{ $item->haris->nama }} </td>
                    <td> {{ $item->waktus->range }} </td>
                    <td> {{ $guruid->nama }} </td>
                    <td> {{ $mapelid->nama }} </td>
                    <td> {{ $kelas->tingkat }} {{ $kelas->nama }}
                        {{ $kelas->jurusans->nama }}
                    </td>
                    <td> {{ $mapelid->jp }} </td>
                    <td> {{ $item->ruangans->kode_ruangan }} </td>
                    <td>
                        {{ $mapelid->tahunajars->semester }}-
                        {{ $mapelid->tahunajars->tahun }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
