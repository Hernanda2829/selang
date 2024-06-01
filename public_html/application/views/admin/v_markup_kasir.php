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

    <title>Buat Mark Up</title>
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
    


<style>
    
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

    #modalImage, #modalImage2 {
        max-width: 100%; /* Lebar gambar tidak akan melebihi lebar parent container */
        max-height: 200px; /* Tinggi gambar tidak akan melebihi 200px */
        width: auto; /* Mempertahankan aspek ratio gambar */
        height: auto; /* Mempertahankan aspek ratio gambar */
        margin-top: 10px; /* Menambahkan margin di atas gambar */
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
                
                <h3 class="page-header">Buat
                    <small>Mark up</small>
                    <!--<a href="#" data-toggle="modal" data-target="#largeModal" class="pull-right" onclick="refreshPageAndShowModal()"><small>Cari Penjualan!</small></a>-->
                    <a href="#" data-toggle="modal" data-target="#largeModal" class="pull-right"><small>Cari Penjualan!</small></a>
                </h3>
            </div>
        </div>
        <br>

        
        <!-- Projects Row -->
        <div class="row">
            <div class="col-lg-12">
                <table style="width:560px">    
                    <tr>
                        <th style="width:200px;">No Faktur</th>
                        <th rowspan="2">
                        <table id="jualTable" style="margin-left:30px;font-size:10px;width:750px;">
                            <tbody>
                            </tbody>
                        </table>
                        </th>
                    </tr>
                    <tr>
                        <th><input type="text" name="nofak" id="nofak" class="form-control input-sm" style="width:150px;"></th> 
                    </tr>    
                </table>
                
                <table id="detailTable" class="table table-bordered table-condensed" style="font-size:11px;margin-top:10px;">
                    <thead>
                        <tr>
                            <th style="text-align:center;">Group Set</th>
                            <th style="text-align:center;">Deskripsi</th>
                            <th style="text-align:center;">Jml Set</th>    
                            <th style="text-align:center;">No Faktur</th>
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
                        <tr>
                            <td style="text-align:center;"></td>
                            <td style="max-width:70px;overflow:hidden;"></td>
                            <td style="text-align:center;"></td>
                            <td style="text-align:center;"></td>
                            <td style="text-align:center;"></td>
                            <td style="text-align:center;"></td>
                            <td style="text-align:center;"></td>
                            <td style="text-align:center;"></td>
                            <td style="text-align:center;"></td>
                            <td style="text-align:center;"></td>
                            <td style="text-align:center;"></td>
                           
                        </tr>
                    </tbody>
                </table>
            
            <br>

            <div class="row">
                <div class="col-lg-12">
                    <a style="display:none;" id="buat_markup" name="buat_markup" class="btn btn-sm btn-success btn-buatmarkup" title="Buat Data Markup"><span class="fa fa-external-link"></span> Buat Data Markup</a>
                </div>
            </div>
            <form id="myForm" class="form-horizontal" method="post" action="">
            <table id="judul_markup" style="margin-top:10px;display:none;">
            <thead>    
                <tr>
                    <th style="width:180px;">Data Markup</th>
                    <th rowspan="2">
                        <table id="markupTable" style="font-size:10px;width:750px;">
                            <tbody>
                            </tbody>
                        </table>
                    </th>

                    <td style="width:5%;vertical-align:middle;padding-right:5px;">
                        <button class="btn btn-sm btn-info" title="Cetak Data Markup untuk Customer/Pelanggan" onclick="varCetak_Markup()"><span class="fa fa-print"></span> Cetak Faktur</button>
                    </td>
                    <td style="width:5%;vertical-align:middle;">
                        <button class="btn btn-sm btn-success" title="Cetak Data Markup untuk Internal" onclick="varCetak_Markup2()"><span class="fa fa-print"></span> Cetak Faktur</button>
                    </td>
                </tr> 
            </thead>
            </table>
            </form>

            <table id="tbl_markup" class="table table-bordered table-condensed" style="font-size:11px;margin-top:10px;display:none;">
                    <thead>
                        <tr>
                            <th style="text-align:center;">Group Set</th>
                            <th style="text-align:center;">Deskripsi</th>
                            <th style="text-align:center;">Jml Set</th>
                            <th style="text-align:center;">No Faktur</th>
                            <th style="text-align:center;">Kode Barang</th>
                            <th style="text-align:center;">Nama Barang</th>
                            <th style="text-align:center;">Satuan</th>
                            <th style="text-align:center;">Quantity</th>
                            <th style="text-align:center;">Harga Jual</th>
                            <th style="text-align:center;">Diskon</th>
                            <th style="text-align:center;">Sub Total</th>
                            <th style="text-align:center;">Aksi</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="text-align:center;"></td>
                            <td style="max-width:70px;overflow:hidden;"></td>
                            <td style="text-align:center;"></td>
                            <td style="text-align:center;"></td>
                            <td style="text-align:center;"></td>
                            <td style="text-align:center;"></td>
                            <td style="text-align:center;"></td>
                            <td style="text-align:center;"></td>
                            <td style="text-align:center;"></td>
                            <td style="text-align:center;"></td>
                            <td style="text-align:center;"></td>
                           
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
             
    
        <!-- ============ MODAL FIND =============== -->
        <div class="modal fade" id="largeModal" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
            <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 class="modal-title" id="myModalLabel">Data Penjualan Markup</small></h3>
            </div>
                <div class="modal-body" style="overflow:scroll;height:450px;">
                    <table class="table table-bordered table-condensed" style="font-size:11px;" id="mydata">
                    <thead>
                        <tr>
                        <th style="text-align:center">No</th>
                        <th style="text-align:center">Cabang</th>
                        <th style="text-align:center">No Faktur</th>
                        <th style="text-align:center">Nama Customer</th>
                        <th style="text-align:center">Tanggal Transaksi</th>
                        <th style="text-align:center">Jenis Bayar</th>
                        <th style="text-align:center">Status Bayar</th>
                        <th style="text-align:center">Total Penjualan</th>
                        <th style="text-align:center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                        $no=0;
                        foreach ($data->result_array() as $a):
                            $no++;
                            $nofak=$a['jual_nofak'];
                            $nmcust=$a['jual_cust_nama'];
                            $tgl=$a['jual_tanggal'];
                            $jb=$a['jual_bayar'];
                            $js=$a['jual_bayar_status'];
                            $tot=$a['jual_total'];
                            $regname=$a['reg_name'];

                    ?>
                        <tr>
                            <td style="text-align:center;"><?php echo $no;?></td>
                            <td><?php echo $regname;?></td>
                            <td><?php echo $nofak;?></td>
                            <td><?php echo $nmcust;?></td>
                            <td><?php echo $tgl;?></td>
                            <td style="text-align:center;"><?php echo $jb;?></td>
                            <td style="text-align:center;"><?php echo $js;?></td>
                            <td style="text-align:right;"><?php echo 'Rp ' . str_replace(',', '.', number_format($tot)); ?></td>
                            <td style="text-align:center;">
                            <button type="submit" class="btn btn-xs btn-info" title="Pilih" onclick="pilihKode('<?php echo $nofak?>')"><span class="fa fa-edit"></span> Pilih</button>
                            </td>
                        </tr>
                    <?php endforeach;?>
                    </tbody>
                    </table>          
                </div>
                <div class="modal-footer">
                    <button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
                    
                </div>
            </div>
            </div>
        </div>
        
        <!-- ============ MODAL Edit Data =============== -->
        <div id="modalEdit" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 class="modal-title" id="myModalLabel"><small>Edit Data Markup</small></h3>
        </div>
            
            <div class="modal-body" style="overflow:scroll;height:450px;">  
                <table id="tbl_head" style="font-size:11px;">
                <tr>
                    <th style="font-weight:normal;width:15%;">Tgl Transaksi</th>
                    <th style="font-weight:normal;text-align:center;width:3%;">: </th>
                    <th style="font-weight:normal;width:30%;"><b><span id="tglValue"></span></b></th>
                </tr>
                <tr>
                    <th style="font-weight:normal;width:15%;">Nama Customer</th>
                    <th style="font-weight:normal;text-align:center;width:3%;">: </th>
                    <th style="font-weight:normal;width:30%;"><b><span id="nmcustValue" style="color: green;"></span></b></th>
                    <th style="font-weight:normal;text-align:right;width:30%;">Jenis Bayar</th>
                    <th style="font-weight:normal;text-align:center;width:3%;"> : </th>
                    <th style="font-weight:normal;text-align:right;width:15%;"><span id="jenisByr" style="color: green;"></span></th>
                </tr>
                <tr>
                    <th style="font-weight:normal;width:15%;">No Faktur</th>
                    <th style="font-weight:normal;text-align:center;width:3%;">: </th>
                    <th style="font-weight:normal;width:30%;"><b><span id="nofakValue"></span></b></th>
                    <th style="font-weight:normal;text-align:right;width:30%;">Status Bayar</th>
                    <th style="font-weight:normal;text-align:center;width:3%;"> : </th> 
                    <th style="font-weight:normal;text-align:right;width:15%;"><span id="statusByr" style="color: green;"></span></th>
                </table>
                <table id="tbl_info" class="table table-bordered table-condensed" style="font-size:11px;">
                <thead>
                <tr>
                    <th style="text-align:center;vertical-align:middle">Kode Barang</th>
                    <th style="text-align:center;vertical-align:middle">Nama Barang</th>
                    <th style="text-align:center;vertical-align:middle">Satuan</th>
                    <th style="text-align:center;vertical-align:middle">Quantity</th>
                    <th style="text-align:center;vertical-align:middle">Harga Jual</th>
                    <th style="text-align:center;vertical-align:middle">Diskon</th>
                    <th style="text-align:center;vertical-align:middle">Sub Total</th>
                </tr>
                </thead>
                <tbody></tbody>
                </table>
                
                <p style="font-size:11px;margin-bottom:0;"><span id="inputByrValue2"><b>Data Markup, </b></span></p>
                
                <table class="table table-bordered table-condensed" style="font-size: 11px;">
                    <input type="hidden" id="txtnofak" name="txtnofak" class="form-control input-sm" style="width:150px;text-align:right;" min="0">
                    <input type="hidden" id="txtidbrg" name="txtidbrg" class="form-control input-sm" style="width:150px;text-align:right;" min="0">
                    <input type="hidden" id="txttot" name="txttot" class="form-control input-sm" style="width:150px;text-align:right;" min="0">   
                    <tr>
                        <th style="width: 150px; padding-bottom: 5px; vertical-align: middle;">Quantity</th>
                        <td>
                         <input type="text" id="txtqty" name="txtqty" class="form-control input-sm" style="width:150px;text-align:right;" min="0" required>   
                        </td>
                    </tr>
                    <tr>
                        <th style="width: 150px; padding-bottom: 5px; vertical-align: middle;">Harga Jual (Rp) </th>
                        <td>
                         <input type="text" id="txtharjul" name="txtharjul" class="form-control input-sm" style="width:150px;text-align:right;" min="0" required>   
                        </td>
                    </tr>
                    <tr>
                        <th style="width:150px;padding-bottom:5px;vertical-align:middle;">Diskon (Rp) </th>
                        <td>
                        <input type="text" id="txtdiskon" name="txtdiskon" class="form-control input-sm" style="width:150px;text-align:right;" min="0" required>
                        </td>
                    </tr>
                    <tr>
                        <th style="width:150px;padding-bottom:5px;vertical-align:middle;">Sub Total</th>
                        <td>
                        <input type="text" id="txttotal" name="txttotal" class="form-control input-sm" style="width:150px;text-align:right;" min="0" readonly>
                        </td>
                    </tr>
                </table>
                <p style="font-size:11px;margin-bottom:0;"><span id="groupid"><b>Group Set, </b></span></p>
                <table id="tbl_set" class="table table-bordered table-condensed" style="font-size: 11px;">
                    <tr>
                        <th style="width: 150px; padding-bottom: 5px; vertical-align: middle;">Deskripsi Set</th>
                        <td>
                            <input type="hidden" id="txtidset" name="txtidset">    
                            <input type="text" id="txtdeskset" name="txtdeskset" class="form-control input-sm" style="width:380px;" required>   
                        </td>
                    </tr>
                    <tr>
                        <th style="width: 150px; padding-bottom: 5px; vertical-align: middle;">Jumlah Set</th>
                        <td>
                            <input type="text" id="txtjmlset" name="txtjmlset" class="form-control input-sm" style="width:150px;" required>   
                        </td>
                    </tr>
                </table>

            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-info btn-update">Update</button>
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
    <script src="<?php echo base_url().'assets/js/moment.js'?>"></script>
    <script src="<?php echo base_url().'assets/js/bootstrap-datetimepicker.min.js'?>"></script>
    <script src="<?php echo base_url().'assets/js/jquery.dataTables.min.js'?>"></script>
    
    
