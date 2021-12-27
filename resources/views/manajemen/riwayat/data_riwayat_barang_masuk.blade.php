@foreach ($daftar_barang as $data)
    <tr>
        <td>{{$data['nama_barang']}}</td>
        <td>{{$data['tipe']}}</td>
        <td>{{$data['merk']}}</td>
        <td>{{$data['jumlah']}}</td>
        <td>{{$data['supplier']}}</td>
        <td>{{$data['tgl_masuk']}}</td>
    </tr>
@endforeach