<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <table>
        <thead>
            <tr>
                <th>Nama Montir</th>
                <th>Pembeli</th>
                <th>Tgl</th>
                <th>Jumlah Transaksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data_riwayat_nota as $data)
                <tr>
                    <td>{{$data['montir']}}</td>
                    <td>{{$data['pembeli']}}</td>
                    <td>{{$data['tgl_nota']}}</td>
                    <td>
                        Rp. {{number_format($data['jumlah_transaksi'],0,',','.')}}
                    </td>
                </tr>
                
            @endforeach
        </tbody>
    </table>
</body>
</html>