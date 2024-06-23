<?php

use App\Http\Livewire\Admin\AddPenyitaan;
use App\Http\Livewire\Admin\BarangBukti;
use App\Http\Livewire\Admin\Home;
use App\Http\Livewire\Admin\Perkara;
use App\Http\Livewire\Admin\Pengumuman;
use App\Http\Livewire\Admin\Penyitaan;
use App\Http\Livewire\Admin\Putusan;
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

Route::get('/', function () {
    return view('welcome');
});
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/home', Home::class)->name('admin.home');
    Route::get('/admin/penyitaan', Penyitaan::class)->name('admin.penyitaan');
    Route::get('/admin/addpenyitaan', AddPenyitaan::class)->name('admin.addpenyitaan');
    Route::get('/admin/barangbukti', BarangBukti::class)->name('admin.barangbukti');
    Route::get('/admin/putusan', Putusan::class)->name('admin.putusan');
    Route::get('/admin/pengumuman', Pengumuman::class)->name('admin.pengumuman');
});
