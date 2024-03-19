 <table id="datatable" class="table table-bordered">
     <thead>
         <tr>
             <th colspan="6"
                 style="text-align: center;width:100px  ; border: 2px solid black; text-align: center;font-weight: bold; ">
                 Data Akun Pengguna</th>

         </tr>
         <tr>
             <th style="text-align: center; font-weight: bold; width: 40px;">No</th>
             <th style="width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">Nama</th>
             <th style="width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">Username</th>
             <th style="width:150px  ; border: 2px solid black; text-align: center; font-weight: bold;">Email</th>
             <th style="width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">Role</th>
             <th style="width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">Status</th>

     </thead>
     <tbody>
         @foreach ($user as $key => $item)
             <tr>
                 <td style="border: 2px solid black; text-align: center;">
                     {{ $key + 1 }}</td>
                 <td style="width:100px  ; border: 2px solid black;  text-transform: capitalize;">
                     {{ $item->name }} </td>
                 <td style="width:100px  ; border: 2px solid black;  "> {{ $item->username }}
                 </td>

                 <td style="width:150px  ; border: 2px solid black;  text-transform: capitalize;"> {{ $item->email }}
                 </td>

                 <td style="width:100px  ; border: 2px solid black;  text-transform: capitalize;">
                     @if ($item->role == '1')
                         <span class="text-dark">Admin</span>
                     @elseif($item->role == '2')
                         <span class="text-danger">Kepala Sekolah</span>
                     @elseif($item->role == '3')
                         <span class="text-warning">Wakil Kurikulum</span>
                     @elseif($item->role == '4')
                         <span class="text-success">Guru</span>
                     @elseif($item->role == '5')
                         <span class="text-primary">Orang Tua</span>
                     @elseif($item->role == '6')
                         <span class="text-primary">Siswa</span>
                     @endif

                 </td>

                 <td style="width:100px  ; border: 2px solid black;  text-transform: capitalize;">
                     @if ($item->status == '0')
                         <span class="btn btn-outline-danger">Tidak Aktif</span>
                     @elseif($item->status == '1')
                         <span class="btn btn-outline-success">Aktif</span>
                     @endif
                 </td>


             </tr>
         @endforeach

     </tbody>
 </table>
