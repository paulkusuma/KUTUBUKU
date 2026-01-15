<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Keranjang Belanja') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @forelse($cart as $id => $item)
                        <div class="flex justify-between items-center mb-4 p-4 border-b">
                            <div>
                                <h4>{{ $item['title'] }}</h4>
                                <p class="text-gray-600">Rp. {{ number_format($item['price'], 2) }} x {{ $item['quantity'] }}</p>
                            </div>
                            <div class="text-lg font-bold">
                                Rp. {{ number_format($item['price'] * $item['quantity'], 2) }}
                            </div>
                        </div>
                    @empty
                        <p>Keranjang Anda kosong.</p>
                    @endforelse

                    @if(!empty($cart))
                        <form action="{{ route('cart.checkout') }}" method="POST" class="mt-6">
                            @csrf
                            <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                Checkout
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>