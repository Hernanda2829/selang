<!DOCTYPE html>
<html lang="en">

<head>
    <?php 
	error_reporting(0);
    // error_reporting(E_ALL);
    // ini_set('display_errors', 1);

    $userid=$userid->row_array();
    $lbl_kembali = "Kembalian (Rp)";
    $sess_carabyr=$this->session->userdata('carabyr');
    $dn="display:none;";
    ?>  

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Produk By <?php echo $userid['co_name'];?>">
    <meta name="author" content="<?php echo $userid['co_name'];?>">

    <title>Transaksi Penjualan</title>
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
                <h3 class="page-header">Transaksi
                    <small>Penjualan - <?php echo $userid['reg_code'];?>  <?php echo $userid['reg_name'];?></small>
                    <a href="#" data-toggle="modal" data-target="#largeModal" class="pull-right"><small>Cari Produk!</small></a>
                </h3> 
            </div>
        </div>
        <!-- /.row -->
        <!-- Projects Row -->
        <div class="row">
            <div class="col-lg-12">
            <form action="<?php echo base_url().'admin/penjualan/add_to_cart'?>" method="post">
            <table>
            <tr>
                <th style="width:100px;vertical-align:middle;padding-bottom:10px;">Customer</th>
                <td style="width:500px;padding-bottom:10px;">
                    <select name="customer" id="customer" class="selectpicker show-tick form-control" data-live-search="true" title="Pilih Customer/Pelanggan" data-width="500px" required>
                        <?php 
                        $sess_custid=$this->session->userdata('idcust');
                        foreach ($cust->result_array() as $c) {
                            $id_cust=$c['cust_id'];
                            $nm_cust=$c['cust_nama'];
                            $al_cust=$c['cust_alamat'];
                            $notelp_cust=$c['cust_notelp'];        
                            if($sess_custid==$id_cust) {
                                echo "<option value='$id_cust' selected>$nm_cust - $al_cust - $notelp_cust</option>";
                            }else {
                                echo "<option value='$id_cust'>$nm_cust - $al_cust - $notelp_cust</option>";
                            }
                        }
                            if($sess_custid=='0') {
                                echo "<option value='0' selected>Umum</option>";
                            }else{
                                echo "<option value='0'>Umum</option>";
                            }
                        ?>
                    </select>        
                </td>
                <th style="width:100px;text-align:right;vertical-align:middle;padding-bottom:10px;">No Nota</th>
                <td style="width:250px;padding-bottom:10px;padding-left:15px;">
                    <input type="text" name="nota" id="nota" class="form-control" style="width:250px" maxlength="30" placeholder="nomor nota penjualan/kuitansi" value="<?php echo $this->session->userdata('nota');?>">
                </td>
            </tr>
            <tr>
                <th style="width:100px;vertical-align:middle;">Cara Bayar</th>
                <td colspan="3">
                    <div style="display:flex;align-items:center;">
                        <select name="carabayar" id="carabayar" class="selectpicker show-tick form-control" data-live-search="true" title="Pilih Cara Pembayaran" data-width="200px" required>
                            <?php  
                                if(!empty($sess_carabyr) && ($sess_carabyr=="Cash")) {
                                    echo '<option selected>'.$sess_carabyr.'</option>';
                                    echo '<option>Tempo</option>';
                                    $lbl_kembali = "Kembalian (Rp)";
                                    $dn='display:none;';
                                }elseif(!empty($sess_carabyr) && ($sess_carabyr=="Tempo")) {
                                    echo '<option>Cash</option>';
                                    echo '<option selected>'.$sess_carabyr.'</option>';
                                    $lbl_kembali = "Kurang Bayar (Rp)";
                                    $dn='';
                                }else {
                                    echo '<option>Cash</option>';
                                    echo '<option>Tempo</option>';
                                    $dn='display:none;';
                                }
                            ?>
                        </select>
                               
                            <span id="lblperiode" style="padding-left:50px;margin-right:10px;font-weight:bold;<?php echo $dn;?>">Periode Tempo (Bln) </span>
                            <div id="btnprdbln" style="<?php echo $dn;?>">
                            <select name="prdbln" id="prdbln" class="selectpicker show-tick form-control" title="Pilih Bulan" placeholder="Pilih Bulan" data-width="130px">
                            <?php
                                $sesprd=$this->session->userdata('bln');    
                                foreach ($periode->result_array() as $p) {
                                    $pval = $p['p_val'];
                                    $pnm = $p['p_nama'];
                                    if(!empty($sesprd) && ($sesprd==$pval)) {
                                        echo "<option value='$pval' selected>$pval $pnm</option>";
                                    }else{
                                        echo "<option value='$pval'>$pval $pnm</option>";
                                    }
                                }  
                            echo '</select>';
                            ?>
                            </div>
                            <span id="lbljtempo" style="padding-left:20px;margin-right:10px;font-weight:bold;<?php echo $dn;?>"> Tgl Jatuh Tempo </span>
                            <div class='input-group date' id='datepicker' style="width:150px;<?php echo $dn;?>">
                            <?php
                            $sesjtm=$this->session->userdata('jtm');
                                echo '<input type="text" name="tgljtempo" id="tgljtempo" class="form-control" style="color:green;" value="'.$sesjtm.'" maxlength="10">';
                            ?>
                                <span class="input-group-addon" onclick="handleDatepickerClick()">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                            <input type="hidden" name="tglnow" id="tglnow" class="form-control input-sm" value="<?php echo $tglskrg?>" style="width:90px;display:flex;" readonly>
                             
                    </div>
                </td>
            </tr>    
            </table>

            <hr/>
            <table>
                <tr>
                    <th>Kode Barang</th>
                </tr>
                <tr>
                    <input type="text" name="id_reg" id="id_reg" class="form-control input-sm" style="width:50px;display:none;" value="<?php echo $userid['reg_id'];?>">
                    <th><input type="text" name="kode_brg" id="kode_brg" class="form-control input-sm" title="Isikan Kode Barang, untuk menampilkan definisi stok barang, atau click Cari Produk untuk menampilkan data barang"></th>
                </tr>
                    <div id="detail_barang" style="position:absolute;">
                    </div>
            </table>
                           
            </form>
            <table id="tbl_data" class="table table-bordered table-condensed" style="font-size:11px;margin-top:10px;">
                <thead>
                    <tr>
                        
                        <th style="text-align:center;">Pilih</th>
                        <th style="text-align:center;">Group</th>
                        <th style="text-align:center;">Deskripsi</th>
                        <th style="text-align:center;">Ket Jml</th>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th style="text-align:center;">Satuan</th>
                        <th style="text-align:center;">Harga(Rp)</th>
                        <th style="text-align:center;">Diskon(%)</th>
                        <th style="text-align:center;">Diskon(Rp)</th>
                        <th style="text-align:center;">Qty</th>
                        <th style="text-align:center;">Sub Total</th>
                        <th style="width:100px;text-align:center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    <?php foreach ($this->cart->contents() as $items): ?>
                    <?php echo form_hidden($i.'[rowid]', $items['rowid']); ?>    
                    <tr>
                        <td style="text-align:center;"><input type="checkbox" name="check<?php echo $items['rowid'];?>"></td>
                        <td style="text-align:center;"><input type="text" id="kode_s<?php echo $i;?>" name="kode_s<?php echo $i;?>" style="width:30px;text-align:center;color:blue" value="<?=$items['kode_set'];?>" readonly></td>
                        <td style="text-align:center;"><input type="text" id="desk_s<?php echo $i;?>" name="desk_s<?php echo $i;?>" style="width:50px;" value="<?=$items['desk_set'];?>" title="<?=$items['desk_set'];?>" readonly></td>
                        <td style="text-align:center;"><input type="text" id="jml_s<?php echo $i;?>" name="jml_s<?php echo $i;?>" style="width:50px;" value="<?=$items['jml_set'];?>" readonly></td>
                        <td><?=$items['id'];?></td>
                        <td><?=$items['name'];?></td>
                        <td style="text-align:center;"><?=$items['satuan'];?></td>
                        <td style="text-align:right;"><?php echo number_format($items['amount'],0, ',' ,'.'); ?></td>
                        <?php 
                        $rtd=$items['ratedisc'];
                        if (floor($rtd) == $rtd) {
                            $formatted_rtd = number_format($rtd, 0, ',', '.');
                        } else {
                            $formatted_rtd = number_format($rtd, 2, ',', '.');
                            $formatted_rtd = rtrim($formatted_rtd, '0');
                            $formatted_rtd = rtrim($formatted_rtd, ',');
                        }
                        echo '<td style="text-align:center;">'. $formatted_rtd.'</td>';
                        ?>           
                        <td style="text-align:right;"><?php echo number_format($items['disc'],0, ',' ,'.'); ?></td>
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
                        <td style="text-align:right;"><?php echo number_format($items['subtotal'],0, ',' ,'.'); ?></td>
                        <td style="text-align:center;"><a href="<?php echo base_url().'admin/penjualan/remove/'.$items['rowid'];?>" class="btn btn-warning btn-xs"><span class="fa fa-close"></span> Batal</a></td>
                    </tr>    
                    <?php $i++; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <table id="tbl_set" style="margin-top:20px;">
                <thead>
                    <tr>
                        <th style="width:20px;vertical-align:middle;padding-right:10px;"></th>
                        <th style="width:20px;vertical-align:middle;padding-right:10px;">Deskripsi Set</th>
                        <th style="width:15px;vertical-align:middle;padding-right:10px;">Jumlah Set</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="width:20px;vertical-align:middle;padding-right:10px;"><button class="btn btn-sm btn-info btn-set" title="Centang pada Kolom Pilih, untuk menjadikan Item Barang Group Set"><span class="fa fa-gears"></span> Buat Set</button></td>
                        <td style="width:20px;vertical-align:middle;padding-right:10px;"><input type="text" id="desk_set" class="form-control input-sm" name="desk_set" style="width:500px;" placeholder="Satu Set..." maxlength="150" title="Isikan Keterangan Set Paket Barang untuk tampilan Pencetakan"></td>
                        <td style="width:15px;vertical-align:middle;padding-right:10px;"><input type="text" id="jml_set" class="form-control input-sm" name="jml_set" style="width:100px;" placeholder="1 Set" maxlength="11" title="Isikan Jumlah/Quantity Set Paket Barang untuk tampilan Pencetakan"></td>
                        <td style="width:20px;vertical-align:middle;padding-right:10px;"><button class="btn btn-sm btn-danger btn-unset" data-row="<?= $i; ?>" title="Centang pada Kolom Pilih, untuk membatalkan Data Set"><span class="fa fa-eraser"></span> Clear Set</button></td>
                    </tr>
                </thead>
            </table>    
            <hr/> 

            <form action="<?php echo base_url().'admin/penjualan/simpan_penjualan'?>" method="post">
            <table>
                <tr>
                    <td style="width:660px;" rowspan="2"><button type="submit" id="simpan" name="simpan" class="btn btn-info btn-lg" title="Simpan Transaksi Penjualan"> Simpan</button>
                    <a href="<?php echo base_url().'admin/penjualan/batalsimpan'?>" class="btn btn-danger btn-lg" title="Batalkan Transaksi Penjualan"><span class="fa fa-close"></span> Batal</a></td>
                    <th style="width:160px;">Total Belanja(Rp)</th>
                    <th style="text-align:right;width:160px;"><input type="text" name="total2" value="<?php echo number_format(($this->cart->total()) ,0, ',','.');?>" class="form-control input-sm" style="text-align:right;margin-bottom:5px;" readonly></th>
                    <input type="hidden" id="total" name="total" value="<?php echo $this->cart->total();?>" class="form-control input-sm" style="text-align:right;margin-bottom:5px;" readonly>
                </tr>
                <tr>
                    <th>Tunai(Rp)</th>
                    <th style="text-align:right;"><input type="text" id="jml_uang" name="jml_uang" class="jml_uang form-control input-sm" style="text-align:right;margin-bottom:5px;" required></th>
                    <input type="hidden" id="jml_uang2" name="jml_uang2" class="form-control input-sm" style="text-align:right;margin-bottom:5px;" readonly>
                </tr>
                <tr>
                    <td></td>    
                    <th id="lbl_kembali"><?php echo $lbl_kembali?></th>
                    <th style="text-align:right;"><input type="text" id="kembalian" name="kembalian" class="form-control input-sm" style="text-align:right;margin-bottom:5px;" readonly></th>
                    
                </tr>
            </table>
            </form>
            <hr/>
        </div>

        

        <!-- ============ MODAL FIND =============== -->
        <div class="modal fade" id="largeModal" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
            <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 class="modal-title" id="myModalLabel">Data Barang - <small><?php echo $userid['reg_code'];?>  <?php echo $userid['reg_name'];?></small></h3>
            </div>
                <div class="modal-body" style="overflow:scroll;height:450px;">

                  <table class="table table-bordered table-condensed" style="font-size:11px;" id="mydata">
                    <thead>
                        <tr>
                            <th style="text-align:center;width:40px;">No</th>
                            <th style="width:120px;">Kode Barang</th>
                            <th style="width:240px;">Nama Barang</th>
                            <th style="padding-left:5px;max-width:10px;text-align:center;vertical-align:middle;" data-orderable="false">Kode Disc</th>
                            <th>Satuan</th>
                            <th style="width:100px;">Harga Jual</th>
                            <th>Stok</th>
                            <th>Kategori</th>
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
                            $disc_id=$a['barang_disc_id'];
                            $satuan=$a['barang_satuan'];
                            $harjul=$a['barang_harjul'];
                            $kategori=$a['barang_kategori_nama'];
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
                            <td style="text-align:center;"><?php echo $kategori;?></td>
                            <td style="text-align:center;">
                            <button type="submit" class="btn btn-xs btn-info" title="Pilih" onclick="pilihKode('<?php echo $id?>')"><span class="fa fa-edit"></span> Pilih</button>
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
            $('#datepicker').datetimepicker({
                format: 'YYYY-MM-DD',
            });
        });
    </script>
    
    <script type="text/javascript">
            $('#jml_uang').on('keydown', function(event) {
                // Hanya izinkan angka, backspace, dan titik (jika diperlukan)
                var allowedKeys = [8, 9, 37, 39, 46];  // Backspace, Tab, left arrow, right arrow, delete
                var inputValue = event.which;
                if (!(event.shiftKey == false && (inputValue >= 48 && inputValue <= 57)) && // Regular numbers
                    !(inputValue == 8 || inputValue == 9 || inputValue == 37 || inputValue == 39 || inputValue == 46)) {  // Backspace, arrows, delete
                    event.preventDefault();
                }
            });   
           
            $(function() {
                $('#jml_uang').on("input", function() {
                    var total = parseFloat($('#total').val().replace(/[^\d.,]/g, '')) || 0;
                    var jumuang = parseFloat($('#jml_uang').val().replace(/[^\d.,]/g, '')) || 0;
                    var hsl = jumuang;
                    $('#jml_uang2').val(hsl);  
                    var kembalian = hsl - total;
                    //var formattedKembalian = Math.floor(kembalian).toLocaleString('id-ID'); //pembulatan ke bawah
                    var formattedKembalian = Math.ceil(kembalian).toLocaleString('id-ID'); //pembulatan ke atas
                    //formattedKembalian = formattedKembalian.replace('.', ','); // Mengganti titik dengan koma untuk desimal kalo mau menggunakan titik jangan gunakan perintah ini
                    $('#kembalian').val(formattedKembalian);
        
                });
                

                $('#jml_uang').on("blur", function() {
                var cb = $('#carabayar option:selected').val();
                if (cb === "Cash") {
                    var total = parseFloat($('#total').val().replace(/[^\d.,]/g, '')) || 0;
                    var jumuang = parseFloat($('#jml_uang2').val().replace(/[^\d.,]/g, '')) || 0;
                    if (jumuang < total) {
                        alert('Pilihan Pembayaran adalah Cash, Uang tunai yang dibayar kurang, cek kembali inputan anda.');
                        $("#jml_uang").val('');
                        $("#jml_uang2").val('');
                        $('#kembalian').val('');
                        setTimeout(function() {
                            $("#jml_uang").focus(); // Tambahkan delay untuk memastikan pengaturan fokus berhasil
                        }, 0);
                    }else {
                        var jumuang = parseFloat($('#jml_uang2').val().replace(/[^\d.,]/g, '')) || 0;
                        var formattedJumuang = jumuang.toLocaleString('id-ID');
                        $('#jml_uang').val(formattedJumuang);
                    }
                } else if (cb === "Tempo") {
                    var total = parseFloat($('#total').val().replace(/[^\d.,]/g, '')) || 0;
                    var jumuang = parseFloat($('#jml_uang').val().replace(/[^\d.,]/g, '')) || 0;
                    if (jumuang >= total) {
                        alert('Pilihan Pembayaran adalah Tempo, tetapi uang tunai yang dibayar melebihi total bayar, cek kembali inputan anda.');
                        $("#jml_uang").val('');
                        $("#jml_uang2").val('');
                        $('#kembalian').val('');
                        setTimeout(function() {
                            $("#jml_uang").focus(); // Tambahkan delay untuk memastikan pengaturan fokus berhasil
                        }, 0);
                    }else {
                        var jumuang = parseFloat($('#jml_uang2').val().replace(/[^\d.,]/g, '')) || 0;
                        var formattedJumuang = jumuang.toLocaleString('id-ID');
                        $('#jml_uang').val(formattedJumuang);
                    }
                }
                });

                $("#kembalian").keydown(function(e) {
                    if (e.which == 9) { // Tombol "Tab" (kode 9)
                        e.preventDefault(); // Mencegah perpindahan bawaan oleh "Tab"
                        $("#simpan").focus(); // Alihkan fokus ke elemen "#jumlah"
                    }
                });


            });
    </script>
    

