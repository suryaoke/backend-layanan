<table id="datatable2" class="table table-sm" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
    <thead>
        <tr>
            <th></th>
        </tr>
        <tr class="ml-8">
            <th style="text-align: center;" colspan="2" rowspan="4"></th>
        </tr>
        <tr>
            <th colspan="7" style=" text-align: center; font-weight: bold; font-size: 14px;"> LEGGER NILAI KELAS
                {{ $dataseksi->rombels->kelass->tingkat }} {{ $dataseksi->rombels->kelass->nama }}
                {{ $dataseksi->rombels->kelass->jurusans->nama }}
            </th>
        </tr>
        <tr>
            <th colspan="7" style="text-align: center; font-weight: bold; font-size: 14px;"> MAN 1 Kota Padang</th>

        </tr>
        <tr>
            <th colspan="7" style="text-align: center; font-weight: bold; font-size: 14px;"> Tahun Pelajaran
                {{ $dataseksi->semesters->semester }} Semester {{ $dataseksi->semesters->tahun }}
            </th>

        </tr>
    </thead>
    <tbody>
        <!-- Your table body goes here -->
    </tbody>
</table>



<p style="font-weight: bold;">A. PENGETAHUAN</p>
<p style="font-weight: bold;">Kriteria Ketuntasan Minimal =
    @php
        $kkm = App\Models\Kkm::where('id_kelas', $dataseksi->rombels->kelass->tingkat)->first();
    @endphp

    {{ $kkm->kkm }}
</p>
<p></p>
<table id="datatable" class="table table-sm" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
    <thead>
        <tr>
            <th style="width:40px; border: 2px solid black; text-align: center; font-weight: bold;">No</th>
            <th style="width:150px; border: 2px solid black; text-align: center;font-weight: bold;">Nama</th>
            <th style="width:100px; border: 2px solid black; text-align: center; font-weight: bold;">Nisn</th>
            <th style="width:100px; border: 2px solid black; text-align: center;font-weight: bold;">Jenis Kelamin</th>
            @foreach ($seksi as $key => $item)
                <th style="width:50px; border: 2px solid black; text-align: center;font-weight: bold;">
                    {{ $item->jadwalmapels->pengampus->mapels->kode_mapel }}
                </th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach ($rombelsiswa as $key => $siswa)
            <tr>
                <td style="width:40px; border: 2px solid black; text-align: center;">{{ $key + 1 }}</td>
                <td style="width:150px; border: 2px solid black;text-transform: capitalize;">{{ $siswa->siswas->nama }}
                </td>
                <td style="width:100px; border: 2px solid black;">{{ $siswa->siswas->nisn }}</td>
                <td style="width:100px; border: 2px solid black; text-align: center;">
                    @if ($siswa->siswas->jk == 'L')
                        L
                    @elseif ($siswa->siswas->jk == 'P')
                        P
                    @endif
                </td>
                @foreach ($seksi as $index => $item)
                    @php
                        $nilaiharian = App\Models\Nilai::where('id_seksi', $item->id)
                            ->where('id_rombelsiswa', $siswa->id)
                            ->where('type_nilai', 1)
                            ->avg('nilai_pengetahuan');
                        $nilaiharian_bulat = round($nilaiharian);

                        $nilaipas = App\Models\Nilai::where('id_rombelsiswa', $siswa->id)
                            ->where('type_nilai', 2)
                            ->where('id_seksi', $item->id)
                            ->first();

                        $rapor = ($nilaiharian_bulat + optional($nilaipas)->nilai_pengetahuan_akhir) / 2;

                        $rapor_bulat = round($rapor);
                    @endphp

                    <td style="width:50px; border: 2px solid black; text-align: center;">
                        {{ $rapor_bulat }}
                    </td>
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>


<p style="font-weight: bold;">B. Keterampilan</p>
<p style="font-weight: bold;">Kriteria Ketuntasan Minimal = {{ $kkm->kkm }}</p>
<p></p>
<table id="datatable1" class="table table-sm" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
    <thead>

        <tr>
            <th style="width:40px; border: 2px solid black; text-align: center; font-weight: bold;">No</th>
            <th style="width:100px; border: 2px solid black; text-align: center;font-weight: bold;">Nama</th>
            <th style="width:100px; border: 2px solid black; text-align: center; font-weight: bold;">Nisn</th>
            <th style="width:100px; border: 2px solid black; text-align: center;font-weight: bold;">Jenis Kelamin</th>
            @foreach ($seksi as $key => $item)
                <th style="width:50px; border: 2px solid black; text-align: center;font-weight: bold;">
                    {{ $item->jadwalmapels->pengampus->mapels->kode_mapel }}
                </th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach ($rombelsiswa as $key => $siswa)
            <tr>
                <td style="width:40px; border: 2px solid black; text-align: center;">{{ $key + 1 }}</td>
                <td style="width:250px; border: 2px solid black;text-transform: capitalize;">{{ $siswa->siswas->nama }}
                </td>
                <td style="width:100px; border: 2px solid black;">{{ $siswa->siswas->nisn }}</td>
                <td style="width:100px; border: 2px solid black; text-align: center;">
                    @if ($siswa->siswas->jk == 'L')
                        L
                    @elseif ($siswa->siswas->jk == 'P')
                        P
                    @endif
                </td>
                @foreach ($seksi as $index => $item)
                    @php

                        $nilaiketerampilan = App\Models\Nilai::where('id_rombelsiswa', $siswa->id)
                            ->where('type_nilai', 3)
                            ->where('id_seksi', $item->id)
                            ->avg('nilai_keterampilan');

                        $nilaiketerampilan_bulat = round($nilaiketerampilan);
                    @endphp

                    <td style="width:50px; border: 2px solid black; text-align: center;">
                        {{ $nilaiketerampilan_bulat }}
                    </td>
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>
<style>
    .left {
        text-align: left;
    }

    .right {
        text-align: right;
    }
</style>
@php
    use Carbon\Carbon;
    setlocale(LC_TIME, 'id_ID');
    $tanggalSaatIni = Carbon::now();
    $bulanIndonesia = [
        'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember',
    ];
@endphp

<table>
    <tr>
        <th colspan="2" rowspan="8" class="left" style="text-transform: capitalize;">
            <div class="">Mengetahui <br> Kepala Sekolah
                <br>
                <br><br><br><br>
                @php
                    $user = App\Models\User::where('role', '2')->first();

                @endphp
                {{ $user->name }}
            </div>
        </th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th colspan="3" rowspan="8" class="right" style="text-transform: capitalize;">
            <div class="">Padang,
                {{ $tanggalSaatIni->format('d ') . $bulanIndonesia[$tanggalSaatIni->month - 1] . $tanggalSaatIni->format(' Y') }}
                <br> Mengetahui <br> Wali Kelas <br> <br> <br><br> @php

                    $walas = App\Models\Guru::where('id', $dataseksi->rombels->walass->id_guru)->first();

                @endphp
                {{ $walas->nama }}
            </div>
        </th>

</table>
