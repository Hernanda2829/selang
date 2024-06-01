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
                    <small>Request Stok - <?php echo $userid['reg_code'];?>  <?php echo $userid['reg_name'];?></small>
                    <div class="pull-right"><a href="<?php echo base_url().'admin/stok'?>" class="btn btn-sm btn-success"><span class="fa fa-plus"></span> Buat Request Stok Baru</a></div>
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
                        <th style="text-align:center;">User</th>
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
                        $ps=$a['proses_stok'];
                        $pk=$a['proses_kirim'];
                        $ts=$a['total_selisih'];
                ?>
                    <tr>
                        <td style="text-align:center;"><?php echo $no;?></td>
                        <td><?php echo $id;?></td>
                        <td><?php echo $tgl;?></td>
                        <td><?php echo $usr;?></td>
                        <td style="text-align:center;">                        
                        <?php
                        if ($ps==0) {
                            echo '<a class="btn btn-xs btn-warning" href="#modalLihatStok'.$id.'" data-toggle="modal" title="Lihat Detail Request"><span class="fa fa-book"></span> Tampil Data</a> ';
                            if ($pk==0) {
                                echo '<a class="btn btn-xs btn-danger" href="#modalHapusStok'.$id.'" data-toggle="modal" title="Hapus Request Stok"><span class="fa fa-close"></span> Hapus Data </a>';
                            }else{
                                //echo '<a class="btn btn-xs btn-warning" href="#modalLihatStok'.$id.'" data-toggle="modal" title="Lihat Detail Request"><span class="fa fa-book"></span> Tampil Data</a>';
                                //echo '<label style="padding-left:7px;color:red;"><span class="fa fa-close"></span> Sudah Proses </label>';
                                echo '<a class="btn btn-xs btn-success" href="#modalKonfirmStok'.$id.'" data-toggle="modal" title="Konfirmasi Request Stok"><span class="fa fa-thumbs-up"></span> Konfirm Stok</a> ';
                            }
                        }else{
                            if ($ts==0) {
                                echo '<a class="btn btn-xs btn-info" href="#modalKomplit'.$id.'" data-toggle="modal" title="Lihat Komplit Request"><span class="fa fa-book"></span> Status Komplit</a> ';
                            }else{
                                echo '<a class="btn btn-xs btn-danger" href="#modalKomplit'.$id.'" data-toggle="modal" title="Status Komplit dengan Total Selisih : '.$ts.'"><span class="fa fa-book"></span> Status Komplit</a> ';
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
        <!-- ============ MODAL Komplit =============== -->
        <?php
            foreach ($data->result_array() as $a) {
            $id=$a['req_stok_no'];
            $tgl=$a['req_stok_tgl'];
            $usr=$a['created_by'];   
        ?>
        <div class="modal fade" id="modalKomplit<?php echo $id?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
            <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 class="modal-title" id="myModalLabel">Request Stok Barang - <small><?php echo $userid['reg_code'];?>  <?php echo $userid['reg_name'];?></small></h3>
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
                        <td style="text-align:center;"><?php echo $no;?></td>
                        <?php 
                        if (floor($req_qty) == $req_qty) {
                            $formatted_req_qty = number_format($req_qty, 0, ',', '.');
                        } else {
                            $formatted_req_qty = number_format($req_qty, 2, ',', '.');
                            $formatted_req_qty = rtrim($formatted_req_qty, '0');
                            $formatted_req_qty = rtrim($formatted_req_qty, ',');
                        }
                        if ($req_qty==$k_qty) {
                            echo '<td style="text-align:center;">' . $formatted_req_qty . '</td>';
                        }else{
                            echo '<td style="text-align:center;color:orange;">' . $formatted_req_qty . '</td>';
                        }
                        if (floor($k_qty) == $k_qty) {
                            $formatted_k_qty = number_format($k_qty, 0, ',', '.');
                        } else {
                            $formatted_k_qty = number_format($k_qty, 2, ',', '.');
                            $formatted_k_qty = rtrim($formatted_k_qty, '0');
                            $formatted_k_qty = rtrim($formatted_k_qty, ',');
                        }
                        if ($k_qty==$kon_qty) {
                            echo '<td style="text-align:center;">' . $formatted_k_qty . '</td>';
                        }else{
                            echo '<td style="text-align:center;color:orange;">' . $formatted_k_qty . '</td>';
                        }
                        if (floor($kon_qty) == $kon_qty) {
                            $formatted_kon_qty = number_format($kon_qty, 0, ',', '.');
                        } else {
                            $formatted_kon_qty = number_format($kon_qty, 2, ',', '.');
                            $formatted_kon_qty = rtrim($formatted_kon_qty, '0');
                            $formatted_kon_qty = rtrim($formatted_kon_qty, ',');
                        }
                        if ($k_qty==$kon_qty) {
                            echo '<td style="text-align:center;">' . $formatted_kon_qty . '</td>';
                        }else{
                            echo '<td style="text-align:center;color:red;">' . $formatted_kon_qty . '</td>';
                        }
                        if (floor($s_qty) == $s_qty) {
                            $formatted_s_qty = number_format($s_qty, 0, ',', '.');
                        } else {
                            $formatted_s_qty = number_format($s_qty, 2, ',', '.');
                            $formatted_s_qty = rtrim($formatted_s_qty, '0');
                            $formatted_s_qty = rtrim($formatted_s_qty, ',');
                        }
                        if ($s_qty==0) {
                            echo '<td style="text-align:center;">' . $formatted_s_qty . '</td>';
                        }else{
                            echo '<td style="text-align:center;background-color:red;">' . $formatted_s_qty . '</td>';
                        }
                        ?>             
                        <td><?php echo $kd;?></td>
                        <td><?php echo $nm;?></td>
                        <td style="text-align:center;"><?php echo $sat;?></td>
                        <td style="text-align:center;"><?php echo $kat;?></td>
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

        <!-- ============ MODAL Konfirm Stok =============== -->
        <?php
            foreach ($data->result_array() as $a) {
            $id=$a['req_stok_no'];
            $tgl=$a['req_stok_tgl'];
            $usr=$a['created_by'];
            //$ps=$a['proses_stok'];
            //$pk=$a['proses_kirim'];
            
        ?>
        <div class="modal fade" id="modalKonfirmStok<?php echo $id?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
            <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 class="modal-title" id="myModalLabel">Request Stok Barang - <small><?php echo $userid['reg_code'];?>  <?php echo $userid['reg_name'];?></small></h3>
            </div>    
            <div class="modal-body" style="overflow:scroll;height:400px;">  
            <p style="font-size:11px;margin-bottom:0;"><b>No Request : <?php echo $id?></b></p>
                <table class="table table-bordered table-condensed" style="font-size:11px;">
                    <thead>
                        <tr>
                            <th style="text-align:center;">No</th>
                            <th style="text-align:center;">Qty Request</th>
                            <th style="text-align:center;">Qty Kirim</th>
                            <th style="text-align:center;">Qty Konfirm</th>
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

                        ?>
                    <tr>
                        <td style="text-align:center;"><?php echo $no;?>
                        <input type="hidden" name="nofak<?php echo $noid?>" value="<?php echo $id?>">
                        <input type="hidden" name="kode<?php echo $noid?>" value="<?php echo $noid?>">
                        <input type="hidden" name="k_qty<?php echo $noid?>" value="<?php echo $k_qty?>">
                        </td>
                        <?php 
                        if (floor($req_qty) == $req_qty) {
                            $formatted_req_qty = number_format($req_qty, 0, ',', '.');
                        } else {
                            $formatted_req_qty = number_format($req_qty, 2, ',', '.');
                            $formatted_req_qty = rtrim($formatted_req_qty, '0');
                            $formatted_req_qty = rtrim($formatted_req_qty, ',');
                        }
                        if ($req_qty==$k_qty) {
                            echo '<td style="text-align:center;">' . $formatted_req_qty . '</td>';
                        }else{
                            echo '<td style="text-align:center;color:orange">' . $formatted_req_qty . '</td>';
                        }
                        if (floor($k_qty) == $k_qty) {
                            $formatted_k_qty = number_format($k_qty, 0, ',', '.');
                        } else {
                            $formatted_k_qty = number_format($k_qty, 2, ',', '.');
                            $formatted_k_qty = rtrim($formatted_k_qty, '0');
                            $formatted_k_qty = rtrim($formatted_k_qty, ',');
                        }
                        if ($req_qty==$k_qty) {
                            echo '<td style="text-align:center;">' . $formatted_k_qty . '</td>';
                        }else {
                            echo '<td style="text-align:center;color:red;">' . $formatted_k_qty . '</td>';
                        }
                        ?>             
                        <td style="text-align:center;"><input type="text" name="kon_qty<?php echo $noid?>" style="width:70px;" value="<?php echo $formatted_k_qty?>" min="0" max="<?php echo $formatted_k_qty?>" required></td>
                        <td><?php echo $kd;?></td>
                        <td><?php echo $nm;?></td>
                        <td style="text-align:center;"><?php echo $sat;?></td>
                        <td style="text-align:center;"><?php echo $kat;?></td>
                    </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>          

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-info" onclick="simpanKonfirmStok(this)">Simpan</button>
                    <button class="btn" data-dismiss="modal" aria-hidden="true" onclick="refreshPage()">Tutup</button>
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
            //$ps=$a['proses_stok'];
            $pk=$a['proses_kirim'];
            
        ?>
        <div class="modal fade" id="modalLihatStok<?php echo $id?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
            <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 class="modal-title" id="myModalLabel">Request Stok Barang - <small><?php echo $userid['reg_code'];?>  <?php echo $userid['reg_name'];?></small></h3>
            </div>    
            <div class="modal-body" style="overflow:scroll;height:400px;">  
                <?php
                    if ($pk==0) {
                        echo '<div class="pull-right" style="margin-bottom: 5px;"><a href="#modalAddEdit'.$id.'" data-toggle="modal" title="Edit" class="btn btn-xs btn-success"><span class="fa fa-plus"></span> Tambah Request Stok</a></div>';    
                    }
                ?>
                <p style="font-size:11px;margin-bottom:0;"><b>No Request : <?php echo $id?></b></p>
                <table class="table table-bordered table-condensed" style="font-size:11px;">
                    <thead>
                        <tr>
                            <th style="text-align:center;">No</th>
                            <th style="text-align:center;">Kode Barang</th>
                            <th style="text-align:center;">Nama Barang</th>
                            <th style="text-align:center;">Satuan</th>
                            <th style="text-align:center;">Kategori</th>
                            <th style="text-align:center;">Qty Request</th>
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
                            $qty=$q['d_req_stok_qty'];
                        ?>
                    <tr>
                        <td style="text-align:center;"><?php echo $no;?></td>
                        <td><?php echo $kd;?></td>
                        <td><?php echo $nm;?></td>
                        <td style="text-align:center;"><?php echo $sat;?></td>
                        <td style="text-align:center;"><?php echo $kat;?></td>
                        <?php 
                        if (floor($qty) == $qty) {
                            $formatted_qty = number_format($qty, 0, ',', '.');
                        } else {
                            $formatted_qty = number_format($qty, 2, ',', '.');
                            $formatted_qty = rtrim($formatted_qty, '0');
                            $formatted_qty = rtrim($formatted_qty, ',');
                        }
                        echo '<td style="text-align:center;">' . $formatted_qty . '</td>';
                        ?>                         
                        <td style="text-align:center;">
                        <?php
                        if ($pk==0) {
                            echo '<a class="btn btn-xs btn-warning" href="#modalEditD'.$noid.'" data-toggle="modal" title="Edit" id="editButton"><span class="fa fa-pencil"></span></a> ';
                            echo '<a class="btn btn-xs btn-danger" href="#modalHapusD'.$noid.'" data-toggle="modal" title="Hapus"><span class="fa fa-trash-o"></span></a>';
                        }else{
                            echo '<label style="padding-left:7px;color:red;"><span class="fa fa-close"></span> Sudah Proses Kirim </label>';
                        }
                        ?>
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
                        $qty=$q['d_req_stok_qty'];    
        ?>        
                <div id="modalEditD<?php echo $noid?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
                    <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h3 class="modal-title" id="myModalLabel">Edit Request Stok</h3>
                    </div>
                    <form id="formEditD<?php echo $noid; ?>" class="form-horizontal" onsubmit="updateData(event, '<?php echo $noid; ?>', '<?php echo $id; ?>')" method="post" action="<?php echo base_url().'admin/stok/edit_detailstok'?>">
                        <div class="modal-body">
                            <input name="kode" type="hidden" value="<?php echo $noid;?>">
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
                                <label class="control-label col-xs-3" >Qty Request</label>
                                <div class="col-xs-9">
                                    <?php 
                                    if (floor($qty) == $qty) {
                                        $formatted_qty = number_format($qty, 0, ',', '.');
                                    } else {
                                        $formatted_qty = number_format($qty, 2, ',', '.');
                                        $formatted_qty = rtrim($formatted_qty, '0');
                                        $formatted_qty = rtrim($formatted_qty, ',');
                                    }
                                    echo '<input name="qty" class="form-control" type="text" value="'.$formatted_qty.'" style="width:280px;" required>';
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

        <!-- ============ MODAL Edit Hapus =============== -->
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
                        $qty=$q['d_req_stok_qty'];    
        ?>        
                <div id="modalHapusD<?php echo $noid?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
                    <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h3 class="modal-title" id="myModalLabel">Edit Request Stok</h3>
                    </div>   
                    <form id="formHapusD<?php echo $noid; ?>" class="form-horizontal" onsubmit="hapusData(event, '<?php echo $noid; ?>', '<?php echo $id; ?>')" method="post" action="<?php echo base_url().'admin/stok/hapus_detailstok'?>">
                        <div class="modal-body">
                            <input name="kode" type="hidden" value="<?php echo $noid;?>">
                            <p>Yakin mau menghapus data Kode Barang : <?php echo $kd. ' , Nama Barang : '. $nm. ', Qty : '.$qty.'...?' ?></p>             
                        </div>
                        <div class="modal-footer">
                            <button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
                            <button type="submit" class="btn btn-danger">Hapus</button>
                        </div>
                    </form>
                </div>
                </div>
                </div>
            <?php endforeach;?> 
        <?php
        }
        ?>

        <!-- ============ MODAL Edit Add =============== -->
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
                        $qty=$q['d_req_stok_qty'];    
        ?>        
                <div id="modalAddEdit<?php echo $id?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
                    <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h3 class="modal-title" id="myModalLabel">Tambah Request Stok</h3>
                    </div> 
                    <form id="formAddEdit<?php echo $noid; ?>" class="form-horizontal" onsubmit="addData(event, '<?php echo $noid; ?>', '<?php echo $id; ?>')" method="post" action="<?php echo base_url().'admin/stok/add_detailstok'?>">
                        <div class="modal-body">
                            <div class="form-group">
                                <input name="noreq" type="hidden" value="<?php echo $id; ?>">
                                <label class="control-label col-xs-3" >Kode Barang</label>
                                <div class="col-xs-9">
                                    <select name="barang" id="barang<?php echo $noid; ?>" class="selectpicker show-tick form-control" data-live-search="true" title="Pilih Suplier" data-width="100%" required onchange="updateNm('<?php echo $noid; ?>')">
                                    <?php foreach ($brg->result_array() as $i) {
                                        $id_brg=$i['barang_id'];
                                        $nm_brg=$i['barang_nama'];
                                        $sat_brg=$i['barang_satuan'];
                                        $kat_brg=$i['barang_kategori_nama'];
                                        echo "<option value='$id_brg' data-nm='$nm_brg' data-sat='$sat_brg' data-kat='$kat_brg'>$id_brg - $nm_brg - $sat_brg - $kat_brg</option>";
                                    }?>
                                </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-xs-3" >Nama Barang</label>
                                <div class="col-xs-9">
                                    <input name="nm" id="nm<?php echo $noid; ?>" class="form-control" type="text" style="width:280px;" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-xs-3" >Satuan</label>
                                <div class="col-xs-9">
                                    <input name="sat" id="sat<?php echo $noid; ?>" class="form-control" type="text" style="width:280px;" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-xs-3" >Kategori</label>
                                <div class="col-xs-9">
                                    <input name="kat" id="kat<?php echo $noid; ?>" class="form-control" type="text" style="width:280px;" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-xs-3" >Qty Request</label>
                                <div class="col-xs-9">
                                   <input name="qty" class="form-control" type="text" style="width:280px;" required> 
                                </div>
                            </div>   
                        </div>
                        <div class="modal-footer">
                            <button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
                            <button type="submit" class="btn btn-info">Simpan</button>
                        </div>
                    </form>
                </div>
                </div>
                </div>
            <?php endforeach;?> 
        <?php
        }
        ?>

        <!-- ============ MODAL HAPUS  =============== -->
        <?php
                    foreach ($data->result_array() as $a) {
                        $id=$a['req_stok_no'];
                        $tgl=$a['req_stok_tgl'];
                        $usr=$a['created_by'];
                    ?>
                <div id="modalHapusStok<?php echo $id?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
                    <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h3 class="modal-title" id="myModalLabel">Hapus Request Stok</h3>
                    </div>
                    <form class="form-horizontal" method="post" action="<?php echo base_url().'admin/stok/hapus_reqstok'?>">
                        <div class="modal-body">
                            <p>Yakin mau menghapus data No Request <?php echo $id; ?>...?</p>
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
    

<script type="text/javascript">
$(document).ready(function() {
    $(document).on('input', 'input[name^="qty"]', function(e) {
        var inputValue = e.target.value;
        //var sanitizedValue = inputValue.replace(/[^0-9,\b\t]/g, ''); // Hapus karakter yang tidak diizinkan (selain angka, koma, backspace, delete, dan tab)
        var sanitizedValue = inputValue.replace(/[^\d,\b\t]/g, '')
        e.target.value = sanitizedValue; // Update nilai input dengan karakter yang diizinkan
    });

    $(document).on('blur', 'input[name^="qty"]', function(e) {
        var numericValue = parseFloat(e.target.value.replace(',', '.')) || 0;
        if (numericValue <= 0) {    // Periksa apakah nilai adalah 0 atau kurang dari 0
            $(this).val(''); // Mengosongkan nilai input yang sedang berfokus
            alert("Nilai harus lebih besar dari 0");    // Jika nilai adalah 0 atau kurang dari 0, berikan pesan kesalahan
            setTimeout(function() {
                $(this).focus(); // Tambahkan delay untuk memastikan pengaturan fokus berhasil
            }.bind(this), 0);
        }
    });

    $(document).on('input', 'input[name^="kon_qty"]', function(e) {
        var inputValue = e.target.value;
        //var sanitizedValue = inputValue.replace(/[^0-9,\b\t]/g, ''); // Hapus karakter yang tidak diizinkan (selain angka, koma, backspace, delete, dan tab)
        var sanitizedValue = inputValue.replace(/[^\d,\b\t]/g, '')
        e.target.value = sanitizedValue; // Update nilai input dengan karakter yang diizinkan
    });

    //membatasi input qty sesuai stok yang tersedia
    var inputElements = document.querySelectorAll('input[name^="kon_qty"]');
    inputElements.forEach(function(inputElement) {
        inputElement.addEventListener('input', function() {
            // var value = parseFloat(this.value);
            // var min = parseFloat(this.min);
            // var max = parseFloat(this.max);
            // if (value < min) {
            //     this.value = min;
            // } else if (value > max) {
            //     this.value = max;
            // }
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
            $('#modalEditD' + noid).modal('hide');
            //$('#modalLihatStok' + id + ' .modal-body').load(location.href + ' #modalLihatStok' + id + ' .modal-body');
            //$('#modalLihatStok' + id + ' .table').load(location.href + ' #modalLihatStok' + id + ' .table');  
            $('#modalLihatStok' + id + ' .modal-dialog').empty();
            $('#modalLihatStok' + id + ' .modal-dialog').load(location.href + ' #modalLihatStok' + id + ' .modal-dialog');
        }
    });
    }

    function hapusData(event, noid, id) {
    event.preventDefault();  // Menghentikan perilaku default form
    var formData = new FormData(event.target); // Dapatkan data dari form
    $.ajax({
        url: event.target.action,
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            $('#modalHapusD' + noid).modal('hide');
            //$('#modalLihatStok' + id + ' .modal-body').load(location.href + ' #modalLihatStok' + id + ' .modal-body');
            $('#modalLihatStok' + id + ' .table').load(location.href + ' #modalLihatStok' + id + ' .table');  
        }
    });
    }

    function addData(event, noid, id) {
    event.preventDefault();  // Menghentikan perilaku default form
    var formData = new FormData(event.target); // Dapatkan data dari form
    $.ajax({
        url: event.target.action,
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            $('#modalAddEdit' + id).modal('hide');
            $('#modalLihatStok' + id + ' .modal-dialog').empty();
            $('#modalLihatStok' + id + ' .modal-dialog').load(location.href + ' #modalLihatStok' + id + ' .modal-dialog');  
        }
    });
    }
    

</script>


<script type="text/javascript">
    // Fungsi untuk mengisi input teks nm
    function updateNm(noid) {
        var select = document.getElementById('barang' + noid);
        var nmInput = document.getElementById('nm' + noid);
        var satInput = document.getElementById('sat' + noid);
        var katInput = document.getElementById('kat' + noid);

        // Mengambil nilai data-nm dari opsi yang dipilih
        var selectedOption = select.options[select.selectedIndex];
        var nmValue = selectedOption.getAttribute('data-nm');
        var satValue = selectedOption.getAttribute('data-sat');
        var katValue = selectedOption.getAttribute('data-kat');

        // Mengisi input teks nm dengan nilai data-nm
        nmInput.value = nmValue || '';
        satInput.value = satValue || '';
        katInput.value = katValue || '';
    }

</script>

<script>
    function refreshPage() {
        window.location.reload(); // Memuat ulang halaman
    }
</script>

<script>
    function simpanKonfirmStok(buttonElement) {
        // Mengumpulkan data dari input dalam tabel
        var data = [];
        var modal = $(buttonElement).closest('.modal'); // Ambil modal yang berisi tombol "Simpan"
        var rows = modal.find('table tbody tr');
        rows.each(function() {
            var row = $(this);
            var nofak = row.find('input[name^="nofak"]').val();
            var kode = row.find('input[name^="kode"]').val();
            var k_qty = row.find('input[name^="k_qty"]').val();
            var qty = row.find('input[name^="kon_qty"]').val();
            var kode_barang = row.find('td:eq(4)').text(); // Kolom kelima
            var nama_barang = row.find('td:eq(5)').text();
            var satuan = row.find('td:eq(6)').text();
            var kategori = row.find('td:eq(7)').text();
            data.push({
                nofak: nofak,
                kode: kode,
                qty: qty.replace(/,/g, '.'),
                k_qty: k_qty.replace(/,/g, '.'),
                kode_barang: kode_barang,
                nama_barang: nama_barang,
                satuan: satuan,
                kategori: kategori
            });
        });
        // Kirim data ke server dengan AJAX
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url('admin/stok/simpan_konfirm_stok');?>",
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
</script>

</body>
</html>
