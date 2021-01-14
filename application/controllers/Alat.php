<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Alat extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('alat_model', 'alat');
        is_logged_in();
    }

    public function index()
    {

        $search = (!empty($this->input->cookie('fnama_alat')) ? $this->input->cookie('fnama_alat') : '');
        $per_page = (!empty($this->input->cookie('fper_page')) ? $this->input->cookie('fper_page') : '10');

        // ------------------------------ form validasi -------------------

        $this->form_validation->set_rules('kode_alat', 'Kode alat', 'trim|required|is_unique[tb_alat.kode_alat]', [
            'is_unique' => 'Kode alat sudah terdaftar!',
            'required' => 'Kode alat tidak boleh kosong!',
        ]);
        $this->form_validation->set_rules('nama_alat', 'Nama alat', 'trim|required', [
            'required' => 'Nama alat tidak Boleh Kosong!'
        ]);

        if ($this->form_validation->run() == false) {

            $config["base_url"] = base_url('alat/index');
            $jumlah_data = $this->db->like('nama_alat', $search, 'both')->get('tb_alat')->num_rows();
            $config['total_rows'] = $jumlah_data;
            $config['per_page'] = $per_page;
            $from = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
            $config["uri_segment"] = 3;

            // Membuat Style pagination untuk BootStrap v4
            $config['first_link']       = 'First';
            $config['last_link']        = 'Last';
            $config['next_link']        = 'Next';
            $config['prev_link']        = 'Prev';
            $config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination justify-content-center">';
            $config['full_tag_close']   = '</ul></nav></div>';
            $config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
            $config['num_tag_close']    = '</span></li>';
            $config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
            $config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
            $config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
            $config['next_tagl_close']  = '<span aria-hidden="true">&raquo;</span></span></li>';
            $config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
            $config['prev_tagl_close']  = '</span>Next</li>';
            $config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
            $config['first_tagl_close'] = '</span></li>';
            $config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
            $config['last_tagl_close']  = '</span></li>';
            // $config['attributes'] = array('class' => 'page-link');
            $this->pagination->initialize($config);

            $data = [
                'title' => 'Alat', //judul halaman
                'kode_alat' => $this->alat->set_kode_alat(), // generate kode alat otomatis
                'data' => $this->alat->get_alat_info($config['per_page'], $from, $search),
                'jumlah_data' => $jumlah_data,
            ];

            $this->render('alat/alat_index', $data);
        } else {

            // simpan data ke database
            $data = [
                'kode_alat' => htmlspecialchars($this->input->post('kode_alat', true)),
                'nama_alat' => htmlspecialchars($this->input->post('nama_alat', true)),
                'date_created' => current_timestamp()
            ];

            $this->alat->save_alat_info($data); //simpan data dengan memanggil fungsi simpan di model

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"> Selamat!, alat anda berhasil didaftarkan. </div>');
            redirect('alat');
        }
    }

    public function update($param)
    {
        $param = decode($param); // decrypt\

        // ------------------------------ form validasi -------------------
        $this->form_validation->set_rules('nama_alat', 'Nama alat', 'trim|required', [
            'required' => 'Nama alat tidak Boleh Kosong!'
        ]);
        // --------- end Validasi -----------

        if ($this->form_validation->run() == false) {

            $data = [
                'title' => 'Update alat', //judul halaman
                'alat' => $this->alat->get_single_alat($param), //get alat berdasarkan id
            ];

            $this->render('alat/alat_edit', $data);
        } else {
            $data = [
                'nama_alat' => htmlspecialchars($this->input->post('nama_alat', true)),
            ];

            $this->alat->update_alat_info($data, $param);

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Alat berhasil diperbaharui!</div>');
            redirect('alat');
        }
    }

    public function delete($e_id)
    {
        $id = decode($e_id); // decrypt

        $this->alat->delete_alat_info($id);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">alat berhasil dihapus!</div>');
        redirect('alat');
    }
}
