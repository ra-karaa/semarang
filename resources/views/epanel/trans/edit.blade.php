@extends('layouts.app')
@section('content')

<div class="container pt-2 mt-2 justify-content-center">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-8 text-start">
                    Silhkan Lengkapi informasi di bawah
                </div>
                <div class="col-md-4 text-end">
                    <a href="{{ route('trans.index') }}" class="btn btn-primary">
                        Kembali
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            @if (\Session::has('error'))
                <div class="alert alert-success">
                    <ul>
                        <li>{!! \Session::get('error') !!}</li>
                    </ul>
                </div>
            @endif
            <form method="POST" action="{{ route('transaksi.update', $data->trans_id) }}" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">User</label>
                    <input type="text" name="peler" value="{{ $data->trans->peler }}" class="form-control"  aria-describedby="emailHelp">
                  </div>
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Harga Satuan</label>
                    <input type="text" name="harga" value="{{ $data->harga_satuan }}" class="form-control"  aria-describedby="emailHelp">
                  </div>
                <div class="mb-3">
                  <label for="exampleInputEmail1" class="form-label">Jumlah</label>
                  <input type="text" name="total" value="{{ $data->total }}" class="form-control"  aria-describedby="emailHelp">
                </div>
                <button type="submit" class="btn btn-primary">Kirim</button>
              </form>
        </div>
    </div>
</div>

@endsection
