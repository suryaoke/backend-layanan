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
            Mapel All
        </h1>
        <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
            <a href="{{ route('mapel.add') }}" class="btn btn-primary shadow-md mr-2">Add New Mapel</a>

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
                                        <th>Mata Pelajaran</th>
                                        <th>Jenis</th>
                                        <th>Jam Pelajaran</th>
                                        <th>Ruangan</th>
                                        <th>Action</th>
                                </thead>
                                <tbody>

                                    @foreach ($mapel as $key => $item)
                                        <tr>
                                            <td> {{ $key + 1 }} </td>
                                           
                                            <td> {{ $item->nama }} </td>
                                            <td>
                                                @if ($item->jenis == "1")
                                                    UMUM
                                                    @elseif ($item->jenis == "2")
                                                    PROD
                                                @endif
                                               

                                            </td>
                                            <td> {{ $item->jp }} JP</td>    
                                            <td> {{ $item->kode_ruangan }} </td>
                                           
                                            <td>
                                                <a id="delete" href="{{ route('mapel.delete', $item->id) }}"
                                                    class="btn btn-danger mr-1 mb-2">
                                                    <i data-lucide="trash" class="w-5 h-5"></i> </a>
                                                <a href="{{ route('mapel.edit', $item->id) }}"
                                                    class="btn btn-success mr-1 mb-2">
                                                    <i data-lucide="edit" class="w-5 h-5"></i>
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

