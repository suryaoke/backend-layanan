<!DOCTYPE html>
<html>

<head>
    <title>Nilai Harian Siswa</title>
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

    <h3 style="text-align: center; margin-bottom: 11px; font-family: Calibri, sans-serif;">Data Nilai Harian Siswa</h3>
    <h4 style=" margin-bottom: 11px; font-family: Calibri, sans-serif;">KI-3 Pengetahuan</h4>


    <table>
        <thead>
            <tr>
                <th class="whitespace-nowrap">No</th>

                <th class="whitespace-nowrap">Nama
                </th>
                <th class="whitespace-nowrap">NISN</th>
                <th class="whitespace-nowrap">Mapel
                </th>
                <th class="whitespace-nowrap">Kelas
                </th>


                @php
                    $printedPhValues = [];
                @endphp

                @foreach ($nilaiSiswaKd3 as $key => $item)
                    @php
                        $nilaikd = App\Models\NilaiKd3::find($item->id_nilaikd3);
                    @endphp

                    @if ($nilaikd && !in_array($nilaikd->ph, $printedPhValues))
                        <th class="whitespace-nowrap">
                            PH
                            {{ $nilaikd->ph }}
                        </th>
                        @php
                            $printedPhValues[] = $nilaikd->ph;
                        @endphp
                    @endif
                @endforeach

            </tr>
        </thead>
        <tbody>
            @php
                $index = 1;
                $checkedData = [];
            @endphp
            @foreach ($nilaiSiswaKd3 as $key => $item)
                @php
                    $idRombelsiswa = $item['id_rombelsiswa'];
                    $idSeksi = $item->nilaikd3->id_seksi;

                    // Check if the combination of id_rombelsiswa and id_seksi has been checked before
                    $isDuplicate = false;
                    foreach ($checkedData as $data) {
                        if ($data['id_rombelsiswa'] == $idRombelsiswa && $data['id_seksi'] == $idSeksi) {
                            $isDuplicate = true;
                            break;
                        }
                    }
                    // If the combination is a duplicate, continue to the next iteration
                    if ($isDuplicate) {
                        continue;
                    }
                    // If the combination is not a duplicate, add it to the checkedData
                    $checkedData[] = ['id_rombelsiswa' => $idRombelsiswa, 'id_seksi' => $idSeksi];
                @endphp

                <tr>
                    <td>
                        {{ $index }} </td>

                    <td>
                        {{ $item['rombelsiswa']['siswas']['nama'] }}
                    </td>
                    <td>
                        {{ $item['rombelsiswa']['siswas']['nisn'] }}
                    </td>
                    <td>
                        {{ $item['nilaikd3']['seksis']['jadwalmapels']['pengampus']['mapels']['nama'] }}
                    </td>
                    <td>
                        {{ $item['nilaikd3']['seksis']['jadwalmapels']['pengampus']['kelass']['tingkat'] }}
                        {{ $item['nilaikd3']['seksis']['jadwalmapels']['pengampus']['kelass']['nama'] }}
                        {{ $item['nilaikd3']['seksis']['jadwalmapels']['pengampus']['kelass']['jurusans']['nama'] }}
                    </td>

                    @foreach ($printedPhValues as $phValue)
                        <td>
                            @foreach ($nilaiSiswaKd3 as $nilai)
                                @if (
                                    $nilai->nilaikd3->ph == $phValue &&
                                        $nilai['id_rombelsiswa'] == $idRombelsiswa &&
                                        $nilai->nilaikd3->id_seksi == $idSeksi)
                                    @if ($nilai->status == 'remedial' && $nilai->remedial == null)
                                        <div style="color: red;">
                                            {{ $nilai->nilai }}
                                        </div>
                                    @elseif($nilai->status == 'remedial' && $nilai->remedial != null)
                                        {{ $nilai->remedial }}
                                    @elseif($nilai->status == 'lulus')
                                        {{ $nilai->nilai }}
                                    @endif
                                @endif
                            @endforeach
                        </td>
                    @endforeach
                    @php
                        $index++; // Increment index setelah setiap iterasi
                    @endphp
                </tr>
            @endforeach


        </tbody>
    </table>

    <h4 style=" margin-bottom: 11px; font-family: Calibri, sans-serif;">KI-4 Keterampilan</h4>


    <table>
        <thead>
            <tr>
                <th class="whitespace-nowrap">No</th>

                <th class="whitespace-nowrap">Nama
                </th>
                <th class="whitespace-nowrap">NISN</th>
                <th class="whitespace-nowrap">Mapel
                </th>
                <th class="whitespace-nowrap">Kelas
                </th>
                @php
                    $printedPhValues = [];
                @endphp

                @foreach ($nilaiSiswaKd4 as $key => $item)
                    @php
                        $nilaikd = App\Models\NilaiKd4::find($item->id_nilaikd4);
                    @endphp

                    @if ($nilaikd && !in_array($nilaikd->ph, $printedPhValues))
                        <th class="whitespace-nowrap">
                            PH {{ $nilaikd->ph }}
                        </th>
                        @php
                            $printedPhValues[] = $nilaikd->ph;
                        @endphp
                    @endif
                @endforeach

            </tr>
        </thead>
        <tbody>
            @php
                $index = 1;
                $checkedData = [];
            @endphp
            @foreach ($nilaiSiswaKd4 as $key => $item)
                @php
                    $idRombelsiswa = $item['id_rombelsiswa'];
                    $idSeksi = $item->nilaikd4->id_seksi;

                    // Check if the combination of id_rombelsiswa and id_seksi has been checked before
                    $isDuplicate = false;
                    foreach ($checkedData as $data) {
                        if ($data['id_rombelsiswa'] == $idRombelsiswa && $data['id_seksi'] == $idSeksi) {
                            $isDuplicate = true;
                            break;
                        }
                    }
                    // If the combination is a duplicate, continue to the next iteration
                    if ($isDuplicate) {
                        continue;
                    }
                    // If the combination is not a duplicate, add it to the checkedData
                    $checkedData[] = ['id_rombelsiswa' => $idRombelsiswa, 'id_seksi' => $idSeksi];
                @endphp

                <tr>
                    <td class="whitespace-nowrap">
                        {{ $index }} </td>

                    <td class="whitespace-nowrap">
                        {{ $item['rombelsiswa']['siswas']['nama'] }}
                    </td>
                    <td class="whitespace-nowrap">
                        {{ $item['rombelsiswa']['siswas']['nisn'] }}
                    </td>
                    <td class="whitespace-nowrap">
                        {{ $item['nilaikd4']['seksis']['jadwalmapels']['pengampus']['mapels']['nama'] }}
                    </td>
                    <td class="whitespace-nowrap">
                        {{ $item['nilaikd4']['seksis']['jadwalmapels']['pengampus']['kelass']['tingkat'] }}
                        {{ $item['nilaikd4']['seksis']['jadwalmapels']['pengampus']['kelass']['nama'] }}
                        {{ $item['nilaikd4']['seksis']['jadwalmapels']['pengampus']['kelass']['jurusans']['nama'] }}
                    </td>

                    @foreach ($printedPhValues as $phValue)
                        <td class="whitespace-nowrap">
                            @foreach ($nilaiSiswaKd4 as $nilai)
                                @if (
                                    $nilai->nilaikd4->ph == $phValue &&
                                        $nilai['id_rombelsiswa'] == $idRombelsiswa &&
                                        $nilai->nilaikd4->id_seksi == $idSeksi)
                                    @if ($nilai->status == 'remedial' && $nilai->remedial == null)
                                        <div style="color: red;">
                                            {{ $nilai->nilai }}
                                        </div>
                                    @elseif($nilai->status == 'remedial' && $nilai->remedial != null)
                                        {{ $nilai->remedial }}
                                    @elseif($nilai->status == 'lulus')
                                        {{ $nilai->nilai }}
                                    @endif
                                @endif
                            @endforeach
                        </td>
                    @endforeach
                    @php
                        $index++; // Increment index setelah setiap iterasi
                    @endphp
                </tr>
            @endforeach

        </tbody>
    </table>

</body>

</html>
