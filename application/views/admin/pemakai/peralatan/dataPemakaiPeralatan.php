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
                         <h3 style="font-weight:bold;color:white;"><?= $title ?></h3>
                     </div>
                     <div class="card-header">
                         <!-- <a href="<?//= site_url('home/tambahKendaraanDinas') ?>" class="btn btn-sm btn-success">Tambah
                             Kendaraan</a> -->
                     </div>
                     <div class="card-body">
                         <table class="table table-bordered table-striped example" width="100%" height="auto">
                             <thead>
                                 <tr>
                                     <th>No</th>
                                     <th>ID Aset</th>
                                     <th>Pemakai</th>
                                     <th>Bidang</th>
                                     <th>Jenis</th>
                                     <th>Merk</th>
                                     <th>Tahun Perolehan</th>
                                 </tr>
                             </thead>
                             <tbody>
                                 <?php $no = 1;
                                    if ($peralatan != '') {
                                        foreach ($peralatan as $alat) { ?>
                                 <tr>
                                     <td><?= $no++; ?></td>
                                     <td><?= $alat['id_asset'] ?></td>
                                     <td><?= $alat['name'] ?></td>
                                     <td><?= $alat['bidang'] ?></td>
                                     <td><?= $alat['jenis'] ?></td>
                                     <td><?= $alat['merk'] ?></td>
                                     <td><?= $alat['tahun_perolehan'] ?></td>
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