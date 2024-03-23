    <table id="datatable" class="table table-bordered">
        <thead>
            <tr>
                <th class="whitespace-nowrap">No</th>
                <th class="whitespace-nowrap">NISN</th>
                <th class="whitespace-nowrap">Nama</th>
                <th class="whitespace-nowrap">Jk</th>
                <th class="whitespace-nowrap">Kelas</th>
                @php
                    $kdValues = App\Models\Nilai::select('kd')
                        ->where('id_seksi', $id)
                        ->where('type_nilai', 3)
                        ->where('type_keterampilan', 2)
                        ->groupBy('kd')
                        ->get();
                @endphp
                @if ($kdValues->count() > 0)
                    @foreach ($kdValues as $kdItem)
                        <th class="whitespace-nowrap">KD {{ $kdItem->kd }}

                        </th>
                    @endforeach
                @else
                    <th class="whitespace-nowrap">KD</th>
                @endif

            </tr>
        </thead>
        <tbody>

            @foreach ($rombelsiswa as $key => $item)
                <tr>
                    <td class="whitespace-nowrap">{{ $key + 1 }}</td>
                    <td class="whitespace-nowrap">{{ $item->siswas->nisn }}</td>
                    <td class="whitespace-nowrap">{{ $item->siswas->nama }}</td>
                    <td class="whitespace-nowrap">{{ $item->siswas->jk }}</td>
                    <td class="whitespace-nowrap">
                        {{ $item->rombels->kelass->tingkat }}
                        {{ $item->rombels->kelass->nama }}
                        {{ $item->rombels->kelass->jurusans->nama }}
                    </td>

                    @if ($kdValues->count() > 0)
                        @foreach ($kdValues as $kdItem)
                            <td class="whitespace-nowrap">
                                @php
                                    $nilai = App\Models\Nilai::where('id_rombelsiswa', $item->id)
                                        ->where('type_nilai', 3)
                                        ->where('type_keterampilan', 2)
                                        ->where('kd', $kdItem->kd)
                                        ->where('id_seksi', $id)
                                        ->first();
                                @endphp
                                @if ($nilai)
                                    {{ $nilai->nilai_keterampilan }}
                                @else
                                    -
                                @endif
                            </td>
                        @endforeach
                    @else
                        <td class="whitespace-nowrap">-</td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
