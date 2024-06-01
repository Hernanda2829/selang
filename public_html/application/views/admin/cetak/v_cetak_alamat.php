<html lang="en" moznomarginboxes mozdisallowselectionprint>
<head>
   <?php 
	error_reporting(0);
    $data=$data->row_array();
    $userid=$userid->row_array();
    ?>
   
    <meta charset="utf-8">
    <style>
        @media print {
            @page {  
                margin: 0;
            }
            body {
                margin: 50;
            }
        }

        
        .table-container {
            width: 700px; /* Sesuaikan lebar tabel */
            margin: 10px auto;
            border-collapse: none;
            border: none !important;
        }

        .table-container td {
            border: none; /* Garis tepi sel */
            width: 96px;
            height: 96px;
            text-align: center;
            padding-bottom: 20px; /* tambahkan jarak antara baris */
        }

        
        .caption {
            background-color: rgba(255, 255, 255, 0.8);
            padding: 5px;
            text-align: center;
            margin-top: -5px;  /* Jarak antara image dan caption */
        }
       
         .address-box {
            border: 1px solid #000; /* Warna dan ketebalan garis kotak */
            padding: 10px; /* Jarak antara teks dan tepi kotak */
            margin-bottom: 5px; /* Jarak antara setiap label alamat */
            margin-right: 10px; /* Jarak antara setiap label alamat */
            width: 210px; /* Sesuaikan lebar kotak sesuai kebutuhan */
            text-align: center; /* Posisi teks di dalam kotak */
            border-radius: 10px; /* membuat ujung kotak curve tidak lancip */
        }

        .address-label {
            margin-bottom: 5px; /* Jarak antara setiap baris label alamat */
        }
        
    </style>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/laporan.css')?>"/>
</head>
<body onload="window.print()">
    <div id="laporan">
        <table align="center" style="width:700px; border-bottom:3px double;border-top:none;border-right:none;border-left:none;margin-top:5px;margin-bottom:20px;">
        </table>
        <table border="0" align="center" style="width:700px; border:none;margin-top:5px;margin-bottom:0px;">
            <tr></tr>
        </table>

        <table class="table-container" align="center">
            <?php
            $counter = 0;

            for ($i = 0; $i < $baris; $i++): ?>
                <tr>
                    <?php for ($j = 0; $j < 5; $j++): ?>
                        <td>
                            <?php if ($counter < $kolom): ?>
                            <div class="address-box">
                                <div class="address-label">
                                    <strong>TO :</strong>
                                    <div class="caption" style="color:#FF0000;font-weight:bold;font-family:'Helvetica',sans-serif;"><?php echo strtoupper($data['suplier_nama']); ?></div>
                                    <div class="caption" style="font-family:'Tw Cen MT',sans-serif;"><?php echo $data['suplier_alamat']; ?></div>
                                    <div class="caption" style="font-family:'Tw Cen MT',sans-serif;"><?php echo $data['suplier_notelp']; ?></div>
                                </div>
                                <div class="address-label">
                                    <strong>FROM :</strong>
                                    <div class="caption" style="color:#FF0000;font-weight:bold;font-family:'Helvetica',sans-serif;"><?php echo strtoupper($userid['co_name']); ?></div>
                                    <div class="caption" style="font-family:'Tw Cen MT',sans-serif;"><?php echo $userid['co_address']; ?></div>
                                    <div class="caption" style="font-family:'Tw Cen MT',sans-serif;"><?php echo $userid['co_phone']; ?></div>
                                </div>
                            </div>
                            <?php endif; ?>
                        </td>
                        <?php $counter++; ?>
                    <?php endfor; ?>
                </tr>
            <?php
                // Setelah selesai satu baris, reset counter untuk baris berikutnya
                $counter = 0;
            endfor; ?>
        </table>
    </div>   
</body>
</html>
