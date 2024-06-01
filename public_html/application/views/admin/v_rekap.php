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

    <title>Rekapitulasi</title>
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

    .grand-total {
      position: sticky;
      left: 0;
      background-color: #027c3f;
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
            <div class="col-lg-12" style="display: flex; justify-content: space-between; align-items: center;">
                <h3 style="margin: 0;">Rekapitulasi Data <small>Penjualan</small></h3>
                <div style="display: flex; align-items: center;">
                    <span style="margin-right: 10px; white-space:nowrap;font-weight: bold;">Periode Tahun : </span>
                    <form id="formTahun" action="<?php echo base_url().'admin/rekap/tampil_rekap';?>" method="GET">
                        <select name="thn" id="thn" class="selectpicker show-tick form-control" data-live-search="true" title="Pilih Tahun" data-width="100%" required>
                            <?php foreach ($jual_thn->result_array() as $t) {
                                $thn=$t['tahun'];
                            ?>
                                <option value="<?php echo $thn; ?>" <?php echo ($tahun == $thn) ? 'selected' : ''; ?>><?php echo $thn; ?></option>
                            <?php }?>
                        </select>
                    </form>
                    <form id="myForm" class="form-horizontal" method="post" action="">
                        <input type="hidden" id="thn2" name="thn2" value="<?php echo $tahun; ?>"> 
                    <button style="margin-left:20px;margin-top:-5px;" class="btn btn-sm btn-success" title="Export to Excel" onclick="varCetak_Excel()"><span class="fa fa-print"></span> Export Excel</button>
                    </form>
                </div>
            </div>
            <div class="col-lg-12">
                <hr></hr>
            </div>
        </div>
    
        <div class="row">
            <div class="col-lg-12">
                <table class="table table-striped table-bordered nowrap" style="font-size:11px;" id="mydata">  
                    <thead>
                        <tr>
                            <th rowspan="2" style="text-align:center;vertical-align:middle;color:white;background-color:#eb1b28;">No</th>
                            <th rowspan="2" style="text-align:center;vertical-align:middle;color:white;background-color:#eb1b28;">Cabang</th>

                            <?php for ($bulan = 1; $bulan <= $jml_bln; $bulan++): ?>
                                <th colspan="5" style="text-align:center;color:white;background-color:black;"><?= date('M Y', strtotime("$tahun-$bulan")); ?></th>
                            <?php endfor; ?>
                            <th colspan="5" style="text-align:center;color:white;background-color:black;">Total <?= date('M', strtotime("$tahun-1")); ?> s.d <?= date('M', strtotime("$tahun-$jml_bln")); ?> <?= $tahun; ?></th>
                            <th rowspan="3" style="text-align:center;vertical-align:middle;color:white;background-color:#eb1b28;">Aksi</th>
                        </tr>
                        <tr>
                            <?php for ($bulan = 1; $bulan <= $jml_bln; $bulan++): ?>
                                <th style="text-align:center;color:#4f81bd;background-color:white">Omzet</th>
                                <th style="text-align:center;color:#c0504d;background-color:white">Piutang</th>
                                <th style="text-align:center;color:#9bbb59;background-color:white">Pelunasan</th>
                                <th style="text-align:center;color:#FFD700;background-color:white">Pengeluaran</th>
                                <th style="text-align:center;color:#030305;background-color:white">Transfer</th>
                            <?php endfor; ?>
                                <th style="text-align:center;color:#4f81bd;background-color:white">Omzet</th>
                                <th style="text-align:center;color:#c0504d;background-color:white">Piutang</th>
                                <th style="text-align:center;color:#9bbb59;background-color:white">Pelunasan</th>
                                <th style="text-align:center;color:#FFA700;background-color:white">Pengeluaran</th>
                                <th style="text-align:center;color:#030305;background-color:white">Transfer</th>
                        </tr>
                        
                        
                        <tr>
                            <th colspan="2" class="grand-total" style="text-align:right;font-weight:bold;color:white;background-color:#027c3f;">Grand Total</th>
                            <?php
                                $grandTotalOmzet = $grandTotalPiutang = $grandTotalPelunasan = $grandTotalPengeluaran = $grandTotalTransfer = 0;
                                for ($bulan = 1; $bulan <= $jml_bln; $bulan++):
                                    $totalOmzet = $totalPiutang = $totalPelunasan = $totalPengeluaran = $totalTransfer = 0;
                                    foreach ($data->result_array() as $a):
                                        $totalOmzet += $a['omzet' . $bulan];
                                        $totalPiutang += $a['piutang' . $bulan];
                                        $totalPelunasan += $a['pelunasan' . $bulan];
                                        $totalPengeluaran += $a['pengeluaran' . $bulan];
                                        $totalTransfer += $a['transfer' . $bulan];
                                    endforeach;
                                    echo '<th style="text-align:right;font-weight:bold;color:white;background-color:#027c3f"> Rp ' . str_replace(',', '.', number_format($totalOmzet)) . '</th>';
                                    echo '<th style="text-align:right;font-weight:bold;color:white;background-color:#027c3f"> Rp ' . str_replace(',', '.', number_format($totalPiutang)) . '</th>';
                                    echo '<th style="text-align:right;font-weight:bold;color:white;background-color:#027c3f"> Rp ' . str_replace(',', '.', number_format($totalPelunasan)) . '</th>';
                                    echo '<th style="text-align:right;font-weight:bold;color:white;background-color:#027c3f"> Rp ' . str_replace(',', '.', number_format($totalPengeluaran)) . '</th>';
                                    echo '<th style="text-align:right;font-weight:bold;color:white;background-color:#027c3f"> Rp ' . str_replace(',', '.', number_format($totalTransfer)) . '</th>';
                                    $grandTotalOmzet += $totalOmzet;
                                    $grandTotalPiutang += $totalPiutang;
                                    $grandTotalPelunasan += $totalPelunasan;
                                    $grandTotalPengeluaran += $totalPengeluaran;
                                    $grandTotalTransfer += $totalTransfer;
                                endfor;
                                    echo '<th style="text-align:right;font-weight:bold;color:white;background-color:#027c3f"> Rp ' . str_replace(',', '.', number_format($grandTotalOmzet)) . '</th>';
                                    echo '<th style="text-align:right;font-weight:bold;color:white;background-color:#027c3f"> Rp ' . str_replace(',', '.', number_format($grandTotalPiutang)) . '</th>';
                                    echo '<th style="text-align:right;font-weight:bold;color:white;background-color:#027c3f"> Rp ' . str_replace(',', '.', number_format($grandTotalPelunasan)) . '</th>';
                                    echo '<th style="text-align:right;font-weight:bold;color:white;background-color:#027c3f"> Rp ' . str_replace(',', '.', number_format($grandTotalPengeluaran)) . '</th>';
                                    echo '<th style="text-align:right;font-weight:bold;color:white;background-color:#027c3f"> Rp ' . str_replace(',', '.', number_format($grandTotalTransfer)) . '</th>';
                            ?>
                           
                        </tr>
                        
                    </thead>
                    <tbody>
                        <?php 
                        $no = 0;
                        foreach ($data->result_array() as $a):
                            $no++;
                            $id = $a['reg_id'];
                            $cab = $a['reg_name'];

                            $totalOmzet = $totalPiutang = $totalPelunasan = $totalPengeluaran = $totalTransfer = 0;
                        ?>
                            <tr>
                                <td style="text-align:center;"><?php echo $no;?></td>
                                <td><?php echo $cab;?></td>
                                
                                <?php for ($bulan = 1; $bulan <= $jml_bln; $bulan++): 
                                    $totalOmzet += $a['omzet' . $bulan];
                                    $totalPiutang += $a['piutang' . $bulan];
                                    $totalPelunasan += $a['pelunasan' . $bulan];
                                    $totalPengeluaran += $a['pengeluaran' . $bulan];
                                    $totalTransfer += $a['transfer' . $bulan];
                                ?>
                                    <td style="text-align:right;"><?php echo 'Rp ' . str_replace(',', '.', number_format($a['omzet' . $bulan]));?></td>
                                    <td style="text-align:right;"><?php echo 'Rp ' . str_replace(',', '.', number_format($a['piutang' . $bulan]));?></td>
                                    <td style="text-align:right;"><?php echo 'Rp ' . str_replace(',', '.', number_format($a['pelunasan' . $bulan]));?></td>
                                    <td style="text-align:right;"><?php echo 'Rp ' . str_replace(',', '.', number_format($a['pengeluaran' . $bulan]));?></td>
                                    <td style="text-align:right;"><?php echo 'Rp ' . str_replace(',', '.', number_format($a['transfer' . $bulan]));?></td>
                                <?php endfor; ?>
                                    <td style="text-align:right;font-weight:bold;color:#4f81bd;background-color:#f2f2f2;"><?php echo 'Rp ' . str_replace(',', '.', number_format($totalOmzet));?></td>
                                    <td style="text-align:right;font-weight:bold;color:#c0504d;background-color:#f2f2f2;"><?php echo 'Rp ' . str_replace(',', '.', number_format($totalPiutang));?></td>
                                    <td style="text-align:right;font-weight:bold;color:#9bbb59;background-color:#f2f2f2;"><?php echo 'Rp ' . str_replace(',', '.', number_format($totalPelunasan));?></td>
                                    <td style="text-align:right;font-weight:bold;color:#FFA700;background-color:#f2f2f2;"><?php echo 'Rp ' . str_replace(',', '.', number_format($totalPengeluaran));?></td>
                                    <td style="text-align:right;font-weight:bold;color:#030305;background-color:#f2f2f2;"><?php echo 'Rp ' . str_replace(',', '.', number_format($totalTransfer));?></td>
                                <td style="text-align:center;">
                                    <a class="btn btn-xs btn-warning btn-lihat" href="#modalLihat" data-toggle="modal" data-regid="<?= $id ;?>" data-cabang="<?= $cab ;?>" title="Lihat Data"><span class="fa fa-eye"></span> Lihat Data</a>
                                </td>
                            </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
            </div>
        </div>


<!-- ============ MODAL Lihat =============== -->
        <div class="modal fade" id="modalLihat" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
            <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 class="modal-title" id="myModalLabel"><small>Cabang : <span id="cabVal"> </span></small></h3>
            </div>
            
                <div class="modal-body" style="overflow:scroll;height:400px;">
                    <input name="regid" id="regid" type="hidden">
                    <table style="font-size:11px;margin-bottom:5px;width:100%;">
                        <tr>
                            <th style="width:5%;vertical-align:middle;">Pencarian :</th>
                            <td style="width:18%;vertical-align:middle;">
                                <select name="cari" id="cari" class="selectpicker show-tick form-control" title="Pilih Pencarian" placeholder="Pilih Pencarian" required>
                                    <option value="omzet" style='font-size:11px;'>Omzet </option>
                                    <option value="jualtunai" style='font-size:11px;'>Penjualan Tunai </option>
                                    <option value="piutang" style='font-size:11px;'>Piutang </option>
                                    <option value="pelunasan" style='font-size:11px;'>Pelunasan</option>
                                    <option value="pengeluaran" style='font-size:11px;'>Pengeluaran</option>
                                    <option value="transfer" style='font-size:11px;'>Transfer</option>
                                </select>
                            </td>
                            <th style="width:10%;vertical-align:middle;text-align:center;padding-left:5px;">Tgl Transaksi :</th>
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
                            <td style="width:10%;vertical-align:middle;padding-left:10px;">
                                <a class="btn btn-sm btn-info btn-tampil" data-toggle="modal" title="Tampilkan Data"><span class="fa fa-search"></span></a>
                            </td>
                        </tr>
                    </table>
                    <hr/>
                    <table id="tbl_tampil" class="table table-striped table-bordered" style="font-size:11px;">
                        <thead></thead>
                        <tbody></tbody>
                    </table>    
                </div>
               
            
                <div class="modal-footer">
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
});
</script>

