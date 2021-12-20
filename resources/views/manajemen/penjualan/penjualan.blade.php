@extends('layouts.admin')

@section('header-script')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
@endsection

@section('modal-content')
<div class="modal fade bd-example-modal-sm" id="modal-tambah-nota" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
          <div class="modal-body">
                <form action="/post-tambah-nota" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="exampleInputEmail1">Nama Pembeli</label>
                        <input type="text" class="form-control" name="nama" id="nama" aria-describedby="emailHelp">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Status</label>
                        <select name="status" id="" class="form-control">
                            <option value="umum">Umum</option>
                            <option value="dinas">Dinas</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm">Tambah</button>
                </form>
          </div>
        
      </div>
    </div>
</div>

{{-- modal cari barang --}}
<div class="modal fade bd-example-modal-lg" id="modal-cari-barang" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-body">
            <div class="form-group">
                <label for="exampleInputEmail1">Cari barang</label>
                <input type="text" class="form-control" name="nama" id="cari_barang_input" aria-describedby="emailHelp">
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Nama Barang</th>
                        <th>Tipe</th>
                        <th>Satuan</th>
                        <th>harga</th>
                        <th>stok</th>
                    </tr>
                </thead>
                <tbody id="tbody_modal_cari_barang">

                </tbody>
            </table>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('content')
<div class="row">
    <div class="col-sm-9">
        <div class="card">
            <div class="card-body">
                <button type="button" onclick="modal_tambah_nota()" class="btn btn-primary btn-sm">Tambah</button>
                @isset($nota)
                    {{-- <a href="/checkout-nota/{{$nota->id}}" class="float-right btn btn-danger btn-sm ">Checkout</a> --}}
                    <a onclick="checkout('{{$nota->id}}')" href="#" class="float-right btn btn-danger btn-sm ">Checkout</a>
                @endisset
                <div class="row">
                    <div class="col">
                        <div class="form-group row">
                            <label for="staticEmail" class="col-sm-2 col-form-label">Nama</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="staticEmail" @isset($nota) value="{{$nota->nama_pembeli}}" @endisset >
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="staticEmail" class="col-sm-2 col-form-label">Status</label>
                            <div class="col-sm-10">
                                <input readonly type="text" class="form-control" id="staticEmail" @isset($nota) value="{{$nota->status}}" @endisset >
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputPassword" class="col-sm-2 col-form-label">Total Harga</label>
                            <div class="col-sm-10">
                                <input readonly id="total_pesanan" type="text" class="form-control" @isset($nota) value="{{$total_pesanan}}" @endisset >
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group row">
                            <label for="inputPassword" class="col-sm-2 col-form-label">Kode</label>
                            <div class="col-sm-10">
                                <input type="text" id="input_kode_barang" @empty($nota) readonly @endempty>
                                <i onclick="show_modal_cari_barang()" class="feather icon-search"></i>
                                <br>
                                <span style="color: red" id="tidak_ditemukan"></span>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <table class="table">
                        <thead>
                            <tr>
                                <th width="">Barang</th>
                                <th>Tipe</th>
                                <th>Merk</th>
                                <th >Harga</th>
                                <th >Jumlah</th>
                                <th >Total</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="tbody_daftar_nota">
                            @isset($nota)
                                @foreach ($nota->pesanan as $pesanan)
                                        <tr id="row_pesanan{{$pesanan->id}}">
                                            <td>{{$pesanan->barang->nama_barang}}</td>
                                            <td>{{$pesanan->barang->tipe_barang}}</td>
                                            <td>{{$pesanan->barang->merk}}</td>
                                            <td id="tdata_harga_satuan{{$pesanan->id}}" ondblclick="show_input_ubah_harga_satuan('{{$pesanan->id}}')">{{$pesanan->harga}}</td>
                                            <td id="tdata_nota{{$pesanan->id}}">
                                                <a href="##" ondblclick="show_input_ubah_jumlah_pesanan('{{$pesanan->id}}')" id="jumlah_pesanan{{$pesanan->id}}">{{$pesanan->jumlah}}</a>
                                            </td>
                                            <td id="tdata_total_sub_pesanan{{$pesanan->id}}">{{$pesanan->jumlah * $pesanan->harga}}</td>
                                            <td><button onclick="hapus_pesanan('{{$pesanan->id}}')">Hapus</button></td>
                                            
                                        </tr>
                                    
                                @endforeach
                            @endisset
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="card">
            <div class="card-body">
                <table border="1" width="100%">
                    @isset($nota)
                        <tr>
                            <td><b><a href="#" onclick="pilih_nama_pembeli('{{$nota->id}}')" style="color: black">{{$nota->nama_pembeli}}</a></b></td>
                            <td><b>{{$nota->tgl_nota}}</b></td>
                            <td>
                                <a href="/hapus_nota/{{$nota->id}}" class="btn btn-danger"><i class="feather mr-2 icon-trash"></i></a>
                            </td> 
                        </tr>
                    @endisset
                    
                    @foreach ($list_nota as $data_nota)
                        <tr>
                            <td><a href="#" onclick="pilih_nama_pembeli('{{$data_nota->id}}')" style="color: black">{{$data_nota->nama_pembeli}}</a></td>
                            <td>{{$data_nota->tgl_nota}}</td>
                            <td>
                                <a href="/hapus_nota/{{$data_nota->id}}" class="btn btn-danger"><i class="feather mr-2 icon-trash"></i></a>
                            </td> 
                        </tr>
                        
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</div>

@endsection

@section('footer-scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

@include('manajemen.penjualan.penjualan_script')
@endsection