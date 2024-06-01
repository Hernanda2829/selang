<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    //error_reporting(E_ALL);
    //ini_set('display_errors', 1); 
	error_reporting(0);
    $userid=$userid->row_array();
    $data_regid=$userid['reg_id'];
    ?>  
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Produk By <?php echo $userid['co_name'];?>">
    <meta name="author" content="<?php echo $userid['co_name'];?>">

    <title>Laporan Laba Penjualan</title>
    <link rel="shortcut icon" href="<?php echo base_url().'assets/img/'. $userid['co_imgicon']; ?>" alt="#no image#" type="image/x-icon">
    <!-- Bootstrap Core CSS -->
    <link href="<?php echo base_url().'assets/css/bootstrap.min.css'?>" rel="stylesheet">
	<link href="<?php echo base_url().'assets/css/style.css'?>" rel="stylesheet">
	<link href="<?php echo base_url().'assets/css/font-awesome.css'?>" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?php echo base_url().'assets/css/4-col-portfolio.css'?>" rel="stylesheet">
    <link href="<?php echo base_url().'assets/css/dataTables.bootstrap.min.css'?>" rel="stylesheet">
    <link href="<?php echo base_url().'assets/css/jquery.dataTables.min.css'?>" rel="stylesheet">
    <link href="<?php echo base_url().'assets/dist/css/bootstrap-select.css'?>" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/css/bootstrap-datetimepicker.min.css'?>">
    <!-- Data Table Fixed Columnn -->
    <link href="<?php echo base_url().'assets/js/dataTable/dataTables.bootstrap4.min.css'?>" rel="stylesheet">
    <link href="<?php echo base_url().'assets/js/dataTable/fixedColumns.bootstrap4.min.css'?>" rel="stylesheet">
    
<style>  
    
   .bootstrap-select .btn {
        font-size: 12px;
    }

    .bootstrap-datetimepicker-widget {
        font-size: 10px; 
    }

    .bootstrap-datetimepicker-widget table {
        line-height: 1 !important; 
    }

    .bootstrap-datetimepicker-widget table th,
    .bootstrap-datetimepicker-widget table td {
        padding: 1px !important; 
    }

</style>

