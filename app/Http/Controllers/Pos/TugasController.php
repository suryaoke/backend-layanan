<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Models\NilaisiswaKd3;
use App\Models\NilaisiswaKd4;
use App\Models\Rombelsiswa;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TugasController extends Controller
{
    public function TugasSiswa(Request $request)
    {

        $searchMapel = $request->input('searchmapel');
        $searchKelas = $request->input('searchkelas');
        $searchMapel1 = $request->input('searchmapel1');
        $searchKelas1 = $request->input('searchkelas1');
        $query = NilaisiswaKd3::query();
        $query1 = NilaisiswaKd4::query();

        if (!empty($searchMapel)) {
            $query->whereHas('nilaikd3', function ($nilaiQuery) use ($searchMapel) {
                $nilaiQuery->whereHas('seksis', function ($seksiQuery) use ($searchMapel) {
                    $seksiQuery->whereHas('jadwalmapels', function ($jadwalQuery) use ($searchMapel) {
                        $jadwalQuery->whereHas('pengampus', function ($pengampuQuery) use ($searchMapel) {
                            $pengampuQuery->whereHas('mapels', function ($mapelQuery) use ($searchMapel) {
                                $mapelQuery->where('id', 'LIKE', '%' . $searchMapel . '%');
                            });
                        });
                    });
                });
            });
        }

        if (!empty($searchKelas)) {
            $query->whereHas('nilaikd3', function ($nilaiQuery) use ($searchKelas) {
                $nilaiQuery->whereHas('seksis', function ($seksiQuery) use ($searchKelas) {
                    $seksiQuery->whereHas('jadwalmapels', function ($jadwalQuery) use ($searchKelas) {
                        $jadwalQuery->whereHas('pengampus', function ($pengampuQuery) use ($searchKelas) {
                            $pengampuQuery->whereHas('kelass', function ($mapelQuery) use ($searchKelas) {
                                $mapelQuery->where('id', 'LIKE', '%' . $searchKelas . '%');
                            });
                        });
                    });
                });
            });
        }


        if (!empty($searchMapel1)) {
            $query1->whereHas('nilaikd4', function ($nilaiQuery) use ($searchMapel1) {
                $nilaiQuery->whereHas('seksis', function ($seksiQuery) use ($searchMapel1) {
                    $seksiQuery->whereHas('jadwalmapels', function ($jadwalQuery) use ($searchMapel1) {
                        $jadwalQuery->whereHas('pengampus', function ($pengampuQuery) use ($searchMapel1) {
                            $pengampuQuery->whereHas('mapels', function ($mapelQuery) use ($searchMapel1) {
                                $mapelQuery->where('id', 'LIKE', '%' . $searchMapel1 . '%');
                            });
                        });
                    });
                });
            });
        }

        if (!empty($searchKelas1)) {
            $query1->whereHas('nilaikd4', function ($nilaiQuery) use ($searchKelas1) {
                $nilaiQuery->whereHas('seksis', function ($seksiQuery) use ($searchKelas1) {
                    $seksiQuery->whereHas('jadwalmapels', function ($jadwalQuery) use ($searchKelas1) {
                        $jadwalQuery->whereHas('pengampus', function ($pengampuQuery) use ($searchKelas1) {
                            $pengampuQuery->whereHas('kelass', function ($mapelQuery) use ($searchKelas1) {
                                $mapelQuery->where('id', 'LIKE', '%' . $searchKelas1 . '%');
                            });
                        });
                    });
                });
            });
        }


        $userId = Auth::user()->id;
        $siswa = Siswa::where('id_user', $userId)->first();

        $rombelSiswaIds = Rombelsiswa::where('id_siswa', $siswa->id)->pluck('id')->toArray();
        if ($rombelSiswaIds) {
            $rombelSiswa = RombelSiswa::whereIn('id', $rombelSiswaIds)->get();
            if ($rombelSiswa) {
                $nilaiSiswaKd3 = $query->whereIn('id_rombelsiswa', $rombelSiswaIds)->get();
                $nilaiSiswaKd4 = $query1->whereIn('id_rombelsiswa', $rombelSiswaIds)->get();
            }
        }



        return view('backend.data.tugas.tugas_all', compact('nilaiSiswaKd4', 'nilaiSiswaKd3'));
    } // end method

}
