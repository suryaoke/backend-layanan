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


    <div class="mb-3 intro-y flex flex-col sm:flex-row items-center mt-8">
        <h1 class="text-lg font-medium mr-auto">
            Surat MAsuk All
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

                                        <th>Asal Surat</th>
                                        <th>Tanggal Surat</th>
                                        <th>Nomor Surat</th>
                                        <th>Perihal</th>
                                        <th>Pengirim</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                </thead>
                                <tbody>

                                    @foreach ($surat as $item)
                                        <tr>

                                            <td>
                                                @if ($item->asal_surat == '1')
                                                    Luar Sekolah
                                                @elseif ($item->asal_surat == '2')
                                                    Dalam Sekolah
                                                @elseif ($item->asal_surat == '0')
                                                    Belum di Pilih
                                                @endif
                                            </td>
                                            <td> {{ $item->tgl_surat }} </td>
                                            <td> {{ $item->no_surat }} </td>
                                            <td> {{ $item->perihal }} </td>
                                            <td>
                                                @if ($item->asal_surat == '1')
                                                    {{ $item->pengirim }}
                                                @elseif ($item->asal_surat == '2')
                                                    {{ $item['users']['name'] }}
                                                @endif
                                            </td>
                                            <td>
                                                @if ($item->status == '0')
                                                    <button
                                                        class="btn btn-outline-pending w-24 inline-block mr-1 mb-2">Belum
                                                        Dibaca</button>
                                                @elseif ($item->status == '1')
                                                    <button
                                                        class="btn btn-outline-primary w-24 inline-block mr-1 mb-2">Dibaca</button>
                                                @endif

                                            </td>


                                            <td>
                                                @if ($item->asal_surat == '1')
                                                    <a href="{{ route('surat.masuk.view', $item->id) }}"
                                                        class="btn btn-primary mr-1 mb-2">
                                                        <i data-lucide="eye" class="w-5 h-5"></i>
                                                    </a>
                                                @elseif ($item->asal_surat == '2')
                                                    <a href="{{ route('surat.keluar.isi', $item->file) }}"
                                                        class="btn btn-primary mr-1 mb-2">
                                                        <i data-lucide="eye" class="w-5 h-5"></i>
                                                    </a>
                                                @endif
                                            </td>

                                        </tr>
                                    @endforeach

                                    @foreach ($surat2 as $items)
                                        <tr>

                                            <td>
                                                @if ($items['suratmasuk']['asal_surat'] == '1')
                                                    Luar Sekolah
                                                @elseif ($items['suratmasuk']['asal_surat'] == '0')
                                                    Belum di Pilih
                                                @endif

                                            </td>
                                            <td> {{ $items['suratmasuk']['tgl_surat'] }} </td>
                                            <td> {{ $items['suratmasuk']['no_surat'] }} </td>
                                            <td> {{ $items['suratmasuk']['perihal'] }} </td>
                                            <td> {{ $items['suratmasuk']['pengirim'] }} </td>
                                            <td>
                                                @if ($items->status == '0')
                                                    <button
                                                        class="btn btn-outline-pending w-24 inline-block mr-1 mb-2">Belum
                                                        Dibaca</button>
                                                @elseif ($items->status == '1')
                                                    <button
                                                        class="btn btn-outline-primary w-24 inline-block mr-1 mb-2">Dibaca</button>
                                                @endif

                                            </td>


                                            <td>

                                                <a href="{{ route('surat.masuk.view', $items['suratmasuk']['id']) }}"
                                                    class="btn btn-primary mr-1 mb-2">
                                                    <i data-lucide="eye" class="w-5 h-5"></i>
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
        </div> <!-- end col -->
    </div> <!-- end row -->
@endsection
