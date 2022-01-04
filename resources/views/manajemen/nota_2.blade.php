<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Nota Penjualan - {{$riwayat_nota->id}}</title>

    <style type="text/css">
  
        @page{
            margin: 0px;
            size: 9.5in 5.5in;
        }

        * {
            font-family: Verdana, Arial, sans-serif;
        }

        body{

            margin: 15px;
        }

        h3{

            margin: 0px;
        }

        table {
            font-size: 7px;
        }



        tfoot tr td {

            font-size: 7px;
        }

        .gray {
            background-color: lightgray
        }

        hr{

            color: black;
        }

        .title_information{

            font-size: 10px;

        }

        .footer {
            position: fixed; 
            bottom: 16px;
            left: 0cm;
            right: 0cm;
            /** Extra personal styles **/
            z-index: 10;
            padding: 0 20px;
            padding-bottom: 10px;
        }

    </style>

</head>

@php
function tgl_indo($tanggal){
$bulan = array (
1 => 'Januari',
'Februari',
'Maret',
'April',
'Mei',
'Juni',
'Juli',
'Agustus',
'September',
'Oktober',
'November',
'Desember'
);
$pecahkan = explode('-', $tanggal);
return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
}

    function penyebut($nilai) {
		$nilai = abs($nilai);
		$huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
		$temp = "";
		if ($nilai < 12) {
			$temp = " ". $huruf[$nilai];
		} else if ($nilai <20) {
			$temp = penyebut($nilai - 10). " belas";
		} else if ($nilai < 100) {
			$temp = penyebut($nilai/10)." puluh". penyebut($nilai % 10);
		} else if ($nilai < 200) {
			$temp = " seratus" . penyebut($nilai - 100);
		} else if ($nilai < 1000) {
			$temp = penyebut($nilai/100) . " ratus" . penyebut($nilai % 100);
		} else if ($nilai < 2000) {
			$temp = " seribu" . penyebut($nilai - 1000);
		} else if ($nilai < 1000000) {
			$temp = penyebut($nilai/1000) . " ribu" . penyebut($nilai % 1000);
		} else if ($nilai < 1000000000) {
			$temp = penyebut($nilai/1000000) . " juta" . penyebut($nilai % 1000000);
		} else if ($nilai < 1000000000000) {
			$temp = penyebut($nilai/1000000000) . " milyar" . penyebut(fmod($nilai,1000000000));
		} else if ($nilai < 1000000000000000) {
			$temp = penyebut($nilai/1000000000000) . " trilyun" . penyebut(fmod($nilai,1000000000000));
		}     
		return $temp;
	}

@endphp




