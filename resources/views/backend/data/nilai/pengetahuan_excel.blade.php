   <table id="datatable" class="table table-bordered">
       <thead>
           <tr>
               <th class="whitespace-nowrap">No</th>
               <th class="whitespace-nowrap">NISN</th>
               <th class="whitespace-nowrap">Nama</th>
               <th class="whitespace-nowrap">Jk</th>
               <th class="whitespace-nowrap">Kelas</th>
               <th class="whitespace-nowrap">Harian</th>
               <th class="whitespace-nowrap">PAS</th>
               <th class="whitespace-nowrap">Rapor</th>
               <th class="whitespace-nowrap">Predikat</th>
               <th class="whitespace-nowrap">Deskripsi</th>


           </tr>
       </thead>
       <tbody>

           @foreach ($rombelsiswa as $key => $item)
               @php
                   $nilaiharian = App\Models\Nilai::where('id_seksi', $id)
                       ->where('id_rombelsiswa', $item->id)
                       ->where('type_nilai', 1)
                       ->avg('nilai_pengetahuan');

                   $nilaiharian_bulat = round($nilaiharian);

                   // Gunakan nilaiharian_bulat untuk penggunaan selanjutnya

                   $nilaipas = App\Models\Nilai::where('id_rombelsiswa', $item->id)
                       ->where('type_nilai', 2)
                       ->first();

                   $rapor = ($nilaiharian_bulat + optional($nilaipas)->nilai_pengetahuan_akhir) / 2;

                   $rapor_bulat = round($rapor);
                   $kkm = App\Models\Kkm::where('id_kelas', $item->rombels->kelass->tingkat)->first();

                   $c = $kkm->kkm + 6;
                   $b = $c + 6;
                   $a = $b + 6;

                   if ($rapor_bulat < $kkm->kkm) {
                       $predikat = 'D';
                   } elseif ($rapor_bulat < $c) {
                       $predikat = 'C';
                   } elseif ($rapor_bulat < $b) {
                       $predikat = 'B';
                   } elseif ($rapor_bulat < $a) {
                       $predikat = 'A';
                   } else {
                       $predikat = '-';
                   }
               @endphp
               <tr>
                   <td class="whitespace-nowrap">{{ $key + 1 }}</td>
                   <td class="whitespace-nowrap"> {{ $item->siswas->nisn }} </td>
                   <td class="whitespace-nowrap"> {{ $item->siswas->nama }} </td>
                   <td class="whitespace-nowrap"> {{ $item->siswas->jk }} </td>
                   <td class="whitespace-nowrap"> {{ $item->rombels->kelass->tingkat }}
                       {{ $item->rombels->kelass->nama }}
                       {{ $item->rombels->kelass->jurusans->nama }}</td>
                   <td class="whitespace-nowrap">

                       {{ $nilaiharian_bulat }}


                   </td>
                   <td class="whitespace-nowrap">
                       @if ($nilaipas)
                           {{ $nilaipas->nilai_pengetahuan_akhir }}
                       @else
                           -
                       @endif
                   </td>
                   <td class="whitespace-nowrap"> {{ $rapor_bulat }} </td>
                   <td class="whitespace-nowrap"> {{ $predikat }} </td>
                   <td class="whitespace-nowrap"> {{ $item->siswas->jk }} </td>
               </tr>
           @endforeach
       </tbody>
   </table>
