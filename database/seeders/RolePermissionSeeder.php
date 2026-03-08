<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Str;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // 1. Reset cache Spatie
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // 2. Definisikan Menu sesuai screenshot Anda
        $menus = [
            'Dokumen Perencanaan',
            'Perencanaan',
            'Pegawai',
            'Persuratan',
            'Jenis Bukti',
            'Rencana Kegiatan',
            'Instansi',
            'Kabupaten',
            'Manajemen Hak Akses',
            'Manajemen Role'
        ];

        // 3. Definisikan Aksi Standar (CRUD)
        $actions = ['view', 'create', 'edit', 'delete'];

        // 4. Loop untuk membuat Permission secara otomatis
        foreach ($menus as $menu) {
            $slug = Str::slug($menu); // Contoh: "Jenis Bukti" menjadi "jenis-bukti"
            
            foreach ($actions as $action) {
                Permission::firstOrCreate([
                    'name'       => "{$slug}-{$action}",
                    'group'      => $menu, // Kolom group untuk memudahkan UI Livewire
                    'guard_name' => 'web'
                ]);
            }
        }

        // 5. Membuat Role Default
        $roleSuperAdmin = Role::firstOrCreate(['name' => 'super-admin']);

        // 6. Assign All Permissions ke Super Admin
        $allPermissions = Permission::all();
        $roleSuperAdmin->syncPermissions($allPermissions);

        // 7. Buat User Contoh jika belum ada
        $admin = User::firstOrCreate(
            ['email' => 'admin@spbe.go.id'],
            [
                'name' => 'Super Admin SPBE',
                'password' => bcrypt('password123'),
            ]
        );
        $admin->assignRole($roleSuperAdmin);
    }
}
