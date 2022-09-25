<?php

use phpDocumentor\Reflection\DocBlock\Tags\Var_;

defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        check_session();
        check_level_pemakai();

        $this->load->model('home_m');
    }
    public function index()
    {
        // $data = [];
        // $data['title'] = 'Data Kendaraan Dinas';
        // $data['kendaraan'] = $this->home_m->data_kendaraan();
        // $this->load->view('admin/template/header');
        // $this->load->view('admin/kendaraan/dataKendaraan', $data);
        // $this->load->view('admin/template/modal');
        // $this->load->view('admin/template/footer');
        return redirect('home/kendaraan_pemakai');
    }
    public function kendaraan_pemakai()
    {
        $data = [];
        $data['title'] = 'Data Kendaraan Dinas';
        $data['kendaraan'] = $this->home_m->data_kendaraan();
        // print_r($this->db->last_query());
        $this->load->view('admin/template/header');
        $this->load->view('admin/kendaraan/dataKendaraan', $data);
        $this->load->view('admin/template/modal');
        $this->load->view('admin/template/footer');
    }
    public function all_kendaraan()
    {
        $data = [];
        $data['title'] = 'Data Kendaraan Dinas';
        $data['kendaraan'] = $this->home_m->data_kendaraan_all();
        $this->load->view('admin/template/header');
        $this->load->view('admin/kendaraan/dataKendaraanall', $data);
        $this->load->view('admin/template/modal');
        $this->load->view('admin/template/footer');
    }
    public function tambahKendaraanDinas()
    {
        check_level_admin();
        $data = [];
        $data['title'] = 'Tambah Kendaraan Dinas';
        if ($this->input->post()) {
            if ($this->home_m->tambahKendaraanDinas()) {
                $this->session->set_flashdata('success', 'Tambah Kendaraan Berhasil');
                redirect('home/kendaraan_pemakai');
            } else {
                $this->session->set_flashdata('danger', 'Tambah Kendaraan gagal');
            }
        }
        $this->load->view('admin/template/header');
        $this->load->view('admin/kendaraan/tambahKendaraanDinas', $data);
        $this->load->view('admin/template/footer');
    }
    public function tambahKendaraanDinasall()
    {
        check_level_admin();
        $data = [];
        $data['title'] = 'Tambah Kendaraan Dinas';
        if ($this->input->post()) {
            if ($this->home_m->tambahKendaraanDinas()) {
                $this->session->set_flashdata('success', 'Tambah Kendaraan Berhasil');
                redirect('home/all_kendaraan');
            } else {
                $this->session->set_flashdata('danger', 'Tambah Kendaraan gagal');
            }
        }
        $this->load->view('admin/template/header');
        $this->load->view('admin/kendaraan/tambahKendaraanDinas', $data);
        $this->load->view('admin/template/footer');
    }
    public function edit_kendaraan()
    {
        check_level_admin();
        $id = $this->input->get('id');
        $cek_id_kondisi = $this->home_m->cek_id_riwayat_kondisi($id);
        if ($cek_id_kondisi != '') {
            $data = [];
            $data['title'] = 'Edit Kendaraan Dinas';
            $data['kend'] = $this->home_m->dataKendaraanByid($id);
            $this->load->view('admin/template/header');
            $this->load->view('admin/kendaraan/editkendaraandinas', $data);
            $this->load->view('admin/template/footer');
        } else {
            show_404();
        }
    }
    public function proseseditkendaraandinas()
    {
        check_level_admin();
        $idk = $this->input->get('id');
        if ($this->input->post()) {
            if ($this->home_m->editKendaraanDinas($idk)) {
                $this->session->set_flashdata('success', 'Update Data Kendaraan Berhasil');
                redirect('home/kendaraan_pemakai');
            } else {
                $this->session->set_flashdata('danger', 'Update Data Kendaraan gagal');
            }
        }
    }
    public function hapus_data_kendaraan()
    {
        check_level_admin();
        $id_kend = ($this->input->get('id'));
        if ($this->home_m->hapus_data_kendaraan($id_kend)) {
            $this->session->set_flashdata('success', 'Hapus Data Kendaraan Berhasil');
            redirect('home');
        } else {
            $this->session->set_flashdata('danger', 'Hapus Data Kendaraan gagal');
            redirect('home');
        }
    }

    public function riwayat_kondisi()
    {
        $id = $this->input->get('id');
        $tahun = date('Y');
        $cek_id_kondisi = $this->home_m->cek_id_riwayat_kondisi($id);
        if ($cek_id_kondisi != '') {
            $data = [];
            $data['kend'] = $this->home_m->kendaraanByid($id);
            $data['pagu'] = $this->home_m->pagukendaraanById($id, $tahun);
            $data['rk'] = $this->home_m->data_riwayatKondisi($id);
            $data['pmk'] = $this->home_m->pemakaiKendById($id);
            $this->load->view('admin/template/header');
            $this->load->view('admin/kondisi/riwayatKondisi', $data);
            $this->load->view('admin/template/modal');
            $this->load->view('admin/template/footer');
        } else {
            show_404();
        }
    }
    public function editriwayatkondisi()
    {
        $id = $this->input->get('id');
        $tahun = date('Y');
        $cek_id  = $this->home_m->cek_id_edit_riwayat_kondisi($id);
        if ($cek_id != '') {
            $data = [];
            $data['title'] = 'Edit Riwayat Kondisi Kendaraan';
            $data['value'] = $this->home_m->data_kondisiById($id);
            $id_kend = $data['value']['id_kendaraan'];
            $data['kend'] = $this->home_m->kendaraanByid($id_kend);
            $data['pmk'] = $this->home_m->pemakaiKendById($id_kend);
            $data['pagu'] = $this->home_m->pagukendaraanById($id_kend, $tahun);
            $this->load->view('admin/template/header');
            $this->load->view('admin/kondisi/editriwayatkondisi', $data);
            $this->load->view('admin/template/footer');
        } else {
            show_404();
        }
    }
    public function proseseditkondisi()
    {
        $data = [];
        $idk = $this->input->post('id_kend');
        $tgl = $this->input->post('tgl');
        $tipe = $this->input->post('tipe');
        $no_pol = $this->input->post('no_pol');
        $id_rk = $this->input->get('id');
        if (!empty($_FILES['depan']['name'])) {
            $config['upload_path'] = './assets/upload/file_kendaraan/depan/'; //path folder
            $config['allowed_types'] = 'jpg|png|jpeg|jfif'; //type yang dapat diakses bisa anda sesuaikan
            // $config['overwrite'] = TRUE; //timpa file yang terupload
            $config['remove_spaces'] = TRUE;
            $config['file_name'] = 'foto_depan_' . $tipe . '_' . $no_pol . '_' . $tgl . '_' . uniqid();

            $this->load->library('upload', $config, 'depan');
            $this->depan->initialize($config);
            $this->depan->do_upload('depan');
            $dpn = $this->depan->data();
            //compress file
            $config['image_library'] = 'gd2';
            $config['source_image'] = './assets/upload/file_kendaraan/depan/' . $dpn['file_name'];
            $config['create_thumb'] = FALSE;
            $config['maintain_ratio'] = TRUE;
            $config['quality'] = '50%';
            $config['width'] = 600;
            $config['height'] = 400;
            $config['new_image'] = './assets/upload/file_kendaraan/depan/' . $dpn['file_name'];
            $this->load->library('image_lib', $config, 'resizedpn');
            $res = $this->resizedpn->resize();
            $nama_dpn = $dpn['file_name'];
        }
        if (!empty($_FILES['blkg']['name'])) {
            $config['upload_path'] = './assets/upload/file_kendaraan/belakang/'; //path folder
            $config['allowed_types'] = 'jpg|png|jpeg|jfif'; //type yang dapat diakses bisa anda sesuaikan
            $config['overwrite'] = TRUE; //timpa file yang terupload
            $config['remove_spaces'] = TRUE;
            $config['file_name'] = 'foto_belakang_' . $tipe . '_' . $no_pol . '_' . $tgl . '_' . uniqid();

            $this->load->library('upload', $config, 'blkg');
            $this->blkg->initialize($config);
            $this->blkg->do_upload('blkg');
            $blkg = $this->blkg->data();
            //compress file
            $config['image_library'] = 'gd2';
            $config['source_image'] = './assets/upload/file_kendaraan/belakang/' . $blkg['file_name'];
            $config['create_thumb'] = FALSE;
            $config['maintain_ratio'] = TRUE;
            $config['quality'] = '50%';
            $config['width'] = 600;
            $config['height'] = 400;
            $config['new_image'] = './assets/upload/file_kendaraan/belakang/' . $blkg['file_name'];
            $this->load->library('image_lib', $config, 'resizeblkg');
            $res = $this->resizeblkg->resize();
            $nama_blkg = $blkg['file_name'];
        }
        if (!empty($_FILES['kiri']['name'])) {
            $config['upload_path'] = './assets/upload/file_kendaraan/kiri/'; //path folder
            $config['allowed_types'] = 'jpg|png|jpeg|jfif'; //type yang dapat diakses bisa anda sesuaikan
            $config['overwrite'] = TRUE; //timpa file yang terupload
            $config['remove_spaces'] = TRUE;
            $config['file_name'] = 'foto_kiri_' . $tipe . '_' . $no_pol . '_' . $tgl . '_' . uniqid();

            $this->load->library('upload', $config, 'kiri');
            $this->kiri->initialize($config);
            $this->kiri->do_upload('kiri');
            $kiri = $this->kiri->data();
            //compress file
            $config['image_library'] = 'gd2';
            $config['source_image'] = './assets/upload/file_kendaraan/kiri/' . $kiri['file_name'];
            $config['create_thumb'] = FALSE;
            $config['maintain_ratio'] = TRUE;
            $config['quality'] = '50%';
            $config['width'] = 600;
            $config['height'] = 400;
            $config['new_image'] = './assets/upload/file_kendaraan/kiri/' . $kiri['file_name'];
            $this->load->library('image_lib', $config, 'resizekiri');
            $res = $this->resizekiri->resize();
            $nama_kiri = $kiri['file_name'];
        }
        if (!empty($_FILES['kanan']['name'])) {
            $config['upload_path'] = './assets/upload/file_kendaraan/kanan/'; //path folder
            $config['allowed_types'] = 'jpg|png|jpeg|jfif'; //type yang dapat diakses bisa anda sesuaikan
            $config['overwrite'] = TRUE; //timpa file yang terupload
            $config['remove_spaces'] = TRUE;
            $config['file_name'] = 'foto_kanan_' . $tipe . '_' . $no_pol . '_' . $tgl . '_' . uniqid();

            $this->load->library('upload', $config, 'kanan');
            $this->kanan->initialize($config);
            $this->kanan->do_upload('kanan');
            $kanan = $this->kanan->data();
            //compress file
            $config['image_library'] = 'gd2';
            $config['source_image'] = './assets/upload/file_kendaraan/kanan/' . $kanan['file_name'];
            $config['create_thumb'] = FALSE;
            $config['maintain_ratio'] = TRUE;
            $config['quality'] = '50%';
            $config['width'] = 600;
            $config['height'] = 400;
            $config['new_image'] = './assets/upload/file_kendaraan/kanan/' . $kanan['file_name'];
            $this->load->library('image_lib', $config, 'resizekanan');
            $res = $this->resizekanan->resize();
            $nama_kanan = $kanan['file_name'];
        }
        // var_dump($nama_kanan, $nama_kiri, $nama_dpn, $nama_blkg, $id_rk);
        // die();
        if (!empty($_FILES['depan']['name']) && !empty($_FILES['blkg']['name']) && !empty($_FILES['kiri']['name']) && !empty($_FILES['kanan']['name'])) {
            $simpan = $this->home_m->updateriwayatkondisikendaraan($nama_dpn, $nama_blkg, $nama_kiri, $nama_kanan, $id_rk);
            if ($simpan) {
                $this->session->set_flashdata('success', 'Update Riwayat Kondisi Kendaraan Berhasil');
                redirect('home/riwayat_kondisi?id=' . $idk . '');
            } else {
                $this->session->set_flashdata('danger', 'Update Riwayat Kondisi Kendaraan gagal');
                $data['post'] = $this->input->post();
            }
        } else if (empty($_FILES['depan']['name']) && empty($_FILES['blkg']['name'])) {
            $nama_dpn = $this->input->post('old_depan');
            $nama_blkg = $this->input->post('old_belakang');
            $simpan = $this->home_m->updateriwayatkondisikendaraan($nama_dpn, $nama_blkg, $nama_kiri, $nama_kanan, $id_rk);
            if ($simpan) {
                $this->session->set_flashdata('success', 'Update Riwayat Kondisi Kendaraan Berhasil. Silakan menunggu proses verifikasi oleh Admin');
                redirect('home/riwayat_kondisi?id=' . $idk . '');
            } else {
                $this->session->set_flashdata('danger', 'Update Riwayat Kondisi Kendaraan gagal');
                $data['post'] = $this->input->post();
            }
        } else if (empty($_FILES['depan']['name']) && empty($_FILES['kiri']['name'])) {
            $nama_dpn = $this->input->post('old_depan');
            $nama_kiri = $this->input->post('old_kiri');
            $simpan = $this->home_m->updateriwayatkondisikendaraan($nama_dpn, $nama_blkg, $nama_kiri, $nama_kanan, $id_rk);
            if ($simpan) {
                $this->session->set_flashdata('success', 'Update Riwayat Kondisi Kendaraan Berhasil. Silakan menunggu proses verifikasi oleh Admin');
                redirect('home/riwayat_kondisi?id=' . $idk . '');
            } else {
                $this->session->set_flashdata('danger', 'Update Riwayat Kondisi Kendaraan gagal');
                $data['post'] = $this->input->post();
            }
        } else if (empty($_FILES['depan']['name']) && empty($_FILES['kanan']['name'])) {
            $nama_dpn = $this->input->post('old_depan');
            $nama_kanan = $this->input->post('old_kanan');
            $simpan = $this->home_m->updateriwayatkondisikendaraan($nama_dpn, $nama_blkg, $nama_kiri, $nama_kanan, $id_rk);
            if ($simpan) {
                $this->session->set_flashdata('success', 'Update Riwayat Kondisi Kendaraan Berhasil. Silakan menunggu proses verifikasi oleh Admin');
                redirect('home/riwayat_kondisi?id=' . $idk . '');
            } else {
                $this->session->set_flashdata('danger', 'Update Riwayat Kondisi Kendaraan gagal');
                $data['post'] = $this->input->post();
            }
        } else if (empty($_FILES['blkg']['name']) && empty($_FILES['depan']['name'])) {
            $nama_blkg = $this->input->post('old_belakang');
            $nama_dpn = $this->input->post('old_depan');
            $simpan = $this->home_m->updateriwayatkondisikendaraan($nama_dpn, $nama_blkg, $nama_kiri, $nama_kanan, $id_rk);
            if ($simpan) {
                $this->session->set_flashdata('success', 'Update Riwayat Kondisi Kendaraan Berhasil. Silakan menunggu proses verifikasi oleh Admin');
                redirect('home/riwayat_kondisi?id=' . $idk . '');
            } else {
                $this->session->set_flashdata('danger', 'Update Riwayat Kondisi Kendaraan gagal');
                $data['post'] = $this->input->post();
            }
        } else if (empty($_FILES['blkg']['name']) && empty($_FILES['kanan']['name'])) {
            $nama_blkg = $this->input->post('old_belakang');
            $nama_kanan = $this->input->post('old_kanan');
            $simpan = $this->home_m->updateriwayatkondisikendaraan($nama_dpn, $nama_blkg, $nama_kiri, $nama_kanan, $id_rk);
            if ($simpan) {
                $this->session->set_flashdata('success', 'Update Riwayat Kondisi Kendaraan Berhasil. Silakan menunggu proses verifikasi oleh Admin');
                redirect('home/riwayat_kondisi?id=' . $idk . '');
            } else {
                $this->session->set_flashdata('danger', 'Update Riwayat Kondisi Kendaraan gagal');
                $data['post'] = $this->input->post();
            }
        } else if (empty($_FILES['blkg']['name']) && empty($_FILES['kiri']['name'])) {
            $nama_blkg = $this->input->post('old_belakang');
            $nama_kiri = $this->input->post('old_kiri');
            $simpan = $this->home_m->updateriwayatkondisikendaraan($nama_dpn, $nama_blkg, $nama_kiri, $nama_kanan, $id_rk);
            if ($simpan) {
                $this->session->set_flashdata('success', 'Update Riwayat Kondisi Kendaraan Berhasil. Silakan menunggu proses verifikasi oleh Admin');
                redirect('home/riwayat_kondisi?id=' . $idk . '');
            } else {
                $this->session->set_flashdata('danger', 'Update Riwayat Kondisi Kendaraan gagal');
                $data['post'] = $this->input->post();
            }
        } else if (empty($_FILES['kiri']['name']) && empty($_FILES['depan']['name'])) {
            $nama_kiri = $this->input->post('old_kiri');
            $nama_dpn = $this->input->post('old_depan');
            $simpan = $this->home_m->updateriwayatkondisikendaraan($nama_dpn, $nama_blkg, $nama_kiri, $nama_kanan, $id_rk);
            if ($simpan) {
                $this->session->set_flashdata('success', 'Update Riwayat Kondisi Kendaraan Berhasil. Silakan menunggu proses verifikasi oleh Admin');
                redirect('home/riwayat_kondisi?id=' . $idk . '');
            } else {
                $this->session->set_flashdata('danger', 'Update Riwayat Kondisi Kendaraan gagal');
                $data['post'] = $this->input->post();
            }
        } else if (empty($_FILES['kiri']['name']) && empty($_FILES['blkg']['name'])) {
            $nama_kiri = $this->input->post('old_kiri');
            $nama_blkg = $this->input->post('old_belakang');
            $simpan = $this->home_m->updateriwayatkondisikendaraan($nama_dpn, $nama_blkg, $nama_kiri, $nama_kanan, $id_rk);
            if ($simpan) {
                $this->session->set_flashdata('success', 'Update Riwayat Kondisi Kendaraan Berhasil. Silakan menunggu proses verifikasi oleh Admin');
                redirect('home/riwayat_kondisi?id=' . $idk . '');
            } else {
                $this->session->set_flashdata('danger', 'Update Riwayat Kondisi Kendaraan gagal');
                $data['post'] = $this->input->post();
            }
        } else if (empty($_FILES['kiri']['name']) && empty($_FILES['kanan']['name'])) {
            $nama_kiri = $this->input->post('old_kiri');
            $nama_kanan = $this->input->post('old_kanan');
            $simpan = $this->home_m->updateriwayatkondisikendaraan($nama_dpn, $nama_blkg, $nama_kiri, $nama_kanan, $id_rk);
            if ($simpan) {
                $this->session->set_flashdata('success', 'Update Riwayat Kondisi Kendaraan Berhasil. Silakan menunggu proses verifikasi oleh Admin');
                redirect('home/riwayat_kondisi?id=' . $idk . '');
            } else {
                $this->session->set_flashdata('danger', 'Update Riwayat Kondisi Kendaraan gagal');
                $data['post'] = $this->input->post();
            }
        } else if (empty($_FILES['kanan']['name']) && empty($_FILES['depan']['name'])) {
            $nama_kanan = $this->input->post('old_kanan');
            $nama_dpn = $this->input->post('old_depan');
            $simpan = $this->home_m->updateriwayatkondisikendaraan($nama_dpn, $nama_blkg, $nama_kiri, $nama_kanan, $id_rk);
            if ($simpan) {
                $this->session->set_flashdata('success', 'Update Riwayat Kondisi Kendaraan Berhasil. Silakan menunggu proses verifikasi oleh Admin');
                redirect('home/riwayat_kondisi?id=' . $idk . '');
            } else {
                $this->session->set_flashdata('danger', 'Update Riwayat Kondisi Kendaraan gagal');
                $data['post'] = $this->input->post();
            }
        } else if (empty($_FILES['kanan']['name']) && empty($_FILES['blkg']['name'])) {
            $nama_kanan = $this->input->post('old_kanan');
            $nama_blkg = $this->input->post('old_belakang');
            $simpan = $this->home_m->updateriwayatkondisikendaraan($nama_dpn, $nama_blkg, $nama_kiri, $nama_kanan, $id_rk);
            if ($simpan) {
                $this->session->set_flashdata('success', 'Update Riwayat Kondisi Kendaraan Berhasil. Silakan menunggu proses verifikasi oleh Admin');
                redirect('home/riwayat_kondisi?id=' . $idk . '');
            } else {
                $this->session->set_flashdata('danger', 'Update Riwayat Kondisi Kendaraan gagal');
                $data['post'] = $this->input->post();
            }
        } else if (empty($_FILES['kanan']['name']) && empty($_FILES['kiri']['name'])) {
            $nama_kanan = $this->input->post('old_kanan');
            $nama_kiri = $this->input->post('old_kiri');
            $simpan = $this->home_m->updateriwayatkondisikendaraan($nama_dpn, $nama_blkg, $nama_kiri, $nama_kanan, $id_rk);
            if ($simpan) {
                $this->session->set_flashdata('success', 'Update Riwayat Kondisi Kendaraan Berhasil. Silakan menunggu proses verifikasi oleh Admin');
                redirect('home/riwayat_kondisi?id=' . $idk . '');
            } else {
                $this->session->set_flashdata('danger', 'Update Riwayat Kondisi Kendaraan gagal');
                $data['post'] = $this->input->post();
            }
        } else if (empty($_FILES['depan']['name'])) {
            $nama_dpn = $this->input->post('old_depan');;
            $simpan = $this->home_m->updateriwayatkondisikendaraan($nama_dpn, $nama_blkg, $nama_kiri, $nama_kanan, $id_rk);
            if ($simpan) {
                $this->session->set_flashdata('success', 'Update Riwayat Kondisi Kendaraan Berhasil. Silakan menunggu proses verifikasi oleh Admin');
                redirect('home/riwayat_kondisi?id=' . $idk . '');
            } else {
                $this->session->set_flashdata('danger', 'Update Riwayat Kondisi Kendaraan gagal');
                $data['post'] = $this->input->post();
            }
        } else if (empty($_FILES['blkg']['name'])) {
            $nama_blkg = $this->input->post('old_belakang');;
            $simpan = $this->home_m->updateriwayatkondisikendaraan($nama_dpn, $nama_blkg, $nama_kiri, $nama_kanan, $id_rk);
            if ($simpan) {
                $this->session->set_flashdata('success', 'Update Riwayat Kondisi Kendaraan Berhasil. Silakan menunggu proses verifikasi oleh Admin');
                redirect('home/riwayat_kondisi?id=' . $idk . '');
            } else {
                $this->session->set_flashdata('danger', 'Update Riwayat Kondisi Kendaraan gagal');
                $data['post'] = $this->input->post();
            }
        } else if (empty($_FILES['kiri']['name'])) {
            $nama_kiri = $this->input->post('old_kiri');;
            $simpan = $this->home_m->updateriwayatkondisikendaraan($nama_dpn, $nama_blkg, $nama_kiri, $nama_kanan, $id_rk);
            if ($simpan) {
                $this->session->set_flashdata('success', 'Update Riwayat Kondisi Kendaraan Berhasil. Silakan menunggu proses verifikasi oleh Admin');
                redirect('home/riwayat_kondisi?id=' . $idk . '');
            } else {
                $this->session->set_flashdata('danger', 'Update Riwayat Kondisi Kendaraan gagal');
                $data['post'] = $this->input->post();
            }
        } else if (empty($_FILES['kanan']['name'])) {
            $nama_kanan = $this->input->post('old_kanan');;
            $simpan = $this->home_m->updateriwayatkondisikendaraan($nama_dpn, $nama_blkg, $nama_kiri, $nama_kanan, $id_rk);
            if ($simpan) {
                $this->session->set_flashdata('success', 'Update Riwayat Kondisi Kendaraan Berhasil. Silakan menunggu proses verifikasi oleh Admin');
                redirect('home/riwayat_kondisi?id=' . $idk . '');
            } else {
                $this->session->set_flashdata('danger', 'Update Riwayat Kondisi Kendaraan gagal');
                $data['post'] = $this->input->post();
            }
        } else if (empty($_FILES['depan']['name']) && empty($_FILES['blkg']['name']) && empty($_FILES['kiri']['name']) && empty($_FILES['kanan']['name'])) {
            $nama_dpn = $this->input->post('old_depan');
            $nama_blkg = $this->input->post('old_belakang');
            $nama_kiri = $this->input->post('old_kiri');
            $nama_kanan = $this->input->post('old_kanan');
            $simpan = $this->home_m->updateriwayatkondisikendaraan($nama_dpn, $nama_blkg, $nama_kiri, $nama_kanan, $id_rk);
            if ($simpan) {
                $this->session->set_flashdata('success', 'Update Riwayat Kondisi Kendaraan Berhasil. Silakan menunggu proses verifikasi oleh Admin');
                redirect('home/riwayat_kondisi?id=' . $idk . '');
            } else {
                $this->session->set_flashdata('danger', 'Update Riwayat Kondisi Kendaraan gagal');
                $data['post'] = $this->input->post();
            }
        } else {
            if (isset($nama_dpn)) {
                unlink('./assets/upload/file_kendaraan/depan/' . $nama_dpn);
            }
            if (isset($nama_blkg)) {
                unlink('./assets/upload/file_kendaraan/belakang/' . $nama_blkg);
            }
            if (isset($nama_kiri)) {
                unlink('./assets/upload/file_kendaraan/kiri/' . $nama_kiri);
            }
            if (isset($nama_kanan)) {
                unlink('./assets/upload/file_kendaraan/kanan/' . $nama_kanan);
            }
            $this->session->set_flashdata('danger', 'Tambah Riwayat Kondisi Kendaraan gagal, Silahkan lengkapi kelengkapan data anda');
            redirect('home/riwayat_kondisi?=' . $idk . '');
            $data['post'] = $this->input->post();
        }
    }
    public function riwayat_pemakai()
    {
        $id = $this->input->get('id');
        $tahun = date('Y');
        $cek_id_pemakai = $this->home_m->cek_id_riwayat_pemakai($id);
        if ($cek_id_pemakai != '') {
            $data = [];
            $data['rp'] = $this->home_m->data_riwayatpemakai($id);
            $data['pemakai'] = $this->home_m->listdata_pemakai();
            $data['kend'] = $this->home_m->kendaraanByid($id);
            $data['pmk'] = $this->home_m->pemakaiKendById($id);
            $data['pagu'] = $this->home_m->pagukendaraanById($id, $tahun);
            $data['lu'] = $this->home_m->data_lokasiunit();
            $this->load->view('admin/template/header');
            $this->load->view('admin/pemakai/riwayatPemakai', $data);
            $this->load->view('admin/template/modal');
            $this->load->view('admin/template/footer');
        } else {
            show_404();
        }
    }
    public function edit_pemakai()
    {
        $id = $this->input->get('id');
        $tahun = date('Y');
        $cek_id  = $this->home_m->cek_id_edit_riwayat_pemakai($id);
        if ($cek_id != '') {
            $data = [];
            $data['title'] = 'Edit Data Pemakai Kendaraan Dinas';
            $data['value'] = $this->home_m->data_pemakaibyid($id);
            $data['pemakai'] = $this->home_m->listdata_pemakai();
            $data['lu'] = $this->home_m->data_lokasiunit();
            $id_kend = $data['value']['id_kendaraan'];
            $data['pmk'] = $this->home_m->pemakaiKendById($id_kend);
            $data['kend'] = $this->home_m->kendaraanByid($id_kend);
            $data['pagu'] = $this->home_m->pagukendaraanById($id_kend, $tahun);
            $this->load->view('admin/template/header');
            $this->load->view('admin/pemakai/editPemakai', $data);
            $this->load->view('admin/template/footer');
        } else {
            show_404();
        }
    }
    public function riwayat_servis()
    {
        $id = $this->input->get('id');
        $tahun = date('Y');
        $cek_id = $this->home_m->cek_id_riwayat_servis($id);
        if ($cek_id != '') {
            $data = [];
            $data['kend'] = $this->home_m->kendaraanByid($id);
            $data['rs'] = $this->home_m->data_riwayatservis($id);
            $data['pmk'] = $this->home_m->pemakaiKendById($id);
            $data['pagu'] = $this->home_m->pagukendaraanById($id, $tahun);
            $this->load->view('admin/template/header');
            $this->load->view('admin/servis/riwayatServis', $data);
            $this->load->view('admin/template/modal');
            $this->load->view('admin/template/footer');
        } else {
            show_404();
        }
    }
    public function prosestambahservis()
    {

        $idk = $this->input->get('id');
        $tgl = $this->input->post('tgl');
        $tipe = $this->input->post('tipe');
        $no_pol = $this->input->post('no_pol');
        $ceksrs = $this->home_m->cek_data_srs($idk);
        if ($ceksrs['status_srs'] == 'Wait') {
            $this->session->set_flashdata('danger', 'Anda sudah melakukan input Riwayat Servis. Silakan menunggu proses verifikasi oleh Admin');
            redirect('home/riwayat_servis?id=' . $idk);
        } else if (empty($ceksrs['status_srs'])) {
            if (!empty($_FILES['foto']['name'])) {
                $config['upload_path'] = './assets/upload/foto_servis/'; //path folder
                $config['allowed_types'] = 'jpg|png|jpeg|jfif'; //type yang dapat diakses bisa anda sesuaikan
                // $config['overwrite'] = TRUE;
                $config['remove_spaces'] = TRUE;
                $config['file_name'] = 'foto_servis_' . $tipe . '_' . $no_pol . '_' . $tgl . '_' . uniqid();

                $this->load->library('upload', $config, 'foto');
                $this->foto->initialize($config);
                $this->foto->do_upload('foto');
                $foto = $this->foto->data();
                //compress file
                $config['image_library'] = 'gd2';
                $config['source_image'] = './assets/upload/foto_servis/' . $foto['file_name'];
                $config['create_thumb'] = FALSE;
                $config['maintain_ratio'] = TRUE;
                $config['quality'] = '50%';
                $config['width'] = 600;
                $config['height'] = 400;
                $config['new_image'] = './assets/upload/foto_servis/' . $foto['file_name'];
                $this->load->library('image_lib', $config, 'resizefoto');
                $res = $this->resizefoto->resize();
                $namafoto = $foto['file_name'];
            }
            if (!empty($_FILES['nota']['name'])) {
                $config['upload_path'] = './assets/upload/foto_nota/'; //path folder
                $config['allowed_types'] = 'jpg|png|jpeg|jfif'; //type yang dapat diakses bisa anda sesuaikan
                // $config['overwrite'] = TRUE;
                $config['remove_spaces'] = TRUE;
                $config['file_name'] = 'foto_nota_' . $tipe . '_' . $no_pol . '_' . $tgl . '_' . uniqid();

                $this->load->library('upload', $config, 'nota');
                $this->nota->initialize($config);
                $this->nota->do_upload('nota');
                $nota = $this->nota->data();
                //compress file
                $config['image_library'] = 'gd2';
                $config['source_image'] = './assets/upload/foto_nota/' . $nota['file_name'];
                $config['create_thumb'] = FALSE;
                $config['maintain_ratio'] = TRUE;
                $config['quality'] = '50%';
                $config['width'] = 600;
                $config['height'] = 400;
                $config['new_image'] = './assets/upload/foto_nota/' . $nota['file_name'];
                $this->load->library('image_lib', $config, 'resizenota');
                $res = $this->resizenota->resize();
                $namanota = $nota['file_name'];
            }
            if (!empty($_FILES['foto']['name']) && !empty($_FILES['nota']['name'])) {
                $simpan = $this->home_m->tambahriwayatserviskendaraan($namafoto, $idk, $namanota);
                if ($simpan) {
                    $this->session->set_flashdata('success', 'Tambah Riwayat Service Kendaraan Berhasil. Silakan menunggu proses verifikasi oleh Admin');
                    redirect('home/riwayat_servis?id=' . $idk . '');
                } else {
                    $this->session->set_flashdata('danger', 'Tambah Riwayat Service Kendaraan gagal');
                    $data['post'] = $this->input->post();
                }
            }
            // without foto service
            else if (empty($_FILES['foto']['name']) && !empty($_FILES['nota']['name'])) {
                $simpan = $this->home_m->tambahriwayatserviskendaraanwithoutservis($idk, $namanota);
                if ($simpan) {
                    $this->session->set_flashdata('success', 'Tambah Riwayat Service Kendaraan Berhasil. Silakan menunggu proses verifikasi oleh Admin');
                    redirect('home/riwayat_servis?id=' . $idk . '');
                } else {
                    $this->session->set_flashdata('danger', 'Tambah Riwayat Service Kendaraan gagal');
                    $data['post'] = $this->input->post();
                }
            }
            // without foto nota
            else if (!empty($_FILES['foto']['name']) && empty($_FILES['nota']['name'])) {
                $simpan = $this->home_m->tambahriwayatserviskendaraanwithoutnota($idk, $namafoto);
                if ($simpan) {
                    $this->session->set_flashdata('success', 'Tambah Riwayat Service Kendaraan Berhasil. Silakan menunggu proses verifikasi oleh Admin');
                    redirect('home/riwayat_servis?id=' . $idk . '');
                } else {
                    $this->session->set_flashdata('danger', 'Tambah Riwayat Service Kendaraan gagal');
                    $data['post'] = $this->input->post();
                }
            }
            // without foto nota & foto service
            else if (empty($_FILES['foto']['name']) or empty($_FILES['nota']['name'])) {
                $simpan = $this->home_m->tambahriwayatserviskendaraanwithoutimage($idk);
                if ($simpan) {
                    $this->session->set_flashdata('success', 'Tambah Riwayat Service Kendaraan Berhasil. Silakan menunggu proses verifikasi oleh Admin');
                    redirect('home/riwayat_servis?id=' . $idk . '');
                } else {
                    $this->session->set_flashdata('danger', 'Tambah Riwayat Service Kendaraan gagal');
                    $data['post'] = $this->input->post();
                }
            } else {
                if (isset($nama_dpn)) {
                    unlink('./assets/foto_servis/' . $namafoto);
                }
                $this->session->set_flashdata('danger', 'Tambah Riwayat Service Kendaraan gagal, Silahkan lengkapi kelengkapan data anda');
                redirect('home/riwayat_servis?id=' . $idk . '');
                $data['post'] = $this->input->post();
            }
        } else {
            if (!empty($_FILES['foto']['name'])) {
                $config['upload_path'] = './assets/upload/foto_servis/'; //path folder
                $config['allowed_types'] = 'jpg|png|jpeg|jfif'; //type yang dapat diakses bisa anda sesuaikan
                // $config['overwrite'] = TRUE;
                $config['remove_spaces'] = TRUE;
                $config['file_name'] = 'foto_servis_' . $tipe . '_' . $no_pol . '_' . $tgl . '_' . uniqid();

                $this->load->library('upload', $config, 'foto');
                $this->foto->initialize($config);
                $this->foto->do_upload('foto');
                $foto = $this->foto->data();
                //compress file
                $config['image_library'] = 'gd2';
                $config['source_image'] = './assets/upload/foto_servis/' . $foto['file_name'];
                $config['create_thumb'] = FALSE;
                $config['maintain_ratio'] = TRUE;
                $config['quality'] = '50%';
                $config['width'] = 600;
                $config['height'] = 400;
                $config['new_image'] = './assets/upload/foto_servis/' . $foto['file_name'];
                $this->load->library('image_lib', $config, 'resizefoto');
                $res = $this->resizefoto->resize();
                $namafoto = $foto['file_name'];
            }
            if (!empty($_FILES['nota']['name'])) {
                $config['upload_path'] = './assets/upload/foto_nota/'; //path folder
                $config['allowed_types'] = 'jpg|png|jpeg|jfif'; //type yang dapat diakses bisa anda sesuaikan
                // $config['overwrite'] = TRUE;
                $config['remove_spaces'] = TRUE;
                $config['file_name'] = 'foto_nota_' . $tipe . '_' . $no_pol . '_' . $tgl . '_' . uniqid();

                $this->load->library('upload', $config, 'nota');
                $this->nota->initialize($config);
                $this->nota->do_upload('nota');
                $nota = $this->nota->data();
                //compress file
                $config['image_library'] = 'gd2';
                $config['source_image'] = './assets/upload/foto_nota/' . $nota['file_name'];
                $config['create_thumb'] = FALSE;
                $config['maintain_ratio'] = TRUE;
                $config['quality'] = '50%';
                $config['width'] = 600;
                $config['height'] = 400;
                $config['new_image'] = './assets/upload/foto_nota/' . $nota['file_name'];
                $this->load->library('image_lib', $config, 'resizenota');
                $res = $this->resizenota->resize();
                $namanota = $nota['file_name'];
            }
            if (!empty($_FILES['foto']['name']) && !empty($_FILES['nota']['name'])) {
                $simpan = $this->home_m->tambahriwayatserviskendaraan($namafoto, $idk, $namanota);
                if ($simpan) {
                    $this->session->set_flashdata('success', 'Tambah Riwayat Service Kendaraan Berhasil. Silakan menunggu proses verifikasi oleh Admin');
                    redirect('home/riwayat_servis?id=' . $idk . '');
                } else {
                    $this->session->set_flashdata('danger', 'Tambah Riwayat Service Kendaraan gagal');
                    $data['post'] = $this->input->post();
                }
            }
            // without foto service
            else if (empty($_FILES['foto']['name']) && !empty($_FILES['nota']['name'])) {
                $simpan = $this->home_m->tambahriwayatserviskendaraanwithoutservis($idk, $namanota);
                if ($simpan) {
                    $this->session->set_flashdata('success', 'Tambah Riwayat Service Kendaraan Berhasil. Silakan menunggu proses verifikasi oleh Admin');
                    redirect('home/riwayat_servis?id=' . $idk . '');
                } else {
                    $this->session->set_flashdata('danger', 'Tambah Riwayat Service Kendaraan gagal');
                    $data['post'] = $this->input->post();
                }
            }
            // without foto nota
            else if (!empty($_FILES['foto']['name']) && empty($_FILES['nota']['name'])) {
                $simpan = $this->home_m->tambahriwayatserviskendaraanwithoutnota($idk, $namafoto);
                if ($simpan) {
                    $this->session->set_flashdata('success', 'Tambah Riwayat Service Kendaraan Berhasil. Silakan menunggu proses verifikasi oleh Admin');
                    redirect('home/riwayat_servis?id=' . $idk . '');
                } else {
                    $this->session->set_flashdata('danger', 'Tambah Riwayat Service Kendaraan gagal');
                    $data['post'] = $this->input->post();
                }
            }
            // without foto nota & foto service
            else if (empty($_FILES['foto']['name']) or empty($_FILES['nota']['name'])) {
                $simpan = $this->home_m->tambahriwayatserviskendaraanwithoutimage($idk);
                if ($simpan) {
                    $this->session->set_flashdata('success', 'Tambah Riwayat Service Kendaraan Berhasil. Silakan menunggu proses verifikasi oleh Admin');
                    redirect('home/riwayat_servis?id=' . $idk . '');
                } else {
                    $this->session->set_flashdata('danger', 'Tambah Riwayat Service Kendaraan gagal');
                    $data['post'] = $this->input->post();
                }
            } else {
                if (isset($nama_dpn)) {
                    unlink('./assets/foto_servis/' . $namafoto);
                }
                $this->session->set_flashdata('danger', 'Tambah Riwayat Service Kendaraan gagal, Silahkan lengkapi kelengkapan data anda');
                redirect('home/riwayat_servis?id=' . $idk . '');
                $data['post'] = $this->input->post();
            }
        }
    }
    public function editriwayatservis()
    {
        $id = $this->input->get('id');
        $tahun = date('Y');
        $cek_id = $this->home_m->cek_id_edit_riwayat_servis($id);
        if ($cek_id != '') {
            $data = [];
            $data['title'] = "Edit Riwayat Servis Kendaraan";
            $data['servis'] = $this->home_m->data_servisById($id);
            $id_kend = $data['servis']['id_kendaraan'];
            $data['pmk'] = $this->home_m->pemakaiKendById($id_kend);
            $data['kend'] = $this->home_m->kendaraanByid($id_kend);
            $data['pagu'] = $this->home_m->pagukendaraanById($id_kend, $tahun);
            $this->load->view('admin/template/header');
            $this->load->view('admin/servis/editRiwayatServis', $data);
            $this->load->view('admin/template/footer');
        } else {
            show_404();
        }
    }
    public function proseseditservis()
    {
        $id_rs = $this->input->get('id');
        $idk = $this->input->post('id_kend');
        $tgl = $this->input->post('tgl');
        $tipe = $this->input->post('tipe');
        $no_pol = $this->input->post('no_pol');
        // $config['overwrite'] = true;

        // $this->load->library('upload', $config);
        if (!empty($_FILES['foto']['name'])) {
            $config['upload_path'] = './assets/upload/foto_servis/'; //path folder
            $config['allowed_types'] = 'jpg|png|jpeg|jfif'; //type yang dapat diakses bisa anda sesuaikan
            // $config['overwrite'] = TRUE;
            $config['remove_spaces'] = TRUE;
            $config['file_name'] = 'foto_servis_' . $tipe . '_' . $no_pol . '_' . $tgl . '_' . uniqid();

            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            $this->upload->do_upload('foto');
            $foto = $this->upload->data();
            //compress file
            $config['image_library'] = 'gd2';
            $config['source_image'] = './assets/upload/foto_servis/' . $foto['file_name'];
            $config['create_thumb'] = FALSE;
            $config['maintain_ratio'] = TRUE;
            $config['quality'] = '50%';
            $config['width'] = 600;
            $config['height'] = 400;
            $config['new_image'] = './assets/upload/foto_servis/' . $foto['file_name'];
            $this->load->library('image_lib', $config);
            $res = $this->image_lib->resize();
            $namafoto = $foto['file_name'];
        }
        if (!empty($_FILES['nota']['name'])) {
            $config['upload_path'] = './assets/upload/foto_nota/'; //path folder
            $config['allowed_types'] = 'jpg|png|jpeg|jfif'; //type yang dapat diakses bisa anda sesuaikan
            // $config['overwrite'] = TRUE; //Overwrite nama yang terupload
            $config['remove_spaces'] = TRUE;
            $config['file_name'] = 'foto_nota_' . $tipe . '_' . $no_pol . '_' . $tgl . '_' . uniqid();

            $this->load->library('upload', $config, 'nota');
            $this->nota->initialize($config);
            $this->nota->do_upload('nota');
            $nota = $this->nota->data();
            //compress file
            $config['image_library'] = 'gd2';
            $config['source_image'] = './assets/upload/foto_nota/' . $nota['file_name'];
            $config['create_thumb'] = FALSE;
            $config['maintain_ratio'] = TRUE;
            $config['quality'] = '50%';
            $config['width'] = 600;
            $config['height'] = 400;
            $config['new_image'] = './assets/upload/foto_nota/' . $nota['file_name'];
            $this->load->library('image_lib', $config, 'resizenota');
            $res = $this->resizenota->resize();
            $namanota = $nota['file_name'];
        }

        if (!empty($_FILES['foto']['name']) && !empty($_FILES['nota']['name'])) {
            $simpan = $this->home_m->updateriwayatserviskendaraan($namafoto, $id_rs, $namanota);
            if ($simpan) {
                $this->session->set_flashdata('success', 'Edit Riwayat Service Kendaraan Berhasil');
                redirect('home/riwayat_servis?id=' . $idk . '');
            } else {
                $this->session->set_flashdata('danger', 'Edit Riwayat Service Kendaraan gagal');
                $data['post'] = $this->input->post();
            }
        } else if (empty($_FILES['foto']['name']) && empty($_FILES['nota']['name'])) {
            $namafoto = $this->input->post('old_servis');
            $namanota = $this->input->post('old_nota');
            $simpan = $this->home_m->updateriwayatserviskendaraan($namafoto, $id_rs, $namanota);
            if ($simpan) {
                $this->session->set_flashdata('success', 'Edit Riwayat Service Kendaraan Berhasil');
                redirect('home/riwayat_servis?id=' . $idk . '');
            } else {
                $this->session->set_flashdata('danger', 'Edit Riwayat Service Kendaraan gagal');
                $data['post'] = $this->input->post();
            }
        } else if (empty($_FILES['nota']['name'])) {
            $namanota = $this->input->post('old_nota');
            $simpan = $this->home_m->updateriwayatserviskendaraan($namafoto, $id_rs, $namanota);
            if ($simpan) {
                $this->session->set_flashdata('success', 'Edit Riwayat Service Kendaraan Berhasil');
                redirect('home/riwayat_servis?id=' . $idk . '');
            } else {
                $this->session->set_flashdata('danger', 'Edit Riwayat Service Kendaraan gagal');
                $data['post'] = $this->input->post();
            }
        } else if (empty($_FILES['nota']['foto'])) {
            $namafoto = $this->input->post('old_servis');
            $simpan = $this->home_m->updateriwayatserviskendaraan($namafoto, $id_rs, $namanota);
            if ($simpan) {
                $this->session->set_flashdata('success', 'Edit Riwayat Service Kendaraan Berhasil');
                redirect('home/riwayat_servis?id=' . $idk . '');
            } else {
                $this->session->set_flashdata('danger', 'Edit Riwayat Service Kendaraan gagal');
                $data['post'] = $this->input->post();
            }
        } else {
            if (isset($nama_dpn)) {
                unlink('./assets/foto_servis/' . $namafoto);
            }
            $this->session->set_flashdata('danger', 'Edit Riwayat Service Kendaraan gagal, Silahkan lengkapi kelengkapan data anda');
            redirect('home/riwayat_servis?id=' . $idk . '');
            $data['post'] = $this->input->post();
        }
    }
    public function delete_servis()
    {
        $id = $this->input->get('id');
        $this->db->where('id_rs', $id);
        $this->db->delete('riwayat_servis');
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function riwayat_bbm()
    {
        $id = ($this->input->get('id'));
        $tahun = date('Y');
        $cek_id = $this->home_m->cek_id_riwayat_bbm($id);
        if ($cek_id != '') {
            $data = [];
            $data['title'] = 'Riwayat BBM Kendaraan Dinas';
            $data['rbbm'] = $this->home_m->data_riwayatbbm($id);
            $data['kend'] = $this->home_m->kendaraanByid($id);
            $data['pmk'] = $this->home_m->pemakaiKendById($id);
            $data['pagu'] = $this->home_m->pagukendaraanById($id, $tahun);
            $this->load->view('admin/template/header');
            $this->load->view('admin/bbm/riwayatBBM', $data);
            $this->load->view('admin/template/modal');
            $this->load->view('admin/template/footer');
        } else {
            show_404();
        }
    }
    public function editrbbm()
    {
        $id_kend = ($this->input->get('idkend'));
        $id_bbm = ($this->input->get('id'));
        $tahun = date('Y');
        $cek_id = $this->home_m->cek_id_edit_riwayat_bbm($id_bbm, $id_kend);
        if ($cek_id != '') {
            $data = [];
            $data['title'] = 'Edit Riwayat BBM';
            $data['rbbm'] = $this->home_m->data_riwayatbbm_byid($id_bbm);
            $data['pmk'] = $this->home_m->pemakaiKendById($id_kend);
            $data['kend'] = $this->home_m->kendaraanByid($id_kend);
            $data['pagu'] = $this->home_m->pagukendaraanById($id_kend, $tahun);
            $this->load->view('admin/template/header');
            $this->load->view('admin/bbm/editriwayatBBM', $data);
            $this->load->view('admin/template/modal');
            $this->load->view('admin/template/footer');
        } else {
            show_404();
        }
    }
    public function prosestambahbbm()
    {
        $id_bbm = ($this->input->get('id'));
        $id_kend = ($this->input->post('id_kend'));
        $data = [];
        $tgl = $this->input->post('tgl_bbm');
        $tipe = ($this->input->post('tipe'));
        $no_pol = ($this->input->post('no_pol'));

        if (!empty($_FILES['struk_bbm']['name'])) {
            $config['upload_path'] = './assets/upload/struk_bbm/'; //path folder
            $config['allowed_types'] = 'jpg|png|jpeg|jfif'; //type yang dapat diakses bisa anda sesuaikan
            // $config['overwrite'] = TRUE; //timpa file yang terupload
            $config['remove_spaces'] = TRUE;
            $config['file_name'] = 'struk_bbm_' . $tipe . '_' . $no_pol . '_' . $tgl . '_' . uniqid();

            $this->load->library('upload', $config, 'struk_bbm');
            $this->struk_bbm->initialize($config);
            $this->struk_bbm->do_upload('struk_bbm');
            $st_bbm = $this->struk_bbm->data();
            //compress file
            $config['image_library'] = 'gd2';
            $config['source_image'] = './assets/upload/struk_bbm/' . $st_bbm['file_name'];
            $config['create_thumb'] = FALSE;
            $config['maintain_ratio'] = TRUE;
            $config['quality'] = '50%';
            $config['width'] = 600;
            $config['height'] = 400;
            $config['new_image'] = './assets/upload/struk_bbm/' . $st_bbm['file_name'];
            $this->load->library('image_lib', $config, 'resize_bbm');
            $res = $this->resize_bbm->resize();
            $nama_struk_bbm = $st_bbm['file_name'];
        }
        if (!empty($_FILES['struk_bbm']['name'])) {
            $simpan = $this->home_m->tambahriwayatbbm($id_kend, $nama_struk_bbm);
            if ($simpan) {
                $this->session->set_flashdata('success', 'Tambah Riwayat BBM Kendaraan Berhasil');
                redirect('home/riwayat_bbm?id=' . $id_bbm);
            } else {
                $this->session->set_flashdata('danger', 'Tambah Riwayat BBM Kendaraan gagal');
                $data['post'] = $this->input->post();
            }
        } else if (empty($_FILES['struk_bbm']['name'])) {
            $simpan = $this->home_m->tambahriwayatbbmwithoutimage($id_kend);
            if ($simpan) {
                $this->session->set_flashdata('success', 'Tambah Riwayat BBM Kendaraan Berhasil');
                redirect('home/riwayat_bbm?id=' . $id_bbm);
            } else {
                $this->session->set_flashdata('danger', 'Tambah Riwayat BBM Kendaraan gagal');
                $data['post'] = $this->input->post();
            }
        } else {
            if (isset($nama_struk_bbm)) {
                unlink('./assets/upload/struk_bbm/' . $nama_struk_bbm);
            }
            $this->session->set_flashdata('danger', 'Tambah Riwayat BBM Kendaraan gagal, Silahkan lengkapi kelengkapan data anda');
            redirect('home/riwayat_bbm?id=' . $id_bbm);
            $data['post'] = $this->input->post();
        }
    }
    public function proseseditbbm()
    {
        $data = [];
        $id_bbm = ($this->input->get('id'));
        $id_kend = ($this->input->get('idkend'));
        $tgl = $this->input->post('tgl_bbm');
        $tipe = ($this->input->post('tipe'));
        $no_pol = ($this->input->post('no_pol'));

        if (!empty($_FILES['struk_bbm']['name'])) {
            $config['upload_path'] = './assets/upload/struk_bbm/'; //path folder
            $config['allowed_types'] = 'jpg|png|jpeg|jfif'; //type yang dapat diakses bisa anda sesuaikan
            // $config['overwrite'] = TRUE; //timpa file yang terupload
            $config['remove_spaces'] = TRUE;
            $config['file_name'] = 'struk_bbm_' . $tipe . '_' . $no_pol . '_' . $tgl . '_' . uniqid();

            $this->load->library('upload', $config, 'struk_bbm');
            $this->struk_bbm->initialize($config);
            $this->struk_bbm->do_upload('struk_bbm');
            $st_bbm = $this->struk_bbm->data();
            //compress file
            $config['image_library'] = 'gd2';
            $config['source_image'] = './assets/upload/struk_bbm/' . $st_bbm['file_name'];
            $config['create_thumb'] = FALSE;
            $config['maintain_ratio'] = TRUE;
            $config['quality'] = '50%';
            $config['width'] = 600;
            $config['height'] = 400;
            $config['new_image'] = './assets/upload/struk_bbm/' . $st_bbm['file_name'];
            $this->load->library('image_lib', $config, 'resize_bbm');
            $res = $this->resize_bbm->resize();
            $nama_struk_bbm = $st_bbm['file_name'];
        }
        if (!empty($_FILES['struk_bbm']['name'])) {
            $simpan = $this->home_m->updateriwayatbbm($id_bbm, $nama_struk_bbm);
            if ($simpan) {
                $this->session->set_flashdata('success', 'Edit Riwayat BBM Kendaraan Berhasil');
                redirect('home/riwayat_bbm?id=' . $id_kend);
            } else {
                $this->session->set_flashdata('danger', 'Edit Riwayat BBM Kendaraan gagal');
                $data['post'] = $this->input->post();
            }
        } else if (empty($_FILES['struk_bbm']['name'])) {
            $nama_struk_bbm = ($this->input->post('old_struk'));
            if (!empty($nama_struk_bbm)) {
                $simpan = $this->home_m->updateriwayatbbm($id_bbm, $nama_struk_bbm);
                if ($simpan) {
                    $this->session->set_flashdata('success', 'Edit Riwayat BBM Kendaraan Berhasil');
                    redirect('home/riwayat_bbm?id=' . $id_kend);
                } else {
                    $this->session->set_flashdata('danger', 'Edit Riwayat BBM Kendaraan gagal');
                    $data['post'] = $this->input->post();
                }
            } else {
                $simpan = $this->home_m->updateriwayatbbmwithoutimage($id_bbm);
                if ($simpan) {
                    $this->session->set_flashdata('success', 'Edit Riwayat BBM Kendaraan Berhasil');
                    redirect('home/riwayat_bbm?id=' . $id_kend);
                } else {
                    $this->session->set_flashdata('danger', 'Edit Riwayat BBM Kendaraan gagal');
                    $data['post'] = $this->input->post();
                }
            }
        } else {
            if (isset($nama_struk_bbm)) {
                unlink('./assets/upload/struk_bbm/' . $nama_struk_bbm);
            }
            $this->session->set_flashdata('danger', 'Edit Riwayat BBM Kendaraan gagal, Silahkan lengkapi kelengkapan data anda');
            redirect('home/riwayat_bbm?id=' . $id_kend);
            $data['post'] = $this->input->post();
        }
    }
    public function hapusrbbm()
    {
        $id_bbm = ($this->input->get('id'));
        $id_kend = ($this->input->get('idkend'));
        if ($this->home_m->hapusbbm($id_bbm)) {
            $this->session->set_flashdata('success', 'Hapus Riwayat BBM Kendaraan Berhasil');
            redirect('home/riwayat_bbm?id=' . $id_kend);
        } else {
            $this->session->set_flashdata('danger', 'Hapus Riwayat BBM Kendaraan gagal');
            redirect('home/riwayat_bbm?id=' . $id_kend);
        }
    }

    public function riwayat_pajak()
    {
        $id = $this->input->get('id');
        $tahun = date('Y');
        $cek_id = $this->home_m->cek_id_riwayat_pajak($id);
        if ($cek_id != '') {
            $data = [];
            $data['rp'] = $this->home_m->data_riwayatpajak($id);
            $data['kend'] = $this->home_m->kendaraanByid($id);
            $data['pmk'] = $this->home_m->pemakaiKendById($id);
            $data['pagu'] = $this->home_m->pagukendaraanById($id, $tahun);
            $data['title'] = 'Riwayat Pajak Kendaraan Dinas';
            $this->load->view('admin/template/header');
            $this->load->view('admin/pajak/riwayatPajak', $data);
            $this->load->view('admin/template/modal');
            $this->load->view('admin/template/footer');
        } else {
            show_404();
        }
    }
    public function prosestambahpajak()
    {
        $idkend = $this->input->get('id');
        if ($this->input->post()) {
            $cektahun = $this->home_m->cek_tahun_pajak($idkend, $this->input->post('tahun_pajak'));
            if ($cektahun != '') {
                $this->session->set_flashdata('danger', 'Anda sudah menginput pajak untuk tahun ' . $this->input->post('tahun_pajak'));
                redirect('home/riwayat_pajak?id=' . $idkend . '');
            } else {
                if ($this->home_m->tambahriwayatpajak($idkend)) {
                    $this->session->set_flashdata('success', 'Tambah Riwayat Pajak Kendaraan Berhasil');
                    redirect('home/riwayat_pajak?id=' . $idkend . '');
                } else {
                    $this->session->set_flashdata('danger', 'Tambah Riwayat Pajak Kendaraan gagal');
                    redirect('home/riwayat_pajak?id=' . $idkend . '');
                }
            }
        }
    }
    public function editriwayatpajak()
    {
        $id = $this->input->get('id');
        $tahun = date('Y');
        $cek_id = $this->home_m->cek_id_edit_riwayat_pajak($id);
        if ($cek_id != '') {
            $data = [];
            $data['rp'] = $this->home_m->data_riwayatpajak($id);
            $data['value'] = $this->home_m->datapajakById($id);
            $id_kend = $data['value']['id_kendaraan'];
            $data['pmk'] = $this->home_m->pemakaiKendById($id_kend);
            $data['kend'] = $this->home_m->kendaraanByid($id_kend);
            $data['pagu'] = $this->home_m->pagukendaraanById($id_kend, $tahun);
            $data['title'] = 'Edit Riwayat Pajak Kendaraan Dinas';
            $this->load->view('admin/template/header');
            $this->load->view('admin/pajak/editriwayatPajak', $data);
            $this->load->view('admin/template/footer');
        } else {
            show_404();
        }
    }
    public function proseseditpajak()
    {
        $id_pjk = $this->input->get('id');
        $id = $this->input->get('id');
        $id_kend = $this->input->post('id_kend');
        if ($this->input->post()) {
            $cektahun = $this->home_m->cek_tahun_pajak($id, $this->input->post('tahun_pajak'));
            if ($cektahun != '') {
                $this->session->set_flashdata('danger', 'Anda sudah menginput pajak untuk tahun ' . $this->input->post('tahun_pajak'));
                redirect('home/riwayat_pajak?id=' . $id_kend);
            } else {
                if ($this->home_m->updateriwayatpajak($id_pjk)) {
                    $this->session->set_flashdata('success', 'Edit Riwayat Pajak Kendaraan Berhasil');
                    redirect('home/riwayat_pajak?id=' . $id_kend . '');
                } else {
                    $this->session->set_flashdata('danger', 'Edit Riwayat Pajak Kendaraan gagal');
                    redirect('home/riwayat_pajak?id=' . $id_kend . '');
                }
            }
        }
    }
    public function hapusriwayatpajak()
    {
        $id_pjk = $this->input->get('id');
        $simpan = $this->home_m->hapusriwayatpajak($id_pjk);
        if ($simpan) {
            $this->session->set_flashdata('success', 'Hapus Riwayat Pajak Kendaraan Dinas Berhasil');
            redirect($_SERVER['HTTP_REFERER']);
        } else {
            $this->session->set_flashdata('danger', 'Hapus Riwayat Pajak Kendaraan Dinas gagal');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

    public function prosestambahkondisi()
    {
        $data = [];
        $idk = $this->input->get('id');
        $tgl = date('Y-m-d');
        $tipe = $this->input->post('tipe');
        $no_pol = $this->input->post('no_pol');

        if (!empty($_FILES['depan']['name'])) {
            $config['upload_path'] = './assets/upload/file_kendaraan/depan/'; //path folder
            $config['allowed_types'] = 'jpg|png|jpeg|jfif'; //type yang dapat diakses bisa anda sesuaikan
            // $config['overwrite'] = TRUE; //timpa file yang terupload
            $config['remove_spaces'] = TRUE;
            $config['file_name'] = 'foto_depan_' . $tipe . '_' . $no_pol . '_' . $tgl . '_' . uniqid();

            $this->load->library('upload', $config, 'depan');
            $this->depan->initialize($config);
            $this->depan->do_upload('depan');
            $dpn = $this->depan->data();
            //compress file
            $config['image_library'] = 'gd2';
            $config['source_image'] = './assets/upload/file_kendaraan/depan/' . $dpn['file_name'];
            $config['create_thumb'] = FALSE;
            $config['maintain_ratio'] = TRUE;
            $config['quality'] = '50%';
            $config['width'] = 600;
            $config['height'] = 400;
            $config['new_image'] = './assets/upload/file_kendaraan/depan/' . $dpn['file_name'];
            $this->load->library('image_lib', $config, 'resizedpn');
            $res = $this->resizedpn->resize();
            $nama_dpn = $dpn['file_name'];
        }
        if (!empty($_FILES['blkg']['name'])) {

            $config['upload_path'] = './assets/upload/file_kendaraan/belakang/'; //path folder
            $config['allowed_types'] = 'jpg|png|jpeg|jfif'; //type yang dapat diakses bisa anda sesuaikan
            // $config['overwrite'] = TRUE; //timpa file yang terupload
            $config['remove_spaces'] = TRUE;
            $config['file_name'] = 'foto_belakang_' . $tipe . '_' . $no_pol . '_' . $tgl . '_' . uniqid();

            $this->load->library('upload', $config, 'blkg');
            $this->blkg->initialize($config);
            $this->blkg->do_upload('blkg');
            $blkg = $this->blkg->data();
            //compress file
            $config['image_library'] = 'gd2';
            $config['source_image'] = './assets/upload/file_kendaraan/belakang/' . $blkg['file_name'];
            $config['create_thumb'] = FALSE;
            $config['maintain_ratio'] = TRUE;
            $config['quality'] = '50%';
            $config['width'] = 600;
            $config['height'] = 400;
            $config['new_image'] = './assets/upload/file_kendaraan/belakang/' . $blkg['file_name'];
            $this->load->library('image_lib', $config, 'resizeblkg');
            $res = $this->resizeblkg->resize();
            $nama_blkg = $blkg['file_name'];
        }
        if (!empty($_FILES['kiri']['name'])) {
            $config['upload_path'] = './assets/upload/file_kendaraan/kiri/'; //path folder
            $config['allowed_types'] = 'jpg|png|jpeg|jfif'; //type yang dapat diakses bisa anda sesuaikan
            // $config['overwrite'] = TRUE; //timpa file yang terupload
            $config['remove_spaces'] = TRUE;
            $config['file_name'] = 'foto_kiri_' . $tipe . '_' . $no_pol . '_' . $tgl . '_' . uniqid();

            $this->load->library('upload', $config, 'kiri');
            $this->kiri->initialize($config);
            $this->kiri->do_upload('kiri');
            $kiri = $this->kiri->data();
            //compress file
            $config['image_library'] = 'gd2';
            $config['source_image'] = './assets/upload/file_kendaraan/kiri/' . $kiri['file_name'];
            $config['create_thumb'] = FALSE;
            $config['maintain_ratio'] = TRUE;
            $config['quality'] = '50%';
            $config['width'] = 600;
            $config['height'] = 400;
            $config['new_image'] = './assets/upload/file_kendaraan/kiri/' . $kiri['file_name'];
            $this->load->library('image_lib', $config, 'resizekiri');
            $res = $this->resizekiri->resize();
            $nama_kiri = $kiri['file_name'];
        }
        if (!empty($_FILES['kanan']['name'])) {
            $config['upload_path'] = './assets/upload/file_kendaraan/kanan/'; //path folder
            $config['allowed_types'] = 'jpg|png|jpeg|jfif'; //type yang dapat diakses bisa anda sesuaikan
            // $config['overwrite'] = TRUE; //timpa file yang terupload
            $config['remove_spaces'] = TRUE;
            $config['file_name'] = 'foto_kanan_' . $tipe . '_' . $no_pol . '_' . $tgl . '_' . uniqid();

            $this->load->library('upload', $config, 'kanan');
            $this->kanan->initialize($config);
            $this->kanan->do_upload('kanan');
            $kanan = $this->kanan->data();
            //compress file
            $config['image_library'] = 'gd2';
            $config['source_image'] = './assets/upload/file_kendaraan/kanan/' . $kanan['file_name'];
            $config['create_thumb'] = FALSE;
            $config['maintain_ratio'] = TRUE;
            $config['quality'] = '50%';
            $config['width'] = 600;
            $config['height'] = 400;
            $config['new_image'] = './assets/upload/file_kendaraan/kanan/' . $kanan['file_name'];
            $this->load->library('image_lib', $config, 'resizekanan');
            $res = $this->resizekanan->resize();
            $nama_kanan = $kanan['file_name'];
        }
        if (!empty($_FILES['depan']['name']) && !empty($_FILES['blkg']['name']) && !empty($_FILES['kiri']['name']) && !empty($_FILES['kanan']['name'])) {
            $simpan = $this->home_m->tambahriwayatkendaraan($nama_dpn, $nama_blkg, $nama_kiri, $nama_kanan, $idk);
            if ($simpan) {
                $this->session->set_flashdata('success', 'Tambah Riwayat Kondisi Kendaraan Berhasil');
                redirect('home/riwayat_kondisi?id=' . $idk);
            } else {
                $this->session->set_flashdata('danger', 'Tambah Riwayat Kondisi Kendaraan gagal');
                $data['post'] = $this->input->post();
            }
        } else {
            if (isset($nama_dpn)) {
                unlink('./assets/upload/file_kendaraan/depan/' . $nama_dpn);
            }
            if (isset($nama_blkg)) {
                unlink('./assets/upload/file_kendaraan/belakang/' . $nama_blkg);
            }
            if (isset($nama_kiri)) {
                unlink('./assets/upload/file_kendaraan/kiri/' . $nama_kiri);
            }
            if (isset($nama_kanan)) {
                unlink('./assets/upload/file_kendaraan/kanan/' . $nama_kanan);
            }
            $this->session->set_flashdata('danger', 'Tambah Riwayat Kondisi Kendaraan gagal, Silahkan lengkapi kelengkapan data anda');
            redirect('home/riwayat_kondisi?id=' . $idk . '');
            $data['post'] = $this->input->post();
        }
    }

    public function hapusriwayatkondisi()
    {
        $idrk = $this->input->get('id');
        $simpan = $this->home_m->hapusriwayatkondisi($idrk);
        if ($simpan) {
            $this->session->set_flashdata('success', 'Hapus Riwayat Kendaraan Berhasil');
            redirect('home/riwayat_kondisi?id=' . $simpan . '');
        } else {
            $this->session->set_flashdata('danger', 'Hapus Riwayat Kendaraan gagal');
            redirect('home/riwayat_kondisi?id=' . $simpan . '');
        }
    }
    public function prosestambahPemakai()
    {
        $idk = $this->input->get('id');
        $kend = $this->home_m->kendaraanByid($idk);
        $nopol = $kend['no_polisi'];
        $id_kend = $kend['idk'];
        $nip = $this->input->post('nip');
        $id_nama_pemakai = $this->input->post('nama');
        $cekkendaraan = $this->home_m->data_riwayatpemakaibynopolandstatus($id_kend);
        $cekpemakai = $this->home_m->data_riwayatpemakaibypilihanpemakai($id_nama_pemakai);
        if ($cekkendaraan != '') {
            $this->session->set_flashdata('danger', 'Tambah Riwayat Pemakai gagal, Kendaraan sudah terpakai ');
            redirect('home/riwayat_pemakai?id=' . $idk . '');
        }
        // else if ($cekpemakai != '') {
        //     $this->session->set_flashdata('danger', 'Tambah Riwayat Pemakai gagal, Pemakai yang Anda inputkan sudah memiliki kendaraan aktif ');
        //     redirect('home/riwayat_pemakai?id=' . $idk . '');
        // } 
        else {
            if ($this->home_m->prosestambahPemakai($idk)) {
                $this->session->set_flashdata('success', 'Tambah Riwayat Pemakai Berhasil');
                redirect('home/riwayat_pemakai?id=' . $idk . '');
            } else {
                $this->session->set_flashdata('danger', 'Tambah Riwayat Pemakai gagal');
                redirect('home/riwayat_pemakai?id=' . $idk . '');
            }
        }
    }
    public function proseseditPemakai()
    {
        $idk = $this->input->get('id');
        $id_kend = $this->input->post('id_kend');
        if ($this->home_m->proseseditPemakai($idk)) {
            $this->session->set_flashdata('success', 'Edit Riwayat Pemakai Berhasil');
            redirect('home/riwayat_pemakai?id=' . $id_kend . '');
        } else {
            $this->session->set_flashdata('danger', 'Edit Riwayat Pemakai gagal');
            redirect('home/riwayat_pemakai?id=' . $id_kend . '');
        }
    }

    public function aktifkanpemakai()
    {
        $id = $this->input->get('id');
        $kend = $this->home_m->data_riwayatpemakaibyidrp($id);
        $id_kend = $kend['id_kendaraan'];
        $cekpemakai = $this->home_m->data_riwayatpemakaibynopolandstatus($id_kend);
        if ($cekpemakai != '') {
            $this->session->set_flashdata('danger', 'Aktifkan Pemakai gagal, Kendaaraan sudah terpakai');
            redirect('home/riwayat_pemakai?id=' . $kend['id_kendaraan'] . '');
        } else {
            if ($this->home_m->aktifkanpemakai($id, $id_kend)) {
                $this->session->set_flashdata('success', 'Aktifkan Pemakai Berhasil');
                redirect('home/riwayat_pemakai?id=' . $kend['id_kendaraan'] . '');
            } else {
                $this->session->set_flashdata('warning', 'Aktifkan Pemakai gagal');
                redirect('home/riwayat_pemakai?id=' . $kend['id_kendaraan'] . '');
            }
        }
    }
    public function nonaktifkanpemakai()
    {
        $id = $this->input->get('id');
        $kend = $this->home_m->data_riwayatpemakaibyidrp($id);
        if ($this->home_m->nonaktifkanpemakai($id)) {
            $this->session->set_flashdata('success', 'Nonaktifkan Pemakai Berhasil');
            redirect('home/riwayat_pemakai?id=' . $kend['id_kendaraan'] . '');
        } else {
            $this->session->set_flashdata('warning', 'Nonaktifkan Pemakai gagal');
            redirect('home/riwayat_pemakai?id=' . $kend['id_kendaraan'] . '');
        }
    }
    public function delete_pemakai()
    {
        $id = ($this->input->get('id'));
        $kend = $this->home_m->data_riwayatpemakaibyidrp($id);
        $id_kend = $kend['id_kendaraan'];
        if ($this->home_m->hapus_pemakai($id)) {
            $this->session->set_flashdata('success', 'Hapus Data Pemakai Berhasil');
            redirect('home/riwayat_pemakai?id=' . $id_kend . '');
        } else {
            $this->session->set_flashdata('danger', 'Hapus Data Pemakai gagal');
            redirect('home/riwayat_pemakai?id=' . $id_kend . '');
        }
    }
    public function print_data_kendaraan()
    {
        check_level_admin();
        $id = $this->input->get('id');
        $cek_id = $this->home_m->cek_id_riwayat_servis($id);
        if ($cek_id != '') {
            $data = [];
            $data['title'] = "Data Kendaraan Dinas";
            $data['kend'] = $this->home_m->datasummary_kendaraanbyid($id);
            $data['kondisi'] = $this->home_m->datasummary_riwayatkondisibyid($id);
            $data['bbm'] = $this->home_m->datasummary_riwayatbbmbyid($id);
            $data['pajak'] = $this->home_m->datasummary_riwayatpajakbyid($id);
            $data['servis'] = $this->home_m->datasummary_riwayatservisbyid($id);
            $this->load->view('admin/template/header_print');
            $this->load->view('admin/print/data_kendaraan', $data);
            $this->load->view('admin/template/footer_print');
        } else {
            show_404();
        }
    }
    public function pengajuan_servis()
    {
        $id = $this->input->get('id');
        $tahun = date('Y');
        $cek_id = $this->home_m->cek_id_riwayat_servis($id);
        if ($cek_id != '') {
            $data = [];
            $data['rp'] = $this->home_m->data_riwayatpengajuanservis_admin($id);
            $data['pmk'] = $this->home_m->pemakaiKendById($id);
            $data['kend'] = $this->home_m->kendaraanByid($id);
            $data['pagu'] = $this->home_m->pagukendaraanById($id, $tahun);
            $data['title'] = 'Form Pengajuan Servis Kendaraan Dinas';
            $this->load->view('admin/template/header');
            $this->load->view('admin/servis/pengajuan/pengajuanservis', $data);
            $this->load->view('admin/template/modal');
            $this->load->view('admin/template/footer');
        } else {
            show_404();
        }
    }
    public function editpengajuanservis()
    {
        $id_pen = $this->input->get('id');
        $tahun = date('Y');
        $cek_id = $this->home_m->cek_id_edit_riwayat_pengajuan_servis($id_pen);
        if ($cek_id != '') {
            $data = [];
            $data['rp'] = $this->home_m->data_riwayatpengajuanservis_pemakaibyidpen($id_pen);
            $id_kend = $data['rp']['id_kendaraan'];
            $data['pmk'] = $this->home_m->pemakaiKendById($id_kend);
            $data['kend'] = $this->home_m->kendaraanByid($id_kend);
            $data['pagu'] = $this->home_m->pagukendaraanById($id_kend, $tahun);
            $data['title'] = 'Form Edit Pengajuan Servis Kendaraan Dinas';
            $this->load->view('admin/template/header');
            $this->load->view('admin/servis/pengajuan/editpengajuanservis', $data);
            $this->load->view('admin/template/footer');
        } else {
            show_404();
        }
    }
    public function prosestambahpengajuanservis()
    {
        $idkend = $this->input->get('id');
        if ($this->input->post()) {
            $cekpengajuan = $this->home_m->cek_data_pengajuan($idkend);
            if ($cekpengajuan['status_pengajuan'] == 'Wait') {
                $this->session->set_flashdata('danger', 'Anda sudah melakukan input pengajuan. Silakan menunggu proses verifikasi oleh Admin');
                redirect('home/pengajuan_servis?id=' . $idkend);
            } else {
                if ($this->home_m->tambahpengajuanservis($idkend)) {
                    $this->session->set_flashdata('success', 'Tambah Pengajuan Servis Kendaraan Berhasil. Silakan Menunggu Proses Persetujuan dari Admin');
                    redirect('home/pengajuan_servis?id=' . $idkend . '');
                } else {
                    $this->session->set_flashdata('danger', 'Tambah Pengajuan Servis Kendaraan gagal');
                    redirect('home/pengajuan_servis?id=' . $idkend . '');
                }
            }
        }
    }
    public function proseseditpengajuanservis()
    {
        $id_pen = $this->input->get('id');
        $idkend = $this->input->get('id_kend');
        if ($this->input->post()) {
            if ($this->home_m->editpengajuanservis($id_pen)) {
                $this->session->set_flashdata('success', 'Edit Pengajuan Servis Kendaraan Berhasil. Silakan Menunggu Proses Persetujuan dari Admin');
                redirect('home/pengajuan_servis?id=' . $idkend . '');
            } else {
                $this->session->set_flashdata('danger', 'Edit Pengajuan Servis Kendaraan gagal');
                redirect('home/pengajuan_servis?id=' . $idkend . '');
            }
        }
    }
    public function cetakpengajuanservis()
    {
        $id_pengajuan = $this->input->get('id');
        $id_kend = $this->input->get('idkend');
        $cek_id = $this->home_m->cek_id_riwayat_pengajuan($id_pengajuan, $id_kend);
        if ($cek_id != '') {
            if ($cek_id['status_pengajuan'] == 'Yes') {
                $data = [];
                $data['title'] = "Cetak Pengajuan Servis Kendaraan Dinas";
                $data['kend'] = $this->home_m->datasummary_kendaraanbyid($id_kend);
                $data['pengajuan'] = $this->home_m->data_riwayatpengajuanbyidrp($id_pengajuan);
                $data['admin'] = $this->home_m->pengajuan_admin($id_pengajuan);
                $this->load->view('pemakai/template/header_print');
                $this->load->view('pemakai/kendaraan/servis/cetakpengajuan', $data);
                $this->load->view('pemakai/template/footer_print');
            } else {
                show_404();
            }
        } else {
            show_404();
        }
    }
    public function approve_pengajuan()
    {
        $id = $this->input->get('id');
        $kend = $this->home_m->data_riwayatpengajuanbyidrp($id);
        $id_kend = $kend['id_kendaraan'];
        if ($this->home_m->approve_pengajuan($id)) {
            $this->session->set_flashdata('success', 'Pengajuan Servis Berhasil Disetujui');
            redirect('home/pengajuan_servis?id=' . $id_kend . '');
        } else {
            $this->session->set_flashdata('danger', 'Gagal Menyetujui Pengajuan Servis');
            redirect('home/pengajuan_servis?id=' . $id_kend . '');
        }
    }
    public function reject_pengajuan()
    {
        $id = $this->input->get('id');
        $kend = $this->home_m->data_riwayatpengajuanbyidrp($id);
        $id_kend = $kend['id_kendaraan'];
        if ($this->home_m->reject_pengajuan($id)) {
            $this->session->set_flashdata('success', 'Pengajuan Servis Berhasil Ditolak');
            redirect('home/pengajuan_servis?id=' . $id_kend . '');
        } else {
            $this->session->set_flashdata('danger', 'Gagal menolak Pengajuan Servis');
            redirect('home/pengajuan_servis?id=' . $id_kend . '');
        }
    }
    public function wait_pengajuan()
    {
        $id = $this->input->get('id');
        $kend = $this->home_m->data_riwayatpengajuanbyidrp($id);
        $id_kend = $kend['id_kendaraan'];
        if ($this->home_m->wait_pengajuan($id)) {
            $this->session->set_flashdata('success', 'Pengajuan Servis Berhasil Diubah menjadi menunggu');
            redirect('home/pengajuan_servis?id=' . $id_kend . '');
        } else {
            $this->session->set_flashdata('danger', 'Gagal mengubah Pengajuan Servis');
            redirect('home/pengajuan_servis?id=' . $id_kend . '');
        }
    }
    public function deletepengajuanservis()
    {
        $id = ($this->input->get('id'));
        $kend = $this->home_m->data_riwayatpengajuanbyidrp($id);
        $id_kend = $kend['id_kendaraan'];
        if ($this->home_m->hapus_data_pengajuan($id)) {
            $this->session->set_flashdata('success', 'Hapus Data Pengajuan Berhasil');
            redirect('home/pengajuan_servis?id=' . $id_kend . '');
        } else {
            $this->session->set_flashdata('danger', 'Hapus Data Pengajuan gagal');
            redirect('home/pengajuan_servis?id=' . $id_kend . '');
        }
    }
    public function approve_riwayatkondisi()
    {
        $id = $this->input->get('id');
        $kend = $this->home_m->data_riwayatKondisibyid($id);
        $id_kend = $kend['id_kendaraan'];
        if ($this->home_m->approve_rk($id)) {
            $this->session->set_flashdata('success', 'Data Kondisi Berhasil Disetujui');
            redirect('home/riwayat_kondisi?id=' . $id_kend . '');
        } else {
            $this->session->set_flashdata('danger', 'Gagal Menyetujui Data Kondisi');
            redirect('home/riwayat_kondisi?id=' . $id_kend . '');
        }
    }
    public function reject_riwayatkondisi()
    {
        $id = $this->input->get('id');
        $kend = $this->home_m->data_riwayatKondisibyid($id);
        $id_kend = $kend['id_kendaraan'];
        if ($this->home_m->reject_rk($id)) {
            $this->session->set_flashdata('success', 'Data Kondisi Berhasil Ditolak');
            redirect('home/riwayat_kondisi?id=' . $id_kend . '');
        } else {
            $this->session->set_flashdata('danger', 'Gagal menolak Data Kondisi');
            redirect('home/riwayat_kondisi?id=' . $id_kend . '');
        }
    }
    public function wait_riwayatkondisi()
    {
        $id = $this->input->get('id');
        $kend = $this->home_m->data_riwayatKondisibyid($id);
        $id_kend = $kend['id_kendaraan'];
        if ($this->home_m->wait_rk($id)) {
            $this->session->set_flashdata('success', 'Data Kondisi Berhasil Diubah menjadi menunggu');
            redirect('home/riwayat_kondisi?id=' . $id_kend . '');
        } else {
            $this->session->set_flashdata('danger', 'Gagal mengubah Data Kondisi');
            redirect('home/riwayat_kondisi?id=' . $id_kend . '');
        }
    }
    public function approve_riwayatbbm()
    {
        $id = $this->input->get('id');
        $kend = $this->home_m->data_riwayatBBMbyid($id);
        $id_kend = $kend['id_kendaraan'];
        if ($this->home_m->approve_rbm($id)) {
            $this->session->set_flashdata('success', 'Data BBM Berhasil Disetujui');
            redirect('home/riwayat_bbm?id=' . $id_kend . '');
        } else {
            $this->session->set_flashdata('danger', 'Gagal Menyetujui Data BBM');
            redirect('home/riwayat_bbm?id=' . $id_kend . '');
        }
    }
    public function reject_riwayatbbm()
    {
        $id = $this->input->get('id');
        $kend = $this->home_m->data_riwayatBBMbyid($id);
        $id_kend = $kend['id_kendaraan'];
        if ($this->home_m->reject_rbm($id)) {
            $this->session->set_flashdata('success', 'Data BBM Berhasil Ditolak');
            redirect('home/riwayat_bbm?id=' . $id_kend . '');
        } else {
            $this->session->set_flashdata('danger', 'Gagal menolak Data BBM');
            redirect('home/riwayat_bbm?id=' . $id_kend . '');
        }
    }
    public function wait_riwayatbbm()
    {
        $id = $this->input->get('id');
        $kend = $this->home_m->data_riwayatBBMbyid($id);
        $id_kend = $kend['id_kendaraan'];
        if ($this->home_m->wait_rbm($id)) {
            $this->session->set_flashdata('success', 'Data BBM Berhasil Diubah menjadi menunggu');
            redirect('home/riwayat_bbm?id=' . $id_kend . '');
        } else {
            $this->session->set_flashdata('danger', 'Gagal mengubah Data BBM');
            redirect('home/riwayat_bbm?id=' . $id_kend . '');
        }
    }
    public function approve_riwayatpajak()
    {
        $id = $this->input->get('id');
        $kend = $this->home_m->data_riwayatPajakbyid($id);
        $id_kend = $kend['id_kendaraan'];
        if ($this->home_m->approve_pjk($id)) {
            $this->session->set_flashdata('success', 'Data Pajak Berhasil Disetujui');
            redirect('home/riwayat_pajak?id=' . $id_kend . '');
        } else {
            $this->session->set_flashdata('danger', 'Gagal Menyetujui Data Pajak');
            redirect('home/riwayat_pajak?id=' . $id_kend . '');
        }
    }
    public function reject_riwayatpajak()
    {
        $id = $this->input->get('id');
        $kend = $this->home_m->data_riwayatPajakbyid($id);
        $id_kend = $kend['id_kendaraan'];
        if ($this->home_m->reject_pjk($id)) {
            $this->session->set_flashdata('success', 'Data Pajak Berhasil Ditolak');
            redirect('home/riwayat_pajak?id=' . $id_kend . '');
        } else {
            $this->session->set_flashdata('danger', 'Gagal menolak Data Pajak');
            redirect('home/riwayat_pajak?id=' . $id_kend . '');
        }
    }
    public function wait_riwayatpajak()
    {
        $id = $this->input->get('id');
        $kend = $this->home_m->data_riwayatPajakbyid($id);
        $id_kend = $kend['id_kendaraan'];
        if ($this->home_m->wait_pjk($id)) {
            $this->session->set_flashdata('success', 'Data Pajak Berhasil Diubah menjadi menunggu');
            redirect('home/riwayat_pajak?id=' . $id_kend . '');
        } else {
            $this->session->set_flashdata('danger', 'Gagal mengubah Data Pajak');
            redirect('home/riwayat_pajak?id=' . $id_kend . '');
        }
    }
    public function approve_servis()
    {
        $id = $this->input->get('id');
        $kend = $this->home_m->data_riwayatservisbyidrp($id);
        $id_kend = $kend['id_kendaraan'];
        if ($this->home_m->approve_servis($id)) {
            $this->session->set_flashdata('success', 'Data Servis Berhasil Disetujui');
            redirect('home/riwayat_servis?id=' . $id_kend . '');
        } else {
            $this->session->set_flashdata('warning', 'Gagal Menyetujui Data Servis');
            redirect('home/riwayat_servis?id=' . $id_kend . '');
        }
    }
    public function reject_servis()
    {
        $id = $this->input->get('id');
        $kend = $this->home_m->data_riwayatservisbyidrp($id);
        $id_kend = $kend['id_kendaraan'];
        if ($this->home_m->reject_servis($id)) {
            $this->session->set_flashdata('success', 'Data Servis Berhasil Ditolak');
            redirect('home/riwayat_servis?id=' . $id_kend . '');
        } else {
            $this->session->set_flashdata('warning', 'Gagal Menolak Data Servis');
            redirect('home/riwayat_servis?id=' . $id_kend . '');
        }
    }
    public function wait_servis()
    {
        $id = $this->input->get('id');
        $kend = $this->home_m->data_riwayatservisbyidrp($id);
        $id_kend = $kend['id_kendaraan'];
        if ($this->home_m->wait_servis($id)) {
            $this->session->set_flashdata('success', 'Data Servis Berhasil Diubah menjadi menunggu');
            redirect('home/riwayat_servis?id=' . $id_kend . '');
        } else {
            $this->session->set_flashdata('danger', 'Gagal mengubah Data Servis');
            redirect('home/riwayat_servis?id=' . $id_kend . '');
        }
    }
}