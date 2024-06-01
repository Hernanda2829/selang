<html lang="en" moznomarginboxes mozdisallowselectionprint>
<head>
    <?php 
	error_reporting(0);
    $userid=$userid->row_array();
    ?>
    <title>Faktur Penjualan Barang</title>
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
 
</style>
</head>
<body onload="window.print()">
<div id="laporan">

<?php 
    $b=$data->row_array();
    $carabayar=$b['jual_bayar'];

//#147aaf #2957a4
?>


<table border="0" align="center" style="width:700px; border:none;margin-top:5px;margin-bottom:10px;">
    <tr>
        <td style="width: 6%;">
            <img src="<?php echo base_url().'assets/img/logo3.png'?>" alt="Curved Image" class="curved-image" width="50" height="50"/>
        </td>
        <td style="width: 94%;">
            <table border="0" align="left" style="width:100%;border:none;">
                <tr>
                    <th style="text-align:left;font-family:Arial;font-weight:normal;font-size:25px;">
                        SAMUDERA SELANG
                    </th>
                </tr>
            </table>
        </td>
    </tr>
</table>

<table border="0" align="center" style="width:700px;border:none;margin-top:10px;">
<tr>
    <th style="text-align:left;font-weight:normal;">Hydraulic - Industrial Hose - & Fitting</th>
</tr>
<tr>
    <th style="text-align:left;font-weight:normal;padding-bottom:5px;">Filter : Udara - Oli - Hydraulic & Seal Kit</th>
</tr>
<tr>
    <th style="text-align:left; font-weight:normal; border-bottom: 1px solid black; display: flex; justify-content: space-between;">
        <span style="width: 40%;"> <?php echo $userid['reg_desc'];?> </span>
        <span style="width: 60%;"></span>
    </th>
</tr>
</table>


<table border="0" align="center" style="width:700px;border:none;margin-top:10px;">
    <tr>
        <th style="text-align:left;width:10%;">Nota</th>
        <th style="text-align:left;width:2%;">:</th>
        <th style="text-align:left;width:30%;"><?php echo $b['jual_nota'];?></th>
        <th style="text-align:left;max-width:15%;"></th>
        <th style="text-align:left;width:12%;">Keterangan</th>
        <th style="text-align:right;width:2%;">:</th>
        <th style="text-align:left;width:14%;padding-left:10px"><?php echo $b['jual_bayar'];?></th>
        <th style="text-align:left;max-width:10%;"></th>
    </tr>
    <tr>
        <th style="text-align:left;width:10%;"></th>
        <th style="text-align:left;width:2%;"></th>
        <th style="text-align:left;width:30%;"></th>
        <th style="text-align:left;max-width:15%;"></th>
        <th style="text-align:left;width:12%;">Total</th>
        <th style="text-align:right;width:2%;">:</th>
        <th style="text-align:right; padding-left:10px; padding-right:3px;"><span style="float:left;">Rp</span><?php echo number_format($b['jual_total'], 0, ',', '.').',-';?></th>
        <th style="text-align:left;max-width:10%;"></th>
    </tr>
    <tr>
        <th style="text-align:left;">Tanggal</th>
        <th style="text-align:left;">:</th>
        <th style="text-align:left;"><?php echo $b['jual_tanggal'];?></th>
        <th style="text-align:right;"></th>
        <th style="text-align:left;">Tunai</th>
        <th style="text-align:right;">:</th>
        <th style="text-align:right; padding-left:10px; padding-right:3px;"><span style="float:left;">Rp</span><?php echo number_format($b['jual_jml_uang'], 0, ',', '.').',-';?></th>
        <th style="text-align:left;"></th>
    </tr>
    <tr>
        <th style="text-align:left;">Customer</th>
        <th style="text-align:left;">:</th>
        <th style="text-align:left;"><?php echo $b['jual_cust_nama'];?></th>
        <th style="text-align:right;"></th>
        <?php
            if ($carabayar==="Cash") {
                echo '<th style="text-align:left;">Kembalian</th>';
                echo '<th style="text-align:right;">:</th>';
                echo '<th style="text-align:right; padding-left:10px; padding-right:3px;"><span style="float:left;">Rp</span>'.number_format($b['jual_kembalian'], 0, ',', '.').',-</th>';
                echo '<th style="text-align:left;"></th>';
            }elseif ($carabayar==="Tempo") {
                $kurbay = $b['jual_kurang_bayar'];
                if ($kurbay < 0) {
                    echo '<th style="text-align:left;">Lebih Bayar</th>';
                    echo '<th style="text-align:right;">:</th>';
                    echo '<th style="text-align:right; padding-left:10px; padding-right:3px;"><span style="float:left;">Rp</span>'.number_format($b['jual_kembalian'], 0, ',', '.').',-</th>';
                    echo '<th style="text-align:left;"></th>';
                } else {
                    echo '<th style="text-align:left;">Kurang Bayar</th>';
                    echo '<th style="text-align:right;">:</th>';
                    echo '<th style="text-align:right; padding-left:10px; padding-right:3px;"><span style="float:left;">Rp</span>-'.number_format($b['jual_kurang_bayar'], 0, ',', '.').',-</th>';
                    echo '<th style="text-align:left;"></th>';
                }
            }
        ?>        
    </tr>

