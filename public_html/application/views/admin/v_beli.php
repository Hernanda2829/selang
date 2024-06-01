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

    <title>Data Pembelian</title>
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
    font-size: 12px;
    }

    .bootstrap-datetimepicker-widget {
        font-size: 10px; 
    }

    .bootstrap-datetimepicker-widget table {
        line-height: 1 !important; 
    }

    .bootstrap-datetimepicker-widget table th,
    .bootstrap-datetimepicker-widget table td {
        padding: 1px !important; 
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
            <li class="active"><a data-toggle="tab" href="#tab1" style="font-size:12px;"><b>Input Stok Pembelian</b></a></li>
            <li><a data-toggle="tab" href="#tab2" style="font-size:12px;"><b>Data Pembelian</b></a></li>
            <!-- Tambahkan lebih banyak tab sesuai kebutuhan -->
        </ul> 
        <!-- Isi Tab -->
        <div class="tab-content">
            <!-- Tab 1: Informasi -->
            <div id="tab1" class="tab-pane fade in active">
                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h3 class="page-header">Data
                            <small>Pembelian</small>
                            <a href="#" data-toggle="modal" data-target="#largeModal" class="pull-right"><small>Lihat Produk!</small></a>
                        </h3>
                    </div>
                </div>
                <!-- /.row -->
                <!-- Projects Row -->
                <div class="row">
                    <div class="col-lg-12">
                        <table class="table table-bordered table-condensed table-striped" style="font-size:11px;" id="mydata">
                            <thead>
                                <tr>
                                    <th style="max-width:10px;vertical-align:middle;text-align:center;width:40px;background-image:none!important;">No</th>
                                    <th style="width:30px;vertical-align:middle;text-align:center;background-image:none!important">No Faktur</th>
                                    <th style="max-width:20px;vertical-align:middle;text-align:center;background-image:none!important">Tanggal Pembelian</th>
                                    <th style="vertical-align:middle;text-align:center;background-image:none!important">Suplier</th>
                                    <th style="vertical-align:middle;text-align:center;background-image:none!important">Kode Barang</th>
                                    <th style="vertical-align:middle;text-align:center;background-image:none!important">Nama Barang</th>
                                    <th style="padding-left:5px;max-width:20px;text-align:center!important;vertical-align:middle;" data-orderable="false">Satuan</th>
                                    <th style="max-width:30px;text-align:center;background-image:none!important">Jumlah Beli (Qty)</th>
                                    <th style="text-align:center;background-image:none!important">Harga Beli (HB)</th>
                                    <th style="width:75px;text-align:center;background-image:none!important" title="Kisaran Harga Bottom/Pokok Per Satuan Barang">Kisaran Harga Satuan (HB/Qty)</th>
                                    <th style="width:120px;vertical-align:middle;text-align:center;" data-orderable="false">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                                $no=0;
                                foreach ($data->result_array() as $a):
                                    $no++;
                                    $idbeli=$a['d_beli_id'];
                                    $nofak=$a['d_beli_nofak'];
                                    $tgl=$a['beli_tanggal'];
                                    $spl=$a['beli_suplier_nama'];
                                    $idbrg=$a['d_beli_barang_id'];
                                    $nmbrg=$a['d_beli_barang_nama'];
                                    $satbrg=$a['d_beli_barang_satuan'];
                                    $jml=$a['d_beli_jumlah'];
                                    $hb=$a['d_beli_harga'];
                                    $hp=$a['harpok'];
                                    $aw_stok=$a['awal_stok'];
                                    $ak_stok=$a['akhir_stok'];
                                    $ps=$a['proses_stok'];
                                    $ss=$a['status_stok'];
                                    $databrg=$this->M_beli->find_brg($idbrg)->result_array();

                            ?>
                                <tr>
                                    <?php
                                    if (floor($jml) == $jml) {
                                                $formatted_jml = number_format($jml, 0, ',', '.');
                                    } else {
                                        $formatted_jml = number_format($jml, 2, ',', '.');
                                        $formatted_jml = rtrim($formatted_jml, '0');
                                        $formatted_jml = rtrim($formatted_jml, ',');
                                    }
                                    ?>
                                    <td style="text-align:center;"><?php echo $no;?></td>
                                    <td><?php echo $nofak;?></td>
                                    <td><?php echo $tgl;?></td>
                                    <td><?php echo $spl;?></td>
                                    <td><?php echo $idbrg;?></td>
                                    <td><?php echo $nmbrg;?></td>
                                    <td style="text-align:center;"><?php echo $satbrg;?></td>
                                    <td style="text-align:right;"><?php echo $formatted_jml;?></td>
                                    <td style="text-align:right;"><?php echo 'Rp ' . str_replace(',', '.', number_format($hb));?></td>
                                    <td style="text-align:right;">
                                    <a class="btn-ubah" href="#modalUbah" data-toggle="modal" data-kdbrg="<?php echo $idbrg;?>" data-harpok="<?php echo $hp;?>" title="Edit Harga Pokok/Bottom Pada Data Barang"><span class="fa fa-edit"></span></a>
                                    <?php echo 'Rp ' . str_replace(',', '.', number_format($hp));?>
                                    </td>
                                    <td style="text-align:center;">
                                    <?php 
                                    if( $ps !=='1') { //jika proses stok 0 / belum di proses stok
                                        if (!empty($databrg)) {
                                            echo '<a class="btn btn-xs btn-warning btn-input" href="#modalInput" data-toggle="modal" data-idbeli="'.$idbeli.'" data-kdbrg="'.$idbrg.'" data-nofak="'.$nofak.'" data-tgl="'.$tgl.'" data-jumbel="'.$jml.'" title="Masukan Data sebagai Stok Barang"><span class="fa fa-edit"></span> Input Stok </a> ';
                                            echo '<a class="btn btn-xs btn-success btn-edit" href="#modalEdit" data-toggle="modal" data-idbeli="'.$idbeli.'" data-kdbrg="'.$idbrg.'" data-nmbrg="'.htmlspecialchars($nmbrg).'" data-satbrg="'.$satbrg.'" data-jumbel="'.$jml.'" data-harbel="'.$hb.'" data-tgl="'.$tgl.'" title="Edit Data Beli"><span class="fa fa-pencil"></span> Edit</a> ';
                                        }else{
                                            echo '<a class="btn btn-xs btn-warning btn-kodebaru" href="#modalKodeBaru" data-toggle="modal" data-nofak="'.$nofak.'" data-idbeli="'.$idbeli.'" data-kdbrg="'.$idbrg.'" data-nmbrg="'.htmlspecialchars($nmbrg).'" data-satbrg="'.$satbrg.'" data-jumbel="'.$jml.'" data-harbel="'.$hb.'" title="Masukan Data sebagai Stok Kode Barang Baru"><span class="fa fa-edit"></span> Input Stok </a> ';
                                            echo '<a class="btn btn-xs btn-success btn-edit" href="#modalEdit" data-toggle="modal" data-idbeli="'.$idbeli.'" data-kdbrg="'.$idbrg.'" data-nmbrg="'.htmlspecialchars($nmbrg).'" data-satbrg="'.$satbrg.'" data-jumbel="'.$jml.'" data-harbel="'.$hb.'" data-tgl="'.$tgl.'" title="Edit Data Beli"><span class="fa fa-pencil"></span> Edit</a> ';
                                        }
                                    }else{  //jika sudah proses stok
                                        if ($ss==0) {   // status stok 0 untuk kode barang lama
                                            echo '<a class="btn btn-xs btn-info btn-lihat" href="#modalLihat" data-toggle="modal" data-idbeli="'.$idbeli.'" data-kdbrg="'.$idbrg.'" data-tgl="'.$tgl.'" data-awstok="'.$aw_stok.'" data-akstok="'.$ak_stok.'" title="Sudah Proses Stok Data Kode Barang Lama"><span class="fa fa-eye"></span> Sudah Input Stok </a> ';
                                        }else{  // status stok 1 untuk kode barang baru
                                            //echo '<p style="color: red;"> Sudah Input Stok Kode Barang Baru </p>';
                                            echo '<a class="btn btn-xs btn-info btn-lihatbaru" href="#modalStokBaru" data-toggle="modal" data-idbeli="'.$idbeli.'" data-kdbrg="'.$idbrg.'" data-tgl="'.$tgl.'" data-awstok="'.$aw_stok.'" data-akstok="'.$ak_stok.'" title="Sudah Proses Stok Data Kode Barang Baru" style="color:#c9302c;"><span class="fa fa-eye"></span> Sudah Input Stok </a> ';
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
            </div>

            <div id="tab2" class="tab-pane fade">
                <br>
                <div class="row">
                    <div class="col-lg-6">
                        <form class="form-horizontal" method="post" action="" target="_blank">
                        <table style="font-size:12px;margin-bottom:10px;">
                            <tr>
                                <th style="width:5%;vertical-align:middle;">Tgl Transaksi :</th>
                                <td style="width:10%;vertical-align:middle;">
                                    <div class="input-group date" id="datepicker1">
                                        <input type="text" id="tgl1" name="tgl1" class="form-control input-sm" style="font-size:11px;color:green;" placeholder="Tanggal..." value="<?= $firstDayOfMonth; ?>" required>
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                </td>
                                <td style="width:2%;vertical-align:middle;text-align:center"> S/d</td>
                                <td style="width:10%;vertical-align:middle;">
                                    <div class="input-group date" id="datepicker2">
                                        <input type="text" id="tgl2" name="tgl2" class="form-control input-sm" style="font-size:11px;color:green;" placeholder="Tanggal..." value="<?= $lastDayOfMonth; ?>" required>
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                </td>
                                <td style="width:4%;vertical-align:middle;padding-left:10px;">
                                    <a class="btn btn-sm btn-info btn-tampil" data-toggle="modal" title="Tampilkan Data"><span class="fa fa-search"></span></a>
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
                                    <th style="text-align:center">No</th>  
                                    <th style="text-align:center">No Faktur</th>     
                                    <th style="text-align:center">Tgl Pembelian</th>
                                    <th style="text-align:center">Suplier</th>
                                    <th style="text-align:center;width:200px;">Aksi</th>
                                    </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $no=0;
                                foreach ($pembelian as $b):
                                    $no++;
                                    $b_id = $b['beli_kode'];
                                    $b_nofak = $b['beli_nofak'];
                                    $b_tgl = $b['beli_tanggal'];
                                    $b_suplier = $b['beli_suplier_nama'];
                                ?>
                                <tr>
                                    <td style="text-align:center;"><?php echo $no;?></td>
                                    <td><?php echo $b_nofak;?></td>
                                    <td><?php echo $b_tgl;?></td>
                                    <td><?php echo $b_suplier;?></td>
                                    <td style="text-align:center;">
                                        <a class="btn btn-xs btn-info btn-lihatbeli" href="#modalLihatBeli" data-toggle="modal" data-noid="<?= $b_id ;?>" data-nofak="<?= $b_nofak ;?>" data-nmsup="<?= $b_suplier ;?>" title="Lihat Data Pembelian"><span class="fa fa-eye"></span> Lihat Data</a>
                                        <a class="btn btn-xs btn-danger btn-hapusbeli" href="#modalHapusBeli" data-toggle="modal" data-noid="<?= $b_id ;?>" data-nofak="<?= $b_nofak ;?>" data-nmsup="<?= $b_suplier ;?>" title="Hapus Data Pembelian"><span class="fa fa-trash"></span> Hapus Data</a>
                                    </td>
                                </tr>
                            <?php endforeach;?>
                            
                            </tbody>
                        </table>
                    </div>
                </div>                     

            </div>
        </div>
        
        <!-- ============ MODAL HAPUS BELI=============== -->               
        <div id="modalHapusBeli" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 class="modal-title" id="myModalLabel">Hapus Data Pembelian</h3>
            </div>
            <form class="form-horizontal" method="post" action="<?php echo base_url().'admin/beli/hapus_data_beli'?>">
                <div class="modal-body">
                    <p>Yakin mau menghapus Data Pembelian : <br>
                    No Faktur : <b><span id="nofakVal"></span></b><br>
                    Nama Suplier : <b><span id="nmsupVal"></span></b></p>
                    <input name="txtkode" id="txtkode" type="hidden">
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Hapus</button>
                    <button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
                </div>
            </form>
        </div>
        </div>
        </div>

        <!-- ============ MODAL Lihat Pembelian =============== -->
        <div id="modalLihatBeli" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 class="modal-title" id="myModalLabel">Informasi Pembelian </h3>
        </div>
        <div class="modal-body" style="overflow:scroll;height:450px;">
            <p style="font-size: 11px; margin-bottom: 0;">
                Nama Suplier : <b><span id="nmsupValue2" style="color: green;"></span></b>
            </p>
            <p style="font-size: 11px; margin-bottom: 0;">
                No Faktur : <b><span id="nofakValue2"></span></b>
            </p>
            <table id="detailTable" class="table table-bordered table-condensed" style="font-size:11px;margin-top:10px;">
            <thead>
                <tr>
                    <th style="text-align:center;">No</th>
                    <th style="text-align:center;">Kode Barang</th>
                    <th style="text-align:center;">Nama Barang</th>
                    <th style="text-align:center;">Satuan</th>
                    <th style="text-align:center;">Quantity</th>
                    <th style="text-align:center;">Harga Beli</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
            </table>
        </div>    
            <div class="modal-footer">   
                <button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
            </div>
        </div>
        </div>
        </div>
        

        <!-- ============ MODAL FIND =============== -->
        <div class="modal fade" id="largeModal" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
            <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 class="modal-title" id="myModalLabel">Data Barang - <?php echo $userid['reg_code'];?>  <?php echo $userid['reg_name'];?></h3>
            </div>
                <div id="barangForm" class="modal-body" style="overflow:scroll;height:450px;">

                  <table class="table table-bordered table-condensed" style="font-size:11px;" id="mydata2">
                    <thead>
                        <tr>
                            <th style="text-align:center;width:40px;background-image:none!important">No</th>
                            <th style="width:120px;background-image:none!important">Kode Barang</th>
                            <th style="width:240px;background-image:none!important">Nama Barang</th>
                            <th style="width:30px;background-image:none!important">Kode Disc</th>
                            <th style="background-image:none!important">Satuan</th>
                            <th style="width:100px;background-image:none!important">Harga Pokok</th>
                            <th style="width:100px;background-image:none!important">Harga Jual</th>
                            <th style="width:30px;background-image:none!important">Kategori</th>
                            <th style="background-image:none!important">Stok</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                        $no=0;
                        foreach ($brg->result_array() as $sd):
                        $no++;
                        $id=$sd['barang_id'];
                        $nm=$sd['barang_nama'];
                        $disc_id=$sd['barang_disc_id'];
                        $satuan=$sd['barang_satuan'];
                        $harpok=$sd['barang_harpok'];
                        $harjul=$sd['barang_harjul'];
                        $kat_nama=$sd['barang_kategori_nama'];
                        $stok=$sd['stok_cabang'];
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
                            <td style="text-align:right;"><?php echo 'Rp ' . str_replace(',', '.', number_format($harpok)); ?></td>
                            <td style="text-align:right;"><?php echo 'Rp ' . str_replace(',', '.', number_format($harjul)); ?></td>
                            <td style="text-align:center;"><?php echo $kat_nama;?></td>
                            <td style="text-align:center;"><?php echo $formatted_stok;?></td>
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
        
        <!-- ============ MODAL Lihat Stok Baru =============== -->
        <div id="modalStokBaru" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
            <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 class="modal-title" id="myModalLabel">Input Stok - <?php echo $userid['reg_code'];?>  <?php echo $userid['reg_name'];?></h3>
            </div>
            <form class="form-horizontal" method="post" action="#">
                <div class="modal-body">
                    <p> Data Kode Barang ( <b> <span id="idbrgbaruValA"></span> </b> ) Belum Terdaftar :</p>
                    <table id="tbl_lihatkdbaruA" class="table table-bordered table-condensed" style="font-size:11px;">
                    <thead>
                    <tr>
                        <th style="text-align:center;">Kode Barang</th>
                        <th style="text-align:center;">Nama Barang</th>
                        <th style="text-align:center;">Satuan</th>
                        <th style="text-align:center;">Jumlah Beli (Jml)</th>
                        <th style="text-align:center;">Harga Beli (HB)</th>
                        <th style="text-align:center;">Harpok (HB/Jml)</th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                    </table>  
                    <p> Data Pembelian Kode Barang (<b> <span id="idbrgbaruValB"></span> </b>) Tgl_Beli : <b><span id="tglbaruVal"></span></b></p>
                    <table id="tbl_lihatkdbaruB" class="table table-bordered table-condensed" style="font-size:11px;">
                    <thead>
                    <tr>
                        <th style="text-align:center;">Kode Barang</th>
                        <th style="text-align:center;">Nama Barang</th>
                        <th style="text-align:center;">Satuan</th>
                        <th style="text-align:center;">Kategori</th>
                        <th style="text-align:center;">Harga Pokok</th>
                        <th style="text-align:center;">Harga Jual</th>
                        <th style="text-align:center;">Stok Awal</th>
                        <th style="text-align:center;">Stok Akhir</th>
                        <th style="text-align:center;">Stok Saat Ini</th>
                    </tr>
                    </thead>
                    <tbody>
                    
                    </tbody>
                    </table>  
                    <p> Sudah dilakukan proses Input Stok pada tanggal : <b> <span id="tglprosesbaruVal"></span> </b>.</p>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-info">Update</button>    
                    <button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
                </div>
            </form>
            </div>
            </div>
        </div>

        <!-- ============ MODAL Lihat Sudah Proses Stok =============== -->
        <div id="modalLihat" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
            <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 class="modal-title" id="myModalLabel">Lihat Data Input Stok - <?php echo $userid['reg_code'];?>  <?php echo $userid['reg_name'];?></h3>
            </div>
            <form class="form-horizontal" method="post" action="#">
                <div class="modal-body">
                    <p> Data Kode Barang ( <b> <span id="idbrgLihatVal"></span> </b> ) sudah Terdaftar :</p>
                    
                <table id="tbl_lihat_databrg" class="table table-bordered table-condensed" style="font-size:11px;">
                <thead>
                <tr>
                    <th style="text-align:center;">Kode Barang</th>
                    <th style="text-align:center;">Nama Barang</th>
                    <th style="text-align:center;">Satuan</th>
                    <th style="text-align:center;">Harga Pokok</th>
                    <th style="text-align:center;">Harga Jual</th>
                    <th style="text-align:center;">Stok Awal</th>
                    <th style="text-align:center;">Stok Akhir</th>
                    <th style="text-align:center;">Stok Saat Ini</th>
                </tr>
                </thead>
                <tbody></tbody>
                </table>  
                <hr/>
                <p> Data Pembelian Kode Barang (<b> <span id="kdbrgLihatVal"></span> </b>) Tgl_Beli : <b><span id="tglbeliLihatVal"></span></b></p>
                <table id="tbl_lihat_databeli" class="table table-bordered table-condensed" style="font-size:11px;">
                    <thead>
                    <tr>
                        <th style="text-align:center;">Kode Barang</th>
                        <th style="text-align:center;">Nama Barang</th>
                        <th style="text-align:center;">Satuan</th>
                        <th style="text-align:center;">Jumlah Beli (Jml)</th>
                        <th style="text-align:center;">Harga Beli (HB)</th>
                        <th style="text-align:center;">Harpok (HB/Jml)</th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>  
                <p> Sudah dilakukan proses Input Stok pada tanggal : <b> <span id="tglprosesLihatVal"></span> </b>.</p>  

                </div>
                <div class="modal-footer">
                    <button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
                </div>
            </form>
            </div>
            </div>
        </div>

        <!-- ============ MODAL Ubah Harpok pada tbl_barang =============== -->
        <div id="modalUbah" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 class="modal-title" id="myModalLabel"><small>Edit Harga Pokok (Bottom) & Harga Jual (Price List)</small></h3>
            </div>
            <form class="form-horizontal" method="post" action="<?php echo base_url().'admin/beli/update_harpok'?>">
                <div class="modal-body">
                <p> Data Kode Barang ( <b> <span id="idbrgUbahVal"></span></b> ) Saat ini :</p>
                <input name="idbrgU" id="idbrgU" type="hidden">                 
                <table id="tbl_databrgU" class="table table-bordered table-condensed" style="font-size:11px;">
                <thead>
                <tr>
                    <th style="text-align:center;">Kode Barang</th>
                    <th style="text-align:center;">Nama Barang</th>
                    <th style="text-align:center;">Satuan</th>
                    <th style="text-align:center;">Harga Pokok</th>
                    <th style="text-align:center;">Harga Jual</th>
                    <th style="text-align:center;">Stok Saat Ini</th>
                </tr>
                </thead>
                <tbody></tbody>
                </table>  
                <hr/>
                <p> Silahkan Tentukan Harga Pokok & Harga Jual :</p>
                <table class="table table-bordered table-condensed" style="font-size:11px;">
                    <tr>
                        <th style="width:150px;padding-bottom:5px;vertical-align:middle;">Harga Pokok</th>
                        <td><input type="text" name="harpokU" id="harpokU" class="form-control input-sm" style="width:200px;" required></td>
                    </tr>
                    <tr>
                        <th style="width:150px;padding-bottom:5px;vertical-align:middle;">Harga Jual</th>
                        <td><input type="text" name="harjulU" id="harjulU" class="form-control input-sm" style="width:200px;" required></td>
                    </tr>
                </table>
                <p> Proses ini hanya akan merubah <b>Harga Pokok</b> dan <b>Harga Jual</b> pada menu <b>Data Barang</b>.</p>  
            
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-info">Update</button>    
                    <button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
                </div>
            </form>
            </div>
            </div>
        </div>
       
        <!-- ============ MODAL Input Stok Kode Barang Lama / sudah terdaftar=============== -->
        <div id="modalInput" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 class="modal-title" id="myModalLabel">Input Stok - <?php echo $userid['reg_code'];?>  <?php echo $userid['reg_name'];?></h3>
            </div>
            <form class="form-horizontal" method="post" action="<?php echo base_url().'admin/beli/update_stok'?>">
                <div class="modal-body">
                <p> Data Kode Barang ( <b> <span id="idbrgInputVal"></span></b> ) sudah Terdaftar :</p>
                <input name="kode" id="kode" type="hidden">
                <input name="nofak" id="nofak" type="hidden">
                <input name="idbrg" id="idbrg" type="hidden">
                <input name="nmbrg" id="nmbrg" type="hidden">
                <input name="satbrg" id="satbrg" type="hidden">
                <input name="jml" id="jml" type="hidden">
                <input name="katbrg" id="katbrg" type="hidden">    
                <table id="tbl_databrg" class="table table-bordered table-condensed" style="font-size:11px;">
                <thead>
                <tr>
                    <th style="text-align:center;">Kode Barang</th>
                    <th style="text-align:center;">Nama Barang</th>
                    <th style="text-align:center;">Satuan</th>
                    <th style="text-align:center;">Harga Pokok</th>
                    <th style="text-align:center;">Harga Jual</th>
                    <th style="text-align:center;">Stok Saat Ini</th>
                </tr>
                </thead>
                <tbody></tbody>
                </table>  
                <hr/>
                <p> Data Pembelian Kode Barang (<b> <span id="idbrgbeliVal"></span></b>) Tgl_Beli : <b><span id="tglbeliVal"></span></b></p>
                <table id="tbl_databeli" class="table table-bordered table-condensed" style="font-size:11px;">
                    <thead>
                    <tr>
                        <th style="text-align:center;">Kode Barang</th>
                        <th style="text-align:center;">Nama Barang</th>
                        <th style="text-align:center;">Satuan</th>
                        <th style="text-align:center;">Jumlah Beli (Jml)</th>
                        <th style="text-align:center;">Harga Beli (HB)</th>
                        <th style="text-align:center;">Harpok (HB/Jml)</th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>  
                <p> Proses Update ini hanya akan menambah <b>Stok</b> data barang yang sudah terdaftar dengan <b>Jumlah Beli</b>, tanpa merubah <b>Harga Pokok</b> dan <b>Harga Jual</b>.</p>  
                <hr/>
                <input id="cekbox" name="cekbox" type="checkbox"><span style="padding-left:10px"> Centang disini untuk merubah <b>Harga Pokok</b> dan <b>Harga Jual</b> pada menu <b>Data Barang</b></span></td>
                <table id="tbl_update_harpok" class="table table-bordered table-condensed" style="font-size:11px;display:none;margin-top:10px;">
                    <tr>
                        <th style="width:150px;padding-bottom:5px;vertical-align:middle;">Harga Pokok</th>
                        <td><input type="text" name="txtharpok" id="txtharpok" class="form-control input-sm" style="width:200px;" required></td>
                    </tr>
                    <tr>
                        <th style="width:150px;padding-bottom:5px;vertical-align:middle;">Harga Jual</th>
                        <td><input type="text" name="txtharjul" id="txtharjul" class="form-control input-sm" style="width:200px;" required></td>
                    </tr>
                </table>
            
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-info">Update</button>    
                    <button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
                </div>
            </form>
            </div>
            </div>
        </div>
        
        <!-- ============ MODAL Input Stok Kode Baru=============== -->
        <div id="modalKodeBaru" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 class="modal-title" id="myModalLabel">Input Stok Kode Barang Baru - <?php echo $userid['reg_code'];?>  <?php echo $userid['reg_name'];?></h3>
            </div>
            <form class="form-horizontal" method="post" action="<?php echo base_url().'admin/beli/tambah_barang'?>">
                <div class="modal-body">
                    <p> Data Kode Barang ( <b><span id="kodebrgVal"></span></b> ) Belum Terdaftar :</p>
                    <input name="nofakB" id="nofakB" type="hidden">
                    <input name="kodeB" id="kodeB" type="hidden">
                    <input name="idbrgB" id="idbrgB" type="hidden">
                    <input name="nmbrgB" id="nmbrgB" type="hidden">
                    <input name="satbrgB" id="satbrgB" type="hidden">
                    <input name="jmlB" id="jmlB" type="hidden">    
                    <table id="tbl_kodebaru" class="table table-bordered table-condensed" style="font-size:11px;">
                    <thead>
                    <tr>
                        <th style="text-align:center;">Kode Barang</th>
                        <th style="text-align:center;">Nama Barang</th>
                        <th style="text-align:center;">Satuan</th>
                        <th style="text-align:center;">Jumlah Beli (Jml)</th>
                        <th style="text-align:center;">Harga Beli (HB)</th>
                        <th style="text-align:center;">Harpok (HB/Jml)</th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                    </table>  
                
                    <table class="table table-bordered table-condensed" style="font-size:11px;">
                    <p>Jika ingin menjadikannya sebagai Kode Barang Baru,
                    <br>Tentukan Harga Pokok dan Harga Jualnya : </p>
                    <tr>
                        <th style="width:150px;padding-bottom:5px;vertical-align:middle;">Harga Pokok</th>
                        <td><input type="text" name="harpok" class="form-control input-sm" style="width:200px;" required></td>
                    </tr>
                    <tr>
                        <th style="width:150px;padding-bottom:5px;vertical-align:middle;">Harga Jual</th>
                        <td><input type="text" name="harjul" class="form-control input-sm" style="width:200px;" required></td>
                    </tr>
                    <tr>
                        <th style="width:150px;padding-bottom:5px;vertical-align:middle;">Kategori</th>
                        <td>
                            <select name="kategori" class="selectpicker show-tick" title="Pilih Kategori" data-width="50%" placeholder="Pilih Kategori" required >
                            <?php foreach ($kat->result_array() as $k) {
                                $id_kat=$k['kategori_id'];
                                $nm_kat=$k['kategori_nama'];
                                echo "<option style='font-size:11px;' value='$id_kat'>$nm_kat</option>";
                            }?>
                        </select> 
                        </td>  
                    </tr>
                    <tr>
                        <th style="width:90px;padding-bottom:5px;vertical-align:middle;">Diskon Penjualan</th>
                        <td>
                            <select name="diskon" class="selectpicker show-tick" title="Pilih Jenis Diskon" data-width="50%" placeholder="Pilih Diskon" required>
                            <?php foreach ($diskon->result_array() as $dc) {
                                $dc_id=$dc['disc_id'];
                                $dc_rate=$dc['disc_rate'];
                                    echo "<option style='font-size:11px;' value='$dc_id'>$dc_rate</option>";
                                }
                                    echo "<option style='font-size:11px;' value=0>Tidak Ada Diskon</option>";
                            ?>  
                            </select>
                        </td>    
                    </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-info">Update</button>    
                    <button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
                </div>
            </form>
            </div>
            </div>
        </div>

        <!-- ============ MODAL Edit =============== -->
        <div id="modalEdit" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 class="modal-title" id="myModalLabel">Edit Pembelian - <?php echo $userid['reg_code'];?>  <?php echo $userid['reg_name'];?></h3>
            </div>
            <form class="form-horizontal" method="post" action="<?php echo base_url().'admin/beli/edit_beli'?>">
                <div class="modal-body">
                    <input name="txtidE" id="txtidE" type="hidden">
                    <input name="txtidbrg" id="txtidbrg" type="hidden">
                    <input name="txttgl" id="txttgl" type="hidden">

                    <table class="table table-bordered table-condensed" style="font-size:11px;">
                    <tr>
                        <th style="width:150px;padding-bottom:5px;vertical-align:middle;">Kode Barang</th>
                        <td><input type="text" name="kdbrgE" id="kdbrgE" class="form-control input-sm" style="width:150px;" maxlength="15" required></td>
                    </tr>
                    <tr>
                        <th style="width:150px;padding-bottom:5px;vertical-align:middle;">Nama Barang</th>
                        <td><input type="text" name="nmbrgE" id="nmbrgE" class="form-control input-sm" style="width:300px;" maxlength="150" required></td>
                    </tr>
                    <tr>
                        <th style="width:150px;padding-bottom:5px;vertical-align:middle;">Satuan</th>
                        <td>
                            <select name="satbrgE" id="satbrgE" class="selectpicker show-tick" title="Pilih Satuan" data-width="37%" placeholder="Pilih Satuan" required >
                            <?php foreach ($units->result_array() as $u) {
                                $units_name=$u['units_name'];
                                $short_name=$u['short_name'];
                                echo "<option style='font-size:11px;' value='$short_name'>$units_name ($short_name) </option>";
                            }?>
                        </select> 
                        </td>
                    </tr>
                    <tr>
                        <th style="width:150px;padding-bottom:5px;vertical-align:middle;">Jumlah Beli</th>
                        <td><input type="text" name="jumbel" id="jumbel" class="form-control input-sm" style="width:150px;" required></td>
                    </tr>
                    <tr>
                        <th style="width:150px;padding-bottom:5px;vertical-align:middle;">Harga Beli</th>
                        <td><input type="text" name="harbel" id="harbel" class="form-control input-sm" style="width:150px;" required></td>
                    </tr>
                    </table>
                </div>
                
                <div class="modal-footer" style="display: flex; align-items: center; justify-content: space-between;">
                    <td style="display: flex; text-align: left;"><a class="btn btn-danger btn-hapus" href="#modalHapus" data-toggle="modal" title="Hapus Data Beli"><span class="fa fa-trash"></span> Hapus</a></td>
                    <div style="display: flex; margin-left: auto;">
                        <button type="submit" class="btn btn-info" title="Update Data Pembelian">Update</button>
                        <button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
                    </div>
                </div>

            </form>
            </div>
            </div>
        </div>
        

        <!-- ============ MODAL Hapus =============== -->
            <div id="modalHapus" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 class="modal-title" id="myModalLabel">Hapus Pembelian - <?php echo $userid['reg_code'];?>  <?php echo $userid['reg_name'];?></h3>
            </div>
            <form class="form-horizontal" method="post" action="<?php echo base_url().'admin/beli/hapus_beli'?>">
                <div class="modal-body">
                    <input name="txtidbeli" id="txtidbeli" type="hidden">
                    <p> Data Pembelian Kode Barang (<b> <span id="idbrgVal"></span> </b>) Tgl_Beli : <b><span id="tglVal"></span></b></p>
                    <table id="tbl_beli" class="table table-bordered table-condensed" style="font-size:11px;">
                    <thead>
                    <tr>
                        <th style="text-align:center;">Kode Barang</th>
                        <th style="text-align:center;">Nama Barang</th>
                        <th style="text-align:center;">Satuan</th>
                        <th style="text-align:center;">Jumlah Beli (Jml)</th>
                        <th style="text-align:center;">Harga Beli (HB)</th>
                        <th style="text-align:center;">Harpok (HB/Jml)</th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                    </table>  
                    <p>Yakin mau menghapus data tersebut ...?</p>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-info">Hapus</button>    
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
    <script src="<?php echo base_url().'assets/js/moment.js'?>"></script>
    <script src="<?php echo base_url().'assets/js/dataTable/bootstrap-datetimepicker.min.js'?>"></script>
    <script src="<?php echo base_url().'assets/js/jquery.dataTables.min.js'?>"></script>

    
   <script type="text/javascript">
    $(document).ready(function () {
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
 
    
    <script type="text/javascript">
        $(document).ready(function() {
            $('#mydata').DataTable();
            $('#mydata2').DataTable();
        } );
    </script>
    <script type="text/javascript">
    $(document).ready(function() {
        $(document).on('input', 'input[name^="harpok"]', function(e) {
            var inputValue = e.target.value;
            var sanitizedValue = inputValue.replace(/[^0-9\b\t]/g, ''); // Hapus karakter yang tidak diizinkan (selain angka, koma, backspace, delete, dan tab)
            e.target.value = sanitizedValue; // Update nilai input dengan karakter yang diizinkan
            var nilai = parseFloat($(this).val().replace(/[^\d.,]/g, '')) || 0;
            var formattednilai = nilai.toLocaleString('id-ID');
            $(this).val(formattednilai);
        });
        $(document).on('input', 'input[name^="harjul"]', function(e) {
            var inputValue = e.target.value;
            var sanitizedValue = inputValue.replace(/[^0-9\b\t]/g, ''); // Hapus karakter yang tidak diizinkan (selain angka, koma, backspace, delete, dan tab)
            e.target.value = sanitizedValue; // Update nilai input dengan karakter yang diizinkan
            var nilai = parseFloat($(this).val().replace(/[^\d.,]/g, '')) || 0;
            var formattednilai = nilai.toLocaleString('id-ID');
            $(this).val(formattednilai);
        });

        $(document).on('input', 'input[name^="harpokU"]', function(e) {
            var inputValue = e.target.value;
            var sanitizedValue = inputValue.replace(/[^0-9\b\t]/g, ''); // Hapus karakter yang tidak diizinkan (selain angka, koma, backspace, delete, dan tab)
            e.target.value = sanitizedValue; // Update nilai input dengan karakter yang diizinkan
            var nilai = parseFloat($(this).val().replace(/[^\d.,]/g, '')) || 0;
            var formattednilai = nilai.toLocaleString('id-ID');
            $(this).val(formattednilai);
        });
        $(document).on('input', 'input[name^="harjulU"]', function(e) {
            var inputValue = e.target.value;
            var sanitizedValue = inputValue.replace(/[^0-9\b\t]/g, ''); // Hapus karakter yang tidak diizinkan (selain angka, koma, backspace, delete, dan tab)
            e.target.value = sanitizedValue; // Update nilai input dengan karakter yang diizinkan
            var nilai = parseFloat($(this).val().replace(/[^\d.,]/g, '')) || 0;
            var formattednilai = nilai.toLocaleString('id-ID');
            $(this).val(formattednilai);
        });

        $(document).on('input', 'input[name^="txtharpok"]', function(e) {
            var inputValue = e.target.value;
            var sanitizedValue = inputValue.replace(/[^0-9\b\t]/g, ''); // Hapus karakter yang tidak diizinkan (selain angka, koma, backspace, delete, dan tab)
            e.target.value = sanitizedValue; // Update nilai input dengan karakter yang diizinkan
            var nilai = parseFloat($(this).val().replace(/[^\d.,]/g, '')) || 0;
            var formattednilai = nilai.toLocaleString('id-ID');
            $(this).val(formattednilai);
        });
        $(document).on('input', 'input[name^="txtharjul"]', function(e) {
            var inputValue = e.target.value;
            var sanitizedValue = inputValue.replace(/[^0-9\b\t]/g, ''); // Hapus karakter yang tidak diizinkan (selain angka, koma, backspace, delete, dan tab)
            e.target.value = sanitizedValue; // Update nilai input dengan karakter yang diizinkan
            var nilai = parseFloat($(this).val().replace(/[^\d.,]/g, '')) || 0;
            var formattednilai = nilai.toLocaleString('id-ID');
            $(this).val(formattednilai);
        });

        $(document).on('input', 'input[name^="jumbel"]', function(e) {
            var inputValue = e.target.value;
            var sanitizedValue = inputValue.replace(/[^0-9,\b\t]/g, ''); // Hapus karakter yang tidak diizinkan (selain angka, koma, backspace, delete, dan tab)
            e.target.value = sanitizedValue; // Update nilai input dengan karakter yang diizinkan
        });

        $(document).on('input', 'input[name^="harbel"]', function(e) {
            var inputValue = e.target.value;
            var sanitizedValue = inputValue.replace(/[^0-9\b\t]/g, ''); // Hapus karakter yang tidak diizinkan (selain angka, koma, backspace, delete, dan tab)
            e.target.value = sanitizedValue; // Update nilai input dengan karakter yang diizinkan
            var nilai = parseFloat($(this).val().replace(/[^\d.,]/g, '')) || 0;
            var formattednilai = nilai.toLocaleString('id-ID');
            $(this).val(formattednilai);
        });

        $(document).on('input', 'input[name^="kdbrg"]', function(e) {
            var inputValue = e.target.value;
            //var sanitizedValue = inputValue.replace(/[^0-9A-Za-z,\b\t]/g, ''); 
            var sanitizedValue = inputValue.replace(/[^0-9A-Za-z\-]/g, '');
            e.target.value = sanitizedValue; 
        });


    })
    </script>

<script type="text/javascript">
$(document).ready(function () {
    $(document).on('click', '.btn-kodebaru', function () {
        $('#tbl_kodebaru tbody').empty();
        var nofakB = $(this).data('nofak');
        var idbeliB = $(this).data('idbeli');
        var kdbrgB = $(this).data('kdbrg');
        var nmbrgB = $(this).data('nmbrg');
        var satbrgB = $(this).data('satbrg');
        var jumbelB = $(this).data('jumbel');
        $('#kodebrgVal').text(kdbrgB);
        $('#nofakB').val(nofakB);
        $('#kodeB').val(idbeliB);
        $('#idbrgB').val(kdbrgB);
        $('#nmbrgB').val(nmbrgB); 
        $('#satbrgB').val(satbrgB);
        $('#jmlB').val(jumbelB);

        $.ajax({
            url: "<?php echo base_url().'admin/beli/get_beli';?>",
            type: "POST",
            data: {
                idbeli: idbeliB
            },
            success: function (data) {
                // console.log("Data from server:", data);
                var parsedData = JSON.parse(data);
                if (parsedData.length !== 0) {   
                        $.each(parsedData, function (index, item) {     
                            var harbel = parseFloat(item.d_beli_harga);
                            var harpok = Math.ceil(item.harpok);
                            var qty = parseFloat(item.d_beli_jumlah);
                            var formatted_qty;
                            if (Math.floor(qty) === qty) {
                                formatted_qty = qty.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ','); // Format sebagai bilangan bulat
                            } else {
                                formatted_qty = qty.toFixed(2).replace('.', ',').replace(/\.?0+$/, '').replace(/\B(?=(\d{3})+(?!\d))/g, ','); // Format sebagai bilangan desimal
                            }   
                            var newRow = '<tr>' +
                                '<td style="font-size:11px;">' + item.d_beli_barang_id + '</td>' +
                                '<td style="font-size:11px;">' + item.d_beli_barang_nama + '</td>' +
                                '<td style="font-size:11px;">' + item.d_beli_barang_satuan + '</td>' +
                                '<td style="font-size:11px;text-align:center;">' + formatted_qty + '</td>' +
                                '<td style="font-size:11px;text-align:right;">' + harbel.toLocaleString('id-ID') + '</td>' +
                                '<td style="font-size:11px;text-align:right;">' + harpok.toLocaleString('id-ID') + '</td>' +
                                '</tr>';
                            $('#tbl_kodebaru tbody').append(newRow);
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

    $(document).on('click', '.btn-edit', function () {
        var idbeli = $(this).data('idbeli');
        var kdbrg = $(this).data('kdbrg');
        var nmbrg = $(this).data('nmbrg');
        var satbrg = $(this).data('satbrg');
        var tgl = $(this).data('tgl');
        var harbel = parseFloat($(this).data('harbel'));
        var jumbel = $(this).data('jumbel');
        var jumbelqty = parseFloat(jumbel);
        var formatted_qty;
        if (Math.floor(jumbelqty) === jumbelqty) {
            formatted_qty = jumbelqty.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ','); // Format sebagai bilangan bulat
        } else {
            formatted_qty = jumbelqty.toFixed(2).replace('.', ',').replace(/\.?0+$/, '').replace(/\B(?=(\d{3})+(?!\d))/g, ','); // Format sebagai bilangan desimal
        }
        $('#txtidE').val(idbeli);
        $('#kdbrgE').val(kdbrg);
        $('#nmbrgE').val(nmbrg); 
        $('#satbrgE').val(satbrg);
        $('#satbrgE').selectpicker('refresh');
        $('#jumbel').val(formatted_qty);
        $('#harbel').val(harbel.toLocaleString('id-ID'));
        $('#txtidbrg').val(kdbrg);
        $('#txttgl').val(tgl);

    });
});
</script>

<script type="text/javascript">
$(document).ready(function () {
    $(document).on('click', '.btn-lihatbaru', function () {
        $('#tbl_lihatkdbaruA tbody').empty();
        $('#tbl_lihatkdbaruB tbody').empty();
        var idbeli = $(this).data('idbeli');
        var idbrg = $(this).data('kdbrg');
        var tgl = $(this).data('tgl');
        var awstok = parseFloat($(this).data('awstok'));
        var akstok = parseFloat($(this).data('akstok'));
        var formatted_awstok;
        if (Math.floor(awstok) === awstok) {
            formatted_awstok = awstok.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ','); // Format sebagai bilangan bulat
        } else {
            formatted_awstok = awstok.toFixed(2).replace('.', ',').replace(/\.?0+$/, '').replace(/\B(?=(\d{3})+(?!\d))/g, ','); // Format sebagai bilangan desimal
        }
        var formatted_akstok;
        if (Math.floor(akstok) === akstok) {
            formatted_akstok = akstok.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ','); // Format sebagai bilangan bulat
        } else {
            formatted_akstok = akstok.toFixed(2).replace('.', ',').replace(/\.?0+$/, '').replace(/\B(?=(\d{3})+(?!\d))/g, ','); // Format sebagai bilangan desimal
        }
        

        //menampilkan data pembelian
        $.ajax({
            url: "<?php echo base_url().'admin/beli/get_beli';?>",
            type: "POST",
            data: {
                idbeli: idbeli
            },
            success: function (data) {
                //console.log("Data from server:", data);
                var parsedData = JSON.parse(data);
                if (parsedData.length !== 0) {
                    $.each(parsedData, function (index, item) {     
                        var harbel = parseFloat(item.d_beli_harga);
                        var harpok = Math.ceil(item.harpok);
                        var qty = parseFloat(item.d_beli_jumlah);
                        var formatted_qty;
                        if (Math.floor(qty) === qty) {
                            formatted_qty = qty.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ','); // Format sebagai bilangan bulat
                        } else {
                            formatted_qty = qty.toFixed(2).replace('.', ',').replace(/\.?0+$/, '').replace(/\B(?=(\d{3})+(?!\d))/g, ','); // Format sebagai bilangan desimal
                        }   
                        var newRow = '<tr>' +
                            '<td style="font-size:11px;">' + item.d_beli_barang_id + '</td>' +
                            '<td style="font-size:11px;">' + item.d_beli_barang_nama + '</td>' +
                            '<td style="font-size:11px;text-align:center;">' + item.d_beli_barang_satuan + '</td>' +
                            '<td style="font-size:11px;text-align:center;">' + formatted_qty + '</td>' +
                            '<td style="font-size:11px;text-align:right;">' + harbel.toLocaleString('id-ID') + '</td>' +
                            '<td style="font-size:11px;text-align:right;">' + harpok.toLocaleString('id-ID') + '</td>' +
                            '</tr>';
                        $('#tbl_lihatkdbaruA tbody').append(newRow);
                        $('#idbrgbaruValA').text(item.d_beli_barang_id);
                        $('#tglbaruVal').text(item.beli_tanggal);
                        $('#tglprosesbaruVal').text(item.tgl_proses);
                    });
                } else {
                        console.log("No data found.");
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX error:", error);
            }
        });

        //menampilkan data barang
        $.ajax({
            url: "<?php echo base_url().'admin/beli/get_brg';?>",
            type: "POST",
            data: {
                idbrg : idbrg
            },
            success: function (data) {
                var parsedData = JSON.parse(data);
                if (parsedData.length !== 0) {
                    $.each(parsedData, function (index, item) {     
                        var harpok = parseFloat(item.barang_harpok);
                        var harjul = parseFloat(item.barang_harjul);
                        var stok = parseFloat(item.stok_cabang);
                        var formatted_stok;
                        if (Math.floor(stok) === stok) {
                            formatted_stok = stok.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ','); // Format sebagai bilangan bulat
                        } else {
                            formatted_stok = stok.toFixed(2).replace('.', ',').replace(/\.?0+$/, '').replace(/\B(?=(\d{3})+(?!\d))/g, ','); // Format sebagai bilangan desimal
                        }   
                        var newRow = '<tr>' +
                            '<td style="font-size:11px;">' + item.barang_id + '</td>' +
                            '<td style="font-size:11px;">' + item.barang_nama + '</td>' +
                            '<td style="font-size:11px;text-align:center;">' + item.barang_satuan + '</td>' +
                            '<td style="font-size:11px;text-align:center;">' + item.barang_kategori_nama + '</td>' +
                            '<td style="font-size:11px;text-align:right;">' + harpok.toLocaleString('id-ID') + '</td>' +
                            '<td style="font-size:11px;text-align:right;">' + harjul.toLocaleString('id-ID') + '</td>' +
                            '<td style="font-size:11px;text-align:center;">' + formatted_awstok + '</td>' +
                            '<td style="font-size:11px;text-align:center;">' + formatted_akstok + '</td>' +
                            '<td style="font-size:11px;text-align:center;">' + formatted_stok + '</td>' +
                            '</tr>';
                        $('#tbl_lihatkdbaruB tbody').append(newRow);
                        $('#idbrgbaruValB').text(item.barang_id);
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
$(document).ready(function () {
    $(document).on('click', '.btn-lihat', function () {
        $('#tbl_lihat_databrg tbody').empty();
        $('#tbl_lihat_databeli tbody').empty();
        var idbeli = $(this).data('idbeli');
        var idbrg = $(this).data('kdbrg');
        var tgl = $(this).data('tgl');
        var awstok = parseFloat($(this).data('awstok'));
        var akstok = parseFloat($(this).data('akstok'));
        var formatted_awstok;
        if (Math.floor(awstok) === awstok) {
            formatted_awstok = awstok.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ','); // Format sebagai bilangan bulat
        } else {
            formatted_awstok = awstok.toFixed(2).replace('.', ',').replace(/\.?0+$/, '').replace(/\B(?=(\d{3})+(?!\d))/g, ','); // Format sebagai bilangan desimal
        }
        var formatted_akstok;
        if (Math.floor(akstok) === akstok) {
            formatted_akstok = akstok.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ','); // Format sebagai bilangan bulat
        } else {
            formatted_akstok = akstok.toFixed(2).replace('.', ',').replace(/\.?0+$/, '').replace(/\B(?=(\d{3})+(?!\d))/g, ','); // Format sebagai bilangan desimal
        }
        $('#kdbrgLihatVal').text(idbrg);
        $('#tglbeliLihatVal').text(tgl);

        //menampilkan data barang
        $.ajax({
            url: "<?php echo base_url().'admin/beli/get_brg';?>",
            type: "POST",
            data: {
                idbrg : idbrg
            },
            success: function (data) {
                var parsedData = JSON.parse(data);
                if (parsedData.length !== 0) {
                    $.each(parsedData, function (index, item) {
                        var harpok = parseFloat(item.barang_harpok);
                        var harjul = parseFloat(item.barang_harjul);
                        var stok = parseFloat(item.stok_cabang);
                        var formatted_stok;
                        if (Math.floor(stok) === stok) {
                            formatted_stok = stok.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ','); // Format sebagai bilangan bulat
                        } else {
                            formatted_stok = stok.toFixed(2).replace('.', ',').replace(/\.?0+$/, '').replace(/\B(?=(\d{3})+(?!\d))/g, ','); // Format sebagai bilangan desimal
                        }   
                        var newRow = '<tr>' +
                            '<td style="font-size:11px;">' + item.barang_id + '</td>' +
                            '<td style="font-size:11px;">' + item.barang_nama + '</td>' +
                            '<td style="font-size:11px;text-align:center;">' + item.barang_satuan + '</td>' +
                            '<td style="font-size:11px;text-align:right;">' + harpok.toLocaleString('id-ID') + '</td>' +
                            '<td style="font-size:11px;text-align:right;">' + harjul.toLocaleString('id-ID') + '</td>' +
                            '<td style="font-size:11px;text-align:center;">' + formatted_awstok + '</td>' +
                            '<td style="font-size:11px;text-align:center;">' + formatted_akstok + '</td>' +
                            '<td style="font-size:11px;text-align:center;">' + formatted_stok + '</td>' +
                            '</tr>';
                        $('#tbl_lihat_databrg tbody').append(newRow);
                        $('#idbrgLihatVal').text(item.barang_id); 
                    }); 
                } else {
                        console.log("No data found.");
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX error:", error);
            }
        });

        //menampilkan data pembelian
        $.ajax({
            url: "<?php echo base_url().'admin/beli/get_beli';?>",
            type: "POST",
            data: {
                idbeli: idbeli
            },
            success: function (data) {
                //console.log("Data from server:", data);
                var parsedData = JSON.parse(data);
                if (parsedData.length !== 0) {
                    $.each(parsedData, function (index, item) {     
                        var harbel = parseFloat(item.d_beli_harga);
                        var harpok = Math.ceil(item.harpok);
                        var qty = parseFloat(item.d_beli_jumlah);
                        var formatted_qty;
                        if (Math.floor(qty) === qty) {
                            formatted_qty = qty.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ','); // Format sebagai bilangan bulat
                        } else {
                            formatted_qty = qty.toFixed(2).replace('.', ',').replace(/\.?0+$/, '').replace(/\B(?=(\d{3})+(?!\d))/g, ','); // Format sebagai bilangan desimal
                        }   
                        var newRow = '<tr>' +
                            '<td style="font-size:11px;">' + item.d_beli_barang_id + '</td>' +
                            '<td style="font-size:11px;">' + item.d_beli_barang_nama + '</td>' +
                            '<td style="font-size:11px;text-align:center;">' + item.d_beli_barang_satuan + '</td>' +
                            '<td style="font-size:11px;text-align:center;">' + formatted_qty + '</td>' +
                            '<td style="font-size:11px;text-align:right;">' + harbel.toLocaleString('id-ID') + '</td>' +
                            '<td style="font-size:11px;text-align:right;">' + harpok.toLocaleString('id-ID') + '</td>' +
                            '</tr>';
                        $('#tbl_lihat_databeli tbody').append(newRow);
                        $('#kdbrgLihatVal').text(item.d_beli_barang_id);
                        $('#tglbeliLihatVal').text(item.beli_tanggal);
                        $('#tglprosesLihatVal').text(item.tgl_proses);
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
$(document).ready(function () {
    $(document).on('click', '.btn-ubah', function () {
        $('#tbl_databrgU tbody').empty();
        var idbrg = $(this).data('kdbrg');
        var harpokU = parseFloat($(this).data('harpok'));
        $('#idbrgU').val(idbrg);
        $('#idbrgUbahVal').text(idbrg);
    
        //menampilkan data barang
        $.ajax({
            url: "<?php echo base_url().'admin/beli/get_brg';?>",
            type: "POST",
            data: {
                idbrg : idbrg
            },
            success: function (data) {
                var parsedData = JSON.parse(data);
                if (parsedData.length !== 0) {
                    $.each(parsedData, function (index, item) {     
                        var harpok = parseFloat(item.barang_harpok);
                        var harjul = parseFloat(item.barang_harjul);
                        var stok = parseFloat(item.stok_cabang);
                        var formatted_stok;
                        if (Math.floor(stok) === stok) {
                            formatted_stok = stok.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ','); // Format sebagai bilangan bulat
                        } else {
                            formatted_stok = stok.toFixed(2).replace('.', ',').replace(/\.?0+$/, '').replace(/\B(?=(\d{3})+(?!\d))/g, ','); // Format sebagai bilangan desimal
                        }   
                        var newRow = '<tr>' +
                            '<td style="font-size:11px;">' + item.barang_id + '</td>' +
                            '<td style="font-size:11px;">' + item.barang_nama + '</td>' +
                            '<td style="font-size:11px;text-align:center;">' + item.barang_satuan + '</td>' +
                            '<td style="font-size:11px;text-align:right;">' + harpok.toLocaleString('id-ID') + '</td>' +
                            '<td style="font-size:11px;text-align:right;">' + harjul.toLocaleString('id-ID') + '</td>' +
                            '<td style="font-size:11px;text-align:center;">' + formatted_stok + '</td>' +
                            '</tr>';
                        $('#tbl_databrgU tbody').append(newRow); 
                        $('#harpokU').val(harpokU.toLocaleString('id-ID'));
                        $('#harjulU').val(harjul.toLocaleString('id-ID'));
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
$(document).ready(function () {
    $(document).on('click', '.btn-input', function () {
        $('#tbl_databrg tbody').empty();
        $('#tbl_databeli tbody').empty();
        var idbeli = $(this).data('idbeli');
        var idbrg = $(this).data('kdbrg');
        var tgl = $(this).data('tgl');
        var nofak = $(this).data('nofak');
        var jumbel = $(this).data('jumbel');

        $('#idbrgbeliVal').text(idbrg);
        $('#tglbeliVal').text(tgl);

        //menampilkan data barang
        $.ajax({
            url: "<?php echo base_url().'admin/beli/get_brg';?>",
            type: "POST",
            data: {
                idbrg : idbrg
            },
            success: function (data) {
                var parsedData = JSON.parse(data);
                if (parsedData.length !== 0) {
                    $.each(parsedData, function (index, item) {     
                        var harpok = parseFloat(item.barang_harpok);
                        var harjul = parseFloat(item.barang_harjul);
                        var stok = parseFloat(item.stok_cabang);
                        var formatted_stok;
                        if (Math.floor(stok) === stok) {
                            formatted_stok = stok.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ','); // Format sebagai bilangan bulat
                        } else {
                            formatted_stok = stok.toFixed(2).replace('.', ',').replace(/\.?0+$/, '').replace(/\B(?=(\d{3})+(?!\d))/g, ','); // Format sebagai bilangan desimal
                        }   
                        var newRow = '<tr>' +
                            '<td style="font-size:11px;">' + item.barang_id + '</td>' +
                            '<td style="font-size:11px;">' + item.barang_nama + '</td>' +
                            '<td style="font-size:11px;text-align:center;">' + item.barang_satuan + '</td>' +
                            '<td style="font-size:11px;text-align:right;">' + harpok.toLocaleString('id-ID') + '</td>' +
                            '<td style="font-size:11px;text-align:right;">' + harjul.toLocaleString('id-ID') + '</td>' +
                            '<td style="font-size:11px;text-align:center;">' + formatted_stok + '</td>' +
                            '</tr>';
                        $('#tbl_databrg tbody').append(newRow); 

                        //------------------------------
                        $('#kode').val(idbeli);
                        $('#nofak').val(nofak);
                        $('#idbrg').val(item.barang_id);
                        $('#nmbrg').val(item.barang_nama);
                        $('#satbrg').val(item.barang_satuan);
                        $('#jml').val(jumbel);
                        $('#katbrg').val(item.barang_kategori_nama);
                        $('#idbrgInputVal').text(item.barang_id);
                        $('#txtharpok').val(harpok.toLocaleString('id-ID'));
                        $('#txtharjul').val(harjul.toLocaleString('id-ID'));
                        //------------------------------


                    }); 
                } else {
                        console.log("No data found.");
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX error:", error);
            }
        });

        //menampilkan data pembelian
        $.ajax({
            url: "<?php echo base_url().'admin/beli/get_beli';?>",
            type: "POST",
            data: {
                idbeli: idbeli
            },
            success: function (data) {
                //console.log("Data from server:", data);
                var parsedData = JSON.parse(data);
                if (parsedData.length !== 0) {
                    $.each(parsedData, function (index, item) {     
                        var harbel = parseFloat(item.d_beli_harga);
                        var harpok = Math.ceil(item.harpok);
                        var qty = parseFloat(item.d_beli_jumlah);
                        var formatted_qty;
                        if (Math.floor(qty) === qty) {
                            formatted_qty = qty.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ','); // Format sebagai bilangan bulat
                        } else {
                            formatted_qty = qty.toFixed(2).replace('.', ',').replace(/\.?0+$/, '').replace(/\B(?=(\d{3})+(?!\d))/g, ','); // Format sebagai bilangan desimal
                        }   
                        var newRow = '<tr>' +
                            '<td style="font-size:11px;">' + item.d_beli_barang_id + '</td>' +
                            '<td style="font-size:11px;">' + item.d_beli_barang_nama + '</td>' +
                            '<td style="font-size:11px;text-align:center;">' + item.d_beli_barang_satuan + '</td>' +
                            '<td style="font-size:11px;text-align:center;">' + formatted_qty + '</td>' +
                            '<td style="font-size:11px;text-align:right;">' + harbel.toLocaleString('id-ID') + '</td>' +
                            '<td style="font-size:11px;text-align:right;">' + harpok.toLocaleString('id-ID') + '</td>' +
                            '</tr>';
                        $('#tbl_databeli tbody').append(newRow);
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
$(document).ready(function () {
    $(document).on('click', '.btn-hapus', function () {
        $('#tbl_beli tbody').empty();
        var idbeli = $('#txtidE').val();
        var idbrg = $('#txtidbrg').val();
        var tgl = $('#txttgl').val();

        $('#txtidbeli').val(idbeli);
        $('#idbrgVal').text(idbrg);
        $('#tglVal').text(tgl);

        $.ajax({
            url: "<?php echo base_url().'admin/beli/get_beli';?>",
            type: "POST",
            data: {
                idbeli: idbeli
            },
            success: function (data) {
                // console.log("Data from server:", data);
                var parsedData = JSON.parse(data);
                if (parsedData.length !== 0) {
                        
                        $.each(parsedData, function (index, item) {     
                            var harbel = parseFloat(item.d_beli_harga);
                            var harpok = Math.ceil(item.harpok);
                            var qty = parseFloat(item.d_beli_jumlah);
                            var formatted_qty;
                            if (Math.floor(qty) === qty) {
                                formatted_qty = qty.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ','); // Format sebagai bilangan bulat
                            } else {
                                formatted_qty = qty.toFixed(2).replace('.', ',').replace(/\.?0+$/, '').replace(/\B(?=(\d{3})+(?!\d))/g, ','); // Format sebagai bilangan desimal
                            }   
                            var newRow = '<tr>' +
                                '<td style="font-size:11px;">' + item.d_beli_barang_id + '</td>' +
                                '<td style="font-size:11px;">' + item.d_beli_barang_nama + '</td>' +
                                '<td style="font-size:11px;text-align:center;">' + item.d_beli_barang_satuan + '</td>' +
                                '<td style="font-size:11px;text-align:center;">' + formatted_qty + '</td>' +
                                '<td style="font-size:11px;text-align:right;">' + harbel.toLocaleString('id-ID') + '</td>' +
                                '<td style="font-size:11px;text-align:right;">' + harpok.toLocaleString('id-ID') + '</td>' +
                                '</tr>';
                            $('#tbl_beli tbody').append(newRow);
                            
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

<script>
$(document).on('click', '.btn-hapusbeli', function() {
    var noid = $(this).data('noid');
    var nofak = $(this).data('nofak');
    var nmsup = $(this).data('nmsup');
    $('#txtkode').val(noid);
    $('#nofakVal').text(nofak);
    $('#nmsupVal').text(nmsup);

});
</script>

<script type="text/javascript">
$(document).ready(function () {
    $(document).on('click', '.btn-tampil', function () {
        $('#tbl_tampil tbody').empty();
        var tgl1 = $('#tgl1').val();
        var tgl2 = $('#tgl2').val();

        $.ajax({
            url: "<?php echo base_url().'admin/beli/get_data_beli';?>",
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
                                var newRow = '<tr>' +
                                    '<td style="font-size:11px;text-align:center;">' + no + '</td>' +
                                    '<td style="font-size:11px;">' + item.beli_nofak + '</td>' +
                                    '<td style="font-size:11px;">' + item.beli_tanggal + '</td>' +
                                    '<td style="font-size:11px;">' + item.beli_suplier_nama + '</td>' +
                                    '<td style="font-size:11px;text-align:center;">' +
                                    '<a class="btn btn-xs btn-info btn-lihatbeli" href="#modalLihatBeli" data-toggle="modal" data-noid="' + item.beli_kode + '" data-nofak="' + item.beli_nofak + '" data-nmsup="' + item.beli_suplier_nama + '" title="Lihat Data Pembelian"><span class="fa fa-eye"></span> Lihat Data</a> ' +
                                    '<a class="btn btn-xs btn-danger btn-hapusbeli" href="#modalHapusBeli" data-toggle="modal" data-noid="' + item.beli_kode + '" data-nofak="' + item.beli_nofak + '" data-nmsup="' + item.beli_suplier_nama + '" title="Hapus Data Pembelian"><span class="fa fa-trash"></span> Hapus Data</a> ' +
                                    '</td>' +
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

$(document).on('click', '.btn-lihatbeli', function() {
    var noid = $(this).data('noid');
    var nofak = $(this).data('nofak');
    var nmsup = $(this).data('nmsup');

    $('#detailTable tbody').empty();    //Clear existing table rows
    $('#nofakValue2').text(nofak);
    $('#nmsupValue2').text(nmsup);

    $.ajax({
        type: "POST",
        url: "<?php echo base_url('admin/beli/get_detail_beli'); ?>",
        data: { noid: noid },
        dataType: 'json',
        success: function (data) {
            //console.log("Data from server:", data);
            if (data.length !== 0) {
                    var no=0;
                    var totbeli=0;
                    $.each(data, function (index, item) {
                            no++;
                            var harbel = parseFloat(item.d_beli_harga);
                            totbeli = totbeli + harbel;
                            var qty = parseFloat(item.d_beli_jumlah);
                            var formatted_qty;
                            if (Math.floor(qty) === qty) {
                                formatted_qty = qty.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ','); // Format sebagai bilangan bulat
                            } else {
                                formatted_qty = qty.toFixed(2).replace('.', ',').replace(/\.?0+$/, '').replace(/\B(?=(\d{3})+(?!\d))/g, ','); // Format sebagai bilangan desimal
                            }
                            var newRow = '<tr>' +
                                '<td style="font-size:11px;text-align:center;">' + no + '</td>' +
                                '<td style="font-size:11px;">' + item.d_beli_barang_id + '</td>' +
                                '<td style="font-size:11px;">' + item.d_beli_barang_nama + '</td>' +
                                '<td style="font-size:11px;text-align:center;">' + item.d_beli_barang_satuan + '</td>' +
                                '<td style="font-size:11px;text-align:center;">' + formatted_qty  + '</td>' +
                                '<td style="font-size:11px;text-align:right;">' + harbel.toLocaleString('id-ID')+ '</td>' +
                                '</tr>';
                            $('#detailTable tbody').append(newRow);  
                    });
                    // Tambahkan baris "Total" setelah loop dan tampilkan grand total
                    var totalRow = '<tr style="background-color:#777;">' +
                        '<td colspan="5" style="text-align:right; font-weight:bold;color:white;">Total</td>' + // Kolom kosong sebelum kolom "Total"
                        '<td style="text-align:right; font-weight:bold;color:white;">' + totbeli.toLocaleString('id-ID') + '</td>' +
                        '</tr>';
                    $('#detailTable tbody').append(totalRow);
                    
            } else {
                    console.log("No data found.");
            }
        },
        error: function(xhr, status, error) {
            //console.log(error);
        }    
    });
});
</script>

<script>
    //$('input[name^="cekbox"]').on('change', function() {
    $('#cekbox').on('change', function() {
        if ($(this).prop('checked')) {
            $('#tbl_update_harpok').show(); 
        }else {
            $('#tbl_update_harpok').hide();
        } 
    });

</script>

</body>
</html>
