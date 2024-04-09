  <table id="datatable1" class="table table-bordered">
      <thead>

          <tr>
              <th></th>
          </tr>
          <tr>
              <th colspan="3" rowspan="4"></th>
          </tr>
          <tr>
              <th colspan="7" style=" text-align: center; font-weight: bold; font-size: 14px;"> JADWAL MATA
                  PELAJARAN </th>
          </tr>
          <tr>
              <th colspan="7" style="text-align: center; font-weight: bold; font-size: 14px;"> MAN 1 Kota Padang</th>

          </tr>
          <tr>
              <th colspan="7" style="text-align: center; font-weight: bold; font-size: 14px;"> Tahun Pelajaran
                  {{ $jadwal['tahun']['tahun'] }} Semester
                  {{ $jadwal['tahun']['semester'] }}
              </th>

          </tr>
          <tr>
              <th></th>
          </tr>
          <tr>
              <th></th>
          </tr>

          <tr>
              <th class="btn-secondary"
                  style="width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">Hari</th>
              <th class="btn-secondary"
                  style="width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">Waktu</th>
              @php
                  $kelasGroups = collect();
              @endphp
              @foreach ($jadwalmapel as $key => $jadwal)
                  @php
                      $kelas = $jadwal->pengampus->kelas;
                      if (!$kelasGroups->has($kelas)) {
                          $kelasGroups->put($kelas, collect());
                      }
                      $kelasGroups[$kelas]->push($jadwal);
                  @endphp
              @endforeach
              @php
                  $kelasGroups = $kelasGroups->sortKeys();
              @endphp
              @foreach ($kelasGroups as $kelas => $jadwalByClass)
                  @php
                      $tingkat = App\Models\Kelas::where('id', $kelas)->first();
                  @endphp
                  <th colspan="3" class="btn-secondary"
                      style="width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                      {{ $tingkat->tingkat }} {{ $tingkat->nama }}
                      {{ $tingkat['jurusans']['nama'] }}
                  </th>
              @endforeach
          </tr>
          <tr>
              <th class="btn-secondary" style="width:100px  ; border: 2px solid black;"></th>
              <th class="btn-secondary" style="width:100px  ; border: 2px solid black;"></th>
              @foreach ($kelasGroups as $kelas => $jadwalByClass)
                  <th style="white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;"
                      class="btn-primary">
                      Kode Guru</th>
                  <th style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;"
                      class="btn-primary">
                      Kode Mapel</th>
                  <th style="white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;"
                      class="btn-primary">
                      Ruangan</th>
              @endforeach
          </tr>
      </thead>
      <tbody>
          @php
              $jumlah = App\Models\Kelas::whereExists(function ($query) {
                  $query
                      ->select(DB::raw(1))
                      ->from('pengampus')
                      ->join('jadwalmapels', 'jadwalmapels.id_pengampu', '=', 'pengampus.id')
                      ->whereRaw('pengampus.kelas = kelas.id');
              })
                  ->orderBy('id', 'desc')
                  ->count();

              $j = 3; // Inisialisasi $j di sini
              if ($jadwal) {
                  $j = 3 * $jumlah;
              }
          @endphp
          {{--  
                        // hari senin  --}}

          // hari senin --}}

          @foreach ($hari->where('kode_hari', 'H01') as $key => $itemhari)
              <tr>

                  <td rowspan="20"
                      style="background-color: rgb(187,191,195); width:100px; border: 2px solid black; text-align: center; font-weight: bold; vertical-align: middle;">
                      <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                          {{ $itemhari->nama }}
                      </div>
                  </td>


                  <td
                      style="white-space: nowrap;background-color: rgb(187,191,195);width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                      07:00 - 08:00</td>
                  <td colspan="{{ $j }}"
                      style="background-color: yellow;width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                      UPACARA</td>
              </tr>
              <tr>
                  <td
                      style="white-space: nowrap;background-color: rgb(187,191,195);width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                      08:00 - 08:40</td>

                  @foreach ($kelasGroups as $kelas => $jadwalByClass)
                      @php
                          $kode_guru = ''; // Initialize kode guru as empty string
                          $kode_mapel = ''; // Initialize kode mapel as empty string
                          $kode_ruangan = ''; // Initialize kode ruangan as empty string

                      @endphp
                      @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                          @php
                              $waktu1 = explode('-', $jadwalKelas->id_waktu);
                              $start_time = $waktu1[0];
                              $end_time = $waktu1[1];

                              // Check if the desired time range falls within the id_waktu range
                              $desired_start_time = '08:00';
                              $desired_end_time = '08:40';
                              $time_within_range = $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                              if ($time_within_range) {
                                  $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                  $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                  $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                              }
                          @endphp
                      @endforeach
                      {{-- Display the kode guru --}}
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_guru }}
                      </td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_mapel }}</td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_ruangan }}</td>
                  @endforeach
              </tr>

              <tr>
                  <td
                      style="white-space: nowrap;background-color: rgb(187,191,195);width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                      08:40 - 09:20</td>
                  @foreach ($kelasGroups as $kelas => $jadwalByClass)
                      @php
                          $kode_guru = ''; // Initialize kode guru as empty string
                          $kode_mapel = ''; // Initialize kode mapel as empty string
                          $kode_ruangan = ''; // Initialize kode ruangan as empty string

                      @endphp
                      @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                          @php
                              $waktu1 = explode('-', $jadwalKelas->id_waktu);
                              $start_time = $waktu1[0];
                              $end_time = $waktu1[1];

                              // Check if the desired time range falls within the id_waktu range
                              $desired_start_time = '08:40';
                              $desired_end_time = '09:20';
                              $time_within_range = $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                              if ($time_within_range) {
                                  $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                  $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                  $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                              }
                          @endphp
                      @endforeach
                      {{-- Display the kode guru --}}
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_guru }}
                      </td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_mapel }}</td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_ruangan }}</td>
                  @endforeach
              </tr>

              <tr>
                  <td
                      style="white-space: nowrap;background-color: rgb(187,191,195);width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                      09:20 - 10:00</td>
                  @foreach ($kelasGroups as $kelas => $jadwalByClass)
                      @php
                          $kode_guru = ''; // Initialize kode guru as empty string
                          $kode_mapel = ''; // Initialize kode mapel as empty string
                          $kode_ruangan = ''; // Initialize kode ruangan as empty string

                      @endphp
                      @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                          @php
                              $waktu1 = explode('-', $jadwalKelas->id_waktu);
                              $start_time = $waktu1[0];
                              $end_time = $waktu1[1];

                              // Check if the desired time range falls within the id_waktu range
                              $desired_start_time = '09:20';
                              $desired_end_time = '10:00';
                              $time_within_range = $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                              if ($time_within_range) {
                                  $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                  $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                  $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                              }
                          @endphp
                      @endforeach
                      {{-- Display the kode guru --}}
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_guru }}
                      </td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_mapel }}</td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_ruangan }}</td>
                  @endforeach
              </tr>

              <tr>
                  <td
                      style="white-space: nowrap;background-color: rgb(187,191,195);width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                      10:00 - 10:20</td>


                  <td colspan="{{ $j }}"
                      style="background-color: yellow;width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                      ISTIRAHAT</td>
              </tr>

              <tr>
                  <td
                      style="white-space: nowrap;background-color: rgb(187,191,195);width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                      10:20 - 10:40</td>
                  @foreach ($kelasGroups as $kelas => $jadwalByClass)
                      @php
                          $kode_guru = ''; // Initialize kode guru as empty string
                          $kode_mapel = ''; // Initialize kode mapel as empty string
                          $kode_ruangan = ''; // Initialize kode ruangan as empty string

                      @endphp
                      @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                          @php
                              $waktu1 = explode('-', $jadwalKelas->id_waktu);
                              $start_time = $waktu1[0];
                              $end_time = $waktu1[1];

                              // Check if the desired time range falls within the id_waktu range
                              $desired_start_time = '10:20';
                              $desired_end_time = '10:40';
                              $time_within_range = $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                              if ($time_within_range) {
                                  $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                  $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                  $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                              }
                          @endphp
                      @endforeach
                      {{-- Display the kode guru --}}
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_guru }}
                      </td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_mapel }}</td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_ruangan }}</td>
                  @endforeach
              </tr>
              <tr>
                  <td
                      style="white-space: nowrap;background-color: rgb(187,191,195);width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                      10:40 - 11:00</td>
                  @foreach ($kelasGroups as $kelas => $jadwalByClass)
                      @php
                          $kode_guru = ''; // Initialize kode guru as empty string
                          $kode_mapel = ''; // Initialize kode mapel as empty string
                          $kode_ruangan = ''; // Initialize kode ruangan as empty string

                      @endphp
                      @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                          @php
                              $waktu1 = explode('-', $jadwalKelas->id_waktu);
                              $start_time = $waktu1[0];
                              $end_time = $waktu1[1];

                              // Check if the desired time range falls within the id_waktu range
                              $desired_start_time = '10:40';
                              $desired_end_time = '11:00';
                              $time_within_range = $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                              if ($time_within_range) {
                                  $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                  $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                  $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                              }
                          @endphp
                      @endforeach
                      {{-- Display the kode guru --}}
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_guru }}
                      </td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_mapel }}</td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_ruangan }}</td>
                  @endforeach
              </tr>
              <tr>
                  <td
                      style="white-space: nowrap;background-color: rgb(187,191,195);width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                      11:00 - 11:20</td>
                  @foreach ($kelasGroups as $kelas => $jadwalByClass)
                      @php
                          $kode_guru = ''; // Initialize kode guru as empty string
                          $kode_mapel = ''; // Initialize kode mapel as empty string
                          $kode_ruangan = ''; // Initialize kode ruangan as empty string

                      @endphp
                      @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                          @php
                              $waktu1 = explode('-', $jadwalKelas->id_waktu);
                              $start_time = $waktu1[0];
                              $end_time = $waktu1[1];

                              // Check if the desired time range falls within the id_waktu range
                              $desired_start_time = '11:00';
                              $desired_end_time = '11:20';
                              $time_within_range = $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                              if ($time_within_range) {
                                  $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                  $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                  $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                              }
                          @endphp
                      @endforeach
                      {{-- Display the kode guru --}}
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_guru }}
                      </td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_mapel }}</td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_ruangan }}</td>
                  @endforeach
              </tr>
              <tr>
                  <td
                      style="white-space: nowrap;background-color: rgb(187,191,195);width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                      11:20 - 11:40</td>
                  @foreach ($kelasGroups as $kelas => $jadwalByClass)
                      @php
                          $kode_guru = ''; // Initialize kode guru as empty string
                          $kode_mapel = ''; // Initialize kode mapel as empty string
                          $kode_ruangan = ''; // Initialize kode ruangan as empty string

                      @endphp
                      @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                          @php
                              $waktu1 = explode('-', $jadwalKelas->id_waktu);
                              $start_time = $waktu1[0];
                              $end_time = $waktu1[1];

                              // Check if the desired time range falls within the id_waktu range
                              $desired_start_time = '11:20';
                              $desired_end_time = '11:40';
                              $time_within_range = $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                              if ($time_within_range) {
                                  $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                  $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                  $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                              }
                          @endphp
                      @endforeach
                      {{-- Display the kode guru --}}
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_guru }}
                      </td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_mapel }}</td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_ruangan }}</td>
                  @endforeach
              </tr>
              <tr>
                  <td
                      style="white-space: nowrap;background-color: rgb(187,191,195);width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                      11:40 - 12:00</td>
                  @foreach ($kelasGroups as $kelas => $jadwalByClass)
                      @php
                          $kode_guru = ''; // Initialize kode guru as empty string
                          $kode_mapel = ''; // Initialize kode mapel as empty string
                          $kode_ruangan = ''; // Initialize kode ruangan as empty string

                      @endphp
                      @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                          @php
                              $waktu1 = explode('-', $jadwalKelas->id_waktu);
                              $start_time = $waktu1[0];
                              $end_time = $waktu1[1];

                              // Check if the desired time range falls within the id_waktu range
                              $desired_start_time = '11:40';
                              $desired_end_time = '12:00';
                              $time_within_range = $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                              if ($time_within_range) {
                                  $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                  $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                  $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                              }
                          @endphp
                      @endforeach
                      {{-- Display the kode guru --}}
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_guru }}
                      </td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_mapel }}</td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_ruangan }}</td>
                  @endforeach
              </tr>
              <tr>
                  <td
                      style="white-space: nowrap;background-color: rgb(187,191,195);width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                      12:00 - 12:20</td>
                  @foreach ($kelasGroups as $kelas => $jadwalByClass)
                      @php
                          $kode_guru = ''; // Initialize kode guru as empty string
                          $kode_mapel = ''; // Initialize kode mapel as empty string
                          $kode_ruangan = ''; // Initialize kode ruangan as empty string

                      @endphp
                      @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                          @php
                              $waktu1 = explode('-', $jadwalKelas->id_waktu);
                              $start_time = $waktu1[0];
                              $end_time = $waktu1[1];

                              // Check if the desired time range falls within the id_waktu range
                              $desired_start_time = '12:00';
                              $desired_end_time = '12:20';
                              $time_within_range = $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                              if ($time_within_range) {
                                  $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                  $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                  $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                              }
                          @endphp
                      @endforeach
                      {{-- Display the kode guru --}}
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_guru }}
                      </td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_mapel }}</td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_ruangan }}</td>
                  @endforeach
              </tr>
              <tr>
                  <td
                      style="white-space: nowrap;background-color: rgb(187,191,195);width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                      12:20 - 13:00</td>

                  <td colspan="{{ $j }}"
                      style="background-color: yellow;width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                      ISTIRAHAT</td>
              </tr>
              <tr>
                  <td
                      style="white-space: nowrap;background-color: rgb(187,191,195);width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                      13:00 - 13:20</td>
                  @foreach ($kelasGroups as $kelas => $jadwalByClass)
                      @php
                          $kode_guru = ''; // Initialize kode guru as empty string
                          $kode_mapel = ''; // Initialize kode mapel as empty string
                          $kode_ruangan = ''; // Initialize kode ruangan as empty string

                      @endphp
                      @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                          @php
                              $waktu1 = explode('-', $jadwalKelas->id_waktu);
                              $start_time = $waktu1[0];
                              $end_time = $waktu1[1];

                              // Check if the desired time range falls within the id_waktu range
                              $desired_start_time = '13:00';
                              $desired_end_time = '13:20';
                              $time_within_range = $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                              if ($time_within_range) {
                                  $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                  $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                  $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                              }
                          @endphp
                      @endforeach
                      {{-- Display the kode guru --}}
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_guru }}
                      </td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_mapel }}</td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_ruangan }}</td>
                  @endforeach
              </tr>
              <tr>
                  <td
                      style="white-space: nowrap;background-color: rgb(187,191,195);width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                      13:20 - 13:40</td>
                  @foreach ($kelasGroups as $kelas => $jadwalByClass)
                      @php
                          $kode_guru = ''; // Initialize kode guru as empty string
                          $kode_mapel = ''; // Initialize kode mapel as empty string
                          $kode_ruangan = ''; // Initialize kode ruangan as empty string

                      @endphp
                      @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                          @php
                              $waktu1 = explode('-', $jadwalKelas->id_waktu);
                              $start_time = $waktu1[0];
                              $end_time = $waktu1[1];

                              // Check if the desired time range falls within the id_waktu range
                              $desired_start_time = '13:20';
                              $desired_end_time = '13:40';
                              $time_within_range = $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                              if ($time_within_range) {
                                  $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                  $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                  $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                              }
                          @endphp
                      @endforeach
                      {{-- Display the kode guru --}}
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_guru }}
                      </td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_mapel }}</td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_ruangan }}</td>
                  @endforeach
              </tr>
              <tr>
                  <td
                      style="white-space: nowrap;background-color: rgb(187,191,195);width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                      13:40 - 14:00</td>
                  @foreach ($kelasGroups as $kelas => $jadwalByClass)
                      @php
                          $kode_guru = ''; // Initialize kode guru as empty string
                          $kode_mapel = ''; // Initialize kode mapel as empty string
                          $kode_ruangan = ''; // Initialize kode ruangan as empty string

                      @endphp
                      @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                          @php
                              $waktu1 = explode('-', $jadwalKelas->id_waktu);
                              $start_time = $waktu1[0];
                              $end_time = $waktu1[1];

                              // Check if the desired time range falls within the id_waktu range
                              $desired_start_time = '13:40';
                              $desired_end_time = '14:00';
                              $time_within_range = $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                              if ($time_within_range) {
                                  $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                  $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                  $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                              }
                          @endphp
                      @endforeach
                      {{-- Display the kode guru --}}
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_guru }}
                      </td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_mapel }}</td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_ruangan }}</td>
                  @endforeach
              </tr>
              <tr>
                  <td
                      style="white-space: nowrap;background-color: rgb(187,191,195);width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                      14:00 - 14:20</td>
                  @foreach ($kelasGroups as $kelas => $jadwalByClass)
                      @php
                          $kode_guru = ''; // Initialize kode guru as empty string
                          $kode_mapel = ''; // Initialize kode mapel as empty string
                          $kode_ruangan = ''; // Initialize kode ruangan as empty string

                      @endphp
                      @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                          @php
                              $waktu1 = explode('-', $jadwalKelas->id_waktu);
                              $start_time = $waktu1[0];
                              $end_time = $waktu1[1];

                              // Check if the desired time range falls within the id_waktu range
                              $desired_start_time = '14:00';
                              $desired_end_time = '14:20';
                              $time_within_range = $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                              if ($time_within_range) {
                                  $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                  $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                  $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                              }
                          @endphp
                      @endforeach
                      {{-- Display the kode guru --}}
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_guru }}
                      </td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_mapel }}</td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_ruangan }}</td>
                  @endforeach
              </tr>
              <tr>
                  <td
                      style="white-space: nowrap;background-color: rgb(187,191,195);width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                      14:20 - 14:40</td>
                  @foreach ($kelasGroups as $kelas => $jadwalByClass)
                      @php
                          $kode_guru = ''; // Initialize kode guru as empty string
                          $kode_mapel = ''; // Initialize kode mapel as empty string
                          $kode_ruangan = ''; // Initialize kode ruangan as empty string

                      @endphp
                      @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                          @php
                              $waktu1 = explode('-', $jadwalKelas->id_waktu);
                              $start_time = $waktu1[0];
                              $end_time = $waktu1[1];

                              // Check if the desired time range falls within the id_waktu range
                              $desired_start_time = '14:20';
                              $desired_end_time = '14:40';
                              $time_within_range = $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                              if ($time_within_range) {
                                  $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                  $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                  $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                              }
                          @endphp
                      @endforeach
                      {{-- Display the kode guru --}}
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_guru }}
                      </td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_mapel }}</td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_ruangan }}</td>
                  @endforeach
              </tr>
              <tr>
                  <td
                      style="white-space: nowrap;background-color: rgb(187,191,195);width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                      14:40 - 15:00</td>
                  @foreach ($kelasGroups as $kelas => $jadwalByClass)
                      @php
                          $kode_guru = ''; // Initialize kode guru as empty string
                          $kode_mapel = ''; // Initialize kode mapel as empty string
                          $kode_ruangan = ''; // Initialize kode ruangan as empty string

                      @endphp
                      @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                          @php
                              $waktu1 = explode('-', $jadwalKelas->id_waktu);
                              $start_time = $waktu1[0];
                              $end_time = $waktu1[1];

                              // Check if the desired time range falls within the id_waktu range
                              $desired_start_time = '14:40';
                              $desired_end_time = '15:00';
                              $time_within_range = $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                              if ($time_within_range) {
                                  $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                  $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                  $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                              }
                          @endphp
                      @endforeach
                      {{-- Display the kode guru --}}
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_guru }}
                      </td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_mapel }}</td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_ruangan }}</td>
                  @endforeach
              </tr>
              <tr>
                  <td
                      style="white-space: nowrap;background-color: rgb(187,191,195);width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                      15:00 - 15:20</td>
                  @foreach ($kelasGroups as $kelas => $jadwalByClass)
                      @php
                          $kode_guru = ''; // Initialize kode guru as empty string
                          $kode_mapel = ''; // Initialize kode mapel as empty string
                          $kode_ruangan = ''; // Initialize kode ruangan as empty string

                      @endphp
                      @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                          @php
                              $waktu1 = explode('-', $jadwalKelas->id_waktu);
                              $start_time = $waktu1[0];
                              $end_time = $waktu1[1];

                              // Check if the desired time range falls within the id_waktu range
                              $desired_start_time = '15:00';
                              $desired_end_time = '15:20';
                              $time_within_range = $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                              if ($time_within_range) {
                                  $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                  $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                  $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                              }
                          @endphp
                      @endforeach
                      {{-- Display the kode guru --}}
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_guru }}
                      </td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_mapel }}</td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_ruangan }}</td>
                  @endforeach
              </tr>
              <tr>
                  <td
                      style="white-space: nowrap;background-color: rgb(187,191,195);width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                      15:20 - 15:40</td>
                  @foreach ($kelasGroups as $kelas => $jadwalByClass)
                      @php
                          $kode_guru = ''; // Initialize kode guru as empty string
                          $kode_mapel = ''; // Initialize kode mapel as empty string
                          $kode_ruangan = ''; // Initialize kode ruangan as empty string

                      @endphp
                      @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                          @php
                              $waktu1 = explode('-', $jadwalKelas->id_waktu);
                              $start_time = $waktu1[0];
                              $end_time = $waktu1[1];

                              // Check if the desired time range falls within the id_waktu range
                              $desired_start_time = '15:20';
                              $desired_end_time = '15:40';
                              $time_within_range = $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                              if ($time_within_range) {
                                  $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                  $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                  $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                              }
                          @endphp
                      @endforeach
                      {{-- Display the kode guru --}}
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_guru }}
                      </td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_mapel }}</td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_ruangan }}</td>
                  @endforeach
              </tr>
          @endforeach
          {{--  // hari selasa //  --}}

          @foreach ($hari->where('kode_hari', 'H02') as $key => $itemhari)
              <tr>
                  <td rowspan="20"
                      style="background-color: rgb(187,191,195); width:100px; border: 2px solid black; text-align: center; font-weight: bold; vertical-align: middle;">
                      <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                          {{ $itemhari->nama }}
                      </div>
                  </td>


                  <td
                      style="white-space: nowrap;background-color: rgb(187,191,195);width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                      07:00 - 07:40</td>

                  @foreach ($kelasGroups as $kelas => $jadwalByClass)
                      @php
                          $kode_guru = ''; // Initialize kode guru as empty string
                          $kode_mapel = ''; // Initialize kode mapel as empty string
                          $kode_ruangan = ''; // Initialize kode ruangan as empty string

                      @endphp
                      @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                          @php
                              $waktu1 = explode('-', $jadwalKelas->id_waktu);
                              $start_time = $waktu1[0];
                              $end_time = $waktu1[1];

                              // Check if the desired time range falls within the id_waktu range
                              $desired_start_time = '07:00';
                              $desired_end_time = '07:40';
                              $time_within_range = $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                              if ($time_within_range) {
                                  $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                  $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                  $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                              }
                          @endphp
                      @endforeach
                      {{-- Display the kode guru --}}
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_guru }}
                      </td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_mapel }}</td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_ruangan }}</td>
                  @endforeach
              </tr>

              <tr>

                  <td
                      style="white-space: nowrap;background-color: rgb(187,191,195);width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                      07:40 - 08:20</td>

                  @foreach ($kelasGroups as $kelas => $jadwalByClass)
                      @php
                          $kode_guru = ''; // Initialize kode guru as empty string
                          $kode_mapel = ''; // Initialize kode mapel as empty string
                          $kode_ruangan = ''; // Initialize kode ruangan as empty string

                      @endphp
                      @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                          @php
                              $waktu1 = explode('-', $jadwalKelas->id_waktu);
                              $start_time = $waktu1[0];
                              $end_time = $waktu1[1];

                              // Check if the desired time range falls within the id_waktu range
                              $desired_start_time = '07:40';
                              $desired_end_time = '08:20';
                              $time_within_range = $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                              if ($time_within_range) {
                                  $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                  $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                  $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                              }
                          @endphp
                      @endforeach
                      {{-- Display the kode guru --}}
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_guru }}
                      </td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_mapel }}</td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_ruangan }}</td>
                  @endforeach
              </tr>

              <tr>

                  <td
                      style="white-space: nowrap;background-color: rgb(187,191,195);width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                      08:20 - 09:00</td>

                  @foreach ($kelasGroups as $kelas => $jadwalByClass)
                      @php
                          $kode_guru = ''; // Initialize kode guru as empty string
                          $kode_mapel = ''; // Initialize kode mapel as empty string
                          $kode_ruangan = ''; // Initialize kode ruangan as empty string

                      @endphp
                      @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                          @php
                              $waktu1 = explode('-', $jadwalKelas->id_waktu);
                              $start_time = $waktu1[0];
                              $end_time = $waktu1[1];

                              // Check if the desired time range falls within the id_waktu range
                              $desired_start_time = '08:20';
                              $desired_end_time = '09:00';
                              $time_within_range = $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                              if ($time_within_range) {
                                  $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                  $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                  $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                              }
                          @endphp
                      @endforeach
                      {{-- Display the kode guru --}}
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_guru }}
                      </td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_mapel }}</td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_ruangan }}</td>
                  @endforeach
              </tr>


              <tr>

                  <td
                      style="white-space: nowrap;background-color: rgb(187,191,195);width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                      09:00 - 09:40</td>

                  @foreach ($kelasGroups as $kelas => $jadwalByClass)
                      @php
                          $kode_guru = ''; // Initialize kode guru as empty string
                          $kode_mapel = ''; // Initialize kode mapel as empty string
                          $kode_ruangan = ''; // Initialize kode ruangan as empty string

                      @endphp
                      @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                          @php
                              $waktu1 = explode('-', $jadwalKelas->id_waktu);
                              $start_time = $waktu1[0];
                              $end_time = $waktu1[1];

                              // Check if the desired time range falls within the id_waktu range
                              $desired_start_time = '09:00';
                              $desired_end_time = '09:40';
                              $time_within_range = $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                              if ($time_within_range) {
                                  $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                  $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                  $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                              }
                          @endphp
                      @endforeach
                      {{-- Display the kode guru --}}
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_guru }}
                      </td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_mapel }}</td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_ruangan }}</td>
                  @endforeach
              </tr>

              <tr>

                  <td
                      style="white-space: nowrap;background-color: rgb(187,191,195);width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                      09:40 - 10:00</td>

                  @foreach ($kelasGroups as $kelas => $jadwalByClass)
                      @php
                          $kode_guru = ''; // Initialize kode guru as empty string
                          $kode_mapel = ''; // Initialize kode mapel as empty string
                          $kode_ruangan = ''; // Initialize kode ruangan as empty string

                      @endphp
                      @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                          @php
                              $waktu1 = explode('-', $jadwalKelas->id_waktu);
                              $start_time = $waktu1[0];
                              $end_time = $waktu1[1];

                              // Check if the desired time range falls within the id_waktu range
                              $desired_start_time = '09:40';
                              $desired_end_time = '10:00';
                              $time_within_range = $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                              if ($time_within_range) {
                                  $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                  $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                  $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                              }
                          @endphp
                      @endforeach
                      {{-- Display the kode guru --}}
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_guru }}
                      </td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_mapel }}</td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_ruangan }}</td>
                  @endforeach
              </tr>

              <tr>
                  <td
                      style="white-space: nowrap;background-color: rgb(187,191,195);width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                      10:00 - 10:20</td>

                  <td colspan="{{ $j }}"
                      style="background-color: yellow;width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                      ISTIRAHAT</td>
              </tr>

              <tr>

                  <td
                      style="white-space: nowrap;background-color: rgb(187,191,195);width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                      10:20 - 10:40</td>

                  @foreach ($kelasGroups as $kelas => $jadwalByClass)
                      @php
                          $kode_guru = ''; // Initialize kode guru as empty string
                          $kode_mapel = ''; // Initialize kode mapel as empty string
                          $kode_ruangan = ''; // Initialize kode ruangan as empty string

                      @endphp
                      @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                          @php
                              $waktu1 = explode('-', $jadwalKelas->id_waktu);
                              $start_time = $waktu1[0];
                              $end_time = $waktu1[1];

                              // Check if the desired time range falls within the id_waktu range
                              $desired_start_time = '10:20';
                              $desired_end_time = '10:40';
                              $time_within_range = $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                              if ($time_within_range) {
                                  $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                  $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                  $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                              }
                          @endphp
                      @endforeach
                      {{-- Display the kode guru --}}
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_guru }}
                      </td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_mapel }}</td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_ruangan }}</td>
                  @endforeach
              </tr>

              <tr>

                  <td
                      style="white-space: nowrap;background-color: rgb(187,191,195);width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                      10:40 - 11:00</td>

                  @foreach ($kelasGroups as $kelas => $jadwalByClass)
                      @php
                          $kode_guru = ''; // Initialize kode guru as empty string
                          $kode_mapel = ''; // Initialize kode mapel as empty string
                          $kode_ruangan = ''; // Initialize kode ruangan as empty string

                      @endphp
                      @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                          @php
                              $waktu1 = explode('-', $jadwalKelas->id_waktu);
                              $start_time = $waktu1[0];
                              $end_time = $waktu1[1];

                              // Check if the desired time range falls within the id_waktu range
                              $desired_start_time = '10:40';
                              $desired_end_time = '11:00';
                              $time_within_range = $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                              if ($time_within_range) {
                                  $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                  $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                  $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                              }
                          @endphp
                      @endforeach
                      {{-- Display the kode guru --}}
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_guru }}
                      </td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_mapel }}</td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_ruangan }}</td>
                  @endforeach
              </tr>

              <tr>

                  <td
                      style="white-space: nowrap;background-color: rgb(187,191,195);width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                      11:00 - 11:20</td>

                  @foreach ($kelasGroups as $kelas => $jadwalByClass)
                      @php
                          $kode_guru = ''; // Initialize kode guru as empty string
                          $kode_mapel = ''; // Initialize kode mapel as empty string
                          $kode_ruangan = ''; // Initialize kode ruangan as empty string

                      @endphp
                      @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                          @php
                              $waktu1 = explode('-', $jadwalKelas->id_waktu);
                              $start_time = $waktu1[0];
                              $end_time = $waktu1[1];

                              // Check if the desired time range falls within the id_waktu range
                              $desired_start_time = '11:00';
                              $desired_end_time = '11:20';
                              $time_within_range = $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                              if ($time_within_range) {
                                  $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                  $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                  $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                              }
                          @endphp
                      @endforeach
                      {{-- Display the kode guru --}}
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_guru }}
                      </td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_mapel }}</td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_ruangan }}</td>
                  @endforeach
              </tr>
              <tr>

                  <td
                      style="white-space: nowrap;background-color: rgb(187,191,195);width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                      11:20 - 11:40</td>

                  @foreach ($kelasGroups as $kelas => $jadwalByClass)
                      @php
                          $kode_guru = ''; // Initialize kode guru as empty string
                          $kode_mapel = ''; // Initialize kode mapel as empty string
                          $kode_ruangan = ''; // Initialize kode ruangan as empty string

                      @endphp
                      @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                          @php
                              $waktu1 = explode('-', $jadwalKelas->id_waktu);
                              $start_time = $waktu1[0];
                              $end_time = $waktu1[1];

                              // Check if the desired time range falls within the id_waktu range
                              $desired_start_time = '11:20';
                              $desired_end_time = '11:40';
                              $time_within_range = $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                              if ($time_within_range) {
                                  $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                  $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                  $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                              }
                          @endphp
                      @endforeach
                      {{-- Display the kode guru --}}
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_guru }}
                      </td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_mapel }}</td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_ruangan }}</td>
                  @endforeach
              </tr>

              <tr>

                  <td
                      style="white-space: nowrap;background-color: rgb(187,191,195);width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                      11:40 - 12:00</td>

                  @foreach ($kelasGroups as $kelas => $jadwalByClass)
                      @php
                          $kode_guru = ''; // Initialize kode guru as empty string
                          $kode_mapel = ''; // Initialize kode mapel as empty string
                          $kode_ruangan = ''; // Initialize kode ruangan as empty string

                      @endphp
                      @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                          @php
                              $waktu1 = explode('-', $jadwalKelas->id_waktu);
                              $start_time = $waktu1[0];
                              $end_time = $waktu1[1];

                              // Check if the desired time range falls within the id_waktu range
                              $desired_start_time = '11:40';
                              $desired_end_time = '12:00';
                              $time_within_range = $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                              if ($time_within_range) {
                                  $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                  $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                  $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                              }
                          @endphp
                      @endforeach
                      {{-- Display the kode guru --}}
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_guru }}
                      </td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_mapel }}</td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_ruangan }}</td>
                  @endforeach
              </tr>
              <tr>

                  <td
                      style="white-space: nowrap;background-color: rgb(187,191,195);width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                      12:00 - 12:20</td>

                  @foreach ($kelasGroups as $kelas => $jadwalByClass)
                      @php
                          $kode_guru = ''; // Initialize kode guru as empty string
                          $kode_mapel = ''; // Initialize kode mapel as empty string
                          $kode_ruangan = ''; // Initialize kode ruangan as empty string

                      @endphp
                      @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                          @php
                              $waktu1 = explode('-', $jadwalKelas->id_waktu);
                              $start_time = $waktu1[0];
                              $end_time = $waktu1[1];

                              // Check if the desired time range falls within the id_waktu range
                              $desired_start_time = '12:00';
                              $desired_end_time = '12:20';
                              $time_within_range = $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                              if ($time_within_range) {
                                  $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                  $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                  $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                              }
                          @endphp
                      @endforeach
                      {{-- Display the kode guru --}}
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_guru }}
                      </td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_mapel }}</td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_ruangan }}</td>
                  @endforeach
              </tr>


              <tr>
                  <td
                      style="white-space: nowrap;background-color: rgb(187,191,195);width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                      12:20 - 13:00</td>

                  <td colspan="{{ $j }}"
                      style="background-color: yellow;width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                      ISTIRAHAT</td>
              </tr>

              <tr>

                  <td
                      style="white-space: nowrap;background-color: rgb(187,191,195);width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                      13:00 - 13:20</td>

                  @foreach ($kelasGroups as $kelas => $jadwalByClass)
                      @php
                          $kode_guru = ''; // Initialize kode guru as empty string
                          $kode_mapel = ''; // Initialize kode mapel as empty string
                          $kode_ruangan = ''; // Initialize kode ruangan as empty string

                      @endphp
                      @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                          @php
                              $waktu1 = explode('-', $jadwalKelas->id_waktu);
                              $start_time = $waktu1[0];
                              $end_time = $waktu1[1];

                              // Check if the desired time range falls within the id_waktu range
                              $desired_start_time = '13:00';
                              $desired_end_time = '13:20';
                              $time_within_range = $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                              if ($time_within_range) {
                                  $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                  $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                  $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                              }
                          @endphp
                      @endforeach
                      {{-- Display the kode guru --}}
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_guru }}
                      </td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_mapel }}</td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_ruangan }}</td>
                  @endforeach
              </tr>

              <tr>

                  <td
                      style="white-space: nowrap;background-color: rgb(187,191,195);width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                      13:20 - 13:40</td>

                  @foreach ($kelasGroups as $kelas => $jadwalByClass)
                      @php
                          $kode_guru = ''; // Initialize kode guru as empty string
                          $kode_mapel = ''; // Initialize kode mapel as empty string
                          $kode_ruangan = ''; // Initialize kode ruangan as empty string

                      @endphp
                      @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                          @php
                              $waktu1 = explode('-', $jadwalKelas->id_waktu);
                              $start_time = $waktu1[0];
                              $end_time = $waktu1[1];

                              // Check if the desired time range falls within the id_waktu range
                              $desired_start_time = '13:20';
                              $desired_end_time = '13:40';
                              $time_within_range = $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                              if ($time_within_range) {
                                  $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                  $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                  $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                              }
                          @endphp
                      @endforeach
                      {{-- Display the kode guru --}}
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_guru }}
                      </td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_mapel }}</td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_ruangan }}</td>
                  @endforeach
              </tr>

              <tr>

                  <td
                      style="white-space: nowrap;background-color: rgb(187,191,195);width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                      13:40 - 14:00</td>

                  @foreach ($kelasGroups as $kelas => $jadwalByClass)
                      @php
                          $kode_guru = ''; // Initialize kode guru as empty string
                          $kode_mapel = ''; // Initialize kode mapel as empty string
                          $kode_ruangan = ''; // Initialize kode ruangan as empty string

                      @endphp
                      @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                          @php
                              $waktu1 = explode('-', $jadwalKelas->id_waktu);
                              $start_time = $waktu1[0];
                              $end_time = $waktu1[1];

                              // Check if the desired time range falls within the id_waktu range
                              $desired_start_time = '13:40';
                              $desired_end_time = '14:00';
                              $time_within_range = $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                              if ($time_within_range) {
                                  $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                  $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                  $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                              }
                          @endphp
                      @endforeach
                      {{-- Display the kode guru --}}
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_guru }}
                      </td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_mapel }}</td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_ruangan }}</td>
                  @endforeach
              </tr>

              <tr>

                  <td
                      style="white-space: nowrap;background-color: rgb(187,191,195);width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                      14:00 - 14:20</td>

                  @foreach ($kelasGroups as $kelas => $jadwalByClass)
                      @php
                          $kode_guru = ''; // Initialize kode guru as empty string
                          $kode_mapel = ''; // Initialize kode mapel as empty string
                          $kode_ruangan = ''; // Initialize kode ruangan as empty string

                      @endphp
                      @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                          @php
                              $waktu1 = explode('-', $jadwalKelas->id_waktu);
                              $start_time = $waktu1[0];
                              $end_time = $waktu1[1];

                              // Check if the desired time range falls within the id_waktu range
                              $desired_start_time = '14:00';
                              $desired_end_time = '14:20';
                              $time_within_range = $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                              if ($time_within_range) {
                                  $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                  $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                  $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                              }
                          @endphp
                      @endforeach
                      {{-- Display the kode guru --}}
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_guru }}
                      </td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_mapel }}</td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_ruangan }}</td>
                  @endforeach
              </tr>

              <tr>

                  <td
                      style="white-space: nowrap;background-color: rgb(187,191,195);width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                      14:20 - 14:40</td>

                  @foreach ($kelasGroups as $kelas => $jadwalByClass)
                      @php
                          $kode_guru = ''; // Initialize kode guru as empty string
                          $kode_mapel = ''; // Initialize kode mapel as empty string
                          $kode_ruangan = ''; // Initialize kode ruangan as empty string

                      @endphp
                      @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                          @php
                              $waktu1 = explode('-', $jadwalKelas->id_waktu);
                              $start_time = $waktu1[0];
                              $end_time = $waktu1[1];

                              // Check if the desired time range falls within the id_waktu range
                              $desired_start_time = '14:20';
                              $desired_end_time = '14:40';
                              $time_within_range = $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                              if ($time_within_range) {
                                  $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                  $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                  $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                              }
                          @endphp
                      @endforeach
                      {{-- Display the kode guru --}}
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_guru }}
                      </td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_mapel }}</td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_ruangan }}</td>
                  @endforeach
              </tr>
              <tr>

                  <td
                      style="white-space: nowrap;background-color: rgb(187,191,195);width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                      14:40 - 15:00</td>

                  @foreach ($kelasGroups as $kelas => $jadwalByClass)
                      @php
                          $kode_guru = ''; // Initialize kode guru as empty string
                          $kode_mapel = ''; // Initialize kode mapel as empty string
                          $kode_ruangan = ''; // Initialize kode ruangan as empty string

                      @endphp
                      @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                          @php
                              $waktu1 = explode('-', $jadwalKelas->id_waktu);
                              $start_time = $waktu1[0];
                              $end_time = $waktu1[1];

                              // Check if the desired time range falls within the id_waktu range
                              $desired_start_time = '14:40';
                              $desired_end_time = '15:00';
                              $time_within_range = $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                              if ($time_within_range) {
                                  $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                  $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                  $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                              }
                          @endphp
                      @endforeach
                      {{-- Display the kode guru --}}
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_guru }}
                      </td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_mapel }}</td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_ruangan }}</td>
                  @endforeach
              </tr>
              <tr>

                  <td
                      style="white-space: nowrap;background-color: rgb(187,191,195);width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                      15:00 - 15:20</td>

                  @foreach ($kelasGroups as $kelas => $jadwalByClass)
                      @php
                          $kode_guru = ''; // Initialize kode guru as empty string
                          $kode_mapel = ''; // Initialize kode mapel as empty string
                          $kode_ruangan = ''; // Initialize kode ruangan as empty string

                      @endphp
                      @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                          @php
                              $waktu1 = explode('-', $jadwalKelas->id_waktu);
                              $start_time = $waktu1[0];
                              $end_time = $waktu1[1];

                              // Check if the desired time range falls within the id_waktu range
                              $desired_start_time = '15:00';
                              $desired_end_time = '15:20';
                              $time_within_range = $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                              if ($time_within_range) {
                                  $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                  $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                  $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                              }
                          @endphp
                      @endforeach
                      {{-- Display the kode guru --}}
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_guru }}
                      </td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_mapel }}</td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_ruangan }}</td>
                  @endforeach
              </tr>
          @endforeach


          {{--  // hari rabu//  --}}



          @foreach ($hari->where('kode_hari', 'H03') as $key => $itemhari)
              <tr>

                  <td rowspan="18"
                      style="background-color: rgb(187,191,195); width:100px; border: 2px solid black; text-align: center; font-weight: bold; vertical-align: middle;">
                      <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                          {{ $itemhari->nama }}
                      </div>
                  </td>
                  <td
                      style="white-space: nowrap;background-color: rgb(187,191,195);width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                      07:00 - 07:40</td>

                  @foreach ($kelasGroups as $kelas => $jadwalByClass)
                      @php
                          $kode_guru = ''; // Initialize kode guru as empty string
                          $kode_mapel = ''; // Initialize kode mapel as empty string
                          $kode_ruangan = ''; // Initialize kode ruangan as empty string

                      @endphp
                      @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                          @php
                              $waktu1 = explode('-', $jadwalKelas->id_waktu);
                              $start_time = $waktu1[0];
                              $end_time = $waktu1[1];

                              // Check if the desired time range falls within the id_waktu range
                              $desired_start_time = '07:00';
                              $desired_end_time = '07:40';
                              $time_within_range = $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                              if ($time_within_range) {
                                  $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                  $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                  $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                              }
                          @endphp
                      @endforeach
                      {{-- Display the kode guru --}}
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_guru }}
                      </td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_mapel }}</td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_ruangan }}</td>
                  @endforeach
              </tr>

              <tr>

                  <td
                      style="white-space: nowrap;background-color: rgb(187,191,195);width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                      07:40 - 08:20</td>

                  @foreach ($kelasGroups as $kelas => $jadwalByClass)
                      @php
                          $kode_guru = ''; // Initialize kode guru as empty string
                          $kode_mapel = ''; // Initialize kode mapel as empty string
                          $kode_ruangan = ''; // Initialize kode ruangan as empty string

                      @endphp
                      @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                          @php
                              $waktu1 = explode('-', $jadwalKelas->id_waktu);
                              $start_time = $waktu1[0];
                              $end_time = $waktu1[1];

                              // Check if the desired time range falls within the id_waktu range
                              $desired_start_time = '07:40';
                              $desired_end_time = '08:20';
                              $time_within_range = $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                              if ($time_within_range) {
                                  $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                  $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                  $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                              }
                          @endphp
                      @endforeach
                      {{-- Display the kode guru --}}
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_guru }}
                      </td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_mapel }}</td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_ruangan }}</td>
                  @endforeach
              </tr>

              <tr>

                  <td
                      style="white-space: nowrap;background-color: rgb(187,191,195);width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                      08:20 - 09:00</td>

                  @foreach ($kelasGroups as $kelas => $jadwalByClass)
                      @php
                          $kode_guru = ''; // Initialize kode guru as empty string
                          $kode_mapel = ''; // Initialize kode mapel as empty string
                          $kode_ruangan = ''; // Initialize kode ruangan as empty string

                      @endphp
                      @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                          @php
                              $waktu1 = explode('-', $jadwalKelas->id_waktu);
                              $start_time = $waktu1[0];
                              $end_time = $waktu1[1];

                              // Check if the desired time range falls within the id_waktu range
                              $desired_start_time = '08:20';
                              $desired_end_time = '09:00';
                              $time_within_range = $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                              if ($time_within_range) {
                                  $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                  $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                  $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                              }
                          @endphp
                      @endforeach
                      {{-- Display the kode guru --}}
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_guru }}
                      </td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_mapel }}</td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_ruangan }}</td>
                  @endforeach
              </tr>


              <tr>

                  <td
                      style="white-space: nowrap;background-color: rgb(187,191,195);width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                      09:00 - 09:40</td>

                  @foreach ($kelasGroups as $kelas => $jadwalByClass)
                      @php
                          $kode_guru = ''; // Initialize kode guru as empty string
                          $kode_mapel = ''; // Initialize kode mapel as empty string
                          $kode_ruangan = ''; // Initialize kode ruangan as empty string

                      @endphp
                      @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                          @php
                              $waktu1 = explode('-', $jadwalKelas->id_waktu);
                              $start_time = $waktu1[0];
                              $end_time = $waktu1[1];

                              // Check if the desired time range falls within the id_waktu range
                              $desired_start_time = '09:00';
                              $desired_end_time = '09:40';
                              $time_within_range = $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                              if ($time_within_range) {
                                  $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                  $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                  $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                              }
                          @endphp
                      @endforeach
                      {{-- Display the kode guru --}}
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_guru }}
                      </td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_mapel }}</td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_ruangan }}</td>
                  @endforeach
              </tr>

              <tr>

                  <td
                      style="white-space: nowrap;background-color: rgb(187,191,195);width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                      09:40 - 10:00</td>

                  @foreach ($kelasGroups as $kelas => $jadwalByClass)
                      @php
                          $kode_guru = ''; // Initialize kode guru as empty string
                          $kode_mapel = ''; // Initialize kode mapel as empty string
                          $kode_ruangan = ''; // Initialize kode ruangan as empty string

                      @endphp
                      @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                          @php
                              $waktu1 = explode('-', $jadwalKelas->id_waktu);
                              $start_time = $waktu1[0];
                              $end_time = $waktu1[1];

                              // Check if the desired time range falls within the id_waktu range
                              $desired_start_time = '09:40';
                              $desired_end_time = '10:00';
                              $time_within_range = $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                              if ($time_within_range) {
                                  $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                  $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                  $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                              }
                          @endphp
                      @endforeach
                      {{-- Display the kode guru --}}
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_guru }}
                      </td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_mapel }}</td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_ruangan }}</td>
                  @endforeach
              </tr>

              <tr>
                  <td
                      style="white-space: nowrap;background-color: rgb(187,191,195);width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                      10:00 - 10:20</td>

                  <td colspan="{{ $j }}"
                      style="white-space: nowrap;background-color: yellow;width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                      ISTIRAHAT</td>
              </tr>

              <tr>

                  <td
                      style="white-space: nowrap;background-color: rgb(187,191,195);width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                      10:20 - 10:40</td>

                  @foreach ($kelasGroups as $kelas => $jadwalByClass)
                      @php
                          $kode_guru = ''; // Initialize kode guru as empty string
                          $kode_mapel = ''; // Initialize kode mapel as empty string
                          $kode_ruangan = ''; // Initialize kode ruangan as empty string

                      @endphp
                      @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                          @php
                              $waktu1 = explode('-', $jadwalKelas->id_waktu);
                              $start_time = $waktu1[0];
                              $end_time = $waktu1[1];

                              // Check if the desired time range falls within the id_waktu range
                              $desired_start_time = '10:20';
                              $desired_end_time = '10:40';
                              $time_within_range = $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                              if ($time_within_range) {
                                  $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                  $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                  $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                              }
                          @endphp
                      @endforeach
                      {{-- Display the kode guru --}}
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_guru }}
                      </td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_mapel }}</td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_ruangan }}</td>
                  @endforeach
              </tr>

              <tr>

                  <td
                      style="white-space: nowrap;background-color: rgb(187,191,195);width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                      10:40 - 11:00</td>

                  @foreach ($kelasGroups as $kelas => $jadwalByClass)
                      @php
                          $kode_guru = ''; // Initialize kode guru as empty string
                          $kode_mapel = ''; // Initialize kode mapel as empty string
                          $kode_ruangan = ''; // Initialize kode ruangan as empty string

                      @endphp
                      @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                          @php
                              $waktu1 = explode('-', $jadwalKelas->id_waktu);
                              $start_time = $waktu1[0];
                              $end_time = $waktu1[1];

                              // Check if the desired time range falls within the id_waktu range
                              $desired_start_time = '10:40';
                              $desired_end_time = '11:00';
                              $time_within_range = $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                              if ($time_within_range) {
                                  $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                  $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                  $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                              }
                          @endphp
                      @endforeach
                      {{-- Display the kode guru --}}
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_guru }}
                      </td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_mapel }}</td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_ruangan }}</td>
                  @endforeach
              </tr>

              <tr>

                  <td
                      style="white-space: nowrap;background-color: rgb(187,191,195);width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                      11:00 - 11:20</td>

                  @foreach ($kelasGroups as $kelas => $jadwalByClass)
                      @php
                          $kode_guru = ''; // Initialize kode guru as empty string
                          $kode_mapel = ''; // Initialize kode mapel as empty string
                          $kode_ruangan = ''; // Initialize kode ruangan as empty string

                      @endphp
                      @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                          @php
                              $waktu1 = explode('-', $jadwalKelas->id_waktu);
                              $start_time = $waktu1[0];
                              $end_time = $waktu1[1];

                              // Check if the desired time range falls within the id_waktu range
                              $desired_start_time = '11:00';
                              $desired_end_time = '11:20';
                              $time_within_range = $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                              if ($time_within_range) {
                                  $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                  $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                  $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                              }
                          @endphp
                      @endforeach
                      {{-- Display the kode guru --}}
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_guru }}
                      </td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_mapel }}</td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_ruangan }}</td>
                  @endforeach
              </tr>
              <tr>

                  <td
                      style="white-space: nowrap;background-color: rgb(187,191,195);width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                      11:20 - 11:40</td>

                  @foreach ($kelasGroups as $kelas => $jadwalByClass)
                      @php
                          $kode_guru = ''; // Initialize kode guru as empty string
                          $kode_mapel = ''; // Initialize kode mapel as empty string
                          $kode_ruangan = ''; // Initialize kode ruangan as empty string

                      @endphp
                      @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                          @php
                              $waktu1 = explode('-', $jadwalKelas->id_waktu);
                              $start_time = $waktu1[0];
                              $end_time = $waktu1[1];

                              // Check if the desired time range falls within the id_waktu range
                              $desired_start_time = '11:20';
                              $desired_end_time = '11:40';
                              $time_within_range = $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                              if ($time_within_range) {
                                  $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                  $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                  $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                              }
                          @endphp
                      @endforeach
                      {{-- Display the kode guru --}}
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_guru }}
                      </td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_mapel }}</td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_ruangan }}</td>
                  @endforeach
              </tr>

              <tr>

                  <td
                      style="white-space: nowrap;background-color: rgb(187,191,195);width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                      11:40 - 12:00</td>

                  @foreach ($kelasGroups as $kelas => $jadwalByClass)
                      @php
                          $kode_guru = ''; // Initialize kode guru as empty string
                          $kode_mapel = ''; // Initialize kode mapel as empty string
                          $kode_ruangan = ''; // Initialize kode ruangan as empty string

                      @endphp
                      @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                          @php
                              $waktu1 = explode('-', $jadwalKelas->id_waktu);
                              $start_time = $waktu1[0];
                              $end_time = $waktu1[1];

                              // Check if the desired time range falls within the id_waktu range
                              $desired_start_time = '11:40';
                              $desired_end_time = '12:00';
                              $time_within_range = $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                              if ($time_within_range) {
                                  $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                  $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                  $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                              }
                          @endphp
                      @endforeach
                      {{-- Display the kode guru --}}
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_guru }}
                      </td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_mapel }}</td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_ruangan }}</td>
                  @endforeach
              </tr>
              <tr>

                  <td
                      style="white-space: nowrap;background-color: rgb(187,191,195);width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                      12:00 - 12:20</td>

                  @foreach ($kelasGroups as $kelas => $jadwalByClass)
                      @php
                          $kode_guru = ''; // Initialize kode guru as empty string
                          $kode_mapel = ''; // Initialize kode mapel as empty string
                          $kode_ruangan = ''; // Initialize kode ruangan as empty string

                      @endphp
                      @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                          @php
                              $waktu1 = explode('-', $jadwalKelas->id_waktu);
                              $start_time = $waktu1[0];
                              $end_time = $waktu1[1];

                              // Check if the desired time range falls within the id_waktu range
                              $desired_start_time = '12:00';
                              $desired_end_time = '12:20';
                              $time_within_range = $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                              if ($time_within_range) {
                                  $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                  $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                  $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                              }
                          @endphp
                      @endforeach
                      {{-- Display the kode guru --}}
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_guru }}
                      </td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_mapel }}</td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_ruangan }}</td>
                  @endforeach
              </tr>


              <tr>
                  <td
                      style="white-space: nowrap;background-color: rgb(187,191,195);width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                      12:20 - 13:00</td>

                  <td colspan="{{ $j }}"
                      style="white-space: nowrap;background-color: yellow;width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                      ISTIRAHAT</td>
              </tr>

              <tr>

                  <td
                      style="white-space: nowrap;background-color: rgb(187,191,195);width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                      13:00 - 13:20</td>

                  @foreach ($kelasGroups as $kelas => $jadwalByClass)
                      @php
                          $kode_guru = ''; // Initialize kode guru as empty string
                          $kode_mapel = ''; // Initialize kode mapel as empty string
                          $kode_ruangan = ''; // Initialize kode ruangan as empty string

                      @endphp
                      @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                          @php
                              $waktu1 = explode('-', $jadwalKelas->id_waktu);
                              $start_time = $waktu1[0];
                              $end_time = $waktu1[1];

                              // Check if the desired time range falls within the id_waktu range
                              $desired_start_time = '13:00';
                              $desired_end_time = '13:20';
                              $time_within_range = $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                              if ($time_within_range) {
                                  $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                  $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                  $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                              }
                          @endphp
                      @endforeach
                      {{-- Display the kode guru --}}
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_guru }}
                      </td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_mapel }}</td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_ruangan }}</td>
                  @endforeach
              </tr>

              <tr>

                  <td
                      style="white-space: nowrap;background-color: rgb(187,191,195);width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                      13:20 - 13:40</td>

                  @foreach ($kelasGroups as $kelas => $jadwalByClass)
                      @php
                          $kode_guru = ''; // Initialize kode guru as empty string
                          $kode_mapel = ''; // Initialize kode mapel as empty string
                          $kode_ruangan = ''; // Initialize kode ruangan as empty string

                      @endphp
                      @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                          @php
                              $waktu1 = explode('-', $jadwalKelas->id_waktu);
                              $start_time = $waktu1[0];
                              $end_time = $waktu1[1];

                              // Check if the desired time range falls within the id_waktu range
                              $desired_start_time = '13:20';
                              $desired_end_time = '13:40';
                              $time_within_range = $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                              if ($time_within_range) {
                                  $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                  $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                  $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                              }
                          @endphp
                      @endforeach
                      {{-- Display the kode guru --}}
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_guru }}
                      </td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_mapel }}</td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_ruangan }}</td>
                  @endforeach
              </tr>

              <tr>

                  <td
                      style="white-space: nowrap;background-color: rgb(187,191,195);width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                      13:40 - 14:00</td>

                  @foreach ($kelasGroups as $kelas => $jadwalByClass)
                      @php
                          $kode_guru = ''; // Initialize kode guru as empty string
                          $kode_mapel = ''; // Initialize kode mapel as empty string
                          $kode_ruangan = ''; // Initialize kode ruangan as empty string

                      @endphp
                      @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                          @php
                              $waktu1 = explode('-', $jadwalKelas->id_waktu);
                              $start_time = $waktu1[0];
                              $end_time = $waktu1[1];

                              // Check if the desired time range falls within the id_waktu range
                              $desired_start_time = '13:40';
                              $desired_end_time = '14:00';
                              $time_within_range = $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                              if ($time_within_range) {
                                  $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                  $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                  $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                              }
                          @endphp
                      @endforeach
                      {{-- Display the kode guru --}}
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_guru }}
                      </td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_mapel }}</td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_ruangan }}</td>
                  @endforeach
              </tr>

              <tr>

                  <td
                      style="white-space: nowrap;background-color: rgb(187,191,195);width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                      14:00 - 14:20</td>

                  @foreach ($kelasGroups as $kelas => $jadwalByClass)
                      @php
                          $kode_guru = ''; // Initialize kode guru as empty string
                          $kode_mapel = ''; // Initialize kode mapel as empty string
                          $kode_ruangan = ''; // Initialize kode ruangan as empty string

                      @endphp
                      @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                          @php
                              $waktu1 = explode('-', $jadwalKelas->id_waktu);
                              $start_time = $waktu1[0];
                              $end_time = $waktu1[1];

                              // Check if the desired time range falls within the id_waktu range
                              $desired_start_time = '14:00';
                              $desired_end_time = '14:20';
                              $time_within_range = $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                              if ($time_within_range) {
                                  $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                  $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                  $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                              }
                          @endphp
                      @endforeach
                      {{-- Display the kode guru --}}
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_guru }}
                      </td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_mapel }}</td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_ruangan }}</td>
                  @endforeach
              </tr>

              <tr>

                  <td
                      style="white-space: nowrap;background-color: rgb(187,191,195);width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                      14:20 - 14:40</td>

                  @foreach ($kelasGroups as $kelas => $jadwalByClass)
                      @php
                          $kode_guru = ''; // Initialize kode guru as empty string
                          $kode_mapel = ''; // Initialize kode mapel as empty string
                          $kode_ruangan = ''; // Initialize kode ruangan as empty string

                      @endphp
                      @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                          @php
                              $waktu1 = explode('-', $jadwalKelas->id_waktu);
                              $start_time = $waktu1[0];
                              $end_time = $waktu1[1];

                              // Check if the desired time range falls within the id_waktu range
                              $desired_start_time = '14:20';
                              $desired_end_time = '14:40';
                              $time_within_range = $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                              if ($time_within_range) {
                                  $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                  $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                  $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                              }
                          @endphp
                      @endforeach
                      {{-- Display the kode guru --}}
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_guru }}
                      </td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_mapel }}</td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_ruangan }}</td>
                  @endforeach
              </tr>
          @endforeach

          {{--  // Kamis //  --}}

          @foreach ($hari->where('kode_hari', 'H04') as $key => $itemhari)
              <tr>
                  <td rowspan="18"
                      style="background-color: rgb(187,191,195); width:100px; border: 2px solid black; text-align: center; font-weight: bold; vertical-align: middle;">
                      <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                          {{ $itemhari->nama }}
                      </div>
                  </td>
                  <td
                      style="white-space: nowrap;background-color: rgb(187,191,195);width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                      07:00 - 07:40</td>

                  @foreach ($kelasGroups as $kelas => $jadwalByClass)
                      @php
                          $kode_guru = ''; // Initialize kode guru as empty string
                          $kode_mapel = ''; // Initialize kode mapel as empty string
                          $kode_ruangan = ''; // Initialize kode ruangan as empty string

                      @endphp
                      @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                          @php
                              $waktu1 = explode('-', $jadwalKelas->id_waktu);
                              $start_time = $waktu1[0];
                              $end_time = $waktu1[1];

                              // Check if the desired time range falls within the id_waktu range
                              $desired_start_time = '07:00';
                              $desired_end_time = '07:40';
                              $time_within_range = $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                              if ($time_within_range) {
                                  $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                  $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                  $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                              }
                          @endphp
                      @endforeach
                      {{-- Display the kode guru --}}
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_guru }}
                      </td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_mapel }}</td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_ruangan }}</td>
                  @endforeach
              </tr>

              <tr>

                  <td
                      style="white-space: nowrap;background-color: rgb(187,191,195);width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                      07:40 - 08:20</td>

                  @foreach ($kelasGroups as $kelas => $jadwalByClass)
                      @php
                          $kode_guru = ''; // Initialize kode guru as empty string
                          $kode_mapel = ''; // Initialize kode mapel as empty string
                          $kode_ruangan = ''; // Initialize kode ruangan as empty string

                      @endphp
                      @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                          @php
                              $waktu1 = explode('-', $jadwalKelas->id_waktu);
                              $start_time = $waktu1[0];
                              $end_time = $waktu1[1];

                              // Check if the desired time range falls within the id_waktu range
                              $desired_start_time = '07:40';
                              $desired_end_time = '08:20';
                              $time_within_range = $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                              if ($time_within_range) {
                                  $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                  $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                  $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                              }
                          @endphp
                      @endforeach
                      {{-- Display the kode guru --}}
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_guru }}
                      </td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_mapel }}</td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_ruangan }}</td>
                  @endforeach
              </tr>

              <tr>

                  <td
                      style="white-space: nowrap;background-color: rgb(187,191,195);width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                      08:20 - 09:00</td>

                  @foreach ($kelasGroups as $kelas => $jadwalByClass)
                      @php
                          $kode_guru = ''; // Initialize kode guru as empty string
                          $kode_mapel = ''; // Initialize kode mapel as empty string
                          $kode_ruangan = ''; // Initialize kode ruangan as empty string

                      @endphp
                      @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                          @php
                              $waktu1 = explode('-', $jadwalKelas->id_waktu);
                              $start_time = $waktu1[0];
                              $end_time = $waktu1[1];

                              // Check if the desired time range falls within the id_waktu range
                              $desired_start_time = '08:20';
                              $desired_end_time = '09:00';
                              $time_within_range = $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                              if ($time_within_range) {
                                  $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                  $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                  $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                              }
                          @endphp
                      @endforeach
                      {{-- Display the kode guru --}}
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_guru }}
                      </td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_mapel }}</td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_ruangan }}</td>
                  @endforeach
              </tr>


              <tr>

                  <td
                      style="white-space: nowrap;background-color: rgb(187,191,195);width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                      09:00 - 09:40</td>

                  @foreach ($kelasGroups as $kelas => $jadwalByClass)
                      @php
                          $kode_guru = ''; // Initialize kode guru as empty string
                          $kode_mapel = ''; // Initialize kode mapel as empty string
                          $kode_ruangan = ''; // Initialize kode ruangan as empty string

                      @endphp
                      @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                          @php
                              $waktu1 = explode('-', $jadwalKelas->id_waktu);
                              $start_time = $waktu1[0];
                              $end_time = $waktu1[1];

                              // Check if the desired time range falls within the id_waktu range
                              $desired_start_time = '09:00';
                              $desired_end_time = '09:40';
                              $time_within_range = $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                              if ($time_within_range) {
                                  $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                  $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                  $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                              }
                          @endphp
                      @endforeach
                      {{-- Display the kode guru --}}
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_guru }}
                      </td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_mapel }}</td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_ruangan }}</td>
                  @endforeach
              </tr>

              <tr>

                  <td
                      style="white-space: nowrap;background-color: rgb(187,191,195);width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                      09:40 - 10:00</td>

                  @foreach ($kelasGroups as $kelas => $jadwalByClass)
                      @php
                          $kode_guru = ''; // Initialize kode guru as empty string
                          $kode_mapel = ''; // Initialize kode mapel as empty string
                          $kode_ruangan = ''; // Initialize kode ruangan as empty string

                      @endphp
                      @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                          @php
                              $waktu1 = explode('-', $jadwalKelas->id_waktu);
                              $start_time = $waktu1[0];
                              $end_time = $waktu1[1];

                              // Check if the desired time range falls within the id_waktu range
                              $desired_start_time = '09:40';
                              $desired_end_time = '10:00';
                              $time_within_range = $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                              if ($time_within_range) {
                                  $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                  $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                  $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                              }
                          @endphp
                      @endforeach
                      {{-- Display the kode guru --}}
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_guru }}
                      </td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_mapel }}</td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_ruangan }}</td>
                  @endforeach
              </tr>

              <tr>
                  <td
                      style="white-space: nowrap;background-color: rgb(187,191,195);width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                      10:00 - 10:20</td>

                  <td colspan="{{ $j }}"
                      style="white-space: nowrap;background-color: yellow;width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                      ISTIRAHAT</td>
              </tr>

              <tr>

                  <td
                      style="white-space: nowrap;background-color: rgb(187,191,195);width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                      10:20 - 10:40</td>

                  @foreach ($kelasGroups as $kelas => $jadwalByClass)
                      @php
                          $kode_guru = ''; // Initialize kode guru as empty string
                          $kode_mapel = ''; // Initialize kode mapel as empty string
                          $kode_ruangan = ''; // Initialize kode ruangan as empty string

                      @endphp
                      @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                          @php
                              $waktu1 = explode('-', $jadwalKelas->id_waktu);
                              $start_time = $waktu1[0];
                              $end_time = $waktu1[1];

                              // Check if the desired time range falls within the id_waktu range
                              $desired_start_time = '10:20';
                              $desired_end_time = '10:40';
                              $time_within_range = $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                              if ($time_within_range) {
                                  $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                  $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                  $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                              }
                          @endphp
                      @endforeach
                      {{-- Display the kode guru --}}
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_guru }}
                      </td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_mapel }}</td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_ruangan }}</td>
                  @endforeach
              </tr>

              <tr>

                  <td
                      style="white-space: nowrap;background-color: rgb(187,191,195);width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                      10:40 - 11:00</td>

                  @foreach ($kelasGroups as $kelas => $jadwalByClass)
                      @php
                          $kode_guru = ''; // Initialize kode guru as empty string
                          $kode_mapel = ''; // Initialize kode mapel as empty string
                          $kode_ruangan = ''; // Initialize kode ruangan as empty string

                      @endphp
                      @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                          @php
                              $waktu1 = explode('-', $jadwalKelas->id_waktu);
                              $start_time = $waktu1[0];
                              $end_time = $waktu1[1];

                              // Check if the desired time range falls within the id_waktu range
                              $desired_start_time = '10:40';
                              $desired_end_time = '11:00';
                              $time_within_range = $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                              if ($time_within_range) {
                                  $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                  $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                  $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                              }
                          @endphp
                      @endforeach
                      {{-- Display the kode guru --}}
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_guru }}
                      </td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_mapel }}</td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_ruangan }}</td>
                  @endforeach
              </tr>

              <tr>

                  <td
                      style="white-space: nowrap;background-color: rgb(187,191,195);width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                      11:00 - 11:20</td>

                  @foreach ($kelasGroups as $kelas => $jadwalByClass)
                      @php
                          $kode_guru = ''; // Initialize kode guru as empty string
                          $kode_mapel = ''; // Initialize kode mapel as empty string
                          $kode_ruangan = ''; // Initialize kode ruangan as empty string

                      @endphp
                      @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                          @php
                              $waktu1 = explode('-', $jadwalKelas->id_waktu);
                              $start_time = $waktu1[0];
                              $end_time = $waktu1[1];

                              // Check if the desired time range falls within the id_waktu range
                              $desired_start_time = '11:00';
                              $desired_end_time = '11:20';
                              $time_within_range = $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                              if ($time_within_range) {
                                  $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                  $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                  $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                              }
                          @endphp
                      @endforeach
                      {{-- Display the kode guru --}}
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_guru }}
                      </td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_mapel }}</td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_ruangan }}</td>
                  @endforeach
              </tr>
              <tr>

                  <td
                      style="white-space: nowrap;background-color: rgb(187,191,195);width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                      11:20 - 11:40</td>

                  @foreach ($kelasGroups as $kelas => $jadwalByClass)
                      @php
                          $kode_guru = ''; // Initialize kode guru as empty string
                          $kode_mapel = ''; // Initialize kode mapel as empty string
                          $kode_ruangan = ''; // Initialize kode ruangan as empty string

                      @endphp
                      @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                          @php
                              $waktu1 = explode('-', $jadwalKelas->id_waktu);
                              $start_time = $waktu1[0];
                              $end_time = $waktu1[1];

                              // Check if the desired time range falls within the id_waktu range
                              $desired_start_time = '11:20';
                              $desired_end_time = '11:40';
                              $time_within_range = $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                              if ($time_within_range) {
                                  $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                  $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                  $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                              }
                          @endphp
                      @endforeach
                      {{-- Display the kode guru --}}
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_guru }}
                      </td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_mapel }}</td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_ruangan }}</td>
                  @endforeach
              </tr>

              <tr>

                  <td
                      style="white-space: nowrap;background-color: rgb(187,191,195);width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                      11:40 - 12:00</td>

                  @foreach ($kelasGroups as $kelas => $jadwalByClass)
                      @php
                          $kode_guru = ''; // Initialize kode guru as empty string
                          $kode_mapel = ''; // Initialize kode mapel as empty string
                          $kode_ruangan = ''; // Initialize kode ruangan as empty string

                      @endphp
                      @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                          @php
                              $waktu1 = explode('-', $jadwalKelas->id_waktu);
                              $start_time = $waktu1[0];
                              $end_time = $waktu1[1];

                              // Check if the desired time range falls within the id_waktu range
                              $desired_start_time = '11:40';
                              $desired_end_time = '12:00';
                              $time_within_range = $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                              if ($time_within_range) {
                                  $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                  $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                  $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                              }
                          @endphp
                      @endforeach
                      {{-- Display the kode guru --}}
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_guru }}
                      </td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_mapel }}</td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_ruangan }}</td>
                  @endforeach
              </tr>
              <tr>

                  <td
                      style="white-space: nowrap;background-color: rgb(187,191,195);width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                      12:00 - 12:20</td>

                  @foreach ($kelasGroups as $kelas => $jadwalByClass)
                      @php
                          $kode_guru = ''; // Initialize kode guru as empty string
                          $kode_mapel = ''; // Initialize kode mapel as empty string
                          $kode_ruangan = ''; // Initialize kode ruangan as empty string

                      @endphp
                      @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                          @php
                              $waktu1 = explode('-', $jadwalKelas->id_waktu);
                              $start_time = $waktu1[0];
                              $end_time = $waktu1[1];

                              // Check if the desired time range falls within the id_waktu range
                              $desired_start_time = '12:00';
                              $desired_end_time = '12:20';
                              $time_within_range = $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                              if ($time_within_range) {
                                  $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                  $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                  $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                              }
                          @endphp
                      @endforeach
                      {{-- Display the kode guru --}}
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_guru }}
                      </td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_mapel }}</td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_ruangan }}</td>
                  @endforeach
              </tr>


              <tr>
                  <td
                      style="white-space: nowrap;background-color: rgb(187,191,195);width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                      12:20 - 13:00</td>

                  <td colspan="{{ $j }}"
                      style="white-space: nowrap;background-color: yellow;width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                      ISTIRAHAT</td>
              </tr>

              <tr>

                  <td
                      style="white-space: nowrap;background-color: rgb(187,191,195);width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                      13:00 - 13:20</td>

                  @foreach ($kelasGroups as $kelas => $jadwalByClass)
                      @php
                          $kode_guru = ''; // Initialize kode guru as empty string
                          $kode_mapel = ''; // Initialize kode mapel as empty string
                          $kode_ruangan = ''; // Initialize kode ruangan as empty string

                      @endphp
                      @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                          @php
                              $waktu1 = explode('-', $jadwalKelas->id_waktu);
                              $start_time = $waktu1[0];
                              $end_time = $waktu1[1];

                              // Check if the desired time range falls within the id_waktu range
                              $desired_start_time = '13:00';
                              $desired_end_time = '13:20';
                              $time_within_range = $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                              if ($time_within_range) {
                                  $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                  $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                  $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                              }
                          @endphp
                      @endforeach
                      {{-- Display the kode guru --}}
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_guru }}
                      </td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_mapel }}</td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_ruangan }}</td>
                  @endforeach
              </tr>

              <tr>

                  <td
                      style="white-space: nowrap;background-color: rgb(187,191,195);width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                      13:20 - 13:40</td>

                  @foreach ($kelasGroups as $kelas => $jadwalByClass)
                      @php
                          $kode_guru = ''; // Initialize kode guru as empty string
                          $kode_mapel = ''; // Initialize kode mapel as empty string
                          $kode_ruangan = ''; // Initialize kode ruangan as empty string

                      @endphp
                      @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                          @php
                              $waktu1 = explode('-', $jadwalKelas->id_waktu);
                              $start_time = $waktu1[0];
                              $end_time = $waktu1[1];

                              // Check if the desired time range falls within the id_waktu range
                              $desired_start_time = '13:20';
                              $desired_end_time = '13:40';
                              $time_within_range = $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                              if ($time_within_range) {
                                  $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                  $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                  $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                              }
                          @endphp
                      @endforeach
                      {{-- Display the kode guru --}}
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_guru }}
                      </td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_mapel }}</td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_ruangan }}</td>
                  @endforeach
              </tr>

              <tr>

                  <td
                      style="white-space: nowrap;background-color: rgb(187,191,195);width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                      13:40 - 14:00</td>

                  @foreach ($kelasGroups as $kelas => $jadwalByClass)
                      @php
                          $kode_guru = ''; // Initialize kode guru as empty string
                          $kode_mapel = ''; // Initialize kode mapel as empty string
                          $kode_ruangan = ''; // Initialize kode ruangan as empty string

                      @endphp
                      @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                          @php
                              $waktu1 = explode('-', $jadwalKelas->id_waktu);
                              $start_time = $waktu1[0];
                              $end_time = $waktu1[1];

                              // Check if the desired time range falls within the id_waktu range
                              $desired_start_time = '13:40';
                              $desired_end_time = '14:00';
                              $time_within_range = $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                              if ($time_within_range) {
                                  $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                  $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                  $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                              }
                          @endphp
                      @endforeach
                      {{-- Display the kode guru --}}
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_guru }}
                      </td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_mapel }}</td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_ruangan }}</td>
                  @endforeach
              </tr>

              <tr>

                  <td
                      style="white-space: nowrap;background-color: rgb(187,191,195);width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                      14:00 - 14:20</td>

                  @foreach ($kelasGroups as $kelas => $jadwalByClass)
                      @php
                          $kode_guru = ''; // Initialize kode guru as empty string
                          $kode_mapel = ''; // Initialize kode mapel as empty string
                          $kode_ruangan = ''; // Initialize kode ruangan as empty string

                      @endphp
                      @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                          @php
                              $waktu1 = explode('-', $jadwalKelas->id_waktu);
                              $start_time = $waktu1[0];
                              $end_time = $waktu1[1];

                              // Check if the desired time range falls within the id_waktu range
                              $desired_start_time = '14:00';
                              $desired_end_time = '14:20';
                              $time_within_range = $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                              if ($time_within_range) {
                                  $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                  $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                  $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                              }
                          @endphp
                      @endforeach
                      {{-- Display the kode guru --}}
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_guru }}
                      </td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_mapel }}</td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_ruangan }}</td>
                  @endforeach
              </tr>

              <tr>

                  <td
                      style="white-space: nowrap;background-color: rgb(187,191,195);width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                      14:20 - 14:40</td>

                  @foreach ($kelasGroups as $kelas => $jadwalByClass)
                      @php
                          $kode_guru = ''; // Initialize kode guru as empty string
                          $kode_mapel = ''; // Initialize kode mapel as empty string
                          $kode_ruangan = ''; // Initialize kode ruangan as empty string

                      @endphp
                      @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                          @php
                              $waktu1 = explode('-', $jadwalKelas->id_waktu);
                              $start_time = $waktu1[0];
                              $end_time = $waktu1[1];

                              // Check if the desired time range falls within the id_waktu range
                              $desired_start_time = '14:20';
                              $desired_end_time = '14:40';
                              $time_within_range = $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                              if ($time_within_range) {
                                  $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                  $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                  $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                              }
                          @endphp
                      @endforeach
                      {{-- Display the kode guru --}}
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_guru }}
                      </td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_mapel }}</td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_ruangan }}</td>
                  @endforeach
              </tr>
          @endforeach



          {{--  // jumat //  --}}

          @foreach ($hari->where('kode_hari', 'H05') as $key => $itemhari)
              <tr>


                  <td rowspan="18"
                      style="background-color: rgb(187,191,195); width:100px; border: 2px solid black; text-align: center; font-weight: bold; vertical-align: middle;">
                      <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                          {{ $itemhari->nama }}
                      </div>
                  </td>

                  <td
                      style="white-space: nowrap;background-color: rgb(187,191,195);width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                      07:00 - 08:00</td>
                  <td colspan="{{ $j }}"
                      style="white-space: nowrap;background-color: yellow;width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                      KULTUM</td>
              </tr>
              <tr>
                  <td
                      style="white-space: nowrap;background-color: rgb(187,191,195);width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                      08:00 - 08:40</td>

                  @foreach ($kelasGroups as $kelas => $jadwalByClass)
                      @php
                          $kode_guru = ''; // Initialize kode guru as empty string
                          $kode_mapel = ''; // Initialize kode mapel as empty string
                          $kode_ruangan = ''; // Initialize kode ruangan as empty string

                      @endphp
                      @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                          @php
                              $waktu1 = explode('-', $jadwalKelas->id_waktu);
                              $start_time = $waktu1[0];
                              $end_time = $waktu1[1];

                              // Check if the desired time range falls within the id_waktu range
                              $desired_start_time = '08:00';
                              $desired_end_time = '08:40';
                              $time_within_range = $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                              if ($time_within_range) {
                                  $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                  $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                  $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                              }
                          @endphp
                      @endforeach
                      {{-- Display the kode guru --}}
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_guru }}
                      </td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_mapel }}</td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_ruangan }}</td>
                  @endforeach
              </tr>



              <tr>
                  <td
                      style="white-space: nowrap;background-color: rgb(187,191,195);width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                      08:40 - 09:20</td>
                  @foreach ($kelasGroups as $kelas => $jadwalByClass)
                      @php
                          $kode_guru = ''; // Initialize kode guru as empty string
                          $kode_mapel = ''; // Initialize kode mapel as empty string
                          $kode_ruangan = ''; // Initialize kode ruangan as empty string

                      @endphp
                      @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                          @php
                              $waktu1 = explode('-', $jadwalKelas->id_waktu);
                              $start_time = $waktu1[0];
                              $end_time = $waktu1[1];

                              // Check if the desired time range falls within the id_waktu range
                              $desired_start_time = '08:40';
                              $desired_end_time = '09:20';
                              $time_within_range = $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                              if ($time_within_range) {
                                  $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                  $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                  $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                              }
                          @endphp
                      @endforeach
                      {{-- Display the kode guru --}}
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_guru }}
                      </td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_mapel }}</td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_ruangan }}</td>
                  @endforeach
              </tr>

              <tr>
                  <td
                      style="white-space: nowrap;background-color: rgb(187,191,195);width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                      09:20 - 10:00</td>
                  @foreach ($kelasGroups as $kelas => $jadwalByClass)
                      @php
                          $kode_guru = ''; // Initialize kode guru as empty string
                          $kode_mapel = ''; // Initialize kode mapel as empty string
                          $kode_ruangan = ''; // Initialize kode ruangan as empty string

                      @endphp
                      @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                          @php
                              $waktu1 = explode('-', $jadwalKelas->id_waktu);
                              $start_time = $waktu1[0];
                              $end_time = $waktu1[1];

                              // Check if the desired time range falls within the id_waktu range
                              $desired_start_time = '09:20';
                              $desired_end_time = '10:00';
                              $time_within_range = $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                              if ($time_within_range) {
                                  $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                  $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                  $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                              }
                          @endphp
                      @endforeach
                      {{-- Display the kode guru --}}
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_guru }}
                      </td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_mapel }}</td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_ruangan }}</td>
                  @endforeach
              </tr>

              <tr>
                  <td
                      style="white-space: nowrap;background-color: rgb(187,191,195);width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                      10:00 - 10:20</td>

                  <td colspan="{{ $j }}"
                      style="white-space: nowrap;background-color: yellow;width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                      ISTIRAHAT</td>
              </tr>
              <tr>
                  <td
                      style="white-space: nowrap;background-color: rgb(187,191,195);width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                      10:20 - 10:40</td>
                  @foreach ($kelasGroups as $kelas => $jadwalByClass)
                      @php
                          $kode_guru = ''; // Initialize kode guru as empty string
                          $kode_mapel = ''; // Initialize kode mapel as empty string
                          $kode_ruangan = ''; // Initialize kode ruangan as empty string

                      @endphp
                      @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                          @php
                              $waktu1 = explode('-', $jadwalKelas->id_waktu);
                              $start_time = $waktu1[0];
                              $end_time = $waktu1[1];

                              // Check if the desired time range falls within the id_waktu range
                              $desired_start_time = '10:20';
                              $desired_end_time = '10:40';
                              $time_within_range = $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                              if ($time_within_range) {
                                  $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                  $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                  $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                              }
                          @endphp
                      @endforeach
                      {{-- Display the kode guru --}}
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_guru }}
                      </td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_mapel }}</td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_ruangan }}</td>
                  @endforeach
              </tr>
              <tr>
                  <td
                      style="white-space: nowrap;background-color: rgb(187,191,195);width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                      10:40 - 11:00</td>
                  @foreach ($kelasGroups as $kelas => $jadwalByClass)
                      @php
                          $kode_guru = ''; // Initialize kode guru as empty string
                          $kode_mapel = ''; // Initialize kode mapel as empty string
                          $kode_ruangan = ''; // Initialize kode ruangan as empty string

                      @endphp
                      @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                          @php
                              $waktu1 = explode('-', $jadwalKelas->id_waktu);
                              $start_time = $waktu1[0];
                              $end_time = $waktu1[1];

                              // Check if the desired time range falls within the id_waktu range
                              $desired_start_time = '10:40';
                              $desired_end_time = '11:00';
                              $time_within_range = $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                              if ($time_within_range) {
                                  $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                  $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                  $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                              }
                          @endphp
                      @endforeach
                      {{-- Display the kode guru --}}
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_guru }}
                      </td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_mapel }}</td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_ruangan }}</td>
                  @endforeach
              </tr>
              <tr>
                  <td
                      style="white-space: nowrap;background-color: rgb(187,191,195);width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                      11:00 - 11:20</td>
                  @foreach ($kelasGroups as $kelas => $jadwalByClass)
                      @php
                          $kode_guru = ''; // Initialize kode guru as empty string
                          $kode_mapel = ''; // Initialize kode mapel as empty string
                          $kode_ruangan = ''; // Initialize kode ruangan as empty string

                      @endphp
                      @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                          @php
                              $waktu1 = explode('-', $jadwalKelas->id_waktu);
                              $start_time = $waktu1[0];
                              $end_time = $waktu1[1];

                              // Check if the desired time range falls within the id_waktu range
                              $desired_start_time = '11:00';
                              $desired_end_time = '11:20';
                              $time_within_range = $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                              if ($time_within_range) {
                                  $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                  $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                  $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                              }
                          @endphp
                      @endforeach
                      {{-- Display the kode guru --}}
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_guru }}
                      </td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_mapel }}</td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_ruangan }}</td>
                  @endforeach
              </tr>

              <tr>
                  <td
                      style="white-space: nowrap;background-color: rgb(187,191,195);width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                      11:20 - 11:40</td>
                  @foreach ($kelasGroups as $kelas => $jadwalByClass)
                      @php
                          $kode_guru = ''; // Initialize kode guru as empty string
                          $kode_mapel = ''; // Initialize kode mapel as empty string
                          $kode_ruangan = ''; // Initialize kode ruangan as empty string

                      @endphp
                      @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                          @php
                              $waktu1 = explode('-', $jadwalKelas->id_waktu);
                              $start_time = $waktu1[0];
                              $end_time = $waktu1[1];

                              // Check if the desired time range falls within the id_waktu range
                              $desired_start_time = '11:20';
                              $desired_end_time = '11:40';
                              $time_within_range = $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                              if ($time_within_range) {
                                  $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                  $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                  $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                              }
                          @endphp
                      @endforeach
                      {{-- Display the kode guru --}}
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_guru }}
                      </td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_mapel }}</td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_ruangan }}</td>
                  @endforeach
              </tr>

              <tr>
                  <td
                      style="white-space: nowrap;background-color: rgb(187,191,195);width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                      11:40 - 13:20</td>

                  <td colspan="{{ $j }}"
                      style="white-space: nowrap;background-color: yellow;width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                      ISTIRAHAT</td>
              </tr>
              <tr>
                  <td
                      style="white-space: nowrap;background-color: rgb(187,191,195);width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                      13:20 - 13:40</td>
                  @foreach ($kelasGroups as $kelas => $jadwalByClass)
                      @php
                          $kode_guru = ''; // Initialize kode guru as empty string
                          $kode_mapel = ''; // Initialize kode mapel as empty string
                          $kode_ruangan = ''; // Initialize kode ruangan as empty string

                      @endphp
                      @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                          @php
                              $waktu1 = explode('-', $jadwalKelas->id_waktu);
                              $start_time = $waktu1[0];
                              $end_time = $waktu1[1];

                              // Check if the desired time range falls within the id_waktu range
                              $desired_start_time = '13:20';
                              $desired_end_time = '13:40';
                              $time_within_range = $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                              if ($time_within_range) {
                                  $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                  $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                  $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                              }
                          @endphp
                      @endforeach
                      {{-- Display the kode guru --}}
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_guru }}
                      </td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_mapel }}</td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_ruangan }}</td>
                  @endforeach
              </tr>
              <tr>
                  <td
                      style="white-space: nowrap;background-color: rgb(187,191,195);width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                      13:40 - 14:00</td>
                  @foreach ($kelasGroups as $kelas => $jadwalByClass)
                      @php
                          $kode_guru = ''; // Initialize kode guru as empty string
                          $kode_mapel = ''; // Initialize kode mapel as empty string
                          $kode_ruangan = ''; // Initialize kode ruangan as empty string

                      @endphp
                      @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                          @php
                              $waktu1 = explode('-', $jadwalKelas->id_waktu);
                              $start_time = $waktu1[0];
                              $end_time = $waktu1[1];

                              // Check if the desired time range falls within the id_waktu range
                              $desired_start_time = '13:40';
                              $desired_end_time = '14:00';
                              $time_within_range = $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                              if ($time_within_range) {
                                  $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                  $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                  $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                              }
                          @endphp
                      @endforeach
                      {{-- Display the kode guru --}}
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_guru }}
                      </td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_mapel }}</td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_ruangan }}</td>
                  @endforeach
              </tr>

              <tr>
                  <td
                      style="white-space: nowrap;background-color: rgb(187,191,195);width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                      14:00 - 14:20</td>
                  @foreach ($kelasGroups as $kelas => $jadwalByClass)
                      @php
                          $kode_guru = ''; // Initialize kode guru as empty string
                          $kode_mapel = ''; // Initialize kode mapel as empty string
                          $kode_ruangan = ''; // Initialize kode ruangan as empty string

                      @endphp
                      @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                          @php
                              $waktu1 = explode('-', $jadwalKelas->id_waktu);
                              $start_time = $waktu1[0];
                              $end_time = $waktu1[1];

                              // Check if the desired time range falls within the id_waktu range
                              $desired_start_time = '14:00';
                              $desired_end_time = '14:20';
                              $time_within_range = $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                              if ($time_within_range) {
                                  $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                  $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                  $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                              }
                          @endphp
                      @endforeach
                      {{-- Display the kode guru --}}
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_guru }}
                      </td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_mapel }}</td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_ruangan }}</td>
                  @endforeach
              </tr>
              <tr>
                  <td
                      style="white-space: nowrap;background-color: rgb(187,191,195);width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                      14:20 - 14:40</td>
                  @foreach ($kelasGroups as $kelas => $jadwalByClass)
                      @php
                          $kode_guru = ''; // Initialize kode guru as empty string
                          $kode_mapel = ''; // Initialize kode mapel as empty string
                          $kode_ruangan = ''; // Initialize kode ruangan as empty string

                      @endphp
                      @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                          @php
                              $waktu1 = explode('-', $jadwalKelas->id_waktu);
                              $start_time = $waktu1[0];
                              $end_time = $waktu1[1];

                              // Check if the desired time range falls within the id_waktu range
                              $desired_start_time = '14:20';
                              $desired_end_time = '14:40';
                              $time_within_range = $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                              if ($time_within_range) {
                                  $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                  $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                  $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                              }
                          @endphp
                      @endforeach
                      {{-- Display the kode guru --}}
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_guru }}
                      </td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_mapel }}</td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_ruangan }}</td>
                  @endforeach
              </tr>
              <tr>
                  <td
                      style="white-space: nowrap;background-color: rgb(187,191,195);width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                      14:40 - 15:00</td>
                  @foreach ($kelasGroups as $kelas => $jadwalByClass)
                      @php
                          $kode_guru = ''; // Initialize kode guru as empty string
                          $kode_mapel = ''; // Initialize kode mapel as empty string
                          $kode_ruangan = ''; // Initialize kode ruangan as empty string

                      @endphp
                      @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                          @php
                              $waktu1 = explode('-', $jadwalKelas->id_waktu);
                              $start_time = $waktu1[0];
                              $end_time = $waktu1[1];

                              // Check if the desired time range falls within the id_waktu range
                              $desired_start_time = '14:40';
                              $desired_end_time = '15:00';
                              $time_within_range = $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                              if ($time_within_range) {
                                  $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                  $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                  $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                              }
                          @endphp
                      @endforeach
                      {{-- Display the kode guru --}}
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_guru }}
                      </td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_mapel }}</td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_ruangan }}</td>
                  @endforeach
              </tr>
              <tr>
                  <td
                      style="white-space: nowrap;background-color: rgb(187,191,195);width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                      15:00 - 15:20</td>
                  @foreach ($kelasGroups as $kelas => $jadwalByClass)
                      @php
                          $kode_guru = ''; // Initialize kode guru as empty string
                          $kode_mapel = ''; // Initialize kode mapel as empty string
                          $kode_ruangan = ''; // Initialize kode ruangan as empty string

                      @endphp
                      @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                          @php
                              $waktu1 = explode('-', $jadwalKelas->id_waktu);
                              $start_time = $waktu1[0];
                              $end_time = $waktu1[1];

                              // Check if the desired time range falls within the id_waktu range
                              $desired_start_time = '15:00';
                              $desired_end_time = '15:20';
                              $time_within_range = $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                              if ($time_within_range) {
                                  $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                  $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                  $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                              }
                          @endphp
                      @endforeach
                      {{-- Display the kode guru --}}
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_guru }}
                      </td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_mapel }}</td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_ruangan }}</td>
                  @endforeach
              </tr>

              <tr>
                  <td
                      style="white-space: nowrap;background-color: rgb(187,191,195);width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                      15:20 - 15:40</td>
                  @foreach ($kelasGroups as $kelas => $jadwalByClass)
                      @php
                          $kode_guru = ''; // Initialize kode guru as empty string
                          $kode_mapel = ''; // Initialize kode mapel as empty string
                          $kode_ruangan = ''; // Initialize kode ruangan as empty string

                      @endphp
                      @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                          @php
                              $waktu1 = explode('-', $jadwalKelas->id_waktu);
                              $start_time = $waktu1[0];
                              $end_time = $waktu1[1];

                              // Check if the desired time range falls within the id_waktu range
                              $desired_start_time = '15:20';
                              $desired_end_time = '15:40';
                              $time_within_range = $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                              if ($time_within_range) {
                                  $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                  $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                  $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                              }
                          @endphp
                      @endforeach
                      {{-- Display the kode guru --}}
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_guru }}
                      </td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_mapel }}</td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_ruangan }}</td>
                  @endforeach
              </tr>

              <tr>
                  <td
                      style="white-space: nowrap;background-color: rgb(187,191,195);width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                      15:40 - 16:00</td>
                  @foreach ($kelasGroups as $kelas => $jadwalByClass)
                      @php
                          $kode_guru = ''; // Initialize kode guru as empty string
                          $kode_mapel = ''; // Initialize kode mapel as empty string
                          $kode_ruangan = ''; // Initialize kode ruangan as empty string

                      @endphp
                      @foreach ($jadwalByClass->where('id_hari', $itemhari->id) as $jadwalKelas)
                          @php
                              $waktu1 = explode('-', $jadwalKelas->id_waktu);
                              $start_time = $waktu1[0];
                              $end_time = $waktu1[1];

                              // Check if the desired time range falls within the id_waktu range
                              $desired_start_time = '15:40';
                              $desired_end_time = '16:00';
                              $time_within_range = $desired_start_time >= $start_time && $desired_end_time <= $end_time;
                              if ($time_within_range) {
                                  $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                  $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                  $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;
                              }
                          @endphp
                      @endforeach
                      {{-- Display the kode guru --}}
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_guru }}
                      </td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_mapel }}</td>
                      <td
                          style=" white-space: nowrap; width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">
                          {{ $kode_ruangan }}</td>
                  @endforeach
              </tr>
          @endforeach


      </tbody>
  </table>


  <style>
      .left {
          text-align: left;
      }

      .right {
          text-align: right;
      }
  </style>
  @php
      use Carbon\Carbon;
      setlocale(LC_TIME, 'id_ID');
      $tanggalSaatIni = Carbon::now();
      $bulanIndonesia = [
          'Januari',
          'Februari',
          'Maret',
          'April',
          'Mei',
          'Juni',
          'Juli',
          'Agustus',
          'September',
          'Oktober',
          'November',
          'Desember',
      ];
  @endphp

  <table>
      <tr>
          <th colspan="2" rowspan="8" class="left" style="text-transform: capitalize;">
              <div class="">Mengetahui <br> Kepala Sekolah
                  <br>
                  <br><br><br><br>
                  @php
                      $user = App\Models\User::where('role', '2')->first();

                  @endphp
                  {{ $user->name }}
              </div>
          </th>
          <th></th>
          <th></th>
          <th></th>
          <th></th>
          <th></th>

          <th colspan="2" rowspan="8" class="right" style="text-transform: capitalize;">
              <div class="">Padang,
                  {{ $tanggalSaatIni->format('d ') . $bulanIndonesia[$tanggalSaatIni->month - 1] . $tanggalSaatIni->format(' Y') }}
                  <br> Mengetahui <br> Wakil Kurikulum <br> <br> <br><br> @php

                      $users = App\Models\User::where('role', '3')->first();

                  @endphp
                  {{ $users->name }}
              </div>
          </th>

  </table>
