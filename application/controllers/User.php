<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('user_model', 'user');
	}

	public function index()
	{

		$data = [
			'title' => 'User',
			'data' => $this->user->getData()
		];

		$this->render('v_user_index', $data);
	}


	public function data($id = false)
	{
		// kondisi jika id tidak sama dengan false
		if ($id !== false) $id = decode($id);

		// start form validasi
		$this->form_validation->set_rules('nama', 'Nama', 'trim|required', [
			'required' => 'Nama tidak Boleh Kosong!'
		]);

		// kondisi, jika id false cek username
		if ($id === false) {
			$this->form_validation->set_rules('username', 'username', 'trim|required|is_unique[user.username]', [
				'is_unique' => 'Username sudah terdaftar!',
				'required' => 'Username tidak boleh kosong!',
			]);
		}
		if (($id === false) or $this->input->post('pass1')) {
			$this->form_validation->set_rules('pass1', 'Password', 'trim|required|min_length[3]|matches[pass2]', [
				'required' => 'Password tidak boleh kosong!',
				'min_length' => 'Password terlalu singkat!',
				'matches' => 'Password tidak cocok!'
			]);
			$this->form_validation->set_rules('pass2', 'Password', 'trim|required', [
				'required' => 'Retype Password tidak boleh kosong!',
			]);
		}

		// kondisi validasi
		if ($this->form_validation->run() == false) { // jika validasi gagal

			$error = validation_errors();

			$data = [
				'title' => 'Data user',
				'data' => $this->user->getData($id),
				'error' => !empty($error) ? $error : ''
			];

			$this->render('v_user_data', $data);

			// jika validasi benar
		} else {

			$data = [
				'nama' 		=>  $this->input->post('nama', true),
				'level' 	=>  $this->input->post('level', true),
			];

			$cek = '';
			if (!empty($_FILES['foto']['name'])) {
				$config['upload_path'] = './public/uploads/img/';
				$config['allowed_types'] = 'jpg|png|jpeg';
				$config['encrypt_name'] = TRUE;
				$this->upload->initialize($config);

				if (!$this->upload->do_upload('foto')) {
					$error = $this->upload->display_errors();
					$cek = $error;
				} else {

					if ($id) {
						$user = $this->user->getData($id);
						$src = 'public/uploads/img/';
						if ($user['foto'] != 'default.png') {
							if (file_exists(FCPATH . $src . $user['foto'])) {
								unlink($src . $user['foto']);
							}
						}
					}

					$post_image = $this->upload->data();
					$data['foto'] = $post_image['file_name'];
				}
			} else {
				if ($id === false) {
					$data['foto'] = 'default.png';
				}
			}

			if (!empty($cek)) {
				$this->session->set_flashdata('message', alert($cek, 'danger'));
				redirect('user');
			} else {
				if ($id) {
					$data['updated_at'] = current_timestamp();

					if ($this->input->post('pass1')) {
						$data['password'] = password_hash($this->input->post('pass1', true), PASSWORD_DEFAULT);
					}
				} else {
					$data['username'] = $this->input->post('username', true);
					$data['password'] = password_hash($this->input->post('pass1'), PASSWORD_DEFAULT);
					$data['created_at'] = current_timestamp();
				}

				$save = $this->user->saveData($id, $data);
				if ($save) {
					$this->session->set_flashdata('message', alert('Data berhasil disimpan!', 'success'));
				} else {
					$this->session->set_flashdata('message', alert('Data gagal disimpan!', 'danger'));
				}
				redirect('user', 'refresh');
			}
		}
	}

	public function hapus($id = false)
	{

		if ($id !== false) $id = decode($id);

		if ($id) {

			$data = $this->user->getData($id);
			$src = 'public/uploads/img/';
			if ($data['foto'] != 'default.png') {
				if (file_exists(FCPATH . $src . $data['foto'])) {
					unlink($src . $data['foto']);
				}
			}

			$delete = $this->user->deleteData($id);

			if ($delete) {
				$this->session->set_flashdata('message', alert('Data berhasil dihapus!', 'success'));
			} else {
				$this->session->set_flashdata('message', alert('Data gagal dihapus', 'danger'));
			}
		} else {
			$this->session->set_flashdata('message', alert('Maaf, data tidak ditemukan!', 'danger'));
		}
		redirect('user', 'refresh');
	}
}
