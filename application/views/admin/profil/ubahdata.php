 <!-- Content Header (Page header) -->
 <div class="content-header">
     <div class="container">
         <div class="row mb-2">
             <div class="col-sm-6">
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
                         <h3 style="font-weight:bold;color:white;"><?= $title ?></h3>
                     </div>
                     <div class="card-header">
                     </div>

                     <?php echo form_open('profile/prosesubahdata?id=' . $user['id'] . '', 'class="form-horizontal"'); ?>
                     <div class="card-body">
                         <div class="form-group row">
                             <label for="nama_user" class="col-sm-2 col-form-label">Nama </label>
                             <div class="col-sm-10">
                                 <input type="name" class="form-control" name="nama_user" value="<?= $user['name'] ?>" f
                                     placeholder="Nama" <?php if ($this->session->userdata('role') == 'Superadmin') : ?>
                                     <?php else : ?>disabled readonly<?php endif; ?>>
                             </div>
                         </div>
                         <div class="form-group row">
                             <label for="lokasi_kerja" class="col-sm-2 col-form-label">Lokasi Kerja</label>
                             <div class="col-sm-10">
                                 <select class="form-control" name="lokasi_kerja" disabled readonly>
                                     <option readonly>-- Pilih Lokasi Kerja --</option>
                                     <?php if ($lu != '') : ?>
                                     <?php foreach ($lu as $value) : ?>
                                     <option <?php if ($user['wilayah'] == $value['lokasi_unit']) : ?> selected
                                         <?php endif ?>>
                                         <?= $value['lokasi_unit'] ?></option>
                                     <?php endforeach;
                                        endif; ?>
                                 </select>
                             </div>
                         </div>
                         <div class="form-group row">
                             <label for="nip_user" class="col-sm-2 col-form-label">Username</label>
                             <div class="col-sm-10">
                                 <input type="username"
                                     class="form-control <?php if (form_error('username') == true) : ?>is-invalid <?php endif ?>"
                                     name="username" value="<?= set_value('username', $user['username']) ?>"
                                     placeholder="Username" required>
                                 <?= form_error('username', '<small class="text-danger pl-3">', '</small>') ?>
                             </div>
                         </div>
                         <div class="form-group row">
                             <label for="password" class="col-sm-2 col-form-label">Password</label>
                             <div class="col-sm-10">
                                 <input type="password"
                                     class="form-control <?php if (form_error('password') == true) : ?>is-invalid <?php endif ?>"
                                     name="password" placeholder="Password">
                                 <p style="color:red;">* Kosongkan jika tidak ingin mengganti Password</p>
                                 <?= form_error('password', '<small class="text-danger pl-3">', '</small>') ?>
                             </div>
                         </div>
                     </div>
                     <!-- /.card-body -->
                     <div class="card-footer">
                         <button type="submit" name="submit" class="btn btn-success">Simpan</button>
                         <?php echo anchor('profile', 'Kembali', ['class' => 'btn btn-warning']); ?>
                     </div>
                     <!-- /.card-footer -->
                     <?php echo form_close(); ?>
                 </div>
             </div>
         </div>
         <!-- /.row -->
     </div><!-- /.container-fluid -->
 </div>
 <!-- /.content -->