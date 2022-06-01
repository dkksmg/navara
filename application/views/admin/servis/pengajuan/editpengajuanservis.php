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
                                    <th><?= $rp['id_assets'] ?></th>
                                </tr>
                                <tr>
                                    <th>No. Polisi</th>
                                    <th>:</th>
                                    <th><?= strtoupper($rp['no_polisi']) ?></th>
                                </tr>
                                <tr>
                                    <th>Jenis</th>
                                    <th>:</th>
                                    <th><?= strtoupper($rp['jenis']) ?></th>
                                </tr>
                                <tr>
                                    <th>Merk</th>
                                    <th>:</th>
                                    <th><?= strtoupper($rp['merk']) ?></th>
                                </tr>
                                <tr>
                                    <th>Tipe</th>
                                    <th>:</th>
                                    <th><?= strtoupper($rp['tipe']) ?></th>
                                </tr>
                                <tr>
                                    <th>CC</th>
                                    <th>:</th>
                                    <th><?= strtoupper($rp['besar_cc']) ?> CC</th>
                                </tr>
                                <tr>
                                    <th>Bahan Bakar</th>
                                    <th>:</th>
                                    <th><?= strtoupper($rp['jenis_bb']) ?></th>
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
                            <?php echo
                            form_open_multipart(
                                'home/proseseditpengajuanservis?id=' . $rp['id_pengajuan'] . '&id_kend=' . $rp['id_kendaraan'],
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
                                            <label>Nama Bengkel</label>
                                            <input type="text" placeholder="Masukkan Bengkel Tujuan"
                                                class="form-control" name="nama_bengkel"
                                                value="<?php echo $rp['bengkel_tujuan'] ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Keluhan</label>
                                            <textarea type="text"
                                                placeholder="Masukkan Keluhan Kendaraan Yang Anda Gunakan"
                                                class="form-control" name="keluhan_kendaraan"
                                                required><?php echo htmlspecialchars($rp['keluhan']) ?></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Servis</label>
                                            <textarea type="text"
                                                placeholder="Masukkan Servis Kendaraan yang diinginkan"
                                                class="form-control" name="servis_kendaraan"
                                                required><?php echo htmlspecialchars($rp['service']) ?></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Lain - Lain</label>
                                            <textarea type="text" placeholder="" class="form-control"
                                                name="lain_lain_kendaraan"><?php echo htmlspecialchars($rp['lain_lain']) ?></textarea>
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