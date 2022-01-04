@foreach ($nota->pesanan as $pesanan)
    <tr id="row_pesanan{{$pesanan->id}}">
        <td>
            {{strtoupper($pesanan->barang->nama_barang)}}
            <br>
            <small><b>Kode : {{$pesanan->barang->kode_barang}}</b></small>
        </td>
        <td>{{$pesanan->barang->tipe_barang}}
        </td>
        <td> {{$pesanan->barang->merk}}</td>
        <td id="tdata_harga_satuan{{$pesanan->id}}">
            <input  type="number" id="pesanan_{{$pesanan->id}}" readonly
            value="{{$pesanan->harga}}" style="cursor: pointer;" 
            @if ($pesanan->barang->jenis == 'jasa')
                class="form-control"
                ondblclick="show_input_ubah_harga_satuan('{{$pesanan->id}}')"
            @elseif(Auth()->user()->roles == "Admin") 
                class="form-control"
                ondblclick="show_input_ubah_harga_satuan('{{$pesanan->id}}')" 
            @else
                class="form-control-plaintext"
            @endif  
            >
        </td>
        <td id="tdata_nota{{$pesanan->id}}">
            <input type="number" id="jumlah_pesanan{{$pesanan->id}}" 
            value="{{$pesanan->jumlah}}" style="cursor: pointer;" readonly
            class="form-control"
            ondblclick="show_input_ubah_jumlah_pesanan('{{$pesanan->id}}')"
            
            >
        </td>
        <td id="tdata_total_sub_pesanan{{$pesanan->id}}">Rp. {{$pesanan->jumlah * $pesanan->harga}}</td>
        <td><button onclick="hapus_pesanan('{{$pesanan->id}}')" class="btn btn-danger btn-sm"><i class="feather mr-2 icon-trash"></i>Hapus</button></td>
        
    </tr>
@endforeach