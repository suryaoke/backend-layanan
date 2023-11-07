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
        $seksi = App\Models\Seksi::join('jadwalmapels', 'seksis.id_jadwal', '=', 'jadwalmapels.id')
            ->join('pengampus', 'jadwalmapels.id_pengampu', '=', 'pengampus.id')
            ->join('gurus', 'pengampus.id_guru', '=', 'gurus.id')
            ->where('status', '=', '2')
            ->where('gurus.id_user', '=', $userId)
            ->select('seksis.*')
            ->get();

        $guruId = App\Models\Guru::where('id_user', $userId)->value('id');
        $kepsek = App\Models\User::where('role', '2')->first();
        if ($guruId) {
            // Ambil ID pengampu yang berelasi dengan guru melalui jadwalmapels
            $pengampuIds = App\Models\Jadwalmapel::whereHas('pengampus', function ($query) use ($guruId) {
                $query->where('id_guru', $guruId);
            })
                ->pluck('id_pengampu')
                ->unique();

            $kepsek = App\Models\User::where('role', '2')->first();
            $nipkepsek = App\Models\Guru::where('id_user', $kepsek->id)->first();

            $walas = App\Models\Walas::where('id_guru', $guruId)->first();
            $kelaswalas = null;
            $kelaswalasjurusan = null;

            if ($walas) {
                $rombel = App\Models\Rombel::where('id_walas', $walas->id)->first();
                if ($rombel) {
                    $kelaswalas = App\Models\Kelas::where('id', $rombel->id_kelas)->first();
                    if ($kelaswalas) {
                        $kelaswalasjurusan = App\Models\Jurusan::where('id', $kelaswalas->id_jurusan)->first();
                    }
                    $rombelsiswa = App\Models\Rombelsiswa::where('id_rombel', $rombel->id)->count();
                }
            }

            $jadwal = App\Models\Guru::where('id_user', $userId)->value('id');
        }

        $info = App\Models\Info::orderby('created_at', 'asc')->get();

    @endphp

    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-12 2xl:col-span-9">
            <div class="grid grid-cols-12 gap-6">
                <!-- BEGIN: General Report -->
                <div class="col-span-12 mt-1">
                    <di class="ml-1 mb-2 intro-y flex items-center justify-between">
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
                    </di>
                    <div class="intro-y alert alert-danger show mb-2 " role="alert">
                        <span>
                            Silahkan gunakan aplikasi dengan sebaik-baiknya, dan jaga kerahasiaan email, username, dan
                            password Anda..!!!
                        </span>
                    </div>



                    <div class="grid grid-cols-12 gap-6 mb-2">
                        <!-- BEGIN: FAQ Menu -->
                        <div class="intro-y col-span-12 lg:col-span-4 xl:col-span-3 ">
                            <div class="intro-y box mt-4 lg:mt-0">
                                <div class="relative flex items-center p-5">
                                    <div>
                                        <img style="width:145px; height:155px" alt="Midone - HTML Admin Template"
                                            src=" {{ !empty($kepsek->profile_image) ? url('uploads/admin_images/' . $kepsek->profile_image) : url('backend/dist/images/profile-user.png') }}">
                                    </div>

                                </div>

                                <div class="p-1 border-t ml-4 border-slate-200/60 dark:border-darkmode-400">
                                    <a class="flex ml-8 " href=""> Kepala Sekolah</a>
                                    <a class="flex items-center mt-2 mb-2" href=""> <i data-lucide="user"
                                            class="w-4 h-4 mr-2"></i> {{ $kepsek->name }}</a>

                                </div>

                            </div>
                        </div>
                        <!-- END: FAQ Menu -->
                        <!-- BEGIN: FAQ Content -->


                        <div class="intro-y col-span-12 lg:col-span-8 xl:col-span-9 mb-2">
                            <div class="intro-y box lg:mt-4">
                                <div class="flex items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                                    <h2 class="font-medium text-base mr-auto">
                                        Visi - Misi MAN 1 Kota Padang.
                                    </h2>
                                </div>
                                <div id="faq-accordion-1" class="accordion accordion-boxed p-5">
                                    <div class="accordion-item">
                                        <div id="faq-accordion-content-1" class="accordion-header">
                                            <button class="accordion-button" type="button" data-tw-toggle="collapse"
                                                data-tw-target="#faq-accordion-collapse-1" aria-expanded="true"
                                                aria-controls="faq-accordion-collapse-1"> Visi</button>
                                        </div>
                                        <div id="faq-accordion-collapse-1" class="accordion-collapse collapse show"
                                            aria-labelledby="faq-accordion-content-1" data-tw-parent="#faq-accordion-1">
                                            <div class="accordion-body text-slate-600 dark:text-slate-600 leading-relaxed">
                                                Unggul, Berakhlak dan Berbudaya Lingkungan. </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <div id="faq-accordion-content-2" class="accordion-header">
                                            <button class="accordion-button collapsed" type="button"
                                                data-tw-toggle="collapse" data-tw-target="#faq-accordion-collapse-2"
                                                aria-expanded="false" aria-controls="faq-accordion-collapse-2">
                                                Misi</button>
                                        </div>
                                        <div id="faq-accordion-collapse-2" class="accordion-collapse collapse"
                                            aria-labelledby="faq-accordion-content-2" data-tw-parent="#faq-accordion-1">
                                            <div class="accordion-body text-slate-600 dark:text-slate-600 leading-relaxed">
                                                1. Mewujudkan managerial kependidikan yang profesional <br>
                                                2. Mewujudkan pendidikan yang islami, berkualitas dan berdaya guna <br>
                                                3. Mewujudkan SDM yang berkualitas, profesional dan menguasai teknologi <br>
                                                4. Mewujudkan suasana pembelajaran yang kondusif, persuasif dan kompetitif
                                                <br>
                                                5. Membina dan mengembangkan potensi guru dan siswa secara terencana dan
                                                profesional <br>
                                                6. Mewujudkan siswa yang sehat, cerdas mandiri dan berbudaya lingkungan <br>
                                                7. Membina seluruh perangkat madrasah untuk mengembangkan sikap:<br>
                                                &emsp; a. Mencegah pencemaran <br>
                                                &emsp; b. Mencegah kerusakan lingkungan <br>
                                                &emsp; c. Mengupayakan pelestarian lingkungan.
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>
                        <!-- END: FAQ Content -->
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
                                        <div class="text-3xl font-medium leading-8 mt-6"> 0</div>
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

                        <div class="grid grid-cols-12 gap-6 mb-2 mt-8">
                            <!-- BEGIN: FAQ Menu -->
                            <div class="intro-y col-span-12 lg:col-span-4 xl:col-span-3 ">
                                <div class="intro-y box mt-4 lg:mt-0">
                                    <div class="relative flex items-center p-5">

                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-user-square-2">
                                            <path d="M18 21a6 6 0 0 0-12 0" />
                                            <circle cx="12" cy="11" r="4" />
                                            <rect width="18" height="18" x="3" y="3" rx="2" />
                                        </svg> <span class="ml-2" style="font-size: 18px"> Wali Kelas</span>



                                    </div>

                                    <div class="p-1 border-t ml-4 border-slate-200/60 dark:border-darkmode-400">

                                        <a class="flex items-center mt-2 mb-2" href=""> Kelas :
                                            @if ($walas && $kelaswalas)
                                                {{ $kelaswalas->tingkat ?? 'Unknown' }}
                                                {{ $kelaswalas->nama ?? 'Unknown' }}
                                                {{ $kelaswalasjurusan->nama ?? 'Unknown' }}
                                            @else
                                                -
                                            @endif

                                        </a>
                                        <a class="flex items-center mt-2 mb-2" href=""> Jumlah Siswa:
                                            @if ($walas)
                                                {{ $rombelsiswa ?? '0' }} Orang
                                            @else
                                                -
                                            @endif
                                        </a>
                                    </div>

                                </div>
                            </div>
                            <!-- END: FAQ Menu -->
                            <!-- BEGIN: FAQ Content -->



                            <div class="intro-y col-span-12 lg:col-span-8 xl:col-span-9 mb-2">
                                <div class="intro-y box lg:mt-4">
                                    <div
                                        class="flex items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                                        <h2 class="font-medium text-base mr-auto">
                                            <i></i> Kelas Anda
                                        </h2>
                                    </div>
                                    <div id="faq-accordion-1" class="accordion accordion-boxed p-5">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="card overflow-x-auto">
                                                    <div class="card-body">
                                                        <table id="datatable" class="table table-report -mt-2">

                                                            <thead>
                                                                <tr>

                                                                    <th class="whitespace-nowrap">Kelas</th>
                                                                    <th class="whitespace-nowrap">Mapel</th>
                                                                    <th class="whitespace-nowrap">Pengetahuan</th>
                                                                    <th class="whitespace-nowrap">Keterampilan</th>
                                                                </tr>
                                                            </thead>
                                                            @foreach ($seksi as $key => $item)
                                                                @php
                                                                    $rombel = App\Models\Rombel::where('id', $item->id_rombel)->first();
                                                                    $kelas = App\Models\Kelas::where('id', $rombel->id_kelas)->first();
                                                                    $jurusan = App\Models\Jurusan::where('id', $kelas->id_jurusan)->first();
                                                                    $jadwal = App\Models\Jadwalmapel::where('id', $item->id_jadwal)->first();
                                                                    $pengampu = App\Models\Pengampu::where('id', $jadwal->id_pengampu)->first();
                                                                    $mapel = App\Models\Mapel::where('id', $pengampu->id_mapel)->first();
                                                                    $idseksi = $item->id; // jika $item adalah satu objek
                                                                    $nilaikd3 = App\Models\NilaiKd3::where('id_seksi', $idseksi)->get();
                                                                    $nilaikd4 = App\Models\NilaiKd4::where('id_seksi', $idseksi)->get();
                                                                @endphp
                                                                <tbody>

                                                                    <tr>
                                                                        <td> {{ $kelas->tingkat }} {{ $kelas->nama }}
                                                                            {{ $jurusan->nama }} - {{ $item->id }}
                                                                        </td>
                                                                        <td> {{ $mapel->nama }} </td>
                                                                        <td>
                                                                            @foreach ($nilaikd3 as $nilai)
                                                                                Ph{{ $nilai->ph }},
                                                                            @endforeach
                                                                        </td>
                                                                        <td>
                                                                            @foreach ($nilaikd4 as $nilai)
                                                                                Ph {{ $nilai->ph }},
                                                                            @endforeach
                                                                        </td>
                                                                    </tr>

                                                                </tbody>
                                                            @endforeach

                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- END: FAQ Content -->

                            {{--  // end bagian  guru //  --}}
                        </div>
                    @endif
                </div>
                <!-- END: General Report -->


            </div>
        </div>

    </div>
    </span>

    <div class="mx-6 pb-8 mt-12 ">

        <div class="responsive-mode">
            @foreach ($info as $key => $item)
                <div class="px-2">
                    <div class="intro-y col-span-12 sm:col-span-6 2xl:col-span-4">
                        <div class="box">
                            <div class="p-5">
                                <div
                                    class="h-40 2xl:h-56 image-fit rounded-md overflow-hidden before:block before:absolute before:w-full before:h-full before:top-0 before:left-0 before:z-10 before:bg-gradient-to-t before:from-black before:to-black/10">

                                    <img src="{{ !empty($item->image) ? url('uploads/admin_images/' . $item->image) : url('uploads/no_image.jpg') }}"
                                        class="rounded-md" alt="User Image">

                                    @if ($item->created_at && $item->id === App\Models\Info::latest()->first()->id)
                                        <span
                                            class="absolute top-0 bg-pending/80 text-white text-xs m-5 px-2 py-1 rounded z-10">New</span>
                                    @endif


                                    <div class="absolute bottom-0 text-white px-5 pb-6 z-10">
                                        {{ $item->nama }} </div>
                                </div>
                                <div class="text-slate-600 dark:text-slate-500 mt-5">
                                    <p> {{ $item->ket }} </p> <br>
                                    <span > {{$item->created_at}} </span>
                                </div>
                            </div>
                            @if ($item->link != null)
                                <div
                                    class="flex justify-center lg:justify-end items-center p-5 border-t border-slate-200/60 dark:border-darkmode-400">
                                    <a class="flex items-center text-primary mr-auto" href="{{ $item->link }}"> <i
                                            data-lucide="eye" class="w-4 h-4 mr-1"></i> Preview </a>

                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            @endforeach


        </div>
    </div>
@endsection
