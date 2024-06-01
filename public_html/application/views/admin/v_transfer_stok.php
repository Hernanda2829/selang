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

    <title>Transfer Stok</title>
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
                <h3>Transfer Stok
                    <small>Barang - <?php echo $userid['reg_code'];?>  <?php echo $userid['reg_name'];?></small>
                    <div class="pull-right"><a href="#" class="btn btn-sm btn-success" id="btnSimpanRequest" data-toggle="modal" title="Click tombol ini jika sudah memilih dan mengisi Qty Kirim"><span class="fa fa-save"></span> Simpan Transfer Stok</a></div>
                </h3>
                <hr style="margin-bottom:10px;">
                <table style="margin:0;">
                    <input type="hidden" id="idreg" name="idreg" value="<?php echo $userid['reg_id'];?>">
                    <th style="padding-right:10px;">Pilih Cabang Penerima : </th>
                    <td>
                        <select name="regid" id="regid" class="selectpicker show-tick form-control" data-live-search="true" title="Pilih Cabang" data-width="200px" required>
                        <?php
                        $id_reg = $userid['reg_id'];
                        $regions_data = $this->Mlogin->tampil_regions()->result_array();
                        foreach ($regions_data as $rg) {
                            $reg_id = $rg['reg_id'];
                            $reg_name = $rg['reg_name'];  
                            if ($reg_id != $id_reg) { // Jika reg_id tidak sama dengan id_reg
                                echo '<option value="'.$reg_id.'" style="font-size:12px">'.$reg_name.'</option>';
                            }
                        }
                        ?>
                        </select>
                    </td>
                </table>
                <hr style="margin-top:10px;">        
            </div>
        </div>
        <!-- /.row -->
        <!-- Projects Row -->
        <div class="row">
            <div class="col-lg-12">
            <table class="table table-bordered table-condensed" style="font-size:11px;" id="mydata">
                <thead>
                    <tr>
                        <th style="max-width:15px;text-align:center;vertical-align:middle;background-image:none!important" title="Centang kotak isian dibawah ini, untuk memilih Kode Barang">Check</th>
                        <th style="max-width:40px;text-align:center;vertical-align:middle;" title="Ketikan Jumlah/Quantity, pada kotak isian di bawah ini">Qty Kirim</th>
                        <th style="max-width:30px;text-align:center;vertical-align:middle;">Stok Tersedia</th>
                        <th style="max-width:30px;text-align:center;vertical-align:middle;">Kode Barang</th>
                        <th style="text-align:center;vertical-align:middle;">Nama Barang</th>
                        <th style="max-width:10px;text-align:center;vertical-align:middle;">Satuan</th>
                        <th style="max-width:40px;text-align:center;vertical-align:middle;">Kategori</th>   
                        <th style="max-width:50px;text-align:center;vertical-align:middle;">Harga Jual</th>
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
                        $harjul=$a['barang_harjul'];
                        $kat=$a['barang_kategori_nama'];
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
                        <td style="text-align:center;"><input type="checkbox" name="check<?php echo $id;?>"></td>
                        <td style="text-align:center;"><input type="text" name="qty<?php echo $id;?>" style="width:70px;" min="0" max="<?php echo $formatted_stok;?>" readonly></td> 
                        <td style="text-align:center;"><?php echo $formatted_stok;?></td>
                        <td><?php echo $id;?></td>
                        <td style="max-width:200px;overflow:hidden;"><?php echo $nm;?></td>
                        <td style="text-align:center;"><?php echo $sat;?></td>                        
                        <td style="text-align:center;"><?php echo $kat;?></td>
                        <td style="text-align:right;"><?php echo 'Rp ' . str_replace(',', '.', number_format($harjul)); ?></td> 
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
                <h3 class="modal-title" id="myModalLabel"><small>Transfer Stok Barang - <?php echo $userid['reg_code'];?>  <?php echo $userid['reg_name'];?> Ke - <span id="cabterima"></span></small></h3>
            </div>
                <div class="modal-body" style="overflow:scroll;height:400px;">

                  <table class="table table-bordered table-condensed" style="font-size:11px;">
                    <thead>
                        <tr>
                            <th style="text-align:center;">No</th>
                            <th style="text-align:center;">Qty Kirim</th>
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
    // var table = $('#mydata').DataTable({
    //     "columnDefs": [{ "orderable": false, "targets": [0, 1, 4] }],
    //     "lengthMenu": [[5, 10, 25, 50, 100], [5, 10, 25, 50, 100]]
    // });
    var table = $('#mydata').DataTable();

    $(document).on('input', 'input[name^="qty"]', function(e) {
        var inputValue = e.target.value;
        var sanitizedValue = inputValue.replace(/[^0-9,\b\t]/g, ''); // Hapus karakter yang tidak diizinkan (selain angka, koma, backspace, delete, dan tab)
        e.target.value = sanitizedValue; // Update nilai input dengan karakter yang diizinkan
    });

    //contoh 1 -----------------------------------------------------------------
    // membatasi input qty sesuai stok yang tersedia
    // var inputElements = document.querySelectorAll('input[name^="qty"]');
    // inputElements.forEach(function(inputElement) {
    //     inputElement.addEventListener('input', function() {
    //         var min = parseFloat(this.min.replace(',', '.'));
    //         var maxFormatted = this.max.replace('.', ''); // Hilangkan titik sebagai pemisah ribuan
    //         var max = parseFloat(maxFormatted);
    //         var value = parseFloat(this.value.replace(/\./g, '').replace(',', '.')); // Parsing dan memformat nilai input
    //         if (isNaN(value)) {
    //             this.value = min;
    //         } else if (value < min) {
    //             this.value = min;
    //         } else if (value > max) {
    //             this.value = maxFormatted; // Tetapkan nilai maksimum dalam format yang benar
    //         }
    //     });
    // });
    
    //contoh 2 -----------------------------------------------------------------
    // membatasi input qty sesuai stok yang tersedia
    var inputElements = document.querySelectorAll('input[name^="qty"]');
    inputElements.forEach(function(inputElement) {
        inputElement.addEventListener('input', function() {
            var min = parseFloat(this.min.replace(',', '.'));
            var maxFormatted = this.max.replace('.', ''); // Hilangkan titik sebagai pemisah ribuan
            var max = parseFloat(maxFormatted.replace(',', '.')); // Parsing nilai maksimum dalam format yang benar
            var value = parseFloat(this.value.replace(/\./g, '').replace(',', '.')); // Parsing dan memformat nilai input
            if (isNaN(value)) {
                this.value = min;
            } else if (value < min) {
                this.value = min;
            } else if (value > max) {
                this.value = maxFormatted; // Tetapkan nilai maksimum dalam format yang benar
            }
        });
    });

    //--------------------------------------------------------------------------



    $('#btnSimpanRequest').click(function(event) {
        event.preventDefault(); // Menghentikan perilaku bawaan klik pada tautan
        // Get the value of regid
        var regid = $('#regid').val();
        var namacab = $('#regid option:selected').text();
        if (!regid) {
            alert("Mohon tentukan terlebih dahulu Cabang Penerima.");
        } else {
            $('#cabterima').text(namacab);
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
                    var qtyInput = $(this.node()).find('input[name="qty' + id + '"]');
                    var qty = qtyInput.val();
                    
                    // cek cara 1 tidak bisa input 0,1 atau 0, lainya
                    //Check if qty is filled and greater than 0
                    // if (qty === '' || parseInt(qty) <= 0) {
                    //     alert("Mohon isi jumlah barang dengan benar.");
                    //     qtyInput.focus(); // Focus back to the quantity input
                    //     isValid = false; // Set validation flag to false
                    //     return false; // Exit the loop
                    // }

                    // cek cara 2
                    var numericValue = parseFloat(qty.replace(',', '.')) || 0;
                    if (numericValue <= 0) { 
                        alert("Mohon isi jumlah barang dengan benar.");
                        qtyInput.focus(); // Focus back to the quantity input
                        isValid = false; // Set validation flag to false
                        return false; // Exit the loop
                    }
                    
                    var kode_barang = data[3]; // Menggunakan data dari DataTable
                    var nama_barang = data[4]; // Menggunakan data dari DataTable
                    var satuan = data[5]; // Menggunakan data dari DataTable
                    var kategori = data[6]; // Menggunakan data dari DataTable

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
        }
    });



    $('#btnSimpan').click(function() {
    //var regid = $('#regid').val();
    var regid = $('#regid option:selected').val();
    //const regid = $('#regid option:selected').val();  //mengambil nilai value select option
    //const namcab = $('#regid option:selected').text(); //mengambil pilihan isi select option
    // Bersihkan requestData setiap kali tombol Simpan ditekan
    requestData = [];
        // Iterate through all rows in DataTable
        table.rows().every(function() {
            var data = this.data();
            var checkbox = $(this.node()).find('input[name^="check"]');
            if (checkbox.is(':checked')) {
                var id = checkbox.attr('name').replace('check', '');
                var qty = $(this.node()).find('input[name="qty' + id + '"]').val();
                var kode_barang = data[3]; // Kolom ketiga Kode Barang
                var nama_barang = data[4];
                var satuan = data[5];
                var kategori = data[6];

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
            url: "<?php echo base_url().'admin/transfer_stok/simpan_transtok';?>",
            data: {
                requestData: requestData,
                regid : regid
            },
            success: function(response) {
                var jsonResponse = JSON.parse(response);
                $('#successMessage').text('' + jsonResponse.message);
                $('#requestModal').modal('hide');// Tutup modal
                
                // Iterate through all rows in DataTable
                table.rows().every(function() {
                    var checkbox = $(this.node()).find('input[name^="check"]');
                    var qtyInput = $(this.node()).find('input[name^="qty"]');    
                    if (checkbox.is(':checked')) {
                        // Mengosongkan input dan menghapus centang yang terkait dengan data yang tercentang
                        qtyInput.val('');
                        checkbox.prop('checked', false);
                    }
                });

                window.location.reload();

            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
            }
        });
    });



});


</script>


<script>
// pencegahan input Qty Kirim Melebihi Stok yang tersedia
$('input[name^="check"]').on('change', function() {
    var row = $(this).closest('tr');
    //var stok = row.find('td:eq(2)').text(); // Mengambil nilai dari kolom ketiga
    var idbrg = row.find('td:eq(3)').text(); // Mengambil nilai dari kolom ketiga
    var qtyInput = row.find('input[name^="qty"]');
    if ($(this).prop('checked')) {
        qtyInput.removeAttr('readonly');
    }else {
        qtyInput.prop('readonly', true);
        qtyInput.val('');
    }
});



</script>


    
</body>
</html>
