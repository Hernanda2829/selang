<html lang="en" moznomarginboxes mozdisallowselectionprint>
<head>
    <?php 
	error_reporting(0);
    $userid=$userid->row_array();
    ?>
    <title>Laporan Data Pengeluaran <?php echo $userid['reg_name'];?></title>
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
    width: 210px; /* Mengatur lebar gambar */
    height: 50px; /* Mengatur tinggi gambar */
    border-radius: 50%; /* Membuat gambar melengkung (lingkaran) */
    object-fit: cover; /* Mengatur cara gambar diatur di dalam area */
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
                <h4 style="margin: 0; margin-left: -110px;">LAPORAN PENGELUARAN <?php echo strtoupper($userid['reg_code']);?> <?php echo strtoupper($userid['reg_name']);?></h4>
                <h4 style="margin: 0; margin-left: -110px;">PERIODE <?php echo date('d/m/Y', strtotime($tgl1)) .' S/d '. date('d/m/Y', strtotime($tgl2)) ;?> </h4>
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
    <div class="col-lg-9">
        <?php
        // Inisialisasi array untuk menyimpan data per kategori
        $kategori_data = array();
        $totRec=0;
        // Kumpulkan data per kategori
        foreach ($data as $a):
            $beb_tgl = $a['beban_tanggal'];
            $beb_nm = $a['beban_nama'];
            $beb_jml = $a['beban_jumlah'];
            $beb_kat = $a['beban_kat_nama'];
            $beb_kat_id = $a['beban_kat_id'];

            // Tambahkan data ke dalam array kategori_data
            if (!isset($kategori_data[$beb_kat])) {
                $kategori_data[$beb_kat] = array(
                    'nama' => $beb_kat,
                    'id' => $beb_kat_id,
                    'no' => 1, // Atur nomor urut grup menjadi 1
                    'total' => 0,
                    'data' => array()
                );
            }

            $kategori_data[$beb_kat]['data'][] = array(
                'no' => $kategori_data[$beb_kat]['no'], // Gunakan nomor urut grup
                'tanggal' => $beb_tgl,
                'nama' => $beb_nm,
                'jumlah' => $beb_jml
            );

            // Akumulasi total jumlah per kategori
            $kategori_data[$beb_kat]['total'] += $beb_jml;

            // Tingkatkan nomor urut grup
            $kategori_data[$beb_kat]['no']++;
            $totRec++;
        endforeach;

        $beb_total = 0;
        
        // Tampilkan data per kategori
        foreach ($kategori_data as $kategori_info):
            echo '<div style="text-align:left; width:700px; margin-top:0; margin-bottom:10px; margin-left:auto; margin-right:auto;">';
            echo '<h4>' . $kategori_info['id'] . '. ' . $kategori_info['nama'] . '</h4>';
            echo '</div>';
            echo '
            <table border="1" align="center" style="width:700px;margin-top:-10px;">
                <thead>
                    <tr>
                        <th style="width:5%;text-align:center">No</th>    
                        <th style="width:20%;text-align:center">Tanggal Transaksi</th>    
                        <th style="width:50%;text-align:center">Nama Pengeluaran</th>
                        <th style="width:25%;text-align:center">Jumlah</th>
                    </tr>
                </thead>
                <tbody>';

            foreach ($kategori_info['data'] as $subgroup):
                echo '
                <tr>
                    <td style="width:5%;text-align:center;">' . $subgroup['no'] . '</td>
                    <td style="width:20%;padding-left:3px;">' . $subgroup['tanggal'] . '</td>
                    <td style="width:50%;padding-left:3px;">' . $subgroup['nama'] . '</td>
                    <td style="width:25%;text-align:right;padding-right:3px;">' . 'Rp ' . str_replace(',', '.', number_format($subgroup['jumlah'])) . '</td>
                </tr>';
            endforeach;
            
            $beb_total += $kategori_info['total'];
            

            // Tampilkan total jumlah per kategori
            echo '
                <tr>
                    <td colspan="3" style="text-align:right;font-size:11px;padding-right:5px;"><b>Total ' . $kategori_info['nama'] . ' : </b></td>
                    <td style="text-align:right;font-size:11px;padding-right:3px;"><b>Rp ' . str_replace(',', '.', number_format($kategori_info['total'])) . '</b></td>
                </tr>';

            echo '
                </tbody>
            </table>';
        endforeach;


        echo '
        <table border="1" align="center" style="width:700px;margin-top:10px;">
            <thead>
                <tr class="total-grup-row">
                    <th style="width:5%;text-align:center">No</th>    
                    <th style="width:20%;text-align:center">Tanggal Transaksi</th>    
                    <th style="width:50%;text-align:center">Nama Pengeluaran</th>
                    <th style="width:25%;text-align:center">Jumlah</th>
                </tr>
            </thead>
            <tbody>
            <tr class="total-grup-row">
                <td style="width:5%;text-align:center;">' . $subgroup['no'] . '</td>
                <td style="width:20%;">' . $subgroup['tanggal'] . '</td>
                <td style="width:50%;">' . $subgroup['nama'] . '</td>
                <td style="width:25%;text-align:right;">' . 'Rp ' . str_replace(',', '.', number_format($subgroup['jumlah'])) . '</td>
            </tr>
            
            <tr>
                <td colspan="2" style="font-size:11px;padding-left:5px;"><b>Total Record : '. $totRec . '</b></td>
                <td style="text-align:right;font-size:11px;padding-right:5px;"><b>Total Pengeluaran : </b></td>
                <td style="text-align:right;font-size:11px;padding-right:3px;"><b>Rp ' . str_replace(',', '.', number_format($beb_total)) . '</b></td>
            </tr>
    
            </tbody>
        </table>';

        ?>
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