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
              $hariGroups = collect();
          @endphp
          @foreach ($jadwalmapel as $key => $jadwal)
              @php
                  // Mengelompokkan data berdasarkan hari

                  $hari1 = $jadwal->id_hari;
                  if (!$hariGroups->has($hari1)) {
                      $hariGroups->put($hari1, collect());
                  }
                  $hariGroups[$hari1]->push($jadwal);

              @endphp
          @endforeach
          @foreach ($hariGroups as $hari1 => $jadwalByDay)
              @php
                  $haridata = App\Models\Hari::find($hari1);
                  $harijumlah = count($jadwalByDay);
                  $printedTimeSlots = []; // Initialize array to keep track of printed time slots
                  $uniqueTimes = $jadwalByDay->unique('id_waktu');
                  $harijumlah = count($uniqueTimes);
              @endphp
              @foreach ($jadwalByDay as $index => $jadwal)
                  @php
                      $timeSlot = $jadwal->waktus->range; // Get the time slot
                  @endphp
                  {{-- Check if the time slot has been printed already --}}
                  @if (!in_array($timeSlot, $printedTimeSlots))
                      <tr>
                          @if ($index === 0)
                              <td style="width:100px  ; border: 2px solid black;" rowspan="{{ $harijumlah }}"
                                  class="btn-secondary">
                                  {{ $haridata->nama }}
                              </td>
                          @endif
                          <td style="width:100px  ; border: 2px solid black;" class="bg-warning">
                              {{ $timeSlot }}
                          </td>
                          {{-- Loop through kelasGroups to display kode guru for each class --}}
                          @foreach ($kelasGroups as $kelas => $jadwalByClass)
                              @php
                                  $kode_guru = ''; // Initialize kode guru as empty string
                                  $kode_mapel = ''; // Initialize kode mapel as empty string
                                  $kode_ruangan = ''; // Initialize kode ruangan as empty string
                              @endphp
                              @foreach ($jadwalByClass as $jadwalKelas)
                                  {{-- Check if the jadwal belongs to the current iteration's class and time slot --}}
                                  @if ($jadwalKelas->waktus->range === $timeSlot && $jadwalKelas->id_hari === $jadwal->id_hari)
                                      {{-- Assign the kode guru if the jadwal belongs to the current iteration's class and time slot --}}
                                      @php
                                          $kode_guru = $jadwalKelas->pengampus->gurus->kode_gr;
                                          $kode_mapel = $jadwalKelas->pengampus->mapels->kode_mapel;
                                          $kode_ruangan = $jadwalKelas->ruangans->kode_ruangan;

                                      @endphp
                                      {{-- Break the inner loop --}}
                                  @break
                              @endif
                          @endforeach
                          {{-- Display the kode guru --}}
                          <td style="width:100px  ; border: 2px solid black;">{{ $kode_guru }}
                          </td>
                          <td style="width:100px  ; border: 2px solid black;">{{ $kode_mapel }}</td>
                          <td style="width:100px  ; border: 2px solid black;">{{ $kode_ruangan }}</td>
                      @endforeach
                  </tr>
                  {{-- Add the printed time slot to the printedTimeSlots array --}}
                  @php
                      $printedTimeSlots[] = $timeSlot;
                  @endphp
              @endif
          @endforeach
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
              <br> Mengetahui <br> Wali Kelas <br> <br> <br><br> @php

                  $users = App\Models\User::where('role', '3')->first();

              @endphp
              {{ $users->name }}
          </div>
      </th>

</table>
