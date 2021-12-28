@extends('layouts.admin')

@section('title')
    
Penjualan
@endsection

@section('header-scripts')
    
@endsection

@section('header-breadcumb')

Penjualan

@endsection

@section('list-breadcumb')
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


@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-light">
                <h5>DAFTAR NOTA</h5>
                <div class="card-header-right">
                    <div class="card-option">
                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-tambah-nota"><i class="feather icon-plus"></i> Tambah Nota</button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table width="100%" class="table-datatables table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Tanggal Nota</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    @isset($nota)
                        <tr class="font-weight-bold">
                            <td><b><a href="#" onclick="pilih_nama_pembeli('{{$nota->id}}')" style="color: black">{{$nota->nama_pembeli}}</a></b></td>
                            <td><b>
                                {{ tgl_indo(date('Y-m-d', strtotime($nota->tgl_nota))) }}
                            </b></td>
                            <td>
                                <button class="btn btn-danger btn-sm" onclick="hapus_nota('{{$nota->id}}')"><i class="feather mr-2 icon-trash"></i>Hapus</button>
                            </td> 
                        </tr>
                    @endisset
                    
                    @foreach ($list_nota as $data_nota)
                        <tr>
                            <td><a href="#" onclick="" style="color: black">{{$data_nota->nama_pembeli}}</a></td>
                            <td>{{ tgl_indo(date('Y-m-d', strtotime($data_nota->tgl_nota))) }}</td>
                            <td>
                                <button class="btn btn-success btn-sm" onclick="pilih_nama_pembeli('{{$data_nota->id}}')"><i class="feather icon-check-square mr-2"></i>Pilih</button>
                                <button class="btn btn-danger btn-sm" onclick="hapus_nota('{{$data_nota->id}}')"><i class="feather mr-2 icon-trash"></i>Hapus</button>
                            </td> 
                        </tr>
                        
                    @endforeach
                    </tbody>
                   
                </table>
            </div>
        </div>
    </div>
    @isset($nota)
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-light">
                <h5>DETAIL NOTA</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12">
                        <h5 class="float-right">Tanggal Nota : {{ tgl_indo(date('Y-m-d', strtotime($nota->tgl_nota))) }}</h5>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Nama</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control pl-2" readonly @isset($nota) value="{{$nota->nama_pembeli}}" @endisset >
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Status</label>
                            <div class="col-sm-9">
                                <input readonly type="text" class="form-control pl-2"  @isset($nota) value="{{ucwords($nota->status)}}" @endisset >
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Total Harga</label>
                            <div class="col-sm-9">
                                <input readonly id="total_pesanan" type="text" class="form-control pl-2" @isset($nota) value="Rp. {{$total_pesanan}}" @endisset >
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        @isset($nota)
                        <a onclick="checkout('{{$nota->id}}')" href="#" class="float-right btn btn-primary btn-sm "><i class="feather icon-printer"></i> Checkout</a>
                        @endisset
                    </div>
                </div>
               
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group row">
                            <div class="col">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <input type="text" id="input_kode_barang" class="form-control" placeholder="Kode Barang..." @empty($nota) readonly @endempty>
                                        <span style="color: red" id="tidak_ditemukan"></span>
                                    </div>
                                    <div class="col-sm-12 mt-2">
                                        <button class="btn btn-sm btn-primary" onclick="show_modal_cari_barang()"><i class="feather icon-search"></i> Cari Barang</button>

                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th width="">Barang</th>
                                    <th>Tipe</th>
                                    <th>Harga</th>
                                    <th>Jumlah</th>
                                    <th>Total</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="tbody_daftar_nota">
                                @isset($nota)
                                    @include('manajemen.penjualan.data_list_penjualan')
                                @endisset
                            </tbody>
                        </table>
                    </div>
                 
                </div>
            </div>
        </div>
    </div>
    @endisset
 
</div>

@endsection

@section('modal-content')
<div class="modal fade bd-example-modal-sm" id="modal-tambah-nota" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog ">
  
      <div class="modal-content">
            <div class="modal-header bg-primary">
                <h4 class="modal-title text-white">Tambah Nota</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{url()->current()}}/post-tambah-nota" method="post">
            @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Pembeli</label>
                        <input type="text" class="form-control" name="nama" id="nama" placeholder="Pembeli..." required>
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" id="" class="form-control" required>
                            <option value="umum">Umum</option>
                            <option value="dinas">Dinas</option>
                        </select>
                    </div>
           
                </div>
                <div class="modal-footer p-2">
                    <button type="reset" data-dismiss="modal" aria-label="Close" class="btn btn-danger btn-sm"><i class="feather icon-refresh-ccw"></i> Reset</button>
                    <button type="submit" class="btn btn-primary btn-sm"><i class="feather icon-save"></i>  Simpan</button>
                </div>
            </form>

        
      </div>
    </div>
</div>

{{-- modal cari barang --}}
<div class="modal fade bd-example-modal-lg" id="modal-cari-barang" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header bg-primary">
            <h4 class="modal-title text-white">Cari Barang</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <input type="text" class="form-control" name="nama" id="cari_barang_input" placeholder="Kode / Nama Barang...">
            </div>
            <table class="table table-striped table-bordered table-hover">
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


@section('footer-scripts')

<script>
    function hapus_nota(id){
          swal({
             title: "Yakin Menghapus ?",
             text: "Data Yang Terhapus Tidak Dapat Dikembalikan !",
             icon: "warning",
             buttons: true,
             dangerMode: true,
           })
          .then((willDelete) => {
               if (willDelete) {
                    window.location.href = "{{url('/')}}/hapus_nota/"+id;
               } 
               else {
                    swal("Hapus Data Dibatalkan", "Silahkan Klik Tombol Ok", "info");
                }
        });
        
    }
</script>

@include('manajemen.penjualan.penjualan_script')
@endsection