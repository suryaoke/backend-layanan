@extends('admin.admin_master')
@section('admin')
    <div class="page-content mt-4">
        <div class="container-fluid">
            <div class="row">

                <div class="col-12">
                    <ul class="nav nav-boxed-tabs" role="tablist">
                        <li id="example-5-tab" class="nav-item flex-1" role="presentation"> <button
                                class="nav-link w-full py-2 active" data-tw-toggle="pill" data-tw-target="#example-tab-5"
                                type="button" role="tab" aria-controls="example-tab-3" aria-selected="true"> REKAP
                                ROMBONGAN BELAJAR </button> </li>
                        <li id="example-5-tab" class="nav-item flex-1" role="presentation"> <button
                                class="nav-link w-full py-2" data-tw-toggle="pill" data-tw-target="#example-tab-6"
                                type="button" role="tab" aria-controls="example-tab-4" aria-selected="false">
                                RUBAH ROMBONGAN BELAJAR </button> </li>
                    </ul>
                </div>
            </div>
        </div>


    </div>

    <div class="overflow-x-auto">
        <div class="tab-content mt-4">
            <div id="example-tab-5" class="tab-pane leading-relaxed active" role="tabpanel" aria-labelledby="example-5-tab">
                <div class="mb-4  intro-y flex flex-col sm:flex-row items-center mt-8">

                    <form role="form" action="{{ route('rombel.all') }}" method="get" class="sm:flex">

                        <div class="flex-1 sm:mr-2">
                            <div class="form-group">

                                <select name="searchwalas" class="form-select w-full">
                                    <option value="">Walas</option>
                                    @foreach ($guru as $item)
                                        <option value="{{ $item->id }}">
                                            {{ $item->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="flex-1 sm:mr-2">
                            <div class="form-group">

                                <select name="searchkelas" class="form-select w-full">
                                    <option value="">Kelas</option>
                                    @foreach ($kelas as $item)
                                        <option value="{{ $item->id }}">{{ $item->tingkat }} {{ $item->nama }}
                                            {{ $item->jurusans->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="flex-1 sm:mr-2">
                            <div class="form-group">

                                <select name="searchtahun" class="form-select w-full">
                                    <option value="">Tahun Ajar</option>
                                    @foreach ($datatahun as $item)
                                        <option value="{{ $item->id }}">{{ $item->semester }} -
                                            {{ $item->tahun }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="sm:ml-1">
                            <button type="submit" class="btn btn-default">Search</button>
                        </div>
                        <div class="sm:ml-2">

                            <a href="{{ route('rombel.all') }}" class="btn btn-danger">Clear</a>

                        </div>
                    </form>
                </div>
                <div class="grid grid-cols-12 gap-6 mt-5">

                    @foreach ($rombel as $item)
                        @php
                            $siswa = App\Models\Rombelsiswa::where('id_rombel', $item->id)->count();
                        @endphp
                        <div class="intro-y col-span-12 md:col-span-6 lg:col-span-4 xl:col-span-3">
                            <div class="box">
                                <div class="p-5">
                                    <div
                                        class="h-40 2xl:h-56 image-fit rounded-md overflow-hidden before:block before:absolute before:w-full before:h-full before:top-0 before:left-0 before:z-10 before:bg-gradient-to-t before:from-black before:to-black/10">
                                        <img alt="Midone - HTML Admin Template" class="rounded-md"
                                            src=" {{ !empty($item->walass->gurus->users->profile_image) ? url('uploads/admin_images/' . $item->walass->gurus->users->profile_image) : url('backend/dist/images/profile-user.png') }}">
                                        <div class="absolute bottom-0 text-white px-5 pb-6 z-10"> <a href=""
                                                class="block font-medium text-base"> {{$item->walass->gurus->nama}} </a> <span
                                                class="text-white/90 text-xs mt-3">Wali Kelas</span> </div>
                                    </div>
                                    <div class="text-slate-600 dark:text-slate-500 mt-5">
                                        <div class="flex items-center"> <i data-lucide="home" class="w-4 h-4 mr-2"></i>
                                            Kelas : {{ $item->kelass->tingkat }} {{ $item->kelass->nama }}
                                            {{ $item->kelass->jurusans->nama }} </div>
                                        <div class="flex items-center mt-2"> <i data-lucide="users"
                                                class="w-4 h-4 mr-2"></i>
                                            Siswa : {{ $siswa }} </div>
                                        <div class="flex items-center mt-2"> <i data-lucide="file" class="w-4 h-4 mr-2"></i>
                                            {{ $item->tahuns->semester }} / {{ $item->tahuns->tahun }} </div>
                                    </div>
                                </div>
                                {{--  <div
                                    class="flex justify-center lg:justify-end items-center p-5 border-t border-slate-200/60 dark:border-darkmode-400">
                                    <a class="flex items-center text-primary mr-auto" href="javascript:;"> <i
                                            data-lucide="eye" class="w-4 h-4 mr-1"></i> Preview </a>

                                </div>  --}}
                            </div>
                        </div>
                    @endforeach


                </div>
            </div>
            <div id="example-tab-6" class="tab-pane leading-relaxed" role="tabpanel" aria-labelledby="example-6-tab">
                <div class="mb-2 intro-y flex flex-col sm:flex-row items-center mt-4">

                    <form role="form" action="{{ route('rombel.all') }}" method="get" class="sm:flex">
                        <div class="flex-1 sm:mr-2">
                            <div class="form-group">

                                <select name="searchwalas" class="form-select w-full">
                                    <option value="">Walas</option>
                                    @foreach ($guru as $item)
                                        <option value="{{ $item->id }}">
                                            {{ $item->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="flex-1 sm:mr-2">
                            <div class="form-group">

                                <select name="searchkelas" class="form-select w-full">
                                    <option value="">Kelas</option>
                                    @foreach ($kelas as $item)
                                        <option value="{{ $item->id }}">{{ $item->tingkat }} {{ $item->nama }}
                                            {{ $item->jurusans->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="flex-1 sm:mr-2">
                            <div class="form-group">

                                <select name="searchtahun" class="form-select w-full">
                                    <option value="">Tahun Ajar</option>
                                    @foreach ($datatahun as $item)
                                        <option value="{{ $item->id }}">{{ $item->semester }} -
                                            {{ $item->tahun }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="sm:ml-1">
                            <button type="submit" class="btn btn-default">Search</button>
                        </div>
                        <div class="sm:ml-2">

                            <a href="{{ route('rombel.all') }}" class="btn btn-danger">Clear</a>

                        </div>
                    </form>
                </div>

                <div class="col-span-2 mb-4 mt-2">
                    @if ($rombelsiswa && $rombelsiswa->rombels)
                        <a href="{{ route('rombel.delete', $rombelsiswa->rombels->id) }}" id="delete"
                            class="btn btn-danger btn-block">
                            <span class="glyphicon glyphicon-download"></span> <i data-lucide="trash"
                                class="w-5 h-5"></i>&nbsp;Rombel
                        </a>
                        <a class="btn btn-pending btn-block" data-tw-toggle="modal"
                            data-tw-target="#excel-modal-preview">
                            <span class="glyphicon glyphicon-download"></span> <i data-lucide="download"
                                class="w-4 h-4"></i>&nbsp;Export
                        </a>
                        <a href="{{ route('rombel.edit', $rombelsiswa->rombels->id) }}"
                            class="btn btn-success btn-block">
                            <span class="glyphicon glyphicon-download"></span> <i data-lucide="edit"
                                class="w-5 h-5"></i>&nbsp;Edit Data
                        </a>
                    @endif
                    <a href="{{ route('rombel.add') }}" class="btn btn-primary btn-block">
                        <span class="glyphicon glyphicon-download"></span> <i data-lucide="plus-square"
                            class="w-5 h-5"></i>&nbsp;Tambah
                        Data
                    </a>

                    <div class="flex mt-2">

                        <div class="flex-1 mr-1">
                            <div class="form-group">
                                <input type="text" name="searchnama" class="form-control" placeholder="Nama"
                                    value="{{ request('searchnama') }}">

                            </div>
                        </div>
                        <div class="flex-1 mr-1">
                            <div class="form-group">
                                <input type="text" name="searchnisn" class="form-control" placeholder="Nisn"
                                    value="{{ request('searchnisn') }}">

                            </div>
                        </div>
                        <div class="flex-1 mr-1">
                            <div class="form-group">
                                <input type="text" name="searchjk" class="form-control" placeholder="Jk"
                                    value="{{ request('searchjk') }}">
                            </div>
                        </div>


                    </div>

                </div>

                @if (isset(
                        $rombelsiswa['rombels']['tahuns'],
                        $rombelsiswa['rombels']['kelass'],
                        $rombelsiswa['rombels']['kelass']['jurusans'],
                        $rombelsiswa['rombels']['walass']['gurus']))
                    <div class="page-content">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card overflow-x-auto">
                                        <div class="card-body">

                                            <div class="intro-y alert alert-primary show mb-2 " role="alert">
                                                <span>
                                                    Semester {{ $rombelsiswa['rombels']['tahuns']['semester'] }}
                                                    Tahun Ajar {{ $rombelsiswa['rombels']['tahuns']['tahun'] }} | Kelas :
                                                    {{ $rombelsiswa->rombels->kelass->tingkat }}
                                                    {{ $rombelsiswa->rombels->kelass->nama }}
                                                    {{ $rombelsiswa->rombels->kelass->jurusans->nama }} | Wali Kelas:
                                                    {{ $rombelsiswa->rombels->walass->gurus->nama }}
                                                </span>
                                            </div>
                                            <table id="datatable" class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th class="whitespace-nowrap">No</th>
                                                        <th class="whitespace-nowrap">Nama</th>
                                                        <th class="whitespace-nowrap">Nisn</th>
                                                        <th class="whitespace-nowrap">Jk</th>
                                                        <th class="whitespace-nowrap">Kelas</th>

                                                </thead>
                                                <tbody>
                                                    @foreach ($rombelsiswaa as $key => $item)
                                                        <tr>
                                                            <td class="whitespace-nowrap"> {{ $key + 1 }} </td>
                                                            <td class="whitespace-nowrap">
                                                                {{ $item->siswas->nama }}
                                                            </td>
                                                            <td class="whitespace-nowrap">
                                                                {{ $item->siswas->nisn }}
                                                            </td>
                                                            <td class="whitespace-nowrap">
                                                                {{ $item->siswas->jk }}
                                                            </td>
                                                            <td class="whitespace-nowrap">
                                                                {{ $item->rombels->kelass->tingkat }}
                                                                {{ $item->rombels->kelass->nama }}
                                                                {{ $item->rombels->kelass->jurusans->nama }}

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
                    </div>
                @endif
            </div>
        </div>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const searchNamaInput = document.querySelector('input[name="searchnama"]');
                const searchNisnInput = document.querySelector('input[name="searchnisn"]');
                const searchJkInput = document.querySelector('input[name="searchjk"]');
                const tableRows = document.querySelectorAll("#datatable tbody tr");

                function filterTable() {
                    const searchNama = searchNamaInput.value.trim().toLowerCase();
                    const searchNisn = searchNisnInput.value.trim().toLowerCase();
                    const searchJk = searchJkInput.value.trim().toLowerCase();

                    tableRows.forEach(row => {
                        const nama = row.cells[1].textContent.trim().toLowerCase();
                        const nisn = row.cells[2].textContent.trim().toLowerCase();
                        const jk = row.cells[3].textContent.trim().toLowerCase();

                        const namaMatch = nama.includes(searchNama);
                        const nisnMatch = nisn.includes(searchNisn);
                        const jkMatch = jk.includes(searchJk);

                        if (namaMatch && nisnMatch && jkMatch) {
                            row.style.display = "";
                        } else {
                            row.style.display = "none";
                        }
                    });
                }

                searchNamaInput.addEventListener("input", filterTable);
                searchNisnInput.addEventListener("input", filterTable);
                searchJkInput.addEventListener("input", filterTable);
            });
        </script>








        <!-- BEGIN: Modal Excel-->

        <div id="excel-modal-preview" class="modal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- BEGIN: Modal Header -->
                    <div class="modal-header">
                        <h2 class="font-medium text-base mr-auto">Export Rombongan Belajar</h2>
                        <div class="dropdown sm:hidden"> <a class="dropdown-toggle w-5 h-5 block" href="javascript:;"
                                aria-expanded="false" data-tw-toggle="dropdown"> <i data-lucide="more-horizontal"
                                    class="w-5 h-5 text-slate-500"></i> </a>
                            <div class="dropdown-menu w-40">
                            </div>
                        </div>
                    </div> <!-- END: Modal Header -->
                    <!-- BEGIN: Modal Body -->

                    <form method="post" action="{{ route('rombel.excel') }}">
                        @csrf
                        <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                            <div class="col-span-12 sm:col-span-6"> <label for="edit-jam">Pilih Kelas </label>
                                <select name="kelas" id="kelas" class="form-select w-full" required>

                                    @foreach ($kelas as $item)
                                        <option value="{{ $item->id }}"> {{ $item->tingkat }}{{ $item->nama }}
                                            {{ $item['jurusans']['nama'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-span-12 sm:col-span-6"> <label for="edit-jam">Pilih Tahun Ajar </label>
                                <select name="tahun" id="tahun" class="form-select w-full" required>

                                    @foreach ($datatahun as $item)
                                        <option value="{{ $item->id }}">{{ $item->semester }} -
                                            {{ $item->tahun }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>


                        <!-- BEGIN: Modal Footer -->
                        <div class="modal-footer">
                            <a href="{{ route('rombel.all') }}" class="btn btn-outline-secondary w-20 mr-1">Cancel</a>
                            <button type="submit" class="btn btn-primary w-20">Export</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- BEGIN: Modal Excel -->
    @endsection
