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

    <title>History Stok Barang</title>
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
    <script src="<?php echo base_url().'assets/js/clipboard.min.js'?>"></script>
    
<style>  

   .bootstrap-select .btn {
        font-size: 12px;
    }

    .bootstrap-datetimepicker-widget {
        font-size: 10px; /* Sesuaikan dengan ukuran font yang diinginkan */
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

        <div class="row">
            <div class="col-lg-12">
                <form id="myForm" class="form-horizontal" method="post" action="">
                <table class="table table-bordered" style="font-size:12px;margin-bottom:10px;">
                    <input type="hidden" name="namacab" id="namacab" value="<?php echo $namacab; ?>">
                    <tr>
                        <th style="width:10%;vertical-align:middle;border-top-color:white;border-right-color:white;border-left-color:white;">Tanggal Transaksi :</th>
                        <td style="width:12%;vertical-align:middle;border-top-color:white;border-right-color:white;">
                            <div class='input-group date' id='datepicker' style="width:130px;">
                                <input type='text' name="tgl" id="tgl" class="form-control" style="font-size:11px;color:green;" placeholder="Tanggal..." value="<?= $today ?>" required>
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </td>
                        <th style="width:7%;vertical-align:middle;border-top-color:white;border-right-color:white;border-left-color:white;">Pilih Cabang :</th>
                        <td style="width:15%;vertical-align:middle;border-top-color:white;border-right-color:white;">
                            <select name="regid" id="regid" class="selectpicker show-tick form-control" data-live-search="true" title="Pilih cabang" placeholder="Pilih Cabang" required>
                                <option value="" disabled selected style="display: none;">Pilih Cabang</option>
                                <optgroup label="Pilih Cabang">
                                    <?php 
                                    $regions_data = $this->Mlogin->tampil_regions()->result_array();
                                    foreach ($regions_data as $rg) {
                                        $reg_id = $rg['reg_id'];
                                        $reg_name = $rg['reg_name'];  
                                        if ($namacab == $reg_name)  {
                                            echo '<option value="'.$reg_id.'" selected>'.$reg_name.'</option>';
                                        }else {
                                            echo '<option value="'.$reg_id.'">'.$reg_name.'</option>';
                                        }
                                    }
                                        if ($namacab == "Gabungan (Global)")  {
                                            echo '<option value="0" selected>Gabungan (Global)</option>';
                                        }else {
                                            echo '<option value="0">Gabungan (Global)</option>';
                                        } 
                                    ?>
                                    
                                </optgroup>
                            </select>
                        </td>
                        <td style="width:10%;border-top-color:white;border-right-color:white;">
                            <a class="btn btn-sm btn-info btn-tampil" data-toggle="modal" title="Tampilkan Data"><span class="fa fa-search"></span></a>
                        </td>
                        <td style="width:15%;border-top-color:white;border-right-color:white;"> 
                        </td>
                        <!-- <td style="width:10%;text-align:right;border-top-color:white;border-right-color:white;">
                            <button class="btn btn-sm btn-info" title="Cetak Data" onclick="varCetak_Laporan()"><span class="fa fa-print"></span> Cetak Data</button>
                        </td> -->
                        <td style="width:5%;text-align:right;border-top-color:white;border-right-color:white;">
                            <button class="btn btn-sm btn-success" title="Export to Excel" onclick="varCetak_Excel()" title="Export to Excel"><span class="fa fa-print"></span> Export Excel</button>
                        </td>
                    </tr>
                </table>
                </form>
            </div>
        </div>
    
        <div class="row">
            <div class="col-lg-12">
                <button class="btn btn-sm btn-info btn-tampilkan" title="Sembunyikan nilai 0 dan tampilkan yang hanya memiliki nilai lebih dari 0">Tampilkan nilai > 0</button>
                <button class="btn btn-sm btn-info btn-reset" title="Kembalikan ke tampilan awal">Reset Tampilan</button>
                <table class="table table-striped table-bordered nowrap" style="font-size:11px;" id="mydata">
                    <textarea id="tambah-column-hidden" style="display: none;"></textarea>
                    <textarea id="kurang-column-hidden" style="display: none;"></textarea>
                    <textarea id="retur-column-hidden" style="display: none;"></textarea>
                    <thead> 
                        <tr>
                            <th style="text-align:center;vertical-align:middle;">No</th>
                            <th style="text-align:center;vertical-align:middle;">Kode Barang</th>
                            <th style="max-width:200px;text-align:center;vertical-align:middle;">Nama Barang</th>
                            <th style="text-align:center;color:#4f81bd;" data-orderable="false" id="tambah-column">
                                <div style="margin-bottom: 5px;">Penambahan Stok</div>
                                <button class="btn btn-sm btn-tambah" data-clipboard-target="#tambah-column-hidden" style="background-color: #aeec64;" title="Copy Seluruh Baris Penambahan Stok">Copy All</button>
                            </th>
                            <th style="text-align:center;color:#4f81bd;" data-orderable="false" id="kurang-column">
                                <div style="margin-bottom: 5px;">Pengurangan Stok</div>
                                <button class="btn btn-sm btn-kurang" data-clipboard-target="#kurang-column-hidden" style="background-color: #aeec64;" title="Copy Seluruh Baris Pengurangan Stok">Copy All</button>
                            </th>
                            <th style="text-align:center;color:#4f81bd;" data-orderable="false" id="retur-column">
                                <div style="margin-bottom: 5px;">Retur</div>
                                <button class="btn btn-sm btn-retur" data-clipboard-target="#retur-column-hidden" style="background-color: #aeec64;" title="Copy Seluruh Baris Retur">Copy All</button>
                            </th>
                            <th style="text-align:center;vertical-align:middle;">Satuan</th>
                            <th style="text-align:center;vertical-align:middle;">Kategori</th>
                            <th style="text-align:center;vertical-align:middle;">Aksi</th>
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
                            $kategori=$a['barang_kategori_nama'];
                            $stok_tambah=$a['stok_tambah'];
                            if (floor($stok_tambah) == $stok_tambah) {
                                $formatted_stok_tambah = number_format($stok_tambah, 0, ',', '.');
                            } else {
                                $formatted_stok_tambah = number_format($stok_tambah, 2, ',', '.');
                                $formatted_stok_tambah = rtrim($formatted_stok_tambah, '0');
                                $formatted_stok_tambah = rtrim($formatted_stok_tambah, ',');
                            }
                            $stok_kurang=$a['stok_kurang'];
                            if (floor($stok_kurang) == $stok_kurang) {
                                $formatted_stok_kurang = number_format($stok_kurang, 0, ',', '.');
                            } else {
                                $formatted_stok_kurang = number_format($stok_kurang, 2, ',', '.');
                                $formatted_stok_kurang = rtrim($formatted_stok_kurang, '0');
                                $formatted_stok_kurang = rtrim($formatted_stok_kurang, ',');
                            }
                            $retur=$a['retur'];
                            if (floor($retur) == $retur) {
                                $formatted_retur = number_format($retur, 0, ',', '.');
                            } else {
                                $formatted_retur = number_format($retur, 2, ',', '.');
                                $formatted_retur = rtrim($formatted_retur, '0');
                                $formatted_retur = rtrim($formatted_retur, ',');
                            }
                    ?>
                        <tr>
                            <td style="text-align:center;"><?php echo $no;?></td>
                            <td><?php echo $id;?></td>
                            <td style="max-width:200px;overflow:hidden;"><?php echo $nm;?></td>
                            <td class="tambah-column" style="text-align:center;"><?php echo $formatted_stok_tambah;?></td>
                            <td class="kurang-column" style="text-align:center;"><?php echo $formatted_stok_kurang;?></td>
                            <td class="retur-column" style="text-align:center;"><?php echo $formatted_retur;?></td>
                            <td style="text-align:center;"><?php echo $satuan;?></td>
                            <td style="text-align:center;"><?php echo $kategori;?></td>
                            <td style="text-align:center;">
                                <a class="btn btn-xs btn-warning btn-lihat" href="#modalLihat" data-toggle="modal" data-idbrg="<?= $id ;?>" data-nmbrg="<?= htmlspecialchars($nm);?>" title="Lihat Data"><span class="fa fa-eye"></span> Lihat Data</a>
                            </td>    
                           
                            
                        </tr>
                    <?php endforeach;?>
                    </tbody>
                </table>
            </div>
        </div>
   
       <!-- ============ MODAL LIHAT =============== -->
        <div class="modal fade" id="modalLihat" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
            <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 class="modal-title" id="myModalLabel">Data History Stok  <span id="nmcabVal"></h3>
            </div>
                <div class="modal-body" style="overflow:scroll;height:450px;">
                    <p style="font-size: 11px; margin-bottom: 0;">
                    Kode Barang : <b><span id="kdbrgVal" style="color: green;"></span></b>
                    </p>
                    <p style="font-size: 11px; margin-bottom: 0;">
                    Nama Barang : <b><span id="nmbrgVal" style="color: green;"></span></b>
                    </p>
                    <p style="font-size: 11px; margin-bottom: 0;">
                    Tanggal : <b><span id="tglVal" style="color: green;"></span></b>
                    </p>    
                    <input type="hidden" id="kdbrg" name="kdbrg">      
                
                
                <table id="tbl_history" class="table table-striped table-bordered" style="font-size:11px;">
                    <thead>
                        <tr>
                            <th style="text-align:center;"> No</th>
                            <th style="text-align:center;"> Stok No</th>
                            <th style="text-align:center"> Keterangan</th>
                            <th style="text-align:center"> Stok Status</th>
                            <th style="text-align:center"> Stok In</th>
                            <th style="text-align:center"> Stok Out</th>
                            <th style="text-align:center"> Cabang</th>
                            <th style="text-align:center"> Created By</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
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
$(document).ready(function () {
    $('#datepicker').datetimepicker({
    format: 'YYYY-MM-DD',
    widgetPositioning: {
        vertical: 'bottom',
        horizontal: 'auto'
        }
    });
    
});
</script>

<!-------------stok tambah---------------->
<!-- <script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function () {
        var clipboard = new ClipboardJS('.btn-tambah', {
            text: function () {
                // Collect all values from the 'awal-column' cells
                var columnValues = $('.tambah-column').map(function () {
                    return $(this).text();
                }).get().join('\n');

                // Set the value of the hidden textarea to the collected content
                $('#tambah-column-hidden').val(columnValues);

                // Return the value to be copied
                return columnValues;
            }
        });

        clipboard.on('success', function (e) {
            //console.info('Text copied to clipboard:', e.text);
            alert('Data berhasil disalin dan siap untuk di-paste!');
        });

        clipboard.on('error', function (e) {
            //console.error('Failed to copy text to clipboard:', e.action);
            alert('Gagal menyalin data. Silakan coba lagi.');
        });

        // Inisialisasi DataTable dengan scroll dan tanpa paging
        $('#mydata').DataTable({
            scrollY: "350px",
            paging: false
        });
    });
