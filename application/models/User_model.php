<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class User_model extends CI_Model
{
    protected $table = 'user';

    // ambil data
    public function getData($id = false)
    {
        if ($id !== false) {
            return $this->db->get_where($this->table, ['id' => $id])->row_array();
        }
        $this->db->order_by('id', 'DESC');
        return $this->db->get($this->table)->result_array();
    }

    //simpan atau update data 
    public function saveData($id = false, $data = [])
    {
        if ($id === false) {
            return $this->db->insert($this->table, $data);
        }

        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }

    public function deleteData($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete($this->table);
    }
}
