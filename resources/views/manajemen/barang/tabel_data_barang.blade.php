@foreach ($barang as $data)

    <tr onclick="modal_tambah_barang_masuk('{{$data->nama_barang}}', '{{$data->id}}')">
        <td>{{$data->kode_barang}}</td>
        <td>{{$data->nama_barang}}</td>
    </tr>
    
@endforeach