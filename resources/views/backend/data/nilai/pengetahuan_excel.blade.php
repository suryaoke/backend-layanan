   <table id="datatable" class="table table-bordered">
       <thead>
           <tr>
               <th colspan="10" style="border: 2px solid black; text-align: center; font-weight: bold;">
                   Data Nilai Pengetahuan Siswa</th>
           </tr>
           <tr>
               <th colspan="10" style="border: 2px solid black; text-align: center; font-weight: bold;">Semester
                   {{ $tahun->semester }} Tahun Ajar {{ $tahun->tahun }} </th>
           </tr>
           <tr>
               <th style="width:40px  ; border: 2px solid black; text-align: center;">No</th>
               <th style="width:100px  ; border: 2px solid black; text-align: center;">NISN</th>
               <th style="width:100px  ; border: 2px solid black; text-align: center;">Nama</th>
               <th style="width:100px  ; border: 2px solid black; text-align: center;">Jk</th>
               <th style="width:100px  ; border: 2px solid black; text-align: center;">Kelas</th>
               <th style="width:100px  ; border: 2px solid black; text-align: center;">Harian</th>
               <th style="width:100px  ; border: 2px solid black; text-align: center;">PAS</th>
               <th style="width:100px  ; border: 2px solid black; text-align: center;">Rapor</th>
               <th style="width:100px  ; border: 2px solid black; text-align: center;">Predikat</th>
               <th style="width:100px  ; border: 2px solid black; text-align: center;">Deskripsi</th>


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
                   <td style="width:40px  ; border: 2px solid black; text-align: center;">{{ $key + 1 }}</td>
                   <td style="width:100px  ; border: 2px solid black; text-align: center;"> {{ $item->siswas->nisn }}
                   </td>
                   <td style="width:100px  ; border: 2px solid black; text-align: center;"> {{ $item->siswas->nama }}
                   </td>
                   <td style="width:100px  ; border: 2px solid black; text-align: center;"> {{ $item->siswas->jk }}
                   </td>
                   <td style="width:100px  ; border: 2px solid black; text-align: center;">
                       {{ $item->rombels->kelass->tingkat }}
                       {{ $item->rombels->kelass->nama }}
                       {{ $item->rombels->kelass->jurusans->nama }}</td>
                   <td style="width:100px  ; border: 2px solid black; text-align: center;">

                       {{ $nilaiharian_bulat }}


                   </td>
                   <td style="width:100px  ; border: 2px solid black; text-align: center;">
                       @if ($nilaipas)
                           {{ $nilaipas->nilai_pengetahuan_akhir }}
                       @else
                           -
                       @endif
                   </td>
                   <td style="width:100px  ; border: 2px solid black; text-align: center;"> {{ $rapor_bulat }} </td>
                   <td style="width:100px  ; border: 2px solid black; text-align: center;"> {{ $predikat }} </td>
                   <td style="width:100px  ; border: 2px solid black; text-align: center;"> {{ $item->siswas->jk }}
                   </td>
               </tr>
           @endforeach
       </tbody>
   </table>
