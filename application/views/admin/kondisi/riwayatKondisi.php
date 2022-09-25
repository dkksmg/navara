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
             <h3 style="font-weight:bold;color:white;">Riwayat Kondisi</h3>
           </div>
           <div class="card-header">
             <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#modal-xl">
               Tambah Riwayat Kondisi
             </button>
           </div>
           <div class="card-body">
             <table class="table table-bordered table-striped example">
               <thead>
                 <tr>
                   <th class="text-center">No</th>
                   <th class="text-center" width="10%">Aksi</th>
                   <th class="text-center">Tgl Pencatatan</th>
                   <th class="text-center">Kondisi</th>
                   <th class="text-center">Foto Tampak Depan</th>
                   <th class="text-center">Foto Tampak Belakang</th>
                   <th class="text-center">Foto Tampak Kanan</th>
                   <th class="text-center">Foto Tampak Kiri</th>
                   <th class="text-center">Status</th>
                   <th class="text-center">Last Update By</th>
                 </tr>
               </thead>
               <tbody>
                 <?php
                                    if ($rk != '') :
                                        $no = 1;
                                        foreach ($rk as $value) : ?>
                 <tr>
                   <td class="text-center" height="50%"><?= $no; ?></td>
                   <td class="text-center">
                     <a onclick="deleteConfirm('<?= site_url('home/hapusriwayatkondisi?id=' . $value['id_rk'] . '') ?>')"
                       href="#" class="btn btn-sm btn-danger jedatombol"
                       title="Hapus Riwayat Kondisi <?= $kend['merk'] . ' ' . $kend['tipe'] . ' ' . $kend['no_polisi'] ?>"><i
                         class="fas fa-trash"></i></a>
                     <a onclick="editConfirm('<?= site_url('home/editriwayatkondisi?id=' . $value['id_rk'] . '') ?>')"
                       href="#" class="btn btn-sm btn-warning jedatombol"
                       title="Edit Riwayat Kondisi <?= $kend['merk'] . ' ' . $kend['tipe'] . ' ' . $kend['no_polisi'] ?>"><i
                         class="fas fa-pen"></i></a>
                     <?php if ($value['status_rk'] == 'No' || $value['status_rk'] == 'Wait') : ?>
                     <a href="#"
                       onclick="approveConfirm('<?= site_url('home/approve_riwayatkondisi?id=' . $value['id_rk'] . '') ?>')"
                       class="btn btn-sm btn-success jedatombol"
                       title="Setujui Riwayat Kondisi <?= $kend['merk'] . ' ' . $kend['tipe'] . ' ' . $kend['no_polisi'] ?>">
                       <i class="fa-solid fa-badge-check"></i></a>
                     <a href="#"
                       onclick="waitConfirm('<?= site_url('home/wait_riwayatkondisi?id=' . $value['id_rk'] . '') ?>')"
                       class="btn btn-sm btn-dark jedatombol <?php if ($value['status_rk'] == 'Wait') : ?> disabled <?php endif; ?>"
                       title="Set Wait Riwayat Kondisi <?= $kend['merk'] . ' ' . $kend['tipe'] . ' ' . $kend['no_polisi'] ?>">
                       <i class="fa-solid fa-circle-pause"></i></a>
                     <a href="#" data-toggle="modal" data-target="#modal_reject<?php echo $no ?>"
                       class="btn btn-sm btn-danger jedatombol <?php if ($value['status_rk'] == 'No') : ?> disabled <?php endif; ?>"
                       title="Tolak Riwayat Kondisi <?= $kend['merk'] . ' ' . $kend['tipe'] . ' ' . $kend['no_polisi'] ?>"><i
                         class="fa-solid fa-circle-xmark"></i></a>
                     <?php else : ?>
                     <a href="#" data-toggle="modal" data-target="#modal_reject<?php echo $no ?>"
                       class="btn btn-sm btn-danger jedatombol"
                       title="Tolak Riwayat Kondisi <?= $kend['merk'] . ' ' . $kend['tipe'] . ' ' . $kend['no_polisi'] ?>"><i
                         class="fa-solid fa-circle-xmark"></i></a>
                     <a href="#"
                       onclick="waitConfirm('<?= site_url('home/wait_riwayatkondisi?id=' . $value['id_rk'] . '') ?>')"
                       class="btn btn-sm btn-dark jedatombol"
                       title="Set Wait Riwayat Kondisi <?= $kend['merk'] . ' ' . $kend['tipe'] . ' ' . $kend['no_polisi'] ?>">
                       <i class="fa-solid fa-circle-pause"></i></a>
                     <?php endif; ?>
                   </td>
                   <td class="text-center"><?= date('d-m-Y', strtotime($value['tgl_pencatatan'])); ?>
                   </td>
                   <td class="text-center"><?= $value['kondisi'] ?></td>
                   <td class="text-center"><img width="70%"
                       src="<?= base_url('assets/upload/file_kendaraan/depan/' . $value['foto_tampak_depan'] . '') ?>"
                       data-toggle="modal" data-target="#depanModal<?php echo $no ?>">
                   </td>
                   <td class="text-center"><img width="70%"
                       src="<?= base_url('assets/upload/file_kendaraan/belakang/' . $value['foto_tampak_belakang'] . '') ?>"
                       data-toggle="modal" data-target="#belakangModal<?php echo $no ?>">
                   <td class="text-center"><img width="70%"
                       src="<?= base_url('assets/upload/file_kendaraan/kanan/' . $value['foto_tampak_kanan'] . '') ?>"
                       data-toggle="modal" data-target="#kananModal<?php echo $no ?>">
                   </td>
                   <td class="text-center"><img width="70%"
                       src="<?= base_url('assets/upload/file_kendaraan/kiri/' . $value['foto_tampak_kiri'] . '') ?>"
                       data-toggle="modal" data-target="#kiriModal<?php echo $no ?>">
                   </td>
                   </td>
                   <td class="text-center" width="15%">
                     <?php if ($value['status_rk'] == 'Wait') : ?>
                     Perlu dicek <br><i style="color:red" class="fa-solid fa-triangle-exclamation"></i>
                     <?php elseif ($value['status_rk'] == 'No') : ?>
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
                                        endforeach; ?>
                 <?php endif ?>
               </tbody>
             </table>
           </div>
         </div>
       </div>
     </div>
     <!-- /.row -->
   </div><!-- /.container-fluid -->
 </div>
 <!-- /.content -->

 <!-- Modal Foto -->
 <!-- Modal -->
 <?php
    $no = 1;
    if ($rk != '') :
        foreach ($rk as $value) : ?>
 <justify>
   <div class="modal fade" id="depanModal<?php echo $no ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
     <div class="modal-dialog" role="document">
       <div class="modal-content">
         <div class="modal-header">
           <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
               aria-hidden="true">&times;</span></button>
         </div>
         <div class="modal-body">
           <center>
             <img src="<?= base_url('assets/upload/file_kendaraan/depan/' . $value['foto_tampak_depan'] . '') ?>"
               alt="Foto Servis" class="img-responsive" width="70%" height="auto">
           </center>
         </div>
         <div class="modal-footer">
           <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
         </div>
       </div>
     </div>
   </div>
   <div class="modal fade" id="kiriModal<?php echo $no ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
     <div class="modal-dialog" role="document">
       <div class="modal-content">
         <div class="modal-header">
           <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
               aria-hidden="true">&times;</span></button>
         </div>
         <div class="modal-body">
           <center>
             <img src="<?= base_url('assets/upload/file_kendaraan/kiri/' . $value['foto_tampak_kiri'] . '') ?>"
               alt="Foto Nota" class="img-responsive" width="70%" height="auto">
           </center>
         </div>
         <div class="modal-footer">
           <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
         </div>
       </div>
     </div>
   </div>
   <div class="modal fade" id="kananModal<?php echo $no ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
     <div class="modal-dialog" role="document">
       <div class="modal-content">
         <div class="modal-header">
           <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
               aria-hidden="true">&times;</span></button>
         </div>
         <div class="modal-body">
           <center>
             <img src="<?= base_url('assets/upload/file_kendaraan/kanan/' . $value['foto_tampak_kanan'] . '') ?>"
               alt="Foto Nota" class="img-responsive" width="70%" height="auto">
           </center>
         </div>
         <div class="modal-footer">
           <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
         </div>
       </div>
     </div>
   </div>
   <div class="modal fade" id="belakangModal<?php echo $no ?>" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel">
     <div class="modal-dialog" role="document">
       <div class="modal-content">
         <div class="modal-header">
           <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
               aria-hidden="true">&times;</span></button>
         </div>
         <div class="modal-body">
           <center>
             <img src="<?= base_url('assets/upload/file_kendaraan/belakang/' . $value['foto_tampak_belakang'] . '') ?>"
               alt="Foto Nota" class="img-responsive" width="70%" height="auto">
           </center>
         </div>
         <div class="modal-footer">
           <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
         </div>
       </div>
     </div>
   </div>
   <div class="modal fade" id="modal_reject<?= $no ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
     <div class="modal-dialog" role="document">
       <?= form_open('home/reject_riwayatkondisi?id=' . $value['id_rk']) ?>
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
 </justify>
 <?php $no++;
        endforeach;
    endif ?>
 <div class="modal fade" id="modal-xl">
   <div class="modal-dialog modal-xl">
     <form method="post" action="<?= site_url('home/prosestambahkondisi?id=' . $kend['idk'] . '') ?>"
       enctype="multipart/form-data">
       <div class="modal-content">
         <div class="modal-header">
           <h4 class="modal-title">Form Riwayat Kondisi</h4>
           <button type="button" class="close" data-dismiss="modal" aria-label="Close">
             <span aria-hidden="true">&times;</span>
           </button>
         </div>
         <div class="modal-body">
           <?php
                        echo form_hidden('tipe', $kend['tipe']);
                        echo form_hidden('no_pol', $kend['no_polisi']); ?>
           <div class="row">
             <div class="col-md-12">
               <div class="form-group">
                 <label>Keterangan Kondisi</label>
                 <select class="form-control" name="kondisi" required>
                   <option>Baik</option>
                   <option>Rusak Ringan</option>
                   <option>Rusak Sedang</option>
                   <option>Rusak Berat</option>
                 </select>
               </div>
             </div>
           </div>
           <div class="row">
             <div class="col-md-6">
               <div class="form-group">
                 <label>Foto Tampak Depan</label>
                 <input type="file" class="form-control" name="depan" required accept="image/*">
               </div>
             </div>
             <div class="col-md-6">
               <div class="form-group">
                 <label>Foto Tampak Belakang</label>
                 <input type="file" class="form-control" name="blkg" required accept="image/*">
               </div>
             </div>
           </div>
           <div class="row">
             <div class="col-md-6">
               <div class="form-group">
                 <label>Foto Tampak Kiri</label>
                 <input type="file" class="form-control" name="kiri" required accept="image/*">
               </div>
             </div>
             <div class="col-md-6">
               <div class="form-group">
                 <label>Foto Tampak Kanan</label>
                 <input type="file" class="form-control" name="kanan" required accept="image/*">
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
 <!-- /.modal-dialog -->
 </div>