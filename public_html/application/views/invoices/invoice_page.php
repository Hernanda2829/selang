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
    align-items: center; /* Memastikan konten di tengah secara horizontal */
    justify-content: center; /* Memastikan konten di tengah secara vertikal */
    height: 100vh; /* Memastikan konten mengisi seluruh tinggi viewport */
    margin: 0; /* Menghilangkan margin bawaan */
  }

  #title {
    margin-top: -10%; /* Sesuaikan dengan nilai negatif untuk mengangkat elemen */
  }

  #tbl_info {
    width: 50%; /* Lebar tabel */
  }
        
  /* Media query untuk handphone */
  @media only screen and (max-width: 600px) {
    #tbl_info {
      width: 80%; /* Mengubah lebar tabel menjadi 80% saat tampilan handphone */
    }
  }
   
</style>
</head>
<body>


   <div id="title">
        <h2 >Informasi Barang</h2>
    </div>
    <table id="tbl_info" style="font-size:11px;">
        <tr>
            <td style="width:50%;text-align:right;"><b>No Faktur</b></td>
            <td style="width:50%;">: <?php echo $invoice->g_nofak; ?></td>
        </tr>
        <tr>
            <td style="width:50%;text-align:right;"><b>Kode Barang</b></td>
            <td style="width:50%;">: <?php echo $invoice->g_brg_id; ?></td>
        </tr>
        <tr>
            <td style="width:50%;text-align:right;"><b>Nama Barang</b></td>
            <td style="width:50%;">: <?php echo $invoice->g_brg_nama; ?> ( <?php echo $invoice->g_brg_sat; ?> )</td>
        </tr>
        <tr>
            <td style="width:50%;text-align:right;"><b>Quantity</b></td>
            <td style="width:50%;">: <?php echo $invoice->g_qty; ?></td>
        </tr>
        <tr>
            <td style="width:50%;text-align:right;"><b>Jenis Bayar</b></td>
            <td style="width:50%;">: <?php echo $invoice->g_jenis_bayar; ?> ( <?php echo $invoice->g_status_bayar; ?> )</td>
        </tr>
        <tr>
            <td style="width:50%;text-align:right;"><b>Periode Garansi</b></td>
            <td style="width:50%;">: <?php echo $invoice->g_hari; ?> hari</td>
        </tr>
        <tr>
            <td style="width:50%;text-align:right;"><b>Tgl Batas Garansi</b></td>
            <td style="width:50%;">: 
              <?php 
                  $tgl_batas_garansi = strtotime($invoice->g_jtempo); // Ambil tanggal batas garansi
                  echo date('d-m-Y', $tgl_batas_garansi); // Tampilkan tanggal batas garansi

                  // Cek jika tanggal hari ini melebihi tanggal batas garansi
                  if (time() > $tgl_batas_garansi) {
                      echo "<span style='color:red; position: relative;'> (Garansi Habis)";
                      echo "<img src='" . base_url() . "assets/img/expired.png' alt='Garansi Habis' style='position: absolute; left: 40%; top: 20px; width: 100px;'>";
                      echo "</span>";
                  }
              ?>
          </td>

        </tr>
        <tr>
            <td style="width:50%;text-align:right;"><b>Keterangan</b></td>
            <td style="width:50%;">: <?php echo $invoice->g_ket; ?></td>
        </tr>        
    </table>



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

