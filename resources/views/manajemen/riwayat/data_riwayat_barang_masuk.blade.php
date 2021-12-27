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
    <td>{{ucwords($data->barang->nama_barang)}}
        <br>
        <small><b>Kode : {{$data->barang->kode_barang}}</b></small>
    </td>
    <td>{{$data->barang->tipe_barang}}
        <br>
        <small><b>Merk : {{$data->barang->merk}}</b></small>
    </td>
    <td>{{$data->jumlah_barang}}</td>
    <td>  
    @if ($data->supplier)
        {{$data->supplier->nama_supplier}}</td>
    @else
        -
    @endif
    </td>
    <td>
        {{ tgl_indo(date('Y-m-d', strtotime($data->tgl_masuk))) }}
    </td>
</tr>
@endforeach