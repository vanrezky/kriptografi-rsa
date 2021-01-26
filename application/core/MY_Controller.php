<?php
class MY_Controller extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        // $this->load->model('auth_model', 'auth');
    }

    function render($view, $data)
    {
        $username = decode($this->session->userdata('username'));
        $data['account_detail'] = $this->db->get_where('user', ['username' => $username])->row_array();


        $this->load->view('layout/header', $data);
        $this->load->view('layout/navbar');
        $this->load->view('layout/sidebar');
        $this->load->view('layout/breadcrumb');
        $this->load->view($view);
        $this->load->view('layout/footer');
    }
}
