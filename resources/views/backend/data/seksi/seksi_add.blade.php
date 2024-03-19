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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script> <!-- Include jQuery Validation plugin -->
    <div class="intro-y flex items-center mt-8 mb-4">
        <h1 class="text-lg font-medium mr-auto">
            Add Data Seksi
        </h1>
    </div>
    <form method="post" action="{{ route('seksi.store') }}" enctype="multipart/form-data" id="myForm">
        @csrf

        <div class="mt-4">
            <label for="">Tahun Ajar</label>
            <div class="mt-1 flex">
                <div
                    class="z-30 rounded-l w-10 flex items-center justify-center
             bg-slate-100 border text-slate-500 dark:bg-darkmode-700 dark:border-darkmode-800
              dark:text-slate-400 -mr-1">
                    <i data-lucide="tag"></i>
                </div>
                <select name="semester" id="semester" class="tom-select  w-full " required>
                    <option value="">Pilih Kelas</option>
                    @foreach ($semester as $item)
                        <option value="{{ $item->id }}">{{ $item->semester }} - {{ $item->tahun }}</option>
                    @endforeach
                </select>
            </div>
            <span id="error-kelas" class="text-sm text-red-600"></span>
        </div>


        <div class="mt-4">
            <label for="">Kelas / Rombongan Belajar</label>

            <div class="mt-1 flex">
                <div
                    class="z-30 rounded-l w-10 flex items-center justify-center
             bg-slate-100 border text-slate-500 dark:bg-darkmode-700 dark:border-darkmode-800
              dark:text-slate-400 -mr-1">
                    <i data-lucide="users"></i>
                </div>
                <select name="id_rombel" id="id_rombel" class="tom-select w-full" required>
                    <option value="">Pilih Rombel</option>

                    @foreach ($rombel as $item)
                        @php

                            $jadwals = App\Models\Jadwalmapel::join(
                                'pengampus',
                                'pengampus.id',
                                '=',
                                'jadwalmapels.id_pengampu',
                            )
                                ->join('rombels', 'rombels.id_kelas', '=', 'pengampus.kelas')
                                ->where('rombels.id', $item->id)
                                ->where('id_tahunajar', $item->id_tahunjar)
                                ->where('status', '2')
                                ->select('jadwalmapels.*')
                                ->whereNotExists(function ($query) {
                                    $query
                                        ->select(DB::raw(1))
                                        ->from('seksis')
                                        ->whereRaw('seksis.id_jadwal = jadwalmapels.id');
                                })
                                ->get();

                            $jadwalsData = [];
                            $mapelsData = [];
                            $seksiData = [];
                            $guruData = [];
                            $kodeData = [];
                            $kelasData = [];

                            foreach ($jadwals as $jadwal) {
                                $jadwalsData[] = $jadwal->id;
                                $mapelsData[] = $jadwal->pengampus->mapels->nama;
                                $seksiData[] = $jadwal->kode_jadwalmapel;
                                $guruData[] = $jadwal->pengampus->gurus->nama;
                                $kodeData[] = $jadwal->pengampus->kode_pengampu;
                                $kelasData[] =
                                    $jadwal->pengampus->kelass->tingkat .
                                    '' .
                                    $jadwal->pengampus->kelass->nama .
                                    '' .
                                    $jadwal->pengampus->kelass->jurusans->nama;
                            }
                        @endphp
                        <option value="{{ $item->id }}" data-jadwal="{{ json_encode($jadwalsData) }}"
                            data-mapel="{{ json_encode($mapelsData) }}" data-seksi="{{ json_encode($seksiData) }}"
                            data-guru="{{ json_encode($guruData) }}" data-kode="{{ json_encode($kodeData) }}"
                            data-kelas="{{ json_encode($kelasData) }}">

                            {{ $item->kelass->tingkat }}
                            {{ $item->kelass->nama }} {{ $item->kelass->jurusans->nama }}
                            - {{ $item->tahuns->semester }} - {{ $item->tahuns->tahun }}
                        </option>
                    @endforeach
                </select>



            </div>
            <span id="error-kelas" class="text-sm text-red-600"></span>
        </div>



        <div class="mt-4">

            <div class="mt-1">
                <table id="datatable" class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="px-4 py-2">Seksi</th>
                            <th class="px-4 py-2">Kode</th>
                            <th class="px-4 py-2">Mata Pelajaran</th>
                            <th class="px-4 py-2">Guru</th>
                            <th class="px-4 py-2">Kelas</th>

                        </tr>
                    </thead>
                    <tbody id="table-body">
                        <!-- Data mata pelajaran akan diisi di sini -->
                    </tbody>
                </table>
            </div>
            <span id="error-matpel" class="text-sm text-red-600"></span>
        </div>


        <div class="mt-4">
            <a class="btn btn-danger mt-2 w-full h-10 xl:w-32 xl:mr-2 align-top" href="{{ route('seksi.all') }}">Cancel
            </a>
            <button class="btn btn-primary mt-2  w-full  h-10  xl:w-32 xl:mr-3 align-top" type="submit">Save</button>

        </div>
    </form>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script type="text/javascript">
        jQuery(document).ready(function() {
            $('#myForm').validate({
                ignore: [],
                rules: {
                    semester: {
                        required: true,
                    },
                    id_rombel: {
                        required: true,
                    },
                    id_jadwal: {
                        required: true,
                    },
                    guru: {
                        required: true,
                    },

                },
                messages: {
                    Semester: {
                        required: 'Please Enter Your Semester',
                    },
                    id_rombel: {
                        required: 'Please Enter Your Rombel',
                    },
                    id_jadwal: {
                        required: 'Please Enter Your Jadwal',
                    },
                    guru: {
                        required: 'Please Enter Your Guru',
                    },
                },
                errorElement: 'span',
                errorClass: 'invalid-feedback',
                errorPlacement: function(error, element) {
                    error.addClass('block text-sm text-red-600');
                    error.appendTo(element.parent().next());
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


    <script>
        document.getElementById("id_rombel").addEventListener("change", function() {
            var selectedOption = this.options[this.selectedIndex];

            var pengampusData = JSON.parse(selectedOption.getAttribute("data-jadwal"));
            var mapelsData = JSON.parse(selectedOption.getAttribute("data-mapel"));
            var seksiData = JSON.parse(selectedOption.getAttribute("data-seksi"));
            var guruData = JSON.parse(selectedOption.getAttribute("data-guru"));
            var kodeData = JSON.parse(selectedOption.getAttribute("data-kode"));
            var kelasData = JSON.parse(selectedOption.getAttribute("data-kelas"));

            var tableBody = document.getElementById("table-body");
            tableBody.innerHTML = ''; // Menghapus data sebelumnya dari tabel

            if (pengampusData) {
                for (var i = 0; i < pengampusData.length; i++) {
                    var row = tableBody.insertRow();
                    var cell1 = row.insertCell(0);
                    var cell2 = row.insertCell(1);
                    var cell3 = row.insertCell(2);
                    var cell4 = row.insertCell(3);
                    var cell5 = row.insertCell(4);

                    cell1.innerHTML = seksiData[i];
                    cell2.innerHTML = kodeData[i];
                    cell3.innerHTML = mapelsData[i];
                    cell4.innerHTML = guruData[i];
                    cell5.innerHTML = kelasData[i];

                }
            }
        });
    </script>



@endsection
