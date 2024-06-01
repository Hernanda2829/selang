<html lang="en" moznomarginboxes mozdisallowselectionprint>
<head>
    <?php 
	error_reporting(0);
    $userid=$userid->row_array();
    ?>
    <title>Laporan Data Penjualan</title>
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
                <h4 style="margin: 0; margin-left: -110px;">LAPORAN PENJUALAN <?php echo strtoupper($namacab);?></h4>
                <h4 style="margin: 0; margin-left: -110px;">PERIODE <?php echo date('d/m/Y', strtotime($tgl1)) .' S/d '. date('d/m/Y', strtotime($tgl2)) ;?></h4>
            </center>
        </td>
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
        <th>No</th>
        <th>Kantor</th>
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
        $cab = $a['reg_name'];
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
        <td><?php echo $cab;?></td>
        <td><?php echo date('d/m/Y', strtotime($tgl));?></td>
        <td><?php echo $cust;?></td>
        <td style="text-align:center;"><?php echo $nofak;?></td>
        <td style="text-align:center;"><?php echo $nota;?></td>
        <td style="text-align:center;"><?php echo $jbyr;?></td>
        <td style="text-align:center;"><?php echo $jstatus;?></td>
        <td style="text-align:right; padding-left:5px; padding-right:3px;"><span style="float:left;">Rp</span><?php echo number_format($tot, 0, ',', '.');?></td>
    </tr>
<?php }?>
</tbody>
<tfoot>

    <tr>
        <td colspan="8" style="text-align:right;padding-right:5px;"><b>Total</b></td>
        <td style="text-align:right; padding-left:5px; padding-right:3px;"><b><span style="float:left;">Rp</span><?php echo number_format($total, 0, ',', '.');?></b></td>
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