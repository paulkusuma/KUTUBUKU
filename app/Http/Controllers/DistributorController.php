<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DistributorController extends Controller
{
    public function index()
    {
        return view('distributor.index');
    }

    public function sync(Request $request)
    {
        $url = $request->url;

        if (!$url) {
            $url = "http://kutubuku.test/api/distributor?id=1";
        }

        // Tambahkan header khusus (simulasi internal request)
        $context = stream_context_create([
            'http' => [
                'method' => 'GET',
                'header' => "X-Internal-Request: true\r\n"
            ]
        ]);

        // HAPUS @ biar kelihatan error
        $response = file_get_contents($url, false, $context);

        // decode JSON jadi array
        $data = json_decode($response, true);
        return view('distributor.result', [
            'data' => $data,
            'url' => $url
        ]);
    }
}
