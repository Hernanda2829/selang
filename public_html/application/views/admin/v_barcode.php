<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    // error_reporting(E_ALL);
    // ini_set('display_errors', 1); 
	error_reporting(0);
    $userid=$userid->row_array();
    $data_regid=$userid['reg_id'];
    ?>  
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Produk By <?php echo $userid['co_name'];?>">
    <meta name="author" content="<?php echo $userid['co_name'];?>">

    <title>Buat Barcode</title>
    <link rel="shortcut icon" href="<?php echo base_url().'assets/img/'. $userid['co_imgicon']; ?>" alt="#no image#" type="image/x-icon">
    <!-- Bootstrap Core CSS -->
    <link href="<?php echo base_url().'assets/css/bootstrap.min.css'?>" rel="stylesheet">
	<link href="<?php echo base_url().'assets/css/style.css'?>" rel="stylesheet">
	<link href="<?php echo base_url().'assets/css/font-awesome.css'?>" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?php echo base_url().'assets/css/4-col-portfolio.css'?>" rel="stylesheet">
    <link href="<?php echo base_url().'assets/css/dataTables.bootstrap.min.css'?>" rel="stylesheet">
    <link href="<?php echo base_url().'assets/css/jquery.dataTables.min.css'?>" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/css/bootstrap-datetimepicker.min.css'?>">
    


