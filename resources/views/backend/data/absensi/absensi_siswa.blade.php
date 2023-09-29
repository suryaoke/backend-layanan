@extends('admin.admin_master')
@section('admin')
    @php
        $absensii = route('absensi.siswa');
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
                    $kelas2 = app\Models\Kelas::find($kelas1);
                @endphp

                @if ($kelas2)
                    Absensi Kelas &nbsp : {{ $kelas2->nama }} <br> Mata Pelajaran : {{ $mapel }}
                @endif
            @else
                Pilih Data Absensi Siswa
            @endif
        </h1>


    </div>
    <div class="mb-4 intro-y flex flex-col sm:flex-row items-center ">
        <div class="w-full sm:w-auto flex mt-4 sm:mt-0">

            <form method="get" action="">
                <div
                    class="absolute rounded-l w-10 h-full flex items-center justify-center bg-slate-100 border text-slate-500 dark:bg-darkmode-700 dark:border-darkmode-800 dark:text-slate-400">
                    <i data-lucide="calendar" class="w-4 h-4"></i>
                </div> <input type="text" class="datepicker   pl-12" data-single-mode="true" placeholder="Tanggal"
                    name="tanggal" id="tanggal" value="{{ Request::get('tanggal') ?? date('d/m/Y') }}">

                <select name="kelas">
                    <option value="" disabled selected>Pilih kelas</option>
                    @foreach ($kelas as $item)
                        @php
                            $siswadata = app\Models\Siswa::where('kelas', $item->id)->first();
                        @endphp
                        @if ($siswadata != null)
                            <option value="{{ $item->id }}" {{ Request::get('kelas') == $item->id ? 'selected' : '' }}>
                                {{ $item->nama }}
                            </option>
                        @endif
                    @endforeach
                </select>

                <select name="mapel">
                    <option value="" disabled selected>Pilih Mata Pelajaran</option>

                    <option value="fisika" {{ Request::get('mapel') == 'fisika' ? 'selected' : '' }}>
                        fisika
                    </option>
                    <option value="bindo" {{ Request::get('mapel') == 'bindo' ? 'selected' : '' }}>
                        bindo
                    </option>

                </select>
                <button type="submit" class="btn btn-primary">Search</button>
                @if ($currentUrl != $absensii || $tanggalParam)
                    <a href="{{ route('absensi.siswa') }}" class="btn btn-danger">Clear</a>
                @endif


            </form>


        </div>
    </div>
    @if ($currentUrl1 != $absensii || $tanggalParam)
        @php
            $kelas2 = app\Models\Kelas::find($kelas1);
        @endphp

        @if ($kelas2)
            <form method="post" action="{{ route('absensi.siswa.store') }}" enctype="multipart/form-data" id="myForm">
                @csrf

                <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
                    <table class="table table-report -mt-2">
                        <thead>
                            <tr>
                                <th class="whitespace-nowrap">No</th>
                                <th class="whitespace-nowrap">Nama</th>
                                <th class="whitespace-nowrap">NISN</th>
                                <th class="whitespace-nowrap">Tanggal</th>
                                <th class="whitespace-nowrap">Status</th>
                                <th class="whitespace-nowrap">Ket</th>
                                <th class="whitespace-nowrap">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($absensi as $key => $item)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    @if ($item->siswass != null)
                                        <td>{{ $item->siswass->nama }}</td>
                                        <td>{{ $item->siswass->nisn }}</td>
                                    @else
                                        <td></td>
                                        <td></td>
                                    @endif
                                    <td>{{ $item->tanggal }}</td>
                                    <td>
                                        <div class="flex flex-col sm:flex-row mt-2">
                                            <div class="form-check mr-2">
                                                <input class="form-check-input" type="radio"
                                                    name="status[{{ $item->id }}]" value="0"
                                                    @if ($item->status == '0') checked @endif>
                                                <label class="form-check-label" for="status_hadir">A</label>
                                            </div>
                                            <div class="form-check mr-2">
                                                <input class="form-check-input" type="radio"
                                                    name="status[{{ $item->id }}]" value="1"
                                                    @if ($item->status == '1') checked @endif>
                                                <label class="form-check-label" for="status_hadir">H</label>
                                            </div>
                                            <div class="form-check mr-2">
                                                <input class="form-check-input" type="radio"
                                                    name="status[{{ $item->id }}]" value="2"
                                                    @if ($item->status == '2') checked @endif>
                                                <label class="form-check-label" for="status_izin">I</label>
                                            </div>
                                            <div class="form-check mr-2">
                                                <input class="form-check-input" type="radio"
                                                    name="status[{{ $item->id }}]" value="3"
                                                    @if ($item->status == '3') checked @endif>
                                                <label class="form-check-label" for="status_sakit">S</label>
                                            </div>
                                        </div>
                                    </td>
                                    <td><input name="ket[{{ $item->id }}]" type="text" class="form-control"
                                            placeholder="Keterangan" value="{{ $item->ket }}"></td>
                                    <td><a id="delete" href="{{ route('absensi.delete', $item->id) }}"
                                            class="btn btn-danger mr-1 mb-2">
                                            <i data-lucide="trash" class="w-5 h-5"></i> </a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div style="float:right;" class="mb-3 ml-1 intro-y flex flex-col sm:flex-row items-center mt-4">
                        <button type="submit" class="btn btn-primary"><i data-lucide="user-check" class="w-5 h-5"></i>
                            &nbsp; Save </button>
                    </div>
                    <div style="float:right;" class="mb-3 intro-y flex flex-col sm:flex-row items-center mt-4">
                        <a href="{{ route('absensi.all') }}" class="btn btn-warning">Back </a>
                    </div>
                </div>
                <!-- END: Data List -->
            </form>
        @endif
    @else
        <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
            <table class="table table-report -mt-2">
                <thead>
                    <tr>
                        <th class="whitespace-nowrap">No</th>
                        <th class="whitespace-nowrap">Nama</th>
                        <th class="whitespace-nowrap">NISN</th>
                        <th class="whitespace-nowrap">Tanggal</th>
                        <th class="whitespace-nowrap">Status</th>
                        <th class="whitespace-nowrap">Ket</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-center" colspan="6">Pilih Data Absensi</td>
                    </tr>
                </tbody>
            </table>

        </div>
    @endif
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
