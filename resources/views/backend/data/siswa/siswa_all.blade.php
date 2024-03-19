@extends('admin.admin_master')
@section('admin')
    <div class="mb-3 intro-y flex flex-col sm:flex-row items-center mt-8">
        <h1 class="text-lg font-medium mr-auto">
            Data Siswa All
        </h1>

    </div>

    <div class="col-span-2 mb-4 mt-4">

        <a class="btn btn-pending btn-block" href="{{ route('siswa.excel') }} ">
            <span class="glyphicon glyphicon-download"></span> </span> <i data-lucide="download"
                class="w-5 h-5"></i>&nbsp;Export
        </a>

        <a href="javascript:;" class="btn btn-success btn-block" data-tw-toggle="modal"
            data-tw-target="#header-footer-modal-preview">
            <span class="glyphicon glyphicon-download"></span> </span> <i data-lucide="upload"
                class="w-5 h-5"></i>&nbsp;Upload</a>

        @if (Auth::user()->role == '1' || Auth::user()->role == '3')
            <a href="{{ route('siswa.add') }}" class="btn btn-primary btn-block"> <span
                    class="glyphicon glyphicon-download"></span> </span> <i data-lucide="plus-square"
                    class="w-5 h-5"></i>&nbsp;Tambah Data</a>
        @endif

    </div>
    <div class="page-content">
        <div class="container-fluid ">
            <div class="card overflow-x-auto">
                <table id="datatable" class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="whitespace-nowrap">No</th>
                            <th class="whitespace-nowrap">Nama</th>
                            <th style="white-space: nowrap;">Nisn</th>
                            <th class="whitespace-nowrap">JK</th>
                            <th class="whitespace-nowrap">TTL</th>
                            <th class="whitespace-nowrap">Foto</th>
                            <th class="whitespace-nowrap">Username</th>
                            <th class="whitespace-nowrap">Last Updated</th>
                            <th class="whitespace-nowrap">Last Active</th>
                            @if (Auth::user()->role == '1' || Auth::user()->role == '3')
                                <th class="whitespace-nowrap">Action</th>
                            @endif
                    </thead>
                    <tbody>
                        @foreach ($siswa as $key => $item)
                            @php
                                $user = App\Models\User::where('id', $item->id_user)->first();
                            @endphp
                            <tr>
                                <td class="whitespace-nowrap"> {{ $key + 1 }} </td>
                                <td class="whitespace-nowrap" style="text-transform: capitalize;"> {{ $item->nama }} </td>
                                <td style="white-space: nowrap;"> {{ $item->nisn }} </td>
                                <td class="whitespace-nowrap"> {{ $item->jk }} </td>
                                <td class="whitespace-nowrap" style="text-transform: capitalize;"> {{ $item->tempat }},
                                    {{ $item->tanggal }} </td>

                                <td class="whitespace-nowrap">
                                    <img style="max-width:70px; max-height:100px"
                                        src=" {{ !empty($user->profile_image) ? url('uploads/admin_images/' . $user->profile_image) : url('backend/dist/images/profile-user.png') }}"
                                        alt="">

                                </td>
                                <td class="whitespace-nowrap">
                                    @if ($item->id_user == 0)
                                        <span class="text-danger">Kosong</span>
                                    @else
                                        {{ $item['users']['username'] }}
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
                                    @if ($user)
                                        @if ($user->last == null)
                                            -
                                        @else
                                            {{ $user->last }}
                                        @endif
                                    @else
                                        -
                                    @endif
                                </td>
                                @if (Auth::user()->role == '1' || Auth::user()->role == '3')
                                    <td class="whitespace-nowrap">
                                        <a id="delete" href="{{ route('siswa.delete', $item->id) }}"
                                            class="btn btn-danger mr-1 mb-2">
                                            <i data-lucide="trash" class="w-4 h-4"></i> </a>
                                        <a href="{{ route('siswa.edit', $item->id) }}" class="btn btn-success mr-1 mb-2">
                                            <i data-lucide="edit" class="w-4 h-4"></i>
                                        </a>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div> <!-- end col -->


    </div> <!-- end row -->

    <!-- BEGIN: Modal Toggle -->
    <!-- END: Modal Toggle --> <!-- BEGIN: Modal Content -->
    <div id="header-footer-modal-preview" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content"> <!-- BEGIN: Modal Header -->
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto">Upload Data Siswa</h2> <a
                        href="{{ asset('/template/Template Siswa.xlsx') }}"
                        class="btn btn-outline-secondary hidden sm:flex"> <i data-lucide="download"
                            class="w-4 h-4 mr-2"></i>
                        Template </a>

                </div> <!-- END: Modal Header --> <!-- BEGIN: Modal Body -->
                <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                    <div class="col-span-12 sm:col-span-12">
                        <form
                            data-file-types="application/vnd.ms-excel|application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
                            class="dropzone flex justify-center items-center" action="{{ route('siswa.upload') }}"
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
