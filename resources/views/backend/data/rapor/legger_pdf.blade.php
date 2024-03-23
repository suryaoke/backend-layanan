<html>

<head>
    <meta http-equiv=Content-Type content="text/html; charset=windows-1252">
    <meta name=Generator content="Microsoft Word 15 (filtered)">
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
        p.MsoNormal,
        li.MsoNormal,
        div.MsoNormal {
            margin-top: 0cm;
            margin-right: 0cm;
            margin-bottom: 8.0pt;
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

        /* Page Definitions */
        @page WordSection1 {
            size: 841.9pt 595.3pt;
            margin: 14.2pt 36.0pt 14.2pt 36.0pt;
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

        .uppercase-text {
            text-transform: capitalize;
        }
        -->
    </style>

</head>

<body lang=EN-ID style='word-wrap:break-word'>

    <div class=WordSection1>

        <table class=MsoTableGrid border=0 cellspacing=0 cellpadding=0 width=992
            style='width:744.2pt;border-collapse:collapse;border:none'>
            <tr style='height:63.6pt'>
                <td width=264 valign=top
                    style='width:198.2pt;border:none;border-bottom:solid black 2.25pt;
  padding:0cm 5.4pt 0cm 5.4pt;height:63.6pt'>
                    <p class=MsoNoSpacing align=center style='text-align:center'><b><span
                                style='font-size:12.0pt;font-family:"Times New Roman",serif'><img width=82 height=82
                                    src="{{ asset('backend/dist/images/kemenag.png') }}"></span></b></p>
                </td>
                <td width=501 valign=top
                    style='width:375.65pt;border:none;border-bottom:
  solid black 2.25pt;padding:0cm 5.4pt 0cm 5.4pt;height:63.6pt'>
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
                <td width=227 valign=top
                    style='width:170.35pt;border:none;border-bottom:
  solid black 2.25pt;padding:0cm 5.4pt 0cm 5.4pt;height:63.6pt'>
                    <p class=MsoNoSpacing align=center style='text-align:center'><b><span
                                style='font-size:12.0pt;font-family:"Times New Roman",serif'><img width=79 height=76
                                    src="{{ asset('backend/dist/images/man1_copy.png') }}"></span></b></p>
                </td>
            </tr>
        </table>

        <p class=MsoNoSpacing align=center style='text-align:center'><b><span
                    style='font-size:12.0pt;font-family:"Times New Roman",serif'>&nbsp;</span></b></p>

        <table class=MsoTableGrid border=0 cellspacing=0 cellpadding=0 width=983
            style='width:26.0cm;border-collapse:collapse;border:none'>
            <tr>
                <td width=93 valign=top style='width:69.4pt;padding:0cm 5.4pt 0cm 5.4pt'>
                    <p class=MsoNoSpacing style='line-height:150%'><span
                            style='font-size:12.0pt;
  line-height:150%;font-family:"Times New Roman",serif'>Kelas</span>
                    </p>
                </td>
                <td width=644 valign=top style='width:483.2pt;padding:0cm 5.4pt 0cm 5.4pt'>
                    <p class=MsoNoSpacing style='line-height:150%'><span
                            style='font-size:12.0pt;
  line-height:150%;font-family:"Times New Roman",serif'>:
                            {{ $dataseksi->rombels->kelass->tingkat }} {{ $dataseksi->rombels->kelass->nama }}
                            {{ $dataseksi->rombels->kelass->jurusans->nama }}</span>
                    </p>
                </td>
                <td width=132 valign=top style='width:99.2pt;padding:0cm 5.4pt 0cm 5.4pt'>
                    <p class=MsoNoSpacing style='line-height:150%'><span
                            style='font-size:12.0pt;
  line-height:150%;font-family:"Times New Roman",serif'>Tahun
                            Pelajaran</span></p>
                </td>
                <td width=114 valign=top style='width:85.3pt;padding:0cm 5.4pt 0cm 5.4pt'>
                    <p class=MsoNoSpacing style='line-height:150%'><span
                            style='font-size:12.0pt;
  line-height:150%;font-family:"Times New Roman",serif'>:
                            {{ $dataseksi->semesters->tahun }}</span>
                    </p>
                </td>
            </tr>
            <tr style='height:12.65pt'>
                <td width=93 valign=top
                    style='width:69.4pt;border:none;border-bottom:solid black 2.25pt;
  padding:0cm 5.4pt 0cm 5.4pt;height:12.65pt'>
                    <p class=MsoNoSpacing style='line-height:150%'><span
                            style='font-size:12.0pt;
  line-height:150%;font-family:"Times New Roman",serif'>Madrasah</span>
                    </p>
                </td>
                <td width=644 valign=top
                    style='width:483.2pt;border:none;border-bottom:solid black 2.25pt;
  padding:0cm 5.4pt 0cm 5.4pt;height:12.65pt'>
                    <p class=MsoNoSpacing style='line-height:150%'><span
                            style='font-size:12.0pt;
  line-height:150%;font-family:"Times New Roman",serif'>: MAN 1
                            Kota Padang</span>
                    </p>
                </td>
                <td width=132 valign=top
                    style='width:99.2pt;border:none;border-bottom:solid black 2.25pt;
  padding:0cm 5.4pt 0cm 5.4pt;height:12.65pt'>
                    <p class=MsoNoSpacing style='line-height:150%'><span
                            style='font-size:12.0pt;
  line-height:150%;font-family:"Times New Roman",serif'>Semester</span>
                    </p>
                </td>
                <td width=114 valign=top
                    style='width:85.3pt;border:none;border-bottom:solid black 2.25pt;
  padding:0cm 5.4pt 0cm 5.4pt;height:12.65pt'>
                    <p class=MsoNoSpacing style='line-height:150%'><span
                            style='font-size:12.0pt;
  line-height:150%;font-family:"Times New Roman",serif'>:
                            {{ $dataseksi->semesters->semester }}</span>
                    </p>
                </td>
            </tr>
        </table>

        <p class=MsoNoSpacing style='line-height:150%'><span
                style='font-size:12.0pt;
line-height:150%;font-family:"Times New Roman",serif'>&nbsp;</span></p>

        <p class=MsoNoSpacing align=center style='text-align:center;line-height:150%'><b><span
                    style='font-size:16.0pt;line-height:150%;font-family:"Times New Roman",serif'>Legger
                    Nilai</span></b></p>

        <p class=MsoNormal><span
                style='font-size:12.0pt;line-height:107%;font-family:
"Times New Roman",serif'>A.Pengetahuan</span></p>

        <p class=MsoNormal><span style='font-size:12.0pt;line-height:107%;font-family:
"Times New Roman",serif'>Kriteria
                Ketuntasan Minimal = @php
                    $kkm = App\Models\Kkm::where('id_kelas', $dataseksi->rombels->kelass->tingkat)->first();
                @endphp

                {{ $kkm->kkm }}</span></p>

        <table id="datatable" class="table table-sm" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
            <thead>
                <tr>
                    <th style="width:40px; border: 1px solid black; text-align: center; font-weight: bold; font-size:10.0pt; font-family:"Times
                        New Roman"">
                        No</th>
                    <th style="width:150px; border: 1px solid black; text-align: center;font-weight: bold; font-size:10.0pt; font-family:"Times
                        New Roman"">
                        Nama</th>
                    <th style="width:100px; border: 1px solid black; text-align: center; font-weight: bold;font-size:10.0pt; font-family:"Times
                        New Roman"">
                        Nisn</th>
                    <th style="width:40px; border: 1px solid black; text-align: center;font-weight: bold;font-size:10.0pt; font-family:"Times
                        New Roman"">
                        JK
                    </th>
                    @foreach ($seksi as $key => $item)
                        <th style="width:50px; border: 1px solid black; text-align: center;font-weight: bold;font-size:10.0pt; font-family:"Times
                            New Roman"">
                            {{ $item->jadwalmapels->pengampus->mapels->kode_mapel }}
                        </th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($rombelsiswa as $key => $siswa)
                    <tr>
                        <td style="width:40px; border: 1px solid black; text-align: center;font-size:10.0pt; font-family:"Times
                            New Roman"">
                            {{ $key + 1 }}</td>
                        <td style="width:150px; border: 1px solid black;text-transform: capitalize;font-size:10.0pt; font-family:"Times
                            New Roman"">
                            {{ $siswa->siswas->nama }}
                        </td>
                        <td style="width:100px; border: 1px solid black;font-size:10.0pt; font-family:"Times New
                            Roman"">{{ $siswa->siswas->nisn }}
                        </td>
                        <td style="width:40px; border: 1px solid black; text-align: center;font-size:10.0pt; font-family:"Times
                            New Roman"">
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

                            <td style="width:50px; border: 1px solid black; text-align: center;font-size:10.0pt; font-family:"Times
                                New Roman"">
                                {{ $rapor_bulat }}
                            </td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>




        <p class=MsoNormal>&nbsp;</p>

        <p class=MsoNormal>&nbsp;</p>


        <table class=MsoTableGrid border=0 cellspacing=0 cellpadding=0 style='border-collapse:collapse;border:none'>
            <tr style='height:93.75pt'>
                <td width=727 valign=top style='width:545.5pt;padding:0cm 5.4pt 0cm 5.4pt;
  height:93.75pt'>
                    <p class=MsoNormal style='margin-bottom:0cm;line-height:normal'>Mengetahui </p>
                    <p class=MsoNormal style='margin-bottom:0cm;line-height:normal'>Kepala
                        Madrasah</p>
                    <p class=MsoNormal style='margin-bottom:0cm;line-height:normal'>&nbsp;</p>
                    <p class=MsoNormal style='margin-bottom:0cm;line-height:normal'>&nbsp;</p>
                    <p class=MsoNormal style='margin-bottom:0cm;line-height:normal'>&nbsp;</p>
                    <p class=MsoNormal style='margin-bottom:0cm;line-height:normal'>&nbsp;</p>
                    <p class=MsoNormal style='margin-bottom:0cm;line-height:normal' class="uppercase-text">
                        @php
                            $user = App\Models\User::where('role', '2')->first();

                        @endphp
                        {{ $user->name }}
                    </p>
                </td>
                <td width=299 valign=top style='width:223.9pt;padding:0cm 5.4pt 0cm 5.4pt;
  height:93.75pt'>

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


                    <p class=MsoNormal style='margin-bottom:0cm;line-height:normal'>Padang,
                        {{ $tanggalSaatIni->format('d ') . $bulanIndonesia[$tanggalSaatIni->month - 1] . $tanggalSaatIni->format(' Y') }}
                    </p>
                    <p class=MsoNormal style='margin-bottom:0cm;line-height:normal'>Mengetahui </p>
                    <p class=MsoNormal style='margin-bottom:0cm;line-height:normal'>Wali Kelas</p>
                    <p class=MsoNormal style='margin-bottom:0cm;line-height:normal'>&nbsp;</p>
                    <p class=MsoNormal style='margin-bottom:0cm;line-height:normal'>&nbsp;</p>
                    <p class=MsoNormal style='margin-bottom:0cm;line-height:normal'>&nbsp;</p>

                    <p class=MsoNormal style='margin-bottom:0cm;line-height:normal' class="uppercase-text">
                        @php
                            $walas = App\Models\Guru::where('id', $dataseksi->rombels->walass->id_guru)->first();
                        @endphp
                        {{ $walas->nama }}</p>
                </td>
            </tr>
        </table>

        <p class=MsoNormal>&nbsp;</p>

        <table class=MsoTableGrid border=0 cellspacing=0 cellpadding=0 width=992
            style='width:744.2pt;border-collapse:collapse;border:none'>
            <tr style='height:70.55pt'>
                <td width=264 valign=top
                    style='width:198.2pt;border:none;border-bottom:solid black 2.25pt;
  padding:0cm 5.4pt 0cm 5.4pt;height:70.55pt'>
                    <p class=MsoNoSpacing align=center style='text-align:center'><b><span
                                style='font-size:12.0pt;font-family:"Times New Roman",serif'><img width=82 height=82
                                    id="Picture 1" src="{{ asset('backend/dist/images/kemenag.png') }}"></span></b>
                    </p>
                </td>
                <td width=501 valign=top
                    style='width:375.65pt;border:none;border-bottom:
  solid black 2.25pt;padding:0cm 5.4pt 0cm 5.4pt;height:70.55pt'>
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
                                style='font-family:"Times New Roman",serif'>Kecamatan Kuranji, Kota Padang �
                                Sumatera Barat</span></i></p>
                    <p class=MsoNoSpacing><b><span
                                style='font-size:12.0pt;font-family:"Times New Roman",serif'>&nbsp;</span></b></p>
                </td>
                <td width=227 valign=top
                    style='width:170.35pt;border:none;border-bottom:
  solid black 2.25pt;padding:0cm 5.4pt 0cm 5.4pt;height:70.55pt'>
                    <p class=MsoNoSpacing align=center style='text-align:center'><b><span
                                style='font-size:12.0pt;font-family:"Times New Roman",serif'><img width=79 height=76
                                    id="Picture 3" src="{{ asset('backend/dist/images/man1_copy.png') }}"></span></b>
                    </p>
                </td>
            </tr>
        </table>

        <p class=MsoNoSpacing align=center style='text-align:center'><b><span
                    style='font-size:12.0pt;font-family:"Times New Roman",serif'>&nbsp;</span></b></p>

        <table class=MsoTableGrid border=0 cellspacing=0 cellpadding=0 width=983
            style='width:26.0cm;border-collapse:collapse;border:none'>
            <tr>
                <td width=93 valign=top style='width:69.4pt;padding:0cm 5.4pt 0cm 5.4pt'>
                    <p class=MsoNoSpacing style='line-height:150%'><span
                            style='font-size:12.0pt;
  line-height:150%;font-family:"Times New Roman",serif'>Kelas</span>
                    </p>
                </td>
                <td width=644 valign=top style='width:483.2pt;padding:0cm 5.4pt 0cm 5.4pt'>
                    <p class=MsoNoSpacing style='line-height:150%'><span
                            style='font-size:12.0pt;
  line-height:150%;font-family:"Times New Roman",serif'>:
                            {{ $dataseksi->rombels->kelass->tingkat }} {{ $dataseksi->rombels->kelass->nama }}
                            {{ $dataseksi->rombels->kelass->jurusans->nama }}</span>
                    </p>
                </td>
                <td width=132 valign=top style='width:99.2pt;padding:0cm 5.4pt 0cm 5.4pt'>
                    <p class=MsoNoSpacing style='line-height:150%'><span
                            style='font-size:12.0pt;
  line-height:150%;font-family:"Times New Roman",serif'>Tahun
                            Pelajaran</span></p>
                </td>
                <td width=114 valign=top style='width:85.3pt;padding:0cm 5.4pt 0cm 5.4pt'>
                    <p class=MsoNoSpacing style='line-height:150%'><span
                            style='font-size:12.0pt;
  line-height:150%;font-family:"Times New Roman",serif'>:
                            {{ $dataseksi->semesters->tahun }}</span>
                    </p>
                </td>
            </tr>
            <tr>
                <td width=93 valign=top
                    style='width:69.4pt;border:none;border-bottom:solid black 2.25pt;
  padding:0cm 5.4pt 0cm 5.4pt'>
                    <p class=MsoNoSpacing style='line-height:150%'><span
                            style='font-size:12.0pt;
  line-height:150%;font-family:"Times New Roman",serif'>Madrasah</span>
                    </p>
                </td>
                <td width=644 valign=top
                    style='width:483.2pt;border:none;border-bottom:solid black 2.25pt;
  padding:0cm 5.4pt 0cm 5.4pt'>
                    <p class=MsoNoSpacing style='line-height:150%'><span
                            style='font-size:12.0pt;
  line-height:150%;font-family:"Times New Roman",serif'>: MAN 1
                            Kota Padang</span>
                    </p>
                </td>
                <td width=132 valign=top
                    style='width:99.2pt;border:none;border-bottom:solid black 2.25pt;
  padding:0cm 5.4pt 0cm 5.4pt'>
                    <p class=MsoNoSpacing style='line-height:150%'><span
                            style='font-size:12.0pt;
  line-height:150%;font-family:"Times New Roman",serif'>Semester</span>
                    </p>
                </td>
                <td width=114 valign=top
                    style='width:85.3pt;border:none;border-bottom:solid black 2.25pt;
  padding:0cm 5.4pt 0cm 5.4pt'>
                    <p class=MsoNoSpacing style='line-height:150%'><span
                            style='font-size:12.0pt;
  line-height:150%;font-family:"Times New Roman",serif'>:
                            {{ $dataseksi->semesters->semester }}</span>
                    </p>
                </td>
            </tr>
        </table>

        <p class=MsoNoSpacing style='line-height:150%'><span
                style='font-size:12.0pt;
line-height:150%;font-family:"Times New Roman",serif'>&nbsp;</span></p>

        <p class=MsoNoSpacing align=center style='text-align:center;line-height:150%'><b><span
                    style='font-size:16.0pt;line-height:150%;font-family:"Times New Roman",serif'>Legger
                    Nilai</span></b></p>

        <p class=MsoNormal><span
                style='font-size:12.0pt;line-height:107%;font-family:
"Times New Roman",serif'>B.Keterampilan</span>
        </p>

        <p class=MsoNormal><span
                style='font-size:12.0pt;line-height:107%;font-family:
"Times New Roman",serif'>Kriteria Ketuntasan
                Minimal = {{ $kkm->kkm }}</span></p>



        <table id="datatable1" class="table table-sm"
            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
            <thead>

                <tr>
                    <th style="width:40px; border: 2px solid black; text-align: center; font-weight: bold;font-size:10.0pt; font-family:"Times
                        New Roman"">
                        No</th>
                    <th style="width:100px; border: 2px solid black; text-align: center;font-weight: bold; font-size:10.0pt; font-family:"Times
                        New Roman"">
                        Nama</th>
                    <th style="width:100px; border: 2px solid black; text-align: center; font-weight: bold;font-size:10.0pt; font-family:"Times
                        New Roman"">
                        Nisn</th>
                    <th style="width:40px; border: 2px solid black; text-align: center;font-weight: bold;font-size:10.0pt; font-family:"Times
                        New Roman"">
                        JK</th>
                    @foreach ($seksi as $key => $item)
                        <th style="width:50px; border: 2px solid black; text-align: center;font-weight: bold;font-size:10.0pt; font-family:"Times
                            New Roman"">
                            {{ $item->jadwalmapels->pengampus->mapels->kode_mapel }}
                        </th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($rombelsiswa as $key => $siswa)
                    <tr>
                        <td style="width:40px; border: 2px solid black; text-align: center;font-size:10.0pt; font-family:"Times
                            New Roman"">
                            {{ $key + 1 }}</td>
                        <td style="width:250px; border: 2px solid black;text-transform: capitalize;font-size:10.0pt; font-family:"Times
                            New Roman"">
                            {{ $siswa->siswas->nama }}
                        </td>
                        <td style="width:100px; border: 2px solid black;font-size:10.0pt; font-family:"Times New
                            Roman"">{{ $siswa->siswas->nisn }}
                        </td>
                        <td style="width:40px; border: 2px solid black; text-align: center;font-size:10.0pt; font-family:"Times
                            New Roman"">
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

                            <td style="width:50px; border: 2px solid black; text-align: center;font-size:10.0pt; font-family:"Times
                                New Roman"">
                                {{ $nilaiketerampilan_bulat }}
                            </td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>





        <p class=MsoNormal>&nbsp;</p>

        <p class=MsoNormal>&nbsp;</p>

        <table class=MsoTableGrid border=0 cellspacing=0 cellpadding=0 style='border-collapse:collapse;border:none'>
            <tr style='height:93.75pt'>
                <td width=727 valign=top style='width:545.5pt;padding:0cm 5.4pt 0cm 5.4pt;
  height:93.75pt'>
                    <p class=MsoNormal style='margin-bottom:0cm;line-height:normal'>Mengetahui </p>
                    <p class=MsoNormal style='margin-bottom:0cm;line-height:normal'>Kepala
                        Madrasah</p>
                    <p class=MsoNormal style='margin-bottom:0cm;line-height:normal'>&nbsp;</p>
                    <p class=MsoNormal style='margin-bottom:0cm;line-height:normal'>&nbsp;</p>
                    <p class=MsoNormal style='margin-bottom:0cm;line-height:normal'>&nbsp;</p>
                    <p class=MsoNormal style='margin-bottom:0cm;line-height:normal'>&nbsp;</p>
                    <p class=MsoNormal style='margin-bottom:0cm;line-height:normal' class="uppercase-text">
                        {{ $user->name }}</p>
                </td>
                <td width=299 valign=top style='width:223.9pt;padding:0cm 5.4pt 0cm 5.4pt;
  height:93.75pt'>
                    <p class=MsoNormal style='margin-bottom:0cm;line-height:normal'>Padang,
                        {{ $tanggalSaatIni->format('d ') . $bulanIndonesia[$tanggalSaatIni->month - 1] . $tanggalSaatIni->format(' Y') }}
                    </p>
                    <p class=MsoNormal style='margin-bottom:0cm;line-height:normal'>Mengetahui </p>
                    <p class=MsoNormal style='margin-bottom:0cm;line-height:normal'>Wali Kelas</p>
                    <p class=MsoNormal style='margin-bottom:0cm;line-height:normal'>&nbsp;</p>
                    <p class=MsoNormal style='margin-bottom:0cm;line-height:normal'>&nbsp;</p>
                    <p class=MsoNormal style='margin-bottom:0cm;line-height:normal'>&nbsp;</p>

                    <p class=MsoNormal style='margin-bottom:0cm;line-height:normal'class="uppercase-text">
                        {{ $walas->nama }}</p>
                </td>
            </tr>
        </table>

        <p class=MsoNormal>&nbsp;</p>

    </div>

</body>

</html>
