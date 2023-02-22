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
      <tr>
        <th>Pemakai</th>
        <th>:</th>
        <th colspan="4"><?= $pmk['name'] ?> <?=isset($pmk['nip_user'])? '('.$pmk['nip_user'].')':''; ?></th>
      </tr>
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
      <!-- <tr>
        <th>Tipe</th>
        <th>:</th>
        <th colspan="4"><//?= $alat['tipe'] ?></th>
      </tr> -->
      <!-- <tr>
        <th>Nama</th>
        <th>:</th>
        <th colspan="4"><?//= $alat['nama'] ?></th>
      </tr> -->
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
        <th><img width="30%" src="<?= base_url('assets/upload/foto_garansi_peralatan/' . $alat['foto_garansi'] . '') ?>" data-toggle="modal" data-target="#notaModaldt" alt="Foto Garansi"></th>
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
          <th style="width:20%">Rp. <?= isset($pagu) ? number_format($pagu['pagu_awal'], 2, ',', '.') : 0 ?></th>
        
          <th style="width:25%">Pagu Peralatan Tahun <?= date('Y')-1 ?></th>
          <th style="width:5%">:</th>
          <th style="width:20%">Rp. <?= isset($pagu2) ? number_format($pagu2['pagu_awal'], 2, ',', '.') : 0 ?></th>
        
      </tr>
      <?php
      // if (isset($pagu)) {
        // $terpakai = $pagu['total_biaya_pajak'] + $pagu['total_biaya_servis'] + $pagu['total_biaya_bbm'];
        // $sisa = $pagu['pagu_awal'] - $terpakai;

        // $terpakai2 = $pagu2['total_biaya_pajak'] + $pagu2['total_biaya_servis'] + $pagu2['total_biaya_bbm'];
        // $sisa2 = $pagu2['pagu_awal'] - $terpakai2;

      // }
      ?>
      <tr>
        <th>Pagu Terpakai</th>
        <th>:</th>
        <th>Rp. <?= isset($terpakai) ? number_format($tot_terpakai1, 2, ',', '.') : 0 ?></th>
        <!-- <th>Rp. <?//= isset($terpakai) ? number_format($terpakai, 2, ',', '.') : 0 ?></th> -->

        <th>Pagu Terpakai</th>
        <th>:</th>
        <th>Rp. <?= isset($terpakai2) ? number_format($tot_terpakai2, 2, ',', '.') : 0 ?></th>
      </tr>
      <tr>
        <th>Sisa Pagu</th>
        <th>:</th>
        <th>Rp. <?= isset($sisa1) ? number_format($sisa1, 2, ',', '.') : 0 ?></th>
        <!-- <th>Rp. <?//= isset($sisa) ? number_format($sisa, 2, ',', '.') : 0 ?></th>
 -->
        <th>Sisa Pagu</th>
        <th>:</th>
        <th>Rp. <?= isset($sisa2) ? number_format($sisa2, 2, ',', '.') : 0 ?></th>
      </tr>
    </table>
  </div>
</div>
<div class="modal fade" id="notaModaldt" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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