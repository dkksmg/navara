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
                                 <th><?= strtoupper($kend['no_polisi']) ?></th>
                             </tr>
                             <tr>
                                 <th>Jenis</th>
                                 <th>:</th>
                                 <th><?= strtoupper($kend['jenis']) ?></th>
                             </tr>
                             <tr>
                                 <th>Merk</th>
                                 <th>:</th>
                                 <th><?= strtoupper($kend['merk']) ?></th>
                             </tr>
                             <tr>
                                 <th>Tipe</th>
                                 <th>:</th>
                                 <th><?= strtoupper($kend['tipe']) ?></th>
                             </tr>
                             <tr>
                                 <th>CC</th>
                                 <th>:</th>
                                 <th><?= strtoupper($kend['besar_cc']) ?> CC</th>
                             </tr>
                             <tr>
                                 <th>Bahan Bakar</th>
                                 <th>:</th>
                                 <th><?= strtoupper($kend['jenis_bb']) ?></th>
                             </tr>
                         </table>
                     </div>
                 </div>
             </div>
             <div class="col-lg-12">
                 <div class="card">
                     <div class="card-header" style="background-color:#4a2f3a;">
                         <h3 style="font-weight:bold;color:white;"><?= $title ?></h3>
                     </div>
                     <div class="card-body">
                         <?php echo form_open_multipart(
                                'home/proseseditbbm?id=' . ($rbbm['id_bbm']) . '&idkend=' . ($kend['idk']),
                                'class="form-horizontal"'
                            ) ?>
                         <?php
                            echo form_hidden('tipe', ($kend['tipe']));
                            echo form_hidden('no_pol', ($kend['no_polisi']));
                            echo form_hidden('old_struk', ($rbbm['struk_bbm'])) ?>
                         <div class="row">
                             <div class="col-md-6">
                                 <div class="form-group">
                                     <label>Tanggal</label>
                                     <input type="text" class="form-control pilihtanggal" name="tgl_bbm"
                                         value="<?= date('d-m-Y', strtotime($rbbm['tgl_pencatatan'])) ?>" required>
                                 </div>
                             </div>
                             <div class="col-md-6">
                                 <div class="form-group">
                                     <label>Total Biaya BBM</label>
                                     <input type="number" class="form-control" name="harga_bbm" required
                                         placeholder="Masukkan Total Biaya BBM" value="<?= $rbbm['total_bbm'] ?>">
                                 </div>
                             </div>
                             <div class="col-md-6">
                                 <div class="form-group">
                                     <label>Struk BBM</label>
                                     <input type="file" class="form-control" name="struk_bbm" accept="image/*"
                                         <?php if ($rbbm['struk_bbm'] == null) : ?> required <?php endif ?>>
                                 </div>
                             </div>
                             <div class="col-md-6">
                                 <div class="form-group">
                                     <label>Foto Struk BBM</label>
                                     <div class="card" style="width: 18rem;">
                                         <div class="gallery">
                                             <img class="card-img-top"
                                                 src="<?= base_url('assets/upload/struk_bbm/' . $rbbm['struk_bbm']) ?>"
                                                 alt="Foto Struk BBM" data-toggle="modal" width="30%"
                                                 data-target="#strukModal">
                                         </div>
                                     </div>

                                 </div>
                             </div>
                         </div>
                     </div>
                     <div class="modal-footer justify-content-end">
                         <button type="sumbit" class="btn btn-primary">Simpan</button>

                     </div>
                     <?php form_close() ?>
                 </div>
             </div>
         </div>
         <!-- /.row -->
     </div><!-- /.container-fluid -->
 </div>
 <!-- /.content -->

 <center>
     <div class="modal fade" id="strukModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
         <div class="modal-dialog" role="document">
             <div class="modal-content">
                 <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                             aria-hidden="true">&times;</span></button>
                 </div>
                 <div class="modal-body">
                     <center>
                         <img src="<?= base_url('assets/upload/struk_bbm/' . $rbbm['struk_bbm'] . '') ?>"
                             alt="Foto Struk BBM" class="img-responsive" width="70%" height="auto">
                     </center>
                 </div>
                 <div class="modal-footer">
                     <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                 </div>
             </div>
         </div>
     </div>
 </center>