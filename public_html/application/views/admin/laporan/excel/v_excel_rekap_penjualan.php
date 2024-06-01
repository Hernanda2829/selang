<!DOCTYPE html>
<html>
<head>
    <?php 
	error_reporting(0);
    $userid=$userid->row_array();
    ?>
    <title>Rekapitulasi Penjualan</title>
<style>
    table {
        width: 100%;
        border-collapse: collapse;
    }

    td, th {
        border: 0.5pt solid black;
        padding: 10px;
    }

    .category-end {
        border-bottom: 0;
    }
</style>
</head>
<body>
    <p><b> REKAPITULASI PENJUALAN TAHUN <?php echo strtoupper($tahun);?></b></p>
    <table width="100%">
    <thead>
        <tr>
            <th rowspan="2" style="text-align:center;vertical-align:middle;color:white;background-color:#eb1b28;">No</th>
            <th rowspan="2" style="text-align:center;vertical-align:middle;color:white;background-color:#eb1b28;">Cabang</th>

            <?php for ($bulan = 1; $bulan <= $jml_bln; $bulan++): ?>
                <th colspan="5" style="text-align:center;color:white;background-color:black;"><?= date('M Y', strtotime("$tahun-$bulan")); ?></th>
            <?php endfor; ?>
            <th colspan="5" style="text-align:center;color:white;background-color:black;">Total <?= date('M', strtotime("$tahun-1")); ?> s.d <?= date('M', strtotime("$tahun-$jml_bln")); ?> <?= $tahun; ?></th>
        </tr>
        <tr>
            <?php for ($bulan = 1; $bulan <= $jml_bln; $bulan++): ?>
                <th style="text-align:center;color:#4f81bd;background-color:white">Omzet</th>
                <th style="text-align:center;color:#c0504d;background-color:white">Piutang</th>
                <th style="text-align:center;color:#9bbb59;background-color:white">Pelunasan</th>
                <th style="text-align:center;color:#FFD700;background-color:white">Pengeluaran</th>
                <th style="text-align:center;color:#030305;background-color:white">Transfer</th>
            <?php endfor; ?>
                <th style="text-align:center;color:#4f81bd;background-color:white">Omzet</th>
                <th style="text-align:center;color:#c0504d;background-color:white">Piutang</th>
                <th style="text-align:center;color:#9bbb59;background-color:white">Pelunasan</th>
                <th style="text-align:center;color:#FFA700;background-color:white">Pengeluaran</th>
                <th style="text-align:center;color:#030305;background-color:white">Transfer</th>
        </tr>
        
        
        <tr>
            <th colspan="2" class="grand-total" style="text-align:right;font-weight:bold;color:white;background-color:#027c3f;">Grand Total</th>
            <?php
                $grandTotalOmzet = $grandTotalPiutang = $grandTotalPelunasan = $grandTotalPengeluaran = $grandTotalTransfer = 0;
                for ($bulan = 1; $bulan <= $jml_bln; $bulan++):
                    $totalOmzet = $totalPiutang = $totalPelunasan = $totalPengeluaran = $totalTransfer = 0;
                    foreach ($data->result_array() as $a):
                        $totalOmzet += $a['omzet' . $bulan];
                        $totalPiutang += $a['piutang' . $bulan];
                        $totalPelunasan += $a['pelunasan' . $bulan];
                        $totalPengeluaran += $a['pengeluaran' . $bulan];
                        $totalTransfer += $a['transfer' . $bulan];
                    endforeach;
                    echo '<th style="text-align:right;font-weight:bold;color:white;background-color:#027c3f">' . number_format($totalOmzet) . '</th>';
                    echo '<th style="text-align:right;font-weight:bold;color:white;background-color:#027c3f">' . number_format($totalPiutang) . '</th>';
                    echo '<th style="text-align:right;font-weight:bold;color:white;background-color:#027c3f">' . number_format($totalPelunasan) . '</th>';
                    echo '<th style="text-align:right;font-weight:bold;color:white;background-color:#027c3f">' . number_format($totalPengeluaran) . '</th>';
                    echo '<th style="text-align:right;font-weight:bold;color:white;background-color:#027c3f">' . number_format($totalTransfer) . '</th>';
                    $grandTotalOmzet += $totalOmzet;
                    $grandTotalPiutang += $totalPiutang;
                    $grandTotalPelunasan += $totalPelunasan;
                    $grandTotalPengeluaran += $totalPengeluaran;
                    $grandTotalTransfer += $totalTransfer;
                endfor;
                    echo '<th style="text-align:right;font-weight:bold;color:white;background-color:#027c3f">' . number_format($grandTotalOmzet) . '</th>';
                    echo '<th style="text-align:right;font-weight:bold;color:white;background-color:#027c3f">' . number_format($grandTotalPiutang) . '</th>';
                    echo '<th style="text-align:right;font-weight:bold;color:white;background-color:#027c3f">' . number_format($grandTotalPelunasan) . '</th>';
                    echo '<th style="text-align:right;font-weight:bold;color:white;background-color:#027c3f">' . number_format($grandTotalPengeluaran) . '</th>';
                    echo '<th style="text-align:right;font-weight:bold;color:white;background-color:#027c3f">' . number_format($grandTotalTransfer) . '</th>';
            ?>
            <th colspan="5"></th>
        </tr>
        
    </thead>
    <tbody>
        <?php 
        $no = 0;
        foreach ($data->result_array() as $a):
            $no++;
            $id = $a['reg_id'];
            $cab = $a['reg_name'];

            $totalOmzet = $totalPiutang = $totalPelunasan = $totalPengeluaran = $totalTransfer = 0;
        ?>
            <tr>
                <td style="text-align:center;"><?php echo $no;?></td>
                <td><?php echo $cab;?></td>
                
                <?php for ($bulan = 1; $bulan <= $jml_bln; $bulan++): 
                    $totalOmzet += $a['omzet' . $bulan];
                    $totalPiutang += $a['piutang' . $bulan];
                    $totalPelunasan += $a['pelunasan' . $bulan];
                    $totalPengeluaran += $a['pengeluaran' . $bulan];
                    $totalTransfer += $a['transfer' . $bulan];
                ?>
                    <td style="text-align:right;"><?php echo number_format($a['omzet' . $bulan]);?></td>
                    <td style="text-align:right;"><?php echo number_format($a['piutang' . $bulan]);?></td>
                    <td style="text-align:right;"><?php echo number_format($a['pelunasan' . $bulan]);?></td>
                    <td style="text-align:right;"><?php echo number_format($a['pengeluaran' . $bulan]);?></td>
                    <td style="text-align:right;"><?php echo number_format($a['transfer' . $bulan]);?></td>
                <?php endfor; ?>
                    <td style="text-align:right;font-weight:bold;color:#4f81bd;background-color:#f2f2f2;"><?php echo number_format($totalOmzet);?></td>
                    <td style="text-align:right;font-weight:bold;color:#c0504d;background-color:#f2f2f2;"><?php echo number_format($totalPiutang);?></td>
                    <td style="text-align:right;font-weight:bold;color:#9bbb59;background-color:#f2f2f2;"><?php echo number_format($totalPelunasan);?></td>
                    <td style="text-align:right;font-weight:bold;color:#FFA700;background-color:#f2f2f2;"><?php echo number_format($totalPengeluaran);?></td>
                    <td style="text-align:right;font-weight:bold;color:#030305;background-color:#f2f2f2;"><?php echo number_format($totalTransfer);?></td>
            </tr>
        <?php endforeach;?>
    </tbody>
    </table>
</body>
</html>
