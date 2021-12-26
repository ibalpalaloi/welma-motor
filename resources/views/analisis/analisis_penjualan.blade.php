@extends('layouts.admin')

@section('header-scripts')
 

@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class='col-sm-6'>
                            <label>Pilih tanggal</label>
                            <input type="date" class="datepicker" id="tgl">
                            <button onclick="lihat_tanggal()">Lihat</button>
                            <br><br>
                            <div class="form-group row">
                                <label for="staticEmail" class="col-sm-4 col-form-label">Jumlah Transaksi</label>
                                <div class="col-sm-8">
                                    <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="Rp. {{number_format($total_harga,0,',','.')}}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="staticEmail" class="col-sm-4 col-form-label">Keuntungan</label>
                                <div class="col-sm-8">
                                    <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="Rp. {{number_format($total_keuntungan,0,',','.')}}">
                                </div>
                            </div>
                         </div>
                         
                    </div>
                    <br>
                    <table class="table">
                        <thead>
                            <tr>
                               <th>Nama Pembeli</th>
                                <th>Tgl Pembelian</th>
                                <th>Jumlah Transaksi</th>
                                <th>Keuntungan</th> 
                                <th>

                                </th>
                            </tr>
                            
                        </thead>
                        <tbody>
                            @foreach ($data_nota as $nota)
                                <tr>
                                    <td>{{$nota['nama_pembeli']}}</td>
                                    <td>{{$nota['tgl_nota']}}</td>
                                    <td>{{$nota['total_harga']}}</td>
                                    <td>{{$nota['total_keuntungan']}}</td>
                                    <td>
                                        <a target="blank" href="/nota/{{$nota['id']}}" class="btn btn-primary">Cek Detail</a>
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

@section('footer-scripts')
<script>
    function lihat_tanggal(){
        var tgl = $('#tgl').val();
        if(tgl != ""){
            window.location.href = "/analisis-penjualan?tgl="+tgl;
        }
    }
</script>
@endsection