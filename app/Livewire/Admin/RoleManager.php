<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class RoleManager extends Component
{
    use AuthorizesRequests;

    public $roleName;
    public $selectedPermissions = [];
    public $isEditMode = false;
    public $roleId;

    // Validasi akses saat komponen dimuat
    public function mount()
    {
        if (!auth()->user()->hasRole('super-admin')) {
            abort(403, 'Hanya Super Admin yang dapat mengelola hak akses sistem.');
        }
    }

    public function render()
    {
        return view('livewire.admin.role-manager', [
            'roles' => Role::with('permissions')->get(),
            // Mengelompokkan berdasarkan kolom group yang baru kita buat
            'groupedPermissions' => Permission::all()->groupBy('group'),
        ])->layout('layouts.app');
    }

    public function store()
    {
        $this->validate([
            'roleName' => 'required|unique:roles,name,' . $this->roleId,
            'selectedPermissions' => 'required|array|min:1'
        ]);

        if ($this->isEditMode) {
            $role = Role::findOrFail($this->roleId);
            
            // Mencegah perubahan nama role super-admin agar tidak terjadi lockout
            if ($role->name === 'super-admin' && $this->roleName !== 'super-admin') {
                session()->flash('error', 'Nama role Super Admin tidak boleh diubah.');
                return;
            }

            $role->update(['name' => $this->roleName]);
            $role->syncPermissions($this->selectedPermissions);
            session()->flash('success', 'Role berhasil diperbarui.');
        } else {
            $role = Role::create(['name' => $this->roleName]);
            $role->syncPermissions($this->selectedPermissions);
            session()->flash('success', 'Role baru berhasil dibuat.');
        }

        $this->resetInput();
    }

    public function edit($id)
    {
        $role = Role::findOrFail($id);
        
        // Opsional: Jika Anda ingin super-admin tetap bisa mengedit permission-nya sendiri, 
        // hapus proteksi ini. Namun, biasanya role super-admin dikunci agar tidak sengaja rusak.
        if ($role->name === 'super-admin') {
            session()->flash('error', 'Role Super Admin adalah role sistem dan tidak disarankan untuk diubah via UI.');
            return;
        }

        $this->roleId = $role->id;
        $this->roleName = $role->name;
        $this->selectedPermissions = $role->permissions->pluck('name')->toArray();
        $this->isEditMode = true;
    }

    public function delete($id)
    {
        $role = Role::findOrFail($id);

        // Keamanan krusial: Role super-admin tidak boleh dihapus dalam kondisi apapun
        if ($role->name === 'super-admin') {
            session()->flash('error', 'Role Super Admin tidak dapat dihapus!');
            return;
        }

        $role->delete();
        session()->flash('success', 'Role berhasil dihapus.');
    }

    public function cancelEdit()
    {
        $this->resetInput();
    }

    // Tambahkan fungsi ini di app/Livewire/Admin/RoleManager.php

    public function pilihPerGroup($groupName)
    {
        // Ambil semua nama permission yang ada di dalam group tersebut
        $groupPermissions = \Spatie\Permission\Models\Permission::where('group', $groupName)
                            ->pluck('name')
                            ->toArray();

        // Periksa apakah semua permission dalam group ini sudah terpilih
        $isAllSelected = collect($groupPermissions)->every(fn($p) => in_array($p, $this->selectedPermissions));

        if ($isAllSelected) {
            // Jika sudah terpilih semua, maka hapus hanya permission milik group ini
            $this->selectedPermissions = array_diff($this->selectedPermissions, $groupPermissions);
        } else {
            // Jika belum, tambahkan yang belum ada ke dalam array (tanpa duplikat)
            $this->selectedPermissions = array_unique(array_merge($this->selectedPermissions, $groupPermissions));
        }
    }

    private function resetInput()
    {
        $this->roleName = '';
        $this->selectedPermissions = [];
        $this->isEditMode = false;
        $this->roleId = null;
    }
}
