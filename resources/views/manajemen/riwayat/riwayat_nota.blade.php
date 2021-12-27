@extends('layouts.admin')



@section('title')
Riwayat Pesanan | Riwayat
@endsection


@section('header-breadcumb')

Riwayat Pesanan | Riwayat

@endsection

@section('list-breadcumb')
<li class="breadcrumb-item active">Riwayat</li>
<li class="breadcrumb-item active">Riwayat Pesanan</li>
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
    .plus-button {
        display: flex;
        justify-content: center;
        align-items: center;
        border: 2px solid lightgrey;
        background-color: #fff;
        font-size: 16px;
        height: 2.5em;
        width: 2.5em;
        border-radius: 999px;
        position: relative;
        
        &:after,
        &:before {
            content: "";
            background-color: grey;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
        
        &:before {
            height: 1em;
            width: 0.2em;
        }

        &:after {
            height: 0.2em;
            width: 1em;
        }
    }

    .plus-button--small {
        font-size: 12px;
    }

    .plus-button--large {
        font-size: 22px;
    }
</style>   
@endsection

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header bg-light">
                <h5>DAFTAR NOTA</h5>
        
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-2">
                        <label for=""><strong>PILIH TANGGAL : </strong></label>
                        <div class="row">
                            <div class="col-sm-5">
                                <input class="form-control" type="date" id='keyword_tgl'>
                            </div>
                            <div class="col-sm-7">
                                <button class="btn btn-success p-2" onclick="cari_nota_tgl()"><i class="feather icon-calendar"></i> Cari</button>
                            </div>
                        </div>
                        
                    </div>
                    <div class="col-md-12">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Pembeli</th>
                                    <th>Status Pesanan</th>
                                    <th>Tanggal Pesanan</th>
                                    <th>Total Pemebelian</th>
                                    <th>Pembuat Nota</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="tbody_data_nota">
                                @foreach ($data_riwayat_nota as $data)
                                    <tr>
                                        <td>{{$data['nama_pembeli']}}</td>
                                        <td>{{$data['status']}}</td>
                                        <td>
                                            {{ tgl_indo(date('Y-m-d', strtotime($data['tgl_nota']))) }}
                                        </td>
                                        <td>Rp. {{$data['total_harga']}}</td>
                                        <td>{{$data['nama_admin']}}</td>
                                        <td>
                                            <a target="blank" href="{{url('/')}}/nota/{{$data['id']}}" class="btn btn-primary btn-sm"><i class="feather icon-bookmark"></i> Lihat Nota</a>
                                            <a href="{{url('/')}}/batalkan_checkout/{{$data['id']}}" class="btn btn-danger btn-sm"><i class="feather icon-rotate-ccw"></i> Batal Checkout</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div id="button_load_more" class="row justify-content-center">
                            <button onclick="load_data()" class="plus-button">+</button>
                        </div>

                    </div>
                </div>

        
              
                
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer-scripts')
<script>
    var page = 2

    function load_data(){
        $.ajax({
            type: "GET",
            url: "{{url('/')}}/load-riwayat-nota?page="+page,
            success:function(data){
                console.log(data);
                console.log(page);
                page = page+1;
                $('#tbody_data_nota').append(data.view);
            }
        })
    }

    function cari_nota_tgl(){
        var tgl = $('#keyword_tgl').val();
        $.ajax({
            type: "GET",
            url: "{{url('/')}}/riwayat-nota-tgl?tgl="+tgl,
            success:function(data){
                $('#tbody_data_nota').empty();
                $('#tbody_data_nota').html(data.view);
                $('#button_load_more').empty();
            }
        })
    }

</script>  
@endsection