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
            </div>
            <div class="card-body">
                <div id="div-filter-nota">
                    <label for="">Pilih Tanggal</label>
                    <input type='date' onkeyup='cari_produk_tgl()' id='keyword_tgl'>
                </div>
                <br><br>
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
                    <tbody id="tbody_data_nota">
                        @foreach ($data_riwayat_nota as $data)
                            <tr>
                                <td>{{$data['nama_pembeli']}}</td>
                                <td>{{$data['tgl_nota']}}</td>
                                <td>Rp. {{$data['total_harga']}}</td>
                                <td>{{$data['nama_admin']}}</td>
                                <td>
                                    <a target="blank" href="/nota/{{$data['id']}}" class="btn btn-primary">Cek Detail</a>
                                    <a href="/batalkan_checkout/{{$data['id']}}" class="btn btn-danger">Batal Checkout</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <button onclick="load_data()" class="plus-button">+</button>
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
            url: "/load-riwayat-nota?page="+page,
            success:function(data){
                console.log(data);
                console.log(page);
                page = page+1;
                $('#tbody_data_nota').append(data.view);
            }
        })
    }

    function berdasarkan_nama(){
        var html = "<label for='' >Cari Produk</label>";
        html += "<input type='text' onkeyup='cari_produk_nama()' id='keyword_nama'>";
        $('#div-filter-nota').html(html);
    }

    function berdasarkan_tgl(){
        var html = "<label for=''>Cari Produk</label>";
        html += "<input type='date' onkeyup='cari_produk_tgl()' id='keyword_tgl'>";
        $('#div-filter-nota').html(html);
    }
</script>  
@endsection