<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Kepegawaian;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class ManajemenAkses extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public $search = '';
    public $selectedPegawai = null; 
    public $roles_dipilih = [];

    // Reset pagination saat search berubah
    public function updatingSearch()
    {
        $this->resetPage();
    }

    // Reset password user
    public function resetPassword($userId)
    {
        $user = User::findOrFail($userId);
        
        $user->update([
            'password' => Hash::make('password123'),
        ]);

        session()->flash(
            'message',
            "Password untuk {$user->name} berhasil direset menjadi: password123"
        );
    }

    // Klik tombol "Edit Hak Akses"
    public function aturRole($id)
    {
        $this->selectedPegawai = Kepegawaian::with('user.roles')->findOrFail($id);

        $this->roles_dipilih = $this->selectedPegawai->user
            ? $this->selectedPegawai->user->getRoleNames()->toArray()
            : [];
    }

    // Simpan perubahan role
    public function simpanAkses()
    {
        if (!$this->selectedPegawai) return;

        // Buat / ambil user berdasarkan email pegawai
        $user = User::updateOrCreate(
            ['email' => $this->selectedPegawai->email],
            [
                'name' => $this->selectedPegawai->nama,
                'password' => bcrypt('password123'),
            ]
        );

        // Hubungkan pegawai ↔ user
        $this->selectedPegawai->update([
            'user_id' => $user->id,
        ]);

        // Sinkronkan role
        $user->syncRoles($this->roles_dipilih);

        // Reset state
        $this->reset(['selectedPegawai', 'roles_dipilih']);

        session()->flash(
            'message',
            'Akses berhasil disinkronkan untuk ' . $user->name
        );
    }

    public function render()
    {
        return view('livewire.admin.manajemen-akses', [
            'pegawais' => Kepegawaian::with('user.roles')
                ->where('nama', 'like', '%' . $this->search . '%')
                ->paginate(10),

            'all_roles' => Role::all(),
        ])->layout('layouts.app');
    }
}
