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
                        <div class="row">
                            <div class="col-sm-4">
                                <label><strong>Pilih Tanggal :</strong></label>
                            </div> 
                        </div>
                        <div class="row">

                            <div class="col-sm-4">
                                <input type="date" class="form-control" id="tgl">
                            </div>
                            <div class="col">
                                <button onclick="lihat_tanggal()" class="btn btn-success p-2"><i class="feather icon-calendar"></i> Cari</button>
                                <button onclick="export_analisis()" class="btn btn-primary p-2 float-right"><i class="feather icon-download"></i> Export Excel</button>

                            </div>
                        

                        </div>
                        <hr>
                        
                        
                    </div>
                    <br>
                    <div class="col-md-12">
                        <table class="table table-striped table-bordered table-hover" >
                            <thead>
                                <tr>
                                    <th>Nama Montir</th>
                                    <th>Pembeli</th>
                                    <th>Tgl</th>
                                    <th>Jumlah Transaksi</th>
                                    <th></th>
                                </tr>
                                
                            </thead>
                            <tbody>
                                @foreach ($data_riwayat_nota as $data)
                                    <td>{{$data['montir']}}</td>
                                    <td>{{$data['pembeli']}}</td>
                                    <td>{{$data['tgl_nota']}}</td>
                                    <td>
                                        Rp. {{number_format($data['jumlah_transaksi'],0,',','.')}}
                                    <td>
                                        <button onclick="lihat_detail_nota('{{$data['id']}}')" type="button" class="btn btn-primary">Detail</button>
                                    </td>
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

@section('modal-content')
{{-- end modal --}}

@endsection

@section('footer-scripts')
<script>

    var tgl = {!! json_encode($tgl) !!};
    
    function export_analisis(){
        window.location.href = "{{url('/')}}/analisis-montir-export?tgl="+tgl;
    }

    function lihat_tanggal(){
        var tgl = $('#tgl').val();
        var status_nota = $('#select_status_nota').val();
        if(tgl != ""){
            window.location.href = "{{url('/')}}/analisis-montir?tgl="+tgl;


        }
    }

    function lihat_detail_nota(id){
        $.ajax({
            type: "GET",
            url: "{{url('/')}}/analisis-get-detail-nota/"+id,
            success:function(data){
                var data_pesanan = data.data_pesanan;
                var table = "";
                for(let i = 0; i < data_pesanan.length; i++){
                    table += "<tr>";
                    table += "<td>"+data_pesanan[i]['nama_barang']+"<br><small><b>Kode : "+data_pesanan[i]['kode_barang']+"</b></small></td>";
                    table += "<td>"+data_pesanan[i]['tipe']+"</td>";
                    table += "<td>"+data_pesanan[i]['merk']+"</td>";
                    table += "<td>"+data_pesanan[i]['jumlah']+"</td>";
                    table += "<td>Rp. "+data_pesanan[i]['harga']+"</td>";
                    table += "<td>Rp. "+data_pesanan[i]['total']+"</td>";
                    table += "<td>Rp. "+data_pesanan[i]['harga_beli']+"<br><small><b>Keuntungan : Rp. "+data_pesanan[i]['keuntungan']+"</b></small></td>";
                    table += "</tr>";
                }
                table += "<tr>"
                table += "<td colspan='5'><b>Total</b></td>"
                table += "<td><b>Rp. "+data.total_harga+"</b></td>"
                table += "<td><b>Rp. "+data.total_modal+"</b><br><small><b>Keuntungan : Rp. "+data.total_keuntungan+"</b></small></td>";
                table += "</tr>"
                $('#tbody_detail_riwayat_pesanan').html(table);
                $('#detail_nama_pembeli').html("Nama Pembeli : "+data.riwayat_nota['nama_pembeli']);
                var status_nota = data.riwayat_nota['status'];
                $('#status_pembeli').html("Status : "+status_nota.toUpperCase());

                $('#modal_detail_nota').modal('show');
            }
        })
    }
</script>
@endsection