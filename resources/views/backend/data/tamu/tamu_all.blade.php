@extends('admin.admin_master')
@section('admin')
    <div class="mb-3 intro-y flex flex-col sm:flex-row items-center mt-8">
        <h1 class="text-lg font-medium mr-auto">
            Tamu All
        </h1>
        <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
            <a href="{{ route('tamu.add') }}" class="btn btn-primary shadow-md mr-2">Add New Tamu</a>

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
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Jabatan</th>
                                        <th>Individu Yang Dituju</th>
                                        <th>Maksud Dan Tujuan</th>
                                        <th>NO HP/WA</th>
                                        <th>Waktu</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                </thead>
                                <tbody>

                                    @foreach ($tamu as $key => $item)
                                        <tr>
                                            <td> {{ $key + 1 }} </td>
                                            <td> {{ $item->nama }} </td>
                                            <td> {{ $item->jabatan }} </td>
                                            <td> {{ $item->individu }} </td>
                                            <td> {{ $item->tujuan }} </td>
                                            <td> {{ $item->no_hp }} </td>
                                            <td> {{ $item->created_at }} </td>

                                            <td>
                                                @if ($item->status == '0')
                                                    <button
                                                        class="btn btn-outline-pending w-24 inline-block mr-1 mb-2">Masuk</button>
                                                @elseif ($item->status == '1')
                                                    <button
                                                        class="btn btn-outline-primary w-24 inline-block mr-1 mb-2">Selesai</button>
                                                @endif

                                            </td>
                                            <td>
                                                @if ($item->status == '0')
                                                    <a id="ApproveBtn" href="{{ route('tamu.selesai', $item->id) }}"
                                                        class="btn btn-success mr-1 mb-2">
                                                        <i data-lucide="check-circle" class="w-5 h-5"></i>
                                                    </a>
                                                    <a id="delete" href="{{ route('tamu.delete', $item->id) }}"
                                                        class="btn btn-danger mr-1 mb-2">
                                                        <i data-lucide="trash" class="w-5 h-5"></i> </a>
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
