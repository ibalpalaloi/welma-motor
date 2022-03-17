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
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header bg-light">
                <h5>DAFTAR BARANG</h5>
                <div class="card-header-right">
                    <div class="card-option">
                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal_tambah_barang"><i class="feather icon-plus"></i> Tambah</button>
                    </div>
                </div>
            </div>
            
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-sm-4">
                        <input onchange="cari_barang()" id="input_cari_barang" type="text" class="bg-light form-control" placeholder="Cari Barang...">
                    </div>
                    <div class="col">
                        <button onclick="cari_barang()" class="btn btn-primary"><i class="feather icon-search"></i> Cari</button>
                    </div>
                </div>
                <table id="" style="font-size: 14px; width:100%;" class="display table table-striped table-bordered table-hover dt-responsive nowrap">
                    <thead>
                        <tr>
                            <th width="1%">No.</th>
                            <th>Barang</th>
                            <th>Tipe</th>
                            <th>Harga</th>
                            <th width="10%">Stok</th>
                            <th width="7%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="tbody_daftar_barang">
                        @foreach ($barang as $data)
                            <tr id="trow_barang{{$data->id}}">
                                <td>{{$loop->iteration}}.</td>
                                <td>
                                    {{ucwords($data->nama_barang)}}
                                    <br>
                                    <small><b>Kode : {{$data->kode_barang}}</b></small>

                                </td>
                     
                                <td style="white-space: normal;">
                                    {{$data->tipe_barang}}
                                    <br>
                                    <small><b>Merk : {{$data->merk}}</b></small>
                                </td>
                                <td>Rp. {{$data->harga}}
                                    <br>
                                    <small><b>Satuan : {{$data->satuan}}</b></small>
                                </td>
                                
                                <td id="tdata_jumlah_barang{{$data->id}}">
                                    @php
                                    if ($data->stok != null) {
                                        $stok = $data->stok->stok;
                                    } else {
                                        $stok = 0; 
                                    }
                                    @endphp
                                    <div @if (Auth()->user()->roles == "Admin") ondblclick="show_ubah_stok('{{$data->id}}')" @endif>
                                        <input class="form-control" type="number" id="stok{{$data->id}}" readonly
                                        value="{{$stok}}" style="cursor: pointer;">
                                    </div>
                
                                </td>
                                
                                <td>
                                    <button class="btn btn-sm btn-primary" onclick="modal_detail_barang('{{$data->id}}')"><i class="feather icon-grid"></i> Detail Barang </button>
                                    <div class="btn-group mr-2">
                                        <button class="btn btn-success dropdown-toggle btn-sm" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Lainnya</button>
                                        <div class="dropdown-menu">
                                            <a href="data:image/png;base64,{{DNS1D::getBarcodePNG($data->kode_barang, 'C128', 1 , 36 , array(0,0,0) , true)}}" download="{{ucwords($data->nama_barang)}}_{{$data->kode_barang}}" target="_blank" class="dropdown-item"><i class="feather icon-printer"></i> Barcode</a>
                                            @if (Auth()->user()->roles == "Admin")
                                            <a class="dropdown-item" href="javascript:void(0)" onclick="modal_ubah_barang('{{$data->id}}')"><i class="feather icon-edit"></i> Ubah Barang</a>
                                            <a class="dropdown-item" hhref="javascript:void(0)" onclick="hapus_barang('{{$data->id}}')" ><i class="feather icon-trash"></i> Hapus Barang</a>
                                            @endif
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

{{-- modal detail barang --}}
<div class="modal fade" id="modal_detail_barang" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h4 class="modal-title text-white">Detail Barang</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-10">
                            <div class="row">
                                <div class="col-sm-9">
                                    <div class="form-group">
                                        <label class="mb-0"><small class="text-danger">* </small>Kode Barang</label>
                                        <input type="text" class="pl-2 form-control" name="kode_barang" id="detail_kode_barang" placeholder="Kode Barang..." readonly>
                                    </div>
                                </div>
                            </div>
                      
                        </div>
              
                    </div>
                    <div class="row">
                        <div class="col-sm-9">
                            <div class="form-group">
                                <label class="mb-0"><small class="text-danger">* </small>Nama Barang</label>
                                <input type="text" class="pl-2 form-control" name="nama_barang" id="detail_nama_barang" readonly placeholder="Nama Barang...">
                            </div>
                        </div>
        
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="mb-0"><small class="text-danger">* </small>Merk</label>
                                <input type="text" class="pl-2 form-control" name="merk" id="detail_merk" readonly placeholder="Merk...">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="mb-0" ><small class="text-danger">* </small>Tipe</label>
                                <input type="text" class="pl-2 form-control" name="tipe_barang" id="detail_tipe_barang" readonly placeholder="Tipe...">
                            </div>
                        </div>
                        
                    </div>
                    <div class="row">

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="mb-0" ><small class="text-danger">* </small>Harga Jual</label>
                                <input type="number" class="pl-2 form-control" name="harga_jual" id="detail_harga_jual" readonly placeholder="Harga Jual...">
                            </div>
    
                        </div>
    
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="mb-0" ><small class="text-danger">* </small>Harga Modal</label>
                                <input type="number" class="pl-2 form-control" name="harga_modal" id="detail_harga_modal" readonly placeholder="Harga Modal...">
                            </div>
    
                        </div>
    
                    </div>
                    <div class="row">
                        <div class="col-sm-5">
                            <div class="form-group">
                                <label class="mb-0" ><small class="text-danger">* </small>Keterangan Satuan</label>
                                <input type="text" class="pl-2 form-control" name="keterangan_satuan" id="detail_keterangan_satuan" readonly placeholder="Keterangan Satuan...">
                            </div>
                        </div>
                    </div>
                
                </div>
                <div class="modal-footer p-2">
                    <button type="button" data-dismiss="modal" aria-label="Close" class="btn btn-danger btn-sm"><i class="feather icon-arrow-right"></i> Tutup</button>
                </div>

      

           
        </div>
    </div>
