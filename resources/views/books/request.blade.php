<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Buku KUTUBUKU') }}
        </h2>
    </x-slot>

   <h2>Request Buku Baru</h2>

@if(session('success'))
    <p style="color:green">{{ session('success') }}</p>
@endif

<form method="POST" action="{{ route('books.request.store') }}">
    @csrf

    <input type="text" name="title" placeholder="Judul Buku"><br><br>
    <input type="text" name="author" placeholder="Penulis"><br><br>

    <input type="url" name="reference_url" placeholder="Link referensi"><br><br>

    <button type="submit">Kirim Request</button>
</form>

@if(file_exists(storage_path('app/public/preview.jpg')))
    <img src="{{ asset('storage/preview.jpg') }}" width="200">
@endif
</x-app-layout>