<script type="text/javascript">
$(document).ready(function () {
    $("#kode_brg").focus();

    $("#kode_brg").on("input", function () {
        handleKodeChange();
    });

    function handleKodeChange() {
        var kobar = { kode_brg: $("#kode_brg").val() };
        var idreg = { id_reg: $('#id_reg').val() };
        var postData = Object.assign({}, kobar, idreg);

        $.ajax({
            type: "POST",
            url: "<?php echo base_url().'admin/penjualan/get_barang';?>",
            data: postData,
            success: function (msg) {
                $('#detail_barang').html(msg);
                handleSelectChange($('#ratediskon')[0]);
            },
            error: function (xhr, status, error) {
                // Handle errors
            }
        });
    }

    function handleSelectChange(selectElement) {
        var harjul = parseFloat($('#harjul').val().replace(/[^\d,]/g, '')) || 0;
        var disc = parseFloat($(selectElement).val().replace(',', '.')) || 0;
        var qty = parseFloat($('#qty').val().replace(',', '.')) || 0;
        var totalHarga = harjul * qty;
        var diskon = totalHarga * (disc / 100);
        var formattedHasil = Math.floor(diskon).toLocaleString('id-ID');
        $('#diskon').val(formattedHasil);
    }

    $('#kode_brg').on('keydown', function (e) {
        if (e.which == 9) {
            e.preventDefault();
            $('#qty').focus();
        }
    });

    $('#largeModal').on('hidden.bs.modal', function () {
        handleKodeChange();
        setTimeout(function() {
        $("#kode_brg").focus();
        }, 100);
    });

    $('#mydata').DataTable();


});
function pilihKode(id) {
    $('#kode_brg').val(id);
    $('#largeModal').modal('hide');
}
</script>


