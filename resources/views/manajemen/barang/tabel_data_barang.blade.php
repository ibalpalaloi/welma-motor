@foreach ($barang as $data)

    <tr >
        <td>{{$data->kode_barang}}</td>
        <td>{{$data->nama_barang}}
            
        </td>
        <td style="white-space: normal;">{{$data->tipe_barang}}
            <br><small><b>Merk : {{$data->merk}}</b></small>
        </td>
        <td>
            @php
                if ($data->stok != null) {
                    $stok = $data->stok->stok;
                } else {
                    $stok = 0; 
                }
            @endphp

            {{$stok}}
        </td>
        <td><button class="btn btn-sm btn-primary" onclick="modal_tambah_barang_masuk('{{$data->nama_barang}}','{{$data->merk}}','{{$data->tipe_barang}}','{{$data->id}}')"><i class="feather icon-plus"></i> Tambah</button></td>
    </tr>
    
@endforeach