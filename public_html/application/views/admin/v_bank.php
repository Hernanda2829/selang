<!DOCTYPE html>
<html lang="en">

<head>
    <?php 
	error_reporting(0);
    $userid=$userid->row_array();
    $data_regid=$userid['reg_id'];
    ?>  
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Produk By <?php echo $userid['co_name'];?>">
    <meta name="author" content="<?php echo $userid['co_name'];?>">

    <title>Transaksi Bank</title>
    <link rel="shortcut icon" href="<?php echo base_url().'assets/img/'. $userid['co_imgicon']; ?>" alt="#no image#" type="image/x-icon">
    <!-- Bootstrap Core CSS -->
    <link href="<?php echo base_url().'assets/css/bootstrap.min.css'?>" rel="stylesheet">
	<link href="<?php echo base_url().'assets/css/style.css'?>" rel="stylesheet">
	<link href="<?php echo base_url().'assets/css/font-awesome.css'?>" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?php echo base_url().'assets/css/showMessageModal.css'?>" rel="stylesheet">
    <link href="<?php echo base_url().'assets/css/4-col-portfolio.css'?>" rel="stylesheet">
    <link href="<?php echo base_url().'assets/css/dataTables.bootstrap.min.css'?>" rel="stylesheet">
    <link href="<?php echo base_url().'assets/css/jquery.dataTables.min.css'?>" rel="stylesheet">
    <link href="<?php echo base_url().'assets/dist/css/bootstrap-select.css'?>" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/css/bootstrap-datetimepicker.min.css'?>">
    


