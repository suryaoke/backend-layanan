   <table id="datatable" class="table table-sm" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
       <thead>
           <tr>
               <th colspan="7" style="border: 2px solid black; text-align: center; font-weight: bold;">
                   Data Seksi</th>
           </tr>
           <tr>
               <th colspan="7" style="border: 2px solid black; text-align: center; font-weight: bold;">Semester
                   {{ $dataseksi->semesters->semester }} Tahun Ajar {{ $dataseksi->semesters->tahun }} </th>
           </tr>
           <tr>
               <th style="width:40px  ; border: 2px solid black; text-align: center;font-weight: bold;">No</th>
               <th style="width:100px  ; border: 2px solid black; text-align: center;font-weight: bold;">Seksi</th>
               <th style="width:100px  ; border: 2px solid black; text-align: center;font-weight: bold;">Kode</th>
               <th style="width:200px  ; border: 2px solid black; text-align: center;font-weight: bold;">Mata Pelajaran
               </th>
               <th style="width:100px  ; border: 2px solid black; text-align: center;font-weight: bold;"> Guru</th>
               <th style="width:100px  ; border: 2px solid black; text-align: center;font-weight: bold;">Kelas / Rombel
               </th>
               <th style="width:200px  ; border: 2px solid black; text-align: center;font-weight: bold;">Tahun Ajar</th>

       </thead>
       <tbody>
           @foreach ($seksi as $key => $item)
               <tr>
                   <td style="width:40px  ; border: 2px solid black; text-align: center;"> {{ $key + 1 }} </td>
                   <td style="width:100px  ; border: 2px solid black; text-align: center;"> {{ $item->kode_seksi }}
                   </td>
                   <td style="width:100px  ; border: 2px solid black; text-align: center;">
                       {{ $item['jadwalmapels']['pengampus']['kode_pengampu'] }}
                   </td>
                   <td style="width:200px  ; border: 2px solid black; text-align: center;">
                       {{ $item['jadwalmapels']['pengampus']['mapels']['nama'] }}
                   </td>
                   <td style="width:100px  ; border: 2px solid black; text-align: center;">
                       {{ $item['jadwalmapels']['pengampus']['gurus']['nama'] }} </td>
                   <td style="width:100px  ; border: 2px solid black; text-align: center;">
                       {{ $item['rombels']['kelass']['tingkat'] }}
                       {{ $item['rombels']['kelass']['nama'] }}
                       {{ $item['rombels']['kelass']['jurusans']['nama'] }} </td>
                   <td style="width:200px  ; border: 2px solid black; text-align: center;">
                       {{ $item['semesters']['semester'] }} / {{ $item['semesters']['tahun'] }}
                   </td>

               </tr>
           @endforeach

       </tbody>
   </table>
