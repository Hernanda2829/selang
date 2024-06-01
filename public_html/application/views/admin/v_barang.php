<!DOCTYPE html>
<html lang="en">

<head>
    <?php 
    // Set error reporting to display all errors
    //error_reporting(E_ALL);
    //ini_set('display_errors', 1);
    
	error_reporting(0);
    $userid=$userid->row_array();
    ?>  
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Produk By <?php echo $userid['co_name'];?>">
    <meta name="author" content="<?php echo $userid['co_name'];?>">

    <title>Management data barang</title>
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
    <!-- Data Table Fixed Columnn -->
    <link href="<?php echo base_url().'assets/js/dataTable/dataTables.bootstrap4.min.css'?>" rel="stylesheet">
    <link href="<?php echo base_url().'assets/js/dataTable/fixedColumns.bootstrap4.min.css'?>" rel="stylesheet">

<style>
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
                <h1 class="page-header">Data
                    <small>Barang</small>
                    <div class="pull-right"><a href="#" class="btn btn-sm btn-success" data-toggle="modal" data-target="#largeModal"><span class="fa fa-plus"></span> Tambah Barang</a></div>
                </h1>
            </div>
        </div>
        <!-- /.row -->
        <!-- Projects Row -->
        <div class="row">
            <div class="col-lg-12">
                <table class="table table-striped table-bordered nowrap" style="font-size:11px;" id="mydata">
                    <thead>
                        <tr>
                            <th rowspan="2" style="text-align:center;vertical-align:middle;">No</th>
                            <th rowspan="2" style="text-align:center;vertical-align:middle;">Kode Barang</th>
                            <th rowspan="2" style="max-width:200px;overflow:hidden;text-align:center;vertical-align:middle;">Nama Barang</th>
                            <th rowspan="2" style="text-align:center;vertical-align:middle;" data-orderable="false">Kode Disc</th>
                            <th rowspan="2" style="text-align:center;vertical-align:middle;" data-orderable="false">Satuan</th>
                            <th rowspan="2" style="text-align:center;vertical-align:middle;">Harga Pokok</th>
                            <th rowspan="2" style="text-align:center;vertical-align:middle;">Harga Jual</th>
                            <th rowspan="2" style="text-align:center;vertical-align:middle;">Stok Global</th>
                            <th colspan="<?php echo $jmlreg; ?>" style="text-align:center;">Stok_Region</th>
                            <th rowspan="2" style="text-align:center;">Kategori</th>
                            <th rowspan="2" style="max-width:100px!important;text-align:center;" data-orderable="false">Aksi</th>
                        </tr>
                        <tr>
                            <?php foreach ($regions->result_array() as $reg) :
                                $reg_name = $reg['reg_name'];
                                $nick_name = $reg['nick_name'];
                            ?>
                                <th style="text-align: center; cursor: pointer;" data-orderable="false" title="<?php echo htmlspecialchars($reg_name); ?>">
                                    <?php echo $nick_name; ?>
                                </th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody></tbody>
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
                <h3 class="modal-title" id="myModalLabel">Tambah Barang</h3>
            </div>
            <form class="form-horizontal" method="post" action="<?php echo base_url().'admin/barang/tambah_barang'?>">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="control-label col-xs-4" >Kode Barang</label>
                        <div class="col-xs-8">
                            <input name="kobar" class="form-control" type="text" placeholder="Kode Barang..." style="width:335px;" maxlength="15" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-4" >Nama Barang</label>
                        <div class="col-xs-8">
                            <input name="nabar" class="form-control" type="text" placeholder="Nama Barang..." style="width:335px;" maxlength="150" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-4" >Diskon</label>
                        <div class="col-xs-8">
                            <select name="diskon" class="selectpicker show-tick form-control" data-live-search="true" title="Pilih Jenis Diskon" data-width="80%" placeholder="Pilih Diskon" required>
                            <?php foreach ($diskon->result_array() as $dc) {
                                $dc_id=$dc['disc_id'];
                                $dc_rate=$dc['disc_rate'];
                                ?>
                                    <option value="<?php echo $dc_id;?>"><?php echo $dc_rate;?></option>
                            <?php }?>
                                    <option value=0>Tidak Ada Diskon</option>                
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-4" >Kategori</label>
                        <div class="col-xs-8">
                            <select name="kategori" class="selectpicker show-tick form-control" data-live-search="true" title="Pilih Kategori" data-width="80%" placeholder="Pilih Kategori" required>
                            <?php 
                                foreach ($kat->result_array() as $k) {
                                $id_kat=$k['kategori_id'];
                                $nm_kat=$k['kategori_nama'];
                                echo '<option value='.$id_kat.'>'.$nm_kat.'</option>' ;
                                }
                            ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-4" >Satuan</label>
                        <div class="col-xs-8">
                             <select name="satuan" class="selectpicker show-tick form-control" data-live-search="true" title="Pilih Satuan" data-width="80%" placeholder="Pilih Satuan" required>
                                <?php 
                                    foreach ($units->result_array() as $u) {
                                    //$units_id=$u['units_id'];
                                    $units_name=$u['units_name'];
                                    $short_name=$u['short_name'];
                                    //echo '<option value='. $units_id .'>'. $units_name . '</option>';
                                    echo '<option value='. $short_name .'>'. $units_name.' ('.$short_name.')</option>';
                                    }
                                ?>
                             </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-4" >Harga Pokok (Rp.)</label>
                        <div class="col-xs-8">
                            <input name="harpok" class="harpok form-control" type="text" placeholder="Harga Pokok..." style="width:335px;">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-4" >Harga Jual (Rp.)</label>
                        <div class="col-xs-8">
                            <input name="harjul" class="harjul form-control" type="text" placeholder="Harga Jual ..." style="width:335px;">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-4" >Stok Global</label>
                        <div class="col-xs-8">
                            <input name="stok" id="stok" class="form-control" type="text" placeholder="Stok Gabungan" style="width:335px;" readonly>
                        </div>
                    </div>
                    <?php foreach ($regions->result_array() as $reg) :
                        $id_reg=$reg['reg_id'];
                        $nick_name=$reg['nick_name'];
                        $reg_name=$reg['reg_name'];
                    ?>
                        <div class="form-group">
                        <label class="control-label col-xs-4" >Stok <?php echo $reg_name;?></label>
                        <div class="col-xs-8">
                            <input name="stok_<?php echo $id_reg;?>" id="stok_<?php echo $id_reg;?>" class="form-control" type="text" placeholder="Stok <?php echo $nick_name;?>" style="width:335px;">
                        </div>
                        </div>
                    <?php endforeach;?>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-info">Simpan</button>    
                    <button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
                </div>
            </form>
            </div>
            </div>
        </div>

        <!-- ============ MODAL EDIT =============== -->
        <div id="modalEditBarang" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 class="modal-title" id="myModalLabel">Edit Barang</h3>
            </div>
            <form class="form-horizontal" method="post" action="<?php echo base_url().'admin/barang/edit_barang'?>">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="control-label col-xs-4" >Kode Barang</label>
                        <div class="col-xs-8">
                            <input name="kobarE" id="kobarE" class="form-control" type="text" placeholder="Kode Barang..." style="width:335px;" readonly>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-4" >Nama Barang</label>
                        <div class="col-xs-8">
                            <input name="nabarE" id="nabarE" class="form-control" type="text" placeholder="Nama Barang..." style="width:335px;" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-4" >Diskon</label>
                        <div class="col-xs-8">
                            <select name="diskonE" id="diskonE" class="selectpicker show-tick form-control" data-live-search="true" title="Pilih Jenis Diskon" data-width="80%" placeholder="Pilih Diskon">
                            <?php foreach ($diskon->result_array() as $dc) {
                                $dc_id=$dc['disc_id'];
                                $dc_rate=$dc['disc_rate'];
                                echo "<option value='$dc_id'>$dc_rate</option>";
                            }
                            echo "<option value=0>Tidak Ada Diskon</option>";
                            ?>  
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-4" >Kategori</label>
                        <div class="col-xs-8">
                            <select name="kategoriE" id="kategoriE" class="selectpicker show-tick form-control" data-live-search="true" title="Pilih Kategori" data-width="80%" placeholder="Pilih Kategori" required>
                            <?php foreach ($kat->result_array() as $k) {
                                $id_kat=$k['kategori_id'];
                                $nm_kat=$k['kategori_nama'];
                                echo '<option value='.$id_kat.'>'.$nm_kat.'</option>';
                            }
                            ?>  
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-4" >Satuan</label>
                        <div class="col-xs-8">
                            <select name="satuanE" id="satuanE" class="selectpicker show-tick form-control" data-live-search="true" title="Pilih Satuan" data-width="80%" placeholder="Pilih Satuan" required>
                            <?php foreach ($units->result_array() as $u) {
                                $units_name=$u['units_name'];
                                $short_name=$u['short_name'];
                                echo "<option value='$short_name'>$units_name ($short_name) </option>";
                                }
                            ?>        
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-4" >Harga Pokok (Rp.)</label>
                        <div class="col-xs-8">
                            <input name="harpokE" id="harpokE" class="harpok form-control" type="text" placeholder="Harga Pokok..." style="width:335px;" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-4" >Harga Jual (Rp.)</label>
                        <div class="col-xs-8">
                            <input name="harjulE" id="harjulE" class="harjul form-control" type="text" placeholder="Harga Jual..." style="width:335px;" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-4" >Stok Global</label>
                        <div class="col-xs-8">
                            <input name="stokE" id="stokE" class="form-control" type="text" placeholder="Stok..." style="width:335px;" readonly>
                        </div>
                    </div>

                    <?php foreach ($regions->result_array() as $reg) :
                    $id_reg = $reg['reg_id'];
                    $nick_name = $reg['nick_name'];
                    $reg_name = $reg['reg_name'];
                    ?>
                    <div class="form-group">
                        <label class="control-label col-xs-4">Stok <?php echo $reg_name; ?></label>
                        <div class="col-xs-8">
                            <input name="qtyE_<?php echo $id_reg;?>" id="qtyE_<?php echo $id_reg;?>" class="form-control" type="hidden" style="width:50px;">
                            <input name="stokE_<?php echo $id_reg;?>" id="stokE_<?php echo $id_reg;?>" class="form-control" type="text" placeholder="stok_<?php echo $nick_name;?>" style="width:335px;">

                        </div>
                    </div>
                    <?php endforeach; ?>

                </div>
                <div class="modal-footer">
                <button type="submit" class="btn btn-info">Update</button>    
                <button id="tutup" name="tutup" class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
                </div>
            </form>
        </div>
        </div>
        </div>

        <!-- ============ MODAL HAPUS =============== -->
        
        <div id="modalHapusBarang" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 class="modal-title" id="myModalLabel">Hapus Barang</h3>
            </div>
            <form class="form-horizontal" method="post" action="<?php echo base_url().'admin/barang/hapus_barang'?>">
                <div class="modal-body">
                    <p>Yakin mau menghapus Kode Barang : <span id="kobarVal"></span> Nama Barang : <span id="nabarVal"></span>...?</p>
                    <p>dengan menghapus Kode Barang ini sekaligus menghapus data stok yang pernah tersimpan.</p>
                        <input name="kodeH" id="kodeH" type="hidden">
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Hapus</button>    
                    <button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
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
    <script src="<?php echo base_url().'assets/dist/js/bootstrap-select.min.js'?>"></script>
    <script src="<?php echo base_url().'assets/js/bootstrap.min.js'?>"></script>
    <script src="<?php echo base_url().'assets/js/jquery.dataTables.min.js'?>"></script>
    <script src="<?php echo base_url().'assets/js/jquery.price_format.min.js'?>"></script>
    <!-- Data Table Fixed Column-->
    <script src="<?php echo base_url().'assets/js/dataTable/dataTables.fixedColumns.min.js'?>"></script>
    
    
