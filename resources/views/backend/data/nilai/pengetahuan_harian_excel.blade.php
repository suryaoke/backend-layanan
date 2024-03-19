 <table id="datatable" class="table table-bordered">
     <thead>
         <tr>
             <th class="whitespace-nowrap">No</th>
             <th class="whitespace-nowrap">NISN</th>
             <th class="whitespace-nowrap">Nama</th>
             <th class="whitespace-nowrap">Jk</th>
             <th class="whitespace-nowrap">Kelas</th>

             @php
                 $dataseksi = $rombelsiswa->first();
                 $phValues = App\Models\Nilai::select('ph')
                     ->where('id_seksi', $id)
                     ->where('type_nilai', 1)
                     ->groupBy('ph')
                     ->get();
             @endphp
             @if ($phValues->count() > 0)
                 @foreach ($phValues as $phItem)
                     <th class="whitespace-nowrap">PH {{ $phItem->ph }}
                      
                     </th>
                 @endforeach
             @else
                 <th class="whitespace-nowrap">PH</th>
             @endif

         </tr>
     </thead>
     <tbody>

         @foreach ($rombelsiswa as $key => $item)
             <tr>
                 <td class="whitespace-nowrap">{{ $key + 1 }}</td>
                 <td class="whitespace-nowrap">{{ $item->siswas->nisn }}</td>
                 <td class="whitespace-nowrap">{{ $item->siswas->nama }}</td>
                 <td class="whitespace-nowrap">{{ $item->siswas->jk }}</td>
                 <td class="whitespace-nowrap">
                     {{ $item->rombels->kelass->tingkat }}
                     {{ $item->rombels->kelass->nama }}
                     {{ $item->rombels->kelass->jurusans->nama }}
                 </td>

                 @if ($phValues->count() > 0)
                     @foreach ($phValues as $phItem)
                         <td class="whitespace-nowrap">
                             @php
                                 $nilai = App\Models\Nilai::where('id_rombelsiswa', $item->id)
                                     ->where('type_nilai', 1)
                                     ->where('ph', $phItem->ph)
                                     ->first();
                             @endphp
                             @if ($nilai)
                                 {{ $nilai->nilai_pengetahuan }}
                             @else
                                 -
                             @endif
                         </td>
                     @endforeach
                 @else
                     <td class="whitespace-nowrap">-</td>
                 @endif
             </tr>
         @endforeach
     </tbody>
 </table>
