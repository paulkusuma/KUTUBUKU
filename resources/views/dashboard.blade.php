<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <!-- KONTEN BARU ANDA ADA DI SINI -->
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium mb-4">Selamat datang di dashboard KUTUBUKU!</h3>
                    <p class="mb-4">Ini adalah toko buku online sederhana. Mulai jelajahi koleksi kami.</p>
                    <a href="{{ route('books.index') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Lihat Koleksi Buku
                    </a>
                </div>
                <!-- AKHIR KONTEN BARU -->
            </div>
        </div>
    </div>
</x-app-layout>