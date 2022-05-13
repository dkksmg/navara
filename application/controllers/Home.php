<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        check_session();
        if (!$this->session->userdata('logged_in_admin') !== FALSE) {
            redirect('pemakai');
        }
        $this->load->model('home_m');
    }
    public function index()
    {
        $data = [];
        $data['title'] = 'Data Kendaraan Dinas';
        $data['kendaraan'] = $this->home_m->data_kendaraan();
        $this->load->view('admin/template/header');
        $this->load->view('admin/dataKendaraan', $data);
        $this->load->view('admin/template/modal');
        $this->load->view('admin/template/footer');
    }


    public function tambahKendaraanDinas()
    {

        $data = [];
        $data['title'] = 'Tambah Kendaraan Dinas';
        if ($this->input->post()) {
            if ($this->home_m->tambahKendaraanDinas()) {
                $this->session->set_flashdata('success', 'Tambah Kendaraan Berhasil');
                redirect('home');
            } else {
                $this->session->set_flashdata('danger', 'Tambah Kendaraan gagal');
            }
        }
        $this->load->view('admin/template/header');
        $this->load->view('admin/tambahKendaraanDinas', $data);
        $this->load->view('admin/template/footer');
    }
    public function edit_kendaraan()
    {

        $data = [];
        $data['title'] = 'Edit Kendaraan Dinas';
        $id = $this->input->get('id');
        $data['kend'] = $this->home_m->dataKendaraanByid($id);
        if ($this->input->post()) {
            if ($this->home_m->edit_kendaraan($id)) {
                $this->session->set_flashdata('success', 'Update data Kendaraan Berhasil');
                redirect('home');
            } else {
                $this->session->set_flashdata('danger', 'Update data Kendaraan gagal');
            }
        }
        $this->load->view('admin/template/header');
        $this->load->view('admin/tambahKendaraanDinas', $data);
        $this->load->view('admin/template/footer');
    }

    public function riwayat_kondisi()
    {
        $id = $this->input->get('id');
        $cek_id_kondisi = $this->home_m->cek_id_riwayat_kondisi($id);
        if ($cek_id_kondisi != '') {
            $data = [];
            $data['kend'] = $this->home_m->kendaraanByid($id);
            $data['rk'] = $this->home_m->data_riwayatKondisi($id);
            $this->load->view('admin/template/header');
            $this->load->view('admin/kondisi_kendaraan/riwayatKondisi', $data);
            $this->load->view('admin/template/modal');
            $this->load->view('admin/template/footer');
        } else {
            show_404();
        }
    }
    public function editriwayatkondisi()
    {
        $id = $this->input->get('id');
        $cek_id  = $this->home_m->cek_id_edit_riwayat_kondisi($id);
        if ($cek_id != '') {
            $data = [];
            $data['title'] = 'Edit Riwayat Kondisi Kendaraan';
            $data['value'] = $this->home_m->data_kondisiById($id);
            $this->load->view('admin/template/header');
            $this->load->view('admin/kondisi_kendaraan/editriwayatkondisi', $data);
            $this->load->view('admin/template/footer');
        } else {
            show_404();
        }
    }
    public function riwayat_pemakai()
    {
        $id = $this->input->get('id');
        $cek_id_pemakai = $this->home_m->cek_id_riwayat_pemakai($id);
        if ($cek_id_pemakai != '') {
            $data = [];
            $data['rp'] = $this->home_m->data_riwayatpemakai($id);
            $data['kend'] = $this->home_m->kendaraanByid($id);
            $data['lu'] = $this->home_m->data_lokasiunit();
            $this->load->view('admin/template/header');
            $this->load->view('admin/pemakai_kendaraan/riwayatPemakai', $data);
            $this->load->view('admin/template/modal');
            $this->load->view('admin/template/footer');
        } else {
            show_404();
        }
    }
    public function edit_pemakai()
    {
        $id = $this->input->get('id');
        $cek_id  = $this->home_m->cek_id_edit_riwayat_pemakai($id);
        if ($cek_id != '') {
            $data = [];
            $data['value'] = $this->home_m->data_pemakaibyid($id);
            $data['lu'] = $this->home_m->data_lokasiunit();
            $data['title'] = 'Edit Data Pemakai Kendaraan Dinas';
            $this->load->view('admin/template/header');
            $this->load->view('admin/pemakai_kendaraan/editPemakai', $data);
            $this->load->view('admin/template/footer');
        } else {
            show_404();
        }
    }
    public function riwayat_servis()
    {
        $id = $this->input->get('id');
        $cek_id = $this->home_m->cek_id_riwayat_servis($id);
        if ($cek_id != '') {
            $data = [];
            $data['kend'] = $this->home_m->kendaraanByid($id);
            $data['rs'] = $this->home_m->data_riwayatservis($id);
            $this->load->view('admin/template/header');
            $this->load->view('admin/servis_kendaraan/riwayatservis', $data);
            $this->load->view('admin/template/modal');
            $this->load->view('admin/template/footer');
        } else {
            show_404();
        }
    }
    public function editriwayatservis()
    {
        $id = $this->input->get('id');
        $cek_id = $this->home_m->cek_id_edit_riwayat_servis($id);
        if ($cek_id != '') {
            $data = [];
            $data['title'] = "Edit Riwayat Servis Kendaraan";
            $data['servis'] = $this->home_m->data_servisById($id);
            $this->load->view('admin/template/header');
            $this->load->view('admin/servis_kendaraan/editriwayatservis', $data);
            $this->load->view('admin/template/footer');
        } else {
            show_404();
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
        $id = decrypt_url($this->input->get('id'));
        $cek_id = $this->home_m->cek_id_riwayat_bbm($id);
        if ($cek_id != '') {
            $data = [];
            $data['title'] = 'Riwayat BBM Kendaraan Dinas';
            $data['rbbm'] = $this->home_m->data_riwayatbbm($id);
            $data['kend'] = $this->home_m->kendaraanByid($id);
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
        $id_kend = decrypt_url($this->input->get('idkend'));
        $id_bbm = decrypt_url($this->input->get('id'));
        $cek_id = $this->home_m->cek_id_edit_riwayat_bbm($id_bbm, $id_kend);
        if ($cek_id != '') {
            $data = [];
            $data['title'] = 'Edit Riwayat BBM';
            $data['rbbm'] = $this->home_m->data_riwayatbbm_byid($id_bbm);
            $data['kend'] = $this->home_m->kendaraanByid($id_kend);
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
        $id_bbm = decrypt_url($this->input->get('id'));
        $id_kend = decrypt_url($this->input->post('id_kend'));
        $id_bbm_enc = encrypt_url($id_bbm);

        $data = [];
        $tgl = $this->input->post('tgl_bbm');
        $tipe = decrypt_url($this->input->post('tipe'));
        $no_pol = decrypt_url($this->input->post('no_pol'));

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
                redirect('home/riwayat_bbm?id=' . $id_bbm_enc);
            } else {
                $this->session->set_flashdata('danger', 'Tambah Riwayat BBM Kendaraan gagal');
                $data['post'] = $this->input->post();
            }
        } else {
            if (isset($nama_struk_bbm)) {
                unlink('./assets/upload/struk_bbm/' . $nama_struk_bbm);
            }
            $this->session->set_flashdata('danger', 'Tambah Riwayat BBM Kendaraan gagal, Silahkan lengkapi kelengkapan data anda');
            redirect('home/riwayat_bbm?id=' . $id_bbm_enc);
            $data['post'] = $this->input->post();
        }
    }
    public function proseseditbbm()
    {
        $id_bbm = decrypt_url($this->input->get('id'));
        $id_kend = decrypt_url($this->input->get('idkend'));
        $id_kend_enc = encrypt_url($id_kend);

        $data = [];
        $tgl = $this->input->post('tgl_bbm');
        $tipe = decrypt_url($this->input->post('tipe'));
        $no_pol = decrypt_url($this->input->post('no_pol'));

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
                redirect('home/riwayat_bbm?id=' . $id_kend_enc);
            } else {
                $this->session->set_flashdata('danger', 'Edit Riwayat BBM Kendaraan gagal');
                $data['post'] = $this->input->post();
            }
        } else if (empty($_FILES['struk_bbm']['name'])) {
            $nama_struk_bbm = decrypt_url($this->input->post('old_struk'));
            $simpan = $this->home_m->updateriwayatbbm($id_bbm, $nama_struk_bbm);
            if ($simpan) {
                $this->session->set_flashdata('success', 'Edit Riwayat BBM Kendaraan Berhasil');
                redirect('home/riwayat_bbm?id=' . $id_kend_enc);
            } else {
                $this->session->set_flashdata('danger', 'Edit Riwayat BBM Kendaraan gagal');
                $data['post'] = $this->input->post();
            }
        } else {
            if (isset($nama_struk_bbm)) {
                unlink('./assets/upload/struk_bbm/' . $nama_struk_bbm);
            }
            $this->session->set_flashdata('danger', 'Edit Riwayat BBM Kendaraan gagal, Silahkan lengkapi kelengkapan data anda');
            redirect('home/riwayat_bbm?id=' . $id_kend_enc);
            $data['post'] = $this->input->post();
        }
    }
    public function hapusrbbm()
    {
        $id_bbm = decrypt_url($this->input->get('id'));
        $id_kend = decrypt_url($this->input->get('idkend'));
        $id_kend_enc = encrypt_url($id_kend);
        if ($this->home_m->hapusbbm($id_bbm)) {
            $this->session->set_flashdata('success', 'Hapus Riwayat BBM Kendaraan Berhasil');
            redirect('home/riwayat_bbm?id=' . $id_kend_enc);
        } else {
            $this->session->set_flashdata('danger', 'Hapus Riwayat BBM Kendaraan gagal');
            redirect('home/riwayat_bbm?id=' . $id_kend_enc);
        }
    }

    public function riwayat_pajak()
    {
        $id = $this->input->get('id');
        $cek_id = $this->home_m->cek_id_riwayat_pajak($id);
        if ($cek_id != '') {
            $data = [];
            $data['rp'] = $this->home_m->data_riwayatpajak($id);
            $data['kend'] = $this->home_m->kendaraanByid($id);
            $data['title'] = 'Riwayat Pajak Kendaraan Dinas';
            $this->load->view('admin/template/header');
            $this->load->view('admin/pajak/riwayatPajak', $data);
            $this->load->view('admin/template/modal');
            $this->load->view('admin/template/footer');
        } else {
            show_404();
        }
    }
    public function editriwayatpajak()
    {
        $id = $this->input->get('id');
        $cek_id = $this->home_m->cek_id_edit_riwayat_pajak($id);
        if ($cek_id != '') {
            $data = [];
            $data['rp'] = $this->home_m->data_riwayatpajak($id);
            $data['value'] = $this->home_m->datapajakById($id);
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
        $cekpemakai = $this->home_m->data_riwayatpemakaibynopolandstatus($id_kend);
        if ($cekpemakai != '') {
            $this->session->set_flashdata('danger', 'Tambah Riwayat Pemakai gagal, Kendaraan sudah terpakai ');
            redirect('home/riwayat_pemakai?id=' . $idk . '');
        } else {
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
    public function print_data_kendaraan()
    {
        check_level();
        $this->load->view('admin/template/header');
        // $this->load->view('admin/servis/editriwayatservis', $data);
        $this->load->view('admin/template/footer');
    }
}