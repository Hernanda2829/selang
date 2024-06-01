<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    //error_reporting(E_ALL);
    //ini_set('display_errors', 1); 
	error_reporting(0);
    $userid=$userid->row_array();
    $data_regid=$userid['reg_id'];
    ?>  
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Produk By <?php echo $userid['co_name'];?>">
    <meta name="author" content="<?php echo $userid['co_name'];?>">

    <title>Data Pengeluaran</title>
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

    .total-grup-row {
        visibility: collapse;
    }

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
                <h3 style="margin: 0;">Data Pengeluaran <small><?php echo $userid['reg_code'];?>  <?php echo $userid['reg_name'];?></small></h3>
            </div>
        </div>
        <hr/>
        <div class="row" style="margin-bottom:10px;">
            <div class="col-lg-12">
                <form id="myForm" class="form-horizontal" method="post" action="" target="_blank">
                <table style="font-size:12px;margin-bottom:10px;">
                    <input type="hidden" name="regid" id="regid" value="<?php echo $data_regid; ?>">
                    <tr>
                        <th style="width:10%;vertical-align:middle;">Tgl Transaksi :</th>
                        <td style="width:13%;vertical-align:middle;">
                            <div class="input-group date" id="datepicker1">
                                <input type="text" id="tgl1" name="tgl1" class="form-control input-sm" style="font-size:11px;color:green;" placeholder="Tanggal..." value="<?= $firstDayOfMonth; ?>" required>
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </td>
                        <th style="width:5%;vertical-align:middle;text-align:center"> S/d</th>
                        <td style="width:13%;vertical-align:middle;">
                            <div class="input-group date" id="datepicker2">
                                <input type="text" id="tgl2" name="tgl2" class="form-control input-sm" style="font-size:11px;color:green;" placeholder="Tanggal..." value="<?= $lastDayOfMonth; ?>" required>
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </td>
                        <td style="width:26%;vertical-align:middle;padding-left:20px;">
                            <a class="btn btn-sm btn-info btn-tampil" data-toggle="modal" title="Tampilkan Data"><span class="fa fa-search"></span></a>
                        </td>
                        <th style="width:10%;vertical-align:middle;text-align:right;padding-right:10px;"> Filter By : </th>
                        <td style="width:20%;vertical-align:middle;text-align:right;">
                            <select name="kat_beb" id="kat_beb" class="selectpicker show-tick form-control" title="Pilih Kategori Beban" placeholder="Pilih Kategori Beban">
                            <option value="" style="font-size: 11px;"></option>
                            <?php   
                                foreach ($data_kategori->result_array() as $k) {
                                    $kid = $k['kat_id'];
                                    $knm = $k['kat_nama'];
                                        echo "<option value='$kid'>$knm</option>";
                                }  
                            echo '</select>';
                            ?>
                        </td>
                    </tr>
                </table>
                </form>
            </div>
        </div>
       
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#tab1" style="font-size:12px;"><b>Tampilan Group</b></a></li>
            <li><a data-toggle="tab" href="#tab2" style="font-size:12px;"><b>Tampilan List</b></a></li>
            <!-- Tambahkan lebih banyak tab sesuai kebutuhan -->
        </ul> 
        
        <!-- Isi Tab -->
        <div class="tab-content">
            <!-- Tab 1: Informasi -->
            <div id="tab1" class="tab-pane fade in active">
                <br>
                <div class="row">
                    <div class="col-lg-12 text-right">
                        <button class="btn btn-sm btn-info" title="Cetak Data" onclick="varCetak_Pengeluaran(1)"><span class="fa fa-print"></span> Cetak Data</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-9">
                        <?php
                        // Inisialisasi array untuk menyimpan data per kategori
                        $kategori_data = array();
                        $totRec = 0;

                        // Kumpulkan data per kategori
                        foreach ($data as $a):
                            $beb_tgl = $a['beban_tanggal'];
                            $beb_nm = $a['beban_nama'];
                            $beb_jml = $a['beban_jumlah'];
                            $beb_kat = $a['beban_kat_nama'];
                            $beb_kat_id = $a['beban_kat_id'];

                            // Tambahkan data ke dalam array kategori_data
                            if (!isset($kategori_data[$beb_kat])) {
                                $kategori_data[$beb_kat] = array(
                                    'nama' => $beb_kat,
                                    'id' => $beb_kat_id,
                                    'no' => 1, // Atur nomor urut grup menjadi 1
                                    'total' => 0,
                                    'data' => array()
                                );
                            }

                            $kategori_data[$beb_kat]['data'][] = array(
                                'no' => $kategori_data[$beb_kat]['no'], // Gunakan nomor urut grup
                                'tanggal' => $beb_tgl,
                                'nama' => $beb_nm,
                                'jumlah' => $beb_jml
                            );

                            // Akumulasi total jumlah per kategori
                            $kategori_data[$beb_kat]['total'] += $beb_jml;

                            // Tingkatkan nomor urut grup
                            $kategori_data[$beb_kat]['no']++;
                            $totRec++;
                        endforeach;

                        $beb_total = 0;

                        // Tampilkan data per kategori
                        foreach ($kategori_data as $kategori_info):
                            //echo '<h4>' . $kategori_info['id'] . '. ' . $kategori_info['nama'] . '</h4>';
                            echo '<h4 id="judul_group_' . $kategori_info['id'] . '">' . $kategori_info['id'] . '. ' . $kategori_info['nama'] . '</h4>';
                            echo '
                            <table class="table table-bordered nowrap tbl_group" style="font-size:11px;">
                                <thead>
                                    <tr>
                                        <th style="width:5%;text-align:center">No</th>
                                        <th style="width:20%;text-align:center">Tanggal Transaksi</th>
                                        <th style="width:50%;text-align:center">Nama Pengeluaran</th>
                                        <th style="width:25%;text-align:center">Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody class="tbl_group_body">';

                            foreach ($kategori_info['data'] as $subgroup):
                                echo '
                                <tr>
                                    <td style="width:5%;text-align:center;">' . $subgroup['no'] . '</td>
                                    <td style="width:20%;">' . $subgroup['tanggal'] . '</td>
                                    <td style="width:50%;">' . $subgroup['nama'] . '</td>
                                    <td style="width:25%;text-align:right;">' . 'Rp ' . number_format($subgroup['jumlah'], 0, ',', '.') . '</td>
                                </tr>';
                            endforeach;

                            $beb_total += $kategori_info['total'];

                            // Tampilkan total jumlah per kategori
                            echo '
                                <tr style="background-color:#777;">
                                    <td colspan="3" style="text-align:right;font-size:11px;color:white;"><b>Total ' . $kategori_info['nama'] . ' : </b></td>
                                    <td style="text-align:right;font-size:11px;color:white;"><b>Rp ' . number_format($kategori_info['total'], 0, ',', '.') . '</b></td>
                                </tr>';

                            echo '
                                </tbody>
                            </table>';
                        endforeach;

                        echo '
                        <table class="table table-bordered nowrap tbl_total_group" style="font-size:11px;">
                            <thead>
                                <tr class="total-grup-row">
                                    <th style="width:5%;text-align:center">No</th>
                                    <th style="width:20%;text-align:center">Tanggal Transaksi</th>
                                    <th style="width:50%;text-align:center">Nama Pengeluaran</th>
                                    <th style="width:25%;text-align:center">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody class="tbl_total_group_body">
                                <tr class="total-grup-row">
                                    <td style="width:5%;text-align:center;"></td>
                                    <td style="width:20%;"></td>
                                    <td style="width:50%;">Total Record</td>
                                    <td style="width:25%;text-align:right;">' . $totRec . '</td>
                                </tr>
                                <tr style="background-color:#333;">
                                    <td colspan="2" style="font-size:11px;color:white;"><b>Total Record : ' . $totRec . '</b></td>
                                    <td style="text-align:right;font-size:11px;color:white;"><b>Total Pengeluaran : </b></td>
                                    <td style="text-align:right;font-size:11px;color:white;"><b>Rp ' . number_format($beb_total, 0, ',', '.') . '</b></td>
                                </tr>
                            </tbody>
                        </table>';

                        ?>
                    </div>
                </div>



            </div>
            <div id="tab2" class="tab-pane fade">
                <br>
                <div class="row" style="margin-bottom:10px;">
                    <div class="col-lg-12 text-right">
                        <button class="btn btn-sm btn-info" title="Cetak Data" onclick="varCetak_Pengeluaran(2)"><span class="fa fa-print"></span> Cetak Data</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">        
                        <table id="tbl_tampil" class="table table-striped table-bordered" style="font-size:11px;">
                            <thead>
                                <tr>
                                    <th style="text-align:center">No</th>    
                                    <th style="text-align:center">Tanggal Transaksi</th>    
                                    <th style="text-align:center">Nama Pengeluaran</th>
                                    <th style="text-align:center">Kategori</th>
                                    <th style="text-align:center">Jumlah</th>
                                    </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $no=0;
                                $beb_total=0;
                                foreach ($data as $a):
                                    $no++;
                                    $beb_tgl = $a['beban_tanggal'];
                                    $beb_nm = $a['beban_nama'];
                                    $beb_jml = $a['beban_jumlah'];
                                    $beb_kat = $a['beban_kat_nama'];
                                    $beb_total = $beb_total+$beb_jml;
                                ?>
                                <tr>
                                    <td style="text-align:center;"><?php echo $no;?></td>
                                    <td><?php echo $beb_tgl;?></td>
                                    <td><?php echo $beb_nm;?></td>
                                    <td><?php echo $beb_kat;?></td>
                                    <td style="text-align:right;"><?php echo 'Rp ' . str_replace(',', '.', number_format($beb_jml)); ?></td>
                                </tr>
                            <?php endforeach;?>
                            <tr style="background-color:#777;">
                                <td colspan="4" style="text-align:right;font-size:11px;color:white;"><b>Total :</b></td>
                                <td style="text-align:right;font-size:11px;color:white;"><b><?php echo 'Rp ' . str_replace(',', '.', number_format($beb_total)); ?></b></td>
                            </tr>
                            </tbody>
                        </table>
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
$(document).ready(function () {
    $('#datepicker1').datetimepicker({
    format: 'YYYY-MM-DD',
    widgetPositioning: {
        vertical: 'bottom',
        horizontal: 'auto'
        }
    });
    $('#datepicker2').datetimepicker({
    format: 'YYYY-MM-DD',
    widgetPositioning: {
        vertical: 'bottom',
        horizontal: 'auto'
        }
    });
});
</script>


