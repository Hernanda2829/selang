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
    
    <script src="<?php echo base_url().'assets/js/jquery-3.6.0.min.js'?>"></script> 
    <script src="<?php echo base_url().'assets/js/bootstrap.min.js'?>"></script>
    <script src="<?php echo base_url().'assets/js/jquery.dataTables.min.js'?>"></script>
    
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
                <h3>Data Transaksi <small>Penjualan - <?php echo $userid['reg_code'];?>  <?php echo $userid['reg_name'];?></small>
                <div class="pull-right">
                </div>
                </h3>
                <hr></hr>
                 
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
            <table id="tbl_jual" class="table table-bordered table-condensed" style="font-size:11px;margin-top:10px;">
                <thead>
                    <tr>
                        <th style="max-width:150px;text-align:center;vertical-align:middle;background-image:none!important">Nama Customer</th>
                        <th style="text-align:center;vertical-align:middle;background-image:none!important">No Faktur</th>
                        <th style="text-align:center;vertical-align:middle;background-image:none!important">Tanggal Transaksi</th>
                        <th style="text-align:center;vertical-align:middle;background-image:none!important">Jenis Pembayaran</th>
                        <th style="text-align:center;vertical-align:middle;background-image:none!important">Status Pembayaran</th>
                        <th style="text-align:center;vertical-align:middle;background-image:none!important">Total Penjualan</th>
                        <th style="text-align:center;vertical-align:middle;background-image:none!important" data-orderable="false">Aksi</th>
                        
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
            <h3 class="modal-title" id="myModalLabel">Pembayaran Tempo - <?php echo $userid['reg_code'];?>  <?php echo $userid['reg_name'];?></h3>
        </div>
        <form class="form-horizontal" method="post" action="<?php echo base_url().'admin/jual/tambah_bayar'?>">
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
                <th style="width:200px;padding-bottom:5px;vertical-align:middle;">Jumlah Pembayaran : </th>
                        <td><input type="text" id="jmlbyr" name="jmlbyr" class="form-control input-sm" style="width:150px;text-align:right;" min="0" required></td>
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

    <script type="text/javascript">
        $(document).ready(function() {
            var tblJual; // Variabel untuk tabel DataTable

        // Inisialisasi DataTable
        tblJual = $('#tbl_jual').DataTable({
            ajax: {
                url: "<?php echo base_url().'admin/jual/get_penjualan_data';?>",
                dataSrc: '',
                data: function(d) {
                    // Mengirim ID cabang saat permintaan AJAX
                    //d.reg_id = $('select[name="regid"]').val();
                }
            },
            columns: [
                // { data: null,
                //     render: function (data, type, row) {
                //     return data.reg_name + ' - (' + data.created_by + ')';
                //     }
                // },
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
                                + '<a class="btn btn-xs btn-info" href="<?php echo base_url().'admin/jual/cetak_faktur/'; ?>' + data.jual_nofak + '/' + data.jual_user_id + '" target="_blank" title="Cetak Faktur untuk Customer/Pelanggan"><span class="fa fa-print"></span> Faktur</a> '
                                + '<a class="btn btn-xs btn-success" href="<?php echo base_url().'admin/jual/cetak_faktur2/'; ?>' + data.jual_nofak + '/' + data.jual_user_id + '" target="_blank" title="Cetak Faktur untuk Internal"><span class="fa fa-print"></span> Faktur</a>';
                            }else{
                                    return '<a class="btn btn-xs btn-warning btn-bayar" href="#modalBayar" data-toggle="modal" data-nofak="' + data.jual_nofak + '" data-nmcust="' + data.jual_cust_nama + '" title="Proses Pembayaran"> <span class="fa fa-book"></span> Pembayaran</a> '
                                + '<a class="btn btn-xs btn-info" href="<?php echo base_url().'admin/jual/cetak_faktur/'; ?>' + data.jual_nofak + '/' + data.jual_user_id + '" target="_blank" title="Cetak Faktur untuk Customer/Pelanggan"><span class="fa fa-print"></span> Faktur</a> '
                                + '<a class="btn btn-xs btn-success" href="<?php echo base_url().'admin/jual/cetak_faktur2/'; ?>' + data.jual_nofak + '/' + data.jual_user_id + '" target="_blank" title="Cetak Faktur untuk Internal"><span class="fa fa-print"></span> Faktur</a>';
                            }
                        }else {
                            return '<a class="btn btn-xs btn-info" href="<?php echo base_url().'admin/jual/cetak_faktur/'; ?>' + data.jual_nofak + '/' + data.jual_user_id + '" target="_blank" title="Cetak Faktur untuk Customer/Pelanggan"><span class="fa fa-print"></span> Faktur</a> '
                            + '<a class="btn btn-xs btn-success" href="<?php echo base_url().'admin/jual/cetak_faktur2/'; ?>' + data.jual_nofak + '/' + data.jual_user_id + '" target="_blank" title="Cetak Faktur untuk Internal"><span class="fa fa-print"></span> Faktur</a>';
                        }

                    }

                }

            ],
            order: [[2, 'desc']] // Menggunakan indeks 2 (jual_tanggal) untuk mengurutkan secara default
            
            
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
            detailTable += '<thead><tr><th>No Faktur</th><th>Barang ID</th><th>Barang Nama</th><th>Satuan</th><th>Quantity</th><th>Harga Jual</th><th>Diskon</th><th>Sub Total</th></tr></thead>';
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
                                    var diskon = parseFloat(detail.d_jual_diskon);
                                    var total = parseFloat(detail.d_jual_total);
                                    
                                    detailTable += '<tr>';
                                    detailTable += '<td>' + detail.d_jual_nofak + '</td>';
                                    detailTable += '<td>' + detail.d_jual_barang_id + '</td>';
                                    detailTable += '<td>' + detail.d_jual_barang_nama + '</td>';
                                    detailTable += '<td>' + detail.d_jual_barang_satuan + '</td>';
                                    detailTable += '<td>' + detail.d_jual_qty + '</td>';
                                    detailTable += '<td>' + hargaJual.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' }).replace(/,00$/, '') ; + '</td>';
                                    detailTable += '<td>' + diskon.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' }).replace(/,00$/, '') ; + '</td>';
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
            },
            error: function(xhr, status, error) {
                //console.log(error);
            }
        });
    });
});

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
