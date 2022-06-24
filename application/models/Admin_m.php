<?php

use LDAP\Result;

defined('BASEPATH') or exit('No direct script access allowed');

class Admin_m extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    // public function pagu_kendaraan($id = null)
    // {
    //     $query = $this->db->where('id_kend', $id)->get('pagu_service');
    //     if ($query->num_rows() > 0) {
    //         foreach ($query->result_array() as $row) {
    //             $hasil[] = $row;
    //         }
    //         return $hasil;
    //     }
    //     $this->db->join(' ( SELECT id_kendaraan, sum(total_biaya) as tb FROM riwayat_servis group by id_kendaraan ) rs ', 'rs.id_kendaraan=pagu_service.id_kend');
    //     $query = $this->db->get('pagu_service');
    //     if ($query->num_rows() > 0) {
    //         foreach ($query->result_array() as $row) {
    //             $hasil[] = $row;
    //         }
    //         return $hasil;
    //     }
    // }
    public function pagu_kendaraan_pemeliharaan()
    {
        $query = $this->db->query('SELECT * FROM `pagu_service` JOIN ( SELECT id_kendaraan, sum(total_biaya) as total_biaya_servis FROM riwayat_servis group by id_kendaraan ) rs ON `rs`.`id_kendaraan`=`pagu_service`.`id_kend` WHERE jenis_pagu = "Pemeliharaan"')->result();
        return $query;
    }
    public function pagu_kendaraan_bbm()
    {
        $query = $this->db->query('SELECT * FROM `pagu_service` JOIN ( SELECT id_kendaraan, sum(total_bbm) as total_biaya_bbm FROM riwayat_bbm group by id_kendaraan ) rs ON `rs`.`id_kendaraan`=`pagu_service`.`id_kend` WHERE jenis_pagu = "BBM"')->result();
        return $query;
    }
    public function pagu_kendaraan_pajak()
    {
        $query = $this->db->query('SELECT * FROM `pagu_service` JOIN ( SELECT id_kendaraan, sum(total_pajak) as total_biaya_pajak FROM riwayat_pajak group by id_kendaraan ) rs ON `rs`.`id_kendaraan`=`pagu_service`.`id_kend` WHERE jenis_pagu = "Pajak Kendaraan"')->result();
        return $query;
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
    public function pagu_kendaraan($id = null)
    {
        $this->db->where('id_kend', $id);
        $query = $this->db->get('pagu_service');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $hasil[] = $row;
            }
            return $hasil;
        }
    }
    public function total_servis_kend($id = null)
    {
        $query = $this->db
            ->where('id_kendaraan', $id)
            ->where('YEAR(tgl_servis)', '2022')
            ->group_by('id_kendaraan')
            ->select('id_kendaraan, sum(total_biaya) as total_biaya_servis')
            ->get('riwayat_servis')
            ->row_array();
        return $query;
    }
    public function total_pajak_kend($id = null)
    {
        $query = $this->db
            ->where('id_kendaraan', $id)
            ->group_by('id_kendaraan')
            ->select('id_kendaraan, sum(total_pajak) as total_biaya_pajak')
            ->get('riwayat_pajak')
            ->row_array();
        return $query;
    }
    public function total_bbm_kend($id = null)
    {
        $query = $this->db
            ->where('id_kendaraan', $id)
            ->group_by('id_kendaraan')
            ->select('id_kendaraan, sum(total_bbm) as total_biaya_bbm')
            ->get('riwayat_bbm')
            ->row_array();
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
    public function cek_datapagu($id = null, $tahun = null)
    {
        $query = $this->db->query("SELECT * FROM `pagu_service` 
        LEFT JOIN (SELECT id_kendaraan, sum(if(YEAR(riwayat_pajak.tgl_pencatatan)='$tahun', riwayat_pajak.total_pajak,0)) as total_biaya_pajak FROM riwayat_pajak group by id_kendaraan ) rp ON `rp`.`id_kendaraan`=`pagu_service`.`id_kend` 
        LEFT JOIN (SELECT id_kendaraan, sum(if(YEAR(riwayat_servis.tgl_servis)='$tahun', riwayat_servis.total_biaya,0)) as total_biaya_servis FROM riwayat_servis group by id_kendaraan ) rs ON `rs`.`id_kendaraan`=`pagu_service`.`id_kend` 
        LEFT JOIN (SELECT id_kendaraan, sum(if(YEAR(riwayat_bbm.tgl_pencatatan)='$tahun', riwayat_bbm.total_bbm,0)) as total_biaya_bbm FROM riwayat_bbm group by id_kendaraan ) rb ON `rb`.`id_kendaraan`=`pagu_service`.`id_kend` 
        WHERE pagu_service.id_kend='$id' AND pagu_service.tahun='$tahun'")->result_array();
        return $query;
    }
    public function user()
    {
        $this->db
            ->order_by('users.role', 'DESC')
            ->order_by('users.wilayah', 'DESC')
            ->order_by('users.name', 'ASC')
            ->where('role !=', 'superadmin');
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


    public function tambahpagu_old($id = null, $jenis = null, $pagu = null)
    {

        $data['id_kend']    = $id;
        $data['tahun']      = $this->input->post('tahun');
        $data['pagu_awal']  = $pagu;
        $data['jenis_pagu']  = $jenis;
        $q = $this->db->insert('pagu_service', $data);
        return $q;
    }
    public function tambahpagu($id = null)
    {

        $data['id_kend']    = $id;
        $data['tahun']      = $this->input->post('tahun');
        $data['pagu_awal']  = $this->input->post('pagu');
        $q = $this->db->insert('pagu_service', $data);
        return $q;
    }
    public function updatepagu($id = null)
    {
        $data['pagu_awal']  = $this->input->post('pagu');
        // $data['jenis_pagu']  = $this->input->post('jenis');
        $q = $this->db->where('id_ps', $id)->update('pagu_service', $data);
        return $q;
    }
    public function hapuspagu($id = null)
    {
        $this->db->where('id_ps', $id);
        $q = $this->db->delete('pagu_service');
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
        $data['nip_user']  = $this->input->post('nip_user');
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
            $data['nip_user']  = $this->input->post('nip_user');
            $data['wilayah']  = $this->input->post('lokasi_kerja');
            $data['role']  = $this->input->post('role_user');
            $data['status']  = $this->input->post('status_user');
            $q = $this->db->where('id', $id_user)->update('users', $data);
            return $q;
        } else {
            $data['username']    = $this->input->post('username');
            $data['password']      = password_hash($this->input->post('password'), PASSWORD_BCRYPT);
            $data['nip_user']  = $this->input->post('nip_user');
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