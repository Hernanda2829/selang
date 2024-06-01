<html lang="en" moznomarginboxes mozdisallowselectionprint>
<head>
    <?php 
	error_reporting(0);
    $userid=$userid->row_array();
    $ks=$transtok->row_array();
    ?>
    <title>Cetak Terima/Konfirm Stok <?php echo $userid['reg_name'];?></title>
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
                <h4 style="margin: 0; margin-left: -110px;">TERIMA/KONFIRM STOK <?php echo strtoupper($userid['reg_code']);?>  <?php echo strtoupper($userid['reg_name']);?></h4>
                <h4 style="margin: 0; margin-left: -110px;">CABANG PENGIRIM : <?php echo strtoupper($ks['reg_name']);?></h4>
                <h4 style="margin: 0; margin-left: -110px;">TANGGAL KIRIM <?php echo strtoupper($ks['trans_stok_tgl']);?></h4>
            </center>
        </td>
    </tr>
</table>

<table border="0" align="center" style="width:700px;border:none;">
        <tr>
            <th style="font-weight:normal;text-align:left"><b>No Transfer : <span style="color: green;"><?php echo $ks['trans_stok_no'];?></span></b></th>
        </tr>
</table>

<table border="1" align="center" style="width:700px; border:none;margin-top:5px;margin-bottom:0px;">
    <thead>
        <tr>
            <th style="text-align:center;">No</th>
            <th style="text-align:center;">Qty Kirim</th>
            <th style="text-align:center;">Qty Konfirm</th>
            <th style="text-align:center;">Kode Barang</th>
            <th style="text-align:center;">Nama Barang</th>
            <th style="text-align:center;">Satuan</th>
            <th style="text-align:center;">Kategori</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $no=0;
        foreach ($detail_transtok as $t):
            $no++;
            $id=$t['d_trans_stok_id'];
            $kd=$t['d_barang_id'];
            $nm=$t['d_barang_nama'];
            $sat=$t['d_barang_satuan'];
            $kat=$t['d_kategori_nama'];
            $qty=$t['kirim_qty'];
        ?>
    <tr>
        <?php
        
        if (floor($qty) == $qty) {
            $formatted_qty = number_format($qty, 0, ',', '.');
        } else {
            $formatted_qty = number_format($qty, 2, ',', '.');
            $formatted_qty = rtrim($formatted_qty, '0');
            $formatted_qty = rtrim($formatted_qty, ',');
        }
        ?> 
        <td style="text-align:center;"><?php echo $no?></td>
        <td style="text-align:center;"><?php echo $qty?></td>
        <td style="text-align:center;"></td>
        <td><?php echo $kd;?></td>
        <td><?php echo $nm;?></td>
        <td style="text-align:center;"><?php echo $sat?></td>
        <td style="text-align:center;"><?php echo $kat?></td>
    </tr>
        <?php endforeach;?>
    </tbody>
</table> 

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