<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mt-3 mb-3">
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
                            <?php echo
                            form_open_multipart(
                                'pemakai/proseseditpengajuanservisperalatan?id=' . $rp['id_pengajuan'] . '&id_alat=' . $rp['id_alat'],
                                'class="form-horizontal"'
                            );
                            ?>
                            <!-- <div class="modal-content"> -->
                            <div class="modal-header">
                                <!-- <h4 class="modal-title">Form Edit Riwayat Servis</h4> -->
                            </div>
                            <div class="modal-body">
                            <div class="row">
                             <div class="col-md-6">
                              <div class="form-group">
                                <label>Tanggal Pengajuan</label>
                                 <input type="text" class="form-control pilihtanggal" name="dari" value="<?=date("d-m-Y", strtotime($rp['tgl_pengajuan']))?>"required>
                              </div>
                             </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Tempat Servis</label>
                                        <input type="text" placeholder="Masukkan Tempat Servis" class="form-control"
                                            name="tempat_servis" value="<?= $rp['tempat_servis'] ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Keluhan</label>
                                        <textarea type="text" placeholder="Masukkan Keluhan Peralatan Yang Anda Gunakan"
                                            class="form-control" name="keluhan_peralatan"
                                            required><?php echo htmlspecialchars($rp['keluhan']) ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Servis</label>
                                        <textarea type="text" placeholder="Masukkan Servis Peralatan yang diinginkan"
                                            class="form-control" name="servis_peralatan"
                                            required><?php echo htmlspecialchars($rp['servis']) ?></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Lain - Lain</label>
                                        <textarea type="text" placeholder="" class="form-control"
                                            name="lain_lain_peralatan"><?php echo htmlspecialchars($rp['lain_lain']) ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                            <div class="modal-footer justify-content-end">
                                <button type="sumbit" class="btn btn-primary">Simpan</button>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
</div>