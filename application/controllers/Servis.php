<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Servis extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        check_session();
        check_level();
        $this->load->model('home_m');
        $this->load->model('admin_m');
        $this->load->model('servis_m');
    }
    public function index()
    {
        $data = [];
        $data['title'] = 'Detail Servis Kendaraan Dinas';
        $data['kendaraan'] = $this->home_m->data_kendaraan();
        $this->load->view('admin/template/header');
        $this->load->view('admin/servis/dataservis', $data);
        $this->load->view('admin/template/footer');
    }
    public function detail_servis()
    {
        $id = $this->input->get('id');
        $idk = $this->input->post('id_kend');
        $bulan_pilihan = $this->input->post('bulan_pilihan');
        $tahun_pilihan = $this->input->post('tahun_pilihan');
        $data = [];
        $data['title'] = 'Riwayat Servis Kendaraan Dinas';
        $data['kend'] = $this->servis_m->kendaraanByid($id);
        $data['rs'] = $this->servis_m->data_riwayatservisbulantahun($idk, $bulan_pilihan, $tahun_pilihan);
        // print_r($this->db->last_query());
        // die();
        $this->load->view('admin/template/header');
        $this->load->view('admin/servis/detailservis', $data);
        $this->load->view('admin/template/footer');
    }
}