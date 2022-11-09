<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use Illuminate\Support\Facades\Validator;

class ProdukController extends Controller
{
    public function __construct(Produk $produk)
    {
        $this->produk = $produk;
    }

    public function index()
    {
        $data = $this->produk->latest()->get();
        return view('epanel.produk.index', compact('data'));
    }

    public function create()
    {
        return view('epanel.produk.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'price' => 'required',
            'stock' => 'required'
        ]);

        if($validator->fails()){
            return redirect()->back()->with('error', 'Username Tidak Valid');
        } else {
            $data = $request->except(['_token']);
            $this->produk->create($data);
            return redirect()->route('produk.index');
        }

    }

    public function edit($id)
    {
        $data = $this->produk->find($id);
        return view('epanel.produk.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $data = $this->produk->where('id', $id)
                ->update([
                    'name' => $request->name,
                    'price' => $request->price,
                    'stock' => $request->stock
                ]);
        return redirect()->route('produk.index');
    }

}
