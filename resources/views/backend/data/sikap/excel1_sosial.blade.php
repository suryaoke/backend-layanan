 <table id="datatable" class="table table-bordered">
     <thead>
         <tr>
             <th style="width:100px; border: 2px solid black; text-align: center; background-color: yellow;">No</th>
             <th style="width:100px; border: 2px solid black; text-align: center; background-color: yellow;">NISN</th>
             <th style="width:100px; border: 2px solid black; text-align: center; background-color: yellow;">Nama</th>
             <th style="width:100px; border: 2px solid black; text-align: center; background-color: yellow;">Kelas</th>
             <th style="width:100px; border: 2px solid black; text-align: center; background-color: yellow;">Kode Sosial
             </th>

             <th style="width:100px; border: 2px solid black; text-align: center; background-color: yellow;">Kejujuran
             </th>
             <th style="width:100px; border: 2px solid black; text-align: center; background-color: yellow;">Kedisiplinan
             </th>
             <th style="width:100px; border: 2px solid black; text-align: center; background-color: yellow;">Tanggung
                 Jawab</th>
             <th style="width:100px; border: 2px solid black; text-align: center; background-color: yellow;">Toleransi
             </th>
             <th style="width:100px; border: 2px solid black; text-align: center; background-color: yellow;">Gotong
                 Royong</th>
             <th style="width:100px; border: 2px solid black; text-align: center; background-color: yellow;">Kesantunan
             </th>
             <th style="width:100px; border: 2px solid black; text-align: center; background-color: yellow;">Percaya
                 Diri</th>
         </tr>
     </thead>
     <tbody>
         @foreach ($rapor as $key => $item)
             @php
                 $nilaiArray = json_decode($item->nilai_sosial, true);
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
                     {{ $item->id }}
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
                 <td style="width:100px; border: 2px solid black; text-align: center; ">
                     @if (isset($nilaiArray[4]))
                         {{ $nilaiArray[4] }}
                     @else
                         -
                     @endif
                 </td>
                 <td style="width:100px; border: 2px solid black; text-align: center; ">
                     @if (isset($nilaiArray[5]))
                         {{ $nilaiArray[5] }}
                     @else
                         -
                     @endif
                 </td>
                 <td style="width:100px; border: 2px solid black; text-align: center; ">
                     @if (isset($nilaiArray[6]))
                         {{ $nilaiArray[6] }}
                     @else
                         -
                     @endif
                 </td>



             </tr>
         @endforeach
     </tbody>
 </table>
