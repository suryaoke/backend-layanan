 @extends('admin.admin_master')
 @section('admin')
     <div class="content">

         <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
             <h2 class="text-lg font-medium mr-auto">
                 Surat Masuk
             </h2>

         </div>
         <!-- BEGIN: Invoice -->
         <div class="intro-y box overflow-hidden mt-5">

             <div class="flex flex-col lg:flex-row border-b px-5 sm:px-10 pt-5 pb-5 sm:pb-10 text-center sm:text-left">
                 <div>
                     <div class="text-base text-slate-500">Surat Details</div>
                     <div class="text-lg font-medium text-primary mt-1">{{ $suratmasuk->pengirim }}
                     </div>
                     <div class="mt-1">Asal Surat:
                         @if ($suratmasuk->asal_surat == '0')
                             Belum di Pilih
                         @elseif ($suratmasuk->asal_surat == '1')
                             Luar Sekolah
                         @endif
                     </div>
                 </div>
                 <div class="mt-10 lg:mt-0 lg:ml-auto lg:text-right">
                     <div class="mt-8">Nomor Surat : {{ $suratmasuk->no_surat }}</div>
                     <div class="mt-1">{{ $suratmasuk->tgl_surat }}</div>
                 </div>
             </div>
             <div class="px-5 sm:px-16 py-5 sm:py-10 border-b px-5 sm:px-10 pt-5 pb-5 sm:pb-10 text-center sm:text-left">
                 <div class="overflow-x-auto">
                     @csrf
                     <iframe src="{{ asset('uploads/suratmasuk/' . $suratmasuk->file) }}"
                         style="width: 100%; height:1100px; border: none;"></iframe>

                 </div>
             </div>

             @if (Auth::user()->role == '1')
                 <div class=" border-b px-5 sm:px-10 pt-5 pb-10 sm:pb-10 text-center sm:text-left">
                     <form method="post" action="{{ route('surat.masuk.disposisi.store') }}" enctype="multipart/form-data"
                         id="myForm">
                         @csrf
                         <div class="text-base text-slate-500"> Disposisi Surat :</div>
                         <div class="mt-8 ">
                             <textarea name="isi" id="isi" cols="91" rows="6" class="form-control">Perihal...</textarea>
                             <div class="mt-4">
                                 <select name="id_penerima" id="id_penerima" class="tom-select w-full col-span-4 "
                                     aria-label="Default select example">

                                     @foreach ($user as $users)
                                         @if ($users->id != Auth::user()->id)
                                             <option value=" {{ $users->id }} ">Tujuan Surat : {{ $users->name }}
                                             </option>
                                         @endif
                                     @endforeach

                                 </select>
                                 <input type="hidden" name="id_sm" id="id_sm" value="{{ $suratmasuk->id }}">
                                 <button class="btn btn-primary mt-10 mr-1 mb-2 " type="submit"><i data-lucide="send"
                                         class="mr-2"></i>
                                     Kirim Surat</button>
                             </div>
                         </div>
                 </div>
             @endif

             @if (Auth::user()->role == '2' || Auth::user()->role == '3')
                 <div class=" border-b px-5 sm:px-10 pt-5 pb-10 sm:pb-10 text-center sm:text-left">
                     <form method="post" action="{{ route('surat.masuk.disposisi.store') }}" enctype="multipart/form-data"
                         id="myForm">
                         @csrf
                         <div class="text-base text-slate-500"> Disposisi Surat :</div>
                         <div class="mt-8 ">
                             <textarea name="isi" id="isi" cols="91" rows="6" class="form-control">Perihal...</textarea>
                             <div class="mt-4">
                                 <select name="id_penerima" id="id_penerima" class="tom-select w-full col-span-4 "
                                     aria-label="Default select example">

                                     @foreach ($user as $users)
                                         @if ($users->id != Auth::user()->id && $users->role != '1')
                                             <option value=" {{ $users->id }} ">Tujuan Surat : {{ $users->name }}
                                             </option>
                                         @endif
                                     @endforeach

                                 </select>
                                 <input type="hidden" name="id_sm" id="id_sm" value="{{ $suratmasuk->id }}">
                                 <button class="btn btn-primary mt-10 mr-1 mb-2 " type="submit"><i data-lucide="send"
                                         class="mr-2"></i>
                                     Kirim Surat</button>
                             </div>
                         </div>
                 </div>
             @endif


             <div class="px-5 sm:px-16 py-10 sm:py-15">
                 <div class="text-base text-slate-500 mb-4"> Surat Masuk Disposisi :</div>
                 <div class="overflow-x-auto">
                     <table class="table">
                         <thead>
                             <tr>
                                 <th class="border-b-2 dark:border-darkmode-400 whitespace-nowrap">Perihal </th>
                                 <th class="border-b-2 dark:border-darkmode-400  whitespace-nowrap">Penerima</th>
                                 <th class="border-b-2 dark:border-darkmode-400  whitespace-nowrap">Tanggal
                                 </th>
                                 <th class="border-b-2 dark:border-darkmode-400  whitespace-nowrap">Status</th>
                                 <th class="border-b-2 dark:border-darkmode-400 whitespace-nowrap">Action</th>
                             </tr>
                         </thead>
                         <tbody>
                             @foreach ($suratmasukdisposisi as $key => $item)
                                 <tr>
                                     <td class="border-b dark:border-darkmode-400">
                                         {{ $item->isi }}
                                     </td>
                                     @php
                                         
                                         $user = App\Models\User::where('id', $item->id_penerima)->first();
                                         $surat = App\Models\SuratMasuk::where('id', $item->id_sm)->first();
                                     @endphp
                                     <td class=" border-b dark:border-darkmode-400 w-32">{{ $user->name }}</td>
                                     <td class=" border-b dark:border-darkmode-400 w-32">
                                         {{ $item->created_at->format('d, M Y') }}
                                     </td>
                                     <td class="t border-b dark:border-darkmode-400 w-32  ">
                                         @if ($item->status == '1')
                                             <span class="btn btn-outline-primary">Dibaca</span>
                                         @elseif ($item->status == '0')
                                             <span class="btn btn-outline-pending">Dikirim</span>
                                         @endif
                                     </td>
                                     @if ($item->status == '0' && $item->id_pengirim == Auth::user()->id)
                                         <td class=" border-b dark:border-darkmode-400 w-32 "><a id="delete"
                                                 href="{{ route('surat.masuk.disposisi.delete', $item->id) }}"
                                                 class="btn btn-danger mr-1 mb-2">
                                                 <i data-lucide="trash" class="w-5 h-5"></i> </a></td>
                                     @else
                                         <td></td>
                                     @endif
                                     @if ($item->id_penerima == Auth::user()->id && $item->status == '0')
                                         <td class=" border-b dark:border-darkmode-400 w-32 "><a id="ApproveBtn"
                                                 href="{{ route('surat.masuk.disposisi.approve', $item->id) }}"
                                                 class="btn btn-success mr-1 mb-2">
                                                 <i data-lucide="check-circle" class="w-5 h-5"></i> </a></td>
                                     @else
                                         <td></td>
                                     @endif
                                 </tr>
                             @endforeach

                         </tbody>
                     </table>
                     </form>

                 </div>
             </div>

         </div>
         <!-- END -->
     </div>
 @endsection

 <script type="text/javascript">
     jQuery(document).ready(function() {
         $('#myForm').validate({
             rules: {
                 id_penerima: {
                     required: true,
                 },




             },
             messages: {
                 id_penerima: {
                     required: 'Please Enter Your Tujuan',
                 },


             },
             errorElement: 'span',
             errorPlacement: function(error, element) {
                 error.addClass('invalid-feedback');
                 element.closest('.form-group').append(error);
             },
             highlight: function(element, errorClass, validClass) {
                 $(element).addClass('is-invalid');
             },
             unhighlight: function(element, errorClass, validClass) {
                 $(element).removeClass('is-invalid');
             },
         });
     });
 </script>
 <script>
     import InlineEditor from "@ckeditor/ckeditor5-build-inline";
     $(".editor").each(function() {
         const el = this;
         InlineEditor.create(el).catch((error) => {
             console.error(error);
         });
     });
 </script>
