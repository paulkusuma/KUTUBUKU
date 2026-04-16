<x-app-layout>
    <div class="p-6">

        <h2 class="text-2xl font-bold mb-4">Hasil Sync Distributor</h2>

        <div class="bg-white shadow rounded-lg p-4">

            @if(is_array($data) && count($data) > 0)

                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-100 text-left">
                            <th class="p-2 border">Nama</th>
                            <th class="p-2 border">Region</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $item)
                            <tr class="hover:bg-gray-50">
                                <td class="p-2 border">
                                    {{ $item['name'] ?? '-' }}
                                </td>
                                <td class="p-2 border">
                                    {{ $item['region'] ?? '-' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            @else
                <div class="bg-red-100 text-red-700 p-3 rounded">
                    Data tidak valid atau kosong
                </div>
            @endif

        </div>
        @if(isset($data['flag']))
    <div class="bg-green-100 text-green-800 p-3 rounded mt-4">
         <b>{{ $data['flag'] }}</b>
    </div>
@endif

    </div>
</x-app-layout>