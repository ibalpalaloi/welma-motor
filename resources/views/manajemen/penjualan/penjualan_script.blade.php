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
</script>