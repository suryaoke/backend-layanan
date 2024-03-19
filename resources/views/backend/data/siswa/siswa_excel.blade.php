 <table id="datatable" class="table table-bordered">
     <thead>
         <tr>
             <th colspan="6"
                 style="text-align: center;width:100px  ; border: 2px solid black; text-align: center;font-weight: bold; ">
                 Data Siswa</th>

         </tr>
         <tr>
             <th style="text-align: center; font-weight: bold; width: 40px;">No</th>
             <th style="width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">Nama</th>
             <th style="width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">Nisn</th>
             <th style="width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">JK</th>
             <th style="width:150px  ; border: 2px solid black; text-align: center; font-weight: bold;">TTL</th>
             <th style="width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">Username</th>
         </tr>

     </thead>
     <tbody>
         @foreach ($siswa as $key => $item)
             @php
                 $user = App\Models\User::where('id', $item->id_user)->first();
             @endphp
             <tr>
                 <td style="border: 2px solid black; text-align: center;">
                     {{ $key + 1 }}</td>
                 <td style="width:100px  ; border: 2px solid black;  text-transform: capitalize;"> {{ $item->nama }}
                 </td>
                 <td style="width:100px  ; border: 2px solid black;  text-transform: capitalize;"> {{ $item->nisn }}
                 </td>
                 <td style="width:100px  ; border: 2px solid black;  text-transform: capitalize;"> {{ $item->jk }}
                 </td>
                 <td style="width:150px  ; border: 2px solid black;  text-transform: capitalize;"> {{ $item->tempat }} -
                     {{ $item->tanggal }} </td>
                 <td style="width:100px  ; border: 2px solid black;  ">
                     @if ($item->id_user == 0)
                         <span class="text-danger">Kosong</span>
                     @else
                         {{ $item['users']['username'] }}
                     @endif
                 </td>


             </tr>
         @endforeach
     </tbody>
 </table>
