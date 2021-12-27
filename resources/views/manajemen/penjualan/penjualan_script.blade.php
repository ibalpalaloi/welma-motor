<script>
    @isset($nota) var nota = {!! json_encode($nota) !!}; @endisset

    function modal_tambah_nota(){
        $('#modal-tambah-nota.modal').modal('show');
    }


    $('#input_kode_barang').on('keypress', function(e) {
                return false;
    });
        

    $("#input_kode_barang").on('input', function(){
        var kode_barang = $('#input_kode_barang').val();
        get_barang(kode_barang);
    })

    function pilih_nama_pembeli(id_nota){
        window.location.replace("/penjualan?id_nota="+id_nota);
    }

    function show_modal_cari_barang(){
        $('#modal-cari-barang').modal('show');
    }

    $('#cari_barang_input').on('input', function(){
        var keyword = $('#cari_barang_input').val();
        cari_barang(keyword);
    });

    function cari_barang(keyword){
        $.ajax({
            type: "get",
            url: "{{url('/')}}/penjualan/cari-barang?keyword="+keyword,
            success:function(data){
                $('#tbody_modal_cari_barang').empty();
                $('#tbody_modal_cari_barang').append(data.view);
            }
        })
    }

    function get_barang(kode_barang){
        $.ajax({
            type: "get",
            url: "{{url('/')}}/get-barang?kode_barang="+kode_barang+"&id_nota="+nota['id'],
            success:function(data){
                console.log(data);
                if(data.status == "sukses"){
                    console.log(data);
                    $('#input_kode_barang').val("");
                    var barang = data.barang;
                    console.log(barang);
                    var tabel = "";

                    if(barang['merk'] == null){
                        barang['merk'] = '';

                    }
        
                    var td_1 = "<td>"+barang['nama_barang'].toUpperCase()+
                                "<br><small><b>Kode : "+
                                barang['kode_barang']
                                +"</b></small>"+
                                "</td>";
                    var td_2 = "<td>"+barang['tipe_barang']+
                                "<br><small><b>Merk : "+
                                barang['merk']
                                +"</b></small>"+
                                "</td>";
                    var td_3 = "<td id='tdata_harga_satuan"+data.id_pesanan+"'>"+
                                '<input class="form-control" type="number" id="pesanan_'+data.id_pesanan+'" readonly value="'+barang['harga']+'" style="cursor: pointer;" ondblclick="show_input_ubah_harga_satuan('+data.id_pesanan+')">'
                                +"</td>";
                    var td_4 =  "<td id='tdata_nota"+data.id_pesanan+"'>"+
                                '<input class="form-control" type="number" id="jumlah_pesanan'+data.id_pesanan+'" readonly value="1" style="cursor: pointer;" ondblclick="show_input_ubah_jumlah_pesanan('+data.id_pesanan+')">'
                                +"</td>";
                    
                    var td_5 = "<td id='tdata_total_sub_pesanan"+data.id_pesanan+"'>"+
                               'Rp. '+barang['harga']
                                +"</td>";

                    var td_6 = "<td>"+
                                "<button onclick='hapus_pesanan("+data.id_pesanan+")' class='btn btn-danger btn-sm'><i class='feather mr-2 icon-trash'></i>Hapus</button>"
                               +"</td>";

                    tabel += "<tr id='row_pesanan"+data.id_pesanan+"'>";
                    tabel += td_1;
                    tabel += td_2;
                    tabel += td_3;
                    tabel += td_4;
                    tabel += td_5;
                    tabel += td_6;
                    tabel += "</tr>";
                    $('#tbody_daftar_nota').append(tabel);
                    $('#tidak_ditemukan').html('');
                    $('#total_pesanan').val(data.total_pesanan);
                }
                else if(data.status == "stok habis"){
                    alert('stok habis');
                    $('#tidak_ditemukan').html('');
                    $('#input_kode_barang').val("");
                }
                else{
                    $('#tidak_ditemukan').html('Barang tidak di temukan');
                }
            }
        })
    }

    function pilih_barang(kode_barang){
        get_barang(kode_barang);
        $('#modal-cari-barang').modal('hide');
    }

    function hapus_pesanan(id){
        $.ajax({
            type: "GET",
            url: "{{url('/')}}/penjualan/hapus-pesanan/"+id,
            success:function(data){
                $('#row_pesanan'+id).remove();
                get_total_harga_pesanan(nota['id']);
            }
        })
    }

    function show_input_ubah_jumlah_pesanan(id){
        var jumlah = parseInt($('#jumlah_pesanan'+id).val());
        var html = "<input class='form-control' type='number' id='input_jumlah_pesanan"+id+"' onkeydown='post_jumlah_pesanan("+id+")' value='"+jumlah+"'>";
        $('#tdata_nota'+id).html(html);
    }

    function show_input_ubah_harga_satuan(id){
        $.ajax({
            type: "get",
            url: "{{url('/')}}/get-pesanan/"+id,
            success:function(data){
                console.log(data);
                html = "<input class='form-control' type='number' id='input_harga_satuan"+id+"' onkeydown='post_harga_satuan("+id+")' value='"+data.pesanan['harga']+"'>";
                $('#tdata_harga_satuan'+id).html(html);
            }
        })
    }

    function post_jumlah_pesanan(id){
        var jumlah = $('#input_jumlah_pesanan'+id).val();
        if (event.keyCode === 13) {
            console.log(nota);
            ajax_post_ubah_jumlah_pesanan(id, jumlah);
            get_total_harga_pesanan(nota['id']);
        }
    }

    function post_harga_satuan(id){
        var harga = $('#input_harga_satuan'+id).val();
        if(event.keyCode === 13){
            ajax_ubah_harga_satuan(id, harga);
            get_total_harga_pesanan(nota['id']);
        }
    }

    function ajax_ubah_harga_satuan(id, harga_satuan){
        $.ajax({
            type: "post",
            url: "{{url('/')}}/penjualan/ubah-harga-satuan",
            data: {'id': id, 'harga_satuan':harga_satuan, "_token": "{{ csrf_token() }}"},
            success:function(data){

                html = '<input class="form-control" type="number" id="pesanan_'+id+'" readonly value="'+harga_satuan+'" style="cursor: pointer;" ondblclick="show_input_ubah_harga_satuan('+id+')">';
                $('#tdata_harga_satuan'+id).html(html);
                total_sub_pesanan(data.pesanan['jumlah'], id);
            }
        })
    }

    function ajax_post_ubah_jumlah_pesanan(id, jumlah){
        console.log(id);
        console.log(jumlah);
        $.ajax({
            type: "post",
            url: "{{url('/')}}/penjualan/ubah-jumlah-pesanan",
            data: {'id_pesanan':id, 'jumlah':jumlah, "_token": "{{ csrf_token() }}"},
            success:function(data){
                console.log(data);
                var html = '<input class="form-control" type="number" id="jumlah_pesanan'+id+'" readonly value="'+data.jumlah+'" style="cursor: pointer;" ondblclick="show_input_ubah_jumlah_pesanan('+id+')">';
                if(data.status == 'sukses'){                
                    $('#tdata_nota'+id).html(html);
                    total_sub_pesanan(data.jumlah, id)
                }
                else{
                    $('#tdata_nota'+id).html(html);
                    total_sub_pesanan(data.jumlah, id)
                    alert(data.status);
                }
                
            }
        })
    }

    function total_sub_pesanan(jumlah, id){
        var harga_satuan = parseInt($('#pesanan_'+id).val());
        var total_harga = "Rp. " + jumlah * harga_satuan;
        $('#tdata_total_sub_pesanan'+id).html(total_harga);
    }

    function get_total_harga_pesanan(id_nota){
        $.ajax({
            type: "get",
            url: "{{url('/')}}/get-total-harga-nota/"+id_nota,
            success:function(data){

                var total_pesanan = "Rp. " + data.total_pesanan;
                $('#total_pesanan').val(total_pesanan);
            }
        })
    }

    function checkout(id){
        window.open("/checkout-nota/"+id, "_blank");
        window.location.href = "/penjualan";
        
    }
</script>