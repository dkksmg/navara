<div class="card">
  <div class="card-header" style="background-color:#4a2f3a;">
    <h3 style="font-weight:bold;color:white;">Data Kendaraan Dinas</h3>
  </div>
  <div class="card-body">
    <table class="table table-striped">
      <tr>
        <th width="250px">ID Aset</th>
        <th width="20px">:</th>
        <th colspan="4"><?= $kend['id_assets'] ?></th>
      </tr>
      <tr>
        <th>Pemakai</th>
        <th>:</th>
        <th colspan="4"><?php if (empty($pmk['name'])) : ?>
          -
          <?php else : ?>
          <?php if (empty($pmk['nip_user'])) : ?>
          <?= strtoupper($pmk['name'] . ' ( - )') ?>
          <?php else : ?>
          <?= strtoupper($pmk['name'] . ' (' . $pmk['nip_user'] . ')') ?>
          <?php endif ?>
          <?php endif ?>
        </th>
      </tr>
      <tr>
        <th>No. Polisi</th>
        <th>:</th>
        <th colspan="4"><?= strtoupper($kend['no_polisi']) ?></th>
      </tr>
      <tr>
        <th>Jenis</th>
        <th>:</th>
        <th colspan="4"><?= strtoupper($kend['jenis']) ?></th>
      </tr>
      <tr>
        <th>Merk</th>
        <th>:</th>
        <th colspan="4"><?= strtoupper($kend['merk']) ?></th>
      </tr>
      <tr>
        <th>Tipe</th>
        <th>:</th>
        <th colspan="4"><?= strtoupper($kend['tipe']) ?></th>
      </tr>
      <tr>
        <th>CC</th>
        <th>:</th>
        <th colspan="4"><?php if ($kend['besar_cc'] == '') :  ?> -
          <?php else : ?><?= strtoupper($kend['besar_cc']) ?> CC <?php endif ?></th>
      </tr>
      <tr>
        <th>Bahan Bakar</th>
        <th>:</th>
        <th colspan="4"><?= strtoupper($kend['jenis_bb']) ?></th>
      </tr>
      <tr style="width:100%">
        
          <th style="width:25%">Pagu Kendaraan Tahun <?= date('Y') ?></th>
          <th style="width:5%">:</th>
          <th style="width:20%">Rp. <?= isset($pagu) ? number_format($pagu['pagu_awal'], 2, ',', '.') : 0 ?></th>
        
          <th style="width:25%">Pagu Kendaraan Tahun <?= date('Y')-1 ?></th>
          <th style="width:5%">:</th>
          <th style="width:20%">Rp. <?= isset($pagu2) ? number_format($pagu2['pagu_awal'], 2, ',', '.') : 0 ?></th>
        
      </tr>
      <?php
      if (isset($pagu)) {
        $terpakai = $pagu['total_biaya_pajak'] + $pagu['total_biaya_servis'] + $pagu['total_biaya_bbm'];
        $sisa = $pagu['pagu_awal'] - $terpakai;
      }
      if (isset($pagu2)) {
        $terpakai2 = $pagu2['total_biaya_pajak'] + $pagu2['total_biaya_servis'] + $pagu2['total_biaya_bbm'];
        $sisa2 = $pagu2['pagu_awal'] - $terpakai2;
      }
      ?>
      <tr>
        <th>Pagu Terpakai</th>
        <th>:</th>
        <th>Rp. <?= isset($terpakai) ? number_format($terpakai, 2, ',', '.') : 0 ?></th>

        <th>Pagu Terpakai</th>
        <th>:</th>
        <th>Rp. <?= isset($terpakai2) ? number_format($terpakai2, 2, ',', '.') : 0 ?></th>
      </tr>
      <tr>
        <th>Sisa Pagu</th>
        <th>:</th>
        <th>Rp. <?= isset($sisa) ? number_format($sisa, 2, ',', '.') : 0 ?></th>

        <th>Sisa Pagu</th>
        <th>:</th>
        <th>Rp. <?= isset($sisa2) ? number_format($sisa2, 2, ',', '.') : 0 ?></th>
      </tr>
    </table>
  </div>
</div>