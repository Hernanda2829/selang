<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    //error_reporting(E_ALL);
    //ini_set('display_errors', 1); 
	error_reporting(0);
    $userid=$userid->row_array();
    $data_regid=$userid['reg_id'];
    ?>  
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Produk By <?php echo $userid['co_name'];?>">
    <meta name="author" content="<?php echo $userid['co_name'];?>">

    <title>Laporan Keuangan</title>
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
    <!-- Data Table Fixed Columnn -->
    <link href="<?php echo base_url().'assets/js/dataTable/dataTables.bootstrap4.min.css'?>" rel="stylesheet">
    <link href="<?php echo base_url().'assets/js/dataTable/fixedColumns.bootstrap4.min.css'?>" rel="stylesheet">
    
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

        <!-- Page Heading -->
        <!-- <div class="row">
            <div class="col-lg-12">
                <h3 style="margin: 0;">Laporan Keuangan dan Penjualan <small><?php //echo $userid['reg_code'];?>  <?php echo $userid['reg_name'];?></small></h3>
            </div>
        </div> -->
        <div class="row">
            <div class="col-lg-8">
                <form id="myForm" class="form-horizontal" method="post" action="">
                <table class="table table-bordered" style="font-size:12px;margin-bottom:10px;">
                    <input type="hidden" name="regid" id="regid" value="<?php echo $data_regid; ?>">
                    <tr>
                        <th style="width:5%;vertical-align:middle;border-top-color:white;border-right-color:white;border-left-color:white;">Bulan :</th>
                        <td style="width:15%;vertical-align:middle;border-top-color:white;border-right-color:white;">
                        <select name="cari_bln" id="cari_bln" class="selectpicker show-tick form-control" title="Pilih Bulan Laporan">
                            <option value="" style="font-size: 11px;"></option>
                            <?php foreach ($daftar_bln as $angka => $bulan) {
                                if ($angka == $bln) {
                                    echo '<option selected value="' . $angka . '">' . $bulan . '</option>';
                                } else {
                                    echo '<option value="' . $angka . '">' . $bulan . '</option>';
                                }
                            }
                            ?>
                        </select>
                        </td>
                        <th style="width:5%;vertical-align:middle;border-top-color:white;border-right-color:white;border-left-color:white;">Tahun :</th>
                        <td style="width:11%;vertical-align:middle;border-top-color:white;border-right-color:white;">
                        <select name="cari_thn" id="cari_thn" class="selectpicker show-tick form-control" title="Pilih Tahun">
                            <option value="" style="font-size: 11px;"></option>
                            <?php foreach ($daftar_thn as $tahun) {
                               
                                if ($tahun == $thn) {
                                    echo '<option selected>' . $tahun . '</option>';
                                } else {
                                    echo '<option>' . $tahun . '</option>';
                                }
                            }
                            ?>
                        </select>
                        </td>
                        <td style="width:4%;vertical-align:middle;border-top-color:white;border-right-color:white;">
                            <a class="btn btn-sm btn-info btn-tampil" data-toggle="modal" title="Tampilkan Data"><span class="fa fa-search"></span></a>
                        </td>
                        <td style="width:30%;vertical-align:middle;text-align:right;border-top-color:white;border-right-color:white;">
                            <button class="btn btn-sm btn-info" title="Cetak Data" onclick="varCetak_Laporan()"><span class="fa fa-print"></span> Cetak Data</button>
                        </td>
                    </tr>
                </table>
                </form>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8 mx-auto text-center" style="margin-bottom:20px;">
                <span style="color:#e26b0a;font-size:14px;"><b>LAPORAN KEUANGAN DAN PENJUALAN <?php echo strtoupper($userid['reg_code']);?>  <?php echo strtoupper($userid['reg_name']);?></b></span>
                <br>
                <span id="periode" style="color:#e26b0a;font-size:14px;"><b>BULAN <?= strtoupper($bln2) ;?></b></span>
            </div>
            <div class="col-lg-8">
                <table id="tbl_lap" class="table table-striped table-bordered" style="font-size:11px;">
                    
                    <?php 
                    // $ku=$data->row_array();
                    // //$omzet = $ku['omzet'];
                    // $piutang = $ku['piutang'];
                    // $jualtunai =  $ku['penjualan_tunai'];
                    // $piutangB =  $ku['piutangB'];
                    // $sudah_bayar =  $ku['sudah_bayar'];
                    // $tagihanA = 0;
                    // $tagihanB = $piutangB - $sudah_bayar;
                    // $jmltagihan = $tagihanA + $tagihanB;
                    // $jmlV = $jualtunai + $sudah_bayar;
                    // $tot=0;
                    // $tot_beb=0;
                    ?>
                    
                    <?php

                    if (!empty($data)) {
                        // Mengambil data pertama dari array hasil
                        $ku = $data[0];    
                        $piutang = isset($ku['piutang']) ? $ku['piutang'] : 0;
                        $jualtunai = isset($ku['penjualan_tunai']) ? $ku['penjualan_tunai'] : 0;
                        $piutangA = isset($ku['piutangA']) ? $ku['piutangA'] : 0;
                        $sudah_bayarA = isset($ku['sudah_bayarA']) ? $ku['sudah_bayarA'] : 0;
                        $piutangB = isset($ku['piutangB']) ? $ku['piutangB'] : 0;
                        $sudah_bayarB = isset($ku['sudah_bayarB']) ? $ku['sudah_bayarB'] : 0;
                        $sudah_bayar = isset($ku['sudah_bayar']) ? $ku['sudah_bayar'] : 0;
                        //tambahan untuk menampilkan saldo akhir bulan kemarin
                        // $jualtunai_kemarin = isset($ku['penjualan_tunai_kemarin']) ? $ku['penjualan_tunai_kemarin'] : 0;
                        // $sudah_bayar_kemarin = isset($ku['sudah_bayar_kemarin']) ? $ku['sudah_bayar_kemarin'] : 0;
                        // $beban_kemarin = isset($ku['beban_kemarin']) ? $ku['beban_kemarin'] : 0;
                        // $transfer_kemarin = isset($ku['transfer_kemarin']) ? $ku['transfer_kemarin'] : 0;
                        $saldo_akhir = isset($ku['saldo_akhir']) ? $ku['saldo_akhir'] : 0;

                    } else {
                        echo "Data not found";
                    }
                    
                    //hit saldo akhir bulan kemarin
                    //$saldo_kemarin = ($jualtunai_kemarin + $sudah_bayar_kemarin) - ($beban_kemarin + $transfer_kemarin);
                    $saldo_kemarin = $saldo_akhir;
                    //-----------------------------
                    $tagihanA = $piutangA - $sudah_bayarA;
                    $tagihanB = $piutang;
                    $jmltagihan = $tagihanA + $tagihanB;
                    $tottagihan = $jmltagihan - $sudah_bayar;

                    $jmlV = $jualtunai + $sudah_bayar;
                    $tot=0;
                    $tot_beb=0;
                    
                    $noI = false; $noVI = false; $noVII = false; // Status untuk menandai apakah angka romawi I sudah ditampilkan
                
                    foreach ($kategori as $k):
                        $kat = $k['kategori_report'];
                        $omzet = $ku['omzet' . $kat];
                        $tot = $tot + $omzet;

                        echo '<tr>';
                        // Tampilkan angka romawi I hanya sekali
                        if (!$noI) {
                            echo '<th style="width:2%;vertical-align:middle;text-align:center;">I</th>';
                            $noI = true; // Set status menjadi true setelah angka romawi I ditampilkan
                        } else {
                            echo '<th style="width:2%;vertical-align:middle;"></th>'; // Kosong untuk baris selanjutnya
                        }

                        echo '<th style="width:30%;vertical-align:middle;">';
                        echo 'OMSET ' . $kat ;
                        echo '<td style="width:5%;vertical-align:middle;text-align:right;"></td>';
                        echo '<td style="width:10%;text-align:right;"></td>';
                        echo '<td style="width:5%;vertical-align:middle;text-align:right;">Rp </td>';
                        echo '<td style="width:10%;vertical-align:middle;text-align:right;">'. str_replace(',', '.', number_format($omzet)) . '</td>';
                        echo '</th>';
                        echo '</tr>';
                    endforeach;

                    echo '<tr>';
                    echo '<th></th>';
                    echo '<th style="width:30%;vertical-align:middle;">';
                    echo 'TOTAL OMSET ';
                    echo '<td style="width:5%;vertical-align:middle;text-align:right;"></td>';
                    echo '<td style="width:10%;text-align:right;"></td>';
                    echo '<td style="width:5%;vertical-align:middle;text-align:right;">Rp </td>';
                    //echo '<td style="width:10%;vertical-align:middle;text-align:right;"><b>'. str_replace(',', '.', number_format($tot)) . '</b></td>';
                    echo '<td style="width:10%;vertical-align:middle;text-align:right;border-top: 2px solid black;color:#538dd5;"><b>'. str_replace(',', '.', number_format($tot)) . '</b></td>';
                    echo '</th>';
                    echo '</tr>';

                    echo '<tr>';
                    echo '<th></th>';
                    echo '<th style="width:30%;vertical-align:middle;">';
                    echo 'PIUTANG Bulan ' . $bln2;
                    echo '<td style="width:5%;vertical-align:middle;text-align:right;"></td>';
                    echo '<td style="width:10%;text-align:right;"></td>';
                    echo '<td style="width:5%;vertical-align:middle;text-align:right;">Rp </td>';
                    echo '<td style="width:10%;vertical-align:middle;text-align:right;color:#ff0000;">'. str_replace(',', '.', number_format($piutang)) . '</td>';
                    echo '</th>';
                    echo '</tr>';

                    echo '<tr>';
                    echo '<th></th>';
                    echo '<th style="width:30%;vertical-align:middle;">';
                    echo 'PENJUALAN TUNAI ' ;
                    echo '<td style="width:5%;vertical-align:middle;text-align:right;"></td>';
                    echo '<td style="width:10%;text-align:right;"></td>';
                    echo '<td style="width:5%;vertical-align:middle;text-align:right;">Rp </td>';
                    echo '<td style="width:10%;vertical-align:middle;text-align:right;border-top: 2px solid black;"><b>'. str_replace(',', '.', number_format($jualtunai)) . '</b></td>';
                    echo '</th>';
                    echo '</tr>';

                    echo '<tr>';
                    echo '<th style="width:2%;vertical-align:middle;text-align:center;">II</th>';
                    echo '<th style="width:30%;vertical-align:middle;">';
                    echo 'JUMLAH TAGIHAN Bulan ' . $bln1;
                    echo '<td style="width:5%;vertical-align:middle;text-align:right;">Rp</td>';
                    echo '<td style="width:10%;vertical-align:middle;text-align:right;color:#ff0000;">'. str_replace(',', '.', number_format($tagihanA)) . '</td>';
                    echo '<td style="width:5%;vertical-align:middle;text-align:right;"> </td>';
                    echo '<td style="width:10%;vertical-align:middle;text-align:right;"></td>';
                    echo '</th>';
                    echo '</tr>';

                    echo '<tr>';
                    echo '<th style="width:2%;vertical-align:middle;"></th>';
                    echo '<th style="width:30%;vertical-align:middle;">';
                    echo 'JUMLAH TAGIHAN Bulan ' . $bln2;
                    echo '<td style="width:5%;vertical-align:middle;text-align:right;">Rp</td>';
                    echo '<td style="width:10%;vertical-align:middle;text-align:right;color:#ff0000;">'. str_replace(',', '.', number_format($tagihanB)) . '</td>';
                    echo '<td style="width:5%;vertical-align:middle;text-align:right;"> </td>';
                    echo '<td style="width:10%;vertical-align:middle;text-align:right;"></td>';
                    echo '</th>';
                    echo '</tr>';

                    echo '<tr>';
                    echo '<th></th>';
                    echo '<th style="width:30%;vertical-align:middle;">';
                    echo ' ' ;
                    echo '<td style="width:5%;vertical-align:middle;text-align:right;"></td>';
                    echo '<td style="width:10%;text-align:right;border-top: 2px solid black;padding-right:3px;"></td>';
                    echo '<td style="width:5%;vertical-align:middle;text-align:right;">Rp </td>';
                    echo '<td style="width:10%;vertical-align:middle;text-align:right;color:#538dd5;"><b>'. str_replace(',', '.', number_format($jmltagihan)) . '</b></td>';
                    echo '</th>';
                    echo '</tr>';

                    echo '<tr>';
                    echo '<th style="width:2%;vertical-align:middle;text-align:center;">III</th>';
                    echo '<th style="width:30%;vertical-align:middle;">';
                    echo 'PELUNASAN TAGIHAN Bulan ' . $bln2;
                    echo '<td style="width:5%;vertical-align:middle;text-align:right;"></td>';
                    echo '<td style="width:10%;text-align:right;"></td>';
                    echo '<td style="width:5%;vertical-align:middle;text-align:right;">Rp </td>';
                    echo '<td style="width:10%;vertical-align:middle;text-align:right;color:#ff0000;">'. str_replace(',', '.', number_format($sudah_bayar)) . '</td>';
                    echo '</th>';
                    echo '</tr>';

                    echo '<tr>';
                    echo '<th style="width:2%;vertical-align:middle;text-align:center;">IV</th>';
                    echo '<th style="width:30%;vertical-align:middle;">';
                    echo 'TOTAL TAGIHAN Bulan ' . $bln2;
                    echo '<td style="width:5%;vertical-align:middle;text-align:right;"></td>';
                    echo '<td style="width:10%;text-align:right;"></td>';
                    echo '<td style="width:5%;vertical-align:middle;text-align:right;">Rp </td>';
                    echo '<td style="width:10%;vertical-align:middle;text-align:right;border-top: 2px solid black;"><b>'. str_replace(',', '.', number_format($tottagihan)) . '</b></td>';
                    echo '</th>';
                    echo '</tr>';

                    echo '<tr>';
                    echo '<th></th>';
                    echo '<th style="width:30%;vertical-align:middle;">';
                    echo ' ' ;
                    echo '<td style="width:5%;vertical-align:middle;text-align:right;"></td>';
                    echo '<td style="width:10%;text-align:right;"></td>';
                    echo '<td style="width:5%;vertical-align:middle;text-align:right;"></td>';
                    echo '<td style="width:10%;vertical-align:middle;text-align:right;"></td>';
                    echo '</th>';
                    echo '</tr>';

                    echo '<tr>';
                    echo '<th style="width:2%;vertical-align:middle;text-align:center;">V</th>';
                    echo '<th style="width:30%;vertical-align:middle;">';
                    echo 'DANA PENJUALAN TUNAI';
                    echo '<td style="width:5%;vertical-align:middle;text-align:right;"></td>';
                    echo '<td style="width:10%;text-align:right;"></td>';
                    echo '<td style="width:5%;vertical-align:middle;text-align:right;">Rp </td>';
                    echo '<td style="width:10%;vertical-align:middle;text-align:right;">'. str_replace(',', '.', number_format($jualtunai)) . '</td>';
                    echo '</th>';
                    echo '</tr>';

                    echo '<tr>';
                    echo '<th></th>';
                    echo '<th style="width:30%;vertical-align:middle;">';
                    echo 'DANA PELUNASAN TAGIHAN';
                    echo '<td style="width:5%;vertical-align:middle;text-align:right;"></td>';
                    echo '<td style="width:10%;text-align:right;"></td>';
                    echo '<td style="width:5%;vertical-align:middle;text-align:right;">Rp </td>';
                    echo '<td style="width:10%;vertical-align:middle;text-align:right;">'. str_replace(',', '.', number_format($sudah_bayar)) . '</td>';
                    echo '</th>';
                    echo '</tr>';

                    // echo '<tr>';
                    // echo '<th></th>';
                    // echo '<th style="width:30%;vertical-align:middle;">';
                    // echo 'SALDO AKHIR Bulan '  . $bln1;
                    // echo '<td style="width:5%;vertical-align:middle;text-align:right;"></td>';
                    // echo '<td style="width:10%;text-align:right;"></td>';
                    // echo '<td style="width:5%;vertical-align:middle;text-align:right;">Rp </td>';
                    // echo '<td style="width:10%;vertical-align:middle;text-align:right;">'. str_replace(',', '.', number_format($saldo_kemarin)) . '</td>';
                    // echo '</th>';
                    // echo '</tr>';
                    
                    echo '<tr>';
                    echo '<th></th>';
                    echo '<th style="width:30%;vertical-align:middle;">';
                    echo ' ' ;
                    echo '<td style="width:5%;vertical-align:middle;text-align:right;"></td>';
                    echo '<td style="width:10%;text-align:right;"></td>';
                    echo '<td style="width:5%;vertical-align:middle;text-align:right;">Rp </td>';
                    echo '<td style="width:10%;vertical-align:middle;text-align:right;border-top: 2px solid black;color:#538dd5;"><b>'. str_replace(',', '.', number_format($jmlV)) . '</b></td>';
                    echo '</th>';
                    echo '</tr>';

                    echo '<tr>';
                    echo '<th></th>';
                    echo '<th style="width:30%;vertical-align:middle;">';
                    echo '' ;
                    echo '<td style="width:5%;vertical-align:middle;text-align:right;"></td>';
                    echo '<td style="width:10%;text-align:right;"></td>';
                    echo '<td style="width:5%;vertical-align:middle;text-align:right;"></td>';
                    echo '<td style="width:10%;vertical-align:middle;text-align:right;"></td>';
                    echo '</th>';
                    echo '</tr>';

                    echo '<tr>';
                    echo '<th style="width:2%;vertical-align:middle;text-align:center;">VI</th>';
                    echo '<th style="width:30%;vertical-align:middle;">';
                    echo 'PENGELUARAN' ;
                    echo '<td style="width:5%;vertical-align:middle;text-align:right;"></td>';
                    echo '<td style="width:10%;text-align:right;"></td>';
                    echo '<td style="width:5%;vertical-align:middle;text-align:right;"></td>';
                    echo '<td style="width:10%;vertical-align:middle;text-align:right;"></td>';
                    echo '</th>';
                    echo '</tr>';
                    
                    $jumlah_data = count($kat_beban);
                    //foreach ($kat_beban as $b):
                    foreach ($kat_beban as $index => $b):
                        $kat_beb = $b['kat_id'];
                        $kat_nama = $b['kat_nama'];
                        $beban = $ku['beban' . $kat_beb];
                        $tot_beb = $tot_beb + $beban;

                        echo '<tr>';
                        echo '<th style="width:2%;vertical-align:middle;"></th>';
                        echo '<th style="width:30%;vertical-align:middle;">';
                        echo ' ' .$kat_nama;
                        echo '<td style="width:5%;vertical-align:middle;text-align:right;">Rp </td>';
                        echo '<td style="width:10%;text-align:right;">'. str_replace(',', '.', number_format($beban)) . '</td>';
                        if ($index === $jumlah_data - 1) {
                            echo '<td style="width:5%;vertical-align:middle;text-align:right;">Rp </td>';
                            echo '<td style="width:10%;vertical-align:middle;text-align:right;color:#ff0000;"><b>' . str_replace(',', '.', number_format($tot_beb)) . '</b></td>';
                        } else {
                            echo '<td style="width:5%;vertical-align:middle;text-align:right;"></td>';
                            echo '<td style="width:10%;vertical-align:middle;text-align:right;"></td>';
                        }
                        echo '</th>';
                        echo '</tr>';
                    endforeach;
                    
                    $jml_sisa = $jmlV - $tot_beb;
                    echo '<tr>';
                    echo '<th></th>';
                    echo '<th colspan="3" style="text-align:right;">Saldo Kas '.$bln2.'</th>';
                    //echo ' ' ;
                    //echo '<td style="width:5%;vertical-align:middle;text-align:right;"></td>';
                    //echo '<td style="width:10%;text-align:right;"></td>';
                    echo '<td style="width:5%;vertical-align:middle;text-align:right;">Rp </td>';
                    echo '<td style="width:10%;vertical-align:middle;text-align:right;border-top: 2px solid black;"><b>'. str_replace(',', '.', number_format($jml_sisa)) . '</b></td>';
                    echo '</th>';
                    echo '</tr>';

                    echo '<tr>';
                    echo '<th></th>';
                    echo '<th colspan="3" style="text-align:right;">Saldo Akhir '.$bln1.'</th>';
                    //echo ' ' ;
                    //echo '<td style="width:5%;vertical-align:middle;text-align:right;"></td>';
                    //echo '<td style="width:10%;text-align:right;"></td>';
                    echo '<td style="width:5%;vertical-align:middle;text-align:right;">Rp </td>';
                    echo '<td style="width:10%;vertical-align:middle;text-align:right;">'. str_replace(',', '.', number_format($saldo_kemarin)) . '</td>';
                    echo '</th>';
                    echo '</tr>';

                    $jml_saldo = $jml_sisa + $saldo_kemarin;
                    echo '<tr>';
                    echo '<th></th>';
                    echo '<th colspan="3" style="text-align:right;">Jumlah Saldo </th>';
                    //echo ' ' ;
                    //echo '<td style="width:5%;vertical-align:middle;text-align:right;"></td>';
                    //echo '<td style="width:10%;text-align:right;"></td>';
                    echo '<td style="width:5%;vertical-align:middle;text-align:right;">Rp </td>';
                    echo '<td style="width:10%;vertical-align:middle;text-align:right;border-top: 2px solid black;"><b>'. str_replace(',', '.', number_format($jml_saldo)) . '</b></td>';
                    echo '</th>';
                    echo '</tr>';

                    echo '<tr>';
                    echo '<th></th>';
                    echo '<th style="width:30%;vertical-align:middle;">';
                    echo ' ' ;
                    echo '<td style="width:5%;vertical-align:middle;text-align:right;"></td>';
                    echo '<td style="width:10%;text-align:right;"></td>';
                    echo '<td style="width:5%;vertical-align:middle;text-align:right;"></td>';
                    echo '<td style="width:10%;vertical-align:middle;text-align:right;"></td>';
                    echo '</th>';
                    echo '</tr>';

                    echo '<tr>';
                    echo '<th style="width:2%;vertical-align:middle;text-align:center;">VII</th>';
                    echo '<th style="width:30%;vertical-align:middle;">';
                    echo 'TRANSFER' ;
                    echo '<td style="width:5%;vertical-align:middle;text-align:right;"></td>';
                    echo '<td style="width:10%;text-align:right;"></td>';
                    echo '<td style="width:5%;vertical-align:middle;text-align:right;"></td>';
                    echo '<td style="width:10%;vertical-align:middle;text-align:right;"></td>';
                    echo '</th>';
                    echo '</tr>';

                    $jml_transfer = 0;
                    $jml_beb = count($transfer);
                    //foreach ($transfer as $t):
                    foreach ($transfer as $index2 => $t):
                        $jml_trans = $t['beban_jumlah'];
                        $nm_beb = $t['beban_nama'];
                        $jml_transfer = $jml_transfer + $jml_trans;

                    echo '<tr>';
                    echo '<th style="width:2%;vertical-align:middle;"></th>'; // Kosong untuk baris selanjutnya
                    echo '<th style="width:30%;vertical-align:middle;">';
                    echo ' ' . $nm_beb ;
                    echo '<td style="width:5%;vertical-align:middle;text-align:right;">Rp </td>';
                    echo '<td style="width:10%;text-align:right;">'. str_replace(',', '.', number_format($jml_trans)) . '</td>';
                    if ($index2 === $jml_beb - 1) {
                        echo '<td style="width:5%;vertical-align:middle;text-align:right;">Rp </td>';
                        echo '<td style="width:10%;vertical-align:middle;text-align:right;border-bottom: 2px solid black;color:#ff0000;"><b>'. str_replace(',', '.', number_format($jml_transfer)) . '</b></td>';
                    } else {
                        echo '<td style="width:5%;vertical-align:middle;text-align:right;"></td>';
                        echo '<td style="width:10%;vertical-align:middle;text-align:right;"></td>';
                    }
                    echo '</th>';
                    echo '</tr>';
                    endforeach;

                    echo '<tr>';
                    echo '<th></th>';
                    echo '<th style="width:30%;vertical-align:middle;">';
                    echo ' ' ;
                    echo '<td style="width:5%;vertical-align:middle;text-align:right;"></td>';
                    echo '<td style="width:10%;text-align:right;"></td>';
                    echo '<td style="width:5%;vertical-align:middle;text-align:right;"></td>';
                    echo '<td style="width:10%;vertical-align:middle;text-align:right;"></td>';
                    echo '</th>';
                    echo '</tr>';

                    //$selisih = $jml_transfer - $jml_sisa;
                    //$selisih2 = $jml_sisa - $jml_transfer;
                    $selisih2 = ($jml_sisa + $saldo_kemarin) - $jml_transfer;
                    echo '<tr>';
                    echo '<th colspan="4" style="text-align:right;">Saldo Akhir : </th>';
                    //echo '<td style="width:5%;vertical-align:middle;text-align:right;">Rp </td>';
                    //echo '<td style="width:10%;vertical-align:middle;text-align:right;color:#ff0000;"><b>'. str_replace(',', '.', number_format($selisih)) . '</b></td>';
                    echo '<td style="width:5%;vertical-align:middle;text-align:right;">Rp </td>';
                    if ($selisih2 > 0) {   
                        echo '<td style="width:10%;text-align:right;"><b>'. str_replace(',', '.', number_format($selisih2)) . '</b></td>';
                    }else {  //mewarnai huruf jadi merah
                        echo '<td style="width:10%;text-align:right;color:#ff0000;"><b>'. str_replace(',', '.', number_format($selisih2)) . '</b></td>';
                    }
                    echo '</th>';
                    echo '</tr>';

                    ?>
                </table>
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
    <script src="<?php echo base_url().'assets/dist/js/bootstrap-select.min.js'?>"></script>
    <script src="<?php echo base_url().'assets/js/jquery.dataTables.min.js'?>"></script>
    <script src="<?php echo base_url().'assets/js/moment.js'?>"></script>
    <!-- Data Table Fixed Column-->
    <script src="<?php echo base_url().'assets/js/dataTable/jquery-3.6.3.min.js'?>"></script>
    <script src="<?php echo base_url().'assets/js/dataTable/bootstrap-datetimepicker.min.js'?>"></script>
    <script src="<?php echo base_url().'assets/js/dataTable/jquery-ui.min.js'?>"></script>
    <script src="<?php echo base_url().'assets/js/dataTable/jquery-1.11.5.dataTables.min.js'?>"></script>
    <script src="<?php echo base_url().'assets/js/dataTable/dataTables.fixedColumns.min.js'?>"></script>


<script type="text/javascript">
$(document).ready(function () {
    // $('select[name="cari_bln"]').on('change', function() {
    //     var form = document.querySelector('#myForm'); 
    //     form.action = "<?php echo base_url().'admin/keuangan/get_bulan_lap';?>"; 
    //     form.target = '_self';
    //     form.submit(); // Mengirimkan formulir
    //     // var bln = $('#cari_bln').val();
    //     // var periodeVal = "BULAN " + bln.toUpperCase() ;
    //     // $('#periode').css('font-weight', 'bold').text(periodeVal);
    // });

    $(document).on('click', '.btn-tampil', function () {
        var form = document.querySelector('#myForm'); 
        form.action = "<?php echo base_url().'admin/keuangan/get_bulan_lap';?>"; 
        form.target = '_self';
        form.submit(); // Mengirimkan formulir
    });

});

    function varCetak_Laporan() {
        var form = document.querySelector('#myForm'); 
        form.action = "<?php echo base_url().'admin/keuangan/cetak_laporan';?>";
        form.target = '_blank';
        form.submit(); // Mengirimkan formulir
    }
</script>



</body>
</html>
