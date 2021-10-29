@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Pembeli</th>
                            <th>Tgl Nota</th>
                            <th>Total Pemebelian</th>
                            <th>Admin</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data_riwayat_nota as $data)
                            <tr>
                                <td>{{$data['nama_pembeli']}}</td>
                                <td>{{$data['tgl_nota']}}</td>
                                <td>Rp. {{$data['total_harga']}}</td>
                                <td>{{$data['nama_admin']}}</td>
                                <td>
                                    <button class="btn btn-primary">Cek Detail</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection