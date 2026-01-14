<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    {{-- LOGIKA UNTUK MENGECEK ROLE --}}
                    @if(Auth::user()->role === 'admin')
                        {{-- INI KONTEN YANG HANYA ADMIN LIHAT --}}
                        <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                            <h3 class="text-lg font-bold text-red-800">Selamat datang, Admin!</h3>
                            <p class="text-red-600">Anda memiliki akses penuh ke sistem.</p>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <a href="{{ route('books.index') }}" class="p-4 bg-blue-50 border border-blue-200 rounded-lg hover:bg-blue-100 block">
                                <h4 class="font-bold text-blue-800">Kelola Buku</h4>
                                <p class="text-blue-600">Lihat dan tambah buku katalog.</p>
                            </a>
                            <a href="{{ route('admin.dashboard') }}" class="p-4 bg-red-50 border border-red-200 rounded-lg hover:bg-red-100 block">
                                <h4 class="font-bold text-red-800">Admin Panel (Rentan)</h4>
                                <p class="text-red-600">Akses halaman admin yang rentan.</p>
                            </a>
                        </div>

                    @else
                        {{-- INI KONTEN YANG HANYA USER BIASA LIHAT --}}
                        <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
                            <h3 class="text-lg font-bold text-green-800">Selamat datang di KUTUBUKU!</h3>
                            <p class="text-green-600">Temukan buku favorit Anda.</p>
                        </div>
                        <a href="{{ route('books.index') }}" class="inline-block bg-blue-500 text-white font-bold py-2 px-4 rounded hover:bg-blue-700">
                            Lihat Koleksi Buku
                        </a>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>