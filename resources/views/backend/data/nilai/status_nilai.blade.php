@extends('admin.admin_master')
@section('admin')
    <div class="page-content mt-4">
        <div class="container-fluid">
            <div class="row">

                <div class="col-12">
                    <ul class="nav nav-boxed-tabs" role="tablist">


                        <li id="example-5-tab" class="nav-item flex-1" role="presentation"> <button
                                class="nav-link w-full py-2 active" data-tw-toggle="pill" data-tw-target="#example-tab-6"
                                type="button" role="tab" aria-controls="example-tab-4" aria-selected="false">
                                STATUS NILAI </button> </li>

                    </ul>
                </div>
            </div>
        </div>

    </div>
    <div class="flex ml-1 mt-8">
        <form role="form" action="{{ route('status.nilai') }}" method="get" class="flex">
            <div class="flex-1 mr-1">
                <div class="form-group">
                    <input type="text" name="searchmapel" class="form-control" placeholder="Mata Pelajaran"
                        value="{{ request('searchmapel') }}">
                </div>
            </div>
            <div class="flex-1 mr-1">
                <div class="form-group">
                    <input type="text" name="searchguru" class="form-control" placeholder="Nama Guru"
                        value="{{ request('searchguru') }}">
                </div>
            </div>

            <div class="flex-1 mr-1">
                <div class="form-group">
                    <select name="searchtahun" class="form-select w-full">
                        <option value=""> Pilih Tahun Ajar
                        </option>
                        @foreach ($datatahun as $item)
                            <option value="{{ $item->id }}">
                                Semester {{ $item->semester }} -{{ $item->tahun }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="ml-1">
                <button type="submit" class="btn btn-default">Search</button>
            </div>

            <div class="ml-2">
                <a href="{{ route('status.nilai') }}" class="btn btn-danger">Clear</a>
            </div>
        </form>
    </div>

    <div class="overflow-x-auto">
        <div class="tab-content mt-4">
            <div class="mb-4 mt-4">
                Semester {{ $dataseksi['semesters']['semester'] }}
                Tahun Ajar {{ $dataseksi['semesters']['tahun'] }}
            </div>

            <table id="datatable" class="table table-bordered">
                <thead>
                    <tr>
                        <th class="whitespace-nowrap">No</th>
                        <th class="whitespace-nowrap">Mata Pelajaran</th>
                        <th class="whitespace-nowrap">Guru</th>
                        <th class="whitespace-nowrap">Pengetahuan</th>
                        <th class="whitespace-nowrap">Keterampilan</th>
                        <th class="whitespace-nowrap">Action</th>


                    </tr>
                </thead>
                <tbody>

                    @foreach ($seksi as $key => $item)
                        @php
                            $nilaipengetahuan = App\Models\Nilai::where('id_seksi', $item->id)
                                ->whereIn('type_nilai', [1, 2])
                                ->first();
                            $nilaiketerampilan = App\Models\Nilai::where('id_seksi', $item->id)
                                ->where('type_nilai', 3)
                                ->first();
                        @endphp
                        <tr>
                            <td class="whitespace-nowrap">{{ $key + 1 }}</td>
                            <td class="whitespace-nowrap"> {{ $item->jadwalmapels->pengampus->mapels->nama }}
                            </td>
                            <td class="whitespace-nowrap"> {{ $item->jadwalmapels->pengampus->gurus->nama }}
                            </td>
                            <td class="whitespace-nowrap">
                                @if ($nilaipengetahuan)
                                    @if ($nilaipengetahuan->status == 0)
                                        <i data-lucide="x" class="text-danger"></i>
                                    @elseif ($nilaipengetahuan->status == 1 || $nilaipengetahuan->status == 2)
                                        <i data-lucide="check" class="text-success"></i>
                                    @endif
                                @else
                                    <i data-lucide="x" class="text-danger"></i>
                                @endif
                            </td>

                            <td class="whitespace-nowrap ">
                                @if ($nilaiketerampilan)
                                    @if ($nilaiketerampilan->status == 0)
                                        <i data-lucide="x" class="text-danger"></i>
                                    @elseif ($nilaiketerampilan->status == 1 || $nilaiketerampilan->status == 2)
                                        <i data-lucide="check" class="text-success"></i>
                                    @endif
                                @else
                                    <i data-lucide="x" class="text-danger"></i>
                                @endif
                            </td>
                            <td class="whitespace-nowrap">
                                @if ($nilaiketerampilan && $nilaipengetahuan)
                                    @if ($nilaiketerampilan->status == 1 && $nilaipengetahuan->status == 1)
                                        <a href="{{ route('kunci.nilai', $item->id) }}" class="btn btn-danger mr-1 mb-2">
                                            <i data-lucide="unlock" class="w-4 h-4"></i>&nbsp; Kunci</a>
                                    @elseif ($nilaiketerampilan->status == 2 && $nilaipengetahuan->status == 2)
                                        <a href="{{ route('buka.kunci', $item->id) }}" class="btn btn-success mr-1 mb-2">
                                            <i data-lucide="lock" class="w-4 h-4"></i>&nbsp; Buka Kunci </a>
                                    @elseif ($nilaiketerampilan->status == 0 && $nilaipengetahuan->status == 0)
                                        <div class="text-primary">Belum dikirim</div>
                                    @endif
                                @else
                                    <div class="text-warning">Belum diproses</div>
                                @endif
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>



        </div>
    </div>


    <!-- BEGIN: Modal Toggle -->
@endsection
