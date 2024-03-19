<table id="datatable" class="table table-bordered">
    <thead>
        <tr>
            <th style="width:100px  ; border: 2px solid black; text-align: center; background-color: yellow;">No</th>
            <th style="width:100px  ; border: 2px solid black; text-align: center; background-color: yellow;">Kode
                Presensi</th>
            <th style="width:100px  ; border: 2px solid black; text-align: center; background-color: yellow;">NISN</th>
            <th style="width:100px  ; border: 2px solid black; text-align: center; background-color: yellow;">Nama</th>
            <th style="width:100px  ; border: 2px solid black; text-align: center; background-color: yellow;">Kelas</th>
            <th style="width:100px  ; border: 2px solid black; text-align: center; background-color: yellow;">Alfa</th>
            <th style="width:100px  ; border: 2px solid black; text-align: center; background-color: yellow;">Sakit</th>
            <th style="width:100px  ; border: 2px solid black; text-align: center;background-color: yellow;">Izin</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($cttnwalas as $key => $item)
            <tr>
                <td style="width:100px  ; border: 2px solid black; text-align: center;">{{ $key + 1 }}</td>
                <td style="width:100px  ; border: 2px solid black; text-align: center;">
                    {{ $item->id }}
                </td>

                <td style="width:100px  ; border: 2px solid black; text-align: center;">
                    {{ $item->rombelsiswas->siswas->nisn }}
                </td>
                <td style="width:100px  ; border: 2px solid black; text-align: center;">
                    {{ $item->rombelsiswas->siswas->nama }}
                </td>
                <td style="width:100px  ; border: 2px solid black; text-align: center;">
                    {{ $item->rombelsiswas->rombels->kelass->tingkat }}
                    {{ $item->rombelsiswas->rombels->kelass->nama }}
                    {{ $item->rombelsiswas->rombels->kelass->jurusans->nama }}
                </td>
                <td style="width:100px  ; border: 2px solid black; text-align: center;">
                    @if ($item->alfa == null)
                        -
                    @else
                        {{ $item->alfa }}
                    @endif
                </td>
                <td style="width:100px  ; border: 2px solid black; text-align: center;">
                    @if ($item->sakit == null)
                        -
                    @else
                        {{ $item->sakit }}
                    @endif
                </td>
                <td style="width:100px  ; border: 2px solid black; text-align: center;">
                    @if ($item->izin == null)
                        -
                    @else
                        {{ $item->izin }}
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