<script type="text/javascript">
    $(function () {
        $('#datepicker').datetimepicker({
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
    $("#nofak").focus();

    $("#nofak").on("input", function () {
        //fungsi nonaktif status kasir
        // $('#buat_markup').hide();
        // $('#judul_markup').hide();
        // $('#tbl_markup').hide();
        // handleNofakChange();
    });

    var dataJual; // Variabel untuk menyimpan data penjualan

    function handleNofakChange() {
        // Clear existing table rows
        $('#detailTable tbody').empty();
        $('#jualTable tbody').empty();
        $('#tbl_markup tbody').empty();
        var nofak = $("#nofak").val();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url().'admin/markup_kasir/get_detail_jual';?>",
            data: { nofak: nofak },
            dataType: 'json',
            success: function (data) {
                if (data && data.queryA && data.queryB) {
                            // Simpan data penjualan ke variabel
                            dataTabelJual = data.queryA;
                            dataJual = data.queryB;
                            //----------------------------------
                            var item = data.queryB[0]; //mengambil nilai pertama saja ,karena jika tidak akan terjadi pengulangan
                            var newRowJualTable = '<tr>' +
                                '<td style="text-align:left;width:10%;">Cabang</td>' +
                                '<td style="text-align:left;width:2%;">:</td>' +
                                '<td style="text-align:left;width:30%;font-weight:normal;font-size:11px;">' + item.reg_name + '</td>' +
                                '</tr>' +
                                '<tr>' +
                                '<td style="text-align:left;width:15%;">Tgl.Transaksi</td>' +
                                '<td style="text-align:left;width:2%;">:</td>' +
                                '<td style="text-align:left;width:30%;font-weight:normal;font-size:11px;">' + item.jual_tanggal + '</td>' +
                                '<td style="text-align:left;width:15%;">Jenis Pembayaran</td>' +
                                '<td style="text-align:left;width:2%;">:</td>' +
                                '<td style="text-align:left;width:30%;font-weight:normal;font-size:11px;">' + item.jual_bayar + '</td>' +
                                '</tr>' +
                                '<tr>' +
                                '<td style="text-align:left;width:15%;">Nama Customer</td>' +
                                '<td style="text-align:left;width:2%;">:</td>' +
                                '<td style="text-align:left;width:30%;color:green;font-size:11px;">' + item.jual_cust_nama + '</td>' +
                                '<td style="text-align:left;width:15%;">Status Pembayaran</td>' +
                                '<td style="text-align:left;width:2%;">:</td>' +
                                '<td style="text-align:left;width:30%;font-weight:normal;font-size:11px;">' + item.jual_bayar_status + '</td>' +
                                '</tr>' +
                                '<tr>' +
                                '<td style="text-align:left;width:10%;">Total Penjualan</td>' +
                                '<td style="text-align:left;width:2%;">:</td>' +
                                '<td style="text-align:left;width:30%;font-weight:normal;font-size:11px;">' + Number(item.jual_total).toLocaleString('id-ID', { style: 'currency', currency: 'IDR' }).replace(/,00$/, '') + '</td>' +
                                '<td style="text-align:left;width:10%;">Jumlah Bayar</td>' +
                                '<td style="text-align:left;width:2%;">:</td>' +
                                '<td style="text-align:left;width:30%;font-weight:normal;font-size:11px;">' + Number(item.jual_jml_uang).toLocaleString('id-ID', { style: 'currency', currency: 'IDR' }).replace(/,00$/, '') + '</td>' +
                                '</tr>';

                            // Append the new row to jualTable
                            $('#jualTable tbody').append(newRowJualTable);

                        // Loop through the data and append rows to the table
                        $.each(data.queryB, function (index, item) {
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
                                '<td style="text-align:center;color:blue;">' + item.group_id + '</td>' +
                                '<td style="text-align:center;color:blue;max-width:70px;overflow:hidden;white-space:nowrap;" title="' + item.group_desc + '">' + item.group_desc + '</td>' +
                                '<td style="text-align:center;color:blue;">' + item.group_sat + '</td>' +
                                '<td style="text-align:center;">' + item.d_jual_nofak + '</td>' +
                                '<td style="text-align:center;">' + item.d_jual_barang_id + '</td>' +
                                '<td style="text-align:center;">' + item.d_jual_barang_nama + '</td>' +
                                '<td style="text-align:center;">' + item.d_jual_barang_satuan + '</td>' +
                                '<td style="text-align:center;">' + formatted_qty + '</td>' +
                                '<td style="text-align:right;">' + harjul.toLocaleString('id-ID') + '</td>' +
                                '<td style="text-align:right;">' + diskon.toLocaleString('id-ID') + '</td>' +
                                '<td style="text-align:right;">' + total.toLocaleString('id-ID') + '</td>' +
                                //'<td style="text-align:center;">' + gTombol  + '</td>' +
                                '</tr>';
                            $('#detailTable tbody').append(newRow);
                        }); 
                        
                        
                        // Periksa apakah ada data dengan g_nofak dan g_barang_id yang sama pada queryA
                            var cekdata = data.queryA.some(function (gItem) {
                                return gItem.jual_nofak === item.d_jual_nofak;
                            });

                            // Ganti tombol berdasarkan hasil periksaan
                           // var gTombol;
                            if (cekdata) {
                                $('#buat_markup').hide();
                                $('#judul_markup').show();
                                $('#tbl_markup').show();
                            } else {
                                $('#buat_markup').show();
                                $('#judul_markup').hide();
                                $('#tbl_markup').hide();
                            }
                        tampilMarkup();  //menampilkan isi tabel markup

               
                } else {
                    console.error("Invalid data format:", data);
                }
            },
            error: function (xhr, status, error) {
                console.error("AJAX error:", error);
            }
        });
    }

    $('#largeModal').on('hidden.bs.modal', function () {
        handleNofakChange();
        setTimeout(function() {
        $("#nofak").focus();
        }, 100);
    });

    $('#mydata').DataTable();

    
    
});

