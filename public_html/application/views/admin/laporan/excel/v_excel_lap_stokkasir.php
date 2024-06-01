<!DOCTYPE html>
<html>
<head>
    <?php 
	error_reporting(0);
    $userid=$userid->row_array();
    //$userid=$userid->row_array();
    ?>  
    <title>Laporan Stok Barang <?php echo $userid['reg_name'];?></title>
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
    <p> LAPORAN STOK BARANG PERKATEGORI <?php echo strtoupper($userid['reg_code']);?>  <?php echo strtoupper($userid['reg_name']);?></p>
    <table width="100%">
    <?php 
    $coid=$co_id;
    $urut=0;
    $nomor=0;
    $group='-';
    $regid = $userid['reg_id'];
    foreach($data->result_array()as $d){
    $nomor++;
    $urut++;
    if($group=='-' || $group!=$d['kategori_nama']){
        $kat=$d['kategori_nama'];
        $query=$this->db->query("SELECT k.kategori_nama,
            IFNULL(
                SUM(CASE WHEN s.stok_regid = '$regid' AND s.stok_in > 0 THEN s.stok_in ELSE 0 END) -
                SUM(CASE WHEN s.stok_regid = '$regid' AND s.stok_out > 0 THEN s.stok_out ELSE 0 END), 0) 
            AS tot_stok
            FROM tbl_kategori k
            LEFT JOIN tbl_barang b ON k.kategori_id = b.barang_kategori_id
            LEFT JOIN tbl_stok s ON b.barang_id = s.brg_id
            WHERE b.barang_co_id = '$coid' AND k.kategori_nama ='$kat'
            GROUP BY k.kategori_nama;
        ");
        $t=$query->row_array();
        $tots=$t['tot_stok'];
        if (floor($tots) == $tots) {
            $formatted_tots = number_format($tots, 0, ',', '.');
        } else {
            $formatted_tots = number_format($tots, 2, ',', '.');
            $formatted_tots = rtrim($formatted_tots, '0');
            $formatted_tots = rtrim($formatted_tots, ',');
        }

        if($group!='-'){
        echo '<tr class="category-end"></tr>';
        }
        echo '<tr><td colspan="4" style="text-align:left"><b>Kategori: '.$kat.' </b></td> <td style="text-align:center;"><b>Total Stok: '.$formatted_tots. '</b></td></tr>';
        echo '<tr style="background-color:#ccc;">';
        echo '<td style="width:50px;text-align: center;"><b>No</b></td>';
        echo '<td style="width:100px;text-align: center;"><b>Kode Barang</b></td>';
        echo '<td style="width:300px;text-align: center;"><b>Nama Barang</b></td>';
        echo '<td style="width:100px;text-align: center;"><b>Satuan</b></td>';
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
            <td style="vertical-align:center;text-align:center;"><?php echo $d['stok_cabang']; ?></td>  
        </tr>
        <?php
        }
        echo '<tr class="category-end"></tr>';
        ?>
</table>
</body>
</html>
