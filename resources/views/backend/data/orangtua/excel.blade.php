 <table id="datatable" class="table table-bordered">
     <thead>

         <tr>
             <th colspan="6"
                 style="text-align: center;width:100px  ; border: 2px solid black; text-align: center;font-weight: bold; ">
                 Data Orang Tua</th>

         </tr>
         <tr>
             <th style="text-align: center; font-weight: bold; width: 40px;">No</th>
             <th style="width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">Kode Orang Tua
             </th>
             <th style="width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">Nama</th>
             <th style="width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">No HP</th>
             <th style="width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">Username</th>
             <th style="width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">Nama Siswa</th>

         </tr>
     </thead>
     <tbody>

         @foreach ($orangtua as $key => $item)
             <tr>

                 @php
                     $user = App\Models\User::where('id', $item->id_user)->first();
                 @endphp
                 <td style="border: 2px solid black; text-align: center;">
                     {{ $key + 1 }}</td>
                 <td style="width:100px  ; border: 2px solid black;  text-transform: capitalize;">
                     {{ $item->kode_ortu }}
                 </td>
                 <td style="width:100px  ; border: 2px solid black;  text-transform: capitalize;">
                     {{ $item->nama }} </td>
                 <td style="width:100px  ; border: 2px solid black;  text-transform: capitalize;"> {{ $item->no_hp }}
                 </td>
                 <td style="width:100px  ; border: 2px solid black;  ">
                     @if ($item->id_user == 0)
                         <span class="text-danger">Kosong</span>
                     @else
                         {{ $item['users']['username'] }}
                     @endif
                 </td>
                 <td style="width:100px  ; border: 2px solid black;  text-transform: capitalize;">
                     @if ($item->id_siswa == 0)
                         <span class="text-danger">Kosong</span>
                     @else
                         {{ $item['siswas']['nama'] }}
                     @endif
                 </td>

             </tr>
         @endforeach

     </tbody>
 </table>
