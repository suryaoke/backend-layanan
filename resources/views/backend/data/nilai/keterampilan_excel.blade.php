 <table id="datatable" class="table table-bordered">
     <thead>
         <tr>
             <th colspan="8" style="border: 2px solid black; text-align: center; font-weight: bold;">
                 Data Nilai Keterampilan Siswa</th>
         </tr>
         <tr>
             <th colspan="8" style="border: 2px solid black; text-align: center; font-weight: bold;">Semester
                 {{ $tahun->semester }} Tahun Ajar {{ $tahun->tahun }} </th>
         </tr>
         <tr>
             <th style="width:40px  ; border: 2px solid black; text-align: center;">No</th>
             <th style="width:100px  ; border: 2px solid black; text-align: center;">NISN</th>
             <th style="width:100px  ; border: 2px solid black; text-align: center;">Nama</th>
             <th style="width:100px  ; border: 2px solid black; text-align: center;">Jk</th>
             <th style="width:100px  ; border: 2px solid black; text-align: center;">Kelas</th>
             <th style="width:100px  ; border: 2px solid black; text-align: center;">Rapor</th>
             <th style="width:100px  ; border: 2px solid black; text-align: center;">Predikat</th>
             <th style="width:100px  ; border: 2px solid black; text-align: center;">Deskripsi</th>


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
                 <td style="width:40px  ; border: 2px solid black; text-align: center;">{{ $key + 1 }}</td>
                 <td style="width:100px  ; border: 2px solid black; text-align: center;"> {{ $item->siswas->nisn }}
                 </td>
                 <td style="width:100px  ; border: 2px solid black; text-align: center;"> {{ $item->siswas->nama }}
                 </td>
                 <td style="width:100px  ; border: 2px solid black; text-align: center;"> {{ $item->siswas->jk }} </td>
                 <td style="width:100px  ; border: 2px solid black; text-align: center;">
                     {{ $item->rombels->kelass->tingkat }}
                     {{ $item->rombels->kelass->nama }}
                     {{ $item->rombels->kelass->jurusans->nama }}</td>
                 <td style="width:100px  ; border: 2px solid black; text-align: center;">

                     {{ $nilaiketerampilan_bulat }}


                 </td>
                 <td style="width:100px  ; border: 2px solid black; text-align: center;">
                     {{ $predikat1 }}
                 </td>
                 <td style="width:100px  ; border: 2px solid black; text-align: center;">
                     -
                 </td>

             </tr>
         @endforeach
     </tbody>
 </table>