<style>
    @media print {
    body {
        margin: 0;
        padding: 0;
        background-color: #fff;
    }

    .qr-code {
        width: 100px; /* Sesuaikan ukuran gambar QR code di sini */
        height: 100px; /* Sesuaikan ukuran gambar QR code di sini */
        display: inline-block;
        margin: 5px; /* Jarak antar gambar QR code di sini */
    }
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

    #modalImage, #modalImage2 {
        max-width: 100%; /* Lebar gambar tidak akan melebihi lebar parent container */
        max-height: 200px; /* Tinggi gambar tidak akan melebihi 200px */
        width: auto; /* Mempertahankan aspek ratio gambar */
        height: auto; /* Mempertahankan aspek ratio gambar */
        margin-top: 10px; /* Menambahkan margin di atas gambar */
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

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <center><?php echo $this->session->flashdata('msg');?></center>
                <h3 class="page-header">Buat
                    <small>Barcode Garansi Barang - <?php echo $userid['reg_code'];?>  <?php echo $userid['reg_name'];?></small>
                    <!--<a href="#" data-toggle="modal" data-target="#largeModal" class="pull-right" onclick="refreshPageAndShowModal()"><small>Cari Penjualan!</small></a>-->
                    <a href="#" data-toggle="modal" data-target="#largeModal" class="pull-right"><small>Cari Penjualan!</small></a>
                </h3>
            </div>
        </div>
        <br>

        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#tab1" style="font-size:12px;"><b>Buat Garansi</b></a></li>
            <li><a data-toggle="tab" href="#tab2" style="font-size:12px;"><b>Data Garansi</b></a></li>
            <!-- Tambahkan lebih banyak tab sesuai kebutuhan -->
        </ul> 
        
        <!-- Isi Tab -->
        <div class="tab-content">
            <!-- Tab 1: Informasi -->
            <div id="tab1" class="tab-pane fade in active">
                <br>
                <!-- Projects Row -->
                <div class="row">
                    <div class="col-lg-12">
                        <table style="width:560px">    
                            <tr>
                                <th style="width:200px">No Faktur</th>
                                <th rowspan="2">
                                <table id="jualTable" style="font-size:10px;" style="width:350px">
                                    <tbody>
                                    </tbody>
                                </table>
                                </th>
                            </tr>
                            <tr>
                                <th><input type="text" name="nofak" id="nofak" class="form-control input-sm" style="width:150px;"></th> 
                            </tr>    
                        </table>
                        
                        <table id="detailTable" class="table table-bordered table-condensed" style="font-size:11px;margin-top:10px;">
                            <thead>
                                <tr>
                                    <th style="text-align:center;">No Faktur</th>
                                    <th style="text-align:center;">Kode Barang</th>
                                    <th style="text-align:center;">Nama Barang</th>
                                    <th style="text-align:center;">Satuan</th>
                                    <th style="text-align:center;">Quantity</th>
                                    <th style="text-align:center;">Harga Jual</th>
                                    <th style="text-align:center;">Diskon</th>
                                    <th style="text-align:center;">Sub Total</th>
                                    <th style="text-align:center;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="text-align:center;"></td>
                                    <td style="text-align:center;"></td>
                                    <td style="text-align:center;"></td>
                                    <td style="text-align:center;"></td>
                                    <td style="text-align:center;"></td>
                                    <td style="text-align:center;"></td>
                                    <td style="text-align:center;"></td>
                                    <td style="text-align:center;"></td>
                                    <td style="text-align:center;"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <hr/>
                </div>
            </div>
            <div id="tab2" class="tab-pane fade">
                <br>
                <table id="tbl_garansi" class="table table-bordered table-condensed" style="font-size:11px;margin-top:10px;">
                    <thead>
                        <tr>
                            <th style="text-align:center;">No</th>
                            <th style="text-align:center;">Tgl Transaksi</th>
                            <th style="text-align:center;">No Faktur</th>
                            <th style="text-align:center;">Nama Customer</th>
                            <th style="text-align:center;">Kode Barang</th>
                            <th style="text-align:center;">Nama Barang</th>
                            <th style="text-align:center;">Satuan</th>
                            <th style="text-align:center;">Quantity</th>
                            <th style="text-align:center;">Harga Jual</th>
                            <th style="text-align:center;">Diskon</th>
                            <th style="text-align:center;">Total</th>
                            <th style="text-align:center;width:120px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $no=0;
                            foreach ($g_data->result_array() as $g):
                                $no++;
                                $g_tgl=$g['g_jual_tgl'];
                                $g_nofak=$g['g_nofak'];
                                $g_cust=$g['g_cust_nama'];
                                $g_kode=$g['g_brg_id'];
                                $g_nm=$g['g_brg_nama'];
                                $g_sat=$g['g_brg_sat'];
                                $g_qty=$g['g_qty'];
                                $g_harjul=$g['g_harjul'];
                                $g_diskon=$g['g_diskon'];
                                $g_tot=$g['g_total'];
                                if (floor($g_qty) == $g_qty) {
                                    $formatted_g_qty = number_format($g_qty, 0, ',', '.');
                                } else {
                                    $formatted_g_qty = number_format($g_qty, 2, ',', '.');
                                    $formatted_g_qty = rtrim($formatted_g_qty, '0');
                                    $formatted_g_qty = rtrim($formatted_g_qty, ',');
                                }
                        ?>
                        <tr>
                            <td style="text-align:center;"><?= $no ;?></td>
                            <td><?= $g_tgl ;?></td>
                            <td><?= $g_nofak ;?></td>
                            <td><?= $g_cust ;?></td>
                            <td><?= $g_kode ;?></td>
                            <td><?= $g_nm ;?></td>
                            <td style="text-align:center;"><?= $g_sat ;?></td>
                            <td style="text-align:center;"><?= $formatted_g_qty ;?></td>
                            <td style="text-align:right;"><?= str_replace(',', '.', number_format($g_harjul)) ;?></td>
                            <td style="text-align:right;"><?= str_replace(',', '.', number_format($g_diskon)) ;?></td>
                            <td style="text-align:right;"><?= str_replace(',', '.', number_format($g_tot)) ;?></td>
                            <td style="text-align:center;">
                            <a href="#modalLihatGaransi" data-toggle="modal" class="btn btn-warning btn-xs btn-tampilgaransi" data-nofak="<?= $g_nofak ;?>" data-idbrg="<?= $g_kode ;?>" title="Lihat Data Keterangan Garansi"><span class="fa fa-dashboard"></span> Lihat</a>
                            <a href="#modalUpload" data-toggle="modal" class="btn btn-info btn-xs btn-upload" data-nofak="<?= $g_nofak ;?>" data-idbrg="<?= $g_kode ;?>" title="Upload File Foto/Dokumen"><span class="fa fa-file-image-o"></span> Upload</a>
                            </td>
                        </tr>
                    <?php endforeach;?>
                    </tbody>
                </table>
            </div>   
        </div>

        
        <!-- ============ MODAL Upload Gambar =============== -->
        <div id="modalUpload" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 class="modal-title" id="myModalLabel"><small>Data Garansi - <?php echo $userid['reg_code'];?>  <?php echo $userid['reg_name'];?> - Upload File</small></h3>
        </div>
        <form class="form-horizontal" method="post" action="<?php echo base_url().'admin/barcode/upload_file'?>" enctype="multipart/form-data">
            <div class="modal-body" style="overflow:scroll;height:450px;">  
                <table style="font-size:11px;">
                <input type="hidden" id="txtnofak" name="txtnofak">
                <input type="hidden" id="txtidbrg" name="txtidbrg">
                <tr>
                    <th style="font-weight:normal;width:15%;">Tgl Transaksi</th>
                    <th style="font-weight:normal;text-align:center;width:3%;">: </th>
                    <th style="font-weight:normal;width:30%;"><b><span id="tglValue3"></span></b></th>
                </tr>
                <tr>
                    <th style="font-weight:normal;width:15%;">Nama Customer</th>
                    <th style="font-weight:normal;text-align:center;width:3%;">: </th>
                    <th style="font-weight:normal;width:30%;"><b><span id="nmcustValue3" style="color: green;"></span></b></th>
                    <th style="font-weight:normal;text-align:right;width:30%;">Jenis Bayar</th>
                    <th style="font-weight:normal;text-align:center;width:3%;"> : </th>
                    <th style="font-weight:normal;text-align:right;width:15%;"><span id="jenisByr3" style="color: green;"></span></th>
                </tr>
                <tr>
                    <th style="font-weight:normal;width:15%;">No Faktur</th>
                    <th style="font-weight:normal;text-align:center;width:3%;">: </th>
                    <th style="font-weight:normal;width:30%;"><b><span id="nofakValue3"></span></b></th>
                    <th style="font-weight:normal;text-align:right;width:30%;">Status Bayar</th>
                    <th style="font-weight:normal;text-align:center;width:3%;"> : </th> 
                    <th style="font-weight:normal;text-align:right;width:15%;"><span id="statusByr3" style="color: green;"></span></th>
                </tr>
                </table>
                <table id="tbl_info3" class="table table-bordered table-condensed" style="font-size:11px;">
                <thead>
                <tr>
                    <th style="text-align:center;vertical-align:middle">Kode Barang</th>
                    <th style="text-align:center;vertical-align:middle">Nama Barang</th>
                    <th style="text-align:center;vertical-align:middle">Satuan</th>
                    <th style="text-align:center;vertical-align:middle">Quantity</th>
                    <th style="text-align:center;vertical-align:middle">Harga Jual</th>
                    <th style="text-align:center;vertical-align:middle">Diskon</th>
                    <th style="text-align:center;vertical-align:middle">Sub Total</th>
                </tr>
                </thead>
                <tbody></tbody>
                </table>
                <hr/>
                <button type="button" class="btn btn-sm btn-success" onclick="addFile()"><span class="fa fa-plus"></span> Add File Upload</button>
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
            <div class="modal-footer">
                <button type="submit" class="btn btn-info">Upload</button>
                <button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
            </div>
        </form>
        </div>
        </div>
        </div>  

        <!-- ============ MODAL Hapus Gambar / File =============== -->
        <div id="modalHapusFile" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 class="modal-title" id="myModalLabel">Hapus File Garansi</h3>
            </div>   
                <div class="modal-body">
                    <input name="txtgid" id="txtgid" type="hidden">
                    <input name="txtfile" id="txtfile" type="hidden">
                    <p>Yakin mau menghapus File : <span id="nmfileVal"></span> ... ?...</p>             
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger btn-hapusfile" data-dismiss="modal" aria-hidden="true">Hapus</button>
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
                <h3 class="modal-title" id="myModalLabel">Data Penjualan - <small><?php echo $userid['reg_code'];?>  <?php echo $userid['reg_name'];?></small></h3>
            </div>
                <div class="modal-body" style="overflow:scroll;height:450px;">

                  <table class="table table-bordered table-condensed" style="font-size:11px;" id="mydata">
                    <thead>
                        <tr>
                        <th style="width:50px!important;text-align:center;vertical-align:middle;background-image:none!important;">No</th>
                        <th style="width:110px!important;text-align:center;vertical-align:middle;background-image:none!important;">No Faktur</th>
                        <th style="text-align:center;vertical-align:middle;background-image:none!important;">Nama Customer</th>
                        <th style="width:170px!important;text-align:center;vertical-align:middle;background-image:none!important;">Tanggal Transaksi</th>
                        <th style="width:70px!important;text-align:center;vertical-align:middle;background-image:none!important;">Jenis Bayar</th>
                        <th style="width:90px!important;text-align:center;vertical-align:middle;background-image:none!important;">Status Bayar</th>
                        <th style="width:100px!important;text-align:center;vertical-align:middle;background-image:none!important;">Total Penjualan</th>
                        <th style="width:100px!important;text-align:center;vertical-align:middle;background-image:none!important;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                        $no=0;
                        foreach ($data->result_array() as $a):
                            $no++;
                            $nofak=$a['jual_nofak'];
                            $nmcust=$a['jual_cust_nama'];
                            $tgl=$a['jual_tanggal'];
                            $jb=$a['jual_bayar'];
                            $js=$a['jual_bayar_status'];
                            $tot=$a['jual_total'];

                    ?>
                        <tr>
                            <td style="text-align:center;"><?php echo $no;?></td>
                            <td><?php echo $nofak;?></td>
                            <td><?php echo $nmcust;?></td>
                            <td><?php echo $tgl;?></td>
                            <td style="text-align:center;"><?php echo $jb;?></td>
                            <td style="text-align:center;"><?php echo $js;?></td>
                            <td style="text-align:right;"><?php echo 'Rp ' . str_replace(',', '.', number_format($tot)); ?></td>
                            <td style="text-align:center;">
                            <button type="submit" class="btn btn-xs btn-info" title="Pilih" onclick="pilihKode('<?php echo $nofak?>')"><span class="fa fa-edit"></span> Pilih</button>
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
        
        <!-- ============ MODAL Buat Data Garansi =============== -->
        <div id="modalGaransi" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 class="modal-title" id="myModalLabel"><small>Data Garansi - <?php echo $userid['reg_code'];?>  <?php echo $userid['reg_name'];?></small></h3>
        </div>
        <form class="form-horizontal" method="post" action="<?php echo base_url().'admin/barcode/add_garansi'?>">
            <div class="modal-body" style="overflow:scroll;height:450px;">
                         
                <table style="font-size:11px;">
                <tr>
                    <th style="font-weight:normal;width:15%;">Tgl Transaksi</th>
                    <th style="font-weight:normal;text-align:center;width:3%;">: </th>
                    <th style="font-weight:normal;width:30%;"><b><span id="tglValue"></span></b></th>
                </tr>
                <tr>
                    <th style="font-weight:normal;width:15%;">Nama Customer</th>
                    <th style="font-weight:normal;text-align:center;width:3%;">: </th>
                    <th style="font-weight:normal;width:30%;"><b><span id="nmcustValue" style="color: green;"></span></b></th>
                    <th style="font-weight:normal;text-align:right;width:30%;">Jenis Bayar</th>
                    <th style="font-weight:normal;text-align:center;width:3%;"> : </th>
                    <th style="font-weight:normal;text-align:right;width:15%;"><span id="jenisByr" style="color: green;"></span></th>
                </tr>
                <tr>
                    <th style="font-weight:normal;width:15%;">No Faktur</th>
                    <th style="font-weight:normal;text-align:center;width:3%;">: </th>
                    <th style="font-weight:normal;width:30%;"><b><span id="nofakValue"></span></b></th>
                    <th style="font-weight:normal;text-align:right;width:30%;">Status Bayar</th>
                    <th style="font-weight:normal;text-align:center;width:3%;"> : </th> 
                    <th style="font-weight:normal;text-align:right;width:15%;"><span id="statusByr" style="color: green;"></span></th>
                </tr>
                </table>
                <table id="tbl_info" class="table table-bordered table-condensed" style="font-size:11px;">
                <thead>
                <tr>
                    <th style="text-align:center;vertical-align:middle">Kode Barang</th>
                    <th style="text-align:center;vertical-align:middle">Nama Barang</th>
                    <th style="text-align:center;vertical-align:middle">Satuan</th>
                    <th style="text-align:center;vertical-align:middle">Quantity</th>
                    <th style="text-align:center;vertical-align:middle">Harga Jual</th>
                    <th style="text-align:center;vertical-align:middle">Diskon</th>
                    <th style="text-align:center;vertical-align:middle">Sub Total</th>
                </tr>
                </thead>
                <tbody></tbody>
                </table>
                
                <p style="font-size:11px;margin-bottom:0;"><span id="inputByrValue"><b>Silahkan Input Keterangan Garansi, </b></span></p>
                
                <table class="table table-bordered table-condensed" style="font-size: 11px;">
                    <tr>
                        <th style="width: 150px; padding-bottom: 5px; vertical-align: middle;">Periode Garansi : </th>
                        <td>
                            <div style="display: flex; align-items: center;">
                                <select name="periode" style="width: 100px; margin-right: 5px;" class="form-control input-sm" required>
                                    <?php foreach ($periode->result_array() as $p) {
                                        $pval = $p['p_val'];
                                        $pnm = $p['p_nama'];
                                        echo "<option value='$pval'>$pval $pnm </option>";
                                    }
                                    ?>
                                </select>
                                <span style="margin-right: 5px;">Tgl Jatuh Tempo :</span>
                                <div class='input-group date' id='datepicker' style="width:130px; margin-left: 5px;">
                                    <input type='text' name="tglJtempo" class="form-control" style="font-size:11px;color:green;" placeholder="Tanggal..." required>
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th style="width:150px;padding-bottom:5px;vertical-align:middle;">Keterangan : </th>
                        <td><textarea id="ket" name="ket" class="form-control input-sm" style="width:400px;height:80px;resize:none;overflow-y:auto;" maxlength="255" required></textarea></td>
                    </tr>
                </table>
            <hr/>
            <p>Dengan mengclick tombol update ,secara otomatis akan membentuk QR Code.</p>
            </div>

            <table class="table table-bordered table-condensed" style="font-size:11px;display:none;">                    
                <thead>
                </thead>
                <tbody>
                <tr><td><input type="text" id="gjualtgl" name="gjualtgl" class="form-control input-sm" style="width:200px;" readonly></td></tr>
                <tr><td><input type="text" id="gcustnama" name="gcustnama" class="form-control input-sm" style="width:200px;" readonly></td></tr>
                <tr><td><input type="text" id="gnofak" name="gnofak" class="form-control input-sm" style="width:200px;" readonly></td></tr>
                <tr><td><input type="text" id="gbrgid" name="gbrgid" class="form-control input-sm" style="width:200px;" readonly></td></tr>
                <tr><td><input type="text" id="gbrgnama" name="gbrgnama" class="form-control input-sm" style="width:200px;" readonly></td></tr>
                <tr><td><input type="text" id="gbrgsat" name="gbrgsat" class="form-control input-sm" style="width:200px;" readonly></td></tr>
                <tr><td><input type="text" id="gqty" name="gqty" class="form-control input-sm" style="width:200px;" readonly></td></tr>
                <tr><td><input type="text" id="gharjul" name="gharjul" class="form-control input-sm" style="width:200px;" readonly></td></tr>
                <tr><td><input type="text" id="gdiskon" name="gdiskon" class="form-control input-sm" style="width:200px;" readonly></td></tr>
                <tr><td><input type="text" id="gtotal" name="gtotal" class="form-control input-sm" style="width:200px;" readonly></td></tr>
                <tr><td><input type="text" id="gjenisbayar" name="gjenisbayar" class="form-control input-sm" style="width:200px;" readonly></td></tr>
                <tr><td><input type="text" id="gstatusbayar" name="gstatusbayar" class="form-control input-sm" style="width:200px;" readonly></td></tr>
                </tbody>
            </table>   

            <div class="modal-footer">
                <button type="submit" class="btn btn-info">Update</button>    
                <button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
            </div>
        </form>
        </div>
        </div>
        </div>                    

        <!-- ============ MODAL Lihat Data Garansi =============== -->
        <div id="modalLihatGaransi" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 class="modal-title" id="myModalLabel"><small>Data Garansi - <?php echo $userid['reg_code'];?>  <?php echo $userid['reg_name'];?></small></h3>
        </div>
            <div class="modal-body" style="overflow:scroll;height:450px;">  
                <table id="tbl_head2" style="font-size:11px;">
                <tr>
                    <th style="font-weight:normal;width:15%;">Tgl Transaksi</th>
                    <th style="font-weight:normal;text-align:center;width:3%;">: </th>
                    <th style="font-weight:normal;width:30%;"><b><span id="tglValue2"></span></b></th>
                </tr>
                <tr>
                    <th style="font-weight:normal;width:15%;">Nama Customer</th>
                    <th style="font-weight:normal;text-align:center;width:3%;">: </th>
                    <th style="font-weight:normal;width:30%;"><b><span id="nmcustValue2" style="color: green;"></span></b></th>
                    <th style="font-weight:normal;text-align:right;width:30%;">Jenis Bayar</th>
                    <th style="font-weight:normal;text-align:center;width:3%;"> : </th>
                    <th style="font-weight:normal;text-align:right;width:15%;"><span id="jenisByr2" style="color: green;"></span></th>
                </tr>
                <tr>
                    <th style="font-weight:normal;width:15%;">No Faktur</th>
                    <th style="font-weight:normal;text-align:center;width:3%;">: </th>
                    <th style="font-weight:normal;width:30%;"><b><span id="nofakValue2"></span></b></th>
                    <th style="font-weight:normal;text-align:right;width:30%;">Status Bayar</th>
                    <th style="font-weight:normal;text-align:center;width:3%;"> : </th> 
                    <th style="font-weight:normal;text-align:right;width:15%;"><span id="statusByr2" style="color: green;"></span></th>
                </table>
                <table id="tbl_info2" class="table table-bordered table-condensed" style="font-size:11px;">
                <thead>
                <tr>
                    <th style="text-align:center;vertical-align:middle">Kode Barang</th>
                    <th style="text-align:center;vertical-align:middle">Nama Barang</th>
                    <th style="text-align:center;vertical-align:middle">Satuan</th>
                    <th style="text-align:center;vertical-align:middle">Quantity</th>
                    <th style="text-align:center;vertical-align:middle">Harga Jual</th>
                    <th style="text-align:center;vertical-align:middle">Diskon</th>
                    <th style="text-align:center;vertical-align:middle">Sub Total</th>
                </tr>
                </thead>
                <tbody></tbody>
                </table>
                
                <p style="font-size:11px;margin-bottom:0;"><span id="inputByrValue2"><b>Keterangan Garansi, </b></span></p>
                
                <table class="table table-bordered table-condensed" style="font-size: 11px;">
                    <tr>
                        <th style="width: 150px; padding-bottom: 5px; vertical-align: middle;">Periode Garansi:</th>
                        <td>
                            <div style="display: flex; align-items: center;">
                                <input type="text" id="periode2" name="periode2" class="form-control input-sm" style="width: 50px; margin-right: 10px;" readonly>
                                <span style="margin-right: 10px;">Bulan, Tgl Jatuh Tempo:</span>
                                <input type="text" id="tglJtempo2" name="tglJtempo2" class="form-control input-sm" style="width: 120px;" readonly>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th style="width:150px;padding-bottom:5px;vertical-align:middle;">Keterangan : </th>
                        <td><textarea id="ket2" name="ket2" class="form-control input-sm" style="width:400px;height:80px;resize:none;overflow-y:auto;" maxlength="255" readonly></textarea></td>                        
                    </tr>
                    <tr>
                        <td colspan="2" style="text-align:center;">
                            <img id="modalImage" class="modal-image" alt="Gambar" />
                        </td>
                    </tr>

                </table>
            </div>
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
            </div>
        </div>
        </div>
        </div>  

        <!-- ============ MODAL Setting Cetak =============== -->
        <div id="modalCetak" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 class="modal-title" id="myModalLabel"><small>Cetak Barcode - <?php echo $userid['reg_code'];?>  <?php echo $userid['reg_name'];?></small></h3>
        </div>
        <form id="cetakForm" class="form-horizontal" method="post" action="<?php echo base_url().'admin/barcode/cetak_barcode';?>">
            <div class="modal-body" style="overflow:scroll;height:400px;">
                <table class="table table-bordered table-condensed" style="font-size: 11px;">
                    <tr>
                        <th style="width: 150px; padding-bottom: 5px; vertical-align: middle;">Pilih Jumlah Kolom : </th>
                        <td>
                            <select name="kolom" style="width: 100px; margin-right: 5px;" class="form-control input-sm" required>
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th style="width:150px;padding-bottom:5px;vertical-align:middle;">Pilih Jumlah Baris : </th>
                        <td>
                            <select name="baris" style="width: 100px; margin-right: 5px;" class="form-control input-sm" required>
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
                                <option>6</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <tr>
                        <th style="width:150px;padding-bottom:5px;vertical-align:middle;">Kode Barang : </th>
                        <td>
                            <label><input type="radio" name="option" value="option1" id="option1"> Tampil Kode Barang</label>
                            <label><input type="radio" name="option" value="option2" id="option2"> Tanpa Kode Barang</label>
                            <input type="hidden" id="gimg" name="gimg" class="form-control input-sm" style="width:400px; margin-right: 10px;" readonly>
                            <input type="hidden" id="kdbrg" name="kdbrg" class="form-control input-sm" style="width:100px; margin-right: 10px;" readonly>
                            <input type="hidden" id="kdbrg2" name="kdbrg2" class="form-control input-sm" style="width:100px; margin-right: 10px;" readonly>
                        </td>                        
                        </tr>
                    </tr>
                    <tr>
                        <td colspan="2" style="text-align:center;">
                            <img id="modalImage2" class="modal-image" alt="Gambar" />
                        </td>
                    </tr>

                </table>
            <hr/>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-info" onclick="setTargetBlank()">Tampil</button>
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
    <script src="<?php echo base_url().'assets/js/bootstrap.min.js'?>"></script>
    <script src="<?php echo base_url().'assets/js/moment.js'?>"></script>
    <script src="<?php echo base_url().'assets/js/bootstrap-datetimepicker.min.js'?>"></script>
    <script src="<?php echo base_url().'assets/js/jquery.dataTables.min.js'?>"></script>
    
<script type="text/javascript">
    $(document).ready(function() {
        $('#tbl_garansi').DataTable();
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
    });
</script>

<script type="text/javascript">
$(document).ready(function () {
    $("#nofak").focus();

    $("#nofak").on("input", function () {
        handleNofakChange();
    });

    var dataJual; // Variabel untuk menyimpan data penjualan

    function handleNofakChange() {
        // Clear existing table rows
        $('#detailTable tbody').empty();
        $('#jualTable tbody').empty();
        var nofak = $("#nofak").val();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url().'admin/barcode/get_detail_jual';?>",
            data: { nofak: nofak },
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
                            // Simpan data penjualan ke variabel
                            dataGaransi = data.queryA;
                            dataJual = data.queryB;
                            //----------------------------------
                            var item = data.queryB[0]; //mengambil nilai pertama saja ,karena jika tidak akan terjadi pengulangan
                            var newRowJualTable = '<tr>' +
                                '<td style="text-align:left;width:10%;">Tgl.Transaksi</td>' +
                                '<td style="text-align:left;width:2%;">:</td>' +
                                '<td style="text-align:left;width:30%;font-weight:normal;font-size:11px;">' + item.jual_tanggal + '</td>' +
                                '</tr>' +
                                '<tr>' +
                                '<td style="text-align:left;width:10%;">Nama Customer</td>' +
                                '<td style="text-align:left;width:2%;">:</td>' +
                                '<td style="text-align:left;width:30%;color:green;font-size:11px;">' + item.jual_cust_nama + '</td>' +
                                '</tr>' +
                                '<tr>' +
                                '<td style="text-align:left;width:10%;">Jenis Pembayaran</td>' +
                                '<td style="text-align:left;width:2%;">:</td>' +
                                '<td style="text-align:left;width:30%;font-weight:normal;font-size:11px;">' + item.jual_bayar + '</td>' +
                                '</tr>' +
                                '<tr>' +
                                '<td style="text-align:left;width:10%;">Status Pembayaran</td>' +
                                '<td style="text-align:left;width:2%;">:</td>' +
                                '<td style="text-align:left;width:30%;font-weight:normal;font-size:11px;">' + item.jual_bayar_status + '</td>' +
                                '</tr>' +
                                '<tr>' +
                                '<td style="text-align:left;width:10%;">Total Penjualan</td>' +
                                '<td style="text-align:left;width:2%;">:</td>' +
                                '<td style="text-align:left;width:30%;font-weight:normal;font-size:11px;">' + Number(item.jual_total).toLocaleString('id-ID', { style: 'currency', currency: 'IDR' }).replace(/,00$/, '') + '</td>' +
                                '</tr>';

                            // Append the new row to jualTable
                            $('#jualTable tbody').append(newRowJualTable);


                        // Loop through the data and append rows to the table
                        $.each(data.queryB, function (index, item) {
                            var harjul = parseFloat(item.d_jual_barang_harjul);
                            var diskon = parseFloat(item.d_jual_diskon);
                            var total = parseFloat(item.d_jual_total);
                            var qty = parseFloat(item.d_jual_qty);
                            var formatted_qty;
                            if (Math.floor(qty) === qty) {
                                formatted_qty = qty.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ','); // Format sebagai bilangan bulat
                            } else {
                                formatted_qty = qty.toFixed(2).replace('.', ',').replace(/\.?0+$/, '').replace(/\B(?=(\d{3})+(?!\d))/g, ','); // Format sebagai bilangan desimal
                            }
                            

                            // Periksa apakah ada data dengan g_nofak dan g_barang_id yang sama pada queryA
                            var cekdata = data.queryA.some(function (gItem) {
                                return gItem.g_nofak === item.d_jual_nofak && gItem.g_brg_id === item.d_jual_barang_id;
                            });

                            // Ganti tombol berdasarkan hasil periksaan
                            var gTombol;
                            if (cekdata) {
                                gTombol = '<a href="#modalLihatGaransi" data-toggle="modal" class="btn btn-danger btn-xs btn-lihatgaransi" data-nofak="' + item.d_jual_nofak + '" data-idbrg="' + item.d_jual_barang_id + '" title="Lihat Data Keterangan Garansi"><span class="fa fa-dashboard"></span> Lihat Data Garansi</a> ' + 
                                          '<a href="#modalCetak" data-toggle="modal" class="btn btn-warning btn-xs btn-cetak" data-nofak="' + item.d_jual_nofak + '" data-idbrg="' + item.d_jual_barang_id + '" title="Cetak Barcode"><span class="fa fa-dashboard"></span> Cetak Barcode</a></td>';
                            } else {
                                gTombol = '<a href="#modalGaransi" data-toggle="modal" class="btn btn-info btn-xs btn-garansi" data-nofak="' + item.d_jual_nofak + '" data-idbrg="' + item.d_jual_barang_id + '" title="Buat Data Keterangan Garansi"><span class="fa fa-dashboard"></span> Buat Data Garansi</a> ';
                            }

                            var newRow = '<tr>' +
                                '<td style="text-align:center;">' + item.d_jual_nofak + '</td>' +
                                '<td style="text-align:center;">' + item.d_jual_barang_id + '</td>' +
                                '<td style="text-align:center;">' + item.d_jual_barang_nama + '</td>' +
                                '<td style="text-align:center;">' + item.d_jual_barang_satuan + '</td>' +
                                '<td style="text-align:center;">' + formatted_qty + '</td>' +
                                '<td style="text-align:right;">' + harjul.toLocaleString('id-ID') + '</td>' +
                                '<td style="text-align:right;">' + diskon.toLocaleString('id-ID') + '</td>' +
                                '<td style="text-align:right;">' + total.toLocaleString('id-ID') + '</td>' +
                                '<td style="text-align:center;">' + gTombol  + '</td>' +
                                '</tr>';
                            $('#detailTable tbody').append(newRow);
                            
                        }); 

                    }
                }
            },
            error: function (xhr, status, error) {
                console.error("AJAX error:", error);
            }
        });
    }

    $('#largeModal').on('hidden.bs.modal', function () {
        handleNofakChange();
        setTimeout(function() {
        $("#nofak").focus();
        }, 100);
    });

    $('#mydata').DataTable();

    // Menangani tombol "Buat Data Garansi" yang diklik
    $(document).on('click', '.btn-garansi', function () {
        //$('#ket').val(''); //mengosongkan data dulu
        // Ambil data dari tombol yang diklik
        $('select[name^="periode"]').val(1); //mengembalikan periode bulan ke 1
        
        var nofak = $(this).data('nofak');
        var idbrg = $(this).data('idbrg');

        // Cari data yang sesuai dari data penjualan yang telah diambil sebelumnya
        var garansiData = dataJual.filter(function (item) {
            return item.d_jual_nofak === nofak && item.d_jual_barang_id === idbrg;
        });

        // Bersihkan isi tabel modal sebelum menambahkan data baru
        $('#tbl_info tbody').empty();

        // Loop through the data and append rows to the modal table
        $.each(garansiData, function (index, item) {
            var harjul = parseFloat(item.d_jual_barang_harjul);
            var diskon = parseFloat(item.d_jual_diskon);
            var total = parseFloat(item.d_jual_total);
            var qty = parseFloat(item.d_jual_qty);
            var formatted_qty;
            if (Math.floor(qty) === qty) {
                formatted_qty = qty.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ','); // Format sebagai bilangan bulat
            } else {
                formatted_qty = qty.toFixed(2).replace('.', ',').replace(/\.?0+$/, '').replace(/\B(?=(\d{3})+(?!\d))/g, ','); // Format sebagai bilangan desimal
            }
            var newRow = '<tr>' +
                '<td style="text-align:center;">' + item.d_jual_barang_id + '</td>' +
                '<td style="text-align:center;">' + item.d_jual_barang_nama + '</td>' +
                '<td style="text-align:center;">' + item.d_jual_barang_satuan + '</td>' +
                '<td style="text-align:center;">' + formatted_qty + '</td>' +
                '<td style="text-align:right;">' + harjul.toLocaleString('id-ID') + '</td>' +
                '<td style="text-align:right;">' + diskon.toLocaleString('id-ID') + '</td>' +
                '<td style="text-align:right;">' + total.toLocaleString('id-ID') + '</td>' +
                '</tr>';

            $('#tbl_info tbody').append(newRow);
            //---------mengisi post simpan----------------
            $('#gjualtgl').val(item.jual_tanggal);
            $('#gcustnama').val(item.jual_cust_nama);
            $('#gnofak').val(item.d_jual_nofak);
            $('#gbrgid').val(item.d_jual_barang_id);
            $('#gbrgnama').val(item.d_jual_barang_nama);
            $('#gbrgsat').val(item.d_jual_barang_satuan);
            $('#gqty').val(item.d_jual_qty);
            $('#gharjul').val(item.d_jual_barang_harjul);
            $('#gdiskon').val(item.d_jual_diskon);
            $('#gtotal').val(item.d_jual_total);
            $('#gjenisbayar').val(item.jual_bayar);
            $('#gstatusbayar').val(item.jual_bayar_status);
            //-------------------------
            $('#nofakValue').text(nofak);
            $('#tglValue').text(item.jual_tanggal);
            $('#nmcustValue').text(item.jual_cust_nama);
            $('#jenisByr').text(item.jual_bayar);
            $('#statusByr').text(item.jual_bayar_status);
            //----mengisi jatuh tempo tanggal 1 bulan
            var tgTrans = item.jual_tanggal;
            var currentDate = new Date(tgTrans);
            var selectedPeriod = 1;
            var futureDate = new Date(currentDate);
            futureDate.setMonth(currentDate.getMonth() + selectedPeriod);
            var formattedDate = futureDate.toISOString().slice(0, 10);
            $('input[name^="tglJtempo"]').val(formattedDate);
            
        });

        // Tampilkan modal
        $('#modalGaransi').modal('show');
    });

    // Menangani tombol "Lihat Data Garansi" yang diklik
    $(document).on('click', '.btn-lihatgaransi', function () {
        $('#modalImage').attr('src', '');   //mengosongkan tampilan gambar terlebih dahulu
        var nofak = $(this).data('nofak');
        var idbrg = $(this).data('idbrg');

        // Cari data yang sesuai dari data penjualan yang telah diambil sebelumnya
        var garansiData = dataGaransi.filter(function (item) {
            return item.g_nofak === nofak && item.g_brg_id === idbrg;
        });

        // Bersihkan isi tabel modal sebelum menambahkan data baru
        $('#tbl_info2 tbody').empty();

        // Loop through the data and append rows to the modal table
        $.each(garansiData, function (index, item) {
            var harjul = parseFloat(item.g_harjul);
            var diskon = parseFloat(item.g_diskon);
            var total = parseFloat(item.g_total);
            var qty = parseFloat(item.g_qty);
            var formatted_qty;
            if (Math.floor(qty) === qty) {
                formatted_qty = qty.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ','); // Format sebagai bilangan bulat
            } else {
                formatted_qty = qty.toFixed(2).replace('.', ',').replace(/\.?0+$/, '').replace(/\B(?=(\d{3})+(?!\d))/g, ','); // Format sebagai bilangan desimal
            }
            var newRow = '<tr>' +
                '<td style="text-align:center;">' + item.g_brg_id + '</td>' +
                '<td style="text-align:center;">' + item.g_brg_nama + '</td>' +
                '<td style="text-align:center;">' + item.g_brg_sat + '</td>' +
                '<td style="text-align:center;">' + formatted_qty + '</td>' +
                '<td style="text-align:right;">' + harjul.toLocaleString('id-ID') + '</td>' +
                '<td style="text-align:right;">' + diskon.toLocaleString('id-ID') + '</td>' +
                '<td style="text-align:right;">' + total.toLocaleString('id-ID') + '</td>' +
                '</tr>';

            $('#tbl_info2 tbody').append(newRow);
            //-------------------------
            $('#nofakValue2').text(nofak);
            $('#tglValue2').text(item.g_jual_tgl);
            $('#nmcustValue2').text(item.g_cust_nama);
            $('#jenisByr2').text(item.g_jenis_bayar);
            $('#statusByr2').text(item.g_status_bayar);
            $('#periode2').val(item.g_periode);
            var date = new Date(item.g_jtempo);
            var formattedDate = date.toLocaleDateString('id-ID'); // Menggunakan bahasa Indonesia
            $('#tglJtempo2').val(formattedDate);            
            $('#ket2').val(item.g_ket);
            //cek gambar sudah ada atau belum 
            //var gimage = item.g_url; // URL atau path file gambar
            var nameimg = item.g_image;
            var pathimg = "<?php echo base_url().'assets/img/img_barcode/'; ?>";
            var gimage = pathimg + nameimg;
            var modalImageElement = document.getElementById('modalImage');
                var xhr = new XMLHttpRequest();
                xhr.open('HEAD', gimage, true);
                xhr.onreadystatechange = function () {
                    if (xhr.readyState == 4) {
                        if (xhr.status == 200) {
                            // File gambar ditemukan
                            //console.log('File gambar ada.');
                            modalImageElement.src = gimage;
                        } else {
                            // File gambar tidak ditemukan atau terjadi kesalahan
                            //console.log('File gambar tidak ditemukan atau terjadi kesalahan.');
                        }
                    }
                };
                xhr.send();

        });

        // Tampilkan modal
        $('#modalLihatGaransi').modal('show');
    });


    // Menangani tombol "Cetak Barcode" yang diklik
    $(document).on('click', '.btn-cetak', function () {
        $('#modalImage2').attr('src', '');  //mengosongkan tampilan gambar terlebih dahulu
        $('#gimg').val('');
        $('#kdbrg').val('');
        $('#kdbrg2').val('');

        var nofak = $(this).data('nofak');
        var idbrg = $(this).data('idbrg');
        $('#option1').prop('checked', true);
       
        // Cari data yang sesuai dari data penjualan yang telah diambil sebelumnya
        var garansiData = dataGaransi.filter(function (item) {
            return item.g_nofak === nofak && item.g_brg_id === idbrg;
        });

        // Loop through the data and append rows to the modal table
        $.each(garansiData, function (index, item) {
            //cek gambar sudah ada atau belum 
            $('#gimg').val(item.g_image);
            $('#kdbrg').val(item.g_brg_id);
            $('#kdbrg2').val(item.g_brg_id);
            //var gimage = item.g_url; // URL atau path file gambar
            var nameimg = item.g_image;
            var pathimg = "<?php echo base_url().'assets/img/img_barcode/'; ?>";
            var gimage = pathimg + nameimg;

            var modalImageElement = document.getElementById('modalImage2');
                var xhr = new XMLHttpRequest();
                xhr.open('HEAD', gimage, true);
                xhr.onreadystatechange = function () {
                    if (xhr.readyState == 4) {
                        if (xhr.status == 200) {
                            // File gambar ditemukan
                            //console.log('File gambar ada.');
                            modalImageElement.src = gimage;
                        } else {
                            // File gambar tidak ditemukan atau terjadi kesalahan
                            //console.log('File gambar tidak ditemukan atau terjadi kesalahan.');
                        }
                    }
                };
                xhr.send();

        });

        // Tampilkan modal
        $('#modalCetak').modal('show');
    });

    
});

