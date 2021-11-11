@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">

                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                               <th>Nama Pembeli</th>
                                <th>Tgl Pembelian</th>
                                <th>Jumlah Transaksi</th>
                                <th>Keuntungan</th> 
                            </tr>
                            
                        </thead>
                        <tbody>
                            @foreach ($data_nota as $nota)
                                <tr>
                                    <td>{{$nota['nama_pembeli']}}</td>
                                    <td>{{$nota['tgl_nota']}}</td>
                                    <td>{{$nota['total_harga']}}</td>
                                    <td>{{$nota['total_keuntungan']}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection