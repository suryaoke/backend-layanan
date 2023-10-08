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
                    <input type="text" name="searchkelas" class="form-control" placeholder="Kelas"
                        value="{{ request('searchkelas') }}">
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
                                    <th>Hari</th>
                                    <th>Waktu</th>
                                    <th>Nama Ruangan</th>
                                    <th>Kapasitas Ruangan</th>
                                    <th>Mata Pelajaran</th>
                                    <th>Guru</th>
                                    <th>Semester</th>
                                    <th>JP</th>
                                    <th>Kelas</th>
                                    <th>Kurikulum</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($jadwalmapel as $key => $item)
                                    @php
                                        $pengampuid = App\Models\Pengampu::find($item->id_pengampu);
                                        $mapelid = App\Models\Mapel::find($pengampuid->id_mapel);
                                        $guruid = App\Models\Guru::find($pengampuid->id_guru);
                                    @endphp

                                    <tr>
                                        <td align="center">{{ $key + 1 }}</td>
                                        <td> {{ $item['haris']['nama'] }} </td>
                                        <td> {{ $item['waktus']['range'] }} </td>
                                        <td> {{ $item['ruangans']['nama'] }} </td>
                                        <td> {{ $item['ruangans']['kapasitas'] }} </td>
                                        <td> {{ $mapelid->nama }} </td>
                                        <td> {{ $guruid->nama }} </td>
                                        <td> {{ $mapelid->semester }} </td>
                                        <td> {{ $mapelid->jp }} </td>
                                        <td> {{ $pengampuid->kelas }} </td>
                                        <td> {{ $pengampuid->kurikulum }} </td>



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
