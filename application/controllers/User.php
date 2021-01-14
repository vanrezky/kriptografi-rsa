<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('admin_model', 'admin');
	}


	public function index()
	{
		is_logged_in();
		
		$cek = '';
		// ------------------------------ form validasi -------------------
		$this->form_validation->set_rules('role_id', 'Role', 'trim|required', [
			'required' => 'Role tidak Boleh Kosong!'
		]);

		$this->form_validation->set_rules('name', 'Name', 'trim|required', [
			'required' => 'Nama tidak Boleh Kosong!'
		]);

		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[tb_user.email]', [
			'is_unique' => 'Email sudah terdaftar!',
			'required' => 'Email tidak boleh kosong!',
			'valid_email' => 'Email tidak valid!'
		]);

		$this->form_validation->set_rules('password1', 'Password', 'trim|required|min_length[3]|matches[password2]', [
			'required' => 'Password tidak boleh kosong!',
			'min_length' => 'Password terlalu singkat!',
			'matches' => 'Password tidak cocok!'
		]);
		$this->form_validation->set_rules('password2', 'Password', 'trim|required', [
			'required' => 'Retype Password tidak boleh kosong!',
		]);


		// --------- end Validasi -----------

		if ($this->form_validation->run() == false) { // jika validasi gagal maka kembali ke halaman user

			$data['title'] = 'User'; // title halaman
			$data['allRole'] = $this->admin->get_all_role(); //ambil semua role
			$data['allUser'] = $this->admin->get_all_user(); //ambil semua user

			$this->render('user/user_index', $data);
		} else {   // jika validasi benar, maka akan input array ke database.

			if (!empty($_FILES['image']['name'])) {
				$config['upload_path'] = './uploads/images/';
				$config['allowed_types'] = 'jpg|png';
				$config['encrypt_name'] = TRUE;

				$this->upload->initialize($config);

				if (!$this->upload->do_upload('image')) {
					$error = $this->upload->display_errors();
					$cek = $error;
				} else {
					$post_image = $this->upload->data();
				}

				if (!empty($cek)) {
					$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">' . $cek . '</div>');
					redirect('user');
				} else {
					$data = [
						'name' => htmlspecialchars($this->input->post('name', true)),
						'email' => htmlspecialchars($this->input->post('email', true)),
						'image' => $post_image['file_name'],
						'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
						'role_id' => htmlspecialchars($this->input->post('role_id', true)),
						'is_active' => '1',
						'date_created' => time()
					];
					$this->admin->save_new_user($data);
					$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"> Selamat!, Akun anda berhasil didaftarkan. </div>');
					redirect('user');
				}
			} else {
				$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> Silahkan upload foto format png/jpg. </div>');
				redirect('user');
			}
		}
	}

	public function profile($email = "")
	{
		// dekripsi terlebih dahulu email
		$email = decode($email);
		$data = $this->admin->get_user_by_email($email);
		$passlama = $this->input->post('passlama', true);
		$cek = true;

		$this->form_validation->set_rules('name', 'Name', 'trim|required', [
			'required' => 'Nama tidak Boleh Kosong!'
		]);

		// kondisi jika password lama tidak kosong
		if (!empty($passlama)) {

			$this->form_validation->set_rules('passlama', 'Password Lama', 'trim|required', [
				'required' => 'Password Lama tidak Boleh Kosong!'
			]);
			$this->form_validation->set_rules('passbaru1', 'Password Baru', 'trim|required|min_length[3]|matches[passbaru2]', [
				'required' => 'Password Baru tidak boleh kosong!',
				'min_length' => 'Password Baru terlalu singkat!',
				'matches' => 'Password Baru tidak cocok!'
			]);
			$this->form_validation->set_rules('passbaru2', 'Konfirmasi Password Baru', 'trim|required', [
				'required' => 'Konfirmasi Password Baru tidak boleh kosong!',
			]);
		}

		if ($this->form_validation->run() == false) { // jika validasi gagal maka kembali ke halaman user

			$D = [
				'title' => 'Profile',
				'data' => $data
			];

			$this->render('user/user_profile', $D);
		} else {
			$insert = array();

			$insert['name'] = $this->input->post('name', true);

			if (!empty($passlama)) { // ==> kondisi jika password lama tidak kosong
				if (password_verify($passlama, $data['password'])) {
					$insert['password'] = $this->input->post('passbaru1');
				} else {
					$cek = false;
					$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Password lama salah!</div>');
				}
			}

			if ($cek === true) {

				$update = $this->admin->update_user_by_email($email, $insert);

				if ($update) {
					$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data berhasil diperbarui!</div>');
				} else {
					$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Data gagal diperbarui!</div>');
				}
			}

			redirect('user/profile/' . encode($email), 'refresh');
		}
	}
}
