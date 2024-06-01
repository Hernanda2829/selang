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
    <meta name="description" content="Produk By <?php echo $userid['co_name'];?>">
    <meta name="author" content="<?php echo $userid['co_name'];?>">

    <title>Management data barang</title>
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

<style>
    .modal-dialog {
        max-height: 90vh; /* Atur tinggi maksimum sesuai kebutuhan Anda */
        overflow-y: auto; /* Aktifkan scrollbar jika kontennya melebihi tinggi maksimum */
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
                <h3 class="page-header">Data
                    <small>Barang - <?php echo $userid['reg_code'];?>  <?php echo $userid['reg_name'];?></small>
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
                        <th style="max-width:10px;text-align:center;">No</th>
                        <th style="max-width:30px;text-align:center;">Kode Barang</th>
                        <th style="text-align:center;vertical-align:middle;">Nama Barang</th>
                        <th style="padding-left:5px;max-width:10px;text-align:center;vertical-align:middle;" data-orderable="false">Kode Disc</th>
                        <th style="padding-left:5px;max-width:25px;text-align:center;">Satuan</th>
                        <th style="max-width:50px;text-align:center;">Harga Jual</th>
                        <th style="max-width:30px;text-align:center;">Stok</th>
                        <th style="max-width:40px;text-align:center;">Kategori</th>
                    </tr>  
                </thead>
                <tbody>
                <?php 
                    $no=0;
                    foreach ($data->result_array() as $a):
                        $no++;
                        $id=$a['barang_id'];
                        $nm=$a['barang_nama'];
                        $disc_id=$a['barang_disc_id'];
                        $satuan=$a['barang_satuan'];
                        $harjul=$a['barang_harjul'];
                        $kat_nama=$a['barang_kategori_nama'];
                        $stok=$a['stok_cabang'];
                        if (floor($stok) == $stok) {
                            $formatted_stok = number_format($stok, 0, ',', '.');
                        } else {
                            $formatted_stok = number_format($stok, 2, ',', '.');
                            $formatted_stok = rtrim($formatted_stok, '0');
                            $formatted_stok = rtrim($formatted_stok, ',');
                        }   
                ?>
                    <tr>
                        <td style="text-align:center;"><?php echo $no;?></td>
                        <td><?php echo $id;?></td>
                        <td><?php echo $nm;?></td>
                        <td style="text-align:center;"><?php echo $disc_id;?></td>
                        <td style="text-align:center;"><?php echo $satuan;?></td>
                        <td style="text-align:right;"><?php echo 'Rp ' . str_replace(',', '.', number_format($harjul)); ?></td>
                        <td style="text-align:center;"><?php echo $formatted_stok;?></td>
                        <td style="text-align:center;"><?php echo $kat_nama;?></td>
                    </tr>
                <?php endforeach;?>
                </tbody>
            </table>
            </div>
        </div>
        
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
    <script src="<?php echo base_url().'assets/js/jquery.price_format.min.js'?>"></script>
          
    <script type="text/javascript">
        $(document).ready(function() {
            $('#mydata').DataTable();
        } );
    </script> 
</body>

</html>
