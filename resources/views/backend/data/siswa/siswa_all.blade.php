@extends('admin.admin_master')
@section('admin')
    <div class="mb-3 intro-y flex flex-col sm:flex-row items-center mt-8">
        <h1 class="text-lg font-medium mr-auto">
            @php
                $siswa1 = URL::route('siswa.all');

            @endphp
            @if (url()->current() == $siswa1)
                Siswa All
            @else
                @php
                    $kelas1 = app\Models\Kelas::where('id', $search)->first();
                @endphp
                @if ($kelas1 != null)
                    Siswa Kelas {{ $kelas1->nama }}
                @else
                    Siswa Kosong
                @endif
            @endif

        </h1>
        <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
            <a href="{{ route('siswa.add') }}" class="btn btn-primary mr-2"> Tambah Data</a>
            <form method="get" action="{{ route('siswa.search') }}">

                <select name="search">
                    <option> Pilih Kelas..
                    </option>
                    @foreach ($kelas as $item)
                        @php
                            $siswadata = app\Models\Siswa::where('kelas', $item->id)->first();
                        @endphp
                        @if ($siswadata != null)
                            <option value="{{ isset($search) ? $search : "$item->id" }}">
                                {{ $item->nama }} <type="hidden" {{ $item->id }}>
                            </option>
                        @endif
                    @endforeach
                </select>
                <button type="submit" class="btn btn-primary">Search</button>
                @if (url()->current() != $siswa1)
                    <a href="{{ route('siswa.all') }}" class="btn btn-danger">Clear</a>
                @endif
            </form>
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
                                        <th>Nama</th>
                                        <th style="white-space: nowrap;">Nisn</th>
                                        <th>JK</th>
                                        <th>Kelas</th>
                                        <th>Username</th>
                                        <th>Foto</th>
                                        <th>Action</th>
                                </thead>
                                <tbody>
                                    @foreach ($siswa as $key => $item)
                                        @php
                                            $user = App\Models\User::where('id', $item->id_user)->first();
                                        @endphp
                                        <tr>
                                            <td> {{ $key + 1 }} </td>
                                            <td> {{ $item->nama }} </td>
                                            <td style="white-space: nowrap;" class="text-primary"> {{ $item->nisn }} </td>
                                            <td> {{ $item->jk }} </td>
                                            <td> {{ $item['kelass']['nama'] }} </td>
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
                                                <a id="delete" href="{{ route('siswa.delete', $item->id) }}"
                                                    class="btn btn-danger mr-1 mb-2">
                                                    <i data-lucide="trash" class="w-4 h-4"></i> </a>
                                                <a href="{{ route('siswa.edit', $item->id) }}"
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
            <div class="mt-8">{{ $siswa->links() }}</div>
        </div> <!-- end col -->


    </div> <!-- end row -->
@endsection
