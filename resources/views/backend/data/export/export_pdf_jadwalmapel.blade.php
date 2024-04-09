<!DOCTYPE html>
<html>

<head>
    <title>Jadwal Mata Pelajaran</title>
    <style>
        #tabel1 {
            /* Menggunakan id sebagai selector */
            border-collapse: collapse;
            border: 1px solid black;
            width: 100%;
            table-layout: fixed;
        }

        #tabel1 th,
        #tabel1 td {
            /* Menggunakan id sebagai selector */
            border: 1px solid black;
            padding: 10px;
            text-align: center;
            word-wrap: break-word;
        }
    </style>
    <style>
        <!--
        /* Font Definitions */
        @font-face {
            font-family: "Cambria Math";
            panose-1: 2 4 5 3 5 4 6 3 2 4;
        }

        @font-face {
            font-family: Calibri;
            panose-1: 2 15 5 2 2 2 4 3 2 4;
        }

        /* Style Definitions */

        body {
            background-image: url('{{ asset('backend/dist/images/kemenag.png') }}');

            background-repeat: no-repeat;
            background-position: center;
            background-attachment: fixed;
            background-size: 40%;
            opacity: 0.1;
            /* Ubah opasitas sesuai kebutuhan */
        }

        p.MsoNormal,
        li.MsoNormal,
        div.MsoNormal {
            margin-top: 0cm;
            margin-right: 0cm;
            margin-bottom: 0pt;
            margin-left: 0cm;
            line-height: 107%;
            font-size: 11.0pt;
            font-family: "Calibri", sans-serif;
        }

        p.MsoNoSpacing,
        li.MsoNoSpacing,
        div.MsoNoSpacing {
            margin: 0cm;
            font-size: 11.0pt;
            font-family: "Calibri", sans-serif;
        }

        .MsoPapDefault {
            margin-bottom: 8.0pt;
            line-height: 107%;
        }

        @page WordSection1 {
            size: 595.3pt 841.9pt;
            margin: 36.0pt 36.0pt 36.0pt 36.0pt;
        }

        div.WordSection1 {
            page: WordSection1;
        }

        /* List Definitions */
        ol {
            margin-bottom: 0cm;
        }

        ul {
            margin-bottom: 0cm;
        }

        /* Additional Styles */
        .MsoTableGrid {
            margin-bottom: 20px;
        }

        .uppercase-text {
            text-transform: capitalize;
        }
        -->
    </style>

</head>

