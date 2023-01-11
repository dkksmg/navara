<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard_m extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }
    public function totalkendaraan()
    {
        $this->db->select('count(*) as jml ');
        $q = $this->db->get('kendaraan');
        return (int)$q->result_array()[0]['jml'];
    }
    public function totalkendaraan_spm()
    {
        $this->db->select('count(*) as jml ');
        $q = $this->db->where('kendaraan.jenis', 'Sepeda Motor')->get('kendaraan');
        return (int)$q->result_array()[0]['jml'];
    }
    public function totalkendaraan_abm()
    {
        $this->db->select('count(*) as jml ');
        $q = $this->db->where('kendaraan.jenis', 'Ambulance')->get('kendaraan');
        return (int)$q->result_array()[0]['jml'];
    }
    public function totalkendaraan_abmkl()
    {
        $this->db->select('count(*) as jml ');
        $q = $this->db->where('kendaraan.jenis', 'Ambulance Keliling')->get('kendaraan');
        return (int)$q->result_array()[0]['jml'];
    }
    public function totalkendaraan_abmhbt()
    {
        $this->db->select('count(*) as jml ');
        $q = $this->db->where('kendaraan.jenis', 'Ambulance Hebat')->get('kendaraan');
        return (int)$q->result_array()[0]['jml'];
    }
    public function totalkendaraan_abmsg()
    {
        $this->db->select('count(*) as jml ');
        $q = $this->db->where('kendaraan.jenis', 'Ambulance Siaga')->get('kendaraan');
        return (int)$q->result_array()[0]['jml'];
    }
    public function totalkendaraan_mbl()
    {
        $this->db->select('count(*) as jml ');
        $q = $this->db
            ->where('kendaraan.jenis !=', 'Ambulance')
            ->where('kendaraan.jenis !=', 'Ambulance Keliling')
            ->where('kendaraan.jenis !=', 'Ambulance Siaga')
            ->where('kendaraan.jenis !=', 'Ambulance Hebat')
            ->where('kendaraan.jenis !=', 'Sepeda Motor')->get('kendaraan');
        return (int)$q->result_array()[0]['jml'];
    }
    public function totaluseradmin()
    {
        $this->db->select('count(*) as jml ');
        $q = $this->db->where('users.role', 'Admin')->get('users');
        return (int)$q->result_array()[0]['jml'];
    }
    public function totaluserpemakai()
    {
        $this->db->select('count(*) as jml ');
        $q = $this->db->where('users.role', 'Pemakai')->get('users');
        return (int)$q->result_array()[0]['jml'];
    }
    public function totalkendaraan_pmkkend()
    {
        if ($this->session->userdata('role') == 'Superadmin') {
            $this->db->select('count(*) as jml ');
            $q = $this->db
                ->join('kendaraan', 'riwayat_pemakai.id_kendaraan = kendaraan.idk')
                ->where('riwayat_pemakai.status', 'aktif')
                ->get('riwayat_pemakai');
            return (int)$q->result_array()[0]['jml'];
        } else {
            $cek_wilayah = $this->session->userdata('wilayah');
            $this->db->select('count(*) as jml ');
            $q = $this->db
                ->join('kendaraan', 'riwayat_pemakai.id_kendaraan = kendaraan.idk')
                ->where('riwayat_pemakai.status', 'aktif')->where('riwayat_pemakai.lokasi_unit', $cek_wilayah)->get('riwayat_pemakai');
            return (int)$q->result_array()[0]['jml'];
        }
    }
}