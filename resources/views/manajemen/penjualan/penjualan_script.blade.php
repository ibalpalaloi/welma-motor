<script>
    var nota = {!! json_encode($nota) !!};
    $(function(){
        $('#datepicker').datepicker();
    });

    function modal_tambah_nota(){
        $('#modal-tambah-nota.modal').modal('show');
    }

    $("#input_kode_barang").on('input', function(){
        var kode_barang = $('#input_kode_barang').val();
        get_barang(kode_barang);
    })

    function pilih_nama_pembeli(id_nota){
        window.location.replace("/penjualan-barang?id_nota="+id_nota);
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
            url: "/penjualan/cari-barang?keyword="+keyword,
            success:function(data){
                $('#tbody_modal_cari_barang').empty();
                $('#tbody_modal_cari_barang').append(data.view);
            }
        })
    }

    function get_barang(kode_barang){
        $.ajax({
            type: "get",
            url: "/get-barang?kode_barang="+kode_barang+"&id_nota="+nota['id'],
            success:function(data){
                console.log(data);
                if(data.status == "sukses"){
                    var barang = data.barang;
                    console.log(barang);
                    var tabel = "";
                    tabel += "<tr>";
                    tabel += "<td>"+barang['nama_barang']+"</td>";
                    tabel += "<td>"+barang['harga']+"</td>";
                    tabel += "<td>1</td>";
                    tabel += "<td>"+barang['harga']+"</td>";
                    $('#tbody_daftar_nota').append(tabel);
                    $('#tidak_ditemukan').html('');
                    $('#total_pesanan').val(data.total_pesanan);
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
            url: "/penjualan/hapus-pesanan/"+id,
            success:function(data){
                $('#row_pesanan'+id).remove();
            }
        })
    }

    function show_input_ubah_jumlah_pesanan(id){
        var jumlah = parseInt($('#jumlah_pesanan'+id).html());
        var html = "<input type='number' id='input_jumlah_pesanan"+id+"' onkeydown='post_jumlah_pesanan("+id+")' value='"+jumlah+"'>";
        $('#tdata_nota'+id).html(html);
    }

    function post_jumlah_pesanan(id){
        var jumlah = $('#input_jumlah_pesanan'+id).val();
        if (event.keyCode === 13) {
            console.log(jumlah);
            ajax_post_ubah_jumlah_pesanan(id, jumlah);
            get_total_harga_pesanan(nota['id']);
            total_sub_pesanan(jumlah, id)
        }
    }

    function ajax_post_ubah_jumlah_pesanan(id, jumlah){
        $.ajax({
            type: "post",
            url: "/penjualan/ubah-jumlah-pesanan",
            data: {'id_pesanan':id, 'jumlah':jumlah, "_token": "{{ csrf_token() }}"},
            success:function(data){
                console.log(data);
                var html = "<a href='#' ondblclick='show_input_ubah_jumlah_pesanan("+id+")' id='jumlah_pesanan"+id+"'>"+data.jumlah+"</a>";
                $('#tdata_nota'+id).html(html);
            }
        })
    }

    function total_sub_pesanan(jumlah, id){
        var harga_satuan = parseInt($('#tdata_harga_satuan'+id).html());
        var total_harga = jumlah * harga_satuan;
        $('#tdata_total_sub_pesanan'+id).html(total_harga);
    }

    function get_total_harga_pesanan(id_nota){
        $.ajax({
            type: "get",
            url: "/get-total-harga-nota/"+id_nota,
            success:function(data){
                $('#total_pesanan').val(data.total_pesanan);
            }
        })
    }
</script>