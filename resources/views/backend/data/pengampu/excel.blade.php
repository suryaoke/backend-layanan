<table class="table table-bordered">
    <thead>
        <tr>
            <th style="background-color: yellow; white-space: nowrap; width: 50px; border: 2px solid black;">No</th>
            <th style="background-color: yellow; white-space: nowrap; width: 150px; border: 2px solid black;">Nama Guru
            </th>
            <th style="background-color: yellow;  white-space: nowrap; width: 150px; border: 2px solid black;">Kode Guru
            </th>
            <th style="background-color: yellow; white-space: nowrap; width: 150px; border: 2px solid black;">Mata
                Pelajaran</th>
            <th style="background-color: yellow; white-space: nowrap; width: 150px; border: 2px solid black;">Kode Mapel
            </th>
            <th style="background-color: yellow; white-space: nowrap; width: 150px; border: 2px solid black;">Kelas</th>
            <th style="background-color: yellow; white-space: nowrap; width: 150px; border: 2px solid black;">Id Kelas
            </th>
        </tr>
    </thead>
    <tbody>
        @php
            $maxCount = max(count($guru), count($mapel), count($kelas));
        @endphp
        @for ($i = 0; $i < $maxCount; $i++)
            <tr>
                <td style="white-space: nowrap; width: 50px; border: 2px solid black;">{{ $i + 1 }}</td>
                <td style="white-space: nowrap; width: 150px; border: 2px solid black;">
                    @if (isset($guru[$i]))
                        {{ $guru[$i]['nama'] }}
                    @endif
                </td>
                <td style="white-space: nowrap; width: 150px; border: 2px solid black;">
                    @if (isset($guru[$i]))
                        {{ $guru[$i]['kode_gr'] }}
                    @endif
                </td>
                <td style="white-space: nowrap; width: 150px; border: 2px solid black;">
                    @if (isset($mapel[$i]))
                        {{ $mapel[$i]['nama'] }}
                    @endif
                </td>
                <td style="white-space: nowrap; width: 150px; border: 2px solid black;">
                    @if (isset($mapel[$i]))
                        {{ $mapel[$i]['kode_mapel'] }}
                    @endif
                </td>
                <td style="white-space: nowrap; width: 150px; border: 2px solid black;">
                    @if (isset($kelas[$i]))
                        {{ $kelas[$i]['tingkat'] }} {{ $kelas[$i]['nama'] }} {{ $kelas[$i]['jurusans']['nama'] }}
                    @endif
                </td>

                <td style="white-space: nowrap; width: 150px; border: 2px solid black;">
                    @if (isset($kelas[$i]))
                        {{ $kelas[$i]['id'] }}
                    @endif
                </td>
            </tr>
        @endfor
    </tbody>
</table>

<table class="table table-bordered">
    <thead>
        <tr>
            <th style="background-color: yellow; white-space: nowrap; width: 50px; border: 2px solid black;">No</th>
            <th style="background-color: yellow; white-space: nowrap; width: 150px; border: 2px solid black;">Template
                Kode Guru
            </th>
            <th style="background-color: yellow; white-space: nowrap; width: 150px; border: 2px solid black;">Template
                Kode Mapel
            </th>
            <th style="background-color: yellow;  white-space: nowrap; width: 150px; border: 2px solid black;">Template
                Id Kelas
            </th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>1</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    </tbody>
</table>
