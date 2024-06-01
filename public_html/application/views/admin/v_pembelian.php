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

    <title>Transaksi Pembelian</title>
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
        font-size: 11px; /* Sesuaikan dengan ukuran font yang diinginkan */
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
            <center><?php echo $this->session->flashdata('msg');?></center>
                <h3 class="page-header">Transaksi Pembelian
                    <small>Barang - <?php echo $userid['reg_code'];?>  <?php echo $userid['reg_name'];?></small>
                    <a href="#" data-toggle="modal" data-target="#largeModal" class="pull-right"><small>Cari Produk!</small></a>
                    
                </h3>
            </div>
        </div>
        <!-- /.row -->
        <!-- Projects Row -->
        <div class="row">
            <div class="col-lg-12">
            <form action="<?php echo base_url().'admin/pembelian/add_to_cart'?>" method="post">
            <table>
                <tr>
                    <th style="width:100px;padding-bottom:5px;">No Faktur</th>
                    <th style="width:300px;padding-bottom:5px;"><input type="text" name="nofak" value="<?php echo $this->session->userdata('nofak');?>" class="form-control input-sm" style="width:200px;" required></th>
                    <th style="width:90px;padding-bottom:5px;">Suplier</th>
                    <td style="width:350px;">
                    <select name="suplier" id="suplier" class="selectpicker show-tick form-control" data-live-search="true" title="Pilih Suplier" data-width="100%" required>
                        <?php foreach ($sup->result_array() as $i) {
                            $id_sup=$i['suplier_id'];
                            $nm_sup=$i['suplier_nama'];
                            $al_sup=$i['suplier_alamat'];
                            $notelp_sup=$i['suplier_notelp'];
                            $sess_id=$this->session->userdata('suplier');
                            if($sess_id==$id_sup)
                                //echo "<option value='$id_sup' selected>$nm_sup - $al_sup - $notelp_sup</option>";
                                echo "<option value='$id_sup' selected>$nm_sup</option>";
                            else
                                //echo "<option value='$id_sup'>$nm_sup - $al_sup - $notelp_sup</option>";
                                echo "<option value='$id_sup'>$nm_sup</option>";
                        }?>
                    </select>
                    </td>
                </tr>
                <tr>
                    <th>Tanggal</th>
                    <td>
                        <div class='input-group date' id='datepicker' style="width:200px;">
                            <input type='text' name="tgl" class="form-control" value="<?php echo $this->session->userdata('tglfak');?>" placeholder="Tanggal..." required/>
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </td>
                    <th></th>
                </tr>
            </table><hr/>
            
            <table>
                <tr>
                    <th>Kode Barang</th>
                </tr>
                <tr>
                    <th><input type="text" name="kode_brg" id="kode_brg" class="form-control input-sm"></th>                     
                </tr>
                    <div id="detail_barang" style="position:absolute;">
                    </div>
            </table>
             </form>
            <table class="table table-bordered table-condensed" style="font-size:11px;margin-top:10px;">
                <thead>
                    <tr>
                        <th>Kode Barang</th>
                        <th>Nama Barang / Keterangan</th>
                        <th style="text-align:center;">Satuan</th>
                        <th style="text-align:center;">Jumlah Beli</th>
                        <th style="text-align:center;">Harga Beli</th>
                        <th style="width:100px;text-align:center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    <?php foreach ($this->cartbeli->contents() as $items): ?>
                    <?php echo form_hidden($i.'[rowid]', $items['rowid']); ?>
                    <tr>
                        <td><?=$items['id'];?></td>
                        <td><?=$items['name'];?></td>
                        <td style="text-align:center;"><?=$items['satuan'];?></td> 
                        <?php 
                        $qty=$items['qty'];
                        if (floor($qty) == $qty) {
                            $formatted_qty = number_format($qty, 0, ',', '.');
                        } else {
                            $formatted_qty = number_format($qty, 2, ',', '.');
                            $formatted_qty = rtrim($formatted_qty, '0');
                            $formatted_qty = rtrim($formatted_qty, ',');
                        }
                        echo '<td style="text-align:center;">'.$formatted_qty.'</td>';
                        ?>        
                        <td style="text-align:right;"><?php echo number_format($items['price'],0, ',' ,'.'); ?></td>
                        <td style="text-align:center;"><a href="<?php echo base_url().'admin/pembelian/remove/'.$items['rowid'];?>" class="btn btn-warning btn-xs"><span class="fa fa-close"></span> Batal</a></td>
                    </tr>
                    <?php $i++; ?>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4" style="padding-right:5px;text-align:right;">Total</td>
                        <td style="text-align:right;">Rp. <?php echo number_format(($this->cartbeli->total()) ,0, ',','.');?></td>
                        
                    </tr>
                </tfoot>
            </table>
            <a href="<?php echo base_url().'admin/pembelian/simpan_pembelian'?>" class="btn btn-info btn-lg"><span class="fa fa-save"></span> Simpan</a>
            <a href="<?php echo base_url().'admin/pembelian/batalsimpan'?>" class="btn btn-danger btn-lg"><span class="fa fa-close"></span> Batal</a>
            </div>
        </div>
        <!-- /.row -->
        
        <hr>


        <!-- ============ MODAL FIND =============== -->
        <div class="modal fade" id="largeModal" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
            <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 class="modal-title" id="myModalLabel">Data Barang - <?php echo $userid['reg_code'];?>  <?php echo $userid['reg_name'];?></h3>
            </div>
                <div id="barangForm" class="modal-body" style="overflow:scroll;height:500px;">

                  <table class="table table-bordered table-condensed" style="font-size:11px;" id="mydata">
                    <thead>
                        <tr>
                            <th style="text-align:center;width:40px;">No</th>
                            <th style="width:120px;">Kode Barang</th>
                            <th style="width:240px;">Nama Barang</th>
                            <th>Satuan</th>
                            <th style="width:100px;">Harga Pokok</th>
                            <th style="width:100px;">Harga Jual</th>
                            <th>Stok</th>
                            <th style="width:100px;text-align:center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                        $no=0;
                        foreach ($data->result_array() as $a):
                            $no++;
                            $id=$a['barang_id'];
                            $nm=$a['barang_nama'];
                            $satuan=$a['barang_satuan'];
                            $harpok=$a['barang_harpok'];
                            $harjul=$a['barang_harjul'];
                
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
                            <td style="text-align:center;"><?php echo $satuan;?></td>
                            <td style="text-align:right;"><?php echo 'Rp ' . str_replace(',', '.', number_format($harpok)); ?></td>
                            <td style="text-align:right;"><?php echo 'Rp ' . str_replace(',', '.', number_format($harjul)); ?></td>
                            <td style="text-align:center;"><?php echo $formatted_stok;?></td>
                            
                            <td style="text-align:center;">
                            <input type="hidden" name="kdbrg_<?php echo $id?>" id="kdbrg_<?php echo $id?>" value="<?php echo $id?>">
                            <button type="submit" class="btn btn-xs btn-info" title="Pilih" onclick="myFunction('<?php echo $id?>')"><span class="fa fa-edit"></span> Pilih</button>
                            </td>
                        </tr>
                    <?php endforeach;?>
                    </tbody>
                </table>          

                </div>

                <div class="modal-footer">
                    <button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
                    
                </div>
            </div>
            </div>
        </div>
        <!-- =========================== -->   

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
    <script src="<?php echo base_url().'assets/js/jquery.price_format.min.js'?>"></script>
    <script src="<?php echo base_url().'assets/js/moment.js'?>"></script>
    <script src="<?php echo base_url().'assets/js/bootstrap-datetimepicker.min.js'?>"></script>
    <script src="<?php echo base_url().'assets/js/jquery.dataTables.min.js'?>"></script>
                            
    <script type="text/javascript">
            $(function () {
                $('#datetimepicker').datetimepicker({
                    format: 'DD MMMM YYYY HH:mm',
                });
                
                $('#datepicker').datetimepicker({
                    format: 'YYYY-MM-DD',
                });
                $('#datepicker2').datetimepicker({
                    format: 'YYYY-MM-DD',
                });

                $('#timepicker').datetimepicker({
                    format: 'HH:mm'
                });
            });
    </script>
    <script type="text/javascript">
        $(function(){
            $('.harpok').priceFormat({
                    prefix: '',
                    //centsSeparator: '',
                    centsLimit: 0,
                    thousandsSeparator: ','
            });
            $('.harjul').priceFormat({
                    prefix: '',
                    //centsSeparator: '',
                    centsLimit: 0,
                    thousandsSeparator: ','
            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function(){
            //Ajax kabupaten/kota insert
            $("#kode_brg").focus();
            //$("#kode_brg").keyup(function(){
            //$('#jumlah').focus();
            $("#kode_brg").on("input",function(){
                var kobar = {kode_brg:$(this).val()};
                $.ajax({
                    type: "POST",
                    url : "<?php echo base_url().'admin/pembelian/get_barang';?>",
                    data: kobar,
                    success: function(msg){
                    $('#detail_barang').html(msg);
                    $('#detail_barang').show();//memunculkan kembali
                    }
                });
            }); 

            $('#kode_brg').on('keydown', function(e) {
            if (e.which == 9) { // Tombol "Tab" memiliki kode kunci 9
                e.preventDefault(); // Mencegah perpindahan bawaan oleh "Tab"
                $('#jumlah').focus(); // Alihkan fokus ke elemen dengan id 'jumlah'
            }
            });

            $('#mydata').DataTable();
            
    });
    </script>

   
<script type="text/javascript">
    function myFunction(id) {
        var kodebrg_id = 'kdbrg_' + id; // Nama elemen input kdbrg_ yang sesuai dengan id
        var kodebrg_value = document.getElementsByName(kodebrg_id)[0].value; // Nilai dari elemen kdbrg_
        // Set nilai kode_brg dengan nilai dari kdbrg_
        document.getElementById('kode_brg').value = kodebrg_value;
         // Setelah mengisi nilai kode_brg, jalankan AJAX
        var kobar = { kode_brg: kodebrg_value };
        $.ajax({
            type: "POST",
            url: "<?php echo base_url().'admin/pembelian/get_barang';?>",
            data: kobar,
            success: function (msg) {
                $('#detail_barang').html(msg);
                $('#detail_barang').show();
            }
        });
        // Menutup modal
        $('#largeModal').modal('hide');    
    }
</script>

<script type="text/javascript"> 
    $(document).on('input', 'input[name^="nofak"]', function(e) {
        var inputValue = e.target.value; 
        //var sanitizedValue = inputValue.replace(/[^0-9A-Za-z\-]/g, ''); //tanpa garis miring hanya - 
        var sanitizedValue = inputValue.replace(/[^0-9A-Za-z\/\-]/g, ''); // dega garis miring
        e.target.value = sanitizedValue; 
    });

</script>
    


</body>
</html>
