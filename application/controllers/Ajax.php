<?php
defined('BASEPATH') or exit('No direct script access allowed');
// Don't forget include/define REST_Controller path

/**
 *
 * Controller Ajax
 *
 * This controller for ...
 *
 * @package   CodeIgniter
 * @category  Controller CI
 * @author    Setiawan Jodi <jodisetiawan@fisip-untirta.ac.id>
 * @author    Raul Guerrero <r.g.c@me.com>
 * @link      https://github.com/setdjod/myci-extension/
 * @param     ...
 * @return    ...
 *
 */

class Ajax extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('datatable_model', 'kendaraan');
    $this->load->model('datatable_all_model', 'kendaraanAll');
  }

  public function kendaraan()
  {
    $list = $this->kendaraan->get_kendaraan_with_pemakai();
    $data = array();
    $no = $_POST['start'];
    foreach ($list as $kend) {
      $no++;
      if (empty($kend->name) && empty($kend->nip_user)) {
        $pemakai = '<p class="text-center">-</p>';
      } else {
        $pemakai = '<p class="text-center">' . $kend->name . '<br>(' . $kend->nip_user . ')</p>';
      }
      if (empty($kend->besar_cc)) {
        $cc = '<p class="text-center">-</p>';
      } else {
        $cc = '<p class="text-center">' . $kend->besar_cc . ' cc</p>';
      }

      $row = array();
      $row[] = $no;
      $row[] = '
      <td class"text-center">
      <a href="' . site_url('home/riwayat_kondisi?id=' . $kend->idk . '') . '" class="btn btn-sm btn-warning jedatombol" title="Riwayat Kondisi ' . $kend->merk . ' ' . $kend->tipe . ' ' . $kend->no_polisi . '"><i class="fa fa-motorcycle"></i></a>
      <a href="' . site_url('home/riwayat_pemakai?id=' . $kend->idk . '') . '" class="btn btn-sm btn-success jedatombol" title="Riwayat Pemakai ' . $kend->merk . ' ' . $kend->tipe . ' ' . $kend->no_polisi . '"><i class="fa fa-users"></i></a> 
      <a href="' . site_url('home/riwayat_servis?id=' . $kend->idk . '') . '" class="btn btn-sm btn-primary jedatombol" title="Riwayat Service ' . $kend->merk . ' ' . $kend->tipe . ' ' . $kend->no_polisi . '"><i class="fa fa-tools"></i></a>      
      <a href="' . site_url('admin/pagu?id=' . $kend->idk . '') . '" class="btn btn-sm btn-dark jedatombol" title="Pagu Tahunan Kendaraan ' . $kend->merk . ' ' . $kend->tipe . ' ' . $kend->no_polisi . '"><i class="fa fa-wallet"></i></a> 
      <a href="' . site_url('home/print_data_kendaraan?id=' . $kend->idk . '') . '" class="btn btn-sm btn-dark jedatombol" title="Print Data Kendaraan ' . $kend->merk . ' ' . $kend->tipe . ' ' . $kend->no_polisi . '"><i class="fa fa-print"></i></a>
      </td>';
      $row[] = '<td class"text-center">
      <a href="' . site_url('home/riwayat_bbm?id=' . $kend->idk . '') . '" class="btn btn-sm btn-primary jedatombol" title="Riwayat BBM ' . $kend->merk . ' ' . $kend->tipe . ' ' . $kend->no_polisi . '"><i class="fa fa-gas-pump"></i></a>
      <a href="' . site_url('home/riwayat_pajak?id=' . $kend->idk . '') . '" class="btn btn-sm btn-success jedatombol" title="Riwayat Pajak ' . $kend->merk . ' ' . $kend->tipe . ' ' . $kend->no_polisi . '"><i class="fa fa-align-justify"></i></a> 
      <a href="' . site_url('home/pengajuan_servis?id=' . $kend->idk . '') . '" class="btn btn-sm btn-primary jedatombol" title="Pengajuan Servis ' . $kend->merk . ' ' . $kend->tipe . ' ' . $kend->no_polisi . '"><i class="fa-regular fa-ballot"></i></a>      
      <a href="' . site_url('home/edit_kendaraan?id=' . $kend->idk . '') . '" onclick="return confirm(\'Yakin ingin mengedit data ini ?\')" class="btn btn-sm btn-warning jedatombol" title="Edit Data Kendaraan ' . $kend->merk . ' ' . $kend->tipe . ' ' . $kend->no_polisi . '"><i class="fa fa-pen"></i></a> 
      <a href="' . site_url('home/hapus_data_kendaraan?id=' . $kend->idk . '') . '" onclick="return confirm(\'Yakin ingin menghapus data ini ?\')" class="btn btn-sm btn-danger jedatombol" title="Hapus Data Kendaraan ' . $kend->merk . ' ' . $kend->tipe . ' ' . $kend->no_polisi . '"><i class="fa fa-trash"></i></a> 
      </td>';
      $row[] = '<p class="text-center">' . $kend->id_assets . '</p>';
      $row[] = $pemakai;
      $row[] = '<p class="text-center">' . $kend->lokasi_unit . '</p>';
      $row[] = '<p class="text-center">' . $kend->no_polisi . '</p>';
      $row[] = '<p class="text-center">' . $kend->jenis . '</p>';
      $row[] = '<p class="text-center">' . $kend->merk . '</p>';
      $row[] = '<p class="text-center">' . $kend->tipe . '</p>';
      $row[] = '<p class="text-center">' . $kend->tahun_perolehan . '</p>';
      $row[] = '<p class="text-center">' . $kend->jenis_bb . '</p>';
      $row[] = $cc;
      $row[] = '<p class="text-center">' . $kend->masa_berlaku_stnk . '</p>';
      $row[] = '<p class="text-center">' . $kend->no_stnk . '</p>';
      $row[] = '<p class="text-center">' . $kend->no_mesin . '</p>';
      $row[] = '<p class="text-center">' . $kend->no_rangka . '</p>';

      $data[] = $row;
    }
    $output = array(
      "draw" => $_POST['draw'],
      "recordsTotal" => $this->kendaraan->count_all(),
      "recordsFiltered" => $this->kendaraan->count_filtered(),
      "data" => $data,
    );
    echo json_encode($output);
  }
  public function kendaraanall()
  {
    $list = $this->kendaraan->get_kendaraan_with_pemakai();
    $data = array();
    $no = $_POST['start'];
    foreach ($list as $kend) {
      $no++;
      if (empty($kend->besar_cc)) {
        $cc = '<p class="text-center">-</p>';
      } else {
        $cc = '<p class="text-center">' . $kend->besar_cc . ' cc</p>';
      }

      $row = array();
      $row[] = $no;
      $row[] = '
      <td class"text-center">
      <a href="' . site_url('home/riwayat_kondisi?id=' . $kend->idk . '') . '" class="btn btn-sm btn-warning jedatombol" title="Riwayat Kondisi ' . $kend->merk . ' ' . $kend->tipe . ' ' . $kend->no_polisi . '"><i class="fa fa-motorcycle"></i></a>
      <a href="' . site_url('home/riwayat_pemakai?id=' . $kend->idk . '') . '" class="btn btn-sm btn-success jedatombol" title="Riwayat Pemakai ' . $kend->merk . ' ' . $kend->tipe . ' ' . $kend->no_polisi . '"><i class="fa fa-users"></i></a> 
      <a href="' . site_url('home/riwayat_servis?id=' . $kend->idk . '') . '" class="btn btn-sm btn-primary jedatombol" title="Riwayat Service ' . $kend->merk . ' ' . $kend->tipe . ' ' . $kend->no_polisi . '"><i class="fa fa-tools"></i></a>      
      <a href="' . site_url('admin/pagu?id=' . $kend->idk . '') . '" class="btn btn-sm btn-dark jedatombol" title="Pagu Tahunan Kendaraan ' . $kend->merk . ' ' . $kend->tipe . ' ' . $kend->no_polisi . '"><i class="fa fa-wallet"></i></a> 
      <a href="' . site_url('home/print_data_kendaraan?id=' . $kend->idk . '') . '" class="btn btn-sm btn-dark jedatombol" title="Print Data Kendaraan ' . $kend->merk . ' ' . $kend->tipe . ' ' . $kend->no_polisi . '"><i class="fa fa-print"></i></a>
      </td>';
      $row[] = '<td class"text-center">
      <a href="' . site_url('home/riwayat_bbm?id=' . $kend->idk . '') . '" class="btn btn-sm btn-primary jedatombol" title="Riwayat BBM ' . $kend->merk . ' ' . $kend->tipe . ' ' . $kend->no_polisi . '"><i class="fa fa-gas-pump"></i></a>
      <a href="' . site_url('home/riwayat_pajak?id=' . $kend->idk . '') . '" class="btn btn-sm btn-success jedatombol" title="Riwayat Pajak ' . $kend->merk . ' ' . $kend->tipe . ' ' . $kend->no_polisi . '"><i class="fa fa-align-justify"></i></a> 
      <a href="' . site_url('home/pengajuan_servis?id=' . $kend->idk . '') . '" class="btn btn-sm btn-primary jedatombol" title="Pengajuan Servis ' . $kend->merk . ' ' . $kend->tipe . ' ' . $kend->no_polisi . '"><i class="fa-regular fa-ballot"></i></a>      
      <a href="' . site_url('home/edit_kendaraan?id=' . $kend->idk . '') . '" onclick="return confirm(\'Yakin ingin mengedit data ini ?\')" class="btn btn-sm btn-warning jedatombol" title="Edit Data Kendaraan ' . $kend->merk . ' ' . $kend->tipe . ' ' . $kend->no_polisi . '"><i class="fa fa-pen"></i></a> 
      <a href="' . site_url('home/hapus_data_kendaraan?id=' . $kend->idk . '') . '" onclick="return confirm(\'Yakin ingin menghapus data ini ?\')" class="btn btn-sm btn-danger jedatombol" title="Hapus Data Kendaraan ' . $kend->merk . ' ' . $kend->tipe . ' ' . $kend->no_polisi . '"><i class="fa fa-trash"></i></a> 
      </td>';
      $row[] = '<p class="text-center">' . $kend->id_assets . '</p>';
      $row[] = '<p class="text-center">' . $kend->lokasi_unit . '</p>';
      $row[] = '<p class="text-center">' . $kend->no_polisi . '</p>';
      $row[] = '<p class="text-center">' . $kend->jenis . '</p>';
      $row[] = '<p class="text-center">' . $kend->merk . '</p>';
      $row[] = '<p class="text-center">' . $kend->tipe . '</p>';
      $row[] = '<p class="text-center">' . $kend->tahun_perolehan . '</p>';
      $row[] = '<p class="text-center">' . $kend->jenis_bb . '</p>';
      $row[] = $cc;
      $row[] = '<p class="text-center">' . $kend->masa_berlaku_stnk . '</p>';
      $row[] = '<p class="text-center">' . $kend->no_stnk . '</p>';
      $row[] = '<p class="text-center">' . $kend->no_mesin . '</p>';
      $row[] = '<p class="text-center">' . $kend->no_rangka . '</p>';

      $data[] = $row;
    }
    $output = array(
      "draw" => $_POST['draw'],
      "recordsTotal" => $this->kendaraan->count_all(),
      "recordsFiltered" => $this->kendaraan->count_filtered(),
      "data" => $data,
    );
    echo json_encode($output);
  }
}


/* End of file Ajax.php */
/* Location: ./application/controllers/Ajax.php */