<script>
    function varCetak_Pengeluaran(nilai) {
        var form = document.querySelector('#myForm'); 
        if (nilai == 1) {
            form.action = "<?php echo base_url().'admin/beban_data/tampil_data_beban/1'?>"; 
        } else if (nilai == 2) { 
            form.action = "<?php echo base_url().'admin/beban_data/tampil_data_beban/2'?>"; 
        }
        form.submit(); // Mengirimkan formulir
    }
</script>


<script type="text/javascript">
$(document).ready(function () {
    $(document).on('click', '.btn-tampil', function () {
        showData();
    });

    $('select[name="kat_beb"]').on('change', function() {
        showData();
        
    });

    function showData() {
        $('#tbl_tampil tbody').empty();
        var regid = $('#regid').val();
        var tgl1 = $('#tgl1').val();
        var tgl2 = $('#tgl2').val();
        var cari = $('#kat_beb').val();

        $.ajax({
            url: "<?php echo base_url().'admin/beban_data/get_data_beban';?>",
            type: "POST",
            data: {
                regid: regid,
                tgl1: tgl1,
                tgl2: tgl2,
                cari: cari
            },
            success: function (data) {
                //console.log("Data from server:", data);
                // console.log(regid);
                // console.log(tgl1);

                var parsedData = JSON.parse(data);
                if (parsedData.length !== 0) {
                        var totbeban=0;
                        var no=0;
                        $.each(parsedData.data, function (index, item) {
                                var jbeban = parseFloat(item.beban_jumlah);
                                totbeban = totbeban + jbeban;
                                no++;
                                var newRow = '<tr>' +
                                    '<td style="font-size:11px;text-align:center;">' + no + '</td>' +
                                    '<td style="font-size:11px;">' + item.beban_tanggal + '</td>' +
                                    '<td style="font-size:11px;">' + item.beban_nama + '</td>' +
                                    '<td style="font-size:11px;">' + item.beban_kat_nama + '</td>' +
                                    '<td style="text-align:right;font-size:11px;">' + jbeban.toLocaleString('id-ID') + '</td>' +
                                    '</tr>';
                                $('#tbl_tampil tbody').append(newRow);

                            
                        });
                        var totRow = '<tr style="background-color:#777;">' +
                            '<td colspan="4" style="text-align:right;font-size:11px;color:white;"><b>Total :</b></td>' +
                            '<td style="text-align:right;font-size:11px;color:white;"><b>' + totbeban.toLocaleString('id-ID') + '</b></td>' +
                            '</tr>';
                        $('#tbl_tampil tbody').append(totRow);
                
                        // Regenerate grouped view
                        generateGroupedView(parsedData.data);
                    
                } else {
                        console.log("No data found.");
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX error:", error);
            }
        });
    }
});
</script>


<script type="text/javascript">
    function generateGroupedView(data) {
        //console.log("Data from server:", data);

        // Menghapus semua elemen yang memiliki kelas tbl_group dan tbl_total_group
        $('.tbl_group').remove();
        $('.tbl_total_group').remove();
        $('[id^="judul_group_"]').remove();
        $('.tbl_group_container').remove();

        var kategori_data = {};
        var totRec = 0;
        var beb_total = 0;

        // Logika Anda untuk menghasilkan tampilan berkelompok perlu ditempatkan di sini
        $.each(data, function (index, item) {
            var beb_kat = item.beban_kat_nama;

            if (!kategori_data[beb_kat]) {
                kategori_data[beb_kat] = {
                    'nama': beb_kat,
                    'id': item.beban_kat_id,
                    'no': 1,
                    'total': 0,
                    'data': []
                };
            }

            kategori_data[beb_kat]['data'].push({
                'no': kategori_data[beb_kat]['no'],
                'tanggal': item.beban_tanggal,
                'nama': item.beban_nama,
                'jumlah': parseFloat(item.beban_jumlah)
            });

            kategori_data[beb_kat]['total'] += parseFloat(item.beban_jumlah);
            kategori_data[beb_kat]['no']++;
            totRec++;
        });

        // Logika Anda untuk menampilkan tampilan berkelompok perlu ditempatkan di sini
        $.each(kategori_data, function (index, kategori_info) {
            var $tblGroupContainer = $('<div>', {
                'class': 'tbl_group_container'
            });

            var $tblGroup = $('<table>', {
                'class': 'table table-bordered nowrap tbl_group', // Menambahkan kelas tbl_group
                'style': 'font-size:11px;'
            });

            var $thead = $('<thead>').append(
                '<tr>' +
                '<th style="width:5%;text-align:center">No</th>' +
                '<th style="width:20%;text-align:center">Tanggal Transaksi</th>' +
                '<th style="width:50%;text-align:center">Nama Pengeluaran</th>' +
                '<th style="width:25%;text-align:center">Jumlah</th>' +
                '</tr>'
            );

            var $tbody = $('<tbody class="tbl_group_body">');

            $.each(kategori_info['data'], function (index, subgroup) {
                $tbody.append(
                    '<tr>' +
                    '<td style="width:5%;text-align:center;">' + subgroup.no + '</td>' +
                    '<td style="width:20%;">' + subgroup.tanggal + '</td>' +
                    '<td style="width:50%;">' + subgroup.nama + '</td>' +
                    '<td style="width:25%;text-align:right;">' + 'Rp ' + parseFloat(subgroup.jumlah).toLocaleString('id-ID') + '</td>' +
                    '</tr>'
                );
            });

            $tbody.append(
                '<tr style="background-color:#777;">' +
                '<td colspan="3" style="text-align:right;font-size:11px;color:white;"><b>Total ' + kategori_info['nama'] + ' : </b></td>' +
                '<td style="text-align:right;font-size:11px;color:white;"><b>Rp ' + parseFloat(kategori_info['total']).toLocaleString('id-ID') + '</b></td>' +
                '</tr>'
            );

            $tblGroup.append($thead);
            $tblGroup.append($tbody);

            $tblGroupContainer.append('<h4>' + kategori_info['id'] + '. ' + kategori_info['nama'] + '</h4>');
            $tblGroupContainer.append($tblGroup);

            $('.col-lg-9').append($tblGroupContainer);

            beb_total += kategori_info['total'];
        });

        var totalRow = '<tr class="total-grup-row">' +
            '<td style="width:5%;text-align:center;"></td>' +
            '<td style="width:20%;"></td>' +
            '<td style="width:50%;">Total Record</td>' +
            '<td style="width:25%;text-align:right;">' + totRec + '</td>' +
            '</tr>';

        var totalRow2 = '<tr style="background-color:#333;">' +
            '<td colspan="2" style="font-size:11px;color:white;"><b>Total Record : ' + totRec + '</b></td>' +
            '<td style="text-align:right;font-size:11px;color:white;"><b>Total Pengeluaran : </b></td>' +
            '<td style="text-align:right;font-size:11px;color:white;"><b>Rp ' + parseFloat(beb_total).toLocaleString('id-ID') + '</b></td>' +
            '</tr>';

        var $tblTotalGroup = $('<table>', {
            'class': 'table table-bordered nowrap tbl_total_group',
            'style': 'font-size:11px;'
        });

        var $theadTotalGroup = $('<thead>').append(
            '<tr class="total-grup-row">' +
            '<th style="width:5%;text-align:center">No</th>' +
            '<th style="width:20%;text-align:center">Tanggal Transaksi</th>' +
            '<th style="width:50%;text-align:center">Nama Pengeluaran</th>' +
            '<th style="width:25%;text-align:center">Jumlah</th>' +
            '</tr>'
        );

        var $tbodyTotalGroup = $('<tbody class="tbl_total_group_body">');

        $tbodyTotalGroup.append(totalRow);
        $tbodyTotalGroup.append(totalRow2);

        $tblTotalGroup.append($theadTotalGroup);
        $tblTotalGroup.append($tbodyTotalGroup);

        $('.col-lg-9').append($tblTotalGroup);
    }
</script>




</body>
</html>
