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
                    
                    {{-- INI ADALAH BARIS YANG HILANG --}}
                    @if(Auth::user()->role === 'admin')
                        {{-- KONTEN UNTUK ADMIN --}}
                        <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                            <h3 class="text-lg font-bold text-red-800">Selamat datang, Admin!</h3>
                            <p class="text-red-600">Anda memiliki akses penuh ke sistem.</p>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <a href="{{ route('admin.books.index') }}" class="p-4 bg-blue-50 border border-blue-200 rounded-lg hover:bg-blue-100 block">
                                <h4 class="font-bold text-blue-800">Kelola Buku</h4>
                                <p class="text-blue-600">Lihat dan tambah buku katalog.</p>
                            </a>
                            <a href="{{ route('admin.dashboard') }}" class="p-4 bg-red-50 border border-red-200 rounded-lg hover:bg-red-100 block">
                                <h4 class="font-bold text-red-800">Admin Panel (Rentan)</h4>
                                <p class="text-red-600">Akses halaman admin yang rentan.</p>
                            </a>
                        </div>

                    @else
                        {{-- KONTEN UNTUK USER BIASA --}}
                     <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
    <h3 class="text-lg font-bold text-green-800">
        Selamat datang di KUTUBUKU!
    </h3>

    <p class="mt-2">
        <a href="{{ route('books.index') }}"
           class="text-green-600 font-medium underline hover:text-green-800 transition">
            Temukan buku favorit Anda.
        </a>
    </p>
</div>
<!-- 🔥 TAMBAHAN FITUR REQUEST BUKU -->
<div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
    <h4 class="text-lg font-bold text-blue-800">
        Tidak menemukan buku?
    </h4>

    <p class="text-blue-600 mb-3">
        Ajukan permintaan buku baru ke admin.
    </p>

    <a href="{{ route('books.request.form') }}"
       class="inline-block bg-blue-500 hover:bg-blue-600 text-white font-semibold px-4 py-2 rounded">
        Request Buku
    </a>
</div>

<!-- 🔥 DISTRIBUTOR SYNC FEATURE (SSRF LAB) -->
<div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mt-6">

    <h4 class="text-lg font-bold text-yellow-800">
        Stock / Distributor Sync Service
    </h4>

    <p class="text-yellow-600 mb-3">
        Sistem akan melakukan sinkronisasi data distributor dari server internal.
    </p>

    <a href="{{ route('distributor.index') }}"
       class="inline-block bg-yellow-500 hover:bg-yellow-600 text-white font-semibold px-4 py-2 rounded">
        Sync Now
    </a>

</div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>