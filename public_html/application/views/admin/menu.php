<?php 
	error_reporting(0);
    $userid=$userid->row_array();
?>  

<style>
    #error-message {
    margin-top: 10px;
}
</style>
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?php echo base_url().'welcome'?>">Point of Sale</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                   <?php $h=$this->session->userdata('akses'); ?>
                    <?php $u=$this->session->userdata('user'); ?>
                    
                    <?php if($h=='1'){ ?> 
                     <!--dropdown-->
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" title="Transaksi"><span class="fa fa-shopping-cart" aria-hidden="true"></span> Transaksi</a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo base_url().'admin/jual'?>"><span class="fa fa-history" aria-hidden="true"></span> History Penjualan</a></li>
                            <li><a href="<?php echo base_url().'admin/penjualan_data'?>"><span class="fa fa-shopping-cart" aria-hidden="true"></span> Data Penjualan</a></li>
                            <li><a href="<?php echo base_url().'admin/tempo'?>"><span class="fa fa-shopping-bag" aria-hidden="true"></span> Data Piutang / Penjualan Tempo</a></li> 
                            <li><a href="<?php echo base_url().'admin/beli'?>"><span class="fa fa-shopping-bag" aria-hidden="true"></span> Data Pembelian</a></li> 
                            <li><a href="<?php echo base_url().'admin/rekap'?>"><span class="fa fa-shopping-bag" aria-hidden="true"></span> Data Rekapitulasi</a></li> 
                            <li><a href="<?php echo base_url().'admin/bank'?>"><span class="fa fa-shopping-bag" aria-hidden="true"></span> Input Transaksi Bank</a></li> 
                            <li><a href="<?php echo base_url().'admin/markup'?>"><span class="fa fa-external-link" aria-hidden="true"></span> Mark Up</a></li> 
                        </ul>
                    </li>
                    <!--ending dropdown-->
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" title="Informasi"><span class="fa fa-file" aria-hidden="true"></span> Inquiry Stok</a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo base_url().'admin/stok/tampil_reqstok'?>"><span class="fa fa-shopping-bag" aria-hidden="true"></span> Data Request Stok Barang</a></li> 
                            <li><a href="<?php echo base_url().'admin/transfer_stok/tampil_transtok'?>"><span class="fa fa-random" aria-hidden="true"></span> Data Transfer Stok Barang</a></li>
                            <li><a href="<?php echo base_url().'admin/transfer_stok/tampil_konfirm'?>"><span class="fa fa-retweet" aria-hidden="true"></span> Data Terima/Konfirm Stok Barang</a></li>
                            <li><a href="<?php echo base_url().'admin/transfer_stok/tampil_history'?>"><span class="fa fa-history" aria-hidden="true"></span> Data History Transfer Stok Barang</a></li>
                            <li><a href="<?php echo base_url().'admin/rekap_stok'?>"><span class="fa fa-cubes" aria-hidden="true"></span> Akumulasi Stok</a></li>
                            <li><a href="<?php echo base_url().'admin/data_stok'?>"><span class="fa fa-cubes" aria-hidden="true"></span> Control Stok Barang</a></li>  
                            <li><a href="<?php echo base_url().'admin/history_stok'?>"><span class="fa fa-history" aria-hidden="true"></span> History Stok</a></li>
                            <li><a href="<?php echo base_url().'admin/retur'?>"><span class="fa fa-refresh"></span> Retur</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="<?php echo base_url().'admin/grafik'?>"><span class="fa fa-line-chart"></span> Grafik</a>
                    </li>

                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" title="Transaksi"><span class="fa fa-file" aria-hidden="true"></span> Laporan</a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo base_url().'admin/laporan'?>"><span class="fa fa-file"></span> Laporan</a></li> 
                            <li><a href="<?php echo base_url().'admin/keuangan'?>"><span class="fa fa-dollar" aria-hidden="true"></span> Laporan Keuangan</a></li> 
                            <li><a href="<?php echo base_url().'admin/laba'?>"><span class="fa fa-dollar" aria-hidden="true"></span> Laporan Laba Penjualan</a></li>
                        </ul>
                    </li>

                    
                    <?php }?>
                    <?php if($h=='2'){ ?> 
                      <!--dropdown-->
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" title="Transaksi"><span class="fa fa-shopping-cart" aria-hidden="true"></span> Transaksi</a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo base_url().'admin/jual'?>"><span class="fa fa-shopping-bag" aria-hidden="true"></span> History Penjualan</a></li> 
                            <li><a href="<?php echo base_url().'admin/penjualan_data'?>"><span class="fa fa-shopping-cart" aria-hidden="true"></span> Data Penjualan</a></li>
                            <li><a href="<?php echo base_url().'admin/piutang'?>"><span class="fa fa-shopping-bag" aria-hidden="true"></span> Data Piutang / Penjualan Tempo</a></li> 
                            <li><a href="<?php echo base_url().'admin/beban_data'?>"><span class="fa fa-dollar" aria-hidden="true"></span> Data Pengeluaran / Beban Operasional</a></li> 
                             
                        </ul>
                    </li>
                    <!--ending dropdown-->
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" title="Informasi"><span class="fa fa-file" aria-hidden="true"></span> Inquiry Stok</a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo base_url().'admin/stok/tampil_reqstok'?>"><span class="fa fa-cubes" aria-hidden="true"></span> Data Request Stok Barang</a></li>
                            <li><a href="<?php echo base_url().'admin/transfer_stok/tampil_transtok'?>"><span class="fa fa-random" aria-hidden="true"></span> Data Transfer Stok Barang</a></li>
                            <li><a href="<?php echo base_url().'admin/transfer_stok/tampil_konfirm'?>"><span class="fa fa-retweet" aria-hidden="true"></span> Data Terima/Konfirm Stok Barang</a></li>
                            <li><a href="<?php echo base_url().'admin/data_stok'?>"><span class="fa fa-balance-scale" aria-hidden="true"></span> Control Stok Barang</a></li>    
                            <li><a href="<?php echo base_url().'admin/retur'?>"><span class="fa fa-refresh"></span> Retur</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" title="Transaksi"><span class="fa fa-file" aria-hidden="true"></span> Laporan</a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo base_url().'admin/keuangan'?>"><span class="fa fa-dollar" aria-hidden="true"></span> Laporan Keuangan</a></li> 
                            <!-- <li><a href="<?php //echo base_url().'admin/laba'?>"><span class="fa fa-dollar" aria-hidden="true"></span> Laporan Laba Penjualan</a></li>  -->
                        </ul>
                    </li>
                    
                    <?php }?>
                     <li>
                        <a href="<?php echo base_url().'administrator/logout'?>"><span class="fa fa-sign-out"></span> Logout</a>
                    </li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="#modalEditPwd" data-toggle="modal" title="Ganti Password"><span class="fa fa-user"></span> User : <?php echo $userid['user_nama'];?></a>
                </li>
                </ul>
 
            </div>
            <!-- /.navbar-collapse -->
             
        </div>
        <!-- /.container -->
    </nav>

    <!-- ============ MODAL EDIT =============== -->
    <div id="modalEditPwd" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 class="modal-title" id="myModalLabel">Ganti Password</h3>
            </div>
            <form id="passwordForm" class="form-horizontal" action="<?php echo base_url().'admin/pengguna/editpassword'; ?>" method="POST">
                <div class="modal-body">
                    <input name="kode" type="hidden" value="<?php echo $userid['user_id'];?>">
                    <div class="form-group">
                        <label class="control-label col-xs-5">Password lama</label>
                        <div class="col-xs-7">
                            <input name="pwdlama" class="form-control" type="password" placeholder="Password lama..." required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-5">Password Baru</label>
                        <div class="col-xs-7">
                            <input name="password" class="form-control" type="password" placeholder="Password Baru..." required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-5">Konfirmasi Password Baru</label>
                        <div class="col-xs-7">
                            <input name="password2" class="form-control" type="password" placeholder="Konfirmasi Password Baru..." required>
                        </div>
                    </div>
                    <div id="error-message"></div> <!-- Tambahkan elemen ini untuk menampilkan pesan kesalahan -->
                </div>
                <div class="modal-footer">
                    <button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
                    <button type="button" class="btn btn-info" onclick="submitForm()">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    function submitForm() {
        var formData = $('#passwordForm').serialize();
        $.ajax({
            type: 'POST',
            url: $('#passwordForm').attr('action'),
            data: formData,
            success: function(response) {
                // Tambahkan pesan kesalahan ke dalam elemen error-message
                //$('#error-message').html('<div class="alert alert-danger">' + response + '</div>');
                if (response === 'Berhasil Ganti Password') {
                    $('#error-message').html('<div class="alert alert-success">' + response + '</div>');
                    //$('#modalEdit').modal('hide');  // Sembunyikan modal jika berhasil
                } else {
                    $('#error-message').html('<div class="alert alert-danger">' + response + '</div>');
                }


            }
        });
    }
</script>






