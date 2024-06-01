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
    <title>Data Request Stok</title>
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
                <center><?php echo $this->session->flashdata('msg');?></center>
                <h3 class="page-header">Data
                    <small>Request Stok Barang</small>
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
                        <th style="text-align:center;width:40px;">No</th>
                        <th style="text-align:center;">No Request</th>
                        <th style="text-align:center;">Tanggal Request</th>
                        <th style="text-align:center;">Kantor Cabang (user) </th>
                        <th style="width:200px;text-align:center;" data-orderable="false">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                    $no=0;
                    foreach ($data->result_array() as $a):
                        $no++;
                        $id=$a['req_stok_no'];
                        $tgl=$a['req_stok_tgl'];
                        $usr=$a['created_by'];
                        $rgnm=$a['reg_name'];
                        $ps=$a['proses_stok'];
                        $pk=$a['proses_kirim'];
                        $ts=$a['total_selisih'];
                ?>
                    <tr>
                        <td style="text-align:center;"><?php echo $no;?></td>
                        <td><?php echo $id;?></td>
                        <td><?php echo $tgl;?></td>
                        <td><?php echo $rgnm. '- (' .$usr.')';?></td>
                        <td style="text-align:center;">
                        <?php
                        if ($pk==0) {
                            echo '<a class="btn btn-xs btn-warning" href="#modalKirimStok'.$id.'" data-toggle="modal" title="Lihat Detail Request"><span class="fa fa-book"></span> Proses Kirim</a> ';
                        }else{
                            if ($ps==0) {
                                echo '<a class="btn btn-xs btn-success" href="#modalLihat'.$id.'" data-toggle="modal" title="Lihat Konfirmasi Request"><span class="fa fa-book"></span> Menunggu Konfirm</a> ';
                            }else{
                                if ($ts==0) {
                                    echo '<a class="btn btn-xs btn-info" href="#modalKomplit'.$id.'" data-toggle="modal" title="Lihat Status Komplit"><span class="fa fa-book"></span> Status Komplit</a> ';
                                }else {
                                    echo '<a class="btn btn-xs btn-danger" href="#modalKomplit'.$id.'" data-toggle="modal" title="Status Komplit dengan Total Selisih : '.$ts.'"><span class="fa fa-book"></span> Status Komplit</a> ';
                                }
                            }
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
        <!-- ============ MODAL Kirim Stok =============== -->
        <?php
            foreach ($data->result_array() as $a) {
            $id=$a['req_stok_no'];
            $tgl=$a['req_stok_tgl'];
            $usr=$a['created_by'];
            $rgnm=$a['reg_name'];
            $pk=$a['proses_kirim'];    
        ?>
        <div class="modal fade" id="modalKirimStok<?php echo $id?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
            <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 class="modal-title" id="myModalLabel">Proses Kirim - Request Stok Barang - <small>Kantor Cabang <?php echo $rgnm.' - ('.$usr.')' ;?></small></h3>
            </div>    
            <div class="modal-body" style="overflow:scroll;height:400px;">  
                <table id="tabelStok" class="table table-bordered table-condensed" style="font-size:11px;">
                    <thead>
                        <tr>
                            <th style="text-align:center;">No</th>
                            <th style="text-align:center;">Qty Kirim</th>
                            <th style="text-align:center;">Qty Request</th>
                            <th style="text-align:center;">Kode Barang</th>
                            <th style="text-align:center;">Nama Barang</th>
                            <th style="text-align:center;">Satuan</th>
                            <th style="text-align:center;">Kategori</th>
                            <th style="text-align:center;">Stok Tersedia</th>    
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no=0;
                        $data_reqstok=$this->M_stok->get_reqstok($id);
                        foreach ($data_reqstok->result_array() as $q):
                            $no++;
                            $noid=$q['d_req_stok_id'];
                            $kd=$q['d_barang_id'];
                            $nm=$q['d_barang_nama'];
                            $sat=$q['d_barang_satuan'];
                            $kat=$q['d_kategori_nama'];
                            $req_qty=$q['d_req_stok_qty'];
                            $stok=$q['stok_cabang']; 
                        ?>
                    <tr>
                        <?php
                        
                        if (floor($stok) == $stok) {
                            $formatted_stok = number_format($stok, 0, ',', '.');
                        } else {
                            $formatted_stok = number_format($stok, 2, ',', '.');
                            $formatted_stok = rtrim($formatted_stok, '0');
                            $formatted_stok = rtrim($formatted_stok, ',');
                        }
                        ?> 
                        <td style="text-align:center;"><?php echo $no?>
                        <input type="hidden" name="nofak<?php echo $noid?>" value="<?php echo $id?>">
                        <input type="hidden" name="kode<?php echo $noid?>" value="<?php echo $noid?>">
                        </td>
                        <?php 
                        if (floor($req_qty) == $req_qty) {
                            $formatted_req_qty = number_format($req_qty, 0, ',', '.');
                        } else {
                            $formatted_req_qty = number_format($req_qty, 2, ',', '.');
                            $formatted_req_qty = rtrim($formatted_req_qty, '0');
                            $formatted_req_qty = rtrim($formatted_req_qty, ',');
                        }
                        if ($req_qty > $stok) {
                            echo '<td style="text-align:center;"><input type="text" name="qty'.$noid.'" style="width:70px;" value="'.$formatted_stok.'" min="0" max="'.$formatted_stok.'" required></td>';
                        }else{
                            echo '<td style="text-align:center;"><input type="text" name="qty'.$noid.'" style="width:70px;" value="'.$formatted_req_qty.'" min="0" max="'.$formatted_stok.'" required></td>';
                        }
                        ?>
                        <td style="text-align:center;"><?php echo $formatted_req_qty?></td>
                        <td><?php echo $kd;?></td>
                        <td><?php echo $nm;?></td>
                        <td style="text-align:center;"><?php echo $sat?></td>
                        <td style="text-align:center;"><?php echo $kat?></td>
                        <td style="text-align:center;"><?php echo $formatted_stok?></td>
                                   
                    </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>          
                </div>
                
                <div class="modal-footer" style="display: flex; align-items: center; justify-content: space-between;">
                    <td style="display: flex; text-align: left;"><input id="cekbox" name="cekbox" type="checkbox"><span style="padding-left:10px"> Kosongkan Isi Quantity Kirim</span></td>

                    <div style="display: flex; margin-left: auto;">
                        <a class="btn btn-info btn-cetak" data-norequest="<?= $id ;?>" id="cetakLink"><span class="fa fa-print"></span> Cetak Request</a>
                        <button type="button" class="btn btn-info" onclick="simpanKirimStok(this)">Simpan</button>
                        <button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
                    </div>
                </div>

            

            </div>
            </div>
        </div>
        <?php
        }
        ?>
        <!-- ============ MODAL Lihat =============== -->
        <?php
            foreach ($data->result_array() as $a) {
            $id=$a['req_stok_no'];
            $tgl=$a['req_stok_tgl'];
            $usr=$a['created_by'];
            $rgnm=$a['reg_name'];
            $pk=$a['proses_kirim'];    
            $ps=$a['proses_stok'];
        ?>
        <div class="modal fade" id="modalLihat<?php echo $id?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
            <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 class="modal-title" id="myModalLabel">Menunggu Konfirm - Request Stok Barang - <small> Kantor Cabang <?php echo $rgnm.' - ('.$usr.')' ;?></small></h3>
            </div>    
            <div class="modal-body" style="overflow:scroll;height:400px;">
            <p style="font-size:11px;margin-bottom:0;"><b>No Faktur : <?php echo $id?></b></p>  
                <table class="table table-bordered table-condensed" style="font-size:11px;">
                    <thead>
                        <tr>
                            <th style="text-align:center;">No</th>
                            <th style="text-align:center;">Qty Request</th>
                            <th style="text-align:center;">Qty Kirim</th>
                            <th style="text-align:center;">Qty Konfirm</th>
                            <th style="text-align:center;">Qty Selisih</th>
                            <th style="text-align:center;">Kode Barang</th>
                            <th style="text-align:center;">Nama Barang</th>
                            <th style="text-align:center;">Satuan</th>
                            <th style="text-align:center;">Kategori</th> 
                            <th style="text-align:center;">Aksi</th>         
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no=0;
                        $data_reqstok=$this->M_stok->get_reqstok($id);
                        foreach ($data_reqstok->result_array() as $q):
                            $no++;
                            $noid=$q['d_req_stok_id'];
                            $kd=$q['d_barang_id'];
                            $nm=$q['d_barang_nama'];
                            $sat=$q['d_barang_satuan'];
                            $kat=$q['d_kategori_nama'];
                            $req_qty=$q['d_req_stok_qty'];
                            $k_qty=$q['kirim_qty'];
                            $kon_qty=$q['konfirm_qty'];
                            $s_qty=$q['selisih_qty'];        
                        ?>
                    <tr>
                        <td style="text-align:center;"><?php echo $no?></td>
                        <?php 
                        if (floor($req_qty) == $req_qty) {
                            $formatted_req_qty = number_format($req_qty, 0, ',', '.');
                        } else {
                            $formatted_req_qty = number_format($req_qty, 2, ',', '.');
                            $formatted_req_qty = rtrim($formatted_req_qty, '0');
                            $formatted_req_qty = rtrim($formatted_req_qty, ',');
                        }
                        if (floor($k_qty) == $k_qty) {
                            $formatted_k_qty = number_format($k_qty, 0, ',', '.');
                        } else {
                            $formatted_k_qty = number_format($k_qty, 2, ',', '.');
                            $formatted_k_qty = rtrim($formatted_k_qty, '0');
                            $formatted_k_qty = rtrim($formatted_k_qty, ',');
                        }
                        if (floor($kon_qty) == $kon_qty) {
                            $formatted_kon_qty = number_format($kon_qty, 0, ',', '.');
                        } else {
                            $formatted_kon_qty = number_format($kon_qty, 2, ',', '.');
                            $formatted_kon_qty = rtrim($formatted_kon_qty, '0');
                            $formatted_kon_qty = rtrim($formatted_kon_qty, ',');
                        }
                        if (floor($s_qty) == $s_qty) {
                            $formatted_s_qty = number_format($s_qty, 0, ',', '.');
                        } else {
                            $formatted_s_qty = number_format($s_qty, 2, ',', '.');
                            $formatted_s_qty = rtrim($formatted_s_qty, '0');
                            $formatted_s_qty = rtrim($formatted_s_qty, ',');
                        }
                        if ($req_qty==$k_qty) {
                            echo '<td style="text-align:center;">' . $formatted_req_qty . '</td>';
                        }else{
                            echo '<td style="text-align:center;color:orange;">' . $formatted_req_qty . '</td>';
                        } 
                        if ($k_qty==$kon_qty) {
                            echo '<td style="text-align:center;">' . $formatted_k_qty . '</td>';
                        }else{
                            echo '<td style="text-align:center;color:orange;">' . $formatted_k_qty . '</td>';
                        }
                        if ($k_qty==$kon_qty) {
                            echo '<td style="text-align:center;">' . $formatted_kon_qty . '</td>';
                        }else{
                            echo '<td style="text-align:center;color:red;">' . $formatted_kon_qty . '</td>';
                        }
                        if ($s_qty==0) {
                            echo '<td style="text-align:center;">' . $formatted_s_qty . '</td>';
                        }else{
                            echo '<td style="text-align:center;background-color:red;">' . $formatted_s_qty . '</td>';
                        }
                        ?>
                        <td><?php echo $kd;?></td>
                        <td><?php echo $nm;?></td>
                        <td style="text-align:center;"><?php echo $sat?></td>
                        <td style="text-align:center;"><?php echo $kat?></td>
                        <td style="text-align:center;">
                        <a class="btn btn-xs btn-warning" href="#modalEdit<?php echo $noid?>" data-toggle="modal" title="Edit Quantity Kirim" id="editButton"><span class="fa fa-pencil"></span></a>                          
                        </td>
                    </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>          
                </div>
                <div class="modal-footer">
                    <button class="btn" data-dismiss="modal" aria-hidden="true" onclick="refreshPage()">Tutup</button>
                </div>
            </div>
            </div>
        </div>
        <?php
        }
        ?>
        <!-- ============ MODAL Edit =============== -->
       <?php
            foreach ($data->result_array() as $a) {
            $id=$a['req_stok_no'];
            $tgl=$a['req_stok_tgl'];
            $usr=$a['created_by'];
                $data_reqstok=$this->M_stok->get_reqstok($id);
                    foreach ($data_reqstok->result_array() as $q):
                        $no++;
                        $noid=$q['d_req_stok_id'];
                        $kd=$q['d_barang_id'];
                        $nm=$q['d_barang_nama'];
                        $sat=$q['d_barang_satuan'];
                        $kat=$q['d_kategori_nama'];
                        $kir_qty=$q['kirim_qty'];
                        $stok=$q['stok_cabang'];

        ?>        
                <div id="modalEdit<?php echo $noid?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
                    <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h3 class="modal-title" id="myModalLabel">Edit Request Stok - Quantity Kirim</h3>
                    </div>
                    <form id="formEditD<?php echo $noid; ?>" class="form-horizontal" onsubmit="updateData(event, '<?php echo $noid; ?>', '<?php echo $id; ?>')" method="post" action="<?php echo base_url().'admin/stok/edit_detailstok_kirim'?>">
                        <div class="modal-body">
                            <input name="kode" type="hidden" value="<?php echo $noid;?>">
                            <input name="stok_no" type="hidden" value="<?php echo $id;?>">
                            <input name="kd_brg" type="hidden" value="<?php echo $kd;?>">
                            <div class="form-group">
                                <label class="control-label col-xs-3" >Kode Barang</label>
                                <div class="col-xs-9">
                                    <input name="kd" class="form-control" type="text" value="<?php echo $kd;?>" style="width:280px;" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-xs-3" >Nama Barang</label>
                                <div class="col-xs-9">
                                    <input name="nm" class="form-control" type="text" value="<?php echo $nm;?>" style="width:280px;" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-xs-3" >Satuan</label>
                                <div class="col-xs-9">
                                    <input name="sat" class="form-control" type="text" value="<?php echo $sat;?>" style="width:280px;" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-xs-3" >Kategori</label>
                                <div class="col-xs-9">
                                    <input name="kat" class="form-control" type="text" value="<?php echo $kat;?>" style="width:280px;" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-xs-3" >Stok Tersedia</label>
                                <div class="col-xs-9">
                                <?php
                                    if (floor($stok) == $stok) {
                                        $formatted_stok = number_format($stok, 0, ',', '.');
                                    } else {
                                        $formatted_stok = number_format($stok, 2, ',', '.');
                                        $formatted_stok = rtrim($formatted_stok, '0');
                                        $formatted_stok = rtrim($formatted_stok, ',');
                                    }
                                    echo '<input name="stok_qty" class="form-control" type="text" value="'.$formatted_stok.'" style="width:280px;" readonly>';
                                ?> 
                                </div>
                            </div>
                            

                            <div class="form-group">
                                <label class="control-label col-xs-3" >Qty Kirim</label>
                                <div class="col-xs-9">
                                    <?php 
                                    if (floor($kir_qty) == $kir_qty) {
                                        $formatted_kir_qty = number_format($kir_qty, 0, ',', '.');
                                    } else {
                                        $formatted_kir_qty = number_format($kir_qty, 2, ',', '.');
                                        $formatted_kir_qty = rtrim($formatted_kir_qty, '0');
                                        $formatted_kir_qty = rtrim($formatted_kir_qty, ',');
                                    }
                                    $max_qty=$kir_qty + $stok;
                                    if (floor($max_qty) == $max_qty) {
                                        $formatted_max_qty = number_format($max_qty, 0, ',', '.');
                                    } else {
                                        $formatted_max_qty = number_format($max_qty, 2, ',', '.');
                                        $formatted_max_qty = rtrim($formatted_max_qty, '0');
                                        $formatted_max_qty = rtrim($formatted_max_qty, ',');
                                    }
                                    echo '<input name="kir_qty" class="form-control" type="text" value="'.$formatted_kir_qty.'" style="width:280px;" min="0" max="'.$formatted_max_qty.'" required>';
                                    ?>    
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
            <?php endforeach;?> 
        <?php
        }
        ?>

        <!-- ============ MODAL Komplit=============== -->
        <?php
            foreach ($data->result_array() as $a) {
            $id=$a['req_stok_no'];
            $tgl=$a['req_stok_tgl'];
            $usr=$a['created_by'];
            $rgnm=$a['reg_name'];
            $pk=$a['proses_kirim'];    
        ?>
        <div class="modal fade" id="modalKomplit<?php echo $id?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
            <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 class="modal-title" id="myModalLabel">Status Komplit - Request Stok Barang - <small> Kantor Cabang <?php echo $rgnm.' - ('.$usr.')' ;?></small></h3>
            </div>    
            <div class="modal-body" style="overflow:scroll;height:400px;">  
                <table class="table table-bordered table-condensed" style="font-size:11px;">
                    <thead>
                        <tr>
                            <th style="text-align:center;">No</th>
                            <th style="text-align:center;">Qty Request</th>
                            <th style="text-align:center;">Qty Kirim</th>
                            <th style="text-align:center;">Qty Konfirm</th>
                            <th style="text-align:center;">Qty Selisih</th>
                            <th style="text-align:center;">Kode Barang</th>
                            <th style="text-align:center;">Nama Barang</th>
                            <th style="text-align:center;">Satuan</th>
                            <th style="text-align:center;">Kategori</th>         
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no=0;
                        $data_reqstok=$this->M_stok->get_reqstok($id);
                        foreach ($data_reqstok->result_array() as $q):
                            $no++;
                            $noid=$q['d_req_stok_id'];
                            $kd=$q['d_barang_id'];
                            $nm=$q['d_barang_nama'];
                            $sat=$q['d_barang_satuan'];
                            $kat=$q['d_kategori_nama'];
                            $req_qty=$q['d_req_stok_qty'];
                            $k_qty=$q['kirim_qty'];
                            $kon_qty=$q['konfirm_qty'];
                            $s_qty=$q['selisih_qty'];        
                        ?>
                    <tr>
                        <td style="text-align:center;"><?php echo $no?></td>
                        <?php 
                        if (floor($req_qty) == $req_qty) {
                            $formatted_req_qty = number_format($req_qty, 0, ',', '.');
                        } else {
                            $formatted_req_qty = number_format($req_qty, 2, ',', '.');
                            $formatted_req_qty = rtrim($formatted_req_qty, '0');
                            $formatted_req_qty = rtrim($formatted_req_qty, ',');
                        }
                        if (floor($k_qty) == $k_qty) {
                            $formatted_k_qty = number_format($k_qty, 0, ',', '.');
                        } else {
                            $formatted_k_qty = number_format($k_qty, 2, ',', '.');
                            $formatted_k_qty = rtrim($formatted_k_qty, '0');
                            $formatted_k_qty = rtrim($formatted_k_qty, ',');
                        }
                        if (floor($kon_qty) == $kon_qty) {
                            $formatted_kon_qty = number_format($kon_qty, 0, ',', '.');
                        } else {
                            $formatted_kon_qty = number_format($kon_qty, 2, ',', '.');
                            $formatted_kon_qty = rtrim($formatted_kon_qty, '0');
                            $formatted_kon_qty = rtrim($formatted_kon_qty, ',');
                        }
                        if (floor($s_qty) == $s_qty) {
                            $formatted_s_qty = number_format($s_qty, 0, ',', '.');
                        } else {
                            $formatted_s_qty = number_format($s_qty, 2, ',', '.');
                            $formatted_s_qty = rtrim($formatted_s_qty, '0');
                            $formatted_s_qty = rtrim($formatted_s_qty, ',');
                        }
                        if ($req_qty==$k_qty) {
                            echo '<td style="text-align:center;">' . $formatted_req_qty . '</td>';
                        }else{
                            echo '<td style="text-align:center;color:orange;">' . $formatted_req_qty . '</td>';
                        } 
                        if ($k_qty==$kon_qty) {
                            echo '<td style="text-align:center;">' . $formatted_k_qty . '</td>';
                        }else{
                            echo '<td style="text-align:center;color:orange;">' . $formatted_k_qty . '</td>';
                        }
                        if ($k_qty==$kon_qty) {
                            echo '<td style="text-align:center;">' . $formatted_kon_qty . '</td>';
                        }else{
                            echo '<td style="text-align:center;color:red;">' . $formatted_kon_qty . '</td>';
                        }
                        if ($s_qty==0) {
                            echo '<td style="text-align:center;">' . $formatted_s_qty . '</td>';
                        }else{
                            echo '<td style="text-align:center;background-color:red;">' . $formatted_s_qty . '</td>';
                        }
                        ?>
                        <td><?php echo $kd;?></td>
                        <td><?php echo $nm;?></td>
                        <td style="text-align:center;"><?php echo $sat?></td>
                        <td style="text-align:center;"><?php echo $kat?></td>                          
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
$(document).ready(function() {
    $(document).on('input', 'input[name^="qty"]', function(e) {
        var inputValue = e.target.value;
        //var sanitizedValue = inputValue.replace(/[^0-9,\b\t]/g, ''); // Hapus karakter yang tidak diizinkan (selain angka, koma, backspace, delete, dan tab)
        var sanitizedValue = inputValue.replace(/[^\d,\b\t]/g, '')
        e.target.value = sanitizedValue; // Update nilai input dengan karakter yang diizinkan
    });

    $(document).on('input', 'input[name^="kir_qty"]', function(e) {
        var inputValue = e.target.value;
        //var sanitizedValue = inputValue.replace(/[^0-9,\b\t]/g, ''); // Hapus karakter yang tidak diizinkan (selain angka, koma, backspace, delete, dan tab)
        var sanitizedValue = inputValue.replace(/[^\d,\b\t]/g, '')
        e.target.value = sanitizedValue; // Update nilai input dengan karakter yang diizinkan
    });

    //membatasi input qty sesuai stok yang tersedia
    var inputElements = document.querySelectorAll('input[name^="qty"]');
    inputElements.forEach(function(inputElement) {
        inputElement.addEventListener('input', function() {
            //var value = parseFloat(this.value);
            var min = parseFloat(this.min);
            var value = parseFloat(this.value.replace(',', '.'));
            var max = parseFloat(this.max.replace(',', '.'));
            if (isNaN(value)) {
                this.value = this.min;
            } else if (value < this.min) {
                this.value = this.min;
            } else if (value > max) {
                this.value = this.max;
            }
        });
    });

    //membatasi input qty sesuai stok yang tersedia
    var inputElements = document.querySelectorAll('input[name^="kir_qty"]');
    inputElements.forEach(function(inputElement) {
        inputElement.addEventListener('input', function() {
            //var value = parseFloat(this.value);
            var min = parseFloat(this.min);
            var value = parseFloat(this.value.replace(',', '.'));
            var max = parseFloat(this.max.replace(',', '.'));
            if (isNaN(value)) {
                this.value = this.min;
            } else if (value < this.min) {
                this.value = this.min;
            } else if (value > max) {
                this.value = this.max;
            }
        });
    });

});
</script>


<script type="text/javascript">
    function updateData(event, noid, id) {
    event.preventDefault();  // Menghentikan perilaku default form
    var formData = new FormData(event.target); // Dapatkan data dari form
    $.ajax({
        url: event.target.action,
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            $('#modalEdit' + noid).modal('hide');
            $('#modalLihat' + id + ' .modal-dialog').empty();
            $('#modalLihat' + id + ' .modal-dialog').load(location.href + ' #modalLihat' + id + ' .modal-dialog');
        }
    });
    }

    function simpanKirimStok(buttonElement) {
        // Mengumpulkan data dari input dalam tabel
        var data = [];
        var modal = $(buttonElement).closest('.modal'); // Ambil modal yang berisi tombol "Simpan"
        var rows = modal.find('table tbody tr');
        rows.each(function() {
            var row = $(this);
            var nofak = row.find('input[name^="nofak"]').val();
            var kode = row.find('input[name^="kode"]').val();
            var qty = row.find('input[name^="qty"]').val();
            var kode_barang = row.find('td:eq(3)').text(); // Kolom keempat
            var nama_barang = row.find('td:eq(4)').text();
            var satuan = row.find('td:eq(5)').text();
            var kategori = row.find('td:eq(6)').text();
            data.push({
                nofak: nofak,
                kode: kode,
                qty: qty.replace(/,/g, '.'),
                kode_barang: kode_barang,
                nama_barang: nama_barang,
                satuan: satuan,
                kategori: kategori
            });
        });

        // Kirim data ke server dengan AJAX
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url('admin/stok/simpan_kirim_stok');?>",
            data: {
                requestData: data
            },
            success: function(response) {
                // Handle respons dari server jika diperlukan
                var jsonResponse = JSON.parse(response);
                alert(jsonResponse.message);
                modal.modal('hide'); // Menutup modal
                refreshPage();
            },
            error: function(xhr, status, error) {
                // Tangani kesalahan jika diperlukan
                console.error(error);
                alert('Gagal menyimpan data.');
            }
        });
    }
 
    function refreshPage() {
        window.location.reload(); // Memuat ulang halaman
    }

</script>

<script>
    $('input[name^="cekbox"]').on('change', function() {
        if ($(this).prop('checked')) {
            $('input[name^="qty"]').val('');
        }
    });

   $(document).on('click', '.btn-cetak', function() {
        var id = $(this).data('norequest');
        var checkbox = $('input[name="cekbox"]:checked');
        var ket = checkbox.length === 0 ? 'isi' : 'kosong';   
        var path = "<?php echo base_url().'admin/stok/cetak_request/'; ?>" + id;
        var href = path + '/' + ket;
        window.open(href, '_blank');
    });
</script>




</body>
</html>
