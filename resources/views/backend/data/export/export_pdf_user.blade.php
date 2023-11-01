<!DOCTYPE html>
<html>

<head>
    <title>Data User</title>
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

    <h3 style="text-align: center; margin-bottom: 11px; font-family: Calibri, sans-serif;">Data Akun User </h3>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Username</th>
                <th>Email</th>
                <th>Role</th>

            </tr>
        </thead>
        <tbody>

            @foreach ($user as $key => $item)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->username }}</td>
                    <td>{{ $item->email }} </td>
                    <td>

                        @if ($item->role == '1')
                            <span class="text-dark">Admin</span>
                        @elseif($item->role == '2')
                            <span class="text-danger">Kepala Sekolah</span>
                        @elseif($item->role == '3')
                            <span class="text-warning">Operator</span>
                        @elseif($item->role == '4')
                            <span class="text-success">Guru</span>
                        @elseif($item->role == '5')
                            <span class="text-primary">Orang Tua</span>
                        @elseif($item->role == '6')
                            <span class="text-primary">Siswa</span>
                        @endif
                    </td>
                </tr>
            @endforeach


        </tbody>
    </table>



</body>

</html>
