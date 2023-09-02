<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Pos\AbsensiController;
use App\Http\Controllers\Pos\GuruController;
use App\Http\Controllers\Pos\JabatanController;
use App\Http\Controllers\Pos\KelasController;
use App\Http\Controllers\Pos\MapelController;
use App\Http\Controllers\Pos\NaskahController;
use App\Http\Controllers\Pos\OrangTuaController;
use App\Http\Controllers\Pos\SiswaController;
use App\Http\Controllers\Pos\SuratKeluarController;
use App\Http\Controllers\Pos\SuratMasukController;
use App\Http\Controllers\Pos\TamuController;
use App\Http\Controllers\Pos\UserController;
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

// Jabatan All Route
Route::controller(JabatanController::class)->middleware(['auth'])->group(function () {
    Route::get('/jabatan/all', 'JabatanAll')->name('jabatan.all');
    Route::get('/jabatan/add', 'JabatanAdd')->name('jabatan.add');
    Route::post('/jabatan/store', 'JabatanStore')->name('jabatan.store');
    Route::get('/jabatan/edit/{id}', 'JabatanEdit')->name('jabatan.edit');
    Route::post('/jabatan/update', 'JabatanUpdate')->name('jabatan.update');
    Route::get('/jabatan/delete{id}', 'JabatanDelete')->name('jabatan.delete');
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

// Surat Masuk All Route
Route::controller(SuratMasukController::class)->middleware(['auth'])->group(function () {
    Route::get('/suratmasuk/all', 'SuratMasukAll')->name('surat.masuk.all');
    Route::get('/suratmasuk/add', 'SuratMasukAdd')->name('surat.masuk.add');
    Route::post('/suratmasuk/store', 'SuratMasukStore')->name('surat.masuk.store');
    Route::get('/suratmasuk/delete{id}', 'SuratMasukDelete')->name('surat.masuk.delete');
    Route::get('/suratmasuk/view/{id}', 'SuratMasukView')->name('surat.masuk.view');
    Route::get('/suratmasukterkirim/all', 'SuratMasukTerkirimAll')->name('surat.masuk.terkirim.all');
    Route::get('/suratmasukterkirim/view/{id}', 'SuratMasukTerkirimView')->name('surat.masuk.terkirim.view');
    Route::get('/suratmasukterkirim/delete{id}', 'SuratMasukTerkirimDelete')->name('surat.masuk.terkirim.delete');
    Route::post('/suratmasukdisposisi/store', 'SuratMasukDisposisiStore')->name('surat.masuk.disposisi.store');
    Route::get('/suratmasukdisposisi/delete{id}', 'SuratMasukDisposisiDelete')->name('surat.masuk.disposisi.delete');
    Route::get('/suratmasuk/approve/{id}', 'SuratMasukDisposisiApprove')->name('surat.masuk.disposisi.approve');
    Route::post('/suratmasuk/tujuan/store', 'SuratMasukTujuanStore')->name('surat.masuk.tujuan.store');
    Route::get('/suratmasuk/report', 'SuratMasukReport')->name('surat.masuk.report');
});

// Naskah All Route
Route::controller(NaskahController::class)->middleware(['auth'])->group(function () {
    Route::get('/naskah/all', 'NaskahAll')->name('naskah.all');
    Route::get('/naskah/add', 'NaskahAdd')->name('naskah.add');
    Route::post('/naskah/store', 'NaskahStore')->name('naskah.store');
    Route::get('/naskah/edit/{id}', 'NaskahEdit')->name('naskah.edit');
    Route::post('/naskah/update', 'NaskahUpdate')->name('naskah.update');
    Route::get('/naskah/delete{id}', 'NaskahDelete')->name('naskah.delete');
});

// Ckeditor Route
Route::post('/upload', [\App\Http\Controllers\EditorController::class, 'uploadimage'])->name('ckeditor.upload');



// Surat Masuk All Route
Route::controller(SuratKeluarController::class)->middleware(['auth'])->group(function () {
    Route::get('/suratkeluar/informasi', 'SuratKeluarInformasi')->name('surat.keluar.informasi');
    Route::post('/suratkeluarinformasi/store', 'SuratKeluarInformasiStore')->name('surat.keluar.informasi.store');
    Route::get('/suratkeluar/tujuan/{id}', 'SuratKeluarTujuan')->name('surat.keluar.tujuan');
    Route::post('/suratkeluartujuan/store', 'SuratKeluarTujuanStore')->name('surat.keluar.tujuan.store');
    Route::get('/suratkeluar/isi/{id}', 'SuratKeluarIsi')->name('surat.keluar.isi');
    Route::post('/suratkeluartujuan/update', 'SuratKeluarTujuanUpdate')->name('surat.keluar.tujuan.update');
    Route::get('/suratkeluartujuan/delete{id}', 'SuratKeluarTujuanDelete')->name('surat.keluar.tujuan.delete');
    Route::post('/suratkeluartembusan/store', 'SuratKeluarTembusanStore')->name('surat.keluar.tembusan.store');
    Route::get('/suratkeluartembusan/delete{id}', 'SuratKeluarTembusanDelete')->name('surat.keluar.tembusan.delete');
    Route::post('/suratkeluarlampiran/store', 'SuratKeluarLampiranStore')->name('surat.keluar.lampiran.store');
    Route::get('/suratkeluarlampiran/delete{id}', 'SuratKeluarLampiranDelete')->name('surat.keluar.lampiran.delete');
    Route::post('/suratkeluarTerkirim/store', 'SuratKeluarTerkirimStore')->name('surat.keluar.terkirim.store');
    Route::get('/suratkeluar/all', 'SuratKeluarAll')->name('surat.keluar.all');
    Route::get('/suratkeluar/verifikasi', 'SuratKeluarVerifikasi')->name('surat.keluar.verifikasi');
    Route::post('/suratkeluarverifikasi/store', 'SuratKeluarVerifikasiStore')->name('surat.keluar.verifikasi.store');
    Route::post('/suratkeluarverifikasi/tolak', 'SuratKeluarVerifikasiTolak')->name('surat.keluar.verifikasi.tolak');
    Route::get('/suratkeluar/tandatangan', 'SuratKeluarTandatangan')->name('surat.keluar.tandatangan');
    Route::post('/suratkeluartandatangan/cetak', 'SuratKeluarTandatanganCetak')->name('surat.keluar.tandatangan.cetak');
    Route::post('/suratkeluartandatangan/gambar', 'SuratKeluarTandatanganGambar')->name('surat.keluar.tandatangan.gambar');
    //   Route::post('/suratkeluartandatangan/langsung', 'SuratKeluarTandatanganLangsung')->name('surat.keluar.tandatangan.langsung');
    Route::get('/suratkeluar/report', 'SuratKeluarReport')->name('surat.keluar.report');
    Route::get('/suratkeluar/delete{id}', 'SuratKeluarDelete')->name('surat.keluar.delete');
});



// Tamu All Route
Route::controller(TamuController::class)->middleware(['auth'])->group(function () {
    Route::get('/tamu/all', 'TamuAll')->name('tamu.all');
    Route::get('/tamu/add', 'TamuAdd')->name('tamu.add');
    Route::post('/tamu/store', 'TamuStore')->name('tamu.store');
    Route::get('/tamu/delete{id}', 'TamuDelete')->name('tamu.delete');
    Route::get('/tamu/selesai{id}', 'TamuSelesai')->name('tamu.selesai');
    Route::post('/tamu/store/frontend', 'TamuStoreFrontend')->name('tamu.store.frontend');
    Route::get('/tamu/report', 'TamuReport')->name('tamu.report');
    Route::get('/tamu/report/pdf', 'TamuReportPdf')->name('tamu.report.pdf');
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
});




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


