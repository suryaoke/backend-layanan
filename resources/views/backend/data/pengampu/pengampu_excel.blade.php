<table id="datatable" class="table table-bordered">
    <thead>
        <tr>
            <th colspan="7"
                style="text-align: center;width:100px  ; border: 2px solid black; text-align: center;font-weight: bold; ">
                Data Pengampu Mata Pelajaran</th>

        </tr>
        <tr>
            <th style="width:40px  ; border: 2px solid black; text-align: center; font-weight: bold;">No</th>
            <th style="width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">Kode Pengampu</th>
            <th style="width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">Nama Guru</th>
            <th style="width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">Kode Guru</th>
            <th style="width:200px  ; border: 2px solid black; text-align: center; font-weight: bold;">Mata Pelajaran
            </th>
            <th style="width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">Kode Mapel</th>
            <th style="width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">Kelas</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($pengampu as $key => $item)
            <tr>
                <td style="width:40px  ; border: 2px solid black; text-align: center;"> {{ $key + 1 }} </td>
                <td style="width:100px  ; border: 2px solid black; text-align: center;">{{ $item->kode_pengampu }}</td>
                <td style="width:100px  ; border: 2px solid black; text-align: center;">{{ $item->gurus->nama }}</td>
                <td style="width:100px  ; border: 2px solid black; text-align: center;">{{ $item->gurus->kode_gr }}</td>
                <td style="width:200px  ; border: 2px solid black; text-align: center;">{{ $item->mapels->nama }}</td>
                <td style="width:100px  ; border: 2px solid black; text-align: center;">{{ $item->mapels->kode_mapel }}
                </td>
                <td style="width:100px  ; border: 2px solid black; text-align: center;">
                    {{ $item->kelass->tingkat }}
                    {{ $item->kelass->nama }}
                    {{ $item->kelass->jurusans->nama }}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
