<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_m extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    public function pagu_kendaraan()
    {
        $this->db->join(' ( SELECT id_kendaraan, sum(total_biaya) as tb FROM riwayat_servis group by id_kendaraan ) rs ', 'rs.id_kendaraan=pagu_service.id_kend');
        $query = $this->db->get('pagu_service');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil[] = $row;
            }
            return $hasil;
        }
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