// Fungsi untuk mengatur target="_blank" setelah formulir dikirim
function setTargetBlank() {
    document.getElementById("cetakForm").target = "_blank";
}


// Ambil elemen tombol pilihan "Option 1" dan "Option 2" menggunakan ID
    var option1 = document.getElementById('option1');
    var option2 = document.getElementById('option2');
    // Tambahkan event listener untuk mengisi kembali input "kdbrg" saat "Option 1" dipilih
    option1.addEventListener('change', function() {
        if (this.checked) {
            // Jika "Option 1" dipilih, isi nilai input "kdbrg" dengan data default
            document.getElementById('kdbrg').value = document.getElementById('kdbrg2').value;
        }
    });
    // Tambahkan event listener untuk mengosongkan input "kdbrg" saat "Option 2" dipilih
    option2.addEventListener('change', function() {
        if (this.checked) {
            // Jika "Option 2" dipilih, kosongkan nilai input "kdbrg"
            document.getElementById('kdbrg').value = '';
        }
    });
//--------------------------------------------



function pilihKode(id) {
    $('#nofak').val(id);
    $('#largeModal').modal('hide');
}


// function refreshPageAndShowModal() {
//     var currentUrl = window.location.href;
//     var newUrl = currentUrl.includes('?') ? currentUrl + '&showModal=true' : currentUrl + '?showModal=true';
//     window.location.href = newUrl;
// }

