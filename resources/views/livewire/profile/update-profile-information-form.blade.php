<?php

use App\Models\User;
use App\Models\Pangkat;
use App\Models\Instansi;
use App\Models\Bank;
use App\Models\Pendidikan;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;

new class extends Component
{
    public string $nama = '';
    public string $email = '';

    public string $nip = '';
    public string $jabatan = '';
    public string $pangkat_id = '';
    public string $tempat_lahir = '';
    public $tgl_lahir = '';
    public string $jenis_kelamin = '';
    public string $agama = '';
    public string $instansi_id = '';
    public string $hp = '';
    // public string $email = '';
    public string $npwp = '';
    public string $bank_id = '';
    public string $no_rek = '';
    public string $pendidikan_id = '';
    public string $is_bpmp = '';

    public function with(): array
    {
        return [
            'pangkatList' => Pangkat::orderBy('nama', 'asc')->get(),
            'instansiList' => Instansi::orderBy('nama_instansi', 'asc')->get(),
            'bankList' => Bank::orderBy('nama', 'asc')->get(),
            'pendidikanList' => Pendidikan::all(),
            // Anda juga bisa menambahkan list untuk Instansi dan Bank di sini
            // 'instansiList' => Instansi::all(),
            // 'bankList' => Bank::all(),
        ];
    }

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $user = Auth::user();
        
        $this->nama = $user->name;
        $this->email = $user->email;

        if ($user->pegawai) {
            $this->nama = $user->pegawai->nama ?? $user->name;
            $this->email = $user->pegawai->email ?? $user->email;
            $this->nip = $user->pegawai->nip ?? '-';
            $this->jabatan = $user->pegawai->jabatan ?? '-';
            $this->pangkat_id = $user->pegawai->pangkat_id ?? '-';
            $this->tempat_lahir = $user->pegawai->tempat_lahir ?? '-';
            $this->tgl_lahir = $user->pegawai->tgl_lahir ?? '-';
            $this->jenis_kelamin = $user->pegawai->jenis_kelamin ?? '-';
            $this->agama = $user->pegawai->agama ?? '-';
            $this->instansi_id = $user->pegawai->instansi_id ?? '-';
            $this->hp = $user->pegawai->hp ?? '-';
            $this->npwp = $user->pegawai->npwp ?? '-';
            $this->bank_id = $user->pegawai->bank_id ?? '-';
            $this->no_rek = $user->pegawai->no_rek ?? '-';
            $this->pendidikan_id = $user->pegawai->pendidikan_id ?? '-';
            $this->is_bpmp = $user->pegawai->is_bpmp ?? '-';
        }
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        $user = Auth::user();
    
        // 1. Validasi data (tambahkan field kepegawaian)
        $validated = $this->validate([
            'nama' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
            'nip' => ['required', 'string'],
            'jabatan' => ['nullable', 'string'],
            'pangkat_id' => ['required', 'integer'],
            'tempat_lahir' => ['required', 'string'],
            'tgl_lahir' => ['required', 'date'],
            'jenis_kelamin' => ['required', 'string'],
            'agama' => ['required', 'string'],
            'instansi_id' => ['required', 'integer'],
            'npwp' => ['required', 'string'],
            'hp' => ['nullable', 'string'],
            'bank_id' => ['required', 'integer'],
            'no_rek' => ['required', 'string'],
            'pendidikan_id' => ['required', 'integer'],
            'is_bpmp' => ['nullable', 'string'],
            // Tambahkan validasi field lainnya sesuai kebutuhan
        ]);
    
        // 2. Simpan data User
        $user->fill([
            'name' => $this->nama,
            'email' => $this->email,
        ]);
    
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }
        $user->save();
    
        // 3. Simpan data Kepegawaian
        if ($user->pegawai) {
            $user->pegawai->update([
                'nama' => $this->nama,
                'email' => $this->email,
                'nip' => $this->nip,
                'jabatan' => $this->jabatan,
                'pangkat_id' => $this->pangkat_id,
                'tempat_lahir' => $this->tempat_lahir,
                'tgl_lahir' => $this->tgl_lahir,
                'jenis_kelamin' => $this->jenis_kelamin,
                'agama' => $this->agama,
                'instansi_id' => $this->instansi_id,
                'hp' => $this->hp,
                'npwp' => $this->npwp,
                'no_rek' => $this->no_rek,
                'pendidikan_id' => $this->pendidikan_id,
                'is_bpmp' => $this->is_bpmp,
            ]);
        }
    
        $this->dispatch('profile-updated', name: $user->name);
    }

    /**
     * Send an email verification notification to the current user.
     */
    public function sendVerification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: RouteServiceProvider::HOME);
            return;
        }

        $user->sendEmailVerificationNotification();
        Session::flash('status', 'verification-link-sent');
    }
}; ?>

