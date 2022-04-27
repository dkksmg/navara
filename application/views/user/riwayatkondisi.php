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
                         <h3 style="font-weight:bold;color:white;">Riwayat Kondisi</h3>
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
                                     <th>No</th>
                                     <th>Aksi</th>
                                     <th>Tgl Pencatatan</th>
                                     <th>Kondisi</th>
                                     <th>Foto Tampak Depan</th>
                                     <th>Foto Tampak Kanan</th>
                                     <th>Foto Tampak Kiri</th>
                                     <th>Foto Tampak Belakang</th>
                                 </tr>
                             </thead>
                             <tbody>
                                 <?php $no = 1;
                                    if ($rk != '') {
                                        foreach ($rk as $value) { ?>
                                 <tr>
                                     <td><?= $no++; ?></td>
                                     <td><a href="<?= site_url('home/hapusriwayatkondisi?id=' . $value['id_rk'] . '') ?>"
                                             class="btn btn-sm btn-danger">Hapus</a></td>
                                     <td><?= $value['tgl_pencatatan'] ?></td>
                                     <td><?= $value['kondisi'] ?></td>
                                     <td><img width="70%"
                                             src="<?= base_url('assets/file_kendaraan/' . $value['foto_tampak_depan'] . '') ?>">
                                     </td>
                                     <td><img width="70%"
                                             src="<?= base_url('assets/file_kendaraan/' . $value['foto_tampak_kanan'] . '') ?>">
                                     </td>
                                     <td><img width="70%"
                                             src="<?= base_url('assets/file_kendaraan/' . $value['foto_tampak_kiri'] . '') ?>">
                                     </td>
                                     <td><img width="70%"
                                             src="<?= base_url('assets/file_kendaraan/' . $value['foto_tampak_belakang'] . '') ?>">
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
                     <div class="row">
                         <div class="col-md-12">
                             <div class="form-group">
                                 <label>Keterangan Kondisi</label>
                                 <select class="form-control" name="kondisi">
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
                                 <input type="file" class="form-control" name="depan" required>
                             </div>
                         </div>
                         <div class="col-md-6">
                             <div class="form-group">
                                 <label>Foto Tampak Belakang</label>
                                 <input type="file" class="form-control" name="blkg" required>
                             </div>
                         </div>
                     </div>
                     <div class="row">
                         <div class="col-md-6">
                             <div class="form-group">
                                 <label>Foto Tampak Kiri</label>
                                 <input type="file" class="form-control" name="kiri" required>
                             </div>
                         </div>
                         <div class="col-md-6">
                             <div class="form-group">
                                 <label>Foto Tampak Kanan</label>
                                 <input type="file" class="form-control" name="kanan" required>
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