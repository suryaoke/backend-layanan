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
                                        Nilai Harian : {{ $pengampu['mapels']['nama'] }}
                                        {{ $pengampu['kelass']['tingkat'] }}
                                        {{ $pengampu['kelass']['nama'] }} {{ $pengampu['kelass']['jurusans']['nama'] }}

                                    </h2>

                                </div>
                                <div id="link-tab" class="p-5">
                                    <div class="preview">
                                        <ul class="nav nav-link-tabs" role="tablist">
                                            <li id="example-5-tab" class="nav-item flex-1" role="presentation">
                                                <button class="nav-link w-full py-2 active" data-tw-toggle="pill"
                                                    data-tw-target="#example-tab-5" type="button" role="tab"
                                                    aria-controls="example-tab-5" aria-selected="true">KD 3 - Pengetahuan
                                                </button>
                                            </li>
                                            <li id="example-6-tab" class="nav-item flex-1" role="presentation">
                                                <button class="nav-link w-full py-2" data-tw-toggle="pill"
                                                    data-tw-target="#example-tab-6" type="button" role="tab"
                                                    aria-controls="example-tab-6" aria-selected="false"> KD 4 - Keterampilan
                                                </button>
                                            </li>
                                        </ul>

                                        <div class="tab-content mt-5">
                                            {{--  // nilai pengetahuan //  --}}
                                            <div id="example-tab-5" class="tab-pane leading-relaxed active" role="tabpanel"
                                                aria-labelledby="example-5-tab">
                                                <div class="w-full sm:w-auto flex mt-4 sm:mt-0 float-right ml-4 mb-4">
                                                    <a data-tw-toggle="modal" data-tw-target="#pengetahuan-modal-preview"
                                                        class="btn btn-primary shadow-md mr-2"> <i data-lucide="plus"></i>
                                                        Nilai Pengetahuan</a>

                                                </div>
                                                <div class="mt-8">
                                                    <table id="datatable" class="table table-sm"
                                                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                        <thead>
                                                            <tr class=" alert-primary ">
                                                                <th>No</th>
                                                                <th>Kd</th>
                                                                <th>Penilaian Harian</th>
                                                                <th>Skema</th>
                                                                <th>Status</th>
                                                                <th>Action</th>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($nilaikd3 as $key => $item)
                                                                @php
                                                                    $nilaisiswakd3belumdinilai = App\Models\NilaisiswaKd3::where('id_nilaikd3', $item->id)
                                                                        ->where('nilai', null)
                                                                        ->count();
                                                                    $nilaisiswakd3remedial = App\Models\NilaisiswaKd3::where('id_nilaikd3', $item->id)
                                                                        ->where('status', 'remedial')
                                                                        ->where('remedial', null)
                                                                        ->count();
                                                                    $tugassiswa = App\Models\NilaisiswaKd3::where('id_nilaikd3', $item->id)
                                                                        ->where('tugas_upload', '!=', null)
                                                                        ->count();

                                                                    $materi = App\Models\NilaisiswaKd3::where('id_nilaikd3', $item->id)->first();

                                                                @endphp
                                                                <tr>
                                                                    <td> {{ $key + 1 }}</td>
                                                                    <td>3. @if (isset($item['kd3']['urutan']))
                                                                            {{ $item['kd3']['urutan'] }}
                                                                            @endif @if (isset($item['kd3']['ket']))
                                                                                {{ $item['kd3']['ket'] }}
                                                                            @endif
                                                                    </td>
                                                                    <td>
                                                                        Ph - @if (isset($item->ph))
                                                                            {{ $item->ph }}
                                                                        @endif <br>
                                                                        @if (isset($item->created_at))
                                                                            {{ $item->created_at }}
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        @if ($item->skema == '1')
                                                                            Tes Tertulis
                                                                        @elseif ($item->skema == '2')
                                                                            Tes Lisan
                                                                        @elseif ($item->skema == '3')
                                                                            Penugasan
                                                                        @endif <br>

                                                                        <a href="{{ asset('public/pdf_files/' . $item->materi) }}"
                                                                            target="_blank">
                                                                            Materi: <i data-lucide="file"></i>
                                                                        </a>

                                                                        <a href="{{ asset('pdf_files/' . $item->materi) }}"
                                                                            target="_blank">
                                                                            <button>Buka File PDF</button>
                                                                        </a>


                                                                    </td>
                                                                    <td>
                                                                        @if (isset($nilaisiswakd3belumdinilai))
                                                                            Tidak dinilai: {{ $nilaisiswakd3belumdinilai }}
                                                                        @else
                                                                            Tidak dinilai: 0
                                                                        @endif <br>

                                                                        @if (isset($nilaisiswakd3remedial))
                                                                            Remedial: {{ $nilaisiswakd3remedial }}
                                                                        @else
                                                                            Remedial: 0
                                                                        @endif <br>

                                                                        @if (isset($tugassiswa))
                                                                            Upload Tugas : {{ $tugassiswa }}
                                                                        @else
                                                                            Upload Tugas : 0
                                                                        @endif


                                                                    </td>
                                                                    <td>
                                                                        <a id="delete"
                                                                            href="{{ route('Nilaikd3.delete', $item->id) }}"
                                                                            class="btn btn-danger mr-1 mb-2">
                                                                            <i data-lucide="trash" class="w-5 h-5"></i> </a>
                                                                        <a data-tw-toggle="modal"
                                                                            data-tw-target="#edit-pengetahuan-modal-preview-{{ $item->id }}"
                                                                            class="btn btn-primary mr-1 mb-2">
                                                                            <i data-lucide="edit" class="w-5 h-5"></i> </a>
                                                                        <br>
                                                                        <a data-tw-toggle="modal"
                                                                            data-tw-target="#nilaisiswa-kd3-{{ $item->id }}"
                                                                            class="btn btn-success mr-1 mb-2">
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                width="24" height="24"
                                                                                viewBox="0 0 24 24" fill="none"
                                                                                stroke="currentColor" stroke-width="2"
                                                                                stroke-linecap="round"
                                                                                stroke-linejoin="round"
                                                                                class="lucide lucide-clipboard-edit">
                                                                                <rect width="8" height="4" x="8"
                                                                                    y="2" rx="1" ry="1" />
                                                                                <path
                                                                                    d="M10.42 12.61a2.1 2.1 0 1 1 2.97 2.97L7.95 21 4 22l.99-3.95 5.43-5.44Z" />
                                                                                <path
                                                                                    d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-5.5" />
                                                                                <path d="M4 13.5V6a2 2 0 0 1 2-2h2" />
                                                                            </svg>
                                                                            &ensp;Nilai
                                                                        </a>


                                                                    </td>
                                                                </tr>
                                                            @endforeach


                                                        </tbody>
                                                    </table>

                                                </div>

                                            </div>

                                            {{--  // nilai keterampilan //  --}}
                                            <div id="example-tab-6" class="tab-pane leading-relaxed" role="tabpanel"
                                                aria-labelledby="example-6-tab">

                                                <div class="w-full sm:w-auto flex mt-4 sm:mt-0 float-right ml-4 mb-2">
                                                    <a data-tw-toggle="modal" data-tw-target="#keterampilan-modal-preview"
                                                        class="btn btn-primary shadow-md mr-2"> <i data-lucide="plus"></i>
                                                        Nilai Keterampilan</a>

                                                </div>
                                                <div class="mt-4">
                                                    <table id="datatable1" class="table table-sm"
                                                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                        <thead>
                                                            <tr class=" alert-primary ">
                                                                <th>No</th>
                                                                <th>Kd</th>
                                                                <th>Penilaian Harian</th>
                                                                <th>Skema</th>
                                                                <th>Status</th>
                                                                <th>Action</th>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($nilaikd4 as $key => $item)
                                                                @php
                                                                    $nilaisiswakd4belumdinilai = App\Models\NilaisiswaKd4::where('id_nilaikd4', $item->id)
                                                                        ->where('nilai', null)
                                                                        ->count();
                                                                    $nilaisiswakd4remedial = App\Models\NilaisiswaKd4::where('id_nilaikd4', $item->id)
                                                                        ->where('status', 'remedial')
                                                                        ->where('remedial', null)
                                                                        ->count();

                                                                @endphp
                                                                <tr>
                                                                    <td> {{ $key + 1 }} </td>
                                                                    <td>4. @if (isset($item['kd4']['urutan']))
                                                                            {{ $item['kd4']['urutan'] }}
                                                                            @endif @if (isset($item['kd4']['ket']))
                                                                                {{ $item['kd4']['ket'] }}
                                                                            @endif
                                                                    </td>
                                                                    <td>
                                                                        Ph - @if (isset($item->ph))
                                                                            {{ $item->ph }}
                                                                        @endif <br>
                                                                        @if (isset($item->created_at))
                                                                            {{ $item->created_at }}
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        @if ($item->skema == '1')
                                                                            Unjuk Kerja / Praktek
                                                                        @elseif ($item->skema == '2')
                                                                            Proyek
                                                                        @elseif ($item->skema == '3')
                                                                            Portofolio
                                                                        @elseif ($item->skema == '4')
                                                                            Produk
                                                                        @elseif ($item->skema == '5')
                                                                            Lainnya
                                                                        @endif

                                                                    </td>
                                                                    <td>
                                                                        @if (isset($nilaisiswakd4belumdinilai))
                                                                            Tidak dinilai: {{ $nilaisiswakd4belumdinilai }}
                                                                        @else
                                                                            Tidak dinilai: 0
                                                                        @endif <br>

                                                                        @if (isset($nilaisiswakd4remedial))
                                                                            Remedial: {{ $nilaisiswakd4remedial }}
                                                                        @else
                                                                            Remedial: 0
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        <a id="delete"
                                                                            href="{{ route('Nilaikd4.delete', $item->id) }}"
                                                                            class="btn btn-danger mr-1 mb-2">
                                                                            <i data-lucide="trash" class="w-5 h-5"></i> </a>
                                                                        <a data-tw-toggle="modal"
                                                                            data-tw-target="#edit-keterampilan-modal-preview-{{ $item->id }}"
                                                                            class="btn btn-primary mr-1 mb-2">
                                                                            <i data-lucide="edit" class="w-5 h-5"></i>
                                                                        </a>
                                                                        <br>
                                                                        <a data-tw-toggle="modal"
                                                                            data-tw-target="#nilaisiswa-kd4-{{ $item->id }}"
                                                                            class="btn btn-success mr-1 mb-2">
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                width="24" height="24"
                                                                                viewBox="0 0 24 24" fill="none"
                                                                                stroke="currentColor" stroke-width="2"
                                                                                stroke-linecap="round"
                                                                                stroke-linejoin="round"
                                                                                class="lucide lucide-clipboard-edit">
                                                                                <rect width="8" height="4" x="8"
                                                                                    y="2" rx="1" ry="1" />
                                                                                <path
                                                                                    d="M10.42 12.61a2.1 2.1 0 1 1 2.97 2.97L7.95 21 4 22l.99-3.95 5.43-5.44Z" />
                                                                                <path
                                                                                    d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-5.5" />
                                                                                <path d="M4 13.5V6a2 2 0 0 1 2-2h2" />
                                                                            </svg>
                                                                            &ensp;Nilai
                                                                        </a>
                                                                    </td>
                                                                </tr>
                                                            @endforeach


                                                        </tbody>
                                                    </table>

                                                </div>

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



    <!-- BEGIN: Add Pengetahuan  -->
    <div id="pengetahuan-modal-preview" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content"> <!-- BEGIN: Modal Header -->
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto">Nilai Pengetahuan</h2>

                </div> <!-- END: Modal Header --> <!-- BEGIN: Modal Body -->
                <form method="post" action="{{ route('nilaikd3.store') }}" onkeydown="return event.key != 'Enter';"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" class="form-control" name="search" value="{{ $rombel->id }}">
                    <input type="hidden" name="id_seksi" id="" value="{{ $seksi->id }}">
                    <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                        <div class="col-span-12 sm:col-span-12"> <label for="modal-form-1" class="form-label">Skema
                                Penilaian</label>
                            <select name="skema" id="skema" class="tom-select w-full " required>
                                <option value="">- Pilih Skema Penilaian -</option>
                                <option value="1">Unjuk Kerja / Praktek</option>
                                <option value="2">Proyek</option>
                                <option value="3">Portofolio</option>
                                <option value="4">Produk</option>
                                <option value="5">Lainnya</option>


                            </select>
                        </div>
                        <div class="col-span-12 sm:col-span-12"> <label for="modal-form-2" class="form-label">Kompetensi
                                Dasar
                                (KD)</label>
                            <select name="id_kd3" id="id_kd3" class="tom-select w-full " required>
                                <option value="">- Pilih Kompetensi Dasar (KD) -</option>
                                @foreach ($kd3 as $item)
                                    <option value="{{ $item->id }}">3.{{ $item->urutan }} {{ $item->ket }}
                                    </option>
                                @endforeach

                            </select>
                        </div>
                        <div class="col-span-12 sm:col-span-12"> <label for="modal-form-3" class="form-label">Penilaian
                                Harian
                                Ke -</label>
                            @if ($datanilaikd3)
                                <input id="ph" name="ph" type="number" value="{{ $datanilaikd3->ph + 1 }}"
                                    class="form-control" readonly>
                            @else
                                <input id="ph" name="ph" type="number" value="1" class="form-control"
                                    readonly>
                            @endif

                            <div class="mt-2">
                                <span class="text-danger">
                                    Pastikan data yang diinputkan benar.</span>
                            </div>
                        </div>

                        <div class="col-span-12 sm:col-span-12 mb-2">
                            <label for="modal-form-2" class="form-label">Tambahkan Tugas</label>
                            <input id="remember-me" type="checkbox" class="form-check-input border ml-2"
                                onchange="showHideElements()">
                        </div>

                        <div class="col-span-12 sm:col-span-12 mb-4" id="keteranganTugas" style="display: none;">
                            <label for="modal-form-2" class="form-label">Keterangan Tugas</label>
                            <input id="ph1" name="ket" type="text" class="form-control">
                        </div>

                        <div class="col-span-12 sm:col-span-6 mb-4" id="uploadSoal" style="display: none;">
                            <label for="modal-form-2" class="form-label">Upload Soal Tugas</label>
                            <input id="ph2" name="tugas" type="file" class="form-control">
                        </div>

                        <div class="col-span-12 sm:col-span-6 mb-4" id="uploadMateri" style="display: none;">
                            <label for="modal-form-2" class="form-label">Upload Materi</label>
                            <input id="ph3" name="materi" type="file" class="form-control">
                        </div>

                    </div> <!-- END: Modal Body --> <!-- BEGIN: Modal Footer -->
                    <div class="modal-footer"> <button type="button" data-tw-dismiss="modal"
                            class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
                        <button type="submit" class="btn btn-primary w-20">Save</button>
                    </div> <!-- END: Modal Footer -->
                </form>
            </div>
            <script>
                function showHideElements() {
                    var checkbox = document.getElementById("remember-me");
                    var keteranganTugas = document.getElementById("keteranganTugas");
                    var uploadSoal = document.getElementById("uploadSoal");
                    var uploadMateri = document.getElementById("uploadMateri");

                    if (checkbox.checked) {
                        keteranganTugas.style.display = "block";
                        uploadSoal.style.display = "block";
                        uploadMateri.style.display = "block";
                    } else {
                        keteranganTugas.style.display = "none";
                        uploadSoal.style.display = "none";
                        uploadMateri.style.display = "none";
                    }
                }
            </script>
        </div>
    </div><!-- END: Modal Content Pengetahuan-->




    <!-- BEGIN: Edit Pengetahuan  -->
    @foreach ($nilaikd3 as $key => $item)
        <div id="edit-pengetahuan-modal-preview-{{ $item->id }}" class="modal" tabindex="-1"
            aria-labelledby="edit-pengetahuan-modal-preview-{{ $item->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content"> <!-- BEGIN: Modal Header -->
                    <div class="modal-header">
                        <h2 class="font-medium text-base mr-auto">Nilai Pengetahuan</h2>

                    </div> <!-- END: Modal Header --> <!-- BEGIN: Modal Body -->
                    <form method="post" action="{{ route('nilaikd3.update') }}"
                        onkeydown="return event.key != 'Enter';">
                        @csrf

                        <input type="hidden" name="id" id="" value="{{ $item->id }}">
                        <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                            <div class="col-span-12 sm:col-span-12"> <label for="modal-form-1" class="form-label">Skema
                                    Penilaian</label>
                                <select name="skema" id="skema" class="tom-select w-full " required>
                                    <option value="{{ $item->skema }}">
                                        @if ($item->skema == '1')
                                            Tes Tertulis
                                        @elseif ($item->skema == '2')
                                            Tes Lisan
                                        @elseif ($item->skema == '3')
                                            Penugasan
                                        @endif
                                    </option>
                                    <option value="1">Tes Tertulis</option>
                                    <option value="2">Tes Lisan</option>
                                    <option value="3">Penugasan</option>

                                </select>
                            </div>

                            <div class="col-span-12 sm:col-span-12">
                                <label for="modal-form-2" class="form-label">Kompetensi Dasar (KD)</label>
                                <select name="id_kd3" id="id_kd3" class="tom-select w-full" required>
                                    @if (isset($item) && isset($item['kd3']['urutan']) && isset($item['kd3']['ket']))
                                        <option value="{{ $item->id_kd3 }}">
                                            3.{{ $item['kd3']['urutan'] }} {{ $item['kd3']['ket'] }}
                                        </option>
                                    @endif

                                    @foreach ($kd3 as $kd)
                                        @if (isset($kd['urutan']) && isset($kd['ket']))
                                            <option value="{{ $kd->id }}">
                                                3.{{ $kd['urutan'] }} {{ $kd['ket'] }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>



                        </div> <!-- END: Modal Body --> <!-- BEGIN: Modal Footer -->
                        <div class="modal-footer">

                            <button type="button" data-tw-dismiss="modal"
                                class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
                            <button type="submit" class="btn btn-primary w-20">Save</button>
                        </div> <!-- END: Modal Footer -->

                    </form>

                </div>
            </div>
        </div> <!-- END: Modal Content Pengetahuan-->
    @endforeach

    <!-- BEGIN: Add Keterampilan  -->
    <div id="keterampilan-modal-preview" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content"> <!-- BEGIN: Modal Header -->
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto">Nilai Keterampilan</h2>

                </div> <!-- END: Modal Header --> <!-- BEGIN: Modal Body -->
                <form method="post" action="{{ route('nilaikd4.store') }}" onkeydown="return event.key != 'Enter';">
                    @csrf
                    <input type="hidden" class="form-control" name="search" value="{{ $rombel->id }}">
                    <input type="hidden" name="id_seksi" id="" value="{{ $seksi->id }}">
                    <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                        <div class="col-span-12 sm:col-span-12"> <label for="modal-form-1" class="form-label">Skema
                                Penilaian</label>
                            <select name="skema" id="skema" class="tom-select w-full " required>
                                <option value="">- Pilih Skema Penilaian -</option>
                                <option value="1">Unjuk Kerja / Praktek</option>
                                <option value="2">Proyek</option>
                                <option value="3">Portofolio</option>
                                <option value="4">Produk</option>
                                <option value="5">Lainnya</option>


                            </select>
                        </div>
                        <div class="col-span-12 sm:col-span-12"> <label for="modal-form-2" class="form-label">Kompetensi
                                Dasar
                                (KD)</label>
                            <select name="id_kd4" id="id_kd4" class="tom-select w-full " required>
                                <option value="">- Pilih Kompetensi Dasar (KD) -</option>
                                @foreach ($kd4 as $item)
                                    <option value="{{ $item->id }}">4.{{ $item->urutan }} {{ $item->ket }}
                                    </option>
                                @endforeach

                            </select>
                        </div>
                        <div class="col-span-12 sm:col-span-12"> <label for="modal-form-3" class="form-label">Penilaian
                                Harian
                                Ke -</label>
                            @if ($datanilaikd4)
                                <input id="ph" name="ph" type="number" value="{{ $datanilaikd4->ph + 1 }}"
                                    class="form-control" readonly>
                            @else
                                <input id="ph" name="ph" type="number" value="1" class="form-control"
                                    readonly>
                            @endif


                        </div>

                    </div> <!-- END: Modal Body --> <!-- BEGIN: Modal Footer -->
                    <div class="modal-footer"> <button type="button" data-tw-dismiss="modal"
                            class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
                        <button type="submit" class="btn btn-primary w-20">Save</button>
                    </div> <!-- END: Modal Footer -->
                </form>
            </div>
        </div>
    </div> <!-- END: Modal Content Keterampilan-->

    <!-- BEGIN: Edit Keterampilan  -->
    @foreach ($nilaikd4 as $key => $item)
        <div id="edit-keterampilan-modal-preview-{{ $item->id }}" class="modal" tabindex="-1"
            aria-labelledby="edit-keterampilan-modal-preview-{{ $item->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content"> <!-- BEGIN: Modal Header -->
                    <div class="modal-header">
                        <h2 class="font-medium text-base mr-auto">Nilai Keterampilan</h2>

                    </div> <!-- END: Modal Header --> <!-- BEGIN: Modal Body -->
                    <form method="post" action="{{ route('nilaikd4.update') }}"
                        onkeydown="return event.key != 'Enter';">
                        @csrf

                        <input type="hidden" name="id" id="" value="{{ $item->id }}">
                        <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                            <div class="col-span-12 sm:col-span-12"> <label for="modal-form-1" class="form-label">Skema
                                    Penilaian</label>
                                <select name="skema" id="skema" class="tom-select w-full " required>
                                    <option value="{{ $item->skema }}">
                                        @if ($item->skema == '1')
                                            Unjuk Kerja / Praktek
                                        @elseif ($item->skema == '2')
                                            Proyek
                                        @elseif ($item->skema == '3')
                                            Portofolio
                                        @elseif ($item->skema == '4')
                                            Produk
                                        @elseif ($item->skema == '5')
                                            Lainnya
                                        @endif
                                    </option>
                                    <option value="1">Unjuk Kerja / Praktek</option>
                                    <option value="2">Proyek</option>
                                    <option value="3">Portofolio</option>
                                    <option value="4">Produk</option>
                                    <option value="5">Lainnya</option>

                                </select>
                            </div>

                            <div class="col-span-12 sm:col-span-12">
                                <label for="modal-form-2" class="form-label">Kompetensi Dasar (KD)</label>
                                <select name="id_kd4" id="id_kd4" class="tom-select w-full" required>
                                    @if (isset($item) && isset($item['kd4']['urutan']) && isset($item['kd4']['ket']))
                                        <option value="{{ $item->id_kd4 }}">
                                            4.{{ $item['kd4']['urutan'] }} {{ $item['kd4']['ket'] }}
                                        </option>
                                    @endif

                                    @foreach ($kd4 as $kd)
                                        @if (isset($kd['urutan']) && isset($kd['ket']))
                                            <option value="{{ $kd->id }}">
                                                4.{{ $kd['urutan'] }} {{ $kd['ket'] }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>


                        </div> <!-- END: Modal Body --> <!-- BEGIN: Modal Footer -->
                        <div class="modal-footer">

                            <button type="button" data-tw-dismiss="modal"
                                class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
                            <button type="submit" class="btn btn-primary w-20">Save</button>
                        </div> <!-- END: Modal Footer -->

                    </form>

                </div>
            </div>
        </div>
    @endforeach
    <!-- END: Modal Content Pengetahuan-->




    <!-- BEGIN: Add nilai siswa pengetahuan-->
    <style>
        .modal-xl {
            width: 90% !important;
        }

        .table {
            width: 100% !important;
        }
    </style>

    @foreach ($nilaikd3 as $key => $item)
        @php
            $nilaisiswakd3 = App\Models\NilaisiswaKd3::where('id_nilaikd3', $item->id)->get();
            $nilaisiswakd3id = $nilaisiswakd3->first();
            $rombelsiswa = App\Models\Rombelsiswa::find($nilaisiswakd3id->id_rombelsiswa);
            $rombel = App\Models\Rombel::find($rombelsiswa->id_rombel);
            $kelas = App\Models\Kelas::find($rombel->id_kelas);
            $kkm = App\Models\Kkm::where('id_kelas', $kelas->tingkat)->first();
        @endphp
        <div id="nilaisiswa-kd3-{{ $item->id }}" class="modal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content">
                    <div class="modal-header intro-y alert alert-primary show mb-2 ">

                        <h2 class="font-medium text-base mr-auto">Nilai Pengetahuan Siswa <br>
                            @if ($kkm)
                                <Span>- KKM Nilai ini adalah <span style="color: red">{{ $kkm->kkm }}.</span></Span>
                                <br>
                            @else
                                <Span>- KKM Nilai belum tersedia.</Span> <br>
                            @endif
                            <span>- Feedback yang Anda berikan akan dikirim kepada Orang tua. </span>
                        </h2>

                        <a data-tw-dismiss="modal" href="javascript:;"> <i data-lucide="x"
                                class="w-8 h-8 text-slate-400"></i> </a>
                    </div>

                    <div class="modal-body">
                        <div class="grid grid-cols-12 gap-4 gap-y-3 mb-4">
                            <div class="col-span-12">
                                <div class="card overflow-x-auto">
                                    <form method="post" action="{{ route('Nilaisiswakd3.update') }}"
                                        onkeydown="return event.key != 'Enter';">
                                        @csrf
                                        <div class="overflow-x-auto">
                                            <table id="datatable2" class="table table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th class="whitespace-nowrap">No</th>
                                                        <th class="whitespace-nowrap">Nisn</th>
                                                        <th class="whitespace-nowrap">Nama</th>
                                                        <th class="whitespace-nowrap">Jk</th>
                                                        <th class="whitespace-nowrap">Nilai</th>
                                                        <th class="whitespace-nowrap">Status</th>
                                                        <th class="whitespace-nowrap">Remedial</th>
                                                        <th class="whitespace-nowrap">Upload Tugas</th>
                                                        <th class="whitespace-nowrap">Feedback</th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if ($nilaisiswakd3)
                                                        @foreach ($nilaisiswakd3 as $key => $item)
                                                            @php
                                                                $rombelsiswa = App\Models\Rombelsiswa::where('id', $item->id_rombelsiswa)->first();
                                                                $rombel = App\Models\Rombel::where('id', $rombelsiswa->id_rombel)->first();
                                                                $kelas = App\Models\Kelas::where('id', $rombel->id_kelas)->first();
                                                                $kkm = App\Models\Kkm::where('id_kelas', $kelas->tingkat)->first();
                                                            @endphp
                                                            <tr>

                                                                <td> {{ $key + 1 }} </td>
                                                                <td> {{ $item['rombelsiswa']['siswas']['nisn'] }} </td>
                                                                <td> {{ $item['rombelsiswa']['siswas']['nama'] }} </td>
                                                                <td> {{ $item['rombelsiswa']['siswas']['jk'] }} </td>


                                                                <td>
                                                                    @if ($item->status == 'remedial')
                                                                        <input name="nilai[]" type="number"
                                                                            value="{{ $item->nilai }}"
                                                                            class="form-control" style="width: 100px;"
                                                                            readonly>
                                                                    @else
                                                                        <input name="nilai[]" type="number"
                                                                            value="{{ $item->nilai }}"
                                                                            class="form-control" style="width: 100px;">
                                                                    @endif
                                                                </td>
                                                                <td class="status-cell">
                                                                    @if ($item->status == 'remedial')
                                                                        <input type="text" name="status[]"
                                                                            class="form-control"
                                                                            value="{{ $item->status }}"
                                                                            style="width: 100px; color: red;" readonly>
                                                                    @elseif($item->status == 'lulus')
                                                                        <input type="text" name="status[]"
                                                                            class="form-control"
                                                                            value="{{ $item->status }}"
                                                                            style="width: 100px; color: green;" readonly>
                                                                    @else
                                                                        <input type="text" name="status[]"
                                                                            class="form-control"
                                                                            value="{{ $item->status }}"
                                                                            style="width: 100px;" readonly>
                                                                    @endif
                                                                </td>


                                                                <td>
                                                                    @if ($item->status == 'remedial')
                                                                        <input name="remedial[]" type="number"
                                                                            value="{{ $item->remedial }}"
                                                                            class="form-control" style="width: 100px;">
                                                                    @else
                                                                        <input name="remedial[]" type="hidden"
                                                                            value="{{ $item->remedial }}"
                                                                            class="form-control" style="width: 100px;">
                                                                    @endif

                                                                </td>
                                                                <td> {{ $item->tugas_upload }} </td>
                                                                <td>
                                                                    <textarea class="form-control" name="feedback[]" cols="10" rows="2">{{ $item->feedback }}</textarea>
                                                                </td>

                                                                <input type="hidden" name="id[]"
                                                                    value="{{ $item->id }}">
                                                                <!-- Add additional action buttons if necessary -->

                                                            </tr>
                                                        @endforeach
                                                    @endif
                                                </tbody>
                                            </table>

                                        </div>
                                        <p class="horizontal-align  mt-4">
                                            <span class="text-danger">Pastikan data yang diinputkan benar.</span>
                                        </p>
                                        <div class="modal-footer">
                                            <button type="button" data-tw-dismiss="modal"
                                                class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
                                            <button type="submit" class="btn btn-primary w-20">Save</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                let nilaiInputs = document.querySelectorAll("input[name='nilai[]']");
                let statusInputs = document.querySelectorAll("input[name='status[]']");
                let kkm = {!! json_encode($kkm->kkm) !!};

                nilaiInputs.forEach(function(input, index) {
                    input.addEventListener("input", function() {
                        let nilai = parseFloat(input.value);

                        if (nilai < kkm) {
                            statusInputs[index].value = "remedial";
                            statusInputs[index].style.color = "red";
                        } else {
                            statusInputs[index].value = "lulus";
                            statusInputs[index].style.color = "green";
                        }
                    });
                });

                statusInputs.forEach(function(input, index) {
                    input.addEventListener("input", function() {
                        let statusValue = input.value;
                        if (statusValue.toLowerCase() === "remedial") {
                            nilaiInputs[index].value = kkm - 1;
                        } else {
                            nilaiInputs[index].value = kkm;
                        }
                    });
                });
            });
        </script>
    @endforeach


    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var table = $('#datatable1').DataTable(); // Inisialisasi DataTable
            $('#searchInput').on('keyup', function() {
                table.search(this.value).draw();
            });

            // Hapus DataTable sebelum menginisialisasi kembali
            if ($.fn.DataTable.isDataTable('#datatable1')) {
                $('#datatable1').DataTable().destroy();
            }

            // Menginisialisasi DataTable kembali dengan paginasi
            $('#datatable1').DataTable({
                paging: true
            });
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var table = $('#datatable2').DataTable(); // Inisialisasi DataTable
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






    <!-- BEGIN: Add nilai siswa pengetahuan-->







    <!-- BEGIN: Add nilai siswa keterampilan-->
    <style>
        .modal-xl {
            width: 90% !important;
        }

        .table {
            width: 100% !important;
        }
    </style>
    @foreach ($nilaikd4 as $key => $item)
        @php
            $nilaisiswakd4 = App\Models\NilaisiswaKd4::where('id_nilaikd4', $item->id)->get();
            $nilaisiswakd4id = App\Models\NilaisiswaKd4::where('id_nilaikd4', $item->id)->first();
            $rombelsiswa = App\Models\Rombelsiswa::where('id', $nilaisiswakd4id->id_rombelsiswa)->first();
            $rombel = App\Models\Rombel::where('id', $rombelsiswa->id_rombel)->first();
            $kelas = App\Models\Kelas::where('id', $rombel->id_kelas)->first();
            $kkm1 = App\Models\Kkm::where('id_kelas', $kelas->tingkat)->first();
        @endphp
        <div id="nilaisiswa-kd4-{{ $item->id }}" class="modal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content">
                    <div class="modal-header intro-y alert alert-primary show mb-2 ">

                        <h2 class="font-medium text-base mr-auto">Nilai Keterampilan Siswa <br>
                            @if ($kkm1)
                                <Span>- KKM Nilai ini adalah <span style="color: red">{{ $kkm1->kkm }}.</span></Span>
                                <br>
                            @else
                                <Span>- KKM Nilai belum tersedia.</Span> <br>
                            @endif
                            <span>- Feedback yang Anda berikan akan dikirim kepada Orang tua.</span>
                        </h2>
                        <a data-tw-dismiss="modal" href="javascript:;"> <i data-lucide="x"
                                class="w-8 h-8 text-slate-400"></i> </a>
                    </div>

                    <div class="modal-body">
                        <div class="grid grid-cols-12 gap-4 gap-y-3 mb-4">
                            <div class="col-span-12">
                                <div class="card overflow-x-auto">
                                    <form method="post" action="{{ route('Nilaisiswakd4.update') }}"
                                        onkeydown="return event.key != 'Enter';">
                                        @csrf
                                        <div class="overflow-x-auto">
                                            <table id="datatable3" class="table table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th class="whitespace-nowrap">No</th>
                                                        <th class="whitespace-nowrap">Nisn</th>
                                                        <th class="whitespace-nowrap">Nama</th>
                                                        <th class="whitespace-nowrap">Jk</th>
                                                        <th class="whitespace-nowrap">Nilai</th>
                                                        <th class="whitespace-nowrap">Status</th>
                                                        <th class="whitespace-nowrap">Remedial</th>
                                                        <th class="whitespace-nowrap">Feedback</th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if ($nilaisiswakd4)
                                                        @foreach ($nilaisiswakd4 as $key => $item)
                                                            @php
                                                                $rombelsiswa = App\Models\Rombelsiswa::where('id', $item->id_rombelsiswa)->first();
                                                                $rombel = App\Models\Rombel::where('id', $rombelsiswa->id_rombel)->first();
                                                                $kelas = App\Models\Kelas::where('id', $rombel->id_kelas)->first();
                                                                $kkm = App\Models\Kkm::where('id_kelas', $kelas->tingkat)->first();
                                                            @endphp
                                                            <tr>
                                                                <td> {{ $key + 1 }} </td>
                                                                <td> {{ $item['rombelsiswa']['siswas']['nisn'] }} </td>
                                                                <td> {{ $item['rombelsiswa']['siswas']['nama'] }} </td>
                                                                <td> {{ $item['rombelsiswa']['siswas']['jk'] }} </td>
                                                                <td>
                                                                    @if ($item->status == 'remedial')
                                                                        <input name="nilai[]" type="number"
                                                                            value="{{ $item->nilai }}"
                                                                            class="form-control" style="width: 100px;"
                                                                            readonly>
                                                                    @else
                                                                        <input name="nilai[]" type="number"
                                                                            value="{{ $item->nilai }}"
                                                                            class="form-control" style="width: 100px;">
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    @if ($item->status == 'remedial')
                                                                        <input type="text" name="status[]"
                                                                            class="form-control"
                                                                            value="{{ $item->status }}"
                                                                            style="width: 100px; color: red;" readonly>
                                                                    @elseif($item->status == 'lulus')
                                                                        <input type="text" name="status[]"
                                                                            class="form-control"
                                                                            value="{{ $item->status }}"
                                                                            style="width: 100px; color: green;" readonly>
                                                                    @else
                                                                        <input type="text" name="status[]"
                                                                            class="form-control"
                                                                            value="{{ $item->status }}"
                                                                            style="width: 100px;" readonly>
                                                                    @endif
                                                                </td>

                                                                <td>
                                                                    @if ($item->status == 'remedial')
                                                                        <input name="remedial[]" type="number"
                                                                            value="{{ $item->remedial }}"
                                                                            class="form-control" style="width: 100px;">
                                                                    @else
                                                                        <input name="remedial[]" type="hidden"
                                                                            value="{{ $item->remedial }}"
                                                                            class="form-control" style="width: 100px;">
                                                                    @endif

                                                                </td>
                                                                <td>
                                                                    <textarea class="form-control" name="feedback[]" cols="10" rows="2">{{ $item->feedback }}</textarea>
                                                                </td>

                                                                <input type="hidden" name="id[]"
                                                                    value="{{ $item->id }}">
                                                                <!-- Add additional action buttons if necessary -->

                                                            </tr>
                                                        @endforeach
                                                    @endif
                                                </tbody>
                                            </table>

                                        </div>
                                        <p class="horizontal-align  mt-4">
                                            <span class="text-danger">Pastikan data yang diinputkan benar.</span>
                                        </p>
                                        <div class="modal-footer">
                                            <button type="button" data-tw-dismiss="modal"
                                                class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
                                            <button type="submit" class="btn btn-primary w-20">Save</button>
                                        </div>
                                    </form>
                                </div>
                            </div>



                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var table = $('#datatable3').DataTable(); // Inisialisasi DataTable
            $('#searchInput').on('keyup', function() {
                table.search(this.value).draw();
            });

            // Hapus DataTable sebelum menginisialisasi kembali
            if ($.fn.DataTable.isDataTable('#datatable3')) {
                $('#datatable3').DataTable().destroy();
            }

            // Menginisialisasi DataTable kembali dengan paginasi
            $('#datatable3').DataTable({
                paging: true
            });
        });
    </script>



    <!-- BEGIN: Add nilai siswa keterampilan-->
@endsection
