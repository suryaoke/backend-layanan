<table id="datatable" class="table table-bordered">
    @php
        $dataseksi = $rombelsiswa->first();
        $phValues = App\Models\Nilai::select('ph')
            ->where('id_seksi', $id)
            ->where('type_nilai', 1)
            ->groupBy('ph')
            ->get();
        $phValuess = $phValues->count();

    @endphp
    <thead>
        <tr>
            <th colspan="{{ $phValuess * 2 + 5 }}"
                style="border: 2px solid black; text-align: center; font-weight: bold;">
                Data Nilai Pengetahuan Harian Siswa</th>
        </tr>
        <tr>
            <th colspan="{{ $phValuess * 2 + 5 }}"
                style="border: 2px solid black; text-align: center; font-weight: bold;">
                Semester
                {{ $tahun->semester }} Tahun Ajar {{ $tahun->tahun }} </th>
        </tr>
        <tr>
            <th style="width:40px; border: 2px solid black; text-align: center;">No</th>
            <th style="width:100px; border: 2px solid black; text-align: center;">NISN</th>
            <th style="width:100px; border: 2px solid black; text-align: center;">Nama</th>
            <th style="width:100px; border: 2px solid black; text-align: center;">Jk</th>
            <th style="width:100px; border: 2px solid black; text-align: center;">Kelas</th>

            @if ($phValuess > 0)
                @foreach ($phValues as $phItem)
                    <th style="width:100px; border: 2px solid black; text-align: center;">PH {{ $phItem->ph }}</th>
                    <th style="width:200px; border: 2px solid black; text-align: center;">Materi PH {{ $phItem->ph }}
                    </th>
                @endforeach
            @else
                <th style="width:100px; border: 2px solid black; text-align: center;">PH</th>
            @endif

        </tr>
    </thead>
    <tbody>
        @foreach ($rombelsiswa as $key => $item)
            <tr>
                <td style="width:40px; border: 2px solid black; text-align: center;">{{ $key + 1 }}</td>
                <td style="width:100px; border: 2px solid black; text-align: center;">{{ $item->siswas->nisn }}</td>
                <td style="width:100px; border: 2px solid black; text-align: center;">{{ $item->siswas->nama }}</td>
                <td style="width:100px; border: 2px solid black; text-align: center;">{{ $item->siswas->jk }}</td>
                <td style="width:100px; border: 2px solid black; text-align: center;">
                    {{ $item->rombels->kelass->tingkat }}
                    {{ $item->rombels->kelass->nama }}
                    {{ $item->rombels->kelass->jurusans->nama }}
                </td>

                @if ($phValuess > 0)
                    @foreach ($phValues as $phItem)
                        <td style="width:100px; border: 2px solid black; text-align: center;">
                            @php
                                $nilai = App\Models\Nilai::where('id_rombelsiswa', $item->id)
                                    ->where('type_nilai', 1)
                                    ->where('ph', $phItem->ph)
                                    ->first();
                            @endphp
                            @if ($nilai)
                                {{ $nilai->nilai_pengetahuan }}
                            @else
                                -
                            @endif
                        </td>
                        <td style="width:200px; border: 2px solid black; text-align: center;">
                            @php
                                $nilai1 = App\Models\Nilai::select('catatan_pengetahuan')
                                    ->where('id_rombelsiswa', $item->id)
                                    ->where('type_nilai', 1)
                                    ->where('ph', $phItem->ph)
                                    ->first();
                            @endphp
                            @if ($nilai1)
                                {{ $nilai1->catatan_pengetahuan }}
                            @else
                                -
                            @endif
                        </td>
                    @endforeach
                @else
                    <td style="width:100px; border: 2px solid black; text-align: center;">-</td>
                @endif


            </tr>
        @endforeach
    </tbody>
</table>
