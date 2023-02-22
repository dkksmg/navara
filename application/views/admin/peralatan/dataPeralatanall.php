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
             <?php if ($this->session->userdata('role') == 'Superadmin') : ?>
             <a href="<?= site_url('home/tambahPeralatanDinasall') ?>" class="btn btn-sm btn-success">Tambah
               Data
               Peralatan</a>
             <?php endif; ?>
           </div>
           <div class="card-body">
             <table class="table table-bordered table-striped" width="100%" height="auto" id="peralatan">
               <thead>
                 <tr>
                   <th class="text-center" rowspan="2">No</th>
                   <th class="text-center" colspan="2">Aksi</th>
                   <th class="text-center" rowspan="2">ID Aset</th>
                   <th class="text-center" rowspan="2">Bidang</th>
                   <th class="text-center" rowspan="2">Jenis</th>
                   <th class="text-center" rowspan="2">Merk</th>
                   <!-- <th class="text-center" rowspan="2">Tipe</th> -->
                   <!-- <th class="text-center" rowspan="2">Nama</th> -->
                   <th class="text-center" rowspan="2">Tahun Perolehan</th>
                   <!-- <th class="text-center" rowspan="2">Lokasi Unit</th> -->
                   <th class="text-center" rowspan="2">Foto Garansi</th>
                   <th class="text-center" rowspan="2">Garansi</th>
                   <th class="text-center" rowspan="2">Keterangan</th>
                 </tr>
                 <tr>
                   <th></th>
                   <th></th>
                 </tr>
               </thead>
               <tbody>

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