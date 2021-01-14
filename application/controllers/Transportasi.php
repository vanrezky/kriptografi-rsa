<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Transportasi extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('transportasi_model', 'transportasi');
        is_logged_in();
    }

    public function index()
    {

        $search = (!empty($this->input->cookie('fnama_kendaraan')) ? $this->input->cookie('fnama_kendaraan') : '');
        $per_page = (!empty($this->input->cookie('fper_page')) ? $this->input->cookie('fper_page') : '10');

        // ------------------------------ form validasi -------------------

        $this->form_validation->set_rules('nama_kendaraan', 'Nama transportasi', 'trim|required', [
            'required' => 'Nama transportasi tidak Boleh Kosong!'
        ]);

        $this->form_validation->set_rules('jenis_kendaraan', 'Jenis Kendaraan', 'trim|required', [
            'required' => 'Jenis Kendaraan tidak Boleh Kosong!',
        ]);

        if ($this->form_validation->run() == false) {

            $config["base_url"] = base_url('transportasi/index');
            $jumlah_data = $this->db->like('nama_kendaraan', $search, 'both')->get('tb_transportasi')->num_rows();
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
                'title' => 'Transportasi', //judul halaman
                'data' => $this->transportasi->get_transportasi_info($config['per_page'], $from, $search),
                'jumlah_data' => $jumlah_data,
            ];

            $this->render('transportasi/transportasi_index', $data);
        } else {

            $data = [
                'nama_kendaraan' => htmlspecialchars($this->input->post('nama_kendaraan', true)),
                'jenis_kendaraan' => htmlspecialchars($this->input->post('jenis_kendaraan', true)),
            ];

            $this->transportasi->save_transportasi_info($data); //simpan data dengan memanggil fungsi simpan di model

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"> Selamat!, Transportasi anda berhasil didaftarkan. </div>');
            redirect('transportasi');
        }
    }

    public function update($param)
    {
        $param = decode($param); // decrypt\

        // ------------------------------ form validasi -------------------
        $this->form_validation->set_rules('nama_kendaraan', 'Nama transportasi', 'trim|required', [
            'required' => 'Nama transportasi tidak Boleh Kosong!'
        ]);

        $this->form_validation->set_rules('jenis_kendaraan', 'Jenis Kendaraan', 'trim|required', [
            'required' => 'Jenis Kendaraan Beli tidak Boleh Kosong!',
        ]);

        // --------- end Validasi -----------

        if ($this->form_validation->run() == false) {

            $data = [
                'title' => 'Update transportasi', //judul halaman
                'transportasi' => $this->transportasi->get_single_transportasi($param), //get transportasi berdasarkan id
            ];

            $this->render('transportasi/transportasi_edit', $data);
        } else {


            $data = [
                'nama_kendaraan' => htmlspecialchars($this->input->post('nama_kendaraan', true)),
                'jenis_kendaraan' => htmlspecialchars($this->input->post('jenis_kendaraan', true)),
            ];

            $this->transportasi->update_transportasi_info($data, $param);

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">transportasi berhasil diperbaharui!</div>');
            redirect('transportasi');
        }
    }

    public function delete($e_id)
    {
        $id = decode($e_id); // decrypt

        $this->transportasi->delete_transportasi_info($id);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Transportasi berhasil dihapus!</div>');
        redirect('transportasi');
    }
}
