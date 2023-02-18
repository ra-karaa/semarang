<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Trans;
use App\Models\TransDetail;

class TransController extends Controller
{
    public function __construct(Trans $trans, TransDetail $detail)
    {
        $this->trans = $trans;
        $this->detail = $detail;
    }

    public function index()
    {
        $data = $this->trans->with('detail')->get();
        return view('epanel.trans.index', compact('data'));
    }

    public function create()
    {
        return view('epanel.trans.create');
    }

    public function store(Request $request)
    {
        $mohon = $request->except(['_token', 'peler']);
        $saldo = 0;
        $cek = $this->trans->where('peler', $request->peler)->latest()->first();
        $data = new $this->trans();
        if(is_null($cek)){
            $saldo = 0;
        } else {
            $saldo = $cek->saldo_akhir;
        }

        $data = new $this->trans;
        $data->peler = $request->peler;
        $data->save();
        $detailnya = [
            'trans_id' => $data->id,
            'harga_satuan' => $request->harga,
            'total' => $request->total,
            'jumlah' => $request->harga * $request->total
        ];
        $this->detail->create($detailnya);

        $update = $this->trans->where('id', $data->id)
                    ->update([
                        'saldo_awal' => $saldo,
                        'saldo_akhir' => $saldo + $request->harga * $request->total
                    ]);

        return redirect()->route('transaksi.index');
    }

    public function edit($id)
    {
        $data = $this->detail->where('trans_id', $id)->first();
        return view('epanel.trans.edit', compact('data'));

    }

    public function update(Request $request, $id)
    {
        $data = TransaksiDetail::where('id', $request->id_detail)->first();
        $coba = Transaksi::where('id', $data->transaksi_id)->first();
        $su = TransaksiDetail::where('transaksi_id', $coba->id)->get();

        $jumlah_awal = 0;
        foreach($su as $susu){
            $jumlah_awal += $susu->harga;
        }

        $totalan = 0;
        for ($i=0; $i < count($request->id_detail); $i++) {
            $harga = $request->berat[$i] * $request->harga[$i];
            $totalan += $harga;
        }


        if($jumlah_awal < $totalan){
            $cek = Transaksi::where('user_id', $coba->user_id)->where('id' ,'>=', $data->transaksi_id)->get();
            for ($i=0; $i < count($request->id_detail); $i++) {
                TransaksiDetail::where('id', $request->id_detail[$i])->update([
                    'jenis_id'=>$request->barang_id[$i],
                    'jumlah'=>$request->berat[$i],
                    'harga_satuan'=>$request->harga[$i],
                    'harga'=>$harga,
                ]);
            }

            $plus = abs(($coba->saldo_akhir - $coba->saldo_awal) - $totalan);
            foreach($cek as $i => $temp){
                $saldo_akhir[] = $temp->saldo_akhir;
                    Transaksi::where('id', $temp->id)
                    ->update([
                        'saldo_akhir' => $saldo_akhir[$i] + $plus
                    ]);
            }

            $cek_lebih = Transaksi::where('user_id', $coba->user_id)->where('id' ,'>', $data->transaksi_id)->get();
            foreach($cek_lebih as $i => $temp){
                $saldo_awal[] = $temp->saldo_awal;
                Transaksi::where('id', $temp->id)
                ->update([
                    'saldo_awal' => $saldo_awal[$i] + $plus
                ]);
            }

            $cek_kureng = Transaksi::where('user_id', $coba->user_id)->where('id' ,'<', $data->transaksi_id)->get();
            if(empty($cek_kureng)){
                Transaksi::where('id', $data->transaksi_id)
                ->update([
                    'saldo_awal' => '0'
                ]);
            }

        } else {
            $cek = Transaksi::where('user_id', $coba->user_id)->where('id' ,'>=', $data->transaksi_id)->get();
            $kureng = abs(($coba->saldo_akhir - $coba->saldo_awal) - $request->harga * $request->total);
            $data->harga_satuan = $request->harga;
            $data->total = $request->total;
            $data->jumlah = $request->harga * $request->total;

            $data->save();

            foreach($cek as $i => $temp){
                    $saldo_akhir[] = $temp->saldo_akhir;
                    Transaksi::where('id', $temp->id)
                    ->update([
                        'saldo_akhir' =>  $saldo_akhir[$i] - $kureng
                    ]);
            }

            $cek_lebih = Transaksi::where('user_id', $coba->user_id)->where('id' ,'>', $data->transaksi_id)->get();
            foreach($cek_lebih as $i => $temp){
                $saldo_awal[] = $temp->saldo_awal;
                Transaksi::where('id', $temp->id)
                ->update([
                    'saldo_awal' => $saldo_awal[$i] - $kureng
                ]);
            }

            $cek_kureng = Transaksi::where('user_id', $coba->user_id)->where('id' ,'<', $data->transaksi_id)->get();
            if(empty($cek_kureng)){
                Transaksi::where('id', $data->transaksi_id)
                ->update([
                    'saldo_awal' => '0'
                ]);
            }
        }

    }

    public function delete($id)
    {
        $data = Trans::find($id);
        $cek = Trans::where('peler', 1)->where('id', '>', $id)->get();
        $saldo_awal = [];
        $saldo_akhir = [];

        if(count($cek) === 0){
            $data->delete();
            return redirect()->back();
        } else {
            if($data->saldo_awal == 0){
                foreach($cek as $i => $becek){
                    $kurang = abs($data->saldo_akhir - $becek->saldo_awal);
                    $saldo_awal[] = $kurang;
                    Trans::where('id', $becek->id)
                    ->update([
                        'saldo_awal' => $saldo_awal[$i]
                    ]);
                }

                foreach($cek as $c => $memek){
                    $kurang_juga = abs($data->saldo_akhir - $memek->saldo_akhir);
                    $saldo_akhir[] = $kurang_juga;
                    Trans::where('id', $memek->id)
                    ->update([
                        'saldo_akhir' => $saldo_akhir[$c]
                    ]);
                }
            } else {
                foreach($cek as $i => $becek){
                    $step1 = abs(($data->saldo_awal - $data->saldo_akhir));
                    $kurang = $becek->saldo_awal - $step1;
                    $saldo_awal[] = $kurang;
                    Trans::where('id', $becek->id)
                    ->update([
                        'saldo_awal' => $saldo_awal[$i]
                    ]);
                }

                foreach($cek as $c => $memek){
                    $step2 = abs(($data->saldo_awal - $data->saldo_akhir));
                    $kurang_juga = $becek->saldo_akhir - $step2;
                    $saldo_akhir[] = $kurang_juga;
                    Trans::where('id', $memek->id)
                    ->update([
                        'saldo_akhir' => $saldo_akhir[$c]
                    ]);
                }
            }

            $data->delete();

            return redirect()->back();
        }
    }




}