<script>
    // Menambahkan event listener ke elemen yang mengelilingi semua form modal
    document.body.addEventListener('input', function(event) {
    var target = event.target;
    // Memeriksa apakah elemen target adalah input yang dimulai dengan 'stok_'
    if (target && target.tagName === 'INPUT' && target.id.startsWith('stok_')) {
        var modal = target.closest('.modal'); // Mencari elemen form modal terdekat
        if (modal) {
        var modalId = modal.id;
        hitungTotalStok(modalId);
        }
    }
    });
    // Fungsi untuk menghitung total stok dalam form modal tertentu
    function hitungTotalStok(modalId) {
    var totalStok = 0;
    // Loop melalui semua input type text dengan nama id yang dimulai dengan 'stok_' di dalam modal yang sesuai
    var stokInputs = document.querySelectorAll(`#${modalId} input[id^="stok_"]`);
    stokInputs.forEach(function(input) {
        var nilai = parseFloat(input.value) || 0; // Mengambil nilai input sebagai angka, jika tidak valid, dianggap 0
        totalStok += nilai;
    });
    // Mengisi nilai total ke input dengan nama id 'stok' dalam modal yang sesuai
    document.querySelector(`#${modalId} #stok`).value = totalStok;
    }

    $(document).on('input', 'input[name^="kobar"]', function(e) {
        var inputValue = e.target.value;
        //var sanitizedValue = inputValue.replace(/[^0-9A-Za-z,\b\t]/g, ''); 
        var sanitizedValue = inputValue.replace(/[^0-9A-Za-z\-]/g, '');
        e.target.value = sanitizedValue; 
    });

    $(document).on('blur', 'input[name^="kobar"]', function(e) {
        if (!$(this).prop('readonly')) {
            var kobar = $(this).val();
            $.ajax({
                url: "<?php echo base_url().'admin/barang/cek_kobar';?>",
                data: { kobar: kobar },
                dataType: 'json',
                success: function(data) {
                    //console.log(data);
                    if (data && data.is_registered) {
                        alert('Kode Barang tersebut sudah terdaftar, silahkan input Kode Barang yang berbeda.');
                        setTimeout(function() {
                            //$('input[name^="kobar"]').val(''); // Menghapus nilai input jika kode sudah terdaftar
                            $('input[name^="kobar"]').focus();
                        }, 0);
                    }
                },
                error: function(xhr, status, error) {
                    //console.log(error);
                }
            });
        }
    });


    $(document).on('input', 'input[name^="stok"]', function(e) {
        var inputValue = e.target.value;
        var sanitizedValue = inputValue.replace(/[^\d,\b\t]/g, '')
        e.target.value = sanitizedValue;
    });

    // $(document).on('change', 'select[name^="kategori"]', function(e) {
    //     const nmkat = $(this).find('option:selected').data('nama');
    //     $('input[name^="katnama"]').val(nmkat);
    // });

