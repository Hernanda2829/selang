<!DOCTYPE html>
<html>
<head>
    <?php 
	error_reporting(0);
    $userid=$userid->row_array();
    ?>
    <title>History Stok Barang</title>
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
    <p><b> HISTORY STOK BARANG <?php echo strtoupper($namacab);?> TANGGAL TRANSAKSI <?php echo strtoupper($today);?> </b></p>
    <table width="100%">
    <thead> 
        <tr>
            <th style="text-align:center;vertical-align:middle;">No</th>
            <th style="text-align:center;vertical-align:middle;">Kode Barang</th>
            <th style="max-width:200px;text-align:center;vertical-align:middle;">Nama Barang</th>
            <th style="text-align:center;vertical-align:middle;">Penambahan Stok</th>
            <th style="text-align:center;vertical-align:middle;">Pengurangan Stok</th>
            <th style="text-align:center;vertical-align:middle;">Retur</th>
            <th style="text-align:center;vertical-align:middle;">Satuan</th>
            <th style="text-align:center;vertical-align:middle;">Kategori</th>
        </tr>  
    </thead>
    <tbody>
    <?php 
        $no=0;
        foreach ($data->result_array() as $a):
            $no++;
            $id=$a['barang_id'];
            $nm=$a['barang_nama'];
            $satuan=$a['barang_satuan'];
            $kategori=$a['barang_kategori_nama'];
            $stok_tambah=$a['stok_tambah'];
            if (floor($stok_tambah) == $stok_tambah) {
                $formatted_stok_tambah = number_format($stok_tambah, 0, ',', '.');
            } else {
                $formatted_stok_tambah = number_format($stok_tambah, 2, ',', '.');
                $formatted_stok_tambah = rtrim($formatted_stok_tambah, '0');
                $formatted_stok_tambah = rtrim($formatted_stok_tambah, ',');
            }
            $stok_kurang=$a['stok_kurang'];
            if (floor($stok_kurang) == $stok_kurang) {
                $formatted_stok_kurang = number_format($stok_kurang, 0, ',', '.');
            } else {
                $formatted_stok_kurang = number_format($stok_kurang, 2, ',', '.');
                $formatted_stok_kurang = rtrim($formatted_stok_kurang, '0');
                $formatted_stok_kurang = rtrim($formatted_stok_kurang, ',');
            }
            $retur=$a['retur'];
            if (floor($retur) == $retur) {
                $formatted_retur = number_format($retur, 0, ',', '.');
            } else {
                $formatted_retur = number_format($retur, 2, ',', '.');
                $formatted_retur = rtrim($formatted_retur, '0');
                $formatted_retur = rtrim($formatted_retur, ',');
            }
    ?>
        <tr>
            <td style="text-align:center;"><?php echo $no;?></td>
            <td><?php echo $id;?></td>
            <td style="max-width:200px;overflow:hidden;"><?php echo $nm;?></td>
            <td style="text-align:center;"><?php echo $formatted_stok_tambah;?></td>
            <td style="text-align:center;"><?php echo $formatted_stok_kurang;?></td>
            <td style="text-align:center;"><?php echo $formatted_retur;?></td>
            <td style="text-align:center;"><?php echo $satuan;?></td>
            <td style="text-align:center;"><?php echo $kategori;?></td>
            
            
        </tr>
    <?php endforeach;?>
    </tbody>
</table>
</body>
</html>