function pilihKode(id) {
    $('#nofak').val(id);
    $('#largeModal').modal('hide');
}


</script>

<script type="text/javascript">
$(document).ready(function () {
    $(document).on('click', '.btn-buatmarkup', function () {
        // Clear existing table rows
        $('#tbl_markup tbody').empty();
        var nofak = $("#nofak").val();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url().'admin/markup_kasir/create_jual';?>",
            data: { nofak: nofak },
            dataType: 'json',
            success: function (data) {
                // console.log("Received data:", data);
                if (data && data.error) {
                    alert('Terjadi kesalahan: ' + data.error);
                } else {
                    $('#judul_markup').show();
                    $('#tbl_markup').show();
                    tampilMarkup();
                    
                }
            },
            error: function (xhr, status, error) {
                console.error("AJAX error:", error);
            }
        });
    });
});
</script> 

<script type="text/javascript">
    var dataPenjualan; // Variabel untuk menyimpan data penjualan
    var dataMarkup; // Variabel untuk menyimpan data markup

    function tampilMarkup() {
        // Clear existing table rows
        $('#markupTable tbody').empty();
        $('#tbl_markup tbody').empty();

        var nofak = $("#nofak").val();

        $.ajax({
            type: "POST",
            url: "<?php echo base_url().'admin/markup_kasir/get_markup';?>",
            data: { nofak: nofak },
            dataType: 'json',
            success: function (data) {
                //console.log("Received data:", data);
                if (data && data.queryA && data.queryB) {
                    if (data.queryA.length > 0) {
                        // Simpan data penjualan dan markup ke variabel
                        dataPenjualan = data.queryA;
                        dataMarkup = data.queryB;

                        var item = data.queryA[0]; // Mengambil nilai pertama saja, karena jika tidak akan terjadi pengulangan
                        var newRowJualTable = '<tr>' +
                            '<td style="text-align:left;width:15%;">Total Penjualan ' +
                            '<input style="display:none;width:100px;text-align:right;" type="text" name="txttotjual" id="txttotjual" class="form-control input-sm" value="' + item.jual_total + '">' +
                            '</td>' +
                            '<td style="text-align:left;width:2%;">:</td>' +
                            '<td style="text-align:left;width:15%;font-weight:normal;font-size:11px;">' + Number(item.jual_total).toLocaleString('id-ID', { style: 'currency', currency: 'IDR' }).replace(/,00$/, '') + '</td>' +
                            '<td style="text-align:left;width:15%;">Jumlah Bayar</td>' +
                            '<td style="text-align:left;width:2%;">:</td>' +
                            '<td style="text-align:left;width:30%;font-weight:normal;font-size:11px;vertical-align:middle;display:flex;align-items:center;">' +
                            '<span id="totm">' + Number(item.jual_jml_uang).toLocaleString('id-ID', { style: 'currency', currency: 'IDR' }).replace(/,00$/, '') + '</span>' +
                            '<input style="display:none;width:100px;text-align:right;" type="text" name="txtjmlbyr" id="txtjmlbyr" class="form-control input-sm" value="' + Number(item.jual_jml_uang).toLocaleString('id-ID') + '">' +
                            '<a href="#" id="btnedit" title="Edit Jumlah Pembayaran" class="fa fa-pencil editbyr" data-nofak="' + item.jual_nofak + '" style="padding-left:20px;color: green;"></a>' +
                            '<a href="#" id="btnsave" title="Simpan Jumlah Pembayaran" class="fa fa-save savebyr" data-nofak="' + item.jual_nofak + '" style="display:none;padding-left:20px; color: green;"></a>' +
                            '<a href="#" id="btncancel" title="Batal" class="fa fa-reply cancelbyr" data-nofak="' + item.jual_nofak + '" style="display:none;padding-left:20px;color:green;"></a>' +
                            '</td>' +
                            '<td style="text-align:right;width:15%;">Kembalian</td>' +
                            '<td style="text-align:left;width:2%;">:</td>' +
                            '<td style="text-align:left;width:15%;font-weight:normal;font-size:11px;">' + Number(item.jual_kembalian).toLocaleString('id-ID', { style: 'currency', currency: 'IDR' }).replace(/,00$/, '') + '</td>' +
                            '</tr>';
                        $('#markupTable tbody').append(newRowJualTable);

                        // Loop through the data and append rows to the table
                        $.each(data.queryB, function (index, item) {
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
                                '<td style="text-align:center;color:blue;">' + item.group_id + '</td>' +
                                '<td style="text-align:center;color:blue;max-width:70px;overflow:hidden;white-space:nowrap;" title="' + item.group_desc + '">' + item.group_desc + '</td>' +
                                '<td style="text-align:center;color:blue;">' + item.group_sat + '</td>' +
                                '<td style="text-align:center;">' + item.d_jual_nofak + '</td>' +
                                '<td style="text-align:center;">' + item.d_jual_barang_id + '</td>' +
                                '<td style="text-align:center;">' + item.d_jual_barang_nama + '</td>' +
                                '<td style="text-align:center;">' + item.d_jual_barang_satuan + '</td>' +
                                '<td style="text-align:center;">' + formatted_qty + '</td>' +
                                '<td style="text-align:right;">' + harjul.toLocaleString('id-ID') + '</td>' +
                                '<td style="text-align:right;">' + diskon.toLocaleString('id-ID') + '</td>' +
                                '<td style="text-align:right;">' + total.toLocaleString('id-ID') + '</td>' +
                                '<td style="text-align:center;"> <a href="#modalEdit" data-toggle="modal" class="btn btn-warning btn-xs btn-markup" data-nofak="' + item.d_jual_nofak + '" data-idbrg="' + item.d_jual_barang_id + '" title="Edit Data"><span class="fa fa-pencil"></span> Edit Data</a> ' +
                                '</td>' +
                                '</tr>';
                            $('#tbl_markup tbody').append(newRow);
                        });
                    } else {
                        //console.log("Data not found.");
                        // Tambahkan langkah-langkah untuk menangani ketika data tidak ditemukan
                    }
                } else {
                    //console.error("Invalid data format:", data);
                }
            },
            error: function (xhr, status, error) {
                console.error("AJAX error:", error);
            }
        });
    }

