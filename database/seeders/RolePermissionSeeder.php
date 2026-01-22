<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
{
    // Reset cache Spatie (Penting agar permission baru terbaca)
    app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

    // 1. Definisikan Permission
    $permissions = [
        'mengelola user',       // Admin
        'akses perencanaan',    // Perencanaan
        'tambah perencanaan',
        'akses kepegawaian',    // Kepegawaian
        'tambah pegawai',
        'akses persuratan',     // Kesektariatan
        'tambah persuratan',
        'akses usulan kegiatan',
        'akses bukti',          // Pegawai
        'tambah bukti',
        'melihat rencana',
        'mengusulkan pegawai',
    ];

    foreach ($permissions as $permission) {
        Permission::create(['name' => $permission]);
    }

    // 2. Buat Role
    $roleAdmin = Role::create(['name' => 'admin']);
    $rolePerencanaan = Role::create(['name' => 'perencanaan']);
    $roleKepegawaian = Role::create(['name' => 'kepegawaian']);
    $roleKesekretariatan = Role::create(['name' => 'kesekretariatan']);
    $rolePegawai = Role::create(['name' => 'pegawai']);
    $roleKatim = Role::create(['name' => 'katim']);

    // 3. Assign Permission ke Role
    $roleAdmin->givePermissionTo(Permission::all());
    $rolePerencanaan->givePermissionTo(['akses perencanaan', 'tambah perencanaan']);
    $roleKepegawaian->givePermissionTo(['akses kepegawaian', 'tambah pegawai']);
    $roleKesekretariatan->givePermissionTo(['akses persuratan', 'tambah persuratan', 'akses usulan kegiatan']);
    $rolePegawai->givePermissionTo(['akses bukti', 'tambah bukti']);
    $roleKatim->givePermissionTo(['melihat rencana', 'mengusulkan pegawai']);



    // 4. Buat User (Gunakan updateOrCreate agar tidak error jika dijalankan ulang)
    $admin = User::updateOrCreate(
        ['email' => 'admin@spbe.go.id'],
        ['name' => 'Admin SPBE', 'password' => bcrypt('password123')]
    );
    $admin->assignRole($roleAdmin);

    $perencanaan = User::updateOrCreate(
        ['email' => 'perencanaan@spbe.go.id'],
        ['name' => 'Staf Perencanaan', 'password' => bcrypt('password123')]
    );
    $perencanaan->assignRole($rolePerencanaan);

    $kepegawaian = User::updateOrCreate(
        ['email' => 'kepegawaian@spbe.go.id'],
        ['name' => 'Staf Kepegawaian', 'password' => bcrypt('password123')]
    );
    $kepegawaian->assignRole($roleKepegawaian);

    $kesekretariatan = User::updateOrCreate(
        ['email' => 'kesekretariatan@spbe.go.id'],
        ['name' => 'Staf kesekretariatan', 'password' => bcrypt('password123')]
    );
    $kesekretariatan->assignRole($roleKesekretariatan);

    $pegawai = User::updateOrCreate(
        ['email' => 'pegawai@spbe.go.id'],
        ['name' => 'Pegawai', 'password' => bcrypt('password123')]
    );
    $pegawai->assignRole($rolePegawai);

    $katim = User::updateOrCreate(
        ['email' => 'katim@spbe.go.id'],
        ['name' => 'katim', 'password' => bcrypt('password123')]
    );
    $katim->assignRole($roleKatim);
}
}
