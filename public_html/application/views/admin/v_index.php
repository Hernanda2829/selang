<!DOCTYPE html>
<html lang="en">

<head>
    <?php 
	error_reporting(0);
    $userid=$userid->row_array();
    $markup = $datamarkup->result_array();
    ?>  
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Produk By <?php echo $userid['co_name'];?>">
    <meta name="author" content="<?php echo $userid['co_name'];?>">

    <title>Welcome</title>
    <link rel="shortcut icon" href="<?php echo base_url().'assets/img/'. $userid['co_imgicon']; ?>" alt="#no image#" type="image/x-icon">
    <!-- Bootstrap Core CSS -->
      <link href="<?php echo base_url().'assets/css/bootstrap.min.css'?>" rel="stylesheet">
	    <link href="<?php echo base_url().'assets/css/style.css'?>" rel="stylesheet">
	    <link href="<?php echo base_url().'assets/css/font-awesome.css'?>" rel="stylesheet">
    <!-- Custom CSS -->
      <link href="<?php echo base_url().'assets/css/4-col-portfolio.css'?>" rel="stylesheet">

      <style type="text/css">
        .bg {
           width: 100%;
           height: 100%;
           position: fixed;
           z-index: -1;
           float: left;
           left: 0;
           margin-top: -20px;
        }
        .scrolling-text {
        color: #fcc;
        white-space: nowrap;
        overflow: hidden;
        animation: scroll 5s linear infinite;
        margin: 0;
        padding: 0;
        transform: translateX(100%); /* Mulai dari kanan ujung layar */
        position: absolute; /* Menetapkan posisi absolut */
        z-index: 999; /* Menetapkan z-index tertinggi */
        }
        @keyframes scroll {
            0% {
                transform: translateX(100%);
            }
            100% {
                transform: translateX(-100%);
            }
        }

      .curved-image {
        /*width: 310px; /* Mengatur lebar gambar */
        /*height: 70px; /* Mengatur tinggi gambar */
        /*border-radius: 20%; /* Membuat gambar melengkung (lingkaran) */
        /*object-fit: cover; /* Mengatur cara gambar diatur di dalam area */
        width: 270px; /* Mengatur lebar gambar */
        height: 70px; /* Mengatur tinggi gambar */
        border-radius: 70%; /* Membuat gambar melengkung (lingkaran) */
        object-fit: cover; /* Mengatur cara gambar diatur di dalam area */
        }

        /* Media query untuk tampilan seluler (misalnya, lebar layar kurang dari 768px) */
        @media screen and (max-width: 768px) {
            .scrolling-text {
            top: 50%; /* Menggeser ke bawah sekitar 50% dari tinggi layar */
            }
        }
        /* Media query untuk tampilan seluler (misalnya, lebar layar kurang dari 768px) */
        @media screen and (max-width: 768px) {
            .curved-image {
                width: 150px; /* Mengatur lebar gambar yang sesuai untuk seluler */
                height: 50px; /* Mengatur tinggi gambar yang sesuai untuk seluler */
                border-radius: 50%; /* Mengatur sudut melengkung yang sesuai untuk seluler */
            }
        }
      </style>
      
</head>

