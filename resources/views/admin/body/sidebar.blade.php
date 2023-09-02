 @php
     
     $id = Request::route('id');
     
     if ($id !== null) {
         $guruedit = URL::route('guru.edit', ['id' => $id]);
         $orangtuaedit = URL::route('orangtua.edit', ['id' => $id]);
         $siswaedit = URL::route('siswa.edit', ['id' => $id]);
         $kelasedit = URL::route('kelas.edit', ['id' => $id]);
         $useredit = URL::route('user.edit', ['id' => $id]);
         $userview = URL::route('user.view', ['id' => $id]);
     } else {
         $guruedit = 1; // Handle jika parameter id tidak ditemukan dalam URL
         $orangtuaedit = 1;
         $siswaedit = 1;
         $kelasedit = 1;
         $useredit = 1;
         $userview = 1;
     }
     
     $url = url()->current();
     $dashboard = URL::route('dashboard');
     $absensi = URL::route('absensi.all');
     $absensiadd = URL::route('absensi.add');
     $absensisiswa = URL::route('absensi.siswa');
     $user = URL::route('user.all');
     $useradd = URL::route('user.add');
     $jabatan = URL::route('jabatan.all');
     $jabatanadd = URL::route('jabatan.add');
     $siswa = URL::route('siswa.all');
     $siswaadd = URL::route('siswa.add');
     $guru = URL::route('guru.all');
     $guruadd = URL::route('guru.add');
     $orangtua = URL::route('orangtua.all');
     $orangtuaadd = URL::route('orangtua.add');
     $suratmasukadd = URL::route('surat.masuk.add');
     $kelas = URL::route('kelas.all');
     $kelasadd = URL::route('kelas.add');
     
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
                 @else
                     <a href="{{ route('dashboard') }}" class="side-menu ">
             @endif
             <div class="side-menu__icon"> <i data-lucide="home"></i> </div>
             <div class="side-menu__title">
                 Dashboard
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
                 Absensi
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
         <li>

             @if ($siswa == $url)
                 <a href="javascript:;" class="side-menu side-menu--active">
                 @elseif ($siswaadd == $url)
                     <a href="javascript:;" class="side-menu side-menu--active">
                     @elseif ($siswaedit == $url)
                         <a href="javascript:;" class="side-menu side-menu--active">
                         @elseif ($kelas == $url)
                             <a href="javascript:;" class="side-menu side-menu--active">
                             @elseif ($kelasadd == $url)
                                 <a href="javascript:;" class="side-menu side-menu--active">
                                 @elseif ($kelasedit == $url)
                                     <a href="javascript:;" class="side-menu side-menu--active">
                                     @elseif ($guru == $url)
                                         <a href="javascript:;" class="side-menu side-menu--active">
                                         @elseif ($guruadd == $url)
                                             <a href="javascript:;" class="side-menu side-menu--active">
                                             @elseif ($guruedit == $url)
                                                 <a href="javascript:;" class="side-menu side-menu--active">
                                                 @elseif ($orangtua == $url)
                                                     <a href="javascript:;" class="side-menu side-menu--active">
                                                     @elseif ($orangtuaadd == $url)
                                                         <a href="javascript:;" class="side-menu side-menu--active">
                                                         @elseif ($orangtuaedit == $url)
                                                             <a href="javascript:;" class="side-menu side-menu--active">
                                                             @else
                                                                 <a href="javascript:;" class="side-menu ">
             @endif
             <div class="side-menu__icon"> <i data-lucide="edit"></i> </div>
             <div class="side-menu__title">
                 Data
                 <div class="side-menu__sub-icon "> <i data-lucide="chevron-down"></i> </div>
             </div>
             </a>
             <ul class="">
                 <li>
                     <a href="{{ route('guru.all') }}" class="side-menu">
                         <div class="side-menu__icon"> <i data-lucide="minus"></i> </div>
                         <div class="side-menu__title"> Guru </div>
                     </a>
                 </li>
                 <li>
                     <a href="{{ route('orangtua.all') }}" class="side-menu">
                         <div class="side-menu__icon"> <i data-lucide="minus"></i> </div>
                         <div class="side-menu__title"> Orang Tua </div>
                     </a>
                 </li>
                 <li>
                     <a href="{{ route('siswa.all') }}" class="side-menu">
                         <div class="side-menu__icon"> <i data-lucide="minus"></i> </div>
                         <div class="side-menu__title"> Siswa </div>
                     </a>
                 </li>
                 @if (Auth::user()->role == '4')
                     <li>
                         <a href="{{ route('kelas.all') }}" class="side-menu">
                             <div class="side-menu__icon"> <i data-lucide="minus"></i> </div>
                             <div class="side-menu__title"> Kelas </div>
                         </a>
                     </li>
                 @endif


                 @if (Auth::user()->role == '1')
                     <li>
                         <a href="{{ route('surat.keluar.tandatangan') }}" class="side-menu">
                             <div class="side-menu__icon"> <i data-lucide="minus"></i> </div>
                             <div class="side-menu__title">
                                 Surat Tandatangan </div>
                         </a>
                     </li>
                 @endif

                 @if (Auth::user()->role == '3')
                     <li>
                         <a href="{{ route('surat.keluar.verifikasi') }}" class="side-menu">
                             <div class="side-menu__icon"> <i data-lucide="minus"></i> </div>
                             <div class="side-menu__title">
                                 Surat Verifivikasi </div>
                         </a>
                     </li>
                 @endif


             </ul>
         </li>

         @if (Auth::user()->role == '4')
             <li>
                 @if ($user == $url)
                     <a href="javascript:;" class="side-menu side-menu--active">
                     @elseif ($useradd == $url)
                         <a href="javascript:;" class="side-menu side-menu--active">
                         @elseif ($useredit == $url)
                             <a href="javascript:;" class="side-menu side-menu--active">
                             @elseif ($userview == $url)
                                 <a href="javascript:;" class="side-menu side-menu--active">
                                 @elseif ($jabatan == $url)
                                     <a href="javascript:;" class="side-menu side-menu--active">
                                     @elseif ($jabatanadd == $url)
                                         <a href="javascript:;" class="side-menu side-menu--active">
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
                             <div class="side-menu__icon"> <i data-lucide="minus"></i> </div>
                             <div class="side-menu__title"> User </div>
                         </a>
                     </li>
                     <li>
                         <a href="{{ route('jabatan.all') }}" class="side-menu">
                             <div class="side-menu__icon"> <i data-lucide="minus"></i> </div>
                             <div class="side-menu__title"> Jabatan</div>
                         </a>
                     </li>

                 </ul>
             </li>


         @endif

         @if (Auth::user()->role == '4' || Auth::user()->role == '1')
             <li>

                 <a href="javascript:;" class="side-menu ">
                     <div class="side-menu__icon"> <i data-lucide="file"></i> </div>
                     <div class="side-menu__title">
                         Report Data
                         <div class="side-menu__sub-icon "> <i data-lucide="chevron-down"></i> </div>
                     </div>
                 </a>
                 <ul class="">
                     <li>
                         <a href="{{ route('tamu.report') }}" class="side-menu">
                             <div class="side-menu__icon"> <i data-lucide="minus"></i> </div>
                             <div class="side-menu__title"> Tamu </div>
                         </a>
                     </li>
                     <li>
                         <a href="{{ route('surat.masuk.report') }}" class="side-menu">
                             <div class="side-menu__icon"> <i data-lucide="minus"></i> </div>
                             <div class="side-menu__title"> Surat Masuk </div>
                         </a>
                     </li>
                     <li>
                         <a href="{{ route('surat.keluar.report') }}" class="side-menu">
                             <div class="side-menu__icon"> <i data-lucide="minus"></i> </div>
                             <div class="side-menu__title"> Surat Keluar </div>
                         </a>
                     </li>

                 </ul>
             </li>
         @endif


     </ul>

 </nav>
