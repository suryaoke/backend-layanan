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
            Surat Masuk Report All
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
                                        <th>Tujuan</th>

                                </thead>
                                <tbody>

                                    @foreach ($suratmasuk as $key => $item)
                                        <tr>
                                            <td> {{ $key + 1 }} </td>
                                            <td>
                                                @if ($item->asal_surat == '0')
                                                    Belum di Pilih
                                                @elseif ($item->asal_surat == '1')
                                                    Luar Sekolah
                                                @elseif ($item->asal_surat == '2')
                                                    Dalam Sekolah
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

                                            <td> {{ $item['user']['name'] }} </td>



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