</div>



@if (Auth()->user()->roles == "Admin")
{{-- modal tambah barang --}}
<div class="modal fade" id="modal_tambah_barang" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h4 class="modal-title text-white">Tambah Barang</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{url()->current()}}/post-tambah-barang" method="post">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-10">
                            <div class="row">
                                <div class="col-sm-9">
                                    <div class="form-group">
                                        <label class="mb-0"><small class="text-danger">* </small>Kode Barang</label>
                                        <input type="text" id="tambah_barang_kode_barang" class="form-control" name="kode_barang" placeholder="Kode Barang..." required>
                                    </div>
                                </div>
                                <div class="col align-self-center">
                                    <button onclick="generate_code()" type="button" class="btn btn-block btn-sm btn-secondary"><i class="feather icon-loader"></i> Generate Kode</button>
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
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="mb-0"><small class="text-danger">* </small>Merk</label>
                                <input type="text" class="form-control" name="merk" required placeholder="Merk...">
                            </div>
                        </div>
                        <div class="col-sm-6">
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
                                <label class="mb-0" ><small class="text-danger">* </small>Harga Modal</label>
                                <input type="number" class="form-control" name="harga_modal" required placeholder="Harga Modal...">
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
                        <div class="col-sm-5">
                            <div class="form-group">
                                <label for="" class="mb-0"><small class="text-danger">* </small>Jenis</label>
                                <select name="jenis_barang" id="" class="form-control">
                                    <option value="barang">Barang</option>
                                    <option value="jasa">Jasa</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                
                </div>
                <div class="modal-footer p-2">
                    <button type="reset" class="btn btn-danger btn-sm"><i class="feather icon-refresh-ccw"></i> Reset</button>
                    <button type="submit" class="btn btn-primary btn-sm"><i class="feather icon-save"></i>  Simpan</button>
                </div>

            </form>

           
        </div>
    </div>
</div>

{{-- modal ubah barang --}}
<div class="modal fade" id="modal_ubah_barang" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h4 class="modal-title text-white">Ubah Barang</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{url()->current()}}/post-ubah-barang" method="post">
                @method('PUT')
                @csrf
                <input type="hidden" name="id_barang" id="ubah_id">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-10">
                            <div class="row">
                                <div class="col-sm-9">
                                    <div class="form-group">
                                        <label class="mb-0"><small class="text-danger">* </small>Kode Barang</label>
                                        <input type="text" class="form-control" name="kode_barang" id="ubah_kode_barang" placeholder="Kode Barang..." required>
                                    </div>
                                </div>
                                <div class="col align-self-center">
                                    <button type="button" class="btn btn-block btn-sm btn-secondary"><i class="feather icon-loader"></i> Generate Kode</button>
                                </div>
    
                            </div>
                      
                        </div>
              
                    </div>
                    <div class="row">
                        <div class="col-sm-9">
                            <div class="form-group">
                                <label class="mb-0"><small class="text-danger">* </small>Nama Barang</label>
                                <input type="text" class="form-control" name="nama_barang" id="ubah_nama_barang" required placeholder="Nama Barang...">
                            </div>
                        </div>
        
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="mb-0"><small class="text-danger">* </small>Merk</label>
                                <input type="text" class="form-control" name="merk" id="ubah_merk" required placeholder="Merk...">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="mb-0" ><small class="text-danger">* </small>Tipe</label>
                                <input type="text" class="form-control" name="tipe_barang" id="ubah_tipe_barang" required placeholder="Tipe...">
                            </div>
                        </div>
                        
                    </div>
                    <div class="row">

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="mb-0" ><small class="text-danger">* </small>Harga Jual</label>
                                <input type="number" class="form-control" name="harga_jual" id="ubah_harga_jual" required placeholder="Harga Jual...">
                            </div>
    
                        </div>
    
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="mb-0" ><small class="text-danger">* </small>Harga Modal</label>
                                <input type="number" class="form-control" name="harga_modal" id="ubah_harga_modal" required placeholder="Harga Modal...">
                            </div>
    
                        </div>
    
                    </div>
                    <div class="row">
                        <div class="col-sm-5">
                            <div class="form-group">
                                <label class="mb-0" ><small class="text-danger">* </small>Keterangan Satuan</label>
                                <input type="text" class="form-control" name="keterangan_satuan" id="ubah_keterangan_satuan" required placeholder="Keterangan Satuan...">
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="form-group">
                                <label for="" class="mb-0">Jenis</label>
                                <select name="jenis_barang" id="option_jenis_barang" class="form-control">
                                    <option value="barang">Barang</option>
                                    <option value="jasa">Jasa</option>
                                </select>
                            </div>
                        </div>
                    </div>
                
                </div>
                <div class="modal-footer p-2">
                    <button type="button" data-dismiss="modal" aria-label="Close" class="btn btn-danger btn-sm"><i class="feather icon-arrow-right"></i> Tutup</button>
                    <button type="submit" class="btn btn-primary btn-sm"><i class="feather icon-save"></i>  Simpan</button>
                </div>

            </form>

           
        </div>
    </div>
