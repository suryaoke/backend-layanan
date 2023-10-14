@extends('admin.admin_master')
@section('admin')
    <div class="mb-3 intro-y flex flex-col sm:flex-row items-center mt-8">
        <h1 class="text-lg font-medium mr-auto">
            Nilai Sikap Sosial Siswa All
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
                                        <th style="white-space: nowrap;">Kejujuran</th>
                                        <th style="white-space: nowrap;">Kedisiplinan</th>
                                        <th style="white-space: nowrap;">Tanggung Jawab</th>
                                        <th style="white-space: nowrap;">Toleransi</th>
                                        <th style="white-space: nowrap;">Gotong Royong</th>
                                        <th style="white-space: nowrap;">Kesantunan</th>
                                        <th style="white-space: nowrap;">Percaya Diri</th>

                                        <th style="white-space: nowrap;">Action</th>
                                </thead>
                                <tbody>
                                    @if ($walas)
                                        @foreach ($siswa as $key => $item)
                                            @php
                                                $nilaisosial = App\Models\Nilaisosial::where('id_siswa', $item->id)->first();
                                            @endphp
                                            <tr>
                                                <td style="white-space: nowrap;"> {{ $key + 1 }} </td>

                                                <td style="white-space: nowrap;"> {{ $item->nisn }} </td>
                                                <td style="white-space: nowrap;"> {{ $item->nama }} </td>
                                                <td style="white-space: nowrap;">
                                                    {{ $item['kelass']['tingkat'] }}
                                                    {{ $item['kelass']['nama'] }}
                                                    {{ $item['kelass']['jurusans']['nama'] }}
                                                </td>
                                                <td style="white-space: nowrap;"> {{ $item->jk }} </td>
                                                {{--  <td style="white-space: nowrap;">
                                                    @if ($nilaisosial)
                                                        @php
                                                            $nilaiArray = json_decode($nilaisosial->nilai, true);
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
                                                    @if ($nilaisosial)
                                                        @php
                                                            $nilaiArray = json_decode($nilaisosial->nilai, true);
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
                                                    @if ($nilaisosial)
                                                        @php
                                                            $nilaiArray = json_decode($nilaisosial->nilai, true);
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
                                                    @if ($nilaisosial)
                                                        @php
                                                            $nilaiArray = json_decode($nilaisosial->nilai, true);
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
                                                    @if ($nilaisosial)
                                                        @php
                                                            $nilaiArray = json_decode($nilaisosial->nilai, true);
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
                                                <td>
                                                    @if ($nilaisosial)
                                                        @php
                                                            $nilaiArray = json_decode($nilaisosial->nilai, true);
                                                        @endphp
                                                        @if (isset($nilaiArray[4]))
                                                            {{ $nilaiArray[4] }}
                                                        @else
                                                            -
                                                        @endif
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($nilaisosial)
                                                        @php
                                                            $nilaiArray = json_decode($nilaisosial->nilai, true);
                                                        @endphp
                                                        @if (isset($nilaiArray[5]))
                                                            {{ $nilaiArray[5] }}
                                                        @else
                                                            -
                                                        @endif
                                                    @else
                                                        -
                                                    @endif
                                                </td>

                                                <td>
                                                    @if ($nilaisosial)
                                                        @php
                                                            $nilaiArray = json_decode($nilaisosial->nilai, true);
                                                        @endphp
                                                        @if (isset($nilaiArray[6]))
                                                            {{ $nilaiArray[6] }}
                                                        @else
                                                            -
                                                        @endif
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td style="white-space: nowrap;">
                                                    @if ($nilaisosial)
                                                        <a class="btn btn-success mr-1 mb-2"
                                                            data-tw-target="#edit-nilaisosial-{{ $item->id }}"
                                                            data-tw-toggle="modal">
                                                            <i data-lucide="edit" class="w-4 h-4"></i>
                                                        </a>
                                                    @else
                                                        <a class="btn btn-success mr-1 mb-2"
                                                            data-tw-target="#add-nilaisosial-{{ $item->id }}"
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


    <!--  Modal Add Cttn All Content -->
    @if ($walas)
        @foreach ($siswa as $item)
            @php
                $walas = App\Models\Walas::where('id_kelas', $item->kelas)->first();
            @endphp
            <!-- BEGIN: Modal Kirim Jadwal All-->
            <div id="add-nilaisosial-{{ $item->id }}" class="modal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <form method="post" action="{{ route('nilaisosial.store') }}"
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
                                    <label for="modal-form-1" class="form-label">Kejujuran</label>
                                    <select name="nilai_kejujuran" class="tom-select w-full" required>
                                        <option value="A">A - Baik Sekali</option>
                                        <option value="B">B - Baik</option>
                                        <option value="C">C - Cukup Baik</option>
                                        <option value="D">D - Kurang Baik</option>
                                    </select>
                                </div>

                                <div class="col-span-12 sm:col-span-6">
                                    <label for="modal-form-2" class="form-label">Kedisiplinan</label>
                                    <select name="nilai_kedisiplinan" class="tom-select w-full" required>
                                        <option value="A">A - Baik Sekali</option>
                                        <option value="B">B - Baik</option>
                                        <option value="C">C - Cukup Baik</option>
                                        <option value="D">D - Kurang Baik</option>
                                    </select>
                                </div>

                                <div class="col-span-12 sm:col-span-6"> <label for="modal-form-3"
                                        class="form-label">Tanggung
                                        Jawab</label> <select name="nilai_tanggungjawab" class="tom-select w-full" required>
                                        <option value="A">A - Baik Sekali</option>
                                        <option value="B">B - Baik</option>
                                        <option value="C">C - Cukup Baik</option>
                                        <option value="D">D - Kurang Baik</option>
                                    </select> </div>

                                <div class="col-span-12 sm:col-span-6"> <label for="modal-form-4"
                                        class="form-label">Toleransi</label> <select name="nilai_toleransi"
                                        class="tom-select w-full" required>
                                        <option value="A">A - Baik Sekali</option>
                                        <option value="B">B - Baik</option>
                                        <option value="C">C - Cukup Baik</option>
                                        <option value="D">D - Kurang Baik</option>
                                    </select> </div>

                                <div class="col-span-12 sm:col-span-6"> <label for="modal-form-3"
                                        class="form-label">Gotong
                                        Royong</label> <select name="nilai_gotongroyong" class="tom-select w-full"
                                        required>
                                        <option value="A">A - Baik Sekali</option>
                                        <option value="B">B - Baik</option>
                                        <option value="C">C - Cukup Baik</option>
                                        <option value="D">D - Kurang Baik</option>
                                    </select> </div>

                                <div class="col-span-12 sm:col-span-6"> <label for="modal-form-4"
                                        class="form-label">Kesantunan</label> <select name="nilai_kesantunan"
                                        class="tom-select w-full" required>
                                        <option value="A">A - Baik Sekali</option>
                                        <option value="B">B - Baik</option>
                                        <option value="C">C - Cukup Baik</option>
                                        <option value="D">D - Kurang Baik</option>
                                    </select> </div>

                                <div class="col-span-12 sm:col-span-6"> <label for="modal-form-4"
                                        class="form-label">Percaya
                                        Diri</label> <select name="nilai_percayadiri" class="tom-select w-full" required>
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
    <!-- END: Modal Add Cttn All Content -->

    <!--  Modal edit cttn All Content -->
    @if ($walas)
        @foreach ($siswa as $item)
            @php
                $nilaisosial = App\Models\Nilaisosial::where('id_siswa', $item->id)->first();
            @endphp
            <!-- BEGIN: Modal Kirim Jadwal All-->
            <div id="edit-nilaisosial-{{ $item->id }}" class="modal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <form method="post" action="{{ route('nilaisosial.update') }}"
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

                                @if ($nilaisosial)
                                    <input type="hidden" name="id" value="{{ $nilaisosial->id }}">
                                    <input type="hidden" name="id_siswa" value="{{ $nilaisosial->id_siswa }}">
                                    <input type="hidden" name="id_walas" value="{{ $nilaisosial->id_walas }}">
                                    <div class="col-span-12 sm:col-span-6">
                                        <label for="modal-form-1" class="form-label">Kejujuran</label>
                                        <select name="nilai_kejujuran" class="tom-select w-full" required>
                                            <option value="A" @if (
                                                $nilaisosial &&
                                                    isset(json_decode($nilaisosial->nilai, true)[0]) &&
                                                    json_decode($nilaisosial->nilai, true)[0] == 'A') selected @endif>A -
                                                Baik
                                                Sekali</option>
                                            <option value="B" @if (
                                                $nilaisosial &&
                                                    isset(json_decode($nilaisosial->nilai, true)[0]) &&
                                                    json_decode($nilaisosial->nilai, true)[0] == 'B') selected @endif>B -
                                                Baik
                                            </option>
                                            <option value="C" @if (
                                                $nilaisosial &&
                                                    isset(json_decode($nilaisosial->nilai, true)[0]) &&
                                                    json_decode($nilaisosial->nilai, true)[0] == 'C') selected @endif>C -
                                                Cukup
                                                Baik</option>
                                            <option value="D" @if (
                                                $nilaisosial &&
                                                    isset(json_decode($nilaisosial->nilai, true)[0]) &&
                                                    json_decode($nilaisosial->nilai, true)[0] == 'D') selected @endif>D -
                                                Kurang Baik</option>
                                        </select>
                                    </div>

                                    <div class="col-span-12 sm:col-span-6">
                                        <label for="modal-form-2" class="form-label">Kedisiplinan</label>
                                        <select name="nilai_kedisiplinan" class="tom-select w-full" required>
                                            <option value="A" @if (
                                                $nilaisosial &&
                                                    isset(json_decode($nilaisosial->nilai, true)[1]) &&
                                                    json_decode($nilaisosial->nilai, true)[1] == 'A') selected @endif>A -
                                                Baik
                                                Sekali</option>
                                            <option value="B" @if (
                                                $nilaisosial &&
                                                    isset(json_decode($nilaisosial->nilai, true)[1]) &&
                                                    json_decode($nilaisosial->nilai, true)[1] == 'B') selected @endif>B -
                                                Baik
                                            </option>
                                            <option value="C" @if (
                                                $nilaisosial &&
                                                    isset(json_decode($nilaisosial->nilai, true)[1]) &&
                                                    json_decode($nilaisosial->nilai, true)[1] == 'C') selected @endif>C -
                                                Cukup
                                                Baik</option>
                                            <option value="D" @if (
                                                $nilaisosial &&
                                                    isset(json_decode($nilaisosial->nilai, true)[1]) &&
                                                    json_decode($nilaisosial->nilai, true)[1] == 'D') selected @endif>D -
                                                Kurang Baik</option>
                                        </select>
                                    </div>
                                    <div class="col-span-12 sm:col-span-6"> <label for="modal-form-3"
                                            class="form-label">Tanggung
                                            Jawab</label> <select name="nilai_tanggungjawab" class="tom-select w-full"
                                            required>
                                            <option value="A" @if (
                                                $nilaisosial &&
                                                    isset(json_decode($nilaisosial->nilai, true)[2]) &&
                                                    json_decode($nilaisosial->nilai, true)[2] == 'A') selected @endif>A -
                                                Baik
                                                Sekali</option>
                                            <option value="B" @if (
                                                $nilaisosial &&
                                                    isset(json_decode($nilaisosial->nilai, true)[2]) &&
                                                    json_decode($nilaisosial->nilai, true)[2] == 'B') selected @endif>B -
                                                Baik
                                            </option>
                                            <option value="C" @if (
                                                $nilaisosial &&
                                                    isset(json_decode($nilaisosial->nilai, true)[2]) &&
                                                    json_decode($nilaisosial->nilai, true)[2] == 'C') selected @endif>C -
                                                Cukup
                                                Baik</option>
                                            <option value="D" @if (
                                                $nilaisosial &&
                                                    isset(json_decode($nilaisosial->nilai, true)[2]) &&
                                                    json_decode($nilaisosial->nilai, true)[2] == 'D') selected @endif>D -
                                                Kurang Baik</option>
                                        </select> </div>

                                    <div class="col-span-12 sm:col-span-6"> <label for="modal-form-4"
                                            class="form-label">Toleransi</label> <select name="nilai_toleransi"
                                            class="tom-select w-full" required>
                                            <option value="A" @if (
                                                $nilaisosial &&
                                                    isset(json_decode($nilaisosial->nilai, true)[3]) &&
                                                    json_decode($nilaisosial->nilai, true)[3] == 'A') selected @endif>A -
                                                Baik
                                                Sekali</option>
                                            <option value="B" @if (
                                                $nilaisosial &&
                                                    isset(json_decode($nilaisosial->nilai, true)[3]) &&
                                                    json_decode($nilaisosial->nilai, true)[3] == 'B') selected @endif>B -
                                                Baik
                                            </option>
                                            <option value="C" @if (
                                                $nilaisosial &&
                                                    isset(json_decode($nilaisosial->nilai, true)[3]) &&
                                                    json_decode($nilaisosial->nilai, true)[3] == 'C') selected @endif>C -
                                                Cukup
                                                Baik</option>
                                            <option value="D" @if (
                                                $nilaisosial &&
                                                    isset(json_decode($nilaisosial->nilai, true)[3]) &&
                                                    json_decode($nilaisosial->nilai, true)[3] == 'D') selected @endif>D -
                                                Kurang Baik</option>
                                        </select> </div>

                                    <div class="col-span-12 sm:col-span-6"> <label for="modal-form-3"
                                            class="form-label">Gotong
                                            Royong</label> <select name="nilai_gotongroyong" class="tom-select w-full"
                                            required>
                                            <option value="A" @if (
                                                $nilaisosial &&
                                                    isset(json_decode($nilaisosial->nilai, true)[4]) &&
                                                    json_decode($nilaisosial->nilai, true)[4] == 'A') selected @endif>A -
                                                Baik
                                                Sekali</option>
                                            <option value="B" @if (
                                                $nilaisosial &&
                                                    isset(json_decode($nilaisosial->nilai, true)[4]) &&
                                                    json_decode($nilaisosial->nilai, true)[4] == 'B') selected @endif>B -
                                                Baik
                                            </option>
                                            <option value="C" @if (
                                                $nilaisosial &&
                                                    isset(json_decode($nilaisosial->nilai, true)[4]) &&
                                                    json_decode($nilaisosial->nilai, true)[4] == 'C') selected @endif>C -
                                                Cukup
                                                Baik</option>
                                            <option value="D" @if (
                                                $nilaisosial &&
                                                    isset(json_decode($nilaisosial->nilai, true)[4]) &&
                                                    json_decode($nilaisosial->nilai, true)[4] == 'D') selected @endif>D -
                                                Kurang Baik</option>
                                        </select> </div>

                                    <div class="col-span-12 sm:col-span-6"> <label for="modal-form-4"
                                            class="form-label">Kesantunan</label> <select name="nilai_kesantunan"
                                            class="tom-select w-full" required>
                                            <option value="A" @if (
                                                $nilaisosial &&
                                                    isset(json_decode($nilaisosial->nilai, true)[5]) &&
                                                    json_decode($nilaisosial->nilai, true)[5] == 'A') selected @endif>A -
                                                Baik
                                                Sekali</option>
                                            <option value="B" @if (
                                                $nilaisosial &&
                                                    isset(json_decode($nilaisosial->nilai, true)[5]) &&
                                                    json_decode($nilaisosial->nilai, true)[5] == 'B') selected @endif>B -
                                                Baik
                                            </option>
                                            <option value="C" @if (
                                                $nilaisosial &&
                                                    isset(json_decode($nilaisosial->nilai, true)[5]) &&
                                                    json_decode($nilaisosial->nilai, true)[5] == 'C') selected @endif>C -
                                                Cukup
                                                Baik</option>
                                            <option value="D" @if (
                                                $nilaisosial &&
                                                    isset(json_decode($nilaisosial->nilai, true)[5]) &&
                                                    json_decode($nilaisosial->nilai, true)[5] == 'D') selected @endif>D -
                                                Kurang Baik</option>
                                        </select> </div>

                                    <div class="col-span-12 sm:col-span-6"> <label for="modal-form-4"
                                            class="form-label">Percaya
                                            Diri</label> <select name="nilai_percayadiri" class="tom-select w-full"
                                            required>
                                            <option value="A" @if (
                                                $nilaisosial &&
                                                    isset(json_decode($nilaisosial->nilai, true)[6]) &&
                                                    json_decode($nilaisosial->nilai, true)[6] == 'A') selected @endif>A -
                                                Baik
                                                Sekali</option>
                                            <option value="B" @if (
                                                $nilaisosial &&
                                                    isset(json_decode($nilaisosial->nilai, true)[6]) &&
                                                    json_decode($nilaisosial->nilai, true)[6] == 'B') selected @endif>B -
                                                Baik
                                            </option>
                                            <option value="C" @if (
                                                $nilaisosial &&
                                                    isset(json_decode($nilaisosial->nilai, true)[6]) &&
                                                    json_decode($nilaisosial->nilai, true)[6] == 'C') selected @endif>C -
                                                Cukup
                                                Baik</option>
                                            <option value="D" @if (
                                                $nilaisosial &&
                                                    isset(json_decode($nilaisosial->nilai, true)[6]) &&
                                                    json_decode($nilaisosial->nilai, true)[6] == 'D') selected @endif>D -
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
    <!-- END: Modal edit cttn All Content -->



@endsection
