@foreach ($barang as $data)
    <tr>
        <td onclick="pilih_barang('{{$data->kode_barang}}')">{{$data->kode_barang}}</td>
        <td>{{$data->nama_barang}}</td>
        <td>{{$data->tipe_barang}}</td>
        <td>{{$data->satuan}}</td>
        <td>{{$data->harga}}</td>
    </tr>
@endforeach