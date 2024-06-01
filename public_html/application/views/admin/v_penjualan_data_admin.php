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

    <title>Data Penjualan</title>
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
        <div class="row">
            <div class="col-lg-12">
                <h3 style="margin: 0;">Data Penjualan </small></h3>
            </div>
        </div>
        <hr/>
        <div class="row" id="cetak_penjualan">
            <div class="col-lg-12">
                <form class="form-horizontal" method="post" action="" target="_blank">
                <table style="font-size:12px;margin-bottom:10px;">
                    <input type="hidden" name="namacab" id="namacab" value="<?php echo $namacab; ?>">
                    <tr>
                        <th style="width:10%;vertical-align:middle;">Tgl Transaksi :</th>
                        <td style="width:15%;vertical-align:middle;">
                            <div style="margin-top:-3px;"  class="input-group date" id="datepicker1">
                                <input type="text" id="tgl1" name="tgl1" class="form-control input-sm" style="font-size:11px;color:green;" placeholder="Tanggal..." value="<?= $firstDayOfMonth; ?>" required>
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </td>
                        <td style="width:5%;vertical-align:middle;text-align:center"> S/d</td>
                        <td style="width:15%;vertical-align:middle;">
                            <div style="margin-top:-3px;"  class="input-group date" id="datepicker2">
                                <input type="text" id="tgl2" name="tgl2" class="form-control input-sm" style="font-size:11px;color:green;" placeholder="Tanggal..." value="<?= $lastDayOfMonth; ?>" required>
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </td>
                        
                        <td style="width:20%;vertical-align:middle;padding-left:20px;">
                        <select name="regid" id="regid" style="margin-left:10px;" class="selectpicker show-tick form-control" data-live-search="true" title="Pilih cabang" placeholder="Pilih Cabang" data-width="200px" required>
                            <option value="" disabled selected style="display: none;">Pilih Cabang</option>
                            <optgroup label="Pilih Cabang">
                                <?php 
                                foreach ($regions ->result_array() as $rg) {
                                    $reg_id = $rg['reg_id'];
                                    $reg_name = $rg['reg_name'];  
                                    if ($namacab == $reg_name)  {
                                        echo '<option value="'.$reg_id.'" selected>'.$reg_name.'</option>';
                                    }else {
                                        echo '<option value="'.$reg_id.'">'.$reg_name.'</option>';
                                    }
                                }
                                    if ($namacab == "Gabungan (Global)")  {
                                        echo '<option value="0" selected>Gabungan (Global)</option>';
                                    }else {
                                        echo '<option value="0">Gabungan (Global)</option>';
                                    } 
                                ?>
                                
                            </optgroup>
                        </select>
                        </td>               

                        <td style="width:10%;vertical-align:middle;padding-left:10px">
                            <a style="margin-top:-3px;" class="btn btn-sm btn-info btn-tampil" data-toggle="modal" title="Tampilkan Data"><span class="fa fa-search"></span></a>
                        </td>
                        <td style="width:20%;vertical-align:middle;">
                        </td>
                        <td style="width:5%;vertical-align:middle;">
                            <button style="margin-top:-3px;"  class="btn btn-sm btn-info" title="Cetak Data" onclick="varCetak_Penjualan()"><span class="fa fa-print"></span> Cetak Data</button>
                        </td>
                    </tr>
                </table>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">        
                <table id="tbl_tampil" class="table table-striped table-bordered" style="font-size:11px;">
                    <thead>
                        <tr>
                            <th style="text-align:center">No</th>
                            <th style="text-align:center">Kantor</th>    
                            <th style="text-align:center">Tanggal Transaksi</th>    
                            <th style="text-align:center">Nama Customer</th>
                            <th style="text-align:center">No Faktur</th>
                            <th style="text-align:center">No Nota</th>
                            <th style="text-align:center">Jenis Pembayaran</th>
                            <th style="text-align:center">Status Pembayaran</th>
                            <th style="text-align:center">Total Penjualan</th>
                            <th style="text-align:center">Aksi</th>
                            </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no=0;
                        $total=0;
                        foreach ($data as $a):
                            $no++;
                            $cab = $a['reg_name'];
                            $tgl = $a['jual_tanggal'];
                            $cust = $a['jual_cust_nama'];
                            $nofak = $a['jual_nofak'];
                            $nota = $a['jual_nota'];
                            $jbyr = $a['jual_bayar'];
                            $jstatus = $a['jual_bayar_status'];
                            $tot = $a['jual_total'];
                            $tgltempo = $a['jual_tgl_tempo'];
                            $blntempo = $a['jual_bulan_tempo'];
                            $total=$total+$tot;
                        ?>
                        <tr>
                            <td style="text-align:center;"><?php echo $no;?></td>
                            <td><?php echo $cab;?></td>
                            <td><?php echo $tgl;?></td>
                            <td><?php echo $cust;?></td>
                            <td><?php echo $nofak;?></td>
                            <td><?php echo $nota;?></td>
                            <td style="text-align:center;"><?php echo $jbyr;?></td>
                            <td style="text-align:center;"><?php echo $jstatus;?></td>
                            <td style="text-align:right;"><?php echo 'Rp ' . str_replace(',', '.', number_format($tot)); ?></td>
                            <td style="text-align:center;">
                                <a class="btn btn-xs btn-info btn-lihatjual" href="#modalLihatJual" data-toggle="modal" data-nofak="<?= $nofak ;?>" data-nmcust="<?= $cust ;?>" data-tmpbln="<?= $blntempo ;?>" data-tmptgl="<?=  $tgltempo ;?>" data-jenisbyr="<?=  $jbyr ;?>" title="Lihat Data Penjualan"><span class="fa fa-eye"></span> Lihat</a>
                                <a class="btn btn-xs btn-info" href="<?php echo base_url() . 'admin/penjualan_data/cetak_faktur/' . $nofak; ?>" target="_blank" title="Cetak Faktur Penjualan untuk Customer/Pelanggan"><span class="fa fa-print"></span> Faktur</a>
                                <a class="btn btn-xs btn-success" href="<?php echo base_url() . 'admin/penjualan_data/cetak_faktur2/' . $nofak; ?>" target="_blank" title="Cetak Faktur Penjualan untuk Internal"><span class="fa fa-print"></span> Faktur</a>
                            </td>
                        </tr>
                    <?php endforeach;?>
                    <tr style="background-color:#777;">
                        <td colspan="8" style="text-align:right;font-size:11px;color:white;"><b>Total :</b></td>
                        <td style="text-align:right;font-size:11px;color:white;"><b><?php echo 'Rp ' . str_replace(',', '.', number_format($total)); ?></b></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>    
    </div>
               
    <!-- ============ MODAL Lihat Penjualan =============== -->
        <div id="modalLihatJual" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 class="modal-title" id="myModalLabel">Informasi Penjualan </h3>
        </div>
        <div class="modal-body" style="overflow:scroll;height:450px;">
            <!-- Navigasi Tab -->
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#tabJual" style="font-size:11px;"><b>Data Penjualan</b></a></li>
                <li><a data-toggle="tab" href="#tabHistory" style="font-size:11px;"><b>History Pembayaran</b></a></li>
                <!-- Tambahkan lebih banyak tab sesuai kebutuhan -->
            </ul>                    
                <!-- Isi Tab -->
                <div class="tab-content">
                    <!-- Tab 1: Informasi -->
                    <div id="tabJual" class="tab-pane fade in active">
                        <br>
                        <table style="font-size: 11px; width: 100%;">
                            <tr>
                                <td style="width:100px;">Kantor Cabang</td>
                                <td style="width:5px;">:</td>
                                <td style="width:200px;color:green;padding-left:10px;"><b><span id="cabValue2"></span></b></td>
                            </tr>
                            <tr>
                                <td style="width:100px;">Nama Customer</td>
                                <td style="width:5px;">:</td>
                                <td style="width:200px;color:green;padding-left:10px;"><b><span id="nmcustValue2"></span></b></td>
                                <td style="text-align:right;padding-right:5px;">Jenis Pembayaran</td>
                                <td style="width:10px;text-align:center;">:</td>
                                <td style="width:80px;color: green; text-align: right;"><b><span id="jenValue2"></span></b></td>
                            </tr>
                            <tr>
                                <td style="width:100px;">No Faktur</td>
                                <td style="width:5px;">:</td>
                                <td style="width:200px;color:green;padding-left:10px;"><b><span id="nofakValue2"></span></b></td>
                                <td style="text-align:right; padding-right:5px;">Status Bayar</td>
                                <td style="width:10px;text-align:center;">:</td>
                                <td style="width:80px;color:green;text-align:right;"><b><span id="ketValue2"></span></b></td>
                            </tr>
                        </table>




                        <table id="detailTable" class="table table-bordered table-condensed" style="font-size:11px;margin-top:10px;">
                        <thead>
                            <tr>
                                <th style="text-align:center;">Kode Barang</th>
                                <th style="text-align:center;">Nama Barang</th>
                                <th style="text-align:center;">Satuan</th>
                                <th style="text-align:center;">Quantity</th>
                                <th style="text-align:center;">Harga Jual</th>
                                <th style="text-align:center;">Diskon</th>
                                <th style="text-align:center;">Sub Total</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        </table>
                    </div>

                    <div id="tabHistory" class="tab-pane fade">
                    <br>
                        <table id="tbl_info" class="table table-bordered table-condensed" style="font-size:11px;">
                        <thead>
                        <tr>
                            <th style="text-align:center;vertical-align:middle">Tgl Transaksi</th>
                            <th style="text-align:center;vertical-align:middle">Kewajiban Pembayaran</th>
                            <th style="text-align:center;vertical-align:middle">Jumlah yang sudah diBayar</th>
                            <th style="text-align:center;vertical-align:middle">Kurang Bayar</th>
                        </tr>
                        </thead>
                        <tbody></tbody>
                        </table>
                        <table style="font-size:11px;">
                        <td><strong>Periode Tempo : <span id="tempobln" style="color: green;"></span> Bulan , Tanggal Jatuh Tempo : <span id="tempotgl" style="color: green;"></span></td></strong>
                        </table>
                        <hr/>
                        <p style="font-size: 11px; margin-bottom: 0;">
                            <b>History Pembayaran : </b>
                            <span style="float: right;"><b>Total yang dibayar : <span id="totValue" style="color: green;"></b></span>
                        </p>
                        <table id="tbl_bayar" class="table table-bordered table-condensed" style="font-size:11px;">
                        <thead>
                        <tr>
                            <th style="text-align:center;vertical-align:middle">No</th>
                            <th style="text-align:center;vertical-align:middle">Tanggal Bayar</th>
                            <th style="text-align:center;vertical-align:middle">Jumlah yang diBayar</th>
                        </tr>
                        </thead>
                        <tbody></tbody>
                        </table> 
                    </div>
                </div>


            
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
$(document).ready(function () {
    $('select[name="regid"]').on('change', function() {
        const namcab = $('#regid option:selected').text();
        $('#namacab').val(namcab);
    });
});

