<!DOCTYPE html>
<html>
<head>
    <?php 
	error_reporting(0);
    $userid=$userid->row_array();
    ?>
    <title>Rekap Stok Barang</title>
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
    <p><b> REKAP STOK BARANG - <?php echo strtoupper($nmcab);?> - PERIODE <?php echo strtoupper($nm_bln);?> <?php echo strtoupper($thn);?></b></p>
    <table width="100%">
    <thead>
        <tr>
            <th style="text-align:center">No</th>
            <th style="text-align:center">Kode Barang</th>
            <th style="text-align:center">Nama Barang</th>
            <th style="text-align:center">Satuan</th>
            <th style="text-align:center">Harga Bottom</th>
            <th style="text-align:center">Harga Pricelist</th>
            <th style="text-align:center">Stok</th>
            <th style="text-align:center">Total Bottom</th>
            <th style="text-align:center">Total Pricelist</th>
            <th style="text-align:center">Kategori</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $no=0;
        $total_totharpok = 0;
        $total_totharjul = 0;

        foreach ($data as $d):
            $no++;
            $kd=$d['barang_id'];
            $nm=$d['barang_nama'];
            $sat=$d['barang_satuan'];
            $harpok=$d['barang_harpok'];
            $harjul=$d['barang_harjul'];
            $stok=$d['stok_cabang']; 
            $totharpok=$d['Total_Harpok'];
            $totharjul=$d['Total_Harjul'];
            $kat=$d['barang_kategori_nama'];

            $total_totharpok += $totharpok;
            $total_totharjul += $totharjul;
            
        ?>
    <tr>
        <td style="text-align:center;"><?php echo $no;?></td>
        <td><?php echo $kd;?></td>
        <td><?php echo $nm;?></td>
        <td style="text-align:center;"><?php echo $sat;?></td>
        <td style="text-align:right;padding-right:3px;"><?php echo number_format($harpok);?></td>
        <td style="text-align:right;padding-right:3px;"><?php echo number_format($harjul);?></td>
        <td style="text-align:center;"><?php echo number_format($stok);?></td>
        <td style="text-align:right;padding-right:3px;"><?php echo number_format($totharpok);?></td>
        <td style="text-align:right;padding-right:3px;"><?php echo number_format($totharjul);?></td>
        <td style="text-align:center;"><?php echo $kat;?></td>
        
    </tr>    
    <?php endforeach;?>
    <!-- Baris total -->
    <tr>
        <td colspan="7" style="text-align:right;padding-right:5px;"><strong>Total : </strong></td>
        <td style="text-align:right;padding-right:3px;"><strong><?php echo number_format($total_totharpok);?></strong></td>
        <td style="text-align:right;padding-right:3px;"><strong><?php echo number_format($total_totharjul);?></strong></td>
        <td></td> <!-- Kolom Kategori tidak ditambahkan pada total -->
    </tr>
    </tbody>
    </table>
</body>
</html>