// Pada halaman yang dimuat kembali
// $(document).ready(function() {
//     if (window.location.search.includes('showModal=true')) {
//         // Tampilkan modal
//         $('#largeModal').modal('show');
//     }
// });



$(document).on('change', 'select[name^="periode"]', function(e) {
    var tgTrans = $('#gjualtgl').val();
    var currentDate = new Date(tgTrans);
    var selectedPeriod = parseInt($(this).val());
    var futureDate = new Date(currentDate);
    futureDate.setMonth(currentDate.getMonth() + selectedPeriod);
    var formattedDate = futureDate.toISOString().slice(0, 10);
    $('input[name^="tglJtempo"]').val(formattedDate);
});

// // Fungsi untuk memformat tanggal ke format "YYYY-MM-DD"
// function formatDate(date) {
//     var year = date.getFullYear();
//     var month = (date.getMonth() + 1).toString().padStart(2, '0'); // Bulan dimulai dari 0
//     var day = date.getDate().toString().padStart(2, '0');
//     return year + '-' + month + '-' + day;
// }

$(document).on('input', 'input[name^="tglJtempo"]', function(e) {
        var inputValue = e.target.value; 
        var sanitizedValue = inputValue.replace(/[^0-9\-]/g, '');
        e.target.value = sanitizedValue; 
});

