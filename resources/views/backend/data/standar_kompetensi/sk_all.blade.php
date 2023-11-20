@extends('admin.admin_master')
@section('admin')
    <div class="page-content">
        <!-- BEGIN: Events -->
        <div class="intro-y box mt-5">
            <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                <h2 class="font-medium text-base mr-auto">
                    STANDAR KOMPETENSI (KI/KD) : {{ $pengampu['mapels']['nama'] }} {{ $pengampu['kelass']['tingkat'] }}
                </h2>
                <form method="post" action="{{ route('sinkron.all') }}" onkeydown="return event.key != 'Enter';">
                    @csrf

                    <input type="hidden" name="id3" value="{{ $idki3->id }}">
                    <input type="hidden" class="form-control" name="ket3" value="{{ $idki3->ket }}">

                    <input type="hidden" name="id4" value="{{ $idki4->id }}">
                    <input type="hidden" class="form-control" name="ket4" value="{{ $idki4->ket }}">
{{--  
                    <button type="submit" class="btn btn-warning mr-1 mb-2"> Sinkronkan Data<i
                            data-loading-icon="spinning-circles" data-color="white" class="w-4 h-4 ml-2"></i>
                    </button>  --}}
                </form>





            </div>

            <div class="p-5">
                <table class="table">
                    <thead>
                        <tr class=" alert-primary">
                            <th>No.</th>
                            <th>KOMPETENSI INTI (KI)</th>
                            <th class="whitespace-nowrap">KOMPETENSI DASAR (KD) </th>
                        </tr>
                    </thead>
                    <tbody>

                        <tr>
                            <td>1.</td>
                            @foreach ($ki3 as $key => $item)
                                <td><span class="text-red-500">3 - Pengetahuan</span> <br><br>
                                    <form method="post" action="{{ route('ki3.update') }}"
                                        onkeydown="return event.key != 'Enter';">
                                        @csrf

                                        <input type="hidden" name="id" value="{{ $item->id }}">
                                        <textarea class="form-control" name="ket" cols="45" rows="5">{{ $item->ket }}  </textarea>

                                        <br><button type="submit" class="text-primary" title="Save">
                                            <i data-lucide="save" class="w-5 h-6 "></i>
                                        </button>
                                    </form>
                                </td>
                            @endforeach


                            <td> <br>
                                <form method="post" action="{{ route('kd3.store') }}"
                                    onkeydown="return event.key != 'Enter';">
                                    @csrf
                                    <input type="hidden" name="id_ki3" value="{{ $ki3data->id }}">
                                    <input class="intro-x login__input form-control py-3 px-4 block" type="number"
                                        placeholder="Urutan" name="urutan">

                                    <textarea class="form-control mt-1" name="ket" cols="40" rows="" placeholder="Kompetensi Dasar"></textarea>
                                    <br> <button type="submit" class="btn btn-primary btn-sm mt-1" title="Save">
                                        <i data-lucide="save" class="w-5 h-5 "></i> &nbsp; Save
                                    </button>
                                </form>
                                <br> <br>


                                @foreach ($kd3 as $key => $item)
                                    <span class="text-small"> 3.{{ $item->urutan }} {{ $item->ket }}
                                        <a id="delete"
                                            href="{{ route('kd3.delete', ['id' => $item->id, 'urutan' => $item->urutan]) }}"
                                            class="text-danger" title="delete">
                                            <i data-lucide="trash" class="w-4 h-4"></i>
                                        </a>
                                    </span><br>
                                @endforeach

                            </td>

                        </tr>


                        <tr>
                            <td>1.</td>
                            @foreach ($ki4 as $key => $item)
                                <td><span class="text-red-500">4 - Keterampilan</span> <br><br>
                                    <form method="post" action="{{ route('ki4.update') }}"
                                        onkeydown="return event.key != 'Enter';">
                                        @csrf

                                        <input type="hidden" name="id" value="{{ $item->id }}">
                                        <textarea class="form-control" name="ket" cols="45" rows="5">{{ $item->ket }}</textarea>

                                        <br><button type="submit" class="text-primary" title="Save">
                                            <i data-lucide="save" class="w-5 h-6 "></i>
                                        </button>
                                    </form>

                                </td>
                            @endforeach
                            <td> <br>
                                <form method="post" action="{{ route('kd4.store') }}"
                                    onkeydown="return event.key != 'Enter';">
                                    @csrf
                                    <input type="hidden" name="id_ki4" value="{{ $ki4data->id }}">
                                    <input class="intro-x login__input form-control py-3 px-4 block" type="number"
                                        placeholder="Urutan" name="urutan">

                                    <textarea class="form-control mt-1" name="ket" cols="40" rows="" placeholder="Kompetensi Dasar"></textarea>
                                    <br> <button type="submit" class="btn btn-primary btn-sm mt-1" title="Save">
                                        <i data-lucide="save" class="w-5 h-5 "></i> &nbsp;Save
                                    </button>
                                </form>
                                <br> <br>


                                @foreach ($kd4 as $key => $item)
                                    <span class="text-small"> 4.{{ $item->urutan }} {{ $item->ket }}
                                        <a id="delete"
                                            href="{{ route('kd4.delete', ['id' => $item->id, 'urutan' => $item->urutan]) }}"
                                            class="text-danger" title="delete">
                                            <i data-lucide="trash" class="w-4 h-4"></i>
                                        </a>
                                    </span><br>
                                @endforeach
                            </td>
                        </tr>

                    </tbody>

                </table>

            </div>
        </div>
        <!-- END: Events -->
    </div> <!-- end row -->
@endsection
