 <!-- Content Header (Page header) -->
 <div class="content-header">
     <div class="container">
         <div class="row mb-2">
             <div class="col-sm-6">
                 <h1 class="m-0"> Data Kendaraan Dinas <small>NAVARA</small></h1>
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
                                 <th>ID ASSETS</th>
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
                         <h3 style="font-weight:bold;color:white;">Riwayat Pemeliharaan</h3>
                     </div>
                     <div class="card-header">
                         <button type="button" class="btn btn-lg btn-success" data-toggle="modal"
                             data-target="#modal-tambah">
                             Tambah Riwayat Pemeliharaan
                         </button>
                     </div>
                     <div class="card-body">
                         <table class="table table-bordered table-striped example" width="100%">
                             <thead>
                                 <tr>
                                     <th>No</th>
                                     <th>Aksi</th>
                                     <th>Tgl Service</th>
                                     <th>Bengkel Service</th>
                                     <th>Keluhan</th>
                                     <th>Perbaikan</th>
                                     <th>total Biaya</th>
                                     <th>Foto Service</th>
                                     <th>Foto Nota</th>
                             </thead>
                             <tbody>
                                 <?php $no = 1;
                  if ($rs != '') {
                    foreach ($rs as $value) { ?>
                                 <tr>
                                     <td><?= $no++; ?></td>
                                     <td><button type="button" class="btn btn-warning" data-toggle="modal"
                                             data-target="#myModal">Edit</button></td>
                                     <td><?= $value['tgl_servis'] ?></td>
                                     <td><?= $value['lokasi'] ?></td>
                                     <td><?= $value['keluhan'] ?></td>
                                     <td><?= $value['perbaikan'] ?></td>
                                     <td>Rp <?= number_format($value['total_biaya'], 2, ',', '.'); ?></td>
                                     <td><img width="40%"
                                             src="<?= base_url('assets/foto_servis/' . $value['foto_servis'] . '') ?>">
                                     </td>
                                     <td><img width="40%"
                                             src="<?= base_url('assets/foto_servis/' . $value['foto_nota'] . '') ?>">
                                     </td>
                                 </tr>
                                 <?php }
                  } ?>
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


 <div class="modal fade" id="modal-tambah">
     <div class="modal-dialog modal-xl">
         <form method="post" action="<?= site_url('pemakai/prosestambahservis?id=' . $kend['idk'] . '') ?>"
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
                         <div class="col-md-6">
                             <div class="form-group">
                                 <label>Tanggal Service</label>
                                 <input type="text" class="form-control pilihtanggal" name="tgl" required>
                             </div>
                         </div>
                         <div class="col-md-6">
                             <div class="form-group">
                                 <label>Nama Bengkel Service</label>
                                 <input type="text" class="form-control" name="bengkel" required>
                             </div>
                         </div>
                     </div>
                     <div class="row">
                         <div class="col-md-6">
                             <div class="form-group">
                                 <label>Keluhan</label>
                                 <input type="text" class="form-control" name="keluhan" required>
                             </div>
                         </div>
                         <div class="col-md-6">
                             <div class="form-group">
                                 <label>Perbaikan</label>
                                 <input type="text" class="form-control" name="perbaikan" required>
                             </div>
                         </div>
                     </div>
                     <div class="row">
                         <div class="col-md-12">
                             <div class="form-group">
                                 <label>Total Biaya</label>
                                 <input type="number" class="form-control" name="biaya" required>
                             </div>
                         </div>
                     </div>
                     <div class="row">
                         <div class="col-md-6">
                             <div class="form-group">
                                 <label>Foto Nota</label>
                                 <input type="file" class="form-control" name="nota" required>
                             </div>
                         </div>
                         <div class="col-md-6">
                             <div class="form-group">
                                 <label>Foto Service</label>
                                 <input type="file" class="form-control" name="foto" required>
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

 <div class="modal fade" id="myModal">
     <div class="modal-dialog modal-xl">
         <form method="post" action="<?= site_url('pemakai/proseseditservis?id=' . $kend['idk'] . '') ?>"
             enctype="multipart/form-data">
             <div class="modal-content">
                 <div class="modal-header">
                     <h4 class="modal-title">Form Edit Riwayat Servis</h4>
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                         <span aria-hidden="true">&times;</span>
                     </button>
                 </div>
                 <div class="modal-body">
                     <div class="row">
                         <div class="col-md-6">
                             <div class="form-group">
                                 <label>Tanggal Service</label>
                                 <input type="text" class="form-control pilihtanggal" name="tgl" required>
                             </div>
                         </div>
                         <div class="col-md-6">
                             <div class="form-group">
                                 <label>Nama Bengkel Service</label>
                                 <input type="text" class="form-control" name="bengkel" required>
                             </div>
                         </div>
                     </div>
                     <div class="row">
                         <div class="col-md-6">
                             <div class="form-group">
                                 <label>Keluhan</label>
                                 <input type="text" class="form-control" name="keluhan" required>
                             </div>
                         </div>
                         <div class="col-md-6">
                             <div class="form-group">
                                 <label>Perbaikan</label>
                                 <input type="text" class="form-control" name="perbaikan" required>
                             </div>
                         </div>
                     </div>
                     <div class="row">
                         <div class="col-md-12">
                             <div class="form-group">
                                 <label>Total Biaya</label>
                                 <input type="number" class="form-control" name="biaya" required>
                             </div>
                         </div>
                     </div>
                     <div class="row">
                         <div class="col-md-6">
                             <div class="form-group">
                                 <label>Foto Nota</label>
                                 <input type="file" class="form-control" name="nota" required>
                             </div>
                         </div>
                         <div class="col-md-6">
                             <div class="form-group">
                                 <label>Foto Service</label>
                                 <input type="file" class="form-control" name="foto" required>
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