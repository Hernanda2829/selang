<!DOCTYPE html>
<html lang="en">

<head>
    <?php 
	error_reporting(0);
    $userid=$userid->row_array();
    $data_regid=$userid['reg_id'];
    ?>  
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Produk By <?php echo $userid['co_name'];?>">
    <meta name="author" content="<?php echo $userid['co_name'];?>">

    <title>Pengeluaran</title>
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
                <h3 class="page-header" style="margin-top:5px;">Pengeluaran / Beban
                    <small>Operasional</small>
                    <div class="pull-right"><a href="#" class="btn btn-sm btn-success" data-toggle="modal" data-target="#largeModal"><span class="fa fa-plus"></span> Tambah Pengeluaran Opr</a></div>
                </h3>
            </div>
        </div>
        <!-- /.row -->
        <!-- Projects Row -->
        <div class="row">
            <div class="col-lg-6">
                <form class="form-horizontal" method="post" action="" target="_blank">
                <table style="font-size:12px;">
                    <tr>
                        <th style="width:5%;vertical-align:middle;">Tgl Transaksi :</th>
                        <td style="width:8%;vertical-align:middle;">
                            <div class="input-group date" id="datepicker1">
                                <input type="text" id="tgl1" name="tgl1" class="form-control input-sm" style="font-size:11px;color:green;" placeholder="Tanggal..." value="<?= $firstDayOfMonth; ?>" required>
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </td>
                        <td style="width:3%;vertical-align:middle;text-align:center"> S/d</td>
                        <td style="width:8%;vertical-align:middle;">
                            <div class="input-group date" id="datepicker2">
                                <input type="text" id="tgl2" name="tgl2" class="form-control input-sm" style="font-size:11px;color:green;" placeholder="Tanggal..." value="<?= $lastDayOfMonth; ?>" required>
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </td>
                        <td style="width:10%;vertical-align:middle;padding-left:20px;">
                            <a class="btn btn-sm btn-info btn-tampil" data-toggle="modal" title="Tampilkan Data"><span class="fa fa-search"></span></a>
                        </td>
                    </tr>
                </table>
                </form>
            </div>
        </div>
        <hr style="margin-top:10px;">
        <div class="row">
            <div class="col-lg-12">
            <table class="table table-bordered table-condensed" style="font-size:11px;" id="mydata">
                <thead>
                    <tr>
                        <th style="text-align:center;width:40px;">No</th>
                        <th style="text-align:center;">Tanggal Input</th>
                        <th style="text-align:center;">Nama Pengeluaran</th>
                        <th style="text-align:center;">Jumlah (Rp)</th>
                        <th style="text-align:center;">Jenis Pengeluaran</th>
                        <th style="text-align:center;">User</th>
                        <th style="text-align:center;">Cabang</th>
                        <th style="width:140px;text-align:center;">Aksi</th>
                    </tr>
                </thead>
                <tbody></tbody>
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
                <h3 class="modal-title" id="myModalLabel"><small>Tambah Pengeluaran / Beban Operasional</small></h3>
            </div>
            <form class="form-horizontal" method="post" action="<?php echo base_url().'admin/beban/tambah_beban'?>">
                <div class="modal-body">

                    <div class="form-group">        
                        <label class="control-label col-xs-3" style="font-size:12px;">Tgl Transaksi</label>
                        <div class="col-xs-9">
                            <div class='input-group date' id='datepicker3' style="width:130px;">
                                <input type='text' name="tgl" id="tgl" class="form-control" style="font-size:11px;color:green;" placeholder="Tanggal..." value="<?= $today ?>" required>
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">        
                        <label class="control-label col-xs-3" style="font-size:12px;">Pilih Kantor Cabang</label>
                        <div class="col-xs-9">
                            <select name="regid" id="regid" class="selectpicker show-tick form-control" data-live-search="true" title="Pilih Cabang" data-width="200px" required>
                            <?php 
                                foreach ($regions ->result_array() as $rg) {
                                    $reg_id = $rg['reg_id'];
                                    $reg_name = $rg['reg_name'];    
                                    echo '<option value="'.$reg_id.'" style="font-size:11px">'.$reg_name.'</option>';
                                }
                            ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3" style="font-size:12px;">Nama Pengeluaran</label>
                        <div class="col-xs-9">
                            <input name="nama" class="form-control" type="text" placeholder="Nama Beban..." style="width:400px;" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-3" style="font-size:12px;">Jenis Pengeluaran</label>
                        <div class="col-xs-6">
                            <select name="katid" id="katid" class="selectpicker show-tick form-control" title="Jenis Pengeluaran" style="width:200px;" placeholder="Jenis Pengeluaran" required>
                            <?php
                                foreach ($beban->result_array() as $b) {
                                    $kid = $b['kat_id'];
                                    $knm = $b['kat_nama'];
                                        echo "<option value='$kid'>$knm</option>";
                                }  
                            echo '</select>';
                            ?>
                        </div>
                    </div>
                    <div class="form-group" id="pilihrek" style="display:none;">
                        <label class="control-label col-xs-3" style="font-size:12px;">Pilih Rekening </label>
                        <div class="col-xs-9">
                            <select name="rek" id="rek" class="selectpicker show-tick form-control" title="Pilih No Rekening" data-width="95%" placeholder="Pilih No Rekening">
                            <?php
                                foreach ($rekening->result_array() as $r) {
                                    $rekno = $r['rek_norek'];
                                    $reknm = $r['rek_nama'];
                                    $rekbank = $r['rek_bank'];
                                        echo "<option value='$rekno'>$rekno - $reknm - $rekbank</option>";
                                }  
                            echo '</select>';
                            ?>
                        </div>
                    </div>    
                    <div class="form-group">
                        <label class="control-label col-xs-3" style="font-size:12px;">Jumlah</label>
                        <div class="col-xs-9">
                            <input name="jml" id="jml" class="form-control" type="text" placeholder="Ketikan angka..." style="text-align:right;width:150px;" required>
                        </div>
                    </div>  
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
                <h3 class="modal-title" id="myModalLabel"><small>Edit Pengeluaran / Beban Operasional</small></h3>
            </div>
            <form class="form-horizontal" method="post" action="<?php echo base_url().'admin/beban/edit_beban'?>">
                <div class="modal-body">
                    <input name="kode" id="kode" type="hidden">
                    <input name="bankno" id="bankno" type="hidden">
                    <input name="norek" id="norek" type="hidden">
                    <div class="form-group">        
                        <label class="control-label col-xs-3" style="font-size:12px;">Tgl Transaksi</label>
                        <div class="col-xs-9">
                            <div class='input-group date' id='datepicker4' style="width:130px;">
                                <input type='text' name="tglE" id="tglE" class="form-control" style="font-size:11px;color:green;" placeholder="Tanggal..." required>
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">        
                        <label class="control-label col-xs-3" style="font-size:12px;">Pilih Kantor Cabang</label>
                        <div class="col-xs-9">
                            <select name="regidE" id="regidE" class="selectpicker show-tick form-control" data-live-search="true" title="Pilih Cabang" data-width="200px" required>
                            <?php 
                                foreach ($regions ->result_array() as $rg) {
                                    $reg_id = $rg['reg_id'];
                                    $reg_name = $rg['reg_name'];    
                                    echo '<option value="'.$reg_id.'" style="font-size:11px">'.$reg_name.'</option>';
                                }
                            ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-3" style="font-size:12px;">Nama Pengeluaran</label>
                        <div class="col-xs-9">
                            <input name="namaE" id="namaE" class="form-control" type="text" placeholder="Nama Beban..." style="width:400px;" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-3" style="font-size:12px;">Jenis Pengeluaran</label>
                        <div class="col-xs-6">
                            <select name="katidE" id="katidE" class="selectpicker show-tick form-control" title="Jenis Pengeluaran" style="width:200px;" placeholder="Jenis Pengeluaran" required>
                            <?php
                                foreach ($beban->result_array() as $b) {
                                    $kid = $b['kat_id'];
                                    $knm = $b['kat_nama'];
                                    echo "<option value='$kid'>$knm</option>";
                                }  
                            echo '</select>';
                            ?>   
                        </div>
                    </div>
                    <div class="form-group" id="pilihrekE" name="pilihrekE" style="display:none;">
                        <label class="control-label col-xs-3" style="font-size:12px;">Pilih Rekening </label>
                        <div class="col-xs-9">
                        <select name="rekE" id="rekE" class="selectpicker show-tick form-control" title="Pilih No Rekening" data-width="95%" placeholder="Pilih No Rekening">
                        <?php        
                            foreach ($rekening->result_array() as $r) {
                                $rekno = $r['rek_norek'];
                                $reknm = $r['rek_nama'];
                                $rekbank = $r['rek_bank'];
                                echo "<option value='$rekno'>$rekno - $reknm - $rekbank</option>";
                                
                            }  
                        echo '</select>';
                        ?>       
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-3" style="font-size:12px;">Jumlah</label>
                        <div class="col-xs-9">
                            <input name="jmlE" id="jmlE" class="form-control jml" type="text" placeholder="Jumlah..." style="text-align:right;width:150px;" required>
                        </div>
                    </div>
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
                <h3 class="modal-title" id="myModalLabel"><small>Hapus Pengeluaran / Beban Operasional</small></h3>
            </div>
            <form class="form-horizontal" method="post" action="<?php echo base_url().'admin/beban/hapus_beban'?>">
                <div class="modal-body">
                    <p>Yakin mau menghapus Data Beban : <br>
                    Tgl Input : <b><span id="tglVal"></span></b><br>
                    Nama Beban : <b><span id="nmVal"></span></b><br>
                    Jumlah : <b><span id="jmlVal"></span></b><br>
                    Jenis Pengeluaran : <b><span id="jenVal"></span></b><br>
                    Kantor Cabang : <b><span id="cabVal"></span></b></p>
                    <input name="kodeH" id="kodeH" type="hidden">
                    <input name="banknoH" id="banknoH" type="hidden">

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
        $('#datepicker4').datetimepicker({
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
    var tbl_beban; // Variabel untuk tabel DataTable
    // Inisialisasi DataTable
    tbl_beban = $('#mydata').DataTable({
        ajax: {
            type: "POST", // Mengubah metode HTTP menjadi POST
            url: "<?php echo base_url().'admin/beban/get_tampil_beban';?>",
            data: function(d) {
                // Mengirim ID cabang saat permintaan AJAX
                d.tgl1 = $('#tgl1').val();
                d.tgl2 = $('#tgl2').val();
            }
        },
        columns: [
            { data: null,
                render: function(data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            { data: 'beban_tanggal2' },
            { data: 'beban_nama' },
            { data: 'beban_jumlah',
                className: 'text-right',
                render: function(data) {
                    var totalFormatted = Math.ceil(data).toLocaleString('id-ID', { style: 'currency', currency: 'IDR' }).replace(/,00$/, '');
                    return totalFormatted;
                }
            },   
            { data: 'beban_kat_nama' },
            { data: 'created_by' },
            { data: 'reg_name' },
            { data: null,
                className: 'text-center',
                render: function(data, type, row) {
                    return '<a class="btn btn-xs btn-warning btn-tampiledit" href="#modalEdit" data-toggle="modal" data-idbeb="' + row.beban_id + '" title="Edit Data Beban"><span class="fa fa-edit"></span> Edit</a> ' +
                            '<a class="btn btn-xs btn-danger btn-hapus" href="#modalHapus" data-toggle="modal" data-idbeb="' + row.beban_id + '" data-nobeb="' + row.beban_no + '" data-tglbeb="' + row.beban_tanggal + '" data-cab="' + row.reg_name + '" data-nmbeb="' + row.beban_nama + '" data-katnm="' + row.beban_kat_nama + '" data-jmlbeb="' + row.beban_jumlah + '" title="Hapus"><span class="fa fa-close"></span> Hapus</a>';
                }
            }
        ],
        language: {
            emptyTable: "Data tidak ditemukan!",
            loadingRecords: "Data tidak ditemukan!",
            zeroRecords: "Tidak ada data yang cocok ditemukan!"
        }
    });

    $(document).on('click', '.btn-tampil', function () {
        // Memanggil ulang data tanpa perlu memuat ulang kolom-kolomnya
        tbl_beban.ajax.reload();
    });
    

});

</script> 

<script type="text/javascript">
$(document).on('input', 'input[name="jml"]', function(e) {
    var inputValue = e.target.value;
    var sanitizedValue = inputValue.replace(/[^0-9\b\t]/g, ''); // Hapus karakter yang tidak diizinkan (selain angka, koma, backspace, delete, dan tab)
    e.target.value = sanitizedValue; // Update nilai input dengan karakter yang diizinkan
});

$(document).on('blur', 'input[name="jml"]', function(e) {
    var nilai = parseFloat($(this).val().replace(/[^\d.,]/g, '')) || 0;
    var formattednilai = nilai.toLocaleString('id-ID');
    $(this).val(formattednilai);
});

$(document).on('input', 'input[name="jmlE"]', function(e) {
    var inputValue = e.target.value;
    var sanitizedValue = inputValue.replace(/[^0-9\b\t]/g, ''); 
    e.target.value = sanitizedValue; 
});

$(document).on('blur', 'input[name="jmlE"]', function(e) {
    var nilai = parseFloat($(this).val().replace(/[^\d.,]/g, '')) || 0;
    var formattednilai = nilai.toLocaleString('id-ID');
    $(this).val(formattednilai);
});
</script>

<script type="text/javascript"> 
$(document).ready(function() {
    $('select[name="katid"]').on('change', function() {
        const cb = $('#katid option:selected').text();
        if (cb == "Transfer") {
            $('#pilihrek').show();
            $('#rek').selectpicker('val', '');
            $('#rek').selectpicker('refresh');
            $('#rek').prop('required', true);
        } else {
            $('#pilihrek').hide();
            $('#rek').selectpicker('val', '');
            $('#rek').selectpicker('refresh');
            $('#rek').removeAttr('required');
        }
    });
});
</script>

<script type="text/javascript"> 
$(document).ready(function() {
    //$('#rekE').selectpicker();
    $('select[name="katidE"]').on('change', function() {
        var katnm = $(this).find('option:selected').text();
        if (katnm == "Transfer") {
            $('#pilihrekE').show();
            $('#rekE').selectpicker('val', '');
            $('#rekE').selectpicker('refresh');
            $('#rekE').prop('required', true);
        } else {
            $('#pilihrekE').hide();
            $('#rekE').selectpicker('val', '');
            $('#rekE').selectpicker('refresh');
            $('#rekE').removeAttr('required');
        }
    });
});
</script>

<script type="text/javascript">
$(document).ready(function () {
    $(document).on('click', '.btn-tampiledit', function () {
      var idbeb = $(this).data('idbeb');
        $.ajax({
            url: "<?php echo base_url().'admin/beban/get_beban';?>",
            type: "POST",
            data: {
                idbeb: idbeb
            },
            success: function (data) {
                //console.log("Data from server:", data);
                //console.log(idbeb);
                var parsedData = JSON.parse(data);
                if (parsedData.length !== 0) {
                    $.each(parsedData.data, function (index, item) {
                        var jmlbeb = parseFloat(item.beban_jumlah);
                        $('#kode').val(item.beban_id);
                        $('#bankno').val(item.beban_no);
                        $('#norek').val(item.bank_norek);
                        $('#tglE').val(item.beban_tanggal);
                        $('#regidE').val(item.beban_reg_id);
                        $('#regidE').selectpicker('refresh');
                        $('#namaE').val(item.beban_nama);
                        $('#katidE').val(item.beban_kat_id);
                        $('#katidE').selectpicker('refresh');
                        $('#rekE').val(item.bank_norek);
                        $('#rekE').selectpicker('refresh');
                        $('#jmlE').val(jmlbeb.toLocaleString('id-ID'));
                        var katnama  = $('#katidE option:selected').text();
                        if (katnama == "Transfer") {
                            $('#pilihrekE').show();
                            //$('#rekE').selectpicker('val', '');
                            $('#rekE').selectpicker('refresh');
                            $('#rekE').prop('required', true);
                        } else {
                            $('#pilihrekE').hide();
                            //$('#rekE').selectpicker('val', '');
                            $('#rekE').selectpicker('refresh');
                            $('#rekE').removeAttr('required');
                        }
       
                    });
                        
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
$(document).on('click', '.btn-hapus', function() {
    var idbeb = $(this).data('idbeb');
    var nobeb = $(this).data('nobeb');
    var tglbeb = $(this).data('tglbeb'); 
    var cab = $(this).data('cab');
    var nmbeb = $(this).data('nmbeb'); 
    var katnm = $(this).data('katnm'); 
    var jmlbeb = parseFloat($(this).data('jmlbeb'));
    $('#tglVal').text(tglbeb);
    $('#nmVal').text(nmbeb);
    $('#jmlVal').text(jmlbeb.toLocaleString('id-ID'));
    $('#jenVal').text(katnm);
    $('#cabVal').text(cab);
    $('#kodeH').val(idbeb);
    $('#banknoH').val(nobeb);

});
</script>





</body>
</html>
