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
@endphp

@foreach ($daftar_barang as $data)
    <tr>
        <td>{{ucwords($data['nama_barang'])}}
            <br>
            <small><b>Kode : {{$data['kode_barang']}}</b></small>
        </td>
        <td>{{$data['tipe']}}
            <br>
            <small><b>Merk : {{$data['merk']}}</b></small>
        </td>
        <td>{{$data['jumlah']}}</td>
        <td> 
            {{$data['supplier']}}
        </td>
        <td>
            {{$data['tgl_masuk']}}
        </td>
    </tr>
@endforeach