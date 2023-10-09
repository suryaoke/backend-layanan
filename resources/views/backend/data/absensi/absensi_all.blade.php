@extends('admin.admin_master')
@section('admin')
    @php
        $absensii = route('absensi.all');
        $currentUrl = url()->current();
        $tanggalParam = request()->query('tanggal'); // Mengambil nilai parameter tanggal dari URL
        
    @endphp
    <div class="mb-3 intro-y flex flex-col sm:flex-row items-center mt-8">
        <h1 class="text-lg font-medium mr-auto">
            @php
                $currentUrl1 = request()->fullUrl(); // Pastikan Anda telah mendefinisikan $absensii dan $tanggalParam
                $kelas1 = request()->query('kelas');
                $mapel = request()->query('mapel');
            @endphp

            @if ($currentUrl1 != $absensii || $tanggalParam)
                @php
                    $kelas2 = App\Models\Kelas::find($kelas1);
                @endphp

                @if ($kelas2)
                    Absensi Kelas &nbsp : {{ $kelas2->nama }} <br> Mata Pelajaran : {{ $mapel }}
                @endif
            @else
                Absensi All
            @endif
        </h1>
        <div class="mr-8"> <a href="{{ route('absensi.siswa') }}" class="btn btn-success"><i data-lucide="user-check"
                    class="w-5 h-5"></i> &nbsp
                Absensi </a></div>

    </div>
    <div class="mb-8 intro-y flex flex-col sm:flex-row items-center ">


        <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
            <a href="{{ route('absensi.add') }}" class="btn btn-primary shadow-md mr-2"> <i data-lucide="file-plus"
                    class="w-5 h-5"></i> &nbsp Form Absensi</a>

        </div>
        <div class="w-full sm:w-auto flex mt-4 sm:mt-0">

            <form role="form" action="{{ route('absensi.all') }}" method="get" class="sm:flex">

                <div class="flex-1 sm:mr-2">
                    <div class="form-group">
                        <div
                            class="absolute rounded-l w-10 h-full flex items-center justify-center bg-slate-100 border text-slate-500 dark:bg-darkmode-700 dark:border-darkmode-800 dark:text-slate-400">
                            <i data-lucide="calendar" class="w-4 h-4"></i>
                        </div>
                        <input type="text" name="searchhari" class="datepicker pl-12" data-single-mode="true"
                            placeholder="Hari" value="{{ request('searchhari') }}">

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

                    <a href="{{ route('absensi.all') }}" class="btn btn-danger">Clear</a>

                </div>
            </form>

        </div>
    </div>


    <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">

        <table class="table table-report -mt-2">
            <thead>
                <tr>
                    <th class="whitespace-nowrap">No</th>
                    <th class="whitespace-nowrap">Nama</th>
                    <th class="whitespace-nowrap">NISN</th>
                    <th class="whitespace-nowrap">Kelas</th>
                    <th class="whitespace-nowrap">Tanggal</th>
                    <th class="whitespace-nowrap">Mapel</th>
                    <th class="whitespace-nowrap">Status</th>
                    <th class="whitespace-nowrap">Ket</th>

                </tr>
            </thead>
            <tbody>

                @foreach ($absensi as $key => $item)
                    <tr>
                        <td> {{ $key + 1 }} </td>
                        @if ($item['siswass'] != null)
                            <td>{{ $item['siswass']['nama'] }}</td>
                            <td>{{ $item['siswass']['nisn'] }}</td>
                            <td>{{ $item['siswass']['kelass']['nama'] }}</td>
                        @else
                            <td></td>
                            <td></td>
                            <td></td>
                        @endif

                        <td>{{ $item->tanggal }}</td>
                        <td>
                            @php
                                $jadwal = App\Models\Jadwalmapel::where('id', $item->id_jadwal)->first();
                                $pengampu = App\Models\Pengampu::where('id', $jadwal->id_pengampu)->first();
                                $mapel = App\Models\Mapel::where('id', $pengampu->id_mapel)->first();
                            @endphp
                            {{ $mapel->nama }}</td>
                        <td>

                            @if ($item->status == '0')
                                <span class="text-danger">
                                    Alfa</span>
                            @elseif($item->status == '1')
                                <span class="text-success">
                                    Hadir</span>
                            @elseif($item->status == '2')
                                <span class="text-primary">
                                    Izin</span>
                            @elseif($item->status == '3')
                                <span class="text-warning">
                                    Sakit</span @endif
                        </td>
                        <td>
                            @if ($item->ket == null)
                                -
                            @else
                                {{ $item->ket }}
                            @endif

                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
        <div class="mt-4 float-right">

            {{ $absensi->links() }}

        </div>

    </div>


    <!-- END: Data List -->


    <script type="text/javascript">
        jQuery(document).ready(function() {
            $('#myForm').validate({
                rules: {
                    tanggal: {
                        required: true,
                    },
                    kelas: {
                        required: true,
                    },
                    mapel: {
                        required: true,
                    },
                    messages: {
                        tanggal: {
                            required: 'Please Enter Your Nama',
                        },
                        kelas: {
                            required: 'Please Enter Your NISN',
                        },
                        mapel: {
                            required: 'Please Enter Your Kelas',
                        },

                    },
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
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
@endsection
