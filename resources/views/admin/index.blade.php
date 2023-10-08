@extends('admin.admin_master')
@section('admin')
    @php
        $user = App\Models\User::all()->count();
        $guru = App\Models\Guru::all()->count();
        $orangtua = App\Models\OrangTua::all()->count();
        $siswa = App\Models\Siswa::all()->count();
        $jadwal = App\Models\Jadwalmapel::all()->count();
        $mapel = App\Models\Mapel::all()->count();
        $hari = App\Models\Hari::all()->count();
        $jurusan = App\Models\Jurusan::all()->count();
        $kelas = App\Models\Kelas::all()->count();
        $ruangan = App\Models\Ruangan::all()->count();
        $waktu = App\Models\Waktu::all()->count();
        $pengampu = App\Models\Pengampu::all()->count();
    @endphp

    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-12 2xl:col-span-9">
            <div class="grid grid-cols-12 gap-6">
                <!-- BEGIN: General Report -->
                <div class="col-span-12 mt-8">
                    <div class="ml-2 mb-8 intro-y flex items-center justify-between">
                        <h2 class="  text-primary">
                            <span class="text-4xl "> Selamat Datang </span>
                            <br>
                            <div class="mt-2 text-3xl">
                                Sistem Informasi Akademik
                            </div>
                        </h2>
                    </div>
                    <div class="intro-y flex items-center h-10">
                        <h2 class="text-lg font-medium truncate mr-5">
                            General Report
                        </h2>
                        <a href="" class="ml-auto flex items-center text-primary">
                            <i data-lucide="refresh-ccw" class="w-4 h-4 mr-3"></i> Reload Data </a>
                    </div>

                    {{--  // bagian  admin //  --}}
                    @if (Auth::user()->role == '1')
                        <div class="grid grid-cols-12 gap-6 mt-5">
                            <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                                <div class="report-box zoom-in">
                                    <div class="box p-5">
                                        <div class="flex">
                                            <i data-lucide="users" class="report-box__icon text-pending"></i>

                                        </div>
                                        <div class="text-3xl font-medium leading-8 mt-6">{{ $user }}</div>
                                        <div class="text-base text-slate-500 mt-1">Akun User</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                                <div class="report-box zoom-in">
                                    <div class="box p-5">
                                        <div class="flex">
                                            <i data-lucide="users" class="report-box__icon text-success"></i>

                                        </div>
                                        <div class="text-3xl font-medium leading-8 mt-6">{{ $guru }}</div>
                                        <div class="text-base text-slate-500 mt-1">Guru</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                                <div class="report-box zoom-in">
                                    <div class="box p-5">
                                        <div class="flex">
                                            <i data-lucide="users" class="report-box__icon text-warning"></i>

                                        </div>
                                        <div class="text-3xl font-medium leading-8 mt-6">{{ $orangtua }}</div>
                                        <div class="text-base text-slate-500 mt-1">Orang Tua</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                                <div class="report-box zoom-in">
                                    <div class="box p-5">
                                        <div class="flex">
                                            <i data-lucide="users" class="report-box__icon text-primary"></i>

                                        </div>
                                        <div class="text-3xl font-medium leading-8 mt-6">{{ $siswa }}</div>
                                        <div class="text-base text-slate-500 mt-1">Siswa</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    {{--  // end bagian  admin //  --}}



                    {{--  // bagian  kepsek //  --}}
                    @if (Auth::user()->role == '2')
                        <div class="grid grid-cols-12 gap-6 mt-5">
                            <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                                <div class="report-box zoom-in">
                                    <div class="box p-5">
                                        <div class="flex">
                                            <i data-lucide="users" class="report-box__icon text-primary"></i>

                                        </div>
                                        <div class="text-3xl font-medium leading-8 mt-6">{{ $siswa }}</div>
                                        <div class="text-base text-slate-500 mt-1">Siswa</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                                <div class="report-box zoom-in">
                                    <div class="box p-5">
                                        <div class="flex">
                                            <i data-lucide="users" class="report-box__icon text-primary"></i>

                                        </div>
                                        <div class="text-3xl font-medium leading-8 mt-6">{{ $guru }}</div>
                                        <div class="text-base text-slate-500 mt-1">Guru</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                                <div class="report-box zoom-in">
                                    <div class="box p-5">
                                        <div class="flex">
                                            <i data-lucide="users" class="report-box__icon text-primary"></i>

                                        </div>
                                        <div class="text-3xl font-medium leading-8 mt-6">{{ $orangtua }}</div>
                                        <div class="text-base text-slate-500 mt-1">Orang Tua</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                                <div class="report-box zoom-in">
                                    <div class="box p-5">
                                        <div class="flex">
                                            <i data-lucide="file-text" class="report-box__icon text-success"></i>

                                        </div>
                                        <div class="text-3xl font-medium leading-8 mt-6">{{ $jadwal }}</div>
                                        <div class="text-base text-slate-500 mt-1">Jadwal Mata Pelajaran</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-12 gap-6 mt-5">
                            <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                                <div class="report-box zoom-in">
                                    <div class="box p-5">
                                        <div class="flex">
                                            <i data-lucide="file-text" class="report-box__icon text-success"></i>
                                        </div>
                                        <div class="text-3xl font-medium leading-8 mt-6">{{ $user }}</div>
                                        <div class="text-base text-slate-500 mt-1">Absensi</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                                <div class="report-box zoom-in">
                                    <div class="box p-5">
                                        <div class="flex">
                                            <i data-lucide="file-text" class="report-box__icon text-success"></i>

                                        </div>
                                        <div class="text-3xl font-medium leading-8 mt-6">{{ $guru }}</div>
                                        <div class="text-base text-slate-500 mt-1">Nilai Rapor</div>
                                    </div>
                                </div>
                            </div>
                         
                        </div>
                    @endif
                    {{--  // end bagian  kepsek //  --}}


                    {{--  // bagian  wakil//  --}}
                    @if (Auth::user()->role == '3')
                        <div class="grid grid-cols-12 gap-6 mt-5">
                            <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                                <div class="report-box zoom-in">
                                    <div class="box p-5">
                                        <div class="flex">
                                            <i data-lucide="file-text" class="report-box__icon text-success"></i>
                                        </div>
                                        <div class="text-3xl font-medium leading-8 mt-6">{{ $jadwal }}</div>
                                        <div class="text-base text-slate-500 mt-1">Jadwal Mata Pelajaran</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                                <div class="report-box zoom-in">
                                    <div class="box p-5">
                                        <div class="flex">
                                            <i data-lucide="file" class="report-box__icon text-success"></i>

                                        </div>
                                        <div class="text-3xl font-medium leading-8 mt-6">{{ $mapel }}</div>
                                        <div class="text-base text-slate-500 mt-1">Mata Pelajaran</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                                <div class="report-box zoom-in">
                                    <div class="box p-5">
                                        <div class="flex">
                                            <i data-lucide="users" class="report-box__icon text-primary"></i>

                                        </div>
                                        <div class="text-3xl font-medium leading-8 mt-6">{{ $pengampu }}</div>
                                        <div class="text-base text-slate-500 mt-1">Pengampu</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                                <div class="report-box zoom-in">
                                    <div class="box p-5">
                                        <div class="flex">
                                            <i data-lucide="users" class="report-box__icon text-primary"></i>

                                        </div>
                                        <div class="text-3xl font-medium leading-8 mt-6">{{ $guru }}</div>
                                        <div class="text-base text-slate-500 mt-1">Guru</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-12 gap-6 mt-5">
                            <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                                <div class="report-box zoom-in">
                                    <div class="box p-5">
                                        <div class="flex">
                                            <i class="report-box__icon text-dark"><svg xmlns="http://www.w3.org/2000/svg"
                                                    width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round" class="lucide lucide-school">
                                                    <path d="m4 6 8-4 8 4" />
                                                    <path d="m18 10 4 2v8a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2v-8l4-2" />
                                                    <path d="M14 22v-4a2 2 0 0 0-2-2v0a2 2 0 0 0-2 2v4" />
                                                    <path d="M18 5v17" />
                                                    <path d="M6 5v17" />
                                                    <circle cx="12" cy="9" r="2" />
                                                </svg> </i>
                                        </div>
                                        <div class="text-3xl font-medium leading-8 mt-6">{{ $ruangan }}</div>
                                        <div class="text-base text-slate-500 mt-1">Ruangan</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                                <div class="report-box zoom-in">
                                    <div class="box p-5">
                                        <div class="flex">
                                            <i data-lucide="file" class="report-box__icon text-success"></i>

                                        </div>
                                        <div class="text-3xl font-medium leading-8 mt-6">{{ $jurusan }}</div>
                                        <div class="text-base text-slate-500 mt-1">Jurusan</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                                <div class="report-box zoom-in">
                                    <div class="box p-5">
                                        <div class="flex">
                                            <i data-lucide="file" class="report-box__icon text-success"></i>

                                        </div>
                                        <div class="text-3xl font-medium leading-8 mt-6">{{ $kelas }}</div>
                                        <div class="text-base text-slate-500 mt-1">Kelas</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                                <div class="report-box zoom-in">
                                    <div class="box p-5">
                                        <div class="flex">
                                            <i data-lucide="calendar" class="report-box__icon text-pending"></i>

                                        </div>
                                        <div class="text-3xl font-medium leading-8 mt-6">{{ $hari }}</div>
                                        <div class="text-base text-slate-500 mt-1">Hari</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                                <div class="report-box zoom-in">
                                    <div class="box p-5">
                                        <div class="flex">
                                            <i data-lucide="clock" class="report-box__icon text-pending"></i>

                                        </div>
                                        <div class="text-3xl font-medium leading-8 mt-6">{{ $waktu }}</div>
                                        <div class="text-base text-slate-500 mt-1">Waktu</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    {{--  // end bagian  wakil //  --}}


                    
                    {{--  // bagian  Guru//  --}}
                    @if (Auth::user()->role == '4')
                        <div class="grid grid-cols-12 gap-6 mt-5">
                            <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                                <div class="report-box zoom-in">
                                    <div class="box p-5">
                                        <div class="flex">
                                            <i data-lucide="file-text" class="report-box__icon text-success"></i>
                                        </div>
                                        <div class="text-3xl font-medium leading-8 mt-6">{{ $jadwal }}</div>
                                        <div class="text-base text-slate-500 mt-1">Jadwal Mata Pelajaran</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                                <div class="report-box zoom-in">
                                    <div class="box p-5">
                                        <div class="flex">
                                            <i data-lucide="file" class="report-box__icon text-success"></i>

                                        </div>
                                        <div class="text-3xl font-medium leading-8 mt-6">{{ $mapel }}</div>
                                        <div class="text-base text-slate-500 mt-1">Mata Pelajaran</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                                <div class="report-box zoom-in">
                                    <div class="box p-5">
                                        <div class="flex">
                                            <i data-lucide="users" class="report-box__icon text-primary"></i>

                                        </div>
                                        <div class="text-3xl font-medium leading-8 mt-6">{{ $pengampu }}</div>
                                        <div class="text-base text-slate-500 mt-1">Siswa</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                                <div class="report-box zoom-in">
                                    <div class="box p-5">
                                        <div class="flex">
                                            <i data-lucide="users" class="report-box__icon text-primary"></i>

                                        </div>
                                        <div class="text-3xl font-medium leading-8 mt-6">{{ $guru }}</div>
                                        <div class="text-base text-slate-500 mt-1">Orang Tua</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                  
                    @endif
                    {{--  // end bagian  guru //  --}}
                </div>
                <!-- END: General Report -->


            </div>
        </div>

    </div>
@endsection
