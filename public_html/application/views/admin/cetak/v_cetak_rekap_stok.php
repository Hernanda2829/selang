<html lang="en" moznomarginboxes mozdisallowselectionprint>
<head>
    <?php 
	error_reporting(0);
    $userid=$userid->row_array();
    ?>
    <title>Akumulasi Harga Stok Barang</title>
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
                <h4 style="margin: 0; margin-left: -110px;">AKUMULASI HARGA STOK BARANG</h4>
                <h4 style="margin: 0; margin-left: -110px;">PERIODE <?php echo strtoupper($nm_bln);?> <?php echo strtoupper($thn);?></h4>
            </center>
        </td>
    </tr>
</table>

<div class="row">
    <div class="col-lg-12">
        <?php 
        $categories = array_chunk($kategori, 2); // Membagi kategori menjadi kelompok-kelompok dengan setiap kelompok berisi 3 kategori
        $iterationCount = 0; // Inisialisasi hitungan iterasi

        foreach ($categories as $categoryGroup):
        ?>
            <div class="table-wrapper">
                <table align="center" class="table table-striped table-bordered nowrap" style="font-size:11px; width:700px; margin-top: 20px; border-collapse: collapse;" id="mydata">  
                    <thead>
                        <tr>
                        <th rowspan="2" style="text-align:center;vertical-align:middle;color:white;background-color:#eb1b28; border: 1px solid #ddd;">No</th>
                        <th rowspan="2" style="text-align:center;vertical-align:middle;color:white;background-color:#eb1b28; border: 1px solid #ddd;">Cabang</th>
                        <?php foreach ($categoryGroup as $k): ?>
                            <th colspan="3" style="text-align:center;color:white;background-color:black; border: 1px solid #ddd;"><?php echo $k['kategori_nama'];?></th>
                        <?php endforeach; ?>
                    </tr>
                    <tr>
                        <?php foreach ($categoryGroup as $k): ?>
                            <th style="text-align:center;color:#4f81bd;background-color:white; border: 1px solid #ddd;">Stok</th>
                            <th style="text-align:center;color:#c0504d;background-color:white; border: 1px solid #ddd;">Bottom</th>
                            <th style="text-align:center;color:#9bbb59;background-color:white; border: 1px solid #ddd;">Pricelist</th>
                        <?php endforeach; ?>
                    </tr>
                    
                    <tr>
                        <th colspan="2" style="text-align:right;font-weight:bold;color:white;background-color:#027c3f;">Grand Total</th>
                        <?php 
                        $grandTotalStok = $grandTotalHarpok = $grandTotalHarjul = 0;
                        foreach ($categoryGroup as $k):  
                            $kat = $k['kategori_id'];
                            $totalStok = $totalHarpok = $totalHarjul = 0;
                            foreach ($data->result_array() as $a):
                                $totalStok += $a['stok_global_' . $kat];
                                $totalHarpok += $a['Total_Harpok_' . $kat];
                                $totalHarjul += $a['Total_Harjul_' . $kat];
                            endforeach;
                            $grandTotalStok += $totalStok;
                            $grandTotalHarpok += $totalHarpok;
                            $grandTotalHarjul += $totalHarjul;
                            ?>
                            <th style="text-align:right;font-weight:bold;color:white;background-color:#027c3f;padding-right:3px;"><?php echo str_replace(',', '.', number_format($totalStok));?></th>
                            <th style="text-align:right;font-weight:bold;color:white;background-color:#027c3f;padding-right:3px;"><?php echo 'Rp ' . str_replace(',', '.', number_format($totalHarpok));?></th>
                            <th style="text-align:right;font-weight:bold;color:white;background-color:#027c3f;padding-right:3px;"><?php echo 'Rp ' . str_replace(',', '.', number_format($totalHarjul));?></th>
                        <?php endforeach; ?>
                    </tr>

                    </thead>
                    <tbody>
                        <?php 
                        $no = 0;
                        foreach ($data->result_array() as $a):
                            $no++;
                            $id = $a['reg_id'];
                            $cab = $a['reg_name'];
                        ?>
                            <tr>
                                <td style="text-align:center; border: 1px solid #ddd;"><?php echo $no;?></td>
                                <td style="border: 1px solid #ddd;"><?php echo $cab;?></td>
                                <?php 
                                $totalStok = $totalHarpok = $totalHarjul = 0;
                                foreach ($categoryGroup as $k):  
                                    $kat = $k['kategori_id'];
                                    $totalStok += $a['stok_global_' . $kat];
                                    $totalHarpok += $a['Total_Harpok_' . $kat];
                                    $totalHarjul += $a['Total_Harjul_' . $kat];
                                ?>
                                    <td style="text-align:right; border: 1px solid #ddd;padding-right:3px;"><?php echo str_replace(',', '.', number_format($a['stok_global_' . $kat]));?></td>
                                    <td style="text-align:right; border: 1px solid #ddd;padding-right:3px;"><?php echo 'Rp ' . str_replace(',', '.', number_format($a['Total_Harpok_' . $kat]));?></td>
                                    <td style="text-align:right; border: 1px solid #ddd;padding-right:3px;"><?php echo 'Rp ' . str_replace(',', '.', number_format($a['Total_Harjul_' . $kat]));?></td>
                                <?php endforeach; ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <?php 
            $iterationCount++;
            if ($iterationCount % 2 === 0): // Setiap dua kali iterasi, tambahkan page break ?>
                <div class="page-break"></div>
                <table border="0" align="center" style="width:700px;border:none;margin-bottom:50px;">
                </table>
            <?php endif; ?>
            
        <?php endforeach; ?>
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