</script>

<script>
    function addFile() {
    var index = $('.bfile').length + 1;
    var newRow = '<tr>' +
        '<td style="text-align:center;vertical-align:middle;"><input type="text" name="nmfile[]" class="form-control input-sm nmfile" style="width:100%;" readonly></td>' +
        '<td style="text-align:center;vertical-align:middle;"><img class="modal-image imgfile" alt="File" style="width:100px;height:100px;" /></td>' +
        '<td style="text-align:center;vertical-align:middle;"><label class="btn btn-sm btn-success btn-file"><i class="fa fa-upload"></i> Pilih File <input type="file" name="bfile[]" class="bfile" style="display:none;"></label></td>' +
        '</tr>';
    $('#tbl_file tbody').append(newRow);

    // Event listener saat input file diubah (file dipilih)
    $('.bfile').last().change(function() {
        var file1 = $(this).val().split("\\").pop();
        $(this).closest('tr').find('.nmfile').val(file1);
        var imgElement = $(this).closest('tr').find(".imgfile");
        var selectedFile = this.files[0];     // Membaca file yang dipilih
        if (selectedFile) { // Memeriksa apakah ada file yang dipilih
            var imageURL = URL.createObjectURL(selectedFile);   // Membuat objek URL untuk file gambar
            imgElement.attr("src", imageURL);   // Menampilkan gambar pada elemen gambar
        }
    });
}

