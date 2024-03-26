@extends('admin.admin_master')
@section('admin')
    <div class="page-content mt-4">
        <div class="container-fluid">
            <div class="row">

                <div class="col-12">
                    <ul class="nav nav-boxed-tabs" role="tablist">


                        <li id="example-5-tab" class="nav-item flex-1" role="presentation"> <button
                                class="nav-link w-full py-2 active" data-tw-toggle="pill" data-tw-target="#example-tab-6"
                                type="button" role="tab" aria-controls="example-tab-4" aria-selected="false">
                                NILAI KETERAMPILAN PROYEK </button> </li>

                    </ul>
                </div>
            </div>
        </div>

    </div>

    <div class="overflow-x-auto">
        <div class="tab-content mt-8">


            <div class="flex mb-4 mt-4">

                <a class="btn btn-danger btn-block mr-1" href="{{ route('nilai.alll', $dataseksi->id) }}">
                    <span class="glyphicon glyphicon-download"></span> <i data-lucide="arrow-left"
                        class="w-4 h-4"></i>&nbsp;Kembali
                </a>
                <a class="btn btn-pending btn-block mr-1" data-tw-toggle="modal" data-tw-target="#excel-modal-preview">
                    <span class="glyphicon glyphicon-download"></span> <i data-lucide="download"
                        class="w-5 h-5"></i>&nbsp;Export
                </a>
                @php
                    $status = App\Models\Nilai::where('id_seksi', $dataseksi->id)
                        ->where('type_nilai', 3)
                        ->where('type_keterampilan', 2)
                        ->first();

                @endphp
                @if ($status == null || $status->status == '0')
                    <a class="btn btn-success btn-block mr-1" data-tw-toggle="modal"
                        data-tw-target="#header1-footer-modal-preview">
                        <span class="glyphicon glyphicon-download"></span> </span> <i data-lucide="download"
                            class="w-5 h-5"></i>&nbsp;Upload</a>
                    <a data-tw-toggle="modal" data-tw-target="#nilai-footer-modal-preview"
                        class="btn btn-primary btn-block">
                        <span class="glyphicon glyphicon-download mr-1"></span> </span>
                        <i data-lucide="edit" class="w-5 h-5"></i>&nbsp;Nilai</a>
                @endif
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


                </div>

            </div>
            <div class="mb-4 mt-4">
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
                        @php
                            $kdValues = App\Models\Nilai::select('kd')
                                ->where('id_seksi', $dataseksi->id)
                                ->where('type_nilai', 3)
                                ->where('type_keterampilan', 2)
                                ->groupBy('kd')
                                ->get();
                        @endphp
                        @if ($kdValues->count() > 0)
                            @foreach ($kdValues as $kdItem)
                                <th class="whitespace-nowrap">KD {{ $kdItem->kd }}
                                    @if ($status == null || $status->status == '0')
                                        <div class="flex">
                                            <div class="mr-2">

                                                <a id="delete"
                                                    href="{{ route('nilai.keterampilan.proyek.delete', ['id' => $kdItem->kd, 'id_seksi' => $dataseksi->id]) }}">
                                                    <i data-lucide="trash" class="w-4 h-4 text-red-500"
                                                        style="color: red;"></i>
                                                </a>

                                            </div>
                                            <div>
                                                <a data-tw-toggle="modal"
                                                    data-tw-target="#edit-footer-modal-preview-{{ $kdItem->kd }}">
                                                    <i data-lucide="edit" class="w-4 h-4 text-blue-500"
                                                        style="color: green;"></i>
                                                </a>
                                            </div>
                                        </div>
                                    @endif

                                </th>
                            @endforeach
                        @else
                            <th class="whitespace-nowrap">KD</th>
                        @endif

                    </tr>
                </thead>
                <tbody>
                    @php
                        $rombelsiswa = App\Models\Rombelsiswa::where('id_rombel', $dataseksi->id_rombel)->get();
                    @endphp
                    @foreach ($rombelsiswa as $key => $item)
                        <tr>
                            <td class="whitespace-nowrap">{{ $key + 1 }}</td>
                            <td class="whitespace-nowrap">{{ $item->siswas->nisn }}</td>
                            <td class="whitespace-nowrap">{{ $item->siswas->nama }}</td>
                            <td class="whitespace-nowrap">{{ $item->siswas->jk }}</td>
                            <td class="whitespace-nowrap">
                                {{ $item->rombels->kelass->tingkat }}
                                {{ $item->rombels->kelass->nama }}
                                {{ $item->rombels->kelass->jurusans->nama }}
                            </td>

                            @if ($kdValues->count() > 0)
                                @foreach ($kdValues as $kdItem)
                                    <td class="whitespace-nowrap">
                                        @php
                                            $nilai = App\Models\Nilai::where('id_rombelsiswa', $item->id)
                                                ->where('id_seksi', $dataseksi->id)
                                                ->where('type_nilai', 3)
                                                ->where('type_keterampilan', 2)
                                                ->where('kd', $kdItem->kd)
                                                ->first();
                                        @endphp
                                        @if ($nilai)
                                            {{ $nilai->nilai_keterampilan }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                @endforeach
                            @else
                                <td class="whitespace-nowrap">-</td>
                            @endif
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

    <!-- BEGIN: Modal Toggle -->


    <!-- END: Modal Toggle --> <!-- BEGIN: Modal Content -->
    <div id="nilai-footer-modal-preview" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" style="max-width: 90vw; width: 55%;"> <!-- Menambahkan style langsung di sini -->
            <div class="modal-content">
                <!-- BEGIN: Modal Header -->
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto">Nilai Keterampilan Proyek</h2>
                </div>
                <!-- END: Modal Header -->
                <!-- BEGIN: Modal Body -->
                <div class="modal-body grid grid-cols-12 gap-4 gap-y-3"
                    style="overflow-x: auto; overflow-y: auto; max-height: 80vh;">
                    <!-- Menambahkan gaya overflow di sini -->
                    <form method="post" action="{{ route('nilai.keterampilan.proyek.store') }}"
                        enctype="multipart/form-data" id="myForm">
                        @csrf
                        <div class="mb-2 grid grid-cols-12">
                            <input type="hidden" name="id_seksi" value="{{ $dataseksi->id }}" id="">

                            KD: <input style="width: 60px;" type="number" name="kd" class="form-control ml-8"
                                required>
                        </div>

                        <div class="mb-1">Materi: </div>
                        <div class="mb-2">
                            <textarea name="catatan_keterampilan" id="catatan_keterampilan" style="width: 350px;" rows="4"
                                class="form-control " required></textarea>

                        </div>



                        <table id="datatable" class="table table-bordered mx-auto">
                            <thead>
                                <tr>
                                    <th class="whitespace-nowrap">No</th>
                                    <th class="whitespace-nowrap">NISN</th>
                                    <th class="whitespace-nowrap">Nama</th>
                                    <th class="whitespace-nowrap">Jk</th>
                                    <th class="whitespace-nowrap">Kelas</th>
                                    <th class="whitespace-nowrap">Nilai <input id="phInput" style="width: 70px;"
                                            type="number"></th>


                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $rombelsiswa = App\Models\Rombelsiswa::where(
                                        'id_rombel',
                                        $dataseksi->id_rombel,
                                    )->get();
                                @endphp
                                @foreach ($rombelsiswa as $key => $item)
                                    <tr>
                                        <td class="whitespace-nowrap">{{ $key + 1 }}</td>
                                        <td class="whitespace-nowrap"> {{ $item->siswas->nisn }} </td>
                                        <td class="whitespace-nowrap"> {{ $item->siswas->nama }} </td>
                                        <td class="whitespace-nowrap"> {{ $item->siswas->jk }} </td>
                                        <td class="whitespace-nowrap"> {{ $item->rombels->kelass->tingkat }}
                                            {{ $item->rombels->kelass->nama }}
                                            {{ $item->rombels->kelass->jurusans->nama }}</td>

                                        <td style="white-space: nowrap; text-transform: capitalize;">
                                            <input class="phInputField" style="width: 70px;" type="number"
                                                name="nilai_keterampilan[]" value="0">
                                        </td>


                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                </div>
                <!-- END: Modal Body -->
                <!-- BEGIN: Modal Footer -->
                <div class="modal-footer">
                    <a href="{{ route('nilai.keterampilan.proyek', $dataseksi->id) }}" type="button"
                        data-tw-dismiss="modal" class="btn btn-danger w-20 mr-1">Cancel</a>
                    <button type="submit" class="btn btn-primary w-20">Save</button>
                </div>
                <!-- END: Modal Footer -->
            </div>
            </form>
        </div>
    </div>


    @foreach ($kdValues as $kdItem)
        <div id="edit-footer-modal-preview-{{ $kdItem->kd }}" class="modal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog" style="max-width: 90vw; width: 55%;">
                <div class="modal-content">
                    <!-- BEGIN: Modal Header -->
                    <div class="modal-header">
                        <h2 class="font-medium text-base mr-auto">Nilai Keterampilan Proyek</h2>
                    </div>
                    <!-- END: Modal Header -->
                    <!-- BEGIN: Modal Body -->
                    <div class="modal-body grid grid-cols-12 gap-4 gap-y-3"
                        style="overflow-x: auto; overflow-y: auto; max-height: 80vh;">
                        <!-- Menambahkan gaya overflow di sini -->
                        <form method="post" action="{{ route('nilai.keterampilan.proyek.update') }}"
                            enctype="multipart/form-data" id="myForm">
                            @csrf
                            @php
                                $datanilai = App\Models\Nilai::where('id_seksi', $dataseksi->id)
                                    ->where('kd', $kdItem->kd)
                                    ->where('type_nilai', 3)
                                    ->where('type_keterampilan', 2)
                                    ->first();
                            @endphp
                            <div class="mb-2 grid grid-cols-12">
                                <input type="hidden" name="id_seksi" value="{{ $dataseksi->id }}" id="">

                                KD: <input style="width: 60px;" type="number" name="kd"
                                    value="{{ $kdItem->kd }}" class="form-control ml-8" readonly>
                            </div>

                            <div class="mb-1">Materi: </div>
                            <div class="mb-2">
                                <textarea name="catatan_keterampilan" id="" style="width: 350px;" rows="4" class="form-control "> {{ $datanilai->catatan_keterampilan }} </textarea>

                            </div>



                            <table id="datatable" class="table table-bordered mx-auto">
                                <thead>
                                    <tr>
                                        <th class="whitespace-nowrap">No</th>
                                        <th class="whitespace-nowrap">NISN</th>
                                        <th class="whitespace-nowrap">Nama</th>
                                        <th class="whitespace-nowrap">Jk</th>
                                        <th class="whitespace-nowrap">Kelas</th>
                                        <th class="whitespace-nowrap">Nilai <input id="editphInput" style="width: 70px;"
                                                type="number"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $rombelsiswa = App\Models\Rombelsiswa::where(
                                            'id_rombel',
                                            $dataseksi->id_rombel,
                                        )->get();
                                    @endphp
                                    @foreach ($rombelsiswa as $index => $item)
                                        <tr>
                                            <td class="whitespace-nowrap">{{ $index + 1 }}</td>
                                            <td class="whitespace-nowrap">{{ $item->siswas->nisn }}</td>
                                            <td class="whitespace-nowrap">{{ $item->siswas->nama }}</td>
                                            <td class="whitespace-nowrap">{{ $item->siswas->jk }}</td>
                                            <td class="whitespace-nowrap">
                                                {{ $item->rombels->kelass->tingkat }}
                                                {{ $item->rombels->kelass->nama }}
                                                {{ $item->rombels->kelass->jurusans->nama }}
                                            </td>
                                            <td style="white-space: nowrap; text-transform: capitalize;">
                                                @php
                                                    $nilai = App\Models\Nilai::where('id_seksi', $dataseksi->id)
                                                        ->where('kd', $kdItem->kd)
                                                        ->where('type_nilai', 3)
                                                        ->where('id_rombelsiswa', $item->id)
                                                        ->where('type_keterampilan', 2)
                                                        ->first();
                                                @endphp
                                                <input style="width: 50px;" type="hidden" name="id[]"
                                                    value="{{ $nilai->id }}">
                                                <input class="editphInputField" style="width: 70px;" type="number"
                                                    name="nilai_keterampilan[]"
                                                    value="{{ $nilai->nilai_keterampilan ?? '0' }}">
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>
                    </div>
                    <!-- END: Modal Body -->
                    <!-- BEGIN: Modal Footer -->
                    <div class="modal-footer">
                        <a href="{{ route('nilai.keterampilan.proyek', $dataseksi->id) }}" type="button"
                            data-tw-dismiss="modal" class="btn btn-danger w-20 mr-1">Cancel</a>
                        <button type="submit" class="btn btn-primary w-20">Save</button>
                    </div>
                    <!-- END: Modal Footer -->
                </div>
                </form>
            </div>
        </div>
    @endforeach

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var judulPh = document.getElementById('phInput');

            var inputPh = document.querySelectorAll('.phInputField');

            judulPh.addEventListener('input', function() {
                var nilaiPh = this.value;
                inputPh.forEach(function(input) {
                    input.value = nilaiPh;
                });
            });



            var judulEditPh = document.getElementById('editphInput');

            var inputEditPh = document.querySelectorAll('.editphInputField');

            judulEditPh.addEventListener('input', function() {
                var nilaiEditPh = this.value;
                inputEditPh.forEach(function(input) {
                    input.value = nilaiEditPh;
                });
            });

        });
    </script>

    <!-- END: Modal Content -->




    {{--  /Export proyek  --}}

    <div id="excel-modal-preview" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- BEGIN: Modal Header -->
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto">Export Nilai Keterampilan Proyek</h2>
                    <div class="dropdown sm:hidden"> <a class="dropdown-toggle w-5 h-5 block" href="javascript:;"
                            aria-expanded="false" data-tw-toggle="dropdown"> <i data-lucide="more-horizontal"
                                class="w-5 h-5 text-slate-500"></i> </a>
                        <div class="dropdown-menu w-40">
                        </div>
                    </div>
                </div> <!-- END: Modal Header -->
                <!-- BEGIN: Modal Body -->

                <form method="post" action="{{ route('keterampilan.proyek.excel') }}">
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
                        <a href="{{ route('nilai.keterampilan.proyek', $dataseksi->id) }}"
                            class="btn btn-outline-secondary w-20 mr-1">Cancel</a>
                        <button type="submit" class="btn btn-primary w-20">Export</button>
                </form>
            </div>
        </div>
    </div>


    <!-- Upload Nilia Proyek --> <!-- BEGIN: Modal Content -->
    <div id="header1-footer-modal-preview" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content"> <!-- BEGIN: Modal Header -->
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto">Upload Data Nilai Proyek</h2>

                    <form method="post" action="{{ route('nilai.proyek.template') }}">
                        @csrf

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

                        <!-- BEGIN: Modal Footer -->
                        <div class="mt-1">
                            <button type="submit" class="btn btn-outline-secondary hidden sm:flex"> <i
                                    data-lucide="download" class="w-4 h-4 mr-2"></i> Template</button>
                        </div>
                    </form>


                </div> <!-- END: Modal Header --> <!-- BEGIN: Modal Body -->
                <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                    <div class="col-span-12 sm:col-span-12">
                        <form
                            data-file-types="application/vnd.ms-excel|application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
                            class="dropzone flex justify-center items-center" action="{{ route('proyek.upload') }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" value="{{ $dataseksi->id }}" name="id_seksi">
                            <input type="hidden" value="{{ $dataseksi->semester }}" name="id_tahunajar">

                            <div class="fallback"> <input name="file" type="file" /> </div>

                            <div class="dz-message" data-dz-message>
                                <div class="text-center">
                                    <img alt="Midone - HTML Admin Template" class="w-10 mx-auto"
                                        src="{{ asset('backend/dist/images/excel.png') }}">
                                    <div class="text-lg font-medium">Drop files here or click to upload.</div>
                                </div>
                            </div>
                    </div>

                </div> <!-- END: Modal Body --> <!-- BEGIN: Modal Footer -->
                <div class="modal-footer"> <a href="{{ route('nilai.keterampilan.proyek', $dataseksi->id) }}"
                        data-tw-dismiss="modal" class="btn btn-danger w-20 mr-1">Cancel</a> <button type="submit"
                        class="btn btn-primary w-20">Save</button> </div> <!-- END: Modal Footer -->
                </form>
            </div>
        </div>
    </div>
@endsection
