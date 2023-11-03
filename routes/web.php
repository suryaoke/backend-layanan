<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Pos\AbsensiController;
use App\Http\Controllers\Pos\ExportController;
use App\Http\Controllers\Pos\GuruController;
use App\Http\Controllers\Pos\HariController;
use App\Http\Controllers\Pos\InfoController;
use App\Http\Controllers\Pos\JadwalmapelController;
use App\Http\Controllers\Pos\JurusanController;
use App\Http\Controllers\Pos\KelasController;
use App\Http\Controllers\Pos\KkmController;
use App\Http\Controllers\Pos\MapelController;
use App\Http\Controllers\Pos\OrangTuaController;
use App\Http\Controllers\Pos\PengampuController;
use App\Http\Controllers\Pos\RombelController;
use App\Http\Controllers\Pos\RuanganController;
use App\Http\Controllers\Pos\SeksiController;
use App\Http\Controllers\Pos\SiswaController;
use App\Http\Controllers\Pos\StandarkompetensiController;
use App\Http\Controllers\Pos\TahunajarController;
use App\Http\Controllers\Pos\TugasController;
use App\Http\Controllers\Pos\WalasController;
use App\Http\Controllers\Pos\UserController;
use App\Http\Controllers\Pos\WaktuController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\vendor\Chatify\MessagesController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Admin All Route

Route::controller(AdminController::class)->middleware(['auth'])->group(function () {
    Route::get('/admin/logout', 'destroy')->name('admin.logout');
    Route::get('/admin/profile', 'Profile')->name('admin.profile');
    Route::get('/edit/profile', 'EditProfile')->name('edit.profile');
    Route::post('/store/profile', 'StoreProfile')->name('store.profile');
    Route::get('/change/password', 'ChangePassword')->name('change.password');
    Route::post('/update/password', 'UpdatePassword')->name('update.password');
});


// All user
Route::controller(UserController::class)->middleware(['auth'])->group(function () {
    Route::get('/user/all', 'UserAll')->name('user.all');
    Route::get('/user/add', 'UserAdd')->name('user.add');
    Route::post('/user/store', 'UserStore')->name('user.store');
    Route::get('/user/view/{id}', 'UserView')->name('user.view');
    Route::get('/user/edit/{id}', 'UserEdit')->name('user.edit');
    Route::post('/user/update', 'UserUpdate')->name('user.update');
    Route::get('/user/delete{id}', 'UserDelete')->name('user.delete');
    Route::post('/user/reset', 'UserReset')->name('user.reset');
    Route::get('/user/tidak/aktif{id}', 'UserTidakAktif')->name('user.tidak.aktif');
    Route::get('/user/aktif{id}', 'UserAktif')->name('user.aktif');
});


// Guru All Route
Route::controller(GuruController::class)->middleware(['auth'])->group(function () {
    Route::get('/guru/all', 'GuruAll')->name('guru.all');
    Route::get('/guru/add', 'GuruAdd')->name('guru.add');
    Route::post('/guru/store', 'GuruStore')->name('guru.store');
    Route::get('/guru/edit/{id}', 'GuruEdit')->name('guru.edit');
    Route::post('/guru/update', 'GuruUpdate')->name('guru.update');
    Route::get('/guru/delete{id}', 'GuruDelete')->name('guru.delete');
});

// Mapel All Route
Route::controller(MapelController::class)->middleware(['auth'])->group(function () {
    Route::get('/mapel/all', 'MapelAll')->name('mapel.all');
    Route::get('/mapel/add', 'MapelAdd')->name('mapel.add');
    Route::post('/mapel/store', 'MapelStore')->name('mapel.store');
    Route::get('/mapel/edit/{id}', 'MapelEdit')->name('mapel.edit');
    Route::post('/mapel/update', 'MapelUpdate')->name('mapel.update');
    Route::get('/mapel/delete{id}', 'MapelDelete')->name('mapel.delete');
});

