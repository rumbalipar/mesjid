<?php

use App\Http\Controllers\ApprovalController;
use App\Http\Controllers\ArusKasController;
use App\Http\Controllers\CompanyProfileController;
use App\Http\Controllers\GrafikController;
use App\Http\Controllers\GroupModuleController;
use App\Http\Controllers\GroupUserController;
use App\Http\Controllers\KategoriPemasukanController;
use App\Http\Controllers\KategoriPengeluaranController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\PengajuanController;
use App\Http\Controllers\SaldoKeluarController;
use App\Http\Controllers\SaldoMasukController;
use App\Http\Controllers\TipePembayaranController;
use App\Http\Controllers\TransaksiSaldoController;
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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/',[MainController::class,'index'])->name('index');
Route::get('/login',[MainController::class,'indexLogin'])->name('index.login');
Route::post('/login',[MainController::class,'login'])->name('login');

Route::prefix('grafik')->group(function(){
    Route::get('/month',[GrafikController::class,'month'])->name('grafik.month');
    Route::get('/year',[GrafikController::class,'year'])->name('grafik.year');
});

Route::prefix('laporan')->group(function(){
    Route::get('/month',[LaporanController::class,'month'])->name('laporan.month');
    Route::get('/aruskas',[LaporanController::class,'arusKas'])->name('laporan.aruskas');
    Route::get('/aruskas/pdf',[LaporanController::class,'arusKasPdf'])->name('laporan.aruskas.pdf');
});


Route::prefix('transaksisaldo')->group(function(){
    Route::get('/',[TransaksiSaldoController::class,'index'])->name('transaksisaldo.index');
    Route::get('/saldomasuk/{tanggal}',[TransaksiSaldoController::class,'viewSaldoMasuk'])->name('transaksisaldo.saldomasuk');
    Route::get('/saldokeluar/{tanggal}',[TransaksiSaldoController::class,'viewSaldoKeluar'])->name('transaksisaldo.saldokeluar');
    Route::get('/saldomasukweb/{tanggal}',[TransaksiSaldoController::class,'viewSaldoMasukWeb'])->name('transaksisaldo.saldomasuk.web');
    Route::get('/saldokeluarweb/{tanggal}',[TransaksiSaldoController::class,'viewSaldoKeluarWeb'])->name('transaksisaldo.saldokeluar.web');
});

