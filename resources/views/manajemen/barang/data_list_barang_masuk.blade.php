
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

@foreach ($barang_masuk as $data)
    <tr>
        <td>{{$data->barang->nama_barang}}</td>
        <td>{{$data->supplier->nama_supplier}}</td>
        <td>{{$data->jumlah_barang}}</td>
        <td>{{ tgl_indo(date('Y-m-d', strtotime($data->tgl_masuk))) }}</td>
    </tr>
@endforeach