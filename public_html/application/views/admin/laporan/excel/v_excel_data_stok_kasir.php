<!DOCTYPE html>
<html>
<head>
    <?php 
	error_reporting(0);
    $userid=$userid->row_array();
    ?>
    <title>Data Stok Barang</title>
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
    <p><b> DATA STOK BARANG - <?php echo strtoupper($namacab);?> - PERIODE <?php echo strtoupper($nm_bln);?> <?php echo strtoupper($thn);?></b></p>
    <table width="100%">
    <thead>
        <tr>
            <th rowspan="2" style="text-align:center;vertical-align:middle;">No</th>
            <th rowspan="2" style="text-align:center;vertical-align:middle;">Kode Barang</th>
            <th rowspan="2" style="max-width:200px;text-align:center;vertical-align:middle;">Nama Barang</th>
            <th colspan="5" style="text-align:center;vertical-align:middle;">STOK</th>
            <th rowspan="2" style="text-align:center;vertical-align:middle;">Harga Jual</th>
            <th rowspan="2" style="text-align:center;vertical-align:middle;">Total Harga Jual</th>
            <th rowspan="2" style="text-align:center;vertical-align:middle;">Satuan</th>
            <th rowspan="2" style="text-align:center;vertical-align:middle;">Kategori</th>
        </tr>  
        <tr>
            <th style="text-align:center;color:#4f81bd;">Awal</th>
            <th style="text-align:center;color:#c0504d;">Penambahan</th>
            <th style="text-align:center;color:#9bbb59;">Pengurangan</th>
            <th style="text-align:center;color:#ee0e0e;">Retur</th>
            <th style="text-align:center;color:#FFD700;">Akhir</th>
        </tr>
    </thead>
    <tbody>
    <?php 
        $no=0;
        foreach ($data->result_array() as $a):
            $no++;
            $id=$a['barang_id'];
            $nm=$a['barang_nama'];
            $harjul=$a['barang_harjul'];
            $totharjul=$a['Total_Harjul'];
            $satuan=$a['barang_satuan'];
            $kategori=$a['barang_kategori_nama'];
            $stok_akhir=$a['stok_cabang'];
            $stok_awal=$a['stok_awal'];
            $stok_tambah=$a['stok_tambah'];
            $stok_kurang=$a['stok_kurang'];
            $retur=$a['retur'];
            
    ?>
        <tr>
            <td style="text-align:center;"><?php echo $no;?></td>
            <td><?php echo $id;?></td>
            <td style="max-width:200px;overflow:hidden;"><?php echo $nm;?></td>
            <td style="text-align:center;"><?php echo number_format($stok_awal);?></td>
            <td style="text-align:center;"><?php echo number_format($stok_tambah);?></td>
            <td style="text-align:center;"><?php echo number_format($stok_kurang);?></td>
            <td style="text-align:center;"><?php echo number_format($retur);?></td>
            <td style="text-align:center;"><?php echo number_format($stok_akhir);?></td>
            <td style="text-align:right;"><?php echo number_format($harjul); ?></td>
            <td style="text-align:right;"><?php echo number_format($totharjul); ?></td>
            <td style="text-align:center;"><?php echo $satuan;?></td>
            <td style="text-align:center;"><?php echo $kategori;?></td>
                
        </tr>
    <?php endforeach;?>
    </tbody>
    </table>
</body>
</html>
