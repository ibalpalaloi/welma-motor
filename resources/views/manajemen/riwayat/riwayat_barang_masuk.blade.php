@extends('layouts.admin')

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
                <h5>Daftar Barang Masuk</h5>
                <div class="card-header-right">
                    <div class="btn-group card-option">
                        <button type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="feather icon-more-horizontal"></i>
                        </button>
                        <ul class="list-unstyled card-option dropdown-menu dropdown-menu-right">
                            <li class="dropdown-item" onclick="berdasarkan_nama()"><a href="#"><span><i ></i> Berdasarkan Nama</span><span style="display:none"><i class="feather icon-minimize"></i> Restore</span></a></li>
                            <li class="dropdown-item" onclick="berdasarkan_tgl()"><a href="#"><span><i ></i> Berdasarakan Tanggal</span><span style="display:none"><i class="feather icon-plus"></i> expand</span></a></li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="card-body">
                <div id="div-filter-barang">
                    
                    
                </div>
                <br><br>
                <table id="" style="font-size: 14px" class="table" style="width:100%">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Tipe</th>
                            <th>Merk</th>
                            <th>Jumlah</th>
                            <th>Tgl Masuk</th>
                        </tr>
                    </thead>
                    <tbody id="tbody_data_barang_masuk">
                        @foreach ($barang_masuk as $data)
                            <tr>
                                <td>{{$data->barang->nama_barang}}</td>
                                <td>{{$data->barang->tipe_barang}}</td>
                                <td>{{$data->merk}}</td>
                                <td>{{$data->jumlah_barang}}</td>
                                <td>{{$data->tgl_masuk}}</td>
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
                    url: "/riwayat-barang-masuk-cari-nama-produk?keyword="+keyword,
                    success:function(data){
                        console.log(data);
                        $('#tbody_data_barang_masuk').html(data.html);
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
                    url: "/riwayat-barang-masuk-cari-tgl-produk?keyword="+keyword,
                    success:function(data){
                        console.log(data);
                        $('#tbody_data_barang_masuk').html(data.html);
                    }
                })
            }
        }
    }

    function berdasarkan_nama(){
        var html = "<label for='' >Cari Produk</label>";
        html += "<input type='text' onkeyup='cari_produk_nama()' id='keyword_nama'>";
        $('#div-filter-barang').html(html);
    }

    function berdasarkan_tgl(){
        var html = "<label for=''>Cari Produk</label>";
        html += "<input type='date' onkeyup='cari_produk_tgl()' id='keyword_tgl'>";
        $('#div-filter-barang').html(html);
    }


</script>
@endsection