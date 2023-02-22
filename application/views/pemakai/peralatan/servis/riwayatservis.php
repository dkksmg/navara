 <!-- Content Header (Page header) -->
 <div class="content-header">
   <div class="container">
     <div class="row mb-2">
       <div class="col-sm-6">
         <!-- <h1 class="m-0"> Data Kendaraan Dinas <small>NAVARA</small></h1> -->
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
             <h3 style="font-weight:bold;color:white;">Data Peralatan Dinas</h3>
           </div>
           <div class="card-body">
             <table class="table table-striped">
                <tr>
                  <th width="250px">ID Aset</th>
                  <th width="20px">:</th>
                  <th colspan="4"><?= $alat['id_asset'] ?></th>
                </tr>
                <tr>
                  <!-- <th>Lokasi Unit</th> -->
                  <th>Bidang</th>
                  <th>:</th>
                  <th colspan="4"><?= $alat['bidang'] ?></th>
                </tr>
                <?//php if($alat['pemegang']!=null) {?>
                <!-- <tr>
                  <th>Pemakai</th>
                  <th>:</th>
                  <th colspan="4"><?//= $pmk['name'] ?></th>
                </tr> -->
                <?//php } ?>
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
                <tr>
                  <th>Sisa Pagu</th>
                  <th>:</th>
                  <th>Rp. <?= isset($alat['sisa_pagu']) ? number_format($alat['sisa_pagu'], 2, ',', '.') : 0 ?></th>

                  <th>Sisa Pagu</th>
                  <th>:</th>
                  <th>Rp. <?= isset($alat2['sisa_pagu']) ? number_format($alat2['sisa_pagu'], 2, ',', '.') : 0 ?></th>
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
               <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#modalTambah">
                 Tambah Riwayat Servis
               </button>
              </div>
              <div class="card-body">
               <div class="table-responsive">
                 <table class="table table-bordered table-striped example" width="100%" height="auto">
                   <thead>
                     <tr>
                       <th class="text-center">No</th>
                       <th class="text-center">Aksi</th>
                       <th class="text-center">Tgl Service</th>
                       <th class="text-center">Tempat Service</th>
                       <th class="text-center">Biaya</th>
                       <th class="text-center">Foto Nota</th>
                       <th class="text-center">Keterangan</th>
                       <th class="text-center">Status</th>
                     </tr>
                   </thead>
                   <tbody>
                     <?php
                      if ($rs != '') :
                        $no = 1;
                        foreach ($rs as $value) : ?>
                     <tr>
                       <td class="text-center"><?= $no; ?></td>
                       <td class="text-center">
                         <?php if ($value['status_srv'] == 'Wait') : ?>
                         <a onclick="editConfirm('#')" href="#" class="btn btn-sm btn-warning jedatombol disabled"><i
                             class="fas fa-pen" title="Edit Riwayat Servis"></i></a>
                         <?php elseif ($value['status_srv'] == 'Yes') : ?>
                         <a onclick="editConfirm('#')" href="#" class="btn btn-sm btn-warning jedatombol disabled"><i
                             class="fas fa-pen" title="Edit Riwayat Servis"></i></a>
                         <?php else : ?>
                         <a style="display: none" onclick="deleteConfirm('#')" href="#"
                           class="btn btn-sm btn-danger jedatombol disabled"><i class="fas fa-trash"
                             title="Hapus Riwayat Servis"></i></a>
                         <a onclick="editConfirm('<?= site_url('pemakai/editriwayatservisperalatan?id=' . $value['id_rs'] . '&idalat=' . $value['id_alat']) ?>')"
                           href="#" class="btn btn-warning btn-sm jedatombol"
                           title="Edit Riwayat Servis"><i class="fas fa-pen"></i></a>
                         <?php endif ?>
                       </td>
                       <td class="text-center"><?= date('d-m-Y', strtotime($value['tgl_servis'])) ?></td>
                       <td class="text-center">
                         <?php if (($value['tempat_servis']) != null) : ?>
                         <?= $value['tempat_servis']; ?>
                         <?php else : ?>
                         <p> - </p>
                         <?php endif; ?>
                       </td>
                       <td class="text-center">
                         <?php if (is_numeric($value['biaya'])) : ?>
                         <?= "Rp. " . number_format($value['biaya'], 2, ',', '.'); ?>
                         <?php elseif (($value['biaya']) == null) : ?>
                         <p> - </p>
                         <?php else : ?>
                         <?= $value['biaya'] ?>
                         <?php endif; ?>
                       </td>
                       <td class="text-center">
                         <?php if (!empty($value['foto_nota'])) : ?>
                         <img width="30%"
                           src="<?= base_url('assets/upload/foto_nota/peralatan/' . $value['foto_nota'] . '') ?>"
                           data-toggle="modal" data-target="#notaModal<?php echo $no ?>" alt="Foto Nota">
                         <?php else : ?>
                         <p data-toggle="modal" data-target="#notaModal<?php echo $no ?>"> - </p>
                         <?php endif ?>
                       </td>
                       <td class="text-center"><?= $value['ket_servis'] ?></td>
                       <td class="text-center" width="10%">
                         <?php if ($value['status_srv'] == 'Wait') : ?>
                         <p>Sedang Diverifikasi</p>
                         <?php elseif ($value['status_srv'] == 'No') : ?>
                         Ditolak<br><i style="color:red;font-size:12px">
                           <?= $value['reject_reason'] ?>.
                           Silakan melakukan input/edit data kembali.<br>Reject on
                           <?= date('d-m-Y H:i:s', strtotime($value['tgl_terima'])) ?></i>
                         <?php else : ?>
                         Disetujui
                         <br><i style="color:green;font-size:12px">Approved on
                           <?= date('d-m-Y H:i:s', strtotime($value['update_srv'])) ?></i>
                         <?php endif ?>
                       </td>

                     </tr>
                     <?php $no++;
                        endforeach;
                      endif; ?>
                   </tbody>
                 </table>
               </div>
              </div>
            </div>
            <div id="collapse2" class="collapse" aria-labelledby="heading2" data-parent="#accordion">
              <div class="card-header">
               <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#modalTambah">
                 Tambah Riwayat Servis
               </button>
              </div>
              <div class="card-body">
               <div class="table-responsive">
                 <table class="table table-bordered table-striped example" width="100%" height="auto">
                   <thead>
                     <tr>
                       <th class="text-center">No</th>
                       <th class="text-center">Aksi</th>
                       <th class="text-center">Tgl Service</th>
                       <th class="text-center">Tempat Service</th>
                       <th class="text-center">Biaya</th>
                       <th class="text-center">Foto Nota</th>
                       <th class="text-center">Keterangan</th>
                       <th class="text-center">Status</th>
                     </tr>
                   </thead>
                   <tbody>
                     <?php
                      if ($rs2 != '') :
                        $no = 1;
                        foreach ($rs2 as $value) : ?>
                     <tr>
                       <td class="text-center"><?= $no; ?></td>
                       <td class="text-center">
                         <?php if ($value['status_srv'] == 'Wait') : ?>
                         <a onclick="editConfirm('#')" href="#" class="btn btn-sm btn-warning jedatombol disabled"><i
                             class="fas fa-pen" title="Edit Riwayat Servis"></i></a>
                         <?php elseif ($value['status_srv'] == 'Yes') : ?>
                         <a onclick="editConfirm('#')" href="#" class="btn btn-sm btn-warning jedatombol disabled"><i
                             class="fas fa-pen" title="Edit Riwayat Servis"></i></a>
                         <?php else : ?>
                         <a style="display: none" onclick="deleteConfirm('#')" href="#"
                           class="btn btn-sm btn-danger jedatombol disabled"><i class="fas fa-trash"
                             title="Hapus Riwayat Servis"></i></a>
                         <a onclick="editConfirm('<?= site_url('pemakai/editriwayatservisperalatan?id=' . $value['id_rs'] . '&idalat=' . $value['id_alat']) ?>')"
                           href="#" class="btn btn-warning btn-sm jedatombol"
                           title="Edit Riwayat Servis"><i class="fas fa-pen"></i></a>
                         <?php endif ?>
                       </td>
                       <td class="text-center"><?= date('d-m-Y', strtotime($value['tgl_servis'])) ?></td>
                       <td class="text-center">
                         <?php if (($value['tempat_servis']) != null) : ?>
                         <?= $value['tempat_servis']; ?>
                         <?php else : ?>
                         <p> - </p>
                         <?php endif; ?>
                       </td>
                       <td class="text-center">
                         <?php if (is_numeric($value['biaya'])) : ?>
                         <?= "Rp. " . number_format($value['biaya'], 2, ',', '.'); ?>
                         <?php elseif (($value['biaya']) == null) : ?>
                         <p> - </p>
                         <?php else : ?>
                         <?= $value['biaya'] ?>
                         <?php endif; ?>
                       </td>
                       <td class="text-center">
                         <?php if (!empty($value['foto_nota'])) : ?>
                         <img width="30%"
                           src="<?= base_url('assets/upload/foto_nota/peralatan/' . $value['foto_nota'] . '') ?>"
                           data-toggle="modal" data-target="#notaModal2<?php echo $no ?>" alt="Foto Nota">
                         <?php else : ?>
                         <p data-toggle="modal" data-target="#notaModal2<?php echo $no ?>"> - </p>
                         <?php endif ?>
                       </td>
                       <td class="text-center"><?= $value['ket_servis'] ?></td>
                       <td class="text-center" width="10%">
                         <?php if ($value['status_srv'] == 'Wait') : ?>
                         <p>Sedang Diverifikasi</p>
                         <?php elseif ($value['status_srv'] == 'No') : ?>
                         Ditolak<br><i style="color:red;font-size:12px">
                           <?= $value['reject_reason'] ?>.
                           Silakan melakukan input/edit data kembali.<br>Reject on
                           <?= date('d-m-Y H:i:s', strtotime($value['datetime_approve'])) ?></i>
                         <?php else : ?>
                         Disetujui
                         <br><i style="color:green;font-size:12px">Approved on
                           <?= date('d-m-Y H:i:s', strtotime($value['datetime_approve'])) ?></i>
                         <?php endif ?>
                       </td>

                     </tr>
                     <?php $no++;
                        endforeach;
                      endif; ?>
                   </tbody>
                 </table>
               </div>
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

 <!-- Modal Foto Servis & Nota -->
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
 <?php
  if ($rs != '') :
    $no = 1;
    foreach ($rs as $value) : ?>
 <center>
   <!-- Modal -->
   <div class="modal fade" id="notaModal<?php echo $no?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
     <div class="modal-dialog" role="document">
       <div class="modal-content">
         <div class="modal-header">
           <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
         </div>
         <div class="modal-body">
           <center>
             <img src="<?= base_url('assets/upload/foto_nota/peralatan/' . $value['foto_nota'] . '') ?>" alt="Foto Nota"
               class="img-responsive" width="70%" height="auto">
           </center>
         </div>
         <div class="modal-footer">
           <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
         </div>
       </div>
     </div>
   </div>
 </center>
 <?php $no++;
    endforeach;
  endif ?>

  <?php
  if ($rs2 != '') :
    $no = 1;
    foreach ($rs2 as $value) : ?>
 <center>
   <!-- Modal -->
   <div class="modal fade" id="notaModal2<?php echo $no?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
     <div class="modal-dialog" role="document">
       <div class="modal-content">
         <div class="modal-header">
           <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
         </div>
         <div class="modal-body">
           <center>
             <img src="<?= base_url('assets/upload/foto_nota/peralatan/' . $value['foto_nota'] . '') ?>" alt="Foto Nota"
               class="img-responsive" width="70%" height="auto">
           </center>
         </div>
         <div class="modal-footer">
           <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
         </div>
       </div>
     </div>
   </div>
 </center>
 <?php $no++;
    endforeach;
  endif ?>

 <!-- Modal Input -->
 <div class="modal fade" id="modalTambah" role="dialog">
   <div class="modal-dialog modal-xl">
     <form method="post" action="<?= site_url('pemakai/prosestambahservisperalatan?id=' . $alat['id'] . '') ?>"
       enctype="multipart/form-data">
       <div class="modal-content">
         <div class="modal-header">
           <h4 class="modal-title">Form Riwayat Servis</h4>
           <button type="button" class="close" data-dismiss="modal" aria-label="Close">
             <span aria-hidden="true">&times;</span>
           </button>
         </div>
         <div class="modal-body">
           <div class="row">
             <div class="col-md-12">
               <div class="form-group">
                 <label>Tanggal Service</label>
                 <input type="text" class="form-control pilihtanggal" name="tgl" placeholder="Tanggal Servis" required>
               </div>
             </div>
           </div>
           <div class="row">
            <div class="col-md-12">
               <div class="form-group">
                 <label>Nama Tempat Service</label>
                 <input type="text" class="form-control" name="tempat_servis" placeholder="Nama Tempat">
               </div>
             </div>
           </div>
           <div class="row">
             <div class="col-md-12">
               <div class="form-group">
                 <label>Biaya</label>
                 <input type="number" class="form-control" id="result" name="biaya" placeholder="Total Biaya">
               </div>
             </div>
           </div>
           <div class="row">
             <div class="col-md-12">
               <div class="form-group">
                 <label>Foto Nota</label>
                 <input type="file" class="form-control" name="nota" accept="image/*">
               </div>
             </div>
           </div>
           <div class="row">
             <div class="col-md-12">
               <div class="form-group">
                 <label>Keterangan</label>
                 <textarea type="text" placeholder="Keterangan Servis" class="form-control"
                   name="keterangan"></textarea>
               </div>
             </div>
           </div>
         </div>
         <div class="modal-footer justify-content-between">
           <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
           <button type="sumbit" class="btn btn-primary">Simpan</button>
         </div>
     </form>
   </div>
   <!-- /.modal-content -->
 </div>
 </div>