</script>

    
<script type="text/javascript">
    $(document).ready(function() {
        var table = $('#mydata').DataTable({
            scrollY: "450px",
            scrollX: true,
            scrollCollapse: true,
            paging: true,
            pageLength: 100,
            lengthMenu: [10, 25, 50, 100],
            fixedColumns: {
                left: 3,
                right: 1
            },
            
          ajax: {
                url: "<?php echo base_url().'admin/barang/ajaxStokByCabang';?>",
                type: "POST",
                error: function(xhr, error, thrown) {
                    alert('Error: ' + thrown);
                    console.log(xhr.responseText);
                }
            },
            columns: [
                { data: "no" }, // Nomor urut
                { data: "barang_id" },
                //{ data: "barang_nama" },
                { data: "barang_nama",
                    render: function(data, type, row) {
                        return '<div style="max-width: 200px; overflow: hidden; white-space: nowrap; text-overflow: ellipsis;">' + data + '</div>';
                    }
                },
                { data: "barang_disc_id" },
                { data: "barang_satuan" },
                { data: 'barang_harpok',
                    className: 'text-right',
                    render: function(data) {
                        var totalFormatted = Math.ceil(data).toLocaleString('id-ID', { style: 'currency', currency: 'IDR' }).replace(/,00$/, '');
                        return totalFormatted;
                    }
                },
                { data: 'barang_harjul',
                    className: 'text-right',
                    render: function(data) {
                        var totalFormatted = Math.ceil(data).toLocaleString('id-ID', { style: 'currency', currency: 'IDR' }).replace(/,00$/, '');
                        return totalFormatted;
                    }
                },
                { data: "stok_global",
                    className: 'text-center',
                    render: function (data, type, row) {
                        if (type === 'display') {
                            let parsedData = parseFloat(data);
                            let formattedStok;
                            if (parsedData === Math.floor(parsedData)) {
                                formattedStok = parsedData.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ','); //  // Jika bilangan bulat, tanpa desimal dan .00
                            } else {
                                formattedStok = parsedData.toFixed(2).replace('.', ',').replace(/\.?0+$/, '').replace(/\B(?=(\d{3})+(?!\d))/g, ','); // // Jika bilangan desimal, tampilkan koma
                            }
                            return formattedStok;
                        }
                        return data;
                    }
                },

                <?php foreach ($regions->result_array() as $reg) : ?>
                {
                    data: "stok_cabang_<?php echo $reg['reg_id']; ?>",
                    className: 'text-center', // Sesuaikan dengan kebutuhan Anda
                    render: function (data, type, row) {
                        let parsedData = parseFloat(data);
                        let formattedStok;
                        if (parsedData === Math.floor(parsedData)) {
                            formattedStok = parsedData.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ',');
                        } else {
                            formattedStok = parsedData.toFixed(2).replace('.', ',').replace(/\.?0+$/, '').replace(/\B(?=(\d{3})+(?!\d))/g, ',');
                        }
                        return formattedStok;
                    }
                },
                <?php endforeach; ?>

                { data: "barang_kategori_nama" },
                {
                    data: null,
                    render: function(data, type, row) {
                        return '<a class="btn btn-xs btn-warning btn-edit" href="#modalEditBarang" data-idbrg="' + row.barang_id + '" data-toggle="modal" title="Edit"><span class="fa fa-edit"></span> Edit</a> ' +
                               '<a class="btn btn-xs btn-danger btn-hapus" href="#modalHapusBarang" data-idbrg="' + row.barang_id + '" data-nmbrg="' + row.barang_nama + '" data-toggle="modal" title="Hapus"><span class="fa fa-close"></span> Hapus</a>';
                    }
                }
            ]
        });
        
    });
    
