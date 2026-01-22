<?php

namespace App\Livewire\Admin;

use App\Models\Kepegawaian; // Model tabel Anda
use Spatie\Permission\Models\Role; // Model dari Spatie
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ManajemenAkses extends Component
{
    use WithPagination;

    public $search = '';

    // --- TAMBAHKAN DUA BARIS INI ---
    public $selectedPegawai = null; 
    public $roles_dipilih = [];
    
    // --- Mengatur ulang pagination saat pencarian berubah ---
    public function updatingSearch()
    {
        $this->resetPage();
    }

    // --- Fungsi Reset Password ---
    public function resetPassword($userId)
    {
        $user = User::findOrFail($userId);
        
        $user->update([
            'password' => Hash::make('password123'),
        ]);

        session()->flash('message', "Password untuk {$user->name} berhasil direset menjadi: password123");
    }

    // --- Dipanggil saat tombol "Edit Hak Akses" diklik ---
    public function aturRole($id)
    {
        $this->selectedPegawai = Kepegawaian::findOrFail($id);
        
        // Ambil role dari user yang terhubung
        if ($this->selectedPegawai->user) {
            $this->roles_dipilih = $this->selectedPegawai->user->getRoleNames()->toArray();
        } else {
            $this->roles_dipilih = [];
        }
    }
    // --- Dipanggil saat tombol "Simpan Perubahan" di klik ---
    public function simpanAkses()
    {
        if (!$this->selectedPegawai) return;

        // 1. Cari atau buat User berdasarkan email pegawai
        // Ini mencegah error "Duplicate entry"
        $user = \App\Models\User::updateOrCreate(
            ['email' => $this->selectedPegawai->email], // Kondisi pencarian
            [
                'name' => $this->selectedPegawai->nama,
                'password' => bcrypt('password123'), // Password default jika baru dibuat
            ]
        );

        // 2. Hubungkan data pegawai dengan ID User tersebut
        $this->selectedPegawai->update([
            'user_id' => $user->id
        ]);

        // 3. Sinkronkan Role ke model User (bukan Kepegawaian)
        $user->syncRoles($this->roles_dipilih);

        // 4. Reset state
        $this->selectedPegawai = null;
        $this->roles_dipilih = [];
        
        session()->flash('message', 'Akses berhasil disinkronkan untuk ' . $user->name);
    }

    public function render()
    {
        return view('livewire.admin.manajemen-akses', [
            // 1. Mengambil data pegawai dengan relasi user dan role-nya
            'pegawais' => \App\Models\Kepegawaian::query()
                ->with(['user.roles'])
                ->where('nama', 'like', '%' . $this->search . '%')
                ->paginate(10),

            // 2. Mengambil SEMUA daftar role untuk ditampilkan di modal (checkbox)
            // Pastikan Anda sudah mengimport Spatie\Permission\Models\Role di bagian atas file
            'all_roles' => \Spatie\Permission\Models\Role::all(), 
        ])->layout('layouts.app');
    }
}
