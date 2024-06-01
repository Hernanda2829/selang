<html lang="en" moznomarginboxes mozdisallowselectionprint>
<head>
    <?php 
	error_reporting(0);
    $userid=$userid->row_array();
    ?>
    <title>Data Stok Barang</title>
    <link rel="shortcut icon" href="<?php echo base_url().'assets/img/'. $userid['co_imgicon']; ?>" alt="#no image#" type="image/x-icon">
    <meta charset="utf-8">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/laporan.css')?>"/>

<style>
    @media print {
        @page {
            size: landscape;  
            margin: 0;
        }
        body {
            margin: 50;
        }
        
    }

    .page-break {
        page-break-before: always;
        
    }

    
       
  .curved-image {
    width: 210px; /* Mengatur lebar gambar */
    height: 50px; /* Mengatur tinggi gambar */
    border-radius: 50%; /* Membuat gambar melengkung (lingkaran) */
    object-fit: cover; /* Mengatur cara gambar diatur di dalam area */
  }
</style>
</head>

<body onload="window.print()">
<div id="laporan">
<table border="0" align="center" style="width:700px;border:none;margin-top:5px;margin-bottom:0px;">
    <tr>
        <td><img src="<?php echo base_url().'assets/img/'. $userid['co_imglogo']; ?>" style="margin-bottom:10px" alt="Curved Image" class="curved-image"/></td>
        <td style="width:750px; padding-left:0px;">
            <center>
                <h4 style="margin: 0; margin-left: -110px;">DATA STOK BARANG <?php echo strtoupper($namacab);?></h4>
                <h4 style="margin: 0; margin-left: -110px;">PERIODE <?php echo strtoupper($nm_bln);?> <?php echo strtoupper($thn);?></h4>
            </center>
        </td>
    </tr>
</table>

<div class="row">
    <div class="col-lg-12">
        <table border="1" align="center" style="width:700px;margin-bottom:20px;">
            <thead>
                <tr>
                    <th rowspan="2" style="text-align:center;vertical-align:middle;">No</th>
                    <th rowspan="2" style="text-align:center;vertical-align:middle;">Kode Barang</th>
                    <th rowspan="2" style="max-width:200px;text-align:center;vertical-align:middle;">Nama Barang</th>
                    <th colspan="5" style="text-align:center;color:white;background-color:grey;">STOK</th>
                    <th rowspan="2" style="text-align:center;vertical-align:middle;">Harga Bottom</th>
                    <th rowspan="2" style="text-align:center;vertical-align:middle;">Harga Pricelist</th>
                    <th rowspan="2" style="text-align:center;vertical-align:middle;">Total Bottom</th>
                    <th rowspan="2" style="text-align:center;vertical-align:middle;">Total Pricelist</th>
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
                    $harpok=$a['barang_harpok'];
                    $harjul=$a['barang_harjul'];
                    $totharpok=$a['Total_Harpok'];
                    $totharjul=$a['Total_Harjul'];
                    $satuan=$a['barang_satuan'];
                    $kategori=$a['barang_kategori_nama'];

                    $stok=$a['stok_cabang'];
                    if (floor($stok) == $stok) {
                        $formatted_stok = number_format($stok, 0, ',', '.');
                    } else {
                        $formatted_stok = number_format($stok, 2, ',', '.');
                        $formatted_stok = rtrim($formatted_stok, '0');
                        $formatted_stok = rtrim($formatted_stok, ',');
                    }   

                    $stok_awal=$a['stok_awal'];
                    if (floor($stok_awal) == $stok_awal) {
                        $formatted_stok_awal = number_format($stok_awal, 0, ',', '.');
                    } else {
                        $formatted_stok_awal = number_format($stok_awal, 2, ',', '.');
                        $formatted_stok_awal = rtrim($formatted_stok_awal, '0');
                        $formatted_stok_awal = rtrim($formatted_stok_awal, ',');
                    }
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
                    <td style="text-align:center;"><?php echo $formatted_stok_awal;?></td>
                    <td style="text-align:center;"><?php echo $formatted_stok_tambah;?></td>
                    <td style="text-align:center;"><?php echo $formatted_stok_kurang;?></td>
                    <td style="text-align:center;"><?php echo $formatted_retur;?></td>
                    <td style="text-align:center;"><?php echo $formatted_stok;?></td>
                    <td style="text-align:right;"><?php echo 'Rp ' . str_replace(',', '.', number_format($harpok)); ?></td>
                    <td style="text-align:right;"><?php echo 'Rp ' . str_replace(',', '.', number_format($harjul)); ?></td>
                    <td style="text-align:right;"><?php echo 'Rp ' . str_replace(',', '.', number_format($totharpok)); ?></td>
                    <td style="text-align:right;"><?php echo 'Rp ' . str_replace(',', '.', number_format($totharjul)); ?></td>
                    <td style="text-align:center;"><?php echo $satuan;?></td>
                    <td style="text-align:center;"><?php echo $kategori;?></td>
                        
                </tr>
            <?php endforeach;?>
            </tbody>
        </table>
    </div>
</div>


<br>
<table align="center" style="width:700px;border:none;margin-bottom:20px;">
    <tr>
        <td colspan="6" style="text-align: center;"></td>
    </tr>
    <tr>
        <td align="left" style="width:25%;"></td>
        <td align="center" style="width:25%;"></td>
        <td align="center" style="width:25%;"></td>
        <td align="center" style="width:25%;"><?php echo $userid['reg_name'];?> , <?php echo date('d-M-Y')?></td>       
    </tr>
    <tr>
        <td align="center" colspan="6"><br><br><br><br></td> <!-- Baris kosong dengan <br> -->
    </tr>
    <tr>
        <td align="left" style="width:25%;"></td>
        <td align="left" style="width:25%;"></td>
        <td align="left" style="width:25%;"></td>
        <td align="center" style="width:25%;">( <?php echo $userid['user_nama'];?> )</td>
    </tr>
    <tr>
    </tr>
</table>

</div>








</body>
</html>