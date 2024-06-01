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

    <title>Data Piutang</title>
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
    
    .total-grup-row {
        visibility: collapse;
    }

    /* tr.bariswarna {
        visibility: collapse;
    } */

    .tbl-total.table-bordered {
        border: 0 !important;
    }

    .tbl-total thead tr th {
        border-bottom: none !important;
    }
 
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
        <div class="row">
            <div class="col-lg-12">
                <h3 style="margin: 0;">Data Piutang / Penjualan Tempo <small><?php echo $userid['reg_code'];?>  <?php echo $userid['reg_name'];?></small></h3>
            </div>
        </div>
        <hr/>
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#tabDetail" style="font-size:12px;"><b>Detail Piutang</b></a></li>
                <li><a data-toggle="tab" href="#tabRekap" style="font-size:12px;"><b>Rekap Piutang (Blok Warna)</b></a></li>
                <li><a data-toggle="tab" href="#tabBayar" style="font-size:12px;"><b>Pelunasan/Pembayaran</b></a></li>
                <!-- Tambahkan lebih banyak tab sesuai kebutuhan -->
            </ul>                    
                <!-- Isi Tab -->
                <div class="tab-content">
                    <!-- Tab 1: Informasi -->
                    <div id="tabDetail" class="tab-pane fade in active">
                        <br>
                        <div class="row" id="cetak_piutang">
                            <div class="col-lg-12">
                                <form class="form-horizontal" method="post" action="" target="_blank">
                                <button class="btn btn-sm btn-info" title="Cetak Data" onclick="varCetak_Piutang()"><span class="fa fa-print"></span> Cetak Data</button>
                                </form>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-lg-12">
                                <?php
                                $groupedData = []; // Array untuk menyimpan data per grup

                                foreach ($data as $a):
                                    $cust = $a['jual_cust_nama'];
                                    $tot = $a['jual_total'];

                                    if (!isset($groupedData[$cust])) {
                                        $groupedData[$cust] = [
                                            'total' => 0,
                                            'sudah_bayar' => 0,
                                            'kurang_bayar' => 0,
                                            'data' => [],
                                        ];
                                    }

                                    $groupedData[$cust]['total'] += $tot;
                                    $groupedData[$cust]['sudah_bayar'] += $a['sudah_bayar'];
                                    $groupedData[$cust]['kurang_bayar'] += $a['kurang_bayar'];
                                    $groupedData[$cust]['data'][] = $a;
                                endforeach;
                                ?>

                                <?php
                                $totalAll = [
                                    'total' => 0,
                                    'sudah_bayar' => 0,
                                    'kurang_bayar' => 0,
                                ];
                                $totalAllRecord = 0;
                                ?>

                                <?php foreach ($groupedData as $custName => $group): ?>
                                    <!-- Baris judul grup -->
                                    <div style="margin-bottom: 20px;">
                                        <b><?php echo $custName; ?></b>
                                        <table class="table table-striped table-bordered" style="font-size:11px;">
                                            <thead>
                                                <tr>
                                                    <th style="text-align:center;vertical-align:middle;">No</th>
                                                    <th style="text-align:center;vertical-align:middle;">Tgl Transaksi</th>
                                                    <th style="text-align:center;vertical-align:middle;">No Faktur</th>
                                                    <th style="text-align:center;vertical-align:middle;">No Nota</th>
                                                    <th style="text-align:center;vertical-align:middle;">Tempo</th>
                                                    <th style="text-align:center;vertical-align:middle;">J_Tempo</th>
                                                    <th style="text-align:center;vertical-align:middle;">Total Penjualan</th>
                                                    <th style="text-align:center;vertical-align:middle;">Sudah Bayar</th>
                                                    <th style="text-align:center;vertical-align:middle;">Kurang Bayar</th>
                                                    <th style="max-width:70px!important;text-align:center;vertical-align:middle;">Tunggakan Hari</th>
                                                    <th style="text-align:center">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $no = 0; // Inisialisasi nomor urut ?>
                                                <?php foreach ($group['data'] as $a): ?>
                                                    <tr>
                                                        <td style="text-align:center;"><?php echo ++$no; ?></td>
                                                        <td style="text-align:center;"><?php echo date('d/m/Y', strtotime($a['jual_tanggal']));?></td>
                                                        <td><?php echo $a['jual_nofak'];?></td>
                                                        <td style="text-align:center;"><?php echo $a['jual_nota'];?></td>
                                                        <td style="text-align:center;"><?php echo $a['jual_bulan_tempo'];?> Bln</td>
                                                        <td style="text-align:center;"><?php echo date('d/m/Y', strtotime($a['jual_tgl_tempo']));?></td>
                                                        <td style="text-align:right;"><?php echo 'Rp ' . number_format($a['jual_total'], 0, ',', '.'); ?></td>
                                                        <td style="text-align:right;"><?php echo 'Rp ' . number_format($a['sudah_bayar'], 0, ',', '.'); ?></td>
                                                        <td style="text-align:right;"><?php echo 'Rp ' . number_format($a['kurang_bayar'], 0, ',', '.'); ?></td>
                                                        <td style="text-align:center;"><?php echo $a['telat_hari']; ?></td>
                                                        <td style="text-align:center;">
                                                            <?php
                                                                if ($a['jual_bayar']=="Tempo") {
                                                                    if ($a['jual_bayar_status']=="Lunas") {
                                                                        echo '<a class="btn btn-xs btn-info btn-bayar" href="#modalBayar" data-toggle="modal" data-nofak="'.$a['jual_nofak'].'" data-nmcust="'.$a['jual_cust_nama'].'" title="Lihat Data Pembayaran Status Lunas"> <span class="fa fa-book"></span> Lihat Data</a>';
                                                                    } else {
                                                                        echo '<a class="btn btn-xs btn-warning btn-bayar" href="#modalBayar" data-toggle="modal" data-nofak="'.$a['jual_nofak'].'" data-nmcust="'.$a['jual_cust_nama'].'" title="Input Proses Pembayaran"> <span class="fa fa-book"></span> Pembayaran</a>';
                                                                    }
                                                                }
                                                            ?>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>

                                                <!-- Baris total grup -->
                                                <tr style="background-color:#777;">
                                                    <td colspan="6" style="text-align:right;font-size:11px;color:white;"><b>Total :</b></td>
                                                    <td style="text-align:right;font-size:11px;color:white;"><b><?php echo 'Rp ' . number_format($group['total'], 0, ',', '.'); ?></b></td>
                                                    <td style="text-align:right;font-size:11px;color:white;"><b><?php echo 'Rp ' . number_format($group['sudah_bayar'], 0, ',', '.'); ?></b></td>
                                                    <td style="text-align:right;font-size:11px;color:white;"><b><?php echo 'Rp ' . number_format($group['kurang_bayar'], 0, ',', '.'); ?></b></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <?php
                                    $totalAll['total'] += $group['total'];
                                    $totalAll['sudah_bayar'] += $group['sudah_bayar'];
                                    $totalAll['kurang_bayar'] += $group['kurang_bayar'];
                                    $totalAllRecord += $no;
                                    ?>
                                <?php endforeach; ?>

                                <!-- Baris total seluruh grup -->
                                <div style="margin-top:-10px;">    
                                    <table class="table table-striped table-bordered nowrap tbl-total" style="font-size:11px;border-color:white;">
                                        <thead>
                                            <tr class="total-grup-row">
                                                <th style="text-align:center;vertical-align:middle;">No</th>
                                                <th style="text-align:center;vertical-align:middle;">Tgl Transaksi</th>
                                                <th style="text-align:center;vertical-align:middle;">No Faktur</th>
                                                <th style="text-align:center;vertical-align:middle;">No Nota</th>
                                                <th style="text-align:center;vertical-align:middle;">Tempo</th>
                                                <th style="text-align:center;vertical-align:middle;">J_Tempo</th>
                                                <th style="text-align:center;vertical-align:middle;">Total Penjualan</th>
                                                <th style="text-align:center;vertical-align:middle;">Sudah Bayar</th>
                                                <th style="text-align:center;vertical-align:middle;">Kurang Bayar</th>
                                                <th style="max-width:70px!important;text-align:center;vertical-align:middle;">Tunggakan Hari</th>
                                                <th style="text-align:center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                          
                                                <tr class="total-grup-row">
                                                    <td style="text-align:center;"><?php echo ++$no; ?></td>
                                                    <td><?php echo date('d/m/Y', strtotime($a['jual_tanggal']));?></td>
                                                    <td><?php echo $a['jual_nofak'];?></td>
                                                    <td><?php echo $a['jual_nota'];?></td>
                                                    <td style="text-align:center;"><?php echo $a['jual_bulan_tempo'];?> Bln</td>
                                                    <td style="text-align:center;"><?php echo date('d/m/Y', strtotime($a['jual_tgl_tempo']));?></td>
                                                    <td style="text-align:right;"><?php echo 'Rp ' . number_format($a['jual_total'], 0, ',', '.'); ?></td>
                                                    <td style="text-align:right;"><?php echo 'Rp ' . number_format($a['sudah_bayar'], 0, ',', '.'); ?></td>
                                                    <td style="text-align:right;"><?php echo 'Rp ' . number_format($a['kurang_bayar'], 0, ',', '.'); ?></td>
                                                    <td style="text-align:center;border-color:white;"><?php echo $a['telat_hari']; ?></td>
                                                    <td style="text-align:center;border-color:white;">
                                                        <a class="btn btn-xs btn-warning btn-bayar" href="#modalBayar" data-toggle="modal" data-nofak="'.$a['jual_nofak'].'" data-nmcust="'.$a['jual_cust_nama'].'" title="Input Proses Pembayaran"> <span class="fa fa-book"></span> Pembayaran</a>
                                                    </td>
                                                </tr>
                                            <!-- Baris total seluruh grup -->
                                            <tr style="background-color:#333; color:white;">
                                                <td colspan="2" style="font-size:11px;"><b>Total Record : <?php echo $totalAllRecord; ?></b></td>
                                                <td colspan="4" style="text-align:right;font-size:11px;"><b>Total Seluruh Grup :</b></td>
                                                <td style="text-align:right;font-size:11px;"><b><?php echo 'Rp ' . number_format($totalAll['total'], 0, ',', '.'); ?></b></td>
                                                <td style="text-align:right;font-size:11px;"><b><?php echo 'Rp ' . number_format($totalAll['sudah_bayar'], 0, ',', '.'); ?></b></td>
                                                <td style="text-align:right;font-size:11px;"><b><?php echo 'Rp ' . number_format($totalAll['kurang_bayar'], 0, ',', '.'); ?></b></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div> 
                    
                    <div id="tabRekap" class="tab-pane fade">
                    <br>                        
                        <div class="row" id="cetak_rekap">
                            <div class="col-lg-12 text-right">
                                <form class="form-horizontal" method="post" action="" target="_blank">
                                <button class="btn btn-sm btn-info" title="Cetak Data" onclick="varCetak_Rekap()"><span class="fa fa-print"></span> Cetak Data</button>
                                </form>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <?php
                                $currentKolek = null;
                                $totalPenjualan = $totalSudahBayar = $totalKurangBayar = $nomorKelompok = 0;
                                $totalSemuaPenjualan = $totalSemuaSudahBayar = $totalSemuaKurangBayar = 0;
                                $totRec = 0;
                                foreach ($rekap->result_array() as $a):
                                    $totRec++;
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
                                    $stopsales = $a['stop_sales'];
                                    
                                    // Check if the current $kolek is different from the previous one
                                    if ($kolek !== $currentKolek) {
                                        // Display totals for the previous group
                                        if ($currentKolek !== null) {
                                            echo '<tr>';
                                            echo '<td colspan="5" style="text-align:right;"><strong>Total</strong></td>';
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
                                        if ($stopsales=="Yes") {
                                            $stopjual="Tidak Boleh Hutang"; 
                                            echo '<h3> (' . $kolek . ') - ' . $kolket . '<small> - (' . $stopjual . ')</small></h3>'; 
                                        } else {
                                            $stopjual="";
                                            echo '<h3> (' . $kolek . ') - ' . $kolket . '</h3>';  
                                        }
                                        
                                        echo '<table class="table table-bordered nowrap" style="font-size:11px;" id="mydata">';
                                        echo '<thead style="color:white;background-color:'. $kolwarna .'">';
                                        echo '<tr>';
                                        echo '<th style="text-align:center;">No</th>';
                                        echo '<th style="text-align:center;">No Faktur</th>';
                                        echo '<th style="text-align:center;">Nama Customer</th>';
                                        echo '<th style="text-align:center;">Tgl Transaksi</th>';
                                        echo '<th style="text-align:center;">Tgl Jatuh Tempo</th>';
                                        echo '<th style="text-align:center;">Total Penjualan</th>';
                                        echo '<th style="text-align:center;">Sudah Bayar</th>';
                                        echo '<th style="text-align:center;">Kurang Bayar</th>';
                                        echo '<th style="text-align:center;">Tempo</th>';
                                        echo '<th style="text-align:center;">Tunggakan Hari</th>';
                                        //echo '<th style="text-align:center;">Kolektibilitas</th>';
                                        echo '<th style="max-width:100px!important;text-align:center;" data-orderable="false">Aksi</th>';
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
                                    echo '<a class="btn btn-xs btn-warning btn-lihatbayar" href="#modalLihatBayar" data-toggle="modal" data-nofak="'.$nofak.'" data-nmcust="'.$nmcust.'" data-tmpbln="'.$blntempo.'" data-tmptgl="'.$tgltempo.'" title="Lihat Data Pembayaran"><span class="fa fa-eye"></span> Lihat Bayar</a> ';
                                    echo '<a class="btn btn-xs btn-info btn-lihatjual" href="#modalLihatJual" data-toggle="modal" data-nofak="'.$nofak.'" data-nmcust="'.$nmcust.'" title="Lihat Data Penjualan"><span class="fa fa-eye"></span> Lihat Jual</a>';
                                    echo '</td>';
                                    echo '</tr>';

                                    // Increment nomorKelompok untuk baris berikutnya
                                    $nomorKelompok++;

                                    // Update the current $kolek
                                    $currentKolek = $kolek;
                                    //--------------------------
                                    $totalSemuaPenjualan += $totjual;
                                    $totalSemuaSudahBayar += $sudbyr;
                                    $totalSemuaKurangBayar += $kurbyr;

                                endforeach;

                                // Display totals for the last group
                                echo '<tr>';
                                echo '<td colspan="5" style="text-align:right;"><strong>Total</strong></td>';
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
                                <!-- Baris total seluruh grup -->        
                                <table class="table table-bordered nowrap tbl-total" style="font-size:11px;" id="mydata">
                                    <thead style="color:white;background-color:#777;border-color:white;">
                                    <tr class="total-grup-row">
                                        <th style="border-color:white;color:white;background-color:white;text-align:center;">No</th>
                                        <th style="border-color:white;color:white;background-color:white;text-align:center;">No Faktur</th>
                                        <th style="border-color:white;color:white;background-color:white;text-align:center;">Nama Customer</th>
                                        <th style="border-color:white;color:white;background-color:white;text-align:center;">Tgl Transaksi</th>
                                        <th style="border-color:white;color:white;background-color:white;text-align:center;">Tgl Jatuh Tempo</th>
                                        <th style="border-color:white;text-align:center;">Total Penjualan</th>
                                        <th style="border-color:white;text-align:center;">Sudah Bayar</th>
                                        <th style="border-color:white;text-align:center;">Kurang Bayar</th>
                                        <th style="border-color:white;color:white;background-color:white;text-align:center;">Tempo</th>
                                        <th style="border-color:white;color:white;background-color:white;text-align:center;">Tunggakan Hari</th>       
                                        <th style="border-color:white;color:white;background-color:white;max-width:100px!important;text-align:center;" data-orderable="false">Aksi</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr class="total-grup-row">
                                        <td style="text-align:center;"><?= $nomorKelompok ;?></td>
                                        <td><?= $nofak ;?></td>
                                        <td><?= $nmcust ;?></td>
                                        <td style="text-align:center;"><?= date('d/m/Y', strtotime($tgltrans)) ;?></td>
                                        <td style="text-align:center;"><?= date('d/m/Y', strtotime($tgltempo)) ;?></td>
                                        <td style="text-align:right;">Rp <?= str_replace(',', '.', number_format($totjual)) ;?></td>
                                        <td style="text-align:right;">Rp <?= str_replace(',', '.', number_format($sudbyr)) ;?></td>
                                        <td style="text-align:right;">Rp <?= str_replace(',', '.', number_format($kurbyr)) ;?></td>
                                        <td style="border-color:white;text-align:center;"><?= $blntempo ;?> Bln </td>
                                        <td style="border-color:white;text-align:center;"><?= $telathari ;?></td>
                                        <td style="border-color:white;text-align:center;">
                                            <a class="btn btn-xs btn-warning btn-lihatbayar" href="#modalLihatBayar" data-toggle="modal" data-nofak="<?= $nofak ;?>" data-nmcust="<?= $nmcust ;?>" data-tmpbln="<?= $blntempo ;?>" data-tmptgl="<?= $tgltempo ;?>" title="Lihat Data Pembayaran"><span class="fa fa-eye"></span> Lihat Bayar</a> 
                                            <a class="btn btn-xs btn-info btn-lihatjual" href="#modalLihatJual" data-toggle="modal" data-nofak="<?= $nofak ;?>" data-nmcust="<?= $nmcust ;?>" title="Lihat Data Penjualan"><span class="fa fa-eye"></span> Lihat Jual</a>
                                        </td>
                                    </tr>
                                     <!-- Baris total seluruh grup -->
                                    <tr style="background-color:#777; color:white;">
                                        <td colspan="2" style="font-size:11px;"><b>Total Record : <?= $totRec ;?></b></td>
                                        <td colspan="3" style="text-align:right;font-size:11px;"><b>Total Seluruh Grup :</b></td>
                                        <td style="text-align:right;font-size:11px;"><b><?php echo 'Rp ' . str_replace(',', '.', number_format($totalSemuaPenjualan)) ; ?></b></td>
                                        <td style="text-align:right;font-size:11px;"><b><?php echo 'Rp ' . str_replace(',', '.', number_format($totalSemuaSudahBayar)) ; ?></b></td>
                                        <td style="text-align:right;font-size:11px;"><b><?php echo 'Rp ' . str_replace(',', '.', number_format($totalSemuaKurangBayar)) ; ?></b></td>
                                    </tr>
                                    </tbody>
                                </table>
                        
                            </div>
                        </div>                   
                    </div>

                    <div id="tabBayar" class="tab-pane fade">
                    <br>                        
                        <div class="row" id="cetak_bayar">
                            <div class="col-lg-7">
                                <form class="form-horizontal" method="post" action="" target="_blank">
                                <table style="font-size:12px;margin-bottom:10px;">
                                    <input type="hidden" name="regid" id="regid" value="<?php echo $data_regid; ?>">
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
                                        <td style="width:5%;vertical-align:middle;">
                                            <button class="btn btn-sm btn-info" title="Cetak Data" onclick="varCetak_Pembayaran()"><span class="fa fa-print"></span> Cetak Data</button>
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
                                            <th style="text-align:center">Tanggal Transaksi</th>    
                                            <th style="text-align:center">Nama Customer</th>
                                            <th style="text-align:center">No Faktur</th>
                                            <th style="text-align:center">No Nota</th>
                                            <th style="text-align:center">Status</th>
                                            <th style="text-align:center">Jumlah Bayar</th>
                                            <th style="text-align:center">Aksi</th>
                                            </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $no=0;
                                        $total=0;
                                        foreach ($pembayaran as $a):
                                            $no++;
                                            $tgl_byr = $a['bayar_tgl_trans'];
                                            $nmcust_byr = $a['jual_cust_nama'];
                                            $nofak_byr = $a['bayar_nofak'];
                                            $nota_byr = $a['jual_nota'];
                                            $status_byr = $a['bayar_ket'];
                                            $jml_byr = $a['bayar_jumlah'];
                                            $tgltempo_byr = $a['jual_tgl_tempo'];
                                            $blntempo_byr = $a['jual_bulan_tempo'];
                                            $total=$total+$jml_byr;
                                           
                                        ?>
                                        <tr>
                                            <td style="text-align:center;"><?php echo $no;?></td>
                                            <td><?php echo $tgl_byr;?></td>
                                            <td><?php echo $nmcust_byr;?></td>
                                            <td><?php echo $nofak_byr;?></td>
                                            <td><?php echo $nota_byr;?></td>
                                            <td style="text-align:center;"><?php echo $status_byr;?></td>
                                            <td style="text-align:right;"><?php echo 'Rp ' . str_replace(',', '.', number_format($jml_byr)); ?></td>
                                            <td style="text-align:center;">
                                                <a class="btn btn-xs btn-info btn-lihatbayar" href="#modalLihatBayar" data-toggle="modal" data-nofak="<?= $nofak_byr ;?>" data-nmcust="<?= $nmcust_byr ;?>" data-tmpbln="<?= $blntempo_byr ;?>" data-tmptgl="<?= $tgltempo_byr ;?>" title="Lihat Data Pembayaran"><span class="fa fa-eye"></span> Lihat Bayar</a>
                                            </td>
                                        </tr>
                                    <?php endforeach;?>
                                    <tr style="background-color:#777;">
                                        <td colspan="6" style="text-align:right;font-size:11px;color:white;"><b>Total :</b></td>
                                        <td style="text-align:right;font-size:11px;color:white;"><b><?php echo 'Rp ' . str_replace(',', '.', number_format($total)); ?></b></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
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

        <!-- ============ MODAL Bayar =============== -->
        <div id="modalBayar" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 class="modal-title" id="myModalLabel">Pembayaran Tempo - <?php echo $userid['reg_code'];?>  <?php echo $userid['reg_name'];?></h3>
        </div>
        <form class="form-horizontal" method="post" action="<?php echo base_url().'admin/piutang/tambah_bayar'?>">
            <div class="modal-body" style="overflow:scroll;height:400px;">
                <p style="font-size: 11px; margin-bottom: 0;">
                    Nama Customer : <b><span id="nmcustValue3" style="color: green;"></span></b>
                </p>
                <p style="font-size: 11px; margin-bottom: 0;">
                    No Faktur : <b><span id="nofakValue3"></span></b>
                    <span style="float: right;">Status Bayar : <b><span id="ketValue3" style="color: green;"></b></span>
                </p>
                <table id="tbl_info3" class="table table-bordered table-condensed" style="font-size:11px;">
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
                <table class="table table-bordered table-condensed" style="font-size:11px;display:none;">
                    <tr>
                        <th style="width:200px;padding-bottom:5px;vertical-align:middle;">No Faktur Penjualan</th>
                        <td><input type="text" id="kode3" name="kode3" class="form-control input-sm" style="width:200px;" readonly></td>
                    </tr>
                    <tr>
                        <th style="width:200px;padding-bottom:5px;vertical-align:middle;">Tgl Transaksi</th>
                        <td><input type="text" id="tglbyr3" name="tglbyr3" class="form-control input-sm" style="width:200px;" readonly></td>
                    </tr>
                    <tr>
                        <th style="width:200px;padding-bottom:5px;vertical-align:middle;">Kewajiban Total Bayar</th>
                        <td><input type="text" id="totbyr3" name="totbyr3" class="form-control input-sm" style="width:200px;" readonly></td>
                    </tr>
                    <tr>
                        <th style="width:200px;padding-bottom:5px;vertical-align:middle;">Jumlah yang Sudah di Bayar</th>
                        <td><input type="text" id="sudbyr3" name="sudbyr3" class="form-control input-sm" style="width:200px;" readonly></td>
                    </tr>
                    <tr>
                        <th style="width:200px;padding-bottom:5px;vertical-align:middle;">Kurang Bayar</th>
                        <td><input type="text" id="kurbyr3" name="kurbyr3" class="form-control input-sm" style="width:200px;" readonly></td>
                    </tr>
                </table>
                <p style="font-size:11px;margin-bottom:0;"><span id="inputByrValue3"><b>Silahkan Input Kekurangan Pembayaran, </b></span></p>
                <table id="tbl_inputBayar3" class="table table-bordered table-condensed" style="font-size:11px;">
                <th style="width:200px;padding-bottom:5px;vertical-align:middle;">Jumlah Pembayaran : </th>
                        <td><input type="text" id="jmlbyr" name="jmlbyr" class="form-control input-sm" style="width:150px;text-align:right;" min="0" required></td>
                </table>
                <hr/>
                <p style="font-size: 11px; margin-bottom: 0;">
                    <b>History Pembayaran : </b>
                    <span style="float: right;"><b>Total yang dibayar : <span id="totValue3" style="color: green;"></b></span>
                </p>
                <table id="tbl_bayar3" class="table table-bordered table-condensed" style="font-size:11px;">
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
                <button type="submit" class="btn btn-info">Update</button>    
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
    function varCetak_Piutang() {
        var form = document.querySelector('#cetak_piutang form');
        form.action = "<?php echo base_url().'admin/piutang/cetak_piutang'?>";    
    }

    function varCetak_Rekap() {
        var form = document.querySelector('#cetak_rekap form');
        form.action = "<?php echo base_url().'admin/piutang/cetak_rekap'?>";    
    }

    function varCetak_Pembayaran() {
        var form = document.querySelector('#cetak_bayar form');
        form.action = "<?php echo base_url().'admin/piutang/cetak_bayar'?>";    
    }
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
            url: "<?php echo base_url().'admin/piutang/get_jual_bayar';?>",
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
            url: "<?php echo base_url('admin/piutang/get_detail_jual'); ?>",
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



<script type="text/javascript">
//---------------Data Proses Pembayaran-------------------------
$(document).ready(function() {
    var tblBayar3; // Variabel untuk tabel DataTable
    var tblInfo3;
    var isDataTableInitialized = false; // Variabel untuk melacak apakah DataTable sudah diinisialisasi
    // Inisialisasi DataTable tanpa data awal
    tblBayar3 = $('#tbl_bayar3').DataTable({
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
    tblInfo3 = $('#tbl_info3').DataTable({
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
    $(document).on('click', '.btn-bayar', function() {
        var nofak3 = $(this).data('nofak');
        var nmcust3 = $(this).data('nmcust');
        $('#kode3').val(nofak3);
        $('#nofakValue3').text(nofak3);
        $('#nmcustValue3').text(nmcust3);
        $.ajax({
            url: "<?php echo base_url().'admin/piutang/get_jual_bayar2';?>",
            data: { nofak : nofak3 },
            dataType: 'json',
            success: function(data) {
                console.log(data);
                console.log(nofak3);
                console.log(nmcust3);
                tblBayar3.clear().draw();
                for (var i = 0; i < data.queryB.length; i++) {
                    tblBayar3.row.add(data.queryB[i]).draw();
                }
                tblInfo3.clear().draw();
                tblInfo3.row.add(data.queryA).draw();
                var ketBayar3 = data.queryA.bayar_ket;
                if (ketBayar3 === "Lunas") {
                    $('#tbl_inputBayar3').css('display', 'none');
                    $('#inputByrValue3').css('display', 'none');
                } else {
                    $('#tbl_inputBayar3').css('display', 'table');
                    $('#inputByrValue3').css('display', 'block');
                }
                var bayarTanggal3 = data.queryA.bayar_tanggal;
                var bayarTotal3 = parseFloat(data.queryA.bayar_total);
                var totBayar3 = parseFloat(data.queryA.tot_bayar);
               
                var kurangBayar3 = parseFloat(data.queryA.kur_bayar);
                bayarTotal3 = Math.ceil(bayarTotal3);
                totBayar3 = Math.ceil(totBayar3);
                kurangBayar3 = Math.ceil(kurangBayar3);
               
                $('#ketValue3').text(ketBayar3);
                $('#totValue3').text(Number(totBayar3).toLocaleString('id-ID', { style: 'currency', currency: 'IDR' }).replace(/,00$/, ''));
                $("#jmlbyr").val('');
                $('#jmlbyr').attr('max',kurangBayar3);
                $("#tglbyr3").val(bayarTanggal3);
                $('#totbyr3').val(bayarTotal3);
                $('#sudbyr3').val(totBayar3);
                $('#kurbyr3').val(kurangBayar3);
            },
            error: function(xhr, status, error) {
                //console.log(error);
            }
        });
    });
});

</script>
<script type="text/javascript">
    $(document).ready(function() {
        $(document).on('input', 'input[name^="jmlbyr"]', function(e) {
            var inputValue = e.target.value;
            var sanitizedValue = inputValue.replace(/[^0-9\b\t]/g, ''); // Hapus karakter yang tidak diizinkan (selain angka, koma, backspace, delete, dan tab)
            e.target.value = sanitizedValue; // Update nilai input dengan karakter yang diizinkan
        });
        var inputElements = document.querySelectorAll('input[name^="jmlbyr"]');
        inputElements.forEach(function(inputElement) {
            inputElement.addEventListener('input', function() {
                var value = parseFloat(this.value.replace('.', ''));
                var min = parseFloat(this.min.replace('.', ''));
                var max = parseFloat(this.max.replace('.', ''));
                if (value < min) {
                    this.value = min;
                } else if (value > max) {
                    this.value = max;
                }
               
            });
        });
        $(document).on('blur', 'input[name^="jmlbyr"]', function(e) {
            var nilai = parseFloat($(this).val().replace(/[^\d.,]/g, '')) || 0;
            var formattednilai = nilai.toLocaleString('id-ID');
            $(this).val(formattednilai);
        });

    });
</script>


<!--Tampil Data Pelunasan -->
<script type="text/javascript">
$(document).ready(function () {
    $(document).on('click', '.btn-tampil', function () {
        $('#tbl_tampil tbody').empty();
        var regid = $('#regid').val();
        var tgl1 = $('#tgl1').val();
        var tgl2 = $('#tgl2').val();

        $.ajax({
            url: "<?php echo base_url().'admin/piutang/get_pembayaran';?>",
            type: "POST",
            data: {
                regid: regid,
                tgl1: tgl1,
                tgl2: tgl2
            },
            success: function (data) {
                // console.log("Data from server:", data);
                // console.log(regid);
                // console.log(tgl1);
                // console.log(tgl2);
                var parsedData = JSON.parse(data);
                if (parsedData.length !== 0) {
                        var totbyr=0;
                        var no=0;
                        $.each(parsedData.data, function (index, item) {
                                var jbyr = parseFloat(item.bayar_jumlah);
                                totbyr = totbyr + jbyr;
                                no++;
                                var newRow = '<tr>' +
                                    '<td style="font-size:11px;text-align:center;">' + no + '</td>' +
                                    '<td style="font-size:11px;">' + item.bayar_tgl_trans + '</td>' +
                                    '<td style="font-size:11px;">' + item.jual_cust_nama + '</td>' +
                                    '<td style="font-size:11px;">' + item.bayar_nofak + '</td>' +
                                    '<td style="font-size:11px;">' + item.jual_nota + '</td>' +
                                    '<td style="font-size:11px;text-align:center;">' + item.bayar_ket + '</td>' +
                                    '<td style="text-align:right;font-size:11px;">' + jbyr.toLocaleString('id-ID') + '</td>' +
                                    '<td style="font-size:11px;text-align:center;">' +
                                    '<a class="btn btn-xs btn-info btn-lihatbayar" href="#modalLihatBayar" data-toggle="modal" data-nofak="' + item.bayar_nofak + '" data-nmcust="' + item.jual_cust_nama + '" data-tmpbln="' + item.jual_bulan_tempo + '" data-tmptgl="' + item.jual_tgl_tempo + '" data-jenisbyr="' + item.jual_bayar + '" title="Lihat Data Penjualan"><span class="fa fa-eye"></span> Lihat Bayar</a> ' +
                                    '</td>' +
                                    '</tr>';
                                $('#tbl_tampil tbody').append(newRow);

                            
                        });
                        var totRow = '<tr style="background-color:#777;">' +
                            '<td colspan="6" style="text-align:right;font-size:11px;color:white;"><b>Total :</b></td>' +
                            '<td style="text-align:right;font-size:11px;color:white;"><b>' + totbyr.toLocaleString('id-ID') + '</b></td>' +
                            '</tr>';
                        $('#tbl_tampil tbody').append(totRow);
                
                    
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



</body>
</html>
