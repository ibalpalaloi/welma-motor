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

<style>
    td {
        white-space: normal !important; 
    }
</style>
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
                            <div class="col-sm-3">
                                <label><strong>Tanggal Awal:</strong></label>
                            </div>
                            <div class="col-sm-3">
                                <label><strong>Tanggal Akhir:</strong></label>
                            </div>
                            <div class="col-sm-3">
                                <label><strong>Status Nota :</strong></label>
                            </div>  
                        </div>
                        <div class="row">

                            <div class="col-sm-3">
                                <input type="date" class="form-control" id="tgl_mulai" value="{{$tgl_mulai}}">
                            </div>
                            <div class="col-sm-3">
                                <input type="date" class="form-control" id="tgl_akhir" value="{{$tgl_akhir}}">
                            </div>
                            <div class="col-sm-3">
                                <select name="" id="select_status_nota" class="form-control">
                                    <option value="semua" 
                                    @if ($status == 'semua')
                                    selected
                                    @endif>Semua</option>
                                    <option value="umum"
                                    @if ($status == 'umum')
                                    selected
                                    @endif
                                    >Umum</option>
                                    <option value="dinas"
                                    @if ($status == 'dinas')
                                    selected
                                    @endif
                                    >Dinas</option>
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <button onclick="lihat_tanggal()" class="btn btn-success p-2"><i class="feather icon-calendar"></i> Cari</button>
                                <button onclick="export_analisis()" class="btn btn-primary p-2 float-right"><i class="feather icon-download"></i> Export Excel</button>

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
                        <table class="table table-striped table-bordered table-hover" >
                            <thead>
                                <tr>
                                    <th>Nama Pembeli</th>
                                    <th>Status</th>
                                    <th>Tanggal Pemesanan</th>
                                    <th>Jumlah Transaksi</th>
                                    <th>Modal</th>
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
                                        <td>{{strtoupper($nota['status'])}}</td>
                                        <td>
                                            {{ tgl_indo(date('Y-m-d', strtotime($nota['tgl_nota']))) }}
                                        </td>
                                        <td>
                                            Rp. {{number_format($nota['total_harga'],0,',','.')}}
                                        </td>
                                        <td>
                                            Rp. {{number_format($nota['total_modal'],0,',','.')}}
                                        </td>
                                        <td>
                                            Rp. {{number_format($nota['total_keuntungan'],0,',','.')}}
                                        
                                        </td>

                                        <td>
                                            <a target="blank" href="{{url('/')}}/nota/lihat/{{$nota['id']}}" class="btn btn-primary btn-sm"><i class="feather icon-bookmark"></i> Lihat Nota</a>
                                            <button onclick="lihat_detail_nota('{{$nota['id']}}')" class="btn btn-success btn-sm"><i class="feather icon-grid"></i> Detail Penjualan</button>
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

@section('modal-content')
{{-- modal --}}
<div class="modal fade bd-example-modal-lg" id="modal_detail_nota" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">DETAIL NOTA</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-sm-12">
                    <h6 id="detail_nama_pembeli" >Nama Pembeli : </h6>
                    <h6 id="status_pembeli">Status Pembeli : </h6>
                </div>
                <div class="col-sm-12">
                    <table class="table table-striped table-bordered table-hover" style="font-size: 9pt">
                        <thead>
                            <th>Nama Barang</th>
                            <th>Tipe</th>
                            <th>Merek</th>
                            <th>Jumlah</th>
                            <th>Harga</th>
                            <th>Total Harga</th>
                            <th>Modal</th>
                        </thead>
                        <tbody id="tbody_detail_riwayat_pesanan">
                            <tr>
                                <td>
                                    Nama Barang <br>
                                    <small><b>Kode barang</b></small>
        
                                </td>
                                <td>
                                    Nama Barang <br>
                                    <small><b>Kode barang</b></small>
        
                                </td>
                                <td>3</td>
                                <td>89999</td>
                                <td>
                                    Nama Barang <br>
                                    <small><b>Kode barang</b></small>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
      
         
        </div>
        <div class="modal-footer p-2">
            <button type="button" data-dismiss="modal" aria-label="Close" class="btn btn-danger btn-sm"><i class="feather icon-arrow-right"></i> Tutup</button>
        </div>
      </div>
    </div>
</div>
{{-- end modal --}}

@endsection

@section('footer-scripts')
<script>
    var tgl_mulai = {!! json_encode($tgl_mulai) !!};
    var tgl_akhir = {!! json_encode($tgl_akhir) !!};
    var status_nota = {!! json_encode($status) !!};
    
    function export_analisis(){
        window.location.href = "<?=url('/')?>/analisis-export?tgl_mulai="+tgl_mulai+"&tgl_akhir="+tgl_akhir+"&status="+status_nota;
    }

    function lihat_tanggal(){
        var tgl_mulai = $('#tgl_mulai').val();
        var tgl_akhir = $('#tgl_akhir').val();
        var status_nota = $('#select_status_nota').val();
        if(tgl_mulai != "" && tgl_akhir != ""){
            window.location.href = "{{url('/')}}/analisis-penjualan?tgl_mulai="+tgl_mulai+"&tgl_akhir="+tgl_akhir+"&status="+status_nota;
        }
        else{
            alert("Lengkapi Tanggal")
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
                    table += "<td> "+formatRupiah(data_pesanan[i]['harga'])+"</td>";
                    table += "<td> "+formatRupiah(data_pesanan[i]['total'])+"</td>";
                    table += "<td> "+formatRupiah(data_pesanan[i]['harga_beli'])+"<br><small><b>Keuntungan : "+formatRupiah(data_pesanan[i]['keuntungan'])+"</b></small></td>";
                    table += "</tr>";
                }
                table += "<tr>"
                table += "<td colspan='5'><b>Total</b></td>"
                table += "<td><b> "+formatRupiah(data.total_harga)+"</b></td>"
                table += "<td><b> "+formatRupiah(data.total_modal)+"</b><br><small><b>Keuntungan : "+formatRupiah(data.total_keuntungan)+"</b></small></td>";
                table += "</tr>"
                $('#tbody_detail_riwayat_pesanan').html(table);
                $('#detail_nama_pembeli').html("Nama Pembeli : "+data.riwayat_nota['nama_pembeli']);
                var status_nota = data.riwayat_nota['status'];
                $('#status_pembeli').html("Status : "+status_nota.toUpperCase());

                $('#modal_detail_nota').modal('show');
            }
        })
    }
    const formatRupiah = (money) => {
        return new Intl.NumberFormat('id-ID',
            { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }
        ).format(money);
    }
</script>
@endsection