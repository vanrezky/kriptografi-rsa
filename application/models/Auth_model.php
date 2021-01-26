<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Auth_model extends CI_Model
{

    public function get_user_login()
    {
        $email = (decode($this->session->userdata('email')));

        $this->db->select('*');
        $this->db->from('tb_user');
        $this->db->join('tb_user_role', 'tb_user.role_id=tb_user_role.id', 'left');
        $this->db->where('email', $email);
        $info = $this->db->get();
        return $info->row_array();
    }

    public function getLoginData($data)

    {
        $username = $data['username']; // dari form input username
        $password = $data['password']; //dari form input password

        $user = $this->db->get_where('user', ['username' => $username])->row_array();
        //jika user ada
        if (!empty($user)) {
            //jika user aktif
            // cek password
            if (password_verify($password, $user['password'])) {
                $data = [
                    'username' => (encode($user['username'])),
                    'level' => strtoupper($user['level'])
                ];
                $this->session->set_userdata($data);
                redirect('dashboard');
            } else {
                $this->session->set_flashdata('pesan_auth', '<div class="alert alert-danger" role="alert">Password Salah!</div>');
                redirect('auth');
            }
        } else {
            $this->session->set_flashdata('pesan_auth', '<div class="alert alert-danger" role="alert">Data tidak ditemukan di server kami! </div>');
            redirect('auth');
        }
    }

    public function getChartData($bulan)
    {
        // $this->db->group_by('MONTH(created_at)');
        $this->db->where("");
        $this->db->order_by('created_at', 'ASC');
        return $this->db->count_all_results('riwayat_pasien');
    }

    public function getSekilas()
    {
        $this->db->select('(
					SELECT COUNT(riwayat_pasien.`id`)
                    FROM riwayat_pasien
				)riwayat, (
					SELECT COUNT(pasien.`id`)
                    FROM pasien
				)pasien,(
					SELECT COUNT(dokter.`id`)
                    FROM dokter
				)dokter,(
					SELECT COUNT(perawat_bidan.`id`)
                    FROM perawat_bidan
				)perawat_bidan');
        return $this->db->get()->row_array();
    }
}
