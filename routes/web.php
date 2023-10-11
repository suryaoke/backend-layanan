<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Pos\AbsensiController;
use App\Http\Controllers\Pos\GuruController;
use App\Http\Controllers\Pos\HariController;
use App\Http\Controllers\Pos\JadwalmapelController;
use App\Http\Controllers\Pos\JurusanController;
use App\Http\Controllers\Pos\KelasController;
use App\Http\Controllers\Pos\MapelController;
use App\Http\Controllers\Pos\NaskahController;
use App\Http\Controllers\Pos\OrangTuaController;
use App\Http\Controllers\Pos\PengampuController;
use App\Http\Controllers\Pos\RuanganController;
use App\Http\Controllers\Pos\SiswaController;
use App\Http\Controllers\Pos\SuratKeluarController;
use App\Http\Controllers\Pos\SuratMasukController;
use App\Http\Controllers\Pos\TahunajarController;
use App\Http\Controllers\Pos\WalasController;
use App\Http\Controllers\Pos\TamuController;
use App\Http\Controllers\Pos\UserController;
use App\Http\Controllers\Pos\WaktuController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\vendor\Chatify\MessagesController;
use App\Models\SuratMasuk;
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


// Walas All Route
Route::controller(WalasController::class)->middleware(['auth'])->group(function () {
    Route::get('/walas/all', 'WalasAll')->name('walas.all');
    Route::get('/walas/add', 'WalasAdd')->name('walas.add');
    Route::post('/walas/store', 'WalasStore')->name('walas.store');
    Route::get('/walas/delete{id}', 'WalasDelete')->name('walas.delete');
    Route::get('/walas/edit/{id}', 'WalasEdit')->name('walas.edit');
    Route::post('/walas/update', 'WalasUpdate')->name('walas.update');
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
