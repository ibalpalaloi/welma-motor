@extends('layouts/admin')

@section('title')
    
Dashboard
@endsection

@section('header-scripts')
    
@endsection

@section('header-breadcumb')
Dashboard
@endsection

@section('list-breadcumb')
    
@endsection

@section('content')
<div class="row">
    <div class="col-md-6 col-lg-4">
        <div class="card widget-statstic-card">
            <div class="card-body">
                <div class="card-header-left mb-3">
                    <h4 class="mb-2">Pengguna</h4>
                    <hr>
                </div>
                <i class="feather icon-users st-icon bg-c-red txt-lite-color"></i>
                <div class="text-left">
                    <div class="row">
                        <div class="col-sm-4">
                            <a href="{{url('manajemen/pengguna')}}" class="btn btn-danger btn-sm btn-block"><i class="feather icon-arrow-right"></i> Daftar</a>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-4">
        <div class="card widget-statstic-card">
            <div class="card-body">
                <div class="card-header-left mb-3">
                    <h4 class="mb-2">Barang</h4>
                    <hr>
                </div>
                <i class="feather icon-package st-icon bg-c-blue"></i>
                <div class="text-left">
                    <div class="row">
                        <div class="col-sm-4">
                            <a href="{{url('manajemen/barang/daftar-barang')}}" class="btn btn-primary btn-sm btn-block"><i class="feather icon-arrow-right"></i> Daftar</a>
                        </div>
                        <div class="col-sm-4">

                            <a href="{{url('manajemen/pengguna')}}" class="btn btn-primary btn-sm btn-block"><i class="feather icon-arrow-right"></i> Penerimaan</a>

                        </div>
                        <div class="col-sm-4">

                            <a href="{{url('manajemen/pengguna')}}" class="btn btn-primary btn-sm btn-block"><i class="feather icon-arrow-right"></i> Penjualan</a>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@section('modal-content')
    
@endsection

@section('footer-scripts')
    
@endsection