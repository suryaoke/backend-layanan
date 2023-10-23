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
         $ekstraedit = URL::route('ekstra.edit', ['id' => $id]);
         $ekstranilaiedit = URL::route('ekstranilai.edit', ['id' => $id]);
         $ekstranilaiview = URL::route('ekstranilai.view', ['id' => $id]);
         $rombeledit = URL::route('rombel.edit', ['id' => $id]);
         $seksiedit = URL::route('seksi.edit', ['id' => $id]);
         $sk = URL::route('sk.all', ['id' => $id]);
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
         $ekstraedit = 1;
         $ekstranilaiedit = 1;
         $ekstranilaiview = 1;
         $rombeledit = 1;
         $seksiedit = 1;
         $sk = 1;
     }

     $url = url()->current();
     $dashboard = URL::route('dashboard');
     $absensi = URL::route('absensi.all');
     $absensiadd = URL::route('absensi.add');
     $absensisiswa = URL::route('absensi.siswa');
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
     $siswaguru = URL::route('siswa.guru');
     $tahunajar = URL::route('tahunajar.all');
     $tahunajaradd = URL::route('tahunajar.add');
     $walas = URL::route('walas.all');
     $walasadd = URL::route('walas.add');
     $ekstra = URL::route('ekstra.all');
     $ekstraadd = URL::route('ekstra.add');
     $ekstranilai = URL::route('ekstranilai.all');
     $ekstranilaiadd = URL::route('ekstranilai.add');
     $siswaguruwalas = URL::route('siswa.guruwalas');
     $cttnwalas = URL::route('cttnwalas.all');
     $absensisiswaguruwalas = URL::route('absensi.siswaguruwalas');
     $nilaisosial = URL::route('nilaisosial.all');
     $nilaispiritual = URL::route('nilaispiritual.all');
     $nilaiprestasi = URL::route('nilaiprestasi.all');
     $rombel = URL::route('rombel.all');
     $rombeladd = URL::route('rombel.add');
     $seksi = URL::route('seksi.all');
     $seksiadd = URL::route('seksi.add');

     $routes = [
         'pusherAuth' => URL::route('pusher.auth'),
         'messagesIndex' => URL::route('messages.index'),
         'idFetchData' => URL::route('messages.idFetchData'),
         'download' => URL::route('messages.download', ['fileName' => 'example-file.pdf']), // Ganti 'example-file.pdf' dengan nama file yang benar
         'send' => URL::route('messages.send'),
         'fetch' => URL::route('messages.fetch'),
         'seen' => URL::route('messages.seen'),
         'getContacts' => URL::route('messages.getContacts'),
         'updateContactItem' => URL::route('messages.updateContactItem'),
         'favorite' => URL::route('messages.favorite'),
         'getFavorites' => URL::route('messages.getFavorites'),
         'search' => URL::route('messages.search'),
         'sharedPhotos' => URL::route('messages.sharedPhotos'),
         'deleteConversation' => URL::route('messages.deleteConversation'),
         'deleteMessage' => URL::route('messages.deleteMessage'),
         'updateSettings' => URL::route('messages.updateSettings'),
         'setActiveStatus' => URL::route('messages.setActiveStatus'),
     ];
     $a = URL::route('messages.index');

 @endphp

 <nav class="side-nav">
     <a href="{{ route('dashboard') }}" class="intro-x flex items-center pl-5 pt-4">
         <img alt="Midone - HTML Admin Template" class="w-12" src="{{ asset('backend/dist/images/man1_copy.png') }}">
         <span class="hidden xl:block text-white text-lg ml-3">SIAKAD MAN 1 Kota Padang</span>
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
                 @if ($user == $url)
                     <a href="javascript:;" class="side-menu side-menu--active">
                     @elseif ($useradd == $url)
                         <a href="javascript:;" class="side-menu side-menu--active">
                         @elseif ($useredit == $url)
                             <a href="javascript:;" class="side-menu side-menu--active">
                             @elseif ($userview == $url)
                                 <a href="javascript:;" class="side-menu side-menu--active">
                                 @elseif ($siswa == $url)
                                     <a href="javascript:;" class="side-menu side-menu--active">
                                     @elseif ($siswaadd == $url)
                                         <a href="javascript:;" class="side-menu side-menu--active">
                                         @elseif ($siswaedit == $url)
                                             <a href="javascript:;" class="side-menu side-menu--active">
                                             @elseif ($guru == $url)
                                                 <a href="javascript:;" class="side-menu side-menu--active">
                                                 @elseif ($guruadd == $url)
                                                     <a href="javascript:;" class="side-menu side-menu--active">
                                                     @elseif ($guruedit == $url)
                                                         <a href="javascript:;"class="side-menu side-menu--active">
                                                         @elseif ($orangtua == $url)
                                                             <a href="javascript:;" class="side-menu side-menu--active">
                                                             @elseif ($orangtuaadd == $url)
                                                                 <a href="javascript:;"
                                                                     class="side-menu side-menu--active">
                                                                 @elseif ($orangtuaedit == $url)
                                                                     <a
                                                                         href="javascript:;"class="side-menu side-menu--active">
                                                                     @else
                                                                         <a href="javascript:;" class="side-menu ">
                 @endif
                 <div class="side-menu__icon"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                         viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                         stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-cog">
                         <circle cx="18" cy="15" r="3" />
                         <circle cx="9" cy="7" r="4" />
                         <path d="M10 15H6a4 4 0 0 0-4 4v2" />
                         <path d="m21.7 16.4-.9-.3" />
                         <path d="m15.2 13.9-.9-.3" />
                         <path d="m16.6 18.7.3-.9" />
                         <path d="m19.1 12.2.3-.9" />
                         <path d="m19.6 18.7-.4-1" />
                         <path d="m16.8 12.3-.4-1" />
                         <path d="m14.3 16.6 1-.4" />
                         <path d="m20.7 13.8 1-.4" />
                     </svg></div>
                 <div class="side-menu__title">
                     MASTER USER
                     <div class="side-menu__sub-icon "> <i data-lucide="chevron-down"></i> </div>
                 </div>
                 </a>
                 <ul class="">
                     <li>
                         <a href="{{ route('user.all') }}" class="side-menu">
                             <div class="side-menu__icon"> <i data-lucide="user"></i> </div>
                             <div class="side-menu__title"> Akun User </div>
                         </a>
                     </li>
                     <li>
                         <a href="{{ route('guru.all') }}" class="side-menu">
                             <div class="side-menu__icon"> <i data-lucide="user"></i> </div>
                             <div class="side-menu__title"> Guru </div>
                         </a>
                     </li>
                     <li>
                         <a href="{{ route('orangtua.all') }}" class="side-menu">
                             <div class="side-menu__icon"> <i data-lucide="user"></i> </div>
                             <div class="side-menu__title"> Orang Tua </div>
                         </a>
                     </li>
                     <li>
                         <a href="{{ route('siswa.all') }}" class="side-menu">
                             <div class="side-menu__icon"> <i data-lucide="user"></i> </div>
                             <div class="side-menu__title"> Siswa </div>
                         </a>
                     </li>

                 </ul>
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

             </li>

         @endif
         {{--  // end bagian kepsek//  --}}


         {{--  // bagian operator //  --}}
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
                     Penjadwalan
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
                                                     @else
                                                         <a href="javascript:;" class="side-menu ">
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





             <li>
                 @if ($ekstra == $url)
                     <a href="javascript:;" class="side-menu side-menu--active">
                     @elseif ($ekstraadd == $url)
                         <a href="javascript:;" class="side-menu side-menu--active">
                         @elseif ($ekstraedit == $url)
                             <a href="javascript:;" class="side-menu side-menu--active">
                             @elseif ($ekstranilaiview == $url)
                                 <a href="javascript:;" class="side-menu side-menu--active">
                                 @else
                                     <a href="javascript:;" class="side-menu side-menu">
                 @endif

                 <div class="side-menu__icon">
                     <i data-lucide="book"></i>
                 </div>
                 <div class="side-menu__title">
                     Rapor
                     <div class="side-menu__sub-icon "> <i data-lucide="chevron-down"></i> </div>
                 </div>
                 </a>
                 <ul class="">
                     <li>
                         <a href="{{ route('ekstra.all') }}" class="side-menu">
                             <div class="side-menu__icon"> <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                     height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                     class="lucide lucide-gauge-circle">
                                     <path d="M15.6 2.7a10 10 0 1 0 5.7 5.7" />
                                     <circle cx="12" cy="12" r="2" />
                                     <path d="M13.4 10.6 19 5" />
                                 </svg></div>
                             <div class="side-menu__title"> Ekstrakurikuler</div>
                         </a>
                     </li>
                     <li>
                         <a href="{{ route('hari.all') }}" class="side-menu">
                             <div class="side-menu__icon"> <i data-lucide="file"></i> </div>
                             <div class="side-menu__title"> KKM Tingkat</div>
                         </a>
                     </li>
                 </ul>
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
                                                     @elseif ($guru == $url)
                                                         <a href="javascript:;" class="side-menu side-menu--active">
                                                         @elseif ($guruadd == $url)
                                                             <a href="javascript:;"
                                                                 class="side-menu side-menu--active">
                                                             @elseif ($guruedit == $url)
                                                                 <a
                                                                     href="javascript:;"class="side-menu side-menu--active">
                                                                 @elseif($tahunajar == $url)
                                                                     <a href="javascript:;"
                                                                         class="side-menu  side-menu--active">
                                                                     @elseif($tahunajaradd == $url)
                                                                         <a href="javascript:;"
                                                                             class="side-menu  side-menu--active">
                                                                         @elseif($tahunajaredit == $url)
                                                                             <a href="javascript:;"
                                                                                 class="side-menu  side-menu--active">
                                                                             @elseif ($hari == $url)
                                                                                 <a href="javascript:;"
                                                                                     class="side-menu side-menu--active">
                                                                                 @elseif($hariedit == $url)
                                                                                     <a href="javascript:;"
                                                                                         class="side-menu side-menu--active">
                                                                                     @elseif($hariadd == $url)
                                                                                         <a href="javascript:;"
                                                                                             class="side-menu side-menu--active">
                                                                                         @elseif($waktu == $url)
                                                                                             <a href="javascript:;"
                                                                                                 class="side-menu side-menu--active">
                                                                                             @elseif($waktuadd == $url)
                                                                                                 <a href="javascript:;"
                                                                                                     class="side-menu side-menu--active">
                                                                                                 @elseif($waktuedit == $url)
                                                                                                     <a href="javascript:;"
                                                                                                         class="side-menu side-menu--active">
                                                                                                     @else
                                                                                                         <a href="javascript:;"
                                                                                                             class="side-menu side-menu">
                 @endif

                 <div class="side-menu__icon">
                     <i data-lucide="database"></i>
                 </div>
                 <div class="side-menu__title">
                     Master Data
                     <div class="side-menu__sub-icon "> <i data-lucide="chevron-down"></i> </div>
                 </div>
                 </a>
                 <ul class="">
                     <li>
                         <a href="{{ route('tahunajar.all') }}" class="side-menu">
                             <div class="side-menu__icon"> <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                     height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                     class="lucide lucide-tag">
                                     <path
                                         d="M12 2H2v10l9.29 9.29c.94.94 2.48.94 3.42 0l6.58-6.58c.94-.94.94-2.48 0-3.42L12 2Z" />
                                     <path d="M7 7h.01" />
                                 </svg> </div>
                             <div class="side-menu__title"> Tahun Ajar</div>
                         </a>
                     </li>
                     <li>
                         <a href="{{ route('guru.all') }}" class="side-menu">
                             <div class="side-menu__icon"> <i data-lucide="user"></i> </div>
                             <div class="side-menu__title"> Guru</div>
                         </a>
                     </li>
                     <li>
                         <a href="{{ route('siswa.all') }}" class="side-menu">
                             <div class="side-menu__icon"> <i data-lucide="user"></i> </div>
                             <div class="side-menu__title"> Siswa</div>
                         </a>
                     </li>
                     <li>
                         <a href="{{ route('orangtua.all') }}" class="side-menu">
                             <div class="side-menu__icon"> <i data-lucide="user"></i> </div>
                             <div class="side-menu__title"> Orang Tua</div>
                         </a>
                     </li>



                     <li>
                         <a href="javascript:;" class="side-menu side-menu">

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

                         <a href="javascript:;" class="side-menu side-menu">


                             <div class="side-menu__icon">
                                 <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                     viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                     stroke-linecap="round" stroke-linejoin="round"
                                     class="lucide lucide-calendar-clock">
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
                 </ul>
             </li>

         @endif
         {{--  // end bagian operator //  --}}





         {{--  // bagian Guru  //  --}}
         @if (Auth::user()->role == '4')
             <li>
                 @if ($url == $jadwalmapelguru)
                     <a href="{{ route('jadwalmapel.guru') }}" class="side-menu  side-menu--active">
                     @else
                         <a href="{{ route('jadwalmapel.guru') }}" class="side-menu ">
                 @endif
                 <div class="side-menu__icon"> <i data-lucide="file-text"></i> </div>
                 <div class="side-menu__title">
                     Jadwal Mata Pelajaran
                 </div>
                 </a>

             </li>

             <li>
                 @if ($url == $absensi)
                     <a href="{{ route('absensi.all') }}" class="side-menu  side-menu--active">
                     @elseif ($url == $absensiadd)
                         <a href="{{ route('absensi.all') }}" class="side-menu  side-menu--active">
                         @elseif ($url == $absensisiswa)
                             <a href="{{ route('absensi.all') }}" class="side-menu  side-menu--active">
                             @else
                                 <a href="{{ route('absensi.all') }}" class="side-menu ">
                 @endif
                 <div class="side-menu__icon"> <i data-lucide="user-check"></i> </div>
                 <div class="side-menu__title">
                     Absensi Siswa
                 </div>
                 </a>

             </li>

             <li>
                 @if ($url == $sk)
                     <a href="javascript:;" class="side-menu side-menu--active">
                     @else
                         <a href="javascript:;" class="side-menu ">
                 @endif
                 <div class="side-menu__icon"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                         viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                         stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-file-spreadsheet">
                         <path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z" />
                         <polyline points="14 2 14 8 20 8" />
                         <path d="M8 13h2" />
                         <path d="M8 17h2" />
                         <path d="M14 13h2" />
                         <path d="M14 17h2" />
                     </svg></div>
                 <div class="side-menu__title">
                     SK (KI/KD)
                     <div class="side-menu__sub-icon "> <i data-lucide="chevron-down"></i> </div>
                 </div>
                 </a>
                 @php
                     $userId = Auth::user()->id;
                     $guru = App\Models\Guru::where('id_user', $userId)->first(); // Mengambil data guru berdasarkan id_user
                     $seksi = [];
                     if ($guru) {
                         $pengampu = App\Models\Pengampu::where('id_guru', $guru->id)->get(); // Mengambil data pengampu berdasarkan id_guru dengan kondisi id_mapel yang unik

                         $pengampuIds = $pengampu->pluck('id')->toArray(); // Mengambil array dari ID pengampu yang terkait
                         $jadwalguru = App\Models\Jadwalmapel::whereIn('id_pengampu', $pengampuIds)->get(); // Mengambil jadwal mapel berdasarkan id_pengampu yang terkait

                         $jadwalguruIds = $jadwalguru->pluck('id')->toArray(); // Ambil array ID dari koleksi $jadwalguru
                         $seksi = App\Models\Seksi::whereIn('id_jadwal', $jadwalguruIds)->get();

                         $jadwalguru2 = App\Models\Jadwalmapel::whereIn('id', $seksi->pluck('id_jadwal')->toArray())->get();
                         $pengampu2 = App\Models\Pengampu::whereIn('id', $jadwalguru2->pluck('id_pengampu')->toArray())->get();
                     }
                     $uniqueRecords = [];
                     $filteredPengampu2 = collect();
                     foreach ($pengampu2 as $item) {
                         $kelas = App\Models\Kelas::where('id', $item->kelas)->first();
                         $key = $item->id_mapel . '-' . $kelas->tingkat; // Menggunakan ID Mapel dan Tingkat sebagai kunci

                         if (!in_array($key, $uniqueRecords)) {
                             $filteredPengampu2->push($item);
                             $uniqueRecords[] = $key;
                         }
                     }
                 @endphp
                 <ul class="">
                     @foreach ($filteredPengampu2 as $item)
                         @php
                             $mapel1 = App\Models\Mapel::where('id', $item->id_mapel)->first();
                             $kelas1 = App\Models\Kelas::where('id', $item->kelas)->first();
                             $jadwal2 = App\Models\Jadwalmapel::where('id_pengampu', $item->id)->first();
                             $seksi2 = App\Models\Seksi::where('id_jadwal', $jadwal2->id)->first();

                         @endphp
                         <li>
                             <a href="{{ route('sk.all', $seksi2->id) }}" class="side-menu">
                                 <div class="side-menu__icon"> <i data-lucide="file"></i> </div>
                                 <div class="side-menu__title"> {{ $mapel1->nama }} : {{ $kelas1->tingkat }}
                                     {{ $seksi2->id }} </div>
                             </a>
                         </li>
                     @endforeach
                 </ul>


             </li>


             <li>

                 <a href="javascript:;" class="side-menu ">

                     <div class="side-menu__icon"> <svg xmlns="http://www.w3.org/2000/svg" width="24"
                             height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                             stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                             class="lucide lucide-user-square-2">
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
                     @php
                         $userId = Auth::user()->id;
                         $guru = App\Models\Guru::where('id_user', $userId)->first(); // Mengambil data guru berdasarkan id_user
                         if ($guru) {
                             $pengampu = App\Models\Pengampu::where('id_guru', $guru->id)->get(); // Mengambil data pengampu berdasarkan id_guru
                             $pengampuIds = $pengampu->pluck('id')->toArray(); // Mengambil array dari ID pengampu yang terkait

                             $jadwalguru = App\Models\Jadwalmapel::whereIn('id_pengampu', $pengampuIds)->get(); // Mengambil jadwal mapel berdasarkan id_pengampu yang terkait
                         } else {
                             // Lakukan sesuatu jika data guru tidak ditemukan
                         }
                     @endphp
                     @foreach ($jadwalguru as $item)
                         @php
                             $pengampus = App\Models\Pengampu::where('id', $item->id_pengampu)->first();
                             $mapels = App\Models\Mapel::where('id', $pengampus->id_mapel)->first();
                             $kelas = App\Models\Kelas::where('id', $pengampus->kelas)->first();
                             $jurusan = App\Models\Jurusan::where('id', $kelas->id_jurusan)->first();
                         @endphp
                         <li>
                             <a href="{{ route('siswa.guruwalas') }}" class="side-menu">
                                 <div class="side-menu__icon"> <i data-lucide="file"></i> </div>
                                 <div class="side-menu__title">{{ $mapels->nama }}:
                                     {{ $kelas->tingkat }}{{ $kelas->nama }} {{ $jurusan->nama }} </div>
                             </a>
                         </li>
                     @endforeach

                 </ul>
             </li>


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

             </li>

             <li class="side-nav__devider my-4"></li>

             <li>
                 @if ($cttnwalas == $url)
                     <a href="javascript:;" class="side-menu side-menu--active">
                     @elseif ($siswaguruwalas == $url)
                         <a href="javascript:;" class="side-menu side-menu--active">
                         @elseif($absensisiswaguruwalas == $url)
                             <a href="javascript:;" class="side-menu side-menu--active">
                             @elseif($nilaisosial == $url)
                                 <a href="javascript:;" class="side-menu side-menu--active">
                                 @elseif($nilaispiritual == $url)
                                     <a href="javascript:;" class="side-menu side-menu--active">
                                     @elseif($nilaiprestasi == $url)
                                         <a href="javascript:;" class="side-menu side-menu--active">
                                         @else
                                             <a href="javascript:;" class="side-menu ">
                 @endif
                 <div class="side-menu__icon"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                         viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                         stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-square-2">
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
                             <div class="side-menu__title">Siswa</div>
                         </a>
                     </li>
                     <li>
                         <a href="{{ route('absensi.siswaguruwalas') }}" class="side-menu">
                             <div class="side-menu__icon"> <i data-lucide="file"></i> </div>
                             <div class="side-menu__title">Absensi Siswa</div>
                         </a>
                     </li>
                     <li>
                         <a href="{{ route('cttnwalas.all') }}" class="side-menu">
                             <div class="side-menu__icon"> <i data-lucide="file"></i> </div>
                             <div class="side-menu__title">Catatan Walas</div>
                         </a>
                     </li>
                     <li>
                         <a href="{{ route('nilaisosial.all') }}" class="side-menu">
                             <div class="side-menu__icon"> <i data-lucide="file"></i> </div>
                             <div class="side-menu__title">Sikap Sosial</div>
                         </a>
                     </li>
                     <li>
                         <a href="{{ route('nilaispiritual.all') }}" class="side-menu">
                             <div class="side-menu__icon"> <i data-lucide="file"></i> </div>
                             <div class="side-menu__title">Sikap Spiritual</div>
                         </a>
                     </li>
                     <li>
                         <a href="{{ route('nilaiprestasi.all') }}" class="side-menu">
                             <div class="side-menu__icon"> <i data-lucide="file"></i> </div>
                             <div class="side-menu__title">Prestasi</div>
                         </a>
                     </li>
                     <li>
                         <a href="{{ route('siswa.guru') }}" class="side-menu">
                             <div class="side-menu__icon"> <i data-lucide="file"></i> </div>
                             <div class="side-menu__title">Status Nilai</div>
                         </a>
                     </li>
                     <li>
                         <a href="{{ route('siswa.guru') }}" class="side-menu">
                             <div class="side-menu__icon"> <i data-lucide="file"></i> </div>
                             <div class="side-menu__title">Rapor</div>
                         </a>
                     </li>
                 </ul>
             </li>


             <li>
                 @if ($url == $ekstranilai)
                     <a href="{{ route('ekstranilai.all') }}" class="side-menu  side-menu--active">
                     @elseif ($url == $ekstranilaiadd)
                         <a href="{{ route('ekstranilai.all') }}" class="side-menu  side-menu--active">
                         @elseif ($url == $ekstranilaiedit)
                             <a href="{{ route('ekstranilai.all') }}" class="side-menu  side-menu--active">
                             @else
                                 <a href="{{ route('ekstranilai.all') }}" class="side-menu ">
                 @endif
                 <div class="side-menu__icon"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                         viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                         stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-gauge-circle">
                         <path d="M15.6 2.7a10 10 0 1 0 5.7 5.7" />
                         <circle cx="12" cy="12" r="2" />
                         <path d="M13.4 10.6 19 5" />
                     </svg></div>
                 <div class="side-menu__title"> Ekstrakurikuler</div>
                 </a>
             </li>



             {{--  // end bagian guru //  --}}
         @endif








         {{--  // bagian selain admin //  --}}
         {{--  @if (Auth::user()->role != '1')
             <li>

                 <a href="javascript:;" class="side-menu ">
                     <div class="side-menu__icon"> <i data-lucide="file-text"></i> </div>
                     <div class="side-menu__title">
                         REPORT
                         <div class="side-menu__sub-icon "> <i data-lucide="chevron-down"></i> </div>
                     </div>
                 </a>
                 <ul class="">
                     <li>
                         <a href="{{ route('jadwalmapel.all') }}" class="side-menu">
                             <div class="side-menu__icon"> <i data-lucide="file"></i> </div>
                             <div class="side-menu__title">Jadwal Mapel</div>
                         </a>
                     </li>
                     <li>
                         <a href="{{ route('jadwalmapel.all') }}" class="side-menu">
                             <div class="side-menu__icon"> <i data-lucide="file"></i> </div>
                             <div class="side-menu__title">Absensi Siswa</div>
                         </a>
                     </li>
                     <li>
                         <a href="{{ route('jadwalmapel.all') }}" class="side-menu">
                             <div class="side-menu__icon"> <i data-lucide="file"></i> </div>
                             <div class="side-menu__title">Guru</div>
                         </a>
                     </li>
                     <li>
                         <a href="{{ route('jadwalmapel.all') }}" class="side-menu">
                             <div class="side-menu__icon"> <i data-lucide="file"></i> </div>
                             <div class="side-menu__title">Orang Tua</div>
                         </a>
                     </li>
                     <li>
                         <a href="{{ route('jadwalmapel.all') }}" class="side-menu">
                             <div class="side-menu__icon"> <i data-lucide="file"></i> </div>
                             <div class="side-menu__title">Siswa</div>
                         </a>
                     </li>

                 </ul>
             </li>
         @endif  --}}
         {{--  // end bagian selain admin //  --}}

     </ul>

 </nav>