</script>



<script type="text/javascript">   
    $(document).ready(function () {
        $(document).on('click', '.editbyr', function () {
            $('#txtjmlbyr').show();
            $('#btnsave').show();
            $('#btncancel').show();
            $('#totm').hide();
            $('#btnedit').hide();
        });

        $(document).on('click', '.cancelbyr', function () {
            $('#totm').show();
            $('#btnedit').show();
            $('#txtjmlbyr').hide();
            $('#btnsave').hide();
            $('#btncancel').hide();
        });

        $(document).on('click', '.savebyr', function () {
            $('#totm').show();
            $('#btnedit').show();
            $('#txtjmlbyr').hide();
            $('#btnsave').hide();
            var nofakM = $(this).data('nofak');
            var jmlbyrM = $('#txtjmlbyr').val();
            var totjualM = $('#txttotjual').val();
            $.ajax({
                type: "POST",
                url: "<?php echo base_url().'admin/markup_kasir/save_bayar';?>",
                data: {
                    nofak  : nofakM,
                    jmlbyr : jmlbyrM,
                    totjual : totjualM 
                },
                dataType: 'json',
                success: function (data) {
                    if (data.error) {
                        alert('Terjadi kesalahan: ' + data.error); // Memberikan umpan balik kepada pengguna
                    } else {
                        tampilMarkup();
                    }
                },
                error: function (xhr, status, error) {
                    console.error("AJAX error:", error);
                    alert('Terjadi kesalahan saat mengirim permintaan AJAX.'); // Memberikan umpan balik kepada pengguna
                }
            });
        });
    });
