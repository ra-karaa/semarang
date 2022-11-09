@extends('layouts.app')
@section('content')

<div class="container pt-2 mt-2 justify-content-center">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-8 text-start">
                    Ubah Informasi Produk
                </div>
                <div class="col-md-4 text-end">
                    <a href="{{ route('produk.index') }}" class="btn btn-primary">
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
            <form method="POST" action="{{ route('produk.update', $data->id) }}">
                @csrf
                <div class="mb-3">
                  <label for="exampleInputEmail1" class="form-label">Nama Produk</label>
                  <input type="text" value="{{ $data->name }}" name="name" class="form-control"  aria-describedby="emailHelp">
                </div>
                <div class="mb-3">
                  <label for="exampleInputPassword1" class="form-label">Harga</label>
                  <input type="number" value="{{ $data->price }}" name="price" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Stock</label>
                    <input type="number" value="{{ $data->stock }}" name="stock" class="form-control" >
                  </div>
                <button type="submit" class="btn btn-primary">Kirim</button>
              </form>
        </div>
    </div>
</div>

@endsection