// Siswa All Route
Route::controller(SiswaController::class)->middleware(['auth'])->group(function () {
    Route::get('/siswa/all', 'SiswaAll')->name('siswa.all');
    Route::get('/siswa/add', 'SiswaAdd')->name('siswa.add');
    Route::post('/siswa/store', 'SiswaStore')->name('siswa.store');
    Route::get('/siswa/delete{id}', 'SiswaDelete')->name('siswa.delete');
    Route::get('/siswa/edit/{id}', 'SiswaEdit')->name('siswa.edit');
    Route::post('/siswa/update', 'SiswaUpdate')->name('siswa.update');
    Route::get('/siswa/search', 'search')->name('siswa.search');
    Route::get('/siswa/profile', 'SiswaProfile')->name('siswa.profile');
    Route::get('/siswa/guru', 'SiswaGuru')->name('siswa.guru');
    Route::get('/siswa/guruwalas', 'SiswaGuruwalas')->name('siswa.guruwalas');
});

// Kelas All Route
Route::controller(KelasController::class)->middleware(['auth'])->group(function () {
    Route::get('/kelas/all', 'KelasAll')->name('kelas.all');
    Route::get('/kelas/add', 'KelasAdd')->name('kelas.add');
    Route::post('/kelas/store', 'KelasStore')->name('kelas.store');
    Route::get('/kelas/delete{id}', 'KelasDelete')->name('kelas.delete');
    Route::get('/kelas/edit/{id}', 'KelasEdit')->name('kelas.edit');
    Route::post('/kelas/update', 'KelasUpdate')->name('kelas.update');
});

// Waktu All Route
Route::controller(WaktuController::class)->middleware(['auth'])->group(function () {
    Route::get('/waktu/all', 'WaktuAll')->name('waktu.all');
    Route::get('/waktu/add', 'waktuAdd')->name('waktu.add');
    Route::post('/waktu/store', 'WaktuStore')->name('waktu.store');
    Route::get('/waktu/delete{id}', 'WaktuDelete')->name('waktu.delete');
    Route::get('/waktu/edit/{id}', 'WaktuEdit')->name('waktu.edit');
    Route::post('/waktu/update', 'WaktuUpdate')->name('waktu.update');
});

// Hari All Route
Route::controller(HariController::class)->middleware(['auth'])->group(function () {
    Route::get('/hari/all', 'HariAll')->name('hari.all');
    Route::get('/hari/add', 'HariAdd')->name('hari.add');
    Route::post('/hari/store', 'HariStore')->name('hari.store');
    Route::get('/hari/delete{id}', 'HariDelete')->name('hari.delete');
    Route::get('/hari/edit/{id}', 'HariEdit')->name('hari.edit');
    Route::post('/hari/update', 'HariUpdate')->name('hari.update');
});

// Ruangan All Route
Route::controller(RuanganController::class)->middleware(['auth'])->group(function () {
    Route::get('/ruangan/all', 'RuanganAll')->name('ruangan.all');
    Route::get('/ruangan/add', 'RuanganAdd')->name('ruangan.add');
    Route::post('/ruangan/store', 'RuanganStore')->name('ruangan.store');
    Route::get('/ruangan/delete{id}', 'RuanganDelete')->name('ruangan.delete');
    Route::get('/ruangan/edit/{id}', 'RuanganEdit')->name('ruangan.edit');
    Route::post('/ruangan/update', 'RuanganUpdate')->name('ruangan.update');
});

// Jurusan All Route
Route::controller(JurusanController::class)->middleware(['auth'])->group(function () {
    Route::get('/jurusan/all', 'JurusanAll')->name('jurusan.all');
    Route::get('/jurusan/add', 'JurusanAdd')->name('jurusan.add');
    Route::post('/jurusan/store', 'JurusanStore')->name('jurusan.store');
    Route::get('/jurusan/delete{id}', 'JurusanDelete')->name('jurusan.delete');
    Route::get('/jurusan/edit/{id}', 'JurusanEdit')->name('jurusan.edit');
    Route::post('/jurusan/update', 'JurusanUpdate')->name('jurusan.update');
});


