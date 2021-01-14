<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pemasukan extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('pemasukan_model', 'pemasukan');
        is_logged_in();
    }

    public function index()
    {

        $search = (!empty($this->input->cookie('fnama_pemasukan')) ? $this->input->cookie('fnama_pemasukan') : '');
        $per_page = (!empty($this->input->cookie('fper_page')) ? $this->input->cookie('fper_page') : '10');

        // ------------------------------ form validasi -------------------
        $this->form_validation->set_rules('tanggal', 'Tanggal', 'trim|required', [
            'required' => 'Tanggal tidak Boleh Kosong!'
        ]);
        $this->form_validation->set_rules('jumlah', 'Jumlah', 'trim|required|numeric', [
            'required' => 'Jumlah tidak Boleh Kosong!',
            'numeric' => 'Jumlah harus berupa angka!',
        ]);
        $this->form_validation->set_rules('proyek', 'Proyek', 'trim|required', [
            'required' => 'Proyek tidak Boleh Kosong!'
        ]);
        $this->form_validation->set_rules('jenis_bayar', 'Jenis Bayar', 'trim|required', [
            'required' => 'Jenis Bayar tidak Boleh Kosong!'
        ]);
        if ($this->form_validation->run() == false) {

            $config["base_url"] = base_url('pemasukan/index');
            $jumlah_data = $this->db->join('tb_proyek', 'tb_pemasukan.proyek=tb_proyek.id', 'LEFT')->like('nama_proyek', $search, 'both')->get('tb_pemasukan')->num_rows();
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
                'title' => 'Pemasukan', //judul halaman
                'data' => $this->pemasukan->get_pemasukan_info($config['per_page'], $from, $search),
                'jumlah_data' => $jumlah_data,
                'proyek' => $this->db->get('tb_proyek')->result_array()
            ];

            $this->render('pemasukan/pemasukan_index', $data);
        } else {
            $cek = '';

            // simpan data ke database
            $data = [
                'proyek' => $this->input->post('proyek', true),
                'jumlah' => $this->input->post('jumlah', true),
                'tanggal' => $this->input->post('tanggal', true),
                'jenis_bayar' => $this->input->post('jenis_bayar', true),
            ];

            if ($this->input->post('jenis_bayar') == 'transfer') {

                if (!empty($_FILES['bukti']['name'])) { // jika user upload dokumen
                    $config['upload_path'] = './uploads/bukti/';
                    $config['allowed_types'] = 'jpg|png|pdf|csv|docx|doc';
                    $config['encrypt_name'] = TRUE;

                    $this->upload->initialize($config);

                    if (!$this->upload->do_upload('bukti')) {
                        $error = $this->upload->display_errors();
                        $cek = $error;
                    } else {
                        $post_image = $this->upload->data();
                        $data['bukti_bayar'] = $post_image['file_name'];
                    }
                } else {
                    $cek = 'Silahkan upload bukti transfer, format disarankan jpg, png, pdf, docx, doc';
                }
            }

            if (!empty($cek)) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">' . $cek . '</div>');
            } else {
                $insert = $this->pemasukan->save_pemasukan_info($data); //simpan data dengan memanggil fungsi simpan di model

                if ($insert) {
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"> Selamat!, pemasukan berhasil disimpan. </div>');
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> Maaf, data gagal disimpan! </div>');
                }
            }

            redirect('pemasukan', 'refresh');
        }
    }

    public function update($param)
    {
        $param = decode($param); // decrypt\

        // ------------------------------ form validasi -------------------
        $this->form_validation->set_rules('tanggal', 'Tanggal', 'trim|required', [
            'required' => 'Tanggal tidak Boleh Kosong!'
        ]);
        $this->form_validation->set_rules('jumlah', 'Jumlah', 'trim|required|numeric', [
            'required' => 'Jumlah tidak Boleh Kosong!',
            'numeric' => 'Jumlah harus berupa angka!',
        ]);
        $this->form_validation->set_rules('proyek', 'Proyek', 'trim|required', [
            'required' => 'Proyek tidak Boleh Kosong!'
        ]);
        $this->form_validation->set_rules('jenis_bayar', 'Jenis Bayar', 'trim|required', [
            'required' => 'Jenis Bayar tidak Boleh Kosong!'
        ]);

        // --------- end Validasi -----------

        if ($this->form_validation->run() == false) {

            $data = [
                'title' => 'Update pemasukan', //judul halaman
                'pemasukan' => $this->pemasukan->get_single_pemasukan($param), //get pemasukan berdasarkan id
                'proyek' => $this->db->get('tb_proyek')->result_array(), //get pemasukan berdasarkan id
            ];

            $this->render('pemasukan/pemasukan_edit', $data);
        } else {
            $cek = '';
            $pemasukan = $this->pemasukan->get_single_pemasukan($param); //get pemasukan berdasarkan id
            $bukti = $pemasukan['bukti_bayar'];

            // simpan data ke database
            $data = [
                'proyek' => $this->input->post('proyek', true),
                'jumlah' => $this->input->post('jumlah', true),
                'tanggal' => $this->input->post('tanggal', true),
                'jenis_bayar' => $this->input->post('jenis_bayar', true),
                'bukti_bayar' => $bukti
            ];

            if (!empty($_FILES['bukti']['name'])) { // jika user upload bukti
                $config['upload_path'] = './uploads/bukti/';
                $config['allowed_types'] = 'jpg|png|pdf|csv|docx|doc';
                $config['encrypt_name'] = TRUE;

                $this->upload->initialize($config);

                if (!$this->upload->do_upload('bukti')) {
                    $error = $this->upload->display_errors();
                    $cek = $error;
                    $bukti = '';
                } else {
                    $post_image = $this->upload->data();

                    $file = FCPATH . "/uploads/bukti/$bukti";
                    if (file_exists($file)) {
                        unlink('uploads/bukti/' . $bukti); // hapus bukti lama
                    }

                    $data['bukti_bayar'] = $post_image['file_name'];
                    $bukti = $post_image['file_name'];
                }
            }

            if ($this->input->post('jenis_bayar') == 'cash') {
                $data['bukti_bayar'] = NULL;
            }



            if (!empty($cek)) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">' . $cek . '</div>');
            } else {
                $update = $this->pemasukan->update_pemasukan_info($data, $param); //simpan data dengan memanggil fungsi simpan di model

                if ($update) {
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"> Selamat!, pemasukan berhasil diupdate. </div>');
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> Maaf, data gagal diupdate! </div>');
                }
            }

            redirect('pemasukan', 'refresh');
        }
    }

    public function delete($id)
    {
        $id = decode($id); // decrypt
        $pemasukan = $this->pemasukan->get_single_pemasukan($id); //get pemasukan berdasarkan id
        $file = FCPATH . "/uploads/bukti/$pemasukan[bukti]";
        if (file_exists($file)) {
            unlink('uploads/bukti/' . $pemasukan['bukti']); // hapus dokumen lama
        }

        $this->pemasukan->delete_pemasukan_info($id);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">pemasukan berhasil dihapus!</div>');
        redirect('pemasukan');
    }
}
