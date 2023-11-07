@extends('admin.admin_master')
@section('admin')
    <div class="intro-y flex items-center mt-8 mb-4">
        <h1 class="text-lg font-medium mr-auto">
            Tugas Harian
        </h1>
    </div>

    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card overflow-x-auto">
                        <div class="card-body">
                            <div class="intro-y box mt-5">
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
                                                <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">

                                                    <div class="col-span-12 sm:col-span-6">

                                                        <label for="modal-form-6" class="form-label  mb-4 mr-4">Mata
                                                            Pelajaran</label>


                                                        <form role="form" action="{{ route('tugas.siswa') }}"
                                                            method="get" class="sm:flex" enctype="multipart/form-data"
                                                            id="myForm">

                                                            <select name="searchmapel" class="tom-select w-full mr-4"
                                                                required>
                                                                <option value="">Pilih Mata Pelajaran</option>
                                                                @foreach ($nilaiSiswaKd3 as $item)
                                                                    <option
                                                                        value="{{ $item['nilaikd3']['seksis']['jadwalmapels']['pengampus']['mapels']['id'] }}">

                                                                        {{ $item['nilaikd3']['seksis']['jadwalmapels']['pengampus']['mapels']['nama'] }}

                                                                    </option>
                                                                @endforeach


                                                            </select>


                                                            <div class="sm:ml-1">
                                                                <button type="submit"
                                                                    class="btn btn-default">Search</button>
                                                            </div>
                                                            <div class="sm:ml-2">

                                                                <a href="{{ route('tugas.siswa') }}"
                                                                    class="btn btn-danger">Clear</a>

                                                            </div>
                                                        </form>
                                                    </div>

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
                                                                                <tr class="alert-primary">
                                                                                    <th class="whitespace-nowrap">No</th>

                                                                                    <th class="whitespace-nowrap">Nama
                                                                                        Siswa
                                                                                    </th>
                                                                                    <th class="whitespace-nowrap">NISN</th>
                                                                                    <th class="whitespace-nowrap">Kelas
                                                                                    </th>
                                                                                    <th class="whitespace-nowrap">Mapel
                                                                                    </th>
                                                                                    <th class="whitespace-nowrap">Ph
                                                                                    </th>
                                                                                    <th class="whitespace-nowrap">Batas
                                                                                        Waktu
                                                                                    </th>
                                                                                    <th class="whitespace-nowrap">Status
                                                                                    </th>
                                                                                    <th class="whitespace-nowrap">Action
                                                                                    </th>

                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>


                                                                                @foreach ($nilaiSiswaKd3 as $key => $item)
                                                                                    @php
                                                                                        $now = Carbon\Carbon::now();
                                                                                        $lastDate = Carbon\Carbon::createFromFormat('j/n/Y:H:i', $item->last);
                                                                                    @endphp
                                                                                    <tr>
                                                                                        <td class="whitespace-nowrap">
                                                                                            {{ $key + 1 }} </td>

                                                                                        <td class="whitespace-nowrap">
                                                                                            {{ $item['rombelsiswa']['siswas']['nama'] }}
                                                                                        </td>
                                                                                        <td class="whitespace-nowrap">
                                                                                            {{ $item['rombelsiswa']['siswas']['nisn'] }}
                                                                                        </td>
                                                                                        <td class="whitespace-nowrap">
                                                                                            {{ $item['nilaikd3']['seksis']['jadwalmapels']['pengampus']['kelass']['tingkat'] }}
                                                                                            {{ $item['nilaikd3']['seksis']['jadwalmapels']['pengampus']['kelass']['nama'] }}
                                                                                            {{ $item['nilaikd3']['seksis']['jadwalmapels']['pengampus']['kelass']['jurusans']['nama'] }}
                                                                                        </td>
                                                                                        <td class="whitespace-nowrap">
                                                                                            {{ $item['nilaikd3']['seksis']['jadwalmapels']['pengampus']['mapels']['nama'] }}
                                                                                        </td>
                                                                                        <td class="whitespace-nowrap">
                                                                                            {{ $item['nilaikd3']['ph'] }}
                                                                                        </td>
                                                                                        <td class="text-danger">
                                                                                            {{ $item->last }} </td>
                                                                                        <td class="text-success">
                                                                                            @if ($item->tugas_upload != null)
                                                                                                Dikirim
                                                                                            @else
                                                                                                -
                                                                                            @endif

                                                                                        </td>

                                                                                        <td class="whitespace-nowrap">
                                                                                            @if ($lastDate < $now)
                                                                                                -
                                                                                            @elseif($item->tugas_upload == null)
                                                                                                <a data-tw-toggle="modal"
                                                                                                    data-tw-target="#edit-pengetahuan-modal-preview-{{ $item->id }}"
                                                                                                    class="btn btn-success mr-1 mb-2">
                                                                                                    Upload
                                                                                                    <i data-lucide="edit"
                                                                                                        class="w-4 h-4 ml-1"></i>
                                                                                                </a>
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

                                                    </div> <!-- end col -->


                                                </div> <!-- end row -->

                                            </div>

                                            {{--  // Nilai keterampilan //  --}}
                                            <div id="example-tab-6" class="tab-pane leading-relaxed" role="tabpanel"
                                                aria-labelledby="example-6-tab">

                                                <div class="modal-body grid grid-cols-12 gap-4 gap-y-4">

                                                    <div class="col-span-12 ml-4 sm:col-span-6">

                                                        <label for="modal-form-6" class="form-label mb-4 mr-4">Mata
                                                            Pelajaran</label>


                                                        <form role="form" action="{{ route('tugas.siswa') }}"
                                                            method="get" class="sm:flex">

                                                            <select name="searchmapel1" class="tom-select w-full mr-4"
                                                                required>
                                                                <option value="">Pilih Mata Pelajaran</option>
                                                                @foreach ($nilaiSiswaKd4 as $item)
                                                                    <option
                                                                        value="{{ $item['nilaikd4']['seksis']['jadwalmapels']['pengampus']['mapels']['id'] }}">

                                                                        {{ $item['nilaikd4']['seksis']['jadwalmapels']['pengampus']['mapels']['nama'] }}

                                                                    </option>
                                                                @endforeach
                                                            </select>




                                                            <div class="sm:ml-1">
                                                                <button type="submit"
                                                                    class="btn btn-default">Search</button>
                                                            </div>
                                                            <div class="sm:ml-2">

                                                                <a href="{{ route('tugas.siswa') }}"
                                                                    class="btn btn-danger">Clear</a>

                                                            </div>
                                                        </form>
                                                    </div>

                                                </div>
                                                <div class="page-content">
                                                    <div class="container-fluid">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="card overflow-x-auto">
                                                                    <div class="card-body">
                                                                        <table id="datatable1" class="table table-sm"
                                                                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                                            <thead>
                                                                                <tr class="alert-primary">
                                                                                    <th class="whitespace-nowrap">No</th>

                                                                                    <th class="whitespace-nowrap">Nama
                                                                                        Siswa
                                                                                    </th>
                                                                                    <th class="whitespace-nowrap">NISN</th>
                                                                                    <th class="whitespace-nowrap">Kelas
                                                                                    </th>
                                                                                    <th class="whitespace-nowrap">Mapel
                                                                                    </th>
                                                                                    <th class="whitespace-nowrap">Ph
                                                                                    </th>
                                                                                    <th class="whitespace-nowrap">Batas
                                                                                        Waktu
                                                                                    </th>
                                                                                    <th class="whitespace-nowrap">Status
                                                                                    </th>

                                                                                    <th class="whitespace-nowrap">Action
                                                                                    </th>

                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>

                                                                                @foreach ($nilaiSiswaKd4 as $key => $item)
                                                                                    @php
                                                                                        $now1 = Carbon\Carbon::now();
                                                                                        $lastDate1 = Carbon\Carbon::createFromFormat('j/n/Y:H:i', $item->last);
                                                                                    @endphp
                                                                                    <tr>
                                                                                        <td class="whitespace-nowrap">
                                                                                            {{ $key + 1 }} </td>

                                                                                        <td class="whitespace-nowrap">
                                                                                            {{ $item['rombelsiswa']['siswas']['nama'] }}
                                                                                        </td>
                                                                                        <td class="whitespace-nowrap">
                                                                                            {{ $item['rombelsiswa']['siswas']['nisn'] }}
                                                                                        </td>
                                                                                        <td class="whitespace-nowrap">
                                                                                            {{ $item['nilaikd4']['seksis']['jadwalmapels']['pengampus']['kelass']['tingkat'] }}
                                                                                            {{ $item['nilaikd4']['seksis']['jadwalmapels']['pengampus']['kelass']['nama'] }}
                                                                                            {{ $item['nilaikd4']['seksis']['jadwalmapels']['pengampus']['kelass']['jurusans']['nama'] }}
                                                                                        </td>
                                                                                        <td class="whitespace-nowrap">
                                                                                            {{ $item['nilaikd4']['seksis']['jadwalmapels']['pengampus']['mapels']['nama'] }}
                                                                                        </td>
                                                                                        <td class="whitespace-nowrap">
                                                                                            {{ $item['nilaikd4']['ph'] }}
                                                                                        </td>
                                                                                        <td class="text-danger">
                                                                                            {{ $item->last }} </td>
                                                                                        <td class="text-success">
                                                                                            @if ($item->tugas_upload != null)
                                                                                                Dikirim
                                                                                            @else
                                                                                                -
                                                                                            @endif
                                                                                        </td>

                                                                                        <td class="whitespace-nowrap">
                                                                                            @if ($lastDate1 < $now1)
                                                                                                -
                                                                                            @elseif($item->tugas_upload == null)
                                                                                                <a data-tw-toggle="modal"
                                                                                                    data-tw-target="#edit-pengetahuan-modal-preview-{{ $item->id }}"
                                                                                                    class="btn btn-success mr-1 mb-2">
                                                                                                    Upload
                                                                                                    <i data-lucide="edit"
                                                                                                        class="w-4 h-4 ml-1"></i>
                                                                                                </a>
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

                                                    </div> <!-- end col -->


                                                </div> <!-- end row -->





                                            </div>
                                        </div> --
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


    <!-- BEGIN: Edit Pengetahuan  -->

    @foreach ($nilaiSiswaKd3 as $key => $item)
        <div id="edit-pengetahuan-modal-preview-{{ $item->id }}" class="modal" tabindex="-1"
            aria-labelledby="edit-pengetahuan-modal-preview-{{ $item->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content"> <!-- BEGIN: Modal Header -->
                    <div class="modal-header">
                        <h2 class="font-medium text-base mr-auto">Nilai Pengetahuan</h2>

                    </div> <!-- END: Modal Header --> <!-- BEGIN: Modal Body -->
                    <form method="post" action="{{ route('tugaskd3.update') }}"
                        onkeydown="return event.key != 'Enter';" enctype="multipart/form-data">
                        @csrf

                        <input type="hidden" name="id" id="" value="{{ $item->id }}">

                        <div class="modal-body">
                            <label for="modal-form-2" class="form-label">Keterangan Tugas :</label> <br>
                            <Span> {{ $item->ket }} </Span>
                        </div>
                        <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                            <div class="mr-4"> <a href="{{ asset('pdf_files/' . $item->tugas) }}">
                                    <span>Tugas <i data-lucide="book"></i></span>
                                </a></div>
                            <div class="ml-8"> <a href="{{ asset('pdf_files/' . $item->materi) }}">
                                    <span>materi <i data-lucide="book"></i></span>
                                </a></div>
                        </div>
                        <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">

                            <div class="col-span-12 sm:col-span-12">
                                <label for="modal-form-2" class="form-label">Upload Tugas</label>
                                <input name="tugas_upload" type="file" accept=".pdf" class="form-control" required>
                                <span>file pdf.</span>
                            </div>


                        </div>
                        <div class="mt-2 ml-4 mb-4">
                            <span class="text-danger">
                                Upload Tugas Hanya Bisa Sekali.</span>
                        </div>
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

    <!-- BEGIN: Edit Keterampilan  -->

    @foreach ($nilaiSiswaKd4 as $key => $item)
        <div id="edit-keterampilan-modal-preview-{{ $item->id }}" class="modal" tabindex="-1"
            aria-labelledby="edit-keterampilan-modal-preview-{{ $item->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content"> <!-- BEGIN: Modal Header -->
                    <div class="modal-header">
                        <h2 class="font-medium text-base mr-auto">Nilai Keterampilan</h2>

                    </div> <!-- END: Modal Header --> <!-- BEGIN: Modal Body -->
                    <form method="post" action="{{ route('tugaskd4.update') }}"
                        onkeydown="return event.key != 'Enter';" enctype="multipart/form-data">
                        @csrf

                        <input type="hidden" name="id" id="" value="{{ $item->id }}">

                        <div class="modal-body">
                            <label for="modal-form-2" class="form-label">Keterangan Tugas :</label> <br>
                            <Span> {{ $item->ket }} </Span>
                        </div>
                        <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                            <div class="mr-4"> <a href="{{ asset('pdf_files/' . $item->tugas) }}">
                                    <span>Tugas <i data-lucide="book"></i></span>
                                </a></div>
                            <div class="ml-8"> <a href="{{ asset('pdf_files/' . $item->materi) }}">
                                    <span>materi <i data-lucide="book"></i></span>
                                </a></div>
                        </div>
                        <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">

                            <div class="col-span-12 sm:col-span-12">
                                <label for="modal-form-2" class="form-label">Upload Tugas</label>
                                <input name="tugas_upload" type="file" accept=".pdf" class="form-control" required>
                               
                                <span>file pdf</span>
                            </div>


                        </div>
                        <div class="mt-2 ml-4 mb-4">
                            <span class="text-danger">
                                Upload Tugas Hanya Bisa Sekali.</span>
                        </div>
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
@endsection
