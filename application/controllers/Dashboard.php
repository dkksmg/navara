<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		check_session();
		check_level_pemakai();
		$this->load->model('dashboard_m');
	}
	public function index()
	{
		$data = [];
		$data['totalkendaraan'] = $this->dashboard_m->totalkendaraan();
		$data['totalspm'] = $this->dashboard_m->totalkendaraan_spm();
		$data['totaladmin'] = $this->dashboard_m->totaluseradmin();
		$data['totalpemakai'] = $this->dashboard_m->totaluserpemakai();
		$this->load->view('admin/template/header');
		$this->load->view('admin/kendaraan/dashboard', $data);
		$this->load->view('admin/template/footer');
	}
}