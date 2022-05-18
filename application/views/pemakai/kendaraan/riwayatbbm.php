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
                                 <th>ID Aset</th>
                                 <th>:</th>
                                 <th><?= $kend['id_assets'] ?></th>
                             </tr>
                             <tr>
                                 <th>No. Polisi</th>
                                 <th>:</th>
                                 <th><?= $kend['no_polisi'] ?></th>
                             </tr>
                             <tr>
                                 <th>Jenis</th>
                                 <th>:</th>
                                 <th><?= $kend['jenis'] ?></th>
                             </tr>
                             <tr>
                                 <th>Merk</th>
                                 <th>:</th>
                                 <th><?= $kend['merk'] ?></th>
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
                             Tambah Riwayat BBM
                         </button>
                     </div>
                     <div class="card-body">
                         <table class="table table-bordered table-striped example" width="auto" height="auto">
                             <thead>
                                 <tr>
                                     <th class="text-center">No</th>
                                     <th class="text-center">Aksi</th>
                                     <th class="text-center">Tanggal</th>
                                     <th class="text-center">Total Harga BBM</th>
                                     <th class="text-center">Foto Struk BBM</th>
                                 </tr>
                             </thead>
                             <tbody>
                                 <?php $no = 1;
                  if ($rbbm != '') :
                    foreach ($rbbm as $value) : ?>
                                 <tr>
                                     <td class="text-center"><?= $no; ?></td>
                                     <td class="text-center">
                                         <a onclick="deleteConfirm('<?= site_url('home/hapusrbbm?id=' . encrypt_url($value['id_bbm']) . '&idkend=' . encrypt_url($value['id_kendaraan'])) ?>')"
                                             href="#" class="btn btn-danger btn-sm jedatombol"
                                             title="Hapus Riwayat BBM <?= $kend['no_polisi'] ?>"><i
                                                 class="fas fa-trash"></i></a>
                                         <a onclick="editConfirm('<?= site_url('home/editrbbm?id=' . encrypt_url($value['id_bbm']) . '&idkend=' . encrypt_url($value['id_kendaraan'])) ?>')"
                                             href="#" class="btn btn-warning btn-sm jedatombol"
                                             title="Edit Riwayat BBM <?= $kend['no_polisi'] ?>"><i
                                                 class="fas fa-pen"></i></a>
                                     </td>
                                     <td class="text-center"><?= date('d-m-Y', strtotime($value['tgl_pencatatan'])); ?>
                                     </td>
                                     <td class="text-center">
                                         <?= "Rp. " . number_format($value['total_bbm'], 2, ',', '.'); ?>
                                     </td>
                                     <td class="text-center"><img
                                             src="<?= base_url('assets/upload/struk_bbm/' . $value['struk_bbm'] . '') ?>"
                                             alt="Foto Struk BBM" data-toggle="modal" width="30%"
                                             data-target="#strukModal<?php echo $no ?>">
                                     </td>

                                 </tr>
                                 <?php $no++;
                    endforeach;
                  endif ?>
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

 <?php
  $no = 1;
  if ($rbbm != '') :
    foreach ($rbbm as $value) : ?>
 <center>
     <div class="modal fade" id="strukModal<?php echo $no ?>" tabindex="-1" role="dialog"
         aria-labelledby="myModalLabel">
         <div class="modal-dialog" role="document">
             <div class="modal-content">
                 <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                             aria-hidden="true">&times;</span></button>
                 </div>
                 <div class="modal-body">
                     <center>
                         <img src="<?= base_url('assets/upload/struk_bbm/' . $value['struk_bbm'] . '') ?>"
                             alt="Foto Struk BBM" class="img-responsive" width="70%" height="auto">
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
         <?php echo form_open_multipart(
        'home/prosestambahbbm?id=' . encrypt_url($kend['idk']) . '',
        'class="form-horizontal"'
      ) ?>
         <?php echo form_hidden('id_kend', encrypt_url($kend['idk']));
      echo form_hidden('tipe', encrypt_url($kend['tipe']));
      echo form_hidden('no_pol', encrypt_url($kend['no_polisi'])) ?>
         <div class="modal-content">
             <div class="modal-header">
                 <h4 class="modal-title">Form Riwayat BBM</h4>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                 </button>
             </div>
             <div class="modal-body">
                 <div class="row">
                     <div class="col-md-6">
                         <div class="form-group">
                             <label>Tanggal</label>
                             <input type="text" class="form-control pilihtanggal" name="tgl_bbm"
                                 value="<?= date('d-m-Y') ?>" required>
                         </div>
                     </div>
                     <div class="col-md-6">
                         <div class="form-group">
                             <label>Total Biaya BBM</label>
                             <input type="number" class="form-control" name="harga_bbm" required
                                 placeholder="Masukkan Total Biaya BBM">
                         </div>
                     </div>
                     <div class="col-md-6">
                         <div class="form-group">
                             <label>Struk BBM</label>
                             <input type="file" class="form-control" name="struk_bbm" accept="image/*" required>
                         </div>
                     </div>
                 </div>
             </div>
             <div class="modal-footer justify-content-between">
                 <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                 <button type="sumbit" class="btn btn-primary">Simpan</button>

             </div>
             <?php form_close() ?>
         </div>
         <!-- /.modal-content -->
     </div>
     <!-- /.modal-dialog -->
 </div>