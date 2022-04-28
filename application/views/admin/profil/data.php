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
                         <h3 style="font-weight:bold;color:white;"><?= $title ?></h3>
                     </div>
                     <div class="card-header">
                     </div>

                     <div class="card-body">
                         <div class="card-body box-profile">
                             <div class="text-center">
                                 <img class="profile-user-img img-fluid img-circle"
                                     src="<?php echo base_url(); ?>assets/logo/user.png" alt="User profile picture">
                             </div>

                             <h3 class="profile-username text-center"><?= $user['name'] ?></h3>

                             <p class="text-muted text-center">Lokasi Kerja : <?= $user['wilayah'] ?></p>

                             <ul class="list-group list-group-unbordered mb-3">
                                 <li class="list-group-item">
                                     <b>Username</b> <a class="float-right"><?= $user['username'] ?></a>
                                 </li>
                                 <li class="list-group-item">
                                     <b>Role</b> <a class="float-right"><?= $user['role'] ?></a>
                                 </li>
                             </ul>
                             <div class="d-flex justify-content-center">
                                 <div class="card-footer col-md-4">
                                     <?php echo anchor('profile/ubahdata/?id=' . $user['id'], '<b>Ubah Data</b>', [
                                            'class' => 'btn btn-primary btn-block ',
                                        ]); ?>
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