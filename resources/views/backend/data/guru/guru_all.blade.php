@extends('admin.admin_master')
@section('admin')
    <div class="mb-3 intro-y flex flex-col sm:flex-row items-center mt-8">
        <h1 class="text-lg font-medium mr-auto">
            Guru All
        </h1>
        <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
            <a href="{{ route('guru.add') }}" class="btn btn-primary shadow-md mr-2">Tambah Data</a>

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
                                        <th style="white-space: nowrap;">Kode Guru</th>
                                        <th>Nama</th>
                                        <th>No HP</th>
                                        <th>Username</th>
                                        <th>Foto</th>
                                        <th>Walas</th>
                                        <th>Action</th>
                                </thead>
                                <tbody>

                                    @foreach ($guru as $key => $item)
                                        @php
                                            $user = App\Models\User::where('id', $item->id_user)->first();
                                            $walas = App\Models\Walas::where('id_guru', $item->id)->first();
                                        @endphp
                                        <tr>
                                            <td> {{ $key + 1 }} </td>
                                            <td style="white-space: nowrap;" class="text-primary"> {{ $item->kode_gr }}
                                            </td>
                                            <td> {{ $item->nama }} </td>
                                            <td> {{ $item->no_hp }} </td>
                                            <td>
                                                @if ($item->id_user == 0)
                                                    <span class="text-danger">Kosong</span>
                                                @else
                                                    {{ $item['users']['username'] }}
                                                @endif
                                            </td>

                                            <td>
                                                <img style="width:70px; height:60px"
                                                    src=" {{ !empty($user->profile_image) ? url('uploads/admin_images/' . $user->profile_image) : url('backend/dist/images/profile-user.png') }}"
                                                    alt="">

                                            </td>
                                            <td>
                                                @if ($walas)
                                                    {{ $walas['kelass']['nama']}}
                                                @else
                                                    <span class="text-danger">Kosong</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a id="delete" href="{{ route('guru.delete', $item->id) }}"
                                                    class="btn btn-danger mr-1 mb-2">
                                                    <i data-lucide="trash" class="w-4 h-4"></i> </a>
                                                <a href="{{ route('guru.edit', $item->id) }}"
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
