<!DOCTYPE html>
<html lang="en">

<head>
    <?php 
	error_reporting(0);
    $userid=$userid->row_array();
    ?>  
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Produk <?php echo $userid['co_name'];?>">
    <meta name="author" content="<?php echo $userid['co_name'];?>">

    <title>Management User</title>
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
            <center><?php echo $this->session->flashdata('msg');?></center>
                <h1 class="page-header">Data
                    <small>Pengguna</small>
                    <div class="pull-right"><a href="#" class="btn btn-sm btn-success" data-toggle="modal" data-target="#largeModal"><span class="fa fa-plus"></span> Tambah Pengguna</a></div>
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
                        <th style="text-align:center;width:40px;">No</th>
                        <th>Nama</th>
                        <th>Username</th>
                        <th>Bagian Pekerjaan</th>
                        <th>Level</th>
                        <th>Status</th>
                        <th>Cabang</th>
                        <th>Perusahaan</th>
                        <th style="width:140px;text-align:center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                    $no=0;
                    foreach ($data->result_array() as $a):
                        $no++;
                        $id=$a['user_id'];
                        $nm=$a['user_nama'];
                        $username=$a['user_username'];
                        $usertitle=$a['user_title'];
                        $level=$a['user_level'];
                        $level_nama=$a['level_nama'];
                        $status=$a['user_status'];
                        if(!empty($status) && ($status==1)){
                            $sts_user="Aktif";
                        }else{
                            $sts_user="Non Aktif";
                        }
                        $regname=$a['reg_name'];
                        $coname=$a['co_name'];
                ?>
                    <tr>
                        <td style="text-align:center;"><?php echo $no;?></td>
                        <td><?php echo $nm;?></td>
                        <td><?php echo $username;?></td>
                        <td><?php echo $usertitle;?></td>
                        <td><?php echo $level_nama;?></td>
                        <td><?php echo $sts_user;?></td>
                        <td><?php echo $regname;?></td>
                        <td><?php echo $coname;?></td>
                        <td style="text-align:center;">
                            <a class="btn btn-xs btn-warning" href="#modalEditPengguna<?php echo $id?>" data-toggle="modal" title="Edit"><span class="fa fa-edit"></span> Edit</a>
                            <?php if(!empty($status) && ($status==1)){
                                echo '<a class="btn btn-xs btn-danger" href="#modalNonAktifkan'.$id.'" data-toggle="modal" title="Hapus"><span class="fa fa-close"></span> Nonaktifkan</a>';
                            }else{
                                echo '<a class="btn btn-xs btn-danger" href="#modalAktifkan'.$id.'" data-toggle="modal" title="Hapus"><span class="fa fa-close"></span> AktifkanLagi </a>';
                            }
                            ?>
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
                <h3 class="modal-title" id="myModalLabel">Tambah Pengguna</h3>
            </div>
            <form class="form-horizontal" method="post" action="<?php echo base_url().'admin/pengguna/tambah_pengguna'?>">
                <div class="modal-body">

                    <div class="form-group">
                        <label class="control-label col-xs-4" >Nama </label>
                        <div class="col-xs-8">
                            <input name="nama" class="form-control" type="text" placeholder="Input Nama..." style="width:280px;" maxlength="35" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-4" >Username (Login)</label>
                        <div class="col-xs-8">
                            <input name="username" class="form-control" type="text" placeholder="Input Username..." style="width:280px;" maxlength="30" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-4" >Bagian Pekerjaan</label>
                        <div class="col-xs-8">
                            <input name="usertitle" class="form-control" type="text" placeholder="Input Jabatan/Pekerjaan..." style="width:280px;" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-4" >Password</label>
                        <div class="col-xs-8">
                            <input name="password" class="form-control" type="password" placeholder="Input Password..." style="width:280px;" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-4" >Ulangi Password</label>
                        <div class="col-xs-8">
                            <input name="password2" class="form-control" type="password" placeholder="Ulangi Password..." style="width:280px;" required>
                        </div>
                    </div> 
                    <div class="form-group">
                    <label class="control-label col-xs-4" >Level</label>
                    <div class="col-xs-8">
                        <select name="level" class="selectpicker show-tick form-control" data-live-search="true" title="Pilih Level" data-width="50%" placeholder="Pilih Level" required>
                        <?php foreach ($user_level->result_array() as $ul) {
                            $lv_id=$ul['level_id'];
                            $lv_nama=$ul['level_nama'];
                            ?>
                                <option value="<?php echo $lv_id;?>"><?php echo $lv_nama;?></option>
                           <?php }?>
                        </select>
                    </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-4" >Cabang</label>
                        <div class="col-xs-8">
                            <select name="regions" class="selectpicker show-tick form-control" data-live-search="true" title="Pilih cabang" data-width="50%" placeholder="Pilih Cabang" required>
                            <?php foreach ($regions->result_array() as $rg) {
                                $reg_id=$rg['reg_id'];
                                $reg_name=$rg['reg_name'];
                                ?>
                                    <option value="<?php echo $reg_id;?>"><?php echo $reg_name;?></option>
                            <?php }?>
                            </select>
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
            $id=$a['user_id'];
            $nm=$a['user_nama'];
            $username=$a['user_username'];
            $level=$a['user_level'];
            $status=$a['user_status'];
            $usertitle=$a['user_title'];
            $regid=$a['reg_id'];
            $coid=$a['co_id'];
            
                        
        ?>
        <div id="modalEditPengguna<?php echo $id?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 class="modal-title" id="myModalLabel">Edit Pengguna</h3>
            </div>
            <form class="form-horizontal" method="post" action="<?php echo base_url().'admin/pengguna/edit_pengguna'?>">
            <div class="modal-body">
                <input name="kode" type="hidden" value="<?php echo $id;?>">

                <div class="form-group">
                    <label class="control-label col-xs-4" >Nama Pendek</label>
                    <div class="col-xs-8">
                        <input name="nama" class="form-control" type="text" value="<?php echo $nm;?>" placeholder="Input Nama..." style="width:280px;" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-xs-4" >Username (Login)</label>
                    <div class="col-xs-8">
                        <input name="username" class="form-control" type="text" value="<?php echo $username;?>" placeholder="Input Username..." style="width:280px;" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-xs-4" >Bagian Pekerjaan</label>
                    <div class="col-xs-8">
                        <input name="usertitle" class="form-control" type="text" value="<?php echo $usertitle;?>" placeholder="Input Username..." style="width:280px;" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-xs-4" >Level</label>
                    <div class="col-xs-8">
                        <select name="level" class="selectpicker show-tick form-control" data-live-search="true" title="Pilih Level" data-width="50%" placeholder="Pilih Level" required>
                        <?php foreach ($user_level->result_array() as $ul) {
                            $lv_id=$ul['level_id'];
                            $lv_nama=$ul['level_nama'];
                            if($lv_id==$level) {
                                echo "<option value='$lv_id' selected>$lv_nama</option>";
                            }else{
                                echo "<option value='$lv_id'>$lv_nama</option>";
                            }
                        }
                        ?>  
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-xs-4" >Cabang</label>
                    <div class="col-xs-8">
                        <select name="regions" class="selectpicker show-tick form-control" data-live-search="true" title="Pilih cabang" data-width="50%" placeholder="Pilih Cabang" required>
                        <?php foreach ($regions->result_array() as $rg) {
                            $reg_id=$rg['reg_id'];
                            $reg_name=$rg['reg_name'];
                            if($reg_id==$regid) {
                                echo "<option value='$reg_id' selected>$reg_name</option>";
                            }else{
                                echo "<option value='$reg_id'>$reg_name</option>";
                            }
                        }
                        ?>  
                        </select>
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

        <!-- ============ MODAL NonAktifkan =============== -->
        <?php
        foreach ($data->result_array() as $a) {
            $id=$a['user_id'];
            $nm=$a['user_nama'];
        ?>
            <div id="modalNonAktifkan<?php echo $id?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
                <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3 class="modal-title" id="myModalLabel">NonAktifkan Pengguna</h3>
                </div>
                <form class="form-horizontal" method="post" action="<?php echo base_url().'admin/pengguna/nonaktifkan'?>">
                    <div class="modal-body">
                        <p>Yakin mau menonaktifkan pengguna <b><?php echo $nm;?></b>..?</p>
                                <input name="kode" type="hidden" value="<?php echo $id; ?>">
                    </div>
                    <div class="modal-footer">
                        <button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
                        <button type="submit" class="btn btn-primary">Nonaktifkan</button>
                    </div>
                </form>
            </div>
            </div>
            </div>
            <?php
        }
        ?>
        <!-- ============ MODAL Aktifkan =============== -->
        <?php
        foreach ($data->result_array() as $a) {
            $id=$a['user_id'];
            $nm=$a['user_nama'];
        ?>
            <div id="modalAktifkan<?php echo $id?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
                <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3 class="modal-title" id="myModalLabel">Aktifkan Kembali Pengguna</h3>
                </div>
                <form class="form-horizontal" method="post" action="<?php echo base_url().'admin/pengguna/aktifkan'?>">
                    <div class="modal-body">
                        <p>Yakin mau mengaktifkan kembali pengguna <b><?php echo $nm;?></b>..?</p>
                                <input name="kode" type="hidden" value="<?php echo $id; ?>">
                    </div>
                    <div class="modal-footer">
                        <button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
                        <button type="submit" class="btn btn-primary">Aktifkan</button>
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
    
</body>

</html>
