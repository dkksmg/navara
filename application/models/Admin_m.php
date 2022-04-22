<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_m extends CI_Model {

	function __construct()
	{
		parent :: __construct();
	}

    public function pagu_kendaraan()
    {   
        $this->db->join(' ( SELECT id_kendaraan, sum(total_biaya) as tb FROM riwayat_servis group by id_kendaraan ) rs ','rs.id_kendaraan=pagu_service.id_kend');
        $query = $this->db->get('pagu_service');
        if ($query->num_rows()>0)   {
            foreach ($query->result_array() as $row)
            { $hasil[]=$row ; }
            return $hasil;
        }
    }
    public function user()
    {   
        $this->db->where('role !=','superadmin');
        $query = $this->db->get('users');
        if ($query->num_rows()>0)   {
            foreach ($query->result_array() as $row)
            { $hasil[]=$row ; }
            return $hasil;
        }
    } 


    public function tambahpagu($id=null,$jenis=null,$pagu=null){

        $data['id_kend']    = $id;
        $data['tahun']      = $this->input->post('tahun');
        $data['pagu_awal']  = $pagu;
        $data['jenis_pagu']  = $jenis;
        $q = $this->db->insert('pagu_service',$data);
        return $q;
    }
 	
}
