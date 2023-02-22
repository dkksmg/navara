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
         <?= $this->load->view('admin/template/data_kend_layout', '', TRUE); ?>
         <?= $this->load->view('admin/template/menu_layout_admin', '', TRUE); ?>
       </div>
       <div class="col-lg-12">
         <div class="card">
           <div class="card-header" style="background-color:#4a2f3a;">
             <h3 style="font-weight:bold;color:white;"><?= $title ?></h3>
           </div>
           
           <!-- <div class="collapse" id="idcollapse"> -->
             <div class="card-header">
               <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#modal-xl">
                 Tambah Riwayat Pajak
               </button>
             </div>
             <div class="card-body">
              <div class="table-responsive">
               <table class="table table-bordered table-striped example" width="100%;">
                 <thead>
                   <tr>
                     <th class="text-center">No</th>
                     <th class="text-center" width="10%">Aksi</th>
                     <th class="text-center">Tanggal Pencatatan</th>
                     <th class="text-center">Tahun</th>
                     <th class="text-center">Total Pajak</th>
                     <th class="text-center">Status</th>
                     <th class="text-center">Last Update By</th>
                   </tr>
                 </thead>
                 <tbody>
                   <?php $no = 1;
                                      if ($rp != '') {
                                          foreach ($rp as $value) { ?>
                   <tr>
                     <td class="text-center"><?= $no; ?></td>
                     <td class="text-center">
                       <a onclick="deleteConfirm('<?= site_url('home/hapusriwayatpajak?id=' . ($value['id_pjk']) . '') ?>')"
                         href="#" class="btn btn-danger btn-sm jedatombol"
                         title="Hapus Riwayat Pajak <?= $kend['no_polisi'] ?>"><i class="fas fa-trash"></i></a>
                       <a onclick="editConfirm('<?= site_url('home/editriwayatpajak?id=' . $value['id_pjk'] . '') ?>')"
                         href="#" class="btn btn-warning btn-sm jedatombol"
                         title="Edit Riwayat Pajak <?= $kend['no_polisi'] ?>"><i class="fas fa-pen"></i></a>
                       <?php if ($value['status_pjk'] == 'No' || $value['status_pjk'] == 'Wait') : ?>
                       <a href="#"
                         onclick="approveConfirm('<?= site_url('home/approve_riwayatpajak?id=' . $value['id_pjk'] . '') ?>')"
                         class="btn btn-sm btn-success jedatombol"
                         title="Setujui Riwayat Pajak <?= $kend['merk'] . ' ' . $kend['tipe'] . ' ' . $kend['no_polisi'] ?>">
                         <i class="fa-solid fa-badge-check"></i></a>
                       <a href="#"
                         onclick="waitConfirm('<?= site_url('home/wait_riwayatpajak?id=' . $value['id_pjk'] . '') ?>')"
                         class="btn btn-sm btn-dark jedatombol <?php if ($value['status_pjk'] == 'Wait') : ?> disabled <?php endif; ?>"
                         title="Set Wait Riwayat Pajak <?= $kend['merk'] . ' ' . $kend['tipe'] . ' ' . $kend['no_polisi'] ?>">
                         <i class="fa-solid fa-circle-pause"></i></a>
                       <a href="#" data-toggle="modal" data-target="#modal_reject<?php echo $no ?>"
                         class="btn btn-sm btn-danger jedatombol <?php if ($value['status_pjk'] == 'No') : ?> disabled <?php endif; ?>"
                         title="Tolak Riwayat Pajak <?= $kend['merk'] . ' ' . $kend['tipe'] . ' ' . $kend['no_polisi'] ?>"><i
                           class="fa-solid fa-circle-xmark"></i></a>
                       <?php else : ?>
                       <a href="#" data-toggle="modal" data-target="#modal_reject<?php echo $no ?>"
                         class="btn btn-sm btn-danger jedatombol"
                         title="Tolak Riwayat Pajak <?= $kend['merk'] . ' ' . $kend['tipe'] . ' ' . $kend['no_polisi'] ?>"><i
                           class="fa-solid fa-circle-xmark"></i></a>
                       <a href="#"
                         onclick="waitConfirm('<?= site_url('home/wait_riwayatpajak?id=' . $value['id_pjk'] . '') ?>')"
                         class="btn btn-sm btn-dark jedatombol"
                         title="Set Wait Riwayat Pajak <?= $kend['merk'] . ' ' . $kend['tipe'] . ' ' . $kend['no_polisi'] ?>">
                         <i class="fa-solid fa-circle-pause"></i></a>
                       <?php endif; ?>
                     </td>
                     <td class="text-center"><?= $value['tgl_pencatatan'] ?></td>
                     <td class="text-center"><?= $value['tahun'] ?></td>
                     <td class="text-center">
                       <?= "Rp. " . number_format($value['total_pajak'], 2, ',', '.'); ?>
                     </td>
                     <td class="text-center" width="15%">
                       <?php if ($value['status_pjk'] == 'Wait') : ?>
                       Perlu dicek <br><i style="color:red" class="fa-solid fa-triangle-exclamation"></i>
                       <?php elseif ($value['status_pjk'] == 'No') : ?>
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
                                          }
                                      } ?>
                 </tbody>
               </table>
              </div>
             </div>
           <!-- </div> -->
         </div>
       </div>
     </div>
     <!-- /.row -->
   </div><!-- /.container-fluid -->
 </div>
 <!-- /.content -->
 <?php
    $no = 1;
    if ($rp != '') :
        foreach ($rp as $value) : ?>
 <justify>
   <div class="modal fade" id="modal_reject<?= $no ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
     <div class="modal-dialog" role="document">
       <?= form_open('home/reject_riwayatpajak?id=' . $value['id_pjk']) ?>
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
     <form method="post" action="<?= site_url('home/prosestambahpajak?id=' . $kend['idk'] . '') ?>"
       enctype="multipart/form-data">
       <div class="modal-content">
         <div class="modal-header">
           <h4 class="modal-title">Form Riwayat Pajak</h4>
           <button type="button" class="close" data-dismiss="modal" aria-label="Close">
             <span aria-hidden="true">&times;</span>
           </button>
         </div>
         <div class="modal-body">
           <div class="row">
             <div class="col-md-6">
               <div class="form-group">
                 <label>Tahun</label>
                 <?php
                                    $year_start  = 2000;
                                    $year_end = date('Y') + 20;
                                    $user_selected_year = date('Y');
                                    echo '<select id="year" required class="form-control" name="tahun_pajak">' . "\n";
                                    for ($i_year = $year_start; $i_year <= $year_end; $i_year++) {
                                        $selected = ($user_selected_year == $i_year ? ' selected' : '');
                                        echo '<option value="' . $i_year . '"' . $selected . '>' . $i_year . '</option>' . "\n";
                                    }
                                    echo '</select>' . "\n";
                                    ?>
               </div>
             </div>
             <div class="col-md-6">
               <div class="form-group">
                 <label>Total Pajak</label>
                 <input type="number" placeholder="Masukkan Total Pajak" class="form-control" name="total_pajak">
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