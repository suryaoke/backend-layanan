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

        <form role="form" action="{{ route('jadwalmapel.kepsek') }}" method="get" class="sm:flex">
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

                <a href="{{ route('jadwalmapel.kepsek') }}" class="btn btn-danger">Clear</a>

            </div>
        </form>
    </div>
    {{--  // End Bagian search //  --}}

    <div class="col-span-2 mb-4 mt-4">
        <a class="btn btn-primary btn-block" data-tw-toggle="modal" data-tw-target="#verifikasi-modal-preview">
            <span class="glyphicon glyphicon-download"></span> <i data-lucide="check-circle"
                class="w-4 h-4"></i>&nbsp;Verifikasi
            Jadwal Mapel All
        </a>

        <a class="btn btn-success btn-block" href="{{ route('jadwalkepsek.excel') }} ">
            <span class="glyphicon glyphicon-download"></span> </span> <i data-lucide="printer"
                class="w-4 h-4"></i>&nbsp;Export Excel
        </a>

        <a href="javascript:;" data-tw-toggle="modal" data-tw-target="#pdf-modal-preview" class="btn btn-primary"> <span
                class="glyphicon glyphicon-download"></span> </span> <i data-lucide="printer"
                class="w-4 h-4"></i>&nbsp;Export Pdf</a>


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
                                    <th style="white-space: nowrap;">Seksi</th>
                                    <th style="white-space: nowrap;">Kode</th>
                                    <th>Hari</th>
                                    <th>Waktu</th>
                                    <th style="white-space: nowrap;">Guru</th>
                                    <th style="white-space: nowrap;">Mata Pelajaran</th>
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
                                        <td style="white-space: nowrap;" class="text-primary">
                                            {{ $item['pengampus']['kode_pengampu'] }} </td>
                                        <td> {{ $item['haris']['nama'] }} </td>
                                        <td> {{ $item['waktus']['range'] }} </td>
                                        <td style="white-space: nowrap;"> {{ $guruid->nama }} </td>
                                        <td style="white-space: nowrap;"> {{ $mapelid->nama }} </td>
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

                                            @if ($item->status == '1')
                                                <a href="javascript:;" data-tw-toggle="modal"
                                                    data-tw-target="#tolak-schedule-modal-{{ $item->id }}"
                                                    class="btn btn-danger">
                                                    <i data-lucide="x-circle" class="w-4 h-4"></i>
                                                </a>
                                                <a href="javascript:;" data-tw-toggle="modal"
                                                    data-tw-target="#verifikasi-schedule-modal-{{ $item->id }}"
                                                    class="btn btn-primary mt-1">
                                                    <i data-lucide="check-circle" class="w-4 h-4"></i>
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


    <!-- BEGIN: Modal Verifikasi Jadwal All-->
    <div id="verifikasi-modal-preview" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form method="post" action="{{ route('jadwalmapelverifikasiall.update') }}">
                @csrf
                <div class="modal-content"> <a data-tw-dismiss="modal" href="javascript:;"> <i data-lucide="x"
                            class="w-8 h-8 text-slate-400"></i> </a>
                    <div class="modal-body p-0">
                        <div class="p-5 text-center"> <i data-lucide="check-circle"
                                class="w-16 h-16 text-success mx-auto mt-3"></i>
                            <div class="text-3xl mt-5">Verifikasi Jadwal Mapel </div>

                        </div>
                        <div class="px-5 pb-8 text-center"> <button type="submit" data-tw-dismiss="modal"
                                class="btn btn-primary w-24">Ok</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- END: Modal Verifikasi Jadwal All Content -->



    <!-- BEGIN: Modal Verifikasi Jadwal Satuan-->
    @foreach ($jadwalmapel as $item)
        <div id="verifikasi-schedule-modal-{{ $item->id }}" class="modal" tabindex="-1" aria-hidden="true"
            aria-labelledby="verifikasi-schedule-modal-label-{{ $item->id }}">
            <div class="modal-dialog">

                <form method="post" action="{{ route('jadwalmapelverifikasione.update', $item->id) }}">
                    @csrf
                    <input type="hidden" value="1" name="status">
                    <div class="modal-content"> <a data-tw-dismiss="modal" href="javascript:;"> <i data-lucide="x"
                                class="w-8 h-8 text-slate-400"></i> </a>
                        <div class="modal-body p-0">
                            <div class="p-5 text-center"> <i data-lucide="check-circle"
                                    class="w-16 h-16 text-success mx-auto mt-3"></i>
                                <div class="text-3xl mt-5">Verifikasi Jadwal Mapel </div>
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

    <!-- BEGIN: Modal Verifikasi Jadwal Satu-->



    <!-- BEGIN: Modal Tolak Jadwal Satuan-->
    @foreach ($jadwalmapel as $item)
        <div id="tolak-schedule-modal-{{ $item->id }}" class="modal" tabindex="-1" aria-hidden="true"
            aria-labelledby="tolak-schedule-modal-label-{{ $item->id }}">
            <div class="modal-dialog">

                <form method="post" action="{{ route('jadwalmapeltolakone.update', $item->id) }}">
                    @csrf
                    <input type="hidden" value="1" name="status">
                    <div class="modal-content"> <a data-tw-dismiss="modal" href="javascript:;"> <i data-lucide="x"
                                class="w-8 h-8 text-slate-400"></i> </a>
                        <div class="modal-body p-0">
                            <div class="p-5 text-center"> <i data-lucide="x-circle"
                                    class="w-16 h-16 text-danger mx-auto mt-3"></i>
                                <div class="text-3xl mt-5">Tolak Jadwal Mapel </div>
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

    <!-- BEGIN: Modal Verifikasi Jadwal Satu-->




    <!-- BEGIN: Modal PDF-->

    <div id="pdf-modal-preview" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content"> <a data-tw-dismiss="modal" href="javascript:;"> <i data-lucide="x"
                        class="w-8 h-8 text-slate-400"></i> </a>
                <!-- BEGIN: Modal Header -->
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto">Export Pdf Jadwal Mapel</h2>
                    <div class="dropdown sm:hidden"> <a class="dropdown-toggle w-5 h-5 block" href="javascript:;"
                            aria-expanded="false" data-tw-toggle="dropdown"> <i data-lucide="more-horizontal"
                                class="w-5 h-5 text-slate-500"></i> </a>
                        <div class="dropdown-menu w-40">

                        </div>
                    </div>
                </div> <!-- END: Modal Header -->
                <!-- BEGIN: Modal Body -->

                <form method="post" action="{{ route('jadwalkepsekcustom.pdf') }}">
                    @csrf
                    <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                        <div class="col-span-12 sm:col-span-6"> <label for="edit-jam">Kelas </label>
                            <select name="kelas" id="lecturers_id" class="form-control w-full" required>
                                <option value="">Pilih Kelas</option>
                                @php
                                    $addedClassRooms = [];
                                @endphp
                                @foreach ($jadwalmapel as $key => $jadwalmapels)
                                    @if (!in_array($jadwalmapels->pengampus->kelas, $addedClassRooms))
                                        <option value="{{ $jadwalmapels->pengampus->kelas }}">
                                            {{ $jadwalmapels->pengampus->kelass->tingkat }}
                                            {{ $jadwalmapels->pengampus->kelass->nama }}
                                            {{ $jadwalmapels->pengampus->kelass->jurusans->nama }}
                                        </option>
                                        @php
                                            $addedClassRooms[] = $jadwalmapels->pengampus->kelas;
                                        @endphp
                                    @endif
                                @endforeach
                            </select>

                        </div>
                        <div class="col-span-12 sm:col-span-6">
                            <label for="edit-jam">Semester </label>
                            <select name="semester" id="edit-jam" class="form-control w-full" required>
                                <option value="">Pilih Semester</option>
                                @php
                                    $addedSemesters = [];
                                @endphp
                                @foreach ($jadwalmapel->unique('pengampus.mapels.semester') as $jadwalmapels)
                                    @if (!in_array($jadwalmapels->pengampus->mapels->semester, $addedSemesters))
                                        <option value="{{ $jadwalmapels->pengampus->mapels->semester }}">
                                            {{ $jadwalmapels->pengampus->mapels->tahunajars->semester }}
                                            {{ $jadwalmapels->pengampus->mapels->tahunajars->tahun }}

                                        </option>
                                        @php
                                            $addedSemesters[] = $jadwalmapels->pengampus->mapels->semester;
                                        @endphp
                                    @endif
                                @endforeach
                            </select>

                        </div>

                    </div> <!-- END: Modal Body -->
                    <!-- BEGIN: Modal Footer -->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary w-20">Custom</button>
                </form>
                <a href=" {{ route('jadwalkepsek.pdf') }}" type="button" data-tw-dismiss="modal"
                    class="btn btn-outline-secondary w-20 mr-1">All</a>
            </div>




        </div>
    </div>

    <!-- BEGIN: Modal PDF-->


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
