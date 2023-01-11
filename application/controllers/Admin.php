<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        check_session();
        check_level_pemakai();
        check_level_admin();
        $this->load->model('home_m');
        $this->load->model('admin_m');
    }
    public function pagu_old()
    {
        $id = $this->input->get('id');
        $cek_id = $this->home_m->cek_id_riwayat_pagu($id);
        if ($cek_id != '') {
            $data = [];
            $data['kend'] = $this->home_m->kendaraanByid($id);
            $data['pemeliharaan'] = $this->admin_m->pagu_kendaraan_pemeliharaan($id);
            $data['bbm'] = $this->admin_m->pagu_kendaraan_bbm($id);
            $data['pajak'] = $this->admin_m->pagu_kendaraan_pajak($id);
            $data['title'] = 'Pagu Anggaran Tahunan Kendaraan Dinas';
            $this->load->view('admin/template/header');
            $this->load->view('admin/pagu/pagukendaraan', $data);
            $this->load->view('admin/template/modal');
            $this->load->view('admin/template/footer');
        } else {
            show_404();
        }
    }
    public function pagu()
    {
        $id = $this->input->get('id');
        $cek_id = $this->home_m->cek_id_riwayat_pagu($id);
        $tahun = date('Y');
        if ($cek_id != '') {
            $data = [];
            $data['paguall'] = $this->admin_m->pagu_kendaraan($id);
            $data['pagu'] = $this->home_m->pagukendaraanById($id, $tahun);
            $data['kend'] = $this->home_m->kendaraanByid($id);
            $data['pmk'] = $this->home_m->pemakaiKendById($id);
            $data['title'] = 'Pagu Anggaran Tahunan Kendaraan Dinas';
            $data['title_cek'] = 'Cek Sisa Pagu Kendaraan Dinas';
            if ($this->input->get()) {
                $tahun = ($this->input->get('tahun'));
                $data['tahun'] = $tahun;
                $data['rekap'] = $this->admin_m->cek_datapagu($id, $tahun);
                // print_r($this->db->last_query());
                // die();
                $data['title_cek'] = 'Cek Sisa Pagu Kendaraan Dinas Tahun ' . $tahun . '';
            }
            $this->load->view('admin/template/header');
            $this->load->view('admin/pagu/pagukendaraan', $data);
            $this->load->view('admin/template/modal');
            $this->load->view('admin/template/footer');
        } else {
            show_404();
        }
    }
    public function prosestambahpagu_old()
    {

        $id = $this->input->get('id');
        $jenispagu = $this->input->post('jenis');
        foreach ($jenispagu as $key => $value) {
            $cektahun = $this->admin_m->cek_tahun_pagu($id, $this->input->post('tahun'));
            if ($cektahun != '') {
                $this->session->set_flashdata('danger', 'Anda sudah menginputkan pagu untuk tahun ' . $this->input->post('tahun'));
                redirect('admin/pagu?id=' . $id);
            } else {
                $simpan = $this->admin_m->tambahpagu($id, $value, $this->input->post('pagu')[$key]);
                if ($simpan) {
                    $this->session->set_flashdata('success', 'Tambah Pagu Anggaran Pemeliharaan Berhasil');
                    redirect('admin/pagu?id=' . $id);
                } else {
                    $this->session->set_flashdata('danger', 'Tambah Pagu Anggaran Pemeliharaan Gagal');
                    redirect('admin/pagu?id=' . $id);
                }
            }
        }
    }
    public function prosestambahpagu()
    {

        $id = $this->input->get('id');
        // $jenispagu = $this->input->post('jenis');
        $cektahun = $this->admin_m->cek_tahun_pagu($id, $this->input->post('tahun'));
        if ($cektahun != '') {
            $this->session->set_flashdata('danger', 'Anda sudah menginputkan pagu untuk tahun ' . $this->input->post('tahun'));
            redirect('admin/pagu?id=' . $id);
        } else {
            $simpan = $this->admin_m->tambahpagu($id);
            if ($simpan) {
                $this->session->set_flashdata('success', 'Tambah Pagu Anggaran Pemeliharaan Berhasil');
                redirect('admin/pagu?id=' . $id);
            } else {
                $this->session->set_flashdata('danger', 'Tambah Pagu Anggaran Pemeliharaan Gagal');
                redirect('admin/pagu?id=' . $id);
            }
        }
    }

    public function editpagu()
    {
        $id = $this->input->get('id');
        $id_kend = $this->input->get('idkend');
        $tahun = date('Y');
        $cek_id = $this->home_m->cek_id_edit_riwayat_pagu($id);
        if ($cek_id != '') {
            $data = [];
            $data['pagukend'] = $this->admin_m->datapagu_kendaraanbyid($id);
            $data['pagu'] = $this->home_m->pagukendaraanById($id_kend, $tahun);
            $data['pmk'] = $this->home_m->pemakaiKendById($id_kend);
            $data['kend'] = $this->home_m->kendaraanByid($id_kend);
            $data['title'] = 'Edit Pagu Anggaran Kendaraan Dinas';
            $this->load->view('admin/template/header');
            $this->load->view('admin/pagu/editpaguKendaraan', $data);
            $this->load->view('admin/template/modal');
            $this->load->view('admin/template/footer');
        } else {
            show_404();
        }
    }
    public function proseseditpagu()
    {
        $id = $this->input->get('id');
        $idkend = $this->input->get('idkend');
        if ($this->input->post()) {

            if ($this->admin_m->updatepagu($id)) {
                // print_r($this->db->last_query());
                // die();
                $this->session->set_flashdata('success', 'Edit Pagu Anggaran ' . $this->input->post('jenis') . ' Berhasil');
                redirect('admin/pagu?id=' . $idkend);
            } else {

                $this->session->set_flashdata('danger', 'Edit Pagu Anggaran ' . $this->input->post('jenis') . ' Gagal');
                redirect('admin/pagu?id=' . $idkend);
            }
        }
    }
    public function hapuspagu()
    {
        $id = ($this->input->get('id'));
        $id_kend = ($this->input->get('idkend'));
        if ($this->admin_m->hapuspagu($id)) {
            $this->session->set_flashdata('success', 'Hapus Data Pagu Berhasil');
            redirect('admin/pagu?id=' . $id_kend);
        } else {
            $this->session->set_flashdata('danger', 'Hapus Data Pagu gagal');
            redirect('admin/pagu?id=' . $id_kend);
        }
    }

    public function user()
    {
        $data['user'] = $this->admin_m->user();
        $data['lu'] = $this->admin_m->data_lokasiunit();
        $this->load->view('admin/template/header');
        $this->load->view('admin/template/modal');
        $this->load->view('admin/users/data', $data);
        $this->load->view('admin/template/footer');
    }
    public function edit_user()
    {
        $id = $this->input->get('id');
        $data['title'] = 'Edit Data User';
        $data['user'] = $this->admin_m->userbyid($id);
        $data['lu'] = $this->admin_m->data_lokasiunit();
        $this->load->view('admin/template/header');
        $this->load->view('admin/users/editUser', $data);
        $this->load->view('admin/template/footer');
    }
    public function delete_user()
    {
        $id = $this->input->get('id');
        $deletePemakai = $this->db
            ->where('id_user', $id)
            ->delete('riwayat_pemakai');
        $delete = $this->db->where('id', $id)->delete('users');
        if ($delete && $deletePemakai) {
            $this->session->set_flashdata('success', 'Hapus User Berhasil');
            redirect('admin/user');
        } else {
            $this->session->set_flashdata('danger', 'Hapus User Gagal');
            redirect('admin/user');
        }
    }
    public function aktifkanuser()
    {
        $id = $this->input->get('id');
        if ($this->admin_m->aktifkanuser($id)) {
            $this->session->set_flashdata('success', 'Berhasil Mengaktifkan User');
            redirect('admin/user');
        } else {
            $this->session->set_flashdata('danger', 'Gagal Mengaktifkan User');
            redirect('admin/user');
        }
    }
    public function nonaktifkanuser()
    {
        $id = $this->input->get('id');
        if ($this->admin_m->nonaktifkanuser($id)) {
            $this->session->set_flashdata('success', 'Berhasil Mengnonaktifkan User');
            redirect('admin/user');
        } else {
            $this->session->set_flashdata('danger', 'Gagal Mengnonaktifkan User');
            redirect('admin/user');
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
    public function prosestambahuser()
    {
        if ($this->input->post()) {
            if ($this->admin_m->tambahuser()) {
                $this->session->set_flashdata('success', 'Tambah User Berhasil');
                redirect('admin/user');
            } else {
                $this->session->set_flashdata('danger', 'Tambah User gagal');
                redirect('admin/user');
            }
        }
    }
    public function prosesedituser()
    {
        $id_user = $this->input->get('id');
        if ($this->input->post()) {
            if ($this->admin_m->edituser($id_user)) {
                $this->session->set_flashdata('success', 'Edit User Berhasil');
                redirect('admin/user');
            } else {
                $this->session->set_flashdata('danger', 'Edit User gagal');
                redirect('admin/user');
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