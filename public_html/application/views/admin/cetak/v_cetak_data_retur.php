<html lang="en" moznomarginboxes mozdisallowselectionprint>
<head>
    <?php 
	error_reporting(0);
    $userid=$userid->row_array();
    ?>
    <title>Laporan Data Retur <?php echo $userid['reg_name'];?></title>
    <link rel="shortcut icon" href="<?php echo base_url().'assets/img/'. $userid['co_imgicon']; ?>" alt="#no image#" type="image/x-icon">
    <meta charset="utf-8">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/laporan.css')?>"/>

<style>
    @media print {
        @page {  
            margin: 0;
        }
        body {
            margin: 50;
        }
    }
    
    .total-grup-row {
    visibility: collapse;
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
<table border="0" align="center" style="width:700px; border:none;margin-top:5px;margin-bottom:0px;">
    <tr>
        <td><img src="<?php echo base_url().'assets/img/'. $userid['co_imglogo']; ?>" style="margin-bottom:10px" alt="Curved Image" class="curved-image"/></td>
        <td style="width:700px; padding-left:0px;">
            <center>
                <h4 style="margin: 0; margin-left: -110px;">LAPORAN DATA RETUR BARANG</h4>
                <h4 style="margin: 0; margin-left: -110px;">PERIODE <?php echo date('d/m/Y', strtotime($tgl1)) .' S/d '. date('d/m/Y', strtotime($tgl2)) ;?> </h4>
            </center>
        </td>
    </tr>
</table>

<table border="0" align="center" style="width:700px;border:none;">
        <tr>
            <th style="text-align:left"></th>
        </tr>
</table>

<div class="row">
    <div class="col-lg-12">        
        <table border="1" align="center" style="width:700px;margin-bottom:20px;">
            <thead>
            <tr>
                <th style="text-align:center;">No</th>
                <th>Tanggal</th>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th style="text-align:center;">Satuan</th>
                <th style="text-align:center;">Kategori</th>
                <th style="text-align:center;">Harga Bottom</th>
                <th style="text-align:center;">Jumlah</th>
                <th style="text-align:center;">Subtotal (Rp)</th>
                <th style="text-align:center;">Keterangan</th>
                <th style="text-align:center;">Cabang</th>
            </tr>
        </thead>
        <tbody>             
            <?php
                $no=0; 
                $totalHargaBottom = 0;
                $totalSubtotal = 0;
                foreach ($data_retur as $d):
                $no++;
                $totalHargaBottom += $d['retur_harpok'];
                $totalSubtotal += $d['retur_subtotal'];
            ?>
                        
            <tr>
                <td style="text-align:center;"><?php echo $no;?></td>
                <td><?php echo $d['retur_tgl'];?></td>
                <td><?php echo $d['retur_brg_id'];?></td>
                <td style="text-align:left;"><?php echo $d['retur_brg_nama'];?></td>
                <td style="text-align:center;"><?php echo $d['retur_brg_sat'];?></td>
                <td style="text-align:center;"><?php echo $d['retur_brg_kat'];?></td>
                <td style="text-align:right;padding-right:3px;"><?php echo number_format($d['retur_harpok'],0, ',' ,'.'); ?></td>
                <?php 
                $qty=$d['retur_qty'];
                if (floor($qty) == $qty) {
                    $formatted_qty = number_format($qty, 0, ',', '.');
                } else {
                    $formatted_qty = number_format($qty, 2, ',', '.');
                    $formatted_qty = rtrim($formatted_qty, '0');
                    $formatted_qty = rtrim($formatted_qty, ',');
                }
                echo '<td style="text-align:center;">'.$formatted_qty.'</td>';
                ?>  
                <td style="text-align:right;padding-right:3px;"><?php echo number_format($d['retur_subtotal'],0, ',' ,'.'); ?></td>
                <td style="text-align:center;"><?php echo $d['retur_keterangan'];?></td>
                <td style="text-align:center;"><?php echo $d['reg_name'];?></td>
            </tr>    
            <?php endforeach; ?>
            <tr>
                <td colspan="6" style="text-align:right;padding-right:5px;"><b>Total:</b></td>
                <td style="text-align:right;padding-right:3px;"><b><?php echo number_format($totalHargaBottom, 0, ',', '.'); ?></b></td>
                <td></td>
                <td style="text-align:right;padding-right:3px;"><b><?php echo number_format($totalSubtotal, 0, ',', '.'); ?></b></td>
                <td></td>
            </tr>
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