@extends('admin.admin_master')
@section('admin')

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <style>
        .horizontal-align {
            display: inline-flex;
            /* atau display: inline-block; */
            align-items: center;
            /* Optional: Untuk menengahkan ikon dan teks secara vertikal jika dibutuhkan */
        }
    </style>



    <div class="page-content mt-4">
        <div class="container-fluid">
            <div class="row">

                <div class="col-12">
                    <ul class="nav nav-boxed-tabs" role="tablist">
                        <li id="example-5-tab" class="nav-item flex-1" role="presentation"> <button
                                class="nav-link w-full py-2 active" data-tw-toggle="pill" data-tw-target="#example-tab-5"
                                type="button" role="tab" aria-controls="example-tab-3" aria-selected="true"> REKAP
                                JADWAL MAPEL </button> </li>
                        <li id="example-5-tab" class="nav-item flex-1" role="presentation"> <button
                                class="nav-link w-full py-2" data-tw-toggle="pill" data-tw-target="#example-tab-6"
                                type="button" role="tab" aria-controls="example-tab-4" aria-selected="false">
                                RUBAH JADWAL MAPEL </button> </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class=" intro-y flex flex-col sm:flex-row items-center mt-4">

            <form role="form" action="{{ route('jadwalmapel.all') }}" method="get" class="sm:flex">
                <div class="flex-1 sm:mr-2">
                    <div class="form-group">
                        <input type="text" name="searchhari" class="form-control" placeholder="Hari"
                            value="{{ request('searchhari') }}">
                    </div>
                </div>
                <div class="flex-1 sm:mr-2">
                    <div class="form-group">
                        <input type="text" name="searchguru" class="form-control" placeholder="Nama Guru"
                            value="{{ request('searchguru') }}">
                    </div>
                </div>
                <div class="flex-1 sm:mr-2">
                    <div class="form-group">
                        <input type="text" name="searchmapel" class="form-control" placeholder="Mata Pelajaran"
                            value="{{ request('searchmapel') }}">

                    </div>
                </div>
                <div class="flex-1 sm:mr-2">
                    <div class="form-group">

                        <select name="searchkelas" class="form-select w-full">
                            <option value="">Kelas</option>
                            @foreach ($kelas as $item)
                                <option value="{{ $item->id }}">{{ $item->tingkat }} {{ $item->nama }}
                                    {{ $item->jurusans->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="flex-1 sm:mr-2">
                    <div class="form-group">

                        <select name="searchtahun" class="form-select w-full">
                            <option value="">Tahun Ajar</option>
                            @foreach ($datatahun as $item)
                                <option value="{{ $item->id }}">{{ $item->semester }} -
                                    {{ $item->tahun }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="sm:ml-1">
                    <button type="submit" class="btn btn-default">Search</button>
                </div>
                <div class="sm:ml-2">

                    <a href="{{ route('jadwalmapel.all') }}" class="btn btn-danger">Clear</a>

                </div>
            </form>
        </div>
        {{--  // End Bagian search //  --}}


        <div class="col-span-2 mb-4 mt-4 intro-y flex flex-col sm:flex-row">
            <div class="sm:ml-1">

                <a class="btn btn-pending btn-block" data-tw-toggle="modal" data-tw-target="#excel-modal-preview">
                    <span class="glyphicon glyphicon-download"></span> <i data-lucide="download"
                        class="w-4 h-4"></i>&nbsp;Export

                </a>
            </div>
            <div class="sm:ml-1">
                <a class="btn btn-success btn-block" data-tw-toggle="modal" data-tw-target="#button-modal-preview">
                    <span class="glyphicon glyphicon-download"></span> <i data-lucide="send" class="w-4 h-4"></i>&nbsp;Kirim
                    Jadwal
                </a>
            </div>
            <div class="sm:ml-1">
                @if (Auth::user()->role == '1' || Auth::user()->role == '3')
                    <a data-tw-toggle="modal" data-tw-target="#add-jadwalmapels-modal" class="btn btn-primary btn-block">
                        <span class="glyphicon glyphicon-download"></span> </span> <i data-lucide="plus-square"
                            class="w-5 h-5"></i>&nbsp;Tambah Data</a>
                @endif
            </div>


        </div>

        <div class="col-span-2 mb-2 mt-4">
            @if (
                !empty($jadwal) &&
                    isset($jadwal['tahun']) &&
                    isset($jadwal['tahun']['semester']) &&
                    isset($jadwal['tahun']['tahun']))
                Semester {{ $jadwal['tahun']['semester'] }}
                Tahun Ajar {{ $jadwal['tahun']['tahun'] }}
            @endif

        </div>
    </div>

    <div class="overflow-x-auto">
        <div class="tab-content mt-4">
            <div id="example-tab-5" class="tab-pane leading-relaxed active" role="tabpanel" aria-labelledby="example-5-tab">

                <table id="datatable1" class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center " style="background-color: rgb(187,191,195)">Hari</th>
                            <th class="text-center "style="background-color: rgb(187,191,195)">Waktu</th>
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
                                <th colspan="3" class="text-center " style="background-color: rgb(187,191,195)">
                                    {{ $tingkat->tingkat }} {{ $tingkat->nama }}
                                    {{ $tingkat['jurusans']['nama'] }}
                                </th>
                            @endforeach
                        </tr>
                        <tr>
                            <th class="text-center "style="background-color: rgb(187,191,195)"></th>
                            <th class="text-center "style="background-color: rgb(187,191,195)"></th>
                            @foreach ($kelasGroups as $kelas => $jadwalByClass)
                                <th style="white-space: nowrap;" class="btn-primary">
                                    Kode Guru</th>
                                <th style=" white-space: nowrap;" class="btn-primary">
                                    Kode Mapel</th>
                                <th style="white-space: nowrap;" class="btn-primary">
                                    Ruangan</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>

                        @php
                            $hariGroups = collect();
                        @endphp
                        @foreach ($jadwalmapel as $key => $jadwal)
                            @php
                                // Mengelompokkan data berdasarkan hari

                                $hari1 = $jadwal->id_hari;
                                if (!$hariGroups->has($hari1)) {
                                    $hariGroups->put($hari1, collect());
                                }
                                $hariGroups[$hari1]->push($jadwal);

                            @endphp
                        @endforeach
                        @foreach ($hariGroups as $hari1 => $jadwalByDay)
                            @php
                                $haridata = App\Models\Hari::find($hari1);
                                $harijumlah = count($jadwalByDay);
                                $printedTimeSlots = []; // Initialize array to keep track of printed time slots
                                $uniqueTimes = $jadwalByDay->unique('id_waktu');
                                $harijumlah = count($uniqueTimes);
                            @endphp
                            @foreach ($jadwalByDay as $index => $jadwal)
                                @php
                                    $timeSlot = $jadwal->waktus->range; // Get the time slot
                                @endphp
                                {{-- Check if the time slot has been printed already --}}
                                @if (!in_array($timeSlot, $printedTimeSlots))
                                    <tr>
                                        @if ($index === 0)
                                            <td rowspan="{{ $harijumlah }}" style="background-color: rgb(187,191,195)">
                                                {{ $haridata->nama }}
                                            </td>
                                        @endif
                                        <td style="white-space: nowrap;" class="bg-warning">
                                            {{ $timeSlot }}
                                        </td>
                                        {{-- Loop through kelasGroups to display kode guru for each class --}}
                                        @foreach ($kelasGroups as $kelas => $jadwalByClass)
                                            @php
                                                $kode_guru = ''; // Initialize kode guru as empty string
                                                $kode_mapel = ''; // Initialize kode mapel as empty string
                                                $kode_ruangan = ''; // Initialize kode ruangan as empty string
                                            @endphp
                                            @foreach ($jadwalByClass as $jadwalKelas)
                                                {{-- Check if the jadwal belongs to the current iteration's class and time slot --}}
                                                @if ($jadwalKelas->waktus->range === $timeSlot && $jadwalKelas->id_hari === $jadwal->id_hari)
                                                    {{-- Assign the kode guru if the jadwal belongs to the current iteration's class and time slot --}}
                                                    @php
                                                        $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                                        $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                                        $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;

                                                    @endphp
                                                    {{-- Break the inner loop --}}
                                                @break
                                            @endif
                                        @endforeach
                                        {{-- Display the kode guru --}}
                                        <td>{{ $kode_guru }}
                                        </td>
                                        <td>{{ $kode_mapel }}</td>
                                        <td>{{ $kode_ruangan }}</td>
                                    @endforeach
                                </tr>
                                {{-- Add the printed time slot to the printedTimeSlots array --}}
                                @php
                                    $printedTimeSlots[] = $timeSlot;
                                @endphp
                            @endif
                        @endforeach
                    @endforeach

                </tbody>
            </table>

        </div>
        <div id="example-tab-6" class="tab-pane leading-relaxed" role="tabpanel" aria-labelledby="example-6-tab">
            <table id="datatable" class="table table-bordered">
                <thead>
                    <tr>

                        <th>No.</th>
                        <th style="white-space: nowrap;">Seksi
                        </th>
                        <th style="white-space: nowrap;">Kode
                        </th>
                        <th>Hari</th>
                        <th>Waktu</th>
                        <th style="white-space: nowrap;">Guru
                        </th>
                        <th style="white-space: nowrap;">Mata
                            Pelajaran</th>
                        <th>Kelas</th>
                        <th>JP</th>
                        <th>Kode Ruangan</th>
                        <th>Semester</th>

                        <th>Status</th>
                        <th>Action</th>


                    </tr>
                </thead>
                <tbody>
                    @foreach ($jadwalmapel as $key => $item)
                        @php
                            $pengampuid = App\Models\Pengampu::find($item->id_pengampu);
                            $mapelid = App\Models\Mapel::find($pengampuid->id_mapel);
                            $guruid = App\Models\Guru::find($pengampuid->id_guru);
                            $kelas = App\Models\Kelas::find($pengampuid->kelas);
                        @endphp

                        <tr>
                            <td align="center">
                                {{ $key + 1 }} </td>
                            <td style="white-space: nowrap;" class="text-primary">
                                {{ $item->kode_jadwalmapel }}
                            </td>
                            <td style="white-space: nowrap;" class="text-primary">
                                {{ $item['pengampus']['kode_pengampu'] }}
                            </td>
                            <td> {{ $item['haris']['nama'] }}
                            </td>
                            <td> {{ $item['waktus']['range'] }}
                            </td>
                            <td style="white-space: nowrap;">
                                {{ $guruid->nama }} </td>
                            <td style="white-space: nowrap;">
                                {{ $mapelid->nama }} </td>
                            <td style="white-space: nowrap;">
                                {{ $kelas->tingkat }}
                                {{ $kelas->nama }}
                                {{ $kelas['jurusans']['nama'] }}
                            </td>
                            <td> {{ $mapelid->jp }} </td>
                            <td> {{ $item['ruangans']['kode_ruangan'] }}
                            </td>
                            <td style="white-space: nowrap;">
                                {{ $item['tahun']['semester'] }}
                                - {{ $item['tahun']['tahun'] }}
                            </td>

                            <td>
                                @if ($item->status == '0')
                                    <span class="btn btn-outline-warning">Proses
                                        Penjadwalan</span>
                                @elseif($item->status == '1')
                                    <span class="btn btn-outline-pending">Menunggu
                                        Verifikasi</span>
                                @elseif($item->status == '2')
                                    <span class="btn btn-outline-success">Kirim</span>
                                @elseif($item->status == '3')
                                    <span class="btn btn-outline-danger">Ditolak</span>
                                @endif

                            </td>
                            <td>

                                <a id="delete" href="{{ route('jadwalmapel.delete', $item->id) }}"
                                    class="btn btn-danger mr-1 mb-2">
                                    <i data-lucide="trash" class="w-4 h-4"></i>
                                </a>

                                <a href="javascript:;" data-tw-toggle="modal"
                                    data-tw-target="#edit-jadwalmapels-modal-{{ $item->id }}"
                                    class="btn btn-primary mb-2">
                                    <i data-lucide="edit" class="w-4 h-4 mb"></i>
                                </a>

                                @if ($item->status == '0' || $item->status == '3')
                                    <a href="javascript:;" data-tw-toggle="modal"
                                        data-tw-target="#kirim-jadwalmapels-modal-{{ $item->id }}"
                                        class="btn btn-primary">
                                        <i data-lucide="send" class="w-4 h-4"></i>
                                    </a>
                                @endif

                            </td>


                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>




    <!-- Modal Tambah Jadwal -->

    <div id="add-jadwalmapels-modal" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto">Tambah Jadwal Mapel</h2>
                </div>
                <form method="post" action="{{ route('jadwalmapel.store') }}" enctype="multipart/form-data"
                    id="myForm1">
                    @csrf
                    <div class="modal-body">
                        <div class="grid grid-cols-12 gap-4 gap-y-3 mb-4">
                            <!-- Kode Pengampu -->
                            <div class="col-span-12 sm:col-span-4">
                                <div class="mb-2">
                                    <div class="mb-2">
                                        <label for="id_pengampu">KODE PENGAMPU</label>
                                    </div>
                                    <select name="id_pengampu" id="id_pengampu" class="tom-select w-full" required>
                                        <optgroup>
                                            <option value="">Pilih Kode Pengampu</option>
                                            @foreach ($pengampu as $item)
                                                <option value="{{ $item->id }}">
                                                    {{ $item->kode_pengampu }} / {{ $item['gurus']['nama'] }}
                                                </option>
                                            @endforeach
                                        </optgroup>
                                    </select>
                                </div>
                            </div>

                            <!-- Tabel Data -->
                            <div class="col-span-12">
                                <div class="card overflow-x-auto">
                                    <div class="card-body table-responsive">
                                        <table id="data-table" class="table table-sm" style="width: 100%;">
                                            <thead>
                                                <tr>

                                                    <th>Kode Pengampu</th>
                                                    <th>Nama Guru</th>
                                                    <th>Mata Pelajaran</th>
                                                    <th>Kelas</th>
                                                    <th>Jp</th>

                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="grid grid-cols-12 gap-4 gap-y-3 mt-8 mb-4">
                            <!-- Waktu -->
                            <div class="col-span-12 sm:col-span-4">
                                <div class="mb-2">
                                    <label for="edit-jam">Waktu</label>
                                </div>
                                <select name="id_waktu" id="id_waktu" class="form-control w-full" required>
                                    <option value="">Pilih Waktu</option>
                                    @foreach ($waktu as $item)
                                        <option value="{{ $item->id }}">{{ $item->range }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Hari -->
                            <div class="col-span-12 sm:col-span-4">
                                <label for="modal-form-4" class="form-label">Hari</label>
                                <select name="id_hari" id="id_hari" class="form-control w-full" required>
                                    <option value="">Pilih Hari</option>
                                    @foreach ($hari as $item)
                                        <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Ruangan -->
                            <div class="col-span-12 sm:col-span-4">
                                <div class="mb-2">
                                    <label for="edit-ruangan">Ruangan</label>
                                </div>
                                <select name="id_ruangan" id="id_ruangan" class="form-control w-full" required>
                                    <option value="">Pilih Ruangan</option>
                                    @foreach ($ruangan as $item)
                                        <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <!-- Tahun Ajar -->
                            <div class="col-span-12 sm:col-span-4">
                                <div class="mb-2">
                                    <label for="edit-ruangan">Tahun Ajar</label>
                                </div>
                                <select name="id_tahunajar" id="id_tahunajar" class="form-control w-full" required>
                                    <option value="">Pilih Tahun Ajar</option>
                                    @foreach ($tahunajar as $item)
                                        <option value="{{ $item->id }}">{{ $item->semester }} -
                                            {{ $item->tahun }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <p class="horizontal-align ml-4">
                        <i data-lucide="alert-triangle" class="mr-1 text-danger"></i>
                        <span class="text-danger">Pastikan data yang diinputkan benar.</span>
                    </p>

                    <div class="modal-footer">
                        <button type="button" data-tw-dismiss="modal"
                            class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
                        <button type="submit" class="btn btn-primary w-20">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#myForm1').validate({
                rules: {
                    id_waktu: {
                        required: true,
                    },
                    id_hari: {
                        required: true,
                    },
                    id_ruangan: {
                        required: true,
                    },

                },
                messages: {
                    id_waktu: {
                        required: 'Please Enter Your Waktu',
                    },
                    id_hari: {
                        required: 'Please Enter Your Hari',
                    },
                    id_ruangan: {
                        required: 'Please Enter Your Ruangan',
                    },


                },
                errorElement: 'span',
                errorClass: 'invalid-feedback',
                errorPlacement: function(error, element) {
                    error.insertAfter(element);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                },
            });
        });
    </script>

    {{--  Scrip Menampilkan data tabel  --}}

    <script>
        // Tangkap elemen dropdown select
        const selectElement = document.getElementById('id_pengampu');

        // Tambahkan event listener untuk menangani perubahan dalam dropdown
        selectElement.addEventListener('change', function() {
            // Ambil nilai yang dipilih dalam dropdown
            const selectedValue = selectElement.value;

            // Buat AJAX request atau manipulasi data sesuai kebutuhan Anda
            // Di sini, kita hanya akan menambahkan data ke dalam tabel sebagai contoh
            const tableBody = document.querySelector('#data-table tbody');
            tableBody.innerHTML = ''; // Bersihkan isi tabel sebelum menambahkan data baru

            // Loop melalui data pengampu untuk menemukan yang sesuai dengan nilai yang dipilih
            @foreach ($pengampu as $item)
                if ("{{ $item->id }}" === selectedValue) {
                    const newRow = tableBody.insertRow();
                    const cell1 = newRow.insertCell(0); // Hanya satu kolom yang perlu ditambahkan sekarang
                    const cell2 = newRow.insertCell(1);
                    const cell3 = newRow.insertCell(2);
                    const cell4 = newRow.insertCell(3);
                    const cell5 = newRow.insertCell(4);


                    cell1.textContent = "{{ $item->kode_pengampu }}"; // Kode Pengampu
                    cell2.textContent = "{{ $item->gurus->nama }}"; // Nama Guru (berdasarkan relasi)
                    cell3.textContent = "{{ $item->mapels->nama }}"; // Mata Pelajaran (berdasarkan relasi)
                    cell4.textContent =
                        "{{ $item->kelass->tingkat }} {{ $item->kelass->nama }} {{ $item->kelass->jurusans->nama }}"; // Kelas
                    cell5.textContent = "{{ $item->mapels->jp }}"; // Jp

                }
            @endforeach
        });
    </script>

    <!-- End Modal Tambah Jadwal -->






    <!-- Modal Edit Jadwal -->

    @foreach ($jadwalmapel as $item)
        <div class="modal fade" id="edit-jadwalmapels-modal-{{ $item->id }}" tabindex="-1" role="dialog"
            aria-labelledby="edit-jadwalmapels-modal-label-{{ $item->id }}" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="font-medium text-base mr-auto">Edit Jadwal Mapel</h2>
                    </div>
                    <form method="post" action="{{ route('jadwalmapel.update', $item->id) }}">
                        @csrf
                        <div class="modal-body">
                            <div class="grid grid-cols-12 gap-4 gap-y-3 mb-4">

                                <!-- Tabel Data -->
                                <div class="col-span-12">
                                    <div class="card overflow-x-auto">
                                        <div class="card-body table-responsive">
                                            <table id="data-table1" class="table table-sm" style="width: 100%;">
                                                <thead>
                                                    <tr>

                                                        <th>Kode Pengampu</th>
                                                        <th>Nama Guru</th>
                                                        <th>Mata Pelajaran</th>
                                                        <th>Kelas</th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $pengampuid = App\Models\Pengampu::find($item->id_pengampu);
                                                        $mapelid = App\Models\Mapel::find($pengampuid->id_mapel);
                                                        $guruid = App\Models\Guru::find($pengampuid->id_guru);
                                                    @endphp

                                                    <tr>

                                                        <td> {{ $pengampuid->kode_pengampu }} </td>
                                                        <td> {{ $guruid->nama }} </td>
                                                        <td> {{ $mapelid->nama }} </td>
                                                        <td> {{ $pengampuid['kelass']['tingkat'] }}
                                                            {{ $pengampuid['kelass']['nama'] }}
                                                            {{ $pengampuid['kelass']['jurusans']['nama'] }} </td>


                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="grid grid-cols-12 gap-4 gap-y-3 mt-8 mb-4">
                                <!-- Waktu -->
                                <div class="col-span-12 sm:col-span-4">
                                    <div class="mb-2">
                                        <label for="edit-jam">Waktu</label>
                                    </div>
                                    <select name="id_waktu" id="id_waktu" class="form-control w-full" required>
                                        <option value="{{ $item->id_waktu }}">{{ $item['waktus']['range'] }}</option>
                                        @foreach ($waktu as $item1)
                                            <option value="{{ $item1->id }}">{{ $item1->range }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Hari -->
                                <div class="col-span-12 sm:col-span-4">
                                    <label for="modal-form-4" class="form-label">Hari</label>
                                    <select name="id_hari" id="id_hari" class="form-control w-full" required>
                                        <option value="{{ $item->id_hari }}">{{ $item['haris']['nama'] }}</option>
                                        @foreach ($hari as $item2)
                                            <option value="{{ $item2->id }}">{{ $item2->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Ruangan -->
                                <div class="col-span-12 sm:col-span-4">
                                    <div class="mb-2">
                                        <label for="edit-ruangan">Ruangan</label>
                                    </div>
                                    <select name="id_ruangan" id="id_ruangan" class="form-control w-full" required>
                                        <option value="{{ $item->id_ruangan }}">{{ $item['ruangans']['nama'] }}
                                        </option>
                                        @foreach ($ruangan as $item3)
                                            <option value="{{ $item3->id }}">{{ $item3->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Tahun Ajar -->
                                <div class="col-span-12 sm:col-span-4">
                                    <div class="mb-2">
                                        <label for="edit-ruangan">Tahun Ajar</label>
                                    </div>
                                    <select name="id_tahunajar" id="id_tahunajar" class="form-control w-full"
                                        required>
                                        <option value=" {{ $item->id_tahunajar }} ">
                                            {{ $item->tahun->semester }} - {{ $item->tahun->tahun }}</option>
                                        @foreach ($tahunajar as $item)
                                            <option value="{{ $item->id }}">
                                                {{ $item->semester }}/{{ $item->tahun }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <p class="horizontal-align ml-4">
                            <i data-lucide="alert-triangle" class="mr-1 text-danger"></i>
                            <span class="text-danger">Pastikan data yang diinputkan benar.</span>
                        </p>

                        <div class="modal-footer">
                            <button type="button" data-tw-dismiss="modal"
                                class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
                            <button type="submit" class="btn btn-primary w-20">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach


    <!-- End Modal Edit Jadwal -->




    <!-- BEGIN: Modal Kirim Jadwal All-->
    <div id="button-modal-preview" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form method="post" action="{{ route('jadwalmapelstatusall.update') }}">
                @csrf
                <div class="modal-content"> <a data-tw-dismiss="modal" href="javascript:;"> <i data-lucide="x"
                            class="w-8 h-8 text-slate-400"></i> </a>
                    <div class="modal-body p-0">
                        <div class="p-5 text-center"> <i data-lucide="check-circle"
                                class="w-16 h-16 text-success mx-auto mt-3"></i>
                            <div class="text-3xl mt-5">Kirim Jadwal </div>
                            <div class="text-slate-500 mt-2">Data Jadwal Mata Pelajaran Di Kirim Ke Kepsek..!!</div>
                        </div>
                        <div class="px-5 pb-8 text-center"> <button type="submit" data-tw-dismiss="modal"
                                class="btn btn-primary w-24">Ok</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- END: Modal Kirim Jadwal All Content -->

    <!-- BEGIN: Modal Excel-->

    <div id="excel-modal-preview" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- BEGIN: Modal Header -->
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto">Export Jadwal Mapel</h2>
                    <div class="dropdown sm:hidden"> <a class="dropdown-toggle w-5 h-5 block" href="javascript:;"
                            aria-expanded="false" data-tw-toggle="dropdown"> <i data-lucide="more-horizontal"
                                class="w-5 h-5 text-slate-500"></i> </a>
                        <div class="dropdown-menu w-40">
                        </div>
                    </div>
                </div> <!-- END: Modal Header -->
                <!-- BEGIN: Modal Body -->

                <form method="post" action="{{ route('jadal.mapels.excel') }}">
                    @csrf
                    <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                        <div class="col-span-12 sm:col-span-6"> <label for="edit-jam">Pilih Tahun Ajar </label>
                            <select name="tahun" id="tahun" class="form-select w-full" required>

                                @foreach ($datatahun as $item)
                                    <option value="{{ $item->id }}">{{ $item->semester }} -
                                        {{ $item->tahun }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div> <!-- END: Modal Body -->
                    <!-- BEGIN: Modal Footer -->
                    <div class="modal-footer">
                        <a href="{{ route('jadwalmapel.all') }}"
                            class="btn btn-outline-secondary w-20 mr-1">Cancel</a>
                        <button type="submit" class="btn btn-primary w-20">Export</button>
                </form>
            </div>
        </div>
    </div>

    <!-- BEGIN: Modal Excel -->

    <!-- BEGIN: Modal Kirim Jadwal Satuan-->
    @foreach ($jadwalmapel as $item)
        <div id="kirim-jadwalmapels-modal-{{ $item->id }}" class="modal" tabindex="-1" aria-hidden="true"
            aria-labelledby="kirim-jadwalmapels-modal-label-{{ $item->id }}">
            <div class="modal-dialog">

                <form method="post" action="{{ route('jadwalmapelstatusone.update', $item->id) }}">
                    @csrf
                    <input type="hidden" value="1" name="status">
                    <div class="modal-content"> <a data-tw-dismiss="modal" href="javascript:;"> <i data-lucide="x"
                                class="w-8 h-8 text-slate-400"></i> </a>
                        <div class="modal-body p-0">
                            <div class="p-5 text-center"> <i data-lucide="check-circle"
                                    class="w-16 h-16 text-success mx-auto mt-3"></i>
                                <div class="text-3xl mt-5">Kirim Jadwal </div>
                                <div class="text-slate-500 mt-2">Data Jadwal Mata Pelajaran Di Kirim Ke Kepsek..!!
                                </div>
                            </div>
                            <div class="px-5 pb-8 text-center"> <button type="submit" data-tw-dismiss="modal"
                                    class="btn btn-primary w-24">Ok</button>

                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div> <!-- END: Modal Content -->
    @endforeach

    <!-- BEGIN: Modal Kirim Jadwal Satu-->





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
@endsection
