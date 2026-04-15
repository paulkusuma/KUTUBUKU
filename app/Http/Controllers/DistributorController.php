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
        // ❗ ambil langsung dari request (bisa dimanipulasi)
        $url = $request->url;

        // fallback default (biar tetap jalan normal)
        if (!$url) {
            $url = "http://kutubuku.test/api/distributor?id=1";
        }

        // 🔥 SSRF
        $response = @file_get_contents($url);


        return view('distributor.result', [
            'data' => $response,
            'url' => $url
        ]);
    }
}
