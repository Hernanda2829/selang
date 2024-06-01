<!DOCTYPE html>
<html>
<head>
    <?php 
	error_reporting(0);
    $b=$jml->row_array();
    if ($lap=="laptgl") {
        $ket="Pertanggal";
    }elseif ($lap=="lapbln") {
        $ket="Perbulan";
    }elseif ($lap=="lapthn") {
        $ket="Pertahun";
    }
    ?>
    <title>Lap Penjualan <?php echo $ket;?> All</title>
</head>
<body>
    <p> LAPORAN PENJUALAN <?php echo strtoupper($ket);?> GABUNGAN (GLOBAL)  <br>
    <?php 
    if ($lap=="laptgl") {
        echo 'Tanggal : '. $b['jual_tanggal'];
    }elseif ($lap=="lapbln") {
        echo 'Bulan : '. $b['bulan'];
    }elseif ($lap=="lapthn") {
        echo 'Tahun : '. $b['tahun'];
    }
    ?>
    </p>
    <table border="1" width="100%">
        <thead>
            <tr>
                <td style="text-align: center;"><b>No</td>
                <td style="text-align: center;"><b>No Faktur</td>
                <td style="text-align: center;"><b>Tanggal</td>
                <td style="text-align: center;"><b>Kode Barang</td>
                <td style="text-align: center;"><b>Nama Barang</td>
                <td style="text-align: center;"><b>Satuan</td>
                <td style="text-align: center;"><b>Harga Jual(Rp)</td>
                <td style="text-align: center;"><b>QTY</td>
                <td style="text-align: center;"><b>Diskon(Rp)</td>
                <td style="text-align: center;"><b>Total(Rp)</td>
                <td style="text-align: center;"><b>User</td>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 0;
            foreach ($data->result_array() as $i) {
                $no++;
                $nofak=$i['jual_nofak'];
                $tgl=$i['jual_tanggal'];
                $barang_id=$i['d_jual_barang_id'];
                $barang_nama=$i['d_jual_barang_nama'];
                $barang_satuan=$i['d_jual_barang_satuan'];
                $barang_harjul=$i['d_jual_barang_harjul'];
                $barang_qty=$i['d_jual_qty'];
                $barang_diskon=$i['d_jual_diskon'];
                $barang_total=$i['d_jual_total'];
                $created_by=$i['created_by'];
            ?>
            <tr>
                <td style="text-align:center;"><?php echo $no;?></td>
                <td style="text-align:left;padding-left:5px;"><?php echo $nofak;?></td>
                <td style="text-align:center;"><?php echo $tgl;?></td>
                <td style="text-align:center;"><?php echo $barang_id;?></td>
                <td style="text-align:left;"><?php echo $barang_nama;?></td>
                <td style="text-align:left;"><?php echo $barang_satuan;?></td>
                <td style="text-align:right;"><?php echo number_format($barang_harjul);?></td>
                <td style="text-align:center;"><?php echo $barang_qty;?></td>
                <td style="text-align:right;"><?php echo number_format($barang_diskon);?></td>
                <td style="text-align:right;"><?php echo number_format($barang_total);?></td>
                <td style="text-align:center;"><?php echo $created_by;?></td>
            </tr>
            <?php
            }
            ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="9" style="text-align:right;padding-right:5px;"><b>Total </b></td>
                <td style="text-align:right;"><b><?php echo number_format($b['total']);?></b></td>
            </tr>
        </tfoot>
    </table>
</body>
</html>
