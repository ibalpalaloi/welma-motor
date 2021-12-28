@extends('layouts.admin')

@section('title')
Supplier
@endsection

@section('header-scripts')
    
@endsection

@section('header-breadcumb')
Supplier
@endsection

@section('list-breadcumb')
<li class="breadcrumb-item active">Supplier</li>
    
@endsection


@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header bg-light">
                <h5>DAFTAR SUPPLIER</h5>
                <div class="card-header-right">
                    <div class="card-option">
                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal_tambah_supplier"><i class="feather icon-plus"></i> Tambah</button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table id="" class="table-datatables display table table-striped table-bordered table-hover dt-responsive nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Supplier</th>
                            <th>Kontak (Nomor Telepon/HP)</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($supplier as $data)
                            <tr>
                                <td>{{$loop->iteration}}.</td>
                                <td>{{$data->nama_supplier}}</td>
                                <td>{{$data->kontak}}</td>
                                <td>{{$data->keterangan}}</td>
                                <td>
                                    <button onclick="ubah_supplier('{{$data->id}}', '{{$data->nama_supplier}}', '{{$data->kontak}}', '{{$data->keterangan}}')" type="button" class="btn btn-primary btn-sm"> <i class="feather icon-edit"></i> Ubah Supplier</button>
                                    <button onclick="hapus_supplier('{{$data->id}}')" type="button" class="btn btn-danger btn-sm"><i class="feather icon-trash"></i> Hapus Supplier</button>
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

<div class="modal fade" id="modal_ubah_supplier" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header bg-primary">
            <h4 class="modal-title text-white">Ubah Supplier</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form action="{{url('/manajemen/supplier')}}/post-ubah-supplier" method="POST">
                @csrf
                    <input type="hidden" id="id_supplier" name="id_supplier">
                    <div class="row">
                        <div class="col-sm-10">
                            <div class="form-group">
                                <label class="mb-0"><small class="text-danger">* </small>Nama Supplier</label>
                                <input type="text" class="form-control" name="nama_supplier_ubah" id="nama_supplier_ubah"  required placeholder="Nama Supplier...">
                            </div>
                      
                        </div>
              
                    </div>
                    <div class="row">
                        <div class="col-sm-10">
                            <div class="form-group">
                                <label class="mb-0"><small class="text-danger">* </small>Kontak <small>(Nomor Telepon/HP)</small></label>
                                <input type="text" class="form-control" name="kontak_supplier_ubah" id="kontak_supplier_ubah" required placeholder="Nama Pengguna...">
                            </div>
                        </div>
        
                    </div>
                    <div class="row">
                        <div class="col-sm-10">
                            <div class="form-group">
                                <label class="mb-0"><small class="text-danger">* </small>Keterangan Supplier</label>
                                <textarea name="keterangan_supplier_ubah" class="form-control" id="keterangan_supplier_ubah" rows="3"></textarea>
                            </div>
                        </div>
        
                    </div>
            
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="feather icon-refresh-ccw"></i> Batal</button>
                <button type="submit" class="btn btn-primary btn-sm"><i class="feather icon-save"></i>  Simpan</button>
            </div>
        </form>
      </div>
    </div>
</div>

{{-- modal tambah supplier --}}
<div class="modal fade" id="modal_tambah_supplier" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h4 class="modal-title text-white">Tambah Supplier</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{url('/manajemen/supplier')}}/post-tambah-supplier" method="post">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-10">
                            <div class="form-group">
                                <label class="mb-0"><small class="text-danger">* </small>Nama Supplier</label>
                                <input type="text" class="form-control" name="nama_supplier" id="nama_supplier"  required placeholder="Nama Supplier...">
                            </div>
                      
                        </div>
              
                    </div>
                    <div class="row">
                        <div class="col-sm-10">
                            <div class="form-group">
                                <label class="mb-0"><small class="text-danger">* </small>Kontak <small>(Nomor Telepon/HP)</small></label>
                                <input type="text" class="form-control" name="kontak_supplier" id="kontak_supplier" required placeholder="Nama Pengguna...">
                            </div>
                        </div>
        
                    </div>
                    <div class="row">
                        <div class="col-sm-10">
                            <div class="form-group">
                                <label class="mb-0"><small class="text-danger">* </small>Keterangan Supplier</label>
                                <textarea name="keterangan_supplier" class="form-control" id="keterangan_supplier" rows="3"></textarea>
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

@endsection

@section('footer-scripts')
<script>
    function ubah_supplier(id, nama, kontak, keterangan){
        $('#id_supplier').val(id);
        $('#nama_supplier_ubah').val(nama);
        $('#kontak_supplier_ubah').val(kontak);
        $('#keterangan_supplier_ubah').val(keterangan);
        $('#modal_ubah_supplier').modal('show');
    }

    function hapus_supplier(id){
          swal({
             title: "Yakin Menghapus ?",
             text: "Data Yang Terhapus Tidak Dapat Dikembalikan !",
             icon: "warning",
             buttons: true,
             dangerMode: true,
           })
          .then((willDelete) => {
               if (willDelete) {
                    window.location.href = "{{url('/manajemen/supplier')}}/hapus-supplier/"+id;

                    
               } 
               else {
                    swal("Hapus Data Dibatalkan", "Silahkan Klik Tombol Ok", "info");
                }
        });
        
    }
</script> 
@endsection