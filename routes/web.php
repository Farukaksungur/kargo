<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MarkaController;
use App\Http\Controllers\MusteriController;
use App\Http\Controllers\OdemeController;
use App\Http\Controllers\RaporController;
use App\Http\Controllers\FinansalController;
use App\Http\Controllers\GelirGiderController;
use App\Http\Controllers\FaturaController;
use App\Http\Controllers\KullaniciController;
use App\Http\Controllers\AyarController;
use App\Http\Controllers\KargoFirmasiController;
use App\Http\Controllers\BasitKargoController;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::resource('markalar', MarkaController::class);
Route::resource('musteriler', MusteriController::class);
Route::post('odemeler', [OdemeController::class, 'store'])->name('odemeler.store');
Route::get('markalar/{markaId}/kargo/{kargoId}', [MarkaController::class, 'kargoDetay'])->name('markalar.kargo.detay');
Route::get('musteriler/{musteriId}/kargo/{kargoId}', [MusteriController::class, 'kargoDetay'])->name('musteriler.kargo.detay');

// Raporlar ve Analitik
Route::resource('raporlar', RaporController::class);
Route::get('raporlar/{tip}/olustur', [RaporController::class, 'olustur'])->name('raporlar.olustur');
Route::get('raporlar/{tip}/pdf', [RaporController::class, 'pdf'])->name('raporlar.pdf');
Route::get('raporlar/{tip}/excel', [RaporController::class, 'excel'])->name('raporlar.excel');
Route::get('markalar/export/excel', [MarkaController::class, 'export'])->name('markalar.excel');
Route::get('musteriler/export/excel', [MusteriController::class, 'export'])->name('musteriler.excel');

// Finansal Yönetim
Route::get('finansal', [FinansalController::class, 'index'])->name('finansal.index');
Route::resource('gelir-gider', GelirGiderController::class);
Route::resource('faturalar', FaturaController::class);

// Kullanıcı ve Yetki Yönetimi
Route::resource('kullanicilar', KullaniciController::class);
Route::get('sifre-degistir', [KullaniciController::class, 'sifreDegistir'])->name('kullanicilar.sifre-degistir');
Route::post('sifre-guncelle', [KullaniciController::class, 'sifreGuncelle'])->name('kullanicilar.sifre-guncelle');
Route::get('islem-loglari', [KullaniciController::class, 'loglar'])->name('kullanicilar.loglar');

// Ayarlar
Route::get('ayarlar', [AyarController::class, 'index'])->name('ayarlar.index');
Route::post('ayarlar', [AyarController::class, 'store'])->name('ayarlar.store');
Route::resource('kargo-firmalari', KargoFirmasiController::class);

// Basit Kargo API
Route::prefix('basitkargo')->name('basitkargo.')->group(function() {
    Route::get('handlers', [BasitKargoController::class, 'getHandlers'])->name('handlers');
    Route::get('fee', [BasitKargoController::class, 'getFee'])->name('fee');
    Route::post('kargo/{kargoId}/create', [BasitKargoController::class, 'createKargo'])->name('kargo.create');
    Route::get('kargo/{kargoId}/status', [BasitKargoController::class, 'getKargoStatus'])->name('kargo.status');
    Route::get('kargo/{kargoId}/label', [BasitKargoController::class, 'downloadLabel'])->name('kargo.label');
    Route::post('sync-statuses', [BasitKargoController::class, 'syncStatuses'])->name('sync.statuses');
    Route::post('webhook', [BasitKargoController::class, 'webhook'])->name('webhook');
});

// Logout
Route::post('logout', function() {
    auth()->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->name('logout');
