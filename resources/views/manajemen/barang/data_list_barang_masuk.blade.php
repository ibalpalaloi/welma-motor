
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
    <td>{{$data->barang->nama_barang}}
        <br>
        <small><b>Kode : {{$data->barang->kode_barang}}</b></small>
    </td>
    <td style="white-space: normal;">{{$data->barang->tipe_barang}}
        <br><small><b>Merk : {{$data->barang->merk}}</b></small>
    </td>
    <td>
        @if ($data->supplier)
            {{$data->supplier->nama_supplier}}</td>
        @else
            -
        @endif
        
    <td>{{$data->jumlah_barang}}</td>
    <td>
        {{ tgl_indo(date('Y-m-d', strtotime($data->tgl_masuk))) }}
    </td>
    <td><button class="btn btn-danger btn-sm" onclick="hapus_riwayat_barang_masuk('{{$data->id}}')"><i class="feather icon-trash"></i> Hapus</button></td>
</tr>
@endforeach