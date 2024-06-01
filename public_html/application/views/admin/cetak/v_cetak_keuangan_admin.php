<html lang="en" moznomarginboxes mozdisallowselectionprint>
<head>
    <?php 
	error_reporting(0);
    $userid=$userid->row_array();
    ?>
    <title>Laporan Keuangan</title>
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
    
  .curved-image {
    width: 210px; /* Mengatur lebar gambar */
    height: 50px; /* Mengatur tinggi gambar */
    border-radius: 50%; /* Membuat gambar melengkung (lingkaran) */
    object-fit: cover; /* Mengatur cara gambar diatur di dalam area */
  }
</style>
</head>

<body onload="window.print()">
<div id="laporan">
<table border="0" align="center" style="width:650px; border:none;margin-top:5px;margin-bottom:0px;">
    <tr>
        <td><img src="<?php echo base_url().'assets/img/'. $userid['co_imglogo']; ?>" style="margin-bottom:10px" alt="Curved Image" class="curved-image"/></td>
        <td style="width:750px; padding-left:0px;">
            <center>
                <h4 style="margin: 0; margin-left: -110px;">LAPORAN KEUANGAN <?php echo strtoupper($namacab);?></h4>
                <h4 style="margin: 0; margin-left: -110px;">PERIODE <?php echo strtoupper($bln2);?></h4>
            </center>
        </td>
    </tr>
</table>

<table border="0" align="center" style="width:800px;border:none;">
        <tr>
            <th style="text-align:left"></th>
        </tr>
</table>