<body>
    <table border=0 cellspacing=0 cellpadding=0 width=686 style='width:514.85pt;border-collapse:collapse;border:none'>
        <tr style='height:70.55pt'>
            <td width=123 valign=top
                style='width:92.15pt;border:none;border-bottom:solid black 2.25pt;
  padding:0cm 5.4pt 0cm 5.4pt;height:70.55pt'>
                <p class=MsoNoSpacing align=center style='text-align:center'><b><span
                            style='font-size:12.0pt;font-family:"Times New Roman",serif'><img width=82 height=82
                                src="{{ asset('backend/dist/images/kemenag.png') }}"></span></b></p>
            </td>
            <td width=454 valign=top
                style='width:12.0cm;border:none;border-bottom:solid black 2.25pt;
  padding:0cm 5.4pt 0cm 5.4pt;height:70.55pt'>
                <p class=MsoNoSpacing align=center style='text-align:center'><b><span
                            style='font-size:12.0pt;font-family:"Times New Roman",serif'>KEMENTRIAN AGAMA
                            REPUBLIK INDONESIA</span></b></p>
                <p class=MsoNoSpacing align=center style='text-align:center'><b><span
                            style='font-size:16.0pt;font-family:"Times New Roman",serif'>MAN 1 KOTA
                            PADANG</span></b></p>
                <p class=MsoNoSpacing align=center style='text-align:center'><i><span
                            style='font-family:"Times New Roman",serif'>JL. RAYA DURIAN TARUNG NO. 37 RT.
                            002 RW. 007</span></i></p>
                <p class=MsoNoSpacing align=center style='text-align:center'><i><span
                            style='font-family:"Times New Roman",serif'>Kecamatan Kuranji, Kota Padang -
                            Sumatera Barat</span></i></p>
                <p class=MsoNoSpacing><b><span
                            style='font-size:12.0pt;font-family:"Times New Roman",serif'>&nbsp;</span></b></p>
            </td>
            <td width=110 valign=top
                style='width:82.5pt;border:none;border-bottom:solid black 2.25pt;
  padding:0cm 5.4pt 0cm 5.4pt;height:70.55pt'>
                <p class=MsoNoSpacing align=center style='text-align:center'><b><span
                            style='font-size:12.0pt;font-family:"Times New Roman",serif'><img width=79 height=76
                                id="Picture 3" src="{{ asset('backend/dist/images/man1_copy.png') }}"></span></b>
                </p>
            </td>
        </tr>
    </table>
    <table class=MsoTableGrid border=0 cellspacing=0 cellpadding=0 width=686
        style='width:514.85pt;border-collapse:collapse;border:none'>
        <h3 style="text-align: center; margin-bottom: 5px; font-family: Calibri, sans-serif;">JADWAL MATA PELAJARAN
        </h3>

        <h3 style="text-align: center; margin-bottom: 5px; font-family: Calibri, sans-serif;">Tahun Pelajaran
            {{ $datajadwal->tahun->tahun }} Semester {{ $datajadwal->tahun->semester }}
        </h3>
    </table>


    <table id="tabel1" class="table table-bordered mt-4">
        <thead>
            <tr>
                <th class="btn-secondary" style="width:100px  ; border: 1px solid black; text-align: center;">Hari</th>
                <th class="btn-secondary" style="width:100px  ; border: 1px solid black; text-align: center;">Waktu</th>
                @php
                    $kelasGroups = collect();
                @endphp
                @foreach ($jadwalmapel as $key => $jadwal)
                    @php
                        $kelas = $jadwal->pengampus->kelas;
                        if (!$kelasGroups->has($kelas)) {
                            $kelasGroups->put($kelas, collect());
                        }
                        $kelasGroups[$kelas]->push($jadwal);
                    @endphp
                @endforeach
                @php
                    $kelasGroups = $kelasGroups->sortKeys();
                @endphp
                @foreach ($kelasGroups as $kelas => $jadwalByClass)
                    @php
                        $tingkat = App\Models\Kelas::where('id', $kelas)->first();
                    @endphp
                    <th colspan="3" class="btn-secondary"
                        style="width:100px  ; border: 1px solid black; text-align: center;">
                        {{ $tingkat->tingkat }} {{ $tingkat->nama }}
                        {{ $tingkat['jurusans']['nama'] }}
                    </th>
                @endforeach
            </tr>
            <tr>
                <th class="btn-secondary" style="width:100px  ; border: 1px solid black;"></th>
                <th class="btn-secondary" style="width:100px  ; border: 1px solid black;"></th>
                @foreach ($kelasGroups as $kelas => $jadwalByClass)
                    <th style="white-space: nowrap; width:100px  ; border: 1px solid black; text-align: center;"
                        class="btn-primary">
                        Kode Guru</th>
                    <th style=" white-space: nowrap; width:100px  ; border: 1px solid black; text-align: center;"
                        class="btn-primary">
                        Kode Mapel</th>
                    <th style="white-space: nowrap; width:100px  ; border: 1px solid black; text-align: center;"
                        class="btn-primary">
                        Ruangan</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @php
                // Filter dan urutkan jadwalmapel berdasarkan id_hari dan id_waktu
                $jadwalmapelSorted = $jadwalmapel->sortBy(['id_hari', 'id_waktu']);
            @endphp

            <!-- Tampilkan jadwal untuk id_hari 1 -->
            @php
                $lastDay = ''; // variabel untuk menyimpan nama hari sebelumnya
            @endphp

            @foreach ($jadwalmapelSorted->where('id_hari', 1) as $key => $jadwal)
                <tr>
                    @if ($lastDay != $jadwal->haris->nama)
                        <td style="width:100px; border: 1px solid black;"
                            rowspan="{{ $jadwalmapelSorted->where('id_hari', 1)->count() }}">
                            {{ $jadwal->haris->nama }}
                        </td>
                        @php
                            $lastDay = $jadwal->haris->nama;
                        @endphp
                    @else
                    @endif
                    <td style="width:100px; border: 1px solid black;">{{ $jadwal->id_waktu }}</td>
                    <td style="width:100px; border: 1px solid black;">{{ $jadwal->pengampus->gurus->kode_gr }}</td>
                    <td style="width:100px; border: 1px solid black;">{{ $jadwal->pengampus->mapels->kode_mapel }}</td>
                    <td style="width:100px; border: 1px solid black;">{{ $jadwal->ruangans->kode_ruangan }}</td>
                </tr>
            @endforeach

            @foreach ($jadwalmapelSorted->where('id_hari', 2) as $key => $jadwal)
                <tr>
                    @if ($lastDay != $jadwal->haris->nama)
                        <td style="width:100px; border: 1px solid black;"
                            rowspan="{{ $jadwalmapelSorted->where('id_hari', 2)->count() }}">
                            {{ $jadwal->haris->nama }}
                        </td>
                        @php
                            $lastDay = $jadwal->haris->nama;
                        @endphp
                    @else
                    @endif
                    <td style="width:100px; border: 1px solid black;">{{ $jadwal->id_waktu }}</td>
                    <td style="width:100px; border: 1px solid black;">{{ $jadwal->pengampus->gurus->kode_gr }}</td>
                    <td style="width:100px; border: 1px solid black;">{{ $jadwal->pengampus->mapels->kode_mapel }}</td>
                    <td style="width:100px; border: 1px solid black;">{{ $jadwal->ruangans->kode_ruangan }}</td>
                </tr>
            @endforeach

            @foreach ($jadwalmapelSorted->where('id_hari', 3) as $key => $jadwal)
                <tr>
                    @if ($lastDay != $jadwal->haris->nama)
                        <td style="width:100px; border: 1px solid black;"
                            rowspan="{{ $jadwalmapelSorted->where('id_hari', 3)->count() }}">
                            {{ $jadwal->haris->nama }}
                        </td>
                        @php
                            $lastDay = $jadwal->haris->nama;
                        @endphp
                    @else
                    @endif
                    <td style="width:100px; border: 1px solid black;">{{ $jadwal->id_waktu }}</td>
                    <td style="width:100px; border: 1px solid black;">{{ $jadwal->pengampus->gurus->kode_gr }}</td>
                    <td style="width:100px; border: 1px solid black;">{{ $jadwal->pengampus->mapels->kode_mapel }}</td>
                    <td style="width:100px; border: 1px solid black;">{{ $jadwal->ruangans->kode_ruangan }}</td>
                </tr>
            @endforeach

            @foreach ($jadwalmapelSorted->where('id_hari', 4) as $key => $jadwal)
                <tr>
                    @if ($lastDay != $jadwal->haris->nama)
                        <td style="width:100px; border: 1px solid black;"
                            rowspan="{{ $jadwalmapelSorted->where('id_hari', 4)->count() }}">
                            {{ $jadwal->haris->nama }}
                        </td>
                        @php
                            $lastDay = $jadwal->haris->nama;
                        @endphp
                    @else
                    @endif
                    <td style="width:100px; border: 1px solid black;">{{ $jadwal->id_waktu }}</td>
                    <td style="width:100px; border: 1px solid black;">{{ $jadwal->pengampus->gurus->kode_gr }}</td>
                    <td style="width:100px; border: 1px solid black;">{{ $jadwal->pengampus->mapels->kode_mapel }}</td>
                    <td style="width:100px; border: 1px solid black;">{{ $jadwal->ruangans->kode_ruangan }}</td>
                </tr>
            @endforeach

            @foreach ($jadwalmapelSorted->where('id_hari', 5) as $key => $jadwal)
                <tr>
                    @if ($lastDay != $jadwal->haris->nama)
                        <td style="width:100px; border: 1px solid black;"
                            rowspan="{{ $jadwalmapelSorted->where('id_hari', 5)->count() }}">
                            {{ $jadwal->haris->nama }}
                        </td>
                        @php
                            $lastDay = $jadwal->haris->nama;
                        @endphp
                    @else
                    @endif
                    <td style="width:100px; border: 1px solid black;">{{ $jadwal->id_waktu }}</td>
                    <td style="width:100px; border: 1px solid black;">{{ $jadwal->pengampus->gurus->kode_gr }}</td>
                    <td style="width:100px; border: 1px solid black;">{{ $jadwal->pengampus->mapels->kode_mapel }}</td>
                    <td style="width:100px; border: 1px solid black;">{{ $jadwal->ruangans->kode_ruangan }}</td>
                </tr>
            @endforeach



        </tbody>

    </table>
    <p class=MsoNoSpacing align=center style='text-align:center'><b><span
                style='font-size:12.0pt;font-family:"Times New Roman",serif'>&nbsp;</span></b></p>

    <table border=0 cellspacing=0 cellpadding=0 style='margin-left:49.65pt;border-collapse:collapse;border:none' ">
