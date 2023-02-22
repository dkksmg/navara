 <!-- Content Header (Page header) -->
 <div class="content-header">
   <div class="container">
     <div class="row mb-2">
       <div class="col-sm-6">
         <!-- <h1 class="m-0"> Data  Kendaraan Dinas <small>NAVARA</small></h1> -->
       </div><!-- /.col -->
       <div class="col-sm-6">
         <ol class="breadcrumb float-sm-right">
         </ol>
       </div><!-- /.col -->
     </div><!-- /.row -->
   </div><!-- /.container-fluid -->
 </div>
 <!-- /.content-header -->

 <!-- Main content -->
 <div class="content">
   <div class="container">
     <div class="row">
       <div class="col-lg-12">
         <div class="card">
           <div class="card-header" style="background-color:#4a2f3a;">
             <h3 style="font-weight:bold;color:white;">Data Peralatan Dinas Anda</h3>
           </div>
           <div class="card-body">
             <table class="table table-striped">
                <tr>
                  <th width="250px">ID Aset</th>
                  <th width="20px">:</th>
                  <th colspan="4"><?= $alat['id_asset'] ?></th>
                </tr>
                <tr>
                  <th>Bidang</th>
                  <th>:</th>
                  <th colspan="4"><?= $alat['bidang'] ?></th>
                </tr>
                <tr>
                  <th>Jenis</th>
                  <th>:</th>
                  <th colspan="4"><?= $alat['jenis'] ?></th>
                </tr>
                <tr>
                  <th>Merk</th>
                  <th>:</th>
                  <th colspan="4"><?= $alat['merk'] ?></th>
                </tr>
                <tr>
                  <th>Tahun Perolehan</th>
                  <th>:</th>
                  <th colspan="4"><?= $alat['tahun_perolehan']; ?></th>
                </tr>
                <tr>
                  <th>Garansi</th>
                  <th>:</th>
                  <?php
                    $time=$alat['garansi'];
                    $year=substr($time, 0, 4);
                    $month=substr($time, 5, 2);
                    $day=substr($time, 8, 2);
                  ?>
                  <!-- <th colspan="4"><?//= $day.'/'.$month.'/'.$year ?></th> -->
                  <th><?= $day.'/'.$month.'/'.$year ?></th>
                  <th><img width="30%" src="<?= base_url('assets/upload/foto_garansi_peralatan/' . $alat['foto_garansi'] . '') ?>" data-toggle="modal" data-target="#garansiModal" alt="Foto Garansi"></th>
                  <th colspan="3"></th>
                </tr>
                <tr>
                  <th>Keterangan</th>
                  <th>:</th>
                  <th colspan="4"><?= $alat['keterangan'] ?></th>
                </tr>
                <tr style="width:100%">
                    <th style="width:25%">Pagu Peralatan Tahun <?= date('Y') ?></th>
                    <th style="width:5%">:</th>
                    <th style="width:20%">Rp. <?= isset($alat['pagu_awal']) ? number_format($alat['pagu_awal'], 2, ',', '.') : 0 ?></th>
                    <!-- <th style="width:20%">Rp. <?//= $pagu['pagu_awal'] ?></th> -->
                  
                    <th style="width:25%">Pagu Peralatan Tahun <?= date('Y')-1 ?></th>
                    <th style="width:5%">:</th>
                    <th style="width:20%">Rp. <?= isset($alat2['pagu_awal']) ? number_format($alat2['pagu_awal'], 2, ',', '.') : 0 ?></th>
                </tr>
                <tr>
                  <th>Pagu Terpakai</th>
                  <th>:</th>
                  <th>Rp. <?= isset($alat['total_biaya_servis']) ? number_format($alat['total_biaya_servis'], 2, ',', '.') : 0 ?></th>

                  <th>Pagu Terpakai</th>
                  <th>:</th>
                  <th>Rp. <?= isset($alat2['total_biaya_servis']) ? number_format($alat2['total_biaya_servis'], 2, ',', '.') : 0 ?></th>
                </tr>
                <?php
                  $alat['sisa']  = $alat['awal_pagu'] - $alat['total_biaya_servis'];
                  $alat2['sisa'] = $alat2['awal_pagu'] - $alat2['total_biaya_servis'];
                ?>
                <tr>
                  <th>Sisa Pagu</th>
                  <th>:</th>
                  <th>Rp. <?= isset($alat['sisa']) ? number_format($alat['sisa_pagu'], 2, ',', '.') : 0 ?></th>

                  <th>Sisa Pagu</th>
                  <th>:</th>
                  <th>Rp. <?= isset($alat2['sisa']) ? number_format($alat2['sisa_pagu'], 2, ',', '.') : 0 ?></th>
                </tr>
             </table>
           </div>
         </div>
       </div>
       <?= $this->load->view('pemakai/template/menu_layout_pemakai_peralatan', '', TRUE); ?>

       <div class="col-lg-12">
         <div class="card">
           <div class="card-header" style="background-color:#4a2f3a;">
             <h3 style="font-weight:bold;color:white;"><?= $title ?></h3>
           </div>
           <div id="accordion">
            <div class="row">
              <div class="col">
                <div class="card">
                  <div class="card-header" id="heading1">
                    <h5 class="mb-0" style="text-align: center">
                      <button class="btn btn-link" data-toggle="collapse" data-target="#collapse1" aria-expanded="true" aria-controls="collapse1">
                        <?= date('Y') ?>
                      </button>
                    </h5>
                  </div>
                </div>
              </div>
              <div class="col">
                <div class="card">
                  <div class="card-header" id="heading2">
                    <h5 class="mb-0" style="text-align: center;">
                      <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse2" aria-expanded="false" aria-controls="collapse2">
                        <?= date('Y')-1 ?>
                      </button>
                    </h5>
                  </div>                  
                </div>
              </div>
            </div>
            <div id="collapse1" class="collapse show" aria-labelledby="heading1" data-parent="#accordion">
              <div class="card-header">
               <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#modal-xl">
                 Tambah Pengajuan Servis
               </button>
              </div>
              <div class="card-body">
                <table class="table table-bordered table-striped example" width="100%;">
                 <thead>
                   <tr>
                     <th class="text-center">No</th>
                     <th class="text-center">Aksi</th>
                     <th class="text-center">Tanggal Pengajuan</th>
                     <th class="text-center">Tempat Servis</th>
                     <th class="text-center">Keluhan</th>
                     <th class="text-center">Servis</th>
                     <th class="text-center">Lain-Lain</th>
                     <th class="text-center">Status Pengajuan</th>
                   </tr>
                 </thead>
                 <tbody>
                   <?php $no = 1;
                                      if ($rp != '') {
                                          foreach ($rp as $value) { ?>
                   <tr>
                     <td class="text-center"><?= $no; ?></td>
                     <td class="text-center">
                       <?php if ($value['status_pengajuan'] == 'No') : ?>
                         <a onclick="editConfirm('<?= site_url('pemakai/editpengajuanservisperalatan?id=' . $value['id_pengajuan'] . '&idalat=' . $value['id_alat']) ?>')"
                           href="#" class="btn btn-sm btn-warning jedatombol"
                           title="Edit Pengajuan Servis"><i
                             class="fas fa-pencil"></i></a>
                         <?php elseif ($value['status_pengajuan'] == 'Yes') : ?>
                         <a onclick="cetakConfirm('<?= site_url('pemakai/cetakpengajuanservisperalatan?id=' . $value['id_pengajuan'] . '&id_alat=' . $value['id_alat'] . '') ?>')"
                           href="#" class="btn btn-sm btn-primary jedatombol"
                           title="Cetak Pengajuan Servis"><i
                             class="fa-solid fa-print"></i></a>
                         <?php else : ?>
                         <a onclick="editConfirm('<?= site_url('pemakai/editpengajuanservisperalatan?id=' . $value['id_pengajuan'] . '&idalat=' . $value['id_alat']) ?>')"
                           href="#" class="btn btn-sm btn-warning jedatombol disabled"
                           title="Edit Pengajuan Servis"><i
                             class="fas fa-pencil"></i></a>
                         <?php endif; ?>
                     </td>
                     <td class="text-center"><?= date('d-m-Y', strtotime($value['tgl_pengajuan'])) ?>
                     </td>
                     <td class="text-center"><?= $value['tempat_servis'] ?></td>
                     <td class="text-center"><?php if ($value['keluhan'] == '') : ?> -
                       <?php else : ?><?= $value['keluhan'] ?><?php endif ?></td>
                     <td class="text-center"><?php if ($value['servis'] == '') : ?> -
                       <?php else : ?><?= $value['servis'] ?><?php endif ?></td>
                     <td class="text-center"><?php if ($value['lain_lain'] == '') : ?> -
                       <?php else : ?><?= $value['lain_lain'] ?><?php endif ?>
                     </td>
                     <td class="text-center" width="15%">
                       <?php if ($value['status_pengajuan'] == 'Wait') : ?>
                              Perlu dicek <br><i style="color:red" class="fa-solid fa-triangle-exclamation"></i>
                       <?php elseif ($value['status_pengajuan'] == 'No') : ?>
                              Ditolak <i class=" fa-solid fa-circle-info" title="<?= $value['reject_reason'] ?>"></i><br><i style="color:red;font-size:12px">
                         Pengguna dapat menginput data kembali. <br>Reject on
                         <?= date('d-m-Y H:i:s', strtotime($value['update_pengajuan'])) ?></i>
                       <?php else : ?>
                       <?php if ($value['role'] == 'Superadmin' || $value['role'] == 'Admin') : ?>
                       Disetujui Oleh <?= $value['name'] ?>
                       <br><i style="color:green;font-size:12px">Approved on
                         <?= date('d-m-Y H:i:s', strtotime($value['tgl_terima'])) ?></i>
                       <?php else : ?>
                       Disetujui
                       <br><i style="color:green;font-size:12px">Approved on
                         <?= date('d-m-Y H:i:s', strtotime($value['tgl_terima'])) ?></i>
                       <?php endif ?>
                       <?php endif ?>
                     </td>
                   </tr>
                   <?php $no++;
                                          }
                                      } ?>
                 </tbody>
               </table>
              </div>
            </div>
            <div id="collapse2" class="collapse" aria-labelledby="heading2" data-parent="#accordion">
              <div class="card-header">
               <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#modal-xl">
                 Tambah Pengajuan Servis
               </button>
              </div>
              <div class="card-body">
                <table class="table table-bordered table-striped example" width="100%;">
                 <thead>
                   <tr>
                     <th class="text-center">No</th>
                     <th class="text-center">Aksi</th>
                     <th class="text-center">Tanggal Pengajuan</th>
                     <th class="text-center">Tempat Servis</th>
                     <th class="text-center">Keluhan</th>
                     <th class="text-center">Servis</th>
                     <th class="text-center">Lain-Lain</th>
                     <th class="text-center">Status Pengajuan</th>
                   </tr>
                 </thead>
                 <tbody>
                   <?php $no = 1;
                                      if ($rp2 != '') {
                                          foreach ($rp2 as $value) { ?>
                   <tr>
                     <td class="text-center"><?= $no; ?></td>
                     <td class="text-center">
                       <?php if ($value['status_pengajuan'] == 'No') : ?>
                         <a onclick="editConfirm('<?= site_url('pemakai/editpengajuanservisperalatan?id=' . $value['id_pengajuan'] . '&idalat=' . $value['id_alat']) ?>')"
                           href="#" class="btn btn-sm btn-warning jedatombol"
                           title="Edit Pengajuan Servis"><i
                             class="fas fa-pencil"></i></a>
                         <?php elseif ($value['status_pengajuan'] == 'Yes') : ?>
                         <a onclick="cetakConfirm('<?= site_url('pemakai/cetakpengajuanservisperalatan?id=' . $value['id_pengajuan'] . '&id_alat=' . $value['id_alat'] . '') ?>')"
                           href="#" class="btn btn-sm btn-primary jedatombol"
                           title="Cetak Pengajuan Servis <?= $kend['merk'] . ' ' . $kend['tipe'] . ' ' . $kend['no_polisi'] ?>"><i
                             class="fa-solid fa-print"></i></a>
                         <?php else : ?>
                         <a onclick="editConfirm('<?= site_url('pemakai/editpengajuanservisperalatan?id=' . $value['id_pengajuan'] . '&idalat=' . $value['id_alat']) ?>')"
                           href="#" class="btn btn-sm btn-warning jedatombol disabled"
                           title="Edit Pengajuan Servis"><i
                             class="fas fa-pencil"></i></a>
                         <?php endif; ?>
                     </td>
                     <td class="text-center"><?= date('d-m-Y', strtotime($value['tgl_pengajuan'])) ?>
                     </td>
                     <td class="text-center"><?= $value['tempat_servis'] ?></td>
                     <td class="text-center"><?php if ($value['keluhan'] == '') : ?> -
                       <?php else : ?><?= $value['keluhan'] ?><?php endif ?></td>
                     <td class="text-center"><?php if ($value['servis'] == '') : ?> -
                       <?php else : ?><?= $value['servis'] ?><?php endif ?></td>
                     <td class="text-center"><?php if ($value['lain_lain'] == '') : ?> -
                       <?php else : ?><?= $value['lain_lain'] ?><?php endif ?>
                     </td>
                     <td class="text-center" width="15%">
                       <?php if ($value['status_pengajuan'] == 'Wait') : ?>
                              Perlu dicek <br><i style="color:red" class="fa-solid fa-triangle-exclamation"></i>
                       <?php elseif ($value['status_pengajuan'] == 'No') : ?>
                              Ditolak <i class=" fa-solid fa-circle-info" title="<?= $value['reject_reason'] ?>"></i><br><i style="color:red;font-size:12px">
                         Pengguna dapat menginput data kembali. <br>Reject on
                         <?= date('d-m-Y H:i:s', strtotime($value['update_pengajuan'])) ?></i>
                       <?php else : ?>
                       <?php if ($value['role'] == 'Superadmin' || $value['role'] == 'Admin') : ?>
                       Disetujui Oleh <?= $value['name'] ?>
                       <br><i style="color:green;font-size:12px">Approved on
                         <?= date('d-m-Y H:i:s', strtotime($value['tgl_terima'])) ?></i>
                       <?php else : ?>
                       Disetujui
                       <br><i style="color:green;font-size:12px">Approved on
                         <?= date('d-m-Y H:i:s', strtotime($value['tgl_terima'])) ?></i>
                       <?php endif ?>
                       <?php endif ?>
                     </td>
                   </tr>
                   <?php $no++;
                                          }
                                      } ?>
                 </tbody>
               </table>
              </div>
            </div>
           </div>
           
         </div>
       </div>
     </div>
     <!-- /.row -->
   </div><!-- /.container-fluid -->
 </div>
 <!-- /.content -->
 <div class="modal fade" id="garansiModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
     <div class="modal-dialog" role="document">
       <div class="modal-content">
         <div class="modal-header">
           <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
         </div>
         <div class="modal-body">
           <center>
             <img src="<?= base_url('assets/upload/foto_garansi_peralatan/' . $alat['foto_garansi'] . '') ?>" alt="Foto Garansi"
               class="img-responsive" width="70%" height="auto">
           </center>
         </div>
         <div class="modal-footer">
           <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
         </div>
       </div>
     </div>
 </div>

 <div class=" modal fade" id="modal-xl">
   <div class="modal-dialog modal-xl">
     <form method="post" action="<?= site_url('pemakai/prosestambahpengajuanservisperalatan?id=' . $alat['id_alat'] . '') ?>"
       enctype="multipart/form-data">
       <div class="modal-content">
         <div class="modal-header">
           <h4 class="modal-title">Form Pengajuan Servis</h4>
           <button type="button" class="close" data-dismiss="modal" aria-label="Close">
             <span aria-hidden="true">&times;</span>
           </button>
         </div>
         <div class="modal-body">
           <div class="row">
             <div class="col-md-12">
               <div class="form-group">
                 <label>Tanggal Pengajuan</label>
                 <input type="text" class="form-control pilihtanggal" name="dari" placeholder="Tanggal Servis" required>
               </div>
             </div>
           </div>
           <div class="row">
             <div class="col-md-6">
               <div class="form-group">
                 <label>Tempat Servis</label>
                 <input type="text" placeholder="Masukkan Tempat Servis" class="form-control" name="tempat_servis">
               </div>
             </div>
             <div class="col-md-6">
               <div class="form-group">
                 <label>Keluhan</label>
                 <textarea type="text" placeholder="Masukkan Keluhan Peralatan Yang Anda Gunakan" class="form-control"
                   name="keluhan_peralatan"></textarea>
               </div>
             </div>
             <div class="col-md-6">
               <div class="form-group">
                 <label>Servis</label>
                 <textarea type="text" placeholder="Masukkan Servis Peralatan yang diinginkan" class="form-control"
                   name="servis_peralatan"></textarea>
               </div>
             </div>
             <div class="col-md-6">
               <div class="form-group">
                 <label>Lain - Lain</label>
                 <textarea type="text" placeholder="" class="form-control" name="lain_lain_peralatan"></textarea>
               </div>
             </div>
           </div>
         </div>
         <div class="modal-footer justify-content-between">
           <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
           <button type="sumbit" class="btn btn-primary">Simpan</button>
         </div>
       </div>
     </form>
   </div>
   <!-- /.modal-content -->
 </div>
 <!-- /.modal-dialog -->
 <!-- </div> -->
  