</table>

<table border="1" align="center" style="width:700px;margin-top:5px;">
<thead>

    <tr>
        <th>No</th>
        <th>Nama Barang</th>
        <th>Satuan</th>
        <th>Harga Jual</th>
        <th style="width:6%;">Qty</th>
        <th>Diskon</th>
        <th>SubTotal</th>
    </tr>
</thead>
<tbody>

<?php
$no = 0;
$groupTotals = array();
$groupCounter = 1;

foreach ($data->result_array() as $i) {
    $groupId = $i['group_id'];
    $groupDesc = $i['group_desc'];
    $groupSat = $i['group_sat'];
    $nabar = $i['d_jual_barang_nama'];
    $satuan = $i['d_jual_barang_satuan'];

    // Pengecekan jika group_id kosong
    if (empty($groupId)) {
        $no++;
        ?>
        <tr>
            <td style="width:2%;text-align:center;"><?php echo $no;?></td>
            <td style="width:49%;text-align:left;padding-left:3px;"><?php echo $nabar;?></td>
            <td style="width:2%;text-align:center;"><?php echo $satuan;?></td>
            <td style="width:14%;text-align:right; padding-left:5px; padding-right:3px;"><span style="float:left;">Rp</span><?php echo number_format($i['d_jual_barang_harjul'], 0, ',', '.');?></td>
            <td style="width:5%;text-align:center;"><?php echo $i['d_jual_qty'];?></td>
            <td style="text-align:right; padding-left:5px; padding-right:3px;"><span style="float:left;">Rp</span><?php echo number_format($i['d_jual_diskon'], 0, ',', '.');?></td>
            <td style="width:14%;text-align:right; padding-left:5px; padding-right:3px;"><span style="float:left;">Rp</span><?php echo number_format($i['d_jual_total'], 0, ',', '.');?></td>
        </tr>
        <?php
        // Lewati pemrosesan grup pada iterasi ini
        continue;
    }

    $harjul = $i['d_jual_barang_harjul'];
    $qty = $i['d_jual_qty'];
    $diskon = $i['d_jual_diskon'];
    $total = $i['d_jual_total'];

    // Menambahkan harga jual dan diskon ke total group_id
    if (!isset($groupTotals[$groupId])) {
        //$groupTotals[$groupId] = array('groupDesc' => $groupDesc, 'groupSat' => $groupSat, 'totalHarjul' => 0, 'totalDiskon' => 0, 'totalQty' => 0, 'totalGroup' => 0, 'groupNo' => $groupCounter);
        $groupTotals[$groupId] = array('groupDesc' => $groupDesc, 'groupSat' => $groupSat, 'totalHarjul' => 0, 'totalDiskon' => 0, 'totalGroup' => 0, 'groupNo' => $groupCounter);
        $groupCounter++;
    }

    //$groupTotals[$groupId]['totalHarjul'] += $harjul;
    $groupTotals[$groupId]['totalHarjul'] += $total + $diskon;
    $groupTotals[$groupId]['totalDiskon'] += $diskon;
    //$groupTotals[$groupId]['totalQty'] = 1;
    //$groupTotals[$groupId]['totalGroup'] = $groupTotals[$groupId]['totalHarjul'] - $groupTotals[$groupId]['totalDiskon'];
    $groupTotals[$groupId]['totalGroup'] += $total;
}

