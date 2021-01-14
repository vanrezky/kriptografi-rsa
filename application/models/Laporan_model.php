<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Laporan_model extends CI_Model
{
    public function proyek()
    {
        return $this->db->get('tb_proyek')->result_array();
    }

    public function get_pemasukan($proyek, $bulan, $tahun)
    {
        $this->db->select('*');
        $this->db->where('proyek', $proyek);
        $this->db->where('MONTH(tanggal)', $bulan);
        $this->db->where('YEAR(tanggal)', $tahun);
        return $this->db->get('tb_pemasukan TP')->result_array();
    }

    public function get_pengeluaran($proyek, $bulan = "", $tahun = "")
    {
        $this->db->select('*');
        $this->db->where('proyek', $proyek);
        if (!empty($bulan)) $this->db->where('MONTH(date_created)', $bulan);
        if (!empty($tahun)) $this->db->where('YEAR(date_created)', $tahun);
        return $this->db->get('tb_transaksi TT')->result_array();
    }

    public function get_all_transaksi($proyek = "") //ambil data
    {
        $data_array = [];

        $this->db->select('TT.*, TST.id_item, TST.satuan, TST.jumlah, TST.harga, TS.satuan, TSP.nama_suplier, TP.nama_proyek');
        $this->db->join('tb_sub_transaksi TST', 'TT.no_trans = TST.no_trans', 'INNER');
        $this->db->join('tb_satuan TS', 'TST.satuan = TS.satuan_id', 'LEFT');
        $this->db->join('tb_suplier TSP', 'TSP.id = TT.suplier', 'LEFT');
        $this->db->join('tb_proyek TP', 'TP.id = TT.proyek', 'LEFT');
        $this->db->where('proyek', $proyek);
        $this->db->order_by('TT.no_trans', 'ASC');
        $this->db->order_by('TST.id', 'ASC');
        $info = $this->db->get('tb_transaksi TT')->result_array();

        foreach ($info as $key => $value) {

            $jenis_transaksi = strtolower($value['jenis_transaksi']);
            $id_item = $value['id_item'];
            $nama_item = '';

            if ($jenis_transaksi == 'barang') {
                $barang = $this->db->get_where('tb_barang', ['id' => $id_item])->row_array();
                $nama_item = $barang['nama_barang'];
            } else if ($jenis_transaksi == 'alat') {
                $alat = $this->db->get_where('tb_alat', ['id' => $id_item])->row_array();
                $nama_item = $alat['nama_alat'];
            } else if ($jenis_transaksi == 'transportasi') {
                $transportasi = $this->db->get_where('tb_transportasi', ['id' => $id_item])->row_array();
                $nama_item = $transportasi['nama_kendaraan'];
            }

            $data_array[] = [
                'no_trans'          => $value['no_trans'],
                'total'             => $value['total'],
                'suplier'           => $value['nama_suplier'],
                'jenis_transaksi'   => $jenis_transaksi,
                'proyek'            => $value['nama_proyek'],
                'jenis_pembayaran'  => $value['jenis_pembayaran'],
                'date_created'      => $value['date_created'],
                'nama_item'           => $nama_item,
                'satuan'            => $value['satuan'],
                'jumlah'            => $value['jumlah'],
                'harga'             => $value['harga'],
            ];
        }
        return $data_array;
    }


    public function get_info($proyek, $bulan, $tahun)
    {
        $this->db->select("(
            SELECT SUM(TP.`jumlah`)
            FROM tb_pemasukan TP
            WHERE TP.`proyek` = {$proyek} 
            AND MONTH(TP.`tanggal`) = {$bulan}
            AND YEAR(TP.`tanggal`) = {$tahun}
        )pemasukan,(
            SELECT SUM(TT.`total`)
            FROM tb_transaksi TT
            WHERE TT.`proyek` = {$proyek} 
            AND MONTH(TT.`date_created`) = {$bulan}
            AND YEAR(TT.`date_created`) = {$tahun}
        )pengeluaran,(
            SELECT (TBP.`anggaran_proyek`)
            FROM tb_proyek TBP
            WHERE TBP.`id` = {$proyek} 
        )anggaran_proyek");
        return $this->db->get()->row_array();
    }

    public function get_info_all($proyek)
    {
        $this->db->select("(
            SELECT SUM(TP.`jumlah`)
            FROM tb_pemasukan TP
            WHERE TP.`proyek` = {$proyek} 
        )pemasukan,(
            SELECT SUM(TT.`total`)
            FROM tb_transaksi TT
            WHERE TT.`proyek` = {$proyek} 
        )pengeluaran,(
            SELECT (TBP.`anggaran_proyek`)
            FROM tb_proyek TBP
            WHERE TBP.`id` = {$proyek} 
        )anggaran_proyek");
        return $this->db->get()->row_array();
    }
}