<body>

    <table width="100%" class="title_information">
        <tr>
            <td valign="top" width="50%">
                <div class=""><h3>WELMA</h3></div>
                <div class="">Bengkel Dan Variasi</div>
                <div class="">Jl. Hangtuah No. 73 Telp 0451 428402, 081341114556</div>
                <div class="">Palu 94118</div>
                <hr width="95%" align="left" style=" border: 1px solid black; color:black;background-color:black" >
            </td>
            <td valign="top" align="right" width="50%">
                <h3>Nota Penjualan</h3>
                <h3>CASH-NOTA{{$riwayat_nota->id}}</h3>
            </td>
        </tr>

    </table>

    <table width="100%" class="title_information">
        <tr >
            <td valign="top" align="left" width="50%">
                <div class=""><strong style="padding-right: 26px;">Tanggal </strong> : {{ tgl_indo(date('Y-m-d', strtotime($riwayat_nota->tgl_nota))) }}</div>
                <div class=""><strong style="padding-right: 20px;">Halaman </strong> : 1</div>

            </td>
            <td valign="top" align="left" width="50%">
                <div class=""><strong>Kepada YTH</strong></div>
                <div class=""><strong>{{strtoupper($riwayat_nota->nama_pembeli)}}</strong></div>        
            </td>
        </tr>

    </table>

    <br />

    <table width="100%" style=" border: 1px solid black;border-collapse: collapse;">
        <thead style="border: 1px solid black;border-collapse: collapse; ">
            <tr height="15">
                <th>No.</th>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Satuan</th>
                <th>Tipe</th>
                <th>Merek</th>
                <th>Jumlah</th>
                <th>Harga</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody align="center">
            @php
                $total_harga = 0;
            @endphp

            @foreach ($riwayat_nota->riwayat_pesanan as $pesanan)
            <tr>
                <th scope="row">{{$loop->iteration}}</th>
                @if ($pesanan->barang->jenis == 'barang')
                    <td>{{$pesanan->kode_barang}}</td>
                @else
                    <td>Jasa</td>
                @endif
                <td align="left">{{$pesanan->nama_barang}}</td>
                <td>{{$pesanan->barang->satuan}}</td>
                <td >{{$pesanan->barang->tipe_barang}}</td>
                <td>{{$pesanan->barang->merk}}</td>
                <td>{{$pesanan->jumlah}}</td>
                <td align="right">Rp. {{number_format($pesanan->harga,0,',','.')}}</td>
                <td align="right">Rp. {{number_format($pesanan->jumlah * $pesanan->harga,0,',','.')}}</td>
            </tr>
            @php
                $total_harga += $pesanan->jumlah * $pesanan->harga
            @endphp
            @endforeach
        </tbody>

        <tfoot style="border: 1px solid black;">
            <tr  >
                <td colspan="5" rowspan="5" valign="top">
                    <div class="">TERBILANG</div>
                    <div class="">{{strtoupper(penyebut($total_harga))}} RUPIAH</div>
                </td>
                <td align="left" colspan="2">JUMLAH</td>
                <td align="right" colspan="2">Rp. {{number_format($total_harga,0,',','.')}}</td>
            </tr>
            <tr  >
          
                <td align="left" colspan="2">PANJAR</td>
                <td align="right" colspan="2">Rp. 0</td>
            </tr>
            
            <tr  >
               
                <td align="left" colspan="2">POTONGAN</td>
                <td align="right" colspan="2">Rp. 0</td>
            </tr>
            
            <tr  >
             
                <td align="left" colspan="2">CHARGE</td>
                <td align="right" colspan="2">Rp. 0</td>
            </tr>
            <tr  >
             
                <td align="left" colspan="2">TOTAL HARGA</td>
                <td align="right" colspan="2">Rp. {{number_format($total_harga,0,',','.')}}</td>
            </tr>
            
            
        </tfoot>
    </table>
<div class="footer">

    <table width="100%">
        <tr valign="top">
            <td align="left" style="width: 55%;">
                <div class="">*) Barang Yang Dibeli Sudah Diperiksa Dalam Kondisi Baik</div>
                <div class=""> *) Batas Waktu Retrun Barang 3 (Tiga) Hari Sejak Tanggal Pembelian</div>
                <div class="" style="margin-top : 15px;">Dicetak Pada Tangal : {{ tgl_indo(date('Y-m-d')) }}</div>
            </td>
            <td align="left" style="width: 15%;">
                @if ($riwayat_nota->montir)
                <div class="" style="margin-bottom: 35px">Montir,</div>
                <div class="" style="text-decoration: underline;">{{strtoupper($riwayat_nota->montir)}}</div>
                @endif
            </td>
            <td align="left" style="width: 15%;">
                <div class="" style="margin-bottom: 35px">Penerima,</div>
                <div class="" style="text-decoration: underline;">{{strtoupper($riwayat_nota->nama_pembeli)}}</div>
            </td>
            <td align="left" style="width: 15%;">
                <div class="" style="margin-bottom: 35px">Mengetahui,</div>
                <div class="" style="text-decoration: underline;">{{strtoupper($riwayat_nota->user->nama)}}</div>
            </td>
        </tr>

    </table>
</div>
     
 
 
</body>

</html>
