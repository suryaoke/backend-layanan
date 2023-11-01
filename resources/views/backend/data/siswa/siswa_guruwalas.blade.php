@extends('admin.admin_master')
@section('admin')
    <div class="mb-3 intro-y flex flex-col sm:flex-row items-center mt-8">
        <h1 class="text-lg font-medium mr-auto">
            Siswa Walas All
        </h1>

    </div>
    
    <div class="col-span-2 mb-4 mt-4">

        <a class="btn btn-success btn-block" href=" ">
            <span class="glyphicon glyphicon-download"></span> </span> <i data-lucide="printer"
                class="w-4 h-4"></i>&nbsp;Export Excel
        </a>
        <a href="javascript:;" data-tw-toggle="modal" data-tw-target="#pdf-modal-preview" class="btn btn-warning"> <span
                class="glyphicon glyphicon-download"></span> </span> <i data-lucide="printer"
                class="w-4 h-4"></i>&nbsp;Export Pdf</a>

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
                                        <th>Nisn</th>
                                        <th>JK</th>
                                      
                                        <th>Username</th>

                                </thead>
                                <tbody>
                                    @if ($walas)
                                        @foreach ($siswa as $key => $item)
                                            <tr>
                                                <td> {{ $key + 1 }} </td>
                                                <td> {{ $item->nama }} </td>
                                                <td> {{ $item->nisn }} </td>
                                                <td> {{ $item->jk }} </td>
                                               
                                                <td>
                                                    @if ($item->id_user == 0)
                                                        <span class="text-danger">Kosong</span>
                                                    @else
                                                        {{ $item['users']['username'] }}
                                                    @endif
                                                </td>


                                            </tr>
                                        @endforeach
                                    @endif


                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>

        </div> <!-- end col -->


    </div> <!-- end row -->
@endsection
