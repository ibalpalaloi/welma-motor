@extends('layouts.admin')


@section('title')
    
Penerimaan Barang | Barang
@endsection

@section('header-scripts')

<link rel="stylesheet" href="{{asset('assets/css/plugins/select2.min.css')}}">

<style>

    #tabel_daftar_barang_masuk td {
        white-space: normal !important; 
    }
</style>

@endsection

@section('header-breadcumb')

Penerimaan Barang | Barang

@endsection


@section('list-breadcumb')
<li class="breadcrumb-item active">Barang</li>
<li class="breadcrumb-item active">Penerimaan Barang</li>

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
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header bg-light">
                <h5>DAFTAR BARANG</h5>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="exampleInputEmail1"><strong>CARI BARANG : </strong></label>
                    <input type="text" class="form-control" id="cari_produk_input" placeholder="Kode / Nama Barang">
                </div>
                <hr>
                <table id="tabel_daftar_barang_masuk" class="table table-striped table-bordered table-hover dt-responsive nowrap">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>Tipe</th>
                            <th>Stok</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="tbody_daftar_barang">

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-12">
        <div class="card">
            <div class="card-header bg-light">
                <h5>RIWAYAT BARANG MASUK</h5>
            </div>
            <div class="card-body">
                <table class="table table-striped table-bordered table-hover dt-responsive nowrap">
                    <thead>
                        <tr>
                            <th>Barang</th>
                            <th>Tipe</th>
                            <th>Supplier</th>
                            <th>Jumlah Masuk</th>
                            <th>Tgl Masuk</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="tbody_list_barang_masuk">
                        @foreach ($barang_masuk as $data)
                            <tr>
                                <td>{{$data->barang->nama_barang}}
                                    <br>
                                    <small><b>Kode : {{$data->barang->kode_barang}}</b></small>
                                </td>
                                <td style="white-space: normal;">{{$data->barang->tipe_barang}}
                                    <br><small><b>Merk : {{$data->barang->merk}}</b></small>
                                </td>
                                <td>
                                    @if ($data->supplier)
                                        {{$data->supplier->nama_supplier}}</td>
                                    @else
                                        -
                                    @endif
                                    
                                <td>{{$data->jumlah_barang}}</td>
                                <td>
                                    {{ tgl_indo(date('Y-m-d', strtotime($data->tgl_masuk))) }}
                                </td>
                                <td><button class="btn btn-danger btn-sm" onclick="hapus_riwayat_barang_masuk('{{$data->id}}')"><i class="feather icon-trash"></i> Hapus</button></td>
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

{{-- modal --}}
<div class="modal" tabindex="-1" role="dialog" id="modal_tambah_barang_masuk">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header bg-primary">
          <h4 class="modal-title text-white">TAMBAH BARANG MASUK</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <input type="text" id="tambah_barang_masuk_id_barang" hidden>
            <div class="form-group">
                <label for="exampleInputEmail1">Nama Barang</label>
                <input readonly type="text" class="pl-2 form-control" id="tambah_barang_masuk_nama_barang" required>
            </div>
            <div class="row">
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Merk</label>
                        <input readonly type="text" class="pl-2 form-control" id="tambah_barang_masuk_merk" required>
                    </div>
                </div>
                <div class="col-sm-9">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Tipe Barang</label>
                        <input readonly type="text" class="pl-2 form-control" id="tambah_barang_masuk_tipe" required>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-sm-7">
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <label for="exampleFormControlSelect1">Supplier</label>
                        </div>
                        <div class="col-sm-12">
                            <select class="select2 form-control py-2" id="tambah_barang_masuk_nama_supplier" style="width: 100%" required>
                                @foreach ($supplier as $data)
                                    <option value="{{$data->id}}">{{$data->nama_supplier}}</option>
                                @endforeach
                              </select>
                        </div>
                    </div>
                </div>
                <div class="col-sm-5">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Tanggal Masuk</label>
                        <input type="date" class="form-control" id="tambah_barang_masuk_tgl_masuk" required>
                    </div>
                </div>
               
        
            </div>
            <div class="row">
                <div class="col-sm-5">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Jumlah</label>
                        <input type="number" class="form-control" id="tambah_barang_masuk_jumlah" placeholder="Jumlah Barang..." required>
                    </div>
                </div>
            </div>
            
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary btn-sm" onclick="post_barang_masuk()">Simpan</button>
        </div>
      </div>
    </div>
</div>

@endsection

@section('footer-scripts')
<script src="{{asset('assets/js/plugins/select2.full.min.js')}}"></script>

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
            url: "{{url()->current()}}/get-daftar-barang?keyword="+keyword,
            success:function(data){
                $('#tbody_daftar_barang').html(data.view);
            }
        })
    }

    function modal_tambah_barang_masuk(nama_barang, merk_barang, tipe_barang, id_barang){
        $('#tambah_barang_masuk_nama_barang').val(nama_barang);
        $('#tambah_barang_masuk_merk').val(merk_barang);
        $('#tambah_barang_masuk_tipe').val(tipe_barang);
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
            url: "{{url()->current()}}/post-barang-masuk",
            data: {'id_barang':id_barang, 'id_supplier':id_supplier, 'jumlah':jumlah, 'tgl_masuk':tgl_masuk},
            success:function(data){
                $('#modal_tambah_barang_masuk').modal('hide');
                $('#tambah_barang_masuk_jumlah').val("");
                $('#tambah_barang_masuk_tgl_masuk').val("");
                get_tabel_list_barang_masuk();
                $('#cari_produk_input').val('');
                $('#tbody_daftar_barang').empty();
                toastr.success('Stok Berhasil Ditambahkan', 'Berhasil', {timeOut: 5000})

            }
        })
    }

    function get_tabel_list_barang_masuk(){
        $.ajax({
            type: "GET",
            url: "{{url()->current()}}/get-list-barang-masuk",
            success:function(data){
                $('#tbody_list_barang_masuk').html(data.view);
            }
        })
    }

    $(document).ready(function() {
    

        $(".select2").select2({
            dropdownParent: $('#modal_tambah_barang_masuk')
        });

    });

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