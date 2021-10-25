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



@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h5>DAFTAR PENGGUNA</h5>
            </div>
            <div class="card-body">
                <table id="" class="table-datatables display table table-striped table-bordered table-hover dt-responsive nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>Level Akses</th>
                            <th>Nama Akun</th>
                            <th>Terakhir Masuk</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($daftar as $row)
                        <tr>
                            <td>{{$row->username}}</td>
                            <td>{{$row->roles}}</td>
                            <td>Akan Datang...</td>
                            <td>Akan Datang...</td>
                            <td>Akan Datang...</td>

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
    
@endsection