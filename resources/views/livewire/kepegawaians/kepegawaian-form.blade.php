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
                        <label class="block mb-1">NIP</label>
                        <input type="text" wire:model.defer="nip" class="border rounded px-3 py-2 w-full">
                        @error('nip') <span class="text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="block mb-1">Jabatan</label>
                        <input type="text" wire:model.defer="jabatan" class="border rounded px-3 py-2 w-full">
                        @error('jabatan') <span class="text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="block mb-1">Pangkat</label>
                        <select wire:model="pangkat_id" class="border rounded px-3 py-2 w-full">
                            <option value="">-- Pilih Pangkat--</option>
                            @foreach ($pangkatList as $pangkat)
                                <option value="{{ $pangkat->id }}">{{ $pangkat->nama }}</option>
                            @endforeach
                        </select>
                        @error('pangkat_id') <span class="text-red-600">{{ $message }}</span> @enderror
                    </div>

                    
                    <div class="mb-3">
                        <label class="block mb-1">Tempat Lahir</label>
                        <input type="text" wire:model.defer="tempat_lahir" class="border rounded px-3 py-2 w-full" autofocus>
                        @error('tempat_lahir') <span class="text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="block mb-1">Tanggal Lahir</label>
                        <input type="date" wire:model="tgl_lahir" class="border rounded px-3 py-2 w-full">
                        @error('tgl_lahir') <span class="text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="block mb-1">Jenis Kelamin</label>
                        <select wire:model="jenis_kelamin" class="border rounded px-3 py-2 w-full">
                            <option value="">Pilih Jenis Kelamin</option>
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
                        <label class="block mb-1">Pilih Instansi</label>
                        <select wire:model="instansi_id" class="border rounded px-3 py-2 w-full">
                            <option value="">Instansi</option>
                            @foreach ($instansiList as $instansi)
                            <option value="{{ $instansi->id }}">{{ $instansi->nama_instansi }}</option>
                            @endforeach
                        </select>
                        @error('instansi_id') <span class="text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="block mb-1">Nomor Handphone</label>
                        <input type="text" wire:model.defer="hp" class="border rounded px-3 py-2 w-full" autofocus>
                        @error('hp') <span class="text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="block mb-1">Email</label>
                        <input type="email" wire:model.defer="email" class="border rounded px-3 py-2 w-full" autofocus>
                        @error('email') <span class="text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="block mb-1">NPWP</label>
                        <input type="text" wire:model.defer="npwp" class="border rounded px-3 py-2 w-full" autofocus>
                        @error('npwp') <span class="text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="block mb-1">Bank</label>
                        <select wire:model="bank_id" class="border rounded px-3 py-2 w-full">
                            <option value="">-- Pilih Bank--</option>
                            @foreach ($bankList as $bank)
                                <option value="{{ $bank->id }}">{{ $bank->nama }}</option>
                            @endforeach
                        </select>
                        @error('bank_id') <span class="text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="block mb-1">Nomor Rekening</label>
                        <input type="text" wire:model.defer="no_rek" class="border rounded px-3 py-2 w-full" autofocus>
                        @error('no_rek') <span class="text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
    <label class="block mb-1">Pendidikan Terakhir</label>
    <select wire:model="pendidikan_id" class="border rounded px-3 py-2 w-full">
        <option value="">-- Pilih Pendidikan--</option>
        @foreach ($pendidikanList as $pendidikan)
            <option value="{{ $pendidikan->id }}">{{ $pendidikan->nama_pendidikan }}</option>
        @endforeach
    </select>
    @error('pendidikan_id') 
        <span class="text-red-600">{{ $message }}</span> 
    @enderror
</div>

                    <div class="mb-3">
                        <label class="block mb-1">IS BPMP</label>
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