</script>

<script>
$(document).ready(function () {
    $(document).on('click', '.btn-hapus', function () {
        var idbrg = $(this).data('idbrg');
        var nmbrg = $(this).data('nmbrg');
        $('#kobarVal').text(idbrg);
        $('#nabarVal').text(nmbrg);
        $('#kodeH').val(idbrg);
    });

    $(document).on('click', '.btn-edit', function () {
        var idbrg = $(this).data('idbrg');
        $.ajax({
            url: "<?php echo base_url().'admin/barang/get_stok_cabang';?>", 
            type: "POST",
            data: { idbrg : idbrg},
            success: function (data) { 
                //console.log("Data from server:", data);
                var parsedData = JSON.parse(data);  // Mengonversi string JSON menjadi objek
                if (parsedData.length !== 0) {
                    $.each(parsedData, function (index, item) {
                        // Set nilai untuk elemen input
                        $('#kobarE').val(item.barang_id);
                        $('#nabarE').val(item.barang_nama);
                        $('#harpokE').val(Number(item.barang_harpok).toLocaleString('id-ID'));
                        $('#harjulE').val(Number(item.barang_harjul).toLocaleString('id-ID'));
                        // Set nilai untuk elemen select
                        if (item.barang_disc_id != null && item.barang_disc_id != "") { // Set nilai untuk elemen select (diskon)
                            $('#diskonE').val(item.barang_disc_id);
                        } else {
                            $('#diskonE').val(0); // Set nilai 0 jika null atau kosong
                        }
                        $('#kategoriE').val(item.barang_kategori_id);
                        $('#satuanE').val(item.barang_satuan);

                        // Refresh elemen selectpicker untuk menampilkan perubahan
                        $('#diskonE, #kategoriE, #satuanE').selectpicker('refresh');
                        
                        // Set nilai untuk elemen input (stok global)
                        $('#stokE').val(formatStok(item.stok_global));

                        // Set nilai untuk elemen input (stok cabang) dengan ID dinamis
                        <?php foreach ($regions->result_array() as $reg) : ?>
                            $('#qtyE_<?php echo $reg['reg_id']; ?>').val(formatStok(item['stok_cabang_<?php echo $reg['reg_id']; ?>']));
                            $('#stokE_<?php echo $reg['reg_id']; ?>').val(formatStok(item['stok_cabang_<?php echo $reg['reg_id']; ?>']));
                        <?php endforeach; ?>

                    });

                    // Fungsi untuk memformat stok
                    function formatStok(stok) {
                        var parsedStok = parseFloat(stok);
                        if (Math.floor(parsedStok) === parsedStok) {
                            return parsedStok.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ','); // Format sebagai bilangan bulat
                        } else {
                            return parsedStok.toFixed(2).replace('.', ',').replace(/\.?0+$/, '').replace(/\B(?=(\d{3})+(?!\d))/g, ','); // Format sebagai bilangan desimal
                        }
                    }
                    
                } else {
                    console.log("No data found.");
                }
            },
            error: function (xhr, status, error) {
            console.error("AJAX error:", error);
            }
        });
    });
});
</script>

