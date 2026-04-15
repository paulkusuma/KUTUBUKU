<x-app-layout>
    <div class="p-6">

        <h2 class="text-xl font-bold">Hasil Sync</h2>

        <p class="text-sm text-gray-500">
            URL: {{ $url }}
        </p>

        <hr class="my-4">

        @if(is_array($data))
            @foreach($data as $item)
                <div class="p-2 border-b">
                    <b>{{ $item['name'] ?? '-' }}</b>
                    - {{ $item['region'] ?? '-' }}
                </div>
            @endforeach
        @else
            <pre>{{ $data }}</pre>
        @endif

    </div>
</x-app-layout>