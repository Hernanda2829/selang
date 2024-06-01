<!DOCTYPE html>
<html lang="en">

<head>
    <?php 
	error_reporting(0);
    $userid=$userid->row_array();
    ?>  
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Produk By <?php echo $userid['co_name'];?>">
    <meta name="author" content="<?php echo $userid['co_name'];?>">

    <title>Data Terima/Konfirm Stok</title>
    <link rel="shortcut icon" href="<?php echo base_url().'assets/img/'. $userid['co_imgicon']; ?>" alt="#no image#" type="image/x-icon">
    <!-- Bootstrap Core CSS -->
    <link href="<?php echo base_url().'assets/css/bootstrap.min.css'?>" rel="stylesheet">
	<link href="<?php echo base_url().'assets/css/style.css'?>" rel="stylesheet">
	<link href="<?php echo base_url().'assets/css/font-awesome.css'?>" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?php echo base_url().'assets/css/4-col-portfolio.css'?>" rel="stylesheet">
    <link href="<?php echo base_url().'assets/css/dataTables.bootstrap.min.css'?>" rel="stylesheet">
    <link href="<?php echo base_url().'assets/css/jquery.dataTables.min.css'?>" rel="stylesheet">
    

</head>
<body>
    <!-- Navigation -->
   <?php 
        $this->load->view('admin/menu');
   ?>

    <!-- Page Content -->
    <div class="container">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <center><?php echo $this->session->flashdata('msg');?></center>
                <h3 class="page-header">Data
                    <small>Terima/Konfirm Stok - <?php echo $userid['reg_code'];?>  <?php echo $userid['reg_name'];?></small>
                </h3>
            </div>
        </div>
        <!-- /.row -->
        <!-- Projects Row -->
        <div class="row">
            <div class="col-lg-12">
            <table class="table table-bordered table-condensed" style="font-size:11px;" id="mydata">
                <thead>
                    <tr>
                        <th style="text-align:center;width:40px;">No</th>
                        <th style="text-align:center;">No Transfer</th>
                        <th style="text-align:center;">Tanggal Transfer/Kirim</th>
                        <th style="text-align:center;">Cabang Pengirim</th>
                        <th style="text-align:center;">Tanggal Konfirm</th>
                        <th style="width:200px;text-align:center;" data-orderable="false">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                    $no=0;
                    foreach ($data->result_array() as $a):
                        $no++;
                        $stokno=$a['trans_stok_no'];
                        $tgl=$a['trans_stok_tgl'];
                        $reg_pengirim=$a['trans_reg_id'];
                        $cab_pengirim=$a['reg_name'];
                        $pk=$a['proses_konfirm'];
                        $ts=$a['total_selisih'];
                        $tglk=$a['tgl_konfirm'];
                        
                ?>
                    <tr>
                        <td style="text-align:center;"><?php echo $no;?></td>
                        <td><?php echo $stokno;?></td>
                        <td><?php echo $tgl;?></td>
                        <td><?php echo $cab_pengirim;?></td>
                        <td><?php echo $tglk;?></td>
                        <td style="text-align:center;">                        
                        <?php
                            if ($pk == 0) {
                                echo '<a class="btn btn-xs btn-success btn-tampil" href="#modalKonfirm" data-toggle="modal" data-stokno="' . $stokno . '" data-nmcab="' . $cab_pengirim . '" data-tgl="' . htmlspecialchars($tgl) . '" data-tgl2="' . htmlspecialchars($tglk) . '" title="Lihat Detail Konfirm"><span class="fa fa fa-thumbs-up"></span> Konfirm Stok</a> ';
                            } else {
                                if ($ts == 0) {
                                    echo '<a class="btn btn-xs btn-info btn-komplit" href="#modalKomplit" data-toggle="modal" data-stokno="' . $stokno . '" data-nmcab="' . $cab_pengirim . '" data-tgl="' . htmlspecialchars($tgl) . '" data-tgl2="' . htmlspecialchars($tglk) . '" title="Lihat Komplit Konfirm"><span class="fa fa-book"></span> Status Komplit</a> ';
                                } else {
                                    echo '<a class="btn btn-xs btn-danger btn-komplit" href="#modalKomplit" data-toggle="modal" data-stokno="' . $stokno . '" data-nmcab="' . $cab_pengirim . '" data-tgl="' . htmlspecialchars($tgl) . '" data-tgl2="' . htmlspecialchars($tglk) . '" title="Status Komplit dengan Total Selisih : ' . $ts . '"><span class="fa fa-book"></span> Status Komplit</a> ';
                                }
                            }
                        ?>
                        </td>
                    </tr>
                <?php endforeach;?>
                </tbody>
            </table>
            </div>
        </div>
        
        <!-- ============ MODAL Komplit =============== -->
        <div class="modal fade" id="modalKomplit" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
            <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 class="modal-title" id="myModalLabel"><small>Data Terima/Konfirm Stok Barang - <?php echo $userid['reg_code'];?>  <?php echo $userid['reg_name'];?></small></h3>
            </div>    
            <div class="modal-body" style="overflow:scroll;height:400px;">  
                <input type="hidden" id="txtstoknoK" name="txtstoknoK">
                <table style="font-size:11px;width:100%;">
                    <tr>
                        <th style="text-align:left;width:15%;">No Transfer</th>
                        <th style="text-align:center;width:2%;">:</th>
                        <th style="text-align:left;width:20%;"><span id="stoknoVal2" style="color: green;"></span></th>
                        <th style="text-align:left;max-width:5%;"></th>
                        <th style="text-align:right;width:20%;">Tanggal Kirim</th>
                        <th style="text-align:center;width:2%;">:</th>
                        <th style="text-align:right;width:15%;padding-right:5px"><span id="tgl1Val2" style="color: green;"></span></th>
                    </tr>
                    <tr>
                        <th style="text-align:left;width:15%;">Cabang Pengirim</th>
                        <th style="text-align:center;width:2%;">:</th>
                        <th style="text-align:left;width:20%;"><span id="cabpengirimVal2" style="color: green;"></span></th>
                        <th style="text-align:left;max-width:5%;"></th>
                        <th style="text-align:right;width:20%;">Tanggal Konfirm</th>
                        <th style="text-align:center;width:2%;">:</th>
                        <th style="text-align:right;width:15%;padding-right:5px"><span id="tgl2Val2" style="color: green;"></span></th>   
                    </tr>
                </table>                
                <table id="tbl_komplit" class="table table-bordered table-condensed" style="font-size:11px;">
                    <thead>
                        <tr>
                            <th style="text-align:center;">No</th>
                            <th style="text-align:center;">Qty Kirim</th>
                            <th style="text-align:center;">Qty Konfirm</th>
                            <th style="text-align:center;">Qty Selisih</th>
                            <th style="text-align:center;">Kode Barang</th>
                            <th style="text-align:center;">Nama Barang</th>
                            <th style="text-align:center;">Satuan</th>
                            <th style="text-align:center;">Kategori</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>          
                </div>
                <div class="modal-footer" style="display: flex; align-items: center; justify-content: space-between;">
                    <a class="btn btn-info btn-cetak_komplit" title="Tampil Cetak Terima/Konfirm Stok"><span class="fa fa-print"></span> Cetak</a>
                    <div style="display: flex; margin-left: auto;">
                        <button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
                    </div>
                </div>
            </div>
            </div>
        </div>
    


        <!-- ============ MODAL Tampil Konfirm Stok=============== -->
        <div class="modal fade" id="modalKonfirm" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
            <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3 class="modal-title" id="myModalLabel"><small>Data Terima/Konfirm Stok Barang - <?php echo $userid['reg_code'];?>  <?php echo $userid['reg_name'];?></small></h3>
                </div>    
                <div class="modal-body" style="overflow:scroll;height:400px;">
                    <input type="hidden" id="txtstokno" name="txtstokno">
                    <table id="tbl_info" style="font-size:11px;width:100%;">
                    <tr>
                        <th style="text-align:left;width:15%;">No Transfer</th>
                        <th style="text-align:center;width:2%;">:</th>
                        <th style="text-align:left;width:20%;"><span id="stoknoVal" style="color: green;"></span></th>
                        <th style="text-align:left;max-width:5%;"></th>
                        <th style="text-align:right;width:20%;"></th>
                        <th style="text-align:center;width:2%;"></th>
                        <th style="text-align:right;width:15%;padding-right:5px"></th>
                    </tr>
                    <tr>
                        <th style="text-align:left;width:15%;">Cabang Pengirim</th>
                        <th style="text-align:center;width:2%;">:</th>
                        <th style="text-align:left;width:20%;"><span id="cabpengirimVal" style="color: green;"></span></th>
                        <th style="text-align:left;max-width:5%;"></th>
                        <th style="text-align:right;width:20%;">Tanggal Kirim</th>
                        <th style="text-align:center;width:2%;">:</th>
                        <th style="text-align:right;width:15%;padding-right:5px"><span id="tgl1Val1" style="color: green;"></span></th>   
                    </tr>
                    </table> 
                    <table id="tbl_konfirm" class="table table-bordered table-condensed" style="font-size:11px;">
                        <thead>
                            <tr>
                                <th style="text-align:center;">No</th>
                                <th style="text-align:center;">Qty Kirim</th>
                                <th style="text-align:center;">Qty Konfirm</th>
                                <th style="text-align:center;">Kode Barang</th>
                                <th style="text-align:center;">Nama Barang</th>
                                <th style="text-align:center;">Satuan</th>
                                <th style="text-align:center;">Kategori</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>          
                </div>
                <div class="modal-footer" style="display: flex; align-items: center; justify-content: space-between;">
                    <a class="btn btn-info btn-cetak_terima" title="Tampil Cetak Terima/Konfirm Stok"><span class="fa fa-print"></span> Cetak</a>
                    <div style="display: flex; margin-left: auto;">
                        <button class="btn btn-info btn-konfirm">Simpan</button>
                        <button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
                    </div>
                </div>
            </div>
            </div>
        </div>
        

        <!--END MODAL-->

        <hr>

        <!-- Footer -->
        <footer>
            <div class="row">
                <div class="col-lg-12">
                    <p style="text-align:center;"><?php echo $userid['co_copyright'];?></p>
                </div>
            </div>
            <!-- /.row -->
        </footer>

    </div>
    <!-- /.container -->

    <!-- jQuery -->
    <script src="<?php echo base_url().'assets/js/jquery.js'?>"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo base_url().'assets/js/bootstrap.min.js'?>"></script>
    <script src="<?php echo base_url().'assets/js/jquery.dataTables.min.js'?>"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#mydata').DataTable();
            //$('#mydata2').DataTable();
        } );
    </script>
    