<style>
    #mydata_wrapper .dataTables_paginate,
    #mydata_wrapper .dataTables_filter input,
    #mydata_wrapper .dataTables_length,
    #mydata_wrapper .dataTables_info {
        font-size: 11px;
    }
    #mydata_wrapper .dataTables_filter label {
    font-size: 11px;
    }
   
    .bootstrap-select .btn {
        font-size: 11px; /* Ganti 16px sesuai dengan ukuran font yang Anda inginkan */
    }
    
    .col-md-4 {
        margin-bottom: 50px; /* Atur sesuai kebutuhan Anda */
    }
    .card {
        margin-bottom: 50px; /* Atur sesuai kebutuhan Anda */
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

<!-- View Message File -->
<?php $this->load->view('admin/alert/message'); ?>

  
    <!-- Page Content -->
    <div class="container">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Input
                    <small>Transaksi Bank</small>
                    <div class="pull-right"><a href="#" class="btn btn-sm btn-success" data-toggle="modal" data-target="#modalAdd"><span class="fa fa-plus"></span> Tambah No Rekening</a></div>
                </h1>
            </div>
        </div>
        <br>
        <!-- /.row -->
        <!-- Projects Row -->
    <div class="container mb-5">
        <div class="row justify-content-center">
            <?php foreach ($data->result_array() as $a) :
                $r_id = $a['rek_id'];
                $r_norek = $a['rek_norek'];
                $r_nama = $a['rek_nama'];
                $r_bank = $a['rek_bank'];
                $r_logo = $a['rek_logo'];
            ?>
                <div class="col-md-4 mb-5"> <!-- Ubah nilai margin di sini -->
                    <div class="card text-center mb-5"> <!-- Ubah nilai margin di sini -->
                        <a class="btn-edit" href="#modalEdit" data-toggle="modal" title="Edit Rekening" class="btn btn-primary btn-input" data-rekid="<?= $r_id; ?>">
                            <img src="<?= base_url('assets/img/img_bank/' . $r_logo); ?>" class="card-img-top" style="max-height: 150px; object-fit: contain;">
                        </a>
                        <div class="card-body">
                            <h5 class="card-title">
                                <a class="btn-lihat" href="#modalLihat" data-toggle="modal" title="Lihat History Transaksi" data-norek="<?= $r_norek; ?>" data-nama="<?= $r_nama; ?>" data-bank="<?= $r_bank; ?>" data-img="<?= base_url('assets/img/img_bank/' . $r_logo); ?>" style="padding-left: 5px; color: black; text-decoration: none; transition: color 0.3s;" onmouseover="this.style.color='#FFD700'" onmouseout="this.style.color='black'">
                                <i class="fa fa-book" style="margin-right: 5px;"><strong></i><?= $r_norek; ?></strong>
                                </a>
                            </h5>
                            <p class="card-text"><?= $r_nama; ?></p>
                            <a href="#modalInput" data-toggle="modal" title="Input Data Transaksi" class="btn btn-primary btn-input" data-norek="<?= $r_norek; ?>" data-nama="<?= $r_nama; ?>" data-bank="<?= $r_bank; ?>" data-img="<?= base_url('assets/img/img_bank/' . $r_logo); ?>">Input Transaksi</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>


     <!-- ============ MODAL Input =============== -->
        <div class="modal fade" id="modalInput" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 class="modal-title" id="myModalLabel">Input Transaksi</h3>
            </div>
            <form class="form-horizontal" method="post" action="<?php echo base_url().'admin/bank/tambah_transaksi'?>">
                <div class="modal-body">
                <input name="kode" id="kode" type="hidden">
                <table style="font-size:11px; width: 100%;">
                    <tr>
                        <th style="font-weight:normal;width:8%;">Nama Bank</th>
                        <th style="font-weight:normal;text-align:center;width:3%;"> : </th>
                        <th style="font-weight:normal;width:30%;"><span id="bankValue" style="color: green;"></span></th>
                        <th rowspan="3" style="font-weight:normal;text-align:right;width:15%;">
                            <img id="modalImage" class="modal-image" alt="Gambar" style="max-height: 60px; width: auto; float: right;margin:5px;"/>
                        </th> 
                    </tr>
                    <tr>    
                        <th style="font-weight:normal;width:8%;">No Rekening</th>
                        <th style="font-weight:normal;text-align:center;width:3%;">: </th>
                        <th style="font-weight:normal;width:30%;"><b><span id="norekValue"></span></b></th>
                        
                    </tr>
                    <tr>
                        <th style="font-weight:normal;width:8%;">Nama Rekening</th>
                        <th style="font-weight:normal;text-align:center;width:3%;">: </th>
                        <th style="font-weight:normal;width:30%;"><b><span id="namaValue" style="color: green;"></span></b></th>    
                    </tr>
                </table>
                <br>
                <table class="table table-bordered table-condensed" style="font-size: 11px;">
                    <tr>
                        <th style="width:150px;vertical-align: middle;">Tanggal Transaksi</th>
                        <td>
                            <div class='input-group date' id='datepicker' style="width:130px;">
                                <input type='text' name="tgltrans" class="form-control" style="font-size:11px;color:green;" placeholder="Tanggal..." required>
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th style="width:150px;vertical-align:middle;">Mutasi Saldo</th>
                        <td>
                        <select name="mutasi" class="selectpicker show-tick form-control" title="Pilih Mutasi" placeholder="Pilih Mutasi" data-width="130px" required>
                            <option value="Debit" style='font-size:11px;'>Uang Keluar </option>
                            <option value="Kredit" style='font-size:11px;'>Uang Masuk </option>
                        </select>
                        </td>
                   </tr>
                    <tr>
                        <th style="width:150px;padding-bottom:5px;vertical-align:middle;">Keterangan</th>
                        <td><input name="ket" class="form-control input-sm" type="text" placeholder="isi keterangan..." style="width:400px;" maxlength="50" required></td> 
                    </tr>
                    <tr>
                        <th style="width:150px;padding-bottom:5px;vertical-align:middle;">Jumlah </th>
                        <td><input name="jml" id="jml" class="form-control input-sm" type="text" placeholder="Jumlah..." style="text-align:right;width:150px;" maxlength="20" required></td>
                    </tr>
                </table>
                <!-- <hr/> -->
                <!-- <p> Input Data di bawah ini, untuk Inisialisasi Mutasi Transfer Saldo Cabang,</p>  
                <table class="table table-bordered table-condensed" style="font-size: 11px;">
                <tr>
                    <th style="width:150px;padding-bottom:5px;vertical-align:middle;">Pilih Cabang </th>
                    <td>
                    <select name="cabang" class="selectpicker show-tick form-control" data-live-search="true" title="" data-width="150px">
                    <option value="" style="font-size: 11px;"></option>
                    <?php 
                            // $regions_data = $this->Mlogin->tampil_regions()->result_array();
                            // foreach ($regions_data as $rg) {
                            //     $reg_id = $rg['reg_id'];
                            //     $reg_name = $rg['reg_name'];    
                            //     echo '<option value="'.$reg_id.'" style="font-size:11px;">'.$reg_name.'</option>';
                            // }
                            ?>
                    </select>
                    <span style="color:green;padding-left:5px"> (Transfer)</span>
                    </td>
                </tr>
                </table>     -->
                </div>
                <div class="modal-footer">
                    <button class="btn btn-info">Simpan</button>    
                    <button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
                </div>
            </form>
            </div>
            </div>
        </div>

                            
<!-- ============ MODAL Lihat/History Transaksi =============== -->
        <div class="modal fade" id="modalLihat" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
            <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <table id="tbl_info_norek" style="font-size:11px; width: 100%;">
                        <tr>
                            <th rowspan="3" style="font-weight:normal;width:2%;">
                                <img id="modalImage2" class="modal-image" alt="Gambar" style="max-height:60px;"/>
                            </th> 
                            <th style="font-weight:normal;width:7%;">Nama Bank</th>
                            <th style="font-weight:normal;text-align:center;width:3%;"> : </th>
                            <th style="font-weight:normal;width:30%;"><span id="bankValue2" style="color: green;"></span></th>
                        </tr>
                        <tr>    
                            <th style="font-weight:normal;width:7%;">No Rekening</th>
                            <th style="font-weight:normal;text-align:center;width:3%;">: </th>
                            <th style="font-weight:normal;width:30%;"><b><span id="norekValue2"></span></b></th>
                            
                        </tr>
                        <tr>
                            <th style="font-weight:normal;width:7%;">Nama Rekening</th>
                            <th style="font-weight:normal;text-align:center;width:3%;">: </th>
                            <th style="font-weight:normal;width:30%;"><b><span id="namaValue2" style="color: green;"></span></b></th>    
                            <th style="font-size:15px;color:grey;width:20%;text-align:right;padding-right:20px;"><b>Lihat History Transaksi<b></th>
                        </tr>
                    </table>
            </div>
            
                <div class="modal-body" style="overflow:scroll;height:400px;">
                    <input name="norek_history" id="norek_history" type="hidden">

                    <!-- Navigasi Tab -->
                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#tabHistory" style="font-size:11px;"><b>History Transaksi</b></a></li>
                        <li><a data-toggle="tab" href="#tabEditTransaksi" style="font-size:11px;"><b>Edit Transaksi</b></a></li>
                        <!-- Tambahkan lebih banyak tab sesuai kebutuhan -->
                    </ul>

                    <!-- Isi Tab -->
                    <div class="tab-content">
                        <!-- Tab 1: Informasi -->
                        <div id="tabHistory" class="tab-pane fade in active">
                        <br>
                            <table style="font-size:11px;margin-bottom:5px;width:100%;">
                                <tr>
                                    <th style="width:15%;vertical-align:middle;">Tgl Transaksi :</th>
                                    <td style="width:10%;">
                                        <div class='input-group date' id='datepicker1' style="width:130px;">
                                            <input type='text' id="tgl1" name="tgl1" class="form-control input-sm" style="font-size:11px;color:green;" placeholder="Tanggal..." value="<?= $firstDayOfMonth; ?>" required>
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar"></span>
                                            </span>
                                        </div>
                                    </td>
                                    <td style="text-align:center;vertical-align:middle;"> S/d</td>
                                    <td style="width:15%;">
                                        <div class='input-group date' id='datepicker2' style="width:130px;">
                                            <input type='text' id="tgl2" name="tgl2" class="form-control input-sm" style="font-size:11px;color:green;" placeholder="Tanggal..." value="<?= $lastDayOfMonth; ?>" required>
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar"></span>
                                            </span>
                                        </div>
                                    </td>
                                    <td style="text-align:center;width:10%;">
                                        <a class="btn btn-sm btn-info btn-history" data-toggle="modal" title="Tampilkan Data"><span class="fa fa-search"></span></a>
                                    </td>
                                    <td style="text-align:right;vertical-align:middle;">
                                    <strong><span> Saldo Saat Ini : Rp. </span><span id="saldoVal" style="color:green"></span>,-</strong>
                                    </td>
                                </tr>
                            </table>
                            <table id="tbl_history" class="table table-striped table-bordered" style="font-size:11px;">
                                <thead>
                                    <tr>
                                        <th style="text-align:center;"> Tgl</th>
                                        <th style="text-align:center"> Keterangan</th>
                                        <th style="text-align:center"> Debit</th>
                                        <th style="text-align:center"> Kredit</th>
                                        <th style="text-align:center"> Saldo</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                        <!-- Tab 2: History -->
                        <div id="tabEditTransaksi" class="tab-pane fade">
                            <br>
                            <div class="row">
                                <div class="col-lg-12">
                                <table id="mydata" class="table table-striped table-bordered" style="font-size:11px;">
                                    <thead>
                                        <tr>
                                            <th style="text-align:center;background-image:none!important;"> Tgl</th>
                                            <th style="text-align:center" data-orderable="false"> Keterangan</th>
                                            <th style="text-align:center" data-orderable="false"> Debit</th>
                                            <th style="text-align:center" data-orderable="false"> Kredit</th>
                                            <th style="text-align:center;" data-orderable="false">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                                </div>
                            </div>
                        </div>
                    </div>
                <hr/>
                </div>
                <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
                </div>
            </div>
            </div>
        </div>


        <!-- ============ MODAL Add Rekening =============== -->
        <div class="modal fade" id="modalAdd" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 class="modal-title" id="myModalLabel">Tambah No Rekening</h3>
            </div>
            <form class="form-horizontal" method="post" action="<?php echo base_url().'admin/bank/tambah_rekening'?>" enctype="multipart/form-data">
                <div class="modal-body">
                <table class="table table-bordered table-condensed" style="font-size: 11px;">
                    <tr>
                        <th style="width:150px;vertical-align: middle;">No Rekening</th>
                        <td><input name="no_rek" class="form-control input-sm" type="text" placeholder="isikan No Rekening..." style="width:200px;" maxlength="35" required></td> 
                    </tr>
                    <tr>
                        <th style="width:150px;vertical-align:middle;">Nama Rekening</th>
                        <td><input name="nm_rek" class="form-control input-sm" type="text" placeholder="Nama Pemilik Rekening..." style="width:200px;" maxlength="50" required></td> 
                   </tr>
                    <tr>
                        <th style="width:150px;vertical-align:middle;">Nama Bank</th>
                        <td><input name="nm_bank" class="form-control input-sm" type="text" placeholder="Nama Bank..." style="width:200px;" maxlength="35" required></td> 
                    </tr>
                    <tr>
                        <th style="width:150px;vertical-align:middle;">Logo Bank</th>
                        <td>
                            <label class="btn btn-sm btn-success btn-file">
                                <i class="fa fa-upload"></i> Browse <input type="file" name="logo_bank" style="display: none;">
                            </label>
                            <span id="file-name-display">No File Selected...</span>
                        </td>

                        <!-- <td><input type="file" name="logo_bank"/></td>  -->
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
        
        <!-- ============ MODAL Edit Rekening =============== -->
        <div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 class="modal-title" id="myModalLabel">Edit Rekening</h3>
            </div>
            <form class="form-horizontal" method="post" action="<?php echo base_url().'admin/bank/edit_rekening'?>" enctype="multipart/form-data">
                <div class="modal-body">
                    <input name="rekid3" id="rekid3" type="hidden">
                    <input name="txtlogo" id="txtlogo" type="hidden">
                <table class="table table-bordered table-condensed" style="font-size: 11px;">
                    <tr>
                        <th style="width:150px;vertical-align: middle;">No Rekening</th>
                        <td><input name="no_rek3" id="no_rek3" class="form-control input-sm" type="text" placeholder="isikan No Rekening..." style="width:200px;" maxlength="35" required></td> 
                    </tr>
                    <tr>
                        <th style="width:150px;vertical-align:middle;">Nama Rekening</th>
                        <td><input name="nm_rek3" id="nm_rek3" class="form-control input-sm" type="text" placeholder="Nama Pemilik Rekening..." style="width:200px;" maxlength="50" required></td> 
                   </tr>
                    <tr>
                        <th style="width:150px;vertical-align:middle;">Nama Bank</th>
                        <td><input name="nm_bank3" id="nm_bank3" class="form-control input-sm" type="text" placeholder="Nama Bank..." style="width:200px;" maxlength="35" required></td> 
                    </tr>
                    <tr>
                        <th style="width:150px;vertical-align:middle;">Logo Bank</th>
                        <td>
                            <div style="display:flex;align-items: center;">
                                <input name="nm_logo" id="nm_logo" class="form-control input-sm" type="text" style="width:200px;margin-right:10px;" maxlength="35" readonly>
                                <label class="btn btn-sm btn-success btn-file">
                                    <i class="fa fa-upload"></i> Edit Gambar <input type="file" name="logo_bank3" id="logo_bank3" style="display:none;" accept="image/*">
                                </label>
                                
                            <div>
                        </td>

                    </tr>
                </table>

                <table class="table table-bordered table-condensed" style="font-size:11px;width:100%;">
                    <tr>
                        <th style="width:50%;text-align:center;">Logo Lama</th>
                        <th style="width:50%;text-align:center;">Logo Baru</th>
                    </tr>
                    <tr>
                        <td style="text-align:center;">
                            <div style="display:flex;justify-content:center;align-items:center;">
                                <img id="modalImage3" class="modal-image" alt="Gambar" style="width: 100px; height: 100px;" />
                            </div>
                        </td>
                        <td style="text-align: center;">
                            <div style="display:flex; justify-content:center;align-items:center;">
                                <img id="modalImage4" class="modal-image" alt="Gambar" style="width:100px;height:100px;" />
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align:center;">
                        </td>
                        <td style="text-align:center;">
                           <span id="file-name-display3"></span>
                        </td>
                    </tr>
                </table>
                </div>
                
                <div class="modal-footer" style="display: flex; align-items: center; justify-content: space-between;">
                    <td style="display: flex; text-align: left;"><a href="#modalHapusRekening" data-toggle="modal" class="btn btn-danger btn-hapusrek" title="Hapus No Rekening">Hapus</a></td>
                    <div style="display: flex; margin-left: auto;">
                        <button class="btn btn-info" title="Simpan Perubahan Data">Simpan</button>    
                        <button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
                    </div>
                </div>

            </form>
            </div>
            </div>
        </div>

        <!-- ============ MODAL Hapus Rekening =============== -->

        <div id="modalHapusRekening" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
                    <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h3 class="modal-title" id="myModalLabel">Hapus Data Rekening</h3>
                    </div>   
                    <form class="form-horizontal" method="post" action="<?php echo base_url().'admin/bank/hapus_rekening'?>" enctype="multipart/form-data">
                        <div class="modal-body">
                            <input name="txtidbank" id="txtidbank" type="hidden">
                            <input name="txtnmlogo" id="txtnmlogo" type="hidden">
                            <p>Yakin mau menghapus No Rekening : <b><span id="norekVal"></span></b><br>
                            Nama Rekening : <b><span id="namarekVal"></b></span><br>
                            Nama Bank : <b><span id="namabankVal"></b></span> ... ?...</p>             
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-danger">Hapus</button>    
                            <button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
                        </div>
                    </form>
                </div>
                </div>
                </div>

        <!-- ============ MODAL Hapus Transaksi =============== -->

        <div id="modalHapusTransaksi" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
                    <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h3 class="modal-title" id="myModalLabel">Hapus Data Transaksi</h3>
                    </div>   
                    <form id="formHapusD" class="form-horizontal" onsubmit="hapusData()" method="post" action="<?php echo base_url().'admin/bank/hapus_transaksi'?>">
                        <div class="modal-body">
                            <input name="bankid" id="bankid" type="hidden">
                            <input name="norekhapus" id="norekhapus" type="hidden">
                            <p>Yakin mau menghapus data transaksi tanggal : <span id="tglhapusVal"></span> Keterangan : <span id="kethapusVal"></span> ... ?...</p>             
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-danger">Hapus</button>    
                            <button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
                        </div>
                    </form>
                </div>
                </div>
                </div>


        <!---show message  -->
        <div class="modal fade" id="successModal2" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="successModalLabel">Sukses!</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <div class="checkmark-container">
                        <img src="<?php echo base_url('assets/img/checkmark.png'); ?>" alt="Checkmark" class="img-fluid checkmark">
                    </div>
                    <p><span id="isipesanVal"></span></p>
                </div>
            </div>
        </div>
    </div>
        <!----------------------------------->



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
    <script src="<?php echo base_url().'assets/js/showMessageModal.js'?>"></script>
    <script src="<?php echo base_url().'assets/dist/js/bootstrap-select.min.js'?>"></script>
    <script src="<?php echo base_url().'assets/js/bootstrap.min.js'?>"></script>
    <script src="<?php echo base_url().'assets/js/jquery.dataTables.min.js'?>"></script>
    <script src="<?php echo base_url().'assets/js/moment.js'?>"></script>
    <script src="<?php echo base_url().'assets/js/bootstrap-datetimepicker.min.js'?>"></script>
    
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
    
    <script type="text/javascript">
            $(document).on('click', '.btn-input', function () {
                $('#modalImage').attr('src', '');   //mengosongkan tampilan gambar terlebih dahulu
                var norek = $(this).data('norek');
                var nama = $(this).data('nama');
                var bank = $(this).data('bank');
                var img = $(this).data('img');
                $('#kode').val(norek);
                $('#norekValue').text(norek);
                $('#namaValue').text(nama);
                $('#bankValue').text(bank);
                
                var gimage = img; // URL atau path file gambar
                var modalImageElement = document.getElementById('modalImage');
                var xhr = new XMLHttpRequest();
                xhr.open('HEAD', gimage, true);
                xhr.onreadystatechange = function () {
                    if (xhr.readyState == 4) {
                        if (xhr.status == 200) {
                            //console.log('File gambar ada.');
                            modalImageElement.src = gimage;
                        } else {
                            //console.log('File gambar tidak ditemukan atau terjadi kesalahan.');
                        }
                    }
                };
                xhr.send();

            });
        
        
            $(document).on('input', 'input[name^="jml"]', function(e) {
                var inputValue = e.target.value;
                var sanitizedValue = inputValue.replace(/[^0-9\b\t]/g, ''); // Hapus karakter yang tidak diizinkan (selain angka, koma, backspace, delete, dan tab)
                e.target.value = sanitizedValue; // Update nilai input dengan karakter yang diizinkan
            });
	
            $('input[name^="jml"]').blur(function() {
                var hargabeli = parseFloat($(this).val().replace(/[^\d.,]/g, '')) || 0;
                var formattedHb = hargabeli.toLocaleString('id-ID');
                $(this).val(formattedHb);
            });


            $(document).on('click', '.btn-lihat', function () {
                $('#mydata tbody').empty();
                $('#tbl_history tbody').empty();
                $('#modalImage2').attr('src', '');   //mengosongkan tampilan gambar terlebih dahulu
                var norek = $(this).data('norek');
                var nama = $(this).data('nama');
                var bank = $(this).data('bank');
                var img = $(this).data('img');
                $('#norek_history').val(norek);
                $('#norekValue2').text(norek);
                $('#namaValue2').text(nama);
                $('#bankValue2').text(bank);
                
                var gimage = img; // URL atau path file gambar
                var modalImageElement = document.getElementById('modalImage2');
                var xhr = new XMLHttpRequest();
                xhr.open('HEAD', gimage, true);
                xhr.onreadystatechange = function () {
                    if (xhr.readyState == 4) {
                        if (xhr.status == 200) {
                            //console.log('File gambar ada.');
                            modalImageElement.src = gimage;
                        } else {
                            //console.log('File gambar tidak ditemukan atau terjadi kesalahan.');
                        }
                    }
                };
                xhr.send();

                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url().'admin/bank/tampil_transaksi';?>",
                    data: { norek: norek },
                    dataType: 'json',
                    success: function (data) {
                        //console.log("Data from server:", data);
                        //console.log(norek);
                        if (data.length !== 0) {
                                var saldo=parseFloat(data.queryB.current_saldo);
                                $('#saldoVal').text(saldo.toLocaleString('id-ID'));
                           $.each(data.queryA, function (index, item) {
                                var debit = parseFloat(item.debit);
                                var kredit = parseFloat(item.kredit);
                                var newRow = '<tr>' +
                                    '<td style="font-size:11px;">' + item.bank_tanggal + '</td>' +
                                    '<td style="font-size:11px;">' + item.bank_ket + '</td>' +
                                    '<td style="text-align:right;font-size:11px;">' + debit.toLocaleString('id-ID') + '</td>' +
                                    '<td style="text-align:right;font-size:11px;">' + kredit.toLocaleString('id-ID') + '</td>' +
                                    '<td style="text-align:center;font-size:11px;">' + '<a href="#modalHapusTransaksi" style="font-size:10px;" data-toggle="modal" class="btn btn-danger btn-xs btn-hapus" data-rekid="' + item.bank_id + '" data-norek="' + item.bank_norek + '" data-tgl="' + item.bank_tanggal + '" data-ket="' + item.bank_ket + '" title="Hapus Data Transaksi"><span class="fa fa-close"></span> Hapus</a></td>' +
                                    //'<td style="text-align:center;font-size:11px;">' + '<a href="#modalEditTransaksi" style="font-size:10px;" data-toggle="modal" class="btn btn-warning btn-xs btn-edit2" data-rekid="' + item.bank_id + '" title="Edit Data Transaksi"><span class="fa fa-pencil"></span> Edit</a> ' +
                                    //'<a href="#modalHapusTransaksi" style="font-size:10px;" data-toggle="modal" class="btn btn-danger btn-xs btn-hapus" data-rekid="' + item.bank_id + '" data-norek="' + item.bank_norek + '" data-tgl="' + item.bank_tanggal + '" data-ket="' + item.bank_ket + '" title="Hapus Data Transaksi"><span class="fa fa-close"></span> Hapus</a></td>' +
                                    '</tr>';
                                $('#mydata tbody').append(newRow); 
                            });
                            //$('#mydata').DataTable(); //penting ini,untuk pencarian data
                            if (!$.fn.dataTable.isDataTable('#mydata')) {
                                $('#mydata').DataTable({
                                    "order": [[0, 'desc']] // di urutkan disini karena default dari DataTable Y-m-d
                                });
                            }
                            //-------------------------------
                        } else {
                            console.log("No data found.");
                        }
                    },
                    error: function (xhr, status, error) {
                    console.error("AJAX error:", error);
                    }
                });
            });


            $(document).on('click', '.btn-edit', function () {
                $('#modalImage3').attr('src', '');   //mengosongkan tampilan gambar terlebih dahulu
                $('#modalImage4').attr('src', '');
                $('#file-name-display3').text('');
                var rekid = $(this).data('rekid');
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url().'admin/bank/get_rekening';?>",
                    data: { rekid: rekid },
                    dataType: 'json',
                    success: function (data) {
                        //console.log("Data from server:", data);
                        if (data.length !== 0) {
                            // Setel nilai elemen-elemen dengan data dari server
                            $('#rekid3').val(data.rek_id);
                            $('#no_rek3').val(data.rek_norek);
                            $('#nm_rek3').val(data.rek_nama);
                            $('#nm_bank3').val(data.rek_bank);
                            $('#nm_logo').val(data.rek_logo);
                            var img = data.rek_logo;
                            var gimage = '<?= base_url("assets/img/img_bank/") ?>' + img; // URL atau path file gambar
                            var modalImageElement = document.getElementById('modalImage3');
                            var xhr = new XMLHttpRequest();
                            xhr.open('HEAD', gimage, true);
                            xhr.onreadystatechange = function () {
                                if (xhr.readyState == 4) {
                                    if (xhr.status == 200) {
                                        //console.log('File gambar ada.');
                                        modalImageElement.src = gimage;
                                    } else {
                                        //console.log('File gambar tidak ditemukan atau terjadi kesalahan.');
                                    }
                                }
                            };
                            xhr.send();
                        } else {
                            console.log("No data found.");
                        }
                    },
                    error: function (xhr, status, error) {
                    console.error("AJAX error:", error);
                    }
                });
            });
    </script>    


