<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Servis extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        check_session();
        check_level_pemakai();
        check_level_admin();
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
        $cek_id = $this->home_m->cek_id_riwayat_servis($id);
        if ($cek_id != '') {
            $bulan_pilihan = $this->input->get('bulan_pilihan');
            $tahun_pilihan = $this->input->get('tahun_pilihan');
            $data = [];
            $data['kend'] = $this->servis_m->kendaraanByid($id);
            $data['rs'] = $this->servis_m->data_riwayatservisbulantahun($id, $bulan_pilihan, $tahun_pilihan);
            if ($bulan_pilihan == '' && $tahun_pilihan == '') {
                $data['title'] = 'Riwayat Servis Kendaraan Dinas';
            } else {
                if ($bulan_pilihan == 1) {
                    $nama_bulan = "Januari";
                } else if ($bulan_pilihan == 2) {
                    $nama_bulan = "Februari";
                } else if ($bulan_pilihan == 3) {
                    $nama_bulan = "Maret";
                } else if ($bulan_pilihan == 4) {
                    $nama_bulan = "April";
                } else if ($bulan_pilihan == 5) {
                    $nama_bulan = "Mei";
                } else if ($bulan_pilihan == 6) {
                    $nama_bulan = "Juni";
                } else if ($bulan_pilihan == 7) {
                    $nama_bulan = "Juli";
                } else if ($bulan_pilihan == 8) {
                    $nama_bulan = "Agustus";
                } else if ($bulan_pilihan == 9) {
                    $nama_bulan = "September";
                } else if ($bulan_pilihan == 10) {
                    $nama_bulan = "Oktober";
                } else if ($bulan_pilihan == 11) {
                    $nama_bulan = "November";
                } else {
                    $nama_bulan = "Desember";
                }
                $data['title'] = 'Riwayat Servis Kendaraan Dinas Bulan ' . $nama_bulan . ' Tahun ' . $tahun_pilihan . '';
            }
            $this->load->view('admin/template/header');
            $this->load->view('admin/servis/detailservis', $data);
            $this->load->view('admin/template/footer');
        } else {
            show_404();
        }
    }
}