<html lang="en" moznomarginboxes mozdisallowselectionprint>
<head>
    <?php 
	error_reporting(0);
    $userid=$userid->row_array();
    ?>
    <title>Laporan Piutang Penjualan</title>
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
                <h4 style="margin: 0; margin-left: -110px;">LAPORAN PIUTANG PENJUALAN</h4>
                <h4 style="margin: 0; margin-left: -110px;">PERIODE <?php echo strtoupper($blnthn);?></h4>
            </center>
        </td>
    </tr>
</table>

<div class="row">
    <div class="col-lg-12">
        <table border="1" align="center" class="table table-striped table-bordered" style="font-size:11px; width:700px;">  
            <thead>
                <tr>
                    <th rowspan="2" style="text-align:center;vertical-align:middle;">No</th>
                    <th rowspan="2" style="text-align:center;vertical-align:middle;">Cabang</th>
                    <th colspan="5" style="text-align:center;vertical-align:middle;"><?= $blnthn;?></th>
                    <th rowspan="2" style="text-align:center;vertical-align:middle;">Total Piutang</th>
                </tr>
                <tr>
                    <?php foreach ($datakolek->result_array() as $k): ?>
                        <th style="text-align: center; color: white; background-color: <?= $k['kol_warna']; ?>">Kolek <?= $k['kol_bln']; ?></th>
                    <?php endforeach; ?>
                </tr>
                
            </thead>
            <tbody>
                <?php 
                $no = 0;
                $total = 0;
                //foreach ($datatempo->result_array() as $b):
                foreach ($datatempo as $b):
                    $no++;
                    $id = $b['reg_id'];
                    $cab = $b['reg_name'];
                    $total=$b['kol1'] + $b['kol2'] + $b['kol3'] + $b['kol4'] + $b['kol5'];
                ?>
                    <tr>
                        <td style="text-align:center;"><?php echo $no;?></td>
                        <td><?php echo $cab;?></td>
                        <td style="text-align:right;padding-right:3px;"><?php echo str_replace(',', '.', number_format($b['kol1']));?></td>
                        <td style="text-align:right;padding-right:3px;"><?php echo str_replace(',', '.', number_format($b['kol2']));?></td>
                        <td style="text-align:right;padding-right:3px;"><?php echo str_replace(',', '.', number_format($b['kol3']));?></td>
                        <td style="text-align:right;padding-right:3px;"><?php echo str_replace(',', '.', number_format($b['kol4']));?></td>
                        <td style="text-align:right;padding-right:3px;"><?php echo str_replace(',', '.', number_format($b['kol5']));?></td>
                        <td style="text-align:right;padding-right:3px;"><?php echo str_replace(',', '.', number_format($total));?></td>
                    </tr>
                <?php endforeach;?>
                <!-- Baris Total -->
                <tr>
                    <th colspan="2" style="text-align:right;font-weight:bold;padding-right:5px;">Grand Total</th>
                    <?php 
                        $totalKol = 0;
                        $totkol1 = $totkol2 = $totkol3 = $totkol4 = $totkol5 = 0;
                        //foreach ($datatempo->result_array() as $b):
                        foreach ($datatempo as $d):
                            $totkol1 += $d['kol1'];
                            $totkol2 += $d['kol2'];
                            $totkol3 += $d['kol3'];
                            $totkol4 += $d['kol4'];
                            $totkol5 += $d['kol5'];
                        endforeach;
                        $totalKol = $totkol1 + $totkol2 + $totkol3 + $totkol4 + $totkol5;
                    ?>
                    <th style="text-align:right;font-weight:bold;padding-right:3px;"><?php echo 'Rp ' . str_replace(',', '.', number_format($totkol1));?></th>
                    <th style="text-align:right;font-weight:bold;padding-right:3px;"><?php echo 'Rp ' . str_replace(',', '.', number_format($totkol2));?></th>
                    <th style="text-align:right;font-weight:bold;padding-right:3px;"><?php echo 'Rp ' . str_replace(',', '.', number_format($totkol3));?></th>
                    <th style="text-align:right;font-weight:bold;padding-right:3px;"><?php echo 'Rp ' . str_replace(',', '.', number_format($totkol4));?></th>
                    <th style="text-align:right;font-weight:bold;padding-right:3px;"><?php echo 'Rp ' . str_replace(',', '.', number_format($totkol5));?></th>
                    <th style="text-align:right;font-weight:bold;padding-right:3px;"><?php echo 'Rp ' . str_replace(',', '.', number_format($totalKol));?></th>
                    
                </tr>
                <!-- End Baris Total -->
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