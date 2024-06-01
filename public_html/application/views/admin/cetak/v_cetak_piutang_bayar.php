<html lang="en" moznomarginboxes mozdisallowselectionprint>

<head>
    <?php 
	error_reporting(0);
    $userid=$userid->row_array();
    ?>
    <title>Laporan Pelunasan Piutang<?php echo $userid['reg_name'];?></title>
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
        width: 210px;
        height: 50px;
        border-radius: 50%;
        object-fit: cover;
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
                        <h4 style="margin: 0; margin-left: -110px;">LAPORAN PELUNASAN PIUTANG <?php echo strtoupper($userid['reg_code']);?> <?php echo strtoupper($userid['reg_name']);?></h4>
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
                            <th style="text-align:center">Nama Customer</th>
                            <th style="text-align:center">No Faktur</th>
                            <th style="text-align:center">No Nota</th>
                            <th style="text-align:center">Status</th>
                            <th style="text-align:center">Jumlah Bayar</th>
                            </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no=0;
                        $total=0;
                        foreach ($data as $a):
                            $no++;
                            $tgl_byr = $a['bayar_tgl_trans'];
                            $nmcust_byr = $a['jual_cust_nama'];
                            $nofak_byr = $a['bayar_nofak'];
                            $nota_byr = $a['jual_nota'];
                            $status_byr = $a['bayar_ket'];
                            $jml_byr = $a['bayar_jumlah'];
                            $tgltempo_byr = $a['jual_tgl_tempo'];
                            $blntempo_byr = $a['jual_bulan_tempo'];
                            $total=$total+$jml_byr;
                            
                        ?>
                        <tr>
                            <td style="text-align:center;"><?php echo $no;?></td>
                            <td style="padding-left:3px;"><?php echo $tgl_byr;?></td>
                            <td style="padding-left:3px;"><?php echo $nmcust_byr;?></td>
                            <td style="padding-left:3px;"><?php echo $nofak_byr;?></td>
                            <td style="text-align:center;"><?php echo $nota_byr;?></td>
                            <td style="text-align:center;"><?php echo $status_byr;?></td>
                            <td style="text-align:right;padding-right:3px;"><?php echo 'Rp ' . str_replace(',', '.', number_format($jml_byr)); ?></td>
                        </tr>
                    <?php endforeach;?>
                    <tr>
                        <td colspan="6" style="text-align:right;font-size:11px;padding-right:5px;"><b>Total : </b></td>
                        <td style="text-align:right;font-size:11px;padding-right:3px;"><b><?php echo 'Rp ' . str_replace(',', '.', number_format($total)); ?></b></td>
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