<div class="row">
    <div class="col-lg-8">
        <table border="1" align="center" style="width:650px;margin-bottom:20px;">
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

                echo '<th style="width:30%;vertical-align:middle;text-align:left;padding-left:3px;">';
                echo 'OMSET ' . $kat ;
                echo '<td style="width:2%;vertical-align:middle;text-align:right;border-right-color:white;"></td>';
                echo '<td style="width:10%;text-align:right;"></td>';
                echo '<td style="width:2%;vertical-align:middle;text-align:center;border-right-color:white;">Rp </td>';
                echo '<td style="width:10%;vertical-align:middle;text-align:right;padding-right:3px;">'. str_replace(',', '.', number_format($omzet)) . '</td>';
                echo '</th>';
                echo '</tr>';
            endforeach;

            echo '<tr>';
            echo '<th></th>';
            echo '<th style="width:30%;vertical-align:middle;text-align:left;padding-left:3px;">';
            echo 'TOTAL OMSET ';
            echo '<td style="width:2%;vertical-align:middle;text-align:center;border-right-color:white;"></td>';
            echo '<td style="width:10%;text-align:right;"></td>';
            echo '<td style="width:2%;vertical-align:middle;text-align:center;border-right-color:white;">Rp </td>';
            //echo '<td style="width:10%;vertical-align:middle;text-align:right;"><b>'. str_replace(',', '.', number_format($tot)) . '</b></td>';
            echo '<td style="width:10%;vertical-align:middle;text-align:right;border-top: 2px solid black;padding-right:3px;"><b><span style="color:#538dd5;">'. str_replace(',', '.', number_format($tot)) . '</span></b></td>';
            echo '</th>';
            echo '</tr>';

            echo '<tr>';
            echo '<th></th>';
            echo '<th style="width:30%;vertical-align:middle;text-align:left;padding-left:3px;">';
            echo 'PIUTANG Bulan ' . $bln2;
            echo '<td style="width:2%;vertical-align:middle;text-align:center;border-right-color:white;"></td>';
            echo '<td style="width:10%;text-align:right;"></td>';
            echo '<td style="width:2%;vertical-align:middle;text-align:center;border-right-color:white;">Rp </td>';
            echo '<td style="width:10%;vertical-align:middle;text-align:right;padding-right:3px;"><span style="color:#ff0000;">'. str_replace(',', '.', number_format($piutang)) . '</span></td>';
            echo '</th>';
            echo '</tr>';

            echo '<tr>';
            echo '<th></th>';
            echo '<th style="width:30%;vertical-align:middle;text-align:left;padding-left:3px;">';
            echo 'PENJUALAN TUNAI ' ;
            echo '<td style="width:2%;vertical-align:middle;text-align:center;border-right-color:white;"></td>';
            echo '<td style="width:10%;text-align:right;"></td>';
            echo '<td style="width:2%;vertical-align:middle;text-align:center;border-right-color:white;">Rp </td>';
            echo '<td style="width:10%;vertical-align:middle;text-align:right;border-top: 2px solid black;padding-right:3px;"><b>'. str_replace(',', '.', number_format($jualtunai)) . '</b></td>';
            echo '</th>';
            echo '</tr>';

            echo '<tr>';
            echo '<th style="width:2%;vertical-align:middle;text-align:center;">II</th>';
            echo '<th style="width:30%;vertical-align:middle;text-align:left;padding-left:3px;">';
            echo 'JUMLAH TAGIHAN Bulan ' . $bln1;
            echo '<td style="width:2%;vertical-align:middle;text-align:center;border-right-color:white;">Rp</td>';
            echo '<td style="width:10%;vertical-align:middle;text-align:right;padding-right:3px;"><span style="color:#ff0000;">'. str_replace(',', '.', number_format($tagihanA)) . '</span></td>';
            echo '<td style="width:2%;vertical-align:middle;text-align:center;border-right-color:white;"> </td>';
            echo '<td style="width:10%;vertical-align:middle;text-align:right;"></td>';
            echo '</th>';
            echo '</tr>';

            echo '<tr>';
            echo '<th style="width:2%;vertical-align:middle;"></th>';
            echo '<th style="width:30%;vertical-align:middle;text-align:left;padding-left:3px;">';
            echo 'JUMLAH TAGIHAN Bulan ' . $bln2;
            echo '<td style="width:2%;vertical-align:middle;text-align:center;border-right-color:white;">Rp</td>';
            echo '<td style="width:10%;vertical-align:middle;text-align:right;padding-right:3px;"><span style="color:#ff0000;">'. str_replace(',', '.', number_format($tagihanB)) . '</span></td>';
            echo '<td style="width:2%;vertical-align:middle;text-align:center;border-right-color:white;"> </td>';
            echo '<td style="width:10%;vertical-align:middle;text-align:right;"></td>';
            echo '</th>';
            echo '</tr>';

            echo '<tr>';
            echo '<th></th>';
            echo '<th style="width:30%;vertical-align:middle;text-align:left;padding-left:3px;">';
            echo ' ' ;
            echo '<td style="width:2%;vertical-align:middle;text-align:center;border-right-color:white;"></td>';
            echo '<td style="width:10%;text-align:right;border-top: 2px solid black;padding-right:3px;"></td>';
            echo '<td style="width:2%;vertical-align:middle;text-align:center;border-right-color:white;">Rp </td>';
            echo '<td style="width:10%;vertical-align:middle;text-align:right;padding-right:3px;"><b><span style="color:#538dd5;">'. str_replace(',', '.', number_format($jmltagihan)) . '</span></b></td>';
            echo '</th>';
            echo '</tr>';

            echo '<tr>';
            echo '<th style="width:2%;vertical-align:middle;text-align:center;">III</th>';
            echo '<th style="width:30%;vertical-align:middle;text-align:left;padding-left:3px;">';
            echo 'PELUNASAN TAGIHAN Bulan ' . $bln2;
            echo '<td style="width:2%;vertical-align:middle;text-align:center;border-right-color:white;"></td>';
            echo '<td style="width:10%;text-align:right;"></td>';
            echo '<td style="width:2%;vertical-align:middle;text-align:center;border-right-color:white;">Rp </td>';
            echo '<td style="width:10%;vertical-align:middle;text-align:right;padding-right:3px;"><span style="color:#ff0000;">'. str_replace(',', '.', number_format($sudah_bayar)) . '</span></td>';
            echo '</th>';
            echo '</tr>';

            echo '<tr>';
            echo '<th style="width:2%;vertical-align:middle;text-align:center;">IV</th>';
            echo '<th style="width:30%;vertical-align:middle;text-align:left;padding-left:3px;">';
            echo 'TOTAL TAGIHAN Bulan ' . $bln2;
            echo '<td style="width:2%;vertical-align:middle;text-align:center;border-right-color:white;"></td>';
            echo '<td style="width:10%;text-align:right;"></td>';
            echo '<td style="width:2%;vertical-align:middle;text-align:center;border-right-color:white;">Rp </td>';
            echo '<td style="width:10%;vertical-align:middle;text-align:right;border-top: 2px solid black;padding-right:3px;"><b>'. str_replace(',', '.', number_format($tottagihan)) . '</b></td>';
            echo '</th>';
            echo '</tr>';

            echo '<tr>';
            echo '<th></th>';
            echo '<th style="width:30%;vertical-align:middle;text-align:left;padding-left:3px;">';
            echo '&nbsp; ' ;
            echo '<td style="width:2%;vertical-align:middle;text-align:center;border-right-color:white;"></td>';
            echo '<td style="width:10%;text-align:right;"></td>';
            echo '<td style="width:2%;vertical-align:middle;text-align:center;border-right-color:white;"></td>';
            echo '<td style="width:10%;vertical-align:middle;text-align:right;"></td>';
            echo '</th>';
            echo '</tr>';

            echo '<tr>';
            echo '<th style="width:2%;vertical-align:middle;text-align:center;">V</th>';
            echo '<th style="width:30%;vertical-align:middle;text-align:left;padding-left:3px;">';
            echo 'DANA PENJUALAN TUNAI';
            echo '<td style="width:2%;vertical-align:middle;text-align:center;border-right-color:white;"></td>';
            echo '<td style="width:10%;text-align:right;"></td>';
            echo '<td style="width:2%;vertical-align:middle;text-align:center;border-right-color:white;">Rp </td>';
            echo '<td style="width:10%;vertical-align:middle;text-align:right;padding-right:3px;">'. str_replace(',', '.', number_format($jualtunai)) . '</td>';
            echo '</th>';
            echo '</tr>';

            echo '<tr>';
            echo '<th></th>';
            echo '<th style="width:30%;vertical-align:middle;text-align:left;padding-left:3px;">';
            echo 'DANA PELUNASAN TAGIHAN';
            echo '<td style="width:2%;vertical-align:middle;text-align:center;border-right-color:white;"></td>';
            echo '<td style="width:10%;text-align:right;"></td>';
            echo '<td style="width:2%;vertical-align:middle;text-align:center;border-right-color:white;">Rp </td>';
            echo '<td style="width:10%;vertical-align:middle;text-align:right;padding-right:3px;">'. str_replace(',', '.', number_format($sudah_bayar)) . '</td>';
            echo '</th>';
            echo '</tr>';

            // echo '<tr>';
            // echo '<th></th>';
            // echo '<th style="width:30%;vertical-align:middle;text-align:left;padding-left:3px;">';
            // echo 'SALDO AKHIR Bulan '  . $bln1;
            // echo '<td style="width:2%;vertical-align:middle;text-align:center;border-right-color:white;"></td>';
            // echo '<td style="width:10%;text-align:right;"></td>';
            // echo '<td style="width:2%;vertical-align:middle;text-align:center;border-right-color:white;">Rp </td>';
            // echo '<td style="width:10%;vertical-align:middle;text-align:right;">'. str_replace(',', '.', number_format($saldo_kemarin)) . '</td>';
            // echo '</th>';
            // echo '</tr>';
            
            echo '<tr>';
            echo '<th></th>';
            echo '<th style="width:30%;vertical-align:middle;text-align:left;padding-left:3px;">';
            echo ' ' ;
            echo '<td style="width:2%;vertical-align:middle;text-align:center;border-right-color:white;"></td>';
            echo '<td style="width:10%;text-align:right;"></td>';
            echo '<td style="width:2%;vertical-align:middle;text-align:center;border-right-color:white;">Rp </td>';
            echo '<td style="width:10%;vertical-align:middle;text-align:right;border-top: 2px solid black;padding-right:3px;"><b><span style="color:#538dd5;">'. str_replace(',', '.', number_format($jmlV)) . '</span></b></td>';
            echo '</th>';
            echo '</tr>';

            echo '<tr>';
            echo '<th></th>';
            echo '<th style="width:30%;vertical-align:middle;text-align:left;padding-left:3px;">';
            echo '&nbsp;' ;
            echo '<td style="width:2%;vertical-align:middle;text-align:center;border-right-color:white;"></td>';
            echo '<td style="width:10%;text-align:right;"></td>';
            echo '<td style="width:2%;vertical-align:middle;text-align:center;border-right-color:white;"></td>';
            echo '<td style="width:10%;vertical-align:middle;text-align:right;"></td>';
            echo '</th>';
            echo '</tr>';

            echo '<tr>';
            echo '<th style="width:2%;vertical-align:middle;text-align:center;">VI</th>';
            echo '<th style="width:30%;vertical-align:middle;text-align:left;padding-left:3px;">';
            echo 'PENGELUARAN' ;
            echo '<td style="width:2%;vertical-align:middle;text-align:center;border-right-color:white;"></td>';
            echo '<td style="width:10%;text-align:right;"></td>';
            echo '<td style="width:2%;vertical-align:middle;text-align:center;border-right-color:white;"></td>';
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
                echo '<th style="width:30%;vertical-align:middle;text-align:left;padding-left:3px;">';
                echo ' ' .$kat_nama;
                echo '<td style="width:2%;vertical-align:middle;text-align:center;border-right-color:white;">Rp </td>';
                echo '<td style="width:10%;text-align:right;padding-right:3px;">'. str_replace(',', '.', number_format($beban)) . '</td>';
                if ($index === $jumlah_data - 1) {
                    echo '<td style="width:2%;vertical-align:middle;text-align:center;border-right-color:white;">Rp </td>';
                    echo '<td style="width:10%;vertical-align:middle;text-align:right;padding-right:3px;"><b><span style="color:#ff0000;">' . str_replace(',', '.', number_format($tot_beb)) . '</span></b></td>';
                } else {
                    echo '<td style="width:2%;vertical-align:middle;text-align:center;border-right-color:white;"></td>';
                    echo '<td style="width:10%;vertical-align:middle;text-align:right;"></td>';
                }
                echo '</th>';
                echo '</tr>';
            endforeach;
                
            $jml_sisa = $jmlV - $tot_beb;
            echo '<tr>';
            echo '<th></th>';
            echo '<th colspan="3" style="text-align:right;padding-right:3px;">Saldo Kas '.$bln2.'</th>';
            //echo ' ' ;
            //echo '<td style="width:2%;vertical-align:middle;text-align:center;border-right-color:white;"></td>';
            //echo '<td style="width:10%;text-align:right;"></td>';
            echo '<td style="width:2%;vertical-align:middle;text-align:center;border-right-color:white;">Rp </td>';
            echo '<td style="width:10%;vertical-align:middle;text-align:right;border-top: 2px solid black;padding-right:3px;"><b>'. str_replace(',', '.', number_format($jml_sisa)) . '</b></td>';
            echo '</th>';
            echo '</tr>';

            echo '<tr>';
            echo '<th></th>';
            echo '<th colspan="3" style="text-align:right;padding-right:3px;">Saldo Akhir '.$bln1.'</th>';
            //echo ' ' ;
            //echo '<td style="width:2%;vertical-align:middle;text-align:center;border-right-color:white;"></td>';
            //echo '<td style="width:10%;text-align:right;"></td>';
            echo '<td style="width:2%;vertical-align:middle;text-align:center;border-right-color:white;">Rp </td>';
            echo '<td style="width:10%;vertical-align:middle;text-align:right;padding-right:3px;">'. str_replace(',', '.', number_format($saldo_kemarin)) . '</td>';
            echo '</th>';
            echo '</tr>';

            $jml_saldo = $jml_sisa + $saldo_kemarin;
            echo '<tr>';
            echo '<th></th>';
            echo '<th colspan="3" style="text-align:right;padding-right:3px;">Jumlah Saldo </th>';
            //echo ' ' ;
            //echo '<td style="width:2%;vertical-align:middle;text-align:center;border-right-color:white;"></td>';
            //echo '<td style="width:10%;text-align:right;"></td>';
            echo '<td style="width:2%;vertical-align:middle;text-align:center;border-right-color:white;">Rp </td>';
            echo '<td style="width:10%;vertical-align:middle;text-align:right;border-top: 2px solid black;padding-right:3px;"><b>'. str_replace(',', '.', number_format($jml_saldo)) . '</b></td>';
            echo '</th>';
            echo '</tr>';

            echo '<tr>';
            echo '<th></th>';
            echo '<th style="width:30%;vertical-align:middle;text-align:left;padding-left:3px;">';
            echo '&nbsp; ' ;
            echo '<td style="width:2%;vertical-align:middle;text-align:center;border-right-color:white;"></td>';
            echo '<td style="width:10%;text-align:right;"></td>';
            echo '<td style="width:2%;vertical-align:middle;text-align:center;border-right-color:white;"></td>';
            echo '<td style="width:10%;vertical-align:middle;text-align:right;"></td>';
            echo '</th>';
            echo '</tr>';

            echo '<tr>';
            echo '<th style="width:2%;vertical-align:middle;text-align:center;">VII</th>';
            echo '<th style="width:30%;vertical-align:middle;text-align:left;padding-left:3px;">';
            echo 'TRANSFER' ;
            echo '<td style="width:2%;vertical-align:middle;text-align:center;border-right-color:white;"></td>';
            echo '<td style="width:10%;text-align:right;"></td>';
            echo '<td style="width:2%;vertical-align:middle;text-align:center;border-right-color:white;"></td>';
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
            echo '<th style="width:30%;vertical-align:middle;text-align:left;padding-left:3px;">';
            echo ' ' . $nm_beb ;
            echo '<td style="width:2%;vertical-align:middle;text-align:center;border-right-color:white;">Rp </td>';
            echo '<td style="width:10%;text-align:right;padding-right:3px;">'. str_replace(',', '.', number_format($jml_trans)) . '</td>';
            if ($index2 === $jml_beb - 1) {
                echo '<td style="width:2%;vertical-align:middle;text-align:center;border-right-color:white;">Rp </td>';
                echo '<td style="width:10%;vertical-align:middle;text-align:right;border-bottom: 2px solid black;padding-right:3px;"><b><span style="color:#ff0000;">'. str_replace(',', '.', number_format($jml_transfer)) . '</span></b></td>';
            } else {
                echo '<td style="width:2%;vertical-align:middle;text-align:center;border-right-color:white;"></td>';
                echo '<td style="width:10%;vertical-align:middle;text-align:right;"></td>';
            }
            echo '</th>';
            echo '</tr>';
            endforeach;

            echo '<tr>';
            echo '<th></th>';
            echo '<th style="width:30%;vertical-align:middle;text-align:left;padding-left:3px;">';
            echo ' ' ;
            echo '<td style="width:2%;vertical-align:middle;text-align:center;border-right-color:white;"></td>';
            echo '<td style="width:10%;text-align:right;"></td>';
            echo '<td style="width:2%;vertical-align:middle;text-align:center;border-right-color:white;"></td>';
            echo '<td style="width:10%;vertical-align:middle;text-align:right;"></td>';
            echo '</th>';
            echo '</tr>';

            //$selisih = $jml_transfer - $jml_sisa;
            //$selisih2 = $jml_sisa - $jml_transfer;
            $selisih2 = ($jml_sisa + $saldo_kemarin) - $jml_transfer;
            echo '<tr>';
            echo '<th colspan="4" style="text-align:right;padding-right:3px;">Saldo Akhir : </th>';
            //echo '<td style="width:2%;vertical-align:middle;text-align:center;border-right-color:white;">Rp </td>';
            //echo '<td style="width:10%;vertical-align:middle;text-align:right;color:#ff0000;"><b>'. str_replace(',', '.', number_format($selisih)) . '</b></td>';
            echo '<td style="width:2%;vertical-align:middle;text-align:center;border-right-color:white;">Rp </td>';
            if ($selisih2 > 0) {   
                echo '<td style="width:10%;text-align:right;padding-right:3px;"><b>'. str_replace(',', '.', number_format($selisih2)) . '</b></td>';
            }else {  //mewarnai huruf jadi merah
                echo '<td style="width:10%;text-align:right;padding-right:3px;"><b><span style="color:#ff0000;">'. str_replace(',', '.', number_format($selisih2)) . '</span></b></td>';
            }
            echo '</th>';
            echo '</tr>';

            ?>
        </table>
    </div>
</div>

<br>
<table align="center" style="width:650px;border:none;margin-bottom:20px;">
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