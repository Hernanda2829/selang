<!DOCTYPE html>
<html lang="en">

<head>
    <?php 
	error_reporting(0);
    $userid=$userid->row_array();
    ?>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Produk By <?php echo $userid['co_name'];?>">
    <meta name="author" content="<?php echo $userid['co_name'];?>">

    <title>Manajemen Laporan</title>
    <link rel="shortcut icon" href="<?php echo base_url().'assets/img/'. $userid['co_imgicon']; ?>" alt="#no image#" type="image/x-icon">
    <!-- Bootstrap Core CSS -->
    <link href="<?php echo base_url().'assets/css/bootstrap.min.css'?>" rel="stylesheet">
    <link href="<?php echo base_url().'assets/css/style.css'?>" rel="stylesheet">
    <link href="<?php echo base_url().'assets/css/font-awesome.css'?>" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?php echo base_url().'assets/css/4-col-portfolio.css'?>" rel="stylesheet">
    <link href="<?php echo base_url().'assets/css/dataTables.bootstrap.min.css'?>" rel="stylesheet">
    <link href="<?php echo base_url().'assets/css/jquery.dataTables.min.css'?>" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/css/bootstrap-datetimepicker.min.css'?>">
    <link href="<?php echo base_url().'assets/dist/css/bootstrap-select.css'?>" rel="stylesheet">

</head>

