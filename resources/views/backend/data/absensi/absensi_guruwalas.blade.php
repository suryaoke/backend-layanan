@extends('admin.admin_master')
@section('admin')
    <div class="mb-3 intro-y flex flex-col sm:flex-row items-center mt-8">
        <h1 class="text-lg font-medium mr-auto">
            Absensi Siswa Walas All
        </h1>

    </div>
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card overflow-x-auto">
                        <div class="card-body">
                            <table id="datatable" class="table table-sm"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>NISN</th>
                                        <th>Kelas</th>
                                        <th>Jk</th>
                                        <th>Sakit</th>
                                        <th>Izin</th>
                                        <th>Alfa</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($absensi->unique('id_siswa') as $key => $item)
                                        @php
                                            $absensialfa = App\Models\Absensi::where('id_siswa', $item->id_siswa)
                                                ->where('status', 0)
                                                ->count();
                                            $absensisakit = App\Models\Absensi::where('id_siswa', $item->id_siswa)
                                                ->where('status', 3)
                                                ->count();
                                            $absensiizin = App\Models\Absensi::where('id_siswa', $item->id_siswa)
                                                ->where('status', 2)
                                                ->count();
                                            $rombelsiswa = App\Models\Rombelsiswa::where('id_siswa', $item->id_siswa)->first();
                                            $rombel = App\Models\Rombel::where('id', $rombelsiswa->id_rombel)->first();
                                            $kelas = App\Models\Kelas::where('id', $rombel->id_kelas)->first();
                                        @endphp

                                        <tr>
                                            <td>{{ $key + 1 }}</td>

                                            <td>{{ $item->siswass->nama }}</td>
                                            <td>{{ $item->siswass->nisn }}</td>
                                            <td> {{ $kelas->tingkat }}{{ $kelas->nama }} {{ $kelas['jurusans']['nama'] }} </td>
                                            <td>{{ $item->siswass->jk }}</td>
                                            <td class="text-danger">{{ $absensialfa }}</td>
                                            <td class="text-primary">{{ $absensiizin }}</td>
                                            <td class="text-warning">{{ $absensisakit }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>


                            </table>

                        </div>
                    </div>
                </div>
            </div>

        </div> <!-- end col -->


    </div> <!-- end row -->
@endsection
