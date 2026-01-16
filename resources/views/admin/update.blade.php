<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pembaruan Perangkat Lunak') }}
        </h2>
    </x-slot>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Pembaruan Perangkat Lunak</div>

                    <div class="card-body">
                        <p class="text-danger">
                            <strong>PERINGATAN:</strong> Fitur ini akan mengunduh file dari URL yang Anda berikan dan menyimpannya di server. Gunakan dengan hati-hati.
                        </p>

                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('admin.update.perform') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="update_url" class="form-label">URL Update</label>
                                <input type="url" class="form-control" id="update_url" name="update_url" placeholder="https://updates.kutubuku.com/v2.0.js" required>
                                <div class="form-text">Masukkan URL lengkap ke file update.</div>
                            </div>
                            <button type="submit" class="btn btn-primary">Unduh dan Terapkan Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>