<script type="text/javascript"> 
    $('select[name="carabayar"]').on('change', function() {
    const cb = $('#carabayar option:selected').val();
    let $lbl_kembali;
    
    if (cb === "Cash") {
        $lbl_kembali = "Kembalian (Rp)";
        $('#prdbln').selectpicker('val', '');
        $('#prdbln').selectpicker('refresh');
        $('#tgljtempo').val('');
        $('#lblperiode').hide();
        $('#lbljtempo').hide();
        $('#btnprdbln').hide();
        $('#datepicker').hide();
        $('#tgljtempo').removeAttr('required');
        $('#prdbln').removeAttr('required');
    } else if (cb === "Tempo") {
        $lbl_kembali = "Kurang Bayar (Rp)";
        $('#lblperiode').show();
        $('#lbljtempo').show();
        $('#btnprdbln').show();
        $('#datepicker').show();
        $('#tgljtempo').prop('required', true);
        $('#prdbln').prop('required', true);
    }
    
    // Memasukkan nilai $lbl_kembali ke dalam elemen <th> dengan ID "lbl_kembali"
    $('#lbl_kembali').text($lbl_kembali);
    $("#jml_uang").val('');
    $('#kembalian').val('');
});


    //$(document).on('input', 'input[name^="nota"]', function(e) {
    $(document).on('input', '#nota', function(e) {
        var inputValue = e.target.value; 
        var sanitizedValue = inputValue.replace(/[^0-9A-Za-z\-]/g, '');
        e.target.value = sanitizedValue; 
    });
    

    //$(document).on('change', 'select[name^="prdbln"]', function(e) {
    $('select[name="prdbln"]').on('change', function() {
        var tgTrans = $('#tglnow').val();
        var currentDate = new Date(tgTrans);
        var selectedPeriod = parseInt($(this).val());
        var futureDate = new Date(currentDate);
        futureDate.setMonth(currentDate.getMonth() + selectedPeriod);
        var formattedDate = futureDate.toISOString().slice(0, 10);
        $('#tgljtempo').val(formattedDate);
    });


    $(document).on('input', '#tgljtempo', function(e) {
        var inputValue = e.target.value;
        var sanitizedValue = inputValue.replace(/[^0-9-\b\t]/g, ''); 
        e.target.value = sanitizedValue; 
    });

    $('#tgljtempo').on("blur", function() {
        var tglJtempoValue = $('#tgljtempo').val();
        var tglnowValue = $('#tglnow').val();
        if (tglJtempoValue !== "" && tglJtempoValue < tglnowValue) {
            // Mengatur kembali nilai $('#tgljtempo') ke nilai minimal jika kurang dari $('#tglnow')
            $('#tgljtempo').val(tglnowValue);
            alert('Tanggal Jatuh Tempo harus lebih dari tanggal hari ini');
        }
    });
