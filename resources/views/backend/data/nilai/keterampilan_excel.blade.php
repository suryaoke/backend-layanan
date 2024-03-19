 <table id="datatable" class="table table-bordered">
     <thead>
         <tr>
             <th class="whitespace-nowrap">No</th>
             <th class="whitespace-nowrap">NISN</th>
             <th class="whitespace-nowrap">Nama</th>
             <th class="whitespace-nowrap">Jk</th>
             <th class="whitespace-nowrap">Kelas</th>
             <th class="whitespace-nowrap">Rapor</th>
             <th class="whitespace-nowrap">Predikat</th>
             <th class="whitespace-nowrap">Deskripsi</th>


         </tr>
     </thead>
     <tbody>

         @foreach ($rombelsiswa as $key => $item)
             @php

                 $nilaiketerampilan = App\Models\Nilai::where('id_seksi', $id)
                     ->where('id_rombelsiswa', $item->id)
                     ->where('type_nilai', 3)
                     ->avg('nilai_keterampilan');

                 $nilaiketerampilan_bulat = round($nilaiketerampilan);
                 $kkm1 = App\Models\Kkm::where('id_kelas', $item->rombels->kelass->tingkat)->first();

                 $c1 = $kkm1->kkm + 6;
                 $b1 = $c1 + 6;
                 $a1 = $b1 + 6;

                 if ($nilaiketerampilan_bulat < $kkm1->kkm) {
                     $predikat1 = 'D';
                 } elseif ($nilaiketerampilan_bulat < $c1) {
                     $predikat1 = 'C';
                 } elseif ($nilaiketerampilan_bulat < $b1) {
                     $predikat1 = 'B';
                 } elseif ($nilaiketerampilan_bulat < $a1) {
                     $predikat1 = 'A';
                 } else {
                     $predikat1 = '-';
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

                     {{ $nilaiketerampilan_bulat }}


                 </td>
                 <td class="whitespace-nowrap">
                     {{ $predikat1 }}
                 </td>
                 <td class="whitespace-nowrap">
                     -
                 </td>

             </tr>
         @endforeach
     </tbody>
 </table>
