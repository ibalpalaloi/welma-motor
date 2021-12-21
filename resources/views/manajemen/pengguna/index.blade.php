@extends('layouts/admin')

@section('title')
Pengguna
@endsection

@section('header-scripts')
    
@endsection

@section('header-breadcumb')
Pengguna
@endsection

@section('list-breadcumb')
<li class="breadcrumb-item active">Pengguna</li>
    
@endsection

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="/post-pengguna-baru" method="post">
            @csrf
                <div class="form-group">
                    <label for="exampleInputEmail1">Username</label>
                    <input name="username" type="text" class="form-control" id="" aria-describedby="emailHelp" placeholder="Username">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Nama</label>
                    <input name="nama" type="text" class="form-control" id="" aria-describedby="emailHelp" placeholder="Username">
                </div>
                <div class="form-group">
                    <label for="exampleFormControlSelect1">Role</label>
                    <select name="role" class="form-control" id="exampleFormControlSelect1">
                      <option>Admin</option>
                      <option>SuperAdmin</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Password</label>
                    <input name="password" type="text" class="form-control" id="" aria-describedby="emailHelp" placeholder="Username">
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


@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h5>DAFTAR PENGGUNA</h5>
            </div>

            <div class="card-body">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Tambah Pengguna</button>
                <br><br>
                <table id="" class="table-datatables display table table-striped table-bordered table-hover dt-responsive nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>Level Akses</th>
                            <th>Nama Akun</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($daftar as $row)
                        <tr>
                            <td>{{$row->username}}</td>
                            <td>{{$row->roles}}</td>
                            <td>{{$row->nama}}</td>
                            <td>
                                <button onclick="hapus_pengguna('{{$row->id}}')" class="btn btn-danger">Hapus</button>
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
    
@endsection

@section('footer-scripts')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
    function hapus_pengguna(id){
        swal("Yakin Ingin Hapus Akun Ini")
        .then((value) => {
            window.location.href = "/hapus-pengguna/"+id;
        });
    }
</script>
@endsection