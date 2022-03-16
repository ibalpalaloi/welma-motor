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