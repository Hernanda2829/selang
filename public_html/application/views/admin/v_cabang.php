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

    <title>Setting Kantor Cabang</title>
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
                <h1 class="page-header">Data Kantor
                    <small>Cabang</small>
                    <div class="pull-right">
                        <a href="#modalProfile" class="btn btn-sm btn-info btn-editprofile" data-toggle="modal" data-coid="<?php echo $userid['co_id'];?>"><span class="fa fa-edit"></span> Company Profile</a>
                        <a href="#" class="btn btn-sm btn-success" data-toggle="modal" data-target="#largeModal"><span class="fa fa-plus"></span> Tambah Kantor Cabang</a>
                    </div>
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
                        <th>Nama Kode</th>
                        <th>Nama Cabang</th>
                        <th>Keterangan</th>
                        <th>Kode Singkatan</th>
                        <th>Perusahaan</th>
                        <th style="width:140px;text-align:center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                    $no=0;
                    foreach ($data->result_array() as $a):
                        $no++;
                        $id=$a['reg_id'];
                        $nmkd=$a['reg_code'];
                        $nm=$a['reg_name'];
                        $ket=$a['reg_desc'];
                        $nicknm=$a['nick_name'];
                        $rgcd=$a['co_name'];                
                ?>
                    <tr>
                        <td style="text-align:center;"><?php echo $no;?></td>
                        <td><?php echo $nmkd;?></td>
                        <td><?php echo $nm;?></td>
                        <td><?php echo $ket;?></td>
                        <td><?php echo $nicknm;?></td>
                        <td><?php echo $rgcd;?></td>
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
                <h3 class="modal-title" id="myModalLabel">Tambah Kantor Cabang</h3>
            </div>
            <form class="form-horizontal" method="post" action="<?php echo base_url().'admin/cabang/tambah_cabang'?>">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="control-label col-xs-4" >Nama Kode</label>
                        <div class="col-xs-8">
                            <input name="nama_kode" class="form-control" type="text" placeholder="Input Kode Cabang" style="width:280px;" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-4" >Nama Cabang</label>
                        <div class="col-xs-8">
                            <input name="nama" class="form-control" type="text" placeholder="Input Nama Cabang" style="width:280px;" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-4" >Keterangan</label>
                        <div class="col-xs-8">
                            <input name="deskripsi" class="form-control" type="text" placeholder="Input Deskripsi" style="width:280px;" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-4" >Kode Singkatan</label>
                        <div class="col-xs-8">
                            <input name="nickname" class="form-control" type="text" placeholder="Input Nick Name" style="width:280px;" required>
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
            $id=$a['reg_id'];
            $nmkd=$a['reg_code'];
            $nm=$a['reg_name'];
            $ket=$a['reg_desc'];
            $nicknm=$a['nick_name'];
            $rgcd=$a['co_name'];    
            
                        
        ?>
        <div id="modalEdit<?php echo $id?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 class="modal-title" id="myModalLabel">Edit Kantor Cabang</h3>
            </div>
            <form class="form-horizontal" method="post" action="<?php echo base_url().'admin/cabang/edit_cabang'?>">
            <div class="modal-body">
                <input name="kode" type="hidden" value="<?php echo $id;?>">

                <div class="form-group">
                    <label class="control-label col-xs-4" >Nama Kode</label>
                    <div class="col-xs-8">
                        <input name="nama_kode" class="form-control" type="text" value="<?php echo $nmkd;?>" placeholder="Input Kode Cabang" style="width:280px;" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-xs-4" >Nama Cabang</label>
                    <div class="col-xs-8">
                        <input name="nama" class="form-control" type="text" value="<?php echo $nm;?>" placeholder="Input Nama Cabang" style="width:280px;" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-xs-4" >Keterangan</label>
                    <div class="col-xs-8">
                        <input name="deskripsi" class="form-control" type="text" value="<?php echo $ket;?>" placeholder="Input Deskripsi" style="width:280px;" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-xs-4" >Kode Singkatan</label>
                    <div class="col-xs-8">
                        <input name="nickname" class="form-control" type="text" value="<?php echo $nicknm;?>" placeholder="Input Nick Nname" style="width:280px;" required>
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
                $id=$a['reg_id'];
                $nmkd=$a['reg_code'];
                $nm=$a['reg_name'];
        ?>
                <div id="modalHapus<?php echo $id?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
                    <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h3 class="modal-title" id="myModalLabel">Hapus Cabang</h3>
                    </div>
                    <form class="form-horizontal" method="post" action="<?php echo base_url().'admin/cabang/hapus_cabang'?>">
                        <div class="modal-body">
                            <p>Yakin mau menghapus data..<?php echo $nmkd; ?> <?php echo $nm; ?> ? ...</p>
                                    <input name="kode" type="hidden" value="<?php echo $id; ?>">
                        </div>
                        <div class="modal-footer">
                            <button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
                            <button type="submit" class="btn btn-primary">Hapus</button>
                        </div>
                    </form>
                </div>
                </div>
                </div>
            <?php
        }
        ?>

        <!-- ============ MODAL Company Profile =============== -->
        <div id="modalProfile" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 class="modal-title" id="myModalLabel">Company Profile</h3>
            </div>
            <form class="form-horizontal" method="post" action="<?php echo base_url().'admin/cabang/edit_company'?>" enctype="multipart/form-data">
            <div class="modal-body">
                <input name="txtcoid" id="txtcoid" type="hidden">
                <table id="tbl_profile" class="table table-bordered table-condensed" style="font-size:11px;">
                
                <tr>
                    <th style="width:150px;padding-bottom:5px;vertical-align:middle;">Nama Perusahaan</th>
                    <td><input type="text" name="coname" id="coname" class="form-control input-sm" style="width:400px;" required></td>
                </tr>
                <tr>
                    <th style="width:150px;padding-bottom:5px;vertical-align:middle;">Alamat Perusahaan</th>
                    <td><input type="text" name="coaddress" id="coaddress" class="form-control input-sm" style="width:400px;" required></td>
                </tr>
                <tr>
                    <th style="width:150px;padding-bottom:5px;vertical-align:middle;">No Telpon</th>
                    <td><input type="text" name="cophone" id="cophone" class="form-control input-sm" style="width:400px;" required></td>
                </tr>
                <tr>
                    <th style="width:150px;padding-bottom:5px;vertical-align:middle;">Website Perusahaan</th>
                    <td><input type="text" name="cowebsite" id="cowebsite" class="form-control input-sm" style="width:400px;" required></td>
                </tr>
                <tr>
                    <th style="width:150px;padding-bottom:5px;vertical-align:middle;">Email Perusahaan</th>
                    <td><input type="text" name="coemail" id="coemail" class="form-control input-sm" style="width:400px;" required></td>
                </tr>
                <tr>
                    <th style="width:150px;padding-bottom:5px;vertical-align:middle;">Moto Perusahaan</th>
                    <td><input type="text" name="comoto" id="comoto" class="form-control input-sm" style="width:400px;" required></td>
                </tr>
                <tr>
                    <th style="width:150px;padding-bottom:5px;vertical-align:middle;">Icon Logo</th>
                    <td>
                        <div style="display: flex; align-items: center;">
                            <input type="text" name="coimgicon" id="coimgicon" class="form-control input-sm" style="width:300px;" readonly>
                            <input type="hidden" name="coimgicon2" id="coimgicon2" class="form-control input-sm" style="width:100px;">
                            <label class="btn btn-sm btn-success btn-file" style="margin-left: 20px;">
                                <i class="fa fa-upload"></i> Browse
                                <input type="file" name="logo1" id="logo1" style="display:none;" accept="image/*">
                            </label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th style="width:150px;padding-bottom:5px;vertical-align:middle;">Logo Pencetakan</th>
                    <td>
                        <div style="display: flex; align-items: center;">
                            <input type="text" name="coimglogo" id="coimglogo" class="form-control input-sm" style="width:300px;" readonly>
                            <input type="hidden" name="coimglogo2" id="coimglogo2" class="form-control input-sm" style="width:100px;">
                            <label class="btn btn-sm btn-success btn-file" style="margin-left: 20px;">
                                <i class="fa fa-upload"></i> Browse
                                <input type="file" name="logo2" id="logo2" style="display:none;" accept="image/*">
                            </label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th style="width:150px;padding-bottom:5px;vertical-align:middle;">Background Menu</th>
                    <td>
                        <div style="display: flex; align-items: center;">
                            <input type="text" name="coimgbg" id="coimgbg" class="form-control input-sm" style="width:300px;" readonly>
                            <input type="hidden" name="coimgbg2" id="coimgbg2" class="form-control input-sm" style="width:100px;">
                            <label class="btn btn-sm btn-success btn-file" style="margin-left: 20px;">
                                <i class="fa fa-upload"></i> Browse
                                <input type="file" name="logo3" id="logo3" style="display:none;" accept="image/*">
                            </label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th style="width:150px;padding-bottom:5px;vertical-align:middle;">Copyright</th>
                    <td><input type="text" name="cocopyright" id="cocopyright" class="form-control input-sm" style="width:400px;" required></td>
                </tr>
                <tr>
                    <th style="width:150px;padding-bottom:5px;vertical-align:middle;">Rekening_1 Perusahaan</th>
                    <td><input type="text" name="coreka" id="coreka" class="form-control input-sm" style="width:400px;" required></td>
                </tr>
                <tr>
                    <th style="width:150px;padding-bottom:5px;vertical-align:middle;">Rekening_2 Perusahaan</th>
                    <td><input type="text" name="corekb" id="corekb" class="form-control input-sm" style="width:400px;" required></td>
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
    <script type="text/javascript">
        $(document).ready(function() {
            $('#mydata').DataTable();
        } );
    </script>


