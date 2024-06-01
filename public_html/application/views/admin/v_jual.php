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

    <title>Data Penjualan</title>
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
    .selectpicker {
    cursor: pointer;
    }
    
    #tbl_jual {
    cursor: pointer; /* Mengembalikan kursor ke tipe default */
    }

    table.table-bordered.dataTable th:last-child,
    table.table-bordered.dataTable td:last-child {
    cursor: default;
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

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12" style="display: flex; justify-content: space-between; align-items: center;">
                <h3 style="margin: 0;">Data Transaksi <small>Penjualan</small></h3>
                <div style="display: flex; align-items: center;">
                    <span style="margin-right: 10px; white-space:nowrap;font-weight: bold;">Filter : </span>
                    <select name="regid" class="selectpicker show-tick form-control" data-live-search="true" title="Pilih cabang" data-width="80%" placeholder="Pilih Cabang" required>
                        <option value="" disabled selected style="display: none;">Pilih Cabang</option>
                        <optgroup label="Pilih Cabang">
                            <?php 
                            $regions_data = $this->Mlogin->tampil_regions()->result_array();
                            foreach ($regions_data as $rg) {
                                $reg_id = $rg['reg_id'];
                                $reg_name = $rg['reg_name'];    
                                echo '<option value="'.$reg_id.'">'.$reg_name.'</option>';
                            }
                            ?>
                            <option value='0'>Gabungan (Global)</option>
                        </optgroup>
                    </select>
                </div>
            </div>
            <div class="col-lg-12">
                <hr></hr>
            </div>
        </div>


        <div class="row">
            <div class="col-lg-12">
            <table id="tbl_jual" class="table table-bordered table-condensed" style="font-size:11px;margin-top:10px;">
                <thead>
                    <tr>
                        <th style="max-width:100px;text-align:center;vertical-align:middle;background-image:none!important">Kantor Cabang</th>
                        <th style="max-width:150px;text-align:center;vertical-align:middle;background-image:none!important">Nama Customer</th>
                        <th style="text-align:center;vertical-align:middle;background-image:none!important">No Faktur</th>
                        <th style="text-align:center;vertical-align:middle;background-image:none!important">Tanggal Transaksi</th>
                        <th style="max-width:50px;text-align:center;vertical-align:middle;background-image:none!important">Jenis Pembayaran</th>
                        <th style="max-width:50px;text-align:center;vertical-align:middle;background-image:none!important">Status Pembayaran</th>
                        <th style="text-align:center;vertical-align:middle;background-image:none!important">Total Penjualan</th>
                        <th style="text-align:center;vertical-align:middle;background-image:none!important">Aksi</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
            </div>
        </div>

        <div id="detailPenjualan" style="display:none">
            <h3>Detail Penjualan</h3>
            <table id="tbl_detail_jual" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>No Faktur</th>
                        <th>Barang ID</th>
                        <th>Barang Nama</th>
                        <th>Satuan</th>
                        <th>Quantity</th>
                        <th>Harga Jual</th>
                        <th>Diskon</th>
                        <th>Sub Total</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>

    <!-- ============ MODAL Bayar =============== -->
        <div id="modalBayar" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 class="modal-title" id="myModalLabel">Informasi Pembayaran Tempo</h3>
        </div>
        <form class="form-horizontal" method="post" action="<?php echo base_url().'admin/jual/tambah_bayar_admin'?>">
            <div class="modal-body" style="overflow:scroll;height:400px;">
                <p style="font-size: 11px; margin-bottom: 0;">
                    Nama Customer : <b><span id="nmcustValue" style="color: green;"></span></b>
                </p>
                <p style="font-size: 11px; margin-bottom: 0;">
                    No Faktur : <b><span id="nofakValue"></span></b>
                    <span style="float: right;">Status Bayar : <b><span id="ketValue" style="color: green;"></b></span>
                </p>
                <table id="tbl_info" class="table table-bordered table-condensed" style="font-size:11px;">
                <thead>
                <tr>
                    <th style="text-align:center;vertical-align:middle">Tgl Transaksi</th>
                    <th style="text-align:center;vertical-align:middle">Kewajiban Pembayaran</th>
                    <th style="text-align:center;vertical-align:middle">Jumlah yang sudah diBayar</th>
                    <th style="text-align:center;vertical-align:middle">Kurang Bayar</th>
                </tr>
                </thead>
                <tbody></tbody>
                </table>
                <table class="table table-bordered table-condensed" style="font-size:11px;display:none;">
                    <tr>
                        <th style="width:200px;padding-bottom:5px;vertical-align:middle;">No Faktur Penjualan</th>
                        <td><input type="text" id="kode" name="kode" class="form-control input-sm" style="width:200px;" readonly></td>
                    </tr>
                    <tr>
                        <th style="width:200px;padding-bottom:5px;vertical-align:middle;">Kode Cabang</th>
                        <td><input type="text" id="kode_cab" name="kode_cab" class="form-control input-sm" style="width:200px;" readonly></td>
                    </tr>
                    <tr>
                        <th style="width:200px;padding-bottom:5px;vertical-align:middle;">Tgl Transaksi</th>
                        <td><input type="text" id="tglbyr" name="tglbyr" class="form-control input-sm" style="width:200px;" readonly></td>
                    </tr>
                    <tr>
                        <th style="width:200px;padding-bottom:5px;vertical-align:middle;">Kewajiban Total Bayar</th>
                        <td><input type="text" id="totbyr" name="totbyr" class="form-control input-sm" style="width:200px;" readonly></td>
                    </tr>
                    <tr>
                        <th style="width:200px;padding-bottom:5px;vertical-align:middle;">Jumlah yang Sudah di Bayar</th>
                        <td><input type="text" id="sudbyr" name="sudbyr" class="form-control input-sm" style="width:200px;" readonly></td>
                    </tr>
                    <tr>
                        <th style="width:200px;padding-bottom:5px;vertical-align:middle;">Kurang Bayar</th>
                        <td><input type="text" id="kurbyr" name="kurbyr" class="form-control input-sm" style="width:200px;" readonly></td>
                    </tr>
                </table>
                <p style="font-size:11px;margin-bottom:0;"><span id="inputByrValue"><b>Silahkan Input Kekurangan Pembayaran, </b></span></p>
                <table id="tbl_inputBayar" class="table table-bordered table-condensed" style="font-size:11px;">
                    <tr> 
                        <th style="width:150px;vertical-align: middle;">Tgl Transaksi</th>
                        <td>
                            <div class='input-group date' id='datepicker' style="width:130px;">
                                <input type='text' name="tgltrans" class="form-control" style="font-size:11px;color:green;" placeholder="Tanggal..." required>
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </td>   
                        <th style="width:200px;padding-bottom:5px;vertical-align:middle;">Jml Pembayaran : </th>
                        <td><input type="text" id="jmlbyr" name="jmlbyr" class="form-control input-sm" style="width:150px;text-align:right;" min="0" required></td>
                        
                    </tr>
                </table>
                <hr/>
                <p style="font-size: 11px; margin-bottom: 0;">
                    <b>History Pembayaran : </b>
                    <span style="float: right;"><b>Total yang dibayar : <span id="totValue" style="color: green;"></b></span>
                </p>
                <table id="tbl_bayar" class="table table-bordered table-condensed" style="font-size:11px;">
                <thead>
                <tr>
                    <th style="text-align:center;vertical-align:middle">No</th>
                    <th style="text-align:center;vertical-align:middle">Tanggal Bayar</th>
                    <th style="text-align:center;vertical-align:middle">Jumlah yang diBayar</th>
                </tr>
                </thead>
                <tbody></tbody>
                </table> 
            </div>
            <div class="modal-footer"> 
                <button type="submit" class="btn btn-info">Update</button>  
                <button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
            </div>
        </form>
        </div>
        </div>
        </div>

    <!-- ============ MODAL HAPUS =============== -->
        
        <div id="modalHapusData<?php echo $id?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 class="modal-title" id="myModalLabel">Hapus Data Penjualan</h3>
            </div>
            <form class="form-horizontal" method="post" action="<?php echo base_url().'admin/jual/hapus_data'?>">
                <div class="modal-body">
                    <p>Yakin mau menghapus No Faktur Penjualan : <span id="kodeVal"></span></p>
                    <p>Proses ini sekaligus menghapus data pembayaran dan data garansi yang terkait</p>
                
                        <input name="kodehapus" id="kodehapus" type="hidden">
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
            widgetPositioning: {
                vertical: 'bottom',
                horizontal: 'auto'
            }
        });
    });
    </script>
    


    <script type="text/javascript">
        $(document).ready(function() {
            var tblJual; // Variabel untuk tabel DataTable

        // Fungsi untuk memuat ulang data berdasarkan ID cabang yang dipilih
        function reloadData(regId) {
            tblJual.ajax.url("<?php echo base_url().'admin/jual/get_penjualan_data?reg_id='; ?>" + regId).load();
        }

        // Event handler ketika pilihan pada select berubah
        $('select[name="regid"]').on('change', function() {
            var selectedRegId = $(this).val(); // Ambil ID cabang yang dipilih
            reloadData(selectedRegId); // Memuat ulang data dengan ID cabang yang dipilih
        });

        // Inisialisasi DataTable
        tblJual = $('#tbl_jual').DataTable({
            ajax: {
                url: "<?php echo base_url().'admin/jual/get_penjualan_data';?>",
                dataSrc: '',
                data: function(d) {
                    // Mengirim ID cabang saat permintaan AJAX
                    d.reg_id = $('select[name="regid"]').val();
                }
            },
            columns: [
                { 
                    data: null,
                    render: function (data, type, row) {
                        return data.reg_name + ' - (' + data.created_by + ')';
                    }
                },
                { data: 'jual_cust_nama' },
                { data: 'jual_nofak' },   
                { data: 'jual_tanggal' },
                { data: 'jual_bayar' },
                { data: 'jual_bayar_status' },
                { data: 'jual_total',
                    className: 'text-right',
                    render: function(data) {
                        var totalFormatted = Math.ceil(data).toLocaleString('id-ID', { style: 'currency', currency: 'IDR' }).replace(/,00$/, '');
                        return totalFormatted;
                    }
                },
                { data: null,
                    className: 'text-center',
                    render: function(data, type, row) {
                        if (data.jual_bayar=="Tempo") {
                            if (data.jual_bayar_status=="Lunas") {
                                return '<a class="btn btn-xs btn-info btn-bayar" href="#modalBayar" data-toggle="modal" data-nofak="' + data.jual_nofak + '" data-nmcust="' + data.jual_cust_nama + '" title="Lihat Data Pembayaran Status Lunas"> <span class="fa fa-book"></span> Lihat Data</a> '
                                + '<a class="btn btn-xs btn-danger btn-hapus" href="#modalHapusData" data-toggle="modal" data-nofak="' + data.jual_nofak + '" title="Hapus Data Penjualan"><span class="fa fa-print"></span> Hapus Data</a>';
                            }else{
                                    return '<a class="btn btn-xs btn-warning btn-bayar" href="#modalBayar" data-toggle="modal" data-nofak="' + data.jual_nofak + '" data-nmcust="' + data.jual_cust_nama + '" title="Lihat Pembayaran"> <span class="fa fa-book"></span> Pembayaran</a> '
                                + '<a class="btn btn-xs btn-danger btn-hapus" href="#modalHapusData" data-toggle="modal" data-nofak="' + data.jual_nofak + '" title="Hapus Data Penjualan"><span class="fa fa-print"></span> Hapus Data</a>';
                            }
                        }else {
                            return '<a class="btn btn-xs btn-danger btn-hapus" href="#modalHapusData" data-toggle="modal" data-nofak="' + data.jual_nofak + '" title="Hapus Data Penjualan"><span class="fa fa-print"></span> Hapus Data</a>';
                        }
                    }
                }
            ],
            order: [[3, 'desc']] // Menggunakan indeks 2 (jual_tanggal) untuk mengurutkan secara default
            
            
        });

            $('#tbl_jual tbody').on('click', 'tr', function () {
                var tr = $(this);
                var row = tblJual.row(tr);
                var detailRow = tr.next('tr.child-row');

                if (row.child.isShown()) {
                    // Detail row is already shown, hide it
                    row.child.hide();
                    tr.removeClass('shown');
                } else {
                    // Detail row is not shown, show it
                    var rowData = row.data();
                    var detailTable = formatDetailRow(rowData);
                    row.child(detailTable).show();
                    tr.addClass('shown');
                }
            });

            function formatDetailRow(data) {
            var detailTable = '<table class="display" style="width:100%">';
            detailTable += '<thead><tr><th>No Faktur</th><th>Barang ID</th><th>Barang Nama</th><th style="text-align:center">Satuan</th><th style="text-align:center">Quantity</th><th style="text-align:right">Harga Bottom</th><th style="text-align:right">Harga Price List</th><th style="text-align:right">Diskon</th><th style="text-align:right">Sub Total</th></tr></thead>';
            detailTable += '<tbody>';

            $.ajax({
                url: "<?php echo base_url().'admin/jual/get_detail_data';?>",
                type: 'GET',
                async: false,
                success: function(detailData) {
                    //console.log("Received detailData:", detailData); // Periksa data sebelum parsing
                    try {
                        var parsedData = JSON.parse(detailData);
                        if (Array.isArray(parsedData) && parsedData.length > 0) {
                            $.each(parsedData, function(index, detail) {
                                if (data.jual_nofak == detail.d_jual_nofak) {
                                    var hargaJual = parseFloat(detail.d_jual_barang_harjul);
                                    var hargaPokok = parseFloat(detail.d_jual_barang_harpok);
                                    var diskon = parseFloat(detail.d_jual_diskon);
                                    var total = parseFloat(detail.d_jual_total);
                                    
                                    detailTable += '<tr>';
                                    detailTable += '<td>' + detail.d_jual_nofak + '</td>';
                                    detailTable += '<td>' + detail.d_jual_barang_id + '</td>';
                                    detailTable += '<td>' + detail.d_jual_barang_nama + '</td>';
                                    detailTable += '<td style="text-align:center;">' + detail.d_jual_barang_satuan + '</td>';
                                    detailTable += '<td style="text-align:center;">' + detail.d_jual_qty + '</td>';
                                    detailTable += '<td style="text-align:right;">' + hargaPokok.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' }).replace(/,00$/, '') ; + '</td>';
                                    detailTable += '<td style="text-align:right;">' + hargaJual.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' }).replace(/,00$/, '') ; + '</td>';
                                    detailTable += '<td style="text-align:right;">' + diskon.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' }).replace(/,00$/, '') ; + '</td>';
                                    detailTable += '<td style="text-align:right;">' + Math.ceil(total).toLocaleString('id-ID', { style: 'currency', currency: 'IDR' }).replace(/,00$/, '') ; + '</td>';                                
                                    detailTable += '</tr>';
                                }
                            });

                         } else {
                            // Handle empty or no data
                            //console.log('Detail data is empty.');
                        }
                    } catch (error) {
                        //console.error("Error parsing JSON:", error);
                    }
                    detailTable += '</tbody></table>';
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching detail data:", error);
                }
            });

            return detailTable;
            }

        });
    </script>

