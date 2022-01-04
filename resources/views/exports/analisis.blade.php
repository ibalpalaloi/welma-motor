<table>
    <tbody>
        @foreach ($riwayat_nota as $data){
            <tr>
                <td colspan="7"></td>
            </tr>
            <tr>
                <td colspan="3">{{$data->nama_pembeli}} ({{$data->status}})</td>
            </tr>
            <tr>
                <td>Nama barang</td>
                <td>Jumlah</td>
                <td>Harga</td>
                <td>Total Harga</td>
                <td>Modal per Barang</td>
                <td>Total Modal</td>
                <td>Keuntungan</td>
            </tr>
            @php
                $total_penjualan = 0;
                $total_keuntungan = 0;
            @endphp
            @foreach ($data->riwayat_pesanan as $pesanan)
                
                <tr>
                    <td>{{$pesanan->nama_barang}}</td>
                    <td>{{$pesanan->jumlah}}</td>
                    <td>{{$pesanan->harga}}</td>
                    <td>{{$pesanan->jumlah * $pesanan->harga}}</td>
                    @if ($pesanan->barang)
                        @php
                            $modal = $pesanan->barang->harga_beli;
                        @endphp
                        <td>{{$pesanan->barang->harga_beli}}</td>
                    @else
                        @php
                            $modal = 0;
                        @endphp
                        <td>0</td>
                    @endif
                    <td>{{$modal * $pesanan->jumlah}}</td>
                    <td>{{($pesanan->jumlah * $pesanan->harga) - ($pesanan->jumlah * $modal)}}</td>
                    @php
                        $total_penjualan += $pesanan->jumlah * $pesanan->harga;
                        $total_keuntungan += ($pesanan->jumlah * $pesanan->harga) - ($pesanan->jumlah * $modal);
                    @endphp
                </tr>
            @endforeach
            <tr>
                <td colspan="3">Total</td>
                <td>{{$total_penjualan}}</td>
                <td></td>
                <td></td>
                <td>{{$total_keuntungan}}</td>
            </tr>
        @endforeach
    </tbody>
</table>