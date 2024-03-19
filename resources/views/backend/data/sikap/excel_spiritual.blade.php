 <table id="datatable" class="table table-bordered">
     <thead>
         <tr>
             <th colspan="8" style="border: 2px solid black; text-align: center; font-weight: bold;">
                 Data Nilai Sikap Spiritual Siswa</th>
         </tr>
         <tr>
             <th colspan="8" style="border: 2px solid black; text-align: center; font-weight: bold;">Semester
                 {{ $tahun->semester }} Tahun Ajar {{ $tahun->tahun }} </th>
         </tr>
         <tr>
             <th style="width:100px; border: 2px solid black; text-align: center; background-color: yellow;">No</th>
             <th style="width:100px; border: 2px solid black; text-align: center; background-color: yellow;">NISN</th>
             <th style="width:100px; border: 2px solid black; text-align: center; background-color: yellow;">Nama</th>
             <th style="width:100px; border: 2px solid black; text-align: center; background-color: yellow;">Kelas</th>
             <th style="width:100px; border: 2px solid black; text-align: center; background-color: yellow;">Berdoa
             </th>
             <th style="width:100px; border: 2px solid black; text-align: center; background-color: yellow;">Memberi
                 Salam
             </th>
             <th style="width:100px; border: 2px solid black; text-align: center; background-color: yellow;">Sholat
                 Berjamaah
             </th>
             <th style="width:100px; border: 2px solid black; text-align: center; background-color: yellow;">Bersyukur
             </th>

         </tr>
     </thead>
     <tbody>
         @foreach ($rapor as $key => $item)
             @php
                 $nilaiArray = json_decode($item->nilai_spiritual, true);
             @endphp
             <tr>
                 <td style="width:50px; border: 2px solid black; text-align: center; ">
                     {{ $key + 1 }}</td>
                 <td style="width:100px; border: 2px solid black; text-align: center; ">
                     {{ $item->rombelsiswas->siswas->nisn }}
                 </td>
                 <td style="width:100px; border: 2px solid black; text-align: center; ">
                     {{ $item->rombelsiswas->siswas->nama }}
                 </td>
                 <td style="width:100px; border: 2px solid black; text-align: center; ">
                     {{ $item->rombelsiswas->rombels->kelass->tingkat }}
                     {{ $item->rombelsiswas->rombels->kelass->nama }}
                     {{ $item->rombelsiswas->rombels->kelass->jurusans->nama }}
                 </td>
                 <td style="width:100px; border: 2px solid black; text-align: center; ">

                     @if (isset($nilaiArray[0]))
                         {{ $nilaiArray[0] }}
                     @else
                         -
                     @endif
                 </td>
                 <td style="width:100px; border: 2px solid black; text-align: center; ">
                     @if (isset($nilaiArray[1]))
                         {{ $nilaiArray[1] }}
                     @else
                         -
                     @endif
                 </td>
                 <td style="width:100px; border: 2px solid black; text-align: center; ">
                     @if (isset($nilaiArray[2]))
                         {{ $nilaiArray[2] }}
                     @else
                         -
                     @endif
                 </td>
                 <td style="width:100px; border: 2px solid black; text-align: center; ">
                     @if (isset($nilaiArray[3]))
                         {{ $nilaiArray[3] }}
                     @else
                         -
                     @endif
                 </td>

             </tr>
         @endforeach
     </tbody>
 </table>
