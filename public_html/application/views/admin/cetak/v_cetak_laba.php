<html lang="en" moznomarginboxes mozdisallowselectionprint>
<head>
    <?php 
	error_reporting(0);
    $userid=$userid->row_array();
    ?>
    <title>Laporan Laba Penjualan <?php echo $userid['reg_name'];?></title>
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
<table border="0" align="center" style="width:750px; border:none;margin-top:5px;margin-bottom:0px;">
    <tr>
        <td><img src="<?php echo base_url().'assets/img/'. $userid['co_imglogo']; ?>" style="margin-bottom:10px" alt="Curved Image" class="curved-image"/></td>
        <td style="width:750px; padding-left:0px;">
            <center>
                <h4 style="margin: 0; margin-left: -110px;">LAPORAN LABA PENJUALAN <?php echo strtoupper($userid['reg_code']);?> <?php echo strtoupper($userid['reg_name']);?></h4>
                <h4 style="margin: 0; margin-left: -110px;">PERIODE <?php echo strtoupper($nm_bln);?> <?php echo strtoupper($thn);?></h4>
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
    <div class="col-lg-12">
        <table border="1" align="center" style="width:750px;margin-bottom:20px;">
            <thead>
                <tr>
                    <th style="text-align:center">No</th>    
                    <th style="text-align:center">Kategori</th>    
                    <th style="text-align:center">Price List Tunai</th>
                    <th style="text-align:center">Bottom Tunai</th>
                    <th style="text-align:center">Laba Tunai</th>
                    <th style="text-align:center">Price List Piutang</th>
                    <th style="text-align:center">Bottom Piutang</th>
                    <th style="text-align:center">Laba Piutang</th>
                    <th style="text-align:center">Total Price List</th>
                    <th style="text-align:center">Total Bottom</th>
                    <th style="text-align:center">Total Laba</th>
                    </tr>
            </thead>
            <tbody>
            <?php 
                $d=$data->row_array();
                $totharjul_tunai=0;
                $totharpok_tunai=0;
                $totharjul_piutang=0;
                $totharpok_piutang=0;
                $totlaba_tunai=0;
                $totlaba_piutang=0;
                $totharjul=0;
                $totharpok=0;
                $totlaba=0;
                $no=0;
                foreach ($kategori as $k):
                $no++;
                $kat = $k['kategori_nama'];
                $harjul_tunai = $d['harjul_tunai' . $kat];
                $harpok_tunai = $d['harpok_tunai' . $kat];
                $harjul_piutang = $d['harjul_piutang' . $kat];
                $harpok_piutang = $d['harpok_piutang' . $kat];
                $harjul = $d['harjul' . $kat];
                $harpok = $d['harpok' . $kat];
                $laba = $harjul - $harpok;
                $totharjul = $totharjul + $harjul;
                $totharpok = $totharpok + $harpok;
                $totlaba = $totlaba + $laba;
                $laba_tunai = $harjul_tunai - $harpok_tunai;
                $totharjul_tunai = $totharjul_tunai + $harjul_tunai;
                $totharpok_tunai = $totharpok_tunai + $harpok_tunai;
                $totlaba_tunai = $totlaba_tunai + $laba_tunai;
                $laba_piutang = $harjul_piutang - $harpok_piutang;
                $totharjul_piutang = $totharjul_piutang + $harjul_piutang;
                $totharpok_piutang = $totharpok_piutang + $harpok_piutang;
                $totlaba_piutang = $totlaba_piutang + $laba_piutang;
                echo '<tr>';
                echo '<td>'.$no.'</td>';
                echo '<td>'.$kat.'</td>';
                echo '<td style="text-align:right;">'.str_replace(',', '.', number_format($harjul_tunai)).'</td>';
                echo '<td style="text-align:right;">'.str_replace(',', '.', number_format($harpok_tunai)).'</td>';
                echo '<td style="text-align:right;">'.str_replace(',', '.', number_format($laba_tunai)).'</td>';
                echo '<td style="text-align:right;">'.str_replace(',', '.', number_format($harjul_piutang)).'</td>';
                echo '<td style="text-align:right;">'.str_replace(',', '.', number_format($harpok_piutang)).'</td>';
                echo '<td style="text-align:right;">'.str_replace(',', '.', number_format($laba_piutang)).'</td>';
                echo '<td style="text-align:right;">'.str_replace(',', '.', number_format($harjul)).'</td>';
                echo '<td style="text-align:right;">'.str_replace(',', '.', number_format($harpok)).'</td>';
                echo '<td style="text-align:right;">'.str_replace(',', '.', number_format($laba)).'</td>';
                echo '</th>';
                echo '</tr>';

            endforeach;
            echo '
                <tr>
                    <td colspan="2" style="text-align:right;font-size:11px;"><b>Total : </b></td>
                    <td style="text-align:right;font-size:11px;"><b>' . str_replace(',', '.', number_format($totharjul_tunai)) . '</b></td>
                    <td style="text-align:right;font-size:11px;"><b>' . str_replace(',', '.', number_format($totharpok_tunai)) . '</b></td>
                    <td style="text-align:right;font-size:11px;"><b>' . str_replace(',', '.', number_format($totlaba_tunai)) . '</b></td>
                    <td style="text-align:right;font-size:11px;"><b>' . str_replace(',', '.', number_format($totharjul_piutang)) . '</b></td>
                    <td style="text-align:right;font-size:11px;"><b>' . str_replace(',', '.', number_format($totharpok_piutang)) . '</b></td>
                    <td style="text-align:right;font-size:11px;"><b>' . str_replace(',', '.', number_format($totlaba_piutang)) . '</b></td>
                    <td style="text-align:right;font-size:11px;"><b>' . str_replace(',', '.', number_format($totharjul)) . '</b></td>
                    <td style="text-align:right;font-size:11px;"><b>' . str_replace(',', '.', number_format($totharpok)) . '</b></td>
                    <td style="text-align:right;font-size:11px;"><b>' . str_replace(',', '.', number_format($totlaba)) . '</b></td>
                </tr>';

            ?>

            </tbody>
        </table>
    </div>
</div>

<br>
<table align="center" style="width:750px;border:none;margin-bottom:20px;">
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