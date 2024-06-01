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

    <title>Data Garansi</title>
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
    @media print {
    body {
        margin: 0;
        padding: 0;
        background-color: #fff;
    }

    .qr-code {
        width: 100px; /* Sesuaikan ukuran gambar QR code di sini */
        height: 100px; /* Sesuaikan ukuran gambar QR code di sini */
        display: inline-block;
        margin: 5px; /* Jarak antar gambar QR code di sini */
    }
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
                <center><?php echo $this->session->flashdata('msg');?></center>
                <h3 class="page-header">Data Garansi Barang 
                </h3>
            </div>
        </div>
        <br>

    <div class="row" style="margin-bottom:10px;">
    <div class="col-lg-12">
        <table id="mydata" class="table table-bordered table-condensed" style="font-size:11px;margin-top:10px;">
            <thead>
                <tr>
                    <th style="text-align:center;">No</th>
                    <th style="text-align:center;">Tgl Transaksi</th>
                    <th style="text-align:center;">No Faktur</th>
                    <th style="text-align:center;">Nama Customer</th>
                    <th style="text-align:center;">Kode Barang</th>
                    <th style="text-align:center;">Nama Barang</th>
                    <th style="text-align:center;">Satuan</th>
                    <th style="text-align:center;">Quantity</th>
                    <th style="text-align:center;">Harga Jual</th>
                    <th style="text-align:center;">Diskon</th>
                    <th style="text-align:center;">Total</th>
                    <th style="text-align:center;width:120px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $no=0;
                    foreach ($g_data->result_array() as $g):
                        $no++;
                        $g_id=$g['g_id'];
                        $g_img=$g['g_image'];
                        $g_tgl=$g['g_jual_tgl'];
                        $g_nofak=$g['g_nofak'];
                        $g_cust=$g['g_cust_nama'];
                        $g_kode=$g['g_brg_id'];
                        $g_nm=$g['g_brg_nama'];
                        $g_sat=$g['g_brg_sat'];
                        $g_qty=$g['g_qty'];
                        $g_harjul=$g['g_harjul'];
                        $g_diskon=$g['g_diskon'];
                        $g_tot=$g['g_total'];
                    
                        if (floor($g_qty) == $g_qty) {
                            $formatted_g_qty = number_format($g_qty, 0, ',', '.');
                        } else {
                            $formatted_g_qty = number_format($g_qty, 2, ',', '.');
                            $formatted_g_qty = rtrim($formatted_g_qty, '0');
                            $formatted_g_qty = rtrim($formatted_g_qty, ',');
                        }
                ?>
                <tr>
                    <td style="text-align:center;"><?= $no ;?></td>
                    <td><?= $g_tgl ;?></td>
                    <td><?= $g_nofak ;?></td>
                    <td><?= $g_cust ;?></td>
                    <td><?= $g_kode ;?></td>
                    <td><?= $g_nm ;?></td>
                    <td style="text-align:center;"><?= $g_sat ;?></td>
                    <td style="text-align:center;"><?= $formatted_g_qty ;?></td>
                    <td style="text-align:right;"><?= str_replace(',', '.', number_format($g_harjul)) ;?></td>
                    <td style="text-align:right;"><?= str_replace(',', '.', number_format($g_diskon)) ;?></td>
                    <td style="text-align:right;"><?= str_replace(',', '.', number_format($g_tot)) ;?></td>
                    <td style="text-align:center;">
                    <a href="#modalLihatGaransi" data-toggle="modal" class="btn btn-warning btn-xs btn-tampilgaransi" data-nofak="<?= $g_nofak ;?>" data-idbrg="<?= $g_kode ;?>" title="Lihat Data Keterangan Garansi"><span class="fa fa-dashboard"></span> Lihat</a>
                    <a class="btn btn-xs btn-danger btn-hapus" href="#modalHapusData" data-toggle="modal" data-gid="<?= $g_id ;?>" data-gimg="<?= $g_img ;?>" data-nofak="<?= $g_nofak ;?>" data-idbrg="<?= $g_kode ;?>" title="Hapus Data Penjualan"><span class="fa fa-print"></span> Hapus</a>
                    </td>
                </tr>
            <?php endforeach;?>
            </tbody>
        </table>
    </div>
    </div>

    <!-- ============ MODAL HAPUS =============== -->               
        <div id="modalHapusData" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 class="modal-title" id="myModalLabel">Hapus Data Penjualan</h3>
            </div>
            <form class="form-horizontal" method="post" action="<?php echo base_url().'admin/garansi/hapus_data'?>">
                <div class="modal-body">
                    <p>Yakin mau menghapus Data Garansi : <br>
                    No Faktur : <b><span id="nofakVal"></span></b><br>
                    Kode Barang : <b><span id="idbrgVal"></span></b></p>
                    <p>Proses ini sekaligus menghapus file gambar data garansi yang terkait.</p>
                        <input name="txtid" id="txtid" type="hidden">
                        <input name="txtimg" id="txtimg" type="hidden">
                        <input name="txtnofak" id="txtnofak" type="hidden">
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Hapus</button>
                    <button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
                </div>
            </form>
        </div>
        </div>
        </div>
           
    <!-- ============ MODAL Lihat Data Garansi =============== -->
        <div id="modalLihatGaransi" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 class="modal-title" id="myModalLabel"><small>Data Garansi - <?php echo $userid['reg_code'];?>  <?php echo $userid['reg_name'];?></small></h3>
        </div>
            <div class="modal-body" style="overflow:scroll;height:450px;">  
                <table id="tbl_head2" style="font-size:11px;">
                <tr>
                    <th style="font-weight:normal;width:15%;">Tgl Transaksi</th>
                    <th style="font-weight:normal;text-align:center;width:3%;">: </th>
                    <th style="font-weight:normal;width:30%;"><b><span id="tglValue2"></span></b></th>
                </tr>
                <tr>
                    <th style="font-weight:normal;width:15%;">Nama Customer</th>
                    <th style="font-weight:normal;text-align:center;width:3%;">: </th>
                    <th style="font-weight:normal;width:30%;"><b><span id="nmcustValue2" style="color: green;"></span></b></th>
                    <th style="font-weight:normal;text-align:right;width:30%;">Jenis Bayar</th>
                    <th style="font-weight:normal;text-align:center;width:3%;"> : </th>
                    <th style="font-weight:normal;text-align:right;width:15%;"><span id="jenisByr2" style="color: green;"></span></th>
                </tr>
                <tr>
                    <th style="font-weight:normal;width:15%;">No Faktur</th>
                    <th style="font-weight:normal;text-align:center;width:3%;">: </th>
                    <th style="font-weight:normal;width:30%;"><b><span id="nofakValue2"></span></b></th>
                    <th style="font-weight:normal;text-align:right;width:30%;">Status Bayar</th>
                    <th style="font-weight:normal;text-align:center;width:3%;"> : </th> 
                    <th style="font-weight:normal;text-align:right;width:15%;"><span id="statusByr2" style="color: green;"></span></th>
                </table>
                <table id="tbl_info2" class="table table-bordered table-condensed" style="font-size:11px;">
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
                
            <!-- Navigasi Tab -->
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#file1" style="font-size:11px;"><b>Barcode</b></a></li>
                    <li><a data-toggle="tab" href="#file2" style="font-size:11px;"><b>File Garansi</b></a></li>
                    <!-- Tambahkan lebih banyak tab sesuai kebutuhan -->
                </ul>

                <!-- Isi Tab -->
                <div class="tab-content">
                    <!-- Tab 1: Informasi -->
                    <div id="file1" class="tab-pane fade in active">
                    <br>
                    <p style="font-size:11px;margin-bottom:0;"><span id="inputByrValue2"><b>Keterangan Garansi, </b></span></p>
                    <table class="table table-bordered table-condensed" style="font-size: 11px;">
                        <tr>
                            <th style="width: 150px; padding-bottom: 5px; vertical-align: middle;">Periode Garansi:</th>
                            <td>
                                <div style="display: flex; align-items: center;">
                                    <input type="text" id="periode2" name="periode2" class="form-control input-sm" style="width: 50px; margin-right: 10px;" readonly>
                                    <span style="margin-right: 10px;">Bulan, Tgl Jatuh Tempo:</span>
                                    <input type="text" id="tglJtempo2" name="tglJtempo2" class="form-control input-sm" style="width: 120px;" readonly>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th style="width:150px;padding-bottom:5px;vertical-align:middle;">Keterangan : </th>
                            <td><textarea id="ket2" name="ket2" class="form-control input-sm" style="width:400px;height:80px;resize:none;overflow-y:auto;" maxlength="255" readonly></textarea></td>                        
                        </tr>
                        <tr>
                            <td colspan="2" style="text-align:center;">
                                <img id="modalImage" class="modal-image" alt="Gambar" />
                            </td>
                        </tr>
                    </table>
                    </div>
                    <!-- Tab 2: History -->
                    <div id="file2" class="tab-pane fade">
                        <br>
                    <table id="tbl_file" class="table table-bordered table-condensed" style="font-size:11px;margin-top:10px;">
                    <thead>
                        <tr>
                            <th style="text-align:center;">Nama File</th>
                            <th style="text-align:center;">File</th>
                            <th style="text-align:center;width:100px;">Aksi</th>
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
    <script src="<?php echo base_url().'assets/js/moment.js'?>"></script>
    <script src="<?php echo base_url().'assets/js/bootstrap-datetimepicker.min.js'?>"></script>
    <script src="<?php echo base_url().'assets/js/jquery.dataTables.min.js'?>"></script>
    
<script type="text/javascript">
    $(document).ready(function() {
        $('#mydata').DataTable();
    } );
</script>

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

<script>
$(document).on('click', '.btn-hapus', function() {
    var g_id = $(this).data('gid');
    var g_nofak = $(this).data('nofak');
    var g_idbrg = $(this).data('idbrg');
    var g_img = $(this).data('gimg');
    $('#txtid').val(g_id);
    $('#txtimg').val(g_img);
    $('#txtnofak').val(g_nofak);
    $('#nofakVal').text(g_nofak);
    $('#idbrgVal').text(g_idbrg);
});
</script>

<script>
$(document).on('click', '.btn-tampilgaransi', function () {
    $('#detailTable tbody').empty();
    $('#tbl_info2 tbody').empty();
    $('#tbl_file tbody').empty();
    $('#modalImage').attr('src', '');   //mengosongkan tampilan gambar terlebih dahulu
    var nofak = $(this).data('nofak');
    var idbrg = $(this).data('idbrg');

    $.ajax({
        type: "POST",
        url: "<?php echo base_url().'admin/garansi/get_detail_jual';?>",
        data: { nofak: nofak },
        dataType: 'json',
        success: function (data) {
            if (data.error) {
                //console.error("Error:", data.error);
            } else {
                //console.log("Received data:", data);
                // Check if data is empty
                if (data.length === 0) {
                    //console.log("No data found.");
                } else {
                        // Simpan data penjualan ke variabel
                        dataGaransi = data.queryA;
                        // Cari data yang sesuai dari data penjualan yang telah diambil sebelumnya
                        var garansiData = dataGaransi.filter(function (item) {
                            return item.g_nofak === nofak && item.g_brg_id === idbrg;
                        });
                        // Loop through the data and append rows to the modal table
                        $.each(garansiData, function (index, item) {
                            var harjul = parseFloat(item.g_harjul);
                            var diskon = parseFloat(item.g_diskon);
                            var total = parseFloat(item.g_total);
                            var qty = parseFloat(item.g_qty);
                            var formatted_qty;
                            if (Math.floor(qty) === qty) {
                                formatted_qty = qty.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ','); // Format sebagai bilangan bulat
                            } else {
                                formatted_qty = qty.toFixed(2).replace('.', ',').replace(/\.?0+$/, '').replace(/\B(?=(\d{3})+(?!\d))/g, ','); // Format sebagai bilangan desimal
                            }
                            var newRow = '<tr>' +
                                '<td style="text-align:center;">' + item.g_brg_id + '</td>' +
                                '<td style="text-align:center;">' + item.g_brg_nama + '</td>' +
                                '<td style="text-align:center;">' + item.g_brg_sat + '</td>' +
                                '<td style="text-align:center;">' + formatted_qty + '</td>' +
                                '<td style="text-align:right;">' + harjul.toLocaleString('id-ID') + '</td>' +
                                '<td style="text-align:right;">' + diskon.toLocaleString('id-ID') + '</td>' +
                                '<td style="text-align:right;">' + total.toLocaleString('id-ID') + '</td>' +
                                '</tr>';

                            $('#tbl_info2 tbody').append(newRow);
                            //-------------------------
                            $('#nofakValue2').text(nofak);
                            $('#tglValue2').text(item.g_jual_tgl);
                            $('#nmcustValue2').text(item.g_cust_nama);
                            $('#jenisByr2').text(item.g_jenis_bayar);
                            $('#statusByr2').text(item.g_status_bayar);
                            $('#periode2').val(item.g_periode);
                            var date = new Date(item.g_jtempo);
                            var formattedDate = date.toLocaleDateString('id-ID'); // Menggunakan bahasa Indonesia
                            $('#tglJtempo2').val(formattedDate);            
                            $('#ket2').val(item.g_ket);
                            //cek gambar sudah ada atau belum 
                            //var gimage = item.g_url; // URL atau path file gambar
                            var nameimg = item.g_image;
                            var pathimg = "<?php echo base_url().'assets/img/img_barcode/'; ?>";
                            var gimage = pathimg + nameimg;
                            var modalImageElement = document.getElementById('modalImage');
                                var xhr = new XMLHttpRequest();
                                xhr.open('HEAD', gimage, true);
                                xhr.onreadystatechange = function () {
                                    if (xhr.readyState == 4) {
                                        if (xhr.status == 200) {
                                            // File gambar ditemukan
                                            //console.log('File gambar ada.');
                                            modalImageElement.src = gimage;
                                        } else {
                                            // File gambar tidak ditemukan atau terjadi kesalahan
                                            //console.log('File gambar tidak ditemukan atau terjadi kesalahan.');
                                        }
                                    }
                                };
                                xhr.send();

                        });

                        // Tampilkan modal
                        $('#modalLihatGaransi').modal('show');
                }
            }
        },
        error: function (xhr, status, error) {
            console.error("AJAX error:", error);
        }
    });

    //menampilkan file garansi
    $.ajax({
        type: "POST",
        url: "<?php echo base_url().'admin/garansi/get_garansi_file';?>",
        data: { 
            nofak : nofak,
            idbrg : idbrg
        },
        dataType: 'json',
        success: function (data) {
            if (data.error) {
                //console.error("Error:", data.error);
            } else {
                //console.log("Received data:", data);
                // Check if data is empty
                if (data.length === 0) {
                    //console.log("No data found.");
                } else {
                        $.each(data, function (index, itemB) {
                            var newRow = '<tr>' +
                                '<td style="text-align:center;vertical-align:middle;"><input type="text" name="nmfile[]" value="' + itemB.g_file + '" class="form-control input-sm nmfile" style="width:100%;" readonly></td>' +
                                '<td style="text-align:center;vertical-align:middle;"><img class="modal-image imgfile" alt="File" style="width:100px;height:100px;" src="<?php echo base_url();?>assets/img/file_garansi/' + itemB.g_file + '"></td>' +
                                '<td style="text-align:center;vertical-align:middle;">' +
                                '<a href="<?php echo base_url();?>assets/img/file_garansi/' + itemB.g_file + '" class="btn btn-info btn-xs" download="' + itemB.g_file + '" title="Unduh File"><span class="fa fa-download"></span> </a> ' +
                                '<a href="<?php echo base_url();?>assets/img/file_garansi/' + itemB.g_file + '" class="btn btn-success btn-xs" target="_blank" title="Buka File"><span class="fa fa-eye"></span> </a> ' +
                                '</td>' +
                                '</tr>';

                            $('#tbl_file tbody').append(newRow);
                        });
                }
            }
        },
        error: function (xhr, status, error) {
            console.error("AJAX error:", error);
        }
    }); 
    //------------------------
});
</script>



</body>
</html>
