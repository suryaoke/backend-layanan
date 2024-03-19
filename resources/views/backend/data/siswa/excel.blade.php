  <table id="datatable" class="table table-sm" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
      <thead>


          <tr>
              <th colspan="21" style="border: 2px solid black; text-align: center; font-weight: bold;">
                  Data Siswa</th>
          </tr>
          <tr>
              <th colspan="21" style="border: 2px solid black; text-align: center; font-weight: bold;">Semester
                  {{ $tahun->semester }} Tahun Ajar {{ $tahun->tahun }} </th>
          </tr>
          <tr>
              <th style="width:40px  ; border: 2px solid black; text-align: center; font-weight: bold;">No</th>
              <th style="width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">Nis</th>
              <th style="width:100px  ; border: 2px solid black; text-align: center; font-weight: bold;">Nisn</th>
              <th style="width:100px  ; border: 2px solid black; text-align: center;font-weight: bold;">Nama</th>
              <th style="width:100px  ; border: 2px solid black; text-align: center;font-weight: bold;">JK</th>
              <th style="width:100px  ; border: 2px solid black; text-align: center;font-weight: bold;">Tempat Lahir
              </th>
              <th style="width:100px  ; border: 2px solid black; text-align: center;font-weight: bold;">Tanggal Lahir
              </th>
              <th style="width:100px  ; border: 2px solid black; text-align: center;">Agama</th>
              <th style="width:100px  ; border: 2px solid black; text-align: center;">Status Keluarga</th>
              <th style="width:100px  ; border: 2px solid black; text-align: center;">Anak Ke</th>
              <th style="width:100px  ; border: 2px solid black; text-align: center;">No Hp</th>
              <th style="width:100px  ; border: 2px solid black; text-align: center;">Alamat Siswa</th>
              <th style="width:100px  ; border: 2px solid black; text-align: center;">Alamat Sekolah</th>
              <th style="width:100px  ; border: 2px solid black; text-align: center;">Nama Ayah</th>
              <th style="width:100px  ; border: 2px solid black; text-align: center;">Nama Ibu</th>
              <th style="width:100px  ; border: 2px solid black; text-align: center;">Pekerjaan Ayah</th>
              <th style="width:100px  ; border: 2px solid black; text-align: center;">Pekerjaan Ibu</th>
              <th style="width:100px  ; border: 2px solid black; text-align: center;">Alamat Orang Tua</th>
              <th style="width:100px  ; border: 2px solid black; text-align: center;">Nama Wali</th>
              <th style="width:100px  ; border: 2px solid black; text-align: center;">Pekerjaan Wali</th>
              <th style="width:100px  ; border: 2px solid black; text-align: center;">Alamat Wali</th>

      </thead>
      <tbody>

          @foreach ($rombelsiswa as $key => $item)
              <tr>
                  <td style="width:40px  ; border: 2px solid black; text-align: center;"> {{ $key + 1 }} </td>
                  <td style="width:100px  ; border: 2px solid black; text-align: center;"> {{ $item->siswas->nis }}
                  </td>
                  <td style="width:100px  ; border: 2px solid black; text-align: center;"> {{ $item->siswas->nisn }}
                  </td>
                  <td style="width:100px  ; border: 2px solid black; text-align: center;"> {{ $item->siswas->nama }}
                  </td>
                  <td style="width:100px  ; border: 2px solid black; text-align: center;">
                      @if ($item->siswas->jk == 'L')
                          Laki - Laki
                      @elseif ($item->siswas->jk == 'P')
                          Perempuan
                      @endif
                  </td>
                  <td style="width:100px  ; border: 2px solid black; text-align: center;"> {{ $item->siswas->tempat }}
                  </td>
                  <td style="width:100px  ; border: 2px solid black; text-align: center;"> {{ $item->siswas->tanggal }}
                  </td>
                  <td style="width:100px  ; border: 2px solid black; text-align: center;"> {{ $item->siswas->agama }}
                  </td>
                  <td style="width:100px  ; border: 2px solid black; text-align: center;">
                      {{ $item->siswas->status_keluarga }}
                  </td>
                  <td style="width:100px  ; border: 2px solid black; text-align: center;"> {{ $item->siswas->anak_ke }}
                  </td>
                  <td style="width:100px  ; border: 2px solid black; text-align: center;"> {{ $item->siswas->no_hp }}
                  </td>
                  <td style="width:100px  ; border: 2px solid black; text-align: center;">
                      {{ $item->siswas->alamat_siswa }}
                  </td>
                  <td style="width:100px  ; border: 2px solid black; text-align: center;">
                      {{ $item->siswas->alamat_sekolah }}
                  </td>
                  <td style="width:100px  ; border: 2px solid black; text-align: center;">
                      {{ $item->siswas->nama_ayah }} </td>
                  <td style="width:100px  ; border: 2px solid black; text-align: center;"> {{ $item->siswas->ibu }}
                  </td>
                  <td style="width:100px  ; border: 2px solid black; text-align: center;">
                      {{ $item->siswas->pekerjaan_ayah }}
                  </td>
                  <td style="width:100px  ; border: 2px solid black; text-align: center;">
                      {{ $item->siswas->pekerjaan_ibu }}
                  </td>
                  <td style="width:100px  ; border: 2px solid black; text-align: center;">
                      {{ $item->siswas->alamat_ortu }}
                  </td>
                  <td style="width:100px  ; border: 2px solid black; text-align: center;">
                      {{ $item->siswas->nama_wali }} </td>
                  <td style="width:100px  ; border: 2px solid black; text-align: center;">
                      {{ $item->siswas->pekerjaan_wali }}
                  </td>
                  <td style="width:100px  ; border: 2px solid black; text-align: center;">
                      {{ $item->siswas->alamat_wali }}
                  </td>
              </tr>
          @endforeach



      </tbody>
  </table>
