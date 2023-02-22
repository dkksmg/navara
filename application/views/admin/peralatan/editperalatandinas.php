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
         <?= $this->load->view('admin/template/menu_layout_peralatan', '', TRUE); ?>
       </div>
       <div class="col-lg-12">
         <div class="card">
           <div class="card-header" style="background-color:#4a2f3a;">
             <h3 style="font-weight:bold;color:white;"><?= $title ?> </h3>
           </div>
           <?php echo form_open('home/proseseditperalatandinas?id=' . $alat['id'], 'class="form-horizontal" enctype="multipart/form-data"') ?>
           <div class="card-body">
               <div class="row">
                 <div class="col-md-6">
                   <div class="form-group">
                     <label>ID Aset</label>
                     <input type="text" class="form-control" name="id_asset" value="<?= isset($alat) ? $alat['id_asset'] : ""; ?>" required readonly>
                   </div>
                 </div>
                 <div class="col-md-6">
                   <div class="form-group">
                     <label>Bidang</label>
                     <select class="form-control" name="bidang" required>
                      <!-- <option value="">Pilih</option>  -->
                      <?php $selected=$alat['bidang']; foreach($lokasi_unit as $lu){ if($selected==$lu['lokasi_unit']){ ?>
                            <option selected="<?= $selected ?>" value="<?=$lu['lokasi_unit'] ?>"><?=$lu['lokasi_unit']?></option>;
                       <?php } else{ ?>
                            <option value="<?=$lu['lokasi_unit']?>"><?=$lu['lokasi_unit']?></option>; 
                        <?php  }  } ?>
                     </select>
                   </div>
                 </div>
               </div>
               <div class="row">
                <div class="col-md-6">
                   <div class="form-group">
                     <label>Jenis</label>
                     <!-- <input type="text" class="form-control" name="jenis" value="<?//= isset($alat) ? $alat['jenis'] : ""; ?>" required> -->
                     <select class="form-control" name="jenis" required>
                     <?php $selected=$alat['jenis']; if($selected=="Komputer"){?> 
                     <option selected="Komputer" value="Komputer">Komputer</option>
                     <option value="Laptop">Laptop</option>
                     <?php } elseif($selected=="Laptop"){?>
                     <option selected="Laptop" value="Laptop">Laptop</option>
                     <option value="Komputer">Komputer</option>
                     <?php } ?> 
                    </select>
                   </div>
                 </div>
                 <div class="col-md-6">
                   <div class="form-group">
                     <label>Merk</label>
                     <input type="text" class="form-control" name="merk" value="<?= isset($alat) ? $alat['merk'] : ""; ?>" required>
                   </div>
                 </div>
                 <!-- <div class="col-md-6">
                   <div class="form-group">
                     <label>Tipe</label>
                     <input type="text" class="form-control" name="tipe" value="<?//= isset($alat) ? $alat['tipe'] : ""; ?>" required>
                   </div>
                 </div> -->
                 <!-- <div class="col-md-4">
                   <div class="form-group">
                     <label>Nama</label>
                     <input type="text" class="form-control" name="nama" value="<?//= isset($alat) ? $alat['nama'] : ""; ?>" required>
                   </div>
                 </div> -->

               </div>
               <div class="row">
                 <div class="col-md-4">
                   <div class="form-group">
                     <label>Tahun Perolehan</label>
                     <input type="text" class="form-control" name="tahun_perolehan" value="<?= isset($alat) ? $alat['tahun_perolehan'] : ""; ?>" required>
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
                     <input type="text" class="form-control pilihtanggal" name="garansi" placeholder="Tanggal Akhir Garansi" value="<?=isset($alat)? date("d-m-Y", strtotime($alat['garansi'])) : ""; ?>"required>
                   </div>
                 </div>
                 
               </div>
               <?//php if($alat['pemegang']!==null){ ?>
               <!-- <div class="col-md-12">
                 <div class="form-group">
                   <label>Pemegang</label>
                   <input type="text" class="form-control" name="pemegang" value="<?//= isset($alat) ? $alat['pemegang'] : ""; ?>" required>
                 </div>
               </div> -->
               <?//php } ?>
               <div class="row">
                <div class="col-md-4">
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <input type="hidden" class="form-control" name="foto_lama" value="<?= isset($alat) ? $alat['foto_garansi'] : ""; ?>" required>
                    <img width="100%" src="<?= base_url('assets/upload/foto_garansi_peralatan/' . $alat['foto_garansi'] . '') ?>"
                      data-toggle="modal" data-target="#notaModal1" alt="Foto Nota">
                  </div>
                </div>
               </div>
               <div class="row">
                 <div class="col-md-12">
                   <div class="form-group">
                     <label>Keterangan</label>
                     <textarea  type="text" class="form-control" name="keterangan"><?= isset($alat) ? $alat['keterangan'] : ""; ?></textarea>
                   </div>
                 </div>
              </div>
             </div>
           <div class="card-footer">
             <button type="submit" class="btn btn-primary">Edit</button>
           </div>
           <?php echo form_close(); ?>
         </div>
       </div>
     </div>

   </div>
   <!-- /.row -->
 </div><!-- /.container-fluid -->
 </div>
 <div class="modal fade" id="notaModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
     <div class="modal-dialog" role="document">
       <div class="modal-content">
         <div class="modal-header">
           <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
               aria-hidden="true">&times;</span></button>
         </div>
         <div class="modal-body">
           <center>
             <img src="<?= base_url('assets/upload/foto_garansi_peralatan/' . $alat['foto_garansi'] . '') ?>" alt="Foto Nota"
               class="img-responsive" width="100%" height="auto">
           </center>
         </div>
         <div class="modal-footer">
           <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
         </div>
       </div>
     </div>
   </div>