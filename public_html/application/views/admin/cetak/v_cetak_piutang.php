<html lang="en" moznomarginboxes mozdisallowselectionprint>

<head>
    <?php 
	error_reporting(0);
    $userid=$userid->row_array();
    ?>
    <title>Laporan Piutang Penjualan <?php echo $userid['reg_name'];?></title>
    <link rel="shortcut icon" href="<?php echo base_url().'assets/img/'. $userid['co_imgicon']; ?>" alt="#no image#" type="image/x-icon">
    <meta charset="utf-8">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/laporan.css')?>"/>

<style>
    @media print {
        @page {  
            margin: 0;
        }
        body {
            margin: 50;
        }
    }

    .total-grup-row {
    visibility: collapse;
    }
    
    .curved-image {
        width: 210px;
        height: 50px;
        border-radius: 50%;
        object-fit: cover;
    }
</style>
</head>

<body onload="window.print()">
    <div id="laporan">
        

        <table border="0" align="center" style="width:700px; border:none;margin-top:5px;margin-bottom:0px;">
            <tr>
                <td><img src="<?php echo base_url().'assets/img/'. $userid['co_imglogo']; ?>" style="margin-bottom:10px" alt="Curved Image" class="curved-image"/></td>
                <td style="width:700px; padding-left:0px;">
                    <center>
                        <h4 style="margin: 0; margin-left: -110px;">LAPORAN PIUTANG PENJUALAN <?php echo strtoupper($userid['reg_code']);?> <?php echo strtoupper($userid['reg_name']);?></h4>
                        <h4 style="margin: 0; margin-left: -110px;">PERIODE <?php echo date('Y')?></h4>
                    </center>
                </td>
            </tr>
        </table>

        <table border="0" align="center" style="width:700px;border:none;">
            <tr>
                <th style="text-align:left"></th>
            </tr>
        </table>

    
       <div class="row">
            <div class="col-lg-12">
                <?php
                $groupedData = []; // Array untuk menyimpan data per grup

                foreach ($data as $a):
                    $cust = $a['jual_cust_nama'];
                    $tot = $a['jual_total'];

                    if (!isset($groupedData[$cust])) {
                        $groupedData[$cust] = [
                            'total' => 0,
                            'sudah_bayar' => 0,
                            'kurang_bayar' => 0,
                            'data' => [],
                        ];
                    }

                    $groupedData[$cust]['total'] += $tot;
                    $groupedData[$cust]['sudah_bayar'] += $a['sudah_bayar'];
                    $groupedData[$cust]['kurang_bayar'] += $a['kurang_bayar'];
                    $groupedData[$cust]['data'][] = $a;
                endforeach;
                ?>

                <?php
                $totalAll = [
                    'total' => 0,
                    'sudah_bayar' => 0,
                    'kurang_bayar' => 0,
                ];
                $totalAllRecord = 0;
                ?>

                <?php foreach ($groupedData as $custName => $group): ?>
                    <!-- Baris judul grup -->
                    <div style="margin-bottom: 20px;">
                       
                        <table border="1" align="center" style="width:700px;margin-bottom:20px;font-size:10px;">
                            <thead>
                                <tr>
                                    <th colspan="9" style="text-align:left; font-size:11px;">
                                        <?php echo $custName; ?>
                                    </th>
                                </tr>
                                <tr>
                                    <th style="text-align:center">No</th>
                                    <th style="text-align:center">Tanggal Transaksi</th>
                                    <th style="text-align:center">No Faktur</th>
                                    <th style="text-align:center">No Nota</th>
                                    <th style="text-align:center">Tempo</th>
                                    <th style="text-align:center">J_Tempo</th>
                                    <th style="text-align:center">Total Penjualan</th>
                                    <th style="text-align:center">Sudah Bayar</th>
                                    <th style="text-align:center">Kurang Bayar</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 0; // Inisialisasi nomor urut ?>
                                <?php foreach ($group['data'] as $a): ?>
                                    <tr>
                                        <td style="text-align:center;"><?php echo ++$no; ?></td>
                                        <td style="padding-left:2px;"><?php echo $a['jual_tanggal'];?></td>
                                        <td style="text-align:center;"><?php echo $a['jual_nofak'];?></td>
                                        <td style="text-align:center;"><?php echo $a['jual_nota'];?></td>
                                        <td style="text-align:center;"><?php echo $a['jual_bulan_tempo'];?> Bln</td>
                                        <td style="text-align:center;"><?php echo date('d/m/Y', strtotime($a['jual_tgl_tempo']));?></td>
                                        <td style="text-align:right;padding-right:3px;"><?php echo 'Rp ' . number_format($a['jual_total'], 0, ',', '.'); ?></td>
                                        <td style="text-align:right;padding-right:3px;"><?php echo 'Rp ' . number_format($a['sudah_bayar'], 0, ',', '.'); ?></td>
                                        <td style="text-align:right;padding-right:3px;"><?php echo 'Rp ' . number_format($a['kurang_bayar'], 0, ',', '.'); ?></td>
                                    </tr>
                                <?php endforeach; ?>

                                <!-- Baris total grup -->
                                <tr>
                                    <td colspan="6" style="text-align:right;font-size:10px;padding-right:5px;"><b>Total :</b></td>
                                    <td style="text-align:right;font-size:10px;padding-right:3px;"><b><?php echo 'Rp ' . number_format($group['total'], 0, ',', '.'); ?></b></td>
                                    <td style="text-align:right;font-size:10px;padding-right:3px;"><b><?php echo 'Rp ' . number_format($group['sudah_bayar'], 0, ',', '.'); ?></b></td>
                                    <td style="text-align:right;font-size:10px;padding-right:3px;"><b><?php echo 'Rp ' . number_format($group['kurang_bayar'], 0, ',', '.'); ?></b></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <?php
                    $totalAll['total'] += $group['total'];
                    $totalAll['sudah_bayar'] += $group['sudah_bayar'];
                    $totalAll['kurang_bayar'] += $group['kurang_bayar'];
                    $totalAllRecord += $no;
                    ?>
                <?php endforeach; ?>

                <!-- Baris total seluruh grup -->
                <div style="margin-top:-10px;">    
                    <table border="1" align="center" style="width:700px;margin-bottom:20px;font-size:10px;">
                        <thead>
                            <tr class="total-grup-row">
                                <th style="text-align:center;">No</th>
                                <th style="text-align:center;">Tanggal Transaksi</th>
                                <th style="text-align:center;">No Faktur</th>
                                <th style="text-align:center;">No Nota</th>
                                <th style="text-align:center;">Tempo</th>
                                <th style="text-align:center;">J_Tempo</th>
                                <th style="text-align:center;">Total Penjualan</th>
                                <th style="text-align:center;">Sudah Bayar</th>
                                <th style="text-align:center;">Kurang Bayar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 0; // Inisialisasi nomor urut ?>

                            <?php foreach ($data as $a): ?>
                                <?php if (!$hideTableHeader): ?>
                                <tr class="total-grup-row">
                                    <td style="text-align:center;"><?php echo ++$no; ?></td>
                                    <td><?php echo $a['jual_tanggal'];?></td>
                                    <td><?php echo $a['jual_nofak'];?></td>
                                    <td><?php echo $a['jual_nota'];?></td>
                                    <td style="text-align:center;"><?php echo $a['jual_bulan_tempo'];?> Bln</td>
                                    <td style="text-align:center;"><?php echo date('d/m/Y', strtotime($a['jual_tgl_tempo']));?></td>
                                    <td style="text-align:right;padding-right:3px;"><?php echo 'Rp ' . number_format($a['jual_total'], 0, ',', '.'); ?></td>
                                    <td style="text-align:right;padding-right:3px;"><?php echo 'Rp ' . number_format($a['sudah_bayar'], 0, ',', '.'); ?></td>
                                    <td style="text-align:right;padding-right:3px;"><?php echo 'Rp ' . number_format($a['kurang_bayar'], 0, ',', '.'); ?></td>
                                </tr>
                            <?php $hideTableHeader = true; ?>
                            <?php endif; ?>
                            <?php endforeach; ?>

                            <!-- Baris total seluruh grup -->
                            <tr>
                                <td colspan="2" style="font-size:10px;"><b>Total Record : <?php echo $totalAllRecord; ?></b></td>
                                <td colspan="4" style="text-align:right;font-size:10px;padding-right:5px;"><b>Total Seluruh Grup :</b></td>
                                <td style="text-align:right;font-size:10px;padding-right:3px;"><b><?php echo 'Rp ' . number_format($totalAll['total'], 0, ',', '.'); ?></b></td>
                                <td style="text-align:right;font-size:10px;padding-right:3px;"><b><?php echo 'Rp ' . number_format($totalAll['sudah_bayar'], 0, ',', '.'); ?></b></td>
                                <td style="text-align:right;font-size:10px;padding-right:3px;"><b><?php echo 'Rp ' . number_format($totalAll['kurang_bayar'], 0, ',', '.'); ?></b></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                
            </div>
        </div>


        <br>
        <table align="center" style="width:700px;border:none;margin-bottom:20px;">
            <tr>
                <td colspan="6" style="text-align: center;"></td>
            </tr>
            <tr>
                <td align="left" style="width:25%;"></td>
                <td align="center" style="width:25%;"></td>
                <td align="center" style="width:25%;"></td>
                <td align="center" style="width:25%;"><?php echo $userid['reg_name'];?> , <?php echo date('d-M-Y')?></td>
            </tr>
            <tr>
                <td align="center" colspan="6"><br><br><br><br></td> <!-- Baris kosong dengan <br> -->
            </tr>
            <tr>
                <td align="left" style="width:25%;"></td>
                <td align="left" style="width:25%;"></td>
                <td align="left" style="width:25%;"></td>
                <td align="center" style="width:25%;">( <?php echo $userid['user_nama'];?> )</td>
            </tr>
            <tr>
            </tr>
        </table>

    </div>
</body>

</html>
