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

    $this->load->model('datatable_model_peralatan', 'peralatan');
    $this->load->model('datatable_all_model_peralatan', 'peralatanAll');
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

  public function peralatan()
  {
    // print_r("alat");die();
    $list = $this->peralatan->get_peralatan();
    // print_r($list);
    // die();
    $data = array();
    $no = $_POST['start'];
    foreach ($list as $alat) {
      $no++;
      if($alat->status=="tidak_aktif"){
        $pemakai = '<p class="text-center">-</p>';
      }
      else{
        if (empty($alat->name) && empty($alat->nip_user)) {
          $pemakai = '<p class="text-center">-</p>';
          // if($alat->status=="tidak_aktif"){
          //   $pemakai = '<p class="text-center">-</p>';
          // }
        } else {
          $pemakai = '<p class="text-center">' . $alat->name .'<br>(' . $alat->nip_user . ')</p>';
        }
      }

      $row = array();
      $row[] = $no;
      $row[] = '
      <td class"text-center">
      <a href="' . site_url('home/riwayat_pemakai_peralatan?id=' . $alat->id_alat . '') . '" class="btn btn-sm btn-success jedatombol" title="Riwayat Pemakai ' . $alat->merk . '"><i class="fa fa-users"></i></a>
      <a href="' . site_url('home/riwayat_servis_peralatan?id=' . $alat->id_alat . '') . '" class="btn btn-sm btn-primary jedatombol" title="Riwayat Service ' . $alat->merk . ' "><i class="fa fa-tools"></i></a>      
      <a href="' . site_url('admin/pagu_peralatan?id=' . $alat->id_alat . '') . '" class="btn btn-sm btn-dark jedatombol" title="Pagu Tahunan Peralatan ' . $alat->merk . ' "><i class="fa fa-wallet"></i></a> 
      </td>';
      $row[] = '<td class"text-center"> 
      <a href="' . site_url('home/pengajuan_servis_peralatan?id=' . $alat->id_alat . '') . '" class="btn btn-sm btn-primary jedatombol" title="Pengajuan Servis ' . $alat->merk . ' "><i class="fa-regular fa-ballot"></i></a>      
      <a href="' . site_url('home/edit_peralatan?id=' . $alat->id_alat . '') . '" onclick="return confirm(\'Yakin ingin mengedit data ini ?\')" class="btn btn-sm btn-warning jedatombol" title="Edit Data alataraan ' . $alat->merk . '"><i class="fa fa-pen"></i></a> 
      <a href="' . site_url('home/hapus_data_peralatan?id=' . $alat->id_alat . '') . '" onclick="return confirm(\'Yakin ingin menghapus data ini ?\')" class="btn btn-sm btn-danger jedatombol" title="Hapus Data alataraan ' . $alat->merk . ' "><i class="fa fa-trash"></i></a> 
      </td>';
      $row[] = '<p class="text-center">' . $alat->id_asset .'</p>';
      $row[] = $pemakai;
      $row[] = '<p class="text-center">' . $alat->bidang . '</p>';
      // $row[] = '<p class="text-center">' . $alat->name . '<br>(' . $alat->nip_user . ')'.'</p>';
      $row[] = '<p class="text-center">' . $alat->jenis . '</p>';
      $row[] = '<p class="text-center">' . $alat->merk . '</p>';
      // $row[] = '<p class="text-center">' . $alat->tipe . '</p>';
      // $row[] = '<p class="text-center">' . $alat->nama . '</p>';
      $row[] = '<p class="text-center">' . $alat->tahun_perolehan . '</p>';
      $row[] = '<img width="100%" src="'.base_url('assets/upload/foto_garansi_peralatan/'.$alat->foto_garansi).'" data-toggle="modal" data-target="#notaModal'.$no.'" alt="Foto Nota"></img>
        <div class="modal fade" id="notaModal'.$no.'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
         <div class="modal-content">
           <div class="modal-header">
             <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                 aria-hidden="true">&times;</span></button>
           </div>
           <div class="modal-body">
             <center>
               <img src="'.base_url('assets/upload/foto_garansi_peralatan/'.$alat->foto_garansi).'" alt="Foto Nota"
                 class="img-responsive" width="100%" height="auto">
             </center>
           </div>
           <div class="modal-footer">
             <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
           </div>
         </div>
        </div>
        </div>';
      $row[] = '<p class="text-center">' . date("d-m-Y", strtotime($alat->garansi)) . '</p>';
      // $row[] = '<p class="text-center">' . $alat->lokasi_unit . '</p>';
      $row[] = '<p class="text-center">' . $alat->keterangan . '</p>';
      
      $data[] = $row;
    }
    $output = array(
      "draw" => $_POST['draw'],
      "recordsTotal" => $this->peralatan->count_all(),
      "recordsFiltered" => $this->peralatan->count_filtered(),
      "data" => $data,
    );
    echo json_encode($output);
  }

  public function peralatanall()
  {
    $list = $this->peralatanAll->get_peralatanall();
    // print_r($list);
    // die();
    $data = array();
    $no = $_POST['start'];
    foreach ($list as $alat) {
      $no++;
      $row = array();
      $row[] = $no;
      $row[] = '
      <td class"text-center">
      <a href="' . site_url('home/riwayat_pemakai_peralatan?id=' . $alat->id . '') . '" class="btn btn-sm btn-success jedatombol" title="Riwayat Pemakai ' . $alat->merk . '"><i class="fa fa-users"></i></a>
      <a href="' . site_url('home/riwayat_servis_peralatan?id=' . $alat->id . '') . '" class="btn btn-sm btn-primary jedatombol" title="Riwayat Service ' . $alat->merk . '"><i class="fa fa-tools"></i></a>      
      <a href="' . site_url('admin/pagu_peralatan?id=' . $alat->id . '') . '" class="btn btn-sm btn-dark jedatombol" title="Pagu Tahunan Peralatan ' . $alat->merk . '"><i class="fa fa-wallet"></i></a>
      </td>';
      $row[] = '<td class"text-center"> 
      <a href="' . site_url('home/pengajuan_servis_peralatan?id=' . $alat->id . '') . '" class="btn btn-sm btn-primary jedatombol" title="Pengajuan Servis ' . $alat->merk . '"><i class="fa-regular fa-ballot"></i></a>      
      <a href="' . site_url('home/edit_peralatan?id=' . $alat->id . '') . '" onclick="return confirm(\'Yakin ingin mengedit data ini ?\')" class="btn btn-sm btn-warning jedatombol" title="Edit Data alataraan ' . $alat->merk . '"><i class="fa fa-pen"></i></a> 
      <a href="' . site_url('home/hapus_data_peralatan?id=' . $alat->id . '') . '" onclick="return confirm(\'Yakin ingin menghapus data ini ?\')" class="btn btn-sm btn-danger jedatombol" title="Hapus Data alataraan ' . $alat->merk . '"><i class="fa fa-trash"></i></a> 
      </td>';
      $row[] = '<p class="text-center">' . $alat->id_asset . '</p>';
      // $row[] = $pemakai;
      $row[] = '<p class="text-center">' . $alat->bidang . '</p>';
      $row[] = '<p class="text-center">' . $alat->jenis . '</p>';
      $row[] = '<p class="text-center">' . $alat->merk . '</p>';
      // $row[] = '<p class="text-center">' . $alat->tipe . '</p>';
      // $row[] = '<p class="text-center">' . $alat->nama . '</p>';
      $row[] = '<p class="text-center">' . $alat->tahun_perolehan . '</p>';
      $row[] = '<img width="100%" src="'.base_url('assets/upload/foto_garansi_peralatan/'.$alat->foto_garansi).'" data-toggle="modal" data-target="#notaModal'.$no.'" alt="Foto Nota"></img>
        <div class="modal fade" id="notaModal'.$no.'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
         <div class="modal-content">
           <div class="modal-header">
             <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                 aria-hidden="true">&times;</span></button>
           </div>
           <div class="modal-body">
             <center>
               <img src="'.base_url('assets/upload/foto_garansi_peralatan/'.$alat->foto_garansi).'" alt="Foto Nota"
                 class="img-responsive" width="100%" height="auto">
             </center>
           </div>
           <div class="modal-footer">
             <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
           </div>
         </div>
        </div>
        </div>';

      $pisah=explode("-", $alat->garansi);
      $haripisah=explode(" ", $pisah[2]);
      $hari=$haripisah[0];
      $bulan=$pisah[1];
      $tahun=$pisah[0];
      $row[] = '<p class="text-center">' . $hari.'/'.$bulan.'/'.$tahun. '</p>';
      
      // $row[] = '<p class="text-center">' . $alat->lokasi_unit . '</p>';
      
      $row[] = '<p class="text-center">' . $alat->keterangan . '</p>';
      
      $data[] = $row;
    }
    $output = array(
      "draw" => $_POST['draw'],
      "recordsTotal" => $this->peralatan->count_all(),
      "recordsFiltered" => $this->peralatan->count_filtered(),
      "data" => $data,
    );
    echo json_encode($output);
  }
}


/* End of file Ajax.php */
/* Location: ./application/controllers/Ajax.php */