</script>

<script type="text/javascript">
    $(document).on('click', '.btn-update', function () {
        var nofakV = $('#txtnofak').val();
        var idbrgV = $('#txtidbrg').val();
        var harjulV = $('#txtharjul').val();
        var diskonV = $('#txtdiskon').val();
        var totalV = $('#txttotal').val();
        var qtyV = $('#txtqty').val();
        var idset = $('#txtidset').val();
        var deskset = $('#txtdeskset').val();
        var jmlset = $('#txtjmlset').val();
        
        if (!harjulV.trim()) { 
            alert('Anda belum menginput data Harga Jual, cek kembali inputan Anda.');
            setTimeout(function() {
                $("#txtharjul").focus();
            }, 0);
        } else if (!diskonV.trim()) {
            alert('Anda belum menginput data Diskon, cek kembali inputan Anda.');
            setTimeout(function() {
                $("#txtdiskon").focus();
            }, 0);
        } else {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url().'admin/markup_kasir/update_markup';?>",
                data: {
                    nofak  : nofakV,
                    idbrg  : idbrgV,
                    harjul : harjulV,
                    diskon : diskonV,
                    total  : totalV,
                    qty    : qtyV,
                    idset  : idset,
                    deskset: deskset,
                    jmlset : jmlset

                },
                dataType: 'json',
                success: function (data) {
                    if (data.error) {
                        alert('Terjadi kesalahan: ' + data.error); // Memberikan umpan balik kepada pengguna
                    } else {
                        $('#modalEdit').modal('hide');
                        tampilMarkup();
                        
                    }
                },
                error: function (xhr, status, error) {
                    console.error("AJAX error:", error);
                    alert('Terjadi kesalahan saat mengirim permintaan AJAX.'); // Memberikan umpan balik kepada pengguna
                }
            });
        }
    });

    // Menangani tombol "Buat Data Garansi" yang diklik
    $(document).on('click', '.btn-markup', function () {
        //$('#ket').val(''); //mengosongkan data dulu
        $('#txtharjul').val('');
        $('#txtdiskon').val('');
        $('#txttotal').val('');
        // Ambil data dari tombol yang diklik
        var nofak = $(this).data('nofak');
        var idbrg = $(this).data('idbrg');

        // Cari data yang sesuai dari data penjualan yang telah diambil sebelumnya
        var dataM = dataMarkup.filter(function (item) {
            return item.d_jual_nofak === nofak && item.d_jual_barang_id === idbrg;
        });

        // Bersihkan isi tabel modal sebelum menambahkan data baru
        $('#tbl_info tbody').empty();

        // Loop through the data and append rows to the modal table
        $.each(dataM, function (index, item) {
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

            $('#tbl_info tbody').append(newRow);
            
            //-------------------------
            $('#txtnofak').val(nofak);
            $('#txtidbrg').val(idbrg);
            $('#txtqty').val(qty);
            $('#txttot').val(total);
            $('#nofakValue').text(nofak);
            $('#tglValue').text(item.jual_tanggal);
            $('#nmcustValue').text(item.jual_cust_nama);
            $('#jenisByr').text(item.jual_bayar);
            $('#statusByr').text(item.jual_bayar_status);

            var idset = item.group_id;
            if (idset === null || idset === '') {
                $('#tbl_set').hide();
                $('#groupid').hide();
                $('#txtidset').val('');
                $('#txtdeskset').val('');
                $('#txtjmlset').val('');
            } else {
                $('#tbl_set').show();
                $('#groupid').show();
                $('#txtidset').val(item.group_id);
                $('#txtdeskset').val(item.group_desc);
                $('#txtjmlset').val(item.group_sat);
            }
                       
            
        });

        // Tampilkan modal
        //$('#modalEdit').modal('show');
    });
