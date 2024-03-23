 @php

     $id = Request::route('id');

     if ($id !== null) {
         $guruedit = URL::route('guru.edit', ['id' => $id]);
         $orangtuaedit = URL::route('orangtua.edit', ['id' => $id]);
         $siswaedit = URL::route('siswa.edit', ['id' => $id]);
         $kelasedit = URL::route('kelas.edit', ['id' => $id]);
         $useredit = URL::route('user.edit', ['id' => $id]);
         $userview = URL::route('user.view', ['id' => $id]);
         $hariedit = URL::route('hari.edit', ['id' => $id]);
         $waktuedit = URL::route('waktu.edit', ['id' => $id]);
         $ruanganedit = URL::route('ruangan.edit', ['id' => $id]);
         $jurusanedit = URL::route('jurusan.edit', ['id' => $id]);
         $mapeledit = URL::route('mapel.edit', ['id' => $id]);
         $pengampuedit = URL::route('pengampu.edit', ['id' => $id]);
         $kelasedit = URL::route('kelas.edit', ['id' => $id]);
         $tahunajaredit = URL::route('tahunajar.edit', ['id' => $id]);
         $walasedit = URL::route('walas.edit', ['id' => $id]);

         $rombeledit = URL::route('rombel.edit', ['id' => $id]);
         $seksiedit = URL::route('seksi.edit', ['id' => $id]);

         $kkmedit = URL::route('kkm.edit', ['id' => $id]);

         $siswaguruwalasedit = URL::route('siswa.walas.edit', ['id' => $id]);

         $nilai = URL::route('nilai.all', ['id' => $id]);
         $nilaii = URL::route('nilai.alll', ['id' => $id]);
         $nilaipengetahuanharian = URL::route('nilai.pengetahuan.harian', ['id' => $id]);
         $nilaipengetahuanakhir = URL::route('nilai.pengetahuan.akhir', ['id' => $id]);

         $nilaiketerampilanportofolio = URL::route('nilai.keterampilan.portofolio', ['id' => $id]);
         $nilaiketerampilanproyek = URL::route('nilai.keterampilan.proyek', ['id' => $id]);
         $nilaiketerampilanunjukkerja = URL::route('nilai.keterampilan.unjukkerja', ['id' => $id]);
     } else {
         $guruedit = 1; // Handle jika parameter id tidak ditemukan dalam URL
         $orangtuaedit = 1;
         $siswaedit = 1;
         $kelasedit = 1;
         $useredit = 1;
         $userview = 1;
         $hariedit = 1;
         $waktuedit = 1;
         $ruanganedit = 1;
         $jurusanedit = 1;
         $mapeledit = 1;
         $pengampuedit = 1;
         $kelasedit = 1;
         $tahunajaredit = 1;
         $walasedit = 1;

         $rombeledit = 1;
         $seksiedit = 1;

         $kkmedit = 1;
         $nilaiketerampilanunjukkerja = 1;
         $siswaguruwalasedit = 1;
         $nilai = 1;
         $nilaii = 1;
         $nilaipengetahuanharian = 1;
         $nilaipengetahuanakhir = 1;
         $nilaiketerampilanportofolio = 1;
         $nilaiketerampilanproyek = 1;
     }

     $url = url()->current();
     $dashboard = URL::route('dashboard');

     $user = URL::route('user.all');
     $useradd = URL::route('user.add');
     $kelas = URL::route('kelas.all');
     $kelasadd = URL::route('kelas.add');
     $siswa = URL::route('siswa.all');
     $siswaadd = URL::route('siswa.add');
     $guru = URL::route('guru.all');
     $guruadd = URL::route('guru.add');
     $orangtua = URL::route('orangtua.all');
     $orangtuaadd = URL::route('orangtua.add');
     $kelas = URL::route('kelas.all');
     $kelasadd = URL::route('kelas.add');
     $waktu = URL::route('waktu.all');
     $waktuadd = URL::route('waktu.add');
     $hari = URL::route('hari.all');
     $hariadd = URL::route('hari.add');
     $ruangan = URL::route('ruangan.all');
     $ruanganadd = URL::route('ruangan.add');
     $jurusan = URL::route('jurusan.all');
     $jurusanadd = URL::route('jurusan.add');
     $mapel = URL::route('mapel.all');
     $mapeladd = URL::route('mapel.add');
     $pengampu = URL::route('pengampu.all');
     $pengampuadd = URL::route('pengampu.add');
     $jadwalmapel = URL::route('jadwalmapel.all');
     $adminprofile = URL::route('admin.profile');
     $editprofile = URL::route('edit.profile');
     $change = URL::route('change.password');
     $jadwalmapelkepsek = URL::route('jadwalmapel.kepsek');
     $jadwalmapelguru = URL::route('jadwalmapel.guru');
     $jadwalmapelsiswa = URL::route('jadwalmapel.siswa');
     $jadwalmapelortu = URL::route('jadwalmapel.ortu');
     $siswaguru = URL::route('siswa.guru');
     $tahunajar = URL::route('tahunajar.all');
     $tahunajaradd = URL::route('tahunajar.add');
     $walas = URL::route('walas.all');
     $walasadd = URL::route('walas.add');

     $siswaguruwalas = URL::route('siswa.guruwalas');

     $rombel = URL::route('rombel.all');
     $rombeladd = URL::route('rombel.add');
     $seksi = URL::route('seksi.all');
     $seksiadd = URL::route('seksi.add');
     $kkm = URL::route('kkm.all');
     $kkmadd = URL::route('kkm.add');
     $presensi = URL::route('presensi.all');
     $catatan = URL::route('catatan.all');

     $prestasi = URL::route('prestasi.all');

     $ekstra = URL::route('ekstra.all');
     $sikap = URL::route('sikap.all');
     $statusnilai = URL::route('status.nilai');
      $raporsiswa = URL::route('rapor.siswa');

 @endphp

 <nav class="side-nav">
     <a href="{{ route('dashboard') }}" class="intro-x flex items-center pl-5 pt-4">
         <img alt="Midone - HTML Admin Template" class="w-16" src="{{ asset('backend/dist/images/man1_copy.png') }}">
         <span class="hidden xl:block text-white text-lg ml-3">MAN 1 Kota Padang</span>
     </a>
     <div class="side-nav__devider my-6"></div>
     <ul>
         <li>
             @if ($url == $dashboard)
                 <a href="{{ route('dashboard') }}" class="side-menu  side-menu--active">
                 @elseif ($adminprofile == $url)
                     <a href="{{ route('dashboard') }}" class="side-menu side-menu--active">
                     @elseif ($editprofile == $url)
                         <a href="{{ route('dashboard') }}" class="side-menu side-menu--active">
                         @elseif ($change == $url)
                             <a href="{{ route('dashboard') }}" class="side-menu side-menu--active">
                             @else
                                 <a href="{{ route('dashboard') }}" class="side-menu ">
             @endif
             <div class="side-menu__icon"> <i data-lucide="home"></i> </div>
             <div class="side-menu__title">
                 Dashboard
             </div>
             </a>

         </li>

         {{--  // bagian  admin //  --}}
         @if (Auth::user()->role == '1')


             <li>
                 @if ($url == $guru)
                     <a href="{{ route('guru.all') }}" class="side-menu  side-menu--active">
                     @elseif ($guruadd == $url)
                         <a href="{{ route('guru.all') }}"class="side-menu side-menu--active">
                         @elseif ($guruedit == $url)
                             <a href="{{ route('guru.all') }}"class="side-menu side-menu--active">
                             @else
                                 <a href="{{ route('guru.all') }}" class="side-menu ">
                 @endif
                 <div class="side-menu__icon"> <i data-lucide="file-text"></i> </div>
                 <div class="side-menu__title">
                     Data Guru
                 </div>
                 </a>

             </li>

             <li>
                 @if ($url == $siswa)
                     <a href="{{ route('siswa.all') }}" class="side-menu  side-menu--active">
                     @elseif ($siswaadd == $url)
                         <a href="{{ route('siswa.all') }}" class="side-menu side-menu--active">
                         @elseif ($siswaedit == $url)
                             <a href="{{ route('siswa.all') }}" class="side-menu side-menu--active">
                             @else
                                 <a href="{{ route('siswa.all') }}" class="side-menu ">
                 @endif
                 <div class="side-menu__icon"> <i data-lucide="file-text"></i> </div>
                 <div class="side-menu__title">
                     Data Siswa
                 </div>
                 </a>

             </li>

             <li>
                 @if ($url == $orangtua)
                     <a href="{{ route('orangtua.all') }}" class="side-menu  side-menu--active">
                     @elseif ($orangtuaadd == $url)
                         <a href="{{ route('orangtua.all') }}" class="side-menu side-menu--active">
                         @elseif ($orangtuaedit == $url)
                             <a href="{{ route('orangtua.all') }}"class="side-menu side-menu--active">
                             @else
                                 <a href="{{ route('orangtua.all') }}" class="side-menu ">
                 @endif
                 <div class="side-menu__icon"> <i data-lucide="file-text"></i> </div>
                 <div class="side-menu__title">
                     Data Orang Tua
                 </div>
                 </a>

             </li>

             <li>
                 @if ($url == $user)
                     <a href="{{ route('user.all') }}" class="side-menu  side-menu--active">
                     @elseif ($useradd == $url)
                         <a href="{{ route('user.all') }}" class="side-menu  side-menu--active">
                         @elseif ($useredit == $url)
                             <a href="{{ route('user.all') }}" class="side-menu side-menu--active">
                             @elseif ($userview == $url)
                                 <a href="{{ route('user.all') }}" class="side-menu side-menu--active">
                                 @else
                                     <a href="{{ route('user.all') }}"class="side-menu ">
                 @endif
                 <div class="side-menu__icon"> <i data-lucide="users"></i> </div>
                 <div class="side-menu__title">
                     Akun Pengguna
                 </div>
                 </a>

             </li>

         @endif
         {{--  // end bagian  admin //  --}}

         {{--  // bagian Kepsek //  --}}
         @if (Auth::user()->role == '2')
             <li>
                 @if ($url == $jadwalmapelkepsek)
                     <a href="{{ route('jadwalmapel.kepsek') }}" class="side-menu  side-menu--active">
                     @else
                         <a href="{{ route('jadwalmapel.kepsek') }}" class="side-menu ">
                 @endif
                 <div class="side-menu__icon"> <i data-lucide="file-text"></i> </div>
                 <div class="side-menu__title">
                     Jadwal Mata Pelajaran
                 </div>
                 </a>

             </li>





         @endif
         {{--  // end bagian kepsek//  --}}


         {{--  // bagian wakil kurikulum //  --}}
         @if (Auth::user()->role == '3')

             <li>
                 @if ($mapel == $url)
                     <a href="javascript:;" class="side-menu side-menu--active">
                     @elseif ($mapeladd == $url)
                         <a href="javascript:;" class="side-menu side-menu--active">
                         @elseif ($mapeledit == $url)
                             <a href="javascript:;" class="side-menu side-menu--active">
                             @elseif ($pengampu == $url)
                                 <a href="javascript:;" class="side-menu side-menu--active">
                                 @elseif ($pengampuadd == $url)
                                     <a href="javascript:;" class="side-menu side-menu--active">
                                     @elseif ($pengampuedit == $url)
                                         <a href="javascript:;" class="side-menu side-menu--active">
                                         @elseif ($jadwalmapel == $url)
                                             <a href="javascript:;" class="side-menu side-menu--active">
                                             @else
                                                 <a href="javascript:;" class="side-menu ">
                 @endif
                 <div class="side-menu__icon"> <i data-lucide="file-text"></i> </div>
                 <div class="side-menu__title">
                     Penjadwalan <br>Mata Pelajaran
                     <div class="side-menu__sub-icon "> <i data-lucide="chevron-down"></i> </div>
                 </div>
                 </a>
                 <ul class="">

                     <li>
                         <a href="{{ route('mapel.all') }}" class="side-menu">
                             <div class="side-menu__icon"> <i data-lucide="file"></i> </div>
                             <div class="side-menu__title">Mata Pelajaran</div>
                         </a>
                     </li>
                     <li>
                         <a href="{{ route('pengampu.all') }}" class="side-menu">
                             <div class="side-menu__icon"> <i data-lucide="users"></i> </div>
                             <div class="side-menu__title">Pengampu Mapel</div>
                         </a>
                     </li>
                     <li>
                         <a href="{{ route('jadwalmapel.all') }}" class="side-menu">
                             <div class="side-menu__icon"> <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                     height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
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
                                 </svg></div>
                             <div class="side-menu__title">Jadwal Mapel</div>
                         </a>
                     </li>
                 </ul>
             </li>


             <li>
                 @if ($url == $walas)
                     <a href="javascript:;" class="side-menu  side-menu--active">
                     @elseif ($url == $walasadd)
                         <a href="javascript:;" class="side-menu  side-menu--active">
                         @elseif ($url == $walasedit)
                             <a href="javascript:;" class="side-menu side-menu--active">
                             @elseif ($url == $rombel)
                                 <a href="javascript:;" class="side-menu  side-menu--active">
                                 @elseif ($url == $rombeladd)
                                     <a href="javascript:;" class="side-menu  side-menu--active">
                                     @elseif ($url == $rombeledit)
                                         <a href="javascript:;" class="side-menu side-menu--active">
                                         @elseif ($url == $seksi)
                                             <a href="javascript:;" class="side-menu  side-menu--active">
                                             @elseif ($url == $seksiadd)
                                                 <a href="javascript:;" class="side-menu  side-menu--active">
                                                 @elseif ($url == $seksiedit)
                                                     <a href="javascript:;" class="side-menu side-menu--active">
                                                     @elseif($tahunajar == $url)
                                                         <a href="javascript:;" class="side-menu  side-menu--active">
                                                         @elseif($tahunajaradd == $url)
                                                             <a href="javascript:;"
                                                                 class="side-menu  side-menu--active">
                                                             @elseif($tahunajaredit == $url)
                                                                 <a href="javascript:;"
                                                                     class="side-menu  side-menu--active">
                                                                 @elseif($kkm == $url)
                                                                     <a href="javascript:;"
                                                                         class="side-menu  side-menu--active">
                                                                     @elseif($kkmadd == $url)
                                                                         <a href="javascript:;"
                                                                             class="side-menu  side-menu--active">
                                                                         @elseif($kkmedit == $url)
                                                                             <a href="javascript:;"
                                                                                 class="side-menu  side-menu--active">
                                                                             @else
                                                                                 <a href="javascript:;"
                                                                                     class="side-menu ">
                 @endif
                 <div class="side-menu__icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                         viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                         stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-square-2">
                         <path d="M18 21a6 6 0 0 0-12 0" />
                         <circle cx="12" cy="11" r="4" />
                         <rect width="18" height="18" x="3" y="3" rx="2" />
                     </svg> </div>
                 <div class="side-menu__title">
                     Akademik
                     <div class="side-menu__sub-icon "> <i data-lucide="chevron-down"></i> </div>
                 </div>
                 </a>
                 <ul class="">
                     <li>
                         <a href="{{ route('tahunajar.all') }}" class="side-menu">
                             <div class="side-menu__icon"> <i data-lucide="file"></i> </div>
                             <div class="side-menu__title"> Tahun Ajar</div>
                         </a>
                     </li>
                     <li>
                         <a href="{{ route('kkm.all') }}" class="side-menu">
                             <div class="side-menu__icon"> <i data-lucide="file"></i> </div>
                             <div class="side-menu__title"> KKM </div>
                         </a>
                     </li>
                     <li>
                         <a href="{{ route('walas.all') }}" class="side-menu">
                             <div class="side-menu__icon"> <i data-lucide="file"></i> </div>
                             <div class="side-menu__title">Set Wali Kelas</div>
                         </a>
                     </li>
                     <li>
                         <a href="{{ route('rombel.all') }}" class="side-menu">
                             <div class="side-menu__icon"> <i data-lucide="users"></i> </div>
                             <div class="side-menu__title">Rombongan Belajar</div>
                         </a>
                     </li>
                     <li>
                         <a href="{{ route('seksi.all') }}" class="side-menu">
                             <div class="side-menu__icon"> <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                     height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                     class="lucide lucide-tag">
                                     <path
                                         d="M12 2H2v10l9.29 9.29c.94.94 2.48.94 3.42 0l6.58-6.58c.94-.94.94-2.48 0-3.42L12 2Z" />
                                     <path d="M7 7h.01" />
                                 </svg></div>
                             <div class="side-menu__title">Seksi</div>
                         </a>
                     </li>
                 </ul>
             </li>

             <li class="side-nav__devider my-4"></li>


             <li>
                 @if ($url == $guru)
                     <a href="{{ route('guru.all') }}" class="side-menu  side-menu--active">
                     @elseif ($guruadd == $url)
                         <a href="{{ route('guru.all') }}"class="side-menu side-menu--active">
                         @elseif ($guruedit == $url)
                             <a href="{{ route('guru.all') }}"class="side-menu side-menu--active">
                             @else
                                 <a href="{{ route('guru.all') }}" class="side-menu ">
                 @endif
                 <div class="side-menu__icon"> <i data-lucide="file-text"></i> </div>
                 <div class="side-menu__title">
                     Data Guru
                 </div>
                 </a>

             </li>

             <li>
                 @if ($url == $siswa)
                     <a href="{{ route('siswa.all') }}" class="side-menu  side-menu--active">
                     @elseif ($siswaadd == $url)
                         <a href="{{ route('siswa.all') }}" class="side-menu side-menu--active">
                         @elseif ($siswaedit == $url)
                             <a href="{{ route('siswa.all') }}" class="side-menu side-menu--active">
                             @else
                                 <a href="{{ route('siswa.all') }}" class="side-menu ">
                 @endif
                 <div class="side-menu__icon"> <i data-lucide="file-text"></i> </div>
                 <div class="side-menu__title">
                     Data Siswa
                 </div>
                 </a>

             </li>

             <li>
                 @if ($url == $orangtua)
                     <a href="{{ route('orangtua.all') }}" class="side-menu  side-menu--active">
                     @elseif ($orangtuaadd == $url)
                         <a href="{{ route('orangtua.all') }}" class="side-menu side-menu--active">
                         @elseif ($orangtuaedit == $url)
                             <a href="{{ route('orangtua.all') }}"class="side-menu side-menu--active">
                             @else
                                 <a href="{{ route('orangtua.all') }}" class="side-menu ">
                 @endif
                 <div class="side-menu__icon"> <i data-lucide="file-text"></i> </div>
                 <div class="side-menu__title">
                     Data Orang Tua
                 </div>
                 </a>

             </li>

             <li>
                 @if ($ruangan == $url)
                     <a href="javascript:;" class="side-menu  side-menu--active">
                     @elseif ($ruanganadd == $url)
                         <a href="javascript:;" class="side-menu  side-menu--active">
                         @elseif ($ruanganedit == $url)
                             <a href="javascript:;" class="side-menu  side-menu--active">
                             @elseif ($jurusan == $url)
                                 <a href="javascript:;" class="side-menu  side-menu--active">
                                 @elseif ($jurusanadd == $url)
                                     <a href="javascript:;" class="side-menu  side-menu--active">
                                     @elseif ($jurusanedit == $url)
                                         <a href="javascript:;" class="side-menu  side-menu--active">
                                         @elseif ($kelas == $url)
                                             <a href="javascript:;" class="side-menu  side-menu--active">
                                             @elseif ($kelasadd == $url)
                                                 <a href="javascript:;" class="side-menu  side-menu--active">
                                                 @elseif ($kelasedit == $url)
                                                     <a href="javascript:;" class="side-menu  side-menu--active">
                                                     @else
                                                         <a href="javascript:;" class="side-menu side-menu">
                 @endif

                 <div class="side-menu__icon">
                     <i data-lucide="home"></i>
                 </div>
                 <div class="side-menu__title">
                     Data Ruangan
                     <div class="side-menu__sub-icon "> <i data-lucide="chevron-down"></i> </div>
                 </div>
                 </a>
                 <ul class="">
                     <li>
                         <a href="{{ route('ruangan.all') }}" class="side-menu">
                             <div class="side-menu__icon"> <i data-lucide="file"></i></div>
                             <div class="side-menu__title"> Ruangan</div>
                         </a>
                     </li>
                     <li>
                         <a href="{{ route('kelas.all') }}" class="side-menu">
                             <div class="side-menu__icon"> <i data-lucide="file"></i> </div>
                             <div class="side-menu__title"> Kelas</div>
                         </a>
                     </li>
                     <li>
                         <a href="{{ route('jurusan.all') }}" class="side-menu">
                             <div class="side-menu__icon"> <i data-lucide="file"></i> </div>
                             <div class="side-menu__title"> Jurusan</div>
                         </a>
                     </li>

                 </ul>
             </li>

             <li>

                 @if ($hari == $url)
                     <a href="javascript:;" class="side-menu side-menu--active">
                     @elseif($hariedit == $url)
                         <a href="javascript:;" class="side-menu side-menu--active">
                         @elseif($hariadd == $url)
                             <a href="javascript:;" class="side-menu side-menu--active">
                             @elseif($waktu == $url)
                                 <a href="javascript:;" class="side-menu side-menu--active">
                                 @elseif($waktuadd == $url)
                                     <a href="javascript:;" class="side-menu side-menu--active">
                                     @elseif($waktuedit == $url)
                                         <a href="javascript:;" class="side-menu side-menu--active">
                                         @else
                                             <a href="javascript:;" class="side-menu side-menu">
                 @endif


                 <div class="side-menu__icon">
                     <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                         stroke-linejoin="round" class="lucide lucide-calendar-clock">
                         <path d="M21 7.5V6a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h3.5" />
                         <path d="M16 2v4" />
                         <path d="M8 2v4" />
                         <path d="M3 10h5" />
                         <path d="M17.5 17.5 16 16.25V14" />
                         <path d="M22 16a6 6 0 1 1-12 0 6 6 0 0 1 12 0Z" />
                     </svg>
                 </div>
                 <div class="side-menu__title">
                     Data Waktu
                     <div class="side-menu__sub-icon "> <i data-lucide="chevron-down"></i> </div>
                 </div>
                 </a>
                 <ul class="">
                     <li>
                         <a href="{{ route('waktu.all') }}" class="side-menu">
                             <div class="side-menu__icon"> <i data-lucide="clock"></i> </div>
                             <div class="side-menu__title"> Waktu</div>
                         </a>
                     </li>
                     <li>
                         <a href="{{ route('hari.all') }}" class="side-menu">
                             <div class="side-menu__icon"> <i data-lucide="calendar"></i> </div>
                             <div class="side-menu__title"> Hari</div>
                         </a>
                     </li>
                 </ul>
             </li>
         @endif
         {{--  // end bagian wakil kurikulum //  --}}

         @php
             use Carbon\Carbon;
         @endphp



         {{--  // bagian Guru  //  --}}
         @if (Auth::user()->role == '4')
             <li>
                 @if ($url == $jadwalmapelguru)
                     <a href="{{ route('jadwalmapel.guru') }}" class="side-menu side-menu--active">
                     @else
                         <a href="{{ route('jadwalmapel.guru') }}" class="side-menu">
                 @endif
                 <div class="side-menu__icon"> <i data-lucide="file-text"></i> </div>
                 <div class="side-menu__title">
                     Jadwal Mata Pelajaran
                 </div>
                 </a>
             </li>

             @php

                 $tanggalSaatIni = Carbon::now();

                 // Mendapatkan semester saat ini berdasarkan bulan
                 $semesterSaatIni = $tanggalSaatIni->month >= 1 && $tanggalSaatIni->month <= 6 ? 'Genap' : 'Ganjil';

                 // Mendapatkan tahun saat ini
                 $tahunSaatIni = $tanggalSaatIni->format('Y');

                 // Mendapatkan data tahun ajar yang sesuai dengan tahun dan semester saat ini
                 $tahunAjarSaatIni = App\Models\Tahunajar::where('tahun', 'like', '%' . $tahunSaatIni . '%')
                     ->where('semester', $semesterSaatIni)
                     ->first();
                 $userId = Auth::user()->id;
                 $seksi = App\Models\Seksi::join('jadwalmapels', 'jadwalmapels.id', '=', 'seksis.id_jadwal')
                     ->join('pengampus', 'pengampus.id', '=', 'jadwalmapels.id_pengampu')
                     ->join('gurus', 'gurus.id', '=', 'pengampus.id_guru')

                     ->where('seksis.semester', $tahunAjarSaatIni->id)
                     ->where('gurus.id_user', '=', $userId)
                     ->select('seksis.*') // Memilih semua kolom dari tabel catata_walas
                     ->get();

             @endphp

             <li>


                 @if ($nilai == $url)
                     <a href="javascript:;" class="side-menu side-menu--active">
                     @elseif ($nilaii == $url)
                         <a href="javascript:;" class="side-menu side-menu--active">
                         @elseif ($nilaipengetahuanharian == $url)
                             <a href="javascript:;" class="side-menu side-menu--active">
                             @elseif ($nilaipengetahuanakhir == $url)
                                 <a href="javascript:;" class="side-menu side-menu--active">
                                 @elseif ($nilaiketerampilanportofolio == $url)
                                     <a href="javascript:;" class="side-menu side-menu--active">
                                     @elseif ($nilaiketerampilanproyek == $url)
                                         <a href="javascript:;" class="side-menu side-menu--active">
                                         @elseif ($nilaiketerampilanunjukkerja == $url)
                                             <a href="javascript:;" class="side-menu side-menu--active">
                                             @else
                                                 <a href="javascript:;" class="side-menu side-menu">
                 @endif

                 <div class="side-menu__icon"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                         viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                         stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-square-2">
                         <path d="M18 21a6 6 0 0 0-12 0" />
                         <circle cx="12" cy="11" r="4" />
                         <rect width="18" height="18" x="3" y="3" rx="2" />
                     </svg> </div>
                 <div class="side-menu__title">
                     Penilaian Anda
                     <div class="side-menu__sub-icon "> <i data-lucide="chevron-down"></i> </div>
                 </div>
                 </a>
                 <ul class="">
                     @foreach ($seksi as $item)
                         <li>
                             <a href="{{ route('nilai.all', $item->id) }}" class="side-menu">
                                 <div class="side-menu__icon"> <i data-lucide="file"></i> </div>
                                 <div class="side-menu__title"> {{ $item->jadwalmapels->pengampus->mapels->nama }} -
                                     {{ $item->jadwalmapels->pengampus->kelass->tingkat }}
                                     {{ $item->jadwalmapels->pengampus->kelass->nama }}
                                     {{ $item->jadwalmapels->pengampus->kelass->jurusans->nama }} </div>
                             </a>


                         </li>
                     @endforeach



                 </ul>
             </li>



             <li class="side-nav__devider my-4"></li>

             @php
                 $userId1 = Auth::user()->id;
                 $guru1 = App\Models\Guru::where('id_user', $userId1)->first();

                 if ($guru1) {
                     $walas = App\Models\Walas::where('id_guru', $guru1->id)->first();

                     if ($walas) {
                         $rombel = App\Models\Rombel::where('id_walas', $walas->id)->first();

                         // Lanjutkan dengan penggunaan $rombel...
                     } else {
                         // Handle kasus ketika $walas null
                     }
                 } else {
                     // Handle kasus ketika $guru1 null
                 }
             @endphp


             @if ($rombel)

                 <li>

                     @if ($siswaguruwalas == $url)
                         <a href="javascript:;" class="side-menu side-menu--active">
                         @elseif ($siswaguruwalasedit == $url)
                             <a href="javascript:;" class="side-menu side-menu--active">
                             @elseif ($presensi == $url)
                                 <a href="javascript:;" class="side-menu side-menu--active">
                                 @elseif ($catatan == $url)
                                     <a href="javascript:;" class="side-menu side-menu--active">
                                     @elseif ($prestasi == $url)
                                         <a href="javascript:;" class="side-menu side-menu--active">
                                         @elseif ($ekstra == $url)
                                             <a href="javascript:;" class="side-menu side-menu--active">
                                             @elseif ($sikap == $url)
                                                 <a href="javascript:;" class="side-menu side-menu--active">
                                                 @elseif ($statusnilai == $url)
                                                     <a href="javascript:;" class="side-menu side-menu--active">
                                                     @elseif ($raporsiswa == $url)
                                                         <a href="javascript:;" class="side-menu side-menu--active">
                                                         @else
                                                             <a href="javascript:;" class="side-menu ">
                     @endif
                     <div class="side-menu__icon"> <svg xmlns="http://www.w3.org/2000/svg" width="24"
                             height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                             stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                             class="lucide lucide-user-square-2">
                             <path d="M18 21a6 6 0 0 0-12 0" />
                             <circle cx="12" cy="11" r="4" />
                             <rect width="18" height="18" x="3" y="3" rx="2" />
                         </svg> </div>
                     <div class="side-menu__title">
                         Wali Kelas
                         <div class="side-menu__sub-icon "> <i data-lucide="chevron-down"></i> </div>
                     </div>
                     </a>
                     <ul class="">
                         <li>
                             <a href="{{ route('siswa.guruwalas') }}" class="side-menu">
                                 <div class="side-menu__icon"> <i data-lucide="file"></i> </div>
                                 <div class="side-menu__title">Data Siswa</div>
                             </a>
                         </li>

                         <li>
                             <a href="{{ route('presensi.all') }}" class="side-menu">
                                 <div class="side-menu__icon"> <i data-lucide="file"></i> </div>
                                 <div class="side-menu__title">Presensi siswa</div>
                             </a>
                         </li>

                         <li>
                             <a href="{{ route('catatan.all') }}" class="side-menu">
                                 <div class="side-menu__icon"> <i data-lucide="file"></i> </div>
                                 <div class="side-menu__title">Catatan Wali Kelas</div>
                             </a>
                         </li>

                         <li>
                             <a href="{{ route('sikap.all') }}" class="side-menu">
                                 <div class="side-menu__icon"> <i data-lucide="file"></i> </div>
                                 <div class="side-menu__title">Nilai Sikap</div>
                             </a>
                         </li>
                         <li>
                             <a href="{{ route('prestasi.all') }}" class="side-menu">
                                 <div class="side-menu__icon"> <i data-lucide="file"></i> </div>
                                 <div class="side-menu__title">Prestasi</div>
                             </a>
                         </li>
                         <li>
                             <a href="{{ route('ekstra.all') }}" class="side-menu">
                                 <div class="side-menu__icon"> <i data-lucide="file"></i> </div>
                                 <div class="side-menu__title">Ekstrakulikuler</div>
                             </a>
                         </li>
                         <li>
                             <a href="{{ route('status.nilai') }}" class="side-menu">
                                 <div class="side-menu__icon"> <i data-lucide="file"></i> </div>
                                 <div class="side-menu__title">Status Nilai</div>
                             </a>
                         </li>
                         <li>
                             <a href="{{ route('rapor.siswa') }}" class="side-menu">
                                 <div class="side-menu__icon"> <i data-lucide="file"></i> </div>
                                 <div class="side-menu__title">Rapor </div>
                             </a>
                         </li>


                     </ul>
                 </li>
             @endif
             {{--  
             <li>
                 @if ($url == $a)
                     <a href="{{ route('messages.index') }}" class="side-menu  side-menu--active">
                     @elseif ($url == $routes)
                         <a href="{{ route('messages.index') }}" class="side-menu  side-menu--active">
                         @else
                             <a href="{{ route('messages.index') }}" class="side-menu ">
                 @endif
                 <div class="side-menu__icon"> <i data-lucide="message-square"></i> </div>
                 <div class="side-menu__title">
                     Pesan
                 </div>
                 </a>

             </li>  --}}



             {{--  // end bagian guru //  --}}
         @endif






         {{--  // bagian  Siswa//  --}}
         @if (Auth::user()->role == '6')

             <li>
                 @if ($url == $jadwalmapelsiswa)
                     <a href="{{ route('jadwalmapel.siswa') }}" class="side-menu  side-menu--active">
                     @else
                         <a href="{{ route('jadwalmapel.siswa') }}" class="side-menu ">
                 @endif
                 <div class="side-menu__icon"> <i data-lucide="file-text"></i> </div>
                 <div class="side-menu__title">
                     Jadwal Mata Pelajaran
                 </div>
                 </a>

             </li>





         @endif
         {{--  // end bagian Siswa//  --}}


         {{--  // bagian  Orang tua//  --}}
         @if (Auth::user()->role == '5')

             <li>
                 @if ($url == $jadwalmapelortu)
                     <a href="{{ route('jadwalmapel.ortu') }}" class="side-menu  side-menu--active">
                     @else
                         <a href="{{ route('jadwalmapel.ortu') }}" class="side-menu ">
                 @endif
                 <div class="side-menu__icon"> <i data-lucide="file-text"></i> </div>
                 <div class="side-menu__title">
                     Jadwal Mata Pelajaran
                 </div>
                 </a>

             </li>





         @endif
         {{--  // end bagian Siswa//  --}}
     </ul>

 </nav>
