<?php

use App\Livewire\Perencanaans\{PerencanaansIndex, DokumenPerencanaanIndex, DokumenPerencanaanForm, PenugasansIndex, PerencanaanDetail};
use App\Livewire\Kepegawaians\{KepegawaianForm, KepegawaiansIndex};
use App\Livewire\Kabupatens\KabupatensIndex;
use App\Livewire\Persuratans\{PersuratanForm, PersuratansIndex};
use App\Livewire\Instansis\{InstansiIndex, InstansiForm};
use App\Livewire\Pelaksanaans\{PelaksanaansIndex, PelaksanaanForm, PelaksanaanShow};
use App\Livewire\Rencanas\{RencanasIndex, RencanasForm};
use App\Livewire\Admin\{ManajemenAkses, RoleManager};
use App\Livewire\Keuangans\{KeuanganIndex, KeuanganForm, KeuanganShow};
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

// Semua rute di bawah ini wajib Login
Route::middleware(['auth'])->group(function () {

    // --- GRUP PERENCANAAN ---
    Route::middleware(['can:perencanaan-view'])->group(function () {
        Route::get('/perencanaans', PerencanaansIndex::class)->name('perencanaans.index');
        Route::middleware(['can:perencanaan-create'])->get('/perencanaans/create', PerencanaanDetail::class)->name('perencanaans.create');
        Route::middleware(['can:perencanaan-edit'])->get('/perencanaans/{perencanaanId}/edit', PerencanaanDetail::class)->name('perencanaans.edit');
        Route::middleware(['can:perencanaan-delete'])->get('/perencanaans/{perencanaanId}/delete', PerencanaanDetail::class)->name('perencanaans.delete');
    });

    // --- DOKUMEN PERENCANAAN ---
    Route::middleware(['can:dokumen-perencanaan-view'])->group(function () {
        Route::get('/dokumen-perencanaan', DokumenPerencanaanIndex::class)->name('dokumen-perencanaan.index');
        Route::middleware(['can:dokumen-perencanaan-create'])->get('/dokumen-perencanaan/create', DokumenPerencanaanForm::class)->name('dokumen-perencanaan.create');
        Route::middleware(['can:dokumen-perencanaan-edit'])->get('/dokumen-perencanaan/{dokumenperencanaan_id}/edit', DokumenPerencanaanForm::class)->name('dokumen-perencanaan.edit');
        Route::middleware(['can:dokumen-perencanaan-delete'])->get('/dokumen-perencanaan/{dokumenperencanaan_id}/delete', DokumenPerencanaanForm::class)->name('dokumen-perencanaan.delete');
    });

    Route::get('/penugasan', PenugasansIndex::class)->name('penugasans.index');

    // --- GRUP KEPEGAWAIAN  ---
    Route::middleware(['can:pegawai-view'])->group(function () {
        Route::get('/kepegawaians', KepegawaiansIndex::class)->name('kepegawaians.index');
        Route::middleware(['can:pegawai-create'])->get('/kepegawaians/create', KepegawaianForm::class)->name('kepegawaians.create');
        Route::middleware(['can:pegawai-edit'])->get('/kepegawaians/{kepegawaian_id}/edit', KepegawaianForm::class)->name('kepegawaians.edit');
        Route::middleware(['can:pegawai-delete'])->get('/kepegawaians/{kepegawaian_id}/delete', KepegawaianForm::class)->name('kepegawaians.delete');
    });

    // --- KABUPATEN
    Route::middleware(['can:kabupatens-view'])->group(function () {
        Route::get('/kabupatens', KabupatensIndex::class)->name('kabupatens.index');
        // Route::middleware(['can:kabupatens-create'])->get('/kabupatens/create', KabupatensForm::class)->name('kabupatens.create');
        // Route::middleware(['can:kabupatens-edit'])->get('/kabupatens/{kabupatens_id}/edit', KabupatensForm::class)->name('kabupatens.edit');
        // Route::middleware(['can:kabupatens-delete'])->get('/kabupatens/{kabupatens_id}/delete', KabupatensForm::class)->name('kabupatens.delete');
    });

    // --- GRUP PERSURATAN ---
    Route::middleware(['can:persuratan-view'])->group(function () {
        Route::get('/persuratans', PersuratansIndex::class)->name('persuratans.index');
        Route::middleware(['can:persuratan-create'])->get('/persuratans/create', PersuratanForm::class)->name('persuratans.create');
        Route::middleware(['can:persuratan-edit'])->get('/persuratans/{persuratan_id}/edit', PersuratanForm::class)->name('persuratans.edit');
        Route::middleware(['can:persuratan-delete'])->get('/persuratans/{persuratan_id}/delete', PersuratanForm::class)->name('persuratans.delete');
    });

    Route::middleware(['can:jenis-bukti-view'])->group(function () {

    Route::get('/pelaksanaans', PelaksanaansIndex::class)
        ->name('pelaksanaans.index');

    Route::middleware(['can:jenis-bukti-create'])
        ->get('/pelaksanaans/create', PelaksanaanForm::class)
        ->name('pelaksanaans.create');

    // SHOW BERDASARKAN RENCANA (harus sebelum edit)
    Route::get(
        '/pelaksanaans/rencana/{rencana}',
        PelaksanaanShow::class
    )->name('pelaksanaans.show.by-rencana');

    Route::middleware(['can:jenis-bukti-edit'])
        ->get('/pelaksanaans/{pelaksanaan_id}/edit', PelaksanaanForm::class)
        ->name('pelaksanaans.edit');

});

    // --- GRUP RENCANA KEGIATAN ---
    Route::middleware(['can:rencana-kegiatan-view'])->group(function () {
        Route::get('/rencanas', RencanasIndex::class)->name('rencanas.index');
        Route::middleware(['can:rencana-kegiatan-create'])->get('/rencanas/create', RencanasForm::class)->name('rencanas.create');
        Route::middleware(['can:rencana-kegiatan-edit'])
        ->get('/rencanas/{rencana_id}/edit', RencanasForm::class)
        ->name('rencanas.edit');
        Route::middleware(['can:rencana-kegiatan-delete'])->get('/rencanas/{rencanas_id}/delete', RencanasForm::class)->name('rencanas.delete');
    });

    // --- GRUP MASTER DATA (INSTANSI) ---
    Route::middleware(['can:instansi-view'])->group(function () {
        Route::get('/instansis', InstansiIndex::class)->name('instansis.index');
        Route::middleware(['can:instansi-create'])->get('/instansis/create', InstansiForm::class)->name('instansis.create');
        Route::middleware(['can:instansi-edit'])->get('/instansis/{instansi_id}/edit', InstansiForm::class)->name('instansis.edit');
        Route::middleware(['can:instansi-delete'])->get('/instansis/{instansi_id}/delete', InstansiForm::class)->name('instansis.delete');
    });

    // --- GRUP SUPER ADMIN (ROLE & PERMISSION) ---
    // Menggunakan can:manajemen-role-view atau bisa langsung role:super-admin
    Route::middleware(['role:super-admin'])->group(function () {
        Route::get('/admin/manajemen-akses', ManajemenAkses::class)->name('admin.akses');
        Route::get('/admin/roles', RoleManager::class)->name('admin.roles');
    });

    // --- GRUP KEUANGAN ---
Route::middleware(['can:keuangan-view'])->group(function () {

    Route::get('/keuangans', KeuanganIndex::class)
        ->name('keuangans.index');

    Route::middleware(['can:keuangan-create'])
        ->get('/keuangans/{pelaksanaan}/create', KeuanganForm::class)
        ->name('keuangans.create');

    Route::middleware(['can:keuangan-view'])
        ->get('/keuangans/{keuangan}', KeuanganShow::class)
        ->name('keuangans.show');
});

});

require __DIR__ . '/auth.php';
