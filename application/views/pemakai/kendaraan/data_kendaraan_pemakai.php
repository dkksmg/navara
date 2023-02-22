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
          if (!empty($kends)) :
            $no = 1;
            foreach ($kends as $kend) :
          ?>
          <div class="card">
            <div class="card-header" style="background-color:#4a2f3a;">
              <h3 style="font-weight:bold;color:white;">Data Kendaraan Dinas Anda Ke-<?= $no ?></h3>
            </div>
            <div class="card-body">
              <table class="table table-striped">
                <tr>
                  <th width="30%">ID Aset</th>
                  <th>:</th>
                  <th colspan="4"><?= $kend['id_assets'] ?></th>
                </tr>
                <tr>
                  <th>No. Polisi</th>
                  <th>:</th>
                  <th><?= strtoupper($kend['no_polisi']) ?></th>
                </tr>
                <tr>
                  <th>Jenis</th>
                  <th>:</th>
                  <th colspan="4"><?= strtoupper($kend['jenis']) ?></th>
                </tr>
                <tr>
                  <th>Merk</th>
                  <th>:</th>
                  <th><?= strtoupper($kend['merk']) ?></th>
                </tr>
                <tr>
                  <th>Tipe</th>
                  <th>:</th>
                  <th colspan="4"><?= strtoupper($kend['tipe']) ?></th>
                </tr>
                <tr>
                  <th>CC</th>
                  <th>:</th>
                  <th><?php if ($kend['besar_cc'] == '') :  ?> -
                    <?php else : ?><?= strtoupper($kend['besar_cc']) ?> CC <?php endif ?></th>
                </tr>
                <tr>
                  <th>Bahan Bakar</th>
                  <th>:</th>
                  <th colspan="4"><?= strtoupper($kend['jenis_bb']) ?></th>
                </tr>
                <tr>
                  <th>Masa Berlaku STNK</th>
                  <th>:</th>
                  <th><?= date('d-m-Y', strtotime($kend['masa_berlaku_stnk'])) ?></th>
                </tr>
                <tr>
                  <th>Tahun Perolehan</th>
                  <th>:</th>
                  <th colspan="4"><?= $kend['tahun_perolehan'] == '' ? '-' : $kend['tahun_perolehan'] ?></th>
                </tr>
                <tr>
                  <th>No STNK</th>
                  <th>:</th>
                  <th><?= $kend['no_stnk'] == '' ? '-' : $kend['no_stnk'] ?></th>
                </tr>
                <tr>
                  <th>No Rangka</th>
                  <th>:</th>
                  <th colspan="4"><?= $kend['no_rangka'] == '' ? '-' : $kend['no_rangka'] ?></th>
                </tr>
                <tr>
                  <th>No Mesin</th>
                  <th>:</th>
                  <th><?= $kend['no_mesin'] == '' ? '-' : $kend['no_mesin'] ?></th>
                </tr>
                <tr>
                  <th>Lokasi Unit</th>
                  <th>:</th>
                  <th colspan="4"><?= strtoupper($kend['lokasi_unit']) ?></th>
                </tr>
                <tr>
                  <th>Pagu Kendaraan Tahun <?= date('Y') ?></th>
                  <th>:</th>
                  <th>Rp. <?= isset($kend) ? number_format($kend['pagu_awal'], 2, ',', '.') : 0 ?>
                    <?php if ($kend['pagu_awal'] == 0 or $kend['pagu_awal'] == '') : ?>
                    <i style="margin-left:15px;color:red" class="fa-solid fa-circle-exclamation"
                      title="Pagu kendaraan dinas Anda tahun <?= date('Y') ?> masih kosong. Silakan hubungi Admin"></i>
                    <?php endif; ?>
                  </th>

                  <th>Pagu Kendaraan Tahun <?= date('Y')-1 ?></th>
                  <th>:</th>
                  <th>Rp. <?= isset($kends2) ? number_format($kends2[0]['pagu_awal'], 2, ',', '.') : 0 ?>
                    <?php if ($kends2[0]['pagu_awal'] == 0 or $kends2[0]['pagu_awal'] == '') : ?>
                    <i style="margin-left:15px;color:red" class="fa-solid fa-circle-exclamation"
                      title="Pagu kendaraan dinas Anda tahun <?= date('Y')-1 ?> masih kosong. Silakan hubungi Admin"></i>
                    <?php endif; ?>
                  </th>
                </tr>
                <?php
                    if (isset($kend)) {
                      $terpakai = $kend['total_biaya_pajak'] + $kend['total_biaya_servis'] + $kend['total_biaya_bbm'];
                      $sisa = $kend['pagu_awal'] - $terpakai;
                    }
                    if (isset($kends2)) {
                      $terpakai2 = $kends2[0]['total_biaya_pajak'] + $kends2[0]['total_biaya_servis'] + $kends2[0]['total_biaya_bbm'];
                      $sisa2 = $kends2[0]['pagu_awal'] - $terpakai2;
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
            <div class="card-footer">
              <a <?php if ($kend['pagu_awal'] == 0 or $kend['pagu_awal'] == null) : ?>onclick="disableBtn()"
                <?php else : ?>href="<?= site_url('pemakai/riwayatkondisi?id=' . $kend['idk'] . '') ?>" <?php endif ?>
                class="btn btn-primary jedatombol"
                title="Riwayat Kondisi <?= strtoupper($kend['tipe']) . ' ' . $kend['no_polisi'] ?>">Riwayat
                Kondisi</a>
              <a <?php if ($kend['pagu_awal'] == 0 or $kend['pagu_awal'] == null) : ?>onclick="disableBtn()"
                <?php else : ?> href="<?= site_url('pemakai/riwayatbbm?id=' . $kend['idk'] . '') ?>" <?php endif; ?>
                class="btn btn-secondary jedatombol"
                title="Riwayat BBM <?= strtoupper($kend['tipe']) . ' ' . $kend['no_polisi'] ?>">Riwayat
                BBM</a>
              <a <?php if ($kend['pagu_awal'] == 0 or $kend['pagu_awal'] == null) : ?>onclick="disableBtn()"
                <?php else : ?> href="<?= site_url('pemakai/riwayatpajak?id=' . $kend['idk'] . '') ?>" <?php endif ?>
                class="btn btn-danger jedatombol"
                title="Riwayat Pajak <?= strtoupper($kend['tipe']) . ' ' . $kend['no_polisi'] ?>">Riwayat
                Pajak</a>
              <a <?php if ($kend['pagu_awal'] == 0 or $kend['pagu_awal'] == null) : ?>onclick="disableBtn()"
                <?php else : ?> href="<?= site_url('pemakai/riwayatservis?id=' . $kend['idk'] . '') ?>" <?php endif; ?>
                class="btn btn-warning jedatombol"
                title="Riwayat Servis <?= strtoupper($kend['tipe']) . ' ' . $kend['no_polisi'] ?>">Riwayat
                Servis</a>
              <a <?php if ($kend['pagu_awal'] == 0 or $kend['pagu_awal'] == null) : ?>onclick="disableBtn()"
                <?php else : ?> href="<?= site_url('pemakai/pengajuanservis?id=' . $kend['idk']) ?>" <?php endif; ?>
                class="btn btn-success jedatombol"
                title="Pengajuan Servis <?= strtoupper($kend['tipe']) . ' ' . $kend['no_polisi'] ?>">Pengajuan
                Servis</a>
            </div>
          </div>
          <?php
              $no++;
            endforeach;  ?>
          <?php else : ?>
          <div class="card">
            <div class="card-header" style="background-color:#4a2f3a;">
              <h3 style="font-weight:bold;color:white;">Data Kendaraan Dinas Anda</h3>
            </div>
            <div class="card-body">
              <h5 class="text-center">Anda Belum Memiliki Kendaraan Aktif</h5>
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