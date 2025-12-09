<?php

use App\Livewire\Perencanaans\PerencanaanForm;
use App\Livewire\Kepegawaians\KepegawaianForm;
use App\Livewire\Perencanaans\PerencanaansIndex;
use App\Livewire\Kepegawaians\KepegawaiansIndex;
use App\Livewire\Kabupatens\KabupatensIndex;
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
Route::get('/kepegawaians/{kepegawaian_id}/edit', action: KepegawaianForm::class)->name(name: 'kepegawaians.edit');
Route::get('/kepegawaians', KepegawaiansIndex::class)->name('kepegawaians.index');
Route::get('/kepegawaians/create', KepegawaianForm::class)->name('kepegawaians.create');
Route::get('/kabupatens', KabupatensIndex::class)->name('kabupatens.index');

require __DIR__ . '/auth.php';
