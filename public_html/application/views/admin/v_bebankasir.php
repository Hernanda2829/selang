<!DOCTYPE html>
<html lang="en">

<head>
    <?php 
	error_reporting(0);
    $userid=$userid->row_array();
    $usid=$userid['user_id'];
    ?>  
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Produk By <?php echo $userid['co_name'];?>">
    <meta name="author" content="<?php echo $userid['co_name'];?>">

    <title>Pengeluaran Operasional</title>
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
                <h3 class="page-header">Pengeluaran / Beban
                    <small>Operasional</small>
                    <div class="pull-right"><a href="#" class="btn btn-sm btn-success" data-toggle="modal" data-target="#modalAdd"><span class="fa fa-plus"></span> Tambah Beban Opr</a></div>
                </h3>
            </div>
        </div>
        <!-- /.row -->
        <!-- Projects Row -->
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
                        <!-- <th style="width:140px;text-align:center;">Aksi</th> -->
                    </tr>
                </thead>
                <tbody>
                <?php 
                    $no=0;
                    foreach ($data->result_array() as $a):
                        $no++;
                        $id=$a['beban_id'];
                        $tgl=$a['beban_tanggal'];
                        $nm=$a['beban_nama'];
                        $jml=$a['beban_jumlah'];
                        $katnama=$a['beban_kat_nama'];
                        //$uid=$a['beban_user_id'];
                        //$cb=$a['created_by'];
                ?>
                    <tr>
                        <td style="text-align:center;"><?php echo $no;?></td>
                        <td><?php echo $tgl;?></td>
                        <td><?php echo $nm;?></td>
                        <td style="text-align:right;"><?php echo number_format($jml,0, ',' ,'.');?></td>
                        <td><?php echo $katnama;?></td>
                        <!-- <td style="text-align:center;"> -->
                        <?php    
                        // if ($usid==$uid) { // digunakan untuk user yg berbeda di cabang
                        //     echo '<a class="btn btn-xs btn-warning" href="#modalEdit'.$id.'" data-toggle="modal" title="Edit"><span class="fa fa-edit"></span> Edit</a> ';
                        //     echo '<a class="btn btn-xs btn-danger" href="#modalHapus'.$id.'" data-toggle="modal" title="Hapus"><span class="fa fa-close"></span> Hapus</a>';
                        // }
                        ?>
                        <!-- <a class="btn btn-xs btn-warning" href="#modalEdit<?php echo $id?>" data-toggle="modal" title="Edit"><span class="fa fa-edit"></span> Edit</a>
                        <a class="btn btn-xs btn-danger" href="#modalHapus<?php echo $id?>" data-toggle="modal" title="Hapus"><span class="fa fa-close"></span> Hapus</a> -->
                        <!-- </td> -->
                    </tr>
                <?php endforeach;?>
                </tbody>
            </table>
            </div>
        </div>
        <!-- /.row -->
        <!-- ============ MODAL ADD =============== -->
        <div class="modal fade" id="modalAdd" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 class="modal-title" id="myModalLabel"><small>Tambah Pengeluaran / Beban Operasional</small></h3>
            </div>
            <form class="form-horizontal" method="post" action="<?php echo base_url().'admin/beban/tambah_beban'?>">
                <div class="modal-body">

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
                            <input name="jml" class="form-control jml" class="form-control" type="text" placeholder="Ketikan angka..." style="text-align:right;width:150px;" required>
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
        <?php
                    foreach ($data->result_array() as $a) {
                        $id=$a['beban_id'];
                        $nm=$a['beban_nama'];
                        $jml=$a['beban_jumlah'];
                        $kat_id=$a['beban_kat_id'];
                    ?>
                <div id="modalEdit<?php echo $id?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
                    <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h3 class="modal-title" id="myModalLabel"><small>Edit Pengeluaran / Beban Operasional</small></h3>
                    </div>
                    <form class="form-horizontal" method="post" action="<?php echo base_url().'admin/beban/edit_beban'?>">
                        <div class="modal-body">
                            <input name="kode" type="hidden" value="<?php echo $id;?>">

                    <div class="form-group">
                        <label class="control-label col-xs-3" style="font-size:12px;">Nama Pengeluaran</label>
                        <div class="col-xs-9">
                            <input name="nama" class="form-control" type="text" placeholder="Nama Beban..." value="<?php echo $nm;?>" style="width:400px;" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-3" style="font-size:12px;">Jenis Pengeluaran</label>
                        <div class="col-xs-6">
                            <select name="katidEdit" id="katidEdit" class="selectpicker show-tick form-control" title="Jenis Pengeluaran" style="width:200px;" placeholder="Jenis Pengeluaran" required>
                            <?php
                                foreach ($beban->result_array() as $b) {
                                    $kid = $b['kat_id'];
                                    $knm = $b['kat_nama'];
                                    if ($kid==$kat_id) {
                                        echo "<option value='$kid' selected>$knm</option>";
                                    } else {
                                        echo "<option value='$kid'>$knm</option>";
                                    }
                                }  
                            echo '</select>';
                            ?>   
                        </div>
                    </div>

                    <div class="form-group" id="pilihrekEdit" style="display:none;">
                        <label class="control-label col-xs-3" style="font-size:12px;">Pilih Rekening </label>
                        <div class="col-xs-9">
                            <select name="rekEdit" id="rekEdit" class="selectpicker show-tick form-control" title="Pilih No Rekening" data-width="95%" placeholder="Pilih No Rekening">
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
                        <div class="col-xs-6">
                            <input name="jml" class="form-control jml" type="text" placeholder="Ketikan angka..." value="<?php echo number_format($jml,0, ',' ,'.'); ?>" style="text-align:right;width:150px;" required>
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
            <?php
        }
        ?>

        <!-- ============ MODAL HAPUS =============== -->
        <?php
                    foreach ($data->result_array() as $a) {
                        $id=$a['beban_id'];
                        $nm=$a['beban_nama'];
                        $jml=$a['beban_jumlah'];
                    ?>
                <div id="modalHapus<?php echo $id?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
                    <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h3 class="modal-title" id="myModalLabel"><small>Hapus Pengeluaran / Beban Operasional</small></h3>
                    </div>
                    <form class="form-horizontal" method="post" action="<?php echo base_url().'admin/beban/hapus_beban'?>">
                        <div class="modal-body">
                            <p>Yakin mau menghapus data ..<?php echo $nm;?> ?...</p>
                                    <input name="kode" type="hidden" value="<?php echo $id; ?>">
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Hapus</button>
                            <button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
                        </div>
                    </form>
                </div>
                </div>
                </div>
            <?php
        }
        ?>

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
    <script type="text/javascript">
        $(document).ready(function() {
            $('#mydata').DataTable();
        } );
    </script>

    <script type="text/javascript">
    $(document).on('input', 'input[name^="jml"]', function(e) {
        var inputValue = e.target.value;
        var sanitizedValue = inputValue.replace(/[^0-9\b\t]/g, ''); // Hapus karakter yang tidak diizinkan (selain angka, koma, backspace, delete, dan tab)
        e.target.value = sanitizedValue; // Update nilai input dengan karakter yang diizinkan
    });

    $('.jml').on("blur", function() { 
    var jumuang = parseFloat($(this).val().replace(/[^\d,]/g, '')) || 0;
    var formattedJumuang = jumuang.toLocaleString('id-ID');
    $(this).val(formattedJumuang);
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

<!-- <script type="text/javascript"> 
    $('select[name="katidEdit"]').on('change', function() {
        const cbEdit = $(this).find('option:selected').text();
        //console.log(cbEdit);
        //harus menggunakan $(this).closest('form').find dikarenakan berada di modal dan mengalami pengulangan for each
        if (cbEdit === "Transfer") {
            $(this).closest('form').find('#pilihrekEdit').show();
            $(this).closest('form').find('#rekEdit').selectpicker('val', '');
            $(this).closest('form').find('#rekEdit').selectpicker('refresh');
            $(this).closest('form').find('#rekEdit').prop('required', true);
        } else {
            $(this).closest('form').find('#pilihrekEdit').hide();
            $(this).closest('form').find('#rekEdit').selectpicker('val', '');
            $(this).closest('form').find('#rekEdit').selectpicker('refresh');
            $(this).closest('form').find('#rekEdit').removeAttr('required');
        }
    });
</script> -->
  
</body>

</html>
