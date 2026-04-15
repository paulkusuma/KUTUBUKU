<x-app-layout>
    <div class="p-6">

        <h2 class="text-xl font-bold">Stock / Distributor Sync Service</h2>

        <p class="text-gray-600 mb-4">
            Sistem akan mengambil data distributor dari internal service.
        </p>

        <form method="POST" action="{{ route('distributor.sync') }}">
            @csrf

            <input type="hidden" name="id" value="1">

            <button class="bg-blue-500 text-white px-4 py-2 rounded">
                Sync Now
            </button>
        </form>

    </div>
</x-app-layout>