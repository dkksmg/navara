<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('logged_in') !== FALSE) {
            redirect('auth');
        }
        $this->load->model('home_m');
        $this->load->model('admin_m');
    }
    public function pagu()
    {
        $data = [];
        $id = $this->input->get('id');
        $data['kend'] = $this->home_m->kendaraanByid($id);
        $data['pagu'] = $this->admin_m->pagu_kendaraan($id);
        $this->load->view('admin/template/header');
        $this->load->view('admin/pagukendaraan', $data);
        $this->load->view('admin/template/footer');
    }

    public function user()
    {
        $data['user'] = $this->admin_m->user();
        $this->load->view('admin/template/header');
        $this->load->view('admin/user', $data);
        $this->load->view('admin/template/footer');
    }

    public function prosestambahpagu()
    {

        $id = $this->input->get('id');
        $jenispagu = $this->input->post('jenis');
        foreach ($jenispagu as $key => $value) {
            $simpan = $this->admin_m->tambahpagu($id, $value, $this->input->post('pagu')[$key]);
        }
        if ($simpan) {
            $this->session->set_flashdata('success', 'Tambah Pagu Anggaran Pemeliharaan Berhasil');
            redirect('admin/pagu?id=' . $id);
        } else {
            $this->session->set_flashdata('danger', 'Tambah Pagu Anggaran Pemeliharaan Gagal');
            redirect('admin/pagu?id=' . $id);
        }
    }

    public function prosestambahbbm()
    {
        $idkend = $this->input->get('id');
        $id_kend = $this->input->post('id_kend');
        if ($this->input->post()) {
            if ($this->home_m->tambahriwayatbbm($idkend)) {
                $this->session->set_flashdata('success', 'Tambah Riwayat BBM Kendaraan Berhasil');
                redirect('home/riwayat_bbm?id=' . $id_kend);
            } else {
                $this->session->set_flashdata('danger', 'Tambah Riwayat BBM Kendaraan gagal');
                redirect('home/riwayat_bbm?id=' . $id_kend);
            }
        }
    }
    public function prosestambahpajak()
    {
        $idkend = $this->input->get('id');
        if ($this->input->post()) {
            $cektahun = $this->home_m->cek_tahun_pajak($idkend, $this->input->post('tahun'));
            if ($cektahun != '') {
                $this->session->set_flashdata('danger', 'Anda sudah menginput pajak untuk tahun ' . $this->input->post('tahun'));
                redirect('home/riwayat_bbm?id=' . $idkend);
            } else {
                if ($this->home_m->tambahriwayatpajak($idkend)) {
                    $this->session->set_flashdata('success', 'Tambah Riwayat Pajak Kendaraan Berhasil');
                    redirect('home/riwayat_bbm?id=' . $idkend);
                } else {
                    $this->session->set_flashdata('danger', 'Tambah Riwayat Pajak Kendaraan gagal');
                    redirect('home/riwayat_bbm?id=' . $idkend);
                }
            }
        }
    }

    public function hapusrbbm()
    {
        $id = $this->input->get('id');
        $idkend = $this->input->get('idkend');
        if ($this->home_m->hapusbbm($id)) {
            $this->session->set_flashdata('success', 'Hapus Riwayat BBM Kendaraan Berhasil');
            redirect('home/riwayat_bbm?id=' . $idkend);
        } else {
            $this->session->set_flashdata('danger', 'Hapus Riwayat BBM Kendaraan gagal');
            redirect('pemakai/riwayatbbm');
        }
    }
}