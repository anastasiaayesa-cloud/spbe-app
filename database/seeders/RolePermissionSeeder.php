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
            'Keuangan',
            'Manajemen Hak Akses',
            'Manajemen Role'
        ];

        // 3. Definisikan Aksi Standar (CRUD)
        $actions = ['view', 'create', 'edit', 'delete'];

        foreach ($menus as $menu) {
            $slug = Str::slug($menu); 
            
            foreach ($actions as $action) {
                // Cari berdasarkan NAME dan GUARD_NAME saja (kunci unik Spatie)
                // Jika tidak ada, baru buat baru dengan tambahan kolom 'group'
                Permission::firstOrCreate(
                    [
                        'name'       => "{$slug}-{$action}",
                        'guard_name' => 'web'
                    ],
                    [
                        'group'      => $menu
                    ]
                );
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