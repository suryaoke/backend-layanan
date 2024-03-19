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
                                NILAI PENGETAHUAN PAS </button> </li>

                    </ul>
                </div>
            </div>
        </div>

    </div>
    @php
        $nilaiValues = App\Models\Nilai::where('id_seksi', $dataseksi->id)
            ->where('type_nilai', 2)
            ->first();
    @endphp
    <div class="overflow-x-auto">
        <div class="tab-content mt-8">


            <div class="flex mb-4 mt-4">

                <a class="btn btn-danger btn-block mr-1" href="{{ route('nilai.all', $dataseksi->id) }}">
                    <span class="glyphicon glyphicon-download"></span> <i data-lucide="arrow-left"
                        class="w-4 h-4"></i>&nbsp;Kembali
                </a>
                <a class="btn btn-pending btn-block mr-1" data-tw-toggle="modal" data-tw-target="#excel-modal-preview">
                    <span class="glyphicon glyphicon-download"></span> <i data-lucide="download"
                        class="w-5 h-5"></i>&nbsp;Export
                </a>

                @if (!$nilaiValues)
                    <a class="btn btn-success btn-block mr-1" data-tw-toggle="modal"
                        data-tw-target="#header1-footer-modal-preview">
                        <span class="glyphicon glyphicon-download"></span> </span> <i data-lucide="download"
                            class="w-5 h-5"></i>&nbsp;Upload</a>



                    <a data-tw-toggle="modal" data-tw-target="#nilai-footer-modal-preview"
                        class="btn btn-primary btn-block">
                        <span class="glyphicon glyphicon-download mr-1"></span> </span>
                        <i data-lucide="edit" class="w-5 h-5"></i>&nbsp;Nilai</a>
                @endif


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

                        @if ($nilaiValues)
                            <th class="whitespace-nowrap">Nilai
                                <div class="flex">
                                    <div class="mr-2">

                                        <a id="delete"
                                            href="{{ route('nilai.pengetahuan.akhir.delete', $dataseksi->id) }}">
                                            <i data-lucide="trash" class="w-4 h-4 text-red-500" style="color: red;"></i>
                                        </a>

                                    </div>
                                    <div>
                                        <a data-tw-toggle="modal" data-tw-target="#edit-footer-modal-preview">
                                            <i data-lucide="edit" class="w-4 h-4 text-blue-500" style="color: green;"></i>
                                        </a>
                                    </div>
                                </div>


                            </th>
                        @else
                            <th class="whitespace-nowrap">Nilai</th>
                        @endif

                    </tr>
                </thead>
                <tbody>
                    @php
                        $rombelsiswa = App\Models\Rombelsiswa::where('id_rombel', $dataseksi->id_rombel)->get();
                    @endphp
                    @foreach ($rombelsiswa as $key => $item)
                        @php
                            $nilai = App\Models\Nilai::where('id_rombelsiswa', $item->id)
                                ->where('type_nilai', 2)
                                ->where('id_seksi', $dataseksi->id)
                                ->first();
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

                                @if ($nilai)
                                    {{ $nilai->nilai_pengetahuan_akhir }}
                                @else
                                    -
                                @endif


                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>


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



    <div id="nilai-footer-modal-preview" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" style="max-width: 90vw; width: 55%;"> <!-- Menambahkan style langsung di sini -->
            <div class="modal-content">
                <!-- BEGIN: Modal Header -->
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto">Nilai Pengetahuan PAS</h2>
                </div>
                <!-- END: Modal Header -->
                <!-- BEGIN: Modal Body -->
                <div class="modal-body grid grid-cols-12 gap-4 gap-y-3"
                    style="overflow-x: auto; overflow-y: auto; max-height: 80vh;">
                    <!-- Menambahkan gaya overflow di sini -->
                    <form method="post" action="{{ route('nilai.pengetahuan.akhir.store') }}"
                        enctype="multipart/form-data" id="myForm">
                        @csrf
                        <input type="hidden" name="id_seksi" value="{{ $dataseksi->id }}" id="">

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
                                                name="nilai_pengetahuan_akhir[]" value="0">
                                        </td>


                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                </div>
                <!-- END: Modal Body -->
                <!-- BEGIN: Modal Footer -->
                <div class="modal-footer">
                    <a href="{{ route('nilai.pengetahuan.akhir', $dataseksi->id) }}" type="button"
                        data-tw-dismiss="modal" class="btn btn-danger w-20 mr-1">Cancel</a>
                    <button type="submit" class="btn btn-primary w-20">Save</button>
                </div>
                <!-- END: Modal Footer -->
            </div>
            </form>
        </div>
    </div>



    <div id="edit-footer-modal-preview" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" style="max-width: 90vw; width: 55%;">
            <div class="modal-content">
                <!-- BEGIN: Modal Header -->
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto">Nilai Pengetahuan PAS</h2>
                </div>
                <!-- END: Modal Header -->
                <!-- BEGIN: Modal Body -->
                <div class="modal-body grid grid-cols-12 gap-4 gap-y-3"
                    style="overflow-x: auto; overflow-y: auto; max-height: 80vh;">
                    <!-- Menambahkan gaya overflow di sini -->
                    <form method="post" action="{{ route('nilai.pengetahuan.akhir.update') }}"
                        enctype="multipart/form-data" id="myForm">
                        @csrf

                        <div class="mb-2 grid grid-cols-12">
                            <input type="hidden" name="id_seksi" value="{{ $dataseksi->id }}" id="">

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

                                                    ->where('type_nilai', 2)
                                                    ->where('id_rombelsiswa', $item->id)
                                                    ->first();
                                            @endphp
                                            @if ($nilai)
                                                <input style="width: 50px;" type="hidden" name="id[]"
                                                    value="{{ $nilai->id }}">
                                                <input class="editphInputField" style="width: 70px;" type="number"
                                                    name="nilai_pengetahuan_akhir[]"
                                                    value="{{ $nilai->nilai_pengetahuan_akhir ?? '0' }}">
                                            @endif

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>

                        </table>
                </div>
                <!-- END: Modal Body -->
                <!-- BEGIN: Modal Footer -->
                <div class="modal-footer">
                    <a href="{{ route('nilai.pengetahuan.akhir', $dataseksi->id) }}" type="button"
                        data-tw-dismiss="modal" class="btn btn-danger w-20 mr-1">Cancel</a>
                    <button type="submit" class="btn btn-primary w-20">Save</button>
                </div>
                <!-- END: Modal Footer -->
            </div>
            </form>
        </div>
    </div>


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

    {{--  /Export PAS  --}}

    <div id="excel-modal-preview" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- BEGIN: Modal Header -->
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto">Export Nilai Pengetahuan PAS</h2>
                    <div class="dropdown sm:hidden"> <a class="dropdown-toggle w-5 h-5 block" href="javascript:;"
                            aria-expanded="false" data-tw-toggle="dropdown"> <i data-lucide="more-horizontal"
                                class="w-5 h-5 text-slate-500"></i> </a>
                        <div class="dropdown-menu w-40">
                        </div>
                    </div>
                </div> <!-- END: Modal Header -->
                <!-- BEGIN: Modal Body -->

                <form method="post" action="{{ route('pengetahuan.akhir.excel') }}">
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
                        <a href="{{ route('nilai.pengetahuan.akhir', $dataseksi->id) }}"
                            class="btn btn-outline-secondary w-20 mr-1">Cancel</a>
                        <button type="submit" class="btn btn-primary w-20">Export</button>
                </form>
            </div>
        </div>
    </div>
@endsection