</script> -->

<!-- <script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function () {
        // Fungsi untuk meng-handle copy All
        function handleCopyAll(buttonClass, hiddenTextareaId, columnClass) {
            var clipboard = new ClipboardJS(buttonClass, {
                text: function () {
                    // Collect all values from the specified column cells
                    var columnValues = $(columnClass).map(function () {
                        return $(this).text();
                    }).get().join('\n');

                    // Set the value of the hidden textarea to the collected content
                    $(hiddenTextareaId).val(columnValues);

                    // Return the value to be copied
                    return columnValues;
                }
            });

            clipboard.on('success', function (e) {
                alert('Data berhasil disalin dan siap untuk di-paste!');
            });

            clipboard.on('error', function (e) {
                alert('Gagal menyalin data. Silakan coba lagi.');
            });
        }

        // Copy All for btn-tambah
        handleCopyAll('.btn-tambah', '#tambah-column-hidden', '.tambah-column');

        // Copy All for btn-kurang
        handleCopyAll('.btn-kurang', '#kurang-column-hidden', '.kurang-column');

        // Copy All for btn-retur
        handleCopyAll('.btn-retur', '#retur-column-hidden', '.retur-column');

        // Inisialisasi DataTable dengan scroll dan tanpa paging
        $('#mydata').DataTable({
            scrollY: "350px",
            paging: false
        });

    });


