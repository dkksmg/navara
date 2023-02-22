<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 *
 * Model Profile_model
 *
 * This Model for ...
 * 
 * @package		CodeIgniter
 * @category	Model
 * @author    Setiawan Jodi <jodisetiawan@fisip-untirta.ac.id>
 * @link      https://github.com/setdjod/myci-extension/
 * @param     ...
 * @return    ...
 *
 */

class Profile_model extends CI_Model
{

  // ------------------------------------------------------------------------

  public function __construct()
  {
    parent::__construct();
  }

  // ------------------------------------------------------------------------


  // ------------------------------------------------------------------------
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
  public function edituser($id_user = null)
  {
    if ($this->session->userdata('role') == 'Admin' || $this->session->userdata('role') == 'Superadmin') {
      if ($this->input->post('password') == "") {
        $data['name']    = $this->input->post('nama_user');
        $data['username']    = $this->input->post('username');
        $q = $this->db->where('id', $id_user)->update('users', $data);
        return $q;
      } else {
        $data['name']    = $this->input->post('nama_user');
        $data['username']    = $this->input->post('username');
        $data['password']      = password_hash($this->input->post('password'), PASSWORD_BCRYPT);
        $q = $this->db->where('id', $id_user)->update('users', $data);
        return $q;
      }
    } else {
      if ($this->input->post('password') == "") {
        $data['name']    = $this->input->post('nama_user');
        $data['nip_user']    = $this->input->post('nip_user');
        $q = $this->db->where('id', $id_user)->update('users', $data);
        return $q;
      } else {
        $data['name']    = $this->input->post('nama_user');
        $data['nip_user']    = $this->input->post('nip_user');
        $data['password']      = password_hash($this->input->post('password'), PASSWORD_BCRYPT);
        $q = $this->db->where('id', $id_user)->update('users', $data);
        return $q;
      }
    }
  }
  public function reset_pw($id_user = null)
  {
    $data['password']      = password_hash('dkksmg2022', PASSWORD_BCRYPT);
    $q = $this->db->where('id', $id_user)->update('users', $data);
    return $q;
  }

  // ------------------------------------------------------------------------

}

/* End of file Profile_model.php */
/* Location: ./application/models/Profile_model.php */