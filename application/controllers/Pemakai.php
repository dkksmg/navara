<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pemakai extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        check_session();
        $this->load->model('home_m');
    }
    public function index()
    {
        $id = $this->session->userdata('id');
        $tahun = date('Y');
        $data = [];
        $data['kends'] = $this->home_m->kendaraanUser($id, $tahun);
        $data['pagu'] = $this->home_m->cek_datapagu($id, $tahun);
        $this->load->view('pemakai/template/headeruser');
        $this->load->view('pemakai/kendaraan/data_kendaraan_pemakai', $data);
        $this->load->view('pemakai/template/footeruser');
    }

    public function riwayatkondisi()
    {
        $id = $this->input->get('id');
        $tahun = date('Y');
        // $cek_id_kondisi = $this->home_m->cek_id_riwayat_kondisi($id);
        $id_user = $this->session->userdata('id');
        $cek = $this->home_m->cekkendaraanUser($id_user);
        $found = false;
        foreach ($cek as $ck) {
            if (in_array($id, $ck)) {
                $found = true;
                break;
            }
        }


        if ($found === true) {
            $data = [];
            $data['title'] = 'Riwayat Kondisi Kendaraan Dinas';
            $data['rk'] = $this->home_m->data_riwayatKondisi($id);
            $data['kend'] = $this->home_m->kendaraanByidwithpagu($id, $tahun);
            // print_r($this->db->last_query());
            $this->load->view('pemakai/template/headeruser');
            $this->load->view('pemakai/kendaraan/kondisi/riwayatkondisi', $data);
            $this->load->view('pemakai/template/modal');
            $this->load->view('pemakai/template/footeruser');
        } else {
            show_404();
        }
    }
    public function prosestambahkondisi()
    {
        $data = [];
        $idk = $this->input->get('id');
        $tgl = date('Y-m-d');
        $tipe = $this->input->post('tipe');
        $no_pol = $this->input->post('no_pol');
        $cekrk = $this->home_m->cek_data_rk($idk);
        if ($cekrk['status_rk'] == 'Wait') {
            $this->session->set_flashdata('danger', 'Anda sudah melakukan input Riwayat Kondisi. Silakan menunggu proses verifikasi oleh Admin');
            redirect('pemakai/riwayatkondisi?id=' . $idk);
        } else {
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
                    $this->session->set_flashdata('success', 'Tambah Riwayat Kondisi Kendaraan Berhasil. Silakan menunggu proses verifikasi oleh Admin');
                    redirect('pemakai/riwayatkondisi?id=' . $idk);
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
                redirect('pemakai/riwayatkondisi?id=' . $idk . '');
                $data['post'] = $this->input->post();
            }
        }
    }
    public function editriwayatkondisi()
    {
        $id = $this->input->get('id');
        $idkend = $this->input->get('idkend');
        $tahun = date('Y');
        $id_user = $this->session->userdata('id');
        $cek_edit = $this->home_m->cekkendaraanUserwithriwayatkondisi($id_user, $id);
        $found = false;
        foreach ($cek_edit as $ck) {
            if (in_array($idkend, $ck)) {
                $found = true;
                break;
            }
        }
        if ($found == true) {
            $data = [];
            $data['title'] = 'Edit Riwayat Kondisi Kendaraan';
            $data['value'] = $this->home_m->data_kondisiById($id);
            $data['kend'] = $this->home_m->kendaraanByidwithpagu($idkend, $tahun);
            $this->load->view('pemakai/template/headeruser');
            $this->load->view('pemakai/kendaraan/kondisi/editriwayatkondisi', $data);
            $this->load->view('pemakai/template/footeruser');
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
                redirect('pemakai/riwayatkondisi?id=' . $idk . '');
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
                redirect('pemakai/riwayatkondisi?id=' . $idk . '');
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
                redirect('pemakai/riwayatkondisi?id=' . $idk . '');
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
                redirect('pemakai/riwayatkondisi?id=' . $idk . '');
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
                redirect('pemakai/riwayatkondisi?id=' . $idk . '');
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
                redirect('pemakai/riwayatkondisi?id=' . $idk . '');
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
                redirect('pemakai/riwayatkondisi?id=' . $idk . '');
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
                redirect('pemakai/riwayatkondisi?id=' . $idk . '');
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
                redirect('pemakai/riwayatkondisi?id=' . $idk . '');
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
                redirect('pemakai/riwayatkondisi?id=' . $idk . '');
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
                redirect('pemakai/riwayatkondisi?id=' . $idk . '');
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
                redirect('pemakai/riwayatkondisi?id=' . $idk . '');
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
                redirect('pemakai/riwayatkondisi?id=' . $idk . '');
            } else {
                $this->session->set_flashdata('danger', 'Update Riwayat Kondisi Kendaraan gagal');
                $data['post'] = $this->input->post();
            }
        } else if (empty($_FILES['depan']['name'])) {
            $nama_dpn = $this->input->post('old_depan');;
            $simpan = $this->home_m->updateriwayatkondisikendaraan($nama_dpn, $nama_blkg, $nama_kiri, $nama_kanan, $id_rk);
            if ($simpan) {
                $this->session->set_flashdata('success', 'Update Riwayat Kondisi Kendaraan Berhasil. Silakan menunggu proses verifikasi oleh Admin');
                redirect('pemakai/riwayatkondisi?id=' . $idk . '');
            } else {
                $this->session->set_flashdata('danger', 'Update Riwayat Kondisi Kendaraan gagal');
                $data['post'] = $this->input->post();
            }
        } else if (empty($_FILES['blkg']['name'])) {
            $nama_blkg = $this->input->post('old_belakang');;
            $simpan = $this->home_m->updateriwayatkondisikendaraan($nama_dpn, $nama_blkg, $nama_kiri, $nama_kanan, $id_rk);
            if ($simpan) {
                $this->session->set_flashdata('success', 'Update Riwayat Kondisi Kendaraan Berhasil. Silakan menunggu proses verifikasi oleh Admin');
                redirect('pemakai/riwayatkondisi?id=' . $idk . '');
            } else {
                $this->session->set_flashdata('danger', 'Update Riwayat Kondisi Kendaraan gagal');
                $data['post'] = $this->input->post();
            }
        } else if (empty($_FILES['kiri']['name'])) {
            $nama_kiri = $this->input->post('old_kiri');;
            $simpan = $this->home_m->updateriwayatkondisikendaraan($nama_dpn, $nama_blkg, $nama_kiri, $nama_kanan, $id_rk);
            if ($simpan) {
                $this->session->set_flashdata('success', 'Update Riwayat Kondisi Kendaraan Berhasil. Silakan menunggu proses verifikasi oleh Admin');
                redirect('pemakai/riwayatkondisi?id=' . $idk . '');
            } else {
                $this->session->set_flashdata('danger', 'Update Riwayat Kondisi Kendaraan gagal');
                $data['post'] = $this->input->post();
            }
        } else if (empty($_FILES['kanan']['name'])) {
            $nama_kanan = $this->input->post('old_kanan');;
            $simpan = $this->home_m->updateriwayatkondisikendaraan($nama_dpn, $nama_blkg, $nama_kiri, $nama_kanan, $id_rk);
            if ($simpan) {
                $this->session->set_flashdata('success', 'Update Riwayat Kondisi Kendaraan Berhasil. Silakan menunggu proses verifikasi oleh Admin');
                redirect('pemakai/riwayatkondisi?id=' . $idk . '');
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
                redirect('pemakai/riwayatkondisi?id=' . $idk . '');
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
            redirect('pemakai/riwayatkondisi?id=' . $idk . '');
            $data['post'] = $this->input->post();
        }
    }
    public function hapusriwayatkondisi()
    {
        $idrk = $this->input->get('id');
        $simpan = $this->home_m->hapusriwayatkondisi($idrk);
        if ($simpan) {
            $this->session->set_flashdata('success', 'Hapus Riwayat Kendaraan Berhasil');
            redirect('pemakai/riwayatkondisi?id=' . $simpan . '');
        } else {
            $this->session->set_flashdata('danger', 'Hapus Riwayat Kendaraan gagal');
            redirect('pemakai/riwayatkondisi?id=' . $simpan . '');
        }
    }
    public function riwayatservis()
    {
        $id = $this->input->get('id');
        $tahun = date('Y');
        $cek_id_kondisi = $this->home_m->cek_id_riwayat_servis($id);
        $id_user = $this->session->userdata('id');
        $cek = $this->home_m->cekkendaraanUser($id_user);

        $found = false;
        foreach ($cek as $ck) {
            // echo $ck['id_kendaraan'];
            if (in_array($id, $ck)) {
                $found = true;
                break;
            }
        }
        if ($found == true) {
            $data = [];
            $data['title'] = 'Riwayat Servis Kendaraan Dinas';
            $data['rs'] = $this->home_m->data_riwayatservis($id);
            $data['kend'] = $this->home_m->kendaraanByidwithpagu($id, $tahun);
            $this->load->view('pemakai/template/headeruser');
            $this->load->view('pemakai/kendaraan/servis/riwayatservis', $data);
            $this->load->view('pemakai/template/modal');
            $this->load->view('pemakai/template/footeruser');
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
            redirect('pemakai/riwayatservis?id=' . $idk);
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
                    redirect('pemakai/riwayatservis?id=' . $idk . '');
                } else {
                    $this->session->set_flashdata('danger', 'Tambah Riwayat Service Kendaraan gagal');
                    $data['post'] = $this->input->post();
                }
            } else {
                if (isset($nama_dpn)) {
                    unlink('./assets/foto_servis/' . $namafoto);
                }
                $this->session->set_flashdata('danger', 'Tambah Riwayat Service Kendaraan gagal, Silahkan lengkapi kelengkapan data anda');
                redirect('pemakai/riwayatservis?id=' . $idk . '');
                $data['post'] = $this->input->post();
            }
        }
    }
    public function editriwayatservis()
    {
        $id_rs = $this->input->get('id');
        $id = $this->input->get('idkend');
        $tahun = date('Y');
        $id_user = $this->session->userdata('id');
        $cek_edit = $this->home_m->cekkendaraanUserwithriwayatservis($id_user, $id_rs);
        $found = false;
        foreach ($cek_edit as $ck) {
            if (in_array($id, $ck)) {
                $found = true;
                break;
            }
        }
        if ($found == true) {
            $data = [];
            $data['title'] = "Edit Riwayat Servis Kendaraan";
            $data['servis'] = $this->home_m->data_servisById($id_rs);
            $data['kend'] = $this->home_m->kendaraanByidwithpagu($id, $tahun);
            $this->load->view('pemakai/template/headeruser');
            $this->load->view('pemakai/kendaraan/servis/editriwayatservis', $data);
            $this->load->view('pemakai/template/footeruser');
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
                redirect('pemakai/riwayatservis?id=' . $idk . '');
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
                redirect('pemakai/riwayatservis?id=' . $idk . '');
            } else {
                $this->session->set_flashdata('danger', 'Edit Riwayat Service Kendaraan gagal');
                $data['post'] = $this->input->post();
            }
        } else if (empty($_FILES['nota']['name'])) {
            $namanota = $this->input->post('old_nota');
            $simpan = $this->home_m->updateriwayatserviskendaraan($namafoto, $id_rs, $namanota);
            if ($simpan) {
                $this->session->set_flashdata('success', 'Edit Riwayat Service Kendaraan Berhasil');
                redirect('pemakai/riwayatservis?id=' . $idk . '');
            } else {
                $this->session->set_flashdata('danger', 'Edit Riwayat Service Kendaraan gagal');
                $data['post'] = $this->input->post();
            }
        } else if (empty($_FILES['nota']['foto'])) {
            $namafoto = $this->input->post('old_servis');
            $simpan = $this->home_m->updateriwayatserviskendaraan($namafoto, $id_rs, $namanota);
            if ($simpan) {
                $this->session->set_flashdata('success', 'Edit Riwayat Service Kendaraan Berhasil');
                redirect('pemakai/riwayatservis?id=' . $idk . '');
            } else {
                $this->session->set_flashdata('danger', 'Edit Riwayat Service Kendaraan gagal');
                $data['post'] = $this->input->post();
            }
        } else {
            if (isset($nama_dpn)) {
                unlink('./assets/foto_servis/' . $namafoto);
            }
            $this->session->set_flashdata('danger', 'Edit Riwayat Service Kendaraan gagal, Silahkan lengkapi kelengkapan data anda');
            redirect('pemakai/riwayatservis?id=' . $idk . '');
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
    public function riwayatbbm()
    {
        $id = ($this->input->get('id'));
        $tahun = date('Y');
        $cek_id = $this->home_m->cek_id_riwayat_bbm($id);
        $id_user = $this->session->userdata('id');
        $cek = $this->home_m->cekkendaraanUser($id_user);

        $found = false;
        foreach ($cek as $ck) {

            if (in_array($id, $ck)) {
                $found = true;
                break;
            }
        }
        if ($found == true) {
            $data = [];
            $data['title'] = 'Riwayat BBM Kendaraan Dinas';
            $data['rbbm'] = $this->home_m->data_riwayatbbm($id);
            $data['kend'] = $this->home_m->kendaraanByidwithpagu($id, $tahun);
            $this->load->view('pemakai/template/headeruser');
            $this->load->view('pemakai/kendaraan/bbm/riwayatbbm', $data);
            $this->load->view('pemakai/template/modal');
            $this->load->view('pemakai/template/footeruser');
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
        $cek_rbm = $this->home_m->cek_data_rbm($id_kend);
        // print_r($this->db->last_query());
        // die();
        if ($cek_rbm['status_rbm'] == 'Wait') {
            $this->session->set_flashdata('danger', 'Anda sudah melakukan input Riwayat BBM. Silakan menunggu proses verifikasi oleh Admin');
            redirect('pemakai/riwayatbbm?id=' . $id_kend);
        } else {
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
                    $this->session->set_flashdata('success', 'Tambah Riwayat BBM Kendaraan Berhasil.. Silakan menunggu proses verifikasi oleh Admin');
                    redirect('pemakai/riwayatbbm?id=' . $id_bbm);
                } else {
                    $this->session->set_flashdata('danger', 'Tambah Riwayat BBM Kendaraan gagal');
                    $data['post'] = $this->input->post();
                }
            } else {
                if (isset($nama_struk_bbm)) {
                    unlink('./assets/upload/struk_bbm/' . $nama_struk_bbm);
                }
                $this->session->set_flashdata('danger', 'Tambah Riwayat BBM Kendaraan gagal, Silahkan lengkapi kelengkapan data anda');
                redirect('pemakai/riwayatbbm?id=' . $id_bbm);
                $data['post'] = $this->input->post();
            }
        }
    }
    public function editrbbm()
    {
        $id = ($this->input->get('idkend'));
        $id_bbm = ($this->input->get('id'));
        $tahun = date('Y');
        $id_user = $this->session->userdata('id');
        $cek_edit = $this->home_m->cekkendaraanUserwithriwayatbbm($id_user, $id_bbm);
        $found = false;
        foreach ($cek_edit as $ck) {
            if (in_array($id, $ck)) {
                $found = true;
                break;
            }
        }
        if ($found == true) {
            $data = [];
            $data['title'] = 'Edit Riwayat BBM';
            $data['rbbm'] = $this->home_m->data_riwayatbbm_byid($id_bbm);
            $data['kend'] = $this->home_m->kendaraanByidwithpagu($id, $tahun);
            $this->load->view('pemakai/template/headeruser');
            $this->load->view('pemakai/kendaraan/bbm/editriwayatbbm', $data);
            $this->load->view('pemakai/template/modal');
            $this->load->view('pemakai/template/footeruser');
        } else {
            show_404();
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
                redirect('pemakai/riwayatbbm?id=' . $id_kend);
            } else {
                $this->session->set_flashdata('danger', 'Edit Riwayat BBM Kendaraan gagal');
                $data['post'] = $this->input->post();
            }
        } else if (empty($_FILES['struk_bbm']['name'])) {
            $nama_struk_bbm = ($this->input->post('old_struk'));
            $simpan = $this->home_m->updateriwayatbbm($id_bbm, $nama_struk_bbm);
            if ($simpan) {
                $this->session->set_flashdata('success', 'Edit Riwayat BBM Kendaraan Berhasil');
                redirect('pemakai/riwayatbbm?id=' . $id_kend);
            } else {
                $this->session->set_flashdata('danger', 'Edit Riwayat BBM Kendaraan gagal');
                $data['post'] = $this->input->post();
            }
        } else {
            if (isset($nama_struk_bbm)) {
                unlink('./assets/upload/struk_bbm/' . $nama_struk_bbm);
            }
            $this->session->set_flashdata('danger', 'Edit Riwayat BBM Kendaraan gagal, Silahkan lengkapi kelengkapan data anda');
            redirect('pemakai/riwayatbbm?id=' . $id_kend);
            $data['post'] = $this->input->post();
        }
    }
    public function hapusrbbm()
    {
        $id_bbm = ($this->input->get('id'));
        $id_kend = ($this->input->get('idkend'));
        if ($this->home_m->hapusbbm($id_bbm)) {
            $this->session->set_flashdata('success', 'Hapus Riwayat BBM Kendaraan Berhasil');
            redirect('pemakai/riwayatbbm?id=' . $id_kend);
        } else {
            $this->session->set_flashdata('danger', 'Hapus Riwayat BBM Kendaraan gagal');
            redirect('pemakai/riwayatbbm?id=' . $id_kend);
        }
    }
    public function riwayatpajak()
    {
        $id = $this->input->get('id');
        $tahun = date('Y');
        $id_user = $this->session->userdata('id');
        $cek = $this->home_m->cekkendaraanUser($id_user);

        $found = false;
        foreach ($cek as $ck) {
            // echo $ck['id_kendaraan'];
            if (in_array($id, $ck)) {
                $found = true;
                break;
            }
        }
        if ($found == true) {
            $data = [];
            $data['rp'] = $this->home_m->data_riwayatpajak($id);
            $data['kend'] = $this->home_m->kendaraanByidwithpagu($id, $tahun);
            $data['title'] = 'Riwayat Pajak Kendaraan Dinas';
            $this->load->view('pemakai/template/headeruser');
            $this->load->view('pemakai/kendaraan/pajak/riwayatpajak', $data);
            $this->load->view('pemakai/template/modal');
            $this->load->view('pemakai/template/footeruser');
        } else {
            show_404();
        }
    }
    public function prosestambahpajak()
    {
        $idkend = $this->input->get('id');
        $cek_pajak = $this->home_m->cek_data_pajak($idkend);
        if ($cek_pajak['status_pjk'] == 'Wait') {
            $this->session->set_flashdata('danger', 'Anda sudah melakukan input Riwayat Pajak. Silakan menunggu proses verifikasi oleh Admin');
            redirect('pemakai/riwayatpajak?id=' . $idkend);
        } else {
            if ($this->input->post()) {
                $cektahun = $this->home_m->cek_tahun_pajak($idkend, $this->input->post('tahun_pajak'));
                if ($cektahun != '') {
                    $this->session->set_flashdata('danger', 'Anda sudah menginput pajak untuk tahun ' . $this->input->post('tahun_pajak'));
                    redirect('pemakai/riwayatpajak?id=' . $idkend . '');
                } else {
                    if ($this->home_m->tambahriwayatpajak($idkend)) {
                        $this->session->set_flashdata('success', 'Tambah Riwayat Pajak Kendaraan Berhasil. Silakan menunggu proses verifikasi oleh Admin');
                        redirect('pemakai/riwayatpajak?id=' . $idkend . '');
                    } else {
                        $this->session->set_flashdata('danger', 'Tambah Riwayat Pajak Kendaraan gagal');
                        redirect('pemakai/riwayatpajak?id=' . $idkend . '');
                    }
                }
            }
        }
    }
    public function editriwayatpajak()
    {
        $id_pjk = $this->input->get('id');
        $id = $this->input->get('idkend');
        $tahun = date('Y');
        $id_user = $this->session->userdata('id');
        $cek_edit = $this->home_m->cekkendaraanUserwithriwayatpajak($id_user, $id_pjk);
        $found = false;
        foreach ($cek_edit as $ck) {
            if (in_array($id, $ck)) {
                $found = true;
                break;
            }
        }
        if ($found == true) {
            $data = [];
            $data['rp'] = $this->home_m->data_riwayatpajak($id_pjk);
            $data['value'] = $this->home_m->datapajakById($id_pjk);
            $data['kend'] = $this->home_m->kendaraanByidwithpagu($id, $tahun);
            $data['title'] = 'Edit Riwayat Pajak Kendaraan Dinas';
            $this->load->view('pemakai/template/headeruser');
            $this->load->view('pemakai/kendaraan/pajak/editriwayatpajak', $data);
            $this->load->view('pemakai/template/footeruser');
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
                redirect('pemakai/riwayatpajak?id=' . $id_kend);
            } else {
                if ($this->home_m->updateriwayatpajak($id_pjk)) {
                    $this->session->set_flashdata('success', 'Edit Riwayat Pajak Kendaraan Berhasil');
                    redirect('pemakai/riwayatpajak?id=' . $id_kend . '');
                } else {
                    $this->session->set_flashdata('danger', 'Edit Riwayat Pajak Kendaraan gagal');
                    redirect('pemakai/riwayatpajak?id=' . $id_kend . '');
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
    public function pengajuanservis()
    {
        $id = $this->input->get('id');
        $tahun = date('Y');
        $cek_id = $this->home_m->cek_id_riwayat_pengajuan_servis($id);
        $id_user = $this->session->userdata('id');
        $cek = $this->home_m->cekkendaraanUser($id_user);

        $found = false;
        foreach ($cek as $ck) {
            // echo $ck['id_kendaraan'];
            if (in_array($id, $ck)) {
                $found = true;
                break;
            }
        }
        if ($found == true) {
            $data = [];
            $data['rp'] = $this->home_m->data_riwayatpengajuanservis_pemakai($id);
            $data['kend'] = $this->home_m->kendaraanByidwithpagu($id, $tahun);
            $data['title'] = 'Form Pengajuan Servis Kendaraan Dinas';
            $this->load->view('pemakai/template/headeruser');
            $this->load->view('pemakai/kendaraan/servis/pengajuan/pengajuanservis', $data);
            $this->load->view('pemakai/template/modal');
            $this->load->view('pemakai/template/footeruser');
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
                redirect('pemakai/pengajuanservis?id=' . $idkend);
            } else {
                if ($this->home_m->tambahpengajuanservis($idkend)) {
                    $this->session->set_flashdata('success', 'Tambah Pengajuan Servis Kendaraan Berhasil. Silakan Menunggu Proses Persetujuan dari Admin');
                    redirect('pemakai/pengajuanservis?id=' . $idkend . '');
                } else {
                    $this->session->set_flashdata('danger', 'Tambah Pengajuan Servis Kendaraan gagal');
                    redirect('pemakai/pengajuanservis?id=' . $idkend . '');
                }
            }
        }
    }
    public function editpengajuanservis()
    {
        $id_pen = $this->input->get('id');
        $idkend = $this->input->get('idkend');
        $tahun = date('Y');
        $id_user = $this->session->userdata('id');
        $cek_edit = $this->home_m->cekkendaraanUserwithpengajuanservis($id_user, $id_pen);
        $found = false;
        foreach ($cek_edit as $ck) {
            if (in_array($idkend, $ck)) {
                $found = true;
                break;
            }
        }
        if ($found == true) {
            $data = [];
            $data['rp'] = $this->home_m->data_riwayatpengajuanservis_pemakaibyidpen($id_pen);
            $data['kend'] = $this->home_m->kendaraanByidwithpagu($idkend, $tahun);
            $data['title'] = 'Form Edit Pengajuan Servis Kendaraan Dinas';
            $this->load->view('pemakai/template/headeruser');
            $this->load->view('pemakai/kendaraan/servis/pengajuan/editpengajuanservis', $data);
            $this->load->view('pemakai/template/footeruser');
        } else {
            show_404();
        }
    }
    public function proseseditpengajuanservis()
    {
        $id_pen = $this->input->get('id');
        $idkend = $this->input->get('id_kend');
        if ($this->input->post()) {
            if ($this->home_m->editpengajuanservis($id_pen)) {
                $this->session->set_flashdata('success', 'Edit Pengajuan Servis Kendaraan Berhasil. Silakan Menunggu Proses Persetujuan dari Admin');
                redirect('pemakai/pengajuanservis?id=' . $idkend . '');
            } else {
                $this->session->set_flashdata('danger', 'Edit Pengajuan Servis Kendaraan gagal');
                redirect('pemakai/pengajuanservis?id=' . $idkend . '');
            }
        }
    }
    public function cetakpengajuanservis()
    {
        $id_pengajuan = $this->input->get('id');
        $id_kend = $this->input->get('id_kend');
        $cek_id = $this->home_m->cek_id_riwayat_pengajuan($id_pengajuan, $id_kend);
        if ($cek_id != '') {
            if ($cek_id['status_pengajuan'] == 'Yes') {
                $data = [];
                $data['title'] = "Cetak Pengajuan Servis Kendaraan Dinas";
                $data['kend'] = $this->home_m->datasummary_kendaraanbyid($id_kend);
                $data['pengajuan'] = $this->home_m->data_riwayatpengajuanbyidrp($id_pengajuan);
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
}