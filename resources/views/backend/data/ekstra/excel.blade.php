<table id="datatable" class="table table-bordered">
    <thead>
         <tr>
            <th colspan="6" style="border: 2px solid black; text-align: center; font-weight: bold;">
                Data Ekstrakulikuler Siswa</th>
        </tr>
        <tr>
            <th colspan="6" style="border: 2px solid black; text-align: center; font-weight: bold;">Semester
                {{ $tahun->semester }} Tahun Ajar {{ $tahun->tahun }} </th>
        </tr>
        <tr>
            <th style="width:100px  ; border: 2px solid black; text-align: center;">No</th>
            <th style="width:100px  ; border: 2px solid black; text-align: center;">NISN</th>
            <th style="width:100px  ; border: 2px solid black; text-align: center;">Nama</th>
            <th style="width:100px  ; border: 2px solid black; text-align: center;">Kelas</th>
            <th style="width:100px  ; border: 2px solid black; text-align: center;">Ekstrakulikuler</th>
            <th style="width:100px  ; border: 2px solid black; text-align: center;">Nilai</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($cttnwalas as $key => $item)
            <tr>
                <td style="width:100px  ; border: 2px solid black; text-align: center;">{{ $key + 1 }}</td>
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
                <td style="width:350px  ; border: 2px solid black; text-align: center;">
                    @if ($item->ekstra == null)
                        -
                    @else
                        {{ $item->ekstra }}
                    @endif
                </td>
                <td style="width:350px  ; border: 2px solid black; text-align: center;">

                    {{ $item->nilai_ekstra }}

                </td>

            </tr>
        @endforeach
    </tbody>
</table>