<tr style='height:103.2pt'>
<td width=206 valign=top style='width:300.4pt;padding:0cm 5.4pt 0cm 5.4pt;
  height:103.2pt'>
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


<p class=MsoNoSpacing><span style='font-size:12.0pt;font-family:"Times New Roman",serif'>Kepala
Madrasah</span></p>

<p class=MsoNoSpacing style='line-height:150%'><span
style='font-size:12.0pt;
  line-height:150%;font-family:"Times New Roman",serif'>&nbsp;</span>
</p>
<p class=MsoNoSpacing style='line-height:150%'><span
style='font-size:12.0pt;
  line-height:150%;font-family:"Times New Roman",serif'>&nbsp;</span>
</p>
<p class=MsoNoSpacing style='line-height:150%'><span
style='font-size:12.0pt;
  line-height:150%;font-family:"Times New Roman",serif'>&nbsp;</span>
</p>
<p class=MsoNoSpacing style='line-height:150%'><span
style='font-size:12.0pt;
  line-height:150%;font-family:"Times New Roman",serif'>&nbsp;</span>
</p>
<p class=MsoNoSpacing style='line-height:150%'><span
style='font-size:12.0pt;
  line-height:150%;font-family:"Times New Roman",serif' class="uppercase-text">@php
      $user = App\Models\User::where('role', '2')->first();

  @endphp
{{ $user->name }}
</span>
</p></span></p>
</td>
<td width=299 valign=top style='width:224.45pt;padding:0cm 5.4pt 0cm 5.4pt;
  height:103.2pt'>


