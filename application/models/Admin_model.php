<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin_model extends CI_Model
{
    public function save_new_user($data) // save data ke database tb_user
    {
        return $this->db->insert('tb_user', $data);
    }

    public function get_all_user() //ambil data dari tabel user
    {

        $this->db->select('*');
        $this->db->from('tb_user');
        $this->db->join('tb_user_role', 'tb_user.role_id=tb_user_role.id', 'INNER');
        $info = $this->db->get();
        return $info->result_array();
    }

    public function get_all_role() // ambil data dari tabel user role
    {

        $this->db->select('*');
        $this->db->from('tb_user_role');
        $info = $this->db->get();
        return $info->result_array();
    }

    public function get_user_by_email($email) // ambil data user berdasarkan email
    {
        $this->db->select('*');
        $this->db->join('tb_user_role TUR', 'TU.role_id= TUR.id', 'LEFT');
        $this->db->where('TU.email', $email);
        $query = $this->db->get('tb_user TU');
        return $query->row_array();
    }

    public function update_user_by_email($email, $data){
        $this->db->where('email', $email);
        return $this->db->update('tb_user', $data);
    }
}