<body>
<img src="<?php echo base_url().'assets/img/'. $userid['co_imgbg']; ?>" class="bg" alt="#no image#"/>
    <!-- Navigation -->
   <?php 
        $this->load->view('admin/menu');
   ?>

    <!-- Page Content -->
    <div class="container">

        <!-- Page Heading -->
    <div class="row">
    <div class="col-lg-12">
        <h1 class="page-header" style="color:#fcc; display: flex; justify-content: space-between; align-items: flex-start; margin-top: 10px;">
            <span>Welcome</span>
            <div class="scrolling-text">
                <br><small><?php echo $userid['user_nama'];?> (<?php echo $userid['user_title'];?>) - <?php echo $userid['reg_code'];?>  <?php echo $userid['reg_name'];?> </small>
            </div>
            <img width="310px" src="<?php echo base_url().'assets/img/'. $userid['co_imglogo']; ?>" alt="#no image#" class="curved-image"/>
        </h1>
    </div>
    </div>

        
        <!-- /.row -->
	<div class="mainbody-section text-center">
    <?php $h=$this->session->userdata('akses'); ?>
     

        <!-- Projects Row -->
        <div class="row">
        <?php if($h=='1'){ ?> 
            <div class="col-md-3 portfolio-item">
                <div class="menu-item blue" style="height:150px;">
                     <a href="<?php echo base_url().'admin/diskon'?>" data-toggle="modal">
                           <i class="fa fa-shopping-bag"></i>
                            <p style="text-align:left;font-size:14px;padding-left:5px;">Setting Diskon</p>
                      </a>
                </div> 
            </div>
            <div class="col-md-3 portfolio-item">
                <div class="menu-item light-orange" style="height:150px;">
                     <a href="<?php echo base_url().'admin/suplier'?>" data-toggle="modal">
                           <i class="fa fa-truck"></i>
                            <p style="text-align:left;font-size:14px;padding-left:5px;">Suplier</p>
                      </a>
                </div> 
            </div>
            <div class="col-md-3 portfolio-item">
                <div class="menu-item color" style="height:150px;">
                     <a href="<?php echo base_url().'admin/kategori'?>" data-toggle="modal">
                           <i class="fa fa-sitemap"></i>
                            <p style="text-align:left;font-size:14px;padding-left:5px;">Kategori</p>
                      </a>
                </div> 
            </div>
            <div class="col-md-3 portfolio-item">
                <div class="menu-item light-orange" style="height:150px;">
                     <a href="<?php echo base_url().'admin/beban'?>" data-toggle="modal">
                           <i class="fa fa-dollar"></i>
                            <p style="text-align:left;font-size:14px;padding-left:5px;">Beban Operasional / Pengeluaran</p>
                      </a>
                </div> 
            </div>

            <?php }?>
            <?php if($h=='2'){ ?> 
            <div class="col-md-3 portfolio-item">
                <div class="menu-item blue" style="height:150px;">
                     <a href="<?php echo base_url().'admin/penjualan'?>" data-toggle="modal">
                           <i class="fa fa-shopping-cart"></i>
                            <p style="text-align:left;font-size:14px;padding-left:5px;">Penjualan</p>
                      </a>
                </div> 
            </div>
            
            <div class="col-md-3 portfolio-item">
                <div class="menu-item purple" style="height:150px;">
                     <a href="<?php echo base_url().'admin/barang'?>" data-toggle="modal">
                           <i class="fa fa-list-alt"></i>
                            <p style="text-align:left;font-size:14px;padding-left:5px;">Daftar Barang</p>
                      </a>
                </div> 
            </div>
            
            <div class="col-md-3 portfolio-item">
                <div class="menu-item light-orange" style="height:150px;">
                     <a href="<?php echo base_url().'admin/beban'?>" data-toggle="modal">
                           <i class="fa fa-dollar"></i>
                            <p style="text-align:left;font-size:14px;padding-left:5px;">Pengeluaran / Beban Operasional</p>
                      </a>
                </div> 
            </div>
            <div class="col-md-3 portfolio-item">
                <div class="menu-item color" style="height:150px;">
                     <a href="<?php echo base_url().'admin/laporan'?>" data-toggle="modal">
                           <i class="fa fa-bar-chart"></i>
                            <p style="text-align:left;font-size:14px;padding-left:5px;">Laporan</p>
                      </a>
                </div> 
            </div>
        <?php }?>
        </div>
        
        <!-- /.row -->

        <!-- Projects Row -->
        <div class="row">
        <?php if($h=='1'){ ?> 
            <div class="col-md-3 portfolio-item">
                <div class="menu-item purple" style="height:150px;">
                     <a href="<?php echo base_url().'admin/barang'?>" data-toggle="modal">
                           <i class="fa fa-cubes"></i>
                            <p style="text-align:left;font-size:14px;padding-left:5px;">Barang</p>
                      </a>
                </div> 
            </div>
            <div class="col-md-3 portfolio-item">
                <div class="menu-item green" style="height:150px;">
                     <a href="<?php echo base_url().'admin/pengguna'?>" data-toggle="modal">
                           <i class="fa fa-user-md"></i>
                            <p style="text-align:left;font-size:14px;padding-left:5px;">Pengguna</p>
                      </a>
                </div> 
            </div>
            <div class="col-md-3 portfolio-item">
                <div class="menu-item blue" style="height:150px;">
                     <a href="<?php echo base_url().'admin/laporan'?>" data-toggle="modal">
                           <i class="fa fa-bar-chart"></i>
                            <p style="text-align:left;font-size:14px;padding-left:5px;">Laporan</p>
                      </a>
                </div> 
            </div>
            <div class="col-md-3 portfolio-item">
                <div class="menu-item light-red" style="height:150px;">
                     <a href="<?php echo base_url().'admin/pembelian'?>" data-toggle="modal">
                           <i class="fa fa-cubes"></i>
                            <p style="text-align:left;font-size:14px;padding-left:5px;">Pembelian</p>
                      </a>
                </div> 
            </div>
            <?php }?>
            <?php if($h=='2'){ ?> 
            
                <div class="col-md-3 portfolio-item">
                    <div class="menu-item red" style="height:150px;">
                        <a href="<?php echo base_url().'admin/customer'?>" data-toggle="modal">
                            <i class="fa fa-users"></i>
                                <p style="text-align:left;font-size:14px;padding-left:5px;">Data Customer</p>
                        </a>
                    </div> 
                </div>

                <div class="col-md-3 portfolio-item">
                    <div class="menu-item green" style="height:150px;">
                        <a href="<?php echo base_url().'admin/stok'?>" data-toggle="modal">
                            <i class="fa fa-cubes"></i>
                                <p style="text-align:left;font-size:14px;padding-left:5px;">Request Stok</p>
                        </a>
                    </div> 
                </div>
                <div class="col-md-3 portfolio-item">
                    <div class="menu-item green" style="height:150px;">
                        <a href="<?php echo base_url().'admin/barcode'?>" data-toggle="modal">
                            <i class="fa fa-qrcode"></i>
                                <p style="text-align:left;font-size:14px;padding-left:5px;">Buat QR Code Garansi</p>
                        </a>
                    </div> 
                </div>
                <?php
                    if (!empty($markup)) {
                        // Jika $markup memiliki data
                        echo '<div class="col-md-3 portfolio-item">';
                        echo '<div class="menu-item red" style="height:150px;">';
                        echo '<a href="'.base_url().'admin/markup_kasir" data-toggle="modal">';
                        echo '<i class="fa fa-line-chart"></i>';
                        echo '<p style="text-align:left;font-size:14px;padding-left:5px;">Data Mark up</p>';
                        echo '</a>';
                        echo '</div>'; 
                        echo '</div>';
                    } else {
                        // Jika $markup tidak memiliki data
                        // Tidak ada yang ditampilkan
                    }
                ?>

            
            <?php }?>
        </div>
        
		<div class="row">
        <?php if($h=='1'){ ?> 
            <div class="col-md-3 portfolio-item">
                <div class="menu-item blue" style="height:150px;">
                     <a href="<?php echo base_url().'admin/cabang'?>" data-toggle="modal">
                           <i class="fa fa-home"></i>
                            <p style="text-align:left;font-size:14px;padding-left:5px;">Setting Kantor Cabang</p>
                      </a>
                </div> 
            </div>

            <div class="col-md-3 portfolio-item">
                <div class="menu-item red" style="height:150px;">
                     <a href="<?php echo base_url().'admin/customer'?>" data-toggle="modal">
                           <i class="fa fa-users"></i>
                            <p style="text-align:left;font-size:14px;padding-left:5px;">Data Customer</p>
                      </a>
                </div> 
            </div>
            <div class="col-md-3 portfolio-item">
                <div class="menu-item red" style="height:150px;">
                     <a href="<?php echo base_url().'admin/backup'?>" data-toggle="modal">
                           <i class="fa fa-database"></i>
                            <p style="text-align:left;font-size:14px;padding-left:5px;">Backup Database</p>
                      </a>
                </div> 
            </div>
            <div class="col-md-3 portfolio-item">
                <div class="menu-item blue" style="height:150px;">
                     <a href="<?php echo base_url().'admin/unit'?>" data-toggle="modal">
                           <i class="fa fa-balance-scale"></i>
                            <p style="text-align:left;font-size:14px;padding-left:5px;">Setting Unit/Satuan</p>
                      </a>
                </div> 
            </div>
        </div>
        <?php }?>
        
        <div class="row">
        <?php if($h=='2'){ ?> 
            <div class="col-md-3 portfolio-item">
                <div class="menu-item purple" style="height:150px;">
                    <a href="<?php echo base_url().'admin/transfer_stok'?>" data-toggle="modal">
                        <i class="fa fa-random"></i>
                            <p style="text-align:left;font-size:14px;padding-left:5px;">Transfer Stok</p>
                    </a>
                </div> 
            </div>
    
        <?php }?>
        </div>
        

        <div class="row">
        <?php if($h=='1'){ ?> 
            <div class="col-md-3 portfolio-item">
                <div class="menu-item green" style="height:150px;">
                     <a href="<?php echo base_url().'admin/kolek'?>" data-toggle="modal">
                           <i class="fa fa-cogs"></i>
                            <p style="text-align:left;font-size:14px;padding-left:5px;">Setting Kolektibilitas</p>
                      </a>
                </div> 
            </div>
            <div class="col-md-3 portfolio-item">
                <div class="menu-item purple" style="height:150px;">
                     <a href="<?php echo base_url().'admin/periode'?>" data-toggle="modal">
                           <i class="fa fa-hourglass-half"></i>
                            <p style="text-align:left;font-size:14px;padding-left:5px;">Setting Periode</p>
                      </a>
                </div> 
            </div>
            <div class="col-md-3 portfolio-item">
                <div class="menu-item blue" style="height:150px;">
                     <a href="<?php echo base_url().'admin/penjualan_admin'?>" data-toggle="modal">
                           <i class="fa fa-shopping-cart"></i>
                            <p style="text-align:left;font-size:14px;padding-left:5px;">Penjualan By Admin</p>
                      </a>
                </div> 
            </div>
            <div class="col-md-3 portfolio-item">
                <div class="menu-item green" style="height:150px;">
                    <a href="<?php echo base_url().'admin/garansi'?>" data-toggle="modal">
                        <i class="fa fa-qrcode"></i>
                            <p style="text-align:left;font-size:14px;padding-left:5px;">Data Garansi</p>
                    </a>
                </div> 
            </div>
            
        </div>
        <?php }?>

        <div class="row">
        <?php if($h=='1'){ ?> 
            <div class="col-md-3 portfolio-item">
                <div class="menu-item light-orange" style="height:150px;">
                     <a href="<?php echo base_url().'admin/tempo_admin'?>" data-toggle="modal">
                           <i class="fa fa-history"></i>
                            <p style="text-align:left;font-size:14px;padding-left:5px;">Input Penjualan Tempo</p>
                      </a>
                </div> 
            </div>

            <div class="col-md-3 portfolio-item">
                <div class="menu-item purple" style="height:150px;">
                    <a href="<?php echo base_url().'admin/transfer_stok'?>" data-toggle="modal">
                        <i class="fa fa-random"></i>
                            <p style="text-align:left;font-size:14px;padding-left:5px;">Transfer Stok</p>
                    </a>
                </div> 
            </div>
            
            
        </div>
        <?php }?>
        <!-- /.row -->
	
    <!-- /.container -->

    <!-- jQuery -->
    <script src="<?php echo base_url().'assets/js/jquery.js'?>"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo base_url().'assets/js/bootstrap.min.js'?>"></script>

</body>

</html>
