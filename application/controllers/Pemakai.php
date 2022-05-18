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
        $data = [];
        $data['kend'] = $this->home_m->kendaraanUser($this->session->userdata('id'));
        $this->load->view('pemakai/template/headeruser');
        $this->load->view('pemakai/kendaraan/data_kendaraan_pemakai', $data);
        $this->load->view('pemakai/template/footeruser');
    }

    public function riwayatkondisi()
    {
        $data = [];
        $id = $this->input->get('id');
        $data['title'] = 'Riwayat Kondisi Kendaraan Dinas';
        $data['rk'] = $this->home_m->data_riwayatKondisi($id);
        $data['kend'] = $this->home_m->kendaraanByid($id);
        $this->load->view('pemakai/template/headeruser');
        $this->load->view('pemakai/kendaraan/riwayatkondisi', $data);
        $this->load->view('pemakai/template/modal');
        $this->load->view('pemakai/template/footeruser');
    }
    public function riwayatbbm()
    {
        $data = [];
        $id = $this->input->get('id');
        $data['title'] = 'Riwayat BBM Kendaraan Dinas';
        $data['rbbm'] = $this->home_m->data_riwayatbbm($id);
        $data['kend'] = $this->home_m->kendaraanByid($id);
        $this->load->view('pemakai/template/headeruser');
        $this->load->view('pemakai/kendaraan/riwayatbbm', $data);
        $this->load->view('pemakai/template/modal');
        $this->load->view('pemakai/template/footeruser');
    }
    public function riwayatpajak()
    {
        $data = [];
        $id = $this->input->get('id');
        $data['title'] = 'Riwayat Pajak Kendaraan Dinas';
        $data['rp'] = $this->home_m->data_riwayatpajak($id);
        $data['kend'] = $this->home_m->kendaraanByid($id);
        $this->load->view('pemakai/template/headeruser');
        $this->load->view('pemakai/kendaraan/riwayatpajak', $data);
        $this->load->view('pemakai/template/modal');
        $this->load->view('pemakai/template/footeruser');
    }
    public function riwayatservis()
    {
        $data = [];
        $id = $this->input->get('id');
        $data['title'] = 'Riwayat Servis Kendaraan Dinas';
        $data['rs'] = $this->home_m->data_riwayatservis($id);
        $data['kend'] = $this->home_m->kendaraanByid($id);
        $this->load->view('pemakai/template/headeruser');
        $this->load->view('pemakai/kendaraan/riwayatservis', $data);
        $this->load->view('pemakai/template/modal');
        $this->load->view('pemakai/template/footeruser');
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
        var_dump($nama_blkg, $nama_dpn, $nama_kanan, $nama_kiri);
        die();
        if (!empty($_FILES['depan']['name']) && !empty($_FILES['blkg']['name']) && !empty($_FILES['kiri']['name']) && !empty($_FILES['kanan']['name'])) {
            $simpan = $this->home_m->tambahriwayatkendaraan($nama_dpn, $nama_blkg, $nama_kiri, $nama_kanan, $idk);
            if ($simpan) {
                $this->session->set_flashdata('success', 'Tambah Riwayat Kondisi Kendaraan Berhasil');
                redirect('pemakai/riwayatkondisi');
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
            redirect('pemakai/riwayatkondisi');
            $data['post'] = $this->input->post();
        }
    }
    public function prosestambahservis()
    {

        $idk = $this->input->get('id');
        $tgl = $this->input->post('tgl');
        $tipe = $this->input->post('tipe');
        $no_pol = $this->input->post('no_pol');

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
                $this->session->set_flashdata('success', 'Tambah Riwayat Service Kendaraan Berhasil');
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
        } else {
            if (isset($nama_dpn)) {
                unlink('./assets/foto_servis/' . $namafoto);
            }
            $this->session->set_flashdata('danger', 'Edit Riwayat Service Kendaraan gagal, Silahkan lengkapi kelengkapan data anda');
            redirect('home/riwayat_servis?id=' . $idk . '');
            $data['post'] = $this->input->post();
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
        } else if (empty($_FILES['depan']['name']) && empty($_FILES['blkg']['name']) && empty($_FILES['kiri']['name']) && empty($_FILES['kanan']['name'])) {
            $nama_dpn = $this->input->post('old_depan');
            $nama_blkg = $this->input->post('old_belakang');
            $nama_kiri = $this->input->post('old_kiri');
            $nama_kanan = $this->input->post('old_kanan');
            $simpan = $this->home_m->updateriwayatkondisikendaraan($nama_dpn, $nama_blkg, $nama_kiri, $nama_kanan, $id_rk);
            if ($simpan) {
                $this->session->set_flashdata('success', 'Update Riwayat Kondisi Kendaraan Berhasil');
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
            redirect('pemakai/riwayatkondisi?=' . $idk . '');
            $data['post'] = $this->input->post();
        }
    }


    public function prosestambahbbm()
    {
        $idkend = $this->input->get('id');
        if ($this->input->post()) {
            if ($this->home_m->tambahriwayatbbm($idkend)) {
                $this->session->set_flashdata('success', 'Tambah Riwayat BBM Kendaraan Berhasil');
                redirect('pemakai/riwayatbbm');
            } else {
                $this->session->set_flashdata('danger', 'Tambah Riwayat BBM Kendaraan gagal');
                redirect('pemakai/riwayatbbm');
            }
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
    public function hapusrbbm()
    {
        $id = $this->input->get('id');
        if ($this->home_m->hapusbbm($id)) {
            $this->session->set_flashdata('success', 'Hapus Riwayat BBM Kendaraan Berhasil');
            redirect('pemakai/riwayatbbm');
        } else {
            $this->session->set_flashdata('danger', 'Hapus Riwayat BBM Kendaraan gagal');
            redirect('pemakai/riwayatbbm');
        }
    }
}