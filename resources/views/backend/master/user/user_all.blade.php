@extends('admin.admin_master')
@section('admin')
    <div class="mb-3 intro-y flex flex-col sm:flex-row items-center mt-8">
        <h1 class="text-lg font-medium mr-auto">
            User All
        </h1>
        <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
            <a href="{{ route('user.add') }}" class="btn btn-primary shadow-md mr-2">Tambah Data</a>

        </div>
    </div>
    <div class="col-span-2 mb-4 mt-4">

        <a class="btn btn-success btn-block" href="{{ route('user.excel') }} ">
            <span class="glyphicon glyphicon-download"></span> </span> <i data-lucide="printer"
                class="w-4 h-4"></i>&nbsp;Export Excel
        </a>
        <a class="btn btn-primary btn-block" href="{{ route('user.pdf') }} ">
            <span class="glyphicon glyphicon-download"></span> </span> <i data-lucide="printer"
                class="w-4 h-4"></i>&nbsp;Export Pdf
        </a>

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
                                        <th class="whitespace-nowrap">No</th>
                                        <th class="whitespace-nowrap">Nama</th>
                                        <th class="whitespace-nowrap">Username</th>
                                        <th class="whitespace-nowrap">Foto</th>
                                        <th class="whitespace-nowrap">Email</th>
                                        <th class="whitespace-nowrap">Role</th>
                                        <th class="whitespace-nowrap">Status</th>
                                        <th class="whitespace-nowrap">Last updated</th>
                                        <th class="whitespace-nowrap">Last Active</th>
                                        <th class="whitespace-nowrap">Action</th>
                                </thead>
                                <tbody>
                                    @foreach ($users as $key => $item)
                                        <tr>
                                            <td class="whitespace-nowrap"> {{ $key + 1 }} </td>
                                            <td class="whitespace-nowrap"> {{ $item->name }} </td>
                                            <td class="whitespace-nowrap"> {{ $item->username }} </td>
                                            <td class="whitespace-nowrap">
                                                <img src="{{ !empty($item->profile_image) ? url('uploads/admin_images/' . $item->profile_image) : url('backend/dist/images/profile-user.png') }}"
                                                    style="max-width:60px; max-height:100px" alt="User Image">
                                            </td>

                                            <td class="whitespace-nowrap"> {{ $item->email }} </td>

                                            <td class="whitespace-nowrap">
                                                @if ($item->role == '1')
                                                    <span class="text-dark">Admin</span>
                                                @elseif($item->role == '2')
                                                    <span class="text-danger">Kepala Sekolah</span>
                                                @elseif($item->role == '3')
                                                    <span class="text-warning">Operator</span>
                                                @elseif($item->role == '4')
                                                    <span class="text-success">Guru</span>
                                                @elseif($item->role == '5')
                                                    <span class="text-primary">Orang Tua</span>
                                                @elseif($item->role == '6')
                                                    <span class="text-primary">Siswa</span>
                                                @endif

                                            </td>

                                            <td class="whitespace-nowrap">
                                                @if ($item->status == '0')
                                                    <span class="btn btn-outline-danger">Tidak Aktif</span>
                                                @elseif($item->status == '1')
                                                    <span class="btn btn-outline-success">Aktif</span>
                                                @endif
                                            </td>
                                            <td class="whitespace-nowrap">
                                                @if ($item->updated_at == null)
                                                    {{ $item->created_at }}
                                                @else
                                                    {{ $item->updated_at }}
                                                @endif
                                            </td>
                                            <td class="whitespace-nowrap">

                                                {{ $item->last }}

                                            </td>
                                            <td class="whitespace-nowrap">
                                                @if ($item->status == '1')
                                                    <a href="{{ route('user.tidak.aktif', $item->id) }}"
                                                        class="btn btn-danger mr-1 mb-2" title="Inactive">
                                                        <i data-lucide="x-circle" class="w-4 h-4"></i> </a>
                                                @elseif($item->status == '0')
                                                    <a href="{{ route('user.aktif', $item->id) }}"
                                                        class="btn btn-success mr-1 mb-2" title="Active">
                                                        <i data-lucide="check-circle" class="w-4 h-4"></i> </a>
                                                @endif


                                                <a href="{{ route('user.view', $item->id) }}"
                                                    class="btn btn-primary mr-1 mb-2" title="Edit Profile">
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