<script>
// Menggunakan jQuery untuk mendeteksi perubahan pada input file
    $('input[name="logo_bank"]').change(function () {
        // Mendapatkan nama file yang dipilih
        var fileName = $(this).val().split("\\").pop();
        // Menampilkan nama file
        $('#file-name-display').text(fileName);
    });

</script>

<script>
// Event listener saat input file diubah (file dipilih)
$("#logo_bank3").change(function() {
    var fileName = $(this).val().split("\\").pop();
    $('#file-name-display3').text(fileName);
    $('#txtlogo').val(fileName);
    var imgElement = $("#modalImage4");
    // Membaca file yang dipilih
    var selectedFile = this.files[0];
    // Memeriksa apakah ada file yang dipilih
    if (selectedFile) {
        // Membuat objek URL untuk file gambar
        var imageURL = URL.createObjectURL(selectedFile);
        // Menampilkan gambar pada elemen gambar
        imgElement.attr("src", imageURL);
    }
});

// Event listener saat elemen gambar diklik
$("#modalImage4").click(function() {
    // Membuka dialog pemilihan file saat elemen gambar diklik
    $("#logo_bank3").click();
});
</script>


<script>
$(document).ready(function () {
    $(document).on('click', '.btn-history', function () {
    $('#tbl_history tbody').empty();
        var norekhis=$('#norek_history').val();
        var tgl1 = $('#tgl1').val();
        var tgl2 = $('#tgl2').val();

        $.ajax({
            url: "<?php echo base_url().'admin/bank/history_saldo';?>", 
            type: "POST",
            data: {
                norekhis:norekhis,
                tgl1: tgl1,
                tgl2: tgl2
            },
            success: function (data) { 
                //console.log("Data from server:", data);
                //console.log(norekhis);
                // Mengonversi string JSON menjadi objek
                var parsedData = JSON.parse(data);
                var saldo = 0; // Inisialisasi saldo
                var totdebit = 0; // Inisialisasi debit
                var totkredit = 0; // Inisialisasi kredit
                if (parsedData.length !== 0) {
                    // Menambahkan saldo awal sebagai baris pertama
                    saldo=parseFloat(parsedData.queryB.current_saldo);
                    var saldoAwalRow = '<tr>' +
                        '<td style="font-size:11px;"></td>' +
                        '<td style="font-size:11px;color:green;">Saldo Awal</td>' +
                        '<td style="text-align:right;font-size:11px;"></td>' +
                        '<td style="text-align:right;font-size:11px;"></td>' +
                        '<td style="text-align:right;font-size:11px;color:green;">' + saldo.toLocaleString('id-ID') + '</td>' +
                        '</tr>';
                    $('#tbl_history tbody').append(saldoAwalRow);
                    $.each(parsedData.queryA, function (index, item) {
                        var debit = parseFloat(item.debit);
                        var kredit = parseFloat(item.kredit);
                        // Menghitung saldo
                        saldo = saldo + kredit - debit;
                        totdebit = totdebit + debit;
                        totkredit = totkredit + kredit;
                        var newRow = '<tr>' +
                            '<td style="font-size:11px;">' + item.bank_tanggal + '</td>' +
                            '<td style="font-size:11px;">' + item.bank_ket + '</td>' +
                            '<td style="text-align:right;font-size:11px;">' + debit.toLocaleString('id-ID') + '</td>' +
                            '<td style="text-align:right;font-size:11px;">' + kredit.toLocaleString('id-ID') + '</td>' +
                            '<td style="text-align:right;font-size:11px;">' + saldo.toLocaleString('id-ID') + '</td>' +
                            '</tr>';
                        $('#tbl_history tbody').append(newRow); 
                    });
                    var saldoAkhirRow = '<tr style="background-color:#777;">' +
                        '<td style="font-size:11px;"></td>' +
                        '<td style="text-align:right;font-size:11px;color:white;"><b>Total<b></td>' +
                        '<td style="text-align:right;font-size:11px;color:white;">' + totdebit.toLocaleString('id-ID') + '</td>' +
                        '<td style="text-align:right;font-size:11px;color:white;">' + totkredit.toLocaleString('id-ID') + '</td>' +
                        '<td style="text-align:right;font-size:11px;"></td>' +
                        '</tr>';
                    $('#tbl_history tbody').append(saldoAkhirRow);
                    
                } else {
                    console.log("No data found.");
                }
            },
            error: function (xhr, status, error) {
            console.error("AJAX error:", error);
            }
        });
    });
});
</script>

