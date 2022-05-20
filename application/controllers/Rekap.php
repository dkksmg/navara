<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Rekap extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		check_level_pemakai();
		check_level_admin();
		check_session();
		$this->load->model('home_m');
	}
	public function index()
	{
		$data = [];
		$data['title'] = "Rekap Laporan Kendaraan Dinas";
		if ($this->input->get()) {
			$dari = date('Y-m-d', strtotime($this->input->get('dari')));
			$sampai = date('Y-m-d', strtotime($this->input->get('sampai')));
			$data['dari'] = $dari;
			$data['sampai'] = $sampai;
			$data['rekap'] = $this->home_m->data_rekap($dari, $sampai);
		}
		$this->load->view('admin/template/header');
		$this->load->view('admin/rekap/datarekap', $data);
		$this->load->view('admin/template/footer');
	}
}