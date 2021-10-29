@extends('layouts.admin')

@section('modal-content')
<div class="modal" tabindex="-1" role="dialog" id="modal_tambah_barang">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Barang</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form action="post-tambah-barang" method="POST">
                @csrf
                <div class="form-group">
                  <label for="exampleInputEmail1">Kode Barang</label>
                  <input name="kode_barang" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Kode Barang">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Nama Barang</label>
                    <input name="nama_barang" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Nama Barang">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Tipe Barang</label>
                    <input name="tipe_barang" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="TIpe Barang">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Satuan</label>
                    <input name="satuan" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Satuan">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Harga</label>
                    <input name="harga" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Harga">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Laba</label>
                    <input name="laba" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Laba">
                </div>
            
            </div>
            <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Save changes</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </form>
      </div>
    </div>
</div>
@endsection



@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-10">
                        <h5>DAFTAR BARANG</h5>
                    </div>
                    <div class="col">
                        <button onclick="modal_tambah_barang()" type="button" class="btn btn-primary"><i class="feather mr-2 icon-plus"></i>Tambah</button>
                    </div>
                </div>
                
            </div>
            
            <div class="card-body">
                <table id="" style="font-size: 14px" class="table-datatables display table table-striped table-bordered table-hover dt-responsive nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th>Kode Barang</th>
                            <th>Nama</th>
                            <th>Stok</th>
                            <th>Tipe</th>
                            <th>Harga</th>
                            <th>Satuan</th>
                            <th>Laba</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($barang as $data)
                            <tr id="trow_barang{{$data->id}}">
                                <td>{{$data->kode_barang}}</td>
                                <td>{{$data->nama_barang}}</td>
                                <td id="tdata_jumlah_barang{{$data->id}}">
                                    <a href="#" ondblclick="show_ubah_stok('{{$data->id}}')" id="stok{{$data->id}}">
                                        @if ($data->stok != null)
                                            {{$data->stok->stok}}
                                        @else
                                            0
                                        @endif
                                    </a>
                                </td>
                                <td>{{$data->tipe_barang}}</td>
                                <td>{{$data->harga}}</td>
                                <td>{{$data->satuan}}</td>
                                <td>{{$data->laba}}</td>
                                <th>
                                    <a href="/barang/hapus-barang/{{$data->id}}" class="btn btn-danger btn-sm">.</a>
                                </th>
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

    function modal_tambah_barang(){
        $('#modal_tambah_barang').modal('show');
    }

    function hapus_barang(id){
        $.ajax({
            type: "GET",
            url: "/barang/hapus-barang/"+id,
            success:function(data){
                $('#trow_barang'+id).remove();
            }
        })
    }

    function show_ubah_stok(id){
        var stok = parseInt($('#stok'+id).html());
        var html = "<input onkeydown='post_stok("+id+")' id='input_stok"+id+"' type='number' value='"+stok+"'>";
        $('#tdata_jumlah_barang'+id).html(html);
    }

    function post_stok(id){
        var stok = $('#input_stok'+id).val();
        if (event.keyCode === 13){
            $.ajax({
                type: "post",
                url: "/post-stok-barang/"+id,
                data: {'stok': stok, 'id_barang':id},
                success:function(data){
                    console.log(data);
                    var html = "<a href='#' ondblclick='show_ubah_stok("+id+")' id='stok"+id+"'>"+data.stok['stok']+"</a>";
                    $('#tdata_jumlah_barang'+id).html(html);
                }
            })
        }
        
    }
</script>
@endsection