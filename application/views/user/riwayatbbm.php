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
                 <th>ID Aset</th>
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
             <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-xl">
               Tambah Riwayat BBM
             </button>
           </div>
           <div class="card-body">
             <table class="table table-bordered table-striped example" width="100%;">
               <thead>
                 <tr>
                   <th>No</th>
                   <th>Aksi</th>
                   <th>Tanggal</th>
                   <th>Total Harga BBM</th>
                 </tr>
               </thead>
               <tbody>
                 <?php $no = 1;
                  if ($rbbm != '') {
                    foreach ($rbbm as $value) { ?>
                     <tr>
                       <td><?= $no++; ?></td>
                       <td></td>
                       <td><?= $value['tgl_pencatatan'] ?></td>
                       <td>Rp <?= number_format($value['total_bbm'], 2, ',', '.'); ?></td>
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
     <form method="post" action="<?= site_url('pemakai/prosestambahbbm?id=' . $kend['idk'] . '') ?>" enctype="multipart/form-data">
       <div class="modal-content">
         <div class="modal-header">
           <h4 class="modal-title">Form Riwayat Pajak</h4>
           <button type="button" class="close" data-dismiss="modal" aria-label="Close">
             <span aria-hidden="true">&times;</span>
           </button>
         </div>
         <div class="modal-body">
           <div class="row">
             <div class="col-md-6">
               <div class="form-group">
                 <label>Tanggal</label>
                 <input type="text" class="form-control pilihtanggal" name="tgl_bbm" value="<?= date('d-m-Y') ?>">
               </div>
             </div>
             <div class="col-md-6">
               <div class="form-group">
                 <label>Total Harga BBM</label>
                 <input type="number" class="form-control" name="harga_bbm">
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