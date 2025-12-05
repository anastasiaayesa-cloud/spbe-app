<?php

use App\Livewire\Perencanaans\PerencanaanForm;
use App\Livewire\Persuratans\PersuratanForm;
use App\Livewire\Perencanaans\PerencanaansIndex;
use App\Livewire\Persuratans\PersuratansIndex;
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
// Route::get('/items/{itemId}/edit', ItemForm::class)->name('items.edit');

Route::get('/persuratans', PersuratansIndex::class)->name('persuratans.index');
Route::get('/persuratans/create', PersuratanForm::class)->name('persuratans.create');
Route::get('/persuratans/{persuratan_id}/edit', PersuratanForm::class)->name('persuratans.edit');


require __DIR__ . '/auth.php';
