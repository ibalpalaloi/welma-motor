
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

@foreach ($data_riwayat_nota as $data)
    <tr>
        <td>{{$data['nama_pembeli']}}</td>
        <td>{{$data['status']}}</td>
        <td>
            {{ tgl_indo(date('Y-m-d', strtotime($data['tgl_nota']))) }}
        </td>
        <td>Rp. {{$data['total_harga']}}</td>
        <td>{{$data['nama_admin']}}</td>

        <td>{{$data['montir']}}</td>
        <td>
            <a target="blank" href="{{url('/')}}/nota/lihat/{{$data['id']}}" class="btn btn-primary btn-sm"><i class="feather icon-bookmark"></i> Lihat Nota</a>
            <a href="{{url('/')}}/batalkan_checkout/{{$data['id']}}" class="btn btn-danger btn-sm"><i class="feather icon-rotate-ccw"></i> Batal Checkout</a>
            <a href="{{url('/')}}/nota/download/{{$data['id']}}" class="btn btn-success btn-sm"><i class="feather icon-download"></i> Download Nota</a>

        </td>
    </tr>
@endforeach