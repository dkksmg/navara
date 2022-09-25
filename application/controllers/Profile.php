<?php
defined('BASEPATH') or exit('No direct script access allowed');


/**
 *
 * Controller Profile
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

class Profile extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    check_session();
    $this->load->model('profile_model');
  }

  public function index()
  {
    $data['title'] = 'Data Profile ' . $this->session->userdata('name') . '';
    $data['user'] = $this->db
      ->get_where('users', [
        'id' => $this->session->userdata('id'),
      ])
      ->row_array();
    if ($this->session->userdata('role') != "Pemakai") {
      $this->load->view('admin/template/header');
      $this->load->view('admin/profil/data', $data);
      $this->load->view('admin/template/footer');
    } else {
      $this->load->view('pemakai/template/headeruser');
      $this->load->view('admin/profil/data', $data);
      $this->load->view('pemakai/template/footeruser');
    }
  }
  public function ubahdata()
  {
    $data['user'] = $this->db
      ->get_where('users', [
        'id' => $this->session->userdata('id'),
      ])
      ->row_array();
    $data['title'] = 'Ubah Data Profile ' . $this->session->userdata('name') . '';
    $data['lu'] = $this->profile_model->data_lokasiunit();
    if ($this->session->userdata('role') != "Pemakai") {
      $this->load->view('admin/template/header');
      $this->load->view('admin/profil/ubahdata', $data);
      $this->load->view('admin/template/footer');
    } else {
      $this->load->view('pemakai/template/headeruser');
      $this->load->view('admin/profil/ubahdata', $data);
      $this->load->view('pemakai/template/footeruser');
    }
  }
  public function prosesubahdata()
  {
    $id_user = $this->input->get('id');
    if ($this->input->post()) {
      if ($this->profile_model->edituser($id_user)) {
        if ($this->session->userdata('role') != 'Pemakai') {
          $this->session->set_flashdata('success', 'Data Anda berhasil di perbaharui');
          redirect('home');
        } else {
          $this->session->set_flashdata('success', 'Data Anda berhasil di perbaharui');
          redirect('pemakai');
        }
      } else {
        $this->session->set_flashdata('danger', 'Data Anda gagal diubah');
        redirect('profile');
      }
    }
  }
}


/* End of file Profile.php */
/* Location: ./application/controllers/Profile.php */