</script>

<script type="text/javascript">
$(document).on('change', '#customer', function(e) {
    var custid = $(this).val();
    $.ajax({
        url: "<?php echo base_url().'admin/penjualan/cek_customer';?>",
        type: "POST",
        data: {custid: custid},
        success: function (data) {
            //console.log(data);
            var parsedData = JSON.parse(data);
            if (parsedData.length !== 0) {
                var jmlyes=0;
                parsedData.forEach(function(item) {
                    if (item.stop_sales === "Yes") {
                        jmlyes=jmlyes+1;
                    }
                });
                if (jmlyes > 0) {
                    alert("Penjualan untuk pelanggan ini telah dihentikan!, silahkan selesaikan dulu kewajibannya.");
                    window.location.reload();      
                }
                
            } else {
                console.log("No data found.");
            }
        },
        error: function(xhr, status, error) {
            console.error("AJAX error:", error);
        }
    });
});
</script>    


<script>
    $(document).ready(function () {
    var lastGroupNumber = 0;
    
    // Fungsi untuk menangani tindakan ketika tombol "Buat Set" di luar tabel diklik
    $('.btn-set').click(function () {
        var checkedRows = $('#tbl_data tbody tr').filter(':has(input[name^="check"]:checked)');

        // Validasi: Periksa apakah setidaknya dua baris dipilih
        if (checkedRows.length >= 2) {
            var duplicateGroupId = false;

            // Periksa apakah ada baris yang sudah memiliki group id
            checkedRows.each(function () {
                var existingGroupId = $(this).find('input[name^="kode_s"]').val();
                if (existingGroupId !== '' && existingGroupId !== undefined) {
                    duplicateGroupId = true;
                    return false; // Hentikan loop jika sudah ditemukan duplikat
                }

            });

            if (duplicateGroupId) {
                alert('Salah satu baris sudah memiliki group id. Cek kembali inputan Anda.');
                return; // Hentikan eksekusi fungsi jika ada duplikat
            }

            // Setidaknya dua baris dipilih
            lastGroupNumber++;
           
            // Lanjutkan dengan logika untuk menampilkan modal dan sebagainya
            checkedRows.each(function () {
                // Mengisi nilai desk dengan nilai dari input #desk_set
                var descValue = $('#desk_set').val();
                $(this).find('input[name^="desk_s"]').val(descValue);
                var jmlValue = $('#jml_set').val();
                $(this).find('input[name^="jml_s"]').val(jmlValue);

                // Mengisi nilai groupid
                $(this).find('input[name^="kode_s"]').val(lastGroupNumber);
            });

            //update cart shoping : 
            var requestData = []; // Bersihkan requestData sebelum mengumpulkan data baru
            $('#tbl_data tbody tr').each(function () {
                var checkbox = $(this).find('input[name^="check"]');
                if (checkbox.is(':checked')) {
                    var id = checkbox.attr('name').replace('check', '');
                    var groupid = $(this).find('input[name^="kode_s"]').val();
                    var groupdesk = $(this).find('input[name^="desk_s"]').val();
                    var groupjml = $(this).find('input[name^="jml_s"]').val();
                    requestData.push({
                        id: id,
                        groupid: groupid,
                        groupdesk: groupdesk,
                        groupjml: groupjml
                    });
                }
            });

            //Kirim data menggunakan AJAX
            $.ajax({
                type: 'POST',
                url: "<?php echo base_url().'admin/penjualan/update_set';?>",
                data: { requestData: JSON.stringify(requestData) }, // Serialize requestData to JSON
                dataType: 'json', // Set dataType to JSON
                success: function (response) {
                    // Lakukan sesuatu dengan respons JSON jika diperlukan
                    //console.log('Response:', response);
                },
                error: function (xhr, status, error) {
                    //console.error('Error:', error);
                }
            });



            // Bersihkan pemilihan pada checkbox
            checkedRows.find('input[name^="check"]').prop('checked', false);
        } else {
            alert('Pilih setidaknya dua baris sebelum membuat set.');
        }
    });

    
});      

