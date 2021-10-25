@foreach ($barang_masuk as $data)
    <tr>
        <td>{{$data->barang->nama_barang}}</td>
        <td>{{$data->supplier->nama_supplier}}</td>
        <td>{{$data->jumlah_barang}}</td>
        <td>{{$data->tgl_masuk}}</td>
    </tr>
@endforeach