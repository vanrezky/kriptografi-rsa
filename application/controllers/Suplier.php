<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Suplier extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('suplier_model', 'suplier');
        is_logged_in();
    }

    public function index()
    {

        $search = (!empty($this->input->cookie('fnama_suplier')) ? $this->input->cookie('fnama_suplier') : '');
        $per_page = (!empty($this->input->cookie('fper_page')) ? $this->input->cookie('fper_page') : '10');

        // ------------------------------ form validasi -------------------
        $this->form_validation->set_rules('nama_suplier', 'Nama suplier', 'trim|required', [
            'required' => 'Nama suplier tidak Boleh Kosong!'
        ]);

        if ($this->form_validation->run() == false) {

            $config["base_url"] = base_url('suplier/index');
            $jumlah_data = $this->db->like('nama_suplier', $search, 'both')->get('tb_suplier')->num_rows();
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
                'title' => 'Suplier', //judul halaman
                'data' => $this->suplier->get_suplier_info($config['per_page'], $from, $search),
                'jumlah_data' => $jumlah_data,
            ];

            $this->render('suplier/suplier_index', $data);
        } else {

            // simpan data ke database
            $data = [
                'nama_suplier' => htmlspecialchars($this->input->post('nama_suplier', true)),
                'date_created' => current_timestamp()
            ];

            $this->suplier->save_suplier_info($data); //simpan data dengan memanggil fungsi simpan di model

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"> Selamat!, suplier anda berhasil didaftarkan. </div>');
            redirect('suplier');
        }
    }

    public function update($param)
    {
        $param = decode($param); // decrypt\

        // ------------------------------ form validasi -------------------
        $this->form_validation->set_rules('nama_suplier', 'Nama suplier', 'trim|required', [
            'required' => 'Nama suplier tidak Boleh Kosong!'
        ]);

        // --------- end Validasi -----------

        if ($this->form_validation->run() == false) {

            $data = [
                'title' => 'Update suplier', //judul halaman
                'suplier' => $this->suplier->get_single_suplier($param), //get suplier berdasarkan id
            ];

            $this->render('suplier/suplier_edit', $data);
        } else {

            $data = [
                'nama_suplier' => htmlspecialchars($this->input->post('nama_suplier', true)),
            ];

            $this->suplier->update_suplier_info($data, $param);

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">suplier berhasil diperbaharui!</div>');
            redirect('suplier');
        }
    }

    public function delete($e_id)
    {
        $id = decode($e_id); // decrypt

        $this->suplier->delete_suplier_info($id);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">suplier berhasil dihapus!</div>');
        redirect('suplier');
    }
}
