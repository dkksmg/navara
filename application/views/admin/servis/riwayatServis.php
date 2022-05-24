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
                                 <th><?= strtoupper($kend['besar_cc']) ?> CC</th>
                             </tr>
                             <tr>
                                 <th>Bahan Bakar</th>
                                 <th>:</th>
                                 <th><?= strtoupper($kend['jenis_bb']) ?></th>
                             </tr>
                         </table>
                     </div>
                 </div>
             </div>
             <div class="col-lg-12">
                 <div class="card">
                     <div class="card-header" style="background-color:#4a2f3a;">
                         <h3 style="font-weight:bold;color:white;">Riwayat Servis</h3>
                     </div>
                     <div class="card-header">
                         <button type="button" class="btn btn-sm btn-success" data-toggle="modal"
                             data-target="#modalTambah">
                             Tambah Riwayat Servis
                         </button>
                     </div>
                     <div class="card-body">
                         <table class="table table-bordered table-striped example" width="100%" height="auto">
                             <thead>
                                 <tr>
                                     <th class="text-center">No</th>
                                     <th class="text-center" width="10%">Aksi</th>
                                     <th class="text-center">Tgl Service</th>
                                     <th class="text-center">Bengkel Service</th>
                                     <th class="text-center">Keluhan</th>
                                     <th class="text-center">Perbaikan</th>
                                     <th class="text-center" width="80px">Total Biaya</th>
                                     <th class="text-center">Foto Service</th>
                                     <th class="text-center">Foto Nota</th>
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
                                         <?php if ($value['status_sistem'] == 'yes') : ?>
                                         <a href="<?= site_url('home/reject_servis?id=' . $value['id_rs'] . '') ?>"
                                             class="btn btn-sm btn-secondary jedatombol"><i
                                                 class="fa-solid fa-octagon-xmark"
                                                 title="Tidak Disetujui <?= $kend['no_polisi'] ?>"></i></a>
                                         <?php else : ?>
                                         <a href="<?= site_url('home/approve_servis?id=' . $value['id_rs'] . '') ?>"
                                             class="btn btn-sm btn-success jedatombol"><i
                                                 class="fa-solid fa-badge-check"
                                                 title="Setujui Data <?= $kend['no_polisi'] ?>"></i></a>
                                         <?php endif ?>
                                         <a onclick="deleteConfirm('<?php echo site_url('home/delete_servis?id=' . $value['id_rs'] . '') ?>')"
                                             href="#" class="btn btn-sm btn-danger jedatombol"><i
                                                 class="fas fa-trash"></i></a>
                                         <a onclick="editConfirm('<?php echo site_url('home/editriwayatservis?id=' . $value['id_rs'] . '') ?>')"
                                             href="#" class="btn btn-sm btn-warning jedatombol"><i
                                                 class="fas fa-pen"></i></a>
                                     </td>
                                     <td class="text-center"><?= date('d-m-Y', strtotime($value['tgl_servis'])) ?></td>
                                     <td class="text-center"><?= $value['lokasi'] ?></td>
                                     <td><?= $value['keluhan'] ?></td>
                                     <td><?= $value['perbaikan'] ?></td>
                                     <td class="text-left">
                                         <?= "Rp. " . number_format($value['total_biaya'], 2, ',', '.'); ?></td>
                                     <td class="text-center">
                                         <img width="40%"
                                             src="<?= base_url('assets/upload/foto_servis/' . $value['foto_servis'] . '') ?>"
                                             data-toggle="modal" data-target="#servisModal<?php echo $no ?>">
                                     </td>
                                     <td class="text-center"><img width="40%"
                                             src="<?= base_url('assets/upload/foto_nota/' . $value['foto_nota'] . '') ?>"
                                             data-toggle="modal" data-target="#notaModal<?php echo $no ?>">
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
         <!-- /.row -->
     </div><!-- /.container-fluid -->
 </div>
 <!-- /.content -->

 <!-- Modal Foto Servis & Nota -->
 <?php
    if ($rs != '') :
        $no = 1;
        foreach ($rs as $value) : ?>
 <center>
     <!-- Modal -->
     <div class="modal fade" id="servisModal<?php echo $no ?>" tabindex="-1" role="dialog"
         aria-labelledby="myModalLabel">
         <div class="modal-dialog" role="document">
             <div class="modal-content">
                 <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                             aria-hidden="true">&times;</span></button>
                 </div>
                 <div class="modal-body">
                     <center>
                         <img src="<?= base_url('assets/upload/foto_servis/' . $value['foto_servis'] . '') ?>"
                             alt="Foto Servis" class="img-responsive" width="70%" height="auto">
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
                         <img src="<?= base_url('assets/upload/foto_nota/' . $value['foto_nota'] . '') ?>"
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
                                 <input type="text" class="form-control pilihtanggal" name="tgl"
                                     placeholder="Tanggal Servis" required>
                             </div>
                         </div>
                         <div class="col-md-6">
                             <div class="form-group">
                                 <label>Nama Bengkel Service</label>
                                 <input type="text" class="form-control" name="bengkel" placeholder="Nama Bengkel"
                                     required>
                             </div>
                         </div>
                     </div>
                     <div class="row">
                         <div class="col-md-6">
                             <div class="form-group">
                                 <label>Keluhan</label>
                                 <input type="text" class="form-control" name="keluhan" placeholder="Keluhan Kendaraan"
                                     required>
                             </div>
                         </div>
                         <div class="col-md-6">
                             <div class="form-group">
                                 <label>Perbaikan</label>
                                 <input type="text" class="form-control" name="perbaikan"
                                     placeholder="Perbaikan Kendaraan" required>
                             </div>
                         </div>
                     </div>
                     <div class="row">
                         <div class="col-md-6">
                             <div class="form-group">
                                 <label>Total Biaya</label>
                                 <input type="number" class="form-control" name="biaya" placeholder="Total Biaya"
                                     required>
                             </div>
                         </div>
                     </div>
                     <div class="row">
                         <div class="col-md-6">
                             <div class="form-group">
                                 <label>Foto Nota</label>
                                 <input type="file" class="form-control" name="nota" accept="image/*" required>
                             </div>
                         </div>
                         <div class="col-md-6">
                             <div class="form-group">
                                 <label>Foto Service</label>
                                 <input type="file" class="form-control" name="foto" accept="image/*" required>
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