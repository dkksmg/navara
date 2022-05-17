<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_m extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    public function pagu_kendaraan($id = null)
    {
        $query = $this->db->where('id_kend', $id)->get('pagu_service');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil[] = $row;
            }
            return $hasil;
        }
    }
    public function pagu_service_kendaraan($id = null)
    {
        $query = $this->db->query('SELECT SUM(total_biaya) as jumlah_total_servis FROM `riwayat_servis` WHERE id_kendaraan = ' . $id . '')->row_array();
        return $query;
    }
    public function pagu_bbm_kendaraan($id = null)
    {
        $query = $this->db->query('SELECT SUM(total_bbm) as jumlah_total_bbm FROM `riwayat_bbm` WHERE id_kendaraan = ' . $id . '')->row_array();
        return $query;
    }
    public function pagu_pajak_kendaraan($id = null)
    {
        $query = $this->db->query('SELECT SUM(total_pajak) as jumlah_total_pajak FROM `riwayat_pajak` WHERE id_kendaraan = ' . $id . '')->row_array();
        return $query;
    }
    public function datapagu_kendaraanbyid($id)
    {
        $query = $this->db
            ->join('kendaraan', 'pagu_service.id_kend = kendaraan.idk')
            ->get_where('pagu_service', ['id_ps' => $id])
            ->row_array();
        return $query;
    }
    public function user()
    {
        $this->db->where('role !=', 'superadmin');
        $query = $this->db->get('users');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil[] = $row;
            }
            return $hasil;
        }
    }
    public function userbyid($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('users')->row_array();
        return $query;
    }


    public function tambahpagu($id = null, $jenis = null, $pagu = null)
    {

        $data['id_kend']    = $id;
        $data['tahun']      = $this->input->post('tahun');
        $data['pagu_awal']  = $pagu;
        $data['jenis_pagu']  = $jenis;
        $q = $this->db->insert('pagu_service', $data);
        return $q;
    }
    public function updatepagu($id = null)
    {
        $data['pagu_awal']  = $this->input->post('pagu');
        $data['jenis_pagu']  = $this->input->post('jenis');
        $q = $this->db->where('id_ps', $id)->update('pagu_service', $data);
        return $q;
    }
    public function cek_tahun_pagu($id = null, $tahun = null)
    {
        $this->db->where('id_kend', $id);
        $this->db->where('tahun', $tahun);
        $query = $this->db->get('pagu_service');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil = $row;
            }
            return $hasil;
        }
    }
    public function tambahuser()
    {

        $data['username']    = $this->input->post('username');
        $data['password']      = password_hash($this->input->post('password'), PASSWORD_BCRYPT);
        $data['name']  = $this->input->post('nama_user');
        $data['wilayah']  = $this->input->post('lokasi_kerja');
        $data['role']  = $this->input->post('role_user');
        $data['status']  = $this->input->post('status_user');
        $q = $this->db->insert('users', $data);
        return $q;
    }
    public function edituser($id_user = null)
    {
        if ($this->input->post('password') == "") {
            $data['username']    = $this->input->post('username');
            $data['name']  = $this->input->post('nama_user');
            $data['wilayah']  = $this->input->post('lokasi_kerja');
            $data['role']  = $this->input->post('role_user');
            $data['status']  = $this->input->post('status_user');
            $q = $this->db->where('id', $id_user)->update('users', $data);
            return $q;
        } else {
            $data['username']    = $this->input->post('username');
            $data['password']      = password_hash($this->input->post('password'), PASSWORD_BCRYPT);
            $data['name']  = $this->input->post('nama_user');
            $data['wilayah']  = $this->input->post('lokasi_kerja');
            $data['role']  = $this->input->post('role_user');
            $data['status']  = $this->input->post('status_user');
            $q = $this->db->where('id', $id_user)->update('users', $data);
            return $q;
        }
    }
    public function aktifkanuser($id = null)
    {
        $data['status'] = "Aktif";
        $this->db->Where('id', $id);
        $q = $this->db->update('users', $data);
        return $q;
    }
    public function nonaktifkanuser($id = null)
    {
        $data['status'] = "Tidak Aktif";
        $this->db->Where('id', $id);
        $q = $this->db->update('users', $data);
        return $q;
    }
    public function data_lokasiunit()
    {
        $query = $this->db->get('ref_lokasi_unit');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil[] = $row;
            }
            return $hasil;
        }
    }
}