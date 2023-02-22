 <!-- Content Header (Page header) -->
 <div class="content-header">
   <div class="container">
     <div class="row mb-2">
       <div class="col-sm-6">
         <!-- <h1 class="m-0"> <?= $title ?> <small>NAVARA</small></h1> -->
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
             <h3 style="font-weight:bold;color:white;"><?= $title ?> </h3>
           </div>
           <?php form_open('home/tambahPeralatanDinas', 'id="formpertanyaan"') ?>
           <form method="post" id="formpertanyaan" enctype="multipart/form-data">
             <div class="card-body">
               <div class="row">
                 <div class="col-md-6">
                   <div class="form-group">
                     <label>ID Aset</label>
                     <input type="text" class="form-control" name="id_aset"
                       value="<?= isset($alat) ? $alat['id_asset'] : id_aset_alat() ?>" disabled readonly>
                     <!-- <input type="text" class="form-control" name="id_asset" required> -->
                   </div>
                 </div>
                 <div class="col-md-6">
                   <div class="form-group">
                     <!-- <label>Lokasi Unit</label> -->
                     <label>Bidang</label>
                     <!-- <input type="text" class="form-control" name="lokasi_unit" required> -->
                     <select class="form-control" name="bidang" required>
                      <option value="">Pilih</option> 
                      <?php foreach($lokasi_unit as $lu){ ?>
                       <option value="<?php echo $lu['lokasi_unit']?>"><?php echo $lu['lokasi_unit']?></option> 
                      <?php } ?>
                     </select>
                   </div>
                 </div>
               </div>
               <div class="row">
                 <div class="col-md-6">
                   <div class="form-group">
                     <label>Jenis</label>
                     <!-- <input type="text" class="form-control" name="jenis" required> -->
                     <select class="form-control" name="jenis" required>
                      <option value="">Pilih</option> 
                      <option value="Komputer">Komputer</option>
                      <option value="Laptop">Laptop</option> 
                     </select>
                   </div>
                 </div>
                 <div class="col-md-6">
                   <div class="form-group">
                     <label>Merk</label>
                     <input type="text" class="form-control" name="merk" required>
                   </div>
                 </div>
                 <!-- <div class="col-md-4">
                   <div class="form-group">
                     <label>Tipe</label>
                     <input type="text" class="form-control" name="tipe" required>
                   </div>
                 </div> -->
                 <!-- <div class="col-md-4">
                   <div class="form-group">
                     <label>Nama</label>
                     <input type="text" class="form-control" name="nama" required>
                   </div>
                 </div> -->
               </div>
               <div class="row">
                 <div class="col-md-4">
                   <div class="form-group">
                     <label>Tahun Perolehan</label>
                     <input type="text" class="form-control" name="tahun_perolehan" required>
                   </div>
                 </div>
                 <div class="col-md-4">
                   <div class="form-group">
                     <label>Foto Garansi</label>
                     <input type="file" class="form-control" name="foto" accept="image/*">
                   </div>
                 </div>
                 <div class="col-md-4">
                   <div class="form-group">
                     <label>Garansi</label>
                     <input type="text" class="form-control pilihtanggal" name="garansi" placeholder="Tanggal Akhir Garansi" required>
                   </div>
                 </div>
               </div>
               <div class="row">
                 <div class="col-md-12">
                   <div class="form-group">
                     <label>Keterangan</label>
                     <textarea type="text" class="form-control" name="keterangan" placeholder="Keterangan Alat"></textarea>
                   </div>
                 </div>
               </div>
             </div>
               
             <div class="card-footer">
               <button type="sumbit" class="btn btn-primary">Tambah</button>
             </div>
           </form>
         </div>
       </div>
     </div>

   </div>
   <!-- /.row -->
 </div><!-- /.container-fluid -->
 </div>