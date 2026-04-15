<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

   <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Tombol Tambah Buku -->
            <div class="mb-6 flex justify-between items-center">
                <h3 class="text-lg font-bold text-gray-800">Daftar Buku</h3>

                <a href="{{ route('admin.books.create') }}"
                   class="bg-green-500 hover:bg-green-600 text-white font-semibold px-4 py-2 rounded shadow">
                    + Tambah Buku
                </a>
            </div>

            <!-- Table -->
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <table class="w-full text-sm text-left text-gray-600">
                    
                    <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
                        <tr>
                            <th class="px-6 py-3">Judul</th>
                            <th class="px-6 py-3">Penulis</th>
                            <th class="px-6 py-3">Harga</th>
                            <th class="px-6 py-3">Stok</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($books as $book)
                        <tr class="border-b hover:bg-gray-50 transition">
                            
                           <!-- Judul (XSS tetap aktif) -->
    <td class="px-6 py-4 font-semibold text-gray-900">
        {!! $book->title !!}
    </td>

    <td class="px-6 py-4">
        {{ $book->author }}
    </td>

    <!-- FORM UPDATE -->
    <td class="px-6 py-4">
        <form action="{{ route('admin.books.update') }}" method="POST" class="flex gap-2 items-center">
            @csrf
            <input type="hidden" name="id" value="{{ $book->id }}">

            <input type="number" name="price" value="{{ $book->price }}"
                class="w-24 border rounded px-2 py-1 text-xs">

            <input type="number" name="stock" value="{{ $book->stock }}"
                class="w-16 border rounded px-2 py-1 text-xs">

            <button class="bg-blue-500 hover:bg-blue-600 text-white px-2 py-1 text-xs rounded">
                Update
            </button>
        </form>
    </td>

    <!-- STOK BADGE -->
    <td class="px-6 py-4">
        <span class="px-2 py-1 text-xs font-bold rounded 
            {{ $book->stock > 0 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
            {{ $book->stock }}
        </span>
    </td>

    <!-- DELETE -->
    <td class="px-6 py-4">
        <a href="{{ route('admin.books.delete', $book->id) }}"
           class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 text-xs rounded">
            Hapus
        </a>
    </td>

</tr>
                        @endforeach
                    </tbody>

                </table>
            </div>

        </div>
    </div>
</x-app-layout>