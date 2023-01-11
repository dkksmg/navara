<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 *
 * Model Datatable_all_model
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

class Datatable_all_model extends CI_Model
{

  // ------------------------------------------------------------------------

  var $table = 'kendaraan';
  var $column_order = array(null, 'kendaraan.idk', 'kendaraan.no_polisi', 'kendaraan.merk', 'kendaraan.jenis', 'kendaraan.tipe', 'kendaraan.no_stnk', 'kendaraan.no_mesin', 'kendaraan.no_rangka', 'kendaraan.tahun_perolehan', 'kendaraan.jenis_bb', 'kendaraan.besar_cc', 'kendaraan.masa_berlaku_stnk'); //set column field database for datatable orderable
  var $column_search = array(null, 'kendaraan.idk', 'kendaraan.no_polisi', 'kendaraan.merk', 'kendaraan.jenis', 'kendaraan.tipe', 'kendaraan.no_stnk', 'kendaraan.no_mesin', 'kendaraan.no_rangka', 'kendaraan.tahun_perolehan', 'kendaraan.jenis_bb', 'kendaraan.besar_cc', 'kendaraan.masa_berlaku_stnk');  //set column field database for datatable searchable 
  var $order = array('kendaraan.idk' => 'ASC');

  public function __construct()
  {
    parent::__construct();
  }

  private function _get_query()
  {
    $this->db->select('*');
    $this->db->join('riwayat_pemakai as rp', 'kendaraan.idk = rp.id_kendaraan', 'left');
    $this->db->join('users as us', 'us.id = rp.id_user', 'left');
    $this->db->where('kendaraan.status', 'aktif');
    $this->db->group_start();
    $this->db->where(array('rp.status' => 'aktif'));
    // ->or_where('rp.status', 'tidak_aktif')
    $this->db->or_where('rp.status is null');
    $this->db->group_end();
    $this->db->order_by('rp.lokasi_unit', 'DESC');
    $this->db->from($this->table);

    $i = 0;
    foreach ($this->column_search as $emp) // loop column 
    {
      if (isset($_POST['search']['value']) && !empty($_POST['search']['value'])) {
        $_POST['search']['value'] = $_POST['search']['value'];
      } else {
        $_POST['search']['value'] = '';
      }

      if ($_POST['search']['value']) // if datatable send POST for search
      {
        if ($i === 0) // first loop
        {
          $this->db->group_start();
          $this->db->like($emp, $_POST['search']['value']);
        } else {
          $this->db->or_like($emp, $_POST['search']['value']);
        }

        if (count($this->column_search) - 1 == $i) //last loop
          $this->db->group_end(); //close bracket
      }
      $i++;
    }

    if (isset($_POST['order'])) // here order processing
    {
      $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
    } else if (isset($this->order)) {
      $order = $this->order;
      $this->db->order_by(key($order), $order[key($order)]);
    }
  }

  function get_kendaraan_with_pemakai()
  {
    $this->_get_query();
    if (isset($_POST['length']) && $_POST['length'] < 1) {
      $_POST['length'] = '10';
    } else
      $_POST['length'] = $_POST['length'];

    if (isset($_POST['start']) && $_POST['start'] > 1) {
      $_POST['start'] = $_POST['start'];
    }
    $this->db->limit($_POST['length'], $_POST['start']);
    //print_r($_POST);die;
    $query = $this->db->get();
    return $query->result();
  }

  function count_filtered()
  {
    $this->_get_query();
    $query = $this->db->get();
    return $query->num_rows();
  }

  public function count_all()
  {
    $this->db->from($this->table);
    return $this->db->count_all_results();
  }
}

/* End of file Datatable_all_model.php */
/* Location: ./application/models/Datatable_all_model.php */