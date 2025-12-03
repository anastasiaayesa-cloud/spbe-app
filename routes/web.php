<?php

use App\Livewire\Perencanaans\PerencanaansIndex;
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
// Route::get('/items/create', ItemForm::class)->name('items.create');
// Route::get('/items/{itemId}/edit', ItemForm::class)->name('items.edit');

require __DIR__ . '/auth.php';
