<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\{
    DispatchDataInvestProduct,
    Transaksi
};
use Http;

class BackgroundController extends Controller
{
    public function __invoke(Request $request)
    {
        // $response = Http::get('https://ojk-invest-api.vercel.app/api/products');
        // return $bodyJson = $response->json('data');

        DispatchDataInvestProduct::dispatch();
        Transaksi::dispatch();

        return view('welcome');
    }
}
