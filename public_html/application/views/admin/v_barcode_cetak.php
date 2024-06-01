<html lang="en" moznomarginboxes mozdisallowselectionprint>
<head>
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
            border-collapse: collapse;
        }

        .table-container td {
            border: none; /* Garis tepi sel */
            width: 96px;
            height: 96px;
            text-align: center;
            padding-bottom: 20px; /* tambahkan jarak antara baris */
        }

        .small-image {
            max-width: 100%;
            max-height: 100%;
        }

        .caption {
            background-color: rgba(255, 255, 255, 0.8);
            padding: 5px;
            text-align: center;
            margin-top: -5px;  /* Jarak antara image dan caption */
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
                                <img src="<?php echo base_url().'assets/img/img_barcode/'.$gimg; ?>" alt="Your Image" class="small-image">
                                <figcaption class="caption"><?php echo $kdbrg; ?></figcaption>
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
