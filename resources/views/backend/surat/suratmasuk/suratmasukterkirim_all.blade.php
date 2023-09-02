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
            Surat Masuk Terkirim All
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
                                        <th>Asal Surat</th>
                                        <th>Tanggal Surat</th>
                                        <th>Nomor Surat</th>
                                        <th>Perihal</th>
                                        <th>Pengirim</th>
                                        <th>Penerima</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                </thead>
                                <tbody>

                                    @foreach ($suratmasukterkirim as $key => $item)
                                        <tr>
                                            <td> {{ $key + 1 }} </td>
                                            <td>
                                                @if ($item['suratmasuk']['asal_surat'] == '0')
                                                    Belum di Pilih
                                                @elseif ($item['suratmasuk']['asal_surat'] == '1')
                                                    Luar Sekolah
                                                @elseif ($item['suratmasuk']['asal_surat'] == '2')
                                                    Dalam Sekolah
                                                @endif
                                            </td>
                                            <td> {{ $item['suratmasuk']['tgl_surat'] }} </td>
                                            <td> {{ $item['suratmasuk']['no_surat'] }} </td>
                                            <td> {{ $item['suratmasuk']['perihal'] }} </td>
                                            <td>
                                                @if ($item['suratmasuk']['asal_surat'] == '1')
                                                    {{ $item['suratmasuk']['pengirim'] }}
                                                @elseif ($item['suratmasuk']['asal_surat'] == '2')
                                                    {{ $item['suratmasuk']['users']['name'] }}
                                                @endif

                                            </td>
                                            <td>
                                                @if ($item['suratmasuk']['tujuan'] == '0')
                                                    <button
                                                        class="btn btn-warning w-24 mr-1 mb-2">{{ $item['suratmasuk']['status'] }}</button>
                                                @else
                                                    {{ $item['suratmasuk']['user']['name'] }}
                                                @endif
                                            </td>

                                            <td>
                                                @if ($item['suratmasuk']['status'] == '0')
                                                    <button class="btn btn-outline-pending w-24 inline-block mr-1 mb-2">
                                                        Belum di Baca </button>
                                                @elseif ($item['suratmasuk']['status'] == '1')
                                                    <button class="btn btn-outline-primary w-24 inline-block mr-1 mb-2"> di
                                                        Baca </button>
                                                @else
                                                    <button class="btn btn-outline-dark w-24 inline-block mr-1 mb-2">
                                                        Belum di Pilih</button>
                                                @endif

                                            </td>
                                            <td>
                                                @if ($item['suratmasuk']['status'] == '0' && $item['suratmasuk']['asal_surat'] == '1')
                                                    <a id="delete"
                                                        href="{{ route('surat.masuk.terkirim.delete', $item['suratmasuk']['id']) }}"
                                                        class="btn btn-danger mr-1 mb-2">
                                                        <i data-lucide="trash" class="w-5 h-5"></i> </a>
                                                @elseif (
                                                    $item['suratmasuk']['status'] != '0' &&
                                                        $item['suratmasuk']['status'] != '1' &&
                                                        $item['suratmasuk']['asal_surat'] == '1')
                                                    <a id="delete"
                                                        href="{{ route('surat.masuk.terkirim.delete', $item['suratmasuk']['id']) }}"
                                                        class="btn btn-danger mr-1 mb-2">
                                                        <i data-lucide="trash" class="w-5 h-5"></i> </a>
                                                @endif

                                                @if ($item['suratmasuk']['asal_surat'] == '1')
                                                    <a href="{{ route('surat.masuk.terkirim.view', $item->id) }}"
                                                        class="btn btn-primary mr-1 mb-2">
                                                        <i data-lucide="eye" class="w-5 h-5"></i>
                                                    </a>
                                                @elseif ($item['suratmasuk']['asal_surat'] == '2')
                                                    <a href="{{ route('surat.keluar.isi', $item['suratmasuk']['file']) }}"
                                                        class="btn btn-primary mr-1 mb-2">
                                                        <i data-lucide="eye" class="w-5 h-5"></i>
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






@endsection
