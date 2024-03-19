<table id="datatable" class="table table-bordered">
    <thead>
        <tr>
            <th colspan="6"
                style="text-align: center;width:100px  ; border: 2px solid black; text-align: center;font-weight: bold; ">
                Data Guru</th>

        </tr>

        <tr>
            <th style="text-align: center; font-weight: bold; width: 40px;">No</th>
            <th style="width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">Kode Guru</th>
            <th style="width:100px  ; border: 2px solid black; text-align: center;font-weight: bold;">Nama</th>
            <th style="width:100px  ; border: 2px solid black; text-align: center;font-weight: bold;">No HP</th>
            <th style="width:100px  ; border: 2px solid black; text-align: center;font-weight: bold;">Walas</th>
            <th style="width:100px  ; border: 2px solid black; text-align: center;font-weight: bold;">Username</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($guru as $key => $item)
            @php
                $user = App\Models\User::find($item->id_user);
                $walas = App\Models\Walas::where('id_guru', $item->id)->first();
            @endphp
            <tr>
                <td style="border: 2px solid black; text-align: center;">
                    {{ $key + 1 }}</td>
                <td style="width:100px  ; border: 2px solid black;  text-transform: capitalize;">
                    {{ $item->kode_gr }}</td>
                <td style="width:100px  ; border: 2px solid black; text-transform: capitalize;">
                    {{ $item->nama }}</td>
                <td style="width:100px  ; border: 2px solid black; ">{{ $item->no_hp }}</td>
                <td style="width:100px  ; border: 2px solid black;  text-transform: capitalize;">
                    @if ($walas)
                        {{ $walas->kelass->tingkat }}
                        {{ $walas->kelass->nama }}
                        {{ $walas->kelass->jurusans->nama }}
                    @else
                        <span class="text-danger">Kosong</span>
                    @endif
                </td>
                <td style="width:100px  ; border: 2px solid black;">
                    @if ($item->id_user == 0)
                        <span class="text-danger">Kosong</span>
                    @else
                        {{ $user->username }}
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
