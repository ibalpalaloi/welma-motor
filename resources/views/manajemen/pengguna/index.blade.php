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
            <div class="card-header">
                <h5>DAFTAR PENGGUNA</h5>
                <div class="card-header-right">
                    <div class="card-option">
                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal_tambah_pengguna"><i class="feather icon-plus"></i> Tambah</button>
                    </div>
                </div>
            </div>

            <div class="card-body">
         
                <table id="" class="table-datatables display table table-striped table-bordered table-hover dt-responsive nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Username</th>
                            <th>Nama Pengguna</th>
                            <th>Level Akses</th>                            
                            <th>Terakhir Masuk</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($daftar as $row)
                        <tr id="trow_pengguna_{{$row->id}}">
                            <td>{{$loop->iteration}}.</td>
                            <td>{{$row->username}}</td>
                            <td>{{$row->nama}}</td>
                            <td>{{ucwords($row->roles)}}</td>
                            <td>
                                @if ($row->last_sign_in != null)

            
                                    {{ tgl_indo(date('Y-m-d', strtotime($row->last_sign_in))) }}
                                    <br>
                                    <small>
                                        Jam : {{date('h:i:sa',strtotime($row->last_sign_in))}}
                                    </small>

                                @else

                                    Belum Pernah

                                @endif
                            </td>
                            <td>
                                <div class="btn-group mr-2">
                                    <button class="btn btn-success dropdown-toggle btn-sm" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Lainnya</button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="javascript:void(0)" onclick="modal_ubah_pengguna('{{$row->id}}')"><i class="feather icon-edit"></i> Ubah Pengguna</a>
                                        <a class="dropdown-item" hhref="javascript:void(0)" onclick="hapus_pengguna('{{$row->id}}')" ><i class="feather icon-trash"></i> Hapus Pengguna</a>
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

{{-- modal tambah pengguna --}}
<div class="modal fade" id="modal_tambah_pengguna" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h4 class="modal-title text-white">Tambah Pengguna</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{url()->current()}}/post-tambah-pengguna" method="post">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-10">
                            <div class="form-group">
                                <label class="mb-0"><small class="text-danger">* </small>Username <small>(Untuk Login)</small></label>
                                <input type="text" class="form-control" name="username_pengguna" id="username_pengguna"  required placeholder="Username Pengguna...">
                            </div>
                      
                        </div>
              
                    </div>
                    <div class="row">
                        <div class="col-sm-10">
                            <div class="form-group">
                                <label class="mb-0"><small class="text-danger">* </small>Nama Pengguna</label>
                                <input type="text" class="form-control" name="nama_pengguna" required placeholder="Nama Pengguna...">
                            </div>
                        </div>
        
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="mb-0"><small class="text-danger">* </small>Level Akses</label>
                                <select class="form-control" name="level_akses_pengguna" required>
                                    <option value="" disabled>--- Pilih Akses ---</option>
                                    <option value="kasir">Kasir</option>
                                </select>
                            </div>
                            
                        </div>
                        <div class="col-sm-5">
                            <div class="form-group">
                                <label class="mb-0" ><small class="text-danger">* </small>Password</label>
                                <input type="password" class="form-control" name="password_pengguna" required placeholder="Password...">
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

{{-- modal ubah pengguna --}}
<div class="modal fade" id="modal_ubah_pengguna" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h4 class="modal-title text-white">Ubah Pengguna</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{url()->current()}}/post-ubah-pengguna" method="post">
                @csrf
                @method('PUT')
                <input type="hidden" name="users_id" id="users_id">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-10">
                            <div class="form-group">
                                <label class="mb-0"><small class="text-danger">* </small>Username <small>(Untuk Login)</small></label>
                                <input type="text" class="form-control" name="username_pengguna_ubah" id="username_pengguna_ubah"  required placeholder="Username Pengguna...">
                            </div>
                      
                        </div>
              
                    </div>
                    <div class="row">
                        <div class="col-sm-10">
                            <div class="form-group">
                                <label class="mb-0"><small class="text-danger">* </small>Nama Pengguna</label>
                                <input type="text" class="form-control" name="nama_pengguna_ubah" id="nama_pengguna_ubah" required placeholder="Nama Pengguna...">
                            </div>
                        </div>
        
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="mb-0"><small class="text-danger">* </small>Level Akses</label>
                                <select class="form-control" name="level_akses_pengguna_ubah" required>
                                    <option value="" disabled>--- Pilih Akses ---</option>
                                    <option value="kasir">Kasir</option>
                                </select>
                            </div>
                            
                        </div>
                        <div class="col-sm-5">
                            <div class="form-group">
                                <label class="mb-0" ><small class="text-danger">* </small>Password</label>
                                <input type="password" class="form-control" name="password_pengguna_ubah" placeholder="Password...">
                            </div>
                        </div>

                    </div>
                
                </div>
                <div class="modal-footer p-2">
                    <button type="button" data-dismiss="modal" aria-label="Close" class="btn btn-danger btn-sm"><i class="feather icon-refresh-ccw"></i> Tutup</button>
                    <button type="submit" class="btn btn-primary btn-sm"><i class="feather icon-save"></i>  Simpan</button>
                </div>

            </form>

           
        </div>
    </div>
</div>

@endsection

@section('footer-scripts')

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>    

<script>

$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
$(function() {
    $('#username_pengguna').on('keypress', function(e) {
        if (e.which == 32)
            return false;
    });
});

function modal_ubah_pengguna(id){
        $.ajax({
            type: "GET",
            url: "{{url('/')}}"+"/get-pengguna/"+id,
            success:function(data){
                console.log(data)
                var detail_pengguna = data.pengguna;
                $('#users_id').val(id);
                $('#username_pengguna_ubah').val(detail_pengguna['username']);
                $('#nama_pengguna_ubah').val(detail_pengguna['nama']);
                $('#level_akses_pengguna_ubah').val(detail_pengguna['roles']);
                $('#modal_ubah_pengguna').modal('show');
            }
        })
}

function hapus_pengguna(id){
    swal("Yakin Ingin Hapus Akun Ini")
        .then((value) => {

            $.ajax({
                type: "GET",
                url: "{{url()->current()}}/hapus-pengguna/"+id,
                success:function(data){
                    $('#trow_pengguna_'+id).remove();
                }
            })

        });
       
    }

</script>
@endsection