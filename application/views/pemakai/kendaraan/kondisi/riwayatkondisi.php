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
                         <h3 style="font-weight:bold;color:white;">Data Kendaraan Dinas</h3>
                     </div>
                     <div class="card-body">
                         <table class="table table-striped">
                             <tr>
                                 <th width="30%">ID Aset</th>
                                 <th>:</th>
                                 <th><?= $kend['id_assets'] ?></th>
                             </tr>
                             <tr>
                                 <th>No. Polisi</th>
                                 <th>:</th>
                                 <th><?= strtoupper($kend['no_polisi']) ?></th>
                             </tr>
                             <tr>
                                 <th>Jenis</th>
                                 <th>:</th>
                                 <th><?= strtoupper($kend['jenis']) ?></th>
                             </tr>
                             <tr>
                                 <th>Merk</th>
                                 <th>:</th>
                                 <th><?= strtoupper($kend['merk']) ?></th>
                             </tr>
                             <tr>
                                 <th>Tipe</th>
                                 <th>:</th>
                                 <th><?= strtoupper($kend['tipe']) ?></th>
                             </tr>
                             <tr>
                                 <th>CC</th>
                                 <th>:</th>
                                 <th><?php if ($kend['besar_cc'] == '') :  ?> -
                                     <?php else : ?><?= strtoupper($kend['besar_cc']) ?> CC <?php endif ?></th>
                             </tr>
                             <tr>
                                 <th>Bahan Bakar</th>
                                 <th>:</th>
                                 <th><?= strtoupper($kend['jenis_bb']) ?></th>
                             </tr>
                             <tr>
                                 <th>Pagu Kendaraan Tahun <?= date('Y') ?></th>
                                 <th>:</th>
                                 <th>Rp. <?= number_format($kend['pagu_awal'], 2, ',', '.') ?></th>
                             </tr>
                             <?php
                                $terpakai = $kend['total_biaya_pajak'] + $kend['total_biaya_servis'] + $kend['total_biaya_bbm'];
                                $sisa = $kend['pagu_awal'] - $terpakai; ?>
                             <tr>
                                 <th>Pagu Terpakai</th>
                                 <th>:</th>
                                 <th>Rp. <?= number_format($terpakai, 2, ',', '.') ?></th>
                             </tr>
                             <tr>
                                 <th>Sisa Pagu</th>
                                 <th>:</th>
                                 <th>Rp. <?= number_format($sisa, 2, ',', '.') ?></th>
                             </tr>
                         </table>
                     </div>
                 </div>
             </div>
             <div class="col-lg-12">
                 <div class="card">
                     <div class="card-header" style="background-color:#4a2f3a;">
                         <h3 style="font-weight:bold;color:white;"><?= $title ?></h3>
                     </div>
                     <div class="card-header">
                         <button type="button" class="btn btn-sm btn-success" data-toggle="modal"
                             data-target="#modal-xl">
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
                                 </tr>
                             </thead>
                             <tbody>
                                 <?php
                                    if ($rk != '') :
                                        $no = 1;
                                        foreach ($rk as $value) : ?>
                                 <tr>
                                     <td class="text-center"><?= $no; ?></td>
                                     <td class="text-center">
                                         <?php if ($value['status_rk'] == 'Wait') : ?>
                                         <a onclick="editConfirm('#')" href="#"
                                             class="btn btn-sm btn-warning jedatombol disabled"><i
                                                 class="fas fa-pen"></i></a>
                                         <?php elseif ($value['status_rk'] == 'Yes') : ?>
                                         <a onclick="editConfirm('#')" href="#"
                                             class="btn btn-sm btn-warning jedatombol disabled"><i
                                                 class="fas fa-pen"></i></a>
                                         <?php else : ?>
                                         <a style="display: none" onclick="deleteConfirm('#')" href="#"
                                             class="btn btn-sm btn-danger jedatombol disabled"><i
                                                 class="fas fa-trash"></i></a>
                                         <a onclick="editConfirm('<?= site_url('pemakai/editriwayatkondisi?id=' . $value['id_rk'] . '&idkend=' . $value['id_kendaraan']) ?>')"
                                             href="#" class="btn btn-sm btn-warning jedatombol"><i
                                                 class="fas fa-pen"></i></a>
                                         <?php endif ?>
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
                                     </td>
                                     <td class="text-center"><img width="70%"
                                             src="<?= base_url('assets/upload/file_kendaraan/kanan/' . $value['foto_tampak_kanan'] . '') ?>"
                                             data-toggle="modal" data-target="#kananModal<?php echo $no ?>">
                                     </td>
                                     <td class="text-center"><img width="70%"
                                             src="<?= base_url('assets/upload/file_kendaraan/kiri/' . $value['foto_tampak_kiri'] . '') ?>"
                                             data-toggle="modal" data-target="#kiriModal<?php echo $no ?>">
                                     </td>
                                     <td class="text-center" width="20%">
                                         <?php if ($value['status_rk'] == 'Wait') : ?>
                                         <p>Sedang Diverifikasi</p>
                                         <?php elseif ($value['status_rk'] == 'No') : ?>
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
 <center>
     <div class="modal fade" id="depanModal<?php echo $no ?>" tabindex="-1" role="dialog"
         aria-labelledby="myModalLabel">
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
     <div class="modal fade" id="kananModal<?php echo $no ?>" tabindex="-1" role="dialog"
         aria-labelledby="myModalLabel">
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
 </center>
 <?php $no++;
        endforeach;
    endif ?>

 <div class="modal fade" id="modal-xl">
     <div class="modal-dialog modal-xl">
         <form method="post" action="<?= site_url('pemakai/prosestambahkondisi?id=' . $kend['idk'] . '') ?>"
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