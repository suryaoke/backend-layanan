<!DOCTYPE html>
<html>

<head>
    <title>Data Guru</title>
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

    <h3 style="text-align: center; margin-bottom: 11px; font-family: Calibri, sans-serif;">Data Guru </h3>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Kode Guru</th>
                <th>No Hp</th>
                <th>Username</th>
                <th>Walas</th>
            </tr>
        </thead>
        <tbody>

            @foreach ($guru as $key => $item)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->kode_gr }}</td>
                    <td>{{ $item->no_hp }}</td>
                    <td>{{ isset($item->users) && isset($item->users->username) ? $item->users->username : '' }}</td>
                    <td>
                        @if (isset($item->walass) &&
                                isset($item->walass->kelass) &&
                                isset($item->walass->kelass->tingkat) &&
                                isset($item->walass->kelass->nama) &&
                                isset($item->walass->kelass->jurusans) &&
                                isset($item->walass->kelass->jurusans->nama))
                            {{ $item->walass->kelass->tingkat }} {{ $item->walass->kelass->nama }}
                            {{ $item->walass->kelass->jurusans->nama }}
                        @endif
                    </td>
                </tr>
            @endforeach


        </tbody>
    </table>



</body>

</html>
