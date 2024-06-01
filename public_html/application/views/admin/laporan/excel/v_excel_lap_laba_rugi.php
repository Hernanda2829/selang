<!DOCTYPE html>
<html>
<head>
    <?php 
	error_reporting(0);
    //$userid=$userid->row_array();
    $reg_id=$id_reg->row_array();
    $b=$jml->row_array();
    if ($lap=="lapgab") {
        $ket1="All";
        $ket2="GABUNGAN (GLOBAL)";
    }elseif ($lap=="lapcab") {
        $ket1=$reg_id['reg_name'];
        $ket2=$reg_id['reg_code']." ".$reg_id['reg_name'];
    }
    ?>
    <title>Laporan Laba/Rugi <?php echo $ket1;?></title>
</head>
<body>
    <p> LAPORAN LABA / RUGI <?php echo strtoupper($ket2);?><br>
        Bulan : <?php echo $b['bulan'];?>
    </p>
    <table border="1" width="100%">
        <thead>
            <tr>
                <td style="text-align: center;"><b>No</td>
                <td style="text-align: center;"><b>Tanggal</td>
                <td style="text-align: center;"><b>Nama Barang</td>
                <td style="text-align: center;"><b>Satuan</td>
                <td style="text-align: center;"><b>Harga Pokok(Rp)</td>
                <td style="text-align: center;"><b>Harga Jual(Rp)</td>
                <td style="text-align: center;"><b>Laba Per Unit(Rp)</td>
                <td style="text-align: center;"><b>Item Terjual</td>
                <td style="text-align: center;"><b>Diskon(Rp)</td>
                <td style="text-align: center;"><b>Untung Bersih(Rp)</td>
                <td style="text-align: center;"><b>User</td>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 0;
            foreach ($data->result_array() as $i) {
                $no++;
                $tgl = $i['jual_tanggal'];
                $nabar = $i['d_jual_barang_nama'];
                $satuan = $i['d_jual_barang_satuan'];
                $harpok = $i['d_jual_barang_harpok'];
                $harjul = $i['d_jual_barang_harjul'];
                $untung_perunit = $i['keunt'];
                $qty = $i['d_jual_qty'];
                $diskon = $i['d_jual_diskon'];
                $untung_bersih = $i['untung_bersih'];
                $created_by = $i['created_by'];
            ?>
            <tr>
                <td style="text-align:center;"><?php echo $no;?></td>
                <td style="text-align:center;"><?php echo $tgl;?></td>
                <td style="text-align:left;"><?php echo $nabar;?></td>
                <td style="text-align:left;"><?php echo $satuan;?></td>
                <td style="text-align:right;"><?php echo number_format($harpok);?></td>
                <td style="text-align:right;"><?php echo number_format($harjul);?></td>
                <td style="text-align:right;"><?php echo number_format($untung_perunit);?></td>
                <td style="text-align:center;"><?php echo $qty;?></td>
                <td style="text-align:right;"><?php echo number_format($diskon);?></td>
                <td style="text-align:right;"><?php echo number_format($untung_bersih);?></td>
                <td style="text-align:center;"><?php echo $created_by;?></td>
            </tr>
            <?php
            }
            ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="9" style="text-align:right;padding-right:5px;"><b>Total Keuntungan</b></td>
                <td style="text-align:right;"><b><?php echo number_format($b['total']);?></b></td>
            </tr>
        </tfoot>
    </table>
</body>
</html>
