<div class="p-6 bg-white border rounded-lg shadow-sm">
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h2 class="text-xl font-bold text-gray-800 italic">Manajemen Role & Hak Akses SPBE</h2>
            <p class="text-sm text-gray-500">Kelola kelompok pengguna dan batasan akses modul.</p>
        </div>
        @if($isEditMode)
            <button wire:click="cancelEdit" class="px-3 py-1 text-xs bg-gray-500 text-white rounded hover:bg-gray-600">
                Batal Edit
            </button>
        @endif
    </div>

    @if (session()->has('success'))
        <div class="p-3 mb-4 text-green-700 bg-green-100 rounded border border-green-200">{{ session('success') }}</div>
    @endif
    @if (session()->has('error'))
        <div class="p-3 mb-4 text-red-700 bg-red-100 rounded border border-red-200">{{ session('error') }}</div>
    @endif

    {{-- Form Input Role --}}
    <div class="p-5 mb-8 border rounded-xl bg-gray-50 shadow-inner">
        <div class="grid grid-cols-1 gap-6">
            <div>
                <label class="block text-sm font-semibold text-gray-700 uppercase tracking-wider">Nama Role</label>
                <input type="text" wire:model="roleName" 
                    class="w-full mt-2 border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Contoh: Admin_Perencanaan">
                @error('roleName') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block mb-3 text-sm font-semibold text-gray-700 uppercase tracking-wider">Pilih Hak Akses (Berdasarkan Modul):</label>
                
                {{-- MATRIKS PERMISSION --}}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($groupedPermissions as $group => $perms)
                    <div class="bg-white border rounded-lg overflow-hidden shadow-sm">
                        {{-- Header Modul dengan Fitur Pilih Per Group --}}
                        <div class="bg-blue-50 px-3 py-2 border-b border-blue-100 flex justify-between items-center">
                            <span class="font-bold text-blue-800 text-sm italic">{{ $group }}</span>
                            
                            {{-- Tombol Kecil Pilih Per Group --}}
                            <button type="button" 
                                wire:click="pilihPerGroup('{{ $group }}')"
                                class="text-[10px] px-2 py-0.5 rounded border transition-colors
                                {{ collect($perms->pluck('name'))->every(fn($p) => in_array($p, $selectedPermissions))
                                    ? 'bg-blue-600 text-white border-blue-700' 
                                    : 'bg-white text-blue-600 border-blue-200 hover:bg-blue-100' }}">
                                {{ collect($perms->pluck('name'))->every(fn($p) => in_array($p, $selectedPermissions)) ? 'Batal' : 'Semua' }}
                            </button>
                        </div>

                        {{-- Body Modul (Checkbox Satuan Tetap Berfungsi) --}}
                        <div class="p-3 grid grid-cols-2 gap-2">
                            @foreach($perms as $perm)
                                <label class="flex items-center space-x-2 cursor-pointer hover:bg-gray-50 p-1 rounded transition">
                                    <input type="checkbox" wire:model="selectedPermissions" value="{{ $perm->name }}" 
                                        class="text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                                    <span class="text-xs text-gray-600 capitalize">
                                        {{ Str::afterLast($perm->name, '-') }}
                                    </span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endforeach
                </div>
                @error('selectedPermissions') <span class="text-xs text-red-500 mt-2 block">{{ $message }}</span> @enderror
            </div>
        </div>
        
        <div class="mt-6 flex justify-end">
            <button wire:click="store" class="px-6 py-2 text-white font-bold bg-blue-600 rounded-lg hover:bg-blue-700 shadow-md transition">
                {{ $isEditMode ? 'Update Role' : 'Simpan Role Baru' }}
            </button>
        </div>
    </div>

    {{-- Tabel Daftar Role --}}
    <div class="overflow-hidden border border-gray-200 rounded-lg">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase">Nama Role</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase">Ringkasan Hak Akses</th>
                    <th class="px-6 py-3 text-right text-xs font-bold text-gray-600 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200 italic">
                @foreach($roles as $role)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4 text-sm font-bold text-gray-900">
                        <span class="{{ $role->name === 'super-admin' ? 'text-red-600' : 'text-blue-600' }}">
                            {{ strtoupper($role->name) }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex flex-wrap gap-1">
                            @foreach($role->permissions->take(8) as $p)
                                <span class="px-2 py-0.5 text-[9px] bg-gray-100 text-gray-600 rounded border border-gray-200">{{ $p->name }}</span>
                            @endforeach
                            @if($role->permissions->count() > 8)
                                <span class="text-[9px] text-gray-400 font-bold ml-1">+{{ $role->permissions->count() - 8 }} lainnya</span>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4 text-right space-x-3">
                        @if($role->name !== 'super-admin')
                            <button wire:click="edit({{ $role->id }})" class="text-amber-600 hover:text-amber-900 text-xs font-bold underline">Edit</button>
                            
                            <button onclick="confirm('Hapus role ini? User dengan role ini akan kehilangan akses.') || event.stopImmediatePropagation()" 
                                wire:click="delete({{ $role->id }})" 
                                class="text-red-600 hover:text-red-900 text-xs font-bold underline">Hapus</button>
                        @else
                            <span class="text-[10px] bg-red-600 text-white px-2 py-1 rounded-full uppercase">Sistem Inti</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>