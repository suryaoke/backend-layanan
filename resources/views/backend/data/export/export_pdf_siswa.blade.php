<!DOCTYPE html>
<html>

<head>
    <title>Data Siswa</title>
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

    <h3 style="text-align: center; margin-bottom: 11px; font-family: Calibri, sans-serif;">Data Siswa </h3>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Nisn</th>
                <th>Jk</th>
                <th>Username</th>

            </tr>
        </thead>
        <tbody>

            @foreach ($siswa as $key => $item)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->nisn }}</td>
                    <td>{{ $item->jk }}</td>
                    <td>{{ isset($item->users) && isset($item->users->username) ? $item->users->username : '' }}</td>

                </tr>
            @endforeach


        </tbody>
    </table>



</body>

</html>
