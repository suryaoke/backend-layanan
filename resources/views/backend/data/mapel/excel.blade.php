<table id="datatable" class="table table-bordered">
    <thead>
        <tr>
            <th colspan="8"
                style="text-align: center;width:100px  ; border: 2px solid black; text-align: center;font-weight: bold; ">
                Data Mata Pelajaran</th>

        </tr>
        <tr>
            <th style="width:40px  ; border: 2px solid black; text-align: center; font-weight: bold;">No</th>
            <th style="width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">Kode Mapel</th>
            <th style="width:100px  ; border: 2px solid black; text-align: center;font-weight: bold;">Induk</th>
            <th style="width:200px  ; border: 2px solid black; text-align: center;font-weight: bold;">Nama</th>
            <th style="width:100px  ; border: 2px solid black; text-align: center;font-weight: bold;">JP</th>
            <th style="width:100px  ; border: 2px solid black; text-align: center;font-weight: bold;">Jurusan</th>
            <th style="width:100px  ; border: 2px solid black; text-align: center;font-weight: bold;">Kelompok</th>
            <th style="width:100px  ; border: 2px solid black; text-align: center;font-weight: bold;">Type</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($mapel as $key => $item)
            <tr>
                <td style="width:40px  ; border: 2px solid black; text-align: center;"> {{ $key + 1 }} </td>
                <td style="width:100px  ; border: 2px solid black; text-align: center;">{{ $item->kode_mapel }}</td>
                <td style="width:100px  ; border: 2px solid black; text-align: center;">
                    @if ($item->induk === null)
                        -
                    @else
                        {{ $item->induk }}
                    @endif
                </td>
                <td style="width:200px  ; border: 2px solid black; ">{{ $item->nama }}</td>
                <td style="width:100px  ; border: 2px solid black; text-align: center;">{{ $item->jp }}</td>
                <td style="width:100px  ; border: 2px solid black; text-align: center;">
                    @if (isset($item['jurusans']['nama']))
                        {{ $item['jurusans']['nama'] }}
                    @endif
                </td>
                <td style="width:100px  ; border: 2px solid black; text-align: center;">Kelompok {{ $item->jenis }}
                </td>
                <td style="width:100px  ; border: 2px solid black; text-align: center;">{{ $item->type }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