function varCetak_Penjualan() {
    var form = document.querySelector('#cetak_penjualan form');
    form.action = "<?php echo base_url().'admin/penjualan_data/lap_data_penjualan'?>";    
}
</script>


<script type="text/javascript">
$(document).ready(function () {
    $(document).on('click', '.btn-tampil', function () {
        $('#tbl_tampil tbody').empty();
        var regid = $('#regid').val();
        var tgl1 = $('#tgl1').val();
        var tgl2 = $('#tgl2').val();

        $.ajax({
            url: "<?php echo base_url().'admin/penjualan_data/get_penjualan_data';?>",
            type: "POST",
            data: {
                regid: regid,
                tgl1: tgl1,
                tgl2: tgl2
            },
            success: function (data) {
                // console.log("Data from server:", data);
                // console.log(regid);
                // console.log(tgl1);
                // console.log(tgl2);
                var parsedData = JSON.parse(data);
                if (parsedData.length !== 0) {
                        var totjual=0;
                        var no=0;
                        $.each(parsedData.data, function (index, item) {
                                var jtot = parseFloat(item.jual_total);
                                totjual = totjual + jtot;
                                no++;
                                var newRow = '<tr>' +
                                    '<td style="font-size:11px;text-align:center;">' + no + '</td>' +
                                    '<td style="font-size:11px;">' + item.reg_name + '</td>' +
                                    '<td style="font-size:11px;">' + item.jual_tanggal + '</td>' +
                                    '<td style="font-size:11px;">' + item.jual_cust_nama + '</td>' +
                                    '<td style="font-size:11px;">' + item.jual_nofak + '</td>' +
                                    '<td style="font-size:11px;">' + item.jual_nota + '</td>' +
                                    '<td style="font-size:11px;text-align:center;">' + item.jual_bayar + '</td>' +
                                    '<td style="font-size:11px;text-align:center;">' + item.jual_bayar_status + '</td>' +
                                    '<td style="text-align:right;font-size:11px;">' + jtot.toLocaleString('id-ID') + '</td>' +
                                    '<td style="font-size:11px;text-align:center;">' +
                                    '<a class="btn btn-xs btn-info btn-lihatjual" href="#modalLihatJual" data-toggle="modal" data-nofak="' + item.jual_nofak + '" data-cab="' + item.reg_name + '" data-nmcust="' + item.jual_cust_nama + '" data-tmpbln="' + item.jual_bulan_tempo + '" data-tmptgl="' + item.jual_tgl_tempo + '" data-jenisbyr="' + item.jual_bayar + '" title="Lihat Data Penjualan"><span class="fa fa-eye"></span> Lihat</a> ' +
                                    '<a class="btn btn-xs btn-info" href="<?php echo base_url() . 'admin/penjualan_data/cetak_faktur/' ?>' + item.jual_nofak + '" target="_blank" title="Cetak Faktur Penjualan untuk Customer/Pelanggan"><span class="fa fa-print"></span> Faktur</a> ' +
                                    '<a class="btn btn-xs btn-success" href="<?php echo base_url() . 'admin/penjualan_data/cetak_faktur2/' ?>' + item.jual_nofak + '" target="_blank" title="Cetak Faktur Penjualan untuk Internal"><span class="fa fa-print"></span> Faktur</a>' +
                                    '</td>' +
                                    '</tr>';
                                $('#tbl_tampil tbody').append(newRow);

                            
                        });
                        var totRow = '<tr style="background-color:#777;">' +
                            '<td colspan="8" style="text-align:right;font-size:11px;color:white;"><b>Total :</b></td>' +
                            '<td style="text-align:right;font-size:11px;color:white;"><b>' + totjual.toLocaleString('id-ID') + '</b></td>' +
                            '</tr>';
                        $('#tbl_tampil tbody').append(totRow);
                
                    
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


<script type="text/javascript">
$(document).ready(function() {
    var tblBayar; // Variabel untuk tabel DataTable
    var tblInfo;
    var isDataTableInitialized = false; // Variabel untuk melacak apakah DataTable sudah diinisialisasi
    // Inisialisasi DataTable tanpa data awal
    tblBayar = $('#tbl_bayar').DataTable({
        ordering: false,
        dom: "", // Hapus semua elemen wrapper
        autoWidth: false,
        scrollY: 'none',
        columns: [
            { data: null,
                className: 'text-center',
                render: function(data, type, row, meta) {
                    return meta.row + 1; // Menambahkan nomor urut
                }
            },
            { data: 'tgl_trans' },
            { data: 'bayar_jumlah',
                className: 'text-right',
                render: function(data) {
                    var totalFormatted = Math.ceil(data).toLocaleString('id-ID', { style: 'currency', currency: 'IDR' }).replace(/,00$/, '');
                    return totalFormatted;
                }
            }
        ]
    });

    // Inisialisasi DataTable tanpa data awal
    tblInfo = $('#tbl_info').DataTable({
        ordering: false,
        dom: "", // Hapus semua elemen wrapper
        autoWidth: false,
        scrollY: 'none',
        columns: [
            { data: 'bayar_tgl' },
            { data: 'bayar_total',
                className: 'text-right',
                render: function(data) {
                    var totalFormatted = Math.ceil(data).toLocaleString('id-ID', { style: 'currency', currency: 'IDR' }).replace(/,00$/, '');
                    return totalFormatted;
                }
            },
            { data: 'tot_bayar',
                className: 'text-right',
                render: function(data) {
                    var totalFormatted = Math.ceil(data).toLocaleString('id-ID', { style: 'currency', currency: 'IDR' }).replace(/,00$/, '');
                    return totalFormatted;
                }
            },
            { data: 'kur_bayar',
                className: 'text-right',
                render: function(data) {
                    var totalFormatted = Math.ceil(data).toLocaleString('id-ID', { style: 'currency', currency: 'IDR' }).replace(/,00$/, '');
                    return totalFormatted;
                }
            }
        ]
    });


    $(document).on('click', '.btn-lihatjual', function() {
        var nofak = $(this).data('nofak');
        var cab = $(this).data('cab');
        var nmcust = $(this).data('nmcust');
        var tmpbln = $(this).data('tmpbln');
        var tmptgl = $(this).data('tmptgl');
        var jenbyr = $(this).data('jenisbyr');
        //menyembunyikan Tab History
        if (jenbyr === "Tempo") {
            $('a[href="#tabHistory"]').parent('li').show();
        } else {
            $('a[href="#tabHistory"]').parent('li').hide();
        }

        $('#detailTable tbody').empty();    //Clear existing table rows
        $('#tempobln').text(tmpbln);
        $('#tempotgl').text(tmptgl);
        $('#cabValue2').text(cab);
        $('#nofakValue2').text(nofak);
        $('#nmcustValue2').text(nmcust);

        $.ajax({
            type: "POST",
            url: "<?php echo base_url('admin/penjualan_data/get_detail_jual'); ?>",
            data: { nofak: nofak },
            dataType: 'json',
            success: function (data) {
                if (data.length === 0) {
                        //console.log("No data found.");
                } else {
                    //-------Tab Penjualan--------------------
                    var itemA = data.queryC[0];
                    $('#jenValue2').text(itemA.jual_bayar);
                    $('#ketValue2').text(itemA.jual_bayar_status);
                    var grandTotal = 0;
                    //Loop through the data and append rows to the table
                    $.each(data.queryC, function (index, item) {
                        var harjul = parseFloat(item.d_jual_barang_harjul);
                        var diskon = parseFloat(item.d_jual_diskon);
                        var total = parseFloat(item.d_jual_total);
                        var qty = parseFloat(item.d_jual_qty);
                        var formatted_qty;
                        if (Math.floor(qty) === qty) {
                            formatted_qty = qty.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ','); // Format sebagai bilangan bulat
                        } else {
                            formatted_qty = qty.toFixed(2).replace('.', ',').replace(/\.?0+$/, '').replace(/\B(?=(\d{3})+(?!\d))/g, ','); // Format sebagai bilangan desimal
                        }
                        
                        var newRow = '<tr>' +
                            '<td style="text-align:center;">' + item.d_jual_barang_id + '</td>' +
                            '<td style="text-align:center;">' + item.d_jual_barang_nama + '</td>' +
                            '<td style="text-align:center;">' + item.d_jual_barang_satuan + '</td>' +
                            '<td style="text-align:center;">' + formatted_qty + '</td>' +
                            '<td style="text-align:right;">' + harjul.toLocaleString('id-ID') + '</td>' +
                            '<td style="text-align:right;">' + diskon.toLocaleString('id-ID') + '</td>' +
                            '<td style="text-align:right;">' + total.toLocaleString('id-ID') + '</td>' +
                            '</tr>';
                        grandTotal += total;
                        $('#detailTable tbody').append(newRow);    
                    });
                    // Tambahkan baris "Total" setelah loop dan tampilkan grand total
                    var totalRow = '<tr>' +
                        '<td colspan="6" style="text-align:right; font-weight:bold;">Total</td>' + // Kolom kosong sebelum kolom "Total"
                        '<td style="text-align:right; font-weight:bold;">' + grandTotal.toLocaleString('id-ID') + '</td>' +
                        '</tr>';
                    $('#detailTable tbody').append(totalRow);

                     //------Tab History--------------------
                        tblBayar.clear().draw();
                        tblInfo.clear().draw();
                        if (data.queryA && data.queryB && data.queryB.length > 0) {
                            for (var i = 0; i < data.queryB.length; i++) {
                                tblBayar.row.add(data.queryB[i]).draw();
                            }
                            tblInfo.row.add(data.queryA).draw();
                            var ketBayar = data.queryA.bayar_ket;
                            var totBayar = parseFloat(data.queryA.tot_bayar);
                            totBayar = Math.ceil(totBayar);
                            $('#ketValue').text(ketBayar);
                            $('#totValue').text(Number(totBayar).toLocaleString('id-ID', { style: 'currency', currency: 'IDR' }).replace(/,00$/, ''));
                        } else {
                            //console.log('queryA atau queryB kosong');
                        }
                        
                } 
            },
            error: function(xhr, status, error) {
                //console.log(error);
            }    
        });
    });



});
</script>

</body>
</html>
