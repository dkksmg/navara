<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_m extends CI_Model {

	function __construct()
	{
		parent :: __construct();
	}

    function check_login($table, $field1, $field2)
    {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where($field1);
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() == 0) {
            return FALSE;
        } else {
            return $query->result();
        }
    }
    function check_login_users($table, $field1, $field2)
    {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->join('kendaraan','riwayat_pemakai.id_kendaraan=kendaraan.idk');
        $this->db->where($field1);
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() == 0) {
            return FALSE;
        } else {
            return $query->result();
        }
    }
 	
}
