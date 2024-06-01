<html lang="en" moznomarginboxes mozdisallowselectionprint>
<head>
    <?php 
	error_reporting(0);
    $userid=$userid->row_array();
    ?>
    <title>Faktur Penjualan Barang</title>
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
<table align="center" style="width:700px; border-bottom:3px double;border-top:none;border-right:none;border-left:none;margin-top:5px;margin-bottom:20px;">
<!--<tr>
    <td><img src="<?php// echo base_url().'assets/img/kop_surat.png'?>"/></td>
</tr>-->
</table>
<table border="0" align="center" style="width:700px; border:none;margin-top:5px;margin-bottom:0px;">
<tr>
</tr>                   
</table>
<?php 
    $b=$data->row_array();
    $carabayar=$b['jual_bayar'];
?>

<table border="0" align="center" style="width:700px;border:none;">
<tr>
    <th style="text-align:left;font-size:25px;color:#147aaf;font-family:Arial;">SAMUDERA SELANG</th>
</tr>
<tr>
    <th style="text-align:left;font-weight:normal;">Hydraulic - Industrial Hose - & Fitting</th>
</tr>
<tr>
    <th style="text-align:left;font-weight:normal;padding-bottom:10px;">Filter : Udara - Oli - Hydraulic & Seal Kit</th>
</tr>

<tr>
    
   <th style="text-align:left; font-weight:normal; border-bottom: 1px dashed black; display: flex; justify-content: space-between;">
    <span style="width: 40%;"> <?php echo $userid['reg_desc'];?> </span>
    <span style="width: 60%;"></span>
</th>



</tr>
</table>
<table border="0" align="center" style="width:700px;border:none;margin-top:10px;">
    <tr>
        <th style="text-align:left;width:10%;">Nota</th>
        <th style="text-align:left;width:2%;">:</th>
        <th style="text-align:left;width:30%;"><?php echo $b['jual_nota'];?></th>
        <th style="text-align:left;max-width:15%;"></th>
        <th style="text-align:left;width:12%;">Keterangan</th>
        <th style="text-align:right;width:2%;">:</th>
        <th style="text-align:left;width:14%;padding-left:10px"><?php echo $b['jual_bayar'];?></th>
        <th style="text-align:left;max-width:10%;"></th>
    </tr>
    <tr>
        <th style="text-align:left;width:10%;">No Faktur</th>
        <th style="text-align:left;width:2%;">:</th>
        <th style="text-align:left;width:30%;"><?php echo $b['jual_nofak'];?></th>
        <th style="text-align:left;max-width:15%;"></th>
        <th style="text-align:left;width:12%;">Total</th>
        <th style="text-align:right;width:2%;">:</th>
        <th style="text-align:right;width:14%;"><?php echo 'Rp '.number_format($b['jual_total']).',-';?></th>
        <th style="text-align:left;max-width:10%;"></th>
    </tr>
    <tr>
        <th style="text-align:left;">Tanggal</th>
        <th style="text-align:left;">:</th>
        <th style="text-align:left;"><?php echo $b['jual_tanggal'];?></th>
        <th style="text-align:right;"></th>
        <th style="text-align:left;">Tunai</th>
        <th style="text-align:right;">:</th>
        <th style="text-align:right;"><?php echo 'Rp '.number_format($b['jual_jml_uang']).',-';?></th>
        <th style="text-align:left;"></th>
    </tr>
    <tr>
        <th style="text-align:left;">Customer</th>
        <th style="text-align:left;">:</th>
        <th style="text-align:left;"><?php echo $b['jual_cust_nama'];?></th>
        <th style="text-align:right;"></th>
        <?php
            if ($carabayar==="Cash") {
                echo '<th style="text-align:left;">Kembalian</th>';
                echo '<th style="text-align:right;">:</th>';
                echo '<th style="text-align:right;">Rp '.number_format($b['jual_kembalian']).',-</th>';
                echo '<th style="text-align:left;"></th>';
            }elseif ($carabayar==="Tempo") {
                echo '<th style="text-align:left;">Kurang Bayar</th>';
                echo '<th style="text-align:right;">:</th>';
                echo '<th style="text-align:right;">Rp '.number_format($b['jual_kurang_bayar']).',-</th>';
                echo '<th style="text-align:left;"></th>';
            }
        ?>        
    </tr>

</table>

<table align="center" style="width:700px; margin-top:5px; border-collapse: collapse; border: 1px dashed black;">
    <thead>
        <tr>
            <th style="width:50px; border: 1px dashed black;">No</th>
            <th style="border: 1px dashed black;">Kode Barang</th>
            <th style="border: 1px dashed black;">Nama Barang</th>
            <th style="border: 1px dashed black;">Satuan</th>
            <th style="border: 1px dashed black;">Harga Jual</th>
            <th style="border: 1px dashed black;">Qty</th>
            <th style="border: 1px dashed black;">Diskon</th>
            <th style="border: 1px dashed black;">SubTotal</th>
        </tr>
    </thead>
    <tbody>
        <?php 
            $no=0;
            foreach ($data->result_array() as $i) {
                $no++;
                $kodbar=$i['d_jual_barang_id'];
                $nabar=$i['d_jual_barang_nama'];
                $satuan=$i['d_jual_barang_satuan'];
                
                $harjul=$i['d_jual_barang_harjul'];
                $qty=$i['d_jual_qty'];
                $diskon=$i['d_jual_diskon'];
                $total=$i['d_jual_total'];
        ?>
        <tr>
            <td style="text-align:center; border: 1px dashed black;"><?php echo $no;?></td>
            <td style="text-align:left;padding-left:3px; border: 1px dashed black;"><?php echo $kodbar;?></td>
            <td style="text-align:left;padding-left:3px; border: 1px dashed black;"><?php echo $nabar;?></td>
            <td style="text-align:center; border: 1px dashed black;"><?php echo $satuan;?></td>
            <td style="text-align:right;padding-right:3px; border: 1px dashed black;"><?php echo 'Rp '.number_format($harjul);?></td>
            <td style="text-align:center; border: 1px dashed black;"><?php echo $qty;?></td>
            <td style="text-align:right;padding-right:3px; border: 1px dashed black;"><?php echo 'Rp '.number_format($diskon);?></td>
            <td style="text-align:right;padding-right:3px; border: 1px dashed black;"><?php echo 'Rp '.number_format($total);?></td>
        </tr>
        <?php }?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="7" style="text-align:right;padding-right:10px; border: 1px dashed black;"><b>Total</b></td>
            <td style="text-align:right; border: 1px dashed black;"><b><?php echo 'Rp '.number_format($b['jual_total']);?></b></td>
        </tr>
    </tfoot>
</table>



<br>
<table align="center" style="width:750px;border:none;margin-bottom:20px;">
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