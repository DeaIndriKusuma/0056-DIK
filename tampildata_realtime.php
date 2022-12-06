<!DOCTYPE HTML>
<html>
    <head>

    </head>

    <body>

        <br><br><br>
        <!-- menampilkan grafik dengan id chartContainer -->
        <!-- ukuran grafik: tinggi = 550 piksel, dan maksimal lebar 920 piksel -->
        <div id="chartContainer" style="height: 250px; max-width: 520px; margin: 0px auto;"></div>

        <h2 style="text-align: center">Monitoring Suhu</h2>

        <!-- import libaray canvasjs dan jquery dengan cdn  -->
        <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.5.1.js"
            integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>

        <script>
            window.onload = function () {

                //inisialisasi data array dps kepanjangan dari datapoints
                var dps = [];
                var dataLength = 100; // panjang data yang ditampilkan (horizontal), ditampilkan di bagian bawah grafik
                var updateInterval = 1000; //setiap 1,5 dtk data direfresh
                var xVal = 0; 
                var yVal = 0; 

                //inisialisasi chart js
                var chart = new CanvasJS.Chart("chartContainer", {
                    title: {
                        text: "Grafik Suhu Realtime" //memberi judul grafik
                    },
                    data: [{
                        type: "line", //tipe grafik yang digunakan, lihat di situsnya untuk lihat gaya lain
                        dataPoints: dps //dps adalah data yang digunakan
                    }]
                });

                var updateChart = function (count) {
                    // data bitcoin yang digunakan https://api.coindesk.com/v1/bpi/currentprice.json
                    $.getJSON("http://localhost/MQTT-PHP/getdata.php", function (data) {

                        var suhu = data.suhu//mengambil data spesifik rate_float
                        console.log(suhu) //menampilkan data dengan console.log hanya terlihat saat mode inspect element
                        yVal = suhu // mengisi variabel yVal dengan data usd

                        count = count || 1;

                        //melakukan perulangan data dengan for agar data dapat dijalankan
                        for (var j = 0; j < count; j++) {
                            dps.push({
                                x: xVal,
                                y: yVal
                            });
                            xVal++;
                        }

                        //jika datapoints telah melewati datalength
                        if (dps.length > dataLength) {
                            dps.shift(); //maka hapus data awal dengan fungsi shift()
                        }

                    })
                    chart.render();
                };

                //jalankan fungsi updateChart di atas
                updateChart(dataLength);

                //fungsi agar data dapat diupdate setiap 1000 detik sekali
                setInterval(function () {
                    updateChart()
                }, updateInterval);
            }

        </script>
    </body>
</html>