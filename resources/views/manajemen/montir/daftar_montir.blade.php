@extends('layouts.admin')

@section('title')
Montir
@endsection

@section('header-scripts')
    
@endsection

@section('header-breadcumb')
Montir
@endsection

@section('list-breadcumb')
<li class="breadcrumb-item active">Montir</li>
    
@endsection


@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header bg-light">
                <h5>DAFTAR MONTIR</h5>
                <div class="card-header-right">
                    <div class="card-option">
                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal_tambah_montir"><i class="feather icon-plus"></i> Tambah</button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table id="" class="table-datatables display table table-striped table-bordered table-hover dt-responsive nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama Montir</th>
                            <th>Keterangan</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($montir as $data)
                            <tr>
                                <td>{{$loop->iteration}}.</td>
                                <td>{{$data->nama}}</td>
                                <td>{{$data->keterangan}}</td>
                                <td>
                                    <button onclick="hapus_montir('{{$data->id}}')" type="button" class="btn btn-danger btn-sm"><i class="feather icon-trash"></i> Hapus</button>
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

{{-- modal tambah montir --}}
<div class="modal fade" id="modal_tambah_montir" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h4 class="modal-title text-white">Tambah Montir</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{url('/')}}/manajemen/montir/post-tambah-montir" method="post">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-10">
                            <div class="form-group">
                                <label class="mb-0"><small class="text-danger">* </small>Nama Montir</label>
                                <input type="text" class="form-control" name="nama_montir" id="nama_montir"  required placeholder="Nama Montir...">
                            </div>
                      
                        </div>
                        <div class="col-sm-10">
                            <div class="form-group">
                                <label class="mb-0"><small class="text-danger">* </small>Keterangan</label>
                                <textarea name="keterangan" class="form-control" id="" cols="30" rows="3"></textarea>
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
    function ubah_montir(id, nama, kontak, keterangan){
        $('#modal_ubah_montir').modal('show');
    }

    function hapus_montir(id){
          swal({
             title: "Yakin Menghapus ?",
             text: "Data Yang Terhapus Tidak Dapat Dikembalikan !",
             icon: "warning",
             buttons: true,
             dangerMode: true,
           })
          .then((willDelete) => {
               if (willDelete) {
                    window.location.href = "{{url('/')}}/manajemen/montir/hapus-montir/"+id;
                    
               } 
               else {
                    swal("Hapus Data Dibatalkan", "Silahkan Klik Tombol Ok", "info");
                }
        });
        
    }
</script> 
@endsection