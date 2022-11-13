<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Produk;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;

class TransaksiController extends Controller
{
    public function __construct(Transaksi $trans, Produk $produk)
    {
        $this->trans = $trans;
        $this->produk = $produk;
    }

    public function index()
    {
        $data = $this->trans->latest()->get();
        return view('epanel.transaksi.index', compact('data'));
    }

    public function create()
    {
        return view('epanel.transaksi.create');
    }

    public function store(Request $request)
    {
        $data = $request->except(['_token']);
        $produk = $this->produk->where('id', $request->produk_id)->first();
        $total = $request->kuantity * $produk->price;
        $cek = new $this->trans();
        $cek->price = $produk->price;
        $cek->total_price = $total;
        $cek->user_id = auth()->user()->id;
        $cek->kuantity = $request->kuantity;
        $cek->produk_id = $request->produk_id;
        $cek->save();

        $client = new \GuzzleHttp\Client();
        $response = $client->request('POST', 'https://sandbox.saebo.id/api/v1/payments', [
            'headers' => [
                'X-API-KEY' => '123ABC'
            ],
            'form_params' => [
                'reference_id' => $cek->id,
                'amount' => $produk->price,
                'product' => $produk->name
            ]
        ]);

        $hasil = json_decode($response->getBody());
        if($hasil->response_code == 2009900){
            $update = $this->trans->where('id', $cek->id)
                    ->update([
                        'reference_number' => $hasil->response_code,
                        'status' => 'SUCCESS'
                    ]);
        } else {
            $update = $this->trans->where('id', $cek->id)
                    ->update([
                        'reference_number' => $hasil->response_code,
                        'status' => 'FAILED'
                    ]);
        }


        return redirect()->route('trans.index');
    }
}
