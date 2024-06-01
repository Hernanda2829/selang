<html lang="en" moznomarginboxes mozdisallowselectionprint>
<head>
    <?php 
	error_reporting(0);
    $userid=$userid->row_array();
    ?>
    <title>Rekap Stok Barang</title>
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
        <td style="width:700px; padding-left:0px;">
            <center>
                <h4 style="margin: 0; margin-left: -110px;">REKAP STOK BARANG KANTOR - <?php echo strtoupper($nmcab);?></h4>
                <h4 style="margin: 0; margin-left: -110px;">PERIODE <?php echo strtoupper($nm_bln);?> <?php echo strtoupper($thn);?></h4>
            </center>
        </td>
    </tr>
</table>

<table border="1" align="center" style="width:700px; border:none;margin-top:5px;margin-bottom:0px;">
    <thead>
        <tr>
            <th style="text-align:center">No</th>
            <th style="text-align:center">Kode Barang</th>
            <th style="text-align:center">Nama Barang</th>
            <th style="text-align:center">Satuan</th>
            <th style="text-align:center">Harga Bottom</th>
            <th style="text-align:center">Harga Pricelist</th>
            <th style="text-align:center">Stok</th>
            <th style="text-align:center">Total Bottom</th>
            <th style="text-align:center">Total Pricelist</th>
            <th style="text-align:center">Kategori</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $no=0;
        $total_totharpok = 0;
        $total_totharjul = 0;

        foreach ($data as $d):
            $no++;
            $kd=$d['barang_id'];
            $nm=$d['barang_nama'];
            $sat=$d['barang_satuan'];
            $harpok=$d['barang_harpok'];
            $harjul=$d['barang_harjul'];
            $stok=$d['stok_cabang']; 
            $totharpok=$d['Total_Harpok'];
            $totharjul=$d['Total_Harjul'];
            $kat=$d['barang_kategori_nama'];

            $total_totharpok += $totharpok;
            $total_totharjul += $totharjul;

            if (floor($stok) == $stok) {
                $formatted_stok = number_format($stok, 0, ',', '.');
            } else {
                $formatted_stok = number_format($stok, 2, ',', '.');
                $formatted_stok = rtrim($formatted_stok, '0');
                $formatted_stok = rtrim($formatted_stok, ',');
            }
            
        ?>
    <tr>
        <td style="text-align:center;"><?php echo $no;?></td>
        <td><?php echo $kd;?></td>
        <td><?php echo $nm;?></td>
        <td style="text-align:center;"><?php echo $sat;?></td>
        <td style="text-align:right;padding-right:3px;"><?php echo number_format($harpok, 0, ',', '.');?></td>
        <td style="text-align:right;padding-right:3px;"><?php echo number_format($harjul, 0, ',', '.');?></td>
        <td style="text-align:center;"><?php echo $formatted_stok;?></td>
        <td style="text-align:right;padding-right:3px;"><?php echo number_format($totharpok, 0, ',', '.');?></td>
        <td style="text-align:right;padding-right:3px;"><?php echo number_format($totharjul, 0, ',', '.');?></td>
        <td style="text-align:center;"><?php echo $kat;?></td>
        
    </tr>    
    <?php endforeach;?>
    <!-- Baris total -->
    <tr>
        <td colspan="7" style="text-align:right;padding-right:5px;"><strong>Total : </strong></td>
        <td style="text-align:right;padding-right:3px;"><strong><?php echo number_format($total_totharpok, 0, ',', '.');?></strong></td>
        <td style="text-align:right;padding-right:3px;"><strong><?php echo number_format($total_totharjul, 0, ',', '.');?></strong></td>
        <td></td> <!-- Kolom Kategori tidak ditambahkan pada total -->
    </tr>
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