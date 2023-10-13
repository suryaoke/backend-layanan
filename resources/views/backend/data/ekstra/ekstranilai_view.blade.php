@extends('admin.admin_master')
@section('admin')
    <div class="mb-3 intro-y flex flex-col sm:flex-row items-center mt-8">
        <h1 class="text-lg font-medium mr-auto">
            Data Ekstrakulikuler Siswa All
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
                                        <th>Nama Ekstrakulikuler</th>
                                        <th>Nisn</th>
                                        <th>Nama</th>
                                        <th>Kelas</th>
                                        <th>JK</th>
                                        <th>Nilai</th>
                                        <th>Ket</th>
                                        <th>Pembina</th>
                                       
                                </thead>
                                <tbody>
                                    @foreach ($ekstranilai as $key => $item)
                                        <tr>
                                            <td> {{ $key + 1 }} </td>
                                            <td> {{ $item['ekstras']['nama'] }} </td>
                                            <td> {{ $item['siswas']['nisn'] }} </td>
                                            <td> {{ $item['siswas']['nama'] }} </td>

                                            <td style="white-space: nowrap;"> {{ $item['siswas']['kelass']['tingkat'] }}
                                                {{ $item['siswas']['kelass']['nama'] }}
                                                {{ $item['siswas']['kelass']['jurusans']['nama'] }}
                                            </td>
                                            <td> {{ $item['siswas']['jk'] }} </td>
                                            <td>
                                                @if ($item->nilai == null)
                                                    -
                                                @else
                                                    {{ $item->nilai }}
                                                @endif
                                            </td>
                                            <td>
                                                @if ($item->ket == null)
                                                    -
                                                @else
                                                    {{ $item->ket }}
                                                @endif
                                            </td>
                                            <td> {{ $item['ekstras']['gurus']['nama'] }} </td>
                                           
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
