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

    <title>Retur Barang</title>
    <link rel="shortcut icon" href="<?php echo base_url().'assets/img/'. $userid['co_imgicon']; ?>" alt="#no image#" type="image/x-icon">
    <!-- Bootstrap Core CSS -->
    <link href="<?php echo base_url().'assets/css/bootstrap.min.css'?>" rel="stylesheet">
	<link href="<?php echo base_url().'assets/css/style.css'?>" rel="stylesheet">
	<link href="<?php echo base_url().'assets/css/font-awesome.css'?>" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?php echo base_url().'assets/css/4-col-portfolio.css'?>" rel="stylesheet">
    <link href="<?php echo base_url().'assets/css/dataTables.bootstrap.min.css'?>" rel="stylesheet">
    <link href="<?php echo base_url().'assets/css/jquery.dataTables.min.css'?>" rel="stylesheet">
    <link href="<?php echo base_url().'assets/dist/css/bootstrap-select.css'?>" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/css/bootstrap-datetimepicker.min.css'?>">

<style>
    
   
    .bootstrap-select .btn {
        font-size: 11px; /* Ganti 16px sesuai dengan ukuran font yang Anda inginkan */
    }
    
    .bootstrap-datetimepicker-widget {
        font-size: 10px; /* Sesuaikan dengan ukuran font yang diinginkan */
    }

    .bootstrap-datetimepicker-widget table {
        line-height: 1 !important; /* Sesuaikan dengan nilai yang sesuai */
    }

    .bootstrap-datetimepicker-widget table th,
    .bootstrap-datetimepicker-widget table td {
        padding: 1px !important; /* Sesuaikan dengan nilai yang sesuai */
    }

