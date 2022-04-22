<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rekap extends CI_Controller {

	function __construct(){
        parent::__construct();
        if (!$this->session->userdata('logged_in') !== FALSE) {
            redirect('auth');
        }
        if (!$this->session->userdata('logged_in_admin') !== FALSE) {
            redirect('pemakai');
        }
        $this->load->model('home_m');
    } 
	public function index()
	{
		$data = [];
		if ($this->input->get()) {
			$dari = date('Y-m-d',strtotime($this->input->get('dari')));
			$sampai = date('Y-m-d',strtotime($this->input->get('sampai')));
			$data['dari'] = $dari;
			$data['sampai'] = $sampai;
			$data['rekap'] = $this->home_m->data_rekap($dari,$sampai);
		}
		$this->load->view('admin/template/header');
		$this->load->view('admin/datarekap',$data);
		$this->load->view('admin/template/footer');
	}
}
