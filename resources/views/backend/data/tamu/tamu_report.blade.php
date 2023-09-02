@extends('admin.admin_master')
@section('admin')
    <div class="mb-3 intro-y flex flex-col sm:flex-row items-center mt-8">
        <h1 class="text-lg font-medium mr-auto">
            Tamu Report All
        </h1>
        <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
            <a href="{{ route('tamu.report.pdf') }}" target="_blank" class="btn btn-primary shadow-md mr-2"> <i
                    data-lucide="printer" class="mr-1"></i> Report Tamu</a>

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
