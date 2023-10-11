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
                                        <th>Sl</th>
                                        <th>Name</th>
                                        <th>Username</th>
                                        <th>Foto</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                </thead>
                                <tbody>
                                    @foreach ($users as $key => $item)
                                        <tr>
                                            <td> {{ $key + 1 }} </td>
                                            <td> {{ $item->name }} </td>
                                            <td> {{ $item->username }} </td>
                                            <td>
                                                <img style="width:70px; height:60px"
                                                    src=" {{ !empty($item->profile_image) ? url('uploads/admin_images/' . $item->profile_image) : url('backend/dist/images/profile-user.png') }}"
                                                    alt="">
                                            </td>
                                            <td> {{ $item->email }} </td>

                                            <td>
                                                @if ($item->role == '1')
                                                    <span class="text-dark">Admin</span>
                                                @elseif($item->role == '2')
                                                    <span class="text-danger">Kepala Sekolah</span>
                                                @elseif($item->role == '3')
                                                    <span class="text-warning">Wakil Kurikulum</span>
                                                @elseif($item->role == '4')
                                                    <span class="text-success">Guru</span>
                                                @elseif($item->role == '5')
                                                    <span class="text-primary">Orang Tua</span>
                                                @elseif($item->role == '6')
                                                    <span class="text-primary">Siswa</span>
                                                @endif

                                            </td>

                                            <td>
                                                @if ($item->status == '0')
                                                    <span class="btn btn-outline-danger">Tidak Aktif</span>
                                                @elseif($item->status == '1')
                                                    <span class="btn btn-outline-success">Aktif</span>
                                                @endif
                                            </td>
                                            <td>
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
