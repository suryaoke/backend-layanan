@extends('admin.admin_master')
@section('admin')
    <div class="mb-3 intro-y flex flex-col sm:flex-row items-center mt-8">
        <h1 class="text-lg font-medium mr-auto">
            Nilai Sikap Spiritual Siswa All
        </h1>

    </div>
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card overflow-x-auto">
                        <div class="card-body">
                            <table id="datatable" class="table table-sm"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th style="white-space: nowrap;">No</th>
                                        <th style="white-space: nowrap;">Nisn</th>
                                        <th style="white-space: nowrap;">Nama</th>
                                        <th style="white-space: nowrap;">Kelas</th>
                                        <th style="white-space: nowrap;">Jk</th>
                                        <th style="white-space: nowrap;">Berdoa</th>
                                        <th style="white-space: nowrap;">Memberi Salam</th>
                                        <th style="white-space: nowrap;">Shalat Berjamaah</th>

                                        <th style="white-space: nowrap;">Bersyukur</th>

                                        <th style="white-space: nowrap;">Action</th>
                                </thead>
                                <tbody>
                                    @if ($walas)
                                        @foreach ($siswa as $key => $item)
                                            @php
                                                $nilaispiritual = App\Models\Nilaispiritual::where('id_siswa', $item->id)->first();
                                                $rombelsiswa = App\Models\Rombelsiswa::where('id_siswa', $item->id)->first();
                                                $rombel = App\Models\Rombel::where('id', $rombelsiswa->id_rombel)->first();
                                                $kelas = App\Models\Kelas::where('id', $rombel->id_kelas)->first();
                                            @endphp
                                            <tr>
                                                <td style="white-space: nowrap;"> {{ $key + 1 }} </td>

                                                <td style="white-space: nowrap;"> {{ $item->nisn }} </td>
                                                <td style="white-space: nowrap;"> {{ $item->nama }} </td>
                                                <td style="white-space: nowrap;"> {{ $kelas->tingkat }}{{ $kelas->nama }}
                                                    {{ $kelas['jurusans']['nama'] }} </td>
                                                <td style="white-space: nowrap;"> {{ $item->jk }} </td>
                                                {{--  <td style="white-space: nowrap;">
                                                    @if ($nilaispiritual)
                                                        @php
                                                            $nilaiArray = json_decode($nilaispiritual->nilai, true);
                                                        @endphp
                                                        @if (isset($nilaiArray[0]))
                                                            @php
                                                                $keterangan = [
                                                                    'A' => 'Baik Sekali',
                                                                    'B' => 'Baik',
                                                                    'C' => 'Cukup Baik',
                                                                    'D' => 'Kurang Baik',
                                                                ];
                                                            @endphp
                                                            @if (isset($keterangan[$nilaiArray[0]]))
                                                                {{ $nilaiArray[0] }} -
                                                                {{ $keterangan[$nilaiArray[0]] }}
                                                            @else
                                                                -
                                                            @endif
                                                        @else
                                                            -
                                                        @endif
                                                    @else
                                                        -
                                                    @endif
                                                </td>  --}}
                                                <td>
                                                    @if ($nilaispiritual)
                                                        @php
                                                            $nilaiArray = json_decode($nilaispiritual->nilai, true);
                                                        @endphp
                                                        @if (isset($nilaiArray[0]))
                                                            {{ $nilaiArray[0] }}
                                                        @else
                                                            -
                                                        @endif
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($nilaispiritual)
                                                        @php
                                                            $nilaiArray = json_decode($nilaispiritual->nilai, true);
                                                        @endphp
                                                        @if (isset($nilaiArray[1]))
                                                            {{ $nilaiArray[1] }}
                                                        @else
                                                            -
                                                        @endif
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($nilaispiritual)
                                                        @php
                                                            $nilaiArray = json_decode($nilaispiritual->nilai, true);
                                                        @endphp
                                                        @if (isset($nilaiArray[2]))
                                                            {{ $nilaiArray[2] }}
                                                        @else
                                                            -
                                                        @endif
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($nilaispiritual)
                                                        @php
                                                            $nilaiArray = json_decode($nilaispiritual->nilai, true);
                                                        @endphp
                                                        @if (isset($nilaiArray[3]))
                                                            {{ $nilaiArray[3] }}
                                                        @else
                                                            -
                                                        @endif
                                                    @else
                                                        -
                                                    @endif
                                                </td>

                                                <td style="white-space: nowrap;">
                                                    @if ($nilaispiritual)
                                                        <a class="btn btn-success mr-1 mb-2"
                                                            data-tw-target="#edit-nilaispiritual-{{ $item->id }}"
                                                            data-tw-toggle="modal">
                                                            <i data-lucide="edit" class="w-4 h-4"></i>
                                                        </a>
                                                    @else
                                                        <a class="btn btn-success mr-1 mb-2"
                                                            data-tw-target="#add-nilaispiritual-{{ $item->id }}"
                                                            data-tw-toggle="modal">
                                                            <i data-lucide="edit" class="w-4 h-4"></i>
                                                        </a>
                                                    @endif

                                                </td>

                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>

                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->


    <!--  Modal Add Nilaispiritual All Content -->
    @if ($walas)
        @foreach ($siswa as $item)
            {{--  @php
                $walas = App\Models\Walas::where('id_kelas', $item->kelas)->first();
            @endphp  --}}
            <!-- BEGIN: Modal Kirim Jadwal All-->
            <div id="add-nilaispiritual-{{ $item->id }}" class="modal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <form method="post" action="{{ route('nilaispiritual.store') }}"
                        onkeydown="return event.key != 'Enter';">
                        @csrf
                        <div class="modal-content">
                            <!-- BEGIN: Modal Header -->
                            <div class="modal-header">
                                <h2 class="font-medium text-base mr-auto">Nilai Sosial {{ $item->nama }} /
                                    {{ $item->nisn }}</h2>
                                <div class="dropdown sm:hidden"> <a class="dropdown-toggle w-5 h-5 block"
                                        href="javascript:;" aria-expanded="false" data-tw-toggle="dropdown"> <i
                                            data-lucide="more-horizontal" class="w-5 h-5 text-slate-500"></i> </a>

                                </div>
                            </div> <!-- END: Modal Header -->
                            <!-- BEGIN: Modal Body -->
                            <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">

                                <input type="hidden" name="id_siswa" value="{{ $item->id }}">
                                <input type="hidden" name="id_walas" value="{{ $walas->id }}">

                                <div class="col-span-12 sm:col-span-6">
                                    <label for="modal-form-1" class="form-label">Berdoa</label>
                                    <select name="nilai_berdoa" class="tom-select w-full" required>
                                        <option value="A">A - Baik Sekali</option>
                                        <option value="B">B - Baik</option>
                                        <option value="C">C - Cukup Baik</option>
                                        <option value="D">D - Kurang Baik</option>
                                    </select>
                                </div>

                                <div class="col-span-12 sm:col-span-6">
                                    <label for="modal-form-2" class="form-label">Memberi Salam</label>
                                    <select name="nilai_memberisalam" class="tom-select w-full" required>
                                        <option value="A">A - Baik Sekali</option>
                                        <option value="B">B - Baik</option>
                                        <option value="C">C - Cukup Baik</option>
                                        <option value="D">D - Kurang Baik</option>
                                    </select>
                                </div>

                                <div class="col-span-12 sm:col-span-6"> <label for="modal-form-3" class="form-label">Shalat
                                        Berjamaah</label> <select name="nilai_shalatberjamaah" class="tom-select w-full"
                                        required>
                                        <option value="A">A - Baik Sekali</option>
                                        <option value="B">B - Baik</option>
                                        <option value="C">C - Cukup Baik</option>
                                        <option value="D">D - Kurang Baik</option>
                                    </select> </div>

                                <div class="col-span-12 sm:col-span-6"> <label for="modal-form-4"
                                        class="form-label">Bersyukur</label> <select name="nilai_bersyukur"
                                        class="tom-select w-full" required>
                                        <option value="A">A - Baik Sekali</option>
                                        <option value="B">B - Baik</option>
                                        <option value="C">C - Cukup Baik</option>
                                        <option value="D">D - Kurang Baik</option>
                                    </select> </div>


                            </div>
                            <!-- END: Modal Body -->
                            <!-- BEGIN: Modal Footer -->
                            <div class="modal-footer"> <button type="button" data-tw-dismiss="modal"
                                    class="btn btn-outline-secondary w-20 mr-1">Cancel</button> <button type="submit"
                                    class="btn btn-primary w-20">Save</button> </div> <!-- END: Modal Footer -->

                        </div>
                    </form>

                </div>
            </div>
        @endforeach
    @endif
    <!-- END: Modal Add Nilaispiritual All Content -->

    <!--  Modal edit nilaispiritual All Content -->
    @if ($walas)
        @foreach ($siswa as $item)
            @php
                $nilaispiritual = App\Models\Nilaispiritual::where('id_siswa', $item->id)->first();
            @endphp
            <!-- BEGIN: Modal Kirim Jadwal All-->
            <div id="edit-nilaispiritual-{{ $item->id }}" class="modal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <form method="post" action="{{ route('nilaispiritual.update') }}"
                        onkeydown="return event.key != 'Enter';">
                        @csrf
                        <div class="modal-content">
                            <!-- BEGIN: Modal Header -->
                            <div class="modal-header">
                                <h2 class="font-medium text-base mr-auto">Nilai Sosial {{ $item->nama }} /
                                    {{ $item->nisn }} </h2>
                                <div class="dropdown sm:hidden"> <a class="dropdown-toggle w-5 h-5 block"
                                        href="javascript:;" aria-expanded="false" data-tw-toggle="dropdown"> <i
                                            data-lucide="more-horizontal" class="w-5 h-5 text-slate-500"></i> </a>

                                </div>
                            </div> <!-- END: Modal Header -->
                            <!-- BEGIN: Modal Body -->
                            <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">

                                @if ($nilaispiritual)
                                    <input type="hidden" name="id" value="{{ $nilaispiritual->id }}">
                                    <input type="hidden" name="id_siswa" value="{{ $nilaispiritual->id_siswa }}">
                                    <input type="hidden" name="id_walas" value="{{ $nilaispiritual->id_walas }}">
                                    <div class="col-span-12 sm:col-span-6">
                                        <label for="modal-form-1" class="form-label">Berdoa</label>
                                        <select name="nilai_berdoa" class="tom-select w-full" required>
                                            <option value="A" @if (
                                                $nilaispiritual &&
                                                    isset(json_decode($nilaispiritual->nilai, true)[0]) &&
                                                    json_decode($nilaispiritual->nilai, true)[0] == 'A') selected @endif>A -
                                                Baik
                                                Sekali</option>
                                            <option value="B" @if (
                                                $nilaispiritual &&
                                                    isset(json_decode($nilaispiritual->nilai, true)[0]) &&
                                                    json_decode($nilaispiritual->nilai, true)[0] == 'B') selected @endif>B -
                                                Baik
                                            </option>
                                            <option value="C" @if (
                                                $nilaispiritual &&
                                                    isset(json_decode($nilaispiritual->nilai, true)[0]) &&
                                                    json_decode($nilaispiritual->nilai, true)[0] == 'C') selected @endif>C -
                                                Cukup
                                                Baik</option>
                                            <option value="D" @if (
                                                $nilaispiritual &&
                                                    isset(json_decode($nilaispiritual->nilai, true)[0]) &&
                                                    json_decode($nilaispiritual->nilai, true)[0] == 'D') selected @endif>D -
                                                Kurang Baik</option>
                                        </select>
                                    </div>

                                    <div class="col-span-12 sm:col-span-6">
                                        <label for="modal-form-2" class="form-label">Memberi Salam</label>
                                        <select name="nilai_memberisalam" class="tom-select w-full" required>
                                            <option value="A" @if (
                                                $nilaispiritual &&
                                                    isset(json_decode($nilaispiritual->nilai, true)[1]) &&
                                                    json_decode($nilaispiritual->nilai, true)[1] == 'A') selected @endif>A -
                                                Baik
                                                Sekali</option>
                                            <option value="B" @if (
                                                $nilaispiritual &&
                                                    isset(json_decode($nilaispiritual->nilai, true)[1]) &&
                                                    json_decode($nilaispiritual->nilai, true)[1] == 'B') selected @endif>B -
                                                Baik
                                            </option>
                                            <option value="C" @if (
                                                $nilaispiritual &&
                                                    isset(json_decode($nilaispiritual->nilai, true)[1]) &&
                                                    json_decode($nilaispiritual->nilai, true)[1] == 'C') selected @endif>C -
                                                Cukup
                                                Baik</option>
                                            <option value="D" @if (
                                                $nilaispiritual &&
                                                    isset(json_decode($nilaispiritual->nilai, true)[1]) &&
                                                    json_decode($nilaispiritual->nilai, true)[1] == 'D') selected @endif>D -
                                                Kurang Baik</option>
                                        </select>
                                    </div>
                                    <div class="col-span-12 sm:col-span-6"> <label for="modal-form-3"
                                            class="form-label">Shalat Berjamaah</label> <select
                                            name="nilai_shalatberjamaah" class="tom-select w-full" required>
                                            <option value="A" @if (
                                                $nilaispiritual &&
                                                    isset(json_decode($nilaispiritual->nilai, true)[2]) &&
                                                    json_decode($nilaispiritual->nilai, true)[2] == 'A') selected @endif>A -
                                                Baik
                                                Sekali</option>
                                            <option value="B" @if (
                                                $nilaispiritual &&
                                                    isset(json_decode($nilaispiritual->nilai, true)[2]) &&
                                                    json_decode($nilaispiritual->nilai, true)[2] == 'B') selected @endif>B -
                                                Baik
                                            </option>
                                            <option value="C" @if (
                                                $nilaispiritual &&
                                                    isset(json_decode($nilaispiritual->nilai, true)[2]) &&
                                                    json_decode($nilaispiritual->nilai, true)[2] == 'C') selected @endif>C -
                                                Cukup
                                                Baik</option>
                                            <option value="D" @if (
                                                $nilaispiritual &&
                                                    isset(json_decode($nilaispiritual->nilai, true)[2]) &&
                                                    json_decode($nilaispiritual->nilai, true)[2] == 'D') selected @endif>D -
                                                Kurang Baik</option>
                                        </select> </div>

                                    <div class="col-span-12 sm:col-span-6"> <label for="modal-form-4"
                                            class="form-label">Bersyukur</label> <select name="nilai_bersyukur"
                                            class="tom-select w-full" required>
                                            <option value="A" @if (
                                                $nilaispiritual &&
                                                    isset(json_decode($nilaispiritual->nilai, true)[3]) &&
                                                    json_decode($nilaispiritual->nilai, true)[3] == 'A') selected @endif>A -
                                                Baik
                                                Sekali</option>
                                            <option value="B" @if (
                                                $nilaispiritual &&
                                                    isset(json_decode($nilaispiritual->nilai, true)[3]) &&
                                                    json_decode($nilaispiritual->nilai, true)[3] == 'B') selected @endif>B -
                                                Baik
                                            </option>
                                            <option value="C" @if (
                                                $nilaispiritual &&
                                                    isset(json_decode($nilaispiritual->nilai, true)[3]) &&
                                                    json_decode($nilaispiritual->nilai, true)[3] == 'C') selected @endif>C -
                                                Cukup
                                                Baik</option>
                                            <option value="D" @if (
                                                $nilaispiritual &&
                                                    isset(json_decode($nilaispiritual->nilai, true)[3]) &&
                                                    json_decode($nilaispiritual->nilai, true)[3] == 'D') selected @endif>D -
                                                Kurang Baik</option>
                                        </select> </div>
                                @endif



                            </div>

                            <!-- END: Modal Body -->
                            <!-- BEGIN: Modal Footer -->
                            <div class="modal-footer"> <button type="button" data-tw-dismiss="modal"
                                    class="btn btn-outline-secondary w-20 mr-1">Cancel</button> <button type="submit"
                                    class="btn btn-primary w-20">Save</button> </div> <!-- END: Modal Footer -->

                        </div>
                    </form>

                </div>
            </div>
        @endforeach
    @endif
    <!-- END: Modal edit nilaispiritual All Content -->



@endsection