</script>

<script>
    $('.btn-unset').click(function () {
        var checkedRows = $('#tbl_data tbody tr').filter(':has(input[name^="check"]:checked)');
           
            // Lanjutkan dengan logika untuk menampilkan modal dan sebagainya
            checkedRows.each(function () {
                // Mengisi nilai desk dengan nilai dari input #desk_set
                var descValue = null;
                $(this).find('input[name^="desk_s"]').val(descValue);
                var jmlValue = null;
                $(this).find('input[name^="jml_s"]').val(jmlValue);

                // Mengisi nilai groupid
                $(this).find('input[name^="kode_s"]').val(null);
            });

            //update cart shoping : 
            var requestData = []; // Bersihkan requestData sebelum mengumpulkan data baru
            $('#tbl_data tbody tr').each(function () {
                var checkbox = $(this).find('input[name^="check"]');
                if (checkbox.is(':checked')) {
                    var id = checkbox.attr('name').replace('check', '');
                    var groupid = null;
                    var groupdesk = null;
                    var groupjml = null;
                    requestData.push({
                        id: id,
                        groupid: groupid,
                        groupdesk: groupdesk,
                        groupjml: groupjml
                    });
                }
            });

            //Kirim data menggunakan AJAX
            $.ajax({
                type: 'POST',
                url: "<?php echo base_url().'admin/penjualan/update_set';?>",
                data: { requestData: JSON.stringify(requestData) }, // Serialize requestData to JSON
                dataType: 'json', // Set dataType to JSON
                success: function (response) {
                    // Lakukan sesuatu dengan respons JSON jika diperlukan
                    //console.log('Response:', response);
                },
                error: function (xhr, status, error) {
                    //console.error('Error:', error);
                }
            });
            // Bersihkan pemilihan pada checkbox
            checkedRows.find('input[name^="check"]').prop('checked', false);
        
    });
</script>


</body>
</html>
