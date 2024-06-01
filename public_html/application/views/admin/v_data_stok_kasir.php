<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    // error_reporting(E_ALL);
    // ini_set('display_errors', 1); 
	error_reporting(0);
    $userid=$userid->row_array();
    $data_regid=$userid['reg_id'];
    ?>  
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Produk By <?php echo $userid['co_name'];?>">
    <meta name="author" content="<?php echo $userid['co_name'];?>">

    <title>Control Stok Barang</title>
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
        font-size: 10px; /* Sesuaikan dengan ukuran font yang diinginkan */
    }

    .bootstrap-datetimepicker-widget table {
        line-height: 1 !important; /* Sesuaikan dengan nilai yang sesuai */
    }

    .bootstrap-datetimepicker-widget table th,
    .bootstrap-datetimepicker-widget table td {
        padding: 1px !important; /* Sesuaikan dengan nilai yang sesuai */
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
        <div class="row">
            <div class="col-lg-12">
            <center><?php echo $this->session->flashdata('msg');?></center>
                <h3 class="page-header">Control Stok Barang - 
                    <small><?php echo $userid['reg_code'];?>  <?php echo $userid['reg_name'];?></small>
                </h3> 
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <form id="myForm" class="form-horizontal" method="post" action="">
                <table class="table table-bordered" style="font-size:12px;margin-bottom:10px;">
                    <input type="hidden" name="namacab" id="namacab" value="<?php echo $userid['reg_name'];?>">
                    <input type="text" name="regid" id="regid" class="form-control input-sm" style="width:50px;display:none;" value="<?php echo $userid['reg_id'];?>">
                    <tr>
                        <th style="width:6%;vertical-align:middle;border-top-color:white;border-right-color:white;border-left-color:white;">Bulan :</th>
                        <td style="width:12%;vertical-align:middle;border-top-color:white;border-right-color:white;">
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
                        <td style="width:10%;vertical-align:middle;border-top-color:white;border-right-color:white;">
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
                        <td style="width:10%;border-top-color:white;border-right-color:white;">
                            <a class="btn btn-sm btn-info btn-tampil" data-toggle="modal" title="Tampilkan Data"><span class="fa fa-search"></span></a>
                        </td>
                        <td style="width:15%;border-top-color:white;border-right-color:white;"> 
                        </td>
                        <!-- <td style="width:10%;text-align:right;border-top-color:white;border-right-color:white;">
                            <button class="btn btn-sm btn-info" title="Cetak Data" onclick="varCetak_Laporan()"><span class="fa fa-print"></span> Cetak Data</button>
                        </td> -->
                        <td style="width:5%;text-align:right;border-top-color:white;border-right-color:white;">
                            <button class="btn btn-sm btn-success" title="Export to Excel" onclick="varCetak_Excel()" title="Export to Excel"><span class="fa fa-print"></span> Export Excel</button>
                        </td>
                    </tr>
                </table>
                </form>
            </div>
        </div>
    
        <div class="row">
            <div class="col-lg-12">
                <table class="table table-striped table-bordered nowrap" style="font-size:11px;" id="mydata">
                    <thead>
                        <tr>
                            <th rowspan="2" style="text-align:center;vertical-align:middle;">No</th>
                            <th rowspan="2" style="text-align:center;vertical-align:middle;">Kode Barang</th>
                            <th rowspan="2" style="max-width:200px;text-align:center;vertical-align:middle;">Nama Barang</th>
                            <th colspan="5" style="text-align:center;color:white;background-color:grey;">STOK</th>
                            <th rowspan="2" style="text-align:center;vertical-align:middle;" title="Harga Jual/Pricelist Per Satuan Barang">Harga Jual</th>
                            <th rowspan="2" style="text-align:center;vertical-align:middle;" title="Total Harga Jual/Pricelist dikalikan Jumlah Stok Akhir Barang">Total Harga Jual</th>
                            <th rowspan="2" style="text-align:center;vertical-align:middle;">Satuan</th>
                            <th rowspan="2" style="text-align:center;vertical-align:middle;">Kategori</th>
                            <th rowspan="2" style="text-align:center;vertical-align:middle;">Aksi</th>
                        </tr>  
                        <tr>
                            <th style="text-align:center;color:#4f81bd;">Awal</th>
                            <th style="text-align:center;color:#c0504d;">Penambahan</th>
                            <th style="text-align:center;color:#9bbb59;">Pengurangan</th>
                            <th style="text-align:center;color:#ee0e0e;">Retur</th>
                            <th style="text-align:center;color:#FFD700;">Akhir</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                        $no=0;
                        foreach ($data->result_array() as $a):
                            $no++;
                            $id=$a['barang_id'];
                            $nm=$a['barang_nama'];
                            //$stok_awal=$a['stok_awal'];
                            //$stok_tambah=$a['stok_tambah'];
                            //$stok_kurang=$a['stok_kurang'];
                            //$retur=$a['retur'];
                            //$harpok=$a['barang_harpok'];
                            $harjul=$a['barang_harjul'];
                            //$totharpok=$a['Total_Harpok'];
                            $totharjul=$a['Total_Harjul'];
                            $satuan=$a['barang_satuan'];
                            $kategori=$a['barang_kategori_nama'];

                           
                            $stok=$a['stok_cabang'];
                            if (floor($stok) == $stok) {
                                $formatted_stok = number_format($stok, 0, ',', '.');
                            } else {
                                $formatted_stok = number_format($stok, 2, ',', '.');
                                $formatted_stok = rtrim($formatted_stok, '0');
                                $formatted_stok = rtrim($formatted_stok, ',');
                            }   

                            $stok_awal=$a['stok_awal'];
                            if (floor($stok_awal) == $stok_awal) {
                                $formatted_stok_awal = number_format($stok_awal, 0, ',', '.');
                            } else {
                                $formatted_stok_awal = number_format($stok_awal, 2, ',', '.');
                                $formatted_stok_awal = rtrim($formatted_stok_awal, '0');
                                $formatted_stok_awal = rtrim($formatted_stok_awal, ',');
                            }
                            $stok_tambah=$a['stok_tambah'];
                            if (floor($stok_tambah) == $stok_tambah) {
                                $formatted_stok_tambah = number_format($stok_tambah, 0, ',', '.');
                            } else {
                                $formatted_stok_tambah = number_format($stok_tambah, 2, ',', '.');
                                $formatted_stok_tambah = rtrim($formatted_stok_tambah, '0');
                                $formatted_stok_tambah = rtrim($formatted_stok_tambah, ',');
                            }
                            $stok_kurang=$a['stok_kurang'];
                            if (floor($stok_kurang) == $stok_kurang) {
                                $formatted_stok_kurang = number_format($stok_kurang, 0, ',', '.');
                            } else {
                                $formatted_stok_kurang = number_format($stok_kurang, 2, ',', '.');
                                $formatted_stok_kurang = rtrim($formatted_stok_kurang, '0');
                                $formatted_stok_kurang = rtrim($formatted_stok_kurang, ',');
                            }
                            $retur=$a['retur'];
                            if (floor($retur) == $retur) {
                                $formatted_retur = number_format($retur, 0, ',', '.');
                            } else {
                                $formatted_retur = number_format($retur, 2, ',', '.');
                                $formatted_retur = rtrim($formatted_retur, '0');
                                $formatted_retur = rtrim($formatted_retur, ',');
                            }
                    ?>
                        <tr>
                            <td style="text-align:center;"><?php echo $no;?></td>
                            <td><?php echo $id;?></td>
                            <td style="max-width:200px;overflow:hidden;"><?php echo $nm;?></td>
                            <td style="text-align:center;"><?php echo $formatted_stok_awal;?></td>
                            <td style="text-align:center;"><?php echo $formatted_stok_tambah;?></td>
                            <td style="text-align:center;"><?php echo $formatted_stok_kurang;?></td>
                            <td style="text-align:center;"><?php echo $formatted_retur;?></td>
                            <td style="text-align:center;"><?php echo $formatted_stok;?></td>
                            <td style="text-align:right;"><?php echo 'Rp ' . str_replace(',', '.', number_format($harjul)); ?></td>
                            <td style="text-align:right;"><?php echo 'Rp ' . str_replace(',', '.', number_format($totharjul)); ?></td>
                            <td style="text-align:center;"><?php echo $satuan;?></td>
                            <td style="text-align:center;"><?php echo $kategori;?></td>
                        <td style="text-align:center;">
                            <a class="btn btn-xs btn-warning btn-lihat" href="#modalLihat" data-toggle="modal" data-idbrg="<?= $id ;?>" data-nmbrg="<?= htmlspecialchars($nm);?>" title="Lihat Data"><span class="fa fa-eye"></span> Lihat Data</a>
                        </td>    
                            
                        </tr>
                    <?php endforeach;?>
                    </tbody>
                </table>
            </div>
        </div>
   
        
        <!-- ============ MODAL LIHAT =============== -->
        <div class="modal fade" id="modalLihat" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
            <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 class="modal-title" id="myModalLabel">Data History Stok - <small><?php echo $userid['reg_code'];?>  <?php echo $userid['reg_name'];?></small></h3>
            </div>
                <div class="modal-body" style="overflow:scroll;height:450px;">
                    <p style="font-size: 11px; margin-bottom: 0;">
                    Kode Barang : <b><span id="kdbrgVal" style="color: green;"></span></b>
                    </p>
                    <p style="font-size: 11px; margin-bottom: 0;">
                    Nama Barang : <b><span id="nmbrgVal"></span></b>
                    </p>  
                    <input type="hidden" id="kdbrg" name="kdbrg">      
                <table style="font-size:12px;margin-bottom:10px;">
                    <tr>
                        <th style="width:7%;vertical-align:middle;">Tgl Transaksi :</th>
                        <td style="width:10%;vertical-align:middle;">
                            <div class="input-group date" id="datepicker1">
                                <input type="text" id="tgl1" name="tgl1" class="form-control input-sm" style="font-size:11px;color:green;" placeholder="Tanggal..." value="<?= $firstDayOfMonth; ?>" required>
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </td>
                        <td style="width:3%;vertical-align:middle;text-align:center"> S/d</td>
                        <td style="width:10%;vertical-align:middle;">
                            <div class="input-group date" id="datepicker2">
                                <input type="text" id="tgl2" name="tgl2" class="form-control input-sm" style="font-size:11px;color:green;" placeholder="Tanggal..." value="<?= $lastDayOfMonth; ?>" required>
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </td>
                        <td style="width:5%;vertical-align:middle;padding-left:10px;">
                            <a class="btn btn-sm btn-info btn-history" data-toggle="modal" title="Tampilkan Data"><span class="fa fa-search"></span></a>
                        </td>
                        <td style="width:30%;text-align:right;border-top-color:white;border-right-color:white;">
                        </td>
                    </tr>
                </table>
                
                <table id="tbl_history" class="table table-striped table-bordered" style="font-size:11px;">
                    <thead>
                        <tr>
                            <th style="text-align:center;"> No</th>
                            <th style="text-align:center;"> Tgl Input</th>
                            <th style="text-align:center;"> Stok No</th>
                            <th style="text-align:center"> Keterangan</th>
                            <th style="text-align:center"> Stok Status</th>
                            <th style="text-align:center"> Stok In</th>
                            <th style="text-align:center"> Stok Out</th>
                            <th style="text-align:center"> Cabang</th>
                            <th style="text-align:center"> Created By</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>        
                </div>
                <div class="modal-footer">
                    <button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>    
                </div>
            </div>
            </div>
        </div>
                        
    </div> 

    <!-- ============ MODAL Ubah Tanggal Stok =============== -->
        <div id="modalUbah" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 class="modal-title" id="myModalLabel"><small>Edit Tanggal Input Stok</small></h3>
            </div>
                <div class="modal-body">
                <p style="font-size: 11px; margin-bottom: 0;">
                Kode Barang : <b><span id="kdbrgVal2" style="color: green;"></span></b>
                </p>
                <p style="font-size: 11px; margin-bottom: 0;">
                Nama Barang : <b><span id="nmbrgVal2"></span></b>
                </p>               
                <input type="hidden" id="txtstokid" name="txtstokid">
                <table id="tbl_stok" class="table table-bordered table-condensed" style="font-size:11px;">
                <thead>
                <tr>
                    <th style="text-align:center;"> Tgl Input</th>
                    <th style="text-align:center;"> Stok No</th>
                    <th style="text-align:center"> Keterangan</th>
                    <th style="text-align:center"> Stok Status</th>
                    <th style="text-align:center"> Stok In</th>
                    <th style="text-align:center"> Stok Out</th>
                    <th style="text-align:center"> Cabang</th>
                    <th style="text-align:center"> Created By</th>
                </tr>
                </thead>
                <tbody></tbody>
                </table>  
                <hr/>
                <p> Silahkan Tentukan Tanggal Input :</p>
                <table class="table table-bordered table-condensed" style="font-size:11px;">
                    <tr>
                        <th style="width:20%;vertical-align:middle;">Tgl Input :</th>
                        <td style="width:80%;vertical-align:middle;">
                            <div style="width:130px;" class="input-group date" id="datepicker3">
                                <input type="text" id="tgl3" name="tgl3" class="form-control input-sm" style="font-size:11px;color:green;" placeholder="Tanggal..." value="<?= $firstDayOfMonth; ?>" required>
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </td>
                    </tr>
                </table>
                <p> Proses ini hanya akan merubah <b>Tanggal Input Stok</b> agar terhitung pada bulan laporan data stok yang dimaksud.</p>  
                </div>
                <div class="modal-footer">
                    <button class="btn btn-info btn-update" data-dismiss="modal" aria-hidden="true">Update</button>    
                    <button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
                </div>
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
    <!-- Data Table Fixed Column-->
    <script src="<?php echo base_url().'assets/js/dataTable/dataTables.fixedColumns.min.js'?>"></script>

  
        
                            
<!-- <script type="text/javascript">  
$(document).ready(function() {
    //$('#mydata').DataTable();
    var table = $('#mydata').DataTable({
        ordering: false
    });
} );
</script> -->
<script type="text/javascript">
$(document).ready(function () {
    $('#datepicker1').datetimepicker({
    format: 'YYYY-MM-DD',
    widgetPositioning: {
        vertical: 'bottom',
        horizontal: 'auto'
        }
    });
    $('#datepicker2').datetimepicker({
    format: 'YYYY-MM-DD',
    widgetPositioning: {
        vertical: 'bottom',
        horizontal: 'auto'
        }
    });
    $('#datepicker3').datetimepicker({
    format: 'YYYY-MM-DD',
    widgetPositioning: {
        vertical: 'bottom',
        horizontal: 'auto'
        }
    });
});
</script>

<script type="text/javascript">  
$(document).ready(function() {
    var table = $('#mydata').DataTable({
        scrollY: "450px",
        scrollX: true,
        scrollCollapse: true,
        paging: true,
        fixedColumns: {
            left: 3,
            right: 1
        },
        ordering: false
    });
    
});
</script>

<script type="text/javascript">
$(document).ready(function () {
    $(document).on('click', '.btn-tampil', function () {
        var form = document.querySelector('#myForm'); 
        form.action = "<?php echo base_url().'admin/data_stok/tampil_rekap';?>"; 
        form.target = '_self';
        form.submit(); // Mengirimkan formulir
    });
});
</script>

<script>
    // function varCetak_Laporan() {
    //     var form = document.querySelector('#myForm'); 
    //     form.action = "<?php echo base_url().'admin/data_stok/cetak_data_stok';?>";
    //     form.target = '_blank';
    //     form.submit(); // Mengirimkan formulir
    // }
    function varCetak_Excel() {
        var form = document.querySelector('#myForm'); 
        form.action = "<?php echo base_url().'admin/data_stok/cetak_stok_excel';?>";
        //form.target = '_blank';
        form.submit(); // Mengirimkan formulir
    }
</script>


<script type="text/javascript">
$(document).ready(function () {
    $(document).on('click', '.btn-lihat', function () {
        var idbrg = $(this).data('idbrg');
        var nmbrg = $(this).data('nmbrg');
        $('#kdbrgVal').text(idbrg);
        $('#nmbrgVal').text(nmbrg);
        $('#kdbrg').val(idbrg);
        tampil_stok();

    });
    
    $(document).on('click', '.btn-history', function () {
        tampil_stok();
    });

    function tampil_stok() {
        $('#tbl_history tbody').empty();
        var tgl1 = $('#tgl1').val();
        var tgl2 = $('#tgl2').val();
        var idbrg=$('#kdbrg').val();
        var regid = $('#regid').val();
        $.ajax({
            url: "<?php echo base_url().'admin/data_stok/history_stok';?>",
            type: "POST",
            data: {
                tgl1: tgl1,
                tgl2: tgl2,
                idbrg: idbrg,
                regid: regid
            },
            success: function (data) {
                //console.log("Data from server:", data);
                //console.log(regid);
                // console.log(tgl1);
                // console.log(tgl2);
                try {
                    var parsedData = JSON.parse(data);
                    if ("error" in parsedData) {
                        console.log(parsedData.error); // Tampilkan pesan error
                    } else if (parsedData.length !== 0) {
                        var no=0;
                        $.each(parsedData, function (index, item) {
                                no++;
                                var stokin = parseFloat(item.stok_in);
                                var stokout = parseFloat(item.stok_out);
                                var formatted_stokin;
                                if (Math.floor(stokin) === stokin) {
                                    formatted_stokin = stokin.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ','); // Format sebagai bilangan bulat
                                } else {
                                    formatted_stokin = stokin.toFixed(2).replace('.', ',').replace(/\.?0+$/, '').replace(/\B(?=(\d{3})+(?!\d))/g, ','); // Format sebagai bilangan desimal
                                }
                                var formatted_stokout;
                                if (Math.floor(stokout) === stokout) {
                                    formatted_stokout = stokout.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ','); // Format sebagai bilangan bulat
                                } else {
                                    formatted_stokout = stokout.toFixed(2).replace('.', ',').replace(/\.?0+$/, '').replace(/\B(?=(\d{3})+(?!\d))/g, ','); // Format sebagai bilangan desimal
                                }
                                var newRow = '<tr>' +
                                    '<td style="font-size:11px;text-align:center;">' + no + '</td>' +
                                    '<td style="font-size:11px;"><a class="btn-ubah" href="#modalUbah" data-toggle="modal" data-stokid="' + item.stok_id +'" data-idbrg="' + item.brg_id +'" data-nmbrg="' + item.brg_nama +'" title="Edit tanggal Input Pada Data Stok"><span class="fa fa-edit"></span></a> ' + item.stok_tgl + '</td>' +
                                    '<td style="font-size:11px;">' + item.stok_no + '</td>' +
                                    '<td style="font-size:11px;text-align:center;">' + item.stok_ket + '</td>' +
                                    '<td style="font-size:11px;text-align:center;">' + item.stok_status + '</td>' +
                                    '<td style="font-size:11px;text-align:center;">' + formatted_stokin + '</td>' +
                                    '<td style="font-size:11px;text-align:center;">' + formatted_stokout + '</td>' +
                                    '<td style="font-size:11px;text-align:center;">' + item.reg_name + '</td>' +
                                    '<td style="font-size:11px;text-align:center;">' + item.created_by + '</td>' +
                                    '</tr>';
                                $('#tbl_history tbody').append(newRow);

                        });
                        
                    } else {
                        console.log("No data found.");
                    }
                } catch (error) {
                    console.error("Error parsing JSON:", error);
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX error:", error);
            }
        });
    }

    $(document).on('click', '.btn-ubah', function () {
        $('#tbl_stok tbody').empty();
        var stokid = $(this).data('stokid');
        var idbrg = $(this).data('idbrg');
        var nmbrg = $(this).data('nmbrg');
        $('#txtstokid').val(stokid);
        $('#kdbrgVal2').text(idbrg);
        $('#nmbrgVal2').text(nmbrg);


         $.ajax({
            url: "<?php echo base_url().'admin/data_stok/get_stok';?>",
            type: "POST",
            data: {
                stokid: stokid
            },
            success: function (data) {
                //console.log("Data from server:", data);
                try {
                    var parsedData = JSON.parse(data);
                    if ("error" in parsedData) {
                        console.log(parsedData.error); // Tampilkan pesan error
                    } else if (parsedData.length !== 0) {
                        $.each(parsedData, function (index, item) {
                                var stokin = parseFloat(item.stok_in);
                                var stokout = parseFloat(item.stok_out);
                                var formatted_stokin;
                                if (Math.floor(stokin) === stokin) {
                                    formatted_stokin = stokin.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ','); // Format sebagai bilangan bulat
                                } else {
                                    formatted_stokin = stokin.toFixed(2).replace('.', ',').replace(/\.?0+$/, '').replace(/\B(?=(\d{3})+(?!\d))/g, ','); // Format sebagai bilangan desimal
                                }
                                var formatted_stokout;
                                if (Math.floor(stokout) === stokout) {
                                    formatted_stokout = stokout.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ','); // Format sebagai bilangan bulat
                                } else {
                                    formatted_stokout = stokout.toFixed(2).replace('.', ',').replace(/\.?0+$/, '').replace(/\B(?=(\d{3})+(?!\d))/g, ','); // Format sebagai bilangan desimal
                                }
                                var newRow = '<tr>' +
                                    '<td style="font-size:11px;">' + item.stok_tgl + '</td>' +
                                    '<td style="font-size:11px;">' + item.stok_no + '</td>' +
                                    '<td style="font-size:11px;">' + item.stok_ket + '</td>' +
                                    '<td style="font-size:11px;text-align:center;">' + item.stok_status + '</td>' +
                                    '<td style="font-size:11px;text-align:center;">' + formatted_stokin + '</td>' +
                                    '<td style="font-size:11px;text-align:center;">' + formatted_stokout + '</td>' +
                                    '<td style="font-size:11px;text-align:center;">' + item.reg_name + '</td>' +
                                    '<td style="font-size:11px;text-align:center;">' + item.created_by + '</td>' +
                                    '</tr>';
                                $('#tbl_stok tbody').append(newRow);

                        });
                        
                    } else {
                        console.log("No data found.");
                    }
                } catch (error) {
                    console.error("Error parsing JSON:", error);
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX error:", error);
            }
        });
    });

    $(document).on('click', '.btn-update', function () {
        $('#tbl_stok tbody').empty();
        var stokid3 =  $('#txtstokid').val();
        var tgl3 = $('#tgl3').val();
        $.ajax({
            url: "<?php echo base_url().'admin/data_stok/update_stok';?>",
            type: "POST",
            data: {
                stokid3: stokid3,
                tgl3: tgl3
            },
            success: function (data) {
                if (data.error) {
                    alert('Terjadi kesalahan: ' + data.error); // Memberikan umpan balik kepada pengguna
                } else {
                    tampil_stok();
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX error:", error);
            }
        });
    });

    

    
});
</script>




</body>
</html>
