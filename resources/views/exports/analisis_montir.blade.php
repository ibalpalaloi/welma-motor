<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Eksport Montir</title>
</head>
<body>
    <table border="1" width="100%">
        <thead>
            <tr>
                <th rowspan="2">No.</th>
                <th rowspan="2">Nama Montir</th>
                <th rowspan="2">Total Jasa Transaksi</th>
                <th rowspan="2">Total Harga Transaksi</th>
                <th colspan="5" align="center">Transaksi</th>
           
            </tr>
            <tr>
                <th>Pembeli</th>
                <th>Status</th>
                <th>Tanggal</th>
                <th>Jasa</th>
                <th>Total Harga</th>
            </tr>
        </thead>
        <tbody>
  
            @foreach ($data_riwayat_nota as $row )

                <tr>
                    <td rowspan="{{$row['jumlah_transaksi'] + 1}}">
                        {{$loop->iteration}}.
                    </td>
                    <td rowspan="{{$row['jumlah_transaksi'] + 1}}">
                        {{$row['montir']}}
                    </td>
                    {{-- 
                    <td rowspan="{{$row['jumlah_transaksi'] + 1}}">
                        {{$row['tanggal']}}
                    </td>
                    --}}

                    <td rowspan="{{$row['jumlah_transaksi'] + 1}}">
                        Rp. {{number_format($row['total_jasa_transaksi'],0,',','.')}}
                    </td>
                
                    <td rowspan="{{$row['jumlah_transaksi'] + 1}}">
                        Rp. {{number_format($row['total_harga_transaksi'],0,',','.')}}
                    </td>


                </tr>

                @foreach ($row['transaksi'] as $transaksi)
                <tr>
                    <td>{{$transaksi['nama_pembeli']}}</td>
                    <td>{{ucwords($transaksi['status'])}}</td>
                    <td>{{$transaksi['tanggal']}}</td>
                    <td>
                        Rp. {{number_format($transaksi['jasa'],0,',','.')}}
                    </td>
                    <td>
                        Rp. {{number_format($transaksi['total_harga'],0,',','.')}}
                    </td>
                </tr>
                    
                @endforeach

             
            @endforeach
        </tbody>
    </table>
</body>
</html>