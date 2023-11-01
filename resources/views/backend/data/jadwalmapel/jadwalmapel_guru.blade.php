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

        <form role="form" action="{{ route('jadwalmapel.guru') }}" method="get" class="sm:flex">
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

                <a href="{{ route('jadwalmapel.guru') }}" class="btn btn-danger">Clear</a>

            </div>
        </form>
    </div>
    {{--  // End Bagian search //  --}}


    <div class="col-span-2 mb-4 mt-4">

        <a class="btn btn-success btn-block" href=" ">
            <span class="glyphicon glyphicon-download"></span> </span> <i data-lucide="printer"
                class="w-4 h-4"></i>&nbsp;Export Excel
        </a>
        <a href="javascript:;" data-tw-toggle="modal" data-tw-target="#pdf-modal-preview" class="btn btn-warning"> <span
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
                                <tr >
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
                               

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($jadwalmapel as $key => $item)
                                    @php
                                        $pengampuid = App\Models\Pengampu::find($item->id_pengampu);
                                        if ($pengampuid) {
                                            $mapelid = App\Models\Mapel::find($pengampuid->id_mapel);
                                            $guruid = App\Models\Guru::find($pengampuid->id_guru);
                                            $kelas = App\Models\Kelas::find($pengampuid->kelas);
                                            $jadwal = App\Models\Jadwalmapel::where('id_pengampu', $pengampuid->id)->first();
                                            if ($jadwal) {
                                                $seksi = App\Models\Seksi::where('id_jadwal', $jadwal->id)->first();
                                                if ($seksi) {
                                                    $rombel = App\Models\Rombel::where('id', $seksi->id_rombel)->first();
                                                    if ($rombel) {
                                                        $rombelsiswa = App\Models\Rombelsiswa::where('id_rombel', $rombel->id)->count();
                                                    }
                                                }
                                            }
                                        }
                                    @endphp

                                    <tr>
                                        <td align="center">{{ $key + 1 }}</td>
                                        <td style="white-space: nowrap;" class="text-primary">
                                            {{ $item->kode_jadwalmapel }}
                                        </td>
                                        <td style="white-space: nowrap;" class="text-primary">
                                            {{ $item['pengampus']['kode_pengampu'] }} </td>
                                        <td> {{ $item['haris']['nama'] ?? '' }} </td>
                                        <td> {{ $item['waktus']['range'] ?? '' }} </td>
                                        <td style="white-space: nowrap;"> {{ $guruid->nama ?? '' }} </td>
                                        <td style="white-space: nowrap;"> {{ $mapelid->nama ?? '' }} </td>
                                        <td style="white-space: nowrap;">
                                            @if ($kelas)
                                                {{ $kelas->tingkat }} {{ $kelas->nama }}
                                                {{ $kelas['jurusans']['nama'] ?? '' }}
                                            @endif
                                        </td>
                                        <td> {{ $mapelid->jp ?? '' }} </td>
                                        <td> {{ $item['ruangans']['kode_ruangan'] ?? '' }} </td>
                                        <td style="white-space: nowrap;">
                                            @if ($mapelid && $mapelid['tahunajars'])
                                                {{ $mapelid['tahunajars']['semester'] }}-
                                                {{ $mapelid['tahunajars']['tahun'] }}
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
