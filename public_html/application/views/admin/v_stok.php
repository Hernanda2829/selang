<!DOCTYPE html>
<html lang="en">

<head>
    <?php 
	error_reporting(0);
    $userid=$userid->row_array();
    ?>  
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Produk By <?php echo $userid['co_name'];?>">
    <meta name="author" content="<?php echo $userid['co_name'];?>">

    <title>Request Stok</title>
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

<style>
    table.dataTable thead .sorting_asc::after {
    content: none;
    }

    .modal-dialog {
        max-height: 90vh; /* Atur tinggi maksimum sesuai kebutuhan Anda */
        overflow-y: auto; /* Aktifkan scrollbar jika kontennya melebihi tinggi maksimum */
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
                <center><span id="successMessage" style="color:white;background-color:green;"></span></center>
                <h3 class="page-header">Request Stok
                    <small>Barang - <?php echo $userid['reg_code'];?>  <?php echo $userid['reg_name'];?> </small>
                    <div class="pull-right"><a href="#" class="btn btn-sm btn-success" id="btnSimpanRequest" data-toggle="modal"><span class="fa fa-save"></span> Simpan Request Stok</a></div>
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
                        <th style="max-width:15px;text-align:center;vertical-align:middle;background-image:none!important" title="Centang kotak isian dibawah ini, untuk Request Kode Barang yang di inginkan">Check</th>
                        <th style="max-width:40px;text-align:center;vertical-align:middle;" title="Ketikan Jumlah/Quantity yang di inginkan, pada kotak isian di bawah ini">Qty Request</th>
                        <th style="max-width:30px;text-align:center;vertical-align:middle;">Kode Barang</th>
                        <th style="text-align:center;vertical-align:middle;">Nama Barang</th>
                        <th style="max-width:10px;text-align:center;vertical-align:middle;">Satuan</th>
                        <th style="max-width:40px;text-align:center;vertical-align:middle;">Kategori</th>
                        
                        
                    </tr>  
                </thead>
                <tbody>
                <?php 
                    $no=0;
                    foreach ($data->result_array() as $a):
                        //$no++;
                        $id=$a['barang_id'];
                        $nm=$a['barang_nama'];
                        $sat=$a['barang_satuan'];
                        $kat=$a['barang_kategori_nama'];
                ?>
                    <tr>
                        <td style="text-align:center;"><input type="checkbox" name="check<?php echo $id;?>"></td>
                        <td style="text-align:center;"><input type="text" name="text<?php echo $id;?>" style="width:70px;"></td> 
                        <td><?php echo $id;?></td>
                        <td style="max-width:200px;overflow:hidden;"><?php echo $nm;?></td>
                        <td style="text-align:center;"><?php echo $sat;?></td>
                        <td style="text-align:center;"><?php echo $kat;?></td> 
                        
                    </tr>
                <?php endforeach;?>
                </tbody>
            </table>
            </div>
        </div>
        <!-- /.row -->
        <!-- ============ MODAL Simpan =============== -->

        <div class="modal fade" id="requestModal" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
            <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 class="modal-title" id="myModalLabel">Request Stok Barang- <?php echo $userid['reg_code'];?>  <?php echo $userid['reg_name'];?></h3>
            </div>
                <div class="modal-body" style="overflow:scroll;height:400px;">

                  <table class="table table-bordered table-condensed" style="font-size:11px;">
                    <thead>
                        <tr>
                            <th style="text-align:center;">No</th>
                            <th style="text-align:center;">Qty Request</th>
                            <th style="text-align:center;">Kode Barang</th>
                            <th style="text-align:center;">Nama Barang</th>
                            <th style="text-align:center;">Satuan</th>
                            <th style="text-align:center;">Kategori</th>
                        </tr>
                    </thead>
                    <tbody id="selectedItems">
                        <!-- Data item yang dipilih akan ditampilkan di sini -->
                    </tbody>
                </table>          

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-info" id="btnSimpan">Simpan</button>    
                    <button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
                </div>
            </div>
            </div>
        </div>
        
        <!-- ============ MODAL EDIT =============== -->
        

        <!-- ============ MODAL HAPUS =============== -->
        
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
    <script src="<?php echo base_url().'assets/js/jquery.price_format.min.js'?>"></script>
    <!-- ... -->
<script type="text/javascript">
$(document).ready(function() {
    var table = $('#mydata').DataTable({
        "columnDefs": [{ "orderable": false, "targets": [0, 1, 4] }],
        "lengthMenu": [[5, 10, 25, 50, 100], [5, 10, 25, 50, 100]]
    });

    $(document).on('input', 'input[name^="text"]', function(e) {
        var inputValue = e.target.value;
        var sanitizedValue = inputValue.replace(/[^0-9,\b\t]/g, ''); // Hapus karakter yang tidak diizinkan (selain angka, koma, backspace, delete, dan tab)
        e.target.value = sanitizedValue; // Update nilai input dengan karakter yang diizinkan
    });


    //perintah lama
    // $('#btnSimpanRequest').click(function() {
    //     // Clear previous content in the modal
    //     $('#selectedItems').empty();
    //     var no = 1; // Nomor urut awal
    //     // Iterate through all rows in DataTable
    //     table.rows().every(function() {
    //         var data = this.data();
    //         var checkbox = $(this.node()).find('input[name^="check"]');
            
    //         if (checkbox.is(':checked')) {
    //             var id = checkbox.attr('name').replace('check', '');
    //             var qty = $(this.node()).find('input[name="text' + id + '"]').val();
    //             var kode_barang = data[2]; // Menggunakan data dari DataTable
    //             var nama_barang = data[3]; // Menggunakan data dari DataTable
    //             var satuan = data[4]; // Menggunakan data dari DataTable
    //             var kategori = data[5]; // Menggunakan data dari DataTable

    //             var row = '<tr><td style="text-align:center;">' + no + '</td><td style="text-align:center;">' + qty + '</td><td>' + kode_barang + '</td><td>' + nama_barang + '</td><td style="text-align:center;">' + satuan + '</td><td style="text-align:center;">' + kategori+ '</td></tr>';
    //             $('#selectedItems').append(row);
    //             no++;
                
    //         }
    //     });
    // });

    $('#btnSimpanRequest').click(function(event) {
        event.preventDefault(); // Menghentikan perilaku bawaan klik pada tautan

        // Clear previous content in the modal
        $('#selectedItems').empty();
        var no = 1; // Nomor urut awal
        var isValid = true; // Flag to track validation
        var isChecked = false; // Flag to track if at least one checkbox is checked

        // Iterate through all rows in DataTable
        table.rows().every(function() {
            var data = this.data();
            var checkbox = $(this.node()).find('input[name^="check"]');
            
            if (checkbox.is(':checked')) {
                isChecked = true; // Set isChecked to true if at least one checkbox is checked
                
                var id = checkbox.attr('name').replace('check', '');
                var qtyInput = $(this.node()).find('input[name="text' + id + '"]');
                var qty = qtyInput.val();
                
                // Check if qty is filled and greater than 0
                if (qty === '' || parseInt(qty) <= 0) {
                    alert("Mohon isi jumlah barang dengan benar.");
                    qtyInput.focus(); // Focus back to the quantity input
                    isValid = false; // Set validation flag to false
                    return false; // Exit the loop
                }
                
                var kode_barang = data[2]; // Menggunakan data dari DataTable
                var nama_barang = data[3]; // Menggunakan data dari DataTable
                var satuan = data[4]; // Menggunakan data dari DataTable
                var kategori = data[5]; // Menggunakan data dari DataTable

                var row = '<tr><td style="text-align:center;">' + no + '</td><td style="text-align:center;">' + qty + '</td><td>' + kode_barang + '</td><td>' + nama_barang + '</td><td style="text-align:center;">' + satuan + '</td><td style="text-align:center;">' + kategori+ '</td></tr>';
                $('#selectedItems').append(row);
                no++;
            }
        });
        
        // Check if at least one checkbox is checked
        if (!isChecked) {
            alert("Harap pilih setidaknya satu item.");
        } else {
            // Check validation flag
            if (isValid) {
                // Jika semua validasi sukses, tampilkan modal
                $('#requestModal').modal('show');
            }
        }
    });


    $('#btnSimpan').click(function() {
    // Bersihkan requestData setiap kali tombol Simpan ditekan
    requestData = [];
        // Iterate through all rows in DataTable
        table.rows().every(function() {
            var data = this.data();
            var checkbox = $(this.node()).find('input[name^="check"]');
            if (checkbox.is(':checked')) {
                var id = checkbox.attr('name').replace('check', '');
                var qty = $(this.node()).find('input[name="text' + id + '"]').val();
                var kode_barang = data[2]; // Kolom ketiga Kode Barang
                var nama_barang = data[3];
                var satuan = data[4];
                var kategori = data[5];

                // Tambahkan data ke array requestData
                requestData.push({
                    id: id,
                    //qty: qty,
                    qty: qty.replace(/,/g, '.'),
                    kode_barang: kode_barang,
                    nama_barang: nama_barang,
                    satuan: satuan,
                    kategori: kategori
                });
            }
        });

        // Lakukan AJAX dengan requestData yang sudah diisi
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url().'admin/stok/simpan_reqstok';?>",
            data: {requestData: requestData},
            success: function(response) {
                var jsonResponse = JSON.parse(response);
                $('#successMessage').text('' + jsonResponse.message);
                $('#requestModal').modal('hide');// Tutup modal
                
                // Iterate through all rows in DataTable
                table.rows().every(function() {
                    var checkbox = $(this.node()).find('input[name^="check"]');
                    var qtyInput = $(this.node()).find('input[name^="text"]');    
                    if (checkbox.is(':checked')) {
                        // Mengosongkan input dan menghapus centang yang terkait dengan data yang tercentang
                        qtyInput.val('');
                        checkbox.prop('checked', false);
                    }
                });

            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
            }
        });
    });



});


</script>
<!-- ... -->


    
</body>
</html>
