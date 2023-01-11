<div class="container">

<<<<<<< HEAD
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
=======
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
>>>>>>> 316cdd9c350e7cdeffa7b00461fea08d732b474c
                    if (!empty($kends)) :
                        $no = 1;
                        foreach ($kends as $kend) :
                    ?>
<<<<<<< HEAD
          <div class="card">
            <div class="card-header" style="background-color:#4a2f3a;">
              <h3 style="font-weight:bold;color:white;">Data Kendaraan Dinas Anda Ke-<?= $no ?></h3>
            </div>
            <div class="card-body">
              <table class="table table-striped">
                <tr>
                  <th width="30%">ID Aset</th>
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
                  <th><?php if ($kend['besar_cc'] == '') :  ?> -
                    <?php else : ?><?= strtoupper($kend['besar_cc']) ?> CC <?php endif ?></th>
                </tr>
                <tr>
                  <th>Bahan Bakar</th>
                  <th>:</th>
                  <th><?= strtoupper($kend['jenis_bb']) ?></th>
                </tr>
                <tr>
                  <th>Masa Berlaku STNK</th>
                  <th>:</th>
                  <th><?= date('d-m-Y', strtotime($kend['masa_berlaku_stnk'])) ?></th>
                </tr>
                <tr>
                  <th>Lokasi Unit</th>
                  <th>:</th>
                  <th><?= strtoupper($kend['lokasi_unit']) ?></th>
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
                </tr>
                <?php
=======
                    <div class="card">
                        <div class="card-header" style="background-color:#4a2f3a;">
                            <h3 style="font-weight:bold;color:white;">Data Kendaraan Dinas Anda Ke-<?= $no ?></h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped">
                                <tr>
                                    <th width="30%">ID Aset</th>
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
                                    <th><?php if ($kend['besar_cc'] == '') :  ?> -
                                        <?php else : ?><?= strtoupper($kend['besar_cc']) ?> CC <?php endif ?></th>
                                </tr>
                                <tr>
                                    <th>Bahan Bakar</th>
                                    <th>:</th>
                                    <th><?= strtoupper($kend['jenis_bb']) ?></th>
                                </tr>
                                <tr>
                                    <th>Masa Berlaku STNK</th>
                                    <th>:</th>
                                    <th><?= date('d-m-Y', strtotime($kend['masa_berlaku_stnk'])) ?></th>
                                </tr>
                                <tr>
                                    <th>Lokasi Unit</th>
                                    <th>:</th>
                                    <th><?= strtoupper($kend['lokasi_unit']) ?></th>
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
                                </tr>
                                <?php
>>>>>>> 316cdd9c350e7cdeffa7b00461fea08d732b474c
                                        if (isset($kend)) {
                                            $terpakai = $kend['total_biaya_pajak'] + $kend['total_biaya_servis'] + $kend['total_biaya_bbm'];
                                            $sisa = $kend['pagu_awal'] - $terpakai;
                                        }
                                        ?>
<<<<<<< HEAD
                <tr>
                  <th>Pagu Terpakai</th>
                  <th>:</th>
                  <th>Rp. <?= isset($terpakai) ? number_format($terpakai, 2, ',', '.') : 0 ?></th>
                </tr>
                <tr>
                  <th>Sisa Pagu</th>
                  <th>:</th>
                  <th>Rp. <?= isset($sisa) ? number_format($sisa, 2, ',', '.') : 0 ?></th>
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

=======
                                <tr>
                                    <th>Pagu Terpakai</th>
                                    <th>:</th>
                                    <th>Rp. <?= isset($terpakai) ? number_format($terpakai, 2, ',', '.') : 0 ?></th>
                                </tr>
                                <tr>
                                    <th>Sisa Pagu</th>
                                    <th>:</th>
                                    <th>Rp. <?= isset($sisa) ? number_format($sisa, 2, ',', '.') : 0 ?></th>
                                </tr>
                            </table>
                        </div>
                        <div class="card-footer">
                            <a <?php if ($kend['pagu_awal'] == 0 or $kend['pagu_awal'] == null) : ?>onclick="disableBtn()"
                                <?php else : ?>href="<?= site_url('pemakai/riwayatkondisi?id=' . $kend['idk'] . '') ?>"
                                <?php endif ?> class="btn btn-primary jedatombol"
                                title="Riwayat Kondisi <?= strtoupper($kend['tipe']) . ' ' . $kend['no_polisi'] ?>">Riwayat
                                Kondisi</a>
                            <a <?php if ($kend['pagu_awal'] == 0 or $kend['pagu_awal'] == null) : ?>onclick="disableBtn()"
                                <?php else : ?> href="<?= site_url('pemakai/riwayatbbm?id=' . $kend['idk'] . '') ?>"
                                <?php endif; ?> class="btn btn-secondary jedatombol"
                                title="Riwayat BBM <?= strtoupper($kend['tipe']) . ' ' . $kend['no_polisi'] ?>">Riwayat
                                BBM</a>
                            <a <?php if ($kend['pagu_awal'] == 0 or $kend['pagu_awal'] == null) : ?>onclick="disableBtn()"
                                <?php else : ?> href="<?= site_url('pemakai/riwayatpajak?id=' . $kend['idk'] . '') ?>"
                                <?php endif ?> class="btn btn-danger jedatombol"
                                title="Riwayat Pajak <?= strtoupper($kend['tipe']) . ' ' . $kend['no_polisi'] ?>">Riwayat
                                Pajak</a>
                            <a <?php if ($kend['pagu_awal'] == 0 or $kend['pagu_awal'] == null) : ?>onclick="disableBtn()"
                                <?php else : ?> href="<?= site_url('pemakai/riwayatservis?id=' . $kend['idk'] . '') ?>"
                                <?php endif; ?> class="btn btn-warning jedatombol"
                                title="Riwayat Servis <?= strtoupper($kend['tipe']) . ' ' . $kend['no_polisi'] ?>">Riwayat
                                Servis</a>
                            <a <?php if ($kend['pagu_awal'] == 0 or $kend['pagu_awal'] == null) : ?>onclick="disableBtn()"
                                <?php else : ?> href="<?= site_url('pemakai/pengajuanservis?id=' . $kend['idk']) ?>"
                                <?php endif; ?> class="btn btn-success jedatombol"
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

>>>>>>> 316cdd9c350e7cdeffa7b00461fea08d732b474c
<!-- /.modal-dialog -->
<!-- </div> -->