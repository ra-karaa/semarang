@extends('layouts.app')
@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-8 text-start">
                            Data Transaksi
                        </div>
                        <div class="col-md-4 text-end">
                            <a href="{{ route('transaksi.create') }}" class="btn btn-primary">
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
                            <th scope="col">Saldo Awal</th>
                            <th scope="col">Saldo Akhir</th>
                            <th></th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach ($data as $i => $temp)
                              <tr>
                                <td>
                                    {{ $temp->id }}
                                </td>
                                <td>
                                    {{ $temp->saldo_awal }}
                                </td>
                                <td>
                                    {{ $temp->saldo_akhir }}
                                </td>
                                <td>
                                    <a href="{{ route('transaksi.edit', $temp->id) }}">
                                        Ubah
                                    </a>
                                    <a href="{{ route('transaksi.delete', $temp->id) }}">
                                        Delete
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

