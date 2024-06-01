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

    <title>Data Transfer Stok</title>
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
                    <small>Transfer Stok - <?php echo $userid['reg_code'];?>  <?php echo $userid['reg_name'];?></small>
                    <div class="pull-right"><a href="<?php echo base_url().'admin/transfer_stok'?>" class="btn btn-sm btn-success"><span class="fa fa-plus"></span> Buat Transfer Stok Baru</a></div>
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
                        <th style="text-align:center;">Cabang Penerima</th>
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
                        $reg_terima=$a['regid_terima'];
                        $cab_terima=$a['reg_name'];
                        $pk=$a['proses_konfirm'];
                        $ts=$a['total_selisih'];
                        $tglk=$a['tgl_konfirm'];
                ?>
                    <tr>
                        <td style="text-align:center;"><?php echo $no;?></td>
                        <td><?php echo $stokno;?></td>
                        <td><?php echo $tgl;?></td>
                        <td><?php echo $cab_terima;?></td>
                        <td><?php echo $tglk;?></td>
                        <td style="text-align:center;">                        
                        <?php
                            if ($pk == 0) {
                                echo '<a class="btn btn-xs btn-warning btn-tampil" href="#modalTampilStok" data-toggle="modal" data-stokno="' . $stokno . '" data-nmcab="' . $cab_terima . '" data-tgl="' . htmlspecialchars($tgl) . '" data-regcab="' . $reg_terima . '" data-tgl2="' . htmlspecialchars($tglk) . '" title="Lihat Detail Transfer"><span class="fa fa-book"></span> Tampil Data</a> ';
                                echo '<a class="btn btn-xs btn-danger btn-tampilhapustranstok" href="#modalHapusTranstok" data-toggle="modal" data-stokno="' . $stokno . '" data-nmcab="' . $cab_terima . '" title="Hapus Transfer Stok"><span class="fa fa-close"></span> Hapus Data </a>';
                            } else {
                                if ($ts == 0) {
                                    echo '<a class="btn btn-xs btn-info btn-komplit" href="#modalKomplit" data-toggle="modal" data-stokno="' . $stokno . '" data-nmcab="' . $cab_terima . '" data-tgl="' . htmlspecialchars($tgl) . '" data-tgl2="' . htmlspecialchars($tglk) . '" title="Lihat Komplit Transfer"><span class="fa fa-book"></span> Status Komplit</a> ';
                                } else {
                                    echo '<a class="btn btn-xs btn-danger btn-komplit" href="#modalKomplit" data-toggle="modal" data-stokno="' . $stokno . '" data-nmcab="' . $cab_terima . '" data-tgl="' . htmlspecialchars($tgl) . '" data-tgl2="' . htmlspecialchars($tglk) . '" title="Status Komplit dengan Total Selisih : ' . $ts . '"><span class="fa fa-book"></span> Status Komplit</a> ';
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
        <!-- /.row -->

        <!-- ============ MODAL Komplit =============== -->
        <div class="modal fade" id="modalKomplit" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
            <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 class="modal-title" id="myModalLabel"><small>Data Transfer Stok Barang - <?php echo $userid['reg_code'];?>  <?php echo $userid['reg_name'];?></small></h3>
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
                        <th style="text-align:left;width:15%;">Cabang Penerima</th>
                        <th style="text-align:center;width:2%;">:</th>
                        <th style="text-align:left;width:20%;"><span id="cabterimaVal2" style="color: green;"></span></th>
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
                    <a class="btn btn-info btn-cetak_komplit" title="Tampil Cetak Data Transfer Stok"><span class="fa fa-print"></span> Cetak</a>
                    <div style="display: flex; margin-left: auto;">
                        <button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
                    </div>
                </div>
            </div>
            </div>
        </div>
        
        
        <!-- ============ MODAL Tampil Transfer Stok=============== -->
        <div class="modal fade" id="modalTampilStok" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
            <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3 class="modal-title" id="myModalLabel"><small>Data Transfer Stok Barang - <?php echo $userid['reg_code'];?>  <?php echo $userid['reg_name'];?></small></h3>
                </div>    
                <div class="modal-body" style="overflow:scroll;height:400px;">  
                    <div class="pull-right" style="margin-bottom: 5px;">
                        <a href="#modalAddEdit" data-toggle="modal" title="Tambah Data Produk" class="btn btn-xs btn-success btn-addtampilstok">
                        <span class="fa fa-plus"></span> Tambah Transfer Stok</a>
                    </div>
                    <input type="hidden" id="txtstoknoE" name="txtstoknoE">
                    <input type="hidden" id="txttglE" name="txttglE">
                    <input type="hidden" id="txtregidE" name="txtregidE">
                    <p style="font-size:11px;margin-bottom:0;"><b>No Transfer : <span id="stoknoVal" style="color: green;"></span></b></p>
                    <p style="font-size:11px;margin-bottom:0;"><b>Cabang Penerima : <span id="cabterimaVal" style="color: green;"></span></b></p>
                    <table id="tbl_transtok" class="table table-bordered table-condensed" style="font-size:11px;">
                        <thead>
                            <tr>
                                <th style="text-align:center;">No</th>
                                <th style="text-align:center;">Kode Barang</th>
                                <th style="text-align:center;">Nama Barang</th>
                                <th style="text-align:center;">Satuan</th>
                                <th style="text-align:center;">Kategori</th>
                                <th style="text-align:center;">Qty Kirim</th>
                                <th style="text-align:center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>          
                </div>
                <div class="modal-footer" style="display: flex; align-items: center; justify-content: space-between;">
                    <a class="btn btn-info btn-cetak_kirim" title="Tampil Cetak Data Transfer Stok"><span class="fa fa-print"></span> Cetak</a>
                    <div style="display: flex; margin-left: auto;">
                        <button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
                    </div>
                </div>
            </div>
            </div>
        </div>
        
        <!-- ============ MODAL Add Tampil Stok =============== -->
        <div id="modalAddEdit" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3 class="modal-title" id="myModalLabel"><small>Tambah Data Produk - Transfer Stok Barang</small></h3>
                </div> 
                <!--<form class="form-horizontal" method="post" action="<?php echo base_url().'admin/transfer_stok/simpan_addtranstok'?>">-->
                    <div class="modal-body">
                        <table class="table table-bordered table-condensed" style="font-size:11px;margin-bottom:10px;">
                        <input type="hidden" id="txtstoknoA" name="txtstoknoA">
                        <input type="hidden" id="txttglA" name="txttglA">
                        <input type="hidden" id="txtregidA" name="txtregidA">
                        <tr>
                            <th style="width:150px;vertical-align:middle;">Kode Barang</th>
                            <td>
                                <div style="display:flex;align-items:center;">
                                    <input name="kdA" id="kdA" class="form-control input-sm" type="text" placeholder="Kode Barang" style="width:150px;" maxlength="15" required>
                                    <a class="btn btn-sm btn-success btn-cariproduk" style="margin-left:10px;font-size:11px;">Cari Produk !</a>
                                </div>
                            </td>     
                        </tr>
                        <tr>
                            <th style="width:150px;vertical-align:middle;">Nama Barang</th>
                            <td><input id="nmA" name="nmA" class="form-control input-sm" type="text" style="font-size:11px;width:400px;" readonly></td>     
                        </tr>
                        <tr>
                            <th style="width:150px;vertical-align:middle;">Satuan</th>
                            <td><input id="satA" name="satA" class="form-control input-sm" type="text" style="font-size:11px;width:150px;" readonly></td>     
                        </tr>
                        <tr>
                            <th style="width:150px;vertical-align:middle;">Kategori</th>
                            <td><input id="katA" name="katA" class="form-control input-sm" type="text" style="font-size:11px;width:150px;" readonly></td>     
                        </tr>
                        <tr>
                            <th style="width:150px;vertical-align:middle;">Stok tersedia</th>
                            <td><input id="stokA" name="stokA" class="form-control input-sm" type="text" style="font-size:11px;width:100px;" readonly></td>     
                        </tr>
                        <tr>
                            <th style="width:150px;vertical-align:middle;">Qty Kirim</th>
                            <td><input id="txtqtyA" name="txtqtyA" class="form-control input-sm" type="text" style="font-size:11px;width:100px;" required></td>     
                        </tr>
                        </table>
                            
                    </div>
                    <div class="modal-footer">
                        <!--<button type="submit" class="btn btn-info btn-addstok">Simpan</button> -->
                        <button class="btn btn-info btn-addstok">Simpan</button>
                        <button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
                    </div>
                <!--</form>-->
            </div>
        </div>
        </div>
            
        <!-- ============ MODAL Edit Tampil Stok=============== -->
        <div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3 class="modal-title" id="myModalLabel"><small>Edit Data Produk - Transfer Stok Barang </small></h3>
                </div>    
                <div class="modal-body">  
                    <table class="table table-bordered table-condensed" style="font-size:11px;margin-bottom:10px;">
                    <input type="hidden" id="txtnostokE" name="txtnostokE">
                    <input type="hidden" id="txtstokidE" name="txtstokidE">
                    <tr>
                        <th style="width:150px;vertical-align:middle;">Kode Barang</th>
                        <td><input id="kd" name="kd" class="form-control input-sm" type="text" style="font-size:11px;width:150px;" readonly></td>
                    </tr>
                    <tr>
                        <th style="width:150px;vertical-align:middle;">Nama Barang</th>
                        <td><input id="nm" name="nm" class="form-control input-sm" type="text" style="font-size:11px;width:400px;" readonly></td>     
                    </tr>
                    <tr>
                        <th style="width:150px;vertical-align:middle;">Satuan</th>
                        <td><input id="sat" name="sat" class="form-control input-sm" type="text" style="font-size:11px;width:150px;" readonly></td>     
                    </tr>
                    <tr>
                        <th style="width:150px;vertical-align:middle;">Kategori</th>
                        <td><input id="kat" name="kat" class="form-control input-sm" type="text" style="font-size:11px;width:150px;" readonly></td>     
                    </tr>
                    <tr>
                        <th style="width:150px;vertical-align:middle;">Stok Tersedia</th>
                        <td><input id="stok_qty" name="stok_qty" class="form-control input-sm" type="text" style="font-size:11px;width:100px;" readonly></td>     
                    </tr>
                    <tr>
                        <th style="width:150px;vertical-align:middle;">Qty Kirim</th>
                        <td><input id="qtyEdit" name="qtyEdit" class="form-control input-sm" type="text" style="font-size:11px;width:100px;" required></td>     
                    </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-info btn-update">Update</button>    
                    <button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
                </div>
            </div>
            </div>
        </div>
        
        <!-- ============ MODAL Hapus Tampil Stok =============== -->
        <div id="modalHapus" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 class="modal-title" id="myModalLabel"><small>Hapus Data Produk - Transfer Stok Barang</small></h3>
            </div>   
                <div class="modal-body">
                    <input type="hidden" id="txtstokidH" name="txtstokidH">
                    <input type="hidden" id="txtnostokH" name="txtnostokH">
                    <input type="hidden" id="kdH" name="kdH">

                    <p>Yakin mau menghapus data Kode Barang : <span id="kdValH" style="color: green;"></span></p>
                    <p>Nama Barang : <span id="nmbrgValH" style="color: green;"></span></p>
                    <p>Satuan : <span id="satValH" style="color: green;"></span></p>
                    <p>Kategori : <span id="katValH" style="color: green;"></span></p>
                    <p>Quantity Kirim : <span id="qtyValH" style="color: green;"></span></p>             
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger btn-hapus">Hapus</button>    
                    <button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
                </div>
        </div>
        </div>
        </div>
        

        <!-- ============ MODAL HAPUS TRANSFER STOK=============== -->               
        <div id="modalHapusTranstok" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 class="modal-title" id="myModalLabel"><small>Hapus Data Transfer Stok</small></h3>
            </div>
            <form class="form-horizontal" method="post" action="<?php echo base_url().'admin/transfer_stok/hapus_data_transtok'?>">
                <div class="modal-body">
                    <input type="hidden" id="txtkode" name="txtkode">
                    <p>Yakin mau menghapus Data <b> Transfer Stok </b> ini : <br>
                    No Transfer : <b><span id="stoknoValH"></span></b> <br>
                    Cabang Penerima : <b><span id="cabterimaValH"></span></b> <br>
                    </p>
                    <p> Proses ini akan mengembalikan nilai stok yang sudah berkurang. </p>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Hapus</button>
                    <button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
                </div>
            </form>
        </div>
        </div>
        </div>

        <!-- ============ MODAL FIND =============== -->
        <div class="modal fade" id="modalCari" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
            <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 class="modal-title" id="myModalLabel">Data Barang</h3>
            </div>
                <div class="modal-body" style="overflow:scroll;height:450px;">

                  <table class="table table-bordered table-condensed" style="font-size:11px;" id="mydata2">
                    <thead>
                        <tr>
                            <th style="text-align:center;width:40px;">No</th>
                            <th style="width:120px;">Kode Barang</th>
                            <th style="width:240px;">Nama Barang</th>
                            <th style="padding-left:5px;max-width:10px;text-align:center;vertical-align:middle;" data-orderable="false">Kode Disc</th>
                            <th>Satuan</th>
                            <th style="width:100px;">Harga Jual</th>
                            <th>Stok</th>
                            <th>Kategori</th>
                            <th style="width:100px;text-align:center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                        $no=0;
                        foreach ($brg->result_array() as $b):
                            $no++;
                            $id=$b['barang_id'];
                            $nm=$b['barang_nama'];
                            $disc_id=$b['barang_disc_id'];
                            $satuan=$b['barang_satuan'];
                            $harjul=$b['barang_harjul'];
                            $kategori=$b['barang_kategori_nama'];
                            $stok=$b['stok_cabang'];
                            if (floor($stok) == $stok) {
                                $formatted_stok = number_format($stok, 0, ',', '.');
                            } else {
                                $formatted_stok = number_format($stok, 2, ',', '.');
                                $formatted_stok = rtrim($formatted_stok, '0');
                                $formatted_stok = rtrim($formatted_stok, ',');
                            }   

                    ?>
                        <tr>
                            <td style="text-align:center;"><?php echo $no;?></td>
                            <td><?php echo $id;?></td>
                            <td><?php echo $nm;?></td>
                            <td style="text-align:center;"><?php echo $disc_id;?></td>
                            <td style="text-align:center;"><?php echo $satuan;?></td>
                            <td style="text-align:right;"><?php echo 'Rp ' . str_replace(',', '.', number_format($harjul)); ?></td>
                            <td style="text-align:center;"><?php echo $formatted_stok;?></td>
                            <td style="text-align:center;"><?php echo $kategori;?></td>
                            <td style="text-align:center;">
                            <button type="submit" class="btn btn-xs btn-info" title="Pilih" onclick="pilihKode('<?php echo $id?>')"><span class="fa fa-edit"></span> Pilih</button>
                            </td>
                        </tr>
                    <?php endforeach;?>
                    </tbody>
                </table>          
                </div>
                <div class="modal-footer">
                    <button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>    
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
            $('#mydata2').DataTable();
        } );
    </script>
    

