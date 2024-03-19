@foreach ($rombelsiswa as $key => $item)
    @php

        $data = App\Models\Rombel::where('id', $item->id_rombel)->first();
    @endphp
@endforeach


<table id="datatable" class="table table-bordered">
    <thead>
        <tr>
            <th colspan="5" style="border: 2px solid black; text-align: center; font-weight: bold;">
                Data Rombongan Belajar</th>
        </tr>
        <tr>
            <th colspan="5" style="border: 2px solid black; text-align: center; font-weight: bold;">Semester
                {{ $data->tahuns->semester }} Tahun Ajar {{ $data->tahuns->tahun }} </th>
        </tr>
        <tr>
            <th colspan="5" style="   border: 2px solid black; text-align: center; font-weight: bold;">Wali Kelas :
                {{ $data->walass->gurus->nama }} </th>
        </tr>
        <tr>

            <th style="width:40px  ; border: 2px solid black; text-align: center;font-weight: bold;">No</th>
            <th style="width:100px  ; border: 2px solid black; text-align: center;font-weight: bold;">Nama</th>
            <th style="width:100px  ; border: 2px solid black; text-align: center;font-weight: bold;">Nisn</th>
            <th style="width:100px  ; border: 2px solid black; text-align: center;font-weight: bold;">Jk</th>
            <th style="width:100px  ; border: 2px solid black; text-align: center;font-weight: bold;">Kelas</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($rombelsiswa as $key => $item)
            <tr>

                <td style="width:40px  ; border: 2px solid black; text-align: center;"> {{ $key + 1 }} </td>
                <td style="width:100px  ; border: 2px solid black; text-align: center;">
                    {{ $item->siswas->nama }}
                </td>
                <td style="width:100px  ; border: 2px solid black; text-align: center;">
                    {{ $item->siswas->nisn }}
                </td>
                <td style="width:100px  ; border: 2px solid black; text-align: center;">
                    {{ $item->siswas->jk }}
                </td>
                <td style="width:100px  ; border: 2px solid black; text-align: center;">
                    {{ $item->rombels->kelass->tingkat }}
                    {{ $item->rombels->kelass->nama }}
                    {{ $item->rombels->kelass->jurusans->nama }}

                </td>
            </tr>
        @endforeach


    </tbody>
</table>
