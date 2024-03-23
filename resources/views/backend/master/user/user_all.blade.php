@extends('admin.admin_master')
@section('admin')
    <div class="mb-3 intro-y flex flex-col sm:flex-row items-center mt-8">
        <h1 class="text-lg font-medium mr-auto">
            Data Akun Pengguna All
        </h1>

    </div>
    <form role="form" action="{{ route('user.all') }}" method="get" class="sm:flex">

        <div class="flex-1 sm:mr-2">
            <div class="form-group">
                <input type="text" name="searchnama" class="form-control" placeholder="Nama"
                    value="{{ request('searchnama') }}">

            </div>
        </div>

        <div class="flex-1 sm:mr-2">
            <div class="form-group">
                <input type="text" name="searchusername" class="form-control" placeholder="Username"
                    value="{{ request('searchusername') }}">
            </div>
        </div>

        <div class="flex-1 sm:mr-2">
            <div class="form-group">
                <input type="text" name="searchemail" class="form-control" placeholder="Email"
                    value="{{ request('searchemail') }}">
            </div>
        </div>

        <div class="flex-1 sm:mr-2">
            <div class="form-group">

                <select name="searchrole" class="form-select w-full">
                    <option value="">Role</option>
                    <option value="1">Admin Sistem</option>
                    <option value="2">Kepala Sekolah</option>
                    <option value="3">Wakil Kurikulum</option>
                    <option value="4">Guru</option>
                    <option value="5">Orang Tua</option>
                    <option value="6">Siswa</option>
                </select>
            </div>
        </div>

        <div class="flex-1 sm:mr-2">
            <div class="form-group">

                <select name="searchstatus" class="form-select w-full">
                    <option value="">Status</option>
                    <option value="1">Aktif</option>
                    <option value="0">Tidak Aktif</option>
                </select>
            </div>
        </div>
        <div class="sm:ml-1">
            <button type="submit" class="btn btn-default">Search</button>
        </div>
        <div class="sm:ml-2">

            <a href="{{ route('user.all') }}" class="btn btn-danger">Clear</a>

        </div>
    </form>
    <div class="col-span-2 mb-4 mt-4">

        <a class="btn btn-pending btn-block" href="{{ route('user.excel') }} ">
            <span class="glyphicon glyphicon-download"></span> </span> <i data-lucide="download"
                class="w-5 h-5"></i>&nbsp;Export
        </a>

        <a href="javascript:;" class="btn btn-success btn-block" data-tw-toggle="modal"
            data-tw-target="#header-footer-modal-preview">
            <span class="glyphicon glyphicon-download"></span> </span> <i data-lucide="upload"
                class="w-5 h-5"></i>&nbsp;Upload</a>

        @if (Auth::user()->role == '1' || Auth::user()->role == '3')
            <a href="{{ route('user.add') }}" class="btn btn-primary btn-block"> <span
                    class="glyphicon glyphicon-download"></span> </span> <i data-lucide="plus-square"
                    class="w-5 h-5"></i>&nbsp;Tambah Data</a>
        @endif

    </div>
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card overflow-x-auto">
                        <div class="card-body">
                            <table id="datatable" class="table table-bordered">
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
                                            <td class="whitespace-nowrap" style="text-transform: capitalize;">
                                                {{ $item->name }} </td>
                                            <td class="whitespace-nowrap"> {{ $item->username }} </td>
                                            <td class="whitespace-nowrap">
                                                <img src="{{ !empty($item->profile_image) ? url('uploads/admin_images/' . $item->profile_image) : url('backend/dist/images/profile-user.png') }}"
                                                    style="max-width:60px; max-height:100px" alt="User Image">
                                            </td>

                                            <td class="whitespace-nowrap"> {{ $item->email }} </td>

                                            <td class="whitespace-nowrap">
                                                @if ($item->role == '1')
                                                    <span class="text-dark">Admin Sistem</span>
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
                                                <a href="{{ route('user.delete', $item->id) }}"
                                                    class="btn btn-danger mr-1 mb-2" title="Delete" id="delete">
                                                    <i data-lucide="trash" class="w-4 h-4"></i>
                                                </a>
                                                @if ($item->status == '1')
                                                    <a href="{{ route('user.tidak.aktif', $item->id) }}"
                                                        class="btn btn-warning mr-1 mb-2" title="Inactive">
                                                        <i data-lucide="x-circle" class="w-4 h-4"></i> </a>
                                                @elseif($item->status == '0')
                                                    <a href="{{ route('user.aktif', $item->id) }}"
                                                        class="btn btn-primary mr-1 mb-2" title="Active">
                                                        <i data-lucide="check-circle" class="w-4 h-4"></i> </a>
                                                @endif


                                                <a href="{{ route('user.view', $item->id) }}"
                                                    class="btn btn-success mr-1 mb-2" title="Edit Profile">
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


    <!-- BEGIN: Modal Toggle -->
    <!-- END: Modal Toggle --> <!-- BEGIN: Modal Content -->
    <div id="header-footer-modal-preview" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content"> <!-- BEGIN: Modal Header -->
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto">Upload Data Akun Pengguna</h2> <a
                        href="{{ asset('/template/Template Pengguna.xlsx') }}"
                        class="btn btn-outline-secondary hidden sm:flex"> <i data-lucide="download"
                            class="w-4 h-4 mr-2"></i>
                        Template </a>

                </div> <!-- END: Modal Header --> <!-- BEGIN: Modal Body -->
                <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                    <div class="col-span-12 sm:col-span-12">
                        <form
                            data-file-types="application/vnd.ms-excel|application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
                            class="dropzone flex justify-center items-center" action="{{ route('user.upload') }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="fallback"> <input name="file" type="file" /> </div>

                            <div class="dz-message" data-dz-message>
                                <div class="text-center">
                                    <img alt="Midone - HTML Admin Template" class="w-10 mx-auto"
                                        src="{{ asset('backend/dist/images/excel.png') }}">
                                    <div class="text-lg font-medium">Drop files here or click to upload.</div>
                                </div>
                            </div>
                    </div>

                </div> <!-- END: Modal Body --> <!-- BEGIN: Modal Footer -->
                <div class="modal-footer"> <a href="{{ route('siswa.all') }}" data-tw-dismiss="modal"
                        class="btn btn-danger w-20 mr-1">Cancel</a> <button type="submit"
                        class="btn btn-primary w-20">Save</button> </div> <!-- END: Modal Footer -->
                </form>
            </div>
        </div>
    </div> <!-- END: Modal Content -->
@endsection