</div>
@endif



@endsection

@section('footer-scripts')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    @if (Auth()->user()->roles == "Admin")
    function generate_code(){
        $.ajax({
            type: "get",
            url: "{{url('/')}}/autocode_kode_barang",
            success:function(data){
                $('#tambah_barang_kode_barang').val(data.code);
            }
        })
    }

    function hapus_barang(id){
          swal({
             title: "Yakin Menghapus ?",
             text: "Data Yang Terhapus Tidak Dapat Dikembalikan !",
             icon: "warning",
             buttons: true,
             dangerMode: true,
           })
          .then((willDelete) => {
               if (willDelete) {
                $.ajax({
                    type: "GET",
                    url: "{{url()->current()}}/hapus-barang/"+id,
                    success:function(data){
                        $('#trow_barang'+id).remove();
                        toastr.success('Data Berhasil Terhapus', 'Berhasil', {timeOut: 5000})

                    }
                })
               } else {
                    swal("Hapus Data Dibatalkan", "Silahkan Klik Tombol Ok", "info");
           }
        });
        
    }

    function show_ubah_stok(id){
        var stok = parseInt($('#stok'+id).val());
        var html = "<input onkeydown='post_stok("+id+")' id='input_stok"+id+"' type='number' class='form-control' value='"+stok+"'>";
        $('#tdata_jumlah_barang'+id).html(html);
    }

    function post_stok(id){
        var stok = $('#input_stok'+id).val();
        if (event.keyCode === 13){
            $.ajax({
                type: "post",
                url: "{{url()->current()}}/post-stok-barang/"+id,
                data: {'stok': stok, 'id_barang':id},
                success:function(data){
                    console.log(data);

                    var html = '<div ondblclick="show_ubah_stok('+id+')"><input class="form-control" type="number" id="stok'+id+'" readonly style="cursor: pointer;" value="'+data.stok['stok']+'"></div>';
                    $('#tdata_jumlah_barang'+id).html(html);

                    toastr.success('Jumlah Pesanan Berhasil Diubah', 'Berhasil', {timeOut: 5000})
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
                var option = "";
                $('#ubah_id').val(id);
                $('#ubah_kode_barang').val(barang['kode_barang']);
                $('#ubah_nama_barang').val(barang['nama_barang']);
                $('#ubah_tipe_barang').val(barang['tipe_barang']);
                $('#ubah_keterangan_satuan').val(barang['satuan']);
                $('#ubah_harga_jual').val(barang['harga']);
                $('#ubah_harga_modal').val(barang['harga_beli']);
                $('#ubah_merk').val(barang['merk']);
                option += "<option value='barang'";
                if(barang['jenis'] == 'barang'){
                    option += "selected";
                }
                option += ">"+"barang"+"</option>"

                option += "<option value='jasa'";
                if(barang['jenis'] == 'jasa'){
                    option += "selected";
                }
                option += ">"+"jasa"+"</option>";

                $('#option_jenis_barang').html(option);
                $('#modal_ubah_barang').modal('show');
            }
        })
    }

    @endif

    function modal_detail_barang(id){
        $.ajax({
            type: "GET",
            url: "/get-barang/"+id,
            success:function(data){
                console.log(data)
                var detail_barang = data.barang;
                $('#detail_kode_barang').val(detail_barang['kode_barang']);
                $('#detail_nama_barang').val(detail_barang['nama_barang']);
                $('#detail_tipe_barang').val(detail_barang['tipe_barang']);
                $('#detail_keterangan_satuan').val(detail_barang['satuan']);
                $('#detail_harga_jual').val(detail_barang['harga']);
                $('#detail_harga_modal').val(detail_barang['harga_beli']);
                $('#detail_merk').val(detail_barang['merk']);
                $('#modal_detail_barang').modal('show');
            }
        })
    }

    $( "#input_cari_barang" ).change(function() {
        cari_barang();
    });

    function cari_barang(){
        var keyword = $('#input_cari_barang').val();
        ajax_cari_barang(keyword);
    }

    function ajax_cari_barang(keyword){
        $.ajax({
            type: 'GET',
            url: '?keyword='+keyword,
            success:function(data){
                console.log(data);
                $('#tbody_daftar_barang').html(data.view);
            }
        })
    }
</script>
@endsection