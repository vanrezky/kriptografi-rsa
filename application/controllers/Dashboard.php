<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('auth_model', 'auth');
		is_logged_in();
	}
	public function index()
	{


		$data['title'] = 'Dashboard';
		$data['data'] = $this->auth->get_dashboard_info();

		$this->render('index', $data);
	}
}
