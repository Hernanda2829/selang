<html lang="en" moznomarginboxes mozdisallowselectionprint>
<head>
    <?php 
	error_reporting(0);
    $userid=$userid->row_array();
    ?>
    <title>Laporan Data Penjualan <?php echo $userid['reg_name'];?></title>
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
<table align="center" style="width:700px; border-bottom:3px double;border-top:none;border-right:none;border-left:none;margin-top:5px;margin-bottom:20px;">
</table>

<table border="0" align="center" style="width:700px; border:none;margin-top:5px;margin-bottom:0px;">
<tr>
    <td><img src="<?php echo base_url().'assets/img/'. $userid['co_imglogo']; ?>" style="margin-bottom:10px" alt="Curved Image" class="curved-image"/></td>
    <td colspan="2" style="width:700px;padding-left:0px;"><center><h4 style="margin-left: -110px;">LAPORAN PENJUALAN BARANG <?php echo strtoupper($userid['reg_code']);?> <?php echo strtoupper($userid['reg_name']);?></h4></center><br/></td>
</tr>                   
</table>

 
<table border="0" align="center" style="width:700px;border:none;">
        <tr>
            <th style="text-align:left"></th>
        </tr>
</table>

<table border="1" align="center" style="width:700px;margin-bottom:20px;">
<thead>
    <tr>
        <th style="width:50px;">No</th>

        <th>Tanggal</th>
        <th>Nama Customer</th>
        <th>No Faktur</th>
        <th>No Nota</th>
        <th>Jenis Pembayaran</th>
        <th>Status Pembayaran</th>
        <th>Total Penjualan</th>
    </tr>
</thead>
<tbody>
<?php 
$no=0;
    foreach ($data as $a) {
        $no++;
        $tgl = $a['jual_tanggal'];
        $cust = $a['jual_cust_nama'];
        $nofak = $a['jual_nofak'];
        $nota = $a['jual_nota'];
        $jbyr = $a['jual_bayar'];
        $jstatus = $a['jual_bayar_status'];
        $tot = $a['jual_total'];
        $total=$total+$tot;
?>
    <tr>
        <td style="text-align:center;"><?php echo $no;?></td>
        <td><?php echo $tgl;?></td>
        <td><?php echo $cust;?></td>
        <td style="text-align:center;"><?php echo $nofak;?></td>
        <td style="text-align:center;"><?php echo $nota;?></td>
        <td style="text-align:center;"><?php echo $jbyr;?></td>
        <td style="text-align:center;"><?php echo $jstatus;?></td>
        <td style="text-align:right;"><?php echo 'Rp ' . str_replace(',', '.', number_format($tot)); ?></td>
    </tr>
<?php }?>
</tbody>
<tfoot>

    <tr>
        <td colspan="7" style="text-align:right;padding-right:5px;"><b>Total</b></td>
        <td style="text-align:right;"><b><?php echo 'Rp ' . str_replace(',', '.', number_format($total)); ?></b></td>
    </tr>
</tfoot>
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