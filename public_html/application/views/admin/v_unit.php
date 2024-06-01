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

    <title>Unit/Satuan</title>
    <link rel="shortcut icon" href="<?php echo base_url().'assets/img/'. $userid['co_imgicon']; ?>" alt="#no image#" type="image/x-icon">
    <!-- Bootstrap Core CSS -->
    <link href="<?php echo base_url().'assets/css/bootstrap.min.css'?>" rel="stylesheet">
	<link href="<?php echo base_url().'assets/css/style.css'?>" rel="stylesheet">
	<link href="<?php echo base_url().'assets/css/font-awesome.css'?>" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?php echo base_url().'assets/css/4-col-portfolio.css'?>" rel="stylesheet">
    <link href="<?php echo base_url().'assets/css/dataTables.bootstrap.min.css'?>" rel="stylesheet">
    <link href="<?php echo base_url().'assets/css/jquery.dataTables.min.css'?>" rel="stylesheet">

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
                <h1 class="page-header">Setting Unit
                    <small>/Satuan</small>
                    <div class="pull-right"><a href="#" class="btn btn-sm btn-success" data-toggle="modal" data-target="#largeModal"><span class="fa fa-plus"></span> Tambah Unit/Satuan</a></div>
                </h1>
            </div>
        </div>
        <br>
        <!-- /.row -->
        <!-- Projects Row -->
        <div class="row">
            <div class="col-lg-12">
            <table class="table table-bordered table-condensed" style="font-size:11px;" id="mydata">
                <thead>
                    <tr>
                        <th style="text-align:center;width:40px;">No</th>
                        <th style="text-align:center;">Nama Unit</th>
                        <th style="text-align:center;">Nama Ringkas/Singkat</th>
                        <th style="width:140px;text-align:center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                    $no=0;
                    foreach ($data->result_array() as $a):
                        $no++;
                        $id=$a['units_id'];
                        $nm=$a['units_name'];
                        $s_nm=$a['short_name'];
                ?>
                    <tr>
                        <td style="text-align:center;"><?php echo $no;?></td>
                        <td><?php echo $nm;?></td>
                        <td><?php echo $s_nm;?></td>
                        <td style="text-align:center;">
                        <a class="btn btn-xs btn-warning" href="#modalEdit<?php echo $id?>" data-toggle="modal" title="Edit"><span class="fa fa-edit"></span> Edit</a>
                        <a class="btn btn-xs btn-danger" href="#modalHapus<?php echo $id?>" data-toggle="modal" title="Hapus"><span class="fa fa-close"></span> Hapus</a> 
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
                <h3 class="modal-title" id="myModalLabel">Tambah Unit/Satuan</h3>
            </div>
            <form class="form-horizontal" method="post" action="<?php echo base_url().'admin/unit/tambah_unit'?>">
                <div class="modal-body">

                    <div class="form-group">
                        <label class="control-label col-xs-4" >Nama Unit/Satuan</label>
                        <div class="col-xs-7">
                            <input name="nama" class="form-control" type="text" placeholder="Nama Unit..." style="width:200px;" maxlength="30" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-4" >Nama Ringkas/Singkat</label>
                        <div class="col-xs-7">
                            <input name="shortnama" class="form-control" type="text" placeholder="Nama Singkat Unit..." style="width:200px;" maxlength="10" required>
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
                        $id=$a['units_id'];
                        $nm=$a['units_name'];
                        $s_nm=$a['short_name'];
                    ?>
                <div id="modalEdit<?php echo $id?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
                    <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h3 class="modal-title" id="myModalLabel">Edit Unit/Satuan</h3>
                    </div>
                    <form class="form-horizontal" method="post" action="<?php echo base_url().'admin/unit/edit_unit'?>">
                        <div class="modal-body">
                            <input name="kode" type="hidden" value="<?php echo $id;?>">

                    <div class="form-group">
                        <label class="control-label col-xs-4" >Nama Unit</label>
                        <div class="col-xs-7">
                            <input name="nama" class="form-control" type="text" placeholder="Nama Unit..." value="<?php echo $nm;?>" style="width:200px;" maxlength="30" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-4" >Nama Ringkas/Singkat</label>
                        <div class="col-xs-7">
                            <input name="shortnama" class="form-control" type="text" placeholder="Nama Singkat Unit..." value="<?php echo $s_nm;?>" style="width:200px;" maxlength="10" required>
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
                        $id=$a['units_id'];
                        $nm=$a['units_name'];
                        $s_nm=$a['short_name'];
                    ?>
                <div id="modalHapus<?php echo $id?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
                    <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h3 class="modal-title" id="myModalLabel">Hapus Unit</h3>
                    </div>
                    <form class="form-horizontal" method="post" action="<?php echo base_url().'admin/unit/hapus_unit'?>">
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
    <script src="<?php echo base_url().'assets/js/bootstrap.min.js'?>"></script>
    <script src="<?php echo base_url().'assets/js/jquery.dataTables.min.js'?>"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#mydata').DataTable();
        } );
    </script>

    <script type="text/javascript">
        $(document).on('input', 'input[name^="nama"]', function(e) {
            var inputValue = e.target.value; 
            var sanitizedValue = inputValue.replace(/[^0-9A-Za-z]/g, '');
            e.target.value = sanitizedValue; 
        });
        $(document).on('input', 'input[name^="shortnama"]', function(e) {
            var inputValue = e.target.value; 
            var sanitizedValue = inputValue.replace(/[^0-9A-Za-z]/g, '');
            e.target.value = sanitizedValue; 
        });
    </script>    

</body>
</html>