// Tahun Ajar All Route
Route::controller(TahunajarController::class)->middleware(['auth'])->group(function () {
    Route::get('/tahunajar/all', 'TahunajarAll')->name('tahunajar.all');
    Route::get('/tahunajar/add', 'TahunajarAdd')->name('tahunajar.add');
    Route::post('/tahunajar/store', 'TahunajarStore')->name('tahunajar.store');
    Route::get('/tahunajar/delete{id}', 'TahunajarDelete')->name('tahunajar.delete');
    Route::get('/tahunajar/edit/{id}', 'TahunajarEdit')->name('tahunajar.edit');
    Route::post('/tahunajar/update', 'TahunajarUpdate')->name('tahunajar.update');
});


// Tugas All Route
Route::controller(TugasController::class)->middleware(['auth'])->group(function () {
    Route::get('/tugas/all', 'TugasSiswa')->name('tugas.siswa');

    Route::post('/tugas/kd3', 'Tugaskd3Update')->name('tugaskd3.update');
    Route::post('/tugas/kd4', 'Tugaskd4Update')->name('tugaskd4.update');
});



// Walas All Route
Route::controller(WalasController::class)->middleware(['auth'])->group(function () {
    Route::get('/walas/all', 'WalasAll')->name('walas.all');
    Route::get('/walas/add', 'WalasAdd')->name('walas.add');
    Route::post('/walas/store', 'WalasStore')->name('walas.store');
    Route::get('/walas/delete/{id}', 'WalasDelete')->name('walas.delete');
    Route::get('/walas/edit/{id}', 'WalasEdit')->name('walas.edit');
    Route::post('/walas/update', 'WalasUpdate')->name('walas.update');
});



Route::controller(InfoController::class)->middleware(['auth'])->group(function () {
    Route::get('/info/all', 'InfoAll')->name('info.all');
    Route::get('/info/add', 'InfoAdd')->name('info.add');
    Route::post('/info/store', 'InfoStore')->name('info.store');
    Route::get('/info/delete/{id}', 'InfoDelete')->name('info.delete');
    Route::get('/info/edit/{id}', 'InfoEdit')->name('info.edit');
    Route::post('/info/update', 'InfoUpdate')->name('info.update');
});


// Kkm All Route
Route::controller(KkmController::class)->middleware(['auth'])->group(function () {
    Route::get('/kkm/all', 'KkmAll')->name('kkm.all');
    Route::get('/kkm/add', 'KkmAdd')->name('kkm.add');
    Route::post('/kkm/store', 'KkmStore')->name('kkm.store');
    Route::get('/kkm/delete/{id}', 'KkmDelete')->name('kkm.delete');
    Route::get('/kkm/edit/{id}', 'KkmEdit')->name('kkm.edit');
    Route::post('/kkm/update', 'KkmUpdate')->name('kkm.update');
});

// Rombel All Route
Route::controller(RombelController::class)->middleware(['auth'])->group(function () {
    Route::get('/rombel/all', 'RombelAll')->name('rombel.all');
    Route::get('/rombel/add', 'RombelAdd')->name('rombel.add');
    Route::post('/rombel/store', 'RombelStore')->name('rombel.store');
    Route::get('/rombel/delete/{id}', 'RombelDelete')->name('rombel.delete');
    Route::get('/rombel/edit/{id}', 'RombelEdit')->name('rombel.edit');
    Route::post('/rombel/update/{id}', 'RombelUpdate')->name('rombel.update');
});


// Seksi All Route
Route::controller(SeksiController::class)->middleware(['auth'])->group(function () {
    Route::get('/seksi/all', 'SeksiAll')->name('seksi.all');
    Route::get('/seksi/add', 'SeksiAdd')->name('seksi.add');
    Route::post('/seksi/store', 'SeksiStore')->name('seksi.store');
    Route::get('/seksi/delete/{id}', 'SeksiDelete')->name('seksi.delete');
    Route::get('/seksi/edit/{id}', 'SeksiEdit')->name('seksi.edit');
    Route::post('/seksi/update', 'SeksiUpdate')->name('seksi.update');
    Route::get('/get-jadwalmapel/{id_kelas}', 'getJadwalmapel')->name('getjadwal.mapel');
});


