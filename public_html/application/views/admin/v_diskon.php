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
    <meta name="description" content="Produk <?php echo $userid['co_name'];?>">
    <meta name="author" content="<?php echo $userid['co_name'];?>">

    <title>Setting Discount</title>
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
                <h1 class="page-header">Diskon Rate
                    <small>Barang</small>
                    <div class="pull-right"><a href="#" class="btn btn-sm btn-success" data-toggle="modal" data-target="#largeModal"><span class="fa fa-plus"></span> Tambah Diskon</a></div>
                </h1>
            </div>
        </div>
        <!-- /.row -->
        <!-- Projects Row -->
        <?php
        //mengambil nilai indeks terbanyak
            $max_indeks = 0;
            foreach ($data->result_array() as $a) {
                $dr = $a['disc_rate'];
                if (!empty($dr)) {
                    $stok_array = explode(';', $dr);
                    $num_indeks = count($stok_array);
                    // Periksa apakah jumlah indeks saat ini lebih besar dari yang sebelumnya
                    if ($num_indeks > $max_indeks) {
                        $max_indeks = $num_indeks;
                    }
                }
            }
            //echo "Indeks tertinggi adalah: " . $max_indeks;
        ?>
        <div class="row">
            <div class="col-lg-12">
            <table class="table table-bordered table-condensed" style="font-size:11px;" id="mydata">
                <thead>
                    <tr>
                        <th rowspan="2" style="vertical-align:middle;text-align:center;width:40px;">No</th>
                        <th rowspan="2" style="vertical-align:middle;text-align:center;">Keterangan Diskon</th>
                        <th colspan="<?php echo $max_indeks; ?>" style="vertical-align:middle;text-align:center;">Rate_Diskon (%)</th>
                        <th rowspan="2" style="max-width:100px!important;text-align:center;vertical-align:middle;" data-orderable="false">Aksi</th>
                    </tr>
                    <tr>               
                    <?php 
                    for ($i = 1; $i <= $max_indeks; $i++) {
                    ?>
                        <th style="max-width:100px!important;text-align:center;border-right: 1px solid #ddd;" data-orderable="false">
                        <?php echo "Diskon " .$i;?>
                        </th>
                    <?php }?> 
                    </tr>  
                </thead>
                <tbody>
                <?php 
                    $no=0;
                    foreach ($data->result_array() as $a):
                        $no++;
                        $id=$a['disc_id'];
                        $nm=$a['disc_ket'];
                        $dr=$a['disc_rate'];
                ?>
                    <tr>
                        <td style="text-align:center;"><?php echo $no;?></td>
                        <td><?php echo $nm;?></td>
                        <?php
                            if (!empty($dr)) {
                                $stok_array = explode(';', $dr);
                                $num_indeks = count($stok_array);
                                if ($num_indeks == $max_indeks) {
                                    $nilai_dict = [];
                                    foreach ($stok_array as $stok_pair) {
                                        list($key, $value) = explode(':', $stok_pair);
                                        $nilai_dict[(int)$key] = $value;
                                    }
                                    ksort($nilai_dict);
                                    foreach ($nilai_dict as $key => $value) {
                                        //echo '<td>' . $value . '</td>';
                                        $rtdc=$value;
                                        if (floor($rtdc) == $rtdc) {
                                            $formatted_rtdc = number_format($rtdc, 0, ',', '.');
                                        } else {
                                            $formatted_rtdc = number_format($rtdc, 2, ',', '.');
                                            $formatted_rtdc = rtrim($formatted_rtdc, '0');
                                            $formatted_rtdc = rtrim($formatted_rtdc, ',');
                                        }
                                        echo '<td>'.$formatted_rtdc.'</td>';
                                    }
                                } else {
                                    // Output nilai dari $stok_array
                                    foreach ($stok_array as $stok_pair) {
                                        list($key, $value) = explode(':', $stok_pair);
                                        //echo '<td>' . $value . '</td>';
                                        $rtdc=$value;
                                        if (floor($rtdc) == $rtdc) {
                                            $formatted_rtdc = number_format($rtdc, 0, ',', '.');
                                        } else {
                                            $formatted_rtdc = number_format($rtdc, 2, ',', '.');
                                            $formatted_rtdc = rtrim($formatted_rtdc, '0');
                                            $formatted_rtdc = rtrim($formatted_rtdc, ',');
                                        }
                                        echo '<td>'.$formatted_rtdc.'</td>';
                                    }
                                    // // Output tambahan untuk indeks yang kurang dari $max_indeks dengan mengambil nilai value terakhir
                                    // for ($i = 1; $i <= ($max_indeks - $num_indeks); $i++) {
                                    //     $last_value = end($stok_array);
                                    //     list($last_key, $last_value) = explode(':', $last_value);
                                    //     echo '<td>' . $last_value . '</td>';
                                    // }
                                    // Output tambahan untuk indeks yang kurang dari $max_indeks dengan memberikan nilai 0
                                    for ($i = $num_indeks + 1; $i <= $max_indeks; $i++) {
                                        echo '<td>0</td>';
                                    }
                                }
                            }
                        ?>

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
                <h3 class="modal-title" id="myModalLabel">Tambah Diskon</h3>
            </div>
            <form class="form-horizontal" method="post" action="<?php echo base_url().'admin/diskon/tambah_diskon'?>">
                <div class="modal-body">

                    <div class="form-group">
                        <label class="control-label col-xs-3" >Nama Diskon</label>
                        <div class="col-xs-9">
                            <input name="nama_diskon" class="form-control" type="text" placeholder="Input Nama Diskon..." style="width:280px;" required>
                        </div>
                    </div>
                    <div id="rate_diskon_container" class="form-group">
                        <label class="control-label col-xs-3" >Rate Diskon 1</label>
                        <div class="col-xs-9">
                            <input name="rate_diskon[]" class="form-control" type="text" placeholder="Input Rate Diskon..." style="width:280px;" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-9">
                        <button type="button" class="btn btn-sm btn-success" onclick="tambahRateDiskon()"><span class="fa fa-plus"></span>Tambah Rate Diskon</button>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button class="btn" data-dismiss="modal" aria-hidden="true" onclick="refreshPage()">Tutup</button>
                    <button class="btn btn-info">Simpan</button>
                </div>
            </form>
            </div>
            </div>
        </div>

        <!-- ============ MODAL EDIT =============== -->
        <?php
                    foreach ($data->result_array() as $a) {
                        $id=$a['disc_id'];
                        $nm=$a['disc_ket'];
                        $dr=$a['disc_rate'];

                    ?>
                <div id="modalEdit<?php echo $id?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
                    <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h3 class="modal-title" id="myModalLabel">Edit Diskon</h3>
                    </div>
                    <form class="form-horizontal" method="post" action="<?php echo base_url().'admin/diskon/edit_diskon'?>">
                        <div class="modal-body">
                            <input name="kode" type="hidden" value="<?php echo $id;?>">

                    <div class="form-group">
                        <label class="control-label col-xs-4">Keterangan Diskon</label>
                        <div class="col-xs-8">
                            <input name="nama_diskon" class="form-control" type="text" value="<?php echo $nm;?>" style="width:250px;" required>
                        </div>
                    </div>
                    <?php
                        $stok_array = explode(';', $dr);
                        $num_indeks = count($stok_array);
                        $nilai_dict = [];
                        foreach ($stok_array as $stok_pair) {
                            list($key, $value) = explode(':', $stok_pair);
                            $nilai_dict[(int)$key] = $value;
                        }
                        ksort($nilai_dict);
                        foreach ($nilai_dict as $key => $value) {
                            echo '<div class="form-group">';
                            echo '<label class="control-label col-xs-4" >Diskon_'.$key.'</label>';
                            echo '<div class="col-xs-3">';
                            $rtdc=$value;
                                if (floor($rtdc) == $rtdc) {
                                    $formatted_rtdc = number_format($rtdc, 0, ',', '.');
                                } else {
                                    $formatted_rtdc = number_format($rtdc, 2, ',', '.');
                                    $formatted_rtdc = rtrim($formatted_rtdc, '0');
                                    $formatted_rtdc = rtrim($formatted_rtdc, ',');
                                }
                            //echo '<input name="rate_diskon[]" class="form-control" type="text" value="'.$value.'" style="width:150px;" required>';
                            echo '<input name="rate_diskon[]" class="form-control" type="text" value="'.$formatted_rtdc.'" style="width:150px;" required>';
                            echo '</div>';
                            echo '<div class="col-xs-2">';
                            echo '<button type="button" onclick="removeInput(this)">Hapus</button>';
                            echo '</div>';
                            echo '</div>';
                        }
                        $selisihIndeks=$max_indeks-$num_indeks;
                        if ($selisihIndeks >0) {
                            for ($i=1; $i <= $selisihIndeks; $i++) {
                                $indekskey=$num_indeks+$i;
                                echo '<div class="form-group">';
                                echo '<label class="control-label col-xs-4" >Diskon_'.$indekskey.'</label>';
                                echo '<div class="col-xs-8">';
                                echo '<input name="rate_diskon[]" class="form-control" type="text" value="0" style="width:150px;" required>';
                                echo '</div>';
                                echo '</div>';
                            }
                        }


                        ?>

                </div>
                        <div class="modal-footer">
                            <!--<button class="btn" data-dismiss="modal" aria-hidden="true" onclick="refreshPage()">Tutup</button>-->
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
                        $id=$a['disc_id'];
                        $nm=$a['disc_ket'];
                    ?>
                <div id="modalHapus<?php echo $id?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
                    <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h3 class="modal-title" id="myModalLabel">Hapus Diskon</h3>
                    </div>
                    <form class="form-horizontal" method="post" action="<?php echo base_url().'admin/diskon/hapus_diskon'?>">
                        <div class="modal-body">
                            <p>Yakin mau menghapus data keterangan diskon : <?php echo $nm; ?> ... ?</p>
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


    <script>
    let counter = 1;
    let isFirstElementAdded = false;
    function tambahRateDiskon() {
        counter++;
        const container = document.getElementById('rate_diskon_container');
        //container.style.marginTop = "20px";  // Tambahkan margin-top sebesar 10px

        const div = document.createElement('div');
        div.className = "form-group";
        div.style.paddingLeft = "10px";  // Add left padding to shift the element to the left
        if (!isFirstElementAdded) {
            div.style.marginTop="8%";
            isFirstElementAdded = true;  // Setel elemen pertama telah ditambahkan
        }
        
        
        const label = document.createElement('label');
        label.className = "control-label col-xs-3";
        label.textContent = 'Rate Diskon ' + counter + ':';

        const innerDiv = document.createElement('div');
        innerDiv.className = "col-xs-9";
        //innerDiv.style.paddingLeft = "25px";  // Add left padding to shift the element to the left

        const input = document.createElement('input');
        input.className = "form-control";
        input.type = "text";
        input.name = "rate_diskon[]";
        input.placeholder = "Input Rate Diskon...";
        input.style.width = "280px";
        input.required = true;

        innerDiv.appendChild(input);
        div.appendChild(label);
        div.appendChild(innerDiv);
        container.appendChild(div);
    }
    </script>
    
    
    <script>
        function removeInput(button) {
        // Dapatkan parent dari button (form-group) dan hapus
        var formGroup = button.closest('.form-group');
        formGroup.parentNode.removeChild(formGroup);
        }
        // function removeInput(button) {
        // // Dapatkan parent dari button (div input-row) dan hapus
        // var inputRow = button.parentNode;
        // inputRow.parentNode.removeChild(inputRow);
        // }
    </script>
    
    
    <script>
        function refreshPage() {
        window.location.reload(); // Memuat ulang halaman
        }
    </script>

<script type="text/javascript">	
$(document).on('input', 'input[name^="rate_diskon"]', function(e) {
    var inputValue = e.target.value;
    var sanitizedValue = inputValue.replace(/[^0-9,\b\t]/g, ''); 
    e.target.value = sanitizedValue; 
 });
</script>

</body>
</html>