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

<aside x-data="{ open: true }"
    class="fixed inset-y-0 left-0 z-40 w-64 bg-white border-r border-gray-200
           transform transition-transform duration-200 ease-in-out
           lg:translate-x-0"
    :class="{ '-translate-x-full': !open }">

    <!-- Logo -->
    <div class="h-16 flex items-center px-8 border-b">
        <a href="{{ route('dashboard') }}" wire:navigate class="flex items-center gap-2">
            <x-application-logo class="h-8 w-auto text-gray-800" />
            <span class="font-semibold text-gray-700">SPBE</span>
        </a>
    </div>

    <!-- Menu -->
    <nav class="flex-1 px-3 py-8 space-y-1 text-sm">

    @php
        $menuClass = 'block px-3 py-2 rounded-md transition';
        $activeClass = 'bg-blue-100 text-blue-700 font-semibold';
        $inactiveClass = 'text-gray-700 hover:bg-gray-100';
    @endphp

    <a href="{{ route('dashboard') }}" wire:navigate
       class="{{ $menuClass }} {{ request()->routeIs('dashboard') ? $activeClass : $inactiveClass }}">
        Dashboard
    </a>

    @role('perencanaan|admin')
        <a href="{{ route('dokumen-perencanaan.index') }}" wire:navigate
           class="{{ $menuClass }} {{ request()->routeIs('dokumen-perencanaan.index') ? $activeClass : $inactiveClass }}">
            Dokumen Perencanaan
        </a>

        <a href="{{ route('perencanaans.index') }}" wire:navigate
           class="{{ $menuClass }} {{ request()->routeIs('perencanaans.index') ? $activeClass : $inactiveClass }}">
            Perencanaan
        </a>
    @endrole

    @role('kepegawaian|admin')
        <a href="{{ route('kepegawaians.index') }}" wire:navigate
           class="{{ $menuClass }} {{ request()->routeIs('kepegawaians.index') ? $activeClass : $inactiveClass }}">
            Pegawai
        </a>

        <a href="{{ route('keuangans.index') }}" wire:navigate
           class="{{ $menuClass }} {{ request()->routeIs('keuangans.index') ? $activeClass : $inactiveClass }}">
            Keuangan
        </a>
    @endrole

    @role('kesekretariatan|admin')
        <a href="{{ route('persuratans.index') }}" wire:navigate
           class="{{ $menuClass }} {{ request()->routeIs('persuratans.index') ? $activeClass : $inactiveClass }}">
            Persuratan
        </a>
    @endrole

    @role('pegawai|admin')
        <a href="{{ route('pelaksanaans.index') }}" wire:navigate
           class="{{ $menuClass }} {{ request()->routeIs('pelaksanaans.index') ? $activeClass : $inactiveClass }}">
            Submit Bukti Pelaksanaan
        </a>
    @endrole

    @role('katim|admin')
        <a href="{{ route('rencanas.index') }}" wire:navigate
           class="{{ $menuClass }} {{ request()->routeIs('rencanas.index') ? $activeClass : $inactiveClass }}">
            Rencana Kegiatan
        </a>
    @endrole

    @role('admin')
        <a href="{{ route('instansis.index') }}" wire:navigate
           class="{{ $menuClass }} {{ request()->routeIs('instansis.index') ? $activeClass : $inactiveClass }}">
            Instansi
        </a>

        <a href="{{ route('kabupatens.index') }}" wire:navigate
           class="{{ $menuClass }} {{ request()->routeIs('kabupatens.index') ? $activeClass : $inactiveClass }}">
            Kabupaten
        </a>
    @endrole
</nav>


    <!-- User -->
    <div class="border-t px-4 py-4 text-sm">
        <div class="font-medium text-gray-700">
            {{ auth()->user()->name }}
        </div>
        <div class="text-xs text-gray-500 mb-3">
            {{ auth()->user()->email }}
        </div>

        <x-nav-link :href="route('profile')" wire:navigate>
            Profile
        </x-nav-link>

        <button wire:click="logout"
            class="w-full text-left mt-2 text-red-600 hover:bg-red-50 rounded px-2 py-1">
            Log Out
        </button>
    </div>
</aside>