</style>
</head>
<body>

    <!-- Navigation -->
   <?php 
        $this->load->view('admin/menu');
   ?>

    <!-- Page Content -->
    <div class="container">
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#tab1" style="font-size:12px;"><b>Tambah Data Retur</b></a></li>
            <li><a data-toggle="tab" href="#tab2" style="font-size:12px;"><b>Cetak Data Retur</b></a></li>
            <!-- Tambahkan lebih banyak tab sesuai kebutuhan -->
        </ul> 
        <!-- Isi Tab -->
        <div class="tab-content">
            <!-- Tab 1: Informasi -->
            <div id="tab1" class="tab-pane fade in active">
                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <center><?php echo $this->session->flashdata('msg');?></center>
                        <h3 class="page-header">Retur 
                            <small>Barang</small>
                            <div class="pull-right"><a href="#modalTambah" class="btn btn-sm btn-success" data-toggle="modal"><span class="fa fa-plus"></span> Tambah Retur</a></div>
                        </h3>
                    </div>
                </div>
                <br>

                <!-- Projects Row -->
                <div class="row">
                    <div class="col-lg-12">
                        <table class="table table-bordered table-condensed" style="font-size:11px;margin-top:10px;" id="mydata2">
                            <thead>
                                <tr>
                                    <th style="text-align:center;">No</th>
                                    <th style="text-align:center;">Tgl Input</th>
                                    <th style="text-align:center;">Kode Barang</th>
                                    <th style="text-align:center;">Nama Barang</th>
                                    <th style="text-align:center;">Satuan</th>
                                    <th style="text-align:center;">Harga Bottom</th>
                                    <th style="text-align:center;">Jumlah</th>
                                    <th style="text-align:center;">Subtotal (Rp)</th>
                                    <th style="text-align:center;">Keterangan</th>
                                    <th style="text-align:center;">Cabang</th>
                                    <th style="width:120px;text-align:center;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>             
                                <?php
                                    $no=0; 
                                    foreach ($retur->result_array() as $items): 
                                    $no++;
                                ?>       
                                <tr>
                                    <td style="text-align:center;"><?php echo $no;?></td>
                                    <td><?php echo $items['retur_tgl'];?></td>
                                    <td><?php echo $items['retur_brg_id'];?></td>
                                    <td style="text-align:left;"><?php echo $items['retur_brg_nama'];?></td>
                                    <td style="text-align:center;"><?php echo $items['retur_brg_sat'];?></td>
                                    <td style="text-align:right;"><?php echo number_format($items['retur_harpok'],0, ',' ,'.'); ?></td>
                                    <?php 
                                    $qty=$items['retur_qty'];
                                    if (floor($qty) == $qty) {
                                        $formatted_qty = number_format($qty, 0, ',', '.');
                                    } else {
                                        $formatted_qty = number_format($qty, 2, ',', '.');
                                        $formatted_qty = rtrim($formatted_qty, '0');
                                        $formatted_qty = rtrim($formatted_qty, ',');
                                    }
                                    echo '<td style="text-align:center;">'.$formatted_qty.'</td>';
                                    ?>  
                                    <td style="text-align:right;"><?php echo number_format($items['retur_subtotal'],0, ',' ,'.'); ?></td>
                                    <td style="text-align:center;"><?php echo $items['retur_keterangan'];?></td>
                                    <td style="text-align:center;"><?php echo $items['reg_name'];?></td>
                                    <td style="text-align:center;">
                                        <a class="btn btn-xs btn-warning btn-lihat" href="#modalLihat" data-toggle="modal" data-noid="<?php echo $items['retur_id'];?>" data-idbrg="<?php echo $items['retur_brg_id'];?>" title="Lihat Data Retur"><span class="fa fa-eye"></span> Lihat</a>    
                                        <a class="btn btn-xs btn-danger btn-hapus" href="#modalHapus" data-toggle="modal" data-noid="<?php echo $items['retur_id'];?>" data-kdbrg="<?php echo $items['retur_brg_id'];?>" title="Hapus Data Retur"><span class="fa fa-trash"></span> Hapus</a>
                                    </td>
                                </tr>    
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div id="tab2" class="tab-pane fade">
                <br>
                <div class="row">
                    <div class="col-lg-12">
                        <form id="myForm" class="form-horizontal" method="post" action="" target="_blank">
                        <table style="font-size:12px;margin-bottom:10px;">
                            <tr>
                                <th style="width:7%;vertical-align:middle;">Tgl Transaksi :</th>
                                <td style="width:10%;vertical-align:middle;">
                                    <div class="input-group date" id="datepicker1">
                                        <input type="text" id="tgl1" name="tgl1" class="form-control input-sm" style="font-size:11px;color:green;" placeholder="Tanggal..." value="<?= $firstDayOfMonth; ?>" required>
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                </td>
                                <td style="width:3%;vertical-align:middle;text-align:center"> S/d</td>
                                <td style="width:10%;vertical-align:middle;">
                                    <div class="input-group date" id="datepicker2">
                                        <input type="text" id="tgl2" name="tgl2" class="form-control input-sm" style="font-size:11px;color:green;" placeholder="Tanggal..." value="<?= $lastDayOfMonth; ?>" required>
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                </td>
                                <td style="width:5%;vertical-align:middle;padding-left:10px;">
                                    <a class="btn btn-sm btn-info btn-tampil" data-toggle="modal" title="Tampilkan Data"><span class="fa fa-search"></span></a>
                                </td>
                                <td style="width:40%;text-align:right;border-top-color:white;border-right-color:white;">
                                    <button class="btn btn-sm btn-info" title="Cetak Data" onclick="varCetak_Data()"><span class="fa fa-print"></span> Cetak Data</button>
                                </td>
                            </tr>
                        </table>
                        </form>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">        
                        <table id="tbl_tampil" class="table table-striped table-bordered" style="font-size:11px;">
                            <thead>
                            <tr>
                                <th style="text-align:center;">No</th>
                                <th style="text-align:center;">Tgl Input</th>
                                <th style="text-align:center;">Kode Barang</th>
                                <th style="text-align:center;">Nama Barang</th>
                                <th style="text-align:center;">Satuan</th>
                                <th style="text-align:center;">Kategori</th>
                                <th style="text-align:center;">Harga Bottom</th>
                                <th style="text-align:center;">Jumlah</th>
                                <th style="text-align:center;">Subtotal (Rp)</th>
                                <th style="text-align:center;">Keterangan</th>
                                <th style="text-align:center;">Cabang</th>
                            </tr>
                        </thead>
                        <tbody>             
                            <?php
                                $no=0; 
                                foreach ($data_retur as $d):
                                $no++;
                            ?>
                                       
                            <tr>
                                <td style="text-align:center;"><?php echo $no;?></td>
                                <td><?php echo $d['retur_tgl'];?></td>
                                <td><?php echo $d['retur_brg_id'];?></td>
                                <td style="text-align:left;"><?php echo $d['retur_brg_nama'];?></td>
                                <td style="text-align:center;"><?php echo $d['retur_brg_sat'];?></td>
                                <td style="text-align:center;"><?php echo $d['retur_brg_kat'];?></td>
                                <td style="text-align:right;"><?php echo number_format($d['retur_harpok'],0, ',' ,'.'); ?></td>
                                <?php 
                                $qty=$d['retur_qty'];
                                if (floor($qty) == $qty) {
                                    $formatted_qty = number_format($qty, 0, ',', '.');
                                } else {
                                    $formatted_qty = number_format($qty, 2, ',', '.');
                                    $formatted_qty = rtrim($formatted_qty, '0');
                                    $formatted_qty = rtrim($formatted_qty, ',');
                                }
                                echo '<td style="text-align:center;">'.$formatted_qty.'</td>';
                                ?>  
                                <td style="text-align:right;"><?php echo number_format($d['retur_subtotal'],0, ',' ,'.'); ?></td>
                                <td style="text-align:center;"><?php echo $d['retur_keterangan'];?></td>
                                <td style="text-align:center;"><?php echo $d['reg_name'];?></td>
                            </tr>    
                            <?php endforeach; ?>
                        </tbody>
                        </table>
                    </div>
                </div>                     
            </div>
        </div>

        <!-- ============ MODAL Tambah =============== -->
        <div class="modal fade" id="modalTambah" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 class="modal-title" id="myModalLabel">Input Retur Barang</h3>
            </div>
            <form class="form-horizontal" method="post" action="<?php echo base_url().'admin/retur/simpan_retur'?>">
                <div class="modal-body" style="overflow:scroll;height:450px;">
                    <table class="table table-bordered table-condensed" style="font-size:11px;margin-bottom:10px;">
                    <tr>
                        <th style="width:150px;vertical-align:middle;">Tgl Transaksi</th>
                        <td>
                            <div style="display:flex;align-items:center;">
                                <div class='input-group date' id='datepicker' style="width:130px;">
                                    <input type='text' name="tgl" id="tgl" class="form-control" style="font-size:11px;color:green;" placeholder="Tanggal..." value="<?= $today ?>" required>
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                                <span style="vertical-align:middle;padding-left:5px;padding-right:5px;"><b>No Faktur :</b></span>
                                <input name="nofak" id="nofak" class="form-control input-sm" type="text" placeholder="No Faktur" style="font-size:11px;width:170px;" maxlength="15">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th style="width:150px;vertical-align:middle;">Pilih Stok Cabang</th>
                        <td>
                            <select name="regid" id="regid" class="selectpicker show-tick form-control" data-live-search="true" title="Pilih Cabang" data-width="150px" required>
                            <?php 
                                foreach ($regions ->result_array() as $rg) {
                                    $reg_id = $rg['reg_id'];
                                    $reg_name = $rg['reg_name'];    
                                    echo '<option value="'.$reg_id.'" style="font-size:11px">'.$reg_name.'</option>';
                                }
                            ?>
                            </select>
                        </td>   
                    </tr>
                    <tr>
                        <th style="width:150px;vertical-align:middle;">Kode Barang</th>
                        <td>
                            <div style="display:flex;align-items:center;">
                                <input name="idbrg" id="idbrg" class="form-control input-sm" type="text" placeholder="Kode Barang" style="width:150px;" maxlength="15" required>
                                <a class="btn btn-sm btn-success btn-cariproduk" style="margin-left:10px;font-size:11px;">Cari Produk !</a>
                            </div>
                        </td>     
                    </tr>
                    </table>

                    <table id="tbl_infobrg" style="font-size:11px;display:none;border:1px solid #dddddd;margin-bottom:5px;width:550px;">
                        <tr><th style="padding-top:5px;"></th></tr>
                        <tr>
                            <th style="text-align:right;padding-right:10px;width:150px;vertical-align:middle;">Nama Barang</th>
                            <td><input name="nmbrg" id="nmbrg" class="form-control input-sm" type="text" style="font-size:11px;width:370px;height:25px;" readonly></td> 
                        </tr>
                        <tr>
                            <th style="text-align:right;padding-right:10px;width:150px;vertical-align:middle;">Satuan</th>
                            <td><input name="satbrg" id="satbrg" class="form-control input-sm" type="text" style="font-size:11px;width:100px;height:25px;" readonly></td> 
                        </tr>
                            <th style="text-align:right;padding-right:10px;width:150px;vertical-align:middle;">Kategori</th>
                            <td><input name="katbrg" id="katbrg" class="form-control input-sm" type="text" style="font-size:11px;width:100px;height:25px;" readonly></td> 
                        <tr>
                            <th style="text-align:right;padding-right:10px;width:150px;vertical-align:middle;">Harga Bottom</th>
                            <td><input name="harpokbrg" id="harpokbrg" class="form-control input-sm" type="text" style="font-size:11px;width:100px;height:25px;text-align:right;" readonly></td> 
                        </tr>
                        <tr>
                            <th style="text-align:right;padding-right:10px;width:150px;vertical-align:middle;">Harga Pricelist</th>
                            <td><input name="harjulbrg" id="harjulbrg" class="form-control input-sm" type="text" style="font-size:11px;width:100px;height:25px;text-align:right;" readonly></td> 
                        </tr>
                        <tr>
                            <th style="text-align:right;padding-right:10px;width:150px;vertical-align:middle;">Stok saat ini</th>
                            <td><input name="stokbrg" id="stokbrg" class="form-control input-sm" type="text" style="font-size:11px;width:100px;height:25px;text-align:right;" readonly></td> 
                        </tr> 
                        <tr><th style="padding-top:5px;"></th></tr>  
                    </table>

                    <table class="table table-bordered table-condensed" style="font-size: 11px;">            
                    <tr>
                        <th style="width:150px;vertical-align:middle;">Jumlah Retur</th>
                        <td><input name="qtyret" id="qtyret" class="form-control input-sm" type="text" style="font-size:11px;width:150px;" maxlength="50" required></td> 
                    </tr>            
                    <tr>
                        <th style="width:150px;vertical-align:middle;">Keterangan</th>
                        <td>
                            <textarea name="ket" id="ket" class="form-control input-sm" placeholder="isi keterangan..." style="font-size:11px;width:370px;height:80px;resize:none;overflow-y:auto;" maxlength="150" required></textarea>
                        </td> 
                    </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-info">Simpan</button>    
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

                  <table class="table table-bordered table-condensed" style="font-size:11px;" id="mydata">
                    <thead>
                        <tr>
                            <th style="text-align:center;width:40px;">No</th>
                            <th style="width:120px;">Kode Barang</th>
                            <th style="width:240px;">Nama Barang</th>
                            <th>Satuan</th>
                            <th style="width:100px;">Harga Bottom</th>
                            <th style="width:100px;">Harga Pokok</th>
                            <th style="width:100px;">Kategori</th>
                            <th style="width:100px;text-align:center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                        $no=0;
                        foreach ($data->result_array() as $a):
                            $no++;
                            $id=$a['barang_id'];
                            $nm=$a['barang_nama'];
                            $satuan=$a['barang_satuan'];
                            $harpok=$a['barang_harpok'];
                            $harjul=$a['barang_harjul'];
                            $kategori=$a['barang_kategori_nama'];
                            
                    ?>
                        <tr>
                            <td style="text-align:center;"><?php echo $no;?></td>
                            <td><?php echo $id;?></td>
                            <td><?php echo $nm;?></td>
                            <td style="text-align:center;"><?php echo $satuan;?></td>
                            <td style="text-align:right;"><?php echo 'Rp ' . str_replace(',', '.', number_format($harpok)); ?></td>
                            <td style="text-align:right;"><?php echo 'Rp ' . str_replace(',', '.', number_format($harjul)); ?></td>
                            <td style="text-align:center;"><?php echo $kategori;?></td>
                            <td style="text-align:center;">
                            <button type="submit" class="btn btn-xs btn-info" title="Pilih" onclick="pilihKode('<?php echo $id?>')"><span class="fa fa-edit"></span> Pilih</button>
                            </form>
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


        <!-- ============ MODAL Lihat =============== -->
        <div class="modal fade" id="modalLihat" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 class="modal-title" id="myModalLabel">Lihat Retur Barang</h3>
            </div>
                <div class="modal-body" style="overflow:scroll;height:450px;">
                    
                    <!-- Navigasi Tab -->
                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#file1" style="font-size:11px;"><b>Data Retur</b></a></li>
                        <li><a data-toggle="tab" href="#file2" style="font-size:11px;"><b>File / Dokumen Retur</b></a></li>
                        <!-- Tambahkan lebih banyak tab sesuai kebutuhan -->
                    </ul>

                    <!-- Isi Tab -->
                    <div class="tab-content">
                        <!-- Tab 1: Informasi -->
                        <div id="file1" class="tab-pane fade in active">
                        <br>
                            <table class="table table-bordered table-condensed" style="font-size:11px;margin-bottom:5px;">
                            <tr>
                                <th style="width:150px;vertical-align:middle;">Tgl Transaksi</th>
                                <td>
                                    <div style="display:flex;align-items:center;">
                                        <input name="tgl3" id="tgl3" class="form-control input-sm" type="text" placeholder="No Faktur" style="font-size:11px;width:130px;" readonly>
                                        <span style="vertical-align:middle;padding-left:5px;padding-right:5px;"><b>No Faktur :</b></span>
                                        <input name="nofak3" id="nofak3" class="form-control input-sm" type="text" placeholder="No Faktur" style="font-size:11px;width:130px;" readonly>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th style="width:150px;vertical-align:middle;">Nama Cabang</th>
                                <td>
                                    <input name="regid3" id="regid3" class="form-control input-sm" type="text" placeholder="No Faktur" style="font-size:11px;width:120px;" readonly>
                                </td>   
                            </tr>
                            <tr>
                                <th style="width:150px;vertical-align:middle;">Kode Barang</th>
                                <td>
                                    <input name="idbrg3" id="idbrg3" class="form-control input-sm" type="text" placeholder="Kode Barang" style="width:120px;" readonly>
                                </td>     
                            </tr>
                            </table>

                            <table id="tbl_infobrg" style="font-size:11px;border:1px solid #dddddd;margin-bottom:5px;width:550px;">
                                <tr><th style="padding-top:5px;"></th></tr>
                                <tr>
                                    <th style="text-align:right;padding-right:10px;width:150px;vertical-align:middle;">Nama Barang</th>
                                    <td><input name="nmbrg3" id="nmbrg3" class="form-control input-sm" type="text" style="font-size:11px;width:370px;height:25px;" readonly></td> 
                                </tr>
                                <tr>
                                    <th style="text-align:right;padding-right:10px;width:150px;vertical-align:middle;">Satuan</th>
                                    <td><input name="satbrg3" id="satbrg3" class="form-control input-sm" type="text" style="font-size:11px;width:100px;height:25px;" readonly></td> 
                                </tr>
                                    <th style="text-align:right;padding-right:10px;width:150px;vertical-align:middle;">Kategori</th>
                                    <td><input name="katbrg3" id="katbrg3" class="form-control input-sm" type="text" style="font-size:11px;width:100px;height:25px;" readonly></td> 
                                <tr>
                                    <th style="text-align:right;padding-right:10px;width:150px;vertical-align:middle;">Harga Bottom</th>
                                    <td>
                                        <div style="display: inline-block;">
                                            <input name="harpokbrg3" id="harpokbrg3" class="form-control input-sm" type="text" style="font-size:11px;width:100px;height:25px;text-align:right;" readonly>
                                        </div>
                                        <div style="display: inline-block;">
                                            <div style="display: inline-block;padding-left:15px;"><b>Sub Total : </b></div>
                                            <div style="display: inline-block;">
                                                <input type="text" name="harpokbrg3b" id="harpokbrg3b" class="form-control input-sm" style="font-size:11px;width:100px;height:25px;text-align:right;" readonly>
                                            </div>
                                        </div>
                                    </td>

                                </tr>
                                <tr>
                                    <th style="text-align:right;padding-right:10px;width:150px;vertical-align:middle;">Harga Pricelist</th>
                                    <td>
                                        <div style="display: inline-block;">
                                            <input name="harjulbrg3" id="harjulbrg3" class="form-control input-sm" type="text" style="font-size:11px;width:100px;height:25px;text-align:right;" readonly> 
                                        </div>
                                        <div style="display: inline-block;">
                                            <div style="display: inline-block;padding-left:15px;"><b>Sub Total : </b></div>
                                            <div style="display: inline-block;">
                                                <input type="text" name="harjulbrg3b" id="harjulbrg3b" class="form-control input-sm" style="font-size:11px;width:100px;height:25px;text-align:right;" readonly>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr><th style="padding-top:5px;"></th></tr>  
                            </table>

                            <table class="table table-bordered table-condensed" style="font-size: 11px;">            
                            <tr>
                                <th style="width:150px;vertical-align:middle;">Jumlah Retur</th>
                                <td><input name="qtyret3" id="qtyret3" class="form-control input-sm" type="text" style="font-size:11px;width:120px;" readonly></td> 
                            </tr>            
                            <tr>
                                <th style="width:150px;vertical-align:middle;">Keterangan</th>
                                <td>
                                    <textarea name="ket3" id="ket3" class="form-control input-sm" placeholder="isi keterangan..." style="font-size:11px;width:370px;height:60px;resize:none;overflow-y:auto;" readonly></textarea>
                                </td> 
                            </tr>
                            </table>
                        </div> 
                        <!-- Tab 2: File Dokumen Retur -->
                        <div id="file2" class="tab-pane fade">
                            <br>
                        <table id="tbl_file" class="table table-bordered table-condensed" style="font-size:11px;margin-top:10px;">
                        <thead>
                            <tr>
                                <th style="text-align:center;">Nama File</th>
                                <th style="text-align:center;">File</th>
                                <th style="text-align:center;width:100px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                        </table>
                        </div>   
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
                </div>
        </div>
        </div>
        </div>

        <!-- ============ MODAL HAPUS RETUR=============== -->               
        <div id="modalHapus" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 class="modal-title" id="myModalLabel">Hapus Data Retur Barang</h3>
            </div>
            <form class="form-horizontal" method="post" action="<?php echo base_url().'admin/retur/hapus_retur'?>">
                <div class="modal-body">
                    <p>Yakin mau menghapus Data <b> Retur </b> ini : <br>
                    Kode Barang : <b><span id="kdbrgVal"></span></b></p>
                    <input name="txtkode" id="txtkode" type="hidden">
                    <p> Selain menghapus data <b> Retur </b>, Proses ini juga akan mengembalikan nilai <b> Stok </b> barang tersebut.</p>  
                    <p>Proses ini juga sekaligus menghapus <b> File Gambar / Dokumen </b> data Retur yang terkait.</p>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Hapus</button>
                    <button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
                </div>
            </form>
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
    <script src="<?php echo base_url().'assets/dist/js/bootstrap-select.min.js'?>"></script>
    <script src="<?php echo base_url().'assets/js/bootstrap.min.js'?>"></script>
    <script src="<?php echo base_url().'assets/js/jquery.dataTables.min.js'?>"></script>
    <script src="<?php echo base_url().'assets/js/moment.js'?>"></script>
    <script src="<?php echo base_url().'assets/js/bootstrap-datetimepicker.min.js'?>"></script>
    
    <script type="text/javascript">
        $(document).ready(function() {
            $('#mydata').DataTable();
        } );
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#mydata2').DataTable();
        } );
    </script>
    <script type="text/javascript">
    $(function () {
        $('#datepicker').datetimepicker({
            format: 'YYYY-MM-DD',
            widgetPositioning: {
                vertical: 'bottom',
                horizontal: 'auto'
            }
        });
        $('#datepicker1').datetimepicker({
        format: 'YYYY-MM-DD',
        widgetPositioning: {
            vertical: 'bottom',
            horizontal: 'auto'
            }
        });
        $('#datepicker2').datetimepicker({
        format: 'YYYY-MM-DD',
        widgetPositioning: {
            vertical: 'bottom',
            horizontal: 'auto'
            }
        });
    });
    </script>

