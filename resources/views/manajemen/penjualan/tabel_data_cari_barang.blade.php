@foreach ($barang as $data)
    <tr onclick="pilih_barang('{{$data->kode_barang}}')">
        <td >{{$data->kode_barang}}
        </td>
        <td>{{$data->nama_barang}}</td>
        <td>{{$data->tipe_barang}}</td>
        <td>{{$data->satuan}}</td>
        <td>{{$data->harga}}</td>
        <td>
            @if ($data->stok != null)
                {{$data->stok->stok}}
            @else
                0
            @endif
        </td>
    </tr>
@endforeach