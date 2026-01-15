<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pembayaran Berhasil') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 text-center">
                    <h3 class="text-lg font-bold text-green-600">Terima kasih!</h3>
                    <p>Pembayaran Anda sebesar <strong>Rp. {{ number_format($totalPrice, 2) }}</strong> telah berhasil diproses.</p>
                    <a href="{{ route('books.index') }}" class="mt-4 inline-block bg-blue-500 text-white font-bold py-2 px-4 rounded">
                        Kembali ke Belanja
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>