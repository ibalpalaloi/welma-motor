@foreach ($data_riwayat_nota as $data)
    <tr>
        <td>{{$data['nama_pembeli']}}</td>
        <td>{{$data['tgl_nota']}}</td>
        <td>Rp. {{$data['total_harga']}}</td>
        <td>{{$data['nama_admin']}}</td>
        <td>
            <a target="blank" href="/nota/{{$data['id']}}" class="btn btn-primary">Cek Detail</a>
            <a href="/batalkan_checkout/{{$data['id']}}" class="btn btn-danger">Batal Checkout</a>
        </td>
    </tr>
@endforeach