</script>





<script type="text/javascript">
$(document).ready(function() {
    $(document).on('input', 'input[name^="txtqty"]', function(e) {
        var inputValue = e.target.value;
        var sanitizedValue = inputValue.replace(/[^0-9,\b\t]/g, ''); 
        e.target.value = sanitizedValue; 
    });

    $(document).on('input', 'input[name^="txtharjul"]', function(e) {
        var inputValue = e.target.value;
        var sanitizedValue = inputValue.replace(/[^0-9\b\t]/g, ''); // Hapus karakter yang tidak diizinkan (selain angka, koma, backspace, delete, dan tab)
        e.target.value = sanitizedValue; // Update nilai input dengan karakter yang diizinkan
    });

    $(document).on('blur', 'input[name^="txtharjul"]', function(e) {
        var nilai = parseFloat($(this).val().replace(/[^\d.,]/g, '')) || 0;
        var formattednilai = nilai.toLocaleString('id-ID');
        $(this).val(formattednilai);
        hitungtotal()
    });

    $(document).on('input', 'input[name^="txtdiskon"]', function(e) {
        var inputValue = e.target.value;
        var sanitizedValue = inputValue.replace(/[^0-9\b\t]/g, ''); // Hapus karakter yang tidak diizinkan (selain angka, koma, backspace, delete, dan tab)
        e.target.value = sanitizedValue; // Update nilai input dengan karakter yang diizinkan
    });

    $(document).on('blur', 'input[name^="txtdiskon"]', function(e) {
        var nilai = parseFloat($(this).val().replace(/[^\d.,]/g, '')) || 0;
        var formattednilai = nilai.toLocaleString('id-ID');
        $(this).val(formattednilai);
        hitungtotal()
    });

    function hitungtotal() {
        var harjulVal = parseFloat($('#txtharjul').val().replace(/[^\d,]/g, '')) || 0;
        var discVal = parseFloat($('#txtdiskon').val().replace(/[^\d,]/g, '')) || 0;
        //var qtyVal = parseFloat($('#txtqty').val()) || 0;
        var qtyVal = parseFloat($('#txtqty').val().replace(',', '.')) || 0;
        var totalHarga = (harjulVal * qtyVal) - discVal;
        var formattedHasil = Math.floor(totalHarga).toLocaleString('id-ID');
        $('#txttotal').val(formattedHasil);
        var totVal = parseFloat($('#txttot').val()) || 0;
        if (totalHarga <= totVal) {
            alert('untuk Harga Total yang di Mark up lebih kecil dari Total Harga Sebenarnya,cek kembali inputan anda.');
            setTimeout(function() {
                $("#txtharjul").focus(); // Tambahkan delay untuk memastikan pengaturan fokus berhasil
            }, 0);
        }

    }

    $(document).on('input', 'input[name^="txtjmlbyr"]', function(e) {
        var inputValue = e.target.value;
        var sanitizedValue = inputValue.replace(/[^0-9\b\t]/g, ''); // Hapus karakter yang tidak diizinkan (selain angka, koma, backspace, delete, dan tab)
        e.target.value = sanitizedValue; // Update nilai input dengan karakter yang diizinkan
    });

    $(document).on('blur', 'input[name^="txtjmlbyr"]', function(e) {
        var nilai = parseFloat($(this).val().replace(/[^\d.,]/g, '')) || 0;
        var formattednilai = nilai.toLocaleString('id-ID');
        $(this).val(formattednilai);
    });

    
});

</script>
<script>
    function varCetak_Markup() {
        var nofakC = $("#nofak").val();
        var pathC = "<?php echo base_url().'admin/markup_kasir/cetak_faktur/';?>";
        var form = document.querySelector('#myForm'); 
        form.action = pathC + nofakC;
        form.target = '_blank';
        form.submit(); // Mengirimkan formulir
    }

    function varCetak_Markup2() {
        var nofakC = $("#nofak").val();
        var pathC = "<?php echo base_url().'admin/markup_kasir/cetak_faktur2/';?>";
        var form = document.querySelector('#myForm'); 
        form.action = pathC + nofakC;
        form.target = '_blank';
        form.submit(); // Mengirimkan formulir
    }
</script>


</body>
</html>
