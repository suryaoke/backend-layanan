@extends('admin.admin_master')
@section('admin')
    <div class="page-content mt-4">
        <div class="container-fluid">
            <div class="row">

                <div class="col-12">
                    <ul class="nav nav-boxed-tabs" role="tablist">

                        <li id="example-5-tab" class="nav-item flex-1" role="presentation"> <button
                                class="nav-link w-full py-2 active" data-tw-toggle="pill" data-tw-target="#example-tab-5"
                                type="button" role="tab" aria-controls="example-tab-3" aria-selected="true"> HOME
                            </button> </li>
                        <li id="example-5-tab" class="nav-item flex-1" role="presentation"> <button
                                class="nav-link w-full py-2" data-tw-toggle="pill" data-tw-target="#example-tab-6"
                                type="button" role="tab" aria-controls="example-tab-4" aria-selected="false">
                                NILAI PENGETAHUAN </button> </li>
                        <li id="example-5-tab" class="nav-item flex-1" role="presentation"> <button
                                class="nav-link w-full py-2" data-tw-toggle="pill" data-tw-target="#example-tab-7"
                                type="button" role="tab" aria-controls="example-tab-5" aria-selected="false">
                                NILAI KETERAMPILAN </button> </li>
                    </ul>
                </div>
            </div>
        </div>

    </div>

    <div class="overflow-x-auto">
        <div class="tab-content mt-8">
            <div id="example-tab-5" class="tab-pane leading-relaxed active" role="tabpanel" aria-labelledby="example-5-tab">

                <div class="grid grid-cols-12 gap-6 mb-2">
                    <!-- BEGIN: FAQ Menu -->
                    <div class="intro-y col-span-12 lg:col-span-4 xl:col-span-3 ">
                        <div class="intro-y box mt-4 lg:mt-0">
                            <div class="relative flex items-center p-5">
                                <div class="ml-2">
                                    <img style="width:145px; height:155px" alt="Midone - HTML Admin Template"
                                        src=" {{ !empty($dataseksi->jadwalmapels->pengampus->gurus->users->profile_image) ? url('uploads/admin_images/' . $dataseksi->jadwalmapels->pengampus->gurus->users->profile_image) : url('backend/dist/images/profile-user.png') }}">
                                </div>

                            </div>

                            <div class="p-1 border-t ml-4 border-slate-200/60 dark:border-darkmode-400">
                                <div class="ml-4"><a class="flex ml-8" href=""> Wali Kelas</a></div>

                                <div class="ml-6"> <a class="flex ml-8 " href="">
                                        {{ $dataseksi->jadwalmapels->pengampus->kelass->tingkat }}
                                        {{ $dataseksi->jadwalmapels->pengampus->kelass->nama }}
                                        {{ $dataseksi->jadwalmapels->pengampus->kelass->jurusans->nama }} </a>
                                </div>
                                <a class="flex items-center  mb-2 ml-8" href=""> <i data-lucide="user"
                                        class="w-4 h-4 mr-2"></i>
                                    <strong>{{ $dataseksi->rombels->walass->gurus->nama }}</strong></a>


                            </div>

                        </div>
                    </div>
                    <!-- END: FAQ Menu -->
                    <!-- BEGIN: FAQ Content -->


                    <div class="intro-y col-span-12 lg:col-span-8 xl:col-span-9 mb-2">
                        <div class="intro-y box lg:mt-4">
                            <div class="mb-4 flex items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                                <h2 class="font-medium text-base mr-auto">
                                    Rincian Kelas
                                </h2>
                            </div>
                            <div id="faq-accordion-1" class="accordion accordion-boxed p-5">

                                <table class="table">
                                    <thead>

                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="font-medium whitespace-nowrap">Mata Pelajaran</div>
                                            </td>
                                            <td>
                                                {{ $dataseksi->jadwalmapels->pengampus->mapels->nama }}</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="font-medium whitespace-nowrap">Jumlah Siswa</div>
                                            </td>
                                            <td>
                                                @php
                                                    $siswa = App\Models\Rombelsiswa::where(
                                                        'id_rombel',
                                                        $dataseksi->id_rombel,
                                                    )->count();
                                                @endphp
                                                {{ $siswa }}


                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="font-medium whitespace-nowrap">Tahun Ajar</div>
                                            </td>
                                            <td> {{ $dataseksi->semesters->semester }} / {{ $dataseksi->semesters->tahun }}
                                            </td>
                                        </tr>
                                    </tbody>

                                </table>

                                <div class="mb-4"></div>

                            </div>
                        </div>

                    </div>

                    <div class="intro-y  xl:col-span-6 mb-2">
                        <div class="intro-y box lg:mt-2">
                            <div class=" flex items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                                <h2 class="font-medium text-base mr-auto">
                                    Kriteria Ketuntasan Minimal (KKM)
                                </h2>
                            </div>
                            <div id="faq-accordion-1" class="accordion accordion-boxed p-5">

                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th style="white-space: nowrap;">Predikat</th>
                                            <th style="white-space: nowrap;">Nilai Minimum</th>
                                            <th style="white-space: nowrap;">Nilai Maksimum</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $kkm = App\Models\Kkm::where(
                                                'id_kelas',
                                                $dataseksi->rombels->kelass->tingkat,
                                            )->first();
                                            $d = $kkm->kkm - 1;
                                            $c = $kkm->kkm;
                                            $c1 = $c + 6;
                                            $b = $c1 + 1;
                                            $b1 = $b + 6;
                                            $a = $b1 + 1;
                                            $a1 = $a + 6;

                                        @endphp

                                        <tr>
                                            <td>
                                                <div class="font-medium whitespace-nowrap ml-4">A</div>
                                            </td>
                                            <td>
                                                <div class="font-medium whitespace-nowrap ml-8"> {{ $a }} </div>
                                            </td>
                                            <td>
                                                <div class="font-medium whitespace-nowrap ml-8">
                                                    {{ $a1 }}
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="font-medium whitespace-nowrap ml-4">B</div>
                                            </td>
                                            <td>
                                                <div class="font-medium whitespace-nowrap ml-8"> {{ $b }} </div>
                                            </td>
                                            <td>
                                                <div class="font-medium whitespace-nowrap ml-8">
                                                    {{ $b1 }}
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="font-medium whitespace-nowrap ml-4">C</div>
                                            </td>
                                            <td>
                                                <div class="font-medium whitespace-nowrap ml-8"> {{ $c }} </div>
                                            </td>
                                            <td>
                                                <div class="font-medium whitespace-nowrap ml-8">
                                                    {{ $c1 }}
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="font-medium whitespace-nowrap ml-4">D</div>
                                            </td>
                                            <td>
                                                <div class="font-medium whitespace-nowrap ml-8">0</div>
                                            </td>
                                            <td>
                                                <div class="font-medium whitespace-nowrap ml-8">
                                                    {{ $d }}
                                                </div>
                                            </td>
                                        </tr>

                                    </tbody>

                                </table>

                                <div class="mb-4"></div>

                            </div>
                        </div>

                    </div>
                    <!-- END: FAQ Content -->
                </div>
            </div>
            @php
                $userId = Auth::user()->id;
                $seksiid = App\Models\Seksi::join('jadwalmapels', 'jadwalmapels.id', '=', 'seksis.id_jadwal')
                    ->join('pengampus', 'pengampus.id', '=', 'jadwalmapels.id_pengampu')
                    ->join('gurus', 'gurus.id', '=', 'pengampus.id_guru')
                    ->join('kelas', 'kelas.id', '=', 'pengampus.kelas')
                    ->join('mapels', 'mapels.id', '=', 'pengampus.id_mapel')
                    ->where('mapels.id', '=', $dataseksi->jadwalmapels->pengampus->mapels->id)
                    ->where('kelas.id', '=', $dataseksi->jadwalmapels->pengampus->kelass->id)
                    ->where('gurus.id_user', '=', $userId)
                    ->select('seksis.*') // Memilih semua kolom dari tabel catata_walas
                    ->get();
            @endphp

            {{--  Nilai Pengetahuan  --}}
            <div id="example-tab-6" class="tab-pane leading-relaxed" role="tabpanel" aria-labelledby="example-6-tab">
                <div class="flex ml-1">

                    <div class="flex-1 mr-1">
                        <div class="form-group">
                            <input type="text" name="searchnama" class="form-control" placeholder="Nama"
                                value="{{ request('searchnama') }}">

                        </div>
                    </div>
                    <div class="flex-1 mr-1">
                        <div class="form-group">
                            <input type="text" name="searchnisn" class="form-control" placeholder="Nisn"
                                value="{{ request('searchnisn') }}">

                        </div>
                    </div>
                    <div class="flex-1 mr-1">
                        <div class="form-group">
                            <input type="text" name="searchjk" class="form-control" placeholder="Jk"
                                value="{{ request('searchjk') }}">
                        </div>
                    </div>
                    <div class="flex-1 mr-1">
                        <div class="form-group">
                            <select id="selectRoute" class="form-select w-full">
                                <option value=""> Pilih Tahun Ajar
                                </option>
                                @foreach ($seksiid as $seksiid)
                                    <option value="{{ route('nilai.alll', $seksiid->id) }}">
                                        {{ $seksiid->semesters->semester }} - {{ $seksiid->semesters->tahun }}
                                    </option>
                                @endforeach
                            </select>

                            <script>
                                document.getElementById("selectRoute").addEventListener("change", function() {
                                    var selectedRoute = this.value;
                                    if (selectedRoute) {
                                        window.location.href = selectedRoute;
                                    }
                                });
                            </script>
                        </div>
                    </div>
                </div>

                <div class="flex mb-4 mt-4">

                    <a class="btn btn-pending btn-block mr-1" data-tw-toggle="modal"
                        data-tw-target="#excel-pengetahuan-modal-preview">
                        <span class="glyphicon glyphicon-download"></span> <i data-lucide="download"
                            class="w-5 h-5"></i>&nbsp;Export
                    </a>
                    <a href="{{ route('nilai.pengetahuan.harian', $dataseksi->id) }}"
                        class="btn btn-warning btn-block mr-1"> <span class="glyphicon glyphicon-download mr-1"></span>
                        </span>
                        <i data-lucide="file" class="w-5 h-5"></i>&nbsp;Harian</a>
                    <a href="{{ route('nilai.pengetahuan.akhir', $dataseksi->id) }}"
                        class="btn btn-primary btn-block mr-1"> <span class="glyphicon glyphicon-download mr-1"></span>
                        </span>
                        <i data-lucide="file" class="w-5 h-5"></i>&nbsp;
                        PAS</a>
                    @php
                        $status = App\Models\Nilai::where('id_seksi', $dataseksi->id)
                            ->whereIn('type_nilai', [1, 2])
                            ->first();

                    @endphp
                    @if ($status == null || $status->status == '0')
                        <a class="btn btn-success btn-block mr-1" data-tw-toggle="modal"
                            data-tw-target="#kirim-pengetahuan-modal-preview">
                            <span class="glyphicon glyphicon-download"></span> </span> <i data-lucide="send"
                                class="w-5 h-5"></i>&nbsp;Kirim</a>
                    @elseif ($status->status == '1')
                        <a class="btn btn-danger btn-block mr-1" data-tw-toggle="modal"
                            data-tw-target="#batal-kirim-pengetahuan-modal-preview">
                            <span class="glyphicon glyphicon-download"></span> </span> <i data-lucide="x"
                                class="w-5 h-5"></i>&nbsp;Batal Kirim</a>
                    @elseif ($status->status == '2')
                        <a class="btn btn-primary btn-block mr-1">
                            <span class="glyphicon glyphicon-download"></span> </span> <i data-lucide="lock"
                                class="w-5 h-5"></i>&nbsp;Nilai Dikunci</a>
                    @endif


                </div>
                <div class="mt-4 mb-4">
                    Semester {{ $dataseksi['semesters']['semester'] }}
                    Tahun Ajar {{ $dataseksi['semesters']['tahun'] }}
                </div>


                <table id="datatable" class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="whitespace-nowrap">No</th>
                            <th class="whitespace-nowrap">NISN</th>
                            <th class="whitespace-nowrap">Nama</th>
                            <th class="whitespace-nowrap">Jk</th>
                            <th class="whitespace-nowrap">Kelas</th>
                            <th class="whitespace-nowrap">Harian</th>
                            <th class="whitespace-nowrap">PAS</th>
                            <th class="whitespace-nowrap">Rapor</th>
                            <th class="whitespace-nowrap">Predikat</th>
                            <th class="whitespace-nowrap">Deskripsi</th>


                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $rombelsiswa = App\Models\Rombelsiswa::where('id_rombel', $dataseksi->id_rombel)->get();
                        @endphp
                        @foreach ($rombelsiswa as $key => $item)
                            @php
                                $nilaiharian = App\Models\Nilai::where('id_rombelsiswa', $item->id)
                                    ->where('type_nilai', 1)
                                    ->where('id_seksi', $dataseksi->id)
                                    ->avg('nilai_pengetahuan');

                                $nilaiharian_bulat = round($nilaiharian);

                                // Gunakan nilaiharian_bulat untuk penggunaan selanjutnya

                                $nilaipas = App\Models\Nilai::where('id_rombelsiswa', $item->id)
                                    ->where('type_nilai', 2)
                                    ->where('id_seksi', $dataseksi->id)
                                    ->first();

                                $rapor = ($nilaiharian_bulat + optional($nilaipas)->nilai_pengetahuan_akhir) / 2;

                                $rapor_bulat = round($rapor);
                                $kkm = App\Models\Kkm::where('id_kelas', $dataseksi->rombels->kelass->tingkat)->first();

                                $c = $kkm->kkm + 6;
                                $b = $c + 6;
                                $a = $b + 6;

                                if ($rapor_bulat < $kkm->kkm) {
                                    $predikat = 'D';
                                } elseif ($rapor_bulat < $c) {
                                    $predikat = 'C';
                                } elseif ($rapor_bulat < $b) {
                                    $predikat = 'B';
                                } elseif ($rapor_bulat < $a) {
                                    $predikat = 'A';
                                } else {
                                    $predikat = '-';
                                }
                            @endphp
                            <tr>
                                <td class="whitespace-nowrap">{{ $key + 1 }}</td>
                                <td class="whitespace-nowrap"> {{ $item->siswas->nisn }} </td>
                                <td class="whitespace-nowrap"> {{ $item->siswas->nama }} </td>
                                <td class="whitespace-nowrap"> {{ $item->siswas->jk }} </td>
                                <td class="whitespace-nowrap"> {{ $item->rombels->kelass->tingkat }}
                                    {{ $item->rombels->kelass->nama }}
                                    {{ $item->rombels->kelass->jurusans->nama }}</td>
                                <td class="whitespace-nowrap">

                                    {{ $nilaiharian_bulat }}


                                </td>
                                <td class="whitespace-nowrap">
                                    @if ($nilaipas)
                                        {{ $nilaipas->nilai_pengetahuan_akhir }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="whitespace-nowrap"> {{ $rapor_bulat }} </td>
                                <td class="whitespace-nowrap"> {{ $predikat }} </td>
                                <td class="whitespace-nowrap"> {{ $item->siswas->jk }} </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        const searchNamaInput = document.querySelector('input[name="searchnama"]');
                        const searchNisnInput = document.querySelector('input[name="searchnisn"]');
                        const searchJkInput = document.querySelector('input[name="searchjk"]');
                        const tableRows = document.querySelectorAll("#datatable tbody tr");

                        function filterTable() {
                            const searchNama = searchNamaInput.value.toLowerCase();
                            const searchNisn = searchNisnInput.value.toLowerCase();
                            const searchJk = searchJkInput.value.toLowerCase();

                            tableRows.forEach(row => {
                                const nama = row.cells[2].textContent.toLowerCase();
                                const nisn = row.cells[1].textContent.toLowerCase();
                                const jk = row.cells[3].textContent.toLowerCase();

                                const namaMatch = nama.includes(searchNama);
                                const nisnMatch = nisn.includes(searchNisn);
                                const jkMatch = jk.includes(searchJk);

                                if (namaMatch && nisnMatch && jkMatch) {
                                    row.style.display = "";
                                } else {
                                    row.style.display = "none";
                                }
                            });
                        }

                        searchNamaInput.addEventListener("input", filterTable);
                        searchNisnInput.addEventListener("input", filterTable);
                        searchJkInput.addEventListener("input", filterTable);
                    });
                </script>
            </div>


            {{--  Nilai Keterampilan  --}}
            @php
                $userId = Auth::user()->id;
                $seksiid = App\Models\Seksi::join('jadwalmapels', 'jadwalmapels.id', '=', 'seksis.id_jadwal')
                    ->join('pengampus', 'pengampus.id', '=', 'jadwalmapels.id_pengampu')
                    ->join('gurus', 'gurus.id', '=', 'pengampus.id_guru')
                    ->join('kelas', 'kelas.id', '=', 'pengampus.kelas')
                    ->join('mapels', 'mapels.id', '=', 'pengampus.id_mapel')
                    ->where('mapels.id', '=', $dataseksi->jadwalmapels->pengampus->mapels->id)
                    ->where('kelas.id', '=', $dataseksi->jadwalmapels->pengampus->kelass->id)
                    ->where('gurus.id_user', '=', $userId)
                    ->select('seksis.*') // Memilih semua kolom dari tabel catata_walas
                    ->get();
            @endphp
            <div id="example-tab-7" class="tab-pane leading-relaxed" role="tabpanel" aria-labelledby="example-7-tab">
                <div class="flex ml-1">

                    <div class="flex-1 mr-1">
                        <div class="form-group">
                            <input type="text" name="searchnama1" class="form-control" placeholder="Nama"
                                value="{{ request('searchnama1') }}">

                        </div>
                    </div>
                    <div class="flex-1 mr-1">
                        <div class="form-group">
                            <input type="text" name="searchnisn1" class="form-control" placeholder="Nisn"
                                value="{{ request('searchnisn1') }}">

                        </div>
                    </div>
                    <div class="flex-1 mr-1">
                        <div class="form-group">
                            <input type="text" name="searchjk1" class="form-control" placeholder="Jk"
                                value="{{ request('searchjk1') }}">
                        </div>
                    </div>
                    <div class="flex-1 mr-1">
                        <div class="form-group">
                            <select id="selectRoutee" class="form-select w-full">
                                <option value=""> Pilih Tahun Ajar
                                </option>
                                @foreach ($seksiid as $seksiid)
                                    <option value="{{ route('nilai.alll', $seksiid->id) }}">
                                        {{ $seksiid->semesters->semester }} - {{ $seksiid->semesters->tahun }}
                                    </option>
                                @endforeach
                            </select>

                            <script>
                                document.getElementById("selectRoutee").addEventListener("change", function() {
                                    var selectedRoutee = this.value;
                                    if (selectedRoutee) {
                                        window.location.href = selectedRoutee;
                                    }
                                });
                            </script>
                        </div>
                    </div>
                </div>

                <div class="flex mb-4 mt-4">

                    <a class="btn btn-pending btn-block mr-1" data-tw-toggle="modal"
                        data-tw-target="#excel-keterampilan-modal-preview">
                        <span class="glyphicon glyphicon-download"></span> <i data-lucide="download"
                            class="w-5 h-5"></i>&nbsp;Export
                    </a>
                    <a href="{{ route('nilai.keterampilan.portofolio', $dataseksi->id) }}"
                        class="btn btn-warning btn-block mr-1"> <span class="glyphicon glyphicon-download mr-1"></span>
                        </span>
                        <i data-lucide="file" class="w-5 h-5"></i>&nbsp;Portofolio</a>
                    <a href="{{ route('nilai.keterampilan.proyek', $dataseksi->id) }}"
                        class="btn btn-primary btn-block mr-1"> <span class="glyphicon glyphicon-download mr-1"></span>
                        </span>
                        <i data-lucide="file" class="w-5 h-5"></i>&nbsp;
                        Proyek</a>
                    <a href="{{ route('nilai.keterampilan.unjukkerja', $dataseksi->id) }}"
                        class="btn btn-danger btn-block mr-1"> <span class="glyphicon glyphicon-download mr-1"></span>
                        </span>
                        <i data-lucide="file" class="w-5 h-5"></i>&nbsp;
                        Unjuk Kerja</a>

                    @php
                        $statusketerampilan = App\Models\Nilai::where('id_seksi', $dataseksi->id)
                            ->where('type_nilai', 3)
                            ->first();

                    @endphp
                    @if ($statusketerampilan == null || $statusketerampilan->status == '0')
                        <a class="btn btn-success btn-block mr-1" data-tw-toggle="modal"
                            data-tw-target="#kirim-keterampilan-modal-preview">
                            <span class="glyphicon glyphicon-download"></span> </span> <i data-lucide="send"
                                class="w-5 h-5"></i>&nbsp;Kirim</a>
                    @elseif ($statusketerampilan->status == '1')
                        <a class="btn btn-danger btn-block mr-1" data-tw-toggle="modal"
                            data-tw-target="#batal-kirim-keterampilan-modal-preview">
                            <span class="glyphicon glyphicon-download"></span> </span> <i data-lucide="x"
                                class="w-5 h-5"></i>&nbsp;Batal Kirim</a>
                    @elseif ($statusketerampilan->status == '2')
                        <a class="btn btn-primary btn-block mr-1">
                            <span class="glyphicon glyphicon-download"></span> </span> <i data-lucide="lock"
                                class="w-5 h-5"></i>&nbsp;Nilai Dikunci</a>
                    @endif

                </div>
                <div class="mt-4 mb-4">
                    Semester {{ $dataseksi['semesters']['semester'] }}
                    Tahun Ajar {{ $dataseksi['semesters']['tahun'] }}
                </div>


                <table id="datatable1" class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="whitespace-nowrap">No</th>
                            <th class="whitespace-nowrap">NISN</th>
                            <th class="whitespace-nowrap">Nama</th>
                            <th class="whitespace-nowrap">Jk</th>
                            <th class="whitespace-nowrap">Kelas</th>
                            <th class="whitespace-nowrap">Rapor</th>
                            <th class="whitespace-nowrap">Predikat</th>
                            <th class="whitespace-nowrap">Deskripsi</th>


                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($rombelsiswa as $key => $item)
                            @php

                                $nilaiketerampilan = App\Models\Nilai::where('id_rombelsiswa', $item->id)
                                    ->where('type_nilai', 3)
                                    ->where('id_seksi', $dataseksi->id)
                                    ->avg('nilai_keterampilan');

                                $nilaiketerampilan_bulat = round($nilaiketerampilan);
                                $kkm1 = App\Models\Kkm::where('id_kelas', $item->rombels->kelass->tingkat)->first();

                                $c1 = $kkm1->kkm + 6;
                                $b1 = $c1 + 6;
                                $a1 = $b1 + 6;

                                if ($nilaiketerampilan_bulat < $kkm1->kkm) {
                                    $predikat1 = 'D';
                                } elseif ($nilaiketerampilan_bulat < $c1) {
                                    $predikat1 = 'C';
                                } elseif ($nilaiketerampilan_bulat < $b1) {
                                    $predikat1 = 'B';
                                } elseif ($nilaiketerampilan_bulat < $a1) {
                                    $predikat1 = 'A';
                                } else {
                                    $predikat1 = '-';
                                }

                            @endphp
                            <tr>
                                <td class="whitespace-nowrap">{{ $key + 1 }}</td>
                                <td class="whitespace-nowrap"> {{ $item->siswas->nisn }} </td>
                                <td class="whitespace-nowrap"> {{ $item->siswas->nama }} </td>
                                <td class="whitespace-nowrap"> {{ $item->siswas->jk }} </td>
                                <td class="whitespace-nowrap"> {{ $item->rombels->kelass->tingkat }}
                                    {{ $item->rombels->kelass->nama }}
                                    {{ $item->rombels->kelass->jurusans->nama }}</td>
                                <td class="whitespace-nowrap">

                                    {{ $nilaiketerampilan_bulat }}


                                </td>
                                <td class="whitespace-nowrap">
                                    {{ $predikat1 }}
                                </td>
                                <td class="whitespace-nowrap">
                                    -
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    const searchnama1Input = document.querySelector('input[name="searchnama1"]');
                    const searchnisn1Input = document.querySelector('input[name="searchnisn1"]');
                    const searchjk1Input = document.querySelector('input[name="searchjk1"]');
                    const tableRows = document.querySelectorAll("#datatable1 tbody tr");

                    function filterTable() {
                        const searchnama1 = searchnama1Input.value.toLowerCase();
                        const searchnisn1 = searchnisn1Input.value.toLowerCase();
                        const searchjk1 = searchjk1Input.value.toLowerCase();

                        tableRows.forEach(row => {
                            const nama = row.cells[2].textContent.toLowerCase();
                            const nisn = row.cells[1].textContent.toLowerCase();
                            const jk = row.cells[3].textContent.toLowerCase();

                            const namaMatch = nama.includes(searchnama1);
                            const nisnMatch = nisn.includes(searchnisn1);
                            const jkMatch = jk.includes(searchjk1);

                            if (namaMatch && nisnMatch && jkMatch) {
                                row.style.display = "";
                            } else {
                                row.style.display = "none";
                            }
                        });
                    }

                    searchnama1Input.addEventListener("input", filterTable);
                    searchnisn1Input.addEventListener("input", filterTable);
                    searchjk1Input.addEventListener("input", filterTable);
                });
            </script>

        </div>
    </div>







    <!-- Masukkan jQuery sebelum kode JavaScript Anda -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Kode JavaScript Anda -->
    <script type="text/javascript">
        $('#myAction').change(function() {
            var action = $(this).val();
            window.location = action;
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#datatable1').DataTable();
        });
    </script>


    {{--   export pengetahuan  --}}

    <div id="excel-pengetahuan-modal-preview" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- BEGIN: Modal Header -->
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto">Export Nilai Pengetahuan</h2>
                    <div class="dropdown sm:hidden"> <a class="dropdown-toggle w-5 h-5 block" href="javascript:;"
                            aria-expanded="false" data-tw-toggle="dropdown"> <i data-lucide="more-horizontal"
                                class="w-5 h-5 text-slate-500"></i> </a>
                        <div class="dropdown-menu w-40">
                        </div>
                    </div>
                </div> <!-- END: Modal Header -->
                <!-- BEGIN: Modal Body -->

                <form method="post" action="{{ route('pengetahuan.excel') }}">
                    @csrf
                    <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">


                        <div class="col-span-12 sm:col-span-6"> <label for="edit-jam">Pilih Tahun Ajar </label>
                            <select name="id" id="tahun" class="form-select w-full" required>

                                @php
                                    $userId = Auth::user()->id;
                                    $seksiids = App\Models\Seksi::join(
                                        'jadwalmapels',
                                        'jadwalmapels.id',
                                        '=',
                                        'seksis.id_jadwal',
                                    )
                                        ->join('pengampus', 'pengampus.id', '=', 'jadwalmapels.id_pengampu')
                                        ->join('gurus', 'gurus.id', '=', 'pengampus.id_guru')
                                        ->join('kelas', 'kelas.id', '=', 'pengampus.kelas')
                                        ->join('mapels', 'mapels.id', '=', 'pengampus.id_mapel')
                                        ->where('mapels.id', '=', $dataseksi->jadwalmapels->pengampus->mapels->id)
                                        ->where('kelas.id', '=', $dataseksi->jadwalmapels->pengampus->kelass->id)
                                        ->where('gurus.id_user', '=', $userId)
                                        ->select('seksis.*') // Memilih semua kolom dari tabel catata_walas
                                        ->get();
                                @endphp

                                @foreach ($seksiids as $item)
                                    <option value="{{ $item->id }}">
                                        {{ $item->semesters->semester }} - {{ $item->semesters->tahun }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>


                    <!-- BEGIN: Modal Footer -->
                    <div class="modal-footer">
                        <a href="{{ route('nilai.all', $dataseksi->id) }}"
                            class="btn btn-outline-secondary w-20 mr-1">Cancel</a>
                        <button type="submit" class="btn btn-primary w-20">Export</button>
                </form>
            </div>
        </div>
    </div>


    {{--   export keterampilan  --}}

    <div id="excel-keterampilan-modal-preview" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- BEGIN: Modal Header -->
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto">Export Nilai Keterampilan</h2>
                    <div class="dropdown sm:hidden"> <a class="dropdown-toggle w-5 h-5 block" href="javascript:;"
                            aria-expanded="false" data-tw-toggle="dropdown"> <i data-lucide="more-horizontal"
                                class="w-5 h-5 text-slate-500"></i> </a>
                        <div class="dropdown-menu w-40">
                        </div>
                    </div>
                </div> <!-- END: Modal Header -->
                <!-- BEGIN: Modal Body -->

                <form method="post" action="{{ route('keterampilan.excel') }}">
                    @csrf
                    <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">


                        <div class="col-span-12 sm:col-span-6"> <label for="edit-jam">Pilih Tahun Ajar </label>
                            <select name="id" id="tahun" class="form-select w-full" required>

                                @php
                                    $userId = Auth::user()->id;
                                    $seksiids = App\Models\Seksi::join(
                                        'jadwalmapels',
                                        'jadwalmapels.id',
                                        '=',
                                        'seksis.id_jadwal',
                                    )
                                        ->join('pengampus', 'pengampus.id', '=', 'jadwalmapels.id_pengampu')
                                        ->join('gurus', 'gurus.id', '=', 'pengampus.id_guru')
                                        ->join('kelas', 'kelas.id', '=', 'pengampus.kelas')
                                        ->join('mapels', 'mapels.id', '=', 'pengampus.id_mapel')
                                        ->where('mapels.id', '=', $dataseksi->jadwalmapels->pengampus->mapels->id)
                                        ->where('kelas.id', '=', $dataseksi->jadwalmapels->pengampus->kelass->id)
                                        ->where('gurus.id_user', '=', $userId)
                                        ->select('seksis.*') // Memilih semua kolom dari tabel catata_walas
                                        ->get();
                                @endphp

                                @foreach ($seksiids as $item)
                                    <option value="{{ $item->id }}">
                                        {{ $item->semesters->semester }} - {{ $item->semesters->tahun }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>


                    <!-- BEGIN: Modal Footer -->
                    <div class="modal-footer">
                        <a href="{{ route('nilai.all', $dataseksi->id) }}"
                            class="btn btn-outline-secondary w-20 mr-1">Cancel</a>
                        <button type="submit" class="btn btn-primary w-20">Export</button>
                </form>
            </div>
        </div>
    </div>



    <!-- BEGIN: Modal Kirim NIlai  Pengetahuan-->
    <div id="kirim-pengetahuan-modal-preview" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form method="post" action="{{ route('kirim.nilai.pengetahuan') }}">
                @csrf
                <div class="modal-content">
                    <div class="modal-body p-0">
                        <div class="p-5 text-center"> <i data-lucide="check-circle"
                                class="w-16 h-16 text-success mx-auto mt-3"></i>
                            <div class="text-3xl mt-5">Kirim Nilai Pengetahuan </div>

                        </div>
                        <input name="id" type="hidden" value="{{ $dataseksi->id }}">
                        @php
                            $phValues = App\Models\Nilai::select('ph')
                                ->where('id_seksi', $dataseksi->id)
                                ->where('type_nilai', 1)
                                ->groupBy('ph')
                                ->get();
                            $pas = App\Models\Nilai::select('type_nilai')
                                ->where('id_seksi', $dataseksi->id)
                                ->where('type_nilai', 2)
                                ->count();
                        @endphp


                        <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                            <div class="col-span-12 sm:col-span-12 text-center"> <label for="modal-form-1"
                                    class="form-label">Nilai Harian : @foreach ($phValues as $phItem)
                                        Ph.{{ $phItem->ph }}
                                    @endforeach
                                </label> </div>
                            <div class="col-span-12 sm:col-span-12 text-center"> <label for="modal-form-2"
                                    class="form-label">Nilai PAS : {{ $pas > 0 ? '1' : '0' }} </label> </div>

                        </div>

                        <div class="modal-footer">
                            <a href="{{ route('nilai.all', $dataseksi->id) }}"
                                class="btn btn-outline-secondary w-20 mr-1">Cancel</a>
                            @if ($phValues->isNotEmpty() && $pas > 0)
                                <button type="submit" class="btn btn-primary w-20">Kirim</button>
                            @endif

                        </div>

                    </div>
                </div>

            </form>
        </div>
    </div>


    <!-- BEGIN: Modal Kirim Nilai  Keterampilan-->
    <div id="kirim-keterampilan-modal-preview" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form method="post" action="{{ route('kirim.nilai.keterampilan') }}">
                @csrf
                <div class="modal-content">
                    <div class="modal-body p-0">
                        <div class="p-5 text-center"> <i data-lucide="check-circle"
                                class="w-16 h-16 text-success mx-auto mt-3"></i>
                            <div class="text-3xl mt-5">Kirim Nilai Keterampilam </div>

                        </div>
                        <input name="id" type="hidden" value="{{ $dataseksi->id }}">
                        @php

                            $portofolio = App\Models\Nilai::select('kd')
                                ->where('id_seksi', $dataseksi->id)
                                ->where('type_nilai', 3)
                                ->where('type_keterampilan', 1)
                                ->groupBy('kd')
                                ->get();

                            $proyek = App\Models\Nilai::select('kd')
                                ->where('id_seksi', $dataseksi->id)
                                ->where('type_nilai', 3)
                                ->where('type_keterampilan', 2)
                                ->groupBy('kd')
                                ->get();

                            $unjukkerja = App\Models\Nilai::select('kd')
                                ->where('id_seksi', $dataseksi->id)
                                ->where('type_nilai', 3)
                                ->where('type_keterampilan', 3)
                                ->groupBy('kd')
                                ->get();

                        @endphp


                        <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                            <div class="col-span-12 sm:col-span-12 text-center"> <label for="modal-form-1"
                                    class="form-label">Nilai Portofolio : @foreach ($portofolio as $portofolioItem)
                                        KD.{{ $portofolioItem->kd }}
                                    @endforeach
                                </label> </div>
                            <div class="col-span-12 sm:col-span-12 text-center"> <label for="modal-form-2"
                                    class="form-label">Nilai Proyek : @foreach ($proyek as $proyekItem)
                                        KD.{{ $proyekItem->kd }}
                                    @endforeach </label> </div>

                            <div class="col-span-12 sm:col-span-12 text-center"> <label for="modal-form-2"
                                    class="form-label">Nilai Unjuk Kerja : @foreach ($unjukkerja as $unjukkerjaItem)
                                        KD.{{ $unjukkerjaItem->kd }}
                                    @endforeach </label> </div>

                        </div>

                        <div class="modal-footer">
                            <a href="{{ route('nilai.all', $dataseksi->id) }}"
                                class="btn btn-outline-secondary w-20 mr-1">Cancel</a>
                            @if ($portofolio->isNotEmpty() || $proyek->isNotEmpty() || $unjukkerja->isNotEmpty())
                                <button type="submit" class="btn btn-primary w-20">Kirim</button>
                            @endif

                        </div>

                    </div>
                </div>

            </form>
        </div>
    </div>

    <!-- BEGIN: Modal Batal Kirim NIlai  Pengetahuan-->
    <div id="batal-kirim-pengetahuan-modal-preview" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form method="post" action="{{ route('batal.kirim.nilai.pengetahuan') }}">
                @csrf
                <div class="modal-content">
                    <div class="modal-body p-0">
                        <div class="p-5 text-center"> <i data-lucide="x" class="w-16 h-16 text-danger mx-auto mt-3"></i>
                            <div class="text-3xl mt-5">Batal Kirim Nilai Pengetahuan </div>

                        </div>
                        <input name="id" type="hidden" value="{{ $dataseksi->id }}">




                        <div class="modal-footer">
                            <a href="{{ route('nilai.all', $dataseksi->id) }}"
                                class="btn btn-outline-secondary w-20 mr-1">Cancel</a>

                            <button type="submit" class="btn btn-primary w-30">Batal Kirim</button>


                        </div>

                    </div>
                </div>

            </form>
        </div>
    </div>

    <!-- BEGIN: Modal Batal Kirim NIlai  Keterampilan-->
    <div id="batal-kirim-keterampilan-modal-preview" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form method="post" action="{{ route('batal.kirim.nilai.keterampilan') }}">
                @csrf
                <div class="modal-content">
                    <div class="modal-body p-0">
                        <div class="p-5 text-center"> <i data-lucide="x" class="w-16 h-16 text-danger mx-auto mt-3"></i>
                            <div class="text-3xl mt-5">Batal Kirim Nilai Keterampilan </div>

                        </div>
                        <input name="id" type="hidden" value="{{ $dataseksi->id }}">


                        <div class="modal-footer">
                            <a href="{{ route('nilai.all', $dataseksi->id) }}"
                                class="btn btn-outline-secondary w-20 mr-1">Cancel</a>

                            <button type="submit" class="btn btn-primary w-30">Batal Kirim</button>


                        </div>

                    </div>
                </div>

            </form>
        </div>
    </div>
@endsection
