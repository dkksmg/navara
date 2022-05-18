 <!-- Content Header (Page header) -->
 <div class="content-header">
     <div class="container">
         <div class="row mb-2">
             <div class="col-sm-6">
                 <!-- <h1 class="m-0"> Data  User Navara <small>NAVARA</small></h1> -->
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
                         <h3 style="font-weight:bold;color:white;">Data User Navara</h3>
                     </div>
                     <div class="card-header">
                         <a href="<?= site_url('home/tambahUser') ?>" class="btn btn-sm btn-success" data-toggle="modal"
                             data-target="#modal-xl">Tambah
                             User</a>
                     </div>

                     <div class="card-body">
                         <table class="table table-bordered table-striped example" width="100%">
                             <thead>
                                 <tr>
                                     <th class="text-center">No</th>
                                     <th width="80px" class="text-center">Aksi</th>
                                     <th class="text-center">Username</th>
                                     <th class="text-center">Nama</th>
                                     <th class="text-center">Lokasi Kerja</th>
                                     <th class="text-center">Role</th>
                                     <th class="text-center">Status</th>
                                 </tr>
                             </thead>
                             <tbody>
                                 <?php $no = 1;
                                    if ($user != '') {
                                        foreach ($user as $usr) { ?>
                                 <tr>
                                     <td class="text-center"><?= $no++; ?></td>
                                     <td class="text-center">
                                         <?php if ($usr['status'] != 'Aktif') : ?>
                                         <a href="<?= site_url('admin/aktifkanuser?id=' . $usr['id']) ?>"
                                             class="btn btn-sm btn-success jedatombol"
                                             title="Aktifkan User <?= $usr['name'] ?>">
                                             <i class="fa-solid fa-badge-check"></i></a>
                                         <?php else : ?>
                                         <a href="<?= site_url('admin/nonaktifkanuser?id=' . $usr['id']) ?>"
                                             class="btn btn-sm btn-secondary jedatombol"
                                             title="Nonaktifkan User <?= $usr['name'] ?>">
                                             <i class="fa-solid fa-octagon-xmark"></i></a>
                                         <?php endif ?>
                                         <a onclick="editConfirm('<?= site_url('admin/edit_user?id=' . $usr['id'] . '') ?>')"
                                             href="#" class="btn btn-sm btn-warning jedatombol"
                                             title="Edit User <?= $usr['name'] ?>"><i class="fa fa-pen"></i></a>
                                         <a onclick="deleteConfirm('<?= site_url('admin/delete_user?id=' . $usr['id'] . '') ?>')"
                                             href="#" class="btn btn-sm btn-danger jedatombol"
                                             title="Delete User <?= $usr['name'] ?>"><i class="fa fa-trash"></i></a>
                                     </td>
                                     <td class="text-center"><?= $usr['username'] ?></td>
                                     <td class="text-center"><?= $usr['name'] ?></td>
                                     <td class="text-center"><?= $usr['wilayah'] ?></td>
                                     <td class="text-center"><?= $usr['role'] ?></td>
                                     <td class="text-center"><?= $usr['status'] ?></td>
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
         <form method="post" action="<?= site_url('admin/prosestambahuser?id=' . $usr['id'] . '') ?>"
             enctype="multipart/form-data">
             <div class="modal-content">
                 <div class="modal-header">
                     <h4 class="modal-title">Form Tambah User</h4>
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                         <span aria-hidden="true">&times;</span>
                     </button>
                 </div>
                 <div class="modal-body">
                     <div class="row">
                         <div class="col-md-6">
                             <div class="form-group">
                                 <label>Nama</label>
                                 <input type="text" class="form-control" name="nama_user" placeholder="Masukkan Nama"
                                     required>
                             </div>
                         </div>
                         <div class="col-md-6">
                             <div class="form-group">
                                 <label>NIP</label>
                                 <input type="number" class="form-control" name="nip_user"
                                     placeholder="Kosongkan Jika Role Tidak Pemakai Kendaraan" required>
                             </div>
                         </div>
                         <div class="col-md-6">
                             <div class="form-group">
                                 <label>Role</label>
                                 <?php
                                    $role = array('' => '- Pilih -', 'Superadmin' => 'Superadmin', 'Admin' => 'Admin Wilayah', 'Pemakai' => 'Pemakai Kendaraan');
                                    echo form_dropdown(
                                        'role_user',
                                        $role,
                                        set_value('role'),
                                        form_error('role') == true ? "class='form-control is-invalid' required" : "class='form-control' required"
                                    ); ?>
                             </div>
                         </div>
                         <div class="col-md-6">
                             <div class="form-group">
                                 <label>Username</label>
                                 <input type="text" class="form-control" name="username" required>
                             </div>
                         </div>
                         <div class="col-md-6">
                             <div class="form-group">
                                 <label>Password</label>
                                 <input type="password" class="form-control" name="password" required>
                             </div>
                         </div>
                     </div>
                     <div class="row">
                         <div class="col-md-6">
                             <div class="form-group">
                                 <label>Lokasi Kerja</label>
                                 <select class="form-control" name="lokasi_kerja" required>
                                     <option readonly>-- Pilih Lokasi Kerja --</option>
                                     <?php if ($lu != '') {
                                            foreach ($lu as $value) { ?>
                                     <option><?= $value['lokasi_unit'] ?></option>
                                     <?php }
                                        } ?>
                                 </select>
                             </div>
                         </div>
                         <div class="col-md-6">
                             <div class="form-group">
                                 <label>Status</label>
                                 <?php
                                    $status = array('' => '- Pilih -', 'Aktif' => 'Aktif', 'Tidak Aktif' => 'Tidak Aktif');
                                    echo form_dropdown(
                                        'status_user',
                                        $status,
                                        set_value('status'),
                                        form_error('status') == true ? "class='form-control is-invalid' required" : "class='form-control' required"
                                    ); ?>
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