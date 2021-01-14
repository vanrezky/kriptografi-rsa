<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Proyek_model extends CI_Model
{
    function get_proyek_info($number, $offset, $search = "")
    {
        $this->db->like('nama_proyek', $search, 'both');
        $this->db->order_by('id', 'DESC');
        return $this->db->get('tb_proyek', $number, $offset)->result_array();
    }

    public function save_proyek_info($data) // save data ke database tb_proyek
    {
        return $this->db->insert('tb_proyek', $data);
    }

    public function save_transaksi_info($data) // save data ke database tb_transaksi
    {
        return $this->db->insert('tb_transaksi', $data);
    }

    public function get_single_proyek($id) // ambil data proyek berdasarkan id
    {

        $this->db->select('*');
        $this->db->from('tb_proyek');
        // $this->db->join('tb_satuan', 'tb_proyek.satuan_id=tb_satuan.satuan_id', 'inner');
        $this->db->where('tb_proyek.id', $id);
        $info = $this->db->get();
        return $info->row_array();
    }

    public function update_proyek_info($data, $param) // update proyek
    {
        $this->db->where('id', $param);
        return $this->db->update('tb_proyek', $data);
    }

    public function delete_proyek_info($id) // delate proyek
    {
        $this->db->where('id', $id);
        return $this->db->delete('tb_proyek');
    }
}
