<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    @isset($nota) 
        var nota = {!! json_encode($nota) !!};
        $("#input_kode_barang").focus();
    @endisset

    document.addEventListener('keydown', e => {
        if(e.key == 'F10' && e.ctrlKey){
            checkout(nota['id']);
        }
    });

    $('#select_montir').change(function(){
        var id_montir = $('#select_montir').val();
        $.ajax({
            type: "POST",
            url: "{{url('/')}}/penjualan-ubah-montir",
            data: {'id_montir':id_montir, 'id_nota':nota['id']},
            success:function(data){
                console.log('ubah montir')
                toastr.success('Montir Berhasil Diubah', 'Berhasil', {timeOut: 5000})

            }
        })
    });

    function show_input_ubah_barang(id){
        console.log(id);
    }

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
            url: "{{url('/')}}/penjualan/get-barang?kode_barang="+kode_barang+"&id_nota="+nota['id'],
            success:function(data){
                console.log(data);
                if(data.status == "sukses"){
                    console.log(data);
                    $('#input_kode_barang').val("");
                    $('#tbody_daftar_nota').html(data.html);
                    $('#tidak_ditemukan').html('');
                    $('#total_pesanan').val(data.total_pesanan);
                    $('#input_kode_barang').val("");
                    $("#input_kode_barang").focus();
                    $('#tbody_modal_cari_barang').empty();
                    toastr.success('Data Berhasil Ditambahkan', 'Berhasil', {timeOut: 5000})

                }
                else if(data.status == "stok habis"){
                    toastr.warning('Stok Barang Habis', 'Pemberitahuan', {timeOut: 5000})
                    $('#tidak_ditemukan').html('');
                    $('#input_kode_barang').val("");
                }
                else{
                    toastr.warning('Barang Tidak Ditemukan', 'Pemberitahuan', {timeOut: 5000})
                    $('#tidak_ditemukan').html('Barang Tidak Ditemukan');
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
                toastr.success('Data Berhasil Terhapus', 'Berhasil', {timeOut: 5000})

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

    function show_input_ubah_nama_jasa(id){

        var nama_jasa = $('#nama_jasa'+id).val();

        // alert('tes');
        $.ajax({
            type: "get",
            url: "{{url('/')}}/get-pesanan/"+id,
            success:function(data){
                console.log(data);
                html = '<input  class="form-control" type="text" id="input_nama_jasa'+id+'" onkeydown="post_nama_jasa('+id+')" value="'+data.pesanan['nama_barang']+'">';
                $('#tdata_nama_jasa'+id).html(html);
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
            toastr.success('Harga Berhasil Diubah', 'Berhasil', {timeOut: 5000})

        }
    }

    function post_nama_jasa(id){
        var nama = $('#input_nama_jasa'+id).val();
        if(event.keyCode === 13){
            ajax_ubah_nama_jasa(id, nama);
            toastr.success('Nama Jasa Berhasil Diubah', 'Berhasil', {timeOut: 5000})
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


    function ajax_ubah_nama_jasa(id, nama){
        $.ajax({
            type: "post",
            url: "{{url('/')}}/penjualan/ubah-nama-jasa",
            data: {'id': id, 'nama_jasa':nama, "_token": "{{ csrf_token() }}"},
            success:function(data){
                html ='<input type="text" id="nama_jasa'+id+'" class="form-control-plaintext p-0" style="cursor: pointer;"  value="'+nama+'" readonly  ondblclick="show_input_ubah_nama_jasa('+id+')">'; 
                $('#tdata_nama_jasa'+id).html(html);
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
                    toastr.success('Jumlah Pesanan Berhasil Diubah', 'Berhasil', {timeOut: 5000})
                }
                else{
                    $('#tdata_nota'+id).html(html);
                    total_sub_pesanan(data.jumlah, id)
                    toastr.info(data.status, 'Pemberitahuan', {timeOut: 5000})
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