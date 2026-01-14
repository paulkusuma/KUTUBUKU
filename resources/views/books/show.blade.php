<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Buku') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6">
                        <a href="{{ route('books.index') }}" class="text-blue-500 hover:underline">&larr; Kembali ke Daftar Buku</a>
                    </div>
                    <div class="space-y-4">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900">{{ $book->title }}</h3>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <span class="font-semibold">Penulis:</span>
                                <p>{{ $book->author }}</p>
                            </div>
                            <div>
                                <span class="font-semibold">Harga:</span>
                                <p class="text-green-600 font-bold">Rp. {{ number_format($book->price, 2) }}</p>
                            </div>
                             <div>
                                <span class="font-semibold">Stok:</span>
                                <p>{{ $book->stock }} buah</p>
                            </div>
                        </div>
                        <div class="pt-4 border-t border-gray-200">
                            <h4 class="font-semibold mb-2">Deskripsi:</h4>
                            <p class="text-gray-700">{{ $book->description }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>