<script type="text/javascript">
$(document).ready(function() {
    var tblBayar; // Variabel untuk tabel DataTable
    var tblInfo;
    var isDataTableInitialized = false; // Variabel untuk melacak apakah DataTable sudah diinisialisasi
    // Inisialisasi DataTable tanpa data awal
    tblBayar = $('#tbl_bayar').DataTable({
        ordering: false,
        dom: "", // Hapus semua elemen wrapper
        autoWidth: false,
        scrollY: 'none',
        columns: [
            { data: null,
                className: 'text-center',
                render: function(data, type, row, meta) {
                    return meta.row + 1; // Menambahkan nomor urut
                }
            },
            { data: 'tgl_trans' },
            { data: 'bayar_jumlah',
                className: 'text-right',
                render: function(data) {
                    var totalFormatted = Math.ceil(data).toLocaleString('id-ID', { style: 'currency', currency: 'IDR' }).replace(/,00$/, '');
                    return totalFormatted;
                }
            }
        ]
    });

    // Inisialisasi DataTable tanpa data awal
    tblInfo = $('#tbl_info').DataTable({
        ordering: false,
        dom: "", // Hapus semua elemen wrapper
        autoWidth: false,
        scrollY: 'none',
        columns: [
            { data: 'bayar_tgl' },
            { data: 'bayar_total',
                className: 'text-right',
                render: function(data) {
                    var totalFormatted = Math.ceil(data).toLocaleString('id-ID', { style: 'currency', currency: 'IDR' }).replace(/,00$/, '');
                    return totalFormatted;
                }
            },
            { data: 'tot_bayar',
                className: 'text-right',
                render: function(data) {
                    var totalFormatted = Math.ceil(data).toLocaleString('id-ID', { style: 'currency', currency: 'IDR' }).replace(/,00$/, '');
                    return totalFormatted;
                }
            },
            { data: 'kur_bayar',
                className: 'text-right',
                render: function(data) {
                    var totalFormatted = Math.ceil(data).toLocaleString('id-ID', { style: 'currency', currency: 'IDR' }).replace(/,00$/, '');
                    return totalFormatted;
                }
            }
        ]
    });

    // Menangani klik tombol pembayaran
    $(document).on('click', '.btn-bayar', function() {
        var nofak = $(this).data('nofak');
        var nmcust = $(this).data('nmcust');
        $('#kode').val(nofak);
        $('#nofakValue').text(nofak);
        $('#nmcustValue').text(nmcust);
        $.ajax({
            url: "<?php echo base_url().'admin/jual/get_jual_bayar';?>",
            data: { nofak: nofak },
            dataType: 'json',
            success: function(data) {
                //console.log(data);
                tblBayar.clear().draw();
                for (var i = 0; i < data.queryB.length; i++) {
                    tblBayar.row.add(data.queryB[i]).draw();
                }
                tblInfo.clear().draw();
                tblInfo.row.add(data.queryA).draw();
                var ketBayar = data.queryA.bayar_ket;
                if (ketBayar === "Lunas") {
                    $('#tbl_inputBayar').css('display', 'none');
                    $('#inputByrValue').css('display', 'none');
                } else {
                    $('#tbl_inputBayar').css('display', 'table');
                    $('#inputByrValue').css('display', 'block');
                }
                var level_user = data.queryA.level_user;
                // if (level_user === "1") {
                //     $('#tbl_inputBayar').css('display', 'none');
                //     $('#inputByrValue').css('display', 'none');
                // }
                var bayarTanggal = data.queryA.bayar_tanggal;
                var bayarTotal = parseFloat(data.queryA.bayar_total);
                var totBayar = parseFloat(data.queryA.tot_bayar);
                //var kurangBayar = parseFloat(data.queryA.kur_bayar).toLocaleString('id-ID');
                var kurangBayar = parseFloat(data.queryA.kur_bayar);
                bayarTotal = Math.ceil(bayarTotal);
                totBayar = Math.ceil(totBayar);
                kurangBayar = Math.ceil(kurangBayar);
                //kurangBayar = Math.ceil(kurangBayar).toLocaleString('id-ID');
                $('#ketValue').text(ketBayar);
                $('#totValue').text(Number(totBayar).toLocaleString('id-ID', { style: 'currency', currency: 'IDR' }).replace(/,00$/, ''));
                $("#jmlbyr").val('');
                $('#jmlbyr').attr('max',kurangBayar);
                $("#tglbyr").val(bayarTanggal);
                $('#totbyr').val(bayarTotal);
                $('#sudbyr').val(totBayar);
                $('#kurbyr').val(kurangBayar);
                $("#kode_cab").val(data.queryA.bayar_reg_id);
            },
            error: function(xhr, status, error) {
                //console.log(error);
            }
        });
    });
});