<script type="text/javascript">  
$(document).ready(function() {
    var table = $('#mydata').DataTable({
        //scrollY: "400px",
        scrollX: true,
        scrollCollapse: true,
        paging: true,
        fixedColumns: {
            left: 2,
            right: 1
        },
        ordering: false
    });
});
</script>

<script type="text/javascript"> 
    $(document).ready(function () {
        $('#thn').change(function () {
            $('#formTahun').submit();

        });
    });   
</script>

<script type="text/javascript">
 $(document).ready(function () {
        $(document).on('click', '.btn-lihat', function () {
        var id = $(this).data('regid');
        var cab = $(this).data('cabang');
        $('#regid').val(id);
        $('#cabVal').text(cab);
        });
    });

$(document).ready(function () {
    $('select[name="cari"]').on('change', function() {
        $('#tbl_tampil thead').empty();
        $('#tbl_tampil tbody').empty();
        var cari=$('#cari').val();
        if (cari==="omzet" || cari==="jualtunai" || cari==="piutang") {
            var newHead = '<tr>' +
            '<th style="text-align:center;"> No</th>' +
            '<th style="text-align:center;"> Tanggal</th>' +
            '<th style="text-align:center"> No Faktur</th>' + 
            '<th style="text-align:center"> Nama Customer</th>' +
            '<th style="text-align:center"> No Nota</th>' + 
            '<th style="text-align:center"> Jenis Bayar</th>' +
            '<th style="text-align:center"> Status Bayar</th>' +
            '<th style="text-align:center"> Total Jual</th>' +
            '</tr>';
            $('#tbl_tampil thead').append(newHead);
        } else if (cari==="pelunasan") {
            var newHead = '<tr>' +
            '<th style="text-align:center;"> No</th>' +
            '<th style="text-align:center;"> Tanggal</th>' +
            '<th style="text-align:center"> No Faktur</th>' + 
            '<th style="text-align:center"> Nama Customer</th>' + 
            '<th style="text-align:center"> No Nota</th>' + 
            '<th style="text-align:center"> Status Bayar</th>' +
            '<th style="text-align:center"> Jumlah Bayar</th>' +
            '</tr>';
            $('#tbl_tampil thead').append(newHead);
        } else if (cari==="pengeluaran" || cari==="transfer") {
            var newHead = '<tr>' +
            '<th style="text-align:center;"> No</th>' +
            '<th style="text-align:center;"> Tanggal</th>' +
            '<th style="text-align:center"> Keterangan</th>' + 
            '<th style="text-align:center"> Jumlah</th>' + 
            '</tr>';
            $('#tbl_tampil thead').append(newHead);
        }
        
    });
});
</script>