// Pengampu All Route
Route::controller(PengampuController::class)->middleware(['auth'])->group(function () {
    Route::get('/pengampu/all', 'PengampuAll')->name('pengampu.all');
    Route::get('/pengampu/add', 'PengampuAdd')->name('pengampu.add');
    Route::post('/pengampu/store', 'PengampuStore')->name('pengampu.store');
    Route::get('/pengampu/delete{id}', 'PengampuDelete')->name('pengampu.delete');
    Route::get('/pengampu/edit/{id}', 'PengampuEdit')->name('pengampu.edit');
    Route::post('/pengampu/update', 'PengampuUpdate')->name('pengampu.update');
});

// Jadwal Mapel All Route
Route::controller(JadwalmapelController::class)->middleware(['auth'])->group(function () {
    Route::get('/jadwalmapel/all', 'JadwalmapelAll')->name('jadwalmapel.all');
    Route::post('/jadwalmapel/store', 'JadwalmapelStore')->name('jadwalmapel.store');
    Route::get('/jadwalmapel/delete{id}', 'JadwalmapelDelete')->name('jadwalmapel.delete');
    Route::post('/jadwalmapel/update/{id}', 'JadwalmapelUpdate')->name('jadwalmapel.update');
    Route::post('/jadwalmapel/status/one/{id}', 'JadwalmapelstatusOne')->name('jadwalmapelstatusone.update');
    Route::post('/jadwal/upadate/status/all', 'JadwalmapelstatusAll')->name('jadwalmapelstatusall.update');
    Route::get('/jadwalmapel/kepsek', 'JadwalmapelKepsek')->name('jadwalmapel.kepsek');
    Route::post('/jadwalmapel/verifikasi/one/{id}', 'JadwalmapelverifikasiOne')->name('jadwalmapelverifikasione.update');
    Route::post('/jadwal/upadate/verifikasi/all', 'JadwalmapelverifikasiAll')->name('jadwalmapelverifikasiall.update');
    Route::post('/jadwalmapel/tolak/one/{id}', 'JadwalmapeltolakOne')->name('jadwalmapeltolakone.update');
    Route::get('/jadwalmapel/guru', 'JadwalmapelGuru')->name('jadwalmapel.guru');

    Route::get('/jadwalmapel/siswa', 'JadwalmapelSiswa')->name('jadwalmapel.siswa');
});



// Abensi All Route
Route::controller(AbsensiController::class)->middleware(['auth'])->group(function () {
    Route::get('/absensi/all', 'AbsensiAll')->name('absensi.all');
    Route::get('/absensi/add', 'AbsensiAdd')->name('absensi.add');
    Route::post('/absensi/store', 'AbsensiStore')->name('absensi.store');
    Route::get('/absensi/search', 'searchAbsensi')->name('absensi.search');
    Route::get('/absensi/siswa', 'AbsensiSiswa')->name('absensi.siswa');
    Route::post('/absensi/siswa/store', 'AbsensiSiswaStore')->name('absensi.siswa.store');
    Route::get('/absensi/delete{id}', 'AbsensiDelete')->name('absensi.delete');
    Route::get('/absensi/siswa/guruwalas', 'AbsensiSiswaguruwalas')->name('absensi.siswaguruwalas');

    Route::get('/absensi/data/all', 'AbsensiDataAll')->name('absensi.data.all');

    Route::get('/absensi/data/siswa', 'AbsensiDataSiswa')->name('absensi.data.siswa');
});



// Orang Tua All Route
Route::controller(OrangTuaController::class)->middleware(['auth'])->group(function () {
    Route::get('/ortu/all', 'OrtuAll')->name('orangtua.all');
    Route::get('/ortu/add', 'OrtuAdd')->name('orangtua.add');
    Route::post('/ortu/store', 'OrtuStore')->name('orangtua.store');
    Route::get('/ortu/edit/{id}', 'OrtuEdit')->name('orangtua.edit');
    Route::post('/ortu/update', 'OrtuUpdate')->name('orangtua.update');
    Route::get('/ortu/delete{id}', 'OrtuDelete')->name('orangtua.delete');
    Route::get('/ambil-mata-pelajaran/{id_pengampu}', 'ambilMataPelajaran');
});