</script>

<script>
   $(document).on('click', '.btn-hapus', function() {
        var nofak_hapus = $(this).data('nofak');
        $('#kodehapus').val(nofak_hapus);
   });
</script>

</script>
<script type="text/javascript">
    $(document).ready(function() {
        $(document).on('input', 'input[name^="jmlbyr"]', function(e) {
            var inputValue = e.target.value;
            var sanitizedValue = inputValue.replace(/[^0-9\b\t]/g, ''); // Hapus karakter yang tidak diizinkan (selain angka, koma, backspace, delete, dan tab)
            e.target.value = sanitizedValue; // Update nilai input dengan karakter yang diizinkan
        });
        var inputElements = document.querySelectorAll('input[name^="jmlbyr"]');
        inputElements.forEach(function(inputElement) {
            inputElement.addEventListener('input', function() {
                var value = parseFloat(this.value.replace('.', ''));
                var min = parseFloat(this.min.replace('.', ''));
                var max = parseFloat(this.max.replace('.', ''));
                if (value < min) {
                    this.value = min;
                } else if (value > max) {
                    this.value = max;
                }
               
            });
        });
        $(document).on('blur', 'input[name^="jmlbyr"]', function(e) {
            var nilai = parseFloat($(this).val().replace(/[^\d.,]/g, '')) || 0;
            var formattednilai = nilai.toLocaleString('id-ID');
            $(this).val(formattednilai);
        });

    });
</script>
        
</body>
</html>
