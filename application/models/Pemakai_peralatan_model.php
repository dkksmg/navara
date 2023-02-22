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

class Pemakai_peralatan_model extends CI_Model
{

  // ------------------------------------------------------------------------

  public function __construct()
  {
    parent::__construct();
  }

  // ------------------------------------------------------------------------


  // ------------------------------------------------------------------------
  public function dataPemakaiPeralatanByStatusPemakai()
  {
    if ($this->session->userdata('role') == 'Admin') {

      $data['user'] = $this->db
        ->get_where('users', [
          'id' => $this->session->userdata('id'),
        ])
        ->row_array();
      $lokasi = $data['user']['wilayah'];
      $query = $this->db
        ->join('riwayat_pemakai_peralatan', 'riwayat_pemakai_peralatan.id_alat = peralatan.id', 'left')
        ->join('users', 'users.id=riwayat_pemakai_peralatan.id_user', 'left')
        ->join('ref_lokasi_unit', 'riwayat_pemakai_peralatan.bidang = ref_lokasi_unit.lokasi_unit', 'inner')
        ->order_by('riwayat_pemakai_peralatan.bidang', 'desc')
        ->order_by('users.name', 'asc')
        ->order_by('id', 'desc')
        ->group_start()
        ->where(array('riwayat_pemakai_peralatan.status' => 'aktif', 'riwayat_pemakai_peralatan.lokasi_unit' => $lokasi))
        // ->or_where('riwayat_pemakai.status is null')
        ->group_end()
        ->get('peralatan');
    } else {

      $query = $this->db
        ->join('riwayat_pemakai_peralatan as rp', 'al.id = rp.id_alat', 'inner')
        ->join('users as us', 'us.id = rp.id_user', 'inner')
        ->order_by('rp.bidang', 'desc')
        ->order_by('us.name', 'asc')
        ->order_by('al.id', 'desc')
        ->group_start()
        ->where('rp.status', 'aktif')
        // ->or_where('rp.status is null')
        ->group_end()
        ->get('peralatan al');
    }

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