<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">Informasi Profil & Kepegawaian</h2>
        <p class="mt-1 text-sm text-gray-600">Perbarui informasi akun dan detail data pegawai Anda secara sinkron.</p>
    </header>

    <form wire:submit="updateProfileInformation" class="mt-6 space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <x-input-label for="nama" :value="__('Nama Lengkap')" />
                <x-text-input wire:model="nama" id="nama" type="text" class="mt-1 block w-full" required autofocus />
                <x-input-error class="mt-2" :messages="$errors->get('nama')" />
            </div>

            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input wire:model="email" id="email" type="email" class="mt-1 block w-full" required />
                <x-input-error class="mt-2" :messages="$errors->get('email')" />
            </div>
        </div>

        <div class="pt-6 border-t border-gray-100">
            <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wider mb-4">Detail Kepegawaian</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <x-input-label for="nip" :value="__('NIP')" />
                    <x-text-input wire:model="nip" id="nip" type="text" class="mt-1 block w-full" />
                    <x-input-error class="mt-2" :messages="$errors->get('nip')" />
                </div>

                <div>
                    <x-input-label for="jabatan" :value="__('Jabatan')" />
                    <x-text-input wire:model="jabatan" id="jabatan" type="text" class="mt-1 block w-full" />
                    <x-input-error class="mt-2" :messages="$errors->get('jabatan')" />
                </div>

                <div>
                    <x-input-label for="pangkat_id" :value="__('Pangkat')" />
                    <select wire:model="pangkat_id" id="pangkat_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500">
                        <option value="">-- Pilih Pangkat --</option>
                        @foreach ($pangkatList as $pangkat)
                            <option value="{{ $pangkat->id }}">{{ $pangkat->nama }}</option>
                        @endforeach
                    </select>
                    <x-input-error class="mt-2" :messages="$errors->get('pangkat_id')" />
                </div>

                <div>
                    <x-input-label for="instansi_id" :value="__('Instansi')" />
                    <select wire:model="instansi_id" id="instansi_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500">
                        <option value="">-- Pilih Instansi --</option>
                        @foreach ($instansiList as $instansi)
                            <option value="{{ $instansi->id }}">{{ $instansi->nama_instansi }}</option>
                        @endforeach
                    </select>
                    <x-input-error class="mt-2" :messages="$errors->get('instansi_id')" />
                </div>

                <div>
                    <x-input-label for="tempat_lahir" :value="__('Tempat Lahir')" />
                    <x-text-input wire:model="tempat_lahir" id="tempat_lahir" type="text" class="mt-1 block w-full" />
                    <x-input-error class="mt-2" :messages="$errors->get('tempat_lahir')" />
                </div>

                <div>
                    <x-input-label for="tgl_lahir" :value="__('Tanggal Lahir')" />
                    <x-text-input wire:model="tgl_lahir" id="tgl_lahir" type="date" class="mt-1 block w-full" />
                    <x-input-error class="mt-2" :messages="$errors->get('tgl_lahir')" />
                </div>

                <div>
                    <x-input-label for="jenis_kelamin" :value="__('Jenis Kelamin')" />
                    <select wire:model="jenis_kelamin" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        <option value="">-- Pilih --</option>
                        <option value="Laki-laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                    <x-input-error class="mt-2" :messages="$errors->get('jenis_kelamin')" />
                </div>

                <div>
                    <x-input-label for="agama" :value="__('Agama')" />
                    <select wire:model="agama" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        <option value="">-- Pilih Agama --</option>
                        <option value="Islam">Islam</option>
                        <option value="Kristen Katolik">Kristen Katolik</option>
                        <option value="Kristen Protestan">Kristen Protestan</option>
                        <option value="Hindu">Hindu</option>
                        <option value="Buddha">Buddha</option>
                        <option value="Konghucu">Konghucu</option>
                    </select>
                </div>

                <div>
                    <x-input-label for="hp" :value="__('No. Handphone')" />
                    <x-text-input wire:model="hp" id="hp" type="text" class="mt-1 block w-full" />
                    <x-input-error class="mt-2" :messages="$errors->get('hp')" />
                </div>

                <div>
                    <x-input-label for="npwp" :value="__('NPWP')" />
                    <x-text-input wire:model="npwp" id="npwp" type="text" class="mt-1 block w-full" />
                    <x-input-error class="mt-2" :messages="$errors->get('npwp')" />
                </div>

                <div>
                    <x-input-label for="bank_id" :value="__('Bank')" />
                    <select wire:model="bank_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        <option value="">-- Pilih Bank --</option>
                        @foreach ($bankList as $bank)
                            <option value="{{ $bank->id }}">{{ $bank->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <x-input-label for="no_rek" :value="__('No. Rekening')" />
                    <x-text-input wire:model="no_rek" id="no_rek" type="text" class="mt-1 block w-full" />
                    <x-input-error class="mt-2" :messages="$errors->get('no_rek')" />
                </div>

                <div>
                    <x-input-label for="pendidikan_id" :value="__('Pendidikan')" />
                    <select wire:model="pendidikan_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        <option value="">-- Pilih Pendidikan --</option>
                        @foreach ($pendidikanList as $pendidikan)
                            <option value="{{ $pendidikan->id }}">{{ $pendidikan->nama_pendidikan }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <x-input-label for="is_bpmp" :value="__('Status BPMP (1/0)')" />
                    <x-text-input wire:model="is_bpmp" id="is_bpmp" type="number" class="mt-1 block w-full" />
                    <x-input-error class="mt-2" :messages="$errors->get('is_bpmp')" />
                </div>
            </div>

            @if(!auth()->user()->pegawai)
                <p class="mt-4 text-sm text-red-600 italic">
                    * Perhatian: Akun Anda belum terhubung secara otomatis dengan data pegawai. Menyimpan form ini akan mencoba membuat data baru.
                </p>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>
            <x-action-message class="me-3" on="profile-updated">{{ __('Saved.') }}</x-action-message>
        </div>
    </form>
</section>
