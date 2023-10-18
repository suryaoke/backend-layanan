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
            Pengampu Mata Pelajaran All
        </h1>
        <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
            <a href="{{ route('pengampu.add') }}" class="btn btn-primary shadow-md mr-2">Tambah Data</a>

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
                                        <th style="white-space: nowrap;">Kode Pengampu</th>
                                        <th style="white-space: nowrap;">Nama Guru</th>
                                        <th style="white-space: nowrap;">Kode Guru</th>
                                        <th style="white-space: nowrap;">Mata Pelajaran</th>
                                        <th style="white-space: nowrap;">Kode Mapel</th>
                                        <th>Kelas</th>
                                        <th>Kurikulum</th>
                                        <th>Action</th>
                                </thead>
                                <tbody>

                                    @foreach ($pengampu as $key => $item)
                                        <tr>
                                            <td> {{ $key + 1 }} </td>
                                            <td style="white-space: nowrap;" class="text-primary">
                                                {{ $item->kode_pengampu }} </td>
                                            <td style="white-space: nowrap;"> {{ $item['gurus']['nama'] }} </td>
                                            <td style="white-space: nowrap;"> {{ $item['gurus']['kode_gr'] }} </td>
                                            <td style="white-space: nowrap;"> {{ $item['mapels']['nama'] }} </td>
                                            <td style="white-space: nowrap;"> {{ $item['mapels']['kode_mapel'] }} </td>
                                            <td style="white-space: nowrap;"> {{ $item['kelass']['tingkat'] }}
                                                {{ $item['kelass']['nama'] }}
                                                {{ $item['kelass']['jurusans']['nama'] }} </td>
                                            <td> {{ $item->kurikulum }} </td>


                                            <td>
                                                <a id="delete" href="{{ route('pengampu.delete', $item->id) }}"
                                                    class="btn btn-danger mr-1 mb-2">
                                                    <i data-lucide="trash" class="w-4 h-4"></i> </a>
                                                <a href="{{ route('pengampu.edit', $item->id) }}"
                                                    class="btn btn-success mr-1 mb-2">
                                                    <i data-lucide="edit" class="w-4 h-4"></i>
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
