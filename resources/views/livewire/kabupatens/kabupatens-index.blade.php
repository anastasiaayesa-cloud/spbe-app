<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Kabupaten') }}
    </h2>
</x-slot>

<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">

                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 border">#</th>
                                <th class="px-4 py-2 border">Nama</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($kabupatens as $kabupaten)
                                <tr>
                                    <td class="px-4 py-2 border">{{ $kabupaten->id }}</td>
                                    <td class="px-4 py-2 border">{{ $kabupaten->nama }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-2 border text-center">
                                        Tidak ada Kabupaten .
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $kabupatens->links() }}
                </div>

            </div>
        </div>
    </div>
</div>