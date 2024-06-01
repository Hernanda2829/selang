<!DOCTYPE html>
<html>
<head>
    <?php 
	error_reporting(0);
    $userid=$userid->row_array();
    ?>
    <title>Rekap Tempo</title>
<style>
    table {
        width: 100%;
        border-collapse: collapse;
    }

    td, th {
        border: 0.5pt solid black;
        padding: 10px;
    }

    .category-end {
        border-bottom: 0;
    }
</style>
</head>
<body>
    <p><b> Rekap Penjualan Tempo <?php echo strtoupper($cab);?> <?php echo strtoupper($blnthn);?></b></p>
    <table width="100%">
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
    </tr>
    </thead>
    <tbody>
        <?php
            $no=0; 
            foreach ($data as $d):
            $no++;
        ?>
                
        <tr>
            <td style="text-align:center;"><?php echo $no;?></td>
            <td style="text-align:center;"><?php echo $d['jual_tanggal'];?></td>
            <td><?php echo $d['jual_nofak'];?></td>
            <td><?php echo $d['jual_cust_nama'];?></td>
            <td style="text-align:center;"><?php echo $d['jual_bulan_tempo'];?></td>
            <td style="text-align:center;"><?php echo $d['jual_tgl_tempo'];?></td>
            <td style="text-align:right;"><?php echo number_format($d['jual_total']);?></td>
            <td style="text-align:right;"><?php echo number_format($d['sudah_bayar']);?></td>
            <td style="text-align:right;"><?php echo number_format($d['kurang_bayar']);?></td>
            <td style="text-align:center;"><?php echo $d['telat_hari'];?></td>
        </tr>    
        <?php endforeach; ?>
    </tbody>
    </table>
</body>
</html>
