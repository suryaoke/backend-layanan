  <table id="datatable" class="table table-bordered">
      <thead>
          @php
              $kdValues = App\Models\Nilai::select('kd')
                  ->where('id_seksi', $id)
                  ->where('type_nilai', 3)
                  ->where('type_keterampilan', 1)
                  ->groupBy('kd')
                  ->get();
              $kdValuess = $kdValues->count();
          @endphp
          <tr>
              <th colspan="{{ $kdValuess * 2 + 5 }}"
                  style="border: 2px solid black; text-align: center; font-weight: bold;">
                  Data Nilai Keterampilan Portofolio Siswa</th>
          </tr>
          <tr>
              <th colspan="{{ $kdValuess * 2 + 5 }}"
                  style="border: 2px solid black; text-align: center; font-weight: bold;">
                  Semester
                  {{ $tahun->semester }} Tahun Ajar {{ $tahun->tahun }} </th>
          </tr>
          <tr>
              <th style="width:40px  ; border: 2px solid black; text-align: center;">No</th>
              <th style="width:100px  ; border: 2px solid black; text-align: center;">NISN</th>
              <th style="width:100px  ; border: 2px solid black; text-align: center;">Nama</th>
              <th style="width:100px  ; border: 2px solid black; text-align: center;">Jk</th>
              <th style="width:100px  ; border: 2px solid black; text-align: center;">Kelas</th>

              @if ($kdValues->count() > 0)
                  @foreach ($kdValues as $kdItem)
                      <th style="width:100px  ; border: 2px solid black; text-align: center;">KD {{ $kdItem->kd }}
                      </th>
                      <th style="width:200px  ; border: 2px solid black; text-align: center;">Materi KD
                          {{ $kdItem->kd }}
                      </th>
                  @endforeach
              @else
                  <th style="width:100px  ; border: 2px solid black; text-align: center;">KD</th>
              @endif

          </tr>
      </thead>
      <tbody>

          @foreach ($rombelsiswa as $key => $item)
              <tr>
                  <td style="width:40px  ; border: 2px solid black; text-align: center;">{{ $key + 1 }}</td>
                  <td style="width:100px  ; border: 2px solid black; text-align: center;">{{ $item->siswas->nisn }}</td>
                  <td style="width:100px  ; border: 2px solid black; text-align: center;">{{ $item->siswas->nama }}</td>
                  <td style="width:100px  ; border: 2px solid black; text-align: center;">{{ $item->siswas->jk }}</td>
                  <td style="width:100px  ; border: 2px solid black; text-align: center;">
                      {{ $item->rombels->kelass->tingkat }}
                      {{ $item->rombels->kelass->nama }}
                      {{ $item->rombels->kelass->jurusans->nama }}
                  </td>

                  @if ($kdValues->count() > 0)
                      @foreach ($kdValues as $kdItem)
                          <td style="width:100px  ; border: 2px solid black; text-align: center;">
                              @php
                                  $nilai = App\Models\Nilai::where('id_rombelsiswa', $item->id)
                                      ->where('type_nilai', 3)
                                      ->where('kd', $kdItem->kd)
                                      ->where('type_keterampilan', 1)
                                      ->first();
                              @endphp
                              @if ($nilai)
                                  {{ $nilai->nilai_keterampilan }}
                              @else
                                  -
                              @endif
                          <td style="width2100px  ; border: 2px solid black; text-align: center;">
                              @php
                                  $nilai = App\Models\Nilai::where('id_rombelsiswa', $item->id)
                                      ->where('type_nilai', 3)
                                      ->where('kd', $kdItem->kd)
                                      ->where('type_keterampilan', 1)
                                      ->first();
                              @endphp
                              @if ($nilai)
                                  {{ $nilai->catatan_keterampilan }}
                              @else
                                  -
                              @endif
                          </td>
                      @endforeach
                  @else
                      <td style="width:100px  ; border: 2px solid black; text-align: center;">-</td>
                  @endif
              </tr>
          @endforeach
      </tbody>
  </table>
