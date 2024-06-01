<html lang="en" moznomarginboxes mozdisallowselectionprint>
<head>
    <?php 
	error_reporting(0);
    $userid=$userid->row_array();
    $rs=$reqstok->row_array();
    ?>
    <title>Cetak Request <?php echo $userid['reg_name'];?></title>
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
                <h4 style="margin: 0; margin-left: -110px;">REQUEST STOK <?php echo strtoupper($rs['reg_name']);?></h4>
                <h4 style="margin: 0; margin-left: -110px;">TANGGAL <?php echo strtoupper($rs['req_stok_tgl']);?></h4>
            </center>
        </td>
    </tr>
</table>

<table border="0" align="center" style="width:700px;border:none;">
        <tr>
            <th style="text-align:left"></th>
        </tr>
</table>

<table border="0" align="center" style="width:700px; border:none;margin-top:5px;margin-bottom:0px;">
    <thead>
        <tr>
            <th style="text-align:center;">No</th>
            <th style="text-align:center;">Qty Kirim</th>
            <th style="text-align:center;">Qty Request</th>
            <th style="text-align:center;">Kode Barang</th>
            <th style="text-align:center;">Nama Barang</th>
            <th style="text-align:center;">Satuan</th>
            <th style="text-align:center;">Kategori</th>
            <th style="text-align:center;">Stok Tersedia</th>    
        </tr>
    </thead>
    <tbody>
        <?php 
        $no=0;
        foreach ($data_reqstok->result_array() as $q):
            $no++;
            $noid=$q['d_req_stok_id'];
            $kd=$q['d_barang_id'];
            $nm=$q['d_barang_nama'];
            $sat=$q['d_barang_satuan'];
            $kat=$q['d_kategori_nama'];
            $req_qty=$q['d_req_stok_qty'];
            $stok=$q['stok_cabang']; 
        ?>
    <tr>
        <?php
        
        if (floor($stok) == $stok) {
            $formatted_stok = number_format($stok, 0, ',', '.');
        } else {
            $formatted_stok = number_format($stok, 2, ',', '.');
            $formatted_stok = rtrim($formatted_stok, '0');
            $formatted_stok = rtrim($formatted_stok, ',');
        }
        ?> 
        <td style="text-align:center;"><?php echo $no?>
        <input type="hidden" name="nofak<?php echo $noid?>" value="<?php echo $id?>">
        <input type="hidden" name="kode<?php echo $noid?>" value="<?php echo $noid?>">
        </td>
        <?php 
        if (floor($req_qty) == $req_qty) {
            $formatted_req_qty = number_format($req_qty, 0, ',', '.');
        } else {
            $formatted_req_qty = number_format($req_qty, 2, ',', '.');
            $formatted_req_qty = rtrim($formatted_req_qty, '0');
            $formatted_req_qty = rtrim($formatted_req_qty, ',');
        }

        if ($ket=="isi") {
            if ($req_qty > $stok) {
                echo '<td style="text-align:center;"><input type="text" name="qty'.$noid.'" style="width:70px;" value="'.$formatted_stok.'" min="0" max="'.$formatted_stok.'"></td>';
            }else{
                echo '<td style="text-align:center;"><input type="text" name="qty'.$noid.'" style="width:70px;" value="'.$formatted_req_qty.'" min="0" max="'.$formatted_stok.'"></td>';
            }
        }else{
            echo '<td style="text-align:center;"><input type="text" name="qty'.$noid.'" style="width:70px;" value=""></td>';
        }

        ?>
        <td style="text-align:center;"><?php echo $formatted_req_qty?></td>
        <td><?php echo $kd;?></td>
        <td><?php echo $nm;?></td>
        <td style="text-align:center;"><?php echo $sat?></td>
        <td style="text-align:center;"><?php echo $kat?></td>
        <td style="text-align:center;"><?php echo $formatted_stok?></td>
        
        

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