<body>

    <!-- Navigation -->
   <?php 
        $this->load->view('admin/menu');
   ?>

    <!-- Page Content -->
    <div class="container">
    <?php $h=$this->session->userdata('akses'); ?>
        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h3 class="page-header">Data
                    <small>Laporan <?php echo $userid['reg_name'];?></small>
                </h3>
            </div>
        </div>
        <!-- /.row -->
        <!-- Projects Row -->
        <div class="row">
            <div class="col-lg-12">
            <table class="table table-bordered table-condensed" style="font-size:12px;" id="mydata">
                <thead>
                    <tr>
                        <th style="text-align:center;width:40px;">No</th>
                        <th>Laporan</th>
                        <th style="width:200px;text-align:center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                
                    <tr>
                        <td style="text-align:center;vertical-align:middle">1</td>
                        <td style="vertical-align:middle;">Laporan Data Barang</td>
                        <td style="text-align:center;">
                        <?php 
                        if($h=='1'){ 
                            echo '<a class="btn btn-sm btn-info" href="#lap_barang" data-toggle="modal" onclick="varCetakBarang(1)"><span class="fa fa-print"></span> Tampil Print</a> ';
                            echo '<a class="btn btn-sm btn-success" href="#lap_barang" data-toggle="modal" onclick="varCetakBarang(2)" title="Export to Excel"><span class="fa fa-print"></span> Export Excel</a>';
                        }else{
                            echo '<a class="btn btn-sm btn-info" href="'.base_url().'admin/laporan/lap_data_barang" target="_blank"><span class="fa fa-print"></span> Tampil Print</a> ';
                            echo '<a class="btn btn-sm btn-success" href="'.base_url().'excel/exportLapexcel/print_excel_data_barang" target="_blank" title="Export to Excel"><span class="fa fa-print"></span> Export Excel</a>';
                        }
                        ?>
                        </td>
                    </tr>

                    <tr>
                        <td style="text-align:center;vertical-align:middle">2</td>
                        <td style="vertical-align:middle;">Laporan Stok Barang</td>
                        <td style="text-align:center;">
                        <?php 
                        if($h=='1'){ 
                            echo '<a class="btn btn-sm btn-info" href="#lap_barang" data-toggle="modal" onclick="varCetakBarang(3)"><span class="fa fa-print"></span> Tampil Print</a> ';
                            echo '<a class="btn btn-sm btn-success" href="#lap_barang" data-toggle="modal" onclick="varCetakBarang(4)" title="Export to Excel"><span class="fa fa-print"></span> Export Excel</a>';
                        }else{
                            echo '<a class="btn btn-sm btn-info" href="'.base_url().'admin/laporan/lap_stok_barang" target="_blank"><span class="fa fa-print"></span> Tampil Print</a> ';
                            echo '<a class="btn btn-sm btn-success" href="'.base_url().'excel/exportLapexcel/print_excel_stok_barang" target="_blank" title="Export to Excel"><span class="fa fa-print"></span> Export Excel</a>';
                        }
                        ?>  
                        </td>
                    </tr>

                    <tr>
                        <td style="text-align:center;vertical-align:middle">3</td>
                        <td style="vertical-align:middle;">Laporan Penjualan</td>
                        <td style="text-align:center;">
                        <?php 
                        if($h=='1'){ 
                            echo '<a class="btn btn-sm btn-info" href="#lap_barang" data-toggle="modal" onclick="varCetakBarang(5)"><span class="fa fa-print"></span> Tampil Print</a> ';
                            echo '<a class="btn btn-sm btn-success" href="#lap_barang" data-toggle="modal" onclick="varCetakBarang(6)" title="Export to Excel"><span class="fa fa-print"></span> Export Excel</a>';
                        }else{
                            echo '<a class="btn btn-sm btn-info" href="'.base_url().'admin/laporan/lap_data_penjualan" target="_blank"><span class="fa fa-print"></span> Tampil Print</a> ';
                            echo '<a class="btn btn-sm btn-success" href="'.base_url().'excel/exportLapexcel/print_excel_penjualan" target="_blank" title="Export to Excel"><span class="fa fa-print"></span> Export Excel</a>';
                        }
                        ?>
                        </td>
                    </tr>

                    <tr>
                        <td style="text-align:center;vertical-align:middle">4</td>
                        <td style="vertical-align:middle;">Laporan Penjualan PerTanggal</td>
                        <td style="text-align:center;">
                        <?php 
                        if($h=='1'){ 
                            echo '<a class="btn btn-sm btn-info" href="#lap_jual_pertanggal" data-toggle="modal" onclick="varCetakJualTanggal(1)"><span class="fa fa-print"></span> Tampil Print</a> ';
                            echo '<a class="btn btn-sm btn-success" href="#lap_jual_pertanggal" data-toggle="modal" onclick="varCetakJualTanggal(2)" title="Export to Excel"><span class="fa fa-print"></span> Export Excel</a>';
                        }else{
                            echo '<a class="btn btn-sm btn-info" href="#lap_jual_pertanggal" data-toggle="modal" onclick="varCetakJualTanggal(3)"><span class="fa fa-print"></span> Tampil Print</a> ';
                            echo '<a class="btn btn-sm btn-success" href="#lap_jual_pertanggal" data-toggle="modal" onclick="varCetakJualTanggal(4)" title="Export to Excel"><span class="fa fa-print"></span> Export Excel</a>';
                        }
                        ?>
                        </td>
                    </tr>

                    <tr>
                        <td style="text-align:center;vertical-align:middle">5</td>
                        <td style="vertical-align:middle;">Laporan Penjualan PerBulan</td>
                        <td style="text-align:center;">
                        <?php 
                        if($h=='1'){ 
                            echo '<a class="btn btn-sm btn-info" href="#lap_jual_perbulan" data-toggle="modal" onclick="varCetakJualBulan(1)"><span class="fa fa-print"></span> Tampil Print</a> ';
                            echo '<a class="btn btn-sm btn-success" href="#lap_jual_perbulan" data-toggle="modal" onclick="varCetakJualBulan(2)" title="Export to Excel"><span class="fa fa-print"></span> Export Excel</a>';
                        }else{
                            echo '<a class="btn btn-sm btn-info" href="#lap_jual_perbulan" data-toggle="modal" onclick="varCetakJualBulan(3)"><span class="fa fa-print"></span> Tampil Print</a> ';
                            echo '<a class="btn btn-sm btn-success" href="#lap_jual_perbulan" data-toggle="modal" onclick="varCetakJualBulan(4)" title="Export to Excel"><span class="fa fa-print"></span> Export Excel</a>';
                        }
                        ?>
                        </td>
                    </tr>

                    <tr>
                        <td style="text-align:center;vertical-align:middle">6</td>
                        <td style="vertical-align:middle;">Laporan Penjualan PerTahun</td>
                        <td style="text-align:center;">
                        <?php 
                        if($h=='1'){ 
                            echo '<a class="btn btn-sm btn-info" href="#lap_jual_pertahun" data-toggle="modal" onclick="varCetakJualTahun(1)"><span class="fa fa-print"></span> Tampil Print</a> ';
                            echo '<a class="btn btn-sm btn-success" href="#lap_jual_pertahun" data-toggle="modal" onclick="varCetakJualTahun(2)" title="Export to Excel"><span class="fa fa-print"></span> Export Excel</a>';
                        }else{
                            echo '<a class="btn btn-sm btn-info" href="#lap_jual_pertahun" data-toggle="modal" onclick="varCetakJualTahun(3)"><span class="fa fa-print"></span> Tampil Print</a> ';
                            echo '<a class="btn btn-sm btn-success" href="#lap_jual_pertahun" data-toggle="modal" onclick="varCetakJualTahun(4)" title="Export to Excel"><span class="fa fa-print"></span> Export Excel</a>';
                        }
                        ?>
                        </td>
                    </tr>
                    
                    <?php if($h=='1'){  ?>
                    <tr>
                        <td style="text-align:center;vertical-align:middle">7</td>
                        <td style="vertical-align:middle;">Laporan Laba/Rugi</td>
                        <td style="text-align:center;">
                            <a class="btn btn-sm btn-info" href="#lap_laba_rugi" data-toggle="modal" onclick="varCetakLabaRugi('1')" title="Export to Excel"><span class="fa fa-print"></span> Tampil Print</a>
                            <a class="btn btn-sm btn-success" href="#lap_laba_rugi" data-toggle="modal" onclick="varCetakLabaRugi('2')" title="Export to Excel"><span class="fa fa-print"></span> Export Excel</a>
                        </td>
                    </tr>
                    <?php }?>
              
                </tbody>
            </table>
            </div>
        </div>
        <!-- /.row -->
        <!-- ============ MODAL ADD =============== -->
        <div class="modal fade" id="lap_barang" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 class="modal-title" id="myModalLabel">Pilih Cabang</h3>
            </div>
            <form class="form-horizontal" method="post" action="" target="_blank">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="control-label col-xs-3" >Cabang</label>
                        <div class="col-xs-9">
                            <select name="regions" class="selectpicker show-tick form-control" data-live-search="true" title="Pilih cabang" data-width="70%" placeholder="Pilih Cabang" required>
                            <?php foreach ($regions->result_array() as $rg) {
                                $reg_id=$rg['reg_id'];
                                $reg_name=$rg['reg_name'];
                                ?>
                                    <option value="<?php echo $reg_id;?>"><?php echo $reg_name;?></option>
                            <?php }?>
                                    <option value=0>Gabungan (Global)</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
                    <button class="btn btn-info"><span class="fa fa-print"></span> Tampilkan</button>
                </div>
            </form>
            </div>
            </div>
        </div>

        <!-- ============ MODAL ADD =============== -->
        <div class="modal fade" id="lap_jual_pertanggal" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <?php if($h=='1'){
                    echo '<h3 class="modal-title" id="myModalLabel">Pilih Cabang dan Tanggal</h3>';
                }else{
                    echo '<h3 class="modal-title" id="myModalLabel">Pilih Tanggal</h3>';
                }?>
            </div>
            <form class="form-horizontal" method="post" action="" target="_blank">
                <div class="modal-body">
                    <?php if($h=='1'){  ?>
                        <div class="form-group">
                            <label class="control-label col-xs-3" >Cabang</label>
                            <div class="col-xs-9">
                                <select name="regions" class="selectpicker show-tick form-control" data-live-search="true" title="Pilih cabang" data-width="71%" placeholder="Pilih Cabang" required>
                                <?php foreach ($regions->result_array() as $rg) {
                                    $reg_id=$rg['reg_id'];
                                    $reg_name=$rg['reg_name'];
                                    ?>
                                        <option value="<?php echo $reg_id;?>"><?php echo $reg_name;?></option>
                                <?php }?>
                                        <option value=0>Gabungan (Global)</option>
                                </select>
                            </div>
                        </div> 
                    <?php }?>   
                        <div class="form-group">
                            <label class="control-label col-xs-3" >Tanggal</label>
                            <div class="col-xs-9">
                                <div class='input-group date' id='datepicker' style="width:300px;">
                                    <input type='text' name="tgl" class="form-control" value="" placeholder="Tanggal..." required/>
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div> 
                </div>
                <div class="modal-footer">
                    <button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
                    <button class="btn btn-info"><span class="fa fa-print"></span> Tampilkan</button>
                </div>
            </form>
            </div>
            </div>
        </div>

        <!-- ============ MODAL ADD =============== -->
        <div class="modal fade" id="lap_jual_perbulan" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <?php if($h=='1'){
                    echo '<h3 class="modal-title" id="myModalLabel">Pilih Cabang dan Bulan</h3>';
                }else{
                    echo '<h3 class="modal-title" id="myModalLabel">Pilih Bulan</h3>';
                }?>
            </div>
            <form class="form-horizontal" method="post" action="" target="_blank">
                <div class="modal-body">
                    <?php if($h=='1'){  ?>
                        <div class="form-group">
                            <label class="control-label col-xs-3" >Cabang</label>
                            <div class="col-xs-9">
                                <select name="regions" class="selectpicker show-tick form-control" data-live-search="true" title="Pilih cabang" data-width="70%" placeholder="Pilih Cabang" required>
                                <?php foreach ($regions->result_array() as $rg) {
                                    $reg_id=$rg['reg_id'];
                                    $reg_name=$rg['reg_name'];
                                    ?>
                                        <option value="<?php echo $reg_id;?>"><?php echo $reg_name;?></option>
                                <?php }?>
                                        <option value=0>Gabungan (Global)</option>
                                </select>
                            </div>
                        </div> 
                    <?php }?>   
                    <div class="form-group">
                        <label class="control-label col-xs-3" >Bulan</label>
                        <div class="col-xs-9">
                                <select name="bln" class="selectpicker show-tick form-control" data-live-search="true" title="Pilih Bulan" data-width="70%" required/>
                                <?php foreach ($jual_bln->result_array() as $k) {
                                    $bln=$k['bulan'];
                                ?>
                                    <option><?php echo $bln;?></option>
                                <?php }?>
                                </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
                    <button class="btn btn-info"><span class="fa fa-print"></span> Tampilkan</button>
                </div>
            </form>
            </div>
            </div>
        </div>

        <!-- ============ MODAL ADD =============== -->
        <div class="modal fade" id="lap_jual_pertahun" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <?php if($h=='1'){
                    echo '<h3 class="modal-title" id="myModalLabel">Pilih Cabang dan Tahun</h3>';
                }else{
                    echo '<h3 class="modal-title" id="myModalLabel">Pilih Tahun</h3>';
                }?>
            </div>
            <form class="form-horizontal" method="post" action="" target="_blank">
                <div class="modal-body">
                    <?php if($h=='1'){  ?>
                        <div class="form-group">
                            <label class="control-label col-xs-3" >Cabang</label>
                            <div class="col-xs-9">
                                <select name="regions" class="selectpicker show-tick form-control" data-live-search="true" title="Pilih cabang" data-width="70%" placeholder="Pilih Cabang" required>
                                <?php foreach ($regions->result_array() as $rg) {
                                    $reg_id=$rg['reg_id'];
                                    $reg_name=$rg['reg_name'];
                                    ?>
                                        <option value="<?php echo $reg_id;?>"><?php echo $reg_name;?></option>
                                <?php }?>
                                        <option value=0>Gabungan (Global)</option>
                                </select>
                            </div>
                        </div> 
                    <?php }?> 
                    <div class="form-group">
                        <label class="control-label col-xs-3" >Tahun</label>
                        <div class="col-xs-9">
                                <select name="thn" class="selectpicker show-tick form-control" data-live-search="true" title="Pilih Tahun" data-width="70%" required/>
                                <?php foreach ($jual_thn->result_array() as $t) {
                                    $thn=$t['tahun'];
                                ?>
                                    <option><?php echo $thn;?></option>
                                <?php }?>
                                </select>
                        </div>
                    </div>           
                </div>
                <div class="modal-footer">
                    <button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
                    <button class="btn btn-info"><span class="fa fa-print"></span> Tampilkan</button>
                </div>
            </form>
            </div>
            </div>
        </div>


         <!-- ============ MODAL ADD =============== -->
        <div class="modal fade" id="lap_laba_rugi" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 class="modal-title" id="myModalLabel">Pilih Bulan</h3>
            </div>
            <form class="form-horizontal" method="post" action="" target="_blank">
                <div class="modal-body">
                    <div class="form-group">
                            <label class="control-label col-xs-3" >Cabang</label>
                            <div class="col-xs-9">
                                <select name="regions" class="selectpicker show-tick form-control" data-live-search="true" title="Pilih cabang" data-width="70%" placeholder="Pilih Cabang" required>
                                <?php foreach ($regions->result_array() as $rg) {
                                    $reg_id=$rg['reg_id'];
                                    $reg_name=$rg['reg_name'];
                                    ?>
                                        <option value="<?php echo $reg_id;?>"><?php echo $reg_name;?></option>
                                <?php }?>
                                        <option value=0>Gabungan (Global)</option>
                                </select>
                            </div>
                        </div> 
                    <div class="form-group">
                        <label class="control-label col-xs-3" >Bulan</label>
                        <div class="col-xs-9">
                                <select name="bln" class="selectpicker show-tick form-control" data-live-search="true" title="Pilih Bulan" data-width="70%" required>
                                <?php foreach ($jual_bln->result_array() as $k) {
                                    $bln=$k['bulan'];
                                ?>
                                    <option><?php echo $bln;?></option>
                                <?php }?>
                                </select>
                        </div>
                    </div>     
                </div>
                <div class="modal-footer">
                    <button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
                    <button class="btn btn-info"><span class="fa fa-print"></span> Tampilkan</button>
                </div>
            </form>
            </div>
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
    <script src="<?php echo base_url().'assets/dist/js/bootstrap-select.min.js'?>"></script>
    <script src="<?php echo base_url().'assets/js/bootstrap.min.js'?>"></script>
    <script src="<?php echo base_url().'assets/js/jquery.dataTables.min.js'?>"></script>
    <script src="<?php echo base_url().'assets/js/moment.js'?>"></script>
    <script src="<?php echo base_url().'assets/js/bootstrap-datetimepicker.min.js'?>"></script>
    <script type="text/javascript">
            $(function () {
                $('#datetimepicker').datetimepicker({
                    format: 'DD MMMM YYYY HH:mm',
                });
                
                $('#datepicker').datetimepicker({
                    format: 'YYYY-MM-DD',
                });
                $('#datepicker2').datetimepicker({
                    format: 'YYYY-MM-DD',
                });

                $('#timepicker').datetimepicker({
                    format: 'HH:mm'
                });
            });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#mydata').DataTable();
        } );
    </script>
    
    <script type="text/javascript">
    function varCetakBarang(nilai) {
        var form = document.querySelector('#lap_barang form');  
        if (nilai ==1) {
            form.action = "<?php echo base_url().'admin/laporan/lap_data_barang'?>";
        } else if (nilai ==2) {
            form.action = "<?php echo base_url().'excel/exportLapexcel/print_excel_data_barang'; ?>";
        } else if (nilai ==3) {
            form.action = "<?php echo base_url().'admin/laporan/lap_stok_barang'?>";
        } else if (nilai ==4) {
            form.action = "<?php echo base_url().'excel/exportLapexcel/print_excel_stok_barang'; ?>";
        } else if (nilai ==5) {
            form.action = "<?php echo base_url().'admin/laporan/lap_data_penjualan'?>";
        } else if (nilai ==6) {
            form.action = "<?php echo base_url().'excel/exportLapexcel/print_excel_penjualan'; ?>";
        }      
    }

    function varCetakJualTanggal(nilai) {
        var form = document.querySelector('#lap_jual_pertanggal form');  
        if (nilai ==1) {
            form.action = "<?php echo base_url().'admin/laporan/lap_penjualan_pertanggal'?>";
        } else if (nilai ==2) {
            form.action = "<?php echo base_url().'excel/exportLapexcel/print_excel_jual_tanggal'; ?>";
        } else if (nilai ==3) {
            form.action = "<?php echo base_url().'admin/laporan/lap_penjualan_pertanggal'?>";
        } else if (nilai ==4) {
            form.action = "<?php echo base_url().'excel/exportLapexcel/print_excel_jual_tanggal'; ?>";
        }
    }

    function varCetakJualBulan(nilai) {
        var form = document.querySelector('#lap_jual_perbulan form');  
        if (nilai ==1) {
            form.action = "<?php echo base_url().'admin/laporan/lap_penjualan_perbulan'?>";
        } else if (nilai ==2) {
            form.action = "<?php echo base_url().'excel/exportLapexcel/print_excel_jual_bulan'; ?>";
        } else if (nilai ==3) {
            form.action = "<?php echo base_url().'admin/laporan/lap_penjualan_perbulan'?>";
        } else if (nilai ==4) {
            form.action = "<?php echo base_url().'excel/exportLapexcel/print_excel_jual_bulan'; ?>";
        }
    }

    function varCetakJualTahun(nilai) {
        var form = document.querySelector('#lap_jual_pertahun form');  
        if (nilai ==1) {
            form.action = "<?php echo base_url().'admin/laporan/lap_penjualan_pertahun'?>";
        } else if (nilai ==2) {
            form.action = "<?php echo base_url().'excel/exportLapexcel/print_excel_jual_tahun'; ?>";
        } else if (nilai ==3) {
            form.action = "<?php echo base_url().'admin/laporan/lap_penjualan_pertahun'?>";
        } else if (nilai ==4) {
            form.action = "<?php echo base_url().'excel/exportLapexcel/print_excel_jual_tahun'; ?>";
        }
    }
    
    function varCetakLabaRugi(nilai) {
        var form = document.querySelector('#lap_laba_rugi form');  
        if (nilai === '1') {
            form.action = "<?php echo base_url().'admin/laporan/lap_laba_rugi'; ?>";
        } else if (nilai === '2') {
            form.action = "<?php echo base_url().'excel/exportLapexcel/print_excel_laba_rugi'; ?>";
        }      
    }

    


    </script>





</body>

</html>
