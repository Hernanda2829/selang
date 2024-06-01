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

    <title>Data Suplier</title>
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
                <h1 class="page-header">Data
                    <small>Suplier</small>
                    <div class="pull-right"><a href="#" class="btn btn-sm btn-success" data-toggle="modal" data-target="#largeModal"><span class="fa fa-plus"></span> Tambah Suplier</a></div>
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
                        <th style="text-align:center;width:5%;">No</th>
                        <th style="text-align:center;width:25%;">Nama Suplier</th>
                        <th style="text-align:center;width:30%;">Alamat</th>
                        <th style="text-align:center;width:15%;">No Telp/HP</th>
                        <th style="text-align:center;width:20%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                    $no=0;
                    foreach ($data->result_array() as $a):
                        $no++;
                        $id=$a['suplier_id'];
                        $nm=$a['suplier_nama'];
                        $alamat=$a['suplier_alamat'];
                        $notelp=$a['suplier_notelp'];
                ?>
                    <tr>
                        <td style="text-align:center;"><?php echo $no;?></td>
                        <td><?php echo $nm;?></td>
                        <td><?php echo $alamat;?></td>
                        <td><?php echo $notelp;?></td>
                        <td style="text-align:center;">
                            <a class="btn btn-xs btn-warning" href="#modalEditPelanggan<?php echo $id?>" data-toggle="modal" title="Edit"><span class="fa fa-edit"></span> Edit</a>
                            <a class="btn btn-xs btn-danger" href="#modalHapusPelanggan<?php echo $id?>" data-toggle="modal" title="Hapus"><span class="fa fa-close"></span> Hapus</a>
                            <a href="#modalCetak" data-toggle="modal" class="btn btn-warning btn-xs btn-cetak" data-idsup="<?php echo $id?>" data-nmsup="<?php echo $nm?>" data-alsup="<?php echo $alamat?>" data-notelp="<?php echo $notelp?>" title="Cetak Alamat Suplier"><span class="fa fa-print"></span> Cetak</a></td>
                        </td>
                    </tr>
                <?php endforeach;?>
                </tbody>
            </table>
            </div>
        </div>
        <!-- /.row -->

        <!-- ============ MODAL Setting Cetak =============== -->
        <div id="modalCetak" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 class="modal-title" id="myModalLabel"><small>Cetak Alamat Suplier</small></h3>
        </div>
        <form id="cetakForm" class="form-horizontal" method="post" action="<?php echo base_url().'admin/suplier/cetak_alamat';?>">
            <div class="modal-body" style="overflow:scroll;">
            <input type="hidden" id="txtidsup" name="txtidsup" class="form-control input-sm" style="width:400px; margin-right: 10px;" readonly>
                <table class="table table-bordered table-condensed" style="font-size: 11px;">
                    <tr>
                        <th style="width: 150px; padding-bottom: 5px; vertical-align: middle;">Nama Suplier : </th>
                        <td><input type="text" id="txtnmsup" name="txtnmsup" class="form-control input-sm" style="width:400px; margin-right: 10px;" readonly></td>
                    </tr>
                    <tr>
                        <th style="width: 150px; padding-bottom: 5px; vertical-align: middle;">Alamat : </th>
                        <td><input type="text" id="txtalsup" name="txtalsup" class="form-control input-sm" style="width:400px; margin-right: 10px;" readonly></td>
                    </tr>
                    <tr>
                        <th style="width: 150px; padding-bottom: 5px; vertical-align: middle;">No Telpon : </th>
                        <td><input type="text" id="txtnotelp" name="txtnotelp" class="form-control input-sm" style="width:400px; margin-right: 10px;" readonly></td>
                    </tr>
                    <tr>
                        <th style="width: 150px; padding-bottom: 5px; vertical-align: middle;">Pilih Jumlah Kolom : </th>
                        <td>
                            <select name="kolom" style="width: 100px; margin-right: 5px;" class="form-control input-sm" required>
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th style="width:150px;padding-bottom:5px;vertical-align:middle;">Pilih Jumlah Baris : </th>
                        <td>
                            <select name="baris" style="width: 100px; margin-right: 5px;" class="form-control input-sm" required>
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
                            </select>
                        </td>
                    </tr>
                </table>
            <hr/>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-info" onclick="setTargetBlank()">Tampil</button>
                <button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
            </div>
        </form>
        </div>
        </div>
        </div> 

        <!-- ============ MODAL ADD =============== -->
        <div class="modal fade" id="largeModal" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 class="modal-title" id="myModalLabel">Tambah Suplier</h3>
            </div>
            <form class="form-horizontal" method="post" action="<?php echo base_url().'admin/suplier/tambah_suplier'?>">
                <div class="modal-body">

                    <div class="form-group">
                        <label class="control-label col-xs-3" >Nama Suplier</label>
                        <div class="col-xs-9">
                            <input name="nama" class="form-control" type="text" placeholder="Nama Suplier..." style="width:280px;" required>
                        </div>
                    </div>
                        
                    <div class="form-group">
                        <label class="control-label col-xs-3" >Alamat</label>
                        <div class="col-xs-9">
                            <input name="alamat" class="form-control" type="text" placeholder="Alamat..." style="width:280px;" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3" >No Telp/ HP</label>
                        <div class="col-xs-9">
                            <input name="notelp" class="form-control" type="text" placeholder="No Telp/HP..." style="width:280px;" required>
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
                        $id=$a['suplier_id'];
                        $nm=$a['suplier_nama'];
                        $alamat=$a['suplier_alamat'];
                        $notelp=$a['suplier_notelp'];
                    ?>
                <div id="modalEditPelanggan<?php echo $id?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
                    <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h3 class="modal-title" id="myModalLabel">Edit Suplier</h3>
                    </div>
                    <form class="form-horizontal" method="post" action="<?php echo base_url().'admin/suplier/edit_suplier'?>">
                        <div class="modal-body">
                            <input name="kode" type="hidden" value="<?php echo $id;?>">

                    <div class="form-group">
                        <label class="control-label col-xs-3" >Nama Suplier</label>
                        <div class="col-xs-9">
                            <input name="nama" class="form-control" type="text" placeholder="Nama Suplier..." value="<?php echo $nm;?>" style="width:280px;" required>
                        </div>
                    </div>
                        
                    <div class="form-group">
                        <label class="control-label col-xs-3" >Alamat</label>
                        <div class="col-xs-9">
                            <input name="alamat" class="form-control" type="text" placeholder="Alamat..." value="<?php echo $alamat;?>" style="width:280px;" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3" >No Telp/ HP</label>
                        <div class="col-xs-9">
                            <input name="notelp" class="form-control" type="text" placeholder="No Telp/HP..." value="<?php echo $notelp;?>" style="width:280px;" required>
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
                        $id=$a['suplier_id'];
                        $nm=$a['suplier_nama'];
                        $alamat=$a['suplier_alamat'];
                        $notelp=$a['suplier_notelp'];
                    ?>
                <div id="modalHapusPelanggan<?php echo $id?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
                    <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h3 class="modal-title" id="myModalLabel">Hapus Suplier</h3>
                    </div>
                    <form class="form-horizontal" method="post" action="<?php echo base_url().'admin/suplier/hapus_suplier'?>">
                        <div class="modal-body">
                            <p>Yakin mau menghapus data..?</p>
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
    
    <script>
    // Fungsi untuk mengatur target="_blank" setelah formulir dikirim
    function setTargetBlank() {
        document.getElementById("cetakForm").target = "_blank";
    }

    $(document).on('click', '.btn-cetak', function () {
        $('#txtidsup').val('');
        $('#txtnmsup').val('');
        $('#txtalsup').val('');
        $('#txtnotelp').val('');
        var idsup = $(this).data('idsup');
        var nmsup = $(this).data('nmsup');
        var alsup = $(this).data('alsup');
        var notelp = $(this).data('notelp');
        $('#txtidsup').val(idsup);
        $('#txtnmsup').val(nmsup);
        $('#txtalsup').val(alsup);
        $('#txtnotelp').val(notelp);
        $('#modalCetak').modal('show');
    });
    </script>

</body>

</html>