Route::group(['middleware' => ['authCheck']],function(){
    Route::get('/home',[MainController::class,'home'])->name('home');
    Route::get('/logout',[MainController::class,'logout'])->name('logout');
    Route::get('ubahpassword', [MainController::class, 'ubahPassword'])->name('ubahpassword');
    Route::post('ubahpassword', [MainController::class, 'changePassword'])->name('changepassword');

    Route::prefix('groupuser')->group(function () {
        Route::get('/', [GroupUserController::class, 'index'])->name('groupuser.index');
        Route::get('/create', [GroupUserController::class, 'create'])->name('groupuser.create');
        Route::post('/create', [GroupUserController::class, 'store'])->name('groupuser.store');
        Route::get('/edit/{id}', [GroupUserController::class, 'edit'])->name('groupuser.edit');
        Route::post('/edit/{id}', [GroupUserController::class, 'update'])->name('groupuser.update');
        Route::get('/delete/{id}', [GroupUserController::class, 'delete'])->name('groupuser.delete');
        Route::post('/delete/{id}', [GroupUserController::class, 'destroy'])->name('groupuser.destroy');
    });

    Route::prefix('user')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('user.index');
        Route::get('/create', [UserController::class, 'create'])->name('user.create');
        Route::post('/create', [UserController::class, 'store'])->name('user.store');
        Route::get('/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
        Route::post('/edit/{id}', [UserController::class, 'update'])->name('user.update');
        Route::get('/delete/{id}', [UserController::class, 'delete'])->name('user.delete');
        Route::post('/delete/{id}', [UserController::class, 'destroy'])->name('user.destroy');
    });

    Route::prefix('groupmodule')->group(function () {
        Route::get('/', [GroupModuleController::class, 'index'])->name('groupmodule.index');
        Route::get('/create', [GroupModuleController::class, 'create'])->name('groupmodule.create');
        Route::post('/create', [GroupModuleController::class, 'store'])->name('groupmodule.store');
        Route::get('/edit/{id}', [GroupModuleController::class, 'edit'])->name('groupmodule.edit');
        Route::post('/edit/{id}', [GroupModuleController::class, 'update'])->name('groupmodule.update');
        Route::get('/delete/{id}', [GroupModuleController::class, 'delete'])->name('groupmodule.delete');
        Route::post('/delete/{id}', [GroupModuleController::class, 'destroy'])->name('groupmodule.destroy');
    });

    Route::prefix('module')->group(function () {
        Route::get('/', [ModuleController::class, 'index'])->name('module.index');
        Route::get('/create', [ModuleController::class, 'create'])->name('module.create');
        Route::post('/create', [ModuleController::class, 'store'])->name('module.store');
        Route::get('/edit/{id}', [ModuleController::class, 'edit'])->name('module.edit');
        Route::post('/edit/{id}', [ModuleController::class, 'update'])->name('module.update');
        Route::get('/delete/{id}', [ModuleController::class, 'delete'])->name('module.delete');
        Route::post('/delete/{id}', [ModuleController::class, 'destroy'])->name('module.destroy');
    });

    Route::prefix('companyprofile')->group(function(){
        Route::get('/', [CompanyProfileController::class, 'index'])->name('companyprofile.index');
        Route::post('/', [CompanyProfileController::class, 'post'])->name('companyprofile.post');
    });

    Route::prefix('kategoripemasukan')->group(function(){
        Route::get('/', [KategoriPemasukanController::class, 'index'])->name('kategoripemasukan.index');
        Route::get('/create', [KategoriPemasukanController::class, 'create'])->name('kategoripemasukan.create');
        Route::post('/create', [KategoriPemasukanController::class, 'store'])->name('kategoripemasukan.store');
        Route::get('/edit/{id}', [KategoriPemasukanController::class, 'edit'])->name('kategoripemasukan.edit');
        Route::post('/edit/{id}', [KategoriPemasukanController::class, 'update'])->name('kategoripemasukan.update');
        Route::get('/delete/{id}', [KategoriPemasukanController::class, 'delete'])->name('kategoripemasukan.delete');
        Route::post('/delete/{id}', [KategoriPemasukanController::class, 'destroy'])->name('kategoripemasukan.destroy');
    });

    Route::prefix('kategoripengeluaran')->group(function(){
        Route::get('/', [KategoriPengeluaranController::class, 'index'])->name('kategoripengeluaran.index');
        Route::get('/create', [KategoriPengeluaranController::class, 'create'])->name('kategoripengeluaran.create');
        Route::post('/create', [KategoriPengeluaranController::class, 'store'])->name('kategoripengeluaran.store');
        Route::get('/edit/{id}', [KategoriPengeluaranController::class, 'edit'])->name('kategoripengeluaran.edit');
        Route::post('/edit/{id}', [KategoriPengeluaranController::class, 'update'])->name('kategoripengeluaran.update');
        Route::get('/delete/{id}', [KategoriPengeluaranController::class, 'delete'])->name('kategoripengeluaran.delete');
        Route::post('/delete/{id}', [KategoriPengeluaranController::class, 'destroy'])->name('kategoripengeluaran.destroy');
    });

    Route::prefix('tipepembayaran')->group(function(){
        Route::get('/', [TipePembayaranController::class, 'index'])->name('tipepembayaran.index');
        Route::get('/create', [TipePembayaranController::class, 'create'])->name('tipepembayaran.create');
        Route::post('/create', [TipePembayaranController::class, 'store'])->name('tipepembayaran.store');
        Route::get('/edit/{id}', [TipePembayaranController::class, 'edit'])->name('tipepembayaran.edit');
        Route::post('/edit/{id}', [TipePembayaranController::class, 'update'])->name('tipepembayaran.update');
        Route::get('/delete/{id}', [TipePembayaranController::class, 'delete'])->name('tipepembayaran.delete');
        Route::post('/delete/{id}', [TipePembayaranController::class, 'destroy'])->name('tipepembayaran.destroy');
    });

    Route::prefix('saldomasuk')->group(function(){
        Route::get('/', [SaldoMasukController::class, 'index'])->name('saldomasuk.index');
        Route::get('/create', [SaldoMasukController::class, 'create'])->name('saldomasuk.create');
        Route::post('/create', [SaldoMasukController::class, 'store'])->name('saldomasuk.store');
        Route::get('/edit/{id}', [SaldoMasukController::class, 'edit'])->name('saldomasuk.edit');
        Route::post('/edit/{id}', [SaldoMasukController::class, 'update'])->name('saldomasuk.update');
        Route::get('/delete/{id}', [SaldoMasukController::class, 'delete'])->name('saldomasuk.delete');
        Route::post('/delete/{id}', [SaldoMasukController::class, 'destroy'])->name('saldomasuk.destroy');
    });

    Route::prefix('saldomasuk')->group(function(){
        Route::get('/', [SaldoMasukController::class, 'index'])->name('saldomasuk.index');
        Route::get('/create', [SaldoMasukController::class, 'create'])->name('saldomasuk.create');
        Route::post('/create', [SaldoMasukController::class, 'store'])->name('saldomasuk.store');
        Route::get('/edit/{id}', [SaldoMasukController::class, 'edit'])->name('saldomasuk.edit');
        Route::post('/edit/{id}', [SaldoMasukController::class, 'update'])->name('saldomasuk.update');
        Route::get('/delete/{id}', [SaldoMasukController::class, 'delete'])->name('saldomasuk.delete');
        Route::post('/delete/{id}', [SaldoMasukController::class, 'destroy'])->name('saldomasuk.destroy');
        Route::get('/kwitansi/{id}', [SaldoMasukController::class, 'kwitansi'])->name('saldomasuk.kwitansi');
    });

    Route::prefix('saldokeluar')->group(function(){
        Route::get('/', [SaldoKeluarController::class, 'index'])->name('saldokeluar.index');
        Route::get('/create', [SaldoKeluarController::class, 'create'])->name('saldokeluar.create');
        Route::post('/create', [SaldoKeluarController::class, 'store'])->name('saldokeluar.store');
        Route::get('/edit/{id}', [SaldoKeluarController::class, 'edit'])->name('saldokeluar.edit');
        Route::post('/edit/{id}', [SaldoKeluarController::class, 'update'])->name('saldokeluar.update');
        Route::get('/delete/{id}', [SaldoKeluarController::class, 'delete'])->name('saldokeluar.delete');
        Route::post('/delete/{id}', [SaldoKeluarController::class, 'destroy'])->name('saldokeluar.destroy');
    });

    Route::prefix('pengajuan')->group(function(){
        Route::get('/', [PengajuanController::class, 'index'])->name('pengajuan.index');
        Route::get('/create', [PengajuanController::class, 'create'])->name('pengajuan.create');
        Route::post('/create', [PengajuanController::class, 'store'])->name('pengajuan.store');
        Route::get('/edit/{id}', [PengajuanController::class, 'edit'])->name('pengajuan.edit');
        Route::post('/edit/{id}', [PengajuanController::class, 'update'])->name('pengajuan.update');
        Route::get('/delete/{id}', [PengajuanController::class, 'delete'])->name('pengajuan.delete');
        Route::post('/delete/{id}', [PengajuanController::class, 'destroy'])->name('pengajuan.destroy');
        Route::get('/proses/{id}', [PengajuanController::class, 'proses'])->name('pengajuan.proses');
        Route::post('/proses/{id}', [PengajuanController::class, 'prosesPost'])->name('pengajuan.proses.post');
    });

    Route::prefix('approval')->group(function(){
        Route::get('/',[ApprovalController::class,'index'])->name('approval.index');
        Route::get('/input/{id}',[ApprovalController::class,'input'])->name('approval.input');
        Route::post('/input/{id}',[ApprovalController::class,'post'])->name('approval.post');
        Route::get('/reset/{id}',[ApprovalController::class,'reset'])->name('approval.reset');
        Route::post('/reset/{id}',[ApprovalController::class,'postReset'])->name('approval.reset.post');
    });

    Route::prefix('aruskas')->group(function(){
        Route::get('/', [ArusKasController::class, 'index'])->name('aruskas.index');
        Route::get('/create', [ArusKasController::class, 'create'])->name('aruskas.create');
        Route::post('/create', [ArusKasController::class, 'store'])->name('aruskas.store');
        Route::get('/edit/{id}', [ArusKasController::class, 'edit'])->name('aruskas.edit');
        Route::post('/edit/{id}', [ArusKasController::class, 'update'])->name('aruskas.update');
        Route::get('/delete/{id}', [ArusKasController::class, 'delete'])->name('aruskas.delete');
        Route::post('/delete/{id}', [ArusKasController::class, 'destroy'])->name('aruskas.destroy');

        Route::prefix('aruskasmasuk')->group(Function(){
            Route::get('/{id}', [ArusKasController::class, 'arusKasMasuk'])->name('aruskas.aruskasmasuk.index');
            Route::get('/create/{id}', [ArusKasController::class, 'arusKasMasukCreate'])->name('aruskas.aruskasmasuk.create');
            Route::post('/create/{id}', [ArusKasController::class, 'arusKasMasukStore'])->name('aruskas.aruskasmasuk.store');
            Route::get('/edit/{id}', [ArusKasController::class, 'arusKasMasukEdit'])->name('aruskas.aruskasmasuk.edit');
            Route::post('/edit/{id}', [ArusKasController::class, 'arusKasMasukUpdate'])->name('aruskas.aruskasmasuk.update');
            Route::get('/delete/{id}', [ArusKasController::class, 'arusKasMasukDelete'])->name('aruskas.aruskasmasuk.delete');
            Route::post('/delete/{id}', [ArusKasController::class, 'arusKasMasukDestroy'])->name('aruskas.aruskasmasuk.destroy');

            Route::prefix('kategoripemasukan')->group(function(){
                Route::get('/{id}',[ArusKasController::class,'arusKasMasukKategori'])->name('aruskas.aruskasmasuk.kategoripemasukan');
                Route::post('/post/{id}',[ArusKasController::class,'arusKasMasukKategoriPost'])->name('aruskas.aruskasmasuk.kategoripemasukan.post');
                Route::post('/delete/{id}/kategori/{kategoriid}',[ArusKasController::class,'arusKasMasukKategoriDestroy'])->name('aruskas.aruskasmasuk.kategoripemasukan.destroy');
            });

            Route::prefix('kategoripengeluaran')->group(function(){
                Route::get('/{id}',[ArusKasController::class,'arusKasKeluarKategori'])->name('aruskas.aruskaskeluar.kategoripengeluaran');
                Route::post('/post/{id}',[ArusKasController::class,'arusKasKeluarKategoriPost'])->name('aruskas.aruskaskeluar.kategoripengeluaran.post');
                Route::post('/delete/{id}/kategori/{kategoriid}',[ArusKasController::class,'arusKasKeluarKategoriDestroy'])->name('aruskas.aruskaskeluar.kategoripengeluaran.destroy');
            });
        });

        Route::prefix('aruskaskeluar')->group(Function(){
            Route::get('/{id}', [ArusKasController::class, 'arusKasKeluar'])->name('aruskas.aruskaskeluar.index');
            Route::get('/create/{id}', [ArusKasController::class, 'arusKasKeluarCreate'])->name('aruskas.aruskaskeluar.create');
            Route::post('/create/{id}', [ArusKasController::class, 'arusKasKeluarStore'])->name('aruskas.aruskaskeluar.store');
            Route::get('/edit/{id}', [ArusKasController::class, 'arusKasKeluarEdit'])->name('aruskas.aruskaskeluar.edit');
            Route::post('/edit/{id}', [ArusKasController::class, 'arusKasKeluarUpdate'])->name('aruskas.aruskaskeluar.update');
            Route::get('/delete/{id}', [ArusKasController::class, 'arusKasKeluarDelete'])->name('aruskas.aruskaskeluar.delete');
            Route::post('/delete/{id}', [ArusKasController::class, 'arusKasKeluarDestroy'])->name('aruskas.aruskaskeluar.destroy');
        });
    });
});