</script> -->


<script type="text/javascript">
    // Declare the 'table' variable outside the 'DOMContentLoaded' function
    var table;

    document.addEventListener('DOMContentLoaded', function () {
        // Fungsi untuk meng-handle copy All
        function handleCopyAll(buttonClass, hiddenTextareaId, columnClass) {
            var clipboard = new ClipboardJS(buttonClass, {
                text: function () {
                    // Collect all values from the specified column cells
                    var columnValues = $(columnClass).map(function () {
                        return $(this).text();
                    }).get().join('\n');

                    // Set the value of the hidden textarea to the collected content
                    $(hiddenTextareaId).val(columnValues);

                    // Return the value to be copied
                    return columnValues;
                }
            });

            clipboard.on('success', function (e) {
                alert('Data berhasil disalin dan siap untuk di-paste!');
            });

            clipboard.on('error', function (e) {
                alert('Gagal menyalin data. Silakan coba lagi.');
            });
        }

        // Copy All for btn-tambah
        handleCopyAll('.btn-tambah', '#tambah-column-hidden', '.tambah-column');

        // Copy All for btn-kurang
        handleCopyAll('.btn-kurang', '#kurang-column-hidden', '.kurang-column');

        // Copy All for btn-retur
        handleCopyAll('.btn-retur', '#retur-column-hidden', '.retur-column');

        // Initialize DataTable with scroll and without paging
        table = $('#mydata').DataTable({
            scrollY: "350px",
            paging: false,
            ordering : false

        });

        // Event handler for the "Tampilkan Data" button
        $('.btn-tampilkan').on('click', function () {
            // Filter DataTable rows based on the criteria
            table.rows().every(function (rowIdx, tableLoop, rowLoop) {
                var tambahColumn = parseFloat(this.data()[3].replace(/[^\d.-]/g, '')) || 0; // Kolom Penambahan Stok
                var kurangColumn = parseFloat(this.data()[4].replace(/[^\d.-]/g, '')) || 0; // Kolom Pengurangan Stok
                var returColumn = parseFloat(this.data()[5].replace(/[^\d.-]/g, '')) || 0;  // Kolom Retur

                // Check if at least one of the three columns has a value greater than 0
                var shouldShowRow = tambahColumn > 0 || kurangColumn > 0 || returColumn > 0;

                // Show or hide the row based on the condition
                this.nodes().to$().toggle(shouldShowRow);
            });

            // Redraw the table after making changes
            table.draw(false);
        });


        // Add a button to reset the table and show all rows
        $('.btn-reset').on('click', function () {
            // Show all rows
            table.rows().every(function (rowIdx, tableLoop, rowLoop) {
                this.nodes().to$().show();
            });

            // Redraw the table after making changes
            table.draw(false);
        });


    });
