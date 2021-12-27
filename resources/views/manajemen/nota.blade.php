<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>Hello, world!</title>
  </head>
  <body>
    <div class="container">
        <div class="text-center">
            <h2>Welma Motor</h2>
        </div>
        <br>
        <div class="row">
            <div class="col">Nama Pembeli: {{$riwayat_nota->nama_pembeli}}</div>
            <div class="col"></div>
        </div>
        <br><br>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nama Barang</th>
                    <th>Jumlah</th>
                    <th>Harga Satuan</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @php
                    $total_harga = 0;
                @endphp
                @foreach ($riwayat_nota->riwayat_pesanan as $pesanan)
                    <tr>
                        <td>{{$pesanan->nama_barang}}</td>
                        <td>{{$pesanan->jumlah}}</td>
                        <td>Rp. {{number_format($pesanan->harga,0,',','.')}}</td>
                        <td>Rp. {{number_format($pesanan->jumlah * $pesanan->harga,0,',','.')}}</td>
                    </tr>
                    @php
                        $total_harga += $pesanan->jumlah * $pesanan->harga
                    @endphp
                @endforeach
                <tr>
                    <td colspan="3">Total</td>
                    <td>Rp. {{number_format($total_harga,0,',','.')}}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script>
        $( document ).ready(function() {
            window.print()
        });
    </script>
  </body>
</html>