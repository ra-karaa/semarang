@extends('layouts.app')
@section('content')

<div class="container pt-2 mt-2 justify-content-center">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-8 text-start">
                    Silhkan Lengkapi informasi di bawah Ini
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
            <form method="POST" action="{{ route('trans.store') }}">
                @csrf
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Produk</label>
                    <select name="produk_id" class="form-control">
                        @php
                            $produk = App\Models\Produk::all();
                        @endphp
                        @foreach($produk as $temp)
                        <option value="{{ $temp->id }}">{{ $temp->name }}</option>
                        @endforeach
                    </select>
                  </div>
                <div class="mb-3">
                  <label for="exampleInputEmail1" class="form-label">Jumlah</label>
                  <input type="text" name="kuantity" class="form-control"  aria-describedby="emailHelp">
                </div>
                <button type="submit" class="btn btn-primary">Kirim</button>
              </form>
        </div>
    </div>
</div>

@endsection
