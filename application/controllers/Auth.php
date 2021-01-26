<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('auth_model', 'auth');
    }
    // ------------------------------------ login page ---------------------
    public function index()
    {
        //jika session sudah ada username
        if ($this->session->has_userdata('username')) redirect('dashboard');

        // =========== start validasi
        $this->form_validation->set_rules('username', 'Username', 'trim|required', [
            'required' => 'Username tidak boleh kosong!',
        ]);
        $this->form_validation->set_rules('password', 'Password', 'trim|required', [
            'required' => 'Password tidak boleh kosong!',
        ]);
        // =========== end validasi

        if ($this->form_validation->run() == false) { // jika form validasi salah

            $data['title'] = 'Login';

            $this->load->view('v_auth_login', $data); // load view

        } else {

            $dt['username']     = $this->input->post('username');
            $dt['password']  = $this->input->post('password');

            $this->auth->getLoginData($dt); // cek login di model
        }
    }

    // ------------------------------------ cek profile ------------------

    public function profile()
    {
        $data['title'] = 'Profile';

        $this->render('user/profile', $data);
    }

    // ------------------------ End cek profile---------------------------

    // ------------------------------------- logout---------------------------------
    public function logout()
    {
        $this->session->unset_userdata('username');
        $this->session->unset_userdata('level');

        $this->session->set_flashdata('pesan_auth', '<div class="alert alert-success" role="alert">Anda berhasil keluar!</div>');
        redirect('auth');
    }

    // ---------------------------------  end logout ---------------------------------

}