<p class=MsoNoSpacing>
<span style='font-size:12.0pt;font-family:"Times New Roman",serif'>
Padang, {{ $tanggalSaatIni->format('d ') . $bulanIndonesia[$tanggalSaatIni->month - 1] . $tanggalSaatIni->format(' Y') }}
</span>
</p>
<p class=MsoNoSpacing><span style='font-size:12.0pt;font-family:"Times New Roman",serif'>Wali Kelas</span></p>

<p class=MsoNoSpacing style='line-height:150%'><span
style='font-size:12.0pt;
  line-height:150%;font-family:"Times New Roman",serif'>&nbsp;</span>
</p>
<p class=MsoNoSpacing style='line-height:150%'><span
style='font-size:12.0pt;
  line-height:150%;font-family:"Times New Roman",serif'>&nbsp;</span>
</p>
<p class=MsoNoSpacing style='line-height:150%'><span
style='font-size:12.0pt;
  line-height:150%;font-family:"Times New Roman",serif'>&nbsp;</span>
</p>
<p class=MsoNoSpacing style='line-height:150%'><span
style='font-size:12.0pt;
  line-height:150%;font-family:"Times New Roman",serif' class="uppercase-text">
@php
    $walas = App\Models\Walas::where('id_kelas', $datajadwal->pengampus->kelas)->first();

    $guru = App\Models\Guru::where('id', $walas->id_guru)->first();
@endphp
{{ $guru->nama }}
</span>
</p>
</td>
</tr>
</table>

<p class=MsoNoSpacing style='line-height:150%'><span
style='font-size:12.0pt;
line-height:150%;font-family:"Times New Roman",serif'>&nbsp;</span></p>


</body>

</html>
