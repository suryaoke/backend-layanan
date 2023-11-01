@extends('admin.admin_master')
@section('admin')
    <div class="mb-3 intro-y flex flex-col sm:flex-row items-center mt-8">
        <h1 class="text-lg font-medium mr-auto">
            Orang Tua All
        </h1>
        @if (Auth::user()->role == '1' || Auth::user()->role == '3')
            <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
                <a href="{{ route('orangtua.add') }}" class="btn btn-primary shadow-md mr-2">Tambah Data</a>

            </div>
        @endif
    </div>
    <div class="col-span-2 mb-4 mt-4">

        <a class="btn btn-success btn-block" href="{{ route('orangtua.excel') }} ">
            <span class="glyphicon glyphicon-download"></span> </span> <i data-lucide="printer"
                class="w-4 h-4"></i>&nbsp;Export Excel
        </a>
        <a class="btn btn-primary btn-block" href="{{ route('orangtua.pdf') }} ">
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
                                        <th style="white-space: nowrap;">Kode Orang Tua</th>
                                        <th class="whitespace-nowrap">Nama</th>
                                        <th class="whitespace-nowrap">No HP</th>
                                        <th class="whitespace-nowrap">Username</th>
                                        <th class="whitespace-nowrap">Nama Siswa</th>
                                        <th class="whitespace-nowrap">Foto</th>
                                        <th class="whitespace-nowrap">Last Updated</th>
                                        <th class="whitespace-nowrap">Last Active</th>
                                        @if (Auth::user()->role == '1' || Auth::user()->role == '3')
                                            <th class="whitespace-nowrap">Action</th>
                                        @endif
                                </thead>
                                <tbody>

                                    @foreach ($ortu as $key => $item)
                                        <tr>

                                            @php
                                                $user = App\Models\User::where('id', $item->id_user)->first();
                                            @endphp
                                            <td class="whitespace-nowrap"> {{ $key + 1 }} </td>
                                            <td style="white-space: nowrap;" class="text-primary"> {{ $item->kode_ortu }}
                                            </td>
                                            <td class="whitespace-nowrap"> {{ $item->nama }} </td>
                                            <td class="whitespace-nowrap"> {{ $item->no_hp }} </td>
                                            <td class="whitespace-nowrap">
                                                @if ($item->id_user == 0)
                                                    <span class="text-danger">Kosong</span>
                                                @else
                                                    {{ $item['users']['username'] }}
                                                @endif
                                            </td>
                                            <td class="whitespace-nowrap">
                                                @if ($item->id_siswa == 0)
                                                    <span class="text-danger">Kosong</span>
                                                @else
                                                    {{ $item['siswas']['nama'] }}
                                                @endif
                                            </td>
                                            <td class="whitespace-nowrap">
                                                <img style="max-width:70px; max-height:100px"
                                                    src=" {{ !empty($user->profile_image) ? url('uploads/admin_images/' . $user->profile_image) : url('backend/dist/images/profile-user.png') }}"
                                                    alt="">
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
                                                    <a id="delete" href="{{ route('orangtua.delete', $item->id) }}"
                                                        class="btn btn-danger mr-1 mb-2">
                                                        <i data-lucide="trash" class="w-4 h-4"></i> </a>
                                                    <a href="{{ route('orangtua.edit', $item->id) }}"
                                                        class="btn btn-success mr-1 mb-2">
                                                        <i data-lucide="edit" class="w-4 h-4"></i>
                                                    </a>
                                                </td>
                                            @endif

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
