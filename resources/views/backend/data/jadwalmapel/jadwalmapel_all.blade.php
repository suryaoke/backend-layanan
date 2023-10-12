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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script> <!-- Include jQuery Validation plugin -->
    <h1 class="text-lg font-medium mb-4 mt-4">Jadwal Mata Pelajaran All</h1>

    <div class="mb-4 intro-y flex flex-col sm:flex-row items-center mt-4">

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
            <div class="sm:ml-1">
                <button type="submit" class="btn btn-default">Search</button>
            </div>
            <div class="sm:ml-2">

                <a href="{{ route('jadwalmapel.all') }}" class="btn btn-danger">Clear</a>

            </div>
        </form>
    </div>
    {{--  // End Bagian search //  --}}

    <div class="col-span-2 mb-4 mt-4">
        <a class="btn btn-primary btn-block" data-tw-toggle="modal" data-tw-target="#button-modal-preview">
            <span class="glyphicon glyphicon-download"></span> <i data-lucide="send" class="w-4 h-4"></i>&nbsp;Kirim
            Jadwal Mapel All
        </a>

        <a class="btn btn-outline-success btn-block ml-2" data-tw-toggle="modal" data-tw-target="#add-schedule-modal">
            <span class="glyphicon glyphicon-download"></span> Tambah Jadwal Mapel
        </a>
    </div>

    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="overflow-x-auto">
                        <table id="datatable" class="table table-sm"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>

                                    <th>No.</th>
                                    <th style="white-space: nowrap;">Kode Seksi</th>
                                    <th>Hari</th>
                                    <th>Waktu</th>
                                    <th style="white-space: nowrap;">Kode Guru</th>
                                    <th style="white-space: nowrap;">Kode Mapel</th>
                                    <th>Kelas</th>
                                    <th>JP</th>
                                    <th>Kode Ruangan</th>
                                    <th>Semester</th>
                                    <th>Kurikulum</th>
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
                                        <td align="center">{{ $key + 1 }}</td>
                                        <td style="white-space: nowrap;" class="text-primary">
                                            {{ $item->kode_jadwalmapel }}
                                        </td>
                                        <td> {{ $item['haris']['nama'] }} </td>
                                        <td> {{ $item['waktus']['range'] }} </td>
                                        <td style="white-space: nowrap;"> {{ $guruid->kode_gr }} </td>
                                        <td style="white-space: nowrap;"> {{ $mapelid->kode_mapel }} </td>
                                        <td style="white-space: nowrap;"> {{ $kelas->tingkat }} {{ $kelas->nama }}
                                            {{ $kelas['jurusans']['nama'] }}
                                        </td>
                                        <td> {{ $mapelid->jp }} </td>
                                        <td> {{ $item['ruangans']['kode_ruangan'] }} </td>
                                        <td style="white-space: nowrap;">
                                            {{ $mapelid['tahunajars']['semester'] }}-
                                            {{ $mapelid['tahunajars']['tahun'] }}
                                        </td>

                                        <td> {{ $pengampuid->kurikulum }} </td>
                                        <td>
                                            @if ($item->status == '0')
                                                <span class="btn btn-outline-warning">Proses Penjadwalan</span>
                                            @elseif($item->status == '1')
                                                <span class="btn btn-outline-pending">Menunggu Verifikasi</span>
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
                                                data-tw-target="#edit-schedule-modal-{{ $item->id }}"
                                                class="btn btn-primary mb-2">
                                                <i data-lucide="edit" class="w-4 h-4 mb"></i>
                                            </a>

                                            @if ($item->status == '0' || $item->status == '3')
                                                <a href="javascript:;" data-tw-toggle="modal"
                                                    data-tw-target="#kirim-schedule-modal-{{ $item->id }}"
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
            </div>
        </div>
    </div>




    <!-- Modal Tambah Jadwal -->

    <div id="add-schedule-modal" class="modal" tabindex="-1" aria-hidden="true">
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
                                                    <th>Kurikulum</th>
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
                    const cell6 = newRow.insertCell(5);

                    cell1.textContent = "{{ $item->kode_pengampu }}"; // Kode Pengampu
                    cell2.textContent = "{{ $item->gurus->nama }}"; // Nama Guru (berdasarkan relasi)
                    cell3.textContent = "{{ $item->mapels->nama }}"; // Mata Pelajaran (berdasarkan relasi)
                    cell4.textContent =
                        "{{ $item->kelass->tingkat }} {{ $item->kelass->nama }} {{ $item->kelass->jurusans->nama }}"; // Kelas
                    cell5.textContent = "{{ $item->mapels->jp }}"; // Jp
                    cell6.textContent = "{{ $item->kurikulum }}"; // Kurikulum
                }
            @endforeach
        });
    </script>

    <!-- End Modal Tambah Jadwal -->






    <!-- Modal Edit Jadwal -->

    @foreach ($jadwalmapel as $item)
        <div class="modal fade" id="edit-schedule-modal-{{ $item->id }}" tabindex="-1" role="dialog"
            aria-labelledby="edit-schedule-modal-label-{{ $item->id }}" aria-hidden="true">
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
                                                        <th>Kurikulum</th>
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
                                                        <td> {{ $pengampuid->kurikulum }} </td>

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
                                        <option value="{{ $item->id_ruangan }}">{{ $item['ruangans']['nama'] }}</option>
                                        @foreach ($ruangan as $item3)
                                            <option value="{{ $item3->id }}">{{ $item3->nama }}</option>
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



    <!-- BEGIN: Modal Kirim Jadwal Satuan-->
    @foreach ($jadwalmapel as $item)
        <div id="kirim-schedule-modal-{{ $item->id }}" class="modal" tabindex="-1" aria-hidden="true"
            aria-labelledby="kirim-schedule-modal-label-{{ $item->id }}">
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
@endsection
