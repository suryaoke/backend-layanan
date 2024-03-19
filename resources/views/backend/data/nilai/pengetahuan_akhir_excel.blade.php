  @php
      $nilaiValues = App\Models\Nilai::where('id_seksi', $id)->where('type_nilai', 2)->first();
  @endphp


  <table id="datatable" class="table table-bordered">
      <thead>
          <tr>
              <th class="whitespace-nowrap">No</th>
              <th class="whitespace-nowrap">NISN</th>
              <th class="whitespace-nowrap">Nama</th>
              <th class="whitespace-nowrap">Jk</th>
              <th class="whitespace-nowrap">Kelas</th>
              <th class="whitespace-nowrap">Nilai</th>


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
                  <td class="whitespace-nowrap">{{ $key + 1 }}</td>
                  <td class="whitespace-nowrap"> {{ $item->siswas->nisn }} </td>
                  <td class="whitespace-nowrap"> {{ $item->siswas->nama }} </td>
                  <td class="whitespace-nowrap"> {{ $item->siswas->jk }} </td>
                  <td class="whitespace-nowrap"> {{ $item->rombels->kelass->tingkat }}
                      {{ $item->rombels->kelass->nama }}
                      {{ $item->rombels->kelass->jurusans->nama }}</td>
                  <td class="whitespace-nowrap">

                      @if ($nilai)
                          {{ $nilai->nilai_pengetahuan_akhir }}
                      @else
                          -
                      @endif


                  </td>

              </tr>
          @endforeach
      </tbody>
  </table>
