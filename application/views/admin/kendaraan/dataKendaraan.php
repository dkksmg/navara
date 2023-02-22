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
             <a href="<?= site_url('home/tambahKendaraanDinas') ?>" class="btn btn-sm btn-success">Tambah
               Data
               Kendaraan</a>
             <?php endif; ?>
           </div>
           <div class="card-body">
             <table class="table table-bordered table-striped" width="100%" height="auto" id="kendaraan">
               <thead>
                 <tr>
                   <th class="text-center" rowspan="2">No</th>
                   <th class="text-center" colspan="2">Aksi</th>
                   <th class="text-center" rowspan="2">ID Aset</th>
                   <th class="text-center" rowspan="2">Pemakai</th>
                   <th class="text-center" rowspan="2">Lokasi Unit</th>
                   <th class="text-center" rowspan="2">No. Polisi</th>
                   <th class="text-center" rowspan="2">Jenis</th>
                   <th class="text-center" rowspan="2">Merk</th>
                   <th class="text-center" rowspan="2">Tipe</th>
                   <th class="text-center" rowspan="2">Tahun Kendaraan</th>
                   <th class="text-center" rowspan="2">Jenis Bahan Bakar</th>
                   <th class="text-center" rowspan="2">Besar CC</th>
                   <th class="text-center" rowspan="2">Masa Berlaku STNK</th>
                   <th class="text-center" rowspan="2">No. STNK</th>
                   <th class="text-center" rowspan="2">No. Mesin</th>
                   <th class="text-center" rowspan="2">No. Rangka</th>
                 </tr>
                 <tr>
                   <th class="text-center"></th>
                   <th class="text-center"></th>
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