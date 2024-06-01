<html lang="en" moznomarginboxes mozdisallowselectionprint>

<head>
    <?php 
	error_reporting(0);
    $userid=$userid->row_array();
    ?>
    <title>Laporan Piutang Penjualan <?php echo $userid['reg_name'];?></title>
    <link rel="shortcut icon" href="<?php echo base_url().'assets/img/'. $userid['co_imgicon']; ?>" alt="#no image#" type="image/x-icon">
    <meta charset="utf-8">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/laporan.css')?>"/>

<style>
    @media print {
        @page {  
            margin: 0;
        }
        body {
            margin: 50;
        }
    }

    .total-grup-row {
    visibility: collapse;
    }
    
    .curved-image {
        width: 210px;
        height: 50px;
        border-radius: 50%;
        object-fit: cover;
    }
</style>
</head>

<body onload="window.print()">
    <div id="laporan">
        

        <table border="0" align="center" style="width:700px; border:none;margin-top:5px;margin-bottom:0px;">
            <tr>
                <td><img src="<?php echo base_url().'assets/img/'. $userid['co_imglogo']; ?>" style="margin-bottom:10px" alt="Curved Image" class="curved-image"/></td>
                <td style="width:700px; padding-left:0px;">
                    <center>
                        <h4 style="margin: 0; margin-left: -110px;">LAPORAN PIUTANG PENJUALAN <?php echo strtoupper($userid['reg_code']);?> <?php echo strtoupper($userid['reg_name']);?></h4>
                        <h4 style="margin: 0; margin-left: -110px;">PERIODE <?php echo date('Y')?></h4>
                    </center>
                </td>
            </tr>
        </table>

        <table border="0" align="center" style="width:700px;border:none;">
            <tr>
                <th style="text-align:left"></th>
            </tr>
        </table>

    
       <div class="row">
            <div class="col-lg-12">
                <?php
                $currentKolek = null;
                $totalPenjualan = $totalSudahBayar = $totalKurangBayar = $nomorKelompok = 0;
                $totalSemuaPenjualan = $totalSemuaSudahBayar = $totalSemuaKurangBayar = 0;
                $totRec = 0;

                foreach ($data->result_array() as $a):
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
                            echo '<td colspan="5" style="text-align:right;padding-right:5px;"><strong>Total : </strong></td>';
                            //echo '<td style="text-align:right;"><strong>Rp ' . number_format($totalPenjualan) . '</strong></td>';
                            //echo '<td style="text-align:right;"><strong>Rp ' . number_format($totalSudahBayar) . '</strong></td>';
                            //echo '<td style="text-align:right;"><strong>Rp ' . number_format($totalKurangBayar) . '</strong></td>';
                            echo '<td style="text-align:right;padding-right:3px;"><strong>Rp ' . str_replace(',', '.', number_format($totalPenjualan)) . '</strong></td>';
                            echo '<td style="text-align:right;padding-right:3px;"><strong>Rp ' . str_replace(',', '.', number_format($totalSudahBayar)) . '</strong></td>';
                            echo '<td style="text-align:right;padding-right:3px;"><strong>Rp ' . str_replace(',', '.', number_format($totalKurangBayar)) . '</strong></td>';
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
                        echo '<div style="text-align:left; width:700px; margin-top:0; margin-bottom:10px; margin-left:auto; margin-right:auto;">';

                        if ($stopsales=="Yes") {
                            $stopjual="Tidak Boleh Hutang"; 
                            echo '<h3> (' . $kolek . ') - ' . $kolket . '<small> - (' . $stopjual . ')</small></h3>'; 
                        } else {
                            $stopjual="";
                            echo '<h3> (' . $kolek . ') - ' . $kolket . '</h3>';  
                        }
                        echo '</div>';
                        echo '<table border="1" align="center" style="width:700px;margin-top:-10px;font-size:10px;">';
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
                    echo '<td style="padding-left:3px;">'.$nofak.'</td>';
                    echo '<td style="padding-left:3px;">'.$nmcust.'</td>';
                    echo '<td style="text-align:center;">' . date('d/m/Y', strtotime($tgltrans)) . '</td>';
                    echo '<td style="text-align:center;">' . date('d/m/Y', strtotime($tgltempo)) . '</td>';
                    //echo '<td>'.$tgltrans.'</td>';
                    //echo '<td>'.$tgltempo.'</td>';
                    //echo '<td style="text-align:right;">Rp ' . number_format($totjual) . '</td>';
                    //echo '<td style="text-align:right;">Rp ' . number_format($sudbyr) . '</td>';
                    //echo '<td style="text-align:right;">Rp ' . number_format($kurbyr) . '</td>';
                    echo '<td style="text-align:right;padding-right:3px;">Rp ' . str_replace(',', '.', number_format($totjual)) . '</td>';
                    echo '<td style="text-align:right;padding-right:3px;">Rp ' . str_replace(',', '.', number_format($sudbyr)) . '</td>';
                    echo '<td style="text-align:right;padding-right:3px;">Rp ' . str_replace(',', '.', number_format($kurbyr)) . '</td>';
                    echo '<td style="text-align:center;">'.$blntempo.' Bln </td>';
                    echo '<td style="text-align:center;">'.$telathari.'</td>';
                    //echo '<td>'.$kolek.'</td>';
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
                echo '<td colspan="5" style="text-align:right;padding-right:5px;"><strong>Total : </strong></td>';
                //echo '<td style="text-align:right;"><strong>Rp ' . number_format($totalPenjualan) . '</strong></td>';
                //echo '<td style="text-align:right;"><strong>Rp ' . number_format($totalSudahBayar) . '</strong></td>';
                //echo '<td style="text-align:right;"><strong>Rp ' . number_format($totalKurangBayar) . '</strong></td>';
                echo '<td style="text-align:right;padding-right:3px;"><strong>Rp ' . str_replace(',', '.', number_format($totalPenjualan)) . '</strong></td>';
                echo '<td style="text-align:right;padding-right:3px;"><strong>Rp ' . str_replace(',', '.', number_format($totalSudahBayar)) . '</strong></td>';
                echo '<td style="text-align:right;padding-right:3px;"><strong>Rp ' . str_replace(',', '.', number_format($totalKurangBayar)) . '</strong></td>';
                echo '<td colspan="3"></td>';
                echo '</tr>';
                echo '</tbody>';
                echo '</table>';
                ?>
                <!-- Baris total seluruh grup --> 
                <div style="margin-top:10px;">    
                    <table border="1" align="center" style="width:700px;margin-bottom:20px;font-size:10px;">       
                        <thead>
                        <tr class="total-grup-row">
                            <th style="text-align:center;">No</th>
                            <th style="text-align:center;">No Faktur</th>
                            <th style="text-align:center;">Nama Customer</th>
                            <th style="text-align:center;">Tgl Transaksi</th>
                            <th style="text-align:center;">Tgl Jatuh Tempo</th>
                            <th style="text-align:center;">Total Penjualan</th>
                            <th style="text-align:center;">Sudah Bayar</th>
                            <th style="text-align:center;">Kurang Bayar</th>
                            <th style="text-align:center;">Tempo</th>
                            <th style="text-align:center;">Tunggakan Hari</th>       
                            
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
                            <td style="text-align:center;"><?= $blntempo ;?> Bln </td>
                            <td style="text-align:center;"><?= $telathari ;?></td>
                            
                        </tr>
                            <!-- Baris total seluruh grup -->
                        <tr>
                            <td colspan="2" style="font-size:10px;"><b>Total Record : <?php echo $totRec ;?></b></td>
                            <td colspan="3" style="text-align:right;font-size:10px;padding-right:5px;"><b>Total Seluruh Grup :</b></td>
                            <td style="text-align:right;font-size:10px;padding-right:3px;"><b><?php echo 'Rp ' . str_replace(',', '.', number_format($totalSemuaPenjualan)) ; ?></b></td>
                            <td style="text-align:right;font-size:10px;padding-right:3px;"><b><?php echo 'Rp ' . str_replace(',', '.', number_format($totalSemuaSudahBayar)) ; ?></b></td>
                            <td style="text-align:right;font-size:10px;padding-right:3px;"><b><?php echo 'Rp ' . str_replace(',', '.', number_format($totalSemuaKurangBayar)) ; ?></b></td>
                        </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div> 


        <br>
        <table align="center" style="width:700px;border:none;margin-bottom:20px;">
            <tr>
                <td colspan="6" style="text-align: center;"></td>
            </tr>
            <tr>
                <td align="left" style="width:25%;"></td>
                <td align="center" style="width:25%;"></td>
                <td align="center" style="width:25%;"></td>
                <td align="center" style="width:25%;"><?php echo $userid['reg_name'];?> , <?php echo date('d-M-Y')?></td>
            </tr>
            <tr>
                <td align="center" colspan="6"><br><br><br><br></td> <!-- Baris kosong dengan <br> -->
            </tr>
            <tr>
                <td align="left" style="width:25%;"></td>
                <td align="left" style="width:25%;"></td>
                <td align="left" style="width:25%;"></td>
                <td align="center" style="width:25%;">( <?php echo $userid['user_nama'];?> )</td>
            </tr>
            <tr>
            </tr>
        </table>

    </div>
</body>

</html>
