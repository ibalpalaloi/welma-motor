@extends('layouts.admin')

@section('header-scripts')
<meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('content')

{{-- modal --}}
<div class="modal" tabindex="-1" role="dialog" id="modal_tambah_barang_masuk">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Barang Masuk</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <input type="text" id="tambah_barang_masuk_id_barang" hidden>
            <div class="form-group">
                <label for="exampleInputEmail1">Nama Barang</label>
                <input readonly type="text"  class="form-control" id="tambah_barang_masuk_nama_barang">
            </div>
            <div class="form-group">
                <label for="exampleFormControlSelect1">Supplier</label>
                <select class="form-control" id="tambah_barang_masuk_nama_supplier">
                  @foreach ($supplier as $data)
                      <option value="{{$data->id}}">{{$data->nama_supplier}}</option>
                  @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Tgl Masuk</label>
                <input type="date"  class="form-control" id="tambah_barang_masuk_tgl_masuk" >
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Jumlah</label>
                <input type="number"  class="form-control" id="tambah_barang_masuk_jumlah" >
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" onclick="post_barang_masuk()">Simpam</button>
        </div>
      </div>
    </div>
</div>



<div class="row">
    <div class="col-sm-6">
        <div class="card">
            <div class="card-header">
                <h4>Barang Masuk</h4>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="exampleInputEmail1">Cari Produk</label>
                    <input type="text" class="form-control" id="cari_produk_input" aria-describedby="emailHelp" placeholder="Kode/Nama Barang">
                </div>
                <hr>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Nama</th>
                        </tr>
                    </thead>
                    <tbody id="tbody_daftar_barang">

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="card">
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Barang</th>
                            <th>Supplier</th>
                            <th>Jumlah</th>
                            <th>Tgl Masuk</th>
                        </tr>
                    </thead>
                    <tbody id="tbody_list_barang_masuk">
                        @foreach ($barang_masuk as $data)
                            <tr>
                                <td>{{$data->barang->nama_barang}}</td>
                                <td>{{$data->supplier->nama_supplier}}</td>
                                <td>{{$data->jumlah_barang}}</td>
                                <td>{{$data->tgl_masuk}}</td>
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

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#cari_produk_input').on('input', function(){
        var keyword = $('#cari_produk_input').val();
        get_list_produk(keyword);
    });

    function get_list_produk(keyword){
        $.ajax({
            type: "get",
            url: "/penerimaan-barang/get-daftar-barang?keyword="+keyword,
            success:function(data){
                $('#tbody_daftar_barang').html(data.view);
            }
        })
    }

    function modal_tambah_barang_masuk(nama_barang, id_barang){
        $('#tambah_barang_masuk_nama_barang').val(nama_barang);
        $('#tambah_barang_masuk_id_barang').val(id_barang);
        $('#modal_tambah_barang_masuk').modal('show');
    }

    function post_barang_masuk(){
        var id_barang = $('#tambah_barang_masuk_id_barang').val();
        var nama_barang = $('#tambah_barang_masuk_nama_barang').val();
        var id_supplier = $('#tambah_barang_masuk_nama_supplier option:selected').val();
        var jumlah = $('#tambah_barang_masuk_jumlah').val();
        var tgl_masuk = $('#tambah_barang_masuk_tgl_masuk').val();
        
        $.ajax({
            type : "POST",
            url: "/barang-masuk/post-barang-masuk",
            data: {'id_barang':id_barang, 'id_supplier':id_supplier, 'jumlah':jumlah, 'tgl_masuk':tgl_masuk},
            success:function(data){
                $('#modal_tambah_barang_masuk').modal('hide');
                $('#tambah_barang_masuk_jumlah').val("");
                $('#tambah_barang_masuk_tgl_masuk').val("");
                get_tabel_list_barang_masuk();
            }
        })
    }

    function get_tabel_list_barang_masuk(){
        $.ajax({
            type: "GET",
            url: "/barang-masuk/get_list_barang_masuk",
            success:function(data){
                $('#tbody_list_barang_masuk').html(data.view);
            }
        })
    }
</script>
@endsection