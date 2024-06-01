<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <title>Informasi Barang</title>
    <!-- Font Awesome -->
    
    <link href="<?php echo base_url().'assets/css/font-awesome.css'?>" rel="stylesheet">
    <!-- Google Fonts Roboto -->
    
    <!-- MDB -->
    <link href="<?php echo base_url().'snippet/css/mdb.min.css'?>" rel="stylesheet">
    <!-- Custom styles -->
    
  
<style>
 

  footer {
    position: fixed;
    bottom: 0;
    width: 100%;
    background-color: rgba(0, 0, 0, 0.2);
    color: white;
    text-align: center;
    padding: 15px;
  }


 body {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh; /* Menggunakan tinggi 100% dari viewport height untuk mengatasi vertikal centering */
            margin: 0;
        }

        .image-container {
            text-align: center;
            margin-top: -200px; /* Sesuaikan dengan nilai negatif untuk menggeser ke atas */
        }

        .image-container img {
            max-width: 250px; /* Mengatur lebar maksimum gambar */
            max-height: 250px; /* Mengatur tinggi maksimum gambar */
            width: auto; /* Agar gambar tetap proporsional */
            height: auto; /* Agar gambar tetap proporsional */
        }

        .image-container p {
            margin-top: 10px; /* Jarak antara gambar dan teks */
        }
        
   
</style>
</head>
<body>

<?php if (!isset($garansi_info)): ?>
    <div class="image-container">
        <?php if (isset($invoice) && is_object($invoice)): ?>
            <img src="<?php echo base_url().'assets/img/img_barcode/'.$invoice->g_image;?>" alt="Your Image">
        <?php else: ?>
            <p>Informasi Barang tidak tersedia</p>
        <?php endif; ?>
    </div>

    <div style="display:flex;align-items:center;">
        <form class="form-horizontal" method="post" action="<?php echo base_url().'page/show_page'?>">
            <input type="text" name="kode" style="width:200px;font-size:12px;text-align:center;" class="form-control input-sm">
    </div>
    <span style="font-size:10px;color:#f08c8c;">Untuk menampilkan 'Informasi Barang' ketikan : No Faktur-Kode Barang</span>
    <button type="submit" class="btn btn-info">View</button>
    </form>
<?php endif; ?>


<?php if (isset($garansi_info)): ?>
    <div style="text-align: center;margin-top: -200px;width: 50%; ">
        <h2 >Informasi Barang</h2>
        <hr >
    </div>
    <table style="font-size:11px;width:50%;margin:0 auto;">
        <tr>
            <td><b>Nama Barang</b></td>
            <td>: <?php echo $garansi_info->g_brg_nama; ?></td>
            <td><b>Satuan</b></td>
            <td>: <?php echo $garansi_info->g_brg_sat; ?></td>
        </tr>
        <tr>
            <td><b>Quantity</b></td>
            <td>: <?php echo $garansi_info->g_qty; ?></td>
            <td><b>Harga</b></td>
            <td>: <?php echo 'Rp ' . number_format($garansi_info->g_harjul,0, ',' ,'.'); ?></td>
        </tr>
        <tr>
            <td><b>Diskon</b></td>
            <td>: <?php echo 'Rp ' . number_format($garansi_info->g_diskon,0, ',' ,'.'); ?></td>
            <td><b>Total</b></td>
            <td>: <?php echo 'Rp ' . number_format($garansi_info->g_total,0, ',' ,'.'); ?></td>
        </tr>
        <tr>
            <td><b>Jenis Bayar</b></td>
            <td>: <?php echo $garansi_info->g_jenis_bayar; ?></td>
            <td><b>Status Bayar</b></td>
            <td>: <?php echo $garansi_info->g_status_bayar; ?></td>
        </tr>
        <tr>
            <td><b>Periode Garansi</b></td>
            <td>: <?php echo $garansi_info->g_hari; ?> hari</td>
            <td><b>Tgl Batas Garansi</b></td>
            <td>: <?php echo date('d-m-Y', strtotime($garansi_info->g_jtempo)); ?></td>
        </tr>
        <tr>
            <td colspan="4">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="4" style="text-align: center;">Keterangan : <?php echo $garansi_info->g_ket; ?></td>
        </tr>
    </table>
<?php endif; ?>







  <footer class="bg-light text-center text-white">
  <!-- Grid container -->
  <div class="container p-4 pb-0">
    <!-- Section: Social media -->
    <section class="mb-4">
      <!-- Facebook -->
      <a
        class="btn btn-primary btn-floating m-1"
        style="background-color: #3b5998;"
        href="#!"
        role="button"
        ><i class="fa fa-facebook"></i
      ></a>

      <!-- Twitter -->
      <a
        class="btn btn-primary btn-floating m-1"
        style="background-color: #55acee;"
        href="#!"
        role="button"
        ><i class="fa fa-twitter"></i
      ></a>

      <!-- Google -->
      <a
        class="btn btn-primary btn-floating m-1"
        style="background-color: #dd4b39;"
        href="#!"
        role="button"
        ><i class="fa fa-google"></i
      ></a>

      <!-- Instagram -->
      <a
        class="btn btn-primary btn-floating m-1"
        style="background-color: #ac2bac;"
        href="#!"
        role="button"
        ><i class="fa fa-instagram"></i
      ></a>

      <!-- Linkedin -->
      <a
        class="btn btn-primary btn-floating m-1"
        style="background-color: #0082ca;"
        href="#!"
        role="button"
        ><i class="fa fa-linkedin"></i
      ></a>
      <!-- Github -->
      <a
        class="btn btn-primary btn-floating m-1"
        style="background-color: #333333;"
        href="#!"
        role="button"
        ><i class="fa fa-github"></i
      ></a>
    </section>
    <!-- Section: Social media -->
 
  <!-- Grid container -->

  <!-- Copyright -->
  <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
    © 2023 Copyright:
    <a class="text-white" href="https://samuderaselang.com/">samuderaselang.com</a>
  </div>
  <!-- Copyright -->
</footer>
  
</div>




<!-- End of .container -->
    <!-- MDB -->
    
    <script type="text/javascript" src="<?php echo base_url().'snippet/js/mdb.min.js'?>"></script>
    <!-- Custom scripts -->
    
    
</body>
</html>

