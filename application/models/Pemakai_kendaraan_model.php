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
    if ($this->session->userdata('role') == 'Admin') :
      $data['user'] = $this->db
        ->get_where('users', [
          'id' => $this->session->userdata('id'),
        ])
        ->row_array();
      $lokasi = $data['user']['wilayah'];
      $query = $this->db
        ->join('riwayat_pemakai', 'riwayat_pemakai.id_kendaraan = kendaraan.idk', 'left')
        ->join('users', 'users.id=riwayat_pemakai.id_user', 'left')
        ->join('ref_lokasi_unit', 'riwayat_pemakai.lokasi_unit = ref_lokasi_unit.lokasi_unit', 'inner')
        ->order_by('riwayat_pemakai.lokasi_unit', 'desc')
        ->order_by('idk', 'asc')
        ->group_start()
        ->where(array('riwayat_pemakai.status' => 'aktif', 'riwayat_pemakai.lokasi_unit' => $lokasi))
        // ->or_where('riwayat_pemakai.status is null')
        ->group_end()
        ->get('kendaraan');
    else :
      $query = $this->db
        ->join('riwayat_pemakai', 'riwayat_pemakai.id_kendaraan = kendaraan.idk', 'left')
        ->join('users', 'users.id=riwayat_pemakai.id_user', 'left')
        ->join('ref_lokasi_unit', 'riwayat_pemakai.lokasi_unit = ref_lokasi_unit.lokasi_unit', 'inner')
        ->order_by('riwayat_pemakai.lokasi_unit', 'desc')
        ->order_by('idk', 'asc')
        ->group_start()
        ->where('riwayat_pemakai.status', 'aktif')
        // ->or_where('riwayat_pemakai.status is null')
        ->group_end()
        ->get('kendaraan');
    endif;

    if ($query->num_rows() > 0) {
      foreach ($query->result_array() as $row) {
        $hasil[] = $row;
      }
      return $hasil;
    }
  }
  // public function dataPemakaiKendaraanBy()
  // {

  //   if ($query->num_rows() > 0) {
  //     foreach ($query->result_array() as $row) {
  //       $hasil[] = $row;
  //     }
  //     return $hasil;
  //   }
  // }

  // ------------------------------------------------------------------------

}

/* End of file Pemakai_kendaraan_model.php */
/* Location: ./application/models/Pemakai_kendaraan_model.php */