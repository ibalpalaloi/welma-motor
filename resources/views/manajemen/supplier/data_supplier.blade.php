@extends('layouts.admin')

@section('content')
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
                    </tr>
                </thead>
                <tbody>
                    @foreach ($supplier as $data)
                        <tr>
                            <td>{{$data->nama_supplier}}</td>
                            <td>{{$data->kontak}}</td>
                            <td>{{$data->keterangan}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection