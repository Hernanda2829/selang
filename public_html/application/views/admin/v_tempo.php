<!DOCTYPE html>
<html lang="en">

<head>
    <?php
     error_reporting(E_ALL);
     ini_set('display_errors', 1); 
	//error_reporting(0);
    $userid=$userid->row_array();
    $data_regid=$userid['reg_id'];
    ?>  
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Produk By <?php echo $userid['co_name'];?>">
    <meta name="author" content="<?php echo $userid['co_name'];?>">

    <title>Penjualan Tempo</title>
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

</style>

</head>

<body>

    <!-- Navigation -->
   <?php 
        $this->load->view('admin/menu');
   ?>

    <!-- Page Content -->
    <div class="container">
        
        <!-- Navigasi Tab -->
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#tab1" style="font-size:12px;"><b>Detail Penjualan Tempo</b></a></li>
            <li><a data-toggle="tab" href="#tab2" style="font-size:12px;"><b>Rekap Penjualan Tempo</b></a></li>
            <!-- Tambahkan lebih banyak tab sesuai kebutuhan -->
        </ul>

        <!-- Isi Tab -->
        <div class="tab-content">
            <!-- Tab 1: Informasi -->
            <div id="tab1" class="tab-pane fade in active">
            <br>
                <div class="row">
                    <div class="col-lg-12">
                        <?php
                        $currentKolek = null;
                        $totalPenjualan = $totalSudahBayar = $totalKurangBayar = $nomorKelompok = 0;

                        foreach ($data->result_array() as $a):
                            $nmcab = $a['reg_name'];
                            $nofak = $a['jual_nofak'];
                            $nmcust = $a['jual_cust_nama'];
                            $tgltrans = $a['jual_tanggal'];
                            $tgltempo = $a['jual_tgl_tempo'];
                            $blntempo = $a['jual_bulan_tempo'];
                            $totjual = $a['jual_total'];
                            $sudbyr = $a['sudah_bayar'];
                            $kurbyr = $a['kurang_bayar'];
                            $telathari = $a['telat_hari'];
                            $kolek = $a['jual_kolek'];
                            $kolket = $a['kol_ket'];
                            $kolwarna = $a['kol_warna'];

                            // Check if the current $kolek is different from the previous one
                            if ($kolek !== $currentKolek) {
                                // Display totals for the previous group
                                if ($currentKolek !== null) {
                                    echo '<tr>';
                                    echo '<td colspan="6" style="text-align:right;"><strong>Total</strong></td>';
                                    //echo '<td style="text-align:right;"><strong>Rp ' . number_format($totalPenjualan) . '</strong></td>';
                                    //echo '<td style="text-align:right;"><strong>Rp ' . number_format($totalSudahBayar) . '</strong></td>';
                                    //echo '<td style="text-align:right;"><strong>Rp ' . number_format($totalKurangBayar) . '</strong></td>';
                                    echo '<td style="text-align:right;"><strong>Rp ' . str_replace(',', '.', number_format($totalPenjualan)) . '</strong></td>';
                                    echo '<td style="text-align:right;"><strong>Rp ' . str_replace(',', '.', number_format($totalSudahBayar)) . '</strong></td>';
                                    echo '<td style="text-align:right;"><strong>Rp ' . str_replace(',', '.', number_format($totalKurangBayar)) . '</strong></td>';
                                    echo '<td colspan="3"></td>';
                                    echo '</tr>';
                                    echo '</tbody>';
                                    echo '</table>';
                                }

                                // Reset total counters for the new group
                                $totalPenjualan = $totalSudahBayar = $totalKurangBayar = 0;

                                // Reset nomorKelompok untuk kelompok baru
                                $nomorKelompok = 1;

                                // Display the header for the new $kolek group
                                //echo '<h3>' . $kolek . '</h3>';
                                echo '<h3> (' . $kolek . ') - ' . $kolket . '</h3>';
                                echo '<table class="table table-bordered nowrap" style="font-size:11px;">';
                                echo '<thead style="color:white;background-color:'. $kolwarna .'">';
                                echo '<tr>';
                                echo '<th style="text-align:center;vertical-align:middle;">No</th>';
                                echo '<th style="text-align:center;vertical-align:middle;">Kantor</th>';
                                echo '<th style="text-align:center;vertical-align:middle;">No Faktur</th>';
                                echo '<th style="text-align:center;vertical-align:middle;">Nama Customer</th>';
                                echo '<th style="text-align:center;vertical-align:middle;">Tgl Transaksi</th>';
                                echo '<th style="text-align:center;vertical-align:middle;">Tgl Jatuh Tempo</th>';
                                echo '<th style="text-align:center;vertical-align:middle;">Total Penjualan</th>';
                                echo '<th style="text-align:center;vertical-align:middle;">Sudah Bayar</th>';
                                echo '<th style="text-align:center;vertical-align:middle;">Kurang Bayar</th>';
                                echo '<th style="max-width:30px!important;text-align:center;vertical-align:middle;">Tempo</th>';
                                echo '<th style="max-width:70px!important;text-align:center;vertical-align:middle;">Tunggakan Hari</th>';
                                //echo '<th style="text-align:center;">Kolektibilitas</th>';
                                echo '<th style="max-width:70px!important;text-align:center;vertical-align:middle;" data-orderable="false">Aksi</th>';
                                echo '</tr>';
                                echo '</thead>';
                                echo '<tbody>';
                            }

                            // Update total counters for the current group
                            $totalPenjualan += $totjual;
                            $totalSudahBayar += $sudbyr;
                            $totalKurangBayar += $kurbyr;

                            // Menampilkan data per baris
                            echo '<tr style="background-color:#f8f9fa;">';
                            echo '<td style="text-align:center;">'.$nomorKelompok.'</td>';
                            echo '<td>'.$nmcab.'</td>';
                            echo '<td>'.$nofak.'</td>';
                            echo '<td>'.$nmcust.'</td>';
                            echo '<td style="text-align:center;">' . date('d/m/Y', strtotime($tgltrans)) . '</td>';
                            echo '<td style="text-align:center;">' . date('d/m/Y', strtotime($tgltempo)) . '</td>';
                            //echo '<td>'.$tgltrans.'</td>';
                            //echo '<td>'.$tgltempo.'</td>';
                            //echo '<td style="text-align:right;">Rp ' . number_format($totjual) . '</td>';
                            //echo '<td style="text-align:right;">Rp ' . number_format($sudbyr) . '</td>';
                            //echo '<td style="text-align:right;">Rp ' . number_format($kurbyr) . '</td>';
                            echo '<td style="text-align:right;">Rp ' . str_replace(',', '.', number_format($totjual)) . '</td>';
                            echo '<td style="text-align:right;">Rp ' . str_replace(',', '.', number_format($sudbyr)) . '</td>';
                            echo '<td style="text-align:right;">Rp ' . str_replace(',', '.', number_format($kurbyr)) . '</td>';
                            echo '<td style="text-align:center;">'.$blntempo.' Bln </td>';
                            echo '<td style="text-align:center;">'.$telathari.'</td>';
                            //echo '<td>'.$kolek.'</td>';
                            echo '<td style="text-align:center;">';
                            echo '<a class="btn btn-xs btn-warning btn-lihatbayar" href="#modalLihatBayar" data-toggle="modal" data-nofak="'.$nofak.'" data-nmcust="'.$nmcust.'" data-tmpbln="'.$blntempo.'" data-tmptgl="'.$tgltempo.'" title="Lihat Data Pembayaran"><span class="fa fa-eye"></span> Bayar</a> ';
                            echo '<a class="btn btn-xs btn-info btn-lihatjual" href="#modalLihatJual" data-toggle="modal" data-nofak="'.$nofak.'" data-nmcust="'.$nmcust.'" title="Lihat Data Penjualan"><span class="fa fa-eye"></span> Jual</a>';
                            echo '</td>';
                            echo '</tr>';

                            // Increment nomorKelompok untuk baris berikutnya
                            $nomorKelompok++;

                            // Update the current $kolek
                            $currentKolek = $kolek;
                        endforeach;

                        // Display totals for the last group
                        echo '<tr>';
                        echo '<td colspan="6" style="text-align:right;"><strong>Total</strong></td>';
                        //echo '<td style="text-align:right;"><strong>Rp ' . number_format($totalPenjualan) . '</strong></td>';
                        //echo '<td style="text-align:right;"><strong>Rp ' . number_format($totalSudahBayar) . '</strong></td>';
                        //echo '<td style="text-align:right;"><strong>Rp ' . number_format($totalKurangBayar) . '</strong></td>';
                        echo '<td style="text-align:right;"><strong>Rp ' . str_replace(',', '.', number_format($totalPenjualan)) . '</strong></td>';
                        echo '<td style="text-align:right;"><strong>Rp ' . str_replace(',', '.', number_format($totalSudahBayar)) . '</strong></td>';
                        echo '<td style="text-align:right;"><strong>Rp ' . str_replace(',', '.', number_format($totalKurangBayar)) . '</strong></td>';
                        echo '<td colspan="3"></td>';
                        echo '</tr>';
                        echo '</tbody>';
                        echo '</table>';
                        ?>
                    </div>
                </div>
            </div>
            <div id="tab2" class="tab-pane fade">
            <br>
                <div class="row">
                    <div class="col-lg-12">
                        <form id="myForm" class="form-horizontal" method="post" action="">
                        <table class="table table-bordered" style="font-size:12px;margin-bottom:10px;">
                            <tr>
                                <th style="width:2%;vertical-align:middle;border-top-color:white;border-right-color:white;border-left-color:white;">Bulan :</th>
                                <td style="width:10%;vertical-align:middle;border-top-color:white;border-right-color:white;">
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
                                <th style="width:2%;vertical-align:middle;border-top-color:white;border-right-color:white;border-left-color:white;">Tahun :</th>
                                <td style="width:5%;vertical-align:middle;border-top-color:white;border-right-color:white;">
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
                                <td style="width:5%;border-top-color:white;border-right-color:white;">
                                    <a class="btn btn-sm btn-info btn-tampil" data-toggle="modal" title="Tampilkan Data"><span class="fa fa-search"></span></a>
                                </td>
                                <td style="width:30%;text-align:right;border-top-color:white;border-right-color:white;">
                                    <button class="btn btn-sm btn-info" title="Cetak Data" onclick="varCetak_Laporan()"><span class="fa fa-print"></span> Cetak Data</button>
                                </td>
                            </tr>
                        </table>
                        </form>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-lg-12">
                        <table class="table table-striped table-bordered" style="font-size:11px;" id="mydata">  
                            <thead>
                                <tr>
                                    <th rowspan="2" style="text-align:center;vertical-align:middle;color:white;background-color:#eb1b28;">No</th>
                                    <th rowspan="2" style="text-align:center;vertical-align:middle;color:white;background-color:#eb1b28;">Cabang</th>
                                    <th colspan="5" style="text-align:center;color:white;background-color:grey;"><span id="thnblnVal"><?= $nm_bln . ' ' . $thn;?></span></th>
                                    <th rowspan="2" style="text-align:center;vertical-align:middle;color:white;background-color:grey;">Total Piutang</th>
                                    <th rowspan="2" style="text-align:center;vertical-align:middle;color:white;background-color:#eb1b28;">Aksi</th>
                                </tr>
                                <tr>
                                    <?php foreach ($datakolek->result_array() as $k): ?>
                                        <th style="text-align: center; color: white; background-color: <?= $k['kol_warna']; ?>">Kolek <?= $k['kol_bln']; ?></th>
                                    <?php endforeach; ?>
                                </tr>
                                <!-- Baris Total -->
                                <tr>
                                    <th colspan="2" style="text-align:right;font-weight:bold;color:white;background-color:#25ce7a;">Grand Total</th>
                                    <?php 
                                        $totalKol = 0;
                                        $totkol1 = $totkol2 = $totkol3 = $totkol4 = $totkol5 = 0;
                                        //foreach ($datatempo->result_array() as $b):
                                        foreach ($datatempo as $d):
                                            $totkol1 += $d['kol1'];
                                            $totkol2 += $d['kol2'];
                                            $totkol3 += $d['kol3'];
                                            $totkol4 += $d['kol4'];
                                            $totkol5 += $d['kol5'];
                                        endforeach;
                                        $totalKol = $totkol1 + $totkol2 + $totkol3 + $totkol4 + $totkol5;
                                    ?>
                                    <th style="text-align:right;font-weight:bold;color:white;background-color:#25ce7a;"><span id="totkol1Val"><?php echo 'Rp ' . str_replace(',', '.', number_format($totkol1));?></span></th>
                                    <th style="text-align:right;font-weight:bold;color:white;background-color:#25ce7a;"><span id="totkol2Val"><?php echo 'Rp ' . str_replace(',', '.', number_format($totkol2));?></span></th>
                                    <th style="text-align:right;font-weight:bold;color:white;background-color:#25ce7a;"><span id="totkol3Val"><?php echo 'Rp ' . str_replace(',', '.', number_format($totkol3));?></span></th>
                                    <th style="text-align:right;font-weight:bold;color:white;background-color:#25ce7a;"><span id="totkol4Val"><?php echo 'Rp ' . str_replace(',', '.', number_format($totkol4));?></span></th>
                                    <th style="text-align:right;font-weight:bold;color:white;background-color:#25ce7a;"><span id="totkol5Val"><?php echo 'Rp ' . str_replace(',', '.', number_format($totkol5));?></span></th>
                                    <th style="text-align:right;font-weight:bold;color:white;background-color:#25ce7a;"><span id="totkolVal"><?php echo 'Rp ' . str_replace(',', '.', number_format($totalKol));?></span></th>
                                    <th style="text-align:center;"><a class="btn btn-xs btn-warning btn-lihat" href="#modalLihat" data-toggle="modal" data-regid="0" data-cabang="Gabungan (Global)" title="Lihat Data"><span class="fa fa-eye"></span> Lihat Data</a></th>
                                </tr>
                                <!-- End Baris Total -->
                            </thead>
                            <tbody>
                                <?php 
                                $no = 0;
                                $total = 0;
                                //foreach ($datatempo->result_array() as $b):
                                foreach ($datatempo as $b):
                                    $no++;
                                    $id = $b['reg_id'];
                                    $cab = $b['reg_name'];
                                    $total=$b['kol1'] + $b['kol2'] + $b['kol3'] + $b['kol4'] + $b['kol5'];
                                ?>
                                    <tr>
                                        <td style="text-align:center;"><?php echo $no;?></td>
                                        <td><?php echo $cab;?></td>
                                        <td style="text-align:right;"><?php echo 'Rp ' . str_replace(',', '.', number_format($b['kol1']));?></td>
                                        <td style="text-align:right;"><?php echo 'Rp ' . str_replace(',', '.', number_format($b['kol2']));?></td>
                                        <td style="text-align:right;"><?php echo 'Rp ' . str_replace(',', '.', number_format($b['kol3']));?></td>
                                        <td style="text-align:right;"><?php echo 'Rp ' . str_replace(',', '.', number_format($b['kol4']));?></td>
                                        <td style="text-align:right;"><?php echo 'Rp ' . str_replace(',', '.', number_format($b['kol5']));?></td>
                                        <td style="text-align:right;background-color:#f2f2f2;"><?php echo 'Rp ' . str_replace(',', '.', number_format($total));?></td>
                                        <td style="text-align:center;">
                                            <a class="btn btn-xs btn-warning btn-lihat" href="#modalLihat" data-toggle="modal" data-regid="<?= $id ;?>" data-cabang="<?= $cab ;?>" title="Lihat Data"><span class="fa fa-eye"></span> Lihat Data</a>
                                        </td>
                                    </tr>
                                <?php endforeach;?>
                            </tbody>
                        </table>
                    </div>
                </div>


            </div>
        </div>

        <!-- ============ MODAL Lihat Pembayaran =============== -->
        <div id="modalLihat" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 class="modal-title" id="myModalLabel">Data Penjualan Tempo Kantor  <span id="nmcabVal"></span></h3>
        </div>
        <form id="myForm2" class="form-horizontal" method="post" action="#">
            <div class="modal-body" style="overflow:scroll;height:450px;">
                <button class="btn btn-sm btn-success" title="Export to Excel" onclick="varCetak_Excel_Lihat()"><span class="fa fa-print"></span> Export Excel</button>
                <input type="hidden" name="txtregid" id="txtregid">
                <input type="hidden" name="txtbln" id="txtbln">
                <input type="hidden" name="txtthn" id="txtthn">
                <input type="hidden" name="txtcab" id="txtcab">
                <table id="tbl_data_jual" class="table table-bordered table-condensed" style="font-size:11px;margin-top:20px;">
                <thead>
                <tr>
                    <th style="text-align:center;vertical-align:middle;">No</th>
                    <th style="text-align:center;vertical-align:middle;">Tgl Transaksi</th>
                    <th style="text-align:center;vertical-align:middle;">No Faktur</th>
                    <th style="text-align:center;vertical-align:middle;">Nama Customer</th>
                    <th style="text-align:center;vertical-align:middle;">Tempo</th>
                    <th style="text-align:center;vertical-align:middle;">J_Tempo</th>
                    <th style="text-align:center;vertical-align:middle;">Total Penjualan</th>
                    <th style="text-align:center;vertical-align:middle;">Sudah Bayar</th>
                    <th style="text-align:center;vertical-align:middle;">Kurang Bayar</th>
                    <th style="max-width:70px!important;text-align:center;vertical-align:middle;">Tunggakan Hari</th>
                    <th style="max-width:40px!important;text-align:center;vertical-align:middle;">Kolek</th>                           
                </tr>
                </thead>
                <tbody></tbody>
                </table>
            </div>
            <div class="modal-footer">   
                <button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
            </div>
        </form>
        </div>
        </div>
        </div>

        <!-- ============ MODAL Lihat Pembayaran =============== -->
        <div id="modalLihatBayar" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 class="modal-title" id="myModalLabel">Informasi Pembayaran Tempo</h3>
        </div>
        <form class="form-horizontal" method="post" action="#">
            <div class="modal-body" style="overflow:scroll;height:450px;">
                <p style="font-size: 11px; margin-bottom: 0;">
                    Nama Customer : <b><span id="nmcustValue" style="color: green;"></span></b>
                </p>
                <p style="font-size: 11px; margin-bottom: 0;">
                    No Faktur : <b><span id="nofakValue"></span></b>
                    <span style="float: right;">Status Bayar : <b><span id="ketValue" style="color: green;"></b></span>
                </p>
                <table id="tbl_info" class="table table-bordered table-condensed" style="font-size:11px;">
                <thead>
                <tr>
                    <th style="text-align:center;vertical-align:middle">Tgl Transaksi</th>
                    <th style="text-align:center;vertical-align:middle">Kewajiban Pembayaran</th>
                    <th style="text-align:center;vertical-align:middle">Jumlah yang sudah diBayar</th>
                    <th style="text-align:center;vertical-align:middle">Kurang Bayar</th>
                </tr>
                </thead>
                <tbody></tbody>
                </table>
                <table style="font-size:11px;">
                <td><strong>Periode Tempo : <span id="tempobln" style="color: green;"></span> Bulan , Tanggal Jatuh Tempo : <span id="tempotgl" style="color: green;"></span></td></strong>
                </table>
                <hr/>
                <p style="font-size: 11px; margin-bottom: 0;">
                    <b>History Pembayaran : </b>
                    <span style="float: right;"><b>Total yang dibayar : <span id="totValue" style="color: green;"></b></span>
                </p>
                <table id="tbl_bayar" class="table table-bordered table-condensed" style="font-size:11px;">
                <thead>
                <tr>
                    <th style="text-align:center;vertical-align:middle">No</th>
                    <th style="text-align:center;vertical-align:middle">Tanggal Bayar</th>
                    <th style="text-align:center;vertical-align:middle">Jumlah yang diBayar</th>
                </tr>
                </thead>
                <tbody></tbody>
                </table> 
            </div>
            <div class="modal-footer">   
                <button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
            </div>
        </form>
        </div>
        </div>
        </div>

        <!-- ============ MODAL Lihat Penjualan =============== -->
        <div id="modalLihatJual" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 class="modal-title" id="myModalLabel">Informasi Penjualan Tempo</h3>
        </div>
        <form class="form-horizontal" method="post" action="#">
            <div class="modal-body" style="overflow:scroll;height:450px;">
                <p style="font-size: 11px; margin-bottom: 0;">
                    Nama Customer : <b><span id="nmcustValue2" style="color: green;"></span></b>
                </p>
                <p style="font-size: 11px; margin-bottom: 0;">
                    No Faktur : <b><span id="nofakValue2"></span></b>
                    <span style="float: right;">Status Bayar : <b><span id="ketValue2" style="color: green;"></b></span>
                </p>
                 <table id="detailTable" class="table table-bordered table-condensed" style="font-size:11px;margin-top:10px;">
                <thead>
                    <tr>
                        <th style="text-align:center;">Kode Barang</th>
                        <th style="text-align:center;">Nama Barang</th>
                        <th style="text-align:center;">Satuan</th>
                        <th style="text-align:center;">Quantity</th>
                        <th style="text-align:center;">Harga Jual</th>
                        <th style="text-align:center;">Diskon</th>
                        <th style="text-align:center;">Sub Total</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>

            </div>
            <div class="modal-footer">   
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
    //$('#mydata').DataTable();
    var table = $('#mydata').DataTable({
        autoWidth: false, 
        paging: true,
        ordering: false
    });
    // var table = $('#tbl_data_jual').DataTable({
    //     autoWidth: false, 
    //     paging: true,
    //     ordering: false
    // });
    
});
</script>


<script type="text/javascript"> 
function varCetak_Laporan() {
    var form = document.querySelector('#myForm'); 
    form.action = "<?php echo base_url().'admin/tempo/cetak_rekap';?>";
    form.target = '_blank';
    form.submit(); // Mengirimkan formulir
}
function varCetak_Excel_Lihat() {
        var form = document.querySelector('#myForm2'); 
        form.action = "<?php echo base_url().'admin/tempo/cetak_lihat_excel';?>";
        //form.target = '_blank';
        form.submit(); // Mengirimkan formulir
    }
</script>

<script type="text/javascript">
    $(document).ready(function() {
        // Fungsi untuk menangani klik pada tombol .btn-tampil
        $(".btn-tampil").on("click", function() {
            $('#mydata tbody').empty();
            // Ambil nilai bulan dan tahun dari input
            var bulan = $("#cari_bln").val();
            var tahun = $("#cari_thn").val();
            var bln = $('#cari_bln option:selected').text();
            var blnthn = bln + ' ' + tahun;
            // Validasi bulan dan tahun
            if (bulan === "" || tahun === "") {
                alert("Pilih bulan dan tahun terlebih dahulu!");
                return;
            }

            // Kirim permintaan AJAX ke controller dengan data bulan dan tahun
            $.ajax({
                
                url: "<?php echo base_url().'admin/tempo/get_tampil_tempo';?>",
                type: "POST",
                data: {
                    cari_bln: bulan,
                    cari_thn: tahun
                },
                dataType: "json",
                success: function(data) {
                    //console.log(data);
                   if (data.length !== 0) {
                            var totkol = totalkol = totkol1 = totkol2 = totkol3 = totkol4 = totkol5 = no = 0;
                            $.each(data, function (index, item) {
                                    var jkol1 = parseFloat(item.kol1);
                                    var jkol2 = parseFloat(item.kol2);
                                    var jkol3 = parseFloat(item.kol3);
                                    var jkol4 = parseFloat(item.kol4);
                                    var jkol5 = parseFloat(item.kol5);
                                    totkol = jkol1 + jkol2 + jkol3 + jkol4 + jkol5;
                                    totkol1 =  totkol1 + jkol1;
                                    totkol2 =  totkol2 + jkol2;
                                    totkol3 =  totkol3 + jkol3;
                                    totkol4 =  totkol4 + jkol4;
                                    totkol5 =  totkol5 + jkol5;
                                    totalkol =  totalkol + totkol;
                                    no++;
                                    var newRow = '<tr>' +
                                        '<td style="font-size:11px;text-align:center;">' + item.reg_id + '</td>' +
                                        '<td style="font-size:11px;">' + item.reg_name + '</td>' +
                                        '<td style="text-align:right;font-size:11px;">Rp ' + jkol1.toLocaleString('id-ID') + '</td>' +
                                        '<td style="text-align:right;font-size:11px;">Rp ' + jkol2.toLocaleString('id-ID') + '</td>' +
                                        '<td style="text-align:right;font-size:11px;">Rp ' + jkol3.toLocaleString('id-ID') + '</td>' +
                                        '<td style="text-align:right;font-size:11px;">Rp ' + jkol4.toLocaleString('id-ID') + '</td>' +
                                        '<td style="text-align:right;font-size:11px;">Rp ' + jkol5.toLocaleString('id-ID') + '</td>' +
                                        '<td style="text-align:right;font-size:11px;background-color:#f2f2f2;">Rp ' + totkol.toLocaleString('id-ID') + '</td>' +
                                        '<td style="text-align:right;font-size:11px;text-align:center;">' +
                                        '<a class="btn btn-xs btn-warning btn-lihat" href="#modalLihat" data-toggle="modal" data-regid="' + item.reg_id + '" data-cabang="' + item.reg_name + '" title="Lihat Data"><span class="fa fa-eye"></span> Lihat Data</a> ' +
                                        '</td>' +
                                        '</tr>';
                                    $('#mydata tbody').append(newRow);
                            });
                              
                            // var totRow = '<tr style="background-color:#777;">' +
                            //     '<td colspan="2" style="text-align:right;font-size:11px;color:white;"><b>Grand Total :</b></td>' +
                            //     '<td style="text-align:right;font-size:11px;color:white;"><b> Rp ' + totkol1.toLocaleString('id-ID') + '</b></td>' +
                            //     '<td style="text-align:right;font-size:11px;color:white;"><b> Rp ' + totkol2.toLocaleString('id-ID') + '</b></td>' +
                            //     '<td style="text-align:right;font-size:11px;color:white;"><b> Rp ' + totkol3.toLocaleString('id-ID') + '</b></td>' +
                            //     '<td style="text-align:right;font-size:11px;color:white;"><b> Rp ' + totkol4.toLocaleString('id-ID') + '</b></td>' +
                            //     '<td style="text-align:right;font-size:11px;color:white;"><b> Rp  ' + totkol5.toLocaleString('id-ID') + '</b></td>' +
                            //     '<td style="text-align:right;font-size:11px;color:white;"><b> Rp ' + totalkol.toLocaleString('id-ID') + '</b></td>' +
                            //     '</tr>';
                            // $('#mydata tbody').append(totRow);
                            $('#thnblnVal').text(blnthn);
                            $('#totkol1Val').text('Rp ' + totkol1.toLocaleString('id-ID'));
                            $('#totkol2Val').text('Rp ' + totkol2.toLocaleString('id-ID'));
                            $('#totkol3Val').text('Rp ' + totkol3.toLocaleString('id-ID'));
                            $('#totkol4Val').text('Rp ' + totkol4.toLocaleString('id-ID'));
                            $('#totkol5Val').text('Rp ' + totkol5.toLocaleString('id-ID'));
                            $('#totkolVal').text('Rp ' + totalkol.toLocaleString('id-ID'));
                            
                
                        // if (!$.fn.dataTable.isDataTable('#mydata')) {
                        //         $('#mydata').DataTable({
                        //         autoWidth: false, 
                        //             paging: true,
                        //             ordering: false
                        //         });
                        // }else {
                        //     $('#mydata').DataTable();
                        // }
                        
                    } else {
                            console.log("No data found.");
                    }
                },
                error: function(xhr, status, error) {
                    alert("Error: " + xhr.responseText);
                }
            });
        });
    });
</script>
<script type="text/javascript">
// Menangani klik tombol pembayaran
    $(document).on('click', '.btn-lihat', function() {
        $('#tbl_data_jual tbody').empty();
        var regid = $(this).data('regid');
        var cabang = $(this).data('cabang');
        var bulan = $("#cari_bln").val();
        var tahun = $("#cari_thn").val();
        $('#nmcabVal').text(cabang);
        $("#txtregid").val(regid);
        $("#txtbln").val(bulan);
        $("#txtthn").val(tahun);
        $("#txtcab").val(cabang);

        $.ajax({
            type: "POST",
            url: "<?php echo base_url().'admin/tempo/tampil_tempo_cabang';?>",
            data: { regid: regid,
                    cari_bln: bulan,
                    cari_thn: tahun
            },
            dataType: 'json',
            success: function(data) {
                //console.log(regid);
                if (data.length !== 0) {
                    var no = 0;
                    tot_jtot = tot_sudbyr = totkurbyr = 0;
                    $.each(data, function (index, item) {
                        no++;
                        var jtot = parseFloat(item.jual_total);
                        var sudbyr = parseFloat(item.sudah_bayar);
                        var kurbyr = parseFloat(item.kurang_bayar);
                        tot_jtot += jtot;
                        tot_sudbyr += sudbyr;
                        totkurbyr += kurbyr;
                        var newRow = '<tr>' +
                            '<td style="text-align:center;font-size:11px;">' + no + '</td>' +
                            '<td style="text-align:center;font-size:11px;">' + item.jual_tanggal + '</td>' +
                            '<td style="font-size:11px;">' + item.jual_nofak + '</td>' +
                            '<td style="font-size:11px;">' + item.jual_cust_nama + '</td>' +
                            '<td style="text-align:center;font-size:11px;">' + item.jual_bulan_tempo + ' Bln</td>' +
                            '<td style="text-align:center;font-size:11px;">' + item.jual_tgl_tempo + '</td>' +
                            '<td style="text-align:right;font-size:11px;">' + jtot.toLocaleString('id-ID') + '</td>' +
                            '<td style="text-align:right;font-size:11px;">' + sudbyr.toLocaleString('id-ID') + '</td>' +
                            '<td style="text-align:right;font-size:11px;">' + kurbyr.toLocaleString('id-ID') + '</td>' +
                            '<td style="text-align:center;font-size:11px;">' + item.telat_hari + '</td>' +
                            '<td style="text-align:center;font-size:11px;">' + item.jual_kolek + '</td>' +
                            '</tr>';
                        $('#tbl_data_jual tbody').append(newRow);
                    }); 
                    var totRow = '<tr style="background-color:#777;">' +
                                '<td colspan="6" style="text-align:right;font-size:11px;color:white;padding-right:5px;"><b> Total : </b></td>' +
                                '<td style="text-align:right;font-size:11px;color:white;"><b> Rp ' + tot_jtot.toLocaleString('id-ID') + '</b></td>' +
                                '<td style="text-align:right;font-size:11px;color:white;"><b> Rp ' + tot_sudbyr.toLocaleString('id-ID') + '</b></td>' +
                                '<td style="text-align:right;font-size:11px;color:white;"><b> Rp ' + totkurbyr.toLocaleString('id-ID') + '</b></td>' +
                                '</tr>';
                            $('#tbl_data_jual tbody').append(totRow);   

                    
                        
                    
                    
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

<script type="text/javascript">
$(document).ready(function() {
    var tblBayar; // Variabel untuk tabel DataTable
    var tblInfo;
    var isDataTableInitialized = false; // Variabel untuk melacak apakah DataTable sudah diinisialisasi
    // Inisialisasi DataTable tanpa data awal
    tblBayar = $('#tbl_bayar').DataTable({
        ordering: false,
        dom: "", // Hapus semua elemen wrapper
        autoWidth: false,
        scrollY: 'none',
        columns: [
            { data: null,
                className: 'text-center',
                render: function(data, type, row, meta) {
                    return meta.row + 1; // Menambahkan nomor urut
                }
            },
            { data: 'tgl_trans' },
            { data: 'bayar_jumlah',
                className: 'text-right',
                render: function(data) {
                    var totalFormatted = Math.ceil(data).toLocaleString('id-ID', { style: 'currency', currency: 'IDR' }).replace(/,00$/, '');
                    return totalFormatted;
                }
            }
        ]
    });

    // Inisialisasi DataTable tanpa data awal
    tblInfo = $('#tbl_info').DataTable({
        ordering: false,
        dom: "", // Hapus semua elemen wrapper
        autoWidth: false,
        scrollY: 'none',
        columns: [
            { data: 'bayar_tgl' },
            { data: 'bayar_total',
                className: 'text-right',
                render: function(data) {
                    var totalFormatted = Math.ceil(data).toLocaleString('id-ID', { style: 'currency', currency: 'IDR' }).replace(/,00$/, '');
                    return totalFormatted;
                }
            },
            { data: 'tot_bayar',
                className: 'text-right',
                render: function(data) {
                    var totalFormatted = Math.ceil(data).toLocaleString('id-ID', { style: 'currency', currency: 'IDR' }).replace(/,00$/, '');
                    return totalFormatted;
                }
            },
            { data: 'kur_bayar',
                className: 'text-right',
                render: function(data) {
                    var totalFormatted = Math.ceil(data).toLocaleString('id-ID', { style: 'currency', currency: 'IDR' }).replace(/,00$/, '');
                    return totalFormatted;
                }
            }
        ]
    });

    // Menangani klik tombol pembayaran
    $(document).on('click', '.btn-lihatbayar', function() {
        var nofak = $(this).data('nofak');
        var nmcust = $(this).data('nmcust');
        var tmpbln = $(this).data('tmpbln');
        var tmptgl = $(this).data('tmptgl');
        $('#nofakValue').text(nofak);
        $('#nmcustValue').text(nmcust);
        $('#tempobln').text(tmpbln);
        $('#tempotgl').text(tmptgl);

        $.ajax({
            url: "<?php echo base_url().'admin/tempo/get_jual_bayar';?>",
            data: { nofak: nofak },
            dataType: 'json',
            success: function(data) {
                //console.log(data);
                tblBayar.clear().draw();
                for (var i = 0; i < data.queryB.length; i++) {
                    tblBayar.row.add(data.queryB[i]).draw();
                }
                tblInfo.clear().draw();
                tblInfo.row.add(data.queryA).draw();
                var ketBayar = data.queryA.bayar_ket;
                var totBayar = parseFloat(data.queryA.tot_bayar);
                totBayar = Math.ceil(totBayar);
                $('#ketValue').text(ketBayar);
                $('#totValue').text(Number(totBayar).toLocaleString('id-ID', { style: 'currency', currency: 'IDR' }).replace(/,00$/, ''));
            },
            error: function(xhr, status, error) {
                //console.log(error);
            }
        });
    });
});

</script>


<script type="text/javascript">
    $(document).on('click', '.btn-lihatjual', function() {
        var nofak = $(this).data('nofak');
        var nmcust = $(this).data('nmcust');
        //Clear existing table rows
        $('#detailTable tbody').empty();
        $('#nofakValue2').text(nofak);
        $('#nmcustValue2').text(nmcust);

        $.ajax({
            type: "POST",
            url: "<?php echo base_url('admin/tempo/get_detail_jual'); ?>",
            data: { nofak: nofak },
            dataType: 'json',
            success: function (data) {
                if (data.length === 0) {
                        //console.log("No data found.");
                } else {
                    var itemA = data[0];
                    $('#ketValue2').text(itemA.jual_bayar_status);
                    var grandTotal = 0;
                    //Loop through the data and append rows to the table
                    $.each(data, function (index, item) {
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
                        grandTotal += total;
                        $('#detailTable tbody').append(newRow);    
                    });
                    // Tambahkan baris "Total" setelah loop dan tampilkan grand total
                    var totalRow = '<tr>' +
                        '<td colspan="6" style="text-align:right; font-weight:bold;">Total</td>' + // Kolom kosong sebelum kolom "Total"
                        '<td style="text-align:right; font-weight:bold;">' + grandTotal.toLocaleString('id-ID') + '</td>' +
                        '</tr>';
                    $('#detailTable tbody').append(totalRow);
    
                } 
            },
            error: function(xhr, status, error) {
                //console.log(error);
            }    
        });
    });
</script>



</body>
</html>
