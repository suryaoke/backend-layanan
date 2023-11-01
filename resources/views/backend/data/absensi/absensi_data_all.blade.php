@extends('admin.admin_master')
@section('admin')
    @php
        $absensii = route('absensi.data.all');
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
                Absensi Siswa All
            @endif
        </h1>


    </div>
    <div class="intro-y flex flex-col sm:flex-row items-center ">

        <div class="w-full sm:w-auto flex mt-4 sm:mt-0">

            <form role="form" action="{{ route('absensi.data.all') }}" method="get" class="sm:flex">

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
                            value="{{ request('searchmapel') }}" required>
                    </div>
                </div>
                <div class="flex-1 sm:mr-2">
                    <div class="form-group">

                        <select name="searchkelas" class="form-select w-full" required>
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

                    <a href="{{ route('absensi.data.all') }}" class="btn btn-danger">Clear</a>

                </div>
            </form>

        </div>

    </div>

    <div class="col-span-2  mt-4">

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
                    <div class="card overflow-x-auto">
                        <div class="card-body">
                            <div class="intro-y box mt-5">
                                <div
                                    class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">

                                </div>
                                <div id="link-tab" class="p-5">
                                    <div class="preview">
                                        <ul class="nav nav-link-tabs" role="tablist">
                                            <li id="example-5-tab" class="nav-item flex-1" role="presentation">
                                                <button class="nav-link w-full py-2 active" data-tw-toggle="pill"
                                                    data-tw-target="#example-tab-5" type="button" role="tab"
                                                    aria-controls="example-tab-5" aria-selected="true">Harian Absensi
                                                </button>
                                            </li>
                                            <li id="example-6-tab" class="nav-item flex-1" role="presentation">
                                                <button class="nav-link w-full py-2" data-tw-toggle="pill"
                                                    data-tw-target="#example-tab-6" type="button" role="tab"
                                                    aria-controls="example-tab-6" aria-selected="false"> Rekap Absensi
                                                </button>
                                            </li>
                                        </ul>

                                        <div class="tab-content mt-5">
                                            {{--  // absensi harian //  --}}
                                            <div id="example-tab-5" class="tab-pane leading-relaxed active" role="tabpanel"
                                                aria-labelledby="example-5-tab">
                                                <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">

                                                    <table id="datatable1" class="table table-report -mt-2">
                                                        <thead>
                                                            <tr class=" alert-primary">
                                                                <th class="whitespace-nowrap">No</th>
                                                                <th class="whitespace-nowrap">Nama</th>
                                                                <th class="whitespace-nowrap">NISN</th>
                                                                <th class="whitespace-nowrap">Kelas</th>
                                                                <th class="whitespace-nowrap">Tanggal</th>
                                                                <th class="whitespace-nowrap">Kode Mapel</th>
                                                                <th class="whitespace-nowrap">Nama Mapel</th>
                                                                <th class="whitespace-nowrap">Status</th>
                                                                <th class="whitespace-nowrap">Ket</th>

                                                            </tr>
                                                        </thead>
                                                        <tbody>

                                                            @foreach ($absensi as $key => $item)
                                                                <tr>
                                                                    @php
                                                                        $jadwal = App\Models\Jadwalmapel::where('id', $item->id_jadwal)->first();
                                                                        $pengampu = App\Models\Pengampu::where('id', $jadwal->id_pengampu)->first();
                                                                        $mapel = App\Models\Mapel::where('id', $pengampu->id_mapel)->first();
                                                                        $seksi = App\Models\Seksi::where('id', $item->id_jadwal)->first();
                                                                        $rombelsiswa = App\Models\Rombelsiswa::where('id_siswa', $item->id_siswa)->first();
                                                                        $rombel = App\Models\Rombel::where('id', $rombelsiswa->id_rombel)->first();
                                                                        // $kelas = App\Models\Kelas::where('id', $rombel->id_kelas)->first();
                                                                    @endphp
                                                                    <td> {{ $key + 1 }} </td>
                                                                    @if ($item['siswass'] != null)
                                                                        <td>{{ $item['siswass']['nama'] }}</td>
                                                                        <td>{{ $item['siswass']['nisn'] }}</td>
                                                                        <td>{{ $rombel['kelass']['tingkat'] }}
                                                                            {{ $rombel['kelass']['nama'] }}
                                                                            {{ $rombel['kelass']['jurusans']['nama'] }}
                                                                        </td>
                                                                    @else
                                                                        <td></td>
                                                                        <td></td>
                                                                        <td></td>
                                                                    @endif

                                                                    <td>{{ $item->tanggal }}</td>
                                                                    <td> {{ $mapel->kode_mapel }}</td>
                                                                    <td> {{ $mapel->nama }}</td>
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


                                                </div>
                                            </div>

                                            {{--  // absensi Rekap //  --}}
                                            <div id="example-tab-6" class="tab-pane leading-relaxed" role="tabpanel"
                                                aria-labelledby="example-6-tab">

                                                <div class="page-content">
                                                    <div class="container-fluid">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="card overflow-x-auto">
                                                                    <div class="card-body">
                                                                        <table id="datatable" class="table table-sm"
                                                                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                                            <thead>
                                                                                <tr class=" alert-primary ">
                                                                                    <th>No</th>
                                                                                    <th>Nama</th>
                                                                                    <th>NISN</th>
                                                                                    <th>Kelas</th>
                                                                                    <th>Jk</th>
                                                                                    <th>Kode
                                                                                        Mapel</th>
                                                                                    <th>Nama
                                                                                        Mapel</th>
                                                                                    <th>Hadir</th>
                                                                                    <th>Sakit</th>
                                                                                    <th>Izin</th>
                                                                                    <th>Alfa</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                @php
                                                                                    $uniqueCombination = [];
                                                                                @endphp
                                                                                @foreach ($absensi as $key => $item)
                                                                                    @php
                                                                                        $currentCombination = $item->id_siswa . '-' . $item->id_jadwal;
                                                                                    @endphp

                                                                                    @if (!in_array($currentCombination, $uniqueCombination))
                                                                                        @php
                                                                                            array_push($uniqueCombination, $currentCombination);

                                                                                            $absensialfa = App\Models\Absensi::where('id_siswa', $item->id_siswa)
                                                                                                ->where('id_jadwal', $item->id_jadwal)
                                                                                                ->where('status', 0)
                                                                                                ->count();
                                                                                            $absensisakit = App\Models\Absensi::where('id_siswa', $item->id_siswa)
                                                                                                ->where('id_jadwal', $item->id_jadwal)
                                                                                                ->where('status', 3)
                                                                                                ->count();
                                                                                            $absensiizin = App\Models\Absensi::where('id_siswa', $item->id_siswa)
                                                                                                ->where('id_jadwal', $item->id_jadwal)
                                                                                                ->where('status', 2)
                                                                                                ->count();
                                                                                            $absensihadir = App\Models\Absensi::where('id_siswa', $item->id_siswa)
                                                                                                ->where('id_jadwal', $item->id_jadwal)
                                                                                                ->where('status', 1)
                                                                                                ->count();
                                                                                            $jadwal = App\Models\Jadwalmapel::where('id', $item->id_jadwal)->first();
                                                                                            $pengampu = App\Models\Pengampu::where('id', $jadwal->id_pengampu)->first();
                                                                                            $mapel = App\Models\Mapel::where('id', $pengampu->id_mapel)->first();
                                                                                            $rombelsiswa = App\Models\Rombelsiswa::where('id_siswa', $item->id_siswa)->first();
                                                                                            $rombel = App\Models\Rombel::where('id', $rombelsiswa->id_rombel)->first();
                                                                                            $kelas = App\Models\Kelas::where('id', $rombel->id_kelas)->first();

                                                                                        @endphp

                                                                                        <tr>
                                                                                            <td>{{ $key + 1 }}
                                                                                            </td>
                                                                                            <td>{{ $item->siswass->nama }}
                                                                                            </td>
                                                                                            <td>{{ $item->siswass->nisn }}
                                                                                            </td>
                                                                                            <td> {{ $kelas->tingkat }}{{ $kelas->nama }}
                                                                                                {{ $kelas['jurusans']['nama'] }}
                                                                                            </td>
                                                                                            <td>{{ $item->siswass->jk }}
                                                                                            </td>
                                                                                            <td> {{ $mapel->kode_mapel }}
                                                                                            </td>
                                                                                            <td> {{ $mapel->nama }}
                                                                                            </td>
                                                                                            <td class="text-success">
                                                                                                {{ $absensihadir }}
                                                                                            </td>
                                                                                            <td class="text-warning">
                                                                                                {{ $absensisakit }}
                                                                                            </td>
                                                                                            <td class="text-primary">
                                                                                                {{ $absensiizin }}
                                                                                            </td>
                                                                                            <td class="text-danger">
                                                                                                {{ $absensialfa }}
                                                                                            </td>

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

                                            </div>
                                        </div>
                                    </div>
                                    <div class="source-code hidden">
                                        <button data-target="#copy-link-tab"
                                            class="copy-code btn py-1 px-2 btn-outline-secondary"> <i data-lucide="file"
                                                class="w-4 h-4 mr-2"></i> Copy example code </button>
                                        <div class="overflow-y-auto mt-3 rounded-md">
                                            <pre id="copy-link-tab" class="source-preview"> <code class="html"> HTMLOpenTagul class=&quot;nav nav-link-tabs&quot; role=&quot;tablist&quot;HTMLCloseTag HTMLOpenTagli id=&quot;example-5-tab&quot; class=&quot;nav-item flex-1&quot; role=&quot;presentation&quot;HTMLCloseTag HTMLOpenTagbutton class=&quot;nav-link w-full py-2 active&quot; data-tw-toggle=&quot;pill&quot; data-tw-target=&quot;#example-tab-5&quot; type=&quot;button&quot; role=&quot;tab&quot; aria-controls=&quot;example-tab-5&quot; aria-selected=&quot;true&quot; HTMLCloseTag Example Tab 1 HTMLOpenTag/buttonHTMLCloseTag HTMLOpenTag/liHTMLCloseTag HTMLOpenTagli id=&quot;example-6-tab&quot; class=&quot;nav-item flex-1&quot; role=&quot;presentation&quot;HTMLCloseTag HTMLOpenTagbutton class=&quot;nav-link w-full py-2&quot; data-tw-toggle=&quot;pill&quot; data-tw-target=&quot;#example-tab-6&quot; type=&quot;button&quot; role=&quot;tab&quot; aria-controls=&quot;example-tab-6&quot; aria-selected=&quot;false&quot; HTMLCloseTag Example Tab 2 HTMLOpenTag/buttonHTMLCloseTag HTMLOpenTag/liHTMLCloseTag HTMLOpenTag/ulHTMLCloseTag HTMLOpenTagdiv class=&quot;tab-content mt-5&quot;HTMLCloseTag HTMLOpenTagdiv id=&quot;example-tab-5&quot; class=&quot;tab-pane leading-relaxed active&quot; role=&quot;tabpanel&quot; aria-labelledby=&quot;example-5-tab&quot;HTMLCloseTag Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#039;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum. HTMLOpenTag/divHTMLCloseTag HTMLOpenTagdiv id=&quot;example-tab-6&quot; class=&quot;tab-pane leading-relaxed&quot; role=&quot;tabpanel&quot; aria-labelledby=&quot;example-6-tab&quot;HTMLCloseTag It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using &#039;Content here, content here&#039;, making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for &#039;lorem ipsum&#039; will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like). HTMLOpenTag/divHTMLCloseTag HTMLOpenTag/divHTMLCloseTag </code> </pre>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->



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

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var table = $('#datatable1').DataTable(); // Inisialisasi DataTable
            $('#searchInput').on('keyup', function() {
                table.search(this.value).draw();
            });

            // Hapus DataTable sebelum menginisialisasi kembali
            if ($.fn.DataTable.isDataTable('#datatable2')) {
                $('#datatable2').DataTable().destroy();
            }

            // Menginisialisasi DataTable kembali dengan paginasi
            $('#datatable2').DataTable({
                paging: true
            });
        });
    </script>
@endsection
