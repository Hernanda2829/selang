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

    <title>Data Penjualan Tempo</title>
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

<style>

    .bootstrap-select .btn {
        font-size: 11px; /* Ganti 16px sesuai dengan ukuran font yang Anda inginkan */
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
                <h1 class="page-header">Data
                    <small>Penjualan Tempo</small>
                    <div class="pull-right"><a href="#" class="btn btn-sm btn-success" data-toggle="modal" data-target="#largeModal"><span class="fa fa-plus"></span> Tambah Penjualan Tempo</a></div>
                </h1>
            </div>
        </div>
        <!-- /.row -->
        <!-- Projects Row -->
        <div class="row">
            <div class="col-lg-12">
            <table class="table table-bordered table-condensed" style="font-size:11px;" id="mydata">
                <thead>
                    <tr>
                        <th style="vertical-align:middle;text-align:center;">No</th>
                        <th style="vertical-align:middle;text-align:center;">Kantor Cabang</th>
                        <th style="vertical-align:middle;text-align:center;">No Faktur</th>
                        <th style="vertical-align:middle;text-align:center;">Nama Customer</th>
                        <th style="vertical-align:middle;text-align:center;width:20px;">No Nota</th>
                        <th style="vertical-align:middle;text-align:center;">Tgl Penjulan</th>
                        <th style="vertical-align:middle;text-align:center;width:20px;">Tempo Bulan</th>
                        <th style="vertical-align:middle;text-align:center;">Jumlah Hutang</th>
                        <th style="vertical-align:middle;text-align:center;">Status</th>
                        <th style="vertical-align:middle;text-align:center;width:100px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                    $no=0;
                    foreach ($data->result_array() as $a):
                        $no++;
                        $cab=$a['reg_name'];
                        $nofak=$a['jual_nofak'];
                        $nmcust=$a['jual_cust_nama'];
                        $nota=$a['jual_nota'];
                        $tgljual=$a['jual_tanggal'];
                        $tempobln=$a['jual_bulan_tempo'];
                        $jtot=$a['jual_total'];
                        $jstatus=$a['jual_bayar_status'];
                ?>
                    <tr>
                        <td style="text-align:center;"><?php echo $no;?></td>
                        <td><?php echo $cab;?></td>
                        <td><?php echo $nofak;?></td>
                        <td><?php echo $nmcust;?></td>
                        <td style="text-align:center;"><?php echo $nota;?></td>
                        <td style="text-align:center;"><?php echo $tgljual;?></td>
                        <td style="text-align:center;"><?php echo $tempobln;?></td>
                        <td style="text-align:right;"><?php echo 'Rp ' .number_format($jtot,0, ',' ,'.'); ?></td>
                        <td style="text-align:center;"><?php echo $jstatus;?></td>
                        <td style="text-align:center;">
                            <a class="btn btn-xs btn-warning btn-edit" href="#modalEdit" data-toggle="modal" title="Edit Data" data-nofak="<?php echo $nofak;?>"><span class="fa fa-edit"></span> Edit</a>
                            <a class="btn btn-xs btn-danger btn-hapus" href="#modalHapus" data-toggle="modal" title="Hapus Data" data-nofak="<?php echo $nofak;?>" data-nmcust="<?php echo $nmcust;?>" data-nota="<?php echo $nota;?>" data-tgljual="<?php echo $tgljual;?>" data-jtot="<?php echo $jtot;?>"><span class="fa fa-close"></span> Hapus</a>
                        </td>
                    </tr>
                <?php endforeach;?>
                </tbody>
            </table>
            </div>
        </div>
        <!-- /.row -->

        

        <!-- ============ MODAL ADD =============== -->
        <div class="modal fade" id="largeModal" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 class="modal-title" id="myModalLabel">Tambah Penjualan Tempo</h3>
            </div>
            <form class="form-horizontal" method="post" action="<?php echo base_url().'admin/tempo_admin/add_tempo'?>">
                <div class="modal-body" style="overflow:scroll;height:450px;">
                    <table class="table table-bordered table-condensed" style="font-size:11px;margin-bottom:5px;">
                        <tr>
                            <th style="width:150px;vertical-align:middle;">Kantor Cabang</th>
                            <td>
                                <select name="regid2" id="regid2" class="selectpicker show-tick form-control" data-live-search="true" title="Pilih Cabang" data-width="200px" required>
                                <?php 
                                    foreach ($regions ->result_array() as $rg) {
                                        $reg_id = $rg['reg_id'];
                                        $reg_name = $rg['reg_name'];    
                                        echo '<option value="'.$reg_id.'" style="font-size:11px">'.$reg_name.'</option>';
                                    }
                                ?>
                                </select>
                            </td>   
                        </tr>
                        <tr>
                            <th style="width:150px;vertical-align:middle;">Nama Customer</th>
                            <td>
                                <select name="idcust2" id="idcust2" class="selectpicker show-tick form-control" data-live-search="true" title="Pilih Customer" data-width="400px" required>
                                <?php 
                                
                                    foreach ($cust->result_array() as $c) {
                                        $id_cust=$c['cust_id'];
                                        $nm_cust=$c['cust_nama'];
                                        $al_cust=$c['cust_alamat'];
                                        $notelp_cust=$c['cust_notelp'];        
                                        echo "<option value='$id_cust' style='font-size:11px;width:400px;'>$nm_cust - $al_cust - $notelp_cust</option>";
                                    }
                                ?>
                                </select>
                            </td>   
                        </tr>
                        <tr>
                            <th style="width:150px;vertical-align:middle;">No Nota</th>
                            <td>
                                <input name="nota2" id="nota2" class="form-control input-sm" type="text" placeholder="No Nota" style="font-size:11px;width:130px;" required>
                            </td>
                        </tr>
                        <tr>
                            <th style="width:150px;vertical-align:middle;">Tgl Penjualan</th>
                            <td>
                                <div class='input-group date' id='datepicker' style="width:130px;">
                                    <input type='text' name="tgljual2" id="tgljual2" class="form-control" style="font-size:11px;color:green;" placeholder="Tanggal..." value="<?= $today ?>" required>
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th style="width:150px;vertical-align:middle;">Tempo Bulan</th>
                            <td>
                                <select name="prdbln2" id="prdbln2" class="selectpicker show-tick form-control" title="Pilih Bulan" placeholder="Pilih Bulan" data-width="130px" required>
                                <?php
                                    foreach ($periode->result_array() as $p) {
                                        $pval = $p['p_val'];
                                        $pnm = $p['p_nama'];
                                        echo "<option value='$pval' style='font-size:11px;'>$pval $pnm</option>";
                                    }  
                                ?>
                                </select>
                            </td>   
                        </tr>
                        <tr>
                            <th style="width:150px;vertical-align:middle;">Jumlah Hutang</th>
                            <td>
                                <input name="jtot2" id="jtot2" class="form-control input-sm" type="text" placeholder="Jumlah Hutang" style="width:130px;text-align:right;" required>
                            </td>     
                        </tr>
                    </table>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-info">Simpan</button>    
                    <button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
                </div>
            </form>
            </div>
            </div>
        </div>

        <!-- ============ MODAL EDIT =============== -->
        <div id="modalEdit" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 class="modal-title" id="myModalLabel">Edit Penjualan Tempo</h3>
            </div>
            <form class="form-horizontal" method="post" action="<?php echo base_url().'admin/tempo_admin/update_tempo'?>">
                <div class="modal-body" style="overflow:scroll;height:450px;">
                    <table class="table table-bordered table-condensed" style="font-size:11px;margin-bottom:5px;">
                        <tr>
                            <th style="width:150px;vertical-align:middle;">Kantor Cabang</th>
                            <td>
                                <select name="regid" id="regid" class="selectpicker show-tick form-control" data-live-search="true" title="Pilih Cabang" data-width="200px" required>
                                <?php 
                                    foreach ($regions ->result_array() as $rg) {
                                        $reg_id = $rg['reg_id'];
                                        $reg_name = $rg['reg_name'];    
                                        echo '<option value="'.$reg_id.'" style="font-size:11px">'.$reg_name.'</option>';
                                    }
                                ?>
                                </select>
                            </td>   
                        </tr>
                        <tr>
                            <th style="width:150px;vertical-align:middle;">No Faktur</th>
                            <td>
                                <input name="nofak" id="nofak" class="form-control input-sm" type="text" placeholder="No Faktur" style="font-size:11px;width:130px;" readonly>
                            </td>
                        </tr>
                        <tr>
                            <th style="width:150px;vertical-align:middle;">Nama Customer</th>
                            <td>
                                <select name="idcust" id="idcust" class="selectpicker show-tick form-control" data-live-search="true" title="Pilih Customer" data-width="400px" required>
                                <?php 
                                
                                    foreach ($cust->result_array() as $c) {
                                        $id_cust=$c['cust_id'];
                                        $nm_cust=$c['cust_nama'];
                                        $al_cust=$c['cust_alamat'];
                                        $notelp_cust=$c['cust_notelp'];        
                                        echo "<option value='$id_cust' style='font-size:11px;width:400px;'>$nm_cust - $al_cust - $notelp_cust</option>";
                                    }
                                ?>
                                </select>
                            </td>   
                        </tr>
                        <tr>
                            <th style="width:150px;vertical-align:middle;">No Nota</th>
                            <td>
                                <input name="nota" id="nota" class="form-control input-sm" type="text" placeholder="No Nota" style="font-size:11px;width:130px;" required>
                            </td>
                        </tr>
                        <tr>
                            <th style="width:150px;vertical-align:middle;">Tgl Penjualan</th>
                            <td>
                                <div class='input-group date' id='datepicker' style="width:130px;">
                                    <input type='text' name="tgljual" id="tgljual" class="form-control" style="font-size:11px;color:green;" placeholder="Tanggal..." required>
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th style="width:150px;vertical-align:middle;">Tempo Bulan</th>
                            <td>
                                <select name="prdbln" id="prdbln" class="selectpicker show-tick form-control" title="Pilih Bulan" placeholder="Pilih Bulan" data-width="130px" required>
                                <?php
                                    foreach ($periode->result_array() as $p) {
                                        $pval = $p['p_val'];
                                        $pnm = $p['p_nama'];
                                        echo "<option value='$pval' style='font-size:11px;'>$pval $pnm</option>";
                                    }  
                                ?>
                                </select>
                            </td>   
                        </tr>
                        <tr>
                            <th style="width:150px;vertical-align:middle;">Jumlah Hutang</th>
                            <td>
                                <input name="jtot" id="jtot" class="form-control input-sm" type="text" placeholder="Jumlah Hutang" style="width:130px;text-align:right;" required>
                            </td>     
                        </tr>
                    </table>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-info">Update</button>    
                    <button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
                </div>
            </form>
        </div>
        </div>
        </div>
       
        <!-- ============ MODAL HAPUS =============== -->
        <div id="modalHapus" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 class="modal-title" id="myModalLabel">Hapus Penjualan Tempo</h3>
            </div>
            <form class="form-horizontal" method="post" action="<?php echo base_url().'admin/tempo_admin/hapus_tempo'?>">
                <div class="modal-body">
                    <p>Yakin mau menghapus data ..? <br>
                    No Faktur : <b><span id="nofakVal"></span></b><br>
                    Nama Customer : <b><span id="nmcustVal"></span></b><br>
                    No Nota : <b><span id="notaVal"></span></b><br>
                    Tgl Penjualan : <b><span id="tgljualVal"></span></b><br>
                    Jumlah Hutang : <b><span id="jtotVal"></span></b><br>
                    </p>
                    <input name="txtkode" id="txtkode" type="hidden">

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Hapus</button>
                    <button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
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
            $('#datepicker').datetimepicker({
                format: 'YYYY-MM-DD',
            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#mydata').DataTable();
        } );
    </script>
    
    

<script type="text/javascript">
$(document).on('click', '.btn-edit', function() {
    var kode = $(this).data('nofak');
    $.ajax({
        type: "POST",
        url: "<?php echo base_url().'admin/tempo_admin/get_tempo';?>",
        data: {
            kode: kode
        },
        dataType: 'json',
        success: function (data) {
            // console.log(data);
            // console.log(kode);
            if (data.length !== 0) {
                $.each(data, function (index, item) { 
                    var jtotal = parseFloat(item.jual_total);
                    $('#regid').val(item.jual_reg_id);
                    $('#regid').selectpicker('refresh');
                    $('#nofak').val(item.jual_nofak);
                    $('#idcust').val(item.jual_cust_id);
                    $('#idcust').selectpicker('refresh');
                    $('#nota').val(item.jual_nota);
                    $('#tgljual').val(item.jual_tanggal);
                    $('#prdbln').val(item.jual_bulan_tempo);
                    $('#prdbln').selectpicker('refresh');
                    $('#jtot').val(jtotal.toLocaleString('id-ID'));
                });
            } else {
                    console.log("No data found.");
            }
            
        },
        error: function (xhr, status, error) {
            console.error("AJAX error:", error);
            alert('Terjadi kesalahan saat mengirim permintaan AJAX.'); // Memberikan umpan balik kepada pengguna
        }
    });
});
</script>

<script type="text/javascript">
$(document).on('change', '#regid', function(e) {
    var regid = $(this).val();
    
    // Menghancurkan dan menginisialisasi kembali Selectpicker
    $('#idcust').selectpicker('destroy');
    
    // Kosongkan elemen select
    $('#idcust').empty();

    $.ajax({
        url: "<?php echo base_url().'admin/tempo_admin/tampil_customer';?>",
        type: "POST",
        data: {regid: regid},
        success: function (data) {
            var parsedData = JSON.parse(data);

            if (parsedData.length !== 0) {
                // Iterasi melalui data dan tambahkan setiap opsi ke dalam select
                parsedData.forEach(function(item) {
                    var optionElement = document.createElement('option');
                    optionElement.value = item.cust_id;
                    optionElement.text = item.cust_nama + ' ' + item.cust_alamat + ' ' + item.cust_notelp;
                    optionElement.style.fontSize = '11px';
                    $('#idcust').append(optionElement);
                });
                // Set lebar hanya jika ada opsi
                $('#idcust').css('width', '400px');
                // Inisialisasi kembali Selectpicker setelah mengubah opsi
                $('#idcust').selectpicker();
            } else {
                console.log("No data found.");
            }
        },
        error: function(xhr, status, error) {
            console.error("AJAX error:", error);
        }
    });
});

</script>

<script type="text/javascript">
$(document).on('change', '#regid2', function(e) {
    var regid = $(this).val();
    
    // Menghancurkan dan menginisialisasi kembali Selectpicker
    $('#idcust2').selectpicker('destroy');
    
    // Kosongkan elemen select
    $('#idcust2').empty();

    $.ajax({
        url: "<?php echo base_url().'admin/tempo_admin/tampil_customer';?>",
        type: "POST",
        data: {regid: regid},
        success: function (data) {
            var parsedData = JSON.parse(data);

            if (parsedData.length !== 0) {
                // Iterasi melalui data dan tambahkan setiap opsi ke dalam select
                parsedData.forEach(function(item) {
                    var optionElement = document.createElement('option');
                    optionElement.value = item.cust_id;
                    optionElement.text = item.cust_nama + ' ' + item.cust_alamat + ' ' + item.cust_notelp;
                    optionElement.style.fontSize = '11px';
                    $('#idcust2').append(optionElement);
                });
                // Set lebar hanya jika ada opsi
                $('#idcust2').css('width', '400px');
                // Inisialisasi kembali Selectpicker setelah mengubah opsi
                $('#idcust2').selectpicker();
            } else {
                console.log("No data found.");
            }
        },
        error: function(xhr, status, error) {
            console.error("AJAX error:", error);
        }
    });
});

</script>


<script type="text/javascript">
$(document).ready(function () {
    $(document).on('click', '.btn-hapus', function () {
        var nofak = $(this).data('nofak');
        var nmcust = $(this).data('nmcust');
        var nota = $(this).data('nota');
        var tgljual = $(this).data('tgljual');
        var jtot = $(this).data('jtot');
        $('#txtkode').val(nofak);
        $('#nofakVal').text(nofak);
        $('#nmcustVal').text(nmcust);
        $('#notaVal').text(nota);
        $('#tgljualVal').text(tgljual);
        $('#jtotVal').text(jtot.toLocaleString('id-ID'));
    });
});
</script>


<script type="text/javascript">
$(document).ready(function() {
    $(document).on('input', 'input[name^="jtot"]', function(e) {
        var inputValue = e.target.value;
        var sanitizedValue = inputValue.replace(/[^0-9\b\t]/g, ''); // Hapus karakter yang tidak diizinkan (selain angka, koma, backspace, delete, dan tab)
        e.target.value = sanitizedValue; // Update nilai input dengan karakter yang diizinkan
        var nilai = parseFloat($(this).val().replace(/[^\d.,]/g, '')) || 0;
        var formattednilai = nilai.toLocaleString('id-ID');
        $(this).val(formattednilai);
    });

    $(document).on('input', 'input[name^="jtot2"]', function(e) {
        var inputValue = e.target.value;
        var sanitizedValue = inputValue.replace(/[^0-9\b\t]/g, ''); // Hapus karakter yang tidak diizinkan (selain angka, koma, backspace, delete, dan tab)
        e.target.value = sanitizedValue; // Update nilai input dengan karakter yang diizinkan
        var nilai = parseFloat($(this).val().replace(/[^\d.,]/g, '')) || 0;
        var formattednilai = nilai.toLocaleString('id-ID');
        $(this).val(formattednilai);
    });

});
</script>


</body>

</html>