<script>
    function hapusData() {
    event.preventDefault();  // Menghentikan perilaku default form
    var formData = new FormData(event.target); // Dapatkan data dari form
    $.ajax({
        url: event.target.action,
        type: 'POST',
        data: formData,
        dataType: 'json',
        processData: false,
        contentType: false,
        success: function(data) {
            $('#modalHapusTransaksi').modal('hide');
            $('#successModal2').modal('show');
            $('#isipesanVal').text('Data berhasil di hapus.');
            // Setelah 3 detik, modal akan tertutup
            setTimeout(function() {
                $('#successModal2').modal('hide');
            }, 2000); // Ganti 3000 dengan waktu yang diinginkan dalam milidetik
            $('#mydata tbody').empty();
            if (data.length !== 0) {
                $.each(data.queryA, function (index, item) {
                var debit = parseFloat(item.debit);
                    var kredit = parseFloat(item.kredit);
                    var newRow = '<tr>' +
                        '<td style="font-size:11px;">' + item.bank_tanggal + '</td>' +
                        '<td style="font-size:11px;">' + item.bank_ket + '</td>' +
                        '<td style="text-align:right;font-size:11px;">' + debit.toLocaleString('id-ID') + '</td>' +
                        '<td style="text-align:right;font-size:11px;">' + kredit.toLocaleString('id-ID') + '</td>' +
                        '<td style="text-align:center;font-size:11px;">' + '<a href="#modalEditTransaksi" style="font-size:10px;" data-toggle="modal" class="btn btn-warning btn-xs btn-edit2" data-rekid="' + item.bank_id + '" title="Edit Data Transaksi"><span class="fa fa-pencil"></span> Edit</a> ' +
                        '<a href="#modalHapusTransaksi" style="font-size:10px;" data-toggle="modal" class="btn btn-danger btn-xs btn-hapus" data-rekid="' + item.bank_id + '" title="Hapus Data Transaksi"><span class="fa fa-close"></span> Hapus</a></td>' +
                        '</tr>';
                    $('#mydata tbody').append(newRow); 
                });
                //$('#mydata').DataTable(); //penting ini,untuk pencarian data
                if (!$.fn.dataTable.isDataTable('#mydata')) {
                    $('#mydata').DataTable({
                        "order": [[0, 'desc']] // di urutkan disini karena default dari DataTable Y-m-d
                    });
                }
                
            } else {
                console.log("No data found.");
            }
        },
        error: function (xhr, status, error) {
        console.error("AJAX error:", error);
        }
    });
    }
