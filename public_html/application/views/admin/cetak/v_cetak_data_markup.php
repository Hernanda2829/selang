<html lang="en" moznomarginboxes mozdisallowselectionprint>
<head>
    <?php 
	error_reporting(0);
    $userid=$userid->row_array();
    ?>
    <title>Laporan Data Markup <?php echo $userid['reg_name'];?></title>
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
                <h4 style="margin: 0; margin-left: -110px;">LAPORAN DATA MARKUP</h4>
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
                <th style="text-align:center">No</th>
                <th style="text-align:center">Cabang</th>
                <th style="text-align:center">No Faktur</th>
                <th style="text-align:center">Nama Customer</th>
                <th style="text-align:center">Tanggal Transaksi</th>
                <th style="text-align:center">Jenis Bayar</th>
                <th style="text-align:center">Status Bayar</th>
                <th style="text-align:center">Total Penjualan</th>
                </tr>
            </thead>
            <tbody>
            <?php 
                $no=0;
                //foreach ($data_markup->result_array() as $m):
                foreach ($data_markup as $m):
                    $no++;
                    $nofak=$m['jual_nofak'];
                    $nmcust=$m['jual_cust_nama'];
                    $tgl=$m['jual_tanggal'];
                    $jb=$m['jual_bayar'];
                    $js=$m['jual_bayar_status'];
                    $tot=$m['jual_total'];
                    $regname=$m['reg_name'];

            ?>
                <tr>
                    <td style="text-align:center;"><?php echo $no;?></td>
                    <td><?php echo $regname;?></td>
                    <td><?php echo $nofak;?></td>
                    <td><?php echo $nmcust;?></td>
                    <td><?php echo $tgl;?></td>
                    <td style="text-align:center;"><?php echo $jb;?></td>
                    <td style="text-align:center;"><?php echo $js;?></td>
                    <td style="text-align:right;"><?php echo 'Rp ' . str_replace(',', '.', number_format($tot)); ?></td>
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