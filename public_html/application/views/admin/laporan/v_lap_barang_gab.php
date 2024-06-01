<html lang="en" moznomarginboxes mozdisallowselectionprint>
<head>
    <?php 
	error_reporting(0);
    $userid=$userid->row_array();
    ?> 
    <title>Laporan Data Barang All</title>
    <link rel="shortcut icon" href="<?php echo base_url().'assets/img/'. $userid['co_imgicon']; ?>" alt="#no image#" type="image/x-icon">
    <meta charset="utf-8">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/laporan.css')?>"/>
    
<style>
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
<table align="center" style="width:900px; border-bottom:3px double;border-top:none;border-right:none;border-left:none;margin-top:5px;margin-bottom:20px;">
</table>

<table border="0" align="center" style="width:800px; border:none;margin-top:5px;margin-bottom:0px;">
<tr>    
    <td><img src="<?php echo base_url().'assets/img/'. $userid['co_imglogo']; ?>" style="margin-left:-50" alt="Curved Image" class="curved-image"/></td>
    <td colspan="2" style="width:900px;padding-left:0px;"><center><h4 style="margin-left: -110px;">LAPORAN DATA BARANG GABUNGAN (GLOBAL)</h4></center><br/></td>
</tr>                   
</table>

<table border="0" align="center" style="width:900px;border:none;">
<tr>
    <th style="text-align:left"></th>
</tr>
</table>

<table border="1" align="center" style="width:900px;margin-bottom:20px;">
<?php 
    $urut=0;
    $nomor=0;
    $group='-';
    foreach($data->result_array()as $d){
    $nomor++;
    $urut++;
    if($group=='-' || $group!=$d['kategori_nama']){
        $kat=$d['kategori_nama'];
        
        if($group!='-')
        echo "</table><br>";
        echo "<table align='center' width='900px;' border='1'>";
        echo "<tr><td colspan='7'><b>Kategori: $kat</b></td> </tr>";
        echo "<tr style='background-color:#ccc;'>
        <td width='4%' align='center'>No</td>
        <td width='10%' align='center'>Kode Barang</td>
        <td width='35%' align='center'>Nama Barang</td>
        <td width='10%' align='center'>Satuan</td>
        <td width='15%' align='center'>Harga Pokok</td>
        <td width='15%' align='center'>Harga Jual</td>
        <td width='15%' align='center'>Stok</td> 
        </tr>";
$nomor=1;
    }
    $group=$d['kategori_nama'];
        if($urut==500){
        $nomor=0;
            echo "<div class='pagebreak'> </div>";

            }
        ?>
        <tr>
                <td style="vertical-align:center;text-align:center;"><?php echo $nomor; ?></td>
                <td style="vertical-align:center;padding-left:5px;text-align:center;"><?php echo $d['barang_id']; ?></td>
                <td style="vertical-align:center;padding-left:5px;"><?php echo $d['barang_nama']; ?></td>
                <td style="vertical-align:center;text-align:center;"><?php echo $d['barang_satuan']; ?></td>
                <td style="vertical-align:center;padding-right:5px;text-align:right;"><?php echo 'Rp '.number_format($d['barang_harpok']); ?></td>
                <td style="vertical-align:center;padding-right:5px;text-align:right;"><?php echo 'Rp '.number_format($d['barang_harjul']); ?></td>
                <?php
                $stok = $d['stok_global'];
                if (floor($stok) == $stok) {
                    $formatted_stok = number_format($stok, 0, ',', '.');
                } else {
                    $formatted_stok = number_format($stok, 2, ',', '.');
                    $formatted_stok = rtrim($formatted_stok, '0');
                    $formatted_stok = rtrim($formatted_stok, ',');
                } 
                ?>  
                <td style="vertical-align:center;text-align:center;"><?php echo $formatted_stok; ?></td>  
        </tr>
        

        <?php
        }
        ?>
</table>

<br>
<table align="center" style="width:900px;border:none;margin-bottom:20px;">
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