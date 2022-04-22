<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_m extends CI_Model {

	function __construct()
	{
		parent :: __construct();
	}
    public function totalkendaraan()
    {
        $this->db->select('count(*) as jml ');
        $q = $this->db->get('kendaraan');
        return (int)$q->result_array()[0]['jml'];
    }    


 	
}