// Standar Komptensi All
Route::controller(StandarkompetensiController::class)->middleware(['auth'])->group(function () {
    Route::get('/sk/all/{id}', 'SkAll')->name('sk.all');

    Route::post('/ki3/update', 'Ki3Update')->name('ki3.update');
    Route::post('/ki4/update', 'Ki4Update')->name('ki4.update');
    Route::post('/kd3/store', 'Kd3Store')->name('kd3.store');
    Route::post('/kd4/store', 'Kd4Store')->name('kd4.store');

    Route::get('/kd3/delete/{id}/{urutan}', 'Kd3Delete')->name('kd3.delete');
    Route::get('/kd4/delete/{id}/{urutan}', 'Kd4Delete')->name('kd4.delete');

    Route::get('/nilaikd/all/{id}', 'NilaikdAll')->name('nilaikd.all');

    Route::post('/Nilaikd3/store', 'Nilaikd3Store')->name('nilaikd3.store');
    Route::post('/Nilaikd4/store', 'Nilaikd4Store')->name('nilaikd4.store');

    Route::get('/nilaikd3/delete{id}', 'Nilaikd3Delete')->name('Nilaikd3.delete');
    Route::get('/nilaikd4/delete{id}', 'Nilaikd4Delete')->name('Nilaikd4.delete');

    Route::post('/nilaisiswakd3/update', 'Nilaisiswakd3Update')->name('Nilaisiswakd3.update');
    Route::post('/nilaisiswakd4/update', 'Nilaisiswakd4Update')->name('Nilaisiswakd4.update');

    Route::get('/nilaisiswaguruwalas/all', 'NilaiSiswaGuruWalas')->name('NilaiSiswaGuruWalas.all');
    Route::get('/nilaisiswagurumapel/all', 'NilaiSiswaGuruMapel')->name('NilaiSiswaGuruMapel.all');

    Route::post('/Nilaikd3/update', 'Nilaikd3Update')->name('nilaikd3.update');
    Route::post('/Nilaikd4/update', 'Nilaikd4Update')->name('nilaikd4.update');

    Route::get('/nilaisiswa/all', 'NilaiSiswaAll')->name('NilaiSiswa.all');


    Route::post('/sinkron/all', 'SinkronAll')->name('sinkron.all');

    Route::get('/nilai/siswa/all', 'NilaiSiswa')->name('nilai.siswa');
});




