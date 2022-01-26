
@foreach ($barang as $data)
    <tr onclick="pilih_barang('{{$data->kode_barang}}')">
        <td >{{$data->kode_barang}}
        </td>
        <td style="white-space: normal !important;">{{$data->nama_barang}}</td>
        <td style="white-space: normal !important;">{{$data->tipe_barang}}</td>
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