 @extends('admin.admin_master')
 @section('admin')
     <div class="content">

         <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
             <h2 class="text-lg font-medium mr-auto">
                 Surat Masuk Terkirim
             </h2>
             @if ($surat['status'] != '0' && $surat['status'] != '1')
                 <a data-tw-toggle="modal" data-tw-target="#header-footer-modal-preview" class="btn btn-warning mr-1 mb-2">
                     <i data-lucide="edit" class="w-5 h-5 mr-1"></i>Tujuan Surat
                 </a>
             @endif
         </div>
         <!-- BEGIN: Invoice -->
         <div class="intro-y box overflow-hidden mt-5">

             <div class="flex flex-col lg:flex-row border-b px-5 sm:px-10 pt-5 pb-5 sm:pb-10 text-center sm:text-left">
                 <div>
                     <div class="text-base text-slate-500">Surat Details</div>
                     <div class="text-lg font-medium text-primary mt-1">{{ $suratmasukterkirim['suratmasuk']['pengirim'] }}
                     </div>
                     <div class="mt-1">Asal Surat:
                         @if ($suratmasukterkirim['suratmasuk']['asal_surat'] == '0')
                             Belum di Pilih
                         @elseif ($suratmasukterkirim['suratmasuk']['asal_surat'] == '1')
                             Luar Sekolah
                         @endif
                     </div>
                 </div>
                 <div class="mt-10 lg:mt-0 lg:ml-auto lg:text-right">
                     <div class="mt-8">Nomor Surat : {{ $suratmasukterkirim['suratmasuk']['no_surat'] }}</div>
                     <div class="mt-1">{{ $suratmasukterkirim['suratmasuk']['tgl_surat'] }}</div>
                 </div>
             </div>
             <div class="px-5 sm:px-16 py-5 sm:py-10 border-b px-5 sm:px-10 pt-5 pb-5 sm:pb-10 text-center sm:text-left">
                 <div class="overflow-x-auto">

                     <iframe src="{{ asset('uploads/suratmasuk/' . $suratmasukterkirim['suratmasuk']['file']) }}"
                         style="width: 100%; height:1100px; border: none;"></iframe>

                 </div>
             </div>

             <div class="px-5 sm:px-16 py-10 sm:py-15">
                 <div class="overflow-x-auto">

                     <table class="table">

                         <thead>
                             <tr>
                                 <th class="border-b-2 dark:border-darkmode-400 whitespace-nowrap">Isi Disposisi</th>
                                 <th class="border-b-2 dark:border-darkmode-400 text-right whitespace-nowrap">Penerima</th>
                                 <th class="border-b-2 dark:border-darkmode-400 text-right whitespace-nowrap">Tanggal
                                 </th>
                                 <th class="border-b-2 dark:border-darkmode-400 text-right whitespace-nowrap">Status</th>
                                 <th class="border-b-2 dark:border-darkmode-400 text-right whitespace-nowrap">Action</th>
                             </tr>
                         </thead>
                         <tbody>
                             @foreach ($suratmasukdisposisi as $key => $item)
                                 <tr>
                                     <td class="border-b dark:border-darkmode-400">
                                         <div class="font-medium whitespace-nowrap">{{ $item->isi }}</div>

                                     </td>
                                     @php
                                         
                                         $user = App\Models\User::where('id', $item->id_penerima)->first();
                                         $surat = App\Models\SuratMasuk::where('id', $item->id_sm)->first();
                                     @endphp
                                     <td class="text-right border-b dark:border-darkmode-400 w-32">{{ $user->name }}</td>
                                     <td class="text-right border-b dark:border-darkmode-400 w-32">
                                         {{ $item->created_at->format('d, M Y') }}
                                     </td>
                                     <td class="text-right border-b dark:border-darkmode-400 w-32 ">
                                         @if ($item->status == '1')
                                             <span class="btn btn-outline-primary">Dibaca</span>
                                         @elseif ($item->status == '0')
                                             <span class="btn btn-outline-pending">Dikirim</span>
                                         @endif

                                     </td>
                                     <td></td>

                                 </tr>
                             @endforeach

                         </tbody>
                     </table>

                 </div>
             </div>



         </div>
         <!-- END -->
     </div>
 @endsection
 @if ($surat['status'] != '0' && $surat['status'] != '1')

     <!-- BEGIN: Modal Content -->
     <div id="header-footer-modal-preview" class="modal" tabindex="-1" aria-hidden="true">
         <div class="modal-dialog">
             <div class="modal-content">
                 <!-- BEGIN: Modal Header -->
                 <div class="modal-header">
                     <h2 class="font-medium text-base mr-auto">Tujuan Surat</h2>
                     <div class="dropdown sm:hidden"> <a class="dropdown-toggle w-5 h-5 block" href="javascript:;"
                             aria-expanded="false" data-tw-toggle="dropdown"> <i data-lucide="more-horizontal"
                                 class="w-5 h-5 text-slate-500"></i> </a>
                         <div class="dropdown-menu w-40">

                         </div>
                     </div>
                 </div> <!-- END: Modal Header -->
                 <!-- BEGIN: Modal Body -->
                 <form method="post" action="{{ route('surat.masuk.tujuan.store') }}" enctype="multipart/form-data"
                     id="myForm">
                     @csrf
                     <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">

                         <div class="col-span-12 sm:col-span-6"> <label for="modal-form-6" class="form-label">Pilih
                                 Tujuan
                                 Surat</label>
                             <select id="modal-form-6" name="tujuan" class="form-select">
                                 @foreach ($user as $users)
                                     @if ($users->id != Auth::user()->id)
                                         <option value=" {{ $users->id }} "> {{ $users->name }} </option>
                                     @endif
                                 @endforeach
                             </select>

                             <input type="hidden" name="id" value="{{ $suratmasukterkirim->id_sm }}">

                         </div>
                     </div> <!-- END: Modal Body -->
                     <!-- BEGIN: Modal Footer -->
                     <div class="modal-footer"> <button type="button" data-tw-dismiss="modal"
                             class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
                         <button type="submit" class="btn btn-primary w-20">Save</button>
                     </div> <!-- END: Modal Footer -->
                 </form>

             </div>
         </div>
     </div> <!-- END: Modal Content -->
 @endif