</script>

<script>
$(document).on('click', '.btn-tampilhapus', function() {
    var g_id = $(this).data('gid');
    var g_file = $(this).data('gfile');
    $('#txtgid').val(g_id);
    $('#txtfile').val(g_file);
    $('#nmfileVal').text(g_file);
});
</script>

<script>
$(document).on('click', '.btn-hapusfile', function () {
    var gid2 = $('#txtgid').val();
    var gfile2 = $('#txtfile').val();
    $.ajax({
        type: "POST",
        url: "<?php echo base_url().'admin/barcode/hapus_garansi_file';?>",
        data: { 
            gid2 : gid2,
            gfile2 : gfile2
        },
        dataType: 'json',
        success: function (data) {
            if (data.error) {
                //console.error("Error:", data.error);
            } else {
                tampil_garansi_file();
            }
        },
        error: function (xhr, status, error) {
            console.error("AJAX error:", error);
        }
    });
});

$(document).on('click', '.btn-upload', function () {
    var nofak = $(this).data('nofak');
    var idbrg = $(this).data('idbrg');
    $('#txtnofak').val(nofak);
    $('#txtidbrg').val(idbrg);
    tampil_garansi_file();
});

function tampil_garansi_file() {
    $('#tbl_info3 tbody').empty();
    $('#tbl_file tbody').empty();
    //var nofak = $(this).data('nofak');
    //var idbrg = $(this).data('idbrg');
    var nofak = $('#txtnofak').val();
    var idbrg = $('#txtidbrg').val();
    $.ajax({
        type: "POST",
        url: "<?php echo base_url().'admin/barcode/get_garansi_file';?>",
        data: { 
            nofak : nofak,
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
                        dataGaransi = data.queryA;
                        dataFile = data.queryB;
                        
                        $.each(dataGaransi, function (index, itemA) {
                            //-------------------------------------------
                            var harjul = parseFloat(itemA.g_harjul);
                            var diskon = parseFloat(itemA.g_diskon);
                            var total = parseFloat(itemA.g_total);
                            var qty = parseFloat(itemA.g_qty);
                            var formatted_qty;
                            if (Math.floor(qty) === qty) {
                                formatted_qty = qty.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ','); // Format sebagai bilangan bulat
                            } else {
                                formatted_qty = qty.toFixed(2).replace('.', ',').replace(/\.?0+$/, '').replace(/\B(?=(\d{3})+(?!\d))/g, ','); // Format sebagai bilangan desimal
                            }
                            var newRow = '<tr>' +
                                '<td style="text-align:center;">' + itemA.g_brg_id + '</td>' +
                                '<td style="text-align:center;">' + itemA.g_brg_nama + '</td>' +
                                '<td style="text-align:center;">' + itemA.g_brg_sat + '</td>' +
                                '<td style="text-align:center;">' + formatted_qty + '</td>' +
                                '<td style="text-align:right;">' + harjul.toLocaleString('id-ID') + '</td>' +
                                '<td style="text-align:right;">' + diskon.toLocaleString('id-ID') + '</td>' +
                                '<td style="text-align:right;">' + total.toLocaleString('id-ID') + '</td>' +
                                '</tr>';

                            $('#tbl_info3 tbody').append(newRow);
                            //-------------------------------------------
                            //$('#txtnofak').val(nofak);
                            //$('#txtidbrg').val(idbrg);
                            $('#nofakValue3').text(nofak);
                            $('#tglValue3').text(itemA.g_jual_tgl);
                            $('#nmcustValue3').text(itemA.g_cust_nama);
                            $('#jenisByr3').text(itemA.g_jenis_bayar);
                            $('#statusByr3').text(itemA.g_status_bayar);
                        });

                        $.each(dataFile, function (index, itemB) {
                            var newRow = '<tr>' +
                                '<td style="text-align:center;vertical-align:middle;"><input type="text" name="nmfile[]" value="' + itemB.g_file + '" class="form-control input-sm nmfile" style="width:100%;" readonly></td>' +
                                '<td style="text-align:center;vertical-align:middle;"><img class="modal-image imgfile" alt="File" style="width:100px;height:100px;" src="<?php echo base_url();?>assets/img/file_garansi/' + itemB.g_file + '"></td>' +
                                '<td style="text-align:center;vertical-align:middle;">' +
                                '<a href="<?php echo base_url();?>assets/img/file_garansi/' + itemB.g_file + '" class="btn btn-info btn-xs" download="' + itemB.g_file + '" title="Unduh File"><span class="fa fa-download"></span> </a> ' +
                                '<a href="<?php echo base_url();?>assets/img/file_garansi/' + itemB.g_file + '" class="btn btn-success btn-xs" target="_blank" title="Buka File"><span class="fa fa-eye"></span> </a> ' +
                                '<a href="#modalHapusFile" data-toggle="modal" class="btn btn-danger btn-xs btn-tampilhapus" data-gid="' + itemB.g_id + '" data-gfile="' + itemB.g_file + '" title="Hapus File"><span class="fa fa-trash"></span> </a>' +
                                '</td>' +
                                '</tr>';

                            $('#tbl_file tbody').append(newRow);
                        });

                        
                        // Tampilkan modal
                        $('#modalUpload').modal('show');
                }
            }
        },
        error: function (xhr, status, error) {
            console.error("AJAX error:", error);
        }
    });
}
</script>

