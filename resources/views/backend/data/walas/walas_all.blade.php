@extends('admin.admin_master')
@section('admin')
    <div class="mb-3 intro-y flex flex-col sm:flex-row items-center mt-8">
        <h1 class="text-lg font-medium mr-auto" style="font-size: 20px">
            Data Wali Kelas All
        </h1>
        <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
            <a href="{{ route('walas.add') }}" class="btn btn-primary shadow-md mr-2">Tambah Data</a>

        </div>
    </div>
    <div class="grid grid-cols-12 gap-6 mt-5">

        <!-- BEGIN: Users Layout -->
        @foreach ($walas as $key => $item)
            @php
                $guru = App\Models\Guru::where('id', $item->id_guru)->first();
                $user = App\Models\User::where('id', $guru->id_user)->first();
                $siswa = App\Models\Siswa::where('kelas', $item->id_kelas)->count();
            @endphp
            <div class="intro-y col-span-12 md:col-span-6 lg:col-span-4 xl:col-span-3">
                <div class="box">
                    <div class="p-3">
                        <div
                            class="h-40 2xl:h-56 image-fit rounded-md overflow-hidden before:block before:absolute before:w-full before:h-full before:top-0 before:left-0 before:z-10 before:bg-gradient-to-t before:from-black before:to-black/10">
                            <img alt="Midone - HTML Admin Template" class="rounded-md"
                                src=" {{ !empty($user->profile_image) ? url('uploads/admin_images/' . $user->profile_image) : url('backend/dist/images/profile-user.png') }}">
                            <div class="absolute bottom-0 text-white px-5 pb-6 z-10"> <a href=""
                                    class="block font-medium text-base">{{ $guru->nama }}</a> <span
                                    class="text-white/90 text-xs mt-3">{{ $guru->kode_gr }}</span> </div>
                        </div>
                        <div class="text-slate-600 dark:text-slate-500 mt-5">
                            <div class="flex items-center ">
                                <div class="mr-1"> <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-square-2">
                                        <path d="M18 21a6 6 0 0 0-12 0" />
                                        <circle cx="12" cy="11" r="4" />
                                        <rect width="18" height="18" x="3" y="3" rx="2" />
                                    </svg> </div> Wali Kelas:
                                {{ $item['kelass']['tingkat'] }} {{ $item['kelass']['nama'] }}
                                {{ $item['kelass']['jurusans']['nama'] }}
                            </div>
                            <div class="flex items-center mt-2"> <i data-lucide="users" class="w-4 h-4 mr-2"></i> Siswa :
                                {{ $siswa }} Orang</div>
                        </div>
                    </div>
                    <div
                        class="flex justify-center lg:justify-end items-center p-5 border-t border-slate-200/60 dark:border-darkmode-400">

                        <a class="flex items-center text-success mr-3" href="{{ route('walas.edit', $item->id) }}"> <i
                                data-lucide="check-square" class="w-4 h-4 mr-1"></i> Edit </a>
                        <a id="delete" class="flex items-center text-danger"
                            href="{{ route('walas.delete', $item->id) }}" data-tw-toggle="modal"
                            data-tw-target="#delete-confirmation-modal"> <i data-lucide="trash-2" class="w-4 h-4 mr-1"></i>
                            Delete </a>
                    </div>
                </div>
            </div>
        @endforeach

    </div>
    <div class="mt-8">{{ $walas->links() }}</div>
@endsection
