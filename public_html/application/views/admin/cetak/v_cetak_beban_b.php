<html lang="en" moznomarginboxes mozdisallowselectionprint>
<head>
    <?php 
	error_reporting(0);
    $userid=$userid->row_array();
    ?>
    <title>Laporan Data Pengeluaran <?php echo $userid['reg_name'];?></title>
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
                <h4 style="margin: 0; margin-left: -110px;">LAPORAN PENGELUARAN <?php echo strtoupper($userid['reg_code']);?> <?php echo strtoupper($userid['reg_name']);?></h4>
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
                    <th style="text-align:center">Tanggal Transaksi</th>    
                    <th style="text-align:center">Nama Pengeluaran</th>
                    <th style="text-align:center">Kategori</th>
                    <th style="text-align:center">Jumlah</th>
                    </tr>
            </thead>
            <tbody>
                <?php 
                $no=0;
                $beb_total=0;
                foreach ($data as $a):
                    $no++;
                    $beb_tgl = $a['beban_tanggal'];
                    $beb_nm = $a['beban_nama'];
                    $beb_jml = $a['beban_jumlah'];
                    $beb_kat = $a['beban_kat_nama'];
                    $beb_total = $beb_total+$beb_jml;
                ?>
                <tr>
                    <td style="text-align:center;"><?php echo $no;?></td>
                    <td style="padding-left:3px;"><?php echo $beb_tgl;?></td>
                    <td style="padding-left:3px;"><?php echo $beb_nm;?></td>
                    <td style="padding-left:3px;"><?php echo $beb_kat;?></td>
                    <td style="text-align:right;padding-right:3px;"><?php echo 'Rp ' . str_replace(',', '.', number_format($beb_jml)); ?></td>
                </tr>
            <?php endforeach;?>
            <tr>
                <td colspan="4" style="text-align:right;font-size:11px;padding-right:5px;"><b>Total :</b></td>
                <td style="text-align:right;font-size:11px;padding-right:3px;"><b><?php echo 'Rp ' . str_replace(',', '.', number_format($beb_total)); ?></b></td>
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