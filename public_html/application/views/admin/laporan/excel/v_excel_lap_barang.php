<!DOCTYPE html>
<html>
<head>
    <?php 
	error_reporting(0);
    $reg_id=$id_reg->row_array();
    ?>  
    <title>Laporan Data Barang <?php echo $reg_id['reg_name'];?></title>
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
    <p> LAPORAN DATA BARANG <?php echo strtoupper($reg_id['reg_code']);?>  <?php echo strtoupper($reg_id['reg_name']);?></p>
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
        
        if($group!='-'){
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
                <td style="vertical-align:center;text-align:center;"><?php echo $nomor; ?></td>
                <td style="vertical-align:center;padding-left:5px;text-align:center;"><?php echo $d['barang_id']; ?></td>
                <td style="vertical-align:center;padding-left:5px;"><?php echo $d['barang_nama']; ?></td>
                <td style="vertical-align:center;text-align:center;"><?php echo $d['barang_satuan']; ?></td>
                <td style="vertical-align:center;padding-right:5px;text-align:right;"><?php echo number_format($d['barang_harpok']); ?></td>
                <td style="vertical-align:center;padding-right:5px;text-align:right;"><?php echo number_format($d['barang_harjul']); ?></td>
                <td style="vertical-align:center;text-align:center;"><?php echo $d['stok_cabang']; ?></td>
        </tr>
        <?php
        }
        echo '<tr class="category-end"></tr>';
        ?>
</table>
</body>
</html>
