<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Buku KUTUBUKU') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6">
                        <a href="{{ route('dashboard') }}" class="text-blue-500 hover:underline">&larr; Kembali ke Dashboard</a>
                    </div>
                    
                    <!-- Form Pencarian -->
                    <form action="{{ route('books.index') }}" method="GET" class="mb-6">
                        <div class="flex">
                            <input type="text" name="search" class="shadow appearance-none border rounded-l w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Cari judul atau penulis..." value="{{ request('search') }}">
                            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-r focus:outline-none focus:shadow-outline" type="submit">
                                Cari
                            </button>
                        </div>
                    </form>

                    <!-- Daftar Buku -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse($books as $book)
                            <div class="bg-white border border-gray-200 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                                <div class="p-4">
                                    <h5 class="text-lg font-bold text-gray-900 truncate">{{ $book->title }}</h5>
                                    <p class="text-gray-600 text-sm mb-2">oleh {{ $book->author }}</p>
                                    <p class="text-gray-800 font-semibold">Rp. {{ number_format($book->price, 2) }}</p>
                                    <div class="mt-4">
                                        <!-- INI ADALAH TOMBOL YANG ANDA CARI -->
                                        <form action="{{ route('cart.add', $book->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="w-full bg-blue-500 text-white text-center font-bold py-2 px-4 rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                                                Tambah ke Keranjang
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full text-center text-gray-500">
                                <p>Belum ada buku tersedia.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>