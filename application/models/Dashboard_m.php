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
}