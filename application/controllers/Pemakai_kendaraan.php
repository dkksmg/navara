<?php
defined('BASEPATH') or exit('No direct script access allowed');
// Don't forget include/define REST_Controller path

/**
 *
 * Controller Pemakai_kendaraan
 *
 * This controller for ...
 *
 * @package   CodeIgniter
 * @category  Controller CI
 * @author    Setiawan Jodi <jodisetiawan@fisip-untirta.ac.id>
 * @author    Raul Guerrero <r.g.c@me.com>
 * @link      https://github.com/setdjod/myci-extension/
 * @param     ...
 * @return    ...
 *
 */

class Pemakai_kendaraan extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    check_session();
    $this->load->model('pemakai_kendaraan_model');
  }

  public function index()
  {
    $data = [];
    $data['title'] = "Data Pemakai Kendaraan Dinas";
    $data['kendaraan'] = $this->pemakai_kendaraan_model->dataPemakaiKendaraanByStatusPemakai();
    $this->load->view('admin/template/header');
    $this->load->view('admin/dataPemakaiKendaraan', $data);
    $this->load->view('admin/template/footer');
  }
}


/* End of file Pemakai_kendaraan.php */
/* Location: ./application/controllers/Pemakai_kendaraan.php */