<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	function __construct(){
        parent::__construct();
        if (!$this->session->userdata('logged_in') !== FALSE) {
            redirect('auth');
        }
        $this->load->model('dashboard_m');
    } 
	public function index()
	{
		$data = [];
		$data['totalkendaraan'] = $this->dashboard_m->totalkendaraan();
		$this->load->view('admin/template/header');
		$this->load->view('admin/dashboard',$data);
		$this->load->view('admin/template/footer');
	}
}
