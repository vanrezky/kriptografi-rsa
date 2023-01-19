<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		is_logged_in();
		$this->load->model('auth_model', 'auth');
	}
	public function index()
	{
		// $chart_array = [];
		// $bulan_ini = 1;
		// for ($i = 0; $i < 6; $i++) {
		// 	$nama_bulan[] = date('F Y', strtotime("-$i month"));
		// 	$chart_array[] = $this->auth->getChartData($i);
		// 	// echo date(', F Y', strtotime("-$i month"));
		// }
		// dd($chart_array);
		// $bulan_array = [];
		// foreach ($this->auth->getBulan() as $key => $value) {
		// }

		$sekilas = $this->auth->getSekilas();

		$grafik = [
			'labels' => ['Riwayat', 'Pasien', 'Dokter', 'Perawat'],
			'series' => [$sekilas['riwayat'], $sekilas['pasien'], $sekilas['dokter'], $sekilas['perawat_bidan']]
		];

		$data = [
			'title' => 'Dashboard',
			'sekilas' => $sekilas,
			'grafik' => $grafik,
			// 'bulan' => $bulan_array,
		];

		$this->render('v_dashboard_index', $data);

		// $data['title'] = 'Dashboard';
		// $data['data'] = $this->auth->get_dashboard_info();

		// $this->render('index', $data);
	}
}