<script>
    // Menambahkan event listener ke elemen yang mengelilingi semua form modal
    document.body.addEventListener('input', function(event) {
    var target = event.target;
    // Memeriksa apakah elemen target adalah input yang dimulai dengan 'stok_'
    if (target && target.tagName === 'INPUT' && target.id.startsWith('stokE_')) {
        var modal = target.closest('.modal'); // Mencari elemen form modal terdekat
        if (modal) {
        var modalId = modal.id;
        hitungTotalStokE(modalId);
        }
    }
    });
    // Fungsi untuk menghitung total stok dalam form modal tertentu
    function hitungTotalStokE(modalId) {
    var totalStok = 0;
    // Loop melalui semua input type text dengan nama id yang dimulai dengan 'stok_' di dalam modal yang sesuai
    var stokInputs = document.querySelectorAll(`#${modalId} input[id^="stokE_"]`);
    stokInputs.forEach(function(input) {
        var nilai = parseFloat(input.value) || 0; // Mengambil nilai input sebagai angka, jika tidak valid, dianggap 0
        totalStok += nilai;
    });
    // Mengisi nilai total ke input dengan nama id 'stok' dalam modal yang sesuai
    document.querySelector(`#${modalId} #stokE`).value = totalStok;
    }

    $(document).on('input', 'input[name^="stokE"]', function(e) {
        var inputValue = e.target.value;
        var sanitizedValue = inputValue.replace(/[^\d,\b\t]/g, '')
        e.target.value = sanitizedValue;
    });
</script>

<script type="text/javascript">
    $(function(){
        $('.harpok').priceFormat({
                prefix: '',
                //centsSeparator: '',
                centsLimit: 0,
                thousandsSeparator: '.'
        });
        $('.harjul').priceFormat({
                prefix: '',
                //centsSeparator: '',
                centsLimit: 0,
                thousandsSeparator: '.'
        });

        $('.harpokE').priceFormat({
                prefix: '',
                //centsSeparator: '',
                centsLimit: 0,
                thousandsSeparator: '.'
        });
        $('.harjulE').priceFormat({
                prefix: '',
                //centsSeparator: '',
                centsLimit: 0,
                thousandsSeparator: '.'
        });
    });
</script>
    
</body>
</html>
