@extends('layouts.admin')

@section('title')
Penjualan | Analisis
@endsection


@section('header-breadcumb')

Penjualan | Analisis

@endsection

@section('list-breadcumb')
<li class="breadcrumb-item active">Analisis</li>
<li class="breadcrumb-item active">Penjualan</li>
@endsection

@php
function tgl_indo($tanggal){
$bulan = array (
1 => 'Januari',
'Februari',
'Maret',
'April',
'Mei',
'Juni',
'Juli',
'Agustus',
'September',
'Oktober',
'November',
'Desember'
);
$pecahkan = explode('-', $tanggal);
return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
}
@endphp

@section('header-scripts')


@endsection


@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header bg-light">
                    <h5>ANALISIS PENJUALAN</h5>
                </div>
                <div class="card-body">

                    <div class="row">
                        <div class='col-md-12'>
                            <label>Pilih tanggal</label>
                            <div class="row">
                                <div class="col-sm-3">
                                    <input type="date" class="datepicker form-control" id="tgl">
                                </div>
                                <div class="col">

                                    <button onclick="lihat_tanggal()" class="btn btn-success p-2"><i class="feather icon-calendar"></i> Lihat Tanggal</button>

                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group row">
                                        <label for="staticEmail" class="col-sm-3 col-form-label"><strong>Jumlah Transaksi :</strong></label>
                                        <div class="col-sm-8">
                                            <input type="text" readonly class="form-control-plaintext" value="Rp. {{number_format($total_harga,0,',','.')}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group row">
                                        <label for="staticEmail" class="col-sm-3 col-form-label"><strong>Keuntungan :</strong></label>
                                        <div class="col-sm-8">
                                            <input type="text" readonly class="form-control-plaintext" value="Rp. {{number_format($total_keuntungan,0,',','.')}}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                          
                           
                        </div>
                        <br>
                        <div class="col-md-12">
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                       <th>Nama Pembeli</th>
                                        <th>Tanggal Pemesanan</th>
                                        <th>Jumlah Transaksi</th>
                                        <th>Keuntungan</th> 
                                        <th>
                                            Aksi
                                        </th>
                                    </tr>
                                    
                                </thead>
                                <tbody>
                                    @foreach ($data_nota as $nota)
                                        <tr>
                                            <td>{{$nota['nama_pembeli']}}</td>
                                            <td>
                                                {{ tgl_indo(date('Y-m-d', strtotime($nota['tgl_nota']))) }}
                                            </td>
                                            <td>
                                                Rp. {{number_format($nota['total_harga'],0,',','.')}}
                                            </td>
                                            <td>
                                                Rp. {{number_format($nota['total_keuntungan'],0,',','.')}}
                                            
                                            </td>
                                            <td>
                                                <a target="blank" href="{{url('/')}}/nota/{{$nota['id']}}" class="btn btn-primary btn-sm"><i class="feather icon-bookmark"></i> Lihat Nota</a>
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
    </div>
@endsection

@section('footer-scripts')
<script>
    function lihat_tanggal(){
        var tgl = $('#tgl').val();
        if(tgl != ""){
            window.location.href = "{{url('/')}}/analisis-penjualan?tgl="+tgl;
        }
    }
</script>
@endsection