<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Proyek extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('proyek_model', 'proyek');
        is_logged_in();
    }

    public function index()
    {

        $search = (!empty($this->input->cookie('fnama_proyek')) ? $this->input->cookie('fnama_proyek') : '');
        $per_page = (!empty($this->input->cookie('fper_page')) ? $this->input->cookie('fper_page') : '10');

        // ------------------------------ form validasi -------------------
        $this->form_validation->set_rules('nama_proyek', 'Nama proyek', 'trim|required', [
            'required' => 'Nama proyek tidak Boleh Kosong!'
        ]);
        $this->form_validation->set_rules('alamat_proyek', 'Alamat Proyek', 'trim|required', [
            'required' => 'Alamat Proyek tidak Boleh Kosong!'
        ]);
        $this->form_validation->set_rules('anggaran_proyek', 'Anggaran Proyek', 'trim|required|numeric', [
            'required' => 'Anggaran Proyek tidak Boleh Kosong!',
            'numeric' => 'Anggaran Proyek harus berupa angka!',
        ]);
        $this->form_validation->set_rules('tanggal_mulai', 'Tanggal Mulai', 'trim|required', [
            'required' => 'Tanggal Mulai tidak Boleh Kosong!'
        ]);
        $this->form_validation->set_rules('tanggal_selesai', 'Tanggal Selesai', 'trim|required', [
            'required' => 'Tanggal Selesai tidak Boleh Kosong!'
        ]);
        $this->form_validation->set_rules('pemilik', 'Pemilik', 'trim|required', [
            'required' => 'Pemilik tidak Boleh Kosong!'
        ]);

        if ($this->form_validation->run() == false) {

            $config["base_url"] = base_url('proyek/index');
            $jumlah_data = $this->db->like('nama_proyek', $search, 'both')->get('tb_proyek')->num_rows();
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
                'title' => 'Proyek', //judul halaman
                'data' => $this->proyek->get_proyek_info($config['per_page'], $from, $search),
                'jumlah_data' => $jumlah_data,
            ];

            $this->render('proyek/proyek_index', $data);
        } else {
            $cek = '';

            if (!empty($_FILES['dokumen']['name'])) { // jika user upload dokumen
                $config['upload_path'] = './uploads/dokumen/';
                $config['allowed_types'] = 'jpg|png|pdf|csv|docx|doc';
                $config['encrypt_name'] = TRUE;

                $this->upload->initialize($config);

                if (!$this->upload->do_upload('dokumen')) {
                    $error = $this->upload->display_errors();
                    $cek = $error;
                } else {
                    $post_image = $this->upload->data();
                }

                if (!empty($cek)) {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">' . $cek . '</div>');
                } else {

                    // simpan data ke database
                    $data = [
                        'nama_proyek' => $this->input->post('nama_proyek', true),
                        'alamat_proyek' => $this->input->post('alamat_proyek', true),
                        'anggaran_proyek' => $this->input->post('anggaran_proyek', true),
                        'tanggal_mulai' => $this->input->post('tanggal_mulai', true),
                        'tanggal_selesai' => $this->input->post('tanggal_selesai', true),
                        'pemilik' => $this->input->post('pemilik', true),
                        'dokumen' => $post_image['file_name'],
                        'date_created' => current_timestamp()
                    ];

                    $insert = $this->proyek->save_proyek_info($data); //simpan data dengan memanggil fungsi simpan di model

                    if ($insert) {
                        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"> Selamat!, proyek berhasil disimpan. </div>');
                    } else {
                        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> Maaf, data gagal disimpan! </div>');
                    }
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Silahkan upload dukumen!</div>');
            }
            redirect('proyek', 'refresh');
        }
    }

    public function update($param)
    {
        $param = decode($param); // decrypt\

        // ------------------------------ form validasi -------------------
        $this->form_validation->set_rules('nama_proyek', 'Nama proyek', 'trim|required', [
            'required' => 'Nama proyek tidak Boleh Kosong!'
        ]);
        $this->form_validation->set_rules('alamat_proyek', 'Alamat Proyek', 'trim|required', [
            'required' => 'Alamat Proyek tidak Boleh Kosong!'
        ]);
        $this->form_validation->set_rules('anggaran_proyek', 'Anggaran Proyek', 'trim|required|numeric', [
            'required' => 'Anggaran Proyek tidak Boleh Kosong!',
            'numeric' => 'Anggaran Proyek harus berupa angka!',
        ]);
        $this->form_validation->set_rules('tanggal_mulai', 'Tanggal Mulai', 'trim|required', [
            'required' => 'Tanggal Mulai tidak Boleh Kosong!'
        ]);
        $this->form_validation->set_rules('tanggal_selesai', 'Tanggal Selesai', 'trim|required', [
            'required' => 'Tanggal Selesai tidak Boleh Kosong!'
        ]);
        $this->form_validation->set_rules('pemilik', 'Pemilik', 'trim|required', [
            'required' => 'Pemilik tidak Boleh Kosong!'
        ]);

        // --------- end Validasi -----------

        if ($this->form_validation->run() == false) {

            $data = [
                'title' => 'Update proyek', //judul halaman
                'proyek' => $this->proyek->get_single_proyek($param), //get proyek berdasarkan id
            ];

            $this->render('proyek/proyek_edit', $data);
        } else {
            $cek = '';
            $data = [];

            // simpan data ke database
            $data = [
                'nama_proyek' => $this->input->post('nama_proyek', true),
                'alamat_proyek' => $this->input->post('alamat_proyek', true),
                'anggaran_proyek' => $this->input->post('anggaran_proyek', true),
                'tanggal_mulai' => $this->input->post('tanggal_mulai', true),
                'tanggal_selesai' => $this->input->post('tanggal_selesai', true),
                'pemilik' => $this->input->post('pemilik', true),
                'date_created' => current_timestamp()
            ];

            if (!empty($_FILES['dokumen']['name'])) { // jika user upload dokumen
                $config['upload_path'] = './uploads/dokumen/';
                $config['allowed_types'] = 'jpg|png|pdf|csv|docx|doc';
                $config['encrypt_name'] = TRUE;

                $this->upload->initialize($config);

                if (!$this->upload->do_upload('dokumen')) {
                    $error = $this->upload->display_errors();
                    $cek = $error;
                } else {
                    $post_image = $this->upload->data();
                    $proyek = $this->proyek->get_single_proyek($param); //get proyek berdasarkan id
                    $file = FCPATH . "/uploads/dokumen/$proyek[dokumen]";
                    if (file_exists($file)) {
                        unlink('uploads/dokumen/' . $proyek['dokumen']); // hapus dokumen lama
                    }

                    $data['dokumen'] = $post_image['file_name'];
                }
            }

            if (!empty($cek)) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">' . $cek . '</div>');
            } else {


                $update = $this->proyek->update_proyek_info($data, $param); //simpan data dengan memanggil fungsi simpan di model

                if ($update) {
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"> Selamat!, proyek berhasil diupdate. </div>');
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> Maaf, data gagal diupdate! </div>');
                }
            }

            redirect('proyek', 'refresh');
        }
    }

    public function delete($id)
    {
        $id = decode($id); // decrypt
        $proyek = $this->proyek->get_single_proyek($id); //get proyek berdasarkan id
        $file = FCPATH . "/uploads/dokumen/$proyek[dokumen]";
        if (file_exists($file)) {
            unlink('uploads/dokumen/' . $proyek['dokumen']); // hapus dokumen lama
        }

        $this->proyek->delete_proyek_info($id);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">proyek berhasil dihapus!</div>');
        redirect('proyek');
    }
}
