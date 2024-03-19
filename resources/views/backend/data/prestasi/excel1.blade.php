<table id="datatable" class="table table-bordered">
    <thead>
        <tr>
            <th style="width:100px; border: 2px solid black; text-align: center; background-color: yellow;">No</th>
            <th style="width:100px; border: 2px solid black; text-align: center; background-color: yellow;">Kode Prestasi
            </th>
            <th style="width:100px; border: 2px solid black; text-align: center; background-color: yellow;">NISN</th>
            <th style="width:100px; border: 2px solid black; text-align: center; background-color: yellow;">Nama</th>
            <th style="width:100px; border: 2px solid black; text-align: center; background-color: yellow;">Kelas</th>
            <th style="width:100px; border: 2px solid black; text-align: center; background-color: yellow;">Prestasi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($cttnwalas as $key => $item)
            <tr>
                <td style="width:100px; border: 2px solid black; text-align: center;">{{ $key + 1 }}</td>
                <td style="width:100px; border: 2px solid black; text-align: center;">{{ $item->id }}</td>
                <td style="width:100px; border: 2px solid black; text-align: center;">
                    {{ $item->rombelsiswas->siswas->nisn }}</td>
                <td style="width:100px; border: 2px solid black; text-align: center;">
                    {{ $item->rombelsiswas->siswas->nama }}</td>
                <td style="width:100px; border: 2px solid black; text-align: center;">
                    {{ $item->rombelsiswas->rombels->kelass->tingkat }}
                    {{ $item->rombelsiswas->rombels->kelass->nama }}
                    {{ $item->rombelsiswas->rombels->kelass->jurusans->nama }}
                </td>
                <td style="width:100px; border: 2px solid black; text-align: center;">
                    @if ($item->prestasi == null)
                        -
                    @else
                        {{ $item->prestasi }}
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