</script>


<script type="text/javascript">
$(document).ready(function () {
    $('select[name="regid"]').on('change', function() {
        const namcab = $('#regid option:selected').text();
        $('#namacab').val(namcab);
    });

    $(document).on('click', '.btn-tampil', function () {
        var form = document.querySelector('#myForm'); 
        form.action = "<?php echo base_url().'admin/history_stok/tampil_data';?>"; 
        form.target = '_self';
        form.submit(); // Mengirimkan formulir
    });
});

    function varCetak_Excel() {
        var form = document.querySelector('#myForm'); 
        form.action = "<?php echo base_url().'admin/history_stok/cetak_stok_excel';?>";
        //form.target = '_blank';
        form.submit(); // Mengirimkan formulir
    }
</script>



<script type="text/javascript">
$(document).ready(function () {
    $(document).on('click', '.btn-lihat', function () {
        var idbrg = $(this).data('idbrg');
        var nmbrg = $(this).data('nmbrg');
        var tgl = $('#tgl').val();
        $('#kdbrgVal').text(idbrg);
        $('#nmbrgVal').text(nmbrg);
        $('#tglVal').text(tgl);
        $('#kdbrg').val(idbrg);
        tampil_stok();

    });
    
    $(document).on('click', '.btn-history', function () {
        tampil_stok();
    });

    function tampil_stok() {
        $('#tbl_history tbody').empty();
        var tgl = $('#tgl').val();
        var idbrg=$('#kdbrg').val();
        const regid = $('#regid option:selected').val();
        const namcab = $('#regid option:selected').text();
        $('#nmcabVal').text(namcab);
        $.ajax({
            url: "<?php echo base_url().'admin/history_stok/history_stok';?>",
            type: "POST",
            data: {
                tgl: tgl,
                idbrg: idbrg,
                regid: regid
            },
            success: function (data) {
                //console.log("Data from server:", data);
                //console.log(regid);
                // console.log(tgl1);
                // console.log(tgl2);
                try {
                    var parsedData = JSON.parse(data);
                    if ("error" in parsedData) {
                        console.log(parsedData.error); // Tampilkan pesan error
                    } else if (parsedData.length !== 0) {
                        var no=0;
                        $.each(parsedData, function (index, item) {
                                no++;
                                var stokin = parseFloat(item.stok_in);
                                var stokout = parseFloat(item.stok_out);
                                var formatted_stokin;
                                if (Math.floor(stokin) === stokin) {
                                    formatted_stokin = stokin.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ','); // Format sebagai bilangan bulat
                                } else {
                                    formatted_stokin = stokin.toFixed(2).replace('.', ',').replace(/\.?0+$/, '').replace(/\B(?=(\d{3})+(?!\d))/g, ','); // Format sebagai bilangan desimal
                                }
                                var formatted_stokout;
                                if (Math.floor(stokout) === stokout) {
                                    formatted_stokout = stokout.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ','); // Format sebagai bilangan bulat
                                } else {
                                    formatted_stokout = stokout.toFixed(2).replace('.', ',').replace(/\.?0+$/, '').replace(/\B(?=(\d{3})+(?!\d))/g, ','); // Format sebagai bilangan desimal
                                }
                                var newRow = '<tr>' +
                                    '<td style="font-size:11px;text-align:center;">' + no + '</td>' +
                                    '<td style="font-size:11px;">' + item.stok_no + '</td>' +
                                    '<td style="font-size:11px;text-align:center;">' + item.stok_ket + '</td>' +
                                    '<td style="font-size:11px;text-align:center;">' + item.stok_status + '</td>' +
                                    '<td style="font-size:11px;text-align:center;">' + formatted_stokin + '</td>' +
                                    '<td style="font-size:11px;text-align:center;">' + formatted_stokout + '</td>' +
                                    '<td style="font-size:11px;text-align:center;">' + item.reg_name + '</td>' +
                                    '<td style="font-size:11px;text-align:center;">' + item.created_by + '</td>' +
                                    '</tr>';
                                $('#tbl_history tbody').append(newRow);

                        });
                        
                    } else {
                        console.log("No data found.");
                    }
                } catch (error) {
                    console.error("Error parsing JSON:", error);
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX error:", error);
            }
        });
    }

});
</script>






</body>
</html>
