<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

 <div class="py-10">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-md rounded-lg p-6">

                <h3 class="text-lg font-bold text-gray-800 mb-6">
                    Tambah Buku Baru
                </h3>

                <form action="{{ route('admin.books.store') }}" method="POST" class="space-y-4">
                    @csrf

                    <!-- Judul -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Judul Buku</label>
                        <input type="text" name="title"
                               class="mt-1 w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Masukkan judul buku">
                    </div>

                    <!-- Penulis -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Penulis</label>
                        <input type="text" name="author"
                               class="mt-1 w-full border-gray-300 rounded-lg shadow-sm"
                               placeholder="Nama penulis">
                    </div>

                    <!-- Harga -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Harga</label>
                        <input type="number" name="price"
                               class="mt-1 w-full border-gray-300 rounded-lg shadow-sm"
                               placeholder="Contoh: 50000">
                    </div>

                    <!-- Stok -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Stok</label>
                        <input type="number" name="stock"
                               class="mt-1 w-full border-gray-300 rounded-lg shadow-sm"
                               placeholder="Jumlah stok">
                    </div>

                    <!-- Deskripsi -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
                        <textarea name="description"
                                  class="mt-1 w-full border-gray-300 rounded-lg shadow-sm"
                                  rows="4"
                                  placeholder="Deskripsi buku..."></textarea>
                    </div>

                    <!-- Button -->
                    <div class="flex justify-between items-center pt-4">
                        <a href="{{ route('admin.books.index') }}"
                           class="text-gray-500 hover:underline">
                            ← Kembali
                        </a>

                        <button type="submit"
                                class="bg-blue-500 hover:bg-blue-600 text-white font-semibold px-6 py-2 rounded shadow">
                            Simpan Buku
                        </button>
                    </div>

                </form>

            </div>

        </div>
    </div>

</x-app-layout>