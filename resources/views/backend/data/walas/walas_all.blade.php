@extends('admin.admin_master')
@section('admin')
    <div class="mb-3 intro-y flex flex-col sm:flex-row items-center mt-8">
        <h1 class="text-lg font-medium mr-auto">
            Data Wali Kelas All
        </h1>

    </div>

    <form role="form" action="{{ route('walas.all') }}" method="get" class="sm:flex">

        <div class="flex-1 sm:mr-2">
            <div class="form-group">
                <input type="text" name="searchkode" class="form-control" placeholder="Kode Guru"
                    value="{{ request('searchkode') }}">
            </div>
        </div>
        <div class="flex-1 sm:mr-2">
            <div class="form-group">
                <input type="text" name="searchnama" class="form-control" placeholder="Nama Guru"
                    value="{{ request('searchnama') }}">
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

        <div class="sm:ml-1">
            <button type="submit" class="btn btn-default">Search</button>
        </div>
        <div class="sm:ml-2">

            <a href="{{ route('walas.all') }}" class="btn btn-danger">Clear</a>

        </div>
    </form>

    <div class="col-span-2 mb-4 mt-4">
        <a href="{{ route('walas.add') }}" class="btn btn-primary btn-block"> <span
                class="glyphicon glyphicon-download"></span> </span> <i data-lucide="plus-square"
                class="w-5 h-5"></i>&nbsp;Tambah Data</a>

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
                                        <th>Nama Guru</th>
                                        <th>Kode Guru</th>
                                        <th>Kelas</th>
                                        <th>Action</th>
                                </thead>
                                <tbody>
                                    @foreach ($walas as $key => $item)
                                        @php
                                            $guru = App\Models\Guru::where('id', $item->id_guru)->first();

                                        @endphp
                                        <tr>
                                            <td> {{ $key + 1 }} </td>
                                            <td> {{ $guru->nama }} </td>
                                            <td>{{ $guru->kode_gr }}</td>
                                            <td> {{ $item['kelass']['tingkat'] }} {{ $item['kelass']['nama'] }}
                                                {{ $item['kelass']['jurusans']['nama'] }}</td>

                                            <td>
                                                <a id="delete" href="{{ route('walas.delete', $item->id) }}"
                                                    class="btn btn-danger mr-1 mb-2">
                                                    <i data-lucide="trash" class="w-4 h-4"></i> </a>
                                                <a href="{{ route('walas.edit', $item->id) }}"
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