<script type="text/javascript">
$(document).ready(function() {
    $(document).on('input', 'input[name^="qty"]', function(e) {
        var inputValue = e.target.value;
        //var sanitizedValue = inputValue.replace(/[^0-9,\b\t]/g, ''); // Hapus karakter yang tidak diizinkan (selain angka, koma, backspace, delete, dan tab)
        var sanitizedValue = inputValue.replace(/[^\d,\b\t]/g, '')
        e.target.value = sanitizedValue; // Update nilai input dengan karakter yang diizinkan
    });

    $(document).on('blur', 'input[name^="qty"]', function(e) {
        var numericValue = parseFloat(e.target.value.replace(',', '.')) || 0;
        if (numericValue <= 0) {    // Periksa apakah nilai adalah 0 atau kurang dari 0
            $(this).val(''); // Mengosongkan nilai input yang sedang berfokus
            alert("Nilai harus lebih besar dari 0");    // Jika nilai adalah 0 atau kurang dari 0, berikan pesan kesalahan
            setTimeout(function() {
                $(this).focus(); // Tambahkan delay untuk memastikan pengaturan fokus berhasil
            }.bind(this), 0);
        }
    });

    // membatasi input qty sesuai stok yang tersedia
    var inputElements = document.querySelectorAll('input[name^="qty"]');
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


    $(document).on('input', 'input[name^="txtqtyA"]', function(e) {
        var inputValue = e.target.value;
        //var sanitizedValue = inputValue.replace(/[^0-9,\b\t]/g, ''); // Hapus karakter yang tidak diizinkan (selain angka, koma, backspace, delete, dan tab)
        var sanitizedValue = inputValue.replace(/[^\d,\b\t]/g, '')
        e.target.value = sanitizedValue; // Update nilai input dengan karakter yang diizinkan
    });

    
    // membatasi input qty sesuai stok yang tersedia
    var inputElements = document.querySelectorAll('input[name^="txtqtyA"]');
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

    
});

    $(document).on('click', '.btn-cetak_kirim', function() {
        var stokno = $('#txtstoknoE').val();
        var href = "<?php echo base_url().'admin/transfer_stok/cetak_kirim/'; ?>" + stokno;
        window.open(href, '_blank');
    });
    $(document).on('click', '.btn-cetak_komplit', function() {
        var stokno = $('#txtstoknoK').val();
        var href = "<?php echo base_url().'admin/transfer_stok/cetak_kirim_komplit/'; ?>" + stokno;
        window.open(href, '_blank');
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
        $('#cabterimaVal2').text(nmcab);
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
                                    '<td style="font-size:11px;text-align:center;' + warna + '">' + formatted_sel_qty + '</td>' +
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
        var tgl = $(this).data('tgl');
        var regcab = $(this).data('regcab');
        $('#txtstoknoE').val(stokno);
        $('#txttglE').val(tgl);
        $('#txtregidE').val(regcab);
        $('#stoknoVal').text(stokno);
        $('#cabterimaVal').text(nmcab);
        tampil_transtok();
    });

    $(document).on('click', '.btn-addtampilstok', function () {
        var stokno = $('#txtstoknoE').val();
        var tgl = $('#txttglE').val();
        var regcab = $('#txtregidE').val();
        $('#txtstoknoA').val(stokno);
        $('#txttglA').val(tgl);
        $('#txtregidA').val(regcab);
        $('#kdA').val('');
        $('#nmA').val('');
        $('#satA').val('');
        $('#katA').val('');
        $('#stokA').val('');
        $('#txtqtyA').val('');
        
    });

    $(document).on('click', '.btn-tampilhapustranstok', function () {
        var stokno = $(this).data('stokno');
        var nmcab = $(this).data('nmcab');
        $('#txtkode').val(stokno);
        $('#stoknoValH').text(stokno);
        $('#cabterimaValH').text(nmcab);
    });

    
    
    $(document).on('click', '.btn-edit', function () {
        var stokno = $(this).data('stokno');
        var stokid = $(this).data('stokid');
        var idbrg = $(this).data('idbrg');
        var nmbrg = $(this).data('nmbrg');
        var sat = $(this).data('sat');
        var kat = $(this).data('kat');
        var qty = $(this).data('qty');
        var formatted_qty;
        if (Math.floor(qty) === qty) {
            formatted_qty = qty.toLocaleString('id-ID', { maximumFractionDigits: 0 });
        } else {
            formatted_qty = qty.toLocaleString('id-ID', { maximumFractionDigits: 2 });
            formatted_qty = formatted_qty.replace(/\.?0+$/, ''); // Menghilangkan nol di belakang desimal
        }
            
        $('#txtnostokE').val(stokno);
        $('#txtstokidE').val(stokid);
        $('#kd').val(idbrg);
        $('#nm').val(nmbrg);
        $('#sat').val(sat);
        $('#kat').val(kat);
        $('#qtyEdit').val(formatted_qty);
        
        //mencari stok barang
        $.ajax({
            type: "POST",
            url: "<?php echo base_url().'admin/transfer_stok/get_barang';?>",
            data: {
                idbrg : idbrg
            },
            dataType: 'json',
            success: function (data) {
                // console.log(idbrg);
                // console.log(regid);
                if (data.error) {
                    alert('Terjadi kesalahan: ' + data.error); // Memberikan umpan balik kepada pengguna
                } else {
                    
                    $.each(data, function (index, item) {
                        var stok = parseFloat(item.stok_cabang);
                        var formatted_stok;
                        if (Math.floor(stok) === stok) {
                            formatted_stok = stok.toLocaleString('id-ID', { maximumFractionDigits: 0 });
                        } else {
                            formatted_stok = stok.toLocaleString('id-ID', { maximumFractionDigits: 2 });
                            formatted_stok = formatted_stok.replace(/\.?0+$/, ''); // Menghilangkan nol di belakang desimal
                        }                            
                        var maxstok = stok + qty ;
                        if (Math.floor(maxstok) === maxstok) {
                            formatted_maxstok = maxstok.toLocaleString('id-ID', { maximumFractionDigits: 0 });
                        } else {
                            formatted_maxstok = maxstok.toLocaleString('id-ID', { maximumFractionDigits: 2 });
                            formatted_maxstok = formatted_maxstok.replace(/\.?0+$/, ''); // Menghilangkan nol di belakang desimal
                        }
                        $('#stok_qty').val(formatted_stok); 
                        $('#qtyEdit').attr('max', formatted_maxstok); // Mengatur nilai max
                        $('#qtyEdit').attr('title', 'Qty Kirim tidak boleh melebihi : ' + formatted_maxstok);

                    });
                    
                }
            },
            error: function (xhr, status, error) {
                console.error("AJAX error:", error);
                alert('Terjadi kesalahan saat mengirim permintaan AJAX.'); // Memberikan umpan balik kepada pengguna
            }
        });
    });

    $(document).on('click', '.btn-tampilhapus', function () {
        var stokno = $(this).data('stokno');
        var stokid = $(this).data('stokid');
        var idbrg = $(this).data('idbrg');
        var nmbrg = $(this).data('nmbrg');
        var sat = $(this).data('sat');
        var kat = $(this).data('kat');
        var qty = $(this).data('qty');
        $('#txtnostokH').val(stokno);
        $('#txtstokidH').val(stokid);
        $('#kdH').val(idbrg);
        $('#kdValH').text(idbrg);
        $('#nmbrgValH').text(nmbrg);
        $('#satValH').text(sat);
        $('#katValH').text(kat);
        $('#qtyValH').text(qty);
    });


    function tampil_transtok() {
        $('#tbl_transtok tbody').empty();
        var stokno=$('#txtstoknoE').val();
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
                                var formatted_k_qty;
                                if (Math.floor(k_qty) === k_qty) {
                                    formatted_k_qty = k_qty.toLocaleString('id-ID', { maximumFractionDigits: 0 });
                                } else {
                                    formatted_k_qty = k_qty.toLocaleString('id-ID', { maximumFractionDigits: 2 });
                                    formatted_k_qty = formatted_k_qty.replace(/\.?0+$/, ''); // Menghilangkan nol di belakang desimal
                                }
                                var newRow = '<tr>' +
                                    '<td style="font-size:11px;text-align:center;">' + no + '</td>' +
                                    '<td style="font-size:11px;">' + item.d_barang_id + '</td>' +
                                    '<td style="font-size:11px;">' + item.d_barang_nama + '</td>' +
                                    '<td style="font-size:11px;text-align:center;">' + item.d_barang_satuan + '</td>' +
                                    '<td style="font-size:11px;text-align:center;">' + item.d_kategori_nama + '</td>' +
                                    '<td style="font-size:11px;text-align:center;">' + formatted_k_qty + '</td>' +
                                    '<td style="text-align:center;">' + 
                                    '<a class="btn btn-xs btn-warning btn-edit" href="#modalEdit" data-toggle="modal" data-stokno="' + item.d_trans_stok_no + '" data-stokid="' + item.d_trans_stok_id + '" data-idbrg="' + item.d_barang_id + '" data-nmbrg="' + item.d_barang_nama + '" data-sat="' + item.d_barang_satuan + '" data-kat="' + item.d_kategori_nama + '" data-qty="' + k_qty + '" title="Edit Data"><span class="fa fa-pencil"></span></a> ' +
                                    '<a class="btn btn-xs btn-danger btn-tampilhapus" href="#modalHapus" data-toggle="modal" data-stokno="' + item.d_trans_stok_no + '" data-stokid="' + item.d_trans_stok_id + '" data-idbrg="' + item.d_barang_id + '" data-nmbrg="' + item.d_barang_nama + '" data-sat="' + item.d_barang_satuan + '" data-kat="' + item.d_kategori_nama + '" data-qty="' + formatted_k_qty + '" title="Hapus Data"><span class="fa fa-trash-o"></span></a>' +
                                    '</td>' +
                                    '</tr>';
                                $('#tbl_transtok tbody').append(newRow);

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

    $(document).on('click', '.btn-update', function () {
        var stokno = $('#txtnostokE').val();
        var brgid = $('#kd').val();
        var stokid =  $('#txtstokidE').val();
        var qty = $('#qtyEdit').val();
        if (qty === '') {
                alert("Mohon isi jumlah/quantity kirim dengan benar.");
        }else {
            $.ajax({
                url: "<?php echo base_url().'admin/transfer_stok/update_transtok';?>",
                type: "POST",
                data: {
                    stokno: stokno,
                    brgid: brgid,
                    stokid: stokid,
                    qty: qty
                },
                success: function (data) {
                    if (data.error) {
                        alert('Terjadi kesalahan: ' + data.error); // Memberikan umpan balik kepada pengguna
                    } else {
                        $('#modalEdit').modal('hide');// Tutup modal
                        tampil_transtok();
                    }
                },
                error: function(xhr, status, error) {
                    console.error("AJAX error:", error);
                }
            });
        }
    });

    $(document).on('click', '.btn-hapus', function () {
        var stokid =  $('#txtstokidH').val();
        var stokno = $('#txtnostokH').val();
        var brgid = $('#kdH').val();
        $.ajax({
            url: "<?php echo base_url().'admin/transfer_stok/hapus_transtok';?>",
            type: "POST",
            data: {
                stokno: stokno,
                stokid: stokid,
                brgid: brgid
            },
            success: function (data) {
                if (data.error) {
                    alert('Terjadi kesalahan: ' + data.error); // Memberikan umpan balik kepada pengguna
                } else {
                    $('#modalHapus').modal('hide');// Tutup modal
                    tampil_transtok();
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX error:", error);
            }
        });
    });


    $(document).on('click', '.btn-addstok', function () {
        var stoknoA = $('#txtstoknoA').val();
        // var tglA = $('#txttglA').val();
        // var regcabA = $('#txtregidA').val();
        var kdA = $('#kdA').val();
        // var nmA = $('#nmA').val();
        // var satA = $('#satA').val();
        // var katA = $('#katA').val();
        var qtyA =  $('#txtqtyA').val();

        var numericValue = parseFloat(qtyA.replace(',', '.')) || 0;
        if (numericValue <= 0) {    // Periksa apakah nilai adalah 0 atau kurang dari 0
            $('#txtqtyA').val(''); // Mengosongkan nilai input yang sedang berfokus
            alert("Nilai harus lebih besar dari 0");    // Jika nilai adalah 0 atau kurang dari 0, berikan pesan kesalahan
            setTimeout(function() {
                $('#txtqtyA').focus(); // Tambahkan delay untuk memastikan pengaturan fokus berhasil
            }.bind('#txtqtyA'), 0);
        }else {
            
            //mencari kode barang yang sudah ada pada data tbl_detail_transtok
            $.ajax({
                type: "POST",
                url: "<?php echo base_url().'admin/transfer_stok/get_data_transtok';?>",
                data: {
                    stokno : stoknoA,
                    idbrg : kdA
                },
                dataType: 'json',
                success: function (data) {
                    // console.log(idbrg);
                    // console.log(regid);
                    if (data.error) {
                        //jika data tidak diketemukan lakukan proses simpan
                        proses_simpan_addstok();
                    } else {
                        
                        alert('Kode Barang Sudah Terdaftar, penyimpanan tidak bisa dilakukan, silahkan gunakan form edit untuk merubah data');
                    }
                },
                error: function (xhr, status, error) {
                    console.error("AJAX error:", error);
                    alert('Terjadi kesalahan saat mengirim permintaan AJAX.'); // Memberikan umpan balik kepada pengguna
                }
            });

        }
    });

    function proses_simpan_addstok() {  
        var stoknoA = $('#txtstoknoA').val();
        var tglA = $('#txttglA').val();
        var regcabA = $('#txtregidA').val();
        var kdA = $('#kdA').val();
        var nmA = $('#nmA').val();
        var satA = $('#satA').val();
        var katA = $('#katA').val();
        var qtyA =  $('#txtqtyA').val();          
        $.ajax({
            url: "<?php echo base_url().'admin/transfer_stok/simpan_addtranstok';?>",
            type: "POST",
            data: {
                stokno: stoknoA,
                tgl: tglA,
                regcab: regcabA,
                kd: kdA,
                nm: nmA,
                sat: satA,
                kat: katA,
                qty: qtyA
            },
            success: function (data) {
                if (data.error) {
                    alert('Terjadi kesalahan: ' + data.error); // Memberikan umpan balik kepada pengguna
                } else {
                    $('#modalAddEdit').modal('hide');// Tutup modal
                    tampil_transtok();
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
    $(document).ready(function(){
        $(document).on('click', '.btn-cariproduk', function () {
            $('#modalCari').modal('show');
        }); 

        //pencarian kode barang pada elemen idbrg
        $("#kdA").on("input",function(){
            var idbrg = $(this).val();
            if (idbrg !== "") {
                cariProduk();
            } 
        });

        function cariProduk() {
            $('#nmA').val('');
            $('#satA').val('');
            $('#katA').val('');
            $('#stokA').val('');
            $('#txtqtyA').val('');
            var idbrg=$('#kdA').val();

            //-----------cari stok yang tersedia---------------
            $.ajax({
                type: "POST",
                url: "<?php echo base_url().'admin/transfer_stok/get_barang';?>",
                data: {
                    idbrg : idbrg
                },
                dataType: 'json',
                success: function (data) {
                    if (data.error) {
                        alert('Terjadi kesalahan: ' + data.error); // Memberikan umpan balik kepada pengguna
                    } else {
                        $.each(data, function (index, item) {
                            var stok = parseFloat(item.stok_cabang);
                            var formatted_stok;
                            if (Math.floor(stok) === stok) {
                                formatted_stok = stok.toLocaleString('id-ID', { maximumFractionDigits: 0 });
                            } else {
                                formatted_stok = stok.toLocaleString('id-ID', { maximumFractionDigits: 2 });
                                formatted_stok = formatted_stok.replace(/\.?0+$/, ''); // Menghilangkan nol di belakang desimal
                            } 
                            $('#nmA').val(item.barang_nama);
                            $('#satA').val(item.barang_satuan);
                            $('#katA').val(item.barang_kategori_nama);
                            $('#stokA').val(formatted_stok);
                            $('#txtqtyA').attr('max', formatted_stok); // Mengatur nilai max
                            $('#txtqtyA').attr('title', 'Qty Kirim tidak boleh melebihi : ' + formatted_stok);
                            
                        });
                        
                    }
                },
                error: function (xhr, status, error) {
                    console.error("AJAX error:", error);
                    alert('Terjadi kesalahan saat mengirim permintaan AJAX.'); // Memberikan umpan balik kepada pengguna
                }
            });
            //----------------------------
            
            
            


        }

        $('#modalCari').on('hidden.bs.modal', function () {
            var idbrg = $('#kdA').val();
            if (idbrg !== "") {
                cariProduk();
                setTimeout(function() {
                $("#txtqtyA").focus();
                }, 100);
            }
        });
        
    });

    function pilihKode(id) {
        //console.log(id);
        $('#kdA').val(id);
        $('#modalCari').modal('hide');
    }
    
    

</script>


</body>
</html>