</script>

<script>
$(document).ready(function () {
    $(document).on('click', '.btn-hapus', function () {
    var bankid = $(this).data('rekid');
    var norekhapus = $(this).data('norek');
    var ket = $(this).data('ket');
    var tgl = $(this).data('tgl');
    $('#bankid').val(bankid);
    $('#norekhapus').val(norekhapus);
    $('#tglhapusVal').text(tgl);
    $('#kethapusVal').text(ket);
    });
});
</script>

<script>
    $(document).on('click', '.btn-hapusrek', function () {
    var rekid3 = $('#rekid3').val();
    var nm_logo = $('#nm_logo').val();
    var no_rek3 = $('#no_rek3').val();
    var nm_rek3 = $('#nm_rek3').val();
    var nm_bank3 = $('#nm_bank3').val();
    $('#txtidbank').val(rekid3);
    $('#txtnmlogo').val(nm_logo);
    $('#norekVal').text(no_rek3);
    $('#namarekVal').text(nm_rek3);
    $('#namabankVal').text(nm_bank3);
    });
</script>

<script>
$(document).on('blur', 'input[name^="no_rek"]', function(e) {
    if (!$(this).prop('readonly')) {
        var norek = $(this).val();
        $.ajax({
            url: "<?php echo base_url().'admin/bank/cek_norek';?>",
            data: { norek: norek },
            dataType: 'json',
            success: function(data) {
                //console.log(data);
                if (data && data.is_registered) {
                    alert('No Rekening tersebut sudah terdaftar, silahkan input No Rekening yang berbeda.');
                    setTimeout(function() {
                        $('input[name^="no_rek"]').focus();
                    }, 0);
                }
            },
            error: function(xhr, status, error) {
                //console.log(error);
            }
        });
    }
});

</script>
</body>
</html>
