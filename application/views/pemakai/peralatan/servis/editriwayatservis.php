<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <!-- <h1><?= $title ?></h1> -->
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header" style="background-color:#4a2f3a;">
                            <h3 style="font-weight:bold;color:white;">Data Peralatan Dinas</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped">
                <tr>
                  <th width="250px">ID Aset</th>
                  <th width="20px">:</th>
                  <th colspan="4"><?= $alat['id_asset'] ?></th>
                </tr>
                <tr>
                  <!-- <th>Lokasi Unit</th> -->
                  <th>Bidang</th>
                  <th>:</th>
                  <th colspan="4"><?= $alat['bidang'] ?></th>
                </tr>
                <?//php if($alat['pemegang']!=null) {?>
                <!-- <tr>
                  <th>Pemakai</th>
                  <th>:</th>
                  <th colspan="4"><?//= $pmk['name'] ?></th>
                </tr> -->
                <?//php } ?>
                <tr>
                  <th>Jenis</th>
                  <th>:</th>
                  <th colspan="4"><?= $alat['jenis'] ?></th>
                </tr>
                <tr>
                  <th>Merk</th>
                  <th>:</th>
                  <th colspan="4"><?= $alat['merk'] ?></th>
                </tr>
                <tr>
                  <th>Tahun Perolehan</th>
                  <th>:</th>
                  <th colspan="4"><?= $alat['tahun_perolehan']; ?></th>
                </tr>
                <tr>
                  <th>Garansi</th>
                  <th>:</th>
                  <?php
                    $time=$alat['garansi'];
                    $year=substr($time, 0, 4);
                    $month=substr($time, 5, 2);
                    $day=substr($time, 8, 2);
                  ?>
                  <!-- <th colspan="4"><?//= $day.'/'.$month.'/'.$year ?></th> -->
                  <th><?= $day.'/'.$month.'/'.$year ?></th>
                  <th><img width="30%" src="<?= base_url('assets/upload/foto_garansi_peralatan/' . $alat['foto_garansi'] . '') ?>" data-toggle="modal" data-target="#garansiModal" alt="Foto Garansi"></th>
                  <th colspan="3"></th>
                </tr>
                <tr>
                  <th>Keterangan</th>
                  <th>:</th>
                  <th colspan="4"><?= $alat['keterangan'] ?></th>
                </tr>
                <tr style="width:100%">
                    <th style="width:25%">Pagu Peralatan Tahun <?= date('Y') ?></th>
                    <th style="width:5%">:</th>
                    <th style="width:20%">Rp. <?= isset($alat['pagu_awal']) ? number_format($alat['pagu_awal'], 2, ',', '.') : 0 ?></th>
                    <!-- <th style="width:20%">Rp. <?//= $pagu['pagu_awal'] ?></th> -->
                  
                    <th style="width:25%">Pagu Peralatan Tahun <?= date('Y')-1 ?></th>
                    <th style="width:5%">:</th>
                    <th style="width:20%">Rp. <?= isset($alat2['pagu_awal']) ? number_format($alat2['pagu_awal'], 2, ',', '.') : 0 ?></th>
                </tr>
                <tr>
                  <th>Pagu Terpakai</th>
                  <th>:</th>
                  <th>Rp. <?= isset($alat['total_biaya_servis']) ? number_format($alat['total_biaya_servis'], 2, ',', '.') : 0 ?></th>

                  <th>Pagu Terpakai</th>
                  <th>:</th>
                  <th>Rp. <?= isset($alat2['total_biaya_servis']) ? number_format($alat2['total_biaya_servis'], 2, ',', '.') : 0 ?></th>
                </tr>
                <tr>
                  <?php 
                  $alat['sisa_pagu']=$alat['pagu_awal']-$alat['total_biaya_servis'];
                  $alat2['sisa_pagu']=$alat2['pagu_awal']-$alat2['total_biaya_servis'];
                  ?>
                  <th>Sisa Pagu</th>
                  <th>:</th>
                  <th>Rp. <?= isset($alat['sisa_pagu']) ? number_format($alat['sisa_pagu'], 2, ',', '.') : 0 ?></th>

                  <th>Sisa Pagu</th>
                  <th>:</th>
                  <th>Rp. <?= isset($alat2['sisa_pagu']) ? number_format($alat2['sisa_pagu'], 2, ',', '.') : 0 ?></th>
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
                                'pemakai/proseseditservisperalatan?id=' . $servis['id_rs'] . '',
                                'class="form-horizontal"'
                            );
                            echo form_hidden('id_alat', $servis['id_alat']);
                            echo form_hidden('old_nota', $servis['foto_nota']);
                            ?>
                            <!-- <form method="post"
                                action="<?//= site_url('pemakai/proseseditservis?id=' . $servis['id_rs'] . '') ?>"
                                enctype="multipart/form-data"> -->
                            <!-- <div class="modal-content"> -->
                            <div class="modal-header">
                                <!-- <h4 class="modal-title">Form Edit Riwayat Servis</h4> -->
                            </div>
                            <div class="modal-body">
                               <div class="row">
                                 <div class="col-md-12">
                                   <div class="form-group">
                                     <label>Tanggal Service</label>
                                     <input type="text" class="form-control pilihtanggal" name="tgl" required value="<?= date('d-m-Y',strtotime($servis['tgl_servis']))?>">
                                   </div>
                                 </div>
                               </div>
                               <div class="row">
                                <div class="col-md-12">
                                   <div class="form-group">
                                     <label>Nama Tempat Service</label>
                                     <input type="text" class="form-control" name="tempat_servis" value="<?= $servis['tempat_servis']?>">
                                   </div>
                                 </div>
                               </div>
                               <div class="row">
                                 <div class="col-md-12">
                                   <div class="form-group">
                                     <label>Biaya</label>
                                     <input type="number" class="form-control" id="result" name="biaya" value="<?=$servis['biaya']?>">
                                   </div>
                                 </div>
                               </div>
                               <div class="row">
                                 <div class="col-md-12">
                                   <div class="form-group">
                                     <label>Foto Nota</label>
                                     <input type="file" class="form-control" name="nota" accept="image/*">
                                   </div>
                                 </div>
                               </div>
                               <div class="row">
                                <div class=col-md-12>
                                  <div class="form-group">
                                    <img src="<?= base_url('assets/upload/foto_nota/peralatan/' . $servis['foto_nota'] . '') ?>" alt="Foto Nota" class="img-responsive" width="20%" height="auto" data-toggle="modal" data-target="#notaModal">
                                  </div>
                                </div>
                               </div>
                               <div class="row">
                                 <div class="col-md-12">
                                   <div class="form-group">
                                     <label>Keterangan</label>
                                     <textarea type="text" class="form-control"
                                       name="keterangan"><?=$servis['ket_servis']?></textarea>
                                   </div>
                                 </div>
                               </div>
                               <div class="modal-footer justify-content-end">
                                    <button type="sumbit" class="btn btn-primary">Simpan</button>
                                </div>
                                <!-- </form> -->
                                <?php form_close() ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="modal fade" id="notaModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
         <div class="modal-dialog" role="document">
           <div class="modal-content">
             <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
             </div>
             <div class="modal-body">
               <center>
                 <img src="<?= base_url('assets/upload/foto_nota/peralatan/' . $servis['foto_nota'] . '') ?>" alt="Foto Nota"
                   class="img-responsive" width="70%" height="auto">
               </center>
             </div>
             <div class="modal-footer">
               <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
             </div>
           </div>
         </div>
       </div>
    </section>