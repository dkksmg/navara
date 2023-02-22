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
         <?= $this->load->view('admin/template/data_kend_layout', '', TRUE); ?>
         <?= $this->load->view('admin/template/menu_layout_admin', '', TRUE); ?>

       </div>
       <div class="col-lg-12">
         <div class="card">
           <div class="card-header" style="background-color:#4a2f3a;">
             <h3 style="font-weight:bold;color:white;">Riwayat Servis</h3>
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
                       <th class="text-center" rowspan="2">No</th>
                       <th class="text-center" colspan="2">Aksi</th>
                       <th class="text-center" rowspan="2">Tgl Service</th>
                       <th class="text-center" rowspan="2">Bengkel Service</th>
                       <th class="text-center" rowspan="2">Service</th>
                       <th class="text-center" rowspan="2">Sparepart</th>
                       <th class="text-center" rowspan="2">Oli</th>
                       <th class="text-center" rowspan="2">Total Biaya</th>
                       <th class="text-center" rowspan="2">Foto Service</th>
                       <th class="text-center" rowspan="2">Foto Nota</th>
                       <th class="text-center" rowspan="2">Status</th>
                       <th class="text-center" rowspan="2">Last Update By</th>
                     </tr>
                     <tr>
                       <th class="text-center"></th>
                       <th class="text-center"></th>
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
                         <a onclick="deleteConfirm('<?= site_url('home/delete_servis?id=' . ($value['id_rs']) . '') ?>')"
                           href="#" class="btn btn-danger btn-sm jedatombol"
                           title="Hapus Riwayat Servis <?= $kend['no_polisi'] ?>"><i class="fas fa-trash"></i></a>
                         <a onclick="editConfirm('<?= site_url('home/editriwayatservis?id=' . $value['id_rs'] . '') ?>')"
                           href="#" class="btn btn-warning btn-sm jedatombol"
                           title="Edit Riwayat Servis <?= $kend['no_polisi'] ?>"><i class="fas fa-pen"></i></a>
                       </td>
                       <td class="text-center">
                         <?php if ($value['status_srs'] == 'No' || $value['status_srs'] == 'Wait') : ?>
                         <a href="#"
                           onclick="approveConfirm('<?= site_url('home/approve_servis?id=' . $value['id_rs'] . '') ?>')"
                           class="btn btn-sm btn-success jedatombol"
                           title="Setujui Riwayat Servis <?= $kend['merk'] . ' ' . $kend['tipe'] . ' ' . $kend['no_polisi'] ?>">
                           <i class="fa-solid fa-badge-check"></i></a>
                         <a href="#"
                           onclick="waitConfirm('<?= site_url('home/wait_servis?id=' . $value['id_rs'] . '') ?>')"
                           class="btn btn-sm btn-dark jedatombol <?php if ($value['status_srs'] == 'Wait') : ?> disabled <?php endif; ?>"
                           title="Set Wait Riwayat Servis <?= $kend['merk'] . ' ' . $kend['tipe'] . ' ' . $kend['no_polisi'] ?>">
                           <i class="fa-solid fa-circle-pause"></i></a>
                         <a href="#" data-toggle="modal" data-target="#modal_reject<?php echo $no ?>"
                           class="btn btn-sm btn-danger jedatombol <?php if ($value['status_srs'] == 'No') : ?> disabled <?php endif; ?>"
                           title="Tolak Riwayat Servis <?= $kend['merk'] . ' ' . $kend['tipe'] . ' ' . $kend['no_polisi'] ?>"><i
                             class="fa-solid fa-circle-xmark"></i></a>
                         <?php else : ?>
                         <a href="#" data-toggle="modal" data-target="#modal_reject<?php echo $no ?>"
                           class="btn btn-sm btn-danger jedatombol"
                           title="Tolak Riwayat Servis <?= $kend['merk'] . ' ' . $kend['tipe'] . ' ' . $kend['no_polisi'] ?>"><i
                             class="fa-solid fa-circle-xmark"></i></a>
                         <a href="#"
                           onclick="waitConfirm('<?= site_url('home/wait_servis?id=' . $value['id_rs'] . '') ?>')"
                           class="btn btn-sm btn-dark jedatombol"
                           title="Set Wait Riwayat Servis <?= $kend['merk'] . ' ' . $kend['tipe'] . ' ' . $kend['no_polisi'] ?>">
                           <i class="fa-solid fa-circle-pause"></i></a>
                         <?php endif; ?>
                       </td>
                       <td class="text-center"><?= date('d-m-Y', strtotime($value['tgl_servis'])) ?></td>
                       <td class="text-center"> <?php if (($value['lokasi']) == null) : ?>
                         <p> - </p>
                         <?php else : ?>
                         <?= $value['lokasi']; ?>
                         <?php endif; ?>
                       </td>
                       <td class="text-center">
                         <?php if (is_numeric($value['service'])) : ?>
                         <?= "Rp. " . number_format($value['service'], 2, ',', '.'); ?>
                         <?php elseif (($value['service']) == null) : ?>
                         <p> - </p>
                         <?php else : ?>
                         <?= $value['service'] ?>
                         <?php endif; ?>
                       </td>
                       <td class="text-center">
                         <?php if (is_numeric($value['sparepart'])) : ?>
                         <?= "Rp. " . number_format($value['sparepart'], 2, ',', '.'); ?>
                         <?php elseif (($value['sparepart']) == null) : ?>
                         <p> - </p>
                         <?php else : ?>
                         <?= $value['sparepart'] ?>
                         <?php endif; ?>
                       </td>
                       <td class="text-center">
                         <?php if (is_numeric($value['oli'])) : ?>
                         <?= "Rp. " . number_format($value['oli'], 2, ',', '.'); ?>
                         <?php elseif (($value['oli']) == null) : ?>
                         <p> - </p>
                         <?php else : ?>
                         <?= $value['oli'] ?>
                         <?php endif; ?>
                       </td>
                       <td class="text-left">
                         <?= "Rp. " . number_format($value['total_biaya'], 2, ',', '.'); ?></td>
                       <td class="text-center">
                         <?php if (!empty($value['foto_servis'])) : ?>
                         <img width="100%"
                           src="<?= base_url('assets/upload/foto_servis/' . $value['foto_servis'] . '') ?>"
                           data-toggle="modal" data-target="#servisModal<?php echo $no ?>" alt="Foto Servis">
                         <?php else : ?>
                         <p data-toggle="modal" data-target="#servisModal<?php echo $no ?>"> - </p>
                         <?php endif ?>
                       </td>
                       <td class="text-center">
                         <?php if (!empty($value['foto_nota'])) : ?>
                         <img width="100%" src="<?= base_url('assets/upload/foto_nota/' . $value['foto_nota'] . '') ?>"
                           data-toggle="modal" data-target="#notaModal<?php echo $no ?>" alt="Foto Nota">
                         <?php else : ?>
                         <p data-toggle="modal" data-target="#notaModal<?php echo $no ?>"> - </p>
                         <?php endif ?>
                       </td>
                       <td class="text-center" width="15%">
                         <?php if ($value['status_srs'] == 'Wait') : ?>
                         Perlu dicek <br><i style="color:red" class="fa-solid fa-triangle-exclamation"></i>
                         <?php elseif ($value['status_srs'] == 'No') : ?>
                         Ditolak <i class=" fa-solid fa-circle-info" title="<?= $value['reject_reason'] ?>">
                         </i><br><i style="color:red;font-size:12px">
                           Pengguna dapat menginput data kembali. <br>Reject on
                           <?= date('d-m-Y H:i:s', strtotime($value['datetime_approve'])) ?></i>
                         <?php else : ?>
                         <?php if ($value['role'] == 'Superadmin' || $value['role'] == 'Admin') : ?>
                         Disetujui Oleh <?= $value['name'] ?>
                         <br><i style="color:green;font-size:12px">Approved on
                           <?= date('d-m-Y H:i:s', strtotime($value['datetime_approve'])) ?></i>
                         <?php else : ?>
                         Disetujui
                         <br><i style="color:green;font-size:12px">Approved on
                           <?= date('d-m-Y H:i:s', strtotime($value['datetime_approve'])) ?></i>
                         <?php endif ?>
                         <?php endif ?>
                       </td>
                       <td class="text-center">
                         <?= $value['name'] ?><br>
                         <i
                           style="color:black;font-size:12px"><b><?= date('d-m-Y H:i:s', strtotime($value['last_time_update'])) ?></b></i>
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
                       <th class="text-center" rowspan="2">No</th>
                       <th class="text-center" colspan="2">Aksi</th>
                       <th class="text-center" rowspan="2">Tgl Service</th>
                       <th class="text-center" rowspan="2">Bengkel Service</th>
                       <th class="text-center" rowspan="2">Service</th>
                       <th class="text-center" rowspan="2">Sparepart</th>
                       <th class="text-center" rowspan="2">Oli</th>
                       <th class="text-center" rowspan="2">Total Biaya</th>
                       <th class="text-center" rowspan="2">Foto Service</th>
                       <th class="text-center" rowspan="2">Foto Nota</th>
                       <th class="text-center" rowspan="2">Status</th>
                       <th class="text-center" rowspan="2">Last Update By</th>
                     </tr>
                     <tr>
                       <th class="text-center"></th>
                       <th class="text-center"></th>
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
                         <a onclick="deleteConfirm('<?= site_url('home/delete_servis?id=' . ($value['id_rs']) . '') ?>')"
                           href="#" class="btn btn-danger btn-sm jedatombol"
                           title="Hapus Riwayat Servis <?= $kend['no_polisi'] ?>"><i class="fas fa-trash"></i></a>
                         <a onclick="editConfirm('<?= site_url('home/editriwayatservis?id=' . $value['id_rs'] . '') ?>')"
                           href="#" class="btn btn-warning btn-sm jedatombol"
                           title="Edit Riwayat Servis <?= $kend['no_polisi'] ?>"><i class="fas fa-pen"></i></a>
                       </td>
                       <td class="text-center">
                         <?php if ($value['status_srs'] == 'No' || $value['status_srs'] == 'Wait') : ?>
                         <a href="#"
                           onclick="approveConfirm('<?= site_url('home/approve_servis?id=' . $value['id_rs'] . '') ?>')"
                           class="btn btn-sm btn-success jedatombol"
                           title="Setujui Riwayat Servis <?= $kend['merk'] . ' ' . $kend['tipe'] . ' ' . $kend['no_polisi'] ?>">
                           <i class="fa-solid fa-badge-check"></i></a>
                         <a href="#"
                           onclick="waitConfirm('<?= site_url('home/wait_servis?id=' . $value['id_rs'] . '') ?>')"
                           class="btn btn-sm btn-dark jedatombol <?php if ($value['status_srs'] == 'Wait') : ?> disabled <?php endif; ?>"
                           title="Set Wait Riwayat Servis <?= $kend['merk'] . ' ' . $kend['tipe'] . ' ' . $kend['no_polisi'] ?>">
                           <i class="fa-solid fa-circle-pause"></i></a>
                         <a href="#" data-toggle="modal" data-target="#modal_reject2<?php echo $no ?>"
                           class="btn btn-sm btn-danger jedatombol <?php if ($value['status_srs'] == 'No') : ?> disabled <?php endif; ?>"
                           title="Tolak Riwayat Servis <?= $kend['merk'] . ' ' . $kend['tipe'] . ' ' . $kend['no_polisi'] ?>"><i
                             class="fa-solid fa-circle-xmark"></i></a>
                         <?php else : ?>
                         <a href="#" data-toggle="modal" data-target="#modal_reject2<?php echo $no ?>"
                           class="btn btn-sm btn-danger jedatombol"
                           title="Tolak Riwayat Servis <?= $kend['merk'] . ' ' . $kend['tipe'] . ' ' . $kend['no_polisi'] ?>"><i
                             class="fa-solid fa-circle-xmark"></i></a>
                         <a href="#"
                           onclick="waitConfirm('<?= site_url('home/wait_servis?id=' . $value['id_rs'] . '') ?>')"
                           class="btn btn-sm btn-dark jedatombol"
                           title="Set Wait Riwayat Servis <?= $kend['merk'] . ' ' . $kend['tipe'] . ' ' . $kend['no_polisi'] ?>">
                           <i class="fa-solid fa-circle-pause"></i></a>
                         <?php endif; ?>
                       </td>
                       <td class="text-center"><?= date('d-m-Y', strtotime($value['tgl_servis'])) ?></td>
                       <td class="text-center"> <?php if (($value['lokasi']) == null) : ?>
                         <p> - </p>
                         <?php else : ?>
                         <?= $value['lokasi']; ?>
                         <?php endif; ?>
                       </td>
                       <td class="text-center">
                         <?php if (is_numeric($value['service'])) : ?>
                         <?= "Rp. " . number_format($value['service'], 2, ',', '.'); ?>
                         <?php elseif (($value['service']) == null) : ?>
                         <p> - </p>
                         <?php else : ?>
                         <?= $value['service'] ?>
                         <?php endif; ?>
                       </td>
                       <td class="text-center">
                         <?php if (is_numeric($value['sparepart'])) : ?>
                         <?= "Rp. " . number_format($value['sparepart'], 2, ',', '.'); ?>
                         <?php elseif (($value['sparepart']) == null) : ?>
                         <p> - </p>
                         <?php else : ?>
                         <?= $value['sparepart'] ?>
                         <?php endif; ?>
                       </td>
                       <td class="text-center">
                         <?php if (is_numeric($value['oli'])) : ?>
                         <?= "Rp. " . number_format($value['oli'], 2, ',', '.'); ?>
                         <?php elseif (($value['oli']) == null) : ?>
                         <p> - </p>
                         <?php else : ?>
                         <?= $value['oli'] ?>
                         <?php endif; ?>
                       </td>
                       <td class="text-left">
                         <?= "Rp. " . number_format($value['total_biaya'], 2, ',', '.'); ?></td>
                       <td class="text-center">
                         <?php if (!empty($value['foto_servis'])) : ?>
                         <img width="100%"
                           src="<?= base_url('assets/upload/foto_servis/' . $value['foto_servis'] . '') ?>"
                           data-toggle="modal" data-target="#servisModal2<?php echo $no ?>" alt="Foto Servis">
                         <?php else : ?>
                         <p data-toggle="modal" data-target="#servisModal2<?php echo $no ?>"> - </p>
                         <?php endif ?>
                       </td>
                       <td class="text-center">
                         <?php if (!empty($value['foto_nota'])) : ?>
                         <img width="100%" src="<?= base_url('assets/upload/foto_nota/' . $value['foto_nota'] . '') ?>"
                           data-toggle="modal" data-target="#notaModal2<?php echo $no ?>" alt="Foto Nota">
                         <?php else : ?>
                         <p data-toggle="modal" data-target="#notaModal2<?php echo $no ?>"> - </p>
                         <?php endif ?>
                       </td>
                       <td class="text-center" width="15%">
                         <?php if ($value['status_srs'] == 'Wait') : ?>
                         Perlu dicek <br><i style="color:red" class="fa-solid fa-triangle-exclamation"></i>
                         <?php elseif ($value['status_srs'] == 'No') : ?>
                         Ditolak <i class=" fa-solid fa-circle-info" title="<?= $value['reject_reason'] ?>">
                         </i><br><i style="color:red;font-size:12px">
                           Pengguna dapat menginput data kembali. <br>Reject on
                           <?= date('d-m-Y H:i:s', strtotime($value['datetime_approve'])) ?></i>
                         <?php else : ?>
                         <?php if ($value['role'] == 'Superadmin' || $value['role'] == 'Admin') : ?>
                         Disetujui Oleh <?= $value['name'] ?>
                         <br><i style="color:green;font-size:12px">Approved on
                           <?= date('d-m-Y H:i:s', strtotime($value['datetime_approve'])) ?></i>
                         <?php else : ?>
                         Disetujui
                         <br><i style="color:green;font-size:12px">Approved on
                           <?= date('d-m-Y H:i:s', strtotime($value['datetime_approve'])) ?></i>
                         <?php endif ?>
                         <?php endif ?>
                       </td>
                       <td class="text-center">
                         <?= $value['name'] ?><br>
                         <i
                           style="color:black;font-size:12px"><b><?= date('d-m-Y H:i:s', strtotime($value['last_time_update'])) ?></b></i>
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
 <?php
  if ($rs != '') :
    $no = 1;
    foreach ($rs as $value) : ?>
 <justify>
   <!-- Modal -->

   <div class="modal fade" id="modal_reject<?= $no ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
     <div class="modal-dialog" role="document">
       <?= form_open('home/reject_servis?id=' . $value['id_rs']) ?>
       <div class="modal-content">
         <div class="modal-header">
           <h5 class="modal-title" id="exampleModalLabel">Yakin ingin menolak Data ini ?</h5>
           <button class="close" type="button" data-dismiss="modal" aria-label="Close">
             <span aria-hidden="true">&times;</span>
           </button>
         </div>
         <div class="modal-body">
           <div class="row">
             <div class="col-md-6">
               <div class="form-group">
                 <label>Alasan Penolakan</label>
                 <input type="text" class="form-control" name="reason_reject" placeholder="Masukkan Alasan Penolakan"
                   value="<?= isset($value) ? $value['reject_reason'] : ""; ?>" required>
               </div>
             </div>
           </div>
         </div>
         <div class="modal-footer justify-content-between">
           <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
           <button type="sumbit" class="btn btn-primary">Simpan</button>

         </div>
       </div>
       <?= form_close() ?>
     </div>
   </div>

   <div class="modal fade" id="servisModal<?php echo $no ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
     <div class="modal-dialog" role="document">
       <div class="modal-content">
         <div class="modal-header">
           <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
               aria-hidden="true">&times;</span></button>
         </div>
         <div class="modal-body">
           <center>
             <img src="<?= base_url('assets/upload/foto_servis/' . $value['foto_servis'] . '') ?>" alt="Foto Servis"
               class="img-responsive" width="70%" height="auto">
           </center>
         </div>
         <div class="modal-footer">
           <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
         </div>
       </div>
     </div>
   </div>
   <div class="modal fade" id="notaModal<?php echo $no ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
     <div class="modal-dialog" role="document">
       <div class="modal-content">
         <div class="modal-header">
           <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
               aria-hidden="true">&times;</span></button>
         </div>
         <div class="modal-body">
           <center>
             <img src="<?= base_url('assets/upload/foto_nota/' . $value['foto_nota'] . '') ?>" alt="Foto Nota"
               class="img-responsive" width="70%" height="auto">
           </center>
         </div>
         <div class="modal-footer">
           <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
         </div>
       </div>
     </div>
   </div>
 </justify>
 <?php $no++;
    endforeach;
  endif ?>

  <?php
  if ($rs2 != '') :
    $no = 1;
    foreach ($rs2 as $value) : ?>
 <justify>
   <!-- Modal -->

   <div class="modal fade" id="modal_reject2<?= $no ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
     <div class="modal-dialog" role="document">
       <?= form_open('home/reject_servis?id=' . $value['id_rs']) ?>
       <div class="modal-content">
         <div class="modal-header">
           <h5 class="modal-title" id="exampleModalLabel">Yakin ingin menolak Data ini ?</h5>
           <button class="close" type="button" data-dismiss="modal" aria-label="Close">
             <span aria-hidden="true">&times;</span>
           </button>
         </div>
         <div class="modal-body">
           <div class="row">
             <div class="col-md-6">
               <div class="form-group">
                 <label>Alasan Penolakan</label>
                 <input type="text" class="form-control" name="reason_reject" placeholder="Masukkan Alasan Penolakan"
                   value="<?= isset($value) ? $value['reject_reason'] : ""; ?>" required>
               </div>
             </div>
           </div>
         </div>
         <div class="modal-footer justify-content-between">
           <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
           <button type="sumbit" class="btn btn-primary">Simpan</button>

         </div>
       </div>
       <?= form_close() ?>
     </div>
   </div>

   <div class="modal fade" id="servisModal2<?php echo $no ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
     <div class="modal-dialog" role="document">
       <div class="modal-content">
         <div class="modal-header">
           <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
               aria-hidden="true">&times;</span></button>
         </div>
         <div class="modal-body">
           <center>
             <img src="<?= base_url('assets/upload/foto_servis/' . $value['foto_servis'] . '') ?>" alt="Foto Servis"
               class="img-responsive" width="70%" height="auto">
           </center>
         </div>
         <div class="modal-footer">
           <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
         </div>
       </div>
     </div>
   </div>
   <div class="modal fade" id="notaModal2<?php echo $no ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
     <div class="modal-dialog" role="document">
       <div class="modal-content">
         <div class="modal-header">
           <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
               aria-hidden="true">&times;</span></button>
         </div>
         <div class="modal-body">
           <center>
             <img src="<?= base_url('assets/upload/foto_nota/' . $value['foto_nota'] . '') ?>" alt="Foto Nota"
               class="img-responsive" width="70%" height="auto">
           </center>
         </div>
         <div class="modal-footer">
           <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
         </div>
       </div>
     </div>
   </div>
 </justify>
 <?php $no++;
    endforeach;
  endif ?>

 <!-- Modal Input -->
 <div class="modal fade" id="modalTambah" role="dialog">
   <div class="modal-dialog modal-xl">
     <form method="post" action="<?= site_url('home/prosestambahservis?id=' . $kend['idk'] . '') ?>"
       enctype="multipart/form-data">
       <?php
        echo form_hidden('tipe', $kend['tipe']);
        echo form_hidden('no_pol', $kend['no_polisi']);
        ?>
       <div class="modal-content">
         <div class="modal-header">
           <h4 class="modal-title">Form Riwayat Servis</h4>
           <button type="button" class="close" data-dismiss="modal" aria-label="Close">
             <span aria-hidden="true">&times;</span>
           </button>
         </div>
         <div class="modal-body">
           <div class="row">
             <div class="col-md-6">
               <div class="form-group">
                 <label>Tanggal Service</label>
                 <input type="text" class="form-control pilihtanggal" name="tgl" placeholder="Tanggal Servis" required>
               </div>
             </div>
             <div class="col-md-6">
               <div class="form-group">
                 <label>Nama Bengkel Service</label>
                 <input type="text" class="form-control" name="bengkel" placeholder="Nama Bengkel">
               </div>
             </div>
           </div>
           <div class="row">
             <div class="col-md-6">
               <div class="form-group">
                 <label>Service</label>
                 <input class="form-control" name="service" id="service" placeholder="Biaya Servis" type="number"
                   onkeyup="sum()" required />
               </div>
             </div>
             <div class="col-md-6">
               <div class="form-group">
                 <label>Sparepart</label>
                 <input class="form-control" name="sparepart" id="sparepart" placeholder="Biaya Sparepart"
                   onkeyup="sum()" type="number" required />
               </div>
             </div>
             <div class="col-md-6">
               <div class="form-group">
                 <label>Oli</label>
                 <input class="form-control" name="oli" id="oli" placeholder="Biaya Oli" onkeyup="sum()" type="number"
                   required />
               </div>
             </div>
             <div class="col-md-6">
               <div class="form-group">
                 <label>Total Biaya</label>
                 <input type="number" class="form-control" id="result" name="biaya" placeholder="Total Biaya" readonly>
               </div>
             </div>
           </div>
           <div class="row">
             <div class="col-md-6">
               <div class="form-group">
                 <label>Foto Nota</label>
                 <input type="file" class="form-control" name="nota" accept="image/*">
               </div>
             </div>
             <div class="col-md-6">
               <div class="form-group">
                 <label>Foto Service</label>
                 <input type="file" class="form-control" name="foto" accept="image/*">
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