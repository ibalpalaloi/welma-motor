@extends('layouts.admin')


@section('title')
    
Daftar | Barang
@endsection

@section('header-scripts')
    
@endsection

@section('header-breadcumb')

Daftar | Barang

@endsection

@section('list-breadcumb')
<li class="breadcrumb-item active">Barang</li>
<li class="breadcrumb-item active">Daftar</li>

@endsection






@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header bg-light">
                <h5>DAFTAR BARANG</h5>
                <div class="card-header-right">
                    <div class="card-option">
                        <button onclick="modal_tambah_barang()" type="button" class="btn btn-sm btn-primary"><i class="feather icon-plus"></i> Tambah</button>
                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal_tambah_barang_new"><i class="feather icon-plus"></i> Tambah</button>

                    </div>
                    
                </div>
            </div>
            
            <div class="card-body">
                <table id="" style="font-size: 14px" class="table-datatables display table table-striped table-bordered table-hover dt-responsive nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th width="1%">No.</th>
                            <th>Nama Barang</th>
                            <th>Merk</th>
                            <th>Stok</th>
                            <th>Tipe</th>
                            <th>Harga</th>
                            <th>Satuan</th>
                            <th>Harga beli</th>
                            <th width="6%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($barang as $data)
                            <tr id="trow_barang{{$data->id}}">
                                <td>{{$loop->iteration}}.</td>
                                <td>
                                    {{ucwords($data->nama_barang)}}
                                    <br>
                                    <small><b>Kode : {{$data->kode_barang}}</b></small>

                                </td>
                                <td>{{$data->merk}}</td>
                                <td id="tdata_jumlah_barang{{$data->id}}">
                                    <a href="##" ondblclick="show_ubah_stok('{{$data->id}}')" id="stok{{$data->id}}">
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
                                <td>{{$data->harga_beli}}</td>
                                <td>

                                    <button class="btn btn-sm btn-primary"><i class="feather icon-grid"></i> Detail Barang </button>

                                    <div class="btn-group mr-2">
                                        <button class="btn btn-success dropdown-toggle btn-sm" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Lainnya</button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="#!" onclick="modal_ubah_barang('{{$data->id}}')"><i class="feather icon-edit"></i> Ubah Barang</a>
                                            <a class="dropdown-item" href="/barang/hapus-barang/{{$data->id}}"><i class="feather icon-trash"></i> Hapus Barang</a>
                                            <a class="dropdown-item" href="/barcode/{{$data->kode_barang}}" target="_blank"><i class="feather icon-printer"></i> Cetak Barcode</a>

                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                
            </div>
        </div>
    </div>
</div>


@endsection

@section('modal-content')
{{-- modal tambah barang --}}
<div class="modal" tabindex="-1" role="dialog" id="modal_tambah_barang">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Tambah Barang</h4>
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
                    <label for="exampleInputEmail1">Merk</label>
                    <input name="merk" type="text" class="form-control" id="" aria-describedby="emailHelp" placeholder="TIpe Barang">
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

{{-- modal ubah barang --}}
<div class="modal" tabindex="-1" role="dialog" id="modal_ubah_barang">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Ubah Barang</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form action="post-ubah-barang" method="POST">
                @csrf
                <input type="text" id="ubah_id" name="id_barang" hidden>
                <div class="form-group">
                  <label for="exampleInputEmail1">Kode Barang</label>
                  <input name="kode_barang" type="text" class="form-control" id="ubah_kode_barang" aria-describedby="emailHelp" placeholder="Kode Barang">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Nama Barang</label>
                    <input name="nama_barang" type="text" class="form-control" id="ubah_nama_barang" aria-describedby="emailHelp" placeholder="Nama Barang">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Tipe Barang</label>
                    <input name="tipe_barang" type="text" class="form-control" id="ubah_tipe_barang" aria-describedby="emailHelp" placeholder="TIpe Barang">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Merk</label>
                    <input name="merk" type="text" class="form-control" id="ubah_merk" aria-describedby="emailHelp" placeholder="TIpe Barang">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Satuan</label>
                    <input name="satuan" type="text" class="form-control" id="ubah_satuan" aria-describedby="emailHelp" placeholder="Satuan">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Harga</label>
                    <input name="harga" type="text" class="form-control" id="ubah_harga" aria-describedby="emailHelp" placeholder="Harga">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Harga Beli</label>
                    <input name="harga_beli" type="text" class="form-control" id="ubah_harga_beli" aria-describedby="emailHelp" placeholder="Laba">
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

<div class="modal fade" id="modal_tambah_barang_new" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h4 class="modal-title text-white">Tambah Barang</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>


            <form action="" method="post">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-10">
                            <div class="row">
                                <div class="col-sm-9">
                                    <div class="form-group">
                                        <label class="mb-0"><small class="text-danger">* </small>Kode Barang</label>
                                        <input type="text" class="form-control" name="kode_barang" placeholder="Kode Barang..." required>
                                    </div>
                                </div>
                                <div class="col align-self-center">
                                    <button class="btn btn-block btn-sm btn-secondary"><i class="feather icon-loader"></i> Generate Kode</button>
                                </div>
    
                            </div>
                      
                        </div>
              
                    </div>
                    <div class="row">
                        <div class="col-sm-9">
                            <div class="form-group">
                                <label class="mb-0"><small class="text-danger">* </small>Nama Barang</label>
                                <input type="text" class="form-control" name="nama_barang" required placeholder="Nama Barang...">
                            </div>
                        </div>
        
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="mb-0"><small class="text-danger">* </small>Merk</label>
                                <input type="text" class="form-control" name="merk" required placeholder="Merk...">
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="form-group">
                                <label class="mb-0" ><small class="text-danger">* </small>Tipe</label>
                                <input type="text" class="form-control" name="tipe_barang" required placeholder="Tipe...">
                            </div>
                        </div>
                        
                    </div>
                    <div class="row">
                  
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="mb-0" ><small class="text-danger">* </small>Harga Jual</label>
                                <input type="number" class="form-control" name="harga_jual" required placeholder="Harga Jual...">
                            </div>
    
                        </div>
    
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="mb-0" ><small class="text-danger">* </small>Harga Beli</label>
                                <input type="number" class="form-control" name="harga_beli" required placeholder="Harga Beli...">
                            </div>
    
                        </div>
    
                    </div>
                    <div class="row">
                        <div class="col-sm-5">
                            <div class="form-group">
                                <label class="mb-0" ><small class="text-danger">* </small>Keterangan Satuan</label>
                                <input type="text" class="form-control" name="keterangan_satuan" required placeholder="Keterangan Satuan...">
                            </div>
                        </div>
                    </div>
                
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary"> Save </button>
                    <button class="btn btn-danger"> Clear </button>
                </div>

            </form>

           
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

    function modal_ubah_barang(id){
        $.ajax({
            type: "GET",
            url: "/get-barang/"+id,
            success:function(data){
                console.log(data)
                var barang = data.barang;
                $('#ubah_id').val(barang['id']);
                $('#ubah_kode_barang').val(barang['kode_barang']);
                $('#ubah_nama_barang').val(barang['nama_barang']);
                $('#ubah_tipe_barang').val(barang['tipe_barang']);
                $('#ubah_satuan').val(barang['satuan']);
                $('#ubah_harga').val(barang['harga']);
                $('#ubah_harga_beli').val(barang['harga_beli']);
                $('#ubah_merk').val(barang['merk']);
                $('#modal_ubah_barang').modal('show');
            }
        })
    }
</script>
@endsection