<script type="text/javascript">
$(document).ready(function () {
    $(document).on('click', '.btn-tampil', function () {
        $('#tbl_tampil tbody').empty();
        var regid = $('#regid').val();
        var cari2 = $('#cari').val();
        var tgl1 = $('#tgl1').val();
        var tgl2 = $('#tgl2').val();

        $.ajax({
            url: "<?php echo base_url().'admin/rekap/tampil_data';?>",
            type: "POST",
            data: {
                regid: regid,
                cari: cari2,
                tgl1: tgl1,
                tgl2: tgl2
            },
            success: function (data) {
                // console.log("Data from server:", data);
                // console.log(regid);
                // console.log(cari2);
                // console.log(tgl1);
                // console.log(tgl2);
                
                var parsedData = JSON.parse(data);
                if (parsedData.length !== 0) {
                    var cari = parsedData.cari;
                    if (cari==="omzet" || cari==="jualtunai" || cari==="piutang") {
                        var totjual=0;
                        var no=0;
                        $.each(parsedData.data, function (index, item) {
                                var jtot = parseFloat(item.jual_total);
                                totjual = totjual + jtot;
                                no++;
                                var newRow = '<tr>' +
                                    '<td style="font-size:11px;text-align:center;">' + no + '</td>' +
                                    '<td style="font-size:11px;">' + item.jual_tanggal + '</td>' +
                                    '<td style="font-size:11px;">' + item.jual_nofak + '</td>' +
                                    '<td style="font-size:11px;">' + item.jual_cust_nama + '</td>' +
                                    '<td style="font-size:11px;">' + item.jual_nota + '</td>' +
                                    '<td style="font-size:11px;">' + item.jual_bayar + '</td>' +
                                    '<td style="font-size:11px;">' + item.jual_bayar_status + '</td>' +
                                    '<td style="text-align:right;font-size:11px;">' + jtot.toLocaleString('id-ID') + '</td>' +
                                    '</tr>';
                                $('#tbl_tampil tbody').append(newRow);
                            
                        });
                                var totRow = '<tr style="background-color:#777;">' +
                                    '<td colspan="7" style="text-align:right;font-size:11px;color:white;"><b>Total :</b></td>' +
                                    '<td style="text-align:right;font-size:11px;color:white;"><b>' + totjual.toLocaleString('id-ID') + '</b></td>' +
                                    '</tr>';
                                $('#tbl_tampil tbody').append(totRow);
                
                    } else if (cari==="pelunasan") {
                        var totbayar=0;
                        var no=0;
                        $.each(parsedData.data, function (index, item) {
                                var jbayar = parseFloat(item.bayar_jumlah);
                                totbayar = totbayar + jbayar;
                                no++;
                                var newRow = '<tr>' +
                                    '<td style="font-size:11px;text-align:center;">' + no + '</td>' +
                                    '<td style="font-size:11px;">' + item.bayar_tgl_trans + '</td>' +
                                    '<td style="font-size:11px;">' + item.bayar_nofak + '</td>' +
                                    '<td style="font-size:11px;">' + item.jual_cust_nama + '</td>' +
                                    '<td style="font-size:11px;">' + item.jual_nota + '</td>' +
                                    '<td style="font-size:11px;">' + item.bayar_ket + '</td>' +
                                    '<td style="text-align:right;font-size:11px;">' + jbayar.toLocaleString('id-ID') + '</td>' +
                                    '</tr>';
                                $('#tbl_tampil tbody').append(newRow);
                            
                        });
                                var totRow = '<tr style="background-color:#777;">' +
                                    '<td colspan="6" style="text-align:right;font-size:11px;color:white;"><b>Total :</b></td>' +
                                    '<td style="text-align:right;font-size:11px;color:white;"><b>' + totbayar.toLocaleString('id-ID') + '</b></td>' +
                                    '</tr>';
                                $('#tbl_tampil tbody').append(totRow);
                    } else if (cari==="pengeluaran") {
                        var totbeban=0;
                        var no=0;
                        $.each(parsedData.data, function (index, item) {
                                var jbeban = parseFloat(item.beban_jumlah);
                                totbeban = totbeban + jbeban;
                                no++;
                                var newRow = '<tr>' +
                                    '<td style="font-size:11px;text-align:center;">' + no + '</td>' +
                                    '<td style="font-size:11px;">' + item.beban_tanggal + '</td>' +
                                    '<td style="font-size:11px;">' + item.beban_nama + '</td>' +
                                    '<td style="text-align:right;font-size:11px;">' + jbeban.toLocaleString('id-ID') + '</td>' +
                                    '</tr>';
                                $('#tbl_tampil tbody').append(newRow);
                            
                        });
                                var totRow = '<tr style="background-color:#777;">' +
                                    '<td colspan="3" style="text-align:right;font-size:11px;color:white;"><b>Total :</b></td>' +
                                    '<td style="text-align:right;font-size:11px;color:white;"><b>' + totbeban.toLocaleString('id-ID') + '</b></td>' +
                                    '</tr>';
                                $('#tbl_tampil tbody').append(totRow);
                    } else if (cari==="transfer") {
                        //var tottransfer=0;
                        //var no=0;
                        // $.each(parsedData.data, function (index, item) {
                        //         var jtransfer = parseFloat(item.bank_jumlah);
                        //         tottransfer = tottransfer + jtransfer;
                        //         no++;
                        //         var newRow = '<tr>' +
                        //             '<td style="font-size:11px;text-align:center;">' + no + '</td>' +
                        //             '<td style="font-size:11px;">' + item.bank_tanggal + '</td>' +
                        //             '<td style="font-size:11px;">' + item.bank_ket + '</td>' +
                        //             '<td style="text-align:right;font-size:11px;">' + jtransfer.toLocaleString('id-ID') + '</td>' +
                        //             '</tr>';
                        //         $('#tbl_tampil tbody').append(newRow);
                            
                        // });
                        //         var totRow = '<tr style="background-color:#777;">' +
                        //             '<td colspan="3" style="text-align:right;font-size:11px;color:white;"><b>Total :</b></td>' +
                        //             '<td style="text-align:right;font-size:11px;color:white;"><b>' + tottransfer.toLocaleString('id-ID') + '</b></td>' +
                        //             '</tr>';
                        //         $('#tbl_tampil tbody').append(totRow);
                        var totbeban=0;
                        var no=0;
                        $.each(parsedData.data, function (index, item) {
                                var jbeban = parseFloat(item.beban_jumlah);
                                totbeban = totbeban + jbeban;
                                no++;
                                var newRow = '<tr>' +
                                    '<td style="font-size:11px;text-align:center;">' + no + '</td>' +
                                    '<td style="font-size:11px;">' + item.beban_tanggal + '</td>' +
                                    '<td style="font-size:11px;">' + item.beban_nama + '</td>' +
                                    '<td style="text-align:right;font-size:11px;">' + jbeban.toLocaleString('id-ID') + '</td>' +
                                    '</tr>';
                                $('#tbl_tampil tbody').append(newRow);
                            
                        });
                                var totRow = '<tr style="background-color:#777;">' +
                                    '<td colspan="3" style="text-align:right;font-size:11px;color:white;"><b>Total :</b></td>' +
                                    '<td style="text-align:right;font-size:11px;color:white;"><b>' + totbeban.toLocaleString('id-ID') + '</b></td>' +
                                    '</tr>';
                                $('#tbl_tampil tbody').append(totRow);
                    }

                } else {
                        console.log("No data found.");
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX error:", error);
            }
        });
    });
});

</script>

<script>
    function varCetak_Excel() {
        var form = document.querySelector('#myForm'); 
        form.action = "<?php echo base_url().'admin/rekap/cetak_rekap_excel';?>";
        //form.target = '_blank';
        form.submit(); // Mengirimkan formulir
    }
</script>


</body>
</html>
