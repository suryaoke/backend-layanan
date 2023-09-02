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
            Surat Keluar Verifikasi
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
                                        <th>Tujuan Surat</th>
                                        <th>Tanggal Surat</th>
                                        <th>Nomor Surat</th>
                                        <th>Perihal</th>
                                        <th>Penerima</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                </thead>
                                <tbody>

                                    @foreach ($verifikasi as $key => $item)
                                        <tr>
                                            <td> {{ $key + 1 }} </td>
                                            <td>
                                                @if ($item['suratkeluarinfo']['tujuan_surat'] == '1')
                                                    Luar Sekolah
                                                @elseif ($item['suratkeluarinfo']['tujuan_surat'] == '2')
                                                    Dalam Sekolah
                                                @endif

                                            </td>
                                            <td> {{ $item['suratkeluarinfo']['tgl_surat'] }} </td>
                                            <td> {{ $item['suratkeluarinfo']['no_surat'] }} </td>
                                            <td> {{ $item['suratkeluarinfo']['perihal'] }} </td>
                                            <td>
                                                @php
                                                    $tujuan = App\Models\TujuanSurat::where('id_informasi', $item->id_informasi)->get();
                                                @endphp
                                                @foreach ($tujuan as $tujuans)
                                                    @if ($item['suratkeluarinfo']['tujuan_surat'] == '1')
                                                        {{ $tujuans->id_user }}.
                                                    @elseif ($item['suratkeluarinfo']['tujuan_surat'] == '2')
                                                        {{ $tujuans['tujuan']['name'] }}.
                                                    @endif
                                                @endforeach
                                            </td>


                                            <td>
                                                @if ($item->status == '0')
                                                    <button
                                                        class="btn btn-outline-pending w-24 inline-block mr-1 mb-2">Diverifikasi</button>
                                                @elseif ($item->status == '1')
                                                    <button class="btn btn-outline-pending w-24 inline-block mr-1 mb-2">
                                                        Ditolak</button>
                                                @elseif ($item->status == '2')
                                                    <button class="btn btn-outline-primary w-24 inline-block mr-1 mb-2">
                                                        Surat OK </button>
                                                @elseif ($item->status == '3')
                                                    <button class="btn btn-outline-pending w-24 inline-block mr-1 mb-2">
                                                        Surat Ditolak </button>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('surat.keluar.isi', $item->id_informasi) }}"
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