</head>
<body>

    <!-- Navigation -->
   <?php 
        $this->load->view('admin/menu');
   ?>

    <!-- Page Content -->
    <div class="container">

        <!-- Page Heading -->
        <!-- <div class="row">
            <div class="col-lg-12">
                <h3 style="margin: 0;">Laporan Keuangan dan Penjualan <small><?php //echo $userid['reg_code'];?>  <?php echo $userid['reg_name'];?></small></h3>
            </div>
        </div> -->
        <div class="row">
            <div class="col-lg-12">
                <form id="myForm" class="form-horizontal" method="post" action="">
                <table class="table table-bordered" style="font-size:12px;margin-bottom:10px;">
                    <input type="hidden" name="regid" id="regid" value="<?php echo $data_regid; ?>">
                    <tr>
                        <th style="width:5%;vertical-align:middle;border-top-color:white;border-right-color:white;border-left-color:white;">Bulan :</th>
                        <td style="width:15%;vertical-align:middle;border-top-color:white;border-right-color:white;">
                        <select name="cari_bln" id="cari_bln" class="selectpicker show-tick form-control" title="Pilih Bulan Laporan">
                            <option value="" style="font-size: 11px;"></option>
                            <?php foreach ($daftar_bln as $angka => $bulan) {
                                if ($angka == $bln) {
                                    echo '<option selected value="' . $angka . '">' . $bulan . '</option>';
                                } else {
                                    echo '<option value="' . $angka . '">' . $bulan . '</option>';
                                }
                            }
                            ?>
                        </select>
                        </td>
                        <th style="width:6%;vertical-align:middle;border-top-color:white;border-right-color:white;border-left-color:white;">Tahun :</th>
                        <td style="width:11%;vertical-align:middle;border-top-color:white;border-right-color:white;">
                        <select name="cari_thn" id="cari_thn" class="selectpicker show-tick form-control" title="Pilih Tahun">
                            <option value="" style="font-size: 11px;"></option>
                            <?php foreach ($daftar_thn as $tahun) {
                               
                                if ($tahun == $thn) {
                                    echo '<option selected>' . $tahun . '</option>';
                                } else {
                                    echo '<option>' . $tahun . '</option>';
                                }
                            }
                            ?>
                        </select>
                        </td>
                        <td style="width:5%;border-top-color:white;border-right-color:white;">
                            <a class="btn btn-sm btn-info btn-tampil" data-toggle="modal" title="Tampilkan Data"><span class="fa fa-search"></span></a>
                        </td>
                        <td style="width:50%;text-align:right;border-top-color:white;border-right-color:white;">
                            <button class="btn btn-sm btn-info" title="Cetak Data" onclick="varCetak_Laporan()"><span class="fa fa-print"></span> Cetak Data</button>
                        </td>
                    </tr>
                </table>
                </form>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12 mx-auto text-center" style="margin-bottom:20px;">
                <span style="color:#e26b0a;font-size:14px;"><b>LAPORAN LABA PENJUALAN <?php echo strtoupper($userid['reg_code']);?>  <?php echo strtoupper($userid['reg_name']);?></b></span>
                <br>
                <span id="periode" style="color:#e26b0a;font-size:14px;"><b>BULAN <?= strtoupper($nm_bln) ;?></b></span>
            </div>
            <div class="col-lg-12">
                <table id="tbl_laba" class="table table-striped table-bordered" style="font-size:11px;">
                    <thead>
                        <tr>
                            <th style="text-align:center">No</th>    
                            <th style="text-align:center">Kategori</th>    
                            <th style="text-align:center">Price List Tunai</th>
                            <th style="text-align:center">Bottom Tunai</th>
                            <th style="text-align:center">Laba Tunai</th>
                            <th style="text-align:center">Price List Piutang</th>
                            <th style="text-align:center">Bottom Piutang</th>
                            <th style="text-align:center">Laba Piutang</th>
                            <th style="text-align:center">Total Price List</th>
                            <th style="text-align:center">Total Bottom</th>
                            <th style="text-align:center">Total Laba</th>
                            </tr>
                    </thead>
                    <tbody>
                    <?php 
                        $d=$data->row_array();
                        $totharjul_tunai=0;
                        $totharpok_tunai=0;
                        $totharjul_piutang=0;
                        $totharpok_piutang=0;
                        $totlaba_tunai=0;
                        $totlaba_piutang=0;
                        $totharjul=0;
                        $totharpok=0;
                        $totlaba=0;
                        $no=0;
                        foreach ($kategori as $k):
                        $no++;
                        $kat = $k['kategori_nama'];
                        $harjul_tunai = $d['harjul_tunai' . $kat];
                        $harpok_tunai = $d['harpok_tunai' . $kat];
                        $harjul_piutang = $d['harjul_piutang' . $kat];
                        $harpok_piutang = $d['harpok_piutang' . $kat];
                        $harjul = $d['harjul' . $kat];
                        $harpok = $d['harpok' . $kat];
                        $laba = $harjul - $harpok;
                        $totharjul = $totharjul + $harjul;
                        $totharpok = $totharpok + $harpok;
                        $totlaba = $totlaba + $laba;
                        $laba_tunai = $harjul_tunai - $harpok_tunai;
                        $totharjul_tunai = $totharjul_tunai + $harjul_tunai;
                        $totharpok_tunai = $totharpok_tunai + $harpok_tunai;
                        $totlaba_tunai = $totlaba_tunai + $laba_tunai;
                        $laba_piutang = $harjul_piutang - $harpok_piutang;
                        $totharjul_piutang = $totharjul_piutang + $harjul_piutang;
                        $totharpok_piutang = $totharpok_piutang + $harpok_piutang;
                        $totlaba_piutang = $totlaba_piutang + $laba_piutang;
                        echo '<tr>';
                        echo '<td>'.$no.'</td>';
                        echo '<td>'.$kat.'</td>';
                        echo '<td style="text-align:right;">'.str_replace(',', '.', number_format($harjul_tunai)).'</td>';
                        echo '<td style="text-align:right;">'.str_replace(',', '.', number_format($harpok_tunai)).'</td>';
                        echo '<td style="text-align:right;">'.str_replace(',', '.', number_format($laba_tunai)).'</td>';
                        echo '<td style="text-align:right;">'.str_replace(',', '.', number_format($harjul_piutang)).'</td>';
                        echo '<td style="text-align:right;">'.str_replace(',', '.', number_format($harpok_piutang)).'</td>';
                        echo '<td style="text-align:right;">'.str_replace(',', '.', number_format($laba_piutang)).'</td>';
                        echo '<td style="text-align:right;">'.str_replace(',', '.', number_format($harjul)).'</td>';
                        echo '<td style="text-align:right;">'.str_replace(',', '.', number_format($harpok)).'</td>';
                        echo '<td style="text-align:right;">'.str_replace(',', '.', number_format($laba)).'</td>';
                        echo '</th>';
                        echo '</tr>';

                    endforeach;
                    echo '
                            <tr style="background-color:#777;">
                                <td colspan="2" style="text-align:right;font-size:11px;color:white;"><b>Total : </b></td>
                                <td style="text-align:right;font-size:11px;color:white;"><b>Rp ' . str_replace(',', '.', number_format($totharjul_tunai)) . '</b></td>
                                <td style="text-align:right;font-size:11px;color:white;"><b>Rp ' . str_replace(',', '.', number_format($totharpok_tunai)) . '</b></td>
                                <td style="text-align:right;font-size:11px;color:white;"><b>Rp ' . str_replace(',', '.', number_format($totlaba_tunai)) . '</b></td>
                                <td style="text-align:right;font-size:11px;color:white;"><b>Rp ' . str_replace(',', '.', number_format($totharjul_piutang)) . '</b></td>
                                <td style="text-align:right;font-size:11px;color:white;"><b>Rp ' . str_replace(',', '.', number_format($totharpok_piutang)) . '</b></td>
                                <td style="text-align:right;font-size:11px;color:white;"><b>Rp ' . str_replace(',', '.', number_format($totlaba_piutang)) . '</b></td>
                                <td style="text-align:right;font-size:11px;color:white;"><b>Rp ' . str_replace(',', '.', number_format($totharjul)) . '</b></td>
                                <td style="text-align:right;font-size:11px;color:white;"><b>Rp ' . str_replace(',', '.', number_format($totharpok)) . '</b></td>
                                <td style="text-align:right;font-size:11px;color:white;"><b>Rp ' . str_replace(',', '.', number_format($totlaba)) . '</b></td>
                            </tr>';

                    ?>

                    </tbody>
                </table>
            </div>
        </div>
            

        <!--END MODAL-->
        <hr>
        <!-- Footer -->
        <footer>
            <div class="row">
                <div class="col-lg-12">
                    <p style="text-align:center;"><?php echo $userid['co_copyright'];?></p>
                </div>
            </div>
            <!-- /.row -->
        </footer>

    </div>
    <!-- /.container -->

     <!-- jQuery -->
    <script src="<?php echo base_url().'assets/js/jquery.js'?>"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo base_url().'assets/js/bootstrap.min.js'?>"></script>
    <script src="<?php echo base_url().'assets/dist/js/bootstrap-select.min.js'?>"></script>
    <script src="<?php echo base_url().'assets/js/jquery.dataTables.min.js'?>"></script>
    <script src="<?php echo base_url().'assets/js/moment.js'?>"></script>
    <!-- Data Table Fixed Column-->
    <script src="<?php echo base_url().'assets/js/dataTable/jquery-3.6.3.min.js'?>"></script>
    <script src="<?php echo base_url().'assets/js/dataTable/bootstrap-datetimepicker.min.js'?>"></script>
    <script src="<?php echo base_url().'assets/js/dataTable/jquery-ui.min.js'?>"></script>
    <script src="<?php echo base_url().'assets/js/dataTable/jquery-1.11.5.dataTables.min.js'?>"></script>
    <script src="<?php echo base_url().'assets/js/dataTable/dataTables.fixedColumns.min.js'?>"></script>


<script type="text/javascript">
$(document).ready(function () {
    $(document).on('click', '.btn-tampil', function () {
        var form = document.querySelector('#myForm'); 
        form.action = "<?php echo base_url().'admin/laba/tampil_data';?>"; 
        form.target = '_self';
        form.submit(); // Mengirimkan formulir
    });
});
</script>
<script>
    function varCetak_Laporan() {
        var form = document.querySelector('#myForm'); 
        form.action = "<?php echo base_url().'admin/laba/cetak_laporan';?>";
        form.target = '_blank';
        form.submit(); // Mengirimkan formulir
    }
</script>


</body>
</html>
