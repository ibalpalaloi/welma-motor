
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ekspor Excel</title>
</head>
<body>
    <table>
        <tbody>
            <tr>
                <td>No.</td>
                <td>Pembeli</td>
                <td>Status</td>
                <td>Tanggal Pemesanan</td>
                <td>Nama Barang</td>
                <td>Kode Barang</td>
                <td>Tipe</td>
                <td>Merek</td>
                <td>Jumlah</td>
                <td>Harga Jual</td>
                <td>Total Harga Jual</td>
                <td>Harga Modal</td>
                <td>Total Harga Modal</td>
                <td>Total Keuntungan</td>
            </tr>
            @foreach ($riwayat_nota as $data){
                @php
                    $jumlah_pesanan = $data->riwayat_pesanan->count();
                    $total_penjualan = 0;
                    $total_keuntungan = 0;
                @endphp
                <tr>
                    <td rowspan="{{$jumlah_pesanan+2}}">{{$loop->iteration}}.</td>
                    <td rowspan="{{$jumlah_pesanan+2}}">{{$data->nama_pembeli}}</td>
                    <td rowspan="{{$jumlah_pesanan+2}}">{{ucwords($data->status)}}</td>
                    <td rowspan="{{$jumlah_pesanan+2}}">{{$data->tgl_nota}}</td>
                </tr>
                
                @foreach ($data->riwayat_pesanan as $pesanan)
                <tr>
                    <td>{{ucwords($pesanan->nama_barang)}}</td>
                    
                    @if ($pesanan->barang)
                        <td>{{$pesanan->barang->kode_barang}}</td>
                        <td>{{$pesanan->barang->tipe_barang}}</td>
                        <td>{{$pesanan->barang->merk}}</td>
                    @else
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                    @endif
                    
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
                    <td colspan="5">Total Jumlah </td>
                    <td>{{$total_penjualan}}</td>
                    <td colspan="2"></td>
                    <td>{{$total_keuntungan}}</td>
                </tr>
            @endforeach
          
         
           
        </tbody>
    </table>
</body>
</html>
  