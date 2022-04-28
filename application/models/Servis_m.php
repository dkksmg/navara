<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Servis_m extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    public function data_riwayatservisbulantahun($idk = null, $bulan_pilihan = null, $tahun_pilihan = null)
    {
        $this->db->where('id_kendaraan', $idk);
        $this->db->where('MONTH(tgl_servis)', $bulan_pilihan);
        $this->db->where('YEAR(tgl_servis)', $tahun_pilihan);
        $query = $this->db->order_by('tgl_servis', 'DESC')->get('riwayat_servis');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil[] = $row;
            }
            return $hasil;
        }
    }
    public function kendaraanByid($id = null)
    {
        $this->db->where('idk', $id);
        $query = $this->db->get('kendaraan');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil = $row;
            }
            return $hasil;
        }
    }
}