<script>
    $('#logo1').change(function() {
        var fileName = $(this).val().split("\\").pop();
        $('#coimgicon').val(fileName);
    });
    $('#logo2').change(function() {
        var fileName = $(this).val().split("\\").pop();
        $('#coimglogo').val(fileName);
    });
    $('#logo3').change(function() {
        var fileName = $(this).val().split("\\").pop();
        $('#coimgbg').val(fileName);
    });
</script>

<script>
$(document).on('click', '.btn-editprofile', function () {
    var coid = $(this).data('coid');
    $.ajax({
        type: "POST",
        url: "<?php echo base_url().'admin/cabang/get_company';?>",
        data: { coid: coid },
        dataType: 'json',
        success: function (data) {
            //console.log("Data from server:", data);
            if (data.length !== 0) {
                // Setel nilai elemen-elemen dengan data dari server
                $('#txtcoid').val(data.co_id);
                $('#coname').val(data.co_name);
                $('#coaddress').val(data.co_address);
                $('#cophone').val(data.co_phone);
                $('#cowebsite').val(data.co_website);
                $('#coemail').val(data.co_email);
                $('#comoto').val(data.co_moto);
                $('#coimgicon').val(data.co_imgicon);
                $('#coimgicon2').val(data.co_imgicon);
                $('#coimglogo').val(data.co_imglogo);
                $('#coimglogo2').val(data.co_imglogo);
                $('#coimgbg').val(data.co_imgbg);
                $('#coimgbg2').val(data.co_imgbg);
                $('#cocopyright').val(data.co_copyright);
                $('#coreka').val(data.co_rek_a);
                $('#corekb').val(data.co_rek_b);
            } else {
                console.log("No data found.");
            }
        },
        error: function (xhr, status, error) {
        console.error("AJAX error:", error);
        }
    });
});
</script>

</body>

</html>