foreach ($groupTotals as $groupId => $groupTotal) {
    $no++;
    ?>
    <tr>
        <td style="text-align:center;"><?php echo $no;?></td>
        <?php
        // Tampilkan deskripsi grup dan status "satu set"
        if (!empty($groupId)) {
            echo '<td style="text-align:left;padding-left:3px;">' . $groupTotal['groupDesc'] . '</td>';
            echo '<td style="text-align:center;">set</td>';
        } else {
            // Tampilkan informasi barang langsung
            echo '<td style="text-align:left;padding-left:3px;">' . $nabar . '</td>';
            echo '<td style="text-align:center;">' . $satuan . '</td>';
        }
        ?>
        <td style="text-align:right; padding-left:5px; padding-right:3px;"><span style="float:left;">Rp</span><?php echo number_format($groupTotal['totalHarjul'], 0, ',', '.');?></td>
        <td style="text-align:center;"><?php echo $groupTotal['groupSat'];?></td>
        <td style="text-align:right; padding-left:5px; padding-right:3px;"><span style="float:left;">Rp</span><?php echo number_format($groupTotal['totalDiskon'], 0, ',', '.');?></td>
        <td style="text-align:right; padding-left:5px; padding-right:3px;"><span style="float:left;">Rp</span><?php echo number_format($groupTotal['totalGroup'], 0, ',', '.');?></td>
    </tr>
    <?php
    // Tentukan bahwa baris dengan group ID ini sudah ditampilkan
    $groupTotals[$groupId]['isDisplayed'] = true;
}

foreach ($data->result_array() as $i) {
    $groupId = $i['group_id'];
    if (!empty($groupId) && (!isset($groupTotals[$groupId]['isDisplayed']) || !$groupTotals[$groupId]['isDisplayed'])) {
        $no++;
        ?>
        <tr>
            <td style="text-align:center;"><?php echo $no;?></td>
            <td style="text-align:left;padding-left:3px;"><?php echo $i['d_jual_barang_nama'];?></td>
            <td style="text-align:center;"><?php echo $i['d_jual_barang_satuan'];?></td>
            <td style="text-align:right; padding-left:5px; padding-right:3px;"><span style="float:left;">Rp</span><?php echo number_format($i['d_jual_barang_harjul'], 0, ',', '.');?></td>
            <td style="text-align:center;"><?php echo $i['d_jual_qty'];?></td>
            <td style="text-align:right; padding-left:5px; padding-right:3px;"><span style="float:left;">Rp</span><?php echo number_format($i['d_jual_diskon'], 0, ',', '.');?></td>
            <td style="text-align:right; padding-left:5px; padding-right:3px;"><span style="float:left;">Rp</span><?php echo number_format($i['d_jual_total'], 0, ',', '.');?></td>
        </tr>
        <?php
    }
}
?>
























</tbody>
<tfoot>
    <tr>
        <td colspan="5" style="padding-left:5px;font-weight:normal;"><b>Terbilang</b> :<i> <?php echo terbilang(ceil($b['jual_total']));?> rupiah</i></td>
        <td style="text-align:right;padding-right:5px;"><b>Total</b></td>
        <td style="text-align:right; padding-left:5px; padding-right:3px;"><b><span style="float:left;">Rp</span><?php echo number_format($b['jual_total'], 0, ',', '.');?></b></td>
    </tr>
</tfoot>
</table>

<table align="center" style="width:700px; border:none;">
    <td style="font-size:10px;">Print date : <?php echo date('Y-m-d H:i:s'); ?></td>
</table>


<br>
<table align="center" style="width:750px;border:none;margin-bottom:20px;">
    <tr>
        <td colspan="6" style="text-align: center;"></td>
    </tr>
    <tr>
        <td align="center" style="width:25%;"></td>
        <td align="center" style="width:25%;"></td>
        <td align="center" style="width:25%;"></td>
        <td align="center" style="width:25%;"><?php echo $userid['reg_name'];?> , <?php echo date('d-M-Y')?></td>       
    </tr>
    <tr>
        <td align="center" style="width:25%;">Tanda Terima,</td>
        <td align="center" style="width:25%;"></td>
        <td align="center" style="width:25%;"></td>
        <td align="center" style="width:25%;">Hormat Kami,</td>       
    </tr>
    <tr>
        <td align="center" colspan="6"><br><br><br><br></td> <!-- Baris kosong dengan <br> -->
    </tr>
    <tr>
        <td align="center" style="width:25%;">(--------------------)</td>
        <td align="left" style="width:25%;"></td>
        <td align="left" style="width:25%;"></td>
        <td align="center" style="width:25%;">( <?php echo $userid['user_nama'];?> )</td>
    </tr>
    <tr>
    </tr>
</table>



<table align="center" style="width:700px; border:none;">
    <tr>
        <td style="width: 50%; text-align:left; font-weight:normal;">
            <u>Transfer melalui Bank :</u><br>
            <?php echo $userid['co_rek_a'];?><br>
            <?php echo $userid['co_rek_b'];?>
        </td>
        <td style="width: 50%; text-align:left;padding-left:5px; font-weight:normal; border: 1px solid black;">
            PERHATIAN !!<br>
            Barang yang sudah dibeli tidak dapat ditukar/dikembalikan
        </td>
    </tr>
</table>


</div>






</body>
</html>

