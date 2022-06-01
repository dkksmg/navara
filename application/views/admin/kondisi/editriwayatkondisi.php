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
                            <h3 style="font-weight:bold;color:white;">Data Kendaraan Dinas</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped">
                                <tr>
                                    <th width="30%">ID Aset</th>
                                    <th>:</th>
                                    <th><?= $value['id_assets'] ?></th>
                                </tr>
                                <tr>
                                    <th>No. Polisi</th>
                                    <th>:</th>
                                    <th><?= strtoupper($value['no_polisi']) ?></th>
                                </tr>
                                <tr>
                                    <th>Jenis</th>
                                    <th>:</th>
                                    <th><?= strtoupper($value['jenis']) ?></th>
                                </tr>
                                <tr>
                                    <th>Merk</th>
                                    <th>:</th>
                                    <th><?= strtoupper($value['merk']) ?></th>
                                </tr>
                                <tr>
                                    <th>Tipe</th>
                                    <th>:</th>
                                    <th><?= strtoupper($value['tipe']) ?></th>
                                </tr>
                                <tr>
                                    <th>CC</th>
                                    <th>:</th>
                                    <th><?= strtoupper($value['besar_cc']) ?> CC</th>
                                </tr>
                                <tr>
                                    <th>Bahan Bakar</th>
                                    <th>:</th>
                                    <th><?= strtoupper($value['jenis_bb']) ?></th>
                                </tr>
                                <tr>
                                    <th>Pagu Kendaraan Tahun <?= date('Y') ?></th>
                                    <th>:</th>
                                    <th>Rp. <?= isset($pagu) ? number_format($pagu['pagu_awal'], 2, ',', '.') : 0 ?>
                                    </th>
                                </tr>
                                <?php
                                if (isset($pagu)) {
                                    $terpakai = $pagu['total_biaya_pajak'] + $pagu['total_biaya_servis'] + $pagu['total_biaya_bbm'];
                                    $sisa = $pagu['pagu_awal'] - $terpakai;
                                }
                                ?>
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
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header" style="background-color:#4a2f3a;">
                            <h3 style="font-weight:bold;color:white;"><?= $title ?></h3>
                        </div>
                        <div class="card-body">
                            <?php echo form_open_multipart(
                                'home/proseseditkondisi?id=' . $value['id_rk'] . '',
                                'class="form-horizontal"'
                            );
                            echo form_hidden('id_kend', $value['id_kendaraan']);
                            echo form_hidden('tgl', $value['tgl_pencatatan']);
                            echo form_hidden('old_depan', $value['foto_tampak_depan']);
                            echo form_hidden('old_belakang', $value['foto_tampak_belakang']);
                            echo form_hidden('old_kiri', $value['foto_tampak_kiri']);
                            echo form_hidden('old_kanan', $value['foto_tampak_kanan']);
                            echo form_hidden('tipe', $value['tipe']);
                            echo form_hidden('no_pol', $value['no_polisi']);
                            ?>
                            <!-- <div class="modal-content"> -->
                            <div class="modal-header">
                                <!-- <h4 class="modal-title">Form Edit Riwayat Servis</h4> -->
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Keterangan Kondisi</label>
                                            <?php
                                            echo form_dropdown(
                                                'kondisi',
                                                [
                                                    '' => '- Pilih -',
                                                    'Baik' => 'Baik',
                                                    'Rusak Ringan' => 'Rusak Ringan',
                                                    'Rusak Sedang' => 'Rusak Sedang',
                                                    'Rusak Berat' => 'Rusat Berat',
                                                    // 'Utama Gigi' => 'Utama Gigi',
                                                ],
                                                set_value('kondisi', $value['kondisi']),
                                                "class='form-control' required"
                                            );

                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Foto Tampak Depan</label>
                                            <input type="file" class="form-control" name="depan"
                                                <?php if (empty($value['foto_tampak_depan'])) : ?>required
                                                <?php endif; ?> accept="image/*">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Foto Tampak Belakang</label>
                                            <input type="file" class="form-control" name="blkg"
                                                <?php if (empty($value['foto_tampak_belakang'])) : ?>required
                                                <?php endif; ?> accept="image/*">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Foto Tampak Kiri</label>
                                            <input type="file" class="form-control" name="kiri"
                                                <?php if (empty($value['foto_tampak_kiri'])) : ?>required
                                                <?php endif; ?> accept="image/*">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Foto Tampak Kanan</label>
                                            <input type="file" class="form-control" name="kanan"
                                                <?php if (empty($value['foto_tampak_kanan'])) : ?>required
                                                <?php endif; ?> accept="image/*">
                                        </div>
                                    </div>


                                </div>

                                <div class="container">
                                    <div class="row">
                                        <div class="col">
                                            <div class="card " style="width: 18rem;">
                                                <h5 class="card-title text-center mt-3 mb-3">Foto Tampak Depan</h5>
                                                <div class="gallery">
                                                    <img class="card-img-top"
                                                        src="<?= base_url('assets/upload/file_kendaraan/depan/' . $value['foto_tampak_depan']) ?>"
                                                        alt="Foto Servis">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="card " style="width: 18rem;">
                                                <h5 class="card-title text-center mt-3 mb-3">Foto Tampak Belakang</h5>
                                                <div class="gallery">
                                                    <img class="card-img-top"
                                                        src="<?= base_url('assets/upload/file_kendaraan/belakang/' . $value['foto_tampak_belakang']) ?>"
                                                        alt="Foto Servis">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="w-100"></div>
                                        <div class="col">
                                            <div class="card " style="width: 18rem;">
                                                <h5 class="card-title text-center mt-3 mb-3">Foto Tampak Kiri</h5>
                                                <div class="gallery">
                                                    <img class="card-img-top"
                                                        src="<?= base_url('assets/upload/file_kendaraan/kiri/' . $value['foto_tampak_kiri']) ?>"
                                                        alt="Foto Servis">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="card" style="width: 18rem;">
                                                <h5 class="card-title text-center mt-3 mb-3">Foto Tampak Kanan</h5>
                                                <div class="gallery">
                                                    <img class="card-img-top"
                                                        src="<?= base_url('assets/upload/file_kendaraan/kanan/' . $value['foto_tampak_kanan']) ?>"
                                                        alt="Foto Servis">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="container-foto">
                                            <div class="popup-kondisi">
                                                <i class="fas fa-times-circle" id="close"></i>
                                                <div class="imageShow">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer mt-5 justify-content-end">
                                    <button type="sumbit" class="btn btn-primary">Update</button>
                                </div>
                                <!-- </form> -->
                                <?php form_close() ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

    </section>
</div>