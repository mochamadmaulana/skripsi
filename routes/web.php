<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {

    Route::get('/', [\App\Http\Controllers\Auth\LoginController::class, 'index'])->name('login');
    Route::post('/', [\App\Http\Controllers\Auth\LoginController::class, 'store'])->name('login.store');
});

Route::middleware('auth')->group(function () {

    Route::get('redirect-auth', function () {
        if(Auth::user()->role == 'Admin'){
            session()->flash('error', 'Akses Ditolak!');
            return redirect()->route('admin.dashboard');
        }elseif(Auth::user()->role == 'Kepala Sekolah'){
            session()->flash('error', 'Akses Ditolak!');
            return redirect()->route('kepala-sekolah.dashboard');
        }else{
            session()->flash('error', 'Akses Ditolak!');
            return redirect()->route('user.dashboard');
        }
    });

    Route::get('logout', [\App\Http\Controllers\Auth\LogoutController::class, 'index'])->name('logout');

    // Route Untuk Role Admin
    Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
        Route::get('dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

        Route::prefix('data-master')->name('data-master.')->group(function () {
            Route::resource('jabatan', \App\Http\Controllers\Admin\DataMaster\JabatanController::class)->except('show');
        });

        Route::resource('surat-masuk', \App\Http\Controllers\Admin\SuratMasukController::class);
        Route::get('surat-masuk/{suratmasuk}/akses-surat/{aksessurat}/delete', [\App\Http\Controllers\Admin\SuratMasukController::class, 'delete_akses']);
        Route::get('surat-masuk/delete-file/{id}', [\App\Http\Controllers\Admin\SuratMasukController::class, 'delete_file'])->name('delete-file-surat-masuk');
        Route::post('surat-masuk/add-file/{id}', [\App\Http\Controllers\Admin\SuratMasukController::class, 'add_file'])->name('add-file-surat-masuk');

        Route::resource('surat-keluar', \App\Http\Controllers\Admin\SuratKeluarController::class);
        Route::get('surat-keluar/{suratkeluar}/akses-surat/{aksessurat}/delete', [\App\Http\Controllers\Admin\SuratKeluarController::class, 'delete_akses']);
        Route::get('surat-keluar/delete-file/{id}', [\App\Http\Controllers\Admin\SuratKeluarController::class, 'delete_file'])->name('delete-file-surat-keluar');
        Route::post('surat-keluar/add-file/{id}', [\App\Http\Controllers\Admin\SuratKeluarController::class, 'add_file'])->name('add-file-surat-keluar');

        Route::prefix('arsip-surat')->name('arsip-surat.')->group(function () {
            Route::get('surat-masuk', [\App\Http\Controllers\Admin\ArsipSurat\SuratMasukController::class, 'index'])->name('surat-masuk.index');
            Route::post('surat-masuk/search', [\App\Http\Controllers\Admin\ArsipSurat\SuratMasukController::class, 'search'])->name('surat-masuk.search');

            Route::get('surat-keluar', [\App\Http\Controllers\Admin\ArsipSurat\SuratKeluarController::class, 'index'])->name('surat-keluar.index');
            Route::post('surat-keluar/search', [\App\Http\Controllers\Admin\ArsipSurat\SuratKeluarController::class, 'search'])->name('surat-keluar.search');
        });

        Route::prefix('laporan-surat')->name('laporan-surat.')->group(function () {
            Route::get('surat-masuk', [\App\Http\Controllers\Admin\LaporanSurat\SuratMasukController::class, 'index'])->name('surat-masuk.index');
            Route::post('surat-masuk/export-excel', [\App\Http\Controllers\Admin\LaporanSurat\SuratMasukController::class, 'export_excel'])->name('surat-masuk.export-excel');

            Route::get('surat-keluar', [\App\Http\Controllers\Admin\LaporanSurat\SuratKeluarController::class, 'index'])->name('surat-keluar.index');
            Route::post('surat-keluar/export-excel', [\App\Http\Controllers\Admin\LaporanSurat\SuratKeluarController::class, 'export_excel'])->name('surat-keluar.export-excel');
        });

        Route::resource('pengguna', \App\Http\Controllers\Admin\PenggunaController::class)->except('show');

        Route::get('profile',[App\Http\Controllers\Admin\ProfileController::class,'index'])->name('profile.index');
        Route::put('profile/update',[App\Http\Controllers\Admin\ProfileController::class,'update_profile'])->name('profile.update-profile');
        Route::put('profile/update-password',[App\Http\Controllers\Admin\ProfileController::class,'update_password'])->name('profile.update-password');
        Route::put('profile/update-avatar',[App\Http\Controllers\Admin\ProfileController::class,'update_avatar'])->name('profile.update-avatar');

    });

    // Route Untuk Role Kepala Sekolah
    Route::prefix('kepala-sekolah')->name('kepala-sekolah.')->middleware('kepala-sekolah')->group(function () {
        Route::get('dashboard', [\App\Http\Controllers\KepalaSekolah\DashboardController::class, 'index'])->name('dashboard');

        Route::resource('surat-masuk', \App\Http\Controllers\KepalaSekolah\SuratMasukController::class)->only('index','show');

        Route::get('surat-keluar', [\App\Http\Controllers\KepalaSekolah\SuratKeluarController::class,'index'])->name('surat-keluar.index');
        Route::get('surat-keluar/show/{id}', [\App\Http\Controllers\KepalaSekolah\SuratKeluarController::class,'show'])->name('surat-keluar.show');
        Route::get('surat-keluar/setuju/{id}', [\App\Http\Controllers\KepalaSekolah\SuratKeluarController::class,'setuju'])->name('surat-keluar.setuju');
        Route::get('surat-keluar/tolak/{id}', [\App\Http\Controllers\KepalaSekolah\SuratKeluarController::class,'tolak'])->name('surat-keluar.tolak');

        Route::prefix('arsip-surat')->name('arsip-surat.')->group(function () {
            Route::get('surat-masuk', [\App\Http\Controllers\KepalaSekolah\ArsipSurat\SuratMasukController::class, 'index'])->name('surat-masuk.index');
            Route::post('surat-masuk/search', [\App\Http\Controllers\KepalaSekolah\ArsipSurat\SuratMasukController::class, 'search'])->name('surat-masuk.search');

            Route::get('surat-keluar', [\App\Http\Controllers\KepalaSekolah\ArsipSurat\SuratKeluarController::class, 'index'])->name('surat-keluar.index');
            Route::post('surat-keluar/search', [\App\Http\Controllers\KepalaSekolah\ArsipSurat\SuratKeluarController::class, 'search'])->name('surat-keluar.search');
        });

        Route::prefix('laporan-surat')->name('laporan-surat.')->group(function () {
            Route::get('surat-masuk', [\App\Http\Controllers\KepalaSekolah\LaporanSurat\SuratMasukController::class, 'index'])->name('surat-masuk.index');
            Route::post('surat-masuk/export-excel', [\App\Http\Controllers\KepalaSekolah\LaporanSurat\SuratMasukController::class, 'export_excel'])->name('surat-masuk.export-excel');

            Route::get('surat-keluar', [\App\Http\Controllers\KepalaSekolah\LaporanSurat\SuratKeluarController::class, 'index'])->name('surat-keluar.index');
            Route::post('surat-keluar/export-excel', [\App\Http\Controllers\KepalaSekolah\LaporanSurat\SuratKeluarController::class, 'export_excel'])->name('surat-keluar.export-excel');
        });

        Route::get('profile',[App\Http\Controllers\KepalaSekolah\ProfileController::class,'index'])->name('profile.index');
        Route::put('profile/update',[App\Http\Controllers\KepalaSekolah\ProfileController::class,'update_profile'])->name('profile.update-profile');
        Route::put('profile/update-password',[App\Http\Controllers\KepalaSekolah\ProfileController::class,'update_password'])->name('profile.update-password');
        Route::put('profile/update-avatar',[App\Http\Controllers\KepalaSekolah\ProfileController::class,'update_avatar'])->name('profile.update-avatar');
    });

    // Route Untuk Role User
    Route::prefix('user')->name('user.')->middleware('user')->group(function () {
        Route::get('dashboard', [\App\Http\Controllers\User\DashboardController::class, 'index'])->name('dashboard');

        Route::resource('surat-masuk', \App\Http\Controllers\User\SuratMasukController::class)->only('index','show');
        Route::resource('surat-keluar', \App\Http\Controllers\User\SuratKeluarController::class)->only('index','show');

        Route::get('profile',[App\Http\Controllers\User\ProfileController::class,'index'])->name('profile.index');
        Route::put('profile/update',[App\Http\Controllers\User\ProfileController::class,'update_profile'])->name('profile.update-profile');
        Route::put('profile/update-password',[App\Http\Controllers\User\ProfileController::class,'update_password'])->name('profile.update-password');
        Route::put('profile/update-avatar',[App\Http\Controllers\User\ProfileController::class,'update_avatar'])->name('profile.update-avatar');
    });

});
