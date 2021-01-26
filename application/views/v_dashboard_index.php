<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-primary card-outline">
                    <div class="card-body text-center">
                        <img src="<?= base_url('public/assets/dist/img/ibi.png'); ?>" width="150">
                        <h4>Selamat Datang di Klinik Citra Bunda</h4>

                        <p class="card-text">Melayani merupakan suatu kebahagiaan dalam kehidupan kami</p>
                    </div>

                </div>
            </div>
            <div class="col-lg-12">
                <div class="card card-outline">
                    <div class="card-header">
                        <h6 class="card-title">Statistik kunjungan pasien</h6>
                    </div>
                    <div class="card-body">

                        <div class="chart">
                            <canvas id="barChart" style="min-height: 250px; height: 400px; max-height: 400px; max-width: 100%;"></canvas>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
<script src="<?= base_url("public/assets/plugins/chart.js/Chart.min.js"); ?>"></script>
<script>
    var areaChartData = {
        labels: ['January', 'February', 'March', 'April', 'May', 'June'],
        datasets: [{
                label: 'Pasien',
                backgroundColor: 'rgba(60,141,188,0.9)',
                borderColor: 'rgba(60,141,188,0.8)',
                pointRadius: false,
                pointColor: '#3b8bba',
                pointStrokeColor: 'rgba(60,141,188,1)',
                pointHighlightFill: '#fff',
                pointHighlightStroke: 'rgba(60,141,188,1)',
                data: [28, 48, 40, 19, 86, 27]
            },
            {
                label: 'Kunjungan Pasien',
                backgroundColor: 'rgba(210, 214, 222, 1)',
                borderColor: 'rgba(210, 214, 222, 1)',
                pointRadius: false,
                pointColor: 'rgba(210, 214, 222, 1)',
                pointStrokeColor: '#c1c7d1',
                pointHighlightFill: '#fff',
                pointHighlightStroke: 'rgba(220,220,220,1)',
                data: [65, 59, 80, 81, 56, 55]
            },
        ]
    }
    var barChartCanvas = $('#barChart').get(0).getContext('2d')
    var barChartData = jQuery.extend(true, {}, areaChartData)
    var temp0 = areaChartData.datasets[0]
    var temp1 = areaChartData.datasets[1]
    barChartData.datasets[0] = temp1
    barChartData.datasets[1] = temp0

    var barChartOptions = {
        responsive: true,
        maintainAspectRatio: false,
        datasetFill: false
    }

    var barChart = new Chart(barChartCanvas, {
        type: 'bar',
        data: barChartData,
        options: barChartOptions
    })
</script>