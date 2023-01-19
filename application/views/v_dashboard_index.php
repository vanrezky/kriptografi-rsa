<div class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12 col-sm-6 col-md-3">
				<div class="info-box">
					<span class="info-box-icon bg-info elevation-1"><i class="fas fa-recycle"></i></span>
					<div class="info-box-content">
						<span class="info-box-text">Riwayat</span>
						<span class="info-box-number"><small>Jumlah:</small> <?= $sekilas['riwayat'] ?></span>
					</div>
				</div>
			</div>

			<div class="col-12 col-sm-6 col-md-3">
				<div class="info-box mb-3">
					<span class="info-box-icon bg-danger elevation-1"><i class="fas fa-users"></i></span>
					<div class="info-box-content">
						<span class="info-box-text">Pasien</span>
						<span class="info-box-number"><small>Jumlah:</small> <?= $sekilas['pasien'] ?></span>
					</div>
				</div>
			</div>
			<div class="clearfix hidden-md-up"></div>
			<div class="col-12 col-sm-6 col-md-3">
				<div class="info-box mb-3">
					<span class="info-box-icon bg-success elevation-1"><i class="fas fa-stethoscope"></i></span>
					<div class="info-box-content">
						<span class="info-box-text">Dokter</span>
						<span class="info-box-number"><small>Jumlah:</small> <?= $sekilas['dokter'] ?></span>
					</div>
				</div>
			</div>

			<div class="col-12 col-sm-6 col-md-3">
				<div class="info-box mb-3">
					<span class="info-box-icon bg-warning elevation-1"><i class="fas fa-user-nurse"></i></span>
					<div class="info-box-content">
						<span class="info-box-text">Perawat/Bidan</span>
						<span class="info-box-number"><small>Jumlah:</small> <?= $sekilas['perawat_bidan'] ?></span>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-6">
				<div class="card card-danger card-outline">
					<div class="card-body">
						<div id="chart-div" style="height: 260px;"></div>
					</div>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="card card-primary card-outline">
					<div class="card-body text-center">
						<img src="<?= base_url('public/assets/dist/img/puskesmas.png'); ?>" width="150">
						<h4>Selamat Datang di Puskesmas Berseri</h4>
						<p class="card-text">Melayani merupakan suatu kebahagiaan</p>
					</div>
				</div>
			</div>

		</div>
	</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
	$(document).ready(function() {

		var options = {
			series: <?= json_encode($grafik['series']) ?>,
			labels: <?= json_encode($grafik['labels']) ?>,
			chart: {
				type: 'polarArea',
			},
			stroke: {
				colors: ['#fff']
			},
			fill: {
				opacity: 0.7
			},
			responsive: [{
				breakpoint: 480,
				options: {
					chart: {
						width: 200
					},
					legend: {
						position: 'bottom'
					}
				}
			}]
		};

		var chart = new ApexCharts(document.querySelector("#chart-div"), options);
		chart.render();
	});
</script>
