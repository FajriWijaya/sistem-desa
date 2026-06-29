<?php

use App\Http\Controllers\DashboardContoller;
use App\Http\Controllers\DusunController;
use App\Http\Controllers\ImportAxcelController;
use App\Http\Controllers\KelahiranController;
use App\Http\Controllers\KeluargaController;
use App\Http\Controllers\KematianController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PendudukController;
use App\Http\Controllers\PindahKeluarController;
use App\Http\Controllers\PindahMasukController;
use App\Http\Controllers\RtController;
use App\Http\Controllers\RwController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware("auth")->group(function () {
    Route::get('/dashboard', [DashboardContoller::class, 'index'])->name('dashboard');
});

Route::get('/dashboard/chart', [DashboardContoller::class, 'chartData'])->name('chartData');
Route::get('/dashboard/chart-mutasi', [DashboardContoller::class, 'chartMutasi'])->name("chartMutasi");

Route::get('/dusun', [DusunController::class, 'index'])->name('dusun');
Route::post('/dusun/store', [DusunController::class, 'store'])->name('dusun.store');
Route::put('/dusun/update/{dusun}', [DusunController::class, 'update'])->name('dusun.update');
Route::delete('/dusun/destroy/{dusun}', [DusunController::class, 'destroy'])->name('dusun.destroy');
Route::get('/dusun/{dusun}/rw', [RwController::class, 'index'])->name('dusun.rw');
Route::post('/dusun/rw', [RwController::class, 'store'])->name('dusun.rw.store');
Route::put('/dusun/rw/{rw}/update', [RwController::class, 'update'])->name('dusun.rw.update');
Route::delete('/dusun/rw/{rw}/destroy', [RwController::class, 'destroy'])->name('dusun.rw.destroy');
Route::get('/dusun/rw/{rw}/rt', [RtController::class, 'index'])->name('dusun.rw.rt');
Route::post('/dusun/rw/rt', [RtController::class, 'store'])->name('dusun.rw.rt.store');
Route::put('/dusun/rw/rt/{rt}/update', [RtController::class, 'update'])->name('dusun.rw.rt.update');
Route::delete('/dusun/rw/{rt}/destroy', [RtController::class, 'destroy'])->name('dusun.rw.rt.destroy');

Route::get('/keluarga/rw', [KeluargaController::class, 'rw'])->name('keluarga.rw');
Route::get('/keluarga/rw/{rw}', [KeluargaController::class, 'index'])->name('keluarga');
Route::get('/keluarga/rw/{rw}/create', [KeluargaController::class, 'create'])->name('keluarga.create');
Route::post('/keluarga/', [KeluargaController::class, 'store'])->name('keluarga.store');
Route::get('/keluarga/{keluarga}', [KeluargaController::class, 'show'])->name('keluarga.show');
Route::get('/keluarga/{keluarga}/edit', [KeluargaController::class, 'edit'])->name('keluarga.edit');
Route::put('/keluarga/{keluarga}', [KeluargaController::class, 'update'])->name('keluarga.update');
Route::delete('/keluarga/{keluarga}', [KeluargaController::class, 'destroy'])->name('keluarga.destroy');
Route::post('/keluarga/{keluarga}/anggota', [KeluargaController::class, 'storeAnggotaKeluarga'])->name('keluarga.anggota.store');
Route::put('/keluarga/anggota/{anggota}', [KeluargaController::class, 'updateAnggotaKeluarga'])->name('keluarga.anggota.update');
Route::delete('/keluarga/anggota/{anggota}', [KeluargaController::class, 'destroyAnggotaKeluarga'])->name('keluarga.anggota.destroy');


Route::get('/penduduk/rw', [PendudukController::class, 'rw'])->name('penduduk.rw');
Route::get('/penduduk/rw/{rw}', [PendudukController::class, 'index'])->name('penduduk.index');
Route::get('/penduduk/{penduduk}/show', [PendudukController::class, 'show'])->name('penduduk.show');
Route::get('/penduduk/{rw}/tambah', [PendudukController::class, 'tambah'])->name('penduduk.tambah');
Route::post('/penduduk/create', [PendudukController::class, 'store'])->name('penduduk.store');
Route::post('penduduk/{rw}/import', [ImportAxcelController::class, 'import'])->name('penduduk.import');
Route::get('penduduk/template', [ImportAxcelController::class, 'downloadTemplate'])->name('penduduk.template');
Route::get('/penduduk/{penduduk}/edit', [PendudukController::class, 'edit'])->name('penduduk.edit');
Route::put('/penduduk/{penduduk}', [PendudukController::class, 'update'])->name('penduduk.update');
Route::delete('/penduduk/{penduduk}', [PendudukController::class, 'destroy'])->name('penduduk.destroy');

