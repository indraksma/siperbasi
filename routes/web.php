<?php

use App\Http\Controllers\FrontController;
use App\Http\Livewire\Admin\AddPenyitaan;
use App\Http\Livewire\Admin\BarangBukti;
use App\Http\Livewire\Admin\Eksekusi;
use App\Http\Livewire\Admin\Home;
use App\Http\Livewire\Admin\Perkara;
use App\Http\Livewire\Admin\Pengumuman;
use App\Http\Livewire\Admin\Penyitaan;
use App\Http\Livewire\Admin\Putusan;
use App\Http\Livewire\Admin\Setting;
use App\Http\Livewire\Admin\Survey;
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
    return view('splash');
});
Route::get('/home', [FrontController::class, 'home'])->name('home');
Route::get('/lelang', [FrontController::class, 'lelang'])->name('lelang');
Route::get('/survey', [FrontController::class, 'survey'])->name('survey');
Route::post('/survey', [FrontController::class, 'storesurvey'])->name('survey.store');
Route::get('/barangbukti', [FrontController::class, 'barangbukti'])->name('barangbukti');
Route::get('/barangbukti/get', [FrontController::class, 'getbarangbukti'])->name('barangbukti.get');
Route::get('/barangbukti/{id}/get', [FrontController::class, 'viewbarangbukti'])->name('barangbukti.view');
Route::get('/barangsita', [FrontController::class, 'barangsita'])->name('barangsita');
Route::get('/barangsita/get', [FrontController::class, 'getbarangsita'])->name('barangsita.get');
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/home', Home::class)->name('admin.home');
    Route::get('/admin/penyitaan', Penyitaan::class)->name('admin.penyitaan');
    Route::get('/admin/addpenyitaan', AddPenyitaan::class)->name('admin.addpenyitaan');
    Route::get('/admin/barangbukti', BarangBukti::class)->name('admin.barangbukti');
    Route::get('/admin/putusan', Putusan::class)->name('admin.putusan');
    Route::get('/admin/eksekusi', Eksekusi::class)->name('admin.eksekusi');
    Route::get('/admin/pengumuman', Pengumuman::class)->name('admin.pengumuman');
    Route::get('/admin/survey', Survey::class)->name('admin.survey');
    Route::get('/admin/setting', Setting::class)->name('admin.setting');
    Route::get('/export-barbuk', [FrontController::class, 'exportBarbuk'])->name('export.barbuk');
});
