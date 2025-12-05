<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Manajemen Kepegawaians') }}
    </h2>
</x-slot>

<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-4 max-w-lg">
                <h2 class="text-xl mb-4">{{ $kepegawaian_id ? 'Edit Kepegawaian' : 'Tambah Kepegawaian' }}</h2>                

                @if (session('success'))
                    <div class="mb-4 text-green-700">{{ session('success') }}</div>
                @endif
                @if (session('error'))
                    <div class="mb-4 text-red-700">{{ session('error') }}</div>
                @endif

                <form wire:submit.prevent="submit" autocomplete="off">
                    <div class="mb-3">
                        <label class="block mb-1">Nama</label>
                        <input type="text" wire:model.defer="nama" class="border rounded px-3 py-2 w-full" placeholder="Isi Nama" autofocus>
                        @error('nama') <span class="text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="block mb-1">nip</label>
                        <input type="text" wire:model.defer="nip" class="border rounded px-3 py-2 w-full">
                        @error('nip') <span class="text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="block mb-1">jabatan</label>
                        <input type="text" wire:model.defer="jabatan" class="border rounded px-3 py-2 w-full">
                        @error('jabatan') <span class="text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="block mb-1">pangkat id</label>
                        <input type="text" wire:model.defer="pangkat_id" class="border rounded px-3 py-2 w-full">
                        @error('pangkat_id') <span class="text-red-600">{{ $message }}</span> @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="block mb-1">tempat lahir</label>
                        <input type="text" wire:model.defer="tempat_lahir" class="border rounded px-3 py-2 w-full" autofocus>
                        @error('tempat_lahir') <span class="text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="block mb-1">tgl lahir</label>
                        <input type="date" wire:model="tgl_lahir" class="border rounded px-3 py-2 w-full">
                        @error('tgl_lahir') <span class="text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="block mb-1">Jenis Kelamin</label>
                        <select wire:model="jenis_kelamin" class="border rounded px-3 py-2 w-full">
                            <option value="Laki-laki">Laki laki</option>
                            <option value="Perempuan">Perempuan</option>                            
                        </select>
                        @error('jenis_kelamin') <span class="text-red-600">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="block mb-1">Agama</label>
                        <select wire:model="agama" class="border rounded px-3 py-2 w-full">
                            <option value="Islam">Islam</option>
                            <option value="Kristen Katolik">Kristen Katolik</option>  
                            <option value="Kristen Protestan">Kristen Protestan</option>
                            <option value="Hindu">Hindu</option> 
                            <option value="Buddha">Buddha</option>
                            <option value="Konghucu">Konghucu</option>                  
                        </select>
                        @error('jenis_kelamin') <span class="text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="block mb-1">nama_instansi</label>
                        <input type="text" wire:model.defer="nama_instansi" class="border rounded px-3 py-2 w-full" autofocus>
                        @error('nama_instansi') <span class="text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="block mb-1">alamat_instansi</label>
                        <input type="text" wire:model.defer="alamat_instansi" class="border rounded px-3 py-2 w-full" autofocus>
                        @error('alamat_instansi') <span class="text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="block mb-1">telp_instansi</label>
                        <input type="text" wire:model.defer="telp_instansi" class="border rounded px-3 py-2 w-full" autofocus>
                        @error('telp_instansi') <span class="text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="block mb-1">kode_kabupaten</label>
                        <input type="text" wire:model.defer="kode_kabupaten" class="border rounded px-3 py-2 w-full" autofocus>
                        @error('kode_kabupaten') <span class="text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="block mb-1">hp</label>
                        <input type="text" wire:model.defer="hp" class="border rounded px-3 py-2 w-full" autofocus>
                        @error('hp') <span class="text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="block mb-1">email </label>
                        <input type="email" wire:model.defer="email" class="border rounded px-3 py-2 w-full" autofocus>
                        @error('email') <span class="text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="block mb-1">npwp</label>
                        <input type="text" wire:model.defer="npwp" class="border rounded px-3 py-2 w-full" autofocus>
                        @error('npwp') <span class="text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="block mb-1">bank_id</label>
                        <input type="text" wire:model="bank_id" class="border rounded px-3 py-2 w-full" autofocus>
                        @error('bank_id') <span class="text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="block mb-1">no_rek</label>
                        <input type="text" wire:model.defer="no_rek" class="border rounded px-3 py-2 w-full" autofocus>
                        @error('no_rek') <span class="text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="block mb-1">pendidikan_terakhir_id</label>
                        <input type="text" wire:model.defer="pendidikan_terakhir_id" class="border rounded px-3 py-2 w-full" autofocus>
                        @error('pendidikan_terakhir_id') <span class="text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="block mb-1">is_bpmp</label>
                        <input type="text" wire:model.defer="is_bpmp" class="border rounded px-3 py-2 w-full" autofocus>
                        @error('is_bpmp') <span class="text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex items-center space-x-2">
                        <button type="submit" class=" px-4 py-2 rounded">
                            {{ $kepegawaian_id ? 'Simpan Perubahan' : 'Simpan' }}
                        </button>
                        @if($kepegawaian_id)
                        <button type="button" wire:click="delete" class="px-4 py-2 bg-red-600 text-white rounded">
                            Hapus
                        </button>
                        @endif
                        <a href="{{ route('kepegawaians.index') }}" class="px-4 py-2 border rounded">Batal</a>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>