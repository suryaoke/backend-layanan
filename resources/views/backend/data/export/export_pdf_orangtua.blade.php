<!DOCTYPE html>
<html>

<head>
    <title>Data Orang Tua</title>
    <style>
        table {
            border-collapse: collapse;
            border: 1px solid black;
            width: 100%;
        }

        th,
        td {
            border: 1px solid black;
            padding: 10px;
            text-align: center;
        }
    </style>
    @php
        $time = Carbon\Carbon::now();
    @endphp
</head>

<body>
    {{ $time }}

    <h3 style="text-align: center; margin-bottom: 11px; font-family: Calibri, sans-serif;">Data Orang Tua </h3>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Orangtua</th>
                <th>Nama</th>
                <th>No Hp</th>
                <th>Username</th>
                <th>Siswa</th>
            </tr>
        </thead>
        <tbody>

            @foreach ($orangtua as $key => $item)
                <tr>
                    <td>{{ $key + 1 }}</td>
                     <td>{{ $item->kode_ortu }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->no_hp }}</td>
                    <td>{{ isset($item->users) && isset($item->users->username) ? $item->users->username : '' }}</td>
                    <td>
                      {{ isset($item->siswas) && isset($item->siswas->nama) ? $item->siswas->nama : '' }}
                    </td>
                </tr>
            @endforeach


        </tbody>
    </table>



</body>

</html>