<script>
    function varCetak_Data() {
        var form = document.querySelector('#myForm'); 
        form.action = "<?php echo base_url().'admin/retur/cetak_data_retur';?>";
        form.target = '_blank';
        form.submit(); // Mengirimkan formulir
    }
</script>

<script type="text/javascript">
$(document).ready(function () {
    $(document).on('click', '.btn-tampil', function () {
        $('#tbl_tampil tbody').empty();
        var tgl1 = $('#tgl1').val();
        var tgl2 = $('#tgl2').val();

        $.ajax({
            url: "<?php echo base_url().'admin/retur/get_data_retur';?>",
            type: "POST",
            data: {
                tgl1: tgl1,
                tgl2: tgl2
            },
            success: function (data) {
                // console.log("Data from server:", data);
                // console.log(tgl1);
                // console.log(tgl2);
                var parsedData = JSON.parse(data);
                if (parsedData.length !== 0) {
                        var no=0;
                        $.each(parsedData.data, function (index, item) {
                                no++;
                                var ret_harpok = parseFloat(item.retur_harpok);
                                var ret_subtotal = parseFloat(item.retur_subtotal);
                                var ret_qty = parseFloat(item.retur_qty);
                                var formatted_ret_qty;
                                if (Math.floor(ret_qty) === ret_qty) {
                                    formatted_ret_qty = ret_qty.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ','); // Format sebagai bilangan bulat
                                } else {
                                    formatted_ret_qty = ret_qty.toFixed(2).replace('.', ',').replace(/\.?0+$/, '').replace(/\B(?=(\d{3})+(?!\d))/g, ','); // Format sebagai bilangan desimal
                                }
                                var newRow = '<tr>' +
                                    '<td style="font-size:11px;text-align:center;">' + no + '</td>' +
                                    '<td style="font-size:11px;">' + item.retur_tgl + '</td>' +
                                    '<td style="font-size:11px;">' + item.retur_brg_id + '</td>' +
                                    '<td style="font-size:11px;">' + item.retur_brg_nama + '</td>' +
                                    '<td style="font-size:11px;text-align:center;">' + item.retur_brg_sat + '</td>' +
                                    '<td style="font-size:11px;text-align:center;">' + item.retur_brg_kat + '</td>' +
                                    '<td style="font-size:11px;text-align:right;">' + ret_harpok.toLocaleString('id-ID') + '</td>' +
                                    '<td style="font-size:11px;text-align:center;">' + formatted_ret_qty + '</td>' +
                                    '<td style="font-size:11px;text-align:right;">' + ret_subtotal.toLocaleString('id-ID') + '</td>' +
                                    '<td style="font-size:11px;">' + item.retur_keterangan + '</td>' +
                                    '<td style="font-size:11px;">' + item.reg_name + '</td>' +
                                    '</tr>';
                                $('#tbl_tampil tbody').append(newRow);

                            
                        });
                        
                } else {
                        console.log("No data found.");
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX error:", error);
            }
        });
    });
});
</script>