// Export All Route
Route::controller(ExportController::class)->middleware(['auth'])->group(function () {
    Route::get('user/pdf', 'Userpdf')->name('user.pdf');
    Route::get('user/excel', 'Userexcel')->name('user.excel');

    Route::get('guru/pdf', 'Gurupdf')->name('guru.pdf');
    Route::get('guru/excel', 'Guruexcel')->name('guru.excel');

    Route::get('orangtua/pdf', 'Orangtuapdf')->name('orangtua.pdf');
    Route::get('orangtua/excel', 'Orangtuaexcel')->name('orangtua.excel');

    Route::get('siswa/pdf', 'Siswapdf')->name('siswa.pdf');
    Route::get('siswa/excel', 'Siswaexcel')->name('siswa.excel');

    Route::get('siswawalas/pdf', 'Siswawalaspdf')->name('siswawalas.pdf');
    Route::get('siswawalas/excel', 'Siswawalasexcel')->name('siswawalas.excel');

    Route::get('jadwalkepsek/pdf', 'Jadwalkepsekpdf')->name('jadwalkepsek.pdf');
    Route::get('jadwalkepsek/excel', 'Jadwalkepsekexcel')->name('jadwalkepsek.excel');


    Route::get('jadwal/pdf', 'Jadwalpdf')->name('jadwal.pdf');
    Route::get('jadwal/excel', 'Jadwalexcel')->name('jadwal.excel');

    Route::get('jadwalmapel/pdf', 'Jadwalmapelpdf')->name('jadwalmapel.pdf');
    Route::get('jadwalmapel/excel', 'Jadwalmapelexcel')->name('jadwalmapel.excel');

    Route::get('nilai/pdf', 'Nilaipdf')->name('nilai.pdf');
    // Route::get('nilai/excel', 'Nilaiexcel')->name('nilai.excel');

    Route::get('nilaimapel/pdf', 'Nilaimapelpdf')->name('nilaimapel.pdf');
    // Route::get('nilaimapel/excel', 'Nilaimapelexcel')->name('nilaimapel.excel');

    Route::get('nilaiwalas/pdf', 'Nilaiwalaspdf')->name('nilaiwalas.pdf');
    // Route::get('nilaiwalas/excel', 'Nilaiwalasexcel')->name('nilaiwalas.excel');



    Route::get('absensi/all/pdf', 'Absensiallpdf')->name('absensi.all.pdf');

    Route::get('absensi/data/all/pdf', 'Absensidataallpdf')->name('absensi.dataall.pdf');

    Route::get('absensi/guru/walas/pdf', 'Absensiguruwalaspdf')->name('absensi.guruwalas.pdf');

    Route::get('jadwalsiswa/pdf', 'Jadwalsiswapdf')->name('jadwalsiswa.pdf');
    Route::get('jadwalsiswa/excel', 'Jadwalsiswaexcel')->name('jadwalsiswa.excel');



    Route::get('absensi/data/siswa//pdf', 'Absensidatasiswapdf')->name('absensi.data.siswa.pdf');

    Route::get('nilaisiswa/pdf', 'Nilaisiswapdf')->name('nilaisiswa.pdf');
});


// routes/web.php



Route::get('/', function () {
    return view('auth.login');
})->name('login');



Route::get('/dashboard', function () {
    return view('admin.index');
})->middleware(['auth'])->name('dashboard');

// Route::get('/', function () {
//     return view('test');
// });
// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

// chat
Route::middleware(['auth'])->group(function () {
    Route::post('/pusher/auth', [MessagesController::class, 'pusherAuth'])->name('pusher.auth');
    Route::get('/messages/{id?}', [MessagesController::class, 'index'])->name('messages.index');
    Route::post('/messages/idFetchData', [MessagesController::class, 'idFetchData'])->name('messages.idFetchData');
    Route::get('/messages/download/{fileName}', [MessagesController::class, 'download'])->name('messages.download');
    Route::post('/messages/send', [MessagesController::class, 'send'])->name('messages.send');
    Route::post('/messages/fetch', [MessagesController::class, 'fetch'])->name('messages.fetch');
    Route::post('/messages/seen', [MessagesController::class, 'seen'])->name('messages.seen');
    Route::post('/messages/getContacts', [MessagesController::class, 'getContacts'])->name('messages.getContacts');
    Route::post('/messages/updateContactItem', [MessagesController::class, 'updateContactItem'])->name('messages.updateContactItem');
    Route::post('/messages/favorite', [MessagesController::class, 'favorite'])->name('messages.favorite');
    Route::post('/messages/getFavorites', [MessagesController::class, 'getFavorites'])->name('messages.getFavorites');
    Route::post('/messages/search', [MessagesController::class, 'search'])->name('messages.search');
    Route::post('/messages/sharedPhotos', [MessagesController::class, 'sharedPhotos'])->name('messages.sharedPhotos');
    Route::post('/messages/deleteConversation', [MessagesController::class, 'deleteConversation'])->name('messages.deleteConversation');
    Route::post('/messages/deleteMessage', [MessagesController::class, 'deleteMessage'])->name('messages.deleteMessage');
    Route::post('/messages/updateSettings', [MessagesController::class, 'updateSettings'])->name('messages.updateSettings');
    Route::post('/messages/setActiveStatus', [MessagesController::class, 'setActiveStatus'])->name('messages.setActiveStatus');
});
