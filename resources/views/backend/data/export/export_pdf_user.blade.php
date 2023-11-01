<!DOCTYPE html>
<html>

<head>
    <title>Jadwal Mata Pelajaran Semester Ganjil</title>
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
</head>

<body>

    <h2 style="text-align: center; margin-bottom: 11px; font-family: Calibri, sans-serif;">JADWAL MATA PELAJARAN</h2>
    <h3 style="text-align: center; margin-bottom: 11px; font-family: Calibri, sans-serif;">SMK MUHAMMADIYAH 1 PEKANBARU
    </h3>

    <table>
        <thead>
            <tr>
                <th>Hari</th>
                <th>Jam</th>
                <th>Kelas</th>
                <th>Kode Guru</th>
                <th>Mata Pelajaran</th>
                <th>Jp</th>
                <th>Ruangan</th>
            </tr>
        </thead>
        <tbody>
            @php
                $prev_day = '';
                $prev_class_room = '';
            @endphp
            @foreach ($schedules as $index => $item)
                @php
                    $timeParts = explode(' - ', $item->time->range);
                    $startTime = strtotime($timeParts[0]);
                    $endTime = strtotime($timeParts[1]);
                    $totalMinutes = round(($endTime - $startTime) / 60); // Total minutes of the class
                    $slots = ceil($totalMinutes / 40); // Calculate the number of 40-minute slots
                    $startTimeString = date('H:i', $startTime);
                    $endTimeString = date('H:i', $endTime);
                    $interval = round($totalMinutes / $slots);
                @endphp

                @for ($i = 0; $i < $slots; $i++)
                    <tr>
                        @if ($i == 0)
                            <td style="border-right: 1px solid black;">
                                @if ($item->day->name_day !== $prev_day || $item->teach->class_room !== $prev_class_room)
                                    {{ $item->day->name_day }}
                                @endif
                            </td>
                        @else
                            <td style="border-top: 20px solid white; border-right: 1px solid black;"></td>
                        @endif

                        <td style="border-left: 1px solid black;">
                            @if ($i == 0)
                                {{ date('H:i', $startTime + $i * $interval * 60) }} -
                                {{ date('H:i', $startTime + ($i + 1) * $interval * 60) }}
                            @else
                                {{ date('H:i', $startTime + $i * $interval * 60) }} -
                                {{ date('H:i', min($startTime + ($i + 1) * $interval * 60, $endTime)) }}
                            @endif
                        </td>
                        <td>{{ $item->teach->class_room }}</td>
                        <td>{{ $item->teach->lecturer->code_lecturers }}</td>
                        <td>{{ $item->teach->course->name }}</td>
                        <td>1</td>
                        <td>{{ $item->room->name }}</td>
                    </tr>
                @endfor
                @php
                    $prev_day = $item->day->name_day;
                    $prev_class_room = $item->teach->class_room;
                @endphp
            @endforeach


        </tbody>
    </table>

    @php
        $kepsek = App\Models\user::where('role', '2')->first();
        $wakil = App\Models\user::where('role', '3')->first();
    @endphp

    <div style="text-align: center; margin-top: 50px;">
        <div style="display: inline-block; text-align: left; margin-right: 270px;">
            <p>Kepala Sekolah</p>
            <br />
            <br />
            <br />
            <br />

            <br />
            <p>{{ $kepsek->name }}</p>
            <p>NBM. {{ $kepsek->nbm }}</p>
        </div>

        <div style="display: inline-block; text-align: left;">
            <p style="text-align: right; margin-top: 50px;">
                Pekanbaru
            </p>
            <p>Waka Kurikulum</p>
            <br />
            <br />
            <br />
            <br />
            <br />
            <p>{{ $wakil->name }}</p>
            <p>NBM. {{ $wakil->nbm }}</p>
        </div>
    </div>


</body>

</html>
