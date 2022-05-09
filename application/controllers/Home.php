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
        $data = [];
        $data['kend'] = $this->home_m->kendaraanByid($id);
        $data['rk'] = $this->home_m->data_riwayatKondisi($id);
        $this->load->view('admin/template/header');
        $this->load->view('admin/kondisi_kendaraan/riwayatKondisi', $data);
        $this->load->view('admin/template/footer');
    }
    public function editriwayatkondisi()
    {
        $id = $this->input->get('id');
        $data = [];
        $data['title'] = 'Edit Riwayat Kondisi Kendaraan';
        $data['kend'] = $this->home_m->kendaraanByid($id);
        $data['value'] = $this->home_m->data_kondisiById($id);
        $this->load->view('admin/template/header');
        $this->load->view('admin/kondisi_kendaraan/editriwayatkondisi', $data);
        $this->load->view('admin/template/footer');
    }
    public function riwayat_pemakai()
    {
        $id = $this->input->get('id');
        $data = [];
        $data['rp'] = $this->home_m->data_riwayatpemakai($id);
        $data['kend'] = $this->home_m->kendaraanByid($id);
        $data['lu'] = $this->home_m->data_lokasiunit();
        $this->load->view('admin/template/header');
        $this->load->view('admin/riwayatPemakai', $data);
        $this->load->view('admin/template/footer');
    }
    public function edit_pemakai()
    {
        $id = $this->input->get('id');
        $data = [];
        $data['value'] = $this->home_m->data_pemakaibyid($id);
        $data['lu'] = $this->home_m->data_lokasiunit();
        $data['title'] = 'Edit Data Pemakai Kendaraan Dinas';
        $this->load->view('admin/template/header');
        $this->load->view('admin/editPemakai', $data);
        $this->load->view('admin/template/footer');
    }

    public function riwayat_bbm()
    {
        $data = [];
        $id = $this->input->get('id');
        $data['title'] = 'Riwayat BBM';
        $data['rbbm'] = $this->home_m->data_riwayatbbm($id);
        $data['kend'] = $this->home_m->kendaraanByid($id);
        $this->load->view('admin/template/header');
        $this->load->view('admin/riwayatBBM', $data);
        $this->load->view('admin/template/footer');
    }
    public function riwayat_pajak()
    {
        $data = [];
        $id = $this->input->get('id');
        $data['rp'] = $this->home_m->data_riwayatpajak($id);
        $data['kend'] = $this->home_m->kendaraanByid($id);
        $this->load->view('admin/template/header');
        $this->load->view('admin/riwayatPajak', $data);
        $this->load->view('admin/template/footer');
    }
    public function prosestambahkondisi()
    {
        $data = [];
        $idk = $this->input->get('id');
        $config['upload_path'] = './assets/file_kendaraan/'; //path folder
        $config['allowed_types'] = 'jpg|png|jpeg|jfif'; //type yang dapat diakses bisa anda sesuaikan
        $config['encrypt_name'] = TRUE; //Enkripsi nama yang terupload

        $this->load->library('upload', $config);

        if (!empty($_FILES['depan']['name'])) {
            $this->load->library('upload', $config, 'depan');
            $this->depan->initialize($config);
            $this->depan->do_upload('depan');
            $dpn = $this->depan->data();
            //compress file
            $config['image_library'] = 'gd2';
            $config['source_image'] = './assets/file_kendaraan/' . $dpn['file_name'];
            $config['create_thumb'] = FALSE;
            $config['maintain_ratio'] = TRUE;
            $config['quality'] = '50%';
            $config['width'] = 600;
            $config['height'] = 400;
            $config['new_image'] = './assets/file_kendaraan/' . $dpn['file_name'];
            $this->load->library('image_lib', $config, 'resizedpn');
            $res = $this->resizedpn->resize();
            $nama_dpn = $dpn['file_name'];
        }
        if (!empty($_FILES['blkg']['name'])) {
            $this->load->library('upload', $config, 'blkg');
            $this->blkg->initialize($config);
            $this->blkg->do_upload('blkg');
            $blkg = $this->blkg->data();
            //compress file
            $config['image_library'] = 'gd2';
            $config['source_image'] = './assets/file_kendaraan/' . $blkg['file_name'];
            $config['create_thumb'] = FALSE;
            $config['maintain_ratio'] = TRUE;
            $config['quality'] = '50%';
            $config['width'] = 600;
            $config['height'] = 400;
            $config['new_image'] = './assets/file_kendaraan/' . $blkg['file_name'];
            $this->load->library('image_lib', $config, 'resizeblkg');
            $res = $this->resizeblkg->resize();
            $nama_blkg = $blkg['file_name'];
        }
        if (!empty($_FILES['kiri']['name'])) {
            $this->load->library('upload', $config, 'kiri');
            $this->kiri->initialize($config);
            $this->kiri->do_upload('kiri');
            $kiri = $this->kiri->data();
            //compress file
            $config['image_library'] = 'gd2';
            $config['source_image'] = './assets/file_kendaraan/' . $kiri['file_name'];
            $config['create_thumb'] = FALSE;
            $config['maintain_ratio'] = TRUE;
            $config['quality'] = '50%';
            $config['width'] = 600;
            $config['height'] = 400;
            $config['new_image'] = './assets/file_kendaraan/' . $kiri['file_name'];
            $this->load->library('image_lib', $config, 'resizekiri');
            $res = $this->resizekiri->resize();
            $nama_kiri = $kiri['file_name'];
        }
        if (!empty($_FILES['kanan']['name'])) {
            $this->load->library('upload', $config, 'kanan');
            $this->kanan->initialize($config);
            $this->kanan->do_upload('kanan');
            $kanan = $this->kanan->data();
            //compress file
            $config['image_library'] = 'gd2';
            $config['source_image'] = './assets/file_kendaraan/' . $kanan['file_name'];
            $config['create_thumb'] = FALSE;
            $config['maintain_ratio'] = TRUE;
            $config['quality'] = '50%';
            $config['width'] = 600;
            $config['height'] = 400;
            $config['new_image'] = './assets/file_kendaraan/' . $kanan['file_name'];
            $this->load->library('image_lib', $config, 'resizekanan');
            $res = $this->resizekanan->resize();
            $nama_kanan = $kanan['file_name'];
        }
        if (!empty($_FILES['depan']['name']) && !empty($_FILES['blkg']['name']) && !empty($_FILES['kiri']['name']) && !empty($_FILES['kanan']['name'])) {
            $simpan = $this->home_m->tambahriwayatkendaraan($nama_dpn, $nama_blkg, $nama_kiri, $nama_kanan, $idk);
            if ($simpan) {
                $this->session->set_flashdata('success', 'Tambah Riwayat Kondisi Kendaraan Berhasil');
                redirect('home/riwayat_kondisi?id=' . $simpan . '');
            } else {
                $this->session->set_flashdata('danger', 'Tambah Riwayat Kondisi Kendaraan gagal');
                $data['post'] = $this->input->post();
            }
        } else {
            if (isset($nama_dpn)) {
                unlink('./assets/file_kendaraan/' . $nama_dpn);
            }
            if (isset($nama_blkg)) {
                unlink('./assets/file_kendaraan/' . $nama_blkg);
            }
            if (isset($nama_kiri)) {
                unlink('./assets/file_kendaraan/' . $nama_kiri);
            }
            if (isset($nama_kanan)) {
                unlink('./assets/file_kendaraan/' . $nama_kanan);
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

    public function riwayat_servis()
    {
        $id = $this->input->get('id');
        $data = [];
        $data['kend'] = $this->home_m->kendaraanByid($id);
        $data['rs'] = $this->home_m->data_riwayatservis($id);
        $this->load->view('admin/template/header');
        $this->load->view('admin/servis_kendaraan/riwayatservis', $data);
        $this->load->view('admin/template/footer');
    }
    public function editriwayatservis()
    {
        $id = $this->input->get('id');
        $data = [];
        $data['title'] = "Edit Riwayat Servis Kendaraan";
        $data['servis'] = $this->home_m->data_servisById($id);
        $this->load->view('admin/template/header');
        $this->load->view('admin/servis_kendaraan/editriwayatservis', $data);
        $this->load->view('admin/template/footer');
    }
    public function delete_servis()
    {
        $id = $this->input->get('id');
        $this->db->where('id_rs', $id);
        $this->db->delete('riwayat_servis');
        redirect($_SERVER['HTTP_REFERER']);
    }

    // public function prosestambahservis()
    // {

    //     $idk = $this->input->get('id');
    //     $config['upload_path'] = './assets/foto_servis/'; //path folder
    //     $config['allowed_types'] = 'jpg|png|jpeg|jfif'; //type yang dapat diakses bisa anda sesuaikan
    //     $config['encrypt_name'] = TRUE; //Enkripsi nama yang terupload

    //     $this->load->library('upload', $config);
    //     if (!empty($_FILES['foto']['name'])) {
    //         $this->load->library('upload', $config);
    //         $this->upload->initialize($config);
    //         $this->upload->do_upload('foto');
    //         $foto = $this->upload->data();
    //         //compress file
    //         $config['image_library'] = 'gd2';
    //         $config['source_image'] = './assets/foto_servis/' . $foto['file_name'];
    //         $config['create_thumb'] = FALSE;
    //         $config['maintain_ratio'] = TRUE;
    //         $config['quality'] = '50%';
    //         $config['width'] = 600;
    //         $config['height'] = 400;
    //         $config['new_image'] = './assets/foto_servis/' . $foto['file_name'];
    //         $this->load->library('image_lib', $config);
    //         $res = $this->image_lib->resize();
    //         $namafoto = $foto['file_name'];
    //     }
    //     if (!empty($_FILES['nota']['name'])) {
    //         $this->load->library('upload', $config, 'nota');
    //         $this->nota->initialize($config);
    //         $this->nota->do_upload('nota');
    //         $nota = $this->nota->data();
    //         //compress file
    //         $config['image_library'] = 'gd2';
    //         $config['source_image'] = './assets/foto_servis/' . $nota['file_name'];
    //         $config['create_thumb'] = FALSE;
    //         $config['maintain_ratio'] = TRUE;
    //         $config['quality'] = '50%';
    //         $config['width'] = 600;
    //         $config['height'] = 400;
    //         $config['new_image'] = './assets/foto_servis/' . $nota['file_name'];
    //         $this->load->library('image_lib', $config, 'resizenota');
    //         $res = $this->resizenota->resize();
    //         $namanota = $nota['file_name'];
    //     }

    //     if (!empty($_FILES['foto']['name']) && !empty($_FILES['nota']['name'])) {
    //         $simpan = $this->home_m->tambahriwayatserviskendaraan($namafoto, $idk, $namanota);
    //         if ($simpan) {
    //             $this->session->set_flashdata('success', 'Tambah Riwayat Service Kendaraan Berhasil');
    //             redirect('home/riwayat_servis?id=' . $idk . '');
    //         } else {
    //             $this->session->set_flashdata('danger', 'Tambah Riwayat Service Kendaraan gagal');
    //             $data['post'] = $this->input->post();
    //         }
    //     } else {
    //         if (isset($nama_dpn)) {
    //             unlink('./assets/foto_servis/' . $namafoto);
    //         }
    //         $this->session->set_flashdata('danger', 'Tambah Riwayat Service Kendaraan gagal, Silahkan lengkapi kelengkapan data anda');
    //         redirect('home/riwayat_servis?id=' . $idk . '');
    //         $data['post'] = $this->input->post();
    //     }
    // }
    public function print_data_kendaraan()
    {
        check_level();
        $this->load->view('admin/template/header');
        // $this->load->view('admin/servis/editriwayatservis', $data);
        $this->load->view('admin/template/footer');
    }
}