<!DOCTYPE html>
<html>
<head>
    <?php 
	error_reporting(0);
    $userid=$userid->row_array();
    ?>
    <title>Akumulasi Harga Stok Barang</title>
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
    <p> AKUMULASI HARGA STOK BARANG PERIODE <?php echo strtoupper($nm_bln);?> <?php echo strtoupper($thn);?></p>
    <table width="100%">
    <thead>
        <tr>
            <th rowspan="2" style="text-align:center;vertical-align:middle;color:white;background-color:#eb1b28;">No</th>
            <th rowspan="2" style="text-align:center;vertical-align:middle;color:white;background-color:#eb1b28;">Cabang</th>
            <?php foreach ($kategori as $k): ?>
                <th colspan="3" style="text-align:center;color:white;background-color:black"><?php echo $k['kategori_nama'];?></th>
            <?php endforeach; ?>
            <th rowspan="2" style="text-align:center;vertical-align:middle;color:white;background-color:#027c3f;">Total Bottom</th>
            <th rowspan="2" style="text-align:center;vertical-align:middle;color:white;background-color:#027c3f;">Total Pricelist</th>

        </tr>
        <tr>
            <?php foreach ($kategori as $k): ?>
                <th style="text-align:center;color:#4f81bd;background-color:white">Stok</th>
                <th style="text-align:center;color:#c0504d;background-color:white">Bottom</th>
                <th style="text-align:center;color:#9bbb59;background-color:white">Pricelist</th>
            <?php endforeach; ?>
        </tr>
        
        <tr>
            <th colspan="2" style="text-align:right;font-weight:bold;color:white;background-color:#027c3f;">Grand Total</th>
            <?php 
            $grandTotalStok = $grandTotalHarpok = $grandTotalHarjul = 0;
            foreach ($kategori as $k):  
                $kat = $k['kategori_id'];
                $totalStok = $totalHarpok = $totalHarjul = 0;
                foreach ($data->result_array() as $a):
                    $totalStok += $a['stok_global_' . $kat];
                    $totalHarpok += $a['Total_Harpok_' . $kat];
                    $totalHarjul += $a['Total_Harjul_' . $kat];
                endforeach;
                $grandTotalStok += $totalStok;
                $grandTotalHarpok += $totalHarpok;
                $grandTotalHarjul += $totalHarjul;
                ?>
                <th style="text-align:right;font-weight:bold;color:white;background-color:#027c3f"><?php echo number_format($totalStok);?></th>
                <th style="text-align:right;font-weight:bold;color:white;background-color:#027c3f"><?php echo number_format($totalHarpok);?></th>
                <th style="text-align:right;font-weight:bold;color:white;background-color:#027c3f"><?php echo number_format($totalHarjul);?></th>
            <?php endforeach; ?>
            <!-- Tambahkan dua kolom di samping kanan -->
                <th style="text-align:right;font-weight:bold;color:white;background-color:#027c3f"><?php echo number_format($grandTotalHarpok);?></th>
                <th style="text-align:right;font-weight:bold;color:white;background-color:#027c3f"><?php echo number_format($grandTotalHarjul);?></th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $no = 0;
        foreach ($data->result_array() as $a):
            $no++;
            $id = $a['reg_id'];
            $cab = $a['reg_name'];
        ?>
            <tr>
                <td style="text-align:center;"><?php echo $no;?></td>
                <td><?php echo $cab;?></td>
                <?php 
                $totalStok = $totalHarpok = $totalHarjul = 0;
                foreach ($kategori as $k):  
                    $kat = $k['kategori_id'];
                    $totalStok += $a['stok_global_' . $kat];
                    $totalHarpok += $a['Total_Harpok_' . $kat];
                    $totalHarjul += $a['Total_Harjul_' . $kat];
                ?>
                    <td style="text-align:right;"><?php echo number_format($a['stok_global_' . $kat]);?></td>
                    <td style="text-align:right;"><?php echo number_format($a['Total_Harpok_' . $kat]);?></td>
                    <td style="text-align:right;"><?php echo number_format($a['Total_Harjul_' . $kat]);?></td>
                <?php endforeach; ?>

                <td style="text-align:right;background-color:#f2f2f2;"><?php echo number_format($totalHarpok);?></td>
                <td style="text-align:right;background-color:#f2f2f2;"><?php echo number_format($totalHarjul);?></td>
            </tr>
        <?php endforeach;?>
    </tbody> 
    </table>
</body>
</html>
