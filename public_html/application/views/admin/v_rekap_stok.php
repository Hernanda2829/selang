<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    // error_reporting(E_ALL);
    // ini_set('display_errors', 1); 
	error_reporting(0);
    $userid=$userid->row_array();
    $data_regid=$userid['reg_id'];
    ?>  
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Produk By <?php echo $userid['co_name'];?>">
    <meta name="author" content="<?php echo $userid['co_name'];?>">

    <title>Rekapitulasi</title>
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
    <!-- Data Table Fixed Columnn -->
    <link href="<?php echo base_url().'assets/js/dataTable/dataTables.bootstrap4.min.css'?>" rel="stylesheet">
    <link href="<?php echo base_url().'assets/js/dataTable/fixedColumns.bootstrap4.min.css'?>" rel="stylesheet">
    
<style>  

   .bootstrap-select .btn {
        font-size: 12px;
    }

    .bootstrap-datetimepicker-widget {
        font-size: 10px; 
    }

    .bootstrap-datetimepicker-widget table {
        line-height: 1 !important; 
    }

    .bootstrap-datetimepicker-widget table th,
    .bootstrap-datetimepicker-widget table td {
        padding: 1px !important; 
    }

   /* .total-bottom {
        position: sticky;
        right: 2;
        background-color: #027c3f;
        z-index: 1;
    } */

    .total-pricelist {
        position: sticky;
        right: 0;
        background-color: #027c3f;
        z-index: 1;
    }

    .grand-total {
      position: sticky;
      left: 0;
      background-color: #027c3f;
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

        <div class="row">
            <div class="col-lg-12">
                <center><?php echo $this->session->flashdata('msg');?></center>
                <form id="myForm" class="form-horizontal" method="post" action="">
                <table class="table table-bordered" style="font-size:12px;margin-bottom:10px;">
                    <tr>
                        <th style="width:7%;vertical-align:middle;border-top-color:white;border-right-color:white;border-left-color:white;">Bulan :</th>
                        <td style="width:15%;vertical-align:middle;border-top-color:white;border-right-color:white;">
                        <select name="cari_bln" id="cari_bln" class="selectpicker show-tick form-control" title="Pilih Bulan Laporan">
                            <option value="" style="font-size: 11px;"></option>
                            <?php foreach ($daftar_bln as $angka => $bulan) {
                                if ($angka == $bln) {
                                    echo '<option selected value="' . $angka . '">' . $bulan . '</option>';
                                } else {
                                    echo '<option value="' . $angka . '">' . $bulan . '</option>';
                                }
                            }
                            ?>
                        </select>
                        </td>
                        <th style="width:6%;vertical-align:middle;border-top-color:white;border-right-color:white;border-left-color:white;">Tahun :</th>
                        <td style="width:11%;vertical-align:middle;border-top-color:white;border-right-color:white;">
                        <select name="cari_thn" id="cari_thn" class="selectpicker show-tick form-control" title="Pilih Tahun">
                            <option value="" style="font-size: 11px;"></option>
                            <?php foreach ($daftar_thn as $tahun) {
                               
                                if ($tahun == $thn) {
                                    echo '<option selected>' . $tahun . '</option>';
                                } else {
                                    echo '<option>' . $tahun . '</option>';
                                }
                            }
                            ?>
                        </select>
                        </td>
                        <td style="width:5%;border-top-color:white;border-right-color:white;">
                            <a class="btn btn-sm btn-info btn-tampil" data-toggle="modal" title="Tampilkan Data"><span class="fa fa-search"></span></a>
                        </td>
                        <td style="width:45%;text-align:right;border-top-color:white;border-right-color:white;">
                            <button class="btn btn-sm btn-info" title="Tampil Cetak Data Akumulasi Stok" onclick="varCetak_Laporan()"><span class="fa fa-print"></span> Cetak Data</button>
                        </td>
                        <td style="width:45%;text-align:right;border-top-color:white;border-right-color:white;">
                            <button class="btn btn-sm btn-success" title="Export ke Excel" onclick="varCetak_Excel()"><span class="fa fa-print"></span> Export Excel</button>
                        </td>
                    </tr>
                </table>
                </form>
            </div>
        </div>
    
       

        <div class="row">
            <div class="col-lg-12">
                <table class="table table-striped table-bordered nowrap" style="font-size:11px;" id="mydata">  
                    <thead>
                        <tr>
                            <th rowspan="2" style="text-align:center;vertical-align:middle;color:white;background-color:#eb1b28;">No</th>
                            <th rowspan="2" style="text-align:center;vertical-align:middle;color:white;background-color:#eb1b28;">Cabang</th>
                            <?php foreach ($kategori as $k): ?>
                                <th colspan="3" style="text-align:center;color:white;background-color:black"><?php echo $k['kategori_nama'];?></th>
                            <?php endforeach; ?>
                            
                            <th rowspan="2" style="text-align:center;vertical-align:middle;color:white;background-color:#027c3f;">Total Bottom</th>
                            <th rowspan="2" style="text-align:center;vertical-align:middle;color:white;background-color:#027c3f;">Total Pricelist</th>
                            <th rowspan="3" style="text-align:center;vertical-align:middle;color:white;background-color:#eb1b28;">Aksi</th>
                        </tr>
                        <tr>
                            <?php foreach ($kategori as $k): ?>
                                <th style="text-align:center;color:#4f81bd;background-color:white">Stok</th>
                                <th style="text-align:center;color:#c0504d;background-color:white">Bottom</th>
                                <th style="text-align:center;color:#9bbb59;background-color:white">Pricelist</th>
                            <?php endforeach; ?>
                        </tr>
                        
                        <tr>
                            <th colspan="2" class="grand-total" style="text-align:right;font-weight:bold;color:white;background-color:#027c3f;">Grand Total</th>
                            <?php 
                            $grandTotalStok = $grandTotalHarpok = $grandTotalHarjul = 0;
                            foreach ($kategori as $k):  
                                $kat = $k['kategori_id'];
                                $totalStok = $totalHarpok = $totalHarjul = 0;
                                foreach ($data->result_array() as $a):
                                    $totalStok += $a['stok_global_' . $kat];
                                    $totalHarpok += $a['Total_Harpok_' . $kat];
                                    $totalHarjul += $a['Total_Harjul_' . $kat];
                                endforeach;
                                $grandTotalStok += $totalStok;
                                $grandTotalHarpok += $totalHarpok;
                                $grandTotalHarjul += $totalHarjul;
                                ?>
                                <th style="text-align:right;font-weight:bold;color:white;background-color:#027c3f"><?php echo str_replace(',', '.', number_format($totalStok));?></th>
                                <th style="text-align:right;font-weight:bold;color:white;background-color:#027c3f"><?php echo 'Rp ' . str_replace(',', '.', number_format($totalHarpok));?></th>
                                <th style="text-align:right;font-weight:bold;color:white;background-color:#027c3f"><?php echo 'Rp ' . str_replace(',', '.', number_format($totalHarjul));?></th>
                            <?php endforeach; ?>
                                <!-- Tambahkan dua kolom di samping kanan -->
                                <th style="text-align:right;font-weight:bold;color:white;background-color:#027c3f"><?php echo 'Rp ' . str_replace(',', '.', number_format($grandTotalHarpok));?></th>
                                <th style="text-align:right;font-weight:bold;color:white;background-color:#027c3f"><?php echo 'Rp ' . str_replace(',', '.', number_format($grandTotalHarjul));?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no = 0;
                        foreach ($data->result_array() as $a):
                            $no++;
                            $id = $a['reg_id'];
                            $cab = $a['reg_name'];
                        ?>
                            <tr>
                                <td style="text-align:center;"><?php echo $no;?></td>
                                <td><?php echo $cab;?></td>
                                <?php 
                                $totalStok = $totalHarpok = $totalHarjul = 0;
                                foreach ($kategori as $k):  
                                    $kat = $k['kategori_id'];
                                    $totalStok += $a['stok_global_' . $kat];
                                    $totalHarpok += $a['Total_Harpok_' . $kat];
                                    $totalHarjul += $a['Total_Harjul_' . $kat];
                                ?>
                                    <td style="text-align:right;"><?php echo str_replace(',', '.', number_format($a['stok_global_' . $kat]));?></td>
                                    <td style="text-align:right;"><?php echo 'Rp ' . str_replace(',', '.', number_format($a['Total_Harpok_' . $kat]));?></td>
                                    <td style="text-align:right;"><?php echo 'Rp ' . str_replace(',', '.', number_format($a['Total_Harjul_' . $kat]));?></td>
                                <?php endforeach; ?>

                                <td style="text-align:right;background-color:#f2f2f2;"><?php echo 'Rp ' . str_replace(',', '.', number_format($totalHarpok));?></td>
                                <td style="text-align:right;background-color:#f2f2f2;"><?php echo 'Rp ' . str_replace(',', '.', number_format($totalHarjul));?></td>
                                <td style="text-align:center;">
                                    <a class="btn btn-xs btn-warning btn-lihat" href="#modalLihat" data-toggle="modal" data-regid="<?= $id ;?>" data-nmcab="<?= $cab ;?>" title="Lihat Data"><span class="fa fa-edit"></span> Lihat Data</a>
                                </td>
                            </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
            </div>
        </div>


                 
        <!-- ============ MODAL Lihat Data =============== -->
        <div class="modal fade" id="modalLihat" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
            <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 class="modal-title" id="myModalLabel"><small>Data Barang Kantor - <span id="nmCabVal"></span></small></h3>
            </div>
            <form id="myForm2" class="form-horizontal" method="post" action="">
            <div class="modal-body" style="overflow:scroll;height:450px;"> 
                <table style="font-size:12px;margin-bottom:10px;">
                    <tr>
                        <input type="hidden" id="txtregid" name="txtregid">
                        <input type="hidden" id="txtnmcab" name="txtnmcab">
                        <input type="hidden" id="txtbln" name="txtbln">
                        <input type="hidden" id="txtthn" name="txtthn">
                        <input type="hidden" id="txtcarikat" name="txtcarikat">
                        <input type="hidden" id="txtcekstok" name="txtcekstok">

                        <th style="width:10%;vertical-align:middle;">Pilih Kategori :</th>
                        <td style="width:20%;vertical-align:middle;border-top-color:white;border-right-color:white;">
                        <select name="cari_kat" id="cari_kat" class="selectpicker show-tick form-control" title="Pilih Kategori Produk">
                            <option value="" style="font-size: 11px;"></option>
                            <?php foreach ($kategori as $kt) {
                                $id_kat = $kt['kategori_id'];
                                $nm_kat = $kt['kategori_nama']; 
                                echo '<option value="' . $id_kat . '">' . $nm_kat . '</option>';
                                
                            }
                            ?>
                        </select>
                        </td>
                        <td style="width:10%;vertical-align:middle;padding-left:10px;">
                            <a class="btn btn-sm btn-info btn-cariproduk" data-toggle="modal" title="Tampilkan Data"><span class="fa fa-search"></span></a>
                        </td>
                        <td style="width:50%;text-align:right;border-top-color:white;border-right-color:white;">
                            <button class="btn btn-sm btn-info" title="Tampil Cetak Data Produk" onclick="varCetak_Produk()" style="font-size:11px;"><span class="fa fa-print"></span> Cetak Data</button>
                            <button class="btn btn-sm btn-success" title="Export ke Excel" onclick="varCetak_Produk_Excel()" style="font-size:11px;"><span class="fa fa-print"></span> Export Excel</button>
                        </td>
                    </tr>
                </table>
                <hr style="margin-top:10px;">
                <table id="tbl_barang" class="table table-bordered table-condensed" style="font-size:11px;">
                    <thead>
                        <tr>
                            <th style="text-align:center;vertical-align:middle;background-image:none!important" data-orderable="false">No</th>
                            <th style="text-align:center;vertical-align:middle;" data-orderable="false">Kode Barang</th>
                            <th style="text-align:center;vertical-align:middle;" data-orderable="false">Nama Barang</th>
                            <th style="text-align:center;vertical-align:middle;" data-orderable="false">Sat uan</th>
                            <th style="text-align:center;vertical-align:middle;" data-orderable="false">Harga Bottom</th>
                            <th style="text-align:center;vertical-align:middle;" data-orderable="false">Harga Pricelist</th>
                            <th style="text-align:center;vertical-align:middle;" data-orderable="false">Stok</th>
                            <th style="text-align:center;vertical-align:middle;" data-orderable="false">Total Bottom</th>
                            <th style="text-align:center;vertical-align:middle;" data-orderable="false">Total Pricelist</th>
                            <th style="text-align:center;vertical-align:middle;" data-orderable="false">Kat egori</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>                          
            </div>
                <div class="modal-footer" style="display: flex; align-items: center; justify-content: space-between;">
                    <td style="display: flex; text-align: left;"><input id="cekbox" name="cekbox" type="checkbox" title="Centang kotak ini jika ingin menampilkan semua kode produk dengan nilai kurang dari atau sama dengan nol"><span style="padding-left:10px"> Tampilkan Semua Kode Produk Barang ( Stok <= 0 ) </span></td>
                    <div style="display: flex; margin-left: auto;">
                        <button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
                    </div>
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
    <script src="<?php echo base_url().'assets/js/moment.js'?>"></script>
    <!-- Data Table Fixed Column-->
    <script src="<?php echo base_url().'assets/js/dataTable/jquery-3.6.3.min.js'?>"></script>
    <script src="<?php echo base_url().'assets/js/dataTable/bootstrap-datetimepicker.min.js'?>"></script>
    <script src="<?php echo base_url().'assets/js/dataTable/jquery-ui.min.js'?>"></script>
    <script src="<?php echo base_url().'assets/js/dataTable/jquery-1.11.5.dataTables.min.js'?>"></script>
    <script src="<?php echo base_url().'assets/js/dataTable/dataTables.fixedColumns.min.js'?>"></script>


<script type="text/javascript">  
$(document).ready(function() {
    var table = $('#mydata').DataTable({
        scrollY: "500px",
        scrollX: true,
        scrollCollapse: true,
        paging: true,
        fixedColumns: {
            left: 2,
            right: 1
        },
        ordering: false
  
    });
});
</script>
  
<script type="text/javascript">
$(document).ready(function () {
    $(document).on('click', '.btn-tampil', function () {
        var form = document.querySelector('#myForm'); 
        form.action = "<?php echo base_url().'admin/rekap_stok/tampil_rekap';?>"; 
        form.target = '_self';
        form.submit(); // Mengirimkan formulir
    });
});
</script>

<script>
    function varCetak_Laporan() {
        var form = document.querySelector('#myForm'); 
        form.action = "<?php echo base_url().'admin/rekap_stok/cetak_rekap';?>";
        form.target = '_blank';
        form.submit(); // Mengirimkan formulir
    }
    function varCetak_Excel() {
        var form = document.querySelector('#myForm'); 
        form.action = "<?php echo base_url().'admin/rekap_stok/cetak_rekap_excel';?>";
        //form.target = '_blank';
        form.submit(); // Mengirimkan formulir
    }
    function varCetak_Produk() {
        var form = document.querySelector('#myForm2'); 
        form.action = "<?php echo base_url().'admin/rekap_stok/cetak_produk';?>";
        form.target = '_blank';
        form.submit(); // Mengirimkan formulir
    }
    function varCetak_Produk_Excel() {
        var form = document.querySelector('#myForm2'); 
        form.action = "<?php echo base_url().'admin/rekap_stok/cetak_produk_excel';?>";
        //form.target = '_blank';
        form.submit(); // Mengirimkan formulir
    }

</script>

<script type="text/javascript">
$(document).ready(function () {
    $(document).on('click', '.btn-lihat', function() {
        var cari_bln = $('#cari_bln option:selected').val();
        var cari_thn = $('#cari_thn option:selected').val();
        var regid = $(this).data('regid');
        var nmcab = $(this).data('nmcab');
        var carikat = '';
        var cekstok = 0;
        $('#txtbln').val(cari_bln); //utk nge post cetak
        $('#txtthn').val(cari_thn); //utk nge post cetak
        $('#txtcarikat').val(carikat); //utk nge post cetak
        $('#txtcekstok').val(cekstok); //utk nge post cetak
        $('#txtregid').val(regid);
        $('#txtnmcab').val(nmcab);
        $('#nmCabVal').text(nmcab);
        tampil_data(carikat,cekstok);
    });

    function tampil_data(carikat, cekstok) {
        var cari_bln = $('#cari_bln option:selected').val();
        var cari_thn = $('#cari_thn option:selected').val();
        var regid = $('#txtregid').val();
        $('#tbl_barang tbody').empty();
        $('#tbl_barang').DataTable().clear().destroy();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('admin/rekap_stok/tampil_barang'); ?>",
            data: {
                cari_bln: cari_bln,
                cari_thn: cari_thn,
                regid: regid,
                carikat: carikat,
                cekstok: cekstok
            },
            dataType: 'json',
            success: function (data) {
                // console.log(regid);
                // console.log(carikat);
                // console.log(cekstok);
                if (data.length === 0) {
                    //console.log("No data found.");
                } else {
                    var no = 0;
                    $.each(data, function (index, item) {
                        no++;
                        var harpok = parseFloat(item.barang_harpok);
                        var harjul = parseFloat(item.barang_harjul);
                        var totharpok = parseFloat(item.Total_Harpok);
                        var totharjul = parseFloat(item.Total_Harjul);
                        var stok = parseFloat(item.stok_cabang);
                        var formatted_stok;
                        if (Math.floor(stok) === stok) {
                            formatted_stok = stok.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ','); // Format sebagai bilangan bulat
                        } else {
                            formatted_stok = stok.toFixed(2).replace('.', ',').replace(/\.?0+$/, '').replace(/\B(?=(\d{3})+(?!\d))/g, ','); // Format sebagai bilangan desimal
                        }
                        var newRow = '<tr>' +
                            '<td style="width:2%;text-align:center;">' + no + '</td>' +
                            '<td style="width:10%;">' + item.barang_id + '</td>' +
                            '<td style="width:21%;">' + item.barang_nama + '</td>' +
                            '<td style="width:2%;text-align:center;">' + item.barang_satuan + '</td>' +
                            '<td style="width:12%;text-align:right;">' + harpok.toLocaleString('id-ID') + '</td>' +
                            '<td style="width:12%;text-align:right;">' + harjul.toLocaleString('id-ID') + '</td>' +
                            '<td style="width:9%;text-align:center;">' + formatted_stok + '</td>' +
                            '<td style="width:15%;text-align:right;">' + totharpok.toLocaleString('id-ID') + '</td>' +
                            '<td style="width:15%;text-align:right;">' + totharjul.toLocaleString('id-ID') + '</td>' +
                            '<td style="width:2%;text-align:center;">' + item.barang_kategori_nama + '</td>' +
                            '</tr>';
                        $('#tbl_barang tbody').append(newRow);   
                    });


                    // Inisialisasi DataTable di sini, cukup sekali saja
                    $('#tbl_barang').DataTable();
                } 
            },
            error: function(xhr, status, error) {
                //console.log(error);
            }    
        });
    }

    $('.btn-cariproduk').on('click', function () {
        var cari = $('#cari_kat option:selected').val();
        var cariVal = $('#cari_kat option:selected').text();
        var cek = $('input[name="cekbox"]:checked');
        var carikat = cari === "" ? "" : cariVal;
        var cekstok = cek.length === 0 ? 0 : 1; 
        $('#txtcarikat').val(carikat); //utk nge post cetak
        $('#txtcekstok').val(cekstok); //utk nge post cetak
        tampil_data(carikat, cekstok);

    });
    
    
});    
</script>





</body>
</html>
