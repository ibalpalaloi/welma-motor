<table>
    <tbody>
        @foreach ($riwayat_nota as $data){

            <tr>
                <td colspan="3">{{$data->nama_pembeli}} ({{$data->status}})</td>
            </tr>
            <tr>
                <td>Nama barang</td>
                <td>Jumlah</td>
                <td>Harga</td>
            </tr>
            @foreach ($data->riwayat_pesanan as $pesanan)
                <tr>
                    <td>{{$pesanan->nama_barang}}</td>
                    <td>{{$pesanan->jumlah}}</td>
                    <td>{{$pesanan->harga}}</td>
                </tr>
            @endforeach
            
        @endforeach
    </tbody>
</table>