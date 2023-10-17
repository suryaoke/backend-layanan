@extends('admin.admin_master')
@section('admin')
    <div class="mb-3 intro-y flex flex-col sm:flex-row items-center mt-8">
        <h1 class="text-lg font-medium mr-auto">
            Data Seksi All
        </h1>
        <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
            <a href="{{ route('seksi.add') }}" class="btn btn-primary shadow-md mr-2">Tambah Data</a>

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
                                        <th>Kode Seksi</th>
                                        <th>Mata Pelajaran</th>
                                        <th> Guru</th>
                                        <th>Kelas / Rombel</th>
                                        <th>Tahun Ajar</th>
                                        <th>Action</th>
                                </thead>
                                <tbody>
                                    @foreach ($seksi as $key => $item)
                                        {{--  @php
                                            $guru = App\Models\Guru::where('id', $item->id_guru)->first();

                                        @endphp  --}}
                                        <tr>
                                            <td> {{ $key + 1 }} </td>
                                     <td> {{$item->id}} </td>

                                            <td>
                                                <a id="delete" href="{{ route('seksi.delete', $item->id) }}"
                                                    class="btn btn-danger mr-1 mb-2">
                                                    <i data-lucide="trash" class="w-4 h-4"></i> </a>
                                                <a href="{{ route('seksi.edit', $item->id) }}"
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