<script type="text/javascript">
$(document).on('click', '.btn-hapus', function() {
    var noid = $(this).data('noid');
    var kdbrg = $(this).data('kdbrg');
    $('#txtkode').val(noid);
    $('#kdbrgVal').text(kdbrg);
});
</script>

<script type="text/javascript">
$(document).on('click', '.btn-lihat', function() {
    $('#tbl_file tbody').empty();
    var noid = $(this).data('noid');
    var idbrg = $(this).data('idbrg');
    var kode = $(this).data('noid');
    $.ajax({
        type: "POST",
        url: "<?php echo base_url().'admin/retur/get_tampil_retur';?>",
        data: {
            kode: kode
        },
        dataType: 'json',
        success: function (data) {
            // console.log(data);
            // console.log(kode);
            if (data.length !== 0) {
                $.each(data, function (index, item) { 
                    var harpok = parseFloat(item.retur_harpok);
                    var harjul = parseFloat(item.retur_harjul);
                    var ret_qty = parseFloat(item.retur_qty);
                    var subtot_harpok = harpok * ret_qty;
                    var subtot_harjul = harjul * ret_qty;
                    var formatted_ret_qty;
                    if (Math.floor(ret_qty) === ret_qty) {
                        formatted_ret_qty = ret_qty.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ','); // Format sebagai bilangan bulat
                    } else {
                        formatted_ret_qty = ret_qty.toFixed(2).replace('.', ',').replace(/\.?0+$/, '').replace(/\B(?=(\d{3})+(?!\d))/g, ','); // Format sebagai bilangan desimal
                    }
                    $('#tgl3').val(item.retur_tgl_trans);
                    $('#nofak3').val(item.retur_no);
                    $('#regid3').val(item.reg_name);
                    $('#idbrg3').val(item.retur_brg_id);
                    $('#nmbrg3').val(item.retur_brg_nama);
                    $('#satbrg3').val(item.retur_brg_sat);
                    $('#katbrg3').val(item.retur_brg_kat);
                    $('#harpokbrg3').val(harpok.toLocaleString('id-ID'));
                    $('#harpokbrg3b').val(subtot_harpok.toLocaleString('id-ID'));
                    $('#harjulbrg3').val(harjul.toLocaleString('id-ID'));
                    $('#harjulbrg3b').val(subtot_harjul.toLocaleString('id-ID'));
                    $('#qtyret3').val(formatted_ret_qty);
                    $('#ket3').val(item.retur_keterangan);
                });
            } else {
                    console.log("No data found.");
            }
            
        },
        error: function (xhr, status, error) {
            console.error("AJAX error:", error);
            alert('Terjadi kesalahan saat mengirim permintaan AJAX.'); // Memberikan umpan balik kepada pengguna
        }
    });

    //menampilkan file / Dokumen Retur
    $.ajax({
        type: "POST",
        url: "<?php echo base_url().'admin/retur/get_retur_file';?>",
        data: { 
            noid : noid,
            idbrg : idbrg
        },
        dataType: 'json',
        success: function (data) {
            if (data.error) {
                //console.error("Error:", data.error);
            } else {
                //console.log("Received data:", data);
                // Check if data is empty
                if (data.length === 0) {
                    //console.log("No data found.");
                } else {
                        dataretur = data.queryA;
                        dataFile = data.queryB;
                        $.each(dataFile, function (index, itemB) {
                            var newRow = '<tr>' +
                                '<td style="text-align:center;vertical-align:middle;"><input type="text" name="nmfile[]" value="' + itemB.r_file + '" class="form-control input-sm nmfile" style="width:100%;" readonly></td>' +
                                '<td style="text-align:center;vertical-align:middle;"><img class="modal-image imgfile" alt="File" style="width:100px;height:100px;" src="<?php echo base_url();?>assets/img/file_retur/' + itemB.r_file + '"></td>' +
                                '<td style="text-align:center;vertical-align:middle;">' +
                                '<a href="<?php echo base_url();?>assets/img/file_retur/' + itemB.r_file + '" class="btn btn-info btn-xs" download="' + itemB.r_file + '" title="Unduh File"><span class="fa fa-download"></span> </a> ' +
                                '<a href="<?php echo base_url();?>assets/img/file_retur/' + itemB.r_file + '" class="btn btn-success btn-xs" target="_blank" title="Buka File"><span class="fa fa-eye"></span> </a> ' +
                                '</td>' +
                                '</tr>';

                            $('#tbl_file tbody').append(newRow);
                        });
                }
            }
        },
        error: function (xhr, status, error) {
            console.error("AJAX error:", error);
        }
    }); 
    //------------------------

});
</script>