<script type="text/javascript">
$(document).ready(function() {
    $(document).on('click', '.btn-cetak_terima', function() {
        var stokno = $('#txtstokno').val();
        var href = "<?php echo base_url().'admin/transfer_stok/cetak_terima/'; ?>" + stokno;
        window.open(href, '_blank');
    });
    $(document).on('click', '.btn-cetak_komplit', function() {
        var stokno = $('#txtstoknoK').val();
        var href = "<?php echo base_url().'admin/transfer_stok/cetak_terima_komplit/'; ?>" + stokno;
        window.open(href, '_blank');
    });

});
</script>

<script type="text/javascript">
$(document).ready(function () {
    $(document).on('click', '.btn-komplit', function () {
        var stokno = $(this).data('stokno');
        var nmcab = $(this).data('nmcab');
        var tgl1 = $(this).data('tgl');
        var tgl2 = $(this).data('tgl2');   
        $('#txtstoknoK').val(stokno);
        $('#stoknoVal2').text(stokno);
        $('#cabpengirimVal2').text(nmcab);
        $('#tgl1Val2').text(tgl1);
        $('#tgl2Val2').text(tgl2);
        tampil_komplit();
    });

    function tampil_komplit() {
        $('#tbl_komplit tbody').empty();
        var stokno=$('#txtstoknoK').val();
        $.ajax({
            url: "<?php echo base_url().'admin/transfer_stok/get_transtok';?>",
            type: "POST",
            data: {              
                stokno: stokno
            },
            success: function (data) {
                //console.log("Data from server:", data);
                //console.log(stokno);
                try {
                    var parsedData = JSON.parse(data);
                    if ("error" in parsedData) {
                        console.log(parsedData.error); // Tampilkan pesan error
                    } else if (parsedData.length !== 0) {
                        var no=0;
                        $.each(parsedData, function (index, item) {
                                no++;
                                var k_qty = parseFloat(item.kirim_qty);
                                var kon_qty = parseFloat(item.konfirm_qty);
                                var sel_qty = parseFloat(item.selisih_qty);
                                var warna;
                                if (sel_qty >0) {
                                    warna=";color:red;";
                                }else{
                                    warna="";
                                }
                                var formatted_k_qty;
                                if (Math.floor(k_qty) === k_qty) {
                                    formatted_k_qty = k_qty.toLocaleString('id-ID', { maximumFractionDigits: 0 });
                                } else {
                                    formatted_k_qty = k_qty.toLocaleString('id-ID', { maximumFractionDigits: 2 });
                                    formatted_k_qty = formatted_k_qty.replace(/\.?0+$/, ''); // Menghilangkan nol di belakang desimal
                                }
                                var formatted_kon_qty;
                                if (Math.floor(kon_qty) === kon_qty) {
                                    formatted_kon_qty = kon_qty.toLocaleString('id-ID', { maximumFractionDigits: 0 });
                                } else {
                                    formatted_kon_qty = kon_qty.toLocaleString('id-ID', { maximumFractionDigits: 2 });
                                    formatted_kon_qty = formatted_kon_qty.replace(/\.?0+$/, ''); // Menghilangkan nol di belakang desimal
                                }
                                var formatted_sel_qty;
                                if (Math.floor(sel_qty) === sel_qty) {
                                    formatted_sel_qty = sel_qty.toLocaleString('id-ID', { maximumFractionDigits: 0 });
                                } else {
                                    formatted_sel_qty = sel_qty.toLocaleString('id-ID', { maximumFractionDigits: 2 });
                                    formatted_sel_qty = formatted_sel_qty.replace(/\.?0+$/, ''); // Menghilangkan nol di belakang desimal
                                }

                                var newRow = '<tr>' +
                                    '<td style="font-size:11px;text-align:center;">' + no + '</td>' +
                                    '<td style="font-size:11px;text-align:center;">' + formatted_k_qty + '</td>' +
                                    '<td style="font-size:11px;text-align:center;">' + formatted_kon_qty + '</td>' +
                                    '<td style="font-size:11px;text-align:center;'+ warna + '">' + formatted_sel_qty + '</td>' +
                                    '<td style="font-size:11px;">' + item.d_barang_id + '</td>' +
                                    '<td style="font-size:11px;">' + item.d_barang_nama + '</td>' +
                                    '<td style="font-size:11px;text-align:center;">' + item.d_barang_satuan + '</td>' +
                                    '<td style="font-size:11px;text-align:center;">' + item.d_kategori_nama + '</td>' +
                                    '</tr>';
                                $('#tbl_komplit tbody').append(newRow);

                        });
                        
                    } else {
                        console.log("No data found.");
                    }
                } catch (error) {
                    console.error("Error parsing JSON:", error);
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX error:", error);
            }
        });
    }


});
</script>

<script type="text/javascript">
$(document).ready(function () {
    $(document).on('click', '.btn-tampil', function () {
        var stokno = $(this).data('stokno');
        var nmcab = $(this).data('nmcab');
        var tgl1 = $(this).data('tgl');   
        $('#txtstokno').val(stokno);
        $('#stoknoVal').text(stokno);
        $('#cabpengirimVal').text(nmcab);
        $('#tgl1Val1').text(tgl1);
        tampil_konfirm();
    });

    function tampil_konfirm() {
        $('#tbl_konfirm tbody').empty();
        var stokno = $('#txtstokno').val();
        $.ajax({
            url: "<?php echo base_url().'admin/transfer_stok/get_transtok';?>",
            type: "POST",
            data: {
                stokno: stokno
            },
            success: function(data) {
                try {
                    var parsedData = JSON.parse(data);
                    if ("error" in parsedData) {
                        console.log(parsedData.error);
                    } else if (parsedData.length !== 0) {
                        var no = 0;
                        $.each(parsedData, function(index, item) {
                            no++;
                            var k_qty = parseFloat(item.kirim_qty);
                            var formatted_k_qty;
                            if (Math.floor(k_qty) === k_qty) {
                                formatted_k_qty = k_qty.toLocaleString('id-ID', { maximumFractionDigits: 0 });
                            } else {
                                formatted_k_qty = k_qty.toLocaleString('id-ID', { maximumFractionDigits: 2 });
                                formatted_k_qty = formatted_k_qty.replace(/\.?0+$/, ''); // Menghilangkan nol di belakang desimal
                            }
                            var newRow = '<tr>' +
                                '<td style="font-size:11px;text-align:center;">' + no + '</td>' +
                                '<td style="font-size:11px;text-align:center;">' + formatted_k_qty + '</td>' +
                                '<td style="font-size:11px;text-align:center;">' +
                                '<input type="hidden" name="stokno' + item.d_trans_stok_id + '" value="' + item.d_trans_stok_no + '">' +
                                '<input type="hidden" name="stokid' + item.d_trans_stok_id + '" value="' + item.d_trans_stok_id + '">' +
                                '<input type="hidden" name="k_qty' + item.d_trans_stok_id + '" value="' + item.kirim_qty + '">' +
                                '<input type="text" name="kon_qty' + item.d_trans_stok_id + '" style="width:70px;" value="' + formatted_k_qty + '" min="0" max="' + formatted_k_qty + '" required>' +
                                '</td>' +
                                '<td style="font-size:11px;">' + item.d_barang_id + '</td>' +
                                '<td style="font-size:11px;">' + item.d_barang_nama + '</td>' +
                                '<td style="font-size:11px;text-align:center;">' + item.d_barang_satuan + '</td>' +
                                '<td style="font-size:11px;text-align:center;">' + item.d_kategori_nama + '</td>' +
                                '</tr>';
                            $('#tbl_konfirm tbody').append(newRow);
                        });

                        $(document).on('input', 'input[name^="kon_qty"]', function(e) {
                            var inputValue = e.target.value;
                            //var sanitizedValue = inputValue.replace(/[^0-9,\b\t]/g, ''); // Hapus karakter yang tidak diizinkan (selain angka, koma, backspace, delete, dan tab)
                            var sanitizedValue = inputValue.replace(/[^\d,\b\t]/g, '')
                            e.target.value = sanitizedValue; // Update nilai input dengan karakter yang diizinkan
                        });

                        // membatasi input qty sesuai stok yang tersedia
                        var inputElements = document.querySelectorAll('input[name^="kon_qty"]');
                        inputElements.forEach(function(inputElement) {
                            inputElement.addEventListener('input', function() {
                                var min = parseFloat(this.min.replace(',', '.'));
                                var maxFormatted = this.max.replace('.', ''); // Hilangkan titik sebagai pemisah ribuan
                                var max = parseFloat(maxFormatted.replace(',', '.')); // Parsing nilai maksimum dalam format yang benar
                                var value = parseFloat(this.value.replace(/\./g, '').replace(',', '.')); // Parsing dan memformat nilai input
                                if (isNaN(value)) {
                                    this.value = min;
                                } else if (value < min) {
                                    this.value = min;
                                } else if (value > max) {
                                    this.value = maxFormatted; // Tetapkan nilai maksimum dalam format yang benar
                                }
                            });
                        });


                    } else {
                        console.log("No data found.");
                    }
                } catch (error) {
                    console.error("Error parsing JSON:", error);
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX error:", error);
            }
        });
    }

    $(document).on('click', '.btn-konfirm', function () {
        var notrans = $('#txtstokno').val();
        // Mengumpulkan data dari input dalam tabel
        var data = [];
        var modal = $(this).closest('.modal');
        var rows = modal.find('#tbl_konfirm tbody tr');
        rows.each(function() {
            var row = $(this);
            var stokno = row.find('input[name^="stokno"]').val();
            var stokid = row.find('input[name^="stokid"]').val();
            var k_qty = row.find('input[name^="k_qty"]').val();
            var qty = row.find('input[name^="kon_qty"]').val();
            var kode_barang = row.find('td:eq(3)').text(); // Kolom kelima
            var nama_barang = row.find('td:eq(4)').text();
            var satuan = row.find('td:eq(5)').text();
            var kategori = row.find('td:eq(6)').text();
            data.push({
                stokno: stokno,
                stokid: stokid,
                k_qty: parseFloat(k_qty.replace(/\./g, '').replace(/,/g, '.')),
                qty: parseFloat(qty.replace(/\./g, '').replace(/,/g, '.')),
                sel_qty: parseFloat(k_qty.replace(/,/g, '.')) - parseFloat(qty.replace(/,/g, '.')),
                kode_barang: kode_barang,
                nama_barang: nama_barang,
                satuan: satuan,
                kategori: kategori
            });

        });
        // Kirim data ke server dengan AJAX
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url('admin/transfer_stok/simpan_konfirm_stok');?>",
            data: {
                requestData: data,
                notrans: notrans
            },
            success: function(response) {
                // Handle respons dari server jika diperlukan
                var jsonResponse = JSON.parse(response);
                alert(jsonResponse.message);
                modal.modal('hide'); // Menutup modal
                window.location.reload();
            },
            error: function(xhr, status, error) {
                // Tangani kesalahan jika diperlukan
                console.error(error);
                alert('Gagal menyimpan data.');
            }
        });
    });

});

</script>






</body>
</html>
