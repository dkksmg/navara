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
                 <div class="card">
                     <div class="card-header" style="background-color:#4a2f3a;">
                         <h3 style="font-weight:bold;color:white;">Data Kendaraan Dinas</h3>
                     </div>
                     <div class="card-body">
                         <table class="table table-bordered table-striped example" width="100%">
                             <thead>
                                 <tr>
                                     <th>No</th>
                                     <th width="150px">Aksi</th>
                                     <th>ID ASSETS</th>
                                     <th>No. Polisi</th>
                                     <th>Jenis</th>
                                     <th>Merk</th>
                                     <th>Tipe</th>
                                 </tr>
                             </thead>
                             <tbody>
                                 <?php $no = 1;
                                    if ($kendaraan != '') {
                                        foreach ($kendaraan as $kend) { ?>
                                 <tr>
                                     <td><?= $no++; ?></td>
                                     <td>
                                         <a href="<?= site_url('servis/detail_servis?id=' . $kend['idk'] . '') ?>"
                                             class="btn btn-sm btn-warning jedatombol">Detail Servis</a>
                                     </td>
                                     <td><?= $kend['id_assets'] ?></td>
                                     <td><?= $kend['no_polisi'] ?></td>
                                     <td><?= $kend['jenis'] ?></td>
                                     <td><?= $kend['merk'] ?></td>
                                     <td><?= $kend['tipe'] ?></td>
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