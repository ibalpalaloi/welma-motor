@extends('layouts.admin')

@section('content')

<div class="modal fade" id="modal_ubah_supplier" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ubah Supplier</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form action="{{url('/post-ubah-supplier')}}" method="POST">
                @csrf
                    <input type="hidden" id="ubah_id" name="id_supplier">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Nama</label>
                        <input name="nama" type="text" class="form-control" id="ubah_nama" aria-describedby="emailHelp">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Kontak</label>
                        <input name="kontak" type="text" class="form-control" id="ubah_kontak" aria-describedby="emailHelp">
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Keterangan</label>
                        <textarea name="keterangan" class="form-control" id="ubah_keterangan" rows="3"></textarea>
                    </div>
            
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
        </form>
      </div>
    </div>
</div>


{{-- modal tambah supplier --}}
<div class="modal fade" id="modal_tambah_supplier" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Tambah Supplier</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form action="{{url('/post-supplier-baru')}}" method="POST">
                @csrf
                    <div class="form-group">
                        <label for="exampleInputEmail1">Nama</label>
                        <input name="nama" type="text" class="form-control" id="ubah_nama" aria-describedby="emailHelp">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Kontak</label>
                        <input name="kontak" type="text" class="form-control" id="ubah_kontak" aria-describedby="emailHelp">
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Keterangan</label>
                        <textarea name="keterangan" class="form-control" id="ubah_keterangan" rows="3"></textarea>
                    </div>
            
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
        </form>
      </div>
    </div>
</div>


<div class="col-sm-12">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-10">
                    <h5>DAFTAR SUPPLIER</h5>
                </div>
                <div class="col">
                    <button onclick="modal_tambah_supplier()" type="button" class="btn btn-primary"><i class="feather mr-2 icon-plus"></i>Tambah</button>
                </div>
            </div>
            
        </div>
        <div class="card-body">
            <table id="" class="table-datatables display table table-striped table-bordered table-hover dt-responsive nowrap" style="width:100%">
                <thead>
                    <tr>
                        <th>Supplier</th>
                        <th>Kontak</th>
                        <th>Keterangan</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($supplier as $data)
                        <tr>
                            <td>{{$data->nama_supplier}}</td>
                            <td>{{$data->kontak}}</td>
                            <td>{{$data->keterangan}}</td>
                            <td>
                                <button onclick="ubah_supplier('{{$data->id}}', '{{$data->nama_supplier}}', '{{$data->kontak}}', '{{$data->keterangan}}')" type="button" class="btn btn-primary">Ubah</button>
                                <button onclick="hapus_supplier('{{$data->id}}')" type="button" class="btn btn-danger">Hapus</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('footer-scripts')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
    function ubah_supplier(id, nama, kontak, keterangan){
        $('#ubah_id').val(id);
        $('#ubah_nama').val(nama);
        $('#ubah_kontak').val(kontak);
        $('#ubah_keterangan').val(keterangan);
        $('#modal_ubah_supplier').modal('show');
    }

    function hapus_supplier(id){
        swal("Yakin Ingin Menghapus ??")
        .then((value) => {
            window.location.href = "/hapus-supplier/"+id;
        });
    }

    function modal_tambah_supplier(){
        $('#modal_tambah_supplier').modal('show');
    }
</script> 
@endsection