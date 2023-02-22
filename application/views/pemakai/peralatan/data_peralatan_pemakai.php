<div class="container">

  <!-- Content Header (Page header) -->
  <div class="content-header" id="body">
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
          <?php
          if (!empty($alats)) :
            $no = 1;
            $noo = 0;
            foreach ($alats as $alat) :
          ?>
          <div class="card">
            <div class="card-header" style="background-color:#4a2f3a;">
              <h3 style="font-weight:bold;color:white;">Data Peralatan Dinas ke <?=$no ?></h3>
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
                  <th><img width="30%" src="<?= base_url('assets/upload/foto_garansi_peralatan/' . $alat['foto_garansi'] . '') ?>" data-toggle="modal" data-target="#notaModaldt<?php echo $no?>" alt="Foto Garansi"></th>
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
                    <th style="width:20%">Rp. <?= isset($alats2[$noo]['pagu_awal']) ? number_format($alats2[$noo]['pagu_awal'], 2, ',', '.') : 0 ?></th>
                </tr>
                <tr>
                  <th>Pagu Terpakai</th>
                  <th>:</th>
                  <?//php $terpakai=$alats[$noo]['total_biaya_servis']; ?>
                  <th>Rp. <?= isset($alat['total_biaya_servis']) ? number_format($alat['total_biaya_servis'], 2, ',', '.') : 0 ?></th>

                  <th>Pagu Terpakai</th>
                  <th>:</th>
                  <?php $terpakai2=$alats2[$noo]['total_biaya_servis']; ?>
                  <th>Rp. <?= isset($terpakai2) ? number_format($terpakai2, 2, ',', '.') : 0 ?></th>
                </tr>
                <tr>
                  <th>Sisa Pagu</th>
                  <th>:</th>
                  <?//php $sisa=$alats[$noo]['pagu_awal']-$alats[$noo]['total_biaya_servis']; ?>
                  <?php $sisa=$alat['pagu_awal']-$alat['total_biaya_servis']; ?>
                  <th>Rp. <?= isset($sisa) ? number_format($sisa, 2, ',', '.') : 0 ?></th>

                  <th>Sisa Pagu</th>
                  <th>:</th>
                  <?php $sisa2=$alats2[$noo]['pagu_awal']-$alats2[$noo]['total_biaya_servis']; ?>
                  <th>Rp. <?= isset($sisa2) ? number_format($sisa2, 2, ',', '.') : 0 ?></th>
                </tr>
              </table>
            </div>
            <div class="card-footer">
              <a <?php if ($alat['pagu_awal'] == 0 or $alat['pagu_awal'] == null) : ?> disabled style="background-color: #555555"
              <?php else : ?>href="<?= site_url('pemakai/riwayatservisperalatan?id=' . $alat['id'] . '') ?>" <?php endif ?>
               class="btn btn-primary jedatombol"
               title="Riwayat Service <?= strtoupper($alat->merk) ?>">Riwayat Servis</a>
              <a <?php if ($alat['pagu_awal'] == 0 or $alat['pagu_awal'] == null) : ?> disabled style="background-color: #555555" 
                <?php else : ?>href="<?= site_url('pemakai/pengajuan_servis_peralatan?id=' . $alat['id'] . '') ?>" <?php endif ?>
                class="btn btn-success jedatombol"
                title="Pengajuan Servis <?= strtoupper($alat->merk) ?>">Pengajuan Servis</a>
            </div>
          </div>
          <div class="modal fade" id="notaModaldt<?php echo $no?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
             <div class="modal-dialog" role="document">
               <div class="modal-content">
                 <div class="modal-header">
                   <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                       aria-hidden="true">&times;</span></button>
                 </div>
                 <div class="modal-body">
                   <center>
                     <img src="<?= base_url('assets/upload/foto_garansi_peralatan/' . $alat['foto_garansi'] . '') ?>" alt="Foto Garansi"
                       class="img-responsive" width="70%" height="auto">
                   </center>
                 </div>
                 <div class="modal-footer">
                   <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                 </div>
               </div>
             </div>
          </div>
          <?php
              $no++;
              $noo++;
            endforeach;  ?>
          <?php else : ?>
          <div class="card">
            <div class="card-header" style="background-color:#4a2f3a;">
              <h3 style="font-weight:bold;color:white;">Data Peralatan Dinas Anda</h3>
            </div>
            <div class="card-body">
              <h5 class="text-center">Anda Belum Memiliki Peralatan Aktif Tahun <?= date('Y') ?></h5>
            </div>
            <div class="card-footer">
            </div>
          </div>
          <?php endif; ?>
        </div>
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
</div>
<!-- /.content -->

<!-- /.modal-dialog -->
<!-- </div> -->