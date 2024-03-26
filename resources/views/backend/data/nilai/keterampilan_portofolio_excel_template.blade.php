<table id="datatable" class="table table-bordered">

    <thead>

        <tr>
            <th style="width:40px; border: 2px solid black; text-align: center; center;background-color: yellow;">No</th>
            <th style="width:100px; border: 2px solid black; text-align: center; center;background-color: yellow;">Kode
                Siswa</th>
            <th style="width:100px; border: 2px solid black; text-align: center; center;background-color: yellow;">NISN
            </th>
            <th style="width:100px; border: 2px solid black; text-align: center; center;background-color: yellow;">Nama
            </th>
            <th style="width:100px; border: 2px solid black; text-align: center; center;background-color: yellow;">Jk
            </th>
            <th style="width:100px; border: 2px solid black; text-align: center; center;background-color: yellow;">Kelas
            </th>
            <th style="width:100px; border: 2px solid black; text-align: center; center;background-color: yellow;">Nilai
            </th>
            <th colspan="4"
                style="width:100px; border: 2px solid black; text-align: center; center;background-color: yellow;">
                Materi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($rombelsiswa as $key => $item)
            <tr>
                <td style="width:40px; border: 2px solid black; text-align: center;">{{ $key + 1 }}</td>
                <td style="width:100px; border: 2px solid black; text-align: center;">{{ $item->id }}</td>
                <td style="width:100px; border: 2px solid black; text-align: center;">{{ $item->siswas->nisn }}</td>
                <td style="width:100px; border: 2px solid black; text-align: center;">{{ $item->siswas->nama }}</td>
                <td style="width:100px; border: 2px solid black; text-align: center;">{{ $item->siswas->jk }}</td>
                <td style="width:100px; border: 2px solid black; text-align: center;">
                    {{ $item->rombels->kelass->tingkat }}
                    {{ $item->rombels->kelass->nama }}
                    {{ $item->rombels->kelass->jurusans->nama }}
                </td>


                <td style="width:100px; border: 2px solid black; text-align: center;">0</td>

                <td colspan="4" style="width:100px; border: 2px solid black; text-align: center;"></td>

            </tr>
        @endforeach
    </tbody>
</table>
