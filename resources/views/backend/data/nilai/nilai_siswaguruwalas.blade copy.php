@extends('admin.admin_master')
@section('admin')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card overflow-x-auto">
                        <div class="card-body">
                            <div class="intro-y box mt-5">
                                <div
                                    class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                                    <h2 class="font-medium text-base mr-auto">
                                        Nilai Harian Kelas :
                                        {{ $rombel['kelass']['tingkat'] }}{{ $rombel['kelass']['nama'] }}
                                        {{ $rombel['kelass']['jurusans']['nama'] }}
                                    </h2>

                                </div>
                                <div id="link-tab" class="p-5">
                                    <div class="preview">
                                        <ul class="nav nav-link-tabs" role="tablist">
                                            <li id="example-5-tab" class="nav-item flex-1" role="presentation">
                                                <button class="nav-link w-full py-2 active" data-tw-toggle="pill"
                                                    data-tw-target="#example-tab-5" type="button" role="tab"
                                                    aria-controls="example-tab-5" aria-selected="true">KI-3 Pengetahuan
                                                </button>
                                            </li>
                                            <li id="example-6-tab" class="nav-item flex-1" role="presentation">
                                                <button class="nav-link w-full py-2" data-tw-toggle="pill"
                                                    data-tw-target="#example-tab-6" type="button" role="tab"
                                                    aria-controls="example-tab-6" aria-selected="false"> KI-4 Keterampilan
                                                </button>
                                            </li>
                                        </ul>

                                        <div class="tab-content mt-5">
                                            {{--  // nilai pengetahuan //  --}}
                                            <div id="example-tab-5" class="tab-pane leading-relaxed active" role="tabpanel"
                                                aria-labelledby="example-5-tab">
                                                <div class="page-content">
                                                    <div class="container-fluid">
                                                        <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                                                            <div class="col-span-12 sm:col-span-6">
                                                                <div
                                                                    class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                                                                    <span>Kompetensi Dasar (KD)</span>

                                                                </div>
                                                                <div id="faq-accordion-2" class="accordion accordion-boxed">
                                                                    <div class="accordion-item">
                                                                        <div id="faq-accordion-content-6"
                                                                            class="accordion-header"> <button
                                                                                class="accordion-button collapsed"
                                                                                type="button" data-tw-toggle="collapse"
                                                                                data-tw-target="#faq-accordion-collapse-6"
                                                                                aria-expanded="false"
                                                                                aria-controls="faq-accordion-collapse-6">
                                                                                PH 1 </button> </div>
                                                                        <div id="faq-accordion-collapse-6"
                                                                            class="accordion-collapse collapse"
                                                                            aria-labelledby="faq-accordion-content-6"
                                                                            data-tw-parent="#faq-accordion-2">
                                                                            <div
                                                                                class="accordion-body text-slate-600 dark:text-slate-500 leading-relaxed">
                                                                                Lorem Ipsum is simply dummy text of the
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-span-12 ml-4 sm:col-span-4">

                                                                <label for="modal-form-6" class="form-label mt-6 mb-4">Mata
                                                                    Pelajaran</label>

                                                                <form role="form"
                                                                    action="{{ route('NilaiSiswaGuruWalas.all') }}"
                                                                    method="get" class="sm:flex">

                                                                    <select name="searchmapel" class="form-select w-full">
                                                                        <option value="">Kelas</option>
                                                                        {{--  @foreach ($kelas as $item)
                                                                                        <option value="{{ $item->id }}">
                                                                                            {{ $item->tingkat }}
                                                                                            {{ $item->nama }}
                                                                                            {{ $item->jurusans->nama }}
                                                                                        </option>
                                                                                    @endforeach  --}}

                                                                        <option value="58">58</option>
                                                                    </select>

                                                                    <div class="sm:ml-1">
                                                                        <button type="submit"
                                                                            class="btn btn-default">Search</button>
                                                                    </div>
                                                                    <div class="sm:ml-2">

                                                                        <a href="{{ route('NilaiSiswaGuruWalas.all') }}"
                                                                            class="btn btn-danger">Clear</a>

                                                                    </div>
                                                                </form>
                                                            </div>

                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="card overflow-x-auto">
                                                                <div class="card-body">
                                                                    <table id="datatable" class="table table-sm"
                                                                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                                        <thead>
                                                                            <tr class="alert-primary">
                                                                                <th>No</th>
                                                                                <th>Nama Siswa</th>
                                                                                <th>NISN</th>


                                                                                @php
                                                                                    $printedPhValues = [];
                                                                                @endphp

                                                                                @foreach ($nilaiSiswaKd3 as $key => $item)
                                                                                    @php
                                                                                        $nilaikd = App\Models\NilaiKd3::find($item->id_nilaikd3);
                                                                                    @endphp

                                                                                    @if ($nilaikd && !in_array($nilaikd->ph, $printedPhValues))
                                                                                        <th>PH {{ $nilaikd->ph }}
                                                                                        </th>
                                                                                        @php
                                                                                            $printedPhValues[] = $nilaikd->ph;
                                                                                        @endphp
                                                                                    @endif
                                                                                @endforeach
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            @php
                                                                                $checkedData = [];
                                                                            @endphp

                                                                            @foreach ($nilaiSiswaKd3 as $key => $item)
                                                                                @php
                                                                                    $idRombelsiswa = $item['id_rombelsiswa'];
                                                                                    $idSeksi = $item->nilaikd3->id_seksi;

                                                                                    // Check if the combination of id_rombelsiswa and id_seksi has been checked before
                                                                                    $isDuplicate = false;
                                                                                    foreach ($checkedData as $data) {
                                                                                        if ($data['id_rombelsiswa'] == $idRombelsiswa && $data['id_seksi'] == $idSeksi) {
                                                                                            $isDuplicate = true;
                                                                                            break;
                                                                                        }
                                                                                    }
                                                                                    // If the combination is a duplicate, continue to the next iteration
                                                                                    if ($isDuplicate) {
                                                                                        continue;
                                                                                    }
                                                                                    // If the combination is not a duplicate, add it to the checkedData
                                                                                    $checkedData[] = ['id_rombelsiswa' => $idRombelsiswa, 'id_seksi' => $idSeksi];
                                                                                @endphp

                                                                                <tr>
                                                                                    <td>{{ $key + 1 }}</td>
                                                                                    <td>{{ $item['rombelsiswa']['siswas']['nama'] }}
                                                                                    </td>
                                                                                    <td>{{ $item['rombelsiswa']['siswas']['nisn'] }}
                                                                                    </td>

                                                                                    @foreach ($printedPhValues as $phValue)
                                                                                        <td>
                                                                                            @foreach ($nilaiSiswaKd3 as $nilai)
                                                                                                @if (
                                                                                                    $nilai->nilaikd3->ph == $phValue &&
                                                                                                        $nilai['id_rombelsiswa'] == $idRombelsiswa &&
                                                                                                        $nilai->nilaikd3->id_seksi == $idSeksi)
                                                                                                    {{ $nilai->nilai }}
                                                                                                @endif
                                                                                            @endforeach
                                                                                        </td>
                                                                                    @endforeach
                                                                                </tr>
                                                                            @endforeach
                                                                        </tbody>
                                                                    </table>


                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div> <!-- end col -->


                                            </div>

                                        </div>

                                        {{--  //Ki4 keterampilan //  --}}
                                        <div id="example-tab-6" class="tab-pane leading-relaxed" role="tabpanel"
                                            aria-labelledby="example-6-tab">

                                            <div class="page-content">
                                                <div class="container-fluid">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="card overflow-x-auto">
                                                                <div class="card-body">
                                                                    <table id="datatable1" class="table table-sm"
                                                                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                                        <thead>
                                                                            <tr class=" alert-primary ">
                                                                                <th>No</th>
                                                                                <th>Nama</th>
                                                                                <th>NISN</th>
                                                                                <th>Jk</th>
                                                                                <th>Hadir</th>
                                                                                <th>Sakit</th>
                                                                                <th>Izin</th>
                                                                                <th>Alfa</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            @foreach ($nilaiSiswaKd3 as $key => $item)
                                                                                {{--  @php
                                                                                        $absensialfa = App\Models\Absensi::where('id_siswa', $item->id_siswa)
                                                                                            ->where('status', 0)
                                                                                            ->count();
                                                                                        $absensisakit = App\Models\Absensi::where('id_siswa', $item->id_siswa)
                                                                                            ->where('status', 3)
                                                                                            ->count();
                                                                                        $absensiizin = App\Models\Absensi::where('id_siswa', $item->id_siswa)
                                                                                            ->where('status', 2)
                                                                                            ->count();

                                                                                        $absensihadir = App\Models\Absensi::where('id_siswa', $item->id_siswa)
                                                                                            ->where('status', 1)
                                                                                            ->count();
                                                                                        $rombelsiswa = App\Models\Rombelsiswa::where('id_siswa', $item->id_siswa)->first();
                                                                                        $rombel = App\Models\Rombel::where('id', $rombelsiswa->id_rombel)->first();
                                                                                        $kelas = App\Models\Kelas::where('id', $rombel->id_kelas)->first();
                                                                                    @endphp  --}}

                                                                                <tr>
                                                                                    {{--  <td>{{ $key + 1 }}</td>

                                                                                        <td>{{ $item->siswass->nama }}</td>
                                                                                        <td>{{ $item->siswass->nisn }}</td>

                                                                                        <td>{{ $item->siswass->jk }}</td>
                                                                                        <td class="text-success">
                                                                                            {{ $absensihadir }}</td>
                                                                                        <td class="text-danger">
                                                                                            {{ $absensialfa }}</td>
                                                                                        <td class="text-primary">
                                                                                            {{ $absensiizin }}</td>
                                                                                        <td class="text-warning">
                                                                                            {{ $absensisakit }}</td>  --}}

                                                                                    <td> {{ $item->id }} </td>
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
