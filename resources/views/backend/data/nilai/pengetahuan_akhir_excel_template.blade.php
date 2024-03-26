  @php
      $nilaiValues = App\Models\Nilai::where('id_seksi', $id)->where('type_nilai', 2)->first();
  @endphp


  <table id="datatable" class="table table-bordered">
      <thead>

          <tr>
              <th style="width:40px; border: 2px solid black; text-align: center;background-color: yellow;">No</th>
              <th style="width:40px; border: 2px solid black; text-align: center;background-color: yellow;">Kode Siswa</th>
              <th style="width:100px; border: 2px solid black; text-align: center;background-color: yellow;">NISN</th>
              <th style="width:100px; border: 2px solid black; text-align: center;background-color: yellow;">Nama</th>
              <th style="width:100px; border: 2px solid black; text-align: center;background-color: yellow;">Jk</th>
              <th style="width:100px; border: 2px solid black; text-align: center;background-color: yellow;">Kelas</th>
              <th style="width:100px; border: 2px solid black; text-align: center;background-color: yellow;">Nilai</th>


          </tr>
      </thead>
      <tbody>

          @foreach ($rombelsiswa as $key => $item)
              @php
                  $nilai = App\Models\Nilai::where('id_rombelsiswa', $item->id)
                      ->where('type_nilai', 2)
                      ->where('id_seksi', $id)
                      ->first();
              @endphp
              <tr>
                  <td style="width:40px; border: 2px solid black; text-align: center;">{{ $key + 1 }}</td>
                  <td style="width:100px; border: 2px solid black; text-align: center;"> {{ $item->id }} </td>
                  <td style="width:100px; border: 2px solid black; text-align: center;"> {{ $item->siswas->nisn }} </td>
                  <td style="width:100px; border: 2px solid black; text-align: center;"> {{ $item->siswas->nama }} </td>
                  <td style="width:100px; border: 2px solid black; text-align: center;"> {{ $item->siswas->jk }} </td>
                  <td style="width:100px; border: 2px solid black; text-align: center;">
                      {{ $item->rombels->kelass->tingkat }}
                      {{ $item->rombels->kelass->nama }}
                      {{ $item->rombels->kelass->jurusans->nama }}</td>
                  <td style="width:100px; border: 2px solid black; text-align: center;">

                      @if ($nilai)
                          {{ $nilai->nilai_pengetahuan_akhir }}
                      @else
                          0
                      @endif


                  </td>

              </tr>
          @endforeach
      </tbody>
  </table>
