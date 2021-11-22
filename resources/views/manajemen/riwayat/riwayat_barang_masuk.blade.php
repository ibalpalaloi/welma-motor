@extends('layouts.admin')

@section('modal-content')



@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-8">
                        <h5>DAFTAR BARANG MASUK</h5>
                    </div>
                    <div class="col">
                        <label for="">Cari Barang</label>
                        <input onkeydown="cari_produk()" type="text" class="" style="width: 100%" id="keyword">
                    </div>
                </div>
                
            </div>
            
            <div class="card-body">
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
                    <tbody>
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
                <div>
                    
                </div>
            </div>
        </div>
    </div>
</div>


@endsection

@section('footer-scripts')
<script>
    function cari_produk(){
        var keyword = $('#keyword').val();
        if(event.keyCode === 13){
            if(keyword != ""){
                $.ajax({
                    type: "GET",
                    url: "/riwayat-barang-masuk?keyword="+keyword,
                    success:function(data){
                        
                    }
                })
            }
        }
    }
</script>
@endsection