<script type="text/javascript">
    $(document).ready(function(){
        $(document).on('click', '.btn-cariproduk', function () {
            var regid=$('#regid').val();
            if (regid !== "") {
                $('#modalCari').modal('show');
                //cariProduk();
            } else {
                alert('Pilih Cabang terlebih dahulu,');
                setTimeout(function() {
                    $("#regid").focus(); // Tambahkan delay untuk memastikan pengaturan fokus berhasil
                }, 0);
            }
        }); 

        $('select[name="regid"]').on('change', function() {
            var idbrg = $('#idbrg').val();
            var regid = $(this).val(); 
            if (regid !== "" && idbrg !== "") {
                $('#qtyret').val('');
                cariProduk();
                setTimeout(function() {
                    $("#qtyret").focus();
                    }, 100);
                }
        });


        //pencarian kode barang pada elemen idbrg
        // $("#idbrg").on("input",function(){
        //     var regid=$('#regid').val();
        //     if (regid !== "") {
        //         cariProduk();
        //     } else {
        //         alert('Pilih Cabang terlebih dahulu,');
        //         setTimeout(function() {
        //             $("#regid").focus(); // Tambahkan delay untuk memastikan pengaturan fokus berhasil
        //         }, 0);
        //     }
        // });

        function cariProduk() {
            $('#tbl_infobrg').show();
            $('#nmbrg').val('');
            $('#satbrg').val('');
            $('#katbrg').val('');
            $('#harpokbrg').val('');
            $('#harjulbrg').val('');
            $('#stokbrg').val('');
            var idbrg=$('#idbrg').val();
            var regid=$('#regid').val();
            $.ajax({
                type: "POST",
                url: "<?php echo base_url().'admin/retur/get_barang';?>",
                data: {
                    idbrg : idbrg,
                    regid  : regid 
                },
                dataType: 'json',
                success: function (data) {
                    // console.log(idbrg);
                    // console.log(regid);
                    if (data.error) {
                        alert('Terjadi kesalahan: ' + data.error); // Memberikan umpan balik kepada pengguna
                    } else {
                        
                        $.each(data, function (index, item) {
                            var harpok = parseFloat(item.barang_harpok);
                            var harjul = parseFloat(item.barang_harjul);
                            var stok = parseFloat(item.stok_cabang);
                            var formatted_stok;
                            if (Math.floor(stok) === stok) {
                                formatted_stok = stok.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ','); // Format sebagai bilangan bulat
                            } else {
                                formatted_stok = stok.toFixed(2).replace('.', ',').replace(/\.?0+$/, '').replace(/\B(?=(\d{3})+(?!\d))/g, ','); // Format sebagai bilangan desimal
                            } 
                            $('#nmbrg').val(item.barang_nama);
                            $('#satbrg').val(item.barang_satuan);
                            $('#katbrg').val(item.barang_kategori_nama);
                            $('#harpokbrg').val(harpok.toLocaleString('id-ID'));
                            $('#harjulbrg').val(harjul.toLocaleString('id-ID'));
                            $('#stokbrg').val(formatted_stok);
                            //$('#qtyret').attr('max', stok);
                            $('#qtyret').attr('max', formatted_stok);

                        });
                        
                    }
                },
                error: function (xhr, status, error) {
                    console.error("AJAX error:", error);
                    alert('Terjadi kesalahan saat mengirim permintaan AJAX.'); // Memberikan umpan balik kepada pengguna
                }
            });
        }

        $('#modalCari').on('hidden.bs.modal', function () {
            cariProduk();
            setTimeout(function() {
            $("#qtyret").focus();
            }, 100);
        });
        
    });

    function pilihKode(id) {
        //console.log(id);
        $('#idbrg').val(id);
        $('#modalCari').modal('hide');
    }
    

</script>

<script type="text/javascript">	
$(document).on('input', 'input[name^="qtyret"]', function(e) {
    var inputValue = e.target.value;
    var sanitizedValue = inputValue.replace(/[^0-9,\b\t]/g, ''); 
    e.target.value = sanitizedValue;
});

//membatasi input qty sesuai stok yang tersedia
var inputElements = document.querySelectorAll('input[name^="qtyret"]');
inputElements.forEach(function(inputElement) {
    inputElement.addEventListener('input', function() {
        var min = parseFloat(this.min);
        var value = parseFloat(this.value.replace(',', '.'));
        var max = parseFloat(this.max.replace(',', '.'));
        if (isNaN(value)) {
            this.value = this.min;
        } else if (value < this.min) {
            this.value = this.min;
        } else if (value > max) {
            this.value = this.max;
        }
    });
})

$('input[name^="qtyret"]').blur(function() {
    var value = parseFloat(this.value.replace(',', '.'));
    if (value === 0) {
        this.value = ''; // Kosongkan elemen input jika nilai adalah 0
        return;
    }
});
</script>


</body>

</html>
