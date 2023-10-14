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
                                    @foreach ($siswa as $key => $item)
                                        @php
                                            $absensi1 = App\Models\Absensi::where('id_siswa', $item->id)->first();
                                            $absensialfa = App\Models\Absensi::where('id_siswa', $item->id)
                                                ->where('status', 0)
                                                ->count();
                                            $absensisakit = App\Models\Absensi::where('id_siswa', $item->id)
                                                ->where('status', 3)
                                                ->count();
                                            $absensiizin = App\Models\Absensi::where('id_siswa', $item->id)
                                                ->where('status', 2)
                                                ->count();
                                        @endphp

                                        @if ($absensi1 && $absensi1->siswass && $absensi1->siswass->kelass && $absensi1->siswass->kelass->jurusans)
                                            <tr>
                                                <td> {{ $key + 1 }} </td>
                                                <td> {{ $absensi1->siswass->nama }} </td>
                                                <td> {{ $absensi1->siswass->nisn }} </td>
                                                <td>
                                                    {{ $absensi1->siswass->kelass->tingkat }}
                                                    {{ $absensi1->siswass->kelass->nama }}
                                                    {{ $absensi1->siswass->kelass->jurusans->nama }}
                                                </td>
                                                <td> {{ $absensi1->siswass->jk }} </td>
                                                <td class="text-warning"> {{ $absensisakit }} </td>
                                                <td class="text-primary"> {{ $absensiizin }} </td>
                                                <td class="text-danger"> {{ $absensialfa }} </td>
                                            </tr>
                                        @endif
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
