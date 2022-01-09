@extends('layouts.admin')

@section('title')
Riwayat Barang Masuk | Riwayat
@endsection


@section('header-breadcumb')

Riwayat Barang Masuk | Riwayat

@endsection

@section('list-breadcumb')
<li class="breadcrumb-item active">Riwayat</li>
<li class="breadcrumb-item active">Riwayat Barang Masuk</li>
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
            <div class="card-header">
                <h5>DAFTAR BARANG MASUK</h5>
             
            </div>
            
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 mb-3">

                        <div class="float-left">
                            <label for=""><strong>Cari Berdasarkan :</strong></label>
                            <select name="" id="" class="form-control" onchange="cari_berdasarkan(this)">
                                <option value="" selected >-- Berdasarkan --</option>
                                <option onclick="berdasarkan_nama()" value="nama_barang">Nama Barang</option>
                                <option onclick="berdasarkan_tgl()" value="tanggal">Tanggal</option>
                            </select>
                        </div>

                        <div id="div-filter-barang" class="float-right">
                    
    
                        </div>
                     
                    </div>
                    <div class="col-md-12">
                        <table id="" style="font-size: 14px" class="table table-striped table-bordered table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Nama Barang</th>
                                    <th>Tipe Barang</th>
                                    <th>Jumlah Barang</th>
                                    <th>Supplier</th>
                                    <th>Tanggal Masuk</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="tbody_data_barang_masuk">
                                @foreach ($daftar_barang as $data)
                                    <tr>
                                        <td>{{ucwords($data['nama_barang'])}}
                                            <br>
                                            <small><b>Kode : {{$data['kode_barang']}}</b></small>
                                        </td>
                                        <td>{{$data['tipe']}}
                                            <br>
                                            <small><b>Merk : {{$data['merk']}}</b></small>
                                        </td>
                                        <td>{{$data['jumlah']}}</td>
                                        <td> 
                                            {{$data['supplier']}}
                                        </td>
                                        <td>
                                            {{ tgl_indo(date('Y-m-d', strtotime($data['tgl_masuk']))) }}
                                        </td>
                                        <td><button class="btn btn-danger btn-sm" onclick="hapus_riwayat_barang_masuk('{{$data['id']}}')"><i class="feather icon-trash"></i> Hapus</button></td>

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
    var page =2;
    function load_data(){
        $.ajax({
            type: "GET",
            url: "?page="+page,
            success:function(data){
                $('#tbody_data_barang_masuk').append(data.html);
                page++;
            }
        })
    }

    function cari_produk_nama(){
        var keyword = $('#keyword_nama').val();
        if(event.keyCode === 13){
            if(keyword != ""){
                $.ajax({
                    type: "GET",
                    url: "{{url('/')}}/riwayat-barang-masuk-cari-nama-produk?keyword="+keyword,
                    success:function(data){
                        console.log(data);
                        $('#tbody_data_barang_masuk').html(data.html);
                        $('#button_load_more').empty();
                    }
                })
            }
        }
    }

    function cari_produk_tgl(){
        var keyword = $('#keyword_tgl').val();
        if(event.keyCode === 13){
            if(keyword != ""){
                $.ajax({
                    type: "GET",
                    url: "{{url('/')}}/riwayat-barang-masuk-cari-tgl-produk?keyword="+keyword,
                    success:function(data){
                        console.log(data);
                        $('#tbody_data_barang_masuk').html(data.html);
                        $('#button_load_more').empty();
                    }
                })
            }
        }
    }

    function cari_berdasarkan(value) {
       var val = value.value;

        if(val =="nama_barang")
        {
            berdasarkan_nama()
       
        }
        else if(val =="tanggal")
        {
            berdasarkan_tgl()
        }
        else{
            var html = '';
            $('#div-filter-barang').html(html);

        }

    }

    function berdasarkan_nama(){
        var html = "<label for='' ><strong>Nama Barang :  </strong></label>";
        html += "<input class='form-control' placeholder='Nama Barang...' type='text' onkeyup='cari_produk_nama()' id='keyword_nama'>";
        $('#div-filter-barang').html(html);
    }

    function berdasarkan_tgl(){
        var html = "<label for=''><strong>Tanggal : </strong></label>";
        html += "<input class='form-control' type='date' onkeyup='cari_produk_tgl()' id='keyword_tgl'>";
        $('#div-filter-barang').html(html);
    }

    function hapus_riwayat_barang_masuk(id){
          swal({
             title: "Yakin Menghapus ?",
             text: "Data Yang Terhapus Tidak Dapat Dikembalikan !",
             icon: "warning",
             buttons: true,
             dangerMode: true,
           })
          .then((willDelete) => {
               if (willDelete) {
                    window.location.href = "{{url('/')}}/riwayat-barang-masuk/hapus-riwayat/"+id;
                    
               } 
               else {
                    swal("Hapus Data Dibatalkan", "Silahkan Klik Tombol Ok", "info");
                }
        });
        
    }


</script>
@endsection