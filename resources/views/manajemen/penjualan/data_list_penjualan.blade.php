@foreach ($nota->pesanan as $pesanan)
    <tr id="row_pesanan{{$pesanan->id}}">
        <td>
            {{strtoupper($pesanan->barang->nama_barang)}}
            <br>
            <small><b>Kode : {{$pesanan->barang->kode_barang}}</b></small>
        </td>
        <td>{{$pesanan->barang->tipe_barang}}
            <br>
            <small><b>Merk : {{$pesanan->barang->merk}}</b>
        </td>
        <td id="tdata_harga_satuan{{$pesanan->id}}">
            <input class="form-control" type="number" id="pesanan_{{$pesanan->id}}" readonly
            value="{{$pesanan->harga}}" style="cursor: pointer;" ondblclick="show_input_ubah_harga_satuan('{{$pesanan->id}}')">
        </td>
        <td id="tdata_nota{{$pesanan->id}}">
            <input class="form-control" type="number" id="jumlah_pesanan{{$pesanan->id}}" readonly
            value="{{$pesanan->jumlah}}" style="cursor: pointer;" ondblclick="show_input_ubah_jumlah_pesanan('{{$pesanan->id}}')">
        </td>
        <td id="tdata_total_sub_pesanan{{$pesanan->id}}">Rp. {{$pesanan->jumlah * $pesanan->harga}}</td>
        <td><button onclick="hapus_pesanan('{{$pesanan->id}}')" class="btn btn-danger btn-sm"><i class="feather mr-2 icon-trash"></i>Hapus</button></td>
        
    </tr>
@endforeach