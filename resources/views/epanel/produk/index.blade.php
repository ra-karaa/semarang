@extends('layouts.app')
@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-8 text-start">
                            Data Produk
                        </div>
                        <div class="col-md-4 text-end">
                            <a href="{{ route('produk.create') }}" class="btn btn-primary">
                                Tambah Data
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-responsive table-striped">
                        <thead>
                          <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Harga</th>
                            <th scope="col">Stok</th>
                            <th></th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach ($data as $i => $temp)
                              <tr>
                                <td>
                                    {{ ++$i }}
                                </td>
                                <td>
                                    {{ $temp->name }}
                                </td>
                                <td>
                                    {{ $temp->price }}
                                </td>
                                <td>
                                    {{ $temp->stock }}
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('produk.edit', $temp->id) }}" class="btn btn-md btn-primary">
                                        Ubah
                                    </a>
                                </td>
                              </tr>
                          @endforeach
                        </tbody>
                      </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