<script>
$(document).on('click', '.btn-tampilgaransi', function () {
    $('#detailTable tbody').empty();
    $('#tbl_info2 tbody').empty();
    $('#modalImage').attr('src', '');   //mengosongkan tampilan gambar terlebih dahulu
    var nofak = $(this).data('nofak');
    var idbrg = $(this).data('idbrg');

    $.ajax({
        type: "POST",
        url: "<?php echo base_url().'admin/barcode/get_detail_jual';?>",
        data: { nofak: nofak },
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
                        // Simpan data penjualan ke variabel
                        dataGaransi = data.queryA;
                        // Cari data yang sesuai dari data penjualan yang telah diambil sebelumnya
                        var garansiData = dataGaransi.filter(function (item) {
                            return item.g_nofak === nofak && item.g_brg_id === idbrg;
                        });

                        // Loop through the data and append rows to the modal table
                        $.each(garansiData, function (index, item) {
                            var harjul = parseFloat(item.g_harjul);
                            var diskon = parseFloat(item.g_diskon);
                            var total = parseFloat(item.g_total);
                            var qty = parseFloat(item.g_qty);
                            var formatted_qty;
                            if (Math.floor(qty) === qty) {
                                formatted_qty = qty.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ','); // Format sebagai bilangan bulat
                            } else {
                                formatted_qty = qty.toFixed(2).replace('.', ',').replace(/\.?0+$/, '').replace(/\B(?=(\d{3})+(?!\d))/g, ','); // Format sebagai bilangan desimal
                            }
                            var newRow = '<tr>' +
                                '<td style="text-align:center;">' + item.g_brg_id + '</td>' +
                                '<td style="text-align:center;">' + item.g_brg_nama + '</td>' +
                                '<td style="text-align:center;">' + item.g_brg_sat + '</td>' +
                                '<td style="text-align:center;">' + formatted_qty + '</td>' +
                                '<td style="text-align:right;">' + harjul.toLocaleString('id-ID') + '</td>' +
                                '<td style="text-align:right;">' + diskon.toLocaleString('id-ID') + '</td>' +
                                '<td style="text-align:right;">' + total.toLocaleString('id-ID') + '</td>' +
                                '</tr>';

                            $('#tbl_info2 tbody').append(newRow);
                            //-------------------------
                            $('#nofakValue2').text(nofak);
                            $('#tglValue2').text(item.g_jual_tgl);
                            $('#nmcustValue2').text(item.g_cust_nama);
                            $('#jenisByr2').text(item.g_jenis_bayar);
                            $('#statusByr2').text(item.g_status_bayar);
                            $('#periode2').val(item.g_periode);
                            var date = new Date(item.g_jtempo);
                            var formattedDate = date.toLocaleDateString('id-ID'); // Menggunakan bahasa Indonesia
                            $('#tglJtempo2').val(formattedDate);            
                            $('#ket2').val(item.g_ket);
                            //cek gambar sudah ada atau belum 
                            //var gimage = item.g_url; // URL atau path file gambar
                            var nameimg = item.g_image;
                            var pathimg = "<?php echo base_url().'assets/img/img_barcode/'; ?>";
                            var gimage = pathimg + nameimg;
                            var modalImageElement = document.getElementById('modalImage');
                                var xhr = new XMLHttpRequest();
                                xhr.open('HEAD', gimage, true);
                                xhr.onreadystatechange = function () {
                                    if (xhr.readyState == 4) {
                                        if (xhr.status == 200) {
                                            // File gambar ditemukan
                                            //console.log('File gambar ada.');
                                            modalImageElement.src = gimage;
                                        } else {
                                            // File gambar tidak ditemukan atau terjadi kesalahan
                                            //console.log('File gambar tidak ditemukan atau terjadi kesalahan.');
                                        }
                                    }
                                };
                                xhr.send();

                        });

                        // Tampilkan modal
                        $('#modalLihatGaransi').modal('show');
                }
            }
        },
        error: function (xhr, status, error) {
            console.error("AJAX error:", error);
        }
    });
});
</script>




</body>
</html>
