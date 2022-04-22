<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Servis extends CI_Controller {

	function __construct(){
        parent::__construct();
        if (!$this->session->userdata('logged_in') !== FALSE) {
            redirect('auth');
        }
        $this->load->model('home_m');
        $this->load->model('admin_m');
        $this->load->model('servis_m');
    } 
	public function index()
	{
		$data = [];
        $data['kendaraan'] = $this->home_m->data_kendaraan();
		$this->load->view('admin/template/header');
		$this->load->view('admin/servis',$data);
		$this->load->view('admin/template/footer');
	}
}
