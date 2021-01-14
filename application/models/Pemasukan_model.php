<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Pemasukan_model extends CI_Model
{
    function get_pemasukan_info($number, $offset, $search = "")
    {
        $this->db->select('tb_pemasukan.*, tb_proyek.nama_proyek');
        $this->db->join('tb_proyek', 'tb_pemasukan.proyek=tb_proyek.id', 'LEFT');
        $this->db->like('nama_proyek', $search, 'both');
        $this->db->order_by('tb_pemasukan.id', 'DESC');
        return $this->db->get('tb_pemasukan', $number, $offset)->result_array();
    }

    public function save_pemasukan_info($data) // save data ke database tb_pemasukan
    {
        return $this->db->insert('tb_pemasukan', $data);
    }

    public function save_transaksi_info($data) // save data ke database tb_transaksi
    {
        return $this->db->insert('tb_transaksi', $data);
    }

    public function get_single_pemasukan($id) // ambil data pemasukan berdasarkan id
    {

        $this->db->select('*');
        $this->db->from('tb_pemasukan');
        $this->db->where('tb_pemasukan.id', $id);
        $info = $this->db->get();
        return $info->row_array();
    }

    public function update_pemasukan_info($data, $param) // update pemasukan
    {
        $this->db->where('id', $param);
        return $this->db->update('tb_pemasukan', $data);
    }

    public function delete_pemasukan_info($id) // delate pemasukan
    {
        $this->db->where('id', $id);
        return $this->db->delete('tb_pemasukan');
    }
}
