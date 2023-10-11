@extends('admin.admin_master')
@section('admin')
    @php
        use Illuminate\Support\Facades\Auth;
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
        $tahunajar = App\Models\Tahunajar::all()->count();

        $userId = Auth::user()->id;
        $jadwalguru = App\Models\Jadwalmapel::join('pengampus', 'jadwalmapels.id_pengampu', '=', 'pengampus.id')
            ->join('gurus', 'pengampus.id_guru', '=', 'gurus.id')
            ->where('status', '=', '2')
            ->where('gurus.id_user', '=', $userId)
            ->orderBy('id_hari', 'asc')
            ->orderBy('id_waktu', 'asc')
            ->count();

        // Ambil ID guru berdasarkan ID user yang aktif
        $guruId = App\Models\Guru::where('id_user', $userId)->value('id');

        // Ambil ID pengampu yang berelasi dengan guru melalui jadwalmapels
        $pengampuIds = App\Models\Jadwalmapel::whereHas('pengampus', function ($query) use ($guruId) {
            $query->where('id_guru', $guruId);
        })
            ->pluck('id_pengampu')
            ->unique();

        // Ambil data siswa dengan kelas yang sama dengan pengampu yang diambil dari jadwalmapels
        $siswaguru = App\Models\Siswa::whereIn('kelas', function ($query) use ($pengampuIds) {
            $query
                ->select('kelas')
                ->from('pengampus')
                ->whereIn('id', $pengampuIds);
        })->count();
    @endphp

    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-12 2xl:col-span-9">
            <div class="grid grid-cols-12 gap-6">
                <!-- BEGIN: General Report -->
                <div class="col-span-12 mt-8">
                    <div class="ml-1 mb-2 intro-y flex items-center justify-between">
                        <h2 class="  text-primary">
                            <span class="text-4xl "> Selamat Datang, @if (Auth::user()->role == '1')
                                    Admin Sistem
                                @elseif (Auth::user()->role == '2')
                                    Kepala Sekolah
                                @elseif (Auth::user()->role == '3')
                                    Operator
                                @elseif (Auth::user()->role == '4')
                                    Guru
                                @elseif (Auth::user()->role == '5')
                                    Orang Tua
                                @elseif (Auth::user()->role == '6')
                                    Siswa
                                @endif </span>
                            <br>
                          
                        </h2>
                    </div>

                    <div class="bg-danger p-2 mb-2">
                        <span class="text-white">
                            Silahkan gunakan aplikasi dengan sebaik-baiknya, dan jaga kerahasiaan email, username, dan
                            password Anda..!!!
                        </span>
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
                        <div class="grid grid-cols-12 gap-6 mt-3">
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
                        <div class="grid grid-cols-12 gap-6 mt-3">
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
                                            <i class="report-box__icon text-success">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="lucide lucide-calendar-days">
                                                    <rect width="18" height="18" x="3" y="4" rx="2"
                                                        ry="2" />
                                                    <line x1="16" x2="16" y1="2" y2="6" />
                                                    <line x1="8" x2="8" y1="2" y2="6" />
                                                    <line x1="3" x2="21" y1="10" y2="10" />
                                                    <path d="M8 14h.01" />
                                                    <path d="M12 14h.01" />
                                                    <path d="M16 14h.01" />
                                                    <path d="M8 18h.01" />
                                                    <path d="M12 18h.01" />
                                                    <path d="M16 18h.01" />
                                                </svg>
                                            </i>

                                        </div>
                                        <div class="text-3xl font-medium leading-8 mt-6">{{ $jadwal }}</div>
                                        <div class="text-base text-slate-500 mt-1">Jadwal Mapel</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-12 gap-6 mt-3">
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


                    {{--  // bagian  operator//  --}}
                    @if (Auth::user()->role == '3')
                        <div class="grid grid-cols-12 gap-6 mt-3">
                            <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                                <div class="report-box zoom-in">
                                    <div class="box p-5">
                                        <div class="flex">
                                            <i class="report-box__icon text-success">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="lucide lucide-calendar-days">
                                                    <rect width="18" height="18" x="3" y="4" rx="2"
                                                        ry="2" />
                                                    <line x1="16" x2="16" y1="2" y2="6" />
                                                    <line x1="8" x2="8" y1="2" y2="6" />
                                                    <line x1="3" x2="21" y1="10" y2="10" />
                                                    <path d="M8 14h.01" />
                                                    <path d="M12 14h.01" />
                                                    <path d="M16 14h.01" />
                                                    <path d="M8 18h.01" />
                                                    <path d="M12 18h.01" />
                                                    <path d="M16 18h.01" />
                                                </svg>
                                            </i>
                                        </div>
                                        <div class="text-3xl font-medium leading-8 mt-6">{{ $jadwal }}</div>
                                        <div class="text-base text-slate-500 mt-1">Jadwal Mapel</div>
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
                                        <div class="text-base text-slate-500 mt-1">Pengampu Mapel</div>
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

                        <div class="grid grid-cols-12 gap-6 mt-3">
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

                            <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                                <div class="report-box zoom-in">
                                    <div class="box p-5">
                                        <div class="flex">
                                            <i data-lucide="file" class="report-box__icon text-success"></i>

                                        </div>
                                        <div class="text-3xl font-medium leading-8 mt-6">{{ $tahunajar }}</div>
                                        <div class="text-base text-slate-500 mt-1">Tahun Ajar</div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                                <div class="report-box zoom-in">
                                    <div class="box p-5">
                                        <div class="flex">
                                            <i class="report-box__icon text-success"><svg
                                                    xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="lucide lucide-user-square-2">
                                                    <path d="M18 21a6 6 0 0 0-12 0" />
                                                    <circle cx="12" cy="11" r="4" />
                                                    <rect width="18" height="18" x="3" y="3" rx="2" />
                                                </svg></i>

                                        </div>
                                        <div class="text-3xl font-medium leading-8 mt-6">{{ $tahunajar }}</div>
                                        <div class="text-base text-slate-500 mt-1">Wali Kelas</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    {{--  // end bagian  operator //  --}}



                    {{--  // bagian  Guru//  --}}
                    @if (Auth::user()->role == '4')
                        <div class="grid grid-cols-12 gap-6 mt-3">
                            <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                                <div class="report-box zoom-in">
                                    <div class="box p-5">
                                        <div class="flex">
                                            <i class="report-box__icon text-success">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="lucide lucide-calendar-days">
                                                    <rect width="18" height="18" x="3" y="4" rx="2"
                                                        ry="2" />
                                                    <line x1="16" x2="16" y1="2" y2="6" />
                                                    <line x1="8" x2="8" y1="2" y2="6" />
                                                    <line x1="3" x2="21" y1="10" y2="10" />
                                                    <path d="M8 14h.01" />
                                                    <path d="M12 14h.01" />
                                                    <path d="M16 14h.01" />
                                                    <path d="M8 18h.01" />
                                                    <path d="M12 18h.01" />
                                                    <path d="M16 18h.01" />
                                                </svg>
                                            </i>
                                        </div>
                                        <div class="text-3xl font-medium leading-8 mt-6">{{ $jadwalguru }}</div>
                                        <div class="text-base text-slate-500 mt-1">Jadwal Mapel</div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                                <div class="report-box zoom-in">
                                    <div class="box p-5">
                                        <div class="flex">
                                            <i data-lucide="users" class="report-box__icon text-primary"></i>

                                        </div>
                                        <div class="text-3xl font-medium leading-8 mt-6">{{ $siswaguru }}</div>
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
