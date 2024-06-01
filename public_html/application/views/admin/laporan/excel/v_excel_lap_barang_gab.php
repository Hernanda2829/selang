<!DOCTYPE html>
<html>
<head>
    <title>Laporan Data Barang All</title>
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
    <p> LAPORAN DATA BARANG GABUNGAN (GLOBAL)</p>
    <table width="100%">
    <?php 
    $urut=0;
    $nomor=0;
    $group='-';
    foreach($data->result_array()as $d){
    $nomor++;
    $urut++;
    if($group=='-' || $group!=$d['kategori_nama']){
        $kat=$d['kategori_nama'];
        
        if($group!='-') {
        echo '<tr class="category-end"></tr>';
        }
        echo '<tr><td colspan="7"><b>Kategori: '.$kat.' </b></td> </tr>';
        echo '<tr style="background-color:#ccc;">';
        echo '<td style="width:50px;text-align: center;"><b>No</b></td>';
        echo '<td style="width:100px;text-align: center;"><b>Kode Barang</b></td>';
        echo '<td style="width:300px;text-align: center;"><b>Nama Barang</b></td>';
        echo '<td style="width:100px;text-align: center;"><b>Satuan</b></td>';
        echo '<td style="width:150px;text-align: center;"><b>Harga Pokok(Rp)</b></td>';
        echo '<td style="width:150px;text-align: center;"><b>Harga Jual(Rp)</b></td>';
        echo '<td style="width:150px;text-align: center;"><b>Stok</td>';
        echo '</tr>';
    $nomor=1;
    }
    $group=$d['kategori_nama'];
        if($urut==500){
        $nomor=0;
            echo "<div class='pagebreak'> </div>";
        }
        ?>
            <tr>
                <td style="text-align:center;"><?php echo $nomor; ?></td>
                <td style="text-align:center;"><?php echo $d['barang_id']; ?></td>
                <td style="text-align:left;"><?php echo $d['barang_nama']; ?></td>
                <td style="text-align:center;"><?php echo $d['barang_satuan']; ?></td>
                <td style="text-align:right;"><?php echo number_format($d['barang_harpok']); ?></td>
                <td style="text-align:right;"><?php echo number_format($d['barang_harjul']); ?></td>
                <td style="text-align:right;"><?php echo $d['stok_global']; ?></td>
            </tr>
            <?php
            }
            echo '<tr class="category-end"></tr>';
            ?>    
</table>
</body>
</html>
