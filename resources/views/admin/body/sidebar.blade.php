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
     }
     
     $url = url()->current();
     $dashboard = URL::route('dashboard');
     $absensi = URL::route('absensi.all');
     $absensiadd = URL::route('absensi.add');
     $absensisiswa = URL::route('absensi.siswa');
     $user = URL::route('user.all');
     $useradd = URL::route('user.add');
     
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
         <span class="hidden xl:block text-white text-lg ml-3">PTSP MAN 1 Kota Padang</span>
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

         {{--  // bagian selain admin //  --}}
         @if (Auth::user()->role != '1')
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
                     Absensi
                 </div>
                 </a>

             </li>
             {{--  // end bagian selain admin //  --}}
         @endif
         {{--  // bagian selain admin //  --}}
         @if (Auth::user()->role != '1')
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
         {{--  // end bagian selain admin //  --}}


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
                     Jadwal Mapel
                     <div class="side-menu__sub-icon "> <i data-lucide="chevron-down"></i> </div>
                 </div>
                 </a>
                 <ul class="">
                     <li>
                         <a href="{{ route('jadwalmapel.all') }}" class="side-menu">
                             <div class="side-menu__icon"> <i data-lucide="calendar"></i> </div>
                             <div class="side-menu__title">Jadwal Mapel</div>
                         </a>
                     </li>
                     <li>
                         <a href="{{ route('mapel.all') }}" class="side-menu">
                             <div class="side-menu__icon"> <i data-lucide="file"></i> </div>
                             <div class="side-menu__title">Mata Pelajaran</div>
                         </a>
                     </li>
                     <li>
                         <a href="{{ route('pengampu.all') }}" class="side-menu">
                             <div class="side-menu__icon"> <i data-lucide="users"></i> </div>
                             <div class="side-menu__title">Pengampu</div>
                         </a>
                     </li>
                 </ul>
             </li>

             <li>
                 @if ($hari == $url)
                     <a href="javascript:;" class="side-menu side-menu--active">
                     @elseif ($hariadd == $url)
                         <a href="javascript:;" class="side-menu side-menu--active">
                         @elseif ($hariedit == $url)
                             <a href="javascript:;" class="side-menu side-menu--active">
                             @elseif ($waktu == $url)
                                 <a href="javascript:;" class="side-menu side-menu--active">
                                 @elseif ($waktuadd == $url)
                                     <a href="javascript:;" class="side-menu side-menu--active">
                                     @elseif ($waktuedit == $url)
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

             <li>
                 @if ($ruangan == $url)
                     <a href="{{ route('ruangan.all') }}" class="side-menu  side-menu--active">
                     @elseif ($ruanganadd == $url)
                         <a href="{{ route('ruangan.all') }}" class="side-menu  side-menu--active">
                         @elseif ($ruanganedit == $url)
                             <a href="{{ route('ruangan.all') }}" class="side-menu  side-menu--active">
                             @else
                                 <a href="{{ route('ruangan.all') }}" class="side-menu ">
                 @endif
                 <div class="side-menu__icon"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                         viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                         stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-school">
                         <path d="m4 6 8-4 8 4" />
                         <path d="m18 10 4 2v8a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2v-8l4-2" />
                         <path d="M14 22v-4a2 2 0 0 0-2-2v0a2 2 0 0 0-2 2v4" />
                         <path d="M18 5v17" />
                         <path d="M6 5v17" />
                         <circle cx="12" cy="9" r="2" />
                     </svg> </div>
                 <div class="side-menu__title">
                     Ruangan
                 </div>
                 </a>

             </li>

             <li>
                 @if ($jurusan == $url)
                     <a href="{{ route('jurusan.all') }}" class="side-menu  side-menu--active">
                     @elseif ($jurusanadd == $url)
                         <a href="{{ route('jurusan.all') }}" class="side-menu  side-menu--active">
                         @elseif ($jurusanedit == $url)
                             <a href="{{ route('jurusan.all') }}" class="side-menu  side-menu--active">
                             @else
                                 <a href="{{ route('jurusan.all') }}" class="side-menu ">
                 @endif
                 <div class="side-menu__icon"><i data-lucide="file-text"></i> </div>
                 <div class="side-menu__title">
                     Jurusan
                 </div>
                 </a>

             </li>



         @endif
         {{--  // end bagian wakil kurikulum //  --}}


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
             <div class="side-menu__icon"> <i data-lucide="users"></i> </div>
             <div class="side-menu__title">
                 Menu Master
                 <div class="side-menu__sub-icon "> <i data-lucide="chevron-down"></i> </div>
             </div>
             </a>
             <ul class="">
                 <li>
                     <a href="{{ route('user.all') }}" class="side-menu">
                         <div class="side-menu__icon"> <i data-lucide="user"></i> </div>
                         <div class="side-menu__title"> User </div>
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


         {{--  // bagian selain admin //  --}}
         @if (Auth::user()->role != '1')
             <li>

                 <a href="javascript:;" class="side-menu ">
                     <div class="side-menu__icon"> <i data-lucide="file"></i> </div>
                     <div class="side-menu__title">
                         Report Data
                         <div class="side-menu__sub-icon "> <i data-lucide="chevron-down"></i> </div>
                     </div>
                 </a>
                 <ul class="">



                 </ul>
             </li>
         @endif
         {{--  // end bagian selain admin //  --}}

     </ul>

 </nav>
