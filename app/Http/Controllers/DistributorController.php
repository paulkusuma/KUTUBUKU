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
        $id = $request->id;

        // 💣 URL dibuat oleh server (inti SSRF)
        $url = "http://kutubuku.test/api/distributor?id=" . $id;

        // 🔥 SSRF terjadi di sini
        $response = file_get_contents($url);

        $data = json_decode($response, true);

        return view('distributor.result', [
            'data' => $data,
            'url' => $url
        ]);
    }
}
