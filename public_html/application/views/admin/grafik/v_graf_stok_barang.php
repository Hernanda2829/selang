<!DOCTYPE html>
<html>
<head>
    <title>Grafik Stok Barang</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <!-- load library jquery dan highcharts -->
    
    <!-- end load library -->

</head>



<body>

<?php
    /* Mengambil query report*/
    foreach($report as $result){
        $bulan[] = $result->kategori_nama; //ambil bulan
        $value[] = (float) $result->tot_stok; //ambil nilai
        // echo '<td>kategori nama : ' .$result->kategori_nama. '</td> ';
        // echo '<td>Jumlah : ' .(float) $result->tot_stok. '</td> ';
    }
    /* end mengambil query*/
     
?>
 
<!-- Load chart dengan menggunakan ID -->
<div id="report"></div>
<!-- END load chart -->

<script src="<?php echo base_url().'assets/js/grafik/jquery.js'?>"></script>
<script src="<?php echo base_url().'assets/js/grafik/highcharts.js'?>"></script>
<!-- Script untuk memanggil library Highcharts -->

<script type="text/javascript">
$(function () {
    var values = <?php echo json_encode($value); ?>;

    $('#report').highcharts({
        chart: {
            type: 'line',
            margin: 75,
            height:500,
            marginBottom: 150,
            reflow: true,
            options3d: {
                enabled: false,
                alpha: 10,
                beta: 25,
                depth: 70
            },

            
        },
        title: {
            text: 'Grafik Stok Barang Perkategori',
            style: {
                fontSize: '18px',
                fontFamily: 'Verdana, sans-serif'
            }
        },
        subtitle: {
            text: '',
            style: {
                fontSize: '15px',
                fontFamily: 'Verdana, sans-serif'
            }
        },
        plotOptions: {
            line: {
                dataLabels: {
                    enabled: true,
                    color: '#045396',
                    align: 'center',
                    formatter: function () {
                        return Highcharts.numberFormat(this.y, 0);
                    },
                    y: 0,
                    style: {
                        fontSize: '13px',
                        fontFamily: 'Verdana, sans-serif'
                    }
                },
                marker: {
                    symbol: 'circle',
                    states: {
                        hover: {
                            fillColor: null // menghapus warna saat hover
                        }
                    }
                }
            }
        },
        credits: {
            enabled: false
        },
        xAxis: {
            categories: <?php echo json_encode($bulan); ?>
        },
        exporting: {
            enabled: false
        },
        yAxis: {
            title: {
                text: 'Total Stok'
            },
        },
        tooltip: {
            formatter: function () {
                return 'Total Stok <b>' + this.x + '</b> Adalah <b>' + Highcharts.numberFormat(this.y, 0) + '</b> Items ';
            }
        },


        legend: {
            layout: 'vertikal', // Menetapkan layout ke 'horizontal'
            align: 'left', // Menetapkan alignment ke 'center'
            verticalAlign: 'bottom', // Menetapkan vertical alignment ke 'bottom'
            x: 50,
            y: 20, // Menentukan posisi vertikal legenda di luar grafik
            itemMarginBottom: 10, // Menambahkan margin antar item
            itemStyle: {
                fontSize: '12px',
                fontFamily: 'Verdana, sans-serif'
               
            }
        },


        series: [{
            name: 'Stok Barang',
            data: values.map(function (val) {
                return {
                    y: val,
                    marker: {
                        //fillColor: val > 100 ? 'lightgreen' : (val == 0 ? 'red' : '#FFD700')
                        fillColor: val > 100 ? 'lightgreen' : (val === 0 ? 'red' : (val < 20 ? 'red' : '#FFD700'))

                    }
                };
            }),
            shadow: true

            }, {
            name: ' stok = 0 < 20 \u00A0 \u00A0 \u00A0 <span style="color:red;font-size:11px;">(Segera lakukan pembelian barang!)</span>',
            data: [], // Anda dapat mengganti ini dengan data yang sesuai
            marker: {
                fillColor: 'Red'
            },
            shadow: true
           
        }, {
            name: ' stok = 21 < 100 \u00A0 <span style="color:#FFD700;font-size:11px;">(Stok cukup)</span>',
            data: [],
            marker: {
                fillColor: '#FFD700'
            },
            shadow: true
        }, {
            name: '  stok > 100 \u00A0 \u00A0 \u00A0 \u00A0 \u00A0 \u00A0<span style="color:green;font-size:11px;">(Stok Aman)</span>',
            data: [],
            marker: {
                fillColor: 'lightgreen'
            },
           shadow: true

        }],
       

        

    });
});
</script>





















</body>
</html>

 