Route::get('/pindah_masuk/rw', [PindahMasukController::class, 'rw'])->name('pindah_masuk.rw');
Route::post('/pindah_masuk/rw/{rw}/filter', [PindahMasukController::class, 'filter'])->name('pindah_masuk.filter');
Route::get('/pindah_masuk/rw/{rw}', [PindahMasukController::class, 'index'])->name('pindah_masuk');
Route::get('/pindah_masuk/rw/{rw}/print', [PindahMasukController::class, 'print'])->name('pindah_masuk.print');
Route::get('/pindah_masuk/rw/{rw}/pdf', [PindahMasukController::class, 'ExportPDF'])->name('pindah_masuk.pdf');
Route::get('/pindah_masuk/{rw}/create/', [PindahMasukController::class, 'create'])->name('pindah_masuk.create');
Route::post('/pindah_masuk/', [PindahMasukController::class, 'store'])->name('pindah_masuk.store');
Route::get('/pindah_masuk/{perpindahan}', [PindahMasukController::class, 'edit'])->name('pindah_masuk.edit');
Route::put('/pindah_masuk/{perpindahan}', [PindahMasukController::class, 'update'])->name('pindah_masuk.update');
Route::get('/pindah_masuk/dusun', [PindahMasukController::class, 'dusun'])->name('pindah_masuk.dusun');
Route::delete('/pindah_masuk/{perpindahan}', [PindahMasukController::class, 'destroy'])->name('pindah_masuk.destroy');

Route::get('/pindah_keluar/rw', [PindahKeluarController::class, 'rw'])->name('pindah_keluar.rw');
Route::get('/pindah_keluar/rw/{rw}', [PindahKeluarController::class, 'index'])->name('pindah_keluar');
Route::post('/pindah_keluar/rw/{rw}/filter', [PindahKeluarController::class, 'filter'])->name('pindah_keluar.filter');
Route::get('/pindah_keluar/rw/{rw}/print', [PindahKeluarController::class, 'print'])->name('pindah_keluar.print');
Route::get('/pindah_keluar/rw/{rw}/pdf', [PindahKeluarController::class, 'ExportPDF'])->name('pindah_keluar.pdf');
Route::get('/pindah_keluar/{rw}/create', [PindahKeluarController::class, 'create'])->name('pindah_keluar.create');
Route::get('/pindah_keluar/{perpindahan}/edit', [PindahKeluarController::class, 'edit'])->name('pindah_keluar.edit');
Route::put('/pindah_keluar/{perpindahan}', [PindahKeluarController::class, 'update'])->name('pindah_keluar.update');
Route::post('/pindah_keluar/', [PindahKeluarController::class, 'store'])->name('pindah_keluar.store');



Route::get('/kelahiran/rw', [KelahiranController::class, 'rw'])->name('kelahiran.rw');
Route::get('/kelahiran/rw/{rw}', [KelahiranController::class, 'index'])->name('kelahiran');
Route::post('/kelahiran/rw/{rw}/filter', [KelahiranController::class, 'filter'])->name('kelahiran.filter');
Route::get('/kelahiran/rw/{rw}/print', [KelahiranController::class, 'print'])->name('kelahiran.print');
Route::get('/kelahiran/rw/{rw}/pdf', [KelahiranController::class, 'ExportPDF'])->name('kelahiran.pdf');
Route::get('/kelahiran/rw/{rw}/create', [KelahiranController::class, 'create'])->name('kelahiran.create');
Route::post('/kelahiran/', [KelahiranController::class, 'store'])->name('kelahiran.store');
Route::get('/kelahiran/{kelahiran}/edit', [KelahiranController::class, 'edit'])->name('kelahiran.edit');
Route::put('/kelahiran/{kelahiran}', [KelahiranController::class, 'update'])->name('kelahiran.update');
Route::delete('/kelahiran/{kelahiran}', [KelahiranController::class, 'destroy'])->name('kelahiran.destroy');


Route::get('/kematian/rw/', [KematianController::class, 'rw'])->name('kematian.rw');
Route::get('/kematian/rw/{rw}/', [KematianController::class, 'index'])->name('kematian');
Route::post('/kematian/rw/{rw}/filter', [KematianController::class, 'filter'])->name('kematian.filter');
Route::get('/kematian/rw/{rw}/print', [KematianController::class, 'print'])->name('kematian.print');
Route::get('/kematian/rw/{rw}/pdf', [KematianController::class, 'ExportPDF'])->name('kematian.pdf');
Route::get('/kematian/rw/{rw}/create', [KematianController::class, 'create'])->name('kematian.create');
Route::post('/kematian/', [KematianController::class, 'store'])->name('kematian.store');
Route::get('/kematian/rw/{kematian}/edit', [KematianController::class, 'edit'])->name('kematian.edit');
Route::put('/kematian/rw/{kematian}/', [KematianController::class, 'update'])->name('kematian.update');
Route::delete('/kematian/rw/{kematian}/', [KematianController::class, 'destroy'])->name('kematian.destroy');

Route::get('/laporan', [LaporanController::class, 'bulanan'])->name('laporan');
Route::get('/laporan/print', [LaporanController::class, 'print'])->name('laporan.print');