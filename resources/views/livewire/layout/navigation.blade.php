<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component
{
    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}; ?>

<aside x-data="{ open: true }" class="fixed top-0 left-0 z-40 w-64 h-screen bg-white border-r border-gray-200">
    <div class="flex flex-col h-full px-4 py-6">

        <!-- Logo -->
        <div class="flex items-center gap-3 mb-8 px-2">
            <a href="{{ route('dashboard') }}" wire:navigate class="flex items-center gap-2">
                <x-application-logo class="h-8 w-auto text-gray-800" />
                <span class="text-lg font-semibold tracking-wide">SPBE</span>
            </a>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 space-y-1 text-sm">

            <x-nav-link class="block px-3 py-2 rounded-lg"
                :href="route('dashboard')"
                :active="request()->routeIs('dashboard')"
                wire:navigate>
                Dashboard
            </x-nav-link>

            @role('perencanaan|admin')
                <x-nav-link class="block px-3 py-2 rounded-lg"
                    :href="route('dokumen-perencanaan.index')"
                    :active="request()->routeIs('dokumen-perencanaan.*')"
                    wire:navigate>
                    Dokumen Perencanaan
                </x-nav-link>

                <x-nav-link class="block px-3 py-2 rounded-lg"
                    :href="route('perencanaans.index')"
                    :active="request()->routeIs('perencanaans.*')"
                    wire:navigate>
                    Perencanaan Pegawai
                </x-nav-link>
            @endrole

            @role('kepegawaian|admin')
                <x-nav-link class="block px-3 py-2 rounded-lg"
                    :href="route('kepegawaians.index')"
                    :active="request()->routeIs('kepegawaians.*')"
                    wire:navigate>
                    Pegawai
                </x-nav-link>

                <x-nav-link class="block px-3 py-2 rounded-lg"
                    :href="route('keuangans.index')"
                    :active="request()->routeIs('keuangans.*')"
                    wire:navigate>
                    Keuangan
                </x-nav-link>

                <x-nav-link class="block px-3 py-2 rounded-lg"
                    :href="route('pelaksanaans.index')"
                    :active="request()->routeIs('pelaksanaans.*')"
                    wire:navigate>
                    Jenis Bukti
                </x-nav-link>
            @endrole

            @role('kesekretariatan|admin')
                <x-nav-link class="block px-3 py-2 rounded-lg"
                    :href="route('persuratans.index')"
                    :active="request()->routeIs('persuratans.*')"
                    wire:navigate>
                    Persuratan
                </x-nav-link>
            @endrole

            @role('pegawai|admin')
                <x-nav-link class="block px-3 py-2 rounded-lg"
                    :href="route('pelaksanaans.index')"
                    :active="request()->routeIs('pelaksanaans.*')"
                    wire:navigate>
                    Jenis Bukti
                </x-nav-link>

                <x-nav-link class="block px-3 py-2 rounded-lg"
                    :href="route('keuangans.index')"
                    :active="request()->routeIs('keuangans.*')"
                    wire:navigate>
                    Keuangan
                </x-nav-link>
            @endrole

            @role('katim|admin')
                <x-nav-link class="block px-3 py-2 rounded-lg"
                    :href="route('rencanas.index')"
                    :active="request()->routeIs('rencanas.*')"
                    wire:navigate>
                    Rencana Kegiatan Instansi
                </x-nav-link>
            @endrole

            @role('admin')
                <!-- 🔹 MENU KEUANGAN (DITAMBAHKAN) -->
                <x-nav-link class="block px-3 py-2 rounded-lg"
                    :href="route('keuangans.index')"
                    :active="request()->routeIs('keuangans.*')"
                    wire:navigate>
                    Keuangan
                </x-nav-link>

                <x-nav-link class="block px-3 py-2 rounded-lg"
                    :href="route('instansis.index')"
                    :active="request()->routeIs('instansis.*')"
                    wire:navigate>
                    Instansi
                </x-nav-link>

                <x-nav-link class="block px-3 py-2 rounded-lg"
                    :href="route('kabupatens.index')"
                    :active="request()->routeIs('kabupatens.*')"
                    wire:navigate>
                    Kabupaten
                </x-nav-link>

                <x-nav-link class="block px-3 py-2 rounded-lg"
                    :href="route('admin.akses')"
                    :active="request()->routeIs('admin.akses')"
                    wire:navigate>
                    Manajemen Hak Akses
                </x-nav-link>
            @endrole

        </nav>

        <!-- User -->
        <div class="pt-4 mt-4 border-t space-y-1">
            <x-nav-link class="block px-3 py-2 rounded-lg"
                :href="route('profile')"
                wire:navigate>
                Profile
            </x-nav-link>

            <button wire:click="logout"
                class="w-full text-left px-3 py-2 rounded-lg text-red-600 hover:bg-red-50 transition">
                Log Out
            </button>
        </div>

    </div>
</aside>

