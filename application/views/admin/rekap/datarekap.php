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
                         <h3 style="font-weight:bold;color:white;"><?= $title ?></h3>
                     </div>
                     <div class="card-header">
                         <form>
                             <div class="row">
                                 <div class="col-md-6">
                                     <div class="form-group">
                                         <label>Periode</label>
                                         <input type="text" class="form-control pilihtanggal" name="dari"
                                             value="<?= isset($dari) ? date('d-m-Y', strtotime($dari)) : date('d-m-Y'); ?>"
                                             required>
                                     </div>
                                 </div>
                                 <div class="col-md-6">
                                     <div class="form-group">
                                         <label>S/D</label>
                                         <input type="text" class="form-control pilihtanggal" name="sampai"
                                             value="<?= isset($sampai) ? date('d-m-Y', strtotime($sampai)) : date('d-m-Y'); ?>"
                                             required>
                                     </div>
                                 </div>
                             </div>
                             <div class="row">
                                 <div class="col-md-3">
                                     <button class="btn btn-sm btn-info">Cari</button>
                                 </div>
                             </div>
                         </form>
                     </div>
                     <div class="card-body">
                         <table class="table table-bordered table-striped example" width="100%">
                             <thead>
                                 <tr>
                                     <th class="text-center">No</th>
                                     <th class="text-center">Total Kendaraan</th>
                                     <th class="text-center">Kondisi Baik</th>
                                     <th class="text-center">Kondisi Rusak Ringan</th>
                                     <th class="text-center">Kondisi Rusak Sedang</th>
                                     <th class="text-center">Kondisi Rusak Berat</th>
                                 </tr>
                             </thead>
                             <tbody>
                                 <?php $no = 1;
                                    if (isset($rekap) && $rekap != '') {
                                        foreach ($rekap as $key => $value) { ?>
                                 <tr>
                                     <td class="text-center"><?= $no++; ?></td>
                                     <td class="text-center"><?= $value['jml'] ?></td>
                                     <td class="text-center"><?= $value['baik'] ?></td>
                                     <td class="text-center"><?= $value['ringan'] ?></td>
                                     <td class="text-center"><?= $value['sedang'] ?></td>
                                     <td class="text-center"><?= $value['berat'] ?></td>
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