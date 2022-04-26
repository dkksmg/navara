<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 *
 * Model Pemakai_kendaraan_model
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

class Pemakai_kendaraan_model extends CI_Model
{

  // ------------------------------------------------------------------------

  public function __construct()
  {
    parent::__construct();
  }

  // ------------------------------------------------------------------------


  // ------------------------------------------------------------------------
  public function dataPemakaiKendaraanByStatusPemakai()
  {
    if ($this->session->userdata('rule') == 'admin') {
      $this->db->where('user_id', $this->session->userdata('id'));
    }
    $query = $this->db->join('riwayat_pemakai', 'riwayat_pemakai.id_kendaraan = kendaraan.idk', 'left')
      ->order_by('idk', 'asc')
      ->group_start()
      ->where('riwayat_pemakai.status', 'aktif')
      // ->or_where('riwayat_pemakai.status is null')
      ->group_end()
      ->get('kendaraan');
    if ($query->num_rows() > 0) {
      foreach ($query->result_array() as $row) {
        $hasil[] = $row;
      }
      return $hasil;
    }
  }

  // ------------------------------------------------------------------------

}

/* End of file Pemakai_kendaraan_model.php */
/* Location: ./application/models/Pemakai_kendaraan_model.php */