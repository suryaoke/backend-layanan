@extends('admin.admin_master')
@section('admin')
    <div class="mb-3 intro-y flex flex-col sm:flex-row items-center mt-8">
        <h1 class="text-lg font-medium mr-auto">
            Catatan Walas All
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
                                        <th>No</th>
                                        <th>Nisn</th>
                                        <th>Nama</th>
                                        <th>Kelas</th>
                                        <th>Jk</th>
                                        <th>Catatan</th>
                                        <th>Action</th>
                                </thead>
                                <tbody>
                                    @if ($walas)
                                        @foreach ($siswa as $key => $item)
                                            @php
                                                $cctnwalas = App\Models\Cttnwalas::where('id_siswa', $item->id)->first();
                                                $rombelsiswa = App\Models\Rombelsiswa::where('id_siswa', $item->id)->first();
                                                $rombel = App\Models\Rombel::where('id', $rombelsiswa->id_rombel)->first();
                                                $kelas = App\Models\Kelas::where('id', $rombel->id_kelas)->first();
                                            @endphp
                                            <tr>
                                                <td> {{ $key + 1 }} </td>

                                                <td> {{ $item->nisn }} </td>
                                                <td> {{ $item->nama }} </td>
                                                <td> {{ $kelas->tingkat }}{{ $kelas->nama }}
                                                    {{ $kelas['jurusans']['nama'] }} </td>

                                                <td> {{ $item->jk }} </td>
                                                <td>
                                                    @if ($cctnwalas)
                                                        {{ $cctnwalas->ket }}
                                                    @else
                                                        -
                                                    @endif
                                                </td>

                                                <td>
                                                    @if ($cctnwalas)
                                                        <a class="btn btn-success mr-1 mb-2"
                                                            data-tw-target="#edit-cttnwalas-{{ $item->id }}"
                                                            data-tw-toggle="modal">
                                                            <i data-lucide="edit" class="w-4 h-4"></i>
                                                        </a>
                                                    @else
                                                        <a class="btn btn-success mr-1 mb-2"
                                                            data-tw-target="#add-cttnwalas-{{ $item->id }}"
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
    @if ($walas1)
        @foreach ($siswa as $item)
            {{--  @php
                $walas = App\Models\Walas::where('id_kelas', $item->kelas)->first();
            @endphp  --}}
            <!-- BEGIN: Modal Kirim Jadwal All-->
            <div id="add-cttnwalas-{{ $item->id }}" class="modal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <form method="post" action="{{ route('cttnwalas.store') }}" onkeydown="return event.key != 'Enter';">
                        @csrf
                        <div class="modal-content">
                            <!-- BEGIN: Modal Header -->
                            <div class="modal-header">
                                <h2 class="font-medium text-base mr-auto">Catatan {{ $item->nama }} /
                                    {{ $item->nisn }}
                                </h2>
                                <div class="dropdown sm:hidden"> <a class="dropdown-toggle w-5 h-5 block"
                                        href="javascript:;" aria-expanded="false" data-tw-toggle="dropdown"> <i
                                            data-lucide="more-horizontal" class="w-5 h-5 text-slate-500"></i> </a>

                                </div>
                            </div> <!-- END: Modal Header -->
                            <!-- BEGIN: Modal Body -->
                            <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                                <div class="col-span-12">
                                    <label for="modal-form-1" class="form-label">Catatan</label>
                                    <input type="hidden" name="id_siswa" value="{{ $item->id }}">
                                    <input type="hidden" name="id_walas" value="{{ $walas1->id }}">

                                    <textarea class="form-control" name="ket" cols="30" rows="10"></textarea>

                                </div>
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
    @if ($walas1)
        @foreach ($siswa as $item)
            @php
                $cttnwalas = App\Models\Cttnwalas::where('id_siswa', $item->id)->first();
            @endphp
            <!-- BEGIN: Modal Kirim Jadwal All-->
            <div id="edit-cttnwalas-{{ $item->id }}" class="modal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <form method="post" action="{{ route('cttnwalas.update') }}" onkeydown="return event.key != 'Enter';">
                        @csrf
                        <div class="modal-content">
                            <!-- BEGIN: Modal Header -->
                            <div class="modal-header">
                                <h2 class="font-medium text-base mr-auto">Catatan {{ $item->nama }} /
                                    {{ $item->nisn }}
                                </h2>
                                <div class="dropdown sm:hidden"> <a class="dropdown-toggle w-5 h-5 block"
                                        href="javascript:;" aria-expanded="false" data-tw-toggle="dropdown"> <i
                                            data-lucide="more-horizontal" class="w-5 h-5 text-slate-500"></i> </a>

                                </div>
                            </div> <!-- END: Modal Header -->
                            <!-- BEGIN: Modal Body -->
                            <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                                <div class="col-span-12">
                                    @if ($cttnwalas)
                                        <input type="hidden" name="id" value="{{ $cttnwalas->id }}">
                                        <input type="hidden" name="id_siswa" value="{{ $cttnwalas->id_siswa }}">
                                        <input type="hidden" name="id_walas" value="{{ $cttnwalas->id_walas }}">
                                        <textarea class="form-control" name="ket" cols="30" rows="10">{{ $cttnwalas->ket }}</textarea>
                                    @endif


                                </div>
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
