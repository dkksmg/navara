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
                         <!-- <a href="<?= site_url('home/tambahKendaraanDinas') ?>" class="btn btn-sm btn-success">Tambah
                             Kendaraan</a> -->
                     </div>
                     <div class="card-body">
                         <table class="table table-bordered table-striped example width=" 100%" height="auto">
                             <thead>
                                 <tr>
                                     <th>No</th>
                                     <th>ID ASSETS</th>
                                     <th>Pemakai</th>
                                     <th>Lokasi Unit</th>
                                     <th>No. Polisi</th>
                                     <th>Jenis</th>
                                     <th>Merk</th>
                                     <th>Tipe</th>
                                     <th>No. STNK</th>
                                     <th>Masa Berlaku STNK</th>
                                     <th>No. Mesin</th>
                                     <th>No. Rangka</th>
                                     <th>Tahun Motor</th>
                                     <th>Jenis Bahan Bakar</th>
                                     <th>Besar CC</th>
                                 </tr>
                             </thead>
                             <tbody>
                                 <?php $no = 1;
                                    if ($kendaraan != '') {
                                        foreach ($kendaraan as $kend) { ?>
                                 <tr>
                                     <td><?= $no++; ?></td>
                                     <td><?= $kend['id_assets'] ?></td>
                                     <td><?= $kend['nama_pemakai'] ?></td>
                                     <td><?= $kend['lokasi_unit'] ?></td>
                                     <td><?= $kend['no_polisi'] ?></td>
                                     <td><?= $kend['jenis'] ?></td>
                                     <td><?= $kend['merk'] ?></td>
                                     <td><?= $kend['tipe'] ?></td>
                                     <td><?= $kend['no_stnk'] ?></td>
                                     <td><?= $kend['masa_berlaku_stnk'] ?></td>
                                     <td><?= $kend['no_mesin'] ?></td>
                                     <td><?= $kend['no_rangka'] ?></td>
                                     <td><?= $kend['tahun_perolehan'] ?></td>
                                     <td><?= $kend['jenis_bb'] ?></td>
                                     <td><?= $kend['besar_cc'] ?></td>
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