<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Cetak Invoice') }}
        </h2>
    </x-slot>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Cetak Invoice</div>
                    <div class="card-body">
                        <p class="text-warning">
                            <strong>PERINGATAN:</strong> Fitur ini menggunakan library pihak ketiga yang rentan. Jangan memasukkan URL sembarangan.
                        </p>
                        <form method="GET" action="{{ route('cart.invoice') }}">
                            <div class="mb-3">
                                <label for="logo_url" class="form-label">URL Logo (Opsional)</label>
                                <input type="url" class="form-control" id="logo_url" name="logo_url">
                                <div class="form-text">Masukkan URL logo untuk dicetak di invoice.</div>
                            </div>
                            <button type="submit" class="btn btn-primary">Buat Invoice</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(isset($logoData))
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-danger"> <!-- TAMBAHKAN KELAS border-danger -->
                <div class="card-header bg-danger text-white"> <!-- TAMBAHKAN KELAS bg-danger text-white -->
                </div>
                <div class="card-body text-center">
                    <img src="data:image/png;base64,{{ $logoData }}" alt="Invoice Logo" style="max-width: 200px; border: 3px solid red;">
                </div>
            </div>
        </div>
    </div>
</div>
@endif
</x-app-layout>