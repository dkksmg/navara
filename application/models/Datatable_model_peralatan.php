<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 *
 * Model DatatableModel_model
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

class Datatable_model_peralatan extends CI_Model
{

  // ------------------------------------------------------------------------

  var $table = 'peralatan';
  var $column_order = array(null, 'peralatan.id', 'peralatan.id_asset', 'peralatan.jenis', 'peralatan.merk', 'peralatan.tipe', 'peralatan.nama','peralatan.tahun_perolehan', 'peralatan.lokasi_unit', 'peralatan.keterangan'); //set column field database for datatable orderable
  var $column_search = array(null, 'peralatan.id', 'peralatan.id_asset', 'peralatan.jenis', 'peralatan.merk', 'peralatan.tipe', 'peralatan.nama','peralatan.tahun_perolehan', 'peralatan.lokasi_unit', 'peralatan.keterangan');  //set column field database for datatable searchable 
  var $order = array('peralatan.id' => 'desc');

  public function __construct()
  {
    parent::__construct();
  }

  private function _get_query()
  {
    $this->db->select('peralatan.id as id_alat, peralatan.id_asset, peralatan.jenis, peralatan.merk, peralatan.tahun_perolehan, peralatan.foto_garansi, peralatan.garansi, peralatan.bidang, peralatan.keterangan, us.name, us.nip_user, rp.status');
    // $this->db->select('peralatan.id, ');
    $this->db->join('riwayat_pemakai_peralatan as rp', 'peralatan.id = rp.id_alat', 'left');
    $this->db->join('users as us', 'us.id = rp.id_user', 'left');
    // $this->db->join('peralatan as al', 'al.id as id_al', 'left');
    // $this->db->where('peralatan.status', 'aktif');
    // $this->db->group_start();
    // $this->db->where(array('rp.status' => 'aktif'));
    // // ->or_where('rp.status', 'tidak_aktif')
    // $this->db->or_where('rp.status', 'tidak_aktif');
    // $this->db->or_where('rp.status is null');
    // $this->db->group_end();
    // $this->db->order_by('rp.lokasi_unit', 'DESC');
    $this->db->from($this->table);
    // $this->db->from('peralatan');

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

  // function get_peralatan_with_pemakai()
  function get_peralatan()
  {
    // print_r("get alat");die;
    $this->_get_query();
    if (isset($_POST['length']) && $_POST['length'] < 1) {
      $_POST['length'] = '10';
    } else
      $_POST['length'] = $_POST['length'];

    if (isset($_POST['start']) && $_POST['start'] > 1) {
      $_POST['start'] = $_POST['start'];
    }
    $this->db->limit($_POST['length'], $_POST['start']);
    // print_r($_POST);die;
    // $this->db->select('*');
    // $this->db->from('peralatan');

    $query = $this->db->get();
    // print_r($query);
    // die();
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

/* End of file DatatableModel_model.php */
/* Location: ./application/models/DatatableModel_model.php */