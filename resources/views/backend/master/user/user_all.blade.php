@extends('admin.admin_master')
@section('admin')
    <div class="mb-3 intro-y flex flex-col sm:flex-row items-center mt-8">
        <h1 class="text-lg font-medium mr-auto">
            User All
        </h1>
        <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
            <a href="{{ route('user.add') }}" class="btn btn-primary shadow-md mr-2">Add New User</a>

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
                                        <th>User Image </th>
                                        <th>Email</th>
                                        <th>Jabatan</th>
                                        <th>Role</th>
                                        <th>Action</th>
                                </thead>
                                <tbody>
                                    @foreach ($users as $key => $item)
                                        <tr>
                                            <td> {{ $key + 1 }} </td>
                                            <td> {{ $item->name }} </td>
                                            <td>
                                                <img style="width:80px; height:60px"
                                                    src=" {{ !empty($item->profile_image) ? url('uploads/admin_images/' . $item->profile_image) : url('uploads/no_image.jpg') }}"
                                                    alt="">
                                            </td>
                                            <td> {{ $item->email }} </td>
                                            <td>
                                                @if ($item->jabatan == '0')
                                                    Belum di Pilih
                                                @else
                                                    {{ $item['jabatans']['name'] }}
                                                @endif
                                            </td>
                                            <td>
                                                @if ($item->role == '0')
                                                    <span class="btn btn-outline-pending">Belum di Pilih</span>
                                                @elseif ($item->role == '-')
                                                    <span class="btn btn-outline-secondary">Tidak Aktif</span>
                                                @elseif($item->role == '1')
                                                    <span class="btn btn-outline-pending">Kepsek</span>
                                                @elseif($item->role == '2')
                                                    <span class="btn btn-outline-primary">Wakil Kepsek</span>
                                                @elseif($item->role == '3')
                                                    <span class="btn btn-outline-warning">Verifikator</span>
                                                @elseif($item->role == '4')
                                                    <span class="btn btn-outline-dark"> Admin</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($item->role != '-')
                                                    <a href="{{ route('user.tidak.aktif', $item->id) }}"
                                                        class="btn btn-danger mr-1 mb-2" title="Inactive">
                                                        <i data-lucide="x-circle" class="w-5 h-5"></i> </a>
                                                @elseif($item->role == '-')
                                                    <a href="{{ route('user.aktif', $item->id) }}"
                                                        class="btn btn-success mr-1 mb-2" title="Active">
                                                        <i data-lucide="check-circle" class="w-5 h-5"></i> </a>
                                                @endif


                                                <a href="{{ route('user.view', $item->id) }}"
                                                    class="btn btn-primary mr-1 mb-2" title="Edit Profile">
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
