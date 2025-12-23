<?php

use App\Livewire\Perencanaans\PerencanaanForm;
use App\Livewire\Perencanaans\PerencanaansIndex;
use App\Livewire\Kepegawaians\KepegawaianForm;
use App\Livewire\Kepegawaians\KepegawaiansIndex;
use App\Livewire\Kabupatens\KabupatensIndex;
use App\Livewire\Perencanaans\DokumenPerencanaanIndex;
use App\Livewire\Perencanaans\DokumenPerencanaanForm;

use App\Livewire\Persuratans\PersuratanForm;
use App\Livewire\Persuratans\PersuratansIndex;
use App\Livewire\Instansis\InstansiIndex;
use App\Livewire\Instansis\InstansiForm;

use App\Livewire\Pelaksanaans\PelaksanaansIndex;
use App\Livewire\Pelaksanaans\PelaksanaanForm;

use App\Livewire\Rencanas\RencanasIndex;
use App\Livewire\Rencanas\RencanasForm;



use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::get('/perencanaans', PerencanaansIndex::class)->name('perencanaans.index');
Route::get('/perencanaans/create', PerencanaanForm::class)->name('perencanaans.create');
Route::get('/dokumen-perencanaan', DokumenPerencanaanIndex::class)->name('dokumen-perencanaan.index');
Route::get('/dokumen-perencanaan/create', DokumenPerencanaanForm::class)->name('dokumen-perencanaan.create');

Route::get('/kepegawaians/{kepegawaian_id}/edit', action: KepegawaianForm::class)->name(name: 'kepegawaians.edit');
Route::get('/kepegawaians', KepegawaiansIndex::class)->name('kepegawaians.index');
Route::get('/kepegawaians/create', KepegawaianForm::class)->name('kepegawaians.create');
Route::get('/kabupatens', KabupatensIndex::class)->name('kabupatens.index');

Route::get('/persuratans', PersuratansIndex::class)->name('persuratans.index');
Route::get('/persuratans/create', PersuratanForm::class)->name('persuratans.create');
Route::get('/persuratans/{persuratan_id}/edit', PersuratanForm::class)->name('persuratans.edit');

Route::get('/instansis', InstansiIndex::class)->name('instansis.index');
Route::get('/instansis/create', InstansiForm::class)->name('instansis.create');
Route::get('/instansis/{instansi_id}/edit', action: InstansiForm::class)->name(name: 'instansis.edit');

Route::get('/pelaksanaans', PelaksanaansIndex::class)->name('pelaksanaans.index');
Route::get('/pelaksanaans/create', PelaksanaanForm::class)->name(name: 'pelaksanaans.create');
Route::get('/pelaksanaans/{pelaksanaan_id}/edit', action: PelaksanaanForm::class)->name(name: 'pelaksanaans.edit');

Route::get('/rencanas', RencanasIndex::class)->name('rencanas.index');
Route::get('/rencanas/create', RencanasForm::class)->name(name: 'rencanas.create');





require __DIR__ . '/auth.php';
