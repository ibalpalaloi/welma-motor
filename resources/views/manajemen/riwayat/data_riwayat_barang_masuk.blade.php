@foreach ($barang_masuk as $data)
    <tr>
        <td>{{$data->barang->nama_barang}}</td>
        <td>{{$data->barang->tipe_barang}}</td>
        <td>{{$data->merk}}</td>
        <td>{{$data->jumlah_barang}}</td>
        <td>{{$data->tgl_masuk}}</td>
    </tr>
@endforeach